<?php
/**
 * @version $Id: db.joomlastats.inc.php 158 2006-11-26 15:28:12Z RoBo $
 * @package JoomlaStats
 * @copyright Copyright (C) 2004-2007 JoomlaStats.org  All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
 *
 * used for:	used only if full backup or new installation
 * called by: 	admin.joomlastats.html.php or/and install.joomastats.php
 * returns:		dataInstalled == true if no errors
 * 				dataSum = number of querys executed
 */


defined('_VALID_MOS') or die('Direct Access to this location is not allowed.');

global $errors;

$dataInstalled 	= false;
$dataSum 		= 0;

if (empty($quer))
	$quer	= array();
if (empty($errors))
	$errors	= array();


$quer[] = 'CREATE TABLE IF NOT EXISTS `#__jstats_bots` ('
        . ' `bot_id` mediumint(9) NOT NULL auto_increment,'
        . ' `bot_string` varchar(50) NOT NULL default \'\','
        . ' `bot_fullname` varchar(50) NOT NULL default \'\','
        . ' PRIMARY KEY (`bot_id`),'
        . ' UNIQUE KEY `bot_string` (`bot_string`)'
        . ' ) TYPE=MyISAM';

$quer[] = 'CREATE TABLE IF NOT EXISTS `#__jstats_browsers` ('
  		. ' `browser_id` mediumint(9) NOT NULL auto_increment,'
  		. ' `browser_string` varchar(50) NOT NULL default \'\','
  		. ' `browser_fullname` varchar(50) NOT NULL default \'\','
  		. ' `browser_img` tinyint(1) NOT NULL default \'0\','
  		. ' PRIMARY KEY  (`browser_id`),'
  		. ' UNIQUE KEY `browser_string` (`browser_string`)'
  		. ' ) TYPE=MyISAM';

$quer[] = 'CREATE TABLE IF NOT EXISTS `#__jstats_configuration` ('
        . ' `description` varchar(250) NOT NULL default \'-\','
        . ' `value` varchar(250) default NULL,'
        . ' PRIMARY KEY (`description`)'
        . ' ) TYPE=MyISAM';

$quer[] = 'CREATE TABLE IF NOT EXISTS #__jstats_ipaddresses ('
		. ' ip varchar(50) NOT NULL default \'\','
		. ' nslookup varchar(255) default NULL,'
		. ' tld varchar(10) NOT NULL default \'unknown\','
		. ' useragent varchar(255) default NULL,'
		. ' system varchar(50) NOT NULL default \'\','
		. ' browser varchar(50) NOT NULL default \'\','
		. ' id mediumint(9) NOT NULL auto_increment,'
		. ' type tinyint(1) NOT NULL default \'0\','
		. ' exclude tinyint(1) NOT NULL default \'0\','
		. ' PRIMARY KEY (id),'
		. ' KEY id (id),'
		. ' KEY type (type),'
		. ' KEY tld (tld)'
		. ' ) TYPE=MyISAM';

$quer[] = 'CREATE TABLE IF NOT EXISTS `#__jstats_iptocountry` ('
        . ' `IP_FROM` bigint(20) NOT NULL default \'0\','
        . ' `IP_TO` bigint(20) NOT NULL default \'0\','
        . ' `COUNTRY_CODE2` char(2) NOT NULL default \'\','
        . ' `COUNTRY_NAME` varchar(50) NOT NULL default \'\','
        . ' PRIMARY KEY (`IP_FROM`)'
        . ' ) TYPE=MyISAM';

$quer[] = 'CREATE TABLE IF NOT EXISTS `#__jstats_keywords` ('
        . ' `kwdate` date NOT NULL default \'0000-00-00\','
        . ' `searchid` mediumint(9) NOT NULL default \'0\','
        . ' `keywords` varchar(255) NOT NULL default \'\''
        . ' ) TYPE=MyISAM';

$quer[] = 'CREATE TABLE IF NOT EXISTS `#__jstats_page_request` ('
        . ' `page_id` mediumint(9) NOT NULL default \'0\','
        . ' `hour` tinyint(4) NOT NULL default \'0\','
        . ' `day` tinyint(4) NOT NULL default \'0\','
        . ' `month` tinyint(4) NOT NULL default \'0\','
        . ' `year` smallint(6) NOT NULL default \'0\','
        . ' `ip_id` mediumint(9) default NULL,'
        . ' KEY `page_id` (`page_id`),'
        . ' KEY `monthyear` (`month`,`year`),'
        . ' KEY `visits_id` (`ip_id`),'
        . ' KEY `index_ip` (`ip_id`)'
        . ' ) TYPE=MyISAM';
        
$quer[] = 'CREATE TABLE IF NOT EXISTS `#__jstats_page_request_c` ('
        . ' `page_id` mediumint(9) NOT NULL default \'0\','
        . ' `hour` tinyint(4) NOT NULL default \'0\','
        . ' `day` tinyint(4) NOT NULL default \'0\','
        . ' `month` tinyint(4) NOT NULL default \'0\','
        . ' `year` smallint(6) NOT NULL default \'0\','
        . ' `count` mediumint(9) default NULL,'
        . ' KEY `page_id` (`page_id`),'
        . ' KEY `monthyear` (`month`,`year`)'
        . ' ) TYPE=MyISAM';

$quer[] = 'CREATE TABLE IF NOT EXISTS `#__jstats_pages` ('
        . ' `page_id` mediumint(9) NOT NULL auto_increment,'
        . ' `page` text NOT NULL,'
        . ' `page_title` varchar(255) default NULL,'
        . ' PRIMARY KEY (`page_id`),'
        . ' KEY `page_id` (`page_id`)'
        . ' ) TYPE=MyISAM';

$quer[] = 'CREATE TABLE IF NOT EXISTS `#__jstats_referrer` ('
        . ' `referrer` varchar(255) NOT NULL default \'\','
        . ' `domain` varchar(100) NOT NULL default \'unknown\','
        . ' `refid` mediumint(9) NOT NULL auto_increment,'
        . ' `day` tinyint(4) NOT NULL default \'0\','
        . ' `month` tinyint(4) NOT NULL default \'0\','
        . ' `year` smallint(6) NOT NULL default \'0\','
        . ' PRIMARY KEY (`refid`),'
        . ' KEY `referrer` (`referrer`),'
        . ' KEY `monthyear` (`month`,`year`)'
        . ' ) TYPE=MyISAM';

$quer[] = 'CREATE TABLE IF NOT EXISTS `#__jstats_search_engines` ('
        . ' `searchid` mediumint(9) NOT NULL auto_increment,'
        . ' `description` varchar(100) NOT NULL default \'\','
        . ' `search` varchar(100) NOT NULL default \'\','
        . ' `searchvar` varchar(50) NOT NULL default \'\','
        . ' PRIMARY KEY (`searchid`)'
        . ' ) TYPE=MyISAM';

$quer[] = 'CREATE TABLE IF NOT EXISTS `#__jstats_systems` ('
        . ' `sys_id` mediumint(9) NOT NULL auto_increment,'
        . ' `sys_string` varchar(25) NOT NULL default \'\','
        . ' `sys_fullname` varchar(25) NOT NULL default \'\','
        . ' `sys_img` tinyint(1) NOT NULL default \'0\','
        . ' PRIMARY KEY (`sys_id`)'
        . ' ) TYPE=MyISAM';

$quer[] = 'CREATE TABLE IF NOT EXISTS `#__jstats_topleveldomains` ('
        . ' `tld_id` mediumint(9) NOT NULL auto_increment,'
        . ' `tld` varchar(6) NOT NULL default \'\','
        . ' `fullname` varchar(255) NOT NULL default \'\','
        . ' PRIMARY KEY (`tld_id`),'
        . ' KEY `tld` (`tld`)'
        . ' ) TYPE=MyISAM';

$quer[] = 'CREATE TABLE IF NOT EXISTS #__jstats_visits ('
		. ' id mediumint(9) NOT NULL auto_increment,'
		. ' ip_id mediumint(9) NOT NULL default \'0\','
		. ' userid int(11) NOT NULL default \'0\','
		. ' hour tinyint(4) NOT NULL default \'0\','
		. ' day tinyint(4) NOT NULL default \'0\','
		. ' month tinyint(4) NOT NULL default \'0\','
		. ' year smallint(6) NOT NULL default \'0\','
		. ' time datetime NOT NULL default \'0000-00-00 00:00:00\','
		. ' PRIMARY KEY (id),'
		. ' KEY time (time),'
		. ' KEY ip_id (ip_id),'
		. ' KEY monthyear (month,year),'
		. ' KEY daymonthyear (day,month,year),'
		. ' KEY `userid` (`userid`)'
		. ' ) TYPE=MyISAM';


// Insert other configuration if they don't exist (if the descriptions exist, they are kept save by primairy key 'description')		
$quer[]  =  "INSERT IGNORE INTO #__jstats_configuration VALUES ('version', '". _JoomlaStats_V ."'),".	// we have to insert the version nummer if it doesn't exist, otherwise the replace won't work
			"('hourdiff','+1'),".
			"('onlinetime','15'),".
			"('startoption','r02'),".
			"('language','auto'),".
			"('purgetime','30'),".
			"('enable_whois','true'),".
			"('enable_i18n','true'),".
			"('show_bu','false'),".
			"('last_purge','')";
			
// Replace the version number
$quer[] =  "REPLACE #__jstats_configuration VALUES ('version', '". _JoomlaStats_V ."')";	
				
	
// transfer the data's 
foreach ($quer AS $query)
{
    $database->setQuery( $query );
   	if (!$database->query())
   	{ 
        $errors[] = array($database->getErrorMsg(), $query);
        //debug: echo $database->getErrorMsg();			// RB: we should display this at the end to make remote troubleshooting more easy
   	}
    else
   		$dataSum++;    	
}
$quer = NULL;




/* ######################### ip related datas ##################### */

// bots
// mic: more under: http://www.useragentstring.com/pages/useragentstring.php
$quer[] = "INSERT IGNORE INTO `#__jstats_bots` VALUES (1, 'acme.spider', 'Acme Spider'),
(2, 'ahoythehomepagefinder', 'Ahoy! The Homepage Finder'),
(3, 'alkaline', 'Alkaline'),
(4, 'appie', 'Walhello appie'),
(5, 'arachnophilia', 'Arachnophilia'),
(6, 'architext', 'ArchitextSpider'),
(7, 'aretha', 'Aretha'),
(8, 'ariadne', 'ARIADNE'),
(9, 'arks', 'arks'),
(10, 'aspider', 'ASpider (Associative Spider)'),
(11, 'atn.txt', 'ATN Worldwide'),
(12, 'atomz', 'Atomz.com Search Robot'),
(13, 'auresys', 'AURESYS'),
(14, 'backrub', 'BackRub'),
(15, 'biUKrother', 'Big Brother'),
(16, 'bjaaland', 'Bjaaland'),
(17, 'blackwidow', 'BlackWidow'),
(18, 'blindekuh', 'Die Blinde Kuh'),
(19, 'bloodhound', 'Bloodhound'),
(20, 'brightnet', 'bright.net caching robot'),
(21, 'bspider', 'BSpider'),
(22, 'cactvschemistryspider', 'CACTVS Chemistry Spider'),
(23, 'calif[^r]', 'Calif'),
(24, 'cassandra', 'Cassandra'),
(25, 'cgireader', 'Digimarc Marcspider/CGI'),
(26, 'checkbot', 'Checkbot'),
(27, 'churl', 'churl'),
(28, 'cmc', 'CMC/0.01'),
(29, 'collective', 'Collective'),
(30, 'combine', 'Combine System'),
(31, 'conceptbot', 'Conceptbot'),
(32, 'coolbot', 'CoolBot'),
(33, 'core', 'Web Core / Roots'),
(34, 'cosmos', 'XYLEME Robot'),
(35, 'cruiser', 'Internet Cruiser Robot'),
(36, 'cusco', 'Cusco'),
(37, 'cyberspyder', 'CyberSpyder Link Test'),
(38, 'deweb', 'DeWeb(c) Katalog/Index'),
(39, 'dienstspider', 'DienstSpider'),
(40, 'digger', 'Digger'),
(41, 'diibot', 'Digital Integrity Robot'),
(42, 'directhit', 'Direct Hit Grabber'),
(43, 'dnabot', 'DNAbot'),
(44, 'download_express', 'DownLoad Express'),
(45, 'dragonbot', 'DragonBot'),
(46, 'dwcp', 'DWCP (Dridus Web Cataloging Project)'),
(47, 'e-collector', 'e-collector'),
(48, 'ebiness', 'EbiNess'),
(49, 'eit', 'EIT Link Verifier Robot'),
(50, 'elfinbot', 'ELFINBOT'),
(51, 'emacs', 'Emacs-w3 Search Engine'),
(52, 'emcspider', 'ananzi'),
(53, 'esther', 'Esther'),
(54, 'evliyacelebi', 'Evliya Celebi'),
(55, 'nzexplorer', 'nzexplorer'),
(56, 'fdse', 'Fluid Dynamics Search Engine robot'),
(57, 'felix', 'Felix IDE'),
(58, 'ferret', 'Wild Ferret Web Hopper #1, #2, #3'),
(59, 'fetchrover', 'FetchRover'),
(60, 'fido', 'fido'),
(61, 'finnish', 'H�m�h�kki'),
(62, 'fireball', 'KIT-Fireball'),
(63, '[^a]fish', 'Fish search'),
(64, 'fouineur', 'Fouineur'),
(65, 'francoroute', 'Robot Francoroute'),
(66, 'freecrawl', 'Freecrawl'),
(67, 'funnelweb', 'FunnelWeb'),
(68, 'gama', 'gammaSpider, FocusedCrawler'),
(69, 'gazz', 'gazz'),
(70, 'gcreep', 'GCreep'),
(71, 'getbot', 'GetBot'),
(72, 'geturl', 'GetURL'),
(73, 'golem', 'Golem'),
(74, 'googlebot', 'Googlebot (Google)'),
(75, 'grapnel', 'Grapnel/0.01 Experiment'),
(76, 'griffon', 'Griffon'),
(77, 'gromit', 'Gromit'),
(78, 'gulliver', 'Northern Light Gulliver'),
(79, 'hambot', 'HamBot'),
(80, 'harvest', 'Harvest'),
(81, 'havindex', 'havIndex'),
(82, 'hometown', 'Hometown Spider Pro'),
(83, 'htdig', 'ht://Dig'),
(84, 'htmlgobble', 'HTMLgobble'),
(85, 'hyperdecontextualizer', 'Hyper-Decontextualizer'),
(86, 'iajabot', 'iajaBot'),
(87, 'ibm', 'IBM_Planetwide'),
(88, 'iconoclast', 'Popular Iconoclast'),
(89, 'ilse', 'Ingrid'),
(90, 'imagelock', 'Imagelock'),
(91, 'incywincy', 'IncyWincy'),
(92, 'informant', 'Informant'),
(93, 'infoseek', 'InfoSeek Robot 1.0'),
(94, 'infoseeksidewinder', 'Infoseek Sidewinder'),
(95, 'infospider', 'InfoSpiders'),
(96, 'inspectorwww', 'Inspector Web'),
(97, 'intelliagent', 'IntelliAgent'),
(98, 'irobot', 'I, Robot'),
(99, 'iron33', 'Iron33'),
(100, 'israelisearch', 'Israeli-search'),
(101, 'javabee', 'JavaBee'),
(102, 'jbot', 'JBot Java Web Robot'),
(103, 'jcrawler', 'JCrawler'),
(104, 'jeeves', 'Jeeves'),
(105, 'jobo', 'JoBo Java Web Robot'),
(106, 'jobot', 'Jobot'),
(107, 'joebot', 'JoeBot'),
(108, 'jubii', 'The Jubii Indexing Robot'),
(109, 'jumpstation', 'JumpStation'),
(110, 'katipo', 'Katipo'),
(111, 'kdd', 'KDD-Explorer'),
(112, 'kilroy', 'Kilroy'),
(113, 'ko_yappo_robot', 'KO_Yappo_Robot'),
(114, 'labelgrabber.txt', 'LabelGrabber'),
(115, 'larbin', 'larbin'),
(116, 'legs', 'legs'),
(117, 'linkidator', 'Link Validator'),
(118, 'linkscan', 'LinkScan'),
(119, 'linkwalker', 'LinkWalker'),
(120, 'lockon', 'Lockon'),
(121, 'logo_gif', 'logo.gif Crawler'),
(122, 'lycos', 'Lycos'),
(123, 'macworm', 'Mac WWWWorm'),
(124, 'magpie', 'Magpie'),
(125, 'marvin', 'marvin/infoseek'),
(126, 'mattie', 'Mattie'),
(127, 'mediafox', 'MediaFox'),
(128, 'merzscope', 'MerzScope'),
(129, 'meshexplorer', 'NEC-MeshExplorer'),
(130, 'mindcrawler', 'MindCrawler'),
(131, 'moget', 'moget'),
(132, 'momspider', 'MOMspider'),
(133, 'monster', 'Monster'),
(134, 'motor', 'Motor'),
(135, 'muscatferret', 'Muscat Ferret'),
(136, 'mwdsearch', 'Mwd.Search'),
(137, 'myweb', 'Internet Shinchakubin'),
(138, 'netcarta', 'NetCarta WebMap Engine'),
(139, 'netcraft', 'Netcraft Web Server Survey'),
(140, 'netmechanic', 'NetMechanic'),
(141, 'netscoop', 'NetScoop'),
(142, 'newscan-online', 'newscan-online'),
(143, 'nhse', 'NHSE Web Forager'),
(144, 'nomad', 'Nomad'),
(145, 'northstar', 'The NorthStar Robot'),
(146, 'occam', 'Occam'),
(147, 'octopus', 'HKU WWW Octopus'),
(148, 'openfind', 'Openfind data gatherer'),
(149, 'orb_search', 'Orb Search'),
(150, 'packrat', 'Pack Rat'),
(151, 'pageboy', 'PageBoy'),
(152, 'parasite', 'ParaSite'),
(153, 'patric', 'Patric'),
(154, 'pegasus', 'pegasus'),
(155, 'perignator', 'The Peregrinator'),
(156, 'perlcrawler', 'PerlCrawler 1.0'),
(157, 'phantom', 'Phantom'),
(158, 'piltdownman', 'PiltdownMan'),
(159, 'pimptrain', 'Pimptrain.com\'s robot'),
(160, 'pioneer', 'Pioneer'),
(161, 'pitkow', 'html_analyzer'),
(162, 'pjspider', 'Portal Juice Spider'),
(163, 'pka', 'PGP Key Agent'),
(164, 'plumtreewebaccessor', 'PlumtreeWebAccessor'),
(165, 'poppi', 'Poppi'),
(166, 'portalb', 'PortalB Spider'),
(167, 'puu', 'GetterroboPlus Puu'),
(168, 'python', 'The Python Robot'),
(169, 'raven', 'Raven Search'),
(170, 'rbse', 'RBSE Spider'),
(171, 'resumerobot', 'Resume Robot'),
(172, 'rhcs', 'RoadHouse Crawling System'),
(173, 'roadrunner', 'Road Runner: The ImageScape Robot'),
(174, 'robbie', 'Robbie the Robot'),
(175, 'robi', 'ComputingSite Robi/1.0'),
(176, 'robofox', 'RoboFox'),
(177, 'robozilla', 'Robozilla'),
(178, 'roverbot', 'Roverbot'),
(179, 'rules', 'RuLeS'),
(180, 'safetynetrobot', 'SafetyNet Robot'),
(181, 'scooter', 'Scooter (AltaVista)'),
(182, 'search_au', 'Search.Aus-AU.COM'),
(183, 'searchprocess', 'SearchProcess'),
(184, 'senrigan', 'Senrigan'),
(185, 'sgscout', 'SG-Scout'),
(186, 'shaggy', 'ShagSeeker'),
(187, 'shaihulud', 'Shai\'Hulud'),
(188, 'sift', 'Sift'),
(189, 'simbot', 'Simmany Robot Ver1.0'),
(190, 'site-valet', 'Site Valet'),
(191, 'sitegrabber', 'Open Text Index Robot'),
(192, 'sitetech', 'SiteTech-Rover'),
(193, 'slcrawler', 'SLCrawler'),
(194, 'slurp', 'Inktomi Slurp'),
(195, 'smartspider', 'Smart Spider'),
(196, 'snooper', 'Snooper'),
(197, 'solbot', 'Solbot'),
(198, 'spanner', 'Spanner'),
(199, 'speedy', 'Speedy Spider'),
(200, 'spider_monkey', 'spider_monkey'),
(201, 'spiderbot', 'SpiderBot'),
(202, 'spiderline', 'Spiderline Crawler'),
(203, 'spiderman', 'SpiderMan'),
(204, 'spiderview', 'SpiderView(tm)'),
(205, 'spry', 'Spry Wizard Robot'),
(206, 'ssearcher', 'Site Searcher'),
(207, 'suke', 'Suke'),
(208, 'suntek', 'suntek search engine'),
(209, 'sven', 'Sven'),
(210, 'tach_bw', 'TACH Black Widow'),
(211, 'tarantula', 'Tarantula'),
(212, 'tarspider', 'tarspider'),
(213, 'techbot', 'TechBOT'),
(214, 'templeton', 'Templeton'),
(215, 'teoma_agent1', 'TeomaTechnologies'),
(216, 'titin', 'TitIn'),
(217, 'titan', 'TITAN'),
(218, 'tkwww', 'The TkWWW Robot'),
(219, 'tlspider', 'TLSpider'),
(220, 'ucsd', 'UCSD Crawl'),
(221, 'udmsearch', 'UdmSearch'),
(222, 'urlck', 'URL Check'),
(223, 'valkyrie', 'Valkyrie'),
(224, 'victoria', 'Victoria'),
(225, 'visionsearch', 'vision-search'),
(226, 'voyager', 'Voyager'),
(227, 'vwbot', 'VWbot'),
(228, 'w3index', 'The NWI Robot'),
(229, 'w3m2', 'W3M2'),
(230, 'wallpaper', 'WallPaper'),
(231, 'wanderer', 'the World Wide Web Wanderer'),
(232, 'wapspider', 'w@pSpider by wap4.com'),
(233, 'webbandit', 'WebBandit Web Spider'),
(234, 'webcatcher', 'WebCatcher'),
(235, 'webcopy', 'WebCopy'),
(236, 'webfetcher', 'Webfetcher'),
(237, 'webfoot', 'The Webfoot Robot'),
(238, 'weblayers', 'Weblayers'),
(239, 'weblinker', 'WebLinker'),
(240, 'webmirror', 'WebMirror'),
(241, 'webmoose', 'The Web Moose'),
(242, 'webquest', 'WebQuest'),
(243, 'webreader', 'Digimarc MarcSpider'),
(244, 'webreaper', 'WebReaper'),
(245, 'websnarf', 'Websnarf'),
(246, 'webspider', 'WebSpider'),
(247, 'webvac', 'WebVac'),
(248, 'webwalk', 'webwalk'),
(249, 'webwalker', 'WebWalker'),
(250, 'webwatch', 'WebWatch'),
(251, 'wget', 'Wget'),
(252, 'whatuseek', 'whatUseek Winona'),
(253, 'whowhere', 'WhoWhere Robot'),
(254, 'wired-digital', 'Wired Digital'),
(255, 'wmir', 'w3mir'),
(256, 'wolp', 'WebStolperer'),
(257, 'wombat', 'The Web Wombat'),
(258, 'worm', 'The World Wide Web Worm'),
(259, 'wwwc', 'WWWC Ver 0.2.5'),
(260, 'wz101', 'WebZinger'),
(261, 'xget', 'XGET'),
(262, 'nederland.zoek', 'Nederland.zoek'),
(263, 'antibot', 'Antibot'),
(264, 'awbot', 'AWBot'),
(265, 'baiduspider', 'BaiDuSpider'),
(266, 'bobby', 'Bobby'),
(267, 'boris', 'Boris'),
(268, 'bumblebee', 'Bumblebee (relevare.com)'),
(269, 'cscrawler', 'CsCrawler'),
(270, 'daviesbot', 'DaviesBot'),
(271, 'digout4u', 'Digout4u'),
(272, 'echo', 'EchO!'),
(273, 'exactseek', 'ExactSeek Crawler'),
(274, 'ezresult', 'Ezresult'),
(275, 'fast-webcrawler', 'Fast-Webcrawler (AllTheWeb)'),
(276, 'gigabot', 'GigaBot'),
(277, 'gnodspider', 'GNOD Spider'),
(278, 'ia_archiver', 'Alexa (IA Archiver)'),
(279, 'internetseer', 'InternetSeer'),
(280, 'jennybot', 'JennyBot'),
(281, 'justview', 'JustView'),
(282, 'linkbot', 'LinkBot'),
(283, 'linkchecker', 'LinkChecker'),
(284, 'mercator', 'Mercator'),
(285, 'msiecrawler', 'MSIECrawler'),
(286, 'perman', 'Perman surfer'),
(287, 'petersnews', 'Petersnews'),
(288, 'pompos', 'Pompos'),
(289, 'psbot', 'psBot'),
(290, 'redalert', 'Red Alert'),
(291, 'shoutcast', 'Shoutcast Directory Service'),
(292, 'slysearch', 'SlySearch'),
(293, 'turnitinbot', 'Turn It In'),
(294, 'ultraseek', 'Ultraseek'),
(295, 'unlost_web_crawler', 'Unlost Web Crawler'),
(296, 'voila', 'Voila'),
(297, 'webbase', 'WebBase'),
(298, 'webcompass', 'webcompass'),
(299, 'wisenutbot', 'WISENutbot (Looksmart)'),
(300, 'yandex', 'Yandex bot'),
(301, 'zyborg', 'Zyborg (Looksmart)'),
(308, 'mixcat', 'morris - mixcat crawler'),
(305, 'netresearchserver', 'Net Research Server'),
(306, 'vagabondo', 'vagabondo (test version WiseGuys webagent)'),
(307, 'szukacz', 'Szukacz crawler'),
(309, 'grub-client', 'Grub\'s distributed crawler'),
(310, 'fluffy', 'fluffy (searchhippo)'),
(311, 'webtrends link analyzer', 'webtrends link analyzer'),
(312, 'naverrobot', 'naver'),
(313, 'steeler', 'steeler'),
(314, 'bordermanager', 'bordermanager'),
(315, 'nutch', 'Nutch'),
(316, 'teradex', 'Teradex'),
(317, 'deepindex', 'DeepIndex'),
(318, 'npbot', 'NPBot'),
(319, 'webcraftboot', 'Webcraftboot'),
(320, 'franklin locator', 'Franklin locator'),
(321, 'internet ninja', 'Internet ninja'),
(322, 'space bison', 'Space bison'),
(323, 'gornker', 'gornker crawler'),
(324, 'gaisbot', 'Gaisbot'),
(325, 'cj spider', 'CJ spider'),
(326, 'semanticdiscovery', 'Semantic Discovery'),
(327, 'zao', 'Zao'),
(328, 'web downloader', 'Web Downloader'),
(329, 'webstripper', 'Webstripper'),
(330, 'zeus', 'Zeus'),
(331, 'webrace', 'Webrace'),
(332, 'christcrawler', 'ChristCENTRAL'),
(333, 'webfilter', 'Webfilter'),
(334, 'webgather', 'Webgather'),
(335, 'surveybot', 'Surveybot'),
(336, 'nitle blog spider', 'Nitle Blog Spider'),
(337, 'galaxybot', 'Galaxybot'),
(338, 'fangcrawl', 'FangCrawl'),
(339, 'searchspider', 'SearchSpider'),
(340, 'msnbot', 'msnbot'),
(341, 'computer_and_automation_research_institute_crawler', 'computer and automation research institute crawler'),
(342, 'overture-webcrawler', 'overture-webcrawler'),
(343, 'exalead ng', 'exalead ng'),
(344, 'denmex websearch', 'denmex websearch'),
(345, 'linkfilter.net url verifier', 'linkfilter.net url verifier'),
(346, 'mac finder', 'mac finder'),
(347, 'polybot', 'polybot'),
(348, 'quepasacreep', 'quepasacreep'),
(349, 'xenu link sleuth', 'xenu link sleuth'),
(350, 'hatena antenna', 'hatena antenna'),
(351, 'timbobot', 'timbobot'),
(352, 'waypath scout', 'waypath scout'),
(353, 'technoratibot', 'technoratibot'),
(354, 'frontier', 'frontier'),
(355, 'blogosphere', 'blogosphere'),
(356, 'my little bot', 'my little bot'),
(357, 'illinois state tech labs', 'illinois state tech labs'),
(358, 'splatsearch.com', 'splatsearch'),
(359, 'blogshares bot', 'blogshares bot'),
(360, 'fastbuzz.com', 'fastbuzz'),
(361, 'obidos-bot', 'obidos'),
(362, 'blogwise.com-metachecker', 'blogwise.com metachecker'),
(363, 'bravobrian bstop', 'bravobrian bstop'),
(364, 'feedster crawler', 'feedster'),
(365, 'isspider', 'blogpulse'),
(366, 'syndic8', 'syndic8'),
(367, 'blogvisioneye', 'blogvisioneye'),
(368, 'downes/referrers', 'downes/referrers'),
(369, 'naverbot', 'naverbot'),
(370, 'soziopath', 'soziopath'),
(371, 'nextopiabot', 'nextopiabot'),
(372, 'ingrid', 'ingrid'),
(373, 'vspider', 'vspider'),
(374, 'yahoo', 'Yahoo'),
(375, 'sherlock-spider', 'Sherlock Spider'),
(376, 'mercubot', 'Mercubot'),
(377, 'mediapartners-google', 'Mediapartners Google'),
(378, 'jetbot', 'JetBot'),
(379, 'faxobot', 'FaxoBot'),
(380, 'cosmixcrawler', 'cosmix crawler'),
(381, 'exabot', 'exabot'),
(382, 'sitespider', 'sitespider'),
(383, 'pipeliner', 'pipeliner'),
(384, 'ccgcrawl', 'ccgcrawl'),
(385, 'cydralspider', 'cydralspider'),
(386, 'crawlconvera', 'crawlconvera'),
(387, 'blogwatcher', 'blogwatcher'),
(388, 'mozdex', 'mozdex'),
(389, 'aleksika spider', 'aleksika spider'),
(390, 'e-societyrobot', 'e-societyrobot'),
(391, 'enterprise_search', 'enterprise search'),
(392, 'seekbot', 'seekbot'),
(393, 'emeraldshield', 'emeraldshield'),
(394, 'mj12bot', 'mj12bot'),
(395, 'aipbot', 'aipbot'),
(396, 'omniexplorer_bot', 'omniexplorer_bot'),
(397, 'shim-crawler', 'shim-crawler'),
(398, 'nimblecrawler', 'nimblecrawler'),
(399, 'msrbot', 'msrbot'),
(400, 'scirus', 'scirus'),
(401, 'geniebot', 'geniebot'),
(402, 'nextgensearchbot', 'nextgensearchbot'),
(403, 'ichiro', 'ichiro'),
(404, 'peerfactor 404 crawler','peerfactor 404 crawler'),
(405, 'ebay relevance ad crawler', 'Ebay relevance ad crawler'),
(406, 'yodaobot', 'yodaobot/1.0'),
(407, 'vmbot', 'vmbot/0.9'),
(408, 'Blaiz-Bee', 'Blaiz-Bee/2.00.*'),
(409, 'sensis', 'Sensis Web Crawler'),
(410, 'ABACHOBot', 'ABACHOBot'),
(411, 'AbiLogicBot', 'AbiLogicBot http://www.abilogic.com/bot.html'),
(412, 'Googlebot-Image', 'Googlebot-Image'),
(413, 'EmailSiphon', 'EmailSiphon (Sonic) - Email Collector'),
(414, 'W3C-checklink', 'W3C Linkchecker'),
(419, 'W3C_Validator', 'W3C XHTML/HTML Validator'),
(420, 'depspid', 'DepSpid http://about.depspid.net');";

// browser
$quer[] = "INSERT IGNORE INTO `#__jstats_browsers` VALUES (1, 'msie', 'Internet Explorer', 0),
(2, 'netscape', 'Netscape', 0),
(3, 'gecko', 'Mozilla', 0),
(4, 'icab', 'iCab', 0),
(5, 'go!zilla', 'Go!Zilla', 0),
(6, 'konqueror', 'Konqueror', 0),
(7, 'links', 'Links', 0),
(8, 'lynx', 'Lynx', 0),
(9, 'omniweb', 'OmniWeb', 0),
(10, 'opera', 'Opera', 0),
(11, 'wget', 'Wget', 0),
(12, '22acidownload', '22AciDownload', 0),
(13, 'aol\\-iweng', 'AOL-Iweng', 0),
(14, 'amaya', 'Amaya', 0),
(15, 'amigavoyager', 'AmigaVoyager', 0),
(16, 'aweb', 'AWeb', 0),
(17, 'bpftp', 'BPFTP', 0),
(18, 'cyberdog', 'Cyberdog', 0),
(19, 'dreamcast', 'Dreamcast', 0),
(20, 'downloadagent', 'DownloadAgent', 0),
(21, 'ecatch', 'eCatch', 0),
(22, 'emailsiphon', 'EmailSiphon', 0),
(23, 'encompass', 'Encompass', 0),
(24, 'friendlyspider', 'FriendlySpider', 0),
(25, 'fresco', 'ANT Fresco', 0),
(26, 'galeon', 'Galeon', 0),
(27, 'getright', 'GetRight', 0),
(28, 'headdump', 'HeadDump', 0),
(29, 'hotjava', 'Sun HotJava', 0),
(30, 'ibrowse', 'IBrowse', 0),
(31, 'intergo', 'InterGO', 0),
(32, 'linemodebrowser', 'W3C Line Mode Browser', 0),
(33, 'lotus-notes', 'Lotus Notes web client', 0),
(34, 'macweb', 'MacWeb', 0),
(35, 'ncsa_mosaic', 'NCSA Mosaic', 0),
(36, 'netpositive', 'NetPositive', 0),
(37, 'nutscrape', 'Nutscrape', 0),
(38, 'msfrontpageexpress', 'MS FrontPage Express', 0),
(39, 'phoenix', 'Phoenix', 0),
(40, 'tzgeturl', 'TzGetURL', 0),
(41, 'viking', 'Viking', 0),
(42, 'webfetcher', 'WebFetcher', 0),
(43, 'webexplorer', 'IBM-WebExplorer', 0),
(44, 'webmirror', 'WebMirror', 0),
(45, 'webvcr', 'WebVCR', 0),
(46, 'teleport', 'TelePort Pro', 0),
(47, 'webcapture', 'Acrobat', 0),
(48, 'webcopier', 'WebCopier', 0),
(49, 'real', 'RealAudio or compatible (media player)', 0),
(50, 'winamp', 'WinAmp (media player)', 0),
(51, 'windows-media-player', 'Windows Media Player (media player)', 0),
(52, 'audion', 'Audion (media player)', 0),
(53, 'freeamp', 'FreeAmp (media player)', 0),
(54, 'itunes', 'Apple iTunes (media player)', 0),
(55, 'jetaudio', 'JetAudio (media player)', 0),
(56, 'mint_audio', 'Mint Audio (media player)', 0),
(57, 'mpg123', 'mpg123 (media player)', 0),
(58, 'nsplayer', 'NetShow Player (media player)', 0),
(59, 'sonique', 'Sonique (media player)', 0),
(60, 'uplayer', 'Ultra Player (media player)', 0),
(61, 'xmms', 'XMMS (media player)', 0),
(62, 'xaudio', 'Some XAudio Engine based MPEG player (media player', 0),
(63, 'mmef', 'Microsoft Mobile Explorer (PDA/Phone browser)', 0),
(64, 'mspie', 'MS Pocket Internet Explorer (PDA/Phone browser)', 0),
(65, 'wapalizer', 'WAPalizer (PDA/Phone browser)', 0),
(66, 'wapsilon', 'WAPsilon (PDA/Phone browser)', 0),
(67, 'webcollage', 'WebCollage (PDA/Phone browser)', 0),
(68, 'alcatel', 'Alcatel Browser (PDA/Phone browser)', 0),
(69, 'nokia', 'Nokia Browser (PDA/Phone browser)', 0),
(70, 'webtv', 'WebTV browser', 0),
(71, 'csscheck', 'WDG CSS Validator', 0),
(72, 'w3m', 'w3m', 0),
(73, 'w3c_css_validator', 'W3C CSS Validator', 0),
(74, 'w3c_validator', 'W3C HTML Validator', 0),
(75, 'wdg_validator', 'WDG HTML Validator', 0),
(76, 'webzip', 'WebZIP', 0),
(77, 'staroffice', 'StarOffice', 0),
(78, 'libwww', 'LibWWW', 0),
(79, 'httrack', 'HTTrack (offline browser utility)', 0),
(80, 'webstripper', 'webstripper (offline browser)', 0),
(81, 'safari', 'Safari', 0),
(82, 'avant browser', 'avant browser', 0),
(83, 'firebird', 'firebird', 0),
(84, 'avantgo', 'avantgo', 0),
(85, 'firefox', 'FireFox', 0),
(86, 'navio_aoltv', 'navio aoltv', 0)";


// search engines
$quer[] = "INSERT IGNORE INTO #__jstats_search_engines VALUES (1, 'Google', 'google.', 'p=,q='),
(2, 'Alexa', 'alexa.com', 'q='),
(3, 'Alltheweb', 'alltheweb.com', 'query=,q='),
(4, 'Altavista', 'altavista.', 'q='),
(5, 'DMOZ', 'dmoz.org', 'search='),
(6, 'Google Images', 'images.google.', 'p=,q='),
(7, 'Lycos', 'lycos.', 'query='),
(8, 'Msn', 'msn.', 'q='),
(9, 'Netscape', 'netscape.', 'search='),
(10, 'Search AOL', 'search.aol.com', 'query='),
(11, 'Search Terra', 'search.terra.', 'query='),
(12, 'Voila', 'voila.', 'kw='),
(13, 'Search.Com', 'www.search.com', 'q='),
(14, 'Yahoo', 'yahoo.', 'p='),
(15, 'Go Com', '.go.com', 'qt='),
(16, 'Ask Com', '.ask.com', 'ask='),
(17, 'Atomz', 'atomz.', 'sp-q='),
(18, 'EuroSeek', 'euroseek.', 'query='),
(19, 'Excite', 'excite.', 'search='),
(20, 'FindArticles', 'findarticles.com', 'key='),
(21, 'Go2Net', 'go2net.com', 'general='),
(22, 'HotBot', 'hotbot.', 'mt='),
(23, 'InfoSpace', 'infospace.com', 'qkw='),
(24, 'Kvasir', 'kvasir.', 'q='),
(25, 'LookSmart', 'looksmart.', 'key='),
(26, 'Mamma', 'mamma.', 'query='),
(27, 'MetaCrawler', 'metacrawler.', 'general='),
(28, 'Nbci.Com', 'nbci.com/search', 'keyword='),
(29, 'Northernlight', 'northernlight.', 'qr='),
(30, 'Overture', 'overture.com', 'keywords='),
(31, 'Dogpile', 'dogpile.com', 'qkw='),
(32, 'Dogpile', 'search.dogpile.com', 'q='),
(33, 'Spray', 'spray.', 'string='),
(34, 'Teoma', 'teoma.', 'q='),
(35, 'Virgilio', 'virgilio.it', 'qs='),
(36, 'Webcrawler', 'webcrawler', 'searchText='),
(37, 'Wisenut', 'wisenut.com', 'query='),
(38, 'ix quick', 'ixquick.com', 'query='),
(39, 'Earthlink', 'search.earthlink.net', 'q='),
(40, 'Sympatico', 'search.sli.sympatico.ca', 'query='),
(41, 'I-une', 'i-une.com', 'keywords=,q='),
(42, 'Miner.Bol.Com', 'miner.bol.com.br', 'q='),
(43, 'Baidu', 'baidu.com', 'word='),
(44, 'Sina', 'search.sina.com', 'word='),
(45, 'Sohu', 'search.sohu.com', 'word='),
(46, 'Atlas cz', 'atlas.cz', 'searchtext='),
(47, 'Seznam cz', 'seznam.cz', 'w='),
(48, 'Ftxt Quick cz', 'ftxt.quick.cz', 'query='),
(49, 'Centrum cz', 'centrum.cz', 'q='),
(50, 'Opasia dk', 'opasia.dk', 'q='),
(51, 'Danielsen', 'danielsen.com', 'q='),
(52, 'Sol dk', 'sol.dk', 'q='),
(53, 'Jubii dk', 'jubii.dk', 'soegeord='),
(54, 'Find dk', 'find.dk', 'words='),
(55, 'Edderkoppen dk', 'edderkoppen.dk', 'query='),
(56, 'Orbis dk', 'orbis.dk', 'search_field='),
(57, '1klik dk', '1klik.dk', 'query='),
(58, 'Ofir dk', 'ofir.dk', 'querytext='),
(59, 'Ilse nl', 'ilse.', 'search_for='),
(60, 'Vindex nl', 'vindex.', 'in='),
(61, 'Ask uk', 'ask.co.uk', 'ask='),
(62, 'BBC uk', 'bbc.co.uk/cgi-bin/search', 'q='),
(63, 'ifind uk', 'ifind.freeserve', 'q='),
(64, 'Looksmart uk', 'looksmart.co.uk', 'key='),
(65, 'mirago uk', 'mirago.', 'txtsearch='),
(66, 'Splut uk', 'splut.', 'pattern='),
(67, 'Spotjockey uk', 'spotjockey.', 'Search_Keyword='),
(68, 'Ukindex uk', 'ukindex.co.uk', 'stext='),
(69, 'Ukdirectory uk', 'ukdirectory.', 'k='),
(70, 'Ukplus uk', 'ukplus.', 'search='),
(71, 'Searchy uk', 'searchy.co.uk', 'search_term='),
(73, 'Haku fi', 'haku.www.fi', 'w='),
(74, 'Nomade fr', 'nomade.fr', 's='),
(75, 'Francite fr', 'francite.', 'name='),
(76, 'Club internet fr', 'recherche.club-internet.fr', 'q='),
(77, 'yandex', 'yandex.ru', 'text='),
(78, 'nigma', 'nigma.ru', 'q='),
(79, 'rambler', 'rambler.ru', 'words='),
(80, 'aport', 'aport.ru', 'r='),
(81, 'mail', 'mail.ru', 'q=')";

// os systems
$quer[] = "INSERT IGNORE INTO #__jstats_systems VALUES (1, 'win95', 'Windows 95', 0),
(2, 'windows 95', 'Windows 95', 0),
(3, 'win98', 'Windows 98', 0),
(4, 'windows 98', 'Windows 98', 0),
(5, 'winme', 'Windows me', 0),
(6, 'windows me', 'Windows me', 0),
(7, 'windows nt 5.0', 'Windows 2000', 0),
(8, 'winnt 5.0', 'Windows 2000', 0),
(10, 'winnt 5.1', 'Windows XP', 0),
(11, 'windows nt 5.1', 'Windows XP', 0),
(12, 'macintosh', 'Mac OS', 0),
(13, 'linux', 'Linux', 0),
(14, 'aix', 'Aix', 0),
(15, 'sunos', 'Sun Solaris', 0),
(16, 'irix', 'Irix', 0),
(17, 'osf', 'OSF Unix', 0),
(18, 'hp-ux', 'HP Unix', 0),
(19, 'netbsd', 'NetBSD', 0),
(20, 'bsdi', 'BSDi', 0),
(21, 'freebsd', 'FreeBSD', 0),
(22, 'openbsd', 'OpenBSD', 0),
(23, 'unix', 'Unknown Unix system', 0),
(24, 'beos', 'BeOS', 0),
(25, 'os/2', 'Warp OS/2', 0),
(26, 'amigaos', 'AmigaOS', 0),
(27, 'vms', 'VMS', 0),
(28, 'cp/m', 'CPM', 0),
(29, 'crayos', 'CrayOS', 0),
(30, 'dreamcast', 'Dreamcast', 0),
(31, 'riscos', 'RISC OS', 0),
(32, 'webtv', 'WebTV', 0),
(33, 'windows nt 5.2', 'Windows 2003', 0),
(34, 'mac_powerpc', 'Mac PowerPC', 0),
(35, 'mac os x', 'Mac OS X', 0),
(36, 'windows nt', 'Windows NT', 0)";

// TLDs
$quer[] = "INSERT IGNORE INTO #__jstats_topleveldomains VALUES
(1, 'ac', '阿森松(南大西洋岛屿)'),
(2, 'ad', '安道尔共和国'),
(3, 'ae', '阿拉伯联合酋长国'),
(4, 'af', '阿富汗'),
(5, 'ag', '安提瓜岛 及 巴布达岛'),
(6, 'ai', '安圭拉'),
(7, 'al', '阿尔巴尼亚'),
(8, 'am', '安圭拉岛'),
(9, 'an', '荷兰 安的列斯群岛'),
(10, 'ao', '安哥拉'),
(11, 'aq', '南极洲'),
(12, 'ar', '阿根廷'),
(13, 'as', '美国 萨摩亚群岛'),
(14, 'at', '奥地利'),
(15, 'au', '澳大利亚'),
(16, 'aw', '阿鲁巴岛'),
(17, 'ax', '奥兰群岛'),
(18, 'az', '阿塞拜疆'),
(19, 'ba', '波斯尼亚 塞尔维亚'),
(20, 'bb', '巴巴多斯岛'),
(21, 'bd', '孟加拉国'),
(22, 'be', '比利时'),
(23, 'bf', '布基纳法索'),
(24, 'bg', '保加利亚'),
(25, 'bh', '巴林'),
(26, 'bi', '布隆迪'),
(27, 'bj', '贝宁'),
(28, 'bm', '百慕大群岛'),
(29, 'bn', '文莱达鲁萨兰国'),
(30, 'bo', '玻利维亚'),
(31, 'br', '巴西'),
(32, 'bs', '巴哈马群岛'),
(33, 'bt', '不丹'),
(34, 'bv', '布维岛'),
(35, 'bw', '博茨瓦纳'),
(36, 'by', '白俄罗斯'),
(37, 'bz', '伯利兹'),
(38, 'ca', '加拿大'),
(39, 'cc', '科科斯群岛(基灵)'),
(40, 'cd', '刚果民主共和国'),
(41, 'cf', '中非共和国'),
(42, 'cg', '刚果共和国'),
(43, 'ch', '瑞士'),
(44, 'ci', 'Cote d\'Ivoire (象牙海岸)'),
(45, 'ck', '库克群岛'),
(46, 'cl', '智利'),
(47, 'cm', '喀麦隆'),
(48, 'cn', '中国'),
(49, 'co', '哥伦比亚'),
(50,  'cr', '哥斯达黎加'),
(51, 'cs', '捷克'),
(52,  'cu', '古巴'),
(53, 'cv', '佛得角共和国'),
(54, 'cx', '圣诞岛'),
(55, 'cy', '塞浦路斯'),
(56, 'cz', '捷克共和国'),
(57, 'de', '德国'),
(58, 'dj', '吉布提'),
(59, 'dk', '丹麦'),
(60, 'dm', '多米尼加'),
(61, 'do', '多米尼加共和国'),
(62, 'dz', '阿尔及利亚'),
(63, 'ec', '厄瓜多尔'),
(64, 'ee', '爱沙尼亚'),
(65, 'eg', '埃及'),
(66, 'eh', '西撒哈拉'),
(67, 'er', '厄立特里亚'),
(68, 'es', '西班牙'),
(69, 'et', '埃塞俄比亚'),
(70, 'fi', '芬兰'),
(71, 'fj', '斐济'),
(72, 'fk', '福克兰群岛'),
(73, 'fm', '密克罗尼西亚'),
(74, 'fo', '法罗群岛'),
(75, 'fr', '法国'),
(76, 'ga', '加蓬'),
(77, 'gb', '英国'),
(78, 'gd', '格林纳达'),
(79, 'ge', '乔治亚苏维埃社会主义共和国'),
(80, 'gf', '法属圭亚那'),
(81, 'gg', '根西岛'),
(82, 'gh', '加纳'),
(83, 'gi', '直布罗陀'),
(84, 'gl', '格陵兰'),
(85, 'gm', '冈比亚'),
(86, 'gn', '几内亚'),
(87, 'gp', '瓜德罗普岛'),
(88, 'gq', '赤道几内亚'),
(89, 'gr', '希腊'),
(90, 'gs', '南乔治亚岛和南桑威奇群岛'),
(91, 'gt', '危地马拉'),
(92, 'gu', '关岛'),
(93, 'gw', '几内亚比绍共和国'),
(94, 'gy', '圭亚那'),
(95, 'hk', '香港'),
(96, 'hm', '赫德岛和麦克唐纳岛'),
(97, 'hn', '洪都拉斯'),
(98, 'hr', '克罗地亚/赫尔瓦次卡'),
(99, 'ht', '海地'),
(100, 'hu', '匈牙利'),
(101, 'id', '印尼'),
(102, 'ie', '爱尔兰'),
(103, 'il', '以色列'),
(104, 'im', '曼恩岛'),
(105, 'in', '印度'),
(106, 'io', '英属印度洋领地'),
(107, 'iq', '伊拉克'),
(108, 'ir', '伊朗'),
(109, 'is', '冰岛'),
(110, 'it', '意大利'),
(111, 'je', '泽西岛'),
(112, 'jm', '牙买加'),
(113, 'jo', '约旦'),
(114, 'jp', '日本'),
(115, 'ke', '肯尼亚'),
(116, 'kg', '吉尔吉斯斯坦'),
(117, 'kh', '柬埔寨'),
(118, 'ki', '基里巴斯'),
(119, 'km', '科摩罗'),
(120, 'kn', '圣基茨和尼维斯'),
(121, 'kp', '朝鲜'),
(122, 'kr', '韩国'),
(123, 'kw', '科威特'),
(124, 'ky', '开曼群岛'),
(125, 'kz', '哈萨克斯坦'),
(126, 'la', '老挝'),
(127, 'lb', '黎巴嫩'),
(128, 'lc', '圣卢西亚'),
(129, 'li', '列支敦士登'),
(130, 'lk', '斯里兰卡'),
(131, 'lr', '利比里亚'),
(132, 'ls', '莱索托'),
(133, 'lt', '立陶宛'),
(134, 'lu', '卢森堡公国'),
(135, 'lv', '拉脱维亚'),
(136, 'ly', '阿拉伯利比亚民众国'),
(137, 'ma', '摩洛哥'),
(138, 'mc', '摩纳哥'),
(139, 'md', '摩尔多瓦'),
(140, 'mg', '马达加斯加岛'),
(141, 'mh', '马绍尔群岛'),
(142, 'mk', '马其顿王国, 前 南斯拉夫'),
(143, 'ml', '马里'),
(144, 'mm', '缅甸'),
(145, 'mn', '蒙古'),
(146, 'mo', '澳门'),
(147, 'mp', '北马里亚纳群岛'),
(148, 'mq', '马提尼克岛'),
(149, 'mr', '毛利塔尼亚'),
(150, 'ms', '蒙特塞拉特岛'),
(151, 'mt', '马耳他'),
(152, 'mu', '毛里求斯'),
(153, 'mv', '马尔代夫'),
(154, 'mw', '马拉维'),
(155, 'mx', '墨西哥'),
(156, 'my', '马来西亚'),
(157, 'mz', '莫桑比克'),
(158, 'na', '纳米比亚'),
(159, 'nc', '新喀里多尼亚'),
(160, 'ne', '尼日尔'),
(161, 'nf', '诺福克岛'),
(162, 'ng', '尼日利亚'),
(163, 'ni', '尼加拉瓜'),
(164, 'nl', '荷兰'),
(165, 'no', '挪威'),
(166, 'np', '尼泊尔'),
(167, 'nr', '瑙鲁'),
(168, 'nt', '中立区'),
(169, 'nu', '纽埃岛'),
(170, 'nz', '新西兰'),
(171, 'om', '阿曼'),
(172, 'pa', '巴拿马'),
(173, 'pe', '秘鲁'),
(174, 'pf', '法属玻利尼西亚'),
(175, 'pg', '巴布亚新几内亚'),
(176, 'ph', '菲律宾'),
(177, 'pk', '巴基斯坦'),
(178, 'pl', '波兰'),
(179, 'pm', '圣彼得岛和米克隆岛'),
(180, 'pn', '皮特凯恩群岛'),
(181, 'pr', '波多黎各'),
(182, 'ps', '巴勒斯坦'),
(183, 'pt', '葡萄牙'),
(184, 'pw', '帕劳群岛'),
(185, 'py', '巴拉圭'),
(186, 'qa', '卡塔尔'),
(187, 're', '留尼汪岛'),
(188, 'ro', '罗马尼亚'),
(189, 'ru', '俄罗斯联邦'),
(190, 'rw', '卢旺达'),
(191, 'sa', '沙特阿拉伯'),
(192, 'sb', '所罗门群岛'),
(193, 'sc', '塞舌尔'),
(194, 'sd', '苏丹'),
(195, 'se', '瑞典'),
(196, 'sg', '新加坡'),
(197, 'sh', '圣海伦岛'),
(198, 'si', '斯洛文尼亚'),
(199, 'sj', '斯瓦尔巴岛和扬马延岛'),
(200, 'sk', '斯洛伐克'),
(201, 'sl', '塞拉利昂'),
(202, 'sm', '圣马力诺'),
(203, 'sn', '塞内加尔'),
(204, 'so', '索马里'),
(205, 'sr', '苏里南'),
(206, 'st', '圣多美和普林西比'),
(207, 'su', '前苏联'),
(208, 'sv', '萨尔瓦多'),
(209, 'sy', '叙利亚'),
(210, 'sz', '斯威士兰'),
(211, 'tc', '特克斯和凯科斯群岛'),
(212, 'td', '乍得'),
(213, 'tf', '法属南部领土'),
(214, 'tg', '多哥'),
(215, 'th', '泰国'),
(216, 'tj', '塔吉克斯坦'),
(217, 'tk', '托克劳群岛'),
(218, 'tl', '东帝汶'),
(219, 'tm', '土库曼斯坦'),
(220, 'tn', '突尼斯'),
(221, 'to', '汤加'),
(222, 'tp', '东帝汶'),
(223, 'tr', '土耳其'),
(224, 'tt', '特立尼达和多巴哥'),
(225, 'tv', '图瓦卢'),
(226, 'tw', '台湾'),
(227, 'tz', '坦桑尼亚'),
(228, 'ua', '乌克兰'),
(229, 'ug', '乌干达'),
(230, 'uk', '英国'),
(231, 'um', '美国本土外小岛屿'),
(232, 'us', '美国'),
(233, 'uy', '乌拉圭'),
(234, 'uz', '乌兹别克斯坦'),
(235, 'va', '教廷 (梵蒂冈)'),
(236, 'vc', '圣文森特和格林纳丁斯'),
(237, 've', '委内瑞拉'),
(238, 'vg', '维尔京群岛 (英国)'),
(239, 'vi', '维尔京群岛 (美国)'),
(240, 'vn', '越南'),
(241, 'vu', '瓦努阿图'),
(242, 'wf', '瓦利斯群岛和富图纳群岛'),
(243, 'ws', '西萨摩亚群岛'),
(244, 'ye', '也门'),
(245, 'yt', '马约特岛'),
(246, 'yu', '南斯拉夫'),
(247, 'za', '南非'),
(248, 'zm', '赞比亚'),
(249, 'zw', '津巴布韦'),

(250, 'eu', '欧盟'),
(251, 'cat', 'Catalonia'),
(252, 'com', '商业域'),
(253, 'net', '网络域'),
(254, 'org', '组织'),
(255, 'gov', '政府域 (美)'),
(256, 'mil', '军队网络 (美国防部)'),
(257, 'int', '国际组织'),
(258, 'aero', '航空工业'),
(259, 'biz', '商业域'),
(260, 'coop', '协作域'),
(261, 'edu', '教育机构'),
(262, 'info', '全球非限定使用'),
(263, 'jobs', '工作机会提供公司'),
(264, 'mobi', '移动互联网服务'),
(265, 'museum', '博物馆'),
(266, 'name', '个人及家庭'),
(267, 'pro', '专业人员域'),
(268, 'travel', '旅游业'),
(269, 'arpa', '旧式 ARPAnet'),

(270, '', '未知')";



// transfer the data's 
foreach($quer AS $query)
{
    $database->setQuery($query);
   	if(!$database->query()) 
        $errors[] = array($database->getErrorMsg(), $query);
    else
   		$dataSum++;    	
}
$quer = NULL;


/* indicates that this file is fullfilled and datas are transfered
 * @param boolean
 */
if (!count($errors))
	$dataInstalled 	= true;

?>
