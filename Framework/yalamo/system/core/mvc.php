<?php if ( ! defined('YPATH')) exit('Access Denied !');
//IMPLEMENT MVC FUNCTIONALITY



/* Class Mvc Definition */
final class Mvc {

private $mediator;

public function __construct(){
    $this->mediator=new Mediator();
}
public function  __destruct() {
    unset($this->mediator);
}
public   function Build() {
    // Loading  the controller
    $this->mediator->Route();
}

}


/* Class Mediator Definition */
final class Mediator {

private $controller;
private $method;
private $controllerinstance ;

public function __construct() {
    $uri=new Uri();
    $this->controller=$uri->Controller();
    $this->method=$uri->Method();
    $file=MVCPATH."controllers".DS.$this->controller.EXT;
    if ((!file_exists($file)) && (!is_readable($file))){
       $this->controller ="Error404";
    }
    //$this->registry = $registry;
    
 }
public function Route(){
    //load the controller file
    $loader=new Loader();
    $loader->Controller($this->controller) ;
    
    //create an instance of the controller
    $class = $this->controller ;
    $this->controllerinstance = new $class();

    //check if the method is callable
    if (is_callable(array($this->controllerinstance, $this->method)) == false){
        $this->method = 'Index';
    }
    //call the method
    $varmethod=$this->method;
    $this->controllerinstance->$varmethod();

}

}


/* Class Controller Definition */
abstract  class Controller {

protected $Load;
protected $Uri;
protected $Query;

public function __construct() {
    $this->variables=array();
    $this->Load=new Loader();
    $this->Uri=new Uri();
    $this->Query=new Query();
    //add additional important class that mig be called in the futur
}
abstract function Index(); //default method must be defined

}

