<?php
	
	/**
	 * Modèles qui va gérer les requêtes de la table Ville
	 * @autor: Brion Sébastien
	 */

	class Ville extends Modele{

		public $id_ville;
		public $ville;
		public $code_postal;

		/** 
		 * Fonction qui retourne une liste de ville en fonction de la recherche de l'utilisateur
		 * @param  Array<>  		$donnees 		Données saisie par l'utilisateur (code postal ou ville)
		 * @return  Array<Array>  					Liste des villes trouvées sous forme de tableau de tableau
		 */
		public static function rechercherVille(&$donnees){
			$requete = 'SELECT * FROM '.self::getNomTable().' WHERE '.$donnees['champs'].' LIKE "'.$donnees['recherche'].'%"';	
			$list_ville = self::executeRequete($requete, 'select');			
			return Modele::jsonSerializeArrayObject($list_ville, true);
		}

	}
?>