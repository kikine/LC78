<?php
/**
* @version $Id: install3.php 4675 2006-08-23 16:55:24Z stingrey $
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
$DBPrefix  	= mosGetParam( $_POST, 'DBPrefix', '' );
$sitename  	= mosGetParam( $_POST, 'sitename', '' );
$adminEmail = mosGetParam( $_POST, 'adminEmail', '');
$filePerms	= mosGetParam( $_POST, 'filePerms', '');
$dirPerms	= mosGetParam( $_POST, 'dirPerms', '');
$configArray['siteUrl'] = trim( mosGetParam( $_POST, 'siteUrl', '' ) );
$configArray['absolutePath'] = trim( mosGetParam( $_POST, 'absolutePath', '' ) );
if (get_magic_quotes_gpc()) {
	$configArray['absolutePath'] = stripslashes(stripslashes($configArray['absolutePath']));
	$sitename = stripslashes(stripslashes($sitename));
}

if ($sitename == '') {
	echo "<form name=\"stepBack\" method=\"post\" action=\"install2.php\">
			<input type=\"hidden\" name=\"DBhostname\" value=\"$DBhostname\">
			<input type=\"hidden\" name=\"DBuserName\" value=\"$DBuserName\">
			<input type=\"hidden\" name=\"DBpassword\" value=\"$DBpassword\">
			<input type=\"hidden\" name=\"DBname\" value=\"$DBname\">
			<input type=\"hidden\" name=\"DBPrefix\" value=\"$DBPrefix\">
			<input type=\"hidden\" name=\"DBcreated\" value=1>
		</form>";

	echo "<script>alert('The sitename has not been provided'); document.stepBack.submit();</script>";
	return;
}

echo "<?xml version=\"1.0\" encoding=\"iso-8859-1\"?".">";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Joomla! - Web Installer</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link rel="shortcut icon" href="../images/favicon.ico" />
<link rel="stylesheet" href="install.css" type="text/css" />
<script type="text/javascript">
<!--
function check() {
	// form validation check
	var formValid = true;
	var f = document.form;
	if ( f.siteUrl.value == '' ) {
		alert('Veuillez saisir l\URL du site');
		f.siteUrl.focus();
		formValid = false;
	} else if ( f.absolutePath.value == '' ) {
		alert('Veuillez saisir le chemin absolu de votre site');
		f.absolutePath.focus();
		formValid = false;
	} else if ( f.adminEmail.value == '' ) {
		alert('Veuillez saisir l\'email du compte Admin');
		f.adminEmail.focus();
		formValid = false;
	} else if ( f.adminPassword.value == '' ) {
		alert('Veuillez saisir un mot de passe pour le compte Admin');
		f.adminPassword.focus();
		formValid = false;
	}

	return formValid;
}

function changeFilePermsMode(mode)
{
	if(document.getElementById) {
		switch (mode) {
			case 0:
				document.getElementById('filePermsFlags').style.display = 'none';
				break;
			default:
				document.getElementById('filePermsFlags').style.display = '';
		} // switch
	} // if
}

function changeDirPermsMode(mode)
{
	if(document.getElementById) {
		switch (mode) {
			case 0:
				document.getElementById('dirPermsFlags').style.display = 'none';
				break;
			default:
				document.getElementById('dirPermsFlags').style.display = '';
		} // switch
	} // if
}
//-->
</script>
</head>
<body onload="document.form.siteUrl.focus();">
<div id="wrapper">
	<div id="header">
		<div id="joomla"><img src="header_install.png" alt="Joomla! Installation" /></div>
	</div>
</div>
<div id="ctr" align="center">
	<form action="install4.php" method="post" name="form" id="form" onsubmit="return check();">
	<input type="hidden" name="DBhostname" value="<?php echo "$DBhostname"; ?>" />
	<input type="hidden" name="DBuserName" value="<?php echo "$DBuserName"; ?>" />
	<input type="hidden" name="DBpassword" value="<?php echo "$DBpassword"; ?>" />
	<input type="hidden" name="DBname" value="<?php echo "$DBname"; ?>" />
	<input type="hidden" name="DBPrefix" value="<?php echo "$DBPrefix"; ?>" />
	<input type="hidden" name="sitename" value="<?php echo "$sitename"; ?>" />
	<div class="install">
		<div id="stepbar">
			<div class="step-off">Pr�-installation</div>
			<div class="step-off">License</div>
			<div class="step-off">Etape 1</div>
			<div class="step-off">Etape 2</div>
			<div class="step-on">Etape 3</div>
			<div class="step-off">Etape 4</div>
		</div>
		<div id="right">
			<div id="step">Etape 3</div>
			<div class="far-right">
				<input class="button" type="submit" name="next" value="Suivant >>"/>
			</div>
			<div class="clr"></div>
			<h1>URL du site, chemin, e-mail de l'admin et CHMOD fichiers/r�pertoires</h1>
			<div class="install-text">
				  <p>Si l'adresse et le chemin absolu semblent corrects, alors conservez les tels quels. Si vous n'en �tes pas certain, alors contactez l'h�bergeur de votre site Internet ou votre administrateur. Habituellement les valeurs affich�es conviendront � votre site.<br/>
				  <br/>Entrez votre adresse email, pour l'administrateur principal du site..<br />
				  <br/>La configuration des permissions va �tre utilis�e pendant l'installation de Joomla!, par le syst�me d'installation de Joomla! et par le "gestionnaire de m�dia". Si vous n'�tes pas certain des valeurs � cocher, alors laissez la configuration par d�faut pour l'instant. Vous pourrez les changer ult�rieurement dans l'espace administrateur sous configuration globale.</p>
			</div>
			<div class="install-form">
				<div class="form-block">
					<table class="content2">
					<tr>
						<td width="100">URL</td>
<?php
	$url = "";
	if ($configArray['siteUrl'])
		$url = $configArray['siteUrl'];
	else {
		$port = ( $_SERVER['SERVER_PORT'] == 80 ) ? '' : ":".$_SERVER['SERVER_PORT'];
		$root = $_SERVER['SERVER_NAME'].$port.$_SERVER['PHP_SELF'];
		$root = str_replace("installation/","",$root);
		$root = str_replace("/install3.php","",$root);
		$url = "http://".$root;
	}
?>						<td align="center"><input class="inputbox" type="text" name="siteUrl" value="<?php echo $url; ?>" size="50"/></td>
					</tr>
					<tr>
						<td>Chemin</td>
<?php
	$abspath = "";
	if ($configArray['absolutePath'])
		$abspath = $configArray['absolutePath'];
	else {
		$path = getcwd();
		if (preg_match("/\/installation/i", "$path"))
			$abspath = str_replace('/installation',"",$path);
		else
			$abspath = str_replace('\installation',"",$path);
	}
?>						<td align="center"><input class="inputbox" type="text" name="absolutePath" value="<?php echo $abspath; ?>" size="50"/></td>
					</tr>
					<tr>
						<td>E-mail Admin</td>
						<td align="center"><input class="inputbox" type="text" name="adminEmail" value="<?php echo "$adminEmail"; ?>" size="50" /></td>
					</tr>
					<tr>
						<td>Mot de passe Admin</td>
						<td align="center"><input class="inputbox" type="text" name="adminPassword" value="<?php echo mosMakePassword(8); ?>" size="50"/></td>
					</tr>
					<tr>
<?php
	$mode = 0;
	$flags = 0644;
	if ($filePerms!='') {
		$mode = 1;
		$flags = octdec($filePerms);
	} // if
?>
						<td colspan="2">
  							<fieldset><legend>Permissions sur les fichiers</legend>
								<table cellpadding="1" cellspacing="1" border="0">
									<tr>
										<td><input type="radio" id="filePermsMode0" name="filePermsMode" value="0" onclick="changeFilePermsMode(0)"<?php if (!$mode) echo ' checked="checked"'; ?>/></td>
										<td><label for="filePermsMode0">Ne pas changer les droits (CHMOD) des fichiers (utilisez ceux du serveur par d�faut)</label></td>
									</tr>
									<tr>
										<td><input type="radio" id="filePermsMode1" name="filePermsMode" value="1" onclick="changeFilePermsMode(1)"<?php if ($mode) echo ' checked="checked"'; ?>/></td>
										<td><label for="filePermsMode1">Modifier les droits (CHMOD) des fichiers en:</label></td>
									</tr>
									<tr id="filePermsFlags"<?php if (!$mode) echo ' style="display:none"'; ?>>
										<td>&nbsp;</td>
										<td>
											<table cellpadding="1" cellspacing="0" border="0">
												<tr>
													<td>Utilisateur:</td>
													<td><input type="checkbox" id="filePermsUserRead" name="filePermsUserRead" value="1"<?php if ($flags & 0400) echo ' checked="checked"'; ?>/></td>
													<td><label for="filePermsUserRead">read</label></td>
													<td><input type="checkbox" id="filePermsUserWrite" name="filePermsUserWrite" value="1"<?php if ($flags & 0200) echo ' checked="checked"'; ?>/></td>
													<td><label for="filePermsUserWrite">write</label></td>
													<td><input type="checkbox" id="filePermsUserExecute" name="filePermsUserExecute" value="1"<?php if ($flags & 0100) echo ' checked="checked"'; ?>/></td>
													<td width="100%"><label for="filePermsUserExecute">execute</label></td>
												</tr>
												<tr>
													<td>Groupe:</td>
													<td><input type="checkbox" id="filePermsGroupRead" name="filePermsGroupRead" value="1"<?php if ($flags & 040) echo ' checked="checked"'; ?>/></td>
													<td><label for="filePermsGroupRead">read</label></td>
													<td><input type="checkbox" id="filePermsGroupWrite" name="filePermsGroupWrite" value="1"<?php if ($flags & 020) echo ' checked="checked"'; ?>/></td>
													<td><label for="filePermsGroupWrite">write</label></td>
													<td><input type="checkbox" id="filePermsGroupExecute" name="filePermsGroupExecute" value="1"<?php if ($flags & 010) echo ' checked="checked"'; ?>/></td>
													<td width="100%"><label for="filePermsGroupExecute">execute</label></td>
												</tr>
												<tr>
													<td>Public:</td>
													<td><input type="checkbox" id="filePermsWorldRead" name="filePermsWorldRead" value="1"<?php if ($flags & 04) echo ' checked="checked"'; ?>/></td>
													<td><label for="filePermsWorldRead">read</label></td>
													<td><input type="checkbox" id="filePermsWorldWrite" name="filePermsWorldWrite" value="1"<?php if ($flags & 02) echo ' checked="checked"'; ?>/></td>
													<td><label for="filePermsWorldWrite">write</label></td>
													<td><input type="checkbox" id="filePermsWorldExecute" name="filePermsWorldExecute" value="1"<?php if ($flags & 01) echo ' checked="checked"'; ?>/></td>
													<td width="100%"><label for="filePermsWorldExecute">execute</label></td>
												</tr>
											</table>
										</td>
									</tr>
								</table>
							</fieldset>
						</td>
					</tr>
					<tr>
<?php
	$mode = 0;
	$flags = 0755;
	if ($dirPerms!='') {
		$mode = 1;
		$flags = octdec($dirPerms);
	} // if
?>
						<td colspan="2">
  							<fieldset><legend>Permissions sur les r�pertoires</legend>
								<table cellpadding="1" cellspacing="1" border="0">
									<tr>
										<td><input type="radio" id="dirPermsMode0" name="dirPermsMode" value="0" onclick="changeDirPermsMode(0)"<?php if (!$mode) echo ' checked="checked"'; ?>/></td>
										<td><label for="dirPermsMode0">Ne pas changer les droits (CHMOD) des fichiers (utilisez ceux du serveur par d�faut)</label></td>
									</tr>
									<tr>
										<td><input type="radio" id="dirPermsMode1" name="dirPermsMode" value="1" onclick="changeDirPermsMode(1)"<?php if ($mode) echo ' checked="checked"'; ?>/></td>
										<td><label for="dirPermsMode1">Modifier les droits (CHMOD) des fichiers en::</label></td>
									</tr>
									<tr id="dirPermsFlags"<?php if (!$mode) echo ' style="display:none"'; ?>>
										<td>&nbsp;</td>
										<td>
											<table cellpadding="1" cellspacing="0" border="0">
												<tr>
													<td>Utilisateur:</td>
													<td><input type="checkbox" id="dirPermsUserRead" name="dirPermsUserRead" value="1"<?php if ($flags & 0400) echo ' checked="checked"'; ?>/></td>
													<td><label for="dirPermsUserRead">read</label></td>
													<td><input type="checkbox" id="dirPermsUserWrite" name="dirPermsUserWrite" value="1"<?php if ($flags & 0200) echo ' checked="checked"'; ?>/></td>
													<td><label for="dirPermsUserWrite">write</label></td>
													<td><input type="checkbox" id="dirPermsUserSearch" name="dirPermsUserSearch" value="1"<?php if ($flags & 0100) echo ' checked="checked"'; ?>/></td>
													<td width="100%"><label for="dirPermsUserSearch">search</label></td>
												</tr>
												<tr>
													<td>Groupe:</td>
													<td><input type="checkbox" id="dirPermsGroupRead" name="dirPermsGroupRead" value="1"<?php if ($flags & 040) echo ' checked="checked"'; ?>/></td>
													<td><label for="dirPermsGroupRead">read</label></td>
													<td><input type="checkbox" id="dirPermsGroupWrite" name="dirPermsGroupWrite" value="1"<?php if ($flags & 020) echo ' checked="checked"'; ?>/></td>
													<td><label for="dirPermsGroupWrite">write</label></td>
													<td><input type="checkbox" id="dirPermsGroupSearch" name="dirPermsGroupSearch" value="1"<?php if ($flags & 010) echo ' checked="checked"'; ?>/></td>
													<td width="100%"><label for="dirPermsGroupSearch">search</label></td>
												</tr>
												<tr>
													<td>Public:</td>
													<td><input type="checkbox" id="dirPermsWorldRead" name="dirPermsWorldRead" value="1"<?php if ($flags & 04) echo ' checked="checked"'; ?>/></td>
													<td><label for="dirPermsWorldRead">read</label></td>
													<td><input type="checkbox" id="dirPermsWorldWrite" name="dirPermsWorldWrite" value="1"<?php if ($flags & 02) echo ' checked="checked"'; ?>/></td>
													<td><label for="dirPermsWorldWrite">write</label></td>
													<td><input type="checkbox" id="dirPermsWorldSearch" name="dirPermsWorldSearch" value="1"<?php if ($flags & 01) echo ' checked="checked"'; ?>/></td>
													<td width="100%"><label for="dirPermsWorldSearch">search</label></td>
												</tr>
											</table>
										</td>
									</tr>
								</table>
							</fieldset>
						</td>
					</tr>
					</table>
				</div>
			</div>
			<div id="break"></div>
		</div>
		<div class="clr"></div>
	</div>
	</form>
</div>
<div class="clr"></div>
<div class="ctr">
	<a href="http://www.joomla.org" target="_blank">Joomla!</a> est un logiciel libre distribu� sous licence GNU/GPL.
</div>
</body>
</html>