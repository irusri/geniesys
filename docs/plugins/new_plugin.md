
How to create a plugin?
=======================

**How to create a plugin**

GenIECMS plugin can start as a simple file with a PHP function. All plugins are being installed in /GenIECMS/plugins. The only requirement for a plugin is that the foldername has to be the same as the menu name and index.php php file should be available inside the plugin folder.
```shell
/GenIECMS/plugins/{pluginname}/index.php
/GenIECMS/plugins/{pluginname}/tool.php
```
**Hello World! Plugin**

```shell
/GenIECMS/plugins/hello/hello.php
```
1. Creat hello_world directory inside the plugin directory
2. Place following index.php file inside hello_world directory
```php
<?php
//index.php
$subdir_arr = explode("/", $_SERVER['REDIRECT_URL']);
$mennu_arr = explode("<br />", $c['menu']);
$menu_exist = false;
for ($search_num = 0; $search_num < count($mennu_arr); $search_num++) {  
    if (trim(strtolower($mennu_arr[$search_num])) == strtolower($subdir_arr[count($subdir_arr) - 1]) ||      
    trim(strtolower($mennu_arr[$search_num])) == "-".strtolower($subdir_arr[count($subdir_arr) - 1])) {  
        $menu_exist = true;
    }
}
if(strtolower(basename(dirname(__FILE__)))== strtolower($subdir_arr[count($subdir_arr)-1]) && $menu_exist==true){
    $c['initialize_tool_plugin'] = true;
    $c['tool_plugin'] = strtolower($subdir_arr[count($subdir_arr) - 1]);
}
?>
```
3.) Add tool.php into the hello_world directory
```php
<?php
//tool.php
echo "Hello World!";
?>
```
4.) Log into the system and add hello into the menu like shown in following figure 1.0.

4.) Navigate to http://[server name]/GenIECMS/hello_world
