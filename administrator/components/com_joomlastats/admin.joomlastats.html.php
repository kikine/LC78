<?php
/**
 * @version $Id: admin.joomlastats.html.php 196 2007-03-18 23:59:17Z RoBo $
 * @package com_joomlastats
 * @copyright Copyright (C) 2004-2007 JoomlaStats Team. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
 */
	
// ensure this file is being included by a parent file
defined('_VALID_MOS') or die ('Direct Access to this location is not allowed.');
	
define( '_JSImagePathTLD', $mosConfig_live_site . '/components/com_joomlastats/images/tld/' );
	
class JoomlaStats_Engine
{		
	var $d = null; 				// day
	var $m = null; 				// month
	var $y = null; 				// year
	var $dom = null; 			// domain
	var $vid = null; 			// visitors id
	var $updatemsg= null;		// update message used for purge
	var $language = null;		// language setting
	var $hourdiff = null;		// hourdiff local vs server
	var $onlinetime = null;		// time online in minutes before new visitor
	var $startoption = null;	// option for starting statistics
	var $purgetime = null;		// time for purge database
	var $enable_i18n = false;	// enable Joom!Fish i18n support
	var $enable_whois = false;	// enable Whois queries
	var $version = null;		// version of script
	var $MainFrame = null;		// mainframe object MOS
	var $task = null;			// task for JoomlaStats_Engine
	var $absolute_path = null;	// Joomla ajustment because the _config function is not
								// included in the mainframe class any more
	var $db = null;
	
	var $show_bu		= false;// new mic: show statistic inclusive backuped values
	var $last_purge		= NULL;	// last purge date - set by the system after purge
	
	// internal
	var $add 			= array(); // holds purged datas
	var $add_dstyle		= '<span style="font-weight:normal; font-style:italic; color:#007BBD">%s</span>';	// style 4 detail view
	var $add_style		= '&nbsp;<span style="font-weight:normal; font-style:italic;">[ %s ]</span>';		// style 4 summary view
	
	
	
		
	function JoomlaStats_Engine(&$mainframe, $task)
	{
		global $mosConfig_offset, $mosConfig_absolute_path, $mosConfig_db, $mosConfig_dbprefix, $database;
		global $monthShort, $monthLong;
		global $JSLanguage, $jslang;
 
		$this->MainFrame = &$mainframe;			
		$this->absolute_path = $mosConfig_absolute_path;
		$this->db = $mosConfig_db;			
		$this->task = $task;

		$sql = "SELECT * FROM #__jstats_configuration";			
		$database->setQuery($sql);			
		$rows = $database->loadAssocList();
	
		$this->hourdiff = $mosConfig_offset;

		foreach ($rows AS $row)
		{	
			if ($row['description'] == 'onlinetime')	
				$this->onlinetime = $row['value'];
				
			if ($row['description'] == 'startoption')	
				$this->startoption = $row['value'];
			
			if ($row['description'] == 'language')		
				$this->langini = $row['value'];
			
			if ($row['description'] == 'purgetime')		
				$this->purgetime = $row['value'];
			
			if ($row['description'] == 'enable_whois')	
				$this->enable_whois = ($row['value'] === 'true') ? true : false;
			
			if ($row['description'] == 'enable_i18n')	
				$this->enable_i18n = ($row['value'] === 'true' ? true : false);
			
			if ($row['description'] == 'version')		
				$this->version = $row['value'];			
				
			if ($row['description'] == 'show_bu' ) 
				$this->show_bu = ( $row['value'] === 'true' ? true : false );
			
			if ($row['description'] == 'last_purge' )
					$this->last_purge = $row['value'];
		}		

		// setting for displaying purged datas
		if ($this->show_bu && $this->last_purge) 
				define('_JS_SHOW_PDATA', 1);		

	
		// RB: Language possibilities: 
		// 		* Auto -> check if we can detect Joomla language
		//		* defined in cfg -> use it
		 
		$langPath = $mosConfig_absolute_path .'/administrator/components/com_joomlastats/language/';
		
		if ($this->langini != 'auto')	// if language is not equal to auto then it is considered to be defined -> just use it. 
		{
		    $langfile = $langPath . $this->langini . ".admin.ini.php";
			if (file_exists($langfile))	// do extra check			
                   $JSLanguage = parse_ini_file($langfile, true);	// file should exist
            else
            {	// otherwise use en language file
				$JSLanguage = parse_ini_file($langPath . 'en.admin.ini.php', true);				
				echo $JSLanguage['instal']['inst09'] ." $langfile ". $JSLanguage['instal']['inst10'] ." 'en.admin.ini.php'<br />";
				echo $JSLanguage['instal']['inst11'] ."<br /><br />";           
            }
		}
		else	// language is set to auto, lets check what the user would like...
		{
			if (defined('_A_LANG'))				// in case there is a admin language defined - yes! this happens sometimes ;-)
		    	$jslang = strtolower(_A_LANG);
			elseif (defined('_LANGUAGE'))
	    		$jslang = strtolower(_LANGUAGE);
			else 
	    		$jslang = 'en';	
	    		
	    	$jslang = str_replace(" ", "", $jslang);	// if there is no language value defined in the Joomla language file
	    	if ($jslang == "")
				$jslang = 'en';							// then just use en language
			
			$langfile = $langPath . $jslang .'.admin.ini.php';
			if (file_exists($langfile))
	    		$JSLanguage = parse_ini_file($langfile, true);
			else
			{
	    		$JSLanguage = parse_ini_file($langPath .'en.admin.ini.php', true);    			
    			echo $JSLanguage['instal']['inst09'] ." $langfile ". $JSLanguage['instal']['inst10'] ." 'en.admin.ini.php'<br />";
				echo $JSLanguage['instal']['inst11'] ."<br /><br />";
			}		
		}	
		
		
		$this->SetDMY2Now();
				
		if (isset($_POST['dom']))	
			$this->dom = $_POST['dom'];
		else	
			$this->dom = '%';		

		if (isset($_POST['vid']))	
			$this->vid = $_POST['vid'];
		else	
			$this->vid = '';		
		
		// new by mic
		$monthShort = array( '', substr( $JSLanguage['months']['m01'], 0, 3 ), substr( $JSLanguage['months']['m02'], 0, 3 ), substr( $JSLanguage['months']['m03'], 0, 3 ), substr( $JSLanguage['months']['m04'], 0, 3 ), substr( $JSLanguage['months']['m05'], 0, 3 ), substr( $JSLanguage['months']['m06'], 0, 3 ), substr( $JSLanguage['months']['m07'], 0, 3 ), substr( $JSLanguage['months']['m08'], 0, 3 ), substr( $JSLanguage['months']['m09'], 0, 3 ), substr( $JSLanguage['months']['m10'], 0, 3 ), substr( $JSLanguage['months']['m11'], 0, 3 ), substr( $JSLanguage['months']['m12'], 0, 3 ) );		
		$monthLong  = array( '', $JSLanguage['months']['m01'], $JSLanguage['months']['m02'], $JSLanguage['months']['m03'], $JSLanguage['months']['m04'], $JSLanguage['months']['m05'], $JSLanguage['months']['m06'], $JSLanguage['months']['m07'], $JSLanguage['months']['m08'], $JSLanguage['months']['m09'], $JSLanguage['months']['m10'], $JSLanguage['months']['m11'], $JSLanguage['months']['m12'] );            						
	}
		
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////		
	
	function JS_Compat()
	/* define CMS product and release
     * return 	bool
     * needed for some functions implemented by the CMS after a special release! (e.g. database calls w/ parameters)
     */
	{
		global $_VERSION;

		if ($_VERSION->PRODUCT == 'Joomla' && $_VERSION->RELEASE >= '1.0' && $_VERSION->DEV_LEVEL > '10')
			return true;
		else		
			return false;
	}
		
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		
		
	function PercentBar($percent,$maxpercent)
	/*
	 *	Displays a percentage bar
 	 */	
	{	
		global $mosConfig_live_site, $option;
	
		$baron= "$mosConfig_live_site/administrator/components/$option/images/bar+.gif";
		$baroff="$mosConfig_live_site/administrator/components/$option/images/bar-.gif";
		$barmaxlength = 150;

		$barlength = (int) ($percent / $maxpercent * $barmaxlength);
		$barrest = ($barmaxlength-$barlength);

		// draw the filled bar
		$retvar = "<img border='0' src='$baron' width='$barlength' height='7' alt='&nbsp;'/>";
		// if there is non-filled bar to draw do so...
		if ($barrest>0)
			$retvar .="<img border='0' src='$baroff' width='$barrest' height='7' alt='&nbsp;'/>";

		return $retvar;
	}

	////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		
	function SetDMY2Now()
	/*
	 * Function to set $this->d; $this->m; $this->y values to now
	 * calculate time diff from server time to local time
	 */
	{	
		$visittime = (time() + ($this->hourdiff * 3600));					
		
		if (!isset($_POST['d']))
			$this->d = date('j',$visittime);
		else
			$this->d = $_POST['d'];
		
		if (!isset($_POST['m']))
			$this->m = date('n',$visittime);
		else
			$this->m = $_POST['m'];
			
		if (!isset($_POST['y']))
			$this->y = date('Y',$visittime);
		else
			$this->y = $_POST['y'];
	} 
		
	
		
	function CreateDayCmb()
	/*
	 *  Create the Day Combo
	 */
	{
		global $JSLanguage;
			
		//echo '<option value="total"'
//			. ( $this->d == 'total' ? ' selected="selected"' : '' )
			//. '>' . $JSLanguage['miscellaneous']['misc99'] . '</option>' . "\n";
			
		for ($i=1; $i<=31; $i++)
		{
			if ($this->d != $i)
				echo "<option value=\"$i\">".$i."</option>\n";
			else
				echo "<option selected value=\"$i\">".$i."</option>\n";
		}
		
		if ($this->d == "total" || $this->d == "%")
			echo "<option selected value='total'>". $JSLanguage['miscellaneous']['misc99'] ."</option>";
	}

	function CreateMonthCmb()
	{
		global $JSLanguage, $monthShort;
			
		//$a = array('','Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec');
			
//			echo '<option value="total"'
			//. ( $this->m == 'total' ? ' selected="selected"' : '' )
			//. '>' . $JSLanguage['miscellaneous']['misc99'] . '</option>' . "\n";
			
		for ($i=1; $i<13; $i++)
		{
			if ($this->m != $i)
				//echo "<option value=\"$i\">".$a[$i]."</option>\n";
				echo "<option value=\"$i\">".$monthShort[$i]."</option>\n";				
			else
				echo "<option selected value=\"$i\">".$monthShort[$i]."</option>\n";
		}
			
		if ($this->m == "total")			
			echo "<option selected value='total'>". $JSLanguage['miscellaneous']['misc99'] ."</option>";
	}

	function CreateYearCmb()
	{
		global $JSLanguage, $task, $mosConfig_debug;
		
		if ($mosConfig_debug) 
		{	?>
			<script>alert('before <?php echo 'task: ' . $task; ?>' + ' | ' + '<?php echo 'year: ' . $this->y; ?>'  + ' | ' + '<?php echo 'month: ' . $this->m; ?> ' + ' | ' + '<?php echo 'day: ' . $this->d; ?>');</script>
			<?php
		}
		
		// mic: selecting automatically the actual month AND year - otherwise no datas are shown if nothing selected
//		if (( $this->y == '%' || $this->y == $JSLanguage['miscellaneous']['misc99']) && ( $this->d == '%' || $this->d == $JSLanguage['miscellaneous']['misc99']) && ( $this->m == '%' || $this->m == $JSLanguage['miscellaneous']['misc99']) )
//		{
//			$this->m = date( 'n' );
//			$this->y = date( 'Y' );
//		}

		if ($mosConfig_debug)
		{	?>
			<script>alert('after <?php echo 'task: ' . $task; ?>' + ' | ' + '<?php echo 'year: ' . $this->y; ?>'  + ' | ' + '<?php echo 'month: ' . $this->m; ?> ' + ' | ' + '<?php echo 'day: ' . $this->d; ?>');</script>
			<?php
		}
		
		// have to create total '-' option for year also, but then we should add a warning for some tables...
		// Mic has made the solution to overcome the warning (Joomla pages)
		// echo "<option selected value='total'>". $JSLanguage['miscellaneous']['misc99'] ."</option>";
		if ($this->y == "total")			
			echo "<option selected value='total'>". $JSLanguage['miscellaneous']['misc99'] ."</option>";
			
		//echo '<option value="total"'
//			. ( $this->y == 'total' ? ' selected="selected"' : '' )
			//. '>' . $JSLanguage['miscellaneous']['misc99'] . '</option>' . "\n";
		
//		for ($i=2003;$i <= date('Y',time());$i++)
		for ($i=date('Y',time()); $i>=2003; $i--)
		{
			if ($this->y != $i)
				echo "<option value=\"$i\">$i</option>\n";
			else
				echo "<option selected value=\"$i\">$i</option>\n";
		}
	}

	function SetConfiguration()
	{
		global $database, $JSLanguage;
			
		$onlinetime = isset($_POST['onlinetime']) ? $_POST['onlinetime'] : '15';
		$startoption = isset($_POST['startoption']) ? $_POST['startoption'] : '002';
		$language = isset($_POST['language']) ? $_POST['language'] : 'en';
		$timelimit = isset($_POST['timelimit']) ? $_POST['timelimit'] : '30';
		$enable_whois = isset($_POST['enable_whois']) ? $_POST['enable_whois'] : false;
		$enable_i18n = isset($_POST['enable_i18n']) ? $_POST['enable_i18n'] : false;
		$show_bu		= isset( $_POST['show_bu'] ) 		? $_POST['show_bu'] 		: false;
			
		$query = "UPDATE #__jstats_configuration"
			. "\n SET value = '$onlinetime'"
			. "\n WHERE description = 'onlinetime'";
		$database->setQuery( $query );
		if (!$database->query())
		{
			echo "<script> alert('".$database->getErrorMsg()."'); window.history.go(-1); </script>\n";
			exit();
		}

		$query = "UPDATE #__jstats_configuration"
			. "\n SET value='$startoption'"
			. "\n WHERE description='startoption'";
		$database->setQuery( $query );
		if (!$database->query())
		{
			echo "<script> alert('".$database->getErrorMsg()."'); window.history.go(-1); </script>\n";
			exit();
		}

		$query = "UPDATE #__jstats_configuration"
			. "\n SET value='$language'"
			. "\n WHERE description='language'";
		$database->setQuery($query);
		if (!$database->query())
		{
		        echo "<script> alert('".$database->getErrorMsg()."'); window.history.go(-1); </script>\n";
                exit();
		}

		$query = "UPDATE #__jstats_configuration"
			. "\n SET value='$timelimit'"
			. "\n WHERE description='purgetime'";
		$database->setQuery( $query );
		if (!$database->query())
		{
			echo "<script> alert('".$database->getErrorMsg()."'); window.history.go(-1); </script>\n";
			exit();
		}

		$query = "UPDATE #__jstats_configuration"
			. "\n SET value='" . ( $enable_whois ? 'true' : 'false' ) ."'"
			. "\n WHERE description='enable_whois'";
		$database->setQuery( $query );
		if (!$database->query())
		{
		        echo "<script> alert('".$database->getErrorMsg()."'); window.history.go(-1); </script>\n";
                exit();
        }

		$query = "UPDATE #__jstats_configuration"
			. "\n SET value='" . ( $enable_i18n ? 'true' : 'false' ) . "'"
			. "\n WHERE description='enable_i18n'";
		$database->setQuery( $query );
		if (!$database->query())
		{
		        echo "<script> alert('".$database->getErrorMsg()."'); window.history.go(-1); </script>\n";
                exit();
        }

        $query = "UPDATE #__jstats_configuration"
			. "\n SET value='" . ( $show_bu ? 'true' : 'false' ) . "'"
			. "\n WHERE description='show_bu'";
			$database->setQuery( $query );
		if (!$database->query())
		{
		    echo "<script> alert('".$database->getErrorMsg()."'); window.history.go(-1); </script>\n";
			exit();
        }

		$msg = $JSLanguage['messages']['msg07'];
		mosRedirect( 'index2.php?option=com_joomlastats&amp;task=getconf', $msg );				
	}

	function getdbversion()
	{
		echo $this->version;
	}
		
	function getdbsize()
	{
		global $database;

		$sql = "SHOW TABLE STATUS FROM `".$this->db."` LIKE '".$this->MainFrame->getCfg('dbprefix')."jstats_%'";
		$database->setQuery($sql);
		$rows = $database->LoadObjectList();
		
		$total = 0;
		foreach ($rows AS $row)
		{
			$total += $row->Data_length + $row->Index_length;
		}

		$color = 'Green';
		if (($total > '10000000') && ($total <= '30000000'))
			$color = 'Blue';		
		if ($total > '30000000') 
			$color = 'Red';

		//while ($row = @mysql_fetch_array($rs))
		//{
			// echo $row['Data_length'] + $row['Index_length'] ."<br>";
			//$total += $row['Data_length'] + $row['Index_length'];
		//}
				
//		echo round((($total/1024)/1024),1);		
		echo '<span style="color:' . $color . '">' . round((($total/1024)/1024), 2) . '</span>';			
	}
	
		
	function resetVar($opt)
	/*
	 * resets/changes date vars for database access
	 * @param	opt		int
	 * $opt=0: set dmy to text 'total');
	 * $opt=1: set dmy to '%' in order to perform database querry
	*/		 
	{
		global $JSLanguage;
		
		if ($opt == 1)
		{
			if ($this->d == "total")	{$this->d = '%';}
			if ($this->m == "total")	{$this->m = '%';}
			if ($this->y == "total")	{$this->y = '%';}
		}
		else
		{
			if ($this->d == '%')	{$this->d = "total";}
			if ($this->m == '%')	{$this->m = "total";}
			if ($this->y == '%')	{$this->y = "total";}
		}			
	}
		
				
	function menu()
	/*
	 *   Display the menu lines
	 */
	{	
		global $JSLanguage;
		
		$n = NULL;
			
		echo '<table width="100%" border="0" cellpadding="2" cellspacing="0">';
		echo '<tr>';
		echo '<td width="10">&nbsp;</td>';	// leave a little whitespace on the left
		 
		while (list($id, $description) = each($JSLanguage['menu']))
		{
			$n++;
			if (strlen($id) == 3)
			{ // we hit a menu item (not an empty line for example)
			  
			  if (($n!=1) && (($n-1) % 6 == 0))			  			  	  		
			  {	// We just started a new line and we have some items left, so start a new line
			  	echo "<tr><td width='10'>&nbsp;</td>";	// start with same whitespace on the left
			  }				  
				  
			  echo '<td>';				  				  
				// echo "<a href=\"index2.php?option=com_joomlastats&task=$id&d=".$this->d."&m=".$this->m."&y=".$this->y."\">$description</a>";
				echo "<a href=\"javascript:submitbutton('".$id."')\">$description</a>";
				echo '</td>';

				if ($n % 6 == 0)
				{	// CR
					echo "<td>&nbsp;</td>";									// leave a little whitespace on the right
					echo '</tr>' . "\n";									// end the line						
				}
			}
		}
		if ($n % 6 != 0)		
			echo "</tr>\n";	// if we didn't just finish the row than do it now.
		echo  "</table>\n";
	}
		
	function DisplayTitle()
	/*
	 *  display menu title (optional with $this->dom)
	 */
	{
		global $JSLanguage;
 

		if (strlen($this->task) == 3)
		{
			echo $JSLanguage['menu'][$this->task];
//			if ($this->dom != '' && $this->dom != '%')
//				echo "&nbsp;&nbsp;&lt;&nbsp;$this->dom&nbsp;&gt;";
		}
		else
		{
			echo $JSLanguage['extra'][$this->task];
			
//			if ($this->dom != '' && $this->dom != '%')
//				echo "&nbsp;&nbsp;&lt;&nbsp;$this->dom&nbsp;&gt;";
		}
		if ($this->dom != '' && $this->dom != '%')
		{
			echo "&nbsp;&nbsp;&lt;&nbsp;$this->dom&nbsp;&gt;";
		}
	} 


	////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	function Buid()
	/*
	 * returns first id from actual table page_request for checking inside page_request_c
	 * used where queries should be done and result is shown/included with purged data
	 */
	{
		global $database;

		$buid = 0;

		$query = "SELECT MIN(a.ip_id)"
           . "\n FROM #__jstats_page_request AS a"
           . "\n LIMIT 1";
		$database->setQuery( $query );
		
		return $database->loadResult();
	}
		
		
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////		
	
	
	function JS_order($view, $type)
	/*
	 *	builds an order UP/DOWN button
	 *	@param	view	string	which task to perform
	 *	@param	type	string	up/down
	 */
	{
		global $mosConfig_live_site, $JSLanguage;

		if ($type == 'up')
		{
			$type	= $JSLanguage['miscellaneous']['misc33'];
			$JS_img = 'uparrow0.png';
		}else{
			$type	= $JSLanguage['miscellaneous']['misc34'];
			$JS_img = 'downarrow0.png';
		}

		$JS_order_img_path = '<img src="'.$mosConfig_live_site.'/administrator/images/';

        $JS_order = '<a href="index2.php?option=com_joomlastats&amp;task=r04&amp;' . $view . '=%s'
            . '&amp;d='. $this->d . '&amp;m=' . $this->m . '&amp;y=' . $this->y
            . '" title="' . $type . '">'
            . $JS_order_img_path . $JS_img . '" width="12" height="12" border="0"'
            . ' alt="' . $type . '"/>'
            . '</a>';

        return $JS_order;
	}
        	
		
		 
		
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		
				
		
	function ysummary()
	/*
	 *	case r02
	 */
	{
		global $database, $JSLanguage, $monthShort;
		
		$where = array();
		
		if ($this->y == "%")
		{
			$visittime = (time() + ($this->hourdiff * 3600));
			$this->y = date('Y',$visittime);
			
			$retval = '<div style="text-align:center">'. $JSLanguage['messages']['msg27'] .': '. $this->y .'</div>';			
		}
		else
			$retval = "";	// to make $retval .= possible next time
			
		$retval .= '<table class="adminlist" cellspacing="0" width="100%"><tr>';
		$retval .= '<th align="center" nowrap="nowrap">' . $JSLanguage['tableheaders']['t02'] . '</th>';
		$retval .= '<th align="center" nowrap="nowrap" colspan="2">' . $JSLanguage['tableheaders']['t03'] . '</th>';
		$retval .= '<th align="center" nowrap="nowrap" colspan="2">' . $JSLanguage['tableheaders']['t04'] . '</th>';
		$retval .= '<th align="center" nowrap="nowrap" colspan="2">' . $JSLanguage['tableheaders']['t05'] . '</th>';
		$retval .= '<th align="center" nowrap="nowrap" colspan="2">' . $JSLanguage['tableheaders']['t08'] . '</th>';
		$retval .= '<th align="center" nowrap="nowrap">' . $JSLanguage['tableheaders']['t09'] . '</th>';
		$retval .= '<th align="center" nowrap="nowrap" colspan="2">' . $JSLanguage['tableheaders']['t06'] . '</th>';
		$retval .= '<th align="center" nowrap="nowrap" colspan="2">' . $JSLanguage['tableheaders']['t07'] . '</th>';
		$retval .= '</tr>';			
	
		$v			= 0; // visitor;
		$uv			= 0; // unique visitor
		$b			= 0; // bots
		$ub			= 0; // unique bots
		$p 			= 0; // pages
		$r 			= 0; // referrers
		$tuv		= 0; // total unique visitors
		$tv			= 0; // total visitors
		$tub		= 0; // total unique bots
		$tb			= 0; // total bots
		$tp			= 0; // total pages
		$tr			= 0; // total referrers
		$ppurge		= 0; // purged pages
		$vpurge 	= 0; // purged visitors
		$uvpurge	= 0; // unique visitors purged
		$tuvpurge	= 0; // total unique visitors purged
		$tvpurge	= 0; // total visitors purged
		$tppurge	= 0; // total pages purged
		$bpurge		= 0; // bots purged
		$tbpurge	= 0; // total bots purged
		$ubpurge	= 0; // unique bots purged
		$tubpurge	= 0; // total unique bots purged
			
		$k=0;
		for ($i=1;$i<13;$i++)
		{
			// get visitors
			$this->resetVar(1);
			
			$where = NULL;

			$where[] = "a.type = 1";
			$where[] = "c.month = $i";
			$where[] = "c.year = $this->y";
			
			if (defined('_JS_SHOW_PDATA'))	// mic: show data with purged data
				$where[] = 'a.id = c.ip_id AND c.id >= ' . $this->buid();
                
			$query  = "SELECT count(*)"
				. "\n FROM #__jstats_visits AS c"
				. "\n LEFT JOIN #__jstats_ipaddresses AS a"
				. "\n ON c.ip_id = a.id"
				. ( count( $where ) ? "\n WHERE " . implode( ' AND ', $where ) : "" );
			$this->resetVar(0);
			$database->setQuery( $query );
			$v = $database->loadResult();

			$tv += $v;
			
			
			if (defined('_JS_SHOW_PDATA'))	// include/show purged data
			{
				$where = NULL;

				$where[] = "a.type = 1";
				$where[] = "c.month = $i";
				$where[] = "c.year = $this->y";
				$where[] = 'a.id = c.ip_id AND c.id < ' . $this->buid();

            	$query  = "SELECT count(*)"
                    . "\n FROM #__jstats_visits AS c"
                    . "\n LEFT JOIN #__jstats_ipaddresses AS a"
                    . "\n ON c.ip_id = a.id"
                    . (count( $where ) ? "\n WHERE " . implode(' AND ', $where ) : "" );
				$this->resetVar(0);
            	$database->setQuery( $query );
            	$vpurge = $database->loadResult();

				$vpurge     += $v;
            	$tvpurge	+= $vpurge;
			}              
			
			
			$where = NULL;
						
			$where[] = "a.type = 1";
			$where[] = "c.month = $i";
			$where[] = "c.year = $this->y";


            if (defined('_JS_SHOW_PDATA'))	// mic: show data with purged data
				$where[] = 'a.id = c.ip_id AND c.id >= ' . $this->buid();

			$query  = "SELECT count(*)"
				. "\n FROM #__jstats_visits AS c"
				. "\n LEFT JOIN #__jstats_ipaddresses AS a ON c.ip_id = a.id"
				. ( count( $where ) ? "\n WHERE " . implode( ' AND ', $where ) : "" )
				. "\n GROUP BY c.ip_id";
			$this->resetVar(0);
			$database->setQuery( $query );
			$rows = $database->loadObjectList();

            $uv 	= count( $rows );
			$tuv 	+= $uv;

			if (defined('_JS_SHOW_PDATA'))	// include/show purged data
			{	
                $where = NULL;

                $where[] = "a.type = 1";
				$where[] = "c.month = $i";
                $where[] = "c.year = $this->y";
                $where[] = 'a.id = c.ip_id AND c.id < ' . $this->buid();

                $query  = "SELECT count(*)"
				    . "\n FROM #__jstats_visits AS c"
                    . "\n LEFT JOIN #__jstats_ipaddresses AS a ON c.ip_id = a.id"
                    . ( count( $where ) ? "\n WHERE " . implode( ' AND ', $where ) : "" )
                    . "\n GROUP BY c.ip_id";
                $this->resetVar(0);
				$database->setQuery( $query );
                $rows = $database->loadObjectList();

                $uvpurge 	= count( $rows );
                $uvpurge    += $uv;
                $tuvpurge	+= $uvpurge;
			}

			// get bots
			$this->resetVar(1);

			$where = NULL;

			$where[] = "a.type = 2";
			$where[] = "c.month = $i";
			$where[] = "c.year = $this->y";

			if (defined( '_JS_SHOW_PDATA' ) )	// mic: show only actual data (without already archived/purged)
                    $where[] = 'a.id = c.ip_id AND c.id >= ' . $this->buid();

			$query = "SELECT count(*)"
				. "\n FROM #__jstats_visits AS c"
				. "\n LEFT JOIN #__jstats_ipaddresses AS a ON c.ip_id = a.id"
				. ( count( $where ) ? "\n WHERE " . implode( ' AND ', $where ) : "" );
			$database->setQuery( $query );
			$b = $database->loadResult();

			$this->resetVar(0);

			$tb += $b;

			// get purged bots
			if (defined('_JS_SHOW_PDATA'))
			{
                    $this->resetVar(1);

                    $where = NULL;

                    $where[] = "a.type = 2";
                    $where[] = "c.month = $i";
                    $where[] = "c.year = $this->y";
                    $where[] = 'a.id = c.ip_id AND c.id >= ' . $this->buid();

                    $query = "SELECT count(*)"
                    	. "\n FROM #__jstats_visits AS c"
                    	. "\n LEFT JOIN #__jstats_ipaddresses AS a ON c.ip_id = a.id"
                    	. ( count( $where ) ? "\n WHERE " . implode( ' AND ', $where ) : "" );
                    $database->setQuery( $query );
                    $bpurge = $database->loadResult();

                    $this->resetVar(0);

                    $tbpurge += $bpurge;
                    $tbpurge += $b;
                }

				// get Unique bots
				$this->resetVar(1);

				$where = NULL;
				$where[] = "a.type = 2";
				$where[] = "c.month = $i";
				$where[] = "c.year = $this->y";

				$query = "SELECT count(*)"
					. "\n FROM #__jstats_visits AS c"
					. "\n LEFT JOIN #__jstats_ipaddresses AS a ON c.ip_id = a.id"
					. ( count( $where ) ? "\n WHERE " . implode( ' AND ', $where ) : "" )
					. "\n GROUP BY a.browser";
				$this->resetVar(0);
				$database->setQuery( $query );
				$rows = $database->loadObjectList();

                $ub		= count( $rows );
				$tub 	+= $ub;

				// get purged Unique bots
				if (defined('_JS_SHOW_PDATA'))
				{
				    $this->resetVar(1);

                    $where = NULL;
                    $where[] = "a.type = 2";
                    $where[] = "c.month = $i";
                    $where[] = "c.year = $this->y";
                    $where[] = 'a.id = c.ip_id AND c.id >= ' . $this->buid();

                    $query = "SELECT count(*)"
                    	. "\n FROM #__jstats_visits AS c"
                    	. "\n LEFT JOIN #__jstats_ipaddresses AS a ON c.ip_id = a.id"
                    	. ( count( $where ) ? "\n WHERE " . implode( ' AND ', $where ) : "" )
                    	. "\n GROUP BY a.browser";
                    $this->resetVar(0);
                    $database->setQuery( $query );
                    $rows = $database->loadObjectList();

                    $ubpurge	= count( $rows );
                    $tubpurge	+= $ubpurge;
                    $tubpurge	+= $ub;
                }

				// get Pages
				$this->resetVar(1);

				$query = "SELECT count(*)"
					. "\n FROM #__jstats_page_request"
					. "\n WHERE month = $i"
					. "\n AND year = $this->y";
				$database->setQuery( $query );
				$p = $database->loadResult();

				$this->resetVar(0);

				// $tp += $p; // mic: see below

				// purged pages
                $this->resetVar(1);

                $query = "SELECT sum(count)"
                	. "\n FROM #__jstats_page_request_c"
                	. "\n WHERE month = $i"
                	. "\n AND year = $this->y";
                $database->setQuery( $query );
                $ppurge = $database->loadResult();

                $this->resetVar(0);

                if (defined('_JS_SHOW_PDATA'))
                {
                    $ppurge     += $p;
                    $tppurge    += $ppurge;
                }else{
                    $p += $ppurge;
                }

				$tp += $p; // mic: see above

				// get Referrers
				$this->resetVar(1);

				$query = "SELECT count(*)"
					." \n FROM #__jstats_referrer"
					. "\n WHERE month = $i"
					. "\n AND year = $this->y";
				
				$database->setQuery( $query );
				$r = $database->loadResult();
				$this->resetVar(0);
				$tr += $r;

				if (defined('_JS_SHOW_PDATA'))
				{
					$add = NULL;
				    if ($uvpurge)
                        $add['uvpurge'] = sprintf($this->add_dstyle, $uvpurge);                    
                    if ($vpurge)
				        $add['vpurge'] = sprintf($this->add_dstyle, $vpurge);                    
                    if ($ppurge)
				        $add['ppurge'] = sprintf($this->add_dstyle, $ppurge);                    
                    if ($bpurge)
				        $add['bpurge'] = sprintf($this->add_dstyle, $bpurge);                    
                    if ($ubpurge)
				        $add['ubpurge'] = sprintf($this->add_dstyle, $ubpurge);                    
                }


				// Now we have all data, let's show the lines of each month
				
				$retval .= '<tr class="row' . $k . '">'
				. "<td align='center'>$monthShort[$i]</td>"
				
				. "<td align='right'>"	. ($uv ? $uv : ".") . "</td>"
				. "<td align='left'>" . (!empty( $add['vpurge']) ? $add['vpurge'] : '&nbsp;' ). '</td>'
				
				. "<td align='right'>". ($v  ? $v  : ".") . "</td>"
				. "<td align='left'>". (!empty($add['uvpurge']) ? $add['uvpurge'] : '&nbsp;' ) . '</td>'
				
				. '<td align="center">';
				if (($uv != 0) && ($v != 0)) 
					$retval .= number_format(round(($v/$uv), 1), 1);
				else
					$retval .= '.';					
				$retval .= '</td><td>';
				if (($uvpurge != 0) && ($vpurge != 0)) 
					$retval .= sprintf($this->add_dstyle, number_format(round(($vpurge/$uvpurge), 1), 1));
				else
					$retval .= '&nbsp;';					
				$retval .= '</td>'
				
				. '<td align="center">' . ( $p ? $p : '.' ) . ' ' . '</td>'
				. '<td>' . (!empty($add['ppurge']) ? $add['ppurge'] : '' ) . '</td>'
				
				. '<td align="center">' . ( $r ? $r : '.' ). '</td>'
				
				. '<td align="center">' . ( $ub ? $ub : '.' ) . ' ' . '</td><td>'
				
				. ( !empty( $add['ubpurge'] ) ? $add['ubpurge'] : '' ) . '</td>'
				
				. '<td align="center">' . ( $b ? $b : '.' ) . ' ' . '</td><td>'
				
				. ( !empty( $add['bpurge'] ) ? $add['bpurge'] : '' ). '</td>'
				
				. '</tr>' . "\n";

				$k = 1 - $k;
			}

            if (defined('_JS_SHOW_PDATA'))
            {
				if ($tuvpurge)
					$add['tuvpurge'] =	sprintf($this->add_style, $tuvpurge);				
				if ($tppurge)
					$add['tppurge'] =	sprintf($this->add_style, $tppurge);				
				if ($tvpurge)
					$add['tvpurge'] =	sprintf($this->add_style, $tvpurge);				
				if ($tbpurge)
					$add['tbpurge'] =	sprintf($this->add_style, $tbpurge);				
				if ($tubpurge)
					$add['tubpurge'] =	sprintf($this->add_style, $tubpurge);				
			}
			
			
			
			
			
			
			
			// re-work coding of next part:
						
			// Get the values for the totals line
			
			// somewhere before this next block of code also tuv is calculated (wrongly)
			// get Total Unique visitors for complete month
			$this->resetVar(1);
			$sql  = "SELECT count(*) FROM `#__jstats_visits` LEFT JOIN `#__jstats_ipaddresses` ON (#__jstats_visits.ip_id=#__jstats_ipaddresses.id) ";
			$sql .= "WHERE #__jstats_ipaddresses.type=1 and #__jstats_visits.year=$this->y ";
			$sql .= "group by #__jstats_visits.ip_id";
			$this->resetVar(0);
			$database->setQuery($sql);			
			$rs = mysql_query($database->_sql);
			$tuv = mysql_num_rows($rs);
			if ($tuv == null)	
				$tuv = 0;	
			
											
						
			// Display the totals line		
					
			$retval .= '<tr>'
			// Month
			. '<th align="center">' . $this->y . '</th>'
			// Unique visitors
			. '<th align="right">'. $tuv .'</th>'
			. '<th align="left">'. (!empty($add['tuvpurge']) ? $add['tuvpurge'] : "&nbsp;") ."</th>"			
			// Number of visits
			. '<th align="right">'. $tv .'</th>' 
			. "<th align='left'>". (!empty($add['tvpurge']) ? $add['tvpurge'] : "&nbsp;") . '</th>'
			// Visits average
			. '<th align="center">';			
			if (($tuv!=0) && ($tv!=0))
				$retval .= number_format(round(($tv/$tuv), 1), 1);
			else
				$retval .= "0.0";			
			$retval .= "</th><th align='left'>";
			if (($tuvpurge != 0) && ($tvpurge != 0 ))
				$retval .= $add['tvpurge'] = sprintf($this->add_style, number_format(round(($tvpurge/$tuvpurge), 1) , 1));
			else
				$retval .= '';								
			$retval .= "</th>";
			// Pages
			$retval .= '<th align="center">'. $tp ."</th>" 
			. "<th align='center'>". (!empty( $add['tppurge'] ) ? $add['tppurge'] : '&nbsp;' ) . '</th>'
			// Referrers
			. '<th align="center">'. $tr .'</th>'
			// Unique bots
			. '<th align="center">'. $tub ."</th>"
			. "<th align='center'>". (!empty($add['tubpurge']) ? $add['tubpurge'] : '&nbsp;') . '</th>'
			// Number of bots
			. '<th align="center">'. $tb ."</th>"
			. "<th align='center'>". (!empty($add['tbpurge'])  ? $add['tbpurge'] : '&nbsp;')  .'</th>'
			
			. '</tr>' . "\n"
			. '</table>' . "\n";			
			return $retval;
		}
		



		/////////////////////////////////////////////////////////////////////////////////////////






	function msummary()
	/*
	 * case r02
	 */
	{
		global $database, $monthShort, $monthLong, $JSLanguage;
		
		$where = array();
			
		if ($this->m == "%")			// user selected whole month ('-')
		{							
			$visittime = (time() + ($this->hourdiff * 3600));
			$this->m = date('n',$visittime);				
		
			$retval = '<div style="text-align:center">'	. $JSLanguage['messages']['msg04'] .': '. $monthLong[$this->m] .'</div>';
		}
		else
			$retval = "";	// to be able to .= the next retval
			
		if ($this->y == "%")
		{
			$visittime = (time() + ($this->hourdiff * 3600));
			$this->y = date('Y',$visittime);
			
			$retval .= '<div style="text-align:center">'. $JSLanguage['messages']['msg27'] .': '. $this->y .'</div>';			
		}

		$dm = array(0,31,28 + date('L',mktime(0,0,0,(int)$this->m,(int)$this->d,(int)$this->y)),31,30,31,30,31,31,30,31,30,31);
			
		$retval .= '<table class="adminlist" cellspacing="0" cellpadding="0" width="100%"><tr>';
		
		$retval .= '<th align="center" nowrap>'. $JSLanguage['tableheaders']['t01'] .'</th>';					// day
		$retval .= '<th align="center" colspan="2"	nowrap>'. $JSLanguage['tableheaders']['t03'] .'</th>';	// unique visitor
		$retval .= '<th align="center" colspan="2"	nowrap>'. $JSLanguage['tableheaders']['t04'] .'</th>';	// number of visits
		$retval .= '<th align="center"				nowrap>'. $JSLanguage['tableheaders']['t05'] .'</th>';	// visits average
		$retval .= '<th align="center" colspan="2"	nowrap>'. $JSLanguage['tableheaders']['t08'] .'</th>';	// pages
		$retval .= '<th align="center"				nowrap>'. $JSLanguage['tableheaders']['t09'] .'</th>';	// referrers
		$retval .= '<th align="center" colspan="2"	nowrap>'. $JSLanguage['tableheaders']['t06'] .'</th>';	// unique bots
		$retval .= '<th align="center" colspan="2"	nowrap>'. $JSLanguage['tableheaders']['t07'] .'</th>';	// number of bots
		$retval .= '</tr>';
				
		$v 			= 0; // visitors
		$b 			= 0; // bots
		$p			= 0; // pages
		$r			= 0; // referrer
		$ub 		= 0; // unique bots
		$tub		= 0; // total unique bots
		$uv 		= 0; // unique visitors
		$tv 		= 0; // total visitors
		$tuv		= 0; // total unique visitors
		$tb 		= 0; // total bots
		$tp 		= 0; // total pages
		$tr 		= 0; // total referrers
		$ppurge 	= 0; // purged pages
		$tppurge	= 0; // total pages purged
		$vpurge		= 0; // visitor purged
		$tvpurge	= 0; // total visitor purged
		$uvpurge	= 0; // unique visitor purged
		$tuvpurge	= 0; // total unique visitor purged
		$bpurge		= 0; // bots purged
		$tbpurge	= 0; // total bots purged
		$ubpurge	= 0; // unique bots purged
		$tubpurge	= 0; // total unique bots purged
			
		for ($i=1; $i<=$dm[$this->m]; $i++)
		{
			// get Unique visitors
			$this->resetVar(1);
			$where = NULL;
			$where[] = "a.type = 1";
			$where[] = "c.day = $i";
			$where[] = "c.month = $this->m";
			$where[] = "c.year = $this->y";			
			
			if (defined( '_JS_SHOW_PDATA'))
            	$where[] = 'a.id = c.ip_id AND c.id >= ' . $this->buid();
			
			$query  = "SELECT count(*)"
				. "\n FROM #__jstats_visits AS c"
				. "\n LEFT JOIN #__jstats_ipaddresses AS a ON c.ip_id = a.id"
				. ( count( $where ) ? "\n WHERE " . implode( ' AND ', $where ) : "" )
				. "\n GROUP BY c.ip_id";
			$database->setQuery( $query );
			$rows = $database->loadObjectList();

			$uv		= count( $rows );
			$tuv 	+= $uv;

			// include/show purged data
		    if (defined( '_JS_SHOW_PDATA' ))
		    {
				$where = NULL;

                $where[] = "a.type != 2"; // mic: exclude only bots
				$where[] = "c.day = $i";
                $where[] = "c.month = $this->m";
                $where[] = "c.year = $this->y";
                $where[] = 'a.id = c.ip_id AND c.id < ' . $this->buid();

                $query  = "SELECT count(*)"
				    . "\n FROM #__jstats_visits AS c"
                    . "\n LEFT JOIN #__jstats_ipaddresses AS a ON c.ip_id = a.id"
                    . ( count( $where ) ? "\n WHERE " . implode( ' AND ', $where ) : "" )
                    . "\n GROUP BY c.ip_id";
				$database->setQuery( $query );
                $rows = $database->loadObjectList();

                $uvpurge 	= count( $rows );
                $tuvpurge	+= $uvpurge;
                $tuvpurge   += $uv;
			}

			$this->resetVar(0);

			// get visitors
			$this->resetVar(1);
			$where = NULL;
			$where[] = "a.type != 2"; // mic: exclude only bots
			$where[] = "c.day = $i";
			$where[] = "c.month = $this->m";
			$where[] = "c.year = $this->y";
			
			if( defined( '_JS_SHOW_PDATA' ) )
            	$where[] = 'a.id = c.ip_id AND c.id >= ' . $this->buid();
                
			$query = "SELECT count(*)"
				. "\n FROM #__jstats_visits AS c"
				. "\n LEFT JOIN #__jstats_ipaddresses AS a ON c.ip_id = a.id"
				. ( count( $where ) ? "\n WHERE " . implode( ' AND ', $where ) : "" );
			$database->setQuery( $query );
			$v = $database->loadResult();

			$tv += $v;

			// include/show purged data
			if( defined( '_JS_SHOW_PDATA' ) )
			{
            	$where = NULL;
                $where[] = "a.type != 2"; // mic: exclude only bots
				$where[] = "c.day = $i";
				$where[] = "c.month = $this->m";
                $where[] = "c.year = $this->y";
                $where[] = 'a.id = c.ip_id AND c.id < ' . $this->buid();

                $query = "SELECT count(*)"
				    . "\n FROM #__jstats_visits AS c"
                    . "\n LEFT JOIN #__jstats_ipaddresses AS a ON c.ip_id = a.id"
                    . ( count( $where ) ? "\n WHERE " . implode( ' AND ', $where ) : "" );
				$database->setQuery( $query );
                $vpurge = $database->loadResult();

                $tvpurge	+= $vpurge;
                $tvpurge	+= $v;
			}
            $this->resetVar(0);


			// get bots
			$this->resetVar(1);

			$where = NULL;
			$where[] = "a.type = 2";
			$where[] = "c.day = $i";
			$where[] = "c.month = $this->m";
			$where[] = "c.year = $this->y";

			if( defined( '_JS_SHOW_PDATA' ) )
				$where[] = 'a.id = c.ip_id AND c.id >= ' . $this->buid();
                
			$query = "SELECT count(*)"
				. "\n FROM #__jstats_visits AS c"
				. "\n LEFT JOIN #__jstats_ipaddresses AS a ON c.ip_id = a.id"
				. ( count( $where ) ? "\n WHERE " . implode( ' AND ', $where ) : "" );
			$database->setQuery( $query );
			$b = $database->loadResult();












				$this->resetVar(0);

				// include/show purged data
			    if( defined( '_JS_SHOW_PDATA' ) ){
                    $where = NULL;

                    $this->resetVar(1);

                    $where[] = "a.type = 2";
				    $where[] = "c.day = $i";
                    $where[] = "c.month = $this->m";
                    $where[] = "c.year = $this->y";
                    $where[] = 'a.id = c.ip_id AND c.id < ' . $this->buid();

                    $query = "SELECT count(*)"
				    . "\n FROM #__jstats_visits AS c"
                    . "\n LEFT JOIN #__jstats_ipaddresses AS a ON c.ip_id = a.id"
                    . ( count( $where ) ? "\n WHERE " . implode( ' AND ', $where ) : "" )
                	;
				    $database->setQuery( $query );
                    $bpurge = $database->loadResult();

                    $this->resetVar(0);

                    $tbpurge += $bpurge;
                    $tbpurge += $b;
                }

				$tb += $b;

				// get Unique bots
				$this->resetVar(1);

				$where = NULL;

				$where[] = "a.type = 2";
				$where[] = "c.day = $i";
				$where[] = "c.month = $this->m";
				$where[] = "c.year = $this->y";

				if( defined( '_JS_SHOW_PDATA' ) ){
                    $where[] = 'a.id = c.ip_id AND c.id >= ' . $this->buid();
                }

				$query = "SELECT count(*)"
				. "\n FROM #__jstats_visits AS c"
				. "\n LEFT JOIN #__jstats_ipaddresses AS a ON c.ip_id = a.id"
				. ( count( $where ) ? "\n WHERE " . implode( ' AND ', $where ) : "" )
				. "\n GROUP BY a.browser"
				;
				$this->resetVar(0);

				$database->setQuery( $query );
				$rows = $database->loadObjectList();

				$ub = count( $rows );

				// include/show purged data - unique bots
			    if( defined( '_JS_SHOW_PDATA' ) ){
                    $where = NULL;

                    $this->resetVar(1);

                    $where[] = "a.type = 2";
                    $where[] = "c.day = $i";
                    $where[] = "c.month = $this->m";
                    $where[] = "c.year = $this->y";
                    $where[] = 'a.id = c.ip_id AND c.id < ' . $this->buid();

                    $query = "SELECT count(*)"
                    . "\n FROM #__jstats_visits AS c"
                    . "\n LEFT JOIN #__jstats_ipaddresses AS a ON c.ip_id = a.id"
                    . ( count( $where ) ? "\n WHERE " . implode( ' AND ', $where ) : "" )
                    . "\n GROUP BY a.browser"
                    ;
                    $database->setQuery( $query );
                    $rows = $database->loadObjectList();

                    $ubpurge = count( $rows );

                    $tubpurge += $ubpurge;
                    $tubpurge += $ub;

                    $this->resetVar(0);
                }

				$tub += $ub; // new mic

				// get Pages
				$this->resetVar(1);

				$where = NULL;

				$where[] = "day = $i";
				$where[] = "month = $this->m";
				$where[] = "year = $this->y";

				$query = "SELECT count(*)"
				. "\n FROM #__jstats_page_request"
				. ( count( $where ) ? "\n WHERE " . implode( ' AND ', $where ) : "" )
				;
				$this->resetVar(0);

				$database->setQuery( $query );
				$p = $database->loadResult();

				// $tp += $p; // mic_ moved down

				// purged pages
                $this->resetVar(1);

                $where = NULL;

				$where[] = "day = $i";
				$where[] = "month = $this->m";
				$where[] = "year = $this->y";

                $query = "SELECT sum(count)"
                . "\n FROM #__jstats_page_request_c"
                . ( count( $where ) ? "\n WHERE " . implode( ' AND ', $where ) : "" )
                ;
                $database->setQuery( $query );
                $ppurge = $database->loadResult();

                $this->resetVar(0);

                if( defined( '_JS_SHOW_PDATA' ) ){
                    $tppurge    += $p;
                    $tppurge    += $ppurge;
                }else{
                    $p += $ppurge;
                }

                $tp += $p; // mic: see below


				// get Referrers
				$this->resetVar(1);

				$where = NULL;
				$where[] = "day = $i";
				$where[] = "month = $this->m";
				$where[] = "year = $this->y";

				$query = "SELECT count(*)"
				. "\n FROM #__jstats_referrer"
				. ( count( $where ) ? "\n WHERE " . implode( ' AND ', $where ) : "" );				
				$this->resetVar(0);
				$database->setQuery( $query );
				$r = $database->loadResult();

				$tr += $r;



				// now we have all values, now draw the row (day)

				if (date( 'w', strtotime("$this->y-$this->m-$i")) == 6) 
					$cls = 'row0'; // info: background-color: #F9F9F9;
				elseif (date( 'w', strtotime("$this->y-$this->m-$i")) == 0) 
					$cls = 'row2" style="background-color:#efefef; border-bottom: 1px dotted #ff0000';
				else
					$cls = 'row1'; // info: background-color: #F1F1F1;				

				$retval .= '<tr class="' . $cls . '">' . "\n" . '<td align="center">';

				if (strlen($i) == 1)
					$retval .= '0' . $i;
				else
					$retval .= $i;

				if (defined('_JS_SHOW_PDATA'))
				{
					$add = NULL;
				    if ( $vpurge )
                        $add['vpurge'] = sprintf( $this->add_dstyle, $vpurge );                    
                    if ( $uvpurge )
                        $add['uvpurge'] = sprintf( $this->add_dstyle, $uvpurge );                    
                    if ( $ppurge )
                        $add['ppurge'] = sprintf( $this->add_dstyle, $ppurge );                    
                    if ( $ubpurge )
                        $add['ubpurge'] = sprintf( $this->add_dstyle, $ubpurge );                    
                    if ( $bpurge )
                        $add['bpurge'] = sprintf( $this->add_dstyle, $bpurge );
                }
                $retval .= '</td>'

		
				. "<td align='right'>" . ($uv ? $uv : "0") ."</td>"				
				. "<td align='left' >" . (!empty($add['uvpurge']) ? $add['uvpurge'] : '&nbsp;' ) . "</td>"
				
				. "<td align='right'>" .($v ? "<a href=\"javascript:SelectDay($i);submitbutton('r03');\" title='" .$JSLanguage['miscellaneous']['misc22']. "'>$v</a>" : "0") . '</td>'
				. "<td align='left' >" . (!empty($add['vpurge']) ? '&nbsp;<a href="javascript:SelectDay($i);submitbutton(\'r03\');" title="'. $JSLanguage['miscellaneous']['misc22'] .'">'.$add['vpurge'].'</a>' : '&nbsp;') . '</td>'
				
				
				. '<td align="center">';
				if (($uv != 0) && ($v != 0)) 
					$retval .= number_format(round(($v/$uv), 1 ), 1);
				else
					$retval .= "0.0";
				$retval .= '</td>'
				
				. '<td align="right">'	. ( $p ? "<a href=\"javascript:SelectDay($i);submitbutton('r06');\" title='". $JSLanguage['miscellaneous']['misc23'] . "'>$p</a>" : "0")
				. '</td><td align="left">'
				. ' ' . ( !empty( $add['ppurge'] ) ? $add['ppurge'] : '&nbsp;' )
				. "</td>"
				
				. '<td align="center">'. ( $r ? "<a href=\"javascript:SelectDay($i);submitbutton('r10');\" title='". $JSLanguage['miscellaneous']['misc24'] . "'>$r</a>" : "0" )  ."</td>"
				
				. '<td align="right">' . ( $ub ? $ub : '0' ) .'</td>'				
				. '<td align="left">'. ' ' . (!empty($add['ubpurge']) ? $add['ubpurge'] : '&nbsp;' ) .'</td>'
				
				. '<td align="right">'. ( $b ? "<a href=\"javascript:SelectDay($i);submitbutton('r09');\" title='". $JSLanguage['miscellaneous']['misc25'] . "'>$b</a>" : "0"). "</td>"
				. "<td>". (!empty($add['bpurge']) ? $add['bpurge'] : '&nbsp;') ."</td>"
				. "</tr>\n";
			}






			// Get the values for the totals line
			// RB: values acuired higher in this function are wrong. check these and remove them
			// RB: change to new database methode


			// get Total Unique visitors
			$this->resetVar(1);
			$sql  = "SELECT count(*) FROM #__jstats_visits LEFT JOIN #__jstats_ipaddresses ON (#__jstats_visits.ip_id=#__jstats_ipaddresses.id) ";
			$sql .= "WHERE #__jstats_ipaddresses.type=1 and #__jstats_visits.month=$this->m and #__jstats_visits.year=$this->y ";
			$sql .= "group by #__jstats_visits.ip_id";
			$this->resetVar(0);
			$database->setQuery($sql);
			$rs = mysql_query($database->_sql);
			$tuv = mysql_num_rows($rs);
							
			if ($tuv == null)	
				$tuv = "&nbsp;";			
			
			
			// get Total Unique bots
			$this->resetVar(1);
			$sql  = "SELECT count(*) FROM #__jstats_visits LEFT JOIN #__jstats_ipaddresses ON (#__jstats_visits.ip_id=#__jstats_ipaddresses.id) ";
			$sql .= "WHERE #__jstats_ipaddresses.type=2 and #__jstats_visits.month=$this->m and #__jstats_visits.year=$this->y ";
			$sql .= "GROUP BY #__jstats_ipaddresses.browser";
			$this->resetVar(0);
			$database->setQuery($sql);
			$rs = mysql_query($database->_sql);				
			$tub = mysql_num_rows($rs);
								
			if ($tub == null)
				$tub="&nbsp;";	



			// Display the totals line
			if (defined('_JS_SHOW_PDATA' ))
			{
				if ( $tvpurge ) 
					$add['tvpurge'] = sprintf( $this->add_style, $tvpurge );				
				if ( $tuvpurge ) 
					$add['tuvpurge'] = sprintf( $this->add_style, $tuvpurge );				
				if ( $tppurge ) 
					$add['tppurge'] = sprintf( $this->add_style, $tppurge );				
				if ( $tubpurge ) 
					$add['tubpurge'] = sprintf( $this->add_style, $tubpurge );				
				if ( $tbpurge ) 
					$add['tbpurge'] = sprintf( $this->add_style, $tbpurge );				
			}

			$retval .= '<tr>'
			// Day
			. '<th align="center">' . $monthShort[$this->m] . '</th>'
			// Unique visitors
			. "<th align='right'>". $tuv ."</th>" 
			. "<th align='left'>". (!empty($add['tuvpurge']) ? $add['tuvpurge'] : '&nbsp;' ) . '</th>'
			// Number of visits
			. "<th align='right'>". $tv ."</th>"
			. "<th align='left'>". (!empty( $add['tvpurge'] ) ? $add['tvpurge'] : '&nbsp;' ). '</th>'
			// Visits average
			. '<th align="center">';
			if (($tuv!=0) && ($tv!=0))
				$retval .= number_format(round(($tv/$tuv), 1), 1);
			else
				$retval .= "0.0";	
			$retval .= '</th>'
			// Pages
			. "<th align='right'>". $tp ."</th>"
			. "<th align='left'>". (!empty($add['tppurge'] ) ? $add['tppurge'] : '&nbsp;') .'</th>'
			// Referrers
			. '<th align="center">' . $tr . '</th>'
			// Unique bots
			. "<th align='right'>". ($tub ? $tub : '0') ."</th>"
			. "<th align='left'>". (!empty($add['tubpurge']) ? $add['tubpurge'] : '&nbsp;' ) .'</th>'
			// Number of bots
			. "<th align='right'>". $tb ."</th>"
			. "<th align='left'>". (!empty($add['tbpurge'] ) ? $add['tbpurge'] : '&nbsp;') .'</th>'
			. '</tr>' . "\n";

			$retval .= '</table>' . "\n";
			return $retval;
		}





		
		
	function VisitInformation()
	/*
	 * case r03
	 */
	{
		global $database, $mosConfig_debug, $mosConfig_list_limit;
		global $mainframe, $JSLanguage, $option;

		$limit		= intval($mainframe->getUserStateFromRequest("viewlistlimit", 'limit', $mosConfig_list_limit));
        $limitstart	= intval($mainframe->getUserStateFromRequest("viewlimitstart", 'limitstart', 0));
		$search		= $mainframe->getUserStateFromRequest("search{$option}", 'search', '');
		$search		= $database->getEscaped(trim(strtolower($search)));

		if ($mosConfig_debug)
		{
			echo "search: '". $search ."'<br />";
			echo 'option: '. $option .'<br />';
			echo 'JS_Compat [ '. $this->JS_Compat() .' ]<br />';
		}		

		$retval = '<table class="adminlist" cellspacing="0" width="100%"><tr>';
		$retval .= '<th align="left">'.$JSLanguage['tableheaders']['t15'].'</th>';	// Time
		$retval .= '<th align="left">'.$JSLanguage['tableheaders']['t30'].'</th>';	// UserName
		$retval .= '<th align="left">'.$JSLanguage['tableheaders']['t10'].'</th>';	// tld
		$retval .= '<th align="left">'.$JSLanguage['tableheaders']['t11'].'</th>';	// country
		$retval .= '<th align="left">'.$JSLanguage['tableheaders']['t29'].'</th>';	// ip
		$retval .= '<th align="left">'.$JSLanguage['tableheaders']['t12'].'</th>';	// nslookup								
		$retval .= '<th colspan="2" align="left">'.$JSLanguage['tableheaders']['t08'].'</th>';	// Pages + Pathinfo 
		//$retval .= '<th align="left">&nbsp;</th>';									// Pathinfo
		$retval .= '<th align="left">'.$JSLanguage['tableheaders']['t13'].'</th>';	// OS
		$retval .= '<th align="left">'.$JSLanguage['tableheaders']['t14'].'</th>';	// Browser		
		$retval .= '<th align="left">'.$JSLanguage['tableheaders']['t33'].'</th>';	// Actions
		$retval .= '</tr>';

		$this->resetVar(1);
		$where = array();
		$where[] = "a.type != 2"; // mic: exclude only bots
		$where[] = "c.day LIKE '$this->d'";
		$where[] = "c.month LIKE '$this->m'";
		$where[] = "c.year LIKE '$this->y'";

		/* mic: show only actual data (without already archived/purged)
		 * a.table : jstats_ipadresses
		 * c.table : jstats_visits
		 */
		if (!defined('_JS_SHOW_PDATA'))
			$where[] = 'a.id = c.ip_id AND c.id >= ' . $this->buid();
		
		//RB: todo: add also username to the search
		if ($search)
		{
			$where[] =	"   (a.ip LIKE '%$search%' " .
						"OR LOWER(a.browser) LIKE '%$search%' " .
						"OR LOWER(a.system) LIKE '%$search%' " .
						"OR LOWER(a.nslookup) LIKE '%$search%' " .
						"OR LOWER(b.tld) LIKE '%$search%' " .
						"OR LOWER(b.fullname) LIKE '%$search%' " .
						"OR c.time LIKE '%$search%')";
			//RB: is LOWER needed? 'like' should check case insensitive?
		}        

		// select total
		$query  = "SELECT COUNT(*)"
			. "\n FROM #__jstats_ipaddresses AS a"
			. "\n LEFT JOIN #__jstats_topleveldomains AS b ON a.tld = b.tld"
			. "\n LEFT JOIN #__jstats_visits AS c ON a.id = c.ip_id"
			. (count($where) ? "\n WHERE " . implode(' AND ', $where) : "");
		$database->setQuery( $query );
		$total = $database->loadResult();
			
		if ($mosConfig_debug)
		{
		    echo 'query: ' . $query . '<br />';
            echo 'total: ' . $total . '<br />';
        }
            
            
            
            
		require_once($GLOBALS['mosConfig_absolute_path'] . '/administrator/includes/pageNavigation.php');
		$pageNav = new mosPageNav($total, $limitstart, $limit);

		$query  = "SELECT a.id AS aid, a.tld, a.nslookup, a.system, a.browser, a.ip, a.exclude, b.fullname, c.userid, c.time, c.id"
			. "\n FROM #__jstats_ipaddresses AS a"
			. "\n LEFT JOIN #__jstats_topleveldomains AS b ON a.tld = b.tld"
			. "\n LEFT JOIN #__jstats_visits AS c ON a.id = c.ip_id"
			. ( count( $where ) ? "\n WHERE " . implode( ' AND ', $where ) : "" )
			. "\n ORDER BY c.time DESC";

		if ($this->JS_Compat())
			$database->setQuery($query, $pageNav->limitstart, $pageNav->limit);
		else
		{
			$query .= "\n LIMIT $pageNav->limitstart, $pageNav->limit";
			$database->setQuery($query);
		}
		$rows = $database->loadObjectList();

		$this->resetVar(0);

		if ($mosConfig_debug)
			echo 'query:<br />' . $query;
		
  		
		if ($rows)
		{
			$k = 0;
			for ($i = 0, $n = count($rows); $i<$n; $i++)
			{				
				$row = &$rows[$i];
                $vid = $row->id;			

				$query = "SELECT count( * ) AS count FROM #__jstats_page_request WHERE #__jstats_page_request.ip_id = $vid";
                $database->setQuery($query);
				$count = $database->loadResult();				
				
				// display username instead of userid
				$query = "SELECT name FROM #__users WHERE id = $row->userid";
                $database->SetQuery($query);
                $name = $database->LoadResult();
                    
				// for excluding user
                $img	= $row->exclude ? 'tick.png' : 'publish_x.png';
                $task   = $row->exclude ? 'unexclude' : 'exclude';
                $alt    = $row->exclude ? $JSLanguage['messages']['msg09'] : $JSLanguage['messages']['msg08'];

				// opens userdetails in own window
                    $userlink = '<a target="popup" href="'
                    . 'index2.php?option=com_users&amp;task=editA&amp;id=' . $row->userid
                    . '&amp;hidemainmenu=1"' // &amp;no_html=1 // mic: optionla, but should then opened with own css!
                    . ' onclick="window.open(\'\',\'popup\''
                    . ',\'resizable=yes,status=no,toolbar=no,location=no,scrollbars=yes,width=690,height=560\')"'
                    . ' title="' . $JSLanguage['miscellaneous']['misc14'] . '">'. $name .'</a>';

                
				//($count ? $retval .= '<tr class="row' . $k . '">' : $retval .= '<tr class="row' . $k . '" style="color:#666666" title="' . $JSLanguage['tooltips']['ttc13'] . '">');
				$retval .= "<tr class='row$k'";
				($count ? $retval .= ">" : $retval .= " style='color:#666666' title='". $JSLanguage['tooltips']['ttc13'] ."'>");				
				
				$retval .= '<td align="left" nowrap="nowrap">' . $row->time . '</td>';
				
				$retval	.=  '<td align="left" nowrap="nowrap">'
                 		. ( $name ? $userlink : $JSLanguage['miscellaneous']['misc13'] )
                    	. '</td>';                    
				
				$retval .= '<td align="left" nowrap="nowrap">&nbsp;' . $row->tld . '</td>'
                . '<td align="left" nowrap="nowrap">&nbsp;'. ( $row->ip == '127.0.0.1' ? $JSLanguage['miscellaneous']['misc98']: $row->fullname ) .'</td>'
                . '<td align="left" nowrap="nowrap">&nbsp;' . $row->ip . '</td>'
                . '<td align="left">';
				
                if (strlen($row->nslookup) > 38)
                {
                    $retval .= '<acronym title="' . $row->nslookup . '">'
                    . substr( $row->nslookup, 0, 37 ) . ' <strong style="color:#FF0000">&raquo;</strong>'
					. '</acronym>';
				}
				else
                	$retval .= $row->nslookup;

                    
				// mic: *** placeholder for archived/purged items
                    $retval .= '</td>'                    
                    
                    . '<td align="left" nowrap="nowrap">'
                    . ($count ? '<a href="javascript:document.adminForm.vid.value=\''
                    . $vid . '\';submitbutton(\'r03a\');"'
                    . ' title="' . $JSLanguage['miscellaneous']['misc25'] . '">' . $count . '</a>' : '***' )
                    . '</td>'
                    
                    . '<td align="left" nowrap="nowrap">'
                    . ( $count ? '<a title="' . $JSLanguage['miscellaneous']['misc12']
                    . '" href="javascript:document.adminForm.vid.value=\''
                    . $vid . '\';submitbutton(\'r03b\');">'
                    . $JSLanguage['miscellaneous']['misc12'] . '</a>' : '***' )
                    . '</td>'
                    
                    . '<td align="left" nowrap="nowrap">&nbsp;' . $row->system . '</td>'
                    . '<td align="left" nowrap="nowrap">&nbsp;' . $row->browser . '</td>'
                                        
                    . '<td>' 
                    . '<a href="javascript:document.adminForm.vid.value=\''
                    . $row->aid . '\';submitbutton(\'' . $task . '\');" title="' . $alt . '"><img src="images/'
                    . $img . '" width="12" height="12" border="0" alt="' . $alt . '" /></a>'
                    . '</td>'
                    . '</tr>' . "\n";

                    $k = 1 - $k;
			}
		}
		else
		{
           	$retval .= '<tr><td colspan="10" style="text-align:center">'
           	. $JSLanguage['messages']['msg05']
          	. '</td></tr>';
        }

		$retval .= '</table>' . "\n";
		$retval .= $pageNav->getListFooter();

		return $retval;
	}




		function getVisitorsByTld()
		/*
		 * case r05
		 */
		{
			global $database, $mainframe;
			global $mosConfig_debug, $mosConfig_list_limit, $mosConfig_live_site;
			global $JSLanguage;
			global $option;
					
			$totalnmb 			= 0;
			$totalmax 			= 0;
			$totaltld 			= 0;
			$totalmaxpercent	= 0;
			$where				= array();
			
			$limit	= intval( $mainframe->getUserStateFromRequest( "viewlistlimit", 'limit', $mosConfig_list_limit ) );
	        $limitstart	= intval( $mainframe->getUserStateFromRequest( "viewlimitstart", 'limitstart', 0 ) );
            // mic: search not activated as of 2006.12.23, prepared for later
            //$search		= $mainframe->getUserStateFromRequest( "search{$option}", 'search', '' );
            //$search		= $database->getEscaped( trim( strtolower( $search ) ) );
			

			$retval  = '<table class="adminlist" cellspacing="0" width="100%"><tr>';
			$retval .= '<th align="left"	width="2%">'.$JSLanguage['tableheaders']['t17'].'</th>';
			$retval .= '<th align="left" 	width="3%">'.$JSLanguage['tableheaders']['t19'].'</th>';
			$retval .= '<th align="center"	width="10%">'.$JSLanguage['tableheaders']['t04'].'</th>';
			$retval .= '<th align="left"	width="20%">'.$JSLanguage['tableheaders']['t18'].'</th>';			
			$retval .= '<th align="left"	width="65%">'.$JSLanguage['tableheaders']['t11'].'</th>';
			$retval .= "</tr>" . "\n";
			
			$this->resetVar(1);
			
			$where[] = "c.day LIKE '$this->d'";
			$where[] = "c.month LIKE '$this->m'";
			$where[] = "c.year LIKE '$this->y'";
			$where[] = "a.type='1'";
			
			/* mic: show only actual data (without already archived/purged)
			 * a.table : jstats_ipadresses
			 * c.table : jstats_visits
			 */
			if (!defined('_JS_SHOW_PDATA'))
				$where[] = 'a.id = c.ip_id AND c.id >= ' . $this->buid();
				
			// select total
			$query  = "SELECT COUNT(*)"
			. "\n FROM #__jstats_ipaddresses AS a"
			. "\n LEFT JOIN #__jstats_topleveldomains AS b ON a.tld = b.tld"
			. "\n LEFT JOIN #__jstats_visits AS c ON a.id = c.ip_id"
			. ( count( $where ) ? "\n WHERE " . implode( ' AND ', $where ) : "" )
			. "\n GROUP BY a.tld"
			;
			$database->setQuery( $query );
			$rows = $database->loadObjectList();
						
			
			$total = count( $rows );

			if ($mosConfig_debug)
			{
			    echo 'query: ' . $query . '<br />';
                echo 'total: ' . $total . '<br />';
            }

			$query = "SELECT count(*) AS numbers, a.tld, b.fullname"
			. "\n FROM #__jstats_ipaddresses AS a"
			. "\n LEFT JOIN #__jstats_topleveldomains AS b ON a.tld = b.tld"
			. "\n LEFT JOIN #__jstats_visits AS c ON a.id = c.ip_id"
			. ( count( $where ) ? "\n WHERE " . implode( ' AND ', $where ) : "" )
			. "\n GROUP BY a.tld"
			//. "\n ORDER BY b.fullname ASC"
			. "\n ORDER BY numbers DESC";
			$database->setQuery( $query );
			$rows = $database->loadObjectList();
						
			$this->resetVar(0);	
						
			
			require_once( $GLOBALS['mosConfig_absolute_path'] . '/administrator/includes/pageNavigation.php' );
			$pageNav = new mosPageNav( count( $rows ), $limitstart, $limit );

			if( $rows ){
                foreach( $rows AS $row )
                {

                    $totalnmb   += $row->numbers;
                    $totaltld   ++;

                    if ($row->numbers > $totalmax)
                        $totalmax = $row->numbers;
                    
                }

                if ($totalnmb != 0)
                    $totalmaxpercent = round( ( ( $totalmax / $totalnmb ) * 100 ), 1 );
                

			    $end	= $limitstart + $limit;
			    $k		= 0;
			    for( $ii = 0; $ii < count( $rows ); $ii++ ) {
					$row = &$rows[$ii];

					if( $ii >= $limitstart && $ii <= $end ) {

                        $retval .= '<tr class="row' . $k . '">' . "\n"
                        . '<td align="center"><img src="';

                        if( $row->tld == '' ){
                            $retval .= _JSImagePathTLD . 'unknown.png" alt="'.
                            $JSLanguage['miscellaneous']['misc27'] . '" />';
                        }else{
                            $retval .= _JSImagePathTLD . $row->tld . '.png" alt="' . $row->tld . '" />';
                        }

						$retval .= '</td>'
                        . '<td align="left">&nbsp;' . $row->tld . '</td>'
                        . '<td align="center">&nbsp;' . $row->numbers . '</td>'
                        . '<td align="left" nowrap="nowrap">&nbsp;';

                        $percent = round((($row->numbers/$totalnmb)*100), 1);

                        $retval .= $this->PercentBar($percent, $totalmaxpercent)
                        . '&nbsp;&nbsp;' . $percent . '%</td>'
                        . '<td align="left">&nbsp;'
                        . ( $row->tld == 'localhost' ? $JSLanguage['miscellaneous']['misc98'] : $row->fullname )
                        . '</td>'
                        . '</tr>' . "\n";
					}

					$k = 1 - $k;

					if( $ii + 1 >= $end ){
                        break;
                    }
                }
            }else{
            	$retval .= '<tr>' . "\n"
            	. '<td colspan="5" style="text-align:center">'
            	. $JSLanguage['messages']['msg05']
            	. '</td></tr>' . "\n";
            }

			$retval .='<tr>' . "\n"
			. '<th colspan="2">&nbsp;</th>'
			. '<th align="center">&nbsp;' . $totalnmb . '</th>'
			. '<th>&nbsp;</th>'
			;

			if( $totaltld != 0 ){
				$retval .= '<th align="left">'
				. $totaltld . '&nbsp;'
				. ( $totaltld == 1 ? $JSLanguage['miscellaneous']['misc95'] : $JSLanguage['miscellaneous']['misc96'] )
				. '</th>';
			}else{
				$retval .= '<th align="left">&nbsp;' . $JSLanguage['miscellaneous']['misc97'] . '</th>';
			}

			$retval .= '</tr>' . "\n"
			. '</table>' . "\n";
			$retval .= $pageNav->getListFooter();

			return $retval;
		}
	

		function getPageHits()
		/*
		 * case r06
		 */
		{
			global $database, $mainframe;
			global $mosConfig_debug, $mosConfig_list_limit, $mosConfig_live_site;
			global $JSLanguage;
			global $option;

			$limit	= intval( $mainframe->getUserStateFromRequest( "viewlistlimit", 'limit', $mosConfig_list_limit ) );
	        $limitstart	= intval( $mainframe->getUserStateFromRequest( "viewlimitstart", 'limitstart', 0 ) );
            // mic: search not activated as of 2006.12.23, prepared for later
            //$search		= $mainframe->getUserStateFromRequest( "search{$option}", 'search', '' );
            //$search		= $database->getEscaped( trim( strtolower( $search ) ) );

			$rowa					= 0;
			$rowb					= 0;
			$pc						= 0;
			$totalnmb				= 0;
			$totalmax				= 0;
			$totaldifferentpages	= 0;
			$totalrowb				= 0;
			$rettable 				= array();

			$retval = '<table class="adminlist" cellspacing="0" width="100%">' . "\n"
			. '<tr>' . "\n"
			. '<th width="3%">&nbsp;</th>'														// Nr.
			. '<th width="5%">' . $JSLanguage['tableheaders']['t28'] . '</th>'					// Count
			. '<th width="20%">' . $JSLanguage['tableheaders']['t18'] . '</th>'					// Percent	
			. '<th align="left" width="72%">' . $JSLanguage['tableheaders']['t20'] . '</th>'	// Page
			. '</tr>' . "\n";

			$query = "SELECT page, page_id, page_title"
			. "\n FROM #__jstats_pages";
			$database->setQuery( $query);
			$rows = $database->loadObjectList();

			foreach( $rows AS $row )
			{
				$this->resetVar(1);

				$query = "SELECT count(*) numbers"
				. "\n FROM #__jstats_page_request AS a"
				//. ( count( $where ) ? "\n WHERE " . implode( ' AND ', $where ) : "" ) // mic: prepared for later
				. "\n WHERE a.page_id = $row->page_id"
				. "\n AND a.day LIKE '$this->d'"
				. "\n AND a.month LIKE '$this->m'"
				. "\n AND a.year LIKE '$this->y'";
                $database->setQuery( $query );
				$rowa = $database->LoadResult();

				$this->resetVar(0);	// cant this line be deleted?
				$this->resetVar(1);

				if (defined('_JS_SHOW_PDATA'))
				{
					// show also archived/purged data
				    $query = "SELECT sum(count)"
                    . "\n FROM #__jstats_page_request_c AS a"
                    //. ( count( $where ) ? "\n WHERE " . implode( ' AND ', $where ) : "" ) // mic: prepared for later
                    . "\n WHERE a.day LIKE '$this->d'"
                    . "\n AND a.month LIKE '$this->m'"
                    . "\n AND a.year LIKE '$this->y'"
                    . "\n AND a.page_id = $row->page_id";
                    $database->setQuery( $query );
                    $rowb = $database->LoadResult();

                    $this->resetVar(0);

					$totalrowb += $rowb;
                }

				if (($rowa + $rowb) > 0)
					$rettable[$row->page . '#/#' . $row->page_title] = ($rowa + $rowb);				
			}

			require_once( $GLOBALS['mosConfig_absolute_path'] . '/administrator/includes/pageNavigation.php' );
			$pageNav = new mosPageNav( count( $rettable ), $limitstart, $limit );

			if ( $rettable )
			{
				arsort( $rettable );
				reset( $rettable );

				while ( list( $key, $val ) = each( $rettable ) )
				{
					$totalnmb += $val;
					$totaldifferentpages++;
					if( $val > $totalmax )
						$totalmax = $val;					
				}
				reset( $rettable );

				if ( $totalnmb > 0 )
					$totalmaxpercent = round( ( ( $totalmax / $totalnmb ) * 100 ), 1 );				

				$end	= $limitstart + $limit;
				$k		= 0;

				for ( $ii = 0; $ii < count( $rettable ); $ii++ )
				{
					list( $key, $val ) = each( $rettable );
					$explodedkey = explode( '#/#', $key );

					if ( $ii >= $limitstart && $ii <= $end )
					{
					    $retval .= '<tr class="row' . $k . '">' . "\n"
					    . '<td align="right"><em>' . ( $ii + 1 ) . '.</em></td>'
                        . '<td align="center" nowrap="nowrap">&nbsp;' . $val . '</td>';

                        $percent = round( ( ( $val / $totalnmb ) * 100 ), 1 );

                        $retval .= '<td align="left" nowrap="nowrap">&nbsp;'
                        . $this->PercentBar($percent,$totalmaxpercent)
                        //. '</td><td align="right">'
                        . '&nbsp;&nbsp;' . number_format( $percent, 1, ',', '' ) . '%'
                        . '</td>';

                        if( $explodedkey[1] )
                            $retval .= '<td align="left" nowrap="nowrap">'
                            . '<a href="' . htmlentities( $explodedkey[0] ) . '" target="_blank" title="'
                            . htmlentities( $explodedkey[0] ) . '">' . $explodedkey[1] . '</a>'
                            . '</td>';
                        else
                            $retval .= '<td align="left" nowrap="nowrap">'
                            . '<a href="' . htmlentities( $explodedkey[0] ) . '" target="_blank" title="'
                            . htmlentities( $explodedkey[0] ) . '">' . $explodedkey[0] . '</a>'
                            . '</td>';
                        
                        $retval .= '</tr>' . "\n";

						$k = 1 - $k;

                        if( $ii + 1 >= $end ){
                        	break;
                        }
                    }
				}
			}else{
            	$retval .= '<tr><td colspan="4" style="text-align:center">'
            	. $JSLanguage['messages']['msg05']
            	. '</td></tr>' . "\n";
            }

			if ( defined( '_JS_SHOW_PDATA' ) )
			{
				$add = NULL;
				if ( $totalrowb != 0 ) {
					$add['totalrowb'] = sprintf( $this->add_style, $totalrowb  );
				}
			}

			$retval .='<tr>' . "\n"
			. '<th>&nbsp;</th>'
			. '<th nowrap="nowrap">&nbsp;'
			. $totalnmb . ( !empty( $add['totalrowb'] ) ? ' ' . $add['totalrowb'] : '' )
			. '</th>'
			. '<th>&nbsp;</th>'
			. '<th align="left">&nbsp;'
			. $totaldifferentpages . '&nbsp;'
			. ( $totaldifferentpages == 1 ? $JSLanguage['miscellaneous']['misc93'] : $JSLanguage['miscellaneous']['misc94'] )
			. '</th>'
			. '</tr>'  . "\n"
			. '</table>' . "\n";

			$retval .= $pageNav->getListFooter();

			return $retval;
		}
		
		
		
		function getSystems()
		/*
		 * case 07
		 */
		{
			global $database;
			global $JSLanguage;

			$where				= array();
			$totalnmb			= 0;
			$totalmax			= 0;
			$totalmaxpercent	= 0;
			$totalsystems		= 0;

			$retval = '<table class="adminlist" cellspacing="0" width="100%">' . "\n"
			. '<tr>'
			. '<th width="10%">' . $JSLanguage['tableheaders']['t28'] . '</th>'
			. '<th width="25%">' . $JSLanguage['tableheaders']['t18'] . '</th>'
			. '<th align="left" width="65%">' . $JSLanguage['tableheaders']['t13'] . '</th>' . "\n"
			. '</tr>' . "\n";

			$this->resetVar(1);

			$where[] = "a.id = c.ip_id";
			$where[] = "c.day LIKE '$this->d'";
			$where[] = "c.month LIKE '$this->m'";
			$where[] = "c.year LIKE '$this->y'";
			$where[] = "a.type = 1";

			/* mic: show only actual data (without already archived/purged)
			 * a.table : jstats_ipadresses
			 * c.table : jstats_visits
			 */
			if( !defined( '_JS_SHOW_PDATA' ) ){
				$where[] = 'a.id = c.ip_id AND c.id >= ' . $this->buid();
			}

			$query = "SELECT a.system, count(*) numbers"
			. "\n FROM #__jstats_ipaddresses AS a, #__jstats_visits AS c"
			. ( count( $where ) ? "\n WHERE " . implode( ' AND ', $where ) : "" )
			. "\n GROUP BY a.system"
			. "\n ORDER BY numbers DESC, a.system ASC";
			$this->resetVar(0);
			$database->setQuery( $query );
			$rows = $database->LoadObjectList();

			if (is_array($rows))	// RB: otherwise "Warning: Invalid argument supplied for foreach() in ...\administrator\components\com_joomlastats\admin.joomlastats.html.php on line " if there are no records
				foreach ($rows AS $row)
				{ 
	                $totalsystems++;
                	$totalnmb += $row->numbers;
	
                	if ($row->numbers > $totalmax)
	                    $totalmax = $row->numbers;
            	}
            	
 

			if ($totalnmb != 0 )
			{
				$totalmaxpercent	= round( ( ( $totalmax / $totalnmb ) *100 ), 1 );
				$k					= 0;

				foreach ( $rows AS $row )
				{
					$retval .= '<tr class="row' . $k . '">'
				  	. '<td align="center" nowrap="nowrap">&nbsp;' . $row->numbers . '</td>';

				  	$percent = round((($row->numbers / $totalnmb)*100), 1);

				  	$retval .= '<td align="left">&nbsp;'
					. $this->PercentBar($percent, $totalmaxpercent)
					. '&nbsp;&nbsp;' . number_format( $percent, 1, ',', '' ) . '%' //RB: maybe try to align percentage on last % so 88,2% wil be right aligned with 2,8%; but keep number just behind bar. 
					. '</td>'
					. '<td align="left" nowrap="nowrap">&nbsp;'
					. ( $row->system ? $row->system :  $JSLanguage['miscellaneous']['misc27'] )
					. '</td>'
					. '</tr>' . "\n";

					$k = 1 - $k;
				}
			}

			// TotalLine
			$retval .= '<tr><th>&nbsp;' . $totalnmb . '</th>'
			. '<th>&nbsp;</th>'
			. '<th align="left">&nbsp;&nbsp;' . $totalsystems . '&nbsp;';

			if( $totalsystems != 0 ){
				$retval .= ( $totalsystems == 1 ? $JSLanguage['miscellaneous']['misc91'] : $JSLanguage['miscellaneous']['misc92'] );
			}else{
				$retval .= $JSLanguage['miscellaneous']['misc90'];
			}

			$retval .= '</th>'
			. '</table>' . "\n";

			return $retval;
		}



		function getBrowsers()
		/*
		 * case r08
		 */
		{
			global $database, $JSLanguage;

			$retval = '<table class="adminlist" cellspacing="0" width="100%">' . "\n"
			. '<tr>'
			. '<th width="10%">' . $JSLanguage['tableheaders']['t28'].'</th>'
			. '<th width="25%">' . $JSLanguage['tableheaders']['t18'].'</th>'			
			. '<th align="left" width="65%">' . $JSLanguage['tableheaders']['t21'].'</th>'
			. '</tr>';

			$where			= array();
			$totalbrowsers 	= 0;
			$totalnmb		= 0;
			$totalmax 		= 0;

			$this->resetVar(1);

			$where[] = "c.ip_id = a.id";
			$where[] = "a.type = 1";
			$where[] = "c.day LIKE '$this->d'";
			$where[] = "c.month LIKE '$this->m'";
			$where[] = "c.year LIKE '$this->y'";

			/* mic: show only actual data (without already archived/purged)
			 * a.table : jstats_ipadresses
			 * c.table : jstats_visits
			 */
			if (!defined('_JS_SHOW_PDATA'))
			{
				$where[] = 'a.id = c.ip_id AND c.id >= ' . $this->buid();
			}

			$query = "SELECT a.browser, count(*) numbers"
				. "\n FROM #__jstats_ipaddresses AS a, #__jstats_visits AS c"
				. ( count( $where ) ? "\n WHERE " . implode( ' AND ', $where ) : "" )
				. "\n GROUP BY a.browser"
				. "\n ORDER BY numbers DESC, a.browser ASC";
			$database->setQuery( $query );
			$rows = $database->loadObjectList();

			$this->resetVar(0);

			if (is_array($rows))	
				foreach ($rows AS $row)
				{
                	$totalbrowsers++;
	                $totalnmb += $row->numbers;

                	if ($row->numbers > $totalmax)
	                    $totalmax = $row->numbers;                
            	}

            if ($totalnmb != 0)
            {
            	$totalmaxpercent = round( ( ( $totalmax / $totalnmb ) * 100 ), 1 );
            	//??? How do I get fixed result not "1" but "1,0"   If i get this to work right align looks better.
            	$k = 0;

				if (is_array($rows))	
	            	foreach ($rows AS $row)
            		{
	            		$percent = round( ( ( $row->numbers / $totalnmb ) * 100 ), 1 );
	
            			$retval .= '<tr class="row' . $k . '">'
						. '<td align="center" nowrap="nowrap">&nbsp;' . $row->numbers . '</td>'
						. '<td align="left" nowrap="nowrap">&nbsp;'
						. $this->PercentBar( $percent, $totalmaxpercent )					
						. '&nbsp;&nbsp;' . number_format( $percent, 1, ',', '' ) . '%'
						. '</td>'
						. '<td align="left" nowrap="nowrap">&nbsp;' . $row->browser . '</td>'
						. '</tr>' . "\n";
	
						$k = 1 - $k;
					}
			}

			// Summary Bar
			$retval .= '<tr><th align="center">&nbsp;' . $totalnmb . '</th>'
			. '<th>&nbsp;</th>'
			. '<th align="left">' . $totalbrowsers . '&nbsp;';
			if ($totalbrowsers != 0)
				$retval .= ( $totalbrowsers == 1 ? $JSLanguage['miscellaneous']['misc87'] : $JSLanguage['miscellaneous']['misc88'] );
			else
				$retval .= $JSLanguage['miscellaneous']['misc87'];
			
			$retval .= '</th></tr>' . "\n"
			. '</table>' . "\n";

			return $retval;
		}
		
		
		
		function getBots()
		/*
		 * Robots/Spiders
		 * case r09		overview
		 * for details see case r09a
		 */
		{
			global $database;
			global $JSLanguage;

			// $this->$dom is used as transfer variable for browser (is name of Bot)
			// $this->$vid is used as transfer variable for ip_id

			$where		= array();
			$do_bots	= 0; // 0: not doing bot || 1: do bots (overview of all Bots)
			$totalnmb	= 0; // total number of records
			$totalbots	= 0; // total nuber of different bots
			$totalmax	= 0;

			if ($this->dom == '')
			{
				// If function not called before, then start with overview bots/spiders table
				$this->dom	= '%';
				$do_bots	= 1;
			}

			if ($this->vid == '')
				$this->vid = '%';
			else
				$do_detailed = 1;

			$retval = '<table class="adminlist" cellspacing="0" width="100%">' . "\n";			

			if ($do_bots)
			{
				// The first screen, list all bots
				$retval .= '<tr><th width="10%">' . $JSLanguage['tableheaders']['t28'] . '</th>'
				. '<th width="20%">' . $JSLanguage['tableheaders']['t18'] . '</th>'				
				. '<th align="left" width="70%">' . $JSLanguage['tableheaders']['t22'] . '</th>'
				. '</tr>';

				$this->resetVar(1);

				$where[] = "c.ip_id = a.id";
				$where[] = "a.browser !=''";
				$where[] = "a.type = 2";
				$where[] = "c.day LIKE '$this->d'";
				$where[] = "c.month LIKE '$this->m'";
				$where[] = "c.year LIKE '$this->y'";

				/* mic: show only actual data (without already archived/purged)
			     * a.table : jstats_ipadresses
                 * c.table : jstats_visits
                 */
                if ( !defined( '_JS_SHOW_PDATA' ) )
                    $where[] = 'a.id = c.ip_id AND c.id >= ' . $this->buid();

				$query = "SELECT a.browser, count(*) numbers"
				. "\n FROM #__jstats_ipaddresses AS a, #__jstats_visits AS c"
				. ( count( $where ) ? "\n WHERE " . implode( ' AND ', $where ) : "" )
				. "\n GROUP BY a.browser"
				. "\n ORDER BY numbers DESC, a.browser ASC";
				$database->setQuery( $query );
				$rows = $database->loadObjectList();

				$this->resetVar(0);

				if (is_array($rows))	
					foreach ($rows AS $row)
					{
                    	$totalbots++;
                    	$totalnmb += $row->numbers;

                    	if ($row->numbers > $totalmax)
	                        $totalmax = $row->numbers;
                }

                if ($totalnmb != 0) 
                {
					$totalmaxpercent	= round((($totalmax/$totalnmb)*100),1);
					$k					= 0;

					if (is_array($rows))	
						foreach ($rows AS $row)
						{						
							$percent = round((($row->numbers / $totalnmb) * 100), 1);

							$retval .= '<tr class="row' . $k . '">'
							.'<td align="center" nowrap="nowrap">&nbsp;' . $row->numbers . '</td>'
							.'<td align="left" nowrap="nowrap">&nbsp;'
                        	. $this->PercentBar($percent, $totalmaxpercent)                        
                        	.'&nbsp;&nbsp;' . number_format($percent, 1, ',', '') . '%'
                        	.'</td>'
                        	.'<td align="left" nowrap="nowrap">&nbsp;'
                        	.'<a title="' . $JSLanguage['miscellaneous']['misc83']
                        	.'" href="javascript:document.adminForm.dom.value=\''
                        	. rawurlencode( $row->browser ) . '\';submitbutton(\'r09\');">' . $row->browser . '</a></td>'
                        	.'</tr>' . "\n";

                        	$k = 1 - $k;
						}
				}

				$retval .= '<tr><th>&nbsp;' . $totalnmb . '</th>'
				.'<th>&nbsp;</th>'
				.'<th align="left">&nbsp;&nbsp;' . ( $totalbots ? $totalbots : '' ) . '&nbsp;';

				if( $totalbots != 0 ) 
					$retval .= ( $totalbots == 1 ? $JSLanguage['miscellaneous']['misc84'] : $JSLanguage['miscellaneous']['misc85'] );
				else
					$retval .= $JSLanguage['miscellaneous']['misc86'];

				$retval .= '</th></tr></table>' . "\n";
			}
			else
			{
				// detail screen, list all visits from selected bot
				$retval .= '<tr><th width= "10%" align="left">' . $JSLanguage['tableheaders']['t10'] . '</th>'
				. '<th width= "10%" align="left">' . $JSLanguage['tableheaders']['t11'] . '</th>'
				. '<th width= "10%" align="left">' . $JSLanguage['tableheaders']['t16'] . '</th>'
				. '<th width= "10%" align="left">' . $JSLanguage['tableheaders']['t08'] . '</th>'
				. '<th width="100%" align="left">' . $JSLanguage['tableheaders']['t15'] . '</th>'
				. '</tr>' . "\n";

				$this->resetVar(1);

				$where[] = "a.browser LIKE '$this->dom'";
				$where[] = "a.type = 2";
				$where[] = "c.day LIKE '$this->d'";
				$where[] = "c.month LIKE '$this->m'";
				$where[] = "c.year LIKE '$this->y'";

				/* mic: show only actual data (without already archived/purged)
			     * a.table : jstats_ipadresses
                 * c.table : jstats_visits
                 */
                if( !defined( '_JS_SHOW_PDATA' ) ){
                    $where[] = 'a.id = c.ip_id AND c.id >= ' . $this->buid();
                }

				$sql  = "SELECT a.tld, a.browser, b.fullname, c.time, c.id"
				. "\n FROM #__jstats_ipaddresses AS a"
				. "\n LEFT JOIN #__jstats_topleveldomains AS b ON a.tld = b.tld"
				. "\n LEFT JOIN #__jstats_visits AS c ON c.ip_id = a.id"
				. ( count( $where ) ? "\n WHERE " . implode( ' AND ', $where ) : "" )
				. "\n ORDER BY c.time DESC"
				;
				$database->setQuery( $sql );
				$rows = $database->loadObjectList();

				$this->resetVar(0);

				if( $GLOBALS['mosConfig_debug'] ){
					echo $sql;
					echo '<br />*************************************<br />';
					echo 'result query [rows]:<br />';
					print_r( $rows );
				}

				$k = 0;
				foreach ( $rows AS $row )
				{
					$vid = $row->id;

					$query = "SELECT count(*) AS count"
					. "\n FROM #__jstats_page_request"
					. "\n WHERE #__jstats_page_request.ip_id = $vid"
					;
					$database->setQuery( $query );
					$rowCount = $database->loadResult();

					$href = 'javascript:document.adminForm.dom.value=\''
					. rawurlencode( $this->dom ) . '\';javascript:document.adminForm.vid.value=\''
					. $vid . '\';submitbutton(\'r09a\');';
					( $rowCount ? $retval .= '<tr class="row' . $k . '">' : $retval .= '<tr class="row' . $k . '" style="color:#666666" title="' . $JSLanguage['tooltips']['ttc13'] . '">' );
					$retval .= '<td style="text-algn:left; white-space:nowrap">&nbsp;' . $row->tld . '</td>'
					. '<td style="text-algn:left; white-space:nowrap">&nbsp;' . $row->fullname . '</td>'
					. '<td style="text-algn:left; white-space:nowrap">&nbsp;' . $row->browser . '</td>'
					. '<td style="text-algn:left; white-space:nowrap"'
					. ( $rowCount ? '>' . '<a title="' . $JSLanguage['miscellaneous']['misc83']
					. '" href="' . $href
					. '">' . $rowCount . '</a>' : '>***' )
					. '</td>'
					. '<td style="text-algn:left; white-space:nowrap">' . $row->time . '</td>'
					. '</tr>' . "\n";

					$k = 1 - $k;
				}

				$retval .= '</table>'
				. '<div style="text-align:center; background-color:#ECECEC">[&nbsp;'
				. '<a href="javascript:submitbutton(\'r09\');">' . $JSLanguage['miscellaneous']['misc11'] . '</a>'
				. '&nbsp;]</div>';
			}

			return $retval;
		}
		
		
		
		function getReferrers()
		/*
		 * case r10
		 */
		{
			global $database, $mainframe;
			global $mosConfig_debug, $mosConfig_list_limit, $mosConfig_live_site;
			global $JSLanguage;
			global $option;

			$limit		= intval($mainframe->getUserStateFromRequest("viewlistlimit", 'limit', $mosConfig_list_limit));
	        $limitstart	= intval($mainframe->getUserStateFromRequest("viewlimitstart", 'limitstart', 0));
            // mic: search not activated as of 2006.12.23, prepared for later
            //$search		= $mainframe->getUserStateFromRequest( "search{$option}", 'search', '' );
            //$search		= $database->getEscaped( trim( strtolower( $search ) ) );

			$totalnmb 			= 0;
			$doreffererdomain 	= 0;
			$totalrefferers		= 0;
			$totalmax 			= 0;
			$selector 			= 'referrer';
			$retval 			= '<table class="adminlist" cellspacing="0" width="100%">' . "\n" . '<tr>';

			if ($this->dom == '')
			{
				$doreffererdomain = 1;
				$this->dom = '%';
			}

			if ($doreffererdomain)
				$selector = 'domain';

			$this->resetVar(1);

			$where[] = "day LIKE '$this->d'";
            $where[] = "month LIKE '$this->m'";
            $where[] = "year LIKE '$this->y'";
            $where[] = "domain LIKE '$this->dom'";

			$query = "SELECT " . $selector . ", count(*) counter"
				. "\n FROM #__jstats_referrer"
				. (count( $where ) ? "\n WHERE ". implode(' AND ', $where ) : "")
            	. "\n GROUP BY " . $selector
            	. "\n ORDER BY counter DESC, ". $selector ." ASC";
			$database->setQuery($query);
			$rows = $database->loadObjectList();

			$this->resetVar(0);

			require_once($GLOBALS['mosConfig_absolute_path'] . '/administrator/includes/pageNavigation.php');
			$pageNav = new mosPageNav(count($rows), $limitstart, $limit);

			if ($doreffererdomain)
			{
				$retval .= '<th width="5%" nowrap="nowrap">' . $JSLanguage['tableheaders']['t28'] . '</th>'
					. '<th width="10%">' . $JSLanguage['tableheaders']['t18'] . '</th>'
					. '<th align="left" width="85%">' . $JSLanguage['tableheaders']['t23'] . '</th>'
					. '</tr>';

				foreach ($rows AS $row)
				{
					$totalnmb += $row->counter;

					if ($row->counter > $totalmax) 
						$totalmax = $row->counter;
					$totalrefferers++;
				}

				if ($totalnmb != 0)
				{
					$totalmaxpercent 	= round((($totalmax / $totalnmb) * 100), 1);
					$k					= 0;

					//foreach( $rows AS $row ){
					$end = $limitstart + $limit;
					for ($ii = 0; $ii<count($rows); $ii++ ) 
					{
						$row = &$rows[$ii];

						if ($ii >= $limitstart && $ii <= $end)
						{
						    $percent = round ((($row->counter / $totalnmb) * 100 ), 1);

                            $retval .= '<tr class="row' . $k . '">' . "\n"
                        	    	. '<td align="center" nowrap="nowrap">&nbsp;' . $row->counter . '</td>'
                            		. '<td align="center" nowrap="nowrap">'
                            		. $this->PercentBar( $percent, $totalmaxpercent )
                            		. '&nbsp;&nbsp;' . number_format( $percent, 1, ',', '' ) . '%'
                            		. '</td>'
                            		. '<td nowrap>&nbsp;'
	                            	. '<a href="javascript:document.adminForm.dom.value=\''
                            		. $row->$selector . '\';submitbutton(\'r10\');">' . $row->$selector . '</a>'
                            		. '</td></tr>' . "\n";

                            $k = 1 - $k;

                            if ($ii+1 >= $end)
                                break;
                        }
					}
				}
				else
				{
                    $retval .= '<tr><td colspan="4" style="text-align:center">'
                	    	. $JSLanguage['messages']['msg05']
                    		. '</td></tr>' . "\n";
                }

				$retval .= '<tr><th>&nbsp;' . $totalnmb . '</th>'
						. '<th>&nbsp;</th>'
						. '<th align="left">';

				if ($totalrefferers > 0)
					$retval .= '<a href="javascript:document.adminForm.dom.value=\'%\';submitbutton(\'r10\');">'
							. $JSLanguage['miscellaneous']['misc79'] . '[ ' . $totalrefferers . ' ]' . '</a>';
				else
					$retval .= $JSLanguage['miscellaneous']['misc78'];				

				$retval .= '</th></tr>' . "\n";
			}
			else
			{
				// do referrer page
				// shows each link which refers
				$retval .= '<th width="5%" nowrap="nowrap">' . $JSLanguage['tableheaders']['t28'] . '</th>'
						. '<th width="10%">' . $JSLanguage['tableheaders']['t18'] . '</th>'
						. '<th align="left" width="100%">' . $JSLanguage['tableheaders']['t24'] . '</th>'
						. '</tr>';

				$totalmax = 0;
				$totalrefferers = 0;

				foreach ($rows AS $row) 
				{
					$totalnmb += $row->counter;

					if ($row->counter > $totalmax) 
						$totalmax = $row->counter;
					$totalrefferers++;
				}

				if ($totalnmb!=0)
				{
					$totalmaxpercent 	= round((($totalmax / $totalnmb) * 100), 1);
					$end 				= $limitstart + $limit;
					$k					= 0;

					for ($ii=0; $ii<count($rows); $ii++) 
					{
						$row = &$rows[$ii];

						if ($ii >= $limitstart && $ii <= $end) 
						{
//						    $percent = round ((($row->counter / $totalnmb) * 100), 1);
						    $percent = round ((int)(($row->counter / $totalnmb) * 100), 1);

                            $retval .= '<tr class="row'. $ii .'">'
                            		. '<td align="center" nowrap="nowrap">&nbsp;'. $row->counter .'</td>'
                            		. '<td align="center" nowrap="nowrap">'
                            		. $this->PercentBar($percent, $totalmaxpercent)                            
                            		. '&nbsp;&nbsp;'. number_format( $percent, 1, ',', '' ) . '%'
                            		. '</td>'
                            		. '<td nowrap="nowrap">'
                            		. '<a href="'. $row->referrer .'" target="_blank" title="'
                            		. $JSLanguage['miscellaneous']['misc77'] . '">' . $row->$selector . '</a>'
                            		. '</td></tr>' . "\n";

							$k = 1 - $k;

                            if ($ii+1 >= $end)
                                break;                            
                        }
					}
				}else{
                    $retval .= '<tr><td colspan="4" style="text-align:center">'
                    . $JSLanguage['messages']['msg05']
                    . '</td></tr>' . "\n";
                }

				// TotalLine
				$retval .= '<tr><th>&nbsp;' . $totalnmb . '</th>'
				. '<th>&nbsp;</th>'
				. '<th align="left">' . $totalrefferers . '&nbsp;'
				. ( $totalrefferers == 1 ? $JSLanguage['miscellaneous']['misc75'] : $JSLanguage['miscellaneous']['misc76'] )
				. '</th></tr>' . "\n";
			}

			$retval .= '</table>';

			if ( !$doreffererdomain )
				$retval .= '<div style="text-align:center">[&nbsp;'
				. '<a href="javascript:document.adminForm.dom.value=\'\';submitbutton(\'r10\');">'
				. $JSLanguage['miscellaneous']['misc11'] . '</a>'
				. '&nbsp;]</div>';

			$retval .= $pageNav->getListFooter();

			return $retval;
		}
		
		
		
		function getNotIdentified()
		/*
		 * case r11
		 * unknown vistors
		 */
		{
			global $database, $mainframe;
			global $mosConfig_debug, $mosConfig_list_limit, $mosConfig_live_site;
			global $JSLanguage;
			global $option;

			$limit	= intval( $mainframe->getUserStateFromRequest( "viewlistlimit", 'limit', $mosConfig_list_limit ) );
	        $limitstart	= intval( $mainframe->getUserStateFromRequest( "viewlimitstart", 'limitstart', 0 ) );
            // mic: search not activated as of 2006.12.23, prepared for later
            //$search		= $mainframe->getUserStateFromRequest( "search{$option}", 'search', '' );
            //$search		= $database->getEscaped( trim( strtolower( $search ) ) );

			$where = array();

			$retval = '<table class="adminlist" cellspacing="0" width="100%">' . "\n"
			. '<tr>'
			. '<th align="left" width="10%">' . $JSLanguage['tableheaders']['t15'] . '</th>'
			. '<th align="left" width="5%">' . $JSLanguage['tableheaders']['t19'] . '</th>'
			. '<th align="left" width="10%">' . $JSLanguage['tableheaders']['t11'] . '</th>'
			. '<th align="left" width="75%">' . $JSLanguage['tableheaders']['t27'] . '</th>'			
			. '</tr>';

			$this->resetVar(1);

			$where[] = "a.tld = b.tld";
			$where[] = "c.ip_id = a.id";
			$where[] = "a.type = 0";
			$where[] = "c.day LIKE '$this->d'";
			$where[] = "c.month LIKE '$this->m'";
			$where[] = "c.year LIKE '$this->y'";

			/* mic: show only actual data (without already archived/purged)
			 * a.table : jstats_ipadresses
             * c.table : jstats_visits
             */
            if ( !defined( '_JS_SHOW_PDATA' ) )
                $where[] = 'a.id = c.ip_id AND c.id >= ' . $this->buid();            

            // get total records
			$query = "SELECT COUNT(*)"
			. "\n FROM #__jstats_ipaddresses AS a, #__jstats_topleveldomains AS b, #__jstats_visits AS c"
			. ( count( $where ) ? "\n WHERE " . implode( ' AND ', $where ) : "" );
			$database->setQuery( $query );
			$total = $database->loadResult();

			require_once( $GLOBALS['mosConfig_absolute_path'] . '/administrator/includes/pageNavigation.php' );
			$pageNav = new mosPageNav( $total, $limitstart, $limit );

			$query = "SELECT a.tld, b.fullname, a.useragent, c.time"
			. "\n FROM #__jstats_ipaddresses AS a, #__jstats_topleveldomains AS b, #__jstats_visits AS c"
			. ( count( $where ) ? "\n WHERE " . implode( ' AND ', $where ) : "" )
			. "\n ORDER BY c.time DESC";
			$database->setQuery( $query );
			
			if ( $this->JS_Compat() )
				$database->setQuery( $query, $pageNav->limitstart, $pageNav->limit );
			else
			{
				$query .= "\n LIMIT $pageNav->limitstart, $pageNav->limit";
				$database->setQuery( $query );
			}
			$rows = $database->loadObjectList();

			$this->resetVar(0);

			if ( $rows )
			{
				$k = 0;
			    foreach( $rows AS $row ) 
			    {
                    $retval .= '<tr class="row' . $k . '">'
                    . '<td nowrap="nowrap">' . $row->time. '</td>'
                    . '<td nowrap="nowrap">&nbsp;' . $row->tld . '</td>'
                    . '<td nowrap="nowrap">&nbsp;' . $row->fullname . '</td>'
                    . '<td nowrap="nowrap">&nbsp;' . $row->useragent . '</td>';                    
                    $retval .= '</tr>';
                    $k = 1 - $k;
                }
            }else
            	$retval .= '<tr><td colspan="4" style="text-align:center">'
            	. $JSLanguage['messages']['msg05']
            	. '</td></tr>';
            

			$retval .= '</table>' . "\n";
			$retval .= $pageNav->getListFooter();
			
			return $retval;
		}
		
		
		function getUnknown()
		/*
		 * case r12
		 * unknown bots
		 */
		{
			global $database, $mainframe;
			global $mosConfig_debug, $mosConfig_list_limit, $mosConfig_live_site;
			global $JSLanguage;
			global $option;

			$limit	= intval( $mainframe->getUserStateFromRequest( "viewlistlimit", 'limit', $mosConfig_list_limit ) );
	        $limitstart	= intval( $mainframe->getUserStateFromRequest( "viewlimitstart", 'limitstart', 0 ) );

			$where = array();

			$retval = '<table class="adminlist" cellspacing="0" width="100%">' . "\n" . '<tr>'
			. '<th align="left" width="10%">' . $JSLanguage['tableheaders']['t15'] . '</th>'
			. '<th align="left" width="5%">' . $JSLanguage['tableheaders']['t19'] . '</th>'
			. '<th align="left" width="10%">' . $JSLanguage['tableheaders']['t11'] . '</th>'
			. '<th align="left" width="75%">' . $JSLanguage['tableheaders']['t27'] . '</th>'			
			. '</tr>';

			$this->resetVar(1);

			$where[] = "a.tld = b.tld";
			$where[] = "c.ip_id = a.id";
			$where[] = "a.browser LIKE 'Unknown%'";
			$where[] = "c.day LIKE '$this->d'";
			$where[] = "c.month LIKE '$this->m'";
			$where[] = "c.year LIKE '$this->y'";

			/* mic: show only actual data (without already archived/purged)
			 * a.table : jstats_ipadresses
             * c.table : jstats_visits
             */
            if( !defined( '_JS_SHOW_PDATA' ) )
                $where[] = 'a.id = c.ip_id AND c.id >= ' . $this->buid();
            

            // get total records
			$query = "SELECT COUNT(*)"
			. "\n FROM #__jstats_ipaddresses AS a, #__jstats_topleveldomains AS b, #__jstats_visits AS c"
			. ( count( $where ) ? "\n WHERE " . implode( ' AND ', $where ) : "" );
			$database->setQuery( $query );
			$total = $database->loadResult();

			require_once( $GLOBALS['mosConfig_absolute_path'] . '/administrator/includes/pageNavigation.php' );
			$pageNav = new mosPageNav( $total, $limitstart, $limit );

			$query = "SELECT a.tld, b.fullname, a.useragent, c.time"
			. "\n FROM #__jstats_ipaddresses AS a, #__jstats_topleveldomains AS b, #__jstats_visits AS c"
			. ( count( $where ) ? "\n WHERE " . implode( ' AND ', $where ) : "" )
			. "\n ORDER BY c.time DESC";
			$database->setQuery( $query );
			
			if ( $this->JS_Compat() )
				$database->setQuery( $query, $pageNav->limitstart, $pageNav->limit );
			else
			{
				$query .= "\n LIMIT $pageNav->limitstart, $pageNav->limit";
				$database->setQuery( $query );
			}
			$rows = $database->loadObjectList();

			$this->resetVar(0);

			if ( $rows ) 
			{
				$k = 0;
			    foreach ( $rows AS $row )
			    {
                    $retval .= '<tr class="row' . $k . '">'
                    . '<td nowrap="nowrap">' . $row->time . '</td>'
                    . '<td nowrap="nowrap">&nbsp;' . $row->tld . '</td>'
                    . '<td nowrap="nowrap">&nbsp;' . $row->fullname . '</td>'
                    . '<td nowrap="nowrap">&nbsp;' . $row->useragent . '</td>'                    
                    . '</tr>';

                    $k = 1 - $k;
                }
             }
             else
            	$retval .= '<tr><td colspan="4" style="text-align:center">'
            	. $JSLanguage['messages']['msg05']
            	. '</td></tr>';

			$retval .= '</table>' . "\n";
			$retval .= $pageNav->getListFooter();
			
			return $retval;
		}

//////////////////////////////////////////////////////////////////////////////////////

		function moreVisitInfo()
		/*
		 * case r03a & task r09a
		 * Displays pages with counts
		 * called by case r03 & r09
		 * input: $this->vid : id
		 * 		  $this->dom : name (optional)
		 */		
		{		
			global $database, $task;
			global $mosConfig_debug;
			global $mainframe;
			global $JSLanguage;

			$vid = intval( $mainframe->getUserStateFromRequest( 'vid', 'vid', '' ) );

			if ( !$vid ) 
				$vid = $this->vid;

			if( $mosConfig_debug )
			{
			    echo 'this->vid [ ' . $this->vid . ' ]<br />';
                echo 'this->dom [ ' . $this->dom . ' ]<br />';
                echo 'vid [ ' . $vid . ' ]<br />';
            }

			$totalnmb = 0;

			$retval = '<table class="adminlist" cellspacing="0" width="100%">' . "\n" . '<tr>'
			. '<th align="left">' . $JSLanguage['tableheaders']['t28'] . '</th>'
			. '<th align="left" width="100%">' . $JSLanguage['tableheaders']['t20'] . '</th>'
			. '</tr>';

			$this->resetVar(1);

			$query = "SELECT count( * ) AS count, b.page, b.page_title"
			. "\n FROM #__jstats_page_request AS a"
			. "\n LEFT JOIN #__jstats_pages AS b ON b.page_id = a.page_id"
			. "\n WHERE a.ip_id = $vid"
			. "\n GROUP BY b.page";
			$database->setQuery( $query );
			$rows = $database->loadObjectList();

			$this->resetVar(0);

			if ( $rows ) 
			{
			    foreach( $rows AS $row ) 
			    {
                    if( $row->page_title == ''){
                        $retval .= '<tr><td nowrap="nowrap">&nbsp;' . $row->count . '</td>'
                        . '<td nowrap="nowrap">'
                        . '<a href="' . htmlentities( $row->page ) . '" target="_blank"'
                        . 'title="' . $JSLanguage['miscellaneous']['misc28'] . '">' . $row->page . '</a>'
                        . '</td></tr>' . "\n";
                    }else{
                        $retval .= '<tr><td nowrap="nowrap">&nbsp;' . $row->count . '</td>'
                        . '<td nowrap="nowrap">'
                        . '<a href="' . htmlentities( $row->page ) . '" target="_blank"'
                        . 'title="' . $JSLanguage['miscellaneous']['misc28'] . '">' . $row->page_title . '</a>'
                        . '</td></tr>' . "\n";
                    }
                }
            }else{
            	$retval .= '<tr><td colspan="4" style="text-align:center">'
            	. $JSLanguage['messages']['msg05']
            	. '</td></tr>';
            }

			$retval .= '<tr><th colspan="2">&nbsp;</th></tr>' . "\n"
			. '</table>' . "\n";

			$retval .= '<div style="text-align:center">[&nbsp;';

			if( $task == 'r09a' ){
				$retval .= '<a href="javascript:document.adminForm.dom.value=\'' . rawurlencode( $this->dom )
				. '\';javascript:document.adminForm.vid.value=\'' . $this->vid . '\';submitbutton(\'r09\');">';
			}else{
				$retval .= '<a href="javascript:submitbutton(\'r03\');">';
			}

			$retval .= $JSLanguage['miscellaneous']['misc11'] . '</a>'
			. '&nbsp;]</div>';

			return $retval;
		}


		
		function morePathInfo()
		/*
		 * case r03b ( direct from case 03)
		 */
		{
			global $database;
			global $JSLanguage;

			$totalnmb = 0;

			$retval = '<table class="adminlist" cellspacing="0" width="100%">' . "\n" . '<tr>'
			. '<th align="left" width="100%">' . $JSLanguage['tableheaders']['t20'] . '</th>'
			. '</tr>';

			$this->resetVar(0);

			$query = "SELECT b.page, b.page_title"
			. "\n FROM #__jstats_page_request AS a"
			. "\n LEFT JOIN #__jstats_pages AS b ON b.page_id = a.page_id"
			. "\n WHERE a.ip_id = $this->vid"
			;
			$database->setQuery( $query );
			$rows = $database->loadObjectList();

			$this->resetVar(0);

			if( $rows )
			{
			    foreach( $rows AS $row ) 
			    {
			    	$retval .= '<tr><td nowrap="nowrap">'
                    . '<a href="' . htmlentities( $row->page ) . '" target="_blank" title="'
                    . $JSLanguage['miscellaneous']['misc77'] . '">'
                    . ( $row->page_title == '' ? $row->page : $row->page_title )
                    . '</a>'
                    . '</td></tr>';
                }
            }else{
            	$retval .= '<tr><td colspan="4" style="text-align:center">'
            	. $JSLanguage['messages']['msg05']
            	. '</td></tr>';
            }

            $retval .= '<tr><th>&nbsp;</th></tr>'
			. '</table>' . "\n"
			. '<div style="text-align:center">[&nbsp;'
			. '<a href="javascript:submitbutton(\'r03\');">' . $JSLanguage['miscellaneous']['misc11'] . '</a>'
			. '&nbsp;]</div>';

			return $retval;
		}
		
		
		
		function getSearches()
		/*
		 * case r14
		 */
		
		{
			global $database, $mainframe;
			global $mosConfig_debug, $mosConfig_list_limit, $mosConfig_live_site;
			global $JSLanguage;

			$where				= array();
			$totalnmb 			= 0;
			$totalmax 			= 0;
			$do_search_engines 	= 0;
			$totalsearches 		= 0;

			$retval = '<table class="adminlist" cellspacing="0" width="100%">' . "\n" . '<tr>';

			if( $this->dom == '' ){
				// If function not called before, then start with search engines table
				$this->dom 			= '%';
				$do_search_engines	= 1;
			}

			$this->resetVar(1);

			$where[] = "YEAR(a.kwdate) LIKE '$this->y'";
			$where[] = "MONTH(a.kwdate) LIKE '$this->m'";
			$where[] = "DAYOFMONTH(a.kwdate) LIKE '$this->d'";

			if( !$do_search_engines ){
				$where[] = "b.description LIKE '$this->dom'";
			}

			if( $do_search_engines ){
				// Search Engines
				$query = "SELECT b.description, count(*) AS count"
				. "\n FROM #__jstats_keywords AS a"
				. "\n LEFT JOIN #__jstats_search_engines AS b ON a.searchid = b.searchid"
				. ( count( $where ) ? "\n WHERE " . implode( ' AND ', $where ) : "" )
				. "\n GROUP BY b.description"
				. "\n ORDER BY count DESC"
				;
			}else{
				// Search Keyphrases
				$query = "SELECT a.keywords, count(*) AS count"
				. "\n FROM #__jstats_keywords AS a"
				. "\n LEFT JOIN #__jstats_search_engines AS b ON a.searchid = b.searchid"
				. ( count( $where ) ? "\n WHERE " . implode( ' AND ', $where ) : "" )
				. "\n GROUP BY a.keywords"
				. "\n ORDER BY count DESC"
				;
			}
			$database->setQuery( $query );
			$rows = $database->loadObjectList();

			$this->resetVar(0);

			if( $do_search_engines )
			{
				// Search Engines
				$retval .= '<th width="5%" nowrap="nowrap">' . $JSLanguage['tableheaders']['t28'] . '</th>'
				. '<th width="10%">' . $JSLanguage['tableheaders']['t18'] . '</th>'
				. '<th align="left" width="85%">' . $JSLanguage['tableheaders']['t25'] . '</th>'
				. '</tr>' . "\n";

				foreach( $rows AS $row ){
					$totalnmb += $row->count;
					if( $row->count > $totalmax ){
						$totalmax = $row->count;
					}
					$totalsearches++;
				}

				if( $totalnmb != 0 ){
					$totalmaxpercent 	= round( ( ( $totalmax / $totalnmb ) * 100 ), 1 );
					$k					= 0;

					foreach( $rows AS $row ){
					    $percent = round( ( ( $row->count / $totalnmb ) * 100 ), 1 );

                        $retval .= '<tr class="row' . $k . '">' . "\n"
                        . '<td align="center" nowrap="nowrap">&nbsp;' . $row->count . '</td>'
                        . '<td align="left" nowrap="nowrap">&nbsp;'
                        . $this->PercentBar($percent,$totalmaxpercent)
                        . '&nbsp;&nbsp;' . number_format( $percent, 1, ',', '' ) . '%'
                        . '</td>'
                      	. '<td align="left" nowrap="nowrap">&nbsp;'
                        . '<a href="javascript:document.adminForm.dom.value=\''
                        . $row->description
                        . '\';submitbutton(\'r14\');" title="' . $JSLanguage['miscellaneous']['misc29'] . '">'
                        . $row->description . '</a>'
                        . '</td></tr>' . "\n";

                        $k = 1 - $k;
					}
				}else{
                    $retval .= '<tr><td colspan="4" style="text-align:center">'
                    . $JSLanguage['messages']['msg05']
                    . '</td></tr>' . "\n";
                }

				// TotalLine
				$retval .= '<tr><th>&nbsp;' . $totalnmb . '</th><th>&nbsp;</th>';

				if( $totalsearches > 0 )
				{
					$retval .= '<th colspan="2" align="left">'
					. '<a href="javascript:document.adminForm.dom.value=\'%\';submitbutton(\'r14\');">'
					. $JSLanguage['miscellaneous']['misc74'] . '</a>'
					. '</th></tr>' . "\n";
				} else 
					$retval .= '<th align="left">' . $JSLanguage['miscellaneous']['misc71'] . '</th></tr>' . "\n";
				
				$retval .= '</table>' . "\n";
			}else{
				// Search Keyphrases
				$retval .= '<th width="5%" nowrap="nowrap">' . $JSLanguage['tableheaders']['t28'] . '</th>'
				. '<th width="15%">' . $JSLanguage['tableheaders']['t18'] . '</th>'
				. '<th align="left" width="85%">' . $JSLanguage['tableheaders']['t26'] . '</th>'
				. '</tr>';

				foreach( $rows AS $row )
				{
					$totalnmb += $row->count;
					if( $row->count > $totalmax ){
						$totalmax = $row->count;
					}
					$totalsearches++;
				}

				if( $totalnmb !=0 && $rows ){
					$totalmaxpercent 	= round( ( ( $totalmax / $totalnmb ) * 100 ), 1 );
					$k					= 0;

					foreach( $rows AS $row ){
					    $percent = round( ( ( $row->count / $totalnmb ) * 100 ), 1 );

                        $retval .= '<tr class="row' . $k . '">'
                        . '<td align="center" nowrap="nowrap">&nbsp;' . $row->count . '</td>'
                        . '<td align="left" nowrap="nowrap">&nbsp;'
                        . $this->PercentBar($percent,$totalmaxpercent)
                        //. '</td><td align="right" nowrap="nowrap">'
                        . '&nbsp;&nbsp;' . number_format( $percent, 1, ',', '' ) . '%'
                        . '</td>'
                        . '<td width="100%" align="left" nowrap="nowrap">'
                        . wordwrap( $row->keywords, 100, '<br />' ) . '</td>'
                        . '</tr>' . "\n";

                        $k = 1 - $k;
					}
				}else{
                    $retval .= '<tr><td colspan="4" style="text-align:center">'
                    . $JSLanguage['messages']['msg05']
                    . '</td></tr>';
                }

				// TotalLine
				$retval .= '<tr><th>&nbsp;' . $totalnmb . '</th>'
                . '<th>&nbsp;</th>'
                . '<th align="left">' . $totalsearches . '&nbsp;'
                . ( $totalsearches == 1 ? $JSLanguage['miscellaneous']['misc72'] : $JSLanguage['miscellaneous']['misc73'] )
                . '</th></tr>' . "\n"
				. '</table>' . "\n"
				. '<div style="text-align:center">[&nbsp;'
                . '<a href="javascript:submitbutton(\'r14\');">' . $JSLanguage['miscellaneous']['misc11'] . '</a>'
                . '&nbsp;]</div>';
			}

			return $retval;
		}
		
		
		
		
		function GetConfiguration()
		{
			global $database;
			global $JSLanguage;
			
			mosCommonHTML::loadOverlib();
			$tabs = new mosTabs( 1 );
			// existing page_requests
			$query = "SELECT count(*)"
			. "\n FROM #__jstats_page_request";
            $database->setQuery($query);
            $pr_sum = $database->loadResult();
            
            ?>			
			<table width="100%" border="0" cellpadding="2" cellspacing="0" class="adminForm">
                <tr>
                    <td>
                        <?php
                        $tabs->startPane( 'jssystem' );
                        $tabs->startTab( $JSLanguage['tabs']['tab01'], 'general' );
                        ?>
                        <table class="adminform" width="100%" border="0" cellspacing="5" cellpadding="0">
                            <tr>
                                <td nowrap="nowrap"><?php echo $JSLanguage['config']['c01']; ?></td>
                                <td>
                                    <select name="onlinetime">
                                    <?php
                                    echo '<option value="10"'. ( $this->onlinetime == 10 ? ' selected="selected"' : '' ) . '>10 ' . $JSLanguage['miscellaneous']['misc31'] . '</option>' . "\n";
                                    echo '<option value="15"'. ( $this->onlinetime == 15 ? ' selected="selected"' : '' ) . '>15 ' . $JSLanguage['miscellaneous']['misc31'] . '</option>' . "\n";
                                    echo '<option value="20"'. ( $this->onlinetime == 20 ? ' selected="selected"' : '' ) . '>20 ' . $JSLanguage['miscellaneous']['misc31'] . '</option>' . "\n";
                                    echo '<option value="25"'. ( $this->onlinetime == 25 ? ' selected="selected"' : '' ) . '>25 ' . $JSLanguage['miscellaneous']['misc31'] . '</option>' . "\n";
                                    echo '<option value="30"'. ( $this->onlinetime == 30 ? ' selected="selected"' : '' ) . '>30 ' . $JSLanguage['miscellaneous']['misc31'] . '</option>' . "\n";
                                    echo '<option value="60"'. ( $this->onlinetime == 60 ? ' selected="selected"' : '' ) . '>60 ' . $JSLanguage['miscellaneous']['misc31'] . '</option>' . "\n";
                                    echo '<option value="90"'. ( $this->onlinetime == 90 ? ' selected="selected"' : '' ) . '>90 ' . $JSLanguage['miscellaneous']['misc31'] . '</option>' . "\n";
                                    echo '<option value="120"'. ( $this->onlinetime == 120 ? ' selected="selected"' : '' ) . '>2 ' . $JSLanguage['miscellaneous']['misc32'] . '</option>' . "\n";
                                    echo '<option value="240"'. ( $this->onlinetime == 240 ? ' selected="selected"' : '' ) . '>4 ' . $JSLanguage['miscellaneous']['misc32'] . '</option>' . "\n";
                                    echo '<option value="480"'. ( $this->onlinetime == 480 ? ' selected="selected"' : '' ) . '>8 ' . $JSLanguage['miscellaneous']['misc32'] . '</option>' . "\n";
                                    echo '<option value="720"'. ( $this->onlinetime == 720 ? ' selected="selected"' : '' ) . '>12 ' . $JSLanguage['miscellaneous']['misc32'] . '</option>' . "\n";
                                    echo '<option value="1440"'. ( $this->onlinetime == 1440 ? ' selected="selected"' : '' ) . '>24 ' . $JSLanguage['miscellaneous']['misc32'] . '</option>' . "\n";
                                    ?>
                                    </select>
                                </td>
                                <td width="100%">
                                    &nbsp;
                                    <?php
                                    $tip = $JSLanguage['tooltips']['ttc01'];
                                    echo mosToolTip( $tip );
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td nowrap="nowrap"><?php echo $JSLanguage['config']['c02']; ?></td>
                                <td>
                                    <select name="startoption">
                                        <?php
                                        echo '<option value="r01"'. ( $this->startoption == 'r01' ? ' selected="selected"' : '' ) . '>' . $JSLanguage['config']['c03'] . '</option>' . "\n";
                                        echo '<option value="r02"'. ( $this->startoption == 'r02' ? ' selected="selected"' : '' )
                                        . '>' . $JSLanguage['config']['c04'] . '</option>' . "\n";
                                        echo '<option value="r03"'. ( $this->startoption == 'r03' ? ' selected="selected"' : '' )
                                        . '>' . $JSLanguage['config']['c05'] . '</option>' . "\n";
                                        echo '<option value="r04"'. ( $this->startoption == 'r04' ? ' selected="selected"' : '' )
                                        . '>' . $JSLanguage['config']['c06'] . '</option>' . "\n";
                                        echo '<option value="r05"'. ( $this->startoption == 'r05' ? ' selected="selected"' : '' )
                                        . '>' . $JSLanguage['config']['c07'] . '</option>' . "\n";
                                        echo '<option value="r06"'. ( $this->startoption == 'r06' ? ' selected="selected"' : '' )
                                        . '>' . $JSLanguage['config']['c08'] . '</option>' . "\n";
                                        echo '<option value="r07"'. ( $this->startoption == 'r07' ? ' selected="selected"' : '' )
                                        . '>' . $JSLanguage['config']['c09'] . '</option>' . "\n";
                                        echo '<option value="r08"'. ( $this->startoption == 'r08' ? ' selected="selected"' : '' )
                                        . '>' . $JSLanguage['config']['c10'] . '</option>' . "\n";
                                        echo '<option value="r09"'. ( $this->startoption == 'r09' ? ' selected="selected"' : '' )
                                        . '>' . $JSLanguage['config']['c11'] . '</option>' . "\n";
                                        echo '<option value="r10"'. ( $this->startoption == 'r10' ? ' selected="selected"' : '' )
                                        . '>' . $JSLanguage['config']['c12'] . '</option>' . "\n";
                                        echo '<option value="r14"'. ( $this->startoption == 'r14' ? ' selected="selected"' : '' )
                                        . '>' . $JSLanguage['config']['c13'] . '</option>' . "\n";
                                        echo '<option value="r11"'. ( $this->startoption == 'r11' ? ' selected="selected"' : '' )
                                        . '>' . $JSLanguage['config']['c14'] . '</option>' . "\n";
                                        echo '<option value="r12"'. ( $this->startoption == 'r12' ? ' selected="selected"' : '' )
                                        . '>' . $JSLanguage['config']['c15'] . '</option>' . "\n";
                                        ?>
                                    </select>
                                </td>
                                <td>
                                    &nbsp;
                                    <?php
                                    $tip = $JSLanguage['tooltips']['ttc02'];
                                    echo mosToolTip( $tip );
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td nowrap="nowrap"><?php echo $JSLanguage['config']['c16']; ?></td>
                                <td>
                                    <select name="language">
                                        <?php
                                        echo '<option value="auto"' . ( ( $this->langini == 'auto' ) ? ' selected="selected"' : '' ) . '>Auto</option>' . "\n";
                                        $langdir = $this->absolute_path
                                        . '/administrator/components/com_joomlastats/language/';
                                        // Open a known directory, and proceed to read its contents
                                        if( is_dir( $langdir ) ){
                                           if( $dh = opendir( $langdir ) ){
                                               while( ( $file = readdir( $dh ) ) !== false ){
                                                    if( ( $file != '.' ) && ( $file != '..' ) && ( $file != 'index.html' ) ){
                                                    	$file = ( str_replace( 'admin_', '', $file ) );
                                                        echo '<option value="' . substr( $file, 0, 2 ) . '"' . ( ( substr( $file, 0, 2 ) == $this->langini ) ? ' selected="selected"' : '' ) . '>' . substr( $file, 0, 2 ) . '</option>' . "\n";
                                                    }
                                               }
                                               closedir( $dh );
                                           }
                                        } ?>
                                    </select>
                                </td>
                                <td>
                                    &nbsp;
                                    <?php
                                    $tip = $JSLanguage['tooltips']['ttc03'];
                                    echo mosToolTip( $tip );
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td nowrap><?php echo $JSLanguage['config']['c17']; ?></td>
                                <td>
                                    <input type="text" name="timelimit" size="4" value="<?php echo $this->purgetime; ?>" /></td>
                                <td>
                                    &nbsp;
                                    <?php
                                    $tip = $JSLanguage['tooltips']['ttc04'];
                                    echo mosToolTip( $tip ); ?>
                                </td>
                            </tr>
                            <tr>
                                <td nowrap="nowrap"><?php echo $JSLanguage['config']['c25']; ?></td>
                                <td>
                                    <input type="checkbox" name="show_bu"<?php echo ( $this->show_bu ? ' checked="checked"' : '' ); ?> />
                                </td>
                                <td>
                                    &nbsp;
                                    <?php
                                    $tip = $JSLanguage['tooltips']['ttc09'];
                                    echo mosToolTip( $tip ); ?>
                                    &nbsp;
                                    <em><?php echo ( $this->last_purge ? $JSLanguage['config']['c27'] . ':&nbsp;'
                                    . $this->last_purge : $JSLanguage['tooltips']['ttc11'] ); ?></em>
                                </td>
                            </tr>
                            <tr>
                                <td nowrap="nowrap"><?php echo $JSLanguage['config']['c18']; ?></td>
                                <td>
                                    <input type="checkbox" name="enable_whois"<?php echo ( $this->enable_whois ? ' checked="checked"' : '' ); ?> />
                                </td>
                                <td>
                                    &nbsp;
                                    <?php
                                    $tip = $JSLanguage['tooltips']['ttc05'];
                                    echo mosToolTip( $tip ); ?>
                                </td>
                            </tr>
                            <tr>
                                <td nowrap="nowrap"><?php echo $JSLanguage['config']['c19']; ?></td>
                                <td>
                                    <input type="checkbox" name="enable_i18n"<?php echo ( $this->enable_i18n ? ' checked="checked"' : '' ); ?> /></td>
                                <td>
                                    &nbsp;
                                    <?php
                                    $tip = $JSLanguage['tooltips']['ttc06'];
                                    echo mosToolTip( $tip ); ?>
                                </td>
                            </tr>
                        </table>
                        <?php
                        $tabs->endTab();
                        $tabs->startTab( $JSLanguage['tabs']['tab02'], 'tools' );
                        ?>
                        <table width="100%" border="0" cellpadding="2" cellspacing="0" class="adminForm">
                        	<tr>
                                <td width="200" align="left">
                                	<?php
                                	if ($pr_sum) { ?>
                                    	<input type="button" name="summinfo" style="width:165px" value="<?php echo $JSLanguage['config']['c20']; ?>" onclick="if(confirm('<?php echo $JSLanguage['messages']['msg22']; ?>'))submitbutton('summinfo');" />
                                    	<?php
                                	}else
                                    	echo $JSLanguage['info']['info20'];                                    
                                    ?>
                                </td>
                                <td>
                                    &nbsp;
                                    <?php
                                    $tip = $JSLanguage['tooltips']['ttc10'];
                                    echo mosWarning( $tip ); ?>
                                    &nbsp;
                                    <?php echo $JSLanguage['config']['c27']; ?>:
                                    &nbsp;
                                	<?php echo ( $this->last_purge ? $this->last_purge : $JSLanguage['miscellaneous']['misc30'] ); ?>
                                	&nbsp;[
                                	<?php
                                	echo $JSLanguage['info']['info19'] . ':&nbsp;';
                                	echo $pr_sum; ?>
                                	]
                                </td>
                          </tr>
                            <tr>
                                <td width="200" align="left">
                                    <input type="button" name="purge_database" style="width:165px" value="<?php echo $JSLanguage['config']['c26']; ?>" onclick="if(confirm('<?php echo $JSLanguage['messages']['msg06']; ?>'))submitbutton('purgedb');" />
                                </td>
                                <td>
                                    &nbsp;
                                    <?php
                                    $tip = $JSLanguage['tooltips']['ttc12'];
                                    echo mosWarning( $tip ); ?>
                                </td>
                          </tr>
                          <tr>
                                <td>
                                	<?php
                                	if( $pr_sum ) { ?>
                                    	<input type="button" name="backup" style="width:165px" value="<?php echo $JSLanguage['config']['c23']; ?>" onclick="if(confirm('<?php echo $JSLanguage['messages']['msg20']; ?>'))submitbutton('jsbackup');" />
                                    	<?php
                                    }else{
                                    	echo $JSLanguage['info']['info20'];
                                    } ?>
                                </td>
                                <td>
                                	&nbsp;
                                    <?php
                                    $tip = $JSLanguage['tooltips']['ttc07'];
                                    echo mosToolTip( $tip ); ?>
                                </td>
                          	</tr>
                          	<tr>
                                <td>
                                    <input type="button" name="backup" style="width:165px" value="<?php echo $JSLanguage['config']['c24']; ?>" onclick="if(confirm('<?php echo $JSLanguage['messages']['msg20']; ?>'))submitbutton('jsbackupcomplete');" />
                                </td>
                                <td>
                                	&nbsp;
                                    <?php
                                    $tip = $JSLanguage['tooltips']['ttc08'];
                                    echo mosToolTip( $tip ); ?>
                                </td>
                          	</tr>
                        </table>
                        <?php
                        $tabs->endTab();
                        $tabs->startTab( $JSLanguage['tabs']['tab03'], 'export' );
                        /*
                         * jstats_ipaddresses
                         * jstats_keywords
                         * jstats_page_request
                         * jstats_page_request_c
                         * jstats_pages
                         * jstats_referrer
                         * jstats_visits
                         */
                        ?>
                        <table width="100%" border="0" cellpadding="2" cellspacing="0" class="adminForm">
                        	<tr>
                        		<td width="220">
                        			<table border="0">
                        				<tr>
                        		            <td width="200">
                                                <label for="act1"><?php echo $JSLanguage['config']['c05']; ?></label>
                                            </td>
                                            <td>
                                                <input type="radio" name="act" id="act1" value="1" />
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <label for="act2"><?php echo $JSLanguage['config']['c13']; ?></label>
                                            </td>
                                            <td>
                                                <input type="radio" name="act" id="act2" value="2" />
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <label for="act3"><?php echo $JSLanguage['config']['c28']; ?></label>
                                            </td>
                                            <td>
                                                <input type="radio" name="act" id="act3" value="3" />
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <label for="act4"><?php echo $JSLanguage['config']['c29']; ?></label>
                                            </td>
                                            <td>
                                                <input type="radio" name="act" id="act4" value="4" />
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <label for="act5"><?php echo $JSLanguage['config']['c30']; ?></label>
                                            </td>
                                            <td>
                                                <input type="radio" name="act" id="act5" value="5" />
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <label for="act6"><?php echo $JSLanguage['config']['c12']; ?></label>
                                            </td>
                                            <td>
                                                <input type="radio" name="act" id="act6" value="6" />
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <label for="act7"><?php echo $JSLanguage['config']['c31']; ?></label>
                                            </td>
                                            <td>
                                                <input type="radio" name="act" id="act7" value="7" />
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                          		<td align="left" width="200">
                                    <input type="button" name="export2csv" style="width:165px" value="<?php echo $JSLanguage['config']['c32']; ?>" onclick="if(confirm('<?php echo $JSLanguage['messages']['msg24']; ?>'))submitbutton('jsexport2csv');" />
                                </td>
                                <td align="left">
                                	&nbsp;
                                    <?php
                                    $tip = $JSLanguage['tooltips']['ttc14'];
                                    echo mosToolTip( $tip ); ?>
                                </td>
                          	</tr>
                        </table>
                        <?php
                        $tabs->endTab();
                        $tabs->endPane(); ?>
                    </td>
                </tr>
            </table>
            <?php
		}
		
		

		function PurgeDatabase()
		{
			global $database;
			global $JSLanguage;

			$queri 	= array();
			$errors = array();
			$i		= 0;

			$queri[] = "DELETE FROM #__jstats_ipaddresses";
			$queri[] = "DELETE FROM #__jstats_iptocountry";
			$queri[] = "DELETE FROM #__jstats_keywords";
			$queri[] = "DELETE FROM #__jstats_page_request";
			$queri[] = "DELETE FROM #__jstats_page_request_c";
			$queri[] = "DELETE FROM #__jstats_pages";
			$queri[] = "DELETE FROM #__jstats_referrer";
			$queri[] = "DELETE FROM #__jstats_visits";

			foreach ($queri AS $query)
			{
                $database->setQuery($query);
                if (!$database->query())
                    $errors[] = array($database->getErrorMsg(), $query);
				else
					$i++;
			} ?>

			<div class="adminform" width="100%">
            	<div style="margin-left:100px">
            		<?php
            		if (!$errors)
            			echo $i . ' ' . $JSLanguage['messages']['msg16'];
            		else
            		{
            			echo '<span style="color:red">' . $JSLanguage['messages']['msg17'] . '</span>';
            			echo '<br />';
            			echo '<ul>';
            			foreach ($errors AS $err)
            				echo '<li>' . $err . '</li>';
            			echo '</ul>';
            		} ?>
            	</div>
            </div>
			<?php
		}
		
		
		

		function GetInformation()
		{
			global $database;
			global $mosConfig_live_site;
			global $JSLanguage;

            $totalbots      = '';
            $totalbrowser   = '';
            $totalse        = '';
            $totalsys       = '';
            $totaltld       = '';
            $totalipc       = '';

            // get infos from db
            $query = "SELECT count(*) AS totalbots FROM #__jstats_bots";
            $database->setQuery($query);
            $totalbots = $database->loadResult();

            $query = "SELECT count(*) AS totalbrowser FROM #__jstats_browsers";
            $database->setQuery($query);
            $totalbrowser = $database->loadResult();

            $query = "SELECT count(*) AS totalse FROM #__jstats_search_engines";
            $database->setQuery($query);
            $totalse = $database->loadResult();

            $sql = "SELECT count(*) AS totalsys FROM #__jstats_systems";
            $database->setQuery($query);
            $totalsys = $database->loadResult();

            $query = "SELECT count(*) AS totaltld FROM #__jstats_topleveldomains";
            $database->setQuery($query);
            $totaltld = $database->loadResult();

            $query = "SELECT count(*) totalipc FROM #__jstats_iptocountry";
            $database->setQuery($query);
            $totalipc = $database->loadResult();
            // user called pages
            $query = "SELECT count(*) totalpages FROM #__jstats_pages";
            $database->setQuery($query);
            $totalpages = $database->loadResult();
            // user page requests
            $query = "SELECT count(*) totalpagerequest FROM #__jstats_page_request";
            $database->setQuery($query);
            $totalpagerequest = $database->loadResult();
            // user page requests (backup)
            $query = "SELECT count(*) bu_totalpagerequest FROM #__jstats_page_request_c";
            $database->setQuery($query);
            $bu_totalpagerequest = $database->loadResult();
            // user referer
            $query = "SELECT count(*) totalreferrer FROM #__jstats_referrer";
            $database->setQuery($query);
            $totalpagereferrer = $database->loadResult();
            // user visits
            $query = "SELECT count(*) totalvisits FROM #__jstats_visits";
            $database->setQuery($query);
            $totalvisits = $database->loadResult();
            ?>

			<table cellspacing="0" cellpadding="4" border="0" width="75%" align="center">
				<tr>
					<td valign="top" class="sectionname">
						<span class="sectionname"><img align="middle" height="67" width="70" src="<?php echo $mosConfig_live_site; ?>/components/com_joomlastats/images/joomlastats.png" alt=".|." />
						JoomlaStats&nbsp;
						<?php echo $JSLanguage['header']['head08']; ?>
						</span>
					</td>
					<td class="small" valign="bottom" align="right">
						&nbsp;&nbsp;Version:&nbsp;<?php echo $this->getdbversion(); ?>
					</td>
                </tr>
				<tr>
                    <td colspan="2">
        				<?php echo $JSLanguage['info']['info12']; ?>
        				<br />          				
          		    </td>
                </tr>
                <tr>
                	<td colspan="2">
                		<table class="adminform" width="100%" align="center" style="border: 1px solid #CCCCCC;">
							<tr>
								<td colspan="4" style="font-weight:bold; text-align:center;">
                                    <?php echo $JSLanguage['info']['info01']; ?>
                                    <hr />
                                </td>
                            <tr>
                                <td width="220"><?php echo $JSLanguage['info']['info02']; ?></td>
                                <td width="150" align="left"><?php echo $totalbots; ?></td>
                                <td width="220" align="left"><?php echo $JSLanguage['info']['info03']; ?></td>
                                <td width="150" align="left"><?php echo $totalpages; ?></td>
                             </tr>
                             <tr>
                                <td><?php echo $JSLanguage['info']['info06']; ?></td>
                                <td align="left"><?php echo $totalbrowser; ?></td>
                                <td align="left"><?php echo $JSLanguage['info']['info04']; ?></td>
                                <td align="left">
                                	<?php echo $totalpagerequest . ' [ ' . $bu_totalpagerequest . ' ] *'; ?>
                                </td>
                             </tr>
                             <tr>
                                <td><?php echo $JSLanguage['info']['info07']; ?></td>
                                <td align="left"><?php echo $totalse; ?></td>
                                <td align="left"><?php echo $JSLanguage['info']['info05']; ?></td>
                                <td align="left"><?php echo $totalpagereferrer; ?></td>
                             </tr>
                             <tr>
                                <td><?php echo $JSLanguage['info']['info08']; ?></td>
                                <td align="left"><?php echo $totalsys; ?></td>
                                <td align="left"><?php echo $JSLanguage['info']['info09']; ?></td>
                                <td align="left"><?php echo $totalvisits; ?></td>
                             </tr>
                             <tr>
                                <td><?php echo $JSLanguage['info']['info10']; ?></td>
                                <td align="left"><?php echo $totaltld; ?></td>
                                <td colspan="2">&nbsp;</td>
                             </tr>
                             <tr>
                                <td><?php echo $JSLanguage['info']['info11']; ?></td>
                                <td align="left"><?php echo $totalipc; ?></td>
                                <td align="left"><?php echo $JSLanguage['config']['c27']; ?></td>
                                <td><?php echo ( $this->last_purge ? $this->last_purge : $JSLanguage['miscellaneous']['misc30'] ); ?></td>
                             </tr>
                             <?php
                             if( $totalipc < 1 ){ ?>
                                 <tr>
                                    <td style="color:red; font-weight:bold;" valign="top">
                                    	<?php echo $JSLanguage['info']['info17']; ?>:
                                    </td>
                                    <td colspan="3" valign="top">
                                        <span style="color:red;">
                                            <?php echo $JSLanguage['info']['info13']; ?>
                                        </span>
                                        <br />
                                        <?php echo $JSLanguage['info']['info14']; ?>
                                    </td>
                                 </tr>
                                 <?php
                             } ?>
                             <tr>
                                <td valign="top">&nbsp;</td>
                                <td colspan="3" align="left"><?php echo $JSLanguage['info']['info18']; ?></td>
                             </tr>
                        </table>
                    </td>
                </tr>
                <?php
                if (   !file_exists($GLOBALS['mosConfig_absolute_path']. '/modules/mod_jstats_activate.php')
                	&& !file_exists($GLOBALS['mosConfig_absolute_path']. '/mambots/system/bot_jstats_activate.php')
                	&& !file_exists($GLOBALS['mosConfig_absolute_path']. '/modules/mod_joostat.php')                	
                	&& !file_exists($GLOBALS['mosConfig_absolute_path']. '/mambots/system/joostat.php'))
                	// need to also check into the template
                {
                	?>
                    <tr>
                        <td colspan="2">
                            <span style="color:red; font-weight:bold;">
                            <?php echo $JSLanguage['info']['info15']; ?>
                            </span>
                        </td>
                    </tr>
                    
                    <tr>
    					<td colspan="2"><?php echo $JSLanguage['info']['info16']; ?></td>
    				</tr>
                    <tr>
                    	<td colspan="2">	
    					<br /><?php echo $JSLanguage['info']['info21']; ?><br />
          				<pre>
   &lt;?php
   if (file_exists($mosConfig_absolute_path."/components/com_joomlastats/joomlastats.inc.php")) 
      require_once($mosConfig_absolute_path."/components/com_joomlastats/joomlastats.inc.php");
   ?&gt;
          				</pre>
						</td></tr>
				<?php
    			}
				else
				{	
					?>
					<br /><?php echo $JSLanguage['info']['info22']; ?><br /><br />
					<?php	
				} ?>

          		
    			
                <tr>
                	<td colspan="2" class="smallgrey" valign="top">
                    	<div align="center">
                    	<span class="smalldark">
                        ©2003-2007 JoomlaStats Team - All rights reserved.<br />
                        <a href="http://www.JoomlaStats.org" target="_blank" title="Visit Homepage">JoomlaStats</a>
                        is Free Software released under the GNU/GPL License.<br />
                        </span>
                        </div>
                    </td>
                </tr>
                <br />
            </table>
            <form name="adminForm" method="post" action="index2.php">
                <input type="hidden" name="option" value="com_joomlastats" />
                <input type="hidden" name="task" value="<?php echo $this->task; ?>" />
                <input type="hidden" name="act" value="" />
                <input type="hidden" name="boxchecked" value="0" />
            </form>
  			<?php
		}


/*
 *  function from mic 
 * 
 * 
		function GetSummariseInfo(){
			global $mosConfig_live_site;
			global $JSLanguage; ?>

            <table cellspacing="0" cellpadding="4" border="0" width="100%">
            <tbody>
            	<tr>
                	<td valign="top" class="sectionname">
                    	<span class="sectionname"><img align="middle" height="67" width="70" src="<?php echo $mosConfig_live_site; ?>/administrator/components/com_joomlastats/images/joomlastats.png" alt="JoomlaStats" /><?php echo $JSLanguage['summarize']['s01']; ?></span>
                	</td>
              	</tr>
              	<tr>
                  	<td><?php echo $JSLanguage['summarize']['s02']; ?>
                    	<ul>
                            <li><?php echo $JSLanguage['summarize']['s03']; ?></li>
                            <li><?php echo $JSLanguage['summarize']['s04']; ?></li>
                            <li><?php echo $JSLanguage['summarize']['s05']; ?></li>
                            <li><?php echo $JSLanguage['summarize']['s06']; ?></li>
                            <li><?php echo $JSLanguage['summarize']['s07']; ?></li>
                    	</ul>
                    	<div style="font-weight:bold"><?php echo $JSLanguage['summarize']['s08']; ?></div>
                    	<div><?php echo $JSLanguage['summarize']['s09']; ?></div>
                  	</td>
              	</tr>
              	<tr>
                	<td class="small" valign="top">&nbsp;&nbsp;Version : <?php echo $this->getdbversion(); ?></td>
				</tr>
              	<tr>
                	<td class="smallgrey" valign="top">
                        <div align="center">
                        <span class="smalldark">
                        ©2003-2007 PJH Diender - All rights reserved.<br />
                        <a href="http://www.JoomlaStats.org" target="_blank" title="Visit Homepage">JoomlaStats</a>
                        is Free Software released under the GNU/GPL License.<br />
                        </span>
                        </div>
                    </td>
                </tr>
            </tbody>
            </table>

          	<form name="adminForm" method="post" action="index2.php">
          	    <input type="hidden" name="option" value="com_joomlastats" />
                <input type="hidden" name="task" value="" />
                <input type="hidden" name="boxchecked" value="0" />
            </form>
  			<?php
		}

 * 
 * 
 * 
 * 
 */


		function GetSummariseInfo()
		{
			?>
		<form name="adminForm" method="post" action="index2.php">
		<input type="hidden" name="option" value="com_joomlastats">
		<input type="hidden" name="task" value="<?PHP echo $this->task; ?>">
		<input type="hidden" name="act" value="" />
		<input type="hidden" name="boxchecked" value="0">
		</form>		
				<table cellspacing="0" cellpadding="4" border="0" width="100%">
					<tbody>
					  <tr> 
						<td valign="top" class="sectionname">
					<span class="sectionname"><img align="middle" height="67" width="70" src="../components/com_joomlastats/images/joomlastats.png">JoomlaStats Summarise information</span></td>
				  </tr>
				<tr>
				
      <td> The summarise process will group the page requests from "old" visitors by 
        <ul>
			<li>page</li>
          	<li>hour</li>
          	<li>day</li>
          	<li>month</li>
          	<li>year</li>
        </ul>
		<p><strong>This process will only affect the possibility to see who visited 
          which page.</strong></p>
        <p>After this process you will not be able to see who visited which page 
          (url in visitors section of JoomlaStats)<br>
          By visitors who come after you have done this you can see which pages 
          they visited.<br>
          <br>
          This process will reduce the size of the JoomlaStats tables. </p></td>
					</tr>
					<tr> 
						<td class="small" valign="top">&nbsp;&nbsp;Version: <?PHP echo _JoomlaStats_V; ?></td>
					  </tr>
					  <tr> 
						<td class="smallgrey" valign="top"> <div align="center"> <span class="smalldark"> 
							JoomlaStats.org ©2003 - 2007 All rights reserved. <br>
							<a href="http://www.JoomlaStats.org">JoomlaStats</a> is Free 
							Software released under the GNU/GPL License. <br>
							</span></div></td>
					  </tr>
					</tbody>
				  </table>
  		<?php
		}

		function GetUnInstallInfo()
		{
			global $JSLanguage;
			global $mosConfig_live_site; ?>

			<table cellspacing="0" cellpadding="4" border="0" width="100%">
				<tbody>
					<tr>
						<td valign="top" class="sectionname">
							<span class="sectionname">
								<img src="<?php echo $mosConfig_live_site; ?>/components/com_joomlastats/images/joomlastats.png" width="70" height="67" align="middle" alt="JoomlaStats" /><?php echo $JSLanguage['uninstall']['ui01']; ?>
							</span>
						</td>
				  	</tr>
					<tr>
						<td valign="top"><?php echo $JSLanguage['uninstall']['ui02']; ?>
						</td>
					</tr>
					<tr>
						<td class="small" valign="top">&nbsp;&nbsp;Version : <?php $this->getdbversion(); ?></td>
					</tr>
					<tr>
						<td class="smallgrey" valign="top">
                    	    <div align="center">
                            <span class="smalldark">
                            JoomlaStats.org ©2003 - 2007 All rights reserved. <br />
                            <a href="http://www.JoomlaStats.org" target="_blank" title="Visit Homepage">JoomlaStats</a>
                            is Free Software released under the GNU/GPL License.<br />
                            </span>
                            </div>
                        </td>
					</tr>
				</tbody>
			</table>
			<form name="adminForm" method="post" action="index2.php">
				<input type="hidden" name="option" value="com_joomlastats" />
				<input type="hidden" name="task" value="" />
                <input type="hidden" name="boxchecked" value="0" />
            </form>
  			<?php
		}
	
	
	
	
	

		function DoSummariseTask()
		/*
		 * case summtask (purge)
		 * - summarizes #__jstats_page_request
		 * - copies the data in #__jstats_page_request_c
		 * - afterwards empties it
		 *
		 * mic: there are 3 statements remarked, they show if an record is tranfered/deleted
		 * to activate, delete remark - but, the list could be very, very long!
		 *
		 * @param	ret	bool	return to original task
		 */
	
		{
			global $database, $mosConfig_live_site;
			global $JSLanguage;

			$i 		= 0;
			$count	= 0;
			$now 	= date('Y-m-d H:i:s', time() + $GLOBALS['mosConfig_offset'] * 60 * 60);

			if (empty($msg))
				$msg = array();

			$start = time();

			$query  = "SELECT page_id, hour, day, month, year, count(*) AS count"
					. "\n FROM #__jstats_page_request"
					. "\n GROUP BY page_id, hour, day, month, year";
			$database->setQuery($query);
			$rows = $database->loadObjectList();

			// if php is not in safe mode than set max execution time
			if (!ini_get('safe_mode'))
				set_time_limit($this->purgetime);			

			if ($rows)
			{
                foreach ($rows AS $row)
                {
                	// check if row still exists
                	$query  = "SELECT count(*)"
            	    		. "\n FROM #__jstats_page_request_c"
                    		. "\n WHERE page_id = ". $row->page_id
                 		   	. "\n AND hour = ". $row->hour
                  		  	. "\n AND day = ". $row->day
                	    	. "\n AND month = ". $row->month
                    		. "\n AND year = ". $row->year;                    
                    $database->setQuery( $query );
                    $count = $database->loadResult();

                    if ($count)
                    {
                        // update backup table (adding values)
                        $query  = "UPDATE #__jstats_page_request_c"
               	         		. "\n SET count = count + " . $row->count
              	          		. "\n WHERE page_id = " . $row->page_id
              	          		. "\n AND hour = " . $row->hour
               	         		. "\n AND day = " . $row->day
               	         		. "\n AND month = " . $row->month
                	        	. "\n AND year = " . $row->year;
                        $database->setQuery( $query );

                        if (!$database->query()) 
                        {
                            // if update was not successful, insert entry
                            $query = "INSERT INTO #__jstats_page_request_c (page_id, hour, day, month, year, count)"
								. "\n VALUES ("
								. $row->page_id . "," . $row->hour . "," . $row->day .","
								. $row->month . "," . $row->year . "," . $row->count .")";
                            $database->setQuery( $query );

                            if (!$database->query())
                            {
                                // leave, because there is something wrong!
                                echo "<script> alert('"
                                . $database->getErrorMsg() . "'); window.history.go(-1); </script>\n";
                                exit();
                            }
                        }
                        /*
                        // mic: optional
                        $msg[] = '<li>' . $JSLanguage['messages']['msg14'] . '</li>';
                        */
					}
					else
					{
                        // if update was not successful, insert entry
                        $query = "INSERT INTO #__jstats_page_request_c (page_id, hour, day, month, year, count)"
                        	. "\n VALUES ("
                        	. $row->page_id . "," . $row->hour . "," . $row->day .","
                        	. $row->month . "," . $row->year . "," . $row->count .")";
                        $database->setQuery( $query );

                        if (!$database->query() )
                        {
                            echo "<script> alert('".$database->getErrorMsg()."'); window.history.go(-1); </script>\n";
                            exit();
                        }

						/*
                        else{
                            // mic: optional
                            $msg[] = '<li>' . $JSLanguage['messages']['msg14'] . '</li>';
                        } */

                    }

                    if ( !$ret )                    //RB: $ret is nowhere defined?!? so will always be 0???
                    {
                        // delete old entries
                        $query = "DELETE FROM #__jstats_page_request"
                        . "\n WHERE page_id = " . $row->page_id
                        . "\n AND hour = " . $row->hour
                        . "\n AND day = " . $row->day
                        . "\n AND month = " . $row->month
                        . "\n AND year = " . $row->year
                        ;
                        $database->setQuery( $query );
                        if( !$database->query() ) 
                        {
                            echo "<script> alert('".$database->getErrorMsg()."'); window.history.go(-1); </script>\n";
                            exit();
                        }
                        /*
                        // mic: optional
                        else{
                            echo '<li>' . $JSLanguage['messages']['msg15'] . '</li>';
                        }
                        */
                    }

                    $i++;
                }

                // update purge time
                $query = "UPDATE #__jstats_configuration"
                	. "\n SET value = '" . $now . "'"
                	. "\n WHERE description = 'last_purge'";
                $database->setQuery( $query );
                $database->query();

            }
            else
            	$msg[] = $JSLanguage['messages']['msg05'];
            

            $end = time();

            if(  ( $end - $start ) > ( ( $this->purgetime ) -1 ) )
            {
                $this->updatemsg = $JSLanguage['messages']['msg10'];
                $msg[] = '<li>' . $JSLanguage['messages']['msg10'] . '</li>';
            }

			$query = "OPTIMIZE TABLE #__jstats_page_request";
			$database->setQuery( $query );
			if ( !$database->query() )
			{
	            echo "<script> alert('".$database->getErrorMsg()."'); window.history.go(-1); </script>\n";
                exit();
            }
            else
            {
            	$msg[] = '<li>' . $JSLanguage['messages']['msg12'] . '</li>';
            }

			if ( !empty( $end ) )
			{
			    if ( ( $end - $start ) < $this->purgetime )
			    {
                    $this->updatemsg = $JSLanguage['messages']['msg11'];
                    $msg[] = '<li>' . $JSLanguage['messages']['msg11'] . '</li>';
                }
            }

			if ( $i )
                $msg[] = '<li>' . $JSLanguage['messages']['msg13'] . ': ' . $i . '</li>';

            if ( $ret )
            	return;
            
            ?>

            <div class="adminform" width="100%">
            	<div style="margin-left:100px">
            		<ul>
            		<?php
                    foreach( $msg AS $message ){
                        echo $message;
                    } ?>
					</ul>
				</div>
			</div>
			<?php

			// mosRedirect( "index2.php?option=com_joomlastats&task=stats" ); // mic: better this way
		}
		
		

		function DoUnInstallTask()
		{
			global $database;
			global $JSLanguage;	// is this needed to define $JSLanguage? 

			$queri 	= array();
			$errors = array();

			$queri[] = "DROP TABLE `#__jstats_bots`";
			$queri[] = "DROP TABLE `#__jstats_browsers`";
			$queri[] = "DROP TABLE `#__jstats_configuration`";
			$queri[] = "DROP TABLE `#__jstats_ipaddresses`";
			$queri[] = "DROP TABLE `#__jstats_iptocountry`";
			$queri[] = "DROP TABLE `#__jstats_keywords`";
			$queri[] = "DROP TABLE `#__jstats_page_request`";
			$queri[] = "DROP TABLE `#__jstats_page_request_c`";
			$queri[] = "DROP TABLE `#__jstats_pages`";
			$queri[] = "DROP TABLE `#__jstats_referrer`";
			$queri[] = "DROP TABLE `#__jstats_search_engines`";
			$queri[] = "DROP TABLE `#__jstats_systems`";
			$queri[] = "DROP TABLE `#__jstats_topleveldomains`";
			$queri[] = "DROP TABLE `#__jstats_visits`";

			foreach( $queri AS $query )
			{
                $database->setQuery( $query );
                if( !$database->query() ) 
                {
                    $errors[] = array( $database->getErrorMsg(), $query );
				}else{
					$i++;		//RB: 2 mic/// i++ ???? i is not used???
				}
			} ?>

			<div class="adminform" width="100%">
            	<div style="margin-left:100px">
            		<?php
            		if( !$error ){	//RB 2 Mic: error is not defined before, so always 0 ???
            			echo $JSLanguage['messages']['msg16'];
            		}else{
            			echo '<span style="color:red">' . $JSLanguage['messages']['msg17'] . '</span>';
            			echo '<br />';
            			echo '<ul>';
            			foreach( $error AS $err ){
            				echo '<li>' . $err . '</li>';
            			}
            			echo '</ul>';
            		} ?>
            	</div>
            </div>
			<?php
		}

		/*
		 * backup routine
		 * new by mic 2006.12.16
		 * 2 parts: 1. part backup (only _page_request), 2. full backup - all tables
		 * backup existing tables, create original tables new
		 */
		function JSBackupTables( $complete = false )
		{
			global $database;
			global $mosConfig_db, $mosConfig_dbprefix, $mosConfig_debug, $mosConfig_absolute_path;
			global $JSLanguage;
			global $msg;

            $i          = 0;
            $errors     = array();
            $msg        = array();
            $quer       = array();
            $buprefix   = 'bu_' . date( 'YmdHi' ) . '_';

            JoomlaStats_Engine::DoSummariseTask( true );

            if( empty( $complete ) ){
                // partial backup
                $tables = array( $mosConfig_dbprefix . 'jstats_page_request' );
                // step 1: backup tables
                foreach( $tables AS $table ){
                    $butable = str_replace( $mosConfig_dbprefix, $buprefix, $table );
                    $query = "RENAME TABLE `$table` TO `$butable`";

                    if ($mosConfig_debug) 
                    {
                        echo 'query: '. $query .'<br />';
                        echo 'table: '. $table .'<br />';
                        echo 'butable: '. $butable .'<br />';
                    }

                    $database->setQuery( $query );
                    if (!$database->query())
                    	$errors[$database->getQuery()] = $database->getErrorMsg();
                    else
                    {
                        $msg[] = $table . ' ' . $JSLanguage['messages']['msg18'];
                        $i++;
                    }
                }

                //step 2: create them new (again: add here what you want)
                $quer[] = 'CREATE TABLE IF NOT EXISTS `#__jstats_page_request` ('
                . ' `page_id` mediumint(9) NOT NULL default \'0\','
                . ' `hour` tinyint(4) NOT NULL default \'0\','
                . ' `day` tinyint(4) NOT NULL default \'0\','
                . ' `month` tinyint(4) NOT NULL default \'0\','
                . ' `year` smallint(6) NOT NULL default \'0\','
                . ' `ip_id` mediumint(9) default NULL,'
                . ' KEY `page_id` (`page_id`),'
                . ' KEY `monthyear` (`month`,`year`),'
                . ' KEY `visits_id` (`ip_id`),'
                . ' KEY `index_ip` (`ip_id`)'
                . ' ) TYPE=MyISAM';

                foreach( $quer AS $query ){
                    $database->setQuery( $query );
                    if( !$database->query() ) {
                        $errors[] = array( $database->getErrorMsg(), $query );
                    }else{
                        $msg[] = '1 ' . $JSLanguage['messages']['msg18'];
                        $i++;
                    }
                }
            }else{
                // full backup
                // step 1: call for tables an backup (rename)
                $query = "SHOW TABLES FROM `$mosConfig_db` LIKE '" . $mosConfig_dbprefix . "%jstats%'";
                $database->setQuery( $query );

                if( $tables = $database->loadResultArray() ) {
                    foreach ($tables as $table) {
                        if( strpos( $table, $mosConfig_dbprefix ) === 0 ) {
                            $butable = str_replace( $mosConfig_dbprefix, $buprefix, $table );
                            $query = "RENAME TABLE `$table` TO `$butable`";
                            $database->setQuery( $query );
                            $database->query();

                            if ($database->getErrorNum()) {
                                $errors[$database->getQuery()] = $database->getErrorMsg();
                            }else{
                                $msg[] = $table . ' ' . $JSLanguage['messages']['msg18'];
                                $i++;
                            }
                        }
                    }
                }
                // step 2: read in new tables and populate (all done inside the included file)
                include_once( $mosConfig_absolute_path
                . '/administrator/components/com_joomlastats/joomlastats_db.inc.php' );
            } ?>

            <div class="adminform" width="100%">
            	<div style="margin-left:100px">
            		<ul>
                    <?php
            		if( !$errors ){
            			echo '<li>' . $i . ' ' . $JSLanguage['messages']['msg18'] . '</li>' ;
            			if( !empty( $msg ) ) {
            			    foreach( $msg AS $message ) {
                                echo '<li>' . $message . '</li>';
                            }
                        }
            		}else{
            			echo '<li><span style="color:red">' . $JSLanguage['messages']['msg17'] . '</span></li>';
            			foreach( $errors AS $err ){
            				echo '<li>' . $err . '</li>';
            			}
            		} ?>
            		</ul>
            	</div>
            </div>
            <?php
        }

        
        function JSExport2CVS( $act )
        /*
         * export to csv.file
         * new by mic 2006.12.29
         * @param	act		int
         */
        {
        	global $mosConfig_db, $mosConfig_dbprefix, $mosConfig_sitename;
        	global $database;
        	global $JSLanguage;

            $csv	= NULL;
            $now 	= date( 'Y-m-d H:i:s', time() + $GLOBALS['mosConfig_offset'] * 60 * 60 );

            $tables = array(
            	'1' => 'jstats_ipaddresses',
            	'2' => 'jstats_keywords',
            	'3' => 'jstats_page_request',
            	'4' => 'jstats_page_request_c',
            	'5' => 'jstats_pages',
            	'6' => 'jstats_referrer',
            	'7' => 'jstats_visits'
            	);

            $table = $mosConfig_dbprefix . $tables[$act];

            // table: table name
            $csv .= '"' . $mosConfig_sitename . ' - ' . $table . ' - ' . $now . "\n";

            // table: header field names
            $query = "SHOW COLUMNS FROM " . $table;
            $database->setQuery( $query );
            $rows = $database->loadObjectList();

            foreach( $rows AS $row )
                $csv .= '"' . $row->Field . '",';
            
            $csv = trim( substr( $csv, 0, -1 ) ) . "\n";

            // table: fields
            $query = "SELECT * FROM " . $table;
            $database->setQuery( $query );

            if ($rows = $database->loadObjectList())
            {
                foreach( $rows AS $row )
                {
                    if (is_object($row))
                    {
                        foreach( $row AS $r )
                            $csv .= '"' . $r . '",';
                        
                        $csv = trim( substr( $csv, 0, -1 ) ) . "\n";
                    }else
                        $csv .= '"' . $row . '",';                    
                    $csv = trim( substr( $csv, 0, -1 ) ) . "\n";
                }

                header( 'Content-type: application/vnd.ms-excel; charset=UTF-8' );
                header( 'Content-disposition: csv; filename=' . date( 'Ymd_His' ) . '_' . $table . '.csv; size=' . strlen( $csv ) );

                echo $csv;
                exit(); // important!!
            }else{ ?>
            	<div class="adminform" width="100%" style="color:red">
                	[&nbsp;<?php echo $table; ?>&nbsp;]&nbsp;<?php echo $JSLanguage['messages']['msg23']; ?>
                </div>
                <?php
            }
        }

        
		function JoomlaStatsHeader()
		{
			global $mosConfig_live_site, $mosConfig_debug;
			global $mainframe, $JSLanguage;

			// get JS specific values
			
            $this->d = $mainframe->getUserStateFromRequest($this->d, 'd', '%');
            
            $visittime = (time() + ($this->hourdiff * 3600));			
            $this->m = $mainframe->getUserStateFromRequest($this->m, 'm', date('n',$visittime));
            $this->y = $mainframe->getUserStateFromRequest($this->y, 'y', date('Y',$visittime));
		
		
			if ($mosConfig_debug || !empty($JSDebug))
			{
				echo 'debug:<br /> [vid[' . $this->vid . ']]&nbsp;&nbsp;';
                echo '[dom"' . $this->dom . '"]<br />' . "\n";
                echo 'search: "'. $_POST['search'] .'"-"'. $mainframe->getUserStateFromRequest($search, 'search', '') .'"<br />';
                echo '[d"' . $this->d . '"]&nbsp;&nbsp;';
                echo '[m"' . $this->m . '"]&nbsp;&nbsp;';
                echo '[y"' . $this->y . '"]<br />' . "\n";
            }

			if ((    $this->task != 'getconf' )
            	&& ( $this->task != 'purgedb' )
            	&& ( $this->task != 'uninstalltask' )
            	&& ( $this->task != 'tldlookup' )
	            && ( $this->task != 'summtask' )
            	&& ( $this->task != 'jsbackup' )
            	&& ( $this->task != 'jsbackupcomplete' ) ) 
            {?>
                <script type="text/javascript">
                    /* <![CDATA[ */
                    function SelectDay(Value)
                    {
                        for (index=0; index<document.adminForm.d.length; index++)
                        {
                        	/* walk the list */
                            if (document.adminForm.d[index].value == Value)
                            {
                            	/* if the day is the day we want to select */
                                document.adminForm.d.selectedIndex = index;
                                /* then mark it selected */
                            }
                        }
                    }

                    function UpdateD()
                    {
                        if (document.adminForm.cb_d.checked)
                            document.adminForm.d.disabled = true;
                        else
                            document.adminForm.d.disabled = false;
                    }

                    function UpdateM()
                    {
                        if (document.adminForm.cb_m.checked)
                            document.adminForm.m.disabled = true;
                        else
                            document.adminForm.m.disabled = false;                        
                    }

					function UpdateY()
                    {
                        if (document.adminForm.cb_y.checked)
                            document.adminForm.y.disabled = true;
                        else
                            document.adminForm.y.disabled = false;                        
                    }


                    function LastChecks()
                    {
                    	// day check
                        if (document.adminForm.cb_d.checked && !document.adminForm.cb_d.disabled)
                        {
                            if (document.adminForm.d.options[document.adminForm.d.length-1] != "total")
                                document.adminForm.d.options[document.adminForm.d.length] = new Option("<?php echo $JSLanguage['miscellaneous']['misc99']; ?>","total");                            
                            document.adminForm.d.selectedIndex = document.adminForm.d.length-1;
                            document.adminForm.d.disabled = false;
                        }
                        // month check
                        if (document.adminForm.cb_m.checked && !document.adminForm.cb_m.disabled)
                        {
                            if (document.adminForm.m.options[document.adminForm.m.length-1] != "total")
                                document.adminForm.m.options[document.adminForm.m.length] = new Option("<?php echo $JSLanguage['miscellaneous']['misc99']; ?>","total");                            
                            document.adminForm.m.selectedIndex = document.adminForm.m.length-1;
                            document.adminForm.m.disabled = false;
                        }
                        // year check
                        if (document.adminForm.cb_y.checked && !document.adminForm.cb_y.disabled)
                        {
                            if (document.adminForm.y.options[document.adminForm.y.length-1] != "total")
                                document.adminForm.y.options[document.adminForm.y.length] = new Option("<?php echo $JSLanguage['miscellaneous']['misc99']; ?>","total");                            
                            document.adminForm.y.selectedIndex = document.adminForm.y.length-1;
                            document.adminForm.y.disabled = false;
                        }
                    }
                    /* ]]> */
                </script>
                <?php
            } ?>

			<form name="adminForm" method="post" action="index2.php">

			<input type="hidden" name="option" value="com_joomlastats" />
			<input type="hidden" name="task" value="<?php echo $this->task; ?>" />
			<input type="hidden" name="act" value="" />
			<input type="hidden" name="vid" value="" />
			<input type="hidden" name="dom" value="" />
			<input type="hidden" name="boxchecked" value="0" />
			<?php
			if ($this->task != 'r03')	// RB: if we are not on a page using search, we just pass seach value as hidden value, so if we come back to a page that uses search value, it is still known.  
			{
			?>
				<input type="hidden" name="search" value="<?php echo $mainframe->getUserStateFromRequest($search, 'search', ''); ?>" />
			<?php
			}
			?>
			<table border="0" align="center" cellspacing="0" width="100%">
			  <tr>
				<td>
					<table class="adminlist" border="0" cellspacing="0" width="100%">
					<!-- 1st row: Logo + date selection -->
					<tr>
						<td width="100%" class="sectionname">
						    <img align="bottom" height="67" width="70" src="<?php echo $mosConfig_live_site; ?>/components/com_joomlastats/images/joomlastats.png" alt="JoomlaStats" />
                            <big>&nbsp;JoomlaStats</big>
                            &nbsp;[&nbsp;<small>
                            <?php
                            if( $this->task == 'getconf' )
                            	echo $JSLanguage['header']['head02'];
                            elseif( $this->task == 'purgedb' )
                            	echo $JSLanguage['header']['head03'];
                            elseif( $this->task == 'uninstalltask' )
                            	echo $JSLanguage['header']['head04'];
                            elseif( $this->task == 'summtask' )
                            	echo $JSLanguage['header']['head06'];
                            elseif( $this->task == 'jsbackup' )
                            	echo $JSLanguage['header']['head07'];
                            elseif( $this->task == 'jsbackupcomplete' )
                            	echo $JSLanguage['header']['head09'];
                            else
                            	echo $JSLanguage['header']['head05'];
                            ?>
                            </small>&nbsp;]
						</td>
						<td>
						<?php
						if (($this->task != 'getconf' )
						&& ( $this->task != 'purgedb' )
						&& ( $this->task != 'uninstalltask' )
						&& ( $this->task != 'tldlookup' )
						&& ( $this->task != 'summtask' )
						&& ( $this->task != 'jsbackup' )
						&& ( $this->task != 'jsbackupcomplete' )) 
						{ ?>
							<table border="0" cellspacing="0" cellpadding="0" width="300">
								<tr>
									<td style="vertical-align:middle">
								  		<br /><?php echo $JSLanguage['miscellaneous']['misc82']; ?>:
									</td>
									<td>
										<select name="d">
											<?php
											//<!-- combo day here -->
											$this->CreateDayCmb(); ?>
										</select>
										<?php
										if( $this->d == "total" || $this->d == '%')
											echo '<input type="checkbox" name="cb_d" checked="checked" disabled="disabled" />';
										else
											echo '<input type="checkbox" name="cb_d" value="total" onChange="UpdateD();" />';
										?>
									</td>
									<td>
										<select name="m">
										    <!-- combo month here -->
                                            <?php $this->CreateMonthCmb(); ?>
									  	</select>
									  	<?php
										if ($this->m == "total" || $this->m == '%' )
											echo '<input type="checkbox" name="cb_m" checked="checked" disabled="disabled" />';											
										else
											echo '<input type="checkbox" name="cb_m" value="total" onChange="UpdateM();" />';											
										?>
									</td>
									<td>
										<select name="y">
										    <!-- combo year here -->
                                            <?php $this->CreateYearCmb(); ?>
									  	</select>
										<?php
										if ($this->y == "total" || $this->y == '%' )
											echo '<input type="checkbox" name="y" checked="checked" disabled="disabled" />';											
										else
											echo '<input type="checkbox" name="y" value="total" />';
										?>
									</td>
									<td>
										<input type="submit" name="Submit" value="Go" onClick="LastChecks();" />
										<!-- hidden value for display stats -->
									  </td>
								  </tr>
								  <?php
								  if ($this->task == 'r03')	// if we are on the visitors table
								  { ?>
								      <tr>
                                        <td colspan="5">
                                        <?php echo $JSLanguage['miscellaneous']['misc21']; ?>:&nbsp;
								  			<input type="text" name="search" value="<?php echo (!empty($_POST['search']) ? $_POST['search'] : $mainframe->getUserStateFromRequest($search, 'search', '')); ?>" class="text_area" onChange="document.adminForm.submit();" title="<?php echo $JSLanguage['miscellaneous']['misc10']; ?>" />
								  	    </td>
                                      </tr>
                                      <?php
								  } ?>
								</table>
								<?php
							}else{
								echo '&nbsp;';
							} ?>
						</td>
					</tr>
					<?php
					if( ( $this->task != 'getconf' )
					&& ( $this->task != 'purgedb' )
					&& ( $this->task != 'uninstalltask' )
					&& ( $this->task != 'tldlookup' )
					&& ( $this->task != 'summtask' )
					&& ( $this->task != 'jsbackup' )
					&& ( $this->task != 'jsbackupcomplete' ) ) { ?>
					<!-- 2nd row: info line -->
					<tr class="row0">
						<td>
                            <span style="color:#000000"><?php echo $JSLanguage['miscellaneous']['misc80']; ?>:
                            <b><?php $this->getdbversion(); ?></b>
                            </span>
                            &nbsp;||&nbsp;
                            <span style="color:#000000"><?php echo $JSLanguage['miscellaneous']['misc81']; ?>:
                            <b><?php $this->getdbsize(); ?>&nbsp;
                            <?php echo $JSLanguage['miscellaneous']['misc07']; ?>&nbsp;</b>
                            </span>
                            &nbsp;||&nbsp;&copy;&nbsp;2003&nbsp;-&nbsp;2007&nbsp;<a href="http://www.JoomlaStats.org" title="JoomlaStats" target="_blank">JoomlaStats</a>
                        </td>
                        <td nowrap="nowrap" align="right">
                        <?php echo '&nbsp;'. $JSLanguage['translation']['trans01'] .':&nbsp;'. $JSLanguage['translation']['trans02']; ?>
                        &nbsp;&nbsp;
                        </td>
                    </tr>
                    <!-- 3rd row: menu -->
					<tr>
						<td colspan="2"><?php $this->menu(); ?></td>
					</tr>
			   </table>
			   <table class="adminlist" border="0" cellspacing="0" width="100%">
			   		<tr>
						<th>
						<!-- 4rd row: title of report here -->
							<div style="width:50%; float:left; text-align:right">
								<?php $this->DisplayTitle(); ?>
							</div>
							<div style="width:50%; float:right; text-align:right; color:#FF0000">
								<?php echo ( defined( '_JS_SHOW_PDATA' ) ? $JSLanguage['miscellaneous']['misc26']
								. ( $this->last_purge ? ' [ '. $this->last_purge . ' ]' : '' ) : '' ); ?>
							</div>
						</th>
					</tr>
			   </table>
			   <?php
			   	$this->resetVar(1);
			}else{
				echo '</table>';
			}
		}

		function JoomlaStatsfooter(){ ?>
			  </td>
			  </tr>
			</table>
			</form>
		<?php
		}

		function listIpAddresses( &$rows, $pageNav, $search, $option ) {
			global $mosConfig_live_site;
			global $JSLanguage; ?>

		    <form name="adminForm" method="post" action="index2.php">
                <input type="hidden" name="option" value="com_joomlastats" />
                <input type="hidden" name="task" value="<?php echo $this->task; ?>" />
                <input type="hidden" name="act" value="" />
                <input type="hidden" name="boxchecked" value="0" />
                <table cellpadding="4" cellspacing="0" border="0" width="100%">
                    <tr>
                    <td width="100%" class="sectionname">
                        <img src="<?php echo $mosConfig_live_site; ?>/components/com_joomlastats/images/joomlastats.png" width="70" height="67" align="middle" alt="JoomlaStats" />
                        <big>Joomlastats</big>
                        &nbsp;[&nbsp;<small>
                        <?php echo $JSLanguage['header']['head01']; ?>
                        </small>&nbsp;]
                    </td>
                    <td nowrap="nowrap"><?php echo $JSLanguage['miscellaneous']['misc20']; ?></td>
                    <td><?php echo $pageNav->writeLimitBox(); ?></td>
                    <td><?php echo $JSLanguage['miscellaneous']['misc21']; ?>:</td>
                    <td>
                    	<input type="text" name="search" value="<?php echo $search;?>" class="inputbox" onChange="document.adminForm.submit();" />
                    </td>
                    </tr>
                </table>
                <table cellpadding="4" cellspacing="0" border="0" width="100%" class="adminlist">
                    <tr>
                        <th width="2%" class="title">#</th>
                        <th width="3%" class="title">
                        	<input type="checkbox" name="toggle" value="" onClick="checkAll(<?php echo count($rows); ?>);" />
                        </th>
                        <th width="20%" class="title"><?php echo $JSLanguage['tableheaders']['t31']; ?></th>
                        <th width="40%" class="title"><?php echo $JSLanguage['tableheaders']['t12']; ?></th>
                        <th width="15%" class="title"><?php echo $JSLanguage['tableheaders']['t13']; ?></th>
                        <th width="15%" class="title"><?php echo $JSLanguage['tableheaders']['t14']; ?></th>
                        <th width="5%" class="title"><?php echo $JSLanguage['tableheaders']['t32']; ?></th>
                        </tr>
                        <?php
                        $k = 0;
                        for( $i = 0, $n = count( $rows ); $i < $n; $i++ ){
                            $row	=& $rows[$i];
                            $img	= $row->exclude ? 'tick.png' : 'publish_x.png';
                            $task	= $row->exclude ? 'unexclude' : 'exclude';
                            $alt	= $row->exclude ? $JSLanguage['messages']['msg09'] : $JSLanguage['messages']['msg08'];
                            ?>
                        <tr class="row<?php echo $k; ?>">
                            <td><?php echo $i + 1 + $pageNav->limitstart;?></td>
                            <td>
                            	<input type="checkbox" id="cb<?php echo $i;?>" name="cid[]" value="<?php echo $row->id; ?>" onClick="isChecked(this.checked);" />
                            </td>
                            <td>
                            	<a href="http://<?php echo $row->ip; ?>" target="_blank" title="<?php echo $JSLanguage['miscellaneous']['misc28']; ?>"><?php echo $row->ip; ?></a>
                            </td>
                            <td><?php echo $row->nslookup; ?></td>
                            <td><?php echo $row->system; ?></td>
                            <td><?php echo $row->browser; ?></td>
                            <td width="10%" align="center">
                            <a href="javascript:void(0);" onClick="return listItemTask('cb<?php echo $i;?>','<?php echo $task;?>');" title="<?php echo $alt; ?>"><img src="images/<?php echo $img;?>" width="12" height="12" border="0" alt="<?php echo $alt; ?>" /></a>
                            </td>
                    	</tr>
                        <?php
                        $k = 1 - $k;
                    } ?>
                    <tr>
                      <th align="center" colspan="9"> <?php echo $pageNav->writePagesLinks(); ?></th>
                    </tr>
                    <tr>
                      <td align="center" colspan="9"> <?php echo $pageNav->writePagesCounter(); ?></td>
                    </tr>
                </table>
            </form>
            <?php
		}
	}
?>
        