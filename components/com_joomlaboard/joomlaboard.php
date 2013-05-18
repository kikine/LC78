<?php
/**
* joomlaboard.php init file
* @package com_joomlaboard
* @copyright (C) 2000 - 2007 TSMF / Jan de Graaff / All Rights Reserved
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* @author TSMF & Jan de Graaff
* Joomla! is Free Software
**/

// Dont allow direct linking
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

global $_CONFIG,$mosConfig_lang,$sbConfig,$sbIcons;

// uncomment below to debug
// define('JB_DEBUG',1);

// if we're debugging show all error reports
if (defined('JB_DEBUG'))
	error_reporting(E_ALL);

// get variables
$catid  = (int) mosGetParam ( $_REQUEST, 'catid' , 0);
$Itemid = (int) mosGetParam ( $_REQUEST, 'Itemid', 1);
$id		= (int) mosGetParam ( $_REQUEST, 'id'    , 0);
$func   = mosGetParam ( $_REQUEST, 'func' , 'listcat');
$do		= mosGetParam ( $_REQUEST , 'do'  , '');
$view	= mosGetParam ( $_GET	 , 'view' , '');

if (!isset($parentid) 		&& isset($_POST["parentid"])) 		$parentid 		= mosGetParam ( $_POST, 'parentid'  , ''); //BBTEMPFIX
if (!isset($contentURL) 	&& isset($_POST["contentURL"])) 	$contentURL 	= mosGetParam ( $_POST, 'contentURL'  , ''); //BBTEMPFIX
if (!isset($sb_authorname) 	&& isset($_POST["sb_authorname"])) 	$sb_authorname 	= mosGetParam ( $_POST, 'sb_authorname'  , ''); //BBTEMPFIX
if (!isset($email) 			&& isset($_POST["email"])) 			$email 			= mosGetParam ( $_POST, 'email'  , ''); //BBTEMPFIX
if (!isset($subject) 		&& isset($_POST["subject"])) 		$subject 		= mosGetParam ( $_POST, 'subject'  , ''); //BBTEMPFIX
if (!isset($topic_emoticon) && isset($_POST["topic_emoticon"])) $topic_emoticon = mosGetParam ( $_POST, 'topic_emoticon'  , ''); //BBTEMPFIX
if (!isset($subscribeMe)	&& isset($_POST["subscribeMe"])) 	$subscribeMe 	= mosGetParam ( $_POST, 'subscribeMe'  , ''); //BBTEMPFIX
if (!isset($attachimage)	&& isset($_FILES['attachimage']))	$attachimage	= mosGetParam ( $_FILES['attachimage'], 'name', ''); //BBTEMPFIX
if (!isset($attachfile)		&& isset($_FILES['attachfile']))	$attachfile		= mosGetParam ( $_FILES['attachfile'], 'name', ''); //BBTEMPFIX
if (!isset($sb_thread)		&& isset($_REQUEST["sb_thread"]))	$sb_thread	 	= mosGetParam ( $_REQUEST, 'sb_thread'  , '');  //BBTEMPFIX
if (!isset($thread)			&& isset($_REQUEST["thread"]))		$thread			= mosGetParam ( $_REQUEST, 'thread'  , '');  //BBTEMPFIX
if (!isset($markaction)		&& isset($_POST["markaction"])) 	$markaction 	= mosGetParam ( $_POST, 'markaction'  , '');  //BBTEMPFIX

//check if the Itemid is set correctly
if ($Itemid==1 or $Itemid == "") {
	$database->setQuery("select id from #__menu where link='index.php?option=com_joomlaboard'");
	$Itemid=$database->loadResult();
}

// set constants
define('JB_JABSPATH',$mainframe->getCfg( 'absolute_path' ));	// Joomla absolute path
define('JB_JLIVEURL',$mainframe->getCfg( 'live_site' ));		// Joomla live url
define('JB_LIVEURL','index.php?option='.$option.'&amp;Itemid='.$Itemid);	// Joomlaboard live url
define('JB_ABSPATH',JB_JABSPATH.'/components/com_joomlaboard');		// joomlaboard absolute path
define('JB_DIRECTURL',JB_JLIVEURL.'/components/com_joomlaboard');	// joomlaboard direct url
define('JB_LANG',$mainframe->getCfg( 'lang' ));
define('JB_ABSADMPATH',JB_JABSPATH.'/administrator/components/com_joomlaboard');

$database->setQuery("SELECT template FROM #__templates_menu where client_id ='0'");	
$current_stylesheet=$database->loadResult();
define('JB_JCSSURL',JB_JLIVEURL.'/templates/'.$current_stylesheet.'/css/template_css.css');

$systime= time()+($mainframe->getCfg('offset_user')*3600);
$settings = isset( $_COOKIE['sboard_settings'] ) ? $_COOKIE['sboard_settings'] : array();

// get Joomlaboards configuration params in
include_once( JB_ABSADMPATH.'/joomlaboard_config.php' );

// set configuration dependent params
$str_jb_templ_path=JB_ABSPATH.'/template/'.$sbConfig['template'];
$board_title=$sbConfig['board_title'];
$fromBot=0;
$prefview=$sbConfig['default_view'];

// get right Language file
if (file_exists(JB_ABSADMPATH.'/language/'.JB_LANG.'.php')) 
  include_once(JB_ABSADMPATH.'/language/'.JB_LANG.'.php');
else 
  include_once(JB_ABSADMPATH.'/language/english.php');


// include required libraries
require_once(JB_ABSPATH.'/functions/sb_layout.php');
require_once(JB_ABSPATH.'/functions/sb_permissions.php');
require_once(JB_ABSPATH.'/classes/category.class.php');
if ($catid!='') 
	$thisCat=new jbCategory($database,$catid);
if (defined('JPATH_BASE')) 
	jimport('pattemplate.patTemplate');
else 
	require_once( JB_JABSPATH. '/includes/patTemplate/patTemplate.php' );
$obj_jb_tmpl   = new patTemplate();
$obj_jb_tmpl->setBasedir($str_jb_templ_path);	

// Permissions: Check for administrators and moderators
if ($my->id != 0) {
   $aro_group = $acl->getAroGroup( $my->id );
   $is_admin = (strtolower($aro_group->name) == 'super administrator' || strtolower($aro_group->name) == 'administrator');
}
else {
	$aro_group=0;
	$is_admin=0;
}
$is_moderator=sb_has_moderator_permission($database,$thisCat,$my->id,$is_admin);

// Get itemid's for variuos integration components
if ($sbConfig['pm_component']=='uddeim') {
	$database->setQuery('SELECT id FROM #__menu WHERE link=`index.php?option=com_uddeim`');
	$uiitemid=$database->loadResult();
}

if ($sbConfig['pm_component']=='missus') {
	$database->setQuery('SELECT id FROM #__menu WHERE link=`index.php?option=com_missus`');
	$miitemid=$database->loadResult();
}

// Include the Community Builder language file if necessary and set ItemID
$cbitemid=0;
if ($sbConfig['cb_profile']) {
	//get the itemid for the Community Builder Component
 	//$query = "SELECT id"
    //    . "\n FROM #__menu"
    //    . "\n WHERE type = 'components'"
    //    . "\n AND published = 1"
    //    . "\n AND link = 'index.php?option=com_comprofiler'";
    //$database->query($query);
	//$cbitemid=$database->loadResult();
	$cbitemid=JBgetCBprofileItemid();
	$UElanguagePath	= $mainframe->getCfg( 'absolute_path' ).'/components/com_comprofiler/plugin/language';
	$UElanguage		= $mainframe->getCfg( 'lang' );
	if ( ! file_exists( $UElanguagePath . '/' . $mosConfig_lang . '/' . $mosConfig_lang . '.php' ) ) {
		$UElanguage = 'default_language';
	}
	include_once( $UElanguagePath . '/' . $UElanguage . '/' . $UElanguage . '.php' );
}

// TODO: icons packs are moving into templates! (set icons dir :-)
// See if there's an icon pack installed
$sbIcons=null;
if (file_exists(JB_JABSPATH.'/modules/mod_sbicons.php')) { 
	include_once(JB_JABSPATH.'/modules/mod_sbicons.php');
	if (is_array($sbIcons))
		define('JB_ICONURL',JB_JLIVEURL.'/modules/mod_sbicons');
}

//Get the userid; sometimes the new var works whilst $my->id doesn't..?!?
$my_id=$my->id;


if ($sbConfig['regonly'] && !$my->id)
{
   echo _FORUM_UNAUTHORIZIED. "<br />";
   echo _FORUM_UNAUTHORIZIED2;
}
else if ($sbConfig['board_offline'] && !$is_admin)
   echo $sbConfig['offline_message'];
else {
	
	/* Session administration 
	 * 
	 * We want to set up permissions only once for each session, so we keep a cache in the db. 
	 * To make sure that users priviliges are updated if permissions change we reset the priviliges
	 * after 30 mins of inactivity.
	 */
	 
	$sbSession=null;
	$previousVisit=time()-1314000; // previous visit defaults to a year ago
	
	$database->setQuery('SELECT * FROM #__sb_sessions where userid='.$my->id);
	$database->loadObject($sbSession);

	// create a session & profile for users that don't have one yet
	// guests share the session of user 0 (only used to have a cache of allowed forums) 
	if ($database->getAffectedRows()==0) {

		// create empty session
		$database->setQuery('INSERT INTO #__sb_sessions (userid,allowed,readtopics) VALUES ('.$my->id.',\'na\',\'\')');
		if(!$database->query())
			echo 'Error: Could not create session. <br />'.$database->getErrorMsg();
		
		// load the session
		$database->setQuery('SELECT * FROM #__sb_sessions where userid='.$my->id);
		$database->loadObject($sbSession);
	
		// create a profile for registered users that don't have one yet
		if ($my->id>0) {
			$database->setQuery('SELECT * FROM #__sb_users WHERE userid='.$my->id);
			$database->loadObject($sbUser);		
			if ($sbConfig['cb_profile']) { // in community builder
				$str_jb_view=$sbConfig['default_view']=='threaded' ? _UE_SB_VIEWTYPE_THREADED : _UE_SB_VIEWTYPE_FLAT;
				$database->setQuery('UPDATE #__comprofiler set sbviewtype=\''.$str_jb_view.'\' WHERE user_id='.$my->id);
				if (!$database->query())
					echo _PROBLEM_CREATING_PROFILE;
			}
			else { // in joomlaboard
				$str_jb_view=$sbConfig['default_view']=='threaded' ? 'threaded' : 'flat';
				$database->setQuery('INSERT INTO #__sb_users(userid,view) VALUES ('.$my->id.',\''.$str_jb_view.'\')');
				if (!$database->query())
					echo _PROBLEM_CREATING_PROFILE;
			}
		}
	}

	// if the cookie doesn't match the current user, overwrite cookie and reload
	if ($settings['member_id']!=$my->id) {
		setcookie("sboard_settings[member_id]",$my->id,time()+31536000,'/');
   		setcookie("sboard_settings[prevvisit]",$previousVisit,time()+31536000,'/');
     		echo '<script language="javascript">setTimeout("window.location.reload( true )",100);</script>';
	}

	// reset priviliges after 30min of inactivity
	$previousVisit=$sbSession->lasttime;
	$inactivePeriod=$previousVisit+1800;
	if ($inactivePeriod<$systime) {
		$database->setQuery('UPDATE #__sb_sessions SET allowed=\'na\', readtopics=\'\' WHERE userid='.$my->id);
		$database->query();
		$database->setQuery('UPDATE #__sb_sessions SET lasttime='.$systime.' WHERE userid='.$my->id);
		if (!$database->query())
			die ($database->getErrorMsg());
		setcookie("sboard_settings[prevvisit]",$previousVisit,time()+31536000,'/');
		echo '<script language="javascript">setTimeout("window.location.reload( true )",100);</script>';
	}
			
	// set allowed forums 
	if (empty($sbSession->allowed) || $sbSession->allowed=='na') {
		$sbSession->allowed=array();
		$database->setQuery('SELECT id from #__sb_categories WHERE published=1');
		$database->query();
		$catids=$database->getNumRows()>0 ? $database->loadResultArray() : array();
		foreach ($catids as $int_jb_catid) {
			$obj_jb_cat= new jbCategory($database,$int_jb_catid);
			if (sb_has_moderator_permission($database,$obj_jb_cat,$my->id,$is_admin) 
				|| sb_has_read_permission($obj_jb_cat,$sbSession->allowed,$aro_group->group_id,$acl)) 
			{
					$sbSession->allowed[]=$int_jb_catid;
			}
		}
		
		$database->setQuery('UPDATE #__sb_sessions SET allowed=\''.implode(',',$sbSession->allowed).'\''.' WHERE userid='.$my->id);
		if (!$database->query())
			die ($database->getErrorMsg());
	}
	else
		$sbSession->allowed=explode(',',$sbSession->allowed);
	
	/* first get the prefered view type for registered users */
	if ($my->id>0 && !isset($str_jb_view) && empty($view)) {
		if ($sbConfig['cb_profile']) {
			$database->setQuery('SELECT sbviewtype FROM #__comprofiler WHERE user_id='.$my->id);
			$str_jb_view=$database->loadResult() == _UE_SB_VIEWTYPE_THREADED ? 'threaded' : 'flat';	
		}
		else {
			$database->setQuery('SELECT view FROM #__sb_users WHERE userid='.$my->id);
			$str_jb_view=$database->loadResult();
		}
	}
	/* determine the prefered view to render the forum in (threaded or flat) */
	/* save this value in a cookie (needed for non registered users)		*/
	if (!empty($view))
		setcookie("sboard_settings[current_view]",$view,time()+31536000,'/');
	elseif (isset($str_jb_view)) 
		$view=$str_jb_view;
	elseif (isset($settings['current_view'])) 
		$view=$settings['current_view'];		
	else
		$view=$sbConfig['default_view'];
	setcookie("sboard_settings[current_view]",$view,time()+31536000,'/');


    //get previous visit time from cookie; if there's no cookie yet, use database stored value
   	if ($settings['prevvisit']==0 && $previousVisit !=0)
   		$prevCheck= $previousVisit;
	else
		$prevCheck=$settings['prevvisit'];
		
   //Get the max# of posts for any one user
   $database->setQuery("SELECT max(posts) from #__sb_users");
   $maxPosts=$database->loadResult();
   
   // Check read permission, stop if the user doesn't have it
	if($catid > 0 && !in_array($catid,$sbSession->allowed)) {
		$sbMenu=jb_get_menu($cbitemid,$sbConfig,$sbIcons,$my->id,1);
		$obj_jb_tmpl->addVar('jb-header','menu',$sbMenu);
   		$obj_jb_tmpl->addVar('jb-header','board_title',$board_title);
		$obj_jb_tmpl->addVar('jb-header','css_path',JB_DIRECTURL.'/template/'.$sbConfig['template'].'/forum.css');
		$obj_jb_tmpl->addVar('jb-header','offline_message',$sbConfig['board_offline'] ? '<span id="sbOffline">' ._FORUM_IS_OFFLINE. '</span>' : '');
		$obj_jb_tmpl->addVar('jb-header','searchbox',getSearchBox());
		$obj_jb_tmpl->displayParsedTemplate('jb-header');
		echo '<p style="text-align:center">'._PERM_NO_READ.'</p>';
		$obj_jb_tmpl->readTemplatesFromFile( "footer.html" );
		$obj_jb_tmpl->addVar('jb-footer','credits','<a href="http://www.tsmf.net" target="_blank">Two Shoes M-Factory</a>');
		$obj_jb_tmpl->addVar('jb-footer','version_info',"Joomlaboard Forum Component ".$sbConfig['version']);
		$obj_jb_tmpl->displayParsedTemplate('jb-footer');
		return;			   	
   }
   //Finally, check if the catid requested is a parent category, because if it is
   //the only thing we can do with it is 'listcat' and nothing else
   if ($func == "showcat" || $func == "view" || $func == "post"){
      $database->setQuery("SELECT parent FROM #__sb_categories WHERE id='$catid'");
      $strCatParent=$database->loadResult();
      if ($catid=='' || $strCatParent==0)
      	$func='listcat';
   }

	//intercept the RSS request; we should stop afterwards
	if ($func=='sb_rss') {
   		include(JB_ABSPATH.'/sb_rss.php');
   		die();
	}
	if ($func=='sb_pdf') {
   		include(JB_ABSPATH.'/sb_pdf.php');
   		die();
	}
	if ($func=='sb_bbjs') {
		include(JB_ABSPATH.'/smile.class.php');
		include(JB_ABSPATH.'/bb.js.php');
		exit();
	}
	
	switch ($func) {
		case 'view':
				$sbMenu=jb_get_menu($cbitemid,$sbConfig,$sbIcons,$my->id,3,$view,$catid,$id);
				break;
		case 'showcat':
				//get number of pending messages
				$database->setQuery('SELECT count(*) FROM #__sb_messages WHERE catid=\''.$catid.'\' and hold=1');
				$numPending=$database->loadResult();
				$sbMenu=jb_get_menu($cbitemid,$sbConfig,$sbIcons,$my->id,2,$view,$catid,0,$is_moderator,$numPending);
				break;
		default:
			$sbMenu=jb_get_menu($cbitemid,$sbConfig,$sbIcons,$my->id,1);
			break;
   }

   // display header
   $obj_jb_tmpl->readTemplatesFromFile( "header.html" );
   $obj_jb_tmpl->addVar('jb-header','menu',$sbMenu);
   $obj_jb_tmpl->addVar('jb-header','board_title',$board_title);
   $obj_jb_tmpl->addVar('jb-header','css_path',JB_DIRECTURL.'/template/'.$sbConfig['template'].'/forum.css');
   $obj_jb_tmpl->addVar('jb-header','offline_message',$sbConfig['board_offline'] ? '<span id="sbOffline">' ._FORUM_IS_OFFLINE. '</span>' : '');
   $obj_jb_tmpl->addVar('jb-header','searchbox',getSearchBox());
   $obj_jb_tmpl->displayParsedTemplate('jb-header');
   switch ($func) {

      #########################################################################################
      case 'post':
         include (JB_JABSPATH."/components/com_joomlaboard/smile.class.php");
         include(JB_JABSPATH.'/components/com_joomlaboard/post.php');
      break;
      #########################################################################################
      case 'view':
         include (JB_JABSPATH."/components/com_joomlaboard/smile.class.php");
         include(JB_JABSPATH.'/components/com_joomlaboard/view.php');
      break;
      #########################################################################################
      case 'faq':
         include(JB_JABSPATH.'/components/com_joomlaboard/faq.php');
      break;
      #########################################################################################
      case 'showcat':
         include (JB_JABSPATH."/components/com_joomlaboard/smile.class.php");
         include(JB_JABSPATH.'/components/com_joomlaboard/showcat.php');
      break;
      #########################################################################################
      case 'listcat':
         include(JB_JABSPATH.'/components/com_joomlaboard/listcat.php');
      break;
      #########################################################################################
      case 'review':
         include (JB_JABSPATH."/components/com_joomlaboard/smile.class.php");
         include(JB_JABSPATH.'/components/com_joomlaboard/moderate_messages.php');
      break;
      #########################################################################################
      case 'rules':
         include(JB_JABSPATH.'/components/com_joomlaboard/rules.php');
      break;
      #########################################################################################
      case 'userprofile':
         include (JB_JABSPATH."/components/com_joomlaboard/smile.class.php");
         include(JB_JABSPATH.'/components/com_joomlaboard/userprofile.php');
      break;
      #########################################################################################
      case 'upload':
         include(JB_JABSPATH.'/components/com_joomlaboard/avatar_upload.php');
      break;
      #########################################################################################
      case 'latest':
         include(JB_JABSPATH.'/components/com_joomlaboard/latestx.php');
      break;
      #########################################################################################
      case 'search':
      	 require_once(JB_ABSPATH.'/classes/search.class.php');
      	 $searchword= mosGetParam( $_REQUEST, 'searchword', '' );
      	 $limitstart = intval( mosGetParam( $_REQUEST, 'limitstart', 0 ) );
      	 // use joomla 1.5 cache if possible
	     if (defined('JPATH_BASE')) {
		 	$cache = & JFactory::getCache();
			$cache->setCaching( 1 );
			$obj_jb_search = $cache->call( array( 'jbSearch', 'jbSearch',$searchword,$my->id,$limitstart,$sbConfig['messages_per_page'] ) );
    	}
    	else
			$obj_jb_search=&new jbSearch($database,$searchword,$my->id,$limitstart,$sbConfig['messages_per_page']);
      	$obj_jb_search->show();
      break;
      #########################################################################################
		case 'markAllRead':
      		setcookie("sboard_settings[prevvisit]",$previousVisit,time()+31536000,'/');
      		mosRedirect(JB_LIVEURL,_GEN_ALL_MARKED);
      #########################################################################################
      case 'markThisRead':
         // get all already read topics
         $database->setQuery("SELECT readtopics FROM #__sb_sessions WHERE userid=$my->id");
         $allreadyRead=$database->loadResult();
         /* Mark all these topics read */
         $database->setQuery("SELECT thread FROM #__sb_messages WHERE catid=$catid and thread not in ('$allreadyRead') GROUP BY THREAD");
         $readForum=$database->loadObjectList();

         $readTopics='--';
         foreach ($readForum as $rf){
            $readTopics=$readTopics.','.$rf->thread;
         }
         $readTopics=str_replace('--,','',$readTopics);

         if ($allreadyRead != ""){
            $readTopics=$readTopics.','.$allreadyRead;
         }

         $database->setQuery("UPDATE #__sb_sessions set readtopics='$readTopics' WHERE userid=$my->id");
         $database->query();
         echo "<script> alert('"._GEN_FORUM_MARKED."'); window.history.go(-1); </script>\n";
      break;
      #########################################################################################
      case 'karma':
         include(JB_JABSPATH.'/components/com_joomlaboard/sb_karma.php');
      break;
	  #########################################################################################
	  case 'stats':
      include(JB_JABSPATH.'/components/com_joomlaboard/stats.php');
      break;
      #########################################################################################
      default:
         include(JB_JABSPATH.'/components/com_joomlaboard/listcat.php');
      break;
   }//hctiws
   
   	// display footer
	$obj_jb_tmpl->readTemplatesFromFile( "footer.html" );
	$obj_jb_tmpl->addVar('jb-footer','credits','<a href="http://www.tsmf.net" target="_blank">Two Shoes M-Factory</a>');
	$obj_jb_tmpl->addVar('jb-footer','version_info',"Joomlaboard Forum Component ".$sbConfig['version']);
	$obj_jb_tmpl->displayParsedTemplate('jb-footer');
}//esle

/**
 * gets Itemid of CB profile, or by default of homepage
 * @param boolean TRUE if should return "&amp:Itemid...." instead of "&Itemid..." (with FALSE as default)
 * @return string "&Itemid=xxx"
 */
function JBgetCBprofileItemid( $htmlspecialchars= false ) {
        global $JB_CB__Cache_ProfileItemid, $database;
       
        if (!$JB_CB__Cache_ProfileItemid) {
                $database->setQuery("SELECT id FROM #__menu WHERE link = 'index.php?option=com_comprofiler' AND published=1");
                $Itemid = (int) $database->loadResult();
                if (!$Itemid) {
                /** Nope, just use the homepage then. */
                        $query = "SELECT id"
                    . "\n FROM #__menu"
                     . "\n WHERE menutype = 'mainmenu'"
                      . "\n AND published = 1"
                        . "\n ORDER BY parent, ordering"
                        . "\n LIMIT 1"
                  ;
                       $database->setQuery( $query );
                  $Itemid = (int) $database->loadResult();
                }
               $JB_CB__Cache_ProfileItemid = $Itemid;
  }
       if ($JB_CB__Cache_ProfileItemid) {
              return $JB_CB__Cache_ProfileItemid;
} else {
                return null;
    }
}

function fmodReplace($x,$y)
{ //function provided for older PHP versions which do not have an fmod function yet
   $i = floor($x/$y);
   // r = x - i * y
   return $x - $i*$y;}

function check_image_type(&$type)
{
   switch( $type )
   {
      case 'jpeg':
      case 'pjpeg':
      case 'jpg':
      case 'JPEG':
      case 'PJPEG':
      case 'JPG':
         return '.jpg';
         break;
      case 'gif':
      case 'GIF':
         return '.gif';
         break;
      case 'png':
      case 'PNG':
         return '.png';
         break;
   }

   return false;
}
?>
