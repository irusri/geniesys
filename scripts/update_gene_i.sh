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

