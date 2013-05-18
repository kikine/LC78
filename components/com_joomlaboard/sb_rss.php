<?php
/**
* sb_rss.php generates rss feed
* @package com_joomlaboard
* @copyright (C) 2000 - 2007 TSMF / Jan de Graaff / All Rights Reserved
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* @author TSMF
* Joomla! is Free Software
**/


// ensure this file is being included by a parent file
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

global $database, $mainframe, $my, $Itemid, $mosConfig_absolute_path;
include ($mosConfig_absolute_path."/components/com_joomlaboard/smile.class.php");

   $now = date( "Y-m-d H:i:s", time()+$mosConfig_offset*60*60 );

   $menu= new mosMenu( $database );
   $menu->load( 1 );
   $params = mosParseParams( $menu->params );

   $count = isset( $params->count ) ? $params->count : 6;
   $intro = isset( $params->intro ) ? $params->intro : 3;
   $orderby = @$params->orderby;

   switch (strtolower( $orderby )) {
      case 'date':
         $orderby = "a.created";
         break;
      case 'rdate':
         $orderby = "a.created DESC";
         break;
      default:
         $orderby = "f.ordering, a.ordering ASC, a.catid, a.sectionid";
         break;
   }

$database->setQuery( "SELECT a. * , b.id as category, b.published as published, c.message as message"
. "\n FROM #__sb_messages AS a LEFT JOIN "
. "\n #__sb_categories AS b on a.catid = b.id LEFT JOIN"
. "\n #__sb_messages_text AS c ON a.id = c.mesid"
. "\n WHERE a.hold = 0 AND b.published = 1"
. "\n AND b.pub_access = 0"
. "\n ORDER  BY a.time DESC "
// 10 zou $count moeten zijn
. "\n LIMIT 10 "
);
$rows = $database->loadObjectList();

header('Content-type: application/xml');
$encoding = split("=", _ISO);
echo "<?xml version=\"1.0\" encoding=\"".$encoding[1]."\"?>"; ?>
<!DOCTYPE rss PUBLIC "-//Netscape Communications//DTD RSS 0.91//EN"
   "http://my.netscape.com/publish/formats/rss-0.91.dtd">
<!-- Mambo Open Source 4.5 RSS Generator Version 2.07 (12/10/2003) - Robert Castley -->
<!-- Changed for use with Joomlaboard (10/04/2004) -->
<!-- Copyright (C) 2000-2003 - <?php echo $mosConfig_sitename; ?> -->
<rss version="0.91">
<channel>
<title><?php echo stripslashes(htmlspecialchars($mosConfig_sitename)); ?> - Forum</title>
<link><?php echo $mosConfig_live_site; ?></link>
<description><?php echo $option ?></description>
<language>en-us</language>
<lastBuildDate><?php $date = date("r"); echo "$date";?></lastBuildDate>
   <image>
   <title>Powered by Joomlaboard</title>
   <url><?php echo $mosConfig_live_site; ?>/components/com_joomlaboard/emoticons/sb_rsspower.gif</url>
   <link><?php echo $mosConfig_live_site; ?></link>
   <width>88</width>
   </image>
<?php
foreach ($rows as $row) {


   echo ("<item>");
   echo ("<title>"._GEN_SUBJECT.": ".stripslashes(htmlspecialchars($row->subject))." - "._GEN_BY.": ".stripslashes(htmlspecialchars($row->name))."</title>"."\n");
   echo "<link>";
   if ($mosConfig_sef == "1"){
      echo sefRelToAbs("index.php?option=com_joomlaboard&amp;Itemid=".$Itemid."&amp;func=view&amp;id=".$row->id."&amp;catid=".$row->catid);
   } else {
      echo $mosConfig_live_site . "/index.php?option=com_joomlaboard&amp;Itemid=".$Itemid."&amp;func=view&amp;id=".$row->id."&amp;catid=".$row->catid;
   }
   echo "</link>\n";
   $words = $row->message;
   $words = smile::purify($words);
   echo ("<description>".substr($words,0,512)."...</description>"."\n");
   echo ("</item>"."\n");
}
?>
</channel>
</rss>
