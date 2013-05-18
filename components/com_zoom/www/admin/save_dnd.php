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
| Filename: save_dnd.php                                              |
|                                                                     |
-----------------------------------------------------------------------
* @version $Id: save_dnd.php,v 1.20 2006/11/26 05:41:18 kevinuru Exp $
* @package zOOmGallery
* @author Mike de Boer <mailme@mikedeboer.nl> 
**/
define( "_VALID_MOS", 1 );
echo "Processing images from list...<br /><br />";	
    // $mosConfig_absolute_path = $_REQUEST['dnd_mospath'];
	/*
	* Iterate over all received files.
	* PHP > 4.2 / 4.3 ? will save the file information into the
	* array $_FILES[]. Before these versions, the data was saved into
	* $HTTP_POST_FILES[]
	*/
	// reset script execution time limit (as set in MAX_EXECUTION_TIME ini directive)...
    // requires SAFE MODE to be OFF!
    if (ini_get('safe_mode') != 1 ) {
        set_time_limit(0);
    }
	include_once('../../../../configuration.php');
	if (file_exists($mosConfig_absolute_path."/version.php")) {
		include_once($mosConfig_absolute_path."/version.php");
	} else {
		include_once($mosConfig_absolute_path."/includes/version.php");
	}
	if (eregi("4\.5[ \t]", $version)) {
		$cmstype = 1;
	} else {
		$cmstype = 2;
	}
	// redefine the mambo database object to use the comment function...
	if($cmstype == 2) {
		require_once($mosConfig_absolute_path.'/includes/database.php');
	} else {
		require_once($mosConfig_absolute_path.'/classes/database.php');
	}
	$database = new database( $mosConfig_host, $mosConfig_user, $mosConfig_password, $mosConfig_db, $mosConfig_dbprefix );
	// Include zOOm configuration
	include_once($mosConfig_absolute_path.'/components/com_zoom/etc/zoom_config.php');
	// Create zOOm Image Gallery object
	require_once($mosConfig_absolute_path.'/components/com_zoom/lib/zoom.class.php');
	require_once($mosConfig_absolute_path.'/components/com_zoom/lib/editmon.class.php'); //like a common session-monitor...
	require_once($mosConfig_absolute_path.'/components/com_zoom/lib/gallery.class.php');
	require_once($mosConfig_absolute_path.'/components/com_zoom/lib/image.class.php');
	require_once($mosConfig_absolute_path.'/components/com_zoom/lib/toolbox.class.php');
	require_once($mosConfig_absolute_path.'/components/com_zoom/lib/privileges.class.php');
	require_once($mosConfig_absolute_path.'/components/com_zoom/lib/mime/mime.class.php');
	$zoom = new zoom();
	
	// now create an instance of the ToolBox!
	$zoom->toolbox = new toolbox(false);

	$catid = intval($zoom->getParam($_REQUEST, 'catid'));
	if (empty($catid)) {
		echo "No gallery specified, please select one from the list.";
		exit();
	}
	$uid = intval($zoom->getParam($_REQUEST, 'dnd_uid'));
	$name = $zoom->getParam($_REQUEST, 'dnd_name');
	$setFilename = (bool)$zoom->getParam($_REQUEST, 'dnd_setFilename');
	$keywords = $zoom->getParam($_REQUEST, 'dnd_keywords');
	$descr = $zoom->getParam($_REQUEST, 'dnd_descr');
    $descr = str_replace("'", "&#39;", $descr);
	$zoom->setGallery($catid, true);
	$zoom->_isAdmin = true; //set this manually, so language file can be read completely...
	$zoom->_CurrUID = $uid;
	
	// inclusion of filesystem-functions, platform dependent.
	if ($zoom->isWin()) {
		require_once($mosConfig_absolute_path.'/components/com_zoom/lib/WinNtPlatform.class.php');
		$zoom->platform = new WinNtPlatform();
	} else {
		require_once($mosConfig_absolute_path.'/components/com_zoom/lib/UnixPlatform.class.php');
		$zoom->platform = new UnixPlatform();
	}
	
	if (file_exists($mosConfig_absolute_path."/components/com_zoom/lib/language/".$mosConfig_lang.".php") ) { 
		include_once($mosConfig_absolute_path."/components/com_zoom/lib/language/".$mosConfig_lang.".php");
	} else { 
		include_once($mosConfig_absolute_path."/components/com_zoom/lib/language/english.php");
	}
	if ($zoom->_CONFIG['readEXIF'] && !(bool)ini_get('safe_mode')) {
		include_once($mosConfig_absolute_path."/components/com_zoom/lib/iptc/JPEG.php");
		include_once($mosConfig_absolute_path."/components/com_zoom/lib/iptc/EXIF.php");
		include_once($mosConfig_absolute_path."/components/com_zoom/lib/iptc/Photoshop_IRB.php");
		include_once($mosConfig_absolute_path."/components/com_zoom/lib/iptc/XMP.php");
		include_once($mosConfig_absolute_path."/components/com_zoom/lib/iptc/Photoshop_File_Info.php");
	}
	// counter:
 	$i = 0;
 		
	foreach ($_FILES as $key => $value) {
 		// get the temporary name (e.g. /tmp/php34634.tmp)
 		$tempName = $value['tmp_name'];
 		$filetype = $value['type'];
	 	// get the real filename
 		$realName = urldecode($value['name']);
 		if(isset($setFilename)) {
 			$name = $realName;
 		}
 		if ($zoom->_CONFIG['autonumber']) {
			$name .= " ".($i + 1);
 		}
 		if ($realName != "") {
 			echo _ZOOM_INFO_PROCESSING." ".$realName."...";
	 		//Check for right format
			if ($zoom->toolbox->processImage($tempName, $realName, $filetype, $keywords, $name, $descr, false)) {
			    echo "<b>"._ZOOM_INFO_DONE."</b><br />";
			    $i++;
			} else {
			    echo "<b>error!</b><br />";
			}
		}
	} // end of for-loop FILES
	if($zoom->toolbox->_err_num > 0) {
	       $zoom->toolbox->displayErrors();
	}
	echo "<b>".$i." "._ZOOM_ALERT_UPLOADSOK."</b><br />";
?>