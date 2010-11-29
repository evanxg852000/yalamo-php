<?php if ( ! defined('YPATH')) exit('Access Denied !');

$BASECONFIG["MVCPATH"]=YPATH."mvc/";

$BASECONFIG["PROFILING"]=TRUE;

$BASECONFIG["AUTOLOAD"]["MODULES"]=array("Cookie");

$BASECONFIG["AUTOLOAD"]["HELPERS"]=array("Core","Validator","Uri","Html");

$BASECONFIG["AUTOLOAD"]["EXTENSIONS"]=array("Javascript");

$BASECONFIG["ALIASES"]=array(
    "fu"=>"getUri",
    "fc"=>"getController"
);

//TODO use require 


