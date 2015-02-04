<?php


$rowid = $_POST['rowid'];
$newname = $_POST['newname'];


require_once('myDatabase.php');


$db = new myDatabase();

$db->exec("UPDATE recordings SET name='$newname'  WHERE rowid = $rowid");
$db->exec("UPDATE changes SET revision = revision + 1, id = $rowid WHERE name='recordings'");

$db = NULL;
