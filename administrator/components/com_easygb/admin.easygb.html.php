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
   * Show credits
   *
   */
  function showCredits(){
    global $option, $easygb_version;
    ?>
    <table class="adminheading">
		<tr>
			<th class="cpanel" rowspan="2" nowrap>EasyGB credits</th>
	  </tr>
	  </table>
    <table cellpadding="4" cellspacing="0" border="0" width="100%" class="adminform">
	  <tr valign="top">
	    <td width="660">
	    <div id="cpanel">
	      <div style="float:left;">
	      <div class="icon">
  			<a href="index2.php?option=com_easygb&act=configuration">
  				<div class="iconimage">
  					<img src="images/config.png" alt="Configuration" align="middle" name="image" border="0" /></div>
  				Configuration</a>
  		  </div>
  		  </div>
	      <div style="float:left;">
	      <div class="icon">
  			<a href="index2.php?option=com_easygb&act=entries">
  				<div class="iconimage">
  					<img src="images/addedit.png" alt="Manage Entries" align="middle" name="image" border="0" /></div>
  				Manager  Messages</a>
  		  </div>
  		  </div>
	    </div>
	    </td>
	    <td>
	      <table cellpadding="4" cellspacing="0" border="1" class="adminform">
	      <tr>
	        <th colspan="2">Easy FAQ</th>
	      </tr>
	      <tr class="row0">
	        <td colspan="2" align="center"><center><img src="components/com_easygb/easygb.gif" alt="Easy GB logo" /></center></td>
	      </tr>
	      <tr class="row1">
	        <td width="100">Version Installer</td>
	        <td><?php echo $easygb_version; ?> </td>
	      </tr>
	      <tr class="row1">
	        <td>Copyright</td>

	        <td>&copy; 2006 Adam van Dongen <a href="http://www.joomla-addons.org" target="_blank">Joomla-addons.org</a></td>
	      </tr>
	      <tr class="row1">
	        <td>Support</td>
	        <td><a href="http://www.joomla-addons.org/option,com_smf/Itemid,7/board,29.0.html" target="_blank">Visit the forum</a></td>
	      </tr>
	      <tr class="row1">
	        <td colspan="2">
	          <!--Creative Commons License--><a rel="license" href="http://creativecommons.org/licenses/by-nd/2.5/"><img alt="Creative Commons License" border="0" src="http://creativecommons.org/images/public/somerights20.png"/></a><br/><br />This work is licensed under a <a rel="license" href="http://creativecommons.org/licenses/by-nd/2.5/">Creative Commons Attribution-NoDerivs 2.5 License</a>.<!--/Creative Commons License--><!-- <rdf:RDF xmlns="http://web.resource.org/cc/" xmlns:dc="http://purl.org/dc/elements/1.1/" xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#">
          	<Work rdf:about="">
          		<license rdf:resource="http://creativecommons.org/licenses/by-nd/2.5/" />
          	</Work>
          	<License rdf:about="http://creativecommons.org/licenses/by-nd/2.5/"><permits rdf:resource="http://web.resource.org/cc/Reproduction"/><permits rdf:resource="http://web.resource.org/cc/Distribution"/><requires rdf:resource="http://web.resource.org/cc/Notice"/><requires rdf:resource="http://web.resource.org/cc/Attribution"/></License></rdf:RDF> -->
	        </td>
	      </tr>
	      </table>

	    </td>
	  </tr>
	  </table>
    <?php
  }
  
  /**
   * Show all Guestbook entries
   *
   * @param array $rows
   * @param mosPageNav $pageNav
   */
  function showEntries($rows, $pageNav){
    global $option;
    ?>
    <form action="index2.php" method="post" name="adminForm">

		<table class="adminheading">
		<tr>
			<th class="edit" rowspan="2" nowrap>Manager Messages </th>
	  </tr>
	  </table>
	  
	  <table class="adminlist">
		<tr>
			<th width="5">
			#
			</th>
			<th width="5">
			<input type="checkbox" name="toggle" value="" onClick="checkAll(<?php echo count( $rows ); ?>);" />
			</th>
			<th class="title">Date</th>
			<th class="title">Contenu</th>
			<th class="title" width="5%">IP</th>
			<th class="title">Navigateur</th>
			<th class="title" width="5%">Publication</th>
	  </tr>
		<?php
		$k = 0;
		for ($i=0, $n=count( $rows ); $i < $n; $i++) {
			$row = &$rows[$i];
			?>
			<tr>
			  <td><?php echo $pageNav->rowNumber( $i ); ?></td>
			  <td><?php echo mosHTML::idBox($i, $row->id); ?></td>
			  <td><a href="index2.php?option=<?php echo $option; ?>&act=entries&task=edit&cid=<?php echo $row->id; ?>&hidemainmenu=1"><?php echo mosFormatDate($row->date, _DATE_FORMAT_LC2); ?></td>
			  <td><?php echo (strlen($row->content) > 100 ? substr($row->content, 0, 100) . '...' : $row->content); ?></td>
			  <td><?php echo $row->ip; ?></td>
			  <td><?php echo $row->browser; ?></td>
			  <td align="center">
					<a href="javascript:void(0);" onclick="return listItemTask('cb<?php echo $i;?>','<?php echo $row->published ? "unpublish" : "publish";?>')">
					<img src="images/<?php echo ($row->published ? 'tick.png' : 'publish_x.png');?>" width="12" height="12" border="0" alt="<?php echo $alt; ?>" />
					</a>
				</td>
			</tr>
			<?php
		}
		?>
	  </table>
	  
	  <?php echo $pageNav->getListFooter(); ?>
	  
	  <input type="hidden" name="option" value="<?php echo $option; ?>" />
		<input type="hidden" name="act" value="entries" />
		<input type="hidden" name="task" value="" />
		<input type="hidden" name="boxchecked" value="0" />
		<input type="hidden" name="hidemainmenu" value="0" />
		</form>
    <?php
  }
  
  /**
   * Edit or add an entry item
   *
   * @param dbEasyGB $row
   */
  function editEntry($row){
    global $option;
    ?>
    
    <form action="index2.php" method="post" name="adminForm">

		<table class="adminheading">
		<tr>
			<th class="edit" rowspan="2" nowrap><?php echo ($row->id ? 'Edit' : 'Add'); ?> entry</th>
	  </tr>
	  </table>
	  
	  <table cellspacing="0" cellpadding="0" width="100%">
		<tr valign="top">
			<td valign="top">
    	  <table class="adminlist">
    		<tr>
    			<th class="title" colspan="2">Edition des Details du Message</th>
    	  </tr>
    	  <tr>
    	    <td width="50">Date:</td>
    	    <td><?php echo mosFormatDate($row->date, _DATE_FORMAT_LC2); ?></td>
    	  </tr>
    	  <tr>
    	    <td>Titre:</td>
    	    <td><input type="text" name="title" value="<?php echo $row->title; ?>" size="50" /></td>
    	  </tr>
    	  <tr>
    	    <td>Nom:</td>
    	    <td><input type="text" name="name" value="<?php echo $row->name; ?>" size="50" /></td>
    	  </tr>
    	  <tr>
    	    <td>Email:</td>
    	    <td><input type="text" name="email" value="<?php echo $row->email; ?>" size="50" /></td>
    	  </tr>
    	  <tr>
    	    <td>Site Internet :</td>
    	    <td><input type="text" name="homepage" value="<?php echo $row->homepage; ?>" size="50" /></td>
    	  </tr>
    	  <tr>
    	    <td>Vote:</td>
    	    <td>
    	      Poor
    	      <input type="radio" class="inputbox" name="rating" value="1" <?php echo ($row->rating == 1 ? 'checked="checked"' : ''); ?> />
    	      <input type="radio" class="inputbox" name="rating" value="2" <?php echo ($row->rating == 2 ? 'checked="checked"' : ''); ?> />
    	      <input type="radio" class="inputbox" name="rating" value="3" <?php echo ($row->rating == 3 ? 'checked="checked"' : ''); ?> />
    	      <input type="radio" class="inputbox" name="rating" value="4" <?php echo ($row->rating == 4 ? 'checked="checked"' : ''); ?> />
    	      <input type="radio" class="inputbox" name="rating" value="5" <?php echo ($row->rating == 5 || is_null($row->rating) ? 'checked="checked"' : ''); ?> />
    	      Great
    	    </td>
    	  </tr>
    	  <tr valign="top">
    	    <td>Message:</td>
    	    <td><textarea rows="10" cols="50" name="content"><?php echo $row->content; ?></textarea></td>
    	  </tr>
    	  <tr>
    	    <td>Publication:</td>
    	    <td><input type="checkbox" name="published" value="1" <?php echo ($row->published ? 'checked="checked"' : ''); ?> /></td>
    	  </tr>
    	  </table>
    	</td>
    </tr>
    </table>
	  <input type="hidden" name="id" value="<?php echo $row->id; ?>" />
	  <input type="hidden" name="option" value="<?php echo $option; ?>" />
		<input type="hidden" name="act" value="entries" />
		<input type="hidden" name="task" value="" />
		<input type="hidden" name="boxchecked" value="0" />
		<input type="hidden" name="hidemainmenu" value="0" />
		</form>
	  <?php
  }
  
  /**
   * Show configuration
   *
   */
  function editConfiguration(){
    global $option, $mainframe;
    
    $tabs = new mosTabs(0);
    
    require($mainframe->getCfg('absolute_path') . '/administrator/components/com_easygb/configuration.php');
    ?>
    <form action="index2.php" method="post" name="adminForm">
    <table class="adminheading">
		<tr>
			<th class="config" rowspan="2" nowrap>EasyGB configuration</th>
	  </tr>
	  </table>
    <?php
		$tabs->startPane("configPane");
		$tabs->startTab("General","general-page");
		?>
		<table class="adminform">
		<tr>
			<td width="200">Post pour Membre seulement:</td>
			<td><?php echo mosHTML::yesnoRadioList('config[users_only]', '', $easygbConfig_users_only); ?></td>
		</tr>
		<tr>
			<td>Publication Automatique:</td>
			<td><?php echo mosHTML::yesnoRadioList('config[auto_publish]', '', $easygbConfig_auto_publish); ?></td>
		</tr>
		<tr>
			<td>Avertir l'administrateur pour les nouveaux posts:</td>
			<td><?php echo mosHTML::yesnoRadioList('config[mail_admin]', '', $easygbConfig_mail_admin); ?></td>
		</tr>
	  </table>
	  <?php
	  $tabs->endTab();
	  $tabs->startTab("User info","info-page");
		?>
		<table class="adminform">
		<tr>
			<td width="200">Afficher l'IP de l'utilisateur:</td>
			<td><?php echo mosHTML::yesnoRadioList('config[show_ip]', '', $easygbConfig_show_ip); ?></td>
		</tr>
		<tr>
			<td>Afficher le navigateuret sa version:</td>
			<td><?php echo mosHTML::yesnoRadioList('config[show_browser]', '', $easygbConfig_show_browser); ?></td>
		</tr>
		<tr>
			<td>Affiche le Ste Internet de l'utisateur:</td>
			<td><?php echo mosHTML::yesnoRadioList('config[show_homepage]', '', $easygbConfig_show_homepage); ?></td>
		</tr>
		<tr>
			<td>Afficher l'adresse E-Mail de l'utilisateur (cloaked):</td>
			<td><?php echo mosHTML::yesnoRadioList('config[show_email]', '', $easygbConfig_show_email); ?></td>
		</tr>
		<tr>
			<td>Afficher post time:</td>
			<td><?php echo mosHTML::yesnoRadioList('config[show_date]', '', $easygbConfig_show_date); ?></td>
		</tr>
		<tr>
			<td>Afficher le vote :</td>
			<td><?php echo mosHTML::yesnoRadioList('config[show_rating]', '', $easygbConfig_show_rating); ?></td>
		</tr>
	  </table>
	  <?php
	  $tabs->endTab();
	  $tabs->startTab("Anti-spam","spam-page");
		?>
		<table class="adminform">
		<tr>
			<td width="200">Liens  signal&eacute;s par des invit&eacute;s:</td>
			<td><?php echo mosHTML::yesnoRadioList('config[guest_striplinks]', '', $easygbConfig_guest_striplinks); ?></td>
		</tr>
		<tr>
			<td> Liens  signal&eacute;s par des utilisateurs:</td>
			<td><?php echo mosHTML::yesnoRadioList('config[user_striplinks]', '', $easygbConfig_user_striplinks); ?></td>
		</tr>
		<tr>
			<td>Longueur du code de CAPTCHA:</td>
			<td><input type="text" name="config[captcha_length]" value="<?php echo $easygbConfig_captcha_length; ?>" size="5" /></td>
		</tr>
		<tr>
			<td>Nombre de lignes utilis&eacute;es dans CAPTCHA:</td>
			<td><input type="text" name="config[captcha_lines]" value="<?php echo $easygbConfig_captcha_lines; ?>" size="5" /></td>
		</tr>
	  </table>
	  <?php
	  $tabs->endTab();
	  $tabs->endPane();
	  ?>
	  <input type="hidden" name="option" value="<?php echo $option; ?>" />
		<input type="hidden" name="act" value="configuration" />
		<input type="hidden" name="task" value="" />
		<input type="hidden" name="boxchecked" value="0" />
		<input type="hidden" name="hidemainmenu" value="0" />
		</form>
	  <?php
  }
}

?>