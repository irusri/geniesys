<!doctype html>
<html lang="en">
   <head>
      <?php
         echo "<meta charset='utf-8'>
         <title>".$c['title']." : ".($c['page'])."</title>
         <base href='$hostname'>
         <link rel='stylesheet' href='themes/".$c['themeSelect']."/css/style.css'>
         <link rel='stylesheet' href='themes/".$c['themeSelect']."/css/hint.min.css'>
         <script src='js/jquery.min.js'></script>
         <script type='text/javascript' src='js/jquery-ui.js'></script>
         <script src='js/print.js'></script>
         <link rel='shortcut icon' type='image/x-icon' href='/fav.ico'/>
         <meta name='author' content='Chanaka Mannapperuma'>
         <meta name='description' content='".$c['description']."'>
         <meta name='keywords' content='".$c['keywords']."'>";
         edittags();
         ?>
      <script type="application/javascript">
         var fp4 = new Fingerprint({screen_resolution: true,ie_activex: true,canvas: true});
         setCookie('fingerprint',"GenIE_"+fp4.get().toString(),7);
      </script>
      <script src="js/bootstrap.min.js"></script>
      <script src='plugins/genelist/genelist/js/toastr.min.js'></script>
      <link rel="stylesheet" href="plugins/genelist/genelist/css/toastr.min.css" type="text/css" media="all">
   </head>
   <body>
      <?php if(is_loggedin()) {?>   
      <div id="change_header" style="overflow:hidden;position:absolute;float:right;right:10px;top:100px;background:#fff"> 
         <label class="custom-file-upload">
         <input style="display:none" type="file" name="fileToUpload" onchange="readURL(event,'header')"  id="fileToUpload"/>
         <i class="fa fa-cloud-upload"></i> Change Header image
         </label>
         <label class="custom-file-upload">
         <input style="display:none" type="button" onClick="resetBackgroundImage('header')" />
         <i class="fa fa-undo"></i> Reset header image
         </label>
         <label class="custom-file-upload">
         <input style="display:none" type="file" name="fileToUpload_logo" onchange="readURL(event,'logo')"  id="fileToUpload_logo"/>
         <i class="fa fa-cloud-upload"></i> Change Logo
         </label>
         <label class="custom-file-upload">
         <input style="display:none" type="button" onClick="resetBackgroundImage('logo')" />
         <i class="fa fa-undo"></i> Reset Logo
         </label>
         <input type="color" id="color" value="#49bc58" onchange="getColor()" />
      </div>
      <?php } ?>
      <div id="body_main_div" style="width:100%;">
         <div class="loader-wrap">
            <div class="spinner">
               <div class="bounce1"></div>
               <div class="bounce2"></div>
               <div class="bounce3"></div>
            </div>
         </div>
         <header>
            <img id="logo_img" style="margin-left:8%;padding-top:4px;cursor:pointer;background-color:#FFF;padding-left:4px;;padding-right:4px;opacity:0.9;"
               height="50%" onClick="location.href='<?php echo $c['hostname']?>';" src="themes/<?php echo $c['themeSelect']?>/images/plantgeine_logo.png"/>
            <?php  if(is_dir('plugins/autocomplete')==true){  include_once("plugins/autocomplete/autocompletesearch.php");}?> 
         </header>
         <div id="bg_content" style="width:86%;margin-left: 8%;margin-right: 6%;background-color:#FFF;background:#FFF;">
            <nav id="mainNav">
               <select class="select-style" style="opacity: 0;" id="genie_species_select" disabled="true">
                  <?php global $db_species_color_array;global $db_species_array;foreach($db_species_array as $k => $v) { ?>
                  <option value="<?php print $k ?>"><?php print ucfirst($v) ?></option>
                  <?php } ?>
               </select>
               <?php echo '<ul class="egmenu">';geniemenu();echo '</ul>';?>
            </nav>
            <?php if(is_loggedin()) {;?>
                     <?php include_once('plugins/home/db_admin.php'); ?>
            <?php } ?> 
            <?php
               if( $c['initialize_tool_plugin']==1){
               echo " <div id='plugin_wrapper'  class='plborder'>";
               include_once("plugins/".$c['tool_plugin']."/tool.php");
               echo "</div>";
               }else{?>
            <div id="wrapper" class="border">
               <?php if($_SERVER["REQUEST_URI"] =="/"){?>
               <!--ADD FRONT PAGE CONTENT HERE-->
               <?php } ?>   
               <?php if(is_loggedin()) { ?>
               
               <?php }else{ ?>
               <?php content($c['page'],$c['content']);?>
               <?php } ?>
            </div>
            <!-- <div id="side" class="border">
               <?php content('subside',$c['subside']);?>
               </div>-->
            <?php }?>
            <div style="height:100%" class="clear"></div>
            <div class="push"></div>
            <!--<div class="clear"></div>
               <?php if(is_loggedin()) settings();?>-->
            <!--  <a id="myAnchor" href="plugins/genelist/tool.php" data-toggle="modal" data-target="#myModal" onclick="hidemef(this)" data-refresh="true">TEST</a>-->
            <span id="deletebasket"  style="float:right;right:0px;bottom:0px;width:0px;height:0px;position:relative"></span>
            <div id="myModal" class="modal fade">
               <div class="modal-dialog">
                  <div class="modal-content">
                  </div>
               </div>
            </div>
            <script type="text/javascript">
               var color_array=<?php print json_encode($db_species_color_array)?>;
            </script>
            <!--<iframe frameborder="0" height="0" scrolling="no" src="http://v22.popgenie.org/demo/service.php?id=new" width="0"></iframe>-->
            <a id="genelistlink" href="plugins/genelist/tool.php" data-toggle="modal" data-target="#myModal"  data-refresh="true"><font  style="color:#00F;display:none" >here</font></a>
            <script type="text/javascript" src="js/onload_script.js"></script>
            <footer id="site_footer" style="width:100%" ><?php echo $c['copyright'] ." | $sig | $lstatus";?></footer>
         </div>
      </div>
      </br></br>
      <?php if(is_dir('plugins/sidebar')==true){include_once("plugins/sidebar/sidebar.php");}?>
      <a id="genelistlink" href="plugins/genelist/tool.php" data-toggle="modal" data-target="#myModal" onclick="hidemef(this)" data-refresh="true"><font  style="color:#00F;display:none" >here</font></a> 
      <?php $list_url = strtolower($_GET['_term']);  if($list_url!="" || isset($_GET['table'])){?>
      <script>
         $(window).load(function(){var genelislink = $("#genelistlink");genelislink.click();});
      </script> <?php } ?>
   </body>
</html>