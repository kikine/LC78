<?php
/**
* @version $Id: $
* @package Joomla
* @subpackage Installer
* @copyright (C) 2000 - 2005 Miro International Pty Ltd
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* Mambo is Free Software
* @version SafeJoomla 1.0 by Pranab Dhar
*/

/** ensure this file is being included by a parent file */
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

require_once( $mosConfig_absolute_path . '/administrator/includes/admin.php' );

class dummyInstaller {
  var $i_SafeMode     = false;
	var $i_ftpUse       = 0;
	var $i_ftpUserName	= "";
	var $i_ftpPassword	= "";
	var $i_ftpHostName	= "";
	var $i_iswin			= false;
	var $i_errno			= 0;
	var $i_error			= ""; 
	/**
	* Constructor
	*/
	function dummyInstaller() {
		$this->i_iswin = (substr(PHP_OS, 0, 3) == 'WIN');
		// the safemode indicator is to indicate to any custom installer that
		// safe mode is in effect and it can use installer supplied makeDir or makePath
		// or copyfiles
		if(!$this->i_iswin)
		    $this->i_SafeMode = (ini_get('safe_mode') == 1 && 
				                    (!function_exists('posix_geteuid') || @getmyuid() != @posix_geteuid()));
	  else
		    $this->i_SafeMode = (ini_get('safe_mode') == 1);
		
	}

  //set ftp variables
	function setFtpGlobals(){
	global $ftpUse, $ftpUserName, $ftpPassword, $ftpHostName;
	$ftpUse=$this->getFtpUse();
	$ftpUserName=$this->getFtpUserName();
	$ftpPassword=$this->getFtpPassword();
	$ftpHostName=$this->getFtpHostName();
	}
  function isWindows() {
		return $this->i_iswin;
	} 
	function isSafeMode() {
	   return $this->i_SafeMode;
	}
	/**
	* @param string The name of the property to set/get
	* @param mixed The value of the property to set
	* @return The value of the property
	*/
	function setVar( $name, $value=null ) {
		if (!is_null( $value )) {
			$this->$name = $value;
		}
		return $this->$name;
	}
	/**
	* @param int The error number
	* @param string The error message
	*/
	function setError( $p_errno, $p_error ) {
		$this->errno( $p_errno );
		$this->error( $p_error );
	}
	/**
	* @param boolean True to display both number and message
	* @param string The error message
	* @return string
	*/
	function getError($p_full = false) {
		if ($p_full) {
			return $this->errno() . " " . $this->error();
		} else {
			return $this->error();
		}
	}
	function errno( $p_errno = null ) {
		return $this->setVar( 'i_errno', $p_errno );
	}
	function error( $p_error = null ) {
		return $this->setVar( 'i_error', $p_error );
	}
	function setFtpUse($ftpUse) {
		return $this->setVar( 'i_ftpUse', $ftpUse );
	}
	function getFtpUse() {
		return $this->i_ftpUse;
	}
	function setFtpUserName($ftpUserName) {
		return $this->setVar( 'i_ftpUserName', $ftpUserName );
	}
	function getFtpUserName() {
		return $this->i_ftpUserName;
	}
	function setFtpPassword($ftpPassword) {
		return $this->setVar( 'i_ftpPassword', $ftpPassword );
	}
	function getFtpPassword() {
		return $this->i_ftpPassword;
	}
	function setFtpHostName($ftpHostName) {
		return $this->setVar( 'i_ftpHostName', $ftpHostName );
	}
	function getFtpHostName() {
		return $this->i_ftpHostName;
	}	
} 
?>