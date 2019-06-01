<?php
ob_start();
session_start();
define('DS', DIRECTORY_SEPARATOR);
define('SITE_ROOT', dirname(__FILE__));
define('SETTINGS', dirname(__FILE__). DS . 'plugins' . DS . 'settings.php');
include_once(SETTINGS);
$rp = (isset($_SERVER['PHP_SELF']) && basename($_SERVER['PHP_SELF'])!="index.php")? basename($_SERVER['PHP_SELF']) : '';
$rp = isset($_REQUEST['page']) ? $_REQUEST['page'] : '';
$c['hostname'] = $GLOBALS["base_url"];//$hostname;
$c['password'] = 'admin';
$c['loggedin'] = false;
$c['page'] = 'home';
$d['page']['home'] = "<h3>Congratulations! You have successfully installed the GenIECMS.</h3><br />\nLogin to the admin panel using the 'Login' link in the footer. The password is admin.<br />\nChange the password as soon as possible.<br /><br />\n\nClick on the content to edit and click outside to save it.<br /><br />Now you successfully install the basic GenIE-CMS in your localhost. Now we need to load databases into MySQL database server. Then edit the plugins/settings.php file accordingly.\n";
$d['page']['example'] = "This is an example page.<br /><br />\n\nTo add a new one, click on the existing pages (in the admin panel) and enter a new one below the others.";
$d['new_page']['admin'] = "Page <b>".str_replace('-',' ',$rp)."</b> created.<br /><br />\n\nClick here to start editing!";
$d['new_page']['visitor'] = "Sorry, but <b>".str_replace('-',' ',$rp)."</b> doesn't exist. :(";
$d['default']['content'] = "Click to edit!";
$c['themeSelect'] = "genie";
$c['menu'] = "Home<br />\nExample";
$c['title'] = 'GenIECMS.org';
$c['subside'] = "<h3>ABOUT YOUR WEBSITE</h3><br />\nWebsite description, contact information, mini map or anything else.<br /><br />\n\n This content is static and is visible on all pages except tools.";
$c['description'] = 'Your website description.';
$c['keywords'] = 'enter, your website, keywords';
$c['copyright'] = "&copy;  Your website";//'&copy;'. //date('Y') .' Your website';
$sig = "Powered by <FONT color='#e15b63'><i class='fa fa-heart' aria-hidden='true'></i></FONT> <a href='http://geniecms.org'>GenIECMS</a>";
$hook['admin-richText'] = "rte.php";
$c['initialize_tool_plugin']=false;
include_once(__DIR__ . DS . 'functions.php');
ob_end_flush();
?>
