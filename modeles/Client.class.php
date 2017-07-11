<?php

	/**
	 * Modèles qui va gérer les requêtes de la table Client
	 * @autor: Brion Sébastien
	 */

	class Client extends Modele{

		public $id_client;
		public $civilite;
		public $nom;
		public $prenom;
		public $adresse;
		public $code_postal;
		public $ville;
		public $telephone;
		public $email;
		public $domaine;

		/** 
		 * Fonction qui va insérer ou mettre à jour un client suivant les données saisies par l'utilisateur
		 * @param  Array<>  		$donnees 				Données saisie par l'utilisateur
		 * @return String			$retour_requete     	Soit insertion, soit mise à jour, soit erreur
	     */
		public static function addUpdate(&$donnees){

			//on va déjà rechercher si l'email saisie existe en base 
			$requete = "SELECT * FROM ".self::getNomTable()." WHERE email='".$donnees['email']."' LIMIT 0,1";	
			$client = self::executeRequete($requete, 'select', 'object');

			$retour_requete = '';

			//si le client n'est pas tableau ou qu'aucune error sql n'a été trouvé, on poursuit le traitement
			if (!is_array($client) || (is_array($client) && !array_key_exists('erreur_sql',$client))){
				//si le client n'est pas trouvé, c'est que son adresse mail n'a pas encore été renseigné, on fait donc une insertion en base
				if ($client == null){
					$requete = "INSERT INTO ".self::getNomTable()." (id_client, civilite, nom, prenom, adresse, code_postal, ville, telephone, email, domaine)
 								VALUES ('', '".$donnees['civilite']."', '".formaterChainePourRequeteSql($donnees['nom'])."', '".formaterChainePourRequeteSql($donnees['prenom'])."', '".formaterChainePourRequeteSql($donnees['adresse'])."', '".formaterChainePourRequeteSql($donnees['code_postal'])."', '".formaterChainePourRequeteSql($donnees['ville'])."', '".formaterChainePourRequeteSql($donnees['telephone'])."', '".formaterChainePourRequeteSql($donnees['email'])."', '".formaterChainePourRequeteSql($donnees['domaine'])."')";
 					$type = 'insert';
				}else{
					$requete = "UPDATE ".self::getNomTable()." SET
								civilite = '".$donnees['civilite']."',
								nom = '".formaterChainePourRequeteSql($donnees['nom'])."',
								prenom = '".formaterChainePourRequeteSql($donnees['prenom'])."',
								adresse = '".formaterChainePourRequeteSql($donnees['adresse'])."',
								code_postal = '".formaterChainePourRequeteSql($donnees['code_postal'])."',
								ville = '".formaterChainePourRequeteSql($donnees['ville'])."',
								telephone = '".formaterChainePourRequeteSql($donnees['telephone'])."',
								email = '".formaterChainePourRequeteSql($donnees['email'])."',
								domaine = '".formaterChainePourRequeteSql($donnees['domaine'])."'
								WHERE id_client=".$client->id_client;
					$type = 'update';
				}

				//on execute la requête adhequate
				$resultats = self::executeRequete($requete, $type);

				//si une erreur sql est survenue, on l'ajoute à la liste des erreurs
				if (!is_array($resultats) || (is_array($resultats) && !array_key_exists('erreur_sql',$resultats))){
					$retour_requete = $type;
				}else{
					$retour_requete = $resultats['erreur_sql'];
				}
			}else{
				$retour_requete = $client['erreur_sql'];
			}

			return $retour_requete;
		}

		/** 
		 * Fonction qui retourne une liste de client ou un client unique
		 * @param  Int 		$id_client			(Optionnel)  Identifiant d'une client
	     * @param  String   $ordre 				(Optionnel)  Champs sur lequel on doit ordonner la liste
	     * @param  Stirng   $sens    			(Optionnel)  Sens de tri de la liste
	     * @param  Int      $page               (Optionnel)  Numéro de la page en cours
	     * @param  String   $champs 			(Optionnel)  Nom du champs pour la recherche de client
	     * @param  String   $valeur             (Optionnel)  Valeur du champs pour la recherche de client
	     * @return Array<Client>				Liste des clients trouvés
	     */
		public static function getListingClient($id_client = null, $ordre = null, $sens = null, $page = null, $champs = null, $valeur = null){

			//Création de la requête
			$requete = "SELECT * FROM ".self::getNomTable();
			
			//Condition de la requete
			$where = '';

			//si on veut un client en particulier
			if ($id_client != null){
				$where .= " WHERE id_client = '".$id_client."'";
			}elseif ($champs != null){
				//Pour la recherche de client
				$where .= " WHERE ".$champs." = '".formaterChainePourRequeteSql($valeur)."'";
			}

			$requete .= $where;

			//on ordonne la liste suivant la demande de l'utilisateur
			if ($ordre != null){
				$requete .= " ORDER BY ".$ordre;
				if ($sens != null){
					$requete .= " ".$sens;
				}
			}

			//on ne retourne que le nombre de ligne suivant la pagination
			if ($id_client != null || $page != null){
				if($id_client != null){
					$offset = 0;
					$limit = 1;
				}else{
					$offset = ($page - 1) * NB_ELEMENT_PAR_PAGE;
					$limit = NB_ELEMENT_PAR_PAGE;
				}

				$requete .= " LIMIT ".$offset.",".$limit;
			}
			
			//echo $requete; exit();
			return self::executeRequete($requete, 'select');
		}

		/** 
		 * Fonction qui va supprimer un client de la BDD
		 */
		public static function delete($id_client){
			$requete = "DELETE FROM ".self::getNomTable()." WHERE id_client=".$id_client;
			self::executeRequete($requete, 'delete');
		}
	}



?>