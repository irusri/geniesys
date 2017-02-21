<?php

		include("koneksi.php");
		$ip=$uuid;

	$action="new";
	$status="submit";
	$readonly="";
	$kode="";
	$nama='';
	$harga='';
	if(isset($_GET['action']) and $_GET['action']=="update" and !empty($_GET['genebasketid']))
	{
			include("koneksi.php");
		$ip=$uuid;

		$str="select * from genebaskets where gene_basket_id=".intval($_GET['genebasketid']);
		$res=mysql_query($str) or die("query gagal dijalankan");
		$data=mysql_fetch_assoc($res);
		//print_r($data);
		$kode=$data['gene_basket_id'];
		$nama=$data['gene_basket_name'];
		$harga=$data['harga'];
		$action="update";
		$simpan=$action;
		$readonly="readonly=readonly";
		//setcookie('blabla', $$nama, time() + (86400 * 30), "/"); // 86400 = 1 day
	}

	if(isset($_GET['action']) and $_GET['action']=="savecurent" )
	{
		include("koneksi.php");
		$ip=$uuid;
$savecurrentquery="SELECT genebaskets.gene_basket_name,genebaskets.harga,defaultgenebaskets.gene_basket_id FROM defaultgenebaskets LEFT JOIN genebaskets ON defaultgenebaskets.gene_basket_id=genebaskets.gene_basket_id where defaultgenebaskets.ip='$ip'";
		$savecurrent=mysql_query($savecurrentquery) or die("query gagal dijalankan");

			if(mysql_num_rows($savecurrent)!=0)
			{

		$savedata=mysql_fetch_assoc($savecurrent);
			$nama=$savedata['gene_basket_name'];
			if($nama=="default"){$nama="active";}
			$kode=$savedata['gene_basket_id'];
		$harga=$data['harga'];
			}




		$action="savecurent";
		$simpan=$action;
		$readonly="readonly=readonly";
	}


?>
<script type="text/javascript">
$(function(){

	$("#formBarang").submit(function(){
		if(document.getElementById('namebarangid').value!=""){
		$.ajax({
			url:$(this).attr("action"),
			type:$(this).attr("method"),
			data:$(this).serialize(),
			success:function(data){
				if(data==1)
				{

					$("#content").load("<?php print $GLOBALS['base_url']?>/plugins/genelist/crud/listbarang.php");
					page=$(this).attr("href")
					$("#Formcontent").html("").unload(page);
					return false
				}
				else
				{
					alert(data);
				}
			}
		});
		}else{
		alert('Please type in name to new gene list!');
		}

		return false;
	});

})
</script>

<form method="post" name="formBarang" action="<?php print $GLOBALS['base_url']?>/plugins/genelist/crud/proses.php" id="formBarang">
<table width="400">
<input type="hidden" name="genebasketid" size="20" value="<?php echo $kode;?>" />
<tr>
<td>name</td><td><input id="namebarangid" type="text" name="namabarang" size="20" value="<?php echo $nama;?>" />&nbsp;<input  type="submit" value="<?php echo $status;?>"/></td>
</tr>

<tr>
<td colspan="2"></td>
</tr>
</table>
<input type="hidden" name="action" value="<?php echo $action;?>" />

</form>
