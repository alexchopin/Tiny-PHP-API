<?php 
$app->get('/api/users', 'user');
$app->post('/api/users/create', 'user@create');
$app->put('/api/users/num:id', 'user@update');
$app->delete('/api/users', 'user@delete');
$app->delete('/api/users/^[a-z]*$:pseudo', 'user@delete');
$app->all('/', function() {
	App::$vars['title'] = 'Accueil';
});
?>