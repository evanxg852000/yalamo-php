<?php
//fonction de connection de l'administrateur

function conect_admin($login_admin ,$mot_pass)
{
	Global 	$DB_PREF;
	$test=false ;
	$sql='SELECT* FROM '.$DB_PREF.'utilisateur WHERE Login="'.$login_admin.'" AND Mot_pass="'.$mot_pass.'" AND Fonction="Admin" AND Etat="N"';
	$req=new DatabaseRequest($sql);
	$resultat=$req->Select();	
	unset($req);
	$nb_ligne =count($resultat);
	if ($nb_ligne!=0)
	{
		//on enregistre la connection dans utilisateur
		$sql = 'UPDATE utilisateur SET Etat="Y"  WHERE Login="'.$login_admin.'"';
		$req=new DatabaseRequest($sql);
		$resultat=$req->Request();	
		unset($req);
		if($resultat)
		{
			$test=true ;
		}
	}
	return $test;
}

//fonction de deconnection de l'administrateur
function deconect_admin($login_conet ,$pass_conet)
{
	Global 	$DB_PREF;
	$sql = 'UPDATE '.$DB_PREF.'utilisateur SET Etat="N"  WHERE Mot_pass="'.$pass_conet.'" AND Login="'.$login_conet.'"';
	$req=new DatabaseRequest($sql);
	$resultat=$req->Request();	
	unset($req);
	if ($resultat ) 
	{
		return true;
	}
	else 
	{  
		return  false;
	}
}


function Test_superAdmin($login_conet ,$pass_conet)
{
	Global 	$DB_PREF;
	$sql = 'SELECT* FROM '.$DB_PREF.'utilisateur WHERE Mot_pass="'.$pass_conet.'" AND Login="'.$login_conet.'" AND Niv_acces="Super_admin"';
	$req=new DatabaseRequest($sql);
	$resultat=$req->Select();	
	unset($req);
	$nb_ligne =count($resultat);
	if ($nb_ligne!=0)
	{
		return true ;
	}
	else
	{
		return false;
	}
}

function get_num_connecte($login_conet ,$pass_conet)
{
	Global 	$DB_PREF;
	$contenu="";
	$sql = 'SELECT* FROM '.$DB_PREF.'utilisateur WHERE Mot_pass="'.$pass_conet.'" AND Login="'.$login_conet.'"';
	$req=new DatabaseRequest($sql);
	$resultat=$req->Select();	
	unset($req); 
	$nb_ligne =count($resultat);
	if ($nb_ligne!=0)
	{
		$contenu=$resultat[0]['Num'].'|'.$resultat[0]['Niv_acces'].'|';
	}	
	return $contenu;
}

function conect_user($login_user ,$motpass_user)
{
	Global 	$DB_PREF;
	$sql = 'SELECT* FROM '.$DB_PREF.'utilisateur WHERE Mot_pass="'.$motpass_user.'" AND Login="'.$login_user.'"';
	$req=new DatabaseRequest($sql);
	$resultat=$req->Select();	
	unset($req);
	$nb_ligne =count($resultat);
	if ($nb_ligne!=0)
	{
		return true ;
	}
	else
	{
		return false;
	}
}

?>