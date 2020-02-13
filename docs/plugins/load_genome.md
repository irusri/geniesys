Load novel genome
======================

Here is a quick guide to describe how to load a novel genome into GenIE-Sys database. 

### Download
Let's assume we need to integrate Populus tremula v2.0 genome into GenIE-System. First, we need to download the required files. The latest version of the GFF3 and FASTA files are available on [PlantGenIE FTP](ftp://plantgenie.org/Data/PopGenIE/Populus_tremula/).

```shell
$ curl -O ftp://plantgenie.org/Data/PopGenIE/Populus_tremula/v2.2/gff/Potra02_genes.gff.gz
$ curl -O ftp://plantgenie.org/Data/PopGenIE/Populus_tremula/v2.2/fasta/Potra02_genome.fasta.gz
$ gzip -d Potra02_genes.gff.gz
$ gzip -d Potra02_genome.fasta.gz

$ awk '!/##/' Potra02_genes.gff  |head
chr1	maker	gene	8865	11259	.	-	.	ID=Potra2n1c1;Name=Potra2n1c1
chr1	maker	mRNA	8865	10802	.	-	.	ID=Potra2n1c1.3;Parent=Potra2n1c1;Name=Potra2n1c1.3;_AED=0.39;_eAED=0.37;_QI=192|0.66|0.75|1|0|0|4|0|115
chr1	maker	CDS	8865	9054	.	-	1	ID=Potra2n1c1.3:cds;Parent=Potra2n1c1.3
chr1	maker	CDS	9487	9559	.	-	2	ID=Potra2n1c1.3:cds;Parent=Potra2n1c1.3
chr1	maker	CDS	9669	9753	.	-	0	ID=Potra2n1c1.3:cds;Parent=Potra2n1c1.3
chr1	maker	exon	9669	9764	.	-	.	ID=Potra2n1c1.3:exon:300;Parent=Potra2n1c1.3
chr1	maker	five_prime_UTR	9754	9764	.	-	.	ID=Potra2n1c1.3:five_prime_utr;Parent=Potra2n1c1.3
chr1	maker	exon	10622	10802	.	-	.	ID=Potra2n1c1.3:exon:299;Parent=Potra2n1c1.3
chr1	maker	five_prime_UTR	10622	10802	.	-	.	ID=Potra2n1c1.3:five_prime_utr;Parent=Potra2n1c1.3
chr1	maker	mRNA	8865	11259	.	-	.	ID=Potra2n1c1.1;Parent=Potra2n1c1;Name=Potra2n1c1.1;_AED=0.22;_eAED=0.21;_QI=896|0.66|0.75|1|0|0|4|0|115

$ head Potra02_genome.fasta
>chr1
AGAGAGCTCTGTGGGTCATTACTGTCACAACTCCTAGCCAGCTTGAATAT
TCCATATAGCACATATCCTGGATGGGAAAGTTTGGTTAATGTGTGCTATT
CTTGCTCGCCTTCAACACGATTATTTCGTTCATACCACAAGAAATAAACA
GTAGTGGATAGTAGAAGGCGAGCTAGCATGTGATCACTGTTATTCTTCTT
CGTGTAGTGAGTGACTGACCAATGAAGCAATTGTGTCCACGGTTTGCATG
GCCAATAATGGTTGGCTCTGCGACAAATGGACTTCCAAACCAAGCTGGTG
TAACTGCATTCAAAAAAGAGGTGTTCATATGTTTCCATGTAAATTCCATA
TAGTATGCAAGTTGTATCTGTGACTCCTCCATGCAATCTATCCATCGTTC
TTAGTCTACCAAGGCTGGCTAACCAGAGTATAAATGAGTGACGAGGGATA
```

### Parse genome
Now we need to parse GFF3 and FASTA files into required formats. There are two primary tables(transcript_info and gene_info) in the database.
```shell
## generate file for gene_info table
awk '/gene/{split($9,a,"ID=");split(a[2],b,";");print b[1],$1,$4,$5,$7}' FS='\t' OFS='\t' Potra02_genes.gff > gene_info.txt
$ head gene_info.txt
Potra2n1c1	chr1	8865	11259	-
Potra2n1c2	chr1	21121	21603	+
Potra2n1c3	chr1	22295	24697	-
Potra2n1c4	chr1	30731	32811	+
Potra2n1c5	chr1	33508	33833	+
Potra2n1c6	chr1	50823	54726	-
Potra2n1c7	chr1	50901	51116	+
Potra2n1c8	chr1	54928	62450	-
Potra2n1c9	chr1	69471	73884	-
Potra2n1c10	chr1	74717	75583	+

## create file for transcript_info table
awk 'BEGIN{ OFS = "\t"; }$3~/gene/{g=$4"\t"$5}$3~/RNA$/{split($9,a,/[;=]/);for(i=1;i in a;i+=2)k[a[i]]=a[i+1]; print k["Name"], k["Parent"], "desc", $1, $7, g, "PAC", "PEP", $4,$5}' Potra02_genes.gff > transcript_info.txt
$ head transcript_info.txt
Potra2n1c1.3	Potra2n1c1	desc	chr1	-	8865	11259	PAC	PEP	8865	10802
Potra2n1c1.1	Potra2n1c1	desc	chr1	-	8865	11259	PAC	PEP	8865	11259
Potra2n1c1.2	Potra2n1c1	desc	chr1	-	8865	11259	PAC	PEP	8865	11259
Potra2n1c2.1	Potra2n1c2	desc	chr1	+	21121	21603	PAC	PEP	21121	21603
Potra2n1c3.1	Potra2n1c3	desc	chr1	-	22295	24697	PAC	PEP	22295	24697
Potra2n1c4.1	Potra2n1c4	desc	chr1	+	30731	32811	PAC	PEP	30731	32811
Potra2n1c5.1	Potra2n1c5	desc	chr1	+	33508	33833	PAC	PEP	33508	33833
Potra2n1c6.1	Potra2n1c6	desc	chr1	-	50823	54726	PAC	PEP	50823	54726
Potra2n1c7.1	Potra2n1c7	desc	chr1	+	50901	51116	PAC	PEP	50901	51116
Potra2n1c8.3	Potra2n1c8	desc	chr1	-	54928	62450	PAC	PEP	54928	61609
```

### Create a database

Now we need to create a database. To do this, you need a MySQL username and password. If you use the MAMP installation default username and password would be `root`.
```shell
## Download all required scripts and dump database
$ git clone https://github.com/irusri/scripts.git
## Create database for default root user and root password
$ mysql -u root -proot
mysql> create database my_genie_sys_database;
Query OK, 1 row affected (0.01 sec)
mysql> use my_genie_sys_database;
Database changed
mysql> source scripts/dump.sql;
```

### Loading to primary tables

Now we need to load above two files(gene_info.txt and transcript_info.txt) into the newly created database. There is a script(`load_data.sh`) to do this. We can download the script and enter the correct `username, password and database` information to `DB_USER, DB_PASS and DB` parameters respectively.

```shell
$ nano scripts/load_data.sh
#load_data.sh script
#!/bin/bash
#load_data.sh
#USAGE: sh load_data.sh [table_name] [filename]
#sh load_data.sh transcript_info_x /tmp/transcript_info.tsv

DB_USER='root' #'your_db_username'
DB_PASS='root' #'your_password'
DB='my_genie_sys_database' #'database_name'

mysql  --host=localhost --user=$DB_USER --password=$DB_PASS --local_infile=1 --database=$DB <<EOFMYSQL
TRUNCATE TABLE $1;
ALTER TABLE $1 AUTO_INCREMENT = 1;
load data local infile '$2' ignore INTO TABLE $1 CHARACTER SET UTF8 fields terminated by '\t' LINES TERMINATED BY '\n' ignore 0 lines;
EOFMYSQL
```
Run following commands to load  `gene_info.txt` and `transcript_info.txt` into respective tables.
```shell
#Load above generated source file into gene_info table
sh scripts/load_data.sh gene_info gene_info.txt

#Load previously generated source file into transcript_info table
sh scripts/load_data.sh transcript_info transcript_info.txt

```
Now we need to update the `gene_i` parameter in `transcript_info` table. There is a script(`update_gene_i.sh`) in the scripts directory, we just need to enter the correct `username, password and database` information to `DB_USER, DB_PASS and DB` parameters respectively as we did in previous step.

```shell
$ nano scripts/update_gene_i.sh
#update_gene_i.sh script
#!/bin/bash
#update_gene_i.sh

DB_USER='root' #'your_db_username'
DB_PASS='root' #'your_password'
DB='my_genie_sys_database' #'database_name'

#USAGE: sh update_gene_i.sh

mysql --host=localhost --user=$DB_USER --password=$DB_PASS --local_infile=1 --database=$DB <<EOFMYSQL
create temporary table add_gene_i(gene_i MEDIUMINT NOT NULL AUTO_INCREMENT PRIMARY KEY, genename VARCHAR(40));
ALTER TABLE add_gene_i AUTO_INCREMENT = 1;
INSERT INTO add_gene_i(genename) select DISTINCT(gene_id) from transcript_info;
UPDATE transcript_info INNER join add_gene_i ON add_gene_i.genename = transcript_info.gene_id SET transcript_info.gene_i = add_gene_i.gene_i;
drop temporary table add_gene_i;
EOFMYSQL

```

Let's run the following command to update `gene_i` in `transcript_info` table.
```shell
#Finally update the gene_i in transcript_info table using update_gene_i.sh.
sh scripts/update_gene_i.sh
```

If above script takes time please try following command on MySQL. This will update the `gene_i` column in `transcript_info` table.

```shell
$ nano scripts/update_gene_i.sh
#update_gene_i_dev.sh script
#!/bin/bash
#update_gene_i_dev.sh

DB_USER='root' #'your_db_username'
DB_PASS='root' #'your_password'
DB='my_genie_sys_database' #'database_name'

#USAGE: sh update_gene_i_dev.sh

mysql --host=localhost --user=$DB_USER --password=$DB_PASS --local_infile=1 --database=$DB <<EOFMYSQL
update transcript_info,gene_info set transcript_info.gene_i=gene_info.gene_i where gene_info.gene_id=transcript_info.gene_id;
EOFMYSQL

```
Run following command to execute the above script(`update_gene_i_dev.sh`) 
```shell
sh scripts/update_gene_i_dev.sh
```
Great! We have loaded transcript and gene infortmation properly into the database. Now can we load additional information. For example; description to the `transcript_info` table.

```shell
$ curl -O ftp://plantgenie.org/Data/PopGenIE/Populus_tremula/v2.2/annotation/blast2go/Potra22_blast2go_description.txt
$ head Potra22_blast2go_description.txt
Potra2n765s36715.1	UniRef90_B9GWJ3F-box domain-containing protein n=2 Tax=Populus TaxID=3689 RepID=B9GWJ3_POPTR
Potra2n765s36713.1	Populus trichocarpa uncharacterized LOC112326797 (LOC112326797), ncRNA
Potra2n765s36713.2	Populus trichocarpa uncharacterized LOC112326797 (LOC112326797), ncRNA
Potra2n765s36714.1	UniRef90_A0A2K2BA33FAD-binding PCMH-type domain-containing protein n=40 Tax=Populus TaxID=3689 RepID=A0A2K2BA33_POPTR
Potra2n1433s37070.1	UniRef90_U7E173Protein kinase domain-containing protein (Fragment) n=1 Tax=Populus trichocarpa TaxID=3694 RepID=U7E173_POPTR
Potra2n581s36023.1	UniRef90_UPI00057ABC08probable LRR receptor-like serine/threonine-protein kinase At4g08850 isoform X1 n=1 Tax=Populus euphratica TaxID=75702 RepID=UPI00057ABC08
Potra2n581s36025.1	UniRef90_UPI00057B3C83probable LRR receptor-like serine/threonine-protein kinase At4g08850 n=1 Tax=Populus euphratica TaxID=75702 RepID=UPI00057B3C83
Potra2n581s36024.1	UniRef90_U5GE99Zeta-carotene desaturase n=10 Tax=fabids TaxID=91835 RepID=U5GE99_POPTR
Potra2n707s36547.1	UniRef90_A0A2K1X8T3AMPKBI domain-containing protein n=5 Tax=Populus TaxID=3689 RepID=A0A2K1X8T3_POPTR
Potra2n409s35556.1	UniRef90_UPI000B5D6D9FE3 ubiquitin-protein ligase SHPRH isoform X3 n=1 Tax=Manihot esculenta TaxID=3983 RepID=UPI000B5D6D9F
```
Here is the script to load `description` into `transcript_info` column.
```shell
#!/bin/bash
#update_description.sh

DB_USER='root' #'your_db_username'
DB_PASS='root' #'your_password'
DB='my_genie_sys_database' #'database_name'

# if less than two arguments supplied, display  error message
        if [  $# -le 0 ]
        then
                start='\033[0;33m'
                start_0='\033[0;33m'
                start_2='\033[0;31m'
                end='\033[0m'
                echo  "\nUsage:\n$0 ${start}[gene_info/transcript_info] [file_name]${end}\nEx: ${start_2}sh update_description.sh transcript_info/gene_info potra_description.tsv${end}\n\nWhat it does?\n${start_0}This script will create a two columns(ids, description) temporary table and load the [file_name] into it.\nThen it will match ids column in temporary table with transcript_ids/gene_ids and update the gene/transcript description.\nFinally delete the temporary table.\n${end}"
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
We just need to run the script to load `description` into `transcript_info` table.
```shell
sh scripts/update_description.sh transcript_info Potra22_blast2go_description.txt
```
### Loading to secondary tables

Secondary table conatins annotation related to the primary tables.
