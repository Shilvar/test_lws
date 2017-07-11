<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

	<head>
	
		<title>Test de compétence de BRION Sébastien</title>
		<meta name="description" content="Ceci est un test de compétence pour le recrutement chez LWS pour le candidat M. BRION Sébastien" />
		<meta name="robots" content="noindex, nofollow" />
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<link rel="icon" type="image/png" href="{$smarty.const.PATH_IMAGES}logos/favicon.png" />
		
		<!-- Fichiers css -->

		<!-- inclusion des fichiers css propre à la page -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" />
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css" />

		<!--[if lt IE 9]>
		  <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<![endif]-->

		<link rel="stylesheet" type="text/css" href="{$smarty.const.PATH_PUBLIC}/css/general.css" media="all" />
		<link rel="stylesheet" type="text/css" href="{$smarty.const.PATH_PUBLIC}/css/header/style.css" media="all" />
		<link rel="stylesheet" type="text/css" href="{$smarty.const.PATH_PUBLIC}/css/footer/style.css" media="all" />

		<!-- inclusion des fichiers css propre à la page -->
		{foreach from=$list_path_fichier_css item=path_fichier_css}
			<link rel="stylesheet" type="text/css" href="{$path_fichier_css}" media="all"/>
		{/foreach}
		
		<!-- Fichiers JS -->	

		<!-- Inclusion de jQuery via son CDN -->
		<script src="https://code.jquery.com/jquery-3.2.1.min.js" type="text/javascript"></script>
		<!-- Inclusion de jQuery UI via son CDN -->
		<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"  type="text/javascript" /></script>

		<script type="text/javascript" src="{$smarty.const.PATH_PUBLIC}/js/general.js"></script>

		<!-- inclusion des fichiers js propre à la page -->
		{foreach from=$list_path_fichier_js item=path_fichier_js}
			<script type="text/javascript" src="{$path_fichier_js}"></script>
		{/foreach}

	</head>

	<body>
