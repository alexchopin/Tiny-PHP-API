<?php 
// PROTOTYPE
// Type : str, num, email, tab, obj
// Key 	: unique, ai
// Default : "default value", false(obligatoire)
// eq, gt, gte, lt, lte, ne, in, min, max, exact
class User {
	private $proto = array(
		"_id"	 => array("key"		=> "ai"),
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
		$list = $users->find();
		// $list = $users->find('["name eq toto"]');
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
		$data = (isset($_POST)) ? $_POST : null;
		$users = new Database('admin','users');
		if ($data && ($res = $users->update($data))) {
			App::send(E200, $res);			
		}
		App::send(E400);
	}
	public function delete() {
		App::send(E200, App::$vars['id']);
	}
}
?>