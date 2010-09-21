<?php
//on ouvre la BD pour extraire la valeur du template ayant pour etat 1
function get_design()
{
	Global 	$DB_PREF;
	$sql="Select* from ".$DB_PREF."template where Etat=1 ";
	$req=new DatabaseRequest($sql);
	$resultat=$req->Select();	
	unset($req);
	return $resultat[0]['Nom'];
}



//on execute une requete qui met a jour la table template
function set_design($num)
{
Global $SERVER,$USERNAME,$PASSSQL,$DBNAME ;
	$req="update  template SET Etat=0 where Etat=1 ";
	$result=select_rec ( $req ) ;
	$nb_ligne = mysql_num_rows($result);
	$req="update  template SET Etat=0 where Etat".$num;
}

//on liste les templates
function list_design()
{
        $req=" Select* from template ";
		$result=select_rec ( $req ) ;
		$nb_ligne = mysql_num_rows($result);
		while ( $list = mysql_fetch_array( $result) ) 
		{
			if($list['Etat']==1)
			{
				echo $list['Nom']; //afficher comme active
			}
			else
			{
			echo $list['Nom']; //afficher simple
			}
		} 
}

?>