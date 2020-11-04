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
    annoyingrequest();
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
        exec("awk '$3==\"gene\"{split($9,c,/[;=]/);for(j=1;j in c;j+=2)l[c[j]]=c[j+1];g=$4\"\t\"$5;h=l[\"ID\"]}$3~/RNA$/{split($9,a,/[;=]/);for(i=1;i in a;i+=2)k[a[i]]=a[i+1]; print k[\"Name\"], h, \"desc\", $1, $7, g, \"\", \"\", $4, $5 }'  FS='\t' OFS='\t' ".$data_dir ."/gene.gff3  >" . $data_dir. "/transcript.tsv");
        exec("awk '/gene/{split($9,c,/[;=]/);for(j=1;j in c;j+=2)l[c[j]]=c[j+1];print l[\"Name\"],$1,$4,$5}' FS='\t' OFS='\t' ". $data_dir ."/gene.gff3 >" . $data_dir . "/gene.tsv");
        exec("awk '!/#/&&$3!~/gene/{split($9,a,/[;=]/);for(i=1;i in a;i+=2)k[a[i]]=a[i+1];($3!~/RNA$/?id=k[\"Name\"]:id=k[\"ID\"]);gsub(\"three_prime_UTR\",\"3UTR\",$3);gsub(\"five_prime_UTR\",\"5UTR\",$3);print id, $1, $3, $4, $5}' OFS='\t' ". $data_dir ."/gene.gff3 >" . $data_dir . "/color.tsv");
        echo json_encode("Done!");
}

// Load files into the database
if ($get_action == "load_files") {
    load_files($data_dir ."/gene.tsv", 'gene_info');
    load_files($data_dir ."/transcript.tsv", 'transcript_info');
    load_files($data_dir ."/color.tsv", 'sequence_color');
    sleep(6);
    unlink($data_dir ."/gene.tsv");
    unlink($data_dir ."/transcript.tsv");
    unlink($data_dir ."/color.tsv");
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
  
  // Generate indices for BLAST and sequence search tool
if ($get_action == "generate_indices") {
     $blast_dir=$data_dir."/blast"; 
    if (!file_exists($blast_dir)) {
        mkdir($blast_dir, 0777);
    } 
    exec("../../blast/services/scripts/bin/formatdb -p F -i ".$data_dir."/genome.fa -n ".$blast_dir."/genome -o T");
    exec("../../blast/services/scripts/bin/formatdb -p F -i ".$data_dir."/transcript.fa -n ".$blast_dir."/transcript -o T");
    exec("../../blast/services/scripts/bin/formatdb -p F -i ".$data_dir."/cds.fa -n ".$blast_dir."/cds -o T");
    exec("../../blast/services/scripts/bin/formatdb -p T -i ".$data_dir."/protein.fa -n ".$blast_dir."/protein -o T");

    chmod($blast_dir, 0777);

    echo "done!";
  }


//Update gene_i in annotation tables
if ($get_action == "update_gene_i") {
//"gene_pfam", "gene_go", "gene_kegg","gene_maize",
$gene_annotation_table_array = array(  "gene_pfam","gene_go", "gene_kegg","transcript_info","gene_populus","gene_spruce","gene_atg");     
include('../../../plugins/settings.php'); 
$private_url = parse_url($db_url['genelist']);
$conn = new mysqli($private_url['host'], $private_url['user'], $private_url['pass'], str_replace('/', '', $private_url['path']));
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 	
for($i=0;$i<count($gene_annotation_table_array);$i++){
    $gene_annotation_sql="UPDATE $gene_annotation_table_array[$i] INNER JOIN gene_info on gene_info.gene_id = $gene_annotation_table_array[$i].gene_id SET $gene_annotation_table_array[$i].gene_i = gene_info.gene_i;";
        
        if ($conn->query($gene_annotation_sql) === TRUE) {
            echo "gene_i updated in $gene_annotation_table_array[$i]";
        } else {
            echo "Error updating table: ".$gene_annotation_table_array[$i]." " . $conn->error;
        }	
    }
    /* close connection */
    mysqli_close($conn);
  }

  // Load description both transcripts and genes
  if ($get_action == "update_description") {
    load_description($data_dir ."/gene_description.tsv","gene_info","gene_id");
    load_description($data_dir ."/transcript_description.tsv","transcript_info","transcript_id");
  }

// Function to load the description
function load_description($file_name,$table_name,$field_name){  
    include('../../../plugins/settings.php'); 
    $private_url = parse_url($db_url['genelist']);
    $conn = new mysqli($private_url['host'], $private_url['user'], $private_url['pass'], str_replace('/', '', $private_url['path']));
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } 	
  mysqli_options($conn, MYSQLI_OPT_LOCAL_INFILE, true);
  $query= <<<eof
  DROP TEMPORARY TABLE IF EXISTS tmp_tb;
  UPDATE $table_name SET description = '';
  CREATE TEMPORARY TABLE tmp_tb(gene_name VARCHAR(255),annotation VARCHAR(500), PRIMARY KEY(gene_name)) ENGINE=MyISAM;
  LOAD DATA LOCAL INFILE '$file_name' replace INTO TABLE tmp_tb CHARACTER SET UTF8 fields terminated by '\t' LINES TERMINATED BY '\n' ignore 0 lines;
  UPDATE $table_name INNER JOIN tmp_tb on tmp_tb.gene_name = $table_name.$field_name SET $table_name.description = tmp_tb.annotation;
  DROP TEMPORARY TABLE tmp_tb;
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

// Load extra annotation
if ($get_action == "load_extra_annotations") {
    load_files($data_dir ."/gene_go.tsv", 'gene_go');
    load_files($data_dir ."/gene_pfam.tsv", 'gene_pfam');
    load_files($data_dir ."/gene_kegg.tsv", 'gene_kegg');

}


// Load best BLAST
if ($get_action == "load_best_blast") {
    load_files($data_dir ."/gene_populus.tsv", 'gene_populus');
    load_files($data_dir ."/gene_spruce.tsv", 'gene_spruce');
    load_files($data_dir ."/gene_arabidopsis.tsv", 'gene_atg');
}


// Annoying resuqest


function annoyingrequest() { 
    $data_dir="../../blast/services/scripts";
    if (!file_exists($data_dir."/bin")) {
        $data_dir="../../blast/services/scripts";
        $zip_file="bin.zip";
        download__compressed("http://build.plantgenie.org/tmp/dump/bin.zip",$zip_file,$data_dir);
    }else{
        //echo "b";
    }
}

function download__compressed($url,$zipFile,$extractDir){
	$zipResource = fopen($zipFile, "w");

	// Get The Zip File From Server
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_FAILONERROR, true);
	curl_setopt($ch, CURLOPT_HEADER, 0);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
	curl_setopt($ch, CURLOPT_AUTOREFERER, true);
	curl_setopt($ch, CURLOPT_BINARYTRANSFER,true);
	curl_setopt($ch, CURLOPT_TIMEOUT, 10);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0); 
	curl_setopt($ch, CURLOPT_FILE, $zipResource);

	$page = curl_exec($ch);

	if(!$page) {
		echo "Error :- ".curl_error($ch);
	}

	curl_close($ch);

	/* Open the Zip file */
	$zip = new ZipArchive;
	$extractPath = $extractDir;

	if($zip->open($zipFile) != "true"){
		echo "Error :- Unable to open the Zip File";
	} 

	/* Extract Zip File */
	$zip->extractTo($extractPath);
    $zip->close();
    unlink($zipFile);

    chmodifyr($extractPath."/bin");
  
	//die('Your file was downloaded and extracted '.$extractPath.', go check.');
}


function chmodify($obj) {
    $chunks = explode('/', $obj);
    chmod($obj, is_dir($obj) ? 0755 : 0755);
    chown($obj, $chunks[2]);
    chgrp($obj, $chunks[2]);
   
 }


 function chmodifyr($dir) 
 {
    if($objs = glob($dir."/*")) {        
        foreach($objs as $obj) {
            chmodify($obj);
            if(is_dir($obj)) chmodifyr($obj);
        }
    }
   
  //  return chmodify($dir);
 }   