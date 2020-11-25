SET NAMES utf8;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
--  Table structure for `network`
-- ----------------------------
DROP TABLE IF EXISTS `network`;
CREATE TABLE `network` (
  `dataset` varchar(255) DEFAULT NULL,
  `source` varchar(255) DEFAULT NULL,
  `target` varchar(255) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `irp_score` float DEFAULT NULL,
  `nc_score` float DEFAULT NULL,
  `nc_sdev` float DEFAULT NULL,
  `gene_i1` int(16) DEFAULT NULL,
  `gene_i2` int(16) DEFAULT NULL,
  `edg_id` int(11) NOT NULL AUTO_INCREMENT,
  `corr1` float DEFAULT NULL,
  PRIMARY KEY (`edg_id`),
  KEY `gene_i1` (`gene_i1`) USING BTREE,
  KEY `gene_i2` (`gene_i2`) USING BTREE,
  KEY `source` (`source`) USING BTREE,
  KEY `target` (`target`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

-- ----------------------------
--  Table structure for `expression`
-- ----------------------------
DROP TABLE IF EXISTS `expression`;
CREATE TABLE `expression` (
  `gene_id` varchar(60) NOT NULL,
  `sample` varchar(60) NOT NULL,
  `expression` double(20,14) DEFAULT NULL,
  `gene_i` mediumint(200) NOT NULL,
  `sample_i` mediumint(11) DEFAULT NULL,
  `sample_name` varchar(255) DEFAULT NULL,
  `dataset` varchar(255) DEFAULT NULL,
	`experiment_id` int(11) DEFAULT NULL,
  KEY `id` (`gene_id`),
  KEY `gene_i` (`gene_i`) USING BTREE,
  KEY `sample_i` (`sample_i`) USING BTREE,
  INDEX `experiment_id` (`experiment_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- ----------------------------
--  Table structure for `experiment`
-- ----------------------------
DROP TABLE IF EXISTS `experiment`;
CREATE TABLE `experiment` (
  `experiment_id` int(11) DEFAULT NULL,
  `experiment_name` varchar(255) DEFAULT NULL,
  `experiment_value` varchar(255) DEFAULT NULL,
  `experiment_table` varchar(255) DEFAULT NULL,
  `visibility` varchar(255) DEFAULT NULL,
  `default selection` varchar(255) DEFAULT NULL,
  `tool_category` varchar(255) DEFAULT NULL,
   INDEX `experiment_id` (`experiment_id`)	
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- ----------------------------
--  Table structure for `gene_arabidopsis`
-- ----------------------------
DROP TABLE IF EXISTS `gene_arabidopsis`;
CREATE TABLE `gene_arabidopsis` (
  `gene_id` varchar(255) NOT NULL,
  `arabidopsis_gene_id` varchar(255) DEFAULT '' NOT NULL,
  `gene_i` mediumint(20) unsigned DEFAULT 0 NOT NULL,
  PRIMARY KEY (`gene_i`,`gene_id`),
  KEY `arabidopsis_gene_id` (`arabidopsis_gene_id`),
  INDEX `gene_i` (`gene_i`),	
  INDEX `gene_id` (`gene_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- ----------------------------
--  Table structure for `gene_atg`
-- ----------------------------
DROP TABLE IF EXISTS `gene_atg`;
CREATE TABLE `gene_atg` (
  `gene_id` varchar(255) NOT NULL,
  `atg_description` varchar(1000) DEFAULT '' NOT NULL,
  `atg_id` varchar(255) DEFAULT '' NOT NULL,
  `gene_i` mediumint(20) unsigned DEFAULT 0 NOT NULL,
  PRIMARY KEY (`gene_i`,`gene_id`),
  KEY `atg_id` (`atg_id`),
  INDEX `gene_i` (`gene_i`),	
  INDEX `gene_id` (`gene_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- ----------------------------
--  Table structure for `gene_eucalyptus`
-- ----------------------------
DROP TABLE IF EXISTS `gene_eucalyptus`;
CREATE TABLE `gene_eucalyptus` (
  `gene_id` varchar(255) NOT NULL,
  `populus_gene_id` varchar(255) DEFAULT '' NOT NULL,
  `gene_i` mediumint(20) unsigned DEFAULT 0 NOT NULL,
  PRIMARY KEY (`gene_i`,`gene_id`),
  KEY `populus_gene_id` (`populus_gene_id`),
  INDEX `gene_i` (`gene_i`),	
  INDEX `gene_id` (`gene_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- ----------------------------
--  Table structure for `gene_go`
-- ----------------------------
DROP TABLE IF EXISTS `gene_go`;
CREATE TABLE `gene_go` (
  `gene_id` varchar(255) NOT NULL,
  `go_description` varchar(1000)  DEFAULT '' NOT NULL,
  `go_id` varchar(255)  DEFAULT '' NOT NULL,
  `gene_i` mediumint(20) unsigned DEFAULT 0 NOT NULL,
  PRIMARY KEY (`gene_i`,`gene_id`),
  KEY `go_id` (`go_id`),
  INDEX `gene_i` (`gene_i`),	
  INDEX `gene_id` (`gene_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- ----------------------------
--  Table structure for `gene_info`
-- ----------------------------
DROP TABLE IF EXISTS `gene_info`;
CREATE TABLE `gene_info` (
  `gene_id` varchar(60) NOT NULL,
  `chromosome_name` varchar(16) NOT NULL,
  `gene_start` int(16) unsigned NOT NULL,
  `gene_end` int(16) unsigned NOT NULL,
  `description` varchar(1000)  DEFAULT '' NOT NULL,
  `gene_i` mediumint(20) unsigned NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`gene_i`,`gene_id`),
  INDEX `gene_i` (`gene_i`),	
  INDEX `gene_id` (`gene_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;

-- ----------------------------
--  Table structure for `gene_kegg`
-- ----------------------------
DROP TABLE IF EXISTS `gene_kegg`;
CREATE TABLE `gene_kegg` (
  `gene_id` varchar(255) NOT NULL,
  `kegg_description` varchar(1000)  DEFAULT '' NOT NULL,
  `kegg_id` varchar(255)  DEFAULT '' NOT NULL,
  `gene_i` mediumint(20) unsigned DEFAULT 0 NOT NULL,
  PRIMARY KEY (`gene_i`,`gene_id`),
  KEY `kegg_id` (`kegg_id`),
  INDEX `gene_i` (`gene_i`),	
  INDEX `gene_id` (`gene_id`)		
) ENGINE=MyISAM DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- ----------------------------
--  Table structure for `gene_maize`
-- ----------------------------
DROP TABLE IF EXISTS `gene_maize`;
CREATE TABLE `gene_maize` (
  `gene_id` varchar(255) NOT NULL,
  `maize_gene_id` varchar(255)  DEFAULT '' NOT NULL,
  `gene_i` mediumint(20) unsigned DEFAULT 0 NOT NULL,
  PRIMARY KEY (`gene_i`,`gene_id`),
  KEY `maize_gene_id` (`maize_gene_id`),
  INDEX `gene_i` (`gene_i`),	
  INDEX `gene_id` (`gene_id`)	
) ENGINE=MyISAM DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- ----------------------------
--  Table structure for `gene_pfam`
-- ----------------------------
DROP TABLE IF EXISTS `gene_pfam`;
CREATE TABLE `gene_pfam` (
  `gene_id` varchar(255) NOT NULL,
  `pfam_description` varchar(1000)  DEFAULT '' NOT NULL,
  `pfam_id` varchar(255)  DEFAULT '' NOT NULL,
  `gene_i` mediumint(20) unsigned DEFAULT 0 NOT NULL,
  PRIMARY KEY (`gene_i`,`gene_id`),
  KEY `pfam_id` (`pfam_id`),
  INDEX `gene_i` (`gene_i`),	
  INDEX `gene_id` (`gene_id`)	
) ENGINE=MyISAM DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- ----------------------------
--  Table structure for `gene_populus`
-- ----------------------------
DROP TABLE IF EXISTS `gene_populus`;
CREATE TABLE `gene_populus` (
  `gene_id` varchar(255) NOT NULL,
  `populus_gene_id` varchar(255)  DEFAULT '' NOT NULL,
  `gene_i` mediumint(20) unsigned DEFAULT 0 NOT NULL,
  PRIMARY KEY (`gene_i`,`gene_id`),
  KEY `populus_gene_id` (`populus_gene_id`),
  INDEX `gene_i` (`gene_i`),	
  INDEX `gene_id` (`gene_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- ----------------------------
--  Table structure for `gene_spruce`
-- ----------------------------
DROP TABLE IF EXISTS `gene_spruce`;
CREATE TABLE `gene_spruce` (
  `gene_id` varchar(255) NOT NULL,
  `spruce_gene_id` varchar(255)  DEFAULT '' NOT NULL,
  `gene_i` mediumint(20) unsigned DEFAULT 0 NOT NULL,
  PRIMARY KEY (`gene_i`,`gene_id`),
  KEY `spruce_gene_id` (`spruce_gene_id`),
  INDEX `gene_i` (`gene_i`),	
  INDEX `gene_id` (`gene_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- ----------------------------
--  Table structure for `sequence_color`
-- ----------------------------
DROP TABLE IF EXISTS `sequence_color`;
CREATE TABLE `sequence_color` (
  `id` varchar(255) DEFAULT NULL,
  `scaffold` varchar(255) DEFAULT NULL,
  `feature` varchar(255) DEFAULT NULL,
  `start_point` varchar(255) DEFAULT NULL,
  `end_point` varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- ----------------------------
--  Table structure for `transcript_info`
-- ----------------------------
DROP TABLE IF EXISTS `transcript_info`;
CREATE TABLE `transcript_info` (
  `transcript_id` varchar(255) NOT NULL DEFAULT '',
  `gene_id` varchar(255) NOT NULL,
  `description` varchar(1000) DEFAULT '',
  `chromosome_name` varchar(16) NOT NULL,
  `strand` varchar(2) NOT NULL,
  `gene_start` int(16) unsigned NOT NULL,
  `gene_end` int(16) unsigned NOT NULL,
  `pac_id` varchar(20) DEFAULT NULL,
  `peptide_name` varchar(50) DEFAULT NULL,
  `transcript_start` int(16) unsigned NOT NULL,
  `transcript_end` int(16) unsigned NOT NULL,
  `transcript_i` mediumint(20) unsigned NOT NULL AUTO_INCREMENT,
  `gene_i` mediumint(20) unsigned DEFAULT 0 NOT NULL ,
  PRIMARY KEY (`transcript_i`,`transcript_id`),
  INDEX `gene_i` (`gene_i`),	
  INDEX `gene_id` (`gene_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC AUTO_INCREMENT=1;

-- ----------------------------
--  Table structure for `transcript_potri`
-- ----------------------------
DROP TABLE IF EXISTS `transcript_potri`;
CREATE TABLE `transcript_potri` (
  `transcript_id` varchar(255)  DEFAULT '' NOT NULL,
  `potri_id` varchar(255)  DEFAULT '' NOT NULL,
  `transcript_i` mediumint(20) unsigned DEFAULT 0 NOT NULL,
  PRIMARY KEY (`transcript_i`,`transcript_id`),
  KEY `potri_id` (`potri_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;

-- ----------------------------
--  Table structure for `transcript_atg`
-- ----------------------------
DROP TABLE IF EXISTS `transcript_atg`;
CREATE TABLE `transcript_atg` (
  `transcript_id` varchar(255) NOT NULL,
  `atg_id` varchar(255)  DEFAULT '' NOT NULL,
  `transcript_i` mediumint(20) unsigned DEFAULT 0 NOT NULL,
  `description` varchar(1000)  DEFAULT '' NOT NULL,
  PRIMARY KEY (`transcript_i`,`transcript_id`),
  KEY `atg_id` (`atg_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;

-- ----------------------------
--  Table structure for `genebaskets`
-- ----------------------------
DROP TABLE IF EXISTS `genebaskets`;
CREATE TABLE `genebaskets` (
  `gene_basket_id` int(10) NOT NULL AUTO_INCREMENT,
  `gene_basket_name` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `harga` bigint(16) NOT NULL,
  `genelist` mediumtext COLLATE latin1_general_ci,
  `ip` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `time` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`gene_basket_id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- ----------------------------
--  Table structure for `share_table`
-- ----------------------------
DROP TABLE IF EXISTS `share_table`;
CREATE TABLE `share_table` (
  `gene_basket_id` int(10) NOT NULL AUTO_INCREMENT,
  `gene_basket_name` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `harga` bigint(16) NOT NULL,
  `genelist` mediumtext COLLATE latin1_general_ci, 
  `ip` varchar(255) COLLATE latin1_general_ci DEFAULT NULL,
  `time` timestamp NULL DEFAULT NULL, 
  `randid` varchar(255) COLLATE latin1_general_ci DEFAULT NULL,
  PRIMARY KEY (`gene_basket_id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- ---------------------------- 
--  Table structure for `defaultgenebaskets`
-- ----------------------------
DROP TABLE IF EXISTS `defaultgenebaskets`;
CREATE TABLE `defaultgenebaskets` (
  `gene_basket_id` int(10) NOT NULL,
  `ip` varchar(255) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `time` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`gene_basket_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

SET FOREIGN_KEY_CHECKS = 1;
