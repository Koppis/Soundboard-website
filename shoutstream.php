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

class Memes extends DatabaseCheck {

	
	public function __construct($db,$revision) {
		$this->db = $db;
		$this->query = "SELECT * FROM memes WHERE rowid = 1 AND rating > $revision";
	}
	
        
	public function getdata() {
		if (isset($this->result)) {
            $result = $this->db->query("SELECT *,rowid FROM memes");
            $session = $GLOBALS['session_id'];

            $data = array();
            foreach ($result as $row){

                $rec = $row['rec'];
                $myrate = NULL;
                if ($rec != '') {
                $myrate = $this->db->query("SELECT * FROM memeratings WHERE user = '$session' AND rec = $rec");
                if (!empty($myrate))
                    $myrate = $myrate[0]['rating'];
                else
                    $myrate = NULL;
                } 
                $recname = NULL;
                $vitsitext = NULL;
                if ($rec != NULL) {
                    $r = $this->db->query("SELECT name FROM recordings WHERE rowid = $rec");
                    $recname = $r[0]['name'];
			    	$data[] = array('rec'=>$rec,'recname'=>$recname,'rating'=>$row['rating'],'myrating'=>$myrate);
                } else if ($row['vitsi'] != NULL) {
                    $r = $this->db->query("SELECT vitsi FROM vitsit WHERE rowid = ".$row['vitsi']);
                    $vitsitext = $r[0]['vitsi'];
			    	$data[] = array('vitsi'=>$row['vitsi'],'vitsitext'=>$vitsitext,'rating'=>$row['rating'],'myrating'=>$myrate);
                } else if ($row['rowid'] == "1") {
			    	$data[] = array('rec'=>$rec,'rating'=>$row['rating']);
                }
			}
            
			return $data;
		}
	}
}


class Processes extends DatabaseCheck {

	
	public function __construct($db,$revision) {
		$this->db = $db;
		$this->query = "SELECT * FROM processes_revision WHERE revision IS NOT $revision";
	}
	
        
	public function getdata() {
		if (isset($this->result)) {
            $result = $this->db->query("SELECT * FROM processes");
            $data = array();
			foreach ($result as $row){		
				$data[] = array('pid'=>$row['pid'],'name'=>$row['name']);
			}
            
			$data[] = intval($this->result[0]['revision']);
            
			return $data;
		}
	}
}

class TeamspeakChat extends DatabaseCheck {

	
	public function __construct($db,$lastRow) {
		$this->db = $db;
		$this->query = "SELECT rowid,* FROM teamspeak_chat WHERE rowid > {$lastRow} ".
						"ORDER BY rowid DESC LIMIT 20";
	}					
	
        
	public function getdata() {
		if (isset($this->result)) {
			foreach ($this->result as $row){
				$text = $row['msg'];
				$text = stripslashes($text);			
				$new_messages[] = array('rowid'=>$row['rowid'],'pvm'=>$row['pvm'],
					'user'=>$row['user'],'msg'=>$text);
			}
			
			return array_reverse($new_messages);
		}
	}
}

class Teamspeak extends Databasecheck {
	public function __construct($db,$revision) {
        $this->db = $db;
        $this->revision = $revision;
		$this->query = "SELECT * FROM teamspeak_changes WHERE id IS NOT $revision";
    }

    public function getdata () {
        $data = array();
            $result = $this->db->query("SELECT * FROM teamspeak_channels");
            
            foreach ($result as $row) {
                $data [] = array('type'=>1, 'id' => intval($row['id']), 'name'=> $row['name'], 'parent'=>intval($row['parent']));
            }

            $result = $this->db->query("SELECT * FROM teamspeak_clients JOIN leagueoflegends ON teamspeak_clients.name = leagueoflegends.name");

            foreach ($result as $row) {
                $data [] = array('type'=>0, 'id' => intval($row['id']), 'name'=> $row['name'], 'channel'=>intval($row['channel']),
                    'online'=>1, 'mode'=>intval($row['mode']), 'lolchamp'=>$row['lolchamp'], 'summonerid'=>$row['summonerid']);
            }

            $data[] = intval($this->result[0]['id']);
        
            
        
        return $data;
    }
}


class Cookie extends Databasecheck {
	public function __construct($db,$rowid,$id) {
		$this->db = $db;
		$this->query = "SELECT *, rowid FROM cookiedata WHERE identifier = '".$id."' AND $rowid = -1";
    }

    public function getdata () {
        if (isset($this->result))
            return $this->result[0];
    }

}

class Youtube extends Databasecheck {
	public function __construct($db,$rowid) {
		$this->db = $db;
		$this->query = "SELECT *,rowid FROM youtube WHERE rowid > $rowid ORDER BY rowid DESC LIMIT 1";
    }

    public function getdata () {
        if (isset($this->result))
            return $this->result[0];
    }

}

class Recordings extends Databasecheck {
	public function __construct($db,$revision) {
        $this->db = $db;
        $this->revision = $revision;
		$this->query = "SELECT revision, id FROM changes WHERE name = 'recordings' AND revision > $revision";
    }

    public function getdata () {
        $newrevision = $this->result[0]['revision'];
        $data = array();

        if ($this->revision == $newrevision - 1) {
                $id = $this->result[0]['id'];
                $row = $this->db->query("SELECT *, rowid FROM recordings WHERE rowid = $id")[0];
                $data = array('justone' => 1, 'rowid' => $row['rowid'], 'name' => $row['name'], 'playcount' => $row['playcount'],
                             'category' => $row['category'], 'deleted' => $row['deleted'], 'revision' => $newrevision,
                             'date' => $row['date']);
        } else {
            $result = $this->db->query('SELECT *, rowid FROM recordings WHERE deleted IS NOT 1 ORDER BY rowid DESC');
            foreach ($result as $row) {
                $data[] = array('rowid' => $row['rowid'], 'name' => $row['name'], 'playcount' => $row['playcount'],
                             'category' => $row['category'], 'date' => $row['date']);
            }
            $data[] = $newrevision;

        }
                return $data;
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
		$this->query = "SELECT nickname FROM users WHERE connected = 1 AND ({$time} - lastpoll < 65)";
		$this->known_users = $known_users;
	}
	
	//Here we need to write isnew() again for "Users" because I couldn't straight
	//up test for it in the query... But it makes getdata() easier
	public function isnew() {
    	$db = $this->db;
        $this->result = $db->query($this->query);
    	$this->new_users = array();
		foreach ($this->result as $row){
			$this->new_users[] = $row['nickname'];
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
		$this->query = "SELECT shoutbox.rowid, shoutbox.*, users.color, users.nickname FROM shoutbox JOIN users ON ".
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
					'user'=>$row['nickname'],'msg'=>$text,'color'=>$row['color']);
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
$emoticons_revision = (isset($_GET['emoticons_revision']) && !empty($_GET['emoticons_revision'])) ? $_GET['emoticons_revision'] : 0;
$recordings = (isset($_GET['recordings_revision']) && !empty($_GET['recordings_revision'])) ? $_GET['recordings_revision']:0;
$youtube_rowid = (isset($_GET['youtube_rowid']) && !empty($_GET['youtube_rowid'])) ? $_GET['youtube_rowid']:0;
$cookie_rowid = (isset($_GET['cookie_rowid']) && !empty($_GET['cookie_rowid'])) ? $_GET['cookie_rowid']:0;
$session_id = (isset($_GET['session_id']) && !empty($_GET['session_id'])) ? $_GET['session_id']:0;
$teamspeak_revision = (isset($_GET['teamspeak_revision']) && !empty($_GET['teamspeak_revision'])) ? $_GET['teamspeak_revision'] : 0;
$teamspeak_chat_rowid = (isset($_GET['teamspeak_chat_rowid']) && !empty($_GET['teamspeak_chat_rowid'])) ? $_GET['teamspeak_chat_rowid'] : 0;
$processes_rowid = (isset($_GET['processes_revision']) && !empty($_GET['processes_revision'])) ? $_GET['processes_revision'] : 0;
$memes_revision = (isset($_GET['memes_revision']) && !empty($_GET['memes_revision'])) ? $_GET['memes_revision'] : 0;





$GLOBALS["session_id"] = $session_id;
$ipaddress = $_SERVER['REMOTE_ADDR'];


$date = date('Y-m-d H:i:s');
$time = time();
$results = False;
$time_wasted=0;

$db = new myDatabase();
if ($user !== 0){
    if (($db->exec("UPDATE users SET nickname='$user', connected=1, lastpoll={$time}, ip='$ipaddress' WHERE name='$session_id'")) == 0)
        $db->exec("INSERT INTO users (name,connected,lastpoll,nickname) VALUES ('$session_id',1,'$time','$user')");
        
    
}



$checks = array();
$checks['memes'] = new Memes($db,$memes_revision);
$checks['processes'] = new Processes($db,$processes_rowid);
$checks['teamspeakchat'] = new TeamspeakChat($db,$teamspeak_chat_rowid);
$checks['teamspeak'] = new Teamspeak($db,$teamspeak_revision);
$checks['youtube'] = new Youtube($db,$youtube_rowid);
$checks['recordings'] = new Recordings($db,$recordings);
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

