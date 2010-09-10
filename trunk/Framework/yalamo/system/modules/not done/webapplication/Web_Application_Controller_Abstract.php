<?php
//definire le controllrer

Abstract Class WebApplicationController {
	
	Protected $registry;

	Public function __construct($registry) {
		$this->registry = $registry;
	}
	
	# Default method for controller all controller must define its body
	Abstract function Index();

}
?>