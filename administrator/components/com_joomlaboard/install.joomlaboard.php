<?php
/**
* install.joomlaboard.php 
* @package com_joomlaboard
* @copyright (C) 2000 - 2006 TSMF / Jan de Graaff / All Rights Reserved
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* @author TSMF & Jan de Graaff
* Joomla! is Free Software
**/

// Dont allow direct linking
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

/**
 * Function that upgrades joomlaboard database tables
 * 
 * @param dbo database object
 * @return boolean
 */
function jbTablesUpdate(&$database,$bool_jbNeedUpgrade) {
	// determine version
	// $database->setQuery('SELECT `value` FROM #__sb_config WHERE `key`=version');
	// $str_jb_version=$database->loadResult();
	// if (empty($str_jb_version)) {
	//	return false;
	// }
	if ($bool_jbNeedUpgrade) {
		$database->setQuery('ALTER TABLE `#__sb_categories` DROP INDEX `catid` , ADD PRIMARY KEY (`id` )');
		if(!$database->query())
			return false;
		$database->setQuery('ALTER TABLE `#__sb_categories` ADD INDEX `published_pubaccess_id` (`published` , `pub_access` , `id` )');
		if(!$database->query())
			return false;
		$database->setQuery('ALTER TABLE `#__sb_messages` DROP INDEX `id`');
		if(!$database->query())
			return false;
		$database->setQuery('ALTER TABLE `#__sb_messages` DROP INDEX `time_2`');
		$database->query();
		$database->setQuery('ALTER TABLE `#__sb_messages` ADD INDEX `hold_time` ( `hold` , `time` )');
		if(!$database->query())
			return false;	
		$database->setQuery('ALTER TABLE `#__sb_messages_text` DROP INDEX `mesid` , ADD PRIMARY KEY ( `mesid` )');
		if(!$database->query())
			return false;	
		$database->setQuery('ALTER TABLE `#__sb_attachments` DROP INDEX `mesid_2`');
		if(!$database->query())
			return false;	
		$database->setQuery('ALTER TABLE `#__sb_moderation` DROP INDEX `catid`');
		if(!$database->query())
			return false;
		return true;
	}
	else {
		$database->setQuery('SELECT * FROM #__sb_smileys');
		if ($database->query() && $database->getNumRows() > 0 )
			return true;
		$database->setQuery("INSERT INTO `#__sb_smileys` VALUES (1, 'B)', 'cool.png', 'cool-grey.png', 1),
				(8, ';)', 'wink.png', 'wink-grey.png', 1),
				(3, ':)', 'smile.png', 'smile-grey.png', 1),
				(10, ':P', 'tongue.png', 'tongue-grey.png', 1),
				(6, ':laugh:', 'laughing.png', 'laughing-grey.png', 1),
				(17, ':ohmy:', 'shocked.png', 'shocked-grey.png', 1),
				(22, ':sick:', 'sick.png', 'sick-grey.png', 1),
				(14, ':angry:', 'angry.png', 'angry-grey.png', 1),
				(25, ':blink:', 'blink.png', 'blink-grey.png', 1),
				(2, ':(', 'sad.png', 'sad-grey.png', 1),
				(16, ':unsure:', 'unsure.png', 'unsure-grey.png', 1),
				(27, ':kiss:', 'kissing.png', 'kissing-grey.png', 1),
				(29, ':woohoo:', 'w00t.png', 'w00t-grey.png', 1),
				(21, ':lol:', 'grin.png', 'grin-grey.png', 1),
				(23, ':silly:', 'silly.png', 'silly-grey.png', 1),
				(35, ':pinch:', 'pinch.png', 'pinch-grey.png', 1),
				(30, ':side:', 'sideways.png', 'sideways-grey.png', 1),
				(34, ':whistle:', 'whistling.png', 'whistling-grey.png', 1),
				(33, ':evil:', 'devil.png', 'devil-grey.png', 1),
				(31, ':S', 'dizzy.png', 'dizzy-grey.png', 1),
				(26, ':blush:', 'blush.png', 'blush-grey.png', 1),
				(7, ':cheer:', 'cheerful.png', 'cheerful-grey.png', 1),
				(18, ':huh:', 'wassat.png', 'wassat-grey.png', 1),
				(19, ':dry:', 'ermm.png', 'ermm-grey.png', 1),
				(4, ':-)', 'smile.png', 'smile-grey.png', 0),
				(5, ':-(', 'sad.png', 'sad-grey.png', 0),
				(9, ';-)', 'wink.png', 'wink-grey.png', 0),
				(37, ':D', 'laughing.png', 'laughing-grey.png', 0),
				(12, ':X', 'sick.png', 'sick-grey.png', 0),
				(13, ':x', 'sick.png', 'sick-grey.png', 0),
				(15, ':mad:', 'angry.png', 'angry-grey.png', 0),
				(20, ':ermm:', 'ermm.png', 'ermm-grey.png', 0),
				(24, ':y32b4:', 'silly.png', 'silly-grey.png', 0),
				(28, ':rolleyes:', 'blink.png', 'blink-grey.png', 0),
				(32, ':s', 'dizzy.png', 'dizzy-grey.png', 0),
				(36, ':p', 'tongue.png', 'tongue-grey.png', 0)");
				if (!$database->query())
					return false;
	}
	return true;
}
/**
 * 	Function to set up icon in backend
 * 
 * @param dbo database object
 * @return boolean
 */
function jbIconSetup(&$database) {
	$database->setQuery( "SELECT id FROM #__components WHERE admin_menu_link = 'option=com_joomlaboard'" );
	$id = $database->loadResult();

	//add new admin menu images
	$database->setQuery( "UPDATE #__components " .
                        "SET admin_menu_img  = '../administrator/components/com_joomlaboard/images/sbmenu.png'" .
                        ",   admin_menu_link = 'option=com_joomlaboard' " .
                        "WHERE id='$id'");
	if ($database->query())
		return true;
	else
		return false;
}


function jbConfigurationUpdate(&$database,$bool_jbNeedUpgrade) {
	global $mainframe;
	
	if ($bool_jbNeedUpgrade) {
		// normally we just add the new config variables here from now on and update the version number.
	}
	require_once($mainframe->getCfg( 'absolute_path' ).'/administrator/components/com_joomlaboard/joomlaboard_config.php');
	foreach ($sbConfig as $KEY=>$VALUE) {
		if (get_magic_quotes_gpc()) {
       		$VALUE = stripslashes($VALUE);
       		$KEY = stripslashes($KEY);
   		}
		$KEY=$database->getEscaped($KEY);
		$VALUE=$database->getEscaped($VALUE);
		$database->setQuery('SELECT `jbvalue` FROM #__sb_config WHERE `jbkey`=\''.$KEY.'\'');
		if ($database->loadResult()=='') {
   			$database->setQuery('INSERT INTO #__sb_config VALUES (\''.$KEY.'\',\''.$VALUE.'\')');
			if (!$database->query())
				return false;
		}
	}
	return true;		
}
function com_install() {
	global $database;
	$bool_jbNeedUpgrade=true;
	$database->setQuery('SHOW KEYS FROM #__sb_categories');
	foreach ($database->loadObjectList() as $row) {
		if ($row->Key_name=='published_pubaccess_id')
			$bool_jbNeedUpgrade=false;
	}
	

	
?>
<div>
	<span style="float: left;text-align: left;min-width:251px;width:25%"><img src="components/com_joomlaboard/images/logo.png" alt="Joomlaboard logo" /></span>
	<span style="float: right;text-align: left;width:75%">
		<strong>Joomlaboard Forum Component</strong> <em>for Joomla! 1.0.x and 1.5.x</em><br />
		&copy; 2001 - 2006 <a href="http://www.tsmf.net" target="_blank">TSMF</a><br />
		All rights reserved<br /><br />
		Joomlaboard is released under the <a href="index2.php?option=com_admisc&amp;task=license">GNU/GPL</a> license.
	</span>
	<div style="clear:both">&nbsp;</div>
</div>
<div style="text-align:left">
<h3 class="title">Installation proces:</h3>
<p>Set up icon in administration backend: 
<?php echo jbIconSetup($database) ? '<img src="images/tick.png" alt="OK" />' : '<img src="images/publish_x.png" alt="FAILED" />'; ?>
<br />Updating configuration:
<?php echo jbConfigurationUpdate($database,$bool_jbNeedUpgrade) ? '<img src="images/tick.png" alt="OK" />' : '<img src="images/publish_x.png" alt="FAILED" />'; ?>
<br />Updating database tables:
<?php echo jbTablesUpdate($database,$bool_jbNeedUpgrade) ? '<img src="images/tick.png" alt="OK" />' : '<img src="images/publish_x.png" alt="FAILED" /><br />ERROR: '.$database->getErrorMsg(); ?><br />
</p>
<p>Installation finished.</p>
<h3 class="title">Documentation</h3>
<p>All documentation regarding the joomlaboard component can be found on the <a href="http://www.tsmf.net" target="_blank">tsmf website</a>.</p>
<h3 class="title">Legal note</h3>
<p style="font-size:x-small">Joomlaboard is free software and therefore provided 'as-is' without warranties of any kind.</p>
<p style="font-size:x-small">The Two Shoes M-Factory, its subsidiaries, its developers, contributors and other volunteers 
            and its parental legal entities (formally or informally) (these will further be referenced as 'TSMF') 
            offer you Joomlaboard for absolutely free for your own personal use, pleasure and education. 
            The TSMF reserves the right to charge corporate or other commercial users of the Software for this 
            or future versions or support on a paid basis. </p>
<p style="font-size:x-small">Any Joomlaboard version may contain errors, bugs and/or can cause  problems otherwise. 
            While we believe it is safe to use this version, we do point you at this fact.<br>
            By installing this software, you have agreed to waive TSMF from whatever form of liability and/or 
            responsibility for any problems and/or damages done by this software to you, your web environment 
            or in any other way legallly, financially, socially, emotionally or whatever other ~ally you could 
            possibly imagine and find a legal article for that favours your rights...<br>
            In short and slightly more human readable: Use this software at your own risk; 
            we don't guarantee anything! And by clicking 'continue' below and using Joomlaboard, 
            it's your way of answering: &quot;Yeah, yeah, I know and I don't care... trust me, I know what I'm 
            doing so it'll be my own fault if things go wrong&quot;...
         </p>
<p style="font-size:x-small">Thank you for choosing our product and have fun with Joomlaboard! We know we have!</p>
</div>
<?php } ?>
