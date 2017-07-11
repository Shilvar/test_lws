$(function(){

	/** 
	 * Action qui va afficher le tableau contenant le listing des clients
	 */
	$(document).on('click', '#affiche_listing_client, .champs_ordre, ul.pagination li', function(){
		var data = {};
		
		//si on clique sur un champs du thead pour ordonner le listing
		if ($(this).hasClass('champs_ordre')){
			data.ordre = $(this).data('ordre');
			data.sens = $(this).data('sens');
			data.page = 1;
		}

		//si on clique sur une page de la pagination
		if ($(this).attr('data-page')){
			data.ordre = $(this).parents('ul:first').data('ordre');
			data.sens = $(this).parents('ul:first').data('sens');
			data.page = $(this).data('page');
		}

		afficherListing(data);
	});

	/** 
	 * Action qui va supprimer un client
	 */
	$(document).on('click', '#supprimer_client', function(){

		var data = {id_client : $(this).data('id_client'),
					ordre : $(this).prevAll('input[name="ordre"]').val(),
					page : $(this).prevAll('input[name="page"]').val(),
					sens : $(this).prevAll('input[name="sens"]').val()};

		appelAjax('clients', 'delete', data, function(var_retour){
			$('#listing_client').html(var_retour.template_listing);
			$("#infos").modal('hide');
		});
	});

	/**
	 * Action qui permet de modifier un client via le formulaire
	 */
	$(document).on('click', '.glyphicon-pencil', function(){
		var data = {id_client : $(this).parents('tr:first').data('id_client')}

		//on retire les textes d'erreur et les champs en rouge
        $('#infos_retour_formulaire').removeClass('alert-danger alert-success').parents('div:first').addClass('dn');   
        $('#form').find('input, select, textarea').each(function(){
            gestionChamps($(this));
        });

		appelAjax('clients', 'getClient', data, function(var_retour){

			//On rempli les champs du formulaire avec les données du client
			$('select[name="civilite"]').val(var_retour.client.civilite);
            $('input[name="nom"]').val(var_retour.client.nom);
            $('input[name="prenom"]').val(var_retour.client.prenom);
            $('textarea[name="adresse"]').val(var_retour.client.adresse);
            $('input[name="code_postal"]').val(var_retour.client.code_postal);
            $('input[name="ville"]').val(var_retour.client.ville);
            $('input[name="telephone"]').val(var_retour.client.telephone);
            $('input[name="email"]').val(var_retour.client.email);
            $('input[name="domaine"]').val(var_retour.client.domaine);
            $('input[name="id_client"]').val(var_retour.client.id_client);

            //on change le texte du bouton et le texte du H2
            $('#soumettre_formulaire').html('Modifier le compte');
            $('#bloc_formulaire h2').html("Formulaire de modification d'un client");

            //On se place à la hauteur du formulaire
            $('html,body').animate({scrollTop: $("#bloc_formulaire").offset().top}, 'slow');
        });

	});

	/***************************  Actions liés à la modal ****************************/

	$("body").on("hidden.bs.modal", ".modal", function () {
        $(this).removeData("bs.modal");
    });

	/** 
	 * Action qui permet d'ouvrir une modal de confirmation pour la suppression
	 */
	$(document).on('click', '.glyphicon-remove', function(){
		var data = {cible_contenu : 'supprimer_client',
					id_client : $(this).parents('tr:first').data('id_client'),
					ordre : $(this).parents('tr:first').data('ordre'),
					page : $(this).parents('tr:first').data('page'),
					sens : $(this).parents('tr:first').data('sens')};
		afficherModal(data);
	});

	/** 
	 * Action qui permet d'ouvrir une modal de confirmation pour la suppression
	 */
	$(document).on('click', '.glyphicon-search', function(){
		var data = {cible_contenu : 'recherche',
					champs : $(this).data('champs'),
					valeur : $(this).data('valeur'),
					ordre : $(this).parents('tr:first').data('ordre'),
					sens : $(this).parents('tr:first').data('sens')};

		afficherModal(data);
	});


});
	
/** 
 * Fonction qui va afficher le listing des clients
 */
function afficherListing(data){	
	appelAjax('clients', 'afficherListing', data, function(var_retour){
		$('#listing_client').html(var_retour.template_listing);
	});
}

/** 
 * Fonction qui va afficher une modale en fonction de la cible 
 */
function afficherModal(data){
	appelAjax('clients', 'afficherModal', data, function(var_retour){
		$('.modal-content').html(var_retour.contenu_modal);
		$("#infos").modal('show');
	});
}
