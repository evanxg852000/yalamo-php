<?php

function create_file($repertoire,$nom_fichier,$contenu_a_ecrire,$extention) 
{
	Global $PATH_ROOT ;
	$test=false ;
	// $repertoire doit etre donne par raport au $ftp_root exple: ftp_root= ftp://localhost/Dopa/ et rep=temp
	$fichier =$PATH_ROOT.$repertoire.$nom_fichier.'.'.$extention;
    $fp = fopen($fichier, "w"); // le fichier est ouvert en ecriture, remis a zero
    if (!$fp) {
        return $test;
        exit;
    }
    fwrite($fp,$contenu_a_ecrire );
	$test=true ;
    fclose($fp);
	return $test;
}	

// cree le bacup d'un fichier dans le rep bacup exple fic: config/test.txt devient backup/backup_config.txt
function create_backup($repertoire,$fichier) //appel: cerate_bacup_file("monrepertoire/","monfichier.txt")
{
Global $PATH_ROOT ;
$test=false ;
$fichier_backup=$PATH_ROOT.'backup/backup_'.$fichier ;
$fichier =$PATH_ROOT.$repertoire.$fichier;

	$fp = fopen($fichier, "r"); // le fichier est ouvert en lecture
    if (!$fp) {
        return $test;
        exit;
    }
	$contenu = fread( $fp, filesize( $fichier ) );
     //$contenu=fgets($fp,9);
	   fclose($fp);
    
    $fp = fopen($fichier_backup, "w"); // le fichier bacup est ouvert en ecriture
    if (!$fp) {
        return $test;
        exit;
    }
    fwrite($fp,$contenu);
	$test=true ;
    fclose($fp);
	return $test;

}

//recupere un fichier nomme xxx_bacup dans le repertoire bacup et le restore en renplacant l'encien
function recove_backup($repertoire,$fichier) //appel: recove_backup('rep de destination du fich a recover','nom du fic a rco')
{
Global $PATH_ROOT ;
$test=false ;
$fichier_backup=$PATH_ROOT.'backup/backup_'.$fichier ;
$fichier =$PATH_ROOT.$repertoire.$fichier;

	$fp = fopen($fichier_backup, "r"); // le fichier est ouvert en lecture
    if (!$fp) {
        return $test;
        exit;
    }
	$contenu = fread( $fp, filesize( $fichier_backup ) );
	   fclose($fp);
    
    $fp = fopen($fichier, "w"); // le fichier bacup est ouvert en ecriture
    if (!$fp) {
        return $test;
        exit;
    }
    fwrite($fp,$contenu);
	$test=true ;
    fclose($fp);
	return $test;
}
?>