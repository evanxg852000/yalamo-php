<?php
//permet de cerer une cookie et de recuperer le valeur
//
class Cookie{
private $variable;
private $valeur;
private $expire;

function __construct() 
 {
	$this->expire= 365*24*3600; //un an
 }

function CookieCreer($variable,$valeur)
 {
	$this->variable= $variable;
	$this->valeur=$valeur;
	if (setcookie($this->variable,$this->valeur,time() +$this->expire))
	{
		return true;
	}
	else
	{
		return false;
	}
 }
 
function CookieRecupere($variable)
 {
	if (!isset($_COOKIE[$variable])) 
	{
	  return false;
	}
	else
	{	
		return $_COOKIE[$variable];
	}
 }
 
}
//exemple d'utilisation
/*
$moncookie=new Cookie();
$moncookie->CookieCreer('NOM','Gargamelle');
echo $moncookie->CookieRecupere('NOM');
*/
?>