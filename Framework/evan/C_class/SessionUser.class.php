<?php

class SessionUser{
private $login;
private $pass;
private $num; //numero d'enregistrement dans la base identifiant
private $fonction;
private $niveau_acces ; //niveau acces
private $is_user=false; //permet de savoir s'il est b1 un utilsateur
private $is_connected=false; //valeur de test s'il est deja connecte
private $is_super_user=false; //permet de savoir s'il est super admin 

function __tostring() 
{
    return "Cette classe permet de définir et manipuler une identication(un utilisteur et renvoie son type).<br/>";
}

function __construct($login, $pass) 
{
    $this->login = $login;
    $this->pass = $pass;
    $this->is_super_user =false;
	$sql = 'SELECT* FROM utilisateur WHERE Mot_pass="'.$this->pass.'" AND Login="'.$this->login.'"'; //on selectionne l'utilisateur
	$dbreq=new DatabaseRequest();
	$resultat=$dbreq->Select($sql);
	if($resultat!=false)  //
	 {
		 $this->is_user=true; //il est identifie
		 $this->num=$resultat[0]['Num']; //on recupere son numero par le tableau retourne
		 $this->fonction=$resultat[0]['Fonction']; //on affec la fonction
		 $this->niveau_acces =$resultat[0]['Niv_acces']; //on affecte le niveau d'acces
		 if($this->niveau_acces=='Super_admin') //on test si il est super admin
		 {
			 $this->is_super_user=true;
		 }
		 if ($resultat[0]['Etat']=='Y')
		 {
			$this->is_connected=true;
		 }
	 }
	 unset($dbreq); //destruction de l'objet requete
}

function ConectUser()
{
	if($this->is_user==true)
	 {
		return true;
	 }
	 else
	 {
		return false;
	 }
}

function DeconectUser()
{

}

function ConectAdmin()
{
	if($this->is_connected==false) // on test s'il n'est pas connecte deja 
	{
		if(($this->is_user==true)&&($this->fonction=='admin'))
		 {
			 //on met a jour la table de connection
				$sql = 'UPDATE utilisateur SET Etat="Y"  WHERE Mot_pass="'.$this->pass.'" AND Login="'.$this->login.'"';
				$dbreq=new DatabaseRequest();
				if($dbreq->Request($sql))
				{ 
					unset($dbreq); //destruction de l'objet
					return true;
				}
				else
				{
					unset($dbreq); //destruction de l'objet
					return false;
				}
		 }
		 else
		 {
			return false;
		 }
	}
	else
	{
	 return false;
	}
}

function DeconectAdmin()
{
	if(($this->is_user==true)&&($this->fonction=='admin')) //on test si c un user et un admin
	 {
		 //on met a jour la table de connection
			$sql = 'UPDATE utilisateur SET Etat="N"  WHERE Mot_pass="'.$this->pass.'" AND Login="'.$this->login.'"';
			$dbreq=new DatabaseRequest();
			if($dbreq->Request($sql))
			{ 
				unset($dbreq); //destruction de l'objet
				return true;
			}
			else
			{
				unset($dbreq); //destruction de l'objet
				return false;
			}
	 }
	 else
	 {
		return false;
	 }
}

function IssuperUser()
{

	return $this->is_super_user;

}

function GetnumUser()
{
	return $this->num;
}
	
}
/*
//exemeple d'utilistation
$massession =new SessionUser('evan','evan');
echo $massession->IssuperUser();
echo $massession->GetnumUser().'>';
echo $massession->ConectAdmin();
echo '|';
echo $massession->DeconectAdmin();
*/



?>