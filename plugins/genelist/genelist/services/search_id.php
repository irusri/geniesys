<?php
include_once("config.php");
// MYSQL configuration

ini_set('memory_limit', '-1');
ini_set('max_execution_time', 300000);
if($_POST['add_genes']==true){
//echo ($datatables->generate);
global $user;
	if($user->uid!=0 ){
	//updategenebasket_testing($datatables->generate_genelist(),$_COOKIE['select_species']);
	}else{
		 if($allow_beta==true){
				updategenebasket_fast($datatables->generate_genelist(),$tintinvariable,$uuid);
		 }else{
			 //	updategenebasket_fast($datatables->generate_genelist(),$tintinvariable,$uuid);
			 	updategenebasket($datatables->generate_genelist());
			 }
	}
}

if($_POST['replace_genes']==true){

updategenebasket_fast($datatables->generate_genelist(),$tintinvariable,$uuid);

}

if($_POST['remove_genes']==true){

removegenebasket($datatables->generate_genelist());

}

if($_POST['add_new_genes']==true){

updategenebasketall($datatables->generate_genelist(),$_POST['add_new_genes_name']);

}




if($_POST['share_table']==true){

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
