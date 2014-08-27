<?php 
// EXEMPLES appels => 'route/:id' ou 'route/num:id' + midd => return true, false ou view::render() + controller success
// $app->get('/:home_view', 'HomeController');
// $app->get('/logout', 'api/Connect@logout');
// $app->post('/api/sendmail', 'api/SendMail');
// $app->all('/api/admin/^[a-z]*$:group/^[a-z]*$:action', 'EspacePro@IsConnected', 'EspacePro@IsAdmin', 'api/AdminApi');
// $app->get('/pro/^[a-z]*$:module/^[a-z]*$:action', 'EspacePro@IsConnected', 'ProController');
$app = new App(((isset($_GET['url'])) ? $_GET['url'] : ''));
$app->get('/api/users', 'User');
$app->post('/api/users/create', 'user@create');
$app->put('/api/users/num:id', 'user@update');
$app->delete('/api/users/^[a-z]*$:name', 'user@delete');
$app->all('/', function() {
	App::$vars['title'] = 'Accueil';
});
// faire la doc 
// finir database Json + schema Db validate + sanitize
// Supprimer le render() pour une version encore plus compact donc plus besoin du app->defaut() ?
?>