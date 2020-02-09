<?php
$reset=$_POST['reset'];
$imageType=$_POST['type'];
$tmp_Color=$_POST['color'];

//Reset header image to default genie theme bckground
if($reset=="header"){
    copy('images/back.png', 'images/tmp.png' );
    exit();
}

//Reset logo to default genie theme logo
if($reset=="logo"){
    copy('images/plantgeine_logo_backup.png', 'images/plantgeine_logo.png' );
    exit();
}


//Change header image
if($imageType=="header"){
$arr_file_types = ['image/png', 'image/gif', 'image/jpg', 'image/jpeg'];
 
if (!(in_array($_FILES['file']['type'], $arr_file_types))) {
    echo "false";
    return;
}
 
    move_uploaded_file($_FILES['file']['tmp_name'], 'images/tmp.png' );//. $_FILES['file']['name']
    echo "success";
}

//Change logo
if($imageType=="logo"){
    $arr_file_types = ['image/png', 'image/gif', 'image/jpg', 'image/jpeg'];
     
    if (!(in_array($_FILES['file']['type'], $arr_file_types))) {
        echo "false";
        return;
    }
     
        move_uploaded_file($_FILES['file']['tmp_name'], 'images/plantgeine_logo.png' );
        echo "success";
}

//Change background color
if($imageType=="color"){
    $file = @fopen(dirname(__FILE__)."/../../genie_files/background", 'w');
	if(!$file){
		echo "Error opening background. Set correct permissions (644) to the background file.";
		exit;
	}
	fwrite($file, $tmp_Color);
	fclose($file);
}

die();
?>