<?php
	
	/**
	 * Liste des fonctions relatives à la gestion des fichiers et des dossiers
	 * @autor: Brion Sébastien
	 */

	/**
	 *	Fonction qui retourne tous les noms de fichiers et dossier d'un dossier
	 *  @param  String      $path 	         Chemin du dossier où l'on veut récupérer les fichiers
	 *  @param  Boolean     $inclide_path    (Optionnel) Définit si on veut que le fichier ait un chemin absolu
	 *  @param  Array       $list_extension  (Optionnel) Liste des extensions que l'on veut ressortir du tableau
	 *	@return Array<String>	             Liste des fichiers et dossiers trouvés
	 */
	function list_nom_fichier($path, $include_path = false, &$list_extension = array(), &$list_path_exclu = array()){
		$list_nom_fichier = array();
		//si on a trouver le dossier, on récupère les fichiers
		if(is_dir($path) && !in_array($list_path_exclu) && $list_nom_fichier = scandir($path)){		
	    	//on ne prend pas en compte les noms de fichier . et ..
			$list_nom_fichier = array_diff($list_nom_fichier, array('..', '.'));
	        //on filtre avec la liste des extensions et les path exclus
	        if (count($list_extension) > 0 || count($list_path_exclu) > 0){
	            foreach($list_nom_fichier as $k_fichier => $nom_fichier){
	                if (is_file($path.'/'.$nom_fichier)){
	                    list($nom, $extension) = explode('.', $nom_fichier);
	                    //si le fichier n'a pas l'extension contenu dans la liste des extensions fournis
	                    //ou si le path du fichier est contenu dans la liste des path à exclure    
	                    //on supprime le fichier de la list à retourner 
	                    if ((count($list_extension) > 0 && !in_array($extension, $list_extension)) || in_array($path.$nom_fichier, $list_path_exclu)){
	                        unset($list_nom_fichier[$k_fichier]);
	                    }
	                }else{
	                    unset($list_nom_fichier[$k_fichier]);
	                }
	            }	            
	        }
			//on remet une bonne clé au element du tableau
			$list_nom_fichier = array_values($list_nom_fichier);      
			//si on veut retourner le chemin complet du fichier
			if($include_path){
				foreach($list_nom_fichier as $key => $nom_fichier){
					$list_nom_fichier[$key] = $path.'/'.$nom_fichier;
				}
			}
		}	   
		return $list_nom_fichier;
	}

	/**
	 * Fonction qui inclut tous les fichiers d'un dossier suivant le chemin passé (fonction recursive)
	 * @param   $path 	Chemin du dossier auquel on veut inclure les fichiers
	 */
	function include_list_fichier($path, &$list_path_exclu){
		$list_extension = array();		
		$list_fichier = list_nom_fichier($path, false, $list_extension, $list_path_exclu);
		//si on a trouvé au moins un fichier, on continue l'inclusion
		if (is_array($list_fichier)){
			foreach($list_fichier as $fichier){
				//si le chemin est un dossier, on relance la fonction afin qu'elle soit récursive
				if (is_dir($path.$fichier)){
					$path .= $fichier.'/';
					include_list_fichier($path, $list_path_exclu);
				}else{					
					include($path.$fichier);
				}			
			}
		}
	}

?>