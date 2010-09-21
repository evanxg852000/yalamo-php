<?php
class DatabaseRequest{
private $server;
private $username;
private $passsql;
private $dbname;
private $sql;

function __tostring() {
    return "Cet objet emet une requete mysql";
    }

  function __construct($sql) { //constructeur
	 Global $SERVER,$USERNAME,$PASSSQL,$DBNAME ;
	 $this->server =$SERVER ;
	 $this->username=$USERNAME;
	 $this->passsql=$PASSSQL;
	 $this->dbname=$DBNAME;	
	 $this->sql=$sql;
    }

protected function Connexion() //cette methode cerer la connection
{	
	if(mysql_connect( $this->server,  $this->username, $this->passsql) )
	{
		if(mysql_select_db($this->dbname))
		{
			return true;
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

function Request() //execute une requete et return un boolean (true ou false)
{   
    if($this->Connexion())
	{
		 if ( mysql_query($this->sql) ) 
		{
			return true;
		}
		else
		{
			return false;
		}
		mysql_close() ;
	}
	else
	{
	return false;
	}
}

function Select() //execute une requete et return un tableau  
{			
	$table=array();
	 if($this->Connexion())
	{
		$query = mysql_query($this->sql);
		$nb_colone=mysql_num_fields($query); //recuperation du nombre de colone
		$nb_ligne=mysql_num_rows($query); //recuperation du nombre de ligne	
		for($i=0;$i<$nb_ligne;$i++)   //parcours de lignes
			{
				$list=mysql_fetch_row($query); //selectione une ligne deplace le pointeur a chaque iteration
				for($j=0;$j<$nb_colone;$j++)
					{
						$nom_colone=mysql_field_name($query, $j); //recuperation du nom de la colone par indice
						$table[$i][$nom_colone]= $list[$j];
					}					
			}
		return $table;
		mysql_close() ;
	}
	else
	{
		return $table;;
	}
}

function SelectJson() //methode qui selection et  converti en string json
{
     if($this->Connexion())
		{

			$table=array();
			$query = mysql_query($this->sql);
			if(mysql_num_rows($query )<=0)
			{
				$table=array( array( "Num"=>"NO RECORD","Nom"=>"NO RECORD","Contenu"=>"NO RECORD" ,"Titre"=>"NO RECORD", "Reponse"=>"NO RECORD","Lien"=>"NO RECORD", "Description"=>"NO RECORD","Num_so"=>"NO RECORD"  ,"Date"=>"NO RECORD","ipCon"=>"NO RECORD","heureCon"=>"NO RECORD","dateCon"=>"NO RECORD","lheure"=>"NO RECORD","Nb_charg"=>"NO RECORD" ));
				return '{success:true,rows:'.json_encode($table).'}';
			}
			else
			{
				while($obj = mysql_fetch_object($query ))
				{
					$table[] = $obj;
				}
				return '{success:true,rows:'.json_encode($table).'}';
			}
		
		}
		else
		{
		return false;
		}
}

}

/*

//exemple dutilistation 1 retoune un tableu
	include('kernel/configuration.php'); //inclusion des parametre mysql
	
////exemple dutilistation 2 effectue une action sur une table
		$req=new DatabaseRequest('Delete from newsletter where Num=3')
	    echo $req->Request();
	
	$req=new DatabaseRequest('select* from news');
	$tes=$req->Select();
	//echo $tes[0]['Nom']; //exemple d'affichage
    print_r($tes);
	*/
?>