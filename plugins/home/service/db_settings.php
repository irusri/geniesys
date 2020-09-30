<?php
ini_set('memory_limit', '-1');
ini_set('max_execution_time', 300);

$host = trim($_POST['host']);
$username = trim($_POST['username']);
$password = trim($_POST['password']);
$database = trim($_POST['database']);
$get_action = $_POST['action'];
$get_name = $_POST['name'];

// output json information
function jsonMsg($status, $message, $name = '')
{
    $arr['status'] = $status;
    $arr['message'] = $message;
    $arr['name'] = $name;
    echo json_encode($arr);
}

//Test Connection - check whther the given username and passwords are correct
if ($get_action == "db_name") {
    //Check the settings file for database name
    $settings_file = fopen("../../../genie_files/settings", "r") or die("Unable to open file!");
    $db_name = fgets($settings_file);
    fclose($settings_file);
    ($db_name == false) ? $db_name = "" : $db_name = $db_name;
    //Make a connection
    $conn = mysqli_connect($host, $username, $password);
    // Check connection
    if (!$conn) {
        jsonMsg('error', "Connection failed: " . mysqli_connect_error);
        die("Connection failed: " . mysqli_connect_error);
    } else {
        jsonMsg('success', "Database server connection was established.", $db_name);
    }
}

//Create a new database depending on the given name
if ($get_action == "create_database") {
    //Make a connection
    $link = mysqli_connect($host, $username, $password);
    if (!$link) {
        jsonMsg('error', "Wrong username and or password");
        exit;
    } else {
        if (!mysqli_select_db($link, $database)) {
            $sql = "CREATE DATABASE " . $database;
            // $sql = "CREATE DATABASE ".$database.";GRANT SELECT ON ".$database.".* TO ".$username."@'".$host."';GRANT INSERT,UPDATE,DELETE ON ".$database.".genebaskets TO ".$username."@'".$host."';GRANT INSERT,UPDATE,DELETE ON ".$database.".defaultgenebaskets TO ".$username."@'".$host."';";
            if ($link->query($sql) === true) {
                jsonMsg('success', "<strong>" . $database . "</strong> database was created");
                mysqli_close($link);
                load_sql($host, $username, $password, $database, $get_name);
            } else {
                jsonMsg('error', "Not enough permssion to create <strong>" . $database . "</strong> database");
                mysqli_close($link);
            }
        } else {
            jsonMsg('error', "Database <strong>" . $database . "</strong> already exist");
            mysqli_close($link);
        }
    }

}

//Drop exsisting database
if ($get_action == "drop_database") {
    //Make a connection
    $link = mysqli_connect($host, $username, $password);
    if (!$link) {
        jsonMsg('error', "Wrong username and or password");
        exit;
    } else {
        if (!mysqli_select_db($link, $database)) {
            jsonMsg('error', "Database <strong>" . $database . "</strong> does not exist");
        } else {
            $sql = "DROP DATABASE " . $database;
            $link->query($sql);
            saveSettings("");
            jsonMsg('success', "<strong>" . $database . "</strong> database was deleted");
        }
    }
}

// load MySQL dump file into the database
function load_sql($host, $username, $password, $database, $get_name)
{

    if ($get_name == "dump") {
        $url = "http://build.plantgenie.org/tmp/dump/dump.sql";
        $file_name = "dump.sql";
    } else {
        $url = "http://build.plantgenie.org/tmp/Athaliana_447/Athaliana_447.sql";
        $file_name = "Athaliana_447.sql";
    }
    //$url="http://build.plantgenie.org/tmp/".$key."/".$file_name;
    $targetFile = fopen($file_name, 'w');

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_NOPROGRESS, false);
    curl_setopt($ch, CURLOPT_PROGRESSFUNCTION, 'progressCallback');
    curl_setopt($ch, CURLOPT_FILE, $targetFile);
    curl_exec($ch);
    fclose($targetFile);

    function progressCallback($download_size, $downloaded_size, $upload_size, $uploaded_size)
    {
        static $previousProgress = 0;

        if ($download_size == 0) {
            $progress = 0;
        } else {
            $progress = round($downloaded_size * 100 / $download_size);
        }

        if ($progress > $previousProgress) {
            $previousProgress = $progress;
            //echo $progress;
        }
    }

    $script_path = getcwd() . "/" . $file_name;

    $conn = new mysqli($host, $username, $password, $database);
    $conn->query('SET @@global.max_allowed_packet = ' . 100 * 1024 * 1024);
    //$maxp2 = $conn->query( 'SELECT @@global.max_allowed_packet' )->fetch_array();
    $sql = file_get_contents($script_path);
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

    saveSettings($database);
    #User permissions:
    $conn->query("CREATE USER IF NOT EXISTS geniecmsuser@'" . $host . "' IDENTIFIED BY 'geniepass'; ");
    $conn->query("GRANT ALL ON " . $database . ".* TO geniecmsuser@'" . $host . "';"); //ALL replace with SELECT
    //$conn->query("GRANT INSERT,UPDATE,DELETE ON ".$database.".genebaskets TO geniecmsuser@'".$host."';");
    //$conn->query("GRANT INSERT,UPDATE,DELETE ON ".$database.".defaultgenebaskets TO geniecmsuser@'".$host."';");
    exec("rm -r $file_name");

    if (!file_exists('upload')) {
        mkdir('upload', 0777, true);
    }

}

/*if the settings file exist save the settings*/
function saveSettings($s)
{
    $file = @fopen("../../../genie_files/settings", 'w');
    if (!$file) {
        echo "Error opening settings. Set correct permissions (644) to the settings file.";
        exit;
    }
    fwrite($file, $s);
    fclose($file);
}

//Upload GFF3 file
if ($get_action == "upload_gff3") {
    // CHANGE THE UPLOAD LIMITS
    ini_set('upload_max_filesize', '500M');
    ini_set('post_max_size', '500M');
    ini_set('max_input_time', 10000);
    ini_set('max_execution_time', 10000);

    $arr_file_types = ['image/png', 'image/gif', 'image/jpg', 'image/jpeg'];

    if ($_FILES["file"]["size"] == 0) {
/*     if (!(in_array($_FILES['file']['type'], $arr_file_types))) {*/
        echo "false";
        return;
    }
    move_uploaded_file($_FILES['file']['tmp_name'], 'upload/' . $_FILES['file']['name']);
    exec("awk '$3==\"gene\"{g=$4\" \"$5}$3~/RNA$/{split($9,a,/[;=]/);for(i=1;i in a;i+=2)k[a[i]]=a[i+1]; print k[\"ID\"], k[\"Parent\"], \"desc\", $1, $7, $4, $5, g}' " . 'upload/' . $_FILES['file']['name'] . " >" . 'upload/' . $_FILES['file']['name'] . "_transcript.tsv");
    exec("awk '/gene/{split($9,a,\"ID=\");split(a[2],b,\";\");print b[1],$1,$4,$5}' FS='\t' OFS='\t' " . 'upload/' . $_FILES['file']['name'] . " >" . 'upload/' . $_FILES['file']['name'] . "_gene.tsv");
    load_files('upload/' . $_FILES['file']['name'] . "_gene.tsv", 'gene_info');
}

//Loading tables
function load_files($input_file, $table_name)
{
    //$input_file=getcwd().'/../tmp/'.$folder.'/'.$table_name.'.txt';
    // $database=$source;
    echo $input_file, $table_name;

    //Build the connection
    include dirname(__FILE__) . '/geniesys/plugins/settings.php';
    $private_url = parse_url($db_url['genelist']);
    $conn = new mysqli($private_url['host'], $private_url['user'], $private_url['pass'], str_replace('/', '', $private_url['path']));
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    //Truncate and load table
    $query = <<<eof
TRUNCATE TABLE $table_name;
ALTER TABLE $table_name AUTO_INCREMENT = 1;
load data local infile '$input_file' ignore  INTO TABLE $table_name CHARACTER SET UTF8 fields terminated by '\t' LINES TERMINATED BY '\n' ignore 0 lines;
eof;
    /* execute multi query */
    if (mysqli_multi_query($conn, $query)) {
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
    mysqli_close($conn);
}

$output_dir = "upload/";
if (isset($_FILES["myfile"])) {
    // CHANGE THE UPLOAD LIMITS
    ini_set('upload_max_filesize', '500M');
    ini_set('post_max_size', '500M');
    ini_set('max_input_time', 10000);
    ini_set('max_execution_time', 10000);
    $ret = array();

//    This is for custom errors;
    /*    $custom_error= array();
    $custom_error['jquery-upload-file-error']="File already exists";
    echo json_encode($custom_error);
    die();
     */
    $error = $_FILES["myfile"]["error"];
    //You need to handle  both cases
    //If Any browser does not support serializing of multiple files using FormData()
    if (!is_array($_FILES["myfile"]["name"])) //single file
    {
        $fileName = $_FILES["myfile"]["name"];
        move_uploaded_file($_FILES["myfile"]["tmp_name"], $output_dir . $fileName);
        $ret[] = $fileName;
    } else //Multiple files, file[]
    {
        $fileCount = count($_FILES["myfile"]["name"]);
        for ($i = 0; $i < $fileCount; $i++) {
            $fileName = $_FILES["myfile"]["name"][$i];
            move_uploaded_file($_FILES["myfile"]["tmp_name"][$i], $output_dir . $fileName);
            $ret[] = $fileName;
        }

    }
    echo json_encode($ret);
}
