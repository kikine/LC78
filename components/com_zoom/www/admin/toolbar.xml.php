<?php
//zOOm Media Gallery//
/**
-----------------------------------------------------------------------
|  zOOm Media Gallery! by Mike de Boer - a multi-gallery component    |
-----------------------------------------------------------------------

-----------------------------------------------------------------------
|                                                                     |
| Author: Mike de Boer, <http://www.mikedeboer.nl>                    |
| Copyright: copyright (C) 2006 by Mike de Boer                       |
| Description: zOOm Media Gallery, a multi-gallery component for      |
|              Joomla!. It's the most feature-rich gallery component  |
|              for Joomla!! For documentation and a detailed list     |
|              of features, check the zOOm homepage:                  |
|              http://www.zoomfactory.org                             |
| License: GPL                                                        |
| Filename: toolbar.xml.php                                           |
|                                                                     |
-----------------------------------------------------------------------
* @version $Id: toolbar.xml.php,v 1.4 2006/07/16 20:21:31 kevinuru Exp $
* @package zOOmGallery
* @author Mike de Boer <mailme@mikedeboer.nl> 
**/
class XML_toolbar {
    function buildToolbar($buttons) {
        ?>
<toolbar>
        <?php
        foreach ($buttons as $button) {
            XML_toolbar::newButton($button);
        }
        ?>
</toolbar>
        <?php
    }
    function newButton($type) {
        global $zoom;
        $caption = constant("_ZOOM_".strtoupper($type));
        $caption = str_replace('&','&amp;',$caption);
        if (!empty($caption)) {
        	?>
<button type="<?php echo $type; ?>" caption="<?php echo $caption; ?>"></button>
            <?php
        }
    }
}
?>