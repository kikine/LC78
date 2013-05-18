<?PHP
	/**
	* @version $Id: toolbar.joomlastats.html.php 187 2007-01-26 23:37:30Z RoBo $
	* @package JoomlaStats
	* @copyright Copyright (C) 2004-2007 JoomlaStats Team. All rights reserved.
	* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
	*/
	
	// ensure this file is being included by a parent file
	defined('_VALID_MOS') or die ('Direct Access to this location is not allowed.');

	class menu_joomlastats 
	{
		/*
		 *  Draws the menu for configuration of JoomlaStats
		 */
		 
		function CONFIG_MENU()
		{
			global $task, $JSLanguage, $mosConfig_absolute_path;
			
			mosMenuBar::startTable();
			mosMenuBar::save('saveconf');
			mosMenuBar::spacer();
			mosMenuBar::custom('stats', '../components/com_joomlastats/images/home.png', '../components/com_joomlastats/images/home_f2.png', $JSLanguage['toolbar']['tb01'],false);
			mosMenuBar::spacer();
			
			if ($task != 'tldlookup')
			{
				mosMenuBar::custom('tldlookup', '../components/com_joomlastats/images/search.png', '../components/com_joomlastats/images/search_f2.png', $JSLanguage['toolbar']['tb05'], false);
				mosMenuBar::spacer();
			}
						
			if ($task != 'uninstall')
			{
        		mosMenuBar::spacer();
	        	mosMenuBar::custom('uninstall', '../components/com_joomlastats/images/delete.png', '../components/com_joomlastats/images/delete_f2.png', $JSLanguage['toolbar']['tb07'], false);
        	}
			mosMenuBar::spacer();
			
			if (file_exists($mosConfig_absolute_path ."/administrator/components/com_joomlastats/help/screen.joomlastats.config_". $JSLanguage['translation']['trans00'] .".html"))
	    		$helpfile = "screen.joomlastats.config_". $JSLanguage['translation']['trans00'] .".html";
	    	else
				$helpfile = "screen.joomlastats.config_en.html";            
			mosMenuBar::help($helpfile, true);			mosMenuBar::endTable();			
		}
		
		
		function UNINSTALL_MENU()
		{
			global $JSLanguage;
			
			mosMenuBar::startTable();
			mosMenuBar::custom('uninstalltask', '../components/com_joomlastats/images/delete.png', '../components/com_joomlastats/images/delete_f2.png', $JSLanguage['toolbar']['tb07'], false);
			mosMenuBar::spacer();
			mosMenuBar::custom('stats', 'back.png', 'back_f2.png', _CMN_BACK, false);
			mosMenuBar::spacer();
			mosMenuBar::endTable();
		}
		
		function SUMMARISE_MENU()
		{
			mosMenuBar::startTable();
			mosMenuBar::custom('summtask', '../components/com_joomlastats/images/archive.png','../components/com_joomlastats/images/archive_f2.png', _CMN_ARCHIVE, false);
			mosMenuBar::spacer();
			mosMenuBar::custom('stats', 'back.png', 'back_f2.png', _CMN_BACK, false);
			mosMenuBar::spacer();
			mosMenuBar::endTable();
		}
		
		function BACKUP_MENU()
		{
    		global $JSLanguage;

        	mosMenuBar::startTable();
	        mosMenuBar::custom('getconf', '../components/com_joomlastats/images/config.png', '../components/com_joomlastats/images/config_f2.png', $JSLanguage['toolbar']['tb02'], false);
    	    mosMenuBar::custom('stats', '../components/com_joomlastats/images/home.png', '../components/com_joomlastats/images/home_f2.png', $JSLanguage['toolbar']['tb01'], false);
        	mosMenuBar::spacer();
	        mosMenuBar::endTable();
    	}
    
		function DEFAULT_MENU()
		{
			global $task, $JSLanguage, $mosConfig_absolute_path;		
			
			
			mosMenuBar::startTable();
			
			if (substr($task, 0, 1) != 'r')
			{
				mosMenuBar::custom('stats', '../components/com_joomlastats/images/home_f2.png', '../components/com_joomlastats/images/home_f2.png', $JSLanguage['toolbar']['tb01'], false);
				mosMenuBar::spacer();
			}
			
			if ($task != 'getconf' )
			{
				mosMenuBar::custom('getconf', '../components/com_joomlastats/images/config_f2.png', '../components/com_joomlastats/images/config_f2.png', $JSLanguage['toolbar']['tb02'], false);
				mosMenuBar::spacer();
			}
			
			if ($task != 'viewip')
			{
				mosMenuBar::custom('viewip', '../components/com_joomlastats/images/switch.png', '../components/com_joomlastats/images/switch_f2.png', $JSLanguage['toolbar']['tb03'], false);
				mosMenuBar::spacer();
			}
			
			if ($task != 'summtask')
			{
				mosMenuBar::custom('summtask', '../components/com_joomlastats/images/archive_f2.png', '../components/com_joomlastats/images/archive_f2.png', $JSLanguage['toolbar']['tb04'], false);
				mosMenuBar::spacer();
			}
			
			// mic: too dangerous here - let em call from the config menu!
			/*
	        if( $task != 'summinfo' ) {
        		mosMenuBar::custom( 'summinfo','archive.png','archive_f2.png', $JSLanguage['toolbar']['tb04'], false);
	        	mosMenuBar::spacer();
	        }
        	mosMenuBar::custom('jsbackup', 'archive.png', 'archive_f2.png', $JSLanguage['toolbar']['tb09'] , false);
        	mosMenuBar::spacer();
			*/
			
			
	        if ($task != 'info')
	        {
	        	mosMenuBar::custom('info', '../components/com_joomlastats/images/info.png', '../components/com_joomlastats/images/info_f2.png', $JSLanguage['toolbar']['tb06'], false);
				mosMenuBar::spacer();
	        }
			      
	    	if (file_exists($mosConfig_absolute_path ."/administrator/components/com_joomlastats/help/screen.joomlastats.config_". $JSLanguage['translation']['trans00'] .".html"))
	    		$helpfile = "screen.joomlastats.config_". $JSLanguage['translation']['trans00'] .".html";
	    	else
				$helpfile = "screen.joomlastats.config_en.html";            
			mosMenuBar::help($helpfile, true);
	        mosMenuBar::spacer();        
			
			mosMenuBar::endTable();
		}
	}	
?>