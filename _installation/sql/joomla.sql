# $Id: joomla.sql 6070 2006-12-20 02:09:09Z robs $

#
# Table structure for table `#__banner`
#

CREATE TABLE `#__banner` (
  `bid` int(11) NOT NULL auto_increment,
  `cid` int(11) NOT NULL default '0',
  `type` varchar(10) NOT NULL default 'banner',
  `name` varchar(50) NOT NULL default '',
  `imptotal` int(11) NOT NULL default '0',
  `impmade` int(11) NOT NULL default '0',
  `clicks` int(11) NOT NULL default '0',
  `imageurl` varchar(100) NOT NULL default '',
  `clickurl` varchar(200) NOT NULL default '',
  `date` datetime default NULL,
  `showBanner` tinyint(1) NOT NULL default '0',
  `checked_out` tinyint(1) NOT NULL default '0',
  `checked_out_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `editor` varchar(50) default NULL,
  `custombannercode` text,
  PRIMARY KEY  (`bid`),
  KEY `viewbanner` (`showBanner`)
) TYPE=MyISAM AUTO_INCREMENT=1 ;

#
# Table structure for table `#__bannerclient`
#

CREATE TABLE `#__bannerclient` (
  `cid` int(11) NOT NULL auto_increment,
  `name` varchar(60) NOT NULL default '',
  `contact` varchar(60) NOT NULL default '',
  `email` varchar(60) NOT NULL default '',
  `extrainfo` text NOT NULL,
  `checked_out` tinyint(1) NOT NULL default '0',
  `checked_out_time` time default NULL,
  `editor` varchar(50) default NULL,
  PRIMARY KEY  (`cid`)
) TYPE=MyISAM;

#
# Table structure for table `#__bannerfinish`
#

CREATE TABLE `#__bannerfinish` (
  `bid` int(11) NOT NULL auto_increment,
  `cid` int(11) NOT NULL default '0',
  `type` varchar(10) NOT NULL default '',
  `name` varchar(50) NOT NULL default '',
  `impressions` int(11) NOT NULL default '0',
  `clicks` int(11) NOT NULL default '0',
  `imageurl` varchar(50) NOT NULL default '',
  `datestart` datetime default NULL,
  `dateend` datetime default NULL,
  PRIMARY KEY  (`bid`)
) TYPE=MyISAM;

#
# Table structure for table `#__categories`
#

CREATE TABLE `#__categories` (
  `id` int(11) NOT NULL auto_increment,
  `parent_id` int(11) NOT NULL default 0,
  `title` varchar(50) NOT NULL default '',
  `name` varchar(255) NOT NULL default '',
  `image` varchar(100) NOT NULL default '',
  `section` varchar(50) NOT NULL default '',
  `image_position` varchar(10) NOT NULL default '',
  `description` text NOT NULL,
  `published` tinyint(1) NOT NULL default '0',
  `checked_out` int(11) unsigned NOT NULL default '0',
  `checked_out_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `editor` varchar(50) default NULL,
  `ordering` int(11) NOT NULL default '0',
  `access` tinyint(3) unsigned NOT NULL default '0',
  `count` int(11) NOT NULL default '0',
  `params` text NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `cat_idx` (`section`,`published`,`access`),
  KEY `idx_section` (`section`),
  KEY `idx_access` (`access`),
  KEY `idx_checkout` (`checked_out`)
) TYPE=MyISAM;

#
# Table structure for table `#__components`
#

CREATE TABLE `#__components` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(50) NOT NULL default '',
  `link` varchar(255) NOT NULL default '',
  `menuid` int(11) unsigned NOT NULL default '0',
  `parent` int(11) unsigned NOT NULL default '0',
  `admin_menu_link` varchar(255) NOT NULL default '',
  `admin_menu_alt` varchar(255) NOT NULL default '',
  `option` varchar(50) NOT NULL default '',
  `ordering` int(11) NOT NULL default '0',
  `admin_menu_img` varchar(255) NOT NULL default '',
  `iscore` tinyint(4) NOT NULL default '0',
  `params` text NOT NULL,
  PRIMARY KEY  (`id`)
) TYPE=MyISAM;

#
# Dumping data for table `#__components`
#

INSERT INTO `#__components` VALUES (1, 'Bannières', '', 0, 0, '', 'Gestion des bannières', 'com_banners', 0, 'js/ThemeOffice/component.png', 0, '');
INSERT INTO `#__components` VALUES (2, 'Gérer les bannières', '', 0, 1, 'option=com_banners', 'Bannières actives', 'com_banners', 1, 'js/ThemeOffice/edit.png', 0, '');
INSERT INTO `#__components` VALUES (3, 'Gérer les clients', '', 0, 1, 'option=com_banners&task=listclients', 'Manage Clients', 'com_banners', 2, 'js/ThemeOffice/categories.png', 0, '');
INSERT INTO `#__components` VALUES (4, 'Liens web', 'option=com_weblinks', 0, 0, '', 'Gestion des liens web', 'com_weblinks', 0, 'js/ThemeOffice/globe2.png', 0, '');
INSERT INTO `#__components` VALUES (5, 'Liens web', '', 0, 4, 'option=com_weblinks', 'Voir les liens web existantss', 'com_weblinks', 1, 'js/ThemeOffice/edit.png', 0, '');
INSERT INTO `#__components` VALUES (6, 'Catégories de liens web', '', 0, 4, 'option=categories&section=com_weblinks', 'Gestion des catégories de liens web', '', 2, 'js/ThemeOffice/categories.png', 0, '');
INSERT INTO `#__components` VALUES (7, 'Contacts', 'option=com_contact', 0, 0, '', 'Gestion des contacts', 'com_contact', 0, 'js/ThemeOffice/user.png', 1, '');
INSERT INTO `#__components` VALUES (8, 'Gérer les contacts', '', 0, 7, 'option=com_contact', 'Editer les contacts', 'com_contact', 0, 'js/ThemeOffice/edit.png', 1, '');
INSERT INTO `#__components` VALUES (9, 'Catégories de contacts', '', 0, 7, 'option=categories&section=com_contact_details', 'Gestion des catégories de contacts', '', 2, 'js/ThemeOffice/categories.png', 1, '');
INSERT INTO `#__components` VALUES (10, 'Page d&#146;accueil', 'option=com_frontpage', 0, 0, '', 'Gestion des articles de la page d&#146;accueil', 'com_frontpage', 0, 'js/ThemeOffice/component.png', 1, '');
INSERT INTO `#__components` VALUES (11, 'Sondage', 'option=com_poll', 0, 0, 'option=com_poll', 'Gestion des sondages', 'com_poll', 0, 'js/ThemeOffice/component.png', 0, '');
INSERT INTO `#__components` VALUES (12, 'Flux RSS', 'option=com_newsfeeds', 0, 0, '', 'Gestion des Flux RSS', 'com_newsfeeds', 0, 'js/ThemeOffice/component.png', 0, '');
INSERT INTO `#__components` VALUES (13, 'Gérer les flux RSS', '', 0, 12, 'option=com_newsfeeds', 'Gestion des Flux RSS', 'com_newsfeeds', 1, 'js/ThemeOffice/edit.png', 0, '');
INSERT INTO `#__components` VALUES (14, 'Gérer les catégories', '', 0, 12, 'option=com_categories&section=com_newsfeeds', 'Gestion des catégories', '', 2, 'js/ThemeOffice/categories.png', 0, '');
INSERT INTO `#__components` VALUES (15, 'Identification', 'option=com_login', 0, 0, '', '', 'com_login', 0, '', 1, '');
INSERT INTO `#__components` VALUES (16, 'Recherche', 'option=com_search', 0, 0, '', '', 'com_search', 0, '', 1, '');
INSERT INTO `#__components` VALUES (17, 'Syndication','',0,0,'option=com_syndicate&hidemainmenu=1','Paramètres de syndication','com_syndicate',0,'js/ThemeOffice/component.png',0,'');
INSERT INTO `#__components` VALUES (18, 'Mailing', '', 0, 0, 'option=com_massmail&hidemainmenu=1', 'Envoyer un mailing', 'com_massmail', 0, 'js/ThemeOffice/mass_email.png', 0, '');
# --------------------------------------------------------

#
# Table structure for table `#__contact_details`
#

CREATE TABLE `#__contact_details` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(100) NOT NULL default '',
  `con_position` varchar(50) default NULL,
  `address` text,
  `suburb` varchar(50) default NULL,
  `state` varchar(20) default NULL,
  `country` varchar(50) default NULL,
  `postcode` varchar(10) default NULL,
  `telephone` varchar(25) default NULL,
  `fax` varchar(25) default NULL,
  `misc` mediumtext,
  `image` varchar(100) default NULL,
  `imagepos` varchar(20) default NULL,
  `email_to` varchar(100) default NULL,
  `default_con` tinyint(1) unsigned NOT NULL default '0',
  `published` tinyint(1) unsigned NOT NULL default '0',
  `checked_out` int(11) unsigned NOT NULL default '0',
  `checked_out_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `ordering` int(11) NOT NULL default '0',
  `params` text NOT NULL,
  `user_id` int(11) NOT NULL default '0',
  `catid` int(11) NOT NULL default '0',
  `access` tinyint(3) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM;

#
# Table structure for table `#__content`
#

CREATE TABLE `#__content` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `title` varchar(100) NOT NULL default '',
  `title_alias` varchar(100) NOT NULL default '',
  `introtext` mediumtext NOT NULL,
  `fulltext` mediumtext NOT NULL,
  `state` tinyint(3) NOT NULL default '0',
  `sectionid` int(11) unsigned NOT NULL default '0',
  `mask` int(11) unsigned NOT NULL default '0',
  `catid` int(11) unsigned NOT NULL default '0',
  `created` datetime NOT NULL default '0000-00-00 00:00:00',
  `created_by` int(11) unsigned NOT NULL default '0',
  `created_by_alias` varchar(100) NOT NULL default '',
  `modified` datetime NOT NULL default '0000-00-00 00:00:00',
  `modified_by` int(11) unsigned NOT NULL default '0',
  `checked_out` int(11) unsigned NOT NULL default '0',
  `checked_out_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `publish_up` datetime NOT NULL default '0000-00-00 00:00:00',
  `publish_down` datetime NOT NULL default '0000-00-00 00:00:00',
  `images` text NOT NULL,
  `urls` text NOT NULL,
  `attribs` text NOT NULL,
  `version` int(11) unsigned NOT NULL default '1',
  `parentid` int(11) unsigned NOT NULL default '0',
  `ordering` int(11) NOT NULL default '0',
  `metakey` text NOT NULL,
  `metadesc` text NOT NULL,
  `access` int(11) unsigned NOT NULL default '0',
  `hits` int(11) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `idx_section` (`sectionid`),
  KEY `idx_access` (`access`),
  KEY `idx_checkout` (`checked_out`),
  KEY `idx_state` (`state`),
  KEY `idx_catid` (`catid`),
  KEY `idx_mask` (`mask`)
) TYPE=MyISAM;

#
# Table structure for table `#__content_frontpage`
#

CREATE TABLE `#__content_frontpage` (
  `content_id` int(11) NOT NULL default '0',
  `ordering` int(11) NOT NULL default '0',
  PRIMARY KEY  (`content_id`)
) TYPE=MyISAM;

#
# Table structure for table `#__content_rating`
#

CREATE TABLE `#__content_rating` (
  `content_id` int(11) NOT NULL default '0',
  `rating_sum` int(11) unsigned NOT NULL default '0',
  `rating_count` int(11) unsigned NOT NULL default '0',
  `lastip` varchar(50) NOT NULL default '',
  PRIMARY KEY  (`content_id`)
) TYPE=MyISAM;

#
# Table structure for table `#__core_log_items`
#
# To be implemented

CREATE TABLE `#__core_log_items` (
  `time_stamp` date NOT NULL default '0000-00-00',
  `item_table` varchar(50) NOT NULL default '',
  `item_id` int(11) unsigned NOT NULL default '0',
  `hits` int(11) unsigned NOT NULL default '0'
) TYPE=MyISAM;

#
# Table structure for table `#__core_log_searches`
#
# To be implemented

CREATE TABLE `#__core_log_searches` (
  `search_term` varchar(128) NOT NULL default '',
  `hits` int(11) unsigned NOT NULL default '0'
) TYPE=MyISAM;

#
# Table structure for table `#__groups`
#

CREATE TABLE `#__groups` (
  `id` tinyint(3) unsigned NOT NULL default '0',
  `name` varchar(50) NOT NULL default '',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM;

#
# Dumping data for table `#__groups`
#

INSERT INTO `#__groups` VALUES (0, 'Public');
INSERT INTO `#__groups` VALUES (1, 'Membre');
INSERT INTO `#__groups` VALUES (2, 'Special');
# --------------------------------------------------------

#
# Table structure for table `#__mambots`
#

CREATE TABLE `#__mambots` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(100) NOT NULL default '',
  `element` varchar(100) NOT NULL default '',
  `folder` varchar(100) NOT NULL default '',
  `access` tinyint(3) unsigned NOT NULL default '0',
  `ordering` int(11) NOT NULL default '0',
  `published` tinyint(3) NOT NULL default '0',
  `iscore` tinyint(3) NOT NULL default '0',
  `client_id` tinyint(3) NOT NULL default '0',
  `checked_out` int(11) unsigned NOT NULL default '0',
  `checked_out_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `params` text NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `idx_folder` (`published`,`client_id`,`access`,`folder`)
) TYPE=MyISAM;

INSERT INTO `#__mambots` VALUES (1,'MOS Image','mosimage','content',0,-10000,1,1,0,0,'0000-00-00 00:00:00','');
INSERT INTO `#__mambots` VALUES (2,'MOS Pagination','mospaging','content',0,10000,1,1,0,0,'0000-00-00 00:00:00','');
INSERT INTO `#__mambots` VALUES (3,'Legacy Mambot Includer','legacybots','content',0,1,0,1,0,0,'0000-00-00 00:00:00','');
INSERT INTO `#__mambots` VALUES (4,'SEF','mossef','content',0,3,1,0,0,0,'0000-00-00 00:00:00','');
INSERT INTO `#__mambots` VALUES (5,'MOS Rating','mosvote','content',0,4,1,1,0,0,'0000-00-00 00:00:00','');
INSERT INTO `#__mambots` VALUES (6,'Recherche dans les articles','content.searchbot','search',0,1,1,1,0,0,'0000-00-00 00:00:00','');
INSERT INTO `#__mambots` VALUES (7,'Recherche dans les liens web','weblinks.searchbot','search',0,2,1,1,0,0,'0000-00-00 00:00:00','');
INSERT INTO `#__mambots` VALUES (8,'Code support','moscode','content',0,2,0,0,0,0,'0000-00-00 00:00:00','');
INSERT INTO `#__mambots` VALUES (9,'Aucun éditeur WYSIWYG','none','editors',0,0,1,1,0,0,'0000-00-00 00:00:00','');
INSERT INTO `#__mambots` VALUES (10,'Editeur TinyMCE WYSIWYG','tinymce','editors',0,0,1,1,0,0,'0000-00-00 00:00:00','theme=advanced');
INSERT INTO `#__mambots` VALUES (11,'Bouton MOS Image éditeur','mosimage.btn','editors-xtd',0,0,1,0,0,0,'0000-00-00 00:00:00','');
INSERT INTO `#__mambots` VALUES (12,'Bouton MOS Pagebreak éditeur','mospage.btn','editors-xtd',0,0,1,0,0,0,'0000-00-00 00:00:00','');
INSERT INTO `#__mambots` VALUES (13,'Recherche dans les contacts','contacts.searchbot','search',0,3,1,1,0,0,'0000-00-00 00:00:00','');
INSERT INTO `#__mambots` VALUES (14, 'Recherche dans les catégories', 'categories.searchbot', 'search', 0, 4, 1, 0, 0, 0, '0000-00-00 00:00:00', '');
INSERT INTO `#__mambots` VALUES (15, 'Recherche dans les sections', 'sections.searchbot', 'search', 0, 5, 1, 0, 0, 0, '0000-00-00 00:00:00', '');
INSERT INTO `#__mambots` VALUES (16, 'Email Cloaking', 'mosemailcloak', 'content', 0, 5, 1, 0, 0, 0, '0000-00-00 00:00:00', '');
INSERT INTO `#__mambots` VALUES (17, 'GeSHi', 'geshi', 'content', 0, 5, 0, 0, 0, 0, '0000-00-00 00:00:00', '');
INSERT INTO `#__mambots` VALUES (18, 'Recherche dans les flux RSS', 'newsfeeds.searchbot', 'search', 0, 6, 1, 0, 0, 0, '0000-00-00 00:00:00', '');
INSERT INTO `#__mambots` VALUES (19, 'Chargeur de positions de module', 'mosloadposition', 'content', 0, 6, 1, 0, 0, 0, '0000-00-00 00:00:00', '');
# --------------------------------------------------------

#
# Table structure for table `#__menu`
#

CREATE TABLE `#__menu` (
  `id` int(11) NOT NULL auto_increment,
  `menutype` varchar(25) default NULL,
  `name` varchar(100) default NULL,
  `link` text,
  `type` varchar(50) NOT NULL default '',
  `published` tinyint(1) NOT NULL default '0',
  `parent` int(11) unsigned NOT NULL default '0',
  `componentid` int(11) unsigned NOT NULL default '0',
  `sublevel` int(11) default '0',
  `ordering` int(11) default '0',
  `checked_out` int(11) unsigned NOT NULL default '0',
  `checked_out_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `pollid` int(11) NOT NULL default '0',
  `browserNav` tinyint(4) default '0',
  `access` tinyint(3) unsigned NOT NULL default '0',
  `utaccess` tinyint(3) unsigned NOT NULL default '0',
  `params` text NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `componentid` (`componentid`,`menutype`,`published`,`access`),
  KEY `menutype` (`menutype`)
) TYPE=MyISAM;

INSERT INTO `#__menu` VALUES (1, 'mainmenu', 'Accueil', 'index.php?option=com_frontpage', 'components', 1, 0, 10, 0, 1, 0, '0000-00-00 00:00:00', 0, 0, 0, 3, 'leading=1\r\nintro=2\r\nlink=1\r\nimage=1\r\npage_title=0\r\nheader=Bienvenue sur la page d\'accueil\r\norderby_sec=front\r\nprint=0\r\npdf=0\r\nemail=0\r\nback_button=0');
# --------------------------------------------------------

#
# Table structure for table `#__messages`
#

CREATE TABLE `#__messages` (
  `message_id` int(10) unsigned NOT NULL auto_increment,
  `user_id_from` int(10) unsigned NOT NULL default '0',
  `user_id_to` int(10) unsigned NOT NULL default '0',
  `folder_id` int(10) unsigned NOT NULL default '0',
  `date_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `state` int(11) NOT NULL default '0',
  `priority` int(1) unsigned NOT NULL default '0',
  `subject` varchar(230) NOT NULL default '',
  `message` text NOT NULL,
  PRIMARY KEY  (`message_id`)
) TYPE=MyISAM;

#
# Table structure for table `#__messages_cfg`
#

CREATE TABLE `#__messages_cfg` (
  `user_id` int(10) unsigned NOT NULL default '0',
  `cfg_name` varchar(100) NOT NULL default '',
  `cfg_value` varchar(255) NOT NULL default '',
  UNIQUE `idx_user_var_name` (`user_id`,`cfg_name`)
) TYPE=MyISAM;

#
# Table structure for table `#__modules`
#

CREATE TABLE `#__modules` (
  `id` int(11) NOT NULL auto_increment,
  `title` text NOT NULL,
  `content` text NOT NULL,
  `ordering` int(11) NOT NULL default '0',
  `position` varchar(10) default NULL,
  `checked_out` int(11) unsigned NOT NULL default '0',
  `checked_out_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `published` tinyint(1) NOT NULL default '0',
  `module` varchar(50) default NULL,
  `numnews` int(11) NOT NULL default '0',
  `access` tinyint(3) unsigned NOT NULL default '0',
  `showtitle` tinyint(3) unsigned NOT NULL default '1',
  `params` text NOT NULL,
  `iscore` tinyint(4) NOT NULL default '0',
  `client_id` tinyint(4) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `published` (`published`,`access`),
  KEY `newsfeeds` (`module`,`published`)
) TYPE=MyISAM;

#
# Dumping data for table `#__modules`
#

INSERT INTO `#__modules` VALUES (0, 'Sondage', '', 1, 'right', 0, '0000-00-00 00:00:00', 1, 'mod_poll', 0, 0, 1, '', 0, 0);
INSERT INTO `#__modules` VALUES (0, 'Menu utilisateur', '', 2, 'left', 0, '0000-00-00 00:00:00', 1, 'mod_mainmenu', 0, 1, 1, 'menutype=usermenu', 1, 0);
INSERT INTO `#__modules` VALUES (0, 'Menu principal', '', 1, 'left', 0, '0000-00-00 00:00:00', 1, 'mod_mainmenu', 0, 0, 1, 'menutype=mainmenu', 1, 0);
INSERT INTO `#__modules` VALUES (0, 'Identification', '', 3, 'left', 0, '0000-00-00 00:00:00', 1, 'mod_login', 0, 0, 1, '', 1, 0);
INSERT INTO `#__modules` VALUES (0, 'Syndication', '', 4, 'left', 0, '0000-00-00 00:00:00', 1, 'mod_rssfeed', 0, 0, 1, '', 1, 0);
INSERT INTO `#__modules` VALUES (0, 'Derniers articles', '', 4, 'user1', 0, '0000-00-00 00:00:00', 1, 'mod_latestnews', 0, 0, 1, '', 1, 0);
INSERT INTO `#__modules` VALUES (0, 'Statistiques', '', 4, 'left', 0, '0000-00-00 00:00:00', 0, 'mod_stats', 0, 0, 1, 'serverinfo=1\nsiteinfo=1\ncounter=1\nincrease=0\nmoduleclass_sfx=', 0, 0);
INSERT INTO `#__modules` VALUES (0, 'Qui est en ligne', '', 1, 'right', 0, '0000-00-00 00:00:00', 1, 'mod_whosonline', 0, 0, 1, 'online=1\nusers=1\nmoduleclass_sfx=', 0, 0);
INSERT INTO `#__modules` VALUES (0, 'Articles les plus lus', '', 6, 'user2', 0, '0000-00-00 00:00:00', 1, 'mod_mostread', 0, 0, 1, '', 0, 0);
INSERT INTO `#__modules` VALUES (0, 'Sélecteur de template','',6,'left',0,'0000-00-00 00:00:00',0,'mod_templatechooser', 0, 0, 1, 'show_preview=1', 0, 0);
INSERT INTO `#__modules` VALUES (0, 'Archive', '', 7, 'left', 0, '0000-00-00 00:00:00', 0, 'mod_archive', 0, 0, 1, '', 1, 0);
INSERT INTO `#__modules` VALUES (0, 'Sections', '', 8, 'left', 0, '0000-00-00 00:00:00', 0, 'mod_sections', 0, 0, 1, '', 1, 0);
INSERT INTO `#__modules` VALUES (0, 'Flash info', '', 1, 'top', 0, '0000-00-00 00:00:00', 1, 'mod_newsflash', 0, 0, 1, 'catid=3\r\nstyle=random\r\nitems=\r\nmoduleclass_sfx=', 0, 0);
INSERT INTO `#__modules` VALUES (0, 'Articles similaires', '', 9, 'left', 0, '0000-00-00 00:00:00', 0, 'mod_related_items', 0, 0, 1, '', 0, 0);
INSERT INTO `#__modules` VALUES (0, 'Recherche', '', 1, 'user4', 0, '0000-00-00 00:00:00', 1, 'mod_search', 0, 0, 0, '', 0, 0);
INSERT INTO `#__modules` VALUES (0, 'Image aléatoire', '', 9, 'right', 0, '0000-00-00 00:00:00', 1, 'mod_random_image', 0, 0, 1, '', 0, 0);
INSERT INTO `#__modules` VALUES (0, 'Menu top', '', 1, 'user3', 0, '0000-00-00 00:00:00', 1, 'mod_mainmenu', 0, 0, 0, 'menutype=topmenu\nmenu_style=list_flat\nmenu_images=n\nmenu_images_align=left\nexpand_menu=n\nclass_sfx=-nav\nmoduleclass_sfx=\nindent_image1=0\nindent_image2=0\nindent_image3=0\nindent_image4=0\nindent_image5=0\nindent_image6=0', 1, 0);
INSERT INTO `#__modules` VALUES (0, 'Bannières', '', 1, 'banner', 0, '0000-00-00 00:00:00', 1, 'mod_banners', 0, 0, 0, 'banner_cids=\nmoduleclass_sfx=\n', 1, 0);
INSERT INTO `#__modules` VALUES (0,'Composants','',2,'cpanel',0,'0000-00-00 00:00:00',1,'mod_components',0,99,1,'',1, 1);
INSERT INTO `#__modules` VALUES (0,'Les plus lus','',3,'cpanel',0,'0000-00-00 00:00:00',1,'mod_popular',0,99,1,'',0, 1);
INSERT INTO `#__modules` VALUES (0,'Derniers articles','',4,'cpanel',0,'0000-00-00 00:00:00',1,'mod_latest',0,99,1,'',0, 1);
INSERT INTO `#__modules` VALUES (0,'Stats des menus','',5,'cpanel',0,'0000-00-00 00:00:00',1,'mod_stats',0,99,1,'',0, 1);
INSERT INTO `#__modules` VALUES (0,'Messages non lus','',1,'header',0,'0000-00-00 00:00:00',1,'mod_unread',0,99,1,'',1, 1);
INSERT INTO `#__modules` VALUES (0,'Utilisateurs en ligne','',2,'header',0,'0000-00-00 00:00:00',1,'mod_online',0,99,1,'',1, 1);
INSERT INTO `#__modules` VALUES (0,'Menu entier','',1,'top',0,'0000-00-00 00:00:00',1,'mod_fullmenu',0,99,1,'',1, 1);
INSERT INTO `#__modules` VALUES (0,'Chemin','',1,'pathway',0,'0000-00-00 00:00:00',1,'mod_pathway',0,99,1,'',1, 1);
INSERT INTO `#__modules` VALUES (0,'Barre d&#146;outils','',1,'toolbar',0,'0000-00-00 00:00:00',1,'mod_toolbar',0,99,1,'',1, 1);
INSERT INTO `#__modules` VALUES (0,'Message système','',1,'inset',0,'0000-00-00 00:00:00',1,'mod_mosmsg',0,99,1,'',1, 1);
INSERT INTO `#__modules` VALUES (0,'Icônes raccourcis','',1,'icon',0,'0000-00-00 00:00:00',1,'mod_quickicon',0,99,1,'',1,1);
INSERT INTO `#__modules` VALUES (0, 'Autre menu', '', 2, 'left', 0, '0000-00-00 00:00:00', 1, 'mod_mainmenu', 0, 0, 0, 'menutype=othermenu\nmenu_style=vert_indent\ncache=0\nmenu_images=0\nmenu_images_align=0\nexpand_menu=0\nclass_sfx=\nmoduleclass_sfx=\nindent_image=0\nindent_image1=\nindent_image2=\nindent_image3=\nindent_image4=\nindent_image5=\nindent_image6=', 0, 0);
INSERT INTO `#__modules` VALUES (0,'Wrapper','',10,'left',0,'0000-00-00 00:00:00',0,'mod_wrapper',0,0,1,'',0, 0);
INSERT INTO `#__modules` VALUES (0,'Connectés','',0,'cpanel',0,'0000-00-00 00:00:00',1,'mod_logged',0,99,1,'',0,1);

# --------------------------------------------------------

#
# Table structure for table `#__modules_menu`
#

CREATE TABLE `#__modules_menu` (
  `moduleid` int(11) NOT NULL default '0',
  `menuid` int(11) NOT NULL default '0',
  PRIMARY KEY  (`moduleid`,`menuid`)
) TYPE=MyISAM;

#
# Dumping data for table `#__modules_menu`
#

INSERT INTO `#__modules_menu` VALUES (1,1);
INSERT INTO `#__modules_menu` VALUES (2,0);
INSERT INTO `#__modules_menu` VALUES (3,0);
INSERT INTO `#__modules_menu` VALUES (4,1);
INSERT INTO `#__modules_menu` VALUES (5,1);
INSERT INTO `#__modules_menu` VALUES (6,1);
INSERT INTO `#__modules_menu` VALUES (6,2);
INSERT INTO `#__modules_menu` VALUES (6,4);
INSERT INTO `#__modules_menu` VALUES (6,27);
INSERT INTO `#__modules_menu` VALUES (6,36);
INSERT INTO `#__modules_menu` VALUES (8,1);
INSERT INTO `#__modules_menu` VALUES (9,1);
INSERT INTO `#__modules_menu` VALUES (9,2);
INSERT INTO `#__modules_menu` VALUES (9,4);
INSERT INTO `#__modules_menu` VALUES (9,27);
INSERT INTO `#__modules_menu` VALUES (9,36);
INSERT INTO `#__modules_menu` VALUES (10,1);
INSERT INTO `#__modules_menu` VALUES (13,0);
INSERT INTO `#__modules_menu` VALUES (15,0);
INSERT INTO `#__modules_menu` VALUES (17,0);
INSERT INTO `#__modules_menu` VALUES (18,0);
INSERT INTO `#__modules_menu` VALUES (30,0);

# --------------------------------------------------------

#
# Table structure for table `#__newsfeeds`
#

CREATE TABLE `#__newsfeeds` (
  `catid` int(11) NOT NULL default '0',
  `id` int(11) NOT NULL auto_increment,
  `name` text NOT NULL,
  `link` text NOT NULL,
  `filename` varchar(200) default NULL,
  `published` tinyint(1) NOT NULL default '0',
  `numarticles` int(11) unsigned NOT NULL default '1',
  `cache_time` int(11) unsigned NOT NULL default '3600',
  `checked_out` tinyint(3) unsigned NOT NULL default '0',
  `checked_out_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `ordering` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `published` (`published`)
) TYPE=MyISAM;

#
# Table structure for table `#__poll_data`
#

CREATE TABLE `#__poll_data` (
  `id` int(11) NOT NULL auto_increment,
  `pollid` int(4) NOT NULL default '0',
  `text` text NOT NULL,
  `hits` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `pollid` (`pollid`,`text`(1))
) TYPE=MyISAM;

#
# Table structure for table `#__poll_date`
#

CREATE TABLE `#__poll_date` (
  `id` bigint(20) NOT NULL auto_increment,
  `date` datetime NOT NULL default '0000-00-00 00:00:00',
  `vote_id` int(11) NOT NULL default '0',
  `poll_id` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `poll_id` (`poll_id`)
) TYPE=MyISAM;

#
# Table structure for table `#__polls`
#

CREATE TABLE `#__polls` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `title` varchar(100) NOT NULL default '',
  `voters` int(9) NOT NULL default '0',
  `checked_out` int(11) NOT NULL default '0',
  `checked_out_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `published` tinyint(1) NOT NULL default '0',
  `access` int(11) NOT NULL default '0',
  `lag` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM;

#
# Table structure for table `#__poll_menu`
#

CREATE TABLE `#__poll_menu` (
  `pollid` int(11) NOT NULL default '0',
  `menuid` int(11) NOT NULL default '0',
  PRIMARY KEY  (`pollid`,`menuid`)
) TYPE=MyISAM;

#
# Table structure for table `#__sections`
#

CREATE TABLE `#__sections` (
  `id` int(11) NOT NULL auto_increment,
  `title` varchar(50) NOT NULL default '',
  `name` varchar(255) NOT NULL default '',
  `image` varchar(100) NOT NULL default '',
  `scope` varchar(50) NOT NULL default '',
  `image_position` varchar(10) NOT NULL default '',
  `description` text NOT NULL,
  `published` tinyint(1) NOT NULL default '0',
  `checked_out` int(11) unsigned NOT NULL default '0',
  `checked_out_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `ordering` int(11) NOT NULL default '0',
  `access` tinyint(3) unsigned NOT NULL default '0',
  `count` int(11) NOT NULL default '0',
  `params` text NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `idx_scope` (`scope`)
) TYPE=MyISAM;

#
# Table structure for table `#__session`
#

CREATE TABLE `#__session` (
  `username` varchar(50) default '',
  `time` varchar(14) default '',
  `session_id` varchar(200) NOT NULL default '0',
  `guest` tinyint(4) default '1',
  `userid` int(11) default '0',
  `usertype` varchar(50) default '',
  `gid` tinyint(3) unsigned NOT NULL default '0',
  PRIMARY KEY  (`session_id`),
  KEY `whosonline` (`guest`,`usertype`)
) TYPE=MyISAM;

#
# Table structure for table `#__stats_agents`
#

CREATE TABLE `#__stats_agents` (
  `agent` varchar(255) NOT NULL default '',
  `type` tinyint(1) unsigned NOT NULL default '0',
  `hits` int(11) unsigned NOT NULL default '1'
) TYPE=MyISAM;

#
# Table structure for table `#__templates_menu`
#

CREATE TABLE `#__templates_menu` (
  `template` varchar(50) NOT NULL default '',
  `menuid` int(11) NOT NULL default '0',
  `client_id` tinyint(4) NOT NULL default '0',
  PRIMARY KEY  (`template`,`menuid`)
) TYPE=MyISAM;

# Dumping data for table `#__templates_menu`

INSERT INTO `#__templates_menu` VALUES ('rhuk_solarflare_ii', '0', '0');
INSERT INTO `#__templates_menu` VALUES ('joomla_admin', '0', '1');

# --------------------------------------------------------

#
# Table structure for table `#__template_positions`
#

CREATE TABLE `#__template_positions` (
  `id` int(11) NOT NULL auto_increment,
  `position` varchar(10) NOT NULL default '',
  `description` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM;

#
# Dumping data for table `#__template_positions`
#

INSERT INTO `#__template_positions` VALUES (0, 'left', '');
INSERT INTO `#__template_positions` VALUES (0, 'right', '');
INSERT INTO `#__template_positions` VALUES (0, 'top', '');
INSERT INTO `#__template_positions` VALUES (0, 'bottom', '');
INSERT INTO `#__template_positions` VALUES (0, 'inset', '');
INSERT INTO `#__template_positions` VALUES (0, 'banner', '');
INSERT INTO `#__template_positions` VALUES (0, 'header', '');
INSERT INTO `#__template_positions` VALUES (0, 'footer', '');
INSERT INTO `#__template_positions` VALUES (0, 'newsflash', '');
INSERT INTO `#__template_positions` VALUES (0, 'legals', '');
INSERT INTO `#__template_positions` VALUES (0, 'pathway', '');
INSERT INTO `#__template_positions` VALUES (0, 'toolbar', '');
INSERT INTO `#__template_positions` VALUES (0, 'cpanel', '');
INSERT INTO `#__template_positions` VALUES (0, 'user1', '');
INSERT INTO `#__template_positions` VALUES (0, 'user2', '');
INSERT INTO `#__template_positions` VALUES (0, 'user3', '');
INSERT INTO `#__template_positions` VALUES (0, 'user4', '');
INSERT INTO `#__template_positions` VALUES (0, 'user5', '');
INSERT INTO `#__template_positions` VALUES (0, 'user6', '');
INSERT INTO `#__template_positions` VALUES (0, 'user7', '');
INSERT INTO `#__template_positions` VALUES (0, 'user8', '');
INSERT INTO `#__template_positions` VALUES (0, 'user9', '');
INSERT INTO `#__template_positions` VALUES (0, 'advert1', '');
INSERT INTO `#__template_positions` VALUES (0, 'advert2', '');
INSERT INTO `#__template_positions` VALUES (0, 'advert3', '');
INSERT INTO `#__template_positions` VALUES (0, 'icon', '');
INSERT INTO `#__template_positions` VALUES (0, 'debug', '');
# --------------------------------------------------------

#
# Table structure for table `#__users`
#

CREATE TABLE `#__users` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(50) NOT NULL default '',
  `username` varchar(25) NOT NULL default '',
  `email` varchar(100) NOT NULL default '',
  `password` varchar(100) NOT NULL default '',
  `usertype` varchar(25) NOT NULL default '',
  `block` tinyint(4) NOT NULL default '0',
  `sendEmail` tinyint(4) default '0',
  `gid` tinyint(3) unsigned NOT NULL default '1',
  `registerDate` datetime NOT NULL default '0000-00-00 00:00:00',
  `lastvisitDate` datetime NOT NULL default '0000-00-00 00:00:00',
  `activation` varchar(100) NOT NULL default '',
  `params` text NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `usertype` (`usertype`),
  KEY `idx_name` (`name`)
) TYPE=MyISAM;

#
# Table structure for table `#__usertypes`
#

CREATE TABLE `#__usertypes` (
  `id` tinyint(3) unsigned NOT NULL default '0',
  `name` varchar(50) NOT NULL default '',
  `mask` varchar(11) NOT NULL default '',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM;

#
# Dumping data for table `#__usertypes`
#

INSERT INTO `#__usertypes` VALUES (0, 'superadministrator', '');
INSERT INTO `#__usertypes` VALUES (1, 'administrator', '');
INSERT INTO `#__usertypes` VALUES (2, 'editor', '');
INSERT INTO `#__usertypes` VALUES (3, 'user', '');
INSERT INTO `#__usertypes` VALUES (4, 'author', '');
INSERT INTO `#__usertypes` VALUES (5, 'publisher', '');
INSERT INTO `#__usertypes` VALUES (6, 'manager', '');
# --------------------------------------------------------

#
# Table structure for table `#__weblinks`
#

CREATE TABLE `#__weblinks` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `catid` int(11) NOT NULL default '0',
  `sid` int(11) NOT NULL default '0',
  `title` varchar(250) NOT NULL default '',
  `url` varchar(250) NOT NULL default '',
  `description` varchar(250) NOT NULL default '',
  `date` datetime NOT NULL default '0000-00-00 00:00:00',
  `hits` int(11) NOT NULL default '0',
  `published` tinyint(1) NOT NULL default '0',
  `checked_out` int(11) NOT NULL default '0',
  `checked_out_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `ordering` int(11) NOT NULL default '0',
  `archived` tinyint(1) NOT NULL default '0',
  `approved` tinyint(1) NOT NULL default '1',
  `params` text NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `catid` (`catid`,`published`,`archived`)
) TYPE=MyISAM;

#
# Table structure for table `#__core_acl_aro`
#

CREATE TABLE `#__core_acl_aro` (
  `aro_id` int(11) NOT NULL auto_increment,
  `section_value` varchar(240) NOT NULL default '0',
  `value` varchar(240) NOT NULL default '',
  `order_value` int(11) NOT NULL default '0',
  `name` varchar(255) NOT NULL default '',
  `hidden` int(11) NOT NULL default '0',
  PRIMARY KEY  (`aro_id`),
  UNIQUE KEY `#__gacl_section_value_value_aro` (`section_value`(100),`value`(100)),
  KEY `#__gacl_hidden_aro` (`hidden`)
) TYPE=MyISAM;

#
# Table structure for table `#__core_acl_aro_groups`
#
CREATE TABLE `#__core_acl_aro_groups` (
  `group_id` int(11) NOT NULL auto_increment,
  `parent_id` int(11) NOT NULL default '0',
  `name` varchar(255) NOT NULL default '',
  `lft` int(11) NOT NULL default '0',
  `rgt` int(11) NOT NULL default '0',
  PRIMARY KEY  (`group_id`),
  KEY `parent_id_aro_groups` (`parent_id`),
  KEY `#__gacl_parent_id_aro_groups` (`parent_id`),
  KEY `#__gacl_lft_rgt_aro_groups` (`lft`,`rgt`)
) TYPE=MyISAM;

#
# Dumping data for table `#__core_acl_aro_groups`
#
INSERT INTO `#__core_acl_aro_groups` VALUES (17,0,'ROOT',1,22);
INSERT INTO `#__core_acl_aro_groups` VALUES (28,17,'USERS',2,21);
INSERT INTO `#__core_acl_aro_groups` VALUES (29,28,'Public Frontend',3,12);
INSERT INTO `#__core_acl_aro_groups` VALUES (18,29,'Registered',4,11);
INSERT INTO `#__core_acl_aro_groups` VALUES (19,18,'Author',5,10);
INSERT INTO `#__core_acl_aro_groups` VALUES (20,19,'Editor',6,9);
INSERT INTO `#__core_acl_aro_groups` VALUES (21,20,'Publisher',7,8);
INSERT INTO `#__core_acl_aro_groups` VALUES (30,28,'Public Backend',13,20);
INSERT INTO `#__core_acl_aro_groups` VALUES (23,30,'Manager',14,19);
INSERT INTO `#__core_acl_aro_groups` VALUES (24,23,'Administrator',15,18);
INSERT INTO `#__core_acl_aro_groups` VALUES (25,24,'Super Administrator',16,17);

#
# Table structure for table `#__core_acl_groups_aro_map`
#
CREATE TABLE `#__core_acl_groups_aro_map` (
  `group_id` int(11) NOT NULL default '0',
  `section_value` varchar(240) NOT NULL default '',
  `aro_id` int(11) NOT NULL default '0',
  UNIQUE KEY `group_id_aro_id_groups_aro_map` (`group_id`,`section_value`,`aro_id`)
) TYPE=MyISAM;

#
# Table structure for table `#__core_acl_aro_sections`
#
CREATE TABLE `#__core_acl_aro_sections` (
  `section_id` int(11) NOT NULL auto_increment,
  `value` varchar(230) NOT NULL default '',
  `order_value` int(11) NOT NULL default '0',
  `name` varchar(230) NOT NULL default '',
  `hidden` int(11) NOT NULL default '0',
  PRIMARY KEY  (`section_id`),
  UNIQUE KEY `value_aro_sections` (`value`),
  UNIQUE KEY `#__gacl_value_aro_sections` (`value`),
  KEY `hidden_aro_sections` (`hidden`),
  KEY `#__gacl_hidden_aro_sections` (`hidden`)
) TYPE=MyISAM;

INSERT INTO `#__core_acl_aro_sections` VALUES (10,'users',1,'Users',0);
