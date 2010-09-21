<?php
class DatabaseRequest{
private $dbpath;
private $dbname;
private $sql;
private $dbressource;

function __tostring() {
    return "Cet objet emet une requete sqlite";
    }

  function __construct($sql) { //constructeur
	 Global $DBPATH,$DBNAME ;
	 $this->dbpath=$DBPATH;
	 $this->dbname=$DBNAME;	
	 $this->sql=$sql;
    }

protected function Connexion() //cette methode cerer la connection
{	
	$this->dbressource=sqlite_open($this->dbpath.$this->dbname.'.ddb',0666,$sqliteerror);
    if ($this->dbressource) 
	{
        return true;       
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
		 if ( sqlite_exec($this->dbressource,$this->sql)) 
		{
			return true;
		}
		else
		{
			return false;
		}
		sqlite_close($this->dbressource) ;
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
		$query = sqlite_query($this->dbressource,$this->sql);
		$nb_colone=sqlite_num_fields($query); //recuperation du nombre de colone
		$nb_ligne=sqlite_num_rows($query);   //recuperation du nombre de ligne	
		for($i=0;$i<$nb_ligne;$i++)         //parcours de lignes
			{
				$list=sqlite_fetch_array($query); //selectione une ligne deplace le pointeur a chaque iteration
				for($j=0;$j<$nb_colone;$j++)
					{
						$nom_colone=sqlite_field_name($query, $j); //recuperation du nom de la colone par indice
						$table[$i][$nom_colone]= $list[$j];
					}					
			}
		return $table;
		sqlite_close() ;
	}
	else
	{
		return $table;
	}
}

function SelectJson() //methode qui selection et  converti en string json
{
     if($this->Connexion())
		{
			$table=array();
			$query = sqlite_query($this->dbressource,$this->sql);
			if(sqlite_num_rows($query)<=0)
			{
				$table=array( array( "Num"=>"NO RECORD","Nom"=>"NO RECORD","Contenu"=>"NO RECORD" ,"Titre"=>"NO RECORD", "Reponse"=>"NO RECORD","Lien"=>"NO RECORD", "Description"=>"NO RECORD","Num_so"=>"NO RECORD"  ,"Date"=>"NO RECORD","ipCon"=>"NO RECORD","heureCon"=>"NO RECORD","dateCon"=>"NO RECORD","lheure"=>"NO RECORD","Nb_charg"=>"NO RECORD" ));
				return '{success:true,rows:'.json_encode($table).'}';
			}
			else
			{
				while($obj = sqlite_fetch_object($query ))    
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

/*  exemple dutilistation 1 retoune un tableu
	include('kernel/configuration.php'); //inclusion des parametre sqlite
	
//exemple dutilistation 2 effectue une action sur une table
	$sql="INSERT INTO news ( Num , Nom , Contenu , Publie , Date ) VALUES ( NULL , 'ivan' , 'ivan' , 'Y' , '' )";
	$req=new DatabaseRequest($sql);
	$tes=$req->Request();
	echo $tes;
//exemple selection
	$sql="select* from news";
	$req=new DatabaseRequest($sql);
	$tes=$req->Select();
	print_r($tes);
	echo $tes[6]['Nom'];
//exemple json	
	$sql="select* from news";
	$req=new DatabaseRequest($sql);
	$tes=$req->SelectJson();
	echo $tes;	
*/	
?>