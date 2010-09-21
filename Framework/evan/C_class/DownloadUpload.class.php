<?php
class DownloadUpload{
private $maxsize;
private $repertoire; //repertoire des fichiers a dowloder ou rep de destination de l'upload
private $type=array(); //type autorise par l'instance
private $files=array();
private $bilan=array(); //permet de dresser un bilandes fichier uploader permet de voire l'echeque de lupload plus en detail


function __tostring() 
	{
    return "Cette classe permet de définir et manipuler une upload ou download.<br/>";
    }

  function __construct($repertoire,$type) 
    {
         $this->repertoire=$repertoire ;
		 $this->type=$type ;
		 $this->Max_size();
    }

protected function Max_size() // cette fonction retoure la taille max autorise du fichier 
	{                       //a uploader par le serveur defini dans php ini (default=2GO)
		$val = trim(ini_get('post_max_size'));
		$last = strtolower($val{strlen($val)-1});
			switch($last)
			{
				case 'g':
						$val *= 1024;
				case 'm':
						$val *= 1024;
				case 'k':
						$val *= 1024;
			}
   		$this->maxsize=$val ;
		return $this->maxsize;
	}
	
function Get_max_size() 
	{
		return $this->maxsize;
	}

function Get_bilan() 
	{
		return $this->bilan;
	}
	
function Upload($files)
	{
		if(!empty($files))
		{
			// Récupération normale des informations
			//comptage du nbre de fichier a transferer
			$nb_fichiers = count($files['fichier']['tmp_name']);
			$raport=array();
			for($i = 0; $i<$nb_fichiers; $i++)
			{
				if(is_uploaded_file($files['fichier']['tmp_name'][$i]))
				{
					$name     = $files['fichier']['name'][$i];
					$tmp_name = $files['fichier']['tmp_name'][$i];
					$type_file = $files['fichier']['type'][$i];
					$error    = $files['fichier']['error'][$i];
					$clean_name = strtolower(basename($name));
					$clean_name = preg_replace('/[^a-z0-9.-]/', '-', $clean_name);
				    if($files['fichier']['size'][$i]>=$this->maxsize)
					{
							$raport[$i]['size']=false;
					}
					//verifie si le type est autorise a etre uploader
					$test_type=false;
					for($j=0;$j<count($this->type);$j++)
					{
					   if(($this->type[$j])==$type_file)
					   { 
							$test_type=true;
					   }
					}
					if ($test_type==true)
					{
							//si le est autorise alors on le deplace
							if(move_uploaded_file($tmp_name, $this->repertoire.$clean_name)) // Déplacement  du répertoire temporaire vers le rep de destination
							{
								//$test=true; //si l'un des fichier est transfere on considere comme succes car le filtre a rejeter les otre c qui est normal 
							}	
							else
							{
								$raport[$i]['move']=false;
							}
					}
					else
					{
						$raport[$i]['type']=false;
					}
				}
			}
			$this->bilan=$raport;
		}
		else
		{
			return false;
			exit;
		}
		//analyse du raport
		if(count($raport)==0)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	
function Download($files)
	{
		
	}
}
?>