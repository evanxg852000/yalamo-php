<?php
// uniquement appele en etete de page $NBCONNECTE=controleur(); $SERVER,$USERNAME,$PASSSQL,$DBNAME,$ADMIN ,$PASSADMIN,
function controleur()
{
	Global $NB_CHARGEMENT_PAR_MN,$DELAI,$DB_PREF ;

// variables programmes
	$serveur=$_SERVER["SERVER_ADDR"];
	$ip_visiteur =$_SERVER["REMOTE_ADDR"] ;

// Suppression des enregegistrements périmés (+5mm)
	$heure=  time(); //retourne le temps en secode depui 1-01-1970 0h gmt
	$temps=time()-$DELAI  ;

  $sql= "DELETE  FROM ".$DB_PREF."compteur WHERE heureCon <= $temps AND Etat='N'";   // va supprimer tous les visiteur dont le temps a expire sans toucher ceux qui sont bloques 
  $req=new DatabaseRequest($sql);
  $resultat=$req->Request();	
  unset($req);
// FIN Suppression des enregegistrements périmés (+5mm)


// Ecriture enregistrement nouveau connecté

	$sql= "SELECT* FROM ".$DB_PREF."compteur where ipCon = '$ip_visiteur' ";
  	$req=new DatabaseRequest($sql);
	$res=$req->Select();	
	unset($req);
    $number=count($res);

	if ($number == 0) // cest dire que c'est sa premiere fois
	{
		$ipCon = $ip_visiteur;
		$heureCon = time();
		$dateCon = Date ("Ymd");
		$lheure = Date ("His");
		$sql="INSERT INTO ".$DB_PREF."compteur ( ipCon ,heureCon , dateCon , lheure) VALUES (  '$ipCon','$heureCon' , '$dateCon' , '$lheure')" ;
		$req=new DatabaseRequest($sql);
		$resultat=$req->Request();	
		unset($req);
	}
	else //cest dire quil a recheregr une nouvel page donc on met son ip a jour
	{
		$sql = 'UPDATE '.$DB_PREF.'compteur SET heureCon = "'.time().'" WHERE ipCon = "'.$ip_visiteur.'"';
		$req=new DatabaseRequest($sql);
		$resultat=$req->Request();	
		unset($req);   
		
		//controle du visiteur
		$nb_chargement=$res[0]['Nb_charg'];
		$heure_conection=$res[0]['heureCon'];   //represente la dernier date de rechergement de page		
		if($nb_chargement>=$NB_CHARGEMENT_PAR_MN)
		{
			// on definit l'Etat du visiteur com bloque et on redirige
			$sql = 'UPDATE '.$DB_PREF.'compteur SET Etat="Y" WHERE ipCon = "'.$ip_visiteur.'"';
			$req=new DatabaseRequest($sql);
			$resultat=$req->Request();	
			unset($req);   
			header('Location:forbiden.php'); 	//echo 'bloque';
		}
		else
		{
			$equart=time()-$heure_conection;
			if ($equart >=60) //on verifie si l'equart entre les deux chargement est conforme sinon on augmente le nb_charg
			{
				//on remet le nombre de chargement a 1: car il peut charger deux fois en 1mn et apres 3mn il cherge 3 fois 
				//en rendant compte ke la page ne l'interesse pas alors on aurai garde ses ancien chargement
				$sql = 'UPDATE '.$DB_PREF.'compteur SET Nb_charg=1 WHERE ipCon = "'.$ip_visiteur.'"';
				$req=new DatabaseRequest($sql);
				$resultat=$req->Request();	
				unset($req);  	  
			}
			else
			{
				$nb_chargement=$nb_chargement+1; 
				$sql = 'UPDATE '.$DB_PREF.'compteur SET Nb_charg="'.$nb_chargement.'" WHERE ipCon = "'.$ip_visiteur.'"';
				$req=new DatabaseRequest($sql);
				$resultat=$req->Request();	
				unset($req);  
			}	
		}		
	}

//comptage final ...
  $sql= "SELECT* FROM ".$DB_PREF."compteur where Etat='N'"; //on selectione tous les visiteurs qui ne sont pas bloque
  $req=new DatabaseRequest($sql);
  $resultat=$req->Select();	
  unset($req);
  $cpt=count($resultat);
  return $cpt;
  }

function controleur_admin()
{
	Global $NB_CHARGEMENT_PAR_MN,$DELAI,$DB_PREF ;
	$bloque=false;
// variables programmes
	$serveur=$_SERVER["SERVER_ADDR"];
	$ip_visiteur =$_SERVER["REMOTE_ADDR"] ;

// Suppression des enregegistrements périmés (+5mm)
	$heure=  time(); //retourne le temps en secode depui 1-01-1970 0h gmt
	$temps=time()-$DELAI  ;

  $sql= "DELETE  FROM ".$DB_PREF."compteur WHERE heureCon <= $temps AND Etat='N'";   // va supprimer tous les visiteur dont le temps a expire sans toucher ceux qui sont bloques 
  $req=new DatabaseRequest($sql);
  $resultat=$req->Request();	
  unset($req);
// FIN Suppression des enregegistrements périmés (+5mm)


// Ecriture enregistrement nouveau connecté

	$sql= "SELECT* FROM ".$DB_PREF."compteur where ipCon = '$ip_visiteur' ";
  	$req=new DatabaseRequest($sql);
	$res=$req->Select();	
	unset($req);
    $number=count($res);

	if ($number == 0) // cest dire que c'est sa premiere fois
	{
		$ipCon = $ip_visiteur;
		$heureCon = time();
		$dateCon = Date ("Ymd");
		$lheure = Date ("His");
		$sql="INSERT INTO ".$DB_PREF."compteur ( ipCon ,heureCon , dateCon , lheure) VALUES (  '$ipCon','$heureCon' , '$dateCon' , '$lheure')" ;
		$req=new DatabaseRequest($sql);
		$resultat=$req->Request();	
		unset($req);
	}
	else //cest dire quil a recheregr une nouvel page donc on met son ip a jour
	{
		$sql = 'UPDATE '.$DB_PREF.'compteur SET heureCon = "'.time().'" WHERE ipCon = "'.$ip_visiteur.'"';
		$req=new DatabaseRequest($sql);
		$resultat=$req->Request();	
		unset($req);   
		
		//controle du visiteur
		$nb_chargement=$res[0]['Nb_charg'];
		$heure_conection=$res[0]['heureCon'];   //represente la dernier date de rechergement de page		
		if($nb_chargement>=$NB_CHARGEMENT_PAR_MN)
		{
			// on definit l'Etat du visiteur com bloque et on redirige
			$sql = 'UPDATE '.$DB_PREF.'compteur SET Etat="Y" WHERE ipCon = "'.$ip_visiteur.'"';
			$req=new DatabaseRequest($sql);
			$resultat=$req->Request();	
			unset($req);   
			$bloque=true;
			//header('Location: ../forbiden.php'); 	//echo 'bloque';
		}
		else
		{
			$equart=time()-$heure_conection;
			if ($equart >=60) //on verifie si l'equart entre les deux chargement est conforme sinon on augmente le nb_charg
			{
				//on remet le nombre de chargement a 1: car il peut charger deux fois en 1mn et apres 3mn il cherge 3 fois 
				//en rendant compte ke la page ne l'interesse pas alors on aurai garde ses ancien chargement
				$sql = 'UPDATE '.$DB_PREF.'compteur SET Nb_charg=1 WHERE ipCon = "'.$ip_visiteur.'"';
				$req=new DatabaseRequest($sql);
				$resultat=$req->Request();	
				unset($req);  	  
			}
			else
			{
				$nb_chargement=$nb_chargement+1; 
				$sql = 'UPDATE '.$DB_PREF.'compteur SET Nb_charg="'.$nb_chargement.'" WHERE ipCon = "'.$ip_visiteur.'"';
				$req=new DatabaseRequest($sql);
				$resultat=$req->Request();	
				unset($req);  
			}	
		}		
	}
	return $bloque;
}
?>