<?php
include("plugins/genelist/crud/getgenelist.php");
$experimentarr=get_expression_experiments();
?>
<div class="ui tiny buttons" style="overflow: hidden;top:240px;left:320px;position:absolute;z-index: 99999;background: #FFFFFF">
  <!--  <div  id="no_replicates" class="ui positive button">Show Mean values</div>
    <div class="or"></div>
    <div id="replicates" class="ui button" style="border-top-right-radius: 2px;border-bottom-right-radius: 2px">Show Replicates</div>
  -->  
    
     <br>     <br><!--Start additional controls-->
     
      <div  id="additional_controls" style="width:99%;height:auto;border: #000000 1px solid;z-index: 9;display: none">
<i id="additional_control_close" onClick="additional_control_close();" class="fa fa-times" aria-hidden="true" style="float:right;padding-right:4px;padding-top: 2px;cursor: pointer"></i>
      <table width="100%" border="0">
        <tbody>
          <tr>
            <td width="30%">Correlation:&nbsp;</td>
            <td><div  id="positive_c" class="ui positive button"><i class="fa fa-plus" aria-hidden="true"></i>&nbsp;</div>
    <div class="or"></div>
    <div id="negative_c" class="ui button" style="border-top-right-radius: 2px;border-bottom-right-radius: 2px"><i class="fa fa-minus" aria-hidden="true"></i>&nbsp;</div></td>
         <td width="10%">&nbsp;</td>
          </tr>
          <tr>
            <td>Threshold:&nbsp;</td>
            <td><div style="width:100%" id="corr_slider"></div></td>
            <td width="10%">&nbsp;&nbsp;<span id="th_value">0.7</span></td>
          </tr>
         
           </tbody>
      </table>
           <div  id="findcorr" class="ui positive button" style="margin-left: 40px;">Find Correlated Genes</div>
           <br><br>
           
            <table width="100%" border="0">
        <tbody>
          <tr>
            <td width="45%"><hr></td>
            <td><span style="margin-top: -40px;background: #CCCCCC;border-radius:16px;padding: 4px;">OR</span></td>
            <td width="45%"><hr></td>
          </tr>
             </tbody>
      </table>
             <table width="100%" border="0">
        <tbody>
          <tr>
            <td width="30%">+/- VST:&nbsp;</td>
            <td><div style="width:100%" id="expr_slider"></div></td>
            <td width="10%">&nbsp;&nbsp;<span id="th_value2">1</span></td>
          </tr>
       
           </tbody>
      </table>
          
        <div  id="findexp" class="ui positive button"  style="margin-left: 20px;">Find similarly expressed Genes</div>  
<br><br><br>
  	 </div><!--End additional controls-->
  </div>
  

  
  <span style="position: absolute;left:240px;" id="explot_waiting"><img width="160px" src="plugins/gene/css/load1.gif" /></span> 
  
<div id="newtable_2" style="width:180px;overflow:hidden;position:absolute;z-index:1000;display:none" >
<div onClick="return toggleMe()"  id="newtable_2title">- Selected Genes</div>
<div id="listids" style="overflow: auto;height:auto;max-height:320px;margin-top:4px;margin-bottom:4px;"></div>
<div  id="newtable_3title" style="bottom:0px;">Make new Genelist</div>
</div>
<div id="newtable_3"    style="height:680px;height:48px;display:none;width:160px;overflow:hidden;position:absolute;z-index:1000">
<div onClick="return toggleMe()" id="newtable_4title">+ Selected Genes <strong><?php echo ' '.count($efppieces);?></strong></div>
</div>
<div id="outterbox"  style="height:1000px;">
<link href="plugins/tour/css/poptour.css" rel="stylesheet"></link>
<link href="plugins/explot/css/explot.css" rel="stylesheet"></link>

<script src="plugins/genelist/genelist/js/toastr.min.js"></script>
<link rel="stylesheet" href="plugins/genelist/genelist/css/toastr.min.css" type="text/css" media="all">

<!--<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
-->
<script src="plugins/explot/js/init.js"></script>
<!--<script src="tools/explot/js/slider/jquery.pageslide.js"></script>
--><script src="plugins/explot/js/popcharts2.js"></script>
<script src="plugins/explot/js/exporting.js"></script>
<script src="plugins/explot/js/draggable-points.js"></script>

<script src="js/popapi.js"></script>

	<script type="text/javascript" src="plugins/explot/js/css/wHumanMsg.js"></script>
	<link href="plugins/explot/js/css/wHumanMsg.css" media="screen" type="text/css" rel="stylesheet">
    <div id="contentx">
 <!--  <span id="showbtn"  style="left:0px;top:0px;display:none;" class="toggle-btn" >></span> onClick="draw_avg_line();"-->
       
       
       
       <span   class="hint--left hint--error" aria-label="Draw editable line will be avialble soon" ><div  id="draw_line" style="cursor: pointer;z-index: 9;overflow: hidden;position: absolute;margin-top: -30px;padding: 4px;border-radius: 6px;">
  	 <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" x="0px" y="0px" width="48px" height="48px" viewBox="0 0 64 64" enable-background="new 0 0 64 64" xml:space="preserve"><g><g><path class="dawrkc" fill="#000000" d="M54.839,5.236c-1.432-1.147-2.876-2.275-4.331-3.394c-1.361-1.058-3.228-0.716-4.446,0.809    c-0.597,0.744-1.174,1.49-1.76,2.235L43.821,5.49c-0.036,0.057-0.084,0.122-0.121,0.179l-0.047-0.035l0.662,0.517l0.195,0.153    l7.453,5.828l0.793,0.612l0.703-0.884c0.551-0.698,1.103-1.396,1.645-2.106C56.316,8.198,56.206,6.336,54.839,5.236z"></path><path class="dawrkc" fill="#000000" d="M42.441,7.316L40.957,9.18l-3.312,4.294c-4.115,5.338-8.231,10.676-12.349,16.018    c-0.318,0.421-0.582,0.915-0.744,1.395c-0.845,2.423-1.666,4.847-2.491,7.261l-0.589,1.734c-0.15,0.417-0.238,0.825-0.261,1.235    c-0.055,1.198,0.736,2.155,1.87,2.27c0.336,0.032,0.669-0.004,1.045-0.143c0.331-0.112,0.686-0.303,1.08-0.562l1.452-0.966    c1.751-1.139,3.485-2.297,5.229-3.466l0.238-0.159c0.775-0.515,1.658-1.113,2.406-2.077c2.181-2.849,4.374-5.689,6.562-8.532    l9.457-12.268c0.064-0.067,0.11-0.135,0.161-0.194l0.644-0.781L42.441,7.316z M45.021,11.556l1.407,1.083L30.72,33.043    c-0.758-0.183-1.205-0.642-1.455-1.021L45.021,11.556z M39.05,14.562l3.689-4.768l0.523,0.408l0.799,0.615L28.459,31.084    c-0.893-0.114-1.276-0.58-1.436-0.915C31.028,24.96,35.041,19.762,39.05,14.562z M31.12,36.627l-0.226,0.15    c-1.324,0.887-2.494,1.667-3.607,2.399c-0.553-0.425-1.094-0.849-1.632-1.262l-1.291-1.006c0.617-1.81,1.234-3.627,1.861-5.442    c0.05-0.146,0.118-0.299,0.197-0.447c0.343,0.442,0.895,0.852,1.741,1.002c0.181,0.425,0.523,0.945,1.059,1.358    c0.433,0.333,0.992,0.597,1.696,0.683c0.204,0.544,0.662,1.229,1.478,1.619C31.997,36.03,31.566,36.327,31.12,36.627z     M39.686,26.405c-2.2,2.85-4.381,5.683-6.559,8.52c-0.916-0.268-1.239-1.009-1.331-1.295l15.59-20.252l0.288,0.221l-0.015,0.019    l1.175,0.911L39.686,26.405z"></path></g><path class="dawrkc" fill="#000000" d="M43.876,62.708c-0.273,0.046-0.55,0.067-0.829,0.062c-0.906-0.018-1.627-0.767-1.61-1.673   c0.018-0.906,0.763-1.628,1.673-1.61c0.624,0.015,1.294-0.485,1.546-1.154c0.464-1.233,0.136-1.692,0.029-1.842   c-1.342-1.879-7.631-1.698-9.998-1.63c-0.419,0.013-0.785,0.023-1.083,0.026c-4.471,0.046-9.054,0.053-13.622,0.023   c-0.362-0.002-0.784,0.01-1.247,0.022c-3.39,0.088-9.065,0.235-10.466-4.034c-0.805-2.454,0.813-4.892,2.743-5.939   c1.246-0.675,2.516-0.82,3.636-0.943c0.742-0.084,1.443-0.162,2.042-0.386c0.851-0.32,1.796,0.111,2.114,0.96   c0.318,0.849-0.111,1.796-0.96,2.114c-0.982,0.368-1.965,0.478-2.831,0.575c-0.941,0.104-1.753,0.195-2.435,0.566   c-0.838,0.455-1.394,1.404-1.189,2.03c0.638,1.946,4.784,1.839,7.26,1.774c0.503-0.013,0.962-0.025,1.354-0.022   c4.549,0.029,9.115,0.021,13.567-0.024c0.282-0.003,0.627-0.013,1.022-0.024c5.035-0.145,10.589-0.045,12.765,3.004   c0.663,0.928,1.265,2.532,0.373,4.905C47.092,61.186,45.574,62.423,43.876,62.708z"></path></g></svg></div></span>
       
       <div id="container"   style="height:800px;width:100%;"></div>
       
     <!--    </ul>
       <div id="modal" style="display: none;">
<script src="tools/tour/poptour.js"></script>
<script src="tools/tour/explot.js"></script>
</div>--></div>

<!--sidebar-->
 <style type="text/css" media="screen">

    .slide-out-div {
    /*     padding: 20px;
        width: 250px;
      background: #f2f2f2;*/
        border-left: #9ac352 2px solid;
		/*margin-top: 5px;*/
		 width: 240px;
		 padding: 20px;
background: url(plugins/explot/img/sidebar_background.png
) no-repeat scroll 100% 100%;
/*border: none;
*/		line-height: 1; position: absolute; height: 100%;  right: -3px;
    }

.handle{
background-image: url(plugins/explot/img//right_sidebar3.png);
width: 28px;
height: 134px;
display: block;
text-indent: -99999px;
outline: none;
position: absolute;
top: 30px;
left: -32px;
background-position: initial initial;
background-repeat: no-repeat no-repeat;
}
	</style>
    <script src="plugins/explot/js/jquery.tabSlideOut.v1.3.js"></script>
         <script>
         $(function(){
             $('.slide-out-div').tabSlideOut({
                 tabHandle: '.handle',                              //class of the element that will be your tab
              //   pathToTabImage: 'images/contact_tab.gif',          //path to the image for the tab (optionaly can be set using css)
                 imageHeight: '186px',                               //height of tab image
                 imageWidth: '40px',                               //width of tab image
                 tabLocation: 'right',                               //side of screen where tab lives, top, right, bottom, or left
                 speed: 300,                                        //speed of animation
                 action: 'click',                                   //options: 'click' or 'hover', action to trigger animation
                 topPos: '0px',                                   //position from the top
                 fixedPosition: true                               //options: true makes it stick(fixed position) on scroll
             });
         });

 //$(window).load(function(){$.drawchart();});



//SVG convertion and download into different formats
function submit_download_form(output_format)
{
	var tmp = chanaka.select(document.getElementById("popcharts-0")).node();
	var svg = document.getElementsByTagName("svg")[0];

	// Extract the data as SVG text string
	var svg_xml = (new XMLSerializer).serializeToString(svg);

	// Submit the <FORM> to the server.
	// The result will be an attachment file to download.
	var form = document.getElementById("svgform");
	form['output_format'].value = output_format;
	form['data'].value = svg_xml ;
	form.submit();
}


if(getCookie("select_species") != undefined) {
	var current_species_cook=getCookie("select_species");

}

$('#poplar_species_select').on('change', function() {
	if(this.value!=current_species_cook){
		 location.reload();
	}

});

plus_minus_corr="false";
$('#positive_c,#negative_c').on('click',function(e){
	console.log(e.target.id)
	if(e.target.id=="positive_c"){
		plus_minus_corr="false";
		$('#positive_c').addClass('positive');
		$('#negative_c').removeClass('positive');
	}else{
		$('#negative_c').addClass('positive');
		$('#positive_c').removeClass('positive');
		plus_minus_corr="true";
	}
});
			 
			 
$('#no_replicates,#replicates').on('click', function(e) {
	if(e.target.id=="no_replicates"){
		$('#no_replicates').addClass('positive');
		$('#replicates').removeClass('positive');
		replicate_flag="false";
	}
	if(e.target.id=="replicates"){
		$('#replicates').addClass('positive')
		$('#no_replicates').removeClass('positive')
		replicate_flag="true";
	}
	setCookie("replicate_flag",replicate_flag,10);
				 
	$("#button2").hide();$("#buttonxx").show();$("#button3").hide();
				 
	$.drawchart();
});
			 
$(document).ready( function () {
	var cookie_replicate_flag=getCookie("replicate_flag");
		if(cookie_replicate_flag=="true"){	 
			$('#replicates').addClass('positive')
			$('#no_replicates').removeClass('positive')
		} else{
			$('#no_replicates').addClass('positive');
			$('#replicates').removeClass('positive');
				
		}
	replicate_flag=cookie_replicate_flag;
	//$.drawchart();
	$("#corr_slider").slider({
	      range: "min",
      animate: "fast",
		step:.1,
      value: .7,
      min: 0,
      max: .9,
      slide: function( event, ui ) {
        // Update value during slide
        $( "#th_value" ).html( ui.value );
      }
		
	
});
	
	
	$("#expr_slider").slider({
	      range: "min",
      animate: "fast",
		step:1,
      value: 1,
      min: 1,
      max: 4,
      slide: function( event, ui ) {
        // Update value during slide
        $( "#th_value2" ).html( ui.value );
      }
		
	
});
	
	
	
});

			 

         </script>

         <form id="svgform" method="post" action="https://spruce.plantphys.umu.se/cDNAeFP/download.pl">
<input type="hidden" id="output_format" name="output_format" value="">
<input type="hidden" id="data" name="data" value="">
</form>


          <div class="slide-out-div">
        <a class="handle" href="http://link-for-non-js-users">Content</a>
         <!--   <h3>Gene List</h3>
        <br />
        <p> Selection gene list is empty, You can select few genes
from <a href="/genelist">here</a.</p>
 <span id="togglebutton"  onClick="toggleslide()" class="toggle-btn">x</span>-->
<button id="startTourBtn" style=" width:100%;background-color:#F90;border-color:#F90;color:#000"  class="btn btn-large btn-primary">Take a Tour</button><br><br>



<!--<div  id="datasourcediv">


<input type="radio"  id="eplant_asp201" name="datasource"   class="radio" checked/>
<label style="font-style:italic" for="eplant_asp201">E. grandis Tissues</label></div><br><br>-->


<!--<div  id="datasourcediv">

<input type="radio"  id="eplant_log" name="datasource" class="radio" checked/>
<label style="font-style:italic" for="eplant_log">P. trichocarpa Tissues</label></div><div>
<input type="radio"  id="eplant_sex" name="datasource" class="radio" />
<label s style="font-style:italic" for="eplant_sex">P. tremula exDiversity</label></div><div>
<input type="radio"  id="eplant_asp201" name="datasource"   class="radio" />
<label style="font-style:italic" for="eplant_asp201">P. tremula exAtlas</label></div><br>-->


<div id="experiment_div" >
<!--<div >

<input  type="radio" id="norwood" onchange="changeview('norwood');" name="datasource" class="radio" checked="checked">
<label s="" style="font-style:italic" for="norwood">NorWood</label></div>
<div><input onchange="changeview('exatlas');" type="radio" id="exatlas" name="datasource" class="radio">
<label s="" style="font-style:italic" for="exatlas">P. abies exAtlas</label></div>-->
</div></br></br></br>
</br></br><br></br></br></br></br>
<!-- <div id="datatype">  <input type="radio" name="typergb" id="vstvalue" class="radio" value="vst"  checked/>
    <label for="vstvalue">VST</label></div><div>
    <input type="radio" name="typergb" id="tpmvalue"   value="tpm"  class="radio" />
    <label for="tpmvalue">TPM</label></div><br><br></br>-->



 <button class="btn btn-success"  id="save_as_svg" value="" >SVG</button>
    <button class="btn btn-success" id="save_as_pdf"  value="" >PDF</button>
    <button class="btn btn-success" id="save_as_png" value="" >PNG</button><br><br>

<textarea id="input_ids" style="width:240px;font-size:14px;"  rows="24"><?php echo  $efpstring?> </textarea><br><!--</div>-->
<button id="submit" style=" width:100%;" class="btn btn-large btn-primary">update chart</button>

<br><br><div style="display: none" id="charttyperadio">
<input type="radio"  id="line" name="charttype" class="radio" checked/>
<label for="line">Line</label></div><div>
<input type="radio"  id="column" name="charttype"   class="radio" style="display: none"/>
<label for="column" style="display: none">Bar</label></div><div>
<button  class="btn btn-large btn-primary" id="swaplabelsbtn" style="display: none" >Change Sample names</button>
 <div style="color: #464646;font-family: Verdana;font-size:12px" id="infolabels"></div>
<br><br>


<!--
<button id="buttonxx" onClick="draw_avg_line();"  style=" width:100%;" class="btn btn-large btn-primary" >Draw draggable line</button>
-->

<button id="button2"  style=" width:100%;display:none" class="btn btn-large btn-primary" >Find Genes</button>

<br><br>
<button id="button3"  style=" width:100%;display:none" class="btn btn-large btn-primary" >Find Cor Genes</button> 

<!-- <button style=" width:100%;" class="btn btn-large btn-primary" id="swapyaxis">Change to non Log values</button><br><br>-->





        </div>





    </div>

    </div>
     <script src="<?php print $GLOBALS['base_url']?>/plugins/tour/poptour.js"></script>
<script src="<?php print $GLOBALS['base_url']?>/plugins/tour/explot.js"></script>
<script src="<?php print $GLOBALS['base_url']?>/plugins/tour/workflow.js"></script>
    <script>
		
		var private_view2;
				var cookie_view=getCookie("cookie_view");
			if(cookie_view!=null && cookie_view != undefined){private_view2=cookie_view;}else{private_view2="experiment_4";}
			//document.getElementById(private_view2).checked=true;
		datasource=private_view2;
		
	if (typeof $_GET('workflow') != 'undefined') {
		var workflow="w"+$_GET('workflow');
		 mannapperuma.startTour(eval(workflow));
	}

	if(getCookie("select_species") != undefined){
	if(getCookie("select_species") =="potra"){
		 $('#datasourcediv').hide();
		  $('#eplant_logs').hide();

		}
	if(getCookie("select_species") =="potrs" || getCookie("select_species") =="potrx"){
			$('#outterbox').hide();
		  $('.title').html('<h3 class="title">exPlot<h3><h4 style="margin-left:100px;color:red">Not available for this assembly. Please change the active GeneList to Potri or Potra!</h4>');
		}

	}



	</script>
<div id="externallink2" style="float:left;padding-bottom:16px;left:0px;font-size:16px;position:relative;">

</div>

<!--
<button id="button" class="autocompare">Add plot band</button>
-->
