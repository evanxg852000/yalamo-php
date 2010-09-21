<?php
/*
lister le contenu d'un rep
ceere un repertoire et ses sous rep en chaine
efaccer un rep
remonter un repertoire d'un cran
*/
Class Repertoire{
private $repertoire;

 function __tostring() {
    return "Cette classe permet de définir et manipuler un repertoire.<br/>";
    }

function __construct($repertoire) 
  {
    $this->repertoire =$repertoire;
  }
  
function RepCreer() 
  {
    if (mkdir($this->repertoire, 0700))
	{
		return true;
	}
	else
	{
		return false;
	}
  }
  
function RepSupprimer() //suprimme un repertoire meme s'il contien des doc
  {
			function browse_dir($dir)
			{
				$handle = opendir($dir);
				while($elem = readdir($handle)) //ce while vide tous les repertoire et sous rep
				{
					if(is_dir($dir.'/'.$elem) && substr($elem, -2, 2) !== '..' && substr($elem, -1, 1) !== '.') //si c'est un repertoire
					{
						browse_dir($dir.'/'.$elem);
					}
					else
					{
						if(substr($elem, -2, 2) !== '..' && substr($elem, -1, 1) !== '.')
						{
							unlink($dir.'/'.$elem);
						}
					}
						
				}
				
				$handle = opendir($dir);
				while($elem = readdir($handle)) //ce while efface tous les dossier
				{
					if(is_dir($dir.'/'.$elem) && substr($elem, -2, 2) !== '..' && substr($elem, -1, 1) !== '.') //si c'est un repertoire
					{
						browse_dir($dir.'/'.$elem);
						rmdir($dir.'/'.$elem);
					}	
				
				}
				if (rmdir($dir))
				{
					return true;
				}
				else
				{
					return false;
				}
			}
		return	browse_dir($this->repertoire);
  }
  
function Rep_Up()
  {
	//on a: C:/wamp/www/Dopa
	//scinde le chemenin en morceau
	$pieces = explode("/", $this->repertoire);
	//compte  les morceaux
	$taille=count($pieces);
	//remonte d'un cran en arriere du chemin en reconstituant les morceaux on a: C:/wamp/www/
	for ($i=0;$i<=$taille-2;$i++)
	{
	  $repertoire=$repertoire.$pieces[$i].'/';	
	}	  
  return $repertoire;
  }

function RepListe()
  {
	$tableau=array();
	$i=0;
	$pointeur = opendir($this->repertoire); 
	while ($fichier = readdir($pointeur)) {
		   if (substr($fichier, -1)!="." )
		   {
				$tableau[$i]= $fichier;
				$i++;
		   }	   
    } 
    if(count($tableau)>0) //comptage du nbr d'el pour trier
    {
        array_multisort($tableau, SORT_ASC); 
    }
       closedir($pointeur); 
       return $tableau;
  }


}
/*/exemple d'utilistion
	listage
$mon_rep=new Repertoire('C:/wamp/www/Dopa');
print_r($mon_rep->RepListe());

remonter
echo '<br>'.$mon_rep->Rep_Up();

ceration
$mon_rep=new Repertoire('./mon dossier');	
$mon_rep->RepCreer()
	
suppression
$mon_rep=new Repertoire('dossier/');	
$t=$mon_rep->RepSupprimer();
echo $t;	
*/	
?>