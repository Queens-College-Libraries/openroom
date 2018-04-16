-- MySQL dump 10.16  Distrib 10.2.14-MariaDB, for Linux (x86_64)
--
-- Host: localhost    Database: openroom
-- ------------------------------------------------------
-- Server version	10.2.14-MariaDB

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
INSERT INTO `administrators` VALUES ('admin');
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
  `timeofcancel` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`reservationid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cancelled`
--

LOCK TABLES `cancelled` WRITE;
/*!40000 ALTER TABLE `cancelled` DISABLE KEYS */;
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
  `optionprivate` tinyint(1) NOT NULL DEFAULT 0,
  `optionrequired` tinyint(1) NOT NULL DEFAULT 0,
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
  `timeofrequest` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`reservationid`)
) ENGINE=InnoDB AUTO_INCREMENT=90 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reservations`
--

LOCK TABLES `reservations` WRITE;
/*!40000 ALTER TABLE `reservations` DISABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roomgroups`
--

LOCK TABLES `roomgroups` WRITE;
/*!40000 ALTER TABLE `roomgroups` DISABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=298 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roomhours`
--

LOCK TABLES `roomhours` WRITE;
/*!40000 ALTER TABLE `roomhours` DISABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rooms`
--

LOCK TABLES `rooms` WRITE;
/*!40000 ALTER TABLE `rooms` DISABLE KEYS */;
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
INSERT INTO `settings` VALUES ('allow_past_reservations','false'),('allow_simultaneous_reservations','false'),('email_can_gef','a:1:{i:0;s:0:\"\";}'),('email_can_terse','a:1:{i:0;s:0:\"\";}'),('email_can_verbose','a:1:{i:0;s:0:\"\";}'),('email_condition',''),('email_condition_value',''),('email_cond_gef','a:1:{i:0;s:0:\"\";}'),('email_cond_terse','a:1:{i:0;s:0:\"\";}'),('email_cond_verbose','a:1:{i:0;s:0:\"\";}'),('email_filter','a:1:{i:0;s:8:\"cuny.edu\";}'),('email_res_gef','a:1:{i:0;s:0:\"\";}'),('email_res_terse','a:1:{i:0;s:0:\"\";}'),('email_res_verbose','a:1:{i:0;s:0:\"\";}'),('email_system',''),('https','true'),('instance_name','Openroom Testing'),('instance_url','localhost'),('interval','30'),('ldap_baseDN',''),('ldap_host',''),('limit_duration','240'),('limit_frequency','a:2:{i:0;i:0;i:1;s:3:\"day\";}'),('limit_openingday',''),('limit_total','a:2:{i:0;i:240;i:1;s:3:\"day\";}'),('limit_window','a:2:{i:0;i:6;i:1;s:5:\"month\";}'),('login_method','normal'),('policies',''),('remindermessage',''),('systemid','hx0dnpffl8'),('theme','default'),('time_format','g:i a');
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
  `lastlogin` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `active` varchar(255) NOT NULL DEFAULT '0',
  PRIMARY KEY (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES ('admin','f3bbbd66a63d4bf1747940578ec3d0103530e21d','hikingfan@gmail.com','2018-04-15 01:34:19','0');
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

-- Dump completed on 2018-04-14 21:41:58
