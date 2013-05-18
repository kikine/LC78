<?php global $my, $database;
$database->setQuery("SELECT email, name from #__users WHERE `id`='$my->id'");
$database->loadObject($user);

?>

<script type="text/javascript">

/***********************************************
* Switch Content script- � Dynamic Drive (www.dynamicdrive.com)
* This notice must stay intact for legal use. Last updated April 2nd, 2005.
* Visit http://www.dynamicdrive.com/ for full source code
***********************************************/

var enablepersist="off" //Enable saving state of content structure using session cookies? (on/off)
var collapseprevious="yes" //Collapse previously open content when opening present? (yes/no)

var contractsymbol='- ' //HTML for contract symbol. For image, use: <img src="whatever.gif">
var expandsymbol='+ ' //HTML for expand symbol.


if (document.getElementById){
document.write('<style type="text/css">')
document.write('.switchcontent{display:none;}')
document.write('</style>')
}

function getElementbyClass(rootobj, classname){
var temparray=new Array()
var inc=0
var rootlength=rootobj.length
for (i=0; i<rootlength; i++){
if (rootobj[i].className==classname)
temparray[inc++]=rootobj[i]
}
return temparray
}

function sweeptoggle(ec){
var thestate=(ec=="expand")? "block" : "none"
var inc=0
while (ccollect[inc]){
ccollect[inc].style.display=thestate
inc++
}
revivestatus()
}


function contractcontent(omit){
var inc=0
while (ccollect[inc]){
if (ccollect[inc].id!=omit)
ccollect[inc].style.display="none"
inc++
}
}

function expandcontent(curobj, cid){
var spantags=curobj.getElementsByTagName("SPAN")
var showstateobj=getElementbyClass(spantags, "showstate")
if (ccollect.length>0){
if (collapseprevious=="yes")
contractcontent(cid)
document.getElementById(cid).style.display=(document.getElementById(cid).style.display!="block")? "block" : "none"
if (showstateobj.length>0){ //if "showstate" span exists in header
if (collapseprevious=="no")
showstateobj[0].innerHTML=(document.getElementById(cid).style.display=="block")? contractsymbol : expandsymbol
else
revivestatus()
}
}
}

function revivecontent(){
contractcontent("omitnothing")
selectedItem=getselectedItem()
selectedComponents=selectedItem.split("|")
for (i=0; i<selectedComponents.length-1; i++)
document.getElementById(selectedComponents[i]).style.display="block"
}

function revivestatus(){
var inc=0
while (statecollect[inc]){
if (ccollect[inc].style.display=="block")
statecollect[inc].innerHTML=contractsymbol
else
statecollect[inc].innerHTML=expandsymbol
inc++
}
}

function get_cookie(Name) {
var search = Name + "="
var returnvalue = "";
if (document.cookie.length > 0) {
offset = document.cookie.indexOf(search)
if (offset != -1) {
offset += search.length
end = document.cookie.indexOf(";", offset);
if (end == -1) end = document.cookie.length;
returnvalue=unescape(document.cookie.substring(offset, end))
}
}
return returnvalue;
}

function getselectedItem(){
if (get_cookie(window.location.pathname) != ""){
selectedItem=get_cookie(window.location.pathname)
return selectedItem
}
else
return ""
}

function saveswitchstate(){
var inc=0, selectedItem=""
while (ccollect[inc]){
if (ccollect[inc].style.display=="block")
selectedItem+=ccollect[inc].id+"|"
inc++
}

document.cookie=window.location.pathname+"="+selectedItem
}

function do_onload(){
uniqueidn=window.location.pathname+"firsttimeload"
var alltags=document.all? document.all : document.getElementsByTagName("*")
ccollect=getElementbyClass(alltags, "switchcontent")
statecollect=getElementbyClass(alltags, "showstate")
if (enablepersist=="on" && ccollect.length>0){
document.cookie=(get_cookie(uniqueidn)=="")? uniqueidn+"=1" : uniqueidn+"=0"
firsttimeload=(get_cookie(uniqueidn)==1)? 1 : 0 //check if this is 1st page load
if (!firsttimeload)
revivecontent()
}
if (ccollect.length>0 && statecollect.length>0)
revivestatus()
}

if (window.addEventListener)
window.addEventListener("load", do_onload, false)
else if (window.attachEvent)
window.attachEvent("onload", do_onload)
else if (document.getElementById)
window.onload=do_onload

if (enablepersist=="on" && document.getElementById)
window.onunload=saveswitchstate

</script>

<table class="boardtable" cellpadding="6" cellspacing="0" align="center" width="100%">
  <caption><a name="msg<?php echo $msg_id;?>" id="msg<?php echo $msg_id;?>" /></caption>
  <tr>
    <td style="padding:0px; border-bottom: 0.1em solid #FFFFFF" bgcolor="#E8E9E3">
      <table cellpadding="0" cellspacing="0" width="100%" >
        <tr>
          <td nowrap="nowrap" valign="top" width="71" style="padding:2px; border-right: 0.1em solid #FFFFFF"  bgcolor="#E8E9E3">
            <?php echo $msg_avatar;?>
          </td>
          <td>
             <table width="100%" cellpadding="0" cellspacing="0" >
               <tr>
                  <td nowrap="nowrap" valign="top" style="padding:2px; border-bottom: 0.1em solid #FFFFFF" colspan="4" >
                     <span style="font-family: Arial, Helvetica, sans-serif; font-size: 11pt; font-weight: bold; color: #ff6600;">
                        <?php echo $msg_subject;?>
                     </span>
                  </td>
               </tr>
               <tr>
                  <td nowrap="nowrap" valign="top" style="padding:2px; border-bottom: 0.1em solid #FFFFFF" width="120">
                     <span style="font-family: Arial, Helvetica, sans-serif; font-size: 8pt; font-weight: bold; color: #8B8B8B;">
                        Date: <?php echo $msg_date;?>
                     </span>
                  </td>
                  <td nowrap="nowrap" valign="top" style="padding:2px; border-left: 0.1em solid #FFFFFF; border-bottom: 0.1em solid #FFFFFF" width="140">
                    <span style="font-family: Arial, Helvetica, sans-serif; font-size: 8pt; font-weight: bold; color: #8B8B8B;">
                       By: <?php echo $msg_username;?>
                    </span>
                  </td>
                  <td nowrap="nowrap" valign="top" style="padding:2px; border-left: 0.1em solid #FFFFFF; border-bottom: 0.1em solid #FFFFFF">
                     <span style="font-family: Arial, Helvetica, sans-serif; font-size: 8pt; font-weight: bold; color: #8B8B8B;">
                        Status: <?php echo $msg_usertype;?>
                     </span>
                  </td>
                  <td nowrap="nowrap" valign="middle" style="padding:2px; border-left: 0.1em solid #FFFFFF; border-bottom: 0.1em solid #FFFFFF" width="90">
                     <?php if($msg_ip) echo $msg_ip_link.'<span style="font-family: Arial, Helvetica, sans-serif; font-size: 7pt; font-weight: bold; color: #8B8B8B;"">'.$msg_ip.'</span></a>'; else echo '&nbsp;';?>
                  </td>
               </tr>
               <tr>
                  <td nowrap="nowrap" valign="top" style="padding:2px;" width="120">
                     <span style="font-family: Arial, Helvetica, sans-serif; font-size: 8pt; font-weight: bold; color: #8B8B8B;">
                        <?php if($msg_karma) echo $msg_karma.'&nbsp&nbsp'.$msg_karmaplus.' '.$msg_karmaminus; else echo '&nbsp;';?>
                     </span>
                  </td>
               </tr>
             </table>
          </td>
          <td nowrap="nowrap" valign="top"  width="90" align="left" style="padding:3px; border-left: 0.1em solid #FFFFFF">
            <?php if($msg_userrank) echo $msg_userrank.'<br />';?>
            <?php if($msg_userrankimg) echo $msg_userrankimg.'<br />';?>
            <?php if($msg_posts) echo "Posts: $msg_posts<br />";?>
            <?php if($useGraph) $myGraph->BarGraphHoriz();?>
          </td>
        </tr>
      </table>
    </td>
  </tr>
  <tr>
    <td style="padding:4px; border-bottom: 0.1em solid #FFFFFF" bgcolor="#E8E9E3">
      <?php echo $msg_text;?>
      <?php if($msg_signature) {
         echo '<hr color="#F6F6FF" width="40%" align="left"/>';
         echo $msg_signature;
         } ?>
      <!--<hr color="#FFFFFF" />-->
    </td>
   </tr>
   <tr>
    <td style="padding:2px; border-bottom: 0.1em solid #FFFFFF" bgcolor="#E8E9E3" valign="bottom">
      <table cellspacing="0" cellpadding="0" width="100%">
         <tr>
            <td align="left">
               <?php if($msg_aim) echo $msg_aim;?>
               <?php if($msg_icq) echo $msg_icq;?>
               <?php if($msg_msn) echo $msg_msn;?>
               <?php if($msg_yahoo) echo $msg_yahoo;?>
               <?php if($msg_pms) echo $msg_pms;?>
               <?php if($msg_profile) echo $msg_profile;?>
               <?php if($msg_regdate) echo "<br />Join Date: " . strip_tags($msg_date) . "<br />";?>
               <?php if($msg_loc) echo "Location: $msg_loc<br />";?>

            </td>
            <td align="right">
               <?php
               if(defined('JB_ICONURL') && array_key_exists('reply',$sbIcons)) {
			   		if ($msg_closed == "") {
	                    echo $msg_reply;
    	                echo " ".$msg_quote;
	               		if ($msg_delete) echo " ".$msg_delete;
						if ($msg_move) echo " ".$msg_move;
	               		if ($msg_edit) echo " ".$msg_edit;
	               		if ($msg_sticky) echo " ".$msg_sticky;
	               		if ($msg_lock) echo " ".$msg_lock;
						}
					 else {
	               		echo $msg_closed;
					 }
                 }
                 else {
	                if ($msg_closed == "") {
						echo $msg_reply;?> | <?php echo $msg_quote;
	               		if ($msg_delete) echo " | ".$msg_delete;
						if ($msg_move) echo " | ".$msg_move;
		               	if ($msg_edit) echo " | ".$msg_edit;
		           		if ($msg_sticky) echo " | ".$msg_sticky;
		           		if ($msg_lock) echo " | ".$msg_lock;
					}
					else {
						echo $msg_closed;
					}
                 }
               ?>
            </td>
         </tr>
         <?php //we should only show the Quick Reply section to registered users. otherwise we are missing too much information!!
         if ($my->id > 0) {
         ?>
            <tr>
               <td colspan="2">
                  <span onClick="expandcontent(this, 'sc<?php echo $msg_id;?>')" style="cursor:hand; cursor:pointer"><span class="showstate"></span>Quick Reply</span><br />
                  <div id="sc<?php echo $msg_id; ?>" class="switchcontent"> <!-- make this div distinct from others on this page -->
                     <?php
                     //see if we need the users realname or his loginname
                     if ($sbConfig['username']) {
                        $authorName=$my->username;
                     }
                     else {
                        $authorName=$user->name;
                     }
                     //contruct the reply subject
                     $table = array_flip(get_html_translation_table(HTML_ENTITIES));
                     $resubject = htmlspecialchars(strtr($msg_subject, $table));
                     $resubject = strtolower(substr($resubject,0,strlen(_POST_RE)))==strtolower(_POST_RE)?stripslashes($resubject):_POST_RE.stripslashes($resubject);
                     ?>
                     <form action="<?php echo sefRelToAbs(JB_LIVEURL. '&amp;func=post'); ?>" method="post" name="postform" enctype="multipart/form-data">
                     <input type="hidden" name="parentid" value="<?php echo $msg_id;?>" />
                     <input type="hidden" name="catid" value="<?php echo $catid;?>" />
                     <input type="hidden" name="action" value="post" />
                     <input type="hidden" name="contentURL" value="empty" />
                     <input type="hidden" name="sb_authorname" size="35" class="inputbox" maxlength="35" value="<?php echo $authorName;?>" />
                     <input type="hidden" name="email" size="35" class="inputbox" maxlength="35" value="<?php echo $user->email;?>" />
                     <input type="hidden" name="subject" size="35" class="inputbox" maxlength="<?php echo $sbConfig['maxSubject'];?>" value="<?php echo $resubject;?>" />
                     <textarea class="inputbox" name="message" id="message" style="height: 100px; width: 100%; overflow:auto;" ></textarea>
                     <input type="submit" class="general" name="submit" value="<?php echo _GEN_CONTINUE;?>" /> <small><em>Please note, although no boardcode and smiley buttons are shown, they are still useable</em></small>
                     </form>
                  </div>
               </td>
            </tr>
         <?php
         } ?>
      </table>
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