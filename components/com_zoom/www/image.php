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
| Filename: image.php                                                  |
|                                                                     |
-----------------------------------------------------------------------
* @version $Id: image.php,v 1.5 2006/11/27 00:58:06 kevinuru Exp $
* @package zOOmGallery
* @author Mike de Boer <mailme@mikedeboer.nl> 
**/
define( "_VALID_MOS", 1 );

require_once( "../../../globals.php" );
include_once("../../../configuration.php");
$ref = $_SERVER['HTTP_REFERER'];
if (strpos($ref,$mosConfig_live_site) === 0 || strpos($ref, 'http') !== 0) {
    
    if (file_exists($mosConfig_absolute_path."/includes/joomla.php")) {
        require_once($mosConfig_absolute_path."/includes/joomla.php");
    } elseif (file_exists($mosConfig_absolute_path."/includes/mambo.php")) {
        require_once($mosConfig_absolute_path."/includes/mambo.php");
    }
    if (file_exists($mosConfig_absolute_path."/version.php")) {
        include_once($mosConfig_absolute_path."/version.php");
    } elseif (file_exists($mosConfig_absolute_path."/includes/version.php")) {
        include_once($mosConfig_absolute_path."/includes/version.php");
    }
    if (file_exists($mosConfig_absolute_path."/classes/database.php")) {
        include_once($mosConfig_absolute_path."/classes/database.php");
        require_once( $mosConfig_absolute_path . "/classes/gacl.class.php" );
        require_once( $mosConfig_absolute_path . "/classes/gacl_api.class.php" ); 
    } elseif (file_exists($mosConfig_absolute_path."/includes/database.php")) {
        include_once($mosConfig_absolute_path."/includes/database.php");
        require_once( $mosConfig_absolute_path . "/includes/gacl.class.php" );
        require_once( $mosConfig_absolute_path . "/includes/gacl_api.class.php" ); 
    }
    $mainframe = new mosMainFrame( $database, 'com_zoom', '..', true );
    
    error_reporting(0);  
    set_magic_quotes_runtime(0); 
    
	// Create zOOm Image Gallery object
    require_once($mosConfig_absolute_path."/components/com_zoom/lib/zoom.class.php");
    require_once($mosConfig_absolute_path."/components/com_zoom/lib/toolbox.class.php");
    require_once($mosConfig_absolute_path."/components/com_zoom/lib/ftplib.class.php");
    require_once($mosConfig_absolute_path."/components/com_zoom/lib/editmon.class.php"); //like a common session-monitor...
    require_once($mosConfig_absolute_path."/components/com_zoom/lib/gallery.class.php");
    require_once($mosConfig_absolute_path."/components/com_zoom/lib/image.class.php");
    require_once($mosConfig_absolute_path."/components/com_zoom/lib/comment.class.php");
    require_once($mosConfig_absolute_path."/components/com_zoom/lib/ecard.class.php");
    require_once($mosConfig_absolute_path."/components/com_zoom/lib/lightbox.class.php");
    require_once($mosConfig_absolute_path."/components/com_zoom/lib/privileges.class.php");
    require_once($mosConfig_absolute_path."/components/com_zoom/lib/iptc/Unicode.php");
    // Load configuration file...
    require($mosConfig_absolute_path."/components/com_zoom/etc/zoom_config.php");
    
    $zoom = new zoom();
    
    // get variables from HTTP request...
    $q = $zoom->decrypt($zoom->getParam($_REQUEST, 'q'));
    // Use &amp; for correct processing
    $params = split("&amp;", $q);
    foreach ($params as $param) {
        $var = split("=", $param);
        if (count($var) === 2) {
            $_REQUEST[$var[0]] = $var[1];
        }
    }
    
    
    $uid = $zoom->getParam($_REQUEST, 'uid');
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
    
    if ($zoom->isWin()) {
        require_once($mosConfig_absolute_path."/components/com_zoom/lib/WinNtPlatform.class.php");
        $zoom->platform = new WinNtPlatform();
    } else {
        require_once($mosConfig_absolute_path."/components/com_zoom/lib/UnixPlatform.class.php");
        $zoom->platform = new UnixPlatform();
    }
    
    //Get all the stuff for the picture
    $key   = intval($zoom->getParam($_REQUEST, 'key'));
    $catid = intval($zoom->getParam($_REQUEST, 'catid'));
    $type  = intval($zoom->getParam($_REQUEST, 'type'));
    $zoom->setGallery($catid);
    $zoom->_gallery->_images[$key]->getInfo();
    
    //Lets show some pictures!
    $img_type = $zoom->_gallery->_images[$key]->_type;
    if ($type == 0) { //Viewsize
        $img = $mosConfig_live_site."/".$zoom->_CONFIG['imagepath'].$zoom->_gallery->_dir."/".$zoom->_gallery->_images[$key]->_viewsize;
    } elseif ($type == 1) { //Fullsize
        $img = $mosConfig_live_site."/".$zoom->_CONFIG['imagepath'].$zoom->_gallery->_dir."/".$zoom->_gallery->_images[$key]->_filename;
    } elseif ($type == 2) { //Thumbnail
        $img = $zoom->_gallery->_images[$key]->_thumbnail;
        $img_type = $zoom->_gallery->_images[$key]->_thumbtype;
    }
    $img = str_replace(' ','%20',$img); 
	header("Content-Type: image/".$img_type."");
    @readfile($img);
} else {
    header("Content-Type: image/png"); 
    $img = $mosConfig_live_site."/components/com_zoom/www/images/hotlink.png";
    @readfile($img);
}
?>