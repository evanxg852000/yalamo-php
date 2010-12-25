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
 * @filesource          index_mvc.php
 */

/*
 * MVC ENTRY POINT
 *
 */

/* Include the Framework */
require_once("yalamo".DIRECTORY_SEPARATOR."Yalamo.php");

// Create an  instance of WebApplication
$WebApplication=new Mvc();
$WebApplication->Build();
unset($w);
?>