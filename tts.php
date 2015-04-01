<?php
if (!function_exists('puolita')){
function puolita($delim,$string){
	$sanat = multipleExplodeKeepDelimiters($delim,$string);
	
	$ret = array();
	$puolisko = "";
	for ($index=0;$index<(count($sanat));$index++){
		if (strlen($puolisko) + strlen($sanat[$index]) < 100){
			$puolisko .= $sanat[$index];
		} else {
			if (strlen($puolisko)>0)
				array_push($ret, $puolisko);
			$puolisko = $sanat[$index];
		}
	}
	array_push($ret, $puolisko);
	return $ret;
	
}}
if (!function_exists('multipleExplodeKeepDelimiters')){
function multipleExplodeKeepDelimiters($delimiters, $string) {
    $initialArray = explode(chr(1), str_replace($delimiters, chr(1), $string));
    $finalArray = array();
    foreach($initialArray as $item) {
        if(strlen($item) > 0 && $item != " ") 
        	array_push($finalArray, 
        		$item . $string[strpos($string, $item) +strlen($item)]);
    }
    return $finalArray;
}}
$vitsi = str_replace('"',"'",$_POST['vitsi']);
$vitsi = utf8_strrev($vitsi);
    function utf8_strrev($str){
            preg_match_all('/./us', $str, $ar);
                return join('', array_reverse($ar[0]));
    }

if (strlen($vitsi) == 1)
    $vitsi = str_replace('?'," kysymysmerkki ",$vitsi);
if (key_exists('kieli',$_POST))
$kieli = $_POST['kieli'];
else
$kieli = 'fi';


if ($vitsi == "**random**"){
     
    $db = new PDO('sqlite:/var/www/db/sqlitemain');
    $db->exec("pragma synchronous = off;");
    
    $r = $db->query(
    'SELECT rowid, * FROM vitsit
    WHERE used IS NOT 1
    ORDER BY RANDOM()
    LIMIT 1'
    );
    $arr = $r->fetch();
    if (empty($arr)){
        $db->exec(
            "UPDATE vitsit set used=0");
        $r = $db->query(
        'SELECT rowid, * FROM vitsit
        WHERE used IS NOT 1
        ORDER BY RANDOM()
        LIMIT 1'
        );
        $arr = $r->fetch();
    }
    
    
    $db->exec(sprintf("UPDATE vitsit SET used=1 WHERE rowid=%s",
        $arr['rowid']));
    $db = NULL;
    
    $vitsi = $arr['vitsi'];
    $kieli = $arr['kieli'];
}

echo $vitsi.'<br>';

$ex = explode(" ",$vitsi);
$vitsi = array();
$counter = 0;
foreach ($ex as $word){
    /*if (strpos($word,"#") !== false ){
        $counter++;
        $vitsi[$counter] .= $word." ";
        $counter++;
    } else {*/
        $vitsi[$counter] .= $word." ";
        
    
        
}

$punctuation = array(".", ";", ":", "?", "!");

$lauseet = array();
//Ensin puolitetaan merkkijono ".", ";", ":", "?", "!" kohdalta
foreach ($vitsi as $v){
    $lause = multipleExplodeKeepDelimiters($punctuation, $v);
    foreach ($lause as $l){
        array_push($lauseet, $l);
    }
}	
$newlauseet = array();
//Sitten pilkkujen kohdalta, jos tarvitsee
foreach ($lauseet as $l){
    
    if (strlen($l) > 100){
        foreach (puolita(",",$l) as $p){
            array_push($newlauseet, $p);	
        }
    }
    else
        array_push($newlauseet, $l);
}
$newnewlauseet = array();
//Then spaces, if needed.
foreach ($newlauseet as $l){
    
    if (strlen($l) > 100){
        foreach (puolita(" ",$l) as $p){
            array_push($newnewlauseet, $p);	
        }
    }
    else
        array_push($newnewlauseet, $l);

}
$newnewnewlauseet = array();
//Finally split on every character (for words longer than 100 characters)
foreach ($newnewlauseet as $l){
    
    if (strlen($l) > 100){
        $s = chunk_split($l,100,chr(1));
        foreach (explode(chr(1),$s) as $p){
            array_push($newnewnewlauseet, $p);	
        }
    }
    else
        array_push($newnewnewlauseet, $l);

}


echo '<p>valmis<br>'.PHP_EOL;
$execstr = "";
foreach( $newnewnewlauseet as $n){
    $sounds = array();
    $i = 0;
    echo "n = $n".PHP_EOL;
    if (preg_match_all("/#(\S*)/",$n,$sounds) > 0){
        echo json_encode($sounds);
        foreach (preg_split("/#\S*/",$n) as $a){
            echo "a = $a".PHP_EOL;
            if ($a == "") continue;
            $execstr .= (' "http://translate.google.com/translate_tts?tl='
                .$kieli.'&ie=UTF-8&q=' . $a . '"' );
            $execstr .= (' "F:\\Program Files (x86)\\Apache Group\\Apache24\\sounds\\recorded\\'.$sounds[1][$i].'.wav"');
            $i ++;
        }
    } else {
        $execstr .= (' "http://translate.google.com/translate_tts?tl='
        .$kieli.'&ie=UTF-8&q=' . $n . '"' );
    }
    //$execstr .= (' "http://translate.google.com/translate_tts?tl='
     //   .$kieli.'&ie=UTF-8&q=' . $n . '"' );
    
}
if (key_exists('badumtss',$_POST))
    if ($_POST['badumtss'] == 1) 
        $execstr .= (' "F:\\Program Files (x86)\\Apache Group\\Apache24\\sounds\\badumtss.mp3"');
    
echo '<p>'.$execstr.PHP_EOL;
$execstr = utf8_decode($execstr);
$socket = socket_create(AF_INET, SOCK_DGRAM, SOL_UDP);
socket_sendto($socket, $execstr, strlen($execstr), 0, "91.156.255.202", 1124);
socket_sendto($socket, $execstr, strlen($execstr), 0, "91.156.255.202", 1125);
socket_sendto($socket, $execstr, strlen($execstr), 0, "91.156.255.202", 1126);
socket_sendto($socket, $execstr, strlen($execstr), 0, "91.156.255.202", 1127);
socket_close($socket);

?>
