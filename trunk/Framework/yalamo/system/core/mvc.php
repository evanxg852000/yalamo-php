<?php if ( ! defined('YPATH')) exit('Access Denied !');
//IMPLEMENT MVC FUNCTIONALITY



/* Class Mvc Definition */
final class Mvc {

private $Variables=array();

public function __construct(){
    # Load Neccessary Packages
    $this->Variables[]='';
}

public   function Build() {
     # The registry object
     $registry = new Registry();

     # The  mediator
     $registry->Mediator = new Mediator($registry);

     # The view instance
     $registry->View = new View($registry);

     # Loading  the controller
     $registry->Mediator->LoadController();

}


}


/* Class Registry Definition */
final class Registry {

private $Variables=array();

# constructor
public function __construct(){}
public function  __toString() {
   return 'I am a registry object';
}

#Public magic methode to set properties in the $vars array
public function __set($key, $val){
    $this->Variables[$key] = $val;
 }

# Public magic method to get properties in the $vars array
public function __get($key) {
    return $this->Variables[$key];
}

}


/* Class Mediator Definition */
final class Mediator {

 private $registry;
 private $contollerpath ;
 private $args = array();

 public  $File;
 public  $Controller;
 public  $Action;

 Public function __construct($registry) {
    $this->registry = $registry;
    $this->contollerpath=MVCPATH."controllers".DS ;
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
    if ($this->Action == false){
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


/* Class Controller Definition */
abstract  class Controller {

//protected $Registry;
protected $Load;
protected $Database;
protected $View;


public function __construct($registry) {
    $this->registry = $registry;
    $this->Load=new Loader();
    $this->Database=Database::GetInstance();
    $this->View=$registry->View;
    //add additional important class that mig be called
}

# Default method for controller all controller must define its body
abstract function Index();

}


/* Class View Definition */

class View {

private $registry ;
private $vars=array();

#Public constructor using a registry as parameter
Public function __construct($registry){
    $this->registry = $registry;
}

#Public magic methode to set properties
public function __set($key, $val){
    $this->vars[$key] = $val;
}

#Public method to load the view
Public function LoadView($controller_name,$view_name,$data=Null){
    $controller_name=ucwords($controller_name);
    $view_name=ucwords($view_name);

    $ViewPath ='mvc'.DS.'views'.DS.$controller_name.'_'. $view_name . '_View.php';

    if (!file_exists($ViewPath)){
	require_once('errors'.DS.'error404.php');
	return false;
    }

    # Load variables by the variable variables trick
    foreach ($this->vars as $key => $val){
	$$key = $val;
    }
    if( $data!=Null){
	foreach ($data as $key => $val){
            $$key = $val;
	}
    }
    require_once($ViewPath);
}


}