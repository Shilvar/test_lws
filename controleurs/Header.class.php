<?php 

/**
 * Controleur qui va gérer le header de la page
 * @autor: Brion Sébastien
 */

class Header{
	
	/** 
	 * Fonction qui affiche le template de la méthode par défaut, à savoir la page du formulaire et du listing
	 * @return Array   $assigns    Liste des données à envoyer au template Smarty 
	 */
	public function index($nom_controleur){

		//on assign la liste des fichiers css et js du module
		$assigns['list_path_fichier_css'] = list_nom_fichier(PATH_PUBLIC.'css/'.$nom_controleur, true);
		$assigns['list_path_fichier_js'] = list_nom_fichier(PATH_PUBLIC.'js/'.$nom_controleur, true);
		return $assigns;
	}
}

?>