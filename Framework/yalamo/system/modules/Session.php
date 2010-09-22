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
 * @version		Version 1.0
 * @filesource          Session.php
 */

/*
 * SESSION IMPLEMENTATION
 *
 * Contains the directory manipulation/info functionalities
 */

//------------------------------------------------------------------------------
/**
 * Session Class
 *
 * The class that contains the framework enumeration and static methods
 * to do useful thing.
 */
class Session {
    private static  $resgistry;
    private $id;


    public function  __construct() {
        session_start();
        $this->id=$_COOKIE["PHPSESSID"];
        self::$resgistry=$_SESSION;
    }
    public function  __toString() {return "Object of Type: Session"; }

    private function  __set($name, $value) {
        $_SESSION[$name]=$value;
        self::$resgistry=$_SESSION;
    }
    private function  __get($name) {
        if((array_key_exists($name, self::$resgistry)) && (array_key_exists($name, $_SESSION))){
            return self::$resgistry[$name];
        }
    }

    public function Id(){
        return $this->id;
    }
    public function Registry(){
        return self::$resgistry;
    }
    public function Set($key, $value){
        $this->$key=$value;
    }    
    public function Get($key){
        return $this->$key;
    }
    public function Clear($keys=Yalamo::All){
        if($keys===Yalamo::All){
            foreach ($_SESSION as $key=>$val){
                unset ($_SESSION[$key]);
            }
            self::$resgistry=$_SESSION;
            return true;
        }
        if(is_array($keys)){
            foreach($keys as $key){
                unset ($_SESSION[$key]);
            }
            self::$resgistry=$_SESSION;
            return true;
        }
        else {
           unset ($_SESSION[$keys]);
           self::$resgistry=$_SESSION;
           return true;
        }


    }
    public function End($redirect=Yalamo::Void){
        session_unset();
        session_destroy();
        self::$resgistry=$_SESSION;
        if($redirect !==Yalamo::Void){
            header ('Location: '.$redirect);
            exit();
        }
    }
     
}