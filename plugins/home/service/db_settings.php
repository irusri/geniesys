<?php

require '../../../api/src/config/crypt.php';

ini_set('memory_limit', '-1');
ini_set('max_execution_time', 300);
$host = trim($_POST['host']);
$username = trim($_POST['username']);
$password = trim($_POST['password']);
$database = trim($_POST['database']);
$species = trim($_POST['species']);
$get_action = $_POST['action'];
$get_name = $_POST['name'];
$settings_array=array();

//Read settings ini file & fill in the input boxes
if ($get_action == "read_settings_ini") {
    readInifile();
}

//Check connection
if ($get_name == "check") {
    readInifile();
}

//Check connection
if ($get_action == "check_connection") {
    checkConnection();
}

//Check database
if ($get_action == "save_ini_file") {
    saveSettings();
}

//Clone database
if ($get_action == "") {

}

//Write  settings inifile
if ($get_action == "") {

}


//Read ini file
function readInifile(){
    $ini_array = parse_ini_file("../../../genie_files/settings",true) or die("Unable to open file!");
    $genieCrypt=new genieCrypt();
    $host=$ini_array['settings'][host];
    $user=$ini_array['settings'][username];
    $pass=$genieCrypt->DecryptThis($ini_array['settings'][password]);
    $database=$ini_array['settings'][database];
    $species=$ini_array['settings'][species];
    $ret=array();
    $ret["host"]=$host;
    $ret["user"]=$user;
    $ret["pass"]=$pass;
    $ret["database"]=$database;
    $ret["species"]=$species;
    $settings_array=$ret; 
    $PHP_Pass=exec('echo $MYSQL_ADMIN_PASS');
    $conn_init = mysqli_connect($host, $user, $PHP_Pass);
    $conn = mysqli_connect($host, $user, $pass);
    if($conn_init==true){
        $conn= $conn_init;
        $ret["pass"]=$PHP_Pass;
    }
    if (!$conn) {
        jsonMsg('error', "Connection failed: " , json_encode($ret));
    }else{
        if (!mysqli_select_db($conn, $database)) {
            jsonMsg('warning', "connection success but database not.", json_encode($ret));
        }else{
            jsonMsg('success', "Database and the server connection were established.", json_encode($ret));
        }
       
    }
}

// output json information
function jsonMsg($status, $message, $name = ''){
    $arr['status'] = $status;
    $arr['message'] = $message;
    $arr['name'] = $name;
    echo json_encode($arr);
}

//if the settings file exist save the settings
function saveSettings(){
  $genieCrypt=new genieCrypt();
    $data = array(
        'settings' => array(
            'host' =>  trim($_POST['host']),
            'username' => trim($_POST['username']),
            'password' => $genieCrypt->EncryptThis(trim($_POST['password'])),
            'database' => trim($_POST['database']),
            'species' => trim($_POST['species'])
        )
    );
    write_php_ini($data, "../../../genie_files/settings") ;
    readInifile();
}

function write_php_ini($array, $file)
{
    $res = array();
    foreach($array as $key => $val){
        if(is_array($val)){
            $res[] = "[$key]";
            foreach($val as $skey => $sval) $res[] = "$skey = ".(is_numeric($sval) ? $sval : '"'.$sval.'"');
        }
        else $res[] = "$key = ".(is_numeric($val) ? $val : '"'.$val.'"');
    }
    safefilerewrite($file, implode("\r\n", $res));
}

function safefilerewrite($fileName, $dataToSave){    
    if ($fp = fopen($fileName, 'w')){
        $startTime = microtime(TRUE);
        do
        {            
            $canWrite = flock($fp, LOCK_EX);
           // If lock not obtained sleep for 0 - 100 milliseconds, to avoid collision and CPU load
           if(!$canWrite) usleep(round(rand(0, 100)*1000));
        } while ((!$canWrite)and((microtime(TRUE)-$startTime) < 5));

        //file was locked so now we can store information
        if ($canWrite) {            
            fwrite($fp, $dataToSave);
            flock($fp, LOCK_UN);
        }
        fclose($fp);
    }

}



//Drop exsisting database
if ($get_action == "drop_database") {
    //saveSettings();
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
            jsonMsg('success', "<strong>" . $database . "</strong> database was deleted");
        }
    }
}


//Create a new database depending on the given name
if ($get_action == "create_database") {
   $link = mysqli_connect($host, $username, $password);
   $sql = "CREATE DATABASE " . $database;
    if ($link->query($sql) === true) {
        mysqli_close($link);
        load_sql($host, $username, $password, $database, $get_name);
        jsonMsg('success', "<strong>" . $database . "</strong> database was created", $database);
    }else{
        jsonMsg('warning', "Database <strong>" . $database . "</strong> already exist", $database);
    }
    mysqli_close($link);
}



// load MySQL dump file into the database
function load_sql($host, $username, $password, $database, $get_name){
$url = "http://build.plantgenie.org/tmp/".$get_name."/dump.sql";
$file_name = "dump.sql";

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

    //saveSettings($database);
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

