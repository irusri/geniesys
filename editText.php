<?php
/**
 * @author		Chanaka Mannapperuma <irusri@gmail.com>
 * @date		2017-03-04
 * @version		Beta 1.0
 * @usage		Security settings for GenIE-Sys
 * @licence		GNU GENERAL PUBLIC LICENSE
 * @link		https://geniecms.org
 */
session_start();
$fieldname = $_REQUEST['fieldname'];
$encrypt_pass = @file_get_contents('genie_files/password');
if($_SESSION['l']!=$encrypt_pass){
	header('HTTP/1.1 401 Unauthorized');
	exit;
}

$content = trim(rtrim(stripslashes($_REQUEST['content'])));

$file = @fopen("genie_files/$fieldname", "w");
if(!$file){
	echo "Editing failed. Set correct permissions (755) to the 'genie_files' folder.";
	exit;
}

fwrite($file, $content);
fclose($file);
echo $content;
?>