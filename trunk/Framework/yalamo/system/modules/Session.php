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
 * @filesource          Session.php
 */

/*
 * SESSION IMPLEMENTATION
 *
 * Contains session handling functionalities
 */

//------------------------------------------------------------------------------
/**
 * Session Class
 *
 * Define methods to create and manipulate sessions
 */
class Session extends Object {
    private static  $resgistry;
    private $id;
    private $is_session_cookie_active;
    private $object;
    private $cookie;
    private $cookie_name;
    private $session_refresh;
    private $is_safe;

 
    public function  __construct() {
        session_start();
        $this->id=session_id();
        $this->is_session_cookie_active=cf("APP/USESESSIONCOKIE");
        if(!$this->is_session_cookie_active){
            return;
        }        
        $this->cookie_name=cf("APP/SESSIONCOOKIE");
        $this->session_refresh=cf("APP/SESSIONREFRESH");
        $this->cookie=new Cookie("20M","/");
        $this->is_safe=false;

        if(!isset($_SESSION[$this->cookie_name])){
            //fisrt visit
            $this->create_session_object();
            $this->is_safe=true;
        }
        else {
            //session has been already created so verify the ingtegrity
            $this->object=@unserialize($_SESSION[$this->cookie_name]);
            $session_object= @unserialize($this->cookie->Get($this->cookie_name));
            if($this->object==$session_object){
                //update that object after 5 min
                if((time()-$this->object->st) >=$this->session_refresh*60 ){
                    $this->create_session_object();
                }
                $this->is_safe=true;
            }
        }
        self::$resgistry=$_SESSION;
    }

    public function Id(){
        return $this->id;
    }
    public function Registry(){
        if(!$this->is_session_cookie_active){
           return self::$resgistry;
        }
        else if($this->is_safe){
            return self::$resgistry;
        }
    }
    public function Set($key, $value){
        if(!$this->is_session_cookie_active){
            $_SESSION[$key]=$value;
            self::$resgistry=$_SESSION;
            return true;
        }
        else if($this->is_safe){
            $_SESSION[$key]=$value;
            self::$resgistry=$_SESSION;
            return true;
        }
        return false;
    }    
    public function Get($key){
        if(!$this->is_session_cookie_active){
            if((array_key_exists($key, self::$resgistry)) && (array_key_exists($key, $_SESSION))){
                return self::$resgistry[$key];
            }
            return;
        }
        else if($this->is_safe){
            if((isset(self::$resgistry[$key])) && (isset($_SESSION[$key])) ){
                return self::$resgistry[$key] ;
            }
        }
        return;
    }
    public function Clear($keys=Yalamo::All){
        if($keys===Yalamo::All){
            foreach ($_SESSION as $key=>$val){
                unset ($_SESSION[$key]);
            }
            self::$resgistry=$_SESSION;
        }
        else if (is_array($keys)){
            foreach($keys as $key){
                unset ($_SESSION[$key]);
            }
            self::$resgistry=$_SESSION;
        }
        else {
           unset ($_SESSION[$keys]);
           self::$resgistry=$_SESSION;
        }
        return true;
    }
    public function End($redirect=Yalamo::Void){
        session_unset();
        session_destroy();
        if($this->is_session_cookie_active){
            $this->cookie->Clear($this->cookie_name);
        }
        self::$resgistry=$_SESSION;
        if(!empty($redirect)){
            $uri=Uri::Instance();
            $uri->Redirect($redirect);
        }
    }

    private function create_session_object(){
        $this->object=new Object();
        $this->object->id= Encryption::UnicKey();
        $this->object->si= $this->id;
        $this->object->ip= $_SERVER["REMOTE_ADDR"];
        $this->object->ua= $_SERVER["HTTP_USER_AGENT"];
        $this->object->st= time();
        $cookie_value=$this->object->Serialize();
        $this->cookie->Set($this->cookie_name,$cookie_value);
        $_SESSION[$this->cookie_name]=$cookie_value;
    }
    
}
