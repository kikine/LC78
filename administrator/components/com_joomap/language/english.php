<?php
// english.php for joomap
// @package joomap
// edited by mic (www.mgfi.info) 2005.09.07 - 20:43
// ensure this file is being included by a parent file
defined( "_VALID_MOS" ) or die( "Direct Access to this location is not allowed." );

// -- General ------------------------------------------------------------------
DEFINE("_JOOMAP_CFG_COM_TITLE", "JooMap Configuration");
DEFINE("_JOOMAP_CFG_OPTIONS", "Display Options");
DEFINE("_JOOMAP_CFG_TITLE", "Title");
DEFINE("_JOOMAP_CFG_CSS_CLASSNAME", "CSS Classname");
DEFINE("_JOOMAP_CFG_EXPAND_CATEGORIES","Expand Content Categories");
DEFINE("_JOOMAP_CFG_EXPAND_SECTIONS","Expand Content Sections");
DEFINE("_JOOMAP_CFG_EXPAND_PHPSHOP", "Expand PhpShop Categories");
DEFINE("_JOOMAP_CFG_SHOW_MENU_TITLES", "Show Menu Titles");
DEFINE("_JOOMAP_CFG_NUMBER_COLUMNS", "Number of Columns");

// -- Menus --------------------------------------------------------------------
DEFINE("_JOOMAP_CFG_SET_ORDER", "Set Menu Display Order");
DEFINE("_JOOMAP_CFG_MENU_SHOW", "Show");
DEFINE("_JOOMAP_CFG_MENU_REORDER", "Reorder");
DEFINE("_JOOMAP_CFG_MENU_ORDER", "Order");
DEFINE("_JOOMAP_CFG_MENU_NAME", "Menu Name");
DEFINE("_JOOMAP_CFG_DISABLE", "Click to disable");
DEFINE("_JOOMAP_CFG_ENABLE", "Click to enable");

// -- Toolbar ------------------------------------------------------------------
DEFINE("_JOOMAP_TOOLBAR_SAVE", "Save");
DEFINE("_JOOMAP_TOOLBAR_CANCEL", "Cancel");

// new by mic
	// -- admin.mambomap.php
define ('_JOOMAP_ERR_NO_LANG','No such language [ %s ] found, loaded default language: english<br />'); // %s = $GLOBALS['mosConfig_lang']
define ('_JOOMAP_SITEMAP_NAME','Sitemap');
define ('_JOOMAP_ERR_CONF_SAVE','<h2>Failed to save the configuration file .<br />Please verify/fix write permissions.</h2><br />Config file: [ %s ] <br />'); // %s = $_JOOMAP_CFG_FILE

	// -- admin.html.php
define ('_JOOMAP_SHOW','Show');
define ('_JOOMAP_NO_SHOW','Dont\'t Show');
define ('_JOOMAP_EX_LINK','Mark External Links');

// -- mambomap.html.php
define ('_JOOMAP_SHOW_AS_EXTERN_ALT','Link opens new window');
define ('_JOOMAP_PREVIEW','Preview');
?>