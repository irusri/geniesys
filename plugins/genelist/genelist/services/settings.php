<?php
$path= dirname(__FILE__)."/../../../settings.php";
include($path);
global $db_url;
$private_url = parse_url($db_url['genelist']);
$genelist_connection=mysqli_connect($private_url['host'], $private_url['user'], $private_url['pass'],str_replace('/', '', $private_url['path'])) or die(mysqli_error());
?>
	 
