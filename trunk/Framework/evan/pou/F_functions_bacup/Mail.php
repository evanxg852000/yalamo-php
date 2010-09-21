<?php
function send_mail($email_exp,$email_dest, $name, $objet, $contenu)
{
	$test=false ;
	$headers ="From: \"$Name\" <$email_exp> \n";
	$headers .="Reply-To: $email_exp \n";
	$headers .='Content-Type: text/plain; charset="iso-8859-1"'."\n";
	$headers .='Content-Transfer-Encoding: 8bit';

	if(mail($email_dest, $objet, $contenu, $headers))
	{
	$test=true ;
	}
	return $test ;
}

function wrtie_us($name, $objet, $contenu)
{

}

?>