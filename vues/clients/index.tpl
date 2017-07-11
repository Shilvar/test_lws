<div class="container-fluid">
    <div class="navbar navbar-inverse navbar-fixed-top">
   		<h4 class="text-center text-white">
    		Test de compétences - BRION Sébastien
  		</h4>
    </div>
</div>

<div class="container">

	<div class="modal fade" id="infos">
 		<div class="modal-dialog modal-lg">
          <div class="modal-content"></div>
        </div> 
	</div>

	<!-- Section comprenant le listing des clients -->
	<section class="row">
		<div class="col-lg-12">
			<button id="affiche_listing_client" type="button" class="btn btn-info">Afficher le listing des clients</button>
		</div>
		<div class="col-lg-12" id="listing_client"></div>
	</section>

	<!-- Section comprenant le formulaire de création d'un client -->
	<section class="row" id="bloc_formulaire">
		<header class="col-lg-12">
			<h2>Formulaire de création d'un client</h2>
		</header>
		<div class="col-lg-8 col-md-12 well">
			{include file="./formulaire_client.tpl"}
		</div>
		
	</section>

</div>

