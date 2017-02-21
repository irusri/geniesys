<?php
$ustream=trim($_GET['ustream']);
$dstream=trim($_GET['dstream']);
$picea_basic_start=trim($_GET['picea_basic_start']);
$picea_basic_end=trim($_GET['picea_basic_end']);
$picea_basic_chromosome=trim($_GET['picea_basic_chromosome']);
$plus_minus=trim($_GET['plus_minus']);


if($plus_minus=="-1"){
  	$plus_minus="2";  
   }else{
	$plus_minus="1"; 
   }

/*if($plus_minus==1){
$picea_basic_start=$picea_basic_start-$ustream;
$picea_basic_end=$picea_basic_end+$dstream;
}else{
$picea_basic_end=$picea_basic_end+$ustream;
$picea_basic_start=$picea_basic_start-$dstream;	
}*/

//exec("fastacmd -d  '/mnt/spruce/public/ftp/sequences/BLAST/Genome_Assemblies/Pabies1.0-genome-gene-only'  -S '".$plus_minus."'  -l 1000000000000000000 -s '".$picea_basic_chromosome."' -D 2;",$outputx);

/*
$picea_basic_start2=$picea_basic_start-$ustream;
$picea_basic_end2=$picea_basic_start-1;
exec("fastacmd -d  '/mnt/spruce/public/ftp/sequences/BLAST/Genome_Assemblies/Pabies1.0-genome-gene-only' -L'".$picea_basic_start2.','.$picea_basic_end2."' -S '".$plus_minus."'  -l 1000000000000000000 -s '".$picea_basic_chromosome."' -D 0;",$output);


$picea_basic_start3=$picea_basic_end+1;
$picea_basic_end3=$picea_basic_end+$dstream;
exec("fastacmd -d  '/mnt/spruce/public/ftp/sequences/BLAST/Genome_Assemblies/Pabies1.0-genome-gene-only' -L'".$picea_basic_start3.','.$picea_basic_end3."' -S '".$plus_minus."'  -l 1000000000000000000 -s '".$picea_basic_chromosome."' -D 0;",$output2);
//ustream=0&dstream=455&picea_basic_chromosome=MA_10000213&picea_basic_start=1&picea_basic_end=1451&plus_minus=1


if($output2[1]==null){
	$output2[1]="";
}
if($output[1]==null){
	$output[1]="";
}
if($dstream+1<strlen($output2[1])){
	$output2[1]="";
}

if($ustream+1<strlen($output[1])){
	$output[1]="";
}*/

if($plus_minus==2){
	$ustream_start=$picea_basic_end+1;
	$ustream_end=$picea_basic_end+$ustream;
	
	exec("fastacmd -d  '/mnt/spruce/www/demo/geniecms/demo/data/BLAST/Egrandis_297_v2.0' -L'".$ustream_start.','.$ustream_end."' -S '".$plus_minus."'  -l 1000000000000000000 -s '".$picea_basic_chromosome."' -D 0;",$output_ustream);
	
	
	//echo "fastacmd -d  '/mnt/spruce/reference_data/BLAST/genome_assemblies/ASSEMBLYLOCK_2012_NOV/master/Picea-abies_rna-scaffolded_gene-only_november-2012' -L'".$ustream_start.','.$ustream_end."' -S '".$plus_minus."'  -l 1000000000000000000 -s '".$picea_basic_chromosome."' -D 0;";
	$dstream_start=$picea_basic_start-$dstream;
	$dstream_end=$picea_basic_start-1;
	
	exec("fastacmd -d  '/mnt/spruce/www/demo/geniecms/demo/data/BLAST/Egrandis_297_v2.0' -L'".$dstream_start.','.$dstream_end."' -S '".$plus_minus."'  -l 1000000000000000000 -s '".$picea_basic_chromosome."' -D 0;",$output_dstream);	
	
/*if(strlen($output_ustream[1])>$ustream+1){
	$output_ustream[1]="";
}*/
	
	
	}else{
		
	if($picea_basic_start-$ustream>1){
	$ustream_start=$picea_basic_start-$ustream;
	$ustream_end=$picea_basic_start-1;	
	
	exec("fastacmd -d  '/mnt/spruce/www/demo/geniecms/demo/data/BLAST/Egrandis_297_v2.0' -L'".$ustream_start.','.$ustream_end."' -S '".$plus_minus."'  -l 1000000000000000000 -s '".$picea_basic_chromosome."' -D 0;",$output_ustream);
	}else{
		$output_ustream[1]="";
		
		}
		
	$dstream_start=$picea_basic_end+1;
	$dstream_end=$picea_basic_end+$dstream;	
		
	exec("fastacmd -d  '/mnt/spruce/www/demo/geniecms/demo/data/BLAST/Egrandis_297_v2.0' -L'".$dstream_start.','.$dstream_end."' -S '".$plus_minus."'  -l 1000000000000000000 -s '".$picea_basic_chromosome."' -D 0;",$output_dstream);	
	
	if(strlen($output_ustream[1])>$ustream+1){
	$output_ustream[1]="";
}
if(strlen($output_dstream[1])>$dstream+1){
	$output_dstream[1]="";
}	
	
}
		

		
		
if($output_ustream[1]==null){
	$output_ustream[1]="";
}
if($output_dstream[1]==null){
	$output_dstream[1]="";
}




$results = array('ustreamstr'=>$output_ustream[1],'dstreamstr'=>$output_dstream[1]);
echo json_encode($results);
?>