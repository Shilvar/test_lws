$(function(){

    /** 
     * Action qui va lancer l'autocompletion lorsque l'utilisateur saisie un code postal ou une ville
     */
    $('input[name="code_postal"], input[name="ville"]').autocomplete({
        source: function(request, response){  
            //on va récupérer la liste des villes en fonction de la recherche de l'utilisateur 
            var list_ville_trouvee = [];
            var data = {recherche : $(this.element).val(),
                        champs : $(this.element).attr('id')}

            appelAjax('clients', 'rechercherVille', data, function(var_retour){
                var list_ville = var_retour.list_ville;
                //on parcourt toute la listes des villes trouvées pour les intégrer au tableau de retour
                for(var i=0; i < (list_ville.length); ++i){
                    list_ville_trouvee.push(list_ville[i].code_postal+' '+list_ville[i].ville);
                };
            });            
            //on affecte la liste des villes trouvées à la source
            response(list_ville_trouvee);
        },        
        select: function(event, ui){
            /*On va séparer en deux la sélection :
                - d'un coté le code postal qui va allez dans le champs code_postal
                - le reste correspondant à la ville qui va allez dans le champs ville
            */
            var value = ui.item.value;
            var element_value = value.split(' ');
            //le code postal est toujours le premier élément du tableau
            var code_postal = element_value[0];
            var ville = '';
            //on reforme la ville avec le reste des éléments
            for(var i = 1; i < element_value.length; ++i){
                if (i > 1){
                    ville += ' ';
                }
                ville += element_value[i];
            }
            //on affecte la valeur du champs où le focus se situe à l'objet ui.item afin de ne pas écraser la véritable valeur
            ui.item.value = ($('input[name="code_postal"]').is(":focus")) ? code_postal : ville;
            //on affecte les bonnes valeurs aux champs
            $('input[name="code_postal"]').val(code_postal);
            $('input[name="ville"]').val(ville);
        },
        minLength: 3,
        delay: 600
    });

    /** 
     * Action qui va écrire le contenu du champ "domaine" avec les icones de l'alphabet
     */
    $('input[name="domaine"]').keyup(function(e){
        
        var chaine = retirerAccent($(this).val());
        var longueur_chaine = chaine.length;
        var code_html = '';

        //On parcourt toutes les lettres de la chaine pour trouver l'icone correspondante
        for(var i=0; i < longueur_chaine; i++){
            var lettre = chaine[i];
            //si la lettre est un espace, on la remplace par blank car c'est le nom de l'icone pour l'espace
            if(lettre == ' '){
                lettre = "blank";
            }
            code_html += '<img src="./public/images/alphabet/'+lettre+'.png" alt="" title="" />';
        }        
        
        //on met à jour le contenu
        $('#icone_domaine').html(code_html);
    });

    /**
     * Action qui va tester le formulaire et le soumettre si tout ce passe bien
     */
    $(document).on('click', '#soumettre_formulaire', function(){        
        var data = {};
        var formulaire = $(this).parents('form:first');

        //on retire les textes d'erreur et les champs en rouge
        $('#infos_retour_formulaire').removeClass('alert-danger alert-success').parents('div:first').addClass('dn');   
        formulaire.find('input, select, textarea').each(function(){
            gestionChamps($(this));
        });

    
        //si le formulaire est valide, on va envoyer les données via l'ajax
        if (validerFormulaire(formulaire)){
            //on récupère les données du formulaire
            data.civilite = $('select[name="civilite"]').val();
            data.nom = $('input[name="nom"]').val();
            data.prenom = $('input[name="prenom"]').val();
            data.adresse = $('textarea[name="adresse"]').val();
            data.code_postal = $('input[name="code_postal"]').val();
            data.ville = $('input[name="ville"]').val();
            data.telephone = $('input[name="telephone"]').val();
            data.email = $('input[name="email"]').val();
            data.domaine = $('input[name="domaine"]').val();

            if (!testVariable($('input[name="id_client"]'), 'valeur_null')){
                data.id_client = $('input[name="id_client"]').val();
            }

            appelAjax('clients', 'addUpdate', data, function(var_retour){

                //si on a eu une erreur de saisie de la part de l'utilisateur, on indique les erreurs aux champs
                if (Object.keys(var_retour.list_erreur_saisie).length > 0){
                    $('html,body').animate({scrollTop: $("#bloc_formulaire").offset().top}, 'slow');
                    //On parcourt tous les champs pour savoir si un champ est erroné
                    formulaire.find('input, select, textarea').each(function(){
                        var name_champs = $(this).attr('name');
                        if (!testVariable(var_retour.list_erreur_saisie[name_champs], 'null')){
                            gestionChamps($(this), 'error', var_retour.list_erreur_saisie[name_champs]);
                        }else{
                            gestionChamps($(this), 'success');
                        }
                    });
                }else if(var_retour.erreur_system != ''){
                    //si on a eu une erreur system (SQL, envoi de mail, etc...)
                    $('html,body').animate({scrollTop: $("#bloc_formulaire").offset().top}, 'slow');
                    $('#infos_retour_formulaire').html(var_retour.erreur_system);
                    $('#infos_retour_formulaire').addClass('alert-danger').parents('div:first').removeClass('dn');
                }else{
                    //si tout s'est bien passé, on indique en haut du formulaire et on vide les champs 
                    $('html, body').animate({scrollTop:0}, 'slow');
                    $('#infos_retour_formulaire').html('Le compte client a bien été enregistré.<br/>L\'e-mail a bien été envoyé au destinataire.');
                    $('#infos_retour_formulaire').addClass('alert-success').parents('div:first').removeClass('dn');

                    //on vide tous les champs du formulaire et on retire les effets visuels (validation ou problème)
                    formulaire.find('input, select, textarea').each(function(){
                        gestionChamps($(this));
                        $(this).val('');
                    });

                    //on ré-initialise le texte par défaut du bouton et du h2
                    $('#soumettre_formulaire').html('Créer le compte');
                    $('#bloc_formulaire h2').html("Formulaire de création d'un client");
                  
                    //si on a envoyer un tweet, on affiche la modal
                    if (!testVariable(var_retour.contenu_modal, 'null')){
                        $('.modal-content').html(var_retour.contenu_modal);
                        $("#infos").modal('show');
                    }
                }                       
            });
        }

        //on retourne false pour ne pas soumettre le formulaire de facon naturel
        return false;
    });

});
