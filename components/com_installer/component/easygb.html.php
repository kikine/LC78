<?php
/**
* @package EasyGB
* @copyright (C) 2006 Joomla-addons.org
* @author Websmurf
* 
* --------------------------------------------------------------------------------
* All rights reserved.  Easy GB Component for Joomla!
*
* This program is free software; you can redistribute it and/or
* modify it under the terms of the Creative Commons - Attribution-NoDerivs 2.5 
* license as published by the Creative Commons Organisation
* http://creativecommons.org/licenses/by-nd/2.5/.
*
* This program is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  
* --------------------------------------------------------------------------------
**/

defined( '_VALID_MOS' ) or die( 'Restricted access' );

class HTML_easygb {
  
  /**
   * Show all guestbook entries
   *
   * @param array $rows
   * @param <var>mosPageNav</var> $pageNav
   */
  function showGBEntries($rows, $pageNav){
    global $option, $Itemid;
    global $easygbConfig_show_ip, $easygbConfig_show_browser, $easygbConfig_show_homepage, $easygbConfig_show_email, $easygbConfig_show_date, $easygbConfig_show_rating;
    ?>
    <form action="index2.php" method="post" name="adminForm">

    <div class="componentheading">View guestbook</div>
	  <table class="adminform" width="100%" cellpadding="0" cellspacing="0">
	  <tr>
	    <td>Displaying <?php echo ($pageNav->limitstart > 0 ? $pageNav->limitstart : 1); ?> - <?php echo ($pageNav->limitstart + $pageNav->limit < $pageNav->total ? $pageNav->limitstart + $pageNav->limit : $pageNav->total); ?> of <?php echo $pageNav->total; ?> results</td>
	    <td><div style="float: right"><a href="index.php?option=<?php echo $option; ?>&task=new&Itemid=<?php echo $Itemid; ?>">Add new entry</a></div></td>
	  </tr>
	  <tr>
	    <td class="sectiontableheader">Name</td>
	    <td class="sectiontableheader">Message</td>
	  </tr>
		<?php
		$k = 0;
		for ($i=0, $n=count( $rows ); $i < $n; $i++) {
			$row = &$rows[$i];
			
			easyGB::process($row);
			?>
			
			<tr valign="top" class="sectiontableentry<?php echo $k + 1; ?>">
			  <td width="150" height="20">
			    <?php echo $row->name; ?><br /><br />
			    <?php if($easygbConfig_show_date) { ?>
			    <img src="components/com_easygb/icons/16x16_clock.png" alt="Posted at <?php echo mosFormatDate($row->date, _DATE_FORMAT_LC2); ?>" title="Posted at <?php echo mosFormatDate($row->date, _DATE_FORMAT_LC2); ?>" border="0" />
			    <?php } 
			    if($easygbConfig_show_homepage && (!empty($row->homepage))) { ?>
			    <a href="<?php echo (substr($row->homepage, 0, 4) != 'http' ? 'http://' . $row->homepage : $row->homepage); ?>"><img src="components/com_easygb/icons/16x16_gohome.png" alt="Visit posters website" title="Visit posters website" border="0" /></a>
			    <?php } 
			    if($easygbConfig_show_email) { ?>
			    <?php echo mosHTML::emailCloaking($row->email, 1, '<img src="components/com_easygb/icons/16x16_kmail.png" alt="Send poster a message" title="Send poster a message" border="0" />', 0); ?>
			    <?php } 
			    if($easygbConfig_show_ip) { ?>
			    <img src="components/com_easygb/icons/16x16_network_local.png" alt="IP: <?php echo $row->ip; ?>" title="IP: <?php echo $row->ip; ?>" border="0" />
			    <?php } 
			    if($easygbConfig_show_browser) { ?>
			    <img src="components/com_easygb/icons/16x16_display.png" alt="<?php echo $row->browser; ?>" title="<?php echo $row->browser; ?>" border="0" /></a>
			    <?php } ?>
			  </td>
			  <td><?php echo nl2br($row->content); ?></td>
			</tr>
			<tr valign="top" class="sectiontableentry<?php echo $k + 1; ?>">
			  <td>&nbsp;</td>
			  <td align="right">
			    <?php 
			    if($easygbConfig_show_rating){
  			    for($j=5;$j>$row->rating;$j--){
  			      echo '<img src="images/M_images/rating_star_blank.png" border="0" align="right" />';
  			    }
  			    for($j=0;$j<$row->rating;$j++){
  			      echo '<img src="images/M_images/rating_star.png" border="0" align="right" />';
  			    }
			    }
			    ?>
			  </td>
			</tr>
			
			<?php
			$k = 1 - $k;
		}
    ?>
    </table>
		<br />
		<?php
		$link = 'index.php?option=' . $option . '&amp;Itemid=' . $Itemid;
	  echo $pageNav->writePagesLinks($link); 
	  ?>
	  
	  <input type="hidden" name="option" value="<?php echo $option; ?>" />
	  <input type="hidden" name="Itemid" value="<?php echo $Itemid; ?>" />
		<input type="hidden" name="task" value="" />
		<input type="hidden" name="boxchecked" value="0" />
		<input type="hidden" name="hidemainmenu" value="0" />
		</form>
    <?php
  }
  
  /**
   * Add/edit entry
   *
   * @param <var>dbEasyGB</var> $row
   */
  function editentry($row){
    global $option, $Itemid, $my, $mainframe, $easygbConfig_users_only, $easygbConfig_show_rating, $easygbConfig_show_homepage;
    
    if(!$my->id){
      if($easygbConfig_users_only){
        mosNotAuth();
        return;
      }
      $mainframe->set('joomlaJavascript', 1);
    }
    
    $code = easyCAPTCHA::generateCode();
    
    $validate = josSpoofValue();
    ?>
    <form action="index2.php" method="post" name="adminForm">
    <div class="componentheading">Create a new guestbook entry</div>
    <table class="adminform" width="100%" cellpadding="0" cellspacing="0">
	  <tr>
	    <td class="sectiontableheader" colspan="2">Information</td>
	  </tr>
	  <?php if(!$my->id){ ?>
	  <tr>
	    <td width="150">Your name:</td>
	    <td><input type="text" class="inputbox" name="name" value="" /></td>
	  </tr>
	  <tr>
	    <td>Your emailaddress:</td>
	    <td><input type="text" class="inputbox" name="email" value="" /></td>
	  </tr>
	  <?php } ?>
	  <?php if($easygbConfig_show_homepage){ ?>
	  <tr>
	    <td>Homepage:</td>
	    <td><input type="text" class="inputbox" name="homepage" value="" /></td>
	  </tr>
	  <?php } ?>
	  <?php if($easygbConfig_show_rating){ ?>
	  <tr>
	    <td>Rating:</td>
	    <td> 
	      Poor
	      <input type="radio" class="inputbox" name="rating" value="1" />
	      <input type="radio" class="inputbox" name="rating" value="2" />
	      <input type="radio" class="inputbox" name="rating" value="3" />
	      <input type="radio" class="inputbox" name="rating" value="4" />
	      <input type="radio" class="inputbox" name="rating" value="5" checked="checked" />
	      Great
	    </td>
	  </tr>
	  <?php } ?>
	  <tr valign="top">
	    <td>Message:</td>
	    <td><textarea class="inputbox" name="content" rows="7" cols="30"></textarea></td>
	  </tr>
	  <tr valign="top">
	    <td>Code:</td>
	    <td>
	      <img src="index2.php?option=<?php echo $option; ?>&task=captcha&hash=<?php echo md5($code); ?>&Itemid=<?php echo $Itemid; ?>&no_html=1&time=<?php echo time(); ?>" alt="code" border="0" /><br />
	      Enter the code from the image above:<br />
	      <input type="text" name="captcha_code" size="10" value="" />
	    </td>
	  </tr>
	  <tr>
	    <td>&nbsp;</td>
	    <td><input type="button" class="button" onclick="submitbutton('save');" value="Submit" /></td>
	  </tr>
	  </table>
	  <input type="hidden" name="<?php echo $validate; ?>" value="1" />
    <input type="hidden" name="option" value="<?php echo $option; ?>" />
	  <input type="hidden" name="Itemid" value="<?php echo $Itemid; ?>" />
	  <input type="hidden" name="hash" value="<?php echo md5($code); ?>" />
		<input type="hidden" name="task" value="" />
		<input type="hidden" name="boxchecked" value="0" />
		<input type="hidden" name="hidemainmenu" value="0" />
		</form>
    <?php
  }
  
  /**
   * Show copyright notices
   */
  function showCopyright(){
    global $mainframe;

    /**
     * Visible copyright notices, you can remove it if you like
     */
    echo '<div class="small" style="clear: both;"><br />Powered by <a href="http://www.joomla-addons.org/easy-guestbook-component.html" target="_blank">Easy Guestbook</a> &copy; 2006 <a href="http://www.joomla-addons.org" target="_blank" title="Joomla components, modules, plugins and hosting">Joomla-addons.org</a></div>';

    /**
     * I would appreciate it very much if you could leave this present,
     * this is something your users will never see
     */
    $mainframe->addMetaTag('Generator', 'Easy Guestbook by www.joomla-addons.org');
  }
}

?>