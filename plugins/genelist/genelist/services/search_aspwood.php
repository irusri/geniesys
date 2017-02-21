<?php 
require_once('Datatables2.php');
require_once('../../../../../../sites/default/settings.php');  
include('../../../../../../crud/getgenelist.php');
$default_gene_basket_array=getdefaultgenelist();

if(isset($_POST['checkrandomid'])){
		$checkrandomid=checksharedlinkexist(trim($_POST['checkrandomid']));
		echo $checkrandomid;
		exit();
}
if($_SERVER['HTTP_REFERER']=="http://popgenie.org/?genelist=enable&_term=cesa&workflow=4"){
	 $test="&workflow=4#genefamily";
}

if(checkprefix(trim(htmlentities($_POST['id'])),"Shared")==true ){
$keywords =  preg_split("/[\:]+/",trim(htmlentities($_POST['id'])));
		$geneids_array=getdefaultsaredgenelist($keywords[1]);
		$sharred_list=implode('","',$geneids_array);
}

$table_name="basic_potri";
$tintinvariable="potri";

if(isset($_POST['selected_genome']) && $_POST['selected_genome']!=""  && $_POST['selected_genome']!=undefined){
$table_name="basic_".trim($_POST['selected_genome']);
$tintinvariable=trim($_POST['selected_genome']);
}else{
$table_name="basic_potri";
$tintinvariable="potri";
}

$datatables = new Datatables();
//MySQL connection from main settings file. database is popgeniegenepages
global $db_url;
$private_url = parse_url($db_url['aspwood_db']);
$popgenie_genepages_config = array(
'username' => $private_url['user'],
'password' => $private_url['pass'],
'database' => str_replace('/', '', $private_url['path']), 
'hostname' => $private_url['host']);
// MYSQL configuration
$datatables->connect($popgenie_genepages_config);
$datatables//,basic.Peptide_Name


->select(''.$table_name.'.Gene_Name as ID,"check_box_value",'.$table_name.'.Gene_Name as ids,'.$table_name.'.Transcript_Name,'.$table_name.'.Chromosome_Name,syno2.field2 as synonyms, '.$table_name.'.Description,  genelist_go.genelist_go_id,'.$table_name.'.Gene_Start as y, genelist_pfam.genelist_pfam_id,genelist_panther.genelist_panther_id,genelist_kog.genelist_kog_id,genelist_ko.genelist_ko_id
,genelist_smart.genelist_smart_id,genelist_atg.genelist_atg_id,genelist_atg.aSynonyms,'.$table_name.'.Gene_End' )
->from($table_name) 
->join('syno2', 'syno2.field1='.$table_name.'.Transcript_Name', 'left')
->join('genelist_go', 'genelist_go.genelist_go_gene_id='.$table_name.'.Transcript_Name', 'left')
->join('genelist_pfam', 'genelist_pfam.genelist_pfam_gene_id='.$table_name.'.Transcript_Name', 'left')
->join('genelist_panther', 'genelist_panther.genelist_panther_gene_id='.$table_name.'.Transcript_Name', 'left') 
->join('genelist_kog', 'genelist_kog.genelist_kog_gene_id='.$table_name.'.Transcript_Name', 'left') 
->join('genelist_ko', 'genelist_ko.genelist_ko_gene_id='.$table_name.'.Transcript_Name', 'left')  
->join('genelist_smart', 'genelist_smart.genelist_smart_gene_id='.$table_name.'.Transcript_Name', 'left') 
->join('genelist_atg', 'genelist_atg.genelist_atg_gene_id='.$table_name.'.Transcript_Name', 'left') 

->edit_column('ids', '<a target="_parent" href="gene?id=$1" target="_parent">$1</a>', 'ID')
->edit_column(''.$table_name.'.Transcript_Name', '<a target="_parent" href="transcript?id=$1#'.$table_name.'">$1</a>', ''.$table_name.'.Transcript_Name')
->edit_column('y', '$1-$2', 'y,'.$table_name.'.Gene_End')
->edit_column('genelist_atg.genelist_atg_id', '<a target="_blank" href="http://atgenie.org/transcript?id=$1">$1</a>', 'genelist_atg.genelist_atg_id')
->unset_column(''.$table_name.'.Gene_End') ; 

/*->select('basic.Gene_Name as ID,"check_box_value",basic.Gene_Name as ids,basic.Transcript_Name,basic.Chromosome_Name,syno2.field2 as synonyms, basic.Description,  genelist_go.genelist_go_id,basic.Gene_Start as y, genelist_pfam.genelist_pfam_id,genelist_panther.genelist_panther_id,genelist_kog.genelist_kog_id,genelist_ko.genelist_ko_id
,genelist_smart.genelist_smart_id,genelist_atg.genelist_atg_id,basic.Gene_End' )
->from('basic') 
->join('syno2', 'syno2.field1=basic.Transcript_Name', 'inner')
->join('genelist_go', 'genelist_go.genelist_go_gene_id=basic.Transcript_Name', 'left')
->join('genelist_pfam', 'genelist_pfam.genelist_pfam_gene_id=basic.Transcript_Name', 'left')
->join('genelist_panther', 'genelist_panther.genelist_panther_gene_id=basic.Transcript_Name', 'left') 
->join('genelist_kog', 'genelist_kog.genelist_kog_gene_id=basic.Transcript_Name', 'left') 
->join('genelist_ko', 'genelist_ko.genelist_ko_gene_id=basic.Transcript_Name', 'left')  
->join('genelist_smart', 'genelist_smart.genelist_smart_gene_id=basic.Transcript_Name', 'left') 
->join('genelist_atg', 'genelist_atg.genelist_atg_gene_id=basic.Transcript_Name', 'left') 

->edit_column('ids', '<a target="_parent" href="gene?id=$1'.$test.'" target="_parent">$1</a>', 'ID')
->edit_column('basic.Transcript_Name', '<a target="_parent" href="transcript?id=$1#basic">$1</a>', 'basic.Transcript_Name')
->edit_column('y', '$1-$2', 'y,basic.Gene_End')
->edit_column('genelist_atg.genelist_atg_id', '<a target="_blank" href="http://atgenie.org/transcript?id=$1">$1</a>', 'genelist_atg.genelist_atg_id')
->unset_column('basic.Gene_End') ; */


if(isset($sharred_list)){
$datatables->where('Gene_Name in ',$sharred_list);	
}

if(isset($_POST['id']) && $_POST['id'] != ''){
	$vowels = array(",", ";", "\t", "\n", "\r", "s+", " ",",,");
	$post_input=preg_replace("/\s+/", ",", trim(htmlentities($_POST['id']))); 
	$onlyconsonants = strtolower(str_replace($vowels, ",", $post_input));
	if($tintinvariable=="potri"){
	$pattern = '/^[a-zA-Z0-9]+[.]+[a-zA-Z0-9]+[.]+[0-9]?[0-9]$/';
	}else{
	$pattern = '/^[a-zA-Z0-9]+[a-zA-Z0-9]+[.]+[0-9]?[0-9]$/';	
	}
	
	$flag=true;
	
	
	if(checkprefix($onlyconsonants,$tintinvariable)==true){
		$flag=false;
	$geneids_array = explode(",", $onlyconsonants);
	$geneids_array_str=implode('","',$geneids_array);
		if(preg_match($pattern,$geneids_array[0])== true){
			$datatables->where('Transcript_Name in ',$geneids_array_str);
		}else{
			$datatables->where('Gene_Name in ',$geneids_array_str);
		}
	}
	
	if(checkprefix($onlyconsonants,"poptr")==true   || checkprefix($onlyconsonants,"fgenesh")==true  || checkprefix($onlyconsonants,"estext")==true  || checkprefix($onlyconsonants,"eugene")==true ){
		$flag=false;
	$onlyconsonants3 = str_replace($vowels, ",",  $post_input);	
	$geneids_array = explode(",", $onlyconsonants3);
	$geneids_array_str=implode('%" OR syno2.field2 LIKE "%',$geneids_array);
	$datatables->where('syno2.field2 like','%'.$geneids_array_str.'%');
	}
	
	if(checkprefix($onlyconsonants,"chr")==true   || checkprefix($onlyconsonants,"scaffold_")==true  ){
		$flag=false;
	$geneids_array = explode(",", $onlyconsonants);
	$geneids_array_str=implode('","',$geneids_array);
	$datatables->where('Chromosome_Name in ',$geneids_array_str);
	}

	if(checkprefix($onlyconsonants,"kog")==true   ){
		$flag=false;
	$onlyconsonants3 = str_replace($vowels, ",", $post_input);	
	$geneids_array = explode(",", $onlyconsonants3);
	$geneids_array_str=implode('%" OR genelist_kog.genelist_kog_id LIKE "%',$geneids_array);
	$datatables->where('genelist_kog.genelist_kog_id like','%'.$geneids_array_str.'%');		
	}	
	
	if(checkprefix($onlyconsonants,"pf")==true   ){
		$flag=false;
	$onlyconsonants3 = str_replace($vowels, ",", $post_input);	
	$geneids_array = explode(",", $onlyconsonants3);
	$geneids_array_str=implode('%" OR genelist_pfam.genelist_pfam_id LIKE "%',$geneids_array);
	$datatables->where('genelist_pfam.genelist_pfam_id like','%'.$geneids_array_str.'%');		
	}	
	
		if(checkprefix($onlyconsonants,"go:")==true   ){
			$flag=false;
	$onlyconsonants3 = str_replace($vowels, ",", $post_input);	
	$geneids_array = explode(",", $onlyconsonants3);
	$geneids_array_str=implode('%" OR genelist_go.genelist_go_id LIKE "%',$geneids_array);
	$datatables->where('genelist_go.genelist_go_id like','%'.$geneids_array_str.'%');		
	}	

		if(checkprefix($onlyconsonants,"pthr")==true   ){
			$flag=false;
	$onlyconsonants3 = str_replace($vowels, ",", $post_input);
	$geneids_array = explode(",", $onlyconsonants3);
	$geneids_array_str=implode('%" OR genelist_panther.genelist_panther_id LIKE "%',$geneids_array);
	$datatables->where('genelist_panther.genelist_panther_id like','%'.$geneids_array_str.'%');		
	}	
	
	if(checkprefix($onlyconsonants,"description:")==true   || checkprefix($onlyconsonants,"define:")==true|| checkprefix($onlyconsonants,"desc:")==true   ){
		$flag=false;
	$vowels_tmp = array("Description:", "Define:","description:","define:","desc:","Desc:");
	$onlyconsonants_tmp = strtolower(str_replace($vowels_tmp, "", $post_input));
	$datatables->where('Description like ','%'.$onlyconsonants_tmp."%");
	}
	
	if(checkprefix($onlyconsonants,"at")==true && strlen($post_input)  >4 &&  substr($onlyconsonants, 2, 1)=="G" ){
		$flag=false;
		
		
		
	$decimal_str = array(".1", ".2", ".3", ".4", ".5", ".6", ".7");
	$post_input2=str_replace($decimal_str, "",$post_input);
	$onlyconsonants2t = str_replace($vowels, ",", $post_input2);	
	$geneids_array = explode(",", $onlyconsonants2t);
		
		
	//$geneids_array = explode(",", $onlyconsonants);
	//$geneids_array_str=implode('","',$geneids_array);
	$geneids_array_str=implode('%" OR genelist_atg.genelist_atg_id LIKE "%',$geneids_array);
	$datatables->where('genelist_atg.genelist_atg_id LIKE','%'.$geneids_array_str.'%');
	}

	if($flag==true &&  checkprefix($post_input,"Shared")==false  ){
			$post_input2=trim(htmlentities($_POST['id'])); 
		////$where = "Description LIKE '%".$post_input."%' OR syno2.field2 LIKE '%".$post_input."%' OR genelist_go.genelist_go_id LIKE '%".$post_input."%' OR genelist_atg.genelist_atg_id LIKE '%".$post_input."%' OR genelist_pfam.genelist_pfam_id LIKE '%".$post_input."%'";
		// OR genelist_kog.genelist_kog_id LIKE '%".$post_input."%' OR genelist_ko.genelist_ko_id LIKE '%".$post_input."%'";
		////$datatables->where($where);	
					$datatables->where("((Description LIKE '%".$post_input2."%') OR (syno2.field2 LIKE '%".$post_input2."%') OR (genelist_atg.genelist_atg_id LIKE '%".$post_input2."%') OR (genelist_atg.aSynonyms LIKE '%".$post_input2."%') OR (genelist_go.genelist_go_id LIKE '%".$post_input2."%') OR (genelist_pfam.genelist_pfam_id LIKE '%".$post_input2."%'))"); 

		}
	
} 	

if($_POST['init_flag']==true){
echo json_encode($default_gene_basket_array);	
}else{
echo $datatables->generate($default_gene_basket_array);	
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

