<?php


error_reporting(E_ALL | E_STRICT);
set_error_handler("warning_handler", E_WARNING);

$socket = socket_create(AF_INET, SOCK_DGRAM, SOL_UDP);
socket_set_option($socket,SOL_SOCKET,SO_RCVTIMEO,array("sec"=>35,"usec"=>0));
socket_bind($socket, '0.0.0.0', 1337);

require_once('myDatabase.php');

$db = new myDatabase();


function warning_handler($errno, $errstr) { 
		print('WARNING '.$errno.': '.$errstr);
	if ($errno !== 2)
		print('WARNING '.$errno.': '.$errstr);
	
	socket_set_option($GLOBALS['socket'],SOL_SOCKET,SO_RCVTIMEO,array("sec"=>35,"usec"=>0));
    $GLOBALS['db']->exec("UPDATE online SET status=0");
    if ($GLOBALS['db']->exec("DELETE FROM processes") > 0)
        $GLOBALS['db']->exec("UPDATE processes_revision SET revision = revision + 1");

}

while (true) {                                                            
    $from = '';
    $port = 0;
    $time = time();
    socket_recvfrom($socket, $buf, 50, 0, $from, $port);
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
    if ($buf == "quit") {
        $db->exec("UPDATE online SET status=0");
        if ($db->exec("DELETE FROM processes") > 0)
            $db->exec("UPDATE processes_revision SET revision = revision + 1");
    }else{
        $db->exec("UPDATE online SET status=1");
    }
    
    if ($buf == "rs") {
    	$db->exec("UPDATE record SET status=1");
        
    } elseif (substr($buf,0,2) == "rd") {
    	$db->exec("UPDATE record SET status=0");
        if (strlen($buf) > 2){ 
            $name = substr($buf,2);
            $db->exec("INSERT INTO recordings (date,name) VALUES (date(),'$name')");
        }else{
            $db->exec("INSERT INTO recordings (date) VALUES (date())");
        }
        $rowid = $db->query("SELECT rowid FROM recordings ORDER BY rowid DESC LIMIT 1")[0]['rowid'];
        $db->exec("UPDATE changes SET revision = revision + 1, id = $rowid WHERE name = 'recordings'");
    } elseif (substr($buf,0,5) == "start") {
        $arr = explode(" ",$buf,3);
        $pid = $arr[1];
        $name = array_pop(explode("\\",array_pop(explode("/",$arr[2]))));
        if (substr($arr[2],0,2) == "yt")
            $db->exec("INSERT INTO processes (pid,name) VALUES ($pid,'yt$name')");
        else
            $db->exec("INSERT INTO processes (pid,name) VALUES ($pid,'$name')");
        $db->exec("UPDATE processes_revision SET revision = revision + 1");
    } elseif (substr($buf,0,4) == "kill") {
        $pid = substr($buf,5);
        $db->exec("DELETE FROM processes WHERE pid=$pid");
        $db->exec("UPDATE processes_revision SET revision = revision + 1");
    }

}
$db = NULL;
socket_close($socket);
