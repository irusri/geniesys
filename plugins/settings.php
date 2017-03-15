<?php
/*Here you can listed genie databases that you are going to use for different genomes and their corresponding species names. eg: "database_1" => "species 1",*/
global $db_species_array;
$db_species_array=array("egrandis_demo"=>"species 1","egrandis_demo"=>"species 2");

/*Here you can listed background colors correspond to each species. eg: "database_1" => "#FF0000",*/
global $db_species_color_array;
$db_species_color_array=array("egrandis_demo"=>"#86c0a6","egrandis_demo"=>"#83afae");


/*You dont need to change anything here*/
$db_key_array=array_keys($db_species_array);
$db_values_array=array_values($db_species_array);

if(isset($_COOKIE['genie_select_species'])) {
    $selected_database=$_COOKIE['genie_select_species'];
} else {
    $selected_database=$db_key_array[0];
	$_COOKIE['genie_select_species']=$db_key_array[0];
}

/*Please state the mysql username and password for above databases. It's important to grant only SELECT permissio to all the tables except defaultgenebaskets and genebasket tables*/
global $db_url;
$db_url=  array ('genelist'=>'mysqli://geniecms:geniepass@spruce.plantphys.umu.se/'.$selected_database);

/*Define your base url with trailing slash*/
$GLOBALS["base_url"]='http://localhost:3000';

/*You dont need to change anything here*/
global $uuid;
if ( isset($_SERVER["REMOTE_ADDR"]) )    {
    $ip = '' . $_SERVER["REMOTE_ADDR"] . '';
} else if ( isset($_SERVER["HTTP_X_FORWARDED_FOR"]) )    {
    $ip = '' . $_SERVER["HTTP_X_FORWARDED_FOR"] . '';
} else if ( isset($_SERVER["HTTP_CLIENT_IP"]) )    {
    $ip = '' . $_SERVER["HTTP_CLIENT_IP"] . '';
}

$uuid =$_COOKIE['fingerprint'];
?>
