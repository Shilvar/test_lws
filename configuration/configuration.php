<?php

	/**
	 * Fichier de configuration qui va charger tous les fichiers nécessaires avant la génération d'une page
	 * @autor: Brion Sébastien
	 */

	session_start();

	//on inclut les fichiers nécessaires au fonctionnement du site
	include('./configuration/constantes.php');
	include(PATH_CONFIGURATION.'/fonctions/fichiers.php');

	$list_path_exclu = array(PATH_CONFIGURATION.'/fonctions/fichiers.php');
	include_list_fichier(PATH_CONFIGURATION.'/fonctions/', $list_path_exclu);

	//on inclut la classe du moteur de template
	include(PATH_CONFIGURATION.'/librairies/smarty/Smarty.class.php');

	//on inclut les fichiers pour utiliser PHPMailer (envoi de mail)
	require_once(PATH_CONFIGURATION.'/librairies/PHPMailer/class.phpmailer.php');
    require_once(PATH_CONFIGURATION.'/librairies/PHPMailer/class.smtp.php');

    //on inclut le fichier permettant d'envoyer des tweet via oAuth
    require (PATH_CONFIGURATION.'/librairies/Twitter/twitteroauth/twitteroauth.php');

	//on inclut les class générales
	include_list_fichier(PATH_CONFIGURATION.'/classes/');

	//On inclut toutes les classes des Modèles
	include_list_fichier(PATH_MODELES);

	//on inclut les controleur du header et du footer
	include(PATH_CONTROLEURS.'Header.class.php');
	include(PATH_CONTROLEURS.'Footer.class.php');
?>
