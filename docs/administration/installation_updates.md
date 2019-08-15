------------------------
Download the GenIE-CMS
------------------------

You can download the latest version of GenIECMS by using the official download link:

[![](https://raw.githubusercontent.com/irusri/GenIECMS/master/docs/images/download.png)](https://github.com/irusri/GenIECMS/archive/master.zip)

Please note that the above link will onlu download the source code for the GenIE-CMS. If you need to download the parsing scripts, you need to download it [here](https://github.com/irusri/scripts/archive/master.zip).

If you prefer using the terminal please run to download both the CMS and parsing scripts:

```
git clone --recursive https://github.com/irusri/GenIECMS.git
```    

------------------
GenIECMS's folder structure
------------------
```shell
├── GenIECMS 
│   ├── data
│   ├── docs   
│   ├── genie_files   
│   ├── index.php   
│   ├── js   
│   ├── LICENSE   
│   ├── plugins   
│   ├── README.md   
│   ├── scripts   
│   └── themes   
```



------------------------
Update configuration file
------------------------
We should update the settings file(```GenIECMS/plugins/settings.php```) right after the installtion. Especially the base URL depending on your webhost. For example:

```php
/*Define your base url with trailing slash*/
$GLOBALS["base_url"]='http://localhost:8888/GenIECMS/';

OR

$GLOBALS["base_url"]='http://localhost:3000';

```

Next, we need to create a MySQL database and load our data.


------------------------
Troubleshooting
------------------------
GenIECMS can easily be installed without an effort. Unfortunately there is always space for problems due to multiple server setups and PHP versions. In this section, we try to answer most frequent issues in order to install GenIECMS as effortless as possible. Please send us an email if you still get trouble with installation or updates: ```contact@geniecms.org```

**Subfolder permissions**

Web server runs in a different group than your user account on most servers. Following subfolder permissions will necessary to grant write access from GenIECMS.:
```
chgrp -R www-data GenIECMS
chmod -R 775 GenIECMS/genie_files
```
Please make sure that the root folder is also readable by the webserver.

**Broken subpages**

Whenever you have problems(can not open or  a server error) with subpages, you can try following steps.
* Make sure that the .htaccess file is present inside GenIECMS folder.
* mod_rewrite should be enabled on your server.
* You need to check the .htaccess. You can test this by adding  some extra  characters into your .htaccess. If this cause an "Internal Server Error", the file gets loaded. Otherwise, you need to enable AllowOverride all in your Web server  configuration file. An example of ```GenIECMS/.htaccess``` file shown below.

```
RedirectMatch 403 ^.*/genie_files/
ErrorDocument 403 &nbsp;
RewriteEngine on
Options -Indexes
ServerSignature Off
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteCond $1#%{REQUEST_URI} ([^#]*)#(.*)\1$
RewriteRule ^([^\.]+)$ %2?page=$1 [QSA,L]
ErrorDocument 404 /notfound.html
```


Please make sure that you are using the PHP 5.4 or higher. 

**More problems?**

Please contact us:```contact@geniecms.org```

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




