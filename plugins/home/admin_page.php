<link rel="stylesheet" type="text/css" href="plugins/home/css/admin.css" />
<script type="text/javascript" src="plugins/home/js/jquery.hashchange.min.js"></script>
<script type="text/javascript" src="plugins/home/js/jquery.easytabs.min.js"></script> 
<div id="tab-container" class='tab-container'>
     <ul class='etabs'>
     <li class='tab'><a href="#page">Edit page</a></li>
       <li class='tab'><a href="#site">Site settings</a></li>
       <li class='tab'><a href="#db">Database settings</a></li>
       <li  class='tab'><a href="#annotation">Annotation</a></li>
       <li class='tab'><a href="#expression">Expression</a></li>
     </ul>
    <div class='panel-container'>
      <div id="page"> <br>
       <!--page section start id="main_editor"-->
       <br><br>
       <textarea class="ckeditor" name="editor"><?php content($c['page'],$c['content']);?></textarea>
               <script type="text/javascript">
                  var key = <?php echo json_encode($c['page']); ?>
               </script>
               <button id="btn_submit" onclick="save(key);">save</button>
               <?php  include('themes/genie/msg_box.php'); ?> 
       <!--page section ended-->
      </div> 
      <div id="site"> <br>
       <!--site section start-->
<?php settings();?>
<button id="btn_submit"  onclick='javascript:location.reload(true);'>save</button>
       <!--site section ended-->
</div>
      <div id="db"><br>
      <!--db section start-->
      <h3>Loading novel genome to GenIE-Sys database. Follow the steps one at a time.</h3>
<span style="overflow: hidden;position: absolute;top:30px" id="error_msg"></span>
<form  id="db_form">
   <p><label for="host">Host:&nbsp;&nbsp;&nbsp;</label><input autocomplete="host" id="mhost" value="localhost" placeholder="MySQL host : localhost" type="text"/> &#9432; This is the default host </p>
   <p><label for="username">Username:</label><input value="admin" autocomplete="username" id="musername" placeholder="MySQL username: admin" type="text"/> &#9432; This is the default username (MAMP uses root as default username) </p>
   <p><label for="password">Password:</label><input value="mypass" autocomplete="password" id="mpassword" placeholder="MySQL password : mypass" type="text"/> &#9432; This is the default password (MAMP uses root as default password)</p>
   <p><label for="database">Database:</label><input id="mdbname" placeholder="Type in new database name" value="" type="text"/> &#9432; Current database name should be type in here</p>
</form>
<br>
<!--<h3> There is a database name stated in the setting file. Howevere that database does not exsist in MySQL server. Do you want to create a new database?</h3>-->
<button class="upbtn"  id="create_db">create a fresh database</button>
<!--<button class="upbtn"  id="create_db_arabidopsis">create a database with <i>Arabidopsis thaliana</i></button>-->
<button id="drop_db" class="upbtn"  style="background:red;color:white">Delete current database</button>&nbsp; <span class="help_span">&#9432; First you have to create a database or use the existing database.</span> 
<button class="upbtn" style="display:none"  id="download_indices">Download indices</button>
<br><br>
<div id="clone_div" style="border:dotted thin black;width:60%;border-radius:5px;padding:6px;display:none">
<h4>Clone from the PlantGenIE core species. This includes all the annotation and expression data.</h4>
<button class="upbtn" onClick="clone_genome(this)"  id="potra">Populus tremula</button>
<button class="upbtn" onClick="clone_genome(this)" id="piabi">Picea abies</button>
<button class="upbtn" onClick="clone_genome(this)"  id="artha">Arbidopsis thaliana</button>
<button class="upbtn" onClick="clone_genome(this)"  id="eugra">Eucalyptus grandis</button></br></br>
</div>
</br></br> 
<a target="_blank" id="myadmin_links" style="color:blue;font-weight:bold;float:right;cursor:pointer">External link to phpMyAdmin page >></a><br>
      <!--db section ended-->
      </div>
      <div id="annotation"><br>
        <!--annotation section started-->
        <div style="padding:4px;background:#808080;color:#ffffff;border-radius:5px;padding:6px;font-size:12px"> Please click the checkboxes one after the other and wait till the previous one is completed before go to the next one.</div>

<span id="check_files_span">
There are some missing files in the data directory. Please upload the following files into data directory and refresh this page again. <br><span style="color:red" id="missing_files"></span>
</span>

<label class="tasks-list-item">
        <input id="database_checkbox" type="checkbox"  onchange="db_operation('db_name', 'check');" name="task_3" value="1" class="tasks-list-cb">
        <span class="tasks-list-mark"></span>
        <span class="tasks-list-desc">Check database connection</span><span id="database_waiting"> &nbsp;&nbsp; <img src='plugins/home/css/btnloader.GIF' /></span>
      </label>
      <label class="tasks-list-item">
        <input id="files_checkbox" type="checkbox"  onchange="check_files()" name="task_2" value="1" class="tasks-list-cb" >
        <span class="tasks-list-mark"></span>
        <span class="tasks-list-desc">Check all required files are included in the data folder</span><span id="files_waiting"> &nbsp;&nbsp; <img src='plugins/home/css/btnloader.GIF' /></span>
      </label>
      <label class="tasks-list-item">
        <input id="prepare_checkbox" type="checkbox"  onchange="generate_files()" name="task_1" value="1" class="tasks-list-cb" >
        <span class="tasks-list-mark"></span>
        <span class="tasks-list-desc">Parse gene.gff3 file into the correct formats</span><span id="prepare_waiting"> &nbsp;&nbsp; <img src='plugins/home/css/btnloader.GIF' /></span>
      </label>


       <label class="tasks-list-item">
        <input id="load_checkbox" type="checkbox" onchange="load_database()" name="task_3" value="1" class="tasks-list-cb">
        <span class="tasks-list-mark"></span>
        <span class="tasks-list-desc">Store primary data into the database</span><span id="load_waiting"> &nbsp;&nbsp; <img src='plugins/home/css/btnloader.GIF' /></span>
      </label>

      <label class="tasks-list-item">
        <input id="update_description_checkbox" type="checkbox" onchange="annotation_update_description()" name="task_3" value="1" class="tasks-list-cb">
        <span class="tasks-list-mark"></span>
        <span class="tasks-list-desc">Store description (gene and transcript) into the database </span><span id="update_description_waiting"> &nbsp;&nbsp; <img src='plugins/home/css/btnloader.GIF' /></span> 
        <!--<a href='javascript:go_to_help(this);'>(help)</a>-->
      </label> 


      <label class="tasks-list-item">
        <input id="update_extra_annotation_checkbox" type="checkbox" onchange="annotation_update_extra_annotation()" name="task_3" value="1" class="tasks-list-cb">
        <span class="tasks-list-mark"></span>
        <span class="tasks-list-desc">Store extra annotation Pfam/GO/Kegg into the database</span><span id="update_extra_annotation_waiting"> &nbsp;&nbsp; <img src='plugins/home/css/btnloader.GIF' /></span>
      </label> 

      <label class="tasks-list-item">
        <input id="update_best_blast_checkbox" type="checkbox" onchange="annotation_update_best_blast()" name="task_3" value="1" class="tasks-list-cb">
        <span class="tasks-list-mark"></span>
        <span class="tasks-list-desc">Store best BLAST annotation into the database</span><span id="update_best_blast_waiting"> &nbsp;&nbsp; <img src='plugins/home/css/btnloader.GIF' /></span>
      </label> 

      <label class="tasks-list-item">
        <input id="update_gene_i_checkbox" type="checkbox" onchange="annotation_update_gene_i()" name="task_3" value="1" class="tasks-list-cb">
        <span class="tasks-list-mark"></span>
        <span class="tasks-list-desc">Update  and optimise database indices for quick search</span><span id="update_gene_i_waiting"> &nbsp;&nbsp; <img src='plugins/home/css/btnloader.GIF' /></span>
      </label> 
 

      <label class="tasks-list-item">
        <input id="fasta_checkbox" type="checkbox" onchange="generate_fasta_indices()" name="task_3" value="1" class="tasks-list-cb">
        <span class="tasks-list-mark"></span>
        <span class="tasks-list-desc">Generate FASTA indices</span><span id="fasta_waiting"> &nbsp;&nbsp; <img src='plugins/home/css/btnloader.GIF' /></span>
      </label> 
      <a target="_blank" id="myadmin_links_annotation" style="color:blue;font-weight:bold;float:right;cursor:pointer">Check whether the data correctly loaded into the annotation tables >></a><br>
     <!--annotation section ended-->
    </div>
      <div id="expression"><br>

      
<div style="padding:4px;background:#808080;color:#ffffff;border-radius:5px;padding:6px;font-size:12px"> You need to follow the file specifications to correctly loading expression data into the GenIE-Sys database. Therefore, please use the standard templates for preparing the experiment and expression files. 
Here (experiment.tsv  expression.tsv) you can download the template files. Then upload them to geniesys/data folder.</div><br>

<div id="expression_error" style="padding:6px;background:#ffa500;color:#ffffff;border-radius:5px;padding:6px;font-size:12px;display:none"> </div>

      <label class="tasks-list-item">
        <input id="check_experiment_checkbox" type="checkbox"  onchange="check_expression_files()" name="task_2" value="1" class="tasks-list-cb" >
        <span class="tasks-list-mark"></span>
        <span class="tasks-list-desc">Check the experiment and expression files are exsist</span><span id="check_experiment_waiting"> &nbsp;&nbsp; <img src='plugins/home/css/btnloader.GIF' /></span>
      </label>
      <label class="tasks-list-item">
        <input id="load_experiment_checkbox" type="checkbox"  onchange="load_expression_table('experiment')" name="task_2" value="1" class="tasks-list-cb" >
        <span class="tasks-list-mark"></span>
        <span class="tasks-list-desc">Load the experiment file into the experiment table</span><span id="experiment_waiting"> &nbsp;&nbsp; <img src='plugins/home/css/btnloader.GIF' /></span>
      </label>
      <label class="tasks-list-item">
        <input id="load_expression_checkbox" type="checkbox"  onchange="load_expression_table('expression')" name="task_2" value="1" class="tasks-list-cb" >
        <span class="tasks-list-mark"></span>
        <span class="tasks-list-desc">Load the expression file into the expression table</span><span id="expression_waiting"> &nbsp;&nbsp; <img src='plugins/home/css/btnloader.GIF' /></span>
      </label>

      <div id="expression_info" style="padding:6px;background:#808080;color:#ffffff;border-radius:5px;padding:6px;font-size:10px;display:none"> Congratulations! Now you can add expression tools to the main menu. Go to the Site settings tab and add <b>explot</b> to the navigation text area as a separate menu link. </div>
      
      <a target="_blank" id="myadmin_links_expression" style="color:blue;font-weight:bold;float:right;cursor:pointer">Check whether the data correctly loaded into the experiment and expression tables >></a><br>
        <!--expression section started-->
        <!--expression section ended-->
      </div>

    </div>
    <br>
</div>
<button class="upbtn" onClick="test_download()"  >Test</button>
<script src="plugins/home/js/init.js"></script>
<script src="plugins/home/js/annotation.js"></script>
