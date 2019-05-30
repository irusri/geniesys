
GeneList
=====================

**Overview**

GeneList is the heart of the GenIE-CMS; this will be the entry point to many of the tools and workflows. Foundation to entire CMS database has been designed based on GeneList tables. Tables that are started with *gene_* or *transcript_* prefixes are considered as GeneList tables. GeneList tables consist of two types of tables according to our vocabulary. The first one is primary tables and the second one is annotation tables. *transcript_info* and *gene_info* tables are considered as primary tables and rest of the GeneList tables are known as annotation tables.

[![](https://github.com/irusri/GenIECMS/blob/master/docs/images/GeneList_v4.png?raw=true "GeneList tables")](https://raw.githubusercontent.com/irusri/GenIECMS/master/docs/images/GeneList_v4.png)

**Primary tables**

There should only be two primary tables (transcript_info and gene_info) in GenIECMS database. Primary tables keep basic gene and transcript information. Since the smallest data unit is based on transcript ids or gene ids, all primary tables are used *transcript_i/gene_i* as a primary key.

Loading data into the primary tables can be easily accomplished using dedicated scripts listed on GenIECMS/scripts folder. First, we need to find corresponding GFF3 and FASTA files related to the species that we are going to load into the GenIE-CMS.

*Creating Primary tables ! You do not need to create these tables seperately, instead use [this script](https://raw.githubusercontent.com/irusri/scripts/master/dump.sql) to create all database tables at once*
```shell
#Create transcript_info table
CREATE TABLE `transcript_info` (
  `transcript_id` varchar(60) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `chromosome_name` varchar(20) DEFAULT NULL,
  `transcript_start` int(16) unsigned DEFAULT NULL,
  `transcript_end` int(16) unsigned DEFAULT NULL,
  `strand` varchar(2) DEFAULT NULL,
  `gene_id` varchar(60) DEFAULT NULL,
  `description` varchar(1000) DEFAULT NULL,
  `gene_i` mediumint(16) unsigned DEFAULT NULL,
  `transcript_i` mediumint(16) unsigned NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`transcript_i`),
  KEY `transcript_id` (`transcript_id`),
  KEY `gene_id` (`gene_id`)
);
#Describe transcript_info table
mysql> explain transcript_info;
+------------------+------------------------+------+-----+---------+----------------+
| Field            | Type                   | Null | Key | Default | Extra          |
+------------------+------------------------+------+-----+---------+----------------+
| transcript_id    | varchar(60)            | NO   | MUL |         |                |
| chromosome_name  | varchar(20)            | YES  |     | NULL    |                |
| transcript_start | int(16) unsigned       | YES  |     | NULL    |                |
| transcript_end   | int(16) unsigned       | YES  |     | NULL    |                |
| strand           | varchar(2)             | YES  |     | NULL    |                |
| gene_id          | varchar(60)            | YES  | MUL | NULL    |                |
| description      | varchar(1000)          | YES  |     | NULL    |                |
| transcript_i     | mediumint(16) unsigned | NO   | PRI | NULL    | auto_increment |
| gene_i           | mediumint(16) unsigned | YES  |     | NULL    |                |
+------------------+------------------------+------+-----+---------+----------------+
9 rows in set (0.00 sec)
#Create gene_info table
CREATE TABLE `gene_info` (
  `gene_id` varchar(60) CHARACTER SET utf8 NOT NULL,
  `chromosome_name` varchar(20) DEFAULT NULL,
  `gene_start` int(16) unsigned DEFAULT NULL,
  `gene_end` int(16) unsigned DEFAULT NULL,
  `strand` varchar(2) DEFAULT NULL,
  `description` varchar(1000) DEFAULT NULL,
  `peptide_name` varchar(50) DEFAULT NULL,
  `gene_i` mediumint(16) unsigned NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`gene_i`),
  KEY `gene_id` (`gene_id`)
);
#Describe gene_info table
mysql> explain gene_info;
+-----------------+------------------------+------+-----+---------+----------------+
| Field           | Type                   | Null | Key | Default | Extra          |
+-----------------+------------------------+------+-----+---------+----------------+
| gene_id         | varchar(60)            | NO   | MUL | NULL    |                |
| chromosome_name | varchar(20)            | YES  |     | NULL    |                |
| gene_start      | int(16) unsigned       | YES  |     | NULL    |                |
| gene_end        | int(16) unsigned       | YES  |     | NULL    |                |
| strand          | varchar(2)             | YES  |     | NULL    |                |
| description     | varchar(1000)          | YES  |     | NULL    |                |
| peptide_name    | varchar(50)            | YES  |     | NULL    |                |
| gene_i          | mediumint(16) unsigned | NO   | PRI | NULL    | auto_increment |
+-----------------+------------------------+------+-----+---------+----------------+
8 rows in set (0.00 sec)
#Adding indeices to transcript_info and gene_info tables is important when we update and select tables.
mysql> ALTER TABLE transcript_info ADD INDEX `transcript_id` (`transcript_id`)
mysql> ALTER TABLE transcript_info ADD INDEX `gene_id` (`gene_id`)
mysql> ALTER TABLE gene_info ADD INDEX `gene_id` (`gene_id`)

```
The following example will show you how to load basic information into the primary tables. 

*Loading data into Primary tables*
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
awk '/gene/{split($9,a,"ID=");split(a[2],b,";");print b[1],$1,$4,$5,$7}' FS='\t' OFS='\t' input/Potra01-gene-mRNA-wo-intron.gff3 > input/gene_info.txt

#results file(gene_info.txt) looks like following
Potra000001g00001	Potra000001	9066	10255	-
Potra000001g00002	Potra000001	13567	14931	+
Potra000002g00003	Potra000002	8029	9534	+
Potra000002g35060	Potra000002	10226	12730	-
Potra000002g00005	Potra000002	19301	25349	-
Potra000002g00006	Potra000002	33101	36247	+
Potra000002g00007	Potra000002	36609	41740	+
Potra000002g31575	Potra000002	42835	43635	+
Potra000002g31576	Potra000002	52539	53036	+
Potra000002g31577	Potra000002	55010	55465	+

#Use GFF3 and generate source input file to load into transcript_info mysql table
awk '/mRNA/{split($9,a,"ID=");split(a[2],b,";");split(b[1],c,".");print b[1],$1,$4,$5,$7,c[1]}' FS='\t' OFS='\t' input/Potra01-gene-mRNA-wo-intron.gff3 > input/transcript_info.txt

#results file(transcript_info.txt) looks like following
Potra000001g00001.1	Potra000001	9066	10255	-	Potra000001g00001
Potra000001g00002.1	Potra000001	13567	14931	+	Potra000001g00002
Potra000002g00003.1	Potra000002	8029	9534	+	Potra000002g00003
Potra000002g35060.1	Potra000002	10226	12730	-	Potra000002g35060
Potra000002g00005.3	Potra000002	19301	21913	-	Potra000002g00005
Potra000002g00005.2	Potra000002	19301	24937	-	Potra000002g00005
Potra000002g00005.1	Potra000002	19301	25032	-	Potra000002g00005
Potra000002g00005.5	Potra000002	19346	21913	-	Potra000002g00005
Potra000002g00005.4	Potra000002	19346	25349	-	Potra000002g00005
Potra000002g00006.5	Potra000002	33101	35399	+	Potra000002g00006
```
Two files are ready for loading into the primary tables. `load_data.sh` script can be used to load them into the database and `load_data.sh` script can be found inside `GenIECMS/scripts` folder.
```shell
#!/bin/bash
#load_data.sh
#USAGE: sh load_data.sh [table_name] [filename]
#sh load_data.sh transcript_info transcript_info.txt

DB_USER='your_db_username'
DB_PASS='your_password'
DB='database_name'

/usr/bin/mysql --host=localhost --user=$DB_USER --password=$DB_PASS --local_infile=1 --database=$DB <<EOFMYSQL
TRUNCATE TABLE $1;
ALTER TABLE $1 AUTO_INCREMENT = 1;
load data local infile '$2' replace INTO TABLE $1 fields terminated by '\t' LINES TERMINATED BY '\n' ignore 0 lines;
EOFMYSQL
```
Folowing two lines will load `transcript_info.txt` and `gene_info.txt` files into respective tables.
```shell
#Load above generated source file into gene_info table
./load_data.sh gene_info gene_info.txt

#Load previously generated source file into transcript_info table
./load_data.sh transcript_info transcript_info.txt
```
Now we just need to fill the description column in gene_info and transcript_info tables. Therefore, we need files similar to folliwng example. 
```shell
#head potra_transcript_description.txt
Potra000001g00001.1	Germin-like protein subfamily 1 member
Potra000001g00002.1	Germin-like protein
Potra000002g00003.1	uncharacterized protein LOC105113244
Potra000002g35060.1	Pyruvate, phosphate dikinase regulatory
Potra000002g00005.3	Gibberellin 2-beta-dioxygenase
Potra000002g00005.2	Gibberellin 2-beta-dioxygenase
Potra000002g00005.1	Gibberellin 2-beta-dioxygenase
Potra000002g00005.5	Gibberellin 2-beta-dioxygenase
Potra000002g00005.4	Gibberellin 2-beta-dioxygenase
Potra000002g00006.5	DnaJ homolog subfamily

#head potra_gene_description.txt
Potra000001g00001	Germin-like protein subfamily 1 member
Potra000001g00002	Germin-like protein
Potra000002g00003	uncharacterized protein LOC105113244
Potra000002g35060	Pyruvate, phosphate dikinase regulatory
Potra000002g00005	Gibberellin 2-beta-dioxygenase
Potra000002g00006	DnaJ homolog subfamily
Potra000002g00007	Tyrosyl-DNA phosphodiesterase
Potra000002g31575	uncharacterized protein LOC105115090
Potra000002g31576	conserved unknown protein
Potra000002g31577	conserved unknown protein
```
There is a script called `update_descriptions.sh` in `GenIECMS/scripts` folder. The script looks like following.
```shell
#!/bin/bash
#update_descriptions.sh

DB_USER='your_db_username'
DB_PASS='your_password'
DB='database_name'

# if less than two arguments supplied, display  error message
        if [  $# -le 0 ]
        then
                start='\033[0;33m'
                start_0='\033[0;33m'
                start_2='\033[0;31m'
                end='\033[0m'
                echo  "\nUsage:\n$0 ${start}[gene_info/transcript_info] [file_name]${end}\nEx: ${start_2}sh update_descriptions.sh transcript_info/gene_info potra_descriptions.tsv${end}\n\nWhat it does?\n${start_0}This script will create a two columns(ids, descriptions) temporary table and load the [file_name] into it.\nThen it will match ids column in temporary table with transcript_ids/gene_ids and update the gene/transcript descriptions.\nFinally delete the temporary table.\n${end}"
                exit 1
        fi

table_name=$(echo $1 | awk '{split($0,a,"_");print a[1]}');
tmp_field_name=$table_name"_id"
/usr/bin/mysql --host=localhost --user=$DB_USER --password=$DB_PASS --local_infile=1 --database=$DB<<EOFMYSQL
CREATE TEMPORARY TABLE tmp_tb(gene_name VARCHAR(60),annotation VARCHAR(1000));
load data local infile '$2' replace INTO TABLE tmp_tb fields terminated by '\t' LINES TERMINATED BY '\n' ignore 0 lines;
UPDATE $1 INNER JOIN tmp_tb on tmp_tb.gene_name = $1.$tmp_field_name SET $1.description = tmp_tb.annotation;
DROP TEMPORARY TABLE tmp_tb;
EOFMYSQL
```
We can use `update_descriptions.sh` script to load descriptions into gene_info and transcript_info tables. 
```shell
#Load gene description
./update_descriptions.sh gene_info potra_transcript_description.txt

#Load transcript description
./update_descriptions.sh transcript_info potra_gene_description.txt

```
Finally update the `gene_i`in `transcript_info` table using `update_gene_i.sh`.
```shell
#!/bin/bash
#update_gene_i.sh

DB_USER='your_db_username'
DB_PASS='your_password'
DB='database_name'

#USAGE: sh update_gene_i.sh

/usr/bin/mysql --host=localhost --user=$DB_USER --password=$DB_PASS --local_infile=1 --database=$DB <<EOFMYSQL
create temporary table add_gene_i(gene_i MEDIUMINT NOT NULL AUTO_INCREMENT PRIMARY KEY, genename VARCHAR(40));
ALTER TABLE add_gene_i AUTO_INCREMENT = 1;
INSERT INTO add_gene_i(genename) select DISTINCT(gene_id) from transcript_info;
UPDATE transcript_info INNER join add_gene_i ON add_gene_i.genename = transcript_info.gene_id SET transcript_info.gene_i = add_gene_i.gene_i;
drop temporary table add_gene_i;
EOFMYSQL
```
Run following command
```shell
./update_gene_i.sh
```

**Annotation tables**

Whenever a user needs to integrate new annotation field into the GeneList, it is possible to create a new table which is known as annotation table. The user can create as many annotation tables depend on their requirements.

Loading data into the annotation tables can be easily done using corresponding scripts listed on GenIECMS/scripts folder. First, we need to create the source file to fill the annotation table. The source file should contain two fields. The first field should be either a gene_id or transcript_id and the other fields should be the annotation.

*Load data into transcript_[go/pfam/kegg] tables*
```shell
#Let's assume, if we have Best BLAST results similar to following example.
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
```
Now we need to create a MySQL Annotation table to load Best BLAST results.

```shell
#Create transcript_atg table
CREATE TABLE `transcript_atg` (
  `transcript_id` varchar(60) NOT NULL,
  `atg_id` varchar(60) NOT NULL,
  `description` varchar(1000) DEFAULT NULL,
  `transcript_i` mediumint(16) unsigned NOT NULL,
  PRIMARY KEY (`transcript_i`),
  KEY `transcript_id` (`transcript_id`),
  KEY `atg_id` (`atg_id`)
);

#We will load above file into following table.
mysql> explain transcript_atg;
+---------------+------------------------+------+-----+---------+-------+
| Field         | Type                   | Null | Key | Default | Extra |
+---------------+------------------------+------+-----+---------+-------+
| transcript_id | varchar(60)            | NO   | MUL | NULL    |       |
| atg_id        | varchar(60)            | NO   | MUL | NULL    |       |
| description   | varchar(1000)          | YES  |     | NULL    |       |
| transcript_i  | mediumint(16) unsigned | NO   | PRI | NULL    |       |
+---------------+------------------------+------+-----+---------+-------+
4 rows in set (0.00 sec)
```

Previous `load_data.sh` script can be used to load Best BLAST results to `transcript_atg` table.

```shell
./load_data.sh transcript_atg potra_transcript_atg.txt
```

Finally update the `transcript_i` in `transcript_atg` table using following script.

```shell
#!/bin/bash
DB_USER='your_db_username'
DB_PASS='your_password'
DB='database_name'

#USAGE sh update.sh transcript_potri
display_usage() {
        echo  "\nUsage:\n$0 [table_name] \n"
        }

# if less than one arguments supplied, display usage
        if [  $# -le 0 ]
        then
                display_usage
                exit 1
        fi
        
/usr/bin/mysql --host=localhost  --user=$DB_USER --password=$DB_PASS --local_infile=1 --database=$DB <<EOFMYSQL
UPDATE $1 INNER JOIN transcript_info on transcript_info.transcript_id = $1.transcript_id SET $1.transcript_i = transcript_info.transcript_i;
EOFMYSQL
```

Run following command to update `transcript_i`

```shell
./update_transcript_i.sh transcript_atg
```

*Load data into gene_[go/pfam/kegg] tables*

Although it is recommended to have all the annotation are based on transcript IDs, sometimes we may have annotation with gene IDs. Following example will show you how to load gene ID based annotation files into GenIE-CMS database.

*Load data into gene_[go/pfam/kegg] tables*

```powershell
#Let's assume, if we have annotation file similar to following example.
Potra000001g00001   GO:0008565      protein transporter activity
Potra000001g00001   GO:0031204      posttranslational protein targeting to membrane, translocation
Potra000002g00006   GO:0005634      nucleus
Potra000002g00005   GO:0003677      DNA binding
Potra000002g00005   GO:0003824      catalytic activity
Potra000002g00006   GO:0015031      protein transport
Potra000002g00006   GO:0006457      protein folding
Potra000001g00002   GO:0003852      2-isopropylmalate synthase activity
Potra000001g00002   GO:0009098      leucine biosynthetic process
Potra000002g00008   GO:0008312      7S RNA binding
```
As you see in the above example, one gene ID associated with several Gene ontology IDs.  Therfore, we need to format the above results into the right format. Following `parse.py` script can be used. Now we need to create MySQL Annotation table to load GO results.

```python
#!/usr/bin/env python
#parse.py
def parse(file, store):
        f = open(file, 'r')
        dic = {}
        for i in f:
                i = i.strip("\n")
                val = i.split("\t")
                try:
                    if(val[1]!=""):
                        dic[val[0]] = dic[val[0]] + ";"+ val[1]+"-"+val[2]
                except KeyError:
                    if(val[0]!=""):
                        dic[val[0]]=val[1]+"-"+val[2]
        f.close()
        f = open(store, 'w')
        for i in dic.keys():
                string = i+"\t"+dic[i]+"\t0"
                f.write(string+"\n")
        f.close

if __name__=="__main__":
        import sys
        if len(sys.argv) > 1:
                file = sys.argv[1]
                store = sys.argv[2]
                parse(file, store)
        else:
                sys.exit("No input")
```

Then the output will be similar to following.

```powershell
Potra000001g00001	GO:0008565-protein transporter activity;GO:0031204-posttranslational protein targeting to membrane, translocation 0
Potra000001g00002	GO:0003852-2-isopropylmalate synthase activity;GO:0009098-leucine biosynthetic process  0
Potra000002g00005	GO:0003677-DNA binding;GO:0003824-catalytic activity  0
Potra000002g00008	GO:0008312-7S RNA binding 0
Potra000002g00006	GO:0005634-nucleus  0
Potra000002g00006	GO:0015031-protein transport;GO:0006457-protein folding 0
```

Now we need to create a table to load newly generated annotation data.

```shell
#Create gene_go table
CREATE TABLE `gene_go` (
  `gene_id` varchar(60) NOT NULL,
  `go_description` varchar(2000) DEFAULT NULL,
  `gene_i` mediumint(16) unsigned DEFAULT '0',
  PRIMARY KEY (`gene_id`),
  KEY `gene_id` (`gene_id`)
);


#We will load above file into following table.
mysql> explain gene_go;
+----------------+------------------------+------+-----+---------+-------+
| Field          | Type                   | Null | Key | Default | Extra |
+----------------+------------------------+------+-----+---------+-------+
| gene_id        | varchar(60)            | NO   | PRI | NULL    |       |
| go_description | varchar(2000)          | YES  |     | NULL    |       |
| gene_i         | mediumint(16) unsigned | YES  |     | 0       |       |
+----------------+------------------------+------+-----+---------+-------+
3 rows in set (0.00 sec)
```

Previousy used `load_data.sh`  script can be used to load go_gene results to `gene_go` table.

```shell
./load_data.sh gene_go gene_go.txt
```

Finally update the `gene_i` in `gene_go` table using following script.

```shell
#!/bin/bash

DB_USER='your_db_username'
DB_PASS='your_password'
DB='database_name'

#USAGE sh update_annotation_gene_i.sh gene_go
display_usage() {
        echo  "\nUsage:\n$0 [table_name] \n"
        }

# if less than one arguments supplied, display usage
        if [  $# -le 0 ]
        then
                display_usage
                exit 1
        fi

/usr/bin/mysql --host=localhost  --user=$DB_USER --password=$DB_PASS --local_infile=1 --database=$DB <<EOFMYSQL
UPDATE $1 INNER JOIN transcript_info on transcript_info.gene_id = $1.gene_id SET $1.gene_i = transcript_info.gene_i;
EOFMYSQL
```

Run following command to update `gene_i`

```shell
./update_annotation_gene_i.sh gene_go
```
<!--
```shell
#Load sequence coloring table
./sequence_coloring.sh input/Potra01-gene-mRNA-wo-intron.gff3
``` 
-->

**Installation**

1. Download the genelist.zip file and unzip into plugins directory.
2. Edit database details in services/settings.php file.

**Usage**

Navigate to `http://[your server name]/GenIECMS/genelist`

