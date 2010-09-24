<?php if ( ! defined('YPATH')) exit('Access Denied !');
/**
 * Yalamo framework
 *
 * A fast,light, and constraint-free Php framework.
 *
 * @package		Yalamo
 * @author		Evance Soumaoro
 * @copyright           Copyright (c) 2009 - 2011, Evansofts.
 * @license		http://projects.evansofts.com/yalamof/license.html
 * @link		http://evansofts.com
 * @version		Version 0.1
 * @filesource          Core.php
 */

/*
 * MVC IMPLEMENTATION
 *
 * The definition of the mvc functionality
 */



//------------------------------------------------------------------------------
/**
 * Mvc Class
 *
 * The class that define the mvc entry point
 */
final class Mvc {
    private $mediator;

    public function __construct(){
        $this->mediator=new Mediator();
    }
    public function __destruct() {
        unset($this->mediator);
    }
    public function Build() {
        // Loading  the controller
        $this->mediator->Route();
    }

}

//------------------------------------------------------------------------------
/**
 * Mediator Class
 *
 * The class that define the mvc mediator which chose where to route the navigation
 * process
 */
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

//------------------------------------------------------------------------------
/**
 * Controller Class
 *
 * The class that define the mvc controller base class and its base fucntionalities
 * and members
 */

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

