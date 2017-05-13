SET NAMES utf8;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
--  Table structure for `transcript_potri`
-- ----------------------------
DROP TABLE IF EXISTS `transcript_eucgr`;
CREATE TABLE `transcript_eucgr` (
  `transcript_id` varchar(255) NOT NULL,
  `potri_id` varchar(24) NOT NULL,
  `transcript_i` mediumint(11) unsigned NOT NULL,
  PRIMARY KEY (`transcript_i`,`transcript_id`),
  KEY `transcript_id` (`transcript_id`),
  KEY `potri_id` (`potri_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

SET FOREIGN_KEY_CHECKS = 1;
