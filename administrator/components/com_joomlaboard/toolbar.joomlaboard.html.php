<?php
/**
* toolbar.joomlaboard.html.php generates toolbar html
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

class TOOLBAR_simpleBoard {

   function _ADMIN() {
      mosMenuBar::startTable();
      mosMenuBar::spacer();
      mosMenuBar::publish();
      mosMenuBar::spacer();
      mosMenuBar::unpublish();
      mosMenuBar::spacer();
      mosMenuBar::addNew();
      mosMenuBar::spacer();
      mosMenuBar::editList();
      mosMenuBar::spacer();
      mosMenuBar::deleteList();
      mosMenuBar::spacer();
      mosMenuBar::endTable();
   }

   function _EDIT() {
      mosMenuBar::startTable();
      mosMenuBar::spacer();
      mosMenuBar::save();
      mosMenuBar::spacer();
      mosMenuBar::cancel();
      mosMenuBar::spacer();
      mosMenuBar::addNew('newmoderator', 'Moderator');
      mosMenuBar::spacer();
      mosMenuBar::unpublish('removemoderator');
      mosMenuBar::spacer();
      mosMenuBar::endTable();
   }

   function _NEWMOD_MENU() {
      mosMenuBar::startTable();
      mosMenuBar::spacer();
      mosMenuBar::publish('addmoderator');
      mosMenuBar::spacer();
      mosMenuBar::unpublish('removemoderator');
      mosMenuBar::spacer();
      mosMenuBar::cancel();
      mosMenuBar::spacer();
      mosMenuBar::endTable();
   }
   function _EDIT_CONFIG() {

      mosMenuBar::startTable();
      mosMenuBar::spacer();
      mosMenuBar::save( 'saveconfig' );
      mosMenuBar::spacer();
      mosMenuBar::back();
      mosMenuBar::spacer();
      mosMenuBar::endTable();


   }
   function _EDITUSER_MENU() {

      mosMenuBar::startTable();
      mosMenuBar::spacer();
      mosMenuBar::save( 'saveuserprofile' );
      mosMenuBar::spacer();
      mosMenuBar::cancel('showprofiles','Back');
      mosMenuBar::spacer();
      mosMenuBar::endTable();


   }
   function _PROFILE_MENU() {

      mosMenuBar::startTable();
      mosMenuBar::spacer();
      mosMenuBar::custom( 'userprofile','edit.png','edit_f2.png','Edit' );
      mosMenuBar::spacer();
      mosMenuBar::cancel();
      mosMenuBar::spacer();
      mosMenuBar::back();
      mosMenuBar::spacer();
      mosMenuBar::endTable();


   }

   function CSS_MENU() {

      mosMenuBar::startTable();
      mosMenuBar::spacer();
      mosMenuBar::save('saveeditcss');
      mosMenuBar::spacer();
      mosMenuBar::cancel();
      mosMenuBar::spacer();
      mosMenuBar::endTable();


   }
   function _PRUNEFORUM_MENU() {
      mosMenuBar::startTable();
      mosMenuBar::spacer();
      mosMenuBar::spacer();
      mosMenuBar::custom( 'doprune','delete.png','delete_f2.png','Prune',false );
      mosMenuBar::spacer();
      mosMenuBar::cancel();
      mosMenuBar::spacer();
      mosMenuBar::endTable();
   }
   function _PRUNEUSERS_MENU() {
      mosMenuBar::startTable();
      mosMenuBar::spacer();
      mosMenuBar::custom( 'dousersprune','delete.png','delete_f2.png','Prune',false );
      mosMenuBar::spacer();
      mosMenuBar::cancel();
      mosMenuBar::spacer();
      mosMenuBar::endTable();
   }

   function BACKONLY_MENU() {
   mosMenuBar::startTable();
   mosMenuBar::back();
   mosMenuBar::endTable();
   }


      function DEFAULT_MENU() {

      mosMenuBar::startTable();
      mosMenuBar::deleteList();
      mosMenuBar::spacer();
      mosMenuBar::endTable();
   }
}?>
