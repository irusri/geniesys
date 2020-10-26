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
//List all the required files here
$required_files=array('experiment.tsv','expression.tsv');

//Check required files at the begening
if($get_action=="check_files"){
    if (!file_exists($data_dir)) {
        mkdir($data_dir, 0777);
        exit;
    } else {
        $files=scandir($data_dir, 1);
    }
    $scanned_directory = array_diff($files, array('..', '.'));
    echo json_encode(array_diff($required_files, $scanned_directory));
}

// Load files into the database
if ($get_action == "load_files" && $get_name="experiment") {
    load_files($data_dir ."/experiment.tsv", 'experiment');
   
}
if ($get_action == "load_files" && $get_name="expression") {
    load_files($data_dir ."/expression.tsv", 'expression');
}


//Loading tables
function load_files($input_file,$table_name){
    include('../../../plugins/settings.php'); 
    $private_url = parse_url($db_url['genelist']);
    $conn = new mysqli($private_url['host'], $private_url['user'], $private_url['pass'], str_replace('/', '', $private_url['path']));
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } 	
  mysqli_options($conn, MYSQLI_OPT_LOCAL_INFILE, true);
  $query= <<<eof
  TRUNCATE TABLE $table_name;
  ALTER TABLE $table_name AUTO_INCREMENT = 1;
  LOAD DATA LOCAL INFILE '$input_file' ignore  INTO TABLE $table_name CHARACTER SET UTF8 fields terminated by '\t' LINES TERMINATED BY '\n' ignore 0 lines;
  eof;
      /* execute multi query */
      if (mysqli_multi_query($conn, $query)) {
      do {
          /* store first result set */
          if ($result = mysqli_store_result($conn)) {
              //do nothing since there's nothing to handle
              mysqli_free_result($result);
          }
          /* print divider */
          if (mysqli_more_results($conn)) {
              //I just kept this since it seems useful
              //try removing and see for yourself
          }
      } while (mysqli_next_result($conn));
      }
      mysqli_close($conn); 
  }


// check whther it has correct number of columns

// load it into the database

// check expression file

// Check it has correct number of coulmns

// load expression table into the database


?>