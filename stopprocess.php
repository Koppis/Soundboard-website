<?php

$msg = "kill ".$_GET['pid'];

$socket = socket_create(AF_INET, SOCK_DGRAM, SOL_UDP);
socket_sendto($socket, $msg, strlen($msg), 0, "91.156.255.202", 1124);
socket_sendto($socket, $msg, strlen($msg), 0, "91.156.255.202", 1125);
socket_sendto($socket, $msg, strlen($msg), 0, "91.156.255.202", 1126);
socket_sendto($socket, $msg, strlen($msg), 0, "91.156.255.202", 1127);
socket_close($socket);