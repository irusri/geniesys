<?php 
$subdir_arr = explode("/", $_SERVER['REDIRECT_URL']);
$mennu_arr= explode("<br />", $c['menu']);
$menu_exist=false;
for($search_num=0;$search_num<count($mennu_arr);$search_num++){
	if(trim(strtolower($mennu_arr[$search_num]))==strtolower($subdir_arr[count($subdir_arr)-1]) || trim(strtolower($mennu_arr[$search_num]))=="-".strtolower($subdir_arr[count($subdir_arr)-1])){
		$menu_exist=true;
	}
}
$actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
if(strtolower(basename(dirname(__FILE__))== strtolower($subdir_arr[count($subdir_arr)-1]) ) || $GLOBALS["base_url"] ==$actual_link ){
//if(strtolower(basename(dirname(__FILE__))== strtolower($subdir_arr[count($subdir_arr)-1]) ) ||  $_SERVER["REQUEST_URI"] =="/geniesys/"   ){//&& $menu_exist==true 
	$c['initialize_tool_plugin']=false;
	$c['tool_plugin']=strtolower($subdir_arr[count($subdir_arr)-1]);
	$c['tool_plugin']="home";
}
?>
