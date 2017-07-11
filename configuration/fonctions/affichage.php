<?php

	/**
	 * Liste des fonctions relatives à l'affichage des pages
	 * @autor: Brion Sébastien
	 */

	/**
	 * Fonction qui va générer un template Smarty correspondant à la page en cours et suivant certains paramètres puis l'afficher dans le navigateur
	 * @param  String   $nom_controleur   (Optionnel) Nom du controleur appelé (correspondant à la page) sinon controleur par défaut
	 */
	function genererPage($nom_controleur = null){

		////////////// RECUPERATION DE LA PAGE COURANTE ET DE LA FONCTION APPELLEE /////////////

	    //On récupère la page en fonction du nom du controleur
	    if ($nom_controleur == null){
	        $nom_controleur = CONTROLEUR_DEFAULT;
	    }
    
	    $methode = (isset($_REQUEST['methode'])) ? $_REQUEST['methode'] : METHODE_DEFAULT;
	    //on recupère le nom de la class pour pouvoir l'inclure
		$class = ucfirst(convertirChaineInverse($nom_controleur));
		
		//si on peut inclure le controleur, on continue
		if (include(PATH_CONTROLEURS.$class.'.class.php')){	

			//on recupère le nom de la class pour pouvoir l'inclure
		    $class = ucfirst(convertirChaineInverse($nom_controleur));
		    
		    //on instancie le controleur de la page     
		    $controleur = new $class();

		    //si la méthode existe dans la classe appelée, on continue
		    if (method_exists($controleur, $methode)){			  

			    //si l'appel de la methode vient de l'ajax, on ne charge pas toutes la page
			    if (isset($_REQUEST['ajax'])){
			    
		            //on appelle la fonction du controleur, afin de récupérer le retour ajax
		            $donnees_ajax = $controleur->$methode();
		            if (!is_array($donnees_ajax)){
		                $donnees_ajax = array();
		            }
		            //on ajoute les données passées en POST avec celle du traitement pour garder les données
		            $donnees_ajax = array_merge($_REQUEST, $donnees_ajax);
		            //on formate les données passées pour ne pas avoir de problème d'encodage par exemple
		            $donnees_ajax = formatDonneesAjax($donnees_ajax);
		            //on encode le tableau en json pour le traiter dans le js
		            echo json_encode($donnees_ajax);
		            //on arrête l'execution php
		            exit();        
			    }else{            
			      	//Contenu de la page               
		            $list_assign_contenu = $controleur->$methode();
		            chargerPageComplete($nom_controleur, $methode, $list_assign_contenu); 
			    }
			}else{
				chargerPageComplete('_generique', 'page_erreur');
			}
		}else{
			chargerPageComplete('_generique', 'page_erreur');
		}
	}

	function chargerPageComplete($nom_controleur, $methode, $list_assign_contenu = array()){

		//Création de la page html                
		$code_html = '';
		$list_assign_global = array('nom_contoleur' => $nom_contoleur,
		                            'methode' => $methode);
		//Header
	    $header = new Header();     
	    $list_assign = $header->index($nom_controleur);             
	    $code_html .= chargerPartiePage('header', 'index', $list_assign, $list_assign_global);

	    //Contenu de la page               
	    $code_html .= chargerPartiePage($nom_controleur, $methode, $list_assign_contenu, $list_assign_global);
	    
	    //Footer
	    $footer = new Footer();     
	    $list_assign = $footer->index();      
	    $code_html .= chargerPartiePage('footer', 'index', $list_assign, $list_assign_global);

	    echo $code_html;
	}
		


	/**
	 * Fonction qui charge une partie de la page (header, contenu ou footer)
	 * @param  String   $nom_dossier        Nom du dossier à utiliser dans le dossier VUES pour créer le chemin du fichier du template
	 * @param  String   $nom_fichier        Nom du fichier correspondant au fichier du template
	 * @param  Array    $list_assign        Liste d'assign spécifique à passer au template Smarty
	 * @param  Array    $list_assignglobal  Liste d'assign à inclure dans toutes les parties de la page
	 * @return  Template<Smarty>            Template généré avec les données passées
	 */
	function chargerPartiePage($nom_dossier, $nom_fichier, &$list_assign = array(), &$list_assign_global){    
		if (!is_array($list_assign)){
		    $list_assign = array();
		}
		$list_assign = array_merge($list_assign, $list_assign_global);
		$path = PATH_VUES.$nom_dossier.'/'.convertirChaine($nom_fichier).'.tpl';
		return genererTemplateSmarty($path, $list_assign);
	}

	/**
 	 * Fonction qui créé et retourne un template de Smarty 
	 * @param 	String 	$path 		     (Optionnel) Chemin absolu du fichier à générer
	 * @param 	Array 	$assign 	     (Optionnel) Liste de données à envoyer au template
	 * @return 	String 	$code_html	     Contenu du template généré (correspond au code html)
	 */
	function genererTemplateSmarty($path = null, $list_assigns=array()){
		//on supprime les doubles slashes du path si existant pour avoir un chemin absolu propre
		$path = str_replace("//","/",$path);  

		//si le path est bien un fichier et qu'il existe
		if (file_exists($path) && is_file($path)){
		    list($template, $extension) = explode('.', basename($path));
		    //si l'extension du fichier est bien un .tpl, on peux générer le template Smarty
		    if ($extension == 'tpl'){
		        //Création du template Smarty
		        $smarty = new Smarty();
		        $smarty->force_compile = false;
		      
		        //On envoie  tout le tableau des données passé en paramètres si existant
		        if($list_assigns != null && is_array($list_assigns)){
		            foreach($list_assigns as $key => $value){
		                $smarty->assign($key, $value);
		            }
		        }
		       
		        //on recupère le code html généré par le template
		        $code_html = $smarty->fetch($path);
		        $code_html = gestionDoubleSlashLiensCodeHtml($code_html);
		    }else{
		        $code_html = 'Le fichier cible n\'est pas un .tpl';
		    }
		}else{
		    $code_html = 'Le chemin n\'existe pas ou n\'est pas un fichier';
		}

		return $code_html;
	}

 	/**
	 * Fonction qui formate les données à passer en ajax (fonction récursive)
	 * @param   Array    $donnees    Données à traiter
	 * @return  Array    $donnees    Données traitées
	 */
	function formatDonneesAjax($donnees){
		foreach($donnees as $key => $val){
		    $key_utf8 = utf8_encode($key);
		    if(is_array($val)){
		        $donnees[$key_utf8] = formatDonneesAjax($val);
		    }else{
		        $donnees[$key_utf8] = supprimeRetourChariotEtTabulation($val);
		    }
		    if($key_utf8 != $key){
		        unset($donnees[$key]);
		    }
		}
		return $donnees;
	}

?>