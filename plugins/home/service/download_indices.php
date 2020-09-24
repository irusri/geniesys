<?php

ini_set('memory_limit', '-1');
ini_set('max_execution_time', 3000);

download_indices();
function download_indices(){
    $url="ftp://plantgenie.org/Data/AtGenIE/Arabidopsis_thaliana/TAIR10/Indexes/BLAST/artha.tar.gz";
    $filepath="/app/geniesys/plugins/home/service/upload/artha.tar.gz";
    $targetFile = fopen( $filepath, 'w' );
    $ch = curl_init( $url );
    curl_setopt($ch, CURLOPT_HEADER, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_BINARYTRANSFER, 1);
    curl_setopt( $ch, CURLOPT_FILE, $targetFile );
    curl_exec( $ch );
    fclose( $targetFile );
    exec("tar -zxvf $filepath -C upload");
    echo filesize($filepath);
    //return (filesize($filepath) > 0)? true : false;
}




?>