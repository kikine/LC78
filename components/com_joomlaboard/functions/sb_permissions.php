<?php
/**
 * This file contains the functions that check permissions
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @author Niels Vandekeybus
 * @package com_joomlaboard
 */

// ################################################################
// MOS Intruder Alerts
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );
// ################################################################

/**
 * Checks if a user has postpermission in given thread
 * @param database object
 * @param int
 * @param int
 * @param int
 * @param boolean
 * @param boolean
 * 
 * @pre: sb_has_read_permission()
 */
function sb_has_post_permission(&$database,$catid,$replyto,$userid,$pubwrite,$ismod) {
	global $sbConfig;
	if ($ismod)
		return 1; // moderators always have post permission
	if($replyto != 0) {
		$database->setQuery("select thread from #__sb_messages where id='$replyto'");
		$topicID=$database->loadResult();
		if ($topicID != 0) //message replied to is not the topic post; check if the topic post itself is locked
			$sql='select locked from #__sb_messages where id='.$topicID;
		else 
			$sql='select locked from #__sb_messages where id='.$replyto;
		$database->setQuery($sql);
		if ($database->loadResult()==1)
		return -1; // topic locked
	}
	
	//topic not locked; check if forum is locked
	$database->setQuery("select locked from #__sb_categories where id=$catid");
	if ($database->loadResult()==1)
		return -2; // forum locked
	
	if ($userid != 0|| $pubwrite)
		return 1; // post permission :-)

	return 0; // no public writing allowed
}
/**
 * Checks if user is a moderator in given forum
 * @param dbo
 * @param int
 * @param int
 * @param bool
 */
function sb_has_moderator_permission(&$database,&$obj_sb_cat,$int_sb_uid,$bool_sb_isadmin) {
	if ($bool_sb_isadmin) 
		return 1; 
	if ($obj_sb_cat!='' && $obj_sb_cat->getModerated() && $int_sb_uid != 0) {
		$database->setQuery('SELECT userid FROM #__sb_moderation WHERE catid='.$obj_sb_cat->getId());
		$modIDs=$database->loadResultArray();
		if (sizeof($modIDs) != 0 && in_array($int_sb_uid, $modIDs)) 
			return 1;
	}
	return 0;
}
/**
 * Checks if user has read permission in given forum
 * @param object
 * @param array
 * @param int
 * @param obj
 */
function sb_has_read_permission(&$obj_sbcat,&$allow_forum,$groupid,&$acl) {
	if ($obj_sbcat->getPubAccess() == 0 || ($obj_sbcat->getPubAccess() == -1 && $groupid > 0) || (sizeof($allow_forum)> 0 && in_array($obj_sbcat->getId(),$allow_forum))) {
      //this is a public forum; let 'Everybody' pass
      //or this forum is for all registered users and this is a registered user
      //or this forum->id is already in the cookie with allowed forums
		return 1;
	}
	else {
		// access restrictions apply; need to check
	
		if( $groupid == $obj_sbcat->getPubAccess()) {
			//the user has the same groupid as the access level requires; let pass
			return 1;
		}
		else {
			if ($obj_sbcat->getPubRecurse()=='RECURSE') {
				//check if there are child groups for the Access Level
				$group_childs=array();
				$group_childs=$acl->get_group_children( $obj_sbcat->getPubAccess(), 'ARO', $obj_sbcat->getPubRecurse() );

				if ( is_array( $group_childs ) && count( $group_childs ) > 0) {
					//there are child groups. See if user is in any ot them
					if ( in_array($groupid, $group_childs) ) {
						//user is in here; let pass
						return 1;
					}
				}
			}
		}//esle

		//no valid frontend users found to let pass; check if this is an Admin that should be let passed:
		
		if( $groupid == $obj_sbcat->getAdminAccess() ) {
			//the user has the same groupid as the access level requires; let pass
			return 1;
		}
        else {
			if ($obj_sbcat->getAdminRecurse()=='RECURSE') {
				//check if there are child groups for the Access Level
				$group_childs=array();
				$group_childs=$acl->get_group_children( $obj_sbcat->getAdminAccess(), 'ARO', $obj_sbcat->getAdminRecurse() );
				
				if (is_array( $group_childs ) && count( $group_childs ) > 0) {
					//there are child groups. See if user is in any ot them
	                  if ( in_array($groupid, $group_childs) ) {
						//user is in here; let pass
	                     return 1;
					}
				}
			}
         }	//esle
	} // esle
	//passage not allowed
	return 0;
}