<?php

// empèche les sorties d'erreurs
error_reporting(0);

// test le safe_mode du serveur
$r =  (ini_get('safe_mode') == '1' ? 1 : 0);

// si safe_mode == off ... redéfini le time limit
if (!$r) set_time_limit(180);


/** include the required class */
require_once("./ImageGallery.php");
if(isset($_GET['imagebaseurl'])){
	$imagebaseurl = $_GET['imagebaseurl'];
} else {
	$imagebaseurl = "../../images/stories/";
}

$iGallery = new ImageGallery($imagebaseurl);

//shell_exec("convert -scale 50x50 '\\home\\virtual\\site10\\fst\\var\\www\\html\\iGallery\\img\\DSCF0032.JPG' '\\home\\virtual\\site10\\fst\\var\\www\\html\\iGallery\\img\\50x50_DSCF0032.JPG'");

/** parse argv command */
if(isset($_GET['command'])){
	$arg = $_GET['command'];	
} else {
	die("output=bad argument");
}

/** print the flash output */
switch($arg){
	
	// image list
	case "list":
		echo "output=" . $iGallery->flashOutput($iGallery->getImageList());
		break;
	
	// make thumbnail
	case "thumb":
		if((isset($_GET['width']) || isset($_GET['height'])) and isset($_GET['image'])){		
			$image  = $_GET['image'];
			$width = -1;
			if(isset($_GET['width'])){
				$width  = $_GET['width'];
			}
			$height = -1;
			if(isset($_GET['height'])){
				$height = $_GET['height'];
			}
			$iGallery->makeThumb($image, $width, $height);
		} else {
			die("output=missing params");
		}
		break;
	// make resized image
	case "resized":
		if(	!isset($_GET['x']) ||
			!isset($_GET['y']) ||
			!isset($_GET['width']) ||
			!isset($_GET['contentWidth']) ||
			!isset($_GET['contentHeight']) ||
			!isset($_GET['image'])){
				die("output=missing params");
			} else {
				$iGallery->DisplayCroppedImage2($_GET['image'], $_GET['x'], $_GET['y'], $_GET['contentWidth'], $_GET['width'], $_GET['contentHeight']);
			}
		break;
	// missing or wrong parameters
	default:
		echo "ouput=" . dirname(__FILE__);
		break;
}

?>