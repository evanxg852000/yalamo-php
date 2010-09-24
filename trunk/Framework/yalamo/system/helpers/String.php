<?php if ( ! defined('YPATH')) exit('Access Denied !');
/*
 * STRING HELPER
 *
 *
 *
 * @author Evance Soumaoro
 */
function getStringFirst($string,$lenght){
    return substr($string,0,$lenght);
}

function getStringLast($string,$lenght){
    return substr($string, -$lenght);
}

function getStringEmpty(){
    return Yalamo::Void;
}