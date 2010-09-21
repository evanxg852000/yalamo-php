<?php

	/*
1 functon store
2 function delete_rec
3 function update_rec
4function select_rec 
5 function number_connected
6function  make reqsql
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
 	  echo '<div class="mes_applic">suppression effectue</DIV>';
      
 }
 else 
 {
    echo '<div class="mes_eror">suppression non effectue</DIV>';   
  
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



function find($critere)
{
	            Global $SERVER,$USERNAME,$PASSSQL,$DBNAME,$ADMIN ,$PASSADMIN ;
				if ($critere=="")
				{
					echo "<div class=mes_eror > No Keyword for the research  </div> </div><br>";
				}
				else
				{
				echo "<div class=mes_info align=left>Keywords of your research : ".$critere."</DIV></div>" ;
			    $req=" Select* from cherche where Mot_cle like '%".$critere."%'"; 	
				/* opening database */
				mysql_connect("$SERVER" ,"$USERNAME" , "$PASSSQL") or die('connexion impossible') ;
				mysql_select_db("$DBNAME") or die('Base inexistante');
                $result = mysql_query($req) or die( 'Erreur d\'execution de la requette' );  
				$nb_ligne = mysql_num_rows($result);
				$i=1 ;
				 if ( $nb_ligne<=0 ) 
				 {
					  echo "<div class=mes_eror align=left> No related link found for this (these) word(s), we recommend you a <a href=http://google.com>Google </a>research </div></div><br> ";
				 }
				 else 
				 {
					 echo"<br>" ;
				   while ( $list = mysql_fetch_array( $result) ) 
				   {
					   echo '<table class="blog" cellpadding="0" cellspacing="0">';
							 echo '<tr><td>';
									echo 'Result '.$i.' Click <a href='.$list['Lien'].'>here</a><br><br>';
							 echo '</td></tr>';
							 echo '<tr align=center><td >';
								echo $list['Details'] ;	
							 echo '</td></tr></table><hr>';
					   $i++ ;
				   }
				 }
				 mysql_close() ;
				}					
}

?>