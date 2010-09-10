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
public function Module($name){
   $classname=ucwords($name);
   $fullpath=YMODULEDIR.$classname.EXT;
   $this->Load($fullpath);
}
public function Helper($name){
   $fullpath=YHELPERSDIR.ucwords($name).EXT;
   $this->Load($fullpath);
}
public function Extension($name){
   $fullpath=YEXTENTIONDIR.ucwords($name).EXT;
   $this->Load($fullpath);
}

/*
<YalDocElem>
Name | Type | Description | $this->Load->Module(array('file','url'));
</YalDocElem>
*/
public function Modules($names){
   foreach($names as $name ){      
      $this->Module($name);
   }
}
public function Helpers($names){
   foreach($names as $name ){
      $this->Helper($name);
   }
}
public function Extensions($names){
   foreach($names as $name ){
      $this->Extension($name);
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


