<?php
// edited by mic (www.mgfi.info) 2005.09.07 - 21:38

defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

class HtmlSitemap {

	var $joomap_cfg;
	var $now;
	var $noauth;
	var $gid;

	function HtmlSitemap( &$config ) {
		$this->joomap_cfg = $config;
	}


	// This is a workaround for JooFish to work with JooMap
	// JooFish only filters the loadObjectList() function of the main database class,
	// so instead of calling $database->loadAssocList(), we use this wrapper
	function loadAssocList( $param = '' ) {
		global $database;
		$objects = $database->loadObjectList( $param );
		$arrays = array();
		foreach($objects as $object)
			$arrays[] = (array) $object;
		return $arrays;
	}

	// Read in the complete Menu List from mos_menu and return a complete
	// tree-structure including all content items and phpshop categories
	function &getMenuTree( &$selection ) {
		global $database, $mosConfig_offset, $mainframe, $my;

		if( !$selection ) return array();

		$this->now		= date( 'Y-m-d H:i:s', time() + $mosConfig_offset * 60 * 60 );
		$this->noauth 	= !$mainframe->getCfg( 'shownoauth' );
		$this->gid		= $my->gid;

		if ( !$this->noauth ) {
			$sql = "SELECT m.id, m.name, m.parent, m.link, m.type, m.browserNav, m.menutype, m.ordering, m.componentid, m.params, c.name AS component"
				. "\n FROM #__menu AS m"
				. "\n LEFT JOIN #__components AS c ON c.id=m.componentid"
				. "\n WHERE m.published='1' AND m.menutype IN (".$selection.")"
				. "\n ORDER BY m.menutype,m.parent,m.ordering";
		}
		else {
			$sql = "SELECT m.id, m.name, m.parent, m.link, m.type, m.browserNav, m.menutype, m.ordering, m.componentid, m.params, c.name AS component"
				. "\n FROM #__menu AS m"
				. "\n LEFT JOIN #__components AS c ON c.id=m.componentid"
				. "\n WHERE m.published='1' AND m.menutype IN (".$selection.")"
				. "\n AND m.access <= '{$this->gid}'"
				. "\n ORDER BY m.menutype,m.parent,m.ordering";
		}
		$database->setQuery( $sql );
		$rows = $this->loadAssocList();
		if( !count($rows) )
			return array();

		$tree	= array();
		$menus	= &$this->joomap_cfg->menus;
		$i		= 999;

		//generate menu tree

		//read in the complete list of menu entries
		foreach($rows as $row) {
			//skip hidden menus
			if( !$menus[$row['menutype']]->show ) continue;

			$row['menu_order'] = isset($menus[$row['menutype']]) ? $menus[$row['menutype']]->ordering : ++$i;

			//convert link to valid xml
			$row['link'] = htmlspecialchars($row['link']);

			if( $this->joomap_cfg->expand_category )
			if( isset($row['type']) && ($row['type'] == 'content_blog_category' || $row['type'] == 'content_category') ) {
				$row['subtree'] = $this->getCategory($row, $row['componentid']);
			}

			if( $this->joomap_cfg->expand_section )
			if( isset($row['type']) && $row['type'] == 'content_section') {
				$row['subtree'] = $this->getSection($row, $row['componentid']);
			}

			if( $this->joomap_cfg->expand_section )
			if( isset($row['type']) && $row['type'] == 'content_blog_section') {
				$row['subtree'] = $this->getBlogSection($row, $row['componentid']);
			}

			if( $this->joomap_cfg->expand_pshop )
			if( isset($row['component']) && $row['component'] == 'mambo-phpShop') {
				$row['subtree'] = $this->getPshopCategories($row);
			}
			unset($row['params']);
			//add this node to tree
			$tree[$row['id']] = $row;
		}

		//copy children into the subtree of their parents
		foreach($tree as $val) {
			if($val['parent'] > 0 && isset($tree[$val['parent']]) ) {
				$tree[$val['parent']]['subtree'][] = &$tree[$val['id']];
			}
		}

		//remove all children from the toptree
		foreach($tree as $val) {
			if($val['parent'] > 0) {
				unset($tree[$val['id']]);
			}
		}

		//sort the top menutrees according to their configured order
		usort($tree, '_cmpMenuOrder');

		return $tree;
	}

/*******************************************************************/
/* content handling taken from /components/com_content/content.php */
/*******************************************************************/

	// Return an array with all items within a category
	function &getCategory( &$parent, $catid) {
		global $database;

		$item['id']	= $parent['id'];
		$item['browserNav'] = $parent['browserNav'];
		$params		= _paramsToArray($parent['params']);
		$orderby	= _orderby_sec( isset($params['order_by']) ? $params['order_by'] : 'rdate' );
		$xwhere2	= "\n AND a.state='1'"
		. "\n AND ( a.publish_up = '0000-00-00 00:00:00' OR a.publish_up <= '". $this->now ."' )"
		. "\n AND ( a.publish_down = '0000-00-00 00:00:00' OR a.publish_down >= '". $this->now ."' )"
		;

		// get the list of items for this category
		$query = "SELECT a.id, a.title"
		. "\n FROM #__content AS a"
		. "\n WHERE a.catid='".$catid."' ".$xwhere2
		. ( $this->noauth ? "\n AND a.access<='". $this->gid ."'" : '' )
		. "\n ORDER BY ". $orderby .""
		;
		$database->setQuery( $query );
		$rows = $this->loadAssocList();
		$list = array();
		foreach($rows as $row) {
			$item['link'] = 'index.php?option=com_content&amp;task=view&amp;id='.$row['id'];
			$item['name'] = $row['title'];
			$list[] = $item;
	    }
	    return $list;
	}

	// Return an array with all Categories within a Section
	// Also call getCategory() for each Category to include it's items
	function &getSection( &$parent, $secid ) {
		global $database;

		$item['id']	= $parent['id'];
		$item['browserNav'] = $parent['browserNav'];
		$params		= _paramsToArray($parent['params']);

		$orderby	= _orderby_sec(  isset($params['orderby']) ? $params['orderby'] : '' );
		$xwhere		= "\n AND a.published = '1'";
		$xwhere2	= "\n AND b.state = '1'"
		. "\n AND ( publish_up = '0000-00-00 00:00:00' OR publish_up <= '". $this->now ."' )"
		. "\n AND ( publish_down = '0000-00-00 00:00:00' OR publish_down >= '". $this->now ."' )"
		;
		// show/hide empty categories
		$empty = '';
		if (@!$params['empty_cat'])
			$empty = "\n HAVING COUNT( b.id ) > 0";
		$query = "SELECT a.id, a.title, a.name, a.params"
		. "\nFROM #__categories AS a"
		. "\nLEFT JOIN #__content AS b ON b.catid = a.id ". $xwhere2
		. "\nWHERE a.section = '{$secid}' ". $xwhere
		;
		if ($this->noauth) {
			$query .= "\nAND a.access <= ". $this->gid
			. "\nAND b.access <= ". $this->gid
			;
		}
		$query .= "\nGROUP BY a.id"
		. $empty
		. "\nORDER BY ".$orderby
		;
		$database->setQuery( $query );
		$rows = $this->loadAssocList();
		$list = array();
		foreach($rows as $row) {
			$item['params'] = $row['params'];
			$item['link'] = 'index.php?option=com_content&amp;task=category&amp;id='.$row['id'];
			$item['name'] = $row['name'];
			$item['subtree'] = null;
			if( $this->joomap_cfg->expand_category )
				$item['subtree'] = $this->getCategory($parent, $row['id']);
			$list[] = $item;
	    }
	    return $list;
	}

	// Return an array with all Items in a Section
	function &getBlogSection( &$parent, $secid ) {
		global $database;

		$item['id']	= $parent['id'];
		$item['browserNav'] = $parent['browserNav'];
		$params 	= _paramsToArray($parent['params']);
		$order_pri	= _orderby_pri( isset($params['orderby_pri']) ? $params['orderby_pri'] : '');
		$order_sec	= _orderby_sec( isset($params['orderby_sec']) ? $params['orderby_sec'] : '');
		$access		= null;
		$where		= _where( 1, $access, $this->noauth, $this->gid, $secid, $this->now );

		$query = "SELECT a.*, ROUND( v.rating_sum / v.rating_count ) AS rating, v.rating_count, u.name AS author, u.usertype, cc.name AS category, g.name AS groups"
		. "\n FROM #__content AS a"
		. "\n INNER JOIN #__categories AS cc ON cc.id = a.catid"
		. "\n LEFT JOIN #__users AS u ON u.id = a.created_by"
		. "\n LEFT JOIN #__content_rating AS v ON a.id = v.content_id"
		. "\n LEFT JOIN #__sections AS s ON a.sectionid = s.id"
		. "\n LEFT JOIN #__groups AS g ON a.access = g.id"
		. ( count( $where ) ? "\n WHERE ".implode( "\n AND ", $where ) : '' )
		. "\n AND s.access<={$this->gid}"
		. "\n ORDER BY ". $order_pri . $order_sec
		;

		$database->setQuery( $query );
		$rows = $this->loadAssocList();
		$list = array();
		foreach($rows as $row) {
			$item['link'] = 'index.php?option=com_content&amp;task=view&amp;id='.$row['id'];
			$item['name'] = $row['title'];
			$list[] = $item;
	    }
	    return $list;
	}
/*******************************************************************/

/************************************************************************************************************/
/* pshop category handling taken from /administrator/components/com_phpshop/classes/ps_product_category.php */
/* ps_product_category::get_category_tree                                                                   */
/************************************************************************************************************/

	// Return an array with all 1st level Categories in PhpShop
	function &getPshopCategories( &$parent ) {
		global $database;

		$item['id']	= $parent['id'];
		$item['browserNav'] = $parent['browserNav'];
		$com_link	= $parent['link'];
		// Show only top level categories and categories that are
	    // being published
	    $query  = "SELECT * FROM #__pshop_category, #__pshop_category_xref"
			."\nWHERE #__pshop_category.category_publish='Y'"
			."\nAND (#__pshop_category_xref.category_parent_id='' OR #__pshop_category_xref.category_parent_id='0')"
			."\nAND #__pshop_category.category_id=#__pshop_category_xref.category_child_id"
			."\nORDER BY #__pshop_category.list_order ASC, #__pshop_category.category_name ASC";
		// initialise the query in the $database connector
		// this translates the '#__' prefix into the real database prefix
		$database->setQuery( $query );
		$rows = $this->loadAssocList();

		$list = array();
		foreach($rows as $row) {
			$item['link'] = $com_link.'&amp;page=shop.browse&amp;category_id='.$row['category_id'];
		    $item['name'] = $row['category_name'];
		    $list[] = $item;
	    }
		return $list;
	}
/************************************************************************************************************/

	/* Convert sitemap tree to an 'unordered' html list (<ul><li></li></ul>)
	   WARNING: keep unnecessary code out of this, it uses recursion, so it's probably
	            gonna be called more than once.
	*/
	function &getHtmlList( &$tree, $level = 0, $exlink ) {
			global $Itemid;

			$out = '<ul class="level_'.$level.'">';
			if ($tree) {
				foreach($tree as $row) {
					$active = ($Itemid == $row['id']) ? ' class="active"' : '';
					$out .= "<li{$active}>";
					$link = $row['link'];
					switch(@$row['type']) {
						case 'separator':
							break;
						case 'url':
							if (eregi( "index.php\?", $link )) {
								if (!strpos( 'Itemid=', $link )) {
									$link .= '&amp;Itemid='.$row['id'];
								}
							}
							break;
						default:
							$link .= '&amp;Itemid='.$row['id'];
							break;
					}


					if( strcasecmp( substr( $link, 0, 4), 'http' ) )
						$link = sefRelToAbs($link);

					switch($row['browserNav']) {
						case 1:
						// open in new window
						$ext_image = '';
						if( $exlink[0] ){
							$ext_image = '&nbsp;<img src="'. $GLOBALS['mosConfig_live_site'] .'/components/com_joomap/images/'. $exlink[1] .'" alt="' . _JOOMAP_SHOW_AS_EXTERN_ALT . '" title="' . _JOOMAP_SHOW_AS_EXTERN_ALT . '" />';
						}
						$out .= '<a href="'. $link .'" title="'. $row['name'] .'" target="_window">'. $row['name'] .'</a>'. $ext_image;
						break;

						case 2:
						// open in popup window
						$ext_image = '';
						if( $exlink[0] ){
							$ext_image = '&nbsp;<img src="'. $GLOBALS['mosConfig_live_site'] .'/components/com_joomap/images/'. $exlink[1] .'" alt="' . _JOOMAP_SHOW_AS_EXTERN_ALT . '" title="' . _JOOMAP_SHOW_AS_EXTERN_ALT . '" />';
						}
						$out .= "<a href=\"$link\" onClick=\"javascript: window.open('$link', '', 'toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes,width=780,height=550'); return false;\">{$row['name']}</a>". $ext_image;
						break;

						case 3:
						// don't link it
						$out .= '<span>{'. $row['name'] .'}</span>';
						break;

						default:
						// open in parent window
						$out .= '<a href="'. $link .'" title="'. $row['name'] .'">'. $row['name'] .'</a>';
						break;
					}
					if( @$row['subtree'] ) {
						$out .= '<br />'.$this->getHtmlList( $row['subtree'], $level + 1, $exlink );
					}
					$out .= '</li>' . "\n";
				}
			}
			$out .= '</ul>' . "\n";
			return $out;
	}

	// Looks up the title for the module that links to $menutype
	function getMenuTitle($menutype) {
		global $database;
		$query = "SELECT title FROM #__modules WHERE published='1' AND params LIKE '%menutype={$menutype}%'";
		$database->setQuery( $query );
		$menutitle = $database->loadResult();
		return $menutitle;
	}

	// Prints out the whole sitemap according to the configuration
	function showSitemap() {
		global $mosConfig_live_site, $mosConfig_absolute_path;
		$cfg = &$this->joomap_cfg;
		echo '<div class="'.$cfg->classname.'">';
		echo '<h2 class="componentheading">'.$this->joomap_cfg->title.'</h2>';
		echo '<div class="contentpaneopen" style="width:100%">';

		$exlink[0] = $cfg->exlinks;
		$exlink[1] = $cfg->ext_image;

		// multicolumn display and menu titles each require loading the menus one by one
		if( $cfg->columns > 1 || $cfg->show_menutitle ) {
			// get a list of all the trees we are actually going to print out
			foreach( $cfg->menus as $key => $val) {
				// don't print hidden menus
				if( !$val->show ) continue;

				// get the menu tree data
				$menutype = "'{$key}'";
				$menu->tree = $this->getMenuTree($menutype);

				// don't print empty menus
				if( count($menu->tree) == 0 ) continue;

				$menu->title = $this->getMenuTitle($key);
				$print_menu[] = $menu;
				unset($menu);
			}

			// we can now calculate the layout
			$total	= count($print_menu);
			$columns = $total < $cfg->columns ? $total : $cfg->columns;
			$width	= (100 / $columns) - 1;

			// print each column, one after the other, from top to bottom
			for( $c = 0; $c < $columns; ++$c) {
				echo '<div style="float:left;width:'.$width.'%">';
				for( $offset = $c; $offset < $total; $offset += $columns) {
					$current = &$print_menu[$offset];
					if($cfg->show_menutitle)
						echo '<ul class="trunk"><li><div class="title">'.$current->title.'</div>';
					echo $this->getHtmlList( $current->tree, $level = 0, $exlink );
					if($cfg->show_menutitle)
						echo '</li></ul>' . "\n";
				}
				echo '</div>';
			}
			echo '<br style="clear:left" />';
		} else {
			// show the whole sitemap in a single list without any menu titles
			foreach($cfg->menus AS $key => $val) {
				if( $val->show ) {
					$menus[] = '\'' . $key . '\'';
				}
			}
			$menutypes = @implode(',', $menus);
			$tree = $this->getMenuTree($menutypes);
			echo $this->getHtmlList( $tree, $level = 0, $exlink );
		}
		// I used to have a link to my website here, but some lady got pissed, because
		// she wanted to use this component on one of her clients websites, who
		// pays money for it. She said this link was ruining her business or something.
		echo '</div></div>' . "\n";
	}

}

/***************************/
/* Little Helper functions */
/***************************/

// convert a menuitem's params field to an array
function _paramsToArray($params) {
	$res = array();
	$tmp = explode("\n", $params);
	foreach($tmp AS $a) {
		@list($key, $val) = explode('=', $a, 2);
		$res[$key] = $val;
	}
	return $res;
}

// called with usort to sort menuitems
function _cmpMenuOrder($a, $b) {
	if( $a['menu_order'] == $b['menu_order']) {
		if( $a['ordering'] == $b['ordering'] )
			return 0;
		return $a['ordering'] < $b['ordering'] ? -1 : 1;
	}
	return $a['menu_order'] < $b['menu_order'] ? -1 : 1;
}

/***************************************************/
/* copied from /components/com_content/content.php */
/***************************************************/
function _orderby_pri( $orderby ) {
	switch ( $orderby ) {
		case 'alpha':
			$orderby = 'cc.title, ';
			break;
		case 'ralpha':
			$orderby = 'cc.title DESC, ';
			break;
		case 'order':
			$orderby = 'cc.ordering, ';
			break;
		default:
			$orderby = '';
			break;
	}

	return $orderby;
}

function _orderby_sec( $orderby ) {
	switch ( $orderby ) {
		case 'date':
			$orderby = 'a.created';
			break;
		case 'rdate':
			$orderby = 'a.created DESC';
			break;
		case 'alpha':
			$orderby = 'a.title';
			break;
		case 'ralpha':
			$orderby = 'a.title DESC';
			break;
		case 'hits':
			$orderby = 'a.hits DESC';
			break;
		case 'rhits':
			$orderby = 'a.hits ASC';
			break;
		case 'order':
			$orderby = 'a.ordering';
			break;
		case 'author':
			$orderby = 'a.created_by, u.name';
			break;
		case 'rauthor':
			$orderby = 'a.created_by DESC, u.name DESC';
			break;
		case 'front':
			$orderby = 'f.ordering';
			break;
		default:
			$orderby = 'a.ordering';
			break;
	}

	return $orderby;
}
/*
* param int 0 = Archives, 1 = Section, 2 = Category
*/
function _where( $type=1, &$access, &$noauth, $gid, $id, $now=NULL, $year=NULL, $month=NULL ) {
	$where = array();

	// normal
	if ( $type > 0) {
		$where[] = "a.state = '1'";
		if ( !$access || !$access->canEdit ) {
			$where[] = "( a.publish_up = '0000-00-00 00:00:00' OR a.publish_up <= '". $now ."' )";
			$where[] = "( a.publish_down = '0000-00-00 00:00:00' OR a.publish_down >= '". $now ."' )";
		}
		if ( $noauth ) {
			$where[] = "a.access <= '". $gid ."'";
		}
		if ( $id > 0 ) {
			if ( $type == 1 ) {
				$where[] = "a.sectionid IN ( ". $id ." ) ";
			} else if ( $type == 2 ) {
				$where[] = "a.catid IN ( ". $id ." ) ";
			}
		}
	}

	// archive
	if ( $type < 0 ) {
		$where[] = "a.state='-1'";
		if ( $year ) {
			$where[] = "YEAR( a.created ) = '". $year ."'";
		}
		if ( $month ) {
			$where[] = "MONTH( a.created ) = '". $month ."'";
		}
		if ( $noauth ) {
			$where[] = "a.access <= '". $gid ."'";
		}
		if ( $id > 0 ) {
			if ( $type == -1 ) {
				$where[] = "a.sectionid = '". $id ."'";
			} else if ( $type == -2) {
				$where[] = "a.catid = '". $id ."'";
			}
		}
	}

	return $where;
}