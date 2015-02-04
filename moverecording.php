<?php


$rowid = $_POST['rowid'];
$newcat = $_POST['newcat'];


require_once('myDatabase.php');


$db = new myDatabase();

$db->exec("UPDATE recordings SET category='$newcat' WHERE rowid = $rowid");
$db->exec("UPDATE changes SET revision = revision + 1, id = $rowid WHERE name='recordings'");

$db = NULL;
