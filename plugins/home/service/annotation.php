<?php
ini_set('memory_limit', '-1');
ini_set('max_execution_time', 300);

$host = trim($_POST['host']);
$username = trim($_POST['username']);
$password = trim($_POST['password']);
$database = trim($_POST['database']);
$get_action = $_POST['action'];
$get_name = $_POST['name'];

$data_dir=dirname(__FILE__)."/../../../data/";
//List all the required files here
$required_files=array('cds.fa','gene.gff3','genome.fa','protein.fa','transcript.fa');

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

//Prepare GFF3 file
if ($get_action == "prepare_files") {
   // if(count(array_diff($required_files, $scanned_directory))==0){
        exec("awk '$3==\"gene\"{g=$4\" \"$5}$3~/RNA$/{split($9,a,/[;=]/);for(i=1;i in a;i+=2)k[a[i]]=a[i+1]; print k[\"ID\"], k[\"Parent\"], \"desc\", $1, $7, $4, $5, g}' " . $data_dir ."/gene.gff3  >" . $data_dir. "/transcript.tsv");
        exec("awk '/gene/{split($9,a,\"ID=\");split(a[2],b,\";\");print b[1],$1,$4,$5}' FS='\t' OFS='\t' " . $data_dir ."/gene.gff3 >" . $data_dir . "/gene.tsv");
    //}
    echo json_encode("testing");
}

// Load files into the database
if ($get_action == "load_files") {
    load_files($data_dir ."/gene.tsv", 'gene_info');
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
  