<?php

switch ($_POST['dothis']){

case 0: //move to different category
 
$path = "/var/www/sounds/" . utf8_decode($_POST['path']);

$f = explode("/",$path);
$fname = $f[count($f)-1];
if ($_POST['cat'] == 'sounds')
	$newpath = "/var/www/sounds/" . $fname;
else
	$newpath = "/var/www/sounds/" . $_POST['cat'] . "/" . $fname;

rename($path,$newpath);
break;

case 1: //delete

echo"deleting "."/var/www/sounds/" . utf8_decode($_POST['path']);

unlink("/var/www/sounds/" . utf8_decode($_POST['path']));

break;

case 2: //rename

$newname = utf8_decode($_POST['newname']);
$oldname = utf8_decode($_POST['oldname']);
$oldpath = "/var/www/sounds/".utf8_decode($_POST['oldpath']);

echo "\nreplace ".$oldname." with ".$newname." in ". $oldpath;

$newpath = str_replace($oldname,$newname,$oldpath);



rename($oldpath,$newpath);

break;


}