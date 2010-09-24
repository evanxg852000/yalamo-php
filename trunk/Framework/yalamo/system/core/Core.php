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
 * CORE IMPLEMENTATION
 *
 * Contains the base class implementation and very usefull constants that form
 * the back bone of the framework
 *
 */

//------------------------------------------------------------------------------
/**
 * Yalamo Class
 *
 * The class that contains the framework enumeration and static methods
 * to do useful thing.
 */
final class Yalamo {
    const  None         = 0;
    const  Unic         = 1;
    const  Double       = 2;

    const  Pogsql       = "POSTGRESQL";
    const  Mysql        = "MYSQL";
    const  Sqlite       = "SQLITE";

    const  Void         ="";
    const  Space        =" ";
    const  All          ="*";
    const  Endline      ="\n";
    const  Tab          ="\t";
    const  Fileonly     ="FO";
    const  Dironly      ="Do";

    const  Ds       =DS;
   
    /**
     * Loads the files contained in the $AutoLoadArray array
     * @param array $AutoLoadArray The User defined array
     */
    public static function  Autoload($AutoLoadArray){
      $load=new Loader();
      $load->Modules($AutoLoadArray['modules']);
      $load->Helpers($AutoLoadArray['helpers']);
      $load->Extensions($AutoLoadArray['extensions']);
    }
    
}


//------------------------------------------------------------------------------
/**
 * Loader Class
 *
 * The class that contains the framework enumeration and static methods
 * to do useful thing.
 */
final class Loader {
    public function  __construct() {}
    public function  __destruct() {}
    public function  __toString() {return "Object of Type: Loader"; }

    /**
     * Loads a Module from the modules directory
     *
     * @param string $module The module name
     */
    public function Module($module){
        $fullpath=YMODULEDIR.ucwords($module).EXT;
        $this->Load($fullpath);
    }

    /**
     * Loads a Helper from the helpers directory
     *
     * @param string $helper the helper name
     */
    public function Helper($helper){
        $fullpath=YHELPERSDIR.ucwords($helper).EXT;
        $this->Load($fullpath);
    }

    /**
     * Loads an Extension from the Extensions directory
     *
     * @param string $extension The extension name
     */
    public function Extension($extension){
        $fullpath=YEXTENTIONDIR.ucwords($extension).EXT;
        $this->Load($fullpath);
    }

    /**
     * Loads a Model from the mvc models directory and instanciate it
     *
     * @param string $model The model name
     * @return Model        An instance of the loade model
     */
    public function Model($model){
        $fullpath=MVCPATH."models".DS.ucwords($model).EXT;
        $this->Load($fullpath);
        return new $model();
    }

    /**
     * Loads a view from the mvc views directory
     *
     * @param string $view  The view name
     * @param mixed  $data  The optional data to be passed in
     */
    public function View($view,$data=Null){
        $fullpath=MVCPATH."views".DS.ucwords($view).EXT;
        $this->Load($fullpath,$data);
    }

    /**
     * Loads a Controller from the mvc controllers directory
     *
     * @param string $controller The controller name
     */
    public function Controller($controller){
        $fullpath=MVCPATH."controllers".DS.ucwords($controller).EXT;
        $this->Load($fullpath);
    }

    /**
     * Loads Modules from the modules directory
     * @param array $modules The names of the modules
     */
    public function Modules($modules){
       foreach($modules as $module ){
          $this->Module($module);
       }
    }

     /**
     * Loads Helpers from the helpers directory
      *
     * @param array $helpers The names of the helpers
     */
    public function Helpers($helpers){
       foreach($helpers as $helper ){
          $this->Helper($helper);
       }
    }

    /**
     * Loads Extensions from the Extensions directory
     *
     * @param array $extensions The names of the extensions
     */
    public function Extensions($extensions){
       foreach($extensions as $extension ){
          $this->Extension($extension);
       }
    }

    /**
     * Load a php file from any path specified. return false if not found
     *
     * @param string $fullpath
     * @param mixe $data  The  data to be passed in
     * @return false|null
     */
    private function  Load($fullpath, $data=null){
        if( $data!=null){ //convert $data into variables by: var var trick
            if(is_array($data)){
               foreach ($data as $key => $val){
                    $$key = $val;
               }
            }
        }
        if(file_exists($fullpath)){
            require_once ($fullpath);
        }
        else{
            return false;
        }

    }

}

//------------------------------------------------------------------------------
/**
 * ISerialisable Interface
 *
 * The Interface for serialisable object.
 */
interface ISerialisable {
    public function Serialize();
    public function Unserialize($object);
}

//------------------------------------------------------------------------------
/**
 * Abstract Class ICollectable 
 *
 * Every class that raise yalamo error to be collected by the Inspector
 * should implement to get more hierarchical capabilities
 * is actually am Interface but for the reason that Php only allow Public methods
 * in interfaces it is declared as an abstract class
 */
abstract class ICollectable{
    abstract protected function Collect($errortype);
}

//------------------------------------------------------------------------------
/**
 * Object Class
 *
 * The base Object of classes that want to use base functionalities without
 * implementing base interfaces
 */
class Object  extends ICollectable implements ISerialisable {
    
    /**
     * The serialise method 
     * @return string The Object in string format
     */
    public function Serialize(){
        return serialize($this);
    }

    /**
     *
     * @param  string $Object   The object in string format
     * @return Object           The object in pure Object format
     */
    public function Unserialize($Object){
        return (Object) unserialize($Object);
    }

    /**
     * The methode that makes a derived class collectable by the inspector
     * and provide for that reason an easy way to raise error on that object
     *
     * @param Error::Enum $errortype
     */
    protected function Collect($errortype) {
        $inspector=Inspector::Instance();
        $inspector->Add($errortype,  $this);
    }

}



//------------------------------------------------------------------------------
/**
 * Php internal auto loading
 *
 * @param string $classname The name of the class that's trying to be instanciated
 */
function __autoload($classname){
   $load=new Loader();
   $load->Module($classname);
}
