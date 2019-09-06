------------------------
Configuration file
------------------------
We should update the settings file(```geniesys/plugins/settings.php```) right after the installtion. Especially the base URL depending on your webhost. For example:

```php
/*Define your base url with trailing slash*/
$GLOBALS["base_url"]='http://localhost:8888/geniesys/';

OR

$GLOBALS["base_url"]='http://localhost:3000';

```

Next, we need to create a MySQL database and load our data.


-----------------
Updates
-----------------
**Manual updates**

GenIE-Sys can be updated manually using latest ZIP file from [GitHub](https://github.com/irusri/geniesys/archive/master.zip). Please backup your older version of  ```geniesys/plugins/settings.php``` and ```geniesys/genie_files``` before you do the latest update. First unzip the genie.zip file from your download folder and move into the Web Server server. Finally copy the ```geniesys/plugins/settings.php``` and ```geniesys/genie_files``` into latest version of GenIE-Sys.

**Updates using Git**

Here is the easy way to update GenIE-Sys using git submodules:

```
cd geniesys
git checkout master
git pull
git submodule foreach --recursive git checkout master
git submodule foreach --recursive git pull
```



