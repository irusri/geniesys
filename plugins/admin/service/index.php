<?php
$key=trim($_POST['key']);
$file_name=trim($_POST['file_name']);

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
        echo $progress;
        
    }
}
sleep(2);

$host='localhost';
$user='root';
$pass='root';
$new_db_name = explode(".", $file_name)[0];

$conn = mysqli_connect($host, $user, $pass);

if(! $conn ){
   echo 'Connected failure<br>';
}
$sql = "create DATABASE $new_db_name";

if (mysqli_query($conn, $sql)) {
echo "Record created successfully";
} else {
   echo "Error deleting record: " . mysqli_error($conn);
}
mysqli_close($conn);

exec("mysql --host=$host -u $user -p$pass $new_db_name < $file_name",$output);

//exec("rm -r $file_name");

?>