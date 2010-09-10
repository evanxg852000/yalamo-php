<?php
# The mediator class will choose wich Controller to use and which method to call

class WebApplicationMediator {

 Private $Registry;
 Private $ContollerPath ;
 Private $Args = array();
 Public $File;
 Public $Controller;
 Public $Action; 

 Public function __construct($registry) {
        $this->Registry = $registry;
		$this->ContollerPath=YALAMO_MVC_PATH."Controllers".DS ;
 }

 
 Private function GetController() {
	# Get the first part of the url to set the controller
	$this->Controller =ucwords(YALCurrentController()) ;
		
	if($this->Controller == false)
	{		
		$this->Controller=ucwords(DEFAULT_CONTROLLER);	
	}
	
	# Get the seconde part of the url to set the controller method
    $this->Action=ucwords(YALCurrentControllerMethod()) ;
	if ($this->Action == false)
	{
		$this->Action = 'Index';
	}

	# Set the controller File path 
	$this->File = $this->ContollerPath.$this->Controller.'_Controller_Class.php';

}

Public function LoadController()
 {
	#Set the Controller and its config
	$this->GetController();

	# Check the file existance and its readability
	if ((!file_exists($this->File)) and (!is_readable($this->File)))
	{
		$this->File ='mvc'.DS.'Errors'.DS.'Error404_Controller_Class.php';
        $this->Controller ="Error404";
	}

	# Include the controller 
	require_once($this->File) ;

	# Create the controller  instance 
	$class = $this->Controller ;
	$controller = new $class($this->Registry);

	
	# Check if the action is callable 
	if (is_callable(array($controller, $this->Action)) == false)
	{
		$action = 'Index';
	}
	else
	{
		$action = $this->Action;
	}
	
	# Execute the action
	$controller->$action();
	
 }


}
?>