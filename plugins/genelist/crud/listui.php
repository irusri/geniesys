<?php
include("common.php");
$defaultgenebasketname = "";
$ip = $uuid;
$str = "select * from genebaskets where ip='$ip'";
$res = mysqli_query($genelist_connection,$str) or die("broken connection");
$defaultstr = "SELECT genebaskets.gene_basket_name,genebaskets.gene_basket_id FROM defaultgenebaskets LEFT JOIN genebaskets ON defaultgenebaskets.gene_basket_id=genebaskets.gene_basket_id where defaultgenebaskets.ip='$ip'";
$defaultresults = mysqli_query($genelist_connection,$defaultstr) or die("broken connection");
if (mysqli_num_rows($defaultresults) != 0) {
    $defaultgeenedata = mysqli_fetch_assoc($defaultresults);
    $gbid = $defaultgeenedata['gene_basket_name'];
    $default_g_id = $defaultgeenedata['gene_basket_id'];
    $defaultgenebasketname = $gbid;
    if ($defaultgenebasketname == "default") {
        $defaultgenebasketname = "active";
    }
    echo ' <a  onclick="open_samplelist();" href="plugins/genelist/tool.php" data-toggle="modal" data-target="#myModal" onclick="hidemef(this)" data-refresh="true"><font style="color:#666">Click here to view (<font style="color:#FF0000" width="3"  id="defaultgenebasket">'.$defaultgenebasketname.
    '</font>) genelist </font></a><font size="1">&nbsp<br></font>';
} else {
    $checkbasketsquery = "SELECT genebaskets.gene_basket_id FROM genebaskets WHERE genebaskets.ip='$ip'";
    $checkbasketsresults = mysqli_query($genelist_connection,$checkbasketsquery) or die("broken connection");
    if (mysqli_num_rows($checkbasketsresults) != 0) {
        $defaultgenebasketname = '<font style="color:#7ab6ab">No active genelist selected!, click the following list to make it as an active genelist.</font>';
    } else {
        $defaultgenebasketname = '<font style="color:#7ab6ab">Click  <a style="cursor:pointer"  onclick="open_genelist();"><font style="color:#00F" width="3"  id="defaultgenebasket">here</font></a> to open the GeneList.</font>';
    }
    echo $defaultgenebasketname;
}
	?>
<script src="plugins/genelist/crud/js/init_list.js" type="text/javascript"></script>
<table style="border-color:none" width="100%" border="0" cellpadding="0" cellspacing="0">
   <tbody>
      <?php while($data=mysqli_fetch_assoc($res)){?>
      <tr>
         <td><a onclick="changespeciesdropdown('<?php echo $data['gene_basket_name'];?>')" href="plugins/genelist/crud/process.php?action=updatedefaultgene&genebasketid=<?php echo $data['gene_basket_id'];?>" id="<?php echo $data['harga'];?>" class="bname"><?php  if($data['gene_basket_name']=="default"){$data['gene_basket_name']="active";}
            if($data['gene_basket_id']==$default_g_id){
            	print '<font style="color:#FF0000">'.$data['gene_basket_name'].'</font>&nbsp;</a><span class="hint--top hint--error" aria-label="Open '.$data['gene_basket_name'].' gene list" style="cursor: pointer" ><a  href="plugins/genelist/tool.php" data-toggle="modal" data-target="#myModal" onclick="hidemef(this)"  data-refresh="true" class="fa fa-eye" aria-hidden="true"></a></span>';
            }else{
            	print '<font style="color:#7ab6ab">'.$data['gene_basket_name'].'</font>&nbsp;</a>';
            }

            ?></td>
         <td>
            <?php
               if($data['gene_basket_id']==$default_g_id){
               	?>
            <script>
               var defaultgenelistname = "<?php echo $data['gene_basket_name']?>";
               changespeciesdropdown(defaultgenelistname);
            </script>
            <?php
               print '<font style="color:#FF0000">'.$data['harga'].'</font>';
               }else{
               echo $data['harga'];
               }
               ?>
         </td>
         <td><a href="plugins/genelist/crud/formui.php?action=update&genebasketid=<?php echo $data['gene_basket_id'];?>" class="edit">
            <?php
               if($data['gene_basket_id']==$default_g_id){
               	print '<span class="hint--top hint--error" aria-label="Rename GeneList"><font style="color:#FF0000"><i class="tablemenu fa-edit"></i></font></span>';
               }else{
               	echo '<span class="hint--top" aria-label="Rename GeneList"><i class="tablemenu fa-edit"></i></span>';
               }
               ?>
            </a>
         </td>
         <td><a href="plugins/genelist/crud/process.php?action=delete&genebasketid=<?php echo $data['gene_basket_id'];?>" class="delete">
            <?php
               if($data['gene_basket_id']==$default_g_id){
               	print '<span class="hint--left hint--error" aria-label="Delete GeneList"><font style="color:#FF0000"><i class="tablemenu fa-trash"></i></font></span>';
               }else{
               	echo '<span class="hint--left" aria-label="Delete GeneList"><i class="tablemenu fa-trash"></i></span>';
               }
               ?></a>
         </td>
      </tr>
      <?php }?>
   </tbody>
</table>
