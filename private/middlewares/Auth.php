<?php 
class Auth {
	public function index() { 
		return true; // No problem : true, Error : false or App::send(E400, "error msg");
	}
}
?>