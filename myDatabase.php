<?php

function initDB ($db) {
    $schema = array("CREATE TABLE changes (name VARCHAR PRIMARY KEY, revision INT)",
    "create table cookiedata (identifier varchar PRIMARY KEY, recordinglayout varchar)",
    "INSERT INTO changes VALUES ('vitsit',0)",
    "INSERT INTO changes VALUES ('emoticons',0)",
    "INSERT INTO changes VALUES ('recordings',0)",
    "CREATE TABLE recordings (name varchar(255) DEFAULT '')",
    "CREATE TABLE `emoticons` (  `sana` varchar(255) NOT NULL DEFAULT '',  `linkki` varchar(255) NOT NULL)",
    "CREATE TABLE lol (nimi CHAR(100))",
    "CREATE TABLE online (status INT)",
    "CREATE TABLE record (status INTEGER)",
    "CREATE TABLE `shoutbox` (  `pvm` datetime DEFAULT NULL,  `user` varchar(255) NOT NULL,  `msg` text)",
    "CREATE TABLE `tj` (  `nimi` varchar(255) NOT NULL,  `alku` date DEFAULT NULL,  `loppu` date DEFAULT NULL)",
    "CREATE TABLE `users` (  `name` varchar(255) PRIMARY KEY,'connected' integer DEFAULT NULL,lastpoll integer,  `focus` integer DEFAULT NULL,  `color` varchar(10) DEFAULT NULL,  `score` double DEFAULT NULL)",
    "CREATE TABLE `vitsit` (  `kieli` varchar(10) DEFAULT 'fi',  `vitsi` text NOT NULL,  `used` integer DEFAULT NULL)",
    "CREATE TABLE youtube (link varchar,name varchar)");
    foreach ($schema as $row) {
        $db->exec($row);
    }
}

class myDatabase {
    
    protected $db = NULL;
    
    function __construct($fname = '/var/www/db/sqlitemain') {
        $this->db = new PDO('sqlite:' . $fname);
        $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
        $this->db->exec("pragma synchronous = off;");
    }

    public /* array */ function query(/* string */ $str = '') {
        $ret = @$this->db->query($str);
        if ($ret === FALSE) {
            initDB($this->db);
            $ret = $this->db->query($str);
        }
        if ($ret === FALSE)
            return array();
        else
            return $ret->fetchAll();
    }

    public /* int */ function exec(/* string */ $str = '') {
        $ret = @$this->db->exec($str);
        if ($ret === FALSE) {
            initDB($this->db);
            $ret = $this->db->exec($str);
        }
        return $ret;
    } 

    function __destruct() {
        $this->db = NULL;
    }
}

if (!debug_backtrace()) {
    $db = new myDatabase();
    echo 'lolol' . PHP_EOL;
    foreach ($db->query('SELECT * FROM vitsit') as $row) {
        echo $row['vitsi'] . PHP_EOL;
    }
}

