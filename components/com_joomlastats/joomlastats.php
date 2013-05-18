<?php
   /**
	* @version $Id: joomlastats.php 175 2007-01-02 00:03:09Z RoBo $
	* @package JoomlaStats
	* @copyright Copyright (C) 2004-2006 PJH Diender. All rights reserved.
	* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
	*/
	
	//ensure this file is being included by a parent file
	defined('_VALID_MOS') or die ('Direct Access to this location is not allowed.');

	require_once($mainframe->getPath('front_html', 'com_joomlastats'));
		
	switch (strtolower($task))
	{
		default:
			// noyetimplemented(); // mic: disabled - do not really need any message at frontend
			break;
	}
	
	function noyetimplemented()
	{
		global $mainframe;
		
		// Dynamic Page Title
		$mainframe->SetPageTitle( "not yet implemented" );
		
		HTML_joomlastats::defaultmessage();
	}	
?>