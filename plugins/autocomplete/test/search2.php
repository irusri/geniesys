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
	$resultssequence = mysql_query("SELECT trinityname,division,taxonomyname FROM trinity_taxonomy WHERE concat(taxonomyname, division,trinityname) LIKE '%$q%'")or die(mysql_error());
		$j = 0;
		while($sequencearr = mysql_fetch_array($resultssequence)){
			  $children[$j]->label=$sequencearr['trinityname'];
			  $children[$j]->category=$sequencearr['division'];
			
			 $children[$j]->value=$sequencearr['taxonomyname'];
				//if (strpos(strtolower($trinitynamer,$divisionr,$taxonomynamer ), $q) !== false) {
			
			$results[] = $children[$j];
			//$results[] = array($trinitynamer, $divisionr,$taxonomynamer);
				 //}
		  $j++;
		}


		//$arrs = array ($results);
		//echo json_encode($arrs);



	}else{
		
		
		
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
