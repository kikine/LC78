<?php
/*
	JooMap (c) Daniel Grothe
	a sitemap component for Joomla! CMS (http://www.joomla.org)
	with support for: phpshop categories, content items
	Author Website: http://www.ko-ca.com
	Project License: GNU/GPL http://www.gnu.org/copyleft/gpl.html
	edited by mic (www.mgfi.info) 2005.09.08 - 14:20
*/

// ensure this file is being included by a parent file
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

// load language file
if( file_exists( $GLOBALS['mosConfig_absolute_path'] . '/administrator/components/com_joomap/language/' . $GLOBALS['mosConfig_lang'] . '.php') ) {
	require_once( $GLOBALS['mosConfig_absolute_path'] . '/administrator/components/com_joomap/language/' . $GLOBALS['mosConfig_lang'] . '.php' );
} else {
	echo 'Language file [ '. $GLOBALS['mosConfig_lang'] .' ] not found, using default language: english<br />';
	require_once( $GLOBALS['mosConfig_absolute_path'] . '/administrator/components/com_joomap/language/english.php' );
}
// load html output class
require_once( $mainframe->getPath( 'admin_html' ) );
// load joomap configuration
require_once( $GLOBALS['mosConfig_absolute_path'] . '/administrator/components/com_joomap/joomap.config.php' );

// load request data
$task 		= mosGetParam( $_REQUEST, 'task', array(0) );
$type 		= mosGetParam( $_POST, 'type', '' );
$cid 		= mosGetParam( $_POST, 'cid', '' );

// populate the $menus array
// necessary if the cfg was not saved at least once before, or if a new menu has been created
function populateMenus() {
	global $joomap_cfg;
	$menutypes = mosAdminMenus::menutypes();
	$cfg_menus = &$joomap_cfg->menus;
	foreach ( $menutypes as $key => $val ) {
		if( !isset($cfg_menus[$val]) ) {
			$cfg_menus[$val]->ordering = $key+1;
			$cfg_menus[$val]->show = false;
		}
	}
}
populateMenus();

//DEBUG: dump POST input
//echo '<pre style="padding:2px;width:100%;text-align:left;border:1px solid red;">'.print_r($_POST,true).'</pre>';

switch ($task) {
	case 'save':
		saveOptions( );
		break;
	case 'cancel':
		mosRedirect( 'index2.php' );
		break;
	case 'publish':
		toggleMenu( $cid[0], true );
		break;
	case 'unpublish':
		toggleMenu( $cid[0], false );
		break;
	case 'orderup':
		orderMenu( $cid[0], -1 );
		break;
	case 'orderdown':
		orderMenu( $cid[0], 1 );
		break;
	default:
		showMenu( );
		break;
}

/* Helper function used to sort menus with usort */
function cmpOrdering($a, $b) {
	if( @$a->ordering == @$b->ordering) {
		return 0;
	}
	return @$a->ordering < @$b->ordering ? -1 : 1;
}

/* Show the list of menus */
function showMenu( ) {
	global $mainframe, $mosConfig_list_limit, $joomap_cfg;

	$limit 		= $mainframe->getUserStateFromRequest( "viewlistlimit", 'limit', $mosConfig_list_limit );
	$limitstart = $mainframe->getUserStateFromRequest( "viewlimitstart", 'limitstart', 0 );

	$menutypes 	= mosAdminMenus::menutypes();
	$total		= count( $menutypes );
	$cfg_menus	= &$joomap_cfg->menus;
	$i			= 0;

	foreach ( $menutypes as $key => $val ) {
		$menus[$i]->id = $key;
		$menus[$i]->type = $val;
		$menus[$i]->checked_out = false;

		$menus[$i]->ordering = $cfg_menus[$val]->ordering;
		$menus[$i]->show = $cfg_menus[$val]->show;
		++$i;
	}

	usort($menus, 'cmpOrdering');

	require_once( $GLOBALS['mosConfig_absolute_path'] . '/administrator/includes/pageNavigation.php' );
	$pageNav = new mosPageNav( $total, $limitstart, $limit  );

	// external link image
	$javascript = 'onchange="changeDisplayImage();"';
    $directory = '/components/com_joomap/images';
    $lists['imageurl'] = mosAdminMenus::Images( 'imageurl', $joomap_cfg->ext_image, $javascript, $directory );

	HTML_joomap::show( $menus, $pageNav, $lists );
}

function saveOptions( ) {
	global $joomap_cfg;

	// debug
	/*
	echo '<strong>[debug - admin - save cfg before]</strong><br />';
	print_r($joomap_cfg);
	echo '<br /><strong>[debug - admin - save cfg before ............... end]</strong><br />';
	*/
	$joomap_cfg->title = mosGetParam( $_POST, 'title', _JOOMAP_SITEMAP_NAME );
	$joomap_cfg->classname = mosGetParam( $_POST, 'classname', 'sitemap' );
	$joomap_cfg->expand_category = mosGetParam( $_POST, 'expand_category', '0' );
	$joomap_cfg->expand_section = mosGetParam( $_POST, 'expand_section', '0' );
	$joomap_cfg->expand_pshop = mosGetParam( $_POST, 'expand_pshop', '0' );
	$joomap_cfg->show_menutitle = mosGetParam( $_POST, 'show_menutitle', '0' );
	$joomap_cfg->columns = intval(mosGetParam( $_POST, 'columns', '1' ));
	$joomap_cfg->exlinks = intval(mosGetParam( $_POST, 'exlinks', '0' ));
	$joomap_cfg->ext_image = mosGetParam( $_POST, 'imageurl', 'img_red.gif' );
	if( $joomap_cfg->columns < 1 ) $joomap_cfg->columns = 1;
	
	// debug
	/*
	echo '<br /><strong>[debug - admin - after calling posts]</strong><br />';
	print_r($joomap_cfg);
	*/

	$menutypes 	= mosAdminMenus::menutypes();
	$order 		= mosGetParam( $_POST, 'order', '0' );
	$cfg_menus	= &$joomap_cfg->menus;

	foreach($order as $key => $val) {
		$type = $menutypes[$key];
		$cfg_menus[$type]->ordering = $val;
	}

	saveConfig($joomap_cfg);

	showMenu();
}

/* Move the display order of a record */
function orderMenu( $uid, $inc ) {
	global $joomap_cfg;

	$cfg_menus	= &$joomap_cfg->menus;
	$menutypes 	= mosAdminMenus::menutypes();

	$type = $menutypes[$uid];
	$cfg_menus[$type]->ordering = $cfg_menus[$type]->ordering + $inc;

	foreach ( $menutypes as $key => $val) {
		if( ($val != $type) && ($cfg_menus[$val]->ordering == $cfg_menus[$type]->ordering) ) {
			$cfg_menus[$val]->ordering -= $inc;
		}
	}

	saveConfig($joomap_cfg);

	showMenu();
}

function toggleMenu( $uid, $show ) {
	global $joomap_cfg;

	$cfg_menus	= &$joomap_cfg->menus;
	$menutypes 	= mosAdminMenus::menutypes();

	$type = $menutypes[$uid];
	$cfg_menus[$type]->show = $show;

	saveConfig($joomap_cfg);

	showMenu();
}

/* save the configuration file */
function saveConfig( $config ) {
	global $_JOOMAP_CFG_FILE, $_JOOMAP_CFG_CLASS;
	global $my;

	//make order numbers contiguous
	$cfg_menus = &$config->menus;
	uasort($cfg_menus, 'cmpOrdering');
	$i = 0;
	foreach($cfg_menus as $key => $val)
		$cfg_menus[$key]->ordering = ++$i;

	// QUICKFIX: var_export() cannot export objects ...
	foreach($cfg_menus as $key => $val)
		$cfg_menus[$key] = (array) $cfg_menus[$key];

	$vars = get_object_vars($config);
	//static header
	$out = "<?php\n"
		. "// Last Edit: " . strftime("%a, %Y-%b-%d %H:%M:%S") . "\n"
        . "// Edited by: " . $my->username . "\n"
		."defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );\n"
		."if( !class_exists('{$_JOOMAP_CFG_CLASS}') ) {\n"
		."class {$_JOOMAP_CFG_CLASS} {\n";

	//configuration variables
	foreach($vars as $key => $value){
		if( is_array( $value ) ){
			$out .= "var \${$key} = ".var_export($value, true).";\n" ;
		}else{
			$out .= "var \${$key} = \"{$value}\";\n" ;
		}
	}

	//static footer
	$out .= "}}\n"
		."?>\n";

	// REVERT QUICKFIX: var_export() cannot export objects ...
	foreach($cfg_menus as $key => $val)
		$cfg_menus[$key] = (object) $cfg_menus[$key];

	//try to overwrite configuration file
	$fp = fopen($GLOBALS['mosConfig_absolute_path'].$_JOOMAP_CFG_FILE, "w");
	if ($fp) {
    	fputs($fp, $out, strlen($out));
     	fclose ($fp);
    	return true;
  	} else {
  		die( _JOOMAP_ERR_CONF_SAVE );
  	}
  	return false;
}
?>
