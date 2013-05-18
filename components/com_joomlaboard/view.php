<?php
/**
* view.php generates topic view
* @package com_joomlaboard
* @copyright (C) 2000 - 2007 TSMF / Jan de Graaff / All Rights Reserved
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* @author TSMF
* Joomla! is Free Software
**/

// Dont allow direct linking
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

// include necessary libraries
if ($sbConfig['postStats']==1) require_once ( JB_ABSPATH.'/sb_statsbar.php' );

$id=(int)$id;
$database->setQuery("SELECT * FROM #__sb_messages AS a LEFT JOIN #__sb_messages_text AS b ON a.id=b.mesid WHERE a.id='$id' and a.hold=0");
$database->query();
if ($database->getNumRows()== 0) {
	echo '<p align="center">'._MODERATION_INVALID_ID.'</p>\n';
}
else  {
	$database->loadObject($this_message);

	// make sure we have the topic as well
	$thread = $this_message->parent==0?$this_message->id:$this_message->thread;
	if ($this_message->parent==0)
		$obj_sb_topic_post=&$this_message;
	else {
		$database->setQuery('SELECT * FROM #__sb_messages WHERE id='.$thread);
		$database->loadObject($obj_sb_topic_post);
	}
		
   		if ($my->id != 0){
	    	//mark this topic as read
    	  	$readTopics="";
      		$database->setQuery("SELECT readtopics FROM #__sb_sessions WHERE userid=".$my->id);
			$readTopics=$database->loadResult();

			if ($readTopics==""){
				$readTopics=$thread;
				$read_topics=array("$thread"); // needed for threaded view
			}
      		else {
				//	get all readTopics in an array
         		$read_topics=explode(',',$readTopics);
         		if (!in_array($thread,$read_topics)){
            		$readTopics=$readTopics.",".$thread;
            		$read_topics[]=$thread; // needed for threaded view
         		}
      		}
   			$database->setQuery("UPDATE #__sb_sessions set readtopics='$readTopics' WHERE userid=$my->id");
   			$database->query();
		}

		//update the hits counter for this topic
    	$database->setQuery("UPDATE #__sb_messages SET hits=hits+1 WHERE id=$thread AND parent=0");
    	$database->query();
	
		// set page title
		$mainframe->setPageTitle( $obj_sb_topic_post->subject.' - '.$sbConfig['board_title'] );
		
		// determine ordering of messages
   		if ($sbConfig['cb_profile'] && $my->id!=0) {
   			$database->setQuery("SELECT sbordering from #__comprofiler where user_id=$my->id");
   			$sbordering=$database->loadResult();
   			if ($sbordering == "_UE_SB_ORDERING_OLDEST") {
		   		$orderingNum = 0;
   			}
   			else {
	   			$orderingNum = 1;
   			}
   		}
   		else {
    		$database->setQuery("SELECT ordering from #__sb_users where userid=$my->id");
    		$orderingNum=$database->loadResult();
   		}
   		$ordering = $orderingNum ? 'DESC' : 'ASC';
   		
   		// Get messages in topic
    	$i=0;
		$flat_messages=array();
   		$database->setQuery("SELECT * FROM #__sb_messages AS a LEFT JOIN #__sb_messages_text AS b ON a.id=b.mesid WHERE (a.thread='$thread' OR a.id='$thread') AND a.hold=0 AND a.catid='$catid' ORDER BY a.time $ordering");
   		if ($view != "flat") 
   			$flat_messages[]=$this_message;
		$arr_messages=$database->loadObjectList();
		if (count($arr_messages)>0) {
	   		foreach ($arr_messages as $message) {
				if ($view == "flat") {
					$flat_messages[]=$message;
        			if ($id==$message->id)
	        			$idmatch=$i;
        			$i++;
      			}
				else {
					$messages[$message->parent][]=$message;
      			}
	    	}
		}
		$total=0;
    	if ($view == "flat") {
	      	//prepare threading
      		$limit = $sbConfig['messages_per_page'];
      		if ($idmatch > $limit) {
      			$limitstart=(floor( $idmatch/$limit))*$limit;
      		}
      		else{
      			$limitstart=0;	
      		}	
			
			$limitstart = intval( mosGetParam( $_REQUEST, 'limitstart', $limitstart ) );
			$total=count($flat_messages);
      		if ($total > $limit) {
        		require_once(JB_JABSPATH.'/includes/pageNavigation.php');
        		$pageNav = new mosPageNav( $total, $limitstart, $limit  );
			
		        // slice out elements based on limits
		        $flat_messages = array_slice( $flat_messages, $pageNav->limitstart, $pageNav->limit );
      		}
      		else {
        		$total=0;
      		}
    	}

		//	Get the category name for breadcrumb
    	$database->setQuery("SELECT name, parent from #__sb_categories where id='$catid'");
    	$database->loadObject($objCatInfo);
		//	Get Parent's cat.name for breadcrumb
		$database->setQuery("SELECT name,id from #__sb_categories WHERE id='$objCatInfo->parent'");
		$database->loadObject($objCatParentInfo);
	
	    //	data ready display now
	    ?>
	    <table border="0" cellspacing="0" cellpadding="0" width="100%" align="center">
    		<tr>
         		<td>
         			<div class="jb_pathway" style="width:100%">
						<a href="<?php echo sefRelToAbs(JB_LIVEURL);?>" class="jb_pathway">
                        <?php echo defined('JB_ICONURL') && array_key_exists('forumlist',$sbIcons) ? '<img src="'.JB_ICONURL.'/'.$sbIcons['forumlist'].'" border="0" alt="'._GEN_FORUMLIST.'" title="'._GEN_FORUMLIST.'">' : _GEN_FORUMLIST; ?>
                     	</a>
                     	<?php
                      	if (file_exists($mosConfig_absolute_path.'/templates/'.$mainframe->getTemplate().'/images/arrow.png')) {
	  				  		echo ' <img src="'.JB_JLIVEURL.'/templates/'.$mainframe->getTemplate().'/images/arrow.png" alt="" /> ';
	  				  	}
	  				  	else {
	  				  		echo ' <img src="'.JB_JLIVEURL.'/images/M_images/arrow.png" alt="" /> ';
						} ?>
                     	<a href="<?php echo sefRelToAbs(JB_LIVEURL.'&amp;func=listcat&amp;catid='.$objCatParentInfo->id);?>" class="jb_pathway">
                        <?php echo $objCatParentInfo->name;?>
                     	</a> 
                     	<?php
                      	if (file_exists($mosConfig_absolute_path.'/templates/'.$mainframe->getTemplate().'/images/arrow.png')) {
	  				  		echo ' <img src="'.JB_JLIVEURL.'/templates/'.$mainframe->getTemplate().'/images/arrow.png" alt="" /> ';
	  				  	} else {
	  				  		echo ' <img src="'.JB_JLIVEURL.'/images/M_images/arrow.png" alt="" /> ';
						} ?>
                     	<a href="<?php echo sefRelToAbs(JB_LIVEURL.'&amp;func=showcat&amp;catid='.$catid);?>" class="jb_pathway">
                        <?php echo $objCatInfo->name;?>
                      	</a>
                	</div>
				</td>
				<td style="text-align: right;">
					<?php
					//	post new topic
					if (($sbConfig['pubwrite']==0 && $my_id != 0)||$sbConfig['pubwrite']==1) {
						echo jb_get_link('new_topic',_GEN_POST_NEW_TOPIC,JB_LIVEURL.'&amp;func=post&amp;do=reply&amp;catid='.$catid);
                   	}?>
         		</td>
      		</tr>
			<tr>
				<td colspan="2">
         		<?php
           if ($total != 0)
           {
          ?>
              <table border="0" cellspacing="1" cellpadding="3" width="100%" class="contentpane">
                <tr>
                  <td class="sectiontableheader" align="center" colspan="2">
                    <?php
                      echo $pageNav->writePagesLinks( JB_LIVEURL.'&amp;func=view&amp;id='.$id.'&amp;catid='.$catid );
                    ?>
                  </td>
                </tr>
              </table>
          <?php
          }
            $tabclass = array("sectiontableentry1", "sectiontableentry2");
            $k=0;
			
			// Set up a list of moderators for this category (limits amount of queries)
            $database->setQuery("SELECT a.userid FROM #__sb_users AS a"
                                  . "\n LEFT JOIN #__sb_moderation AS b"
                                  . "\n ON b.userid=a.userid"
                                  . "\n WHERE b.catid='$catid'"
                                   );
			$catModerators=$database->loadResultArray();			
			
			// Check post permission
			$bool_jb_has_post_perm=sb_has_post_permission($database,$catid,$obj_sb_topic_post->id,$my->id,$sbConfig['pubwrite'],$is_moderator);
			
            foreach($flat_messages as $fmessage)
            {
              $k= 1-$k;
              if($fmessage->parent==0){
                 $sb_thread=$fmessage->id;
              }
              else {
                 $sb_thread=$fmessage->thread;
              }

              //filter out clear html
              $fmessage->name = htmlspecialchars($fmessage->name);
              $fmessage->email = htmlspecialchars($fmessage->email);
              $fmessage->subject = htmlspecialchars($fmessage->subject);
  			  //Get userinfo needed later on, this limits the amount of queries
  			  $userinfo=null;
              $database->setQuery("SELECT a.posts,a.karma,a.signature,a.avatar,b.name,b.username,b.gid FROM #__sb_users as a LEFT JOIN #__users as b on b.id=a.userid where a.userid='$fmessage->userid'");
			  $database->loadObject($userinfo);

			  //get the username:
              $sb_username="";
              if ($sbConfig['username']){$sb_queryName="username";}else{$sb_queryName="name";}
              $sb_username=$userinfo->$sb_queryName;
              if ($sb_username=="" || $sbConfig['changename'] ){$sb_username=$fmessage->name;}
              
              $msg_id = $fmessage->id;
              $msg_username = $fmessage->email!=""&&$my_id>0&&$sbConfig['showemail']=='1'?"<a href=\"mailto:".stripslashes($fmessage->email)."\">".stripslashes($sb_username)."</a>":stripslashes($sb_username);
              
              	// Set the avatar & profile link
              	$msg_avatar='';
				$msg_profile='';
				if($sbConfig['allowAvatar'] && $fmessage->userid) {
                	switch ($sbConfig['avatar_src']) {
	                	case 'pmspro':
	                		$msg_profile=jb_get_image_link('userprofile',JB_JLIVEURL.'/components/com_mypms/images/folders/profile.gif',_VIEW_PROFILE,JB_JLIVEURL.'/index.php?option=com_mypms&amp;task=showprofile&amp;user='.$userinfo->username.'&amp;Itemid='.$pmsproitemid);
							
							$database->setQuery('SELECT picture FROM #__mypms_profiles WHERE user=\''.$userinfo->username.'\'');
	                		$str_pms_avatar=$database->loadResult();
	                		if ($str_pms_avatar != '') 
	                			$msg_avatar=jb_get_image_link('profileicon',JB_JLIVEURL.'/components/com_mypms/pictures/'.$str_pms_avatar,_VIEW_PROFILE,JB_JLIVEURL.'/index.php?option=com_mypms&amp;task=showprofile&amp;user='.$userinfo->username.'&amp;Itemid='.$pmsproitemid);
							break;
						case 'cb':
							$msg_profile=jb_get_image_link('userprofile',JB_JLIVEURL.'/components/com_comprofiler/images/profiles.gif',_VIEW_PROFILE,JB_JLIVEURL.'/index.php?option=com_comprofiler&amp;task=userProfile&amp;user='.$fmessage->userid.'&amp;Itemid='.$cbitemid);				
	                		
	                		$database->setQuery('SELECT avatar FROM #__comprofiler WHERE user_id='.$fmessage->userid.' AND avatarapproved=\'1\'');
	                		$str_cb_avatar=$database->loadResult();
	                		if ($str_cb_avatar != '') {
	                      		$str_cb_imgpath=JB_JLIVEURL.'/images/comprofiler/';
	                      		if(eregi("gallery/",$str_cb_avatar)==false) 
	                      			$str_cb_imgpath .= "tn".$str_cb_avatar;
	                      		else 
	                      			$str_cb_imgpath .= $str_cb_avatar;
									$msg_avatar=jb_get_image_link('profileicon',$str_cb_imgpath,_VIEW_PROFILE,JB_JLIVEURL.'/index.php?option=com_comprofiler&amp;task=userProfile&amp;user='.$fmessage->userid.'&amp;Itemid='.$cbitemid);
	                		}
							break;
						default:                
							if ($userinfo->avatar!='')
                				$msg_avatar='<img src="'.JB_DIRECTURL.'/avatars/'.$userinfo->avatar.'" alt="avatar" />';
                	}
                	#$msg_avatar=empty($msg_avatar)? '': '<img src="'.$msg_avatar.'" alt="avatar" />';
				}
				
				// Set pm link (if necessary) 
				$msg_pms="";
				if ($fmessage->userid  && $my->id) {
					switch ($sbConfig['pm_component']) {
						case 'pms':
							$msg_pms=jb_get_image_link('pms' ,JB_DIRECTURL.'/images/sendpm.gif', _VIEW_PMS , JB_JLIVEURL.'/index.php?option=com_pms&page=new&amp;id='.$userinfo->username.'&title='.$fmessage->subject);
							break;
						case 'pmspro':
							$msg_pms=jb_get_image_link('pms' ,JB_DIRECTURL.'/images/sendpm.gif', _VIEW_PMS , JB_JLIVEURL.'/index.php?option=com_pms&page=new&amp;id='.$userinfo->username.'&title='.$fmessage->subject);
							break;
						case 'uddeim':
							$msg_pms=jb_get_image_link('pms' ,JB_DIRECTURL.'/images/sendpm.gif', _VIEW_PMS , JB_JLIVEURL.'/index.php?option=com_uddeim&amp;Itemid='.$uiitemid.'&amp;task=new&amp;recip='.$fmessage->userid);
							break;
						case 'missus':
							$msg_pms=jb_get_image_link('pms' ,JB_DIRECTURL.'/images/sendpm.gif', _VIEW_PMS , JB_JLIVEURL.'/index.php?option=com_missus&amp;Itemid='.$miitemid.'&amp;func=newmsg&amp;user='.$fmessage->userid);
							break;	
						case 'jim':
							$msg_pms=jb_get_image_link('pms' ,JB_DIRECTURL.'/images/sendpm.gif', _VIEW_PMS , JB_JLIVEURL.'/index.php?option=com_jim&page=new&amp;id='.$userinfo->username.'&title='.$fmessage->subject);
							break;
					}
				}
				$msg_userrank='';
				$msg_userrankimg='';
				$useGraph=0;
              if($sbConfig['showstats']) {
                //user type determination
                $ugid=$userinfo->gid;
				$bool_jb_uismod=0;
                $bool_jb_uisadm=0;
                $bool_jb_uismod=in_array($fmessage->userid,$catModerators);
                if($ugid>0) //only get the groupname from the ACL if we're sure there is one
					$str_jb_agrp=strtolower( $acl->get_group_name( $ugid, 'ARO' ) );
                else
                	$str_jb_agrp="";
				
				if(strtolower($str_jb_agrp)=="administrator" || strtolower($str_jb_agrp)=="superadministrator"|| strtolower($str_jb_agrp)=="super administrator") {
                	$msg_usertype=_VIEW_ADMIN;
                	$bool_jb_uisadm=1;
                }
				elseif($bool_jb_uismod)
               		$msg_usertype = _VIEW_MODERATOR;
               	elseif($ugid>0)
               		$msg_usertype = _VIEW_USER;
				else
					$msg_usertype = _VIEW_VISITOR; 

                  //# of post for this user and ranking
                if ($fmessage->userid) {
                  $numPosts=(int)$userinfo->posts;
                  //ranking
                  $rText="";
                  $rImg="";
                  if($sbConfig['showranking']) {
                    if ($numPosts>=0 && $numPosts<(int)$sbConfig['rank1']){$rText=$sbConfig['rank1txt']; $rImg=JB_DIRECTURL.'/ranks/rank1.gif';}
                    if ($numPosts>=(int)$sbConfig['rank1'] && $numPosts<(int)$sbConfig['rank2']){$rText=$sbConfig['rank2txt']; $rImg=JB_DIRECTURL.'/ranks/rank2.gif';}
                    if ($numPosts>=(int)$sbConfig['rank2'] && $numPosts<(int)$sbConfig['rank3']){$rText=$sbConfig['rank3txt']; $rImg=JB_DIRECTURL.'/ranks/rank3.gif';}
                    if ($numPosts>=(int)$sbConfig['rank3'] && $numPosts<(int)$sbConfig['rank4']){$rText=$sbConfig['rank4txt']; $rImg=JB_DIRECTURL.'/ranks/rank4.gif';}
                    if ($numPosts>=(int)$sbConfig['rank4'] && $numPosts<(int)$sbConfig['rank5']){$rText=$sbConfig['rank5txt']; $rImg=JB_DIRECTURL.'/ranks/rank5.gif';}
                    if ($numPosts>=(int)$sbConfig['rank5']){$rText=$sbConfig['rank6txt']; $rImg=JB_DIRECTURL.'/ranks/rank6.gif';}
                    if ($bool_jb_uismod){$rText=_RANK_MODERATOR; $rImg=JB_DIRECTURL.'/ranks/rankmod.gif';}
                    if ($bool_jb_uisadm){$rText=_RANK_ADMINISTRATOR; $rImg=JB_DIRECTURL.'/ranks/rankadmin.gif';}

                    if($sbConfig['rankimages']){$msg_userrankimg = '<img src="'.$rImg.'" alt="" />';}
                      $msg_userrank = $rText;
                    }
                    
                    
                    if (!$sbConfig['postStats']){
                      $msg_posts = $numPosts;
                      $useGraph=0;
                    } else {

                      $myGraph = new phpGraph();
                      //$myGraph->SetGraphTitle(_POSTS);
                      $myGraph->AddValue(_POSTS,$numPosts);
                      $myGraph->SetRowSortMode(0);
                      $myGraph->SetBarImg(JB_DIRECTURL."/graph/col".$sbConfig['statsColor']."m.png");
                      $myGraph->SetBarImg2(JB_DIRECTURL."/emoticons/graph.gif");
                      $myGraph->SetMaxVal($maxPosts);
                      $myGraph->SetShowCountsMode(2);
                      $myGraph->SetBarWidth(4); //height of the bar
                      $myGraph->SetBorderColor("#333333");
                      $myGraph->SetBarBorderWidth(0);
                      $myGraph->SetGraphWidth(64);//should match column width in the <TD> above -5 pixels
                      //$myGraph->BarGraphHoriz();
                      $useGraph=1;
                    }

                 }
               }
               //karma points and buttons
               $msg_karma=''; $msg_karmaminus=''; $msg_karmaplus='';
               if($sbConfig['showkarma'] && $fmessage->userid != '0')
               {
                 $karmaPoints=$userinfo->karma;
                 $karmaPoints=(int)$karmaPoints;
                 $msg_karma = "<strong>"._KARMA.":</strong> $karmaPoints";
                 if($my->id != '0' && $my->id != $fmessage->userid ) {
                    $msg_karmaminus = jb_get_image_link('karmaminus',JB_DIRECTURL.'/emoticons/karmaminus.gif',_KARMA_SMITE,JB_LIVEURL.'&amp;func=karma&amp;do=decrease&userid='.$fmessage->userid.'&pid='.$fmessage->id.'&amp;catid='.$catid);
                    $msg_karmaplus  = jb_get_image_link('karmaplus',JB_DIRECTURL.'/emoticons/karmaplus.gif',_KARMA_APPLAUD,JB_LIVEURL.'&amp;func=karma&amp;do=increase&userid='.$fmessage->userid.'&pid='.$fmessage->id.'&amp;catid='.$catid);
                  }
               }                
                  /*let's see if we should use myPMSPro integration */
                    //mypms pro profile link
                   if ($sbConfig['pm_component']=="pmspro" && $fmessage->userid  && $my->id) {
                   
                    // add buddy link
                    $msg_buddy = jb_get_image_link('pms2buddy',JB_JLIVEURL.'/components/com_mypms/images/messages/addbuddy.gif',_VIEW_ADDBUDDY,JB_JLIVEURL.'/index.php?option=com_mypms&user='.$userinfo->username.'&task=addbuddy');
                    
					$database->setQuery("SELECT icq,ym,msn,aim,website,location FROM #__mypms_profiles WHERE user='" . $userinfo->username . "'");
                    $database->loadObject($obj_pmsprofile);
                    if($obj_pmsprofile->aim)
                    	$msg_aim = "<a href=\"aim:goim?screenname=" . str_replace(" ", "+", $obj_pmsprofile->aim) . "\"><img src=\"/components/com_joomlaboard/images/aim.png\" border=0></a>";
					if($obj_pmsprofile->icq)
                    	$msg_icq = "<a href=\"http://www.icq.com/whitepages/wwp.php?uin=" . $obj_pmsprofile->icq . "\"><img src=\"/components/com_joomlaboard/images/icq.png\" border=0></a>";
					if($obj_pmsprofile->msn)
                      	$msg_msn = "<a href=\"" . sefRelToAbs('index.php?option=com_mypms&task=showprofile&amp;user='.$userinfo->username). "\"><img src=\"/components/com_joomlaboard/images/msn.png\" border=0></a>";
					if($obj_pmsprofile->ym)
                    	$msg_yahoo = "<a href=\"http://edit.yahoo.com/config/send_webmesg?.target=" . $obj_pmsprofile->ym . "&.src=pg\"><img src=\"http://opi.yahoo.com/online?u=" . $obj_pmsprofile->ym . "&m=g&t=0\" border=0></a>";
					if($obj_pmsprofile->location)
                    	$msg_loc = $obj_pmsprofile->location;
                    unset($obj_pmsprofile);
                    }

                    //Show admins the IP address of the user:
                    $msg_ip='';
                    if ($is_admin || $is_moderator) { 
                       $msg_ip = 'IP: '.$fmessage->ip;
                       $msg_ip_link='<a href="http://openrbl.org/dnsbl?i='.$fmessage->ip.'&f=2" target="_blank">';
                       }
                       

                  $sb_subject_txt = $fmessage->subject;
                  $table = array_flip(get_html_translation_table(HTML_ENTITIES));
                  $sb_subject_txt = strtr($sb_subject_txt, $table);
                  $sb_subject_txt = smile::sbHtmlSafe($sb_subject_txt);
                  $sb_subject_txt = stripslashes($sb_subject_txt);
                  $msg_subject = stripslashes($sb_subject_txt);
                  $msg_date = date(_DATETIME , $fmessage->time);
                  
                  $sb_message_txt = $fmessage->message;
                  $sb_message_txt = stripslashes(smile::smileReplace($sb_message_txt,0, $sbConfig['disemoticons']));
                  $sb_message_txt = str_replace("\n","<br />",$sb_message_txt);

                  //wordwrap:
						$sb_message_txt = smile::htmlwrap($sb_message_txt, $sbConfig['wrap']);
						//this doesn't work for code... need to find something else..


                  //restore the \n (were replaced with _CTRL_) occurences inside code tags, but only after we have stripslashes; otherwise they will be stripped again
                  $msg_text = str_replace("_CRLF_","\\n",stripslashes($sb_message_txt));
                  
                  if ($sbConfig['cb_profile']) {
                  	 $database->setQuery("select sbsignature from #__comprofiler where user_id=$fmessage->userid");
                  	 $signature=$database->loadResult();
                  } else {
                     $signature=$userinfo->signature;
                  }
                  if($signature != "")
                  {
                     $signature = stripslashes(smile::smileReplace($signature,0, $sbConfig['disemoticons']));
                     $signature = str_replace("\n","<br />",$signature);
                     $signature = str_replace("<P>&nbsp;</P><br />","",$signature);
                     $signature = str_replace("</P><br />","</P>",$signature);
                     $signature = str_replace("<P><br />","<P>",$signature);
                     //wordwrap:
						   $signature = smile::htmlwrap($signature, $sbConfig['wrap']);
                     //restore the \n (were replaced with _CTRL_) occurences inside code tags, but only after we have striplslashes; otherwise they will be stripped again
                    $signature = str_replace("_CRLF_","\\n",stripslashes($signature));

                    $msg_signature = $signature;
                  }
                  if (empty($msg_signature))
                  	$msg_signature="";

                  	// post actions				
                  	if ($bool_jb_has_post_perm == 1) {
                  		$msg_closed= '';
				  		$msg_reply = jb_get_link('reply',_GEN_REPLY,JB_LIVEURL.'&amp;func=post&amp;do=reply&amp;replyto='.$fmessage->id.'&amp;catid='.$catid);
						$msg_quote = jb_get_link('quote',_GEN_QUOTE,JB_LIVEURL.'&amp;func=post&amp;do=quote&amp;replyto='.$fmessage->id.'&amp;catid='.$catid);
                  	}
					else {
						$msg_reply='';
						$msg_quote='';
	                    if ($bool_jb_has_post_perm == -1) 
    	                	$msg_closed = _POST_LOCK_SET;
        	            else 
							$msg_closed = _VIEW_DISABLED;
					}
					if ($is_moderator || ($my->id > 0  && $sbConfig['useredit']==1 && $my->id == $fmessage->userid))
						$msg_edit = jb_get_link('edit',_GEN_EDIT,JB_LIVEURL.'&amp;func=post&amp;do=edit&amp;id='.$fmessage->id.'&amp;catid='.$catid);
					else
						$msg_edit = '';
						
					// moderator functions
					$msg_move=''; $msg_delete='';$msg_sticky='';$msg_lock='';
					if ($is_moderator) {
						$msg_delete = jb_get_link('delete',_GEN_DELETE,JB_LIVEURL.'&amp;func=post&amp;do=delete&amp;id='.$fmessage->id.'&amp;catid='.$catid);
						if ($fmessage->parent==0) {
							$msg_move   = jb_get_link('move',_GEN_MOVE,JB_LIVEURL.'&amp;func=post&amp;do=move&amp;id='.$fmessage->id.'&amp;catid='.$catid.'&name='.$fmessage->name);
							if ($fmessage->ordering==0)
								$msg_sticky = jb_get_link('sticky',_GEN_STICKY,JB_LIVEURL.'&amp;func=post&amp;do=sticky&amp;id='.$fmessage->id.'&amp;catid='.$catid);
							else
								$msg_sticky = jb_get_link('unsticky',_GEN_UNSTICKY,JB_LIVEURL.'&amp;func=post&amp;do=unsticky&amp;id='.$fmessage->id.'&amp;catid='.$catid);
							if ($fmessage->locked==0)
								$msg_lock = jb_get_link('lock',_GEN_LOCK,JB_LIVEURL.'&amp;func=post&amp;do=lock&amp;id='.$fmessage->id.'&amp;catid='.$catid);
							else
								$msg_lock = jb_get_link('unlock',_GEN_UNLOCK,JB_LIVEURL.'&amp;func=post&amp;do=unlock&amp;id='.$fmessage->id.'&amp;catid='.$catid);
						}
					}
                  include(JB_ABSPATH.'/template/'.$sbConfig['template'].'/'.$sbConfig['template'].'_view.php');
				  unset($msg_id,$msg_username,$msg_avatar,$msg_usertype,$msg_userrank,$msg_userrankimg,$msg_posts,$msg_karma,$msg_karmaplus,$msg_karmaminus,$msg_ip, $msg_ip_link ,$msg_date,$msg_subject,$msg_text,$msg_signature,$msg_aim,$msg_icq,$msg_msn,$msg_yahoo,$msg_buddy,$msg_profile,$msg_loc,$msg_regdate,$myGraph);                  
                  $useGraph=0;
            } // end for
             ?>
         </td>
      </tr>
      <?php if ($view!="flat") { ?>
      <tr>
         <td>
         <br />
         <?php include(JB_ABSPATH.'/thread.php'); ?>
         </td>
      </tr>

      <?php } ?>
   </table>



   <?php if ($total != 0){?>
   <table width="100%">
   <tr>
      <td class="sectiontableheader" align="center" colspan="2">
      <?php echo $pageNav->writePagesLinks( JB_LIVEURL.'&amp;func=view&amp;id='.$id.'&amp;catid='.$catid);?>

      </td>
   </tr>
   </table>
   <?php }?>


   <table width="100%">
      <tr>
        <td>
           <div class="jb_pathway" style="width:100%">
               <a href="<?php echo sefRelToAbs(JB_LIVEURL);?>" class="jb_pathway">
                  <?php echo defined('JB_ICONURL') && array_key_exists('forumlist',$sbIcons) ? '<img src="'.JB_JLIVEURL.'/modules/mod_sbicons/'.$sbIcons['forumlist'].'" border="0" alt="'._GEN_FORUMLIST.'" title="'._GEN_FORUMLIST.'">' : _GEN_FORUMLIST; ?>
               </a>
                     <?php
                      if (file_exists($mosConfig_absolute_path.'/templates/'.$mainframe->getTemplate().'/images/arrow.png')) {
	  				  echo ' <img src="'.JB_JLIVEURL.'/templates/'.$mainframe->getTemplate().'/images/arrow.png" alt="" /> ';
	  				  } else {
	  				  echo ' <img src="'.JB_JLIVEURL.'/images/M_images/arrow.png" alt="" /> ';
						} ?>
               <a href="<?php echo sefRelToAbs(JB_LIVEURL.'&amp;func=listcat&amp;catid='.$objCatParentInfo->id);?>" class="jb_pathway">
                  <?php echo $objCatParentInfo->name;?>
               </a> 
                     <?php
                      if (file_exists($mosConfig_absolute_path.'/templates/'.$mainframe->getTemplate().'/images/arrow.png')) {
	  				  echo ' <img src="'.JB_JLIVEURL.'/templates/'.$mainframe->getTemplate().'/images/arrow.png" alt="" /> ';
	  				  } else {
	  				  echo ' <img src="'.JB_JLIVEURL.'/images/M_images/arrow.png" alt="" /> ';
						} ?>
               <a href="<?php echo sefRelToAbs(JB_LIVEURL.'&amp;func=showcat&amp;catid='.$catid);?>" class="jb_pathway">
                  <?php echo $objCatInfo->name;?>
               </a>
           </div>
        </td>
		<td style="text-align: right;">
            <?php
            //post new topic
            //echo "</td></tr><tr><td align=\"right\">";
			if (($sbConfig['pubwrite']==0 && $my_id != 0)||$sbConfig['pubwrite']==1) {
            	echo jb_get_link('new_topic',_GEN_POST_NEW_TOPIC,JB_LIVEURL.'&amp;func=post&amp;do=reply&amp;catid='.$catid);
            }?>
         </td>
      </tr>
      <tr>
        <td colspan="2">
            <?php
            if($sbConfig['allowsubscriptions']==1 && (""!=$my_id || 0!=$my_id)){
               //$sb_thread==0 ? $check_thread=$catid : $check_thread=$sb_thread;
               $database->setQuery("SELECT thread from #__sb_subscriptions where userid=$my_id and thread='$sb_thread'");
               $sb_subscribed=$database->loadResult();
               if ($sb_subscribed == ""){$sb_cansubscribe=1;} else {$sb_cansubscribe=0;}
            }

            if($my_id != 0 && $sbConfig['allowsubscriptions'] == 1 && $sb_cansubscribe == 1 ) {?>
            <a href="<?php echo sefRelToAbs('index.php?option=com_joomlaboard&amp;Itemid='.$Itemid.'&amp;func=post&amp;do=subscribe&amp;catid='.$catid.'&amp;id='.$id.'&amp;sb_thread='.$sb_thread);?>">
            <?php echo  defined('JB_ICONURL') && array_key_exists('subscribe',$sbIcons) ?'<img src="'.JB_JLIVEURL.'/modules/mod_sbicons/'.$sbIcons['subscribe'].'" border="0" title="'._VIEW_SUBSCRIBETXT.'" alt="'._VIEW_SUBSCRIBETXT.'" />' : _VIEW_SUBSCRIBE;?></a>
          <?php
            }?>
       </td>
      </tr>
      </table>

<?php
   }




function formatdate($date){
   global $mosConfig_offset;
   if ( $date && ereg("([0-9]{4})-([0-9]{2})-([0-9]{2})[ ]([0-9]{2}):([0-9]{2}):([0-9]{2})", $date, $regs ) ) {
      $date = mktime( $regs[4], $regs[5], $regs[6], $regs[2], $regs[3], $regs[1] );
      $date = $date > -1 ? strftime( "%d %B %Y %H:%M", $date + ($mosConfig_offset*60*60) ) : '-';
   }
   return $date;
}


?>
