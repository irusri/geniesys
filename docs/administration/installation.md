Basic Installation
=====================  


## Installing with MAMP/XAMPP
  
Most Mac users will probably try GenIE-Sys with MAMP/LAMP.  

[![](https://github.com/irusri/geniesys/blob/master/docs/images/mamp.png?raw=true )](http://www.mamp.info/en/downloads/)

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


## Docker installation 

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


## Running from Command Line

If you want to use PHP's built-in server (**not recommended**), just use following lines to install GenIE-Sys. This is only for the initial test installation, in order to make a full functional website you have to install Webbserver package such as MAMP or LAMP.

```
git clone --recursive https://github.com/irusri/geniesys.git
cd geniesys
php -S localhost:3000
```
You should now be able to access GenIE-Sys at: ```http://localhost:3000``` in your browser.