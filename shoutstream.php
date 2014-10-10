<?php

require_once('myDatabase.php');

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

class Emoticons extends Databasecheck {
	public function __construct($db,$revision) {
		$this->db = $db;
		$this->query = "SELECT revision FROM changes WHERE name = 'emoticons' AND revision > $revision";
    }

    public function getdata () {
        $data = array();
        $result = $this->db->query('SELECT * FROM emoticons');
        foreach ($result as $row) {
            $data[] = array('sana'=>$row['sana'],'linkki'=>$row['linkki']);
        }

        $data[] = $this->result[0]['revision'];

        return $data;
    }

}


class Vitsit extends DatabaseCheck {
	public function __construct($db,$revision) {
		$this->db = $db;
		$this->query = "SELECT revision FROM changes WHERE name = 'vitsit' AND revision > $revision";
    }

    public function getdata () {
        $data = array();
        $result = $this->db->query('SELECT *, rowid FROM vitsit');
        foreach ($result as $row) {
            $data[] = array('used'=>$row['used'],'rowid'=>$row['rowid'],
                            'kieli'=>$row['kieli'],'vitsi'=>$row['vitsi']);
        }

        $data[] = $this->result[0]['revision'];

        return $data;
    }
}


class JukeboxOnline extends DatabaseCheck {
	public function __construct($db,$online) {
		$this->db = $db;
		$this->query = "SELECT status FROM online WHERE status IS NOT $online";
		$this->online = $online;
	}
	public function getdata () {
		if (isset($this->result)) {
			if (empty($this->result))
				return $this->online;
			foreach ($this->result as $row)
				return $row['status'];
		}
	}
}


class Record extends DatabaseCheck {
	public function __construct($db,$rec) {
		$this->db = $db;
		$this->query = "SELECT status FROM record WHERE status IS NOT $rec";
		$this->rec = $rec;
	}
	public function getdata () {
		if (isset($this->result)) {
			if (empty($this->result))
				return $this->rec;
			foreach ($this->result as $row)
				return $row['status'];
		}
	}
}

class Users extends DatabaseCheck {
	public function __construct($db,$time,$known_users) {
		$this->db = $db;
		$this->query = "SELECT name FROM users WHERE connected = 1 AND ({$time} - lastpoll < 65)";
		$this->known_users = $known_users;
	}
	
	//Here we need to write isnew() again for "Users" because I couldn't straight
	//up test for it in the query... But it makes getdata() easier
	public function isnew() {
    	$db = $this->db;
        $this->result = $db->query($this->query);
    	$this->new_users = array();
		foreach ($this->result as $row){
			$this->new_users[] = $row['name'];
		}
    	if ($this->known_users == $this->new_users){
    		return false;
    	} else {
    		return true;
    	}
    }
	
	public function getdata () {
		if (isset($this->new_users)) {
			return $this->new_users;
		}
	}
}

class Messages extends DatabaseCheck {

	
	public function __construct($db,$lastRow) {
		$this->db = $db;
		$this->query = "SELECT shoutbox.rowid, shoutbox.*, users.color FROM shoutbox JOIN users ON ".
						"shoutbox.user = users.name WHERE shoutbox.rowid > {$lastRow} ".
						"ORDER BY shoutbox.rowid DESC LIMIT 50";
	}					
	
        
	public function getdata() {
		if (isset($this->result)) {
			$emotes_result = $this->db->query("SELECT * FROM emoticons");
			$emotes = array();
			foreach ($emotes_result as $row){
				$emotes[] = array('sana'=>$row['sana'],'linkki'=>$row['linkki']);
			}
			$new_messages = array();
			foreach ($this->result as $row){
				$text = $row['msg'];
				$text = stripslashes($text);
				foreach ($emotes as $e)
					$text = str_replace($e['sana'],
						'<img style="max-height:50px;max-width:50px;" src="'.
						$e['linkki'].'">',$text);
			
				$new_messages[] = array('rowid'=>$row['rowid'],'time'=>$row['pvm'],
					'user'=>$row['user'],'msg'=>$text,'color'=>$row['color']);
			}
			
			return array_reverse($new_messages);
		}
	}
}




    $lastRow = (isset($_GET['rowid']) && !empty($_GET['rowid'])) ? $_GET['rowid']:0;
    $kohta = (isset($_GET['kohta']) && !empty($_GET['kohta'])) ? $_GET['kohta'] : 0;
    $user = (isset($_GET['user']) && !empty($_GET['user'])) ? $_GET['user'] : 0;
    $rec = (isset($_GET['rec']) && !empty($_GET['rec'])) ? $_GET['rec'] : 0;
    $new_rec = $rec;
    $known_users = (isset($_GET['users']) && !empty($_GET['users'])) 
                    ? JSON_decode($_GET['users']) : array();
    $online = (isset($_GET['online']) && !empty($_GET['online'])) ? $_GET['online'] : 0;
    $vitsit_revision = (isset($_GET['vitsit_revision']) && !empty($_GET['vitsit_revision'])) ? $_GET['vitsit_revision'] : 0;    
    $emoticons_revision = (isset($_GET['emoticons_revision']) && !empty($_get['emoticons_revision'])) ? $_get['emoticons_revision'] : 0;



    $date = date('Y-m-d H:i:s');
    $time = time();
    $results = False;
    $time_wasted=0;

if (!debug_backtrace()) {
    $db = new myDatabase('sqlitemain');
} else {
    $db = new myDatabase();
    if ($user !== 0){
        if (@$db->exec("INSERT INTO users (name,connected,lastpoll)".
            " VALUES ('{$user}',1,'{$time}')") == false){
            $db->exec("UPDATE users SET connected=1, lastpoll={$time}".
                " WHERE name='{$user}'");
        }
    }

}

$checks = array();
$checks['emoticons'] = new Emoticons($db,$emoticons_revision);
$checks['vitsit'] = new Vitsit($db,$vitsit_revision);
$checks['online'] = new JukeboxOnline($db,$online);
$checks['rec'] = new Record($db,$rec);
$checks['users'] = new Users($db,$time,$known_users);
$checks['messages'] = new Messages($db,$lastRow);



//NO NEED TO CHANGE THINGS BELOW, I THINK



foreach ($checks as $value) {
	if ($value->isnew()) {
		$results = True;
	}
}

while($results == False){
	if ($time_wasted >= 300){
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
$db = NULL;

die(json_encode($return_array));

