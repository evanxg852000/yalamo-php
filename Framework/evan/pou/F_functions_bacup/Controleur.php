<?php
// uniquement appele en etete de page $NBCONNECTE=controleur();
function controleur()
{
	Global $SERVER,$USERNAME,$PASSSQL,$DBNAME,$ADMIN ,$PASSADMIN,$NB_CHARGEMENT_PAR_MN,$DELAI ;

// variables programmes
$serveur=$_SERVER["SERVER_ADDR"];
$ip_visiteur =$_SERVER["REMOTE_ADDR"] ;

// Connection à la base de donnée 
mysql_connect("$SERVER" ,"$USERNAME" , "$PASSSQL") or die('connexion impossible') ;
mysql_select_db("$DBNAME") or die('Base inexistante');


// Suppression des enregegistrements périmés (+5mm)
$heure=  time(); //retourne le temps en secode depui 1-01-1970 0h gmt


$temps=time()-$DELAI  ;
   //
  $query = "DELETE  FROM compteur WHERE heureCon <= $temps AND Etat='N'";   // va supprimer tous les visiteur dont le temps a expire sans toucher ceux qui sont bloques 
  $result =  mysql_query($query)or die('erreur de requete');

// FIN Suppression des enregegistrements périmés (+5mm)


// Ecriture enregistrement nouveau connecté

 $req = "SELECT* FROM compteur where ipCon = '$ip_visiteur' ";
 $res =  mysql_query($req )or die('erreur de requete');
 $number=mysql_num_rows($res);

if ($number == 0) // cest dire que c'est sa premiere fois
{
$ipCon = $ip_visiteur;
$heureCon = time();
$dateCon = Date ("Ymd");
$lheure = Date ("His");
$req1="INSERT INTO compteur ( ipCon ,heureCon , dateCon , lheure) VALUES (  '$ipCon','$heureCon' , '$dateCon' , '$lheure')" ;
mysql_query($req1) or die('erreur de requete');
}
else //cest dire quil a recheregr une nouvel page donc on met son ip a jour
{
	$sql = 'UPDATE compteur SET heureCon = "'.time().'" WHERE ipCon = "'.$ip_visiteur.'"';
    mysql_query($sql)or die('erreur de requete');
	
//controle du visiteur
	while ( $list = mysql_fetch_array( $res) ) 
					{
					$nb_chargement=$list['Nb_charg'];
					$heure_conection=$list['heureCon'];   //represente la dernier date de rechergement de page
					}		
if($nb_chargement>=$NB_CHARGEMENT_PAR_MN)
{
	// on definit l'Etat du visiteur com bloque et on redirige
	    $sql = 'UPDATE compteur SET Etat="Y" WHERE ipCon = "'.$ip_visiteur.'"';
		mysql_query($sql)or die('erreur de requete');
        header('Location:forbiden.php');
		//echo 'bloque';
}
else
{
	$equart=time()-$heure_conection;
	if ($equart >=60) //on verifie si l'equart entre les deux chargement est conforme sinon on augmente le nb_charg
	{
		//on remet le nombre de chargement a 1: car il peut charger deux fois en 1mn et apres 3mn il cherge 3 fois 
		//en rendant compte ke la page ne l'interesse pas alors on aurai garde ses ancien chargement
		$sql = 'UPDATE compteur SET Nb_charg=1 WHERE ipCon = "'.$ip_visiteur.'"';
		mysql_query($sql)or die('erreur de requete');
	  
	}
	else
	{
		$nb_chargement=$nb_chargement+1; 
		$sql = 'UPDATE compteur SET Nb_charg="'.$nb_chargement.'" WHERE ipCon = "'.$ip_visiteur.'"';
		mysql_query($sql)or die('erreur de requete');
	}	
}		
}

//comptage final ...
  $queryd = "SELECT* FROM compteur where Etat='N'"; //on selectione tous les visiteurs qui ne sont pas bloque
  $resultd =  mysql_query($queryd) or die('erreur de requete');
  $cpt = mysql_num_rows($resultd);
mysql_close() ;
return $cpt;
}

//================================================================

function controleur_admin()
{
	Global $SERVER,$USERNAME,$PASSSQL,$DBNAME,$ADMIN ,$PASSADMIN,$NB_CHARGEMENT_PAR_MN,$DELAI ;

// variables programmes
$serveur=$_SERVER["SERVER_ADDR"];
$ip_visiteur =$_SERVER["REMOTE_ADDR"] ;

// Connection à la base de donnée 
mysql_connect("$SERVER" ,"$USERNAME" , "$PASSSQL") or die('connexion impossible') ;
mysql_select_db("$DBNAME") or die('Base inexistante');


// Suppression des enregegistrements périmés (+5mm)
$heure=  time(); //retourne le temps en secode depui 1-01-1970 0h gmt


$temps=time()-$DELAI  ;
   //
  $query = "DELETE  FROM compteur WHERE heureCon <= $temps AND Etat='N'";   // va supprimer tous les visiteur dont le temps a expire sans toucher ceux qui sont bloques 
  $result =  mysql_query($query)or die('erreur de requete');

// FIN Suppression des enregegistrements périmés (+5mm)


// Ecriture enregistrement nouveau connecté

 $req = "SELECT* FROM compteur where ipCon = '$ip_visiteur' ";
 $res =  mysql_query($req )or die('erreur de requete');
 $number=mysql_num_rows($res);

if ($number == 0) // cest dire que c'est sa premiere fois
{
$ipCon = $ip_visiteur;
$heureCon = time();
$dateCon = Date ("Ymd");
$lheure = Date ("His");
$req1="INSERT INTO compteur ( ipCon ,heureCon , dateCon , lheure) VALUES (  '$ipCon','$heureCon' , '$dateCon' , '$lheure')" ;
mysql_query($req1) or die('erreur de requete');
}
else //cest dire quil a recheregr une nouvel page donc on met son ip a jour
{
	$sql = 'UPDATE compteur SET heureCon = "'.time().'" WHERE ipCon = "'.$ip_visiteur.'"';
    mysql_query($sql)or die('erreur de requete');
	
//controle du visiteur
	while ( $list = mysql_fetch_array( $res) ) 
					{
					$nb_chargement=$list['Nb_charg'];
					$heure_conection=$list['heureCon'];   //represente la dernier date de rechergement de page
					}		
if($nb_chargement>=$NB_CHARGEMENT_PAR_MN)
{
	// on definit l'Etat du visiteur com bloque et on redirige
	    $sql = 'UPDATE compteur SET Etat="Y" WHERE ipCon = "'.$ip_visiteur.'"';
		mysql_query($sql)or die('erreur de requete');
        header('Location: ../forbiden.php');
		//echo 'bloque';
}
else
{
	$equart=time()-$heure_conection;
	if ($equart >=60) //on verifie si l'equart entre les deux chargement est conforme sinon on augmente le nb_charg
	{
		//on remet le nombre de chargement a 1: car il peut charger deux fois en 1mn et apres 3mn il charge 3 fois 
		//en rendant compte ke la page ne l'interesse pas alors on aurai garde ses ancien chargement
		$sql = 'UPDATE compteur SET Nb_charg=1 WHERE ipCon = "'.$ip_visiteur.'"';
		mysql_query($sql)or die('erreur de requete');
	  
	}
	else
	{
		$nb_chargement=$nb_chargement+1; 
		$sql = 'UPDATE compteur SET Nb_charg="'.$nb_chargement.'" WHERE ipCon = "'.$ip_visiteur.'"';
		mysql_query($sql)or die('erreur de requete');
	}	
}		
}
mysql_close() ;
}
?>