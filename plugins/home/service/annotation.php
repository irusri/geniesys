<?php
$filename = '/path/to/foo.txt';

if (file_exists($filename)) {
    echo getcwd()." The file $filename exists";
} else {
    echo getcwd(). " The file $filename does not exist";
}
?>