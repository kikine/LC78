<table border="0" cellspacing="1" cellpadding="3" width="100%" class="contentpane" style="text-align: left;">
	              <tr class="<?php echo $tabclass[$k];?>">
                <td valign="top" style="width: 70px;">
                  <strong><?php echo $msg_username;?></strong>
                  <br />
                  
                    <span class="sb_avatar"><?php echo $msg_avatar; ?></span>
                   <?php
                   echo $msg_usertype.'<br />';
                   if($msg_userrankimg) echo $msg_userrankimg.'<br />';
						 if($msg_userrank) echo $msg_userrank.'<br />';
                   if($useGraph) $myGraph->BarGraphHoriz().'<br />';
                   if($msg_karma) echo $msg_karma.'&nbsp;&nbsp;'.$msg_karmaplus.' '.$msg_karmaminus.'<br />'; else echo '&nbsp;<br />';
                   if($msg_pms) echo $msg_pms;
                   if($msg_profile) echo $msg_profile;
                   ?>
                   
                </td>
                <td valign="top" class="<?php echo $tabclass[$k];?>">
                <a name="msg<?php echo $msg_id;?>" id="msg<?php echo $msg_id;?>"><strong><?php echo $msg_subject;?></strong></a> - <em><?php echo $msg_date;?></em>
                <span class="sb_messagebody"><?php echo $msg_text; ?></span>
                <?php if($msg_signature) echo '<span class="sb_signature">'.$msg_signature.'</span>'; ?>
                </td>
              </tr>
             <tr bgcolor="<?php echo $bgcolor;?>">
               <td style="border-bottom:solid 1px #000000;">
                 <?php
                 if($msg_ip) echo $msg_ip_link.'<span style="font-family: Arial, Helvetica, sans-serif; font-size: 7pt;">'.$msg_ip.'</span></a>'; else echo '&nbsp;';
                 ?>
               </td>
               <td style="border-bottom:solid 1px #000000; text-align: right;">
               <?php
               if(defined('JB_ICONURL'))
                    {
                    echo $msg_reply;
                    echo " ".$msg_quote;
               		if ($msg_delete) echo " ".$msg_delete;
					if ($msg_move) echo " ".$msg_move;
               		if ($msg_edit) echo " ".$msg_edit;
               		if ($msg_closed) echo " ".$msg_closed;
               		if ($msg_sticky) echo " ".$msg_sticky;
               		if ($msg_lock) echo " ".$msg_lock;
                    }
                    else
                    {
                    echo $msg_reply;?> | <?php echo $msg_quote;
               		if ($msg_delete) echo " | $msg_delete";
					if ($msg_move) echo " | $msg_move";
               		if ($msg_edit) echo " | $msg_edit";
               		if ($msg_closed) echo " | $msg_closed";
               		if ($msg_sticky) echo " | $msg_sticky";
               		if ($msg_lock) echo " | $msg_lock";
                    }
               ?>
               </td>
             </tr>
   </table>

<?php
// --------------------------------------------------------------
//  Legend to the variables used
// --------------------------------------------------------------
// $msg_id          = Message ID#
// $msg_username    = Username (with email link if enabled)
// $msg_avatar      = User Avatar
// $msg_usertype    = User Type (Visitor/Member/moderator/Admin)
// $msg_userrank    = User Rank
// $msg_userrankimg = User Rank Image
// $msg_posts       = Post Count
// $msg_karma       = Karma Points
// $msg_karmaplus   = Linked Image for Karma+
// $msg_karmaminus  = Linked Image for Karma-
// $msg_ip          = IP of Poster
// $msg_ip_link     = Link to look up IP of Poster
// $msg_date        = Date of Post
// $msg_subject     = Post Subject
// $msg_text        = Post Text
// $msg_signature   = User's Signature
// $msg_reply       = Reply Option
// $msg_quote       = Quote Option
// $msg_edit        = Edit Option
// $msg_closed      = Locked/Diabled message
// $msg_delete      = Delete Option
// $msg_sticky      = Sticky/Unsticky Option
// $msg_lock        = Lock/Unlock Option
// $msg_aim         = User's AIM
// $msg_icq         = User's ICQ#
// $msg_msn         = User's MSN
// $msg_yahoo       = User's Yahoo
// $msg_profile     = Image link to user's Profile Page
// $msg_pms         = PMS link (for jim,uddeim,...)
// $msg_buddy       = Add buddy image link
// $msg_loc         = User's Location
// $msg_regdate     = User's Registration Date 
// $tabclass[$k]    = CSS Class for TD (use to alternate colors)
// sb_messagebody   = CSS Class for post text
// sb_signature     = CSS Class for signature
?>