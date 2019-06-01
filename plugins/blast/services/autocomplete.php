<?php

//require_once 'checkinitialid.php';

header('Cache-Control: no-cache');
header('Pragma: no-cache');

/*
 * Database connection from plugins/settings.php 
 */	  
$path= $_SERVER['DOCUMENT_ROOT']."/plugins/settings.php";
include_once($path);
$private_url = parse_url($db_url['genelist']);
$GLOBALS["genelist_connection"]=mysqli_connect($private_url['host'], $private_url['user'], $private_url['pass'],str_replace('/', '', $private_url['path'])) or die(mysqli_error());


/*
* Basic get variables
*/
$primaryGene = trim($_GET['q']);


datagenerator($primaryGene);
$retg;	

function datagenerator($popmeGene){
	
	$primaryGene = trim($_GET['q']);
	$tmpLimit = trim($_GET['limit']);
	if($tmpLimit==""){$tmpLimit=10;};
	
	$retg= getalldata($popmeGene,$tmpLimit,$retg);
	
	if($retg!=null){
		$arrsg = array ('length'=>count($retg),'genedata'=>$retg); 
	}else{
		$arrsg = array ('genedata'=>$retg,'errorID'=>$primaryGene);
	}
	
	echo json_encode($arrsg);
}
/*
* get all data by feeding datagenerator data
*/
function getalldata($popmeData,$tmpLimit,$ret){
$resultPROBE_ID = mysqli_query($GLOBALS["genelist_connection"],"SELECT distinct(gene_id),description FROM transcript_info WHERE concat(transcript_id,description) like '%$popmeData%' limit $tmpLimit;")
or die(mysqli_error());
$g = 0;
while ($rowPROBE_ID = mysqli_fetch_array($resultPROBE_ID)) {
				$ttid=$children[$g]->TranscriptName=$rowPROBE_ID['gene_id'];
			$children[$g]->description=limit($rowPROBE_ID['description']);
		
			
				
				$ret[] = $children[$g];
				$g++;
				}
				
				//if($ret==null){
					//$ret=array('TranscriptName'=>'no results!');
					
					//}
				
				
	return $ret;

	

}

function limit($text,$length=64,$tail="...") {
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

function limit2($text,$length=40,$tail="...") {
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




//mysqli_close(mysql_connect()); 
?>
