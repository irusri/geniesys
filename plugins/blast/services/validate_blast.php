<?php
$uuid=$_POST['uuid'];
$qid=$_POST['qid'];
$program=$_POST['program'];

//sleep(10);
if(isset($uuid)){
	$tmp_resultfile="../tmp/".$uuid.".output";
	
	if(file_exists($tmp_resultfile) && filesize($tmp_resultfile) > 0) {
		$tmp_table=blast_result_xml($tmp_resultfile);
		//echo getcwd();
      if(file_exists($tmp_resultfile.'.html')==false){
      		exec('perl scripts/htmlwriter.pl '.$tmp_resultfile.' > '.$tmp_resultfile.'.html'); 
          ##BLAST to gff3
          exec('perl scripts/parseBlastBestHitLocSeq.pl '.$tmp_resultfile.' > '.$tmp_resultfile.'.tab');
          exec('(cat '.$tmp_resultfile.'.tab |sort -k1,1 | perl scripts/blast92gff3.pl > '.$tmp_resultfile.'.gff)');
          exec('sh scripts/awk_script.sh '.$tmp_resultfile.'.gff '.$tmp_resultfile.'.gff2');
          exec('mv '.$tmp_resultfile.'.gff2 '.$tmp_resultfile.'.gff');
          //unlink($tmp_resultfile.'.tab');
          ##BLAST2 gff3
      		if( $program!= 'blastp' && $program != 'tblastn'  ){
      			exec('xsltproc --novalid blast2svg2.xsl '.$tmp_resultfile.' > '.$tmp_resultfile.'.svg '); 
      		}
        }
		delete_old_files();
    $read_map=file_get_contents($tmp_resultfile.".txt");
	

	$config_path = file_get_contents($_SERVER['DOCUMENT_ROOT']."/plugins/config.json");
	$json_path = json_decode($config_path, true);
	$replacements=$json_path['default_jbrowse_dataset_directory'];
	$read_map2= str_replace("jbrowse_dataset_directory", $replacements, $read_map);
	

		$return_array=array('uuid'=>$uuid,'table'=>$tmp_table,'read_map'=>$read_map2);
		echo json_encode($return_array);
		
	//echo $uuid;
	}else{
		if(isset($qid)){
			exec("tsp -c ".$qid,$tmp_path);
			echo $tmp_path[0];
		}else{

      echo "error";
    }
		
		}
	
}

function delete_old_files(){
	/** define the directory **/
	$dir = "../tmp/";
	
	/*** cycle through all files in the directory ***/
	foreach (glob($dir."*") as $file) {
	
	/*** if file is 24 hours (86400 seconds) old then delete it ***/
	if (filemtime($file) < time() - 8640) {
		unlink($file);
		}
	}
	
	}

function blast_result_xml($outfile) {
  $result_array = array();
  if (!file_exists($outfile)) {
    echo "error";
    return FALSE;
  }
  $xml_in    = simplexml_load_file($outfile, 'SimpleXMLElement');
  $algorithm = (string)$xml_in->BlastOutput_program;
  $xml       = $xml_in->BlastOutput_iterations;
  //is either an object (one query) or an array. so convert to array.
  $array_iterations = get_object_vars($xml);
  $array_iterations = $array_iterations['Iteration'];
  if (is_object($array_iterations)) {
    $array_iterations = array(0 => $array_iterations);
  }
  $query_rank;
  foreach ($array_iterations as $iteration_obj) {
    $query_rank++;
    $query_id           = '';
    $name_of_hit        = '';
    $accession_of_hit   = '';
    $average_bit_score  = '';
    $top_bit_score      = '';
    $average_evalue     = '';
    $lowest_evalue      = '';
    $average_identity   = '';
    $average_similarity = '';
    // we need array-ize to get query_id
    $iteration_data_array = get_object_vars($iteration_obj);

    $query_id = $iteration_data_array['Iteration_query-ID'] .' '. $iteration_data_array['Iteration_query-def'];
    $query_id = preg_replace('/\s*lcl\|\d+_\d+\s*/', '', $query_id);
   // $query_id = preg_replace('/\s*lcl\|s*/', '', $query_id);
    //$query_id = preg_replace('/\s*lcl\|s*/', '', $query_id);
	//$query_id = str_ireplace('T', 'u', $query_id);
    $query_id = str_replace('No definition line found', '', $query_id);
    if (empty($query_id)) {
      $query_id = "User query $query_rank";
    }
    if (!empty($iteration_data_array['Iteration_message'])) {
     // drupal_set_message(t('%a : %b for %query_id', array('%query_id' => $query_id, '%a' => $algorithm, '%b' => $iteration_data_array['Iteration_message'])), 'error');
    }
    $hit_iteration_hits = $iteration_data_array['Iteration_hits'];
    if (empty($hit_iteration_hits)) {
      continue;
    }

    $hits_array = get_object_vars($hit_iteration_hits);
    //dvm($hits_array);
    $hits_array = $hits_array['Hit'];
    if (is_object($hits_array)) {
      $hits_array = array(0 => $hits_array);
    }
    //dvm($hits_array);

    foreach ($hits_array as $rank0 => $hit_object) {
      // cast objects as strings to avoid extra lines of code
      $name_of_hit        = (string)$hit_object->Hit_id;
      $name_of_hit = preg_replace('/\s*lcl\|s*/', '', $name_of_hit);
      $accession_of_hit   = (string)$hit_object->Hit_accession;
      $description_of_hit = (string)$hit_object->Hit_def;
      if ($description_of_hit == 'No definition line found') {
        $description_of_hit = '';
      }
      //HACK
      if (!empty($description_of_hit) && (strpos($name_of_hit,'ORD_ID'))){
          $name_of_hit=$description_of_hit;
      }
      $hsps_array = get_object_vars($hit_object->Hit_hsps);
      // cannot get Hit_hsps->Hsp directly, because if HSP is an array, then get_object_vars only returns first element of array
      // so get Hit_hsps only. Then retrieve second element of resulting array (first is the XML key)
      $hsps_array = $hsps_array['Hsp'];
      // result is sometimes an array (multiple HSPs) and sometimes an object (one HSP)
      // So check
      if (is_object($hsps_array)) {
        // then one HSP and we got first HSP object directly. Convert to an array with one key.
        $hsps_array = array(0 => $hsps_array);
      }
      //$hsps_array is now an array of objects, each object is an hsp, key is hsp_rank.
      $total_bit_score  = 0;
      $total_evalue     = 0;
      $hsp_number       = 0;
      $total_identity   = 0;
      $total_similarity = 0;
      foreach ($hsps_array as $hsp_rank => $hsp_obj) {
        $hsp_data = get_object_vars($hsp_obj);
        //dpm($hsp_data);
        $bit_score  = $hsp_data['Hsp_bit-score'];
        $aln_length = $hsp_data['Hsp_align-len'];
        $evalue     = $hsp_data['Hsp_evalue'];
        if (!empty($aln_length)) {
          $identity = $hsp_data['Hsp_identity'] / $aln_length;
          $similarity = $hsp_data['Hsp_positive'] / $aln_length;
        }
        $total_bit_score += $bit_score;
        $total_evalue += $evalue;
        $total_identity += $identity;
        $total_similarity += $similarity;
        $hsp_number++; 
        if (empty($lowest_evalue) || $evalue < $lowest_evalue) {
          $lowest_evalue = $evalue;
        }
        if (empty($top_bit_score) || $bit_score > $top_bit_score) {
          $top_bit_score = $bit_score;
        }
      }
      $lowest_evalue = sprintf('%.2e', $lowest_evalue);
      $average_bit_score = $hsp_number ? sprintf('%.2f', $total_bit_score / $hsp_number) : 'NA';
      $average_evalue = $hsp_number ? sprintf('%.2e', $total_evalue / $hsp_number) : 'NA';
      $top_bit_score = sprintf('%.2f', $top_bit_score);
      $average_identity = $hsp_number ? sprintf('%.2f %%', $total_identity * 100 / $hsp_number) : 'NA';
      $average_similarity = $hsp_number ? sprintf('%.2f %%', $total_similarity * 100 / $hsp_number) : 'NA';
     // $result_array[$rank0]= array(
	   $result_array[$query_id][$rank0 + 1] = array(
        'query_id' => $query_id ,
        'name_of_hit' => $name_of_hit,
        'accession_of_hit' => $accession_of_hit,
        'average_bit_score' => $average_bit_score,
        'top_bit_score' => $top_bit_score,
        'average_evalue' => $average_evalue,
        'lowest_evalue' => $lowest_evalue,
        'average_identity' => $average_identity,
        'average_similarity' => $average_similarity,
        'query_rank' => $query_rank,
      );
    }
  }
  $result = array();
foreach ($result_array as $array) {
    $result = array_merge($result, $array);
}
 return $result;
}
/*if(isset($qid) && isset($uuid)){
	exec("tsp -s ".$qid,$tmp_path);
	if($tmp_path[0]=="finished"){
			$resultfile="../tmp/".$uuid.".output";
			if(file_exists($resultfile) && filesize($resultfile) > 0) {
				echo $uuid;
			}
			//exec("tsp -i ".$qid,$error_text);
			//$error.=json_encode($error_text);
		}

}*/

/*if(isset($uuid)){
	echo getcwd() ;
	$error.="empty output";
}
echo $error;*/
?>