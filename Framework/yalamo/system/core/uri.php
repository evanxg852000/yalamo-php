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

public function GetBase() {
    return $this->baseuri;
}
public function GetFull() {
    return $this->requesturi;
}
public function GetSegment($num){
    if(array_key_exists($num , $this->segments)){
	return $this->segments[$num];
    }
    else {
	return false;
    }
}
public function GetController() {
    return ucwords($this->controller);
}
public function GetMethod() {
    return ucwords($this->method);
}
public function GetQueryString() {
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
$u->GetBase();
$u->GetFull();
$u->GetSegment(1);
$u->GetController();
$u->GetMethod();
$u->GetQueryString();
*/



