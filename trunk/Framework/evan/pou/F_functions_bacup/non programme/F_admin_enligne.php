<?php
include("../config.ini.php") ;



//==================================================================
function cherch_admin( )
{	
	Global $SERVER,$USERNAME,$PASSSQL,$DBNAME,$ADMIN ,$PASSADMIN ;
/* opening database */
$test=false ;
mysql_connect( $SERVER ,$USERNAME , $PASSSQL) or die('connexion impossible') ;
mysql_select_db("$DBNAME") or die('Base inexistante');
$reqsql="select from utilisateur where Login='Admin' AND Etat='1' "; 
$rest=mysql_num_rows(mysql_query($reqsql)) 
 if (  $rest==1) 
 {
      $test=true ;
 }
  return $test;
mysql_close() ;
}


	
?>
