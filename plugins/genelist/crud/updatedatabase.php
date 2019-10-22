<?php
include ("common.php");
$ip = $uuid;
if (isset($_POST['genes_send']) || isset($_POST['genes_send_add'])) {
    $genessendaddString = trim($_POST['genes_send_add']);
    $genessendaddStringArray = explode(",", $genessendaddString);
    $genessendaddStringArray = array_unique($genessendaddStringArray);
    $genessendaddString = implode(",", $genessendaddStringArray);
    $check = mysqli_query($genelist_connection, "select * from defaultgenebaskets where ip='$ip'");
    if (isset($_POST['bname'])) {
        $bname = trim($_POST['bname']);
        $initcounts22 = count($genessendaddStringArray);
        $check_name = mysqli_query($genelist_connection, "select * from genebaskets where ip='$ip' AND gene_basket_name='$bname'");
        if (mysqli_num_rows($check_name) == 0) {
            mysqli_query($genelist_connection, "insert into genebaskets(gene_basket_id,gene_basket_name,harga,genelist,ip) values('$kid','$bname','$initcounts22','$genessendaddString','$ip')") or die("insert failed");
            if (mysqli_num_rows($check) == 0) {
                mysqli_query($genelist_connection, "insert into defaultgenebaskets(defaultgenebaskets.gene_basket_id,defaultgenebaskets.ip) SELECT LAST_INSERT_ID(gene_basket_id),'$ip' from genebaskets WHERE ip='$ip' ORDER BY gene_basket_id DESC Limit 1;");
            } else {
                mysqli_query($genelist_connection, "update defaultgenebaskets set gene_basket_id=(SELECT LAST_INSERT_ID(gene_basket_id) from genebaskets WHERE ip='$ip' ORDER BY gene_basket_id DESC Limit 1) where ip='$ip'");
            }
        } else {
            echo "error";
        }
        exit();
    }
    if (mysqli_num_rows($check) == 0) {
        // NO DEFAULT GENEBASKETS,INSTERED
        $initcounts = count($genessendaddStringArray);
        mysqli_query($genelist_connection, "insert into genebaskets(gene_basket_id,gene_basket_name,harga,genelist,ip) values('$kid','default','$initcounts','$genessendaddString','$ip')") or die("insert failed");
        mysqli_query($genelist_connection, "insert into defaultgenebaskets(defaultgenebaskets.gene_basket_id,defaultgenebaskets.ip) SELECT LAST_INSERT_ID(gene_basket_id),'$ip' from genebaskets WHERE ip='$ip' ORDER BY gene_basket_id DESC Limit 1;");
        echo $genessendaddString;
    } else {
        //FOUND DEFAULT genes
        $defaultstr = "SELECT genebaskets.genelist,genebaskets.gene_basket_id FROM defaultgenebaskets LEFT JOIN genebaskets ON defaultgenebaskets.gene_basket_id=genebaskets.gene_basket_id where defaultgenebaskets.ip='$ip'";
        $defaultresults = mysqli_query($genelist_connection, $defaultstr) or die("broken connection");
        if (mysqli_num_rows($defaultresults) != 0) {
            $defaultgeenedata = mysqli_fetch_assoc($defaultresults);
            $dbgenesStr = $defaultgeenedata['genelist'];
            $basketid = $defaultgeenedata['gene_basket_id'];
            $dbgenesStrArray = explode(",", $dbgenesStr);
            if ($dbgenesStr == "") {
                //EMPTY gene basket
                $initcount = count($genessendaddStringArray);
                mysqli_query($genelist_connection, "update genebaskets set genelist='$genessendaddString',harga='$initcount' where gene_basket_id='$basketid'") or die("update failed");
                echo '1' . $initcount . 't' . $genessendaddString;
            } else {
                //Gene basket with genes
                $tmpresultArr = array_merge($dbgenesStrArray, $genessendaddStringArray);
                $updategenelistArr = array_unique($tmpresultArr);
                $updatecount = count($updategenelistArr);
                $updategenelist = implode(',', $updategenelistArr);
                mysqli_query($genelist_connection, "update genebaskets set genelist='$updategenelist',harga='$updatecount' where gene_basket_id='$basketid'") or die("update failed");
                echo '2' . $updatecount . 't' . $updategenelist;
            }
        } else {
        }
        //mysqli_query($genelist_connection,"update defaultgenebaskets set gene_basket_id='$kid' where ip='$ip'") or die ("update failed");
        
    }
} else if (isset($_POST['genes_send_remove'])) {
    $genessendremovetring = trim($_POST['genes_send_remove']);
    $genessendremovetringArr = explode(",", $genessendremovetring);
    $updategenelistRemoveArr = array_unique($genessendremovetringArr);
    $defaultstrRemove = "SELECT genebaskets.genelist,genebaskets.gene_basket_id FROM defaultgenebaskets LEFT JOIN genebaskets ON defaultgenebaskets.gene_basket_id=genebaskets.gene_basket_id where defaultgenebaskets.ip='$ip'";
    $defaultresultsRemove = mysqli_query($genelist_connection, $defaultstrRemove) or die("broken connection");
    if (mysqli_num_rows($defaultresultsRemove) != 0) {
        $defaultgeeneremovedata = mysqli_fetch_assoc($defaultresultsRemove);
        $dbgenesremoveStr = $defaultgeeneremovedata['genelist'];
        $basketremoveid = $defaultgeeneremovedata['gene_basket_id'];
        $dbgenesStrRemoveArray = explode(",", $dbgenesremoveStr);
        if ($dbgenesremoveStr != "") {
            $tmpresultRemoveArr = array_diff($dbgenesStrRemoveArray, $genessendremovetringArr);
            $updategenelistRemoveArr = array_unique($tmpresultRemoveArr);
            $updatecountremove = count($updategenelistRemoveArr);
            $updategenelistremove = implode(',', $updategenelistRemoveArr);
            mysqli_query($genelist_connection, "update genebaskets set genelist='$updategenelistremove',harga='$updatecountremove' where gene_basket_id='$basketremoveid'") or die("update failed");
            //echo $updategenelistremove;
            
        } else {
            echo "no gene ids to remove";
        }
    } else {
        echo 'no default gene basket';
    }
} else if (isset($_POST['empty_default_basket'])) {
    $cleaarthebasketStr = "SELECT genebaskets.genelist,genebaskets.gene_basket_id FROM defaultgenebaskets LEFT JOIN genebaskets ON defaultgenebaskets.gene_basket_id=genebaskets.gene_basket_id where defaultgenebaskets.ip='$ip'";
    $clearthebasketmysql = mysqli_query($genelist_connection, $cleaarthebasketStr) or die("broken connection");
    if (mysqli_num_rows($clearthebasketmysql) != 0) {
        $cleardefaultbasketdata = mysqli_fetch_assoc($clearthebasketmysql);
        $clearbasketid = $cleardefaultbasketdata['gene_basket_id'];
    }
    mysqli_query($genelist_connection, "update genebaskets set genelist='',harga='0' where gene_basket_id='$clearbasketid'") or die("update failed");
    echo 'please clear me!';
} else if (isset($_POST['get_default_genes'])) {
    $defaultstr = "SELECT genebaskets.genelist FROM defaultgenebaskets LEFT JOIN genebaskets ON defaultgenebaskets.gene_basket_id=genebaskets.gene_basket_id where defaultgenebaskets.ip='$ip'";
    $defaultresults = mysqli_query($genelist_connection, $defaultstr) or die("broken connection");
    if (mysqli_num_rows($defaultresults) != 0) {
        $defaultgeenedata = mysqli_fetch_assoc($defaultresults);
        $genessendStringt = $defaultgeenedata['genelist'];
        echo $genessendStringt;
    }
} else if (isset($_POST['genes_send_add_new'])) {
    $genessendaddStringnew = trim($_POST['genes_send_add_new']);
    $genessendaddStringArraynew = explode(",", $genessendaddStringnew);
    $genessendaddStringArraynew = array_unique($genessendaddStringArraynew);
    $genessendaddStringnew = implode(",", $genessendaddStringArraynew);
    $initcountsnew = count($genessendaddStringArraynew);
    $check = mysqli_query($genelist_connection, "select * from defaultgenebaskets where ip='$ip'");
    if (mysqli_num_rows($check) != 0) {
        $defaultbasketname = "SELECT genebaskets.gene_basket_name FROM defaultgenebaskets LEFT JOIN genebaskets ON defaultgenebaskets.gene_basket_id=genebaskets.gene_basket_id where defaultgenebaskets.ip='$ip'";
        $defaultbasketnamemysql = mysqli_query($genelist_connection, $defaultbasketname) or die("broken connection");
        $defaultgeeneremovedata = mysqli_fetch_assoc($defaultbasketnamemysql);
        $defaultn = $defaultgeeneremovedata['gene_basket_name'];
        $defaultn.= '1';
        mysqli_query($genelist_connection, "insert into genebaskets(gene_basket_id,gene_basket_name,harga,genelist,ip) values('$kid','" . $defaultn . "','$initcountsnew','$genessendaddStringnew','$ip')") or die("insert failed");
        mysqli_query($genelist_connection, "update defaultgenebaskets set gene_basket_id=(SELECT LAST_INSERT_ID(gene_basket_id) from genebaskets WHERE ip='$ip' ORDER BY gene_basket_id DESC Limit 1) where ip='$ip';") or die("update failed");
    } else {
        mysqli_query($genelist_connection, "insert into genebaskets(gene_basket_id,gene_basket_name,harga,genelist,ip) values('$kid','new list','$initcountsnew','$genessendaddStringnew','$ip')") or die("insert failed");
        mysqli_query($genelist_connection, "insert into defaultgenebaskets(defaultgenebaskets.gene_basket_id,defaultgenebaskets.ip) SELECT LAST_INSERT_ID(gene_basket_id),'$ip' from genebaskets WHERE ip='$ip' ORDER BY gene_basket_id DESC Limit 1;");
    }
    //echo json_encode($initcountsnew);
    
} else if (isset($_POST['genes_send_add_new_cdn'])) {
    $genessendaddStringnew = trim($_POST['genes_send_add_new_cdn']);
    $basketnamecdn = trim($_POST['basketname']);
    $genessendaddStringArraynew = explode(",", $genessendaddStringnew);
    $genessendaddStringArraynew = array_unique($genessendaddStringArraynew);
    $genessendaddStringnew = implode(",", $genessendaddStringArraynew);
    $initcountsnew = count($genessendaddStringArraynew);
    $check = mysqli_query($genelist_connection, "select * from defaultgenebaskets where ip='$ip'");
    if (mysqli_num_rows($check) != 0) {
        $defaultbasketname = "SELECT genebaskets.gene_basket_name FROM defaultgenebaskets LEFT JOIN genebaskets ON defaultgenebaskets.gene_basket_id=genebaskets.gene_basket_id where defaultgenebaskets.ip='$ip'";
        $defaultbasketnamemysql = mysqli_query($genelist_connection, $defaultbasketname) or die("broken connection");
        $defaultgeeneremovedata = mysqli_fetch_assoc($defaultbasketnamemysql);
        $defaultn = $defaultgeeneremovedata['gene_basket_name'];
        $defaultn.= '1';
        mysqli_query($genelist_connection, "insert into genebaskets(gene_basket_id,gene_basket_name,harga,genelist,ip) values('$kid',' $basketnamecdn','$initcountsnew','$genessendaddStringnew','$ip')") or die("insert failed");
        mysqli_query($genelist_connection, "update defaultgenebaskets set gene_basket_id=(SELECT LAST_INSERT_ID(gene_basket_id) from genebaskets WHERE ip='$ip' ORDER BY gene_basket_id DESC Limit 1) where ip='$ip';") or die("update failed");
    } else {
        mysqli_query($genelist_connection, "insert into genebaskets(gene_basket_id,gene_basket_name,harga,genelist,ip) values('$kid',' $basketnamecdn','$initcountsnew','$genessendaddStringnew','$ip')") or die("insert failed");
        mysqli_query($genelist_connection, "insert into defaultgenebaskets(defaultgenebaskets.gene_basket_id,defaultgenebaskets.ip) SELECT LAST_INSERT_ID(gene_basket_id),'$ip' from genebaskets WHERE ip='$ip' ORDER BY gene_basket_id DESC Limit 1;");
    }
    $variablea = array('number' => $initcountsnew, 'name' => $basketnamecdn);
    echo json_encode($variablea);
}
?>