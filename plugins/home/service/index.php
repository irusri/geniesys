<?php
$key=trim($_POST['key']);
$file_name=trim($_POST['file_name']);

$host=trim($_POST['host']);
$username=trim($_POST['username']);
$password=trim($_POST['password']);
$database=trim($_POST['database']);
$operation=trim($_POST['operation']);

$host="localhost";
$username="root";
$password="root";
$operation="check";


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

/*
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
*/ 
//exec("/Applications/MAMP/Library/bin/mysql", $ret);
//printf("Server version: %s\n", $mysqli->server_info);
//echo json_encode($ret)."<br>";
$path=getcwd()."/".$file_name;
echo "/Applications/MAMP/Library/bin/mysql --host=$host -u $username -p$password $database < $path";
exec("/Applications/MAMP/Library/bin/mysql --host=$host -u $username -p$password $database < $path",$output);

/*
$path="Athaliana_167.sql";
$sql = file_get_contents($path);
echo $host, $username, $password, $database."<br>";

$mysqli = new mysqli($host, $username, $password, $database);
if (mysqli_connect_errno()) { 
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}


if ($mysqli->multi_query($sql)) {
    echo "success";
} else {
   echo $mysqli->error;
}*/


//exec("rm -r $file_name");

?>