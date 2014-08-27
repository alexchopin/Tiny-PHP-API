<?php
// Database Json + schema Db validate + sanitize
class Database {
	public  $file = false;
	private $db = false;
	private $header = '{"ids":0,"body":[]}';

	public function __construct($base, $table) {
		$this->file = DATABASE.$base.DS.$table.'.json';
		if (!file_exists(DATABASE.$base)) { mkdir(DATABASE.$base, 0700);}
		$this->db = (file_exists($this->file)) ? json_decode(file_get_contents($this->file)) : json_decode($this->header);
	}
	private function gt($a, $b) { return (($a > $b) ? true : false);}
	private function gte($a, $b) { return (($a >= $b) ? true : false);}
	private function lt($a, $b) { return (($a < $b) ? true : false);}
	private function lte($a, $b) { return (($a <= $b) ? true : false);}
	private function eq($a, $b) { return (($a == $b) ? true : false);}
	private function neq($a, $b) { return (($a != $b) ? true : false);}
	private function in($a, $b) { return in_array($a, json_decode($b));}
	private function search($l, $a) {
		$res = array();
		for ($i = 0; $i < count($l); $i++) {
			$o = 0;
			$vars = get_object_vars($l[$i]);
			foreach ($a as $b) {
				$c = explode(' ', $b);
				$o += (key_exists($c[0], $vars) && !is_object($vars[$c[0]]) && !is_array($vars[$c[0]]) && $this->$c[1]($vars[$c[0]], $c[2])) ? 1 : 0;
			}
			if ($o == count($a)) {
				array_push($res, $l[$i]);
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
	public function update($conditions = null) {
	}
	public function delete($conditions = null) {
	}
}
?>