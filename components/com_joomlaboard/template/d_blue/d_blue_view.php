<table class="boardtable" cellpadding="6" cellspacing="0" align="center" width="100%">
  <caption><a name="msg<?php echo $msg_id;?>" id="msg<?php echo$msg_id;?>" /></caption>
  <tr>
    <td bgcolor="#B4D4FF" style="padding:0px">
      <table cellpadding="0" cellspacing="6" border="0" width="100%">
        <tr>
          <td nowrap="nowrap">
            <?php echo $msg_avatar;?>
          </td>
          <td nowrap="nowrap">
            <span style="font-family: Arial, Helvetica, sans-serif; font-size: 14pt; font-weight: bold; color: #0048b0;"><?php echo$msg_username;?></span><br />
            <?php echo $msg_userrank;?>
            <?php if($msg_ip) echo "<br />\n$msg_ip";?>
          </td>
          <td width="100%">&nbsp;</td>
          <td nowrap="nowrap">
            <?php if($msg_regdate) echo "Join Date: " . strip_tags($msg_date) . "<br />";?>
            <?php if($msg_posts) echo "Posts: $msg_posts<br />";?>
            <?php if($msg_loc) echo "Location: $msg_loc<br />";?>
            <?php if($msg_aim) echo $msg_aim;?>
            <?php if($msg_icq) echo $msg_icq;?>
            <?php if($msg_msn) echo $msg_msn;?>
            <?php if($msg_yahoo) echo $msg_yahoo;?>
            <?php if($msg_pms) echo $msg_pms;?>
            <?php if($msg_profile) echo $msg_profile;?>
          </td>
        </tr>
      </table>
    </td>
  </tr>
  <tr>
    <td bgcolor=#FBFBFB>
      <strong><?php echo $msg_subject;?></strong> - <em><?php echo $msg_date;?></em>
      <hr size="1" style="color:#D1D1E1" />
      <?php echo$msg_text;?>
      <?php if($msg_signature) echo "<hr style=\"margin: 13 0 13 0; padding: 0; height: 1px; border-bottom: 1px dashed #F6F6FF; \" />$msg_signature";?>
      <hr size="1" style="color:#D1D1E1" />
      <div align="right">
        <?php if($msg_reply) echo $msg_reply;?>
        <?php if($msg_quote) echo $msg_quote;?>
        <?php if($msg_edit) echo $msg_edit;?>
        <?php if($msg_closed) echo $msg_closed;?>
        <?php if($msg_delete) echo $msg_delete;?>
        <?php if($msg_sticky) echo $msg_sticky;?>
        <?php if($msg_lock) echo $msg_lock;?>
      </div>
    </td>
  </tr>
</table>
<br />

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
// $msg_pms         = Linked image for PMS2
// $msg_buddy       = Add buddy image link
// $msg_loc         = User's Location
// $msg_regdate     = User's Registration Date 
// $tabclass[$k]    = CSS Class for TD (use to alternate colors)
// sb_messagebody   = CSS Class for post text
// sb_signature     = CSS Class for signature
?>