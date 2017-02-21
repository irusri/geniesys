<?php if($_SERVER['REMOTE_ADDR']=="85.226.186.s116"){ ?>
	<script type="text/javascript" src="plugins/sidebar/js/jquery.cycle.all.2.72.js"></script>
<script type="text/javascript" src="plugins/sidebar/js/jquery-sticklr-1.0.pack.js"></script>
<link rel="stylesheet" href="plugins/sidebar/css/font-awesome.min.css">

<link href="plugins/sidebar/css/style.css" rel="stylesheet"/>
<div  id="sticky" > <span id="nogenesspan" style="top:240px !important;align:left;position:fixed;background:#F00;color:#FFF;display:none">Click here to some genes!</span>
	<ul id="example-2" class="sticklr"
	style="top:260px !important;text-align:left;" >
		<li id="genelistli"> <a href="<?php print $GLOBALS['base_url']?>/genelist" id="genebagclick" onclick="clickgenelink();" class="icon-emails" title="Gene Selection"> GeneList <span id="numberofgenesSpan" class="notification-count" style="opacity: 1;">00</span></a>
			<ul id="numberofgenesSpanDetail" class="notifi"><!--<a href="plugins/genelist/tool.php" data-toggle="modal" data-target="#myModal" onclick="hidemef(this)" data-refresh="true"><font  style="color:#00F" >here</font></a>
			--><div id="content"><?php include( "plugins/genelist/crud/listbarang.php");?> </div>
				<div id="Formcontent"></div> <a href="<?php print $GLOBALS['base_url']?>/plugins/genelist/crud/formbarang.php?action=add" class="add">add empty genelist</a> / <a href="<?php print $GLOBALS['base_url']?>/plugins/genelist/crud/formbarang.php?action=savecurent"
				class="savecurrent">save current list</a> / <a href="<?php print $GLOBALS['base_url']?>/plugins/genelist/crud/formbarang.php?action=add" class="cancel">cancel</a>				</ul>
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
				<li> <a href="<?php print $GLOBALS['base_url']?>/chromosome_diagram" class="icon-barx">Chromoplot</a> </li>
				<li> <a href="<?php print $GLOBALS['base_url']?>/#" class="icon_heat">&nbsp;exHeatmap</a> </li>
			</ul>
		</li> <span onclick="closeslider();" id="showhidespans" style="top:32px !important;text-align:left;cursor:pointer;color:#000000;font-size: 16px;font-weight: bold;text-shadow: 0 2px 0 #ffffff;left:77px;position: absolute;opacity:0.6;z-index:99000000"><</span>		</ul>

</div></div>
	<script src="plugins/sidebar/js/init.js" type="text/javascript"></script>
<?php }else{ ?>
<!--#####################################################################################################################################################################################-->
	<script type="text/javascript" src="plugins/sidebar/js/jquery.cycle.all.2.72.js"></script>
	<script type="text/javascript" src="plugins/sidebar/js/jquery-sticklr-1.0.pack.js"></script>
		<link rel="stylesheet" href="plugins/sidebar/css/font-awesome.min.css">
	<link href="plugins/sidebar/css/style_2.css" rel="stylesheet"/>
	<!-- <div  id="sticky" style="display:none">
	<ul id="example-2" class="sticklr"
	style="top:260px !important;text-align:left;" style="display:none">


		<li id="analysisli" > <a href="#" class="icon-tags" title="Popgenie Analysis Tools">Analysis</a>
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
	</div></div> -->
	<script src="plugins/sidebar/js/init.js" type="text/javascript"></script>
	<div id="editpanel" style="background:#fff; ;font-size:16px;overflow:hidden;z-index:9;position:absolute;display:none;width:400px;color:#000;border: 2px solid #e15b63;min-height:200px; ">
		<li id="genelistli" style="list-style-type: none;">
			<ul id="numberofgenesSpanDetail" class="notifi">
				<div id="content" style="font-weight:bold">
					<?php include( "plugins/genelist/baskets/listbarang.php");?> </div>
				<div id="Formcontent"></div> <a href="<?php print $GLOBALS['base_url']?>/plugins/genelist/baskets/formbarang.php?action=add" class="add"><i class="savemenu fa-plus"></i></a> &nbsp;&nbsp;<a href="<?php print $GLOBALS['base_url']?>/plugins/genelist/baskets/formbarang.php?action=savecurent"
				class="savecurrent"><i class="savemenu fa-copy"></i></a>  &nbsp;&nbsp; <a href="<?php print $GLOBALS['base_url']?>/plugins/genelist/baskets/formbarang.php?action=add" class="cancel"><i class="savemenu fa-backward"></i></a>				</ul>
		</li>

		<div id="editpanel2" style="background:#fff ;font-size:12px;;z-index:9;position:relative;display:none;width:100%;min-height:120px;overflow:hidden;min-height:200px;margin-left:-40px;">
			<ul style=" display: block;list-style-type: none;width:100%" >

				<li style=" width:100%">
						<a class="toollinks" style="cursor:pointer" onClick="open_genelist()" >&nbsp;GeneList</a>
				</li>
									<li style=" width:100%">
											<a class="toollinks" href="/demo/blast" >&nbsp;BLAST</a>
									</li>
									<li  style=" width:100%">
											<a class="toollinks" href="/demo/jbrowse" >&nbsp;JBrowse</a>
									</li>
									<li  style=" width:100%">
											<a class="toollinks" href="/demo/chrdiagram" >&nbsp;ChrDiagram</a>
									</li>
									<li  style=" width:100%">
											<a class="toollinks" href="/demo/qtlxplorer" >&nbsp;QTLXplorer</a>
									</li>

							</ul>
	</div>
	<div id="editpanel3" style="background:#fff ;font-size:12px;n;z-index:9;position:relative;display:none;width:100%;min-height:120px;overflow:hidden;min-height:200px;margin-left:-40px;">
		<ul style=" display: block;list-style-type: none;width:100%" >

			<li>
					<a class="toollinks" href="/demo/explot" >&nbsp;exPlot</a>
			</li>

								<li>
										<a class="toollinks" href="/demo/eximage" >&nbsp;exImage</a>
								</li>

								<li>
										<a class="toollinks" href="/demo/exheatmap" >&nbsp;exHeatmap</a>
								</li>


						</ul>



	</div>
	</div>





<link href="plugins/sidebar/drag/geniemenu.css" rel="stylesheet"/>
<script src="plugins/sidebar/drag/geniemenu.js" type="text/javascript"></script>

<ul id="nav" style="list-style-type: none;">

	<!--		<li><a href="plugins/genelist/tool.php" data-toggle="modal" data-target="#myModal" onclick="hidemef(this)" data-refresh="true">GeneList</a></li>
	-->
			<li id="expression_tools" style="background:#e15b63;;width:40px;height:40px;border-radius:40px;text-align:center;vertical-align: top;color:#FFF;cursor:pointer"><a  style="color:#000" href="javascript:void(0);"></a>
				<div class="display-box">
			      <div class="hero-icon yellow science-shake medium"><i class="main fa fa-flask"></i>
			        <div class="science-bubbles"><i class="bubble fa fa-circle"></i><i class="bubble fa fa-circle"></i><i class="bubble fa fa-circle"></i></div>
			      </div>
			    </div>
					</li>
					<li id="analysis_tools" style="background:#e15b63;;width:40px;height:40px;border-radius:40px;text-align:center;vertical-align: top;color:#FFF;cursor:pointer"><a  style="color:#000" href="javascript:void(0);"></a>
					<div class="display-box">
							<div class="hero-icon yellow science-shake medium"><i class="bubble fa fa-helix"></i><!--<img class="icon icons8-DNA-Helix" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADQAAAA0CAYAAADFeBvrAAAEnElEQVRoQ+2ZjVEUQRCFuyNQIlAiACNQIhAjUCMQIhAiECJQIlAiECIQIhAjUCJo69vqvuqbm729vdu5Uoqpoqi73dntN/369c+pPLClDwyPPAL61z366KFNPGRmT0Xkk4jsi8i5qn7Z5Hm1vVvzkJkdishnEQEU64+q7vyXgMwMIO8K4y9UtfxuY3xNPeQU+yoirwpLL1UVj02+WgP6XoD55ZR7IiLEz6mq3k2JqhkgMzsRkY/J2FsHRwxx7S1xJCJnqno6FagmgJxqP5MAhL0nYbyZQcMzEdkTEbx0rKrfNgXWChDBjhDEOnCvvBSRGxF5r6r8FzPjXoBBwysH1l1bZ7UClOl2p6q7bvyRA8P47C1oyLWgKACJLyg5arUCxEnjjVh8foOBZvbcBaHmLa4B5rXHF6DPMyKn856qXteQbgMQYkCccNqAAhxUq3rLr5XxBUWv/DB+eGxSafCMudUKEJKMirE4SShIwEM1VO3YDe/1ViW+2M+hRDK+VtUyv7VpHzzQQxS6EsepAlDoRNDjrS4HDXirjK/wyFY9xMkj27GgTFeIuvEUqJw233dSvSy2Eg1J1LE4kAWZb0I5NyDTDuNfJI9QbWPMs0zBZd4ys/y8e1WNIrd9DKUTh1rEDWuufhugYBlbKF3Oa0g6cbmwmnkoBXUYUi1IU/xYpqDvp4DFM3EofH0vIs/7clRTQAkUhpFTqhWAmUFBDEfeZyro+8vWoxo74apRgPzFqBRyCYcxJBaKlSvn+Ez8dED6kqEbzvNIqsg995Nj+MttxmAPtRIgVyBOakH3azxe4bsMHuOjxAEUeaYW8Leqmg+w+ppBQO4V5LKqKisYP8UtJOfDVWq7pYCKUiMMy00a0jtXayUvZkrmum4MQN71pU/RRqucmZUdJz3LmQMFDEFMbUaCHOw83dsARZb5yws6d3WeU/Am6r4xJ9DrIW/AcmaeVczxgtSVEgMLlfEYQ6a6dxkgPICi5bXQWRaSyx68Ve1jvMZDxVCryWdynZLWTsaz+O90jeoYMMgq5QqGQ78ZzQpvzWq0/HwzI3nG2lklyMd6rg8Q2s/4KdYuxjtQSo4PtQHHkLcKQAfrxMgQwD5Acy20F5YzGhWGk0fwVjRuMdUJ0Lmi5l6EhNUJzJCBY6/3ASrjpxs3+Tw6A8td59wcwEWFOOkqamYETtWQ8N4CcyyIfH8foDwTuPSkiiELc7Siai57nOytqA6i2qh2nJuAWSYKGVDkHuIqRAHjkOmLJOEYGh6Zy02Ft2LLVgGFKFCq7xdqRq1FjEGlmozn+CtHVVA5KLc9QBwhVFomqy7TxFAMCImJEIbcoAE6pjYZ7HYBrcJlj58o8xcmn8VUFDpSLUfFvD1RWAVMkTBzL8Ol2S8LRe7K27aXh8YCSsIA1eKXhRkwV8c8vG9Ct16VWxdQAgatUMSQeuQ8V9dNvNMMUAJGfDGDy6s6INz0EGP/YMe67ovMjF8SylHT4Exg3fc1BVQMBeNdzcE0o5yZ5UqD5HzUqv8pPdqEcl6NIwokVcCM/uFqXeo1AbSuMVPsewQ0xSm2fMajh1qe7hTP/gv1NkBTnBOtgQAAAABJRU5ErkJggg==" width="32" height="32"></img>--></i>
								<div class="science-bubbles"><i class="bubble fa fa-circle"></i><i class="bubble fa fa-circle"></i><i class="bubble fa fa-circle"></i></div>
							</div>
						</div>	</li>

	<li id="genenumber" style="background:#e15b63;;width:40px;height:40px;border-radius:40px;text-align:center;vertical-align: top;color:#FFF;cursor:pointer"><span class="notificationcount2"><a   onclick="open_samplelist();" href="plugins/genelist/tool.php" data-toggle="modal" data-target="#myModal" onclick="hidemef(this)"  data-refresh="true"><FONT color="#FFFFFF"><span  id="notificationcount_2"   style="opacity: 1;">00</span></FONT></a>
	</span></li>

</ul>

<script type="text/javascript">




$(document).ready(function() {
	var init_position="left-center";


		if (getCookie("sidebarclass") != null) {
			init_position=getCookie("sidebarclass");
			//console.log(init_position)
		}

	$("#nav").genieMenu({
			delay: 20,
			position: init_position
	});
	var notificationBubble = document.getElementById("geniemenu-controller-0");
var node = document.createElement("span");
	node.innerHTML='<a   onclick="open_samplelist();" href="plugins/genelist/tool.php" data-toggle="modal" data-target="#myModal" onclick="hidemef(this)"  data-refresh="true"><FONT color="#FFFFFF"><span style="position:relative"  id="numberofgenesSpan"  style="opacity: 1;">00</span></FONT></a>';
///node = document.getElementById("bbb");
	//var node = document.createElement("span");
	node.setAttribute("class", "notificationcount");
	node.setAttribute("id", "mainspan");
	notificationBubble.appendChild(node);



	//	var notificationBubble = document.getElementById("geniemenu-controller-0");
		//	var node = document.getElementById("bubble");
//	notificationBubble.appendChild(node);
/*	var notificationBubble = document.getElementById("geniemenu-controller-0");
	var node = document.createElement("span");
	node.setAttribute("class", "notificationcount");
	node.setAttribute("id", "numberofgenesSpan");
	notificationBubble.appendChild(node); //.append("<span id='numberofgenesSpan' class='notification-count' style='position:relative;'></span>")*/


	$(".geniemenu-controller").click(function() {
			if ($(".geniemenu-controller").hasClass("open") == true) {
	adjustPadding();
					$("#editpanel").show()
					updategenebasket3();
					$("#content").load("plugins/genelist/baskets/listbarang.php");
				//	console.log($("#genenumber")[0].)
				//	console.log($("#mainspan")[0])
$("#mainspan").hide();
$("#notificationcount_2")[0].innerHTML=$("#numberofgenesSpan")[0].innerHTML;


/*$('.notificationcount').animate({position:"relative",
					 top: $('.notificationcount2:eq(0)').css('top'),
					 left: $('.notificationcount2:eq(0)').css('left')
			 }, 500);
			 $('.notificationcount2').animate({position:"relative",
			 					 top: $('.notificationcount:eq(0)').css('top'),
			 					 left: $('.notificationcount:eq(0)').css('left')
			 			 }, 500);
*///console.log($('#genenumber').css('top'),$('#genenumber').css('left'));

//$("#genenumber")[0].innerHTML=	"<span class='notificationcount2'>"+$("#mainspan")[0].innerHTML+"</span>";

					///mainspan 	$("#editpanel").show()



				//	console.log(tmp_new_x,tmp_new_y)

			} else {
					$("#editpanel").hide()
					$("#mainspan").delay( 200 ).show(200);
			}
	});

	//var testme=document.getElementById("geniemenu-controller-0");



});

//document.getElementById("analysis_tools").addEventListener("click",function(e){console.log(e)},false);
$("#analysis_tools").mouseover(function(e) {
		$("#genelistli").hide()
		$("#editpanel2").hide()
		$("#editpanel3").show()

});
$("#genenumber").mouseover(function(e) {
		$("#genelistli").show()
		$("#editpanel2").hide()
		$("#editpanel3").hide()

});

$("#expression_tools").mouseover(function(e) {
		$("#genelistli").hide()
		$("#editpanel2").show()
		$("#editpanel3").hide()

});

function adjustPadding(){
	var u=document.getElementById("geniemenu-controller-0").className.split(" ")[2].split("-")[0]
	if(u=="right"){
		$("#editpanel").css({Right:"120px",Left:"10px"});
		$("#editpanel2").css({Right:"120px",Left:"10px"})
		$("#editpanel3").css({Right:"120px",Left:"10px"})
	}else{
		$("#editpanel").css({Right:"10px",Left:"120px"});
		$("#editpanel2").css({Right:"10px",Left:"120px"});
		$("#editpanel3").css({Right:"10px",Left:"120px"});
	}
}

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
