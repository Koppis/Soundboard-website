<?php

include('getshouts.php');

$path = "/var/www/html/sounds/" . $_POST['path'];

$f = explode("/",$path);
$fname = $f[count($f)-1];
if ($_POST['cat'] == 'sounds')
	$newpath = "/var/www/html/sounds/" . $fname;
else
	$newpath = "/var/www/html/sounds/" . $_POST['cat'] . "/" . $fname;

if (rename($path,$newpath)){
	
	$con = mysqli_connect('localhost','root','kissa123','www');
	if (mysqli_connect_errno()) {
	  echo "Failed to connect to MySQL: " . mysqli_connect_error() . '<br>';
	}
	
	
	$result = mysqli_fetch_array(
		mysqli_query($con, "SELECT paikka FROM sounds WHERE path='{$_POST['target']}'"));
	$target = $result['paikka'];
	
	$result = mysqli_fetch_array(
		mysqli_query($con, "SELECT paikka FROM sounds WHERE path='{$_POST['path']}'"));
	$file = $result['paikka'];
	if ($target < $file){
	mysqli_query($con, "UPDATE sounds SET paikka=paikka+1 WHERE paikka>={$target} AND paikka<{$file}");
	mysqli_query($con, "UPDATE sounds SET paikka={$target},cat='{$_POST['cat']}' WHERE path='{$_POST['path']}'");
	}
	else{
	mysqli_query($con, "UPDATE sounds SET paikka=paikka-1 WHERE paikka<{$target} AND paikka>{$file}");
	mysqli_query($con, "UPDATE sounds SET paikka=".($target-1).",cat='{$_POST['cat']}' WHERE path='{$_POST['path']}'");
	}
	
	
	//echo $_POST['target'].' = '.$target.'<br>'.
	//	 $_POST['path'].' = '.$file.'<br>';
}
getsounds();
	