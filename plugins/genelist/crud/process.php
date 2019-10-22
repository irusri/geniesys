<?php
	error_reporting(0);
	include("common.php");
	if(isset($_POST))
	{
	$action=$_POST['action'];
	$kid=$_POST['genebasketid'];
	$lname=$_POST['namabarang'];
	$cipher_count=$_POST['harga'];

	}

$ip=$uuid;

	if($action=="new")
	{
		$initcheck=mysqli_query($genelist_connection,"select * from genebaskets where ip='$ip'");
				if(mysqli_num_rows($initcheck)<10){

		$check=mysqli_query($genelist_connection,"select * from genebaskets where gene_basket_id='$kid' and ip='$ip'");
		if(mysqli_num_rows($check)==0)
		{
		mysqli_query($genelist_connection,"insert into genebaskets(gene_basket_id,gene_basket_name,harga,genelist,ip) values('$kid','$lname','$cipher_count','$name','$ip')") or die("insert failed");
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
		mysqli_query($genelist_connection,"update genebaskets set gene_basket_name='$lname' where gene_basket_id='$kid'") or die ("update failed");
		echo 1 ;
		exit;
	}
	elseif($_GET['action']=="updatedefaultgene")
	{
		//echo $ip;
		$kid=intval($_GET['genebasketid']);
		$check2=mysqli_query($genelist_connection,"select * from defaultgenebaskets where ip='$ip'");
		if(mysqli_num_rows($check2)==0)
		{
		mysqli_query($genelist_connection,"insert into defaultgenebaskets(gene_basket_id,ip) values('$kid','$ip')") or die("insert failed");
		}else{
		mysqli_query($genelist_connection,"update defaultgenebaskets set gene_basket_id='$kid' where ip='$ip'") or die ("update failed");
		}
		echo 1 ;
	//	echo "sss";
		exit;

	}elseif($_GET['action']=="delete")
	{
		$kid=intval($_GET['genebasketid']);
		mysqli_query($genelist_connection,"delete from genebaskets where gene_basket_id='$kid'")or die("delete failed");

		//$check3=mysqli_query($genelist_connection,"select * from defaultgenebaskets where gene_basket_id='$kid' and ip='$ip'" );
		//if(mysqli_num_rows($check3)!=0)
		//{
		mysqli_query($genelist_connection,"delete from defaultgenebaskets where gene_basket_id='$kid'")or die("delete failed");
		//}

		//echo "it shold deleted";
		echo 1;
		exit;
	}elseif($action=="savecurent")
	{


		$initcheck2=mysqli_query($genelist_connection,"select * from genebaskets where ip='$ip'");
				if(mysqli_num_rows($initcheck2)<10){

		if($kid!=0){
			//if($cipher_count!=0){

			mysqli_query($genelist_connection,"insert into genebaskets(genebaskets.genelist,genebaskets.ip,genebaskets.harga,genebaskets.gene_basket_name) SELECT genebaskets.genelist,genebaskets.ip,genebaskets.harga,'$lname' from genebaskets WHERE genebaskets.gene_basket_id='$kid';");

			//mysqli_query($genelist_connection,"update genebaskets set genebaskets.genelist='',genebaskets.harga='' where genebaskets.gene_basket_id='$kid'") or die ("update failed");
			echo 1;

			//}else{
		//echo 'No meaning to save empty gene list.Please go to Gene Search tool and add few genes to default list first.';
		//}
	}else{
		echo 'No default gene list selected';
	}
		//
		//echo $kid.$lname;
		exit;
			}else{
				echo 'Maximum 10 gene list allowed!';
				}


	}

?>
