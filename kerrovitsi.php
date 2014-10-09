<?php

$con = mysqli_connect('localhost','root','kissa123','www');
if (mysqli_connect_errno()) {
  echo "Failed to connect to MySQL: " . mysqli_connect_error() . '<br>';
}

$tulos = mysqli_query($con,
'SELECT kieli,vitsi FROM vitsit
ORDER BY RAND()
LIMIT 1'
);

mysqli_close($con);

$vitsi = mysqli_fetch_array($tulos);
mysqli_query(sprintf("UPDATE vitsit SET used=1 WHERE vitsiid=%s",
	$vitsi['vitsiid']));

echo $vitsi['kieli'] .  $vitsi['vitsi'];

exec('/usr/bin/mpg123 "http://translate.google.com/translate_tts?tl='.
	$vitsi['kieli'].'&ie=UTF-8&q='.$vitsi['vitsi'].'" sounds/badumtss.mp3 &' );


?>