<?php 
$app->get('/api/users', 'User');
$app->post('/api/users/create', 'User@create');
$app->put('/api/users/:name', 'User@update');
$app->delete('/api/users', 'User@delete');
$app->delete('/api/users/^[a-z]*$:pseudo', 'User@delete');
$app->all('/', function() {
	App::$vars['title'] = 'Accueil';
});
?>