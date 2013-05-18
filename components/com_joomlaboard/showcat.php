<?php
/**
* showcat.php generates forum view (includes either flat.php or thread.php)
* @package com_joomlaboard
* @copyright (C) 2000 - 2007 TSMF / Jan de Graaff / All Rights Reserved
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* @author TSMF
* Joomla! is Free Software
**/

// Dont allow direct linking
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

//Security basics begin
	//Securing passed form elements:
	$catid=(int)$catid;
	$Itemid=(int)$Itemid;
	//resetting some things:
	$moderatedForum=0;
	$lockedForum=0;
	$topicLocked=0;
	$topicSticky=0;
//Security Basics end
	

   $threads_per_page=$sbConfig['threads_per_page'];
   $view=$view==""?$settings['current_view']:$view;
   setcookie("sboard_settings[current_view]",$view,time()+31536000,'/');

   /*//////////////// Start selecting messages, prepare them for threading, etc... /////////////////*/
   $page = (int)mosGetParam($_GET,'page',1);
   $page = $page<1?1:$page;
   $offset = ($page-1)*$threads_per_page;
   $row_count=$page*$threads_per_page;
   $database->setQuery("Select count(*) FROM #__sb_messages WHERE parent = '0' AND catid= '$catid' AND hold = '0' ");
   $total=(int)$database->loadResult();
   $database->setQuery("SELECT a. * , MAX( b.time )  AS lastpost FROM  #__sb_messages  AS a LEFT  JOIN #__sb_messages  AS b ON b.thread = a.thread WHERE a.parent =  '0' AND a.catid =  $catid AND a.hold =  '0' GROUP  BY id ORDER  BY ordering DESC , lastpost DESC  LIMIT $offset,$threads_per_page");
 
   foreach ($database->loadObjectList() as $message) {
		$threadids[]=$message->id;
		$messages[$message->parent][]=$message;
		$last_reply[$message->id] = $message;
		$hits[$message->id]=$message->hits;
   }

	if (count($threadids) > 0) {
    	$idstr = @join("','",$threadids);
		$database->setQuery("SELECT id,parent,thread,catid,subject,name,time,topic_emoticon,locked,ordering, moved FROM #__sb_messages WHERE thread IN ('$idstr') AND id NOT IN ('$idstr') and hold=0");
		$thread_counts=array(); 
		foreach ($database->loadObjectList() as $message) {
			$messages[$message->parent][]=$message;
			if (array_key_exists($message->thread,$thread_counts))
				$thread_counts[$message->thread]++;
			else
				$thread_counts[$message->thread]=1;
         	$last_reply[$message->thread]=$last_reply[$message->thread]->time<$message->time?$message:$last_reply[$message->thread];
      }
   }
   //get number of pending messages
   $database->setQuery("select count(*) from #__sb_messages where catid='$catid' and hold=1");
   $numPending=$database->loadResult();


   //@rsort($messages[0]);
?>

<table border="0" cellspacing="0" cellpadding="0" width="100%" class="contentpane">
	<tr><td>
<?php
   if (($sbConfig['pubwrite']==0 && $my_id != 0)||$sbConfig['pubwrite']==1) {
	//this user is allowed to post a new topic:
	   echo jb_get_link('new_topic',_GEN_POST_NEW_TOPIC,JB_LIVEURL.'&amp;func=post&amp;do=reply&amp;catid='.$catid);
	}
   echo '</td></tr><tr><td style="text-align: right;">';
   //pagination 1
   if (count($messages[0]) > 0) {
      echo _PAGE;
      if (($page-2) > 1) {
         echo '<a href="'.sefRelToAbs('index.php?option=com_joomlaboard&amp;Itemid='.$Itemid.'&amp;func=showcat&amp;catid='.$catid.'&amp;page=1').'">1</a>&nbsp;';
         echo "...&nbsp;";
      }
      for ($i=($page-2)<=0?1:($page-2); $i<= $page+2 && $i<= ceil($total/$threads_per_page); $i++) {
            if ($page == $i) {
                  echo "<strong>[$i]</strong>&nbsp;";
            }
            else {
               echo '<a href="'.sefRelToAbs('index.php?option=com_joomlaboard&amp;Itemid='.$Itemid.'&amp;func=showcat&amp;catid='.$catid.'&amp;page='.$i).'">'.$i.'</a>&nbsp;';
            }
       }
      if ($page+2 < ceil($total/$threads_per_page)) {
         echo "...&nbsp;";
         echo '<a href="'.sefRelToAbs('index.php?option=com_joomlaboard&amp;Itemid='.$Itemid.'&amp;func=showcat&amp;catid='.$catid.'&amp;page='.ceil($total/$threads_per_page)).'">'.ceil($total/$threads_per_page).'</a>';
      }
   }

      echo "      </td>";
      echo "   </tr>";


      //Get the category name for breadcrumb
      $database->setQuery("SELECT name,locked,review, parent from #__sb_categories where id='$catid'");
     $database->loadObject($objCatInfo);
     //Get the Category's parent category name for breadcrumb
     $database->setQuery("SELECT name,id FROM #__sb_categories WHERE id='$objCatInfo->parent'");
     $database->loadObject($objCatParentInfo);
     
     // set page title
     $mainframe->setPageTitle( $objCatParentInfo->name.' - '.$objCatInfo->name.' - '.$sbConfig['board_title'] ); 
     
      //check if this forum is locked
      $forumLocked=$objCatInfo->locked;
      //check if this forum is subject to review
      $forumReviewed=$objCatInfo->review;
      echo "<tr>";
      echo '<td><div class="jb_pathway" style="width:100%">';
      echo '<a href="'.sefRelToAbs('index.php?option=com_joomlaboard&amp;Itemid='.$Itemid).'" class="jb_pathway" >';
      echo defined('JB_ICONURL') && array_key_exists('forumlist',$sbIcons) ? '<img src="'.JB_ICONURL.'/'.$sbIcons['forumlist'].'" border="0" alt="'._GEN_FORUMLIST.'" /> ' : _GEN_FORUMLIST;
      echo '</a> ';
      if (file_exists($mosConfig_absolute_path.'/templates/'.$mainframe->getTemplate().'/images/arrow.png')) {
	  echo '<img src="'.JB_JLIVEURL.'/templates/'.$mainframe->getTemplate().'/images/arrow.png" alt="" />';
	  } else {
	  echo '<img src="'.JB_JLIVEURL.'/images/M_images/arrow.png" alt="" />';
	}
	  echo ' <a href="'.sefRelToAbs('index.php?option=com_joomlaboard&amp;Itemid='.$Itemid.'&amp;func=listcat&amp;catid='.$objCatParentInfo->id).'" class="jb_pathway" >'.$objCatParentInfo->name.'</a> ';
      if (file_exists($mosConfig_absolute_path.'/templates/'.$mainframe->getTemplate().'/images/arrow.png')) {
	  echo '<img src="'.JB_JLIVEURL.'/templates/'.$mainframe->getTemplate().'/images/arrow.png" alt="" />';
	  } else {
	  echo '<img src="'.JB_JLIVEURL.'/images/M_images/arrow.png" alt="" /> ';
	}
	   echo '<strong> '.$objCatInfo->name.'</strong>  ';

      if ($forumLocked)
      {
         echo defined('JB_ICONURL') && array_key_exists('forumlocked',$sbIcons) ? '<img src="'.JB_ICONURL.'/'.$sbIcons['forumlocked'].'" border="0" alt="'._GEN_LOCKED_FORUM.'" title="'._GEN_LOCKED_FORUM.'"/>' : '  <img src="'.JB_DIRECTURL.'/emoticons/lock.gif"  border="0"  width="15" height="15" alt="'._GEN_LOCKED_FORUM.'" title="'._GEN_LOCKED_FORUM.'">';
         $lockedForum=1;
      }else{echo "";}
      if ($forumReviewed)
      {
         echo defined('JB_ICONURL') && array_key_exists('forummoderated',$sbIcons) ? '<img src="'.JB_ICONURL.'/'.$sbIcons['forummoderated'].'" border="0" alt="'._GEN_MODERATED.'" title="'._GEN_MODERATED.'"/>' : '  <img src="'.JB_DIRECTURL.'/emoticons/review.gif" border="0"  width="15" height="15" alt="'._GEN_MODERATED.'" title="'._GEN_MODERATED.'">';
         $moderatedForum=1;
      }else{echo "";}
      echo "</div></td></tr>";
      echo "   <tr>";
      echo "      <td>";
      
      //get all readTopics in an array
      $readTopics="";
      $database->setQuery("SELECT readtopics FROM #__sb_sessions WHERE userid=$my->id");
      $readTopics=$database->loadResult();
	  if ( count ($readTopics) == 0 ) { $readTopics = "0"; } //make sure at least something is in there..
      //make it into an array
      $read_topics=explode(',',$readTopics);

      if (count($messages) > 0)
      {
      if ($view=="flat")
         include_once(JB_ABSPATH.'/flat.php');
      else
         include_once(JB_ABSPATH.'/thread.php');
      }
      else
      {
         echo "<p align=\"center\">";
         echo '<br /><br />'._SHOWCAT_NO_TOPICS;
         echo "</p>";
      }?>
            </td>
         </tr>
         <tr><td colspan="8" style="text-align: right;">
         <?php
            //pagination 2
            if (count($messages[0]) > 0)
            {
               echo _PAGE;
               if (($page-2) > 1)
               {
                  echo '<a href="'.sefRelToAbs('index.php?option=com_joomlaboard&amp;Itemid='.$Itemid.'&amp;func=showcat&amp;catid='.$catid.'&amp;page=1').'">1</a>&nbsp;';
                  echo "...&nbsp;";
               }
               for ($i=($page-2)<=0?1:($page-2); $i<= $page+2 && $i<= ceil($total/$threads_per_page); $i++)
                  {
                     if ($page == $i)
                        {
                           echo "<strong>[$i]</strong>&nbsp;";
                        }
                        else
                        {
                           echo '<a href="'.sefRelToAbs('index.php?option=com_joomlaboard&amp;Itemid='.$Itemid.'&amp;func=showcat&amp;catid='.$catid.'&amp;page='.$i).'">'.$i.'</a>&nbsp;';
                        }
                  }


               if ($page+2 < ceil($total/$threads_per_page))
                  {
                     echo "...&nbsp;";
                     echo '<a href="'.sefRelToAbs('index.php?option=com_joomlaboard&amp;Itemid='.$Itemid.'&amp;func=showcat&amp;catid='.$catid.'&amp;page='.ceil($total/$threads_per_page)).'">'.ceil($total/$threads_per_page).'</a>';
                  }

             }         ?>
             <br />&nbsp;
            </td>
         </tr>
         <tr><td>
            <?php
			if (($sbConfig['pubwrite']==0 && $my_id != 0)||$sbConfig['pubwrite']==1) {
	          	echo jb_get_link('new_topic',_GEN_POST_NEW_TOPIC,JB_LIVEURL.'&amp;func=post&amp;do=reply&amp;catid='.$catid);
			}?>	
         </td></tr>
		 <?php 
         if ($sbConfig['enableForumJump']){ ?>
               <tr>
               <td>
         		<form id="jumpto" name="jumpto" method="post" target="_self" action="<?php echo sefRelToAbs('index.php?option=com_joomlaboard&amp;Itemid='.$Itemid.'&amp;func=showcat');?>" onsubmit="if(document.jumpto.catid.value < 2){return false;}">
         		<div style="width: 100%" align="right">
         		<input type="submit" name="Go" value="Go" class="button" />
         		<select name="catid" onchange="if(this.options[this.selectedIndex].value > 0){ forms['jumpto'].submit() }" class="button">
               <option value="SELECTED"><?php echo _GEN_FORUM_JUMP;?></option>
         		<?php


            	showChildren(0, "", $sbSession->allowed);
         ?>
         </select>
         </div>
         </form>
         </td>
         </tr>
         <?php } ?>
      <?php
        if ($my->id != 0){
           echo '<tr><td colspan="6" align="left">';
           echo jb_get_link('markThisForumRead',_GEN_MARK_THIS_FORUM_READ,JB_LIVEURL.'&amp;func=markThisRead&amp;catid='.$catid);
           echo '</td></tr>';
           echo '<tr><td colspan="6">';
              echo '<span class="sb_new">';
              echo defined('JB_ICONURL') && array_key_exists('unreadmessage',$sbIcons) ? '<img src="'.JB_ICONURL.'/'.$sbIcons['unreadmessage'].'" border="0" alt="'._GEN_UNREAD.'" title="'._GEN_UNREAD.'"/>' : $sbConfig['newChar'];
              echo '</span><small> - '._GEN_UNREAD.'</small><br /><span class="sb_notnew">';
              echo defined('JB_ICONURL') && array_key_exists('readmessage',$sbIcons) ? '<img src="'.JB_ICONURL.'/'.$sbIcons['readmessage'].'" border="0" alt="'._GEN_NOUNREAD.'" title="'._GEN_NOUNREAD.'"/>' : $sbConfig['newChar'];
              echo '</span><small> - '._GEN_NOUNREAD.'</small></td></tr>';
        }      
      ?>
         
     <tr>
         <td colspan="5">
         <?php
         if ($topicLocked)
         {
            echo defined('JB_ICONURL') && array_key_exists('topiclocked',$sbIcons) ? '<img src="'.JB_ICONURL.'/'.$sbIcons['topiclocked'].'" border="0" alt="'._GEN_LOCKED_TOPIC.'" title="'._GEN_LOCKED_TOPIC.'" /><small> - '._GEN_LOCKED_TOPIC.'</small><br />': '<img src="'.JB_DIRECTURL.'/emoticons/lock.gif" width="15" height="15" alt="'._GEN_LOCKED_TOPIC.'" title="'._GEN_LOCKED_TOPIC.'"><small> - '._GEN_LOCKED_TOPIC.'</small><br />';
         }
         if ($topicSticky)
         {
            echo defined('JB_ICONURL') && array_key_exists('topicsticky',$sbIcons) ? '<img src="'.JB_ICONURL.'/'.$sbIcons['topicsticky'].'" border="0" alt="'._GEN_ISSTICKY.'" title="'._GEN_ISSTICKY.'" /><small> - '._GEN_ISSTICKY.'</small>' : '<img src="'.JB_DIRECTURL.'/emoticons/pushpin.gif" width=15 height=15 alt="'._GEN_ISSTICKY.'" title="'._GEN_ISSTICKY.'"><small> - '._GEN_ISSTICKY.'</small>';
         }
         ?>
         </td>
     </tr>
    
     <?php
      //get the Moderator list for display
      $database->setQuery("select * from #__sb_moderation left join #__users on #__users.id=#__sb_moderation.userid where #__sb_moderation.catid=$catid");
      $modslist=$database->loadObjectList();
?>
     <tr>
         <td colspan="5">

         <?php
            if ($lockedForum==1)
            {
               echo defined('JB_ICONURL') && array_key_exists('forumlocked',$sbIcons) ? '<img src="'.JB_ICONURL.'/'.$sbIcons['forumlocked'].'" border="0" alt="'._GEN_LOCKED_FORUM.'" /><small> - '._GEN_LOCKED_FORUM.'</small><br />' : '  <img src="'.JB_DIRECTURL.'/emoticons/lock.gif" border="0"  width="15" height="15" alt="'._GEN_LOCKED_FORUM.'"><small> - '._GEN_LOCKED_FORUM.'</small><br />';
            }else{echo "";}
            if ($moderatedForum==1)
            {
               echo defined('JB_ICONURL') && array_key_exists('forummoderated',$sbIcons) ? '<img src="'.JB_ICONURL.'/'.$sbIcons['forummoderated'].'" border="0" alt="'._GEN_MODERATED.'" /><small> - '._GEN_MODERATED.'</small>' : '  <img src="'.JB_DIRECTURL.'/emoticons/review.gif" border="0" width="15" height="15" alt="'._GEN_MODERATED.'"><small> - '._GEN_MODERATED.'</small>';
            }else{echo "";}
         ?>
            <?php if (count($modslist)>0)
            {
               echo '<br />'._GEN_MODERATORS.": ";
               foreach ($modslist as $mod)
               {
                  echo "&nbsp;<small><u>$mod->username</u></small>&nbsp;";
                }
            } ?>
         </td>
      </tr>
   </table>
   <?php


function showChildren($category,$prefix="", &$allow_forum) {
   global $database;
               
   $database->setQuery( "SELECT id, name, parent FROM #__sb_categories WHERE parent='$category'  and published='1' order by ordering");
   $forums = $database->loadObjectList();
   foreach ($forums as $forum)
   {
      if (in_array($forum->id, $allow_forum)) {
         echo ("<option value=\"{$forum->id}\">$prefix{$forum->name}</option>");
      }
   showChildren($forum->id,$prefix."&nbsp;&nbsp;&#0124;-- ", $allow_forum);
   }
}
?>