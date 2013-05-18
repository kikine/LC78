<?php
/**
* @package EasyGB
* @copyright (C) 2006 Joomla-addons.org
* @author Websmurf
* 
* --------------------------------------------------------------------------------
* All rights reserved.  Easy GB Component for Joomla!
*
* This program is free software; you can redistribute it and/or
* modify it under the terms of the Creative Commons - Attribution-NoDerivs 2.5 
* license as published by the Creative Commons Organisation
* http://creativecommons.org/licenses/by-nd/2.5/.
*
* This program is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  
* --------------------------------------------------------------------------------
**/

defined( '_VALID_MOS' ) or die( 'Restricted access' );

require_once($mainframe->getPath('class'));
require_once($mainframe->getPath('front_html'));
require($mainframe->getCfg('absolute_path') . '/administrator/components/com_easygb/configuration.php');

$task = mosGetParam($_REQUEST, 'task');
$limit = intval(mosGetParam($_REQUEST, 'limit', $mainframe->getCfg('list_limit')));
$limitstart = intval(mosGetParam($_REQUEST, 'limitstart', 0));

switch ($task){
  case 'new':
    easyGB::editEntry(0);
    break;
  case 'save':
    easyGB::saveEntryFromFrontend();
    break;
  case 'captcha':
    $hash = mosGetParam($_REQUEST, 'hash');
    easyCAPTCHA::generateImage($hash);
    break;
  default: 
    easyGB::showGBEntries($limit, $limitstart);
    break;
}

/**
 * do not comment this out please,
 * have a look at the bottom of easygb.html.php
 * for some comments
 */
HTML_easygb::showCopyright();
?>