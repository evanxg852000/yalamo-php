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
 * @filesource          File.php
 */


/*
 * WEBSERVICE IMPLEMENTATION
 *
 * Contains implementation of web services SOAP and REST
 */

class Webservice extends Object{
    const Soap="SOAP";
    const Rest="REST";

    private $type;
    private $location;

    public function __construct($location,$type=Webservice::Rest){
    	$this->type=$type;
        $this->location=$location;
    }

    public function Server(& $object){
	if(! ($object instanceof IService) ){
            return $object->OnError("This object does not comply to a service server");
	}
        if($this->type==Webservice::Rest){
            $params=Uri::Instance()->QueryString();
            $method=ucwords(array_shift($params));
            if(count($params)==0){
                echo $object->$method();
            }
            else{
               echo $object->$method($params);
            }
        }
	else {
            $soap_server=new SoapServer($this->location);
            $soap_server->setClass(get_class($object));
            $soap_server->handle();
	}
    }
    public function Call($method,$params=null){
        if($this->type==Webservice::Rest){
            if(is_array($params)){
                $params="/".implode($params,"/");
            }
            return file_get_contents(urldecode(trim($this->location,"/")."/".$method."/".$params));
        }
        else{
            try{
                $params=serialize($params);
                $soap_client=new SoapClient($this->location);
                return $soap_client->__soapCall($method, array("params"=>$params));
            }
            catch (Exception $e){
                return $e->getMessage();
            }   
        }   
    }
  
}

//------------------------------------------------------------------------------
/**
 * Abstract Class IService
 *
 * Every class that is meant to serve web service functionalities
 * should inherite this abstract class
 * is actually an Interface but for the reason that Php only allow Public methods
 * in interfaces it is declared as an abstract class
 */
abstract class IService extends Component{
    protected $response;
    
    public function __construct() {
        $this->response='<?xml version="1.0"?><response>{response}</response>';
    }
    public function Respond($value){
        header("Content-type: text/xml") ;
        return str_replace("{response}",$value, $this->response);
    }
    public function OnError($message) {
        return $this->Respond($message);
    }
    public final function  __call($name, $arguments) {
        return $this->OnError("There is no service api that match '$name'  with passed args");
    }
}







