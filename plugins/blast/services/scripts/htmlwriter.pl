#!/usr/bin/perl
=head1 AUTHORS
Big thanks to  Alexie Papanicolaou giving me the impression to rewrite this piece of code.
Chanaka Mannapperuma
        1 Umeå University
        irusri@gmail.com
=cut
use strict; 
use warnings;
use DBI;
use Bio::Tools::GFF;
use File::Basename;
use Bio::SearchIO;
use Bio::SearchIO::Writer::HTMLResultWriter;
use Bio::SearchIO::Writer::TextResultWriter;
use Bio::SearchIO::Writer::GbrowseGFF;
use Bio::Graphics;
use Bio::FeatureIO;
use Bio::SeqFeature::Generic;


my $db_link    = "#%s";
my $outfile = "searschio.html";
my $infile = shift or die "Usage: $0 <BLAST-report-file>\n       HTML output is saved to $outfile\n";
			# make a gff3
			my $query_counter = 0;
			my $map_resultss;

			my $writer_html;
			if ($db_link) {
				$writer_html =
				  Bio::SearchIO::Writer::HTMLResultWriter->new( -nucleotide_url => $db_link,
																-protein_url    => $db_link, );
				$writer_html->id_parser( \&blast_id_parser );
			} else {
				$writer_html = Bio::SearchIO::Writer::HTMLResultWriter->new();
			}
			$writer_html->title( \&blast_title );
			$writer_html->introduction( \&blast_intro );
			$writer_html->start_report( \&blast_head );
			#$writer_html->algorithm_reference('t');
			my $writer_txt = Bio::SearchIO::Writer::TextResultWriter->new();
			my $in         = new Bio::SearchIO( -format => 'blastxml', -file => $infile );
			my $max;

			while ( my $result = $in->next_result ) {
				$max = $result->query_length()
				  if ( !$max || $max < $result->query_length() );
			}

			#rewind
			$in = new Bio::SearchIO( -format => 'blastxml', -file => $infile );
			my $graph =
			  Bio::Graphics::Panel->new(
										 -length    => $max,
										 -width     => 1000,
										 -pad_left  => 10,
										 -pad_right => 10,
			  );


			while ( my $result = $in->next_result ) {
				my $query    = $result->query_name();
				my $hitcount = $result->num_hits;

				#my @hit_array;
				$query_counter++;
				if ( $hitcount && $hitcount > 0 ) {

					my $out_html =
					  new Bio::SearchIO( -writer => $writer_html,
										 -file   => ">$infile.Query$query_counter.html" );
					my $out_txt =
					  new Bio::SearchIO( -writer => $writer_txt,
										 -file   => ">$infile.Query$query_counter.txt" );
					my $out_txt_whole =
					  new Bio::SearchIO( -writer => $writer_txt,
										 -file   => ">>$infile.all.txt" );
										 
					#graph starts in the result section and is built through the hits...
					my $full_length =
					  Bio::SeqFeature::Generic->new(
													 -start        => 1,
													 -end          => $result->query_length,
													 -display_name => $result->query_name,
					  );
					$graph->add_track(
									   $full_length,
									   -description => 'Top 50 hits',
									   -glyph   => 'arrow',
									   -tick    => 2,
									   -fgcolor => 'black',
									   -double  => 1,
									   -label   => 1,
					);
					my $track = $graph->add_track(
						-glyph       => 'graded_segments',
						-label       => 1,
						-feature_limit => 50,
						-connector   => 'dashed',
						-bgcolor     => 'blue',
						-font2color  => 'red',
						-sort_order  => 'low_score',
						-description => sub {
							my $feature = shift;
							return unless $feature->has_tag('description');
							my ($description) = $feature->each_tag_value('description');
							my $score = $feature->score;
							"E=$score; $description";
						},
					);
					my $i = int(0);
					while ( my $hit = $result->next_hit ) {
						my $hitname = $hit->name;
						$hitname =~ s/lcl\|//;
						my $description = $hit->description;
						$description =~ s/No definition line found//;
						if ( $hit && $i < 50 ) {
							$i++;
							my $feature =
							  Bio::SeqFeature::Generic->new(-score        => $hit->significance,
															-display_name => $hitname,
															-tag => { description => $description },
							  );
							while ( my $hsp = $hit->next_hsp ) {
								$feature->add_sub_SeqFeature( $hsp, 'EXPAND' );
							}
							$track->add_feature($feature);

						}
					}
					my $html_success = $out_html->write_result($result);
					$out_txt_whole->write_result($result);
					$out_txt->write_result($result);
				}
			}

			#START-Added on 12th November 2015
			my ( $url, $map, $mapname ) = $graph->image_and_map(
		                -root  => '',
		                -url   => '',
		                -target => '_blank',
		                -link  => 'jbrowse?loc=$name&tracks=UserBlastResults%2CDNA%2CGenes&data=data%2jbrowse_dataset_directory'
		            );
		           	$map_resultss=$map;
 

			open (WH, ">", "../tmp/$infile.txt");
			#print WH "<svg>";
			#print WH '<link type="text/css" rel="stylesheet" href="http://dictybase.org/assets/stylesheets/blast.css">';
			#print WH "\n<div id='blast-graph' class='block-container'>";
			#src="http://v22.popgenie.org/demo/geniecms/plugins/blast/tmp/'.$infile.'.png" 
			print WH '<img id="blast_image" style="overflow:hidden;top:0px"  usemap="#'. $mapname. '" border=1/>';
			print WH $map_resultss;			
			#print WH "</div>\n</svg>\n";
#			open (WH, ">", "../tmp/outfile.svg");
#			print WH "<html>";
#			print WH '<link type="text/css" rel="stylesheet" href="http://dictybase.org/assets/stylesheets/blast.css">';
#			print WH "<body>\n<div id='blast-graph' class='block-container'>";
#			print WH '<img style="overflow:hidden;top:0px" src="'.$infile.'.png"  usemap="#'. $mapname. '" border=1/>';
#			print WH $map_resultss;			
#			print WH "</div>\n</body>\n</html>\n";
			#END-Added on 12th November 2015

			open( GRAPH, ">$infile.png" );
			print GRAPH $graph->png if $graph; 
			close GRAPH;



sub algorithm_reference2(){
return "";
}
			
sub blast_head($) {
	return '
    <HTML>
      <HEAD> 
      <TITLE>BLAST results</TITLE>
      </HEAD>
      <!------------------------------------------------------------------->
      <!-- Generated by Bio::SearchIO::Writer::HTMLResultWriter          -->
      <!-- http://bioperl.org                                            -->
      <!------------------------------------------------------------------->
      <BODY BGCOLOR="WHITE">
    ';
}

sub blast_title($) {
	my $data = shift;
	my $alg  = $data->{'_algorithm_version'};
	return "<b>$alg</b><h3>BLAST results</h3>";
}

sub blast_id_parser($) {
	my ($string) = @_;
	my ( $gi, $acc );
	if ( $string =~ s/gi\|(\d+)\|?// ) {
		$gi  = $1;
		$acc = $1;
	} elsif ( $string =~ /lcl\|([\w\.\_\-]+)/ ) {
		$acc = $1;
	} elsif ( $string =~ /gnl\|[\w\.\_\-]+\|([\w\.\_\-]+)/ ) {
		$acc = $1;
	} elsif ( $string =~ /(\w+)\|([\w\.\_]+)\|[A-Z\d\_]+?/ ) {
		$acc = defined $2 ? $2 : $1;
	} else {
		$acc = $string;
		$acc =~ s/^\s+(\S+)/$1/;
		$acc =~ s/\s+$//;
	}
	return ( $gi, $acc );
}
 
sub blast_intro($) {
	my $data = shift;
	my $db   = basename( $data->database_name );
	$db =~ s/\w+\.subject/user_uploaded_database/g;
	return '<p>' . sprintf(
		qq{
    <p>
    <b>Database:</b> %s<br><dd>%s sequences; %s total letters<p></dd>
    <p>
    }, $db,
		&_numwithcommas( $data->database_entries ),
		&_numwithcommas( $data->database_letters ),
	) . '</p>';
}

sub _numwithcommas($) {
	my $num = reverse( $_[0] );
	$num =~ s/(\d{3})(?=\d)(?!\d*\.)/$1,/g;
	return scalar reverse $num;
}		
					
