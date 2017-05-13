#!/bin/bash
#update_transcripts,sh

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

/usr/bin/mysql --defaults-file="$(dirname "$0")"/.mysql.cnf --local_infile=1 <<EOFMYSQL
UPDATE $1 INNER JOIN transcript_info on transcript_info.transcript_id = $1.transcript_id SET $1.transcript_i = transcript_info.transcript_i;
EOFMYSQL
