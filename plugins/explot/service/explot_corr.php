<?php

#####################################
//Header variables and GET parameters
//2017/01/08- Chanaka Mannapperuma
#####################################
header('Cache-Control: no-cache');
header('Pragma: no-cache');
$primaryGene = trim($_GET['primaryGene']);
$sample = trim($_GET['sample']);
$view = trim($_POST['private_view']);
$expression_table="expression_exatlas_".$view;
$t_ids = $_POST['ids'];
$threshold = trim($_POST['threshold']);
$plus_minus_corr = trim($_POST['plus_minus_corr']);


$post_array = array();
foreach($_POST as $k => $v) {
	$post_array[trim($k)] = trim($v);
	
}


$input_cordinates="23,".$t_ids ;//"23,5.3677,5.5060,6.9868,7.2164,7.1324,5.0339,4.7546,5.5053";
//$database_table=$expression_table;
//$input_cordinates="23,5.3677,5.5060,6.9868,7.2164,7.1324,5.0339,4.7546,5.5053";
//$expression_table="expression_experiment_2";
if($plus_minus_corr==true){
	$ascending_order="true";
}else{
	$ascending_order="false";
}
//$ascending_order=$plus_minus_corr;
$number_of_results=16;


//echo "Rscript calculate_cor.R ".$input_cordinates." ".$database_table." ".$ascending_order." ".$number_of_results;

exec("Rscript calculate_cor.R ".$input_cordinates." ".$expression_table." ".$ascending_order." ".$number_of_results,$output);//.$random_id. " ".$hierarcial_clustering." ".$distance_function);


//echo json_encode($output, JSON_UNESCAPED_SLASHES);
//print_r($output);
$tmp_arr=array();
$corr_genes=array();
$corr_genes=json_decode($output[0], true);
for($i=0;$i<count($corr_genes);$i++){
	if($corr_genes[$i]["corr"]>$threshold){
	$tmp_arr[]=$corr_genes[$i]["gene2"];
	}
}
	
if(count($tmp_arr)<201){
$new_array=getdata($tmp_arr,$expression_table);
print json_encode($new_array);
}else{
print json_encode("exceeded");	
}

function getdata($primaryGenes,$expression_table){
mysql_connect("localhost", "popuser", "poppass") or die(mysql_error());
mysql_select_db("eucgenie_egrandis_v2") or die(mysql_error());
$result = array();
$result2 = array();

$geneids_array = $primaryGenes;//explode(",", $primaryGenes);
for($t=0;$t<count($geneids_array);$t++){
/*if(checkprefix($geneids_array[$t],"Esu")==true){
$resultprobeset = mysql_query("SELECT * FROM $source_view WHERE id='$geneids_array[$t]' order by sample;")
or die(mysql_error());
}else{*/
	$sorting_fild=" group by sample";
	if($expression_table=="expression_experiment_2"){
		$sorting_fild="order by FIELD(sample, 'phloem_TTGT', 'matureleaf_TTGT', 'phloem_GCTT', 'matureleaf_GCTT', 'immature_xylem_2','phloem_CACT','matureleaf_CACT','immature_xylem_4')";
	}
	if($expression_table=="expression_experiment_3"){
		$sorting_fild="order by FIELD(sample, 'rep1', 'GCTT', 'rep2', 'CACT', 'rep3','TTGT')";
	}
	
	if($expression_table=="expression_experiment_4"){
		$sorting_fild="order by FIELD(sample, 'TTGT_stage1', 'TTGT_stage2', 'GCTT_stage3', 'CACT_stage1', 'GCTT_stage2','TTGT_stage3','GCTT_stage1','CACT_stage2','CACT_stage3')";
	}
	
	if($expression_table=="expression_experiment_1"){
		$sorting_fild="order by FIELD(sample, 'xylem', 'immature_xylem', 'phloem', 'mature_leaf','young_leaf', 'shoot_tips')";
	}

	
	$resultprobeset = mysql_query("SELECT DISTINCT sample,id,log2 FROM $expression_table WHERE id='$geneids_array[$t]' $sorting_fild;")	or die(mysql_error());

	/*$pattern = '/^[a-zA-Z0-9]+[.]+[a-zA-Z0-9]+[.]+[0-9]?[0-9]$/';
		if(preg_match($pattern,$geneids_array[$t])== true){
			$newpattern = '/^[a-zA-Z0-9]+[.]+[a-zA-Z0-9]+[.]+[0-9]$/';
			if(preg_match($newpattern,$geneids_array[$t])== true){
				$newid= substr_replace($geneids_array[$t], "", -2);
				$resultprobeset = mysql_query("SELECT DISTINCT sample,id,log2 FROM $expression_table WHERE id='$newid' $sorting_fild;")	or die(mysql_error());
			}else{
				$newid2= substr_replace($geneids_array[$t], "", -3);
				$resultprobeset = mysql_query("SELECT DISTINCT sample,id,log2 FROM $expression_table WHERE id='$newid2' $sorting_fild;")	or die(mysql_error());
			}
		}else{
			$resultprobeset = mysql_query("SELECT DISTINCT sample,id,log2 FROM $expression_table WHERE id='$geneids_array[$t]' $sorting_fild;")	or die(mysql_error());
		}*/
//}



$rows = array();
$rows2 = array();
//$tmpsamples="";
$rows['name'] = $geneids_array[$t];
while ($rowPROBE_ID = mysql_fetch_assoc($resultprobeset)) {
	$rows['data'][]=(float)$rowPROBE_ID['log2'];
	//if($rowPROBE_ID['sample']!=""){
	//$rows['samples'][]=$rowPROBE_ID['sample'];
	$rows2['sample'][]=str_replace('_', ' ',ucfirst($rowPROBE_ID['sample']));
	//$rows['samples'].=$rowPROBE_ID['sample'];
	
	
	
	//}
}

	

		
array_push($result,$rows);
	
	//array_push($result,"draggableY:draggableY");

array_push($result2,$rows2);
}
$result2=$result2[0]['sample'];
//array("immature_xylem", "mature_leaf", "phloem", "shoot_tips","xylem", "young_leaf");

if($source=="eplant_sex"){
$result2= array("alidhem", "ersboda", "leaf-01", "leaf-02", "leaf-03", "leaf-04", "leaf-05", "leaf-06", "leaf-07", "leaf-08", "leaf-09", "leaf-10", "leaf-11", "leaf-12", "leaf-13", "leaf-14", "leaf-15", "leaf-16", "leaf-17", "sculPark");
}
if($source=="eplant_asp201"){
$result2= array("Buds-Dormant", "Buds-Pre-chilling", "Cambium-Phloem-Dormant", "Flowers-Dormant", "Flowers-Expanded", "Flowers-Expanding", "Leaves-Beetle-Damaged", "Leaves-Control", "Leaves-Drought", "Leaves-Drought-2", "Leaves-Freshly-Expanded", "Leaves-Girdled", "Leaves-Mature", "Leaves-Mature-2", "Leaves-Mechanical-Damage", "Leaves-Non-Girdled", "Leaves-Undamaged", "Leaves-Young-Expanding", "Petiole-Mature", "Roots-Control", "Roots-Drought", "Seeds-Mature", "Suckers-Whole-Sucker", "Twigs-Non-Girdled");
}
	
if($expression_table=="expression_experiment_x"){
$result2= array("Buds-Dormant", "Buds-Pre-chilling", "Cambium-Phloem-Dormant", "Flowers-Dormant", "Flowers-Expanded", "Flowers-Expanding", "Leaves-Beetle-Damaged", "Leaves-Control", "Leaves-Drought", "Leaves-Drought-2", "Leaves-Freshly-Expanded", "Leaves-Girdled", "Leaves-Mature", "Leaves-Mature-2", "Leaves-Mechanical-Damage", "Leaves-Non-Girdled", "Leaves-Undamaged", "Leaves-Young-Expanding", "Petiole-Mature", "Roots-Control", "Roots-Drought", "Seeds-Mature", "Suckers-Whole-Sucker", "Twigs-Non-Girdled");
}
	

$arrsg = array ('popdata'=>$result,'samples'=>$result2);

//

return $arrsg;
}


?>
