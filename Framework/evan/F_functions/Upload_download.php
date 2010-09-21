<?php
function get_max_size() // cette fonction retoure la taille max du fichier a uploader defini dans php ini (default=2GO)
{
   $val = trim(ini_get('post_max_size'));
   $last = strtolower($val{strlen($val)-1});
   switch($last) {
       case 'g':
           $val *= 1024;
       case 'm':
           $val *= 1024;
       case 'k':
           $val *= 1024;
   }
   return $val;
}
	
function upload($tableau_fichier,$repertoire_upload,$type_autorise)
{
		$max_size=get_max_size();
		$test=false;

		if(!empty($tableau_fichier)){
			// Récupération normale des informations
			//comptage du nbre de fichier a transferer
			$nb_fichiers = count($tableau_fichier['fichier']['tmp_name']);
			for($i = 0; $i< $nb_fichiers; ++$i){
				if(is_uploaded_file($tableau_fichier['fichier']['tmp_name'][$i])){
					$name     = $tableau_fichier['fichier']['name'][$i];
					$tmp_name = $tableau_fichier['fichier']['tmp_name'][$i];
					 $type = $_FILES['fichier']['type'][$i];
					$error    = $tableau_fichier['fichier']['error'][$i];
					$clean_name = strtolower(basename($name));
					$clean_name = preg_replace('/[^a-z0-9.-]/', '-', $clean_name);
				    if($tableau_fichier['fichier']['size'][$i]>=$max_size)
					{
						return $test;
						exit;
					}
					//verifie si le type est autorise a etre uploader
					$n=count($type_autorise);
					for($j=0;$j<$n;++$j)
					{
					   if(($type_autorise[$j])!=$type)
					   {
						   
						   //le est autorise alors on le deplace
							// Déplacement  du répertoire temporaire vers le rep de destination
							if(move_uploaded_file($tmp_name, $repertoire_upload.$clean_name))
							{
								$test=true; //$error_string = 'Le fichier a été déplacé correctement';
							}
					   }
					}
				}
			}
		}
		return $test;
}

function upload_form($nb_fichier)//creer un formulaire d'upload avec le nbre de fichier
{

}
?>