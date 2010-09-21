<?php
//inclusion des classe
//on inclu la class de requete selon le type de base de donnees 
//ces fichier contiene la meme class donc on inclut un et le contenu depand du type de bd
	switch ($TYPE_BD)
	{
		case 'mysql':
			require_once('C_class/MysqlRequest.class.php');
		break;
		case 'sqlite':
			require_once('C_class/SqliteRequest.class.php');
		break;
		//Case ajouter d'autre type de bd ...
	}
	require_once("C_class/Cookie.class.php");
	require_once("C_class/DownloadUpload.class.php");
	require_once("C_class/Fichier.class.php");
	require_once("C_class/Graph.class.php");
	require_once("C_class/InstallParser.class.php");
	require_once("C_class/Mail.class.php");
	require_once("C_class/MotCrypt.class.php");
	require_once("C_class/Repertoire.class.php");
	require_once("C_class/SessionUser.class.php");
	require_once("C_class/Zip.class.php");
	
	// inclusion des functions 
	require_once("F_functions/Clean.php");
	require_once("F_functions/Math.php");
	require_once("F_functions/Designs.php");
	require_once("F_functions/Controleur.php");	
	require_once("F_functions/Upload_download.php");
	require_once("F_functions/Gestion_connection.php");
	/*
	include('F_functions/Barre_navigation.php');
	include('F_functions/Mysql.php');	
	include('F_functions/Fichier.php');
	include('F_functions/Mail.php');
	include('F_functions/Image.php');
	*/
?>