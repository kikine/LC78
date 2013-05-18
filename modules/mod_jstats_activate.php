<?php
/**
* @version $Id: mod_jstats_activate.php,v 1.3 2006/12/28 22:39:39 mic Exp $
* @package Activate JoomlaStats
* @copyright (C) 2007 JoomlaStats Team
* first version by:  Mic
* @license Creative Commons http://creativecommons.org/licenses/by-nc-sa/2.0/at
*/

/*
 * Delivers an alternative for adding these lines to template (just below <body>)
 * 
   <?PHP
     if (file_exists($mosConfig_absolute_path."/components/com_joomlastats/joomlastats.inc.php"))
     require_once($mosConfig_absolute_path."/components/com_joomlastats/joomlastats.inc.php");
   ?>
 *  
 */

/** ensure this file is being included by a parent file */
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

if (defined('_JSTATS_ACTIVATE'))
	return;
else
{
    define('_JSTATS_ACTIVATE', 1);

	$query = "SELECT published \n"
	. "FROM #__modules \n"
	. "WHERE module = 'mod_jstats_activate'";
	$database->setQuery($query);
    $published = $database->loadResult();

    if ($published)
    {
    	echo "\n" . '<!-- JoomlaStatsActivated -->' . "\n";
    	$fileJS 	= $GLOBALS['mosConfig_absolute_path'] . '/components/com_joomlastats/joomlastats.inc.php';	// org
    	$fileTFSM	= $GLOBALS['mosConfig_absolute_path'] . '/components/com_tfsformambo/tfsformambo.php';		// tfsm
    	$fileJSM	= $GLOBALS['mosConfig_absolute_path'] . '/components/com_joomlastats/joomlastats.php';		// mgfi.ver

		if (file_exists($fileJS))
			require_once($fileJS);
        elseif (file_exists($fileTFSM)) 
        	require_once($fileTFSM);
        elseif (file_exists($fileJSM)) 
        	require_once($fileJSM );
    }
}
?>