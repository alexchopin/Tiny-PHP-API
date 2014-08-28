<?php
// PROTOTYPE
// Type : str, num, email, tab, obj
// Key 	: unique, ai
// Default : "default value", false(obligatoire)
// eq, gt, gte, lt, lte, ne, in, min, max, exact
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