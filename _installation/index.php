<?php
/**
* @version $Id: index.php 4807 2006-08-28 17:30:12Z stingrey $
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
define( '_VALID_MOS', 1 );

if (file_exists( '../configuration.php' ) && filesize( '../configuration.php' ) > 10) {
	header( "Location: ../index.php" );
	exit();
}
require( '../globals.php' );
require_once( '../includes/version.php' );

/** Include common.php */
include_once( 'common.php' );
view();

/*
 * Added 1.0.11
 */
function view() {
	$sp 		= ini_get( 'session.save_path' );

	$_VERSION 		= new joomlaVersion();
	$versioninfo 	= $_VERSION->RELEASE .'.'. $_VERSION->DEV_LEVEL .' '. $_VERSION->DEV_STATUS;
	$version 		= $_VERSION->PRODUCT .' '. $_VERSION->RELEASE .'.'. $_VERSION->DEV_LEVEL .' '. $_VERSION->DEV_STATUS.' [ '.$_VERSION->CODENAME .' ] '. $_VERSION->RELDATE .' '. $_VERSION->RELTIME .' '. $_VERSION->RELTZ;
	
echo "<?xml version=\"1.0\" encoding=\"iso-8859-1\"?".">";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Joomla! - Web Installer</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link rel="shortcut icon" href="../images/favicon.ico" />
<link rel="stylesheet" href="install.css" type="text/css" />
</head>
<body>

<div id="wrapper">
<div id="header">
			<div id="joomla">
				<img src="header_install.png" alt="Installation Joomla!" />
			</div>
</div>
</div>

<div id="ctr" align="center">
<div class="install">
<div id="stepbar">
<div class="step-on">Pr�-installation</div>
<div class="step-off">Licence</div>
<div class="step-off">Etape 1</div>
<div class="step-off">Etape 2</div>
<div class="step-off">Etape 3</div>
<div class="step-off">Etape 4</div>
</div>

<div id="right">
<div id="step">Pr�-installation</div>

<div class="far-right">
	<input name="Button2" type="submit" class="button" value="Suivant >>" onclick="window.location='install.php';" />
	<br/>
	<br/>
	<input type="button" class="button" value="V�rifier � nouveau" onclick="window.location=window.location" />
</div>
<div class="clr"></div>

				<h1 style="text-align: center; border-bottom: 0px;">
					<?php echo $version; ?>
				</h1>
	
				<h1>
					V�rification des param�tres n�cessaires:
				</h1>
				
<div class="install-text">
					<p>
						Si certains �l�ments sont �crits en rouge, alors veuillez prendre les mesures n�cessaires pour les corriger. 
					</p>
					<p>
						Sinon l'installation de Joomla peut ne pas fonctionner correctement.
					</p>
					<div class="ctr"></div>
				</div>
	
				<div class="install-form">
					<div class="form-block">
<table class="content">
<tr>
	<td class="item">
	PHP version >= 4.1.0
	</td>
	<td align="left">
	<?php echo phpversion() < '4.1' ? '<b><font color="red">Non</font></b>' : '<b><font color="green">Oui</font></b>';?>
	</td>
</tr>
<tr>
	<td>
	&nbsp; - Compression ZLIB
	</td>
	<td align="left">
	<?php echo extension_loaded('zlib') ? '<b><font color="green">Oui</font></b>' : '<b><font color="red">Non</font></b>';?>
	</td>
</tr>
<tr>
	<td>
	&nbsp; - Support XML
	</td>
	<td align="left">
	<?php echo extension_loaded('xml') ? '<b><font color="green">Oui</font></b>' : '<b><font color="red">Non</font></b>';?>
	</td>
</tr>
<tr>
	<td>
	&nbsp; - Support MySQL
	</td>
	<td align="left">
	<?php echo function_exists( 'mysql_connect' ) ? '<b><font color="green">Oui</font></b>' : '<b><font color="red">Non</font></b>';?>
	</td>
</tr>
<tr>
	<td valign="top" class="item">
	configuration.php
	</td>
	<td align="left">
	<?php
	if (@file_exists('../configuration.php') &&  @is_writable( '../configuration.php' )){
		echo '<b><font color="green">Modifiable</font></b>';
	} else if (is_writable( '..' )) {
		echo '<b><font color="green">Modifiable</font></b>';
	} else {
		echo '<b><font color="red">Non modifiable</font></b><br /><span class="small">Vous pouvez poursuivre l\'installation, vous devrez toutefois copier et coller les donn�es de configuration affich�es � la fin de l\'installation dans un fichier configuration.php, que vous devrez ensuite uploader.</span>';
	} ?>
	</td>
</tr>
<tr>
	<td class="item">
	Session save path
	</td>
	<td align="left" valign="top">
	<?php echo is_writable( $sp ) ? '<b><font color="green">Modifiable</font></b>' : '<b><font color="red">Non modifiable</font></b>';?>
	</td>
</tr>
<tr>
	<td class="item" colspan="2">
								<b>
									<?php echo $sp ? $sp : 'Not set'; ?>
								</b>
							</td>
						</tr>
						</table>
					</div>
				</div>
				<div class="clr"></div>
				
		
				
				<?php
				$wrongSettingsTexts = array();
				
				if ( ini_get('magic_quotes_gpc') != '1' ) {
					$wrongSettingsTexts[] = 'Param�tre PHP magic_quotes_gpc est sur `OFF` au lieu de `ON`';
				}
				if ( ini_get('register_globals') == '1' ) {
					$wrongSettingsTexts[] = 'Param�tre PHP register_globals est sur `ON` au lieu de `OFF`';
				}
				if ( RG_EMULATION != 0 ) {
					$wrongSettingsTexts[] = 'Param�tre Joomla! RG_EMULATION est sur `ON` au lieu de `OFF` dans le fichier globals.php <br /><span style="font-weight: normal; font-style: italic; color: #666;">`ON` est d�fini par d�faut pour des raisons de compatibilit�</span>';
				}	
	
				if ( count($wrongSettingsTexts) ) {
					?>							
					<h1>
						V�rification de la s�curit�:
					</h1>

					<div class="install-text">
						<p>
							Les param�tres PHP Serveur suivants ne sont pas optimum pour la <strong>S�curit�</strong> de votre site, il vous est recommand� de les modifier:
						</p>
						<p>
							Vous pouvez consulter cette discussion sur le <a href="http://forum.joomla.org/index.php/topic,81058.0.html" target="_blank">site officiel Joomla! </a> pour plus d'informations.
						</p>
						<div class="ctr"></div>
					</div>
							
					<div class="install-form">
						<div class="form-block" style=" border: 1px solid #cc0000; background: #ffffcc;">
							<table class="content">
							<tr>
								<td class="item">
									<ul style="margin: 0px; padding: 0px; padding-left: 5px; text-align: left; padding-bottom: 0px; list-style: none;">
										<?php
										foreach ($wrongSettingsTexts as $txt) {
											?>	
											<li style="min-height: 25px; padding-bottom: 5px; padding-left: 25px; color: red; font-weight: bold; background-image: url(../includes/js/ThemeOffice/warning.png); background-repeat: no-repeat; background-position: 0px 2px;" >
												<?php
												echo $txt;
												?>
											</li>
											<?php
										}
										?>
									</ul>
	</td>
</tr>
</table>
</div>
</div>
<div class="clr"></div>
					<?php
				}
				?>
												
				<h1>
					Configuration recommand�e:
				</h1>

<div class="install-text">
                                <p>
					Ces param�tres PHP sont recommand�s afin d'assurer 
					une pleine compatibilit� avec Joomla.
                                </p>
                                <p>
					Toutefois, Joomla devrait quand m�me fonctionner correctement s'ils ne sont pas activ�s.
                                 </p>
					<div class="ctr"></div>
</div>

<div class="install-form">
<div class="form-block">

<table class="content">
<tr>
							<td class="toggle" width="500px">
	Directive
	</td>
	<td class="toggle">
	Recommand�
	</td>
	<td class="toggle">
	Actuel
	</td>
</tr>
<?php
$php_recommended_settings = array(array ('Safe Mode','safe_mode','OFF'),
array ('Display Errors','display_errors','ON'),
array ('File Uploads','file_uploads','ON'),
array ('Magic Quotes GPC','magic_quotes_gpc','ON'),
array ('Magic Quotes Runtime','magic_quotes_runtime','OFF'),
array ('Register Globals','register_globals','OFF'),
array ('Output Buffering','output_buffering','OFF'),
array ('Session auto start','session.auto_start','OFF'),
);

foreach ($php_recommended_settings as $phprec) {
?>
<tr>
								<td class="item">
									<?php echo $phprec[0]; ?>:
								</td>
								<td class="toggle">
									<?php echo $phprec[2]; ?>:
								</td>
	<td>
									<b>
	<?php
	if ( get_php_setting($phprec[1]) == $phprec[2] ) {
	?>
											<font color="green">
	<?php
	} else {
	?>
											<font color="red">
	<?php
	}
	echo get_php_setting($phprec[1]);
	?>
										</font>
									</b>
	<td>
</tr>
<?php
}
?>
						<tr>
							<td class="item">
								Emulation de Register Globals :
							</td>
							<td class="toggle">
								OFF:
							</td>
							<td>
								<?php
								if ( RG_EMULATION ) {
									?>
									<font color="red"><b>
									<?php
								} else {
									?>
									<font color="green"><b>
									<?php
								}
								echo ((RG_EMULATION) ? 'ON' : 'OFF');
								?>
								</b>
								</font>
							<td>
						</tr>
</table>
</div>
</div>
<div class="clr"></div>

				<h1>
					Permissions des r�pertoires:
				</h1>
				
<div class="install-text">
					<p>
						Pour que Joomla fonctionne correctement, certains r�pertoires doivent �tre accessibles en lecture et �criture. 
					</p>
					<p>
						Si certains des r�pertoires list�s co-contre sont dans l'�tat "Non modifiable", alors vous devrez changer les CHMODer pour les rendre "Modifiables".
					</p>
<div class="clr">&nbsp;&nbsp;</div>
<div class="ctr"></div>
</div>

<div class="install-form">
<div class="form-block">
<table class="content">
<?php
writableCell( 'administrator/backups' );
writableCell( 'administrator/components' );
writableCell( 'administrator/modules' );
writableCell( 'administrator/templates' );
writableCell( 'cache' );
writableCell( 'components' );
writableCell( 'images' );
writableCell( 'images/banners' );
writableCell( 'images/stories' );
writableCell( 'language' );
writableCell( 'mambots' );
writableCell( 'mambots/content' );
writableCell( 'mambots/editors' );
writableCell( 'mambots/editors-xtd' );
writableCell( 'mambots/search' );
writableCell( 'mambots/system' );
writableCell( 'media' );
writableCell( 'modules' );
writableCell( 'templates' );
?>
</table>
</div>
<div class="clr"></div>
</div>
	
				
<div class="clr"></div>
</div>
<div class="clr"></div>
</div>
</div>

<div class="ctr">
		<a href="http://www.joomla.org" target="_blank">Joomla!</a> est un logiciel libre distribu� sous licence GNU/GPL..
	</div>
	
	</body>
	</html>
	<?php
}

function get_php_setting($val) {
	$r =  (ini_get($val) == '1' ? 1 : 0);
	return $r ? 'ON' : 'OFF';
}

function writableCell( $folder, $relative=1, $text='' ) {
	$writeable 		= '<b><font color="green">Modifiable</font></b>';
	$unwriteable 	= '<b><font color="red">Non-modifiable</font></b>';
	
	echo '<tr>';
	echo '<td class="item">' . $folder . '/</td>';
	echo '<td align="right">';
	if ( $relative ) {
		echo is_writable( "../$folder" ) 	? $writeable : $unwriteable;
	} else {
		echo is_writable( "$folder" ) 		? $writeable : $unwriteable;
	}
	echo '</tr>';
}
?>