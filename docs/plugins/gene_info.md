Gene Information Pages
=====================

**Installation**

1. Download the gene.zip file and unzip into plugins directory.
2. Edit database details in services/settings.php file.
3. Edit the conf.json file, if needed to display sequence information inside the gene pages.

**Usage**

Navigate to `http://[your server name]/genie/gene?id=[gene id]` or `http://[your server name]/genie/transcript?id=[transcript id]`

**Sequence information**
Sequences will be displayed under the sequence tab once we configure the config.json file. 

**Sequence coloring**

Following script will be used to load genome gff3 file into corresponding sequence coloring table(sequence_color) in GenIE database. This feature will be shaded the genomic,transcriptomic and cds sequence regions in gene information pages.

```shell
#!/bin/bash
#get the gene.gff3 file and loaded into database table calles sequence_color
#Usage: sh sequence_color.sh /data/Egrandis_297_v2.0.gene.gff3

awk '/mRNA/{split($2,a,"=");sub(/ID=./,a[2]";");print $1;next}/gene/{;next}{sub(/ID=./,a[2]";");print $1}' FS=\; OFS=\; $1 | awk '!/#/{print $9"\t"$1"\t"$3"\t"$4"\t"$5}' > tmp &&
sed -i 's/five_prime_UTR/5UTR/' tmp && sed -i 's/three_prime_UTR/3UTR/' tmp  &&
/usr/bin/mysql --host=localhost --user=[user] --password=[pass] --local_infile=1 --database=egrandis<<EOFMYSQL
TRUNCATE TABLE  sequence_color;
LOAD DATA LOCAL INFILE "tmp" INTO TABLE sequence_color fields terminated by '\t' LINES TERMINATED BY '\n' ignore 0 lines;
EOFMYSQL
rm tmp
``

