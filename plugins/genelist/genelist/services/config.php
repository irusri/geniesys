<?php
require_once('Datatables.php');
include_once("../../../settings.php");

 if(isset($_POST['checkrandomid'])){
		$checkrandomid=checksharedlinkexist(trim($_POST['checkrandomid']));
		echo $checkrandomid;
		exit();
}

if(checkprefix(trim(htmlentities($_POST['id'])),"Shared")==true ){
$keywords =  preg_split("/[\:]+/",trim(htmlentities($_POST['id'])));
		$geneids_array=getdefaultsaredgenelist($keywords[1]);
		$sharred_list=implode('","',$geneids_array);
}

$tintinvariable="pot";
$table_name="transcript_info"; 

$datatables = new Datatables();
//MySQL connection from main settings file. database is popgeniegenepages
$db_url=$GLOBALS["db_url"];
$private_url = parse_url($db_url['genelist']);
$popgenie_genepages_config = array(
'username' => $private_url['user'],  
'password' => $private_url['pass'], 
'database' => str_replace('/', '', $private_url['path']), 
'hostname' => $private_url['host']);
// MYSQL configuration
$datatables->connect($popgenie_genepages_config);
$datatables

->select(''.$table_name.'.gene_id as ID,"check_box_value",'.$table_name.'.gene_id as ids,'.$table_name.'.transcript_id,'.$table_name.'.chromosome_name,'.$table_name.'.description,
gene_atg.atg_description,
gene_go.go_description,
gene_kegg.kegg_description,
gene_pfam.pfam_description,
gene_atg.atg_id,
gene_populus.populus_gene_id,
gene_spruce.spruce_gene_id')
->from($table_name) 
->join('transcript_potri', 'transcript_potri.transcript_i=transcript_info.transcript_i', 'left')
//->join('transcript_atg', 'transcript_atg.transcript_i=transcript_info.transcript_i', 'left')
	
	->join('gene_kegg', 'gene_kegg.gene_i=transcript_info.gene_i', 'left')
	->join('gene_go', 'gene_go.gene_i=transcript_info.gene_i', 'left')
	->join('gene_pfam', 'gene_pfam.gene_i=transcript_info.gene_i', 'left')

	->join('gene_atg', 'gene_atg.gene_i=transcript_info.gene_i', 'left')
	->join('gene_populus', 'gene_populus.gene_i=transcript_info.gene_i', 'left')
	->join('gene_spruce', 'gene_spruce.gene_i=transcript_info.gene_i', 'left')
->edit_column('ids', '<a target="_parent" href="gene?id=$1" target="_blank">$1</a>', 'ID') 
//->edit_column(''.$table_name.'.transcript_id', '<a target="_blank" href="transcript?id=$1">$1</a>', ''.$table_name.'.transcript_id')
->edit_column('gene_spruce.spruce_gene_id', '<a target="_blank" href="//plantgenie.org/redirect.php?id=$1">$1</a>', 'gene_spruce.spruce_gene_id')	
//->edit_column('gene_populus.populus_gene_id', '<a target="_blank" href="http://popgenie.org/gene?id=$1">$1</a>', 'gene_populus.populus_gene_id') 
->edit_column('gene_atg.atg_id', '<a target="_blank" href="//plantgenie.org/redirect.php?id=$1">$1</a>', 'gene_atg.atg_id') ;
  
if(isset($sharred_list)){
$datatables->where($table_name.'.gene_id in ',$sharred_list);	
}

if(isset($_POST['id']) && $_POST['id'] != ''){
	$vowels = array(",", ";", "\t", "\n", "\r", "s+", " ",",,");
	$post_input=preg_replace("/\s+/", ",", trim(htmlentities($_POST['id']))); 
	$onlyconsonants = strtolower(str_replace($vowels, ",", $post_input));
	if(checkprefix($onlyconsonants,"potri")==true){
	$pattern = '/^[a-zA-Z]+[+]+[a-zA-Z0-9]+[.]+[0-9]?[0-9]$/';	
	}else{
	$pattern = '/^[a-zA-Z]+[a-zA-Z0-9]+[.]+[0-9]?[0-9]$/';
	}
	$flag=true;

	if(checkprefix($onlyconsonants,$tintinvariable)==true && checkprefix($onlyconsonants,"pot")==true){
		$flag=false;
		$geneids_array = explode(",", $onlyconsonants);
		$geneids_array_str=implode('","',$geneids_array);
		if(preg_match($pattern,$geneids_array[0])== true){
				$datatables->where($table_name.'.transcript_id in ',$geneids_array_str);
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

	if(checkprefix($onlyconsonants,"potris")==true   ){
		$flag=false;
		$geneids_array = explode(",", $onlyconsonants);
		$geneids_array_str=implode('","',$geneids_array);
			$pattern = '/^[a-zA-Z]+[.]+[a-zA-Z0-9]+[.]+[0-9]?[0-9]$/';
			if(preg_match($pattern,$geneids_array[0])== true){
				$datatables->where('transcript_potri.potri_id in ',$geneids_array_str);
			}else{
				$datatables->where('gene_populus.populus_gene_id in ',$geneids_array_str);
			}
	}

	if(checkprefix($onlyconsonants,"at")==true   ){
		$flag=false;
		
		$geneids_array = explode(",", $onlyconsonants);
		$geneids_array_str=implode('","',$geneids_array); 
		$datatables->where('gene_atg.atg_id in ',$geneids_array_str);
	}	

	if(checkprefix($onlyconsonants,"ma_")==true   ){
		$flag=false;
		$geneids_array = explode(",", $onlyconsonants);
		$geneids_array_str=implode('","',$geneids_array);
		$datatables->where('gene_spruce.spruce_gene_id in ',$geneids_array_str);
	}	

	if($flag==true &&  checkprefix($post_input,"Shared")==false  ){
		$post_input2=trim(htmlentities($_POST['id'])); 
		$datatables->where("(($table_name.description LIKE '%".$post_input2."%' ) OR (gene_atg.atg_description LIKE '%".$post_input2."%' ) OR (transcript_potri.potri_id LIKE '%".$post_input2."%' ) OR (gene_go.go_description LIKE '%".$post_input2."%' ) OR (gene_pfam.pfam_description LIKE '%".$post_input2."%' ) OR (gene_kegg.kegg_description LIKE '%".$post_input2."%') )"); 

	}
	
} 	

$mysqlcolumns=array('Gene'=>'ID','Transcript'=>'transcript_id','Chromosome'=>'chromosome_name','Description'=>'description','Poplar'=>'potri_id','ATG'=>'atg_id','KEGG'=>'kegg_description','ATG Description'=>'atg_description','GO'=>'go_description','PFAM'=>'pfam_description','Spruce'=>'ma_gene_id'  );

?>