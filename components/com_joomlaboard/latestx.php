<?php
/**
* latestx.php displays latest posts
* @package com_joomlaboard
* @copyright (C) 2000 - 2007 TSMF / Jan de Graaff / All Rights Reserved
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* @author TSMF
* Joomla! is Free Software
**/
// Dont allow direct linking
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

//Start with determining which forums the user can see
$ResultSet ="";
if ($my->id > 0){
   $database->setQuery("SELECT allowed FROM #__sb_sessions WHERE userid='".$my->id."'");
   $ResultSet=$database->loadResult();

   if ($ResultSet=="na"){
      mosRedirect($mosConfig_live_site.'/index.php?option=com_joomlaboard&Itemid='.$_GET['Itemid'].'&func=listcat',_LATEST_REDIRECT);
      return;
   }
   //$allowed_forums = explode (',',$ResultSet);
} 

else {
   $database->setQuery("SELECT id FROM #__sb_categories WHERE pub_access='0'");
   $allowed_forums=$database->loadObjectList();
   foreach ($allowed_forums as $af) {
      if ($ResultSet == "" ) {
         $ResultSet = $af->id;
      }
      else {
         $ResultSet = $ResultSet.','.$af->id;
      }
   }
}
//start the latest x
$sel  = (int) mosGetParam ( $_GET, 'sel' , 4 );
switch ($sel) {
	case 0:
		$querytime=($prevCheck-1800);
		break;
	default:
		$querytime=time()-($sel*3600);
}

   // get all the threads with posts in the specified timeframe
   $database->setQuery("SELECT  a.thread, b.subject FROM #__sb_messages AS a LEFT JOIN #__sb_messages AS b ON a.thread=b.thread WHERE a.time >'$querytime' AND b.parent=0 AND a.catid IN ($ResultSet) AND a.moved != 1 GROUP BY a.thread ORDER BY a.time DESC LIMIT 100");
   $resultSet=$database->loadObjectList();
   $countRS=count($resultSet);
   //check if $sel has a reasonable value and not a Unix timestamp:
   $since=false;
   if ($sel == "0") {$lastvisit=date(_DATETIME , $querytime); $since=true;} 
?>
<br />

   <p align="center"><span class="contentheading"><?php if (!$since) {echo _SHOW_LAST_POSTS.' '.$sel.' '._SHOW_HOURS;} else {echo _SHOW_LAST_SINCE . ' ' . $lastvisit;} ?> (<?php echo _SHOW_POSTS; ?><?php echo $countRS;?>)</span><br />
   <?php echo _DESCRIPTION_POSTS; ?><br />
      <a href="<?php echo sefRelToAbs('index.php?option=com_joomlaboard&amp;Itemid='.$Itemid.'&amp;func=latest&amp;do=show&amp;sel=4'); ?>"  ><?php echo _SHOW_4_HOURS; ?></a>
      | <a href="<?php echo sefRelToAbs('index.php?option=com_joomlaboard&amp;Itemid='.$Itemid.'&amp;func=latest&amp;do=show&amp;sel=8'); ?>"  ><?php echo _SHOW_8_HOURS; ?></a>
      | <a href="<?php echo sefRelToAbs('index.php?option=com_joomlaboard&amp;Itemid='.$Itemid.'&amp;func=latest&amp;do=show&amp;sel=12'); ?>" ><?php echo _SHOW_12_HOURS; ?></a>
      | <a href="<?php echo sefRelToAbs('index.php?option=com_joomlaboard&amp;Itemid='.$Itemid.'&amp;func=latest&amp;do=show&amp;sel=24'); ?>" ><?php echo _SHOW_24_HOURS; ?></a>
      | <a href="<?php echo sefRelToAbs('index.php?option=com_joomlaboard&amp;Itemid='.$Itemid.'&amp;func=latest&amp;do=show&amp;sel=48'); ?>" ><?php echo _SHOW_48_HOURS; ?></a>
      | <a href="<?php echo sefRelToAbs('index.php?option=com_joomlaboard&amp;Itemid='.$Itemid.'&amp;func=latest&amp;do=show&amp;sel=168'); ?>"><?php echo _SHOW_WEEK; ?></a>
      | <a href="<?php echo sefRelToAbs('index.php?option=com_joomlaboard&amp;Itemid='.$Itemid.'&amp;func=latest&amp;do=show&amp;sel=0'); ?>"><?php echo _SHOW_LASTVISIT; ?></a>
   </p>
<table border="0" cellspacing="0" cellpadding="3" width="100%" class="contentpane" style="text-align: left;">
  <tr>
    <td class="sectiontableheader" width="200"><?php echo _LATEST_THREADFORUM; ?></td>
    <td class="sectiontableheader"><?php echo _LATEST_NUMBER; ?></td>
    <td class="sectiontableheader"><?php echo _LATEST_AUTHOR; ?></td>
    <td class="sectiontableheader"><?php echo _POSTED_AT; ?></td>
  </tr><?php
   if (0<$countRS) {
      $tabclass = array("sectiontableentry1", "sectiontableentry2");
      $k=0;//for alternating rows
      foreach($resultSet as $rs) {
         //get the latest post time for this thread
         $database->setQuery("SELECT max(time) FROM #__sb_messages where thread=$rs->thread");
         $latestPostTime=$database->loadResult();
         //get the latest post itself
         $result="";
         $database->setQuery("SELECT a.id,a.name,a.catid,b.name as catname from #__sb_messages as a LEFT JOIN #__sb_categories as b on a.catid=b.id where a.time=$latestPostTime AND a.thread=".$rs->thread);
		 $database->loadObject($result);
         $latestPostId=$result->id;
         $latestPostName=$result->name;
         $latestPostCatid=$result->catid;
         $catname=$result->catname;
         $database->setQuery("SELECT count(*) from #__sb_messages where time>'$querytime' and thread=$rs->thread");
         $numberOfPosts=$database->loadResult();
        $k= 1- $k; 
        echo "<tr>"; 
        echo '<td  class="'.$tabclass[$k].'" width="200"><a href="'. sefRelToAbs('index.php?option=com_joomlaboard&amp;Itemid='.$Itemid.'&amp;func=view&amp;catid='.$latestPostCatid.'&amp;id='.$rs->thread).'#msg'.$latestPostId .'">'.htmlspecialchars(stripslashes($rs->subject)).'</a><br />'._GEN_FORUM.' : '.$catname.'</td>';
        echo '<td  class="'.$tabclass[$k].'">'.$numberOfPosts.'</td>';
        echo "<td class=\"$tabclass[$k]\">".htmlspecialchars($latestPostName)."</td>"; 
        echo "<td class=\"$tabclass[$k]\">".date(_DATETIME,$latestPostTime)."</td>"; 
        echo "</tr>"; 
       } 
     } 
     else { 
        echo "<tr><td colspan=\"3\" class=\"contentpane\"> "._NO_TIMEFRAME_POSTS." </td></tr>"; 
     } 
     echo "</table>";
?>