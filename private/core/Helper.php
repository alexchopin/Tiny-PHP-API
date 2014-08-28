<?php 
class Sanitize {
	static function unTrim($a, $c) { return $c.$a.$c;}
	static function str($a) { return filter_var($a, FILTER_SANITIZE_STRING);}
	static function num($a) { return filter_var($a, FILTER_SANITIZE_NUMBER_INT);}
	static function url($a) { return filter_var($a, FILTER_SANITIZE_URL);}
	static function email($a) { return trim(filter_var($a, FILTER_SANITIZE_EMAIL));}
	static function upper($a) { return strtoupper($a);}
	static function lower($a) { return strtolower($a);}
	static function maj($a) { return ucfirst($a);}
	static function pwd($a) { return crypt($a);}
	static function token($a, $nb) { return substr(self::url(self::pwd($a)), 0, $nb);}
}
class Validate {
	static function gt($a, $b) { return (($a > $b) ? true : false);}
	static function gte($a, $b) { return (($a >= $b) ? true : false);}
	static function lt($a, $b) { return (($a < $b) ? true : false);}
	static function lte($a, $b) { return (($a <= $b) ? true : false);}
	static function eq($a, $b) { return (($a == $b) ? true : false);}
	static function ne($a, $b) { return (($a != $b) ? true : false);}
	static function in($a, $b) { return in_array($a, $b);}
	static function min($a, $b) { return ((strlen($a) >= $b) ? true : false);}
	static function max($a, $b) { return ((strlen($a) <= $b) ? true : false);}
	static function exact($a, $b) { return ((strlen($a) == $b) ? true : false);}
	static function num($a) { return is_numeric($a);}
	static function email($a) { return filter_var($a, FILTER_VALIDATE_EMAIL);}
	static function tab($a) { return is_array($a);}
	static function str($a) { return is_string($a);}
	static function obj($a) { return is_object($a);}
	static function isKey($a, $b) { return array_key_exists($a, $b);}
	static function int($a) { return filter_var($a, FILTER_VALIDATE_INT, array('options' => array('min_range' => 0)));}
	static function pwd($a, $b) {return ((crypt($a, $b) == $b) ? true : false);}
	static function regexp($a, $b) { return filter_var($b, FILTER_VALIDATE_REGEXP, array('options' => array('regexp' => Sanitize::unTrim($a, '"'))));}
	static function type($a, $b) {
		if (empty($a)) { return true;}
		if (is_callable('self::'.$a)) { return self::$a($b);} else { return self::regexp($a, $b);}
	}
}
class Redirect {
	static function to($url) { die(header('Location: '.BASE_URL.$url));}	
	static function on($url) { die(header('Location: '.$url));}	
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