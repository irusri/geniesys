<?php

include("koneksi.php");
$ip=$uuid;
function getdefaultsamplelist(){
	include("koneksi.php");
$ip=$uuid;
	 $sampleliststr="SELECT samplebaskets.samplelist,samplebaskets.sample_basket_id FROM samplebaskets WHERE samplebaskets.ip='$ip'";
		$samplelistresults=mysql_query($sampleliststr) or die("query gagal dijalankan");
		
			if(mysql_num_rows($samplelistresults)!=0)	{
							$defaultsampledata=mysql_fetch_assoc($samplelistresults);
							$samplesendstringt=$defaultsampledata['samplelist'];
							$sampletemparr=explode(',',$samplesendstringt);
							return $sampletemparr;
				}
				//return 'null';
}



	
function getdefaultgenelist(){
	include("koneksi.php");
$ip=$uuid;
	
	
	 $defaultstr="SELECT genebaskets.genelist FROM defaultgenebaskets LEFT JOIN genebaskets ON defaultgenebaskets.gene_basket_id=genebaskets.gene_basket_id where defaultgenebaskets.ip='$ip'";
		$defaultresults=mysql_query($defaultstr) or die("query gagal dijalankan");
		
			if(mysql_num_rows($defaultresults)!=0)	{
			$defaultgeenedata=mysql_fetch_assoc($defaultresults);
							$genessendStringt=$defaultgeenedata['genelist'];
							$tmpArr=explode(',',$genessendStringt);
							return $tmpArr;
				}
				//return 'null';
}


function updategenebasket($genearray){

include("koneksi.php");
$ip=$uuid;


 $genessendaddStringArray = $genearray;//explode(",",$genessendaddString);
$genessendaddString=implode(",",$genearray);

$check=mysql_query("select * from defaultgenebaskets where ip='$ip'");
if(mysql_num_rows($check)==0)
		
		{
			// NO DEFAULT GENEBASKETS,INSTERED

			$initcounts=count($genessendaddStringArray);
			
			mysql_query("insert into genebaskets(gene_basket_id,gene_basket_name,harga,genelist,ip) values('$kode','default','$initcounts','$genessendaddString','$ip')") or die("data gagal di insert");
			mysql_query("insert into defaultgenebaskets(defaultgenebaskets.gene_basket_id,defaultgenebaskets.ip) SELECT LAST_INSERT_ID(gene_basket_id),'$ip' from genebaskets WHERE ip='$ip' ORDER BY gene_basket_id DESC Limit 1;");
			
			//return $genessendaddString;
			
		}else{
			//FOUND DEFAULT genes
		$defaultstr="SELECT genebaskets.genelist,genebaskets.gene_basket_id FROM defaultgenebaskets LEFT JOIN genebaskets ON defaultgenebaskets.gene_basket_id=genebaskets.gene_basket_id where defaultgenebaskets.ip='$ip'";
		$defaultresults=mysql_query($defaultstr) or die("query gagal dijalankan");
		
			if(mysql_num_rows($defaultresults)!=0)
			{
				$defaultgeenedata=mysql_fetch_assoc($defaultresults);
				$dbgenesStr=$defaultgeenedata['genelist'];
				$basketid=$defaultgeenedata['gene_basket_id'];
				$dbgenesStrArray=explode(",",$dbgenesStr);
				
				if($dbgenesStr==""){
					//EMPTY gene basket
				$initcount=count($genessendaddStringArray);
				mysql_query("update genebaskets set genelist='$genessendaddString',harga='$initcount' where gene_basket_id='$basketid'") or die ("data gagal di update");
			//echo '1'.$genessendaddString;
				}else{
					//Gene basket with genes
						
				$tmpresultArr = array_merge($dbgenesStrArray,$genessendaddStringArray);
				$updategenelistArr=array_unique($tmpresultArr);
				$updatecount=count($updategenelistArr);
				$updategenelist=implode(',',$updategenelistArr);
				
				mysql_query("update genebaskets set genelist='$updategenelist',harga='$updatecount' where gene_basket_id='$basketid'") or die ("data gagal di update");
				//echo '2'.$updategenelist;
				}
			
			
			
		}else{
			
		}
		
		//mysql_query("update defaultgenebaskets set gene_basket_id='$kode' where ip='$ip'") or die ("data gagal di update");
		}
		
		
	
	
}

function removegenebasket($removegenearray){
	include("koneksi.php");
$ip=$uuid;
	
$genessendremovetringArr=$removegenearray;
$genessendremovetring=implode(",",$removegenearray);

$defaultstrRemove="SELECT genebaskets.genelist,genebaskets.gene_basket_id FROM defaultgenebaskets LEFT JOIN genebaskets ON defaultgenebaskets.gene_basket_id=genebaskets.gene_basket_id where defaultgenebaskets.ip='$ip'";
		$defaultresultsRemove=mysql_query($defaultstrRemove) or die("query gagal dijalankan");
		
			if(mysql_num_rows($defaultresultsRemove)!=0)
			{
				$defaultgeeneremovedata=mysql_fetch_assoc($defaultresultsRemove);
				$dbgenesremoveStr=$defaultgeeneremovedata['genelist'];
				$basketremoveid=$defaultgeeneremovedata['gene_basket_id'];
				$dbgenesStrRemoveArray=explode(",",$dbgenesremoveStr);
				
				if($dbgenesremoveStr!=""){
					
					
				$tmpresultRemoveArr =  array_diff($dbgenesStrRemoveArray,$genessendremovetringArr);
				$updategenelistRemoveArr=array_unique($tmpresultRemoveArr);
				$updatecountremove=count($updategenelistRemoveArr);
				$updategenelistremove=implode(',',$updategenelistRemoveArr);
				
				mysql_query("update genebaskets set genelist='$updategenelistremove',harga='$updatecountremove' where gene_basket_id='$basketremoveid'") or die ("data gagal di update");
				//echo $updategenelistremove;
					
					
				}else{
					echo "no gene ids to remove";	
				}
					

			}else{
				echo 'no default gene basket selected';
			}




	
}

function updategenebasketall($updateallarr){
	include("koneksi.php");
		
$ip=$uuid;

	$genessendaddString=implode(",",$updateallarr);

$checkme=mysql_query("select * from defaultgenebaskets where ip='$ip'");
if(mysql_num_rows($checkme)==0)
		
		{
			// NO DEFAULT GENEBASKETS,INSTERED

			$initcountsupdate=count($updateallarr);
			
			mysql_query("insert into genebaskets(gene_basket_id,gene_basket_name,harga,genelist,ip) values('$kode','default','$initcountsupdate','$genessendaddString','$ip')") or die("data gagal di insert");
			mysql_query("insert into defaultgenebaskets(defaultgenebaskets.gene_basket_id,defaultgenebaskets.ip) SELECT LAST_INSERT_ID(gene_basket_id),'$ip' from genebaskets WHERE ip='$ip' ORDER BY gene_basket_id DESC Limit 1;");
			
			//return $genessendaddString;
			
		}else{
			//FOUND DEFAULT genes
		$defaultstru="SELECT genebaskets.gene_basket_id FROM defaultgenebaskets LEFT JOIN genebaskets ON defaultgenebaskets.gene_basket_id=genebaskets.gene_basket_id where defaultgenebaskets.ip='$ip'";
		$defaultresultsu=mysql_query($defaultstru) or die("query gagal dijalankan");
		
	
				$dbgenesStrArrayu=implode(",",$updateallarr);
				
				
					//EMPTY gene basket
				$initcountu=count($updateallarr);
				
				if(mysql_num_rows($defaultresultsu)!=0)
			{
				$cleardefaultbasketdatau=mysql_fetch_assoc($defaultresultsu);
				$clearbasketidu=$cleardefaultbasketdatau['gene_basket_id'];
				 
				
					mysql_query("update genebaskets set genelist='$dbgenesStrArrayu',harga='$initcountu' where gene_basket_id='$clearbasketidu'") or die ("data gagal di update");
				//echo '2'.$updategenelist;
			
			
			
			}
		
		
		//mysql_query("update defaultgenebaskets set gene_basket_id='$kode' where ip='$ip'") or die ("data gagal di update");
		}
		
	
}

?>