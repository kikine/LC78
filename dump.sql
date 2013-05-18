-- phpMyAdmin SQL Dump
-- version 2.7.0-pl2
-- http://www.phpmyadmin.net
-- 
-- Serveur: localhost
-- Généré le : Samedi 18 Août 2007 à 17:08
-- Version du serveur: 5.0.18
-- Version de PHP: 5.1.2
-- 
-- Base de données: `lc78escrimecom`
-- 


USE lc78escrimecom;
-- --------------------------------------------------------

-- 
-- Structure de la table `jos_banner`
-- 

DROP TABLE IF EXISTS `jos_banner`;
CREATE TABLE IF NOT EXISTS `jos_banner` (
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
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

-- 
-- Contenu de la table `jos_banner`
-- 

INSERT INTO `jos_banner` VALUES (1, 1, 'banner', 'OSM 1', 0, 43, 0, 'osmbanner1.png', 'http://www.opensourcematters.org', '2004-07-07 15:31:29', 1, 0, '0000-00-00 00:00:00', NULL, NULL);
INSERT INTO `jos_banner` VALUES (2, 1, 'banner', 'OSM 2', 0, 54, 0, 'osmbanner2.png', 'http://www.opensourcematters.org', '2004-07-07 15:31:29', 1, 0, '0000-00-00 00:00:00', NULL, NULL);
INSERT INTO `jos_banner` VALUES (3, 2, '', 'Joomla.fr', 0, 10, 0, 'banner_jfr.gif', 'http://www.joomla.fr', '2006-03-18 22:24:36', 1, 0, '0000-00-00 00:00:00', '', '');

-- --------------------------------------------------------

-- 
-- Structure de la table `jos_bannerclient`
-- 

DROP TABLE IF EXISTS `jos_bannerclient`;
CREATE TABLE IF NOT EXISTS `jos_bannerclient` (
  `cid` int(11) NOT NULL auto_increment,
  `name` varchar(60) NOT NULL default '',
  `contact` varchar(60) NOT NULL default '',
  `email` varchar(60) NOT NULL default '',
  `extrainfo` text NOT NULL,
  `checked_out` tinyint(1) NOT NULL default '0',
  `checked_out_time` time default NULL,
  `editor` varchar(50) default NULL,
  PRIMARY KEY  (`cid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

-- 
-- Contenu de la table `jos_bannerclient`
-- 

INSERT INTO `jos_bannerclient` VALUES (1, 'Open Source Matters', 'Administrator', 'admin@opensourcematters.org', '', 0, '00:00:00', NULL);
INSERT INTO `jos_bannerclient` VALUES (2, 'Joomla.fr', 'Admin', 'admins@joomla.fr', '', 0, '00:00:00', '');

-- --------------------------------------------------------

-- 
-- Structure de la table `jos_bannerfinish`
-- 

DROP TABLE IF EXISTS `jos_bannerfinish`;
CREATE TABLE IF NOT EXISTS `jos_bannerfinish` (
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
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- 
-- Contenu de la table `jos_bannerfinish`
-- 


-- --------------------------------------------------------

-- 
-- Structure de la table `jos_categories`
-- 

DROP TABLE IF EXISTS `jos_categories`;
CREATE TABLE IF NOT EXISTS `jos_categories` (
  `id` int(11) NOT NULL auto_increment,
  `parent_id` int(11) NOT NULL default '0',
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
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=16 ;

-- 
-- Contenu de la table `jos_categories`
-- 

INSERT INTO `jos_categories` VALUES (1, 0, 'Dernières news', 'Dernières news', 'taking_notes.jpg', '1', 'left', 'Les dernères news du site', 1, 0, '0000-00-00 00:00:00', '', 0, 0, 1, '');
INSERT INTO `jos_categories` VALUES (2, 0, 'Joomla!', 'Joomla!', 'clock.jpg', 'com_weblinks', 'left', 'A selection of links that are all related to the Joomla! Project.', 0, 0, '0000-00-00 00:00:00', NULL, 2, 0, 0, '');
INSERT INTO `jos_categories` VALUES (3, 0, 'Newsflash', 'Newsflash', '', '2', 'left', '', 1, 0, '0000-00-00 00:00:00', '', 0, 0, 0, '');
INSERT INTO `jos_categories` VALUES (4, 0, 'Joomla!', 'Joomla!', '', 'com_newsfeeds', 'left', '', 1, 0, '0000-00-00 00:00:00', NULL, 2, 0, 0, '');
INSERT INTO `jos_categories` VALUES (5, 0, 'Business: general', 'Business: general', '', 'com_newsfeeds', 'left', '', 1, 0, '0000-00-00 00:00:00', NULL, 1, 0, 0, '');
INSERT INTO `jos_categories` VALUES (7, 0, 'Exemples', 'Exemple FAQs', 'key.jpg', '3', 'left', 'Here you will find an example set of FAQs.', 1, 0, '0000-00-00 00:00:00', NULL, 0, 0, 2, '');
INSERT INTO `jos_categories` VALUES (9, 0, 'Finance', 'Finance', '', 'com_newsfeeds', 'left', '', 1, 0, '0000-00-00 00:00:00', NULL, 5, 0, 0, '');
INSERT INTO `jos_categories` VALUES (10, 0, 'Linux', 'Linux', '', 'com_newsfeeds', 'left', '<br />\r\n', 1, 0, '0000-00-00 00:00:00', NULL, 6, 0, 0, '');
INSERT INTO `jos_categories` VALUES (11, 0, 'Internet', 'Internet', '', 'com_newsfeeds', 'left', '', 1, 0, '0000-00-00 00:00:00', NULL, 7, 0, 0, '');
INSERT INTO `jos_categories` VALUES (12, 0, 'Contacts', 'Contacts', '', 'com_contact_details', 'left', 'Les ma&icirc;tres d&#39;armes, les b&eacute;n&eacute;voles...', 1, 0, '0000-00-00 00:00:00', NULL, 1, 0, 0, '');
INSERT INTO `jos_categories` VALUES (13, 0, 'Liens institutionnels', 'Liens institutionnels', '', 'com_weblinks', 'left', '', 1, 0, '0000-00-00 00:00:00', NULL, 3, 0, 0, '');
INSERT INTO `jos_categories` VALUES (14, 0, 'Partenaires', 'Partenaires', '', 'com_weblinks', 'left', '', 1, 0, '0000-00-00 00:00:00', NULL, 1, 0, 0, '');
INSERT INTO `jos_categories` VALUES (15, 0, 'Ligues Régionales d\\''escrime', 'Ligues Régionales d\\''escrime', '', 'com_weblinks', 'left', '', 1, 0, '0000-00-00 00:00:00', NULL, 4, 0, 0, '');

-- --------------------------------------------------------

-- 
-- Structure de la table `jos_components`
-- 

DROP TABLE IF EXISTS `jos_components`;
CREATE TABLE IF NOT EXISTS `jos_components` (
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
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=37 ;

-- 
-- Contenu de la table `jos_components`
-- 

INSERT INTO `jos_components` VALUES (1, 'Bannières', '', 0, 0, '', 'Gestion des bannières', 'com_banners', 0, 'js/ThemeOffice/component.png', 0, '');
INSERT INTO `jos_components` VALUES (2, 'Gérer les bannières', '', 0, 1, 'option=com_banners', 'Bannières actives', 'com_banners', 1, 'js/ThemeOffice/edit.png', 0, '');
INSERT INTO `jos_components` VALUES (3, 'Gérer les clients', '', 0, 1, 'option=com_banners&task=listclients', 'Manage Clients', 'com_banners', 2, 'js/ThemeOffice/categories.png', 0, '');
INSERT INTO `jos_components` VALUES (4, 'Liens web', 'option=com_weblinks', 0, 0, '', 'Gestion des liens web', 'com_weblinks', 0, 'js/ThemeOffice/globe2.png', 0, '');
INSERT INTO `jos_components` VALUES (5, 'Liens web', '', 0, 4, 'option=com_weblinks', 'Voir les liens web existantss', 'com_weblinks', 1, 'js/ThemeOffice/edit.png', 0, '');
INSERT INTO `jos_components` VALUES (6, 'Catégories de liens web', '', 0, 4, 'option=categories&section=com_weblinks', 'Gestion des catégories de liens web', '', 2, 'js/ThemeOffice/categories.png', 0, '');
INSERT INTO `jos_components` VALUES (7, 'Contacts', 'option=com_contact', 0, 0, '', 'Gestion des contacts', 'com_contact', 0, 'js/ThemeOffice/user.png', 1, '');
INSERT INTO `jos_components` VALUES (8, 'Gérer les contacts', '', 0, 7, 'option=com_contact', 'Editer les contacts', 'com_contact', 0, 'js/ThemeOffice/edit.png', 1, '');
INSERT INTO `jos_components` VALUES (9, 'Catégories de contacts', '', 0, 7, 'option=categories&section=com_contact_details', 'Gestion des catégories de contacts', '', 2, 'js/ThemeOffice/categories.png', 1, '');
INSERT INTO `jos_components` VALUES (10, 'Page d&#146;accueil', 'option=com_frontpage', 0, 0, '', 'Gestion des articles de la page d&#146;accueil', 'com_frontpage', 0, 'js/ThemeOffice/component.png', 1, '');
INSERT INTO `jos_components` VALUES (11, 'Sondage', 'option=com_poll', 0, 0, 'option=com_poll', 'Gestion des sondages', 'com_poll', 0, 'js/ThemeOffice/component.png', 0, '');
INSERT INTO `jos_components` VALUES (12, 'Flux RSS', 'option=com_newsfeeds', 0, 0, '', 'Gestion des Flux RSS', 'com_newsfeeds', 0, 'js/ThemeOffice/component.png', 0, '');
INSERT INTO `jos_components` VALUES (13, 'Gérer les flux RSS', '', 0, 12, 'option=com_newsfeeds', 'Gestion des Flux RSS', 'com_newsfeeds', 1, 'js/ThemeOffice/edit.png', 0, '');
INSERT INTO `jos_components` VALUES (14, 'Gérer les catégories', '', 0, 12, 'option=com_categories&section=com_newsfeeds', 'Gestion des catégories', '', 2, 'js/ThemeOffice/categories.png', 0, '');
INSERT INTO `jos_components` VALUES (15, 'Identification', 'option=com_login', 0, 0, '', '', 'com_login', 0, '', 1, '');
INSERT INTO `jos_components` VALUES (16, 'Recherche', 'option=com_search', 0, 0, '', '', 'com_search', 0, '', 1, '');
INSERT INTO `jos_components` VALUES (17, 'Syndication', '', 0, 0, 'option=com_syndicate&hidemainmenu=1', 'Paramètres de syndication', 'com_syndicate', 0, 'js/ThemeOffice/component.png', 0, '');
INSERT INTO `jos_components` VALUES (18, 'Mailing', '', 0, 0, 'option=com_massmail&hidemainmenu=1', 'Envoyer un mailing', 'com_massmail', 0, 'js/ThemeOffice/mass_email.png', 0, '');
INSERT INTO `jos_components` VALUES (25, 'Joomlaboard Forum', 'option=com_joomlaboard', 0, 0, 'option=com_joomlaboard', 'Joomlaboard Forum', 'com_joomlaboard', 0, '../administrator/components/com_joomlaboard/images/sbmenu.png', 0, '');
INSERT INTO `jos_components` VALUES (23, 'Configuration', '', 0, 22, 'option=com_easygb&act=configuration', 'Configuration', 'com_easygb', 0, 'js/ThemeOffice/config.png', 0, '');
INSERT INTO `jos_components` VALUES (24, 'Manage Entries', '', 0, 22, 'option=com_easygb&act=entries', 'Manage Entries', 'com_easygb', 1, 'js/ThemeOffice/content.png', 0, '');
INSERT INTO `jos_components` VALUES (22, 'Easy Guestbook', 'option=com_easygb', 0, 0, 'option=com_easygb', 'Easy Guestbook', 'com_easygb', 0, '../administrator/components/com_easygb/icons/16x16_klipper.png', 0, '');
INSERT INTO `jos_components` VALUES (26, 'JooMap', 'option=com_joomap', 0, 0, 'option=com_joomap', 'JooMap', 'com_joomap', 0, 'js/ThemeOffice/component.png', 0, '');
INSERT INTO `jos_components` VALUES (27, 'zOOm Media Gallery', 'option=com_zoom', 0, 0, 'option=com_zoom', 'zOOm Media Gallery', 'com_zoom', 0, '../administrator/components/com_zoom/images/zoom_menu.png', 0, '');
INSERT INTO `jos_components` VALUES (28, 'GCalendar', 'option=com_gcalendar', 0, 0, 'option=com_gcalendar', 'GCalendar', 'com_gcalendar', 0, 'js/ThemeOffice/component.png', 0, '');
INSERT INTO `jos_components` VALUES (29, 'Show Calendars', '', 0, 28, 'option=com_gcalendar', 'Show Calendars', 'com_gcalendar', 0, 'js/ThemeOffice/component.png', 0, '');
INSERT INTO `jos_components` VALUES (30, 'JoomlaStats', 'option=com_joomlastats', 0, 0, 'option=com_joomlastats', 'JoomlaStats', 'com_joomlastats', 0, '../administrator/components/com_joomlastats/images/joomlastats_icon.png', 0, '');
INSERT INTO `jos_components` VALUES (31, 'Statistics', '', 0, 30, 'option=com_joomlastats&task=stats', 'Statistics', 'com_joomlastats', 0, '../administrator/components/com_joomlastats/images/joomlastats_icon.png', 0, '');
INSERT INTO `jos_components` VALUES (32, 'Configuration', '', 0, 30, 'option=com_joomlastats&task=getconf', 'Configuration', 'com_joomlastats', 1, '../administrator/components/com_joomlastats/images/menu_config.png', 0, '');
INSERT INTO `jos_components` VALUES (33, 'Exclude IP', '', 0, 30, 'option=com_joomlastats&task=viewip', 'Exclude IP', 'com_joomlastats', 2, '../administrator/components/com_joomlastats/images/menu_switch.png', 0, '');
INSERT INTO `jos_components` VALUES (34, 'Summerize database', '', 0, 30, 'option=com_joomlastats&task=summinfo', 'Summerize database', 'com_joomlastats', 3, '../administrator/components/com_joomlastats/images/menu_archive.png', 0, '');
INSERT INTO `jos_components` VALUES (35, 'Information', '', 0, 30, 'option=com_joomlastats&task=info', 'Information', 'com_joomlastats', 4, '../administrator/components/com_joomlastats/images/menu_info.png', 0, '');
INSERT INTO `jos_components` VALUES (36, 'JoomlaStats Uninstall', '', 0, 30, 'option=com_joomlastats&task=uninstall', 'JoomlaStats Uninstall', 'com_joomlastats', 5, '../administrator/components/com_joomlastats/images/menu_delete.png', 0, '');

-- --------------------------------------------------------

-- 
-- Structure de la table `jos_contact_details`
-- 

DROP TABLE IF EXISTS `jos_contact_details`;
CREATE TABLE IF NOT EXISTS `jos_contact_details` (
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
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

-- 
-- Contenu de la table `jos_contact_details`
-- 

INSERT INTO `jos_contact_details` VALUES (1, 'Le Chesnay 78 Escrime', 'Salle d''armes', '7 rue Pottier', 'Le Chesnay', 'Yvelines', 'France', '78150', '01 39 43 93 45', 'Fax', 'Téléphone portable des Maître d''armes : 06 15 96 59 42', 'asterisk.png', 'top', 'email@email.com', 0, 1, 0, '0000-00-00 00:00:00', 3, 'menu_image=-1\npageclass_sfx=\nprint=\nback_button=\nname=1\nposition=0\nemail=0\nstreet_address=1\nsuburb=1\nstate=0\ncountry=1\npostcode=1\ntelephone=1\nfax=0\nmisc=1\nimage=0\nvcard=0\nemail_description=0\nemail_description_text=\nemail_form=1\nemail_copy=0\ndrop_down=0\ncontact_icons=0\nicon_address=\nicon_email=\nicon_telephone=\nicon_fax=\nicon_misc=', 0, 12, 0);
INSERT INTO `jos_contact_details` VALUES (2, 'Thomas Raso', 'Webmaster', '---------------------', 'Versailles', 'Yvelines', 'France', '78000', '+33677814146', '', '', '', NULL, 'thomas.raso@lc78-escrime.com', 0, 1, 0, '0000-00-00 00:00:00', 2, 'menu_image=-1\npageclass_sfx=\nprint=\nback_button=\nname=1\nposition=1\nemail=0\nstreet_address=0\nsuburb=1\nstate=0\ncountry=0\npostcode=1\ntelephone=1\nfax=0\nmisc=0\nimage=0\nvcard=0\nemail_description=0\nemail_description_text=\nemail_form=1\nemail_copy=0\ndrop_down=0\ncontact_icons=0\nicon_address=\nicon_email=\nicon_telephone=\nicon_fax=\nicon_misc=', 66, 12, 0);
INSERT INTO `jos_contact_details` VALUES (3, 'Jean-Yves Huet', 'Maître d''armes', '', '', '', '', '', '06 15 96 59 42', '', '', '', NULL, 'jeanyveshuet@aol.com', 0, 1, 0, '0000-00-00 00:00:00', 1, 'menu_image=-1\npageclass_sfx=\nprint=\nback_button=\nname=1\nposition=1\nemail=0\nstreet_address=0\nsuburb=0\nstate=0\ncountry=0\npostcode=0\ntelephone=1\nfax=0\nmisc=0\nimage=0\nvcard=0\nemail_description=0\nemail_description_text=\nemail_form=1\nemail_copy=0\ndrop_down=0\ncontact_icons=0\nicon_address=\nicon_email=\nicon_telephone=\nicon_fax=\nicon_misc=', 0, 12, 0);

-- --------------------------------------------------------

-- 
-- Structure de la table `jos_content`
-- 

DROP TABLE IF EXISTS `jos_content`;
CREATE TABLE IF NOT EXISTS `jos_content` (
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
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=13 ;

-- 
-- Contenu de la table `jos_content`
-- 

INSERT INTO `jos_content` VALUES (1, 'Nouvelle version de notre site Internet', 'Nouvelle version', '<p><img src="http://www.lc78-escrime.com/images/divers/logo_lc78_escrime.gif" alt=" " align="left" />La voil&agrave; enfin, la tant attendu nouvelle version du site internet de LC78. Apr&egrave;s plusieurs semaines de travail, elle est maintenant ouverte au public.<br /><br />Cette version s&#39;appuie sur un autre syst&egrave;me de gestion de contenu. En effet, nous avons fait le choix de Joomla! plut&ocirc;t que de garder E107...</p><p>La vie du site du LC78-escrime sera facilit&eacute; par la cr&eacute;ation de r&eacute;dacteur qui pourront mettre en ligne divers articles concernant, les comp&eacute;titions, les entrainements, la vie du club, l&#39;humeur du moment...&nbsp;</p><p>Le modules permettant de consulter les galleries photos sera repens&eacute; un peu plus tard...&nbsp;</p><p>&nbsp;Enfin, veuillez nous escusez pour les potentiel probl&egrave;me d&#39;indisponibilit&eacute; du site qui pourront survenir lors des premi&egrave;res semaines d&#39;utilisation du site.</p>', '<h4><font color="#ff6600">Fonctionnalit&eacute; du nouveau site (Joomla) :<br /></font></h4> <ul>  <li>Site enti&egrave;rement pilot&eacute; par une base de donn&eacute;es</li> <li>Articles &eacute;ditables et g&eacute;rables sans limitations</li> <li>Les contributeurs peuvent soumettre des articles</li>  <li>Gestionnaire d&#39;images</li> <li>Gestionnaire de sondages/banni&egrave;res/votes</li></ul>  <h4>Administration &eacute;tendue:</h4> <ul><li>Gestionnaire de flux RSS</li> <li>Archivage des articles</li> <li>Envoi d&#39;article par mail ou en format imprimable</li></ul><p>&nbsp;</p><p>Cette nouvelle version nous permettra d&#39;am&eacute;liorer la qualit&eacute; de service offerte &agrave; nos internautes et d&#39;y acqu&eacute;rir des informations mises &agrave; jour de mani&egrave;res beaucoup plus r&eacute;guli&egrave;re.</p><p>&nbsp;Un sondage sera mis en place afin de connaitre votre opinion vis-&agrave;-vis de cette nouvelle version. </p><ul><br /><br /></ul>', 1, 1, 0, 1, '2004-06-12 11:54:06', 62, 'Webmaster', '2007-08-01 10:38:05', 62, 0, '0000-00-00 00:00:00', '2004-01-01 00:00:00', '0000-00-00 00:00:00', 'asterisk.png|left|Joomla! Logo|1|Exemple Caption|bottom|center|120', '', 'pageclass_sfx=\nback_button=\nitem_title=1\nlink_titles=\nintrotext=1\nsection=0\nsection_link=0\ncategory=0\ncategory_link=0\nrating=\nauthor=\ncreatedate=\nmodifydate=\npdf=\nprint=\nemail=\nkeyref=\ndocbook_type=', 6, 0, 2, '', '', 0, 4);
INSERT INTO `jos_content` VALUES (2, 'Arnaud Gacion à l''international', '', 'Arnaud Gacoin part une ann&eacute;e &eacute;tudier &agrave; l&#39;&eacute;tranger...', '<p>Arnaud Gacoin (Gomina pour les intimes !) nous quitte pour une ann&eacute;e afin de poursuivre ses &eacute;tudes. Tout d&#39;abord il ira passer quelques mois &agrave; Madrid capitale espagnole puis il s&#39;envolera pour la Floride.</p><p>&nbsp;Bonne chance et &agrave; bient&ocirc;t ! </p>', 1, 2, 0, 3, '2004-08-09 08:30:34', 66, '', '2007-07-16 11:18:03', 62, 0, '0000-00-00 00:00:00', '2004-08-09 00:00:00', '0000-00-00 00:00:00', '', '', 'pageclass_sfx=\nback_button=\nitem_title=1\nlink_titles=\nintrotext=1\nsection=0\nsection_link=0\ncategory=0\ncategory_link=0\nrating=\nauthor=\ncreatedate=\nmodifydate=\npdf=\nprint=\nemail=\nkeyref=\ndocbook_type=', 4, 0, 1, '', '', 0, 1);
INSERT INTO `jos_content` VALUES (3, 'Escrime au parc Aubert', 'Escrime au parc Aubert', 'Arnaud Gacoin et Jean-Baptiste comp&egrave;re l&#39;ont fait !', 'Pour la f&ecirc;te nationale, Arnaud Gacoin et Jean-Baptiste Comp&egrave;re ont effectu&eacute; quelques touches au parc Aubert', 1, 2, 0, 3, '2004-08-09 08:30:34', 66, '', '2007-08-01 10:35:21', 62, 0, '0000-00-00 00:00:00', '2004-08-09 00:00:00', '0000-00-00 00:00:00', '', '', 'pageclass_sfx=\nback_button=\nitem_title=1\nlink_titles=\nintrotext=1\nsection=0\nsection_link=0\ncategory=0\ncategory_link=0\nrating=\nauthor=\ncreatedate=\nmodifydate=\npdf=\nprint=\nemail=\nkeyref=\ndocbook_type=', 4, 0, 2, '', '', 0, 0);
INSERT INTO `jos_content` VALUES (4, 'Newsflash 3', '', 'Sleon une &eacute;dtue de l''Uvinertis&eacute; de Cmabrigde, l''odrre des ltteers dnas un mot n''a pas d''ipmrotncae, la suele coshe ipmrotnate est que la pmeir&egrave;re et la dren&egrave;ire soit à la bnnoe pclae. Le rsete peut &ecirc;rte dnas un ds&eacute;rorde ttoal et vuos puoevz tujoruos lrie snas porlbl&egrave;me. C''est prace que le creaveu hmauin ne lit pas chuaqe ltetre elle-mm&ecirc;e, mias le mot cmome un tuot.', '', -2, 2, 1, 3, '2004-08-09 08:30:34', 62, '', '0000-00-00 00:00:00', 0, 0, '0000-00-00 00:00:00', '2004-08-09 00:00:00', '0000-00-00 00:00:00', '', '', '', 1, 0, 0, '', '', 0, 1);
INSERT INTO `jos_content` VALUES (5, 'Joomla! License Guidelines', '', '<p>This website is powered by <a href="http://www.joomla.org/">Joomla!</a>  The software and default templates on which it runs are Copyright 2005 <a href="http://www.opensourcematters.org/">Open Source Matters</a>.  All other content and data, including data entered into this website and templates added after installation, are copyrighted by their respective copyright owners.</p><p>If you want to distribute, copy or modify Joomla!, you are welcome to do so under the terms of the <a href="http://www.gnu.org/copyleft/gpl.html#SEC1">GNU General Public License</a>.  If you are unfamiliar with this license, you might want to read <a href="http://www.gnu.org/copyleft/gpl.html#SEC4">''How To Apply These Terms To Your Program''</a> and the <a href="http://www.gnu.org/licenses/gpl-faq.html">''GNU General Public License FAQ''</a>.</p>', '', 1, 0, 0, 0, '2004-08-19 20:11:07', 62, '', '2004-08-19 20:14:49', 62, 0, '0000-00-00 00:00:00', '2004-08-19 00:00:00', '0000-00-00 00:00:00', '', '', 'menu_image=\nitem_title=1\npageclass_sfx=\nback_button=\nrating=\nauthor=\ncreatedate=\nmodifydate=\npdf=\nprint=\nemail=', 1, 0, 11, '', '', 0, 10);
INSERT INTO `jos_content` VALUES (6, 'Exemple Article 1', 'News1', '{mosimage}Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum.', '<p>{mosimage}Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat, vel illum dolore eu feugiat nulla facilisis at vero eros et accumsan et iusto odio dignissim qui blandit praesent luptatum zzril delenit augue duis dolore te feugait nulla facilisi. Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.</p>  <p>Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat. Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat, vel illum dolore eu feugiat nulla facilisis at vero eros et accumsan et iusto odio dignissim qui blandit praesent luptatum zzril delenit augue duis dolore te feugait nulla facilisi.</p>  <p>Nam liber tempor cum soluta nobis eleifend option congue nihil imperdiet doming id quod mazim placerat facer possim assum. Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat.</p>  <p>Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat, vel illum dolore eu feugiat nulla facilisis. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, At accusam aliquyam diam diam dolore dolores duo eirmod eos erat, et nonumy sed tempor et et invidunt justo labore Stet clita ea et gubergren, kasd magna no rebum. sanctus sea sed takimata ut vero voluptua. est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat.</p>  <p>Consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.</p>', -2, 1, 0, 1, '2004-07-07 11:54:06', 62, '', '2007-06-19 13:57:30', 62, 0, '0000-00-00 00:00:00', '2004-07-07 00:00:00', '0000-00-00 00:00:00', 'food/coffee.jpg|left||0\r\nfood/bread.jpg|right||0', '', 'pageclass_sfx=\nback_button=\nitem_title=1\nlink_titles=\nintrotext=1\nsection=0\nsection_link=0\ncategory=0\ncategory_link=0\nrating=\nauthor=\ncreatedate=\nmodifydate=\npdf=\nprint=\nemail=\nkeyref=\ndocbook_type=', 2, 0, 0, '', '', 0, 6);
INSERT INTO `jos_content` VALUES (7, 'Exemple Article 2', 'News2', '<p>{mosimage}Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat,\r\nsed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit\r\namet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam\r\nvoluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem\r\nipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At\r\nvero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.</p>', '', -2, 1, 0, 1, '2004-07-07 11:54:06', 62, '', '2004-07-07 18:11:30', 62, 0, '0000-00-00 00:00:00', '2004-07-07 00:00:00', '0000-00-00 00:00:00', 'food/bun.jpg|right||0', '', '', 1, 0, 0, '', '', 0, 3);
INSERT INTO `jos_content` VALUES (8, 'Exemple Article 3', 'News3', '<p>{mosimage}Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat,\r\nsed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit\r\namet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam\r\nvoluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem\r\nipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At\r\nvero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.</p>', '', -2, 1, 0, 1, '2004-04-12 11:54:06', 62, '', '2004-07-07 18:08:23', 62, 0, '0000-00-00 00:00:00', '2004-07-07 00:00:00', '0000-00-00 00:00:00', 'fruit/pears.jpg|right||0', '', '', 1, 0, 0, '', '', 0, 1);
INSERT INTO `jos_content` VALUES (9, 'Exemple Article 4', 'News4', '<p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat,\r\nsed diam voluptua. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam\r\nvoluptua. At\r\nvero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.</p>', '<p>{mosimage}Duis autem vel eum iriure dolor in hendrerit in vulputate\r\nvelit esse molestie consequat, vel illum dolore eu feugiat nulla facilisis at\r\nvero eros et accumsan et iusto odio dignissim qui blandit praesent luptatum\r\nzzril delenit augue duis dolore te feugait nulla facilisi. Lorem ipsum dolor\r\nsit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt\r\nut laoreet dolore magna aliquam erat volutpat.</p>\r\n\r\n{mospagebreak}<p>{mosimage}Ut wisi enim ad minim veniam, quis nostrud exerci tation\r\nullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat. Duis\r\nautem vel eum iriure dolor in hendrerit in vulputate velit esse molestie\r\nconsequat, vel illum dolore eu feugiat nulla facilisis at vero eros et accumsan\r\net iusto odio dignissim qui blandit praesent luptatum zzril delenit augue duis\r\ndolore te feugait nulla facilisi.</p>\r\n\r\n<p>{mosimage}Nam liber tempor cum soluta nobis eleifend option congue\r\nnihil imperdiet doming id quod mazim placerat facer possim assum. Lorem ipsum\r\ndolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod\r\ntincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim\r\nveniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut\r\naliquip ex ea commodo consequat.</p>\r\n\r\n<p>Duis autem vel eum iriure dolor in hendrerit in vulputate\r\nvelit esse molestie consequat, vel illum dolore eu feugiat nulla facilisis. At\r\nvero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd\r\ngubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum\r\ndolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor\r\ninvidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero\r\neos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no\r\nsea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit\r\namet, consetetur sadipscing elitr, At accusam aliquyam diam diam dolore dolores\r\nduo eirmod eos erat, et nonumy sed tempor et et invidunt justo labore Stet\r\nclita ea et gubergren, kasd magna no rebum. sanctus sea sed takimata ut vero\r\nvoluptua. est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet,\r\nconsetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore\r\net dolore magna aliquyam erat.</p>\r\n\r\n{mospagebreak}<p>Consetetur sadipscing elitr, sed diam nonumy eirmod tempor\r\ninvidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero\r\neos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no\r\nsea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit\r\namet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut\r\nlabore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam\r\net justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata\r\nsanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur\r\nsadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore\r\nmagna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo\r\ndolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est\r\nLorem ipsum dolor sit amet.</p>', -2, 1, 0, 1, '2004-07-07 11:54:06', 62, '', '2004-07-07 18:10:23', 62, 0, '0000-00-00 00:00:00', '2004-07-07 00:00:00', '0000-00-00 00:00:00', 'fruit/strawberry.jpg|left||0\r\nfruit/pears.jpg|right||0\r\nfruit/cherry.jpg|left||0', '', '', 1, 0, 0, '', '', 0, 7);
INSERT INTO `jos_content` VALUES (10, 'Exemple FAQ Item 1', 'FAQ1', '<p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat,\r\nsed diam voluptua. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam\r\nvoluptua. At\r\nvero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.</p>', '', -2, 3, 0, 7, '2004-05-12 11:54:06', 62, '', '2004-07-07 18:10:23', 62, 0, '0000-00-00 00:00:00', '2004-01-01 00:00:00', '0000-00-00 00:00:00', '', '', '', 1, 0, 0, '', '', 0, 8);
INSERT INTO `jos_content` VALUES (11, 'Exemple FAQ Item 2', 'FAQ2', '<p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat,\r\nsed diam voluptua. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam\r\nvoluptua. At\r\nvero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.</p>', '<p>{mosimage}Duis autem vel eum iriure dolor in hendrerit in vulputate\r\nvelit esse molestie consequat, vel illum dolore eu feugiat nulla facilisis at\r\nvero eros et accumsan et iusto odio dignissim qui blandit praesent luptatum\r\nzzril delenit augue duis dolore te feugait nulla facilisi. Lorem ipsum dolor\r\nsit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt\r\nut laoreet dolore magna aliquam erat volutpat.</p>\r\n\r\n<p>{mosimage}Ut wisi enim ad minim veniam, quis nostrud exerci tation\r\nullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat. Duis\r\nautem vel eum iriure dolor in hendrerit in vulputate velit esse molestie\r\nconsequat, vel illum dolore eu feugiat nulla facilisis at vero eros et accumsan\r\net iusto odio dignissim qui blandit praesent luptatum zzril delenit augue duis\r\ndolore te feugait nulla facilisi.</p>\r\n\r\n<p>{mosimage}Nam liber tempor cum soluta nobis eleifend option congue\r\nnihil imperdiet doming id quod mazim placerat facer possim assum. Lorem ipsum\r\ndolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod\r\ntincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim\r\nveniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut\r\naliquip ex ea commodo consequat.</p>\r\n\r\n<p>Duis autem vel eum iriure dolor in hendrerit in vulputate\r\nvelit esse molestie consequat, vel illum dolore eu feugiat nulla facilisis. At\r\nvero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd\r\ngubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum\r\ndolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor\r\ninvidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero\r\neos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no\r\nsea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit\r\namet, consetetur sadipscing elitr, At accusam aliquyam diam diam dolore dolores\r\nduo eirmod eos erat, et nonumy sed tempor et et invidunt justo labore Stet\r\nclita ea et gubergren, kasd magna no rebum. sanctus sea sed takimata ut vero\r\nvoluptua. est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet,\r\nconsetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore\r\net dolore magna aliquyam erat.</p>\r\n\r\n<p>Consetetur sadipscing elitr, sed diam nonumy eirmod tempor\r\ninvidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero\r\neos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no\r\nsea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit\r\namet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut\r\nlabore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam\r\net justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata\r\nsanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur\r\nsadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore\r\nmagna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo\r\ndolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est\r\nLorem ipsum dolor sit amet.</p>', -2, 3, 0, 7, '2004-05-12 11:54:06', 62, 'Webmaster', '2004-07-07 18:10:23', 62, 0, '0000-00-00 00:00:00', '2004-01-01 00:00:00', '0000-00-00 00:00:00', 'fruit/cherry.jpg|left||0\r\nfruit/peas.jpg|right||0\r\nfood/milk.jpg|left||0', '', '', 1, 0, 0, '', '', 0, 10);
INSERT INTO `jos_content` VALUES (12, 'Encadrement', 'Encadrement', '	  <p>Trois Ma&icirc;tres d&#39;Arme assurent l&#39;encadrement au LC78 Escrime :</p> 	  <p>&nbsp;</p> 	  <div align="center"> 		<p><strong><em>Ma&icirc;tre Jean-Yves HUET<br /> 		</em> 		</strong> 		  n&eacute; en 1966<br /> 		  licenci&eacute; depuis 1972<br /> 		  BE1 en juin 97<br /> 		  au LC78 depuis 2005</p> 		<p>jean-yves.huet@lc78-escrime.com  	<br /> 		  <br /> 		  <!--<img border="0" src="http://www.lc78-escrime.com/images/portraits/portrait_jean-yves.jpg" width="305" height="243">--> <img src="http://www.lc78-escrime.com/images/portraits/jy_huet.jpg" border="0" alt="" /><br /> 		</p> 		<br /><br /></div> 	  <div align="center"><strong><em>Ma&icirc;tre Renaud PLUCHET<br /> 		</em> 		</strong>n&eacute; en 1966<br /> 		</div> 	  <div align="center">licenci&eacute; depuis 1972<br /> 		BE 1 en juillet 2000<br /> 		au LC78 depuis 2003</div> 	  <div align="center">renaud.pluchet@lc78-escrime.com  	<br /> 		<br /> 			<!--<img border="0" src="http://www.lc78-escrime.com/images/portraits/renaud%201973_mini.jpg" width="160" height="239" hspace="5" align="center"><font face="Arial" size="7"><marquee width="10%" direction="right">?</marquee></font>--><img src="http://www.lc78-escrime.com/images/portraits/portrait_pluchet.JPG" border="0" alt="" hspace="10" width="218" height="321" align="middle" /><br /> 		</div><div align="center">&nbsp;</div> 	   	     <div align="center"> 		<p>&nbsp;</p><p><strong><em>Ma&icirc;tre Jean-Christophe VOISEUX</em></strong><br /> 		  n&eacute; en 1980<br /> 		  licenci&eacute; depuis 1986<br /> 		  BE 1 en juin 2007<br /> 		  au LC78 depuis 2006</p> 		<br /> 		  <br /> 		  <!--<img border="0" src="http://www.lc78-escrime.com/images/portraits/jc_voiseux.jpg" width="243" height="305">--> <img src="http://www.lc78-escrime.com/images/portraits/jc_voiseux_2.jpg" border="0" alt="" /><br /> 		<p>&nbsp;</p> 		<br /><br /><br /> 	  </div> ', '', 1, 1, 0, 1, '2007-08-16 16:58:02', 62, 'Webmaster', '2007-08-16 17:04:23', 62, 0, '0000-00-00 00:00:00', '2007-08-16 16:44:31', '0000-00-00 00:00:00', '', '', 'pageclass_sfx=\nback_button=\nitem_title=1\nlink_titles=\nintrotext=1\nsection=0\nsection_link=0\ncategory=0\ncategory_link=0\nrating=\nauthor=\ncreatedate=\nmodifydate=\npdf=\nprint=\nemail=\nkeyref=\ndocbook_type=', 3, 0, 1, '', '', 0, 3);

-- --------------------------------------------------------

-- 
-- Structure de la table `jos_content_frontpage`
-- 

DROP TABLE IF EXISTS `jos_content_frontpage`;
CREATE TABLE IF NOT EXISTS `jos_content_frontpage` (
  `content_id` int(11) NOT NULL default '0',
  `ordering` int(11) NOT NULL default '0',
  PRIMARY KEY  (`content_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- 
-- Contenu de la table `jos_content_frontpage`
-- 

INSERT INTO `jos_content_frontpage` VALUES (1, 1);
INSERT INTO `jos_content_frontpage` VALUES (2, 2);
INSERT INTO `jos_content_frontpage` VALUES (3, 3);
INSERT INTO `jos_content_frontpage` VALUES (4, 4);
INSERT INTO `jos_content_frontpage` VALUES (5, 5);

-- --------------------------------------------------------

-- 
-- Structure de la table `jos_content_rating`
-- 

DROP TABLE IF EXISTS `jos_content_rating`;
CREATE TABLE IF NOT EXISTS `jos_content_rating` (
  `content_id` int(11) NOT NULL default '0',
  `rating_sum` int(11) unsigned NOT NULL default '0',
  `rating_count` int(11) unsigned NOT NULL default '0',
  `lastip` varchar(50) NOT NULL default '',
  PRIMARY KEY  (`content_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- 
-- Contenu de la table `jos_content_rating`
-- 


-- --------------------------------------------------------

-- 
-- Structure de la table `jos_core_acl_aro`
-- 

DROP TABLE IF EXISTS `jos_core_acl_aro`;
CREATE TABLE IF NOT EXISTS `jos_core_acl_aro` (
  `aro_id` int(11) NOT NULL auto_increment,
  `section_value` varchar(240) NOT NULL default '0',
  `value` varchar(240) NOT NULL default '',
  `order_value` int(11) NOT NULL default '0',
  `name` varchar(255) NOT NULL default '',
  `hidden` int(11) NOT NULL default '0',
  PRIMARY KEY  (`aro_id`),
  UNIQUE KEY `jos_gacl_section_value_value_aro` (`section_value`(100),`value`(100)),
  KEY `jos_gacl_hidden_aro` (`hidden`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=16 ;

-- 
-- Contenu de la table `jos_core_acl_aro`
-- 

INSERT INTO `jos_core_acl_aro` VALUES (10, 'users', '62', 0, 'Administrator', 0);
INSERT INTO `jos_core_acl_aro` VALUES (11, 'users', '63', 0, 'Jean-Yves Huet', 0);
INSERT INTO `jos_core_acl_aro` VALUES (12, 'users', '64', 0, 'Renaud Pluchet', 0);
INSERT INTO `jos_core_acl_aro` VALUES (13, 'users', '65', 0, 'Jean-Christophe Voiseux', 0);
INSERT INTO `jos_core_acl_aro` VALUES (14, 'users', '66', 0, 'Thomas Raso', 0);
INSERT INTO `jos_core_acl_aro` VALUES (15, 'users', '67', 0, 'Mathieu Lehoux', 0);

-- --------------------------------------------------------

-- 
-- Structure de la table `jos_core_acl_aro_groups`
-- 

DROP TABLE IF EXISTS `jos_core_acl_aro_groups`;
CREATE TABLE IF NOT EXISTS `jos_core_acl_aro_groups` (
  `group_id` int(11) NOT NULL auto_increment,
  `parent_id` int(11) NOT NULL default '0',
  `name` varchar(255) NOT NULL default '',
  `lft` int(11) NOT NULL default '0',
  `rgt` int(11) NOT NULL default '0',
  PRIMARY KEY  (`group_id`),
  KEY `parent_id_aro_groups` (`parent_id`),
  KEY `jos_gacl_parent_id_aro_groups` (`parent_id`),
  KEY `jos_gacl_lft_rgt_aro_groups` (`lft`,`rgt`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=31 ;

-- 
-- Contenu de la table `jos_core_acl_aro_groups`
-- 

INSERT INTO `jos_core_acl_aro_groups` VALUES (17, 0, 'ROOT', 1, 22);
INSERT INTO `jos_core_acl_aro_groups` VALUES (28, 17, 'USERS', 2, 21);
INSERT INTO `jos_core_acl_aro_groups` VALUES (29, 28, 'Public Frontend', 3, 12);
INSERT INTO `jos_core_acl_aro_groups` VALUES (18, 29, 'Registered', 4, 11);
INSERT INTO `jos_core_acl_aro_groups` VALUES (19, 18, 'Author', 5, 10);
INSERT INTO `jos_core_acl_aro_groups` VALUES (20, 19, 'Editor', 6, 9);
INSERT INTO `jos_core_acl_aro_groups` VALUES (21, 20, 'Publisher', 7, 8);
INSERT INTO `jos_core_acl_aro_groups` VALUES (30, 28, 'Public Backend', 13, 20);
INSERT INTO `jos_core_acl_aro_groups` VALUES (23, 30, 'Manager', 14, 19);
INSERT INTO `jos_core_acl_aro_groups` VALUES (24, 23, 'Administrator', 15, 18);
INSERT INTO `jos_core_acl_aro_groups` VALUES (25, 24, 'Super Administrator', 16, 17);

-- --------------------------------------------------------

-- 
-- Structure de la table `jos_core_acl_aro_sections`
-- 

DROP TABLE IF EXISTS `jos_core_acl_aro_sections`;
CREATE TABLE IF NOT EXISTS `jos_core_acl_aro_sections` (
  `section_id` int(11) NOT NULL auto_increment,
  `value` varchar(230) NOT NULL default '',
  `order_value` int(11) NOT NULL default '0',
  `name` varchar(230) NOT NULL default '',
  `hidden` int(11) NOT NULL default '0',
  PRIMARY KEY  (`section_id`),
  UNIQUE KEY `value_aro_sections` (`value`),
  UNIQUE KEY `jos_gacl_value_aro_sections` (`value`),
  KEY `hidden_aro_sections` (`hidden`),
  KEY `jos_gacl_hidden_aro_sections` (`hidden`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

-- 
-- Contenu de la table `jos_core_acl_aro_sections`
-- 

INSERT INTO `jos_core_acl_aro_sections` VALUES (10, 'users', 1, 'Users', 0);

-- --------------------------------------------------------

-- 
-- Structure de la table `jos_core_acl_groups_aro_map`
-- 

DROP TABLE IF EXISTS `jos_core_acl_groups_aro_map`;
CREATE TABLE IF NOT EXISTS `jos_core_acl_groups_aro_map` (
  `group_id` int(11) NOT NULL default '0',
  `section_value` varchar(240) NOT NULL default '',
  `aro_id` int(11) NOT NULL default '0',
  UNIQUE KEY `group_id_aro_id_groups_aro_map` (`group_id`,`section_value`,`aro_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- 
-- Contenu de la table `jos_core_acl_groups_aro_map`
-- 

INSERT INTO `jos_core_acl_groups_aro_map` VALUES (19, '', 11);
INSERT INTO `jos_core_acl_groups_aro_map` VALUES (19, '', 12);
INSERT INTO `jos_core_acl_groups_aro_map` VALUES (19, '', 13);
INSERT INTO `jos_core_acl_groups_aro_map` VALUES (25, '', 10);
INSERT INTO `jos_core_acl_groups_aro_map` VALUES (25, '', 14);
INSERT INTO `jos_core_acl_groups_aro_map` VALUES (25, '', 15);

-- --------------------------------------------------------

-- 
-- Structure de la table `jos_core_log_items`
-- 

DROP TABLE IF EXISTS `jos_core_log_items`;
CREATE TABLE IF NOT EXISTS `jos_core_log_items` (
  `time_stamp` date NOT NULL default '0000-00-00',
  `item_table` varchar(50) NOT NULL default '',
  `item_id` int(11) unsigned NOT NULL default '0',
  `hits` int(11) unsigned NOT NULL default '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- 
-- Contenu de la table `jos_core_log_items`
-- 


-- --------------------------------------------------------

-- 
-- Structure de la table `jos_core_log_searches`
-- 

DROP TABLE IF EXISTS `jos_core_log_searches`;
CREATE TABLE IF NOT EXISTS `jos_core_log_searches` (
  `search_term` varchar(128) NOT NULL default '',
  `hits` int(11) unsigned NOT NULL default '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- 
-- Contenu de la table `jos_core_log_searches`
-- 


-- --------------------------------------------------------

-- 
-- Structure de la table `jos_easygb`
-- 

DROP TABLE IF EXISTS `jos_easygb`;
CREATE TABLE IF NOT EXISTS `jos_easygb` (
  `id` int(11) NOT NULL auto_increment,
  `date` datetime NOT NULL default '0000-00-00 00:00:00',
  `content` text NOT NULL,
  `name` varchar(255) NOT NULL default '',
  `email` varchar(255) NOT NULL default '',
  `homepage` varchar(255) NOT NULL default '',
  `rating` tinyint(1) NOT NULL default '0',
  `ip` varchar(15) NOT NULL default '',
  `browser` varchar(255) NOT NULL default '',
  `published` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- 
-- Contenu de la table `jos_easygb`
-- 


-- --------------------------------------------------------

-- 
-- Structure de la table `jos_easygb_captcha`
-- 

DROP TABLE IF EXISTS `jos_easygb_captcha`;
CREATE TABLE IF NOT EXISTS `jos_easygb_captcha` (
  `id` int(11) NOT NULL auto_increment,
  `code` varchar(255) NOT NULL default '',
  `generated` datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

-- 
-- Contenu de la table `jos_easygb_captcha`
-- 

INSERT INTO `jos_easygb_captcha` VALUES (4, 'bm8483', '2007-06-16 11:28:07');

-- --------------------------------------------------------

-- 
-- Structure de la table `jos_gcalendar`
-- 

DROP TABLE IF EXISTS `jos_gcalendar`;
CREATE TABLE IF NOT EXISTS `jos_gcalendar` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(100) NOT NULL default '',
  `htmlUrl` text,
  `xmlUrl` text,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

-- 
-- Contenu de la table `jos_gcalendar`
-- 


-- --------------------------------------------------------

-- 
-- Structure de la table `jos_groups`
-- 

DROP TABLE IF EXISTS `jos_groups`;
CREATE TABLE IF NOT EXISTS `jos_groups` (
  `id` tinyint(3) unsigned NOT NULL default '0',
  `name` varchar(50) NOT NULL default '',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- 
-- Contenu de la table `jos_groups`
-- 

INSERT INTO `jos_groups` VALUES (0, 'Public');
INSERT INTO `jos_groups` VALUES (1, 'Membre');
INSERT INTO `jos_groups` VALUES (2, 'Special');

-- --------------------------------------------------------

-- 
-- Structure de la table `jos_jstats_bots`
-- 

DROP TABLE IF EXISTS `jos_jstats_bots`;
CREATE TABLE IF NOT EXISTS `jos_jstats_bots` (
  `bot_id` mediumint(9) NOT NULL auto_increment,
  `bot_string` varchar(50) NOT NULL default '',
  `bot_fullname` varchar(50) NOT NULL default '',
  PRIMARY KEY  (`bot_id`),
  UNIQUE KEY `bot_string` (`bot_string`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=421 ;

-- 
-- Contenu de la table `jos_jstats_bots`
-- 

INSERT INTO `jos_jstats_bots` VALUES (1, 'acme.spider', 'Acme Spider');
INSERT INTO `jos_jstats_bots` VALUES (2, 'ahoythehomepagefinder', 'Ahoy! The Homepage Finder');
INSERT INTO `jos_jstats_bots` VALUES (3, 'alkaline', 'Alkaline');
INSERT INTO `jos_jstats_bots` VALUES (4, 'appie', 'Walhello appie');
INSERT INTO `jos_jstats_bots` VALUES (5, 'arachnophilia', 'Arachnophilia');
INSERT INTO `jos_jstats_bots` VALUES (6, 'architext', 'ArchitextSpider');
INSERT INTO `jos_jstats_bots` VALUES (7, 'aretha', 'Aretha');
INSERT INTO `jos_jstats_bots` VALUES (8, 'ariadne', 'ARIADNE');
INSERT INTO `jos_jstats_bots` VALUES (9, 'arks', 'arks');
INSERT INTO `jos_jstats_bots` VALUES (10, 'aspider', 'ASpider (Associative Spider)');
INSERT INTO `jos_jstats_bots` VALUES (11, 'atn.txt', 'ATN Worldwide');
INSERT INTO `jos_jstats_bots` VALUES (12, 'atomz', 'Atomz.com Search Robot');
INSERT INTO `jos_jstats_bots` VALUES (13, 'auresys', 'AURESYS');
INSERT INTO `jos_jstats_bots` VALUES (14, 'backrub', 'BackRub');
INSERT INTO `jos_jstats_bots` VALUES (15, 'biUKrother', 'Big Brother');
INSERT INTO `jos_jstats_bots` VALUES (16, 'bjaaland', 'Bjaaland');
INSERT INTO `jos_jstats_bots` VALUES (17, 'blackwidow', 'BlackWidow');
INSERT INTO `jos_jstats_bots` VALUES (18, 'blindekuh', 'Die Blinde Kuh');
INSERT INTO `jos_jstats_bots` VALUES (19, 'bloodhound', 'Bloodhound');
INSERT INTO `jos_jstats_bots` VALUES (20, 'brightnet', 'bright.net caching robot');
INSERT INTO `jos_jstats_bots` VALUES (21, 'bspider', 'BSpider');
INSERT INTO `jos_jstats_bots` VALUES (22, 'cactvschemistryspider', 'CACTVS Chemistry Spider');
INSERT INTO `jos_jstats_bots` VALUES (23, 'calif[^r]', 'Calif');
INSERT INTO `jos_jstats_bots` VALUES (24, 'cassandra', 'Cassandra');
INSERT INTO `jos_jstats_bots` VALUES (25, 'cgireader', 'Digimarc Marcspider/CGI');
INSERT INTO `jos_jstats_bots` VALUES (26, 'checkbot', 'Checkbot');
INSERT INTO `jos_jstats_bots` VALUES (27, 'churl', 'churl');
INSERT INTO `jos_jstats_bots` VALUES (28, 'cmc', 'CMC/0.01');
INSERT INTO `jos_jstats_bots` VALUES (29, 'collective', 'Collective');
INSERT INTO `jos_jstats_bots` VALUES (30, 'combine', 'Combine System');
INSERT INTO `jos_jstats_bots` VALUES (31, 'conceptbot', 'Conceptbot');
INSERT INTO `jos_jstats_bots` VALUES (32, 'coolbot', 'CoolBot');
INSERT INTO `jos_jstats_bots` VALUES (33, 'core', 'Web Core / Roots');
INSERT INTO `jos_jstats_bots` VALUES (34, 'cosmos', 'XYLEME Robot');
INSERT INTO `jos_jstats_bots` VALUES (35, 'cruiser', 'Internet Cruiser Robot');
INSERT INTO `jos_jstats_bots` VALUES (36, 'cusco', 'Cusco');
INSERT INTO `jos_jstats_bots` VALUES (37, 'cyberspyder', 'CyberSpyder Link Test');
INSERT INTO `jos_jstats_bots` VALUES (38, 'deweb', 'DeWeb(c) Katalog/Index');
INSERT INTO `jos_jstats_bots` VALUES (39, 'dienstspider', 'DienstSpider');
INSERT INTO `jos_jstats_bots` VALUES (40, 'digger', 'Digger');
INSERT INTO `jos_jstats_bots` VALUES (41, 'diibot', 'Digital Integrity Robot');
INSERT INTO `jos_jstats_bots` VALUES (42, 'directhit', 'Direct Hit Grabber');
INSERT INTO `jos_jstats_bots` VALUES (43, 'dnabot', 'DNAbot');
INSERT INTO `jos_jstats_bots` VALUES (44, 'download_express', 'DownLoad Express');
INSERT INTO `jos_jstats_bots` VALUES (45, 'dragonbot', 'DragonBot');
INSERT INTO `jos_jstats_bots` VALUES (46, 'dwcp', 'DWCP (Dridus Web Cataloging Project)');
INSERT INTO `jos_jstats_bots` VALUES (47, 'e-collector', 'e-collector');
INSERT INTO `jos_jstats_bots` VALUES (48, 'ebiness', 'EbiNess');
INSERT INTO `jos_jstats_bots` VALUES (49, 'eit', 'EIT Link Verifier Robot');
INSERT INTO `jos_jstats_bots` VALUES (50, 'elfinbot', 'ELFINBOT');
INSERT INTO `jos_jstats_bots` VALUES (51, 'emacs', 'Emacs-w3 Search Engine');
INSERT INTO `jos_jstats_bots` VALUES (52, 'emcspider', 'ananzi');
INSERT INTO `jos_jstats_bots` VALUES (53, 'esther', 'Esther');
INSERT INTO `jos_jstats_bots` VALUES (54, 'evliyacelebi', 'Evliya Celebi');
INSERT INTO `jos_jstats_bots` VALUES (55, 'nzexplorer', 'nzexplorer');
INSERT INTO `jos_jstats_bots` VALUES (56, 'fdse', 'Fluid Dynamics Search Engine robot');
INSERT INTO `jos_jstats_bots` VALUES (57, 'felix', 'Felix IDE');
INSERT INTO `jos_jstats_bots` VALUES (58, 'ferret', 'Wild Ferret Web Hopper #1, #2, #3');
INSERT INTO `jos_jstats_bots` VALUES (59, 'fetchrover', 'FetchRover');
INSERT INTO `jos_jstats_bots` VALUES (60, 'fido', 'fido');
INSERT INTO `jos_jstats_bots` VALUES (61, 'finnish', 'Hämähäkki');
INSERT INTO `jos_jstats_bots` VALUES (62, 'fireball', 'KIT-Fireball');
INSERT INTO `jos_jstats_bots` VALUES (63, '[^a]fish', 'Fish search');
INSERT INTO `jos_jstats_bots` VALUES (64, 'fouineur', 'Fouineur');
INSERT INTO `jos_jstats_bots` VALUES (65, 'francoroute', 'Robot Francoroute');
INSERT INTO `jos_jstats_bots` VALUES (66, 'freecrawl', 'Freecrawl');
INSERT INTO `jos_jstats_bots` VALUES (67, 'funnelweb', 'FunnelWeb');
INSERT INTO `jos_jstats_bots` VALUES (68, 'gama', 'gammaSpider, FocusedCrawler');
INSERT INTO `jos_jstats_bots` VALUES (69, 'gazz', 'gazz');
INSERT INTO `jos_jstats_bots` VALUES (70, 'gcreep', 'GCreep');
INSERT INTO `jos_jstats_bots` VALUES (71, 'getbot', 'GetBot');
INSERT INTO `jos_jstats_bots` VALUES (72, 'geturl', 'GetURL');
INSERT INTO `jos_jstats_bots` VALUES (73, 'golem', 'Golem');
INSERT INTO `jos_jstats_bots` VALUES (74, 'googlebot', 'Googlebot (Google)');
INSERT INTO `jos_jstats_bots` VALUES (75, 'grapnel', 'Grapnel/0.01 Experiment');
INSERT INTO `jos_jstats_bots` VALUES (76, 'griffon', 'Griffon');
INSERT INTO `jos_jstats_bots` VALUES (77, 'gromit', 'Gromit');
INSERT INTO `jos_jstats_bots` VALUES (78, 'gulliver', 'Northern Light Gulliver');
INSERT INTO `jos_jstats_bots` VALUES (79, 'hambot', 'HamBot');
INSERT INTO `jos_jstats_bots` VALUES (80, 'harvest', 'Harvest');
INSERT INTO `jos_jstats_bots` VALUES (81, 'havindex', 'havIndex');
INSERT INTO `jos_jstats_bots` VALUES (82, 'hometown', 'Hometown Spider Pro');
INSERT INTO `jos_jstats_bots` VALUES (83, 'htdig', 'ht://Dig');
INSERT INTO `jos_jstats_bots` VALUES (84, 'htmlgobble', 'HTMLgobble');
INSERT INTO `jos_jstats_bots` VALUES (85, 'hyperdecontextualizer', 'Hyper-Decontextualizer');
INSERT INTO `jos_jstats_bots` VALUES (86, 'iajabot', 'iajaBot');
INSERT INTO `jos_jstats_bots` VALUES (87, 'ibm', 'IBM_Planetwide');
INSERT INTO `jos_jstats_bots` VALUES (88, 'iconoclast', 'Popular Iconoclast');
INSERT INTO `jos_jstats_bots` VALUES (89, 'ilse', 'Ingrid');
INSERT INTO `jos_jstats_bots` VALUES (90, 'imagelock', 'Imagelock');
INSERT INTO `jos_jstats_bots` VALUES (91, 'incywincy', 'IncyWincy');
INSERT INTO `jos_jstats_bots` VALUES (92, 'informant', 'Informant');
INSERT INTO `jos_jstats_bots` VALUES (93, 'infoseek', 'InfoSeek Robot 1.0');
INSERT INTO `jos_jstats_bots` VALUES (94, 'infoseeksidewinder', 'Infoseek Sidewinder');
INSERT INTO `jos_jstats_bots` VALUES (95, 'infospider', 'InfoSpiders');
INSERT INTO `jos_jstats_bots` VALUES (96, 'inspectorwww', 'Inspector Web');
INSERT INTO `jos_jstats_bots` VALUES (97, 'intelliagent', 'IntelliAgent');
INSERT INTO `jos_jstats_bots` VALUES (98, 'irobot', 'I, Robot');
INSERT INTO `jos_jstats_bots` VALUES (99, 'iron33', 'Iron33');
INSERT INTO `jos_jstats_bots` VALUES (100, 'israelisearch', 'Israeli-search');
INSERT INTO `jos_jstats_bots` VALUES (101, 'javabee', 'JavaBee');
INSERT INTO `jos_jstats_bots` VALUES (102, 'jbot', 'JBot Java Web Robot');
INSERT INTO `jos_jstats_bots` VALUES (103, 'jcrawler', 'JCrawler');
INSERT INTO `jos_jstats_bots` VALUES (104, 'jeeves', 'Jeeves');
INSERT INTO `jos_jstats_bots` VALUES (105, 'jobo', 'JoBo Java Web Robot');
INSERT INTO `jos_jstats_bots` VALUES (106, 'jobot', 'Jobot');
INSERT INTO `jos_jstats_bots` VALUES (107, 'joebot', 'JoeBot');
INSERT INTO `jos_jstats_bots` VALUES (108, 'jubii', 'The Jubii Indexing Robot');
INSERT INTO `jos_jstats_bots` VALUES (109, 'jumpstation', 'JumpStation');
INSERT INTO `jos_jstats_bots` VALUES (110, 'katipo', 'Katipo');
INSERT INTO `jos_jstats_bots` VALUES (111, 'kdd', 'KDD-Explorer');
INSERT INTO `jos_jstats_bots` VALUES (112, 'kilroy', 'Kilroy');
INSERT INTO `jos_jstats_bots` VALUES (113, 'ko_yappo_robot', 'KO_Yappo_Robot');
INSERT INTO `jos_jstats_bots` VALUES (114, 'labelgrabber.txt', 'LabelGrabber');
INSERT INTO `jos_jstats_bots` VALUES (115, 'larbin', 'larbin');
INSERT INTO `jos_jstats_bots` VALUES (116, 'legs', 'legs');
INSERT INTO `jos_jstats_bots` VALUES (117, 'linkidator', 'Link Validator');
INSERT INTO `jos_jstats_bots` VALUES (118, 'linkscan', 'LinkScan');
INSERT INTO `jos_jstats_bots` VALUES (119, 'linkwalker', 'LinkWalker');
INSERT INTO `jos_jstats_bots` VALUES (120, 'lockon', 'Lockon');
INSERT INTO `jos_jstats_bots` VALUES (121, 'logo_gif', 'logo.gif Crawler');
INSERT INTO `jos_jstats_bots` VALUES (122, 'lycos', 'Lycos');
INSERT INTO `jos_jstats_bots` VALUES (123, 'macworm', 'Mac WWWWorm');
INSERT INTO `jos_jstats_bots` VALUES (124, 'magpie', 'Magpie');
INSERT INTO `jos_jstats_bots` VALUES (125, 'marvin', 'marvin/infoseek');
INSERT INTO `jos_jstats_bots` VALUES (126, 'mattie', 'Mattie');
INSERT INTO `jos_jstats_bots` VALUES (127, 'mediafox', 'MediaFox');
INSERT INTO `jos_jstats_bots` VALUES (128, 'merzscope', 'MerzScope');
INSERT INTO `jos_jstats_bots` VALUES (129, 'meshexplorer', 'NEC-MeshExplorer');
INSERT INTO `jos_jstats_bots` VALUES (130, 'mindcrawler', 'MindCrawler');
INSERT INTO `jos_jstats_bots` VALUES (131, 'moget', 'moget');
INSERT INTO `jos_jstats_bots` VALUES (132, 'momspider', 'MOMspider');
INSERT INTO `jos_jstats_bots` VALUES (133, 'monster', 'Monster');
INSERT INTO `jos_jstats_bots` VALUES (134, 'motor', 'Motor');
INSERT INTO `jos_jstats_bots` VALUES (135, 'muscatferret', 'Muscat Ferret');
INSERT INTO `jos_jstats_bots` VALUES (136, 'mwdsearch', 'Mwd.Search');
INSERT INTO `jos_jstats_bots` VALUES (137, 'myweb', 'Internet Shinchakubin');
INSERT INTO `jos_jstats_bots` VALUES (138, 'netcarta', 'NetCarta WebMap Engine');
INSERT INTO `jos_jstats_bots` VALUES (139, 'netcraft', 'Netcraft Web Server Survey');
INSERT INTO `jos_jstats_bots` VALUES (140, 'netmechanic', 'NetMechanic');
INSERT INTO `jos_jstats_bots` VALUES (141, 'netscoop', 'NetScoop');
INSERT INTO `jos_jstats_bots` VALUES (142, 'newscan-online', 'newscan-online');
INSERT INTO `jos_jstats_bots` VALUES (143, 'nhse', 'NHSE Web Forager');
INSERT INTO `jos_jstats_bots` VALUES (144, 'nomad', 'Nomad');
INSERT INTO `jos_jstats_bots` VALUES (145, 'northstar', 'The NorthStar Robot');
INSERT INTO `jos_jstats_bots` VALUES (146, 'occam', 'Occam');
INSERT INTO `jos_jstats_bots` VALUES (147, 'octopus', 'HKU WWW Octopus');
INSERT INTO `jos_jstats_bots` VALUES (148, 'openfind', 'Openfind data gatherer');
INSERT INTO `jos_jstats_bots` VALUES (149, 'orb_search', 'Orb Search');
INSERT INTO `jos_jstats_bots` VALUES (150, 'packrat', 'Pack Rat');
INSERT INTO `jos_jstats_bots` VALUES (151, 'pageboy', 'PageBoy');
INSERT INTO `jos_jstats_bots` VALUES (152, 'parasite', 'ParaSite');
INSERT INTO `jos_jstats_bots` VALUES (153, 'patric', 'Patric');
INSERT INTO `jos_jstats_bots` VALUES (154, 'pegasus', 'pegasus');
INSERT INTO `jos_jstats_bots` VALUES (155, 'perignator', 'The Peregrinator');
INSERT INTO `jos_jstats_bots` VALUES (156, 'perlcrawler', 'PerlCrawler 1.0');
INSERT INTO `jos_jstats_bots` VALUES (157, 'phantom', 'Phantom');
INSERT INTO `jos_jstats_bots` VALUES (158, 'piltdownman', 'PiltdownMan');
INSERT INTO `jos_jstats_bots` VALUES (159, 'pimptrain', 'Pimptrain.com''s robot');
INSERT INTO `jos_jstats_bots` VALUES (160, 'pioneer', 'Pioneer');
INSERT INTO `jos_jstats_bots` VALUES (161, 'pitkow', 'html_analyzer');
INSERT INTO `jos_jstats_bots` VALUES (162, 'pjspider', 'Portal Juice Spider');
INSERT INTO `jos_jstats_bots` VALUES (163, 'pka', 'PGP Key Agent');
INSERT INTO `jos_jstats_bots` VALUES (164, 'plumtreewebaccessor', 'PlumtreeWebAccessor');
INSERT INTO `jos_jstats_bots` VALUES (165, 'poppi', 'Poppi');
INSERT INTO `jos_jstats_bots` VALUES (166, 'portalb', 'PortalB Spider');
INSERT INTO `jos_jstats_bots` VALUES (167, 'puu', 'GetterroboPlus Puu');
INSERT INTO `jos_jstats_bots` VALUES (168, 'python', 'The Python Robot');
INSERT INTO `jos_jstats_bots` VALUES (169, 'raven', 'Raven Search');
INSERT INTO `jos_jstats_bots` VALUES (170, 'rbse', 'RBSE Spider');
INSERT INTO `jos_jstats_bots` VALUES (171, 'resumerobot', 'Resume Robot');
INSERT INTO `jos_jstats_bots` VALUES (172, 'rhcs', 'RoadHouse Crawling System');
INSERT INTO `jos_jstats_bots` VALUES (173, 'roadrunner', 'Road Runner: The ImageScape Robot');
INSERT INTO `jos_jstats_bots` VALUES (174, 'robbie', 'Robbie the Robot');
INSERT INTO `jos_jstats_bots` VALUES (175, 'robi', 'ComputingSite Robi/1.0');
INSERT INTO `jos_jstats_bots` VALUES (176, 'robofox', 'RoboFox');
INSERT INTO `jos_jstats_bots` VALUES (177, 'robozilla', 'Robozilla');
INSERT INTO `jos_jstats_bots` VALUES (178, 'roverbot', 'Roverbot');
INSERT INTO `jos_jstats_bots` VALUES (179, 'rules', 'RuLeS');
INSERT INTO `jos_jstats_bots` VALUES (180, 'safetynetrobot', 'SafetyNet Robot');
INSERT INTO `jos_jstats_bots` VALUES (181, 'scooter', 'Scooter (AltaVista)');
INSERT INTO `jos_jstats_bots` VALUES (182, 'search_au', 'Search.Aus-AU.COM');
INSERT INTO `jos_jstats_bots` VALUES (183, 'searchprocess', 'SearchProcess');
INSERT INTO `jos_jstats_bots` VALUES (184, 'senrigan', 'Senrigan');
INSERT INTO `jos_jstats_bots` VALUES (185, 'sgscout', 'SG-Scout');
INSERT INTO `jos_jstats_bots` VALUES (186, 'shaggy', 'ShagSeeker');
INSERT INTO `jos_jstats_bots` VALUES (187, 'shaihulud', 'Shai''Hulud');
INSERT INTO `jos_jstats_bots` VALUES (188, 'sift', 'Sift');
INSERT INTO `jos_jstats_bots` VALUES (189, 'simbot', 'Simmany Robot Ver1.0');
INSERT INTO `jos_jstats_bots` VALUES (190, 'site-valet', 'Site Valet');
INSERT INTO `jos_jstats_bots` VALUES (191, 'sitegrabber', 'Open Text Index Robot');
INSERT INTO `jos_jstats_bots` VALUES (192, 'sitetech', 'SiteTech-Rover');
INSERT INTO `jos_jstats_bots` VALUES (193, 'slcrawler', 'SLCrawler');
INSERT INTO `jos_jstats_bots` VALUES (194, 'slurp', 'Inktomi Slurp');
INSERT INTO `jos_jstats_bots` VALUES (195, 'smartspider', 'Smart Spider');
INSERT INTO `jos_jstats_bots` VALUES (196, 'snooper', 'Snooper');
INSERT INTO `jos_jstats_bots` VALUES (197, 'solbot', 'Solbot');
INSERT INTO `jos_jstats_bots` VALUES (198, 'spanner', 'Spanner');
INSERT INTO `jos_jstats_bots` VALUES (199, 'speedy', 'Speedy Spider');
INSERT INTO `jos_jstats_bots` VALUES (200, 'spider_monkey', 'spider_monkey');
INSERT INTO `jos_jstats_bots` VALUES (201, 'spiderbot', 'SpiderBot');
INSERT INTO `jos_jstats_bots` VALUES (202, 'spiderline', 'Spiderline Crawler');
INSERT INTO `jos_jstats_bots` VALUES (203, 'spiderman', 'SpiderMan');
INSERT INTO `jos_jstats_bots` VALUES (204, 'spiderview', 'SpiderView(tm)');
INSERT INTO `jos_jstats_bots` VALUES (205, 'spry', 'Spry Wizard Robot');
INSERT INTO `jos_jstats_bots` VALUES (206, 'ssearcher', 'Site Searcher');
INSERT INTO `jos_jstats_bots` VALUES (207, 'suke', 'Suke');
INSERT INTO `jos_jstats_bots` VALUES (208, 'suntek', 'suntek search engine');
INSERT INTO `jos_jstats_bots` VALUES (209, 'sven', 'Sven');
INSERT INTO `jos_jstats_bots` VALUES (210, 'tach_bw', 'TACH Black Widow');
INSERT INTO `jos_jstats_bots` VALUES (211, 'tarantula', 'Tarantula');
INSERT INTO `jos_jstats_bots` VALUES (212, 'tarspider', 'tarspider');
INSERT INTO `jos_jstats_bots` VALUES (213, 'techbot', 'TechBOT');
INSERT INTO `jos_jstats_bots` VALUES (214, 'templeton', 'Templeton');
INSERT INTO `jos_jstats_bots` VALUES (215, 'teoma_agent1', 'TeomaTechnologies');
INSERT INTO `jos_jstats_bots` VALUES (216, 'titin', 'TitIn');
INSERT INTO `jos_jstats_bots` VALUES (217, 'titan', 'TITAN');
INSERT INTO `jos_jstats_bots` VALUES (218, 'tkwww', 'The TkWWW Robot');
INSERT INTO `jos_jstats_bots` VALUES (219, 'tlspider', 'TLSpider');
INSERT INTO `jos_jstats_bots` VALUES (220, 'ucsd', 'UCSD Crawl');
INSERT INTO `jos_jstats_bots` VALUES (221, 'udmsearch', 'UdmSearch');
INSERT INTO `jos_jstats_bots` VALUES (222, 'urlck', 'URL Check');
INSERT INTO `jos_jstats_bots` VALUES (223, 'valkyrie', 'Valkyrie');
INSERT INTO `jos_jstats_bots` VALUES (224, 'victoria', 'Victoria');
INSERT INTO `jos_jstats_bots` VALUES (225, 'visionsearch', 'vision-search');
INSERT INTO `jos_jstats_bots` VALUES (226, 'voyager', 'Voyager');
INSERT INTO `jos_jstats_bots` VALUES (227, 'vwbot', 'VWbot');
INSERT INTO `jos_jstats_bots` VALUES (228, 'w3index', 'The NWI Robot');
INSERT INTO `jos_jstats_bots` VALUES (229, 'w3m2', 'W3M2');
INSERT INTO `jos_jstats_bots` VALUES (230, 'wallpaper', 'WallPaper');
INSERT INTO `jos_jstats_bots` VALUES (231, 'wanderer', 'the World Wide Web Wanderer');
INSERT INTO `jos_jstats_bots` VALUES (232, 'wapspider', 'w@pSpider by wap4.com');
INSERT INTO `jos_jstats_bots` VALUES (233, 'webbandit', 'WebBandit Web Spider');
INSERT INTO `jos_jstats_bots` VALUES (234, 'webcatcher', 'WebCatcher');
INSERT INTO `jos_jstats_bots` VALUES (235, 'webcopy', 'WebCopy');
INSERT INTO `jos_jstats_bots` VALUES (236, 'webfetcher', 'Webfetcher');
INSERT INTO `jos_jstats_bots` VALUES (237, 'webfoot', 'The Webfoot Robot');
INSERT INTO `jos_jstats_bots` VALUES (238, 'weblayers', 'Weblayers');
INSERT INTO `jos_jstats_bots` VALUES (239, 'weblinker', 'WebLinker');
INSERT INTO `jos_jstats_bots` VALUES (240, 'webmirror', 'WebMirror');
INSERT INTO `jos_jstats_bots` VALUES (241, 'webmoose', 'The Web Moose');
INSERT INTO `jos_jstats_bots` VALUES (242, 'webquest', 'WebQuest');
INSERT INTO `jos_jstats_bots` VALUES (243, 'webreader', 'Digimarc MarcSpider');
INSERT INTO `jos_jstats_bots` VALUES (244, 'webreaper', 'WebReaper');
INSERT INTO `jos_jstats_bots` VALUES (245, 'websnarf', 'Websnarf');
INSERT INTO `jos_jstats_bots` VALUES (246, 'webspider', 'WebSpider');
INSERT INTO `jos_jstats_bots` VALUES (247, 'webvac', 'WebVac');
INSERT INTO `jos_jstats_bots` VALUES (248, 'webwalk', 'webwalk');
INSERT INTO `jos_jstats_bots` VALUES (249, 'webwalker', 'WebWalker');
INSERT INTO `jos_jstats_bots` VALUES (250, 'webwatch', 'WebWatch');
INSERT INTO `jos_jstats_bots` VALUES (251, 'wget', 'Wget');
INSERT INTO `jos_jstats_bots` VALUES (252, 'whatuseek', 'whatUseek Winona');
INSERT INTO `jos_jstats_bots` VALUES (253, 'whowhere', 'WhoWhere Robot');
INSERT INTO `jos_jstats_bots` VALUES (254, 'wired-digital', 'Wired Digital');
INSERT INTO `jos_jstats_bots` VALUES (255, 'wmir', 'w3mir');
INSERT INTO `jos_jstats_bots` VALUES (256, 'wolp', 'WebStolperer');
INSERT INTO `jos_jstats_bots` VALUES (257, 'wombat', 'The Web Wombat');
INSERT INTO `jos_jstats_bots` VALUES (258, 'worm', 'The World Wide Web Worm');
INSERT INTO `jos_jstats_bots` VALUES (259, 'wwwc', 'WWWC Ver 0.2.5');
INSERT INTO `jos_jstats_bots` VALUES (260, 'wz101', 'WebZinger');
INSERT INTO `jos_jstats_bots` VALUES (261, 'xget', 'XGET');
INSERT INTO `jos_jstats_bots` VALUES (262, 'nederland.zoek', 'Nederland.zoek');
INSERT INTO `jos_jstats_bots` VALUES (263, 'antibot', 'Antibot');
INSERT INTO `jos_jstats_bots` VALUES (264, 'awbot', 'AWBot');
INSERT INTO `jos_jstats_bots` VALUES (265, 'baiduspider', 'BaiDuSpider');
INSERT INTO `jos_jstats_bots` VALUES (266, 'bobby', 'Bobby');
INSERT INTO `jos_jstats_bots` VALUES (267, 'boris', 'Boris');
INSERT INTO `jos_jstats_bots` VALUES (268, 'bumblebee', 'Bumblebee (relevare.com)');
INSERT INTO `jos_jstats_bots` VALUES (269, 'cscrawler', 'CsCrawler');
INSERT INTO `jos_jstats_bots` VALUES (270, 'daviesbot', 'DaviesBot');
INSERT INTO `jos_jstats_bots` VALUES (271, 'digout4u', 'Digout4u');
INSERT INTO `jos_jstats_bots` VALUES (272, 'echo', 'EchO!');
INSERT INTO `jos_jstats_bots` VALUES (273, 'exactseek', 'ExactSeek Crawler');
INSERT INTO `jos_jstats_bots` VALUES (274, 'ezresult', 'Ezresult');
INSERT INTO `jos_jstats_bots` VALUES (275, 'fast-webcrawler', 'Fast-Webcrawler (AllTheWeb)');
INSERT INTO `jos_jstats_bots` VALUES (276, 'gigabot', 'GigaBot');
INSERT INTO `jos_jstats_bots` VALUES (277, 'gnodspider', 'GNOD Spider');
INSERT INTO `jos_jstats_bots` VALUES (278, 'ia_archiver', 'Alexa (IA Archiver)');
INSERT INTO `jos_jstats_bots` VALUES (279, 'internetseer', 'InternetSeer');
INSERT INTO `jos_jstats_bots` VALUES (280, 'jennybot', 'JennyBot');
INSERT INTO `jos_jstats_bots` VALUES (281, 'justview', 'JustView');
INSERT INTO `jos_jstats_bots` VALUES (282, 'linkbot', 'LinkBot');
INSERT INTO `jos_jstats_bots` VALUES (283, 'linkchecker', 'LinkChecker');
INSERT INTO `jos_jstats_bots` VALUES (284, 'mercator', 'Mercator');
INSERT INTO `jos_jstats_bots` VALUES (285, 'msiecrawler', 'MSIECrawler');
INSERT INTO `jos_jstats_bots` VALUES (286, 'perman', 'Perman surfer');
INSERT INTO `jos_jstats_bots` VALUES (287, 'petersnews', 'Petersnews');
INSERT INTO `jos_jstats_bots` VALUES (288, 'pompos', 'Pompos');
INSERT INTO `jos_jstats_bots` VALUES (289, 'psbot', 'psBot');
INSERT INTO `jos_jstats_bots` VALUES (290, 'redalert', 'Red Alert');
INSERT INTO `jos_jstats_bots` VALUES (291, 'shoutcast', 'Shoutcast Directory Service');
INSERT INTO `jos_jstats_bots` VALUES (292, 'slysearch', 'SlySearch');
INSERT INTO `jos_jstats_bots` VALUES (293, 'turnitinbot', 'Turn It In');
INSERT INTO `jos_jstats_bots` VALUES (294, 'ultraseek', 'Ultraseek');
INSERT INTO `jos_jstats_bots` VALUES (295, 'unlost_web_crawler', 'Unlost Web Crawler');
INSERT INTO `jos_jstats_bots` VALUES (296, 'voila', 'Voila');
INSERT INTO `jos_jstats_bots` VALUES (297, 'webbase', 'WebBase');
INSERT INTO `jos_jstats_bots` VALUES (298, 'webcompass', 'webcompass');
INSERT INTO `jos_jstats_bots` VALUES (299, 'wisenutbot', 'WISENutbot (Looksmart)');
INSERT INTO `jos_jstats_bots` VALUES (300, 'yandex', 'Yandex bot');
INSERT INTO `jos_jstats_bots` VALUES (301, 'zyborg', 'Zyborg (Looksmart)');
INSERT INTO `jos_jstats_bots` VALUES (308, 'mixcat', 'morris - mixcat crawler');
INSERT INTO `jos_jstats_bots` VALUES (305, 'netresearchserver', 'Net Research Server');
INSERT INTO `jos_jstats_bots` VALUES (306, 'vagabondo', 'vagabondo (test version WiseGuys webagent)');
INSERT INTO `jos_jstats_bots` VALUES (307, 'szukacz', 'Szukacz crawler');
INSERT INTO `jos_jstats_bots` VALUES (309, 'grub-client', 'Grub''s distributed crawler');
INSERT INTO `jos_jstats_bots` VALUES (310, 'fluffy', 'fluffy (searchhippo)');
INSERT INTO `jos_jstats_bots` VALUES (311, 'webtrends link analyzer', 'webtrends link analyzer');
INSERT INTO `jos_jstats_bots` VALUES (312, 'naverrobot', 'naver');
INSERT INTO `jos_jstats_bots` VALUES (313, 'steeler', 'steeler');
INSERT INTO `jos_jstats_bots` VALUES (314, 'bordermanager', 'bordermanager');
INSERT INTO `jos_jstats_bots` VALUES (315, 'nutch', 'Nutch');
INSERT INTO `jos_jstats_bots` VALUES (316, 'teradex', 'Teradex');
INSERT INTO `jos_jstats_bots` VALUES (317, 'deepindex', 'DeepIndex');
INSERT INTO `jos_jstats_bots` VALUES (318, 'npbot', 'NPBot');
INSERT INTO `jos_jstats_bots` VALUES (319, 'webcraftboot', 'Webcraftboot');
INSERT INTO `jos_jstats_bots` VALUES (320, 'franklin locator', 'Franklin locator');
INSERT INTO `jos_jstats_bots` VALUES (321, 'internet ninja', 'Internet ninja');
INSERT INTO `jos_jstats_bots` VALUES (322, 'space bison', 'Space bison');
INSERT INTO `jos_jstats_bots` VALUES (323, 'gornker', 'gornker crawler');
INSERT INTO `jos_jstats_bots` VALUES (324, 'gaisbot', 'Gaisbot');
INSERT INTO `jos_jstats_bots` VALUES (325, 'cj spider', 'CJ spider');
INSERT INTO `jos_jstats_bots` VALUES (326, 'semanticdiscovery', 'Semantic Discovery');
INSERT INTO `jos_jstats_bots` VALUES (327, 'zao', 'Zao');
INSERT INTO `jos_jstats_bots` VALUES (328, 'web downloader', 'Web Downloader');
INSERT INTO `jos_jstats_bots` VALUES (329, 'webstripper', 'Webstripper');
INSERT INTO `jos_jstats_bots` VALUES (330, 'zeus', 'Zeus');
INSERT INTO `jos_jstats_bots` VALUES (331, 'webrace', 'Webrace');
INSERT INTO `jos_jstats_bots` VALUES (332, 'christcrawler', 'ChristCENTRAL');
INSERT INTO `jos_jstats_bots` VALUES (333, 'webfilter', 'Webfilter');
INSERT INTO `jos_jstats_bots` VALUES (334, 'webgather', 'Webgather');
INSERT INTO `jos_jstats_bots` VALUES (335, 'surveybot', 'Surveybot');
INSERT INTO `jos_jstats_bots` VALUES (336, 'nitle blog spider', 'Nitle Blog Spider');
INSERT INTO `jos_jstats_bots` VALUES (337, 'galaxybot', 'Galaxybot');
INSERT INTO `jos_jstats_bots` VALUES (338, 'fangcrawl', 'FangCrawl');
INSERT INTO `jos_jstats_bots` VALUES (339, 'searchspider', 'SearchSpider');
INSERT INTO `jos_jstats_bots` VALUES (340, 'msnbot', 'msnbot');
INSERT INTO `jos_jstats_bots` VALUES (341, 'computer_and_automation_research_institute_crawler', 'computer and automation research institute crawler');
INSERT INTO `jos_jstats_bots` VALUES (342, 'overture-webcrawler', 'overture-webcrawler');
INSERT INTO `jos_jstats_bots` VALUES (343, 'exalead ng', 'exalead ng');
INSERT INTO `jos_jstats_bots` VALUES (344, 'denmex websearch', 'denmex websearch');
INSERT INTO `jos_jstats_bots` VALUES (345, 'linkfilter.net url verifier', 'linkfilter.net url verifier');
INSERT INTO `jos_jstats_bots` VALUES (346, 'mac finder', 'mac finder');
INSERT INTO `jos_jstats_bots` VALUES (347, 'polybot', 'polybot');
INSERT INTO `jos_jstats_bots` VALUES (348, 'quepasacreep', 'quepasacreep');
INSERT INTO `jos_jstats_bots` VALUES (349, 'xenu link sleuth', 'xenu link sleuth');
INSERT INTO `jos_jstats_bots` VALUES (350, 'hatena antenna', 'hatena antenna');
INSERT INTO `jos_jstats_bots` VALUES (351, 'timbobot', 'timbobot');
INSERT INTO `jos_jstats_bots` VALUES (352, 'waypath scout', 'waypath scout');
INSERT INTO `jos_jstats_bots` VALUES (353, 'technoratibot', 'technoratibot');
INSERT INTO `jos_jstats_bots` VALUES (354, 'frontier', 'frontier');
INSERT INTO `jos_jstats_bots` VALUES (355, 'blogosphere', 'blogosphere');
INSERT INTO `jos_jstats_bots` VALUES (356, 'my little bot', 'my little bot');
INSERT INTO `jos_jstats_bots` VALUES (357, 'illinois state tech labs', 'illinois state tech labs');
INSERT INTO `jos_jstats_bots` VALUES (358, 'splatsearch.com', 'splatsearch');
INSERT INTO `jos_jstats_bots` VALUES (359, 'blogshares bot', 'blogshares bot');
INSERT INTO `jos_jstats_bots` VALUES (360, 'fastbuzz.com', 'fastbuzz');
INSERT INTO `jos_jstats_bots` VALUES (361, 'obidos-bot', 'obidos');
INSERT INTO `jos_jstats_bots` VALUES (362, 'blogwise.com-metachecker', 'blogwise.com metachecker');
INSERT INTO `jos_jstats_bots` VALUES (363, 'bravobrian bstop', 'bravobrian bstop');
INSERT INTO `jos_jstats_bots` VALUES (364, 'feedster crawler', 'feedster');
INSERT INTO `jos_jstats_bots` VALUES (365, 'isspider', 'blogpulse');
INSERT INTO `jos_jstats_bots` VALUES (366, 'syndic8', 'syndic8');
INSERT INTO `jos_jstats_bots` VALUES (367, 'blogvisioneye', 'blogvisioneye');
INSERT INTO `jos_jstats_bots` VALUES (368, 'downes/referrers', 'downes/referrers');
INSERT INTO `jos_jstats_bots` VALUES (369, 'naverbot', 'naverbot');
INSERT INTO `jos_jstats_bots` VALUES (370, 'soziopath', 'soziopath');
INSERT INTO `jos_jstats_bots` VALUES (371, 'nextopiabot', 'nextopiabot');
INSERT INTO `jos_jstats_bots` VALUES (372, 'ingrid', 'ingrid');
INSERT INTO `jos_jstats_bots` VALUES (373, 'vspider', 'vspider');
INSERT INTO `jos_jstats_bots` VALUES (374, 'yahoo', 'Yahoo');
INSERT INTO `jos_jstats_bots` VALUES (375, 'sherlock-spider', 'Sherlock Spider');
INSERT INTO `jos_jstats_bots` VALUES (376, 'mercubot', 'Mercubot');
INSERT INTO `jos_jstats_bots` VALUES (377, 'mediapartners-google', 'Mediapartners Google');
INSERT INTO `jos_jstats_bots` VALUES (378, 'jetbot', 'JetBot');
INSERT INTO `jos_jstats_bots` VALUES (379, 'faxobot', 'FaxoBot');
INSERT INTO `jos_jstats_bots` VALUES (380, 'cosmixcrawler', 'cosmix crawler');
INSERT INTO `jos_jstats_bots` VALUES (381, 'exabot', 'exabot');
INSERT INTO `jos_jstats_bots` VALUES (382, 'sitespider', 'sitespider');
INSERT INTO `jos_jstats_bots` VALUES (383, 'pipeliner', 'pipeliner');
INSERT INTO `jos_jstats_bots` VALUES (384, 'ccgcrawl', 'ccgcrawl');
INSERT INTO `jos_jstats_bots` VALUES (385, 'cydralspider', 'cydralspider');
INSERT INTO `jos_jstats_bots` VALUES (386, 'crawlconvera', 'crawlconvera');
INSERT INTO `jos_jstats_bots` VALUES (387, 'blogwatcher', 'blogwatcher');
INSERT INTO `jos_jstats_bots` VALUES (388, 'mozdex', 'mozdex');
INSERT INTO `jos_jstats_bots` VALUES (389, 'aleksika spider', 'aleksika spider');
INSERT INTO `jos_jstats_bots` VALUES (390, 'e-societyrobot', 'e-societyrobot');
INSERT INTO `jos_jstats_bots` VALUES (391, 'enterprise_search', 'enterprise search');
INSERT INTO `jos_jstats_bots` VALUES (392, 'seekbot', 'seekbot');
INSERT INTO `jos_jstats_bots` VALUES (393, 'emeraldshield', 'emeraldshield');
INSERT INTO `jos_jstats_bots` VALUES (394, 'mj12bot', 'mj12bot');
INSERT INTO `jos_jstats_bots` VALUES (395, 'aipbot', 'aipbot');
INSERT INTO `jos_jstats_bots` VALUES (396, 'omniexplorer_bot', 'omniexplorer_bot');
INSERT INTO `jos_jstats_bots` VALUES (397, 'shim-crawler', 'shim-crawler');
INSERT INTO `jos_jstats_bots` VALUES (398, 'nimblecrawler', 'nimblecrawler');
INSERT INTO `jos_jstats_bots` VALUES (399, 'msrbot', 'msrbot');
INSERT INTO `jos_jstats_bots` VALUES (400, 'scirus', 'scirus');
INSERT INTO `jos_jstats_bots` VALUES (401, 'geniebot', 'geniebot');
INSERT INTO `jos_jstats_bots` VALUES (402, 'nextgensearchbot', 'nextgensearchbot');
INSERT INTO `jos_jstats_bots` VALUES (403, 'ichiro', 'ichiro');
INSERT INTO `jos_jstats_bots` VALUES (404, 'peerfactor 404 crawler', 'peerfactor 404 crawler');
INSERT INTO `jos_jstats_bots` VALUES (405, 'ebay relevance ad crawler', 'Ebay relevance ad crawler');
INSERT INTO `jos_jstats_bots` VALUES (406, 'yodaobot', 'yodaobot/1.0');
INSERT INTO `jos_jstats_bots` VALUES (407, 'vmbot', 'vmbot/0.9');
INSERT INTO `jos_jstats_bots` VALUES (408, 'Blaiz-Bee', 'Blaiz-Bee/2.00.*');
INSERT INTO `jos_jstats_bots` VALUES (409, 'sensis', 'Sensis Web Crawler');
INSERT INTO `jos_jstats_bots` VALUES (410, 'ABACHOBot', 'ABACHOBot');
INSERT INTO `jos_jstats_bots` VALUES (411, 'AbiLogicBot', 'AbiLogicBot http://www.abilogic.com/bot.html');
INSERT INTO `jos_jstats_bots` VALUES (412, 'Googlebot-Image', 'Googlebot-Image');
INSERT INTO `jos_jstats_bots` VALUES (413, 'EmailSiphon', 'EmailSiphon (Sonic) - Email Collector');
INSERT INTO `jos_jstats_bots` VALUES (414, 'W3C-checklink', 'W3C Linkchecker');
INSERT INTO `jos_jstats_bots` VALUES (419, 'W3C_Validator', 'W3C XHTML/HTML Validator');
INSERT INTO `jos_jstats_bots` VALUES (420, 'depspid', 'DepSpid http://about.depspid.net');

-- --------------------------------------------------------

-- 
-- Structure de la table `jos_jstats_browsers`
-- 

DROP TABLE IF EXISTS `jos_jstats_browsers`;
CREATE TABLE IF NOT EXISTS `jos_jstats_browsers` (
  `browser_id` mediumint(9) NOT NULL auto_increment,
  `browser_string` varchar(50) NOT NULL default '',
  `browser_fullname` varchar(50) NOT NULL default '',
  `browser_img` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`browser_id`),
  UNIQUE KEY `browser_string` (`browser_string`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=87 ;

-- 
-- Contenu de la table `jos_jstats_browsers`
-- 

INSERT INTO `jos_jstats_browsers` VALUES (1, 'msie', 'Internet Explorer', 0);
INSERT INTO `jos_jstats_browsers` VALUES (2, 'netscape', 'Netscape', 0);
INSERT INTO `jos_jstats_browsers` VALUES (3, 'gecko', 'Mozilla', 0);
INSERT INTO `jos_jstats_browsers` VALUES (4, 'icab', 'iCab', 0);
INSERT INTO `jos_jstats_browsers` VALUES (5, 'go!zilla', 'Go!Zilla', 0);
INSERT INTO `jos_jstats_browsers` VALUES (6, 'konqueror', 'Konqueror', 0);
INSERT INTO `jos_jstats_browsers` VALUES (7, 'links', 'Links', 0);
INSERT INTO `jos_jstats_browsers` VALUES (8, 'lynx', 'Lynx', 0);
INSERT INTO `jos_jstats_browsers` VALUES (9, 'omniweb', 'OmniWeb', 0);
INSERT INTO `jos_jstats_browsers` VALUES (10, 'opera', 'Opera', 0);
INSERT INTO `jos_jstats_browsers` VALUES (11, 'wget', 'Wget', 0);
INSERT INTO `jos_jstats_browsers` VALUES (12, '22acidownload', '22AciDownload', 0);
INSERT INTO `jos_jstats_browsers` VALUES (13, 'aol-iweng', 'AOL-Iweng', 0);
INSERT INTO `jos_jstats_browsers` VALUES (14, 'amaya', 'Amaya', 0);
INSERT INTO `jos_jstats_browsers` VALUES (15, 'amigavoyager', 'AmigaVoyager', 0);
INSERT INTO `jos_jstats_browsers` VALUES (16, 'aweb', 'AWeb', 0);
INSERT INTO `jos_jstats_browsers` VALUES (17, 'bpftp', 'BPFTP', 0);
INSERT INTO `jos_jstats_browsers` VALUES (18, 'cyberdog', 'Cyberdog', 0);
INSERT INTO `jos_jstats_browsers` VALUES (19, 'dreamcast', 'Dreamcast', 0);
INSERT INTO `jos_jstats_browsers` VALUES (20, 'downloadagent', 'DownloadAgent', 0);
INSERT INTO `jos_jstats_browsers` VALUES (21, 'ecatch', 'eCatch', 0);
INSERT INTO `jos_jstats_browsers` VALUES (22, 'emailsiphon', 'EmailSiphon', 0);
INSERT INTO `jos_jstats_browsers` VALUES (23, 'encompass', 'Encompass', 0);
INSERT INTO `jos_jstats_browsers` VALUES (24, 'friendlyspider', 'FriendlySpider', 0);
INSERT INTO `jos_jstats_browsers` VALUES (25, 'fresco', 'ANT Fresco', 0);
INSERT INTO `jos_jstats_browsers` VALUES (26, 'galeon', 'Galeon', 0);
INSERT INTO `jos_jstats_browsers` VALUES (27, 'getright', 'GetRight', 0);
INSERT INTO `jos_jstats_browsers` VALUES (28, 'headdump', 'HeadDump', 0);
INSERT INTO `jos_jstats_browsers` VALUES (29, 'hotjava', 'Sun HotJava', 0);
INSERT INTO `jos_jstats_browsers` VALUES (30, 'ibrowse', 'IBrowse', 0);
INSERT INTO `jos_jstats_browsers` VALUES (31, 'intergo', 'InterGO', 0);
INSERT INTO `jos_jstats_browsers` VALUES (32, 'linemodebrowser', 'W3C Line Mode Browser', 0);
INSERT INTO `jos_jstats_browsers` VALUES (33, 'lotus-notes', 'Lotus Notes web client', 0);
INSERT INTO `jos_jstats_browsers` VALUES (34, 'macweb', 'MacWeb', 0);
INSERT INTO `jos_jstats_browsers` VALUES (35, 'ncsa_mosaic', 'NCSA Mosaic', 0);
INSERT INTO `jos_jstats_browsers` VALUES (36, 'netpositive', 'NetPositive', 0);
INSERT INTO `jos_jstats_browsers` VALUES (37, 'nutscrape', 'Nutscrape', 0);
INSERT INTO `jos_jstats_browsers` VALUES (38, 'msfrontpageexpress', 'MS FrontPage Express', 0);
INSERT INTO `jos_jstats_browsers` VALUES (39, 'phoenix', 'Phoenix', 0);
INSERT INTO `jos_jstats_browsers` VALUES (40, 'tzgeturl', 'TzGetURL', 0);
INSERT INTO `jos_jstats_browsers` VALUES (41, 'viking', 'Viking', 0);
INSERT INTO `jos_jstats_browsers` VALUES (42, 'webfetcher', 'WebFetcher', 0);
INSERT INTO `jos_jstats_browsers` VALUES (43, 'webexplorer', 'IBM-WebExplorer', 0);
INSERT INTO `jos_jstats_browsers` VALUES (44, 'webmirror', 'WebMirror', 0);
INSERT INTO `jos_jstats_browsers` VALUES (45, 'webvcr', 'WebVCR', 0);
INSERT INTO `jos_jstats_browsers` VALUES (46, 'teleport', 'TelePort Pro', 0);
INSERT INTO `jos_jstats_browsers` VALUES (47, 'webcapture', 'Acrobat', 0);
INSERT INTO `jos_jstats_browsers` VALUES (48, 'webcopier', 'WebCopier', 0);
INSERT INTO `jos_jstats_browsers` VALUES (49, 'real', 'RealAudio or compatible (media player)', 0);
INSERT INTO `jos_jstats_browsers` VALUES (50, 'winamp', 'WinAmp (media player)', 0);
INSERT INTO `jos_jstats_browsers` VALUES (51, 'windows-media-player', 'Windows Media Player (media player)', 0);
INSERT INTO `jos_jstats_browsers` VALUES (52, 'audion', 'Audion (media player)', 0);
INSERT INTO `jos_jstats_browsers` VALUES (53, 'freeamp', 'FreeAmp (media player)', 0);
INSERT INTO `jos_jstats_browsers` VALUES (54, 'itunes', 'Apple iTunes (media player)', 0);
INSERT INTO `jos_jstats_browsers` VALUES (55, 'jetaudio', 'JetAudio (media player)', 0);
INSERT INTO `jos_jstats_browsers` VALUES (56, 'mint_audio', 'Mint Audio (media player)', 0);
INSERT INTO `jos_jstats_browsers` VALUES (57, 'mpg123', 'mpg123 (media player)', 0);
INSERT INTO `jos_jstats_browsers` VALUES (58, 'nsplayer', 'NetShow Player (media player)', 0);
INSERT INTO `jos_jstats_browsers` VALUES (59, 'sonique', 'Sonique (media player)', 0);
INSERT INTO `jos_jstats_browsers` VALUES (60, 'uplayer', 'Ultra Player (media player)', 0);
INSERT INTO `jos_jstats_browsers` VALUES (61, 'xmms', 'XMMS (media player)', 0);
INSERT INTO `jos_jstats_browsers` VALUES (62, 'xaudio', 'Some XAudio Engine based MPEG player (media player', 0);
INSERT INTO `jos_jstats_browsers` VALUES (63, 'mmef', 'Microsoft Mobile Explorer (PDA/Phone browser)', 0);
INSERT INTO `jos_jstats_browsers` VALUES (64, 'mspie', 'MS Pocket Internet Explorer (PDA/Phone browser)', 0);
INSERT INTO `jos_jstats_browsers` VALUES (65, 'wapalizer', 'WAPalizer (PDA/Phone browser)', 0);
INSERT INTO `jos_jstats_browsers` VALUES (66, 'wapsilon', 'WAPsilon (PDA/Phone browser)', 0);
INSERT INTO `jos_jstats_browsers` VALUES (67, 'webcollage', 'WebCollage (PDA/Phone browser)', 0);
INSERT INTO `jos_jstats_browsers` VALUES (68, 'alcatel', 'Alcatel Browser (PDA/Phone browser)', 0);
INSERT INTO `jos_jstats_browsers` VALUES (69, 'nokia', 'Nokia Browser (PDA/Phone browser)', 0);
INSERT INTO `jos_jstats_browsers` VALUES (70, 'webtv', 'WebTV browser', 0);
INSERT INTO `jos_jstats_browsers` VALUES (71, 'csscheck', 'WDG CSS Validator', 0);
INSERT INTO `jos_jstats_browsers` VALUES (72, 'w3m', 'w3m', 0);
INSERT INTO `jos_jstats_browsers` VALUES (73, 'w3c_css_validator', 'W3C CSS Validator', 0);
INSERT INTO `jos_jstats_browsers` VALUES (74, 'w3c_validator', 'W3C HTML Validator', 0);
INSERT INTO `jos_jstats_browsers` VALUES (75, 'wdg_validator', 'WDG HTML Validator', 0);
INSERT INTO `jos_jstats_browsers` VALUES (76, 'webzip', 'WebZIP', 0);
INSERT INTO `jos_jstats_browsers` VALUES (77, 'staroffice', 'StarOffice', 0);
INSERT INTO `jos_jstats_browsers` VALUES (78, 'libwww', 'LibWWW', 0);
INSERT INTO `jos_jstats_browsers` VALUES (79, 'httrack', 'HTTrack (offline browser utility)', 0);
INSERT INTO `jos_jstats_browsers` VALUES (80, 'webstripper', 'webstripper (offline browser)', 0);
INSERT INTO `jos_jstats_browsers` VALUES (81, 'safari', 'Safari', 0);
INSERT INTO `jos_jstats_browsers` VALUES (82, 'avant browser', 'avant browser', 0);
INSERT INTO `jos_jstats_browsers` VALUES (83, 'firebird', 'firebird', 0);
INSERT INTO `jos_jstats_browsers` VALUES (84, 'avantgo', 'avantgo', 0);
INSERT INTO `jos_jstats_browsers` VALUES (85, 'firefox', 'FireFox', 0);
INSERT INTO `jos_jstats_browsers` VALUES (86, 'navio_aoltv', 'navio aoltv', 0);

-- --------------------------------------------------------

-- 
-- Structure de la table `jos_jstats_configuration`
-- 

DROP TABLE IF EXISTS `jos_jstats_configuration`;
CREATE TABLE IF NOT EXISTS `jos_jstats_configuration` (
  `description` varchar(250) NOT NULL default '-',
  `value` varchar(250) default NULL,
  PRIMARY KEY  (`description`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- 
-- Contenu de la table `jos_jstats_configuration`
-- 

INSERT INTO `jos_jstats_configuration` VALUES ('version', '2.2.0');
INSERT INTO `jos_jstats_configuration` VALUES ('hourdiff', '+1');
INSERT INTO `jos_jstats_configuration` VALUES ('onlinetime', '15');
INSERT INTO `jos_jstats_configuration` VALUES ('startoption', 'r03');
INSERT INTO `jos_jstats_configuration` VALUES ('language', 'fr');
INSERT INTO `jos_jstats_configuration` VALUES ('purgetime', '30');
INSERT INTO `jos_jstats_configuration` VALUES ('enable_whois', 'true');
INSERT INTO `jos_jstats_configuration` VALUES ('enable_i18n', 'true');
INSERT INTO `jos_jstats_configuration` VALUES ('show_bu', 'false');
INSERT INTO `jos_jstats_configuration` VALUES ('last_purge', '');

-- --------------------------------------------------------

-- 
-- Structure de la table `jos_jstats_ipaddresses`
-- 

DROP TABLE IF EXISTS `jos_jstats_ipaddresses`;
CREATE TABLE IF NOT EXISTS `jos_jstats_ipaddresses` (
  `ip` varchar(50) NOT NULL default '',
  `nslookup` varchar(255) default NULL,
  `tld` varchar(10) NOT NULL default 'unknown',
  `useragent` varchar(255) default NULL,
  `system` varchar(50) NOT NULL default '',
  `browser` varchar(50) NOT NULL default '',
  `id` mediumint(9) NOT NULL auto_increment,
  `type` tinyint(1) NOT NULL default '0',
  `exclude` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `id` (`id`),
  KEY `type` (`type`),
  KEY `tld` (`tld`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

-- 
-- Contenu de la table `jos_jstats_ipaddresses`
-- 

INSERT INTO `jos_jstats_ipaddresses` VALUES ('127.0.0.1', '127.0.0.1', '', 'mozilla/5.0 (windows; u; windows nt 5.1; fr; rv:1.8.1.4) gecko/20070515 firefox/2.0.0.4', 'Windows XP', 'FireFox 2.0.0.4', 1, 1, 0);
INSERT INTO `jos_jstats_ipaddresses` VALUES ('127.0.0.1', '127.0.0.1', '', 'mozilla/5.0 (windows; u; windows nt 5.1; fr; rv:1.8.1.6) gecko/20070725 firefox/2.0.0.6', 'Windows XP', 'FireFox 2.0.0.6', 2, 1, 0);

-- --------------------------------------------------------

-- 
-- Structure de la table `jos_jstats_iptocountry`
-- 

DROP TABLE IF EXISTS `jos_jstats_iptocountry`;
CREATE TABLE IF NOT EXISTS `jos_jstats_iptocountry` (
  `IP_FROM` bigint(20) NOT NULL default '0',
  `IP_TO` bigint(20) NOT NULL default '0',
  `COUNTRY_CODE2` char(2) NOT NULL default '',
  `COUNTRY_NAME` varchar(50) NOT NULL default '',
  PRIMARY KEY  (`IP_FROM`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- 
-- Contenu de la table `jos_jstats_iptocountry`
-- 


-- --------------------------------------------------------

-- 
-- Structure de la table `jos_jstats_keywords`
-- 

DROP TABLE IF EXISTS `jos_jstats_keywords`;
CREATE TABLE IF NOT EXISTS `jos_jstats_keywords` (
  `kwdate` date NOT NULL default '0000-00-00',
  `searchid` mediumint(9) NOT NULL default '0',
  `keywords` varchar(255) NOT NULL default ''
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- 
-- Contenu de la table `jos_jstats_keywords`
-- 


-- --------------------------------------------------------

-- 
-- Structure de la table `jos_jstats_page_request`
-- 

DROP TABLE IF EXISTS `jos_jstats_page_request`;
CREATE TABLE IF NOT EXISTS `jos_jstats_page_request` (
  `page_id` mediumint(9) NOT NULL default '0',
  `hour` tinyint(4) NOT NULL default '0',
  `day` tinyint(4) NOT NULL default '0',
  `month` tinyint(4) NOT NULL default '0',
  `year` smallint(6) NOT NULL default '0',
  `ip_id` mediumint(9) default NULL,
  KEY `page_id` (`page_id`),
  KEY `monthyear` (`month`,`year`),
  KEY `visits_id` (`ip_id`),
  KEY `index_ip` (`ip_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- 
-- Contenu de la table `jos_jstats_page_request`
-- 

INSERT INTO `jos_jstats_page_request` VALUES (1, 12, 3, 7, 2007, 1);
INSERT INTO `jos_jstats_page_request` VALUES (1, 8, 16, 7, 2007, 2);
INSERT INTO `jos_jstats_page_request` VALUES (1, 9, 16, 7, 2007, 2);
INSERT INTO `jos_jstats_page_request` VALUES (1, 9, 16, 7, 2007, 2);
INSERT INTO `jos_jstats_page_request` VALUES (1, 9, 16, 7, 2007, 2);
INSERT INTO `jos_jstats_page_request` VALUES (1, 9, 16, 7, 2007, 2);
INSERT INTO `jos_jstats_page_request` VALUES (1, 9, 16, 7, 2007, 2);
INSERT INTO `jos_jstats_page_request` VALUES (1, 9, 16, 7, 2007, 2);
INSERT INTO `jos_jstats_page_request` VALUES (1, 9, 16, 7, 2007, 2);
INSERT INTO `jos_jstats_page_request` VALUES (1, 9, 16, 7, 2007, 2);
INSERT INTO `jos_jstats_page_request` VALUES (1, 9, 16, 7, 2007, 2);
INSERT INTO `jos_jstats_page_request` VALUES (1, 9, 16, 7, 2007, 2);
INSERT INTO `jos_jstats_page_request` VALUES (1, 9, 16, 7, 2007, 2);
INSERT INTO `jos_jstats_page_request` VALUES (1, 9, 16, 7, 2007, 2);
INSERT INTO `jos_jstats_page_request` VALUES (1, 9, 16, 7, 2007, 2);
INSERT INTO `jos_jstats_page_request` VALUES (1, 9, 16, 7, 2007, 2);
INSERT INTO `jos_jstats_page_request` VALUES (1, 9, 16, 7, 2007, 2);
INSERT INTO `jos_jstats_page_request` VALUES (1, 9, 16, 7, 2007, 2);
INSERT INTO `jos_jstats_page_request` VALUES (1, 9, 16, 7, 2007, 2);
INSERT INTO `jos_jstats_page_request` VALUES (1, 8, 1, 8, 2007, 3);
INSERT INTO `jos_jstats_page_request` VALUES (1, 8, 1, 8, 2007, 3);
INSERT INTO `jos_jstats_page_request` VALUES (1, 14, 8, 8, 2007, 4);

-- --------------------------------------------------------

-- 
-- Structure de la table `jos_jstats_page_request_c`
-- 

DROP TABLE IF EXISTS `jos_jstats_page_request_c`;
CREATE TABLE IF NOT EXISTS `jos_jstats_page_request_c` (
  `page_id` mediumint(9) NOT NULL default '0',
  `hour` tinyint(4) NOT NULL default '0',
  `day` tinyint(4) NOT NULL default '0',
  `month` tinyint(4) NOT NULL default '0',
  `year` smallint(6) NOT NULL default '0',
  `count` mediumint(9) default NULL,
  KEY `page_id` (`page_id`),
  KEY `monthyear` (`month`,`year`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- 
-- Contenu de la table `jos_jstats_page_request_c`
-- 


-- --------------------------------------------------------

-- 
-- Structure de la table `jos_jstats_pages`
-- 

DROP TABLE IF EXISTS `jos_jstats_pages`;
CREATE TABLE IF NOT EXISTS `jos_jstats_pages` (
  `page_id` mediumint(9) NOT NULL auto_increment,
  `page` text NOT NULL,
  `page_title` varchar(255) default NULL,
  PRIMARY KEY  (`page_id`),
  KEY `page_id` (`page_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

-- 
-- Contenu de la table `jos_jstats_pages`
-- 

INSERT INTO `jos_jstats_pages` VALUES (1, '/V3/', 'Le Chesnay - Escrime - Accueil');

-- --------------------------------------------------------

-- 
-- Structure de la table `jos_jstats_referrer`
-- 

DROP TABLE IF EXISTS `jos_jstats_referrer`;
CREATE TABLE IF NOT EXISTS `jos_jstats_referrer` (
  `referrer` varchar(255) NOT NULL default '',
  `domain` varchar(100) NOT NULL default 'unknown',
  `refid` mediumint(9) NOT NULL auto_increment,
  `day` tinyint(4) NOT NULL default '0',
  `month` tinyint(4) NOT NULL default '0',
  `year` smallint(6) NOT NULL default '0',
  PRIMARY KEY  (`refid`),
  KEY `referrer` (`referrer`),
  KEY `monthyear` (`month`,`year`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- 
-- Contenu de la table `jos_jstats_referrer`
-- 


-- --------------------------------------------------------

-- 
-- Structure de la table `jos_jstats_search_engines`
-- 

DROP TABLE IF EXISTS `jos_jstats_search_engines`;
CREATE TABLE IF NOT EXISTS `jos_jstats_search_engines` (
  `searchid` mediumint(9) NOT NULL auto_increment,
  `description` varchar(100) NOT NULL default '',
  `search` varchar(100) NOT NULL default '',
  `searchvar` varchar(50) NOT NULL default '',
  PRIMARY KEY  (`searchid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=82 ;

-- 
-- Contenu de la table `jos_jstats_search_engines`
-- 

INSERT INTO `jos_jstats_search_engines` VALUES (1, 'Google', 'google.', 'p=,q=');
INSERT INTO `jos_jstats_search_engines` VALUES (2, 'Alexa', 'alexa.com', 'q=');
INSERT INTO `jos_jstats_search_engines` VALUES (3, 'Alltheweb', 'alltheweb.com', 'query=,q=');
INSERT INTO `jos_jstats_search_engines` VALUES (4, 'Altavista', 'altavista.', 'q=');
INSERT INTO `jos_jstats_search_engines` VALUES (5, 'DMOZ', 'dmoz.org', 'search=');
INSERT INTO `jos_jstats_search_engines` VALUES (6, 'Google Images', 'images.google.', 'p=,q=');
INSERT INTO `jos_jstats_search_engines` VALUES (7, 'Lycos', 'lycos.', 'query=');
INSERT INTO `jos_jstats_search_engines` VALUES (8, 'Msn', 'msn.', 'q=');
INSERT INTO `jos_jstats_search_engines` VALUES (9, 'Netscape', 'netscape.', 'search=');
INSERT INTO `jos_jstats_search_engines` VALUES (10, 'Search AOL', 'search.aol.com', 'query=');
INSERT INTO `jos_jstats_search_engines` VALUES (11, 'Search Terra', 'search.terra.', 'query=');
INSERT INTO `jos_jstats_search_engines` VALUES (12, 'Voila', 'voila.', 'kw=');
INSERT INTO `jos_jstats_search_engines` VALUES (13, 'Search.Com', 'www.search.com', 'q=');
INSERT INTO `jos_jstats_search_engines` VALUES (14, 'Yahoo', 'yahoo.', 'p=');
INSERT INTO `jos_jstats_search_engines` VALUES (15, 'Go Com', '.go.com', 'qt=');
INSERT INTO `jos_jstats_search_engines` VALUES (16, 'Ask Com', '.ask.com', 'ask=');
INSERT INTO `jos_jstats_search_engines` VALUES (17, 'Atomz', 'atomz.', 'sp-q=');
INSERT INTO `jos_jstats_search_engines` VALUES (18, 'EuroSeek', 'euroseek.', 'query=');
INSERT INTO `jos_jstats_search_engines` VALUES (19, 'Excite', 'excite.', 'search=');
INSERT INTO `jos_jstats_search_engines` VALUES (20, 'FindArticles', 'findarticles.com', 'key=');
INSERT INTO `jos_jstats_search_engines` VALUES (21, 'Go2Net', 'go2net.com', 'general=');
INSERT INTO `jos_jstats_search_engines` VALUES (22, 'HotBot', 'hotbot.', 'mt=');
INSERT INTO `jos_jstats_search_engines` VALUES (23, 'InfoSpace', 'infospace.com', 'qkw=');
INSERT INTO `jos_jstats_search_engines` VALUES (24, 'Kvasir', 'kvasir.', 'q=');
INSERT INTO `jos_jstats_search_engines` VALUES (25, 'LookSmart', 'looksmart.', 'key=');
INSERT INTO `jos_jstats_search_engines` VALUES (26, 'Mamma', 'mamma.', 'query=');
INSERT INTO `jos_jstats_search_engines` VALUES (27, 'MetaCrawler', 'metacrawler.', 'general=');
INSERT INTO `jos_jstats_search_engines` VALUES (28, 'Nbci.Com', 'nbci.com/search', 'keyword=');
INSERT INTO `jos_jstats_search_engines` VALUES (29, 'Northernlight', 'northernlight.', 'qr=');
INSERT INTO `jos_jstats_search_engines` VALUES (30, 'Overture', 'overture.com', 'keywords=');
INSERT INTO `jos_jstats_search_engines` VALUES (31, 'Dogpile', 'dogpile.com', 'qkw=');
INSERT INTO `jos_jstats_search_engines` VALUES (32, 'Dogpile', 'search.dogpile.com', 'q=');
INSERT INTO `jos_jstats_search_engines` VALUES (33, 'Spray', 'spray.', 'string=');
INSERT INTO `jos_jstats_search_engines` VALUES (34, 'Teoma', 'teoma.', 'q=');
INSERT INTO `jos_jstats_search_engines` VALUES (35, 'Virgilio', 'virgilio.it', 'qs=');
INSERT INTO `jos_jstats_search_engines` VALUES (36, 'Webcrawler', 'webcrawler', 'searchText=');
INSERT INTO `jos_jstats_search_engines` VALUES (37, 'Wisenut', 'wisenut.com', 'query=');
INSERT INTO `jos_jstats_search_engines` VALUES (38, 'ix quick', 'ixquick.com', 'query=');
INSERT INTO `jos_jstats_search_engines` VALUES (39, 'Earthlink', 'search.earthlink.net', 'q=');
INSERT INTO `jos_jstats_search_engines` VALUES (40, 'Sympatico', 'search.sli.sympatico.ca', 'query=');
INSERT INTO `jos_jstats_search_engines` VALUES (41, 'I-une', 'i-une.com', 'keywords=,q=');
INSERT INTO `jos_jstats_search_engines` VALUES (42, 'Miner.Bol.Com', 'miner.bol.com.br', 'q=');
INSERT INTO `jos_jstats_search_engines` VALUES (43, 'Baidu', 'baidu.com', 'word=');
INSERT INTO `jos_jstats_search_engines` VALUES (44, 'Sina', 'search.sina.com', 'word=');
INSERT INTO `jos_jstats_search_engines` VALUES (45, 'Sohu', 'search.sohu.com', 'word=');
INSERT INTO `jos_jstats_search_engines` VALUES (46, 'Atlas cz', 'atlas.cz', 'searchtext=');
INSERT INTO `jos_jstats_search_engines` VALUES (47, 'Seznam cz', 'seznam.cz', 'w=');
INSERT INTO `jos_jstats_search_engines` VALUES (48, 'Ftxt Quick cz', 'ftxt.quick.cz', 'query=');
INSERT INTO `jos_jstats_search_engines` VALUES (49, 'Centrum cz', 'centrum.cz', 'q=');
INSERT INTO `jos_jstats_search_engines` VALUES (50, 'Opasia dk', 'opasia.dk', 'q=');
INSERT INTO `jos_jstats_search_engines` VALUES (51, 'Danielsen', 'danielsen.com', 'q=');
INSERT INTO `jos_jstats_search_engines` VALUES (52, 'Sol dk', 'sol.dk', 'q=');
INSERT INTO `jos_jstats_search_engines` VALUES (53, 'Jubii dk', 'jubii.dk', 'soegeord=');
INSERT INTO `jos_jstats_search_engines` VALUES (54, 'Find dk', 'find.dk', 'words=');
INSERT INTO `jos_jstats_search_engines` VALUES (55, 'Edderkoppen dk', 'edderkoppen.dk', 'query=');
INSERT INTO `jos_jstats_search_engines` VALUES (56, 'Orbis dk', 'orbis.dk', 'search_field=');
INSERT INTO `jos_jstats_search_engines` VALUES (57, '1klik dk', '1klik.dk', 'query=');
INSERT INTO `jos_jstats_search_engines` VALUES (58, 'Ofir dk', 'ofir.dk', 'querytext=');
INSERT INTO `jos_jstats_search_engines` VALUES (59, 'Ilse nl', 'ilse.', 'search_for=');
INSERT INTO `jos_jstats_search_engines` VALUES (60, 'Vindex nl', 'vindex.', 'in=');
INSERT INTO `jos_jstats_search_engines` VALUES (61, 'Ask uk', 'ask.co.uk', 'ask=');
INSERT INTO `jos_jstats_search_engines` VALUES (62, 'BBC uk', 'bbc.co.uk/cgi-bin/search', 'q=');
INSERT INTO `jos_jstats_search_engines` VALUES (63, 'ifind uk', 'ifind.freeserve', 'q=');
INSERT INTO `jos_jstats_search_engines` VALUES (64, 'Looksmart uk', 'looksmart.co.uk', 'key=');
INSERT INTO `jos_jstats_search_engines` VALUES (65, 'mirago uk', 'mirago.', 'txtsearch=');
INSERT INTO `jos_jstats_search_engines` VALUES (66, 'Splut uk', 'splut.', 'pattern=');
INSERT INTO `jos_jstats_search_engines` VALUES (67, 'Spotjockey uk', 'spotjockey.', 'Search_Keyword=');
INSERT INTO `jos_jstats_search_engines` VALUES (68, 'Ukindex uk', 'ukindex.co.uk', 'stext=');
INSERT INTO `jos_jstats_search_engines` VALUES (69, 'Ukdirectory uk', 'ukdirectory.', 'k=');
INSERT INTO `jos_jstats_search_engines` VALUES (70, 'Ukplus uk', 'ukplus.', 'search=');
INSERT INTO `jos_jstats_search_engines` VALUES (71, 'Searchy uk', 'searchy.co.uk', 'search_term=');
INSERT INTO `jos_jstats_search_engines` VALUES (73, 'Haku fi', 'haku.www.fi', 'w=');
INSERT INTO `jos_jstats_search_engines` VALUES (74, 'Nomade fr', 'nomade.fr', 's=');
INSERT INTO `jos_jstats_search_engines` VALUES (75, 'Francite fr', 'francite.', 'name=');
INSERT INTO `jos_jstats_search_engines` VALUES (76, 'Club internet fr', 'recherche.club-internet.fr', 'q=');
INSERT INTO `jos_jstats_search_engines` VALUES (77, 'yandex', 'yandex.ru', 'text=');
INSERT INTO `jos_jstats_search_engines` VALUES (78, 'nigma', 'nigma.ru', 'q=');
INSERT INTO `jos_jstats_search_engines` VALUES (79, 'rambler', 'rambler.ru', 'words=');
INSERT INTO `jos_jstats_search_engines` VALUES (80, 'aport', 'aport.ru', 'r=');
INSERT INTO `jos_jstats_search_engines` VALUES (81, 'mail', 'mail.ru', 'q=');

-- --------------------------------------------------------

-- 
-- Structure de la table `jos_jstats_systems`
-- 

DROP TABLE IF EXISTS `jos_jstats_systems`;
CREATE TABLE IF NOT EXISTS `jos_jstats_systems` (
  `sys_id` mediumint(9) NOT NULL auto_increment,
  `sys_string` varchar(25) NOT NULL default '',
  `sys_fullname` varchar(25) NOT NULL default '',
  `sys_img` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`sys_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=37 ;

-- 
-- Contenu de la table `jos_jstats_systems`
-- 

INSERT INTO `jos_jstats_systems` VALUES (1, 'win95', 'Windows 95', 0);
INSERT INTO `jos_jstats_systems` VALUES (2, 'windows 95', 'Windows 95', 0);
INSERT INTO `jos_jstats_systems` VALUES (3, 'win98', 'Windows 98', 0);
INSERT INTO `jos_jstats_systems` VALUES (4, 'windows 98', 'Windows 98', 0);
INSERT INTO `jos_jstats_systems` VALUES (5, 'winme', 'Windows me', 0);
INSERT INTO `jos_jstats_systems` VALUES (6, 'windows me', 'Windows me', 0);
INSERT INTO `jos_jstats_systems` VALUES (7, 'windows nt 5.0', 'Windows 2000', 0);
INSERT INTO `jos_jstats_systems` VALUES (8, 'winnt 5.0', 'Windows 2000', 0);
INSERT INTO `jos_jstats_systems` VALUES (10, 'winnt 5.1', 'Windows XP', 0);
INSERT INTO `jos_jstats_systems` VALUES (11, 'windows nt 5.1', 'Windows XP', 0);
INSERT INTO `jos_jstats_systems` VALUES (12, 'macintosh', 'Mac OS', 0);
INSERT INTO `jos_jstats_systems` VALUES (13, 'linux', 'Linux', 0);
INSERT INTO `jos_jstats_systems` VALUES (14, 'aix', 'Aix', 0);
INSERT INTO `jos_jstats_systems` VALUES (15, 'sunos', 'Sun Solaris', 0);
INSERT INTO `jos_jstats_systems` VALUES (16, 'irix', 'Irix', 0);
INSERT INTO `jos_jstats_systems` VALUES (17, 'osf', 'OSF Unix', 0);
INSERT INTO `jos_jstats_systems` VALUES (18, 'hp-ux', 'HP Unix', 0);
INSERT INTO `jos_jstats_systems` VALUES (19, 'netbsd', 'NetBSD', 0);
INSERT INTO `jos_jstats_systems` VALUES (20, 'bsdi', 'BSDi', 0);
INSERT INTO `jos_jstats_systems` VALUES (21, 'freebsd', 'FreeBSD', 0);
INSERT INTO `jos_jstats_systems` VALUES (22, 'openbsd', 'OpenBSD', 0);
INSERT INTO `jos_jstats_systems` VALUES (23, 'unix', 'Unknown Unix system', 0);
INSERT INTO `jos_jstats_systems` VALUES (24, 'beos', 'BeOS', 0);
INSERT INTO `jos_jstats_systems` VALUES (25, 'os/2', 'Warp OS/2', 0);
INSERT INTO `jos_jstats_systems` VALUES (26, 'amigaos', 'AmigaOS', 0);
INSERT INTO `jos_jstats_systems` VALUES (27, 'vms', 'VMS', 0);
INSERT INTO `jos_jstats_systems` VALUES (28, 'cp/m', 'CPM', 0);
INSERT INTO `jos_jstats_systems` VALUES (29, 'crayos', 'CrayOS', 0);
INSERT INTO `jos_jstats_systems` VALUES (30, 'dreamcast', 'Dreamcast', 0);
INSERT INTO `jos_jstats_systems` VALUES (31, 'riscos', 'RISC OS', 0);
INSERT INTO `jos_jstats_systems` VALUES (32, 'webtv', 'WebTV', 0);
INSERT INTO `jos_jstats_systems` VALUES (33, 'windows nt 5.2', 'Windows 2003', 0);
INSERT INTO `jos_jstats_systems` VALUES (34, 'mac_powerpc', 'Mac PowerPC', 0);
INSERT INTO `jos_jstats_systems` VALUES (35, 'mac os x', 'Mac OS X', 0);
INSERT INTO `jos_jstats_systems` VALUES (36, 'windows nt', 'Windows NT', 0);

-- --------------------------------------------------------

-- 
-- Structure de la table `jos_jstats_topleveldomains`
-- 

DROP TABLE IF EXISTS `jos_jstats_topleveldomains`;
CREATE TABLE IF NOT EXISTS `jos_jstats_topleveldomains` (
  `tld_id` mediumint(9) NOT NULL auto_increment,
  `tld` varchar(6) NOT NULL default '',
  `fullname` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`tld_id`),
  KEY `tld` (`tld`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=271 ;

-- 
-- Contenu de la table `jos_jstats_topleveldomains`
-- 

INSERT INTO `jos_jstats_topleveldomains` VALUES (1, 'ac', 'Ascension Island');
INSERT INTO `jos_jstats_topleveldomains` VALUES (2, 'ad', 'Andorra');
INSERT INTO `jos_jstats_topleveldomains` VALUES (3, 'ae', 'United Arab Emirates');
INSERT INTO `jos_jstats_topleveldomains` VALUES (4, 'af', 'Afghanistan');
INSERT INTO `jos_jstats_topleveldomains` VALUES (5, 'ag', 'Antigua and Barbuda');
INSERT INTO `jos_jstats_topleveldomains` VALUES (6, 'ai', 'Anguilla');
INSERT INTO `jos_jstats_topleveldomains` VALUES (7, 'al', 'Albania');
INSERT INTO `jos_jstats_topleveldomains` VALUES (8, 'am', 'Armenia');
INSERT INTO `jos_jstats_topleveldomains` VALUES (9, 'an', 'Netherlands Antilles');
INSERT INTO `jos_jstats_topleveldomains` VALUES (10, 'ao', 'Angola');
INSERT INTO `jos_jstats_topleveldomains` VALUES (11, 'aq', 'Antarctica');
INSERT INTO `jos_jstats_topleveldomains` VALUES (12, 'ar', 'Argentina');
INSERT INTO `jos_jstats_topleveldomains` VALUES (13, 'as', 'American Samoa');
INSERT INTO `jos_jstats_topleveldomains` VALUES (14, 'at', 'Austria');
INSERT INTO `jos_jstats_topleveldomains` VALUES (15, 'au', 'Australia');
INSERT INTO `jos_jstats_topleveldomains` VALUES (16, 'aw', 'Aruba');
INSERT INTO `jos_jstats_topleveldomains` VALUES (17, 'ax', 'Aland Islands');
INSERT INTO `jos_jstats_topleveldomains` VALUES (18, 'az', 'Azerbaijan');
INSERT INTO `jos_jstats_topleveldomains` VALUES (19, 'ba', 'Bosnia Hercegovina');
INSERT INTO `jos_jstats_topleveldomains` VALUES (20, 'bb', 'Barbados');
INSERT INTO `jos_jstats_topleveldomains` VALUES (21, 'bd', 'Bangladesh');
INSERT INTO `jos_jstats_topleveldomains` VALUES (22, 'be', 'Belgium');
INSERT INTO `jos_jstats_topleveldomains` VALUES (23, 'bf', 'Burkina Faso');
INSERT INTO `jos_jstats_topleveldomains` VALUES (24, 'bg', 'Bulgaria');
INSERT INTO `jos_jstats_topleveldomains` VALUES (25, 'bh', 'Bahrain');
INSERT INTO `jos_jstats_topleveldomains` VALUES (26, 'bi', 'Burundi');
INSERT INTO `jos_jstats_topleveldomains` VALUES (27, 'bj', 'Benin');
INSERT INTO `jos_jstats_topleveldomains` VALUES (28, 'bm', 'Bermuda');
INSERT INTO `jos_jstats_topleveldomains` VALUES (29, 'bn', 'Brunei Darussalam');
INSERT INTO `jos_jstats_topleveldomains` VALUES (30, 'bo', 'Bolivia');
INSERT INTO `jos_jstats_topleveldomains` VALUES (31, 'br', 'Brazil');
INSERT INTO `jos_jstats_topleveldomains` VALUES (32, 'bs', 'Bahamas');
INSERT INTO `jos_jstats_topleveldomains` VALUES (33, 'bt', 'Bhutan');
INSERT INTO `jos_jstats_topleveldomains` VALUES (34, 'bv', 'Bouvet Island');
INSERT INTO `jos_jstats_topleveldomains` VALUES (35, 'bw', 'Botswana');
INSERT INTO `jos_jstats_topleveldomains` VALUES (36, 'by', 'Belarus (Byelorussia)');
INSERT INTO `jos_jstats_topleveldomains` VALUES (37, 'bz', 'Belize');
INSERT INTO `jos_jstats_topleveldomains` VALUES (38, 'ca', 'Canada');
INSERT INTO `jos_jstats_topleveldomains` VALUES (39, 'cc', 'Cocos Islands (Keeling)');
INSERT INTO `jos_jstats_topleveldomains` VALUES (40, 'cd', 'Congo, Democratic Republic of the');
INSERT INTO `jos_jstats_topleveldomains` VALUES (41, 'cf', 'Central African Republic');
INSERT INTO `jos_jstats_topleveldomains` VALUES (42, 'cg', 'Congo, Republic of');
INSERT INTO `jos_jstats_topleveldomains` VALUES (43, 'ch', 'Switzerland');
INSERT INTO `jos_jstats_topleveldomains` VALUES (44, 'ci', 'Cote d''Ivoire (Ivory Coast)');
INSERT INTO `jos_jstats_topleveldomains` VALUES (45, 'ck', 'Cook Islands');
INSERT INTO `jos_jstats_topleveldomains` VALUES (46, 'cl', 'Chile');
INSERT INTO `jos_jstats_topleveldomains` VALUES (47, 'cm', 'Cameroon');
INSERT INTO `jos_jstats_topleveldomains` VALUES (48, 'cn', 'China');
INSERT INTO `jos_jstats_topleveldomains` VALUES (49, 'co', 'Colombia');
INSERT INTO `jos_jstats_topleveldomains` VALUES (50, 'cr', 'Costa Rica');
INSERT INTO `jos_jstats_topleveldomains` VALUES (51, 'cs', 'Serbia and Montenegro');
INSERT INTO `jos_jstats_topleveldomains` VALUES (52, 'cu', 'Cuba');
INSERT INTO `jos_jstats_topleveldomains` VALUES (53, 'cv', 'Cap Verde');
INSERT INTO `jos_jstats_topleveldomains` VALUES (54, 'cx', 'Christmas Island');
INSERT INTO `jos_jstats_topleveldomains` VALUES (55, 'cy', 'Cyprus');
INSERT INTO `jos_jstats_topleveldomains` VALUES (56, 'cz', 'Czech Republic');
INSERT INTO `jos_jstats_topleveldomains` VALUES (57, 'de', 'Germany');
INSERT INTO `jos_jstats_topleveldomains` VALUES (58, 'dj', 'Djibouti');
INSERT INTO `jos_jstats_topleveldomains` VALUES (59, 'dk', 'Denmark');
INSERT INTO `jos_jstats_topleveldomains` VALUES (60, 'dm', 'Dominica');
INSERT INTO `jos_jstats_topleveldomains` VALUES (61, 'do', 'Dominican Republic');
INSERT INTO `jos_jstats_topleveldomains` VALUES (62, 'dz', 'Algeria');
INSERT INTO `jos_jstats_topleveldomains` VALUES (63, 'ec', 'Ecuador');
INSERT INTO `jos_jstats_topleveldomains` VALUES (64, 'ee', 'Estonia');
INSERT INTO `jos_jstats_topleveldomains` VALUES (65, 'eg', 'Egypt');
INSERT INTO `jos_jstats_topleveldomains` VALUES (66, 'eh', 'Western Sahara');
INSERT INTO `jos_jstats_topleveldomains` VALUES (67, 'er', 'Eritrea');
INSERT INTO `jos_jstats_topleveldomains` VALUES (68, 'es', 'Spain');
INSERT INTO `jos_jstats_topleveldomains` VALUES (69, 'et', 'Ethiopia');
INSERT INTO `jos_jstats_topleveldomains` VALUES (70, 'fi', 'Finland');
INSERT INTO `jos_jstats_topleveldomains` VALUES (71, 'fj', 'Fiji');
INSERT INTO `jos_jstats_topleveldomains` VALUES (72, 'fk', 'Falkland Islands');
INSERT INTO `jos_jstats_topleveldomains` VALUES (73, 'fm', 'Micronesia, Federated States of');
INSERT INTO `jos_jstats_topleveldomains` VALUES (74, 'fo', 'Faroe Islands');
INSERT INTO `jos_jstats_topleveldomains` VALUES (75, 'fr', 'France');
INSERT INTO `jos_jstats_topleveldomains` VALUES (76, 'ga', 'Gabon');
INSERT INTO `jos_jstats_topleveldomains` VALUES (77, 'gb', 'United Kingdom');
INSERT INTO `jos_jstats_topleveldomains` VALUES (78, 'gd', 'Grenada');
INSERT INTO `jos_jstats_topleveldomains` VALUES (79, 'ge', 'Georgia');
INSERT INTO `jos_jstats_topleveldomains` VALUES (80, 'gf', 'French Guiana');
INSERT INTO `jos_jstats_topleveldomains` VALUES (81, 'gg', 'Guernsey');
INSERT INTO `jos_jstats_topleveldomains` VALUES (82, 'gh', 'Ghana');
INSERT INTO `jos_jstats_topleveldomains` VALUES (83, 'gi', 'Gibraltar');
INSERT INTO `jos_jstats_topleveldomains` VALUES (84, 'gl', 'Greenland');
INSERT INTO `jos_jstats_topleveldomains` VALUES (85, 'gm', 'Gambia');
INSERT INTO `jos_jstats_topleveldomains` VALUES (86, 'gn', 'Guinea');
INSERT INTO `jos_jstats_topleveldomains` VALUES (87, 'gp', 'Guadeloupe');
INSERT INTO `jos_jstats_topleveldomains` VALUES (88, 'gq', 'Equatorial Guinea');
INSERT INTO `jos_jstats_topleveldomains` VALUES (89, 'gr', 'Greece');
INSERT INTO `jos_jstats_topleveldomains` VALUES (90, 'gs', 'South Georgia and the South Sandwich Islands');
INSERT INTO `jos_jstats_topleveldomains` VALUES (91, 'gt', 'Guatemala');
INSERT INTO `jos_jstats_topleveldomains` VALUES (92, 'gu', 'Guam');
INSERT INTO `jos_jstats_topleveldomains` VALUES (93, 'gw', 'Guinea-Bissau');
INSERT INTO `jos_jstats_topleveldomains` VALUES (94, 'gy', 'Guyana');
INSERT INTO `jos_jstats_topleveldomains` VALUES (95, 'hk', 'Hong Kong');
INSERT INTO `jos_jstats_topleveldomains` VALUES (96, 'hm', 'Heard and McDonald Islands');
INSERT INTO `jos_jstats_topleveldomains` VALUES (97, 'hn', 'Honduras');
INSERT INTO `jos_jstats_topleveldomains` VALUES (98, 'hr', 'Croatia/Hrvatska');
INSERT INTO `jos_jstats_topleveldomains` VALUES (99, 'ht', 'Haiti');
INSERT INTO `jos_jstats_topleveldomains` VALUES (100, 'hu', 'Hungary');
INSERT INTO `jos_jstats_topleveldomains` VALUES (101, 'id', 'Indonesia');
INSERT INTO `jos_jstats_topleveldomains` VALUES (102, 'ie', 'Ireland');
INSERT INTO `jos_jstats_topleveldomains` VALUES (103, 'il', 'Israel');
INSERT INTO `jos_jstats_topleveldomains` VALUES (104, 'im', 'Isle of Man');
INSERT INTO `jos_jstats_topleveldomains` VALUES (105, 'in', 'India');
INSERT INTO `jos_jstats_topleveldomains` VALUES (106, 'io', 'British Indian Ocean Territory');
INSERT INTO `jos_jstats_topleveldomains` VALUES (107, 'iq', 'Iraq');
INSERT INTO `jos_jstats_topleveldomains` VALUES (108, 'ir', 'Iran, Islamic Republic of');
INSERT INTO `jos_jstats_topleveldomains` VALUES (109, 'is', 'Iceland');
INSERT INTO `jos_jstats_topleveldomains` VALUES (110, 'it', 'Italy');
INSERT INTO `jos_jstats_topleveldomains` VALUES (111, 'je', 'Jersey');
INSERT INTO `jos_jstats_topleveldomains` VALUES (112, 'jm', 'Jamaica');
INSERT INTO `jos_jstats_topleveldomains` VALUES (113, 'jo', 'Jordan');
INSERT INTO `jos_jstats_topleveldomains` VALUES (114, 'jp', 'Japan');
INSERT INTO `jos_jstats_topleveldomains` VALUES (115, 'ke', 'Kenya');
INSERT INTO `jos_jstats_topleveldomains` VALUES (116, 'kg', 'Kyrgyzstan');
INSERT INTO `jos_jstats_topleveldomains` VALUES (117, 'kh', 'Cambodia');
INSERT INTO `jos_jstats_topleveldomains` VALUES (118, 'ki', 'Kiribati');
INSERT INTO `jos_jstats_topleveldomains` VALUES (119, 'km', 'Comoros');
INSERT INTO `jos_jstats_topleveldomains` VALUES (120, 'kn', 'Saint Kitts and Nevis');
INSERT INTO `jos_jstats_topleveldomains` VALUES (121, 'kp', 'Korea, Democratic People''s Republic');
INSERT INTO `jos_jstats_topleveldomains` VALUES (122, 'kr', 'Korea, Republic of');
INSERT INTO `jos_jstats_topleveldomains` VALUES (123, 'kw', 'Kuwait');
INSERT INTO `jos_jstats_topleveldomains` VALUES (124, 'ky', 'Cayman Islands');
INSERT INTO `jos_jstats_topleveldomains` VALUES (125, 'kz', 'Kazakhstan');
INSERT INTO `jos_jstats_topleveldomains` VALUES (126, 'la', 'Lao People''s Democratic Republic');
INSERT INTO `jos_jstats_topleveldomains` VALUES (127, 'lb', 'Lebanon');
INSERT INTO `jos_jstats_topleveldomains` VALUES (128, 'lc', 'Saint Lucia');
INSERT INTO `jos_jstats_topleveldomains` VALUES (129, 'li', 'Liechtenstein');
INSERT INTO `jos_jstats_topleveldomains` VALUES (130, 'lk', 'Sri Lanka');
INSERT INTO `jos_jstats_topleveldomains` VALUES (131, 'lr', 'Liberia');
INSERT INTO `jos_jstats_topleveldomains` VALUES (132, 'ls', 'Lesotho');
INSERT INTO `jos_jstats_topleveldomains` VALUES (133, 'lt', 'Lithuania');
INSERT INTO `jos_jstats_topleveldomains` VALUES (134, 'lu', 'Luxembourg');
INSERT INTO `jos_jstats_topleveldomains` VALUES (135, 'lv', 'Latvia');
INSERT INTO `jos_jstats_topleveldomains` VALUES (136, 'ly', 'Libyan Arab Jamahiriya');
INSERT INTO `jos_jstats_topleveldomains` VALUES (137, 'ma', 'Morocco');
INSERT INTO `jos_jstats_topleveldomains` VALUES (138, 'mc', 'Monaco');
INSERT INTO `jos_jstats_topleveldomains` VALUES (139, 'md', 'Moldova, Republic of');
INSERT INTO `jos_jstats_topleveldomains` VALUES (140, 'mg', 'Madagascar');
INSERT INTO `jos_jstats_topleveldomains` VALUES (141, 'mh', 'Marshall Islands');
INSERT INTO `jos_jstats_topleveldomains` VALUES (142, 'mk', 'Macedonia, Former Yugoslav Republic');
INSERT INTO `jos_jstats_topleveldomains` VALUES (143, 'ml', 'Mali');
INSERT INTO `jos_jstats_topleveldomains` VALUES (144, 'mm', 'Myanmar');
INSERT INTO `jos_jstats_topleveldomains` VALUES (145, 'mn', 'Mongolia');
INSERT INTO `jos_jstats_topleveldomains` VALUES (146, 'mo', 'Macau');
INSERT INTO `jos_jstats_topleveldomains` VALUES (147, 'mp', 'Northern Mariana Islands');
INSERT INTO `jos_jstats_topleveldomains` VALUES (148, 'mq', 'Martinique');
INSERT INTO `jos_jstats_topleveldomains` VALUES (149, 'mr', 'Mauritani');
INSERT INTO `jos_jstats_topleveldomains` VALUES (150, 'ms', 'Montserrat');
INSERT INTO `jos_jstats_topleveldomains` VALUES (151, 'mt', 'Malta');
INSERT INTO `jos_jstats_topleveldomains` VALUES (152, 'mu', 'Mauritius');
INSERT INTO `jos_jstats_topleveldomains` VALUES (153, 'mv', 'Maldives');
INSERT INTO `jos_jstats_topleveldomains` VALUES (154, 'mw', 'Malawi');
INSERT INTO `jos_jstats_topleveldomains` VALUES (155, 'mx', 'Mexico');
INSERT INTO `jos_jstats_topleveldomains` VALUES (156, 'my', 'Malaysia');
INSERT INTO `jos_jstats_topleveldomains` VALUES (157, 'mz', 'Mozambique');
INSERT INTO `jos_jstats_topleveldomains` VALUES (158, 'na', 'Namibia');
INSERT INTO `jos_jstats_topleveldomains` VALUES (159, 'nc', 'New Caledonia');
INSERT INTO `jos_jstats_topleveldomains` VALUES (160, 'ne', 'Niger');
INSERT INTO `jos_jstats_topleveldomains` VALUES (161, 'nf', 'Norfolk Island');
INSERT INTO `jos_jstats_topleveldomains` VALUES (162, 'ng', 'Nigeria');
INSERT INTO `jos_jstats_topleveldomains` VALUES (163, 'ni', 'Nicaragua');
INSERT INTO `jos_jstats_topleveldomains` VALUES (164, 'nl', 'Netherlands');
INSERT INTO `jos_jstats_topleveldomains` VALUES (165, 'no', 'Norway');
INSERT INTO `jos_jstats_topleveldomains` VALUES (166, 'np', 'Nepal');
INSERT INTO `jos_jstats_topleveldomains` VALUES (167, 'nr', 'Nauru');
INSERT INTO `jos_jstats_topleveldomains` VALUES (168, 'nt', 'Neutral Zone');
INSERT INTO `jos_jstats_topleveldomains` VALUES (169, 'nu', 'Niue');
INSERT INTO `jos_jstats_topleveldomains` VALUES (170, 'nz', 'New Zealand');
INSERT INTO `jos_jstats_topleveldomains` VALUES (171, 'om', 'Oman');
INSERT INTO `jos_jstats_topleveldomains` VALUES (172, 'pa', 'Panama');
INSERT INTO `jos_jstats_topleveldomains` VALUES (173, 'pe', 'Peru');
INSERT INTO `jos_jstats_topleveldomains` VALUES (174, 'pf', 'French Polynesia');
INSERT INTO `jos_jstats_topleveldomains` VALUES (175, 'pg', 'Papua New Guinea');
INSERT INTO `jos_jstats_topleveldomains` VALUES (176, 'ph', 'Philippines');
INSERT INTO `jos_jstats_topleveldomains` VALUES (177, 'pk', 'Pakistan');
INSERT INTO `jos_jstats_topleveldomains` VALUES (178, 'pl', 'Poland');
INSERT INTO `jos_jstats_topleveldomains` VALUES (179, 'pm', 'St. Pierre and Miquelon');
INSERT INTO `jos_jstats_topleveldomains` VALUES (180, 'pn', 'Pitcairn Island');
INSERT INTO `jos_jstats_topleveldomains` VALUES (181, 'pr', 'Puerto Rico');
INSERT INTO `jos_jstats_topleveldomains` VALUES (182, 'ps', 'Palestinian Territories');
INSERT INTO `jos_jstats_topleveldomains` VALUES (183, 'pt', 'Portugal');
INSERT INTO `jos_jstats_topleveldomains` VALUES (184, 'pw', 'Palau');
INSERT INTO `jos_jstats_topleveldomains` VALUES (185, 'py', 'Paraguay');
INSERT INTO `jos_jstats_topleveldomains` VALUES (186, 'qa', 'Qatar');
INSERT INTO `jos_jstats_topleveldomains` VALUES (187, 're', 'Reunion Island');
INSERT INTO `jos_jstats_topleveldomains` VALUES (188, 'ro', 'Romania');
INSERT INTO `jos_jstats_topleveldomains` VALUES (189, 'ru', 'Russian Federation');
INSERT INTO `jos_jstats_topleveldomains` VALUES (190, 'rw', 'Rwanda');
INSERT INTO `jos_jstats_topleveldomains` VALUES (191, 'sa', 'Saudi Arabia');
INSERT INTO `jos_jstats_topleveldomains` VALUES (192, 'sb', 'Solomon Islands');
INSERT INTO `jos_jstats_topleveldomains` VALUES (193, 'sc', 'Seychelles');
INSERT INTO `jos_jstats_topleveldomains` VALUES (194, 'sd', 'Sudan');
INSERT INTO `jos_jstats_topleveldomains` VALUES (195, 'se', 'Sweden');
INSERT INTO `jos_jstats_topleveldomains` VALUES (196, 'sg', 'Singapore');
INSERT INTO `jos_jstats_topleveldomains` VALUES (197, 'sh', 'St. Helena');
INSERT INTO `jos_jstats_topleveldomains` VALUES (198, 'si', 'Slovenia');
INSERT INTO `jos_jstats_topleveldomains` VALUES (199, 'sj', 'Svalbard and Jan Mayen Islands');
INSERT INTO `jos_jstats_topleveldomains` VALUES (200, 'sk', 'Slovak Republic');
INSERT INTO `jos_jstats_topleveldomains` VALUES (201, 'sl', 'Sierra Leone');
INSERT INTO `jos_jstats_topleveldomains` VALUES (202, 'sm', 'San Marino');
INSERT INTO `jos_jstats_topleveldomains` VALUES (203, 'sn', 'Senegal');
INSERT INTO `jos_jstats_topleveldomains` VALUES (204, 'so', 'Somalia');
INSERT INTO `jos_jstats_topleveldomains` VALUES (205, 'sr', 'Suriname');
INSERT INTO `jos_jstats_topleveldomains` VALUES (206, 'st', 'Sao Tome and Principe');
INSERT INTO `jos_jstats_topleveldomains` VALUES (207, 'su', 'Former Soviet Union');
INSERT INTO `jos_jstats_topleveldomains` VALUES (208, 'sv', 'El Salvador');
INSERT INTO `jos_jstats_topleveldomains` VALUES (209, 'sy', 'Syrian Arab Republic');
INSERT INTO `jos_jstats_topleveldomains` VALUES (210, 'sz', 'Swaziland');
INSERT INTO `jos_jstats_topleveldomains` VALUES (211, 'tc', 'Turks and Caicos Islands');
INSERT INTO `jos_jstats_topleveldomains` VALUES (212, 'td', 'Chad');
INSERT INTO `jos_jstats_topleveldomains` VALUES (213, 'tf', 'French Southern Territories');
INSERT INTO `jos_jstats_topleveldomains` VALUES (214, 'tg', 'Togo');
INSERT INTO `jos_jstats_topleveldomains` VALUES (215, 'th', 'Thailand');
INSERT INTO `jos_jstats_topleveldomains` VALUES (216, 'tj', 'Tajikistan');
INSERT INTO `jos_jstats_topleveldomains` VALUES (217, 'tk', 'Tokelau');
INSERT INTO `jos_jstats_topleveldomains` VALUES (218, 'tl', 'East Timor');
INSERT INTO `jos_jstats_topleveldomains` VALUES (219, 'tm', 'Turkmenistan');
INSERT INTO `jos_jstats_topleveldomains` VALUES (220, 'tn', 'Tunisia');
INSERT INTO `jos_jstats_topleveldomains` VALUES (221, 'to', 'Tonga');
INSERT INTO `jos_jstats_topleveldomains` VALUES (222, 'tp', 'East Timor');
INSERT INTO `jos_jstats_topleveldomains` VALUES (223, 'tr', 'Turkey');
INSERT INTO `jos_jstats_topleveldomains` VALUES (224, 'tt', 'Trinidad and Tobago');
INSERT INTO `jos_jstats_topleveldomains` VALUES (225, 'tv', 'Tuvalu');
INSERT INTO `jos_jstats_topleveldomains` VALUES (226, 'tw', 'Taiwan');
INSERT INTO `jos_jstats_topleveldomains` VALUES (227, 'tz', 'Tanzania');
INSERT INTO `jos_jstats_topleveldomains` VALUES (228, 'ua', 'Ukraine');
INSERT INTO `jos_jstats_topleveldomains` VALUES (229, 'ug', 'Uganda');
INSERT INTO `jos_jstats_topleveldomains` VALUES (230, 'uk', 'United Kingdom');
INSERT INTO `jos_jstats_topleveldomains` VALUES (231, 'um', 'US Minor Outlying Islands');
INSERT INTO `jos_jstats_topleveldomains` VALUES (232, 'us', 'United States');
INSERT INTO `jos_jstats_topleveldomains` VALUES (233, 'uy', 'Uruguay');
INSERT INTO `jos_jstats_topleveldomains` VALUES (234, 'uz', 'Uzbekistan');
INSERT INTO `jos_jstats_topleveldomains` VALUES (235, 'va', 'Holy See (City Vatican State)');
INSERT INTO `jos_jstats_topleveldomains` VALUES (236, 'vc', 'Saint Vincent and the Grenadines');
INSERT INTO `jos_jstats_topleveldomains` VALUES (237, 've', 'Venezuela');
INSERT INTO `jos_jstats_topleveldomains` VALUES (238, 'vg', 'Virgin Islands (British)');
INSERT INTO `jos_jstats_topleveldomains` VALUES (239, 'vi', 'Virgin Islands (USA)');
INSERT INTO `jos_jstats_topleveldomains` VALUES (240, 'vn', 'Vietnam');
INSERT INTO `jos_jstats_topleveldomains` VALUES (241, 'vu', 'Vanuatu');
INSERT INTO `jos_jstats_topleveldomains` VALUES (242, 'wf', 'Wallis and Futuna Islands');
INSERT INTO `jos_jstats_topleveldomains` VALUES (243, 'ws', 'Western Samoa');
INSERT INTO `jos_jstats_topleveldomains` VALUES (244, 'ye', 'Yemen');
INSERT INTO `jos_jstats_topleveldomains` VALUES (245, 'yt', 'Mayotte');
INSERT INTO `jos_jstats_topleveldomains` VALUES (246, 'yu', 'Serbia and Montenegro');
INSERT INTO `jos_jstats_topleveldomains` VALUES (247, 'za', 'South Africa');
INSERT INTO `jos_jstats_topleveldomains` VALUES (248, 'zm', 'Zambia');
INSERT INTO `jos_jstats_topleveldomains` VALUES (249, 'zw', 'Zimbabwe');
INSERT INTO `jos_jstats_topleveldomains` VALUES (250, 'eu', 'European Union');
INSERT INTO `jos_jstats_topleveldomains` VALUES (251, 'cat', 'Catalonia');
INSERT INTO `jos_jstats_topleveldomains` VALUES (252, 'com', 'Commercial');
INSERT INTO `jos_jstats_topleveldomains` VALUES (253, 'net', 'Network');
INSERT INTO `jos_jstats_topleveldomains` VALUES (254, 'org', 'Organization');
INSERT INTO `jos_jstats_topleveldomains` VALUES (255, 'gov', 'US Government');
INSERT INTO `jos_jstats_topleveldomains` VALUES (256, 'mil', 'US Military (Dept of Defense)');
INSERT INTO `jos_jstats_topleveldomains` VALUES (257, 'int', 'International Organizations');
INSERT INTO `jos_jstats_topleveldomains` VALUES (258, 'aero', 'Aviation Industry');
INSERT INTO `jos_jstats_topleveldomains` VALUES (259, 'biz', 'Businesses');
INSERT INTO `jos_jstats_topleveldomains` VALUES (260, 'coop', 'Cooperatives');
INSERT INTO `jos_jstats_topleveldomains` VALUES (261, 'edu', 'Educational Institutions');
INSERT INTO `jos_jstats_topleveldomains` VALUES (262, 'info', 'Worldwide unrestricted use');
INSERT INTO `jos_jstats_topleveldomains` VALUES (263, 'jobs', 'Job Offering Companies');
INSERT INTO `jos_jstats_topleveldomains` VALUES (264, 'mobi', 'Mobile Internet Services');
INSERT INTO `jos_jstats_topleveldomains` VALUES (265, 'museum', 'Museums');
INSERT INTO `jos_jstats_topleveldomains` VALUES (266, 'name', 'Individuals and Families');
INSERT INTO `jos_jstats_topleveldomains` VALUES (267, 'pro', 'Attorneys, Physicians, Engineers, and Accountants');
INSERT INTO `jos_jstats_topleveldomains` VALUES (268, 'travel', 'Travel and Tourism Industry');
INSERT INTO `jos_jstats_topleveldomains` VALUES (269, 'arpa', 'Old Style Arpanet');
INSERT INTO `jos_jstats_topleveldomains` VALUES (270, '', 'Unknown');

-- --------------------------------------------------------

-- 
-- Structure de la table `jos_jstats_visits`
-- 

DROP TABLE IF EXISTS `jos_jstats_visits`;
CREATE TABLE IF NOT EXISTS `jos_jstats_visits` (
  `id` mediumint(9) NOT NULL auto_increment,
  `ip_id` mediumint(9) NOT NULL default '0',
  `userid` int(11) NOT NULL default '0',
  `hour` tinyint(4) NOT NULL default '0',
  `day` tinyint(4) NOT NULL default '0',
  `month` tinyint(4) NOT NULL default '0',
  `year` smallint(6) NOT NULL default '0',
  `time` datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (`id`),
  KEY `time` (`time`),
  KEY `ip_id` (`ip_id`),
  KEY `monthyear` (`month`,`year`),
  KEY `daymonthyear` (`day`,`month`,`year`),
  KEY `userid` (`userid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

-- 
-- Contenu de la table `jos_jstats_visits`
-- 

INSERT INTO `jos_jstats_visits` VALUES (1, 1, 0, 12, 3, 7, 2007, '2007-07-03 12:36:37');
INSERT INTO `jos_jstats_visits` VALUES (2, 1, 0, 8, 16, 7, 2007, '2007-07-16 09:34:09');
INSERT INTO `jos_jstats_visits` VALUES (3, 2, 0, 8, 1, 8, 2007, '2007-08-01 08:33:08');
INSERT INTO `jos_jstats_visits` VALUES (4, 2, 0, 14, 8, 8, 2007, '2007-08-08 14:07:14');

-- --------------------------------------------------------

-- 
-- Structure de la table `jos_mambots`
-- 

DROP TABLE IF EXISTS `jos_mambots`;
CREATE TABLE IF NOT EXISTS `jos_mambots` (
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
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=20 ;

-- 
-- Contenu de la table `jos_mambots`
-- 

INSERT INTO `jos_mambots` VALUES (1, 'MOS Image', 'mosimage', 'content', 0, -10000, 1, 1, 0, 0, '0000-00-00 00:00:00', '');
INSERT INTO `jos_mambots` VALUES (2, 'MOS Pagination', 'mospaging', 'content', 0, 10000, 1, 1, 0, 0, '0000-00-00 00:00:00', '');
INSERT INTO `jos_mambots` VALUES (3, 'Legacy Mambot Includer', 'legacybots', 'content', 0, 1, 0, 1, 0, 0, '0000-00-00 00:00:00', '');
INSERT INTO `jos_mambots` VALUES (4, 'SEF', 'mossef', 'content', 0, 3, 1, 0, 0, 0, '0000-00-00 00:00:00', '');
INSERT INTO `jos_mambots` VALUES (5, 'MOS Rating', 'mosvote', 'content', 0, 4, 1, 1, 0, 0, '0000-00-00 00:00:00', '');
INSERT INTO `jos_mambots` VALUES (6, 'Recherche dans les articles', 'content.searchbot', 'search', 0, 1, 1, 1, 0, 0, '0000-00-00 00:00:00', '');
INSERT INTO `jos_mambots` VALUES (7, 'Recherche dans les liens web', 'weblinks.searchbot', 'search', 0, 2, 1, 1, 0, 0, '0000-00-00 00:00:00', '');
INSERT INTO `jos_mambots` VALUES (8, 'Code support', 'moscode', 'content', 0, 2, 0, 0, 0, 0, '0000-00-00 00:00:00', '');
INSERT INTO `jos_mambots` VALUES (9, 'Aucun éditeur WYSIWYG', 'none', 'editors', 0, 0, 1, 1, 0, 0, '0000-00-00 00:00:00', '');
INSERT INTO `jos_mambots` VALUES (10, 'Editeur TinyMCE WYSIWYG', 'tinymce', 'editors', 0, 0, 1, 1, 0, 0, '0000-00-00 00:00:00', 'theme=advanced');
INSERT INTO `jos_mambots` VALUES (11, 'Bouton MOS Image éditeur', 'mosimage.btn', 'editors-xtd', 0, 0, 1, 0, 0, 0, '0000-00-00 00:00:00', '');
INSERT INTO `jos_mambots` VALUES (12, 'Bouton MOS Pagebreak éditeur', 'mospage.btn', 'editors-xtd', 0, 0, 1, 0, 0, 0, '0000-00-00 00:00:00', '');
INSERT INTO `jos_mambots` VALUES (13, 'Recherche dans les contacts', 'contacts.searchbot', 'search', 0, 3, 1, 1, 0, 0, '0000-00-00 00:00:00', '');
INSERT INTO `jos_mambots` VALUES (14, 'Recherche dans les catégories', 'categories.searchbot', 'search', 0, 4, 1, 0, 0, 0, '0000-00-00 00:00:00', '');
INSERT INTO `jos_mambots` VALUES (15, 'Recherche dans les sections', 'sections.searchbot', 'search', 0, 5, 1, 0, 0, 0, '0000-00-00 00:00:00', '');
INSERT INTO `jos_mambots` VALUES (16, 'Email Cloaking', 'mosemailcloak', 'content', 0, 5, 1, 0, 0, 0, '0000-00-00 00:00:00', '');
INSERT INTO `jos_mambots` VALUES (17, 'GeSHi', 'geshi', 'content', 0, 5, 0, 0, 0, 0, '0000-00-00 00:00:00', '');
INSERT INTO `jos_mambots` VALUES (18, 'Recherche dans les flux RSS', 'newsfeeds.searchbot', 'search', 0, 6, 1, 0, 0, 0, '0000-00-00 00:00:00', '');
INSERT INTO `jos_mambots` VALUES (19, 'Chargeur de positions de module', 'mosloadposition', 'content', 0, 6, 1, 0, 0, 0, '0000-00-00 00:00:00', '');

-- --------------------------------------------------------

-- 
-- Structure de la table `jos_menu`
-- 

DROP TABLE IF EXISTS `jos_menu`;
CREATE TABLE IF NOT EXISTS `jos_menu` (
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
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=33 ;

-- 
-- Contenu de la table `jos_menu`
-- 

INSERT INTO `jos_menu` VALUES (1, 'mainmenu', 'Accueil', 'index.php?option=com_frontpage', 'components', 1, 0, 10, 0, 1, 0, '0000-00-00 00:00:00', 0, 0, 0, 3, 'leading=1\r\nintro=2\r\nlink=1\r\nimage=1\r\npage_title=0\r\nheader=Bienvenue sur la page d''accueil\r\norderby_sec=front\r\nprint=0\r\npdf=0\r\nemail=0\r\nback_button=0');
INSERT INTO `jos_menu` VALUES (2, 'mainmenu', 'News', 'index.php?option=com_content&task=section&id=1', 'content_section', 1, 0, 1, 0, 3, 0, '0000-00-00 00:00:00', 0, 0, 0, 3, '');
INSERT INTO `jos_menu` VALUES (3, 'mainmenu', 'Nous contacter', 'index.php?option=com_contact', 'components', 1, 0, 7, 0, 15, 0, '0000-00-00 00:00:00', 0, 0, 0, 3, '');
INSERT INTO `jos_menu` VALUES (23, 'mainmenu', 'Liens', 'index.php?option=com_weblinks', 'components', 1, 0, 4, 0, 14, 0, '0000-00-00 00:00:00', 0, 0, 0, 0, 'menu_image=web_links.jpg\npageclass_sfx=\nback_button=\npage_title=1\nheader=\nheadings=1\nhits=\nitem_description=1\nother_cat=1\ndescription=1\ndescription_text=\nimage=-1\nimage_align=right\nweblink_icons=');
INSERT INTO `jos_menu` VALUES (5, 'mainmenu', 'Rechercher', 'index.php?option=com_search', 'components', 0, 0, 16, 0, 5, 0, '0000-00-00 00:00:00', 0, 0, 0, 3, '');
INSERT INTO `jos_menu` VALUES (6, 'mainmenu', 'Licence Joomla!', 'index.php?option=com_content&task=view&id=5', 'content_typed', 0, 0, 5, 0, 2, 0, '0000-00-00 00:00:00', 0, 0, 0, 0, '');
INSERT INTO `jos_menu` VALUES (7, 'mainmenu', 'Flux RSS', 'index.php?option=com_newsfeeds', 'components', 0, 0, 12, 0, 6, 0, '0000-00-00 00:00:00', 0, 0, 0, 3, 'menu_image=-1\npageclass_sfx=\nback_button=\npage_title=1\nheader=');
INSERT INTO `jos_menu` VALUES (8, 'mainmenu', 'Wrapper', 'index.php?option=com_wrapper', 'wrapper', 0, 0, 0, 0, 8, 0, '0000-00-00 00:00:00', 0, 0, 0, 3, 'menu_image=-1\npageclass_sfx=\nback_button=\npage_title=1\nheader=\nscrolling=auto\nwidth=100%\nheight=600\nheight_auto=0\nurl=www.joomla.org');
INSERT INTO `jos_menu` VALUES (9, 'mainmenu', 'Blog', 'index.php?option=com_content&task=blogsection&id=0', 'content_blog_section', 0, 0, 0, 0, 4, 0, '0000-00-00 00:00:00', 0, 0, 0, 3, 'menu_image=-1\npageclass_sfx=\nback_button=\nheader=Affichage type blog de toutes les sections sans images\npage_title=1\nleading=0\nintro=6\ncolumns=2\nlink=4\norderby_pri=\norderby_sec=\npagination=2\npagination_results=1\nimage=0\ndescription=0\ndescription_image=0\ncategory=0\ncategory_link=0\nitem_title=1\nlink_titles=\nreadmore=\nrating=\nauthor=\ncreatedate=\nmodifydate=\npdf=\nprint=\nemail=\nsectionid=');
INSERT INTO `jos_menu` VALUES (10, 'othermenu', 'Site officiel Joomla!', 'http://www.joomla.org', 'url', 0, 0, 0, 0, 1, 0, '0000-00-00 00:00:00', 0, 0, 0, 3, '');
INSERT INTO `jos_menu` VALUES (11, 'othermenu', 'Forum officiel Joomla!', 'http://forum.joomla.org', 'url', 0, 0, 0, 0, 2, 0, '0000-00-00 00:00:00', 0, 0, 0, 3, '');
INSERT INTO `jos_menu` VALUES (12, 'othermenu', 'OpenSourceMatters', 'http://www.opensourcematters.org', 'url', 0, 0, 0, 0, 3, 0, '0000-00-00 00:00:00', 0, 0, 0, 3, '');
INSERT INTO `jos_menu` VALUES (24, 'othermenu', 'Administration du site', 'administrator/', 'url', 0, 0, 0, 0, 5, 0, '0000-00-00 00:00:00', 0, 0, 0, 3, 'menu_image=-1');
INSERT INTO `jos_menu` VALUES (21, 'usermenu', 'Votre profil', 'index.php?option=com_user&task=UserDetails', 'url', 1, 0, 0, 0, 1, 0, '0000-00-00 00:00:00', 0, 0, 1, 3, '');
INSERT INTO `jos_menu` VALUES (13, 'usermenu', 'Proposer une news', 'index.php?option=com_content&task=new&sectionid=1&Itemid=0', 'url', 1, 0, 0, 0, 2, 0, '0000-00-00 00:00:00', 0, 0, 1, 2, '');
INSERT INTO `jos_menu` VALUES (14, 'usermenu', 'Proposer un lien web', 'index.php?option=com_weblinks&task=new', 'url', 1, 0, 0, 0, 4, 0, '0000-00-00 00:00:00', 0, 0, 1, 2, '');
INSERT INTO `jos_menu` VALUES (15, 'usermenu', 'Vérifier vos articles', 'index.php?option=com_user&task=CheckIn', 'url', 1, 0, 0, 0, 5, 0, '0000-00-00 00:00:00', 0, 0, 1, 2, '');
INSERT INTO `jos_menu` VALUES (16, 'usermenu', 'D&eacute;connexion', 'index.php?option=com_login', 'components', 1, 0, 15, 0, 5, 0, '0000-00-00 00:00:00', 0, 0, 1, 3, '');
INSERT INTO `jos_menu` VALUES (17, 'topmenu', 'Accueil', 'index.php', 'url', 1, 0, 0, 0, 1, 0, '0000-00-00 00:00:00', 0, 0, 0, 3, '');
INSERT INTO `jos_menu` VALUES (18, 'topmenu', 'Nous contacter', 'index.php?option=com_contact&Itemid=3', 'url', 1, 0, 0, 0, 2, 0, '0000-00-00 00:00:00', 0, 0, 0, 3, '');
INSERT INTO `jos_menu` VALUES (19, 'topmenu', 'News', 'index.php?option=com_content&task=section&id=1&Itemid=2', 'url', 1, 0, 0, 0, 3, 0, '0000-00-00 00:00:00', 0, 0, 0, 3, '');
INSERT INTO `jos_menu` VALUES (20, 'topmenu', 'Liens', 'index.php?option=com_weblinks&Itemid=22', 'url', 1, 0, 0, 0, 4, 0, '0000-00-00 00:00:00', 0, 0, 0, 3, 'menu_image=-1');
INSERT INTO `jos_menu` VALUES (25, 'mainmenu', 'FAQs', 'index.php?option=com_content&task=category&sectionid=3&id=7', 'content_category', 0, 0, 7, 0, 7, 0, '0000-00-00 00:00:00', 0, 0, 0, 0, 'menu_image=-1\npage_title=1\npageclass_sfx=\nback_button=\norderby=\ndate_format=\ndate=\nauthor=\ntitle=1\nhits=\nheadings=1\nnavigation=1\norder_select=1\ndisplay=1\ndisplay_num=50\nfilter=1\nfilter_type=title\nother_cat=1\nempty_cat=0\ncat_items=1\ncat_description=1');
INSERT INTO `jos_menu` VALUES (26, 'othermenu', 'Portail Joomla.fr', 'http://www.joomla.fr', 'url', 0, 0, 0, 0, 4, 0, '0000-00-00 00:00:00', 0, 0, 0, 0, 'menu_image=-1');
INSERT INTO `jos_menu` VALUES (27, 'othermenu', 'F.F.E.', 'http://www.escrime-ffe.fr', 'url', 0, 0, 0, 0, 6, 0, '0000-00-00 00:00:00', 0, 0, 0, 0, 'menu_image=-1');
INSERT INTO `jos_menu` VALUES (28, 'mainmenu', 'Galleries Photos', 'http://lc78escrime.free.fr', 'url', 1, 0, 0, 0, 10, 0, '0000-00-00 00:00:00', 0, 0, 0, 0, 'menu_image=-1');
INSERT INTO `jos_menu` VALUES (29, 'mainmenu', 'Livre d''Or', 'index.php?option=com_easygb', 'components', 1, 0, 19, 0, 11, 0, '0000-00-00 00:00:00', 0, 0, 0, 0, '');
INSERT INTO `jos_menu` VALUES (30, 'mainmenu', 'Forum', 'index.php?option=com_joomlaboard', 'components', 0, 0, 25, 0, 12, 0, '0000-00-00 00:00:00', 0, 0, 0, 0, '');
INSERT INTO `jos_menu` VALUES (31, 'mainmenu', 'Carte du site', 'index.php?option=com_joomap', 'components', 1, 0, 26, 0, 13, 0, '0000-00-00 00:00:00', 0, 0, 0, 0, '');
INSERT INTO `jos_menu` VALUES (32, 'mainmenu', 'Encadrement', 'index.php?option=com_content&task=view&id=12', 'content_item_link', 1, 0, 12, 0, 9, 0, '0000-00-00 00:00:00', 0, 0, 0, 0, 'menu_image=-1\nunique_itemid=0');

-- --------------------------------------------------------

-- 
-- Structure de la table `jos_messages`
-- 

DROP TABLE IF EXISTS `jos_messages`;
CREATE TABLE IF NOT EXISTS `jos_messages` (
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
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- 
-- Contenu de la table `jos_messages`
-- 


-- --------------------------------------------------------

-- 
-- Structure de la table `jos_messages_cfg`
-- 

DROP TABLE IF EXISTS `jos_messages_cfg`;
CREATE TABLE IF NOT EXISTS `jos_messages_cfg` (
  `user_id` int(10) unsigned NOT NULL default '0',
  `cfg_name` varchar(100) NOT NULL default '',
  `cfg_value` varchar(255) NOT NULL default '',
  UNIQUE KEY `idx_user_var_name` (`user_id`,`cfg_name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- 
-- Contenu de la table `jos_messages_cfg`
-- 


-- --------------------------------------------------------

-- 
-- Structure de la table `jos_modules`
-- 

DROP TABLE IF EXISTS `jos_modules`;
CREATE TABLE IF NOT EXISTS `jos_modules` (
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
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=35 ;

-- 
-- Contenu de la table `jos_modules`
-- 

INSERT INTO `jos_modules` VALUES (1, 'Sondage', '', 1, 'right', 0, '0000-00-00 00:00:00', 0, 'mod_poll', 0, 0, 1, '', 0, 0);
INSERT INTO `jos_modules` VALUES (2, 'Menu utilisateur', '', 3, 'left', 0, '0000-00-00 00:00:00', 1, 'mod_mainmenu', 0, 1, 1, 'menutype=usermenu', 1, 0);
INSERT INTO `jos_modules` VALUES (3, 'Menu principal', '', 2, 'left', 0, '0000-00-00 00:00:00', 1, 'mod_mainmenu', 0, 0, 1, 'menutype=mainmenu', 1, 0);
INSERT INTO `jos_modules` VALUES (4, 'Identification', '', 5, 'left', 0, '0000-00-00 00:00:00', 1, 'mod_login', 0, 0, 1, '', 1, 0);
INSERT INTO `jos_modules` VALUES (5, 'Syndication', '', 6, 'left', 0, '0000-00-00 00:00:00', 0, 'mod_rssfeed', 0, 0, 1, '', 1, 0);
INSERT INTO `jos_modules` VALUES (6, 'Derniers articles', '', 4, 'user1', 0, '0000-00-00 00:00:00', 0, 'mod_latestnews', 0, 0, 1, '', 1, 0);
INSERT INTO `jos_modules` VALUES (7, 'Statistiques', '', 4, 'right', 0, '0000-00-00 00:00:00', 1, 'mod_stats', 0, 0, 1, 'serverinfo=0\nsiteinfo=0\ncounter=1\nincrease=1\nmoduleclass_sfx=', 0, 0);
INSERT INTO `jos_modules` VALUES (8, 'Qui est en ligne', '', 2, 'right', 0, '0000-00-00 00:00:00', 1, 'mod_whosonline', 0, 0, 1, 'showmode=0\nmoduleclass_sfx=', 0, 0);
INSERT INTO `jos_modules` VALUES (9, 'Articles les plus lus', '', 6, 'user2', 0, '0000-00-00 00:00:00', 0, 'mod_mostread', 0, 0, 1, '', 0, 0);
INSERT INTO `jos_modules` VALUES (10, 'Sélecteur de template', '', 8, 'left', 0, '0000-00-00 00:00:00', 0, 'mod_templatechooser', 0, 0, 1, 'show_preview=1', 0, 0);
INSERT INTO `jos_modules` VALUES (11, 'Archive', '', 9, 'left', 0, '0000-00-00 00:00:00', 0, 'mod_archive', 0, 0, 1, '', 1, 0);
INSERT INTO `jos_modules` VALUES (12, 'Sections', '', 10, 'left', 0, '0000-00-00 00:00:00', 0, 'mod_sections', 0, 0, 1, '', 1, 0);
INSERT INTO `jos_modules` VALUES (13, 'Flash info', '', 1, 'top', 0, '0000-00-00 00:00:00', 1, 'mod_newsflash', 0, 0, 1, 'catid=3\r\nstyle=random\r\nitems=\r\nmoduleclass_sfx=', 0, 0);
INSERT INTO `jos_modules` VALUES (14, 'Articles similaires', '', 11, 'left', 0, '0000-00-00 00:00:00', 0, 'mod_related_items', 0, 0, 1, '', 0, 0);
INSERT INTO `jos_modules` VALUES (15, 'Recherche', '', 1, 'user4', 0, '0000-00-00 00:00:00', 0, 'mod_search', 0, 0, 0, '', 0, 0);
INSERT INTO `jos_modules` VALUES (16, 'Image aléatoire', '', 5, 'right', 0, '0000-00-00 00:00:00', 1, 'mod_random_image', 0, 0, 1, '', 0, 0);
INSERT INTO `jos_modules` VALUES (17, 'Menu top', '', 1, 'user3', 0, '0000-00-00 00:00:00', 1, 'mod_mainmenu', 0, 0, 0, 'menutype=topmenu\nmenu_style=list_flat\nmenu_images=n\nmenu_images_align=left\nexpand_menu=n\nclass_sfx=-nav\nmoduleclass_sfx=\nindent_image1=0\nindent_image2=0\nindent_image3=0\nindent_image4=0\nindent_image5=0\nindent_image6=0', 1, 0);
INSERT INTO `jos_modules` VALUES (18, 'Bannières', '', 1, 'banner', 0, '0000-00-00 00:00:00', 0, 'mod_banners', 0, 0, 0, 'banner_cids=\nmoduleclass_sfx=\n', 1, 0);
INSERT INTO `jos_modules` VALUES (19, 'Composants', '', 2, 'cpanel', 0, '0000-00-00 00:00:00', 1, 'mod_components', 0, 99, 1, '', 1, 1);
INSERT INTO `jos_modules` VALUES (20, 'Les plus lus', '', 3, 'cpanel', 0, '0000-00-00 00:00:00', 1, 'mod_popular', 0, 99, 1, '', 0, 1);
INSERT INTO `jos_modules` VALUES (21, 'Derniers articles', '', 4, 'cpanel', 0, '0000-00-00 00:00:00', 1, 'mod_latest', 0, 99, 1, '', 0, 1);
INSERT INTO `jos_modules` VALUES (22, 'Stats des menus', '', 5, 'cpanel', 0, '0000-00-00 00:00:00', 1, 'mod_stats', 0, 99, 1, '', 0, 1);
INSERT INTO `jos_modules` VALUES (23, 'Messages non lus', '', 1, 'header', 0, '0000-00-00 00:00:00', 1, 'mod_unread', 0, 99, 1, '', 1, 1);
INSERT INTO `jos_modules` VALUES (24, 'Utilisateurs en ligne', '', 2, 'header', 0, '0000-00-00 00:00:00', 1, 'mod_online', 0, 99, 1, '', 1, 1);
INSERT INTO `jos_modules` VALUES (25, 'Menu entier', '', 1, 'top', 0, '0000-00-00 00:00:00', 1, 'mod_fullmenu', 0, 99, 1, '', 1, 1);
INSERT INTO `jos_modules` VALUES (26, 'Chemin', '', 1, 'pathway', 0, '0000-00-00 00:00:00', 1, 'mod_pathway', 0, 99, 1, '', 1, 1);
INSERT INTO `jos_modules` VALUES (27, 'Barre d&#146;outils', '', 1, 'toolbar', 0, '0000-00-00 00:00:00', 1, 'mod_toolbar', 0, 99, 1, '', 1, 1);
INSERT INTO `jos_modules` VALUES (28, 'Message système', '', 1, 'inset', 0, '0000-00-00 00:00:00', 1, 'mod_mosmsg', 0, 99, 1, '', 1, 1);
INSERT INTO `jos_modules` VALUES (29, 'Icônes raccourcis', '', 1, 'icon', 0, '0000-00-00 00:00:00', 1, 'mod_quickicon', 0, 99, 1, '', 1, 1);
INSERT INTO `jos_modules` VALUES (30, 'Autre menu', '', 4, 'left', 0, '0000-00-00 00:00:00', 1, 'mod_mainmenu', 0, 0, 0, 'menutype=othermenu\nmenu_style=vert_indent\ncache=0\nmenu_images=0\nmenu_images_align=0\nexpand_menu=0\nclass_sfx=\nmoduleclass_sfx=\nindent_image=0\nindent_image1=\nindent_image2=\nindent_image3=\nindent_image4=\nindent_image5=\nindent_image6=', 0, 0);
INSERT INTO `jos_modules` VALUES (31, 'Wrapper', '', 12, 'left', 0, '0000-00-00 00:00:00', 0, 'mod_wrapper', 0, 0, 1, '', 0, 0);
INSERT INTO `jos_modules` VALUES (32, 'Connectés', '', 0, 'cpanel', 0, '0000-00-00 00:00:00', 1, 'mod_logged', 0, 99, 1, '', 0, 1);
INSERT INTO `jos_modules` VALUES (33, 'JoomlaStats Activation Module', '', 13, 'left', 0, '0000-00-00 00:00:00', 0, 'mod_jstats_activate', 0, 0, 1, '', 0, 0);
INSERT INTO `jos_modules` VALUES (34, 'Flash SlideShow', '', 3, 'right', 62, '2007-08-16 17:08:02', 1, 'mod_slideshow', 0, 0, 0, 'moduleclass_sfx=\nid=\nimagepath=/slideshow/\nimage=\nstretchMethode=inner\nrandom=1\nwidth=150\nheight=200\nbackground=0x000000\ntemplate=tpl_default.swf\nshowcontrols=0\nautoplay=1\nBlinds=Blinds\nFade=Fade\nFly=Fly\nIris=Iris\nPhoto=Photo\nPixelDissolve=PixelDissolve\nRotate=0\nSqueeze=Squeeze\nWipe=Wipe\nZoom=0\ntransduration=1\ndelay=5\ndefaultText=', 0, 0);

-- --------------------------------------------------------

-- 
-- Structure de la table `jos_modules_menu`
-- 

DROP TABLE IF EXISTS `jos_modules_menu`;
CREATE TABLE IF NOT EXISTS `jos_modules_menu` (
  `moduleid` int(11) NOT NULL default '0',
  `menuid` int(11) NOT NULL default '0',
  PRIMARY KEY  (`moduleid`,`menuid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- 
-- Contenu de la table `jos_modules_menu`
-- 

INSERT INTO `jos_modules_menu` VALUES (1, 1);
INSERT INTO `jos_modules_menu` VALUES (2, 0);
INSERT INTO `jos_modules_menu` VALUES (3, 0);
INSERT INTO `jos_modules_menu` VALUES (4, 1);
INSERT INTO `jos_modules_menu` VALUES (5, 1);
INSERT INTO `jos_modules_menu` VALUES (6, 1);
INSERT INTO `jos_modules_menu` VALUES (6, 2);
INSERT INTO `jos_modules_menu` VALUES (6, 4);
INSERT INTO `jos_modules_menu` VALUES (6, 27);
INSERT INTO `jos_modules_menu` VALUES (6, 36);
INSERT INTO `jos_modules_menu` VALUES (7, 0);
INSERT INTO `jos_modules_menu` VALUES (8, 1);
INSERT INTO `jos_modules_menu` VALUES (9, 1);
INSERT INTO `jos_modules_menu` VALUES (9, 2);
INSERT INTO `jos_modules_menu` VALUES (9, 4);
INSERT INTO `jos_modules_menu` VALUES (9, 27);
INSERT INTO `jos_modules_menu` VALUES (9, 36);
INSERT INTO `jos_modules_menu` VALUES (10, 1);
INSERT INTO `jos_modules_menu` VALUES (13, 0);
INSERT INTO `jos_modules_menu` VALUES (15, 0);
INSERT INTO `jos_modules_menu` VALUES (17, 0);
INSERT INTO `jos_modules_menu` VALUES (18, 0);
INSERT INTO `jos_modules_menu` VALUES (30, 0);
INSERT INTO `jos_modules_menu` VALUES (33, 0);
INSERT INTO `jos_modules_menu` VALUES (34, 0);

-- --------------------------------------------------------

-- 
-- Structure de la table `jos_newsfeeds`
-- 

DROP TABLE IF EXISTS `jos_newsfeeds`;
CREATE TABLE IF NOT EXISTS `jos_newsfeeds` (
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
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=12 ;

-- 
-- Contenu de la table `jos_newsfeeds`
-- 

INSERT INTO `jos_newsfeeds` VALUES (4, 1, 'Joomla! - Official News', 'http://www.joomla.org/index.php?option=com_rss_xtd&feed=RSS2.0&type=com_frontpage&Itemid=1', '', 1, 5, 3600, 0, '0000-00-00 00:00:00', 8);
INSERT INTO `jos_newsfeeds` VALUES (4, 2, 'Joomla! - Community News', 'http://www.joomla.org/index.php?option=com_rss_xtd&feed=RSS2.0&type=com_content&task=blogcategory&id=0&Itemid=33', '', 1, 5, 3600, 0, '0000-00-00 00:00:00', 9);
INSERT INTO `jos_newsfeeds` VALUES (10, 4, 'Linux Today', 'http://linuxtoday.com/backend/my-netscape.rdf', '', 1, 3, 3600, 0, '0000-00-00 00:00:00', 1);
INSERT INTO `jos_newsfeeds` VALUES (5, 5, 'Business News', 'http://headlines.internet.com/internetnews/bus-news/news.rss', '', 1, 3, 3600, 0, '0000-00-00 00:00:00', 2);
INSERT INTO `jos_newsfeeds` VALUES (11, 6, 'Web Developer News', 'http://headlines.internet.com/internetnews/wd-news/news.rss', '', 1, 3, 3600, 0, '0000-00-00 00:00:00', 3);
INSERT INTO `jos_newsfeeds` VALUES (10, 7, 'Linux Central:New Products', 'http://linuxcentral.com/backend/lcnew.rdf', '', 1, 3, 3600, 0, '0000-00-00 00:00:00', 4);
INSERT INTO `jos_newsfeeds` VALUES (10, 8, 'Linux Central:Best Selling', 'http://linuxcentral.com/backend/lcbestns.rdf', '', 1, 3, 3600, 0, '0000-00-00 00:00:00', 5);
INSERT INTO `jos_newsfeeds` VALUES (10, 9, 'Linux Central:Daily Specials', 'http://linuxcentral.com/backend/lcspecialns.rdf', '', 1, 3, 3600, 0, '0000-00-00 00:00:00', 6);
INSERT INTO `jos_newsfeeds` VALUES (9, 10, 'Internet:Finance News', 'http://headlines.internet.com/internetnews/fina-news/news.rss', '', 1, 3, 3600, 0, '0000-00-00 00:00:00', 7);
INSERT INTO `jos_newsfeeds` VALUES (4, 11, 'Joomla.fr', 'http://www.joomla.fr/index2.php?option=com_rss&feed=RSS2.0&no_html=1', NULL, 1, 5, 3600, 0, '0000-00-00 00:00:00', 1);

-- --------------------------------------------------------

-- 
-- Structure de la table `jos_poll_data`
-- 

DROP TABLE IF EXISTS `jos_poll_data`;
CREATE TABLE IF NOT EXISTS `jos_poll_data` (
  `id` int(11) NOT NULL auto_increment,
  `pollid` int(4) NOT NULL default '0',
  `text` text NOT NULL,
  `hits` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `pollid` (`pollid`,`text`(1))
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=13 ;

-- 
-- Contenu de la table `jos_poll_data`
-- 

INSERT INTO `jos_poll_data` VALUES (1, 14, 'Bien mieux... Pourquoi elle est pas arrivée plus tôt ?', 0);
INSERT INTO `jos_poll_data` VALUES (2, 14, 'agréable à visiter.', 0);
INSERT INTO `jos_poll_data` VALUES (3, 14, 'Peut mieux faire !', 0);
INSERT INTO `jos_poll_data` VALUES (4, 14, 'minable... On veut revenir sur l\\''ancienne version !', 0);
INSERT INTO `jos_poll_data` VALUES (5, 14, 'Aucune idée, je ne connaissais pas la version précédente', 0);
INSERT INTO `jos_poll_data` VALUES (6, 14, '', 0);
INSERT INTO `jos_poll_data` VALUES (7, 14, '', 0);
INSERT INTO `jos_poll_data` VALUES (8, 14, '', 0);
INSERT INTO `jos_poll_data` VALUES (9, 14, '', 0);
INSERT INTO `jos_poll_data` VALUES (10, 14, '', 0);
INSERT INTO `jos_poll_data` VALUES (11, 14, '', 0);
INSERT INTO `jos_poll_data` VALUES (12, 14, '', 0);

-- --------------------------------------------------------

-- 
-- Structure de la table `jos_poll_date`
-- 

DROP TABLE IF EXISTS `jos_poll_date`;
CREATE TABLE IF NOT EXISTS `jos_poll_date` (
  `id` bigint(20) NOT NULL auto_increment,
  `date` datetime NOT NULL default '0000-00-00 00:00:00',
  `vote_id` int(11) NOT NULL default '0',
  `poll_id` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `poll_id` (`poll_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- 
-- Contenu de la table `jos_poll_date`
-- 


-- --------------------------------------------------------

-- 
-- Structure de la table `jos_poll_menu`
-- 

DROP TABLE IF EXISTS `jos_poll_menu`;
CREATE TABLE IF NOT EXISTS `jos_poll_menu` (
  `pollid` int(11) NOT NULL default '0',
  `menuid` int(11) NOT NULL default '0',
  PRIMARY KEY  (`pollid`,`menuid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- 
-- Contenu de la table `jos_poll_menu`
-- 

INSERT INTO `jos_poll_menu` VALUES (14, 1);

-- --------------------------------------------------------

-- 
-- Structure de la table `jos_polls`
-- 

DROP TABLE IF EXISTS `jos_polls`;
CREATE TABLE IF NOT EXISTS `jos_polls` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `title` varchar(100) NOT NULL default '',
  `voters` int(9) NOT NULL default '0',
  `checked_out` int(11) NOT NULL default '0',
  `checked_out_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `published` tinyint(1) NOT NULL default '0',
  `access` int(11) NOT NULL default '0',
  `lag` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=15 ;

-- 
-- Contenu de la table `jos_polls`
-- 

INSERT INTO `jos_polls` VALUES (14, 'Cette nouvelle version du site est ...', 0, 0, '0000-00-00 00:00:00', 0, 0, 86400);

-- --------------------------------------------------------

-- 
-- Structure de la table `jos_sb_attachments`
-- 

DROP TABLE IF EXISTS `jos_sb_attachments`;
CREATE TABLE IF NOT EXISTS `jos_sb_attachments` (
  `mesid` int(11) NOT NULL default '0',
  `filelocation` text NOT NULL,
  KEY `mesid` (`mesid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- 
-- Contenu de la table `jos_sb_attachments`
-- 


-- --------------------------------------------------------

-- 
-- Structure de la table `jos_sb_categories`
-- 

DROP TABLE IF EXISTS `jos_sb_categories`;
CREATE TABLE IF NOT EXISTS `jos_sb_categories` (
  `id` int(11) NOT NULL auto_increment,
  `parent` int(11) default '0',
  `name` tinytext,
  `cat_emoticon` tinyint(4) NOT NULL default '0',
  `locked` tinyint(4) NOT NULL default '0',
  `alert_admin` tinyint(4) NOT NULL default '0',
  `moderated` tinyint(4) NOT NULL default '0',
  `moderators` varchar(15) default NULL,
  `pub_access` tinyint(4) default '1',
  `pub_recurse` tinyint(4) default '1',
  `admin_access` tinyint(4) default '0',
  `admin_recurse` tinyint(4) default '1',
  `ordering` tinyint(4) NOT NULL default '0',
  `future2` int(11) default '0',
  `published` tinyint(4) NOT NULL default '0',
  `checked_out` tinyint(4) NOT NULL default '0',
  `checked_out_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `review` tinyint(4) NOT NULL default '0',
  `hits` int(11) NOT NULL default '0',
  `description` text NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `published_pubaccess_id` (`published`,`pub_access`,`id`),
  KEY `catparent` (`parent`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

-- 
-- Contenu de la table `jos_sb_categories`
-- 

INSERT INTO `jos_sb_categories` VALUES (1, 0, 'Forum Category', 0, 0, 0, 0, NULL, 0, 0, 0, 0, 1, 0, 1, 0, '0000-00-00 00:00:00', 0, 0, '');
INSERT INTO `jos_sb_categories` VALUES (2, 1, 'Forum 1', 0, 0, 0, 0, NULL, 0, 0, 0, 0, 1, 0, 1, 0, '0000-00-00 00:00:00', 0, 0, 'Sample Forum 1\r\n');

-- --------------------------------------------------------

-- 
-- Structure de la table `jos_sb_config`
-- 

DROP TABLE IF EXISTS `jos_sb_config`;
CREATE TABLE IF NOT EXISTS `jos_sb_config` (
  `jbkey` tinytext NOT NULL,
  `jbvalue` tinytext NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- 
-- Contenu de la table `jos_sb_config`
-- 

INSERT INTO `jos_sb_config` VALUES ('board_title', 'Forum du LC78-Escrime');
INSERT INTO `jos_sb_config` VALUES ('email', 'forum@lc78-escrime.com');
INSERT INTO `jos_sb_config` VALUES ('board_offline', '0');
INSERT INTO `jos_sb_config` VALUES ('board_ofset', '7');
INSERT INTO `jos_sb_config` VALUES ('offline_message', '<h2>The Forum is currently offline for maintenance.</h2>\r\n\r\nCheck back soon!');
INSERT INTO `jos_sb_config` VALUES ('default_view', 'flat');
INSERT INTO `jos_sb_config` VALUES ('enableRSS', '1');
INSERT INTO `jos_sb_config` VALUES ('enablePDF', '0');
INSERT INTO `jos_sb_config` VALUES ('threads_per_page', '15');
INSERT INTO `jos_sb_config` VALUES ('messages_per_page', '6');
INSERT INTO `jos_sb_config` VALUES ('showHistory', '1');
INSERT INTO `jos_sb_config` VALUES ('historyLimit', '6');
INSERT INTO `jos_sb_config` VALUES ('showNew', '1');
INSERT INTO `jos_sb_config` VALUES ('newChar', '!');
INSERT INTO `jos_sb_config` VALUES ('disemoticons', '0');
INSERT INTO `jos_sb_config` VALUES ('template', 'default');
INSERT INTO `jos_sb_config` VALUES ('rtewidth', '450');
INSERT INTO `jos_sb_config` VALUES ('rteheight', '300');
INSERT INTO `jos_sb_config` VALUES ('enableRulesPage', '1');
INSERT INTO `jos_sb_config` VALUES ('enableStatsPage', '0');
INSERT INTO `jos_sb_config` VALUES ('enableForumJump', '1');
INSERT INTO `jos_sb_config` VALUES ('username', '1');
INSERT INTO `jos_sb_config` VALUES ('askemail', '0');
INSERT INTO `jos_sb_config` VALUES ('showemail', '0');
INSERT INTO `jos_sb_config` VALUES ('showstats', '1');
INSERT INTO `jos_sb_config` VALUES ('postStats', '1');
INSERT INTO `jos_sb_config` VALUES ('statsColor', '9');
INSERT INTO `jos_sb_config` VALUES ('showkarma', '1');
INSERT INTO `jos_sb_config` VALUES ('useredit', '1');
INSERT INTO `jos_sb_config` VALUES ('editMarkUp', '1');
INSERT INTO `jos_sb_config` VALUES ('allowsubscriptions', '1');
INSERT INTO `jos_sb_config` VALUES ('wrap', '100');
INSERT INTO `jos_sb_config` VALUES ('maxSubject', '50');
INSERT INTO `jos_sb_config` VALUES ('maxSig', '300');
INSERT INTO `jos_sb_config` VALUES ('regonly', '0');
INSERT INTO `jos_sb_config` VALUES ('changename', '0');
INSERT INTO `jos_sb_config` VALUES ('pubwrite', '1');
INSERT INTO `jos_sb_config` VALUES ('floodprotection', '0');
INSERT INTO `jos_sb_config` VALUES ('mailmod', '1');
INSERT INTO `jos_sb_config` VALUES ('allowAvatar', '1');
INSERT INTO `jos_sb_config` VALUES ('allowAvatarUpload', '1');
INSERT INTO `jos_sb_config` VALUES ('allowAvatarGallery', '1');
INSERT INTO `jos_sb_config` VALUES ('avatarHeight', '70');
INSERT INTO `jos_sb_config` VALUES ('avatarWidth', '70');
INSERT INTO `jos_sb_config` VALUES ('avatarSize', '40');
INSERT INTO `jos_sb_config` VALUES ('allowImageUpload', '0');
INSERT INTO `jos_sb_config` VALUES ('allowImageRegUpload', '1');
INSERT INTO `jos_sb_config` VALUES ('imageHeight', '499');
INSERT INTO `jos_sb_config` VALUES ('imageWidth', '499');
INSERT INTO `jos_sb_config` VALUES ('imageSize', '50');
INSERT INTO `jos_sb_config` VALUES ('allowFileUpload', '0');
INSERT INTO `jos_sb_config` VALUES ('allowFileRegUpload', '1');
INSERT INTO `jos_sb_config` VALUES ('fileTypes', 'zip,txt,doc,gz');
INSERT INTO `jos_sb_config` VALUES ('fileSize', '65');
INSERT INTO `jos_sb_config` VALUES ('showranking', '1');
INSERT INTO `jos_sb_config` VALUES ('rankimages', '1');
INSERT INTO `jos_sb_config` VALUES ('rank1', '20');
INSERT INTO `jos_sb_config` VALUES ('rank1txt', 'De passage');
INSERT INTO `jos_sb_config` VALUES ('rank2', '50');
INSERT INTO `jos_sb_config` VALUES ('rank2txt', 'Bavard');
INSERT INTO `jos_sb_config` VALUES ('rank3', '100');
INSERT INTO `jos_sb_config` VALUES ('rank3txt', 'Accro');
INSERT INTO `jos_sb_config` VALUES ('rank4', '200');
INSERT INTO `jos_sb_config` VALUES ('rank4txt', 'Dort sur place');
INSERT INTO `jos_sb_config` VALUES ('rank5', '500');
INSERT INTO `jos_sb_config` VALUES ('rank5txt', 'Fait parti des meubles');
INSERT INTO `jos_sb_config` VALUES ('rank6txt', 'Ne décroche pas du clavier');
INSERT INTO `jos_sb_config` VALUES ('avatar_src', 'sb');
INSERT INTO `jos_sb_config` VALUES ('pm_component', 'no');
INSERT INTO `jos_sb_config` VALUES ('cb_profile', '0');
INSERT INTO `jos_sb_config` VALUES ('badwords', '0');
INSERT INTO `jos_sb_config` VALUES ('discussBot', '1');
INSERT INTO `jos_sb_config` VALUES ('version', '1.1.5');

-- --------------------------------------------------------

-- 
-- Structure de la table `jos_sb_messages`
-- 

DROP TABLE IF EXISTS `jos_sb_messages`;
CREATE TABLE IF NOT EXISTS `jos_sb_messages` (
  `id` int(11) NOT NULL auto_increment,
  `parent` int(11) default '0',
  `thread` int(11) default '0',
  `catid` int(11) NOT NULL default '0',
  `name` tinytext,
  `userid` int(11) NOT NULL default '0',
  `email` tinytext,
  `subject` tinytext,
  `time` int(11) NOT NULL default '0',
  `ip` varchar(15) default NULL,
  `topic_emoticon` int(11) NOT NULL default '0',
  `locked` tinyint(4) NOT NULL default '0',
  `hold` tinyint(4) NOT NULL default '0',
  `ordering` int(11) default '0',
  `hits` int(11) default '0',
  `moved` tinyint(4) default '0',
  PRIMARY KEY  (`id`),
  KEY `thread` (`thread`),
  KEY `parent` (`parent`),
  KEY `catid` (`catid`),
  KEY `ip` (`ip`),
  KEY `userid` (`userid`),
  KEY `hold_time` (`hold`,`time`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

-- 
-- Contenu de la table `jos_sb_messages`
-- 

INSERT INTO `jos_sb_messages` VALUES (1, 0, 1, 2, 'tsmf', 0, 'jan@tsmf-mambo.com', 'Sample Post 1', 1075387732, '127.0.0.1', 0, 0, 0, 0, 4, 0);
INSERT INTO `jos_sb_messages` VALUES (2, 1, 1, 2, 'toto', 0, 'anonymous@forum.here', 'Re:Sample Post 1', 1181159193, '127.0.0.1', 0, 0, 0, 0, 0, 0);

-- --------------------------------------------------------

-- 
-- Structure de la table `jos_sb_messages_text`
-- 

DROP TABLE IF EXISTS `jos_sb_messages_text`;
CREATE TABLE IF NOT EXISTS `jos_sb_messages_text` (
  `mesid` int(11) NOT NULL default '0',
  `message` text NOT NULL,
  PRIMARY KEY  (`mesid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- 
-- Contenu de la table `jos_sb_messages_text`
-- 

INSERT INTO `jos_sb_messages_text` VALUES (1, '[b][size=4][color=#FF6600]Sample Post[/color][/size][/b]\nCongratulations with your new Forum!\n\n[url=http://tsmf.jigsnet.com]-The TSMF Team[/url]');
INSERT INTO `jos_sb_messages_text` VALUES (2, 'test test');

-- --------------------------------------------------------

-- 
-- Structure de la table `jos_sb_moderation`
-- 

DROP TABLE IF EXISTS `jos_sb_moderation`;
CREATE TABLE IF NOT EXISTS `jos_sb_moderation` (
  `catid` int(11) NOT NULL default '0',
  `userid` int(11) NOT NULL default '0',
  `future1` tinyint(4) default '0',
  `future2` int(11) default '0',
  PRIMARY KEY  (`catid`,`userid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- 
-- Contenu de la table `jos_sb_moderation`
-- 


-- --------------------------------------------------------

-- 
-- Structure de la table `jos_sb_sessions`
-- 

DROP TABLE IF EXISTS `jos_sb_sessions`;
CREATE TABLE IF NOT EXISTS `jos_sb_sessions` (
  `userid` int(11) NOT NULL default '0',
  `allowed` text,
  `lasttime` int(11) NOT NULL default '0',
  `readtopics` text,
  PRIMARY KEY  (`userid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- 
-- Contenu de la table `jos_sb_sessions`
-- 

INSERT INTO `jos_sb_sessions` VALUES (0, '1,2', 1181133088, '');

-- --------------------------------------------------------

-- 
-- Structure de la table `jos_sb_smileys`
-- 

DROP TABLE IF EXISTS `jos_sb_smileys`;
CREATE TABLE IF NOT EXISTS `jos_sb_smileys` (
  `id` int(4) NOT NULL auto_increment,
  `code` varchar(12) NOT NULL default '',
  `location` varchar(50) NOT NULL default '',
  `greylocation` varchar(60) NOT NULL default '',
  `emoticonbar` tinyint(4) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=38 ;

-- 
-- Contenu de la table `jos_sb_smileys`
-- 

INSERT INTO `jos_sb_smileys` VALUES (1, 'B)', 'cool.png', 'cool-grey.png', 1);
INSERT INTO `jos_sb_smileys` VALUES (8, ';)', 'wink.png', 'wink-grey.png', 1);
INSERT INTO `jos_sb_smileys` VALUES (3, ':)', 'smile.png', 'smile-grey.png', 1);
INSERT INTO `jos_sb_smileys` VALUES (10, ':P', 'tongue.png', 'tongue-grey.png', 1);
INSERT INTO `jos_sb_smileys` VALUES (6, ':laugh:', 'laughing.png', 'laughing-grey.png', 1);
INSERT INTO `jos_sb_smileys` VALUES (17, ':ohmy:', 'shocked.png', 'shocked-grey.png', 1);
INSERT INTO `jos_sb_smileys` VALUES (22, ':sick:', 'sick.png', 'sick-grey.png', 1);
INSERT INTO `jos_sb_smileys` VALUES (14, ':angry:', 'angry.png', 'angry-grey.png', 1);
INSERT INTO `jos_sb_smileys` VALUES (25, ':blink:', 'blink.png', 'blink-grey.png', 1);
INSERT INTO `jos_sb_smileys` VALUES (2, ':(', 'sad.png', 'sad-grey.png', 1);
INSERT INTO `jos_sb_smileys` VALUES (16, ':unsure:', 'unsure.png', 'unsure-grey.png', 1);
INSERT INTO `jos_sb_smileys` VALUES (27, ':kiss:', 'kissing.png', 'kissing-grey.png', 1);
INSERT INTO `jos_sb_smileys` VALUES (29, ':woohoo:', 'w00t.png', 'w00t-grey.png', 1);
INSERT INTO `jos_sb_smileys` VALUES (21, ':lol:', 'grin.png', 'grin-grey.png', 1);
INSERT INTO `jos_sb_smileys` VALUES (23, ':silly:', 'silly.png', 'silly-grey.png', 1);
INSERT INTO `jos_sb_smileys` VALUES (35, ':pinch:', 'pinch.png', 'pinch-grey.png', 1);
INSERT INTO `jos_sb_smileys` VALUES (30, ':side:', 'sideways.png', 'sideways-grey.png', 1);
INSERT INTO `jos_sb_smileys` VALUES (34, ':whistle:', 'whistling.png', 'whistling-grey.png', 1);
INSERT INTO `jos_sb_smileys` VALUES (33, ':evil:', 'devil.png', 'devil-grey.png', 1);
INSERT INTO `jos_sb_smileys` VALUES (31, ':S', 'dizzy.png', 'dizzy-grey.png', 1);
INSERT INTO `jos_sb_smileys` VALUES (26, ':blush:', 'blush.png', 'blush-grey.png', 1);
INSERT INTO `jos_sb_smileys` VALUES (7, ':cheer:', 'cheerful.png', 'cheerful-grey.png', 1);
INSERT INTO `jos_sb_smileys` VALUES (18, ':huh:', 'wassat.png', 'wassat-grey.png', 1);
INSERT INTO `jos_sb_smileys` VALUES (19, ':dry:', 'ermm.png', 'ermm-grey.png', 1);
INSERT INTO `jos_sb_smileys` VALUES (4, ':-)', 'smile.png', 'smile-grey.png', 0);
INSERT INTO `jos_sb_smileys` VALUES (5, ':-(', 'sad.png', 'sad-grey.png', 0);
INSERT INTO `jos_sb_smileys` VALUES (9, ';-)', 'wink.png', 'wink-grey.png', 0);
INSERT INTO `jos_sb_smileys` VALUES (37, ':D', 'laughing.png', 'laughing-grey.png', 0);
INSERT INTO `jos_sb_smileys` VALUES (12, ':X', 'sick.png', 'sick-grey.png', 0);
INSERT INTO `jos_sb_smileys` VALUES (13, ':x', 'sick.png', 'sick-grey.png', 0);
INSERT INTO `jos_sb_smileys` VALUES (15, ':mad:', 'angry.png', 'angry-grey.png', 0);
INSERT INTO `jos_sb_smileys` VALUES (20, ':ermm:', 'ermm.png', 'ermm-grey.png', 0);
INSERT INTO `jos_sb_smileys` VALUES (24, ':y32b4:', 'silly.png', 'silly-grey.png', 0);
INSERT INTO `jos_sb_smileys` VALUES (28, ':rolleyes:', 'blink.png', 'blink-grey.png', 0);
INSERT INTO `jos_sb_smileys` VALUES (32, ':s', 'dizzy.png', 'dizzy-grey.png', 0);
INSERT INTO `jos_sb_smileys` VALUES (36, ':p', 'tongue.png', 'tongue-grey.png', 0);

-- --------------------------------------------------------

-- 
-- Structure de la table `jos_sb_subscriptions`
-- 

DROP TABLE IF EXISTS `jos_sb_subscriptions`;
CREATE TABLE IF NOT EXISTS `jos_sb_subscriptions` (
  `thread` int(11) NOT NULL default '0',
  `userid` int(11) NOT NULL default '0',
  `future1` int(11) default '0',
  KEY `thread` (`thread`),
  KEY `userid` (`userid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- 
-- Contenu de la table `jos_sb_subscriptions`
-- 


-- --------------------------------------------------------

-- 
-- Structure de la table `jos_sb_users`
-- 

DROP TABLE IF EXISTS `jos_sb_users`;
CREATE TABLE IF NOT EXISTS `jos_sb_users` (
  `userid` int(11) NOT NULL default '0',
  `view` varchar(8) NOT NULL default 'flat',
  `signature` text,
  `moderator` int(11) default '0',
  `ordering` int(11) default '0',
  `posts` int(11) default '0',
  `avatar` varchar(50) default NULL,
  `karma` int(11) default '0',
  `karma_time` int(11) default '0',
  PRIMARY KEY  (`userid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- 
-- Contenu de la table `jos_sb_users`
-- 


-- --------------------------------------------------------

-- 
-- Structure de la table `jos_sections`
-- 

DROP TABLE IF EXISTS `jos_sections`;
CREATE TABLE IF NOT EXISTS `jos_sections` (
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
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

-- 
-- Contenu de la table `jos_sections`
-- 

INSERT INTO `jos_sections` VALUES (1, 'News', 'Les News', 'articles.jpg', 'content', 'right', 'Sélectionner une catégorie de news dans la liste ci-dessous.', 1, 0, '0000-00-00 00:00:00', 1, 0, 1, '');
INSERT INTO `jos_sections` VALUES (2, 'Newsflashes', 'Newsflashes', '', 'content', 'left', '', 1, 0, '0000-00-00 00:00:00', 2, 0, 1, '');
INSERT INTO `jos_sections` VALUES (3, 'FAQs', 'Foire Aux Questions', 'pastarchives.jpg', 'content', 'left', 'Sélectionner une catégorie de news dans la liste ci-dessous pour consulter..', 1, 0, '0000-00-00 00:00:00', 2, 0, 1, '');

-- --------------------------------------------------------

-- 
-- Structure de la table `jos_session`
-- 

DROP TABLE IF EXISTS `jos_session`;
CREATE TABLE IF NOT EXISTS `jos_session` (
  `username` varchar(50) default '',
  `time` varchar(14) default '',
  `session_id` varchar(200) NOT NULL default '0',
  `guest` tinyint(4) default '1',
  `userid` int(11) default '0',
  `usertype` varchar(50) default '',
  `gid` tinyint(3) unsigned NOT NULL default '0',
  PRIMARY KEY  (`session_id`),
  KEY `whosonline` (`guest`,`usertype`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- 
-- Contenu de la table `jos_session`
-- 

INSERT INTO `jos_session` VALUES ('', '1187277610', 'fa96e1faba15032e600b9b78e068b212', 1, 0, '', 0);
INSERT INTO `jos_session` VALUES ('admin', '1187276882', '9c9715d97b058a7f2d84207c24eadb8f', 1, 62, 'Super Administrator', 0);

-- --------------------------------------------------------

-- 
-- Structure de la table `jos_siteftpaccnt`
-- 

DROP TABLE IF EXISTS `jos_siteftpaccnt`;
CREATE TABLE IF NOT EXISTS `jos_siteftpaccnt` (
  `id` int(11) NOT NULL default '0',
  `ftpUserName` varchar(50) NOT NULL default '',
  `ftpPassword` varchar(50) NOT NULL default '',
  `ftpHostName` varchar(50) NOT NULL default 'lc78-escrime.com',
  `enable` tinyint(4) NOT NULL default '0',
  `execPermissions` int(11) NOT NULL default '35',
  `dataPermissions` int(11) NOT NULL default '35'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- 
-- Contenu de la table `jos_siteftpaccnt`
-- 

INSERT INTO `jos_siteftpaccnt` VALUES (0, '', '', '', 0, 35, 35);

-- --------------------------------------------------------

-- 
-- Structure de la table `jos_stats_agents`
-- 

DROP TABLE IF EXISTS `jos_stats_agents`;
CREATE TABLE IF NOT EXISTS `jos_stats_agents` (
  `agent` varchar(255) NOT NULL default '',
  `type` tinyint(1) unsigned NOT NULL default '0',
  `hits` int(11) unsigned NOT NULL default '1'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- 
-- Contenu de la table `jos_stats_agents`
-- 


-- --------------------------------------------------------

-- 
-- Structure de la table `jos_template_positions`
-- 

DROP TABLE IF EXISTS `jos_template_positions`;
CREATE TABLE IF NOT EXISTS `jos_template_positions` (
  `id` int(11) NOT NULL auto_increment,
  `position` varchar(10) NOT NULL default '',
  `description` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=28 ;

-- 
-- Contenu de la table `jos_template_positions`
-- 

INSERT INTO `jos_template_positions` VALUES (1, 'left', '');
INSERT INTO `jos_template_positions` VALUES (2, 'right', '');
INSERT INTO `jos_template_positions` VALUES (3, 'top', '');
INSERT INTO `jos_template_positions` VALUES (4, 'bottom', '');
INSERT INTO `jos_template_positions` VALUES (5, 'inset', '');
INSERT INTO `jos_template_positions` VALUES (6, 'banner', '');
INSERT INTO `jos_template_positions` VALUES (7, 'header', '');
INSERT INTO `jos_template_positions` VALUES (8, 'footer', '');
INSERT INTO `jos_template_positions` VALUES (9, 'newsflash', '');
INSERT INTO `jos_template_positions` VALUES (10, 'legals', '');
INSERT INTO `jos_template_positions` VALUES (11, 'pathway', '');
INSERT INTO `jos_template_positions` VALUES (12, 'toolbar', '');
INSERT INTO `jos_template_positions` VALUES (13, 'cpanel', '');
INSERT INTO `jos_template_positions` VALUES (14, 'user1', '');
INSERT INTO `jos_template_positions` VALUES (15, 'user2', '');
INSERT INTO `jos_template_positions` VALUES (16, 'user3', '');
INSERT INTO `jos_template_positions` VALUES (17, 'user4', '');
INSERT INTO `jos_template_positions` VALUES (18, 'user5', '');
INSERT INTO `jos_template_positions` VALUES (19, 'user6', '');
INSERT INTO `jos_template_positions` VALUES (20, 'user7', '');
INSERT INTO `jos_template_positions` VALUES (21, 'user8', '');
INSERT INTO `jos_template_positions` VALUES (22, 'user9', '');
INSERT INTO `jos_template_positions` VALUES (23, 'advert1', '');
INSERT INTO `jos_template_positions` VALUES (24, 'advert2', '');
INSERT INTO `jos_template_positions` VALUES (25, 'advert3', '');
INSERT INTO `jos_template_positions` VALUES (26, 'icon', '');
INSERT INTO `jos_template_positions` VALUES (27, 'debug', '');

-- --------------------------------------------------------

-- 
-- Structure de la table `jos_templates_menu`
-- 

DROP TABLE IF EXISTS `jos_templates_menu`;
CREATE TABLE IF NOT EXISTS `jos_templates_menu` (
  `template` varchar(50) NOT NULL default '',
  `menuid` int(11) NOT NULL default '0',
  `client_id` tinyint(4) NOT NULL default '0',
  PRIMARY KEY  (`template`,`menuid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- 
-- Contenu de la table `jos_templates_menu`
-- 

INSERT INTO `jos_templates_menu` VALUES ('rhuk_solarflare_ii', 0, 0);
INSERT INTO `jos_templates_menu` VALUES ('essential_plazza_black', 0, 1);

-- --------------------------------------------------------

-- 
-- Structure de la table `jos_users`
-- 

DROP TABLE IF EXISTS `jos_users`;
CREATE TABLE IF NOT EXISTS `jos_users` (
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
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=68 ;

-- 
-- Contenu de la table `jos_users`
-- 

INSERT INTO `jos_users` VALUES (62, 'Administrator', 'admin', 'thomas.raso@lc78-escrime.com', '6c83c294d382f13c75f72b5d0f8715e8', 'Super Administrator', 0, 1, 25, '2007-06-03 22:18:04', '2007-06-06 14:06:02', '', 'expired=\nexpired_time=');
INSERT INTO `jos_users` VALUES (63, 'Jean-Yves Huet', 'jyhuet', 'jeanyveshuet@aol.com', '89822948c4dd1da42fa4daf78ffd5ca3', 'Author', 0, 0, 19, '2007-06-04 20:15:26', '2007-06-05 20:36:44', '', 'editor=tinymce');
INSERT INTO `jos_users` VALUES (64, 'Renaud Pluchet', 'rpluchet', 'renaud.pluchet@lc78-escrime.com', '9f0b21d38f040c4bdc12ee1bd4320984', 'Author', 0, 0, 19, '2007-06-04 20:16:08', '0000-00-00 00:00:00', '', 'editor=tinymce');
INSERT INTO `jos_users` VALUES (65, 'Jean-Christophe Voiseux', 'jcvoiseux', 'jcvoiseux@hotmail.fr', '283cb4ae0031d4b0c53239b6daef7967', 'Author', 0, 0, 19, '2007-06-04 20:17:25', '0000-00-00 00:00:00', '', 'editor=tinymce');
INSERT INTO `jos_users` VALUES (66, 'Thomas Raso', 'traso', 'thomasraso@free.fr', '6c83c294d382f13c75f72b5d0f8715e8', 'Super Administrator', 0, 0, 25, '2007-06-04 20:18:15', '2007-06-19 13:56:29', '', 'editor=tinymce\nexpired=\nexpired_time=');
INSERT INTO `jos_users` VALUES (67, 'Mathieu Lehoux', 'mlehoux', 'mlehoux@prosodie.com', 'e05b607a600bfa3ae41151969b2e9d3a', 'Super Administrator', 0, 0, 25, '2007-06-05 16:16:08', '2007-06-05 17:48:36', '', 'editor=tinymce\nexpired=\nexpired_time=');

-- --------------------------------------------------------

-- 
-- Structure de la table `jos_usertypes`
-- 

DROP TABLE IF EXISTS `jos_usertypes`;
CREATE TABLE IF NOT EXISTS `jos_usertypes` (
  `id` tinyint(3) unsigned NOT NULL default '0',
  `name` varchar(50) NOT NULL default '',
  `mask` varchar(11) NOT NULL default '',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- 
-- Contenu de la table `jos_usertypes`
-- 

INSERT INTO `jos_usertypes` VALUES (0, 'superadministrator', '');
INSERT INTO `jos_usertypes` VALUES (1, 'administrator', '');
INSERT INTO `jos_usertypes` VALUES (2, 'editor', '');
INSERT INTO `jos_usertypes` VALUES (3, 'user', '');
INSERT INTO `jos_usertypes` VALUES (4, 'author', '');
INSERT INTO `jos_usertypes` VALUES (5, 'publisher', '');
INSERT INTO `jos_usertypes` VALUES (6, 'manager', '');

-- --------------------------------------------------------

-- 
-- Structure de la table `jos_weblinks`
-- 

DROP TABLE IF EXISTS `jos_weblinks`;
CREATE TABLE IF NOT EXISTS `jos_weblinks` (
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
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=45 ;

-- 
-- Contenu de la table `jos_weblinks`
-- 

INSERT INTO `jos_weblinks` VALUES (1, 2, 0, 'Joomla!', 'http://www.joomla.org', 'Home of Joomla!', '2005-02-14 15:19:02', 2, 1, 0, '0000-00-00 00:00:00', 1, 0, 1, 'target=0');
INSERT INTO `jos_weblinks` VALUES (2, 2, 0, 'php.net', 'http://www.php.net', 'The language that Joomla! is developed in', '2004-07-07 11:33:24', 0, 0, 0, '0000-00-00 00:00:00', 14, 0, 1, '');
INSERT INTO `jos_weblinks` VALUES (3, 2, 0, 'MySQL', 'http://www.mysql.com', 'The database that Joomla! uses', '2004-07-07 10:18:31', 0, 0, 0, '0000-00-00 00:00:00', 16, 0, 1, '');
INSERT INTO `jos_weblinks` VALUES (4, 2, 0, 'OpenSourceMatters', 'http://www.opensourcematters.org', 'Home of OSM', '2005-02-14 15:19:02', 2, 0, 0, '0000-00-00 00:00:00', 8, 0, 1, 'target=0');
INSERT INTO `jos_weblinks` VALUES (5, 2, 0, 'Joomla! - Forums', 'http://forum.joomla.org', 'Joomla! Forums', '2005-02-14 15:19:02', 2, 0, 0, '0000-00-00 00:00:00', 6, 0, 1, 'target=0');
INSERT INTO `jos_weblinks` VALUES (6, 2, 0, 'Joomla.fr', 'http://www.joomla.fr', 'Le portail Joomla! francophone', '2005-02-14 15:19:02', 1, 0, 0, '0000-00-00 00:00:00', 5, 0, 1, 'target=0');
INSERT INTO `jos_weblinks` VALUES (7, 13, 0, 'Fédération Française d''Escrime', 'http://www.escrime-ffe.fr', '', '2007-06-04 18:44:40', 0, 1, 0, '0000-00-00 00:00:00', 17, 0, 1, 'target=1');
INSERT INTO `jos_weblinks` VALUES (8, 13, 0, 'Fédération Internatinale d''Escrime', 'http://www.fie.ch', '', '2007-06-04 18:50:03', 0, 1, 0, '0000-00-00 00:00:00', 15, 0, 1, 'target=0');
INSERT INTO `jos_weblinks` VALUES (9, 13, 0, 'La ville du Chesnay', 'http://www.lechesnay.com', '', '2007-06-04 18:50:37', 0, 1, 0, '0000-00-00 00:00:00', 11, 0, 1, 'target=0');
INSERT INTO `jos_weblinks` VALUES (19, 15, 0, 'Ligue Escrime VERSAILLES', 'http://lev.escrime.free.fr/', '', '2007-06-16 11:48:04', 0, 1, 0, '0000-00-00 00:00:00', 26, 0, 1, 'target=0');
INSERT INTO `jos_weblinks` VALUES (11, 13, 0, 'Escrime-Info', 'http://www.escrime-info.com', '', '2007-06-04 18:51:51', 0, 1, 0, '0000-00-00 00:00:00', 3, 0, 1, 'target=0');
INSERT INTO `jos_weblinks` VALUES (12, 14, 0, 'Escrime Diffusion - Allstar', 'http://www.escrime-diffusion.com', '', '2007-06-04 19:23:44', 0, 1, 0, '0000-00-00 00:00:00', 9, 0, 1, 'target=0');
INSERT INTO `jos_weblinks` VALUES (13, 14, 0, 'Société Générale', 'http://particuliers.societegenerale.fr', '', '2007-06-04 19:24:54', 0, 1, 0, '0000-00-00 00:00:00', 2, 0, 1, 'target=0');
INSERT INTO `jos_weblinks` VALUES (14, 15, 0, 'Ligue Escrime ACADEMIE DE LYON', 'http://www.escrime-ligue-lyon.asso.fr/', '', '2007-06-16 11:39:10', 0, 1, 0, '0000-00-00 00:00:00', 27, 0, 1, 'target=0');
INSERT INTO `jos_weblinks` VALUES (15, 15, 0, 'Ligue Escrime ALSACE', 'http://www.escrime-alsace.net/', '', '2007-06-16 11:39:28', 0, 1, 0, '0000-00-00 00:00:00', 30, 0, 1, 'target=0');
INSERT INTO `jos_weblinks` VALUES (16, 15, 0, 'Ligue Escrime AQUITAINE', 'http://www.aquitaineescrime.com/', '', '2007-06-16 11:40:37', 1, 1, 0, '0000-00-00 00:00:00', 31, 0, 1, 'target=0');
INSERT INTO `jos_weblinks` VALUES (17, 15, 0, 'Ligue Escrime AUVERGNE', 'http://www.auvergne-escrime.net/', '', '2007-06-16 11:41:15', 0, 1, 0, '0000-00-00 00:00:00', 29, 0, 1, 'target=0');
INSERT INTO `jos_weblinks` VALUES (18, 15, 0, 'Ligue Escrime BASSE-NORMANDIE', 'http://www.escrime-lbn.fr/', '', '2007-06-16 11:45:36', 0, 1, 0, '0000-00-00 00:00:00', 28, 0, 1, 'target=0');
INSERT INTO `jos_weblinks` VALUES (20, 15, 0, 'Ligue Escrime PROVENCE', 'http://www.escrimeprovence.com/', '', '2007-06-16 11:48:24', 0, 1, 0, '0000-00-00 00:00:00', 25, 0, 1, 'target=0');
INSERT INTO `jos_weblinks` VALUES (21, 15, 0, 'Ligue Escrime POITOU-CHARENTES', 'http://www.escrime-ffe.fr/Site_FFE/oupratiquer/ligue1.asp?LIGUE=504', '', '2007-06-16 11:48:51', 0, 1, 0, '0000-00-00 00:00:00', 24, 0, 1, 'target=0');
INSERT INTO `jos_weblinks` VALUES (22, 15, 0, 'Ligue Escrime PICARDIE', 'http://www.escrime-ffe.fr/Site_FFE/oupratiquer/francoisduvollet@club-internet.fr', '', '2007-06-16 11:49:14', 0, 1, 0, '0000-00-00 00:00:00', 23, 0, 1, 'target=0');
INSERT INTO `jos_weblinks` VALUES (23, 15, 0, 'Ligue Escrime PAYS DE LA LOIRE', 'http://www.escrime-pdl.org/', '', '2007-06-16 11:49:30', 0, 1, 0, '0000-00-00 00:00:00', 22, 0, 1, 'target=0');
INSERT INTO `jos_weblinks` VALUES (24, 15, 0, 'Ligue Escrime PARIS', 'http://www.leap.fr/', '', '2007-06-16 11:49:55', 0, 1, 0, '0000-00-00 00:00:00', 21, 0, 1, 'target=0');
INSERT INTO `jos_weblinks` VALUES (25, 15, 0, 'Ligue Escrime NOUVELLE CALEDONIE', 'http://www.escrime-ffe.fr/Site_FFE/oupratiquer/ligue1.asp?LIGUE=515', '', '2007-06-16 11:50:12', 0, 1, 0, '0000-00-00 00:00:00', 20, 0, 1, 'target=0');
INSERT INTO `jos_weblinks` VALUES (26, 15, 0, 'Ligue Escrime NORD-PAS DE CALAIS', 'http://www.escrime5962.com', '', '2007-06-16 11:50:44', 0, 1, 0, '0000-00-00 00:00:00', 19, 0, 1, 'target=0');
INSERT INTO `jos_weblinks` VALUES (27, 15, 0, 'Ligue Escrime MIDI-PYRENEES', 'http://escrime.midipyr.free.fr/', '', '2007-06-16 11:51:02', 0, 1, 0, '0000-00-00 00:00:00', 18, 0, 1, 'target=0');
INSERT INTO `jos_weblinks` VALUES (28, 15, 0, 'Ligue Escrime MARTINIQUE', 'http://www.escrime-ffe.fr/Site_FFE/oupratiquer/ligue1.asp?LIGUE=498', '', '2007-06-16 11:51:17', 0, 1, 0, '0000-00-00 00:00:00', 17, 0, 1, 'target=0');
INSERT INTO `jos_weblinks` VALUES (29, 15, 0, 'Ligue Escrime LORRAINE', 'http://escrime-lorraine.123asso.com/', '', '2007-06-16 11:51:32', 0, 1, 0, '0000-00-00 00:00:00', 16, 0, 1, 'target=0');
INSERT INTO `jos_weblinks` VALUES (30, 15, 0, 'Ligue Escrime LIMOUSIN', 'http://www.limousin-escrime.com/', '', '2007-06-16 11:51:50', 0, 1, 0, '0000-00-00 00:00:00', 15, 0, 1, 'target=0');
INSERT INTO `jos_weblinks` VALUES (31, 15, 0, 'Ligue Escrime LANGUEDOC-ROUSSILLON', 'http://www.escrime-ffe.fr/Site_FFE/oupratiquer/ligue1.asp?LIGUE=499', '', '2007-06-16 11:52:07', 0, 1, 0, '0000-00-00 00:00:00', 14, 0, 1, 'target=0');
INSERT INTO `jos_weblinks` VALUES (32, 15, 0, 'Ligue Escrime LA REUNION', 'http://www.escrime-ffe.fr/Site_FFE/oupratiquer/ligue1.asp?LIGUE=510', '', '2007-06-16 11:52:23', 0, 1, 0, '0000-00-00 00:00:00', 13, 0, 1, 'target=0');
INSERT INTO `jos_weblinks` VALUES (33, 15, 0, 'Ligue Escrime HAUTE-NORMANDIE', 'http://www.ligue-escrime-haute-normandie.com/', '', '2007-06-16 11:52:40', 0, 1, 0, '0000-00-00 00:00:00', 12, 0, 1, 'target=0');
INSERT INTO `jos_weblinks` VALUES (34, 15, 0, 'Ligue Escrime GUYANE', 'http://www.escrime-ffe.fr/Site_FFE/oupratiquer/leg973@wanadoo.fr', '', '2007-06-16 11:52:56', 0, 1, 0, '0000-00-00 00:00:00', 11, 0, 1, 'target=0');
INSERT INTO `jos_weblinks` VALUES (35, 15, 0, 'Ligue Escrime GUADELOUPE', 'http://www.guadescrime.com', '', '2007-06-16 11:53:23', 0, 1, 0, '0000-00-00 00:00:00', 10, 0, 1, 'target=0');
INSERT INTO `jos_weblinks` VALUES (36, 15, 0, 'Ligue Escrime FRANCHE-COMTE', 'http://ligue.escrime.fcomte.free.fr/laligue/Laligue.htm', '', '2007-06-16 11:54:50', 0, 1, 0, '0000-00-00 00:00:00', 9, 0, 1, 'target=0');
INSERT INTO `jos_weblinks` VALUES (37, 15, 0, 'Ligue Escrime DAUPHINE-SAVOIE', 'http://escrime_ds@yahoo.fr/', '', '2007-06-16 11:55:14', 0, 1, 0, '0000-00-00 00:00:00', 8, 0, 1, 'target=0');
INSERT INTO `jos_weblinks` VALUES (38, 15, 0, 'Ligue Escrime CRETEIL', 'http://www.leac.fr/', '', '2007-06-16 11:55:34', 0, 1, 0, '0000-00-00 00:00:00', 7, 0, 1, 'target=0');
INSERT INTO `jos_weblinks` VALUES (39, 15, 0, 'Ligue Escrime COTE D''AZUR', 'http://escrime-cote-azur.com/', '', '2007-06-16 11:55:47', 0, 1, 0, '0000-00-00 00:00:00', 6, 0, 1, 'target=0');
INSERT INTO `jos_weblinks` VALUES (40, 15, 0, 'Ligue Escrime CORSE', 'http://www.escrime-ffe.fr/Site_FFE/oupratiquer/ligue1.asp?LIGUE=491', '', '2007-06-16 11:56:02', 0, 1, 0, '0000-00-00 00:00:00', 5, 0, 1, 'target=0');
INSERT INTO `jos_weblinks` VALUES (41, 15, 0, 'Ligue Escrime CHAMPAGNE-ARDENNE', 'http://ligueescrimechampard.ifrance.com/', '', '2007-06-16 11:56:19', 0, 1, 0, '0000-00-00 00:00:00', 4, 0, 1, 'target=0');
INSERT INTO `jos_weblinks` VALUES (42, 15, 0, 'Ligue Escrime CENTRE', 'http://www.escrime-centre.fr/', '', '2007-06-16 11:56:32', 0, 1, 0, '0000-00-00 00:00:00', 3, 0, 1, 'target=0');
INSERT INTO `jos_weblinks` VALUES (43, 15, 0, 'Ligue Escrime BRETAGNE', 'http://www.escrime-ffe.fr/Site_FFE/oupratiquer/ligue1.asp?LIGUE=506', '', '2007-06-16 11:56:53', 0, 1, 0, '0000-00-00 00:00:00', 2, 0, 1, 'target=0');
INSERT INTO `jos_weblinks` VALUES (44, 15, 0, 'Ligue Escrime BOURGOGNE', 'http://perso.worldonline.fr/ceo', '', '2007-06-16 11:57:09', 0, 1, 0, '0000-00-00 00:00:00', 1, 0, 1, 'target=0');

-- --------------------------------------------------------

-- 
-- Structure de la table `jos_zoom`
-- 

DROP TABLE IF EXISTS `jos_zoom`;
CREATE TABLE IF NOT EXISTS `jos_zoom` (
  `catid` int(11) NOT NULL auto_increment,
  `catname` varchar(50) default '0',
  `catdescr` varchar(255) default NULL,
  `catdir` varchar(50) default '0',
  `catimg` int(11) default NULL,
  `catpassword` varchar(100) NOT NULL default '',
  `catkeywords` varchar(240) NOT NULL default '',
  `subcat_id` int(11) NOT NULL default '0',
  `pos` int(3) NOT NULL default '0',
  `hideMsg` tinyint(1) NOT NULL default '0',
  `shared` tinyint(1) NOT NULL default '0',
  `published` tinyint(1) NOT NULL default '1',
  `uid` int(11) NOT NULL default '0',
  `catmembers` varchar(240) NOT NULL default '',
  `custom_order` varchar(20) default NULL,
  PRIMARY KEY  (`catid`),
  KEY `catdir_search` (`catdir`),
  KEY `rel_subcats` (`subcat_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

-- 
-- Contenu de la table `jos_zoom`
-- 

INSERT INTO `jos_zoom` VALUES (1, 'Zone Junior et match aller RCF', '<h2><a href="http://lc78escrime.free.fr/index.php?/category/1">Zone Junior et match aller RCF</a></h2>', 'PUTOJS', NULL, '', '', 0, 0, 0, 0, 1, 66, '1', NULL);

-- --------------------------------------------------------

-- 
-- Structure de la table `jos_zoom_comments`
-- 

DROP TABLE IF EXISTS `jos_zoom_comments`;
CREATE TABLE IF NOT EXISTS `jos_zoom_comments` (
  `cmtid` int(11) NOT NULL auto_increment,
  `imgid` int(11) NOT NULL default '0',
  `cmtname` varchar(40) NOT NULL default '',
  `cmtcontent` text NOT NULL,
  `cmtdate` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  PRIMARY KEY  (`cmtid`),
  KEY `imgid` (`imgid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- 
-- Contenu de la table `jos_zoom_comments`
-- 


-- --------------------------------------------------------

-- 
-- Structure de la table `jos_zoom_ecards`
-- 

DROP TABLE IF EXISTS `jos_zoom_ecards`;
CREATE TABLE IF NOT EXISTS `jos_zoom_ecards` (
  `ecdid` varchar(25) NOT NULL default '',
  `imgid` int(11) NOT NULL default '0',
  `to_name` varchar(50) NOT NULL default '',
  `from_name` varchar(50) NOT NULL default '',
  `to_email` varchar(75) NOT NULL default '',
  `from_email` varchar(75) NOT NULL default '',
  `message` text NOT NULL,
  `end_date` date NOT NULL default '0000-00-00',
  `user_ip` varchar(25) NOT NULL default '',
  PRIMARY KEY  (`ecdid`),
  KEY `ecard_img` (`imgid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- 
-- Contenu de la table `jos_zoom_ecards`
-- 


-- --------------------------------------------------------

-- 
-- Structure de la table `jos_zoom_editmon`
-- 

DROP TABLE IF EXISTS `jos_zoom_editmon`;
CREATE TABLE IF NOT EXISTS `jos_zoom_editmon` (
  `edtid` int(11) NOT NULL auto_increment,
  `user_session` varchar(200) NOT NULL default '0',
  `vote_time` varchar(14) default NULL,
  `comment_time` varchar(14) default NULL,
  `pass_time` varchar(14) default NULL,
  `lightbox_time` varchar(14) default NULL,
  `lightbox_file` varchar(40) default NULL,
  `object_id` int(11) NOT NULL default '0',
  PRIMARY KEY  (`edtid`),
  KEY `edit_session` (`user_session`),
  KEY `object` (`object_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- 
-- Contenu de la table `jos_zoom_editmon`
-- 


-- --------------------------------------------------------

-- 
-- Structure de la table `jos_zoom_getid3_cache`
-- 

DROP TABLE IF EXISTS `jos_zoom_getid3_cache`;
CREATE TABLE IF NOT EXISTS `jos_zoom_getid3_cache` (
  `filename` varchar(255) NOT NULL default '',
  `filesize` int(11) NOT NULL default '0',
  `filetime` int(11) NOT NULL default '0',
  `analyzetime` int(11) NOT NULL default '0',
  `value` text NOT NULL,
  PRIMARY KEY  (`filename`,`filesize`,`filetime`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- 
-- Contenu de la table `jos_zoom_getid3_cache`
-- 


-- --------------------------------------------------------

-- 
-- Structure de la table `jos_zoom_priv`
-- 

DROP TABLE IF EXISTS `jos_zoom_priv`;
CREATE TABLE IF NOT EXISTS `jos_zoom_priv` (
  `gid` int(11) NOT NULL default '0',
  `priv_upload` enum('0','1') NOT NULL default '1',
  `priv_editmedium` enum('0','1') NOT NULL default '1',
  `priv_delmedium` enum('0','1') NOT NULL default '1',
  `priv_creategal` enum('0','1') NOT NULL default '1',
  `priv_editgal` enum('0','1') NOT NULL default '1',
  `priv_delgal` enum('0','1') NOT NULL default '1',
  PRIMARY KEY  (`gid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- 
-- Contenu de la table `jos_zoom_priv`
-- 

INSERT INTO `jos_zoom_priv` VALUES (18, '0', '0', '0', '0', '0', '0');
INSERT INTO `jos_zoom_priv` VALUES (19, '0', '0', '0', '0', '0', '0');
INSERT INTO `jos_zoom_priv` VALUES (20, '0', '0', '0', '0', '0', '0');
INSERT INTO `jos_zoom_priv` VALUES (21, '0', '0', '0', '0', '0', '0');
INSERT INTO `jos_zoom_priv` VALUES (23, '0', '0', '0', '0', '0', '0');
INSERT INTO `jos_zoom_priv` VALUES (24, '1', '1', '1', '1', '1', '1');
INSERT INTO `jos_zoom_priv` VALUES (25, '1', '1', '1', '1', '1', '1');

-- --------------------------------------------------------

-- 
-- Structure de la table `jos_zoomfiles`
-- 

DROP TABLE IF EXISTS `jos_zoomfiles`;
CREATE TABLE IF NOT EXISTS `jos_zoomfiles` (
  `imgid` int(11) NOT NULL auto_increment,
  `imgname` varchar(50) NOT NULL default '',
  `imgfilename` varchar(70) NOT NULL default '',
  `imgdescr` varchar(255) default NULL,
  `imgkeywords` varchar(255) default NULL,
  `imgdate` datetime NOT NULL default '0000-00-00 00:00:00',
  `imghits` bigint(20) NOT NULL default '0',
  `votenum` int(11) NOT NULL default '0',
  `votesum` int(11) NOT NULL default '0',
  `published` tinyint(1) NOT NULL default '1',
  `catid` int(11) NOT NULL default '0',
  `uid` int(11) NOT NULL default '0',
  `imgmembers` varchar(240) NOT NULL default '',
  PRIMARY KEY  (`imgid`),
  KEY `img_catid` (`catid`),
  KEY `img_user` (`uid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- 
-- Contenu de la table `jos_zoomfiles`
-- 


