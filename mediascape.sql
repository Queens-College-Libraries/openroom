-- MySQL dump 10.13  Distrib 5.7.23, for Linux (x86_64)
--
-- Host: localhost    Database: mediascape
-- ------------------------------------------------------
-- Server version	5.7.23-0ubuntu0.18.04.1

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
-- Table structure for table `administrators`
--

DROP TABLE IF EXISTS `administrators`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `administrators` (
  `username` varchar(255) NOT NULL,
  PRIMARY KEY (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `administrators`
--

LOCK TABLES `administrators` WRITE;
/*!40000 ALTER TABLE `administrators` DISABLE KEYS */;
INSERT INTO `administrators` VALUES ('admin'),('dwilliams1'),('ewall'),('khada');
/*!40000 ALTER TABLE `administrators` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `bannedusers`
--

DROP TABLE IF EXISTS `bannedusers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bannedusers` (
  `username` varchar(255) NOT NULL,
  PRIMARY KEY (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bannedusers`
--

LOCK TABLES `bannedusers` WRITE;
/*!40000 ALTER TABLE `bannedusers` DISABLE KEYS */;
INSERT INTO `bannedusers` VALUES ('banned');
/*!40000 ALTER TABLE `bannedusers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cancelled`
--

DROP TABLE IF EXISTS `cancelled`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cancelled` (
  `reservationid` bigint(20) NOT NULL,
  `start` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `end` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `roomid` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `timeofrequest` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `timeofcancel` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`reservationid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cancelled`
--

LOCK TABLES `cancelled` WRITE;
/*!40000 ALTER TABLE `cancelled` DISABLE KEYS */;
INSERT INTO `cancelled` VALUES (90,'2017-08-20 19:00:00','2017-08-20 19:29:59',28,'khada100','2017-08-19 23:15:04','2017-08-19 23:16:40'),(94,'2017-08-23 16:00:00','2017-08-23 17:29:59',29,'ttam','2017-08-23 14:52:42','2017-08-23 14:53:11'),(95,'2017-08-23 20:30:00','2017-08-23 20:59:59',28,'khada100','2017-08-23 16:13:40','2017-08-23 16:14:00'),(96,'2017-08-23 20:30:00','2017-08-23 21:29:59',29,'khada100','2017-08-23 16:48:51','2017-08-23 19:38:04'),(97,'2017-08-23 21:00:00','2017-08-23 21:29:59',28,'khada100','2017-08-23 19:40:07','2017-08-23 19:40:26'),(98,'2017-09-20 21:30:00','2017-09-20 21:59:59',28,'jmellone','2017-09-07 17:07:03','2017-09-07 17:07:38'),(99,'2017-09-11 16:00:00','2017-09-11 17:29:59',28,'dwilliams1','2017-09-11 20:01:20','2017-09-11 20:01:52'),(100,'2017-09-11 15:30:00','2017-09-11 15:59:59',28,'khada100','2017-09-11 20:04:55','2017-09-11 20:05:56'),(106,'2017-11-22 21:30:00','2017-11-22 21:59:59',29,'joates','2017-09-22 19:02:57','2017-11-15 21:49:20'),(107,'2017-11-29 21:30:00','2017-11-29 21:59:59',29,'joates','2017-09-22 19:02:57','2017-11-15 21:50:42'),(111,'2017-10-10 17:30:00','2017-10-10 18:59:59',28,'MUS 373','2017-09-22 19:03:49','2017-10-10 15:00:48'),(112,'2017-10-17 17:30:00','2017-10-17 18:59:59',28,'MUS 373','2017-09-22 19:03:50','2017-10-10 15:01:33'),(113,'2017-10-24 17:30:00','2017-10-24 18:59:59',28,'MUS 373','2017-09-22 19:03:51','2017-10-10 15:01:39'),(114,'2017-10-31 17:30:00','2017-10-31 18:59:59',28,'MUS 373','2017-09-22 19:03:52','2017-10-10 15:01:43'),(115,'2017-11-07 18:30:00','2017-11-07 19:59:59',28,'MUS 373','2017-09-22 19:03:53','2017-10-10 15:01:49'),(116,'2017-11-14 18:30:00','2017-11-14 19:59:59',28,'MUS 373','2017-09-22 19:03:53','2017-10-10 15:01:54'),(117,'2017-11-21 18:30:00','2017-11-21 19:59:59',28,'MUS 373','2017-09-22 19:03:54','2017-10-10 15:01:59'),(118,'2017-11-28 18:30:00','2017-11-28 19:59:59',28,'MUS 373','2017-09-22 19:03:55','2017-10-10 15:02:02'),(119,'2017-12-05 18:30:00','2017-12-05 19:59:59',28,'MUS 373','2017-09-22 19:03:55','2017-10-10 15:02:08'),(120,'2017-12-12 18:30:00','2017-12-12 19:59:59',28,'MUS 373','2017-09-22 19:03:56','2017-10-10 15:02:13'),(121,'2017-10-02 17:00:00','2017-10-02 17:59:59',28,'ewall','2017-09-25 20:49:26','2017-09-25 20:50:21'),(124,'2017-10-10 17:30:00','2017-10-10 19:29:59',29,'joates','2017-10-10 14:59:15','2017-10-10 15:00:43'),(156,'2017-11-21 16:30:00','2017-11-21 17:59:59',29,'jnichols','2017-10-24 19:45:41','2017-11-15 15:04:20'),(157,'2017-11-28 16:30:00','2017-11-28 17:59:59',29,'jnichols','2017-10-24 19:45:42','2017-11-15 15:04:28'),(158,'2017-12-05 16:30:00','2017-12-05 17:59:59',29,'jnichols','2017-10-24 19:45:42','2017-11-15 15:04:35'),(159,'2017-12-12 16:30:00','2017-12-12 17:59:59',29,'jnichols','2017-10-24 19:45:43','2017-11-15 15:04:41'),(160,'2017-12-19 16:30:00','2017-12-19 17:59:59',29,'jnichols','2017-10-24 19:45:44','2017-11-15 15:04:46'),(172,'2017-11-08 17:30:00','2017-11-08 21:29:59',28,'rramirez107','2017-10-30 03:43:42','2017-11-08 03:25:59'),(173,'2017-10-30 20:30:00','2017-10-30 21:59:59',28,'OFRIEDMAN101','2017-10-30 20:16:02','2017-10-30 20:16:19'),(192,'2017-12-20 17:30:00','2017-12-20 21:29:59',28,'rramirez107','2017-11-08 03:29:37','2017-12-18 00:53:35'),(193,'2017-12-18 17:30:00','2017-12-18 21:29:59',28,'rramirez107','2017-11-08 03:29:44','2017-12-18 00:52:39'),(194,'2017-11-14 20:30:00','2017-11-14 21:29:59',28,'ttam','2017-11-09 17:38:17','2017-11-09 17:38:29'),(196,'2017-11-10 16:30:00','2017-11-10 17:59:59',28,'pchua100','2017-11-10 16:11:33','2017-11-10 16:11:52'),(200,'2017-11-21 15:00:00','2017-11-21 18:29:59',28,'OFRIEDMAN101','2017-11-13 00:37:17','2017-11-21 17:21:44'),(201,'2017-11-13 16:00:00','2017-11-13 19:59:59',29,'CDORTA100','2017-11-13 15:20:31','2017-11-13 15:21:05'),(203,'2017-11-15 21:30:00','2017-11-15 21:59:59',28,'usharma','2017-11-15 16:46:04','2017-11-15 16:46:14'),(204,'2017-11-22 17:00:00','2017-11-22 18:29:59',29,'Mikiko Iwasaki','2017-11-15 21:49:04','2017-11-16 20:38:28'),(213,'2017-11-27 19:30:00','2017-11-27 22:29:59',29,'mkhurana100','2017-11-27 19:07:22','2017-11-27 19:09:04'),(214,'2017-11-29 15:00:00','2017-11-29 18:59:59',29,'mkhurana100','2017-11-27 19:08:02','2017-11-29 15:33:05'),(221,'2017-12-12 19:00:00','2017-12-12 21:29:59',28,'kdaniliuk100','2017-12-12 18:50:13','2017-12-12 18:50:26'),(225,'2017-12-20 16:30:00','2017-12-20 20:29:59',28,'rramirez107','2017-12-20 03:37:03','2017-12-20 03:37:13'),(226,'2017-12-20 17:00:00','2017-12-20 20:59:59',28,'rramirez107','2017-12-20 03:37:18','2017-12-20 04:31:14'),(228,'2018-02-05 17:30:00','2018-02-05 18:59:59',28,'ttam','2018-02-05 16:38:42','2018-02-05 16:39:17'),(229,'2018-02-05 17:30:00','2018-02-05 18:59:59',29,'ttam','2018-02-05 16:39:09','2018-02-05 16:39:38'),(230,'2018-02-13 17:00:00','2018-02-13 17:29:59',28,'dheppard100','2018-02-13 15:18:06','2018-02-13 15:18:11'),(235,'2018-02-20 16:00:00','2018-02-20 19:59:59',29,'rramirez107','2018-02-20 13:06:23','2018-02-20 13:09:36'),(236,'2018-02-21 16:00:00','2018-02-21 19:59:59',28,'rramirez107','2018-02-20 13:06:59','2018-02-20 13:09:01'),(239,'2018-02-20 19:00:00','2018-02-20 21:59:59',28,'Ahuang113','2018-02-20 15:37:39','2018-02-20 15:38:35'),(246,'2018-03-01 15:00:00','2018-03-01 18:59:59',28,'rramirez107','2018-03-01 13:02:42','2018-03-01 13:02:55'),(247,'2018-03-01 16:00:00','2018-03-01 19:59:59',28,'rramirez107','2018-03-01 13:03:00','2018-03-01 14:46:55'),(248,'2018-03-01 15:30:00','2018-03-01 19:29:59',28,'rramirez107','2018-03-01 14:47:02','2018-03-01 14:48:09'),(250,'2018-03-06 15:30:00','2018-03-06 19:29:59',28,'rramirez107','2018-03-05 13:04:38','2018-03-05 13:04:56'),(251,'2018-03-06 15:00:00','2018-03-06 18:59:59',28,'rramirez107','2018-03-05 13:05:30','2018-03-06 13:52:05'),(253,'2018-03-13 14:00:00','2018-03-13 17:59:59',28,'rramirez107','2018-03-05 13:06:09','2018-03-13 14:54:23'),(255,'2018-03-15 14:00:00','2018-03-15 17:59:59',28,'rramirez107','2018-03-05 13:06:36','2018-03-15 03:28:16'),(263,'2018-03-12 14:00:00','2018-03-12 17:59:59',28,'rramirez107','2018-03-12 12:01:20','2018-03-12 13:48:36'),(267,'2018-03-14 14:00:00','2018-03-14 17:59:59',28,'rramirez107','2018-03-13 14:54:41','2018-03-14 11:46:20'),(268,'2018-03-16 14:00:00','2018-03-16 17:59:59',28,'rramirez107','2018-03-13 14:55:01','2018-03-16 13:51:51'),(273,'2018-03-15 14:00:00','2018-03-15 17:59:59',29,'MCHOWDHURY119','2018-03-15 03:38:57','2018-03-15 13:38:07'),(275,'2018-03-19 17:30:00','2018-03-19 21:29:59',29,'MCHOWDHURY119','2018-03-19 02:13:39','2018-03-19 02:14:01'),(280,'2018-03-26 14:00:00','2018-03-26 17:59:59',28,'rramirez107','2018-03-26 01:12:23','2018-03-26 14:17:44'),(285,'2018-04-09 14:00:00','2018-04-09 17:59:59',29,'mkhurana100','2018-04-08 18:45:41','2018-04-08 18:45:49'),(287,'2018-04-09 15:30:00','2018-04-09 16:59:59',28,'kdaniliuk100','2018-04-09 13:20:39','2018-04-09 13:20:47'),(288,'2018-04-09 15:30:00','2018-04-09 17:29:59',28,'kdaniliuk100','2018-04-09 13:21:10','2018-04-09 15:40:06'),(293,'2018-04-18 15:00:00','2018-04-18 16:29:59',28,'kdaniliuk100','2018-04-18 14:40:11','2018-04-18 14:40:33'),(296,'2018-05-01 19:30:00','2018-05-01 19:59:59',29,'Exam: Y. Park','2018-04-19 15:00:32','2018-04-19 15:00:40'),(299,'2018-05-07 19:30:00','2018-05-07 20:29:59',29,'Exam: A. Ali','2018-04-19 15:01:58','2018-04-20 18:29:08'),(305,'2018-04-26 17:00:00','2018-04-26 20:59:59',28,'VBatista103','2018-04-26 16:43:51','2018-04-26 17:27:14'),(306,'2018-04-26 17:00:00','2018-04-26 17:29:59',29,'vbatista103','2018-04-26 16:49:04','2018-04-26 16:49:55'),(323,'2019-06-05 15:00:00','2019-06-05 15:29:59',28,'dwilliams1','2018-06-05 18:13:58','2018-06-05 18:14:06'),(324,'2018-08-27 19:00:00','2018-08-27 20:59:59',29,'ttam','2018-07-12 15:21:19','2018-08-22 01:10:06');
/*!40000 ALTER TABLE `cancelled` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `deletedrooms`
--

DROP TABLE IF EXISTS `deletedrooms`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `deletedrooms` (
  `roomid` int(11) NOT NULL,
  `roomname` varchar(255) NOT NULL,
  `roomcapacity` int(11) NOT NULL,
  `roomgroupid` bigint(20) NOT NULL,
  `roomdescription` longtext NOT NULL,
  PRIMARY KEY (`roomid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `deletedrooms`
--

LOCK TABLES `deletedrooms` WRITE;
/*!40000 ALTER TABLE `deletedrooms` DISABLE KEYS */;
INSERT INTO `deletedrooms` VALUES (28,'125a',8,6,'Room 125a'),(29,'125c',16,6,'Room 125c');
/*!40000 ALTER TABLE `deletedrooms` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `optionalfields`
--

DROP TABLE IF EXISTS `optionalfields`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `optionalfields` (
  `optionname` varchar(255) NOT NULL,
  `optionformname` varchar(255) NOT NULL COMMENT 'no spaces, a-z only',
  `optiontype` int(11) NOT NULL COMMENT '0 = text, 1 = select',
  `optionchoices` varchar(700) NOT NULL COMMENT '";" delimited',
  `optionorder` int(11) NOT NULL,
  `optionquestion` varchar(255) NOT NULL,
  `optionprivate` tinyint(1) NOT NULL DEFAULT '0',
  `optionrequired` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`optionname`),
  UNIQUE KEY `optionformname` (`optionformname`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `optionalfields`
--

LOCK TABLES `optionalfields` WRITE;
/*!40000 ALTER TABLE `optionalfields` DISABLE KEYS */;
/*!40000 ALTER TABLE `optionalfields` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reporters`
--

DROP TABLE IF EXISTS `reporters`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `reporters` (
  `username` varchar(255) NOT NULL,
  PRIMARY KEY (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reporters`
--

LOCK TABLES `reporters` WRITE;
/*!40000 ALTER TABLE `reporters` DISABLE KEYS */;
INSERT INTO `reporters` VALUES ('reporter');
/*!40000 ALTER TABLE `reporters` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reservationoptions`
--

DROP TABLE IF EXISTS `reservationoptions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `reservationoptions` (
  `optionname` varchar(255) NOT NULL,
  `reservationid` bigint(20) NOT NULL,
  `optionvalue` varchar(700) NOT NULL,
  PRIMARY KEY (`optionname`,`reservationid`),
  KEY `reservationid` (`reservationid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reservationoptions`
--

LOCK TABLES `reservationoptions` WRITE;
/*!40000 ALTER TABLE `reservationoptions` DISABLE KEYS */;
/*!40000 ALTER TABLE `reservationoptions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reservations`
--

DROP TABLE IF EXISTS `reservations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `reservations` (
  `reservationid` bigint(20) NOT NULL AUTO_INCREMENT,
  `start` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `end` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `roomid` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `numberingroup` int(11) NOT NULL,
  `timeofrequest` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`reservationid`)
) ENGINE=InnoDB AUTO_INCREMENT=340 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reservations`
--

LOCK TABLES `reservations` WRITE;
/*!40000 ALTER TABLE `reservations` DISABLE KEYS */;
INSERT INTO `reservations` VALUES (325,'2018-07-18 14:00:00','2018-07-18 14:29:59',28,'admin',1,'2018-07-18 19:40:30'),(326,'2018-07-18 15:00:00','2018-07-18 15:29:59',28,'admin',1,'2018-07-18 19:41:39'),(327,'2018-07-18 15:30:00','2018-07-18 15:59:59',28,'admin',1,'2018-07-18 19:42:18'),(329,'2018-07-19 01:00:00','2018-07-19 01:29:59',28,'admin',1,'2018-07-18 20:35:53'),(330,'2018-07-20 01:00:00','2018-07-20 01:29:59',28,'admin',1,'2018-07-18 20:35:53'),(331,'2018-07-21 01:00:00','2018-07-21 01:29:59',28,'admin',1,'2018-07-18 20:35:53'),(332,'2018-07-22 01:00:00','2018-07-22 01:29:59',28,'admin',1,'2018-07-18 20:35:53'),(333,'2018-07-23 01:00:00','2018-07-23 01:29:59',28,'admin',1,'2018-07-18 20:35:53'),(335,'2018-07-19 00:00:00','2018-07-19 00:29:59',28,'admin',1,'2018-07-18 20:41:15'),(336,'2018-07-20 00:00:00','2018-07-20 00:29:59',28,'admin',1,'2018-07-18 20:41:15'),(337,'2018-07-21 00:00:00','2018-07-21 00:29:59',28,'admin',1,'2018-07-18 20:41:15'),(338,'2018-07-22 00:00:00','2018-07-22 00:29:59',28,'admin',1,'2018-07-18 20:41:15'),(339,'2018-07-23 00:00:00','2018-07-23 00:29:59',28,'admin',1,'2018-07-18 20:41:15');
/*!40000 ALTER TABLE `reservations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `roomgroups`
--

DROP TABLE IF EXISTS `roomgroups`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `roomgroups` (
  `roomgroupid` bigint(20) NOT NULL AUTO_INCREMENT,
  `roomgroupname` varchar(255) NOT NULL,
  PRIMARY KEY (`roomgroupid`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roomgroups`
--

LOCK TABLES `roomgroups` WRITE;
/*!40000 ALTER TABLE `roomgroups` DISABLE KEYS */;
INSERT INTO `roomgroups` VALUES (7,'Mediascape');
/*!40000 ALTER TABLE `roomgroups` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `roomhours`
--

DROP TABLE IF EXISTS `roomhours`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `roomhours` (
  `roomhoursid` bigint(20) NOT NULL AUTO_INCREMENT,
  `roomid` int(11) NOT NULL,
  `dayofweek` smallint(6) NOT NULL,
  `start` time NOT NULL,
  `end` time NOT NULL,
  PRIMARY KEY (`roomhoursid`)
) ENGINE=InnoDB AUTO_INCREMENT=349 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roomhours`
--

LOCK TABLES `roomhours` WRITE;
/*!40000 ALTER TABLE `roomhours` DISABLE KEYS */;
INSERT INTO `roomhours` VALUES (311,28,0,'02:00:00','23:00:00'),(312,28,1,'02:00:00','23:00:00'),(313,28,2,'02:00:00','23:00:00'),(314,28,3,'02:00:00','23:00:00'),(315,28,4,'02:00:00','23:00:00'),(316,28,5,'02:00:00','23:00:00'),(317,28,6,'02:00:00','23:00:00'),(318,29,0,'02:00:00','23:00:00'),(319,29,1,'02:00:00','23:00:00'),(320,29,2,'02:00:00','23:00:00'),(321,29,3,'02:00:00','23:00:00'),(322,29,4,'02:00:00','23:00:00'),(323,29,5,'02:00:00','23:00:00'),(324,29,6,'02:00:00','23:00:00'),(325,30,1,'09:00:00','20:00:00'),(326,30,2,'09:00:00','20:00:00'),(327,30,3,'09:00:00','20:00:00'),(328,30,4,'09:00:00','20:00:00'),(330,31,1,'09:00:00','20:00:00'),(331,31,2,'09:00:00','20:00:00'),(332,31,3,'09:00:00','20:00:00'),(333,31,4,'09:00:00','20:00:00'),(335,32,1,'09:00:00','20:00:00'),(336,32,2,'09:00:00','20:00:00'),(337,32,3,'09:00:00','20:00:00'),(338,32,4,'09:00:00','20:00:00'),(340,30,5,'09:00:00','16:00:00'),(341,31,5,'09:00:00','16:00:00'),(342,32,5,'09:00:00','16:00:00'),(343,30,0,'12:00:00','16:00:00'),(344,30,6,'12:00:00','16:00:00'),(345,31,0,'12:00:00','16:00:00'),(346,31,6,'12:00:00','16:00:00'),(347,32,0,'12:00:00','16:00:00'),(348,32,6,'12:00:00','16:00:00');
/*!40000 ALTER TABLE `roomhours` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rooms`
--

DROP TABLE IF EXISTS `rooms`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rooms` (
  `roomid` int(11) NOT NULL AUTO_INCREMENT,
  `roomname` varchar(255) NOT NULL,
  `roomposition` int(11) NOT NULL,
  `roomcapacity` int(11) NOT NULL,
  `roomgroupid` bigint(20) NOT NULL,
  `roomdescription` longtext NOT NULL,
  PRIMARY KEY (`roomid`)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rooms`
--

LOCK TABLES `rooms` WRITE;
/*!40000 ALTER TABLE `rooms` DISABLE KEYS */;
INSERT INTO `rooms` VALUES (30,'1',0,6,7,'Room One'),(31,'2',1,6,7,'Room Two'),(32,'3',2,6,7,'Room Three');
/*!40000 ALTER TABLE `rooms` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `roomspecialhours`
--

DROP TABLE IF EXISTS `roomspecialhours`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `roomspecialhours` (
  `roomspecialhoursid` bigint(20) NOT NULL AUTO_INCREMENT,
  `roomid` int(11) NOT NULL,
  `fromrange` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `torange` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `start` time NOT NULL,
  `end` time NOT NULL,
  PRIMARY KEY (`roomspecialhoursid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roomspecialhours`
--

LOCK TABLES `roomspecialhours` WRITE;
/*!40000 ALTER TABLE `roomspecialhours` DISABLE KEYS */;
/*!40000 ALTER TABLE `roomspecialhours` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `settings`
--

DROP TABLE IF EXISTS `settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `settings` (
  `settingname` varchar(255) NOT NULL,
  `settingvalue` longtext NOT NULL,
  PRIMARY KEY (`settingname`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `settings`
--

LOCK TABLES `settings` WRITE;
/*!40000 ALTER TABLE `settings` DISABLE KEYS */;
INSERT INTO `settings` VALUES ('allow_past_reservations','false'),('allow_simultaneous_reservations','false'),('email_can_gef','a:1:{i:0;s:22:\"kushalpublic@gmail.com\";}'),('email_can_terse','a:1:{i:0;s:22:\"kushalpublic@gmail.com\";}'),('email_can_verbose','a:1:{i:0;s:22:\"kushalpublic@gmail.com\";}'),('email_condition',''),('email_condition_value',''),('email_cond_gef','a:1:{i:0;s:22:\"kushalpublic@gmail.com\";}'),('email_cond_terse','a:1:{i:0;s:22:\"kushalpublic@gmail.com\";}'),('email_cond_verbose','a:1:{i:0;s:22:\"kushalpublic@gmail.com\";}'),('email_filter','a:2:{i:0;s:11:\"qc.cuny.edu\";i:1;s:14:\"qmail.cuny.edu\";}'),('email_res_gef','a:1:{i:0;s:22:\"kushalpublic@gmail.com\";}'),('email_res_terse','a:1:{i:0;s:22:\"kushalpublic@gmail.com\";}'),('email_res_verbose','a:1:{i:0;s:22:\"kushalpublic@gmail.com\";}'),('email_system','kushalpublic@gmail.com'),('endtime','21'),('https','true'),('instance_name','My Openroom'),('instance_url','library-test.qc.cuny.edu/spaces/mediascape'),('interval','60'),('ldap_baseDN','ldap://149.4.100.201:3268'),('ldap_host','DC=qc,DC=ads'),('limit_duration','60'),('limit_frequency','a:2:{i:0;s:1:\"0\";i:1;s:3:\"day\";}'),('limit_openingday',''),('limit_total','a:2:{i:0;s:3:\"180\";i:1;s:3:\"day\";}'),('limit_window','a:2:{i:0;s:1:\"2\";i:1;s:5:\"month\";}'),('login_method','ldap'),('phone_number','7165015874'),('policies','Here be dragons.'),('remindermessage','Thank you for helping test openroom. Please report all bugs to Kushal.'),('service_password','Nicaragua1942!'),('service_username','library2sa'),('starttime','7'),('systemid','mediascape'),('theme','default'),('time_format','g:i a');
/*!40000 ALTER TABLE `settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `lastlogin` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `active` varchar(255) NOT NULL DEFAULT '0',
  PRIMARY KEY (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES ('admin','f3bbbd66a63d4bf1747940578ec3d0103530e21d','spamkushal+admin@gmail.com','2018-08-16 18:29:01','0'),('banned','f3bbbd66a63d4bf1747940578ec3d0103530e21d','spamkushal+banned@gmail.com','2018-07-13 14:08:27','0'),('kushal','f3bbbd66a63d4bf1747940578ec3d0103530e21d','kushaldeveloper@gmail.com','2018-08-16 18:33:09','0'),('reporter','f3bbbd66a63d4bf1747940578ec3d0103530e21d','spamkushal+reporter@gmail.com','2018-07-13 14:09:09','0');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2018-08-21 22:05:39
