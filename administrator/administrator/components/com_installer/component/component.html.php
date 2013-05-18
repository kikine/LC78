<?php
/**
* @version $Id: component.html.php,v 1.7 2004/09/18 12:10:33 stingrey Exp $
* @package Mambo_4.5.1
* @copyright (C) 2000 - 2004 Miro International Pty Ltd
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* Mambo is Free Software
* @subpackage Installer
* @version Safemode Patch 0.9
*/

/** ensure this file is being included by a parent file */
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

/**
* @package Mambo_4.5.1

*/
class HTML_component {
/**
* @param array An array of records
* @param string The URL option
*/
	function showInstalledComponents( $rows, $option ) {
		if (count( $rows )) {
		?>
		<form action="index2.php" method="post" name="adminForm" onSubmit="return getFtpForm(adminForm);">
		<table class="adminheading">
		<tr>
			<th class="install">
			Installed Components
			</th>
		</tr>
		</table>

		<table class="adminlist">
		<tr>
			<th width="20%" class="title">
			Currently Installed
			</th>
			<th width="20%" class="title">
			Component Menu Link
			</th>
			<th width="10%" align="left">
			Author
			</th>
			<th width="5%" align="center">
			Version
			</th>
			<th width="10%" align="center">
			Date
			</th>
			<th width="15%" align="left">
			Author Email
			</th>
			<th width="15%" align="left">
			Author URL
			</th>
		</tr>
		<?php
		$rc = 0;
		for ($i = 0, $n = count( $rows ); $i < $n; $i++) {
		    $row =& $rows[$i];
			?>
			<tr class="<?php echo "row$rc"; ?>">
				<td>
				<input type="radio" id="cb<?php echo $i;?>" name="cid[]" value="<?php echo $row->id; ?>" onclick="isChecked(this.checked);">
				<span class="bold">
				<?php echo $row->name; ?>
				</span>
				</td>
				<td>
				<?php echo @$row->link != "" ? $row->link : "&nbsp;"; ?>
				</td>
				<td>
				<?php echo @$row->author != "" ? $row->author : "&nbsp;"; ?>
				</td>
				<td align="center">
				<?php echo @$row->version != "" ? $row->version : "&nbsp;"; ?>
				</td>
				<td align="center">
				<?php echo @$row->creationdate != "" ? $row->creationdate : "&nbsp;"; ?>
				</td>
				<td>
				<?php echo @$row->authorEmail != "" ? $row->authorEmail : "&nbsp;"; ?>
				</td>
				<td>
				<?php echo @$row->authorUrl != "" ? "<a href=\"" .(substr( $row->authorUrl, 0, 7) == 'http://' ? $row->authorUrl : 'http://'.$row->authorUrl). "\" target=\"_blank\">$row->authorUrl</a>" : "&nbsp;";?>
				</td>
			</tr>
			<?php
	    		$rc = 1 - $rc;
			}
		} else {
			?>
			<td class="small">
			There are no custom components installed
			</td>
			<?php
		}
		?>
		</table>
	
		<input type="hidden" name="task" value="" />
		<input type="hidden" name="boxchecked" value="0" />
		<input type="hidden" name="option" value="com_installer" />
		<input type="hidden" name="element" value="component" />
		<input type="hidden" name="ftpUse" value="0" />
		<input type="hidden" name="ftpUserName" value="" />
		<input type="hidden" name="ftpPassword" value="" />
		<input type="hidden" name="ftpHostName" value="" />
		</form>
		<?php
	}
	
	
}
?>
