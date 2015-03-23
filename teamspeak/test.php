<?php
// load framework files
require_once("libraries/TeamSpeak3/TeamSpeak3.php");
require_once("../myDatabase.php");


$GLOBALS["db"] = new myDatabase();

$GLOBALS["secondtime"] = false;


while (1) {
// connect to local server in non-blocking mode, authenticate and spawn an object for the virtual server on port 9987
$GLOBALS["ts3"] = TeamSpeak3::factory("serverquery://koppislandia:xg1rR+Ni@127.0.0.1:10011/?server_port=9987&blocking=0");
// get notified on incoming private messages
$GLOBALS["ts3"]->notifyRegister("textchannel");
//$ts3_VirtualServer->notifyRegister("textprivate");
$GLOBALS["ts3"]->notifyRegister("channel",0);


// walk through list of channels
$GLOBALS["db"]->exec("DELETE FROM teamspeak_channels");
foreach($GLOBALS["ts3"]->channelList() as $ts3_channel)
{

    $info = $ts3_channel->getInfo();

    $cid = $info['cid'];
    $pid = $info['pid'];
    $name = $info['channel_name'];

    $GLOBALS["db"]->exec("INSERT OR IGNORE INTO teamspeak_channels (id,name,parent) VALUES ($cid,'$name',$pid)");
    $GLOBALS["db"]->exec("UPDATE teamspeak_channels SET name = '$name', parent = $pid WHERE id = $cid");
    

    //foreach($info as $key => $value)
      //  echo $key." => ".$value.PHP_EOL;

    echo "channel name: ".$info['channel_name'].", id:".$info['cid'].", parent id:".$info['pid'].PHP_EOL;

}

// walk through list of clients on virtual server
$GLOBALS["db"]->exec("DELETE FROM teamspeak_clients");
foreach($GLOBALS["ts3"]->clientList() as $ts3_Client)
{
    //foreach($ts3_Client->getInfo() as $key => $value)
      //  echo $key." => ".$value.PHP_EOL;

    // skip query clients
    if($ts3_Client["client_type"]) continue;
    
    $array = $ts3_Client->getInfo();
    
    $clid = $array['clid'];
    $cid = $array['cid'];
    $cldbid = $array['client_database_id'];
    $nickname = $array['client_nickname'];
  
    $GLOBALS["db"]->exec("INSERT OR IGNORE INTO teamspeak_clients (id,name,channel,online,clid) VALUES ($cldbid,'$nickname',$cid,1,$clid)");
    $GLOBALS["db"]->exec("UPDATE teamspeak_changes SET id = id + 1");
    echo "clid: " . $array['clid']
    .", name: ". $array['client_nickname'] 
    . ", channel: " . $array['cid'] 
    . ", cldbid: " . $array['client_database_id'] 
    . PHP_EOL;
}



// register a callback for notifyTextmessage events 

//
TeamSpeak3_Helper_Signal::getInstance()->subscribe("notifyTextmessage", "onTextmessage");
TeamSpeak3_Helper_Signal::getInstance()->subscribe("notifyClientmoved", "onClientmoved");
TeamSpeak3_Helper_Signal::getInstance()->subscribe("notifyClientleftview", "onClientdisconnect");
TeamSpeak3_Helper_Signal::getInstance()->subscribe("notifyCliententerview", "onClientconnect");




/*foreach (TeamSpeak3_Helper_Signal::getInstance()->getSignals() as $sig) {
    echo($sig);
}
 */
// wait for events
try {

while(1) $GLOBALS["ts3"]->getAdapter()->wait();
    
} catch (TeamSpeak3_Transport_Exception $e) {
    $date = date('Y-m-d H:i:s');
    echo $date . " : It crashed!" . PHP_EOL;
continue;
}

break;
$db = NULL;
}

// define a callback function
function onTextmessage(TeamSpeak3_Adapter_ServerQuery_Event $event, TeamSpeak3_Node_Host $host)
{
    echo "Client " . $event["invokername"] . " sent textmessage: " . $event["msg"] . PHP_EOL;

    $user = $event["invokername"];
    $msg = str_replace("'","''",htmlspecialchars($event["msg"]));
    $date = date('Y-m-d H:i:s');

    $GLOBALS["db"]->exec("INSERT INTO teamspeak_chat (pvm,user,msg) VALUES ('$date','$user','$msg')");
    
}
function onClientmoved(TeamSpeak3_Adapter_ServerQuery_Event $event, TeamSpeak3_Node_Host $host)
{   
    $clid = $event['clid'];
    $ctid = $event['ctid'];
    $cldbid = $GLOBALS["db"]->query("SELECT id FROM teamspeak_clients WHERE clid = $clid")[0]['id'];
    
    
    $GLOBALS["db"]->exec("UPDATE teamspeak_clients SET channel = $ctid WHERE id = $cldbid");
    $GLOBALS["db"]->exec("UPDATE teamspeak_changes SET id = id + 1");
    echo "client moved, clid=" . $event['clid'] . ", ctid=".$event['ctid'] . ", reasonid=" . $event['reasonid'] . PHP_EOL; 
    
    if ($ctid == 1) {
        if ($GLOBALS["secondtime"] == true) {
            $msg = "sounds\\recorded\\3726.wav";
            if ($msg != "") {
                $socket = socket_create(AF_INET, SOCK_DGRAM, SOL_UDP);
                socket_sendto($socket, $msg, strlen($msg), 0, "91.156.255.202", 1124);
                socket_sendto($socket, $msg, strlen($msg), 0, "91.156.255.202", 1125);
                socket_sendto($socket, $msg, strlen($msg), 0, "91.156.255.202", 1126);
                socket_sendto($socket, $msg, strlen($msg), 0, "91.156.255.202", 1127);
                socket_close($socket);
            }
            echo "sent ayyy".PHP_EOL;
            $GLOBALS["secondtime"] = false;
        } else {
            $GLOBALS["secondtime"] = true;
        }
    }

}
function onClientdisconnect(TeamSpeak3_Adapter_ServerQuery_Event $event, TeamSpeak3_Node_Host $host)
{      
    $clid = $event['clid'];
    
    $result = $GLOBALS["db"]->query("SELECT id FROM teamspeak_clients WHERE clid = $clid AND online = 1");
    #echo "count : ".count($result).PHP_EOL;
    if (count($result) > 0) {
        $cldbid = $result[0]['id'];
    } else {
        return ;
    }

    $GLOBALS["db"]->exec("DELETE FROM teamspeak_clients WHERE clid = $clid");
    $GLOBALS["db"]->exec("UPDATE teamspeak_changes SET id = id + 1");
    
    echo "client disconnected, clid=" . $event['clid'] . ", cldbid=".$cldbid . PHP_EOL;  
    
    $msg = "";
    /*switch ($cldbid) {
        case 6: // Eero
        $msg = "sounds\\recorded\\1.wav";
        break;
        case 39: // Teemu
        $msg = "sounds\\recorded\\2106.wav";
        break;
        case 8: // Lassi
        $msg = "sounds\\recorded\\2120.wav";
        break;
        case 4: // Lauri
        $msg = "sounds\\recorded\\2107.wav";
        break;
        case 7: // Touko
        $msg = "sounds\\recorded\\218.wav";
        break;
    }*/
    $msg = "sounds\\mlg\\SPOOKY.mp3";
    if ($msg != "") {
        $socket = socket_create(AF_INET, SOCK_DGRAM, SOL_UDP);
        socket_sendto($socket, $msg, strlen($msg), 0, "91.156.255.202", 1124);
        socket_sendto($socket, $msg, strlen($msg), 0, "91.156.255.202", 1125);
        socket_sendto($socket, $msg, strlen($msg), 0, "91.156.255.202", 1126);
        socket_sendto($socket, $msg, strlen($msg), 0, "91.156.255.202", 1127);
        socket_close($socket);
    }

}
function onClientconnect(TeamSpeak3_Adapter_ServerQuery_Event $event, TeamSpeak3_Node_Host $host)
{      
    $clid = $event['clid'];
    $ctid = $event['ctid'];
    $cldbid = $event['client_database_id'];
    $nickname = $event['client_nickname'];

    $msg = "";
    switch ($cldbid) {
        case 6: // Eero
        $msg = "sounds\\recorded\\4035.wav";
        break;
        case 39: // Teemu
        $msg = "sounds\\recorded\\932.wav";
        break;
        case 8: // Lassi
        $msg = "sounds\\recorded\\761.wav";
        break;
        case 4: // Lauri
        $msg = "sounds\\recorded\\624.wav";
        break;
        case 7: // Touko
        $msg = "sounds\\recorded\\286.wav";
        break;
    }
    if ($msg != "") {
        $socket = socket_create(AF_INET, SOCK_DGRAM, SOL_UDP);
        socket_sendto($socket, $msg, strlen($msg), 0, "91.156.255.202", 1124);
        socket_sendto($socket, $msg, strlen($msg), 0, "91.156.255.202", 1125);
        socket_sendto($socket, $msg, strlen($msg), 0, "91.156.255.202", 1126);
        socket_sendto($socket, $msg, strlen($msg), 0, "91.156.255.202", 1127);
        socket_close($socket);
    }

    
    
    if (!(strpos($nickname, 'from 127.0.0.1') !== FALSE)) {
    
    $GLOBALS["db"]->exec("INSERT OR IGNORE INTO teamspeak_clients (id,name,channel,online,clid) VALUES ($cldbid,'$nickname',$ctid,1,$clid)");

    
    $GLOBALS["db"]->exec("UPDATE teamspeak_changes SET id = id + 1");
    }
    
    echo "client connected, clid=" . $clid . ", cldbid=".$cldbid . ", name=".$nickname . PHP_EOL;

}




