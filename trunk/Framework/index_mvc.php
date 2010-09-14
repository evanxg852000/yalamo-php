<?php
/*
 * MVC ENTRY POINT
 *
 *
 *
 * @author Evance Soumaoro
 */


/* Include the Framework */
require_once("yalamo/yalamo.php");

// Create an  instance of WebApplication
$WebApplication=new Mvc();
$WebApplication->Build();
unset($w);

?>