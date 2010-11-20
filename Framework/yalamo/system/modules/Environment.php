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
class Environment extends Object{

     /**
     * Gets a value from the $_ENV global array based on the key specified
      *
     * @param string $key The key in the $_ENV global array
     * @return mixed      It returns false if there is no match
     */
    public static function Env($key,$rule=null){
       if(!array_key_exists($key,$_ENV)) {
           self::scollect(Error::YE100);
           return false;
        }
        if((is_null($rule))  || ( self::validate($_REQUEST[$key], $rule) )) {
             return $_ENV[$key];
        }
        return false;
    }

     /**
     * Gets a value from the $_REQUEST global array based on the key specified
      *
     * @param  string $key  The key in the $_REQUEST global array
     * @return mixed        It returns false if there is no match
     */
    public static function Request($key,$rule=null){
       if(!array_key_exists($key,$_REQUEST)) {
           self::scollect(Error::YE100);
           return false;
        }
        if((is_null($rule))  || ( self::validate($_REQUEST[$key], $rule) )) {
             return $_REQUEST[$key];
        }
        return false;
    }

     /**
     * Gets a value from the $_SERVER global array based on the key specified
     * @param   string $key     The key in the $_SERVER global array
     * @return  mixed           It returns false if there is no match
     */
    public static function Server($key,$rule=null){
        if(!array_key_exists($key,$_SERVER)) {
           self::scollect(Error::YE100);
           return false;
        }
        if((is_null($rule))  || ( self::validate($_SERVER[$key], $rule) )) {
             return $_SERVER[$key];
        }
        return false;
    }

    /**
     * Gets a value from the $_SESSION global array based on the Key specified
     * @param   string $key     The key in the $_SESSION global array
     * @return  mixed           It returns false if there is no match
     */
    public static function Session($key,$rule=null){
       if(!array_key_exists($key,$_SESSION)) {
           self::scollect(Error::YE100);
           return false;
        }
        if((is_null($rule))  || ( self::validate($_SESSION[$key], $rule) )) {
             return $_SESSION[$key];
        }
        return false;
    }

     /**
     * Gets a value from the $_COOKIE global array based on the Key specified
     * @param   string $key     The key in the $_COOKIE global array
     * @return  mixed           It returns false if there is no match
     */
    public static function Cookie($key,$rule=null){
        if(!array_key_exists($key,$_COOKIE)) {
           self::scollect(Error::YE100);
           return false;
        }
        if((is_null($rule))  || ( self::validate($_COOKIE[$key], $rule) )) {
             return $_COOKIE[$key];
        }
        return false;
    }

    /**
     * Gets a value from the $_GET global array based on the Key specified
     * @param   string $key     The key in the $_GET global array
     * @return  mixed           It returns false if there is no match
     */
    public static function Get($key,$rule=null){
        if(!array_key_exists($key,$_GET)) {
           self::scollect(Error::YE100);
           return false;
        }
        if((is_null($rule))  || ( self::validate($_GET[$key], $rule) )) {
             return $_GET[$key];
        }
        return false;
    }

    /**
     * Gets a value from the $_POST global array based on the Key specified
     * @param   string $key     The key in the $_POST global array
     * @return  mixed           It returns false if there is no match
     */
    public static function Post($key,$rule=null){
        if(!array_key_exists($key,$_POST)) {
            self::scollect(Error::YE100);
            return false;
        }
        if((is_null($rule))  || ( self::validate($_POST[$key], $rule) )) {
             return $_POST[$key];
        }
        return false;
    }

    /**
     * Gets a value from the $_FILES global array based on the Key specified
     * @param   string $key     The key in the $_FILES global array
     * @return  mixed           It returns false if there is no match
     */
    public static function File($key){
        if(!array_key_exists($key,$_FILES)) {
           self::scollect(Error::YE100);
           return false;
        }
         return $_FILES[$key];
    }

    /**
     * Gets a value from the $AppConfig global array based on the key specified
     * @global array $AppConfig
     * @param  string $key The key in the $AppConfig global array
     * @return string      It returns false if there is no match
     */
    public static function Application($key){
        global $AppConfig;
        if(!array_key_exists($key,$AppConfig)) {
           self::scollect(Error::YE100);
           return false;
        }
         return $AppConfig[$key];
    }

    /**
     * Validate a data
     *
     * @param string $subject
     * @param regex $rule
     * @return bool
     */
    private static function validate($subject,$rule){
       $v=new Validator($rule);
       return $v->Validate($subject);
    }
    private static function scollect($errortype){
        $instance=new Environment();
        $instance->Collect($errortype);
    }
}