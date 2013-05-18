<?php
/**
* search.class.php 
* @package com_joomlaboard
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* @author TSMF
**/

// ################################################################
// MOS Intruder Alerts
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );
// ################################################################
 

/**
 * A jbSearch Object
 */
class jbSearch {
	/** search results **/
	var $arr_jb_results;
	/** search strings **/
	var $arr_jb_searchstrings;
	/** error number **/
	var $int_jb_errornr;
	/** error msg **/
	var $str_jb_errormsg;
	/** limit **/
	var $limit;
	/** limitstart **/
	var $limitstart;
	
	/**
	 * Search constructor
	 * @param object database
	 * @param string search 
	 * @param int uid (userid)
	 */
    function jbSearch(&$database,$search,$uid,$limitstart=0,$limit=20) {
    	$this->limitstart=$limitstart;
    	$this->limit=$limit;
    				
  	   	/* handle search string */
  	   	$search=htmlspecialchars($search,ENT_COMPAT,'UTF-8');
    	$arr_searchwords=split(' ',$search);
    	
    	/* return error if empty search string */
    	if (count($arr_searchwords)==0) {
    		$this->int_jb_errornr=2;
    		$this->str_jb_errormsg=_NOKEYWORD;
    		$this->arr_jb_results=array();
    		return array();
    	}
    	
    	for ($x=0;$x<count($arr_searchwords);$x++) {
    		$searchword=$arr_searchwords[$x];
   			$searchword=$database->getEscaped(trim(strtolower($searchword)));
   			$matches=array();
   			$not='';
   			$operator=' OR ';
   			if (strstr($searchword,'-')==$searchword) {
   				$not='NOT';
   				$operator='AND';
   				$searchword=substr($searchword,1);
   			}
   			if (preg_match('/^author:(\w+)/',$searchword,$matches)) {
   				$querystrings[]='m.name '.$not. ' LIKE \'%'.$matches[1].'%\'';
   			}
   			else if (preg_match('/^after:(\d{8})/',$searchword,$matches)) {
   				$querystrings[]='m.time > UNIX_TIMESTAMP('.$matches[1].')';
   			}
   			else if (preg_match('/^before:(\d{8})/',$searchword,$matches)) {
   				$querystrings[]='m.time < UNIX_TIMESTAMP('.$matches[1].')';
   			}
   			else if (preg_match('/^groupby:(\w{4,6})/',$searchword,$matches)) {
   				$groupby[]=$matches[1];
   			}
   			else if (preg_match('/^orderby:(\w{4,6})/',$searchword,$matches)) {
   				$orderby[]=$matches[1];
   			}
   			else {
   				$querystrings[]='(t.message '.$not. ' LIKE \'%'.$searchword.'%\' '. $operator
   								.' m.subject '. $not. ' LIKE \'%'. $searchword. '%\')';
   			}
    	}
    	$this->arr_jb_searchstrings=$arr_searchwords;
    	
    	/* get allowed forums */
    	$allowed_forums='';
    	if ($uid>0) {
    		$database->setQuery('SELECT allowed FROM #__sb_sessions WHERE userid='.$uid);
    		$result=$database->loadResult();
    		if ($result!='na')
    			$allowed_forums=$result;
    	}
    	
    	/* non registered users can only search in public forums */
    	if (empty($allowed_forums)) {
    		 $database->setQuery("SELECT id FROM #__sb_categories WHERE pub_access='0' AND parent='0'");
    		 $arr_pubcats=$database->loadResultArray();
    		 if (count($arr_pubcats) > 0) {
    		 	$database->setQuery('SELECT id FROM #__sb_categories WHERE pub_access=\'0\' AND parent IN ('.implode(',',$arr_pubcats).')');
    		 	$allowed_forums=implode(',',$database->loadResultArray()); 
    		 }
	   	}
    	
    	/* if there are no forums to search in, set error and return */
    	if (empty($allowed_forums)) {
    		$this->int_jb_errornr=1;
    		$this->str_jb_errormsg='No forums to search in.';
    		return 0;
    	}
    	
    	/* build query */
    	$querystrings[]='m.catid IN ('.$allowed_forums.')';
    	$querystrings[]='m.moved!=1';
    	$querystrings[]='m.hold=0';
    	$where=implode(' AND ',$querystrings);
    	if (!empty($orderby))
    		$orderby=implode(',',$orderby);
    	else 
    		$orderby='m.ordering DESC, m.time DESC,m.hits DESC';
    	if (!empty($groupby))
    		$groupby=' GROUP BY '.implode(',',$groupby);
    	else
    		$groupby='';
    	$sql='SELECT m.id,m.subject,m.catid,m.thread,m.name,m.time,t.message FROM #__sb_messages_text as t LEFT JOIN #__sb_messages as m ON m.id=t.mesid WHERE '
   			. $where
   			. $groupby			
   			. ' ORDER BY '. $orderby
   			. ' LIMIT '.$limitstart.','.$limit;
    	/* get total */
   		$database->setQuery('SELECT count(m.id) FROM #__sb_messages as m  LEFT JOIN #__sb_messages_text as t ON m.id=t.mesid WHERE '. $where . $groupby . ' LIMIT 300');
   		$this->total=$database->loadResult();

   		/* get results */
   		$database->setQuery($sql);
   		$rows=$database->loadObjectList();
   		$this->str_jb_errormsg=$sql.'<br />'.$database->getErrorMsg();
   		if (count($rows)>0)
   			$this->arr_jb_results=$rows;
   		else
   			$this->arr_jb_results=array();
   		return $this;
    }
    
	/** get searchstrings (array) **/
    function get_searchstrings() {
    	return $this->arr_jb_searchstrings;
    }
    
    /** get limit (int) **/
    function get_limit() {
    	return $this->limit;
    }
    
    /** get start (int) **/
    function get_limitstart() {
    	return $this->limitstart;
    }
    /** get results (array) **/
    function get_results() {
    	return $this->arr_jb_results;
    }
    
    /**
     * Display results
     * @param string actionstring
     */
    function show() {
    	$searchword=implode(' ',$this->get_searchstrings());
    	$results=$this->get_results();
    	$totalRows=$this->total;
    	if ($this->get_limit() < $totalRows) {
    		require_once(JB_JABSPATH.'/includes/pageNavigation.php');
			$pageNav = new mosPageNav( $totalRows, $this->get_limitstart(), $this->get_limit()  );
    	}
    	if (defined('JB_DEBUG'))
    		echo '<p style="background-color:#FFFFCC;border:1px solid red;">'.$this->str_jb_errormsg.'</p>';
    	?>
    	<h3 class="contentheading"><?php echo _FORUM_SEARCHTITLE; ?></h3>
    	<p><?php printf(_FORUM_SEARCH,$searchword); ?></p>
    	
    	<table cellspacing="0" cellpadding="2" width="100%">
    	<tr>
    		<th class="sectiontableheader" width="60%"><?php echo _GEN_SUBJECT; ?></th>
    		<th class="sectiontableheader" width="20%"><?php echo _GEN_AUTHOR; ?></th>
    		<th class="sectiontableheader" width="20%"><?php echo _GEN_DATE; ?></th>
    	</tr>
    	<?php	
		$tabclass = array("sectiontableentry1", "sectiontableentry2");
		$k = 0;
		if ($totalRows==0 && $this->int_jb_errornr) {
			echo '<tr><td colspan="3" class="'.$tabclass[$k].'" style="text-align:center;font-weight:bold">Error '.$this->int_jb_errornr.': '.$this->str_jb_errormsg.'</td></tr>';
		}
		foreach ($results as $result) {
			echo '<tr>';
			echo '<td class="'.$tabclass[$k].'"><a href="'.sefRelToAbs(JB_LIVEURL.'&amp;func=view&amp;id='.$result->id.'&amp;catid='.$result->catid.'#msg'.$result->id).'" title="'.substr(htmlspecialchars($result->message),0,128).'">'.$result->subject.'</a></td>';
			echo '<td class="'.$tabclass[$k].'">'.$result->name.'</td>';
			echo '<td class="'.$tabclass[$k].'">'.date(_DATETIME ,$result->time).'</td></tr>';
			echo "\n";
		}
		?>
		<?php if ($totalRows>$this->limit) { ?>
    	<tr>
    		<td colspan="3" class="sectiontableheader" style="text-align:center">
    			<?php echo $pageNav->writePagesLinks(JB_LIVEURL.'&amp;func=search&amp;searchword='.$searchword); ?>
    		</td>
    	</tr>
    	<?php } ?>
		<tr>
			<td colspan="3" style="text-align:center" class="sectiontableheader"><?php printf(_FORUM_SEARCHRESULTS,count($results),$totalRows); ?></td>
		</tr>    	
    	</table>
    	<?php
    }
}
?>