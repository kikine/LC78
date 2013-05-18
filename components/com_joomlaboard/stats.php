<?php 

/**
* stats.php display joomlaboard stats
* Joomla! is Free Software 
* @package com_joomlaboard
* @copyright (C) 2000 - 2007 TSMF / Jan de Graaff / All Rights Reserved
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* @author TSMF
**/
// Dont allow direct linking
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

include_once(JB_ABSPATH.'/classes/stats.class.php');
?>
<h3 class="contentheading"><?php echo $mosConfig_sitename._STATS_TITLE;?></h3>
<div class="sectiontableheader"><?php echo _STATS_GEN_STATS; ?></div>

<table border="0" cellpadding="1" cellspacing="0" width="100%">
<tr><td>
<div style="width: 23%; float: left;">
<?php echo _STATS_TOTAL_MEMBERS; ?><br />
<?php echo _STATS_TOTAL_REPLIES; ?><br />
<?php echo _STATS_TOTAL_TOPICS; ?><br />
<?php echo _STATS_TODAY_TOPICS; ?><br />
<?php echo _STATS_TODAY_REPLIES; ?><br />
</div>
<div style="width: 23%; float: left;">
<?php 
echo jbStats::get_total_members().'<br />';
echo jbStats::get_total_messages() . '<br />';
echo jbStats::get_total_topics() . '<br />';
echo jbStats::get_total_topics(date("Y-m-d 00:00:01"),date("Y-m-d 23:59:59")) . '<br />';
echo jbStats::get_total_messages(date("Y-m-d 00:00:01"),date("Y-m-d 23:59:59")) . '<br />';
?>
</div>

<div style="width: 23%; float: left;">
<?php echo _STATS_TOTAL_CATEGORIES; ?><br />
<?php echo _STATS_TOTAL_SECTIONS; ?><br />
<?php echo _STATS_LATEST_MEMBER; ?><br />
<?php echo _STATS_YESTERDAY_TOPICS; ?><br />
<?php echo _STATS_YESTERDAY_REPLIES; ?><br />
</div>
<div style="width: 23%; float: left;">
<?php 
$yesterday = mktime(0, 0, 0, date("m")  , date("d")-1, date("Y"));
echo jbStats::get_total_categories() . '<br />';
echo jbStats::get_total_sections() . '<br />';
echo jbStats::get_latest_member() . '<br />';
echo jbStats::get_total_topics() . '<br />';
echo jbStats::get_total_messages(date("Y-m-d 00:00:01",$yesterday),date("Y-m-d 23:59:59",$yesterday)) . '<br />';
?>
</div>
</td></tr>
</table>
<br />
<table border="0" cellpadding="1" cellspacing="0" width="100%">
<tr>
<td class="sectiontableheader" width="50%"><?php echo _STATS_TOP_POSTERS; ?></td>
<td class="sectiontableheader" width="50%"><?php echo ($sbConfig['cb_profile']==1) ? _STATS_POPULAR_PROFILE : ''; ?></td>
</tr>

<tr>
<td class="sectiontableentry2" valign="top" width="50%">
<table border="0" cellpadding="1" cellspacing="0" width="100%">
<?php
$jb_top_posters=jbStats::get_top_posters();
foreach ($jb_top_posters as $jb_poster) {
	if ($jb_poster->posts == $jb_top_posters[0]->posts) {
		$barwidth = 100;
	}
	else {
		$barwidth = round(($jb_poster->posts * 100) / $jb_top_posters[0]->posts);
	}
?>
<tr>
	<td valign="top" width="30%">
		<?php echo $jb_poster->username;?>
	</td>
	<td align="left" valign="top" width="50%">
		<img style="margin-bottom:1px" src="<?php echo JB_DIRECTURL.'/graph/bar.gif'; ?>" alt="" height="15" width="<?php echo $barwidth;?>">
	</td>
	<td align="right" valign="top" width="20%"><?php echo $jb_poster->posts;?></td>
</tr>
<?php
}
?>
</table>
</td>
<td class="sectiontableentry2" valign="top" width="50%">
<table border="0" cellpadding="1" cellspacing="0" width="100%">
<?php 
if ($sbConfig['cb_profile']==1) {
	$cb_top_profiles=jbStats::get_top_cbprofiles();
	foreach ($cb_top_profiles as $cb_profile) {
		if ($cb_profile->hits == $cb_top_profiles[0]->hits)
			$barwidth = 100;
		else
			$barwidth = round(($cb_profile->hits * 100) / $cb_top_profiles[0]->hits);
?>
<tr>
	<td valing="top" width="30%"><?php echo $cb_profile->user; ?></td>
	<td align="left" valign="top" width="50%">
		<img style="margin-bottom:1px" src="<?php echo JB_DIRECTURL.'/graph/bar.gif'; ?>" alt="" height="15" width="<?php echo $barwidth;?>">
	</td>
	<td align="right" valign="top" width="20%"><?php echo $cb_profile->hits;?></td>
</tr>
<?php		
	}
}
?>
</table>
</td>
</tr>
</table>
<br />

<table border="0" cellpadding="1" cellspacing="0" width="100%">
<tr>
<td class="sectiontableheader" colspan="3" width="100%"><b><?php echo _STATS_POPULAR_TOPICS; ?></b></td>
</tr>

<?php 
$jb_top_posts=jbStats::get_top_topics();
foreach ($jb_top_posts as $jb_post) {
	if ($jb_post->hits == $jb_top_posts[0]->hits) {
		$barwidth = 100;
	}
	else {
		$barwidth = round(($jb_post->hits * 100) / $jb_top_posts[0]->hits);
	}
	$link = sefReltoAbs(JB_LIVEURL.'&func=view&id='.$jb_post->id.'&catid='.$jb_post->catid);
?>
<tr>
	<td valign="top" width="50%">
		<a href="<?php echo $link;?>"><?php echo $jb_post->subject;?></a>
	</td>
	<td align="left" valign="top" width="40%">
		<img src="<?php echo JB_DIRECTURL.'/graph/bar.gif'; ?>" alt="" style="margin-bottom:1px" height="15" width="<?php echo $barwidth;?>">
	</td>
	<td align="right" valign="top" width="10%"><?php echo $jb_post->hits;?></td>
</tr>
<?php } ?>
</table>
<br />
