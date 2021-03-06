<?php
/**
* @version $Id: login.php 3551 2006-05-18 20:23:01Z stingrey $
* @package Joomla
* @copyright Copyright (C) 2005 Open Source Matters. All rights reserved.
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
* Joomla! is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
* See COPYRIGHT.php for copyright notices and details.
*/

/** ensure this file is being included by a parent file */
defined( '_VALID_MOS' ) or die( 'Restricted access' );

$tstart = mosProfiler::getmicrotime();
?>
<?php echo "<?xml version=\"1.0\"?>\r\n"; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php echo $mosConfig_sitename; ?> - Administration [Joomla]</title>
<meta http-equiv="Content-Type" content="text/html; <?php echo _ISO; ?>" />
<style type="text/css">
@import url(templates/essential_plazza_black/css/admin_login.css);
</style>
<script language="javascript" type="text/javascript">
	function setFocus() {
		document.loginForm.usrname.select();
		document.loginForm.usrname.focus();
	}
</script>
<link rel="shortcut icon" href="<?php echo $mosConfig_live_site .'/images/favicon.ico';?>" />
</head>
<body onload="setFocus();" >
<div id="ctr" align="center">
	<?php
	// handling of mosmsg text in url
	include_once( $mosConfig_absolute_path .'/administrator/modules/mod_mosmsg.php' ); 
	?>
	<div class="login">
		<div class="login-form">
					<form action="index.php" method="post" name="loginForm" id="loginForm">
			
				<div class="inputlabel">Identifiant</div>
				<input name="usrname" type="text" class="inputboxusr" size="15" />
				<div class="inputlabel">Mot de passe</div>
				<input name="pass" type="password" class="inputboxpwd" size="15" />
				<div align="left"><input type="submit" name="submit" class="button" value="Ouvrir" /></div>
			
			</form>
		</div>
		<div class="clr"></div>
	</div>
</div>
<noscript style="color:#FF0000; font-weight:bold; text-align:center;">
<div align="center">
!Attention! le Javascript doit �tre activ�e pour fonctionner correctement.
</div></noscript>
<div class="footer" align="center">
  <div align="center">
		<?php echo $_VERSION->URL; ?>
Desigh du Template par <a href="http://www.templateplazza.com" target="_blank">TemplatePlazza</a>	</div>
</div>
</body>
</html>