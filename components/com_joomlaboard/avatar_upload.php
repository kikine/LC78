<?php
/**
* avatar_upload.php manages avatar settings
* @package com_joomlaboard
* @copyright (C) 2000 - 2007 TSMF / Jan de Graaff / All Rights Reserved
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* @author TSMF & Derrick Sobodash
* Joomla! is Free Software
**/
//----------------------------------------------------------------------------
// Modified by Derrick Sobodash 2004
//----------------------------------------------------------------------------
// My modification adds support for multiple avatar galleries using a
// drop-down list. Selecting a gallery in the drop-down list changes the
// images available to the user.
//
// Default Gallery is your normal Joomlaboard /gallery/ folder. Any images
// directly in that path will be displayed in the Default Galllery. To add
// galleries, just create sub-directories. Whatever the subdirectory is
// called will be the name of the gallery.
//----------------------------------------------------------------------------

// Dont allow direct linking
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

global $my;
$do='';
$do= mosGetParam( $_REQUEST, 'do', 'init' );
$gallery= mosGetParam($_REQUEST,'gallery','default');
$gallery1='';
$gallery2='';
if ($do=='init'){
   if($sbConfig['allowAvatarUpload']){
         echo "<span class='contentheading'>"._UPLOAD_SUBMIT."</span><br /><br />";
         echo _UPLOAD_DIMENSIONS.": ".$sbConfig['avatarWidth']."x".$sbConfig['avatarHeight']." - ".$sbConfig['avatarSize']." KB";
         echo '<form action="'.sefRelToAbs(JB_LIVEURL.'&amp;func=upload&amp;do=validate').'" method="post" name="adminForm" enctype="multipart/form-data">';
         echo "<input type='hidden' value='do' text='validate'>";
         echo "<table width='100%' border='0' cellpadding='4' cellspacing='2'>";
         echo "<tr align='center' valign='middle'><td align='center' valign='top'>";

          $uplabel=_UPLOAD_UPLOAD;
          //echo " <input type='hidden' name='MAX_FILE_SIZE' value='".$maxAllowed."' />";
          echo _UPLOAD_SELECT_FILE." <input type='file' class='button' name='avatar' />";
          echo "<input type='submit' class='button' value='"._UPLOAD_UPLOAD."' />";
          echo "</td></tr></table><br />";
          echo "</form>";
     }

     if($sbConfig['allowAvatarGallery']){
          echo "<span class='contentheading'>"._UPLOAD_GALLERY."</span><p />\n";
?><script type="text/javascript">
<!--
function switch_avatar_category(gallery)
{
   if (gallery == "")
      return;
   location.href = "<?php echo sefRelToAbs(JB_LIVEURL.'&func=upload&gallery='); ?>" + gallery ;
}
//-->
</script>
<?php          
          echo "<center>";
          get_dirs(JB_ABSPATH.'/avatars/gallery', "categoryid", $gallery);
//          echo "<input type=\"button\" value=\"Go\" class=\"button\" onclick=\"switch_avatar_category(this.options[this.selectedIndex].value)\" />\n";
          echo "</center>";
          echo "<br />\n";
          echo "<table width='100%' border='0' cellpadding='4' cellspacing='2'>";
          echo '<form action="'.sefRelToAbs(JB_LIVEURL.'&amp;func=upload&amp;do=fromgallery').'" method="post" name="adminForm">';
          echo "<tr align='center' valign='middle'>";
          if($gallery=="default") unset($gallery);
          if(isset($gallery)) {
             $gallery1="/".str_replace("%20", " ", $gallery);
             $gallery2=str_replace("%20", " ", $gallery) . "/";
          }
          $avatar_gallery_path=JB_ABSPATH.'/avatars/gallery'.$gallery1;
          $avatar_images=array();
          $avatar_images=display_avatar_gallery($avatar_gallery_path);
          for($i = 0; $i < count($avatar_images); $i++) {
             $j=$i+1;
             echo '<td>';
             //echo '<img src="'.$avatar_gallery_path .'/'. $avatar_images[$i].'">';
             echo '<img src="'.JB_DIRECTURL .'/avatars/gallery/'.$gallery2. $avatar_images[$i].'">';
             echo '<input type="radio" name="newAvatar" value="gallery/'.$gallery2.$avatar_images[$i].'">';
             echo "</td>\n";
               if (function_exists('fmod')) {
                   if (!fmod(($j),5)){echo '</tr><tr align="center" valign="middle">';}
               } else {
                   if (!fmodReplace(($j),5)){echo '</tr><tr align="center" valign="middle">';}
               }

          }
          echo '</tr>';
          echo '<tr><td colspan="5" align="center"><input type="submit" value="'._UPLOAD_CHOOSE.'">';
          echo '</table>';
          echo "</form>";
       }

}else if ($do=='validate'){
   $Itemid = mosGetParam( $_REQUEST, 'Itemid' );
   //numExtensions= people tend to upload malicious files using mutliple extensions like: virus.txt.vbs; we'll want to have the last extension to validate against..
   $filename= split("\.", $_FILES['avatar']['name']);
   $numExtensions=(count($filename))-1;
   $avatarName=$filename[0];
   $avatarExt=$filename[$numExtensions];

   $newFileName=$my->id.".".$avatarExt;

   //move it to the proper location
   if (! move_uploaded_file($_FILES['avatar']['tmp_name'], JB_ABSPATH."/avatars/$newFileName") )
      echo _UPLOAD_ERROR_GENERAL;
   @chmod (JB_ABSPATH."/avatars/$newFileName", 0777);

   //Filename + proper path
   $fileLocation=JB_ABSPATH."/avatars/$newFileName";
   //Avatar Size
   $avatarSize=$_FILES['avatar']['size'];

   //check for empty file
   if (empty($_FILES['avatar']['name'])) {
    unlink($fileLocation);
    MOSredirect(JB_LIVEURL.'&func=upload',_UPLOAD_ERROR_EMPTY);
   }

   //check for allowed file type (jpeg, gif, png)
   if (!($imgtype = check_image_type($avatarExt))){
      unlink($fileLocation);
      MOSredirect(JB_LIVEURL.'&func=upload',_UPLOAD_ERROR_TYPE);
   }
   //check file name characteristics
   if (eregi("[^0-9a-zA-Z_]", $avatarExt)) {
     unlink($fileLocation);
     MOSredirect(JB_LIVEURL.'&func=upload',_UPLOAD_ERROR_NAME);
   }
   //check filesize
   $maxAvSize=$sbConfig['avatarSize']*1024;
   if ($avatarSize > $maxAvSize) {
     unlink($fileLocation);
     MOSredirect(JB_LIVEURL.'&func=upload',_UPLOAD_ERROR_SIZE." (".$sbConfig['avatarSize']." KiloBytes)");
    return;
   }

   list($width, $height) = @getimagesize($fileLocation);

   if ( $width > $sbConfig['avatarWidth']){
      unlink($fileLocation);
      MOSredirect(JB_LIVEURL.'&func=upload',_UPLOAD_ERROR_WIDTH." (".$sbConfig['avatarWidth']." pixels)");
   }

   if ( $height > $sbConfig['avatarHeight']){
      unlink($fileLocation);
      MOSredirect(JB_LIVEURL.'&func=upload',_UPLOAD_ERROR_HEIGHT." (".$sbConfig['avatarHeight']." pixels)");
   }

   $database->setQuery("UPDATE #__sb_users SET avatar='$newFileName' WHERE userid='$my->id'");
   $database->query();

   echo " <strong>"._UPLOAD_UPLOADED."</strong>...<br /><br />";
   echo '<a href="'.sefRelToAbs(JB_LIVEURL.'&amp;func=userprofile&amp;do=show').'">'._GEN_CONTINUE.".</a>";
}else if ($do=='fromgallery'){
   require_once(JB_ABSPATH.'/sb_helpers.php');
   $newAvatar=mosGetParam($_POST,'newAvatar','');
   if($newAvatar==''){
      MOSredirect(JB_LIVEURL.'&func=upload',_UPLOAD_ERROR_CHOOSE);
   }
   $database->setQuery("UPDATE #__sb_users SET avatar='$newAvatar' WHERE userid='$my->id'");

   if(!$database->query()) {
      echo _USER_PROFILE_NOT_A." <strong><font color=\"red\">"._USER_PROFILE_NOT_B."</font></strong> "._USER_PROFILE_NOT_C.".<br /><br />";
   }else {
      echo _USER_PROFILE_UPDATED."<br /><br />";
   }
   echo _USER_RETURN_A.' <a href="'.sefRelToAbs(JB_LIVEURL.'&amp;func=userprofile&amp;do=show').'">'._USER_RETURN_B.'</a><br /><br />';
   sbSetTimeout(JB_LIVEURL.'&func=userprofile&do=show',3500);
}

function check_filesize($file,$maxSize) {

   $size = filesize($file);

   if($size <= $maxSize) {
      return true;
   }
   return false;
}

function display_avatar_gallery($avatar_gallery_path)
{
   $dir = @opendir($avatar_gallery_path);
   $avatar_images = array();
   $avatar_col_count = 0;
   while( $file = @readdir($dir) )
   {

      if( $file != '.' && $file != '..' && is_file($avatar_gallery_path . '/' . $file) && !is_link($avatar_gallery_path. '/' . $file) )
      {
            if( preg_match('/(\.gif$|\.png$|\.jpg|\.jpeg)$/is', $file) )
            {
               $avatar_images[$avatar_col_count] = $file;
               $avatar_name[$avatar_col_count] = ucfirst(str_replace("_", " ", preg_replace('/^(.*)\..*$/', '\1', $file)));
               $avatar_col_count++;
            }
       }
   }

   @closedir($dir);

   @ksort($avatar_images);
   @reset($avatar_images);

   return $avatar_images;
}

//function fmodReplace($x,$y)
//{ //function provided for older PHP versions which do not have an fmod function yet
//   $i = floor($x/$y);
   // r = x - i * y
//   return $x - $i*$y;}

// This function was modified from the one posted to PHP.net by rockinmusicgv
// It is available under the readdir() entry in the PHP online manual
function get_dirs($directory, $select_name, $selected = "") {
   if ($dir = @opendir($directory)) {
       while (($file = readdir($dir)) !== false) {
            if ($file != ".." && $file != ".") {
               if(is_dir($directory."/".$file)) {
                   if(!($file[0] == '.')) {
                       $filelist[] = $file;
                   }
               }
           }
       }
       closedir($dir);
   }
   if($selected) $selected = str_replace("%20", " ", $selected);
   echo "<select name=\"$select_name\" id=\"avatar_category_select\" OnChange=\"switch_avatar_category(this.options[this.selectedIndex].value)\">\n";
   echo "<option value=\"default\"";
   if ($selected == "") {
       echo " selected";
   }
   echo ">Default Gallery</option>\n";
   
   asort($filelist);
   while (list ($key, $val) = each ($filelist)) {
       echo "<option value=\"$val\"";
       if ($selected == $val) {
           echo " selected";
       }
       echo ">$val Gallery</option>\n";
   }
   echo "</select>\n";
}

?>