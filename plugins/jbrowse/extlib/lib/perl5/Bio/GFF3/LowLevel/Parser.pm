package Bio::GFF3::LowLevel::Parser;
BEGIN {
  $Bio::GFF3::LowLevel::Parser::AUTHORITY = 'cpan:RBUELS';
}
{
  $Bio::GFF3::LowLevel::Parser::VERSION = '2.0';
}
# ABSTRACT: a fast, low-level gff3 parser

use strict;
use warnings;
use Carp;

use IO::Handle ();
use Scalar::Util ();

use List::MoreUtils ();

use Bio::GFF3::LowLevel ();



sub open {
    my $class = shift;
    return bless {

        filethings  => \@_,
        filehandles => [ map $class->_open($_), @_ ],

        # features that are ready to go out and be flushed
        item_buffer => [],

        # features that we have to keep on hand for now because they
        # might be referenced by something else
        under_construction_top_level => [],
        # index of the above by ID
        under_construction_by_id => {},

        # features that reference something we have not seen yet
        # structured as:
        # {  'some_id' => {
        #     'Parent' => [ orphans that have a Parent attr referencing it ],
        #     'Derives_from' => [ orphans that have a Derives_from attr referencing it ],
        # }
        under_construction_orphans => {},
    }, $class;
}
sub _open {
    my ( $class, $thing ) = @_;
    return $thing if ref $thing eq 'GLOB' || Scalar::Util::blessed( $thing ) && $thing->can('getline');
    CORE::open my $f, '<', $thing or croak "$! opening '$thing' for reading";
    return $f;
}


sub max_lookback {
    my ( $self, $count ) = @_;
    $self->{max_lookback} = $count
}


sub new {
    my $class = shift;
    require Bio::GFF3::LowLevel::Parser::1_0_backcompat;
    return Bio::GFF3::LowLevel::Parser::1_0_backcompat->new( @_ );
}


sub next_item {
    my ( $self ) = @_;

    # try to get more items if the buffer is empty
    $self->_buffer_items unless $self->_buffered_items_count;

    # return the next item if we have some
    return shift @{ $self->{item_buffer}} if $self->_buffered_items_count;

    # if we were not able to get any more items, return nothing
    return;
}

sub _buffer_item {
    push @{$_[0]->{item_buffer}}, $_[1];
}

sub _buffered_items_count {
    scalar @{ $_[0]->{item_buffer} }
}

## get and parse lines from the files(s) to add at least one item to
## the buffer
sub _buffer_items {
    my ( $self ) = @_;

    # File position buffer, needed for correct parsing of
    # implicit beginning of a FASTA section
    my $pos_buffer = 0;
    while( my $line = $self->_next_line ) {
        if( $line =~ /^ \s* [^#\s>] /x ) { #< feature line, most common case
            # Remember current position
            $pos_buffer = tell;

            my $f = Bio::GFF3::LowLevel::gff3_parse_feature( $line );
            $self->_buffer_feature( $f );
        }
        # directive or comment
        elsif( my ( $hashsigns, $contents ) = $line =~ /^ \s* (\#+) (.*) /x ) {
            # Remember current position
            $pos_buffer = tell;

            if( length $hashsigns == 3 ) { #< sync directive, all forward-references are resolved.
                $self->_buffer_all_under_construction_features;
            }
            elsif( length $hashsigns == 2 ) {
                my $directive = Bio::GFF3::LowLevel::gff3_parse_directive( $line );
                if( $directive->{directive} eq 'FASTA' ) {
                    $self->_buffer_all_under_construction_features;
                    $self->_buffer_item( { directive => 'FASTA', filehandle => shift @{$self->{filehandles} } });
                    shift @{$self->{filethings}};
                } else {
                    $self->_buffer_item( $directive );
                }
            }
            else {
                $contents =~ s/\s*$//;
                $self->_buffer_item( { comment => $contents } );
            }
        }
        elsif( $line =~ /^ \s* $/x ) {
            # blank line, do nothing

            # Remember current position
            $pos_buffer = tell;
        }
        elsif( $line =~ /^ \s* > /x ) {
            # implicit beginning of a FASTA section.  a very stupid
            # idea to include this in the format spec.  increases
            # implementation complexity by a lot.
            $self->_buffer_all_under_construction_features;

            # rewind to previous file position to include the fasta header
            my $fh = shift @{$self->{filehandles}};
            seek $fh, $pos_buffer, 0;

            $self->_buffer_item( { directive => 'FASTA', filehandle => $fh } );
            shift @{$self->{filethings}};

            # update file position
            $pos_buffer = tell;
        }
        else { # it's a parse error
            # Remember current position
            $pos_buffer = tell;

            chomp $line;
            $self->_parse_error("parse error.  Cannot parse '$line'.");
        }

        # buffer old features if we are starting to approach our mem limit
        $self->_ensure_lookback_limit;

        # return now if we were able to find some things to put in the
        # output buffer
        return if $self->_buffered_items_count;
    }

    # if we are out of lines, buffer all under-construction features
    $self->_buffer_all_under_construction_features;
}

sub _parse_error {
    my ( $self, $error ) = @_;
    croak "$self->{filethings}[0]:$.: $error";
}

## take all under-construction features and put them in the
## item_buffer to be output
sub _buffer_all_under_construction_features {
    my ( $self ) = @_;

    # since the under_construction_top_level buffer is likely to be
    # much larger than the item_buffer, we swap them and unshift the
    # existing buffer onto it to avoid a big copy.
    my $old_buffer = $self->{item_buffer};
    $self->{item_buffer} = $self->{under_construction_top_level};
    unshift @{$self->{item_buffer}}, @$old_buffer;
    undef $old_buffer;

    $self->{under_construction_top_level} = [];
    $self->{under_construction_by_id} = {};
    $self->{completed_references} = {};

    # if we have any orphans hanging around still, this is a problem. die with a parse error
    if( grep %$_, values %{$self->{under_construction_orphans}} ) {
        die <<EOM.$self->_unresolved_references_report;

GFF3 parse error: some features reference other features that do not exist in the file (or in the same '###' scope).  A list of them:
EOM
    }
}

sub _ensure_lookback_limit {
    my ( $self ) = @_;

    return unless defined $self->{max_lookback};

    my $toplevel = $self->{under_construction_top_level};
    my $byid = $self->{under_construction_by_id};
    my $out_buffer = $self->{item_buffer};
    no warnings 'uninitialized';
    while( @$toplevel > $self->{max_lookback} ) {
        my $f = shift @$toplevel;
        delete $byid->{$_} for map @{$_->{attributes}{ID}}, @$f;
        push @$out_buffer, $f;
    }
}

# makes a string with a tabular report of all the currently unresolved
# references: Parent, Derives_from, etc.
sub _unresolved_references_report {
    my ( $self ) = @_;

    require IO::Handle;

    our $id;
    our $reference_string;

    my $report = '';
    CORE::open my $fh, '>', \$report;
$fh->print(<<'');
 ID                 |           Cannot Find
----------------------------------------------------------------------

    no strict 'subs';
    format UNRESOLVED_REFERENCES_REPORT =
@<<<<<<<<<<<<<<<<<< | @<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<
$id,                  $reference_string
.



    for my $refid ( keys %{$self->{under_construction_orphans}} ) {
        my $escaped_refid = Bio::GFF3::LowLevel::gff3_escape( $refid );
        my $references = $self->{under_construction_orphans}{$refid};
        for my $reftype ( keys %$references ) {
            my $references = $references->{$reftype};
            for my $feature (@$references) {
                for my $location ( @$feature ) {
                    $id = (($location->{attributes}||{})->{ID}||[])->[0]; #< avoid autovivification
                    $id = '(no id)' unless defined $id;
                    $reference_string = "$reftype=$escaped_refid";
                    $fh->format_write( Bio::GFF3::LowLevel::Parser::UNRESOLVED_REFERENCES_REPORT );
                }
            }
        }
    }
    return $report;
}


## get the next line from our file(s), returning nothing if we are out
## of lines and files
sub _next_line {
    no warnings;
    # fast code path for reading a line from the first filehandle,
    my $first_fh = $_[0]->{filehandles}[0];
    return <$first_fh> || do {
        # slower case where we are at the end, or need to change
        # filehandles
        my ( $self ) = @_;
        my $filehandles = $self->{filehandles};
        while ( @$filehandles ) {
            my $line = $filehandles->[0]->getline;
            return $line if $line;
            shift @$filehandles;
            shift @{$self->{filethings}};
        }
        return;
    };
}

my %container_attributes = ( Parent => 'child_features', Derives_from => 'derived_features' );
## do the right thing with a newly-parsed feature line
sub _buffer_feature {
    my ( $self, $feature_line ) = @_;

    $feature_line->{'child_features'}   = [];
    $feature_line->{'derived_features'} = [];

    # NOTE: a feature is an arrayref of one or more feature lines.
    my $ids     = $feature_line->{attributes}{ID}     || [];
    my $parents = $feature_line->{attributes}{Parent} || [];
    my $derives = $feature_line->{attributes}{Derives_from} || [];

    if( !@$ids && !@$parents && !@$derives ) {
        # if it has no IDs and does not refer to anything, we can just
        # output it
        $self->_buffer_item( [ $feature_line ] );
        return;
    }

    my $feature;
    for my $id ( @$ids ) {
        if( my $existing = $self->{under_construction_by_id}{$id} ) {
            # another location of the same feature
            unless( $existing->[-1]->{type} eq $feature_line->{type} ) {
                $self->_parse_error("type ".$feature_line->{type}." is not the same as previous type ".$existing->[-1]->{type}." for ID '".$id."'");
            }
            push @$existing, $feature_line;
            $feature = $existing;
        }
        else {
            # haven't seen it yet
            $feature = [ $feature_line ];
            if( !@$parents && !@$derives ) {
                push @{ $self->{under_construction_top_level} }, $feature;
            }
            $self->{under_construction_by_id}{$id} = $feature;

            # see if we have anything buffered that refers to it
            $self->_resolve_references_to( $feature, $id );
        }
    }

    # try to resolve all its references
    $self->_resolve_references_from( $feature || [ $feature_line ], { Parent => $parents, Derives_from => $derives }, $ids );
}

sub _resolve_references_to {
    my ( $self, $feature, $id ) = @_;
    my $references = $self->{under_construction_orphans}{$id}
        or return;
    for my $attrname ( keys %$references ) {
        my $pname = $container_attributes{$attrname} || lc $attrname;
        for my $loc ( @$feature ) {
            push @{ $loc->{$pname} },
                  @{ delete $references->{$attrname} };
        }
    }
}
sub _resolve_references_from {
    my ( $self, $feature, $references, $ids ) = @_;
    # go through our references
    #  if we have the feature under construction, put this feature in the right place
    #  otherwise, put this feature in the right slot in the orphans

    for my $attrname ( keys %$references ) {
        my $pname;
        for my $to_id ( @{ $references->{ $attrname } } ) {
            if( my $other_feature = $self->{under_construction_by_id}{ $to_id } ) {
                $pname ||= $container_attributes{$attrname} || lc $attrname;
                unless( grep $self->{completed_references}{$_}{$attrname}{$to_id}++, @$ids ) {
                    for my $loc ( @$other_feature ) {
                        push @{ $loc->{ $pname } }, $feature;
                    }
                }
            }
            else {
                push @{ $self->{under_construction_orphans}{$to_id}{$attrname} ||= [] }, $feature;
            }
        }
    }
}


1;

__END__

=pod

=encoding utf-8

=head1 NAME

Bio::GFF3::LowLevel::Parser - a fast, low-level gff3 parser

=head1 SYNOPSIS

  my $p = Bio::GFF3::LowLevel::Parser->open( $file_or_fh );

  while( my $i = $p->next_item ) {

      if( ref $i eq 'ARRAY' ) {
          ## $i is an arrayref of feature lines that have the same ID,
          ## in the same format as returned by
          ## Bio::GFF3::LowLevel::gff3_parse_feature
          for my $f (@$i) {
             # for each location of this feature
             # do something with it
          }
      }
      elsif( $i->{directive} ) {
          if( $i->{directive} eq 'FASTA' ) {
              my $fasta_filehandle = $i->{filehandle};
              ## parse the FASTA in the filehandle with BioPerl or
              ## however you want.  or ignore it.
          }
          elsif( $i->{directive} eq 'gff-version' ) {
              print "it says it is GFF version $i->{value}\n";
          }
          elsif( $i->{directive} eq 'sequence-region' ) {
              print( "found a sequence-region, sequence $i->{seq_id},",
                     " from $i->{start} to $i->{end}\n"
                   );
          }
      }
      elsif( $i->{comment} ) {
          ## this is a comment in your GFF3 file, in case you want to do
          ## something with it.
          print "that comment said: '$i->{comment}'\n";
      }
      else {
          die 'this should never happen!';
      }

  }

=head1 DESCRIPTION

This is a fast, low-level parser for Generic Feature Format, version 3
(GFF3).  It is a low-level parser, it only returns dumb hashrefs.  It
B<does> reconstruct feature hierarchies, however, using features'
C<ID>, C<Parent>, and C<Derives_from> attributes, and it B<does> group
together lines with the same ID (i.e. features that have multiple
locations).

=head3 Features

Features are returned as arrayrefs containing one or more (never zero)
feature lines parsed in the same format as
L<Bio::GFF3::LowLevel/gff3_parse_feature>.  Each has some additional
keys for related features: C<child_features> and C<derived_features>,
each of which is a (possibly empty) arrayref of features
(i.e. arrayrefs) that refer to this one as a C<Parent> or claim that
they C<Derives_from> it.

Note that, to make code that uses this parser easier to write, B<all>
features have C<child_features> and C<derived_features> arrayrefs.
This means you don't have to check for the existence of these before
seeing if they have anything in them.

=head3 Directives

Directives are returned as hashrefs, in the same format as
L<Bio::GFF3::LowLevel/gff3_parse_directive>.

=head3 Comments

Comments are parsed into a hashref of the form:

  { comment => 'text of the comment, not including the hash mark(s) and ending newline' }

=head1 FUNCTIONS

=head2 open( $file_or_filehandle, ... )

Make a new parser object that will parse the GFF3 from all of the files
or filehandles that you give it, as if they were all a single stream.

=head2 max_lookback( $features )

Set a maximum number of features the parser will keep buffered in case
there are features later in the file referring to it.  By default,
there is no limit, with the parser instead relying on the presence of
'###' marks in the GFF3 file.

=head2 new

Returns a wrapped copy of this parser that returns data that is backward-compatible with what the 1.0 version of this parser returned.  Do not use in new code.

=head2 next_item()

Iterate through all of the items (features, directives, and comments)
in the file(s) given to the parser.  Features are arrayrefs of
hashrefs, and directives and comments are hashrefs.

=head1 AUTHOR

Robert Buels <rmb32@cornell.edu>

=head1 COPYRIGHT AND LICENSE

This software is copyright (c) 2012 by Robert Buels.

This is free software; you can redistribute it and/or modify it under
the same terms as the Perl 5 programming language system itself.

=cut
