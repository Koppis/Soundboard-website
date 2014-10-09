<?php

//VERSION
$version = 11;

if (intval($_POST['ver']) < $version)
	echo 1;
else
	echo 0;