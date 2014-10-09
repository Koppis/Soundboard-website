<?php

$known_users = (isset($_GET['users']) && !empty($_GET['users'])) ? JSON_decode($_GET['users']) : 0;
$user = (isset($_GET['user']) && !empty($_GET['user'])) ? $_GET['user'] : 0;
class MyDB extends SQLite3{
	function __construct(){
		$this->open('sqlitemain');
	}
}

$time_wasted=0;
$db = new MyDB();
$db->busyTimeout(5000);
if ($user != 0){
	$r = $db->exec("INSERT INTO users (name,connected) VALUES ('{$user}',1)");
	if ($r == false)
		$db->exec("UPDATE users SET connected=1 WHERE name='{$user}'");
}
$db->close();
$db->open('sqlitemain',SQLITE3_OPEN_READONLY);

$users_result = $db->query(
"SELECT name FROM users WHERE connected = 1".$where);

while($shoutbox_result->fetchArray() == false){
	if ($time_wasted >= 60){
		$db->close();
		die(json_encode(array('debug'=>'wasted','status'=>'no-results')));
		exit;                                                         
	}
	$db->close();
	sleep(1);
	$db->open('sqlitemain',SQLITE3_OPEN_READONLY);

	$time_wasted++;
	$users_result = $db->query(
	"SELECT name FROM users WHERE connected = 1".$where);
}
$users_result->reset();
$new_users = array();
while ($row = $users_result->fetchArray()){
	$new_users[] = array('user'=>$row['name']);
}

$db->close();
die(json_encode(array('debug'=>'','status'=>'results','data'=>$new_users)));
