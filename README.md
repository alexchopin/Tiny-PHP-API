TINY-PHP-API
==========

TINY-PHP-API is a powerful tool to write an Web-app in few minutes. 
Don't loose your time with the server side, be focus on the UI/UX.

Installation
------------

<pre>
git clone git://github.com/alexchopin/Tiny-PHP-API.git
cd Tiny-PHP-API/
</pre>

Documentation
-------------

**RESTful API HTTP methods**

GET : $app->get();<br>
POST : $app->post();<br>
PUT : $app->put();<br>
DELETE : $app->delete();<br>
ALL : $app->all();<br>

Configure your routes in private/core/Routes.php

**Differentes ways to declare your routes :**

$app->all(URL, FUNCTION(){ *// code...* });<br>
$app->all(URL, CONTROLLER); *// call index function by default*<br>
$app->all(URL, CONTROLLER@TEST); *// call function test*<br>
$app->all(URL, MIDDLEWARE, CONTROLLER); *// call index function of middleware by default*<br>
$app->all(URL, MIDDLEWARE@LOGIN, CONTROLLER); *// call function login*<br>

**Inject params in your URL :**

$app->all('/api/:id', function() {
  echo App::$vars['params']['id']; *// GET URL PARAMS*
});

**Validate params inject in your URL :**

$app->all('/api/num:id', ...); *// call function Valide::num() in private/core/Helper.php*<br>
$app->all('/api/^[a-z]*$:id', ...); *// call function Valide::regexp()*<br>
