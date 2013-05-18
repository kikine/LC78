<?PHP
/**
 * @version $Id: admin.joomlastats.php 196 2007-03-18 23:59:17Z RoBo $
 * @package JoomlaStats
 * @copyright Copyright (C) 2004-2007 JoomlaStats Team. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
 */
	
//ensure this file is being included by a parent file
defined('_VALID_MOS') or die ('Direct Access to this location is not allowed.');

// mic: usercheck
if (!($acl->acl_check('administration', 'edit', 'users', $my->usertype, 'components', 'all' ) || 
	  $acl->acl_check('administration', 'edit', 'users', $my->usertype, 'components', 'com_joomlastats')) )
    mosRedirect('index2.php', _NOT_AUTH);

global $JSLanguage, $jslang;


require_once($mainframe->getPath('admin_html'));

$task = trim(mosGetParam($_REQUEST, 'task', 'stats'));
$cid = mosGetParam($_REQUEST, 'cid', array(0));
	
if (!is_array($cid)) 
	$cid = array (0);


// create JoomlaStats engine for reporting
$JoomlaStatsEngine = new JoomlaStats_Engine($mainframe,$task);

if ($task == 'stats')
{
	$JoomlaStatsEngine->task = $JoomlaStatsEngine->startoption;
	$task = $JoomlaStatsEngine->startoption;
}
		
switch ($task)
{
	case "r01":
		$JoomlaStatsEngine->JoomlaStatsHeader();
		echo $JoomlaStatsEngine->ysummary();
		$JoomlaStatsEngine->JoomlaStatsfooter();
		break;
	case "r02":
		$JoomlaStatsEngine->JoomlaStatsHeader();
		echo $JoomlaStatsEngine->msummary();
		$JoomlaStatsEngine->JoomlaStatsfooter();
		break;
	case "r03":
		$JoomlaStatsEngine->JoomlaStatsHeader();
		echo $JoomlaStatsEngine->VisitInformation();
		$JoomlaStatsEngine->JoomlaStatsfooter();
		break;
		
///RB: Is this one (r04) added by mic or should it be removed?	
	case "r04":
		$JoomlaStatsEngine->JoomlaStatsHeader();
		echo $JoomlaStatsEngine->botsInformation();
		$JoomlaStatsEngine->JoomlaStatsfooter();
		break;

	case "r05":
		$JoomlaStatsEngine->JoomlaStatsHeader();
		echo $JoomlaStatsEngine->getVisitorsByTld();
		$JoomlaStatsEngine->JoomlaStatsfooter();
		break;
	case "r06":
		$JoomlaStatsEngine->JoomlaStatsHeader();
		echo $JoomlaStatsEngine->getPageHits();
		$JoomlaStatsEngine->JoomlaStatsfooter();
		break;
	case "r07":
		$JoomlaStatsEngine->JoomlaStatsHeader();
		echo $JoomlaStatsEngine->getSystems();
		$JoomlaStatsEngine->JoomlaStatsfooter();
		break;
	case "r08":
		$JoomlaStatsEngine->JoomlaStatsHeader();
		echo $JoomlaStatsEngine->getBrowsers();
		$JoomlaStatsEngine->JoomlaStatsfooter();
		break;
	case "r09":
		$JoomlaStatsEngine->JoomlaStatsHeader();
		echo $JoomlaStatsEngine->getBots();
		$JoomlaStatsEngine->JoomlaStatsfooter();
		break;
	case "r09a":
		$JoomlaStatsEngine->JoomlaStatsHeader();
		echo $JoomlaStatsEngine->moreVisitInfo();
		$JoomlaStatsEngine->JoomlaStatsfooter();
		break;
	case "r10":
		$JoomlaStatsEngine->JoomlaStatsHeader();
		echo $JoomlaStatsEngine->getReferrers();
		$JoomlaStatsEngine->JoomlaStatsfooter();
		break;
	case "r11":
		$JoomlaStatsEngine->JoomlaStatsHeader();
		echo $JoomlaStatsEngine->getNotIdentified();
		$JoomlaStatsEngine->JoomlaStatsfooter();
		break;
	case "r12":
		$JoomlaStatsEngine->JoomlaStatsHeader();
		echo $JoomlaStatsEngine->getUnknown();
		$JoomlaStatsEngine->JoomlaStatsfooter();
		break;
	case "r14":
		$JoomlaStatsEngine->JoomlaStatsHeader();
		echo $JoomlaStatsEngine->getSearches();
		$JoomlaStatsEngine->JoomlaStatsfooter();
		break;
	case "r03a":
		$JoomlaStatsEngine->JoomlaStatsHeader();
		echo $JoomlaStatsEngine->moreVisitInfo();
		$JoomlaStatsEngine->JoomlaStatsfooter();
		break;
	case "r03b":
		$JoomlaStatsEngine->JoomlaStatsHeader();
		echo $JoomlaStatsEngine->morePathInfo();
		$JoomlaStatsEngine->JoomlaStatsfooter();
		break;		
	case "summinfo":
		echo $JoomlaStatsEngine->GetSummariseInfo();
		break;
	case "summtask":
		$JoomlaStatsEngine->JoomlaStatsHeader();
		echo $JoomlaStatsEngine->DoSummariseTask();
		$JoomlaStatsEngine->JoomlaStatsfooter();
		break;
	case "uninstall":
		echo $JoomlaStatsEngine->GetUnInstallInfo();
		break;
	case "uninstalltask":
		$JoomlaStatsEngine->JoomlaStatsHeader();
		echo $JoomlaStatsEngine->DoUnInstallTask();
		$JoomlaStatsEngine->JoomlaStatsfooter();
		break;
	case "getconf":
		$JoomlaStatsEngine->JoomlaStatsHeader();
		echo $JoomlaStatsEngine->GetConfiguration();
		$JoomlaStatsEngine->JoomlaStatsfooter();
		break;
	case "purgedb":
		$JoomlaStatsEngine->JoomlaStatsHeader();
		$JoomlaStatsEngine->PurgeDatabase();
		echo $JoomlaStatsEngine->GetConfiguration();
		$JoomlaStatsEngine->JoomlaStatsfooter();
		break;
	case "saveconf":
		$JoomlaStatsEngine->JoomlaStatsHeader();
		echo $JoomlaStatsEngine->SetConfiguration();
		$JoomlaStatsEngine->JoomlaStatsfooter();
		break;
	case "info":
		echo $JoomlaStatsEngine->GetInformation();
		break;
	case "exclude":
		excludeIpAddress($cid, 1, $option);
		break;
	case "unexclude":
		excludeIpAddress($cid, 0, $option);
		break;
	case "viewip":
		showIpAddresses($option);
		break;
	case "tldlookup":
		$JoomlaStatsEngine->JoomlaStatsHeader();
		processTldLookUp($option);
		$JoomlaStatsEngine->JoomlaStatsfooter();
		break;
		
	case 'jsbackup':
		$JoomlaStatsEngine->JoomlaStatsHeader();
		$JoomlaStatsEngine->JSBackupTables();
		$JoomlaStatsEngine->JoomlaStatsfooter();
		break;
	case 'jsbackupcomplete':
		$JoomlaStatsEngine->JoomlaStatsHeader();
		$JoomlaStatsEngine->JSBackupTables( true );
		$JoomlaStatsEngine->JoomlaStatsfooter();
		break;
	case 'jsexport2csv':
		$JoomlaStatsEngine->JSExport2CVS( $act );
		break;
			
	default:
		$JoomlaStatsEngine->JoomlaStatsHeader();
		echo $JoomlaStatsEngine->ysummary();
		$JoomlaStatsEngine->JoomlaStatsfooter();
		break;
}	


function showIpAddresses($option)
{
	global $database, $mainframe, $my, $acl, $JoomlaStatsEngine;

	$limit = $mainframe->getUserStateFromRequest( "viewlistlimit", 'limit', 10 );
	$limitstart = $mainframe->getUserStateFromRequest( "view{$option}limitstart", 'limitstart', 0 );
	$search = $mainframe->getUserStateFromRequest( "search{$option}", 'search', '' );
	$search = $database->getEscaped( trim( strtolower( $search ) ) );

	$where = array();
	if (isset( $search ) && $search!= "")
		$where[] = "(ip LIKE '%$search%' OR nslookup LIKE '%$search%' OR browser LIKE '%$search%' OR system LIKE '%$search%')";
		
	$sql= "SELECT COUNT(*) "
			. "FROM #__jstats_ipaddresses "
			. (count( $where ) ? "WHERE " . implode( ' AND ', $where ) : "");
	$database->setQuery($sql);
	$total = $database->loadResult();	
	echo $database->getErrorMsg();
	
	require_once("includes/pageNavigation.php");	
	$pageNav = new mosPageNav( $total, $limitstart, $limit  );
	
	$sql = "SELECT id, ip, nslookup, system, browser, exclude "
			."FROM #__jstats_ipaddresses "
			. (count( $where ) ? "\nWHERE " . implode( ' AND ', $where ) : "")
			. " ORDER BY exclude DESC, ip DESC"
			. " LIMIT $pageNav->limitstart, $pageNav->limit";
	$database->setQuery($sql);	
	$rows = $database->loadObjectList();
	if ($database->getErrorNum())
	{
		echo $database->stderr();
		return false;
	}
	
	$JoomlaStatsEngine->listIpAddresses($rows, $pageNav, $search, $option);
}
	
function excludeIpAddress($cid=null, $block=1, $option)
/*
 *	$cid =		 
 *  $block =	 0: unexclude	1: exclude 
 *  $option =	 
 */
{
	global $database, $my;
	global $JSLanguage;
	
	$vid = mosGetParam($_REQUEST, 'vid', array());
		
	// mic: in case if function is called from the statistics page
	if (count($vid) > 0)
	{
		$cid[0]	= $vid;
		$task	= 'r03';
	}else
		$task	= 'viewip';
	
	if (count($cid) < 1)
	{
		$action = $block ? 'exclude' : 'unexclude';
		echo "<script type=\"text/javascript\">alert('" . $JSLanguage['messages']['msg01'] . ': ' . $action . "'); window.history.go(-1);</script>\n";
		exit;
	}

	$cids = implode(',', $cid);

	$sql  = "UPDATE #__jstats_ipaddresses"
		. "\n SET exclude = '$block'"
		. "\n WHERE id IN ($cids)";
	$database->setQuery($sql);
	if (!$database->query())
	{
		echo "<script> alert('".$database->getErrorMsg()."'); window.history.go(-1); </script>\n";
		exit();
	}

	if ($block) 
		$msg = $JSLanguage['messages']['msg25'];
	else
		$msg = $JSLanguage['messages']['msg26'];

	mosRedirect('index2.php?option=' . $option . '&amp;task=' . $task, $msg);
}	

function processTldLookUp($option)
{
	global $database, $my, $mainframe;
	global $mosConfig_debug;
	global $JSLanguage;

	// get the list of all unresolved nslookup ipaddresses
	$sql = "SELECT ip, id"
		. "\n FROM #__jstats_ipaddresses"
		. "\n WHERE ip = nslookup"
		. "\n AND tld != 'unknown'";		
	$database->setQuery($sql);
	$rows = $database->loadObjectList();
	if ($database->getErrorNum())
	{
		echo $database->stderr();
		return false;
	}

	if ($mosConfig_debug)
	{
		echo 'admin.joomlastats.php [ processTldLookUp ]<br />';
		echo 'query:<br />' . $sql . '<br />';
		print_r($rows);
		echo '<br/>----------------<br />';
	}

	$n = count($rows);
	if ($n > 0)
	{
		if ($n > 25)
			$n = 25;		

		echo '<div style="color:#FF0000;">' . $JSLanguage['messages']['msg02'] . ': ' . count($rows) . '</div><br /><br />';
		echo "<script type=\"text/javascript\">redirect = true;</script>";

		for ($i=0; $i<$n; $i++)
		{
			$row = &$rows[$i];

			if (substr($row->ip, 0, 3) == '127' || substr($row->ip, 0, 7) == '192.168')
			{
				// mic: no need for a lookup for local addresses ....
				// need to add also:	172.16.0.0 – 172.31.255.255 and 192.168.0.0 – 192.168.255.255
				$nslp	= 'localhost';
				$tld	= 'localhost';
			}
			else
			{
			    $nslp   = strtolower(gethostbyaddr($row->ip));
				$arr    = explode('.', $nslp);
				$tld    = end($arr);

                if (!ereg('([a-zA-Z])', $tld))
                        $tld = 'unknown';
                        
                // following code block inserted by slako
                if ($tld === '' || $tld === 'eu' || strlen($tld) > 2)
                {
                    $sql = "SELECT country_code2 FROM #__jstats_iptocountry ".
                           "WHERE inet_aton('$row->ip') >= ip_from AND inet_aton('$row->ip') <= ip_to";
                    $database->setQuery($sql);                    
                    $country_code2 = $database->loadResult();
        
                    if ($country_code2)
                    	$tld = strtolower($country_code2);                    
                }                
			}

			$query = "UPDATE #__jstats_ipaddresses"
				   . "\n SET tld=". $database->Quote( $tld ) .", nslookup=". $database->Quote($nslp)
				   . "\n WHERE id = ". $row->id;
			$database->setQuery($query);
			if (!$database->query())
			{
				echo "<script type=\"text/javascript\">alert('".$database->getErrorMsg()."');</script>\n";
				exit();
			}
			echo '<div>' . $row->ip . '&nbsp;&nbsp;-->&nbsp;&nbsp;' . $tld . '&nbsp;&nbsp;-->&nbsp;&nbsp;' . $nslp . '</div>';
		}
	
		if ($n != 25)
		{
			$query = "UPDATE #__jstats_ipaddresses"
					. "\n SET tld = ''"
					. "\n WHERE tld = 'unknown'";
			$database->setQuery( $query );
			if (!$database->query())
			{
				echo "<script type=\"text/javascript\">alert('".$database->getErrorMsg()."');</script>\n";
				exit();
			}
			echo "<script type=\"text/javascript\">redirect = false;</script>";
			echo "<script type=\"text/javascript\">alert('"
					. $JSLanguage['messages']['msg03']
					. "');document.location.href='index2.php?option=com_joomlastats';</script>\n";
		}

		echo "<script type=\"text/javascript\">function urlredirect(redirect){if(redirect == true){document.location.href='index2.php?option=com_joomlastats&task=tldlookup';}}</script>\n";
    	echo "<script type=\"text/javascript\">setTimeout('urlredirect(redirect)',2000);</script>\n";
	} else {
		$msg = $JSLanguage['messages']['msg21'];
		mosRedirect( 'index2.php?option=' . $option . '&amp;task=stats', $msg );
	}
}
?>