<?php

$uuid=$_POST['uuid'];
$ids=$_POST['ids'];
$ids_array=explode(",",$ids);

/*
 * Database connection from plugins/settings.php 
 */	  
$path= dirname(__FILE__)."/../../settings.php";
include_once($path);
$private_url = parse_url($db_url['genelist']);
$GLOBALS["genelist_connection"]=mysqli_connect($private_url['host'], $private_url['user'], $private_url['pass'],str_replace('/', '', $private_url['path'])) or die(mysqli_error());

$final_array=array();
$j=0;
for($i=0;$i<count($ids_array);$i++){ 
	$post_id=str_replace(".p","",trim($ids_array[$i])) ;
		$initcheck2=mysqli_query($GLOBALS["genelist_connection"],"SELECT * FROM transcript_info WHERE gene_id='$post_id' or transcript_id='$post_id'") or die(mysqli_error());	;
	while ($blast_results_rows = mysqli_fetch_row($initcheck2)) {
			array_push($final_array,$blast_results_rows[1]); 
		}
		mysqli_free_result($initcheck);
	$j++;
}
echo json_encode($final_array);
?>