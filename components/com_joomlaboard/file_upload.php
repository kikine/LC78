<?php
/**
* file_upload.php manages file uploads
* @package com_joomlaboard
* @copyright (C) 2000 - 2007 TSMF / Jan de Graaff / All Rights Reserved
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* @author TSMF
* Joomla! is Free Software
**/
// Dont allow direct linking
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

/**
 * @package com_joomlaboard
 * @version $Revision: 1.17 $ by $Author: progster $ ($Date: 2005/11/14 20:48:49 $) 
 * @author jdg
 */
require_once(JB_ABSPATH.'/sb_helpers.php');

function fileUploadError($msg) {
  global $fileLocation, $message, $rc;
  $rc = 0;
  $message = str_replace("[file]","",$message);
  sbAlert("$msg\n" ._FILE_NOT_UPLOADED);
}


$rc = 1; //reset return code

$filename= split("\.", $_FILES['attachfile']['name']);

//some transaltions for readability

//numExtensions= people tend to upload malicious files using mutliple extensions like: virus.txt.vbs; we'll want to have the last extension to validate against..
$numExtensions=(count($filename))-1;

//Translate all invalid characters
$fileName=preg_replace("/[^0-9a-zA-Z_]/","_",$filename[0]);

// get the final extension
$fileExt=$filename[$numExtensions];

// create the new filename
$newFileName=$fileName.'.'.$fileExt;

// Get the Filesize
$fileSize=$_FILES['attachfile']['size'];   

//Enforce it is a new file
if (file_exists(JB_ABSPATH."/uploaded/files/$newFileName") ) {
   $newFileName = $fileName.'-'.md5(microtime()) . "." . $fileExt;
}



if ($rc){
   //Filename + proper path
   $fileLocation=JB_ABSPATH."/uploaded/files/$newFileName";

   // Check for empty filename
   if (empty($_FILES['attachfile']['name'])) {
     fileUploadError(_FILE_ERROR_EMPTY);
   }

	// check for allowed file types
	$allowedArray= explode (',',strtolower($sbConfig['fileTypes']));
	if( ! in_array($fileExt,$allowedArray ) ) {
		fileUploadError(_FILE_ERROR_TYPE . " " . $sbConfig['fileTypes']);
	}
   
   // Check filesize
   $maxImgSize=$sbConfig['fileSize']*1024;
   if ($fileSize > $maxImgSize) {
      fileUploadError(_FILE_ERROR_SIZE . " (" . $sbConfig['fileSize'] . "kb)");
   }
}
if ($rc) {
   // file is OK, move it to the proper location
   move_uploaded_file($_FILES['attachfile']['tmp_name'], $fileLocation);
   @chmod ($fileLocation, 0777);

}

// Insert file code into message
if ($rc) {
  $code='[file name='.$newFileName.' size='.$fileSize.']'.JB_DIRECTURL.'/uploaded/files/'.$newFileName.'[/file]';

  if ( preg_match("/\[file\]/si", $message) ) {
    $message = str_replace("[file]",$code,$message);
  } else {
     $message=$message.' '.$code;
  }
}



?>
