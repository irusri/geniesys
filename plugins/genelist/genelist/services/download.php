<?php 
header('Content-type: text/plain; charset=utf-8');
require_once('Datatables.php');
require_once('settings.php');  




if(isset($_POST['checkrandomid'])){
		$checkrandomid=checksharedlinkexist(trim($_POST['checkrandomid']));
		echo $checkrandomid;
		exit();
}



if(checkprefix($_POST['id'],"Shared")==true ){
$keywords =  preg_split("/[\:]+/",trim($_POST['id']));
		$geneids_array=getdefaultsaredgenelist($keywords[1]);
		$sharred_list=implode('","',$geneids_array);
		//echo $_POST['id'];
}

$datatables = new Datatables();

$tintinvariable="at";
$table_name="transcript_info";


//MySQL connection from main settings file. database is popgeniegenepages
$private_url = parse_url($db_url['genelist']);
$popgenie_genepages_config = array(
'username' => $private_url['user'],
'password' => $private_url['pass'],
'database' => str_replace('/', '', $private_url['path']), 
'hostname' => $private_url['host']);


// MYSQL configuration
$datatables->connect($popgenie_genepages_config);


$datatables
->select(''.$table_name.'.gene_id as ID,"check_box_value",'.$table_name.'.gene_id as ids,'.$table_name.'.transcript_id,'.$table_name.'.chromosome_name,'.$table_name.'.description,transcript_potri.potri_id,transcript_atg.atg_id,gene_kegg.kegg_description,gene_atg.atg_description,gene_go.go_description,gene_pfam.pfam_description')
->from($table_name) 
->join('transcript_potri', 'transcript_potri.transcript_i=transcript_info.transcript_i', 'left')
->join('transcript_atg', 'transcript_atg.transcript_i=transcript_info.transcript_i', 'left')
->join('gene_kegg', 'gene_kegg.gene_i=transcript_info.gene_i', 'left')
	->join('gene_atg', 'gene_atg.gene_i=transcript_info.gene_i', 'left')
	->join('gene_go', 'gene_go.gene_i=transcript_info.gene_i', 'left')
	->join('gene_pfam', 'gene_pfam.gene_i=transcript_info.gene_i', 'left')


//->edit_column('ids', '<a target="_parent" href="gene?id=$1" target="_blank">$1</a>', 'ID') 
//->edit_column(''.$table_name.'.transcript_id', '<a target="_blank" href="transcript?id=$1">$1</a>', ''.$table_name.'.transcript_id')

//->edit_column('transcript_potri.potri_id', '<a target="_blank" href="http://popgenie.org/transcript?id=$1">$1</a>', 'transcript_potri.potri_id') 
//->edit_column('transcript_atg.atg_id', '<a target="_blank" href="http://atgenie.org/transcript?id=$1">$1</a>', 'transcript_atg.atg_id') ;
//->unset_column(''.$table_name.'.gene_end') ; 
;

  
if(isset($sharred_list)){
$datatables->where('gene_id in ',$sharred_list);	
}

if(isset($_POST['id']) && $_POST['id'] != ''){
	$vowels = array(",", ";", "\t", "\n", "\r", "s+", " ",",,");
	$post_input=preg_replace("/\s+/", ",", trim(htmlentities($_POST['id']))); 
	$onlyconsonants = strtolower(str_replace($vowels, ",", $post_input));
	$pattern = '/^[a-zA-Z0-9]+[.]+[a-zA-Z0-9]+[.]+[0-9]?[0-9]$/';
	$flag=true;

	if(checkprefix($onlyconsonants,$tintinvariable)==true && checkprefix($onlyconsonants,"at")==true){
		$flag=false;
	$geneids_array = explode(",", $onlyconsonants);
	$geneids_array_str=implode('","',$geneids_array);
	
		if(preg_match($pattern,$geneids_array[0])== true){
			$datatables->where($table_name.'transcript_id in ',$geneids_array_str);
			
		}else{
			$datatables->where($table_name.'.gene_id in ',$geneids_array_str);
		}
	}
	
	
	if(checkprefix($onlyconsonants,"chr")==true   || checkprefix($onlyconsonants,"scaffold_")==true  ){
		$flag=false;
	$geneids_array = explode(",", $onlyconsonants);
	$geneids_array_str=implode('","',$geneids_array);
	$datatables->where('chromosome_name in ',$geneids_array_str);
	}

	if(checkprefix($onlyconsonants,"potri")==true   ){
	$flag=false;
	$geneids_array = explode(",", $onlyconsonants);
	$geneids_array_str=implode('","',$geneids_array);
	$datatables->where('transcript_potri.potri_id in ',$geneids_array_str);
	}
	
	if(checkprefix($onlyconsonants,"satg")==true   ){
	$flag=false;
	$geneids_array = explode(",", $onlyconsonants);
	$geneids_array_str=implode('","',$geneids_array);
	$datatables->where('transcript_atg.atg_id in ',$geneids_array_str);
	}	
	


	if($flag==true &&  checkprefix($post_input,"Shared")==false  ){
		$post_input2=trim(htmlentities($_POST['id'])); 
		$datatables->where("($table_name.description LIKE '%".$post_input2."%' ) OR (transcript_atg.atg_id LIKE '%".$post_input2."%' ) OR (gene_go.go_description LIKE '%".$post_input2."%' ) OR (gene_pfam.pfam_description LIKE '%".$post_input2."%' ) OR (gene_kegg.kegg_description LIKE '%".$post_input2."%' )"); 
		}
	
	
} 	



$intersect_mysql_viscol_keys=array();
//$mysqlcolumns=array('Gene'=>'ids','Chromosome'=>'chromosome','Source'=>'source','Confidence'=>'confidence','Trinity'=>'trinity_id','PFAM'=>'pfam_ids','GO'=>'go_ids','PFAM-Description'=>'pfam_desc','GO-Description'=>'go_desc');
$mysqlcolumns=array('Gene'=>'ID','Transcript'=>'transcript_id','Chromosome'=>'chromosome_name','Description'=>'description','Poplar'=>'potri_id','ATG'=>'atg_id','KEGG'=>'kegg_description','ATG Description'=>'atg_description','GO'=>'go_description','PFAM'=>'pfam_description'  );
$mysqlcolumns_flipped=array_flip($mysqlcolumns);
$visColumnsarray = explode(",",$_POST['visColumns']);
$intersect_mysql_viscol=array_intersect($mysqlcolumns_flipped,$visColumnsarray);
foreach($intersect_mysql_viscol as $k=>$v)
{
  $intersect_mysql_viscol_keys[] = $k;
} 

ini_set('memory_limit', '-1');
ini_set('max_execution_time', 300);
//print_r($intersect_mysql_viscol);
if($_POST['button_name']!="Export table as TSV"){
header('Content-type: application/csv');
header('Content-Disposition: attachment; filename=gene_table.csv');
echo  array_to_scv($datatables->generate_csv($intersect_mysql_viscol_keys),$intersect_mysql_viscol);	
}else{
header('Content-type: application/tsv');
header('Content-Disposition: attachment; filename=gene_table.tsv');
//exec("awk '{print $2}' gene_table.tsv "); 
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
	
	
	//print_r( $uniqueEmails);
	return $output;
}



//echo $datatables->generate($default_gene_basket_array);



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