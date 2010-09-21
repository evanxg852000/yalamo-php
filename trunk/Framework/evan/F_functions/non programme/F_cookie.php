<?php


	/*
creer un coockie et recuper le coockie
*/
//execute une requette speciale com creation de table ou modification de structure



function exereq( $reqsql )
{	
	Global $SERVER,$USERNAME,$PASSSQL,$DBNAME,$ADMIN ,$PASSADMIN ;

/* opening database */
$test=false ;
mysql_connect("$SERVER" ,"$USERNAME" , "$PASSSQL") or die('connexion impossible') ;
mysql_select_db("$DBNAME") or die('Base inexistante');

 if ( mysql_query($reqsql) ) 
 {
 	  $test=true;
      
 }
 else 
 {   
 }
 
mysql_close() ;
return $test ;
}

//fonction de connection de l'administrateur

function conect_admin($nom_admin ,$mot_pass)
{
Global $SERVER,$USERNAME,$PASSSQL,$DBNAME,$ADMIN ,$PASSADMIN ;
$test=false ;
if (($nom_admin==$ADMIN) and ($mot_pass==$PASSADMIN))
{
$test=true ;
}
return $test;
}



//==================================================================
function store( $reqsql )
{	
	Global $SERVER,$USERNAME,$PASSSQL,$DBNAME,$ADMIN ,$PASSADMIN ;
/* opening database */
$test=false ;
mysql_connect( $SERVER ,$USERNAME , $PASSSQL) or die('connexion impossible') ;
mysql_select_db("$DBNAME") or die('Base inexistante');

 if ( mysql_query($reqsql) ) 
 {
 	  echo("<div class=mes_info align=left> Enregistrement effectué  </div>");
      $test=true ;
      
 }
 else 
 {
   
   echo("<div class=mes_eror align=left>Enregistrement non effectué </div>");
   
 }
  return $test;
mysql_close() ;
}
//$query = mysql_query($reqsql) or die( 'Erreur' );
//===========================================================================================================
function delete_rec ( $reqsql)
{
	Global $SERVER,$USERNAME,$PASSSQL,$DBNAME,$ADMIN ,$PASSADMIN ;
/* opening database */

mysql_connect( $SERVER ,$USERNAME , $PASSSQL) or die('connexion impossible') ;
mysql_select_db("$DBNAME") or die('Base inexistante');

if ( mysql_query($reqsql) ) 
 {
 	  echo('suppression effectue');
      
 }
 else 
 {
   
   echo('suppression non effectue');
   
 }

mysql_close() ;
}
//===========================================================================================================
function update_rec ( $reqsql)
{
	Global $SERVER,$USERNAME,$PASSSQL,$DBNAME,$ADMIN ,$PASSADMIN ;
/* opening database */

mysql_connect( $SERVER ,$USERNAME , $PASSSQL) or die('connexion impossible') ;
mysql_select_db("$DBNAME") or die('Base inexistante');

$query = mysql_query($reqsql) or die( 'Erreur' );

mysql_close() ;
}
//===========================================================================================================

function select_rec ( $reqsql )
{
	Global $SERVER,$USERNAME,$PASSSQL,$DBNAME,$ADMIN ,$PASSADMIN ;
/* opening database */

mysql_connect( $SERVER ,$USERNAME , $PASSSQL) or die('connexion impossible') ;
mysql_select_db("$DBNAME") or die('Base inexistante');


$query = mysql_query($reqsql) or die( 'Erreur d\'execution de la requette' );
 $nb_ligne = mysql_num_rows($query);
 return $query ;
 
 
mysql_close() ;
}

function numdoss($nom ,$prenom)
{
$result1 = substr($prenom, 2,3); // retourne "bcdef"
$result2 = substr($nom, 0, 2); // retourne 3 premieres lettre du nom
$result3 = date("d").date("m");
$result4 =date("H").date("i");
$result=strtoupper("DO".$result1.$result4.$result3.$result2) ;
return $result ;
}

function info()
{
		$critere=rand(1, 5); 
		$req=" Select* from info where Num_in=".$critere ;
		$result=select_rec ( $req ) ;
		$nb_ligne = mysql_num_rows($result);
		while ( $list = mysql_fetch_array( $result) ) 
		{
		echo $list['Contenu_in'];
		}									
}	
	
?>
