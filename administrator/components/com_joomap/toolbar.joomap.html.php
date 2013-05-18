<?php

/** ensure this file is being included by a parent file */
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

class TOOLBAR_joomap {
	/**
	* Draws the toolbar
	*/
	function _DEFAULT() {
		mosMenuBar::startTable();
		mosMenuBar::save('save', _JOOMAP_TOOLBAR_SAVE);
		mosMenuBar::spacer();
		mosMenuBar::cancel('cancel', _JOOMAP_TOOLBAR_CANCEL);
		mosMenuBar::endTable();
	}

}
?>