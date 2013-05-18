<?php
/**
* post.php handles everything related to posts
* @package com_joomlaboard
* @copyright (C) 2000 - 2007 TSMF / Jan de Graaff / All Rights Reserved
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* @author TSMF
* Joomla! is Free Software
**/
// Dont allow direct linking
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );


// get variables
$action		=		mosGetParam($_POST	 , 'action'		, '');
$resubject	= 		mosGetParam($_REQUEST, 'resubject'	, '');
$replyto	= (int)	mosGetParam($_REQUEST, 'replyto'	, 0);
$ip			=		$_SERVER["REMOTE_ADDR"];  //ip for floodprotection, post logging, subscriptions, etcetera
$editmode	=		0;
$catName	=		$thisCat->getName();
if ($my->id > 0) {
	$my_name = $sbConfig['username'] ? $my->username : $my->name;
	$my_email= $my->email;
}
else {
	$my_name = '';
	$my_email= '';
}

// permissions check
switch (sb_has_post_permission($database,$catid,$replyto,$my->id,$sbConfig['pubwrite'],$is_moderator)) {
	case 0:
		echo "<p align=\"center\">";
		echo _POST_NO_PUBACCESS1."<br />";
		echo _POST_NO_PUBACCESS2."<br /><br />";
		if ($sbConfig['cb_profile']) {
        	echo '<a href="'.sefRelToAbs('index.php?option=com_comprofiler&amp;task=registers').'">'._POST_NO_PUBACCESS3.'</a><br /></p>';
        } 
		else {
        	echo '<a href="'.sefRelToAbs('index.php?option=com_registration&amp;task=register').'">'._POST_NO_PUBACCESS3.'</a><br /></p>';
		}
		return;
	case -1:
		echo '<p align="center">' . _GEN_TOPIC ._POST_LOCKED.'<br />';
        echo _POST_NO_NEW.'<br /></p>';
        return;
	case -2:
		echo '<p align="center">' . _GEN_FORUM ._POST_LOCKED.'<br />';
        echo _POST_NO_NEW.'<br /></p>';
		return;	
}

// flood protection
$sbConfig['floodprotection'] = (int) $sbConfig['floodprotection'];

if ($sbConfig['floodprotection'] != 0) {
	$database->setQuery("select max(time) from #__sb_messages where ip='$ip'");
    $lastPostTime=$database->loadResult();
}
if ( ! $is_moderator && $do!='edit' && $sbConfig['floodprotection'] == 1 && ($lastPostTime+$sbConfig['floodprotection']) >= $systime) {
   echo _POST_TOPIC_FLOOD1;
   echo $sbConfig['floodprotection']." "._POST_TOPIC_FLOOD2."<br />";
   echo _POST_TOPIC_FLOOD3;
   return;
}

?>

   <table border="0" cellspacing="0" cellpadding="0" width="100%" align="center">
      <tr>
         <td>


   <?php
if ($action=="post"){
  
      ?>
         <table border="0" cellspacing="1" cellpadding="3" width="70%" align="center" class="contentpane"><tr><td>
            <?php
            $parent=(int)$parentid;
            $message	= isset($_POST['message']) ? trim($_POST['message']) : '';
            if (empty($sb_authorname))
            {
               echo _POST_FORGOT_NAME;
            }
            else if (empty($subject))
            {
               echo _POST_FORGOT_SUBJECT;
            }
            else if (empty($message))
            {
               echo _POST_FORGOT_MESSAGE;
            }
            else
            {
               if ($parent == 0)
                  $thread = $parent = 0;


			   $database->setQuery("SELECT id,thread,parent FROM #__sb_messages WHERE id='$parent'");
			   $database->query();
               if ($database->getNumRows() == 0)
               {
                  // bad parent, create a new post
                  $parent = 0;
                  $thread = 0;
               }
               else
               {
				  $database->loadObject($m);
                  $thread = $m->parent==0?$m->id:$m->thread;
               }


               if ($catid == 0 )
               {
                  $catid = 1; //make sure there's a proper category
               }

               if ($attachfile != '' ) {
                  $noFileUpload=0;
                  include JB_ABSPATH.'/file_upload.php';
                  if ($rc==0){
                     $noFileUpload=1;
                  }
               }
               if ($attachimage != '' ) {
                  $noImgUpload=0;
                  include JB_ABSPATH.'/image_upload.php';
                  if ($rc==0){
                     $noImgUpload=1;
                  }
               }
               $messagesubject=$subject;//before we add slashes and all... used later in mail
               $sb_authorname=trim(addslashes($sb_authorname));
               $subject=trim(htmlspecialchars(addslashes($subject))); 
               $message=trim(htmlspecialchars(addslashes($message)));
               if ($contentURL != "empty") { $message= $contentURL.'\n\n'.$message;}
               //parse the message for some preliminary bbcode and stripping of HTML
               $message = smile::bbencode_first_pass($message);
               $subject = smile::bbencode_first_pass($subject);

               //--
               $email=trim(addslashes($email));
               $topic_emoticon=(int)$topic_emoticon;
               $topic_emoticon=$topic_emoticon>7?0:$topic_emoticon;
               $posttime=time()+($sbConfig['board_ofset']*3600);

               //check if the post must be reviewed by a Moderator prior to showing
               //doesn't apply to admin/moderator posts ;-)
               $holdPost=0;
               if (!$is_moderator){
                  $database->setQuery("SELECT review FROM #__sb_categories WHERE id=$catid");
                  $holdPost=$database->loadResult();
               }


			   $database->setQuery("INSERT INTO #__sb_messages (parent,thread,catid,name,userid,email,subject,time,ip,topic_emoticon,hold) VALUES('$parent','$thread','$catid','$sb_authorname','$my_id','$email','$subject','$posttime','$ip','$topic_emoticon','$holdPost')");
               if ($database->query())
               {
                  $pid=$database->insertId();
                  $database->setQuery("INSERT INTO #__sb_messages_text (mesid,message) VALUES('$pid','$message')");
				  $database->query();
                  if ($thread==0){
                     //if thread was zero, we now know to which id it belongs, so we can determine the thread and update it
                     $database->setQuery("UPDATE #__sb_messages SET thread='$pid' WHERE id='$pid'");
					 $database->query();
                  }
                  //update the user posts count
                  if ($my->id != 0){
                     $database->setQuery("UPDATE #__sb_users SET posts=posts+1 WHERE userid='$my->id'");
                     $database->query();
                  }

                  //Update the attachments table if an image has been attached
                  if ( $imageLocation != "" && ! $noImgUpload)
                  {
                     $database->setQuery("INSERT INTO #__sb_attachments (mesid, filelocation) values ('$pid','$imageLocation')");
                     if (!$database->query()){
                        echo "<script> alert('Storing image failed: ".$database->getErrorMsg()."'); </script>\n";
                     }
                  }
                  //Update the attachments table if an file has been attached
                  if ( $fileLocation != ""  && ! $noFileUpload)
                  {
                     $database->setQuery("INSERT INTO #__sb_attachments (mesid, filelocation) values ('$pid','$fileLocation')");
                     if (!$database->query()){
                        echo "<script> alert('Storing file failed: ".$database->getErrorMsg()."'); </script>\n";
                     }
                  }
                  //Now manage the subscriptions (only if subscriptions are allowed)
                  if($sbConfig['allowsubscriptions'] == 1) {//they're allowed
                     //get the proper user credentials for each subscription to this topic
                     if ($thread==0){
                        $querythread=$pid;
                     } else {
                        $querythread=$thread;
                     }

                     //clean up the message
                     $mailmessage=smile::purify($message);

                     $database->setQuery("SELECT * FROM #__sb_subscriptions AS a"
                     . "\n LEFT JOIN #__users as u"
                     . "\n ON a.userid=u.id "
                     . "\n WHERE a.thread= '$querythread'");
                     $subsList=$database->loadObjectList();

                     //construct a useable URL
                     $messageUrl=sefRelToAbs($mosConfig_live_site."/index.php?option=com_joomlaboard&Itemid=$Itemid&func=view&catid=$catid&id=$pid")."#$pid";

                     if(count($subsList)>0){//we got more than 0 subscriptions
                        foreach($subsList as $subs){
                           $mailsubject = "$_COM_A_NOTIFICATION $board_title";

                           $msg  = "$subs->name,\n";
                           $msg .= "$_COM_A_NOTIFICATION1 $board_title forum\n";
                           $msg .= "Subject: '".stripslashes($messagesubject)."' in Forum: '".stripslashes($catName)."'\n";
                           $msg .= "Posted by: ". stripslashes($sb_authorname) . "\n\n";
                           $msg .= "$_COM_A_NOTIFICATION2\n";
                           $msg .= "URL: $messageUrl\n\n";
                           $msg .= "Post:\n";
                           $msg .= stripslashes($mailmessage);
                           $msg .= "\n\n";
                           $msg .= "$_COM_A_NOTIFICATION3\n";
                           $msg .= "\n\n\n\n\n";
                           $msg .= "** Joomlaboard Forum Component by Jan de Graaff **\n";
                           $msg .= "** the Two Shoes M-Factory - http://www.tsmf.net **";

                           if($ip != "127.0.0.1" && $my_id != $subs->id){//don't mail yourself
                              mosmail($sbConfig['email'],"Forum at ". $_SERVER['SERVER_NAME'],$subs->email,$mailsubject,$msg);
                           }
                        }
                     }
                  }
                  //Now manage the mail for moderators (only if configured)
                  if($sbConfig['mailmod'] == '1') {//they're configured
                     //get the proper user credentials for each moderator for this forum
                     $database->setQuery("SELECT * FROM #__sb_moderation AS a"
                     . "\n LEFT JOIN #__users AS u"
                     . "\n ON a.userid=u.id"
                     . "\n WHERE a.catid=$catid");
                     $modsList=$database->loadObjectList();

                     if(count($modsList)>0){//we got more than 0 moderators eligible for email
                        foreach($modsList as $mods){
                           $mailsubject = "$_COM_A_NOTIFICATION $board_title";

                           $msg  = "$mods->name,\n";
                           $msg .= "$_COM_A_NOT_MOD1 $board_title forum\n";
                           $msg .= "Subject: '".stripslashes($messagesubject)."' in Forum: '".stripslashes($catName)."'\n";
                           $msg .= "Posted by: ". stripslashes($sb_authorname) . "\n\n";
                           $msg .= "$_COM_A_NOT_MOD2\n";
                           $msg .= "URL: $messageUrl\n\n";
                           $msg .= "Post:\n";
                           $msg .= stripslashes($mailmessage);
                           $msg .= "\n\n";
                           $msg .= "$_COM_A_NOTIFICATION3\n";
                           $msg .= "\n\n\n\n\n";
                           $msg .= "** Joomlaboard Forum Component by TSMF **\n";
                           $msg .= "** the Two Shoes M-Factory - http://www.tsmf.net **";

                           if($ip != "127.0.0.1"  && $my_id != $mods->id){//don't mail yourself
							   //Send away
                               mosmail($sbConfig['email'],"Forum at ". $_SERVER['SERVER_NAME'],$mods->email,$mailsubject,$msg);
                           }
                        }
                     }
                  }
                  //now try adding any new subscriptions if asked for by the poster
                  if($subscribeMe == 1){
                     if ($thread==0){$sb_thread=$pid;}else{$sb_thread=$thread;}
                     $database->setQuery("INSERT INTO #__sb_subscriptions (thread,userid) VALUES ('$sb_thread','$my_id')");
                     if ($database->query()){
                        echo _POST_SUBSCRIBED_TOPIC."<br /><br />";
                     }else{
                        echo _POST_NO_SUBSCRIBED_TOPIC."<br /><br />";
                     }
                  }


                  if($holdPost==1){
                     echo _POST_SUCCES_REVIEW.' <a href="'.sefRelToAbs('index.php?option=com_joomlaboard&amp;Itemid='.$Itemid.'&amp;func=showcat&catid='.$catid).'">'._GEN_CONTINUE.'</a>.';
                  }else{
                     echo '<div align="center">'._POST_SUCCESS_POSTED.'<br /><br />';
                     echo '<a href="'.sefRelToAbs('index.php?option=com_joomlaboard&amp;Itemid='.$Itemid.'&amp;func=view&catid='.$catid.'&amp;id='.$pid).'#'.$pid.'">'._POST_SUCCESS_VIEW.'</a><br />';
                     echo '<a href="'.sefRelToAbs('index.php?option=com_joomlaboard&amp;Itemid='.$Itemid.'&amp;func=showcat&catid='.$catid).'">'._POST_SUCCESS_FORUM.'</a><br />';
                     echo '</div>';
                  ?>
                  <script language="javascript">
                     setTimeout("location='<?php echo sefRelToAbs('index.php?option=com_joomlaboard&Itemid='.$Itemid.'&func=view&catid='.$catid.'&id='.$pid).'#'.$pid;?>'",3500);
                  </script>
                  <?php
                  }
                }
               else
               {
                  echo _POST_ERROR_MESSAGE;
               }
            }?>
            </td></tr></table>
            <?php
}
else if ($action=="cancel") {
	echo '<br /><br /><div align="center">'._SUBMIT_CANCEL."</div><br />";
	echo '<div align="center">'._SUBMIT_CANCEL.'<br /><br />';
	echo '<a href="'.sefRelToAbs('index.php?option=com_joomlaboard&amp;Itemid='.$Itemid.'&amp;func=view&catid='.$catid.'&amp;id='.$pid).'#'.$pid.'">'._POST_SUCCESS_VIEW.'</a><br />';
	echo '<a href="'.sefRelToAbs('index.php?option=com_joomlaboard&amp;Itemid='.$Itemid.'&amp;func=showcat&catid='.$catid).'">'._POST_SUCCESS_FORUM.'</a><br />';
	echo '</div>';
}
else {
     if ($do=="quote") {//reply do quote
		$parentid=0;
                  if ($replyto > 0)
                  {
                     $database->setQuery("SELECT #__sb_messages.*,#__sb_messages_text.message FROM #__sb_messages,#__sb_messages_text WHERE id='$replyto' AND mesid='$replyto'");
					 $database->query();
                     if ($database->getNumRows() > 0)
                     {
						$database->loadObject($message);
                        //$message->message=smile::smileReplace($message->message,0);
                        $table = array_flip(get_html_translation_table(HTML_ENTITIES));
                        $quote = strtr($message->message, $table);
                        $htmlText  = "[b]".stripslashes($message->name)." "._POST_WROTE.":[/b]\n";
                        $htmlText .= '[quote]'.$quote."[/quote]";
                        $quote=smile::sbStripHtmlTags($quote);
                        //$quote=RTESafe_sb(nl2br($quote));
                        $resubject = strtr($message->subject, $table);
                        $resubject = strtolower(substr($resubject,0,strlen(_POST_RE)))==strtolower(_POST_RE)?stripslashes($resubject):_POST_RE.stripslashes($resubject);
                        //$resubject = htmlspecialchars($resubject);
                        $resubject=smile::sbStripHtmlTags($resubject);
                        $parentid = $message->id;
                        $authorName=$my_name;
                     }
                  }

                  ?>
                  <form action="<?php echo sefRelToAbs(JB_LIVEURL.'&amp;func=post'); ?>" method="post" name="postform" enctype="multipart/form-data">
                  <input type="hidden" name="parentid" value="<?php echo $parentid;?>" />
                  <input type="hidden" name="catid" value="<?php echo $catid;?>" />
                  <input type="hidden" name="action" value="post" />
                  <input type="hidden" name="contentURL" value="empty" />
                  <?php
                  //get the writing stuff in:
                  $no_upload="0";//only edit mode should disallow this
                  include(JB_ABSPATH.'/write.html.php');
                  //--
	}
    else if ($do=="reply") {// reply no quote
		$parentid=0;
        $setFocus=0;
        if ($replyto > 0) {
        	$database->setQuery('SELECT #__sb_messages.*,#__sb_messages_text.message'. 
								"\n". 'FROM #__sb_messages,#__sb_messages_text'.
								"\n".  'WHERE id='.$replyto.' AND mesid='.$replyto);
			$database->query();
            if ($database->getNumRows() > 0){
				$database->loadObject($message);
                $table = array_flip(get_html_translation_table(HTML_ENTITIES));
                $resubject = htmlspecialchars(strtr($message->subject, $table));
                $resubject = strtolower(substr($resubject,0,strlen(_POST_RE)))==strtolower(_POST_RE)?stripslashes($resubject):_POST_RE.stripslashes($resubject);
                $parentid = $message->id;
			}
		}
		$htmlText="";
        $authorName=$my_name;

        ?>
        <form action="<?php echo sefRelToAbs('index.php?option=com_joomlaboard&amp;Itemid='.$Itemid . '&amp;func=post'); ?>" method="post" name="postform" enctype="multipart/form-data">
        <input type="hidden" name="parentid" value="<?php echo $parentid;?>" />
        <input type="hidden" name="catid" value="<?php echo $catid;?>" />
        <input type="hidden" name="action" value="post" />
        <input type="hidden" name="contentURL" value="empty" />
        <?php
        //get the writing stuff in:
        $no_upload="0";//only edit mode should disallow this
        include(JB_ABSPATH.'/write.html.php');
        //--
	}
    else if ($do=="newFromBot") {// The Mosbot "discuss on forums" has detected an unexisting thread and wants to create one
		$parentid=0;
        $setFocus=0;
//      $resubject = base64_decode($resubject); //per mf#6100  -- jdg 16/07/2005
		$resubject = base64_decode(strtr($resubject, "()", "+/"));
        $resubject = str_replace("%20"," ",$resubject);
        $resubject = preg_replace('/%32/','&',$resubject);
        $resubject = preg_replace('/%33/',';',$resubject);
        $resubject = preg_replace("/\'/",'&#039;',$resubject);
        $resubject = preg_replace("/\"/",'&quot;',$resubject);

		//$table = array_flip(get_html_translation_table(HTML_ENTITIES));
        //$resubject = strtr($resubject, $table);
        $fromBot=1; //this new topic comes from the discuss mambot
        $authorName=htmlspecialchars($my_name);
		$rowid     = (int) mosGetParam( $_GET, 'rowid', 0 );
		$rowItemid = (int) mosGetParam( $_GET, 'rowItemid', 0 );
		if ( $rowItemid ) {
			$contentURL=sefRelToAbs('index.php?option=content&task=view&amp;Itemid='.$rowItemid.'&amp;id='.$rowid);
		  }
		  else {
		    $contentURL=sefRelToAbs('index.php?option=content&task=view&amp;Itemid=1&amp;id='.$rowid);
		  }
                  $contentURL= _POST_DISCUSS.': [url='.$contentURL.']'.$resubject.'[/url]';

                  ?>
                  <form action="<?php echo sefRelToAbs("index.php?option=com_joomlaboard&amp;Itemid=$Itemid&amp;func=post");?>" method="post" name="postform" enctype="multipart/form-data">
                  <input type="hidden" name="parentid" value="<?php echo $parentid;?>" />
                  <input type="hidden" name="catid" value="<?php echo $catid;?>" />
                  <input type="hidden" name="action" value="post" />
                  <input type="hidden" name="contentURL" value="<?php echo $contentURL ;?>" />
                  <?php
                  //get the writing stuff in:
                  $no_upload="0";//only edit mode should disallow this
                  include(JB_ABSPATH.'/write.html.php');
                  //--
                  //echo "</form>";
	}
    else if ($do == "edit") {
    	$allowEdit=0; 
        $id=(int)$id;
        $mess=null;
        $database->setQuery("SELECT * FROM #__sb_messages LEFT JOIN #__sb_messages_text ON #__sb_messages.id=#__sb_messages_text.mesid WHERE #__sb_messages.id='$id'");
        $database->loadObject($mes);

		// Check permission
    	$allowEdit=0;
    	if ($is_moderator) {
	    	$allowEdit=1;
		}
		elseif ($sbConfig['useredit']==1 && $my->id >0 && $my->id == $mes->userid ) {
        	$allowEdit=1;
		}
		if (!$allowEdit) {
			echo '<p>Hacking attempt!</p>';
			return;
		}
        //we're now in edit mode
        $editmode=1;
		$htmlText=smile::sbStripHtmlTags($mes->message);
		$table = array_flip(get_html_translation_table(HTML_ENTITIES));
        $htmlText = strtr($htmlText, $table);
        $htmlText=smile::sbHtmlSafe($htmlText);
        $resubject=htmlspecialchars(stripslashes($mes->subject));
        $authorName=htmlspecialchars($mes->name);
		?>
		<form action="<?php echo sefRelToAbs("index.php?option=com_joomlaboard&Itemid=$Itemid&catid=$catid&func=post"); ?>" method="post" name="postform" enctype="multipart/form-data" />
        <input type="hidden" name="id" value="<?php echo $mes->id;?>" />
        <input type="hidden" name="do" value="editpostnow" />
        <?php
		// get the writing stuff in:
        // first check if there is an uploaded image or file already for this post (no new ones allowed)
        $no_file_upload=0;
        $no_image_upload=0;
		$database->setQuery("SELECT filelocation FROM #__sb_attachments WHERE mesid='$id'");
        $attachments=$database->loadObjectList();
		if (count($attachments > 0) ) {
			foreach($attachments as $att) {
                if (preg_match("&/uploaded/files/&si", $att->filelocation) ){
                	$no_file_upload="1";
				}
				if (preg_match("&/uploaded/images/&si", $att->filelocation) ){
                	$no_image_upload="1";
				}
			}
		}
		else {
        	$no_upload="0";
		}
        include(JB_ABSPATH.'/write.html.php');
		//echo "</form>";

	}
    else if ($do == "editpostnow") {
		$database->setQuery("SELECT userid FROM #__sb_messages WHERE id='$id'");
        $userid=$database->loadResult();

		// Check permission
    	$allowEdit=0;
    	if ($is_moderator) {
	    	$allowEdit=1;
		}
		elseif ($sbConfig['useredit']==1 && $my->id >0 && $my->id == $userid ) {
        	$allowEdit=1;
		}
		if (!$allowEdit) {
			echo '<p>Hacking attempt!</p>';
			return;
		}
                  if ($attachfile != '' ) {
                     include JB_ABSPATH.'/file_upload.php';
                  }
                  if ($attachimage != '' ) {
                     include JB_ABSPATH.'/image_upload.php';
                  }
		$message	= isset($_POST['message']) ? trim($_POST['message']) : '';
               $message=trim(htmlspecialchars(addslashes($message)));

               if ($sbConfig['editMarkUp']) {
                  $posttime=time()+($sbConfig['board_ofset']*3600);
                  $message = $message."<br /><br />"._EDIT_BY." ".$my->username.", "._EDIT_AT." ".date(_DATETIME, $posttime);
               }
               //parse the message for some preliminary bbcode and stripping of HTML
               $message = smile::bbencode_first_pass($message);
               $id=(int)$id;
               $database->setQuery("SELECT id FROM #__sb_messages WHERE id='$id'");
			   $database->query();
               if ($database->getNumRows() > 0)
               {
                  $database->setQuery("UPDATE #__sb_messages SET name='$sb_authorname', email='".addslashes($email)."', subject='".addslashes($subject)."', topic_emoticon='".((int)$topic_emoticon)."' WHERE id='$id'");
				  $dbr_nameset=$database->query();
                  $database->setQuery("UPDATE #__sb_messages_text SET message='$message' WHERE mesid='$id'");
                  if ($database->query() && $dbr_nameset)
                  {
                     //Update the attachments table if an image has been attached
                     if ( $imageLocation != "" )
                     {
                        $database->setQuery("INSERT INTO #__sb_attachments (mesid, filelocation) values ('$id','$imageLocation')");
                        if (!$database->query()){
                           echo "<script> alert('Storing image failed: ".$database->getErrorMsg()."'); </script>\n";
                        }
                     }
                     //Update the attachments table if an file has been attached
                     if ( $fileLocation != "" )
                     {
                        $database->setQuery("INSERT INTO #__sb_attachments (mesid, filelocation) values ('$id','$fileLocation')");
                        if (!$database->query()){
                           echo "<script> alert('Storing file failed: ".$database->getErrorMsg()."'); </script>\n";
                        }
                     }
                   echo '<div align="center">'._POST_SUCCESS_EDIT.'<br /><br />';
                   echo '<a href="'.sefRelToAbs('index.php?option=com_joomlaboard&amp;Itemid='.$Itemid.'&amp;func=view&catid='.$catid.'&amp;id='.$id).'#'.$id.'">'._POST_SUCCESS_VIEW.'</a><br />';
                   echo '<a href="'.sefRelToAbs('index.php?option=com_joomlaboard&amp;Itemid='.$Itemid.'&amp;func=showcat&catid='.$catid).'">'._POST_SUCCESS_FORUM.'</a><br />';
                   echo '</div>';
                  }
                  else
                     echo _POST_ERROR_MESSAGE_OCCURED;
               }
               else
               {
                  echo _POST_INVALID;
               }
	}
    else if ($do == "delete") {
		if(!$is_moderator){ die("Hacking Attempt!");}
        $id=(int)$id;
        $database->setQuery("SELECT * FROM #__sb_messages WHERE id=$id");
        $message=$database->loadObjectList();
        foreach ($message as $mes) {
                  ?>
				  
				  <form action="<?php echo sefRelToAbs("index.php?option=com_joomlaboard&Itemid=$Itemid&catid=$catid&func=post"); ?>" method="post" name="myform">
                  <input type="hidden" name="do" value="deletepostnow" />
                  <input type="hidden" name="id" value="<?php echo $mes->id;?>" />
                  <?php echo _POST_ABOUT_TO_DELETE;?>: <strong><?php echo stripslashes(htmlspecialchars($mes->subject));?></strong>.<br /><br />
                  <?php echo _POST_ABOUT_DELETE;?><br /><br />
                  <input type="checkbox" checked name="delAttachments" value="delAtt" /> <?php echo _POST_DELETE_ATT;?>
                  <br /><br />
                  <a href="javascript:document.myform.submit();"><?php echo _GEN_CONTINUE;?></a>
                  | <a href="<?php echo sefRelToAbs("index.php?option=com_joomlaboard&amp;Itemid=$Itemid&amp;func=view&catid=$catid;&amp;id=$id");?>"><?php echo _GEN_CANCEL;?></a>
                  </form>
                  <?php
		}
	}
    else if ($do == "deletepostnow") {
		if(!$is_moderator)
			die("Hacking Attempt!");
		$id=(int) mosGetParam($_POST,'id','');
		$dellattach=mosGetParam($_POST,'delAttachments','')=='delAtt'?1:0;
		$thread=sb_delete_post($database,$id,$dellattach);
		switch ($thread) {
			case -1:
				echo _POST_ERROR_TOPIC.'<br />';
				echo 'Could not promote children in post hierarchy. Nothing deleted.';
				break;
			case -2:
				echo _POST_ERROR_TOPIC.'<br />';
				echo 'Could not delete the post(s) - nothing else deleted';
				break;
			case -3:
				echo _POST_ERROR_TOPIC.'<br />';
				echo 'Could not delete the texts of the post(s). Update the database manually (mesid='.$id.').';
				break;
			case -4:
				echo _POST_ERROR_TOPIC.'<br />';
				echo 'Everything deleted, but failed to update user post stats!';
				break;
			case -5:
				echo _POST_ERROR_TOPIC.'<br />';
				echo 'Could not delete the poll. Update the database manually.';
				break;						
			default:
				echo '<div align="center">'._POST_SUCCESS_DELETE.'<br /><br />';
				if ($do=='deletepostnow')
					echo '<a href="'.sefRelToAbs(JB_LIVEURL.'&amp;func=view&catid='.$catid.'&amp;id='.$thread).'">'._POST_SUCCESS_VIEW.'</a><br />';
				echo '<a href="'.sefRelToAbs(JB_LIVEURL.'&amp;func=showcat&catid='.$catid).'">'._POST_SUCCESS_FORUM.'</a><br />';
				echo '</div>';
				echo '<script language="javascript">';
				if ($do=='deletetopicnow')
					echo 'setTimeout("location=\''.sefRelToAbs(JB_LIVEURL.'&func=showcat&catid='.$catid).'\'",3500)';
				else
					echo 'setTimeout("location=\''.sefRelToAbs(JB_LIVEURL.'&func=view&catid='.$catid.'&id='.$thread).'\'",3500)';					
				echo '</script>';
				break;
		}
	}//fi $do==deletepostnow
    else if ($do == "move") {
               if(!$is_moderator){ die("Hacking Attempt!");}
               $catid=(int)$catid;
               $id=(int)$id;

               //get list of available forums
               //$database->setQuery("SELECT id,name FROM #__sb_categories WHERE parent != '0'");
                  $database->setQuery( "SELECT a.*, b.name AS category"
                  . "\nFROM #__sb_categories AS a"
                  . "\nLEFT JOIN #__sb_categories AS b ON b.id = a.parent"
                  . "\nWHERE a.parent != '0'"
                  . "\nORDER BY parent, ordering");
               $catlist=$database->loadObjectList();
               // get topic subject:
               $database->setQuery("select subject from #__sb_messages where id=$id");
               $topicSubject=$database->loadResult();
               ?>
					<form action="<?php echo sefRelToAbs("index.php?option=com_joomlaboard&Itemid=$Itemid&func=post"); ?>" method="post" name="myform">
               <input type="hidden" name="do" value="domovepost" />
               <input type="hidden" name="id" value="<?php echo $id;?>" />

               <p><?php echo _GEN_TOPIC;?>: <strong><?php echo $topicSubject;?></strong><br /><br />
               <?php echo _POST_MOVE_TOPIC;?>:<br />
               <select name="catid" size="4">
               <?php
               foreach ($catlist as $cat)
               {
                  echo "<OPTION value=\"$cat->id\" > $cat->category/$cat->name </OPTION>";
               }?>
               </select><br />
				<input type="checkbox" checked name="leaveGhost" value="1" /> <?php echo _POST_MOVE_GHOST;?>
				<br />
				<input type="submit" class="button" value="<?php echo _GEN_MOVE;?>" />
					</form>

          <?php
            }
            else if ($do == "domovepost")
            {
               if(!$is_moderator){ die("Hacking Attempt!");}
               $catid=(int)$catid;
               $id=(int)$id;
				$bool_leaveGhost=(int)mosGetParam($_POST,'leaveGhost',0);               
					//get the some details from the original post for later
					$database->setQuery("SELECT `subject`, `catid`, `time` AS timestamp FROM #__sb_messages WHERE `id`='$id'");
					$oldRecord=$database->loadObjectList();
					$newSubject=_MOVED_TOPIC." ".$oldRecord[0]->subject;
					$database->setQuery("SELECT MAX(time) AS timestamp FROM #__sb_messages WHERE `thread`='$id'");
					$lastTimestamp=$database->loadResult();
					if ($lastTimestamp == "") { $lastTimestamp = $oldRecord[0]->timestamp; }
					
               //perform the actual move
               //Move topic post first
               $database->setQuery("UPDATE #__sb_messages SET `catid`='$catid' WHERE `id`='$id'");
               if ($database->query())
               { //succeeded; move the rest of the thread if exists
                  $database->setQuery("UPDATE #__sb_messages set `catid`='$catid' WHERE `thread`='$id'");
                  if ($database->query())
                  { 
						  // insert 'moved topic' notification in old forum if needed
						  if ($bool_leaveGhost) {
						  		$database->setQuery("INSERT INTO #__sb_messages (`parent`, `subject`, `time`, `catid`, `moved`) VALUES ('0','$newSubject','".$lastTimestamp."','".$oldRecord[0]->catid."','1')");
						  		if ($database->query() ) { 
                       				//determine the new location for link composition
						     		$newId=$database->insertid();
									$newURL = "catid=".$catid."&id=".$id;
									$database->setQuery("INSERT INTO #__sb_messages_text (`mesid`, `message`) VALUES ('$newId', '$newURL')");
							  		if (! $database->query() ) { $database->stderr(true); }
                       				//and update the thread id on the 'moved' post for the right ordering when viewing the forum..
                       				$database->setQuery("UPDATE #__sb_messages SET `thread`='$newId' WHERE `id`='$newId'");
                       				if (! $database->query() ) { $database->stderr(true); }							  
						  		}
						  		else
						  			echo '<p style="text-align:center">'._POST_GHOST_FAILED.'</p>';
						  }

						  //move succeeded
                    echo '<div align="center">'._POST_SUCCESS_MOVE.'<br /><br />';
                    echo '<a href="'.sefRelToAbs(JB_LIVEURL.'&amp;func=view&catid='.$catid.'&amp;id='.$id).'#'.$id.'">'._POST_SUCCESS_VIEW.'</a><br />';
                    echo '<a href="'.sefRelToAbs(JB_LIVEURL.'&amp;func=showcat&catid='.$catid).'">'._POST_SUCCESS_FORUM.'</a><br />';
                    echo '</div>';
                  ?>
                  <script language="javascript">
                  setTimeout("location='<?php echo sefRelToAbs(JB_LIVEURL.'&amp;func=view&amp;catid='.$catid.'&amp;id='.$id); ?>'",3500);
                  </script>
                  <?php
                  }
                  else
                  {
                     echo "Severe database error. Update your database manually so the replies to the topic are matched to the new forum as well";
                     //this is severe.. takes a lot of coding to programatically correct it. Won't do that.
                     //chances of this happening are very slim. Disclaimer: this is software as-is *lol*;
                     //go read the GPL and the header of this file..
                  }
               }
               else
               {?>
                  <?php echo _POST_TOPIC_NOT_MOVED;?> <a href="index.php?option=com_joomlaboard&amp;Itemid=<?php echo $Itemid;?>&amp;func=view&catid=<?php echo $catid;?>&amp;id=<?php echo $id;?>"><?php echo _POST_CLICK;?></a>
             <?php
               }
            }
            else if ($do == "subscribe")
            {
               $catid=(int)$catid;
               $id=(int)$id;
               $database->setQuery("INSERT INTO #__sb_subscriptions (thread,userid) VALUES ('$sb_thread','$my_id')");
               if ($database->query()){
                  echo _POST_SUBSCRIBED_TOPIC."<br /><br />";
               }else{
                  echo _POST_NO_SUBSCRIBED_TOPIC."<br /><br />";
               }
                echo '<div align="center">'._POST_SUCCESS_SUBSCRIBE.'<br /><br />';
                echo '<a href="'.sefRelToAbs(JB_LIVEURL.'&amp;func=view&amp;catid='.$catid.'&amp;id='.$pid).'#'.$pid.'">'._POST_SUCCESS_VIEW.'</a><br />';
                echo '<a href="'.sefRelToAbs(JB_LIVEURL.'&amp;func=showcat&amp;catid='.$catid).'">'._POST_SUCCESS_FORUM.'</a><br />';
                echo '</div>';               ?>
               <script language="javascript">
               setTimeout("location='<?php echo sefRelToAbs(JB_LIVEURL.'&amp;func=userprofile&amp;do=show'); ?>'",3500);
               </script>
               <?php
            }
            else if ($do == "sticky")
            {

               if(!$is_moderator){ die("Hacking Attempt!");}
               $database->setQuery("update #__sb_messages set ordering=1 where id=$id");
               if ($database->query()){
                  echo '<p align="center">'._POST_STICKY_SET.'<br /><br />';
               }else{
                  echo '<p align="center">'._POST_STICKY_NOT_SET.'<br /><br />';
               }
                echo '<div align="center">'._POST_SUCCESS_REQUEST2.'<br /><br />';
                echo '<a href="'.sefRelToAbs(JB_LIVEURL.'&amp;func=view&amp;catid='.$catid.'&amp;id='.$id).'#'.$id.'">'._POST_SUCCESS_VIEW.'</a><br />';
                echo '<a href="'.sefRelToAbs(JB_LIVEURL.'&amp;func=showcat&amp;catid='.$catid).'">'._POST_SUCCESS_FORUM.'</a><br />';
                echo '</div>';
               ?>
               <script language="javascript">
               setTimeout("location='<?php echo sefRelToAbs(JB_LIVEURL.'&amp;func=view&amp;catid='.$catid.'&amp;id='.$id);?>'",3500);
               </script>
               <?php
            }
            else if ($do == "unsticky")
            {
               if(!$is_moderator){ die("Hacking Attempt!");}

               $database->setQuery("update #__sb_messages set ordering=0 where id=$id");

               if ($database->query()){
                  echo '<p align="center">'._POST_STICKY_UNSET.'<br /><br />';
               }else{
                  echo '<p align="center">'._POST_STICKY_NOT_UNSET.'<br /><br />';
               }
                echo '<div align="center">'._POST_SUCCESS_REQUEST2.'<br /><br />';
                echo '<a href="'.sefRelToAbs(JB_LIVEURL.'&amp;func=view&amp;catid='.$catid.'&amp;id='.$id).'#'.$id.'">'._POST_SUCCESS_VIEW.'</a><br />';
                echo '<a href="'.sefRelToAbs(JB_LIVEURL.'&amp;func=showcat&amp;catid='.$catid).'">'._POST_SUCCESS_FORUM.'</a><br />';
                echo '</div>';               ?>
               <script language="javascript">
               setTimeout("location='<?php echo sefRelToAbs(JB_LIVEURL.'&amp;func=view&amp;catid='.$catid.'&amp;id='.$id) ;?>'",3500);
               </script>

               <?php
            }
            else if ($do == "lock")
            {
               if(!$is_moderator){ die("Hacking Attempt!");}
               //lock topic post
               $database->setQuery("update #__sb_messages set locked=1 where id=$id");
               if ($database->query()){
                  echo '<p align=/"center/">'._POST_LOCK_SET.'<br /><br />';
               }else{
                  echo '<p align=/"center/">'._POST_LOCK_NOT_SET.'<br /><br />';
               }
                echo '<div align=/"center/">'._POST_SUCCESS_REQUEST2.'<br /><br />';
                echo '<a href="'.sefRelToAbs(JB_LIVEURL.'&amp;func=view&amp;catid='.$catid.'&amp;id='.$id).'#'.$id.'">'._POST_SUCCESS_VIEW.'</a><br />';
                echo '<a href="'.sefRelToAbs(JB_LIVEURL.'&amp;func=showcat&amp;catid='.$catid).'">'._POST_SUCCESS_FORUM.'</a><br />';
                echo '</div>';
               ?>
               <script language="javascript">
               setTimeout("location='<?php echo sefRelToAbs(JB_LIVEURL.'&amp;func=view&amp;catid='.$catid.'&amp;id='.$id);?>'",3500);
               </script>
               <?php
            }
            else if ($do == "unlock")
            {
               if(!$is_moderator){ die("Hacking Attempt!");}

               $database->setQuery("update #__sb_messages set locked=0 where id=$id");
               if ($database->query()){
                  echo '<p align="center">'._POST_LOCK_UNSET.'<br /><br />';
               }else{
                  echo '<p align="center">'._POST_LOCK_NOT_UNSET.'<br /><br />';
               }
                echo '<div align="center">'._POST_SUCCESS_REQUEST2.'<br /><br />';
                echo '<a href="'.sefRelToAbs(JB_LIVEURL.'&amp;func=view&amp;catid='.$catid.'&amp;id='.$id).'#'.$id.'">'._POST_SUCCESS_VIEW.'</a><br />';
                echo '<a href="'.sefRelToAbs(JB_LIVEURL.'&amp;func=showcat&amp;catid='.$catid).'">'._POST_SUCCESS_FORUM.'</a><br />';
                echo '</div>';               ?>
               <script language="javascript">
               setTimeout("location='<?php echo sefRelToAbs(JB_LIVEURL.'&amp;func=view&amp;catid='.$catid.'&amp;id='.$id);?>'",3500);
               </script>
               <?php
            }
         }
         ?>
         </td>
      </tr>
   </table>
<?php

/**
 * Function to delete posts
 *
 * @param database object 
 * @param int the id if the post to be deleted
 * @param boolean determines if we need to delete attachements as well
 *
 * @return int returns thread id if all went well, -1 to -5 are error numbers
**/
function sb_delete_post(&$database,$id,$dellattach) {
	$database->setQuery('SELECT id,catid,parent,thread,subject,userid FROM #__sb_messages WHERE id='.$id);
	if (!$database->query())
		return -2;
	$database->loadObject($mes);
	$thread=$mes->thread;
    
	if ($mes->parent==0) {
		// this is the forum topic; if removed, all children must be removed as well.
		$children=array();
		$userids=array();
		$database->setQuery('SELECT userid,id FROM #__sb_messages WHERE thread='.$id .' OR id='.$id);
		foreach ($database->loadObjectList() as $line) {
			$children[]=$line->id;
			if ($line->userid > 0) 
				$userids[]=$line->userid;
		}
		$children=implode(',',$children);
		$userids=implode(',',$userids);
	}
	else {
		//this is not the forum topic, so delete it and promote the direct children one level up in the hierarchy
		$database->setQuery('UPDATE #__sb_messages SET parent=\''.$mes->parent.'\' WHERE parent=\''.$id.'\'');
		if (!$database->query()) 
			return -1;
		$children=$id;
		$userids=$mes->userid > 0 ? $mes->userid : '';
	}
		
	//Delete the post (and it's children when it's the first post)
	$database->setQuery('DELETE FROM #__sb_messages WHERE id='.$id .' OR thread='.$id);
	if (!$database->query())
		return -2;
	
	//Delete message text(s)
	$database->setQuery('DELETE FROM #__sb_messages_text WHERE mesid IN ('.$children.')');
	if (!$database->query())
		return -3;
	
	//Update user post stats
	if (!empty($userids) && count($userids) > 0) {
		$database->setQuery('UPDATE #__sb_users SET posts=posts-1 WHERE userid IN ('.$userids.')');
		if (!$database->query())
			return -4;		
	}
	//Delete (possible) ghost post 
	$database->setQuery('SELECT mesid FROM #__sb_messages_text WHERE message=\'catid='.$mes->catid.'&id='.$id.'\'');
	$int_ghost_id=$database->loadResult();
	if ($int_ghost_id>0) {
		$database->setQuery('DELETE FROM #__sb_messages WHERE id='.$int_ghost_id);
		$database->query();
		$database->setQuery('DELETE FROM #__sb_messages_text WHERE mesid='.$int_ghost_id);
		$database->query();
	}
	
	//Delete attachments
	if ($dellattach) {
		$database->setQuery('SELECT filelocation FROM #__sb_attachments WHERE mesid IN ('.$children.')');
		$fileList=$database->loadObjectList();
		if (count($fileList)>0){
			foreach ($fileList as $fl)
				unlink($fl->filelocation);                                   
				$database->setQuery('DELETE FROM #__sb_attachments WHERE mesid IN ('.$children.')');
				$database->query();
		}		
	}
	return $thread; // all went well :-)
}

function listThreadHistory($id,$sbConfig, $database)
{
   if($id != 0)
   {
      //get the parent# for the post on which 'reply' or 'quote' is chosen
      $database->setQuery("SELECT parent FROM #__sb_messages WHERE id='$id'");
      $this_message_parent = $database->loadResult();
      //Get the thread# for the same post
      $database->setQuery("SELECT thread FROM #__sb_messages WHERE id='$id'");
      $this_message_thread = $database->loadResult();
      //determine the correct thread# for the entire thread
      if ($this_message_parent==0)
      {$thread=$id;} else {$thread=$this_message_thread;}
      //get all the messages for this thread
      $database->setQuery("SELECT * FROM #__sb_messages LEFT JOIN #__sb_messages_text ON #__sb_messages.id=#__sb_messages_text.mesid WHERE thread='$thread' OR id='$thread' AND hold = 0 ORDER BY time DESC LIMIT ".$sbConfig['historyLimit']);
      $messages=$database->loadObjectList();
      //and the subject of the first thread (for reference)
      $database->setQuery("SELECT subject FROM #__sb_messages WHERE id='$thread' and parent=0");
      $this_message_subject = $database->loadResult();
      echo "<b>"._POST_TOPIC_HISTORY.":</b> ".htmlspecialchars($this_message_subject)." <br />"._POST_TOPIC_HISTORY_MAX." $historyLimit "._POST_TOPIC_HISTORY_LAST."<br />";
      ?>
      <table border="0" cellspacing="1" cellpadding="3" width="100%" class="sb_review_table">
         <tr>
            <td class="sb_review_header" width="20%" align="center"><strong><?php echo _GEN_AUTHOR;?></strong></td>
            <td class="sb_review_header" align="center"><strong><?php echo _GEN_MESSAGE;?></strong></td>
         </tr>
            <?php
            $k=0;
            foreach($messages as $mes)
            {
               $k = 1-$k;
               $mes->name = htmlspecialchars($mes->name);
               $mes->email = htmlspecialchars($mes->email);
               $mes->subject = htmlspecialchars($mes->subject);
               $mes->message = smile::smileReplace($mes->message,1, $sbConfig['disemoticons']);
               ?>
               <tr>
                  <td class="sb_review_body<?php echo $k;?>" valign="top"><?php echo stripslashes($mes->name);?></td>
                  <td class="sb_review_body<?php echo $k;?>">
                     <?php
                     $sb_message_txt = stripslashes($mes->message);
                     $sb_message_txt = str_replace("</P><br />","</P>", $sb_message_txt );
                     //Long Words Wrap:
					$sb_message_txt = smile::htmlwrap($sb_message_txt, $sbConfig['wrap']);
                     echo $sb_message_txt;
                     ?>
                  </td>
               </tr>


         <?php }
            ?>


      </table><?php
   }//else: this is a new topic so there can't be a history
}
?>
