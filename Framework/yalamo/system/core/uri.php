<?php
//Shsss, Silence is Golden !
Class Uri {

private $segments=array();  				//segments :     /controller/method/param1/param2/...    $_server['PATH_INFO']			  						//fullurl:	   http://localhost/index.php/controller/method/param1/param2/....
private $baseuri;		//define in userconfig	 						//baseurl        http://localhost/index.php
private $requesturl;            //full url in the client browser
private $querystr;              //query string

public function __construct(){
    $this->baseuri=SITEURL ;
    $this->requesturl=$this->RequestUrl();
    $this->querystr=str_replace($this->baseuri, "",  $this->requesturl );

   $this->segments=explode('/',$this->querystr);

   echo 'query='.$this->querystr.' ' ;
    
    var_dump($this->segments);
    var_dump(explode('/',$this->baseuri));
}

Public function Extract($num){
    if(array_key_exists($num , $this->segments)){
	return $this->segments[$num];
    }
    else {
	return false;
    }
}

public function GetFullUrl() {
    return $this->requesturl;
}

public function GetBaseUrl() {
    return $this->baseuri;
}

private function RequestUrl() {
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






Function YALCurrentController()
{
	$result=false;
	$url=new Uri() ;
	$result=$url->Extract(1);
	unset($url);
	
        echo 'heresultt: '. $result;
}

# Utilitis necessary for WebApplication Package: MVC
# Extract the second part of the url which is normally the current controller method
# return the controller method name or false if not set
Function YALCurrentControllerMethod()
{
	$result=false;
	$url=new Uri() ;
	$result=$url->Extract(2);
	unset($url);
	return $result;
}
