<?php
/**
* sb_helpers.php joomlaboard help functions
* @package com_joomlaboard
* @copyright (C) 2000 - 2007 TSMF / Jan de Graaff / All Rights Reserved
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* @author TSMF & Thomas Despoix
* @version $Revision: 1.1 $ by $Author: jigsjdg $ ($Date: 2005/07/27 10:09:40 $)
* Joomla! is Free Software
**/
 
// Dont allow direct linking
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

function sbJsEscape($msg) {
  // escape javascript quotes and backslashes, newlines, etc.
  static $convertions = array(
    '\\'=>'\\\\',
    "'" =>"\\'",
    '"' =>'\\"',
    "\r"=>'\\r',
    "\n"=>'\\n',
    '</'=>'<\/');
    
  return strtr($msg, $convertions);
}

function sbAlert ($msg) {
  $msg = sbJsEscape($msg);
  echo "<script> alert('$msg'); </script>\n";
}

function sbAssertOrGoBack($predicate, $msg) {
  if (!$predicate) {
    $msg = sbJsEscape($msg);
    echo "<script> alert('$msg'); window.history.go(-1); </script>\n";
    exit();
  }
}

function sbAssertOrGoTo($predicate, $msg, $url) {
  if (!$predicate) {
    $msg = sbJsEscape($msg);
    $url = sefRelToAbs($url);
    echo "<script> alert('$msg'); window.location=$url'; </script>\n";
  }
}

function sbSetTimeout($url,$time,$script=1) {
	   $url=sefRelToAbs($url);
	   if ($script)
	   		echo '<script language="javascript">setTimeout("location=\''.$url.'\'",$time)</script>';
	   else
	   		echo 'setTimeout("location=\''.$url.'\'",$time)';
}	

function sbRedirect($url,$time,$msg) {
	echo '<script language="javascript">';
	echo 'alert(\''. sbJsEscape($msg) .'\')';
	sbSetTimeout($url,$time,0);
	echo '</script>';
}


?>

