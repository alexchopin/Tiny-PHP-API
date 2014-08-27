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
		if ($data && ($res = $users->create($data))) {
			App::send(E200, $res);			
		}
		App::send(E400);
	}
	public function update() {
		$data = (isset($_POST)) ? $_POST : null;
		App::send(E200, App::$vars['id']);
	}
	public function delete() {
		App::send(E200, App::$vars['id']);
	}
}
?>