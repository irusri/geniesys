<?php
/*
 * Results array
 */
$results = array();

/*
 * Autocomplete formatter
 */
function autocomplete_format($results) {
    foreach ($results as $result) {
        echo $result[0] . '|' . $result[1] . "\n";
    }
}

if (isset($_GET['q'])) {
  $q = trim($_GET['q']);
  $onlyconsonants=strtolower($q);
  if ($q) {

/*
 * Database connection from plugins/settings.php
 */	  
$path= $_SERVER['DOCUMENT_ROOT']."/plugins/settings.php";
include($path);
$private_url = parse_url($db_url['genelist']);
$GLOBALS["genelist_connection"]=mysqli_connect($private_url['host'], $private_url['user'], $private_url['pass'],str_replace('/', '', $private_url['path'])) or die(mysqli_error());

	$resultssequence2 = mysqli_query($GLOBALS["genelist_connection"],"SELECT * FROM transcript_info WHERE concat(transcript_id,gene_id,description) like '%$q%' limit 10")or die(mysqli_error());
		
		$k = 0;
		while($sequencearr2 = mysqli_fetch_array($resultssequence2)){
			  $trinitynamer2=$sequencearr2['gene_id'];
			   if($sequencearr2['description']!="" && $sequencearr2['description']!="-"){
			   $trinitynamer2x=$sequencearr2['gene_id'].'-'.limit($sequencearr2['description']);
			   }else{
				    $trinitynamer2x=$sequencearr2['gene_id'];
			   }
			   
			  $divisionr2="test";
			  $taxonomynamer2=$sequencearr2['chromosome_name'];
					 $results2[] = array('trinityname'=>$trinitynamer2,'trinityname2x'=>$trinitynamer2x, 'division'=>limit($divisionr2),'taxonomyname'=>limit($taxonomynamer2));
		  $k++;
		}
  }
} 

function limit($text,$length=52,$tail="...") {
    $text = trim($text);
    $txtl = strlen($text);
    if($txtl > $length) {
        for($i=1;$text[$length-$i]!=" ";$i++) {
            if($i == $length) {
                return substr($text,0,$length) . $tail;
            }
        }
        $text = substr($text,0,$length-$i+1) . $tail;
    }
    return ucfirst($text);
}


/*
 * Output format
 */
$output = 'autocomplete';
if (isset($_GET['output'])) {
    $output = strtolower($_GET['output']);
}

/*
 * Output results
 */

if ($output === 'json') {
	
    echo json_encode($results);
} else {
	 $array3 = array_merge((array) $results2,(array) $results);
	echo json_encode($array3);
   // echo autocomplete_format($results);
}

#####################################
//Check prefix
#####################################
function checkprefix($source, $prefix) {
    if (str_startswith($source, $prefix)) {
       return true;
    } else {
       return false;
    }
}
function str_startswith($source, $prefix)
{
   return strncmp($source, $prefix, strlen($prefix)) == 0;
}
/////////////////////////////////////


#####################################
//Check suffix
#####################################
function checksuffix($source, $suffix) {
    if (str_endswith($source, $suffix)) {
       return true;
    } else {
       return false;
    }
}
function str_endswith($source, $suffix) {
   return (strpos(strrev($source), strrev($suffix)) === 0);
}
/////////////////////////////////////
