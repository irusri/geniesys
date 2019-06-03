-- MySQL dump 10.13  Distrib 5.7.25, for Linux (x86_64)
--
-- Host: crick.upsc.se    Database: 5cf34f5a56ccc
-- ------------------------------------------------------
-- Server version	5.7.25-0ubuntu0.18.04.2

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `correlation_expatlas_clr`
--

DROP TABLE IF EXISTS `correlation_expatlas_clr`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `correlation_expatlas_clr` (
  `edg_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `gene_i1` int(11) NOT NULL,
  `gene_i2` int(11) NOT NULL,
  `corr1` double(16,10) DEFAULT NULL,
  PRIMARY KEY (`edg_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `correlation_expatlas_clr`
--

LOCK TABLES `correlation_expatlas_clr` WRITE;
/*!40000 ALTER TABLE `correlation_expatlas_clr` DISABLE KEYS */;
/*!40000 ALTER TABLE `correlation_expatlas_clr` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `defaultgenebaskets`
--

DROP TABLE IF EXISTS `defaultgenebaskets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `defaultgenebaskets` (
  `gene_basket_id` int(10) NOT NULL,
  `ip` varchar(255) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `time` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`gene_basket_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `defaultgenebaskets`
--

LOCK TABLES `defaultgenebaskets` WRITE;
/*!40000 ALTER TABLE `defaultgenebaskets` DISABLE KEYS */;
/*!40000 ALTER TABLE `defaultgenebaskets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `expression_exatlas_tissue_tpm`
--

DROP TABLE IF EXISTS `expression_exatlas_tissue_tpm`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `expression_exatlas_tissue_tpm` (
  `id` varchar(60) NOT NULL,
  `sample` varchar(60) NOT NULL,
  `log2` double(20,14) DEFAULT NULL,
  `gene_i` mediumint(20) unsigned DEFAULT '0',
  `sample_i` mediumint(20) unsigned DEFAULT '0',
  KEY `id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `expression_exatlas_tissue_tpm`
--

LOCK TABLES `expression_exatlas_tissue_tpm` WRITE;
/*!40000 ALTER TABLE `expression_exatlas_tissue_tpm` DISABLE KEYS */;
/*!40000 ALTER TABLE `expression_exatlas_tissue_tpm` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `gene_arabidopsis`
--

DROP TABLE IF EXISTS `gene_arabidopsis`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `gene_arabidopsis` (
  `gene_id` varchar(255) NOT NULL,
  `arabidopsis_gene_id` varchar(255) NOT NULL DEFAULT '',
  `gene_i` mediumint(20) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`gene_i`,`gene_id`),
  KEY `arabidopsis_gene_id` (`arabidopsis_gene_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `gene_arabidopsis`
--

LOCK TABLES `gene_arabidopsis` WRITE;
/*!40000 ALTER TABLE `gene_arabidopsis` DISABLE KEYS */;
/*!40000 ALTER TABLE `gene_arabidopsis` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `gene_atg`
--

DROP TABLE IF EXISTS `gene_atg`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `gene_atg` (
  `gene_id` varchar(255) NOT NULL,
  `atg_description` varchar(1000) NOT NULL DEFAULT '',
  `atg_id` varchar(255) NOT NULL DEFAULT '',
  `gene_i` mediumint(20) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`gene_i`,`gene_id`),
  KEY `atg_id` (`atg_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `gene_atg`
--

LOCK TABLES `gene_atg` WRITE;
/*!40000 ALTER TABLE `gene_atg` DISABLE KEYS */;
/*!40000 ALTER TABLE `gene_atg` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `gene_eucalyptus`
--

DROP TABLE IF EXISTS `gene_eucalyptus`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `gene_eucalyptus` (
  `gene_id` varchar(255) NOT NULL,
  `populus_gene_id` varchar(255) NOT NULL DEFAULT '',
  `gene_i` mediumint(20) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`gene_i`,`gene_id`),
  KEY `populus_gene_id` (`populus_gene_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `gene_eucalyptus`
--

LOCK TABLES `gene_eucalyptus` WRITE;
/*!40000 ALTER TABLE `gene_eucalyptus` DISABLE KEYS */;
/*!40000 ALTER TABLE `gene_eucalyptus` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `gene_go`
--

DROP TABLE IF EXISTS `gene_go`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `gene_go` (
  `gene_id` varchar(255) NOT NULL,
  `go_description` varchar(1000) NOT NULL DEFAULT '',
  `go_id` varchar(255) NOT NULL DEFAULT '',
  `gene_i` mediumint(20) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`gene_i`,`gene_id`),
  KEY `go_id` (`go_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `gene_go`
--

LOCK TABLES `gene_go` WRITE;
/*!40000 ALTER TABLE `gene_go` DISABLE KEYS */;
/*!40000 ALTER TABLE `gene_go` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `gene_info`
--

DROP TABLE IF EXISTS `gene_info`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `gene_info` (
  `gene_id` varchar(60) NOT NULL,
  `chromosome_name` varchar(16) NOT NULL,
  `gene_start` int(16) unsigned NOT NULL,
  `gene_end` int(16) unsigned NOT NULL,
  `description` varchar(1000) NOT NULL DEFAULT '',
  `gene_i` mediumint(20) unsigned NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`gene_i`,`gene_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `gene_info`
--

LOCK TABLES `gene_info` WRITE;
/*!40000 ALTER TABLE `gene_info` DISABLE KEYS */;
INSERT INTO `gene_info` VALUES ('Query ERROR: caught BioMart::Exception::Usage: WITHIN Virtua','',0,0,'',1);
/*!40000 ALTER TABLE `gene_info` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `gene_kegg`
--

DROP TABLE IF EXISTS `gene_kegg`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `gene_kegg` (
  `gene_id` varchar(255) NOT NULL,
  `kegg_description` varchar(1000) NOT NULL DEFAULT '',
  `kegg_id` varchar(255) NOT NULL DEFAULT '',
  `gene_i` mediumint(20) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`gene_i`,`gene_id`),
  KEY `kegg_id` (`kegg_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `gene_kegg`
--

LOCK TABLES `gene_kegg` WRITE;
/*!40000 ALTER TABLE `gene_kegg` DISABLE KEYS */;
INSERT INTO `gene_kegg` VALUES ('Query ERROR: caught BioMart::Exception::Usage: WITHIN Virtual Schema : zome_mart, Dataset notfound NOT FOUND','','',0);
/*!40000 ALTER TABLE `gene_kegg` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `gene_maize`
--

DROP TABLE IF EXISTS `gene_maize`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `gene_maize` (
  `gene_id` varchar(255) NOT NULL,
  `maize_gene_id` varchar(255) NOT NULL DEFAULT '',
  `gene_i` mediumint(20) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`gene_i`,`gene_id`),
  KEY `maize_gene_id` (`maize_gene_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `gene_maize`
--

LOCK TABLES `gene_maize` WRITE;
/*!40000 ALTER TABLE `gene_maize` DISABLE KEYS */;
/*!40000 ALTER TABLE `gene_maize` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `gene_pfam`
--

DROP TABLE IF EXISTS `gene_pfam`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `gene_pfam` (
  `gene_id` varchar(255) NOT NULL,
  `pfam_description` varchar(1000) NOT NULL DEFAULT '',
  `pfam_id` varchar(255) NOT NULL DEFAULT '',
  `gene_i` mediumint(20) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`gene_i`,`gene_id`),
  KEY `pfam_id` (`pfam_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `gene_pfam`
--

LOCK TABLES `gene_pfam` WRITE;
/*!40000 ALTER TABLE `gene_pfam` DISABLE KEYS */;
INSERT INTO `gene_pfam` VALUES ('Query ERROR: caught BioMart::Exception::Usage: WITHIN Virtual Schema : zome_mart, Dataset notfound NOT FOUND','','',0);
/*!40000 ALTER TABLE `gene_pfam` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `gene_populus`
--

DROP TABLE IF EXISTS `gene_populus`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `gene_populus` (
  `gene_id` varchar(255) NOT NULL,
  `populus_gene_id` varchar(255) NOT NULL DEFAULT '',
  `gene_i` mediumint(20) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`gene_i`,`gene_id`),
  KEY `populus_gene_id` (`populus_gene_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `gene_populus`
--

LOCK TABLES `gene_populus` WRITE;
/*!40000 ALTER TABLE `gene_populus` DISABLE KEYS */;
/*!40000 ALTER TABLE `gene_populus` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `gene_spruce`
--

DROP TABLE IF EXISTS `gene_spruce`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `gene_spruce` (
  `gene_id` varchar(255) NOT NULL,
  `spruce_gene_id` varchar(255) NOT NULL DEFAULT '',
  `gene_i` mediumint(20) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`gene_i`,`gene_id`),
  KEY `spruce_gene_id` (`spruce_gene_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `gene_spruce`
--

LOCK TABLES `gene_spruce` WRITE;
/*!40000 ALTER TABLE `gene_spruce` DISABLE KEYS */;
/*!40000 ALTER TABLE `gene_spruce` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `genebaskets`
--

DROP TABLE IF EXISTS `genebaskets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `genebaskets` (
  `gene_basket_id` int(10) NOT NULL AUTO_INCREMENT,
  `gene_basket_name` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `harga` bigint(16) NOT NULL,
  `genelist` mediumtext COLLATE latin1_general_ci,
  `ip` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `time` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`gene_basket_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `genebaskets`
--

LOCK TABLES `genebaskets` WRITE;
/*!40000 ALTER TABLE `genebaskets` DISABLE KEYS */;
/*!40000 ALTER TABLE `genebaskets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sequence_color`
--

DROP TABLE IF EXISTS `sequence_color`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sequence_color` (
  `id` varchar(255) DEFAULT NULL,
  `scaffold` varchar(255) DEFAULT NULL,
  `feature` varchar(255) DEFAULT NULL,
  `start_point` varchar(255) DEFAULT NULL,
  `end_point` varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sequence_color`
--

LOCK TABLES `sequence_color` WRITE;
/*!40000 ALTER TABLE `sequence_color` DISABLE KEYS */;
/*!40000 ALTER TABLE `sequence_color` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `share_table`
--

DROP TABLE IF EXISTS `share_table`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `share_table` (
  `gene_basket_id` int(10) NOT NULL AUTO_INCREMENT,
  `gene_basket_name` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `harga` bigint(16) NOT NULL,
  `genelist` mediumtext COLLATE latin1_general_ci,
  `ip` varchar(255) COLLATE latin1_general_ci DEFAULT NULL,
  `time` timestamp NULL DEFAULT NULL,
  `randid` varchar(255) COLLATE latin1_general_ci DEFAULT NULL,
  PRIMARY KEY (`gene_basket_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `share_table`
--

LOCK TABLES `share_table` WRITE;
/*!40000 ALTER TABLE `share_table` DISABLE KEYS */;
/*!40000 ALTER TABLE `share_table` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `transcript_atg`
--

DROP TABLE IF EXISTS `transcript_atg`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `transcript_atg` (
  `transcript_id` varchar(255) NOT NULL,
  `atg_id` varchar(255) NOT NULL DEFAULT '',
  `transcript_i` mediumint(20) unsigned NOT NULL DEFAULT '0',
  `description` varchar(1000) NOT NULL DEFAULT '',
  PRIMARY KEY (`transcript_i`,`transcript_id`),
  KEY `atg_id` (`atg_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `transcript_atg`
--

LOCK TABLES `transcript_atg` WRITE;
/*!40000 ALTER TABLE `transcript_atg` DISABLE KEYS */;
/*!40000 ALTER TABLE `transcript_atg` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `transcript_info`
--

DROP TABLE IF EXISTS `transcript_info`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
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
  `gene_i` mediumint(20) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`transcript_i`,`transcript_id`),
  KEY `gene_i` (`gene_i`),
  KEY `gene_id` (`gene_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `transcript_info`
--

LOCK TABLES `transcript_info` WRITE;
/*!40000 ALTER TABLE `transcript_info` DISABLE KEYS */;
INSERT INTO `transcript_info` VALUES ('Query ERROR: caught BioMart::Exception::Usage: WITHIN Virtual Schema : zome_mart, Dataset notfound NOT FOUND','','','','',0,0,NULL,NULL,0,0,1,1);
/*!40000 ALTER TABLE `transcript_info` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `transcript_potri`
--

DROP TABLE IF EXISTS `transcript_potri`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `transcript_potri` (
  `transcript_id` varchar(255) NOT NULL DEFAULT '',
  `potri_id` varchar(255) NOT NULL DEFAULT '',
  `transcript_i` mediumint(20) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`transcript_i`,`transcript_id`),
  KEY `potri_id` (`potri_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `transcript_potri`
--

LOCK TABLES `transcript_potri` WRITE;
/*!40000 ALTER TABLE `transcript_potri` DISABLE KEYS */;
/*!40000 ALTER TABLE `transcript_potri` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2019-06-02  6:24:47
