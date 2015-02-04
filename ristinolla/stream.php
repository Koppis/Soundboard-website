<?php

require_once("myRistiDatabase.php");

class DatabaseCheck {
	protected $db = NULL;
	protected $query = "";
	public function __construct($db) {
		$this->db = $db;
	}
    // Returns true or false
    public function isnew() {
        $this->result = $this->db->query($this->query);
    	if (empty($this->result)){
    		return false;
    	} else {
    		return true;
    	}
    }
}

class Players extends Databasecheck {
    public function __construct($db,$id) {
        $this->id = $id;
		$this->db = $db;
		$this->query = "SELECT id FROM users WHERE id IS NOT '$id'";
    }

    public function getdata () {
        $opponent_id = $this->result[0]['id'];
        $opponent_name = $this->db->query("SELECT name FROM all_users WHERE id = '$opponent_id'")[0]['name'];
        $this->db->exec("INSERT INTO data (p1,p2,turn,board) VALUES ('$opponent_id','$this->id',1,'{}')");
        return $opponent_name;
    }

}

class GameEnded extends Databasecheck {
    public function __construct($db,$id) {
        $this->id = $id;
		$this->db = $db;
		$this->query = "SELECT turn FROM data WHERE (p1 = '$this->id' OR p2 = '$this->id')";
    }
    public function isnew() {
        $this->result = $this->db->query($this->query);
    	if (empty($this->result)){
    		return true;
    	} else {
    		return false;
    	}
    }
    public function getdata () {
        return true;
    }
}


class Gamedata extends Databasecheck {
    public function __construct($db,$current_turn,$id) {
        $this->id = $id;
		$this->db = $db;
		$this->query = "SELECT turn FROM data WHERE (p1 = '$this->id' OR p2 = '$this->id') AND turn > $current_turn";
    }

    public function getdata () {
        $result = $this->db->query("SELECT board,turn,p1,p2 FROM data WHERE p1 = '$this->id' OR p2 = '$this->id'")[0];
        
        if ($result['p1'] == $this->id) {
            $mysign = "X";
            $o_id = $result['p2'];
        }else{
            $o_id = $result['p1'];
            $mysign = "O";
        }
        $o_result = $this->db->query("SELECT name FROM all_users WHERE id = '$o_id'")[0];
        
        return array('turn' => $result['turn'], 'opponent' => $o_result['name'], 'mysign' => $mysign, 'board' => $result['board']);
    }

}


$db = new myRistiDatabase();

$id = $_POST['id'];
$turn = $_POST['turn'];
$searching = $_POST['searching'];
$username = $_POST['username'];



$checks = array();
$checks['gamedata'] = new Gamedata($db,$turn,$id);


if ($searching == "true" && !$checks['gamedata']->isnew()) {
    $checks['players'] = new Players($db,$id);

    @$db->exec("INSERT INTO users (id) VALUES ('$id')");
} else {
    $checks['gameended'] = new GameEnded($db,$id);
}

$db->exec("REPLACE INTO all_users (id,name) VALUES ('$id','$username')");


$results = False;
$time_wasted=0;



foreach ($checks as $value) {
	if ($value->isnew()) {
		$results = True;
	}
}

while($results == False){
    

	if ($time_wasted >= 300){
        $db->exec("DELETE FROM users WHERE id = '$id'");
        $db = NULL;
        die(json_encode(array('debug'=>'wasted','status'=>'no-results')));
		exit;
	}
	//$db->close();
	usleep(200000);
	//$db->myOpen();
    
	$time_wasted++;
    
    foreach ($checks as $value) {
		if ($value->isnew()) {
			$results = True;
		}
	}
}
$return_array = array('debug'=>"jJ",'status'=>'results');
foreach ($checks as $key => $value) {
	if ($value->isnew())
		$return_array[$key] = $value->getdata();
}


$db->exec("DELETE FROM users WHERE id = '$id'");

$db = NULL;

die(json_encode($return_array));


