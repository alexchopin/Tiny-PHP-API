<?php 
define('E200', '200 OK'); 
define('E400', '400 Bad Request');
define('E401', '401 Unauthorized');
define('E404', '404 Not Found');
define('E500', '500 Internal Server Error'); 
define('E501', '501 Not Implemented');
define('E503', '503 Service Unavailable');
define('DATABASE', ROOT.DS.'private'.DS.'database'.DS);
define('APP', ROOT.DS.'private'.DS);
define('PUB', ROOT.DS.'public'.DS);
class Conf {
	static $debug = 1;
}
?>