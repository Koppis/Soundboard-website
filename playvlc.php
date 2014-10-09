<?php
putenv('LANG=en_US.UTF-8'); 
function utf8_urldecode($str) {
	$str = preg_replace("/%u([0-9a-f]{3,4})/i","&#x\\1;",urldecode($str));
	return html_entity_decode($str,null,'UTF-8');
}

#$_POST['path'] = utf8_decode($_POST['path']);


$file_parts = pathinfo($_POST['path']);

echo $_POST['path'];

$msg = $_POST['path'];

if (isset($_POST['yt']) && !empty($_POST['yt']) && $_POST['yt'] == 1) {
	preg_match('!(https?://)?www.youtube.com/watch\?v=(.{11})!i', $msg, $matches);
	echo $matches[2];
	if ($matches){
	$vidtitle = youtube_title($matches[2]);
	} else {
	$vidtitle = $msg;
	}
	$db = new PDO('sqlite:sqlitemain');
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
	$db->exec("pragma synchronous = off;");
	$db->exec("INSERT INTO youtube (link,name) VALUES ('{$msg}','{$vidtitle}')");
	$db = NULL;
}

$socket = socket_create(AF_INET, SOCK_DGRAM, SOL_UDP);
socket_sendto($socket, $msg, strlen($msg), 0, "91.156.255.202", 1124);
socket_sendto($socket, $msg, strlen($msg), 0, "91.156.255.202", 1125);
socket_sendto($socket, $msg, strlen($msg), 0, "91.156.255.202", 1126);
socket_sendto($socket, $msg, strlen($msg), 0, "91.156.255.202", 1127);
socket_close($socket);


function youtube_title($id) {
  $video_info = file_get_contents("http://youtube.com/get_video_info?video_id=".$id);
	parse_str($video_info, $ytarr);
	return $ytarr['title'];
}