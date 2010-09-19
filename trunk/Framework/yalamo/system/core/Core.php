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
 * @version		Version 1.0
 * @filesource          Userconfig.php
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
//constants
    const  None         = 0;
    

    const Pogsql        = "POSTGRESQL";
    const Mysql         = "MYSQL";
    const Sqlite        = "SQLITE";

    const  Void     ="";
    const  Space    =" ";
    const  All      ="*";
    const  Endline  ="\n";
    const  Tab      ="\t";

//functions
    public static function  Autoload($AutoLoadArray){
      $load=new Loader();
      $load->Modules($AutoLoadArray['modules']);
      $load->Helpers($AutoLoadArray['helpers']);
      $load->Extensions($AutoLoadArray['extensions']);
    }
    /* Get application Variable*/
    public static function AppConfig($key){
        global  $AppVaribles;
        if(array_key_exists($key,$AppVaribles)) {
            return $AppVaribles[$key];
        }
        else{ return false; }
    }

    
}


//------------------------------------------------------------------------------
/* Loader Class */
final class Loader {

public function  __construct() {}
public function   __destruct() {}
public function   __toString() {
    return "Load script from different location";
}

/*
<YalDocElem>
Name | Type | Description | $this->Load->Module('file');
</YalDocElem>
*/
public function Module($module){
   $fullpath=YMODULEDIR.ucwords($module).EXT;
   $this->Load($fullpath);
}
public function Helper($helper){
   $fullpath=YHELPERSDIR.ucwords($helper).EXT;
   $this->Load($fullpath);
}
public function Extension($extension){
   $fullpath=YEXTENTIONDIR.ucwords($extension).EXT;
   $this->Load($fullpath);
}
public function Model($model){
    $fullpath=MVCPATH."models".DS.ucwords($model).EXT;
    $this->Load($fullpath);
    return new $model(); //return the model object to work on
}
public function View($view,$data=Null){
    $fullpath=MVCPATH."views".DS.ucwords($view).EXT;
    $this->Load($fullpath,$data);
}
public function Controller($controller){
    $fullpath=MVCPATH."controllers".DS.ucwords($controller).EXT;
    $this->Load($fullpath);
}

/*
<YalDocElem>
Name | Type | Description | $this->Load->Module(array('file','url'));
</YalDocElem>
*/
public function Modules($modules){
   foreach($modules as $module ){
      $this->Module($module);
   }
}
public function Helpers($helpers){
   foreach($helpers as $helper ){
      $this->Helper($helper);
   }
}
public function Extensions($extensions){
   foreach($extensions as $extension ){
      $this->Extension($extension);
   }
}

private function  Load($fullpath, $data=NULL){
    //convert $data into variables by: var var trick
    if( $data!=Null){
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
/* Php internal auto loading */
function __autoload($classname){
   $load=new Loader();
   $load->Module($classname);
}
/*Framework auto Loading */
function Autoload($AutoLoadArray){
    Yalamo::Autoload($AutoLoadArray);
}

function  AppConfig($key){
    return Yalamo::AppConfig($key);
}