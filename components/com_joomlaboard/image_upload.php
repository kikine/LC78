<?php
/**
* image_upload.php manages image uploads
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
 * @version $Revision: 1.18 $ by $Author: progster $ ($Date: 2005/11/15 18:28:07 $) 
 * @author jdg
 */
require_once(JB_ABSPATH.'/sb_helpers.php');

function imageUploadError($msg) {
  global $imageLocation, $message, $rc;
  $rc = 0;
  $message = str_replace("[img]","",$message);
  
  sbAlert("$msg\n" ._IMAGE_NOT_UPLOADED);
}

$rc = 1; //reset return code

$filename= split("\.", $_FILES['attachimage']['name']);

//some transaltions for readability

//numExtensions= people tend to upload malicious files using mutliple extensions like: virus.txt.vbs; we'll want to have the last extension to validate against..
$numExtensions=(count($filename))-1;

//Translate all invalid characters
$imageName=preg_replace("/[^0-9a-zA-Z_]/","_",$filename[0]);

// get the final extension
$imageExt=$filename[$numExtensions];

// create the new filename
$newFileName=$imageName.'.'.$imageExt;

// Get the Filesize
$imageSize=$_FILES['attachimage']['size'];   

//Enforce it is a new file
if (file_exists(JB_ABSPATH."/uploaded/images/$newFileName") ) {
   $newFileName = $imageName.'-'.md5(microtime()) . "." . $imageExt;
}

if ($rc){
   //Filename + proper path
   $imageLocation=JB_ABSPATH."/uploaded/images/$newFileName";

   // Check for empty filename
   if (empty($_FILES['attachimage']['name'])) {
     imageUploadError(_IMAGE_ERROR_EMPTY);
   }

   	// Check for allowed file type (jpeg, gif, png)
   if (!($imgtype = check_image_type($imageExt))){
      imageUploadError(_IMAGE_ERROR_TYPE);
   }
   
   // Check filesize
   $maxImgSize=$sbConfig['imageSize']*1024;
   if ($imageSize > $maxImgSize) {
      imageUploadError(_IMAGE_ERROR_SIZE . " (" . $sbConfig['imageSize'] . "kb)");
   }

   list($width, $height) = @getimagesize($_FILES['attachimage']['tmp_name']);

	// Check image width
   if ( $width > $sbConfig['imageWidth']){
      imageUploadError(_IMAGE_ERROR_WIDTH . " (" . $sbConfig['imageWidth'] . " pixels");
   }

	// Check image height
	if ( $height > $sbConfig['imageHeight']){
      imageUploadError(_IMAGE_ERROR_HEIGHT . " (" . $sbConfig['imageHeight'] . " pixels");
   }
}
if ($rc) {
   // file is OK, move it to the proper location
   move_uploaded_file($_FILES['attachimage']['tmp_name'], $imageLocation);
   @chmod ($imageLocation, 0777);

}

if ($rc) {
   // echo '<span class="contentheading">'._IMAGE_UPLOADED."...</span>";
   if ($width<'100') {
      $code='[img]'.JB_DIRECTURL.'/uploaded/images/'.$newFileName.'[/img]';
   }else{
      $code='[img size='.$width.']'.JB_DIRECTURL.'/uploaded/images/'.$newFileName.'[/img]';
   }
   if ( preg_match("/\[img\]/si", $message) ) {
      $message=str_replace("[img]",$code,$message);
   } else {
      $message=$message.' '.$code;
   }
}
?>