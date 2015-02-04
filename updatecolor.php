<?php

$user = (isset($_GET['session']) && !empty($_GET['session'])) 
	? $_GET['session'] : "";
$color = (isset($_GET['color']) && !empty($_GET['color'])) 
	? $_GET['color'] : '#000000';

if (user == ""){
	die("No user specified");
	exit;	
}

$db = new PDO('sqlite:/var/www/db/sqlitemain');
$db->exec("pragma synchronous = off");
$db->exec("UPDATE users SET color = '{$color}' WHERE name IS '{$user}'");
$db = NULL;
