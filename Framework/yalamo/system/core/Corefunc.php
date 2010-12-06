<?php if ( ! defined('YPATH')) exit('Access Denied !');
/**
 * Php internal auto loading
 *
 * @param string $classname The name of the class that's trying to be instanciated
 */
function __autoload($classname){
  Loader::Instance()->Module($classname);
}

// base/sub/sub2/
function cf($path){
    global $BASECONFIG, $URICONFIG, $APPCONFIG ,$DATABASECONFIG;
    $path=explode("/",trim($path,"/"));
    if(count($path)<1){
        return false;
    }
     $category=$path[0]."CONFIG";
     
     $array=(isset($$category))? $$category: array();
     $result=false;
    switch (count($path)) {
        case 1:
            $result=$array;
            break;
         case 2:
            $section=$path[1];
            $result=(isset($array[$section]))? $array[$section] : false  ;
            break;
         case 3:
            $section=$path[1];
            $item=$path[2];
            $result=(isset($array[$section][$item]))? $array[$section][$item] : false  ;
            break;
    }
    return $result;


}

function pr($data){
    echo Sanitizer::ForOut($data);
}

function y($data){
    echo $data;
}

function _y($object){
    print_r($object);
}

function tr(){
    echo "translation function not implemetated";
}





