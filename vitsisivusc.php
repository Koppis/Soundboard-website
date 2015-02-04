<?php

if (!isset($_SERVER["HTTP_HOST"])) {
    //for dem debugs
  parse_str($argv[1], $_GET);
  parse_str($argv[1], $_POST);
}

if (key_exists('dothis',$_POST))
	$choice = $_POST['dothis'];
else{
	die("You didn't specify a dothis");
}

require_once('myDatabase.php');

$db = new myDatabase();


switch ($_POST['dothis']){

case 0: // Add a joke
    
    $db->exec(sprintf("INSERT INTO vitsit (kieli, vitsi) VALUES ('%s','%s')",$_POST['kieli'],$_POST['vitsi']));
    $db->exec("UPDATE changes SET revision = revision + 1 WHERE name = 'vitsit'");

break;

case 1: // Remove a joke

    $db->exec(sprintf("DELETE FROM vitsit WHERE rowid=%s",$_POST['id']));
    $db->exec("UPDATE changes SET revision = revision + 1 WHERE name = 'vitsit'");

break;

case 2: //Edit a joke

    $db->exec(sprintf("UPDATE vitsit SET vitsi='%s' WHERE rowid=%s",$_POST['newname'],$_POST['id']));
    $db->exec("UPDATE changes SET revision = revision + 1 WHERE name = 'vitsit'");

break;
}

$db = null;
