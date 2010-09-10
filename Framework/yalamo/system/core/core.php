<?php if ( ! defined('YPATH')) exit('Access Denied !');
//IMPLEMENT CORE FUNCTIONALITY


//Loader Class
class Loader {
public function  __construct() {
        ;
}
public function   __destruct() {
        ;
}
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
    $fullpath=MVCPATH."models/".ucwords($model).EXT;
    $this->Load($fullpath);
}
public function View($view){
    $fullpath=MVCPATH."views/".ucwords($view).EXT;
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

private function  Load($fullpath){
    if(file_exists($fullpath)){
        require_once ($fullpath);
    }
}

}


//Auto Loading
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


