<?php 
include_once("config.php");	

ini_set('memory_limit', '-1');
ini_set('max_execution_time', 3000000);

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