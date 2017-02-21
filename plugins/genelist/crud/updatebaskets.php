<?php

if (isset($_GET)) {
    $baskettype = $_GET['id'];
}
include("koneksi.php");
$ip = $uuid;
if ($baskettype == "gene") {
    $getgenelistsql = "SELECT genebaskets.harga FROM genebaskets JOIN defaultgenebaskets ON  genebaskets.gene_basket_id=defaultgenebaskets.gene_basket_id where defaultgenebaskets.ip='$ip'";
    $genelistresults = mysql_query($getgenelistsql) or die("query gagal dijalankan");
    if (mysql_num_rows($genelistresults) != 0) {
        $genelistdata   = mysql_fetch_assoc($genelistresults);
        $genelistnumber = $genelistdata['harga'];
    } else {
        $genelistnumber = '0';
    }
    echo $genelistnumber;
} else if ($baskettype == "sample") {
    $getsamplelistsql = "SELECT samplebaskets.harga FROM samplebaskets where samplebaskets.ip='$ip'";
    $sampplelistresults = mysql_query($getsamplelistsql) or die("query gagal dijalankan");
    if (mysql_num_rows($sampplelistresults) != 0) {
        $samplelistdata   = mysql_fetch_assoc($sampplelistresults);
        $samplelistnumber = $samplelistdata['harga'];
    } else {
        $samplelistnumber = '0';
    }
    echo $samplelistnumber;
} else if ($baskettype == "go") {
    $getgolistsql = "SELECT gobaskets.harga FROM gobaskets where gobaskets.ip='$ip'";
    $golistresults = mysql_query($getgolistsql) or die("query gagal dijalankan");
    if (mysql_num_rows($golistresults) != 0) {
        $golistdata   = mysql_fetch_assoc($golistresults);
        $golistnumber = $golistdata['harga'];
    } else {
        $golistnumber = '0';
    }
    echo $golistnumber;
}
?>
