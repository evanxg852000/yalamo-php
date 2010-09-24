<?php if ( ! defined('YPATH')) exit('Access Denied !');
/*
 * URI HELPER
 *
 *
 *
 * @author Evance Soumaoro
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