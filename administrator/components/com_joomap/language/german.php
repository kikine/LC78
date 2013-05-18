<?php
// germanf.php fuer joomap
// @package joomap
// edited by mic (www.mgfi.info) 2005.09.07 - 20:42
// ensure this file is being included by a parent file
defined( "_VALID_MOS" ) or die( "Direct Access to this location is not allowed." );

// -- General ------------------------------------------------------------------
DEFINE("_JOOMAP_CFG_COM_TITLE", "JooMap Konfiguration");
DEFINE("_JOOMAP_CFG_OPTIONS", "Anzeige Einstellungen");
DEFINE("_JOOMAP_CFG_TITLE", "Titel");
DEFINE("_JOOMAP_CFG_CSS_CLASSNAME", "CSS Klassenname");
DEFINE("_JOOMAP_CFG_EXPAND_CATEGORIES","Kategorien ausklappen");
DEFINE("_JOOMAP_CFG_EXPAND_SECTIONS","Bereiche ausklappen");
DEFINE("_JOOMAP_CFG_EXPAND_PHPSHOP", "PhpShop Kategorien ausklappen");
DEFINE("_JOOMAP_CFG_SHOW_MENU_TITLES", "Men&uuml; Titel anzeigen");
DEFINE("_JOOMAP_CFG_NUMBER_COLUMNS", "Anzahl der Spalten");

// -- Menus --------------------------------------------------------------------
DEFINE("_JOOMAP_CFG_SET_ORDER", "Men&uuml; Anzeige Reihenfolge");
DEFINE("_JOOMAP_CFG_MENU_SHOW", "Anzeigen");
DEFINE("_JOOMAP_CFG_MENU_REORDER", "Umordnen");
DEFINE("_JOOMAP_CFG_MENU_ORDER", "Reihenfolge");
DEFINE("_JOOMAP_CFG_MENU_NAME", "Men&uuml; Name");
DEFINE("_JOOMAP_CFG_DISABLE", "Ausschalten");
DEFINE("_JOOMAP_CFG_ENABLE", "Einschalten");

// -- Toolbar ------------------------------------------------------------------
DEFINE("_JOOMAP_TOOLBAR_SAVE", "Speichern");
DEFINE("_JOOMAP_TOOLBAR_CANCEL", "Abbrechen");

// new by mic
	// -- admin.mambomap.php
define ('_JOOMAP_ERR_NO_LANG','Sprachendatei [ %s ] nicht gefunden, verwende stattdessen Englisch<br />');// %s = $GLOBALS['mosConfig_lang']
define ('_JOOMAP_SITEMAP_NAME','Seiten&uuml;bersicht');
define ('_JOOMAP_ERR_CONF_SAVE','<h2>Fehler bei Konfigurationsspeicherung!<br />Bitte Schreibrechte &uuml;berpr&uuml;fen</h2><br />Konfigurationsdatei: [ % ]<br />');// %s = $_JOOMAP_CFG_FILE

	// -- admin.html.php
define ('_JOOMAP_SHOW','Anzeigen');
define ('_JOOMAP_NO_SHOW','Keine Anzeige');
define ('_JOOMAP_EX_LINK','Externe Links Markieren');

// -- mambomap.html.php
define ('_JOOMAP_SHOW_AS_EXTERN_ALT','Link &ouml;ffnet neues Fenster');
define ('_JOOMAP_PREVIEW','Vorschau');
?>