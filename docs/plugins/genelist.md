
GeneList
=====================

**Overview**

GeneList is the heart of the GenIE-CMS; this will be the entry point of many of the tools and workflows. Foundation to entire CMS database has been designed based on GeneList tables. Tables that are started with gene_ or transcript_  prefixes are considered as GeneList tables. GeneList tables are comprised of two types of tables according to our vocabulary; the first one is primary tables and the second one is annotation tables. transcript_info and gene_info tables are considered as primary tables and rest of the GeneList tables are known as annotation tables.

[![GeneList tables](https://github.com/irusri/GenIECMS/blob/master/docs/images/GeneList_v4.png?raw=true "GeneList tables")](https://raw.githubusercontent.com/irusri/GenIECMS/master/docs/images/GeneList_v4.png)

**Primary tables**

There are only two primary tables(transcript_info and gene_info) in GenIECMS database. Primary tables keep basic gene and transcript information. Since the smallest data unit is based on transcript ids or gene ids, all primary tables are used transcript_i/gene_i as a primary key.

Loading data into the primary tables can be easily accomplished using dedicated scripts listed on GenIECMS/scripts folder. First, we need to find corresponding GFF3 and FASTA files related to the species that we are going to load into the GenIE-CMS.

**Creating Primary tables**
```shell
#Create transcript_info table
CREATE TABLE `transcript_info` (
  `transcript_i` mediumint(16) unsigned NOT NULL AUTO_INCREMENT,
  `transcript_id` varchar(60) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `transcript_start` int(16) unsigned DEFAULT NULL,
  `transcript_end` int(16) unsigned DEFAULT NULL,
  `gene_id` varchar(60) DEFAULT NULL,
  `chromosome_name` varchar(20) DEFAULT NULL,
  `description` varchar(1000) DEFAULT NULL,
  `gene_i` mediumint(16) unsigned DEFAULT NULL,
  PRIMARY KEY (`transcript_i`),
  KEY `transcript_id` (`transcript_id`)
)
#Describe transcript_info table
mysql> explain transcript_info;
+------------------+------------------------+------+-----+---------+----------------+
| Field            | Type                   | Null | Key | Default | Extra          |
+------------------+------------------------+------+-----+---------+----------------+
| transcript_i     | mediumint(16) unsigned | NO   | PRI | NULL    | auto_increment |
| transcript_id    | varchar(60)            | NO   | MUL |         |                |
| transcript_start | int(16) unsigned       | YES  |     | NULL    |                |
| transcript_end   | int(16) unsigned       | YES  |     | NULL    |                |
| gene_id          | varchar(60)            | YES  |     | NULL    |                |
| chromosome_name  | varchar(20)            | YES  |     | NULL    |                |
| description      | varchar(1000)          | YES  |     | NULL    |                |
| gene_i           | mediumint(16) unsigned | YES  |     | NULL    |                |
+------------------+------------------------+------+-----+---------+----------------+
10 rows in set (0.00 sec)
#Create gene_info table
CREATE TABLE `gene_info` (
  `gene_i` mediumint(16) unsigned NOT NULL AUTO_INCREMENT,
  `gene_id` varchar(60) CHARACTER SET utf8 NOT NULL,
  `description` varchar(1000) DEFAULT NULL,
  `chromosome_name` varchar(20) DEFAULT NULL,
  `strand` varchar(1) DEFAULT NULL,
  `gene_start` int(16) unsigned DEFAULT NULL,
  `gene_end` int(16) unsigned DEFAULT NULL,
  `peptide_name` varchar(60) DEFAULT NULL,
  PRIMARY KEY (`gene_i`),
  UNIQUE KEY `gene_id` (`gene_id`)
) ;
#Describe gene_info table
mysql> explain  gene_info;
+-----------------+------------------------+------+-----+---------+----------------+
| Field           | Type                   | Null | Key | Default | Extra          |
+-----------------+------------------------+------+-----+---------+----------------+
| gene_i          | mediumint(16) unsigned | NO   | PRI | NULL    | auto_increment |
| gene_id         | varchar(60)            | NO   | UNI | NULL    |                |
| description     | varchar(1000)          | YES  |     | NULL    |                |
| chromosome_name | varchar(20)            | YES  |     | NULL    |                |
| strand          | varchar(1)             | YES  |     | NULL    |                |
| gene_start      | int(16) unsigned       | YES  |     | NULL    |                |
| gene_end        | int(16) unsigned       | YES  |     | NULL    |                |
| peptide_name    | varchar(60)            | YES  |     | NULL    |                |
+-----------------+------------------------+------+-----+---------+----------------+
9 rows in set (0.00 sec)
#Adding indeices to transcript_info and gene_info tables is important when we update and select tables.
mysql> ALTER TABLE transcript_info ADD INDEX `transcript_id` (`transcript_id`)
mysql> ALTER TABLE gene_info ADD INDEX `gene_id` (`gene_id`)

```
The following example will show you how to load basic information into the primary tables. 

**Loading data into Primary tables**
```shell
#head  input/Potra01-gene-mRNA-wo-intron.gff3
Potra000001	leafV2	gene	9066	10255	.	-	.	ID=Potra000001g00001;Name=Potra000001g00001;potri=Potri.004G180000,Potri.004G180200
Potra000001	leafV2	mRNA	9066	10255	.	-	.	ID=Potra000001g00001.1;Parent=Potra000001g00001;Name=Potra000001g00001;cdsMD5=71c5f03f2dd2ad2e0e00b15ebe21b14c;primary=TRUE
Potra000001	leafV2	three_prime_UTR	9066	9291	.	-	.	ID=Potra000001g00001.1.3pUTR1;Parent=Potra000001g00001.1;Name=Potra000001g00001.1
Potra000001	leafV2	exon	9066	9845	.	-	.	ID=Potra000001g00001.1.exon2;Parent=Potra000001g00001.1;Name=Potra000001g00001.1
Potra000001	leafV2	CDS	9292	9845	.	-	2	ID=Potra000001g00001.1.cds2;Parent=Potra000001g00001.1;Name=Potra000001g00001.1
Potra000001	leafV2	CDS	10113	10236	.	-	0	ID=Potra000001g00001.1.cds1;Parent=Potra000001g00001.1;Name=Potra000001g00001.1
Potra000001	leafV2	exon	10113	10255	.	-	.	ID=Potra000001g00001.1.exon1;Parent=Potra000001g00001.1;Name=Potra000001g00001.1
Potra000001	leafV2	five_prime_UTR	10237	10255	.	-	.	ID=Potra000001g00001.1.5pUTR1;Parent=Potra000001g00001.1;Name=Potra000001g00001.1
Potra000001	leafV2	gene	13567	14931	.	+	.	ID=Potra000001g00002;Name=Potra000001g00002;potri=Potri.004G179800,Potri.004G179900,Potri.004G180100
Potra000001	leafV2	mRNA	13567	14931	.	+	.	ID=Potra000001g00002.1;Parent=Potra000001g00002;Name=Potra000001g00002;cdsMD5=df49ed7856591c4a62d602fef61c7e37;primary=TRUE

#Use GFF3 file and generate source input file to load into gene_info mysql table
awk -F"\t" '/gene/{split($9,a,"ID=");split(a[2],b,";");print b[1]"\t"$1"\t"$4"\t"$5"\t"$7}' input/Potra01-gene-mRNA-wo-intron.gff3 > input/gene_info.txt

#Load above generated source file into gene_info table
./load_data.sh gene_info gene_info.txt

#Use GFF3 and generate source input file to load into transcript_info mysql table
awk -F"\t" '/mRNA/{split($9,a,"ID=");split(a[2],b,";");split(b[1],c,".");print b[1]"\t"c[1]"\t"$1"\t"$4"\t"$5"\t"$7}' input/Potra01-gene-mRNA-wo-intron.gff3 > input/transcript_info.txt

#Load previously generated source file into transcript_info table
./load_data.sh transcript_info transcript_info.txt

#Load sequence coloring table
./sequence_coloring.sh input/Potra01-gene-mRNA-wo-intron.gff3

#Load gene description
./update_descriptions.sh gene_info input/Potra01.1_gene_Description.tsv

#Load transcript description
./update_descriptions.sh transcript_info input/Potra01.1_transcript_Description.tsv
```


**Annotation tables**

Whenever a user needs to integrate new annotation field into the GeneList, it is a possible to create a new table which is known as annotation table. The user can create as many annotation tables depend on their requirements.

Loading data into the annotation tables can be easily done using corresponding scripts listed on GenIECMS/scripts folder. First, we need to create the source file to fill the annotation table. The source file should contain two fields. The first field should be either a gene_id or transcript_id and the other fields should be the annotation.

```shell
#Load Annotations
#Let's assume, if we have Best BLAST atg Ids which are corresponding to Poplar ids. Results file will look like following example.

Potra000001g00001.1 AT5G39130.1
Potra000001g00002.1 AT5G39130.1
Potra000002g00003.1 AT4G21215.2
Potra000002g00005.1 AT4G21200.1 ATGA2OX8,GA2OX8
Potra000002g00005.2 AT4G21200.1 ATGA2OX8,GA2OX8
Potra000002g00005.3 AT4G21200.1 ATGA2OX8,GA2OX8
Potra000002g00005.4 AT4G21200.1 ATGA2OX8,GA2OX8
Potra000002g00005.5 AT4G21200.1 ATGA2OX8,GA2OX8
Potra000002g00006.1 AT1G61770.1
Potra000002g00006.2 AT1G61770.1

#We will load above file into following table.
#mysql> explain transcript_atg;
+-----------------+------------------------+------+-----+---------+-------+
| Field           | Type                   | Null | Key | Default | Extra |
+-----------------+------------------------+------+-----+---------+-------+
| transcript_id   | varchar(255)           | NO   | PRI | NULL    |       |
| atg_id          | varchar(24)            | NO   | MUL | NULL    |       |
| atg_description | varchar(255)           | YES  |     | NULL    |       |
| transcript_i    | mediumint(20) unsigned | NO   | PRI | NULL    |       |
+-----------------+------------------------+------+-----+---------+-------+
4 rows in set (0.00 sec)

./load_data.sh transcript_atg input/potra_genelist_atg.txt transcript_id
./update_transcript_i.sh transcript_atg

#Finally update the gene_i
update_gene_i.sh

#Following script will update the gene_i in gene_[go/pfam/kegg] tables
update_annotation_gene_i.sh  gene_[go/pfam/kegg]
```

**Installation**

1. Download the genelist.zip file and unzip into plugins directory.
2. Edit database details in services/settings.php file.

**Usage**

Navigate to `http://[your server name]/GenIECMS/genelist`

