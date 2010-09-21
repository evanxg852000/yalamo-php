<?php
include("../config.ini.php") ;
/*
-envoi mail interne
-lire mail interne	
envoi de mailexterne
*/

function sendmail_intern($email_exp, $name, $objet, $contenu)
{


}

function readmail_intern($email_exp, $name, $objet, $contenu)
{


}


function sendmail_text($email_exp, $name, $objet, $contenu)
{
	Global $EMAIL ;
$test=false ;
$headers ="From: \"$Name\" <$email_exp> \n";
$headers .="Reply-To: $email_exp \n";
$headers .='Content-Type: text/plain; charset="iso-8859-1"'."\n";
$headers .='Content-Transfer-Encoding: 8bit';

if(mail($EMAIL, $objet, $contenu, $headers))
{
$test=true ;
}

if ($test==true)
{

echo (" <DIV  class=mes_applic > Message send successfuly. </DIV>");
}
else
{
	echo("<div  class=mes_eror >  Message not sended</div> </DIV>");
}

}

function sendmail_html($email_exp, $name, $objet, $contenu)
{
	Global $EMAIL ;
$test=false ;
$headers ="From: \"$Name\" <$email_exp> \n";
$headers .="Reply-To: $email_exp \n";
$headers .='Content-Type: text/plain; charset="iso-8859-1"'."\n";
$headers .='Content-Transfer-Encoding: 8bit';

if(mail($EMAIL, $objet, $contenu, $headers))
{
$test=true ;
}

if ($test==true)
{

echo (" <DIV  class=mes_applic > Message send successfuly. </DIV>");
}
else
{
	echo("<div  class=mes_eror >  Message not sended</div> </DIV>");
}

}



	
?>
