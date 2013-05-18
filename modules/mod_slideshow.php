<?php
/**
* Flash slideshow Module for Mambo
* Version: 0.2.3
* Author: Bpixel
* URL:  http://www.ubi.fr
* mail: bsamson@ubi.fr
* FileName: mod_flashslideshow.php
* Date: 28/09/2005
* MOS Version #: 4.5.1a, 4.5.2 ... and more
* License: Copyright © UBI, 2005, All Rights Reserved
**/

/** ensure this file is being included by a parent file */
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );


$moduleclass_sfx = $params->get( 'moduleclass_sfx' );
$flashpath = './';
$sshowId = $params->get( 'id');

global $database, $mosConfig_live_site;

$row = null;
	
$database->setQuery( "SELECT * FROM #__slideshow WHERE id=".$sshowId );
$database->loadObject($row );


if ($row){		

	
	// standard parameters
	$imagepath  = '../../images/stories'.$row->imagepath.'/';
	$image  = $row->image;
	$stretchMethode =  $row->stretchMethode;
	
	// size
	$width=$row->width;
	$height=$row->height;
	$background = $row->background;
	
	// default text 
	$defaultText =  $row->defaultText;
	$defaultText = urlencode(utf8_encode(str_replace(CHR(13).CHR(10), '<br>', $defaultText)));
	
	// template
	$template=$row->template;

	$showcontrols = $row->showcontrols;
	
	// play methode and transitions
	$random =  $row->random;
	$autoplay  = $row->autoplay;
	$delay  = $row->delay;		
	$transduration = $row->transduration;
	$transitions = $row->transitions;
	
	
	
} else {
	
	// standard parameters
	$imagepath  = '../../'.$params->get( 'imagepath');
	$autoplay  = $params->get( 'autoplay');
	$delay  = $params->get( 'delay');
	$image  = $params->get( 'image');
	
	$stretchMethode =  $params->get( 'stretchMethode');
	$random =  $params->get( 'random');
	$defaultText =  $params->get( 'defaultText');
	$showcontrols = $params->get( 'showcontrols');
	
	$transitions = '';
	$transitions .= $params->get( 'Blinds') 		== '0' ? '' : '0,';
	$transitions .= $params->get( 'Fade') 			== '0' ? '' : '1,';
	$transitions .= $params->get( 'Fly') 			== '0' ? '' : '2,';
	$transitions .= $params->get( 'Iris') 			== '0' ? '' : '3,';
	$transitions .= $params->get( 'Photo') 		== '0' ? '' : '4,';
	$transitions .= $params->get( 'PixelDissolve') == '0' ? '' : '5,';
	$transitions .= $params->get( 'Rotate') 		== '0' ? '' : '6,';
	$transitions .= $params->get( 'Squeeze') 		== '0' ? '' : '7,';
	$transitions .= $params->get( 'Wipe') 			== '0' ? '' : '8,';
	$transitions .= $params->get( 'Zoom') 			== '0' ? '' : '9';
	
	$transduration = $params->get( 'transduration');
	
	$defaultText = '&desc='.urlencode(utf8_encode(str_replace(CHR(13).CHR(10), '<br>', $defaultText)));
	
	// size
	$width=$params->get( 'width');
	$height=$params->get( 'height');
	$background = $params->get( 'background');
	$template=$params->get( 'template');
}


$wmode = 'opaque';

if ($background == 'transparent' || $background == 'none'){
	$wmode = 'transparent';	
	$bg = '#ffffff';
} else {
	$bg = '#'.substr($background,2);
}

// flash variables ...
$flashvars = 'getimagepath=' . $imagepath; 
$flashvars .= '&getflashpath=' . $flashpath;
$flashvars .= '&getautoplay=' . $autoplay;
$flashvars .= '&gettemplate=' . $template;
$flashvars .= '&getdelay=' . $delay;
$flashvars .= '&getimage=' . $image;
$flashvars .= '&getStretchMethode=' . $stretchMethode;
$flashvars .= '&getRandom=' . $random;
$flashvars .= '&getDefaultText=' . $defaultText;
$flashvars .= '&getShowcontrols=' . $showcontrols;
$flashvars .= '&gettransitions=' . $transitions;
$flashvars .= '&gettransduration=' . $transduration;
$flashvars .= '&getbackground=' . $background;

// in case using multilingual template, use _level0.lang to get the current language in flash
if ( isset($mosConfig_lang) ){
	$flashvars .= '&lang=' . $mosConfig_lang;	
}

?>
<center>
<div style="width:<? echo $width ?>px;height:<? echo $height ?>px;" class="slideshow">
	<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,0,0" width="<? echo $width ?>" height="<? echo $height ?>" id="mod_slideshow" align="middle">
		<param name="allowScriptAccess" value="sameDomain" />
		<param name="movie" value="./modules/mod_slideshow/mod_slideshow.swf" />
		<param name="quality" value="high" />
		<param name="base" value="./modules/mod_slideshow/" />
		<param name="bgcolor" value="<? echo $bg; ?>" />
		<param name="wmode" value="<? echo $wmode; ?>" />
		<param name="flashVars" value="<? echo $flashvars; ?>" />
		<embed src="./modules/mod_slideshow/mod_slideshow.swf" quality="high" base="./modules/mod_slideshow/" wmode="<? echo $wmode; ?>" flashVars="<? echo $flashvars; ?>" bgcolor="<? echo $bg; ?>" width="<? echo $width ?>" height="<? echo $height ?>" name="mod_slideshow" align="middle" allowScriptAccess="sameDomain" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" />
	</object>
</div>
</center>

