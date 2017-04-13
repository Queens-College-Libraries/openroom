DROP DATABASE IF EXISTS rooms;
DROP USER if EXISTS rooms;
CREATE DATABASE IF NOT EXISTS rooms;
GRANT ALL PRIVILEGES ON rooms.* TO rooms@localhost
IDENTIFIED BY 'oZl4eftKZuYx4aTDGcLK2yXrLbePH6iQ3POAcVm2YPtbEMBlCwcTpn2abhpls2v';
USE rooms;
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";

-- MySQL dump 10.13  Distrib 5.7.16, for Linux (x86_64)
--
-- Host: localhost    Database: rooms
-- ------------------------------------------------------
-- Server version	5.7.16-0ubuntu0.16.04.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT = @@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS = @@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION = @@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE = @@TIME_ZONE */;
/*!40103 SET TIME_ZONE = '+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS = @@UNIQUE_CHECKS, UNIQUE_CHECKS = 0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS = @@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS = 0 */;
/*!40101 SET @OLD_SQL_MODE = @@SQL_MODE, SQL_MODE = 'NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES = @@SQL_NOTES, SQL_NOTES = 0 */;

--
-- Table structure for table `administrators`
--

DROP TABLE IF EXISTS `administrators`;
/*!40101 SET @saved_cs_client = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `administrators` (
  `username` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`username`)
)
  ENGINE = InnoDB
  DEFAULT CHARSET = latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `administrators`
--

LOCK TABLES `administrators` WRITE;
/*!40000 ALTER TABLE `administrators`
  DISABLE KEYS */;
INSERT INTO `administrators` VALUES ('dwilliams1'), ('khada');
/*!40000 ALTER TABLE `administrators`
  ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `bannedusers`
--

DROP TABLE IF EXISTS `bannedusers`;
/*!40101 SET @saved_cs_client = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bannedusers` (
  `username` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`username`)
)
  ENGINE = InnoDB
  DEFAULT CHARSET = utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bannedusers`
--

LOCK TABLES `bannedusers` WRITE;
/*!40000 ALTER TABLE `bannedusers`
  DISABLE KEYS */;
INSERT INTO `bannedusers` VALUES ('apple'), ('ball'), ('cat'), ('dog');
/*!40000 ALTER TABLE `bannedusers`
  ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cancelled`
--

DROP TABLE IF EXISTS `cancelled`;
/*!40101 SET @saved_cs_client = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cancelled` (
  `reservationid` BIGINT(20)   NOT NULL,
  `start`         TIMESTAMP    NOT NULL DEFAULT '0000-00-00 00:00:00',
  `end`           TIMESTAMP    NOT NULL DEFAULT '0000-00-00 00:00:00',
  `roomid`        INT(11)      NOT NULL,
  `username`      VARCHAR(255) NOT NULL,
  `timeofrequest` TIMESTAMP    NOT NULL DEFAULT '0000-00-00 00:00:00',
  `timeofcancel`  TIMESTAMP    NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`reservationid`)
)
  ENGINE = InnoDB
  DEFAULT CHARSET = latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cancelled`
--

LOCK TABLES `cancelled` WRITE;
/*!40000 ALTER TABLE `cancelled`
  DISABLE KEYS */;
INSERT INTO `cancelled` VALUES
  (14, '2016-11-09 18:00:00', '2016-11-09 18:59:59', 2, 'dwilliams1', '2016-10-19 20:29:08', '2016-11-03 14:40:22'),
  (16, '2016-11-10 18:00:00', '2016-11-10 19:29:59', 2, 'dwilliams1', '2016-11-02 17:31:29', '2016-11-03 14:40:44'),
  (17, '2016-11-03 23:00:00', '2016-11-04 00:29:59', 1, 'khada100', '2016-11-03 18:14:37', '2016-11-03 18:15:05'),
  (18, '2016-11-03 23:00:00', '2016-11-04 00:29:59', 4, 'khada100', '2016-11-03 20:03:57', '2016-11-03 20:04:05'),
  (19, '2016-11-03 22:30:00', '2016-11-03 22:59:59', 3, 'khada100', '2016-11-03 20:07:17', '2016-11-03 20:07:36'),
  (20, '2016-11-03 22:00:00', '2016-11-03 23:29:59', 2, 'khada100', '2016-11-03 20:11:31', '2016-11-03 20:11:37'),
  (21, '2016-11-03 22:00:00', '2016-11-03 23:59:59', 4, 'khada100', '2016-11-03 20:13:20', '2016-11-03 20:13:24'),
  (22, '2016-11-03 22:00:00', '2016-11-03 22:29:59', 4, 'khada100', '2016-11-03 20:21:26', '2016-11-03 20:21:32'),
  (23, '2016-11-03 22:30:00', '2016-11-03 23:59:59', 4, 'khada100', '2016-11-03 20:21:55', '2016-11-03 20:22:03'),
  (24, '2016-11-03 22:00:00', '2016-11-03 23:59:59', 4, 'khada100', '2016-11-03 20:23:53', '2016-11-03 20:24:04'),
  (25, '2016-11-12 20:00:00', '2016-11-12 20:59:59', 1, 'dwilliams1', '2016-11-03 20:23:55', '2016-11-03 20:24:33'),
  (26, '2016-11-03 21:30:00', '2016-11-03 23:29:59', 4, 'khada100', '2016-11-03 20:27:47', '2016-11-03 20:27:54'),
  (27, '2016-11-03 21:00:00', '2016-11-03 22:59:59', 4, 'khada100', '2016-11-03 20:28:55', '2016-11-03 20:29:01'),
  (28, '2016-11-03 20:30:00', '2016-11-03 20:59:59', 4, 'khada100', '2016-11-03 20:29:29', '2016-11-03 20:29:36'),
  (29, '2016-11-03 20:30:00', '2016-11-03 20:59:59', 4, 'khada100', '2016-11-03 20:30:03', '2016-11-03 20:30:24'),
  (30, '2016-11-04 00:00:00', '2016-11-04 00:29:59', 4, 'khada100', '2016-11-03 20:30:39', '2016-11-03 20:31:00'),
  (31, '2016-11-03 23:00:00', '2016-11-03 23:29:59', 4, 'khada', '2016-11-03 20:32:23', '2016-11-03 20:32:34'),
  (32, '2016-11-03 21:00:00', '2016-11-03 22:59:59', 4, 'khada100', '2016-11-03 20:34:16', '2016-11-03 20:34:51'),
  (33, '2016-11-03 23:30:00', '2016-11-04 00:59:59', 4, 'khada100', '2016-11-03 20:44:21', '2016-11-03 20:44:31'),
  (34, '2016-11-03 22:30:00', '2016-11-03 23:59:59', 4, 'khada100', '2016-11-03 20:48:08', '2016-11-03 20:48:15'),
  (35, '2016-11-03 20:30:00', '2016-11-03 22:59:59', 2, 'khada100', '2016-11-03 20:48:55', '2016-11-03 20:49:17'),
  (36, '2016-11-03 21:30:00', '2016-11-03 21:59:59', 3, 'khada100', '2016-11-03 21:00:00', '2016-11-03 21:00:05'),
  (37, '2016-11-03 22:30:00', '2016-11-03 22:59:59', 2, 'khada', '2016-11-03 21:09:14', '2016-11-03 21:09:19'),
  (38, '2016-11-03 23:30:00', '2016-11-03 23:59:59', 2, 'khada100', '2016-11-03 21:09:44', '2016-11-03 21:09:55'),
  (39, '2016-11-03 21:00:00', '2016-11-03 21:29:59', 2, 'khada100', '2016-11-03 21:10:40', '2016-11-03 21:24:19'),
  (40, '2016-11-04 18:30:00', '2016-11-04 18:59:59', 1, 'khada', '2016-11-04 01:32:17', '2016-11-04 01:32:24'),
  (41, '2016-11-04 18:00:00', '2016-11-04 18:29:59', 1, 'khada100', '2016-11-04 01:32:42', '2016-11-04 01:32:47'),
  (42, '2016-11-03 18:00:00', '2016-11-03 18:29:59', 4, 'khada', '2016-11-04 01:49:15', '2016-11-04 01:49:20'),
  (43, '2016-11-05 16:00:00', '2016-11-05 16:29:59', 1, 'library2aa', '2016-11-04 22:28:49', '2016-11-04 22:28:52'),
  (44, '2016-11-06 19:30:00', '2016-11-06 19:59:59', 1, 'khada100', '2016-11-06 12:58:19', '2016-11-06 12:58:32'),
  (45, '2016-11-06 19:00:00', '2016-11-06 19:29:59', 1, 'khada100', '2016-11-06 13:02:54', '2016-11-06 13:03:45'),
  (46, '2016-11-06 19:30:00', '2016-11-06 19:59:59', 1, 'khada100', '2016-11-06 13:04:04', '2016-11-06 13:09:13'),
  (47, '2016-11-06 19:30:00', '2016-11-06 19:59:59', 1, 'library2sa', '2016-11-06 13:14:56', '2016-11-06 13:15:01'),
  (48, '2016-11-07 23:00:00', '2016-11-07 23:59:59', 3, 'khada100', '2016-11-07 15:35:53', '2016-11-07 15:37:00'),
  (49, '2016-11-08 00:00:00', '2016-11-08 01:29:59', 1, 'khada100', '2016-11-07 15:38:19', '2016-11-07 15:38:28'),
  (50, '2016-11-22 18:00:00', '2016-11-22 18:59:59', 2, 'dwilliams1', '2016-11-07 22:13:59', '2016-11-07 22:14:55'),
  (51, '2016-11-22 19:30:00', '2016-11-22 19:59:59', 1, 'khada100', '2016-11-07 22:15:50', '2016-11-07 22:16:18'),
  (52, '2016-11-15 20:00:00', '2016-11-15 21:29:59', 3, 'dwilliams1', '2016-11-09 16:16:04', '2016-11-09 16:17:38'),
  (53, '2016-11-15 21:30:00', '2016-11-15 21:59:59', 7, 'dwilliams1', '2016-11-09 16:18:30', '2016-11-09 16:19:17');
/*!40000 ALTER TABLE `cancelled`
  ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `deletedrooms`
--

DROP TABLE IF EXISTS `deletedrooms`;
/*!40101 SET @saved_cs_client = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `deletedrooms` (
  `roomid`          INT(11)      NOT NULL,
  `roomname`        VARCHAR(255) NOT NULL,
  `roomcapacity`    INT(11)      NOT NULL,
  `roomgroupid`     BIGINT(20)   NOT NULL,
  `roomdescription` LONGTEXT     NOT NULL,
  PRIMARY KEY (`roomid`)
)
  ENGINE = InnoDB
  DEFAULT CHARSET = utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `deletedrooms`
--

LOCK TABLES `deletedrooms` WRITE;
/*!40000 ALTER TABLE `deletedrooms`
  DISABLE KEYS */;
/*!40000 ALTER TABLE `deletedrooms`
  ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `optionalfields`
--

DROP TABLE IF EXISTS `optionalfields`;
/*!40101 SET @saved_cs_client = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `optionalfields` (
  `optionname`     VARCHAR(255) NOT NULL,
  `optionformname` VARCHAR(255) NOT NULL
  COMMENT 'no spaces, a-z only',
  `optiontype`     INT(11)      NOT NULL
  COMMENT '0 = text, 1 = select',
  `optionchoices`  VARCHAR(700) NOT NULL
  COMMENT '";" delimited',
  `optionorder`    INT(11)      NOT NULL,
  `optionquestion` VARCHAR(255) NOT NULL,
  `optionprivate`  TINYINT(1)   NOT NULL DEFAULT '0',
  `optionrequired` TINYINT(1)   NOT NULL DEFAULT '0',
  PRIMARY KEY (`optionname`),
  UNIQUE KEY `optionformname` (`optionformname`)
)
  ENGINE = InnoDB
  DEFAULT CHARSET = latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `optionalfields`
--

LOCK TABLES `optionalfields` WRITE;
/*!40000 ALTER TABLE `optionalfields`
  DISABLE KEYS */;
INSERT INTO `optionalfields` VALUES
  ('campus-affiliation', 'campusaffiliation', 1, 'Undergraduate;Graduate;FacultyStaff', 1,
   '\"What is your Campus Affiliation?\"', 0, 1);
/*!40000 ALTER TABLE `optionalfields`
  ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reporters`
--

DROP TABLE IF EXISTS `reporters`;
/*!40101 SET @saved_cs_client = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `reporters` (
  `username` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`username`)
)
  ENGINE = InnoDB
  DEFAULT CHARSET = utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reporters`
--

LOCK TABLES `reporters` WRITE;
/*!40000 ALTER TABLE `reporters`
  DISABLE KEYS */;
INSERT INTO `reporters` VALUES ('1'), ('apple');
/*!40000 ALTER TABLE `reporters`
  ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reservationoptions`
--

DROP TABLE IF EXISTS `reservationoptions`;
/*!40101 SET @saved_cs_client = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `reservationoptions` (
  `optionname`    VARCHAR(255) NOT NULL,
  `reservationid` BIGINT(20)   NOT NULL,
  `optionvalue`   VARCHAR(700) NOT NULL,
  PRIMARY KEY (`optionname`, `reservationid`),
  KEY `reservationid` (`reservationid`)
)
  ENGINE = InnoDB
  DEFAULT CHARSET = latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reservationoptions`
--

LOCK TABLES `reservationoptions` WRITE;
/*!40000 ALTER TABLE `reservationoptions`
  DISABLE KEYS */;
/*!40000 ALTER TABLE `reservationoptions`
  ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reservations`
--

DROP TABLE IF EXISTS `reservations`;
/*!40101 SET @saved_cs_client = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `reservations` (
  `reservationid` BIGINT(20)   NOT NULL AUTO_INCREMENT,
  `start`         TIMESTAMP    NOT NULL DEFAULT '0000-00-00 00:00:00',
  `end`           TIMESTAMP    NOT NULL DEFAULT '0000-00-00 00:00:00',
  `roomid`        INT(11)      NOT NULL,
  `username`      VARCHAR(255) NOT NULL,
  `numberingroup` INT(11)      NOT NULL,
  `timeofrequest` TIMESTAMP    NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`reservationid`)
)
  ENGINE = InnoDB
  AUTO_INCREMENT = 17
  DEFAULT CHARSET = latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reservations`
--

LOCK TABLES `reservations` WRITE;
/*!40000 ALTER TABLE `reservations`
  DISABLE KEYS */;
INSERT INTO `reservations`
VALUES (1, '2016-09-09 19:30:00', '2016-09-09 19:59:59', 1, 'dwilliams1', 4, '2016-09-09 18:58:21'),
  (2, '2016-09-14 13:00:00', '2016-09-14 13:29:59', 1, 'khada100', 1, '2016-09-14 16:27:37'),
  (3, '2016-09-14 17:30:00', '2016-09-14 17:59:59', 1, 'khada100', 1, '2016-09-14 16:32:26'),
  (4, '2016-09-14 18:30:00', '2016-09-14 18:59:59', 1, 'khada', 1, '2016-09-14 16:33:15'),
  (5, '2016-09-14 20:00:00', '2016-09-14 20:29:59', 1, 'instr\\khada', 1, '2016-09-14 16:35:12'),
  (6, '2016-09-14 20:30:00', '2016-09-14 20:59:59', 1, 'instr\\\\khada100', 1, '2016-09-14 16:35:31'),
  (7, '2016-09-22 17:30:00', '2016-09-22 18:29:59', 3, 'dwilliams1', 4, '2016-09-21 19:28:12'),
  (8, '2016-10-08 16:00:00', '2016-10-08 19:59:59', 1, 'khada100', 6, '2016-10-08 03:34:06'),
  (9, '2016-10-08 15:00:00', '2016-10-08 15:59:59', 1, 'library2sa', 8, '2016-10-08 03:50:03'),
  (10, '2016-10-15 17:30:00', '2016-10-15 19:29:59', 1, 'khada100', 4, '2016-10-15 13:07:52'),
  (11, '2016-10-20 17:30:00', '2016-10-20 18:59:59', 6, 'dwilliams1', 5, '2016-10-17 16:58:27'),
  (12, '2016-10-18 19:30:00', '2016-10-18 21:29:59', 1, 'khada100', 1, '2016-10-17 20:53:59'),
  (13, '2016-10-18 21:30:00', '2016-10-18 23:59:59', 1, 'library2sa', 1, '2016-10-17 21:59:52'),
  (15, '2016-10-26 23:00:00', '2016-10-26 23:29:59', 1, 'library2sa', 1, '2016-10-26 22:10:41'),
  (16, '2017-01-13 19:30:00', '2017-01-13 19:59:59', 1, 'khada100', 8, '2017-01-13 20:34:57');
/*!40000 ALTER TABLE `reservations`
  ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `roomgroups`
--

DROP TABLE IF EXISTS `roomgroups`;
/*!40101 SET @saved_cs_client = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `roomgroups` (
  `roomgroupid`   BIGINT(20)   NOT NULL AUTO_INCREMENT,
  `roomgroupname` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`roomgroupid`)
)
  ENGINE = InnoDB
  AUTO_INCREMENT = 3
  DEFAULT CHARSET = latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roomgroups`
--

LOCK TABLES `roomgroups` WRITE;
/*!40000 ALTER TABLE `roomgroups`
  DISABLE KEYS */;
INSERT INTO `roomgroups` VALUES (1, 'Library'), (2, 'MediaScape');
/*!40000 ALTER TABLE `roomgroups`
  ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `roomhours`
--

DROP TABLE IF EXISTS `roomhours`;
/*!40101 SET @saved_cs_client = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `roomhours` (
  `roomhoursid` BIGINT(20)  NOT NULL AUTO_INCREMENT,
  `roomid`      INT(11)     NOT NULL,
  `dayofweek`   SMALLINT(6) NOT NULL,
  `start`       TIME        NOT NULL,
  `end`         TIME        NOT NULL,
  PRIMARY KEY (`roomhoursid`)
)
  ENGINE = InnoDB
  AUTO_INCREMENT = 53
  DEFAULT CHARSET = latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roomhours`
--

LOCK TABLES `roomhours` WRITE;
/*!40000 ALTER TABLE `roomhours`
  DISABLE KEYS */;
INSERT INTO `roomhours`
VALUES (1, 1, 0, '11:00:00', '16:00:00'), (2, 1, 1, '09:00:00', '21:00:00'), (3, 1, 2, '09:00:00', '21:00:00'),
  (4, 1, 3, '09:00:00', '21:00:00'), (5, 1, 4, '09:00:00', '21:00:00'), (7, 1, 6, '11:00:00', '16:00:00'),
  (8, 2, 0, '11:00:00', '16:00:00'), (9, 2, 1, '09:00:00', '21:00:00'), (10, 2, 2, '09:00:00', '21:00:00'),
  (11, 2, 3, '09:00:00', '21:00:00'), (12, 2, 4, '09:00:00', '21:00:00'), (14, 2, 6, '11:00:00', '16:00:00'),
  (15, 3, 0, '11:00:00', '16:00:00'), (16, 3, 1, '09:00:00', '21:00:00'), (17, 3, 2, '09:00:00', '21:00:00'),
  (18, 3, 3, '09:00:00', '22:00:00'), (19, 3, 4, '09:00:00', '21:00:00'), (21, 3, 6, '11:00:00', '16:00:00'),
  (22, 4, 0, '11:00:00', '16:00:00'), (23, 4, 1, '09:00:00', '21:00:00'), (24, 4, 2, '09:00:00', '21:00:00'),
  (25, 4, 3, '09:00:00', '21:00:00'), (26, 4, 4, '09:00:00', '21:00:00'), (27, 4, 5, '09:00:00', '16:00:00'),
  (28, 4, 6, '11:00:00', '16:00:00'), (29, 1, 5, '09:00:00', '16:00:00'), (30, 2, 5, '09:00:00', '16:00:00'),
  (31, 3, 5, '09:00:00', '16:00:00'), (32, 5, 0, '11:00:00', '16:00:00'), (33, 5, 6, '11:00:00', '16:00:00'),
  (34, 5, 5, '09:00:00', '16:00:00'), (35, 6, 0, '11:00:00', '16:00:00'), (36, 6, 6, '11:00:00', '16:00:00'),
  (37, 6, 5, '09:00:00', '16:00:00'), (38, 7, 0, '11:00:00', '16:00:00'), (39, 7, 6, '11:00:00', '16:00:00'),
  (40, 7, 5, '09:00:00', '16:00:00'), (41, 5, 1, '09:00:00', '21:00:00'), (42, 5, 2, '09:00:00', '21:00:00'),
  (43, 5, 3, '09:00:00', '21:00:00'), (44, 5, 4, '09:00:00', '21:00:00'), (45, 6, 1, '09:00:00', '21:00:00'),
  (46, 6, 2, '09:00:00', '21:00:00'), (47, 6, 3, '09:00:00', '21:00:00'), (48, 6, 4, '09:00:00', '21:00:00'),
  (49, 7, 1, '09:00:00', '21:00:00'), (50, 7, 2, '09:00:00', '21:00:00'), (51, 7, 3, '09:00:00', '21:00:00'),
  (52, 7, 4, '09:00:00', '21:00:00');
/*!40000 ALTER TABLE `roomhours`
  ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rooms`
--

DROP TABLE IF EXISTS `rooms`;
/*!40101 SET @saved_cs_client = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rooms` (
  `roomid`          INT(11)      NOT NULL AUTO_INCREMENT,
  `roomname`        VARCHAR(255) NOT NULL,
  `roomposition`    INT(11)      NOT NULL,
  `roomcapacity`    INT(11)      NOT NULL,
  `roomgroupid`     BIGINT(20)   NOT NULL,
  `roomdescription` LONGTEXT     NOT NULL,
  PRIMARY KEY (`roomid`)
)
  ENGINE = InnoDB
  AUTO_INCREMENT = 8
  DEFAULT CHARSET = latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rooms`
--

LOCK TABLES `rooms` WRITE;
/*!40000 ALTER TABLE `rooms`
  DISABLE KEYS */;
INSERT INTO `rooms`
VALUES (1, '445', 0, 8, 1, 'Room 445'), (2, '446', 1, 8, 1, 'Room 446'), (3, '503', 2, 8, 1, 'Room 503'),
  (4, '541', 3, 8, 1, 'Room 541'), (5, '1', 0, 8, 2, 'MediaScape Room 1'), (6, '2', 1, 8, 2, 'MediaScape Room 2'),
  (7, '3', 2, 8, 2, 'MediaScape Room 3');
/*!40000 ALTER TABLE `rooms`
  ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `roomspecialhours`
--

DROP TABLE IF EXISTS `roomspecialhours`;
/*!40101 SET @saved_cs_client = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `roomspecialhours` (
  `roomspecialhoursid` BIGINT(20) NOT NULL AUTO_INCREMENT,
  `roomid`             INT(11)    NOT NULL,
  `fromrange`          TIMESTAMP  NOT NULL DEFAULT '0000-00-00 00:00:00',
  `torange`            TIMESTAMP  NOT NULL DEFAULT '0000-00-00 00:00:00',
  `start`              TIME       NOT NULL,
  `end`                TIME       NOT NULL,
  PRIMARY KEY (`roomspecialhoursid`)
)
  ENGINE = InnoDB
  AUTO_INCREMENT = 36
  DEFAULT CHARSET = latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roomspecialhours`
--

LOCK TABLES `roomspecialhours` WRITE;
/*!40000 ALTER TABLE `roomspecialhours`
  DISABLE KEYS */;
INSERT INTO `roomspecialhours` VALUES (1, 1, '2016-10-10 04:00:00', '2016-10-10 04:00:00', '00:00:00', '00:00:00'),
  (2, 2, '2016-10-10 04:00:00', '2016-10-10 04:00:00', '00:00:00', '00:00:00'),
  (3, 3, '2016-10-10 04:00:00', '2016-10-10 04:00:00', '00:00:00', '00:00:00'),
  (4, 4, '2016-10-10 04:00:00', '2016-10-10 04:00:00', '00:00:00', '00:00:00'),
  (5, 5, '2016-10-10 04:00:00', '2016-10-10 04:00:00', '00:00:00', '00:00:00'),
  (6, 6, '2016-10-10 04:00:00', '2016-10-10 04:00:00', '00:00:00', '00:00:00'),
  (7, 7, '2016-10-10 04:00:00', '2016-10-10 04:00:00', '00:00:00', '00:00:00'),
  (8, 1, '2016-11-24 05:00:00', '2016-11-27 05:00:00', '00:00:00', '00:00:00'),
  (9, 2, '2016-11-24 05:00:00', '2016-11-27 05:00:00', '00:00:00', '00:00:00'),
  (10, 3, '2016-11-24 05:00:00', '2016-11-27 05:00:00', '00:00:00', '00:00:00'),
  (11, 4, '2016-11-24 05:00:00', '2016-11-27 05:00:00', '00:00:00', '00:00:00'),
  (12, 5, '2016-11-24 05:00:00', '2016-11-27 05:00:00', '00:00:00', '00:00:00'),
  (13, 6, '2016-11-24 05:00:00', '2016-11-27 05:00:00', '00:00:00', '00:00:00'),
  (14, 7, '2016-11-24 05:00:00', '2016-11-27 05:00:00', '00:00:00', '00:00:00'),
  (15, 1, '2016-12-23 05:00:00', '2016-12-26 05:00:00', '00:00:00', '00:00:00'),
  (16, 2, '2016-12-23 05:00:00', '2016-12-26 05:00:00', '00:00:00', '00:00:00'),
  (17, 3, '2016-12-23 05:00:00', '2016-12-26 05:00:00', '00:00:00', '00:00:00'),
  (18, 4, '2016-12-23 05:00:00', '2016-12-26 05:00:00', '00:00:00', '00:00:00'),
  (19, 5, '2016-12-23 05:00:00', '2016-12-26 05:00:00', '00:00:00', '00:00:00'),
  (20, 6, '2016-12-23 05:00:00', '2016-12-26 05:00:00', '00:00:00', '00:00:00'),
  (21, 7, '2016-12-23 05:00:00', '2016-12-26 05:00:00', '00:00:00', '00:00:00'),
  (22, 1, '2016-12-30 05:00:00', '2016-12-31 05:00:00', '00:00:00', '00:00:00'),
  (23, 2, '2016-12-30 05:00:00', '2016-12-31 05:00:00', '00:00:00', '00:00:00'),
  (24, 3, '2016-12-30 05:00:00', '2016-12-31 05:00:00', '00:00:00', '00:00:00'),
  (25, 4, '2016-12-30 05:00:00', '2016-12-31 05:00:00', '00:00:00', '00:00:00'),
  (26, 5, '2016-12-30 05:00:00', '2016-12-31 05:00:00', '00:00:00', '00:00:00'),
  (27, 6, '2016-12-30 05:00:00', '2016-12-31 05:00:00', '00:00:00', '00:00:00'),
  (28, 7, '2016-12-30 05:00:00', '2016-12-31 05:00:00', '00:00:00', '00:00:00'),
  (29, 1, '2017-01-01 05:00:00', '2017-01-02 05:00:00', '00:00:00', '00:00:00'),
  (30, 2, '2017-01-01 05:00:00', '2017-01-02 05:00:00', '00:00:00', '00:00:00'),
  (31, 3, '2017-01-01 05:00:00', '2017-01-02 05:00:00', '00:00:00', '00:00:00'),
  (32, 4, '2017-01-01 05:00:00', '2017-01-02 05:00:00', '00:00:00', '00:00:00'),
  (33, 5, '2017-01-01 05:00:00', '2017-01-02 05:00:00', '00:00:00', '00:00:00'),
  (34, 6, '2017-01-01 05:00:00', '2017-01-02 05:00:00', '00:00:00', '00:00:00'),
  (35, 7, '2017-01-01 05:00:00', '2017-01-02 05:00:00', '00:00:00', '00:00:00');
/*!40000 ALTER TABLE `roomspecialhours`
  ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `settings`
--

DROP TABLE IF EXISTS `settings`;
/*!40101 SET @saved_cs_client = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `settings` (
  `settingname`  VARCHAR(255) NOT NULL,
  `settingvalue` LONGTEXT     NOT NULL,
  PRIMARY KEY (`settingname`)
)
  ENGINE = InnoDB
  DEFAULT CHARSET = latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `settings`
--

LOCK TABLES `settings` WRITE;
/*!40000 ALTER TABLE `settings`
  DISABLE KEYS */;
INSERT INTO `settings` VALUES ('allow_past_reservations', 'false'), ('allow_simultaneous_reservations', 'false'),
  ('email_can_gef', 'a:1:{i:0;s:0:\"\";}'), ('email_can_terse', 'a:1:{i:0;s:0:\"\";}'),
  ('email_can_verbose', 'a:1:{i:0;s:0:\"\";}'), ('email_condition', ''), ('email_condition_value', ''),
  ('email_cond_gef', 'a:1:{i:0;s:0:\"\";}'), ('email_cond_terse', 'a:1:{i:0;s:0:\"\";}'),
  ('email_cond_verbose', 'a:1:{i:0;s:0:\"\";}'),
  ('email_filter', 'a:2:{i:0;s:11:\"qc.cuny.edu\";i:1;s:14:\"qmail.cuny.edu\";}'),
  ('email_res_gef', 'a:1:{i:0;s:0:\"\";}'), ('email_res_terse', 'a:1:{i:0;s:0:\"\";}'),
  ('email_res_verbose', 'a:1:{i:0;s:0:\"\";}'), ('email_system', 'qc_ask_circ@qc.cuny.edu'), ('endtime', '22'),
  ('https', 'false'), ('instance_name', 'Rosenthal Room Reservations'),
  ('instance_url', 'library-test.qc.cuny.edu/rooms/'), ('interval', '30'), ('ldap_baseDN', 'ldap://149.4.100.201:3268'),
  ('ldap_host', 'DC=qc,DC=ads'), ('limit_duration', '240'), ('limit_frequency', 'a:2:{i:0;s:1:\"0\";i:1;s:3:\"day\";}'),
  ('limit_openingday', ''), ('limit_total', 'a:2:{i:0;s:3:\"240\";i:1;s:3:\"day\";}'),
  ('limit_window', 'a:2:{i:0;i:0;i:1;s:10:\"12/31/2016\";}'), ('login_method', 'ldap'),
  ('policies', 'Rosenthal Library usually has several rooms available to students for group study on a first-come, first-serve basis. These rooms are available to currently registered Queens College students only.\r\n\r\nImmediate use of a Group Study Room is made by presenting your valid Queens College ID at the Circulation Desk (located on Level 3 of the Library). If available, a room will be assigned to you for one 2-hour time block. If the room is in use a hold may be placed to secure the next available time slot. Room use, like book use, is assigned to your record in our automated circulation system. When a room is assigned to you, you will be handed a wooden block upon which the room number and policies governing Group Study Rooms is adhered. Upon completing your use of the room, the wooden block is to be returned to the Circulation Desk and the assignment of the room to your record will be released.\r\n\r\nShould you wish to extend the use of the room you are required to return to the Circulation desk with your ID and the wooden block at the end of the 2 hours. The room will then be reassigned to you provided there are no other users awaiting use of the room.'),
  ('remindermessage', 'The Library will be CLOSED, Monday, January 16.'), ('service_password', 'service_password'),
  ('service_username', 'library2sa'), ('starttime', '8'), ('systemid', '80zhh73n5'), ('theme', 'rosenthal'),
  ('time_format', 'g:i a');
/*!40000 ALTER TABLE `settings`
  ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `username`  VARCHAR(255) NOT NULL,
  `password`  VARCHAR(255) NOT NULL,
  `email`     VARCHAR(255) NOT NULL,
  `lastlogin` TIMESTAMP    NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `active`    VARCHAR(255) NOT NULL DEFAULT '0',
  PRIMARY KEY (`username`)
)
  ENGINE = InnoDB
  DEFAULT CHARSET = latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users`
  DISABLE KEYS */;
/*!40000 ALTER TABLE `users`
  ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE = @OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE = @OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS = @OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS = @OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT = @OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS = @OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION = @OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES = @OLD_SQL_NOTES */;

-- Dump completed on 2017-01-13 21:32:13