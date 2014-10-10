<?php


error_reporting(E_ALL | E_STRICT);
set_error_handler("warning_handler", E_WARNING);

$socket = socket_create(AF_INET, SOCK_DGRAM, SOL_UDP);
socket_set_option($socket,SOL_SOCKET,SO_RCVTIMEO,array("sec"=>35,"usec"=>0));
socket_bind($socket, '0.0.0.0', 1337);

$db = new PDO('sqlite:/var/www/db/sqlitemain');
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
$db->exec("pragma synchronous = off;");


function warning_handler($errno, $errstr) { 
	if ($errno !== 2)
		print('WARNING '.$errno.': '.$errstr);
	
	socket_set_option($GLOBALS['socket'],SOL_SOCKET,SO_RCVTIMEO,array("sec"=>35,"usec"=>0));
	$GLOBALS['db']->exec("UPDATE online SET status=0");

}

while (true) {                                                            
    $from = '';
    $port = 0;
    $time = time();
    socket_recvfrom($socket, $buf, 4, 0, $from, $port);
    if ($from == '') continue;
    echo "Received $buf from remote address $from and remote port $port" . PHP_EOL;
    if ($from !== '91.156.255.202') {
    	#pitaa ottaa huomioon muualta tulevat udp-paketit, jotka resetoivat timeoutin
    	$secs = socket_get_option($GLOBALS['socket'],SOL_SOCKET,SO_RCVTIMEO)['sec'] -
    			(time() - $time);
    	print('secs : ' . $secs);
    	socket_set_option($GLOBALS['socket'],SOL_SOCKET,SO_RCVTIMEO,array("sec"=>$secs,"usec"=>100));
    	continue;
    }
    
    socket_set_option($GLOBALS['socket'],SOL_SOCKET,SO_RCVTIMEO,array("sec"=>35,"usec"=>0));
    if ($buf == "quit") 
        $db->exec("UPDATE online SET status=0");
    else
        $db->exec("UPDATE online SET status=1");
    
    
    if ($buf == "rs") {
    	$db->exec("UPDATE record SET status=1");
        
    } elseif ($buf == "rd") {
    	$db->exec("UPDATE record SET status=0");
    	$db->exec("INSERT INTO recordings VALUES (1)");
        $db->exec("UPDATE changes SET revision = revision + 1 WHERE name = 'recordings'");
    }

}
$db = NULL;
socket_close($socket);