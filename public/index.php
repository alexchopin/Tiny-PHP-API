<?php
define('BASE_URL', dirname(dirname($_SERVER['SCRIPT_NAME'])));
define('WEBROOT', dirname(__FILE__));
define('ROOT', dirname(WEBROOT));
define('DS', DIRECTORY_SEPARATOR);
require_once(ROOT.DS.'private'.DS.'core'.DS.'includes.php');
?>
<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <title><?= (isset(App::$vars['title'])) ? App::$vars['title'] : 'Title';?></title>
        <meta name="description" content="">
    </head>
	<body>
		Home page
	</body>
</html>
