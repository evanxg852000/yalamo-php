<?php
#definire le the view loader

Class WebApplicationView {
	
	Private $registry ;
	Private $vars=array();
	
	#Public constructor using a registry as parameter
	Public function __construct($registry)
	{
		$this->registry = $registry;
	}
	
	#Public magic methode to set properties
	Public function __set($key, $val)
 	{
        $this->vars[$key] = $val;
 	}
	
	#Public method to load the view
	Public function LoadView($controller_name,$view_name,$data=Null)
	{
		$controller_name=ucwords($controller_name);
		$view_name=ucwords($view_name);
		
		$ViewPath ='mvc'.DS.'views'.DS.$controller_name.'_'. $view_name . '_View.php';

		if (!file_exists($ViewPath))
		{	
			require_once('errors'.DS.'error404.php'); 
			return false;
		}
	
		# Load variables by the variable variables trick
		foreach ($this->vars as $key => $val)
		{
			$$key = $val;
		}
		if( $data!=Null)
		{
			foreach ($data as $key => $val)
			{
				$$key = $val;
			}
		}
		require_once($ViewPath);    
	}
	
	
}
?>