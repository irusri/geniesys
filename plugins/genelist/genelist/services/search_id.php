<?php
//Include config file
include_once("config.php");

ini_set('memory_limit', '-1');
ini_set('max_execution_time', 300000);
if($_POST['add_genes']==true){
//echo ($datatables->generate);
global $user;
	if($user->uid!=0 ){
	//updategenebasket_testing($datatables->generate_genelist(),$_COOKIE['select_species']);
	}else{
		 if($allow_beta==true){
				echo json_encode($datatables->generate_genelist(),$tintinvariable,$uuid);
		 }else{
			 	echo json_encode($datatables->generate_genelist());
		}
	}
}

if($_POST['replace_genes']==true){
	updategenebasket_2x($datatables->generate_genelist(),$tintinvariable,$uuid);
}

if($_POST['remove_genes']==true){
	removegenebasket($datatables->generate_genelist());
}

if($_POST['add_new_genes']==true){
	echo json_encode($datatables->generate_genelist());
}


if($_POST['share_table']==true){
	$randid = substr(number_format(time() * rand(), 0, '', ''), 0, 10000000);
	echo json_encode($datatables->generate_genelist());
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
