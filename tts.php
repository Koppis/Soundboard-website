<?php
if (!function_exists('puolita')){
function puolita($delim,$string){
	$sanat = multipleExplodeKeepDelimiters($delim,$string);
	
	foreach( $sanat as $n){
		echo strlen($n) . "   " .  $n . '<br>';
	}
	$ret = array();
	$puolisko = "";
	for ($index=0;$index<(count($sanat));$index++){
		if (strlen($puolisko) + strlen($sanat[$index]) < 100){
			$puolisko .= $sanat[$index];
			echo 'puolisko: ' . $puolisko . '<br>';
		} else {
			if (strlen($puolisko)>0)
				array_push($ret, $puolisko);
			$puolisko = $sanat[$index];
		}
	}
	array_push($ret, $puolisko);
	foreach($ret as $n){
		echo strlen($n) . "   return:   " .  $n . '<br>';
	}
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
 //function katko ($vitsi){
	$vitsi = str_replace('"',"'",$_POST['vitsi']);
	if (strlen($vitsi) == 1)
		$vitsi = str_replace('?'," kysymysmerkki ",$vitsi);
	if (key_exists('kieli',$_POST))
	$kieli = $_POST['kieli'];
	else
	$kieli = 'fi';
	
	
	if ($vitsi == "**random**"){
		 
		$db = new PDO('sqlite:sqlitemain');
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
		if (strpos($word,"#") !== false ){
			$counter++;
			$vitsi[$counter] .= $word." ";
			$counter++;
		} else {
			$vitsi[$counter] .= $word." ";
			
		}
			
	}
	
	$punctuation = array(".", ";", ":", "?", "!");
	
	$lauseet = array();
	foreach ($vitsi as $v){
		echo $v.'<br>';
		$lause = multipleExplodeKeepDelimiters($punctuation, $v);
		foreach ($lause as $l){
		echo $l.'<br>';
			array_push($lauseet, $l);
		}
	}
	
	foreach( $lauseet as $n){
		echo $n . '<br>'; 
	}
	echo '<p>';
	
	$newlauseet = array();
	foreach ($lauseet as $l){
		
		if (strlen($l) > 100){
			foreach (puolita(",",$l) as $p){
				array_push($newlauseet, $p);	
			}
		}
		else	// lause, on jo alle 101 merkkiä, iauhdaisudh
			array_push($newlauseet, $l);
	}
	$newnewlauseet = array();
	foreach ($newlauseet as $l){
		
		if (strlen($l) > 100){
			foreach (puolita(" ",$l) as $p){
				array_push($newnewlauseet, $p);	
			}
		}
		else	// lause, on jo alle 101 merkkiä, iauhdaisudh
			array_push($newnewlauseet, $l);
	
	}
	$newnewnewlauseet = array();
	foreach ($newnewlauseet as $l){
		
		if (strlen($l) > 100){
			$s = chunk_split($l,100,chr(1));
			foreach (explode(chr(1),$s) as $p){
				array_push($newnewnewlauseet, $p);	
			}
		}
		else	// lause, on jo alle 101 merkkiä, iauhdaisudh
			array_push($newnewnewlauseet, $l);
	
	}
	
	
	echo '<p>valmis<br>';
	$execstr = "";
	foreach( $newnewnewlauseet as $n){
		$execstr .= (' "http://translate.google.com/translate_tts?tl='
			.$kieli.'&ie=UTF-8&q=' . $n . '"' );
		
	}
	if (key_exists('badumtss',$_POST))
		if ($_POST['badumtss'] == 1) 
			$execstr .= (' "F:\\Program Files (x86)\\Apache Group\\Apache24\\sounds\\badumtss.mp3"');
		
	echo '<p>'.$execstr;
	//$count = shell_exec('ps aux | grep -i -e aplay -e vlc -e mpg123 | wc -l');
	//if ($count < 15){
		$execstr = utf8_decode($execstr);
		$socket = socket_create(AF_INET, SOCK_DGRAM, SOL_UDP);
		socket_sendto($socket, $execstr, strlen($execstr), 0, "91.156.255.202", 1124);
		socket_sendto($socket, $execstr, strlen($execstr), 0, "91.156.255.202", 1125);
		socket_sendto($socket, $execstr, strlen($execstr), 0, "91.156.255.202", 1126);
		socket_sendto($socket, $execstr, strlen($execstr), 0, "91.156.255.202", 1127);
		socket_close($socket);
		//exec($execstr);
	//}

?>