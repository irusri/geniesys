<?php
$s=$_POST['settings'];
saveSettings($s);
/*if the settings file exist save the settings*/
function saveSettings($s){
	$file = @fopen('../../../genie_files/settings', 'w');
	if(!$file){
		echo "Error opening settings. Set correct permissions (644) to the settings file.";
		exit;
	}
	fwrite($file, $s);
	fclose($file);
}

?>