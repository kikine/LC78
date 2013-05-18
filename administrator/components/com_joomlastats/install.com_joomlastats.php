<?php
/**
 * @version $Id: install.com_joomlastats.php 195 2007-03-13 23:48:57Z RoBo $
 * @package JoomlaStats
 * @copyright Copyright (C) 2004-2007 JoomlaStats.org  All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
 */

define('_JoomlaStats_V','2.2.0');

function com_install()
{
	global $database, $mosConfig_absolute_path, $mosConfig_live_site;
	global $errors;

	// autofind language
    if (defined('_A_LANG'))
		// in case there is a admin language defined - yes! this happens sometimes ;-)
		$jslang	= strtolower(_A_LANG);
	elseif (defined('_LANGUAGE'))
		$jslang = strtolower(_LANGUAGE);
	else
		$jslang = 'en';
		
	$jslang = str_replace(" ", "", $jslang);	// if there is no language value defined in the Joomla language file 
	if ($jslang == "")
		$jslang = 'en';							// then just use en language
				
	$langPath = $mosConfig_absolute_path . '/administrator/components/com_joomlastats/language/';
	$langfile = $langPath . $jslang . '.admin.ini.php';	
	
    if (file_exists($langfile))
		$JSLanguage = parse_ini_file($langfile, true);
	else	
	{
      	$JSLanguage = parse_ini_file($langPath . 'en.admin.ini.php', true);
      	echo $JSLanguage['instal']['inst09'] ." $langfile ". $JSLanguage['instal']['inst10'] ." 'en.admin.ini.php'<br />";
      	echo $JSLanguage['instal']['inst11'] ."<br /><br />";
	}
  
  	//////////////////////////////
			
	$quer		= array();
    $errors 	= array();
    $datasum	= 0;

    // check if old tables are existing 
//    $query = "SELECT count(*) AS FROM #__TFS_bots";
//    $database->setQuery($query);
//    $JS_old_bots = $database->loadResult();

//    $query = "SELECT count(*) AS FROM #__tfs_bots";
//    $database->setQuery($query);
//    $JS_old_bots1 = $database->loadResult();

//    if ($JS_old_bots || $JS_old_bots1)
//    {	// if they exist, then rename the tables
        $query = "RENAME TABLE #__TFS_bots TO #__jstats_bots, #__TFS_browsers TO #__jstats_browsers, #__TFS_configuration TO #__jstats_configuration, #__TFS_ipaddresses TO #__jstats_ipaddresses, #__TFS_iptocountry TO #__jstats_iptocountry, #__TFS_keywords TO #__jstats_keywords, #__TFS_page_request TO #__jstats_page_request, #__TFS_page_request_c TO #__jstats_page_request_c, #__TFS_pages TO #__jstats_pages, #__TFS_referrer TO #__jstats_referrer, #__TFS_search_engines TO #__jstats_search_engines, #__TFS_systems TO #__jstats_systems, #__TFS_topleveldomains TO #__jstats_topleveldomains, #__TFS_visits TO #__jstats_visits";
        $database->setQuery( $query );
        $database->query();

        $query = "RENAME TABLE #__tfs_bots TO #__jstats_bots, #__tfs_browsers TO #__jstats_browsers, #__tfs_configuration TO #__jstats_configuration, #__tfs_ipaddresses TO #__jstats_ipaddresses, #__tfs_iptocountry TO #__jstats_iptocountry, #__tfs_keywords TO #__jstats_keywords, #__tfs_page_request TO #__jstats_page_request, #__tfs_page_request_c TO #__jstats_page_request_c, #__tfs_pages TO #__jstats_pages, #__tfs_referrer TO #__jstats_referrer, #__tfs_search_engines TO #__jstats_search_engines, #__tfs_systems TO #__jstats_systems, #__tfs_topleveldomains TO #__jstats_topleveldomains, #__tfs_visits TO #__jstats_visits";
        $database->setQuery( $query );
        $database->query();
        
        $query = "ALTER IGNORE TABLE #__jstats_pages ADD `page_title` VARCHAR( 255 )";
        $database->setQuery( $query );
        $database->query();        
//	}
//	else
//	{
		// install complete new tables
		$langPath = $GLOBALS['mosConfig_absolute_path'] . '/administrator/components/com_joomlastats/';
		$langfile = $langPath . $jslang .'.db.joomlastats.inc.php';
    	if (file_exists($langfile))
			include_once($langfile);
		else	
		{      		
      		include_once($langPath . 'en.db.joomlastats.inc.php');
//	Suppress warning message for now (2.2.0 release), no one expect this feature and it probably only raise questions.
//      		echo $JSLanguage['instal']['inst09'] ." $langfile ". $JSLanguage['instal']['inst10'] ." 'en.db.joomlastats.inc.php'<br />";
//      		echo $JSLanguage['instal']['inst11'] ."<br /><br />";
		}		
//    }
    
	// however there where made some changes to the jstats table during time...
	if (empty($quer))
		$quer	= array();
	if (empty($errors))
		$errors	= array();    
		
	// we added the primairy key description later, because then we could keep the old configuration (in the past the config was reset on every update).
	//$quer[] = "ALTER TABLE #__jstats_configuration DROP PRIMARY KEY;";		
	$quer[] = "ALTER TABLE `#__jstats_configuration` ADD PRIMARY KEY (description)";
	// this index should realy speed up things...
	$quer[] = "CREATE INDEX visits_id ON `#__jstats_page_request` (`ip_id`)";
	//$quer[] = "ALTER IGNORE TABLE `#__jstats_page_request` ADD INDEX visits_id (`ip_id`)";   // RB: maybe this line can replace previous line? did no testing, so left as comment 
	$quer[] = "ALTER IGNORE TABLE `#__jstats_page_request` ADD INDEX `index_ip` (ip_id)";
	// added user awareness
	$quer[] = "ALTER IGNORE TABLE `#__jstats_visits` ADD userid INT NOT NULL AFTER ip_id";
	
	// before release 2.1.9 additional userid indexes where created unwanted, remove them. 
	$quer[] = "ALTER TABLE `mos_jstats_visits` DROP INDEX `userid_2`";
	$quer[] = "ALTER TABLE `mos_jstats_visits` DROP INDEX `userid_3`"; 
	$quer[] = "ALTER TABLE `mos_jstats_visits` DROP INDEX `userid_4`"; 
	$quer[] = "ALTER TABLE `mos_jstats_visits` DROP INDEX `userid_5`"; 
	$quer[] = "ALTER TABLE `mos_jstats_visits` DROP INDEX `userid_6`"; 
	$quer[] = "ALTER TABLE `mos_jstats_visits` DROP INDEX `userid_7`"; 
	$quer[] = "ALTER TABLE `mos_jstats_visits` DROP INDEX `userid_8`"; 
	$quer[] = "ALTER TABLE `mos_jstats_visits` DROP INDEX `userid_9`"; 
	$quer[] = "ALTER TABLE `mos_jstats_visits` DROP INDEX `userid_10`"; 
	$quer[] = "ALTER TABLE `mos_jstats_visits` DROP INDEX `userid_11`"; 
	$quer[] = "ALTER TABLE `mos_jstats_visits` DROP INDEX `userid_12`"; 
	$quer[] = "ALTER TABLE `mos_jstats_visits` DROP INDEX `userid_13`"; 
	$quer[] = "ALTER TABLE `mos_jstats_visits` DROP INDEX `userid_14`"; 
	$quer[] = "ALTER TABLE `mos_jstats_visits` DROP INDEX `userid_15`"; 
	$quer[] = "ALTER TABLE `mos_jstats_visits` DROP INDEX `userid_16`"; 
	$quer[] = "ALTER TABLE `mos_jstats_visits` DROP INDEX `userid_17`"; 
	$quer[] = "ALTER TABLE `mos_jstats_visits` DROP INDEX `userid_18`"; 
	$quer[] = "ALTER TABLE `mos_jstats_visits` DROP INDEX `userid_19`"; 
	$quer[] = "ALTER TABLE `mos_jstats_visits` DROP INDEX `userid_20`"; 
	$quer[] = "ALTER TABLE `mos_jstats_visits` DROP INDEX `userid_21`"; 
	$quer[] = "ALTER TABLE `mos_jstats_visits` DROP INDEX `userid_22`"; 
	$quer[] = "ALTER TABLE `mos_jstats_visits` DROP INDEX `userid_23`"; 
	$quer[] = "ALTER TABLE `mos_jstats_visits` DROP INDEX `userid_24`"; 
	$quer[] = "ALTER TABLE `mos_jstats_visits` DROP INDEX `userid_25`"; 
	$quer[] = "ALTER TABLE `mos_jstats_visits` DROP INDEX `userid_26`"; 
	$quer[] = "ALTER TABLE `mos_jstats_visits` DROP INDEX `userid_27`"; 
	$quer[] = "ALTER TABLE `mos_jstats_visits` DROP INDEX `userid_28`"; 
	$quer[] = "ALTER TABLE `mos_jstats_visits` DROP INDEX `userid_29`";	
	$quer[] = "ALTER IGNORE TABLE `#__jstats_visits` ADD INDEX `userid` (userid)";
			 
		
	// transfer what we have
    foreach ($quer AS $query)
    {
    	$database->setQuery($query);
        if (!$database->query()) 
        	$errors[] = array($database->getErrorMsg(), $query);
        else
			$datasum++;	// RB: do we want to use datasum? It's not yet used in the code right now?
	}



//	if (empty($complete))
//	{
		// process only if it IS ONLY a new installation!
		
		
		// RB: question to mic -> why would we want to have the images also in /a/i ?   maybe for the toolbar, but we could use paths to access images

	/*	$pathFROM 	= $GLOBALS['mosConfig_absolute_path'] . '/administrator/components/com_joomlastats/images/';
		$pathTO		= $GLOBALS['mosConfig_absolute_path'] . '/administrator/images/';

		// copies various images from components folder to admin image folder
		if( !@copy( $pathFROM . 'home.png', $pathTO . 'home.png' )) {
			$errors[] = 'Image [ home ] not copied';
		}
		if( !@copy( $pathFROM . 'home_f2.png', $pathTO . 'home_f2.png' )) {
			$errors[] = 'Image [ home_f2 ] not copied';
		}
		if( !@copy( $pathFROM . 'info.png', $pathTO . 'info.png' )) {
			$errors[] = 'Image [ info ] not copied';
		}
		..... more lines where here		
*/
//	}

    // ask for id (needed below)
    $query = "SELECT id FROM #__components WHERE link = 'option=com_joomlastats'";
    $database->setQuery( $query );
    $id = $database->loadResult();

    // set the JoomlaStats menu icon
    $database->setQuery( "UPDATE #__components SET admin_menu_img = '../administrator/components/com_joomlastats/images/joomlastats_icon.png', admin_menu_link = 'option=com_joomlastats', link = 'option=com_joomlastats' WHERE id='$id'");
    $database->query();
    
    // add additional component menu entries
    $database->setQuery("INSERT INTO `#__components` VALUES ('', '". $JSLanguage['instal']['inst03'] ."', '', 0, $id, 'option=com_joomlastats&task=stats',		'". $JSLanguage['instal']['inst03'] ."', 'com_joomlastats', 0, '../administrator/components/com_joomlastats/images/joomlastats_icon.png',	0, '')");
    $database->query();    
    $database->setQuery("INSERT INTO `#__components` VALUES ('', '". $JSLanguage['instal']['inst04'] ."', '', 0, $id, 'option=com_joomlastats&task=getconf',	'". $JSLanguage['instal']['inst04'] ."', 'com_joomlastats', 1, '../administrator/components/com_joomlastats/images/menu_config.png',		0, '')");
    $database->query();    
    $database->setQuery("INSERT INTO `#__components` VALUES ('', '". $JSLanguage['instal']['inst05'] ."', '', 0, $id, 'option=com_joomlastats&task=viewip',		'". $JSLanguage['instal']['inst05'] ."', 'com_joomlastats', 2, '../administrator/components/com_joomlastats/images/menu_switch.png',		0, '')");
    $database->query();    
    $database->setQuery("INSERT INTO `#__components` VALUES ('', '". $JSLanguage['instal']['inst06'] ."', '', 0, $id, 'option=com_joomlastats&task=summinfo',	'". $JSLanguage['instal']['inst06'] ."', 'com_joomlastats', 3, '../administrator/components/com_joomlastats/images/menu_archive.png',		0, '')");
    $database->query();    
    $database->setQuery("INSERT INTO `#__components` VALUES ('', '". $JSLanguage['instal']['inst07'] ."', '', 0, $id, 'option=com_joomlastats&task=info',		'". $JSLanguage['instal']['inst07'] ."', 'com_joomlastats', 4, '../administrator/components/com_joomlastats/images/menu_info.png',			0, '')");
    $database->query();    
    $database->setQuery("INSERT INTO `#__components` VALUES ('', '". $JSLanguage['instal']['inst08'] ."', '', 0, $id, 'option=com_joomlastats&task=uninstall',	'". $JSLanguage['instal']['inst08'] ."', 'com_joomlastats', 5, '../administrator/components/com_joomlastats/images/menu_delete.png',		0, '')");
    $database->query();


	

	// get some figures
    $query = "SELECT count(*) FROM #__jstats_bots";
    $database->setQuery($query);
    $totalbots = $database->loadResult();

    $query = "SELECT count(*) FROM #__jstats_browsers";
    $database->setQuery($query);
    $totalbrowser = $database->loadResult();

    $query = "SELECT count(*) FROM #__jstats_search_engines";
    $database->setQuery($query);
    $totalse = $database->loadResult();

    $sql = "SELECT count(*) FROM #__jstats_systems";
    $database->setQuery($query);
    $totalsys = $database->loadResult();

    $query = "SELECT count(*) FROM #__jstats_topleveldomains";
    $database->setQuery($query);
    $totaltld = $database->loadResult();

    $query = "SELECT count(*) FROM #__jstats_iptocountry";
    $database->setQuery($query);
    $totalipc = $database->loadResult();
	

?>
<table cellspacing="0" cellpadding="0" align="center" border="0" width="523"><tbody>     
<tr><td align="center" valign="top">  
	<table cellspacing="0" cellpadding="1" align="center" border="0" width="100%"><tbody>
	
	<tr><td colspan="2" valign="top" class="sectionname"><span class="sectionname"><img align="middle" height="67" width="70" src="<?php echo $mosConfig_live_site; ?>/components/com_joomlastats/images/joomlastats.png" />&nbsp;<?php echo $JSLanguage['instal']['inst01']; ?></span></td>	</tr>
	<tr><td colspan="2" class="small" valign="top">&nbsp;&nbsp;Version: <?php	echo _JoomlaStats_V; ?>	</td>	</tr>
	<tr><td colspan="2">&nbsp;</td></tr>
	
	<tr><td colspan="2"><strong><?php echo $JSLanguage['instal']['inst02']; ?>:</strong></td>	</tr>
	
    <tr><td width="30%"><?php echo $JSLanguage['info']['info02']; ?></td>			<td align="left"><?php echo $totalbots; ?></td>		</tr>
	<tr><td width="30%"><?php echo $JSLanguage['info']['info06']; ?></td>			<td align="left"><?php echo $totalbrowser; ?></td>	</tr>
	<tr><td width="30%"><?php echo $JSLanguage['info']['info07']; ?></td>			<td align="left"><?php echo $totalse; ?></td>		</tr>
	<tr><td width="30%"><?php echo $JSLanguage['info']['info08']; ?></td>			<td align="left"><?php echo $totalsys; ?></td>		</tr>
	<tr><td width="30%"><?php echo $JSLanguage['info']['info10']; ?></td>			<td align="left"><?php echo $totaltld; ?></td>		</tr>
	<tr><td width="30%"><?php echo $JSLanguage['info']['info11']; ?></td>			<td align="left"><?php echo $totalipc; ?></td>		</tr>
	<?php
	// RB: above line is displayed as: "IP-Adresses 0", but it's not the number of IP Adresses, but the number of solved countries.'
	?>
	
	<?php
	// If there are no rows in iptocountry, then display tip to do tld_loockup
	if ($totalipc < 1)
	{ 
		?>
		<tr>
			<td style="color:red;" valign="top"><?php echo $JSLanguage['info']['info17']; ?>:</td>
			<td valign="top"><span style="color:red;"><?php echo $JSLanguage['info']['info13']; ?></span><br /><?php echo $JSLanguage['info']['info14']; ?></td>	
		</tr>
		<?php
    } ?>
	
	<tr>
		<td colspan="2">
		<br />
		<?php echo $JSLanguage['info']['info12']; ?><br />
		<br />
		<br />
	</tr>
	
	<tr>
		<td colspan="2">
		<?php
		// Show warning message if no activation is available
		if (       !file_exists($GLOBALS['mosConfig_absolute_path']. '/modules/mod_jstats_activate.php')
            	&& !file_exists($GLOBALS['mosConfig_absolute_path']. '/mambots/system/bot_jstats_activate.php')
               	&& !file_exists($GLOBALS['mosConfig_absolute_path']. '/modules/mod_joostat.php')                	
               	&& !file_exists($GLOBALS['mosConfig_absolute_path']. '/mambots/system/joostat.php'))
       	{	
			?>
			
			<span style="color:red; font-weight:bold;">
			<?php echo $JSLanguage['info']['info15']; ?><br />
			</span>
			<br />
			<?php echo $JSLanguage['info']['info16']; ?><br />
			<br />
			<?php echo $JSLanguage['info']['info21']; ?><br />    
			<pre>
   &lt;?php
   if (file_exists($mosConfig_absolute_path."/components/com_joomlastats/joomlastats.inc.php")) 
      require_once($mosConfig_absolute_path."/components/com_joomlastats/joomlastats.inc.php");	
   ?&gt;
			</pre><br />			
			<?php		  
		}
		else
		{	
			?>
			<br /><?php echo $JSLanguage['info']['info22']; ?><br /><br />
			<?php	
		}
		?>
		</td>
	</tr>	
    
	
		
	<tr><td colspan="2" class="smallgrey" valign="top" align="center">JoomlaStats.org ©2003 - 2007 All rights reserved.<br />
        <a href="http://www.JoomlaStats.org">JoomlaStats</a> is Free Software released under the GNU/GPL License.<br />
    </td></tr>

	</tbody></table>
</td></tr>
</tbody></table>
<?php
}
?>