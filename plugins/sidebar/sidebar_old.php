<?php if($_SERVER['REMOTE_ADDR']!="130.239.72.21"){ ?>
	<script type="text/javascript" src="plugins/sidebar/js/jquery.cycle.all.2.72.js"></script>
<script type="text/javascript" src="plugins/sidebar/js/jquery-sticklr-1.0.pack.js"></script>
<link href="plugins/sidebar/css/style.css" rel="stylesheet"/>
<div  id="sticky" > <span id="nogenesspan" style="top:240px !important;align:left;position:fixed;background:#F00;color:#FFF;display:none">Click here to some genes!</span>
	<ul id="example-2" class="sticklr"
	style="top:260px !important;text-align:left;" >
		<li id="genelistli"> <a href="<?php print $GLOBALS['base_url']?>/genelist" id="genebagclick" onclick="clickgenelink();" class="icon-emails" title="Gene Selection"> GeneList <span id="numberofgenesSpan" class="notification-count" style="opacity: 1;">00</span></a>
			<ul id="numberofgenesSpanDetail" class="notifi"><a href="plugins/genelist/tool.php" data-toggle="modal" data-target="#myModal" onclick="hidemef(this)" data-refresh="true"><font  style="color:#00F" >here</font></a>
				<div id="content">
					<? include( "plugins/genelist/baskets/listbarang.php");?> </div>
				<div id="Formcontent"></div> <a href="<?php print $GLOBALS['base_url']?>/plugins/genelist/baskets/formbarang.php?action=add" class="add">add empty genelist</a> / <a href="<?php print $GLOBALS['base_url']?>/plugins/genelist/baskets/formbarang.php?action=savecurent"
				class="savecurrent">save current list</a> / <a href="<?php print $GLOBALS['base_url']?>/plugins/genelist/baskets/formbarang.php?action=add" class="cancel">cancel</a>				</ul>
		</li>
		<!--<li id="samplelistli">
         <a style="cursor:pointer" onclick="open_samplelist();" class="icon-experiments" title="Sample Selection">SampleList<span id="numberofexpSpan" class="notification-count">00</span></a>
         </li>--></li>
		<li id="analysisli"> <a href="#" class="icon-tags" title="Popgenie Analysis Tools">Analysis</a>
			<ul style="left:85px;" class="toolul1">
				<li class="sticklr-title"> <a href="#">Tools with GeneList</a> </li>
				<li> <a href="<?php print $GLOBALS['base_url']?>/eximage" class="icon-eplant">&nbsp;exImage</a> </li>
				<li> <a href="<?php print $GLOBALS['base_url']?>/#" class="icon-cluster">&nbsp;exNet</a> </li>
			</ul>
			<ul class="toolul2">
				<li> <a href="<?php print $GLOBALS['base_url']?>/explot" class="icon-explot">&nbsp;exPlot</a> </li>
				<li> <a href="<?php print $GLOBALS['base_url']?>/#" class="icon-barx">Chromosome Diagram</a> </li>
				<li> <a href="<?php print $GLOBALS['base_url']?>/#" class="icon_heat">&nbsp;exHeatmap</a> </li>
			</ul>
		</li> <span onclick="closeslider();" id="showhidespans" style="top:32px !important;text-align:left;cursor:pointer;color:#000000;font-size: 16px;font-weight: bold;text-shadow: 0 2px 0 #ffffff;left:77px;position: absolute;opacity:0.6;z-index:99000000"><</span>		</ul>

</div></div>
	<script src="plugins/sidebar/js/init.js" type="text/javascript"></script>
<?}else{ ?>
	<!--#############################################################################################################-->
	<script type="text/javascript" src="plugins/sidebar/js/jquery.cycle.all.2.72.js"></script>
	<script type="text/javascript" src="plugins/sidebar/js/jquery-sticklr-1.0.pack.js"></script>
	<link href="plugins/sidebar/css/style_2.css" rel="stylesheet"/>
	<div  id="sticky" >
	<ul id="example-2" class="sticklr"
	style="top:260px !important;text-align:left;" >

		<!--<li id="samplelistli">
				 <a style="cursor:pointer" onclick="open_samplelist();" class="icon-experiments" title="Sample Selection">SampleList<span id="numberofexpSpan" class="notification-count">00</span></a>
				 </li>--></li>
		<li id="analysisli"> <a href="#" class="icon-tags" title="Popgenie Analysis Tools">Analysis</a>
			<ul style="left:85px;" class="toolul1">
				<li class="sticklr-title"> <a href="#">Tools with GeneList</a> </li>
				<li> <a href="<?php print $GLOBALS['base_url']?>/eximage" class="icon-eplant">&nbsp;exImage</a> </li>
				<li> <a href="<?php print $GLOBALS['base_url']?>/#" class="icon-cluster">&nbsp;exNet</a> </li>
			</ul>
			<ul class="toolul2">
				<li> <a href="<?php print $GLOBALS['base_url']?>/explot" class="icon-explot">&nbsp;exPlot</a> </li>
				<li> <a href="<?php print $GLOBALS['base_url']?>/#" class="icon-barx">Chromosome Diagram</a> </li>
				<li> <a href="<?php print $GLOBALS['base_url']?>/#" class="icon_heat">&nbsp;exHeatmap</a> </li>
			</ul>
		</li>

	</div></div>
	<script src="plugins/sidebar/js/init.js" type="text/javascript"></script>


	<div id="editpanel" style="background:#FFFFFF;font-size:10px;overflow:hidden;z-index:9;position:absolute;display:none;padding-right: 60px;padding-left: 60px;width:400px;">
		<li id="genelistli">
			<ul id="numberofgenesSpanDetail" class="notifi">
				<div id="content">
					<? include( "plugins/genelist/baskets/listbarang.php");?> </div>
				<div id="Formcontent"></div> <a href="<?php print $GLOBALS['base_url']?>/plugins/genelist/baskets/formbarang.php?action=add" class="add">add empty genelist</a> / <a href="<?php print $GLOBALS['base_url']?>/plugins/genelist/baskets/formbarang.php?action=savecurent"
				class="savecurrent">save current list</a> / <a href="<?php print $GLOBALS['base_url']?>/plugins/genelist/baskets/formbarang.php?action=add" class="cancel">cancel</a>				</ul>
		</li>
	</div>


<link href="plugins/sidebar/drag/geniemenu.css" rel="stylesheet"/>
<script src="plugins/sidebar/drag/geniemenu.js" type="text/javascript"></script>

<ul id="nav" style="list-style-type: none;">

	<!--		<li><a href="plugins/genelist/tool.php" data-toggle="modal" data-target="#myModal" onclick="hidemef(this)" data-refresh="true">GeneList</a></li>
	--><li   style="background:#ccc;width:60px;height:60px;border-radius:40px;text-align:center;vertical-align: bottom;color:#FFF"><a  style="color:#000" href="javascript:void(0);"><br>GeneList</a>
			</li>
			<li style="background:#ccc;width:60px;height:60px;border-radius:40px;text-align:center;vertical-align: bottom;color:#FFF"><a  style="color:#000;font-size:10px;" href="javascript:void(0);"><br>Expression</a>
					</li>
					<li style="background:#ccc;width:60px;height:60px;border-radius:40px;text-align:center;vertical-align: bottom;color:#FFF"><a  style="color:#000" href="javascript:void(0);"><br>Analysis</a>
							</li>
		<!--	<li  style="background:red;width:60px;height:60px;"><a  style="background:red" href="javascript:void(0);"><i class="icon-map-marker"></i></a></li>-->

		</ul>

<script type="text/javascript">
$(document).ready(function() {
	$("#nav").genieMenu({
			delay: 20,
			position: "left-center"
	});
	var notificationBubble = document.getElementById("geniemenu-controller-0");
	var node = document.createElement("span");
	node.setAttribute("class", "notificationcount");
	node.setAttribute("id", "numberofgenesSpan");
	notificationBubble.appendChild(node); //.append("<span id='numberofgenesSpan' class='notification-count' style='position:relative;'></span>")


	$(".geniemenu-controller").click(function() {
			if ($(".geniemenu-controller").hasClass("open") == true) {
					$("#editpanel").show()
					var tmp_x = $(this).data().startingPosition.x;
					var tmp_y = $(this).data().startingPosition.y;
					var tmp_new_x;
					var tmp_new_y;
					if (tmp_x + $("#editpanel").width() < $(window).width()) {
							tmp_new_x = tmp_x + 30;
					} else {
							tmp_new_x = tmp_x - $("#editpanel").width() + 30;
					}
					if (tmp_y + $("#editpanel").height() < $(window).height()) {
							tmp_new_y = tmp_y + 30;
					} else {
							tmp_new_y = tmp_y - $("#editpanel").height() + 30;
					}
					$("#editpanel").css({
							left: tmp_new_x,
							top: tmp_new_y
					});
				//	console.log(tmp_new_x, tmp_new_y)
			} else {
					$("#editpanel").hide()
			}
	});
});

	</script>
</head>
<!--<script src="https://rawgit.com/briangonzalez/jquery.pep.js/master/src/jquery.pep.js"></script>
<script>
var docHeight = $(document).height();
var windowHeight = $(window).height();
var buffer = 100;

function handleNear() {
  var near = windowHeight - this.ev.y <= buffer;

  if (near && this.velocity().y > 0 )
    window.scrollTo(0, this.ev.y + buffer);
}

$('#sticky1').pep({

  debug: false,
  drag: function(e) {
    handleNear.apply(this);
  }
});
</script>-->





<?php } ?>
