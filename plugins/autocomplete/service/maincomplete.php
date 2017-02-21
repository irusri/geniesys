 <?php
require_once 'connection.php';
//require_once 'checkinitialid.php';

header('Cache-Control: no-cache');
header('Pragma: no-cache');
/*
* Basic get variables
*/
$primaryGene = trim($_GET['unavailable']);

if($primaryGene==""){
	$primaryGene="protein";
}
datagenerator($primaryGene);
$retg;	

function datagenerator($popmeGene){
	
	$primaryGene = trim($_GET['unavailable']);
	$retg= getalldata($popmeGene,$retg);
	
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
function getalldata($popmeData,$ret){


$resultPROBE_ID = mysql_query("SELECT * FROM mainpagesearch2 WHERE concat(Transcript_Name,Description,Synonyms) like '%$popmeData%' limit 10;")
or die(mysql_error());
$g = 0;
while ($rowPROBE_ID = mysql_fetch_array($resultPROBE_ID)) {
				$ttid=$children[$g]->TranscriptName=$rowPROBE_ID['Transcript_Name'];
			$children[$g]->description=limit($rowPROBE_ID['Description']);
		
			if($rowPROBE_ID['Synonyms']!=""){
				$children[$g]->synonyms='('.limit2($rowPROBE_ID['Synonyms']).')';
			}else{
				$children[$g]->synonyms=limit2($rowPROBE_ID['Synonyms']); 	
			}
				
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

exit;


mysql_close(mysql_connect()); 
?>
