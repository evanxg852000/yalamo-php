<?php
	
	
	
//==================ENTETE============================
	/*
ici on inclu toute les functions 
*/
include('config.ini.php');



//==================FONCTIONS============================
function framework($frame)  //$frame= F_image
{
	$test=false ;
	if (substr( $frame, 0, 2)=="F_" )
	{
		include("F_functions/$frame.php");
		$test=true;
	}
	else
	{
	echo "impossible d'inclure la librairie";
	}
return $test ;
}
	
?>
