Database design
=====================  

GenIE-Sys is a file-based Contents Management System(CMS) with basic content stored in text files. MySQL database is not needed to get started with the CMS. However, the database server is required to load the genomic data and integrate with GenIE-Sys plugins.

You can create a database using a graphical user interface or command line.
## Creating a new database using GUI
Once you navigate to the Home page, you will see options to install the database. There are two options available, to begin with, database installation, as stated below.

**1.) install Arabidopsis thaliana model species**   
**2.) install an empty database.**

[![](https://github.com/irusri/geniesys/blob/master/docs/images/install_db.png?raw=true)](https://raw.githubusercontent.com/irusri/geniesys/master/docs/images/install_db.png) 

**1.) install Arabidopsis thaliana model species** 

You need to type in the database name, MySQL host, username and password and then click the button "Load Data into the Database."  
[![](https://github.com/irusri/geniesys/blob/master/docs/images/install_atg_db.png?raw=true)](https://raw.githubusercontent.com/irusri/geniesys/master/docs/images/install_atg_db.png) 

**2.) install an empty database.**  

You need to type in the empty database name, MySQL host, username and password and then click the button "Load Data into the Database."
[![](https://github.com/irusri/geniesys/blob/master/docs/images/install_empty_db.png?raw=true)](https://raw.githubusercontent.com/irusri/geniesys/master/docs/images/install_empty_db.png)  

Once the above processes are completed, you can be able to access the newly created database in MySQL server. 

## Creating a new database using CMD

Due to increasing number of species in PlantGenIE we use standard naming convention to easily identify and maintain the databases. For example: ```[website name]_[species name]_[version number]```   

[![](https://github.com/irusri/geniesys/blob/master/docs/images/genie_databases.png?raw=true)](https://raw.githubusercontent.com/irusri/geniesys/master/docs/images/genie_databases.png)  



Log into the MySQL server and create a database. 
```mysql
#Create a database:
CREATE DATABASE new_database;
```
You can download the empty database [here](https://raw.githubusercontent.com/irusri/scripts/master/dump.sql). Then load the database into the newly created database using following commands.


```shell
git show HEAD~1:scripts/dump.sql > dump.sql
mysql -u newuser -p newpassword new_database < dump.sql
```
Log into the MySQL server to create user and grant permissions.
```mysql
#Create MySQL user:
CREATE USER newuser@'localhost' IDENTIFIED BY 'newpassword';

#User permissions:
GRANT SELECT ON new_database.* TO newuser@'localhost';
GRANT INSERT,UPDATE,DELETE ON new_database.genebaskets TO newuser@'localhost';
GRANT INSERT,UPDATE,DELETE ON new_database.defaultgenebaskets TO newuser@'localhost';
```
```newuser, newpassword and new_database``` should be included in the plugins/settings.php similar to following example.
```php
//Define the databasename names
$db_species_array=array("new_database"=>"new genome",...
//Define the databasename and background colours
$db_species_color_array=array("new_database"=>"#86c0a6",....
//Define the username, password and host here
$db_url=  array ('genelist'=>'mysqli://newuser:newpassword@localhost/'.$selected_database); 
//Define the base url with trailing slash
$GLOBALS["base_url"]='http://localhost:3000/';
```
**Loading tables**

Following database diagram shows the initial genie database architecture. It will be used with basic geniesys tools such as GeneList, gene information pages, autocomlete search and BLAST. 


[![](https://raw.githubusercontent.com/irusri/geniesys/master/docs/images/GenIE-CMS_V4.png)](https://raw.githubusercontent.com/irusri/geniesys/master/docs/images/GenIE-CMS_V4.png)

We have to to follow the [data loading](https://geniesys.readthedocs.io/en/latest/plugins/genelist.html) instructions in order to load data into the database tables.


**Configuring genome database**


All configuration settings in geniesys need to be added into ```/geniesys/plugins/settings.php``` file. You need to update ```/geniesys/plugins/settings.php``` file with your available details. You can find everything about the integration plugins and how to load data in the plugins section.


