<?php
//session_name('apache');
#echo ' Client IP: ';


chdir('/mnt/spruce/www/v3'); 
//echo getcwd ();
require_once('/mnt/spruce/www/v3/includes/bootstrap.inc');
drupal_bootstrap(DRUPAL_BOOTSTRAP_FULL);
global $user;


//include("/mnt/spruce/www/popgenie1/crud/koneksi.php");
//include  '/mnt/spruce/www/popgenie1/popgenie_global.php';
//require_once 'popconnection.php';
header('Cache-Control: no-cache');
  		header('Pragma: no-cache');

//$ip=$uuid;

#echo session_id();
//setcookie("popgenieMenu", $session_id);
//echo $session_id;
//echo session_id();
#echo session_id();
	#echo "User=". $_SESSION['user'];*/
	#http://130.239.131.199/upscgenesearch/homepage/cytoTEMP.php new directory site


?>
<html>
<script type="text/javascript">
document.domain="popgenie.org"; 

//alert(selectedCheckboxes.toString());
// for(var k=0;k<selectedCheckboxes.length;k++){
//	document.getElementById('p2j2').value=selectedCheckboxes.toString(); 
 //}
 
</script>


 <!-- <input type="button" onClick="parent.updateallbaskets()" value="test update"/>  -->
<?php

/* $defaultstr="SELECT genebaskets.genelist FROM defaultgenebaskets LEFT JOIN genebaskets ON defaultgenebaskets.gene_basket_id=genebaskets.gene_basket_id where defaultgenebaskets.ip='$ip'";
		$defaultresults=mysql_query($defaultstr) or die("query gagal dijalankan");
		
			if(mysql_num_rows($defaultresults)!=0)	{
			$defaultgeenedata=mysql_fetch_assoc($defaultresults);
							$genessendStringt=$defaultgeenedata['genelist'];
							
//echo $genessendStringt;
		
				
				
				}*/
	
	include("/mnt/spruce/www/v3/crud/getgenelist.php");

$genessendStringt =  implode(',',getdefaultgenelist()); 		
			
?>

<INPUT   type="hidden" ID= "p2j" VALUE="<?php if($genessendStringt!=""){ $displaygeneString=$genessendStringt;
									 $displaygenesendpattern = '/\s+/';
  									 $displaygenesendreplacement = '.1,   ';
									 $Encrypter_variables= array(".1,",".1");
						$displaygeneString= preg_replace($displaygenesendpattern, $displaygenesendreplacement, $displaygeneString);
									//		$displaygeneString=$displaygeneString.'.1';
								//	$displaygeneString= preg_replace("/,   .1/", "", $displaygeneString);
									//geneNumbertoGenie($_SESSION['genes_send']);
									echo $genessendStringt;
									//geneNumbertoGenie($_SESSION['genes_send']);
									}else{
										//geneNumbertoGenie(0);
										echo "";
										//geneNumbertoGenie("");
										};?> "/>
<head>
  <script type="text/javascript" src="swfobject.js"></script>

      <script type="text/javascript">
	
          function querySt(ji) {
              hu = window.location.search.substring(1);
              gy = hu.split("&");
              for (i = 0; i < gy.length; i++) {
                  ft = gy[i].split("=");
                  if (ft[0] == ji) {
                      return ft[1];
                  }
              }
              return "";
          }
          function setUrlHash(url) {
              parent.location.hash = url;
          }
          var flashvars = {};
         // if (querySt("type") != "") { 
              flashvars.type = "functional";//querySt("type");
          //}
          if (p2j.value != "") {
            flashvars.agi=p2j.value;//querySt("agi");
          }
		 //  if (selectedCheckboxes.length> 0) {
           // flashvars.chkstr=selectedCheckboxes.toString();//querySt("agi");
          //}
		  
          var params = {
            scale: "noscale",
            quality: "best",
            align: "middle",
            wmode: "gpu",
			wmode: "transparent",
            bgcolor: "#ccc",
            devicefont: "false",
            allowScriptAccess: "sameDomain",
            allowFullScreen: "true",
            allowNetworking: "all"
          };
         var attributes = {};
         swfobject.embedSWF("/mnt/spruce/www/bt/Newbulktool.swf", "mainContent", "100%", "100%", "10.0.0", null, flashvars, params, attributes);
      </script>
</head>


               
<body  >



<!--	<form enctype="multipart/form-data" action="index2.php" target="_self" method="post" >
								<div class="all_form">
						

									<div class="text_area">
										<table>
										<tr><td>Gene IDs:<td><tr>
										</table>
										<input type="text" style="background-color:#FFFFFD" value=" id="genes_send" name="genes_send"  ></input>
										</div>
								</div>
								<div class="submit_button">
										<input type="submit" value="Submit"/>
								</div>
							</form>-->
     <style>
        /* Suggestions by: http://blog.deconcept.com/2005/01/02/100-height-and-100-width-xhtml-flash-embed/ */
        html {
            height: 100%;
            overflow: hidden;
        }
        body, mainContent {
            background-color: #cccc;
            background: url(/images/career_background.png);
            margin: 0;
            padding: 0;
            font-size: 11px;
            font-family: Arial;
            color: #999;
            height: 100%;
            overflow: hidden;
        }
        a {
            text-decoration: none;
            color: #ccc;
        }
      </style>
      <div id="mainContent" style="height: 100%">
         <br><br>
         <table width="500" align="center">
            <tr>
              <td>
                  <h1>Browser Flash Support</h1>
                  In order to use the Gene Search tool, you will require the latest version of Flash (v11). Please follow the link below to continue. If you continue to have trouble contact the system administrator.
                  <br><br>
                  <a href="http://get.adobe.com/flashplayer/"><img border="0" src="http://www.adobe.com/images/shared/download_buttons/get_adobe_flash_player.png"></a>
                  <br><br>
              </td>
            </tr>
        </table>
      </div>                          
                            
</body>
</html>
