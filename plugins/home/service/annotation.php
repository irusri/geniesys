<?php
ini_set('memory_limit', '-1');
ini_set('max_execution_time', 300);

$host = trim($_POST['host']);
$username = trim($_POST['username']);
$password = trim($_POST['password']);
$database = trim($_POST['database']);
$get_action = $_POST['action'];
$get_name = $_POST['name'];


if($get_action=="check_files"){
 $data_dir=dirname(__FILE__)."/../../../data/";
 if (!file_exists($data_dir)) {
    mkdir($data_dir, 0777);
    exit;
} else {
    $files=scandir($data_dir, 1);
}

$scanned_directory = array_diff($files, array('..', '.'));
$required_files=array('cds.fa','gene.gff3','genome.fa','protein.fa','transcript.fa');
echo json_encode(array_diff($required_files, $scanned_directory));
}


?>