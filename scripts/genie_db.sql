/*
 Target Server Type    : MySQL
 Target Server Version : 50717
 File Encoding         : utf-8

 Date: 02/27/2017 05:58:31 AM
*/

SET NAMES utf8;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
--  Table structure for `correlation_datasetX_clr`
-- ----------------------------
DROP TABLE IF EXISTS `correlation_datasetX_clr`;
CREATE TABLE `correlation_datasetX_clr` (
  `gene_i1` int(11) unsigned NOT NULL,
  `gene_i2` int(11) unsigned NOT NULL,
  `corr1` float DEFAULT NULL,
  PRIMARY KEY (`gene_i1`,`gene_i2`),
  KEY `gene_i2` (`gene_i2`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- ----------------------------
--  Table structure for `correlation_datasetX_pear`
-- ----------------------------
DROP TABLE IF EXISTS `correlation_datasetX_pear`;
CREATE TABLE `correlation_datasetX_pear` (
  `gene_i1` int(11) unsigned NOT NULL,
  `gene_i2` int(11) unsigned NOT NULL,
  `corr1` float DEFAULT NULL,
  PRIMARY KEY (`gene_i1`,`gene_i2`),
  KEY `gene_i2` (`gene_i2`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- ----------------------------
--  Table structure for `defaultgenebaskets`
-- ----------------------------
DROP TABLE IF EXISTS `defaultgenebaskets`;
CREATE TABLE `defaultgenebaskets` (
  `gene_basket_id` int(10) NOT NULL,
  `ip` varchar(255) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `time` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`gene_basket_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;

-- ----------------------------
--  Table structure for `experiment_datasetX`
-- ----------------------------
DROP TABLE IF EXISTS `experiment_datasetX`;
CREATE TABLE `experiment_datasetX` (
  `exp_i` int(11) NOT NULL AUTO_INCREMENT,
  `exp_id` varchar(60) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `pubmed_id` varchar(255) DEFAULT '',
  `web_link` varchar(255) DEFAULT NULL,
  `summary` text,
  `sample_ids` text,
  `contributors` text,
  `contact` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`exp_i`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- ----------------------------
--  Table structure for `expression_datasetX`
-- ----------------------------
DROP TABLE IF EXISTS `expression_datasetX`;
CREATE TABLE `expression_datasetX` (
  `sample_i` int(11) NOT NULL,
  `expression` float DEFAULT NULL,
  `gene_i` int(11) unsigned NOT NULL,
  PRIMARY KEY (`sample_i`,`gene_i`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- ----------------------------
--  Table structure for `gene_go`
-- ----------------------------
DROP TABLE IF EXISTS `gene_go`;
CREATE TABLE `gene_go` (
  `go_i` int(11) NOT NULL,
  `gene_i` int(11) unsigned NOT NULL,
  PRIMARY KEY (`go_i`,`gene_i`),
  KEY `gene_i` (`gene_i`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- ----------------------------
--  Table structure for `gene_info`
-- ----------------------------
DROP TABLE IF EXISTS `gene_info`;
CREATE TABLE `gene_info` (
  `gene_i` int(11) unsigned NOT NULL,
  `gene_id` varchar(60) CHARACTER SET utf8 DEFAULT '',
  `description` varchar(255) NOT NULL DEFAULT '""',
  `synonyms` varchar(255) NOT NULL DEFAULT '',
  `has_exp` tinyint(1) NOT NULL DEFAULT '0',
  `cluster` varchar(1) NOT NULL DEFAULT '',
  `at_desc` varchar(255) DEFAULT '',
  `at_ortholog` varchar(15) DEFAULT '',
  `at_syn` varchar(255) DEFAULT '',
  `degree` smallint(5) DEFAULT '0',
  `btw_rank` smallint(5) DEFAULT '0',
  `close_rank` smallint(5) DEFAULT '0',
  `avg_neigh_deg` float DEFAULT '0',
  PRIMARY KEY (`gene_i`),
  KEY `gene_id` (`gene_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- ----------------------------
--  Table structure for `go_info`
-- ----------------------------
DROP TABLE IF EXISTS `go_info`;
CREATE TABLE `go_info` (
  `go_i` int(11) NOT NULL AUTO_INCREMENT,
  `go_id` varchar(255) DEFAULT NULL,
  `name_space` varchar(255) DEFAULT 'unknown',
  `description` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`go_i`)
) ENGINE=MyISAM AUTO_INCREMENT=41439 DEFAULT CHARSET=latin1;

-- ----------------------------
--  Table structure for `go_relation`
-- ----------------------------
DROP TABLE IF EXISTS `go_relation`;
CREATE TABLE `go_relation` (
  `go_c` int(11) NOT NULL,
  `go_p` int(11) NOT NULL,
  PRIMARY KEY (`go_c`,`go_p`),
  KEY `go_p` (`go_p`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- ----------------------------
--  Table structure for `pfam_table`
-- ----------------------------
DROP TABLE IF EXISTS `pfam_table`;
CREATE TABLE `pfam_table` (
  `gene_i` int(11) unsigned DEFAULT NULL,
  `pfam_i` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `pfam_id` varchar(20) DEFAULT NULL,
  `description` varchar(500) DEFAULT NULL,
  PRIMARY KEY (`pfam_i`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- ----------------------------
--  Table structure for `sample_datasetX`
-- ----------------------------
DROP TABLE IF EXISTS `sample_datasetX`;
CREATE TABLE `sample_datasetX` (
  `sample_i` bigint(20) NOT NULL,
  `sample_id` varchar(45) NOT NULL,
  `exp_i` int(11) DEFAULT NULL,
  `title` varchar(500) NOT NULL DEFAULT '',
  `last_update` varchar(45) NOT NULL DEFAULT '',
  `type` varchar(200) NOT NULL DEFAULT '',
  `source_name` varchar(200) DEFAULT NULL,
  `organism` varchar(200) DEFAULT '',
  `characteristics` varchar(500) DEFAULT NULL,
  `treatment_protocol` text,
  `growth_protocol` text,
  `molecule` varchar(200) DEFAULT NULL,
  `extract_protocol` text,
  `lable` varchar(200) DEFAULT NULL,
  `lable_protocol` text,
  `hyb_protocol` text,
  `description` text,
  `contact` varchar(500) DEFAULT NULL,
  `supplementary_file` text,
  `exp_id` varchar(200) DEFAULT '',
  PRIMARY KEY (`sample_id`,`title`,`last_update`,`type`),
  KEY `fk_Sample_PO1` (`last_update`),
  KEY `fk_Sample_ENVO1` (`type`),
  KEY `fk_Sample_Experiment1` (`title`),
  KEY `exp_i` (`exp_i`),
  KEY `sample_i` (`sample_i`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

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
) ENGINE=MyISAM DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;

-- ----------------------------
--  Table structure for `share_table`
-- ----------------------------
DROP TABLE IF EXISTS `share_table`;
CREATE TABLE `share_table` (
  `gene_basket_id` int(10) NOT NULL AUTO_INCREMENT,
  `gene_basket_name` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `harga` int(11) NOT NULL,
  `genelist` mediumtext COLLATE latin1_general_ci,
  `ip` varchar(255) COLLATE latin1_general_ci DEFAULT NULL,
  `time` timestamp NULL DEFAULT NULL,
  `randid` varchar(255) COLLATE latin1_general_ci DEFAULT NULL,
  PRIMARY KEY (`gene_basket_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci ROW_FORMAT=DYNAMIC;

-- ----------------------------
--  Table structure for `tf`
-- ----------------------------
DROP TABLE IF EXISTS `tf`;
CREATE TABLE `tf` (
  `TF_family_i` int(11) NOT NULL,
  `gene_i` int(11) unsigned NOT NULL,
  `transcript_i` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`TF_family_i`,`gene_i`),
  KEY `fk_TF_GeneTable1` (`gene_i`),
  KEY `transcript_i` (`transcript_i`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- ----------------------------
--  Table structure for `tf_family`
-- ----------------------------
DROP TABLE IF EXISTS `tf_family`;
CREATE TABLE `tf_family` (
  `tf_family_i` int(11) NOT NULL,
  `tf_family_id` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`tf_family_i`),
  KEY `transcript_i` (`tf_family_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- ----------------------------
--  Table structure for `tf_set`
-- ----------------------------
DROP TABLE IF EXISTS `tf_set`;
CREATE TABLE `tf_set` (
  `TF_dbi` int(11) NOT NULL AUTO_INCREMENT,
  `TF_desciption` varchar(255) DEFAULT NULL,
  `TF_link` varchar(60) DEFAULT NULL,
  `TF_family_i` int(11) NOT NULL,
  PRIMARY KEY (`TF_dbi`),
  KEY `fk_TF_set_TF1` (`TF_dbi`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- ----------------------------
--  Table structure for `transcript_atg`
-- ----------------------------
DROP TABLE IF EXISTS `transcript_atg`;
CREATE TABLE `transcript_atg` (
  `transcript_id` int(11) unsigned NOT NULL,
  `atg_id` varchar(24) NOT NULL,
  `transcript_i` int(11) unsigned NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`transcript_i`,`transcript_id`),
  KEY `transcript_id` (`transcript_id`),
  KEY `atg_id` (`atg_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;

-- ----------------------------
--  Table structure for `transcript_info`
-- ----------------------------
DROP TABLE IF EXISTS `transcript_info`;
CREATE TABLE `transcript_info` (
  `transcript_id` varchar(60) NOT NULL DEFAULT '',
  `gene_id` varchar(60) NOT NULL DEFAULT '',
  `description` varchar(255) DEFAULT '',
  `chromosome_name` varchar(16) NOT NULL,
  `strand` varchar(2) NOT NULL,
  `gene_start` int(11) unsigned NOT NULL,
  `gene_end` int(11) unsigned NOT NULL,
  `pac_id` varchar(20) DEFAULT NULL,
  `peptide_name` varchar(50) DEFAULT NULL,
  `transcript_start` int(16) unsigned NOT NULL,
  `transcript_end` int(16) unsigned NOT NULL,
  `transcript_i` mediumint(11) unsigned NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`transcript_i`,`transcript_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;

SET FOREIGN_KEY_CHECKS = 1;
