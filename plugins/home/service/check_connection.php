<?php
$host=trim($_POST['host']);
$username=trim($_POST['username']);
$password=trim($_POST['password']);
$database=trim($_POST['database']);
$operation=trim($_POST['operation']);


if($operation=="check"){
    $link = mysqli_connect($host, $username, $password);

    if (!$link) {
        echo json_encode("<font color='red'>  Wrong username and or password</font>");
        exit;
    }else{

        if (!mysqli_select_db($link,$database)){
            $sql = "CREATE DATABASE ".$database;
           // $sql = "CREATE DATABASE ".$database.";GRANT SELECT ON ".$database.".* TO ".$username."@'".$host."';GRANT INSERT,UPDATE,DELETE ON ".$database.".genebaskets TO ".$username."@'".$host."';GRANT INSERT,UPDATE,DELETE ON ".$database.".defaultgenebaskets TO ".$username."@'".$host."';";
            if ($link->query($sql) === TRUE) {
                echo json_encode("success");
            }else {
                echo json_encode("<font color='red'> Not enough permssion to create <strong>".$database."</strong> database.");
            }
        } else{
            echo json_encode("<font color='red'>Database <strong>".$database."</strong> already exist.</font>");
        }


    }
}






mysqli_close($link);
?>