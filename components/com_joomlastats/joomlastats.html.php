<?php

/**
 * @version $Id: joomlastats.html.php 175 2007-01-02 00:03:09Z RoBo $
 * @package JoomlaStats
 * @copyright Copyright (C) 2004-2007 JoomlaStats Team. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
 */
	
// ensure this file is being included by a parent file
defined('_VALID_MOS') or die ('Direct Access to this location is not allowed.');
	
/**
 *   class for writing the HTML
 */ 
class HTML_joomlastats
{
	/**
 	 *   default component message 
	 */	 
	function defaultmessage()
	{
		?>
    	<div>
	       	Note to the administrator:
       		<br />
       		Public component statistics are not yet available at this time.
	       	<br /><br />
       		Please use one or more module(s) to display statistics on the frontend
	       	<br />
       	</div>
		<?php		
	}
}
?>