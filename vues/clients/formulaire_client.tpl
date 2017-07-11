<form id="form" class="form-horizontal col-lg-12">

	<div class="row dn">
		<div id="infos_retour_formulaire" class="col-lg-12 alert alert-block ">
		
		</div>
	</div>

	<!-- Civilité --> 
	<div class="row">
		<div class="form-group has-feedback">
			<label for="civilite" class="col-lg-2 control-label">Civilité<span class="requis">*</span></label>
			<div class="col-lg-10">
				<select id="civilite" name="civilite" class="form-control" requis="1">
					<option value=""></option>
					<option value="madame" {if $client->civilite == 'madame'}selected="selected"{/if}>Madame</option>
					<option value="monsieur" {if $client->civilite == 'monsieur'}selected="selected"{/if}>Monsieur</option>
				</select>
				<span class="help-block"></span>
			</div>

		</div>
	</div>

	<!-- Nom --> 
	<div class="row">
		<div class="form-group has-feedback">
			<label for="nom" class="col-lg-2 control-label">Nom<span class="requis">*</span></label>
			<div class="col-lg-10">
				<input id="nom" name="nom" value="{$client->nom}" class="form-control" requis="1">				
				<span class="glyphicon form-control-feedback"></span>			
				<span class="help-block"></span>
			</div>

		</div>
	</div>

	<!-- Prénom --> 
	<div class="row">
		<div class="form-group has-feedback">
			<label for="prenom" class="col-lg-2 control-label">Prénom<span class="requis">*</span></label>
			<div class="col-lg-10">
				<input id="prenom" name="prenom" value="{$client->prenom}" class="form-control" requis="1">				
				<span class="glyphicon form-control-feedback"></span>
				<span class="help-block"></span>
			</div>
		</div>
	</div>

	<!-- Adresse --> 
	<div class="row">
		<div class="form-group has-feedback">
			<label for="adresse" class="col-lg-2 control-label">Adresse<span class="requis">*</span></label>
			<div class="col-lg-10">
				<textarea id="adresse" name="adresse" class="form-control" requis="1">{$client->adresse}</textarea>		
				<span class="glyphicon form-control-feedback"></span>
				<span class="help-block"></span>
			</div>
		</div>
	</div>

	<!-- Code postal --> 
	<div class="row">
		<div class="form-group has-feedback">
			<label for="code_postal" class="col-lg-2 control-label">Code postal<span class="requis">*</span></label>
			<div class="col-lg-10">
				<input id="code_postal" name="code_postal" value="{$client->code_postal}" class="form-control" requis="1" numerique="1">
				<span class="glyphicon form-control-feedback"></span>
				<span class="help-block"></span>
			</div>
		</div>
	</div>

	<!-- Ville --> 
	<div class="row">
		<div class="form-group has-feedback">
			<label for="ville" class="col-lg-2 control-label">Ville<span class="requis">*</span></label>
			<div class="col-lg-10">
				<input id="ville" name="ville" value="{$client->ville}" class="form-control" requis="1">
				<span class="glyphicon form-control-feedback"></span>
				<span class="help-block"></span>
			</div>
		</div>
	</div>

	<!-- Téléphone --> 
	<div class="row">
		<div class="form-group has-feedback">
			<label for="telephone" class="col-lg-2 control-label">Téléphone</label>
			<div class="col-lg-10">
				<input id="telephone" name="telephone" value="{$client->telephone}" placeholder="Ex:01.23.45.67.89" class="form-control">
				<span class="glyphicon form-control-feedback"></span>
				<span class="help-block"></span>
			</div>
		</div>
	</div>

	<!-- E-mail --> 
	<div class="row">
		<div class="form-group has-feedback">
			<label for="email" class="col-lg-2 control-label">E-mail<span class="requis">*</span></label>
			<div class="col-lg-10">
				<input id="email" name="email" value="{$client->email}" class="form-control" requis="1" email="1">
				<span class="glyphicon form-control-feedback"></span>
				<span class="help-block"></span>
			</div>
		</div>
	</div>

	<!-- Domaine --> 
	<div class="row">
		<div class="form-group has-feedback">
			<label for="domaine" class="col-lg-2 control-label">Domaine</label>
			<div class="col-lg-10">
				<input id="domaine" name="domaine" value="{$client->domaine}" class="form-control">
				<span class="glyphicon form-control-feedback"></span>
				<span class="help-block"></span>
			</div>
		</div>
	</div>
	
	<input type="hidden" name="id_client" value="{$client->id_client}" />

	<div class="form-group has-feedback">
	   <button id="soumettre_formulaire" class="pull-right btn btn-default">Créer le compte</button>
	</div>

	<div class="row">
		<div class="col-lg-12 text-danger">* : Champ requis</div>
	</div>
</form>

<div class="row text-center">
	<div class="col-lg-12" id="icone_domaine"></div>
</div>