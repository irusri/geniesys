How to create a plugin?
=======================

**How to create a plugin**

A GenIECMS plugin can start as a simple file with a PHP function. All plugins are being installed in /geniecms/plugins. The only requirement for a plugin is that the foldername has to be the same as the menu name and index.php php file should be available inside the plugin folder.
```
/geniecms/plugins/{pluginname}/index.php
/geniecms/plugins/{pluginname}/tool.php
```
For example:
```
/geniecms/plugins/hello/hello.php
```
