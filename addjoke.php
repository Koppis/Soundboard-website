<?php

$vitsi = $_POST['vitsi'];
$kieli = $_POST['kieli'];

// $vitsi = $vitsi.replace("\n"," ");


class MyDB extends SQLite3
{
	function __construct()
	{
		$this->open('sqlitemain');
	}
}
$db = new MyDB();

$db->exec("INSERT INTO vitsit (kieli, vitsi) VALUES ('" .
			$kieli . "','" . $vitsi . "')");

$db->close();

?>