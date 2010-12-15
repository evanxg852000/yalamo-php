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
 * @filesource          Userconfig.php
 */

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

 


