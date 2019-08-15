------------------------
Configuration file
------------------------
We should update the settings file(```GenIECMS/plugins/settings.php```) right after the installtion. Especially the base URL depending on your webhost. For example:

```php
/*Define your base url with trailing slash*/
$GLOBALS["base_url"]='http://localhost:8888/GenIECMS/';

OR

$GLOBALS["base_url"]='http://localhost:3000';

```

Next, we need to create a MySQL database and load our data.


-----------------
GenIECMS updates
-----------------
**Manual updates**

GenIECMS can be updated manually using latest ZIP file from [GitHub](https://github.com/irusri/GenIECMS/archive/master.zip). Please backup your older version of  ```GenIECMS/plugins/settings.php``` and ```GenIECMS/genie_files``` before you do the latest update. First unzip the genie.zip file from your download folder and move into the Web Server server. Finally copy the ```GenIECMS/plugins/settings.php``` and ```GenIECMS/genie_files``` into latest version of GenIECMS.

**Updates using Git**

Here is the easy way to update GenIECMS using git submodules:

```
cd GenIECMS
git checkout master
git pull
git submodule foreach --recursive git checkout master
git submodule foreach --recursive git pull
```



