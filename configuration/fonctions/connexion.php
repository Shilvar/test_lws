<?php
	
	/**
	 * Liste des fonctions relatives à la connexion avec la base de données
	 * @autor: Brion Sébastien
	 */

	/**
	 * Fonction qui va ouvrir une connexion à la BDD
	 */
	function connexionBdd(){
		try{
		    $connexion = new PDO('mysql:host='.HOST.';dbname='.BASENAME, USER_BDD, PASSWORD_BDD);
		    return $connexion;
		}catch(Exception $e){		    
		   return false;
		}
	}
?>