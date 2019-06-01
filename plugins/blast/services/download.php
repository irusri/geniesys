<?php
$uuid=$_POST['uuid'];
$ids=$_POST['ids'];

$my_submission_file = $uuid.'.submission';
unlink('../tmp/'.$uuid.'.fasta');
$string=file_get_contents('../tmp/'.$my_submission_file);
//$json_a = json_decode($string, true);
exec($string .' '.$ids,$out);
echo json_encode($out);
?>