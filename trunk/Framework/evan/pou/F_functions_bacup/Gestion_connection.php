<?php
//fonction de connection de l'administrateur

function conect_admin($login_admin ,$mot_pass)
{
Global $SERVER,$USERNAME,$PASSSQL,$DBNAME,$ADMIN ,$PASSADMIN ;
$test=false ;
$req='SELECT* FROM utilisateur WHERE Login="'.$login_admin.'" AND Mot_pass="'.$mot_pass.'" AND Fonction="Admin" AND Etat="N"';

mysql_connect("$SERVER" ,"$USERNAME" , "$PASSSQL") or die('connexion impossible') ;
mysql_select_db("$DBNAME") or die('Base inexistante');

$query = mysql_query($req) or die( 'Erreur d\'execution de la requette' );

 $nb_ligne = mysql_num_rows($query);
 
if ($nb_ligne!=0)
{
//on enregistre la connection dans utilisateur
$sql = 'UPDATE utilisateur SET Etat="Y"  WHERE Login="'.$login_admin.'"';
mysql_query($sql)or die('erreur de requete');
$test=true ;
}
mysql_close() ;	
return $test;
}

//fonction de deconnection de l'administrateur
function deconect_admin($login_conet ,$pass_conet)
{
	Global $SERVER,$USERNAME,$PASSSQL,$DBNAME,$ADMIN ,$PASSADMIN ;
$test=false;
$sql = 'UPDATE utilisateur SET Etat="N"  WHERE Mot_pass="'.$pass_conet.'" AND Login="'.$login_conet.'"';

mysql_connect("$SERVER" ,"$USERNAME" , "$PASSSQL") or die('connexion impossible') ;
mysql_select_db("$DBNAME") or die('Base inexistante');

if ( mysql_query($sql) ) 
 {
 	  $test=true;
      
 }
 else 
 {  
	   $test=false;
 }
 
 return $test;
mysql_close() ;
}


function Test_superAdmin($login_conet ,$pass_conet)
{
Global $SERVER,$USERNAME,$PASSSQL,$DBNAME,$ADMIN ,$PASSADMIN ;
$test=false;
$sql = 'SELECT* FROM utilisateur WHERE Mot_pass="'.$pass_conet.'" AND Login="'.$login_conet.'" AND Niv_acces="Super_admin"';
mysql_connect( $SERVER ,$USERNAME , $PASSSQL) or die('connexion impossible') ;
mysql_select_db("$DBNAME") or die('Base inexistante');
 $query=mysql_query($sql)or die('erreur de requete');
 $nb_ligne = mysql_num_rows($query);
 
if ($nb_ligne!=0)
{
$test=true ;
}
mysql_close() ;	
return $test;
}

function get_num_connecte($login_conet ,$pass_conet)
{
Global $SERVER,$USERNAME,$PASSSQL,$DBNAME,$ADMIN ,$PASSADMIN ;
$result="";
$sql = 'SELECT* FROM utilisateur WHERE Mot_pass="'.$pass_conet.'" AND Login="'.$login_conet.'"';
mysql_connect( $SERVER ,$USERNAME , $PASSSQL) or die('connexion impossible') ;
mysql_select_db("$DBNAME") or die('Base inexistante');
 $query=mysql_query($sql)or die('erreur de requete');
 $nb_ligne = mysql_num_rows($query);
 
if ($nb_ligne!=0)
{
	while ( $list = mysql_fetch_array( $query) )
	{
	   $result=$list['Num'].'|'.$list['Niv_acces'].'|';
	}
}
mysql_close() ;	
return $result;
}

?>