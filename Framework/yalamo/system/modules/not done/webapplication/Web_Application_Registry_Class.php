<?php
#definire le registry

Class WebApplicationRegistry {

	Private $vars=array();
	
	# constructor
	Public function __construct()
	{

	}
	
	#Public magic methode to set properties in the $vars array
	Public function __set($key, $val)
 	{
        $this->vars[$key] = $val;
 	}
	
	# Public magic method to get properties in the $vars array
	Public function __get($key)
 	{
		return $this->vars[$key];
 	}
	
}
?>