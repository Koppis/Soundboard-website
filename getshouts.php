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




function youtube_title($id) {
  $video_info = file_get_contents("http://youtube.com/get_video_info?video_id=".$id);
	parse_str($video_info, $ytarr);
	return $ytarr['title'];
}
