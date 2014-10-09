<?php
//init
$con = mysqli_connect('localhost','root','kissa123','www');
if (mysqli_connect_errno()) {
  echo "Failed to connect to MySQL: " . mysqli_connect_error() . '<br>';
}

date_default_timezone_set("Europe/Helsinki");
$date = date('Y-m-d H:i:s');
//endof init

function uusipeli($con,$date){
	$result = mysqli_query($con,
	"SELECT value FROM numeropeli_stats WHERE id = 'potti'");
	$row = mysqli_fetch_array($result);
	$potti = "";
	if ($row['value'] > 0)
	$potti = "Potti: ".$row['value'];
	
	$rand = rand(1,100);
	mysqli_query($con,
		"DELETE FROM numeropeli");
	mysqli_query($con,
		"INSERT INTO numeropeli VALUES ('ADMIN',{$rand})");
	$result = mysqli_query($con,
		"SELECT name FROM users 
		WHERE TIMESTAMPDIFF(SECOND,joindate,'{$date}') > 1
		AND TIMESTAMPDIFF(SECOND,lastseen,'{$date}') < 5
		AND name != '' LIMIT 5");
	
	while ($row = mysqli_fetch_array($result)){
		echo $row['name'];
		mysqli_query($con,
			"INSERT INTO numeropeli (name) VALUES ('{$row['name']}')");
	}
	chat($con,$date,"Uusi peli, random väliltä 1-100. Arvatkaa! ".$potti);
}

if ($_POST['peli'] == "uusi")
{
uusipeli($con,$date);
} elseif ($_POST['peli'] == "arvaus") {
	
$arvaus = intval($_POST['arvaus']);
echo($arvaus);

if ($arvaus < 101 && $arvaus > 0 && count(mysqli_fetch_array(mysqli_query($con,"SELECT * FROM numeropeli"))) > 0){

	if (count(mysqli_fetch_array(mysqli_query($con,
		"SELECT * FROM numeropeli WHERE arvaus={$arvaus} AND name!='ADMIN'
		OR arvaus IS NOT NULL AND name='{$_POST['name']}'"))) != 0){
	chat($con,$date,"Arvasit jo tai arvasit saman kuin joku muu.");
	exit;
		}
	
	mysqli_query($con,
			"UPDATE numeropeli
			SET arvaus={$_POST['arvaus']}
			WHERE name='{$_POST['name']}'
			AND arvaus IS NULL");
	
	$result = mysqli_query($con,
		"SELECT name FROM numeropeli
		WHERE arvaus IS NULL");
	$users = "";
	while ($row = mysqli_fetch_array($result))
		$users .= " " . $row['name'];
	//chat($con,$date,"{$_POST['name']}:n arvaus: {$_POST['arvaus']}.");
	if ($users != ""){
	
	chat($con,$date," Jäljellä arvaamassa: {$users}");
	}
	else
	{
	$result = mysqli_query($con,
		"SELECT arvaus FROM numeropeli
		WHERE name='ADMIN'");
	$row = mysqli_fetch_array($result);
	$rand = $row['arvaus'];
	
	//echo $rand;
	
	$result = mysqli_query($con,
		"SELECT name,arvaus FROM numeropeli
		WHERE name!='ADMIN'");
	
	$winner ="";
	$losers = 0;
	$losestr = "";
	while ($row = mysqli_fetch_array($result)){
		if ($row['arvaus'] == $rand)
			$winner = $row['name'];
		else{
			if ($losers == 0)
			$losestr .= "name='".$row['name']."'";
			else
			$losestr .= " OR name='".$row['name']."'";
			
			$losers++;
			
		}
		
	}
	
	if ($winner != ""){
	$result = mysqli_query($con,
				"SELECT value FROM numeropeli_stats WHERE id = 'potti'");
	$row = mysqli_fetch_array($result);
	$losers += $row['value'];
	chat($con,$date,"Oikea vastaus {$rand}, Voittaja on {$winner}! (+".$losers.")
 #fanfares");
	tts("#fanfares");
	mysqli_query($con,
		"UPDATE users SET score=score-1 WHERE {$losestr}");
	mysqli_query($con,
		"UPDATE users SET score=score+{$losers} WHERE name='{$winner}'");
	mysqli_query($con,
		"DELETE FROM numeropeli");
	mysqli_query($con,
		"UPDATE numeropeli_stats SET value = 0 WHERE id = 'potti'");
	
	}
	else
	{
		chat($con,$date,"Oikea vastaus {$rand}, Ei voittajia");
		tts("#ai");
		if ($losers > 1){
			mysqli_query($con,
				sprintf("UPDATE numeropeli_stats SET value = 1 WHERE value = 0 AND id = 'potti'",$losers));
			mysqli_query($con,
				sprintf("UPDATE numeropeli_stats SET value = value * %s WHERE id = 'potti'",$losers));
				

			
			uusipeli($con,$date);
		}
		else
		{
			mysqli_query($con,
			"DELETE FROM numeropeli");
		}
	}
	}
	
	
	

}
}

function chat ($con,$date,$msg){
	mysqli_query($con,"INSERT INTO shoutbox (pvm,user, msg) VALUES (
		'{$date}','ADMIN','{$msg}')");
}
function tts($msg){
	$_POST['kieli'] = "fi";
	$_POST['vitsi'] = $msg;
	include('tts.php');
}



