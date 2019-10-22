<?php
include("common.php");
$ip = $uuid;
$action = "new";
$status = "submit";
$readonly = "";
$kid = "";
$lname = '';
$cipher_count = '';
if (isset($_GET['action']) and $_GET['action'] == "update"
    and!empty($_GET['genebasketid'])) {
    include("common.php");
    $ip = $uuid;
    $str = "select * from genebaskets where gene_basket_id=".intval($_GET['genebasketid']);
    $res = mysqli_query($genelist_connection,$str) or die("broken connection");
    $data = mysqli_fetch_assoc($res);
    //print_r($data);
    $kid = $data['gene_basket_id'];
    $lname = $data['gene_basket_name'];
    $cipher_count = $data['harga'];
    $action = "update";
    $simp = $action;
    $readonly = "readonly=readonly";
    //setcookie('blabla', $$lname, time() + (86400 * 30), "/"); // 86400 = 1 day
}
if (isset($_GET['action']) and $_GET['action'] == "savecurent") {
    include("common.php");
    $ip = $uuid;
    $savecurrentquery = "SELECT genebaskets.gene_basket_name,genebaskets.harga,defaultgenebaskets.gene_basket_id FROM defaultgenebaskets LEFT JOIN genebaskets ON defaultgenebaskets.gene_basket_id=genebaskets.gene_basket_id where defaultgenebaskets.ip='$ip'";
    $savecurrent = mysqli_query($genelist_connection,$savecurrentquery) or die("broken connection");
    if (mysqli_num_rows($savecurrent) != 0) {
        $savedata = mysqli_fetch_assoc($savecurrent);
        $lname = $savedata['gene_basket_name'];
        if ($lname == "default") {
            $lname = "active";
        }
        $kid = $savedata['gene_basket_id'];
        $cipher_count = $data['harga'];
    }
    $action = "savecurent";
    $simp = $action;
    $readonly = "readonly=readonly";
}

?>
<script src="plugins/genelist/crud/js/init_form.js" type="text/javascript"></script>
<form style="height: 36px;margin-bottom:16px" method="post" name="formUI" action="plugins/genelist/crud/process.php" id="formUI">
    <table style="border:1px solid #e15b63;border-radius: 10px;padding: 2px 2px 2px 2px;" width="100%">
        <input type="hidden" name="genebasketid" size="20" value="<?php echo $kid;?>" />
        <tr >
            <!-- <td>name</td> -->
            <td>
                <input id="namebarangid" type="text" name="namabarang" size="28" style="font-size:16px;width:80%;background-color: #fafafa  ; outline: none;border:none;color:blue;font-weight:bold;color:#7ab6ab" value="<?php echo $lname;?>" />&nbsp;
                <!-- <button type="submit" value="" class="btn btn-default"><span id="submitformbtn"></span></button> -->
                <span class="hint--top" aria-label="Save GeneList"><button class="submitb" type="submit" style="font-size:20px;cursor:pointer;color:#909090"><i class="fa fa-save"></i></button></span>
            </td>
        </tr>
        <tr>
            <td colspan="2"></td>
        </tr>
    </table>
    <input type="hidden" name="action" value="<?php echo $action;?>" />
</form>
