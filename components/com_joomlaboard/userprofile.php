<?php
/**
* userprofile.php manages joomlaboard userprofile
* @package com_joomlaboard
* @copyright (C) 2000 - 2007 TSMF / Jan de Graaff / All Rights Reserved
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* @author TSMF
* Joomla! is Free Software
**/

// Dont allow direct linking
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );
if ($my->id != "" && $my->id != 0)
{//we got a valid and logged on user so we can go on

   //What should we do?
   if($do=="show")
   {//show it is..
		if (!$sbConfig['cb_profile']) {
      //first we gather some information about this person
      $database->setQuery("SELECT * FROM #__sb_users LEFT JOIN #__users on #__users.id=#__sb_users.userid WHERE userid=$my->id");
      $userDetails=$database->loadObjectList();
         //Mambo userids are unique, so we don't worry about that

      //fill the variables needed later
      foreach($userDetails as $user)
      {
         $prefview  = $user->view     ;
         $signature = $user->signature;
         $username  = $user->name     ;
         $moderator = $user->moderator;
         $sbavatar  = $user->avatar;
         $ordering  = $user->ordering;
         list($avWidth, $avHeight) = @getimagesize($avatar);

         //that's it we got now; later the 'future_use' columns can be used..
      }
      
      //use mypms pro avatar if configured
      if ($sbConfig['avatar_src']=="pmspro") {
      $database->setQuery("SELECT picture FROM #__mypms_profiles WHERE name='$username'");
      $avatar=$database->loadResult();
      }
		elseif ($sbConfig['avatar_src']=="cb") {
		$database->setQuery("SELECT avatar FROM #__comprofiler WHERE user_id='$my->id'");
      $avatar=$database->loadResult();
		}
		else {
		$avatar = $sbavatar;
		}
		}

      //get all subscriptions for this user
      $database->setQuery("select thread from #__sb_subscriptions where userid=$my->id");
      $subslist=$database->loadObjectList();
      $csubslist=count($subslist);

      //get all forums for which this user is assigned as moderator, BUT only if the user isn't an admin
      //since these are moderators for all forums (regardless if a forum is set to be moderated)
      if (!$is_admin)
      {
         $database->setQuery("select #__sb_moderation.catid,#__sb_categories.name from #__sb_moderation left join #__sb_categories on #__sb_categories.id=#__sb_moderation.catid where #__sb_moderation.userid=$my->id");
         $modslist=$database->loadObjectList();
         $cmodslist=count($modslist);
      }
      //here we go:
?>
 <script type="text/javascript" src="<?php echo sefRelToAbs(JB_LIVEURL.'&amp;nohtml=1&amp;func=sb_bbjs'); ?>"></script>
		<?php if (!$sbConfig['cb_profile']) { ?>

     <p align="center"class="contentheader"><?php echo _USER_PROFILE;?> <?php echo $username;?><br /><br /></p>

      <form action="<?php echo sefRelToAbs(JB_LIVEURL.'&amp;func=userprofile&amp;do=update'); ?>" method="POST" name="postform">
      <input type="hidden" name="do" value="update">

      <table border=0 cellspacing=0 width="100%" align="center" class="contentpane">
         <tr>
            <td colspan="3" class="sectiontableheader"><?php echo _USER_GENERAL;?></td>
         </tr>
         <tr>
            <td width="150" class="contentpane" style="vertical-align: top;"><strong><?php echo _USER_PREFERED;?>*</strong>:</td>
            <td align="left" valign="top" colspan="2">
               <?php
               // make the select list for the view type
               $yesno[] = mosHTML::makeOption( 'flat', _GEN_FLAT );
               $yesno[] = mosHTML::makeOption( 'threaded', _GEN_THREADED );

               // build the html select list
               $tosend = mosHTML::selectList( $yesno, 'newview', 'class="inputbox" size="2"', 'value', 'text', $prefview );
               echo $tosend;
               ?>
            </td>
         </tr>
         <tr>
            <td width="150" class="contentpane" style="vertical-align: top;"><strong><?php echo _USER_ORDER;?>*</strong>:</td>
            <td align="left" valign="top" class="contentpane"  colspan="2">
               <?php
               // make the select list for the view type
               $yesno1[] = mosHTML::makeOption( 0, _USER_ORDER_ASC );
               $yesno1[] = mosHTML::makeOption( 1, _USER_ORDER_DESC );

               // build the html select list
               $tosend = mosHTML::selectList( $yesno1, 'neworder', 'class="inputbox" size="2"', 'value', 'text', $ordering );
               echo $tosend;
               echo '<br /><font size="1"><em>*'._USER_CHANGE_VIEW.'</em></font>';
               ?>
            </td>
         </tr>
         <tr>
            <td width="150" class="contentpane" style="vertical-align: top;">
               <strong><?php echo _GEN_SIGNATURE;?></strong>:<br />
               <i><?php echo $sbConfig['maxSig'];?> <?php echo _CHARS; ?></i><br />
               <input readonly type=text name="counter" size="3" maxlength=3 value=""><br />
               <?php echo _HTML_YES; ?>
            </td>
            <td align="left" valign="top" class="contentpane">

            <textarea style="width: <?php echo $sbConfig['rtewidth']?>px; height: 60px;" class="inputbox" onMouseOver="textCounter(this.form.message,this.form.counter,<?php echo $sbConfig['maxSig'];?>);" onClick="textCounter(this.form.message,this.form.counter,<?php echo $sbConfig['maxSig'];?>);" onKeyDown="textCounter(this.form.message,this.form.counter,<?php echo $sbConfig['maxSig'];?>);" onKeyUp="textCounter(this.form.message,this.form.counter,<?php echo $sbConfig['maxSig'];?>);" type="text" name="message"><?php echo $signature;?></textarea>
            <br />
               <input type="button" class="button" accesskey="b" name="addbbcode0" value=" B " style="font-weight:bold; width: 30px" onClick="bbstyle(0)" onMouseOver="helpline('b')" />
               <input type="button" class="button" accesskey="i" name="addbbcode2" value=" i " style="font-style:italic; width: 30px" onClick="bbstyle(2)" onMouseOver="helpline('i')" />
               <input type="button" class="button" accesskey="u" name="addbbcode4" value=" u " style="text-decoration: underline; width: 30px" onClick="bbstyle(4)" onMouseOver="helpline('u')" />
               <input type="button" class="button" accesskey="p" name="addbbcode14" value="Img" style="width: 40px"  onClick="bbstyle(14)" onMouseOver="helpline('p')" />
               <input type="button" class="button" accesskey="w" name="addbbcode16" value="URL" style="text-decoration: underline; width: 40px" onClick="bbstyle(16)" onMouseOver="helpline('w')" />
               <br /><?php echo _SMILE_COLOUR; ?>:
               <select name="addbbcode20" onChange="bbfontstyle('[color=' + this.form.addbbcode20.options[this.form.addbbcode20.selectedIndex].value + ']', '[/color]');this.selectedIndex=0;" onMouseOver="helpline('s')">
                    <option style="color:black;  background-color: #FAFAFA" value=""><?php echo _COLOUR_DEFAULT;?></option>
                    <option style="color:red;    background-color: #FAFAFA" value="#FF0000"><?php echo _COLOUR_RED;?></option>
                    <option style="color:blue;   background-color: #FAFAFA" value="#0000FF"><?php echo _COLOUR_BLUE;?></option>
                    <option style="color:green;  background-color: #FAFAFA" value="#008000"><?php echo _COLOUR_GREEN;?></option>
                    <option style="color:yellow; background-color: #FAFAFA" value="#FFFF00"><?php echo _COLOUR_YELLOW;?></option>
                    <option style="color:orange; background-color: #FAFAFA" value="#FF6600"><?php echo _COLOUR_ORANGE;?></option>
                    </select>
               <?php echo _SMILE_SIZE; ?>: <select name="addbbcode22" onChange="bbfontstyle('[size=' + this.form.addbbcode22.options[this.form.addbbcode22.selectedIndex].value + ']', '[/size]')" onMouseOver="helpline('f')">
                    <option value="1"><?php echo _SIZE_VSMALL;?></option>
                    <option value="2"><?php echo _SIZE_SMALL;?></option>
                    <option value="3" selected="selected"><?php echo _SIZE_NORMAL;?></option>
                    <option value="4"><?php echo _SIZE_BIG;?></option>
                    <option value="5"><?php echo _SIZE_VBIG;?></option>
                    </select>
               <br />
               <input type="text" name="helpbox" size="45" maxlength="100" style="width: <?php echo $sbConfig['rtewidth']?>px; font-size:9px" class="helpline" value="<?php echo _BBCODE_HINT;?>" />
           <br /> <a href="javascript:bbstyle(-1)" onMouseOver="helpline('a')"><small><?php echo _BBCODE_CLOSA;?></small></a></span><br />
			   <input type="checkbox" value="1" name="deleteSig"><i> <?php echo _USER_DELETE;?></i>
            </td>

         </tr>
         <tr>
           <td colspan="2" class="contentpane" style="vertical-align: top;">&nbsp;</td>
           <td  class="contentpane">&nbsp;</td>
         </tr>
         <tr>
           <td class="contentpane" style="vertical-align: top;"><?php if ($sbConfig['allowAvatar']){?>
               <?php echo _YOUR_AVATAR."</td><td class=\"contentpane\">";
					if ($sbConfig['avatar_src']=="pmspro"){
						if ($avatar!=""){?>
						<img src="components/com_mypms/pictures/<?php echo $avatar;?>" ><br />
						<a href="<?php echo sefRelToAbs('index.php?option=com_mypms&amp;task=upload');?>"><?php echo _SET_NEW_AVATAR; ?></a>
						<?php
						}else{echo _NON_SELECTED;?>
						<a href="<?php echo sefRelToAbs('index.php?option=com_mypms&amp;task=upload');?>"><?php echo _SET_NEW_AVATAR; ?></a>
						<?php
						}
						}
               elseif ($sbConfig['avatar_src']=="cb"){
						if ($avatar!=""){?>
						<img src="components/com_comprofiler/images/<?php echo $avatar;?>" ><br />
						<a href="<?php echo sefRelToAbs('index.php?option=com_comprofiler&amp;Itemid=117&amp;task=userAvatar');?>"><?php echo _SET_NEW_AVATAR; ?></a>
						<?php
						}else{echo _NON_SELECTED;?>
						<a href="<?php echo sefRelToAbs('index.php?option=com_comprofiler&amp;Itemid=117&amp;task=userAvatar');?>"><?php echo _SET_NEW_AVATAR; ?></a>
						<?php
						}
						}
				   else {
						if ($avatar!=""){?>
                  		<img src="components/com_joomlaboard/avatars/<?php echo $avatar;?>" ><br />
						<a href="<?php echo sefRelToAbs('index.php?option=com_joomlaboard&amp;Itemid='.$Itemid.'&amp;func=upload');?>">
						<?php echo _SET_NEW_AVATAR; ?></a><br />
                        <input type="checkbox" value="1" name="deleteAvatar"><i> <?php echo _USER_DELETEAV;?></i>
                  		<?php
                  		}else{echo _NON_SELECTED;?>
						<a href="<?php echo sefRelToAbs('index.php?option=com_joomlaboard&amp;Itemid='.$Itemid.'&amp;func=upload');?>">
						<?php echo _SET_NEW_AVATAR; ?></a>
						<?php }?>
                  	<input type="hidden" value="<?php echo $avatar;?>" name="avatar">
					<?php }?>
            </td>
            <?php } else { echo "<td>&nbsp;"; echo '<input type="hidden" value="" name="avatar"></td>'; }?>
         </tr>
         <tr>
           <td colspan="2" class="contentpane">&nbsp;</td>
           <td  class="contentpane">&nbsp;</td>
         </tr>


         <tr><td colspan=2><input type="checkbox" name="unsubscribeAll" value="1"><i><?php echo _USER_UNSUBSCRIBE_ALL;?></i></td></tr>
         <tr cellspacing="3" colspan="3">
            <td colspan="3" class="sectiontableheader" align="center">&nbsp;<input type="submit" class="button" value="<?php echo _GEN_SUBMIT;?>"></td>
         </tr>
      </table>
      </form>
      <br />
	<?php } ?>
      <table border=0 cellspacing=0 width="100%" align="center" class="contentpane">
         <tr>
            <td colspan="2" class="sectiontableheader"><?php echo _USER_SUBSCRIPTIONS;?></td>
         </tr>
         <?php
         $enum=1;//reset value
         $tabclass = array("sectiontableentry1", "sectiontableentry2");//alternating row CSS classes
         $k=0; //value for alternating rows
         if($csubslist >0){
            foreach($subslist as $subs){//get all message details for each subscription
               $database->setQuery("select * from #__sb_messages where id=$subs->thread");
               $subdet=$database->loadObjectList();
               foreach($subdet as $sub){
                  $k=1-$k;
                  echo "<tr>";
                  echo '  <td class="'.$tabclass[$k].'">'.$enum.': <a href="index.php?option=com_joomlaboard&amp;Itemid='.$Itemid.'&amp;func=view&amp;catid='.$sub->catid.'&amp;id='.$sub->id.'">'.$sub->subject.'</a> - ' ._GEN_BY. ' ' .$sub->name;
                  echo '  <td class="'.$tabclass[$k].'"><a href="index.php?option=com_joomlaboard&amp;Itemid='.$Itemid.'&amp;func=userprofile&do=unsubscribe&thread='.$subs->thread.'">' ._THREAD_UNSUBSCRIBE. '</a>';
                  echo "</tr>";
                  $enum++;
               }
            }
         }
         else{
            echo '<tr><td>'._USER_NOSUBSCRIPTIONS.'</td></tr>';
         }
      ?>
      </table>
      <br />
      <table border=0 cellspacing=0 width="100%" align="center" class="contentpane">

         <tr>
            <td colspan="2" class="sectiontableheader"><?php echo _USER_MODERATOR;?>:</td>
         </tr>
         <?php
         if (!$is_admin)
         {
            $enum=1;//reset value
            $tabclass = array("sectiontableentry1", "sectiontableentry2");//alternating row CSS classes
            $k=0; //value for alternating rows
            if($cmodslist >0){
               foreach($modslist as $mods){//get all moderator details for each moderation
                     $k=1-$k;
                     echo "<tr>";
                     echo ' <td class="'.$tabclass[$k].'">'.$enum.': '.$mods->name.'</td>';
                     echo "</tr>";
                     $enum++;
               }
            }
            else
            {
               echo "<tr><td>"._USER_MODERATOR_NONE."</td></tr>";
            }
        }
        else
        {
            echo "<tr><td>"._USER_MODERATOR_ADMIN."</td></tr>";
        }
      echo "</table>";

   }
   else if($do == "update")
   {//we update anything
   $deleteAvatar   = mosGetParam( $_POST, 'deleteAvatar'  , 0      );
   $deleteSig      = mosGetParam( $_POST, 'deleteSig'     , 0      );
   $unsubscribeAll = mosGetParam( $_POST, 'unsubscribeAll', 0      );
   $signature      = mosGetParam( $_POST, 'message'       , ''     );
   $newview        = mosGetParam( $_POST, 'newview'       , 'flat' );
   $avatar         = mosGetParam( $_POST, 'avatar'        , ''     );
   (int)$neworder  = mosGetParam( $_POST, 'neworder'      , 0      );
   if($deleteSig == 1){$signature="";}
   $signature=trim(htmlentities(addslashes($signature)));
   //parse the message for some preliminary bbcode and stripping of HTML
   $signature = smile::bbencode_first_pass($signature);

   if($deleteAvatar == 1){$avatar="";}
   $database->setQuery("UPDATE #__sb_users set signature='$signature', view='$newview', avatar='$avatar', ordering='$neworder' where userid=$my_id");
   setcookie("sboard_settings[current_view]",$newview);

   if(!$database->query()) {
      echo _USER_PROFILE_NOT_A." <strong><font color=\"red\">"._USER_PROFILE_NOT_B."</font></strong> "._USER_PROFILE_NOT_C.".<br /><br />";
   }else {
      echo _USER_PROFILE_UPDATED."<br /><br />";
   }
   echo _USER_RETURN_A." <a href=\"index.php?option=com_joomlaboard&amp;Itemid=$Itemid&amp;func=userprofile&do=show\">"._USER_RETURN_B."</a><br /><br />";
   if ($unsubscribeAll){
      $database->setQuery("DELETE FROM #__sb_subscriptions WHERE userid='$my_id'");
      $database->query();
   }
   ?>
   <script language="javascript">
      setTimeout("location='index.php?option=com_joomlaboard&Itemid=<?php echo $Itemid;?>&func=userprofile&do=show'",3500);
   </script>
   <?php
   }
   else if($do == "unsubscribe")
   {//ergo, ergo delete
      $database->setQuery("DELETE from #__sb_subscriptions where userid=$my->id and thread=$thread");
      if(!$database->query()) {
         echo _USER_UNSUBSCRIBE_A." <strong><font color=\"red\">"._USER_UNSUBSCRIBE_B."</font></strong> "._USER_UNSUBSCRIBE_C.".<br /><br />";
      }else {
         echo _USER_UNSUBSCRIBE_YES.".<br /><br />";
      }
      if ($sbConfig['cb_profile']) {
      	echo _USER_RETURN_A." <a href=\"index.php?option=com_comprofiler&amp;Itemid='.$cbitemid.'&amp;tab=getForumTab\">"._USER_RETURN_B."</a><br /><br />";
      	?>
      	<script language="javascript">
      	   setTimeout("location='index.php?option=com_comprofiler&Itemid=<?php echo $cbitemid; ?>&tab=getForumTab'",3500);
      	</script>
      	<?php
      } else {

      echo _USER_RETURN_A." <a href=\"index.php?option=com_joomlaboard&amp;Itemid=$Itemid&amp;func=userprofile&do=show\">"._USER_RETURN_B."</a><br /><br />";
      ?>
      <script language="javascript">
         setTimeout("location='index.php?option=com_joomlaboard&Itemid=<?php echo $Itemid;?>&func=userprofile&do=show'",3500);
      </script>
      <?php
      }
   }
   else
   {//you got me there... don't know what to $do
      echo _USER_ERROR_A;
      echo _USER_ERROR_B."<br /><br />";
      echo _USER_ERROR_C."<br /><br />"._USER_ERROR_D.": <code>SB001-up-02NoDO</code><br /><br />";
   }
}
else
{//get outa here, you fraud!
   echo _USER_ERROR_A;
   echo _USER_ERROR_B."<br /><br />";
   echo _USER_ERROR_C."<br /><br />"._USER_ERROR_D.": <code>SB001-up-01NLO</code><br /><br />";
   //that should scare 'em off enough... ;-)
}
?>
