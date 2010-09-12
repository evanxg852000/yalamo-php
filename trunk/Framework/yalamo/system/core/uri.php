<?php if ( ! defined('YPATH')) exit('Access Denied !');

define('A', "B");
//URI CLASS IMPLEMENTATION
Class Uri {

private $baseuri;            //define in userconfig                         :  http://foo.com/
private $requesturi;         //full url in the client browser               :  http://foo.com/controller/method/param1/param2
private $segments=array();   //segments :                                   :  (controller, method , param1 , param2 )
private $controller;         //current requested controller
private $method;             //current requested method of the controller
private $querystr=array();   //array containing the query string             :  ( param1 , param2 )

public function __construct(){
    $this->controller=DEFAULTCONTROLLER;
    
    $this->baseuri=SITEURL ;
    $this->requesturi=$this->RequestUri();
    $segementstring=str_replace($this->baseuri, "",  $this->requesturi );
    $this->segments=explode('/',$segementstring);

    if(array_key_exists(0, $this->segments) ){
       if( $this->segments[0]!=""){
          $this->controller=$this->segments[0];
       }
    }

    if(array_key_exists(1, $this->segments)){
        $this->method=$this->segments[1];
    }
    else {
        $this->method="Index";
    }
    
    for($i=2; $i< count($this->segments);$i++ ){
        if(array_key_exists($i, $this->segments)){
             $this->querystr[]=$this->segments[$i];
        }
    }   
}

public function Base() {
    return $this->baseuri;
}
public function Full() {
    return $this->requesturi;
}
public function Segment($num){
    if(array_key_exists($num , $this->segments)){
	return $this->segments[$num];
    }
    else {
	return false;
    }
}
public function Controller() {
    return ucwords($this->controller);
}
public function Method() {
    return ucwords($this->method);
}
public function QueryString() {
    return $this->querystr;
}

private function RequestUri() {
    $url = 'http';
    $port='';
    if (isset($_SERVER["HTTPS"]) and ( $_SERVER["HTTPS"]== "on"))  {	$url .= "s"; }
     $url .= "://";
     if ($_SERVER["SERVER_PORT"] !== "80") {
	$port =':'.$_SERVER["SERVER_PORT"];
     }
     $url .= $_SERVER["SERVER_NAME"].$port.$_SERVER["REQUEST_URI"];
     return $url;
}

}


/*
$u=new Uri() ;
$u->Base();
$u->Full();
$u->Segment(1);
$u->Controller();
$u->Method();
$u->SQueryString();
*/



