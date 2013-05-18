DROP TABLE `resultats`;
CREATE TABLE `resultats` (
  `id` int(5) NOT NULL auto_increment,
  `date_comp` date NOT NULL default '0000-00-00',
  `epreuve` varchar(50) NOT NULL default '',
  `lieu` varchar(50) NOT NULL default '',
  `categorie` varchar(50) NOT NULL default '',
  `resultat_che` text NOT NULL,
  PRIMARY KEY  (`id`)
) TYPE=MyISAM AUTO_INCREMENT=1 ;

-- 
-- Contenu de la table `resultats`
-- 

INSERT INTO `resultats` VALUES (1, '2006-09-24', 'Circuit Zone', 'Gonesse', 'Junior Dames', '11 - MOURET Alix');
INSERT INTO `resultats` VALUES (2, '2006-09-24', 'Circuit Zone', 'Gonesse', 'Junior Hommes', '3 - COMPERE Jean-Baptiste<br />\n16 - DOIREAU Charles<br />\r\n20 - DOIREAU Louis<br />\r\n39 - POYET Geoffroy<br />\r\n57 - CHEVREUIL Pierre-Olivier<br />\r\n70 - BEAUCHET Marc<br />');
INSERT INTO `resultats` VALUES (3, '2006-09-30', 'Circuit National', 'Livry-Gargan', 'Seniors', '112 - RASO Thomas<br />\n118 - VIGOUROUX Guillaume<br />\n126 - BELLICART Denis (Villeurbanne)<br />\n151 - VOISEUX Jean-Christophe<br />\n174 - COMPERE Jean-Baptiste<br />\n189 - TARALLE Florent<br />\n304 - GACOIN Arnaud<br />\n309 - TARALLE Luc');