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
 * @filesource          Html.php
 */

/*
 * HTML HELPER
 *
 * Includes usefull functions for user that want to use the framework in procedural mode
 * about regular expressions. These functions can be called from oo mode
 */
Class Html {
    public static function TagOption($options){
        if(!is_array($options)){
           return;
        }
        foreach ($options as $name=>$value){
            if(is_numeric($name)){continue;}
            $stroption .=" $name=\"$value\" ";
        }
        return $stroption;
    }
}


function anchor($url, $text,$options){
    y('<a href="$url"'.Html::TagOption($options).'>'.$text.'</a>');
}

