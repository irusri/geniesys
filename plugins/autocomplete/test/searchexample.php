<?php

/*
 * Load sample data
 */
include 'data.php';

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

/*
 * Search for term if it is given

if (isset($_GET['q'])) {
    $q = strtolower($_GET['q']);
    if ($q) {
        foreach ($data as $key => $value) {
            if (strpos(strtolower($key), $q) !== false) {
                $results[] = array($key, $value,$q);
            }
        }
    }
} */

if (isset($_GET['q'])) {
  //$q = strtolower($_GET['q']);
  $q = trim($_GET['q']);
  if ($q) {
	mysql_connect("localhost", "conuser", "conpass") or die(mysql_error());
	mysql_select_db("congeniegenepagesbeta") or die(mysql_error());
	
	if(substr($q, 0, 3)!="MA_"){
	//$resultssequence = mysql_query("select trinityname,division,taxonomyname from trinity_taxonomy where trinityname like '%$q%'")or die(mysql_error());
	//}else if(substr($q, 0, 4)=="comp"){
	$resultssequence = mysql_query("SELECT DISTINCT trinityname FROM trinity_taxonomy WHERE trinityname LIKE '%$q%'")or die(mysql_error());
		$j = 0;
		while($sequencearr = mysql_fetch_array($resultssequence)){
			  $trinitynamer=$sequencearr['trinityname'];
			 
				//if (strpos(strtolower($trinitynamer,$divisionr,$taxonomynamer ), $q) !== false) {
					 $results[] = array($trinitynamer);
				 //}
		  $j++;
		}
	}

	if(substr($q, 0, 2)=="MA"){
		
		
		$resultssequence = mysql_query("SELECT DISTINCT ID FROM new_augustus_data WHERE ID LIKE '%$q%'")or die(mysql_error());
		$j = 0;
		while($sequencearr = mysql_fetch_array($resultssequence)){
			  $trinitynamer=$sequencearr['ID'];
			 
				//if (strpos(strtolower($trinitynamer,$divisionr,$taxonomynamer ), $q) !== false) {
					 $results[] = array($trinitynamer);
				 //}
		  $j++;
		}
		
		
	}


  }
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
    echo autocomplete_format($results);
}
