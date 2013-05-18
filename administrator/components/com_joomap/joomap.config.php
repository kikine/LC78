<?php

// This is a wrapper to load the configuration from joomap.cfg.php

defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

$_JOOMAP_CFG_FILE = '/administrator/components/com_joomap/joomap.cfg.php';
$_JOOMAP_CFG_CLASS = 'JOOMAP_CFG_1_1';
@include_once( $GLOBALS['mosConfig_absolute_path'].$_JOOMAP_CFG_FILE );
if( !class_exists($_JOOMAP_CFG_CLASS) ) {
	//if configuration doesn't exist, set defaults
	class JOOMAP_CFG_1_1 {
	var $title = 'Sitemap';
	var $classname = 'sitemap';
	var $expand_category = 1;
	var $expand_section = 1;
	var $expand_pshop = 1;
	var $show_menutitle = false;
	var $columns = 1;
	var $exlinks = 1;
	var $ext_image = 'img_grey.gif';
	var $menus = array();
	};
}
$joomap_cfg = new JOOMAP_CFG_1_1();
foreach( $joomap_cfg->menus as $key => $val) {
	$joomap_cfg->menus[$key] = (object) $val;
}
?>