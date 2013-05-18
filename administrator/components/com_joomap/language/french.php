<?php
// english.php for joomap
// @package joomap
// French Translation : Joomla.fr
// edited by mic (www.mgfi.info) 2005.09.07 - 20:43
// ensure this file is being included by a parent file
defined( "_VALID_MOS" ) or die( "Vous ne pouvez pas acceder directment à ce fichier." );

// -- General ------------------------------------------------------------------
DEFINE("_JOOMAP_CFG_COM_TITLE", "Configuration de JooMap");
DEFINE("_JOOMAP_CFG_OPTIONS", "Options visuelle");
DEFINE("_JOOMAP_CFG_TITLE", "Titre");
DEFINE("_JOOMAP_CFG_CSS_CLASSNAME", "Class CSS");
DEFINE("_JOOMAP_CFG_EXPAND_CATEGORIES","Afficher les categories de Joomla");
DEFINE("_JOOMAP_CFG_EXPAND_SECTIONS","Afficher les sections de Joomla");
DEFINE("_JOOMAP_CFG_EXPAND_PHPSHOP", "Afficher les categories PhpShop");
DEFINE("_JOOMAP_CFG_SHOW_MENU_TITLES", "Afficher le titre des menus");
DEFINE("_JOOMAP_CFG_NUMBER_COLUMNS", "Nombre de colonnes");

// -- Menus --------------------------------------------------------------------
DEFINE("_JOOMAP_CFG_SET_ORDER", "Ordre d\'affichage des menus");
DEFINE("_JOOMAP_CFG_MENU_SHOW", "Afficher");
DEFINE("_JOOMAP_CFG_MENU_REORDER", "Reorder");
DEFINE("_JOOMAP_CFG_MENU_ORDER", "Trier");
DEFINE("_JOOMAP_CFG_MENU_NAME", "Menu Name");
DEFINE("_JOOMAP_CFG_DISABLE", "Click pour desactiver");
DEFINE("_JOOMAP_CFG_ENABLE", "Click pour activer");

// -- Toolbar ------------------------------------------------------------------
DEFINE("_JOOMAP_TOOLBAR_SAVE", "Enregistrer");
DEFINE("_JOOMAP_TOOLBAR_CANCEL", "Annuler");

// new by mic
	// -- admin.mambomap.php
define ('_JOOMAP_ERR_NO_LANG','Fichier langue non trouvé [ %s ] chargement de la langue : english<br />'); // %s = $GLOBALS['mosConfig_lang']
define ('_JOOMAP_SITEMAP_NAME','Plans du site');
define ('_JOOMAP_ERR_CONF_SAVE','<h2>Impossible d\'enregistrer le fichier configuration .<br />Merci de verifier les permissions.</h2><br />Fichier config: [ %s ] <br />'); // %s = $_JOOMAP_CFG_FILE

	// -- admin.html.php
define ('_JOOMAP_SHOW','Afficher');
define ('_JOOMAP_NO_SHOW','Ne pas afficher');
define ('_JOOMAP_EX_LINK','Marquer les liens externes');

// -- mambomap.html.php
define ('_JOOMAP_SHOW_AS_EXTERN_ALT','Ouvrir les liens dans une nouvelle fenetre');
define ('_JOOMAP_PREVIEW','Apercu');
?>
