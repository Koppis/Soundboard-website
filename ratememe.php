<?php 
require_once("myDatabase.php");
$db = new myDatabase();


print "lel".PHP_EOL;

$rec = (isset($_POST['rec']) && !empty($_POST['rec'])) ? $_POST['rec'] : -1;
$vitsi = (isset($_POST['vitsi']) && !empty($_POST['vitsi'])) ? $_POST['vitsi'] : -1;
$user = (isset($_POST['user']) && !empty($_POST['user'])) ? $_POST['user'] : "";
$rating = (isset($_POST['rating'])) ? intval($_POST['rating']) : -1;

echo "rec = ".$rec.PHP_EOL."user = ".$user.PHP_EOL."rating = ".$rating.PHP_EOL;

$kumpi = "rec";
if ($rec == -1){
    $rec = $vitsi;
    $kumpi = "vitsi";
}

if ($rec == -1 || $user == "") die();

if ($rating < 0) $rating = 0;
if ($rating > 10) $rating = 10;

if (($db->exec("UPDATE memeratings SET rating = $rating WHERE $kumpi = $rec AND user = '$user'" )) == 0)
    $db->exec("INSERT INTO memeratings (user,$kumpi,rating) VALUES ('$user',$rec,$rating)");

$results = $db->query("SELECT * FROM memeratings WHERE $kumpi = $rec");

$rating = 0;
$count = 0;
$nollia = 0;

foreach ($results as $row){
    $rating += $row['rating'];
    $count ++;
    if ($row['rating'] < 1)
        $nollia ++;
}
$rating = intval($rating / $count);

if ($vitsi == -1) {
if ($nollia > 1) {
    $res = $db->query("SELECT nickname, recordings.name FROM ".
    "(memeratings JOIN users ON memeratings.user = users.name) ".
    "JOIN recordings ON memeratings.rec = recordings.rowid WHERE ".
    "rec = $rec ORDER BY memeratings.rowid LIMIT 1;");
    $nick = $res[0]['nickname'];
    $meme = $res[0]['name'];
    $msg = '"http://translate.google.com/translate_tts?tl=fi&ie=UTF-8&q='.
            'hyi sinua '.$nick.', memesi '.$meme.' on saanut 0 tähteä '.$nollia.' käyttäjältä "';
    $msg .= ' "http://translate.google.com/translate_tts?tl=fi&ie=UTF-8&q='.
            ' mene pois surkeiden memejesi kanssa homo"';
    //$msg .= ' "F:\\Program Files (x86)\\Apache Group\\Apache24\sounds\\Music\\mememon.mp3"';
    sendmsg($msg);
    sendmsg("sounds/mlg/2SAD4ME.mp3");
}
if ($rating == 10 || $count == 1) {
    $res = $db->query("SELECT nickname, recordings.name FROM ".
    "(memeratings JOIN users ON memeratings.user = users.name) ".
    "JOIN recordings ON memeratings.rec = recordings.rowid WHERE ".
    "rec = $rec ORDER BY memeratings.rowid LIMIT 1;");
    $nick = $res[0]['nickname'];
    $meme = $res[0]['name'];
    $msg = "";
    if ($count == 1) {
        $msg = '"http://translate.google.com/translate_tts?tl=fi&ie=UTF-8&q='.
            'Käyttäjä '.$nick.' teki uuden memen. '.$meme.'"';
        $msg .= (rand(0,3) == 0) ? kehu() : "";
    } else {
        $msg = '"http://translate.google.com/translate_tts?tl=fi&ie=UTF-8&q=O'.
            'nnittelut '.$nick.'!" "http://translate.google.com/translate_tts?tl=fi&ie=UTF-8&q='.
            'Memesi '.$meme.' sai viisi tähteä '.$count.' käyttäjältä"';
            
        
        $msg .= kehu();

        $msg .= ' "F:\\Program Files (x86)\\Apache Group\\Apache24\sounds\\Music\\mememon.mp3"';
    }
    
    
    sendmsg($msg);

}
}

if ($rating <= 2){
    $db->exec("DELETE FROM memes WHERE $kumpi = $rec");
    $db->exec("UPDATE memes SET rating = rating + 1 WHERE rowid = 1");
} else {
    if (($db->exec("UPDATE memes SET rating = $rating WHERE $kumpi = $rec" )) == 0)
        $db->exec("INSERT INTO memes ($kumpi,rating) VALUES ($rec,$rating)");
    //$db->exec("UPDATE memes SET rating = rating + 1 WHERE rowid = 1");

}

function sendmsg($msg) {
    $msg = utf8_decode($msg);
    $socket = socket_create(AF_INET, SOCK_DGRAM, SOL_UDP);
    socket_sendto($socket, $msg, strlen($msg), 0, "91.156.255.202", 1124);
    socket_sendto($socket, $msg, strlen($msg), 0, "91.156.255.202", 1125);
    socket_sendto($socket, $msg, strlen($msg), 0, "91.156.255.202", 1126);
    socket_sendto($socket, $msg, strlen($msg), 0, "91.156.255.202", 1127);
    socket_close($socket);
} 

function kehu() {
    $msg = ' "http://translate.google.com/translate_tts?tl=fi&ie=UTF-8&q=';
    switch (rand(0,6)) {
        case 0:
            $msg .=  'hyi vittu mikä meme, mut silti niin hyvä! viis kautta viis"';
        break;
        case 1:
            $msg .= 'haha meme overload"';
        break;
        case 2:
            $msg .= 'meme ei ollut käytössä, mutta nyt se on taas"';
        break;
        case 3:
            $msg .= 'joku pistää vähä memeä koneesee!"';
        break;
        case 4:
            $msg .= 'olet eeppinen memettäjä"';
        break;
        case 5:
            $msg .= 'meet kyl memelläs toppii!"';
        break;
        case 6:
            $msg .= 'viddu migä meme mage!"';
        break;
    }
    return $msg;
}
