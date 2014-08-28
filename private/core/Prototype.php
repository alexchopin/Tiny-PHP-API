<?php
class Prototype {	
	static $user = array(
		"_id"	 => array("type" => "num","key"	=> "ai"),
		"pseudo" => array(
			"type" 		=> "str",
			"default" 	=> false,
			"key" 		=> "unique",
			"min" 		=> 3
		),
		"age" => array(
			"type" 		=> "num",
			"gte" 		=> 6,
			"default" 	=> 10
		),
		"email" => array(
			"type" 		=> "email",
			"default" 	=> "aucun"
	));
}



?>