<?php
class C_Zip {
  private $zip;                 //reference de l'objet interne crerer
  private $Origine_folder;     //chemin du fichier d'origine
  private $Nom_fichier;       //nom du fichier zip a extraire qui peut etre le nom du dossier a compresser lors de la creation d'un zip
  private $Extrac_folder;    //dossier d'extration 
  private $Tableau_fichier; //liste des fichier contenu dans le zip
  
  function __tostring() {
    return "Cette classe permet de définir et manipuler uneun fichier zip";
    }

  function __construct($chemin,$nom) { 
	 $this->Origine_folder = $chemin;
	 $this->Nom_fichier = $nom.'.zip';
	 $this->zip = new ZipArchive; 
    }
//==================================================   
  function ExtraireFichier($destination) {
      $this->Extrac_folder = $destination;
	  $bool = $this->zip->open($this->Origine_folder.$this->Nom_fichier);
			if ( $bool== TRUE) {
				$this->zip->extractTo($this->Extrac_folder);
				$this->zip->close();
				return true;
			} else {
				return false;
			}
    }
//==================================================   
   function CreateZip() { 
	 $nom_dossier= substr($this->Nom_fichier, 0,strlen($this->Nom_fichier)-4); 
	  $test = $this->zip->open( $this->Nom_fichier, ZipArchive::CREATE);
	if ($test === TRUE) {
		$this->zip->addEmptyDir($nom_dossier); //ajoute le dossier a compresser 
		$this->zip->close();
		return true;
	} else {
		return false;
	}

  }
   
 //==================================================   
  function AjouterFichier($list) {
    $bool = $this->zip->open($this->Origine_folder.$this->Nom_fichier);
	$sourep=substr($this->Nom_fichier, 0, strlen($this->Nom_fichier)-4).'/'; 
	  if ( $bool== TRUE) 
	  {
		  for($i=0;$i<=count($list);$i++)
		  {
			$nom_fic=basename($list[$i]);
			$this->zip->addFile($list[$i],$sourep.$nom_fic );
		  }
		$this->zip->close();
		return true;
	  }
	  else
	  {
		return false;
	  } 
    }
 //==================================================   
  function ArchiverDossier() //le dossier doit exister a l'instanciation
  {
	$repertoire=substr($this->Nom_fichier, 0, strlen($this->Nom_fichier)-4).'/';
	$this->CreateZip();
	$list=$this->ListerDossierSource($repertoire);
	$test=$this->AjouterFichier($list);
	if ($test){
	return true;
	}else{
	return false;
	}
  }
//==================================================   
  function ListerDossierSource($repertoire){
	//recuperation du contenu du dossier
	  if($dir=opendir( $repertoire)){
		$result=array();
		$i=0;
		while ($file = readdir($dir)) {
			$result[$i]=$file;
			$i++;
		}
		closedir($dir);
	  }
	  else{
	  //nothing
	  }
	  return $result;
   } 
//================================================== 
  function EffaceArchive()
  {
   $test=unlink($this->Origine_folder.$this->Nom_fichier);
			if ($test){
			return true;
			}else{
			return false;
			}
  }
//==================================================  
    function ListerDossierCompresse( ) {
    
    }
//==================================================   
  function LireFichier($nom) { //lire un fichier dans le dossier compresser

  }
  
  
  }




/*

echo 'test1='.$test;

$list=ListerDossierSource('./');
$evance=new C_Zip('','folder');
$test=$evance->CreateZip();
//$list=array(1=>'test/class.php',2=>'test/gre.php');
$evance->AjouterFichier($list);


*/
//exemple archiver le dossier test/ dans le meme rep que le scrip	
$evance=new C_Zip('','folder');
$evance->ArchiverDossier();
 
//exemple deffacage
$evance=new C_Zip('','zip');
$evance-> EffaceArchive();

//exemple pour extraire un fichier nomme zip.zip dans le meme repertoire du script
$xavier = new C_Zip('','test');
$xavier->ExtraireFichier('extra/');

?>