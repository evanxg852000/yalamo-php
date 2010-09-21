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
 * @filesource          Userconfig.php
 */


/*
 * ENVIRONMENT IMPLEMENTATION
 *
 * This file contains definition of environement variable and provide
 * the application variable
 */

//------------------------------------------------------------------------------
/**
 * Evironment Class
 *
 * The class comprise of pure static methods to get variable from different PHP
 * Global Array.
 */
class Environment{

     /**
     * Gets a value from the $_ENV Global array based on the Key specified, return false if no match
     * @param <string> $key
     * @return <implicite> or false
     */
    public static function Env($key){
       if(!array_key_exists($key,$_ENV)) {
           return false;
        }
         return $_ENV[$key];
    }

     /**
     * Gets a value from the $_REQUEST Global array based on the Key specified, return false if no match
     * @param <string> $key
     * @return <implicite> or false
     */
    public static function Request($key){
       if(!array_key_exists($key,$_REQUEST)) {
           return false;
        }
         return $_REQUEST[$key];
    }

     /**
     * Gets a value from the $_SERVER Global array based on the Key specified, return false if no match
     * @param <string> $key
     * @return <implicite> or false
     */
    public static function Server($key){
        if(!array_key_exists($key,$_SERVER)) {
           return false;
        }
         return $_SERVER[$key];
    }

    /**
     * Gets a value from the $_SESSION Global array based on the Key specified, return false if no match
     * @param <string> $key
     * @return <implicite> or false
     */
    public static function Session($key){
       if(!array_key_exists($key,$_SESSION)) {
           return false;
        }
         return $_SESSION[$key];
    }

     /**
     * Gets a value from the $_COOKIE Global array based on the Key specified, return false if no match
     * @param <string> $key
     * @return <implicite> or false
     */
    public static function Cookie($key){
        if(!array_key_exists($key,$_COOKIE)) {
           return false;
        }
         return $_COOKIE[$key];
    }

    /**
     * Gets a value from the $_GET Global array based on the Key specified, return false if no match
     * @param <string> $key
     * @return <implicite> or false
     */
    public static function Get($key){
        if(!array_key_exists($key,$_GET)) {
           return false;
        }
         return $_GET[$key];
    }

    /**
     * Gets a value from the $_POST Global array based on the Key specified, return false if no match
     * @param <string> $key
     * @return <implicite> or false
     */
    public static function Post($key){
        if(!array_key_exists($key,$_POST)) {
           return false;
        }
         return $_POST[$key];
    }

    /**
     * Gets a value from the $_FILE Global array based on the Key specified, return false if no match
     * @param <string> $key
     * @return <implicite> or false
     */
    public static function File($key){
        if(!array_key_exists($key,$_FILES)) {
           return false;
        }
         return $_FILES[$key];
    }

    /**
     * Gets a value from the $AppConfig Global array based on the Key specified, return false if no match
     * @global <array> $AppConfig
     * @param <string> $key
     * @return <string> Or false
     */
    public static function Application($key){
        global $AppConfig;
        if(!array_key_exists($key,$AppVaribles)) {
           return false;
        }
         return $AppVaribles[$key];
    }

}