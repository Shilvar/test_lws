<?php

	/**
	 * Liste des fonctions relatives à la gestion des chaines de caractères
	 * @autor: Brion Sébastien
	 */
	
	/**
	 * Fonction qui transforme une chaine convertirChaine en convertir_chaine
	 * @param  	String      $chaine	    Chaîne à convertir
	 * @return 	String 		$chaine     Chaîne convertie
	 */
	function convertirChaine($chaine){
	    $chaine_convertie = "";
	    //on parcourt toutes les lettres de la chaine
	    $longueur_chaine = strlen($chaine);
	    for($i=0; $i < $longueur_chaine; $i++){
	    	//si la lettre n'est pas la première de la chaîne et que c'est une majuscule, on ajoute un underscore
	        if($i > 0 && testSiMajuscule($chaine[$i])){
	            $chaine_convertie .= "_";
	        }
	        //On met toutes les lettres de la chaîne en minuscule
	        $chaine_convertie .= strtolower($chaine[$i]);
	    }
	    return $chaine_convertie;
	}

	/**
	 * Fonction qui transforme une chaine convertir_chaine_inverse en convertirChaineInverse
	 * @param   String      $chaine     Chaîne à convertir
	 * @return  String      $chaine     Chaîne convertie
	 */
	function convertirChaineInverse($chaine){
	    $list_partie_chaine = explode("_",strtolower($chaine));
	    $chaine = "";
	    foreach($list_partie_chaine as $key => $partie_chaine){
	        $chaine .= ($key > 0) ? ucfirst($partie_chaine) : $partie_chaine;
	    }
	    return $chaine;
	}

	/**
	 * Fonction qui retourne vrai si le caractère passé est une majucule
	 * @param  Char       $caractere      Lettre à comparer avec les majuscules
	 * @return Boolean                    True si majuscule
	 */
	function testSiMajuscule($caractere){
	    return preg_match("#[A-Z]#", $caractere);
	}

	/**
	 * Fonction qui enlève les doubles slashes dans les attributs src et href
	 * @param 	String 	$code_html 	Code html à formater
	 * @return 	String 	$code_html 	Code html formaté
	 */
	function gestionDoubleSlashLiensCodeHtml($code_html){
	    //on recherche tous les liens dans le code source
	    if(preg_match_all('#(src|href)=(["\'])(http?://)?(.[^\'"]*)([\'"])#', $code_html, $list_lien)){
	        foreach($list_lien[0] as $lien){
	            $list_recherche = array ('//', 'http:/');
	            $list_remplace = array ('/', 'http://');
	            //on supprime déjà tous les doubles slashes dans le code source et on gère ensuite le cas particulé des liens
	            $new_lien = str_replace($list_recherche, $list_remplace, $lien);
	            //On met à jour le lien dans le code html
	            $code_html = str_replace ($lien, $new_lien, $code_html);           
	        }
	    }
	    return $code_html;
	}

	/**
	 * Fonction qui va correctement formater une chaine pour l'insertion en BDD ou la transformer pour un affichage correcte
	 * @param  String   $chaine  Chaine à formater
	 * @param  Boolean  $inverse (Optionnel) Définit si on récupérer la chaîne d'origine 
	 * @return String   $chaine  Chaine formatée
	 */
	function formaterChainePourRequeteSql($chaine, $inverse = false){
	    $list_recherche = array("'", '"');
	    $list_remplace = array("&#39;", "&#34;");

	    $chaine = (!$inverse) ? str_replace($list_recherche, $list_remplace, $chaine) : str_replace($list_remplace, $list_recherche, $chaine);
	    return $chaine;
	}

	/**
	 * Fonction qui va supprimer les retours chariots et les tabulations d'une chaine
	 * @param   String      $chaine        Chaine à traiter
	 * @return  String      $chaine        Chaine traitée
	 */
	function supprimeRetourChariotEtTabulation($chaine){   
	    if(is_string($chaine)){
	        $list_recherche = array("\t", "\n", "\r");
	        $chaine  = str_replace($list_recherche,'', $chaine);
	    }
	    return $chaine;
	}

	/**
	 * Fonction qui va tester les champs d'un formulaire
	 * @param  Array<>  		$donnees 				Données saisie par l'utilisateur
	 * @param  Array<>          $list_test      		Tableau des tests à réaliser sur les champs
	 * @return Array<>          $list_erreur_saisie		Tableau des erreurs saisies avec comme clé, la clé du tableau $_POST
	 */
	function testChampsFormulaire(&$donnees, &$list_test){

		$list_erreur_saisie = array();

    	//On va tester les champs transmis
    	foreach($donnees as $key=>$value){
    		//On parcourt la liste des tests à effectuer
    		foreach($list_test as $key_test => $test){
    			//si on doit tester le champs
    			if (in_array($key, $test)){
    				//on teste le champs suivant le mode de test
	    			switch ($key_test){
	    				case 'requis':
	    					if (empty(str_replace(CHR(32),"",$value))){
	    						$list_erreur_saisie[$key] .= 'Ce champs est requis.<br/>';
	    					}	
	    				break;
	    				case 'numerique':
	    					if (!is_numeric($value)){
	    						$list_erreur_saisie[$key] .= 'Ce champs doit être un nombre.<br/>';
	    					}
	    				break;
	    				case 'email': 
	    					if (!filter_var($value, FILTER_VALIDATE_EMAIL)){
	    						$list_erreur_saisie[$key] .= "L'adresse mail entrée n'est pas valide.<br/>";
	    					}
	    				break;
	    			}
	    		}
    		}
    	}
    	return $list_erreur_saisie;
	}

	/**
	 * Fonction qui va tronquer une chaine trop longue
	 * @param   String  $chaine   				Chaine à tester et à tronquer si besoin
	 * @param   Int     $longueur_max_chaine 	Longueur maximal de la chaine
	 * @return  String  $chaine  				Chaine d'origine ou tronquée
	 */
	function tronquerChaine($chaine, $longueur_max_chaine){
		//Si la chaîne est plus longue que la longueur maximal passée, on la tronque
		if(strlen($chaine) > $longueur_max_chaine) {
		    $chaine = substr($chaine,0,($longueur_max_chaine - 3));
		    if (strrpos($chaine," ")) {
		    	$chaine = substr($chaine,0,strrpos($chaine," "));
		    }
		    $chaine = $chaine."...";
		}

		return $chaine;
	}

?>
