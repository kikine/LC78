<?php
/**
* sb_karma.php 
* @package com_joomlaboard
* @copyright (C) 2000 - 2007 TSMF / Jan de Graaff / All Rights Reserved
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* @author TSMF & Jan de Graaff
* Joomla! is Free Software
**/
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

// get variables
$userid = (int)	mosGetParam ( $_GET, 'userid'	, 0);
$pid	= (int)	mosGetParam ( $_GET, 'pid'		, 0);

// Modify this to change the minimum time between karma modifications from the same user
$karma_min_seconds = '21600'; // 21600 seconds = 6 hours

//This checks:
// - if the karma function is activated by the admin
// - if a registered user submits the modify request
// - if he specifies an action related to the karma change
// - if he specifies the user that will have the karma modified
if ($sbConfig['showkarma'] && $my->id != "" && $my->id != 0 && $do != '' && $userid != '' ) {
	$time = time();
  	if ($my->id != $userid) {
	    // This checkes to see if it's not too soon for a new karma change
		if ( ! $is_moderator) {
       		$database->setQuery('SELECT karma_time FROM #__sb_users WHERE userid='.$my->id.'');
       		$karma_time_old = $database->loadResult();
       		$karma_time_diff = $time - $karma_time_old;
    	}
    	if($karma_time_diff >= $karma_min_seconds || $is_moderator ) {
        	if ($do == "increase") {
            	$database->setQuery('UPDATE #__sb_users SET karma_time='.$time.' WHERE userid='.$my->id.'');
            	$database->query();
            	$database->setQuery('UPDATE #__sb_users SET karma=karma+1 WHERE userid='.$userid.'');
            	$database->query();
            	echo _KARMA_INCREASED.'<br /> <a href="'.sefRelToAbs('index.php?option=com_joomlaboard&Itemid='.$Itemid.'&func=view&catid='.$catid.'&id='.$pid).'">'._POST_CLICK.'</a>.';
                ?>
				<script language="javascript">
                	setTimeout("location='<?php echo sefRelToAbs('index.php?option=com_joomlaboard&Itemid='.$Itemid.'&func=view&catid='.$catid.'&id='.$pid); ?>'",3500);
				</script>
                <?php
        	}

        	else if ($do == "decrease") {
            	$database->setQuery('UPDATE #__sb_users SET karma_time='.$time.' WHERE userid='.$my->id.'');
            	$database->query();
            	$database->setQuery('UPDATE #__sb_users SET karma=karma-1 WHERE userid='.$userid.'');
            	$database->query();
            	echo _KARMA_DECREASED.'<br /> <a href="'.sefRelToAbs('index.php?option=com_joomlaboard&Itemid='.$Itemid.'&func=view&catid='.$catid.'&id='.$pid).'">'._POST_CLICK.'</a>.';
                     ?>
                     <script language="javascript">
                        setTimeout("location='<?php echo sefRelToAbs('index.php?option=com_joomlaboard&Itemid='.$Itemid.'&func=view&catid='.$catid.'&id='.$pid); ?>'",3500);
                     </script>
                     <?php
        	}
        	else {//you got me there... don't know what to $do
        		echo '<div style="text-align:center;">';
            	echo _USER_ERROR_A;
            	echo _USER_ERROR_B."<br /><br />";
            	echo _USER_ERROR_C."<br /><br />"._USER_ERROR_D.": <code>SB001-karma-02NoDO</code><br /><br />";
            	echo '</div>';
        	}
    	}
    	else
    		echo '<div style="text-align:center">'._KARMA_WAIT.'<br /> '._KARMA_BACK.' <a href="'.sefRelToAbs('index.php?option=com_joomlaboard&Itemid='.$Itemid.'&func=view&catid='.$catid.'&id='.$pid).'">'._POST_CLICK.'</a>.</div>';
  	}
  	else if ($my->id == $userid) { // In case the user tries modifing his own karma by changing the userid from the URL...
		if ($do == "increase") { // Seriously decrease his karma if he tries to increase it
			$database->setQuery('UPDATE #__sb_users SET karma=karma-10, karma_time='.$time.' WHERE userid='.$my->id.'');
			$database->query();
			echo '<div style="text-align:center">'._KARMA_SELF_INCREASE.'<br />'._KARMA_BACK.' <a href="'.sefRelToAbs('index.php?option=com_joomlaboard&Itemid='.$Itemid.'&func=view&catid='.$catid.'&id='.$pid).'">'._POST_CLICK.'</a>.</div>';
      	}
      	if ($do == "decrease") { // Stop him from decreasing his karma but still update karma_time
			$database->setQuery('UPDATE #__sb_users SET karma_time='.$time.' WHERE userid='.$my->id.'');
			$database->query();
			echo '<div style="text-align:center">'._KARMA_SELF_DECREASE.'<br /> '._KARMA_BACK.' <a href="'.sefRelToAbs('index.php?option=com_joomlaboard&Itemid='.$Itemid.'&func=view&catid='.$catid.'&id='.$pid).'">'._POST_CLICK.'</a>.</div>';
		}
	}
}
else { // no permission
	echo '<div style="text-align:center">';
	echo _USER_ERROR_A;
	echo _USER_ERROR_B."<br /><br />";
	echo _USER_ERROR_C."<br /><br />"._USER_ERROR_D.": <code>SB001-karma-01NLO</code><br /><br /></div>";
   //that should scare 'em off enough... ;-)
}
?>