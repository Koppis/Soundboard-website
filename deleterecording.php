<?php


$rowid = $_POST['rowid'];


require_once('myDatabase.php');


$db = new myDatabase();

$db->exec("UPDATE recordings SET deleted=1 WHERE rowid = $rowid");
$db->exec("UPDATE changes SET revision = revision + 1, id = $rowid WHERE name='recordings'");

$db = NULL;
