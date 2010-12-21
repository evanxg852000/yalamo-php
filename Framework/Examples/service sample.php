<?php
//Rest
//server
    $s=new Webservice(Webservice::Rest);
    $service_obj=$this->Load->Component("greeting", Component::Controller);
    $s->Server($service_obj);
//client
   $s=new Webservice("http://localhost/Framework/welcome/index/",Webservice::Rest);
   $response=$s->Call("african","guerze");
   $x=new Xml($response);
   echo $response;

//-------------------------------
//Soap
//server
     $s=new Webservice("http://localhost/service/wsdl.wsdl",Webservice::Soap);
    $service_obj=$this->Load->Component("greeting", Component::Controller);
    $s->Server($service_obj);
//client
    $s=new Webservice("http://localhost/service/wsdl.wsdl",Webservice::Soap);
    $response=$s->Call("african","guerze");
    $x=new Xml($response);
    echo $response;


    //service sample
    //NOTE For Soap server class the params should be unserialized to be usable
 //controllers/componets/Greeting.php
    class Greeting extends IService{
    public function  __construct() {
        parent::__construct();
    }

    public function English($params=null){
        return $this->Respond("Hello world");
    }

    public function French($params=null){
        return $this->Respond("Bonjour le monde");
    }

    public function African($params=null){
        //for soap service $params=unserialize($params);
        if(is_null($params)){
            return $this->Respond("Manbo dunia");
        }
        switch ($params[0]){
            case "guerze":
                return $this->Respond("Yaghoun Yene");
                break;
            case "swahili":
                return $this->Respond("Manbo dunia");
                break;
        }

    }

}