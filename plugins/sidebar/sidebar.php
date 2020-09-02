<script type="text/javascript" src="plugins/sidebar/js/jquery.cycle.all.2.72.js"></script>
<script type="text/javascript" src="plugins/sidebar/js/jquery-sticklr-1.0.pack.js"></script>
<link rel="stylesheet" href="plugins/sidebar/css/font-awesome.min.css">
<link href="plugins/sidebar/css/style_2.css" rel="stylesheet" />
<script src="plugins/sidebar/js/init.js" type="text/javascript"></script>
<div id="editpanel" style="background:#fff; ;font-size:14px;overflow:hidden;z-index:9;position:fixed;display:none;min-width:360px;color:#000;border: 2px solid #e15b63;min-height:200px; ">
   <li id="genelistli" style="list-style-type: none;">
      <ul id="numberofgenesSpanDetail" class="notifi">
         <div id="content" style="font-weight:bold">
            <?php include( "plugins/genelist/crud/listui.php");?>
         </div>
         <div id="Formcontent"></div>
         <span class="hint--bottom" aria-label="Add new GeneList"> <a href="<?php print $GLOBALS['base_url']?>/plugins/genelist/crud/formui.php?action=add" class="add"><i class="savemenu fa-plus"></i></a></span> &nbsp;<span class="hint--bottom" aria-label="Duplicate selected GeneList"><a href="<?php print $GLOBALS['base_url']?>/plugins/genelist/crud/formui.php?action=savecurent"
            class="savecurrent"><i class="savemenu fa-copy"></i></a></span> &nbsp; <span id="cancelbtn" class="hint--right" aria-label="Cancel" style="display:none"><a href="<?php print $GLOBALS['base_url']?>/plugins/genelist/crud/formui.php?action=add" class="cancel"><i class="savemenu fa-ban"></i></a></span> 
      </ul>
   </li>
   <div id="editpanel2" style="background:#fff ;font-size:14px;;z-index:9;position:relative;display:none;width:100%;min-height:120px;overflow:hidden;min-height:200px;margin-left:-40px;">
      <ul style=" display: block;list-style-type: none;">
         <li style=" width:100%">
            <a class="toollinks" href="/blast">&nbsp;BLAST</a>
         </li>
         <li style=" width:100%">
            <a class="toollinks" href="/jbrowse">&nbsp;JBrowse</a>
         </li>
         <li style=" width:100%">
            <a class="toollinks" href="/chrdiagram">&nbsp;ChrDiagram</a>
         </li>
      </ul>
   </div>
   <div id="editpanel3" style="background:#fff ;font-size:12px;n;z-index:9;position:relative;display:none;width:100%;min-height:120px;overflow:hidden;min-height:200px;margin-left:-40px;">
      <ul style=" display: block;list-style-type: none;">
         <li>
            <a class="toollinks" href="/explot">&nbsp;exPlot</a>
         </li>
         <li>
            <a class="toollinks" href="/eximage">&nbsp;exImage</a>
         </li>
         <li>
            <a class="toollinks" href="/exheatmap">&nbsp;exHeatmap</a>
         </li>
      </ul>
   </div>
</div>
<link href="plugins/sidebar/drag/geniemenu.css" rel="stylesheet" />
<?php if($_SERVER['REMOTE_ADDR']=="85.226.1s86.116"){ ?>
<script src="plugins/sidebar/drag/geniemenu_copy.js" type="text/javascript"></script>
<?php }else{ ?>
<script src="plugins/sidebar/drag/geniemenu.js" type="text/javascript"></script>
<?php } ?>
<ul id="nav" style="list-style-type: none;background: #DA0D10;background-color: aqua">
   <li id="expression_tools" style="background:#e15b63;;width:40px;height:40px;border-radius:40px;text-align:center;vertical-align: top;color:#FFF;cursor:pointer;">
      <span class="hint--bottom hint--success" aria-label="Genome Tools">
         <a  style="color:#000" href="javascript:void(0);"></a>
         <div class="display-box">
            <div class="hero-icon yellow science-shake medium"  style="line-height: 2em"><i class="main fa fa-helix"><img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADQAAAA0CAYAAADFeBvrAAAEnElEQVRoQ+2ZjVEUQRCFuyNQIlAiACNQIhAjUCMQIhAiECJQIlAiECIQIhAjUCJo69vqvuqbm729vdu5Uoqpoqi73dntN/369c+pPLClDwyPPAL61z366KFNPGRmT0Xkk4jsi8i5qn7Z5Hm1vVvzkJkdishnEQEU64+q7vyXgMwMIO8K4y9UtfxuY3xNPeQU+yoirwpLL1UVj02+WgP6XoD55ZR7IiLEz6mq3k2JqhkgMzsRkY/J2FsHRwxx7S1xJCJnqno6FagmgJxqP5MAhL0nYbyZQcMzEdkTEbx0rKrfNgXWChDBjhDEOnCvvBSRGxF5r6r8FzPjXoBBwysH1l1bZ7UClOl2p6q7bvyRA8P47C1oyLWgKACJLyg5arUCxEnjjVh8foOBZvbcBaHmLa4B5rXHF6DPMyKn856qXteQbgMQYkCccNqAAhxUq3rLr5XxBUWv/DB+eGxSafCMudUKEJKMirE4SShIwEM1VO3YDe/1ViW+2M+hRDK+VtUyv7VpHzzQQxS6EsepAlDoRNDjrS4HDXirjK/wyFY9xMkj27GgTFeIuvEUqJw233dSvSy2Eg1J1LE4kAWZb0I5NyDTDuNfJI9QbWPMs0zBZd4ys/y8e1WNIrd9DKUTh1rEDWuufhugYBlbKF3Oa0g6cbmwmnkoBXUYUi1IU/xYpqDvp4DFM3EofH0vIs/7clRTQAkUhpFTqhWAmUFBDEfeZyro+8vWoxo74apRgPzFqBRyCYcxJBaKlSvn+Ez8dED6kqEbzvNIqsg995Nj+MttxmAPtRIgVyBOakH3azxe4bsMHuOjxAEUeaYW8Leqmg+w+ppBQO4V5LKqKisYP8UtJOfDVWq7pYCKUiMMy00a0jtXayUvZkrmum4MQN71pU/RRqucmZUdJz3LmQMFDEFMbUaCHOw83dsARZb5yws6d3WeU/Am6r4xJ9DrIW/AcmaeVczxgtSVEgMLlfEYQ6a6dxkgPICi5bXQWRaSyx68Ve1jvMZDxVCryWdynZLWTsaz+O90jeoYMMgq5QqGQ78ZzQpvzWq0/HwzI3nG2lklyMd6rg8Q2s/4KdYuxjtQSo4PtQHHkLcKQAfrxMgQwD5Acy20F5YzGhWGk0fwVjRuMdUJ0Lmi5l6EhNUJzJCBY6/3ASrjpxs3+Tw6A8td59wcwEWFOOkqamYETtWQ8N4CcyyIfH8foDwTuPSkiiELc7Siai57nOytqA6i2qh2nJuAWSYKGVDkHuIqRAHjkOmLJOEYGh6Zy02Ft2LLVgGFKFCq7xdqRq1FjEGlmozn+CtHVVA5KLc9QBwhVFomqy7TxFAMCImJEIbcoAE6pjYZ7HYBrcJlj58o8xcmn8VUFDpSLUfFvD1RWAVMkTBzL8Ol2S8LRe7K27aXh8YCSsIA1eKXhRkwV8c8vG9Ct16VWxdQAgatUMSQeuQ8V9dNvNMMUAJGfDGDy6s6INz0EGP/YMe67ovMjF8SylHT4Exg3fc1BVQMBeNdzcE0o5yZ5UqD5HzUqv8pPdqEcl6NIwokVcCM/uFqXeo1AbSuMVPsewQ0xSm2fMajh1qe7hTP/gv1NkBTnBOtgQAAAABJRU5ErkJggg==" width="24"  height="24"></img></i>
            </div>
         </div>
      </span>
   </li>
   <li id="analysis_tools" style="background:#e15b63;;width:40px;height:40px;border-radius:40px;text-align:center;vertical-align: top;color:#FFF;cursor:pointer">
      <span class="hint--right hint--success" aria-label="Expression Tools">
         <a  style="color:#000" href="javascript:void(0);"></a>
         <div class="display-box">
            <div class="hero-icon yellow science-shake medium"><i class="fa fa-calculator"></i>
            </div>
         </div>
      </span>
   </li>
   <li id="genenumber" style="background:#e15b63;;width:40px;height:40px;border-radius:40px;text-align:center;vertical-align: top;color:#FFF;cursor:pointer" class="hint--right hint--success" aria-label="Click here to open GeneList"><span class="notificationcount2"><a   onclick="open_samplelist();" href="plugins/genelist/tool.php" data-toggle="modal" data-target="#myModal" onclick="hidemef(this)"  data-refresh="true"><FONT color="#FFFFFF"><span  id="notificationcount_2"   style="opacity: 1;">00</span></FONT>
      </a>
      </span>
   </li>
</ul>
<script type="text/javascript">

</script>
</head>