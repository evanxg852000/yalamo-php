<?php if ( ! defined('YPATH')) exit('Access Denied !');
/*
 * CORE IMPLEMENTATION
 *
 *
 *
 * @author Evance Soumaoro
 */

/* Yalamo Class for Enumerating Supported Constants */
final class Yalamo {
    //List of constants
    const  None         = 0;
    


    const Pogsql        = "POSTGRESQL";
    const Mysql         = "MYSQL";
    const Sqlite        = "SQLITE";

    const  Void     ="";
    const  Space    =" ";
    const  All      ="*";
    const  Endline  ="\n";
    const  Tab      ="\t";


    
}



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


/* Auto Loading */
function Autoload($AutoLoadArray){
  $load=new Loader();
  $load->Modules($AutoLoadArray['modules']);
  $load->Helpers($AutoLoadArray['helpers']);
  $load->Extensions($AutoLoadArray['extensions']);
}
function __autoload($classname){
   $load=new Loader();
   $load->Module($classname);
}

