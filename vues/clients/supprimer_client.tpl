<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal">x</button>
  <h4 class="modal-title">Supprimer un client</h4>
</div>
<div class="modal-body">
  Etes-vous sûr de vouloir supprimer ce client ?
</div>
<div class="modal-footer">
    <input type="hidden" name="ordre" value="{$ordre}" />
    <input type="hidden" name="sens" value="{$sens}" />
    <input type="hidden" name="page" value="{$page}" />
    <button type="submit" class="btn btn-default" data-id_client="{$id_client}" id="supprimer_client">Oui</button>
    <button class="btn btn-info" data-dismiss="modal">Non</button>
</div>