
#!/bin/bash
#update_annotation_gene.sh

#Include settings file
. "$(dirname "$0")"/settings.ini

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

/usr/bin/mysql --host=${HOST} -u ${DB_USER} -p${DB_PASS} --local_infile=1 --database=${DB}<<EOFMYSQL
UPDATE $1 INNER JOIN transcript_info on transcript_info.gene_id = $1.gene_id SET $1.gene_i = transcript_info.gene_i;
EOFMYSQL
