<?php
	include("./includes/config.php");
	include("./includes/fonctions.php");
	connexion($bd_server,$bd_user,$bd_passwd,$bd_base_ceg); ?>


<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Strict//EN">
<html xml:lang="fr" xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>LC78 - JUPITER</title>
	<meta http-equiv=content-type content="text/html; charset=iso-8859-1">
	<meta http-equiv=content-script-type content=text/javascript>
	<meta http-equiv=content-style-type content=text/css>
	<meta content="internet" name=category>
	<meta content="index, follow" name=robots>
	<link title=normal media=screen href="http://<?php echo $hostname; ?>/JUPITER/style/style.css" type=text/css rel=stylesheet>
	<link href="http://<?php echo $hostname; ?>/JUPITER/style/logo_LC78.jpeg" type=images/x-icon rel="shortcut icon">
	<meta content="mshtml 6.00.2800.1491" name=generator>
</head>

<body>
	<div id="content">
		<form action="./verif.php" method="post">
			<fieldset>
				<legend>Veuillez vous identifier...</legend>
				<div>
						<label for="log">IDENTIFIANT</label><input type="text" id ="log" name="login"/>
				</div>
				<div>
						<label for="mdp">MOT DE PASSE</label><input type="password" id ="mdp" name="mdp"/>
				</div>
				<br/>
				<div class="form-control">
					<input type="submit" value="Valider" class="form-submit" />
					<input type="reset" value="Effacer" class="form-reset" />
				</div>
			</fieldset>
		</form>
	
	<?php 	include("./includes/footer.inc"); ?>