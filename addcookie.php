<?php

require_once('myDatabase.php');

$db = new myDatabase();

$data = JSON_encode($_POST['recordinglayout']);

$db->exec("insert or replace into cookiedata (identifier,recordinglayout)".
    " values ('{$_POST['identifier']}','{$data}')");
    
$db = NULL;