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

function uri_get(){
    return Uri::Instance()->Full();
}

function uri_get_base(){
    return Uri::Instance()->Base();
}

function uri_get_segement($num){
     return Uri::Instance()->Segment($num);
}

function uri_get_controller(){
    return Uri::Instance()->Controller();
}

function uri_get_method(){
    return Uri::Instance()->Method();
}

function uri_get_query(){
    return Uri::Instance()->QueryString();
}

function uri_redirect($url){
    $uri=new Uri();
    Uri::Instance()->Redirect($url);
}

function uri_create($page,$prefix=null){
   return Uri::Instance()->Create($page,$prefix);
}
