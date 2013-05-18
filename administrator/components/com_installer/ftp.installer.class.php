<?php
/**
* @version $Id: ftp.installer.class.php,v 1.00 2004/11/13 16:46:23 mightyb Exp $
* @package Mambo_4.5.1
* @copyright (C) 2000 - 2004 Miro International Pty Ltd
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* Mambo is Free Software
* @subpackage Installer
* @version Safemode Patch 1.0
*/

/** ensure this file is being included by a parent file */
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );


// dmcd - dec 27/03  big change for mos 4.5.stable is that component directories no longer
// stored in the database.
// dmcd - feb 01/04  increased ftp account database fields to 50 chars, added a max_memory
// ini setting of 16M to correct max memory errors on some larger component uploads.

//asdbg_break();

defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

//make sure the max_memory limit is at least 16M
// for older php versions
$memlimit = ini_get('memory_limit');
preg_match("/[0-9]+/",$memlimit,$matches);
$memlimit=$matches[0];
if(!isset($memlimit) || $memlimit < 16)
   ini_set('memory_limit','16M');

$isWindows = substr(PHP_OS, 0, 3) == 'WIN';

// get any disabled php functions
$disFuncs = explode(',',ini_get('disable_functions'));
foreach($disFuncs as $func){
	$disabledFunctions[trim($func)] = 1;
}
unset($disFuncs);

// determine if FTP is available

// make sure the required functions for FTP support are available and not
// disabled.  Note that if any of the ftp extension functions are 
// disabled, we go and check for teh fsockopen function and use our own
// custom ftp class to provide FTP support if we can.

$ftpDisabled = false;
$ftpIsAvailable = false;

if(extension_loaded('ftp') &&
	!(array_key_exists('ftp_connect', $disabledFunctions) ||
	  array_key_exists('ftp_login', $disabledFunctions) ||
	  array_key_exists('ftp_site', $disabledFunctions) ||
	  array_key_exists('ftp_mkdir', $disabledFunctions) ||
	  array_key_exists('ftp_put', $disabledFunctions) ||
	  array_key_exists('ftp_nlist', $disabledFunctions) ||
	  array_key_exists('ftp_chdir', $disabledFunctions))){

	$ftpIsAvailable = true;

	// define a new ftp connection class to abstract the actual ftp extensions
	// so that we can still use fsockopen below if some of these ftp functions are
	// disabled
	class ftp{
		var $ftpRes = NULL;

		function ftpConnect($hostname){
			$this->ftpRes = @ftp_connect($hostname);
			if ($this->ftpRes === false){
				$this->ftpRes = NULL;
				return false;
			}
			return $this->ftpRes;
		}
		function ftpClose(){
			@ftp_close($this->ftpRes);
			$this->ftpRes = NULL;
		}
		function ftpLogin($name, $password){
			return @ftp_login($this->ftpRes, $name, $password);
		}
		function ftpSite($cmd){
			return @ftp_site($this->ftpRes, $cmd);
		}
		function ftpSize($file){
			return @ftp_size($this->ftpRes, $file);
		}
		function ftpMkdir($dir){
			return @ftp_mkdir($this->ftpRes, $dir);
		}
		function ftpChdir($path){
			return @ftp_chdir($this->ftpRes, $path);
		}
		function ftpNlist($dir){
			return @ftp_nlist($this->ftpRes, $dir);
		}
		function ftpPut($filedest, $filesrc, $mode){
			return @ftp_put($this->ftpRes, $filedest, $filesrc, $mode);
		}
		
	}
} elseif(function_exists(fsockopen) &&
	!(array_key_exists('fsockopen', $disabledFunctions))){
	if($sock = @fsockopen("localhost", 21)){
		fclose($sock);
//		mosDebugMessage("Using socket-based FTP...");
		$ftpIsAvailable = true;
		require_once($mosConfig_absolute_path . "/administrator/includes/pcl/ftp-client-class.php");
	}
} else $ftpIsAvailable = false;

if($ftpIsAvailable) $ftp = new ftp;

global $ftpUse;

$useFtpForCopy = $ftpUse;
$ftpMosAbsPath='';

// dmcd  oct 26/03
// enable writing of ALL file permissions

umask(0);

// determine if this is a bad php safe mode where scripts are being executed under
// different process effective uid to file uid. Don't know how this can work on windows
// systems.  Need to look into this more.
// $isWindows is not the same as the installer class var $i_iswin.  We are only concerned
// about file perms and process/file uid's here whereas $i_iswin is checking for
// file path convention differeces when running something like IIS.

$isWindows = substr(PHP_OS, 0, 3) == 'WIN';

$uidsDiff = $isWindows ? getmyuid() != getmypid() : !function_exists('posix_geteuid') || getmyuid() != posix_geteuid();

$safeMode = ini_get('safe_mode') && $uidsDiff;

$isWinPath = (substr(PHP_OS, 0, 3) == 'WIN' && stristr ( $_SERVER["SERVER_SOFTWARE"], "microsoft"));
$pathSepChr =  $isWinPath ? "\\" : '/';

// New directories should get permissions of 755 by default, or 777
// if created by mambo where script uid is not the same as process uid.
// TODO: deldir does not work for 0755, use mambo standard 0777 instead

$newDirPermissions = ($uidsDiff && !$ftpUse) ? 0777 : 0755; 

$defaultFilePermissions = octdec('0777');

// note that we want to also allow an ftp option, which will be needed as a minimum to support
// bad safemode as above to create directories and subdirectories of the component or module
// installation.


class ftpHostAccnt {
	var $id = 0;
	var $ftpUserName = null;
	var $ftpPassword = null;
	var $ftpHostName = null;
	var $enable = null;
	var $execPermissions = 35;
	var $dataPermissions = 35;
	
function getFtpAccnt(){
	// get previously used ftp user and host names if any to fill in those fields
        // for the user
	// go create this db table with blank entries if it does not exist yet
	global $database;
	
	$database->setQuery("CREATE TABLE IF NOT EXISTS #__siteFtpAccnt ".
		"(id INT NOT NULL DEFAULT 0, ftpUserName VARCHAR(50) NOT NULL DEFAULT '', ftpPassword VARCHAR(50) NOT NULL DEFAULT '', ".
		"ftpHostName VARCHAR(50) NOT NULL DEFAULT '".preg_replace('/^www\./i','',$_SERVER['SERVER_NAME'])."', ".
		"enable TINYINT NOT NULL DEFAULT 0, ".
		"execPermissions INT NOT NULL DEFAULT ". octdec(0755) .", ".
		"dataPermissions INT NOT NULL DEFAULT ". octdec(0755).") TYPE=MyISAM");

	if($database->query()){
		$database->setQuery("SELECT * FROM #__siteFtpAccnt");

		if(!($database->loadObject($this))){
                        // create new row in ftpAccntTable if none exists
			$this->ftpUserName='';
			$this->ftpPassword='';
			$this->ftpHostName=preg_replace('/^www\./i','',$_SERVER['SERVER_NAME']);
			$this->enable=0;
			$database->insertObject("#__siteFtpAccnt", $this);
			$database->setQuery("SELECT * FROM #__siteFtpAccnt");
			$database->loadObject($this);
		}
	
        return true;
	} else return false;
}

function setFtpAccnt(){
	// save ftp accnt info in the mambo database
	global $database;
	
	$cur = $database->updateObject("#__siteFtpAccnt", $this, 'id');
	return $cur;
}
}


function translatePath($dirPath) {
	// translates mambo paths into a path for the ftp server command
        global $ftpUse, $ftpMosAbsPath, $mosConfig_absolute_path;
	if($ftpUse){
		$mosPath = str_replace("\\","/",str_replace($mosConfig_absolute_path,'', $dirPath));
		if(substr($mosPath,0,1) != '/'){
			// ?  must be a relative path from the administrator script?
			// flag as an error for now.
		} else return $ftpMosAbsPath.$mosPath;
	} else return $dirPath;
}

function makeDir($dirPath, $permissions) {
	// oct 29th/03  dmcd - this function is used in lieu of the built-in mkdir() function in order to transparently
	// (as much as possible) support creating directories thru an ftp socket call to the web host server
	// admin ftp account.  This gets around the issue of safemode restrictions, but also allows file ownership
	// to remain as the web server admin, rather than 'nobody' which can greatly increase security.
	
	
	global $ftpUse, $ftp;
	
	if(file_exists($dirPath) && substr(decoct(fileperms($dirPath)),-3) == decoct($permissions)) return true;

	if(!$ftpUse) return mkdir($dirPath, $permissions);
	
	// check the ftp resource to see if we are still connected
	$dirPath = translatePath($dirPath);

	if (!$ftp->ftpMkdir($dirPath)){
		// flag user error for ftp mkdir
		return false;
	}
	
	if (!$ftp->ftpSite("CHMOD ". decoct($permissions)." $dirPath")){
		// flag user error for ftp chmod
		return false;
	}
	
	return true;
}

function delDir( $dir ) {
	global $ftpUse, $ftp;
	
	
	if (!is_deletable($dir)){
			chmodDir($dir,'777');
		}
		
	$current_dir = opendir( $dir );
	while ($entryname = readdir( $current_dir )) {
		if ($entryname != '.' and $entryname != '..') {
			if (is_dir( $dir . $entryname )) {
				delDir( mosPathName( $dir . $entryname ) );
			} else {
				unlink( $dir . $entryname );
			}
		}
	}
	closedir( $current_dir );
	
	if(substr($dir,-1,1) == '/') $dir = substr($dir,0,-1);
	
		 return rmdir( $dir );
}

function getDirPermsAndOwner($dir, &$perms, &$ownerIsMe) {
	global $isWindows;

	if(!file_exists($dir) || filetype($dir) != 'dir') return false;
	// octal perms
    $perms = substr(decoct(fileperms($dir)),-3);
	$ownerIsMe = $isWindows ? fileowner($dir) == getmyuid() : function_exists('posix_geteuid') && fileowner($dir) == posix_geteuid();
	return true;
}

function chmodDir($dir, $perms) {

	global $ftpUse, $ftp, $isWindows;

	if(!file_exists($dir) || filetype($dir) != 'dir') return false;
	// octal perms
	// just return if the dir permissions are already set to the requested value
	if(substr(decoct(fileperms($dir)),-3) == $perms) return true;

	if($isWindows ? fileowner($dir) == getmyuid() : function_exists('posix_geteuid') && fileowner($dir) == posix_geteuid() )
		chmod($dir, octdec($perms));
	elseif ($ftpUse)
{
		$ftp->ftpSite("CHMOD $perms ".translatePath($dir));	
//mosDebugMessage("chmoded dir $dir translated to ".translatePath($dir)." thru ftp to $perms ...");
}
	else return false;
	
	return true;
}

function needFtpForCompDirs(&$dirs){
	// checks the directories in the given array and all its subdirectories to see
	// if FTP is required for deletion.  Returns true if FTP required.
	// If dir does not exist, we skip it.  This supports optional module directories.

	$needFtp=false;
	
	foreach($dirs as $dir){
		if(!file_exists($dir)) continue;
		$current_dir = opendir($dir);
		while($entryname = readdir($current_dir)){
			if(is_dir("$dir/$entryname") and ($entryname != "." and $entryname!="..")){
				//getDirPermsAndOwner("$dir/$entryname", $perms, $owner);
				$Dirs = array("$dir/$entryname");
				if(!is_deletable("$dir/$entryname") ||
					needFtpForCompDirs($Dirs)){
					$needFtp=true;
					break;
				}
			}
		}
		closedir($current_dir);
		if($needFtp) break;
	}
	return $needFtp;
}

function setFilePermissions($filedest){
	global $defaultFilePermissions, $uidsDiff, $ftpUse;
	
	$perms = $defaultFilePermissions;

	// we want to restrict file permissions after copying files based on what we are doing
	// and what the file type is.

	// if pid is uid of this script, then either php is running as a cgi with a suExec functionality, or
	// someone somehow set all script file ownership over to the apache process, which is unlikely
	
	// writeprotect php script files and image files. Anything else will be set to $defaultFilePermissions
	// which is usually 0777.

	if(preg_match('/\.(php[0-9]?)|(\.jpg)|(\.gif)|(\.png)$/', $filedest))
		if($uidsDiff && !$ftpUse) $perms = octdec('0777');
		else $perms = octdec('0755');

	return $perms;
}
	
function establishFtpConn(&$myObj){
	global $ftpUse, $ftpUserName, $ftpPassword, $ftpHostName, $ftp, $ftpMosAbsPath, $mosConfig_absolute_path;
	
	if($ftpUse){

		$hostip=$ftpHostName;
		if(!preg_match('/^[\t ]*[0-9]+\.[0-9]+\.[0-9]+\.[0-9]+[\t ]*$/', $ftpHostName))
			$hostip = gethostbyname($ftpHostName);
		$ftplogin= $ftp->ftpConnect("$hostip");

		$ftpLoginRes = $ftp->ftpLogin($ftpUserName, $ftpPassword);
		if($ftplogin === false || $ftpLoginRes === false){
			// error msg to user, ftp failed login to host site account
			if(!is_null($myObj)) $myObj->setError('1','Error, failed to login to FTP host: '.$ftpHostName.' with user name: '.$ftpUserName);
			return;
		}
			
			
		unset($ftpPassword); // destroy the ftp password variable, we are done with it.
		
		// the absolute path thru the ftp socket is most likely not
                // the same absolute path for the mambo files on the host used
                // by the $mosConfig_absolute_path.  Need to determine where this
		// path starts.
		$ftpMosAbsPath = str_replace('\\', '/', $mosConfig_absolute_path);
			
		$resolved=false;
		while(!$resolved){
			if($ftp->ftpChdir($ftpMosAbsPath)){
				$resolved = true;
			}
			elseif (!($ftpMosAbsPath = stristr(substr($ftpMosAbsPath,1), '/'))) break;
		}		
		if(!$resolved){
			// could be that ftp root directory IS the Mambo directory
                        // In this case, $ftpMosAbsPath should have no '/', and we need
                        // to test for the presence of the mambo config file and
                        // the top subdirectories in the ftp root login directory?
                        if(!stristr(substr($ftpMosAbsPath,1), '/')){
				// read ftp root directory
				if(!($files=$ftp->ftpNlist('/'))){
					if(!is_null($myObj)) $myObj->setError('1','Error, failed to resolve the FTP host path to the Mambo directory');
					return false;
				}
				foreach($files as $key=>$file) $files[$key] = preg_replace("/^[ \t]*[\/]+/", "", $file);
                                // swap the key-value pairs for the files array
                                $files=array_swapKeyValue($files);
				$mosFiles = array();
				$mosFiles[] = 'configuration.php';
				$mosFiles[] = 'administrator';
				$mosFiles[] = 'classes';
				$mosFiles[] = 'includes';
				$mosFiles[] = 'components';
				$mosFiles[] = 'modules';
				$mosFiles[] = 'templates';
				$mosFiles[] = 'language';
				foreach($mosFiles as $mosFile){
					if(!array_key_exists($mosFile, $files)){
						if(!is_null($myObj)) $myObj->setError('1','Error, failed resolve FTP host path to Mambo directory');
						return false;
					}
				}
				
			} else {
				if(!is_null($myObj)) $myObj->setError('1','Error, failed resolve FTP host path to Mambo directory');
				return false;
			}
		}

	}
	return true;
}

function array_swapKeyValue($arry){
	// swaps the keys and values for the array
        $new_arry= array();
	foreach($arry as $key=>$value)
		$new_arry[$value]=$key;
	return $new_arry;
}



function is_deletable($dir)
{
	global $isWindows;

	// determines if a directory is deletable based on directory ownership, permissions,
	// and php safemode.

	// Note that the posix_geteuid() function is not available in a Windows OS environment,
	// Maybe use getpid instead?
	
	// Note that if the directory is not owned by the same uid as this executing script, it will
	// be unreadable and I think unwriteable in safemode regardless of directory permissions.

	if(ini_get('safe_mode') == 1 && @getmyuid() != fileowner($dir)) return false;

	// if dir owner not same as effective uid of this process, then perms must be full 777.
	// No other perms combo seems reliable across system implementations
	
	if(!$isWindows && (!(function_exists('posix_geteuid')) || posix_geteuid() !=  fileowner($dir))) return (substr(decoct(fileperms($dir)),-3) == '777');
	if($isWindows && getmypid() !=  fileowner($dir)) return (substr(decoct(fileperms($dir)),-3) == '777');
	// otherwise if this process owns the directory, we can chmod it ourselves to delete it
	return true;
}

?>
