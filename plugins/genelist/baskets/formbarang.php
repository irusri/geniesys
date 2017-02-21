<?php
include("koneksi.php");
$ip = $uuid;
$action = "new";
$status = "submit";
$readonly = "";
$kode = "";
$nama = '';
$harga = '';
if (isset($_GET['action']) and $_GET['action'] == "update"
    and!empty($_GET['genebasketid'])) {
    include("koneksi.php");
    $ip = $uuid;
    $str = "select * from genebaskets where gene_basket_id=".intval($_GET['genebasketid']);
    $res = mysql_query($str) or die("query gagal dijalankan");
    $data = mysql_fetch_assoc($res);
    //print_r($data);
    $kode = $data['gene_basket_id'];
    $nama = $data['gene_basket_name'];
    $harga = $data['harga'];
    $action = "update";
    $simpan = $action;
    $readonly = "readonly=readonly";
    //setcookie('blabla', $$nama, time() + (86400 * 30), "/"); // 86400 = 1 day
}
if (isset($_GET['action']) and $_GET['action'] == "savecurent") {
    include("koneksi.php");
    $ip = $uuid;
    $savecurrentquery = "SELECT genebaskets.gene_basket_name,genebaskets.harga,defaultgenebaskets.gene_basket_id FROM defaultgenebaskets LEFT JOIN genebaskets ON defaultgenebaskets.gene_basket_id=genebaskets.gene_basket_id where defaultgenebaskets.ip='$ip'";
    $savecurrent = mysql_query($savecurrentquery) or die("query gagal dijalankan");
    if (mysql_num_rows($savecurrent) != 0) {
        $savedata = mysql_fetch_assoc($savecurrent);
        $nama = $savedata['gene_basket_name'];
        if ($nama == "default") {
            $nama = "active";
        }
        $kode = $savedata['gene_basket_id'];
        $harga = $data['harga'];
    }
    $action = "savecurent";
    $simpan = $action;
    $readonly = "readonly=readonly";
}

?>
<script src="plugins/genelist/baskets/js/init_form.js" type="text/javascript"></script>
<form style="height: 36px;margin-bottom:16px" method="post" name="formBarang" action="plugins/genelist/baskets/proses.php" id="formBarang">
    <table style="border:1px solid #e15b63;border-radius: 10px;padding: 2px 2px 2px 2px;" width="100%">
        <input type="hidden" name="genebasketid" size="20" value="<?php echo $kode;?>" />
        <tr >
            <!-- <td>name</td> -->
            <td>
                <input id="namebarangid" type="text" name="namabarang" size="28" style="font-size:16px;width:80%;background-color: #fafafa  ; outline: none;border:none;color:blue;font-weight:bold;color:#7ab6ab" value="<?php echo $nama;?>" />&nbsp;
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
