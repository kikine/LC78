-- phpMyAdmin SQL Dump
-- version 2.6.1
-- http://www.phpmyadmin.net
-- 
-- Serveur: localhost
-- Généré le : Lundi 12 Décembre 2005 à 22:57
-- Version du serveur: 4.1.9
-- Version de PHP: 4.3.10
-- 
-- Base de données: `ceg_manager`
-- 
DROP DATABASE `ceg_manager`;
CREATE DATABASE `ceg_manager` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE ceg_manager;

-- --------------------------------------------------------

-- 
-- Structure de la table `tireurs`
-- 

DROP TABLE IF EXISTS `tireurs`;
CREATE TABLE IF NOT EXISTS `tireurs` (
  `nom` varchar(50) NOT NULL default '',
  `prenom` varchar(50) NOT NULL default '',
  `date_naiss` date NOT NULL default '0000-00-00',
  `numlic` varchar(12) NOT NULL default '0',
  `sexe` char(1) NOT NULL default '',
  `tel_fixe` varchar(10) NOT NULL default '',
  `tel_port` varchar(10) NOT NULL default '',
  `categorie` char(2) NOT NULL default '',
  `email` varchar(100) NOT NULL default '',
  `msn` varchar(100) NOT NULL default '',
  PRIMARY KEY  (`nom`,`prenom`,`date_naiss`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- 
-- Contenu de la table `tireurs`
-- 

INSERT INTO `tireurs` VALUES ('RASO', 'Thomas', '1984-01-26', '0616', 'M', '0555645285', '0677814146', 'SE', 'thomas_raso@hotmail.com', 'kikine_33@hotmail.com');
INSERT INTO `tireurs` VALUES ('BONNEFOND', 'Bénédicte', '1987-07-06', '0', 'F', '0556751015', '0675442919', 'JU', 'la_bene_33@hotmail.com', 'la_bene_33@hotmail.com');
INSERT INTO `tireurs` VALUES ('RASO', 'Bruno', '1956-01-04', '0', 'M', '', '', '', '', '');
INSERT INTO `tireurs` VALUES ('FERRADOU', 'Julien', '1986-09-20', '0999', 'M', '0556647934', '0664613159', 'JU', 'juju@toto.fr', 'juju@tata.fr');
INSERT INTO `tireurs` VALUES ('MOURET', 'Cédric', '0000-00-00', '1012', 'M', '', '', 'SE', '', '');
INSERT INTO `tireurs` VALUES ('JULES', 'Dominique', '0000-00-00', '0254', 'M', '', '', 'VE', '', '');

-- --------------------------------------------------------

-- 
-- Structure de la table `users`
-- 

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `nom` varchar(20) NOT NULL default '',
  `prenom` varchar(20) NOT NULL default '',
  `login` varchar(20) NOT NULL default '',
  `password` varchar(21) NOT NULL default '',
  `trigram` char(3) NOT NULL default '',
  `email` varchar(128) NOT NULL default '',
  PRIMARY KEY  (`nom`,`prenom`,`trigram`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- 
-- Contenu de la table `users`
-- 

INSERT INTO `users` VALUES ('RASO', 'Thomas', 'traso', 'traso', 'TRA', 'kikine_33@hotmail.com');
INSERT INTO `users` VALUES ('VILLEPREUX', 'Fabien', 'fvillepreux', 'fvillepreux', 'FVI', '');
INSERT INTO `users` VALUES ('RABEC', 'Samuel', 'srabec', 'srabec', 'SRA', '');
INSERT INTO `users` VALUES ('RASO', 'Bruno', 'braso', 'braso', 'BRA', 'brunoosar@aol.com');

-- 
-- Base de données: `mysql`
-- 
DROP DATABASE `mysql`;
CREATE DATABASE `mysql` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE mysql;

-- --------------------------------------------------------

-- 
-- Structure de la table `columns_priv`
-- 

DROP TABLE IF EXISTS `columns_priv`;
CREATE TABLE IF NOT EXISTS `columns_priv` (
  `Host` char(60) character set latin1 collate latin1_bin NOT NULL default '',
  `Db` char(64) character set latin1 collate latin1_bin NOT NULL default '',
  `User` char(16) character set latin1 collate latin1_bin NOT NULL default '',
  `Table_name` char(64) character set latin1 collate latin1_bin NOT NULL default '',
  `Column_name` char(64) character set latin1 collate latin1_bin NOT NULL default '',
  `Timestamp` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  `Column_priv` set('Select','Insert','Update','References') NOT NULL default '',
  PRIMARY KEY  (`Host`,`Db`,`User`,`Table_name`,`Column_name`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='Column privileges';

-- 
-- Contenu de la table `columns_priv`
-- 


-- --------------------------------------------------------

-- 
-- Structure de la table `db`
-- 

DROP TABLE IF EXISTS `db`;
CREATE TABLE IF NOT EXISTS `db` (
  `Host` char(60) character set latin1 collate latin1_bin NOT NULL default '',
  `Db` char(64) character set latin1 collate latin1_bin NOT NULL default '',
  `User` char(16) character set latin1 collate latin1_bin NOT NULL default '',
  `Select_priv` enum('N','Y') NOT NULL default 'N',
  `Insert_priv` enum('N','Y') NOT NULL default 'N',
  `Update_priv` enum('N','Y') NOT NULL default 'N',
  `Delete_priv` enum('N','Y') NOT NULL default 'N',
  `Create_priv` enum('N','Y') NOT NULL default 'N',
  `Drop_priv` enum('N','Y') NOT NULL default 'N',
  `Grant_priv` enum('N','Y') NOT NULL default 'N',
  `References_priv` enum('N','Y') NOT NULL default 'N',
  `Index_priv` enum('N','Y') NOT NULL default 'N',
  `Alter_priv` enum('N','Y') NOT NULL default 'N',
  `Create_tmp_table_priv` enum('N','Y') NOT NULL default 'N',
  `Lock_tables_priv` enum('N','Y') NOT NULL default 'N',
  PRIMARY KEY  (`Host`,`Db`,`User`),
  KEY `User` (`User`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='Database privileges';

-- 
-- Contenu de la table `db`
-- 

INSERT INTO `db` VALUES (0x6c6f63616c686f7374, 0x70726f6b796f6e, 0x70726f6b796f6e, 'Y', 'Y', 'Y', 'Y', 'Y', 'Y', 'N', 'Y', 'Y', 'Y', 'Y', 'Y');
INSERT INTO `db` VALUES (0x6a756c6961, 0x6365675f6d616e61676572, 0x636567, 'Y', 'Y', 'Y', 'Y', 'Y', 'Y', 'Y', 'Y', 'Y', 'Y', 'Y', 'Y');

-- --------------------------------------------------------

-- 
-- Structure de la table `func`
-- 

DROP TABLE IF EXISTS `func`;
CREATE TABLE IF NOT EXISTS `func` (
  `name` char(64) character set latin1 collate latin1_bin NOT NULL default '',
  `ret` tinyint(1) NOT NULL default '0',
  `dl` char(128) NOT NULL default '',
  `type` enum('function','aggregate') NOT NULL default 'function',
  PRIMARY KEY  (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='User defined functions';

-- 
-- Contenu de la table `func`
-- 


-- --------------------------------------------------------

-- 
-- Structure de la table `host`
-- 

DROP TABLE IF EXISTS `host`;
CREATE TABLE IF NOT EXISTS `host` (
  `Host` char(60) character set latin1 collate latin1_bin NOT NULL default '',
  `Db` char(64) character set latin1 collate latin1_bin NOT NULL default '',
  `Select_priv` enum('N','Y') NOT NULL default 'N',
  `Insert_priv` enum('N','Y') NOT NULL default 'N',
  `Update_priv` enum('N','Y') NOT NULL default 'N',
  `Delete_priv` enum('N','Y') NOT NULL default 'N',
  `Create_priv` enum('N','Y') NOT NULL default 'N',
  `Drop_priv` enum('N','Y') NOT NULL default 'N',
  `Grant_priv` enum('N','Y') NOT NULL default 'N',
  `References_priv` enum('N','Y') NOT NULL default 'N',
  `Index_priv` enum('N','Y') NOT NULL default 'N',
  `Alter_priv` enum('N','Y') NOT NULL default 'N',
  `Create_tmp_table_priv` enum('N','Y') NOT NULL default 'N',
  `Lock_tables_priv` enum('N','Y') NOT NULL default 'N',
  PRIMARY KEY  (`Host`,`Db`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='Host privileges;  Merged with database privileges';

-- 
-- Contenu de la table `host`
-- 


-- --------------------------------------------------------

-- 
-- Structure de la table `tables_priv`
-- 

DROP TABLE IF EXISTS `tables_priv`;
CREATE TABLE IF NOT EXISTS `tables_priv` (
  `Host` char(60) character set latin1 collate latin1_bin NOT NULL default '',
  `Db` char(64) character set latin1 collate latin1_bin NOT NULL default '',
  `User` char(16) character set latin1 collate latin1_bin NOT NULL default '',
  `Table_name` char(60) character set latin1 collate latin1_bin NOT NULL default '',
  `Grantor` char(77) NOT NULL default '',
  `Timestamp` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  `Table_priv` set('Select','Insert','Update','Delete','Create','Drop','Grant','References','Index','Alter') NOT NULL default '',
  `Column_priv` set('Select','Insert','Update','References') NOT NULL default '',
  PRIMARY KEY  (`Host`,`Db`,`User`,`Table_name`),
  KEY `Grantor` (`Grantor`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='Table privileges';

-- 
-- Contenu de la table `tables_priv`
-- 


-- --------------------------------------------------------

-- 
-- Structure de la table `user`
-- 

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `Host` varchar(60) character set latin1 collate latin1_bin NOT NULL default '',
  `User` varchar(16) character set latin1 collate latin1_bin NOT NULL default '',
  `password` varchar(16) NOT NULL default '',
  `Select_priv` enum('N','Y') NOT NULL default 'N',
  `Insert_priv` enum('N','Y') NOT NULL default 'N',
  `Update_priv` enum('N','Y') NOT NULL default 'N',
  `Delete_priv` enum('N','Y') NOT NULL default 'N',
  `Create_priv` enum('N','Y') NOT NULL default 'N',
  `Drop_priv` enum('N','Y') NOT NULL default 'N',
  `Reload_priv` enum('N','Y') NOT NULL default 'N',
  `Shutdown_priv` enum('N','Y') NOT NULL default 'N',
  `Process_priv` enum('N','Y') NOT NULL default 'N',
  `File_priv` enum('N','Y') NOT NULL default 'N',
  `Grant_priv` enum('N','Y') NOT NULL default 'N',
  `References_priv` enum('N','Y') NOT NULL default 'N',
  `Index_priv` enum('N','Y') NOT NULL default 'N',
  `Alter_priv` enum('N','Y') NOT NULL default 'N',
  `Show_db_priv` enum('N','Y') NOT NULL default 'N',
  `Super_priv` enum('N','Y') NOT NULL default 'N',
  `Create_tmp_table_priv` enum('N','Y') NOT NULL default 'N',
  `Lock_tables_priv` enum('N','Y') NOT NULL default 'N',
  `Execute_priv` enum('N','Y') NOT NULL default 'N',
  `Repl_slave_priv` enum('N','Y') NOT NULL default 'N',
  `Repl_client_priv` enum('N','Y') NOT NULL default 'N',
  `ssl_type` enum('','ANY','X509','SPECIFIED') NOT NULL default '',
  `ssl_cipher` blob NOT NULL,
  `x509_issuer` blob NOT NULL,
  `x509_subject` blob NOT NULL,
  `max_questions` int(11) NOT NULL default '0',
  `max_updates` int(11) unsigned NOT NULL default '0',
  `max_connections` int(11) unsigned NOT NULL default '0',
  PRIMARY KEY  (`Host`,`User`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='Users and global privileges';

-- 
-- Contenu de la table `user`
-- 

INSERT INTO `user` VALUES (0x6c6f63616c686f7374, 0x726f6f74, '', 'Y', 'Y', 'Y', 'Y', 'Y', 'Y', 'Y', 'Y', 'Y', 'Y', 'Y', 'Y', 'Y', 'Y', 'Y', 'Y', 'Y', 'Y', 'Y', 'Y', 'Y', '', '', '', '', 0, 0, 0);
INSERT INTO `user` VALUES (0x6a756c6961, 0x636567, '5336eb751494bdb1', 'Y', 'Y', 'Y', 'Y', 'Y', 'Y', 'Y', 'Y', 'Y', 'Y', 'Y', 'Y', 'Y', 'Y', 'Y', 'Y', 'Y', 'Y', 'Y', 'Y', 'Y', '', '', '', '', 10000, 10000, 10000);
-- 
-- Base de données: `xoops`
-- 

CREATE DATABASE `xoops` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE xoops;

-- --------------------------------------------------------

-- 
-- Structure de la table `xoops_avatar`
-- 

DROP TABLE IF EXISTS `xoops_avatar`;
CREATE TABLE IF NOT EXISTS `xoops_avatar` (
  `avatar_id` mediumint(8) unsigned NOT NULL auto_increment,
  `avatar_file` varchar(30) NOT NULL default '',
  `avatar_name` varchar(100) NOT NULL default '',
  `avatar_mimetype` varchar(30) NOT NULL default '',
  `avatar_created` int(10) NOT NULL default '0',
  `avatar_display` tinyint(1) unsigned NOT NULL default '0',
  `avatar_weight` smallint(5) unsigned NOT NULL default '0',
  `avatar_type` char(1) NOT NULL default '',
  PRIMARY KEY  (`avatar_id`),
  KEY `avatar_type` (`avatar_type`,`avatar_display`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- 
-- Contenu de la table `xoops_avatar`
-- 


-- --------------------------------------------------------

-- 
-- Structure de la table `xoops_avatar_user_link`
-- 

DROP TABLE IF EXISTS `xoops_avatar_user_link`;
CREATE TABLE IF NOT EXISTS `xoops_avatar_user_link` (
  `avatar_id` mediumint(8) unsigned NOT NULL default '0',
  `user_id` mediumint(8) unsigned NOT NULL default '0',
  KEY `avatar_user_id` (`avatar_id`,`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- 
-- Contenu de la table `xoops_avatar_user_link`
-- 


-- --------------------------------------------------------

-- 
-- Structure de la table `xoops_banner`
-- 

DROP TABLE IF EXISTS `xoops_banner`;
CREATE TABLE IF NOT EXISTS `xoops_banner` (
  `bid` smallint(5) unsigned NOT NULL auto_increment,
  `cid` tinyint(3) unsigned NOT NULL default '0',
  `imptotal` mediumint(8) unsigned NOT NULL default '0',
  `impmade` mediumint(8) unsigned NOT NULL default '0',
  `clicks` mediumint(8) unsigned NOT NULL default '0',
  `imageurl` varchar(255) NOT NULL default '',
  `clickurl` varchar(255) NOT NULL default '',
  `date` int(10) NOT NULL default '0',
  `htmlbanner` tinyint(1) NOT NULL default '0',
  `htmlcode` text NOT NULL,
  PRIMARY KEY  (`bid`),
  KEY `idxbannercid` (`cid`),
  KEY `idxbannerbidcid` (`bid`,`cid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

-- 
-- Contenu de la table `xoops_banner`
-- 

INSERT INTO `xoops_banner` VALUES (1, 1, 0, 1, 0, 'http://julia:3000/xoops_2092fr%5cxoops-2.0.9.2%5chtml/images/banners/xoops_banner.gif', 'http://www.xoops.org/', 1008813250, 0, '');
INSERT INTO `xoops_banner` VALUES (2, 1, 0, 1, 0, 'http://julia:3000/xoops_2092fr%5cxoops-2.0.9.2%5chtml/images/banners/xoops_banner_2.gif', 'http://www.xoops.org/', 1008813250, 0, '');
INSERT INTO `xoops_banner` VALUES (3, 1, 0, 1, 0, 'http://julia:3000/xoops_2092fr%5cxoops-2.0.9.2%5chtml/images/banners/banner.swf', 'http://www.xoops.org/', 1008813250, 0, '');

-- --------------------------------------------------------

-- 
-- Structure de la table `xoops_bannerclient`
-- 

DROP TABLE IF EXISTS `xoops_bannerclient`;
CREATE TABLE IF NOT EXISTS `xoops_bannerclient` (
  `cid` smallint(5) unsigned NOT NULL auto_increment,
  `name` varchar(60) NOT NULL default '',
  `contact` varchar(60) NOT NULL default '',
  `email` varchar(60) NOT NULL default '',
  `login` varchar(10) NOT NULL default '',
  `passwd` varchar(10) NOT NULL default '',
  `extrainfo` text NOT NULL,
  PRIMARY KEY  (`cid`),
  KEY `login` (`login`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

-- 
-- Contenu de la table `xoops_bannerclient`
-- 

INSERT INTO `xoops_bannerclient` VALUES (1, 'XOOPS', 'XOOPS Dev Team', 'webmaster@xoops.org', '', '', '');

-- --------------------------------------------------------

-- 
-- Structure de la table `xoops_bannerfinish`
-- 

DROP TABLE IF EXISTS `xoops_bannerfinish`;
CREATE TABLE IF NOT EXISTS `xoops_bannerfinish` (
  `bid` smallint(5) unsigned NOT NULL auto_increment,
  `cid` smallint(5) unsigned NOT NULL default '0',
  `impressions` mediumint(8) unsigned NOT NULL default '0',
  `clicks` mediumint(8) unsigned NOT NULL default '0',
  `datestart` int(10) unsigned NOT NULL default '0',
  `dateend` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`bid`),
  KEY `cid` (`cid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- 
-- Contenu de la table `xoops_bannerfinish`
-- 


-- --------------------------------------------------------

-- 
-- Structure de la table `xoops_bb_categories`
-- 

DROP TABLE IF EXISTS `xoops_bb_categories`;
CREATE TABLE IF NOT EXISTS `xoops_bb_categories` (
  `cat_id` smallint(3) unsigned NOT NULL auto_increment,
  `cat_title` varchar(100) NOT NULL default '',
  `cat_order` varchar(10) default NULL,
  PRIMARY KEY  (`cat_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

-- 
-- Contenu de la table `xoops_bb_categories`
-- 

INSERT INTO `xoops_bb_categories` VALUES (1, 'Escrime', '1');
INSERT INTO `xoops_bb_categories` VALUES (2, 'Informatique', '2');
INSERT INTO `xoops_bb_categories` VALUES (3, 'Internet', '3');
INSERT INTO `xoops_bb_categories` VALUES (4, 'Bordeaux', '4');
INSERT INTO `xoops_bb_categories` VALUES (5, 'Grenoble', '5');
INSERT INTO `xoops_bb_categories` VALUES (6, 'Paris / Versailles', '6');
INSERT INTO `xoops_bb_categories` VALUES (7, 'Manga', '7');
INSERT INTO `xoops_bb_categories` VALUES (8, 'Film', '8');

-- --------------------------------------------------------

-- 
-- Structure de la table `xoops_bb_forum_access`
-- 

DROP TABLE IF EXISTS `xoops_bb_forum_access`;
CREATE TABLE IF NOT EXISTS `xoops_bb_forum_access` (
  `forum_id` int(4) unsigned NOT NULL default '0',
  `user_id` int(5) unsigned NOT NULL default '0',
  `can_post` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`forum_id`,`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- 
-- Contenu de la table `xoops_bb_forum_access`
-- 


-- --------------------------------------------------------

-- 
-- Structure de la table `xoops_bb_forum_mods`
-- 

DROP TABLE IF EXISTS `xoops_bb_forum_mods`;
CREATE TABLE IF NOT EXISTS `xoops_bb_forum_mods` (
  `forum_id` int(4) unsigned NOT NULL default '0',
  `user_id` int(5) unsigned NOT NULL default '0',
  KEY `forum_user_id` (`forum_id`,`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- 
-- Contenu de la table `xoops_bb_forum_mods`
-- 

INSERT INTO `xoops_bb_forum_mods` VALUES (1, 1);
INSERT INTO `xoops_bb_forum_mods` VALUES (2, 1);

-- --------------------------------------------------------

-- 
-- Structure de la table `xoops_bb_forums`
-- 

DROP TABLE IF EXISTS `xoops_bb_forums`;
CREATE TABLE IF NOT EXISTS `xoops_bb_forums` (
  `forum_id` int(4) unsigned NOT NULL auto_increment,
  `forum_name` varchar(150) NOT NULL default '',
  `forum_desc` text,
  `forum_access` tinyint(2) NOT NULL default '1',
  `forum_moderator` int(2) default NULL,
  `forum_topics` int(8) NOT NULL default '0',
  `forum_posts` int(8) NOT NULL default '0',
  `forum_last_post_id` int(5) unsigned NOT NULL default '0',
  `cat_id` int(2) NOT NULL default '0',
  `forum_type` int(10) default '0',
  `allow_html` enum('0','1') NOT NULL default '0',
  `allow_sig` enum('0','1') NOT NULL default '0',
  `posts_per_page` tinyint(3) unsigned NOT NULL default '20',
  `hot_threshold` tinyint(3) unsigned NOT NULL default '10',
  `topics_per_page` tinyint(3) unsigned NOT NULL default '20',
  PRIMARY KEY  (`forum_id`),
  KEY `forum_last_post_id` (`forum_last_post_id`),
  KEY `cat_id` (`cat_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

-- 
-- Contenu de la table `xoops_bb_forums`
-- 

INSERT INTO `xoops_bb_forums` VALUES (1, 'Cercle d''Escrime de Gradignan', 'Forum du CE Gradignan de la ligue d''escrime d''Aquitaine.', 2, NULL, 1, 1, 1, 1, 0, '0', '1', 10, 10, 20);
INSERT INTO `xoops_bb_forums` VALUES (2, 'CEG Manager', 'Forum ayant trait au logiciel de gestion du Cercle d''Escrime de Gradignan.\r\nQue ce soit du développement ou de son utilisation et même de son support.', 2, NULL, 0, 0, 0, 1, 0, '0', '1', 10, 10, 20);

-- --------------------------------------------------------

-- 
-- Structure de la table `xoops_bb_posts`
-- 

DROP TABLE IF EXISTS `xoops_bb_posts`;
CREATE TABLE IF NOT EXISTS `xoops_bb_posts` (
  `post_id` int(8) unsigned NOT NULL auto_increment,
  `pid` int(8) NOT NULL default '0',
  `topic_id` int(8) NOT NULL default '0',
  `forum_id` int(4) NOT NULL default '0',
  `post_time` int(10) NOT NULL default '0',
  `uid` int(5) unsigned NOT NULL default '0',
  `poster_ip` varchar(15) NOT NULL default '',
  `subject` varchar(255) NOT NULL default '',
  `nohtml` tinyint(1) NOT NULL default '0',
  `nosmiley` tinyint(1) NOT NULL default '0',
  `icon` varchar(25) NOT NULL default '',
  `attachsig` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`post_id`),
  KEY `uid` (`uid`),
  KEY `pid` (`pid`),
  KEY `subject` (`subject`(40)),
  KEY `forumid_uid` (`forum_id`,`uid`),
  KEY `topicid_uid` (`topic_id`,`uid`),
  KEY `topicid_postid_pid` (`topic_id`,`post_id`,`pid`),
  FULLTEXT KEY `search` (`subject`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

-- 
-- Contenu de la table `xoops_bb_posts`
-- 

INSERT INTO `xoops_bb_posts` VALUES (1, 0, 1, 1, 1132946871, 1, '127.0.0.1', 'Résultats CZ Junior', 1, 0, '', 0);

-- --------------------------------------------------------

-- 
-- Structure de la table `xoops_bb_posts_text`
-- 

DROP TABLE IF EXISTS `xoops_bb_posts_text`;
CREATE TABLE IF NOT EXISTS `xoops_bb_posts_text` (
  `post_id` int(8) unsigned NOT NULL auto_increment,
  `post_text` text,
  PRIMARY KEY  (`post_id`),
  FULLTEXT KEY `search` (`post_text`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

-- 
-- Contenu de la table `xoops_bb_posts_text`
-- 

INSERT INTO `xoops_bb_posts_text` VALUES (1, 'Quelqu''un a t il des info sur Toulouse ?');

-- --------------------------------------------------------

-- 
-- Structure de la table `xoops_bb_topics`
-- 

DROP TABLE IF EXISTS `xoops_bb_topics`;
CREATE TABLE IF NOT EXISTS `xoops_bb_topics` (
  `topic_id` int(8) unsigned NOT NULL auto_increment,
  `topic_title` varchar(255) default NULL,
  `topic_poster` int(5) NOT NULL default '0',
  `topic_time` int(10) NOT NULL default '0',
  `topic_views` int(5) NOT NULL default '0',
  `topic_replies` int(4) NOT NULL default '0',
  `topic_last_post_id` int(8) unsigned NOT NULL default '0',
  `forum_id` int(4) NOT NULL default '0',
  `topic_status` tinyint(1) NOT NULL default '0',
  `topic_sticky` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`topic_id`),
  KEY `forum_id` (`forum_id`),
  KEY `topic_last_post_id` (`topic_last_post_id`),
  KEY `topic_poster` (`topic_poster`),
  KEY `topic_forum` (`topic_id`,`forum_id`),
  KEY `topic_sticky` (`topic_sticky`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

-- 
-- Contenu de la table `xoops_bb_topics`
-- 

INSERT INTO `xoops_bb_topics` VALUES (1, 'Résultats CZ Junior', 1, 1132946871, 2, 0, 1, 1, 0, 0);

-- --------------------------------------------------------

-- 
-- Structure de la table `xoops_block_module_link`
-- 

DROP TABLE IF EXISTS `xoops_block_module_link`;
CREATE TABLE IF NOT EXISTS `xoops_block_module_link` (
  `block_id` mediumint(8) unsigned NOT NULL default '0',
  `module_id` smallint(5) NOT NULL default '0',
  KEY `module_id` (`module_id`),
  KEY `block_id` (`block_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- 
-- Contenu de la table `xoops_block_module_link`
-- 

INSERT INTO `xoops_block_module_link` VALUES (1, 0);
INSERT INTO `xoops_block_module_link` VALUES (2, 0);
INSERT INTO `xoops_block_module_link` VALUES (3, 0);
INSERT INTO `xoops_block_module_link` VALUES (4, 0);
INSERT INTO `xoops_block_module_link` VALUES (5, 0);
INSERT INTO `xoops_block_module_link` VALUES (6, 0);
INSERT INTO `xoops_block_module_link` VALUES (7, 0);
INSERT INTO `xoops_block_module_link` VALUES (8, 0);
INSERT INTO `xoops_block_module_link` VALUES (9, 0);
INSERT INTO `xoops_block_module_link` VALUES (10, 0);
INSERT INTO `xoops_block_module_link` VALUES (11, 0);
INSERT INTO `xoops_block_module_link` VALUES (12, 0);
INSERT INTO `xoops_block_module_link` VALUES (13, -1);
INSERT INTO `xoops_block_module_link` VALUES (14, -1);
INSERT INTO `xoops_block_module_link` VALUES (15, -1);
INSERT INTO `xoops_block_module_link` VALUES (16, -1);
INSERT INTO `xoops_block_module_link` VALUES (17, -1);
INSERT INTO `xoops_block_module_link` VALUES (18, -1);

-- --------------------------------------------------------

-- 
-- Structure de la table `xoops_config`
-- 

DROP TABLE IF EXISTS `xoops_config`;
CREATE TABLE IF NOT EXISTS `xoops_config` (
  `conf_id` smallint(5) unsigned NOT NULL auto_increment,
  `conf_modid` smallint(5) unsigned NOT NULL default '0',
  `conf_catid` smallint(5) unsigned NOT NULL default '0',
  `conf_name` varchar(25) NOT NULL default '',
  `conf_title` varchar(30) NOT NULL default '',
  `conf_value` text NOT NULL,
  `conf_desc` varchar(30) NOT NULL default '',
  `conf_formtype` varchar(15) NOT NULL default '',
  `conf_valuetype` varchar(10) NOT NULL default '',
  `conf_order` smallint(5) unsigned NOT NULL default '0',
  PRIMARY KEY  (`conf_id`),
  KEY `conf_mod_cat_id` (`conf_modid`,`conf_catid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=89 ;

-- 
-- Contenu de la table `xoops_config`
-- 

INSERT INTO `xoops_config` VALUES (1, 0, 1, 'sitename', '_MD_AM_SITENAME', 'Kikine XOOPS', '_MD_AM_SITENAMEDSC', 'textbox', 'text', 0);
INSERT INTO `xoops_config` VALUES (2, 0, 1, 'slogan', '_MD_AM_SLOGAN', 'Just be the Best', '_MD_AM_SLOGANDSC', 'textbox', 'text', 2);
INSERT INTO `xoops_config` VALUES (3, 0, 1, 'language', '_MD_AM_LANGUAGE', 'french', '_MD_AM_LANGUAGEDSC', 'language', 'other', 4);
INSERT INTO `xoops_config` VALUES (4, 0, 1, 'startpage', '_MD_AM_STARTPAGE', 'newbb', '_MD_AM_STARTPAGEDSC', 'startpage', 'other', 6);
INSERT INTO `xoops_config` VALUES (5, 0, 1, 'server_TZ', '_MD_AM_SERVERTZ', '1', '_MD_AM_SERVERTZDSC', 'timezone', 'float', 8);
INSERT INTO `xoops_config` VALUES (6, 0, 1, 'default_TZ', '_MD_AM_DEFAULTTZ', '1', '_MD_AM_DEFAULTTZDSC', 'timezone', 'float', 10);
INSERT INTO `xoops_config` VALUES (7, 0, 1, 'theme_set', '_MD_AM_DTHEME', 'default', '_MD_AM_DTHEMEDSC', 'theme', 'other', 12);
INSERT INTO `xoops_config` VALUES (8, 0, 1, 'anonymous', '_MD_AM_ANONNAME', 'Anonyme', '_MD_AM_ANONNAMEDSC', 'textbox', 'text', 15);
INSERT INTO `xoops_config` VALUES (9, 0, 1, 'gzip_compression', '_MD_AM_USEGZIP', '0', '_MD_AM_USEGZIPDSC', 'yesno', 'int', 16);
INSERT INTO `xoops_config` VALUES (10, 0, 1, 'usercookie', '_MD_AM_USERCOOKIE', 'xoops_user', '_MD_AM_USERCOOKIEDSC', 'textbox', 'text', 18);
INSERT INTO `xoops_config` VALUES (11, 0, 1, 'session_expire', '_MD_AM_SESSEXPIRE', '15', '_MD_AM_SESSEXPIREDSC', 'textbox', 'int', 22);
INSERT INTO `xoops_config` VALUES (12, 0, 1, 'banners', '_MD_AM_BANNERS', '1', '_MD_AM_BANNERSDSC', 'yesno', 'int', 26);
INSERT INTO `xoops_config` VALUES (13, 0, 1, 'debug_mode', '_MD_AM_DEBUGMODE', '0', '_MD_AM_DEBUGMODEDSC', 'select', 'int', 24);
INSERT INTO `xoops_config` VALUES (14, 0, 1, 'my_ip', '_MD_AM_MYIP', '127.0.0.1', '_MD_AM_MYIPDSC', 'textbox', 'text', 29);
INSERT INTO `xoops_config` VALUES (15, 0, 1, 'use_ssl', '_MD_AM_USESSL', '0', '_MD_AM_USESSLDSC', 'yesno', 'int', 30);
INSERT INTO `xoops_config` VALUES (16, 0, 1, 'session_name', '_MD_AM_SESSNAME', 'xoops_session', '_MD_AM_SESSNAMEDSC', 'textbox', 'text', 20);
INSERT INTO `xoops_config` VALUES (17, 0, 2, 'minpass', '_MD_AM_MINPASS', '5', '_MD_AM_MINPASSDSC', 'textbox', 'int', 1);
INSERT INTO `xoops_config` VALUES (18, 0, 2, 'minuname', '_MD_AM_MINUNAME', '3', '_MD_AM_MINUNAMEDSC', 'textbox', 'int', 2);
INSERT INTO `xoops_config` VALUES (19, 0, 2, 'new_user_notify', '_MD_AM_NEWUNOTIFY', '1', '_MD_AM_NEWUNOTIFYDSC', 'yesno', 'int', 4);
INSERT INTO `xoops_config` VALUES (20, 0, 2, 'new_user_notify_group', '_MD_AM_NOTIFYTO', '1', '_MD_AM_NOTIFYTODSC', 'group', 'int', 6);
INSERT INTO `xoops_config` VALUES (21, 0, 2, 'activation_type', '_MD_AM_ACTVTYPE', '0', '_MD_AM_ACTVTYPEDSC', 'select', 'int', 8);
INSERT INTO `xoops_config` VALUES (22, 0, 2, 'activation_group', '_MD_AM_ACTVGROUP', '1', '_MD_AM_ACTVGROUPDSC', 'group', 'int', 10);
INSERT INTO `xoops_config` VALUES (23, 0, 2, 'uname_test_level', '_MD_AM_UNAMELVL', '0', '_MD_AM_UNAMELVLDSC', 'select', 'int', 12);
INSERT INTO `xoops_config` VALUES (24, 0, 2, 'avatar_allow_upload', '_MD_AM_AVATARALLOW', '0', '_MD_AM_AVATARALWDSC', 'yesno', 'int', 14);
INSERT INTO `xoops_config` VALUES (27, 0, 2, 'avatar_width', '_MD_AM_AVATARW', '80', '_MD_AM_AVATARWDSC', 'textbox', 'int', 16);
INSERT INTO `xoops_config` VALUES (28, 0, 2, 'avatar_height', '_MD_AM_AVATARH', '80', '_MD_AM_AVATARHDSC', 'textbox', 'int', 18);
INSERT INTO `xoops_config` VALUES (29, 0, 2, 'avatar_maxsize', '_MD_AM_AVATARMAX', '35000', '_MD_AM_AVATARMAXDSC', 'textbox', 'int', 20);
INSERT INTO `xoops_config` VALUES (30, 0, 1, 'adminmail', '_MD_AM_ADMINML', 'kikine_33@hotmail.com', '_MD_AM_ADMINMLDSC', 'textbox', 'text', 3);
INSERT INTO `xoops_config` VALUES (31, 0, 2, 'self_delete', '_MD_AM_SELFDELETE', '0', '_MD_AM_SELFDELETEDSC', 'yesno', 'int', 22);
INSERT INTO `xoops_config` VALUES (32, 0, 1, 'com_mode', '_MD_AM_COMMODE', 'nest', '_MD_AM_COMMODEDSC', 'select', 'text', 34);
INSERT INTO `xoops_config` VALUES (33, 0, 1, 'com_order', '_MD_AM_COMORDER', '0', '_MD_AM_COMORDERDSC', 'select', 'int', 36);
INSERT INTO `xoops_config` VALUES (34, 0, 2, 'bad_unames', '_MD_AM_BADUNAMES', 'a:3:{i:0;s:9:"webmaster";i:1;s:6:"^xoops";i:2;s:6:"^admin";}', '_MD_AM_BADUNAMESDSC', 'textarea', 'array', 24);
INSERT INTO `xoops_config` VALUES (35, 0, 2, 'bad_emails', '_MD_AM_BADEMAILS', 'a:1:{i:0;s:10:"xoops.org$";}', '_MD_AM_BADEMAILSDSC', 'textarea', 'array', 26);
INSERT INTO `xoops_config` VALUES (36, 0, 2, 'maxuname', '_MD_AM_MAXUNAME', '10', '_MD_AM_MAXUNAMEDSC', 'textbox', 'int', 3);
INSERT INTO `xoops_config` VALUES (37, 0, 1, 'bad_ips', '_MD_AM_BADIPS', 'a:1:{i:0;s:9:"127.0.0.1";}', '_MD_AM_BADIPSDSC', 'textarea', 'array', 42);
INSERT INTO `xoops_config` VALUES (38, 0, 3, 'meta_keywords', '_MD_AM_METAKEY', 'news, technology, headlines, xoops, xoop, nuke, myphpnuke, myphp-nuke, phpnuke, SE, geek, geeks, hacker, hackers, linux, software, download, downloads, free, community, mp3, forum, forums, bulletin, board, boards, bbs, php, survey, poll, polls, kernel, comment, comments, portal, odp, open, source, opensource, FreeSoftware, gnu, gpl, license, Unix, *nix, mysql, sql, database, databases, web site, weblog, guru, module, modules, theme, themes, cms, content management', '_MD_AM_METAKEYDSC', 'textarea', 'text', 0);
INSERT INTO `xoops_config` VALUES (39, 0, 3, 'footer', '_MD_AM_FOOTER', 'Powered by XOOPS 2.0 &copy; 2001-2003 <a href="http://www.frxoops.org/" target="_blank">The XOOPS Project</a>', '_MD_AM_FOOTERDSC', 'textarea', 'text', 20);
INSERT INTO `xoops_config` VALUES (40, 0, 4, 'censor_enable', '_MD_AM_DOCENSOR', '0', '_MD_AM_DOCENSORDSC', 'yesno', 'int', 0);
INSERT INTO `xoops_config` VALUES (41, 0, 4, 'censor_words', '_MD_AM_CENSORWRD', 'a:2:{i:0;s:4:"fuck";i:1;s:4:"shit";}', '_MD_AM_CENSORWRDDSC', 'textarea', 'array', 1);
INSERT INTO `xoops_config` VALUES (42, 0, 4, 'censor_replace', '_MD_AM_CENSORRPLC', '#OOPS#', '_MD_AM_CENSORRPLCDSC', 'textbox', 'text', 2);
INSERT INTO `xoops_config` VALUES (43, 0, 3, 'meta_robots', '_MD_AM_METAROBOTS', 'index,follow', '_MD_AM_METAROBOTSDSC', 'select', 'text', 2);
INSERT INTO `xoops_config` VALUES (44, 0, 5, 'enable_search', '_MD_AM_DOSEARCH', '1', '_MD_AM_DOSEARCHDSC', 'yesno', 'int', 0);
INSERT INTO `xoops_config` VALUES (45, 0, 5, 'keyword_min', '_MD_AM_MINSEARCH', '5', '_MD_AM_MINSEARCHDSC', 'textbox', 'int', 1);
INSERT INTO `xoops_config` VALUES (46, 0, 2, 'avatar_minposts', '_MD_AM_AVATARMP', '0', '_MD_AM_AVATARMPDSC', 'textbox', 'int', 15);
INSERT INTO `xoops_config` VALUES (47, 0, 1, 'enable_badips', '_MD_AM_DOBADIPS', '0', '_MD_AM_DOBADIPSDSC', 'yesno', 'int', 40);
INSERT INTO `xoops_config` VALUES (48, 0, 3, 'meta_rating', '_MD_AM_METARATING', 'general', '_MD_AM_METARATINGDSC', 'select', 'text', 4);
INSERT INTO `xoops_config` VALUES (49, 0, 3, 'meta_author', '_MD_AM_METAAUTHOR', 'XOOPS', '_MD_AM_METAAUTHORDSC', 'textbox', 'text', 6);
INSERT INTO `xoops_config` VALUES (50, 0, 3, 'meta_copyright', '_MD_AM_METACOPYR', 'Copyright &copy; 2001-2003', '_MD_AM_METACOPYRDSC', 'textbox', 'text', 8);
INSERT INTO `xoops_config` VALUES (51, 0, 3, 'meta_description', '_MD_AM_METADESC', 'XOOPS is a dynamic Object Oriented based open source portal script written in PHP.', '_MD_AM_METADESCDSC', 'textarea', 'text', 1);
INSERT INTO `xoops_config` VALUES (52, 0, 2, 'allow_chgmail', '_MD_AM_ALLWCHGMAIL', '0', '_MD_AM_ALLWCHGMAILDSC', 'yesno', 'int', 3);
INSERT INTO `xoops_config` VALUES (53, 0, 1, 'use_mysession', '_MD_AM_USEMYSESS', '0', '_MD_AM_USEMYSESSDSC', 'yesno', 'int', 19);
INSERT INTO `xoops_config` VALUES (54, 0, 2, 'reg_dispdsclmr', '_MD_AM_DSPDSCLMR', '1', '_MD_AM_DSPDSCLMRDSC', 'yesno', 'int', 30);
INSERT INTO `xoops_config` VALUES (55, 0, 2, 'reg_disclaimer', '_MD_AM_REGDSCLMR', 'Les administrateurs et mod&eacute;rateurs de ce site s''efforceront de supprimer ou &eacute;diter tous les messages &agrave; caract&egrave;re r&eacute;pr&eacute;hensible aussi rapidement que possible. Toutefois, il leur est impossible de passer en revue tous les messages. Vous admettez donc que tous les messages post&eacute;s sur ces forums expriment la vue et opinion de leurs auteurs respectifs, et non pas des administrateurs, ou mod&eacute;rateurs, ou webmestres (except&eacute; les messages post&eacute;s par eux-m&ecirc;me) et par cons&eacute;quent ne peuvent pas &ecirc;tre tenus pour responsables.\r\n\r\nVous consentez &agrave; ne pas poster de messages injurieux, obsc&egrave;nes, vulgaires, diffamatoires, mena&ccedil;ants, sexuels ou tout autre message qui violerait les lois applicables. Le faire peut vous conduire &agrave; &ecirc;tre banni imm&eacute;diatement de fa&ccedil;on permanente (et votre fournisseur d''acc&egrave;s &agrave; internet en sera inform&eacute;). L''adresse IP de chaque message est enregistr&eacute;e afin d''aider &agrave; faire respecter ces conditions. Vous &ecirc;tes d''accord sur le fait que le webmestre, l''administrateur et les mod&eacute;rateurs de ce forum ont le droit de supprimer, &eacute;diter, d&eacute;placer ou verrouiller n''importe quel sujet de discussion &agrave; tout moment. En tant qu''utilisateur, vous &ecirc;tes d''accord sur le fait que toutes les informations que vous donnerez ci-apr&egrave;s seront stock&eacute;es dans une base de donn&eacute;es. Cependant, ces informations ne seront divulgu&eacute;es &agrave; aucune tierce personne ou soci&eacute;t&eacute; sans votre accord. Le webmestre, l''administrateur, et les mod&eacute;rateurs ne peuvent pas &ecirc;tre tenus pour responsables si une tentative de piratage informatique conduit &agrave; l''acc&egrave;s de ces donn&eacute;es.\r\n\r\nCe site utilise les cookies pour stocker des informations sur votre ordinateur. Ces cookies ne contiendront aucune information que vous aurez entr&eacute;s ci-apr&egrave;s, ils servent uniquement &agrave; am&eacute;liorer le confort d''utilisation.\r\nL''adresse e-mail est uniquement utilis&eacute;e afin de confirmer les d&eacute;tails de votre enregistrement ainsi que votre mot de passe (et aussi pour vous envoyer un nouveau mot de passe dans la cas o&ugrave; vous l''oublieriez).\r\n\r\nEn vous enregistrant, vous vous portez garant du fait d''&ecirc;tre en accord avec le r&egrave;glement ci-dessus.', '_MD_AM_REGDSCLMRDSC', 'textarea', 'text', 32);
INSERT INTO `xoops_config` VALUES (56, 0, 2, 'allow_register', '_MD_AM_ALLOWREG', '1', '_MD_AM_ALLOWREGDSC', 'yesno', 'int', 0);
INSERT INTO `xoops_config` VALUES (57, 0, 1, 'theme_fromfile', '_MD_AM_THEMEFILE', '0', '_MD_AM_THEMEFILEDSC', 'yesno', 'int', 13);
INSERT INTO `xoops_config` VALUES (58, 0, 1, 'closesite', '_MD_AM_CLOSESITE', '0', '_MD_AM_CLOSESITEDSC', 'yesno', 'int', 26);
INSERT INTO `xoops_config` VALUES (59, 0, 1, 'closesite_okgrp', '_MD_AM_CLOSESITEOK', 'a:1:{i:0;s:1:"1";}', '_MD_AM_CLOSESITEOKDSC', 'group_multi', 'array', 27);
INSERT INTO `xoops_config` VALUES (60, 0, 1, 'closesite_text', '_MD_AM_CLOSESITETXT', 'Le site est actuellement fermé pour maintenance. Merci de revenir plus tard.', '_MD_AM_CLOSESITETXTDSC', 'textarea', 'text', 28);
INSERT INTO `xoops_config` VALUES (61, 0, 1, 'sslpost_name', '_MD_AM_SSLPOST', 'xoops_ssl', '_MD_AM_SSLPOSTDSC', 'textbox', 'text', 31);
INSERT INTO `xoops_config` VALUES (62, 0, 1, 'module_cache', '_MD_AM_MODCACHE', 'a:3:{i:2;s:1:"0";i:3;s:1:"0";i:4;s:1:"0";}', '_MD_AM_MODCACHEDSC', 'module_cache', 'array', 50);
INSERT INTO `xoops_config` VALUES (63, 0, 1, 'template_set', '_MD_AM_DTPLSET', 'default', '_MD_AM_DTPLSETDSC', 'tplset', 'other', 14);
INSERT INTO `xoops_config` VALUES (64, 0, 6, 'mailmethod', '_MD_AM_MAILERMETHOD', 'mail', '_MD_AM_MAILERMETHODDESC', 'select', 'text', 4);
INSERT INTO `xoops_config` VALUES (65, 0, 6, 'smtphost', '_MD_AM_SMTPHOST', 'a:1:{i:0;s:0:"";}', '_MD_AM_SMTPHOSTDESC', 'textarea', 'array', 6);
INSERT INTO `xoops_config` VALUES (66, 0, 6, 'smtpuser', '_MD_AM_SMTPUSER', '', '_MD_AM_SMTPUSERDESC', 'textbox', 'text', 7);
INSERT INTO `xoops_config` VALUES (67, 0, 6, 'smtppass', '_MD_AM_SMTPPASS', '', '_MD_AM_SMTPPASSDESC', 'password', 'text', 8);
INSERT INTO `xoops_config` VALUES (68, 0, 6, 'sendmailpath', '_MD_AM_SENDMAILPATH', '/usr/sbin/sendmail', '_MD_AM_SENDMAILPATHDESC', 'textbox', 'text', 5);
INSERT INTO `xoops_config` VALUES (69, 0, 6, 'from', '_MD_AM_MAILFROM', '', '_MD_AM_MAILFROMDESC', 'textbox', 'text', 1);
INSERT INTO `xoops_config` VALUES (70, 0, 6, 'fromname', '_MD_AM_MAILFROMNAME', '', '_MD_AM_MAILFROMNAMEDESC', 'textbox', 'text', 2);
INSERT INTO `xoops_config` VALUES (71, 0, 1, 'sslloginlink', '_MD_AM_SSLLINK', 'https://', '_MD_AM_SSLLINKDSC', 'textbox', 'text', 33);
INSERT INTO `xoops_config` VALUES (72, 0, 1, 'theme_set_allowed', '_MD_AM_THEMEOK', 'a:1:{i:0;s:7:"default";}', '_MD_AM_THEMEOKDSC', 'theme_multi', 'array', 13);
INSERT INTO `xoops_config` VALUES (73, 0, 6, 'fromuid', '_MD_AM_MAILFROMUID', '1', '_MD_AM_MAILFROMUIDDESC', 'user', 'int', 3);
INSERT INTO `xoops_config` VALUES (74, 3, 0, 'notification_enabled', '_NOT_CONFIG_ENABLE', '3', '_NOT_CONFIG_ENABLEDSC', 'select', 'int', 0);
INSERT INTO `xoops_config` VALUES (75, 3, 0, 'notification_events', '_NOT_CONFIG_EVENTS', 'a:8:{i:0;s:15:"thread-new_post";i:1;s:15:"thread-bookmark";i:2;s:16:"forum-new_thread";i:3;s:14:"forum-new_post";i:4;s:14:"forum-bookmark";i:5;s:16:"global-new_forum";i:6;s:15:"global-new_post";i:7;s:19:"global-new_fullpost";}', '_NOT_CONFIG_EVENTSDSC', 'select_multi', 'array', 1);
INSERT INTO `xoops_config` VALUES (76, 4, 0, 'popular', '_MI_MYDOWNLOADS_POPULAR', '100', '_MI_MYDOWNLOADS_POPULARDSC', 'select', 'int', 0);
INSERT INTO `xoops_config` VALUES (77, 4, 0, 'newdownloads', '_MI_MYDOWNLOADS_NEWDLS', '10', '_MI_MYDOWNLOADS_NEWDLSDSC', 'select', 'int', 1);
INSERT INTO `xoops_config` VALUES (78, 4, 0, 'perpage', '_MI_MYDOWNLOADS_PERPAGE', '10', '_MI_MYDOWNLOADS_PERPAGEDSC', 'select', 'int', 2);
INSERT INTO `xoops_config` VALUES (79, 4, 0, 'anonpost', '_MI_MYDOWNLOADS_ANONPOST', '0', '', 'yesno', 'int', 3);
INSERT INTO `xoops_config` VALUES (80, 4, 0, 'autoapprove', '_MI_MYDOWNLOADS_AUTOAPPROVE', '0', '_MI_MYDOWNLOADS_AUTOAPPROVEDSC', 'yesno', 'int', 4);
INSERT INTO `xoops_config` VALUES (81, 4, 0, 'useshots', '_MI_MYDOWNLOADS_USESHOTS', '0', '_MI_MYDOWNLOADS_USESHOTSDSC', 'yesno', 'int', 5);
INSERT INTO `xoops_config` VALUES (82, 4, 0, 'shotwidth', '_MI_MYDOWNLOADS_SHOTWIDTH', '140', '_MI_MYDOWNLOADS_SHOTWIDTHDSC', 'textbox', 'int', 6);
INSERT INTO `xoops_config` VALUES (83, 4, 0, 'check_host', '_MI_MYDOWNLOADS_CHECKHOST', '0', '', 'yesno', 'int', 7);
INSERT INTO `xoops_config` VALUES (84, 4, 0, 'referers', '_MI_MYDOWNLOADS_REFERERS', 'a:1:{i:0;s:5:"julia";}', '_MI_MYDOWNLOADS_REFERERSDSC', 'textarea', 'array', 8);
INSERT INTO `xoops_config` VALUES (85, 4, 0, 'com_rule', '_CM_COMRULES', '1', '', 'select', 'int', 9);
INSERT INTO `xoops_config` VALUES (86, 4, 0, 'com_anonpost', '_CM_COMANONPOST', '0', '', 'yesno', 'int', 10);
INSERT INTO `xoops_config` VALUES (87, 4, 0, 'notification_enabled', '_NOT_CONFIG_ENABLE', '3', '_NOT_CONFIG_ENABLEDSC', 'select', 'int', 11);
INSERT INTO `xoops_config` VALUES (88, 4, 0, 'notification_events', '_NOT_CONFIG_EVENTS', 'a:11:{i:0;s:19:"global-new_category";i:1;s:18:"global-file_modify";i:2;s:18:"global-file_broken";i:3;s:18:"global-file_submit";i:4;s:15:"global-new_file";i:5;s:20:"category-file_submit";i:6;s:17:"category-new_file";i:7;s:17:"category-bookmark";i:8;s:12:"file-comment";i:9;s:19:"file-comment_submit";i:10;s:13:"file-bookmark";}', '_NOT_CONFIG_EVENTSDSC', 'select_multi', 'array', 12);

-- --------------------------------------------------------

-- 
-- Structure de la table `xoops_configcategory`
-- 

DROP TABLE IF EXISTS `xoops_configcategory`;
CREATE TABLE IF NOT EXISTS `xoops_configcategory` (
  `confcat_id` smallint(5) unsigned NOT NULL auto_increment,
  `confcat_name` varchar(25) NOT NULL default '',
  `confcat_order` smallint(5) unsigned NOT NULL default '0',
  PRIMARY KEY  (`confcat_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

-- 
-- Contenu de la table `xoops_configcategory`
-- 

INSERT INTO `xoops_configcategory` VALUES (1, '_MD_AM_GENERAL', 0);
INSERT INTO `xoops_configcategory` VALUES (2, '_MD_AM_USERSETTINGS', 0);
INSERT INTO `xoops_configcategory` VALUES (3, '_MD_AM_METAFOOTER', 0);
INSERT INTO `xoops_configcategory` VALUES (4, '_MD_AM_CENSOR', 0);
INSERT INTO `xoops_configcategory` VALUES (5, '_MD_AM_SEARCH', 0);
INSERT INTO `xoops_configcategory` VALUES (6, '_MD_AM_MAILER', 0);

-- --------------------------------------------------------

-- 
-- Structure de la table `xoops_configoption`
-- 

DROP TABLE IF EXISTS `xoops_configoption`;
CREATE TABLE IF NOT EXISTS `xoops_configoption` (
  `confop_id` mediumint(8) unsigned NOT NULL auto_increment,
  `confop_name` varchar(255) NOT NULL default '',
  `confop_value` varchar(255) NOT NULL default '',
  `conf_id` smallint(5) unsigned NOT NULL default '0',
  PRIMARY KEY  (`confop_id`),
  KEY `conf_id` (`conf_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=80 ;

-- 
-- Contenu de la table `xoops_configoption`
-- 

INSERT INTO `xoops_configoption` VALUES (1, '_MD_AM_DEBUGMODE1', '1', 13);
INSERT INTO `xoops_configoption` VALUES (2, '_MD_AM_DEBUGMODE2', '2', 13);
INSERT INTO `xoops_configoption` VALUES (3, '_NESTED', 'nest', 32);
INSERT INTO `xoops_configoption` VALUES (4, '_FLAT', 'flat', 32);
INSERT INTO `xoops_configoption` VALUES (5, '_THREADED', 'thread', 32);
INSERT INTO `xoops_configoption` VALUES (6, '_OLDESTFIRST', '0', 33);
INSERT INTO `xoops_configoption` VALUES (7, '_NEWESTFIRST', '1', 33);
INSERT INTO `xoops_configoption` VALUES (8, '_MD_AM_USERACTV', '0', 21);
INSERT INTO `xoops_configoption` VALUES (9, '_MD_AM_AUTOACTV', '1', 21);
INSERT INTO `xoops_configoption` VALUES (10, '_MD_AM_ADMINACTV', '2', 21);
INSERT INTO `xoops_configoption` VALUES (11, '_MD_AM_STRICT', '0', 23);
INSERT INTO `xoops_configoption` VALUES (12, '_MD_AM_MEDIUM', '1', 23);
INSERT INTO `xoops_configoption` VALUES (13, '_MD_AM_LIGHT', '2', 23);
INSERT INTO `xoops_configoption` VALUES (14, '_MD_AM_DEBUGMODE3', '3', 13);
INSERT INTO `xoops_configoption` VALUES (15, '_MD_AM_INDEXFOLLOW', 'index,follow', 43);
INSERT INTO `xoops_configoption` VALUES (16, '_MD_AM_NOINDEXFOLLOW', 'noindex,follow', 43);
INSERT INTO `xoops_configoption` VALUES (17, '_MD_AM_INDEXNOFOLLOW', 'index,nofollow', 43);
INSERT INTO `xoops_configoption` VALUES (18, '_MD_AM_NOINDEXNOFOLLOW', 'noindex,nofollow', 43);
INSERT INTO `xoops_configoption` VALUES (19, '_MD_AM_METAOGEN', 'general', 48);
INSERT INTO `xoops_configoption` VALUES (20, '_MD_AM_METAO14YRS', '14 years', 48);
INSERT INTO `xoops_configoption` VALUES (21, '_MD_AM_METAOREST', 'restricted', 48);
INSERT INTO `xoops_configoption` VALUES (22, '_MD_AM_METAOMAT', 'mature', 48);
INSERT INTO `xoops_configoption` VALUES (23, '_MD_AM_DEBUGMODE0', '0', 13);
INSERT INTO `xoops_configoption` VALUES (24, 'PHP mail()', 'mail', 64);
INSERT INTO `xoops_configoption` VALUES (25, 'sendmail', 'sendmail', 64);
INSERT INTO `xoops_configoption` VALUES (26, 'SMTP', 'smtp', 64);
INSERT INTO `xoops_configoption` VALUES (27, 'SMTPAuth', 'smtpauth', 64);
INSERT INTO `xoops_configoption` VALUES (28, '_NOT_CONFIG_DISABLE', '0', 74);
INSERT INTO `xoops_configoption` VALUES (29, '_NOT_CONFIG_ENABLEBLOCK', '1', 74);
INSERT INTO `xoops_configoption` VALUES (30, '_NOT_CONFIG_ENABLEINLINE', '2', 74);
INSERT INTO `xoops_configoption` VALUES (31, '_NOT_CONFIG_ENABLEBOTH', '3', 74);
INSERT INTO `xoops_configoption` VALUES (32, 'Discussion : Nouvel envoi', 'thread-new_post', 75);
INSERT INTO `xoops_configoption` VALUES (33, 'Discussion : Signet', 'thread-bookmark', 75);
INSERT INTO `xoops_configoption` VALUES (34, 'Forum : Nouvelle discusion', 'forum-new_thread', 75);
INSERT INTO `xoops_configoption` VALUES (35, 'Forum : Nouvel envoi', 'forum-new_post', 75);
INSERT INTO `xoops_configoption` VALUES (36, 'Forum : Signet', 'forum-bookmark', 75);
INSERT INTO `xoops_configoption` VALUES (37, 'Globale : Nouveau forum', 'global-new_forum', 75);
INSERT INTO `xoops_configoption` VALUES (38, 'Globale : Nouvel envoi', 'global-new_post', 75);
INSERT INTO `xoops_configoption` VALUES (39, 'Globale : Nouvel envoi (Texte Complet)', 'global-new_fullpost', 75);
INSERT INTO `xoops_configoption` VALUES (40, '5', '5', 76);
INSERT INTO `xoops_configoption` VALUES (41, '10', '10', 76);
INSERT INTO `xoops_configoption` VALUES (42, '50', '50', 76);
INSERT INTO `xoops_configoption` VALUES (43, '100', '100', 76);
INSERT INTO `xoops_configoption` VALUES (44, '200', '200', 76);
INSERT INTO `xoops_configoption` VALUES (45, '500', '500', 76);
INSERT INTO `xoops_configoption` VALUES (46, '1000', '1000', 76);
INSERT INTO `xoops_configoption` VALUES (47, '5', '5', 77);
INSERT INTO `xoops_configoption` VALUES (48, '10', '10', 77);
INSERT INTO `xoops_configoption` VALUES (49, '15', '15', 77);
INSERT INTO `xoops_configoption` VALUES (50, '20', '20', 77);
INSERT INTO `xoops_configoption` VALUES (51, '25', '25', 77);
INSERT INTO `xoops_configoption` VALUES (52, '30', '30', 77);
INSERT INTO `xoops_configoption` VALUES (53, '50', '50', 77);
INSERT INTO `xoops_configoption` VALUES (54, '5', '5', 78);
INSERT INTO `xoops_configoption` VALUES (55, '10', '10', 78);
INSERT INTO `xoops_configoption` VALUES (56, '15', '15', 78);
INSERT INTO `xoops_configoption` VALUES (57, '20', '20', 78);
INSERT INTO `xoops_configoption` VALUES (58, '25', '25', 78);
INSERT INTO `xoops_configoption` VALUES (59, '30', '30', 78);
INSERT INTO `xoops_configoption` VALUES (60, '50', '50', 78);
INSERT INTO `xoops_configoption` VALUES (61, '_CM_COMNOCOM', '0', 85);
INSERT INTO `xoops_configoption` VALUES (62, '_CM_COMAPPROVEALL', '1', 85);
INSERT INTO `xoops_configoption` VALUES (63, '_CM_COMAPPROVEUSER', '2', 85);
INSERT INTO `xoops_configoption` VALUES (64, '_CM_COMAPPROVEADMIN', '3', 85);
INSERT INTO `xoops_configoption` VALUES (65, '_NOT_CONFIG_DISABLE', '0', 87);
INSERT INTO `xoops_configoption` VALUES (66, '_NOT_CONFIG_ENABLEBLOCK', '1', 87);
INSERT INTO `xoops_configoption` VALUES (67, '_NOT_CONFIG_ENABLEINLINE', '2', 87);
INSERT INTO `xoops_configoption` VALUES (68, '_NOT_CONFIG_ENABLEBOTH', '3', 87);
INSERT INTO `xoops_configoption` VALUES (69, 'Globale : Nouvelle cat&eacute;gorie', 'global-new_category', 88);
INSERT INTO `xoops_configoption` VALUES (70, 'Globale : Modification de fichier demand&eacute;e', 'global-file_modify', 88);
INSERT INTO `xoops_configoption` VALUES (71, 'Globale : Fichier bris&eacute; propos&eacute;', 'global-file_broken', 88);
INSERT INTO `xoops_configoption` VALUES (72, 'Globale : Nouveau fichier propos&eacute;', 'global-file_submit', 88);
INSERT INTO `xoops_configoption` VALUES (73, 'Globale : Nouveau fichier', 'global-new_file', 88);
INSERT INTO `xoops_configoption` VALUES (74, 'Cat&eacute;gorie : Nouveau fichier propos&eacute;', 'category-file_submit', 88);
INSERT INTO `xoops_configoption` VALUES (75, 'Cat&eacute;gorie : Nouveau fichier', 'category-new_file', 88);
INSERT INTO `xoops_configoption` VALUES (76, 'Cat&eacute;gorie : Signet', 'category-bookmark', 88);
INSERT INTO `xoops_configoption` VALUES (77, 'Fichier : Commentaire ajout&eacute;', 'file-comment', 88);
INSERT INTO `xoops_configoption` VALUES (78, 'Fichier : Commentaire propos&eacute;', 'file-comment_submit', 88);
INSERT INTO `xoops_configoption` VALUES (79, 'Fichier : Signet', 'file-bookmark', 88);

-- --------------------------------------------------------

-- 
-- Structure de la table `xoops_group_permission`
-- 

DROP TABLE IF EXISTS `xoops_group_permission`;
CREATE TABLE IF NOT EXISTS `xoops_group_permission` (
  `gperm_id` int(10) unsigned NOT NULL auto_increment,
  `gperm_groupid` smallint(5) unsigned NOT NULL default '0',
  `gperm_itemid` mediumint(8) unsigned NOT NULL default '0',
  `gperm_modid` mediumint(5) unsigned NOT NULL default '0',
  `gperm_name` varchar(50) NOT NULL default '',
  PRIMARY KEY  (`gperm_id`),
  KEY `groupid` (`gperm_groupid`),
  KEY `itemid` (`gperm_itemid`),
  KEY `gperm_modid` (`gperm_modid`,`gperm_name`(10))
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=78 ;

-- 
-- Contenu de la table `xoops_group_permission`
-- 

INSERT INTO `xoops_group_permission` VALUES (1, 1, 1, 1, 'module_admin');
INSERT INTO `xoops_group_permission` VALUES (2, 1, 1, 1, 'module_read');
INSERT INTO `xoops_group_permission` VALUES (3, 2, 1, 1, 'module_read');
INSERT INTO `xoops_group_permission` VALUES (4, 3, 1, 1, 'module_read');
INSERT INTO `xoops_group_permission` VALUES (5, 1, 1, 1, 'system_admin');
INSERT INTO `xoops_group_permission` VALUES (6, 1, 2, 1, 'system_admin');
INSERT INTO `xoops_group_permission` VALUES (7, 1, 3, 1, 'system_admin');
INSERT INTO `xoops_group_permission` VALUES (8, 1, 4, 1, 'system_admin');
INSERT INTO `xoops_group_permission` VALUES (9, 1, 5, 1, 'system_admin');
INSERT INTO `xoops_group_permission` VALUES (10, 1, 6, 1, 'system_admin');
INSERT INTO `xoops_group_permission` VALUES (11, 1, 7, 1, 'system_admin');
INSERT INTO `xoops_group_permission` VALUES (12, 1, 8, 1, 'system_admin');
INSERT INTO `xoops_group_permission` VALUES (13, 1, 9, 1, 'system_admin');
INSERT INTO `xoops_group_permission` VALUES (14, 1, 10, 1, 'system_admin');
INSERT INTO `xoops_group_permission` VALUES (15, 1, 11, 1, 'system_admin');
INSERT INTO `xoops_group_permission` VALUES (16, 1, 12, 1, 'system_admin');
INSERT INTO `xoops_group_permission` VALUES (17, 1, 13, 1, 'system_admin');
INSERT INTO `xoops_group_permission` VALUES (18, 1, 14, 1, 'system_admin');
INSERT INTO `xoops_group_permission` VALUES (19, 1, 15, 1, 'system_admin');
INSERT INTO `xoops_group_permission` VALUES (20, 1, 1, 1, 'block_read');
INSERT INTO `xoops_group_permission` VALUES (21, 2, 1, 1, 'block_read');
INSERT INTO `xoops_group_permission` VALUES (22, 3, 1, 1, 'block_read');
INSERT INTO `xoops_group_permission` VALUES (23, 1, 2, 1, 'block_read');
INSERT INTO `xoops_group_permission` VALUES (24, 2, 2, 1, 'block_read');
INSERT INTO `xoops_group_permission` VALUES (25, 3, 2, 1, 'block_read');
INSERT INTO `xoops_group_permission` VALUES (26, 1, 3, 1, 'block_read');
INSERT INTO `xoops_group_permission` VALUES (27, 2, 3, 1, 'block_read');
INSERT INTO `xoops_group_permission` VALUES (28, 3, 3, 1, 'block_read');
INSERT INTO `xoops_group_permission` VALUES (29, 1, 4, 1, 'block_read');
INSERT INTO `xoops_group_permission` VALUES (30, 2, 4, 1, 'block_read');
INSERT INTO `xoops_group_permission` VALUES (31, 3, 4, 1, 'block_read');
INSERT INTO `xoops_group_permission` VALUES (32, 1, 5, 1, 'block_read');
INSERT INTO `xoops_group_permission` VALUES (33, 2, 5, 1, 'block_read');
INSERT INTO `xoops_group_permission` VALUES (34, 3, 5, 1, 'block_read');
INSERT INTO `xoops_group_permission` VALUES (35, 1, 6, 1, 'block_read');
INSERT INTO `xoops_group_permission` VALUES (36, 2, 6, 1, 'block_read');
INSERT INTO `xoops_group_permission` VALUES (37, 3, 6, 1, 'block_read');
INSERT INTO `xoops_group_permission` VALUES (38, 1, 7, 1, 'block_read');
INSERT INTO `xoops_group_permission` VALUES (39, 2, 7, 1, 'block_read');
INSERT INTO `xoops_group_permission` VALUES (40, 3, 7, 1, 'block_read');
INSERT INTO `xoops_group_permission` VALUES (41, 1, 8, 1, 'block_read');
INSERT INTO `xoops_group_permission` VALUES (42, 2, 8, 1, 'block_read');
INSERT INTO `xoops_group_permission` VALUES (43, 3, 8, 1, 'block_read');
INSERT INTO `xoops_group_permission` VALUES (44, 1, 9, 1, 'block_read');
INSERT INTO `xoops_group_permission` VALUES (45, 2, 9, 1, 'block_read');
INSERT INTO `xoops_group_permission` VALUES (46, 3, 9, 1, 'block_read');
INSERT INTO `xoops_group_permission` VALUES (47, 1, 10, 1, 'block_read');
INSERT INTO `xoops_group_permission` VALUES (48, 2, 10, 1, 'block_read');
INSERT INTO `xoops_group_permission` VALUES (49, 3, 10, 1, 'block_read');
INSERT INTO `xoops_group_permission` VALUES (50, 1, 11, 1, 'block_read');
INSERT INTO `xoops_group_permission` VALUES (51, 2, 11, 1, 'block_read');
INSERT INTO `xoops_group_permission` VALUES (52, 3, 11, 1, 'block_read');
INSERT INTO `xoops_group_permission` VALUES (53, 1, 12, 1, 'block_read');
INSERT INTO `xoops_group_permission` VALUES (54, 2, 12, 1, 'block_read');
INSERT INTO `xoops_group_permission` VALUES (55, 3, 12, 1, 'block_read');
INSERT INTO `xoops_group_permission` VALUES (56, 1, 2, 1, 'module_admin');
INSERT INTO `xoops_group_permission` VALUES (57, 1, 2, 1, 'module_read');
INSERT INTO `xoops_group_permission` VALUES (58, 2, 2, 1, 'module_read');
INSERT INTO `xoops_group_permission` VALUES (59, 1, 3, 1, 'module_admin');
INSERT INTO `xoops_group_permission` VALUES (60, 1, 3, 1, 'module_read');
INSERT INTO `xoops_group_permission` VALUES (61, 1, 13, 1, 'block_read');
INSERT INTO `xoops_group_permission` VALUES (62, 1, 14, 1, 'block_read');
INSERT INTO `xoops_group_permission` VALUES (63, 1, 15, 1, 'block_read');
INSERT INTO `xoops_group_permission` VALUES (64, 1, 16, 1, 'block_read');
INSERT INTO `xoops_group_permission` VALUES (65, 2, 3, 1, 'module_read');
INSERT INTO `xoops_group_permission` VALUES (66, 2, 13, 1, 'block_read');
INSERT INTO `xoops_group_permission` VALUES (67, 2, 14, 1, 'block_read');
INSERT INTO `xoops_group_permission` VALUES (68, 2, 15, 1, 'block_read');
INSERT INTO `xoops_group_permission` VALUES (69, 2, 16, 1, 'block_read');
INSERT INTO `xoops_group_permission` VALUES (70, 1, 4, 1, 'module_admin');
INSERT INTO `xoops_group_permission` VALUES (71, 1, 4, 1, 'module_read');
INSERT INTO `xoops_group_permission` VALUES (72, 1, 17, 1, 'block_read');
INSERT INTO `xoops_group_permission` VALUES (73, 1, 18, 1, 'block_read');
INSERT INTO `xoops_group_permission` VALUES (74, 2, 4, 1, 'module_read');
INSERT INTO `xoops_group_permission` VALUES (75, 2, 17, 1, 'block_read');
INSERT INTO `xoops_group_permission` VALUES (76, 2, 18, 1, 'block_read');
INSERT INTO `xoops_group_permission` VALUES (77, 3, 3, 1, 'module_read');

-- --------------------------------------------------------

-- 
-- Structure de la table `xoops_groups`
-- 

DROP TABLE IF EXISTS `xoops_groups`;
CREATE TABLE IF NOT EXISTS `xoops_groups` (
  `groupid` smallint(5) unsigned NOT NULL auto_increment,
  `name` varchar(50) NOT NULL default '',
  `description` text NOT NULL,
  `group_type` varchar(10) NOT NULL default '',
  PRIMARY KEY  (`groupid`),
  KEY `group_type` (`group_type`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

-- 
-- Contenu de la table `xoops_groups`
-- 

INSERT INTO `xoops_groups` VALUES (1, 'Webmestres', 'Webmestres de ce site', 'Admin');
INSERT INTO `xoops_groups` VALUES (2, 'Utilisateurs enregistr&eacute;s', 'Groupe des utilisateurs enregistr&eacute;s', 'User');
INSERT INTO `xoops_groups` VALUES (3, 'Utilisateurs anonymes', 'Groupe des utilisateurs anonymes', 'Anonymous');

-- --------------------------------------------------------

-- 
-- Structure de la table `xoops_groups_users_link`
-- 

DROP TABLE IF EXISTS `xoops_groups_users_link`;
CREATE TABLE IF NOT EXISTS `xoops_groups_users_link` (
  `linkid` mediumint(8) unsigned NOT NULL auto_increment,
  `groupid` smallint(5) unsigned NOT NULL default '0',
  `uid` mediumint(8) unsigned NOT NULL default '0',
  PRIMARY KEY  (`linkid`),
  KEY `groupid_uid` (`groupid`,`uid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

-- 
-- Contenu de la table `xoops_groups_users_link`
-- 

INSERT INTO `xoops_groups_users_link` VALUES (1, 1, 1);
INSERT INTO `xoops_groups_users_link` VALUES (2, 2, 1);

-- --------------------------------------------------------

-- 
-- Structure de la table `xoops_image`
-- 

DROP TABLE IF EXISTS `xoops_image`;
CREATE TABLE IF NOT EXISTS `xoops_image` (
  `image_id` mediumint(8) unsigned NOT NULL auto_increment,
  `image_name` varchar(30) NOT NULL default '',
  `image_nicename` varchar(255) NOT NULL default '',
  `image_mimetype` varchar(30) NOT NULL default '',
  `image_created` int(10) unsigned NOT NULL default '0',
  `image_display` tinyint(1) unsigned NOT NULL default '0',
  `image_weight` smallint(5) unsigned NOT NULL default '0',
  `imgcat_id` smallint(5) unsigned NOT NULL default '0',
  PRIMARY KEY  (`image_id`),
  KEY `imgcat_id` (`imgcat_id`),
  KEY `image_display` (`image_display`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- 
-- Contenu de la table `xoops_image`
-- 


-- --------------------------------------------------------

-- 
-- Structure de la table `xoops_imagebody`
-- 

DROP TABLE IF EXISTS `xoops_imagebody`;
CREATE TABLE IF NOT EXISTS `xoops_imagebody` (
  `image_id` mediumint(8) unsigned NOT NULL default '0',
  `image_body` mediumblob,
  KEY `image_id` (`image_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- 
-- Contenu de la table `xoops_imagebody`
-- 


-- --------------------------------------------------------

-- 
-- Structure de la table `xoops_imagecategory`
-- 

DROP TABLE IF EXISTS `xoops_imagecategory`;
CREATE TABLE IF NOT EXISTS `xoops_imagecategory` (
  `imgcat_id` smallint(5) unsigned NOT NULL auto_increment,
  `imgcat_name` varchar(100) NOT NULL default '',
  `imgcat_maxsize` int(8) unsigned NOT NULL default '0',
  `imgcat_maxwidth` smallint(3) unsigned NOT NULL default '0',
  `imgcat_maxheight` smallint(3) unsigned NOT NULL default '0',
  `imgcat_display` tinyint(1) unsigned NOT NULL default '0',
  `imgcat_weight` smallint(3) unsigned NOT NULL default '0',
  `imgcat_type` char(1) NOT NULL default '',
  `imgcat_storetype` varchar(5) NOT NULL default '',
  PRIMARY KEY  (`imgcat_id`),
  KEY `imgcat_display` (`imgcat_display`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- 
-- Contenu de la table `xoops_imagecategory`
-- 


-- --------------------------------------------------------

-- 
-- Structure de la table `xoops_imgset`
-- 

DROP TABLE IF EXISTS `xoops_imgset`;
CREATE TABLE IF NOT EXISTS `xoops_imgset` (
  `imgset_id` smallint(5) unsigned NOT NULL auto_increment,
  `imgset_name` varchar(50) NOT NULL default '',
  `imgset_refid` mediumint(8) unsigned NOT NULL default '0',
  PRIMARY KEY  (`imgset_id`),
  KEY `imgset_refid` (`imgset_refid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

-- 
-- Contenu de la table `xoops_imgset`
-- 

INSERT INTO `xoops_imgset` VALUES (1, 'default', 0);

-- --------------------------------------------------------

-- 
-- Structure de la table `xoops_imgset_tplset_link`
-- 

DROP TABLE IF EXISTS `xoops_imgset_tplset_link`;
CREATE TABLE IF NOT EXISTS `xoops_imgset_tplset_link` (
  `imgset_id` smallint(5) unsigned NOT NULL default '0',
  `tplset_name` varchar(50) NOT NULL default '',
  KEY `tplset_name` (`tplset_name`(10))
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- 
-- Contenu de la table `xoops_imgset_tplset_link`
-- 

INSERT INTO `xoops_imgset_tplset_link` VALUES (1, 'default');

-- --------------------------------------------------------

-- 
-- Structure de la table `xoops_imgsetimg`
-- 

DROP TABLE IF EXISTS `xoops_imgsetimg`;
CREATE TABLE IF NOT EXISTS `xoops_imgsetimg` (
  `imgsetimg_id` mediumint(8) unsigned NOT NULL auto_increment,
  `imgsetimg_file` varchar(50) NOT NULL default '',
  `imgsetimg_body` blob NOT NULL,
  `imgsetimg_imgset` smallint(5) unsigned NOT NULL default '0',
  PRIMARY KEY  (`imgsetimg_id`),
  KEY `imgsetimg_imgset` (`imgsetimg_imgset`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- 
-- Contenu de la table `xoops_imgsetimg`
-- 


-- --------------------------------------------------------

-- 
-- Structure de la table `xoops_modules`
-- 

DROP TABLE IF EXISTS `xoops_modules`;
CREATE TABLE IF NOT EXISTS `xoops_modules` (
  `mid` smallint(5) unsigned NOT NULL auto_increment,
  `name` varchar(150) NOT NULL default '',
  `version` smallint(5) unsigned NOT NULL default '100',
  `last_update` int(10) unsigned NOT NULL default '0',
  `weight` smallint(3) unsigned NOT NULL default '0',
  `isactive` tinyint(1) unsigned NOT NULL default '0',
  `dirname` varchar(25) NOT NULL default '',
  `hasmain` tinyint(1) unsigned NOT NULL default '0',
  `hasadmin` tinyint(1) unsigned NOT NULL default '0',
  `hassearch` tinyint(1) unsigned NOT NULL default '0',
  `hasconfig` tinyint(1) unsigned NOT NULL default '0',
  `hascomments` tinyint(1) unsigned NOT NULL default '0',
  `hasnotification` tinyint(1) unsigned NOT NULL default '0',
  PRIMARY KEY  (`mid`),
  KEY `hasmain` (`hasmain`),
  KEY `hasadmin` (`hasadmin`),
  KEY `hassearch` (`hassearch`),
  KEY `hasnotification` (`hasnotification`),
  KEY `dirname` (`dirname`),
  KEY `name` (`name`(15))
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

-- 
-- Contenu de la table `xoops_modules`
-- 

INSERT INTO `xoops_modules` VALUES (1, 'Syst&egrave;me', 100, 1132945674, 0, 1, 'system', 0, 1, 0, 0, 0, 0);
INSERT INTO `xoops_modules` VALUES (2, 'Membres', 100, 1132946402, 1, 1, 'xoopsmembers', 1, 0, 0, 0, 0, 0);
INSERT INTO `xoops_modules` VALUES (3, 'Forum', 100, 1132946467, 1, 1, 'newbb', 1, 1, 1, 0, 0, 1);
INSERT INTO `xoops_modules` VALUES (4, 'T&eacute;l&eacute;chargements', 110, 1132946507, 1, 1, 'mydownloads', 1, 1, 1, 1, 1, 1);

-- --------------------------------------------------------

-- 
-- Structure de la table `xoops_mydownloads_broken`
-- 

DROP TABLE IF EXISTS `xoops_mydownloads_broken`;
CREATE TABLE IF NOT EXISTS `xoops_mydownloads_broken` (
  `reportid` int(5) NOT NULL auto_increment,
  `lid` int(11) NOT NULL default '0',
  `sender` int(11) NOT NULL default '0',
  `ip` varchar(20) NOT NULL default '',
  PRIMARY KEY  (`reportid`),
  KEY `lid` (`lid`),
  KEY `sender` (`sender`),
  KEY `ip` (`ip`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

-- 
-- Contenu de la table `xoops_mydownloads_broken`
-- 


-- --------------------------------------------------------

-- 
-- Structure de la table `xoops_mydownloads_cat`
-- 

DROP TABLE IF EXISTS `xoops_mydownloads_cat`;
CREATE TABLE IF NOT EXISTS `xoops_mydownloads_cat` (
  `cid` int(5) unsigned NOT NULL auto_increment,
  `pid` int(5) unsigned NOT NULL default '0',
  `title` varchar(50) NOT NULL default '',
  `imgurl` varchar(150) NOT NULL default '',
  PRIMARY KEY  (`cid`),
  KEY `pid` (`pid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

-- 
-- Contenu de la table `xoops_mydownloads_cat`
-- 

INSERT INTO `xoops_mydownloads_cat` VALUES (1, 0, 'Videos', 'http://');
INSERT INTO `xoops_mydownloads_cat` VALUES (3, 1, 'Escrime', '');
INSERT INTO `xoops_mydownloads_cat` VALUES (4, 0, 'Musique', 'http://');
INSERT INTO `xoops_mydownloads_cat` VALUES (5, 4, 'Nightwish', '');
INSERT INTO `xoops_mydownloads_cat` VALUES (6, 4, 'Têtes Raides', '');
INSERT INTO `xoops_mydownloads_cat` VALUES (7, 4, 'Noir Désir', '');
INSERT INTO `xoops_mydownloads_cat` VALUES (8, 4, 'Sangria Gratuite', '');

-- --------------------------------------------------------

-- 
-- Structure de la table `xoops_mydownloads_downloads`
-- 

DROP TABLE IF EXISTS `xoops_mydownloads_downloads`;
CREATE TABLE IF NOT EXISTS `xoops_mydownloads_downloads` (
  `lid` int(11) unsigned NOT NULL auto_increment,
  `cid` int(5) unsigned NOT NULL default '0',
  `title` varchar(100) NOT NULL default '',
  `url` varchar(250) NOT NULL default '',
  `homepage` varchar(100) NOT NULL default '',
  `version` varchar(10) NOT NULL default '',
  `size` int(8) NOT NULL default '0',
  `platform` varchar(50) NOT NULL default '',
  `logourl` varchar(60) NOT NULL default '',
  `submitter` int(11) NOT NULL default '0',
  `status` tinyint(2) NOT NULL default '0',
  `date` int(10) NOT NULL default '0',
  `hits` int(11) unsigned NOT NULL default '0',
  `rating` double(6,4) NOT NULL default '0.0000',
  `votes` int(11) unsigned NOT NULL default '0',
  `comments` int(11) unsigned NOT NULL default '0',
  PRIMARY KEY  (`lid`),
  KEY `cid` (`cid`),
  KEY `status` (`status`),
  KEY `title` (`title`(40))
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

-- 
-- Contenu de la table `xoops_mydownloads_downloads`
-- 

INSERT INTO `xoops_mydownloads_downloads` VALUES (1, 3, 'CN Handisport Meylan 2005', 'http://julia:3000/CEG_Manager/telechargements/videos/escrime/CN_HANDISPORT_MEYLAN_2005.avi', 'http://', '', 74693504, '', '', 1, 1, 1133566995, 0, 0.0000, 0, 0);
INSERT INTO `xoops_mydownloads_downloads` VALUES (3, 6, 'Fragile', 'http://julia:3000/CEG_manager/telechargements/musique/Têtes%20Raides/Fragile.rar', 'http://', '', 43853486, '', '', 1, 1, 1133568209, 0, 0.0000, 0, 0);
INSERT INTO `xoops_mydownloads_downloads` VALUES (4, 5, 'Once', 'http://julia:3000/CEG_manager/telechargements/musique/nightwish/once.rar', 'http://', '', 65336132, '', '', 1, 1, 1133568424, 0, 0.0000, 0, 0);
INSERT INTO `xoops_mydownloads_downloads` VALUES (5, 7, 'En public', 'http://julia:3000/CEG_manager/telechargements/musique/Noir%20Désir/En%20Public.rar', 'http://', '', 129426428, '', '', 1, 1, 1133568796, 0, 0.0000, 0, 0);
INSERT INTO `xoops_mydownloads_downloads` VALUES (6, 8, 'Especial Hot Fiesta Melange', 'http://julia:3000/CEG_manager/telechargements/musique/Sangria%20Gratuite/Especial%20Hot%20Fiesta%20Melange.zip', 'http://', '', 29672579, '', '', 1, 1, 1133569095, 0, 0.0000, 0, 0);

-- --------------------------------------------------------

-- 
-- Structure de la table `xoops_mydownloads_mod`
-- 

DROP TABLE IF EXISTS `xoops_mydownloads_mod`;
CREATE TABLE IF NOT EXISTS `xoops_mydownloads_mod` (
  `requestid` int(11) unsigned NOT NULL auto_increment,
  `lid` int(11) unsigned NOT NULL default '0',
  `cid` int(5) unsigned NOT NULL default '0',
  `title` varchar(100) NOT NULL default '',
  `url` varchar(250) NOT NULL default '',
  `homepage` varchar(100) NOT NULL default '',
  `version` varchar(10) NOT NULL default '',
  `size` int(8) NOT NULL default '0',
  `platform` varchar(50) NOT NULL default '',
  `logourl` varchar(60) NOT NULL default '',
  `description` text NOT NULL,
  `modifysubmitter` int(11) NOT NULL default '0',
  PRIMARY KEY  (`requestid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- 
-- Contenu de la table `xoops_mydownloads_mod`
-- 


-- --------------------------------------------------------

-- 
-- Structure de la table `xoops_mydownloads_text`
-- 

DROP TABLE IF EXISTS `xoops_mydownloads_text`;
CREATE TABLE IF NOT EXISTS `xoops_mydownloads_text` (
  `lid` int(11) unsigned NOT NULL default '0',
  `description` text NOT NULL,
  KEY `lid` (`lid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- 
-- Contenu de la table `xoops_mydownloads_text`
-- 

INSERT INTO `xoops_mydownloads_text` VALUES (1, 'Vidéo extraite du journal télévisé de France 3 Grenoble lors du Circuit National Handisport d''escrime de Meylan (Isère - 38) en 2005');
INSERT INTO `xoops_mydownloads_text` VALUES (3, '01 - Je préfère.mp3\r\n02 - Fragile.mp3\r\n03 - Je voudrais pas crever.mp3\r\n04 - Latuvu.mp3\r\n05 - L''oraison.mp3\r\n06 - Je préfère comprendre.mp3\r\n07 - We gonna love me.mp3\r\n08 - Lové-moi.mp3\r\n09 - Constipé.mp3\r\n10 - Le raccourci.mp3\r\n11 - Houba.mp3\r\n12 - Les animaux.mp3\r\n13 - Chanson pour pieds.mp3\r\n14 - Je comprends.mp3\r\n15 - De kracht.mp3');
INSERT INTO `xoops_mydownloads_text` VALUES (4, '01 - Dark Chest Of Wonders.mp3\r\n02 - Wish I Had An Angel.mp3\r\n03 - Nemo.mp3\r\n04 - Planet Hell.mp3\r\n05 - Creek Mary''s Blood.mp3\r\n06 - The Siren.mp3\r\n07 - Dead Gardens.mp3\r\n08 - Romanticide.mp3\r\n09 - Ghost.mp3\r\n10 - Love Score.mp3\r\n11 - Higher Than Hope.mp3\r\n12 - Whtie Night Fantasy.mp3\r\n13 - Live To Tell The Tale.mp3');
INSERT INTO `xoops_mydownloads_text` VALUES (5, '01 - Pyromane.mp3\r\n02 - Septembre en attendant.mp3\r\n03 - One trip one noise.mp3\r\n04 - A l''envers à l''endroit.mp3\r\n05 - Les écorchés.mp3\r\n06 - Le grands incendie.mp3\r\n07 - Le fleuve.mp3\r\n08 - La chaleur.mp3\r\n09 - Des armes.mp3\r\n10 - Ernestine.mp3\r\n11 - Tostaky.mp3\r\n12 - Lazy.mp3\r\n\r\n01 - Si rien ne bouge.mp3\r\n02 - A l''arrière des taxis.mp3\r\n03 - Lolita nie en bloc.mp3\r\n04 - L''homme pressé.mp3\r\n05 - Des visages et des figures.mp3\r\n06 - Bouquet de nerfs.mp3\r\n07 - Le vent nous portera.mp3\r\n08 - 21st century schizoid man.mp3\r\n09 - Ces gens la.mp3\r\n10 - Comme elle vient.mp3\r\n11 - A ton étoile.mp3\r\n12 - Ce n''est pas moi qui clame.mp3');
INSERT INTO `xoops_mydownloads_text` VALUES (6, '01 Da Dou Ron Ron.mp3\r\n02 La Camioneta de Mi Papa.mp3\r\n03 Quey Coupaou Lou Capeou.mp3\r\n04 La Chica d''Hagetmau.mp3\r\n05 Bateau La.mp3\r\n06 Il a fait de la moto.mp3');

-- --------------------------------------------------------

-- 
-- Structure de la table `xoops_mydownloads_votedata`
-- 

DROP TABLE IF EXISTS `xoops_mydownloads_votedata`;
CREATE TABLE IF NOT EXISTS `xoops_mydownloads_votedata` (
  `ratingid` int(11) unsigned NOT NULL auto_increment,
  `lid` int(11) unsigned NOT NULL default '0',
  `ratinguser` int(11) NOT NULL default '0',
  `rating` tinyint(3) unsigned NOT NULL default '0',
  `ratinghostname` varchar(60) NOT NULL default '',
  `ratingtimestamp` int(10) NOT NULL default '0',
  PRIMARY KEY  (`ratingid`),
  KEY `ratinguser` (`ratinguser`),
  KEY `ratinghostname` (`ratinghostname`),
  KEY `lid` (`lid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- 
-- Contenu de la table `xoops_mydownloads_votedata`
-- 


-- --------------------------------------------------------

-- 
-- Structure de la table `xoops_newblocks`
-- 

DROP TABLE IF EXISTS `xoops_newblocks`;
CREATE TABLE IF NOT EXISTS `xoops_newblocks` (
  `bid` mediumint(8) unsigned NOT NULL auto_increment,
  `mid` smallint(5) unsigned NOT NULL default '0',
  `func_num` tinyint(3) unsigned NOT NULL default '0',
  `options` varchar(255) NOT NULL default '',
  `name` varchar(150) NOT NULL default '',
  `title` varchar(255) NOT NULL default '',
  `content` text NOT NULL,
  `side` tinyint(1) unsigned NOT NULL default '0',
  `weight` smallint(5) unsigned NOT NULL default '0',
  `visible` tinyint(1) unsigned NOT NULL default '0',
  `block_type` char(1) NOT NULL default '',
  `c_type` char(1) NOT NULL default '',
  `isactive` tinyint(1) unsigned NOT NULL default '0',
  `dirname` varchar(50) NOT NULL default '',
  `func_file` varchar(50) NOT NULL default '',
  `show_func` varchar(50) NOT NULL default '',
  `edit_func` varchar(50) NOT NULL default '',
  `template` varchar(50) NOT NULL default '',
  `bcachetime` int(10) unsigned NOT NULL default '0',
  `last_modified` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`bid`),
  KEY `mid` (`mid`),
  KEY `visible` (`visible`),
  KEY `isactive_visible_mid` (`isactive`,`visible`,`mid`),
  KEY `mid_funcnum` (`mid`,`func_num`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=19 ;

-- 
-- Contenu de la table `xoops_newblocks`
-- 

INSERT INTO `xoops_newblocks` VALUES (1, 1, 1, '', 'Menu utilisateur', 'Menu utilisateur', '', 0, 0, 1, 'S', 'H', 1, 'system', 'system_blocks.php', 'b_system_user_show', '', 'system_block_user.html', 0, 1132945674);
INSERT INTO `xoops_newblocks` VALUES (2, 1, 2, '', 'Connexion', 'Connexion', '', 0, 0, 1, 'S', 'H', 1, 'system', 'system_blocks.php', 'b_system_login_show', '', 'system_block_login.html', 0, 1132945674);
INSERT INTO `xoops_newblocks` VALUES (3, 1, 3, '', 'Recherche', 'Recherche', '', 0, 0, 0, 'S', 'H', 1, 'system', 'system_blocks.php', 'b_system_search_show', '', 'system_block_search.html', 0, 1132945674);
INSERT INTO `xoops_newblocks` VALUES (4, 1, 4, '', 'Contenu en attente', 'Contenu en attente', '', 0, 0, 0, 'S', 'H', 1, 'system', 'system_blocks.php', 'b_system_waiting_show', '', 'system_block_waiting.html', 0, 1132945674);
INSERT INTO `xoops_newblocks` VALUES (5, 1, 5, '', 'Menu principal', 'Menu principal', '', 0, 0, 1, 'S', 'H', 1, 'system', 'system_blocks.php', 'b_system_main_show', '', 'system_block_mainmenu.html', 0, 1132945674);
INSERT INTO `xoops_newblocks` VALUES (6, 1, 6, '320|190|s_poweredby.gif|1', 'Infos du site', 'Infos du site', '', 0, 0, 0, 'S', 'H', 1, 'system', 'system_blocks.php', 'b_system_info_show', 'b_system_info_edit', 'system_block_siteinfo.html', 0, 1132945674);
INSERT INTO `xoops_newblocks` VALUES (7, 1, 7, '', 'Qui est en ligne', 'Qui est en ligne', '', 0, 0, 0, 'S', 'H', 1, 'system', 'system_blocks.php', 'b_system_online_show', '', 'system_block_online.html', 0, 1132945674);
INSERT INTO `xoops_newblocks` VALUES (8, 1, 8, '10|1', 'Top envois', 'Top envois', '', 0, 0, 0, 'S', 'H', 1, 'system', 'system_blocks.php', 'b_system_topposters_show', 'b_system_topposters_edit', 'system_block_topusers.html', 0, 1132945674);
INSERT INTO `xoops_newblocks` VALUES (9, 1, 9, '10|1', 'Nouveaux membres', 'Nouveaux membres', '', 0, 0, 0, 'S', 'H', 1, 'system', 'system_blocks.php', 'b_system_newmembers_show', 'b_system_newmembers_edit', 'system_block_newusers.html', 0, 1132945674);
INSERT INTO `xoops_newblocks` VALUES (10, 1, 10, '10', 'Commentaires r&eacute;cents', 'Commentaires r&eacute;cents', '', 0, 0, 0, 'S', 'H', 1, 'system', 'system_blocks.php', 'b_system_comments_show', 'b_system_comments_edit', 'system_block_comments.html', 0, 1132945674);
INSERT INTO `xoops_newblocks` VALUES (11, 1, 11, '', 'Options de notification', 'Options de notification', '', 0, 0, 0, 'S', 'H', 1, 'system', 'system_blocks.php', 'b_system_notification_show', '', 'system_block_notification.html', 0, 1132945674);
INSERT INTO `xoops_newblocks` VALUES (12, 1, 12, '0|80', 'Th&egrave;mes', 'Th&egrave;mes', '', 0, 0, 0, 'S', 'H', 1, 'system', 'system_blocks.php', 'b_system_themes_show', 'b_system_themes_edit', 'system_block_themes.html', 0, 1132945674);
INSERT INTO `xoops_newblocks` VALUES (13, 3, 1, '10|1|time', 'Sujets r&eacute;cents', 'Sujets r&eacute;cents', '', 0, 0, 0, 'M', 'H', 1, 'newbb', 'newbb_new.php', 'b_newbb_new_show', 'b_newbb_new_edit', 'newbb_block_new.html', 0, 1132946470);
INSERT INTO `xoops_newblocks` VALUES (14, 3, 2, '10|1|views', 'Sujets les plus vus', 'Sujets les plus vus', '', 0, 0, 0, 'M', 'H', 1, 'newbb', 'newbb_new.php', 'b_newbb_new_show', 'b_newbb_new_edit', 'newbb_block_top.html', 0, 1132946470);
INSERT INTO `xoops_newblocks` VALUES (15, 3, 3, '10|1|replies', 'Sujets les plus actifs', 'Sujets les plus actifs', '', 0, 0, 0, 'M', 'H', 1, 'newbb', 'newbb_new.php', 'b_newbb_new_show', 'b_newbb_new_edit', 'newbb_block_active.html', 0, 1132946470);
INSERT INTO `xoops_newblocks` VALUES (16, 3, 4, '10|1|time', 'Sujets priv&eacute;s r&eacute;cents', 'Sujets priv&eacute;s r&eacute;cents', '', 0, 0, 0, 'M', 'H', 1, 'newbb', 'newbb_new.php', 'b_newbb_new_private_show', 'b_newbb_new_edit', 'newbb_block_prv.html', 0, 1132946470);
INSERT INTO `xoops_newblocks` VALUES (17, 4, 1, 'date|10|19', 'T&eacute;l&eacute;chargements r&eacute;cents', 'T&eacute;l&eacute;chargements r&eacute;cents', '', 0, 0, 0, 'M', 'H', 1, 'mydownloads', 'mydownloads_top.php', 'b_mydownloads_top_show', 'b_mydownloads_top_edit', 'mydownloads_block_new.html', 0, 1132946509);
INSERT INTO `xoops_newblocks` VALUES (18, 4, 2, 'hits|10|19', 'Top T&eacute;l&eacute;chargements', 'Top T&eacute;l&eacute;chargements', '', 0, 0, 0, 'M', 'H', 1, 'mydownloads', 'mydownloads_top.php', 'b_mydownloads_top_show', 'b_mydownloads_top_edit', 'mydownloads_block_top.html', 0, 1132946509);

-- --------------------------------------------------------

-- 
-- Structure de la table `xoops_online`
-- 

DROP TABLE IF EXISTS `xoops_online`;
CREATE TABLE IF NOT EXISTS `xoops_online` (
  `online_uid` mediumint(8) unsigned NOT NULL default '0',
  `online_uname` varchar(25) NOT NULL default '',
  `online_updated` int(10) unsigned NOT NULL default '0',
  `online_module` smallint(5) unsigned NOT NULL default '0',
  `online_ip` varchar(15) NOT NULL default '',
  KEY `online_module` (`online_module`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- 
-- Contenu de la table `xoops_online`
-- 


-- --------------------------------------------------------

-- 
-- Structure de la table `xoops_priv_msgs`
-- 

DROP TABLE IF EXISTS `xoops_priv_msgs`;
CREATE TABLE IF NOT EXISTS `xoops_priv_msgs` (
  `msg_id` mediumint(8) unsigned NOT NULL auto_increment,
  `msg_image` varchar(100) default NULL,
  `subject` varchar(255) NOT NULL default '',
  `from_userid` mediumint(8) unsigned NOT NULL default '0',
  `to_userid` mediumint(8) unsigned NOT NULL default '0',
  `msg_time` int(10) unsigned NOT NULL default '0',
  `msg_text` text NOT NULL,
  `read_msg` tinyint(1) unsigned NOT NULL default '0',
  PRIMARY KEY  (`msg_id`),
  KEY `to_userid` (`to_userid`),
  KEY `touseridreadmsg` (`to_userid`,`read_msg`),
  KEY `msgidfromuserid` (`msg_id`,`from_userid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- 
-- Contenu de la table `xoops_priv_msgs`
-- 


-- --------------------------------------------------------

-- 
-- Structure de la table `xoops_ranks`
-- 

DROP TABLE IF EXISTS `xoops_ranks`;
CREATE TABLE IF NOT EXISTS `xoops_ranks` (
  `rank_id` smallint(5) unsigned NOT NULL auto_increment,
  `rank_title` varchar(50) NOT NULL default '',
  `rank_min` mediumint(8) unsigned NOT NULL default '0',
  `rank_max` mediumint(8) unsigned NOT NULL default '0',
  `rank_special` tinyint(1) unsigned NOT NULL default '0',
  `rank_image` varchar(255) default NULL,
  PRIMARY KEY  (`rank_id`),
  KEY `rank_min` (`rank_min`),
  KEY `rank_max` (`rank_max`),
  KEY `rankminrankmaxranspecial` (`rank_min`,`rank_max`,`rank_special`),
  KEY `rankspecial` (`rank_special`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

-- 
-- Contenu de la table `xoops_ranks`
-- 

INSERT INTO `xoops_ranks` VALUES (1, 'Newbie', 0, 20, 0, '');
INSERT INTO `xoops_ranks` VALUES (2, 'Aspirant', 21, 40, 0, 'rank3dbf8e94a6f72.gif');
INSERT INTO `xoops_ranks` VALUES (3, 'Régulier', 41, 100, 0, 'rank3dbf8e9e7d88d.gif');
INSERT INTO `xoops_ranks` VALUES (4, 'Semi pro', 101, 300, 0, 'rank3dbf8ea81e642.gif');
INSERT INTO `xoops_ranks` VALUES (5, 'Xoops accro', 301, 10000, 0, 'rank3dbf8eb1a72e7.gif');
INSERT INTO `xoops_ranks` VALUES (6, 'Modérateur', 0, 0, 1, 'rank3dbf8edf15093.gif');
INSERT INTO `xoops_ranks` VALUES (7, 'Webmestre', 0, 0, 1, 'rank3dbf8ee8681cd.gif');

-- --------------------------------------------------------

-- 
-- Structure de la table `xoops_session`
-- 

DROP TABLE IF EXISTS `xoops_session`;
CREATE TABLE IF NOT EXISTS `xoops_session` (
  `sess_id` varchar(32) NOT NULL default '',
  `sess_updated` int(10) unsigned NOT NULL default '0',
  `sess_ip` varchar(15) NOT NULL default '',
  `sess_data` text NOT NULL,
  PRIMARY KEY  (`sess_id`),
  KEY `updated` (`sess_updated`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- 
-- Contenu de la table `xoops_session`
-- 

INSERT INTO `xoops_session` VALUES ('922044ffbacd88b24d86edcb7b3aedd0', 1132946912, '127.0.0.1', '');
INSERT INTO `xoops_session` VALUES ('4429894745360f8eda1995eae34f0d06', 1133291627, '127.0.0.1', '');
INSERT INTO `xoops_session` VALUES ('d0c492f383101173801e904e1bd88a70', 1133373461, '127.0.0.1', '');
INSERT INTO `xoops_session` VALUES ('f0ca46a69130d1bec074c53a95b7cb88', 1133569431, '127.0.0.1', '');
INSERT INTO `xoops_session` VALUES ('1843e52b2d3d111faa8135d28f331dbc', 1133609333, '127.0.0.1', '');
INSERT INTO `xoops_session` VALUES ('5bf48a91322115a9b1f71970dc718277', 1133647809, '127.0.0.1', 'xoopsUserId|s:1:"1";xoopsUserGroups|a:2:{i:0;s:1:"1";i:1;s:1:"2";}xoopsUserTheme|s:7:"default";');
INSERT INTO `xoops_session` VALUES ('841408d808d5e003ab7fb7b845f09306', 1134154874, '127.0.0.1', '');
INSERT INTO `xoops_session` VALUES ('b91159cb7cc43647879e1e947275a788', 1134322846, '127.0.0.1', '');
INSERT INTO `xoops_session` VALUES ('caacdf71f2b877362a1d174c3c22cf36', 1134323667, '127.0.0.1', '');

-- --------------------------------------------------------

-- 
-- Structure de la table `xoops_smiles`
-- 

DROP TABLE IF EXISTS `xoops_smiles`;
CREATE TABLE IF NOT EXISTS `xoops_smiles` (
  `id` smallint(5) unsigned NOT NULL auto_increment,
  `code` varchar(50) NOT NULL default '',
  `smile_url` varchar(100) NOT NULL default '',
  `emotion` varchar(75) NOT NULL default '',
  `display` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=18 ;

-- 
-- Contenu de la table `xoops_smiles`
-- 

INSERT INTO `xoops_smiles` VALUES (1, ':-D', 'smil3dbd4d4e4c4f2.gif', 'Très heureux', 1);
INSERT INTO `xoops_smiles` VALUES (2, ':-)', 'smil3dbd4d6422f04.gif', 'Content', 1);
INSERT INTO `xoops_smiles` VALUES (3, ':-(', 'smil3dbd4d75edb5e.gif', 'Triste', 1);
INSERT INTO `xoops_smiles` VALUES (4, ':-o', 'smil3dbd4d8676346.gif', 'Surpris', 1);
INSERT INTO `xoops_smiles` VALUES (5, ':-?', 'smil3dbd4d99c6eaa.gif', 'Confus', 1);
INSERT INTO `xoops_smiles` VALUES (6, '8-)', 'smil3dbd4daabd491.gif', 'Cool', 1);
INSERT INTO `xoops_smiles` VALUES (7, ':lol:', 'smil3dbd4dbc14f3f.gif', 'Mort de rire', 1);
INSERT INTO `xoops_smiles` VALUES (8, ':-x', 'smil3dbd4dcd7b9f4.gif', 'Fou', 1);
INSERT INTO `xoops_smiles` VALUES (9, ':-P', 'smil3dbd4ddd6835f.gif', 'Ironique', 1);
INSERT INTO `xoops_smiles` VALUES (10, ':oops:', 'smil3dbd4df1944ee.gif', 'Embarrasé', 0);
INSERT INTO `xoops_smiles` VALUES (11, ':cry:', 'smil3dbd4e02c5440.gif', 'Pleur (très triste)', 0);
INSERT INTO `xoops_smiles` VALUES (12, ':evil:', 'smil3dbd4e1748cc9.gif', 'Mauvais ou très Fou', 0);
INSERT INTO `xoops_smiles` VALUES (13, ':roll:', 'smil3dbd4e29bbcc7.gif', 'je fais l''innocent', 0);
INSERT INTO `xoops_smiles` VALUES (14, ';-)', 'smil3dbd4e398ff7b.gif', 'Clin d''oeil', 0);
INSERT INTO `xoops_smiles` VALUES (15, ':pint:', 'smil3dbd4e4c2e742.gif', 'Une autre pinte de bière', 0);
INSERT INTO `xoops_smiles` VALUES (16, ':hammer:', 'smil3dbd4e5e7563a.gif', 'En plein travail', 0);
INSERT INTO `xoops_smiles` VALUES (17, ':idea:', 'smil3dbd4e7853679.gif', 'J''ai une idée', 0);

-- --------------------------------------------------------

-- 
-- Structure de la table `xoops_tplfile`
-- 

DROP TABLE IF EXISTS `xoops_tplfile`;
CREATE TABLE IF NOT EXISTS `xoops_tplfile` (
  `tpl_id` mediumint(7) unsigned NOT NULL auto_increment,
  `tpl_refid` smallint(5) unsigned NOT NULL default '0',
  `tpl_module` varchar(25) NOT NULL default '',
  `tpl_tplset` varchar(50) NOT NULL default '',
  `tpl_file` varchar(50) NOT NULL default '',
  `tpl_desc` varchar(255) NOT NULL default '',
  `tpl_lastmodified` int(10) unsigned NOT NULL default '0',
  `tpl_lastimported` int(10) unsigned NOT NULL default '0',
  `tpl_type` varchar(20) NOT NULL default '',
  PRIMARY KEY  (`tpl_id`),
  KEY `tpl_refid` (`tpl_refid`,`tpl_type`),
  KEY `tpl_tplset` (`tpl_tplset`,`tpl_file`(10))
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=51 ;

-- 
-- Contenu de la table `xoops_tplfile`
-- 

INSERT INTO `xoops_tplfile` VALUES (1, 1, 'system', 'default', 'system_imagemanager.html', '', 1132945674, 1132945674, 'module');
INSERT INTO `xoops_tplfile` VALUES (2, 1, 'system', 'default', 'system_imagemanager2.html', '', 1132945674, 1132945674, 'module');
INSERT INTO `xoops_tplfile` VALUES (3, 1, 'system', 'default', 'system_userinfo.html', '', 1132945674, 1132945674, 'module');
INSERT INTO `xoops_tplfile` VALUES (4, 1, 'system', 'default', 'system_userform.html', '', 1132945674, 1132945674, 'module');
INSERT INTO `xoops_tplfile` VALUES (5, 1, 'system', 'default', 'system_rss.html', '', 1132945674, 1132945674, 'module');
INSERT INTO `xoops_tplfile` VALUES (6, 1, 'system', 'default', 'system_redirect.html', '', 1132945674, 1132945674, 'module');
INSERT INTO `xoops_tplfile` VALUES (7, 1, 'system', 'default', 'system_comment.html', '', 1132945674, 1132945674, 'module');
INSERT INTO `xoops_tplfile` VALUES (8, 1, 'system', 'default', 'system_comments_flat.html', '', 1132945674, 1132945674, 'module');
INSERT INTO `xoops_tplfile` VALUES (9, 1, 'system', 'default', 'system_comments_thread.html', '', 1132945674, 1132945674, 'module');
INSERT INTO `xoops_tplfile` VALUES (10, 1, 'system', 'default', 'system_comments_nest.html', '', 1132945674, 1132945674, 'module');
INSERT INTO `xoops_tplfile` VALUES (11, 1, 'system', 'default', 'system_siteclosed.html', '', 1132945674, 1132945674, 'module');
INSERT INTO `xoops_tplfile` VALUES (12, 1, 'system', 'default', 'system_dummy.html', 'Dummy template file for holding non-template contents. This should not be edited.', 1132945674, 1132945674, 'module');
INSERT INTO `xoops_tplfile` VALUES (13, 1, 'system', 'default', 'system_notification_list.html', '', 1132945674, 1132945674, 'module');
INSERT INTO `xoops_tplfile` VALUES (14, 1, 'system', 'default', 'system_notification_select.html', '', 1132945674, 1132945674, 'module');
INSERT INTO `xoops_tplfile` VALUES (15, 1, 'system', 'default', 'system_block_user.html', 'Shows user block', 1132945674, 1132945674, 'block');
INSERT INTO `xoops_tplfile` VALUES (16, 2, 'system', 'default', 'system_block_login.html', 'Shows login form', 1132945674, 1132945674, 'block');
INSERT INTO `xoops_tplfile` VALUES (17, 3, 'system', 'default', 'system_block_search.html', 'Shows search form block', 1132945674, 1132945674, 'block');
INSERT INTO `xoops_tplfile` VALUES (18, 4, 'system', 'default', 'system_block_waiting.html', 'Shows contents waiting for approval', 1132945674, 1132945674, 'block');
INSERT INTO `xoops_tplfile` VALUES (19, 5, 'system', 'default', 'system_block_mainmenu.html', 'Shows the main navigation menu of the site', 1132945674, 1132945674, 'block');
INSERT INTO `xoops_tplfile` VALUES (20, 6, 'system', 'default', 'system_block_siteinfo.html', 'Shows basic info about the site and a link to Recommend Us pop up window', 1132945674, 1132945674, 'block');
INSERT INTO `xoops_tplfile` VALUES (21, 7, 'system', 'default', 'system_block_online.html', 'Displays users/guests currently online', 1132945674, 1132945674, 'block');
INSERT INTO `xoops_tplfile` VALUES (22, 8, 'system', 'default', 'system_block_topusers.html', 'Top posters', 1132945674, 1132945674, 'block');
INSERT INTO `xoops_tplfile` VALUES (23, 9, 'system', 'default', 'system_block_newusers.html', 'Shows most recent users', 1132945674, 1132945674, 'block');
INSERT INTO `xoops_tplfile` VALUES (24, 10, 'system', 'default', 'system_block_comments.html', 'Shows most recent comments', 1132945674, 1132945674, 'block');
INSERT INTO `xoops_tplfile` VALUES (25, 11, 'system', 'default', 'system_block_notification.html', 'Shows notification options', 1132945674, 1132945674, 'block');
INSERT INTO `xoops_tplfile` VALUES (26, 12, 'system', 'default', 'system_block_themes.html', 'Shows theme selection box', 1132945674, 1132945674, 'block');
INSERT INTO `xoops_tplfile` VALUES (27, 2, 'xoopsmembers', 'default', 'xoopsmembers_searchform.html', '', 1132946402, 0, 'module');
INSERT INTO `xoops_tplfile` VALUES (28, 2, 'xoopsmembers', 'default', 'xoopsmembers_searchresults.html', '', 1132946402, 0, 'module');
INSERT INTO `xoops_tplfile` VALUES (29, 3, 'newbb', 'default', 'newbb_index.html', '', 1132946467, 0, 'module');
INSERT INTO `xoops_tplfile` VALUES (30, 3, 'newbb', 'default', 'newbb_search.html', '', 1132946468, 0, 'module');
INSERT INTO `xoops_tplfile` VALUES (31, 3, 'newbb', 'default', 'newbb_searchresults.html', '', 1132946468, 0, 'module');
INSERT INTO `xoops_tplfile` VALUES (32, 3, 'newbb', 'default', 'newbb_thread.html', '', 1132946468, 0, 'module');
INSERT INTO `xoops_tplfile` VALUES (33, 3, 'newbb', 'default', 'newbb_viewforum.html', '', 1132946468, 0, 'module');
INSERT INTO `xoops_tplfile` VALUES (34, 3, 'newbb', 'default', 'newbb_viewtopic_flat.html', '', 1132946469, 0, 'module');
INSERT INTO `xoops_tplfile` VALUES (35, 3, 'newbb', 'default', 'newbb_viewtopic_thread.html', '', 1132946469, 0, 'module');
INSERT INTO `xoops_tplfile` VALUES (36, 13, 'newbb', 'default', 'newbb_block_new.html', 'Shows recent topics in the forums', 1132946470, 0, 'block');
INSERT INTO `xoops_tplfile` VALUES (37, 14, 'newbb', 'default', 'newbb_block_top.html', 'Shows most viewed topics in the forums', 1132946470, 0, 'block');
INSERT INTO `xoops_tplfile` VALUES (38, 15, 'newbb', 'default', 'newbb_block_active.html', 'Shows most active topics in the forums', 1132946470, 0, 'block');
INSERT INTO `xoops_tplfile` VALUES (39, 16, 'newbb', 'default', 'newbb_block_prv.html', 'Shows recent and private topics in the forums', 1132946470, 0, 'block');
INSERT INTO `xoops_tplfile` VALUES (40, 4, 'mydownloads', 'default', 'mydownloads_brokenfile.html', '', 1132946507, 0, 'module');
INSERT INTO `xoops_tplfile` VALUES (41, 4, 'mydownloads', 'default', 'mydownloads_download.html', '', 1132946507, 0, 'module');
INSERT INTO `xoops_tplfile` VALUES (42, 4, 'mydownloads', 'default', 'mydownloads_index.html', '', 1132946508, 0, 'module');
INSERT INTO `xoops_tplfile` VALUES (43, 4, 'mydownloads', 'default', 'mydownloads_modfile.html', '', 1132946508, 0, 'module');
INSERT INTO `xoops_tplfile` VALUES (44, 4, 'mydownloads', 'default', 'mydownloads_ratefile.html', '', 1132946508, 0, 'module');
INSERT INTO `xoops_tplfile` VALUES (45, 4, 'mydownloads', 'default', 'mydownloads_singlefile.html', '', 1132946508, 0, 'module');
INSERT INTO `xoops_tplfile` VALUES (46, 4, 'mydownloads', 'default', 'mydownloads_submit.html', '', 1132946508, 0, 'module');
INSERT INTO `xoops_tplfile` VALUES (47, 4, 'mydownloads', 'default', 'mydownloads_topten.html', '', 1132946509, 0, 'module');
INSERT INTO `xoops_tplfile` VALUES (48, 4, 'mydownloads', 'default', 'mydownloads_viewcat.html', '', 1132946509, 0, 'module');
INSERT INTO `xoops_tplfile` VALUES (49, 17, 'mydownloads', 'default', 'mydownloads_block_new.html', 'Shows recently added donwload files', 1132946509, 0, 'block');
INSERT INTO `xoops_tplfile` VALUES (50, 18, 'mydownloads', 'default', 'mydownloads_block_top.html', 'Shows most downloaded files', 1132946509, 0, 'block');

-- --------------------------------------------------------

-- 
-- Structure de la table `xoops_tplset`
-- 

DROP TABLE IF EXISTS `xoops_tplset`;
CREATE TABLE IF NOT EXISTS `xoops_tplset` (
  `tplset_id` int(7) unsigned NOT NULL auto_increment,
  `tplset_name` varchar(50) NOT NULL default '',
  `tplset_desc` varchar(255) NOT NULL default '',
  `tplset_credits` text NOT NULL,
  `tplset_created` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`tplset_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

-- 
-- Contenu de la table `xoops_tplset`
-- 

INSERT INTO `xoops_tplset` VALUES (1, 'default', 'XOOPS Default Template Set', '', 1132945674);

-- --------------------------------------------------------

-- 
-- Structure de la table `xoops_tplsource`
-- 

DROP TABLE IF EXISTS `xoops_tplsource`;
CREATE TABLE IF NOT EXISTS `xoops_tplsource` (
  `tpl_id` mediumint(7) unsigned NOT NULL default '0',
  `tpl_source` mediumtext NOT NULL,
  KEY `tpl_id` (`tpl_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- 
-- Contenu de la table `xoops_tplsource`
-- 

INSERT INTO `xoops_tplsource` VALUES (1, '<!DOCTYPE html PUBLIC ''//W3C//DTD XHTML 1.0 Transitional//EN'' ''http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd''>\r\n<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<{$xoops_langcode}>" lang="<{$xoops_langcode}>">\r\n<head>\r\n<meta http-equiv="content-type" content="text/html; charset=<{$xoops_charset}>" />\r\n<meta http-equiv="content-language" content="<{$xoops_langcode}>" />\r\n<title><{$sitename}> <{$lang_imgmanager}></title>\r\n<script type="text/javascript">\r\n<!--//\r\nfunction appendCode(addCode) {\r\n	var targetDom = window.opener.xoopsGetElementById(''<{$target}>'');\r\n	if (targetDom.createTextRange && targetDom.caretPos){\r\n  		var caretPos = targetDom.caretPos;\r\n		caretPos.text = caretPos.text.charAt(caretPos.text.length - 1) \r\n== '' '' ? addCode + '' '' : addCode;  \r\n	} else if (targetDom.getSelection && targetDom.caretPos){\r\n		var caretPos = targetDom.caretPos;\r\n		caretPos.text = caretPos.text.charat(caretPos.text.length - 1)  \r\n== '' '' ? addCode + '' '' : addCode;\r\n	} else {\r\n		targetDom.value = targetDom.value + addCode;\r\n  	}\r\n	window.close();\r\n	return;\r\n}\r\n//-->\r\n</script>\r\n<style type="text/css" media="all">\r\nbody {margin: 0;}\r\nimg {border: 0;}\r\ntable {width: 100%; margin: 0;}\r\na:link {color: #3a76d6; font-weight: bold; background-color: transparent;}\r\na:visited {color: #9eb2d6; font-weight: bold; background-color: transparent;}\r\na:hover {color: #e18a00; background-color: transparent;}\r\ntable td {background-color: white; font-size: 12px; padding: 0; border-width: 0; vertical-align: top; font-family: Verdana, Arial, Helvetica, sans-serif;}\r\ntable#imagenav td {vertical-align: bottom; padding: 5px;}\r\ntable#imagemain td {border-right: 1px solid silver; border-bottom: 1px solid silver; padding: 5px; vertical-align: middle;}\r\ntable#imagemain th {border: 0; background-color: #2F5376; color:white; font-size: 12px; padding: 5px; vertical-align: top; text-align:center; font-family: Verdana, Arial, Helvetica, sans-serif;}\r\ntable#header td {width: 100%; background-color: #2F5376; vertical-align: middle;}\r\ntable#header td#headerbar {border-bottom: 1px solid silver; background-color: #dddddd;}\r\ndiv#pagenav {text-align:center;}\r\ndiv#footer {text-align:right; padding: 5px;}\r\n</style>\r\n</head>\r\n\r\n<body onload="window.resizeTo(<{$xsize}>, <{$ysize}>);">\r\n  <table id="header" cellspacing="0">\r\n    <tr>\r\n      <td><a href="<{$xoops_url}>/"><img src="<{$xoops_url}>/images/logo.gif" width="150" height="80" alt="" /></a></td><td> </td>\r\n    </tr>\r\n    <tr>\r\n      <td id="headerbar" colspan="2"> </td>\r\n    </tr>\r\n  </table>\r\n\r\n  <form action="imagemanager.php" method="get">\r\n    <table cellspacing="0" id="imagenav">\r\n      <tr>\r\n        <td>\r\n          <select name="cat_id" onchange="location=''<{$xoops_url}>/imagemanager.php?target=<{$target}>&cat_id=''+this.options[this.selectedIndex].value"><{$cat_options}></select> <input type="hidden" name="target" value="<{$target}>" /><input type="submit" value="<{$lang_go}>" />\r\n        </td>\r\n\r\n        <{if $show_cat > 0}>\r\n        <td align="right"><a href="<{$xoops_url}>/imagemanager.php?target=<{$target}>&op=upload&imgcat_id=<{$show_cat}>"><{$lang_addimage}></a></td>\r\n        <{/if}>\r\n\r\n      </tr>\r\n    </table>\r\n  </form>\r\n\r\n  <{if $image_total > 0}>\r\n\r\n  <table cellspacing="0" id="imagemain">\r\n    <tr>\r\n      <th><{$lang_imagename}></th>\r\n      <th><{$lang_image}></th>\r\n      <th><{$lang_imagemime}></th>\r\n      <th><{$lang_align}></th>\r\n    </tr>\r\n\r\n    <{section name=i loop=$images}>\r\n    <tr align="center">\r\n      <td><input type="hidden" name="image_id[]" value="<{$images[i].id}>" /><{$images[i].nicename}></td>\r\n      <td><img src="<{$images[i].src}>" alt="" /></td>\r\n      <td><{$images[i].mimetype}></td>\r\n      <td><a href="#" onclick="javascript:appendCode(''<{$images[i].lxcode}>'');"><img src="<{$xoops_url}>/images/alignleft.gif" alt="Left" /></a> <a href="#" onclick="javascript:appendCode(''<{$images[i].xcode}>'');"><img src="<{$xoops_url}>/images/aligncenter.gif" alt="Center" /></a> <a href="#" onclick="javascript:appendCode(''<{$images[i].rxcode}>'');"><img src="<{$xoops_url}>/images/alignright.gif" alt="Right" /></a></td>\r\n    </tr>\r\n    <{/section}>\r\n  </table>\r\n\r\n  <{/if}>\r\n\r\n  <div id="pagenav"><{$pagenav}></div>\r\n\r\n  <div id="footer">\r\n    <input value="<{$lang_close}>" type="button" onclick="javascript:window.close();" />\r\n  </div>\r\n\r\n  </body>\r\n</html>');
INSERT INTO `xoops_tplsource` VALUES (2, '<!DOCTYPE html PUBLIC ''//W3C//DTD XHTML 1.0 Transitional//EN'' ''http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd''>\r\n<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<{$xoops_langcode}>" lang="<{$xoops_langcode}>">\r\n<head>\r\n<meta http-equiv="content-type" content="text/html; charset=<{$xoops_charset}>" />\r\n<meta http-equiv="content-language" content="<{$xoops_langcode}>" />\r\n<title><{$xoops_sitename}> <{$lang_imgmanager}></title>\r\n<{$image_form.javascript}>\r\n<style type="text/css" media="all">\r\nbody {margin: 0;}\r\nimg {border: 0;}\r\ntable {width: 100%; margin: 0;}\r\na:link {color: #3a76d6; font-weight: bold; background-color: transparent;}\r\na:visited {color: #9eb2d6; font-weight: bold; background-color: transparent;}\r\na:hover {color: #e18a00; background-color: transparent;}\r\ntable td {background-color: white; font-size: 12px; padding: 0; border-width: 0; vertical-align: top; font-family: Verdana, Arial, Helvetica, sans-serif;}\r\ntable#imagenav td {vertical-align: bottom; padding: 5px;}\r\ntd.body {padding: 5px; vertical-align: middle;}\r\ntd.caption {border: 0; background-color: #2F5376; color:white; font-size: 12px; padding: 5px; vertical-align: top; text-align:left; font-family: Verdana, Arial, Helvetica, sans-serif;}\r\ntable#imageform {border: 1px solid silver;}\r\ntable#header td {width: 100%; background-color: #2F5376; vertical-align: middle;}\r\ntable#header td#headerbar {border-bottom: 1px solid silver; background-color: #dddddd;}\r\ndiv#footer {text-align:right; padding: 5px;}\r\n</style>\r\n</head>\r\n\r\n<body onload="window.resizeTo(<{$xsize}>, <{$ysize}>);">\r\n  <table id="header" cellspacing="0">\r\n    <tr>\r\n      <td><a href="<{$xoops_url}>/"><img src="<{$xoops_url}>/images/logo.gif" width="150" height="80" alt="" /></a></td><td> </td>\r\n    </tr>\r\n    <tr>\r\n      <td id="headerbar" colspan="2"> </td>\r\n    </tr>\r\n  </table>\r\n\r\n  <table cellspacing="0" id="imagenav">\r\n    <tr>\r\n      <td align="left"><a href="<{$xoops_url}>/imagemanager.php?target=<{$target}>&cat_id=<{$show_cat}>"><{$lang_imgmanager}></a></td>\r\n    </tr>\r\n  </table>\r\n\r\n  <form name="<{$image_form.name}>" id="<{$image_form.name}>" action="<{$image_form.action}>" method="<{$image_form.method}>" <{$image_form.extra}>>\r\n    <table id="imageform" cellspacing="0">\r\n    <!-- start of form elements loop -->\r\n    <{foreach item=element from=$image_form.elements}>\r\n      <{if $element.hidden != true}>\r\n      <tr valign="top">\r\n        <td class="caption"><{$element.caption}></td>\r\n        <td class="body"><{$element.body}></td>\r\n      </tr>\r\n      <{else}>\r\n      <{$element.body}>\r\n      <{/if}>\r\n    <{/foreach}>\r\n    <!-- end of form elements loop -->\r\n    </table>\r\n  </form>\r\n\r\n\r\n  <div id="footer">\r\n    <input value="<{$lang_close}>" type="button" onclick="javascript:window.close();" />\r\n  </div>\r\n\r\n  </body>\r\n</html>');
INSERT INTO `xoops_tplsource` VALUES (3, '<{if $user_ownpage == true}>\r\n\r\n<form name="usernav" action="user.php" method="post">\r\n\r\n<br /><br />\r\n\r\n<table width="70%" align="center" border="0">\r\n  <tr align="center">\r\n    <td><input type="button" value="<{$lang_editprofile}>" onclick="location=''edituser.php''" />\r\n    <input type="button" value="<{$lang_avatar}>" onclick="location=''edituser.php?op=avatarform''" />\r\n    <input type="button" value="<{$lang_inbox}>" onclick="location=''viewpmsg.php''" />\r\n\r\n    <{if $user_candelete == true}>\r\n    <input type="button" value="<{$lang_deleteaccount}>" onclick="location=''user.php?op=delete''" />\r\n    <{/if}>\r\n\r\n    <input type="button" value="<{$lang_logout}>" onclick="location=''user.php?op=logout''" /></td>\r\n  </tr>\r\n</table>\r\n</form>\r\n\r\n<br /><br />\r\n<{elseif $xoops_isadmin != false}>\r\n\r\n<br /><br />\r\n\r\n<table width="70%" align="center" border="0">\r\n  <tr align="center">\r\n    <td><input type="button" value="<{$lang_editprofile}>" onclick="location=''<{$xoops_url}>/modules/system/admin.php?fct=users&uid=<{$user_uid}>&op=modifyUser''" />\r\n    <input type="button" value="<{$lang_deleteaccount}>" onclick="location=''<{$xoops_url}>/modules/system/admin.php?fct=users&op=delUser&uid=<{$user_uid}>''" />\r\n  </tr>\r\n</table>\r\n\r\n<br /><br />\r\n<{/if}>\r\n\r\n<table width="100%" border="0" cellspacing="5">\r\n  <tr valign="top">\r\n    <td width="50%">\r\n      <table class="outer" cellpadding="4" cellspacing="1" width="100%">\r\n        <tr>\r\n          <th colspan="2" align="center"><{$lang_allaboutuser}></th>\r\n        </tr>\r\n        <tr valign="top">\r\n          <td class="head"><{$lang_avatar}></td>\r\n          <td align="center" class="even"><img src="<{$user_avatarurl}>" alt="Avatar" /></td>\r\n        </tr>\r\n        <tr>\r\n          <td class="head"><{$lang_realname}></td>\r\n          <td align="center" class="odd"><{$user_realname}></td>\r\n        </tr>\r\n        <tr>\r\n          <td class="head"><{$lang_website}></td>\r\n          <td class="even"><{$user_websiteurl}></td>\r\n        </tr>\r\n        <tr valign="top">\r\n          <td class="head"><{$lang_email}></td>\r\n          <td class="odd"><{$user_email}></td>\r\n        </tr>\r\n	<tr valign="top">\r\n          <td class="head"><{$lang_privmsg}></td>\r\n          <td class="even"><{$user_pmlink}></td>\r\n        </tr>\r\n        <tr valign="top">\r\n          <td class="head"><{$lang_icq}></td>\r\n          <td class="odd"><{$user_icq}></td>\r\n        </tr>\r\n        <tr valign="top">\r\n          <td class="head"><{$lang_aim}></td>\r\n          <td class="even"><{$user_aim}></td>\r\n        </tr>\r\n        <tr valign="top">\r\n          <td class="head"><{$lang_yim}></td>\r\n          <td class="odd"><{$user_yim}></td>\r\n        </tr>\r\n        <tr valign="top">\r\n          <td class="head"><{$lang_msnm}></td>\r\n          <td class="even"><{$user_msnm}></td>\r\n        </tr>\r\n        <tr valign="top">\r\n          <td class="head"><{$lang_location}></td>\r\n          <td class="odd"><{$user_location}></td>\r\n        </tr>\r\n        <tr valign="top">\r\n          <td class="head"><{$lang_occupation}></td>\r\n          <td class="even"><{$user_occupation}></td>\r\n        </tr>\r\n        <tr valign="top">\r\n          <td class="head"><{$lang_interest}></td>\r\n          <td class="odd"><{$user_interest}></td>\r\n        </tr>\r\n        <tr valign="top">\r\n          <td class="head"><{$lang_extrainfo}></td>\r\n          <td class="even"><{$user_extrainfo}></td>\r\n        </tr>\r\n      </table>\r\n    </td>\r\n    <td width="50%">\r\n      <table class="outer" cellpadding="4" cellspacing="1" width="100%">\r\n        <tr valign="top">\r\n          <th colspan="2" align="center"><{$lang_statistics}></th>\r\n        </tr>\r\n        <tr valign="top">\r\n          <td class="head"><{$lang_membersince}></td>\r\n          <td align="center" class="even"><{$user_joindate}></td>\r\n        </tr>\r\n        <tr valign="top">\r\n          <td class="head"><{$lang_rank}></td>\r\n          <td align="center" class="odd"><{$user_rankimage}><br /><{$user_ranktitle}></td>\r\n        </tr>\r\n        <tr valign="top">\r\n          <td class="head"><{$lang_posts}></td>\r\n          <td align="center" class="even"><{$user_posts}></td>\r\n        </tr>\r\n	<tr valign="top">\r\n          <td class="head"><{$lang_lastlogin}></td>\r\n          <td align="center" class="odd"><{$user_lastlogin}></td>\r\n        </tr>\r\n      </table>\r\n      <br />\r\n      <table class="outer" cellpadding="4" cellspacing="1" width="100%">\r\n        <tr valign="top">\r\n          <th colspan="2" align="center"><{$lang_signature}></th>\r\n        </tr>\r\n        <tr valign="top">\r\n          <td class="even"><{$user_signature}></td>\r\n        </tr>\r\n      </table>\r\n    </td>\r\n  </tr>\r\n</table>\r\n\r\n<!-- start module search results loop -->\r\n<{foreach item=module from=$modules}>\r\n\r\n<p>\r\n<h4><{$module.name}></h4>\r\n\r\n  <!-- start results item loop -->\r\n  <{foreach item=result from=$module.results}>\r\n\r\n  <img src="<{$result.image}>" alt="<{$module.name}>" /><b><a href="<{$result.link}>"><{$result.title}></a></b><br /><small>(<{$result.time}>)</small><br />\r\n\r\n  <{/foreach}>\r\n  <!-- end results item loop -->\r\n\r\n<{$module.showall_link}>\r\n</p>\r\n\r\n<{/foreach}>\r\n<!-- end module search results loop -->\r\n');
INSERT INTO `xoops_tplsource` VALUES (4, '<fieldset style="padding: 10px;">\r\n  <legend style="font-weight: bold;"><{$lang_login}></legend>\r\n  <form action="user.php" method="post">\r\n    <{$lang_username}> <input type="text" name="uname" size="26" maxlength="25" value="<{$usercookie}>" /><br />\r\n    <{$lang_password}> <input type="password" name="pass" size="21" maxlength="32" /><br />\r\n    <input type="hidden" name="op" value="login" />\r\n    <input type="hidden" name="xoops_redirect" value="<{$redirect_page}>" />\r\n    <input type="submit" value="<{$lang_login}>" />\r\n  </form>\r\n  <a name="lost"></a>\r\n  <div><{$lang_notregister}><br /></div>\r\n</fieldset>\r\n\r\n<br />\r\n\r\n<fieldset style="padding: 10px;">\r\n  <legend style="font-weight: bold;"><{$lang_lostpassword}></legend>\r\n  <div><br /><{$lang_noproblem}></div>\r\n  <form action="lostpass.php" method="post">\r\n    <{$lang_youremail}> <input type="text" name="email" size="26" maxlength="60" />&nbsp;&nbsp;<input type="hidden" name="op" value="mailpasswd" /><input type="submit" value="<{$lang_sendpassword}>" />\r\n  </form>\r\n</fieldset>');
INSERT INTO `xoops_tplsource` VALUES (5, '<?xml version="1.0" encoding="UTF-8"?>\r\n<rss version="2.0">\r\n  <channel>\r\n    <title><{$channel_title}></title>\r\n    <link><{$channel_link}></link>\r\n    <description><{$channel_desc}></description>\r\n    <lastBuildDate><{$channel_lastbuild}></lastBuildDate>\r\n    <docs>http://backend.userland.com/rss/</docs>\r\n    <generator><{$channel_generator}></generator>\r\n    <category><{$channel_category}></category>\r\n    <managingEditor><{$channel_editor}></managingEditor>\r\n    <webMaster><{$channel_webmaster}></webMaster>\r\n    <language><{$channel_language}></language>\r\n    <{if $image_url != ""}>\r\n    <image>\r\n      <title><{$channel_title}></title>\r\n      <url><{$image_url}></url>\r\n      <link><{$channel_link}></link>\r\n      <width><{$image_width}></width>\r\n      <height><{$image_height}></height>\r\n    </image>\r\n    <{/if}>\r\n    <{foreach item=item from=$items}>\r\n    <item>\r\n      <title><{$item.title}></title>\r\n      <link><{$item.link}></link>\r\n      <description><{$item.description}></description>\r\n      <pubDate><{$item.pubdate}></pubDate>\r\n      <guid><{$item.guid}></guid>\r\n    </item>\r\n    <{/foreach}>\r\n  </channel>\r\n</rss>');
INSERT INTO `xoops_tplsource` VALUES (6, '<html>\r\n<head>\r\n<meta http-equiv="Content-Type" content="text/html; charset=<{$xoops_charset}>" />\r\n<meta http-equiv="Refresh" content="<{$time}>; url=<{$url}>" />\r\n<title><{$xoops_sitename}></title>\r\n</head>\r\n<body>\r\n<div style="text-align:center; background-color: #EBEBEB; border-top: 1px solid #FFFFFF; border-left: 1px solid #FFFFFF; border-right: 1px solid #AAAAAA; border-bottom: 1px solid #AAAAAA; font-weight : bold;">\r\n  <h4><{$message}></h4>\r\n  <p><{$lang_ifnotreload}></p>\r\n</div>\r\n</body>\r\n</html>');
INSERT INTO `xoops_tplsource` VALUES (7, '<!-- start comment post -->\r\n        <tr>\r\n          <td class="head"><a id="comment<{$comment.id}>"></a> <{$comment.poster.uname}></td>\r\n          <td class="head"><div class="comDate"><span class="comDateCaption"><{$lang_posted}>:</span> <{$comment.date_posted}>&nbsp;&nbsp;<span class="comDateCaption"><{$lang_updated}>:</span> <{$comment.date_modified}></div></td>\r\n        </tr>\r\n        <tr>\r\n\r\n          <{if $comment.poster.id != 0}>\r\n\r\n          <td class="odd"><div class="comUserRank"><div class="comUserRankText"><{$comment.poster.rank_title}></div><img class="comUserRankImg" src="<{$xoops_upload_url}>/<{$comment.poster.rank_image}>" alt="" /></div><img class="comUserImg" src="<{$xoops_upload_url}>/<{$comment.poster.avatar}>" alt="" /><div class="comUserStat"><span class="comUserStatCaption"><{$lang_joined}>:</span> <{$comment.poster.regdate}></div><div class="comUserStat"><span class="comUserStatCaption"><{$lang_from}>:</span> <{$comment.poster.from}></div><div class="comUserStat"><span class="comUserStatCaption"><{$lang_posts}>:</span> <{$comment.poster.postnum}></div><div class="comUserStatus"><{$comment.poster.status}></div></td>\r\n\r\n          <{else}>\r\n\r\n          <td class="odd"> </td>\r\n\r\n          <{/if}>\r\n\r\n          <td class="odd">\r\n            <div class="comTitle"><{$comment.image}><{$comment.title}></div><div class="comText"><{$comment.text}></div>\r\n          </td>\r\n        </tr>\r\n        <tr>\r\n          <td class="even"></td>\r\n\r\n          <{if $xoops_iscommentadmin == true}>\r\n\r\n          <td class="even" align="right">\r\n            <a href="<{$editcomment_link}>&amp;com_id=<{$comment.id}>"><img src="<{$xoops_url}>/images/icons/edit.gif" alt="<{$lang_edit}>" /></a><a href="<{$deletecomment_link}>&amp;com_id=<{$comment.id}>"><img src="<{$xoops_url}>/images/icons/delete.gif" alt="<{$lang_delete}>" /></a><a href="<{$replycomment_link}>&amp;com_id=<{$comment.id}>"><img src="<{$xoops_url}>/images/icons/reply.gif" alt="<{$lang_reply}>" /></a>\r\n          </td>\r\n\r\n          <{elseif $xoops_isuser == true && $xoops_userid == $comment.poster.id}>\r\n\r\n          <td class="even" align="right">\r\n            <a href="<{$editcomment_link}>&amp;com_id=<{$comment.id}>"><img src="<{$xoops_url}>/images/icons/edit.gif" alt="<{$lang_edit}>" /></a><a href="<{$replycomment_link}>&amp;com_id=<{$comment.id}>"><img src="<{$xoops_url}>/images/icons/reply.gif" alt="<{$lang_reply}>" /></a>\r\n          </td>\r\n\r\n          <{elseif $xoops_isuser == true || $anon_canpost == true}>\r\n\r\n          <td class="even" align="right">\r\n            <a href="<{$replycomment_link}>&amp;com_id=<{$comment.id}>"><img src="<{$xoops_url}>/images/icons/reply.gif" alt="<{$lang_reply}>" /></a>\r\n          </td>\r\n\r\n          <{else}>\r\n\r\n          <td class="even"> </td>\r\n\r\n          <{/if}>\r\n\r\n        </tr>\r\n<!-- end comment post -->');
INSERT INTO `xoops_tplsource` VALUES (8, '<table class="outer" cellpadding="5" cellspacing="1">\r\n  <tr>\r\n    <th width="20%"><{$lang_poster}></td>\r\n    <th><{$lang_thread}></td>\r\n  </tr>\r\n  <{foreach item=comment from=$comments}>\r\n    <{include file="db:system_comment.html" comment=$comment}>\r\n  <{/foreach}>\r\n</table>');
INSERT INTO `xoops_tplsource` VALUES (9, '<{section name=i loop=$comments}>\r\n<br />\r\n<table cellspacing="1" class="outer">\r\n  <tr>\r\n    <th width="20%"><{$lang_poster}></th>\r\n    <th><{$lang_thread}></th>\r\n  </tr>\r\n  <{include file="db:system_comment.html" comment=$comments[i]}>\r\n</table>\r\n\r\n<{if $show_threadnav == true}>\r\n<div style="text-align:left; margin:3px; padding: 5px;">\r\n<a href="<{$comment_url}>"><{$lang_top}></a> | <a href="<{$comment_url}>&amp;com_id=<{$comments[i].pid}>&amp;com_rootid=<{$comments[i].rootid}>#newscomment<{$comments[i].pid}>"><{$lang_parent}></a>\r\n</div>\r\n<{/if}>\r\n\r\n<{if $comments[i].show_replies == true}>\r\n<!-- start comment tree -->\r\n<br />\r\n<table cellspacing="1" class="outer">\r\n  <tr>\r\n    <th width="50%"><{$lang_subject}></th>\r\n    <th width="20%" align="center"><{$lang_poster}></th>\r\n    <th align="right"><{$lang_posted}></th>\r\n  </tr>\r\n  <{foreach item=reply from=$comments[i].replies}>\r\n  <tr>\r\n    <td class="even"><{$reply.prefix}> <a href="<{$comment_url}>&amp;com_id=<{$reply.id}>&amp;com_rootid=<{$reply.root_id}>"><{$reply.title}></a></td>\r\n    <td class="odd" align="center"><{$reply.poster.uname}></td>\r\n    <td class="even" align="right"><{$reply.date_posted}></td>\r\n  </tr>\r\n  <{/foreach}>\r\n</table>\r\n<!-- end comment tree -->\r\n<{/if}>\r\n\r\n<{/section}>');
INSERT INTO `xoops_tplsource` VALUES (10, '<{section name=i loop=$comments}>\r\n<br />\r\n<table cellspacing="1" class="outer">\r\n  <tr>\r\n    <th width="20%"><{$lang_poster}></th>\r\n    <th><{$lang_thread}></th>\r\n  </tr>\r\n  <{include file="db:system_comment.html" comment=$comments[i]}>\r\n</table>\r\n\r\n<!-- start comment replies -->\r\n<{foreach item=reply from=$comments[i].replies}>\r\n<br />\r\n<table cellspacing="0" border="0">\r\n  <tr>\r\n    <td width="<{$reply.prefix}>"></td>\r\n    <td>\r\n      <table class="outer" cellspacing="1">\r\n        <tr>\r\n          <th width="20%"><{$lang_poster}></th>\r\n          <th><{$lang_thread}></th>\r\n        </tr>\r\n        <{include file="db:system_comment.html" comment=$reply}>\r\n      </table>\r\n    </td>\r\n  </tr>\r\n</table>\r\n<{/foreach}>\r\n<!-- end comment tree -->\r\n<{/section}>');
INSERT INTO `xoops_tplsource` VALUES (11, '<!DOCTYPE html PUBLIC ''//W3C//DTD XHTML 1.0 Transitional//EN'' ''http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd''>\r\n<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<{$xoops_langcode}>" lang="<{$xoops_langcode}>">\r\n<head>\r\n<meta http-equiv="content-type" content="text/html; charset=<{$xoops_charset}>" />\r\n<meta http-equiv="content-language" content="<{$xoops_langcode}>" />\r\n<title><{$xoops_sitename}></title>\r\n<link rel="stylesheet" type="text/css" media="all" href="<{$xoops_url}>/xoops.css" />\r\n\r\n</head>\r\n<body>\r\n  <table cellspacing="0">\r\n    <tr id="header">\r\n      <td style="width: 150px; background-color: #2F5376; vertical-align: middle; text-align:center;"><a href="<{$xoops_url}>/"><img src="<{$xoops_imageurl}>logo.gif" width="150" alt="" /></a></td>\r\n      <td style="width: 100%; background-color: #2F5376; vertical-align: middle; text-align:center;">&nbsp;</td>\r\n    </tr>\r\n    <tr>\r\n      <td style="height: 8px; border-bottom: 1px solid silver; background-color: #dddddd;" colspan="2">&nbsp;</td>\r\n    </tr>\r\n  </table>\r\n\r\n  <table cellspacing="1" align="center" width="80%" border="0" cellpadding="10px;">\r\n    <tr>\r\n      <td align="center"><div style="background-color: #DDFFDF; color: #136C99; text-align: center; border-top: 1px solid #DDDDFF; border-left: 1px solid #DDDDFF; border-right: 1px solid #AAAAAA; border-bottom: 1px solid #AAAAAA; font-weight: bold; padding: 10px;"><{$lang_siteclosemsg}></div></td>\r\n    </tr>\r\n  </table>\r\n  \r\n  <form action="<{$xoops_url}>/user.php" method="post">\r\n    <table cellspacing="0" align="center" style="border: 1px solid silver; width: 200px;">\r\n      <tr>\r\n        <th style="background-color: #2F5376; color: #FFFFFF; padding : 2px; vertical-align : middle;" colspan="2"><{$lang_login}></th>\r\n      </tr>\r\n      <tr>\r\n        <td style="padding: 2px;"><{$lang_username}></td><td style="padding: 2px;"><input type="text" name="uname" size="12" value="" /></td>\r\n      </tr>\r\n      <tr>\r\n        <td style="padding: 2px;"><{$lang_password}></td><td style="padding: 2px;"><input type="password" name="pass" size="12" /></td>\r\n      </tr>\r\n      <tr>\r\n        <td style="padding: 2px;">&nbsp;</td>\r\n        <td style="padding: 2px;"><input type="hidden" name="xoops_login" value="1" /><input type="submit" value="<{$lang_login}>" /></td>\r\n      </tr>\r\n    </table>\r\n  </form>\r\n\r\n  <table cellspacing="0" width="100%">\r\n    <td style="height:8px; border-bottom: 1px solid silver; border-top: 1px solid silver; background-color: #dddddd;" colspan="2">&nbsp;</td>\r\n  </table>\r\n\r\n  </body>\r\n</html>');
INSERT INTO `xoops_tplsource` VALUES (12, '<{$dummy_content}>');
INSERT INTO `xoops_tplsource` VALUES (13, '<h4><{$lang_activenotifications}></h4>\r\n<form name="notificationlist" action="notifications.php" method="post">\r\n<table class="outer">\r\n  <tr>\r\n    <th><input name="allbox" id="allbox" onclick="xoopsCheckGroup(''notificationlist'', ''allbox'', ''del_mod[]'');" type="checkbox" value="<{$lang_checkall}>" /></th>\r\n    <th><{$lang_event}></th>\r\n    <th><{$lang_category}></th>\r\n    <th><{$lang_itemid}></th>\r\n    <th><{$lang_itemname}></th>\r\n  </tr>\r\n  <{foreach item=module from=$modules}>\r\n  <tr>\r\n    <td class="head"><input name="del_mod[<{$module.id}>]" id="del_mod[]" onclick="xoopsCheckGroup(''notificationlist'', ''del_mod[<{$module.id}>]'', ''del_not[<{$module.id}>][]'');" type="checkbox" value="<{$module.id}>" /></td>\r\n    <td class="head" colspan="4"><{$lang_module}>: <{$module.name}></td>\r\n  </tr>\r\n  <{foreach item=category from=$module.categories}>\r\n  <{foreach item=item from=$category.items}>\r\n  <{foreach item=notification from=$item.notifications}>\r\n  <tr>\r\n    <{cycle values=odd,even assign=class}>\r\n    <td class="<{$class}>"><input type="checkbox" name="del_not[<{$module.id}>][]" id="del_not[<{$module.id}>][]" value="<{$notification.id}>" /></td>\r\n    <td class="<{$class}>"><{$notification.event_title}></td>\r\n    <td class="<{$class}>"><{$notification.category_title}></td>\r\n    <td class="<{$class}>"><{if $item.id != 0}><{$item.id}><{/if}></td>\r\n    <td class="<{$class}>"><{if $item.id != 0}><{if $item.url != ''''}><a href="<{$item.url}>"><{/if}><{$item.name}><{if $item.url != ''''}></a><{/if}><{/if}></td>\r\n  </tr>\r\n  <{/foreach}>\r\n  <{/foreach}>\r\n  <{/foreach}>\r\n  <{/foreach}>\r\n  <tr>\r\n    <td class="foot" colspan="5">\r\n      <input type="submit" name="delete_cancel" value="<{$lang_cancel}>" />\r\n      <input type="reset" name="delete_reset" value="<{$lang_clear}>" />\r\n      <input type="submit" name="delete" value="<{$lang_delete}>" />\r\n    </td>\r\n  </tr>\r\n</table>\r\n</form>\r\n');
INSERT INTO `xoops_tplsource` VALUES (14, '<{if $xoops_notification.show}>\r\n<form name="notification_select" action="<{$xoops_notification.target_page}>" method="post">\r\n<h4 style="text-align:center;"><{$lang_activenotifications}></h4>\r\n<input type="hidden" name="not_redirect" value="<{$xoops_notification.redirect_script}>" />\r\n<table class="outer">\r\n  <tr><th colspan="3"><{$lang_notificationoptions}></th></tr>\r\n  <tr>\r\n    <td class="head"><{$lang_category}></td>\r\n    <td class="head"><input name="allbox" id="allbox" onclick="xoopsCheckAll(''notification_select'',''allbox'');" type="checkbox" value="<{$lang_checkall}>" /></td>\r\n    <td class="head"><{$lang_events}></td>\r\n  </tr>\r\n  <{foreach name=outer item=category from=$xoops_notification.categories}>\r\n  <{foreach name=inner item=event from=$category.events}>\r\n  <tr>\r\n    <{if $smarty.foreach.inner.first}>\r\n    <td class="even" rowspan="<{$smarty.foreach.inner.total}>"><{$category.title}></td>\r\n    <{/if}>\r\n    <td class="odd">\r\n    <{counter assign=index}>\r\n    <input type="hidden" name="not_list[<{$index}>][params]" value="<{$category.name}>,<{$category.itemid}>,<{$event.name}>" />\r\n    <input type="checkbox" id="not_list[]" name="not_list[<{$index}>][status]" value="1" <{if $event.subscribed}>checked="checked"<{/if}> />\r\n    </td>\r\n    <td class="odd"><{$event.caption}></td>\r\n  </tr>\r\n  <{/foreach}>\r\n  <{/foreach}>\r\n  <tr>\r\n    <td class="foot" colspan="3" align="center"><input type="submit" name="not_submit" value="<{$lang_updatenow}>" /></td>\r\n  </tr>\r\n</table>\r\n<div align="center">\r\n<{$lang_notificationmethodis}>:&nbsp;<{$user_method}>&nbsp;&nbsp;[<a href="<{$editprofile_url}>"><{$lang_change}></a>]\r\n</div>\r\n</form>\r\n<{/if}>');
INSERT INTO `xoops_tplsource` VALUES (15, '<table cellspacing="0">\r\n  <tr>\r\n    <td id="usermenu">\r\n      <a class="menuTop" href="<{$xoops_url}>/user.php"><{$block.lang_youraccount}></a>\r\n      <a href="<{$xoops_url}>/edituser.php"><{$block.lang_editaccount}></a>\r\n      <a href="<{$xoops_url}>/notifications.php"><{$block.lang_notifications}></a>\r\n      <a href="<{$xoops_url}>/user.php?op=logout"><{$block.lang_logout}></a>\r\n      <{if $block.new_messages > 0}>\r\n        <a class="highlight" href="<{$xoops_url}>/viewpmsg.php"><{$block.lang_inbox}> (<span style="color:#ff0000; font-weight: bold;"><{$block.new_messages}></span>)</a>\r\n      <{else}>\r\n        <a href="<{$xoops_url}>/viewpmsg.php"><{$block.lang_inbox}></a>\r\n      <{/if}>\r\n\r\n      <{if $xoops_isadmin}>\r\n        <a href="<{$xoops_url}>/admin.php"><{$block.lang_adminmenu}></a>\r\n      <{/if}>\r\n    </td>\r\n  </tr>\r\n</table>\r\n');
INSERT INTO `xoops_tplsource` VALUES (16, '<form style="margin-top: 0px;" action="<{$xoops_url}>/user.php" method="post">\r\n    <{$block.lang_username}><br />\r\n    <input type="text" name="uname" size="12" value="<{$block.unamevalue}>" maxlength="25" /><br />\r\n    <{$block.lang_password}><br />\r\n    <input type="password" name="pass" size="12" maxlength="32" /><br />\r\n    <!-- <input type="checkbox" name="rememberme" value="On" class ="formButton" /><{$block.lang_rememberme}><br /> //-->\r\n    <input type="hidden" name="xoops_redirect" value="<{$xoops_requesturi}>" />\r\n    <input type="hidden" name="op" value="login" />\r\n    <input type="submit" value="<{$block.lang_login}>" /><br />\r\n    <{$block.sslloginlink}>\r\n</form>\r\n<a href="<{$xoops_url}>/user.php#lost"><{$block.lang_lostpass}></a>\r\n<br /><br />\r\n<a href="<{$xoops_url}>/register.php"><{$block.lang_registernow}></a>');
INSERT INTO `xoops_tplsource` VALUES (17, '<form style="margin-top: 0px;" action="<{$xoops_url}>/search.php" method="get">\r\n  <input type="text" name="query" size="14" /><input type="hidden" name="action" value="results" /><br /><input type="submit" value="<{$block.lang_search}>" />\r\n</form>\r\n<a href="<{$xoops_url}>/search.php"><{$block.lang_advsearch}></a>');
INSERT INTO `xoops_tplsource` VALUES (18, '<ul>\r\n  <{foreach item=module from=$block.modules}>\r\n  <li><a href="<{$module.adminlink}>"><{$module.lang_linkname}></a>: <{$module.pendingnum}></li>\r\n  <{/foreach}>\r\n</ul>');
INSERT INTO `xoops_tplsource` VALUES (19, '<table cellspacing="0">\r\n  <tr>\r\n    <td id="mainmenu">\r\n      <a class="menuTop" href="<{$xoops_url}>/"><{$block.lang_home}></a>\r\n      <!-- start module menu loop -->\r\n      <{foreach item=module from=$block.modules}>\r\n      <a class="menuMain" href="<{$xoops_url}>/modules/<{$module.directory}>/"><{$module.name}></a>\r\n        <{foreach item=sublink from=$module.sublinks}>\r\n          <a class="menuSub" href="<{$sublink.url}>"><{$sublink.name}></a>\r\n        <{/foreach}>\r\n      <{/foreach}>\r\n      <!-- end module menu loop -->\r\n    </td>\r\n  </tr>\r\n</table>');
INSERT INTO `xoops_tplsource` VALUES (20, '<table class="outer" cellspacing="0">\r\n\r\n  <{if $block.showgroups == true}>\r\n\r\n  <!-- start group loop -->\r\n  <{foreach item=group from=$block.groups}>\r\n  <tr>\r\n    <th colspan="2"><{$group.name}></th>\r\n  </tr>\r\n\r\n  <!-- start group member loop -->\r\n  <{foreach item=user from=$group.users}>\r\n  <tr>\r\n    <td class="even" valign="middle" align="center"><img src="<{$user.avatar}>" alt="" width="32" /><br /><a href="<{$xoops_url}>/userinfo.php?uid=<{$user.id}>"><{$user.name}></a></td><td class="odd" width="20%" align="right" valign="middle"><{$user.msglink}></td>\r\n  </tr>\r\n  <{/foreach}>\r\n  <!-- end group member loop -->\r\n\r\n  <{/foreach}>\r\n  <!-- end group loop -->\r\n  <{/if}>\r\n</table>\r\n\r\n<br />\r\n\r\n<div style="margin: 3px; text-align:center;">\r\n  <img src="<{$block.logourl}>" alt="" border="0" /><br /><{$block.recommendlink}>\r\n</div>');
INSERT INTO `xoops_tplsource` VALUES (21, '<{$block.online_total}><br /><br /><{$block.lang_members}>: <{$block.online_members}><br /><{$block.lang_guests}>: <{$block.online_guests}><br /><br /><{$block.online_names}> <a href="javascript:openWithSelfMain(''<{$xoops_url}>/misc.php?action=showpopups&amp;type=online'',''Online'',420,350);"><{$block.lang_more}></a>');
INSERT INTO `xoops_tplsource` VALUES (22, '<table cellspacing="1" class="outer">\r\n  <{foreach item=user from=$block.users}>\r\n  <tr class="<{cycle values="even,odd"}>" valign="middle">\r\n    <td><{$user.rank}></td>\r\n    <td align="center">\r\n      <{if $user.avatar != ""}>\r\n      <img src="<{$user.avatar}>" alt="" width="32" /><br />\r\n      <{/if}>\r\n      <a href="<{$xoops_url}>/userinfo.php?uid=<{$user.id}>"><{$user.name}></a>\r\n    </td>\r\n    <td align="center"><{$user.posts}></td>\r\n  </tr>\r\n  <{/foreach}>\r\n</table>\r\n');
INSERT INTO `xoops_tplsource` VALUES (23, '<table cellspacing="1" class="outer">\r\n  <{foreach item=user from=$block.users}>\r\n    <tr class="<{cycle values="even,odd"}>" valign="middle">\r\n      <td align="center">\r\n      <{if $user.avatar != ""}>\r\n      <img src="<{$user.avatar}>" alt="" width="32" /><br />\r\n      <{/if}>\r\n      <a href="<{$xoops_url}>/userinfo.php?uid=<{$user.id}>"><{$user.name}></a>\r\n      </td>\r\n      <td align="center"><{$user.joindate}></td>\r\n    </tr>\r\n  <{/foreach}>\r\n</table>\r\n');
INSERT INTO `xoops_tplsource` VALUES (24, '<table width="100%" cellspacing="1" class="outer">\r\n  <{foreach item=comment from=$block.comments}>\r\n  <tr class="<{cycle values="even,odd"}>">\r\n    <td align="center"><img src="<{$xoops_url}>/images/subject/<{$comment.icon}>" alt="" /></td>\r\n    <td><{$comment.title}></td>\r\n    <td align="center"><{$comment.module}></td>\r\n    <td align="center"><{$comment.poster}></td>\r\n    <td align="right"><{$comment.time}></td>\r\n  </tr>\r\n  <{/foreach}>\r\n</table>');
INSERT INTO `xoops_tplsource` VALUES (25, '<form action="<{$block.target_page}>" method="post">\r\n<table class="outer">\r\n  <{foreach item=category from=$block.categories}>\r\n  <{foreach name=inner item=event from=$category.events}>\r\n  <{if $smarty.foreach.inner.first}>\r\n  <tr>\r\n    <td class="head" colspan="2"><{$category.title}></td>\r\n  </tr>\r\n  <{/if}>\r\n  <tr>\r\n    <td class="odd"><{counter assign=index}><input type="hidden" name="not_list[<{$index}>][params]" value="<{$category.name}>,<{$category.itemid}>,<{$event.name}>" /><input type="checkbox" name="not_list[<{$index}>][status]" value="1" <{if $event.subscribed}>checked="checked"<{/if}> /></td>\r\n    <td class="odd"><{$event.caption}></td>\r\n  </tr>\r\n  <{/foreach}>\r\n  <{/foreach}>\r\n  <tr>\r\n    <td class="foot" colspan="2"><input type="hidden" name="not_redirect" value="<{$block.redirect_script}>"><input type="submit" name="not_submit" value="<{$block.submit_button}>" /></td>\r\n  </tr>\r\n</table>\r\n</form>');
INSERT INTO `xoops_tplsource` VALUES (26, '<div style="text-align: center;">\r\n<form action="index.php" method="post">\r\n<{$block.theme_select}>\r\n</form>\r\n</div>');
INSERT INTO `xoops_tplsource` VALUES (27, '<h4 style=''text-align:left;''><{$lang_search}></h4>(<{$lang_totalusers}>)\r\n\r\n<{$searchform.javascript}>\r\n<b><{$searchform.title}></b>\r\n<br /><br />\r\n<form name="<{$searchform.name}>" action="<{$searchform.action}>" method="<{$searchform.method}>" <{$searchform.extra}>>\r\n  <table class="outer" cellpadding="4" cellspacing="1">\r\n    <!-- start of form elements loop -->\r\n    <{foreach item=element from=$searchform.elements}>\r\n      <{if $element.hidden != true}>\r\n      <tr>\r\n        <td class="head"><b><{$element.caption}></b></td>\r\n        <td class="<{cycle values="even,odd"}>"><{$element.body}></td>\r\n      </tr>\r\n      <{else}>\r\n      <{$element.body}>\r\n      <{/if}>\r\n    <{/foreach}>\r\n    <!-- end of form elements loop -->\r\n  </table>\r\n</form>');
INSERT INTO `xoops_tplsource` VALUES (28, '<a href="index.php"><{$lang_search}></a>&nbsp;<span style="font-weight:bold;">&raquo;&raquo;</span>&nbsp;<{$lang_results}><br /><br />\r\n\r\n<{if $total_found != 0}>\r\n<table class="outer" cellspacing="1" cellpadding="4">\r\n  <tr>\r\n    <th align="center"><{$lang_avatar}></th><th align="center"><{$lang_username}></th><th align="center"><{$lang_realname}></th><th align="center"><{$lang_email}></th><th align="center"><{$lang_privmsg}></th><th align="center"><{$lang_url}></th><th align="center"><{$lang_regdate}></th><th align="center"><{$lang_lastlogin}></th><th align="center"><{$lang_posts}></th>\r\n    <{if $is_admin == true}>\r\n    <th align="center"><{$lang_admin}></th>\r\n    <{/if}>\r\n  </tr>\r\n  <{section name=i loop=$users}>\r\n  <tr valign="middle">\r\n    <td class="even"><{$users[i].avatar}></td><td class="odd"><a href="<{$xoops_url}>/userinfo.php?uid=<{$users[i].id}>"><{$users[i].name}></a></td><td class="even"><{$users[i].realname}></td><td align="center" class="odd"><{$users[i].email}></td><td class="even" align="center"><{$users[i].pmlink}></td><td class="odd" align="center"><{$users[i].website}></td><td class="even" align="center"><{$users[i].registerdate}></td><td class="odd" align="center"><{$users[i].lastlogin}></td><td class="even" align="center"><{$users[i].posts}></td>\r\n    <{if $is_admin == true}><td class="odd" align="center"><{$users[i].adminlink}></td><{/if}>\r\n  </tr>\r\n  <{/section}>\r\n</table>\r\n<div style="text-align:center">\r\n  <{$pagenav}>\r\n  <{$lang_numfound}>\r\n</div>\r\n<{else}>\r\n  <{$lang_nonefound}>\r\n<{/if}>');
INSERT INTO `xoops_tplsource` VALUES (29, '<!-- start module contents -->\r\n<table cellspacing="0" width="100%">\r\n  <tr>\r\n    <td colspan="2"><b><{$lang_welcomemsg}></b><br /><small><{$lang_tostart}></small><hr /></td>\r\n  </tr>\r\n  <tr valign="bottom">\r\n    <td><small><{$lang_totaltopics}><b><{$total_topics}></b> | <{$lang_totalposts}><b><{$total_posts}></b></small><br /><br /><a href="<{$xoops_url}>/modules/newbb/index.php"><{$forum_index_title}></a></td>\r\n    <td align="right"><small><{$lang_currenttime}><br /><{$lang_lastvisit}></small></td>\r\n  </tr>\r\n</table>\r\n<br />\r\n\r\n<!-- start forum categories -->\r\n<{section name=category loop=$categories}>\r\n<table cellspacing="1" class="outer">\r\n  <tr align="left" valign="top"><th colspan="6"> <a href="<{$xoops_url}>/modules/newbb/index.php?cat=<{$categories[category].cat_id}>"><{$categories[category].cat_title}></a></th></tr>\r\n  <tr class="head" align="center">\r\n    <td>&nbsp;</td>\r\n	<td nowrap="nowrap" align="left"><{$lang_forum}></td>\r\n	<td nowrap="nowrap"><{$lang_topics}></td>\r\n	<td nowrap="nowrap"><{$lang_posts}></td>\r\n	<td nowrap="nowrap"><{$lang_lastpost}></td>\r\n  </tr>\r\n  <!-- start forums -->\r\n  <{section name=forum loop=$categories[category].forums.forum_id}>\r\n  <tr>\r\n    <td class="even" align="center" valign="middle" width="5%"><img src="<{$categories[category].forums.forum_folder[forum]}>" alt="" /></td>\r\n    <td class="odd" onclick="window.location=''<{$xoops_url}>/modules/newbb/viewforum.php?forum=<{$categories[category].forums.forum_id[forum]}>''"><a href="<{$xoops_url}>/modules/newbb/viewforum.php?forum=<{$categories[category].forums.forum_id[forum]}>"><b><{$categories[category].forums.forum_name[forum]}></b></a><br /><{$categories[category].forums.forum_desc[forum]}><br /><span style="font-size:smaller;"><b><{$lang_moderators}></b> <{$categories[category].forums.forum_moderators[forum]}></span></td>\r\n    <td class="even" width="5%" align="center" valign="middle"><{$categories[category].forums.forum_topics[forum]}></td>\r\n    <td class="odd" width="5%" align="center" valign="middle"><{$categories[category].forums.forum_posts[forum]}></td>\r\n    <td class="even" width="20%" align="center" valign="middle"><{$categories[category].forums.forum_lastpost_time[forum]}><br /><{$categories[category].forums.forum_lastpost_user[forum]}> <{$categories[category].forums.forum_lastpost_icon[forum]}></td>\r\n  </tr>\r\n  <{/section}>\r\n  <!-- end forums -->\r\n</table>\r\n<img src="images/pixel.gif" height="5" alt="" /><br />\r\n<{/section}>\r\n<!-- end forum categories -->\r\n\r\n<form name="search" action="search.php" method="post">\r\n  <table width="100%">\r\n    <tr>\r\n      <td valign="middle"><img src="<{$img_hotfolder}>" alt="" /> = <{$lang_newposts}><br /><img src="<{$img_folder}>" alt="" /> = <{$lang_nonewposts}><br />  <img src="<{$img_locked}>" alt="" /> = <{$lang_private}></td>\r\n      <td align="right" valign="bottom"><b><{$lang_search}></b>&nbsp;<input name="term" type="text" size="20" /><input type="hidden" name="forum" value="all" /><input type="hidden" name="sortby" value="p.post_time desc" /><input type="hidden" name="searchboth" value="both" /><input type="hidden" name="submit" value="<{$lang_search}>" /><br />[ <a href="<{$xoops_url}>/modules/newbb/search.php"><{$lang_advsearch}></a> ]</td>\r\n    </tr>\r\n  </table>\r\n</form>\r\n<{include file=''db:system_notification_select.html''}>\r\n<!-- end module contents -->');
INSERT INTO `xoops_tplsource` VALUES (30, '<!-- start module contents -->\r\n<table border="0" cellpadding="5" align="center">\r\n  <tr>\r\n    <td colspan="2" align="left"><img src="<{$img_folder}>" alt="" />&nbsp;&nbsp;<a href="<{$xoops_url}>/modules/newbb/index.php"><{$lang_forumindex}></a><br />&nbsp;&nbsp;&nbsp;<img src="<{$img_folder}>" alt="" />&nbsp;&nbsp;<{$lang_search}></td>\r\n  </tr>\r\n</table>\r\n\r\n<form name="Search" action="search.php" method="post">\r\n  <table class="outer" border="0" cellpadding="1" cellspacing="0" align="center" width="95%">\r\n    <tr>\r\n      <td>\r\n        <table border="0" cellpadding="1" cellspacing="1" width="100%" class="head">\r\n          <tr>\r\n            <td class="head" width="50%" align="right"><b><{$lang_keywords}></b>&nbsp;</td>\r\n            <td class="even" width="50%"><input type="text" name="term" /></td>\r\n          </tr>\r\n          <tr>\r\n            <td class="head" width="50%">&nbsp;</td>\r\n            <td class="even" width="50%"><input type="radio" name="addterms" value="any" checked="checked" /><{$lang_searchany}></td>\r\n          </tr>\r\n          <tr>\r\n            <td class="head" width="50%">&nbsp;</td>\r\n            <td class="even" width="50%"><input type="radio" name="addterms" value="all" /><{$lang_searchall}></td>\r\n          </tr>\r\n          <tr>\r\n            <td class="head" width="50%" align="right"><b><{$lang_forumc}></b>&nbsp;</td>\r\n            <td class="even" width="50%"><{$forum_selection_box}></td>\r\n          </tr>\r\n	  <tr>\r\n            <td class="head" width="50%" align="right"><b><{$lang_author}></b>&nbsp;</td>\r\n            <td class="even" width="50%"><input type="text" name="search_username" /></td>\r\n          </tr>\r\n          <tr>\r\n            <td class="head" width="50%" align="right"><b><{$lang_sortby}></b>&nbsp;</td>\r\n            <td class="even" width="50%"><input type="radio" name="sortby" value="p.post_time desc" checked="checked" /><{$lang_date}>&nbsp;&nbsp;<input type="radio" name="sortby" value="t.topic_title" /><{$lang_topic}>&nbsp;&nbsp;<input type="radio" name="sortby" value="f.forum_name" /><{$lang_forum}>&nbsp;&nbsp;<input type="radio" name="sortby" value="u.uname" /><{$lang_username}>&nbsp;&nbsp;</td>\r\n          </tr>\r\n          <tr>\r\n            <td class="head" width="50%" align="right"><b><{$lang_searchin}></b>&nbsp;</td>\r\n            <td class="even" width="50%"><input type="radio" name="searchboth" value="title" /><{$lang_subject}>&nbsp;&nbsp;<input type="radio" name="searchboth" value="text" checked="checked" /><{$lang_body}>&nbsp;&nbsp;<input type="radio" name="searchboth" value="both" /><{$lang_subject}> & <{$lang_body}>&nbsp;&nbsp;</td>\r\n          </tr>\r\n          <tr>\r\n            <td class="head" width="50%" align="right">&nbsp;</td>\r\n            <td class="even"><input type="submit" name="submit" value="<{$lang_search}>" /></td>\r\n        </table>\r\n      </td>\r\n    </tr>\r\n  </table>\r\n</form>\r\n<!-- end module contents -->');
INSERT INTO `xoops_tplsource` VALUES (31, '<!-- start module contents -->\r\n<table border="0" cellpadding="5" align="center">\r\n  <tr>\r\n    <td colspan="2" align="left"><img src="<{$img_folder}>" alt="" />&nbsp;&nbsp;<a href="<{$xoops_url}>/modules/newbb/index.php"><{$lang_forumindex}></a><br />&nbsp;&nbsp;&nbsp;<img src="<{$img_folder}>" alt="" />&nbsp;&nbsp;<a href="search.php"><{$lang_search}></a><br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp<img src="<{$img_folder}>" alt="" />&nbsp;&nbsp;<{$lang_searchresults}></td>\r\n  </tr>\r\n</table>\r\n\r\n<table class="outer" border="0" cellpadding="0" cellspacing="0" align="center" width="95%">\r\n  <tr>\r\n    <td>\r\n      <table border="0" cellpadding="4" cellspacing="1" width="100%">\r\n        <tr class="head" align="center">\r\n			<td><{$lang_forum}></td>\r\n			<td><{$lang_topic}></td>\r\n			<td><{$lang_author}></td>\r\n			<td><{$lang_replies}></td>\r\n			<td><{$lang_views}></td>\r\n			<td nowrap><{$lang_possttime}></td>\r\n        </tr>\r\n        <!-- start search results -->\r\n		<{section name=i loop=$results}>\r\n        <!-- start each result -->\r\n        <tr align="center">\r\n          <td class="even"><a href="viewforum.php?forum=<{$results[i].forum_id}>"><{$results[i].forum_name}></a></td>\r\n          <td class="odd"><a href="viewtopic.php?topic_id=<{$results[i].topic_id}>&amp;forum=<{$results[i].forum_id}>"><{$results[i].topic_title}></a></td>\r\n          <td class="even"><a href="<{$xoops_url}>/userinfo.php?uid=<{$results[i].user_id}>"><{$results[i].user_name}></a></td>\r\n          <td class="odd"><{$results[i].topic_replies}></td>\r\n          <td class="even"><{$results[i].topic_views}></td>\r\n          <td class="odd"><{$results[i].post_time}></td>\r\n        </tr>\r\n        <!-- end each result -->\r\n        <{/section}>\r\n        <!-- end search results -->\r\n      </table>\r\n    </td>\r\n  </tr>\r\n</table>\r\n<br />\r\n<form name="Search" action="search.php" method="post">\r\n  <table class="outer" border="0" cellpadding="1" cellspacing="0" align="center" width="95%">\r\n    <tr>\r\n      <td>\r\n        <table border="0" cellpadding="1" cellspacing="1" width="100%" class="head">\r\n          <tr>\r\n            <td class="head" width="50%" align="right"><b><{$lang_keywords}></b>&nbsp;</td>\r\n            <td class="even" width="50%"><input type="text" name="term" /></td>\r\n          </tr>\r\n          <tr>\r\n            <td class="head" width="50%">&nbsp;</td>\r\n            <td class="even" width="50%"><input type="radio" name="addterms" value="any" checked="checked" /><{$lang_searchany}></td>\r\n          </tr>\r\n          <tr>\r\n            <td class="head" width="50%">&nbsp;</td>\r\n            <td class="even" width="50%"><input type="radio" name="addterms" value="all" /><{$lang_searchall}></td>\r\n          </tr>\r\n            <td class="head" width="50%" align="right"><b><{$lang_author}></b>&nbsp;</td>\r\n            <td class="even" width="50%"><input type="text" name="search_username" /></td>\r\n          </tr>\r\n            <td class="head" width="50%" align="right">&nbsp;</td>\r\n            <td class="even"><input type="submit" name="submit" value="<{$lang_search}>" /></td>\r\n        </table>\r\n      </td>\r\n    </tr>\r\n  </table>\r\n</form>\r\n<!-- end module contents -->');
INSERT INTO `xoops_tplsource` VALUES (32, '<!-- start comment post -->\r\n        <tr>\r\n          <td class="head"><a id="forumpost<{$topic_post.post_id}>"></a> <{$topic_post.poster_uname}></td>\r\n          <td class="head"><div class="comDate"><span class="comDateCaption"><{$lang_postedon}></span> <{$topic_post.post_date}></div></td>\r\n        </tr>\r\n        <tr>\r\n\r\n          <{if $topic_post.poster_uid != 0}>\r\n\r\n          <td class="odd"><div class="comUserRank"><div class="comUserRankText"><{$topic_post.poster_rank_title}></div><{$topic_post.poster_rank_image}></div><img class="comUserImg" src="<{$xoops_upload_url}>/<{$topic_post.poster_avatar}>" alt="" /><div class="comUserStat"><span class="comUserStatCaption"><{$lang_joined}>:</span> <{$topic_post.poster_regdate}></div><div class="comUserStat"><span class="comUserStatCaption"><{$lang_from}>:</span> <{$topic_post.poster_from}></div><div class="comUserStat"><span class="comUserStatCaption"><{$lang_posts}>:</span> <{$topic_post.poster_postnum}></div><div class="comUserStatus"><{$topic_post.poster_status}></div></td>\r\n\r\n          <{else}>\r\n\r\n          <td class="odd"> </td>\r\n\r\n          <{/if}>\r\n\r\n          <td class="odd">\r\n            <div class="comTitle"><{$topic_post.post_title}></div><div class="comText"><{$topic_post.post_text}></div>\r\n          </td>\r\n        </tr>\r\n        <tr>\r\n          <td class="even"></td>\r\n\r\n          <{if $viewer_is_admin == true}>\r\n\r\n          <td class="even" align="right">\r\n            <a href="edit.php?forum=<{$forum_id}>&amp;post_id=<{$topic_post.post_id}>&amp;topic_id=<{$topic_id}>&amp;viewmode=<{$topic_viewmode}>&amp;order=<{$topic_order}>"><img src="<{$xoops_url}>/images/icons/edit.gif" alt="<{$lang_edit}>" /></a><a href=''delete.php?forum=<{$forum_id}>&amp;topic_id=<{$topic_id}>&amp;post_id=<{$topic_post.post_id}>&amp;viewmode=<{$topic_viewmode}>&amp;order=<{$topic_order}>''><img src="<{$xoops_url}>/images/icons/delete.gif" alt="<{$lang_delete}>" /></a><a href=''reply.php?forum=<{$forum_id}>&amp;post_id=<{$topic_post.post_id}>&amp;topic_id=<{$topic_id}>&amp;viewmode=<{$topic_viewmode}>&amp;order=<{$topic_order}>''><img src="<{$xoops_url}>/images/icons/reply.gif" alt="<{$lang_reply}>" /></a>\r\n          </td>\r\n\r\n          <{elseif $xoops_isuser == true && $xoops_userid == $topic_post.poster_uid}>\r\n\r\n          <td class="even" align="right">\r\n            <a href="edit.php?forum=<{$forum_id}>&amp;post_id=<{$topic_post.post_id}>&amp;topic_id=<{$topic_id}>&amp;viewmode=<{$topic_viewmode}>&amp;order=<{$topic_order}>"><img src="<{$xoops_url}>/images/icons/edit.gif" alt="<{$lang_edit}>" /></a><a href=''reply.php?forum=<{$forum_id}>&amp;post_id=<{$topic_post.post_id}>&amp;topic_id=<{$topic_id}>&amp;viewmode=<{$topic_viewmode}>&amp;order=<{$topic_order}>''><img src="<{$xoops_url}>/images/icons/reply.gif" alt="<{$lang_reply}>" /></a>\r\n          </td>\r\n\r\n          <{elseif $viewer_can_post == true}>\r\n\r\n          <td class="even" align="right">\r\n            <a href=''reply.php?forum=<{$forum_id}>&amp;post_id=<{$topic_post.post_id}>&amp;topic_id=<{$topic_id}>&amp;viewmode=<{$topic_viewmode}>&amp;order=<{$topic_order}>''><img src="<{$xoops_url}>/images/icons/reply.gif" alt="<{$lang_reply}>" /></a>\r\n          </td>\r\n\r\n          <{else}>\r\n\r\n          <td class="even"> </td>\r\n\r\n          <{/if}>\r\n\r\n        </tr>\r\n<!-- end comment post -->');
INSERT INTO `xoops_tplsource` VALUES (33, '<!-- start module contents -->\r\n<table border="0" width="100%" cellpadding="5" align="center">\r\n  <tr>\r\n    <td align="left"><img src="<{$forum_image_folder}>" alt="/" />&nbsp;&nbsp;<a href="<{$xoops_url}>/modules/newbb/index.php"><{$forum_index_title}></a><br />&nbsp;&nbsp;&nbsp;<img src="<{$forum_image_folder}>" alt="/" />&nbsp;&nbsp;<b><{$forum_name}></b><br />(<{$lang_moderatedby}>:<{$forum_moderators}>)</td>\r\n    <td align="right"><{$forum_post_or_register}></td>\r\n  </tr>\r\n</table>\r\n\r\n<table align="center" border="0" width="100%">\r\n  <tr>\r\n    <td align="right"><{$forum_pagenav}></td>\r\n  </tr>\r\n</table>\r\n\r\n<!-- start forum main table -->\r\n<form action="viewforum.php" method="get">\r\n<table class="outer" cellspacing="1">\r\n  <tr>\r\n    <th colspan="7"> <{$forum_name}></th>\r\n  </tr>\r\n  <tr class="head" align="left">\r\n    <td width="2%">&nbsp;</td>\r\n    <td width="2%">&nbsp;</td>\r\n    <td>&nbsp;<b><a href="<{$h_topic_link}>"><{$lang_topic}></a></b></td>\r\n    <td width="9%" align="center" nowrap="nowrap"><b><a href="<{$h_reply_link}>"><{$lang_replies}></a></b></td>\r\n    <td width="20%" align="center" nowrap="nowrap"><b><a href="<{$h_poster_link}>"><{$lang_poster}></a></b></td>\r\n    <td width="8%" align="center" nowrap="nowrap"><b><a href="<{$h_views_link}>"><{$lang_views}></a></b></td>\r\n    <td width="15%" align="center" nowrap="nowrap"><b><a href="<{$h_date_link}>"><{$lang_date}></a></b></td>\r\n  </tr>\r\n  <!-- start forum topic -->\r\n  <{foreach item=topic from=$topics}>\r\n  <tr class="<{cycle values="even,odd}>">\r\n    <td align="center"><img src="<{$topic.topic_folder}>" alt="/" /></td>\r\n    <td align="center"><{$topic.topic_icon}></td>\r\n    <td>&nbsp;<a href="<{$topic.topic_link}>"><{$topic.topic_title}></a><{$topic.topic_page_jump}></td>\r\n    <td align="center" valign="middle"><{$topic.topic_replies}></td>\r\n	<td align="center" valign="middle"><{$topic.topic_poster}></td>\r\n    <td align="center" valign="middle"><{$topic.topic_views}></td>\r\n	<td align="right" valign="middle"><{$topic.topic_last_posttime}><br /><{$lang_by}> <{$topic.topic_last_poster}></td>\r\n  </tr>\r\n  <{/foreach}>\r\n  <!-- end forum topic -->\r\n  <tr class="foot">\r\n    <td colspan="7" align="center">\r\n    <b><{$lang_sortby}></b> <{$forum_selection_sort}> <{$forum_selection_order}> <{$forum_selection_since}> <input type="hidden" name="forum" value="<{$forum_id}>" /><input type="submit" name="refresh" value="<{$lang_go}>" />\r\n    </td>\r\n  </tr>\r\n</table>\r\n<!-- end forum main table -->\r\n\r\n<table align="center" border="0" width="100%">\r\n  <tr>\r\n    <td valign="top"><img src="<{$img_newposts}>" alt="/" /> = <{$lang_newposts}> (<img src="<{$img_hotnewposts}>" alt="/" /> = <{$lang_hotnewposts}>)<br /><img src="<{$img_folder}>" alt="/" /> = <{$lang_nonewposts}> (<img src="<{$img_hotfolder}>" alt="/" /> = <{$lang_hotnonewposts}>)<br /><img src="<{$img_locked}>" alt="/" /> = <{$lang_topiclocked}><br /><img src="<{$img_sticky}>" alt="/" /> = <{$lang_topicsticky}></td>\r\n    <td align="right"><{$forum_pagenav}><br /><{$forum_jumpbox}></td>\r\n  </tr>\r\n</table>\r\n<{include file=''db:system_notification_select.html''}>\r\n<!-- end module contents -->');
INSERT INTO `xoops_tplsource` VALUES (34, '<!-- start module contents -->\r\n<table border="0" width="100%" cellpadding=''5'' align=''center''>\r\n  <tr>\r\n    <td align=''left''><img src=''<{$xoops_url}>/modules/newbb/images/folder.gif'' alt='''' /> <a href=''<{$xoops_url}>/modules/newbb/index.php''><{$lang_forum_index}></a><br />&nbsp;&nbsp;<img src=''<{$xoops_url}>/modules/newbb/images/folder.gif'' alt='''' /> <a href=''<{$xoops_url}>/modules/newbb/viewforum.php?forum=<{$forum_id}>''><{$forum_name}></a>\r\n<br />&nbsp;&nbsp;&nbsp;&nbsp;<img src=''<{$xoops_url}>/modules/newbb/images/folder.gif'' alt='''' /> <b><{$topic_title}></b></td><td align=''right''><{$forum_post_or_register}></td>\r\n  </tr>\r\n</table>\r\n\r\n<br />\r\n\r\n<!-- start topic thread -->\r\n<table cellpadding="4" width="100%">\r\n  <tr>\r\n    <td align="left"><a id="threadtop"></a><a href="viewtopic.php?viewmode=thread&amp;order=<{$order_current}>&amp;topic_id=<{$topic_id}>&amp;forum=<{$forum_id}>"><{$lang_threaded}></a> | <a href="viewtopic.php?viewmode=flat&amp;order=<{$order_other}>&amp;topic_id=<{$topic_id}>&amp;forum=<{$forum_id}>"><{$lang_order_other}></a></td>\r\n    <td align="right"><a href="viewtopic.php?viewmode=flat&amp;order=<{$order_current}>&amp;topic_id=<{$topic_id}>&amp;forum=<{$forum_id}>&amp;move=prev&amp;topic_time=<{$topic_time}>"><{$lang_prevtopic}></a> | <a href="viewtopic.php?viewmode=flat&amp;order=<{$order_current}>&amp;topic_id=<{$topic_id}>&amp;forum=<{$forum_id}>&amp;move=next&amp;topic_time=<{$topic_time}>"><{$lang_nexttopic}></a> | <a href="#threadbottom"><{$lang_bottom}></a></td>\r\n  </tr>\r\n</table>\r\n<table cellspacing="1" class="outer">\r\n  <tr align=''left''>\r\n    <th width=''20%''><{$lang_poster}></th>\r\n    <th><{$lang_thread}></th>\r\n  </tr>\r\n  <{foreach item=topic_post from=$topic_posts}>\r\n  <{include file="db:newbb_thread.html" topic_post=$topic_post}>\r\n  <{/foreach}>\r\n  <tr class="foot" align="left">\r\n    <td colspan="2" align="center"><{$forum_page_nav}> </td>\r\n  </tr>\r\n</table>\r\n<table cellpadding="4" width="100%">\r\n  <tr>\r\n    <td align="left"><a id="threadbottom"></a><a href="viewtopic.php?viewmode=thread&amp;order=<{$order_current}>&amp;topic_id=<{$topic_id}>&amp;forum=<{$forum_id}>"><{$lang_threaded}></a> | <a href="viewtopic.php?viewmode=flat&amp;order=<{$order_other}>&amp;topic_id=<{$topic_id}>&amp;forum=<{$forum_id}>"><{$lang_order_other}></a></td>\r\n    <td align="right"><a href="viewtopic.php?viewmode=flat&amp;order=<{$order_current}>&amp;topic_id=<{$topic_id}>&amp;forum=<{$forum_id}>&amp;move=prev&amp;topic_time=<{$topic_time}>"><{$lang_prevtopic}></a> | <a href="viewtopic.php?viewmode=flat&amp;order=<{$order_current}>&amp;topic_id=<{$topic_id}>&amp;forum=<{$forum_id}>&amp;move=next&amp;topic_time=<{$topic_time}>"><{$lang_nexttopic}></a> | <a href="#threadtop"><{$lang_top}></a></td>\r\n  </tr>\r\n</table>\r\n<!-- end topic thread -->\r\n\r\n<br />\r\n\r\n<table cellspacing="0" class="outer" width="100%">\r\n  <tr class=''foot''>\r\n    <td align=''left''> <{$forum_post_or_register}></td>\r\n    <td align=''right''><{$forum_jumpbox}> </td>\r\n  </tr>\r\n  <tr class=''foot'' valign="bottom">\r\n    <{if $viewer_is_admin == true}>\r\n    <td colspan=''2'' align=''center''>&nbsp;<{$topic_lock_image}>&nbsp;<{$topic_move_image}>&nbsp;<{$topic_delete_image}>&nbsp;<{$topic_sticky_image}>&nbsp;</td>\r\n    <{else}>\r\n    <td colspan=''2''>&nbsp;</td>\r\n    <{/if}>\r\n  </tr>\r\n</table>\r\n<{include file=''db:system_notification_select.html''}>\r\n<!-- end module contents -->');
INSERT INTO `xoops_tplsource` VALUES (35, '<!-- start module contents -->\r\n<table border="0" cellpadding=''5'' align=''center''>\r\n  <tr>\r\n    <td align=''left''><img src=''<{$xoops_url}>/modules/newbb/images/folder.gif'' alt='''' /> <a href=''<{$xoops_url}>/modules/newbb/index.php''><{$lang_forum_index}></a><br />&nbsp;&nbsp;<img src=''<{$xoops_url}>/modules/newbb/images/folder.gif'' alt='''' /> <a href=''<{$xoops_url}>/modules/newbb/viewforum.php?forum=<{$forum_id}>''><{$forum_name}></a>\r\n<br />&nbsp;&nbsp;&nbsp;&nbsp;<img src=''<{$xoops_url}>/modules/newbb/images/folder.gif'' alt='''' /> <b><{$topic_title}></b></td><td align=''right''><{$forum_post_or_register}></td>\r\n  </tr>\r\n</table>\r\n\r\n<img src="images/pixel.gif" height="5" alt="" /><br />\r\n\r\n<!-- start topic thread -->\r\n<table cellpadding="4" width="100%">\r\n  <tr>\r\n    <td align="left"><a href="viewtopic.php?viewmode=flat&amp;topic_id=<{$topic_id}>&amp;forum=<{$forum_id}>"><{$lang_flat}></a></td>\r\n    <td align="right"><a href="viewtopic.php?viewmode=thread&amp;topic_id=<{$topic_id}>&amp;forum=<{$forum_id}>&amp;move=prev&amp;topic_time=<{$topic_time}>"><{$lang_prevtopic}></a> | <a href="viewtopic.php?viewmode=thread&amp;topic_id=<{$topic_id}>&amp;forum=<{$forum_id}>&amp;move=next&amp;topic_time=<{$topic_time}>"><{$lang_nexttopic}></a></td>\r\n  </tr>\r\n</table>\r\n<table cellspacing="1" class="outer">\r\n  <tr>\r\n    <th width=''20%''><{$lang_poster}></th>\r\n    <th><{$lang_thread}></th>\r\n  </tr>\r\n  <{foreach item=topic_post from=$topic_posts}>\r\n    <{include file="db:newbb_thread.html" topic_post=$topic_post}>\r\n  <{/foreach}>\r\n</table>\r\n\r\n<table cellpadding="4" width="100%">\r\n  <tr>\r\n    <td align="left"><a href="viewtopic.php?viewmode=flat&amp;order=<{$order_current}>&amp;topic_id=<{$topic_id}>&amp;forum=<{$forum_id}>"><{$lang_flat}></a></td>\r\n    <td align="right"><a href="viewtopic.php?viewmode=thread&amp;topic_id=<{$topic_id}>&amp;forum=<{$forum_id}>&amp;move=prev&amp;topic_time=<{$topic_time}>"><{$lang_prevtopic}></a> | <a href="viewtopic.php?viewmode=thread&amp;topic_id=<{$topic_id}>&amp;forum=<{$forum_id}>&amp;move=next&amp;topic_time=<{$topic_time}>"><{$lang_nexttopic}></a></td>\r\n  </tr>\r\n</table>\r\n\r\n<br />\r\n\r\n<!-- start topic tree -->\r\n<table class="outer" cellspacing=''1''>\r\n  <tr align=''left''>\r\n    <th width=''50%''><{$lang_subject}></th>\r\n    <th width=''20%''><{$lang_poster}></th>\r\n    <th><{$lang_date}></th>\r\n  </tr>\r\n  <{foreach item=topic_tree from=$topic_trees}>\r\n  <tr class="<{cycle values="even,odd"}>">\r\n    <td><{$topic_tree.post_prefix}> <{$topic_tree.post_image}> <{$topic_tree.post_title}></td>\r\n    <td><{$topic_tree.poster_uname}></td>\r\n    <td><{$topic_tree.post_date}></td>\r\n  </tr>\r\n  <{/foreach}>\r\n</table>\r\n<!-- end topic tree -->\r\n<!-- end topic thread -->\r\n\r\n<img src="images/pixel.gif" height="5" alt="" /><br />\r\n\r\n<table width="100%" class="outer" cellspacing="0">\r\n  <tr class=''foot'' valign="top">\r\n    <td align=''left''> <{$forum_post_or_register}></td>\r\n    <td align=''right''><{$forum_jumpbox}> </td>\r\n  </tr>\r\n  <tr class=''foot'' valign="bottom">\r\n    <{if $viewer_is_admin == true}>\r\n    <td colspan=''2'' align=''center''>&nbsp;<{$topic_lock_image}>&nbsp;<{$topic_move_image}>&nbsp;<{$topic_delete_image}>&nbsp;<{$topic_sticky_image}>&nbsp;</td>\r\n    <{else}>\r\n    <td colspan=''2''>&nbsp;</td>\r\n    <{/if}>\r\n  </tr>\r\n</table>\r\n<{include file=''db:system_notification_select.html''}>\r\n<!-- end module contents -->');
INSERT INTO `xoops_tplsource` VALUES (36, '<table class="outer" cellspacing="1">\r\n\r\n  <{if $block.full_view == true}>\r\n  <tr>\r\n    <th><{$block.lang_forum}></th>\r\n    <th><{$block.lang_topic}></th>\r\n    <th align="center"><{$block.lang_replies}></th>\r\n    <th align="center"><{$block.lang_views}></th>\r\n    <th align="right"><{$block.lang_lastpost}></th>\r\n  </tr>\r\n\r\n  <{foreach item=topic from=$block.topics}>\r\n  <tr class="<{cycle values="even,odd"}>">\r\n    <td><a href="<{$xoops_url}>/modules/newbb/viewforum.php?forum=<{$topic.forum_id}>"><{$topic.forum_name}></a></td>\r\n    <td><a href="<{$xoops_url}>/modules/newbb/viewtopic.php?topic_id=<{$topic.id}>&amp;forum=<{$topic.forum_id}>&amp;post_id=<{$topic.post_id}>#forumpost<{$topic.post_id}>"><{$topic.title}></a></td>\r\n    <td align="center"><{$topic.replies}></td>\r\n    <td align="center"><{$topic.views}></td>\r\n    <td align="right"><{$topic.time}></td>\r\n  </tr>\r\n  <{/foreach}>\r\n\r\n  <{else}>\r\n\r\n  <tr>\r\n    <td class="head"><{$block.lang_topic}></td>\r\n    <td class="head" align="center"><{$block.lang_replies}></td>\r\n    <td class="head" align="right"><{$block.lang_lastpost}></td>\r\n  </tr>\r\n\r\n  <{foreach item=topic from=$block.topics}>\r\n  <tr class="<{cycle values="even,odd"}>">\r\n    <td><a href="<{$xoops_url}>/modules/newbb/viewtopic.php?topic_id=<{$topic.id}>&amp;forum=<{$topic.forum_id}>"><{$topic.title}></a></td>\r\n    <td align="center"><{$topic.replies}></td>\r\n    <td align="right"><{$topic.time}></td>\r\n  </tr>\r\n  <{/foreach}>\r\n\r\n  <{/if}>\r\n\r\n</table>\r\n\r\n<div style="text-align:right; padding: 5px;">\r\n<a href="<{$xoops_url}>/modules/newbb/"><{$block.lang_visitforums}></a>\r\n</div>');
INSERT INTO `xoops_tplsource` VALUES (37, '<table class="outer" cellspacing="1">\r\n\r\n  <{if $block.full_view == true}>\r\n\r\n  <tr>\r\n    <th><{$block.lang_forum}></th>\r\n    <th><{$block.lang_topic}></th>\r\n    <th align="center"><{$block.lang_replies}></th>\r\n    <th align="center"><{$block.lang_views}></th>\r\n    <th align="right"><{$block.lang_lastpost}></th>\r\n  </tr>\r\n\r\n  <{foreach item=topic from=$block.topics}>\r\n  <tr class="<{cycle values="even,odd"}>">\r\n    <td><a href="<{$xoops_url}>/modules/newbb/viewforum.php?forum=<{$topic.forum_id}>"><{$topic.forum_name}></a></td>\r\n    <td><a href="<{$xoops_url}>/modules/newbb/viewtopic.php?topic_id=<{$topic.id}>&amp;forum=<{$topic.forum_id}>&amp;post_id=<{$topic.post_id}>#forumpost<{$topic.post_id}>"><{$topic.title}></a></td>\r\n    <td align="center"><{$topic.replies}></td>\r\n    <td align="center"><{$topic.views}></td>\r\n    <td align="right"><{$topic.time}></td>\r\n  </tr>\r\n  <{/foreach}>\r\n\r\n  <{else}>\r\n\r\n  <tr>\r\n    <td class="head"><{$block.lang_topic}></td>\r\n    <td class="head" align="center"><{$block.lang_replies}></td>\r\n    <td class="head" align="right"><{$block.lang_lastpost}></td>\r\n  </tr>\r\n\r\n  <{foreach item=topic from=$block.topics}>\r\n  <tr class="<{cycle values="even,odd"}>">\r\n    <td><a href="<{$xoops_url}>/modules/newbb/viewtopic.php?topic_id=<{$topic.id}>&amp;forum=<{$topic.forum_id}>"><{$topic.title}></a></td>\r\n    <td align="center"><{$topic.views}></td>\r\n    <td align="right"><{$topic.time}></td>\r\n  </tr>\r\n  <{/foreach}>\r\n\r\n  <{/if}>\r\n\r\n</table>\r\n\r\n<div style="text-align:right; padding: 5px;">\r\n<a href="<{$xoops_url}>/modules/newbb/"><{$block.lang_visitforums}></a>\r\n</div>');
INSERT INTO `xoops_tplsource` VALUES (38, '<table class="outer" cellspacing="1">\r\n\r\n  <{if $block.full_view == true}>\r\n  <tr>\r\n    <th><{$block.lang_forum}></th>\r\n    <th><{$block.lang_topic}></th>\r\n    <th align="center"><{$block.lang_replies}></th>\r\n    <th align="center"><{$block.lang_views}></th>\r\n    <th align="right"><{$block.lang_lastpost}></th>\r\n  </tr>\r\n\r\n  <{foreach item=topic from=$block.topics}>\r\n  <tr class="<{cycle values="even,odd"}>">\r\n    <td><a href="<{$xoops_url}>/modules/newbb/viewforum.php?forum=<{$topic.forum_id}>"><{$topic.forum_name}></a></td>\r\n    <td><a href="<{$xoops_url}>/modules/newbb/viewtopic.php?topic_id=<{$topic.id}>&amp;forum=<{$topic.forum_id}>&amp;post_id=<{$topic.post_id}>#forumpost<{$topic.post_id}>"><{$topic.title}></a></td>\r\n    <td align="center"><{$topic.replies}></td>\r\n    <td align="center"><{$topic.views}></td>\r\n    <td align="right"><{$topic.time}></td>\r\n  </tr>\r\n  <{/foreach}>\r\n\r\n  <{else}>\r\n\r\n  <tr>\r\n    <td class="head"><{$block.lang_topic}></td>\r\n    <td class="head" align="center"><{$block.lang_replies}></td>\r\n    <td class="head" align="right"><{$block.lang_lastpost}></td>\r\n  </tr>\r\n\r\n  <{foreach item=topic from=$block.topics}>\r\n  <tr class="<{cycle values="even,odd"}>">\r\n    <td><a href="<{$xoops_url}>/modules/newbb/viewtopic.php?topic_id=<{$topic.id}>&amp;forum=<{$topic.forum_id}>"><{$topic.title}></a></td>\r\n    <td align="center"><{$topic.replies}></td>\r\n    <td align="right"><{$topic.time}></td>\r\n  </tr>\r\n  <{/foreach}>\r\n\r\n  <{/if}>\r\n\r\n</table>\r\n\r\n<div style="text-align:right; padding: 5px;">\r\n<a href="<{$xoops_url}>/modules/newbb/"><{$block.lang_visitforums}></a>\r\n</div>');
INSERT INTO `xoops_tplsource` VALUES (39, '<table class="outer" cellspacing="1">\r\n\r\n  <{if $block.full_view == true}>\r\n  <tr>\r\n    <th><{$block.lang_forum}></th>\r\n    <th><{$block.lang_topic}></th>\r\n    <th align="center"><{$block.lang_replies}></th>\r\n    <th align="center"><{$block.lang_views}></th>\r\n    <th align="right"><{$block.lang_lastpost}></th>\r\n  </tr>\r\n\r\n  <{foreach item=topic from=$block.topics}>\r\n  <tr class="<{cycle values="even,odd"}>">\r\n    <td><a href="<{$xoops_url}>/modules/newbb/viewforum.php?forum=<{$topic.forum_id}>"><{$topic.forum_name}></a></td>\r\n    <td><a href="<{$xoops_url}>/modules/newbb/viewtopic.php?topic_id=<{$topic.id}>&amp;forum=<{$topic.forum_id}>&amp;post_id=<{$topic.post_id}>#forumpost<{$topic.post_id}>"><{$topic.title}></a></td>\r\n    <td align="center"><{$topic.replies}></td>\r\n    <td align="center"><{$topic.views}></td>\r\n    <td align="right"><{$topic.time}></td>\r\n  </tr>\r\n  <{/foreach}>\r\n\r\n  <{else}>\r\n\r\n  <tr>\r\n    <td class="head"><{$block.lang_topic}></td>\r\n    <td class="head" align="center"><{$block.lang_replies}></td>\r\n    <td class="head" align="right"><{$block.lang_lastpost}></td>\r\n  </tr>\r\n\r\n  <{foreach item=topic from=$block.topics}>\r\n  <tr class="<{cycle values="even,odd"}>">\r\n    <td><a href="<{$xoops_url}>/modules/newbb/viewtopic.php?topic_id=<{$topic.id}>&amp;forum=<{$topic.forum_id}>"><{$topic.title}></a></td>\r\n    <td align="center"><{$topic.replies}></td>\r\n    <td align="right"><{$topic.time}></td>\r\n  </tr>\r\n  <{/foreach}>\r\n\r\n  <{/if}>\r\n\r\n</table>\r\n\r\n<div style="text-align:right; padding: 5px;">\r\n<a href="<{$xoops_url}>/modules/newbb/"><{$block.lang_visitforums}></a>\r\n</div>');
INSERT INTO `xoops_tplsource` VALUES (40, '<br /><br />\r\n\r\n<p align="center">\r\n    <a href="<{$xoops_url}>/modules/mydownloads/index.php"><img src="<{$xoops_url}>/modules/mydownloads/images/logo-en.gif" alt="" /></a>\r\n</p>\r\n<br /><br /><br />\r\n\r\n<div align=''center''>\r\n  <h4><{$lang_reportbroken}></h4>\r\n  <form action="brokenfile.php" method="POST">\r\n    <input type="hidden" name="lid" value="<{$file_id}>" /><{$lang_thanksforhelp}><br /><{$lang_forsecurity}><br /><br /><input type="submit" name="submit" value="<{$lang_reportbroken}>" />&nbsp;<input type=button value="<{$lang_cancel}>" onclick="javascript:history.go(-1)" />\r\n  </form>\r\n</div>\r\n\r\n<br />');
INSERT INTO `xoops_tplsource` VALUES (41, '<table width=''100%'' cellspacing=''0'' class=''outer''>\r\n  <tr>\r\n    <td class="head" colspan=''2'' align=''left'' height="18"><{$lang_category}> <{$down.category}></td>\r\n  </tr>\r\n  <tr>\r\n    <td class=''even'' width=''65%'' align=''left'' valign="bottom"><a href=''visit.php?cid=<{$down.cid}>&amp;lid=<{$down.id}>'' target=''_blank''><img src=''images/download.gif'' border=''0'' alt=''<{$lang_dlnow}>'' /><b><{$down.title}></b></a></td>\r\n    <td class=''even'' align=''right'' width=''35%''><b><{$lang_version}>:</b>&nbsp;<{$down.version}><br /><b><{$lang_subdate}>:</b>&nbsp;&nbsp;<{$down.updated}></td>\r\n  </tr>\r\n  <tr>\r\n    <td colspan=''2'' class=''odd'' align=''left''><{$down.adminlink}><b><{$lang_description}></b><br />\r\n\r\n<{if $down.logourl != ""}>\r\n   <a href="<{$xoops_url}>/modules/mydownloads/visit.php?cid=<{$down.cid}>&amp;lid=<{$down.id}>" target="_blank"><img src="<{$xoops_url}>/modules/mydownloads/images/shots/<{$down.logourl}>" width="<{$shotwidth}>" alt=""  align="right" vspace="3" hspace="7"/></a>\r\n<{/if}>\r\n\r\n<div style="text-align: justify"><{$down.description}></div><br /></td>\r\n  </tr>\r\n  <tr>\r\n    <td colspan=''2'' class=''even'' align=''left''><img src=''images/counter.gif'' border=''0'' align=''absmiddle'' alt=''<{$down.lang_dltimes}>'' />\r\n&nbsp;<{$down.hits}>&nbsp;&nbsp;<img src=''images/size.gif'' border=''0'' align=''absmiddle'' alt=''<{$lang_size}>'' />&nbsp;<{$down.size}>&nbsp;&nbsp;<img src=''images/platform.gif'' border=''0'' align=''absmiddle'' alt=''<{$lang_platform}>'' />&nbsp;<{$down.platform}>&nbsp;&nbsp;<img src=''images/home.gif'' border=''0'' align=''absmiddle'' alt=''<{$lang_homepage}>'' />&nbsp;<a href="<{$down.homepage}>" target="_BLANK"><{$down.homepage}></a></td>\r\n  </tr>\r\n  <tr>\r\n    <td colspan=''2'' class=''foot'' align=''center''>\r\n    <div><b><{$lang_ratingc}></b> <{$down.rating}> (<{$down.votes}>)</div>\r\n    <a href="<{$xoops_url}>/modules/mydownloads/ratefile.php?cid=<{$down.cid}>&amp;lid=<{$down.id}>"><{$lang_ratethissite}></a> | <a href="<{$xoops_url}>/modules/mydownloads/modfile.php?lid=<{$down.id}>"><{$lang_modify}></a> | <a href="<{$xoops_url}>/modules/mydownloads/brokenfile.php?lid=<{$down.id}>"><{$lang_reportbroken}></a> | <a target="_top" href="mailto:?subject=<{$down.mail_subject}>&amp;body=<{$down.mail_body}>"><{$lang_tellafriend}></a> | <a href="<{$xoops_url}>/modules/mydownloads/singlefile.php?cid=<{$down.cid}>&amp;lid=<{$down.id}>"><{$lang_comments}> (<{$down.comments}>)</a>\r\n    </td>\r\n  </tr>\r\n</table>\r\n<br /><br />');
INSERT INTO `xoops_tplsource` VALUES (42, '<br /><br />\r\n\r\n<p align="center">\r\n    <a href="<{$xoops_url}>/modules/mydownloads/index.php"><img src="<{$xoops_url}>/modules/mydownloads/images/logo-en.gif" alt="" /></a>\r\n</p>\r\n\r\n<br /><br /><br />\r\n<{if count($categories) gt 0}>\r\n<hr noshade color=#000000">\r\n<table border=''0'' cellspacing=''5'' cellpadding=''0'' align="center">\r\n  <tr>\r\n  <!-- Start category loop -->\r\n  <{foreach item=category from=$categories}>\r\n\r\n    <td valign="top" >\r\n    <{if $category.image != ""}>\r\n    <a href="<{$xoops_url}>/modules/mydownloads/viewcat.php?cid=<{$category.id}>"><img src="<{$category.image}>" height="50" border="0" alt="" /></a>\r\n    <{/if}>\r\n    </td>\r\n    <td valign="top" width="40%"><a href="<{$xoops_url}>/modules/mydownloads/viewcat.php?cid=<{$category.id}>"><b><{$category.title}></b></a>&nbsp;(<{$category.totaldownloads}>)<br /><{$category.subcategories}></td>\r\n    <{if $category.count is div by 3}>\r\n    </tr><tr>\r\n    <{/if}>\r\n\r\n  <{/foreach}>\r\n  <!-- End category loop -->\r\n  </tr>\r\n</table>\r\n<br /><br />\r\n\r\n<div><{$lang_thereare}></div>\r\n<hr noshade color=#000000">\r\n\r\n  <{/if}>\r\n\r\n<{if $file != ""}>\r\n<h4><{$lang_latestlistings}></h4>\r\n<table width="100%" cellspacing="0" cellpadding="10" border="0">\r\n<tr>\r\n<td width="100%" align="center" valign="top">\r\n  <!-- Start new link loop -->\r\n  <{section name=i loop=$file}>\r\n    <{include file="db:mydownloads_download.html" down=$file[i]}>\r\n  <{/section}>\r\n  <!-- End new link loop -->\r\n</td></tr>\r\n  </table>\r\n<{/if}>\r\n<{include file="db:system_notification_select.html"}>');
INSERT INTO `xoops_tplsource` VALUES (43, '<br /><br />\r\n\r\n<p align="center">\r\n    <a href="<{$xoops_url}>/modules/mydownloads/index.php"><img src="<{$xoops_url}>/modules/mydownloads/images/logo-en.gif" alt="" /></a>\r\n</p>\r\n\r\n<br /><br /><br />\r\n<h4><{$lang_requestmod}></h4>\r\n<form action="modfile.php" method="post">\r\n<table width="80%">\r\n  <tr>\r\n    <td align="right"><{$lang_fileid}></td>\r\n    <td><b><{$file.id}></b></td>\r\n  </tr>\r\n  <tr>\r\n    <td align="right"><{$lang_sitetitle}></td>\r\n    <td><input type="text" name="title" size="50" maxlength="100" value="<{$file.title}>"></td>\r\n  </tr>\r\n  <tr>\r\n    <td align="right"><{$lang_siteurl}></td>\r\n    <td><input type="text" name="url" size="50" maxlength="100" value="<{$file.url}>"></td>\r\n  </tr>\r\n  <tr>\r\n    <td align="right"><{$lang_category}></td>\r\n    <td><{$category_selbox}></td>\r\n  </tr>\r\n  <tr>\r\n    <td></td><td></td>\r\n  </tr>\r\n  <tr>\r\n    <td align="right"><{$lang_homepage}></td>\r\n    <td><input type="text" name="homepage" size="50" maxlength="100" value="<{$file.homepage}>"></td>\r\n  </tr>\r\n  <tr>\r\n    <td align="right"><{$lang_version}></td>\r\n    <td><input type="text" name="version" size="10" maxlength="20" value="<{$file.version}>"></td>\r\n  </tr>\r\n  <tr>\r\n    <td align="right"><{$lang_size}></td>\r\n    <td><input type="text" name="size" size="10" maxlength="20" value="<{$file.size}>"> <{$lang_bytes}></td>\r\n  </tr>\r\n  <tr>\r\n    <td align="right"><{$lang_platform}></td>\r\n    <td><input type="text" name="platform" size="50" maxlength="50" value="<{$file.plataform}>"></td>\r\n  </tr>\r\n  <tr>\r\n    <td align="right" valign="top"><{$lang_description}></td>\r\n    <td><textarea name=description cols=60 rows=5><{$file.description}></textarea></td>\r\n  </tr>\r\n  <tr>\r\n    <td colspan="2" align="center"><br /><input type="hidden" name="logourl" value="<{$file.logourl}>"></input><input type="hidden" name="lid" value="<{$file.id}>"></input><input type="submit" name="submit" value="<{$lang_sendrequest}>"></input>&nbsp;<input type=button value="<{$lang_cancel}>" onclick="javascript:history.go(-1)"></input></td>\r\n  </tr>\r\n</table>\r\n</form>');
INSERT INTO `xoops_tplsource` VALUES (44, '<br /><br />\r\n\r\n<p align="center">\r\n    <a href="<{$xoops_url}>/modules/mydownloads/index.php"><img src="<{$xoops_url}>/modules/mydownloads/images/logo-en.gif" alt="" /></a>\r\n</p>\r\n\r\n<br /><br /><br />\r\n\r\n<hr size=1 noshade>\r\n<table border=0 cellpadding=1 cellspacing=0 width="80%" align="center">\r\n  <tr>\r\n    <td>\r\n      <h4><{$file.title}></h4>\r\n      <ul>\r\n             <li><{$lang_voteonce}>\r\n             <li><{$lang_ratingscale}>\r\n             <li><{$lang_beobjective}>\r\n             <li><{$lang_donotvote}>\r\n      </ul>\r\n    </td>\r\n  </tr>\r\n  <tr>\r\n    <td align="center">\r\n      <form method="post" action="ratefile.php">\r\n        <input type="hidden" name="lid" value="<{$file.id}>">\r\n        <input type="hidden" name="cid" value="<{$file.cid}>">\r\n             <select name="rating"><option>--</option><option>10</option><option>9</option><option>8</option><option>7</option><option>6</option><option>5</option><option>4</option><option>3</option><option>2</option><option>1</option></select>&nbsp;&nbsp;\r\n        <input type="submit" name="submit" value="<{$lang_rateit}>" /> <input type=button value="<{$lang_cancel}>" onclick="location=''<{$xoops_url}>/modules/mydownloads/singlefile.php?cid=<{$file.cid}>&amp;lid=<{$file.id}>''" />\r\n      </form>\r\n    </td>\r\n  </tr>\r\n</table></div>');
INSERT INTO `xoops_tplsource` VALUES (45, '<br /><br />\r\n\r\n<p align="center">\r\n    <a href="<{$xoops_url}>/modules/mydownloads/index.php"><img src="<{$xoops_url}>/modules/mydownloads/images/logo-en.gif" alt="" /></a>\r\n</p>\r\n\r\n<br /><br /><br />\r\n<div>\r\n<table width="97%" cellspacing="2" cellpadding="2" border="0">\r\n  <tr>\r\n    <td class="newstitle"><{$category_path}></td>\r\n  </tr>\r\n</table>\r\n</div>\r\n<br />\r\n<table width="100%" cellspacing="0" cellpadding="10" border="0">\r\n  <tr>\r\n    <td width="100%" align="center" valign="top">\r\n    <{include file="db:mydownloads_download.html" down=$file}>   \r\n    </td>\r\n  </tr>\r\n</table>\r\n\r\n<div style="text-align: center; padding: 3px; margin:3px;">\r\n  <{$commentsnav}>\r\n  <{$lang_notice}>\r\n</div>\r\n\r\n<div style="margin:3px; padding: 3px;">\r\n<!-- start comments loop -->\r\n<{if $comment_mode == "flat"}>\r\n  <{include file="db:system_comments_flat.html"}>\r\n<{elseif $comment_mode == "thread"}>\r\n  <{include file="db:system_comments_thread.html"}>\r\n<{elseif $comment_mode == "nest"}>\r\n  <{include file="db:system_comments_nest.html"}>\r\n<{/if}>\r\n<!-- end comments loop -->\r\n</div>\r\n<{include file="db:system_notification_select.html"}>');
INSERT INTO `xoops_tplsource` VALUES (46, '<br /><br />\r\n\r\n<p align="center">\r\n    <a href="<{$xoops_url}>/modules/mydownloads/index.php"><img src="<{$xoops_url}>/modules/mydownloads/images/logo-en.gif" alt="" /></a>\r\n</p>\r\n\r\n<br />\r\n\r\n<table width="100%" cellspacing="1" cellpadding="4" border="0">\r\n  <tr>\r\n    <td>\r\n        <ul>\r\n            <li><{$lang_submitonce}></li>\r\n            <li><{$lang_allpending}></li>\r\n            <li><{$lang_dontabuse}></li>\r\n            <li><{$lang_wetakeshot}></li>\r\n        </ul><br />\r\n    <form action="submit.php" method="post">\r\n        <table class ="outer" width="80%">\r\n          <tr> \r\n            <td class="itemHead" align="left" nowrap colspan="2"><b><{$lang_submitcath}></b> \r\n            </td>\r\n          </tr>\r\n          <tr> \r\n            <td class="head" align="left" nowrap><b><{$lang_sitetitle}></b></td>\r\n            <td class="even"> \r\n              <input type="text" name="title" size="50" maxlength="100" />\r\n            </td>\r\n          </tr>\r\n          <tr> \r\n            <td class="head" align="left" nowrap><b><{$lang_siteurl}></b></td>\r\n            <td class="odd" > \r\n              <input type="text" name="url" size="50" maxlength="250" value="http://" />\r\n            </td>\r\n          </tr>\r\n          <tr> \r\n            <td class="head" align="left" nowrap><b><{$lang_category}></b></td>\r\n            <td class="even"><{$category_selbox}></td>\r\n          </tr>\r\n          <tr> \r\n            <td class="head" align="left"><b><{$lang_homepage}></b></td>\r\n            <td class="odd" > \r\n              <input type="text" name="homepage" size="50" maxlength="100" value="<{$file.homepage}>">\r\n            </td>\r\n          </tr>\r\n          <tr> \r\n            <td class="head" align="left"><b><{$lang_version}></b></td>\r\n            <td class="even"> \r\n              <input type="text" name="version" size="10" maxlength="20" value="<{$file.version}>">\r\n            </td>\r\n          </tr>\r\n          <tr> \r\n            <td class="head" align="left"><b><{$lang_size}></b></td>\r\n            <td class="odd"> \r\n              <input type="text" name="size" size="10" maxlength="20" value="<{$file.size}>">\r\n              <{$lang_bytes}></td>\r\n          </tr>\r\n          <tr> \r\n            <td class="head" align="left"><b><{$lang_platform}></b></td>\r\n            <td class="even"> \r\n              <input type="text" name="platform" size="50" maxlength="50" value="<{$file.plataform}>">\r\n            </td>\r\n          </tr>\r\n          <tr> \r\n            <td class="head" align="left" valign="top" nowrap><b><{$lang_description}></b></td>\r\n            <td class="odd"><{$xoops_codes}><{$xoops_smilies}></td>\r\n          </tr>\r\n          <tr>\r\n            <td class="head"><b><{$lang_options}></b></td>\r\n            <td class="even">\r\n            <{if $notify_show}>\r\n              <input type="checkbox" name="notify" value="1"><{$lang_notify}></input>\r\n            <{/if}>\r\n            </td>\r\n          </tr>\r\n        </table>\r\n      <br />\r\n      <div style="text-align: center;"><input type="submit" name="submit" class="button" value="<{$lang_submit}>" />&nbsp;<input type="button" value="<{$lang_cancel}>" onclick="javascript:history.go(-1)" /></div>\r\n    </form>\r\n  </td>\r\n</tr>\r\n</table>');
INSERT INTO `xoops_tplsource` VALUES (47, '<br /><br />\r\n\r\n<p align="center">\r\n    <a href="<{$xoops_url}>/modules/mydownloads/index.php"><img src="<{$xoops_url}>/modules/mydownloads/images/logo-en.gif" alt="" /></a>\r\n</p>\r\n\r\n<br /><br /><br />\r\n<!-- Start ranking loop -->\r\n<{foreach item=ranking from=$rankings}>\r\n<table class="outer">\r\n  <tr>\r\n    <th colspan="6" align="center"><{$ranking.title}> (<{$lang_sortby}>)</th>\r\n  </tr>\r\n  <tr>\r\n    <td width=''7%'' class="head"><{$lang_rank}></td>\r\n    <td width=''28%'' class="head"><{$lang_title}></td>\r\n    <td width=''40%'' class="head"><{$lang_category}></td>\r\n    <td width=''8%'' class="head" align=''center''><{$lang_hits}></td>\r\n    <td width=''9%'' class="head" align=''center''><{$lang_rating}></td>\r\n    <td width=''8%'' class="head" align=''right''><{$lang_vote}></td>\r\n  </tr>\r\n\r\n  <!-- Start files loop -->\r\n  <{foreach item=file from=$ranking.file}>\r\n\r\n  <tr>\r\n    <td class="even"><{$file.rank}></td>\r\n    <td class="odd"><a href=''singlefile.php?cid=<{$file.cid}>&amp;lid=<{$file.id}>''><{$file.title}></a></td>\r\n    <td class="even"><{$file.category}></td>\r\n    <td class="odd" align=''center''><{$file.hits}></td>\r\n    <td class="even" align=''center''><{$file.rating}></td>\r\n    <td align=''right''><{$file.votes}></td>\r\n  </tr>\r\n\r\n  <{/foreach}>\r\n  <!-- End links loop-->\r\n\r\n</table>\r\n<br />\r\n<{/foreach}>\r\n<!-- End ranking loop -->');
INSERT INTO `xoops_tplsource` VALUES (48, '<br /><br />\r\n\r\n<p align="center">\r\n    <a href="<{$xoops_url}>/modules/mydownloads/index.php"><img src="<{$xoops_url}>/modules/mydownloads/images/logo-en.gif" alt="" /></a>\r\n</p>\r\n\r\n<br /><br /><br />\r\n<div>\r\n<table width="97%" cellspacing="0" cellpadding="0" border="0">\r\n  <tr>\r\n    <td align="left">\r\n      <table width="100%" cellspacing="1" cellpadding="2" border="0">\r\n        <tr>\r\n          <td class="newstitle" height="18"><b><{$category_path}></b></td>\r\n        </tr>\r\n      </table>\r\n    </td>\r\n  </tr>\r\n  <tr>\r\n    <td align="center">\r\n      <table width="90%">\r\n        <tr><br />\r\n          <{foreach item=subcat from=$subcategories}>\r\n            <td align="left"><b><a href="viewcat.php?cid=<{$subcat.id}>"><{$subcat.title}></a></b>&nbsp;(<{$subcat.totallinks}>)<br /><font class="subcategories"><{$subcat.infercategories}></font></td>\r\n            <{if $subcat.count is div by 4}>\r\n            </tr><tr>\r\n            <{/if}>\r\n          <{/foreach}>\r\n        </tr>\r\n      </table>\r\n      <br />\r\n      <hr />\r\n\r\n      <{if $show_links == true}>\r\n\r\n      <{if $show_nav == true}>\r\n      <div><{$lang_sortby}>&nbsp;&nbsp;<{$lang_title}> (<a href="viewcat.php?cid=<{$category_id}>&amp;orderby=titleA"><img src="images/up.gif" border="0" align="middle" alt="" /></a><a href="viewcat.php?cid=<{$category_id}>&amp;orderby=titleD"><img src="images/down.gif" border="0" align="middle" alt="" /></a>)&nbsp;<{$lang_date}> (<a href="viewcat.php?cid=<{$category_id}>&amp;orderby=dateA"><img src="images/up.gif" border="0" align="middle" alt="" /></a><a href="viewcat.php?cid=<{$category_id}>&amp;orderby=dateD"><img src="images/down.gif" border="0" align="middle" alt="" /></a>)&nbsp;<{$lang_rating}> (<a href="viewcat.php?cid=<{$category_id}>&amp;orderby=ratingA"><img src="images/up.gif" border="0" align="middle" alt="" /></a><a href="viewcat.php?cid=<{$category_id}>&amp;orderby=ratingD"><img src="images/down.gif" border="0" align="middle" alt="" /></a>)&nbsp;<{$lang_popularity}> (<a href="viewcat.php?cid=<{$category_id}>&amp;orderby=hitsA"><img src="images/up.gif" border="0" align="middle" alt="" /></a><a href="viewcat.php?cid=<{$category_id}>&amp;orderby=hitsD"><img src="images/down.gif" border="0" align="middle" alt="" /></a>)\r\n      <br /><b><{$lang_cursortedby}></b>\r\n      </div>\r\n      <hr />\r\n      <{/if}>\r\n\r\n    </td>\r\n  </tr>\r\n</table>\r\n<table width="100%" cellspacing="0" cellpadding="10" border="0">\r\n<tr>\r\n<td width="100%" align="center" valign="top">\r\n  <!-- Start link loop -->\r\n  <{section name=i loop=$file}>\r\n    <{include file="db:mydownloads_download.html" down=$file[i]}>\r\n  <{/section}>\r\n  <!-- End link loop -->\r\n</td></tr>\r\n</table>\r\n<{$page_nav}>\r\n<{else}>\r\n    </td>\r\n  </tr>\r\n</table>\r\n<{/if}>\r\n<{include file="db:system_notification_select.html"}>');
INSERT INTO `xoops_tplsource` VALUES (49, '<ul>\r\n  <{foreach item=download from=$block.downloads}>\r\n    <li><a href="<{$xoops_url}>/modules/mydownloads/singlefile.php?cid=<{$download.cid}>&amp;lid=<{$download.id}>"><{$download.title}></a> (<{$download.date}>)</li>\r\n  <{/foreach}>\r\n</ul>');
INSERT INTO `xoops_tplsource` VALUES (50, '<ul>\r\n  <{foreach item=download from=$block.downloads}>\r\n    <li><a href="<{$xoops_url}>/modules/mydownloads/singlefile.php?cid=<{$download.cid}>&amp;lid=<{$download.id}>"><{$download.title}></a> (<{$download.hits}>)</li>\r\n  <{/foreach}>\r\n</ul>');

-- --------------------------------------------------------

-- 
-- Structure de la table `xoops_users`
-- 

DROP TABLE IF EXISTS `xoops_users`;
CREATE TABLE IF NOT EXISTS `xoops_users` (
  `uid` mediumint(8) unsigned NOT NULL auto_increment,
  `name` varchar(60) NOT NULL default '',
  `uname` varchar(25) NOT NULL default '',
  `email` varchar(60) NOT NULL default '',
  `url` varchar(100) NOT NULL default '',
  `user_avatar` varchar(30) NOT NULL default 'blank.gif',
  `user_regdate` int(10) unsigned NOT NULL default '0',
  `user_icq` varchar(15) NOT NULL default '',
  `user_from` varchar(100) NOT NULL default '',
  `user_sig` tinytext NOT NULL,
  `user_viewemail` tinyint(1) unsigned NOT NULL default '0',
  `actkey` varchar(8) NOT NULL default '',
  `user_aim` varchar(18) NOT NULL default '',
  `user_yim` varchar(25) NOT NULL default '',
  `user_msnm` varchar(100) NOT NULL default '',
  `pass` varchar(32) NOT NULL default '',
  `posts` mediumint(8) unsigned NOT NULL default '0',
  `attachsig` tinyint(1) unsigned NOT NULL default '0',
  `rank` smallint(5) unsigned NOT NULL default '0',
  `level` tinyint(3) unsigned NOT NULL default '1',
  `theme` varchar(100) NOT NULL default '',
  `timezone_offset` float(3,1) NOT NULL default '0.0',
  `last_login` int(10) unsigned NOT NULL default '0',
  `umode` varchar(10) NOT NULL default '',
  `uorder` tinyint(1) unsigned NOT NULL default '0',
  `notify_method` tinyint(1) NOT NULL default '1',
  `notify_mode` tinyint(1) NOT NULL default '0',
  `user_occ` varchar(100) NOT NULL default '',
  `bio` tinytext NOT NULL,
  `user_intrest` varchar(150) NOT NULL default '',
  `user_mailok` tinyint(1) unsigned NOT NULL default '1',
  PRIMARY KEY  (`uid`),
  KEY `uname` (`uname`),
  KEY `email` (`email`),
  KEY `uiduname` (`uid`,`uname`),
  KEY `unamepass` (`uname`,`pass`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

-- 
-- Contenu de la table `xoops_users`
-- 

INSERT INTO `xoops_users` VALUES (1, 'Thomas Raso', 'kikine', 'kikine_33@hotmail.com', 'http://julia:3000/xoops_2092fr%5cxoops-2.0.9.2%5chtml/', 'blank.gif', 1132945675, '', 'Bordeaux - Versailles', '', 1, '', '', '', 'kikine_33@hotmail.com', '6c83c294d382f13c75f72b5d0f8715e8', 1, 0, 7, 5, 'default', 1.0, 1133647777, 'thread', 0, 1, 0, 'webmaster - intégrateur', '', 'informatique - escrime', 0);

-- --------------------------------------------------------

-- 
-- Structure de la table `xoops_xoopscomments`
-- 

DROP TABLE IF EXISTS `xoops_xoopscomments`;
CREATE TABLE IF NOT EXISTS `xoops_xoopscomments` (
  `com_id` mediumint(8) unsigned NOT NULL auto_increment,
  `com_pid` mediumint(8) unsigned NOT NULL default '0',
  `com_rootid` mediumint(8) unsigned NOT NULL default '0',
  `com_modid` smallint(5) unsigned NOT NULL default '0',
  `com_itemid` mediumint(8) unsigned NOT NULL default '0',
  `com_icon` varchar(25) NOT NULL default '',
  `com_created` int(10) unsigned NOT NULL default '0',
  `com_modified` int(10) unsigned NOT NULL default '0',
  `com_uid` mediumint(8) unsigned NOT NULL default '0',
  `com_ip` varchar(15) NOT NULL default '',
  `com_title` varchar(255) NOT NULL default '',
  `com_text` text NOT NULL,
  `com_sig` tinyint(1) unsigned NOT NULL default '0',
  `com_status` tinyint(1) unsigned NOT NULL default '0',
  `com_exparams` varchar(255) NOT NULL default '',
  `dohtml` tinyint(1) unsigned NOT NULL default '0',
  `dosmiley` tinyint(1) unsigned NOT NULL default '0',
  `doxcode` tinyint(1) unsigned NOT NULL default '0',
  `doimage` tinyint(1) unsigned NOT NULL default '0',
  `dobr` tinyint(1) unsigned NOT NULL default '0',
  PRIMARY KEY  (`com_id`),
  KEY `com_pid` (`com_pid`),
  KEY `com_itemid` (`com_itemid`),
  KEY `com_uid` (`com_uid`),
  KEY `com_title` (`com_title`(40))
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- 
-- Contenu de la table `xoops_xoopscomments`
-- 


-- --------------------------------------------------------

-- 
-- Structure de la table `xoops_xoopsnotifications`
-- 

DROP TABLE IF EXISTS `xoops_xoopsnotifications`;
CREATE TABLE IF NOT EXISTS `xoops_xoopsnotifications` (
  `not_id` mediumint(8) unsigned NOT NULL auto_increment,
  `not_modid` smallint(5) unsigned NOT NULL default '0',
  `not_itemid` mediumint(8) unsigned NOT NULL default '0',
  `not_category` varchar(30) NOT NULL default '',
  `not_event` varchar(30) NOT NULL default '',
  `not_uid` mediumint(8) unsigned NOT NULL default '0',
  `not_mode` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`not_id`),
  KEY `not_modid` (`not_modid`),
  KEY `not_itemid` (`not_itemid`),
  KEY `not_class` (`not_category`),
  KEY `not_uid` (`not_uid`),
  KEY `not_event` (`not_event`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- 
-- Contenu de la table `xoops_xoopsnotifications`
-- 

        