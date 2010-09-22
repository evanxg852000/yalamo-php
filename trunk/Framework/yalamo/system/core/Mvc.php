<?php if ( ! defined('YPATH')) exit('Access Denied !');
/*
 * MVC IMPLEMENTATION
 *
 *
 *
 * @author Evance Soumaoro
 */

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
abstract class Controller {
    protected $Variables;
    protected $Load;
    protected $Uri;
    protected $Model;


    public function __construct() {
        $this->Variables=array();
        $this->Load=new Loader();
        $this->Uri=new Uri();

    }
    abstract function Index(); 

}

