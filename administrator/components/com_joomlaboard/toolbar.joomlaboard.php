<?php
/**
* toolbar.joomlaboard.php generates the toolbar for joomlaboard backend
* @package com_joomlaboard
* @copyright (C) 2000 - 2007 TSMF / Jan de Graaff / All Rights Reserved
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* @author TSMF
* Joomla! is Free Software
**/

// ################################################################
// MOS Intruder Alerts
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );
// ################################################################



require_once( $mainframe->getPath( 'toolbar_html' ) );

switch ( $task ) {
   case "new":
   case "edit":
   case "edit2":
      TOOLBAR_simpleBoard::_EDIT();
      break;

   case "cancel":
      TOOLBAR_simpleBoard::DEFAULT_MENU();
      break;

   case "showconfig":
      TOOLBAR_simpleBoard::_EDIT_CONFIG();
      break;

   case "showCss":
      TOOLBAR_simpleBoard::CSS_MENU();
      break;

   case "profiles":
      TOOLBAR_simpleBoard::_PROFILE_MENU();
      break;

   case "instructions":
      break;

   case "newmoderator":
      TOOLBAR_simpleBoard::_NEWMOD_MENU();
      break;

   case "userprofile":
      TOOLBAR_simpleBoard::_EDITUSER_MENU();
      break;

   case "pruneforum":
      TOOLBAR_simpleBoard::_PRUNEFORUM_MENU();
      break;

   case "pruneusers":
      TOOLBAR_simpleBoard::_PRUNEUSERS_MENU();
      break;

   case "showAdministration":
      TOOLBAR_simpleBoard::_ADMIN();
      break;

   case "showprofiles":
      TOOLBAR_simpleBoard::_PROFILE_MENU();
      break;

   default:
      TOOLBAR_simpleBoard::BACKONLY_MENU();
      break;
}
?>
