<?php


$lastRow = (isset($_GET['rowid']) && !empty($_GET['rowid'])) ? $_GET['rowid']:0;
$kohta = (isset($_GET['kohta']) && !empty($_GET['kohta'])) ? $_GET['kohta'] : 0;
$user = (isset($_GET['user']) && !empty($_GET['user'])) ? $_GET['user'] : 0;
$rec = (isset($_GET['rec']) && !empty($_GET['rec'])) ? $_GET['rec'] : 0;
$new_rec = $rec;
$known_users = (isset($_GET['users']) && !empty($_GET['users'])) 
	? JSON_decode($_GET['users']) : array();


$date = date('Y-m-d H:i:s');
$time = time();
$results = False;
$time_wasted=0;
$db = new PDO('sqlite:sqlitemain');
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
$db->exec("pragma synchronous = off;");
if ($user !== 0){
	if (@$db->exec("INSERT INTO users (name,connected,lastpoll)".
		" VALUES ('{$user}',1,'{$time}')") == false){
		$db->exec("UPDATE users SET connected=1, lastpoll={$time}".
			" WHERE name='{$user}'");
	}
}
$result = $db->query(
	"SELECT status FROM record WHERE status IS NOT $rec");
$rec_result = $result->fetchAll();
$users_result = $db->query(
	"SELECT name FROM users WHERE connected = 1 AND ({$time} - lastpoll < 65)");
$new_users = array();
$new_messages = array();
foreach ($users_result as $row){
	$new_users[] = $row['name'];
}
$result = $db->query(
"SELECT shoutbox.rowid, shoutbox.*, users.color FROM shoutbox JOIN users ON ".
"shoutbox.user = users.name WHERE shoutbox.rowid > {$lastRow} ".
"ORDER BY shoutbox.rowid DESC LIMIT 50");
$shoutbox_result = $result->fetchAll();
if (!empty($shoutbox_result)){
	$new_messages = getMessages($db,$shoutbox_result);
	$results = True;
}
if (!empty($rec_result)){
	$new_rec = ($rec == 1) ? 0 : 1;
	$results = True;
}
if ($known_users !== $new_users){
	$results = True;
}

while($results == False){
	if ($time_wasted >= 300){
		$db = NULL;
		die(json_encode(array('debug'=>'wasted','status'=>'no-results')));
		exit;
	}
	//$db->close();
	usleep(200000);
	//$db->myOpen();
    
	$time_wasted++;
    
    $result = $db->query(
	"SELECT status FROM record WHERE status IS NOT $rec");
    $rec_result = $result->fetchAll();
	$users_result = $db->query(
	"SELECT name FROM users WHERE connected = 1 AND ({$time} - lastpoll < 65)");
	$new_users = array();
	$new_messages = array();
	foreach ($users_result as $row){
	$new_users[] = $row['name'];
	}
	$result = $db->query(
	"SELECT shoutbox.rowid, shoutbox.*, users.color FROM shoutbox JOIN users ON ".
	"shoutbox.user = users.name WHERE shoutbox.rowid > {$lastRow} ".
	"ORDER BY shoutbox.rowid DESC LIMIT 50");

	$shoutbox_result = $result->fetchAll();
	
	if (!empty($shoutbox_result)){
	$new_messages = getMessages($db,$shoutbox_result);
	$results = True;
	}
    if (!empty($rec_result)){
	$new_rec = ($rec == 1) ? 0 : 1;
	$results = True;
    }
	if ($known_users !== $new_users){
	$results = True;
	}else {$new_users = array();} //clear new_users so it's not sent.
}

$db = NULL;
die(json_encode(array('debug'=>"jJ",'status'=>'results',
	'messages'=>$new_messages,'users'=>$new_users,'rec'=>$new_rec)));

function getMessages($db,$shoutbox_result){
	$emotes_result = $db->query("SELECT * FROM emoticons");
	$emotes = array();
	foreach ($emotes_result as $row){
		$emotes[] = array('sana'=>$row['sana'],'linkki'=>$row['linkki']);
	}
	$new_messages = array();
	foreach ($shoutbox_result as $row){
		$text = $row['msg'];
		$text = stripslashes($text);
		foreach ($emotes as $e)
			$text = str_replace($e['sana'],
				'<img style="max-height:50px;max-width:50px;" src="'.
				$e['linkki'].'">',$text);
	
		$new_messages[] = array('rowid'=>$row['rowid'],'time'=>$row['pvm'],
			'user'=>$row['user'],'msg'=>$text,'color'=>$row['color']);
	}
	
	return array_reverse($new_messages);

}
