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
 * @version		Version 1.0
 * @filesource          index_mvc.php
 */

/*
 * MVC ENTRY POINT
 *
 * To rename index.php if you choose to run in MVC-MODE
 *
 */

/* Include the Framework */
require_once("yalamo/yalamo.php");

// Create an  instance of WebApplication
$WebApplication=new Mvc();
$WebApplication->Build();
unset($w);


/*$BEGING_TIME = microtime(true);
$ENDING_TIME = microtime(true);
echo 'Benchmark time : '.round($ENDING_TIME -$BEGING_TIME , 4);
*/


?>