package Bio::GFF3::Transform::SyncDirectives;
BEGIN {
  $Bio::GFF3::Transform::SyncDirectives::AUTHORITY = 'cpan:RBUELS';
}
{
  $Bio::GFF3::Transform::SyncDirectives::VERSION = '2.0';
}
# ABSTRACT: insert sync (###) directives into an existing GFF3 file.  WARNING: this module does not really work in the general case, read the DESCRIPTION section below.

use strict;
use warnings;

use File::Temp;
use File::ReadBackwards;

use Bio::GFF3::LowLevel ();

require Exporter;
our @ISA = ( 'Exporter' );
our @EXPORT_OK = ( 'gff3_add_sync_directives' );

sub gff3_add_sync_directives {
    my ( $out_fh, @files ) = @_;

    my $tempfile = File::Temp->new;

    my %open_parent_rels;
    for my $file ( @files ) {
        my $fh = File::ReadBackwards->new( $file );
        while ( my $line = $fh->readline ) {
            $tempfile->print( $line ) unless $line =~ /^###\s*$/;
            unless( $line =~ /^#/ ) {
                if ( my ( $attr ) = $line =~ / \t ([^\t]+) \s* $/x ) {
                    $attr = Bio::GFF3::LowLevel::gff3_parse_attributes( $attr );
                    if ( $attr->{Parent} ) {
                        for ( @{$attr->{Parent}} ) {
                            $open_parent_rels{ $_ } = 1;
                        }
                    }
                    if ( $attr->{ID} ) {
                        for ( @{$attr->{ID}} ) {
                            delete $open_parent_rels{ $_ };
                        }
                    }
                }
                $tempfile->print( "###\n" ) unless %open_parent_rels;
            }
        }
    }
    $tempfile->close;

    my $temp_backwards = File::ReadBackwards->new( "$tempfile" );
    # print up to and not including the first sync mark (to get rid of the
    # unnecessary first one
    while ( my $line = $temp_backwards->readline ) {
        last if $line =~ /^###\s*$/;
        print $out_fh $line;
    }
    while ( my $line = $temp_backwards->readline ) {
        print $out_fh $line;
    }
}

1;

__END__

=pod

=encoding utf-8

=head1 NAME

Bio::GFF3::Transform::SyncDirectives - insert sync (###) directives into an existing GFF3 file.  WARNING: this module does not really work in the general case, read the DESCRIPTION section below.

=head1 SYNOPSIS

    use Bio::GFF3::Transform::SyncDirectives 'gff3_add_sync_directives';

    my @input_files = ( 'input1.gff3', 'input2.gff3' );
    open my $output_fh, '>', 'myoutputfile.gff3';
    gff3_add_sync_directives( $output_fh, @input_files );

=head1 DESCRIPTIONS

This module, and its gff3_insert_sync_directives script, have some
important caveats: they do not support C<Derives_from>, they will not
work if any child features come in the file B<before> their parent
(which in practice is unusual), and they do not work when more than
one feature line has the same ID.  Perhaps in the future I may get
around to writing a more capable version of this.

=head1 FUNCTIONS

All functions below are EXPORT_OK.

=head2 gff3_add_sync_directives( $out_filehandle, @files )

Read GFF3 from the given files, add as many sync directives (###) as
possible, and print the resulting GFF3 to the given output filehandle.
Existing sync directives will not be preserved.

=head1 AUTHOR

Robert Buels <rmb32@cornell.edu>

=head1 COPYRIGHT AND LICENSE

This software is copyright (c) 2012 by Robert Buels.

This is free software; you can redistribute it and/or modify it under
the same terms as the Perl 5 programming language system itself.

=cut
