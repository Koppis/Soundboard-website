<?php


// load framework files
require_once("libraries/TeamSpeak3/TeamSpeak3.php");
require_once("../myDatabase.php");

while (1) {

echo PHP_EOL."Main loop starting!".PHP_EOL;


// connect to local server in non-blocking mode, authenticate and spawn an object for the virtual server on port 9987
$GLOBALS["ts3"] = TeamSpeak3::factory("serverquery://koppislandia:xg1rR+Ni@127.0.0.1:10011/?server_port=9987&blocking=0");
// get notified on incoming private messages
//$GLOBALS["ts3"]->notifyRegister("textchannel");
//$ts3_VirtualServer->notifyRegister("textprivate");
//$GLOBALS["ts3"]->notifyRegister("channel",0);

$db = new myDatabase();


try {
while (1) {
$GLOBALS["ts3"]->clientListReset();
echo count($GLOBALS["ts3"]->clientList()).PHP_EOL;

foreach($GLOBALS["ts3"]->clientList() as $ts3_client)
{
    #echo ",";

    if($ts3_client["client_type"]) continue;


    $clientinfo = $ts3_client->getInfo();


    $cldbid = $clientinfo['client_database_id'];
    $nickname = $clientinfo['client_nickname'];
    #echo $nickname;
    $mode = 0;
    if ($clientinfo['client_input_muted'] == 1)
        $mode = 1;
    if ($clientinfo['client_output_muted'] == 1)
        $mode = 2;
    if ($clientinfo['client_away'] == 1)
        $mode = 3;

    
    #echo $date . " : It crashed!" . PHP_EOL;

    #echo "Nickname: ".$clientinfo['client_nickname'].PHP_EOL;
    #echo "Speakers muted: ".$clientinfo['client_output_muted'].PHP_EOL;
    #echo "Mic muted: ".$clientinfo['client_input_muted'].PHP_EOL;
    #echo "away: ".$clientinfo['client_away'].PHP_EOL;
    #echo "cldbid: ".$clientinfo['client_database_id'].PHP_EOL;

    $ret = $db->exec("UPDATE OR IGNORE teamspeak_clients SET mode = $mode, name='$nickname' WHERE id = $cldbid AND (mode IS NOT $mode OR name IS NOT '$nickname') ");
    
    if ($ret == 1) {
    $date = date('Y-m-d H:i:s');
    echo PHP_EOL.$date  . PHP_EOL;

    echo "Nickname: ".$clientinfo['client_nickname'].PHP_EOL;
    echo "Speakers muted: ".$clientinfo['client_output_muted'].PHP_EOL;
    echo "Mic muted: ".$clientinfo['client_input_muted'].PHP_EOL;
    echo "away: ".$clientinfo['client_away'].PHP_EOL;
    echo "cldbid: ".$clientinfo['client_database_id'].PHP_EOL;

    $GLOBALS["db"]->exec("UPDATE teamspeak_changes SET id = id + 1");

    }

}

usleep(500000);
}

} catch (Exception $e) {
    $date = date('Y-m-d H:i:s');

    echo $date.' Caught exception: ',  $e->getMessage(), "\n";   

    $GLOBALS["ts3"] = NULL;
    
    continue;
}
}
