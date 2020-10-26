<?php
ini_set('memory_limit', '-1');
ini_set('max_execution_time', 300);

$host = trim($_POST['host']);
$username = trim($_POST['username']);
$password = trim($_POST['password']);
$database = trim($_POST['database']);
$get_action = $_POST['action'];
$get_name = $_POST['name'];

// data directory
$data_dir=dirname(__FILE__)."/../../../data/";

//Check experiment file

// check whther it has correct number of columns

// load it into the database

// check network file

// Check it has correct number of coulmns

// load network table into the database

?>