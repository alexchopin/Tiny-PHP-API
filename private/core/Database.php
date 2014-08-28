<?php
class Database {
	public  $file = false;
	private $db = false;
	private $header = '{"ai":0,"body":[]}';

	public function __construct($base, $table) {
		$this->file = DATABASE.$base.DS.$table.'.json';
		if (!file_exists(DATABASE.$base)) { mkdir(DATABASE.$base, 0700);}
		$this->db = (file_exists($this->file)) ? json_decode(file_get_contents($this->file)) : json_decode($this->header);
	}
	private function search($l, $a, $key_opt = null) {
		$res = array();
		for ($i = 0; $i < count($l); $i++) {
			$o = 0;
			$vars = get_object_vars($l[$i]);
			foreach ($a as $b) {
				$c = explode(' ', $b);
				$o += (key_exists($c[0], $vars) && !is_object($vars[$c[0]]) && !is_array($vars[$c[0]]) && Inspect::$c[1]($vars[$c[0]], (($c[1] == "in") ? json_decode($c[2]) : $c[2]))) ? 1 : 0;
			}
			if ($o == count($a)) {
				$val = ($key_opt) ? $i : $l[$i];
				array_push($res, $val);
			}
		}
		return $res;
	}
	public function find($opt = null) {
		// $opt = json_decode('["name eq titi","name in [a,b,c]"]'); SELECT * + CONDITION AND
		return json_encode((($opt) ? $this->search($this->db->body, json_decode($opt)) : $this->db->body));
	}
	public function findFirst($opt = null) {
		return json_encode(current((($opt) ? $this->search($this->db->body, json_decode($opt)) : $this->db->body)));
	}
	public function create($data) {
		array_push($this->db->body, $data);
		if (file_put_contents($this->file, json_encode($this->db), LOCK_EX)) {
			return json_encode($data);
		}
		return false;
	}
	public function update($opt, $data, $proto) {
		$list = $this->search($this->db->body, json_decode($opt), true);
		foreach ($list as $i) {
			foreach ($data as $k => $v) {
				$this->db->body[$i]->$k = $v;
			}
			if (!is_array($err = $this->proto($proto, get_object_vars($this->db->body[$i]), true))) {
				return $err;
			}
		}
		return ((count($list)) ? !(file_put_contents($this->file, json_encode($this->db), LOCK_EX)) : "Datas not found");
	}
	public function delete($opt = null) {
		if ($opt) {
			$list = $this->search($this->db->body, json_decode($opt), true);
			foreach ($list as $i) {
				array_splice($this->db->body, $i, 1);
			}
			return ((count($list)) ? file_put_contents($this->file, json_encode($this->db), LOCK_EX) : false);
		}
		return ((file_exists($this->file)) ? unlink($this->file) : false);
	}
	public function proto($proto, $data, $updt = null) {
		foreach ($proto as $k => $p) {
			if (key_exists($k, $data)) {
				if ((key_exists("type", $p) && (Inspect::$p["type"]($data[$k]) || (key_exists("default", $p) && $p["default"] == $data[$k]))) || (!key_exists("type", $p) && Inspect::str($data[$k]))) {
					foreach ($p as $f => $v) {
						if (!in_array($f, array("type","key","default")) && !Inspect::$f($data[$k],$v)) {
							return ("Bad format of argument ".$k);
						}
					}
					if (key_exists("key", $p) && $p["key"] == "unique" && !$updt && count($this->search($this->db->body, json_decode('["'.$k.' eq '.$data[$k].'"]')))) {
						return ("Entity already exists");
					}
				} else {
					return ("Bad type of argument ".$k);					
				}
			} else if (!key_exists($k, $data) && key_exists("default", $p) && !$p["default"]) {
				return ("Missing argument ".$k); // FIELD NO-OPTIONAL
			} else if (!key_exists($k, $data) && key_exists("default", $p)) {
				$data[$k] = $p["default"]; // FIELD CREATE WITH DEFAULT VALUE
			} else if (!key_exists($k, $data) && key_exists("key", $p) && $p["key"] == "ai") {
				$data[$k] = $this->db->ai;
				$this->db->ai++;
			}
		}
		ksort($data);
		return $data;
	}
}
?>