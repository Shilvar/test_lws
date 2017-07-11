<?php

	/**
	 * Liste des constantes utilisées dans l'application
	 * @autor: Brion Sébastien
	 */

	//Constantes pour la connexion à la base de données
	define('HOST', 'xxxxx');					// Hôte de la base de données
	define('BASENAME', 'xxxxxx');					// Nom de la base de données
	define('USER_BDD', 'xxxxxx');					// Login de la base de données
	define('PASSWORD_BDD', 'xxxxxx');				// Mot de passe de la base de données

	//Constantes pour l'envoi du mail via SMTP
	define('FROM', 'b.sebastien.88@gmail.com'); 		// E-mail d'envoi
	define('FROM_NAME', 'BRION Sébastien'); 			// Nom de la personne qui envoie le mail
	define('HOST_SMTP', "smtp.gmail.com");				// Hôte du serveur SMTP
	define('PORT_SMTP', 465);							// Port à utiliser pour le SMTP
	define('MODE_SECURITE', 'tls');						// Mode de sécurité à employer pour l'envoi SMTP
	define('GMAIL_USER', 'b.sebastien.88@gmail.com');	// Login du compte Gmail
	define('GMAIL_PWD', '*****');					    // Mot de passe du compte Gmail

	//Constantes pour l'envoi du Tweet
	define('CONSUMER_KEY','xxxx');
        define('CONSUMER_SECRET' ,'xxxx');
        define('ACCESS_TOKEN', 'xxxx');
        define('ACCESS_TOKEN_SECRET', 'xxxxx');

	//Déclaration des constantes générales
	define('RACINE', './');							
	define('PATH_CONFIGURATION', RACINE.'configuration');
	define('PATH_CONTROLEURS', RACINE.'controleurs/');
	define('PATH_VUES', RACINE.'vues/');
	define('PATH_PUBLIC', RACINE.'public/');
	define('PATH_MODELES', RACINE.'modeles/');
	define('PATH_IMAGES', PATH_PUBLIC.'images/');

	define('CONTROLEUR_DEFAULT', 'clients');			// Controleur à appeler par défaut si non renseigné
	define('METHODE_DEFAULT', 'index');					// Methode du controleur à appeler par défaut si non renseigné
	define('NB_ELEMENT_PAR_PAGE', 3);					// Définit le nombre de ligne dans le tableau pour le listing client
	
?>
