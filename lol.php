<?php
function myErrorHandler($errno, $errstr, $errfile, $errline) {
      if ( E_RECOVERABLE_ERROR===$errno ) {
      throw new ErrorException($errstr, $errno, 0, $errfile, $errline);
       return true;
     }
    return false;
}
set_error_handler('myErrorHandler');

require_once("/var/www/dev/teamspeak/libraries/TeamSpeak3/TeamSpeak3.php");
require_once("/var/www/dev/myDatabase.php");
require '/var/www/dev/vendor/autoload.php';
use LeagueWrap\Api;
$myKey = "f9ca22bf-67ab-4a68-bc69-546a98b778ac";
$api      = new Api($myKey);           // Load up the API
$api->setRegion('eune');
$api->limit(10, 10);    // Set a limit of 10 requests per 10 seconds
$api->limit(500, 600);  // Set a limit of 500 requests per 600 (10 minutes) seconds
$summoner = $api->summoner();          // Load up the summoner request object.
$currentGame = $api->currentGame();
$api->attachStaticData(); 



while (1) {

echo PHP_EOL."Main loop starting!".PHP_EOL;


// connect to local server in non-blocking mode, authenticate and spawn an object for the virtual server on port 9987
$GLOBALS["ts3"] = TeamSpeak3::factory("serverquery://koppislandia:xg1rR+Ni@127.0.0.1:10011/?server_port=9987&blocking=0");
// get notified on incoming private messages
//$GLOBALS["ts2"]->notifyRegister("textchannel");
//$ts3_VirtualServer->notifyRegister("textprivate");
//$GLOBALS["ts3"]->notifyRegister("channel",0);

$db = new myDatabase();

try{
while (1) {
$GLOBALS["ts3"]->clientListReset();
$nicks = array();
foreach($GLOBALS["ts3"]->clientList() as $ts3_client)
{

    if($ts3_client["client_type"]) continue;


    $clientinfo = $ts3_client->getInfo();


    $cldbid = $clientinfo['client_database_id'];
    $nickname = $clientinfo['client_nickname'];
    $date = date('Y-m-d H:i:s');

    echo "Nickname: ".$clientinfo['client_nickname'].PHP_EOL;
    $searchname = $nickname;
    switch ($nickname) {
    case "Super":
        $searchname = "Twitch chat";
        break;
    case "omena":
        $searchname = "Happy Omena";
        break;
    }
    $s = $summoner->info($searchname); 
    try {
        echo "League name: ".$s->name."\n";
        $id = $s->id;
        $game = $currentGame->currentGame($s);
        $participant = $game->participant($id);
        $champion = $api->champion()->championById($participant->championId);
        $champname = str_replace("'","",$champion->championStaticData->name);
        echo "name: " . $champname . "\n";
        $r = $db->query("SELECT lolchamp FROM teamspeak_clients WHERE name = '$nickname'");
        if ($r[0]['lolchamp'] != $champname) {
            $db->exec("UPDATE teamspeak_clients SET lolchamp = '$champname' WHERE name = '$nickname'");
            $db->exec("UPDATE teamspeak_changes SET id = id + 1");
        }
    } catch (Exception $e) {
        echo "Ei pelaa \n";
        $r = $db->query("SELECT lolchamp FROM teamspeak_clients WHERE name = '$nickname'");
        if ($r[0]['lolchamp'] != NULL) {
            $db->exec("UPDATE teamspeak_clients SET lolchamp = NULL WHERE name = '$nickname'");
            $db->exec("UPDATE teamspeak_changes SET id = id + 1");
        }
    }
}

echo "\n";
usleep(10000000);
}

} catch (Exception $e) {
    $date = date('Y-m-d H:i:s');

    echo $date.' Caught exception: ',  $e->getMessage(), "\n";   

    $db = NULL;
    
    continue;
}}

function sendmsg($msg) {
    $msg = utf8_decode($msg);
    $socket = socket_create(AF_INET, SOCK_DGRAM, SOL_UDP);
    socket_sendto($socket, $msg, strlen($msg), 0, "91.156.255.202", 1124);
    socket_sendto($socket, $msg, strlen($msg), 0, "91.156.255.202", 1125);
    socket_sendto($socket, $msg, strlen($msg), 0, "91.156.255.202", 1126);
    socket_sendto($socket, $msg, strlen($msg), 0, "91.156.255.202", 1127);
    socket_close($socket);
} 
