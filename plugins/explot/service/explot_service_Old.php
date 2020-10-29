<?php
//print  json_encode($result);//, JSON_NUMERIC_CHECK);
$selected_genelist=trim($_POST['selected_genelist']);
$primaryGenes=trim($_POST['primaryGenes']);
$expression_table="expression_exatlas_".trim($_POST['source']);

$rf=trim($_POST['rf']);

$primaryGenes = trim($primaryGenes, ', ');
include("../../genelist/crud/getgenelist.php");
if (isset($_POST['selected_genelist'])){

	$geneids_array = explode(",", trim($_POST['selected_genelist']));
	echo trim(updategenebasketall($geneids_array,"explot list"));
	exit;
}

$t_ids_ar=array();
//if($primaryGenes==""){
$primaryGenes2=getdefaultgenelist();
/*}else{
	$t_ids_ar=explode(",",$primaryGenes);
	$primaryGenes2=$t_ids_ar;
}*/
	

if(count($primaryGenes2)<201){
$new_array=getdata($primaryGenes2,$samplelist_array,$expression_table,$rf);
print json_encode($new_array);
}else{
print json_encode("exceeded");	
}

function getdata($primaryGenes,$source,$expression_table,$rf){
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
$expression_table="expression_sample";
	
	
	
	
	if($rf=="false"){
		$type="T";
	}else{
	$type="Pf";
	}
	
	$pattern = '/^[a-zA-Z0-9]+[.]+[a-zA-Z0-9]+[.]+[0-9]?[0-9]$/';
		if(preg_match($pattern,$geneids_array[$t])== true){
			$newpattern = '/^[a-zA-Z0-9]+[.]+[a-zA-Z0-9]+[.]+[0-9]$/';
			if(preg_match($newpattern,$geneids_array[$t])== true){
				$newid= substr_replace($geneids_array[$t], "", -2);
				$resultprobeset = mysql_query("SELECT DISTINCT sample,id,log2 FROM $expression_table WHERE id='$newid' and type ='$type' order by sample;")	or die(mysql_error());
			}else{
				$newid2= substr_replace($geneids_array[$t], "", -3);
				$resultprobeset = mysql_query("SELECT DISTINCT sample,id,log2 FROM $expression_table WHERE id='$newid2' and type ='$type' order by sample;")	or die(mysql_error());
			}
		}else{
		//	echo "SELECT DISTINCT sample,id,log2 FROM $expression_table WHERE id='$geneids_array[$t]' and type ='$type' order by sample;";
			$resultprobeset = mysql_query("SELECT DISTINCT sample,id,log2 FROM $expression_table WHERE id='$geneids_array[$t]' and type ='$type' order by sample;")	or die(mysql_error());
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


#####################################
//Check prefix
#####################################
function checkprefix($source, $prefix) {
    if (str_startswith($source, $prefix)) {
       return true;
    } else {
       return false;
    }
}
function str_startswith($source, $prefix)
{
   return strncmp($source, $prefix, strlen($prefix)) == 0;
}

/////////////////////////////////////


?>
