<?php
/**
* @version $Id: installer.class.php,v 1.28 2004/09/21 15:46:23 rcastley Exp $
* @package Mambo_4.5.1
* @copyright (C) 2000 - 2004 Miro International Pty Ltd
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* Mambo is Free Software
* @subpackage Installer
* @version Safemode Patch 1.0
*/

/** ensure this file is being included by a parent file */
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

require_once($mosConfig_absolute_path . "/administrator/components/com_installer/ftp.installer.class.php");

/**
* Installer class
* @package Mambo_4.5.1
* @abstract
*/
class mosInstaller {
	
	//set ftp variables
	function setFtpGlobals(){
	global $ftpUse, $ftpUserName, $ftpPassword, $ftpHostName;
	$ftpUse=$this->getFtpUse();
	$ftpUserName=$this->getFtpUserName();
	$ftpPassword=$this->getFtpPassword();
	$ftpHostName=$this->getFtpHostName();
	
	}
	
	// name of the XML file with installation information
	var $i_installfilename	= "";
	var $i_installarchive	= "";
	var $i_installdir		= "";
	var $i_iswin			= false;
	var $i_errno			= 0;
	var $i_error			= "";
	var $i_installtype		= "";
	var $i_unpackdir		= "";
	var $i_docleanup		= true;

	/** @var string The directory where the element is to be installed */
	var $i_elementdir = '';
	/** @var string The name of the Mambo element */
	var $i_elementname = '';
	/** @var string The name of a special atttibute in a tag */
	var $i_elementspecial = '';
	/** @var object A DOMIT XML document */
	var $i_xmldoc			= null;

	var $i_hasinstallfile = null;
	var $i_installfile = null;
	
	var $i_ftpUse = 0;
	var $i_ftpUserName	= "";
	var $i_ftpPassword	= "";
	var $i_ftpHostName	= "";

	/**
	* Constructor
	*/
	function mosInstaller() {
		$this->i_iswin = (substr(PHP_OS, 0, 3) == 'WIN');
	}
	/**
	* Uploads and unpacks a file
	* @param string The uploaded package filename or install directory
	* @param boolean True if the file is an archive file
	* @return boolean True on success, False on error
	*/
	function upload($p_filename = null, $p_unpack = true) {
		global $mosConfig_absolute_path;
		//include_once( $mosConfig_absolute_path . '/administrator/components/com_installer/ftp.installer.class.php' );
		$this->i_iswin = (substr(PHP_OS, 0, 3) == 'WIN');
		$this->installArchive( $p_filename );
		
		if ($p_unpack) {
			if ($this->extractArchive()) {
				return $this->findInstallFile();
			} else {
				return false;
			}
		}
	}
	/**
	* Extracts the package archive file
	* @return boolean True on success, False on error
	*/
	function extractArchive() {
		global $mosConfig_absolute_path;

		// Common functions for the installer(s)
		// Extract functions
		require_once( $mosConfig_absolute_path . '/administrator/includes/pcl/pclzip.lib.installer.php' );
		require_once( $mosConfig_absolute_path . '/administrator/includes/pcl/pclerror.lib.php' );
		require_once( $mosConfig_absolute_path . '/administrator/includes/pcl/pcltrace.lib.php' );
		require_once( $mosConfig_absolute_path . '/administrator/includes/pcl/pcltar.lib.installer.php' );

		$base_Dir = mosPathName( $mosConfig_absolute_path . '/media' );

		$archivename = $base_Dir . $this->installArchive();
		$tmpdir = uniqid( 'install_' );

		$extractdir = mosPathName( $base_Dir . $tmpdir );
		$archivename = mosPathName( $archivename, false );

		$this->unpackDir( $extractdir );
		// Find the extension of the file
		$fileext = substr( strrchr( basename($this->installArchive()), '.' ), 1 );

		if ($fileext == 'gz' || $fileext == 'tar') {
			$result = PclTarExtract( $archivename, $extractdir );
			if (!$result) {
				$this->setError( 1, 'Tar Extract Error "' . PclErrorString(). '" Code ' . intval( PclErrorCode() ) );
				return false;
			}
			$this->installDir( $extractdir );
		} else {
			$zipfile = new PclZip( $archivename );
			if($this->isWindows()) {
				define('OS_WINDOWS',1);
			} else {
				define('OS_WINDOWS',0);
			}

			$ret = $zipfile->extract(PCLZIP_OPT_PATH,$extractdir);
			if($ret == 0) {
				$this->setError( 1, 'Unrecoverable error "'.$zipfile->errorName(true).'"' );
				return false;
			}
			$this->installDir( $extractdir );
		}

		// Try to find the correct install dir. in case that the package have subdirs
		// Save the install dir for later cleanup
		$filesindir = mosReadDirectory( $this->installDir(), '' );

		if (count( $filesindir ) == 1) {
			if (is_dir( $extractdir . $filesindir[0] )) {
				$this->installDir( mosPathName( $extractdir . $filesindir[0] ) );
			}
		}
		return true;
	}
	/**
	* Tries to find the package XML file
	* @return boolean True on success, False on error
	*/
	function findInstallFile() {
		$found = false;
		// Search the install dir for an xml file
		$files = mosReadDirectory( $this->installDir(), '.xml$' );

		if (count( $files ) > 0) {
			foreach ($files as $file) {
				$packagefile = $this->isPackageFile( $this->installDir() . $file );
				if (!is_null( $packagefile ) && !$found ) {
					$this->xmlDoc( $packagefile );
					return true;
				}
			}
			$this->setError( 1, 'ERROR: Could not find a Mambo XML setup file in the package.' );
			return false;
		} else {
			$this->setError( 1, 'ERROR: Could not find an XML setup file in the package.' );
			return false;
		}
	}
	/**
	* @param string A file path
	* @return object A DOMIT XML document, or null if the file failed to parse
	*/
	function isPackageFile( $p_file ) {
		$xmlDoc =& new DOMIT_Lite_Document();
		$xmlDoc->resolveErrors( true );

		if (!$xmlDoc->loadXML( $p_file, false, true )) {
			return null;
		}
		$element = &$xmlDoc->documentElement;

		if ($element->getTagName() != 'mosinstall') {
			return null;
		}
		// Set the type
		$this->installType( $element->getAttribute( 'type' ) );
		$this->installFilename( $p_file );
		return $xmlDoc;
	}
	/**
	* Loads and parses the XML setup file
	* @return boolean True on success, False on error
	*/
	function readInstallFile() {

		if ($this->installFilename() == "") {
			$this->setError( 1, 'No filename specified' );
			return false;
		}

		$this->i_xmldoc =& new DOMIT_Lite_Document();
		$this->i_xmldoc->resolveErrors( true );
		if (!$this->i_xmldoc->loadXML( $this->installFilename(), false, true )) {
			return false;
		}
		$main_element = &$this->i_xmldoc->documentElement;

		// Check that it's am installation file
		if ($main_element->getTagName() != 'mosinstall') {
			$this->setError( 1, 'File :"' . $this->installFilename() . '" is not a valid Mambo installation file' );
			return false;
		}

		$this->installType( $main_element->getAttribute( 'type' ) );
		return true;
	}
	/**
	* Abstract install method
	*/
	function install() {
		die( 'Method "install" cannot be called by class ' . strtolower(get_class( $this )) );
	}
	/**
	* Abstract uninstall method
	*/
	function uninstall() {
		die( 'Method "uninstall" cannot be called by class ' . strtolower(get_class( $this )) );
	}
	/**
	* return to method
	*/
	function returnTo( $option, $element ) {
		return "index2.php?option=$option&element=$element";
	}
	/**
	* @param string Install from directory
	* @param string The install type
	* @return boolean
	*/
	function preInstallCheck( $p_fromdir, $type ) {

		if (!is_null($p_fromdir)) {
			$this->installDir($p_fromdir);
		}

		if (!$this->installfile()) {
			$this->findInstallFile();
		}

		if (!$this->readInstallFile()) {
			$this->setError( 1, 'Installation file not found:<br />' . $this->installDir() );
			return false;
		}

		if ($this->installType() != $type) {
			$this->setError( 1, 'XML setup file is not for a "'.$type.'".' );
			return false;
		}

		// In case there where an error doring reading or extracting the archive
		if ($this->errno()) {
			return false;
		}

		return true;
	}
	/**
	* @param string The tag name to parse
	* @param string An attribute to search for in a filename element
	* @param string The value of the 'special' element if found
	* @param boolean True for Administrator components
	* @return mixed Number of file or False on error
	*/
	function parseFiles( $tagName='files', $special='', $specialError='', $adminFiles=0 ) {
		//require_once( $mosConfig_absolute_path . '/administrator/components/com_installer/ftp.installer.class.php' );
		global $mosConfig_absolute_path, $newDirPermissions;
		// Find files to copy
		$xml =& $this->xmlDoc();

		$files_element =& $xml->getElementsByPath( $tagName, 1 );
		if (is_null( $files_element )) {
			return 0;
		}

		if (!$files_element->hasChildNodes()) {
			// no files
			return 0;
		}
		$files = $files_element->childNodes;
		$copyfiles = array();
		if (count( $files ) == 0) {
			// nothing more to do
			return 0;
		}
		foreach ($files as $file) {
			if (basename( $file->getText() ) != $file->getText()) {
				$newdir = dirname( $file->getText() );

				if ($adminFiles){
					if (!makeDir( $this->componentAdminDir().$newdir, $newDirPermissions )) {	
						$this->setError( 1, 'Failed to create directory "' . ($this->componentAdminDir()) . $newdir . '"' );
						return false;
					}
				} else {
					if (!makeDir( $this->elementDir().$newdir, $newDirPermissions )) {
						$this->setError( 1, 'Failed to create directory "' . ($this->elementDir()) . $newdir . '"' );
						return false;
					}
				}
			}
			$copyfiles[] = $file->getText();

			// check special for attribute
			if ($file->getAttribute( $special )) {
				$this->elementSpecial( $file->getAttribute( $special ) );
			}
		}

		if ($specialError) {
			if ($this->elementSpecial() == '') {
				$this->setError( 1, $specialError );
				return false;
			}
		}

		if ($tagName == 'media') {
			// media is a special tag
			$mediaDir = mosPathName( $mosConfig_absolute_path . '/images/stories' );
			$result = $this->copyFiles( $this->installDir(), $mediaDir, $copyfiles );
		} else if ($adminFiles) {
			$result = $this->copyFiles( $this->installDir(), $this->componentAdminDir(), $copyfiles );
		} else {
			$result = $this->copyFiles( $this->installDir(), $this->elementDir(), $copyfiles );
		}

		return $result;
	}
	/**
	* @param string Source directory
	* @param string Destination directory
	* @param array array with filenames
	* @return boolean True on success, False on error
	*/
	function copyFiles( $p_sourcedir, $p_destdir, $p_files ) {
		global $mosConfig_absolute_path;
		//require_once( $mosConfig_absolute_path . '/administrator/components/com_installer/ftp.installer.class.php' );
		global $defaultFilePermissions, $ftp;
  
		if (is_array( $p_files ) && count( $p_files ) > 0) {
			foreach($p_files as $_file) {
				$filesource	= mosPathName( $p_sourcedir ) . $_file;
				$filedest	= mosPathName( $p_destdir ) . $_file;
				if($this->isWindows()) {
					$filesource = str_replace('/','\\',$filesource);
					$filedest	= str_replace('/','\\',$filedest);
				} else {
					$filesource = str_replace('\\','/',$filesource);
					$filedest	= str_replace('\\','/',$filedest);
				}

				if (!file_exists( $filesource )) {
					$this->setError( 1, "File $filesource does not exist!" );
					return false;
				} else if (file_exists( $filedest )) {
					$this->setError( 1, "There is already a file called $filedest - Are you trying to install the same CMT twice?" );
					return false;
				} else {
					$perms = setFilePermissions($filedest);
					if($this->getFtpUse()){
						// copy files via an ftp file transfer to keep ownership as ftp user
						// the ftp socket should be open already
						$filedest = translatePath($filedest);
						
						if(!$ftp->ftpPut($filedest, $filesource,  FTP_BINARY)){
							// flag ftp_put error
							$this->setError(1,"Failed to ftp file $filedest");
							return false;
						} elseif (!$ftp->ftpSite("CHMOD ". decoct($perms)." $filedest")){
							// flag ftp_exec chmod error
							$this->setError(1,"Failed to chmod permissions via ftp for file $filedest");
							return false;
						}

					}
					else{
							if(!(copy($filesource,$filedest) && chmod($filedest, 0777))) {
								$this->setError( 1, "Failed to copy file: $filesource to $filedest" );
								return false;
						}
					}
				}
			}
		} else {
			return false;
		}
		return count( $p_files );
	}
	/**
	* Copies the XML setup file to the element Admin directory
	* Used by Components/Modules/Mambot Installer Installer
	* @return boolean True on success, False on error
	*/
	function copySetupFile($where='admin') {
		if ($where == 'admin') {
			return $this->copyFiles( $this->installDir(),	$this->componentAdminDir(),	array( basename( $this->installFilename() ) ));
		} else if ($where == 'front') {
			return $this->copyFiles( $this->installDir(),	$this->elementDir(),	array( basename( $this->installFilename() ) ));
		}
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

	function installFilename( $p_filename = null ) {
		if(!is_null($p_filename)) {
			if($this->isWindows()) {
				$this->i_installfilename = str_replace('/','\\',$p_filename);
			} else {
				$this->i_installfilename = str_replace('\\','/',$p_filename);
			}
		}
		return $this->i_installfilename;
	}

	function installType( $p_installtype = null ) {
		return $this->setVar( 'i_installtype', $p_installtype );
	}

	function error( $p_error = null ) {
		return $this->setVar( 'i_error', $p_error );
	}

	function xmlDoc( $p_xmldoc = null ) {
		return $this->setVar( 'i_xmldoc', $p_xmldoc );
	}

	function installArchive( $p_filename = null ) {
		return $this->setVar( 'i_installarchive', $p_filename );
	}

	function installDir( $p_dirname = null ) {
		return $this->setVar( 'i_installdir', $p_dirname );
	}

	function unpackDir( $p_dirname = null ) {
		return $this->setVar( 'i_unpackdir', $p_dirname );
	}

	function isWindows() {
		return $this->i_iswin;
	}

	function errno( $p_errno = null ) {
		return $this->setVar( 'i_errno', $p_errno );
	}

	function hasInstallfile( $p_hasinstallfile = null ) {
		return $this->setVar( 'i_hasinstallfile', $p_hasinstallfile );
	}

	function installfile( $p_installfile = null ) {
		return $this->setVar( 'i_installfile', $p_installfile );
	}

	function elementDir( $p_dirname = null )	{
		return $this->setVar( 'i_elementdir', $p_dirname );
	}

	function elementName( $p_name = null )	{
		return $this->setVar( 'i_elementname', $p_name );
	}
	function elementSpecial( $p_name = null )	{
		return $this->setVar( 'i_elementspecial', $p_name );
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
	
	function cleanupInstall( $userfile_name, $resultdir) {
	global $mosConfig_absolute_path;

		if (file_exists( $resultdir )) {
			$this->deldirectory( $resultdir );
			unlink( mosPathName( $mosConfig_absolute_path . '/media/' . $userfile_name, false ) );
		}
	}

	function deldirectory( $dir ) {
		global $mosConfig_absolute_path, $ftp;
		
		//require_once( $mosConfig_absolute_path . '/administrator/components/com_installer/ftp.installer.class.php' );
	
		return delDir( $dir );
	}

	function makedirectory( $dir, $perms ) {
		global $mosConfig_absolute_path, $ftp;
		
		//require_once( $mosConfig_absolute_path . '/administrator/components/com_installer/ftp.installer.class.php' );
		
		return makeDir( $dir, $perms );
	}

}


?>