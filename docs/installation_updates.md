Installation & Updates
=====================

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
Installing GenIECMS on a Mac
------------------------
Most Mac users will probably try GenIECMS with MAMP.  

[![](https://github.com/irusri/GenIECMS/blob/master/docs/images/mamp.png?raw=true )](http://www.mamp.info/en/downloads/)

**Installing MAMP**

Installing MAMP is just a matter of downloading the app from the MAMP website and running the installer. It will install a MAMP app in your Applications folder.

[![](https://github.com/irusri/GenIECMS/blob/master/docs/images/mamp-02.png?raw=true)](http://www.mamp.info/en/downloads/)

By starting the MAMP app you are also starting your Apache and MySQL server. You should now be able to reach your local server at ```http://localhost:8888```.

It is convenient to change the MySQL and Apache ports to 3306 and 80 respectively to use default MySQL and Apache ports.

[![](https://github.com/irusri/GenIECMS/blob/master/docs/images/mamp_settings.png?raw=true)](http://www.mamp.info/en/downloads/)

**Download GenIECMS**

[![](https://github.com/irusri/GenIECMS/blob/master/docs/images/download.png?raw=true)](https://github.com/irusri/GenIECMS/archive/master.zip)

**Copy GenIECMS to MAMP Web server**

You will find the source of GenIECMS in your download folder. So you just need to Copy GenIECMS folder into corresponding ```~/Applications/MAMP/htdocs/``` folder.

That is basically what you need to do in order to install GenIECMS on your Mac's local server. You should now be able to access it at: ```http://localhost:8888/GenIECMS``` in your browser.

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
-----------------
Docker installation 
-----------------
For Developers and Contricutors

```
# Please comment the supporting_files/run.sh line to avoid download the geniecms.git  
git clone https://github.com/irusri/docker4geniecms.git  
cd docker4geniecms  
git submodule add -f https://github.com/irusri/genie.git  
docker build -t genie -f ./Dockerfile .  
docker run --rm -i -t -p "80:80" -p "3308:3306" -v ${PWD}/genie:/app -v ${PWD}/mysql:/var/lib/mysql -e MYSQL_ADMIN_PASS="mypass" --name genie genie  
cd genie 
```

When we need to commit changes, please go to `cd docker4geniecms/genie` folder. Never commit from `docker4geniecms` folder. Because it will add genie as a submodule. Incase you mistakenly pushed from `docker4geniecms` folder, please `cd docker4geniecms` and  `git rm genie`. You can access MySQL using `mysql -u admin -pmypass -h localhost -P 3308` or using [phpMyAdmin](http://localhost/phpmyadmin). Some useful docker commands are as follows.
```
# Must be run first because images are attached to containers
docker rm -f $(docker ps -a -q)
# Delete every Docker images
docker rmi -f $(docker images -q)
# To see docker process
docker ps -l 
# To see or remove all volumes
docker volume ls/prune
# To run bash inside the running docker container
docker exec -it 890fa15eeef6126b668f4b0fcb7a38b33eaff0 /bin/bash
or
docker attach 890fa15eeef6126b668f4b0fcb7a38b33eaff0
```

Now we can start the real development and push changes into genie.

------------------------
Running from Command Line
------------------------
If you want to use PHP's built-in server (not recommended), just use following lines to install GenIECMS. This is only for the initial test installation, in order to make a full functional website you have to install Webbserver package such as MAMP or LAMP.

```
git clone --recursive https://github.com/irusri/GenIECMS.git
cd GenIECMS
php -S localhost:3000
```
You should now be able to access GenIECMS at: ```http://localhost:3000``` in your browser.




