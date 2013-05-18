<?php
/**
* write.html.php generates post form
* @package com_joomlaboard
* @copyright (C) 2000 - 2007 TSMF / Jan de Graaff / All Rights Reserved
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* @author TSMF
* Joomla! is Free Software
**/

// ################################################################
// MOS Intruder Alerts
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );
// ################################################################

//Some initial thingies needed anyway:
$htmlText=stripslashes($htmlText);
$setFocus=0;
    include_once( JB_ABSADMPATH.'/joomlaboard_config.php' );
    ?>
<script type="text/javascript" src="<?php echo sefRelToAbs(JB_LIVEURL.'&amp;no_html=1&amp;func=sb_bbjs'); ?>"></script>
   <table width="100%" border="0" cellspacing="1" cellpadding="3" style="text-align: left;">

   <tr>
      <td colspan="2" class="sectiontableheader"><strong><?php echo _POST_MESSAGE;?>"<?php echo $catName;?>"</strong></td>
   </tr>
   <tr>
      <td class="sb_leftcolumn"><strong><?php echo _GEN_NAME;?></strong>:</td>
     
<?php
if ( ! $is_moderator && $sbConfig['changename']=='0' && $my->id > 0) {
	echo '<td><input type="hidden" name="sb_authorname" size="35" class="inputbox" maxlength="35" value="' . $authorName . '" />' . $authorName . '</td>';
}
else {
	echo '<td><input type="text" name="sb_authorname" size="35" class="inputbox" maxlength="35" value="' . $authorName . '" /></td>';
    if ($my->id <= 0) {
    	echo "<script type=\"text/javascript\">document.postform.sb_authorname.focus();</script></td>";
    	$setFocus=1;
	} 
}
?>
   </tr>


<?php
if ($sbConfig['askemail']) {
	echo '<tr><td class="sb_leftcolumn"><strong>*' . _GEN_EMAIL .'</strong>:</td>';
	if ( ! $is_moderator && $my->id > 0 && $sbConfig['changename'] == 0) 
		echo '<td><input type="hidden" name="email" value="' . $my->email . '" />' . $my->email . '</td>';
	else
		echo '<td><input type="text" name="email" size="35" class="inputbox" maxlength="35" value="' . $my_email . '" /></td>';
}
else {
	if ($my->id > 0)
		echo '<tr><td><input type="hidden" name="email" value="'.$my->email.'" /></td></tr>';
	else 
		echo '<tr><td><input type="hidden" name="email" value="anonymous@forum.here" /></td></tr>';
}?>

   <tr>
      <?php if ( ! $fromBot) {
         ?>
         <td class="sb_leftcolumn"><strong><?php echo _GEN_SUBJECT;?></strong>:</td><td><input type="text" class="inputbox" name="subject" size="35" maxlength="<?php echo $sbConfig['maxSubject'];?>" value="<?php echo $resubject;?>" /></td>
         <?php
         }
         else {
         ?>
         <td class="sb_leftcolumn"><strong><?php echo _GEN_SUBJECT;?></strong>:</td><td><input type="hidden" class="inputbox" name="subject" size="35" maxlength="<?php echo $sbConfig['maxSubject'];?>" value="<?php echo $resubject;?>" /><?php echo $resubject;?></td>
         <?php
         } ?>
      <?php
      if($setFocus==0 && $replyto==0 && ! $fromBot )
      {echo "<script type=\"text/javascript\">document.postform.subject.focus();</script>"; $setFocus=1;}
      ?>
   </tr>
   <tr>
      <td class="sb_leftcolumn"><strong><?php echo _GEN_TOPIC_ICON;?></strong>:</td>
       <td>
         <?php
         $topicToolbar = smile::topicToolbar(0,$sbConfig['rtewidth']);
         echo $topicToolbar;
         ?>
      </td>
   </tr>

      <?php
      $sbTextArea=smile::SbWriteTextarea('message', $htmlText, $sbConfig['rtewidth'],$sbConfig['rteheight'], 0, $sbConfig['disemoticons']);
      echo $sbTextArea;
		if($setFocus==0){echo "<script type=\"text/javascript\">document.postform.message.focus();</script>";}
   //check if this user is already subscribed to this topic but only if subscriptions are allowed
   if($sbConfig['allowsubscriptions']==1){


      if($replyto==0) {
         $sb_thread=-1;
      }
      else{
         $database->setQuery("select thread from #__sb_messages where id=$replyto");

         $sb_thread=$database->loadResult();
      }


      $database->setQuery("SELECT thread from #__sb_subscriptions where userid=$my_id and thread='$sb_thread'");
      $sb_subscribed=$database->loadResult();
      if ($sb_subscribed == "" || $replyto == 0 ){$sb_cansubscribe=1;} else {$sb_cansubscribe=0;}
   }
            if( ( $sbConfig['allowImageUpload'] || ($sbConfig['allowImageRegUpload'] && $my->id != 0 ) || $is_moderator ) && ($no_upload=="0" || $no_image_upload=="0") ) { ?>
                <tr>
                  <td class="sb_leftcolumn"><strong><?php echo _IMAGE_SELECT_FILE;?></strong></td><td> <input type='file' class='button' name='attachimage' onmouseover="helpline('iu')" />
                  <input type="button" class="button" name="addImagePH" value="<?php echo _POST_ATTACH_IMAGE;?>" style="cursor:hand; width: 40px" onclick="javascript:emo(' [img] ');" onmouseover="helpline('ip')" />
                  </td>
               </tr>
               <?php
            }?>
         <?php
            if( ( $sbConfig['allowFileUpload'] || ($sbConfig['allowFileRegUpload'] && $my->id != 0) || $is_moderator ) && ($no_upload=="0" || $no_file_upload=="0") ){ ?>
                  <tr>
                  <td class="sb_leftcolumn"><strong><?php echo _FILE_SELECT_FILE;?></strong></td><td> <input type='file' class='button' name='attachfile' onmouseover="helpline('fu')" style="cursor:hand" />
                  <input type="button" class="button" name="addFilePH" value="<?php echo _POST_ATTACH_FILE;?>" style="cursor:hand; width: 40px" onclick="javascript:emo(' [file] ');" onmouseover="helpline('fp')" />
                  </td>
                  </tr>
         <?php
            }
            if($my_id != 0 && $sbConfig['allowsubscriptions'] == 1 && $sb_cansubscribe == 1 && ! $editmode) {?>
      			<tr>
         		<td class="sb_leftcolumn"><strong><?php echo _POST_SUBSCRIBE;?></strong>:</td>
         		<td>
            	<input type="checkbox" name="subscribeMe" value="1" /> <i><?php echo _POST_NOTIFIED;?></i>
         		</td>
      		</tr>
      	<?php }  ?>
                  <tr>
         <td colspan="2" style="text-align: center;">
            <input type="submit" class="button" name="submit" value="<?php echo _GEN_CONTINUE;?>"  onclick="return submitForm()" onmouseover="helpline('submit')" />
            <input type="button" class="button" value="<?php echo _PREVIEW;?>" onclick="Preview('<?php echo JB_JCSSURL;?>', '<?php echo JB_DIRECTURL;?>', '<?php echo $sbConfig['template'];?>', '<?php echo $sbConfig['disemoticons'];?>')" onmouseover="helpline('preview')" />
            <input type="button" class="button" value="<?php echo _GEN_CANCEL;?>" onclick="javascript:window.history.back();" onmouseover="helpline('cancel')" />
         </td>
      </tr>
 
     </table>
   </form></td>
</tr>
<tr>
   <td>
      <?php
		if ($sbConfig['askemail']) {
      	echo $sbConfig['showemail']=='0'?"<em>* - "._POST_EMAIL_NEVER."</em>":"<em>* - "._POST_EMAIL_REGISTERED."</em>";
		}
      ?>
   </td>
</tr>
<tr>
<td style="text-align: left;">
<br />
<?php
$no_upload="0";//reset the value.. you just never know..
if ($sbConfig['showHistory']==1)
{
   listThreadHistory($replyto,$sbConfig,$database);
}
?>
