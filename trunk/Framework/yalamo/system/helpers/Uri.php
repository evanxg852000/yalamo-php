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
 * @filesource          Uri.php
 */

/*
 * URI HELPER
 *
  * Includes usefull functions for user that want to use the framework in procedural mode
 * about uri. These functions can be called from oo mode
 */

function getUri(){
    $uri=new Uri() ;
    return $uri->Full();
}

function getUriBase(){
    $uri=new Uri() ;
    return $uri->Base();
}

function getUriSegement($num){
     $uri=new Uri() ;
     return $uri->Segment($num);
}

function getUriController(){
    $uri=new Uri() ;
    return $uri->Controller();
}

function getUriMethod(){
    $uri=new Uri() ;
     return $uri->Method();
}

function getUriQueryString(){
    $uri=new Uri() ;
    return $uri->QueryString();
}

function Redirect($url){
    $uri=new Uri();
    $uri->Redirect($url);
}