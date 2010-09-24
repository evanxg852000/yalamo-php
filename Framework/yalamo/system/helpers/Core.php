<?php

function  getAppConfig($key){
    return Yalamo::AppConfig($key);
}

function loadModule($modules){
    $load=new Loader();
    if(is_array($modules)){
        $load->Module($modules);
        return;
    }
    $load->Modules($modules);
}

function loadHelper($helpers){
    $load=new Loader();
    if(is_array($helpers)){
        $load->Helper($helpers);
        return;
    }
    $load->Helpers($helpers);
}

function loadExtension($extensions){
    $load=new Loader();
    if(is_array($extensions)){
        $load->Extension($extensions);
        return;
    }
    $load->Extensions($extensions);
}

function loadModel($model){
    $load=new Loader();
    return $load->Model($model);
}

function loadView($view, $data=null){
     $load=new Loader();
     $load->View($view, $data);
}

function loadController($controller){
    $load=new Loader();
    $load->Controller($controller);
}

