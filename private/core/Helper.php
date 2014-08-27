<?php 
class Redirect {
	static function to($url) { die(header('Location: '.BASE_URL.$url));}	
	static function on($url) { die(header('Location: '.$url));}	
}
class Sanitize {
	static function unTrim($str, $c) { return $c.$str.$c;}
	static function str($str) { return filter_var($str, FILTER_SANITIZE_STRING);}
	static function num($str) { return filter_var($str, FILTER_SANITIZE_NUMBER_INT);}
	static function url($str) { return filter_var($str, FILTER_SANITIZE_URL);}
	static function email($str) { return trim(filter_var($str, FILTER_SANITIZE_EMAIL));}
	static function upper($str) { return strtoupper($str);}
	static function lower($str) { return strtolower($str);}
	static function maj($str) { return ucfirst($str);}
	static function pwd($str) { return crypt($str);}
	static function token($str, $nb) { return substr(self::url(self::pwd($str)), 0, $nb);}
}
class Valide {	
	static function type($reg, $str) {
		if (empty($reg)) { return true;}
		if (is_callable('self::'.$reg)) { return self::$reg($str);} else { return self::regexp($reg, $str);}
	}
	static function regexp($reg, $str) { return filter_var($str, FILTER_VALIDATE_REGEXP, array('options' => array('regexp' => Sanitize::unTrim($reg, '"'))));}
	static function num($str) { return filter_var($str, FILTER_VALIDATE_INT, array('options' => array('min_range' => 0)));}
	static function email($str) { return filter_var($str, FILTER_VALIDATE_EMAIL);}
	static function isKey($str, $tab) { return array_key_exists($str, $tab);}
	static function min($str, $num, $opt = null) { return ((($opt && $str >= $num) || (!$opt && strlen($str) >= $num)) ? true : false);}
	static function max($str, $num, $opt = null) { return ((($opt && $str <= $num) || (!$opt && strlen($str) <= $num)) ? true : false);}
	static function equal($str, $num, $opt = null) { return ((($opt && $str == $num) || (!$opt && strlen($str) == $num)) ? true : false);}
	static function pwd($str, $pwd) {return ((crypt($str, $pwd) == $pwd) ? true : false);}
	static function isAdmin() {
		if (session_id() == "") { session_start();}
		return ((isset($_SESSION['user']) && !empty($_SESSION['user']) && isset($_SESSION['user']['id']) && $_SESSION['user']['id'] < 0) ? true : false);
	}
}
class Error {	
	static function debug($str) {
		if (Conf::$debug) {
			header("HTTP/1.0 400 Bad Request");
			$backtrace = debug_backtrace();
			echo '<p><b>ERROR : '.$str.'</b><br/>';
			foreach ($backtrace as $v) { echo 'Fichier : '.$v['file'].'<br/>Ligne : '.$v['line'].'<br/>';}
			echo '</p>';
			die();
		}
		return false;
	}
}
?>