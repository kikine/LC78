<?php
/**
* @package EasyGB
* @copyright (C) 2006 Joomla-addons.org
* @author Websmurf
* 
* --------------------------------------------------------------------------------
* All rights reserved.  Easy GB Component for Joomla!
*
* This program is free software; you can redistribute it and/or
* modify it under the terms of the Creative Commons - Attribution-NoDerivs 2.5 
* license as published by the Creative Commons Organisation
* http://creativecommons.org/licenses/by-nd/2.5/.
*
* This program is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  
* --------------------------------------------------------------------------------
**/

defined( '_VALID_MOS' ) or die( 'Restricted access' );

$easygb_version = '1.0. beta 1';

class easyGB {
  
  /**
   * Show guestbook entries
   *
   */
  function showEntries(){
    global $database, $mainframe;
    
    $limit = intval( $mainframe->getUserStateFromRequest( "viewlistlimit", 'limit', $mainframe->getCfg('list_limit') ) );
  	$limitstart	= intval( $mainframe->getUserStateFromRequest( "view{$option}limitstart", 'limitstart', 0 ) );
    
    $basequery = "SELECT * FROM #__easygb ORDER BY date DESC";
    
    $query = str_replace('*', 'COUNT(1)', $basequery);
  	$database->setQuery($query);
  	$total = $database->loadResult();
  	
  	require_once($mainframe->getCfg('absolute_path') . '/administrator/includes/pageNavigation.php');
  	$pageNav = new mosPageNav($total, $limitstart, $limit);
  	
  	$query = str_replace("*", "*", $basequery) . " LIMIT $limitstart, $limit";
  	$database->setQuery($query);
  	$rows = $database->loadObjectList();
  	echo $database->getErrorMsg();
  	
  	HTML_easyGB::showEntries($rows, $pageNav);
  }
  
  /**
   * Edit or add an entry
   *
   * @param int $id
   */
  function editEntry($id){
    global $database, $my;
    
    $row = new dbEasyGB($database);
    $row->load($id);
    
    HTML_easyGB::editEntry($row);
  }
  
  /**
   * Save changes to entry
   *
   */
  function saveEntry(){
    global $database, $task, $option, $my;
    
    $row = new dbEasyGB($database);
    $row->bind($_POST);
    
    $row->published = intval(mosGetParam($_REQUEST, 'published', 0));
    
    if (!$row->check()) {
			echo "<script> alert('".$row->getError()."'); window.history.go(-1); </script>\n";
			exit();
		}
		if (!$row->store()) {
			echo "<script> alert('".$row->getError()."'); window.history.go(-1); </script>\n";
			exit();
		}
		
		switch ($task){
		  case 'save':
		    mosRedirect('index2.php?option=' . $option . '&act=entries', 'Changes to entry saved');
		    break;
		  case 'apply':
		    mosRedirect('index2.php?option=' . $option . '&act=entries&task=edit&cid=' . $row->id . '&hidemainmenu=1', 'Changes to entry saved');
		    break;
		}
  }
  
  /**
   * Save changes to entry
   *
   */
  function saveEntryFromFrontend(){
    global $database, $option, $my, $Itemid, $easygbConfig_auto_publish, $easygbConfig_mail_admin, $mainframe;
    
    josSpoofCheck(1);
    
    $row = new dbEasyGB($database);
    $row->bind($_POST);
    
    $row->published = $easygbConfig_auto_publish;
    $row->ip = $_SERVER['REMOTE_ADDR'];
    $row->browser = $_SERVER['HTTP_USER_AGENT'];
    $row->date = date('Y-m-d H:i:s');
    
    mosMakeHtmlSafe($row);
    
    if($my->id){
      $my->load();
      
      $row->email = $my->email;
      $row->name = $my->name;
    }
    
    //check captcha code:
    $code = mosGetParam($_REQUEST, 'captcha_code');
    $hash = mosGetParam($_REQUEST, 'hash');

    $captcha = easyCAPTCHA::getRowByHash($hash);
    if($captcha->code != $code){
      echo "<script> alert('Invalide security code, please try agian'); window.history.go(-1); </script>\n";
			exit();
    }
    
    if (!$row->check()) {
			echo "<script> alert('".$row->getError()."'); window.history.go(-1); </script>\n";
			exit();
		}
		if (!$row->store()) {
			echo "<script> alert('".$row->getError()."'); window.history.go(-1); </script>\n";
			exit();
		}
		
		//send out mail for new message
		if($easygbConfig_mail_admin){
      $content = "Hi, \n\nA new message has been posted in the guestbook at " . $mainframe->getCfg('live_site') . "\n\n" . 
                 "Name: " . $row->name . "\nMessage: " . $row->content . "\n\nThis message has been auto-generated";
      
      $query = "SELECT email, sendEmail 
        FROM #__users 
        WHERE ( gid = 24 OR gid = 25 )
        AND sendEmail = 1
        AND block = 0";
      $database->setQuery( $query );
      $admins = $database->loadObjectList();
      for($i=0,$n=count($admins);$i<$n;$i++){
        $admin = $admins[$i];
        
        mosMail($mainframe->getCfg('mailfrom'), $mainframe->getCfg('sitename'), $admin->email, 'New message in guestbook', $content);
      }
    }
		
    mosRedirect('index.php?option=' . $option . '&Itemid=' . $Itemid, $msg);
  }
  
  /**
   * Remove Entries
   *
   * @param array ids
   */
  function removeEntries($cid){
    global $database, $option;
    
    $row = new dbEasyGB($database);
    
    for($i=0,$n=count($cid);$i<$n;$i++){
      $row->delete($cid[$i]);
    }
    
    mosRedirect('index2.php?option=' . $option . '&act=entries', 'Guestbook entries removed');
  }
  
  /**
   * Set an entry state
   *
   * @param mixed id
   * @param int published
   */
  function setState($ids, $published){
    global $database, $option;
    
    $row = new dbEasyGB($database);
    for($i=0,$n=count($ids);$i<$n;$i++){
      $id = $ids[$i];
      
      $row->load($id);
    
      $row->published = $published;
    
      if (!$row->store()) {
  			echo "<script> alert('".$row->getError()."'); window.history.go(-1); </script>\n";
  			exit();
  		}
    }
    
    mosRedirect('index2.php?option=' . $option . '&act=entries');
  }
  
  /**
   * Show guestbook entries to the general public
   *
   */
  function showGBEntries($limit, $limitstart){
    global $database, $mainframe;
    
    
    $basequery = "SELECT * FROM #__easygb WHERE published = 1 ORDER BY date DESC";
    
    $query = str_replace('*', 'COUNT(1)', $basequery);
  	$database->setQuery($query);
  	$total = $database->loadResult();
  	
  	require_once($mainframe->getCfg('absolute_path') . '/includes/pageNavigation.php');
  	$pageNav = new mosPageNav($total, $limitstart, $limit);
  	
  	$query = str_replace("*", "*", $basequery) . " LIMIT $limitstart, $limit";
  	$database->setQuery($query);
  	$rows = $database->loadObjectList();
  	echo $database->getErrorMsg();
  	
  	HTML_easyGB::showGBEntries($rows, $pageNav);
  }
  
  /**
   * Handle all stripping etc..
   *
   * @param <var>dbEasyGB</var> $row
   */
  function process(&$row){
    global $my, $easygbConfig_guest_striplinks;
    
    $row->content = ' ' . $row->content;
    
    if(!$my->id && $easygbConfig_guest_striplinks){
      //strip all links
      easyFilter::striplinks($row->content);
    }
    if($my->id && $easygbConfig_user_striplinks){
      //strip all links
      easyFilter::striplinks($row->content);
    }
    
    //make all links clickable
    easyFilter::clickable($row->content);
    
    $row->content = substr($row->content, 1);
//    echo '<pre>';
//    print_r($row);
//    echo '</pre>';
  }
  
  function saveConfiguration(){
    global $option, $mainframe;
    
    
    $config = mosGetParam($_REQUEST, 'config');
    ksort($config);
    
    $content = '<?php
/**
* @package EasyGB
* @copyright (C) 2006 Joomla-addons.org
* @author Websmurf
* 
* --------------------------------------------------------------------------------
* All rights reserved.  Easy GB Component for Joomla!
*
* This program is free software; you can redistribute it and/or
* modify it under the terms of the Creative Commons - Attribution-NoDerivs 2.5 
* license as published by the Creative Commons Organisation
* http://creativecommons.org/licenses/by-nd/2.5/.
*
* This program is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  
* --------------------------------------------------------------------------------
**/

defined( \'_VALID_MOS\' ) or die( \'Restricted access\' );

';
    $keys = array_keys($config);
    for($i=0,$n=count($keys);$i<$n;$i++){
      $content .= '$easygbConfig_' . $keys[$i] . ' = ' . $config[$keys[$i]] . ";\n";
    }
    $content .= "\n?>";
    
    if(!is_writable($mainframe->getCfg('absolute_path') . '/administrator/components/com_easygb/configuration.php')){
      mosRedirect('index2.php?option=' . $option . '&act=configuration', 'Configuration file is not writable');
      return;
    }
    
    $fp = fopen($mainframe->getCfg('absolute_path') . '/administrator/components/com_easygb/configuration.php', 'w');
    fwrite($fp, $content);
    fclose($fp);
    
    mosRedirect('index2.php?option=' . $option . '', 'Configuration saved');
  }
}

class easyFilter {
  
  /**
   * Strip all links from content
   *
   * @param string $content
   */
  function striplinks(&$content){
    $content = preg_replace('#http://(.*)\s#iU', '** ', $content);
    $content = preg_replace('#www.(.*)\s#iU', '** ', $content);
    $content = preg_replace('#ftp://(.*)\s#iU', '** ', $content);
  }
  
  /**
   * Make links in content clickable
   *
   * @param string $content
   */
  function clickable(&$content){
    $content = preg_replace('#\swww.(.*)\s#iU', ' http://www.\\1 ', $content);
    $content = preg_replace('#\s(.*)://(.*)\s#iU', ' <a href="\\1://\\2" target="_blank">\\2</a> ', $content);
  }
}

class easyCAPTCHA {
  
  /**
   * Generate an image based on the hash
   *
   * @param string $hash
   */
  function generateImage($hash){
    global $easygbConfig_captcha_lines;
    
    $row = easyCAPTCHA::getRowByHash($hash);
    
    header("Content-type: image/png");
    $img = imagecreate(150, 30);
    
    $background_color = imagecolorallocate($img, 128, 128, 128);
    $text_color = imagecolorallocate($img, 200, 200, 200);
    $line_color = imagecolorallocate($img, 75, 75, 75);
    
    //draw a bunch of lines
    for($i=0;$i<$easygbConfig_captcha_lines;$i++){
      $x_1 = rand(0, 150);
      $x_2 = rand(0, 150);
      $y_1 = rand(0, 30);
      $y_2 = rand(0, 30);
      imageline($img, $x_1, $y_1, $x_2, $y_2, $line_color);
    }
    
    $x_offset = 15;
    for($i=0,$n=strlen($row->code);$i<$n;$i++){
      $y_offset = rand(3, 8);
      
      imagestring($img, 5, $x_offset, $y_offset,  substr($row->code, $i, 1), $text_color);
      
      $x_offset += rand(0, 15)+ 10;
    }
    
    imagepng($img);
    imagedestroy($img);
    die;
  }
  
  /**
   * Get the database row based on the hash
   *
   * @param string $hash
   * @return <var>dbEasyGBCaptcha</var>
   */
  function getRowByHash($hash){
    global $database;
    
    $query = "SELECT * FROM #__easygb_captcha WHERE md5(id) = '$hash'";
    $database->setQuery($query);
    $database->loadObject($row);
    
    return $row;
  }
  
  /**
   * Generate new code
   *
   * @return int ID
   */
  function generateCode(){
    global $database, $easygbConfig_captcha_length;
    
    
    //truncate all old ones
    $query = "DELETE FROM #__easygb_captcha WHERE generated < DATE_SUB(NOW(), INTERVAL 2 HOUR)";
    $database->setQuery($query);
    if(!$database->query()){
      echo $database->getErrorMsg();
    }
    
    $row = new dbEasyGBCaptcha($database);
    $row->generated = date('Y-m-d H:i:s');
    
    $letters = array('a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'j', 'k', 'm', 'n', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z', '2', '3', '4', '5', '6', '7', '8', '9');
    for($i=0;$i<($easygbConfig_captcha_length + 1);$i++){
      $row->code .= $letters[rand(0, count($letters) - 1)];
    }
    
    if (!$row->store()) {
			echo "<script> alert('".$row->getError()."'); window.history.go(-1); </script>\n";
			exit();
		}
    
    return $row->id;
  }
  
}

class dbEasyGB extends mosDBTable {
  /** @var int ID **/
  var $id = null;
  /** @var datetime date **/
  var $date = null;
  /** @var text content **/
  var $content = null;
  /** @var string name **/
  var $name = null;
  /** @var string email **/
  var $email = null;
  /** @var string homepage **/
  var $homepage = null;
  /** @var tinyint rating **/
  var $rating = null;
  /** @var string ip **/
  var $ip = null;
  /** @var string browser **/
  var $browser = null;
  /** @var boolean published **/
  var $published = null;
  
  function dbEasyGB(&$db){
    $this->mosDBTable('#__easygb', 'id', $db);
  }
}

class dbEasyGBCaptcha extends mosDBTable {
  /** @var int ID **/
  var $id = null;
  /** @var string code **/
  var $code = null;
  /** @var datetime generated **/
  var $generated = null;
  
  function dbEasyGBCaptcha(&$db){
    $this->mosDBTable('#__easygb_captcha', 'id', $db);
  }
}