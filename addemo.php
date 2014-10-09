<?php



class MyDB extends SQLite3
{
	function __construct()
	{
		$this->open('sqlitemain');
	}
}
$db = new MyDB();




if (key_exists('remove',$_POST)){
	$db->exec("DELETE FROM emoticons WHERE sana='{$_POST['remove']}'");
}else{
$sana = addslashes($_POST['sana']);
$linkki = addslashes($_POST['linkki']);
$db->exec("INSERT INTO emoticons VALUES ('{$sana}','{$linkki}')");
}

$db->close();

header("Location: index.php"); 