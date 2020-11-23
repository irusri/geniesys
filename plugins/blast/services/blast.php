<?php
/*Process POST variables and attach to blast variable string*/
$tmp_array=array();
$tmp_random_id=get_random_id();
$par="scripts/bin/blastall -m 7 -a 3 "; 
$par2="scripts/bin/fastacmd ";
foreach($_POST as $name => $value) {
	array_push($tmp_array,"$name : $value");
	switch ($name) {
		case 'database_type':
			if(check_plain($value)=="blastp" || check_plain($value)=="blastx"){$t_p='T';}else{$t_p='F';}
			$par .= ' -p '. check_plain($value);
			$par2 .= ' -p '.$t_p ;
			$program_name=check_plain($value);
		break;		
		case 'advanced_parameters_scoring_matrix':
			$par .= ' -M '. check_plain($value);
		break;
		case 'advanced_parameters_low_complexity_regions':
			if($value=="true"){
			$par .= ' -F T ';}else{$par .= ' -F F ';}
		break;
		case 'advanced_parameters_filtering_lower_case_letters':
			if($value=="true"){
			$par .= ' -U T ';}
		break;
		case 'advanced_parameters_e_value_cutoff':
			$par .= ' -e '. check_plain($value);
		break;				
		case 'advanced_parameters_e_value_cutoff_BLAST_options_ungapped':
			if($value=="true" && $program_name!="tblastx"){
			$par .= ' -g F ';}
		break;
		case 'advanced_parameters_options_megablast':
			if($value=="true" && $program_name=="blastn"){
			$par .= ' -n T ';}
		break;
		case 'advanced_parameters_genetic_code':
        	$par .= ' -Q '. check_plain($value);
        break;
     	case 'advanced_parameters_DB_genetic_code':
        	$par .= ' -D '. check_plain($value);
        break;
      	case 'advanced_parameters_word_size':
        	$par .= ' -W '. check_plain($value);
        break;
      	case 'advanced_parameters_Frame_shift_penalty':
        	$par .= ' -w '. check_plain($value);
        break;
      	case 'advanced_parameters_number_of_results':
        	$par .= ' -b '. check_plain($value) .' -v '. check_plain($value);
        break; 
		case 'selected_datasets':
			$tmp_datasets=explode(",",check_plain($value));
        	$par .= " -d '";
			$par2 .=" -d '";
			/*Read the config.json file to get dataset path(s) based on selected dataset number(s)*/
			$string = file_get_contents("../../config.json");
			$json_a = json_decode($string, true);
			foreach ($json_a['datasets'] as $name => $value) {
				for($k=0;$k<count($tmp_datasets);$k++){
					if(json_encode($value['number'])==$tmp_datasets[$k]){
						$par .= dirname(__FILE__)."/../../../".$value['dataset_path']." ";
						$par2 .= dirname(__FILE__)."/../../../".$value['dataset_path']." ";
						}
				}
				
			}
			$par .= "'";
			$par2 .= "'";
			$par2 .=' -o ../tmp/'.$tmp_random_id.'.fasta -s ';
			if (!file_exists('../tmp')) {
    			mkdir('../tmp', 0777, true);
			}
			$my_submission_file = $tmp_random_id.'.submission';
			$handle_submission = fopen('../tmp/'.$my_submission_file, 'w') or die('Cannot open file:  '.$my_submission_file); //open file for writing ('w','r','a')...
			$data_to_write_submission = trim($par2);
			fwrite($handle_submission, $data_to_write_submission);
			fclose($handle_submission);
		break;
		case 'query_sequence_text':
		if (!file_exists('../tmp')) {
    			mkdir('../tmp', 0777, true);
		}
		$my_query_file = $tmp_random_id.'.query';
		$handle = fopen('../tmp/'.$my_query_file, 'w') or die('Cannot open file:  '.$my_query_file); //open file for writing ('w','r','a')...
		$data_to_write = trim($value);
		fwrite($handle, $data_to_write);
		fclose($handle);
		$par .= ' -i ../tmp/'.$my_query_file.' -o ../tmp/'.$tmp_random_id.'.output';
		break;
	}
}
exec("tsp ".$par,$queue_id);
$return_array=array('uuid'=>$tmp_random_id,'qid'=>$queue_id,'program'=>$program_name);
echo json_encode($return_array);

function check_plain($text) {
  return htmlspecialchars($text, ENT_QUOTES, 'UTF-8');
}

function get_random_id() {
    return sprintf( '%04x%04x%04x%04x%04x%04x%04x%04x',
        mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ),
        mt_rand( 0, 0xffff ),
        mt_rand( 0, 0x0fff ) | 0x4000,
        mt_rand( 0, 0x3fff ) | 0x8000,
        mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff )
    );
}

?>