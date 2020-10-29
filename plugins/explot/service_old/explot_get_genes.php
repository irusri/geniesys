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
$range = trim($_POST['range']);
$t_ids = $_POST['ids'];

$post_array = array();
foreach($_POST as $k => $v) {
	$post_array[trim($k)] = trim($v);
	
}

#####################################
//MySQL connection
#####################################
$con=mysqli_connect("localhost", "popuser", "poppass","eucgenie_egrandis_v2");
// Check connection
if(mysqli_connect_errno()){echo "Failed to connect to MySQL: " . mysqli_connect_error();}

$tmp_sample_ar = array();
$sorting_field=" group by sample";

if($expression_table=="expression_experiment_2_no_replicates"){
		$sorting_field="order by FIELD(sample, 'immature_xylem', 'matureleaf', 'phloem')";
		$tmp_sample_ar=array('immature_xylem', 'matureleaf', 'phloem');
	}
if($expression_table=="expression_experiment_3_no_replicates"){
		$sorting_field="order by FIELD(sample, 'control', 'rep')";
		$tmp_sample_ar=array( 'control', 'rep');
	}

if($expression_table=="expression_experiment_4_no_replicates"){
		$sorting_field="order by FIELD(sample, 'stage1', 'stage2','stage3')";
		$tmp_sample_ar=array( 'control', 'rep');
	}

if($expression_table=="expression_experiment_1_no_replicates"){
		$sorting_field="order by FIELD(sample, 'xylem', 'immature_xylem', 'phloem', 'mature_leaf','young_leaf', 'shoot_tips')";
		$tmp_sample_ar=array('xylem', 'immature_xylem', 'phloem', 'mature_leaf','young_leaf', 'shoot_tips');
	}


	if($expression_table=="expression_exatlas_experiment_2"){
		$sorting_field="order by FIELD(sample, 'phloem_TTGT', 'matureleaf_TTGT', 'phloem_GCTT', 'matureleaf_GCTT', 'immature_xylem_2','phloem_CACT','matureleaf_CACT','immature_xylem_4')";
		$tmp_sample_ar=array('phloem_TTGT', 'matureleaf_TTGT', 'phloem_GCTT', 'matureleaf_GCTT', 'immature_xylem_2','phloem_CACT','matureleaf_CACT','immature_xylem_4');
	}
	if($expression_table=="expression_exatlas_experiment_3"){
		$sorting_field="order by FIELD(sample, 'rep1', 'GCTT', 'rep2', 'CACT', 'rep3','TTGT')";
		$tmp_sample_ar=array('rep1', 'GCTT', 'rep2', 'CACT', 'rep3','TTGT');
	}
	
	if($expression_table=="expression_exatlas_experiment_4"){
		$sorting_field="order by FIELD(sample, 'TTGT_stage1', 'TTGT_stage2', 'GCTT_stage3', 'CACT_stage1', 'GCTT_stage2','TTGT_stage3','GCTT_stage1','CACT_stage2','CACT_stage3')";
		$tmp_sample_ar=array('TTGT_stage1', 'TTGT_stage2', 'GCTT_stage3', 'CACT_stage1', 'GCTT_stage2','TTGT_stage3','GCTT_stage1','CACT_stage2','CACT_stage3');
	}
	
	if($expression_table=="expression_exatlas_experiment_1"){
		$sorting_field="order by FIELD(sample, 'xylem', 'immature_xylem', 'phloem', 'mature_leaf','young_leaf', 'shoot_tips')";
		$tmp_sample_ar=array('xylem', 'immature_xylem', 'phloem', 'mature_leaf','young_leaf', 'shoot_tips');
	}

$t_ids_ar=array();
$t_ids_ar=explode(",",$t_ids); 

$range_sql_array=array(); 
for($i=0;$i<count($tmp_sample_ar);$i++){
	 $t_ids_ar[$i]."-".$tmp_sample_ar[$i];
	$range_sql_array[]="select id from $expression_table where sample ='".$tmp_sample_ar[$i]."' and cast(log2 as decimal(5,4)) between ".($t_ids_ar[$i]-$range)." and ".($t_ids_ar[$i]+$range);
	 
}

$isect = array();
for($k=0;$k<count($range_sql_array);$k++){
	${'array'.$k}=array();
	if ($result = mysqli_query($con, $range_sql_array[$k]) or die(mysqli_error($con))) {
		while ($row = mysqli_fetch_assoc($result)){ ${'array'.$k}[] = $row["id"];}
	}
	
	 mysqli_free_result($result);	
}

$arrays = array();
for ($i = 0; $i < count($range_sql_array); $i++) {
    $arrays[] = ${'array'.$i};
}
if(count($range_sql_array)==1){
$isect = call_user_func_array('array_merge', $arrays);	
}else{
$isect = call_user_func_array('array_intersect', $arrays);
}
//echo json_encode(array_values($isect));
//include("../../explot/service/explot_service.php");
//echo $isect,$tmp_sample_ar,$expression_table;exit();
$new_array=getdata(array_values($isect),$tmp_sample_ar,$expression_table);
print json_encode($new_array); 






function getdata($primaryGenes,$source,$expression_table){
mysql_connect("localhost", "popuser", "poppass") or die(mysql_error());
mysql_select_db("eucgenie_egrandis_v2") or die(mysql_error());
$result = array();
$result2 = array();
//$source='eplant_sex';

$source_view='expression_tissues';


$geneids_array = $primaryGenes;//explode(",", $primaryGenes);
for($t=0;$t<count($geneids_array);$t++){
/*if(checkprefix($geneids_array[$t],"Esu")==true){
$resultprobeset = mysql_query("SELECT * FROM $source_view WHERE id='$geneids_array[$t]' order by sample;")
or die(mysql_error());
}else{*/
	$sorting_fild=" group by sample";
	if($expression_table=="expression_exatlas_experiment_2"){
		$sorting_fild="order by FIELD(sample, 'phloem_TTGT', 'matureleaf_TTGT', 'phloem_GCTT', 'matureleaf_GCTT', 'immature_xylem_2','phloem_CACT','matureleaf_CACT','immature_xylem_4')";
	}
	if($expression_table=="expression_exatlas_experiment_3"){
		$sorting_fild="order by FIELD(sample, 'rep1', 'GCTT', 'rep2', 'CACT', 'rep3','TTGT')";
	}
	
	if($expression_table=="expression_exatlas_experiment_4"){
		$sorting_fild="order by FIELD(sample, 'TTGT_stage1', 'TTGT_stage2', 'GCTT_stage3', 'CACT_stage1', 'GCTT_stage2','TTGT_stage3','GCTT_stage1','CACT_stage2','CACT_stage3')";
	}
	
	if($expression_table=="expression_exatlas_experiment_1" || $expression_table=="expression_experiment_1_no_replicates" ){
		$sorting_fild="order by FIELD(sample, 'xylem', 'immature_xylem', 'phloem', 'mature_leaf','young_leaf', 'shoot_tips')";
	}


	$pattern = '/^[a-zA-Z0-9]+[.]+[a-zA-Z0-9]+[.]+[0-9]?[0-9]$/';
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
		}
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
	
	if($rowPROBE_ID['id']=="Eucgr.A00375"){
		$rows["draggableY"]="true";
	$rows["dragMinY"]=0;$rows["minPointLength"]=2;
	}
	
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

























//$mysql_arr_str=implode(" union ",$mysql_arr);
//echo $mysql_arr_str;

//echo $sorting_field;
exit();
#####################################
//MySQL connection
#####################################
$con=mysqli_connect("localhost", "popuser", "poppass","eucgenie_egrandis_v2");
// Check connection
if(mysqli_connect_errno()){echo "Failed to connect to MySQL: " . mysqli_connect_error();}

$sample_name='mature_leaf';

###################################################
//Finding all distinct samples and put into array
###################################################
$finding_samples="select DISTINCT(sample) from $expression_table";
if ($result = mysqli_query($con, $finding_samples) or die(mysqli_error($con))) {
	$sample_array = array ();
	while ($row = mysqli_fetch_assoc($result)){ $sample_array[] = $row["sample"];}
    mysqli_free_result($result);
}

##################################################################################################################
//Loop sample_array to find matching values for each sample
##################################################################################################################
$par="";
$range_sql_array = array ();
for($j=0;$j<count($sample_array);$j++){
	###############################################################################################################
	//Finding the Range(Max-Min) and Min value assign to dynamic variables for any given sample
	###############################################################################################################
	$sample_name=$sample_array[$j];
	$expression_range="select (max(cast(log2 as decimal(5,4)))-min(cast(log2 as decimal(5,4))))/7,min(cast(log2 as decimal(5,4))) from $expression_table where sample ='$sample_name'";
	if ($result=mysqli_query($con,$expression_range) or die(mysqli_error($con)) ){
	  while ($row=mysqli_fetch_row($result)){${$sample_name."sample_range"}= $row[0];${$sample_name."sample_min_value"}= $row[1];}
	  mysqli_free_result($result);
	}

	###################################################################################################################
	//Finding the legend scales using Min+$sample_range*array_index and fill into dynamic variables for any given sample
	###################################################################################################################
	for($i=0;$i<=7;$i++){
		${$sample_name."scale_value_".$i} = ${$sample_name."sample_min_value"}+${$sample_name."sample_range"}*$i;
	}
	
	$no_match_flag=false;
	foreach($post_array as $kk => $vv) {
		if($kk==$sample_name && $kk !="private_view"){
		 $range_parameter= "cast(log2 as decimal(5,4)) between ".${$sample_name."scale_value_".($vv)} ." and ". ${$sample_name."scale_value_".($vv+1)};
		 $no_match_flag=true;
		}
	}
		
	###############################################################
	//Print results
	###############################################################	
	//$range_sql_array[]="select id from expression_experiment_2 where sample='".$sample_name. "' AND $range_parameter";
	if( $no_match_flag==true){
	$range_sql_array[]="select id from $expression_table where sample='".$sample_name. "' AND $range_parameter";
	}
}

//print_r($range_sql_array);
//$find_genes_string=implode(" union ",$range_sql_array);
###############################################################
//Finding genes corresponding to given expression range
###############################################################
//$finding_genes="select id from expression_experiment_1 where $find_genes_string";
$isect = array();
for($k=0;$k<count($range_sql_array);$k++){
	${'array'.$k}=array();
	if ($result = mysqli_query($con, $range_sql_array[$k]) or die(mysqli_error($con))) {
		while ($row = mysqli_fetch_assoc($result)){ ${'array'.$k}[] = $row["id"];}
	}
	
	 mysqli_free_result($result);	
}

$arrays = array();
for ($i = 0; $i < count($range_sql_array); $i++) {
    $arrays[] = ${'array'.$i};
}
if(count($range_sql_array)==1){
$isect = call_user_func_array('array_merge', $arrays);	
}else{
$isect = call_user_func_array('array_intersect', $arrays);
}
echo json_encode(array_values($isect));

/*if ($result = mysqli_query($con, $find_genes_string) or die(mysqli_error($con))) {
	$genes_array = array ();
	while ($row = mysqli_fetch_assoc($result)){ $genes_array[] = $row["id"];}
    mysqli_free_result($result);
} 



print_r($genes_array);*/
//print_r($count_values);













/*$first_scale_value= $sample_min_value;
$second_scale_value= $sample_min_value + $sample_range*1;
$third_scale_value= $sample_min_value + $sample_range*2;
$forth_scale_value= $sample_min_value + $sample_range*3;
$fifth_scale_value= $sample_min_value + $sample_range*4;
$sixth_scale_value= $sample_min_value + $sample_range*5;
$seventh_scale_value= $sample_min_value + $sample_range*6;
$eight_scale_value= $sample_min_value + $sample_range*7;


echo $eight_scale_value;*/




mysqli_close($con);




exit();



$resultprobeset = mysql_query("SELECT sample,log2,rmd,log2fc FROM $expression_table WHERE id='$primaryGene' order by sample;")	or die(mysql_error());
$g = 0;
while ($rowPROBE_ID = mysql_fetch_array($resultprobeset)) {
	$children[$g]->sample=$rowPROBE_ID['sample'];
	$children[$g]->log2=$rowPROBE_ID['log2'];
	$children[$g]->rmd=$rowPROBE_ID['log2'];
	$children[$g]->log2fc=$rowPROBE_ID['log2'];
	$ret[] = $children[$g];
	$g++;
}

#####################################
//Pass the results as JSON array
#####################################
if($ret!=null){
		$arrsg = array ('popdata'=>$ret);
}else{
		$arrsg = array ('popdata'=>$ret,'errorID'=>$popmeGene);
}
echo json_encode($arrsg);



 ?>
