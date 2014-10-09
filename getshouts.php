<?php
if (array_key_exists('dothis',$_GET)){
	switch ($_GET['dothis']){
	case 'getshouts':
		getshouts($_GET['rowcount'],$_GET['kohta']);
		break;
	case 'getsounds':
		getsounds();
		break;
	case 'savesounds':
		savesounds();
		break;
	case 'getusers':
		getusers();
		break;
	case 'getwc':
		getwc($_GET['word']);
		break;
	case 'getemoticons':
		getemoticons();
		break;
	case 'getprocesses':
		getprocesses();
		break;
	}
}


function getshouts($rowcount,$kohta){

	$returnvalue = "";
	class MyDB extends SQLite3{
		function __construct(){
			$this->open('sqlitemain',SQLITE3_OPEN_READONLY);
		}
	}
	$db = new MyDB();
	$db->busyTimeout(5000);
	//Ensin otetaan selvää väreistä
	$result = $db->query("SELECT name,color FROM users");
	  
	$colors = array();
	while ($row = $result->fetchArray())
		$colors[$row['name']] = $row['color'];	
	//Sitten hymiöistä
	$result = $db->query("SELECT * FROM emoticons");
	
	$emotes = array();
	while ($row = $result->fetchArray())
		array_push($emotes,array('sana' => $row['sana'], 'linkki' => $row['linkki']));
	//Sitten katsotaan tarvitsseko päivittää
	$result = $db->query("select count(*) as count from shoutbox");
	$count = $result->fetchArray();
	if ($count['count'] == $rowcount)
		die();
	//Sitten vasta itse viesteistä
	$result = $db->query("SELECT rowid, * FROM shoutbox ORDER BY pvm DESC LIMIT {$kohta}, 50");
	
	
	if ($kohta == 0)
		$returnvalue .= ('<div id="shoutbox"><table value="'.$count['count'].'"><colgroup>
		<col width="20px">
		<col width="15px">
		<col width="200px"></colgroup>
		<thead><tr><td>Date</td><td>User</td><td>Message</td></tr></thead><tbody>'."\n");
	
	
	while($row = $result->fetchArray()) {
	$text = $row['msg'];
	//$text = preg_replace('!(((f|ht)tp(s)?://)[-a-zA-Zа-яА-Я()0-9@:%_+.~#?&;//=]+)!i', '<a href="$1">$1</a>', $text);
		foreach ($emotes as $e)
			$text = str_replace($e['sana'],'<img style="max-height:50px;max-width:50px;" src="'.$e['linkki'].'">',$text);

		if (key_exists($row['user'],$colors))
			$c = $colors[$row['user']];
		else
			$c = "000000";
			
			
		$returnvalue .= ('<tr id="'.$row['rowid'].'"><td>' 
		. $row['pvm'] . '</td><td><span class="'.$row['user'].' username" style="color:'.$c.'">' 
		. $row['user'] . '</span></td><td>' 
		. $text . "</td></tr>\n");
	}
	if ($kohta == 0)
		$returnvalue .= ('</tbody></table></div>');
	
	
		echo $returnvalue;
	
	$db->close();
}

function getusers(){
	
	class MyDB extends SQLite3
	{
		function __construct()
		{
			$this->open('sqlitemain',SQLITE3_OPEN_READONLY);
		}
	}
	$db = new MyDB();
	$db->busyTimeout(5000);
	if (key_exists('focus',$_GET))
		$focus = $_GET['focus'];
	else
		$focus = 1;
	
	if (key_exists('user',$_GET))
		$user = $_GET['user'];
	else
		$user = "";
	
	$color = $_GET['color'];
	date_default_timezone_set("Europe/Helsinki");
	$date = date('Y-m-d H:i:s');
	
	//echo $date.'<br>';
	try {
	$result = @$db->exec("INSERT INTO users (lastseen,name,joindate,focus,color,score) VALUES ('{$date}','{$user}','{$date}','{$focus}','{$color}',100)");
	} catch (Exception $e) {
	echo 'Caught exception: ',  $e->getMessage(), "\n";
	if ($result == FALSE)
		$db->exec("UPDATE users SET lastseen='{$date}',focus='{$focus}',color='{$color}'");
	}
	
	//FIXME! pitäis kattoo onko ajat oikein
	
	$result = $db->query("SELECT name,focus,score from users");
		
	echo '<div id="users">Paikalla: ';
	
	$users = array();
	while ($row = $result->fetchArray()){
		if ($row['focus'] == 1)
			$color = "green";
		else
			$color = "red";
		if ($row['name'] != ""){
			echo "<span style=\"color:{$color}\">".$row['name']." </span> ({$row['score']})";
		}
	}
	echo '</div>';
	$db->close();
}

function getsounds(){
		
	$paths = glob('F:/Program Files (x86)/Apache Group/Apache24/sounds{/*/*,/*}.{mp3,wav,ogg}',GLOB_BRACE);
	
	if (count($paths) == $_GET['rowcount'])
		die();
	
	echo sprintf('<div id="sounds_rowcount" value="%s"></div>',count($paths));
	$sounds = Array();
	$categories = Array();
	foreach ($paths as $p){
		$f = explode("/",$p);
		$path = "";
		for ($i=4;$i<count($f)-1;$i++)
			$path .= ($f[$i]."/");
		$path .= $f[count($f)-1];
		$cat = $f[count($f)-2];
		
		$e = explode(".",$f[count($f)-1]);
		$nimi = str_replace(".".$e[count($e)-1],"",$f[count($f)-1]);
		
		if (!in_array($cat,$categories))
			$categories[] =  $cat;
		
		$s = array('path' => $path, 'cat'=> $cat, 'nimi' => $nimi);
		array_push($sounds, $s);
	}
	
	
	foreach ($categories as $cat){
		echo '<br><button style="padding:2px;min-width:20px;" class="hidecat">-</button><div style="display:inline" ondrop="handleDrop(event)" ondragover="handleDragOver(event)" class="cat" id="'.$cat.'">'. $cat . '<br>';
		foreach ($sounds as $s){
			$path = $s['path'];
			$nimi = $s['nimi'];
			if ($cat !== $s['cat'])
				continue;
				
			echo('
				<button draggable="true" ondragstart="handleDragStart(event)" class="sbutton" id="'.utf8_encode($path).'" value="'.utf8_encode($path).'">'
				.utf8_encode($nimi)
				.'</button>');
		}
		echo "</div>";
	}
	
}

function utf8_urldecode($str) {
	$str = preg_replace("/%u([0-9a-f]{3,4})/i","&#x\\1;",urldecode($str));
	return html_entity_decode($str,null,'UTF-8');
}

function getwc($word){
	
	date_default_timezone_set("Europe/Helsinki");
	class MyDB extends SQLite3
	{
		function __construct()
		{
			$this->open('sqlitemain',SQLITE3_OPEN_READONLY);
		}
	}
	$db = new MyDB();
	$db->busyTimeout(5000);
	$result = $db->query('SELECT msg,pvm FROM shoutbox');
	
	$allwords = "";
	$minutewords = "";
	
	while ($row = $result->fetchArray()){
		
		$allwords .= $row['msg'];
		if (time() - strtotime($row['pvm']) < 60)
			$minutewords .= $row['msg'];
		
	}
	$count = 0;
	$mcount = 0;
	foreach ($word as $w){
		$count += substr_count($allwords,$w);
		$mcount += substr_count($minutewords,$w);
		}
	
	echo $count." Kappa / minute: ".$mcount;
	
	
	
	
	$db->close();
	
}
function getprocesses(){
	putenv('LANG=en_US.UTF-8'); 
	exec("ps a -u ts3serv | grep -i -e aplay -e vlc -e mpg123",$output);
	echo "<ul>";
	foreach($output as $o){
		$o = addslashes($o);
		if (strpos($o,"grep -i -e aplay -e vlc -e mpg123") !== false)
			continue;

		$e = explode(" ",$o);
		
		$pid = $e[0];
		$c=1;
		while ($pid == ""){
			$pid = $e[$c];
			$c++;
		}
		if (strpos($o,"http://translate.google.com/translate_tts?") !== false){
			$e = explode("/usr/bin/mpg123",$o);
			$file = preg_replace("/http:\/\/translate.google.com\/translate_tts\?tl=.{1,5}&ie=UTF-8&q=/","",$e[1]);
		echo "<li><button style='padding:2px;min-width:20px;' class='killprocess' id='".$pid."'>X</button>".$file."</li>";
		}
		else
		{
			$e = explode("/",$o);
			$file = $e[count($e)-1];
			if (strpos($file,"watch?v=") !== false){
				$file = str_replace("watch?v=","",$file);
				$file = youtube_title($file);
			echo "<li><button style='padding:2px;min-width:20px;' class='killprocess' id='".$pid."'>X</button><a href='http://".$e[count($e)-2]."/".$e[count($e)-1]."'>".$file."</a></li>";
			}
			else
			
		echo "<li><button style='padding:2px;min-width:20px;' class='killprocess' id='".$pid."'>X</button>".$file."</li>";
		}
		
	}
	echo "</ul>";
	
	
}

function getemoticons(){
	class MyDB extends SQLite3
	{
		function __construct()
		{
			$this->open('sqlitemain',SQLITE3_OPEN_READONLY);
		}
	}
	$db = new MyDB();
	$db->busyTimeout(5000);
	$result = $db->query('SELECT sana,linkki FROM emoticons');
	echo '<div id="emoticons">';
	while ($row = $result->fetchArray())
		echo '<img style="max-height:50px;max-width:50px" alt="'.$row['sana'].'" src="'.$row['linkki'].'" class="emoticon">';
	echo '</div>';
	$db->close();
	
}


function youtube_title($id) {
  $video_info = file_get_contents("http://youtube.com/get_video_info?video_id=".$id);
	parse_str($video_info, $ytarr);
	return $ytarr['title'];
}
