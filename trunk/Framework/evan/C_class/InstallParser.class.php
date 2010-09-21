<?php
class InstallParser {
	private $Xmlobject;
	public $version;
	public $type;
	public $name;
	public $lien;
	public $files;
	public $sqls;

// Construction de l'objet en lui passant le fichier à parser
   function __construct($nomfichier)
   {
		$this->files= Array();
		$this->sql= Array();
		$this->Xmlobject= simplexml_load_file($nomfichier);
		$this->version	= $this->Xmlobject->version;
		$this->type	= $this->Xmlobject->type;
		$this->name	= $this->Xmlobject->name;
		$this->lien	= $this->Xmlobject->lien;
		for($i=0;$i<=count($this->Xmlobject->files);$i++)
		{
			$this->files[$i]= $this->Xmlobject->files->file[$i];
		}
		for($i=0;$i<=count($this->Xmlobject->sqls);$i++)
		{
			$this->sqls[$i]= $this->Xmlobject->sqls->sql[$i];
		}
	}
	
}
/*
//exemple d'tulisation de la classe
    $xml = new InstallParser('install.xml');
    echo $xml->version;
	echo $xml->name;
	echo $xml->type;
	echo $xml->files[0];
	echo $xml->files[1];
	*/
?>