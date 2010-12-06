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
 * CORE HELPER
 *
 * Includes usefull functions for user that want to use the framework in procedural mode
 * about core functionalities. These functions can be called from oo mode
 */

function app_config($key){
    return Environment::Application($key);
}

function load_module($modules){
    $load=new Loader();
    if(!is_array($modules)){
        $load->Module($modules);
        return;
    }
    $load->Modules($modules);
}

function load_helper($helpers){
    $load=new Loader();
    if(!is_array($helpers)){
        $load->Helper($helpers);
        return;
    }
    $load->Helpers($helpers);
}

function load_extension($extensions){
    $load=new Loader();
    if(!is_array($extensions)){
        $load->Extension($extensions);
        return;
    }
    $load->Extensions($extensions);
}

function load_model($model){
    $load=new Loader();
    return $load->Model($model);
}

function load_view($view, $data=null){
     $load=new Loader();
     $load->View($view, $data);
}

function load_controller($controller){
    $load=new Loader();
    $load->Controller($controller);
}


