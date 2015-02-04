<?php


require_once("myRistiDatabase.php");


$id = $_POST['id'];

$db = new myRistiDatabase();

$db->exec("DELETE FROM data WHERE (p1 = '$id' OR p2 = '$id')");

