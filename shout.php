<?php

require_once('myDatabase.php');

$text = $_POST['msg'];



$text = str_replace(">","&gt;",$text);
$text = str_replace("<","&lt;",$text);
$text = preg_replace('!(((f|ht)tp(s)?://)[-a-zA-Z?-??-?()0-9@:%_+.~#?&;//=]+)!i', '<a href="$1">$1</a>', $text);

preg_match('!>(https?://)?www.youtube.com/watch\?v=(.{11})<\/a>!i', $text, $matches);
if ($matches){
$vidtitle = youtube_title($matches[2]);

$text = preg_replace('!>(https?://)?www.youtube.com/watch\?v=(.{11})<\/a>!i',
		'>'.$vidtitle.'</a>', $text);
}


date_default_timezone_set("Europe/Helsinki");
$date = date('Y-m-d H:i:s');

$db = new myDatabase();
$db->exec("INSERT INTO shoutbox (pvm,user, msg) VALUES ('" .
			$date . "','" . addslashes($_POST['user']) . "','" . addslashes($text) . "')");
$db = NULL;

function youtube_title($id) {
  $video_info = file_get_contents("http://youtube.com/get_video_info?video_id=".$id);
	parse_str($video_info, $ytarr);
	return $ytarr['title'];
}
