<?php 
require_once('Datatables2.php');
include('../../../../../../crud/getgenelist.php');
$default_gene_basket_array=getdefaultgenelist();

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


// MYSQL configuration
$config = array(
'username' => 'conuser',
'password' => 'conpass',
'database' => 'congeniegenepagesbeta', 
'hostname' => 'localhost');

//final_pabies_pfam,pfam_gene_ids,pfam_ids,pfam_desc_only,pfam_desc
//final_pabies_go,go_gene_ids,go_ids,go_desc,desc_only

$datatables->connect($config);

$datatables
/*->select('ID,ID as ids,chromosome,source,confidence,trinity_id,pfam_id,GO,description,"check_box_value"')
->from('new_augustus_data')
->join('pfam_main','new_augustus_data.ID=pfam_main.pid','left')
->join('pabies_go_main','new_augustus_data.ID=pabies_go_main.gids','left')


->unset_column('description')
->edit_column('ids', '<a target="_parent" href="gene?id=$1" target="_parent">$1</a>', 'ID')
->edit_column('trinity_id', '<a target="_parent" href="trinity?id=$1" target="_parent">$1</a>', 'trinity_id')
->edit_column('chromosome', '<a target="_parent" href="chromosome?id=$1" target="_parent">$1</a>', 'chromosome');*/


->select('ID,"check_box_value",ID as ids,chromosome,source,confidence,trinity_id,pfam_ids,go_ids,pfam_desc')
->from('new_augustus_data')
->join('final_pabies_pfam','new_augustus_data.ID=final_pabies_pfam.pfam_gene_ids','left')
->join('final_pabies_go','new_augustus_data.ID=final_pabies_go.go_gene_ids','left')


//->unset_column('description')
->edit_column('ids', '<a target="_parent" href="gene?id=$1" target="_parent">$1</a>', 'ID')
->edit_column('trinity_id', '<a target="_parent" href="trinity?id=$1" target="_parent">$1</a>', 'trinity_id')
->edit_column('chromosome', '<a target="_parent" href="chromosome?id=$1" target="_parent">$1</a>', 'chromosome');


if(isset($sharred_list)){
$datatables->where('ID in ',$sharred_list);	
}

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
	
	if(checkprefix($onlyconsonants,"comp")==true || checkprefix($onlyconsonants,"na")==true  ){
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
	
//cho $geneids_array_str;

}



if($_POST['init_flag']==true){
	//$geneids_array_strx=implode('","',$default_gene_basket_array);
	//$datatables->where('ID in ',$geneids_array_strx);
//	$datatables->where('ID in ',$default_gene_basket_array);	
//$default_gene_basket_array_string=implode(',',$default_gene_basket_array);
echo json_encode($default_gene_basket_array);	
}else{
echo $datatables->generate($default_gene_basket_array);	
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