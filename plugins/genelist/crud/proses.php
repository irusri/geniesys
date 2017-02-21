<?php
	error_reporting(0);
	include("koneksi.php");
	if(isset($_POST))
	{
	$action=$_POST['action'];
	$kode=$_POST['genebasketid'];
	$nama=$_POST['namabarang'];
	$harga=$_POST['harga'];

	}

$ip=$uuid;

	if($action=="new")
	{
		$initcheck=mysql_query("select * from genebaskets where ip='$ip'");
				if(mysql_num_rows($initcheck)<10){

		$check=mysql_query("select * from genebaskets where gene_basket_id='$kode' and ip='$ip'");
		if(mysql_num_rows($check)==0)
		{
		mysql_query("insert into genebaskets(gene_basket_id,gene_basket_name,harga,genelist,ip) values('$kode','$nama','$harga','$name','$ip')") or die("data gagal di insert");
		echo 1;
		}
		else
		{
			echo "kode barang sudah ada";
		}

				}else{
				echo 'Maximum 10 gene list allowed!';
				}
		exit;
	}
	elseif($action=="update")
	{
		mysql_query("update genebaskets set gene_basket_name='$nama' where gene_basket_id='$kode'") or die ("data gagal dsi update");
		echo 1 ;
		exit;
	}
	elseif($_GET['action']=="updatedefaultgene")
	{
		$kode=intval($_GET['genebasketid']);
		$check2=mysql_query("select * from defaultgenebaskets where ip='$ip'");
		if(mysql_num_rows($check2)==0)
		{
		mysql_query("insert into defaultgenebaskets(gene_basket_id,ip) values('$kode','$ip')") or die("data gagal di insert");
		}else{
		mysql_query("update defaultgenebaskets set gene_basket_id='$kode' where ip='$ip'") or die ("data gagal dii update");
		}
		echo 1 ;
	//	echo "sss";
		exit;

	}elseif($_GET['action']=="delete")
	{
		$kode=intval($_GET['genebasketid']);
		mysql_query("delete from genebaskets where gene_basket_id='$kode'")or die("data tidak berhasil di hapus");

		//$check3=mysql_query("select * from defaultgenebaskets where gene_basket_id='$kode' and ip='$ip'" );
		//if(mysql_num_rows($check3)!=0)
		//{
		mysql_query("delete from defaultgenebaskets where gene_basket_id='$kode'")or die("data tidak berhasil di hapus");
		//}

		//echo "it shold deleted";
		echo 1;
		exit;
	}elseif($action=="savecurent")
	{


		$initcheck2=mysql_query("select * from genebaskets where ip='$ip'");
				if(mysql_num_rows($initcheck2)<10){

		if($kode!=0){
			//if($harga!=0){

			mysql_query("insert into genebaskets(genebaskets.genelist,genebaskets.ip,genebaskets.harga,genebaskets.gene_basket_name) SELECT genebaskets.genelist,genebaskets.ip,genebaskets.harga,'$nama' from genebaskets WHERE genebaskets.gene_basket_id='$kode';");

			//mysql_query("update genebaskets set genebaskets.genelist='',genebaskets.harga='' where genebaskets.gene_basket_id='$kode'") or die ("data gagal di update");
			echo 1;

			//}else{
		//echo 'No meaning to save empty gene list.Please go to Gene Search tool and add few genes to default list first.';
		//}
	}else{
		echo 'No default gene list selected';
	}
		//
		//echo $kode.$nama;
		exit;
			}else{
				echo 'Maximum 10 gene list allowed!';
				}


	}

?>
