<?php
/**
* @version $Id: admin.installer.html.php,v 1.24 2004/09/23 18:47:32 saka Exp $
* @package Mambo_4.5.1
* @copyright (C) 2000 - 2004 Miro International Pty Ltd
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* Mambo is Free Software
* @subpackage Installer
* @version Safemode Patch 1.0
*/

/** ensure this file is being included by a parent file */
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

function writableCell( $folder ) {
	echo '<tr>';
	echo '<td class="item">' . $folder . '/</td>';
	echo '<td align="left">';
	echo is_writable( $GLOBALS['mosConfig_absolute_path'] . '/' . $folder ) ? '<b><font color="green">Writeable</font></b>' : '<b><font color="red">Unwriteable</font></b>' . '</td>';
	echo '</tr>';
}

/**
* @package Mambo_4.5.1
*/
class HTML_installer
{
	function showInstallForm( $title, $option, $element, $client = "", $p_startdir = "", $backLink="" )
	{
		global $database, $ftpIsAvailable, $isWindows;
	?>
	<script language="javascript" type="text/javascript">
		
		function checkFtpForm(){
			myForm=document.forms['adminForm_install'];
			if(myForm.ftpUse.checked &&
				(myForm.ftpUserName.value == "" ||
				myForm.ftpPassword.value == "" ||
				myForm.ftpHostName.value == "" )){
				alert("You have chosen 'FTP Assist'.  Please provide a Username, Password, and Hostname");
				return false;
			}
			return true;
		}

		function getFtpForm(thisForm){
			myForm=document.forms['adminForm_install'];
			thisForm.ftpUserName.value=myForm.ftpUserName.value;
			thisForm.ftpPassword.value=myForm.ftpPassword.value;
			thisForm.ftpHostName.value=myForm.ftpHostName.value;

			if(myForm.ftpUse.checked){
				thisForm.ftpUse.value='1';
				if(checkFtpForm()) return true;
				return false;
			} else thisForm.ftpUse.value='0';

			return true;
		}

		function submitform(pressbutton){
			document.adminForm.task.value=pressbutton;
			document.adminForm.action='index2.php';
			try {
				if(!document.adminForm.onsubmit()) return false;
			}
			catch(e){}
			document.adminForm.submit();
			return true;
		}
		
		function submitbutton3(pressbutton) {
			var form = document.adminForm_dir;

			// do field validation
			if (form.userfile.value == ""){
				alert( "Please select a directory" );
			} else {
				//form.submit();
			}
		}
	</script>
	
<?php
	// dmcd - php safe mode is only an issue for module or component installation if the mambo
	// scripts are being executed by an apache web server process of a different effective uid to
    // the script uid.  In this case, any file or directory these scripts create will become
    // instantly unuseable to themselves!
	// Some php installations may even disable certain php functions as well, such as 'getmypid' by
	// always returning a result of 0.  Bad News!

	//echo .getmypid().'<br />;
	//echo .getmyuid().'<br />;
	// note that the posix functions are NOT available on a windows platform
	// For windows, need to understand that a little better

	if(!$isWindows)
		// dmcd dec 27/03, want to assume uids diff if posix functions unavailable
		$safeMode = ini_get('safe_mode') == 1 && (!function_exists('posix_geteuid') || @getmyuid() != @posix_geteuid());
	else
		$safeMode = ini_get('safe_mode') == 1;

	if($safeMode){ ?>
	<br /><div style='margin-bottom:10pt; text-decoration:underline; text-align:center; font-weight:bold; font-size:12pt;color:red;'>WARNING! </div>
	<div style='text-align:justify;'>This web host is running a particular implementation of PHP <b>safe mode</b> which places severe limitations
 on what files the Mambo admin interface can create.  File uploads will currently not install correctly unless you select
 the <b>FTP Assist</b> option below.  FTP Assist uses your site admin’s  FTP account to copy, make directories, and
 set permissions for newly installed components, modules, or templates.  This also allows all file ownership to be retained by
the site admin uid which can improve security and alleviate site maintenance problems thru the FTP client later.  To use FTP
 Assist, click the ‘Use FTP Assist’ checkbox below and provide your FTP account username, password, and host
 address in the provided test boxes.  The password is not retained by Mambo for security reasons.

<br /><br />If the ‘use FTP Assist’ checkbox is disabled below, then your current PHP implementation on this host does not support FTP.
  The only other alternative for installation is to perform a manual install using the <b>Install from directory</b>
 option below.  You will need to use an ftp client on your PC to transfer the uncompressed component or module
 installation files (using a zip utility) to a temporary directory on this site.  You will need to view the
  module/component/template's .xml installation directive file to determine what and where to manually create (thru your ftp client) any new
 installation subdirectories and where to copy the files from the temporary install directory over to the proper
 destination areas, just as the .xml file would direct this installer script.  After completing this manual process, proceed
 with the <b>Install from directory</b> option below.  The script will verify that all required files and directories have
 been properly copied by you.  Then the required Mambo database changes will be performed to complete installation.
  Note: you will need to enable write access to your components subdirectory as 755 at a minimum
 (ie. owner: rwx group: r-x everyone: r-x) or 777 (all rwx)<br /><br /></div>

<?php

	} elseif (!$isWindows && (!function_exists('posix_geteuid') || @getmyuid() != @posix_geteuid()) && $ftpIsAvailable) {
?>

	<br /><div style='margin-bottom:10pt; text-decoration:underline; text-align:center; font-weight:bold; font-size:12pt;color:red;'>WARNING! </div>
	<div style='text-align:justify;'>This web host is running a particular implementation of PHP where executable scripts are possibly being executed by a process with an <i>effective</i> uid different to that
 of the file uid of exisitng Mambo PHP scripts.  Using normal installation, any new component or module script files, directories or other files such as images will be owned by
  the apache server process.  In order for mambo to function correctly, these new files and directories will need to have their file permissions set to 777 (all rwx).
    This allows other scripts to read these files properly.  The installer will ensure that permissions are set properly.  However, this compromises web security since now
    certain files will be writable by any script created by the apache server process.<br /><br />

To maintain consistent file ownership and improve security, it is advised that the <b>FTP Assist</b> option be
used to assist in this installation.  By checking the 'Use FTP Assist' checkbox below, the site FTP User name, Password, and Host name should be entered in the textbox areas provided.
  The FTP password is not stored within Mambo and is used only briefly before being deleted for security reasons.  Note that FTP assist can be used for
 either 'Upload...' or 'Install from Directory' install options.
</div><br />
<?php }

	if(!extension_loaded('zlib') && !($safeMode && !$ftpIsAvailable)) { ?>
	<br /><div style='margin-bottom:10pt; text-decoration:underline; text-align:center; font-weight:bold; font-size:12pt;color:red;'>WARNING! </div>
	<div style='text-align:justify;'>The PHP installation on this web host does not have the zlib compression library loaded.  This will prevent any successful
 installation of an uploaded compressed component or module archive (IE. .zip, .gz, .tgz).  You can put a request in to your host provider to add this, or you can use a <b>tar</b> type file archive which is an uncompressed
 format.  To convert <b>zip</b> files to <b>tar</b>, you can download the following free windows-based file archive utility:
 <a style='color:red;' href='http://www.ultimatezip.com'>Ultimatezip</a>.  Be sure that the .tar file extension is lower case before attempting to upload.</div><br />
	<?php
	}

	// get ftp accnt info from database
	$ftpDB = new ftpHostAccnt;
	$ftpDB->getFtpAccnt();

	if($ftpDB->ftpUserName=='' || !$ftpIsAvailable)
		// disable FP assist if no username or no ftp lib
        $ftpDB->enable=0;

	if($ftpDB->ftpHostName == '')
		// use server host name as default
		$ftpDB->ftpHostName = preg_replace('/^www\./', '', $_SERVER['SERVER_NAME']);

?>
	<br />
	<form action="index2.php" method="POST" name="adminForm_install">
	<table border="0" cellpadding="4" cellspacing="0" width="100%" class="adminform">
	  <tr>
	    <td align="Left">Use FTP Assist&nbsp;<input class="checkbox" name="ftpUse" type="checkbox" <?= ($ftpDB->enable) ? 'Checked' : '' ?> <?= !$ftpIsAvailable ? 'Disabled':'' ?> onClick="myForm=document.forms['adminForm_install'];
	    myTextBoxes = document.getElementById('ftpTextBoxes');
	    if (this.checked)
	    {myTextBoxes.style.color='black';myForm.ftpHostName.disabled=false;myForm.ftpUserName.disabled=false;myForm.ftpPassword.disabled=false; myForm.ftpPassword.value='<?= $ftpDB->ftpPassword ?>' }
	    else {myTextBoxes.style.color='gray';myForm.ftpHostName.disabled=true;myForm.ftpUserName.disabled=true;myForm.ftpPassword.disabled=true;myForm.ftpPassword.value='';}return true;" />
	    <span id='ftpTextBoxes' style='color: <?= $ftpDB->enable ? 'black;' : 'gray;' ?>'>&nbsp;&nbsp;&nbsp;User Name&nbsp;<input style='color:inherit;' class="inputbox" name="ftpUserName" type="text" value="<?= $ftpDB->ftpUserName ?>" <?= $ftpDB->enable ? '' : 'Disabled' ?> />&nbsp;&nbsp;&nbsp;Password&nbsp;
		<input  style='color:inherit;' class="inputbox" name="ftpPassword" type="password" value="<?= $ftpDB->ftpPassword ?>" <?= $ftpDB->enable ? '' : 'Disabled' ?> />&nbsp;&nbsp;&nbsp;Host&nbsp;
		<input  style='color:inherit;' class="inputbox" name="ftpHostName" type="text" value="<?= $ftpDB->ftpHostName ?>" <?= $ftpDB->enable ? '' : 'Disabled' ?> /></span></td>
	  </tr>
	</table>
	</form>

<form enctype="multipart/form-data" action="index2.php" method="post" name="filename" OnSubmit="return getFtpForm(filename);">
	<input type="hidden" name="task" value="uploadfile" />
	<input type="hidden" name="option" value="<?php echo $option;?>">
	<input type="hidden" name="element" value="<?php echo $element;?>">
	<input type="hidden" name="client" value="<?php echo $client;?>">
	<input type="hidden" name="ftpUse" value="0" />
	<input type="hidden" name="ftpUserName" value="" />
	<input type="hidden" name="ftpPassword" value="" />
	<input type="hidden" name="ftpHostName" value="" />

	<table class="adminheading">
	  <tr>
	    <th><?php echo $title;?></th>
	    <td align="right" nowrap="true"><?php echo $backLink;?></td>
	  </tr>
	</table>
	<table class="adminform">
	  <tr>
	    <th>Upload Package File</th>
	  </tr>
	  <tr>
	    <td align="Left">Package File:&nbsp;<input class="text_area" name="userfile" type="file" />&nbsp;<input class="button" type="submit" value="Upload File &amp; Install" />
	    <?= $safeMode ? '&nbsp;&nbsp;&nbsp;<span style=\'font-style:italic;color:red;font-size:8pt;\'>(FTP Assist option recommended)</span>' : '' ?></td>
	  </tr>
	</table>
</form>
<br />

<form enctype="multipart/form-data" action="index2.php" method="post" name="adminForm_dir" OnSubmit="submitbutton3(); return getFtpForm(adminForm_dir);">
	<input type="hidden" name="task" value="installfromdir" />
	<input type="hidden" name="option" value="<?php echo $option;?>">
	<input type="hidden" name="element" value="<?php echo $element;?>">
	<input type="hidden" name="client" value="<?php echo $client;?>">
	<input type="hidden" name="ftpUse" value="0" />
	<input type="hidden" name="ftpUserName" value="" />
	<input type="hidden" name="ftpPassword" value="" />
	<input type="hidden" name="ftpHostName" value="" />
	<table class="adminform">
	  <tr>
	    <th>Install from directory</th>
	  </tr>
	  <tr>
	    <td align="Left">
			Install directory:&nbsp;
			<input type="text" name="userfile" class="text_area" size="50" value="<?php echo $p_startdir; ?>"/>&nbsp;
			<input type="submit" class="button" value="Install" />
			<?= ($safeMode && !$disableInstFrmDir) ? '&nbsp;&nbsp;&nbsp;<span style=\'font-style:italic;color:red;font-size:8pt;\'>(FTP Assist option recommended)</span>' : '' ?>
		</td>
	  </tr>
	</table>
</form>
	<?php
	}
/**
* @param string
* @param string
* @param string
* @param string
*/
	function showInstallMessage( $message, $title, $url ) {
		global $PHP_SELF;
?>
<table class="adminheading">
	<tr>
		<th class="install">
			<?php echo $title; ?>
		</th>
	</tr>
</table>
<table class="adminform">
	<tr>
		<td align="Left">
			<strong><?php echo $message; ?></strong>
		</td>
	</tr>
	<tr>
		<td colspan="2" align="center">
			[&nbsp;<a href="<?php echo $url;?>" style="font-size: 16px; font-weight: bold">Continue ...</a>&nbsp;]
		</td>
	</tr>
</table>
<?php
	}
}
?>
