<?php
$key=trim($_POST['key']);
$file_name=trim($_POST['file_name']);

$host=trim($_POST['host']);
$username=trim($_POST['username']);
$password=trim($_POST['password']);
$database=trim($_POST['database']);
$operation=trim($_POST['operation']);


$url="http://build.plantgenie.org/tmp/".$key."/".$file_name;

$targetFile = fopen( $file_name, 'w' );

$ch = curl_init( $url );
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt( $ch, CURLOPT_NOPROGRESS, false );
curl_setopt( $ch, CURLOPT_PROGRESSFUNCTION, 'progressCallback' );
curl_setopt( $ch, CURLOPT_FILE, $targetFile );
curl_exec( $ch );
fclose( $targetFile );

function progressCallback( $download_size, $downloaded_size, $upload_size, $uploaded_size )
{
    static $previousProgress = 0;
    
    if ( $download_size == 0 )
        $progress = 0;
    else
        $progress = round( $downloaded_size * 100 / $download_size );
    
    if ( $progress > $previousProgress)
    {
        $previousProgress = $progress;
        //echo $progress;
        
    }
}

$path=getcwd()."/".$file_name;
/*exec("/Applications/MAMP/Library/bin/mysql --host=$host -u $username -p$password $database < $path",$output);*/

$conn = new mysqli($host, $username, $password, $database);
$conn->query( 'SET @@global.max_allowed_packet = ' . 128 * 1024 * 1024 );
//$maxp2 = $conn->query( 'SELECT @@global.max_allowed_packet' )->fetch_array();
$sql = file_get_contents($path);
if (mysqli_multi_query($conn, $sql)) {
    do {
        /* store first result set */
        if ($result = mysqli_store_result($conn)) {
            //do nothing since there's nothing to handle
            mysqli_free_result($result);
        }
        /* print divider */
        if (mysqli_more_results($conn)) {
            //I just kept this since it seems useful
            //try removing and see for yourself
        }
    } while (mysqli_next_result($conn));
 }

#User permissions:
$conn->query("CREATE USER IF NOT EXISTS geniecmsuser@'".$host."' IDENTIFIED BY 'geniepass'; ");
$conn->query("GRANT SELECT ON ".$database.".* TO geniecmsuser@'".$host."';");
$conn->query("GRANT INSERT,UPDATE,DELETE ON ".$database.".genebaskets TO geniecmsuser@'".$host."';");
$conn->query("GRANT INSERT,UPDATE,DELETE ON ".$database.".defaultgenebaskets TO geniecmsuser@'".$host."';");
 exec("rm -r $file_name");

?>