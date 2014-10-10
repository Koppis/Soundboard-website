<?php

require_once('myDatabase.php');


$rowcount = $_GET['rowcount'];
$kohta = $_GET['kohta'];

$returnvalue = "";
$db = new MyDatabase();
//Ensin otetaan selvää väreistä
$result = $db->query("SELECT name,color FROM users");
  
$colors = array();

foreach ($result as $row)
    $colors[$row['name']] = $row['color'];	

//Sitten hymiöistä
$result = $db->query("SELECT * FROM emoticons");

$emotes = array();

foreach ($result as $row)
    array_push($emotes,array('sana' => $row['sana'], 'linkki' => $row['linkki']));

//Sitten katsotaan tarvitsseko päivittää
$count = $db->query("select count(*) as count from shoutbox")[0];
if ($count['count'] == $rowcount)
    die();

//Sitten vasta itse viesteistä
$result = $db->query("SELECT rowid, * FROM shoutbox ORDER BY pvm DESC LIMIT {$kohta}, 500");


if ($kohta == 0)
    $returnvalue .= ('<div id="shoutbox"><table value="'.$count['count'].'"><colgroup>
    <col width="20px">
    <col width="15px">
    <col width="200px"></colgroup>
    <thead><tr><td>Date</td><td>User</td><td>Message</td></tr></thead><tbody>'."\n");


foreach ($result as $row) {
$text = $row['msg'];
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



$db = NULL;


die($returnvalue);



