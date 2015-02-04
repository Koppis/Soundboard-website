<?php

echo "tschatmessage.php";

require_once("libraries/TeamSpeak3/TeamSpeak3.php");

$msg = $_POST['msg'];
$user = $_POST['user'];
if ($user == "Username") $user = "Anonymous";
$date = $date = date('Y-m-d H:i:s');

$msg = preg_replace('!(((f|ht)tp(s)?://)[-a-zA-Z?-??-?()0-9@:%_+.~#?&;//=]+)!i', '[URL]$1[/URL]', $msg);
try {
    $ts3 = TeamSpeak3::factory("serverquery://koppislandia:xg1rR+Ni@127.0.0.1:10011/?server_port=9987&blocking=0&nickname=".$user);
} catch (Exception $e) {
    $ts3 = TeamSpeak3::factory("serverquery://koppislandia:xg1rR+Ni@127.0.0.1:10011/?server_port=9987&blocking=0&nickname=".$user."1");
}
$channel = $ts3->channelGetById(1);

$channel->message("$msg");


echo "Sent ".$msg." as ".$user.".";
