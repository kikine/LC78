<?/*
* (c) 2005 Phil Taylor - Blue Flame IT Ltd
* $Id: combomax.php 9 2005-07-04 23:00:21Z me $
* $Revision: 9 $
* $Date: 2005-07-05 00:00:21 +0100 (Tue, 05 Jul 2005) $
* Support: http://www.phil-taylor.com
*/?>
<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

$_MAMBOTS->registerFunction( 'onPrepareContent', 'botanalytics' );

if (!defined( '_CSS_INCLUDED' )) {
	global $mainframe, $database;
	define( '_CSS_INCLUDED' , 1);
	
  $query = "SELECT id FROM #__mambots WHERE element = 'analytics' AND folder = 'content'";

	$database->setQuery( $query );
	$id = $database->loadResult();
	$mambot = new mosMambot( $database );
	$mambot->load( $id );
	$params =& new mosParameters( $mambot->params );	

$analytics = $params->get( 'analytics', 'Default' );

$head = '<script src="http://www.google-analytics.com/urchin.js" type="text/javascript">
</script>
<script type="text/javascript">
_uacct = "'.$analytics.'";
urchinTracker();
</script>';

	$mainframe->addCustomHeadTag($head);
}

?>
