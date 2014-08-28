<?php 
// PROTOTYPE
// Type : str, num, email, tab, obj
// Key 	: unique, ai
// Default : "default value", false(obligatoire)
// eq, gt, gte, lt, lte, ne, in, min, max, exact
class User {
	private $proto = array(
		"_id"	 => array("type" => "num","key"	=> "ai"),
		"pseudo" => array(
			"type" 		=> "str",
			"default" 	=> false,
			"key" 		=> "unique",
			"min" 		=> 3
		),
		"age" => array(
			"type" 		=> "num",
			"gte" 		=> 6,
			"default" 	=> 10
		),
		"email" => array(
			"type" 		=> "email",
			"default" 	=> "aucun"
	));
	public function index() {
		$users = new Database('admin','users');
		// $list = $users->find();
		$list = $users->find(array("pseudo eq alex"));
		App::send(E200, $list);
	}
	public function create() {
		$data = (isset($_POST)) ? $_POST : null;
		$users = new Database('admin','users');
		if (is_array($err = $users->proto($this->proto, $data)) && ($res = $users->create($err))) {
			App::send(E200, $res);
		}
		App::send(E400, $err);
	}
	public function update() {
		$opt = (isset(App::$vars['params']['id'])) ? '["_id eq '.App::$vars['params']['id'].'"]' : null;
		$data = array();
		parse_str(file_get_contents("php://input"), $data);
		$users = new Database('admin','users');
		if ($data && !($err = $users->update($opt, $data, $this->proto))) {
			App::send(E200);
		}
		App::send(E400, $err);
	}
	public function delete() {
		$opt = (isset(App::$vars['params']['pseudo'])) ? '["pseudo eq '.App::$vars['params']['pseudo'].'"]' : null;
		$users = new Database('admin','users');
		if ($users->delete($opt)) {
			App::send(E200);
		}
		App::send(E400);
	}
}
?>