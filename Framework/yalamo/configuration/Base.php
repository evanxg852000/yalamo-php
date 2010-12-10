<?php if ( ! defined('YPATH')) exit('Access Denied !');

$BASECONFIG["MVCPATH"]=YPATH."mvc/";

$BASECONFIG["CACHEPATH"]=YFSBASE."cache/";

$BASECONFIG["PROFILING"]=true;

$BASECONFIG["AUTOLOAD"]["MODULES"]=array("Cookie");

$BASECONFIG["AUTOLOAD"]["HELPERS"]=array("Core","Validator","Uri","Html");

$BASECONFIG["AUTOLOAD"]["EXTENSIONS"]=array("Javascript");

$BASECONFIG["ALIASES"]=array(
    "fu"=>"getUri",
    "fc"=>"getController"
);

 


