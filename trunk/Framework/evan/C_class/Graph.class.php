<?php
Class Graph{
private $nom; //nom de l'image
private $donnee=array();
private $option; //-s enregister sur le disque, -a pour generer seulement
private $largeur;
private $hauteur;
private $image; //image courante
private $nom_sorti;

function __tostring() 
{
    return "Cette classe permet de manipuler un fichier.<br/>";
}

function __construct($nom,$nom_sorti,$donnee,$option) //si on specifie l'image de fond on la largeur depend du fond
{	
		$this->nom=$nom;
		$this->donnee=$donnee;
		$this->option=$option;
		if(file_exists($nom)&& substr($nom,-3)=='png')
		{
			$this->nom_sorti=$nom_sorti;
			$info=getimagesize( $nom);
			$this->largeur=$info[0];
			$this->hauteur=$info[1];
			$this->image=imagecreatefrompng($nom);
		}
		else
		{
				return false;
		}		
}

protected function Barre()//horizontal ou vertical h,v
{
	$table=$this->donnee;
	$blanc=imagecolorallocate($this->image, 0, 0,0);
	$r=255;
	$v=0;
	$b=255;
	$x_0=43; //se termine a 460 
	$y_0=257;   //se termine a 65 (192)  
	$l_barre=30;
	$equart=35;
	for($i=0;$i<count($table);$i++)
	{
		$r=$r-10;$v=$v+10;$b=$b-5;
		$x_0=$x_0+$equart;
		$couleur=imagecolorallocate($this->image, $r,$v, $b);
		
		ImageFilledRectangle ($this->image, $x_0, $y_0,$x_0+$l_barre,$y_0-$table[$i]['value']*192/100, $couleur);
		
		imagestringup($this->image,6, $x_0+5,$y_0+35,$table[$i]['label'] , $blanc);
	}
	
}

function Dessine() //methode qui positione tous les composant
{
	header ("Content-type: image/png");
	$this->Barre();

	switch ($this->option) //on termine en enregistraant ou en affichant selon l'option
	{
		case '-s':
			imagepng($this->image, $this->nom_sorti); //on enregistre
		break;
		case '-a':
		    imagepng($this->image); //on affiche simplement
		break;
	
	}
} 

function DessineMini($width,$height) //methode qui positione tous les composant
{
	header ("Content-type: image/png");
	$this->Barre();
	$destination =imagecreatetruecolor($width,$height); 
	imagecopyresampled($destination, $this->image, 0, 0, 0, 0,$width,$height, $this->largeur, $this->hauteur);	
	switch ($this->option) //on termine en enregistraant ou en affichant selon l'option
	{
		case '-s':
			imagepng($destination, $this->nom_sorti); //on enregistre
		break;
		case '-a':
		    imagepng($destination); //on affiche simplement
		break;
	
	}
}

}
/*
$donnee=array(
0=>array(label=>'eva',value=>'12'),
1=>array(label=>'fre',value=>'20'),
2=>array(label=>'par',value=>'32'),
3=>array(label=>'ev',value=>'23'),
4=>array(label=>'griou',value=>'53')
);
$graph=new Graph('sondage.png','resul.png',$donnee,'-a');
//$graph->Dessine();
$graph->DessineMini(250,200);
*/
?>