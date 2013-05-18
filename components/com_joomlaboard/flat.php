<?php
/**
* flat.php joomlaboard flat view (used to display topics in a forum)
* @package com_joomlaboard
* @copyright (C) 2000 - 2007 TSMF / Jan de Graaff / All Rights Reserved
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* @author TSMF
* Joomla! is Free Software
**/
// Dont allow direct linking
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );
// topic emoticons

$topic_emoticons=array();
$topic_emoticons[0]=JB_DIRECTURL.'/emoticons/default.gif';
$topic_emoticons[1]=JB_DIRECTURL.'/emoticons/exclam.gif';
$topic_emoticons[2]=JB_DIRECTURL.'/emoticons/question.gif';
$topic_emoticons[3]=JB_DIRECTURL.'/emoticons/arrow.gif';
$topic_emoticons[4]=JB_DIRECTURL.'/emoticons/love.gif';
$topic_emoticons[5]=JB_DIRECTURL.'/emoticons/grin.gif';
$topic_emoticons[6]=JB_DIRECTURL.'/emoticons/shock.gif';
$topic_emoticons[7]=JB_DIRECTURL.'/emoticons/smile.gif';
$tabclass = array("sectiontableentry1", "sectiontableentry2");
if (count($messages[0]) > 0) {
?>
         <table width="100%" border="0" cellspacing="1" cellpadding="3" class="contentpane">
            <tr>
               <?php if ($sbConfig['showNew'] && $my->id !=0){echo '<td class="sectiontableheader" width="10">&nbsp;</td>';}?>
               <td class="sectiontableheader" width="5" align="center">&nbsp;</td>
               <td class="sectiontableheader" width="5" align="center">&nbsp;</td>
               <td class="sectiontableheader" align="center"><strong><?php echo _GEN_TOPICS;?></strong></td>
               <td class="sectiontableheader" align="center"  width="20"><strong><?php echo _GEN_REPLIES;?></strong></td>
               <td class="sectiontableheader" align="center"  width="20"><strong><?php echo _GEN_HITS;?></strong></td>
               <td class="sectiontableheader" width="110" align="center"><strong><?php echo _GEN_LAST_POST;?></strong></td>
            </tr>
            <?php $k=0;
            foreach($messages[0] as $leaf){
                $k=1-$k; //used for alternating colours
				//$leaf->subject = htmlspecialchars($leaf->subject);
				$leaf->name    = htmlspecialchars($leaf->name   );
				$leaf->email   = htmlspecialchars($leaf->email  );
             ?>
            <tr class="<?php echo $tabclass[$k];?>">
            <?php
            if ($sbConfig['showNew'] && $my->id !=0 ){
               if (($prevCheck<$last_reply[$leaf->id]->time) && !in_array($last_reply[$leaf->id]->thread, $read_topics) && ! $leaf->moved){
                  //new post(s) in topic
                  echo '<td width="1%" class="sb_new">';
                  echo defined('JB_ICONURL') && array_key_exists('unreadmessage',$sbIcons) ? '<img src="'.JB_ICONURL.'/'.$sbIcons['unreadmessage'].'" border="0" alt="'._GEN_UNREAD.'" title="'._GEN_UNREAD.'"/>' : $sbConfig['newChar'];
                  echo '</td>';
               }
               else{
                  //no new posts in topic
                  echo '<td width="1%" class="sb_notnew">';
                  echo defined('JB_ICONURL') && array_key_exists('readmessage',$sbIcons) ? '<img src="'.JB_ICONURL.'/'.$sbIcons['readmessage'].'" border="0" alt="'._GEN_NOUNREAD.'" title="'._GEN_NOUNREAD.'"/>' : $sbConfig['newChar'];
                  echo '</td>';
               }
            } ?>
               <td align="center" width="5">
                  <?php
                  if ($leaf->ordering==0) {
                     if($leaf->locked==0) {
                       echo "&nbsp;";
                     }
                     else{
                        echo defined('JB_ICONURL') && array_key_exists('topiclocked',$sbIcons) ? '<img src="'.JB_ICONURL.'/'.$sbIcons['topiclocked'].'" border="0" alt="'._GEN_LOCKED_TOPIC.'" />' : '<img src="'.JB_DIRECTURL.'/emoticons/lock.gif" width="15" height="15" alt="'._GEN_LOCKED_TOPIC.'" title="'._GEN_LOCKED_TOPIC.'" />';
                        $topicLocked=1;
                     }
                  }
                  else {
                     echo defined('JB_ICONURL') && array_key_exists('topicsticky',$sbIcons) ? '<img src="'.JB_ICONURL.'/'.$sbIcons['topicsticky'].'" border="0" alt="'._GEN_ISSTICKY.'" />' : '<img src="'.JB_DIRECTURL.'/emoticons/pushpin.gif" width="15" height="15" alt="'._GEN_ISSTICKY.'" title="'._GEN_ISSTICKY.'" />';
                     $topicSticky=1;
                  }
                  ?>
               </td>
					<?php
					if ($leaf->moved ==0) {
						?>
		               	<td align="center" width="5"><a href="#<?php echo $id;?>"></a><?php echo $leaf->topic_emoticon==0? '<img src="'.JB_DIRECTURL.'/tree-blank.gif" width="15" height="15" alt="" />':"<img src=\"".$topic_emoticons[$leaf->topic_emoticon]."\" alt=\"emo\" />";?></td> 
        		        <td><a href="<?php echo sefRelToAbs(JB_LIVEURL.'&amp;func=view&amp;id='.$leaf->id.'&amp;catid='.$catid);?>"><?php echo stripslashes($leaf->subject);?></a><br />
<div class="sb_author">
<?php echo $leaf->email!=""&&$my_id>0&&$sbConfig['showemail']=='1'?_GEN_STARTEDBY."<a href=\"mailto:".stripslashes($leaf->email)."\">".stripslashes($leaf->name)."</a></div>":_GEN_STARTEDBY.stripslashes($leaf->name)."</div>";
					} else {
						//this thread has been moved, get the new location
						$newURL=""; //init
						$database->setQuery("SELECT `message` FROM #__sb_messages_text WHERE `mesid`='".$leaf->id."'");
						$newURL=$database->loadResult();
						?>
               	<td align="center" width="5"><a href="#<?php echo $id;?>"></a><img src="<?php echo JB_DIRECTURL;?>/emoticons/arrow.gif" width="19" height="19" alt="emo" /></td>
                  <td><a href="<?php echo sefRelToAbs(JB_LIVEURL.'&amp;func=view&amp;'.$newURL);?>"><?php echo stripslashes($leaf->subject);?></a>
						<?php
					}
              			
               		$totalMessages=(int) array_key_exists($leaf->id,$thread_counts)? $thread_counts[$leaf->id] : 0;
               		if ($totalMessages > $sbConfig['messages_per_page'])
               		{
               			$threadPages= ceil($totalMessages/ $sbConfig['messages_per_page']);
               			echo ("<div class=\"sb_pagination\">[");
               			echo _PAGE;
               			echo '<a href="'.sefRelToAbs(JB_LIVEURL.'&amp;func=view&amp;id='.$leaf->id.'&amp;catid='.$catid).'">1</a>';
               			if ($threadPages>3)
               			{
               				echo ("...");
               				$startPage=$threadPages-2;
               			}
               			else
               			{
               				echo (",");
               				$startPage=2;
               			}
               			$noComma=true;
               			for ($hopPage=$startPage; $hopPage<=$threadPages; $hopPage++)
               			{
               				if ($noComma) $noComma=false; else echo(",");
               				echo '<a href="' . sefRelToAbs('index.php?option=com_joomlaboard&amp;Itemid='.$Itemid.'&amp;func=view&amp;id='.$leaf->id.'&amp;catid='.$catid.'&amp;limit='.$sbConfig['messages_per_page'].'&amp;limitstart='.(($hopPage-1)*$sbConfig['messages_per_page'])) . '">'.$hopPage.'</a>';
               			}
               			echo ("]</div>");
               		}
               ?>
               </td>
               <td align="center"><?php echo $leaf->moved ? "" :$totalMessages;?></td>
               <td align="center"><?php echo $leaf->moved ? "" :(int)$hits[$leaf->id];?></td>
               
               <td align="center">
                  <table border="0" cellspacing="0" cellpadding="0" width="110">
                     <tr bgcolor="<?php echo $bgcolor;?>">
                        <td width="100" class="createdate"><?php echo $leaf->moved ? "" :date(_DATETIME , $last_reply[$leaf->id]->time);?><br />
                        <?php echo $leaf->moved ? "" :_GEN_BY.' '.stripslashes($last_reply[$leaf->id]->name);?></td>
                        <td width="10"><a href="<?php echo sefRelToAbs(JB_LIVEURL.'&amp;func=view&amp;catid='.$catid.'&amp;id='.$last_reply[$leaf->id]->id).'#msg'.$last_reply[$leaf->id]->id;?>">
                        <?php 
								if ( ! $leaf->moved ) {
									echo defined('JB_ICONURL') && array_key_exists('latestpost',$sbIcons) ? '<img src="'.JB_ICONURL.'/'.$sbIcons['latestpost'].'" border="0" alt="'._SHOW_LAST.'" />' : '  <img src="'.JB_DIRECTURL.'/emoticons/icon_newest_reply.gif" border="0"  width="18" height="9" alt="'._SHOW_LAST.'" title="'._SHOW_LAST.'" />';
									}
									?>
                        </a>&nbsp;</td>
                     </tr>
                  </table>
               </td>
            </tr>
            <?php } ?>
         </table>
<?php
}
else{
   echo "<p align=\"center\">"._VIEW_NO_POSTS."</p>";
}
?>
