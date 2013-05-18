<?php
/**
* listcat.php displays forum view (eg categories and their subforums)
* @package com_joomlaboard
* @copyright (C) 2000 - 2007 TSMF / Jan de Graaff / All Rights Reserved
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* @author TSMF
* Joomla! is Free Software
**/
// Dont allow direct linking
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

//securing passed form elements
$catid=(int)$catid;
$Itemid=(int)$Itemid;

//resetting some things:
$moderatedForum=0;
$lockedForum=0;

// Start getting the categories
$str_catids=implode(',',$sbSession->allowed);
$where[]='published=1';
$where[]='id IN ('.$str_catids.')';
if ($catid > 0 )
	$where[]='(parent='.$catid.' OR id='.$catid.')';
$database->setQuery("SELECT * FROM #__sb_categories WHERE ".implode(' AND ',$where)." ORDER BY ordering");
$allCat=$database->loadObjectList();
$database->setQuery('SELECT catid,count(*) as amount FROM #__sb_messages WHERE parent=0 AND hold=0 AND moved=0 AND catid IN ('.$str_catids.') GROUP BY catid');
$allTopicCount=$database->loadObjectList();
$database->setQuery('SELECT catid,count(*) as amount FROM #__sb_messages WHERE parent!=0 AND hold=0 AND moved=0 AND catid IN ('.$str_catids.') GROUP BY catid');
$allMesCount=$database->loadObjectList();
$database->setQuery('SELECT catid FROM #__sb_moderation WHERE catid IN ('.$str_catids.') AND userid='.$my->id);
$arr_moderating=$database->loadResultArray();

$threadids=array();
$categories=array();

// set page title
$mainframe->setPageTitle( _GEN_FORUMLIST.' - '.$sbConfig['board_title'] );

if (count($allCat)>0) {
	foreach ($allCat as $category) {
		$threadids[]=$category->id;
	  	$categories[$category->parent][]=$category;
	}
}
if (count($allTopicCount)>0) {
	foreach ($allTopicCount as $topic) {
		$topics[$topic->catid]=intval($topic->amount);
	}
}
unset($allTopicCount);
if (count($allMesCount)>0) {
	foreach ($allMesCount as $topic) {
		$replies[$topic->catid]=intval($topic->amount);
	}
}
unset($allMesCount);
?>

<br />

<table width="100%" border="0" cellspacing="1" cellpadding="3" class="contentpane" style="text-align: left;">
<?php

if (count($categories[0]) > 0) {
	foreach($categories[0] as $cat) {
		$int_jb_rows=($sbConfig['showNew'] && $my->id != 0) ? 6:5;
		?>
			<tr>
        		<th colspan="<?php echo $int_jb_rows ; ?>" class="sb_catname"><?php echo '<a href="'.sefRelToAbs(JB_LIVEURL.'&amp;task=listcat&amp;catid='.$cat->id).'">'.$cat->name.'</a>';?></th>
     		</tr>
      		<tr>
      			<?php if ($sbConfig['showNew'] && $my->id != 0){echo '<td width="10"  class="sectiontableheader">&nbsp;</td>';}?>
        		<td class="sectiontableheader" width="0" align="left"><strong><?php echo _GEN_FORUM;?></strong></td>
        		<td class="sectiontableheader" width="15" align="center"><strong><?php echo _GEN_TOPICS;?></strong></td>
        		<td class="sectiontableheader" width="15" align="center"><strong><?php echo _GEN_REPLIES;?></strong></td>
        		<td class="sectiontableheader" width="110" align="center" colspan="2"><strong><?php echo _GEN_LAST_POST;?></strong></td>
    </tr>
	<?php
		$tabclass = array("sectiontableentry1", "sectiontableentry2");
		$k=0;
		if (!array_key_exists($cat->id,$categories)) 
			echo '<td colspan="'.$int_jb_rows.'">'._GEN_NOFORUMS.'</td>';
		else {
			foreach($categories[$cat->id] as $singlerow) {
				    //	$k=for alternating row colours:
	    	       	$k=1-$k;
		    
				    //Get the last post from each forum
			        $database->setQuery("SELECT MAX(time) from #__sb_messages WHERE catid='$singlerow->id' and hold='0' AND moved!='1'");
			        $lastPosttime=$database->loadResult();
					$lastPosttime=(int)$lastPosttime;
	
					if ($my->id !=0){
			            //	get all threads with posts after the users last visit; don't bother for guests
			            $database->setQuery("SELECT thread from #__sb_messages where catid='$singlerow->id' and hold='0' and time>$prevCheck group by thread");
			            $newThreadsAll=$database->loadObjectList();
						if (count($newThreadsAll)==0) 
							$newThreadsAll=array();
						//Get the topics this user has already read this session from #__sb_sessions         
			            $readTopics=$sbSession->readtopics;
						//make it into an array
			            $read_topics=explode(',',$readTopics);
					}
				    //	get pending messages if user is a Moderator for that forum
					$numPending=0;
					if (isset($arr_moderating[$singlerow->id])) {
			        	$database->setQuery("select count(*) from #__sb_messages where catid='$singlerow->id' and hold='1'");
			            $numPending=$database->loadResult();
					}
					$numPending=(int)$numPending;
			
			        //	get latest post info
			        $latestname  = "";
			        $latestcatid = "";
			        $latestid    = "";
					if ($lastPosttime!=0) {
			        	$database->setQuery("SELECT id, catid,name from #__sb_messages WHERE time=$lastPosttime and hold='0' and moved!='1' LIMIT 1");
			            $database->loadObject($obj_lp);
			            $latestname  = $obj_lp->name;
			            $latestcatid = $obj_lp->catid;
			            $latestid    = $obj_lp->id;
					}
					echo '<tr class="'. $tabclass[$k].'">';
					
					if ($sbConfig['showNew'] && $my->id !=0){
					    // Check if unread threads are in any of the forums topics
						$newPostsAvailable=0;
						foreach ($newThreadsAll as $nta) {
							if (!in_array($nta->thread,$read_topics)) {
								$newPostsAvailable++;
							}
						}
						if ( $newPostsAvailable>0 && count($newThreadsAll)!=0 ){
					    	echo '<td width="1%" class="sb_new">';
					       	echo defined('JB_ICONURL') && array_key_exists('unreadforum',$sbIcons) ? '<img src="'.JB_ICONURL.'/'.$sbIcons['unreadforum'].'" border="0" alt="'._GEN_FORUM_NEWPOST.'" title="'._GEN_FORUM_NEWPOST.'"/>' : $sbConfig['newChar'];
					        echo '</td>';
						}		
						else{
					    	echo '<td width="1%" class="sb_notnew">';
					        echo defined('JB_ICONURL') && array_key_exists('readforum',$sbIcons) ? '<img src="'.JB_ICONURL.'/'.$sbIcons['readforum'].'" border="0" alt="'._GEN_FORUM_NOTNEW.'" title="'._GEN_FORUM_NOTNEW.'"/>' : $sbConfig['newChar'];
					        echo '</td>';
						}
					}
				    echo '<td><a href="'.sefRelToAbs('index.php?option=com_joomlaboard&amp;Itemid='.$Itemid.'&amp;func=showcat&amp;catid='.$singlerow->id).'">'.$singlerow->name.'</a>';
					if ($singlerow->locked) {
				    	echo defined('JB_ICONURL') && array_key_exists('forumlocked',$sbIcons) ? '&nbsp;&nbsp;<img src="'.JB_ICONURL.'/'.$sbIcons['forumlocked'].'" border="0" alt="'._GEN_LOCKED_FORUM.'" title="'._GEN_LOCKED_FORUM.'"/>' : '&nbsp;&nbsp;<img src="'.JB_DIRECTURL.'/emoticons/lock.gif"  border="0"  width="15" height="15" alt="'._GEN_LOCKED_FORUM.'">';
				        $lockedForum=1;
					}
				           	
					if ($singlerow->review) {
				    	echo defined('JB_ICONURL') && array_key_exists('forummoderated',$sbIcons) ? '&nbsp;&nbsp;<img src="'.JB_ICONURL.'/'.$sbIcons['forummoderated'].'" border="0" alt="'._GEN_MODERATED.'" title="'._GEN_MODERATED.'"/>' : '&nbsp;&nbsp;<img src="'.JB_DIRECTURL.'/emoticons/review.gif" border="0"  width="15" height="15" alt="'._GEN_MODERATED.'">';
				        $moderatedForum=1;
					}
					if ($singlerow->description != "") {
				    	echo "<br />".$singlerow->description;
					}
	
					if ($numPending>0) {
				    	echo '<br /><font color="red">'.$numPending.' '._LISTCAT_PENDING.'</font>';
					}
	
					echo "</td>";
				   	echo "<td align=\"center\">".$topics[$singlerow->id]."</td>";
				    echo "<td align=\"center\">".$replies[$singlerow->id]."</td>";
					if ($topics[$singlerow->id] != 0) {
				    ?>
				            <td width="100">
				            <span class="createdate"><?php echo date(_DATETIME , $lastPosttime);?> <br /><?php echo _GEN_BY;?> <?php echo $latestname;?></span>
				            </td>
				            <td width="10">
				            <?php echo jb_get_image_link('latestpost',JB_DIRECTURL.'/emoticons/icon_newest_reply.gif',_SHOW_LAST,JB_LIVEURL.'&amp;func=view&amp;catid='.$latestcatid.'&amp;id='.$latestid.'#msg'.$latestid);?>
				            </td></tr>
				        	<?php
					}
					else {
			        	echo' <td colspan="2"><span class="createdate">' ._NO_POSTS. '</span></td></tr>';
					}
		    	}
			}
		}


	if ($my->id != 0){
		echo '<tr><td colspan="6" align="left">';
		echo jb_get_link('markAllRead',_GEN_MARK_ALL_FORUMS_READ,JB_LIVEURL.'&amp;func=markAllRead');
		echo '</td></tr>';
		echo '<tr><td colspan="6">';
		echo '<span class="sb_new">';
		echo defined('JB_ICONURL') && array_key_exists('unreadforum',$sbIcons) ? '<img src="'.JB_ICONURL.'/'.$sbIcons['unreadforum'].'" border="0" alt="'._GEN_FORUM_NEWPOST.'" title="'._GEN_FORUM_NEWPOST.'"/>' : $sbConfig['newChar'];
		echo '</span><small> - '._GEN_FORUM_NEWPOST.'</small><br /><span class="sb_notnew">';
		echo defined('JB_ICONURL') && array_key_exists('readforum',$sbIcons) ? '<img src="'.JB_ICONURL.'/'.$sbIcons['readforum'].'" border="0" alt="'._GEN_FORUM_NOTNEW.'" title="'._GEN_FORUM_NOTNEW.'"/>' : $sbConfig['newChar'];
		echo '</span><small> - '._GEN_FORUM_NOTNEW.'</small></td></tr>';
	}
	if ($lockedForum==1) { ?>
	    <tr>
	    <td colspan="<?php if ($sbConfig['showNew'] && $my->id != 0){echo '6';} else {echo '5';}?>">
	    <?php
		echo defined('JB_ICONURL') && array_key_exists('forumlocked',$sbIcons) ? '<img src="'.JB_ICONURL.'/'.$sbIcons['forumlocked'].'" border="0" alt="'._GEN_LOCKED_FORUM.'" title="'._GEN_LOCKED_FORUM.'" /> - '._GEN_LOCKED_FORUM.'</td></tr>' : '  <img src="'.JB_DIRECTURL.'/emoticons/lock.gif" border="0"  width="15" height="15" alt="'._GEN_LOCKED_FORUM.'" /> - '._GEN_LOCKED_FORUM.'</td></tr>';
	}
	if ($moderatedForum==1) { ?>
		<tr>
	    <td colspan="<?php if ($sbConfig['showNew'] && $my->id != 0){echo '6';} else {echo '5';}?>">
		<?php
	    echo defined('JB_ICONURL') && array_key_exists('forummoderated',$sbIcons) ? '<img src="'.JB_ICONURL.'/'.$sbIcons['forummoderated'].'" border="0" alt="'._GEN_MODERATED.'" title="'._GEN_MODERATED.'" /> - '._GEN_MODERATED.'</td></tr>' : '  <img src="'.JB_DIRECTURL.'/emoticons/review.gif" border="0" width="15" height="15" alt="'._GEN_MODERATED.'" /> - '._GEN_MODERATED.'</td></tr>';
	}
}
   else
   {
     ?>
     <tr><td colspan="6">
     <p align=\"center\"><center>
     <?php
       echo _LISTCAT_NO_CATS.'<br />';
       echo _LISTCAT_ADMIN.'<br />';
       echo _LISTCAT_PANEL.'<br /><br />';
       echo _LISTCAT_INFORM.'<br /><br />';
       echo _LISTCAT_DO.' <img src="'.JB_DIRECTURL.'/emoticons/wink.png" width="19" height="19" alt="" border="0" />';
     ?>
     </center></p>
     </td></tr>
     <?php
   }
if ($sbConfig['enableRSS']) echo '<tr><td colspan="3"><a href="'.$mosConfig_live_site.'/index2.php?option=com_joomlaboard&amp;func=sb_rss&amp;no_html=1" target="_blank"><img src="'.JB_JLIVEURL.'/images/M_images/rss.png" border="0" alt="'._LISTCAT_RSS.'" title="'._LISTCAT_RSS.'" /> - '._LISTCAT_RSS.'</a></td></tr>';
?>
</table>