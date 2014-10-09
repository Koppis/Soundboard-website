<?php
if (key_exists('dothis',$_POST))
	$choice = $_POST['dothis'];
else{
	die("You didn't specify a dothis");
}





switch ($_POST['dothis']){
	
	
	
case 0: // Get emoticonsa
if (!class_exists('MyDB')){
	class MyDB extends SQLite3
	{
		function __construct()
		{
			$this->open('sqlitemain',SQLITE3_OPEN_READONLY);
		}
	}
	
}
$db = new MyDB();
	$db->busyTimeout(500);
$result = $db->query("SELECT count(*) as count FROM emoticons");
$count = $result->fetchArray();



$result = $db->query("SELECT * FROM emoticons");

	
echo '<table value="' . $count['count'] . '">';
?>

<colgroup>
	<col width="10px">
	<col width="10px">
	<col width="10px">
	<col width="1000px">
</colgroup><tbody>

<?php

while ($row = $result->fetchArray()){
	echo sprintf('<tr>
	<td>%s</td>
	<td><img style="max-width:50px;max-height:50px"src="%s"/></td>
	<td><button class="deleteemo">X</button></td>
	<td>%s</td></tr>',
	$row['sana'],$row['linkki'],$row['linkki']);
}
?>
</tbody></table>
<?php
break;

case 1: // Remove an emoticon
if (!class_exists('MyDB')){
	class MyDB extends SQLite3
	{
		function __construct()
		{
			$this->open('sqlitemain');
		}
	}
	
}
$db = new MyDB();
	$db->busyTimeout(500);
$db->exec(sprintf("DELETE FROM emoticons WHERE sana='%s'",$_POST['sana']));


break;

case 2: // Add an emoticon
if (!class_exists('MyDB')){
	class MyDB extends SQLite3
	{
		function __construct()
		{
			$this->open('sqlitemain');
		}
	}
	
}
$db = new MyDB();
	$db->busyTimeout(500);
$db->exec(sprintf("INSERT INTO emoticons VALUES ('%s','%s')",$_POST['sana'],$_POST['linkki']));


break;

}

$db->close();