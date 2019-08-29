Database design
=====================  

GenIE-CMS is a file-based CMS with basic content stored in text files. MySQL database is not needed to get started with the CMS. However, the database server is required to load the genomic data and integrate with GenIE-CMS plugins.

You can create a database using a graphical user interface or command line.
## Creating a new database GUI

## Creating a new database CMD

Due to increasing number of species in PlantGenIE we use standard naming convention to easily identify and maintain the databases. For example: ```[website name]_[species name]_[version number]``` 

[![](https://github.com/irusri/GenIECMS/blob/master/docs/images/genie_databases.png?raw=true)](https://raw.githubusercontent.com/irusri/GenIECMS/master/docs/images/genie_databases.png)



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
# Loading tables

Following database diagram shows the initial genie database architecture. It will be used with basic GenIECMS tools such as GeneList, gene information pages, autocomlete search and BLAST. 


[![](https://raw.githubusercontent.com/irusri/GenIECMS/master/docs/images/GenIE-CMS_V4.png)](https://raw.githubusercontent.com/irusri/GenIECMS/master/docs/images/GenIE-CMS_V4.png)

We have to to follow the [data loading](https://geniecms.readthedocs.io/en/latest/plugins/genelist.html) instructions in order to load data into the database tables.


# Configuring genome database


All configuration settings in GenIECMS need to be added into ```/GenIECMS/plugins/settings.php``` file. You need to update ```/GenIECMS/plugins/settings.php``` file with your available details. You can find everything about the integration plugins and how to load data in the plugins section.


