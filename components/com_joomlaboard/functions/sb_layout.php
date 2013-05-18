<?php
/**
 * This file contains the functions that display stuff (menu, pathways,...)
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @author Niels Vandekeybus
 * @package com_joomlaboard
 */

// ################################################################
// MOS Intruder Alerts
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );
// ################################################################

/**
 *  Function to print the pathway
 *  @param object	database object
 *  @param object	category object
 *  @param int		the post id
 *  @param boolean	set title
 */
function jb_print_pathway(&$database,$obj_sb_cat,$bool_set_title,$obj_post=0) {
	echo '<div class="sb_pathway">'.jb_get_pathway($database,$obj_sb_cat,$bool_set_title,$obj_post).'</div>';
}
/**
 *  Function to print the pathway
 *  @param object	database object
 *  @param object	category object
 *  @param int		the post id
 *  @param boolean	set title
 */
function jb_get_pathway(&$database,$obj_sb_cat,$bool_set_title,$obj_post=0) {
	global $mainframe,$sbConfig,$sbIcons;
	
	//Get the Category's parent category name for breadcrumb
	$database->setQuery('SELECT name,id FROM #__sb_categories WHERE id='. $obj_sb_cat->getParent());
	$database->loadObject($objCatParentInfo);

	//get the Moderator list for display
	$database->setQuery('SELECT * FROM #__sb_moderation LEFT JOIN #__users ON #__users.id=#__sb_moderation.userid WHERE #__sb_moderation.catid='.$obj_sb_cat->getId());
	$modslist=$database->loadObjectList();
//	echo '<div class="sb_pathway">';
	// List of Forums
	// show folder icon
	$return= '<img src="'.JB_DIRECTURL.'/images/folder.gif" border="0" alt="'._GEN_FORUMLIST.'" style="vertical-align: middle;" />&nbsp;';
	
	// link to List of Forum Categories
	$return.= '&nbsp;<a href="'.sefRelToAbs(JB_LIVEURL).'">'._GEN_FORUMLIST.'</a><br />';
	
	// List of	Categories	
	if ($objCatParentInfo) {
		if ($bool_set_title) 
			$mainframe->setPageTitle( $objCatParentInfo->name.' - '.$obj_sb_cat->getName() .' - '.$sbConfig['board_title'] );
		// show lines
		$return.= '&nbsp;<img src="'.JB_DIRECTURL.'/images/tree-end.gif" alt="|-" border="0" style="vertical-align: middle;" />';
		$return.= '&nbsp;<img src="'.JB_DIRECTURL.'/images/folder.gif" alt="'.$objCatParentInfo->name.'" border="0" style="vertical-align: middle;" />&nbsp;';
		// link to Category
		$return.= '&nbsp;<a href="'.sefRelToAbs(JB_LIVEURL.'&amp;func=listcat&amp;catid='.$objCatParentInfo->id).'">'.$objCatParentInfo->name.'</a><br />';
		$return.='&nbsp;<img src="'.JB_DIRECTURL.'/images/tree-blank.gif" alt="| " border="0" style="vertical-align: middle;" />';
	}
	else {
			if ($bool_set_title) 
				$mainframe->setPageTitle($obj_sb_cat->getName() .' - '.$sbConfig['board_title'] );
	}
	
	// Forum
	// show lines
	$return.= '&nbsp;<img src="'.JB_DIRECTURL.'/images/tree-end.gif" alt="|-" border="0" style="vertical-align: middle;" />';
	$return.= '&nbsp;<img src="'.JB_DIRECTURL.'/images/folder.gif" alt="+" border="0" style="vertical-align: middle;" />&nbsp;';
	
	// Link to forum
	$return.= '&nbsp;<a href="'.sefRelToAbs(JB_LIVEURL.'&amp;func=showcat&amp;catid='.$obj_sb_cat->getId()).'">'.$obj_sb_cat->getName().'</a>';
	
	//check if this forum is locked

	if ($obj_sb_cat->getLocked()) {
		$return.= defined('JB_ICONURL') && array_key_exists('forumlocked',$sbIcons) ? '&nbsp;&nbsp;<img src="'.JB_ICONURL.'/'.$sbIcons['forumlocked'].'" border="0" alt="'._GEN_LOCKED_FORUM.'" title="'._GEN_LOCKED_FORUM.'"/>' : '	<img src="'.JB_DIRECTURL.'/images/lock.gif"	border="0" width="13" height="13" alt="'._GEN_LOCKED_FORUM.'" title="'._GEN_LOCKED_FORUM.'">';
	}
	
	// check if this forum is reviewed
	if ($obj_sb_cat->getReview()) {
		$return.= defined('JB_ICONURL') && array_key_exists('forumreviewed',$sbIcons) ? '&nbsp;&nbsp;<img src="'.JB_ICONURL.'/'.$sbIcons['forumreviewed'].'" border="0" alt="'._GEN_REVIEWED.'" title="'._GEN_REVIEWED.'"/>' : '	<img src="'.JB_DIRECTURL.'/images/review.gif" border="0" width="15" height="15" alt="'._GEN_REVIEWED.'" title="'._GEN_REVIEWED.'">';
	}
	
	//check if this forum is moderated
	if ($obj_sb_cat->getModerated()) {
		$return.= defined('JB_ICONURL') && array_key_exists('forummoderated',$sbIcons) ? '&nbsp;&nbsp;<img src="'.JB_ICONURL.'/'.$sbIcons['forummoderated'].'" border="0" alt="'._GEN_MODERATED.'" title="'._GEN_MODERATED.'"/>' : '	<img src="'.JB_DIRECTURL.'/emoticons/moderate.gif" border="0" width="15" height="15" alt="'._GEN_MODERATED.'" title="'._GEN_MODERATED.'">';
		$text = '';
		if (count($modslist)>0) {
			foreach ($modslist as $mod) {
				$text = $text.', '.$mod->username;
			}
			$return.= '&nbsp;('._GEN_MODERATORS.': '.ltrim($text,",").')';
		}
	}
	
	if ($obj_post!=0) {
		if ($bool_set_title) 
			$mainframe->setPageTitle( $obj_post->subject.' - '.$sbConfig['board_title'] );
		// Topic
		// show lines
		$return.= '<br />&nbsp;<img src="'.JB_DIRECTURL.'/images/tree-blank.gif" alt="| " border="0" style="vertical-align: middle;" />';
		$return.= '&nbsp;<img src="'.JB_DIRECTURL.'/images/tree-blank.gif" alt="| " border="0" style="vertical-align: middle;" />';
		$return.= '&nbsp;<img src="'.JB_DIRECTURL.'/images/tree-end.gif" alt="|-" border="0" style="vertical-align: middle;" />';
		$return.= '&nbsp;<img src="'.JB_DIRECTURL.'/images/folder.gif" alt="+" border="0" style="vertical-align: middle;" />&nbsp;';
		$return.= '&nbsp;<b>'.$obj_post->subject.'</b>';
	
		// Check if the Topic is locked?
		if ( (int)$obj_post->locked != 0) {
			$return.= '&nbsp;<img src="'.JB_DIRECTURL.'/images/lock.gif"	border="0" width="13" height="13" alt="'._GEN_LOCKED_TOPIC.'" title="'._GEN_LOCKED_TOPIC.'">';
		}
	}
//	echo '</div>';
	return $return;
}

/** 
 * Function to generate the page list of a forum
 */
 function jb_get_pagination($int_total,$int_limit,$int_limitstart,$str_actionstr) {
	 if ($int_total == 0) return "";
	 $return= _PAGE;
	 if ($int_limitstart-2 > 1) {
		 $return.='<a href="'.sefRelToAbs($str_actionstr.'&amp;page=1').'">1</a>&nbsp;';
		 $return.='...&nbsp;';
	 }
	 $i=($int_limitstart-2)<=0 ? 1 : ($int_limitstart-2);
	 for ($i;$i<=$int_limitstart+2 && $int_limit<= ceil($int_total/$int_limit);$i++) {
		 if ($int_limitstart == $i)
			$return.='<strong>['.$i.']</strong>&nbsp;';
		else 
			$return.='<a href="'.sefRelToAbs($str_actionstr.'&amp;page='.$i).'">'.$i.'</a>&nbsp;';
	 }
	 if ($int_limitstart < ceil($int_total/$int_limit)) {
		 $return.='...&nbsp;';
		 $return.='<a href="'.sefRElToAbs($str_actionstr.'&amp;page='.ceil($int_total/$int_limit)).'">'.ceil($int_total/$int_limit).'</a>';
	 }
	 return $return;
 }
	
/**
 * Function  that get the menu used in the header of our board	
 * @param int $cbitemid
 * 			Community builder itemid, used for linking to cb profile
 * @param array $sbConfig
 * @param array $sbIcons
 * @param int $my_id
 * 			The user id
 * @param int $type
 * 			What kind of header do you want to print: 1: default (home/profile/latest posts/faq), 2: extended1 (home/profile/view/pending messages/faq) ,3:extended2 (home/profile/reply/view/pdf/faq)
 * @param string $view
 * 			The view the user is currently using, only needs to be pass when type==3 or type==2
 * @param int $catid
 * 			Only needs to be passed when type==3 or type==2
 * @param int $id
 * 			Only needs to be passed when type==3 or type==2
 * @param int $thread
 * 			Only needs to be passed when type==3 or type==2 (well actually just give 0 when type==2)
 * @param boolean $is_moderator
 * 			Only needs to be passed when type==2
 * @param int $numPending
 * 			Number of pending messages, only needs to be passed when type==2
 * @return String $header 
 * 			The menu :-)
 */
function jb_get_menu($cbitemid,$sbConfig,$sbIcons,$my_id,$type,$view="",$catid=0,$id=0,$is_moderator=false,$numPending=0) {
		$header = jb_get_link('home' , _HOME , JB_LIVEURL);
   	    if ($my_id != 0)
		{
			$profileurl=$sbConfig['cb_profile'] ? 'index.php?option=com_comprofiler&amp;Itemid='.$cbitemid.'&amp;task=userDetails' : JB_LIVEURL.'&amp;func=userprofile&amp;do=show';
		    $header.= jb_get_link('profile' , _GEN_MYPROFILE , $profileurl);
	  	}   	    
		switch ($type) {
				case 3:
					$header.= jb_get_link('menureply' , _GEN_POST_REPLY , JB_LIVEURL.'&amp;func=post&amp;do=reply&amp;replyto='.$id.'&amp;catid='.$catid); 
			        if ($view=="flat") 
		            	$header.= jb_get_link('threadedview' , _GEN_THREADED_VIEW , JB_LIVEURL.'&amp;func=view&amp;view=threaded&amp;id='.$id.'&amp;catid='.$catid);
			        else 
						$header.= jb_get_link('flatview' , _GEN_FLAT_VIEW , JB_LIVEURL.'&amp;func=view&amp;view=flat&amp;id='.$id.'&amp;catid='.$catid);
						
			        if ($sbConfig['enablePDF'])  
	 					$header.= jb_get_link('pdf' , _GEN_PDF , JB_LIVEURL.'&amp;id='.$id.'&amp;catid='.$catid.'&amp;func=sb_pdf');			 
					break;
				case 2:
					if ($view=="flat") 
		            	$header.= jb_get_link('threadedview' , _GEN_THREADED_VIEW , JB_LIVEURL.'&amp;func=showcat&amp;view=threaded&amp;catid='.$catid);
			        else 
						$header.= jb_get_link('flatview' , _GEN_FLAT_VIEW , JB_LIVEURL.'&amp;func=showcat&amp;view=flat&amp;catid='.$catid);

					if ($is_moderator){
						if ($numPending>0)
						{
							$numcolor='<font color="red">';
							$header.= ' <a href="'.sefRelToAbs(JB_LIVEURL.'&amp;func=review&action=list&amp;catid='.$catid).'" >';
							$header.= defined('JB_ICONURL') && array_key_exists('pendingmessages',$sbIcons) ? '<img src="'.JB_ICONURL.'/'.$sbIcons['pendingmessages'].'" border="0" alt="'.$numPending.' '._SHOWCAT_PENDING.'" />' : $numcolor.''.$numPending.'</font> '._SHOWCAT_PENDING;
							$header.= '</a>';
						}
					}
					
					break;
				case 1:
				default: 
			    	   	$header.= jb_get_link('showlatest' , _GEN_LATEST_POSTS , JB_LIVEURL.'&amp;func=latest');
					break;
			
		}
		if ( $sbConfig['enableRulesPage'] )
			  $header.=  jb_get_link('rules' , _GEN_RULES , JB_LIVEURL.'&amp;func=rules');
		if ( $sbConfig['enableStatsPage'] )
			  $header.= jb_get_link('stats' , _GEN_STATS , JB_LIVEURL.'&amp;func=stats');
		$header.= jb_get_link('help' , _GEN_HELP , JB_LIVEURL.'&amp;func=faq');
		return $header;
	}
	/**
 	* Returns a link using icons or alternate text
 	* @param string str_iconname icon name
 	* @param string str_action alternative text
	* @param string str_url url
 	*/
 	function jb_get_link($str_iconname,$str_action,$str_url) {
 		global $sbIcons;
 		$return= '<a href="'. sefRelToAbs($str_url) .'">';
		if(defined('JB_ICONURL') && array_key_exists($str_iconname,$sbIcons)) 
			$return .= '<img src="'.JB_ICONURL.'/' . $sbIcons[$str_iconname].'" alt="'.$str_action.'" border="0" title="'. $str_action.'" />';
		else
			$return .= $str_action;
		return $return.'</a>';
 	}
 	
 	/**
 	* Returns a link using icons or alternate image
 	* @param string str_iconname icon name
 	* @param string str_imgloc alternative image location
 	* @param string str_action alternative text for image
	* @param string str_url  url
 	*/
 	function jb_get_image_link($str_iconname,$str_img_loc,$str_action,$str_url) {
 		global $sbIcons;
 		$return= '<a href="'. sefRelToAbs($str_url) .'">';
		if(defined('JB_ICONURL') && array_key_exists($str_iconname,$sbIcons)) 
			$return .= '<img src="'.JB_ICONURL.'/' . $sbIcons[$str_iconname].'" alt="'.$str_action.'" border="0" title="'. $str_action.'" />';
		else
			$return .= '<img src="'.$str_img_loc.'" alt="'.$str_action.'" border="0" title="'.$str_action.'" />';
		return $return.'</a>';
 	}
	function sb_get_formatted_date($strUnixTime) {
		return strftime(_DATETIME,$strUnixTime);
	}
	function getSearchBox() {
    	$return= '<form action="'.sefRelToAbs(JB_LIVEURL.'&amp;func=search') . '" name="searchSB" method="post">';
        $boxsize=strlen(_GEN_SEARCH_BOX);
        if ($boxsize<=15)
            $boxsize=15;
        $return.='<input class="inputbox" type="text" name="searchword" size="' . $boxsize . '" value="' . _GEN_SEARCH_BOX . '" onblur="if(this.value==\'\') this.value=\''. _GEN_SEARCH_BOX . '\';" onfocus="if(this.value==\''. _GEN_SEARCH_BOX.'\') this.value=\'\';" />';
      	$return.= '</form>';
		return $return;
	}
	function printSearchBox() {
		echo getSearchBox();
	}
	?>