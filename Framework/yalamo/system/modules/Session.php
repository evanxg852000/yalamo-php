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

    public function  __construct() {
        session_start();
    }
    public function  __toString() {return "Object of Type: Session"; }

    public function Set($key, $value){
        $_SESSION[$key]=$value;
    }    
    public function Content($key){
        if(array_key_exists($key, $_SESSION)){
            return $_SERVER[$key];
        }
    }
    public function End($redirect=Yalamo::Void){
        session_unset();
        session_destroy();
        if($redirect !==Yalamo::Void){
            header ('Location: '.$redirect);
            exit();
        }
    }

    public static function Clear($key=Yalamo::All){
        if($keys===Yalamo::All){
            foreach ($_SESSION as $key=>$val){
                unset ($_SESSION[$key]);
            }
            return true;
        }
        if(is_array($keys)){
            foreach($keys as $key){
                unset ($_SESSION[$key]);
            }
            return true;
        }
        else {
           unset ($_SESSION[$key]);
           return true;
        }



    }

    
}