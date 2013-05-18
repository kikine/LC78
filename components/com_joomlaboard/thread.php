<?php
/**
* thread.php generates a threaded view for a given list of topics
* @package com_joomlaboard
* @copyright (C) 2000 - 2007 TSMF / Jan de Graaff / All Rights Reserved
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* @author TSMF
* Joomla! is Free Software
**/

// Dont allow direct linking
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

global $joomlaboardPath;
// arrows and lines
$join = '<img src="'.JB_DIRECTURL.'/tree-join.gif" width="12" height="18" alt="thread link" />';
$end = '<img src="'.JB_DIRECTURL.'/tree-end.gif" width="12" height="18" alt="thread link" />';
$blank ='<img src="'.JB_DIRECTURL.'/tree-blank.gif" width="12" height="18" alt="thread link" />';
$vert = '<img src="'.JB_DIRECTURL.'/tree-vert.gif" width="12" height="18" alt="thread link" />';
$loc_emoticons=JB_DIRECTURL.'/emoticons';
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

$c=0;
function thread_flat(&$tree,&$leaves,$branchid=0,$level=0)
{
   global $c;
   foreach($leaves[$branchid] as $leaf)
   {
      $leaf->level=$level;
      $tree[]=$leaf;
      $c++;
      if (array_key_exists($leaf->id,$leaves)) // if it exists it's an array due to the way $messages is constructed
         thread_flat($tree,$leaves,$leaf->id,$level+1);
   }
   return $tree;
}

$tree=thread_flat($tree,$messages);
?>

         <table width="100%" border="0" cellspacing="1" cellpadding="3" class="contentpane">
            <tr>
               <?php if ($sbConfig['showNew'] && $my->id !=0){echo '<td width="10" class="sectiontableheader">&nbsp;</td>';}?>
               <td class="sectiontableheader" align="center" width="5">&nbsp;</td>
               <td class="sectiontableheader" align="center" width="5">&nbsp;</td>
               <td class="sectiontableheader" width="60%" align="center"><strong><?php echo _GEN_TOPICS;?></strong></td>
               <td class="sectiontableheader" width="15%" align="center"><strong><?php echo _GEN_AUTHOR;?></strong></td>
               <td class="sectiontableheader"  align="center"><strong><?php echo _GEN_DATE;?></strong></td>
            </tr>
            <?php foreach($tree as $leaf) {
            $leaf->name=htmlspecialchars($leaf->name);
            $leaf->subject=htmlspecialchars($leaf->subject);
            $leaf->email=isset($leaf->email)? htmlspecialchars($leaf->email) : '';
            //get all html out of the subject & email & name before posting:

            ?>

            <tr>
               <?php
               if ($sbConfig['showNew'] && $my->id !=0 ){
                  if (($prevCheck<($leaf->time)) && (sizeof($read_topics) == 0 || !in_array($leaf->thread, $read_topics)) && ! $leaf->moved) {
                  	//new post
                  	echo '<td width="1%" class="sb_new">';
                  	echo defined('JB_ICONURL') && array_key_exists('unreadmessage',$sbIcons) ? '<img src="'.JB_ICONURL.'/'.$sbIcons['unreadmessage'].'" border="0" alt="'._GEN_UNREAD.'" title="'._GEN_UNREAD.'"/>' : $sbConfig['newChar'];
                  	echo '</td>';
                  }else{
                  	//not new posts
                  	echo '<td width="1%" class="sb_notnew">';
                  	echo defined('JB_ICONURL') && array_key_exists('readmessage',$sbIcons) ? '<img src="'.JB_ICONURL.'/'.$sbIcons['readmessage'].'" border="0" alt="'._GEN_NOUNREAD.'" title="'._GEN_NOUNREAD.'"/>' : $sbConfig['newChar'];
                  	echo '</td>';
               	}
               } ?>
               <td align="center" width="5"
					<?php echo $leaf->id==$id?" class=\"sectiontableentry2\">":">";
                  if ($leaf->ordering==0)
                  {
                     if($leaf->locked==0)
                     {
                       echo "&nbsp;";
                     }
                     else
                     {
                        echo defined('JB_ICONURL') && array_key_exists('topiclocked',$sbIcons) ? '<img src="'.JB_ICONURL.'/'.$sbIcons['topiclocked'].'" border="0" alt="'._GEN_LOCKED_TOPIC.'" title="'._GEN_LOCKED_TOPIC.'" />' : '<img src="'.JB_DIRECTURL.'/emoticons/lock.gif" width="15" height="15" alt="'._GEN_LOCKED_TOPIC.'" />';
                        $topicLocked=1;
                     }
                  }
                  else
                  {
                     echo defined('JB_ICONURL') && array_key_exists('topicsticky',$sbIcons) ? '<img src="'.JB_ICONURL.'/'.$sbIcons['topicsticky'].'" border="0" alt="'._GEN_ISSTICKY.'" title="'._GEN_ISSTICKY.'" />' : '<img src="'.JB_DIRECTURL.'/emoticons/pushpin.gif" width="15" height="15" alt="'._GEN_ISSTICKY.'" />';
                     $topicSticky=1;
                  }
                  ?>
               </td>
               <td align="center" width="5" <?php echo $leaf->id==$id?" class=\"sectiontableentry2\"":"";?>><?php echo $leaf->topic_emoticon==0?'<img src="'.JB_DIRECTURL.'/tree-blank.gif" width="15" height="15" alt="thread link" />':"<img src=\"".$topic_emoticons[$leaf->topic_emoticon]."\" alt=\"emo\" />";?></td>
               <td<?php echo $leaf->id==$id?" class=\"sectiontableentry2\"":"";?>>
                  <table border="0" cellspacing="0" cellpadding="0"><tr>
                     <td<?php echo $leaf->id==$id?" class=\"sectiontableentry2\"":"";?>><?php
                         $array[$leaf->level + 1] = array_key_exists($leaf->id,$messages) ? count($messages[$leaf->id]) : 0;
                         $array[$leaf->level] = array_key_exists($leaf->level,$array) ? $array[$leaf->level]-1 : 0;
                         for ($i = 0; $i < $leaf->level; $i++) {
                             if ($array[$i] > 0) echo($vert);
                             elseif ($array[$i] == 0) echo($blank);
                         }
                         if ($array[$leaf->level] > 0) echo($join);
                         elseif ($array[$leaf->level] == 0 && $leaf->parent != 0) echo($end);
                         //else echo($blank);
                     ?></td>
                     <?php
						$newURL="index.php?option=com_joomlaboard&amp;Itemid=$Itemid&amp;func=view&amp;"; //init
						if ($leaf->moved) {
							$database->setQuery("SELECT `message` FROM #__sb_messages_text WHERE `mesid`='".$leaf->id."'");
							$newURL.=$database->loadResult();
						}
						else
						{
						$newURL.='id='.$leaf->id.'&amp;catid='.$catid;
						$newURL=sefRelToAbs($newURL);
									//sefRelToAbs('index.php?option=com_joomlaboard&amp;Itemid='.$Itemid.'&amp;func=view&amp;id='.$leaf->id.'&amp;catid='.$catid);
						}								
					?>
                     <td<?php echo $leaf->id==$id?" class=\"sectiontableentry2\"":"";?>><a href="<?php echo $newURL; ?>"><?php echo stripslashes($leaf->subject);?></a></td>
                  </tr></table>
               </td>
               <td align="center" <?php echo $leaf->id==$id?' class="sectiontableentry2"':'';?>><small><?php echo $leaf->email!=""&&$my_id>0&&$sbConfig['showemail']=='1'?'<a href="mailto:'.stripslashes($leaf->email).'">'.stripslashes($leaf->name).'</a>':stripslashes($leaf->name);?></small></td>
               <td align="center" <?php echo $leaf->id==$id?' class="sectiontableentry2"':'';?>><small><?php echo $leaf->moved ? date(_DATETIME , $leaf->time) :date(_DATETIME , $leaf->time);?></small></td>
            </tr>
            <?php } ?>
         </table>
