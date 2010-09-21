<?php
class Koly  //ma methode  de cryptage
{
	private $chaine;
	function __construct($chaine) 
	{
		$this->chaine=$chaine;
	}

	function Crypter()
	{
		return 'fonction non definie';
	}

	function Decrypter()
	{
		return 'fonction non definie';
	}
}

//=================================================Classe pricipale==================================================
/*
cette class  utilise les type de crypetage MD5,Crypt();sha1 et Koly=ma methode de cryptographie
M->md5
C->crypt
S->sha1
K->koly (seul cette methode peut etre decrypter )
*/

Class MotCrypte{
private $chaine;
private $type;
	
function __tostring() 
{
    return "Cette classe permet de définir et manipuler un mot crypte.<br/>";
}

function __construct($chaine, $type) 
{
    $this->chaine=$chaine;
    $this->type=$type;	
}

function Crypter()
{
	switch ($this->type)
	{
		case 'm':
		       return md5($this->chaine);
		break;
		case 'c':
				return crypt($this->chaine);
		break;
		case 's':
			return sha1($this->chaine);
		break;
		case 'k':
			    $koly=new Koly($this->chaine);
				return $koly->crypter();
		break;
	}
}

function Decrypter()
{
	switch ($this->type)
		{
			case 'm':
				   return md5($this->chaine);
			break;
			case 'c':
					return crypt($this->chaine);
			break;
			case 's':
				return sha1($this->chaine);
			break;
			case 'k':
					$koly=new Koly($this->chaine);
					return $koly->decrypter();
			break;
		}
}
}
/*
//exemple d'utilisation

$c=new MotCrypte("evance","m");
echo 'type md5: crypt '.$c->Crypter();
echo 'type md5: decrypt '.$c->Decrypter();
echo '<br>';

$c=new MotCrypte("evance","s");
echo 'type Shacal: crypt'.$c->Crypter();
echo 'type Shacal: decrypt '.$c->Decrypter();
echo '<br>';
*/

?>