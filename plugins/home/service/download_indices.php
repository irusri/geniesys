<?php

ini_set('memory_limit', '-1');
ini_set('max_execution_time', 300);

$host=trim($_POST['host']);
$username=trim($_POST['username']);
$password=trim($_POST['password']);
$database=trim($_POST['database']);
$get_action=$_POST['action'];
$get_name=$_POST['name'];

function downloadZipFile($url, $filepath){
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_HEADER, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_BINARYTRANSFER, 1);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 0);
    $raw_file_data = curl_exec($ch);

    if(curl_errno($ch)){
       echo 'error:' . curl_error($ch);
    }
    curl_close($ch);

    file_put_contents($filepath, $raw_file_data);
    return (filesize($filepath) > 0)? true : false;
}

?>