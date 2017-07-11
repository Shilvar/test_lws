<html>
	<head>		
	</head>

	<body>
		Votre compte client vient d'être {if isset($donnees['id_client'])}modifié{else}créé !{/if}<br/><br/>

		{foreach from=$donnees key=key item=value}
			{if $key != 'id_client' && $key != 'ajax' && $key != 'type_requete'}
				{ucfirst($key)} : <b>{$value}</b><br/>
			{/if}
		{/foreach}
	</body>

</html>