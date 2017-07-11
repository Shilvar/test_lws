#################################################
#      INSTALLATION DE LA BASE DE DONNEES       #
################################################# 

Le fichier comprenant les tables nécessaires à l'utilisation de l'application se trouve dans le réperoire "fichier_sql"
et s'intitule "tables.sql".

Créez votre base de données depuis votre portail phpMyAdmin puis importer le fichier "tables.sql"
Deux tables seront créées : 

	- Une table "client" permettant d'insérer les nouveaux clients
	- une table "ville" permettant d'utiliser l'autocompletion pour le formulaire


#################################################
#         ARCHITECTURE DE L'APPLICATION         #
#################################################

L'application est divisé en plusieurs dossiers:  

	- Dossier "Configuration" : Dossier qui contient tout ce que l'application à besoin pour fonctionner (librairie, class globales, fonctions, etc...)
		- Dossier "Classes" : Dossier qui regroupe toutes les classes globales de l'application
		- Dossier "Fonctions" : Dossier qui regroupe toutes les fonctions séparées par thème
		- Dossier "Librairies" :  Dossier qui regroupe les librairies utilisées dans l'application (PhpMailer, Smarty, et oAuth Twitter)
		- Fichier "configuration.php" : Fichier qui est appélé par chaque fichier php source (comme index.php) permettant d'inclure tous les fichiers nécessaires
		- Fichier "constantes.php" : Fichier comprenant les constantes de l'application
	
	- Dossier "Controleur" : Dossier qui contient l'ensemble des controleurs de notre application
	- Dossier "Modeles" : Dossier qui contient l'ensemble des modèles de notre application
	- Dossier "Public" : Dossier qui contient les fichiers css, javascript, et les images
	- Dossier "Vues" : Dossier qui contient l'ensemble des vues
	- Fichiers "clients.php" et "index.php" : points d'entrée de notre application


############################################################
#      CONFIGURATION DES CONSTANTES DE L'APPLICATION       #
############################################################

Pour configurer les constantes permettant de faire fonctionner l'application, vous devez dans le fichier : /configuration/constantes.php
Ce fichier est utilisé pour les paramètres de connexion à votre base de données, à l'envoi du mail en SMTP sécurisé et pour l'envoi d'un tweet



Pour l'envoi d'un e-mail via un SMTP sécurisé, vous devez :

	- Posséder une adresse G-MAIL valide
	- Avoir le port 465 d'ouvert sur le serveur
	- Modifier les paramètres dans le fichier constantes.php

La fonction permettant d'envoyer un mail se situe dans le fichier : /configuration/fonctions/mail.php



Pour l'envoi d'un tweet, vous devez : 
	
	- Posséder un compte Twitter valide
	- Avoir créé une application depuis https://apps.twitter.com/
	- Avoir généré les tokens dans la partie "Keys and Access token"
	- Mettre à jour les constantes dans le fichier constantes.php



##############################################
#      FONCTIONNEMENT DE L'APPLICATION       #
##############################################

Le point d'entré de l'application est soit le fichier "index.php" ou "clients.php".
En faisant appel à ces fichiers, l'application va générer la page via la fonction "genererPage" contenu dans le fichiers : /configuration/fonctions/affichage.php
Que ce soit l'appel ajax ou l'appel depuis l'url, on passe toujours par cette fonction général pour récupérer le contenu souhaité (html, json, etc...)
Cette fonction va instancier le controleur (ici, on a uniquement le controleur Client.class.php) et va charger sa méthode (soit par défaut "index()", soit la méthode appelée)

Les modèles sont des classes filles de la classe abstraite "Modele" contenu dans le fichier : /configuration/classes/modele.class.php
Cette classe abstraite permet de gérer l'exécution d'une requête et faire appel au constructeur lorsque l'on fait appel à la classe fille.

Le moteur de template est Smarty, cela me permet de séparer le code HTML du PHP.
