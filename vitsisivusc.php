<?php
if (key_exists('dothis',$_POST))
	$choice = $_POST['dothis'];
else{
	die("You didn't specify a dothis");
}

$db = new PDO('sqlite:sqlitemain');
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
$db->exec("pragma synchronous = off;");



switch ($_POST['dothis']){

case 0: // Add a joke
    
    $db->exec(sprintf("INSERT INTO vitsit (kieli, vitsi) VALUES ('%s','%s')",$_POST['kieli'],$_POST['vitsi']));
    $db->exec("UPDATE changes SET revision = revision + 1 WHERE name = 'vitsit'");

break;

case 1: // Remove a vitsi

    $db->exec(sprintf("DELETE FROM vitsit WHERE rowid=%s",$_POST['id']));
    $db->exec("UPDATE changes SET revision = revision + 1 WHERE name = 'vitsit'");
break;

case 2: //Edit a vitsi

$id = $_POST['id'];
$new = $_POST['new'];
	
$db->exec(sprintf("UPDATE vitsit SET vitsi='%s' WHERE rowid=%s",$new,$id));
$db->exec("UPDATE changes SET revision = revision + 1 WHERE name = 'vitsit'");


break;
}

$db = null;
