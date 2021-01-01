<?php 
header('Content-type: text/plain; charset=utf-8');

//Include config file
include_once("config.php");


$intersect_mysql_viscol_keys=array();
$mysqlcolumns_flipped=array_flip($mysqlcolumns);
$visColumnsarray = explode(",",$_POST['visColumns']);
$intersect_mysql_viscol=array_intersect($mysqlcolumns_flipped,$visColumnsarray);
foreach($intersect_mysql_viscol as $k=>$v)
{
  $intersect_mysql_viscol_keys[] = $k;
} 

ini_set('memory_limit', '-1');
ini_set('max_execution_time', 300);
if($_POST['button_name']=="Export table as TSV"){
header('Content-type: application/csv');
header('Content-Disposition: attachment; filename=gene_table.csv');
echo  array_to_scv($datatables->generate_csv($intersect_mysql_viscol_keys),$intersect_mysql_viscol);	
}else{
header('Content-type: application/tsv');
header('Content-Disposition: attachment; filename=gene_table.tsv');
echo  array_to_scv($datatables->generate_csv($intersect_mysql_viscol_keys),$intersect_mysql_viscol,true,"\t","\n","");

}

/**
*Clean Array
**/
function array_multi_unique($multiArray){
  $uniqueArray = array();
  foreach($multiArray as $subArray){
    if(!in_array($subArray, $uniqueArray)){
      $uniqueArray[] = $subArray;
    }
  }
  return $uniqueArray;
}

/**
* Generatting CSV formatted string from an array.
* By Sergey Gurevich.
*/
function array_to_scv($arrayall,$headerarray, $header_row = true, $col_sep = ",", $row_sep = "\n", $qut = '"')
{
	
	$check_transcript_name = preg_match("/transcript/i", $_POST['visColumns']);
	if($check_transcript_name==1){
		//transcript selected
		$array=$arrayall;
	}else{
		//transcript not selected
		$array=array_multi_unique($arrayall);		
	}
	
	if (!is_array($array) or !is_array($array[0])) return false;

	//Header row.
	if ($header_row)
	{
		foreach ($headerarray as $key => $val)
		{
			//Escaping quotes.
			$key = str_replace($qut, "$qut$qut", $key);
			$output .= "$col_sep$qut$key$qut";
		}
		$output = substr($output, 1)."\n";
	}
	//Data rows.
	foreach ($array as $key => $val)
	{
		$tmp = '';
		foreach ($val as $cell_key => $cell_val)
		{
			//Escaping quotes.
			$cell_val = str_replace($qut, "$qut$qut", $cell_val);
			$tmp .= "$col_sep$qut$cell_val$qut";
		}
		$output .= substr($tmp, 1).$row_sep;
	}
	
	

	return $output;
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



?>