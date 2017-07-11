<?php
    
    /**
     * Classe abstraite qui va permettre de gérer les fonctions communes aux modèles (constructeur, execution de requête, etc...)
     * @autor: Brion Sébastien
     */

    abstract class Modele{

    	/**
    	 * Fonction qui construit l'objet d'une class en fonction de ces attributs
    	 */
        public function __construct(){
        	//on récupère les propriétés de la class appelée            
            $proprietes  = get_object_vars($this);
            //on construit l'objet en fonction de ces attributs
            foreach($proprietes as $propriete => $value){
                $this->$propriete = $value;
            }
        }


        /***************** METHODES RELATIVES A LA CREATION ET EXECUTION D'UNE REQUETE ******************/


        /** 
         * Fonction qui retourne le nom de la table de la BDD en fonction de la classe appelée
         */
        public static function getNomTable($classe = null){
            //on récupère le nom de la class courante si elle n'est pas envoyée en argument
            return ($classe == null) ? convertirChaine(get_called_class()) : $classe;
        }

        /**
         * Fonction qui va executer une requete sur la base de donnée
         * @param  String   $requete                 Requête à exécuter
         * @param  String   $type_retour             Type de retour de la requête (tableau d'objet ou objet)
         * @param  String   $type_requete            Type de requête à générer et exécuter SELECT, UPDATE, INSERT OU DELETE
         * @return Multi    $resultats               Résultats de la requête SQL (tableau d'objet, objet, int, etc...)
         */
        public static function executeRequete($requete, $type_requete, $type_retour = null){

            $resultats = array();
            //on récupère le nom de la class appelée
            $class_fille = get_called_class();
            //on créer une nouvelle instance de la class
            $class = new $class_fille();

            try{
                //connexion à la base de données
                if ($connexion = connexionBdd()){
                    $connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    $connexion->setAttribute(PDO::FETCH_COLUMN, 1);
                    $requete_preparee = $connexion->prepare($requete);
                    $requete_preparee->execute();

                    if ($type_requete == 'select' || $type_requete == 'insert'){
                        if ($type_requete == 'select'){             
                            //suivant le retour de la requête demandé, on va retourner un tableau d'objet ou un objet
                            if ($type_retour == null || $type_retour == 'array'){
                                $resultats = $requete_preparee->fetchAll(PDO::FETCH_OBJ);                    
                            }else{
                                $resultats = $requete_preparee->fetch(PDO::FETCH_OBJ);
                            }
                        }
                        //si on a fait une insertion en base, on retourne automatiquement l'identifiant créé et on l'assigne à l'objet
                        if ($type_requete == 'insert'){                    
                            $resultats[0] = $connexion->lastInsertId();                         
                        }

                        //Traitement des resultats uniquement si on a un tableau, un objet ou un entier
                        if (is_array($resultats) || is_object($resultats) || is_int($resultats)){           
                            $resultats = self::traitementApresExecution($resultats, $class);
                        }
                    }
                    //on ferme la connexion à la base de données
                    unset($connexion);
                }else{
                    $resultats['erreur_sql'] = 'Problème de connexion avec la base de données.<br/>'; 
                }  
            }catch(PDOException $e){
               $resultats['erreur_sql'] = 'Une erreur sur l\'execution de la requête SQL a été trouvée.<br/>';          
            }            
            return $resultats;
        }

        /**
         * Fonction qui va traiter les résultats obtenus après la requête SQL
         * @param   Multi   $resultats               Résultats de la requête SQL (tableau d'objet, objet, int, etc...)
         * @param   Object  $class                   Class en cours         
         * @return  Multi   $resultats               Nouveau résultats traités
         */
        public static function traitementApresExecution($resultats, $class){

            //si c'est un tableau d'objet qui a été retourné par PDO
            if (is_array($resultats)){
                $objects = array();
                //on parcourt le tableau d'objet
                foreach($resultats as $key_resultat => $resultat){
                    if (is_object($resultat)){
                        $proprietes = get_object_vars($resultat);
                        //on clone l'objet correspondant à la class en cours
                        $object = clone($class);
                        //Pour chaque attribut de l'objet de la class en cours, on va attribuer la valeur du résultat de PDO
                        foreach($proprietes as $key=>$value){                 
                            $object->{$key} = formaterChainePourRequeteSql($resultat->{$key}, true);                      
                        }
                        //on remplie le nouveau tableau d'objet
                        $objects[$key_resultat] = $object;  
                    }          
                }
                if (count($objects) > 0){
                    $resultats = $objects;
                }                        
            }elseif(is_object($resultats)){     
                $proprietes = get_object_vars($resultats);
                //si PDO a retourné un objet, pour chaque attribut de l'objet de la class en cours, on va attribuer la valeur du résultat de PDO
                foreach($proprietes as $key=>$value){                    
                    $class->{$key} = formaterChainePourRequeteSql($resultats->{$key}, true);              
                }       
                $resultats = $class;
            }
            return $resultats;
        }

        public static function count(){
            $requete = "SELECT COUNT(id_client) as nb_element FROM ".self::getNomTable();
            $resultat = self::executeRequete($requete, 'select', 'object');
            return $resultat->nb_element;

        }

        /**************************************** METHODE RELATIVE A JSON **************************************/

        /**
         * Converti l'objet $this en tableau pour encodage en json
         *
         * @param Boolean optionnel $ajax Si true alors on encode les chaines de caractères en UTF8 afin que l'encodage en JSON puisse se faire
         * @return Array Tableau modelisant l'objet
         */
        public function jsonSerialize($ajax=false){
            $array =  get_object_vars($this);
            foreach($array as $index => $value){    
                if($ajax){
                    if(is_string($value)){
                        $array[$index] = supprimeRetourChariotEtTabulation($value);
                    }else{
                        if(is_array($value)){
                            foreach($array[$index] as $index2 => $value2){
                                $array[$index][$index2] = supprimeRetourChariotEtTabulation($value2);
                            }
                        }
                    }
                }            
                if(is_array($value)){
                    $keys = array_keys($value);
                    if(is_object($value[$keys[0]])){
                        $array[$index] = self::jsonSerializeArrayObject($value, $ajax);
                    }                
                }elseif(is_object($value)){
                    $array[$index] = $value->jsonSerialize($ajax);
                }            
            }
          
            return $array;
        }
        
        /**
         * Converti un tableau d'objets en tableau de tableaux pour encodage json
         * @param Array[Objet] $array tableau d'objets
         * @return Array[Array] $array tableau de tableaux
         */
        public static function jsonSerializeArrayObject($array,$ajax=false){
            if(is_array($array)){
                foreach($array as $index => $value){
                    if(is_object($value)){
                        $array[$index] = $value->jsonSerialize($ajax);
                    }elseif(is_array($value)){
                        $array[$index] = self::jsonSerializeArrayObject($value, $ajax);
                    }
                }                
            }
            return $array;
        }
    }
?>


