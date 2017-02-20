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
                echo  "\nUsage:\n$0 ${start}[gene_info/transcript_info] [file_name]${end}\nEx: ${start_2}sh update_descriptions.sh transcript_info/gene_info pot$
                exit 1
        fi

table_name=$(echo $1 | awk '{split($0,a,"_");print a[1]}');
tmp_field_name=$table_name"_id"
/usr/bin/mysql --host=localhost --user=$DB_USER --password=$DB_PASS --local_infile=1 --database=$DB<<EOFMYSQL
CREATE TEMPORARY TABLE tmp_tb(gene_name VARCHAR(255),annotation VARCHAR(255));
load data local infile '$2' replace INTO TABLE tmp_tb fields terminated by '\t' LINES TERMINATED BY '\n' ignore 0 lines;
UPDATE $1 INNER JOIN tmp_tb on tmp_tb.gene_name = $1.$tmp_field_name SET $1.description = tmp_tb.annotation;
DROP TEMPORARY TABLE tmp_tb;
EOFMYSQL
