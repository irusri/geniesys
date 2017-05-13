#!/bin/bash
#sequence_color.sh
#get the gene.gff3 file and loaded into database sequence_color table.
#Usage: sh sequence_color.sh /mnt/spruce/www/demo/geniecms/data/Egrandis_297_v2.0.gene.gff3

#Include settings file
. "$(dirname "$0")"/settings.ini

# if less than two arguments supplied, display  error message
        if [  $# -le 0 ]
        then
                start='\033[0;33m'
                start_0='\033[0;33m'
                start_2='\033[0;31m'
                end='\033[0m'
                echo  "\nUsage:\n$0 ${start}[file_name]${end}\nEx: ${start_2}sh sequence_color.sh gene.gff3${end}
\nWhat it does?\n${start_0}This script will read input gff3 fil[file_name] and load feature coordinates to sequence_color table.${end}\n"
                exit 1
        fi

awk '/mRNA/{split($2,a,"=");sub(/ID=./,a[2]";");print $1;next}/gene/{;next}{sub(/ID=./,a[2]";");print $1}' FS=\; OFS=\; $1 | awk '!/#/{print $9"\t"$1"\t"$3"\t"$4"\t"$5}' > tmp &&
sed -i 's/five_prime_UTR/5UTR/' tmp && sed -i 's/three_prime_UTR/3UTR/' tmp  &&
/usr/bin/mysql --host=${HOST} -u ${DB_USER} -p${DB_PASS} --local_infile=1 --database=${DB}<<EOFMYSQL
TRUNCATE TABLE  sequence_color;
LOAD DATA LOCAL INFILE "tmp" INTO TABLE sequence_color fields terminated by '\t' LINES TERMINATED BY '\n' ignore 0 lines;
EOFMYSQL
rm tmp
