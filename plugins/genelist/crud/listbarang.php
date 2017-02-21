<?php
	//require_once('sites/default/settings.php');
	//global $base_url;


	include("koneksi.php");
	$defaultgenebasketname = "";
$ip=$uuid;

	$str="select * from genebaskets where ip='$ip'";
	$res=mysql_query($str) or die("query gagal dijalankan");

	$defaultstr="SELECT genebaskets.gene_basket_name,genebaskets.gene_basket_id FROM defaultgenebaskets LEFT JOIN genebaskets ON defaultgenebaskets.gene_basket_id=genebaskets.gene_basket_id where defaultgenebaskets.ip='$ip'";
	$defaultresults=mysql_query($defaultstr) or die("query gagal dijalankan");

	if(mysql_num_rows($defaultresults)!=0)
		{
			$defaultgeenedata=mysql_fetch_assoc($defaultresults);
			$gbid=$defaultgeenedata['gene_basket_name'];
			$default_g_id=$defaultgeenedata['gene_basket_id'];
			$defaultgenebasketname=$gbid;
			if($defaultgenebasketname=="default"){$defaultgenebasketname="active";}
			echo 'view active genelist (<font style="color:#FF0000" width="3"  id="defaultgenebasket">'.$defaultgenebasketname.'</font>) <a href="plugins/genelist/tool.php" data-toggle="modal" data-target="#myModal" onclick="hidemef(this)" data-refresh="true"><font  style="color:#00F" >here</font></a>.';

		}else{

   $checkbasketsquery="SELECT genebaskets.gene_basket_id FROM genebaskets WHERE genebaskets.ip='$ip'";
	$checkbasketsresults=mysql_query($checkbasketsquery) or die("query gagal dijalankan");

	if(mysql_num_rows($checkbasketsresults)!=0){
		$defaultgenebasketname='no active genelist selected! click one of following gene list name to use it as a active genelist.';
		}else{
		$defaultgenebasketname ='add few genes to active genelist <a style="cursor:pointer"  onclick="open_genelist();"><font style="color:#00F" width="3"  id="defaultgenebasket">here</font></a>.'	;
		}

			 echo $defaultgenebasketname;
		}

	?>
<script type="text/javascript">
function hidemef(e){
	$("#numberofgenesSpanDetail").hide();
	$('.sticklr-arrow').hide();
	}

$(function(){
	$.ajaxSetup ({
    // Disable caching of AJAX responses
   // cache: false
});
	$("a.edit").click(function(){
		page=$(this).attr("href");
		$("#Formcontent").html("loading...").load(page);
		return false;
	})
	$("a.delete").click(function(){
		el=$(this);
		if(confirm("Are you sure you want to delete this gene list,you will loose all the genes in it?"))
		{

			$.ajax({
				url:$(this).attr("href"),
				type:"GET",
				success:function(hasil)
				{
					if(hasil==1)
					{

						$("#content").load("<?php print $GLOBALS['base_url']?>/plugins/genelist/crud/listbarang.php");

						updategenebasket();

						el.parent().parent().fadeOut('slow');
					}
					else
					{
						alert(hasil);
					}
				}
			})
		}

		return false;
	})

		$("a.bname").click(function(){

				 var valuest = $(this).attr("id");
			$.ajax({
				url:$(this).attr("href"),
				type:"GET",
				success:function(hasil)
				{

					if(hasil==1)
					{


							page4=$(this).attr("href");
							$("#content").load("<?php print $GLOBALS['base_url']?>/plugins/genelist/crud/listbarang.php");
							//$("#numberofgenesSpan").html(valuest).load(page4);
						updategenebasket();

					}
					else
					{
						alert(hasil);
					}
				}
			})

			return false;
		})



})


function changespeciesdropdown(tmpcookie){


	//console.log(tmpcookie);
	if(tmpcookie.match(/^potr[aisx]$/)){

		$('#poplar_species_select').val(tmpcookie).change();
		setCookie("select_species",tmpcookie,10);
	}

	}
</script>


 <font size="1px"> <?php /*?>?php echo 'This details associated with '.$ip.' address.';?><?php */?></font>
<table  width="100%" border="0" cellpadding="0" cellspacing="0">
<thead>
<tr bgcolor="#CCCCCC">
<!--<th>NO</th>--><th>genelist name</th><th>genes</th><th width="50">rename</th><th width="50">delete</th>
</tr>
</thead>
<tbody>
<?php while($data=mysql_fetch_assoc($res)){?>
<tr>
<td><a onclick="changespeciesdropdown('<?php echo $data['gene_basket_name'];?>')" href="<?php print $GLOBALS['base_url']?>/plugins/genelist/crud/proses.php?action=updatedefaultgene&genebasketid=<?php echo $data['gene_basket_id'];?>"  id="<?php echo $data['harga'];?>"  class="bname"><?php  if($data['gene_basket_name']=="default"){$data['gene_basket_name']="active";}
if($data['gene_basket_id']==$default_g_id){
	print '<font style="color:#FF0000">'.$data['gene_basket_name'].'</font>';
}else{
	print '<font style="color:#00F">'.$data['gene_basket_name'].'</font>';
}

?></a></td><td>


<?php
if($data['gene_basket_id']==$default_g_id){
	?>
    <script>
	var defaultgenelistname="<?php echo $data['gene_basket_name']?>";
	changespeciesdropdown(defaultgenelistname);
	</script>
    <?php
	print '<font style="color:#FF0000">'.$data['harga'].'</font>';
}else{
	echo $data['harga'];
}
?></td><td><a href="<?php print $GLOBALS['base_url']?>/plugins/genelist/crud/formbarang.php?action=update&genebasketid=<?php echo $data['gene_basket_id'];?>" class="edit">
<?php
if($data['gene_basket_id']==$default_g_id){
	print '<font style="color:#FF0000">rename</font>';
}else{
	echo 'rename';
}
?>



</a></td><td><a href="<?php print $GLOBALS['base_url']?>/plugins/genelist/crud/proses.php?action=delete&genebasketid=<?php echo $data['gene_basket_id'];?>" class="delete">
<?php
if($data['gene_basket_id']==$default_g_id){
	print '<font style="color:#FF0000">delete</font>';
}else{
	echo 'delete';
}
?></a></td>
</tr>
<?php }?>
</tbody>
</table>
