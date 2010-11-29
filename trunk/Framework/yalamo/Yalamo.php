<?php 
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
 * @filesource          Yalamo.php
 */

/*
 * YALAMO KERNEL
 *
 * Includes all the framework base component and define some constants use
 * throughout the framework
 *
 */

/**
 * Set error level
 */
error_reporting(E_ALL|E_STRICT);

/**
 * Define file system variable as constants
 */
define("DS",DIRECTORY_SEPARATOR);
define('EXT', '.php');
define("YPATH",pathinfo(__FILE__, PATHINFO_DIRNAME).DS);
define('YFSBASE', str_replace(basename(dirname(__FILE__)),"",pathinfo(__FILE__, PATHINFO_DIRNAME)));

/**
 * Include required files
 */
require("configuration".DS."Base".EXT);
require("configuration".DS."Uri".EXT);
require("configuration".DS."Internationalisation".EXT);
require("configuration".DS."Database".EXT);
require("configuration".DS."Application".EXT);
require("system".DS."core".DS."Coreconfig".EXT);

require(YCOREFILE);
require(YCOREFUNCFILE);
require(YERRORFILE);
require(YMODELFILE);
require(YURIFILE);
require(YMVCFILE);

/**
 *  Autoload user prefered files using the autoload array
 */
Yalamo::Autoload($YAUTOLOADCINFIG);

/**
 * Initialise Profiler
 */
if($BASECONFIG["PROFILING"]){
   Profiler::CheckPoint("Init");
}
