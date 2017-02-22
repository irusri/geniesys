<?php
ob_start();
session_start();
define('DS', DIRECTORY_SEPARATOR);
define('SITE_ROOT', dirname(__FILE__));
define('SETTINGS', dirname(__FILE__). DS . 'plugins' . DS . 'settings.php');
include_once(__DIR__ . DS . 'plugins' . DS . 'settings.php');
include_once(__DIR__ . DS . 'functions.php');
ob_end_flush();
?>
