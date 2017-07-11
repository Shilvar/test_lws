<?php 

/**
 * Controleur qui va gérer la page relative au client
 * @autor: Brion Sébastien
 */

class Clients{
	
    /******************************** AFFICHAGE ********************************/

	/** 
	 * Fonction qui affiche le template de la méthode par défaut, à savoir la page du formulaire et du listing
	 * @return Array   $assigns    Liste des données à envoyer au template Smarty 
	 */
	public function index(){
		//on envoie un objet client vide pour le formulaire.
		$assigns['client'] = new Client();
		return $assigns;
	}

	/**
     * Fonction qui retourne la liste de ville en fonction du code postal ou de la ville saisie
     * @return   Array   $donnees_ajax    Liste des données à envoyer à la fonction de retour ajax
     */
    public function rechercherVille(){
        $donnees_ajax['list_ville'] = Ville::rechercherVille($_POST);
        return $donnees_ajax;
    }

    /** 
     * Fonction qui va afficher le listing des clients suivant l'ordre, la page ou une condition
     * @param    String  $ordre           (Optionnel) Ordre de tri 
     * @param    String  $sens            (Optionnel) Sens de tri 
     * @param    String  $page            (Optionnel) Numéro de la page en cours
     * @return   Array   $donnees_ajax    Liste des données à envoyer à la fonction de retour ajax
     */
    public function afficherListing($ordre = null, $sens = null, $page = null){

        //Initialisation des variables
        $ordre = (isset($_POST['ordre'])) ? $_POST['ordre'] : (($ordre != null) ? $ordre : 'nom');
        $sens = (isset($_POST['sens'])) ? $_POST['sens'] : (($sens != null) ? $sens : 'ASC');
        $page = (isset($_POST['page'])) ? $_POST['page'] : (($page != null) ? $page : 1);

         //on récupère le nombre de page
        $nb_client = Client::count();
        $nb_page = (NB_ELEMENT_PAR_PAGE > 0) ? ceil($nb_client / NB_ELEMENT_PAR_PAGE) : 1;

        //si le numéro de page passé est supérieur au nombre total de page, on force le numéro de la page
        if ($page > $nb_page){
            $page = $nb_page;
        }

        //on recupère les clients
        $list_client = Client::getListingClient(null, $ordre, $sens, $page);
       
        //on enregistre le tableau de données utile pour la génération du template
        $list_assign = array('list_client' => $list_client,
                             'nb_page' => $nb_page,
                             'ordre' => $ordre,
                             'sens' => $sens,
                             'page' => $page);

        $donnees_ajax['template_listing'] = genererTemplateSmarty(PATH_VUES.'./clients/listing_client.tpl', $list_assign);
        
        return $donnees_ajax;
    }

    /**
     * Fonction qui permet d'afficher une modal suivant la cible demandée.
     * @return   Array   $donnees_ajax    Liste des données à envoyer à la fonction de retour ajax
     */
    public function afficherModal($cible_contenu = null, $list_assign = null){

        $cible_contenu = (isset($_POST['cible_contenu'])) ? $_POST['cible_contenu'] : $cible_contenu;
        $list_assign = ($list_assign != null) ? $list_assign : array();

        //on passe toutes les données envoyer en ajax au template        
        foreach($_POST as $key=>$value){
            $list_assign[$key] = $value;
        }

        switch($_POST['cible_contenu']){
            case 'recherche':
                $list_assign['list_client'] = Client::getListingClient(null, $ordre, $sens, null, $_POST['champs'], $_POST['valeur']);
                $list_assign['no_action'] = true;
            break;
        }

        //on récupère le template pour l'afficher dans la modal
        $donnees_ajax['contenu_modal'] = genererTemplateSmarty(PATH_VUES.'./clients/'.$cible_contenu.'.tpl', $list_assign);

        return $donnees_ajax;
    }

    /**
     * Fonction qui retourne les infos d'un client 
     * @return   Array   $donnees_ajax    Liste des données à envoyer à la fonction de retour ajax
     */
    public function getClient(){
        $list_client = Client::getListingClient($_POST['id_client']);
        $donnees_ajax['client'] = $list_client[0];
        return $donnees_ajax;
    }

    /******************************** TRAITEMENT ********************************/
    
    /**
     * Fonction qui va mettre à jour ou créé un client
     * @return   Array   $donnees_ajax    Liste des données à envoyer à la fonction de retour ajax
     */
    public function addUpdate(){
 
    	$list_test = array('requis' => array('civilite', 'nom', 'prenom', 'adresse', 'code_postal', 'ville', 'email'),
    					   'numerique' => array('code_postal'),
    					   'email' => array('email'));

    	//on teste dans un premier temps les champs saisis
    	$donnees_ajax['list_erreur_saisie'] = testChampsFormulaire($_POST, $list_test);
                
    	//si l'utilisateur a correctement rempli le formulaire
    	if (count($donnees_ajax['list_erreur_saisie']) == 0){
            //Insertion ou mise ç jour du compte client
    		$retour_requete = Client::addUpdate($_POST);
            
            //si le retour de la requete n'est ni une insertion, ni une mise à jour, c'est qu'une erreur est survenue
            if ($retour_requete != 'insert' && $retour_requete != 'update'){
                $donnees_ajax['erreur_system'] = $retour_requete;
            }else{
                $_POST['type_requete'] = $retour_requete;
                $donnees_ajax['erreur_system'] = smtpMailer($_POST);

                //si on est dans le cas d'une insertion en base, on envoie le tweet
                if ($retour_requete == 'insert'){                    
                    $message = 'Bienvenue à M.'.$_POST['nom'].' '.$_POST['prenom'].'!';
                    $list_assign['id_tweet'] = tweet($message);
                    $donnees_ajax = array_merge($donnees_ajax, $this->afficherModal('tweet', $list_assign));
                }
            }
    	}
        return $donnees_ajax;
    }

    /** 
     * Fonction qui va supprimer un client de la BDD
     * @return   Array   $donnees_ajax    Liste des données à envoyer à la fonction de retour ajax
     */   
    public function delete(){

        //On supprime le client
        Client::delete($_POST['id_client']);
        //on retourne le template permettant de rafraichir le listing client
        return $this->afficherListing($_POST['ordre'], $_POST['sens'], $_POST['page']);
    }  

}

?>