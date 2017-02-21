<?php
$q="comp1_c0_seq1";
mysql_connect("localhost", "conuser", "conpass") or die(mysql_error());
mysql_select_db("congeniegenepagesbeta") or die(mysql_error());

$resultssequence = mysql_query("select nam,len,gc from trinity where nam='$q'")or die(mysql_error());
                                //$j = 0;
                                //$sequence="";
                                //while (
								while($sequencearr = mysql_fetch_array($resultssequence)){;//) {
                               		  $namesr=$sequencearr['nam'];
									  $lenr=$sequencearr['nam'];
		                            
									foreach ($sequencearr as $namesr) {
            							if (strpos(strtolower($namesr), $q) !== false) {
               								 $results[] = array($namesr, $lenr,$q);
           								 }
       								}
									  $j++;
									}
									print_r($results)
?>