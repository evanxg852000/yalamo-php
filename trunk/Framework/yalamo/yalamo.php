<?php
/*
 * YALAMO KERNEL
 *
 *
 *
 * @author Evance Soumaoro
 */

/* Set Error Level */
error_reporting(E_ALL);

/* File System */
define("DS",DIRECTORY_SEPARATOR);
define('EXT', '.php');
define("YPATH",pathinfo(__FILE__, PATHINFO_DIRNAME).DS);

/* Include Required Files */
require_once("userconfig".EXT);
require_once("system".DS."core".DS."coreconfig".EXT);

require_once(YCOREFILE);
require_once(YERRORFILE);
require_once(YMODELFILE);
require_once(YURIFILE);
require_once(YMVCFILE);

/* Initialise Inspector */
$Inspector=  Inspector::Instance();


/* Autoload */
Autoload($YAutoLoad);