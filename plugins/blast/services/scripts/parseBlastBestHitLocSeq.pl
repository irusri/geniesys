#!/usr/bin/perl

# Parsing BLAST reports with BioPerl's Bio::SearchIO module
# WI Unix and Programming Skills for Biologists - class 3

# See documentation at http://bioperl.org/HOWTOs/SearchIO/index.html

use Bio::SearchIO;

# Prompt the user for the filename it it's not given as an argument
if (! $ARGV[0])
{
   print "What is the BLAST text file to parse? ";

   # Get input and remove the newline character at the end
   chomp ($inFile = <STDIN>);
}
else
{
   $inFile = $ARGV[0];
   #print '$ARGV[0]\n';
}
if (! $ARGV[1])
{
	$toParse = 1;
}
else
{
	$toParse = $ARGV[1];
}
# Create a SearchIO "object" from the BLAST report
# This report may contain multiple concatenated reports
$report = new Bio::SearchIO( -file => "$inFile", -format => "blastxml");

# Print out one line of all desired fields, delimited by tabs:
# QUERY NAME, HIT NUM, HIT NAME, HIT E-VALUE, FRACTION IDENTITY   [and ending with a newline]

# 1
# Fields: , Subject id, % identity, alignment length, mismatches, gap openings, q. start, q. end, s. start, s. end, e-value, bit score
#print "QUERY_ACC";
#print "\tQUERY_DESC";
#print "\tHIT_NUM";
#print "\tHIT_NAME";
#print "\tHIT_DESC";
#print "\tSCORE";
#print "\tHIT_SIGNIF";
#print "\tHIT_E-VALUE";
#print "\tFRAC_IDENTITY";
#print "\tQUERY_LEN";
#print "\tHSP_LEN";
#print "\tQUERY_STRAND";
#print "\tQUERY_START";
#print "\tQUERY_END";
#print "\tHSP_STRAND";
#print "\tHSP_START";
#print "\tHSP_END";
#print "\tNUM_GAPS";
#print "\tSEQ_QUERY";
#print "\tSEQ_HSP";
# print "\tSEQ_CONSENSUS";
#print "\n";

# Go through BLAST reports one by one              
while($result = $report->next_result)
{
   # Reset hit number for each query  
   $hitNumber = 0;

   # Go through each each matching sequence
   while($hit = $result->next_hit)
   {
      $hitNumber++;
      # Go through each each HSP for this sequence
      while ($hsp = $hit->next_hsp)
      {
         # Print some tab-delimited data about this HSP
         $queryName = $result->query_name;
         $queryAcc = $result->query_accession;
         $queryLength = $result->query_length;
         $queryDesc = $result->query_description;
         $dbName = $result->database_name;
         $numSeqsInDb = $result->database_entries;
         $numHits = $result->num_hits;

         $hitName = $hit->name;
         $hitAcc = $hit->accession;
         $hitDesc = $hit->description;
         $hitEvalue = $hit->significance;
         $hitBits = $hit->bits;
         $numHsps = $hit->num_hsps;

         $hspEvalue = $hsp->evalue;
         $fracIdentical = $hsp->frac_identical;
         $fracConserved = $hsp->frac_conserved;
         $numGaps = $hsp->gaps;
         $mismatch =$hsp->seq_inds('hit', 'mismatch');#
         
         $hspLength = $hsp->hsp_length;
         $hspQuerySeq = $hsp->query_string;
         $hspHitSeq = $hsp->hit_string;
         $hspConsensus = $hsp->homology_string;
         $hspLength = $hsp->hsp_length;
         $hspRank = $hsp->rank;

         $queryStrand = $hsp->strand('query');
         $hitStrand = $hsp->strand('hit');
         $queryStart = $hsp->start('query');
         $queryEnd = $hsp->end('query');
         $hspStart = $hsp->start('hit');
         $hspEnd = $hsp->end('hit');

         $hspScore = $hsp->score;
         $hspBits = $hsp->bits;
         
         # PRINT OUT BEST FIVE HITS FOR EACH QUERY SEQUENCE

         # If $hitNumber <= 5 and $hspRank == 1, print out the following fields: 
         # QUERY NAME, HIT NUM, HIT DESCRIPTION, HIT E-VALUE, FRACTION IDENTITY
         # as tab-delimited fields on one line

         # 2$queryAcc.
         	if ($hspEvalue ==0){
         	$rounded_hspEvalue2=$hitName." evalue 0";
         	}else{
			$rounded_hspEvalue2 = $hitName." evalue".('%2.0g',$hspEvalue);
			}
            print "$hitAcc";
            print "\t$hitAcc";
           	$fracIdentical_rounded = sprintf("%.2f", $fracIdentical*100);
            print "\t$fracIdentical_rounded";
            print "\t$hspLength";
            print "\t$mismatch";
            
            print "\t$numGaps";
            print "\t$queryStart";
            print "\t$queryEnd";
            print "\t$hspStart";
            print "\t$hspEnd";
            
            $rounded_hspEvalue = sprintf("%2.0g", $hspEvalue);
            print "\t$rounded_hspEvalue";
            
            $rounded_hspBits = sprintf("%0.1f", $hspBits);
            print "\t$rounded_hspBits";
            print "\n";
         
      }
    }

    #if ($hitNumber ==0)
    #{
      #$queryAcc = $result->query_accession;
       #$queryDesc = $result->query_description;
       #print "$queryAcc\t$queryDesc\t0\tNo hit\n";
    #}

}

