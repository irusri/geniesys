
GeneList
=====================

**Overview**

GeneList is the heart of the GenIE-CMS; this will be the entry point of many of the tools and workflows. Foundation to entire CMS database has been designed based on GeneList tables. Tables that are started with gene_ or transcript_  prefixes are considered as GeneList tables. GeneList tables are comprised of two types of tables according to our vocabulary; the first one is primary tables and the second one is annotation tables. transcript_info and gene_info tables are considered as primary tables and rest of the GeneList tables are known as annotation tables.


**Primary tables**

There are only two primary tables(transcript_info and gene_info) in GenIECMS database. Primary tables keep basic gene and transcript information. Since the smallest data unit is based on transcript ids, all primary tables are used transcript id as a primary key.

Loading data into the primary tables can be easily accomplished using dedicated scripts listed on GenIECMS/scripts folder. First, we need to find corresponding GFF3 and FASTA files related to the species that we are going to load into the GenIE-CMS.  The following example will show you how to load the basic information into the primary tables. 


**Annotation tables**

Whenever a user needs to integrate new annotation field into the GeneList, it is a possible to create a new table which is known as annotation table. The user can create as many annotation tables depend on their requirements.

Loading data into the annotation tables can be easily done using corresponding scripts listed on GenIECMS/scripts folder. First, we need to create the source file to fill the annotation table. The source file should contain two fields. The first field should be either a gene_id or transcript_id and the other fields should be the annotation.


**Installation**

1. Download the genelist.zip file and unzip into plugins directory.
2. Edit database details in services/settings.php file.

**Usage**

Navigate to `http://[your server name]/GenIECMS/genelist`

