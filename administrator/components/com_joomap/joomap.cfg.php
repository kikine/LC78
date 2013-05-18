<?php
// Last Edit: sam, 2007-jun-16 11:32:56
// Edited by: traso
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );
if( !class_exists('JOOMAP_CFG_1_1') ) {
class JOOMAP_CFG_1_1 {
var $title = "Plan du site LC78-escrime.com";
var $classname = "sitemap";
var $expand_category = "1";
var $expand_section = "1";
var $expand_pshop = "1";
var $show_menutitle = "0";
var $columns = "1";
var $exlinks = "1";
var $ext_image = "img_grey.gif";
var $menus = array (
  'othermenu' => 
  array (
    'ordering' => 1,
    'show' => false,
  ),
  'mainmenu' => 
  array (
    'ordering' => 2,
    'show' => true,
  ),
  'topmenu' => 
  array (
    'ordering' => 3,
    'show' => false,
  ),
  'usermenu' => 
  array (
    'ordering' => 4,
    'show' => true,
  ),
);
}}
?>
