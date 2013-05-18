<?php
/**
* @package EasyGB
* @copyright (C) 2006 Joomla-addons.org
* @author Websmurf
* 
* --------------------------------------------------------------------------------
* All rights reserved.  Easy GB Component for Joomla!
*
* This program is free software; you can redistribute it and/or
* modify it under the terms of the Creative Commons - Attribution-NoDerivs 2.5 
* license as published by the Creative Commons Organisation
* http://creativecommons.org/licenses/by-nd/2.5/.
*
* This program is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  
* --------------------------------------------------------------------------------
**/

function com_install(){
  global $mainframe, $database;
  
  //Updates menu option
  $query = "UPDATE #__components 
    SET admin_menu_img='../administrator/components/com_easygb/icons/16x16_klipper.png' 
    WHERE admin_menu_link='option=com_easygb'";
  $database->setQuery($query);
  if(!$database->query()){  
    echo $database->getErrorMsg() . '<br />';
  }
  
  $query = "UPDATE #__components 
    SET admin_menu_img='js/ThemeOffice/config.png' 
    WHERE admin_menu_link='option=com_easygb&act=configuration'";
  $database->setQuery($query);
  if(!$database->query()){  
    echo $database->getErrorMsg() . '<br />';
  }
  
  $query = "UPDATE #__components 
    SET admin_menu_img='js/ThemeOffice/content.png' 
    WHERE admin_menu_link='option=com_easygb&act=entries'";
  $database->setQuery($query);
  if(!$database->query()){  
    echo $database->getErrorMsg() . '<br />';
  }
}

?>