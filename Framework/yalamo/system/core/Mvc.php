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
 * The core calss of the mvc patern in the framework
 */
final class Mvc extends Object{
    private $mediator;

    /**
     * Constructor of the Mvc class
     */
    public function __construct(){
        $this->mediator=new Mediator();
    }
    public function __destruct() {
        unset($this->mediator);
    }

    /**
    * This method load the right controller by using the route method
     * of the mediator to assemble the pieces of the page
    */
    public function Build() {
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
final class Mediator extends Object{
    private $page;
    private $controller;
    private $action;
    private $controller_instance;

    /**
     * Constructor get the current controller and sets up the mediator member variables
     */
    public function __construct() {
        $uri=Uri::Instance();
        $this->page=$uri->Page();
        $this->controller=$uri->Controller();
        $this->action=$uri->Action();
           
        if( cf("RUI/MODE")===Yalamo::Classic){
            $file=$this->page.EXT;
            if ((!file_exists($file)) || (!is_readable($file))){
               $this->page="Error404";
            }
        }
        else{
           $file=cf("BASE/MVCPATH")."controllers".DS.$this->controller.EXT;
           if ((!file_exists($file)) || (!is_readable($file))){
               $this->controller ="Error404";
           }
        }  
     }

    /**
     *  This method loads the controller and call its method
     */
    public function Route(){
        $load=new Loader();
        if(cf("RUI/MODE")==Yalamo::Classic){
            $load->Page($this->page);
            return;
        }
       
        //if not then load the controller file
        $load->Controller($this->controller) ;
        //create an instance of the controller
        $class = $this->controller ;
        $this->controller_instance = new $class();
        if(!is_subclass_of($this->controller_instance,Controller::Baseclass)){
            $this->Collect(Error::YE002);
            return;  
        }
         //check if the action is not empty
         if($this->action==Yalamo::Void){
             $this->action = 'Index';
         }
        //check if the action is callable
        if (! is_callable(array($this->controller_instance, $this->action))){
            $load->Page("Error404");
            exit();
        }
        //call the action
        $var_action=$this->action;
        $this->controller_instance->$var_action();
    }

}

//------------------------------------------------------------------------------
/**
 * Controller Class
 *
 * The class that define the mvc controller base class and its base fucntionalities
 * and members
 */
abstract class Controller extends Object {
    const Baseclass="Controller";

    /**
     * @var array Variables of the controller that can be passed as data parameter
     *            when loading the view
     */
    protected $Variables;

    /**
     * @var Loader $Load The Loader object available to load all sort of stuff it can
     */
    protected $Load;

    /**
     * @var Uri  $Uri The uri object that can serve to retrieve info like query string
     */
    protected $Uri;

    /**
     * @var Model $Model The model of this controller note initialised here and should be to take advantage of it
     *                   again this is important when the controller operate on one model as gather data from subclasses
     *                   of Table class 
     */
    protected $Model;

    /**
     * Constructor that initialise the protected members that are important
     * in a controller subclass
     * Sould be called in any subclass constructor 
     */
    public function __construct() {
        $this->Variables=array();
        $this->Load=new Loader();
        $this->Uri=Uri::Instance();
        $this->Model=$this->Load->Model(get_class($this));
    }
    
    final protected function Set($name,$value){
        $this->Variables[$name]=$value;
    }

    final protected function Component($name){
        return $this->Load->Component($name, "controllers");
    }

    final protected function Delegate($action) {
        //get the name of the subcontroller
        $sub_controller= $this->Uri->Controller().$this->Uri->Action();

        $this->Load->Controller($sub_controller);
        $sub_instance=new $sub_controller();
        if(!is_subclass_of($sub_instance, Controller::Baseclass)){
            $this->Collect(Error::YE002);
            return;
        }
        if($action==Yalamo::Void){
            $action="Index";
        }
        //check if the action is callable
        if (!is_callable(array($sub_instance, $action))){
            $this->Load->Page("Error404");
            exit();
        }
        //call the action
        $sub_instance->$action();
    }

    /**
     * Abstract default method that must be implemented in every controller's subclass
     * this method is called when there not a action specified from the url or the method is not callable
     */
    abstract function Index();

} 

