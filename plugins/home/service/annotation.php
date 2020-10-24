<?php
ini_set('memory_limit', '-1');
ini_set('max_execution_time', 300);

$host = trim($_POST['host']);
$username = trim($_POST['username']);
$password = trim($_POST['password']);
$database = trim($_POST['database']);
$get_action = $_POST['action'];
$get_name = $_POST['name'];

 $data_dir=dirname(__FILE__)."/../../../data";
 if (!file_exists($data_dir)) {
    mkdir($data_dir, 0777);
    echo "The data directory was successfully created.";
    exit;
} else {
    echo "The data directory exists.";
    $files=scandir($data_dir);
}

?>