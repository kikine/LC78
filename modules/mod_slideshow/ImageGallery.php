<?php

Class ImageGallery
{
	// base image folder
	var $base;	
	// default jpeg quality output
	var $jpeg_quality = 80;
	/**
	 * Constructor
	 */
	function ImageGallery($baseDir){
		$this->base = $baseDir;
	}
	
	/**
	 * Return GD library version installed
	 */
	 /*
	function getGDVersion()	{
		if(function_exists("imagecreatetruecolor")){
			$gd = 2;
		} else {
			$gd = 1;
		}
		return $gd;
	}
	*/
	function getGDVersion($user_ver = 0)
	{
	   if (! extension_loaded('gd')) { return; }
	   static $gd_ver = 0;
	   // Just accept the specified setting if it's 1.
	   if ($user_ver == 1) { $gd_ver = 1; return 1; }
	   // Use the static variable if function was called previously.
	   if ($user_ver !=2 && $gd_ver > 0 ) { return $gd_ver; }
	   // Use the gd_info() function if possible.
	   if (function_exists('gd_info')) {
	       $ver_info = gd_info();
	       preg_match('/\d/', $ver_info['GD Version'], $match);
	       $gd_ver = $match[0];
	       return $match[0];
	   }
	   // If phpinfo() is disabled use a specified / fail-safe choice...
	   if (preg_match('/phpinfo/', ini_get('disable_functions'))) {
	       if ($user_ver == 2) {
	           $gd_ver = 2;
	           return 2;
	       } else {
	           $gd_ver = 1;
	           return 1;
	       }
	   }
	   // ...otherwise use phpinfo().
	   ob_start();
	   phpinfo(8);
	   $info = ob_get_contents();
	   ob_end_clean();
	   $info = stristr($info, 'gd version');
	   preg_match('/\d/', $info, $match);
	   $gd_ver = $match[0];
	   return $match[0];
	} // End getGDVersion()
	
	
	/**
	 * Return image list available
	 * @return associative array
	 */
	function getImageList(){
		$img_array = array();
		$dir = @opendir($this->base);
		if($dir){
			while(false !== ($file = readdir($dir))){
				if(strtolower(substr($file, strlen($file)-3)) == "jpg" || strtolower(substr($file, strlen($file)-3)) == "swf"){
					$stat = @getimagesize($this->base . $file);
					$more = '';
					
					$datafile = $this->base.substr($file, 0, strlen($file)-4).'.txt';
					
					if (file_exists($datafile)){	
						$more = $datafile;
					}
					
					array_push($img_array, array("image" => $file, "stat" => $stat, "info" => $more));
				}			
			}
			sort($img_array);
		}
		return $img_array;
	}
	
	/**
	 * make thumbinail file
	 */
	function makeThumb($image, $w, $h){	
		
			if ($version = $this->getGDVersion()){
			
				if ( is_file($this->base . $image) ){
					header("Content-type: image/jpeg");
					ob_start();
					$image_dir  = dirname($this->base .$image);
					$image_name = basename($this->base . $image);
					$size       = getimagesize($this->base . $image);
					if($h == -1){
						$h = $w/($size[0] / $size[1]);
					}
					if($w == -1){
						$w = $h/($size[0] / $size[1]);
					}				
					// nom du file
					$c_path = sprintf($this->base . "thumbs/__%dx%d_%s", $w, $h, $image_name);
					
					// $c_path = $this->base . "thumbs/". $image_name;
					// file exist ?
					if( is_file($c_path) ){
						header("Content-Length: ". filesize($c_path));
						readfile($c_path);
						ob_end_flush();
						return;
					}
					
					$src_width    = $size[0];
					$src_height   = $size[1];
					/* horizontal */
					if($src_height < $src_width){
						while($src_height/($src_width/$w) < $h){
							$w +=1;
						}
						if($version >= 2){
							$dst_img = imagecreatetruecolor($w,$h);
						} else {
							$dst_img = imagecreate($w,$h);
						}
					/* vertical */
					} else {
						$h = $src_height/($src_width/$w);
						if($version >= 2){
							$dst_img = imagecreatetruecolor($w,$h);
						} else {
							$dst_img = imagecreate($w,$h);
						}						
					}
					
					//#$h = 50;
					$src_img = @imagecreatefromjpeg ($this->base . $image);
					if($version >= 2){
						imagecopyresampled($dst_img,$src_img, 0, 0, 0, 0, $w, $h, $src_width, $src_height);
					} else {
						imagecopyresized($dst_img,$src_img, 0, 0, 0, 0, $w, $h, $src_width, $src_height);
					}
					//#die("$w, $h");
					//#return;
					/** now save the image */
					if(!is_dir(sprintf("%s/thumbs", $image_dir))){
						if(!is_writeable($image_dir)){
							chmod($image_dir, 0777);
						}
						mkdir(sprintf("%s/thumbs", $image_dir));
						chmod(sprintf("%s/thumbs", $image_dir),0777);
					}
					imagejpeg($dst_img, $c_path, $this->jpeg_quality);
					header("Content-Length: ". filesize($c_path));
					readfile($c_path);
					ob_end_flush();
				}	
			} else {
				readfile($this->base.$image);
			}
	
	} // makeThumb

	/**
	 * static flashOutput
	 */
	function flashOutput($out){
		return serialize($out);
		//return urlencode(utf8_encode(serialize($out)));
	}	
}



?>