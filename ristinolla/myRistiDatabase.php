<?php

function initDB ($db) {
    $schema = array(
        "CREATE TABLE all_users (id VARCHAR PRIMARY KEY, name VARCHAR, wins INT, losses INT)",
        "CREATE TABLE data (p1 REFERENCES all_users(id), p2 REFERENCES all_users(id), turn INT, board TEXT)",
        "CREATE TABLE users (id REFERENCES all_users(id) PRIMARY KEY, challenger REFERENCES all_users(id))");
    foreach ($schema as $row) {
        $db->exec($row);
    }
}

class myRistiDatabase {
    
    protected $db = NULL;
    
    function __construct($fname = 'ristinolla.db') {
        $this->db = new PDO('sqlite:' . $fname);
        $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
        
        $this->db->exec("pragma foreign_keys = on;");
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

