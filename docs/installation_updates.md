Installation & Updates
=====================

------------------------
Download the GenIE-Sys
------------------------

You can download the latest version of GenIE-Sys by using the official download link:

[![](https://raw.githubusercontent.com/plantgenie/geniesys/master/docs/images/download.png)](https://github.com/plantgenie/geniesys/archive/master.zip)

Please note that the above link will onlu download the source code for the GenIE-Sys. If you need to download the parsing scripts, you need to download it [here](https://github.com/irusri/scripts/archive/master.zip).

If you prefer using the terminal please run to download both the GenIE-Sys and parsing scripts:

```
git clone --recursive https://github.com/plantgenie/geniesys.git
```    

------------------
GenIE-Sys's folder structure
------------------
```shell
├── geniesys 
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
Installing GenIE-Sys on a Mac
------------------------
Most Mac users will probably try GenIE-Sys with MAMP.  

[![](https://github.com/irusri/geniesys/blob/master/docs/images/mamp.png?raw=true )](http://www.mamp.info/en/downloads/)

**Installing MAMP**

Installing MAMP is just a matter of downloading the app from the MAMP website and running the installer. It will install a MAMP app in your Applications folder.

[![](https://github.com/irusri/geniesys/blob/master/docs/images/mamp-02.png?raw=true)](http://www.mamp.info/en/downloads/)

By starting the MAMP app you are also starting your Apache and MySQL server. You should now be able to reach your local server at ```http://localhost:8888```.

It is convenient to change the MySQL and Apache ports to 3306 and 80 respectively to use default MySQL and Apache ports.

[![](https://github.com/irusri/geniesys/blob/master/docs/images/mamp_settings.png?raw=true)](http://www.mamp.info/en/downloads/)

**Download GenIE-Sys**

[![](https://github.com/irusri/geniesys/blob/master/docs/images/download.png?raw=true)](https://github.com/irusri/geniesys/archive/master.zip)

**Copy GenIE-Sys to MAMP Web server**

You will find the source of GenIE-Sys in your download folder. So you just need to Copy GenIE-Sys folder into corresponding ```~/Applications/MAMP/htdocs/``` folder.

That is basically what you need to do in order to install GenIE-Sys on your Mac's local server. You should now be able to access it at: ```http://localhost:8888/geniesys``` in your browser.

-----------------
Docker installation 
-----------------
For Developers and Contricutors

```
# Please comment the supporting_files/run.sh line to avoid download the geniesys.git  
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
If you want to use PHP's built-in server (not recommended), just use following lines to install GenIE-Sys. This is only for the initial test installation, in order to make a full functional website you have to install Webbserver package such as MAMP or LAMP.

```
git clone --recursive https://github.com/irusri/geniesys.git
cd geniesys
php -S localhost:3000
```
You should now be able to access geniesys at: ```http://localhost:3000``` in your browser.

------------------------
Update configuration file
------------------------
We should update the settings file(```geniesys/plugins/settings.php```) right after the installtion. Especially the base URL depending on your webhost. For example:

```php
/*Define your base url with trailing slash*/
$GLOBALS["base_url"]='http://localhost:8888/geniesys/';

OR

$GLOBALS["base_url"]='http://localhost:3000';

```

Next, we need to create a MySQL database and load our data.


------------------------
Troubleshooting
------------------------
GenIE-Sys can easily be installed without an effort. Unfortunately there is always space for problems due to multiple server setups and PHP versions. In this section, we try to answer most frequent issues in order to install GenIE-Sys as effortless as possible. Please send us an email if you still get trouble with installation or updates: ```contact@geniecms.org```

**Subfolder permissions**

Web server runs in a different group than your user account on most servers. Following subfolder permissions will necessary to grant write access from GenIE-Sys.:
```
chgrp -R www-data geniesys
chmod -R 775 geniesys/genie_files
```
Please make sure that the root folder is also readable by the webserver.

**Broken subpages**

Whenever you have problems(can not open or  a server error) with subpages, you can try following steps.
* Make sure that the .htaccess file is present inside GenIE-Sys folder.
* mod_rewrite should be enabled on your server.
* You need to check the .htaccess. You can test this by adding  some extra  characters into your .htaccess. If this cause an "Internal Server Error", the file gets loaded. Otherwise, you need to enable AllowOverride all in your Web server  configuration file. An example of ```geniesys/.htaccess``` file shown below.

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
GenIE-Sys updates
-----------------
**Manual updates**

GenIE-Sys can be updated manually using latest ZIP file from [GitHub](https://github.com/irusri/geniesys/archive/master.zip). Please backup your older version of  ```geniesys/plugins/settings.php``` and ```geniesys/genie_files``` before you do the latest update. First unzip the genie.zip file from your download folder and move into the Web Server server. Finally copy the ```geniesys/plugins/settings.php``` and ```geniesys/genie_files``` into latest version of GenIE-Sys.

**Updates using Git**

Here is the easy way to update GenIE-Sys using git submodules:

```
cd GenIE-Sys
git checkout master
git pull
git submodule foreach --recursive git checkout master
git submodule foreach --recursive git pull
```




