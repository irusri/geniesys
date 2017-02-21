<?php 
require_once('Datatables2.php');
include('../../../../../../crud/getgenelist.php');

$datatables = new Datatables();

// MYSQL configuration
$config = array(
'username' => 'conuser',
'password' => 'conpass',
'database' => 'congeniegenepagesbeta', 
'hostname' => 'localhost');

$datatables->connect($config);

$datatables
->select('ID,"check_box_value",ID as ids,chromosome,source,confidence,trinity_id,pfam_ids,go_ids,pfam_desc,go_desc')
->from('new_augustus_data')
->join('final_pabies_pfam','new_augustus_data.ID=final_pabies_pfam.pfam_gene_ids','left')
->join('final_pabies_go','new_augustus_data.ID=final_pabies_go.go_gene_ids','left');


//->unset_column('ids,trinity_id,pfam_ids,go_ids,pfam_desc,go_desc');
//->edit_column('ids', '<a target="_parent" href="gene?id=$1" target="_parent">$1</a>', 'ID')
//->edit_column('trinity_id', '<a target="_parent" href="trinity?id=$1" target="_parent">$1</a>', 'trinity_id')
//->edit_column('chromosome', '<a target="_parent" href="chromosome?id=$1" target="_parent">$1</a>', 'chromosome');

 
//->unset_column('autoid')
//->edit_column('ids', '<a target="_parent" href="gene?id=$1" target="_parent">$1</a>', 'ID');
//->edit_column('trinity_id', '<a target="_parent" href="trinity?id=$1" target="_parent">$1</a>', 'trinity_id')
//->edit_column('chromosome', '<a target="_parent" href="chromosome?id=$1" target="_parent">$1</a>', 'chromosome');



if(isset($_POST['id']) && $_POST['id'] != ''){
	$vowels = array(",", ";", "\t", "\n", "\r", "s+", " ");
	$onlyconsonants = strtolower(str_replace($vowels, ",", $_POST['id']));
	
	
	if(checkprefix($onlyconsonants,"ma")==true &&  strpos($onlyconsonants,'g') == false){
	$geneids_array = explode(",", $onlyconsonants);
	$geneids_array_str=implode('","',$geneids_array);
	$datatables->where('chromosome in ',$geneids_array_str);
	}
	
	
	if(checkprefix($onlyconsonants,"ma")==true && strpos($onlyconsonants,'g') == true){
	$geneids_array = explode(",", $onlyconsonants);
	$geneids_array_str=implode('","',$geneids_array);
	$datatables->where('ID in ',$geneids_array_str);
	}
	
	if(checkprefix($onlyconsonants,"eugene")==true || checkprefix($onlyconsonants,"augustus")==true ){
	$geneids_array = explode(",", $onlyconsonants);
	$geneids_array_str=implode('","',$geneids_array);
	$datatables->where('source in ',$geneids_array_str);		
	}
	
	if(checkprefix($onlyconsonants,"high")==true || checkprefix($onlyconsonants,"medium")==true | checkprefix($onlyconsonants,"low")==true){
	$geneids_array = explode(",", $onlyconsonants);
	$geneids_array_str=implode('","',$geneids_array);
	$datatables->where('confidence in ',$geneids_array_str);
	}
	
	if(checkprefix($onlyconsonants,"comp")==true ){
	$geneids_array = explode(",", $onlyconsonants);
	$geneids_array_str=implode('","',$geneids_array);
	$datatables->where('trinity_id in ',$geneids_array_str);
	}
	
	if(checkprefix($onlyconsonants,"go")==true ){
	$onlyconsonants2 = str_replace($vowels, ",", $_POST['id']);	
	$geneids_array = explode(",", $onlyconsonants2);
	$geneids_array_str=implode('%" OR go_ids LIKE "%',$geneids_array);
	$datatables->where('go_ids like','%'.$geneids_array_str.'%');
	}
	
	if(checkprefix($onlyconsonants,"pf")==true ){
	$onlyconsonants3 = str_replace($vowels, ",", $_POST['id']);	
	$geneids_array = explode(",", $onlyconsonants3);
	$geneids_array_str=implode('%" OR pfam_ids LIKE "%',$geneids_array);
	$datatables->where('pfam_ids like','%'.$geneids_array_str.'%');
	}
	
	
	
	
}
ini_set('memory_limit', '-1');
ini_set('max_execution_time', 300);
if($_POST['add_genes']==true){
//print_r($datatables->generate_genelist());
updategenebasket($datatables->generate_genelist()); 

}

if($_POST['remove_genes']==true){
//$temparr=array($datatables->generate_genelist());
removegenebasket($datatables->generate_genelist());
//print_r($datatables->generate_genelist());
}

if($_POST['share_table']==true){
//print_r($datatables->generate_genelist());
//$randid=rand(100, 100000000000);
$randid = substr(number_format(time() * rand(), 0, '', ''), 0, 10000000);
sharetable($datatables->generate_genelist(),"shared table",$randid); 
echo  $randid;
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