<?php

require_once('myDatabase.php');

date_default_timezone_set("Europe/Helsinki");
$date = time();


$db = new MyDatabase();


$count = $db->query("select count(*) as count from tj")[0];

    
if ($count['count'] == $_POST['rowcount'])
	die();
	
	
$result = $db->query("SELECT * FROM tj");
echo "TJ<br />";

foreach ($result as $row){

    $kokotj = floor((strtotime($row['loppu'])-strtotime($row['alku']))/(60*60*24));
    $tj = floor((strtotime($row['loppu'])-$date)/(60*60*24));

    if ($tj > $kokotj) $tj = $kokotj;
    if ($tj < 0) $tj = 0;

    if ($tj/$kokotj > 0.5){
        $red = 255;
        $green = floor((1-($tj/$kokotj))*2*255);}
    else{
        $red = floor(($tj/$kokotj)*2*255);
        $green = 255;
        }
        


    if ($tj > $kokotj)
    $tj = $kokotj;
    echo sprintf("<span style='color:#%02X%02X00'>%s : %s/%s - %.1f%% </span><br />",
        $red,$green,$row['nimi'],$tj,$kokotj,($tj*100/$kokotj));
}


$row = $db->query("SELECT * FROM youtube ORDER by rowid DESC")[0];

echo '<a href="'.$row['link'].'">'.$row['name'].'</a>';
$db=NULL;
echo "";
