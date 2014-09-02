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

**CONTROLLER AND MIDDLEWARE USAGE**

"admin/user@create" in $app->(URL, "admin/user@create") is the controller's path.<br>
*"admin/user@create" will search the function create() in class User at private/controllers/admin/user.php (insensitive case path)*<br>

"admin/user@isconnected" in $app->(URL, "admin/user@isconnected", CONTROLLER) is the middleware's path.<br>
*"admin/user@isconnected" will search the function create() in class User at private/middlewares/admin/user.php (insensitive case path)*<br>

MIDDLEWARE Return Values :
- Success => return true
- Error   => return false OR App::send(STATUT, ERR_MSG);

CONTROLLER Return Values :
- Success => return App::send(E200, DATA);
- Error   => return false OR App::send(STATUT, ERR_MSG);

**DATABASE**

SQL to Tiny-Db :<br>
Base  => Directory<br>
Table => File<br>
Row   => JSON Object<br>

Open/Create a file : $db = new Database(DIRECTORY, FILENAME);

Read : $db->find($options); or $db->findFirst($options);<br>
Create : $db->create($data, $prototype);<br>
Update : $db->update($options, $data, $prototype);<br>
Delete : $db->delete($options);<br>

$options => array("JSON");<br>
Exemple : 'name eq "toto"' in SQL => where name = "toto"<br>

OPERATORS :<br>
gt  : > <br>
gte : >= <br>
lt  : < <br>
lte : <= <br>
eq  : == <br>
ne  : != <br>
in  : in_array() <br>
nin  : !in_array() <br>
min, max, exact : strlen() <br>
pwd : crypt() <br>
regexp : regular expression<br>

**DATABASE PROTOTYPE**

Declare in private/core/Prototype.php to validate data before save it.<br>

<pre>
static $user = array(
    fieldName => array(
        propertie => value
    )
);
</pre>

PROPERTIES & VALUES :<br>
<b>type :</b><br>
  str   (validate only string value)<br>
  num   (validate only numeric value)<br>
  int   (validate only numeric and positive value)<br>
  email (validate only email value)<br>
  tab   (validate only array value)<br>
  obj   (validate only object value)<br>
<b>key :</b><br>
  unique  (validate only if value is unique)<br>
  ai      (assign an autoincrement value, must be type num or int)<br>
<b>default :</b> <br>
  false       (validate only if value exist, the field become non-optional)<br>
  "any value" (assign a default value)<br>
<b>operators with conditional value</b> (gt, gte, lt, lte, eq, ne, in, min, max, exact, pwd, regexp)<br>

<pre>
class Prototype {
  static $user = array(
    "_id"  => array(
        "type" => "num", "key" => "ai"
    ),
    "name" => array(
        "type" => "str", "default": "Toto", "min": 6, "max": 30
    ),
    "email" => array(
        "type" => "email", "default": false
    )
  );
}
</pre>

Informations
------------

You can easily develop a web application which can use the API and put it in public/ folder!

Remember, Tiny-PHP-API is meant to help you create a web application easily thinking about writting any backend code.
The database is a tiny No-SQL solution for JSON data.
If you want to put your application into production, I would recommend you to use MongoDB as Database.

Have fun!
