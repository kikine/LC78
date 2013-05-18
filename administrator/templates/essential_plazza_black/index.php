<?php
/**
* @version $Id: index.php 4801 2006-08-28 16:10:28Z stingrey $
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
// needed to seperate the ISO number from the language file constant _ISO
$iso = explode( '=', _ISO );
// xml prolog
echo '<?xml version="1.0" encoding="'. $iso[1] .'"?' .'>';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php echo $mosConfig_sitename; ?> - Administration [Joomla]</title>
<link rel="stylesheet" href="templates/essential_plazza_black/css/template_css.css" type="text/css" />
<link rel="stylesheet" href="templates/essential_plazza_black/css/theme.css" type="text/css" />
<script language="JavaScript" src="<?php echo $mosConfig_live_site; ?>/includes/js/JSCookMenu_mini.js" type="text/javascript"></script>
<script language="JavaScript" src="<?php echo $mosConfig_live_site; ?>/administrator/includes/js/ThemeOffice/theme.js" type="text/javascript"></script>
<script language="JavaScript" src="<?php echo $mosConfig_live_site; ?>/includes/js/joomla.javascript.js" type="text/javascript"></script>
<?php
include_once( $mosConfig_absolute_path . '/editor/editor.php' );
initEditor();
?>
<meta http-equiv="Content-Type" content="text/html; <?php echo _ISO; ?>" />
<meta name="Generator" content="Joomla! Content Management System" />
<link rel="shortcut icon" href="<?php echo $mosConfig_live_site .'/images/favicon.ico';?>" />
</head>
<body style="background:#333333" onload="MM_preloadImages('images/help_f2.png','images/archive_f2.png','images/back_f2.png','images/cancel_f2.png','images/delete_f2.png','images/edit_f2.png','images/new_f2.png','images/preview_f2.png','images/publish_f2.png','images/save_f2.png','images/unarchive_f2.png','images/unpublish_f2.png','images/upload_f2.png')">

<div id="wrapper">
<div class="wrapbox">
<table width="98%" border="0" cellspacing="0" cellpadding="0" align="center" >
  <tr>
    <td width="17" align="left" valign="top"><img src="templates/essential_plazza_black/images/bgtop-left.gif" alt=" " /></td>
    <td align="left" valign="top" style="background:url(templates/essential_plazza_black/images/bgtop-mid.gif) repeat-x";><img src="templates/essential_plazza_black/images/logo.gif" alt=" " />
		
	</td>
    <td width="275" align="right" valign="top" id="toptd-r">
	
	<?php if(file_exists($mosConfig_absolute_path."/administrator/components/com_backendcontentsearch/admin.backendcontentsearch.php")){ ?>
	<img src="templates/essential_plazza_black/images/bsearch.gif" alt=" " align="left" /> 					
	<form action="index2.php?option=com_backendcontentsearch" method="post">			
	<input type="text" class="bsearch" name="searchstring" value="" class="text_area" />
			
		<input type="hidden" name="option" value="com_backendcontentsearch" />
		<input type="hidden" name="sectionid" value="" />

		<input type="hidden" name="task" value="search" />
		<input type="hidden" name="boxchecked" value="0" />
		<input type="hidden" name="hidemainmenu" value="0" />
		<input type="hidden" name="redirect" value="" />
		</form>
		<?php } else { ?>
		<img src="templates/essential_plazza_black/images/bsearch.gif" alt=" " align="left" /> 					
	<form>			
	<input type="text" class="bsearch" name="" value="désactivée" class="text_area" disabled="disabled" />
	</form>
	<?php } ?>
	</td>
  </tr>
</table>

<table width="98%" border="0" cellspacing="0" cellpadding="0" style="margin-top:5px;" align="center" >
  <tr>
    <td width="17" align="left" valign="top"><img src="templates/essential_plazza_black/images/menubg-l.gif" alt=" " /></td>
    <td align="left" valign="top" style="background:url(templates/essential_plazza_black/images/menubg-m.gif) repeat-x";><?php mosLoadAdminModule( 'fullmenu' );?>
		
	</td>
    <td width="150" align="right" valign="top" class="ddowntd-r">
	<div style="display:inline; color:#FFFFFF;">
	<?php mosLoadAdminModules( 'header' );?><a href="index2.php?option=logout" style="  font-weight: bold">
			Déconnecter</a>
		<strong><?php echo $my->username;?></strong></div>			</td>
  </tr>
</table>





</div>
	
</div>
		
		


<!-- start body -->
<div id="roundedDivWrapper" align="center">
<div class="roundedDiv" align="center">
	<div class="header"><ul><li>&nbsp;</li></ul></div>
	<div id="content">
		<div id="tb">
			<?php mosLoadAdminModule( 'pathway' );?>
			<?php mosLoadAdminModule( 'toolbar' );?>
		</div>
		<?php mosLoadAdminModule( 'mosmsg' );?>
		<?php mosMainBody_Admin(); ?>
		<div style=" clear:both"></div>
	</div>
	<div class="footer"><ul><li>&nbsp;</li></ul></div>
</div>
</div>




<div align="center" class="centermain">
	<div class="main">
	</div>
</div>

<div align="center" class="footer">
	<table width="99%" border="0">
	<tr>
		<td align="center">
			<div align="center">
				<?php echo $_VERSION->URL; ?>
			</div>
		  <div align="center" class="smallgrey">
				<?php echo $version; ?>
				<br />	<a href="http://www.joomla.org/content/blogcategory/32/66/" target="_blank">
Vérifier votre version</a><br />Backend Template Designed by <a href="http://www.templateplazza.com" target="_blank">TemplatePlazza</a>					</div>			
			<?php
			if ( $mosConfig_debug ) {
				echo '<div class="smallgrey">';
				$tend = mosProfiler::getmicrotime();
				$totaltime = ($tend - $tstart);
				printf ("Page genérée en %f secondes", $totaltime);
				echo '</div>';
			}
			?>			
		</td>
	</tr>
	</table>
</div>

<?php mosLoadAdminModules( 'debug' );?>
</body>
</html>