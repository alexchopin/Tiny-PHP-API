<?php 
class App {
	static public 	$vars = array();
	public  		$url;

	function __construct($url) { $this->url = $url;}
	// URL parse + save URL params in $vars[]
	private function parseUrl($route, $url) {
		$route = explode('/', trim($route, '/'));
		$url = explode('/', trim($url, '/'));
		if (count($route) == count($url)) {
			for ($i = 0; $i < count($route); $i++) {
				$cut = strpos($route[$i], ':');
				if ($cut === false && strcmp($route[$i], $url[$i]) != 0) { return false;}
				if ($cut !== false) {
					$tmp = explode(':', $route[$i]);
					if (!Valide::type($tmp[0], $url[$i])) { return Error::debug("Bad variable format in URL");}
					App::$vars['params'][$tmp[1]] = $url[$i];
				}
			}
			return true;
		}
		return false;
	}
	// Middleware and Controller parse + execute
	private function parsePath($url, $src) {
		if (is_callable($url)) {
			return $url();
		} else {
			$path = APP.$src.'s';
			$p = explode('/', $url);
			foreach ($p as $v) {
				$c = $v;
				$f = 'index';
				if (strpos($v, '@') > 0) {
					$tab = explode('@', $v);
					$c = $tab[0];
					$f = $tab[1];
				}
				$path .= DS.$c;
			}
			$path .= '.php';
			if (!file_exists($path)) { return Error::debug('Bad '.$src.' path : '.$path.' in app->X()');}
			require_once $path;
			$obj = new $c();
			if (!in_array($f, get_class_methods($obj))) { return Error::debug('Bad '.$src.' function : '.$f.' in app->X()');}
			return $obj->$f();
		}
	}
	private function run($nb_args, $args) {
		if ($nb_args < 2) { return Error::debug("Args < 2 in app->X()"); }
		if ($this->parseUrl($args[0], $this->url)) {
			for ($i = 1; $i < ($nb_args - 1); $i++){
				if (!$this->parsePath($args[$i], 'middleware'))
					return false;
			}
			return $this->parsePath($args[$i], 'controller');
		}
		return false;
	}
	public function all() { return $this->run(func_num_args(), func_get_args());}
	public function get() { return (($_SERVER['REQUEST_METHOD'] === 'GET') ? $this->run(func_num_args(), func_get_args()) : false);}
	public function post() { return (($_SERVER['REQUEST_METHOD'] === 'POST') ? $this->run(func_num_args(), func_get_args()) : false);}
	public function put() { return (($_SERVER['REQUEST_METHOD'] === 'PUT') ? $this->run(func_num_args(), func_get_args()) : false);}
	public function delete() { return (($_SERVER['REQUEST_METHOD'] === 'DELETE') ? $this->run(func_num_args(), func_get_args()) : false);}
	static function send($status, $data = null) {header("HTTP/1.0 ".$status);die($data);}
}
$app = new App(((isset($_GET['url'])) ? $_GET['url'] : ''));
?>