<?php
/*
	JooMap (c) Daniel Grothe
	a sitemap component for Joomla! CMS (http://www.joomla.org)
	with support for: phpshop categories, content items
	Author Website: http://www.ko-ca.com/
	Project License: GNU/GPL http://www.gnu.org/copyleft/gpl.html
*/

defined('_VALID_MOS') or die('Direct Access to this location is not allowed.');

require_once( $mainframe->getPath('front_html') );
require_once( $GLOBALS['mosConfig_absolute_path'].'/administrator/components/com_joomap/joomap.config.php' );

// load language file
if( file_exists( $GLOBALS['mosConfig_absolute_path'] . '/administrator/components/com_joomap/language/' . $GLOBALS['mosConfig_lang'] . '.php') ) {
    require_once( $GLOBALS['mosConfig_absolute_path'] . '/administrator/components/com_joomap/language/' . $GLOBALS['mosConfig_lang'] . '.php' );
} else {
    require_once( $GLOBALS['mosConfig_absolute_path'] . '/administrator/components/com_joomap/language/english.php' );
}


// output sitemap as html
$sitemap = new HtmlSitemap($joomap_cfg);
$sitemap->showSitemap();
?>