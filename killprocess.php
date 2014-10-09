<?php

$pid = $_POST['pid'];


exec("ps -u ts3serv | awk '{ print $1 }'",$output);
echo $pid;
if (in_array($pid,$output)){
	echo "asd";
	exec("kill ".$pid);
	}