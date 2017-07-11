#################################################
#      INSTALLATION DE LA BASE DE DONNEES       #
################################################# 

Le fichier comprenant les tables n�cessaires � l'utilisation de l'application se trouve dans le r�peroire "fichier_sql"
et s'intitule "tables.sql".

Cr�ez votre base de donn�es depuis votre portail phpMyAdmin puis importer le fichier "tables.sql"
Deux tables seront cr��es : 

	- Une table "client" permettant d'ins�rer les nouveaux clients
	- une table "ville" permettant d'utiliser l'autocompletion pour le formulaire


#################################################
#         ARCHITECTURE DE L'APPLICATION         #
#################################################

L'application est divis� en plusieurs dossiers:  

	- Dossier "Configuration" : Dossier qui contient tout ce que l'application � besoin pour fonctionner (librairie, class globales, fonctions, etc...)
		- Dossier "Classes" : Dossier qui regroupe toutes les classes globales de l'application
		- Dossier "Fonctions" : Dossier qui regroupe toutes les fonctions s�par�es par th�me
		- Dossier "Librairies" :  Dossier qui regroupe les librairies utilis�es dans l'application (PhpMailer, Smarty, et oAuth Twitter)
		- Fichier "configuration.php" : Fichier qui est app�l� par chaque fichier php source (comme index.php) permettant d'inclure tous les fichiers n�cessaires
		- Fichier "constantes.php" : Fichier comprenant les constantes de l'application
	
	- Dossier "Controleur" : Dossier qui contient l'ensemble des controleurs de notre application
	- Dossier "Modeles" : Dossier qui contient l'ensemble des mod�les de notre application
	- Dossier "Public" : Dossier qui contient les fichiers css, javascript, et les images
	- Dossier "Vues" : Dossier qui contient l'ensemble des vues
	- Fichiers "clients.php" et "index.php" : points d'entr�e de notre application


############################################################
#      CONFIGURATION DES CONSTANTES DE L'APPLICATION       #
############################################################

Pour configurer les constantes permettant de faire fonctionner l'application, vous devez dans le fichier : /configuration/constantes.php
Ce fichier est utilis� pour les param�tres de connexion � votre base de donn�es, � l'envoi du mail en SMTP s�curis� et pour l'envoi d'un tweet



Pour l'envoi d'un e-mail via un SMTP s�curis�, vous devez :

	- Poss�der une adresse G-MAIL valide
	- Avoir le port 465 d'ouvert sur le serveur
	- Modifier les param�tres dans le fichier constantes.php

La fonction permettant d'envoyer un mail se situe dans le fichier : /configuration/fonctions/mail.php



Pour l'envoi d'un tweet, vous devez : 
	
	- Poss�der un compte Twitter valide
	- Avoir cr�� une application depuis https://apps.twitter.com/
	- Avoir g�n�r� les tokens dans la partie "Keys and Access token"
	- Mettre � jour les constantes dans le fichier constantes.php



##############################################
#      FONCTIONNEMENT DE L'APPLICATION       #
##############################################

Le point d'entr� de l'application est soit le fichier "index.php" ou "clients.php".
En faisant appel � ces fichiers, l'application va g�n�rer la page via la fonction "genererPage" contenu dans le fichiers : /configuration/fonctions/affichage.php
Que ce soit l'appel ajax ou l'appel depuis l'url, on passe toujours par cette fonction g�n�ral pour r�cup�rer le contenu souhait� (html, json, etc...)
Cette fonction va instancier le controleur (ici, on a uniquement le controleur Client.class.php) et va charger sa m�thode (soit par d�faut "index()", soit la m�thode appel�e)

Les mod�les sont des classes filles de la classe abstraite "Modele" contenu dans le fichier : /configuration/classes/modele.class.php
Cette classe abstraite permet de g�rer l'ex�cution d'une requ�te et faire appel au constructeur lorsque l'on fait appel � la classe fille.

Le moteur de template est Smarty, cela me permet de s�parer le code HTML du PHP.
