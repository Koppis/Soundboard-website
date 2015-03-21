<?php
$oldtime = $_GET['time'];
$delay = round(microtime(true) * 1000) - $oldtime;

echo $delay;

