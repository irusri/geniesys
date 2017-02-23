Getting Started
=============


------------
What is GenIECMS?
------------

The Genome Integrative Explorer Content Management System (GenIE-CMS) is dedicative in-house CMS to facilitate external groups in setting up their own web resource for searching, visualizing, editing, sharing and reproducing their genomic and transcriptomic data while using project raw data(gff3,fasta,fatsq) as an input.

GenIE-CMS will support cutting-edge genomic science, providing easily accessible, reproducible, and shareable science. The increasingly large size of many datasets is a particularly challenging aspect of current and future genomics based research; it is often difficult to move large datasets between servers due to constraints of time and finance. It is also important to keep the experimental datasets private among the group members until the project goals are accomplished or until after publication. In other words, it must provide a high level of security to ensure that the genomic web resource remains private without requiring the moving of data to unknown remote servers. Therefore, a locally hosted GenIE-CMS installation represents a more secure, less expensive and time consuming resource to implement.

In Addition, Researchers who are not specialized in bioinformatics or have limited computers skills are not currently able to gain maximal insight from the biological data typically produced by genomics projects. In order to overcome this limitation, GenIE-CMS will provide an ideal gateway with simple graphical user interfaces to those who have limited skills in bioinformatics.

Web resources such as Phytozome :cite:t:`goodstein_phytozome:2012`, iPlant( Goff. et al.,2011), TAIR (Rhee et al., 2003) and PLAZA (Proost et al., 2011) help users to search and navigate through different genomes . These collections of tools and services have been sources of inspiration to be and have contributed my desire to develop the GenIE-CMS as well as, and importantly, developing an understanding of their limitations to end users. None of these resources allow users to easily setup their own web resource without submitting their data to the resource developers and making them publicly available.

.. bibliography:: references.bibtex

------------------
GenIECMS's folder structure
------------------
```
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
Configuring genome database
-------------------------

You need to rename ```/GenIECMS/plugins/settings_copy.php``` into ```/GenIECMS/plugins/settings_copy.php```. All configuration settings for GenIECMS will be available in ```/GenIECMS/plugins/settings.php``` file. You can find everything about the available configuration options and how to set them in the configuration section.

-------------------------
Database design
-------------------------

![GenIE Database](https://github.com/irusri/GenIECMS/blob/master/docs/images/GenIE_DB.png?raw=true "GenIE Database")


