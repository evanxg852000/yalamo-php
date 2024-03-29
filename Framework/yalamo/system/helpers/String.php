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
 * @filesource          String.php
 */

/*
 * STRING HELPER
 *
 * Includes usefull functions for user that want to use the framework in procedural mode
 * about string. These functions can be called from oo mode
 */

function string_first($string,$lenght){
    return substr($string,0,$lenght);
}

function string_last($string,$lenght){
    return substr($string, -$lenght);
}

function string_empty(){
    return Yalamo::Void;
}