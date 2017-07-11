{* TEMPLATE AFFICHANT LE LISTING DES CLIENTS *}

<section class="row">
  <div class="col-lg-12">
    {if !isset($no_action)}  
      <h2 class="">Listing des clients</h2>

      {*  AFFICHAGE DE LA PAGINATION SI ON A PLUS D'UNE PAGE A AFFICHER *}
      {if $nb_page > 1}  
        <div class="text-center">
          <ul class="pagination" data-ordre="{$ordre}" data-sens="{$sens}">
            {if $page > 1}<li data-page="{$page-1}"><a href="#">&laquo;</a></li>{/if}
            {for $i=1 to $nb_page}
              <li data-page="{$i}" {if $page == $i}class="page_active"{/if}><a href="#">{$i}</a></li>
            {/for}
            {if $page < $nb_page}<li data-page="{$page+1}"><a href="#">&raquo;</a></li>{/if}
          </ul>
        </div>
      {/if}
    {/if}

      {*  LISTING DES CLIENTS *}
      <table class="table">
        <thead>
       		<tr>
            <th>{include file="../_generique/champs_th.tpl" list_element=$list_client champs_th="#" champs_bdd="id_client"}</th>
            <th>{include file="../_generique/champs_th.tpl" list_element=$list_client champs_th="Civilité" champs_bdd="civilite"}</th>
            <th>{include file="../_generique/champs_th.tpl" list_element=$list_client champs_th="Nom" champs_bdd="nom"}</th>
            <th>{include file="../_generique/champs_th.tpl" list_element=$list_client champs_th="Prénom" champs_bdd="prenom"}</th>
            <th>{include file="../_generique/champs_th.tpl" list_element=$list_client champs_th="Adresse" champs_bdd="adresse"}</th>
            <th>{include file="../_generique/champs_th.tpl" list_element=$list_client champs_th="Code postal" champs_bdd="code_postal"}</th>
            <th>{include file="../_generique/champs_th.tpl" list_element=$list_client champs_th="Ville" champs_bdd="ville"}</th>
            <th>{include file="../_generique/champs_th.tpl" list_element=$list_client champs_th="Téléphone" champs_bdd="telephone"}</th>
            <th>{include file="../_generique/champs_th.tpl" list_element=$list_client champs_th="E-mail" champs_bdd="email"}</th>
            <th>{include file="../_generique/champs_th.tpl" list_element=$list_client champs_th="Domaine" champs_bdd="domaine"}</th>
            {if !isset($no_action)}
              <th>Actions</th>
            {/if}
            
          </tr>
        </thead>

        <tbody>           
          {if $list_client|@count > 0}
            {foreach from=$list_client item=client}
              <tr data-id_client="{$client->id_client}" data-page={$page} data-ordre={$ordre} data-sens={$sens}>
                <td>{$client->id_client}</td>
                <td>
                  <div class="row">
                    <div class="col-lg-5">{ucfirst($client->civilite)}</div>
                    {include file="./search.tpl" champs="civilite" valeur=$client->civilite}
                  </div>                  
                </td>
                <td>
                  <div class="row">
                    <div class="col-lg-5">{$client->nom}</div>
                    {include file="./search.tpl" champs="nom" valeur=$client->nom}
                  </div>
                </td>
                <td>
                  <div class="row">
                    <div class="col-lg-5">{$client->prenom}</div>
                    {include file="./search.tpl" champs="prenom" valeur=$client->prenom}
                  </div>
                </td>
                <td>
                  <div class="row">
                    <div class="col-lg-5">{$client->adresse}</div>
                    {include file="./search.tpl" champs="adresse" valeur=$client->adresse}
                  </div>
                </td>
                <td>
                  <div class="row">
                    <div class="col-lg-5">{$client->code_postal}</div>
                    {include file="./search.tpl" champs="code_postal" valeur=$client->code_postal}
                  </div>
                </td>
                <td>
                  <div class="row">
                    <div class="col-lg-5">{$client->ville}</div>
                    {include file="./search.tpl" champs="ville" valeur=$client->ville}
                  </div>
                </td>
                <td>
                  <div class="row">
                    <div class="col-lg-5">{$client->telephone}</div>
                    {include file="./search.tpl" champs="telephone" valeur=$client->telephone}
                  </div>
                </td>
                <td>
                  <div class="row">
                    <div class="col-lg-5">{$client->email}</div>
                  </div>
                </td>
                <td>
                  <div class="row">
                    <div class="col-lg-5">{$client->domaine}</div>
                    {include file="./search.tpl" champs="domaine" valeur=$client->domaine}
                  </div>
                </td>
                {if !isset($no_action)}
                  <td class="text-center">                  
                    <span class="glyphicon glyphicon-pencil"></span>
                    <span class="glyphicon glyphicon-remove"></span>
                  </td>
                {/if}
              </tr>
            {/foreach}
          {else}
            <tr>
              <td colspan="11" class="text-center text-italic">Aucun client trouvé !</td>
            </tr>
          {/if}
          
        </tbody>
      </table>
      
  </div>
</section>

<script>
  $('.champs_ordre').tooltip();
</script>