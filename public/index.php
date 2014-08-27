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
        <title><?= App::$vars['title'];?></title>
        <meta name="description" content="">
		<link rel="stylesheet" type="text/css" media="screen" href="css/font-awesome.css">
		<!--[if lt IE 9]>
			<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->
    </head>
	<body>
		Home page
	</body>
</html>
