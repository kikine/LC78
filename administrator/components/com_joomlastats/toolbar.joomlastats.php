<?PHP
	/**
	* @version $Id: toolbar.joomlastats.php 186 2007-01-18 22:39:33Z RoBo $
	* @package JoomlaStats
	* @copyright Copyright (C) 2004-2007 JoomlaStats Team. All rights reserved.
	* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
	*/
	
	// ensure this file is being included by a parent file
	defined('_VALID_MOS') or die ('Direct Access to this location is not allowed.');

	require_once($mainframe->getPath('toolbar_html'));
		
	switch ($task)
	{
		case "tldlookup":
			// no menu
			break;
		case "getconf":
		case "purgedb":
			menu_joomlastats::CONFIG_MENU();
			break;
		case "uninstall":
			menu_joomlastats::UNINSTALL_MENU();
			break;
		case "summinfo":
			menu_joomlastats::SUMMARISE_MENU();
			break;
		case "jsbackup":
			menu_joomlastats::BACKUP_MENU();
			break;
						
		case 'summtask';
		default:
			menu_joomlastats::DEFAULT_MENU();
			break;		
	}	
?>