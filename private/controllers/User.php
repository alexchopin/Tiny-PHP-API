<?php 
class User {
	public function index() {
		$users = new Database('admin','users');
		$list = $users->find();
		App::send(E200, $list);
	}
	public function create() {
		$data = (isset($_POST)) ? $_POST : null;
		$users = new Database('admin','users');
		if (is_array($res = $users->create($data, Prototype::$user))) {
			App::send(E200, $res);
		}
		App::send(E400, $res);
	}
	public function update() {
		$data = array();
		parse_str(file_get_contents("php://input"), $data);
		$opt = (isset(App::$vars['params']['id'])) ? array('_id eq '.App::$vars['params']['id']) : null;
		$users = new Database('admin','users');
		if ($data && !($err = $users->update($opt, $data, Prototype::$user))) {
			App::send(E200);
		}
		App::send(E400, $err);
	}
	public function delete() {
		$opt = (isset(App::$vars['params']['pseudo'])) ? array('pseudo eq '.App::$vars['params']['pseudo']) : null;
		$users = new Database('admin','users');
		if ($users->delete($opt)) {
			App::send(E200);
		}
		App::send(E400);
	}
}
?>