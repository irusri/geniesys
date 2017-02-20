<!doctype html>
<html lang="en">
<head>
<?php
	echo "<meta charset='utf-8'>
	<title>".$c['title']." - ".$c['page']."</title>
	<base href='$hostname'>
	<link rel='stylesheet' href='themes/".$c['themeSelect']."/style.css'>
	<script src='js/jquery.min.js'></script>
	<meta name='description' content='".$c['description']."'>
	<meta name='keywords' content='".$c['keywords']."'>";
	editTags();
?>
	 <script src="js/fingerprint.js" type="text/javascript"></script>
	 <script type="application/javascript">
		var fp4 = new Fingerprint({screen_resolution: true,ie_activex: true,canvas: true});
		setCookie('fingerprint',fp4.get(),7);
	</script>
     <script src="js/cufon-yui.js" type="text/javascript"></script>
     <script src="js/cufon_300.font.js" type="text/javascript"></script>
     <script type="text/javascript">
        Cufon.replace('h1',{ fontFamily: "Cufon" });
        Cufon.replace('h2',{ fontFamily: "Cufon" });
        Cufon.replace('h3',{ fontFamily: "Cufon" }); 
        Cufon.replace('#mainNav',{ fontFamily: "Cufon" });
        Cufon.replace('#siteDescription',{ fontFamily: "Cufon" });
     </script>
     <script src="js/bootstrap.min.js"></script>
</head>
<body>
<div class="loader-wrap">
<div class="spinner">
  <div class="bounce1"></div>
  <div class="bounce2"></div>
  <div class="bounce3"></div>
</div></div>
	<header>
     <a href="plugins/genelist/tool.php" data-toggle="modal" data-target="#myModal"><span id="numberofgenesSpan" class="notification-count" style="float:right;right:6px;top:10px;width:16px;cursor:pointer">00</span></a>
  		<h1 class="cufon"><a href='./'><?php echo $c['title'];?></a></h1>
		<nav id="mainNav">
        <?php echo '<ul class="egmenu">';genie_menu();echo '</ul>';?>
		</nav>
	</header>
   <br><br><br><br>  <br><br>
<?php if(is_loggedin()) {settings();echo "<hr style='100%;border:1px solid #222'/>";}?>
	<div class="clear"></div>  
         <?php 
	 if( $c['initialize_tool_plugin']==1){
	 echo " <div id='plugin_wrapper'  class='plborder'>";
	 include_once("plugins/".$c['tool_plugin']."/tool.php");
	 echo "</div>";
	 }else{?>
   <div id="wrapper" class="border">
 		<?php if(is_loggedin()) { ?> 
			<textarea class="ckeditor" name="editor"><?php content($c['page'],$c['content']);?></textarea> 
			<script type="text/javascript">
			var key = <?php echo json_encode($c['page']); ?>
			</script> 
			<button id="btn_submit" onclick="save(key);">save</button>
			<?php include('msg_box.php'); ?>
			<?php }else{ ?>
			<?php content($c['page'],$c['content']);?>
			<?php } ?> 
	</div>
	<div id="side" class="border">
			<?php content('subside',$c['subside']);?>
	</div>
<?php }?>
	<div style="height:100%" class="clear"></div>
    
                <div class="push"></div> 

    
	<footer ><p><?php echo $c['copyright'] ." | $sig | $lstatus";?></p></footer>
	<!--<div class="clear"></div>
	<?php if(is_loggedin()) settings();?>-->
<span id="deletebasket"  style="float:right;right:0px;bottom:0px;width:0px;height:0px;"></span> 
 <div id="myModal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content"> 
            </div>
        </div>
    </div>
<script type="application/javascript">
$(window).load(function() {
	$(".loader-wrap").fadeOut("slow");
	
})

$('#myModal').on('show.bs.modal', function (e) {
	$(".loader-wrap").show();
});
$('#myModal').on('shown.bs.modal', function (e) {
	$(".loader-wrap").hide();
});
</script>
</body>
</html>