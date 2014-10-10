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
    $db->exec(sprintf("INSERT INTO emoticons VALUES ('%s','%s')",$_POST['sana'],$_POST['linkki']));
    $db->exec("UPDATE changes SET revision = revision + 1 WHERE name = 'emoticons'");
break;

case 1: // Remove an emoticon
    $db->exec(sprintf("DELETE FROM emoticons WHERE sana='%s'",$_POST['sana']));
    $db->exec("UPDATE changes SET revision = revision + 1 WHERE name = 'emoticons'");
break;

}

$db = NULL;
