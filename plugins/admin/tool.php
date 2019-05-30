
<?php 
$tmp_key=uniqid();
setcookie('genie_key', $tmp_key);?>
<iframe id="build_frame" width="100%" height="900px"  frameborder="0" src="http://build.plantgenie.org/geniecms.php?key=<?php echo $tmp_key;?>">
</iframe>
<script src="plugins/admin/js/init.js" type="application/javascript"></script>
<div id="post_information" style="display:none">
You can access the database in using <a target="_blank" href="http://localhost/phpmyadmin">phpMyAdmin</a><br>
<pre>
username: admin
password: mypass
</pre>
You have successfully installed the GenIE-CMS and <span id='db_name_1'>eucgenie_egrandis_v2_new</span> database into personal docker container. Now you need to add following database details into plugins/settings.php file.

<pre>
$db_species_array=array("<span id='db_name_2'>eucgenie_egrandis_v2_new</span>"=>"<span id='species_name'>eucgenie_egrandis_v2_new</span>");
$GLOBALS['db_url']=  array ('genelist'=>'mysqli://admin:mypass@localhost/'.$selected_database);
$GLOBALS["base_url"]='http://localhost';
</pre>
Further customisation please go to CMS documentation <a target="_blank" href="https://geniecms.readthedocs.io/en/latest">https://geniecms.readthedocs.io/en/latest/</a>
</div><?php if(is_loggedin()) { ?>
<?php } ?>