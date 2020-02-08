<?php
$reset=$_POST['reset'];
$imageType=$_POST['type'];

if($reset=="header"){
    copy('images/back.png', 'images/tmp.png' );
    exit();
}

if($reset=="logo"){
    copy('images/plantgeine_logo_backup.png', 'images/plantgeine_logo.png' );
    exit();
}



if($imageType=="header"){
$arr_file_types = ['image/png', 'image/gif', 'image/jpg', 'image/jpeg'];
 
if (!(in_array($_FILES['file']['type'], $arr_file_types))) {
    echo "false";
    return;
}
 
    move_uploaded_file($_FILES['file']['tmp_name'], 'images/tmp.png' );//. $_FILES['file']['name']
    echo "success";
}

if($imageType=="logo"){
    $arr_file_types = ['image/png', 'image/gif', 'image/jpg', 'image/jpeg'];
     
    if (!(in_array($_FILES['file']['type'], $arr_file_types))) {
        echo "false";
        return;
    }
     
        move_uploaded_file($_FILES['file']['tmp_name'], 'images/plantgeine_logo.png' );//. $_FILES['file']['name']
        echo "success";
}


die();
?>