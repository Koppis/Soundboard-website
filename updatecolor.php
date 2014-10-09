<?php

$user = (isset($_GET['user']) && !empty($_GET['user'])) 
	? $_GET['user'] : "";
$color = (isset($_GET['color']) && !empty($_GET['color'])) 
	? $_GET['color'] : '#000000';

if (user == ""){
	die("No user specified");
	exit;	
}

$db = new PDO('sqlite:sqlitemain');
$db->exec("pragma synchronous = off");
$db->exec("UPDATE users SET color = '{$color}' WHERE name IS '{$user}'");
$db = NULL;