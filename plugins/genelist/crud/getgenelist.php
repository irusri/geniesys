<?php
include_once ("common.php");
$ip = $uuid;
function getdefaultsamplelist() {
    include ("common.php");
    $ip = $uuid;
    $sampleliststr = "SELECT samplebaskets.samplelist,samplebaskets.sample_basket_id FROM samplebaskets WHERE samplebaskets.ip='$ip'";
    $samplelistresults = mysqli_query($genelist_connection, $sampleliststr) or die("broken connection");
    if (mysqli_num_rows($samplelistresults) != 0) {
        $defaultsampledata = mysqli_fetch_assoc($samplelistresults);
        $samplesendstringt = $defaultsampledata['samplelist'];
        $sampletemparr = explode(',', $samplesendstringt);
        return $sampletemparr;
    }
}
function getdefaultgolist() {
    include ("common.php");
    $ip = $uuid;
    $sampleliststr = "SELECT gobaskets.golist FROM gobaskets WHERE gobaskets.ip='$ip'";
    $samplelistresults = mysqli_query($genelist_connection, $sampleliststr) or die("broken connection");
    if (mysqli_num_rows($samplelistresults) != 0) {
        $defaultsampledata = mysqli_fetch_assoc($samplelistresults);
        $samplesendstringt = $defaultsampledata['golist'];
        $sampletemparr = explode(',', $samplesendstringt);
        return $sampletemparr;
    }
}
function getdefaultgenelist() {
    include ("common.php");
    $ip = $uuid;
    $defaultstr = "SELECT genebaskets.genelist FROM defaultgenebaskets LEFT JOIN genebaskets ON defaultgenebaskets.gene_basket_id=genebaskets.gene_basket_id where defaultgenebaskets.ip='$ip'";
    $defaultresults = mysqli_query($genelist_connection, $defaultstr) or die("broken connection");
    if (mysqli_num_rows($defaultresults) != 0) {
        $defaultgeenedata = mysqli_fetch_assoc($defaultresults);
        $genessendStringt = $defaultgeenedata['genelist'];
        $tmpArr = explode(',', $genessendStringt);
        return $tmpArr;
    }
}
function getdefaultgenelistname() {
    include ("common.php");
    $ip = $uuid;
    $defaultstr = "SELECT genebaskets.gene_basket_name FROM defaultgenebaskets LEFT JOIN genebaskets ON defaultgenebaskets.gene_basket_id=genebaskets.gene_basket_id where defaultgenebaskets.ip='$ip'";
    $defaultresults = mysqli_query($genelist_connection, $defaultstr) or die("broken connection");
    if (mysqli_num_rows($defaultresults) != 0) {
        $defaultgeenedata = mysqli_fetch_assoc($defaultresults);
        $genessendStringt = $defaultgeenedata['gene_basket_name'];
        //$tmpArr=explode(',',$genessendStringt);
        return $genessendStringt;
    }
}
function updategenebasket($genearray) {
    include ("common.php");
    $ip = $uuid;
    $genessendaddStringArray = array_unique($genearray);
    $genessendaddString = implode(",", $genessendaddStringArray);
    $check = mysqli_query($genelist_connection, "select * from defaultgenebaskets where ip='$ip'");
    if (mysqli_num_rows($check) == 0) {
        // NO DEFAULT GENEBASKETS,INSTERED
        $initcounts = count($genessendaddStringArray);
        mysqli_query($genelist_connection, "insert into genebaskets(gene_basket_id,gene_basket_name,harga,genelist,ip) values('$kid','default','$initcounts','$genessendaddString','$ip')") or die("insert failed");
        mysqli_query($genelist_connection, "insert into defaultgenebaskets(defaultgenebaskets.gene_basket_id,defaultgenebaskets.ip) SELECT LAST_INSERT_ID(gene_basket_id),'$ip' from genebaskets WHERE ip='$ip' ORDER BY gene_basket_id DESC Limit 1;");
        //return $genessendaddString;
        
    } else {
        //FOUND DEFAULT genes
        $defaultstr = "SELECT genebaskets.genelist,genebaskets.gene_basket_id FROM defaultgenebaskets LEFT JOIN genebaskets ON defaultgenebaskets.gene_basket_id=genebaskets.gene_basket_id where defaultgenebaskets.ip='$ip'";
        $defaultresults = mysqli_query($genelist_connection, $defaultstr) or die("broken connection");
        if (mysqli_num_rows($defaultresults) != 0) {
            $defaultgeenedata = mysqli_fetch_assoc($defaultresults);
            $dbgenesStr = $defaultgeenedata['genelist'];
            $basketid = $defaultgeenedata['gene_basket_id'];
            $dbgenesStrArray = explode(",", $dbgenesStr);
            if (strlen($dbgenesStr) < 5) {
                //EMPTY gene basket
                $initcount = count($genessendaddStringArray);
                mysqli_query($genelist_connection, "update genebaskets set genelist='$genessendaddString',harga='$initcount' where gene_basket_id='$basketid'") or die("update failed");
                //echo 'harga'.$defaultstr;
                
            } else {
                //Gene basket with genes
                $tmpresultArr = array_merge($dbgenesStrArray, $genessendaddStringArray);
                $updategenelistArr = array_unique($tmpresultArr);
                $updatecount = count($updategenelistArr);
                $updategenelist = implode(',', $updategenelistArr);
                mysqli_query($genelist_connection, "update genebaskets set genelist='$updategenelist',harga='$updatecount' where gene_basket_id='$basketid'") or die("update failed");
                //echo '2'.$updategenelist;
                
            }
        } else {
        }
        //mysqli_query($genelist_connection,"update defaultgenebaskets set gene_basket_id='$kid' where ip='$ip'") or die ("update failed");
        
    }
}
####Testing STARTS
function updategenebasket_testing($genearray, $basket_name_post) {
    include ("common.php");
    $ip = $uuid;
    $genessendaddStringArray = array_unique($genearray);
    $genessendaddString = implode(",", $genessendaddStringArray);
    $check = mysqli_query($genelist_connection, "select * from defaultgenebaskets where ip='$ip'");
    if (mysqli_num_rows($check) == 0) {
        // NO DEFAULT GENEBASKETS,INSTERED
        $initcounts = count($genessendaddStringArray);
        mysqli_query($genelist_connection, "insert into genebaskets(gene_basket_id,gene_basket_name,harga,genelist,ip) values('$kid','$basket_name_post','$initcounts','$genessendaddString','$ip')") or die("insert failed");
        mysqli_query($genelist_connection, "insert into defaultgenebaskets(defaultgenebaskets.gene_basket_id,defaultgenebaskets.ip) SELECT LAST_INSERT_ID(gene_basket_id),'$ip' from genebaskets WHERE ip='$ip' ORDER BY gene_basket_id DESC Limit 1;");
        //return $genessendaddString;
        
    } else {
        //FOUND DEFAULT genes
        $defaultstr = "SELECT genebaskets.genelist,genebaskets.gene_basket_id FROM defaultgenebaskets LEFT JOIN genebaskets ON defaultgenebaskets.gene_basket_id=genebaskets.gene_basket_id where defaultgenebaskets.ip='$ip'";
        $defaultresults = mysqli_query($genelist_connection, $defaultstr) or die("broken connection");
        if (mysqli_num_rows($defaultresults) != 0) {
            $defaultgeenedata = mysqli_fetch_assoc($defaultresults);
            $dbgenesStr = $defaultgeenedata['genelist'];
            $basketid = $defaultgeenedata['gene_basket_id'];
            $dbgenesStrArray = explode(",", $dbgenesStr);
            if (strlen($dbgenesStr) < 5) {
                //EMPTY gene basket
                $initcount = count($genessendaddStringArray);
                mysqli_query($genelist_connection, "update genebaskets set genelist='$genessendaddString',harga='$initcount' where gene_basket_id='$basketid'") or die("update failed");
                //echo 'harga'.$defaultstr;
                
            } else {
                //Gene basket with genes
                $tmpresultArr = array_merge($dbgenesStrArray, $genessendaddStringArray);
                $updategenelistArr = array_unique($tmpresultArr);
                $updatecount = count($updategenelistArr);
                $updategenelist = implode(',', $updategenelistArr);
                mysqli_query($genelist_connection, "update genebaskets set genelist='$updategenelist',harga='$updatecount' where gene_basket_id='$basketid'") or die("update failed");
                //echo '2'.$updategenelist;
                
            }
        } else {
        }
        //mysqli_query($genelist_connection,"update defaultgenebaskets set gene_basket_id='$kid' where ip='$ip'") or die ("update failed");
        
    }
}
####Testing END
################################################### TESTING NEW #################################################################
function updategenebasket_fast($genearray, $post_basket_name) {
    include ("common.php");
    $ip = $uuid;
    $genessendaddStringArray = array_unique($genearray);
    $genessendaddString = implode(",", $genessendaddStringArray);
    $initcount = count($genessendaddStringArray);
    $post_basket_name = trim($post_basket_name);
    $check_defaultgenebaskets = mysqli_query($genelist_connection, "select gene_basket_name,defaultgenebaskets.gene_basket_id from genebaskets join defaultgenebaskets on defaultgenebaskets.ip=genebaskets.ip and defaultgenebaskets.gene_basket_id=genebaskets.gene_basket_id where defaultgenebaskets.ip = '$ip';");
    if (mysqli_num_rows($check_defaultgenebaskets) != 0) {
        $defaultgeenedata = mysqli_fetch_assoc($check_defaultgenebaskets);
        $g_name = $defaultgeenedata['gene_basket_name'];
        $g_id = $defaultgeenedata['gene_basket_id'];
        //if(preg_match('/^potr[aisx]$/', $post_basket_name)==true){
        $check_genelist = mysqli_query($genelist_connection, "select gene_basket_name,gene_basket_id from genebaskets where ip='$ip' and gene_basket_name='$post_basket_name'");
        //echo "select gene_basket_name,gene_basket_id from genebaskets where ip='$ip' and gene_basket_name='$post_basket_name'";
        if (mysqli_num_rows($check_genelist) != 0) {
            $g_geenedata = mysqli_fetch_assoc($check_genelist);
            $g_g_name = $g_geenedata['gene_basket_name'];
            $g_g_id = $g_geenedata['gene_basket_id'];
            if ($g_name == $post_basket_name) {
                echo "given name is equal to species list name and the default genelist name# just update the genelist";
                mysqli_query($genelist_connection, "update genebaskets set genelist='$genessendaddString',harga='$initcount' where gene_basket_id='$g_id' and ip='$ip' ORDER BY gene_basket_id DESC Limit 1;;") or die("update failed");
            } else {
                if (preg_match('/^potr[aisx]$/', $g_name) == true) {
                    echo "default name is specieslist" . $g_g_name;
                    mysqli_query($genelist_connection, "update genebaskets set genelist='$genessendaddString',harga='$initcount' where gene_basket_id='$g_g_id' and ip='$ip' ORDER BY gene_basket_id DESC Limit 1;") or die("update failed");
                    mysqli_query($genelist_connection, "update defaultgenebaskets set gene_basket_id ='$g_g_id'  WHERE ip  = '$ip';") or die("update failed");
                } else {
                    echo "default name is not species list";
                    mysqli_query($genelist_connection, "update genebaskets set genelist='$genessendaddString',harga='$initcount' where gene_basket_id='$g_id' and ip='$ip' ORDER BY gene_basket_id DESC Limit 1;") or die("update failed");
                }
            }
        } else {
            echo "there is no genelist for this species name in genelistdb";
            mysqli_query($genelist_connection, "insert into genebaskets(gene_basket_id,gene_basket_name,harga,genelist,ip) values('$kid','$post_basket_name','$initcount','$genessendaddString','$ip')") or die("insert failed");
            mysqli_query($genelist_connection, "UPDATE defaultgenebaskets, genebaskets SET defaultgenebaskets.gene_basket_id = LAST_INSERT_ID(genebaskets.gene_basket_id) WHERE defaultgenebaskets.ip  = '$ip' and genebaskets.gene_basket_name='$post_basket_name';");
        }
        /*}else{
        //if genelistdb this name exixt update
        echo "this is not one of the species list";
        mysqli_query($genelist_connection,"insert into genebaskets(gene_basket_id,gene_basket_name,harga,genelist,ip) values('$kid','$post_basket_name','$initcount','$genessendaddString','$ip')") or die("insert failed");
        //	mysqli_query($genelist_connection,"update genebaskets set genelist='$genessendaddString',harga='$initcount' where gene_basket_id='$g_id' and ip='$ip' ORDER BY gene_basket_id DESC Limit 1;") or die("update failed");
         mysqli_query($genelist_connection,"UPDATE defaultgenebaskets, genebaskets SET defaultgenebaskets.gene_basket_id = LAST_INSERT_ID(genebaskets.gene_basket_id) WHERE defaultgenebaskets.ip  = '$ip' and genebaskets.gene_basket_name='$post_basket_name';");
        
        }*/
    } else {
        $check_genelist = mysqli_query($genelist_connection, "select gene_basket_name,gene_basket_id from genebaskets where ip='$ip' and gene_basket_name='$post_basket_name'");
        if (mysqli_num_rows($check_genelist) != 0) {
            $g_geenedata = mysqli_fetch_assoc($check_genelist);
            $g_g_name = $g_geenedata['gene_basket_name'];
            $g_g_id = $g_geenedata['gene_basket_id'];
            //if($g_g_name==$post_basket_name){
            //update the genelist
            echo "insert into default genelist";
            mysqli_query($genelist_connection, "update genebaskets set genelist='$genessendaddString',harga='$initcount' where gene_basket_id='$g_g_id' and ip='$ip'  ORDER BY gene_basket_id DESC Limit 1;") or die("update failed");
            mysqli_query($genelist_connection, "insert into defaultgenebaskets(defaultgenebaskets.gene_basket_id,defaultgenebaskets.ip) SELECT gene_basket_id,'$ip' from genebaskets WHERE ip='$ip' and gene_basket_id='$g_g_id' ORDER BY gene_basket_id DESC Limit 1;");
            //}else{
            //insert and insert
            //}
            
        } else {
            echo "insert and insert";
            mysqli_query($genelist_connection, "insert into genebaskets(gene_basket_id,gene_basket_name,harga,genelist,ip) values('$kid','$post_basket_name','$initcount','$genessendaddString','$ip')") or die("insert failed");
            //$get_genelist_id = "SELECT genebaskets.gene_basket_id FROM genebaskets where and gene_basket_name='$post_basket_name' and ip='$ip' ORDER BY gene_basket_id DESC Limit 1;";
            //$defaultresults = mysqli_query($genelist_connection,$defaultstr) or die("broken connection");
            mysqli_query($genelist_connection, "insert into defaultgenebaskets(defaultgenebaskets.gene_basket_id,defaultgenebaskets.ip) SELECT LAST_INSERT_ID(gene_basket_id),'$ip' from genebaskets WHERE ip='$ip' and gene_basket_name='$post_basket_name'");
        }
        /*mysqli_query($genelist_connection,"insert into genebaskets(gene_basket_id,gene_basket_name,harga,genelist,ip) values('$kid','$post_basket_name','$initcount','$genessendaddString','$ip')") or die("insert failed");
        //$get_genelist_id = "SELECT genebaskets.gene_basket_id FROM genebaskets where and gene_basket_name='$post_basket_name' and ip='$ip' ORDER BY gene_basket_id DESC Limit 1;";
        echo "$defaultresults = mysqli_query($genelist_connection,$defaultstr) or die;";
        mysqli_query($genelist_connection,"insert into defaultgenebaskets(defaultgenebaskets.gene_basket_id,defaultgenebaskets.ip) SELECT LAST_INSERT_ID(gene_basket_id),'$ip' from genebaskets WHERE ip='$ip' and gene_basket_name='$post_basket_name'");*/
    }
}
function updategenebasket_real($genearray, $post_basket_name) {
    include ("common.php");
    $ip = $uuid;
    $genessendaddStringArray = array_unique($genearray);
    $genessendaddString = implode(",", $genessendaddStringArray);
    $initcount = count($genessendaddStringArray);
    $post_basket_name = trim($post_basket_name);
    $check_genelist = mysqli_query($genelist_connection, "select * from genebaskets where ip='$ip'");
    if (mysqli_num_rows($check_genelist) != 0) {
        echo "There are genelist exist for this id";
        $check_genelist_and_species = mysqli_query($genelist_connection, "select * from genebaskets where gene_basket_name='$post_basket_name' and ip='$ip'");
        $check_defaultgenebaskets = mysqli_query($genelist_connection, "select gene_basket_id from defaultgenebaskets where ip='$ip'");
        if (mysqli_num_rows($check_genelist_and_species) != 0 && preg_match('/^potr[aisx]$/', $post_basket_name) == true) {
            $defaultstr = "SELECT genebaskets.gene_basket_name,genebaskets.gene_basket_id FROM defaultgenebaskets LEFT JOIN genebaskets ON defaultgenebaskets.gene_basket_id=genebaskets.gene_basket_id where defaultgenebaskets.ip='$ip'";
            $defaultgeenedata = mysqli_fetch_assoc($check_defaultgenebaskets);
            $basketid_new_id = $defaultgeenedata['gene_basket_id'];
            $ddefault_g_b = $defaultgeenedata['gene_basket_name'];
            if (mysqli_num_rows($check_defaultgenebaskets) != 0 && preg_match('/^potr[aisx]$/', $ddefault_g_b) == false) {
                echo "genelist is species list and that already exist in the DB\n<br>there is a default genelist but its not species list";
                mysqli_query($genelist_connection, "update genebaskets set genelist='$genessendaddString',harga='$initcount' where gene_basket_id='$basketid_new_id' and ip='$ip'  ORDER BY gene_basket_id DESC Limit 1;") or die("update failed");
            } else {
                echo "genelist is species list and that already exist in the DB but there is no default genelists ";
                mysqli_query($genelist_connection, "update genebaskets set genelist='$genessendaddString',harga='$initcount' where gene_basket_name='$post_basket_name' and ip='$ip'  ORDER BY gene_basket_id DESC Limit 1;") or die("update failed");
                mysqli_query($genelist_connection, "insert into defaultgenebaskets(defaultgenebaskets.gene_basket_id,defaultgenebaskets.ip) SELECT gene_basket_id,'$ip' from genebaskets WHERE ip='$ip' and gene_basket_name='$post_basket_name' ORDER BY gene_basket_id DESC Limit 1;");
            }
        } else {
            echo "genelist name not species ";
            mysqli_query($genelist_connection, "insert into genebaskets(gene_basket_id,gene_basket_name,harga,genelist,ip) values('$kid','$post_basket_name','$initcount','$genessendaddString','$ip')") or die("insert failed");
            if (mysqli_num_rows($check_defaultgenebaskets) != 0) {
                echo "there is a default genelist but not any of the aspen species for sure";
                //	echo "UPDATE defaultgenebaskets, genebaskets SET defaultgenebaskets.gene_basket_id = LAST_INSERT_ID(genebaskets.gene_basket_id) WHERE defaultgenebaskets.ip  = '$ip' and genebaskets.gene_basket_name='$post_basket_name';";
                $check_defaultgenebaskets = mysqli_query($genelist_connection, "UPDATE defaultgenebaskets, genebaskets SET defaultgenebaskets.gene_basket_id = LAST_INSERT_ID(genebaskets.gene_basket_id) WHERE defaultgenebaskets.ip  = '$ip' and genebaskets.gene_basket_name='$post_basket_name';");
                //echo $check_defaultgenebaskets ;
                
            } else {
                echo "there is no default genelist and not species for sure";
                mysqli_query($genelist_connection, "insert into defaultgenebaskets(defaultgenebaskets.gene_basket_id,defaultgenebaskets.ip) SELECT LAST_INSERT_ID(gene_basket_id),'$ip' from genebaskets WHERE ip='$ip' and gene_basket_name='$post_basket_name' ORDER BY gene_basket_id DESC Limit 1;");
            }
        }
    } else {
        echo "There are no already saved genelist exist for this id";
        mysqli_query($genelist_connection, "insert into genebaskets(gene_basket_id,gene_basket_name,harga,genelist,ip) values('$kid','$post_basket_name','$initcount','$genessendaddString','$ip')") or die("insert failed");
        //$get_genelist_id = "SELECT genebaskets.gene_basket_id FROM genebaskets where and gene_basket_name='$post_basket_name' and ip='$ip' ORDER BY gene_basket_id DESC Limit 1;";
        //$defaultresults = mysqli_query($genelist_connection,$defaultstr) or die("broken connection");
        mysqli_query($genelist_connection, "insert into defaultgenebaskets(defaultgenebaskets.gene_basket_id,defaultgenebaskets.ip) SELECT LAST_INSERT_ID(gene_basket_id),'$ip' from genebaskets WHERE ip='$ip' and gene_basket_name='$post_basket_name'");
    }
}
function updategenebasket_new($genearray, $basket_name_post) {
    include ("common.php");
    $ip = $uuid;
    $genessendaddStringArray = array_unique($genearray);
    $genessendaddString = implode(",", $genessendaddStringArray);
    $check_defaultgenebaskets = mysqli_query($genelist_connection, "select * from defaultgenebaskets where ip='$ip'");
    if (mysqli_num_rows($check_defaultgenebaskets) == 0) {
        ## NO active genelist
        ##Are there any GeneLists Avaiable by current GeneList name?
        $check_genebaskets = mysqli_query($genelist_connection, "select * from genebaskets where ip='$ip' and gene_basket_name='$basket_name_post'");
        if (mysqli_num_rows($check_genebaskets) != 0) {
            #YES
            $initcount = count($genessendaddStringArray);
            mysqli_query($genelist_connection, "update genebaskets set genelist='$genessendaddString',harga='$initcount' where  ip='$ip' and gene_basket_name='$basket_name_post'") or die("update failed");
            mysqli_query($genelist_connection, "insert into defaultgenebaskets(defaultgenebaskets.gene_basket_id,defaultgenebaskets.ip) SELECT LAST_INSERT_ID(gene_basket_id),'$ip' from genebaskets WHERE ip='$ip' and gene_basket_name='$basket_name_post' ORDER BY gene_basket_id DESC Limit 1;");
        } else {
            #NO
            $initcounts = count($genessendaddStringArray);
            mysqli_query($genelist_connection, "insert into genebaskets(gene_basket_id,gene_basket_name,harga,genelist,ip) values('$kid','$basket_name_post','$initcounts','$genessendaddString','$ip')") or die("insert failed");
            mysqli_query($genelist_connection, "insert into defaultgenebaskets(defaultgenebaskets.gene_basket_id,defaultgenebaskets.ip) SELECT LAST_INSERT_ID(gene_basket_id),'$ip' from genebaskets WHERE ip='$ip' and gene_basket_name='$basket_name_post' ORDER BY gene_basket_id DESC Limit 1;");
        }
    } else {
        ## YES Active GeneList exist
        ##Are there any GeneLists Avaiable by current GeneList name?
        $check_genebaskets_2 = mysqli_query($genelist_connection, "select * from genebaskets where ip='$ip' and gene_basket_name='$basket_name_post'");
        if (mysqli_num_rows($check_genebaskets) != 0) {
            ##YES
            $initcount = count($genessendaddStringArray);
            mysqli_query($genelist_connection, "update genebaskets set genelist='$genessendaddString',harga='$initcount' where and gene_basket_name='$basket_name_post' and gene_basket_name='$basket_name_post'") or die("update failed");
        } else {
            ##NO
            $initcounts = count($genessendaddStringArray);
            mysqli_query($genelist_connection, "insert into genebaskets(gene_basket_id,gene_basket_name,harga,genelist,ip) values('$kid','$basket_name_post','$initcounts','$genessendaddString','$ip')") or die("insert failed");
        }
    }
    exit();
    /*	if(is GeneList exist){
    if(is Species List exist and is the saving genelist name related to species){
    Update GeneList for unique user id and by species list name
    }else{
    if(is default genelist exist){
    Update genelist by default genelist id
    }else{
    Insert genelist and default genelist
    }
    }
    }else{
    	Insert into GeneList and GeneList name for unique id
    }
    
    */
    $check_genelist_and_species = mysqli_query($genelist_connection, "select * from genebaskets where gene_basket_name REGEXP '^potr[aisx]$' and ip='$ip'");
    $check_defaultgenebaskets = mysqli_query($genelist_connection, "select * from defaultgenebaskets where ip='$ip'");
    if (mysqli_num_rows($check_genelist_and_species) != 0) {
        mysqli_query($genelist_connection, "update genebaskets set genelist='$genessendaddString',harga='$initcount' where and gene_basket_name='$post_basket_name' and ip='$ip'") or die("update failed");
        if (mysqli_num_rows($check_defaultgenebaskets) != 0) {
        } else {
            mysqli_query($genelist_connection, "insert into genebaskets(gene_basket_id,gene_basket_name,harga,genelist,ip) values('$kid','$post_basket_name','$initcounts','$genessendaddString','$ip')") or die("insert failed");
        }
    } else {
        $check_genelist_any = mysqli_query($genelist_connection, "select * from genebaskets where gene_basket_name ip='$ip'");
        if (mysqli_num_rows($check_defaultgenebaskets) != 0) {
            mysqli_query($genelist_connection, "update genebaskets set genelist='$genessendaddString',harga='$initcount' where and gene_basket_name='$post_basket_name' and ip='$ip'") or die("update failed");
        } else {
            mysqli_query($genelist_connection, "insert into genebaskets(gene_basket_id,gene_basket_name,harga,genelist,ip) values('$kid','$post_basket_name','$initcounts','$genessendaddString','$ip')") or die("insert failed");
        }
        if (mysqli_num_rows($check_defaultgenebaskets) != 0) {
        } else {
            mysqli_query($genelist_connection, "insert into genebaskets(gene_basket_id,gene_basket_name,harga,genelist,ip) values('$kid','$post_basket_name','$initcounts','$genessendaddString','$ip')") or die("insert failed");
        }
    }
    $check_defaultgenebaskets = mysqli_query($genelist_connection, "select * from defaultgenebaskets where ip='$ip'");
    if (mysqli_num_rows($check_genelist_and_species) != 0) {
    } else {
        mysqli_query($genelist_connection, "insert into defaultgenebaskets(defaultgenebaskets.gene_basket_id,defaultgenebaskets.ip) SELECT LAST_INSERT_ID(gene_basket_id),'$ip' from genebaskets WHERE ip='$ip' and gene_basket_name='$basket_name_post' ORDER BY gene_basket_id DESC Limit 1;");
    }
    include ("common.php");
    $ip = $uuid;
    $genessendaddStringArray = array_unique($genearray);
    $genessendaddString = implode(",", $genessendaddStringArray);
    $check = mysqli_query($genelist_connection, "select * from defaultgenebaskets where ip='$ip'");
    if (mysqli_num_rows($check) == 0) {
        // NO DEFAULT GENEBASKETS,INSTERED
        $initcounts = count($genessendaddStringArray);
        mysqli_query($genelist_connection, "insert into genebaskets(gene_basket_id,gene_basket_name,harga,genelist,ip) values('$kid','$basket_name_post','$initcounts','$genessendaddString','$ip')") or die("insert failed");
        mysqli_query($genelist_connection, "insert into defaultgenebaskets(defaultgenebaskets.gene_basket_id,defaultgenebaskets.ip) SELECT LAST_INSERT_ID(gene_basket_id),'$ip' from genebaskets WHERE ip='$ip' ORDER BY gene_basket_id DESC Limit 1;");
        //return $genessendaddString;
        
    } else {
        //FOUND DEFAULT genes
        $defaultstr = "SELECT genebaskets.gene_basket_name,genebaskets.genelist,genebaskets.gene_basket_id FROM defaultgenebaskets LEFT JOIN genebaskets ON defaultgenebaskets.gene_basket_id=genebaskets.gene_basket_id where defaultgenebaskets.ip='$ip'";
        $defaultresults = mysqli_query($genelist_connection, $defaultstr) or die("broken connection");
        if (mysqli_num_rows($defaultresults) != 0) {
            $defaultgeenedata = mysqli_fetch_assoc($defaultresults);
            $dbgenesStr = $defaultgeenedata['genelist'];
            $basketid = $defaultgeenedata['gene_basket_id'];
            $baske_name = $defaultgeenedata['gene_basket_name'];
            $dbgenesStrArray = explode(",", $dbgenesStr);
            if ($baske_name == "potri" || $baske_name == "potrs" || $baske_name == "potrx" || $baske_name == "potra") {
                if (strlen($dbgenesStr) < 5) {
                    //EMPTY gene basket
                    $initcount = count($genessendaddStringArray);
                    mysqli_query($genelist_connection, "update genebaskets set genelist='$genessendaddString',harga='$initcount' where gene_basket_id='$basketid'") or die("update failed");
                    //echo 'harga'.$defaultstr;
                    
                } else {
                    //Gene basket with genes
                    $tmpresultArr = array_merge($dbgenesStrArray, $genessendaddStringArray);
                    $updategenelistArr = array_unique($tmpresultArr);
                    $updatecount = count($updategenelistArr);
                    $updategenelist = implode(',', $updategenelistArr);
                    mysqli_query($genelist_connection, "update genebaskets set genelist='$updategenelist',harga='$updatecount' where gene_basket_id='$basketid'") or die("update failed");
                    //echo '2'.$updategenelist;
                    
                }
            } else {
                $initcounts = count($genessendaddStringArray);
                mysqli_query($genelist_connection, "insert into genebaskets(gene_basket_id,gene_basket_name,harga,genelist,ip) values('$kid','$basket_name_post','$initcounts','$genessendaddString','$ip')") or die("insert failed");
                // mysqli_query($genelist_connection,"insert into defaultgenebaskets(defaultgenebaskets.gene_basket_id,defaultgenebaskets.ip) SELECT LAST_INSERT_ID(gene_basket_id),'$ip' from genebaskets WHERE ip='$ip' ORDER BY gene_basket_id DESC Limit 1;");
                //  mysqli_query($genelist_connection,"update genebaskets set genelist='$genessendaddString',harga='$initcount' where gene_basket_id='$basketid'") or die("update failed");
                
            }
        } else {
        }
        //mysqli_query($genelist_connection,"update defaultgenebaskets set gene_basket_id='$kid' where ip='$ip'") or die ("update failed");
        
    }
}
#################################################### TESTING END ########################################################################
function removegenebasket($removegenearray) {
    include ("common.php");
    $ip = $uuid;
    $genessendremovetringArr = array_unique($removegenearray);
    $genessendremovetring = implode(",", $genessendremovetringArr);
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
        echo 'no default gene basket selected';
    }
}
function updategenebasketall($updateallarr, $name = FALSE) {
    if ($name) {
        $basketname = $name;
    } else {
        $basketname = "default";
    }
    include ("common.php");
    $ip = $uuid;
    $updategenelistArrx = array_unique($updateallarr);
    $genessendaddString = implode(",", $updategenelistArrx);
    $checkme = mysqli_query($genelist_connection, "select * from defaultgenebaskets where ip='$ip'");
    if ($name != "explot list" && $name != "") {
        $checkme_genebasket = mysqli_query($genelist_connection, "select * from genebaskets where ip='$ip' AND gene_basket_name='$name'");
        if (mysqli_num_rows($checkme_genebasket) == 0) {
            $initcountsupdate = count($updategenelistArrx);
            mysqli_query($genelist_connection, "insert into genebaskets(gene_basket_id,gene_basket_name,harga,genelist,ip) values('$kid','$basketname','$initcountsupdate','$genessendaddString','$ip')") or die("insert failed");
            return $initcountsupdate;
        } else {
            $initcount = count($updategenelistArrx);
            mysqli_query($genelist_connection, "update genebaskets set genelist='$genessendaddString',harga='$initcount' where genebaskets.ip='$ip'  AND gene_basket_name='$name' ") or die("update failed");
        }
        return $initcountsupdate;
    }
    if ($name == "explot list") {
        $checkme_genebasket = mysqli_query($genelist_connection, "select * from genebaskets where ip='$ip' AND gene_basket_name='explot list'");
        if (mysqli_num_rows($checkme_genebasket) == 0) {
            $initcountsupdate = count($updategenelistArrx);
            mysqli_query($genelist_connection, "insert into genebaskets(gene_basket_id,gene_basket_name,harga,genelist,ip) values('$kid','$basketname','$initcountsupdate','$genessendaddString','$ip')") or die("insert failed");
            return $initcountsupdate;
        } else {
            $gene_AND_default_basket_id_query = "SELECT genebaskets.genelist,genebaskets.gene_basket_id FROM genebaskets where genebaskets.ip='$ip' AND gene_basket_name='explot list'";
            $gene_AND_default_basket_id_results = mysqli_query($genelist_connection, $gene_AND_default_basket_id_query);
            if (mysqli_num_rows($gene_AND_default_basket_id_results) == TRUE) {
                $gene_AND_default_basket_id_data = mysqli_fetch_assoc($gene_AND_default_basket_id_results);
                $gene_AND_default_basket_id = $gene_AND_default_basket_id_data['gene_basket_id'];
                $gene_AND_default_basket_id_genelist = $gene_AND_default_basket_id_data['genelist'];
                $gene_AND_default_basket_id_genelist_array = explode(",", $gene_AND_default_basket_id_genelist);
                if (strlen($gene_AND_default_basket_id_genelist) < 5) {
                    $initcount = count($updategenelistArrx);
                    mysqli_query($genelist_connection, "update genebaskets set genelist='$genessendaddString',harga='$initcount' where gene_basket_id='$gene_AND_default_basket_id'  AND gene_basket_name='explot list' ") or die("update failed");
                    return 3;
                } else {
                    $tmpresultArr = array_merge($gene_AND_default_basket_id_genelist_array, $updategenelistArrx);
                    $updategenelistArr = array_unique($tmpresultArr);
                    $updatecount = count($updategenelistArr);
                    $updategenelist = implode(',', $updategenelistArr);
                    mysqli_query($genelist_connection, "update genebaskets set genelist='$updategenelist',harga='$updatecount' where gene_basket_id='$gene_AND_default_basket_id' AND gene_basket_name='explot list'") or die("update failed");
                    return 4;
                }
            }
        }
    } else {
        if (mysqli_num_rows($checkme) == 0) {
            // NO DEFAULT GENEBASKETS,INSTERED
            $initcountsupdate = count($updategenelistArrx);
            mysqli_query($genelist_connection, "insert into genebaskets(gene_basket_id,gene_basket_name,harga,genelist,ip) values('$kid','$basketname','$initcountsupdate','$genessendaddString','$ip')") or die("insert failed");
            mysqli_query($genelist_connection, "insert into defaultgenebaskets(defaultgenebaskets.gene_basket_id,defaultgenebaskets.ip) SELECT LAST_INSERT_ID(gene_basket_id),'$ip' from genebaskets WHERE ip='$ip' ORDER BY gene_basket_id DESC Limit 1;");
            //return $genessendaddString;
            
        } else {
            //FOUND DEFAULT genes
            $defaultstru = "SELECT genebaskets.gene_basket_id FROM defaultgenebaskets LEFT JOIN genebaskets ON defaultgenebaskets.gene_basket_id=genebaskets.gene_basket_id where defaultgenebaskets.ip='$ip'";
            $defaultresultsu = mysqli_query($genelist_connection, $defaultstru) or die("broken connection");
            $dbgenesStrArrayu = implode(",", $updategenelistArrx);
            //EMPTY gene basket
            $initcountu = count($updategenelistArrx);
            if (mysqli_num_rows($defaultresultsu) != 0) {
                $cleardefaultbasketdatau = mysqli_fetch_assoc($defaultresultsu);
                $clearbasketidu = $cleardefaultbasketdatau['gene_basket_id'];
                mysqli_query($genelist_connection, "update genebaskets set genelist='$dbgenesStrArrayu',harga='$initcountu' where gene_basket_id='$clearbasketidu'") or die("update failed"); //echo '2'.$updategenelist;
                
            }
            //mysqli_query($genelist_connection,"update defaultgenebaskets set gene_basket_id='$kid' where ip='$ip'") or die ("update failed");
            
        }
    }
    //	return "sss";
    
}
function updategenebasketall_new($updateallarr, $name = FALSE) {
    if ($name) {
        $basketname = $name;
    } else {
        $basketname = "default";
    }
    include ("common.php");
    $ip = $uuid;
    $updategenelistArrx = array_unique($updateallarr);
    $genessendaddString = implode(",", $updategenelistArrx);
    $checkme = mysqli_query($genelist_connection, "select * from defaultgenebaskets where ip='$ip'");
    if ($name != "explot list" && $name != "") {
        $checkme_genebasket = mysqli_query($genelist_connection, "select * from genebaskets where ip='$ip' AND gene_basket_name='$name'");
        if (mysqli_num_rows($checkme_genebasket) == 0) {
            $initcountsupdate = count($updategenelistArrx);
            mysqli_query($genelist_connection, "insert into genebaskets(gene_basket_id,gene_basket_name,harga,genelist,ip) values('$kid','$basketname','$initcountsupdate','$genessendaddString','$ip')") or die("insert failed");
            return $initcountsupdate;
        } else {
            $initcount = count($updategenelistArrx);
            mysqli_query($genelist_connection, "update genebaskets set genelist='$genessendaddString',harga='$initcount' where genebaskets.ip='$ip'  AND gene_basket_name='$name' ") or die("update failed");
        }
        return $initcountsupdate;
    }
    if ($name == "explot list") {
        $checkme_genebasket = mysqli_query($genelist_connection, "select * from genebaskets where ip='$ip' AND gene_basket_name='explot list'");
        if (mysqli_num_rows($checkme_genebasket) == 0) {
            $initcountsupdate = count($updategenelistArrx);
            mysqli_query($genelist_connection, "insert into genebaskets(gene_basket_id,gene_basket_name,harga,genelist,ip) values('$kid','$basketname','$initcountsupdate','$genessendaddString','$ip')") or die("insert failed");
            return $initcountsupdate;
        } else {
            $gene_AND_default_basket_id_query = "SELECT genebaskets.genelist,genebaskets.gene_basket_id FROM genebaskets where genebaskets.ip='$ip' AND gene_basket_name='explot list'";
            $gene_AND_default_basket_id_results = mysqli_query($genelist_connection, $gene_AND_default_basket_id_query);
            if (mysqli_num_rows($gene_AND_default_basket_id_results) == TRUE) {
                $gene_AND_default_basket_id_data = mysqli_fetch_assoc($gene_AND_default_basket_id_results);
                $gene_AND_default_basket_id = $gene_AND_default_basket_id_data['gene_basket_id'];
                $gene_AND_default_basket_id_genelist = $gene_AND_default_basket_id_data['genelist'];
                $gene_AND_default_basket_id_genelist_array = explode(",", $gene_AND_default_basket_id_genelist);
                if (strlen($gene_AND_default_basket_id_genelist) < 5) {
                    $initcount = count($updategenelistArrx);
                    mysqli_query($genelist_connection, "update genebaskets set genelist='$genessendaddString',harga='$initcount' where gene_basket_id='$gene_AND_default_basket_id'  AND gene_basket_name='explot list' ") or die("update failed");
                    return 3;
                } else {
                    $tmpresultArr = array_merge($gene_AND_default_basket_id_genelist_array, $updategenelistArrx);
                    $updategenelistArr = array_unique($tmpresultArr);
                    $updatecount = count($updategenelistArr);
                    $updategenelist = implode(',', $updategenelistArr);
                    mysqli_query($genelist_connection, "update genebaskets set genelist='$updategenelist',harga='$updatecount' where gene_basket_id='$gene_AND_default_basket_id' AND gene_basket_name='explot list'") or die("update failed");
                    return 4;
                }
            }
        }
    } else {
        if (mysqli_num_rows($checkme) == 0) {
            // NO DEFAULT GENEBASKETS,INSTERED
            $initcountsupdate = count($updategenelistArrx);
            mysqli_query($genelist_connection, "insert into genebaskets(gene_basket_id,gene_basket_name,harga,genelist,ip) values('$kid','$basketname','$initcountsupdate','$genessendaddString','$ip')") or die("insert failed");
            mysqli_query($genelist_connection, "insert into defaultgenebaskets(defaultgenebaskets.gene_basket_id,defaultgenebaskets.ip) SELECT LAST_INSERT_ID(gene_basket_id),'$ip' from genebaskets WHERE ip='$ip' ORDER BY gene_basket_id DESC Limit 1;");
            //return $genessendaddString;
            
        } else {
            //FOUND DEFAULT genes
            $defaultstru = "SELECT genebaskets.gene_basket_id FROM defaultgenebaskets LEFT JOIN genebaskets ON defaultgenebaskets.gene_basket_id=genebaskets.gene_basket_id where defaultgenebaskets.ip='$ip'";
            $defaultresultsu = mysqli_query($genelist_connection, $defaultstru) or die("broken connection");
            $dbgenesStrArrayu = implode(",", $updategenelistArrx);
            //EMPTY gene basket
            $initcountu = count($updategenelistArrx);
            if (mysqli_num_rows($defaultresultsu) != 0) {
                $cleardefaultbasketdatau = mysqli_fetch_assoc($defaultresultsu);
                $clearbasketidu = $cleardefaultbasketdatau['gene_basket_id'];
                mysqli_query($genelist_connection, "update genebaskets set genelist='$dbgenesStrArrayu',harga='$initcountu' where gene_basket_id='$clearbasketidu'") or die("update failed"); //echo '2'.$updategenelist;
                
            }
            //mysqli_query($genelist_connection,"update defaultgenebaskets set gene_basket_id='$kid' where ip='$ip'") or die ("update failed");
            
        }
    }
    //	return "sss";
    
}
function sharetable($updateallarr, $name = FALSE, $randid = FALSE) {
    if ($name) {
        $basketname = $name;
    } else {
        $basketname = "default";
    }
    include ("common.php");
    $ip = $uuid;
    $updategenelistArrx = array_unique($updateallarr);
    $genessendaddString = implode(",", $updategenelistArrx);
    // NO DEFAULT GENEBASKETS,INSTERED
    $initcountsupdate = count($updategenelistArrx);
    $mysqldate = date('Y-m-d H:i:s');
    mysqli_query($genelist_connection, "DELETE FROM share_table WHERE time < (NOW() - INTERVAL 30 DAY) ;");
    mysqli_query($genelist_connection, "insert into share_table(gene_basket_id,gene_basket_name,harga,genelist,ip,time,randid) values('$kid','$basketname','$initcountsupdate','$genessendaddString','$ip','$mysqldate','$randid')") or die("insert failed");
}
function getdefaultsaredgenelist($randid) {
    include ("common.php");
    $ip = $uuid;
    $checkme = mysqli_query($genelist_connection, "select * from share_table where randid='$randid';");
    if (mysqli_num_rows($checkme) != 0) {
        $defaultstr = "SELECT share_table.genelist FROM share_table where share_table.randid='$randid'";
        $defaultresults = mysqli_query($genelist_connection, $defaultstr) or die("broken connection");
        if (mysqli_num_rows($defaultresults) != 0) {
            $defaultgeenedata = mysqli_fetch_assoc($defaultresults);
            $genessendStringt = $defaultgeenedata['genelist'];
            $tmpArr = explode(',', $genessendStringt);
            return $tmpArr;
        }
        echo 'null';
    } else {
        echo 'null';
    }
}
function checksharedlinkexist($randid) {
    include ("common.php");
    $ip = $uuid;
    $checkme = mysqli_query($genelist_connection, "select * from share_table where randid='$randid';");
    if (mysqli_num_rows($checkme) != 0) {
        $defaultstr = "SELECT time FROM share_table where randid='$randid';";
        $defaultresults = mysqli_query($genelist_connection, $defaultstr) or die("broken connection");
        $result = mysqli_fetch_assoc($defaultresults);
        $datetime = new DateTime($result['time']);
        echo $datetime->format('Y-m-d');
    } else {
        echo 'null';
    }
}
/*Updated on 4th December 2013 by Chanaka */
function updategobasket($genearray) {
    include ("common.php");
    $ip = $uuid;
    $samplestrArr = array_unique($genearray);
    $initcounts = count($samplestrArr);
    $sampleaddString = implode(",", $samplestrArr);
    $check = mysqli_query($genelist_connection, "SELECT * FROM gobaskets WHERE gobaskets.ip='$ip'");
    if (mysqli_num_rows($check) == 0) {
        mysqli_query($genelist_connection, "insert into gobaskets(go_basket_id,go_basket_name,harga,golist,ip) values('$kid','default','$initcounts','$sampleaddString','$ip')") or die("insert failed");
        echo $initcounts . '  added(1)';
    } else {
        $samplequerystr = "SELECT gobaskets.golist,gobaskets.go_basket_id FROM gobaskets WHERE gobaskets.ip='$ip'";
        $samplequeryresults = mysqli_query($genelist_connection, $samplequerystr) or die("broken connection");
        $samplequerydata = mysqli_fetch_assoc($samplequeryresults);
        $samplelisttmp = $samplequerydata['golist'];
        $samplelistidtmp = $samplequerydata['go_basket_id'];
        if ($samplelisttmp == "") {
            mysqli_query($genelist_connection, "update gobaskets set gobaskets.golist='$sampleaddString',gobaskets.harga='$initcounts' where gobaskets.go_basket_id='$samplelistidtmp'") or die("update failed");
            echo $initcounts . '  updated(2)';
        } else {
            $samplelisttmpArr = explode(",", $samplelisttmp);
            $tmpresultArr = array_merge($samplelisttmpArr, $samplestrArr);
            $filtertedtmpresultsArr = array_unique($tmpresultArr);
            $filteredupdatecount = count($filtertedtmpresultsArr);
            $filteredupdatedlist = implode(',', $filtertedtmpresultsArr);
            mysqli_query($genelist_connection, "update gobaskets set gobaskets.golist='$filteredupdatedlist',gobaskets.harga='$filteredupdatecount' where gobaskets.go_basket_id='$samplelistidtmp'") or die("update failed");
            //echo $filteredupdatecount.'->'.$filteredupdatedlist;
            echo $filteredupdatecount . '  updated(3)';
        }
    }
}
function removegobasket($removegenearray) {
    include ("common.php");
    $ip = $uuid;
    $samplesremoveArr = array_unique($removegenearray);
    $sampleremovecount = count($samplesremoveArr);
    $sampleremovetring = implode(",", $samplesremoveArr);
    $check2 = mysqli_query($genelist_connection, "SELECT * FROM gobaskets WHERE gobaskets.ip='$ip'") or die("broken connection");;
    if (mysqli_num_rows($check2) == 0) {
    } else {
        $sampleremovequerystr = "SELECT gobaskets.golist,gobaskets.go_basket_id FROM gobaskets WHERE gobaskets.ip='$ip'";
        $sampleremovequeryresults = mysqli_query($genelist_connection, $sampleremovequerystr) or die("broken connection");
        $sampleremovequerydata = mysqli_fetch_assoc($sampleremovequeryresults);
        $sampleremovelisttmp = $sampleremovequerydata['golist'];
        $sampleremovelistidtmp = $sampleremovequerydata['go_basket_id'];
        echo '1';
        if ($sampleremovelisttmp == "") {
        } else {
            $sampleremovelisttmpArr = explode(",", $sampleremovelisttmp);
            $tmpresultRemoveArr = array_diff($sampleremovelisttmpArr, $samplesremoveArr);
            $updatesamplelistRemoveArr = array_unique($tmpresultRemoveArr);
            $updatecountremove = count($updatesamplelistRemoveArr);
            $updatesremove = implode(',', $updatesamplelistRemoveArr);
            mysqli_query($genelist_connection, "update gobaskets set gobaskets.golist='$updatesremove',gobaskets.harga='$updatecountremove' where gobaskets.go_basket_id='$sampleremovelistidtmp'") or die("update failed");
            echo '2';
        }
    }
}
?>
