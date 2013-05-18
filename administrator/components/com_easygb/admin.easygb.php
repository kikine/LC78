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
require_once($mainframe->getPath('admin_html'));

$task = mosGetParam($_REQUEST, 'task');
$act = mosGetParam($_REQUEST, 'act');
$cid = mosGetParam($_REQUEST, 'cid', array(0));

if(!is_array($cid)){
  $cid = array($cid);
}

switch ($act){
  case 'entries':
    swEntries($task, $cid);
    break;
  case 'configuration':
    swConfiguration($task, $cid);
    break;
  default:
    HTML_easygb::showCredits();
    break;
}

function swConfiguration($task, $cid){
  global $option;
  
  switch ($task){
    case 'save':
      easyGB::saveConfiguration();
      break;
    case 'cancel':
      mosRedirect('index2.php?option=' . $option);
      break;
    default:
      HTML_easygb::editConfiguration();
      break;
  }
}

function swEntries($task, $cid){
  global $option;
  
  switch ($task){
    case 'new':
      easyGB::editEntry(0);
      break;
    case 'edit':
      easyGB::editEntry($cid[0]);
      break;
    case 'apply':
    case 'save':
      easyGB::saveEntry();
      break;
    case 'remove':
      easyGB::removeEntries($cid);
      break;
    case 'cancel':
      mosRedirect('index2.php?option=' . $option . '&act=entries');
      break;
    case 'publish':
      easyGB::setState($cid, 1);
      break;
    case 'unpublish':
      easyGB::setState($cid, 0);
      break;
    default:
      easyGB::showEntries();
      break;
  }
}