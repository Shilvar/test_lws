{if $list_element|@count > 0 && !isset($no_action)}
	<span class="champs_ordre {if $ordre == $champs_bdd}champs_ordre_actif{/if}" data-ordre="{$champs_bdd}" data-sens="{if $ordre == $champs_bdd}{if $sens == 'ASC'}DESC{else}ASC{/if}{else}ASC{/if}" title="Trier la liste des clients par {$champs_th} dans l'ordre {if $ordre == $champs_bdd}{if $sens == 'ASC'}décroissant{else}croissant{/if}{else}croissant{/if}">{$champs_th}</span>
{else}
	{$champs_th}
{/if}