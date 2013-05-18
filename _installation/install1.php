<?php
/**
* @version $Id: install1.php 4675 2006-08-23 16:55:24Z stingrey $
* @package Joomla
* @copyright Copyright (C) 2005 Open Source Matters. All rights reserved.
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
* Joomla! is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
* See COPYRIGHT.php for copyright notices and details.
*/

// Set flag that this is a parent file
define( "_VALID_MOS", 1 );

/** Include common.php */
require_once( 'common.php' );

$DBhostname = mosGetParam( $_POST, 'DBhostname', '' );
$DBuserName = mosGetParam( $_POST, 'DBuserName', '' );
$DBpassword = mosGetParam( $_POST, 'DBpassword', '' );
$DBname  	= mosGetParam( $_POST, 'DBname', '' );
$DBPrefix  	= mosGetParam( $_POST, 'DBPrefix', 'jos_' );
$DBDel  	= intval( mosGetParam( $_POST, 'DBDel', 0 ) );
$DBBackup  	= intval( mosGetParam( $_POST, 'DBBackup', 0 ) );
$DBSample  	= intval( mosGetParam( $_POST, 'DBSample', 1 ) );

echo "<?xml version=\"1.0\" encoding=\"iso-8859-1\"?".">";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Joomla! - Web Installer</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link rel="shortcut icon" href="../images/favicon.ico" />
<link rel="stylesheet" href="install.css" type="text/css" />
<script  type="text/javascript">
<!--
function check() {
	// form validation check
	var formValid=false;
	var f = document.form;
	if ( f.DBhostname.value == '' ) {
		alert('Veuillez saisir un nom de serveur');
		f.DBhostname.focus();
		formValid=false;
	} else if ( f.DBuserName.value == '' ) {
		alert('Veuillez saisir le nom d\'utilisateur de la base de données');
		f.DBuserName.focus();
		formValid=false;
	} else if ( f.DBname.value == '' ) {
		alert('Veuillez saisir le nom de la base de données');
		f.DBname.focus();
		formValid=false;
	} else if ( f.DBPrefix.value == '' ) {
		alert('Vous devez saisir un préfixe pour les tables MySQL.');
		f.DBPrefix.focus();
		formValid=false;
	} else if ( f.DBPrefix.value == 'old_' ) {
		alert('Vous ne pouvez pas utiliser le préfixe "old_" qui est celui utilisé pour les tables sauvegardées.');
		f.DBPrefix.focus();
		formValid=false;
	} else if ( confirm('Etes vous certain que ces paramètres sont corrects? \nJoomla! va maintenant configurer la base de données.')) {
		formValid=true;
	}

	return formValid;
}
//-->
</script>
</head>
<body onload="document.form.DBhostname.focus();">
<div id="wrapper">
	<div id="header">
		<div id="joomla"><img src="header_install.png" alt="Joomla! Installation" /></div>
	</div>
</div>
<div id="ctr" align="center">
	<form action="install2.php" method="post" name="form" id="form" onsubmit="return check();">
	<div class="install">
		<div id="stepbar">
			<div class="step-off">
				Pré-installation
			</div>
			<div class="step-off">
				Licence
			</div>
			<div class="step-on">
				Etape 1
			</div>
			<div class="step-off">
				Etape 2
			</div>
			<div class="step-off">
				Etape 3
			</div>
			<div class="step-off">
				Etape 4
			</div>
		</div>
		<div id="right">
			<div class="far-right">
				<input class="button" type="submit" name="next" value="Suivant >>"/>
  			</div>
	  		<div id="step">
	  			Etape 1
	  		</div>
  			<div class="clr"></div>
  			<h1>Configuration de la base de données MySQL:</h1>
	  		<div class="install-text">
  				<p>L'installation de Joomla! sur votre serveur implique 4 étapes simples...</p>
  				<p>Veuillez entrer le nom du serveur (hostname) sur lequel Joomla! va être installé.</p>
				<p>Entrez le nom d'utilisateur, le mot de passe et le nom de la BDD MySQL que vous allez utiliser avec Joomla!.</p>
				<p>Entrez le préfixe des tables devant étre utilisé par cette installation Joomla! et choisissez l'action adéquat à faire lorsqu'il existe des tables d'une installation précédente.</p>
				<p>Installez les exemples de contenu si vous n'étes pas expérimenté avec Joomla!, sinon vous aurez un site presque entiérement vide de contenu pour débuter.</p>
  			</div>
			<div class="install-form">
  				<div class="form-block">
  		 			<table class="content2">
  		  			<tr>
  						<td></td>
  						<td></td>
  						<td></td>
  					</tr>
  		  			<tr>
  						<td colspan="2">
  							Nom du serveur
  							<br/>
  							<input class="inputbox" type="text" name="DBhostname" value="<?php echo "$DBhostname"; ?>" />
  						</td>
			  			<td>
			  				<em> Habituellement 'localhost'</em>
			  			</td>
  					</tr>
					<tr>
			  			<td colspan="2">
			  				Nom d'utilisateur
			  				<br/>
			  				<input class="inputbox" type="text" name="DBuserName" value="<?php echo "$DBuserName"; ?>" />
			  			</td>
			  			<td>
			  				<em>Soit 'root' ou un nom d'utilisateur fourni par l'hébergeur</em>
			  			</td>
  					</tr>
			  		<tr>
			  			<td colspan="2">
			  				Mot de passe
			  				<br/>
			  				<input class="inputbox" type="text" name="DBpassword" value="<?php echo "$DBpassword"; ?>" />
			  			</td>
			  			<td>
			  				<em>Pour la sécurité du site l'utilisation d'un mot de passe est obligatoire pour le compte mysql</em>
			  			</td>
					</tr>
  		  			<tr>
  						<td colspan="2">
  							Nom de la base de données
  							<br/>
  							<input class="inputbox" type="text" name="DBname" value="<?php echo "$DBname"; ?>" />
  						</td>
			  			<td>
			  				<em>Certains hébergements limitent le nombre de noms de BDD par site. Utilisez dans ce cas le préfixe de table pour distinguer les sites Joomla!..</em>
			  			</td>
  					</tr>
  		  			<tr>
  						<td colspan="2">
  							Préfixe des tables
  							<br/>
  							<input class="inputbox" type="text" name="DBPrefix" value="<?php echo "$DBPrefix"; ?>" />
  						</td>
			  			<td>
			  			<!--
			  			<em> N'utilisez pas 'old_', qui est réservé à la sauvegarde des tables</em>
			  			-->
			  			</td>
  					</tr>
  		  			<tr>
			  			<td>
			  				<input type="checkbox" name="DBDel" id="DBDel" value="1" <?php if ($DBDel) echo 'checked="checked"'; ?> />
			  			</td>
						<td>
							<label for="DBDel">Supprimer les tables existantes</label>
						</td>
  						<td>
  						</td>
			  		</tr>
  		  			<tr>
			  			<td>
			  				<input type="checkbox" name="DBBackup" id="DBBackup" value="1" <?php if ($DBBackup) echo 'checked="checked"'; ?> />
			  			</td>
						<td>
							<label for="DBBackup">Sauvegarder les anciennes tables</label>
						</td>
  						<td>
  							<em>Toute sauvegarde de tables d'une installation précédente de Joomla! sera remplacée</em>
  						</td>
			  		</tr>
  		  			<tr>
			  			<td>
			  				<input type="checkbox" name="DBSample" id="DBSample" value="1" <?php if ($DBSample) echo 'checked="checked"'; ?> />
			  			</td>
						<td>
							<label for="DBSample">Installer des exemples de données</label>
						</td>
			  			<td>
			  				<em>Décochez seulement si vous êtes expérimenté avec Joomla!</em>
			  			</td>
			  		</tr>
		  		 	</table>
  				</div>
			</div>
		</div>
		<div class="clr"></div>
	</div>
	</form>
</div>
<div class="clr"></div>
<div class="ctr">
	<a href="http://www.joomla.org" target="_blank">Joomla!</a> est un logiciel libre distribué sous licence GNU/GPL.
</div>
</body>
</html>