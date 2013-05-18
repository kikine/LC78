<?php
//zOOm Media Gallery//
/** 
-----------------------------------------------------------------------
|  zOOm Media Gallery! by Mike de Boer - a multi-gallery component    |
-----------------------------------------------------------------------

-----------------------------------------------------------------------
|                                                                     |
| Author: Mike de Boer, <http://www.mikedeboer.nl>                    |
| Copyright: copyright (C) 2006 by Mike de Boer                       |
| Description: zOOm Media Gallery, a multi-gallery component for      |
|              Joomla!. It's the most feature-rich gallery component  |
|              for Joomla!! For documentation and a detailed list     |
|              of features, check the zOOm homepage:                  |
|              http://www.zoomfactory.org                             |
| License: GPL                                                        |
| Filename: playlist.php                                                  |
|                                                                     |
-----------------------------------------------------------------------
* @version $Id: playlist.php,v 1.2 2006/10/05 20:16:57 mikedeboer Exp $
* @package zOOmGallery
* @author Mike de Boer <mailme@mikedeboer.nl> 
**/
// Turn off Magic quotes runtime, because it interferes with saving info to the 
// database and vice versa.
//error_reporting(0);  
set_magic_quotes_runtime(0); 
error_reporting(0); 
define( "_VALID_MOS", 1 );
include_once('../../../configuration.php');
if (file_exists($mosConfig_absolute_path."/version.php")) {
	include_once($mosConfig_absolute_path."/version.php");
} elseif (file_exists($mosConfig_absolute_path."/includes/version.php")) {
	include_once($mosConfig_absolute_path."/includes/version.php");
}
if (file_exists($mosConfig_absolute_path."/classes/database.php")) {
	include_once($mosConfig_absolute_path."/classes/database.php");
	require_once( $mosConfig_absolute_path . '/classes/gacl.class.php' );
    require_once( $mosConfig_absolute_path . '/classes/gacl_api.class.php' ); 
} elseif (file_exists($mosConfig_absolute_path."/includes/database.php")) {
	include_once($mosConfig_absolute_path."/includes/database.php");
    require_once( $mosConfig_absolute_path . '/includes/gacl.class.php' );
    require_once( $mosConfig_absolute_path . '/includes/gacl_api.class.php' ); 
}

$database = new database($mosConfig_host, $mosConfig_user, $mosConfig_password, $mosConfig_db, $mosConfig_dbprefix);
$acl = new gacl_api();

if (isset($_REQUEST['uid'])) {
	$uid = intval(trim($_REQUEST['uid']));
} else {
	$uid = '0';
}
//$my = new stdClass();

session_start();

$database->setQuery( "SELECT id, gid, username, usertype FROM #__users WHERE id=$uid");
$row = null;
if ($database->loadObject( $row )) {
	// fudge the group stuff
	$grp = $acl->getAroGroup( $row->id );
	$row->gid = 1;

	if ($acl->is_group_child_of( $grp->name, 'Registered', 'ARO' ) ||
	$acl->is_group_child_of( $grp->name, 'Public Backend', 'ARO' )) {
		// fudge Authors, Editors, Publishers and Super Administrators into the Special Group
		$row->gid = 2;
	}
	$row->usertype = $grp->name;
	
	$my->id = intval( $row->id );
    $my->username = $row->username;
    $my->usertype = $row->usertype;
    $my->gid = intval( $row->gid );
}

// Create zOOm Image Gallery object
require_once($mosConfig_absolute_path.'/components/com_zoom/lib/zoom.class.php');
require_once($mosConfig_absolute_path.'/components/com_zoom/lib/toolbox.class.php');
require_once($mosConfig_absolute_path.'/components/com_zoom/lib/ftplib.class.php');
//require_once($mosConfig_absolute_path.'/components/com_zoom/lib/pdf.class.php'); // Caused headers to stop being sent
require_once($mosConfig_absolute_path.'/components/com_zoom/lib/editmon.class.php'); //like a common session-monitor...
require_once($mosConfig_absolute_path.'/components/com_zoom/lib/gallery.class.php');
require_once($mosConfig_absolute_path.'/components/com_zoom/lib/image.class.php');
require_once($mosConfig_absolute_path.'/components/com_zoom/lib/comment.class.php');
require_once($mosConfig_absolute_path.'/components/com_zoom/lib/ecard.class.php');
require_once($mosConfig_absolute_path.'/components/com_zoom/lib/lightbox.class.php');
require_once($mosConfig_absolute_path.'/components/com_zoom/lib/privileges.class.php');
require_once($mosConfig_absolute_path.'/components/com_zoom/lib/iptc/Unicode.php');
// Load configuration file...
require($mosConfig_absolute_path.'/components/com_zoom/etc/zoom_config.php');

$zoom = new zoom();
// now create an instance of the ToolBox!
$zoom->toolbox = new toolbox(false);
// Start session for the LightBox...
if ($zoom->_CONFIG['lightbox']) {
    @ini_set('session.save_handler', 'files'); 
    session_name('zoom');
	if(session_id()) {
		@session_destroy();
	}
	@ini_set('session.save_handler', 'files');
	session_start();
    if (!isset($_SESSION['lightbox'])) {
        $_SESSION['lightbox'] = new lightbox();
        // for test purposes:
        $_SESSION['lb_checked_out'] = false;
    }
}

// list of common inclusions:
if (file_exists($mosConfig_absolute_path."/components/com_zoom/lib/language/".$mosConfig_lang.".php")) { 
    include_once($mosConfig_absolute_path."/components/com_zoom/lib/language/".$mosConfig_lang.".php");
} else { 
    include_once($mosConfig_absolute_path."/components/com_zoom/lib/language/english.php");
}
if ($zoom->isWin()) {
    require_once($mosConfig_absolute_path.'/components/com_zoom/lib/WinNtPlatform.class.php');
    $zoom->platform = new WinNtPlatform();
} else {
    require_once($mosConfig_absolute_path.'/components/com_zoom/lib/UnixPlatform.class.php');
    $zoom->platform = new UnixPlatform();
}

// Update the Edit Monitor, eg. delete unnecessary rows
$zoom->EditMon->updateEditMon();




echo header("Content-type:text/xml; charset="._ZOOM_ISO);
echo header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
echo header("Cache-Control: no-store, no-cache, must-revalidate");
echo header("Cache-Control: post-check=0, pre-check=0", false);
//header("charset:"._ZOOM_ISO);
echo header("Pragma: no-cache");

$keys      = $zoom->getParam($_REQUEST, 'keys');
$playlist  = ''; 

$pieces = explode(",", $keys); 
$total = count($pieces);
       for($x = 0; $x < $total; $x += 2){ 
			$zoom->setGallery($pieces[$x]);
			$playlist .= '<track>';
			$zoom->_gallery->_images[$pieces[$x+1]]->getInfo();
			$img_path = $mosConfig_live_site."/".$zoom->_CONFIG['imagepath'].$zoom->_gallery->_dir."/".$zoom->_gallery->_images[$pieces[$x+1]]->_viewsize;
			$id3_data = $zoom->_gallery->_images[$pieces[$x+1]]->_metadata;
			$artist = (!empty($id3_data["comments_html"]["artist"][0])) ? $id3_data["comments_html"]["artist"][0] : "no artist";
			$title = (!empty($id3_data["comments_html"]["title"][0])) ? $id3_data["comments_html"]["title"][0] : "no title";
			$playlist .= '<annotation>'.(!($artist == "no artist" && $title == "no title") ? $artist.' - '.$title : $zoom->_gallery->_images[$pieces[$x+1]]->_name).'</annotation>';
			$playlist .= '<location>'.$img_path.'</location>';
			$playlist .= '</track>';
       }
?>
<playlist version="1" xmlns="http://xspf.org/ns/0/">
	<trackList>
		<?php echo $playlist ?>
	</trackList>
</playlist>