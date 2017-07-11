
/* ########################## GESTION REQUETES AJAX ##########################*/

/**
 * Fonction qui va exécuter une requête AJAX suivant les paramètres passés
 * @param   String      nom_controleur     Nom du contrôleur à appeler
 * @param   String      nom_methode        Nom de la méthode à appeler dans le controleur
 * @param   Object      data               (optionnel) Liste des données à envoyer en POST pour le traitement
 * @param   Function    fonction_retour    (Optionnel) Fonction de retour à traiter une fois le retour ajax fait
 * @param   Booleann    async              (Optionnel) Définit si on veut être asymchrone ou synchrone          
 */
function appelAjax(nom_controleur, nom_methode, data, fonction_retour, async){
   
    //On créé l'url qui cible la fonction du controleur à appeler
    var url = nom_controleur+'.php';
    //si on a passé un nom de methode, on l'ajoute en paramètre GET à l'url
    if (!testVariable(nom_methode, 'null')){
        url += '?methode='+nom_methode;
    }
    //on ajoute le paramètre ajax aux données passées
    var data = (testVariable(data, 'null')) ? {} : data;
    data.ajax = 1;
 
    //On définit les paramètres de la méthode AJax
    var parametres_ajax = {type: 'POST',
                           url: url,
                           data : data,
                           async : ((testVariable(async, 'null')) ? false : async)};
    
    //Execution de la requête ajax
    $.ajax(parametres_ajax).done(function(var_retour){
          //si on a spécifier une fonction à executer au retour de l'ajax
        if(!testVariable(fonction_retour, 'null')){
            //si le type de la variable retourné n'est pas un objet
            if(!testVariable(var_retour, 'object')){
                var_retour = JSON.parse(var_retour);
                //On appelle la fonction passée en paramètre
                fonction_retour(var_retour);
            }else{
                //on affiche le retour de la fonction afin de voir le problème survenu
                alert(var_retour);
            }
        }
    }).fail(function(){
        alert('échouée')
    });
}

/**
 * Fonction qui va tester une variable ou sa valeur
 * @param  Var          $var       Variable à tester
 * @return Boolean 
 */
function testVariable(variable, test){
    var resultat_test;

    switch(test){
        //Test l'existance de la variable
        case 'null':
            resultat_test = (typeof(variable) === 'undefined' || variable == null);
        break;
        //Test si la variable est un objet
        case 'object':
            resultat_test = (typeof(variable) === 'object');
        break;
        //Test si la valeur de la variable est null
        case 'valeur_null':
            resultat_test = (variable.val() == '' || variable.val() == null);
        break;
        //Test si la valeur de la variable est numérique
        case 'valeur_numerique':
            resultat_test = isNaN(variable.val());
        break;
    }

    return resultat_test;
}


/* ########################## GESTION FORMULAIRE ##########################*/

/**
 * Fonction qui va valider un formulaire
 * @param  Element  formulaire   Formulaire à tester
 * @return Boolean               Retourne true ou false si le formulaire est valide ou non
 */
function validerFormulaire(formulaire){
    
    //On initialise la validation du formulaire à true
    var formulaire_valide = true;
    var texte_erreur = '';

    //On parcourt tous les champs pour savoir si un champ doit être testé ou non
    formulaire.find('input, select, textarea').each(function(){
        var texte_erreur = '';

        //si le champs est requis
        if (!testVariable($(this).attr('requis'), 'null')){
            //On teste si l'utilisateur a renseigné le champs
            if(testVariable($(this), 'valeur_null')){                  
                texte_erreur += "Ce champs est requis.<br/>";
            }
        }

        //si on doit tester une adresse mail
        if (!testVariable($(this).attr('email'), 'null')){
            var pattern = /^([a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+(\.[a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+)*|"((([ \t]*\r\n)?[ \t]+)?([\x01-\x08\x0b\x0c\x0e-\x1f\x7f\x21\x23-\x5b\x5d-\x7e\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|\\[\x01-\x09\x0b\x0c\x0d-\x7f\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))*(([ \t]*\r\n)?[ \t]+)?")@(([a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.)+([a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.?$/i;
            if (!pattern.test($(this).val())){
                texte_erreur += "L'adresse mail entrée n'est pas valide.<br/>";
            }
        }

        //si on doit tester une adresse mail
        if (!testVariable($(this).attr('numerique'), 'null')){
            //On teste si l'utilisateur a renseigné le champs
            if(testVariable($(this), 'valeur_numerique')){                  
                texte_erreur += "Ce champs doit être un nombre.<br/>";
            }
        }

        //si une erreur est survenue, on met le champs en rouge et on lui met le focus
        if (texte_erreur != ''){
            gestionChamps($(this), 'error', texte_erreur);
            formulaire_valide = false;
        }else{
            gestionChamps($(this), 'success');
        }
    });

    return formulaire_valide;
}

/** 
 * Fonction qui va agir sur le status d'un champs du formulaire
 * @param  Element   champs         Champs sur lequel on veut agir
 * @param  String    type           Type de status à affecter : error, success, ou neutre
 * @param  String    text_erreur    Texte d'erreur à afficher en dessous du champs dans le cas error
 */
function gestionChamps(champs, type, texte_erreur){

    switch(type){

        case 'error':
            champs.parents('div.form-group:first').addClass('has-error');
            if (champs.next().hasClass('form-control-feedback')){
                champs.next().addClass('glyphicon-remove');
            }
            champs.nextAll('span.help-block').html(texte_erreur);
        break;

        case 'success':
            champs.parents('div.form-group:first').addClass('has-success');
            if (champs.next().hasClass('form-control-feedback')){
                champs.next().addClass('glyphicon-ok');
            }
        break;

        default:
            champs.parents('div.form-group:first').removeClass('has-error has-success');
            if (champs.next().hasClass('form-control-feedback')){
                    champs.next().removeClass('glyphicon-remove glyphicon-ok');
                }
            champs.nextAll('span.help-block:first').text('');
        break;
    }
}

/**
 * Fonction qui va remplacer tous les caractères accentués d'une chaine par son caractère non-accentué
 * @param  String  chaine    Chaine avec caractères accentués
 * @return String  chaine    Chaine avec caractères non-accentués
 */
function retirerAccent(chaine){
    var accents = ["À","Á","Â","Ã","Ä","Å","Æ","Ç","È","É","Ê","Ë",
        "Ì","Í","Î","Ï","Ð","Ñ","Ò","Ó","Ô","Õ","Ö","Ø","Ù","Ú","Û","Ü","Ý",
        "Þ","ß","à","á","â","ã","ä","å","æ","ç","è","é","ê","ë","ì","í","î",
        "ï","ð","ñ","ò","ó","ô","õ","ö","ø","ù","ú","û","ü","ý","ý","þ","ÿ"],
        remplaces = ["A","A","A","A","A","A","A","C","E","E","E","E",
        "I","I","I","I","D","N","O","O","O","O","O","O","U","U","U","U","Y",
        "b","s","a","a","a","a","a","a","a","c","e","e","e","e","i","i","i",
        "i","d","n","o","o","o","o","o","o","u","u","u","u","y","y","b","y"];

    var reg_exp = new RegExp(accents.join('|'), 'g');

    return chaine.replace(reg_exp, function(c) {
        return remplaces[accents.indexOf(c)];
    });
}
