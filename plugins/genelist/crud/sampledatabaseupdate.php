<?php
	
include("koneksi.php");
$ip=$uuid;


if (isset($_POST['empty_default_basket'])){
	
	$cleaarthebasketStr="SELECT samplebaskets.samplelist,samplebaskets.sample_basket_id FROM samplebaskets  where samplebaskets.ip='$ip'";
	echo $cleaarthebasketStr;
		$clearthebasketmysql=mysql_query($cleaarthebasketStr) or die("query gagal dijalankan");
	if(mysql_num_rows($clearthebasketmysql)!=0)
			{
				$cleardefaultbasketdata=mysql_fetch_assoc($clearthebasketmysql);
				$clearbasketid=$cleardefaultbasketdata['sample_basket_id'];
			}
			mysql_query("update samplebaskets set samplelist='',harga='0' where sample_basket_id='$clearbasketid'") or die ("data gagal di update");
	echo 'please clear me!';
	
}


if(isset($_POST['exp_sel_add'])){
	
	$sampleaddString=trim($_POST['exp_sel_add']);
	$samplestrArr = explode(",",$sampleaddString);
	$samplestrArr = array_unique($samplestrArr);
	$initcounts=count($samplestrArr);
	$sampleaddString = implode(",",$samplestrArr);

	 
	 $check=mysql_query("SELECT * FROM samplebaskets WHERE samplebaskets.ip='$ip'");
	  if(mysql_num_rows($check)==0)
		{
	
			mysql_query("insert into samplebaskets(sample_basket_id,sample_basket_name,harga,samplelist,ip) values('$kode','default','$initcounts','$sampleaddString','$ip')") or die("data gagal di insert");
		echo $sampleaddString;
		}else{
				$samplequerystr="SELECT samplebaskets.samplelist,samplebaskets.sample_basket_id FROM samplebaskets WHERE samplebaskets.ip='$ip'";
				$samplequeryresults=mysql_query($samplequerystr) or die("query gagal dijalankan");
			
				$samplequerydata=mysql_fetch_assoc($samplequeryresults);
				$samplelisttmp=$samplequerydata['samplelist'];
				$samplelistidtmp=$samplequerydata['sample_basket_id'];
			if($samplelisttmp==""){
				mysql_query("update samplebaskets set samplebaskets.samplelist='$sampleaddString',samplebaskets.harga='$initcounts' where samplebaskets.sample_basket_id='$samplelistidtmp'") or die ("data gagal di update");
				echo $sampleaddString;
			}else{
				$samplelisttmpArr = explode(",",$samplelisttmp);
							
				$tmpresultArr = array_merge($samplelisttmpArr,$samplestrArr);
				$filtertedtmpresultsArr=array_unique($tmpresultArr);
				$filteredupdatecount=count($filtertedtmpresultsArr);
				$filteredupdatedlist=implode(',',$filtertedtmpresultsArr);	
				mysql_query("update samplebaskets set samplebaskets.samplelist='$filteredupdatedlist',samplebaskets.harga='$filteredupdatecount' where samplebaskets.sample_basket_id='$samplelistidtmp'") or die ("data gagal di update");
				//echo $filteredupdatecount.'->'.$filteredupdatedlist;
				echo $filteredupdatedlist;
			}
			
			
		 
		
		}
	 
	
	 
	 
	//echo 1; 
	exit;
}else if(isset($_POST['exp_sel_remove'])) {
	
	$sampleremovetring=trim($_POST['exp_sel_remove']);
	$samplesremoveArr = explode(",",$sampleremovetring);
	$samplesremoveArr = array_unique($samplesremoveArr);
	$sampleremovecount=count($samplesremoveArr);
	$sampleremovetring = implode(",",$samplesremoveArr);
	
	 $check2=mysql_query("SELECT * FROM samplebaskets WHERE samplebaskets.ip='$ip'");
	  if(mysql_num_rows($check2)==0)
		{
			
			//echo ;
		}else{
			
			$sampleremovequerystr="SELECT samplebaskets.samplelist,samplebaskets.sample_basket_id FROM samplebaskets WHERE samplebaskets.ip='$ip'";
				$sampleremovequeryresults=mysql_query($sampleremovequerystr) or die("query gagal dijalankan");
			
				$sampleremovequerydata=mysql_fetch_assoc($sampleremovequeryresults);
				$sampleremovelisttmp=$sampleremovequerydata['samplelist'];
				$sampleremovelistidtmp=$sampleremovequerydata['sample_basket_id'];
				
				
				
			if($sampleremovelisttmp==""){
			//echo '  removed nothing(2)';
				}else{
					
				$sampleremovelisttmpArr = explode(",",$sampleremovelisttmp);
				$tmpresultRemoveArr =  array_diff($sampleremovelisttmpArr,$samplesremoveArr);
				$updatesamplelistRemoveArr=array_unique($tmpresultRemoveArr);
				$updatecountremove=count($updatesamplelistRemoveArr);
				$updatesremove=implode(',',$updatesamplelistRemoveArr);
					
					mysql_query("update samplebaskets set samplebaskets.samplelist='$updatesremove',samplebaskets.harga='$updatecountremove' where samplebaskets.sample_basket_id='$sampleremovelistidtmp'") or die ("data gagal di update");
					
					echo $updatesremove;
					
				}
			
			
			
		}
	
	
	exit;
}




/*else if($_POST['exp_sel']){
 $genessendaddString=trim($_POST['genes_send_add']);
 $genessendaddStringArray = explode(",",$genessendaddString);
 $genessendaddStringArray = array_unique($genessendaddStringArray);
 $genessendaddString = implode(",",$genessendaddStringArray);
  
  
$check=mysql_query("select * from defaultgenebaskets where ip='$ip'");
 if(mysql_num_rows($check)==0)
		{
			// NO DEFAULT GENEBASKETS,INSTERED
			$initcounts=count($genessendaddStringArray);
			
			mysql_query("insert into genebaskets(gene_basket_id,gene_basket_name,harga,genelist,ip) values('$kode','default','$initcounts','$genessendaddString','$ip')") or die("data gagal di insert");
			mysql_query("insert into defaultgenebaskets(defaultgenebaskets.gene_basket_id,defaultgenebaskets.ip) SELECT LAST_INSERT_ID(gene_basket_id),'$ip' from genebaskets WHERE ip='$ip' ORDER BY gene_basket_id DESC Limit 1;");
			
			echo $genessendaddString;
			
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
			echo '1'.$initcount.'t'.$genessendaddString;
				}else{
					//Gene basket with genes
						
				$tmpresultArr = array_merge($dbgenesStrArray,$genessendaddStringArray);
				$updategenelistArr=array_unique($tmpresultArr);
				$updatecount=count($updategenelistArr);
				$updategenelist=implode(',',$updategenelistArr);
				
				mysql_query("update genebaskets set genelist='$updategenelist',harga='$updatecount' where gene_basket_id='$basketid'") or die ("data gagal di update");
			echo '2'.$updatecount.'t'.$updategenelist;
				}
			
			
			
		}else{
			
		}
		
		//mysql_query("update defaultgenebaskets set gene_basket_id='$kode' where ip='$ip'") or die ("data gagal di update");
		}
		
		


}else if($_POST['genes_send_remove']){
	
$genessendremovetring=trim($_POST['genes_send_remove']);
$genessendremovetringArr=explode(",",$genessendremovetring);

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
				echo 'no default gene basket';
			}




}else if (isset($_POST['empty_default_basket'])){
	
	$cleaarthebasketStr="SELECT genebaskets.genelist,genebaskets.gene_basket_id FROM defaultgenebaskets LEFT JOIN genebaskets ON defaultgenebaskets.gene_basket_id=genebaskets.gene_basket_id where defaultgenebaskets.ip='$ip'";
		$clearthebasketmysql=mysql_query($cleaarthebasketStr) or die("query gagal dijalankan");
	if(mysql_num_rows($clearthebasketmysql)!=0)
			{
				$cleardefaultbasketdata=mysql_fetch_assoc($clearthebasketmysql);
				$clearbasketid=$cleardefaultbasketdata['gene_basket_id'];
			}
			
			mysql_query("update genebaskets set genelist='',harga='0' where gene_basket_id='$clearbasketid'") or die ("data gagal di update");
	echo 'please clear me!';
	
}else if (isset($_POST['get_default_genes'])){
	
		
	 $defaultstr="SELECT genebaskets.genelist FROM defaultgenebaskets LEFT JOIN genebaskets ON defaultgenebaskets.gene_basket_id=genebaskets.gene_basket_id where defaultgenebaskets.ip='$ip'";
		$defaultresults=mysql_query($defaultstr) or die("query gagal dijalankan");
		
			if(mysql_num_rows($defaultresults)!=0)	{
			$defaultgeenedata=mysql_fetch_assoc($defaultresults);
							$genessendStringt=$defaultgeenedata['genelist'];
						
		echo $genessendStringt;
				
				
				}
}
		
		
		
		

*/
?>