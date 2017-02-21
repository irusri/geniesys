<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>
<body>
<?php
include("getgenelist.php");

//$tmparr=koneksi();
//print "initial list\n";

// print_r($tmparr);

//$tmp=array("POPTR_0006s13370","POPTR_0011s10540");
//removegenebasket($tmp);
//tmparr_second=getdefaultgenelist();
//print  '/nafeter removing list "POPTR_0001s28760","POPTR_0004s17470" array';
//print_r($tmparr_second);


//$tmp_second=array("POPTR_0030s00230","POPTR_0030s00250","POPTR_0007s07730");
//updategenebasketall($tmp_second);



//updategenebasketall($tmp_second);

$tmparr_second=getdefaultsamplelist();
//print  '/nafeter adding list "POPTR_0030s00210","POPTR_0006s11770 ","POPTR_0030s00230","POPTR_0030s00250" array';
print_r($tmparr_second);
?>

</body>
</html>
