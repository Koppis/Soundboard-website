<?php
function myErrorHandler($errno, $errstr, $errfile, $errline) {
      if ( E_RECOVERABLE_ERROR===$errno ) {
      throw new ErrorException($errstr, $errno, 0, $errfile, $errline);
       return true;
     }
    return false;
}
set_error_handler('myErrorHandler');

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
$api_game = $api->game();


while (1) {

echo PHP_EOL."Main loop starting!".PHP_EOL;

$db = new myDatabase();

$nicks = array();
$tsclients = $db->query("SELECT name FROM teamspeak_clients");
foreach ($tsclients as $row) {
    $nickname = $row['name']; 
    $db->exec("INSERT OR IGNORE INTO leagueoflegends (name) VALUES ('$nickname')");
    @$id = intval($db->query("SELECT summonerid FROM leagueoflegends WHERE name = '$nickname'")[0]['summonerid']);
    echo "Nickname: ".$nickname.PHP_EOL;
    if ($id == NULL) {
        $searchname = $nickname;
        switch ($nickname) {
        case "Super":
            $searchname = "Twitch chat";
            break;
        case "Koppis":
            $searchname = "Koppis1337";
            break;
        case "omena":
            $searchname = "Happy Omena";
            break;
        }
        if ($searchname == "Jukebox") continue;
        $s = $summoner->info($searchname); 
        if ($s == NULL) continue;
        $db->exec("UPDATE leagueoflegends SET summonerid = ".$s->id." WHERE name = '$nickname'");
        $id = $s->id;
    } 
    try {
        //echo "League name: ".$s->name."\n";

        $r = $db->query("SELECT lastgameid FROM leagueoflegends WHERE name = '$nickname'");
        $games = @$api_game->recent($id);
        $recentgame  = $games[0]->stats;
        $lastgameid = $games[0]->gameId;
        $champion = $api->champion()->championById($games[0]->championId);
        $champname = str_replace("'","",$champion->championStaticData->name);
        echo "db lastgameid: ".$r[0]['lastgameid']." last gameid: ".$lastgameid."\n";
        //print_r( $recentgame);
        if ($r[0]['lastgameid'] != $lastgameid){
            $db->exec("UPDATE leagueoflegends SET lastgameid = $lastgameid WHERE name = '$nickname'");
            $kills = intval($recentgame->championsKilled);
            $deaths = intval($recentgame->numDeaths);
            $assists = intval($recentgame->assists);
            $wards = intval($recentgame->wardPlaced);
            $cscore = intval($recentgame->minionsKilledi + $recentgame->neutralMinionsKilled); 
            if ($recentgame->win == 1) {
            $msg = '"http://translate.google.com/translate_tts?tl=fi&ie=UTF-8&q='.
                'Käyttäjä '.$nickname.' voitti lol pelin sankarilla '.$champname.'"';
            $msg .= ' "http://translate.google.com/translate_tts?tl=fi&ie=UTF-8&q='.
                'Onnittelut! sait jopa '.$kills.' tappoa ja kuolit vain '.$deaths.' kertaa"';
            $msg .= ' "http://translate.google.com/translate_tts?tl=fi&ie=UTF-8&q='.
                'Assisteja sait '.$assists.' ja asetit tiimillesi jopa '. $wards. ' wardia"';
            $msg .= ' "http://translate.google.com/translate_tts?tl=fi&ie=UTF-8&q='.
                'Tapoit hurjat '.$cscore.' minionia"';
            } else {
            $msg = '"http://translate.google.com/translate_tts?tl=fi&ie=UTF-8&q='.
                'Käyttäjä '.$nickname.' hävisi lol pelin sankarilla '.$champname.'"';
            $msg .= ' "http://translate.google.com/translate_tts?tl=fi&ie=UTF-8&q='.
                'Hyi sinua! sait vain '.$kills.' tappoa ja feedit '.$deaths.' kertaa"';
            $msg .= ' "http://translate.google.com/translate_tts?tl=fi&ie=UTF-8&q='.
                'Assisteja sait '.$assists.' ja asetit vain '. $wards. ' wardia"';
            $msg .= ' "http://translate.google.com/translate_tts?tl=fi&ie=UTF-8&q='.
                'Tapoit vain '.$cscore.' minionia"';
            }sendmsg($msg); 
        }

        $game = $currentGame->currentGame($id);
        $participant = $game->participant($id);
        $gameid = $game->gameId;
        $champion = $api->champion()->championById($participant->championId);
        $champname = str_replace(" ","",str_replace("'","",$champion->championStaticData->name));
        echo "name: " . $champname . "\n";

        $r = $db->query("SELECT champ, gameid FROM leagueoflegends WHERE name = '$nickname'");
        echo "db gameid: ".$r[0]['gameid']." current gameid: ".$gameid."\n";
        echo "db champname: ".$r[0]['champ']." current champname: ".$champname."\n";
        if ($r[0]['gameid'] != $gameid) {
            echo "Updated " . $r[0]['gameid'] . " to $gameid \n";
            $db->exec("UPDATE leagueoflegends SET gameid = $gameid, champ = '$champname' WHERE name = '$nickname'");
            $db->exec("UPDATE teamspeak_changes SET id = id + 1");
            $msg = '"http://translate.google.com/translate_tts?tl=fi&ie=UTF-8&q='.
            'Käyttäjä '.$nickname.' aloitti uuden pelin sankarilla '.$champname.'"';
            sendmsg($msg);
        }
    } catch (Exception $e) {
        echo "Ei pelaa \n";//.$e->getMessage()."\n";
        $r = $db->query("SELECT champ FROM leagueoflegends WHERE name = '$nickname'");
        if ($r[0]['champ'] != NULL) {
            $champname = $r[0]['champ'];
            echo "Cleared champion $champname  \n";
            $db->exec("UPDATE leagueoflegends SET champ = NULL WHERE name = '$nickname'");
            $db->exec("UPDATE teamspeak_changes SET id = id + 1");
        }
    }
    
    echo "\n";
}

echo "\n";
usleep(10000000);
}



function sendmsg($msg) {
    echo "sent message: " . $msg . "\n";
//      return;
    $msg = utf8_decode($msg);
    $socket = socket_create(AF_INET, SOCK_DGRAM, SOL_UDP);
    socket_sendto($socket, $msg, strlen($msg), 0, "91.156.255.202", 1124);
    socket_sendto($socket, $msg, strlen($msg), 0, "91.156.255.202", 1125);
    socket_sendto($socket, $msg, strlen($msg), 0, "91.156.255.202", 1126);
    socket_sendto($socket, $msg, strlen($msg), 0, "91.156.255.202", 1127);
    socket_close($socket);
} 
