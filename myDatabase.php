<?php

function initDB ($db) {
    $schema = array("CREATE TABLE IF NOT EXISTS changes (name VARCHAR PRIMARY KEY, revision INT, id INT)",
    "create table IF NOT EXISTS cookiedata (identifier varchar PRIMARY KEY, recordinglayout varchar)",
    "INSERT OR IGNORE INTO changes (name,revision,id) VALUES ('vitsit',0,NULL)",
    "INSERT OR IGNORE INTO changes (name,revision,id) VALUES ('emoticons',0,NULL)",
    "INSERT OR IGNORE INTO changes (name,revision,id) VALUES ('recordings',0,NULL)",
    "CREATE TABLE IF NOT EXISTS recordings (name varchar(255) DEFAULT '')",
    "CREATE TABLE IF NOT EXISTS `emoticons` (  `sana` varchar(255) NOT NULL DEFAULT '',  `linkki` varchar(255) NOT NULL)",
    "CREATE TABLE IF NOT EXISTS lol (nimi CHAR(100))",
    "CREATE TABLE IF NOT EXISTS online (status INT)",
    "CREATE TABLE IF NOT EXISTS record (status INTEGER)",
    "CREATE TABLE IF NOT EXISTS `shoutbox` (  `pvm` datetime DEFAULT NULL,  `user` varchar(255) NOT NULL,  `msg` text)",
    "CREATE TABLE IF NOT EXISTS `tj` (  `nimi` varchar(255) NOT NULL,  `alku` date DEFAULT NULL,  `loppu` date DEFAULT NULL)",
    "CREATE TABLE IF NOT EXISTS `users` (  `name` varchar(255) PRIMARY KEY,'connected' integer DEFAULT NULL,lastpoll integer,  `focus` integer DEFAULT NULL,  `color` varchar(10) DEFAULT NULL,  `score` double DEFAULT NULL)",
    "CREATE TABLE IF NOT EXISTS `vitsit` (  `kieli` varchar(10) DEFAULT 'fi',  `vitsi` text NOT NULL,  `used` integer DEFAULT NULL)",
    "CREATE TABLE IF NOT EXISTS youtube (link varchar,name varchar)");
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
            try {
                $ret = $this->db->query($str);
            } catch (Exception $e) {
                echo "Error in PDO query() str : ".$str."\n".$e->getMessage();
            }
        }
        if ($ret === FALSE)
            return array();
        else
            return $ret->fetchAll();
    }

    public /* int */ function exec(/* string */ $str = '') {
        //echo PHP_EOL."myDatabase->exec('$str')".PHP_EOL;
        $ret = @$this->db->exec($str);
        if ($ret === FALSE) {
            initDB($this->db);
            try {
                $ret = $this->db->exec($str);
            } catch (Exception $e) {
                echo "Error in PDO exec() str : ".$str."\n".$e->getMessage();
            }
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

