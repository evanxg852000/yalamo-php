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
 * @filesource          Validator.php
 */

/*
 * VALIDATOR IMPLEMENTATION
 *
 * The class that implements user input validation using regular expression
 */

//------------------------------------------------------------------------------
/**
 * Validator Class
 *
 * Implements abstract methods from the DBDriver class for Sqlite engine
 */

final class Validator {
    const Name          ="//";
    const Email         ="//";
    const Password      ="//";
    const Urlhttp       ="//";
    const Urlhttps      ="//";
    const Urlftp        ="//";
    const Pcusa         ="//";
    const Pcuk          ="//";
    const Pcfrance      ="//";

    private $regex;

    public function __construct($rule) {
        $this->regex=$rule;
    }
    public function __toString() {return "Object of Type: Validator"; }
    public function Validate($subject){
        if(preg_match($this->regex, $subject)){
            return true;
        }
        return false;
    }


}
