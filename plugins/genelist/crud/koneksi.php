<?php
$path= dirname(__FILE__)."/../../settings.php";
//$pathA= $_SERVER['DOCUMENT_ROOT']."/plugins/settings.php";
//$pathB= dirname(__FILE__)."/../../../settings.php";
//if(file_exists($pathA)){$path=$pathA;}else{$path=$pathB;}
include_once($path);
global $db_url;
global $genelist_connection;
$private_url = parse_url($db_url['genelist']);
$genelist_connection=mysqli_connect($private_url['host'], $private_url['user'], $private_url['pass'],str_replace('/', '', $private_url['path'])) or die(mysqli_error());
mysqli_query($genelist_connection,"SET SESSION sql_mode = '".$db_settings['modes']."';");
//mysql_select_db(str_replace('/', '', $private_url['path'])) or die(mysql_error());
global $uuid;
?>
