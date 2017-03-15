<?php
$post_id=trim($_POST['id']);
include('settings.php'); 
$table_name="transcript_info"; 
$id_type="";
 

//Initial check whether given ID exsist on our Database
if(isset($post_id) && $post_id != ''){
	$initcheck=mysqli_query($genelist_connection,"SELECT * FROM ".$table_name." WHERE transcript_id='$post_id' or gene_id='$post_id'");
	if(mysqli_num_rows($initcheck)!=0){
		$init_id = strtolower($post_id);
		$pattern = '/^[a-zA-Z0-9]+[.]+[a-zA-Z0-9]+[.]+[0-9]?[0-9]$/';
		if(preg_match($pattern,$init_id)== true){
			$id_type="transcript";
		}else{
			$id_type="gene";  
		}
	}else{
			$id_type="invalid id";
		}
}
//When id is transcript or gene
if($id_type=="transcript" ||  $id_type=="gene"){
	$basic_results = mysqli_query($genelist_connection,"SELECT ".$table_name.".*,potri_id,atg_id FROM ".$table_name." 
	left join transcript_atg on ".$table_name.".transcript_i=transcript_atg.transcript_i
	left join transcript_potri on ".$table_name.".transcript_i=transcript_potri.transcript_i
	WHERE ".$table_name.".transcript_id='$post_id' or ".$table_name.".gene_id='$post_id' limit 1");
	error_reporting(0);
	$g = 0;
	while ($basic_results_rows = mysqli_fetch_array($basic_results)) {
		$tmp_geneid=$basic_results_rows['gene_id'];
		$children[$g]->gene_id=$basic_results_rows['gene_id'];		
		$basic_results_tids = mysqli_query($genelist_connection,"SELECT transcript_id FROM ".$table_name." WHERE gene_id='$tmp_geneid'");
		while ($basic_results_rows_tids = mysqli_fetch_array($basic_results_tids)) {
			if($basic_results_rows_tids['transcript_id']!=$post_id){
			$tmp_tids.=$basic_results_rows_tids['transcript_id'].' ';
			}
		}
		$children[$g]->transcript_id=$basic_results_rows['transcript_id'];
		
		$children[$g]->other_transcripts=$tmp_tids;
		$children[$g]->description=$basic_results_rows['description'];
		$children[$g]->chromosome_name=$basic_results_rows['chromosome_name'];
		$children[$g]->strand=$basic_results_rows['strand'];
		
		$children[$g]->gene_start=$basic_results_rows['gene_start'];
		$children[$g]->gene_end=$basic_results_rows['gene_end'];
		
		$children[$g]->pac_id=$basic_results_rows['pac_id'];
		$children[$g]->peptide_name=$basic_results_rows['peptide_name'];
		$children[$g]->transcript_start=$basic_results_rows['transcript_start'];
		$children[$g]->transcript_end=$basic_results_rows['transcript_end'];
		
		$children[$g]->potri_id=$basic_results_rows['potri_id'];
		$children[$g]->atg_id=$basic_results_rows['atg_id'];
		
		$children[$g]->input_type=$id_type;
		$children[$g]->input_id=$post_id;
		$ret[] = $children[$g];
		$g++;
	}
}
	

	
//When id is an invalid 	
if($id_type=="invalid id"){
	}	

if($ret!=null){
	$arrsg = array ('basic_data'=>$ret); 
}else{
	$arrsg = array ('error'=>$post_id);
}
echo json_encode($arrsg);
	
	
  
######################################################################
//Check prefix
######################################################################
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



?>