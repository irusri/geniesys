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
  $onlyconsonants=strtolower($q);
  if ($q) {
	mysql_connect("localhost", "conuser", "conpass") or die(mysql_error());
	mysql_select_db("congeniegenepagesbeta") or die(mysql_error());
	
	//if(substr($q, 0, 2)!="MA"){
	//$resultssequence = mysql_query("select trinityname,division,taxonomyname from trinity_taxonomy where trinityname like '%$q%'")or die(mysql_error());
	//}else if(substr($q, 0, 4)=="comp"){
	/*$resultssequence = mysql_query("SELECT trinityname,division,taxonomyname FROM trinity_taxonomy WHERE concat(taxonomyname, division,trinityname) LIKE '%$q%' order by division DESC limit 20; ")or die(mysql_error());
		$j = 0;
		while($sequencearr = mysql_fetch_array($resultssequence)){
			  $trinitynamer=$sequencearr['trinityname'];
			  $divisionr=$sequencearr['division'];
			  $taxonomynamer=$sequencearr['taxonomyname'];
				//if (strpos(strtolower($trinitynamer,$divisionr,$taxonomynamer ), $q) !== false) {
					 $results[] = array('trinityname'=>$trinitynamer, 'division'=>limit($divisionr),'taxonomyname'=>limit($taxonomynamer));
				 //}
		  $j++;
		}
*/
if(checkprefix($onlyconsonants,"ma")==true || checkprefix($onlyconsonants,"pi")==true  ){	
		$resultssequence2 = mysql_query("SELECT ID,confidence,chromosome FROM new_augustus_data WHERE concat(ID,confidence,chromosome) LIKE '%$q%' order by confidence ASC limit 20; ")or die(mysql_error());
		
		
		$k = 0;
		while($sequencearr2 = mysql_fetch_array($resultssequence2)){
			  $trinitynamer2=$sequencearr2['ID'];
			  $divisionr2=$sequencearr2['confidence'];
			  $taxonomynamer2=$sequencearr2['chromosome'];
				//if (strpos(strtolower($trinitynamer,$divisionr,$taxonomynamer ), $q) !== false) {
					 $results2[] = array('trinityname'=>$trinitynamer2,'trinityname2x'=>$trinitynamer2, 'division'=>limit($divisionr2),'taxonomyname'=>limit($taxonomynamer2));
				 //}
		  $k++;
		}

}
		
	if(checkprefix($onlyconsonants,"po")==true ){	
			$resultssequence2 = mysql_query("SELECT ID,confidence,chromosome,yaocheng_pabies_poplar_s_gene FROM new_augustus_data left join pabies_poplar_new on pabies_poplar_new.yaocheng_pabies_id=new_augustus_data.ID WHERE yaocheng_pabies_poplar_id LIKE '%$q%' order by confidence ASC limit 20; ")or die(mysql_error());
			
		$k = 0;
		while($sequencearr2 = mysql_fetch_array($resultssequence2)){
			  $trinitynamer2=$sequencearr2['ID'];
			    $trinitynamer2x=$sequencearr2['ID'].'</br>'.$sequencearr2['yaocheng_pabies_poplar_s_gene'];
			  
			  $divisionr2=$sequencearr2['confidence'];
			  $taxonomynamer2=$sequencearr2['chromosome'];
				//if (strpos(strtolower($trinitynamer,$divisionr,$taxonomynamer ), $q) !== false) {
					 $results2[] = array('trinityname'=>$trinitynamer2,'trinityname2x'=>limit($trinitynamer2x), 'division'=>limit($divisionr2),'taxonomyname'=>limit($taxonomynamer2));
				 //}
		  $k++;
		}

	}
	
	
		
	if(checkprefix($onlyconsonants,"at")==true ){	
			$resultssequence2 = mysql_query("SELECT ID,confidence,chromosome,yaocheng_pabies_tair_s_gene FROM new_augustus_data left join pabies_tair_new on pabies_tair_new.yaocheng_pabies_id=new_augustus_data.ID WHERE yaocheng_pabies_tair_s_gene LIKE '%$q%' order by confidence ASC limit 20; ")or die(mysql_error());
			
			
		$k = 0;
		while($sequencearr2 = mysql_fetch_array($resultssequence2)){
			  $trinitynamer2=$sequencearr2['ID'];
			    $trinitynamer2x=$sequencearr2['ID'].'</br>'.$sequencearr2['yaocheng_pabies_tair_s_gene'];
			  
			  $divisionr2=$sequencearr2['confidence'];
			  $taxonomynamer2=$sequencearr2['chromosome'];
				//if (strpos(strtolower($trinitynamer,$divisionr,$taxonomynamer ), $q) !== false) {
					 $results2[] = array('trinityname'=>$trinitynamer2, 'trinityname2x'=>limit($trinitynamer2x),'division'=>limit($divisionr2),'taxonomyname'=>limit($taxonomynamer2));
				 //}
		  $k++;
		}

	}	




	/*}else{
		
		
		
		
	}*/


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
