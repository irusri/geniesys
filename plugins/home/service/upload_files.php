<?php
// Set cross domain header
header('Access-Control-Allow-Origin:*');
header('Access-Control-Allow-Methods:PUT,POST,GET,DELETE,OPTIONS');
header('Access-Control-Allow-Headers:x-requested-with,content-type');
header('Content-Type:application/json; charset=utf-8');

$file = isset($_FILES['file_data']) ? $_FILES['file_data']:null; // Segmented file
$name = isset($_POST['file_name']) ? $_POST['file_name']:null;  // file name to save
$total = isset($_POST['file_total']) ? $_POST['file_total']:0;// Total number of slices
$index = isset($_POST['file_index']) ? $_POST['file_index']:0;  // Current number of slices
$md5   = isset($_POST['file_md5']) ? $_POST['file_md5'] : 0; // md5 value of the file
$size  = isset($_POST['file_size']) ?  $_POST['file_size'] : null; // file size

// output json information
function jsonMsg($status,$message,$url=''){
   $arr['status'] = $status;
   $arr['message'] = $message;
   $arr['url'] = $url;
   echo json_encode($arr);
   die();
}

if(!$file || !$name){
	jsonMsg(0,'No file');
}

// Simply determine the file type
$info = pathinfo($name);

//get file suffix
$ext = isset($info['extension'])?$info['extension']:'';

/*  Determine file type
$imgarr = array('jpeg','jpg','png','gif');
if(!in_array($ext,$imgarr)){
    jsonMsg(0,'File type error');
}*/

//  In actual use, use md5 to name the file, which can reduce conflicts
$file_name = $name.'.'.$ext;
$newfile = 'upload/'.$file_name;

// file accessible address
$url = 'upload/'.$file_name;

/**  Determine whether to upload repeatedly **/
//clear file status
clearstatcache($newfile);


ini_set('upload_max_filesize', '500M');
ini_set('post_max_size', '500M');
ini_set('max_input_time', 10000);
ini_set('max_execution_time', 10000);

// The file size is the same, indicating that it has been uploaded
/*if(is_file($newfile) && ($size == filesize($newfile))){
   jsonMsg(3,'Already uploaded');          
}*/

/** Determine whether to upload repeatedly  **/
// check whether the file stream uploaded
if ($file['error'] == 0) {
    // Create if the file does not exist
    if (!file_exists($newfile)) {
        if (!move_uploaded_file($file['tmp_name'], $newfile)) {
            jsonMsg(0,'Cannot move file');
        }
        // the number of pieces is equal
        if($index == $total ){  
          jsonMsg(2,'upload completed');
        }        
        jsonMsg(1,'uploading');
    }     
    //  If the current number of pieces is less than or equal to the total number of pieces, continue to add after the file
    if($index <= $total){
        $content = file_get_contents($file['tmp_name']);
        if (!file_put_contents($newfile, $content, FILE_APPEND)) {
          jsonMsg(0,'Cannot write to file');
        }
        // the number of pieces is equal
        if($index == $total ){  
          exec("awk '$3==\"gene\"{split($9,c,/[;=]/);for(j=1;j in c;j+=2)l[c[j]]=c[j+1];g=$4\"\t\"$5;h=l[\"ID\"]}$3~/RNA$/{split($9,a,/[;=]/);for(i=1;i in a;i+=2)k[a[i]]=a[i+1]; print k[\"ID\"], h, \"desc\", $1, $7, g, \"\", \"\", $4, $5 }'  FS='\t' OFS='\t' ".$newfile." > ".$newfile."_transcript.tsv");
          exec("awk '/gene/{split($9,c,/[;=]/);for(j=1;j in c;j+=2)l[c[j]]=c[j+1];print l[\"Name\"],$1,$4,$5}' FS='\t' OFS='\t' ".$newfile." > ".$newfile."_gene.tsv");
          exec("awk '!/#/&&$3!~/gene/{split($9,a,/[;=]/);for(i=1;i in a;i+=2)k[a[i]]=a[i+1];($3!~/RNA$/?id=k[\"Name\"]:id=k[\"ID\"]);gsub(\"three_prime_UTR\",\"3UTR\",$3);gsub(\"five_prime_UTR\",\"5UTR\",$3);print id, $1, $3, $4, $5}' OFS='\t' ".$newfile." > ".$newfile."_color.tsv");

         load_files($newfile."_gene.tsv",'gene_info');
         load_files($newfile."_transcript.tsv",'transcript_info');
         load_files($newfile."_color.tsv",' sequence_color');
          unlink($newfile);
          jsonMsg(2,"done","url");
        }
        jsonMsg(1,'uploading');
    }               
} else {
    jsonMsg(0,'No file uploaded');
}

//Loading tables
function load_files($input_file,$table_name){
  //Build the connection
  include('../../../plugins/settings.php'); 
  $private_url = parse_url($db_url['genelist']);
  //print_r($private_url );
  $conn = new mysqli($private_url['host'], $private_url['user'], $private_url['pass'], str_replace('/', '', $private_url['path']));
  // Check connection
  if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
  } 	
mysqli_options($conn, MYSQLI_OPT_LOCAL_INFILE, true);
  //Truncate and load table	
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
