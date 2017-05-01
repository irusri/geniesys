
Getting Started
=============

------------
What is GenIECMS?
------------

The Genome Integrative Explorer Content Management System (GenIE-CMS) is dedicative in-house CMS to facilitate external groups in setting up their own web resource for searching, visualizing, editing, sharing and reproducing their genomic and transcriptomic data while using project raw data(gff3,fasta,fatsq) as an input.

GenIE-CMS will support cutting-edge genomic science, providing easily accessible, reproducible, and shareable science. The increasingly large size of many datasets is a particularly challenging aspect of current and future genomics based research; it is often difficult to move large datasets between servers due to constraints of time and finance. It is also important to keep the experimental datasets private among the group members until the project goals are accomplished or until after publication. In other words, it must provide a high level of security to ensure that the genomic web resource remains private without requiring the moving of data to unknown remote servers. Therefore, a locally hosted GenIE-CMS installation represents a more secure, less expensive and time consuming resource to implement.

In Addition, Researchers who are not specialized in bioinformatics or have limited computers skills are not currently able to gain maximal insight from the biological data typically produced by genomics projects. In order to overcome this limitation, GenIE-CMS will provide an ideal gateway with simple graphical user interfaces to those who have limited skills in bioinformatics.

Web resources such as <a target="_blank" href="http://www.ncbi.nlm.nih.gov/pmc/articles/PMC3245001/">Phytozome(Goodst et al., 2012) </a>, <a target="_blank"  href="http://www.ncbi.nlm.nih.gov/pmc/articles/PMC3355756/">iPlant( Goff. et al.,2011)</a>, <a  target="_blank" href="https://academic.oup.com/nar/article/31/1/224/2401365/The-Arabidopsis-Information-Resource-TAIR-a-model">TAIR (Rhee et al., 2003)</a> and <a target="_blank"  href="http://www.plantphysiol.org/content/158/2/590">PLAZA (Proost et al., 2011)</a>. These collections of tools and services have been sources of inspiration to be and have contributed my desire to develop the GenIE-CMS as well as, and importantly, developing an understanding of their limitations to end users. None of these resources allow users to easily setup their own web resource without submitting their data to the resource developers and making them publicly available.

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
-------------------------
Database design
-------------------------

**Creating a new database**

Due to increasing number of species in PlantGenIE we use standard naming convention to easily identify and maintain the databases. For example: ```[website name]_[species name]_[version number]``` 

[![GenIE Databases](https://github.com/irusri/GenIECMS/blob/master/docs/images/genie_databases.png?raw=true "GenIE Databases")](https://raw.githubusercontent.com/irusri/GenIECMS/master/docs/images/genie_databases.png)

```mysql
#Create a database:
CREATE DATABASE new_database;

#Create MySQL user:
CREATE USER newuser@'localhost' IDENTIFIED BY 'newpassword';

#User permissions:
GRANT SELECT ON new_database.* TO newuser@'localhost';
GRANT INSERT,UPDATE,DELETE ON new_database.genebaskets TO newuser@'localhost';
GRANT INSERT,UPDATE,DELETE ON new_database.defaultgenebaskets TO newuser@'localhost';
```
```newuser, newpassword and new_database``` will be used in plugins/settings.php similar to following example.
```php
$db_species_array=array("new_database"=>"new genome",...
$db_species_color_array=array("new_database"=>"#86c0a6",....
$db_url=  array ('genelist'=>'mysqli://newuser:newpassword@localhost/'.$selected_database); 
```
**Loading tables**

Following database diagram shows the initial genie tables which are compatible with default GenIECMS tools(GeneList, gene information pages, autocomlete search and BLAST). You can [download](https://raw.githubusercontent.com/irusri/GenIECMS/master/scripts/genie_db.sql) and load tables into the newly created database using following commands.
```shell
git show HEAD~1:scripts/genie_db.sql > genie_db.sql
mysql -u newuser -p newpassword new_database < genie_db.sql
```
**Please read the plugins/genelist to load customize datasets into the GenIE-CMS.**

[![GenIE Database Design](https://raw.githubusercontent.com/irusri/GenIECMS/master/docs/images/GenIE-CMS_V4.png "GenIE Database Design")](https://raw.githubusercontent.com/irusri/GenIECMS/master/docs/images/GenIE-CMS_V4.png)


-------------------------
Configuring genome database
-------------------------

All configuration settings for GenIECMS will be available in ```/GenIECMS/plugins/settings.php``` file. You need to update ```/GenIECMS/plugins/settings.php``` file with your available details. You can find everything about the integration plugins and how to load data in the plugins section.

-------------------------
Plugins/Modules
-------------------------

Analysis, expression or genomic tools can be integreated into a CMS as an external plugin. Comprehensive plugin development guidelines can be found under the plugins section. GenIE-CMS will contain JBrowse, GeneList, gene information pages and BLAST as standard default plugins. All additional tools(exImage, exNet, Enrichment) developed as part of other sub projects will be integrated as en external plugins to the GenIE-CMS. 


