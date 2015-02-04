<?php



if (!isset($_SERVER["HTTP_HOST"])) {
  parse_str($argv[1], $_GET);
  parse_str($argv[1], $_POST);
}

if (key_exists('dothis',$_POST))
	$choice = $_POST['dothis'];
else{
	die("You didn't specify a dothis");
}

require_once('myDatabase.php');

$db = new myDatabase();



switch ($_POST['dothis']){

case 0: // Add an emoticon
    $linkki = $_POST['linkki'];
    $arr = explode(".",$linkki);
    $fname = "/images/emoticons/".$_POST['sana'].".".$arr[count($arr)-1];
    $image = file_get_contents($linkki);
    file_put_contents("/var/www".$fname, $image); //Where to save the image on your server
    shell_exec("convert /var/www$fname -resize 50x50\> /var/www$fname");
    $db->exec(sprintf("INSERT INTO emoticons VALUES ('%s','%s')",$_POST['sana'],$fname));
    $db->exec("UPDATE changes SET revision = revision + 1 WHERE name = 'emoticons'");
break;

case 1: // Remove an emoticon
    $res = $db->query(sprintf("SELECT linkki FROM emoticons WHERE sana='%s'",$_POST['sana']));
    $db->exec(sprintf("DELETE FROM emoticons WHERE sana='%s'",$_POST['sana']));
    $arr = explode("/",$res[0]['linkki']);
    unlink("/var/www/images/emoticons/" . $arr[count($arr)-1]);

    $db->exec("UPDATE changes SET revision = revision + 1 WHERE name = 'emoticons'");
break;

}

$db = NULL;
