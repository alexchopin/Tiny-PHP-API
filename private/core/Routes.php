<?php 
$app->get('/api/users', 'User');
$app->post('/api/users/create', 'user@create');
$app->put('/api/users/num:id', 'user@update');
$app->delete('/api/users/^[a-z]*$:name', 'user@delete');
$app->all('/', function() {
	App::$vars['title'] = 'Accueil';
});
?>