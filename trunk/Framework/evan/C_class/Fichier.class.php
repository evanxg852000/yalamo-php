<?php
Class Fichier{
private $nom;
private $contenu;

function __tostring() 
{
    return "Cette classe permet de manipuler un fichier.<br/>";
}

function __construct($nom) 
{
	$this->nom=$nom;
	
}

function CreerFichier($contenu)
{ 
			$fp=fopen($this->nom,'w');
				if(fwrite($fp,$contenu))
				{
					fclose($fp);
					return true;
				}
				else
				{
					fclose($fp);
					return false;
				}
}

function LireFichier()
{
		if (file_exists( $this->nom))
		{
			$fp=fopen($this->nom,'rb');
			$this->contenu=fread($fp, filesize($this->nom));
			fclose($fp);
			return $this->contenu;
		}
		else
		{
			return false;
		}
}

function AjouterFichier($contenu)
{
		if (file_exists( $this->nom))
		{
			$fp=fopen($this->nom,'a');
			fwrite($fp,$contenu);
			fclose($fp);
			return $this->contenu;
		}
		else
		{
			return false;
		}
}

function EffacerFichier()
{
	if(unlink($this->nom))
	{
		return true;
	}
	else
	{
		return false;
	}
}

function CopierFichier($nom_copie)
{
	if(copy($this->nom,$nom_copie))
	{
		return true;
	}
	else
	{
		return false;
	}
}

}
/*
//exemple 
$f=new Fichier("bric.png");
//$f->EffacerFichier();
//$f->CopierFichier("brev.txt")
//$f->CreerFichier("voici l'utilisation de ma classe");
$f->AjouterFichier("\n  je sui un ajout de text");
echo $f->LireFichier();
*/
?>