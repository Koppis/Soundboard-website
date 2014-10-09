<?php
$user = (isset($_GET['user']) && !empty($_GET['user'])) ? $_GET['user'] : 0;

$db = new PDO('sqlite:sqlitemain');
$db->exec("pragma synchronous = off;");
$date = date('Y-m-d H:i:s');
$db->exec("UPDATE users SET connected=0 WHERE name='{$user}'");


$db = NULL;