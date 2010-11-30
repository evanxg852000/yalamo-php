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
 * @filesource          Core.php
 */

/*
 * URI IMPLEMENTATION
 *
 * Definition of the uri functionalities
 */

//------------------------------------------------------------------------------
/**
 * Yalamo Class
 *
 * The class that contains the framework enumeration and static methods
 * to do useful thing.
 */
Class Uri extends Singleton{
    const Page="{page}";
    const Controller="{controller}";

    private static $instance=null;
    
    private $uri_config;

    /**
     * Base uri, define in Userconfig.php file is the web app url
     * @var string
     * @example http://evansofts.com/
     */
    private $base_uri;

    /**
     * Full uri in the client browser
     * @var string
     * @example http://evansofts.com/services/consultancy/option/vip
     */
    private $request_uri;

    private $full_uri;
    
    /**
     * The uri segments
     * @var array
     * @example  [services, consultancy, option,vip ]
     */
    private $segments=array();

    /**
    * The current requested page in classic mode
    * @var string
    * @example  services
    */
    private $page;

    /**
     * The current requested controller
     * @var string
     * @example  services
     */
    private $controller;

    /**
     * The current requested action of the controller
     * @var string
     * @example  consultancy
     */
    private $action;

    /**
     * The array containing the query string
     * @var array
     * @example [ option,vip ]
     */
    private $query_string=array();

    /**
     * Constructor
     */
    private function __construct(){
        $this->uri_config= cf("URI/");
        $this->base_uri=$this->uri_config["BASE"];
        $this->setupuri();
        $this->checkmap();
        $this->segments=explode("/",$this->request_uri);

        //initialise using uri scheme;
        $this->uri_config["SCHEME"]=trim($this->uri_config["SCHEME"],"/");
        //classic mode
        if($this->uri_config["MODE"]===Yalamo::Classic){
            $this->page=$this->uri_config["DEFAULTPAGE"];
            $page_position= array_keys(explode("/", $this->uri_config["SCHEME"]),Uri::Page);
            $page_position=$page_position[0];
            //page
            if(isset($this->segments[$page_position])){
                $this->page=$this->segments[$page_position];
            }       
            //query string
            $c=count($this->segments);
            for($i=$page_position+1; $i<$c;$i++ ){
                if(isset($this->segments[$i])){
                    $this->query_string[]=$this->segments[$i];
                    $_GET[$i]=$this->segments[$i];
                }
            }
            $this->controller=null;
            $this->action=null; 
        }
        //mvc mode
        else {
            $this->controller=$this->uri_config["DEFAULTCONTROLLER"];
            $controller_position= array_keys(explode("/", $this->uri_config["SCHEME"]),Uri::Controller);
            $controller_position=$controller_position[0];

            //controller
            if((isset($this->segments[$controller_position])) && (!empty($this->segments[$controller_position])) ){
                   $this->controller=$this->segments[$controller_position];
            }
            //action
            if((isset($this->segments[$controller_position+1])) && (!empty($this->segments[$controller_position+1]))){
                $this->action=$this->segments[$controller_position+1];
            }
            else {
                $this->action="index";
            }
            //query string
            $c=count($this->segments);
            for($i=$controller_position+2; $i<$c;$i++ ){
                if(isset($this->segments[$i])){
                    $this->query_string[]=$this->segments[$i];
                    $_GET[$i]=$this->segments[$i];
                }
            }
            $this->page=null;    
        }
    }
        
    public static function Instance(){
        if(!self::$instance){
            self::$instance=new Uri();
        }
        return self::$instance;
    }

    /**
     *@access private
     * @return string
     */
    private function setupuri() {
        $this->full_uri =(isset($_SERVER["HTTPS"]) && ( $_SERVER["HTTPS"]== "on"))? "https://" :"http://" ;
        if(isset($_SERVER["SERVER_NAME"])){
            $this->full_uri .=$_SERVER["SERVER_NAME"];
        }
        if ((isset($_SERVER["SERVER_PORT"])) && ($_SERVER["SERVER_PORT"] !== "80")) {
            $this->full_uri .=':'.$_SERVER["SERVER_PORT"];
        }
       //check if we are in sub folder or webroot
       $SubFolder=trim(str_replace($this->full_uri,"", $this->base_uri),"/");
       if(!empty($SubFolder)){
           $this->full_uri.="/".$SubFolder;
       }
        //1st chance
        if (isset($_GET) && count($_GET) == 1 && trim(key($_GET), '/') != ''){
            $this->request_uri=trim(key($_GET),"/");
            $this->full_uri .="/".$this->request_uri;
            return ;
        }
       //2nd chance
       if($_SERVER["QUERY_STRING"]){
            $this->request_uri=trim($_SERVER["QUERY_STRING"],"/");
            $this->full_uri .="/".$this->request_uri;
            return ;
        }
        //3rd chance
        if(isset ($_SERVER["REQUEST_URI"])){
            $this->request_uri=trim(str_replace($SubFolder,"",$_SERVER["REQUEST_URI"]),"/");
            $this->full_uri .="/".$this->request_uri;
            return ;
        }
        //last chance
        if(isset($_SERVER["PATH_INFO"])){
            $this->request_uri=trim($_SERVER["PATH_INFO"],"/");
            $this->full_uri .="/".$this->request_uri;
            return ;
        }
        
    }

    /* check map for routing */
    private function checkmap(){
        if(isset($this->uri_config["MAP"][$this->full_uri."/"])){
             $this->Redirect($this->uri_config["MAP"][$this->full_uri."/"]);
        }
    }

        /**
     * The accessor to the base uri
     * 
     * @return string The base uri
     */
    public function Base() {
        return $this->base_uri;
    }

    /**
     * The accessor to the full uri
     * 
     * @return string The full uri
     */
    public function Full() {
          return $this->full_uri;
    }

    /**
     * The accessor to the  page of the uri
     *
     * @return String The page of the uri
     */
    public function Page() {
        return ucwords($this->page);
    }

    /**
     * The accessor to the  controller of the uri
     *
     * @return String The controller of the uri
     */
    public function Controller() {
        return ucwords($this->controller);
    }

    /**
     * The accessor to the  action of the uri
     *
     * @return String The method of the uri
     */
    public function Action(){
        return ucwords($this->action);
    }

    /**
     * The accessor  to a portion of the uri
     *
     * @param int $num  The index of the uri registry
     * @return string   The portion value
     */
    public function Segment($num){
        if(isset($this->segments[$num])){
            return $this->segments[$num];
        }
        return false;
    }
    
    public function Params($num){
        if(isset($this->query_string[$num ])){
            return $this->query_string[$num];
        }
        return false;
    }

    /**
     * The accessor to the  query_stringing of the uri
     * 
     * @return String The query_stringing of the uri
     */
    public function QueryString() {
        return $this->query_string;
    }

    /**
     * The methode to redirect the user
     *
     * @param string $url The new location
     */
    public function Redirect($url){
        header("Location: $url" );
        exit ();
    }

    /**
     * This method create a url(to be used as href ) in mvc mode
     *
     * @param string $controller The controller of the url
     * @param string $method     The method of the url
     * @param strign $params     The query string
     */
    public function CreateMvc($controller,$method,$params=null,$prefix=null){
        //TODO: link
        $paramstr=Yalamo::Void;
        if(is_array($params)){
            foreach($params as $param){
                $paramstr .="/".$param;
            }
        }
        if(substr($this->Base(), -1)==="/"){
         return $this->Base()."$controller/$method/$paramstr";
        }
        return $this->Base()."/$controller/$method/$paramstr";
    }

    /**
     * This method create a url(to be used as href ) in classic mode
     *
     * @param string $page       The page name
     * @param strign $params     The query string
     */
    public function CreateClassic($page,$params=null,$prefix=null){
        //TODO: link 
        $paramstr=Yalamo::Void;
        if(is_array($params)){
            foreach($params as $param){
                $paramstr .="/".$param;
            }
        }
        if(substr($this->Base(), -1)==="/"){
         return $this->Base()."$page/$paramstr";
        }
        return $this->Base()."/$page/$paramstr";
    }

}
