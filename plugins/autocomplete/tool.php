<?php

if ( isset($_SERVER["REMOTE_ADDR"]) )    {
    $ip = '' . $_SERVER["REMOTE_ADDR"] . '';
} else if ( isset($_SERVER["HTTP_X_FORWARDED_FOR"]) )    {
    $ip = '' . $_SERVER["HTTP_X_FORWARDED_FOR"] . '';
} else if ( isset($_SERVER["HTTP_CLIENT_IP"]) )    {
    $ip = '' . $_SERVER["HTTP_CLIENT_IP"] . '';
}

global $user;
if($user->uid!=$_COOKIE['initcongenie_uuid']){
$expire=time()+ 86400 * 1;//however long you want
$popuuid=$user->uid;
$myDomain = ereg_replace('^[^\.]*\.([^\.]*)\.(.*)$', '\1.\2', $_SERVER['HTTP_HOST']);
$setDomain = ($_SERVER['HTTP_HOST']) != "localhost" ? ".$myDomain" : false;
setcookie ("initcongenie_uuids", $popuuid, $expire, '/', $setDomain, 0 );
}
?>
<!--<div id="test-popup" class="white-popup mfp-hide"> @import "sites/all/themes/admire_grunge/genelist/css/demo_page.css";-->
<style type="text/css">
	@import "plugins/genelist/genelist/css/demo_table.css";
	@import "plugins/genelist/genelist/css/TableTools.css";
</style>

<script type="text/javascript">
   var species_selection = "<?php echo $_COOKIE['select_species']; ?>";
</script>
 <script src="plugins/genelist/genelist/js/jquery/jquery-1.8.3.js"></script>
 <script src="plugins/genelist/genelist/js/jquery/jquery-ui.js"></script>
<!--  <script src="http://beta.congenie.org/sites/all/themes/admire_grunge/tabs/vendor/jquery-1.8.3.js"></script>
<script src="http://beta.congenie.org/sites/all/themes/admire_grunge/tabs/vendor/jquery-1.8.3.js"></script>
  <script src="http://beta.congenie.org/sites/all/themes/admire_grunge/tabs/vendor/jquery-ui.js"></script>-->
<!--<script type="text/javascript" language="javascript" src="/misc/jquery.js"></script>-->
<script src="plugins/genelist/genelist/js/jquery.dataTables.js"></script>
<script src="plugins/genelist/genelist/js/FixedColumns.js"></script>
<script src='plugins/genelist/genelist/js/ColVis.js'></script>  
<script src='plugins/genelist/genelist/js/ZeroClipboard.js'></script>
<script src="plugins/genelist/genelist/js/TableTools.min.js"></script> 
<script src='plugins/genelist/genelist/js/toastr.min.js'></script>
<!--<script src="http://datatables.net/extras/thirdparty/ColReorderWithResize/ColReorderWithResize.js"></script>-->
<script type="text/javascript" src="plugins/genelist/genelist/js/css/wHumanMsg.js"></script>
<link href="plugins/genelist/genelist/js/css/wHumanMsg.css" media="screen" type="text/css" rel="stylesheet">
<script src='plugins/genelist/genelist/js/maininit.js'></script>
<link rel="stylesheet" href="plugins/genelist/genelist/css/style.css" type="text/css" media="all">
<?php

$allow_betax=false;
$blacklist_ip_range = array('/^130\.239\.(\d+)\.(\d+)/','/^130\.238\.(\d+)\.(\d+)/', '/^85\.226\.(\d+)\.(\d+)/',);$USER_IP_ADDR = $ip ;
foreach( $blacklist_ip_range as $ip ) {if( preg_match( $ip, $USER_IP_ADDR ) ){ $allow_betax=true;}}

;
 if($user->uid!=1111 ){ ?>




<div class="select_genome">
  <label class="radio inline"> 
      <input onChange="changedbsource('potri');"  type="radio" name="popr" id="potri" value="potri" checked>
      <span> Populus <i>trichocarpa</i> </span> 
   </label>
  <label class="radio inline"> 
      <input onChange="changedbsource('potra');"  type="radio" name="popr" id="potra" value="potra">
      <span>Populus <i>tremula</i> </span> 
  </label>
   <label  class="radio inline"> 
      <input onChange="changedbsource('potrs');" type="radio" name="popr" id="potrs" value="potrs">
      <span>Populus <i>tremuloides</i></span> 
  </label>
     <label  class="radio inline"> 
      <input  onChange="changedbsource('potrx');" type="radio" name="popr" id="potrx" value="potrx">
      <span>Populus <i>tremula</i> X Populus <i>tremuloides</i></span> 
  </label>
</div><? } ?>
<div style="width:100%;padding:5px;">
<?php if($table_exsist==false){?>
<font color="#FF0000"><a id="loadexamplebtn"  title="Click here to load example gene list." style="cursor:pointer;text-decoration:none;z-index:10000">Load Example</a>&nbsp;|&nbsp;<a style="cursor:pointer;text-decoration:none;z-index:10000" id="str" >Start a tour</a>&nbsp;|&nbsp;<a target="_blank" href="http://popgenie.org/help" >Help</a></font>
<textarea  multiple="multiple"  placeholder="Type in here to search all database fields " id="myInputTextField" value="" style="width:100%;;margin:5px;max-height:500px;"  ></textarea><br />
<? } ?>
<!--<font color="#999999">*please use <strong>desc:</strong> prefix for search description.e.g: desc:drought</font>
--></div>
<script>
console.log(fp4.get());
$(window).load(function() {
	/*var element = $('#poplink');
    var href = $(element).attr("nodeurl");
    var options = {width: '400px', hijackDestination: false, href: "/genelist"};
    Popups.openPath(element, options);*/   });




</script>

<br />

  <div   style="height:84%;" id="dt_example"> 
    <div style="height:84%;" id="container">
          <table  id='tblPrueba2' name='tblPrueba2' class='dataTable'>
		<thead>
          <tr class='headerFiltro'>
          <th class=''>
            </th>
             <th class=''>
         </th>
     
          <th  class=''>
              <input type='hidden' id='_search_gene_initVal' value='Filter Gene' />
              <input type='hidden' id='_search_gene_index' value='2' />
              <input type='text' id='search_gene' value='Filter Gene' class='search_init text_filter' />
            </th>
                   <th width="50px;" class=''>
              <input type='hidden' id='_search_transcript_initVal' value='Filter Transcript' />
              <input type='hidden' id='_search_transcript_index' value='3' />
			 <input type='text' id='search_transcript' value='Filter Transcript' class='search_init text_filter' />
            </th>
             <th width="50px;" class=''>
              <input type='hidden' id='_search_chromosome_initVal' value='Filter Chromosome' />
              <input type='hidden' id='_search_chromosome_index' value='4' />
			 <input type='text' id='search_chromosome' value='Filter Chromosome' class='search_init text_filter' />
            </th>
          
            <th  class=''>
              <input type='hidden' id='_search_synonyms_initVal' value='Filter Synonyms' />
              <input type='hidden' id='_search_synonyms_index' value='5' />
              <input type='text' id='search_synonyms' value='Filter Synonyms' class='search_init text_filter' />
            </th>
         <th class=''>
              <input type='hidden' id='_search_description_initVal' value='Filter Description' />
              <input type='hidden' id='_search_description_index' value='6' />
              <input type='text' id='search_description' value='Filter Description' class='search_init text_filter' />
            </th>
              <th class=''>
              <input type='hidden' id='_search_go_initVal' value='Filter GO' />
              <input type='hidden' id='_search_go_index' value='7' />
              <input type='text' id='search_go' value='Filter GO' class='search_init text_filter' />
            </th>
             <th class=''>
              <input type='hidden' id='_search_start_stop_initVal' value='Filter Start-Stop' />
              <input type='hidden' id='_search_start_stop_index' value='8' />
              <input type='text' id='search_start_stop' value='Filter Start-Stop' class='search_init text_filter' />
            </th>
            
                         <th class=''>
              <input type='hidden' id='_search_pfamdesc_initVal' value='Filter PFAM' />
              <input type='hidden' id='_search_pfamdesc_index' value='9' />
              <input type='text' id='search_pfamdesc' value='Filter PFAM' class='search_init text_filter' />
            </th>
            
                         <th class=''>
              <input type='hidden' id='_search_PANTHER_initVal' value='Filter PANTHER' />
              <input type='hidden' id='_search_PANTHER_index' value='10' />
              <input type='text' id='search_PANTHER' value='Filter PANTHER' class='search_init text_filter' />
            </th>
            
            <th class=''>
              <input type='hidden' id='_search_KOG_initVal' value='Filter KOG' />
              <input type='hidden' id='_search_KOG_index' value='11' />
              <input type='text' id='search_KOG' value='Filter KOG' class='search_init text_filter' />
            </th>
            
            <th class=''> 
              <input type='hidden' id='_search_KO_initVal' value='Filter KO' />
              <input type='hidden' id='_search_KO_index' value='12' />
              <input type='text' id='search_KO' value='Filter KO' class='search_init text_filter' />
            </th>
            
            <th class=''>
              <input type='hidden' id='_search_SMART_initVal' value='Filter SMART' />
              <input type='hidden' id='_search_SMART_index' value='13' />
              <input type='text' id='search_SMART' value='Filter SMART' class='search_init text_filter' />
            </th>
                     
         <th class=''>
              <input type='hidden' id='_search_ATG_initVal' value='Filter ATG' />
              <input type='hidden' id='_search_ATG_index' value='14' />
              <input type='text' id='search_ATG' value='Filter ATG' class='search_init text_filter' />
            </th>
            
            
            <th class=''>
              <input type='hidden' id='_search_bestblasthit_initVal' value='Filter Best BLAST' />
              <input type='hidden' id='_search_bestblasthit_index' value='15' />
              <input type='text' id='search_bestblasthit' value='Filter Best BLAST' class='search_init text_filter' />
            </th>
            
              <th class=''>
              <input type='hidden' id='_search_ATGSynonyms_initVal' value='Filter ATG Synonyms' />
              <input type='hidden' id='_search_ATGSynonyms_index' value='16' />
              <input type='text' id='search_ATGSynonyms' value='Filter ATG Synonyms' class='search_init text_filter' />
            </th>
            
                  
            
          </tr>
          <tr>    
           <th width="50px;"></th>
           <th width="10px"> </th>
            <th width="50px;">Gene</th>
            <th width="50px;">Transcript</th>
            <th width="50px;">Chromosome</th> 
            <th width="50px;">Synonyms</th>
             <th width="50px;">Description</th>
              <th width="70px;">GO</th>
              <th width="70px;">Start-Stop</th>
               <th width="80%">PFAM</th>
              <th width="80%">PANTHER</th>
              
               <th width="80%">KOG</th>
               <th width="80%">KO</th>
               <th width="80%">SMART</th>
               <th width="80%">ATG</th>
           
               <th width="50px">Best BLAST Hit</th>
                   <th width="50px">ATG Synonyms</th>
          </tr>
        </thead>
        <tbody>
        </tbody>
        <tfoot>
        </tfoot>
      </table>
    </div>
    </div>
<div id="loader" class="loader_color small"></div>



