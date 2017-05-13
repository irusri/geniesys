#!/bin/bash
#update_descriptions.sh

#Include settings file
. "$(dirname "$0")"/settings.ini

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
/usr/bin/mysql --host=${HOST} -u ${DB_USER} -p${DB_PASS} --local_infile=1 --database=${DB}<<EOFMYSQL
CREATE TEMPORARY TABLE tmp_tb(gene_name VARCHAR(60),annotation VARCHAR(1000));
load data local infile '$2' replace INTO TABLE tmp_tb fields terminated by '\t' LINES TERMINATED BY '\n' ignore 0 lines;
UPDATE $1 INNER JOIN tmp_tb on tmp_tb.gene_name = $1.$tmp_field_name SET $1.description = tmp_tb.annotation;
DROP TEMPORARY TABLE tmp_tb;
EOFMYSQL
