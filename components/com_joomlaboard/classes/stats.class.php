<?php 
/**
* stats.php display joomlaboard stats 
* @package com_joomlaboard
* @copyright (C) 2000 - 2007 TSMF / Jan de Graaff / All Rights Reserved
* @author TSMF
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* Joomla! is Free Software
**/
// Dont allow direct linking
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

/**
* Joomlaboard stats support class
* @package com_joomlaboard
*/
class jbStats {
	
	/**
	 * Total messages in joomlaboard 
	 * @param  string date start
	 * @param string date end
	 * @return int
	 */	
	function get_total_messages($start='',$end='') {
		global $database;
		$where=array();
		if (!empty($start))
			$where[]='time > UNIX_TIMESTAMP(\'' . $start. '\')';
		if (!empty($end))
			$where[]='time < UNIX_TIMESTAMP(\'' . $end . '\')';
		$query='SELECT COUNT(*) FROM #__sb_messages WHERE moved=0 AND hold=0';
		if (count($where)>0)
			$query.=' AND '.implode(' AND ',$where);
		$database->setQuery($query);
		return intval($database->loadResult());
	}
	
	/**
	 * Total topics in joomlaboard
	 * @param  string date start
	 * @param string date end
	 * @return int
	 */
	function get_total_topics($start='',$end='') {
		global $database;
		$where=array();
		if (!empty($start))
			$where[]='time > UNIX_TIMESTAMP(\'' . $start. '\')';
		if (!empty($end))
			$where[]='time < UNIX_TIMESTAMP(\'' . $end . '\')';
		$query='SELECT COUNT(*) FROM #__sb_messages WHERE moved=0 AND hold=0 AND parent=0';
		if (count($where)>0)
			$query.=' AND '.implode(' AND ',$where);
		$database->setQuery($query);
		return intval($database->loadResult());
	}
	
	/**
	 * Get top topics
	 * @return array
	 */
	function get_top_topics() {
		global $database;
		$database->setQuery('SELECT * FROM #__sb_messages WHERE parent = 0 ' .
				'AND hits > 0  ORDER BY hits DESC LIMIT 5');
		$results=$database->loadObjectList();
		return count($results) > 0 ? $results : array();
	}
	
	/**
	 * Total categories in joomlaboard
	 * @return int
	 */
	function get_total_categories() {
		global $database;
		$database->setQuery('SELECT COUNT(*) FROM #__sb_categories WHERE parent=0');
		return intval($database->loadResult());
	}
	/**
	 * Get top categories
	 * @return array
	 */
	function get_top_categories() {
		global $database;
		$database->setQuery('SELECT catid,COUNT(id) as totalmsg FROM #__sb_messages' .
				' GROUP BY c.id ORDER BY catid LIMIT 5');
		$results=$database->loadObjectList();
		if (count($results)>0) {
				$ids=implode(',',$results);
				$database->setQuery('SELECT name FROM #__sb_categories WHERE id IN ('.$ids.') ORDER BY catid');
				$names=$database->loadResultArray();
				$i=0;
				foreach ($results as $result)
					$result->name=$names[$i++];
		}
		else
			$results=array();
		return $results;
	}
	/**
	 * Total sections in joomlaboard
	 * @return int
	 */
	function get_total_sections() {
		global $database;
		$database->setQuery('SELECT COUNT(*) FROM #__sb_categories WHERE parent>0');
		return intval($database->loadResult());
	}
	
	/**
	 * Latest Joomla members
	 * @return string
	 */
	function get_latest_member() {
		global $database;
		$database->setQuery('SELECT username FROM #__users WHERE block=0 AND activation=\'\' ORDER BY id DESC LIMIT 1');
		return $database->loadResult();
	}

	/**
	 * Total joomla members
	 * @return int
	 */
	function get_total_members() {
		global $database;
		$database->setQuery('SELECT COUNT(*) FROM #__users');
		return intval($database->loadresult());
	}
	
	/**
	 * Top posters
	 * @return array
	 */
	function get_top_posters() {
		global $database;
		$database->setQuery('SELECT s.userid,s.posts,u.username FROM #__sb_users as s ' .
				"\n INNER JOIN  #__users as u ON s.userid=u.id" .
				"\n WHERE s.posts > 0 ORDER BY s.posts DESC LIMIT 10");
		return count($database->loadObjectList()) > 0 ? $database->loadObjectList() : array();
	}
	
	/**
	 * CB top profiles
	 * @return array
	 */
	 function get_top_cbprofiles() {
	 	global $database;
 		$database->setQuery("SELECT u.username AS user, p.hits FROM #__users AS u"
			. "\n LEFT JOIN #__comprofiler AS p ON p.user_id = u.id"
			. "\n WHERE p.hits > 0 ORDER BY p.hits DESC LIMIT 10");
		return count($database->loadObjectList()) > 0 ? $database->loadObjectList() : array();
	 }
}

?>