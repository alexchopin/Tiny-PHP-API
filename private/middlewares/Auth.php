<?php 
class Auth {
	public function IsAdmin() { return Valide::isAdmin();}
	public function IsConnected() {
		if (session_id() == "") { session_start();}
		return ((isset($_SESSION['user']) && !empty($_SESSION['user'])) ? true : Redirect::to('home/login'));
	}
}
?>