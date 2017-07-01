DROP DATABASE IF EXISTS openroom;
GRANT USAGE ON *.* TO 'openroom' @'localhost';
DROP USER IF EXISTS openroom;
CREATE DATABASE IF NOT EXISTS openroom;
GRANT ALL PRIVILEGES ON openroom.* TO openroom@localhost
IDENTIFIED BY 'xnNtKs804RoaohzSyUfV6xo7bPtvSJnbL9J7M9SrcWIkv3yaWfw8UhjDqMnfEqG';
USE openroom;
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";

-- MySQL dump 10.13  Distrib 5.7.16, for Linux (x86_64)
--
-- Host: localhost    Database: openroom
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

DROP TABLE IF EXISTS ` administrators `;
/*!40101 SET @saved_cs_client = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `administrators` (
`username` VARCHAR (255) NOT NULL,
PRIMARY KEY (`username`)
)
ENGINE = InnoDB
DEFAULT CHARSET = latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `administrators`
--

LOCK TABLES `administrators ` WRITE;
/*!40000 ALTER TABLE `administrators`
  DISABLE KEYS */;
INSERT INTO ` administrators` VALUES ('adfaf'), ('dwilliams1'), ('khada'), ('khada100'), ('library2sa'), ('shibboleth');
/*!40000 ALTER TABLE `administrators`
  ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `bannedusers`
--

DROP TABLE IF EXISTS ` bannedusers `;
/*!40101 SET @saved_cs_client = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bannedusers` (
`username` VARCHAR (255) NOT NULL,
PRIMARY KEY (`username`)
)
ENGINE = InnoDB
DEFAULT CHARSET = utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bannedusers`
--

LOCK TABLES `bannedusers ` WRITE;
/*!40000 ALTER TABLE `bannedusers`
  DISABLE KEYS */;
INSERT INTO ` bannedusers` VALUES ('egg');
/*!40000 ALTER TABLE `bannedusers`
  ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cancelled`
--

DROP TABLE IF EXISTS ` cancelled `;
/*!40101 SET @saved_cs_client = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cancelled` (
`reservationid` BIGINT (20) NOT NULL,
` START ` TIMESTAMP NOT NULL DEFAULT '0000-00-00 00:00:00',
` END ` TIMESTAMP NOT NULL DEFAULT '0000-00-00 00:00:00',
`roomid` INT (11) NOT NULL,
`username` VARCHAR (255) NOT NULL,
`timeofrequest` TIMESTAMP NOT NULL DEFAULT '0000-00-00 00:00:00',
`timeofcancel` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
PRIMARY KEY (`reservationid`)
)
ENGINE = InnoDB
DEFAULT CHARSET = latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cancelled`
--

LOCK TABLES `cancelled ` WRITE;
/*!40000 ALTER TABLE `cancelled`
  DISABLE KEYS */;
INSERT INTO ` cancelled `
VALUES (11, '2016-10-08 15:00:00', '2016-10-08 18:59:59', 1, 'khada100', '2016-10-08 03:25:46', '2016-10-08 03:26:08'),
  (21, '2016-11-03 21:30:00', '2016-11-03 22:59:59', 1, 'khada', '2016-11-03 18:10:28', '2016-11-03 18:10:35'),
  (22, '2016-11-03 22:00:00', '2016-11-03 23:29:59', 1, 'khada100', '2016-11-03 18:37:41', '2016-11-03 18:41:33'),
  (23, '2016-11-03 22:00:00', '2016-11-03 22:59:59', 1, 'khada100', '2016-11-03 18:42:52', '2016-11-03 18:43:04'),
  (24, '2016-11-03 22:30:00', '2016-11-03 23:59:59', 1, 'khada100', '2016-11-03 18:44:48', '2016-11-03 18:45:26'),
  (25, '2016-11-03 22:00:00', '2016-11-03 23:29:59', 1, 'khada100', '2016-11-03 18:46:29', '2016-11-03 18:48:08'),
  (26, '2016-11-03 22:30:00', '2016-11-03 23:59:59', 2, 'khada100', '2016-11-03 18:51:37', '2016-11-03 18:51:58'),
  (27, '2016-11-03 21:30:00', '2016-11-03 21:59:59', 3, 'khada100', '2016-11-03 18:52:57', '2016-11-03 18:53:05'),
  (28, '2016-11-03 21:00:00', '2016-11-03 22:29:59', 2, 'khada100', '2016-11-03 18:56:25', '2016-11-03 18:56:33'),
  (29, '2016-11-03 22:00:00', '2016-11-03 23:29:59', 3, 'khada100', '2016-11-03 18:59:46', '2016-11-03 18:59:52'),
  (30, '2016-11-03 20:30:00', '2016-11-03 22:29:59', 4, 'khada100', '2016-11-03 19:09:27', '2016-11-03 19:09:34'),
  (31, '2016-11-03 21:00:00', '2016-11-03 21:29:59', 4, 'khada100', '2016-11-03 19:23:07', '2016-11-03 19:23:12'),
  (32, '2016-11-03 22:30:00', '2016-11-03 22:59:59', 4, 'khada100', '2016-11-03 19:47:12', '2016-11-03 19:47:18'),
  (33, '2016-11-03 21:30:00', '2016-11-03 21:59:59', 4, 'khada100', '2016-11-03 19:49:30', '2016-11-03 19:49:35'),
  (34, '2016-11-03 22:30:00', '2016-11-03 23:59:59', 4, 'khada100', '2016-11-03 19:56:31', '2016-11-03 19:56:37'),
  (35, '2016-11-03 22:30:00', '2016-11-04 00:59:59', 4, 'khada100', '2016-11-03 20:23:12', '2016-11-03 20:23:19'),
  (36, '2016-11-03 22:00:00', '2016-11-03 22:29:59', 4, 'khada100', '2016-11-03 20:35:53', '2016-11-03 20:35:58'),
  (37, '2016-11-03 22:00:00', '2016-11-03 22:29:59', 4, 'khada100', '2016-11-03 20:41:13', '2016-11-03 20:41:21'),
  (38, '2016-11-03 22:00:00', '2016-11-03 22:29:59', 3, 'khada100', '2016-11-03 20:59:33', '2016-11-03 20:59:37'),
  (39, '2016-11-03 21:30:00', '2016-11-03 21:59:59', 2, 'khada100', '2016-11-03 21:03:07', '2016-11-03 21:03:13'),
  (40, '2016-11-03 23:00:00', '2016-11-03 23:29:59', 2, 'khada', '2016-11-03 21:06:30', '2016-11-03 21:06:37'),
  (41, '2016-11-04 18:00:00', '2016-11-04 18:29:59', 4, 'library2sa', '2016-11-04 22:28:12', '2016-11-04 22:28:18'),
  (43, '2016-11-04 18:30:00', '2016-11-04 18:59:59', 1, 'library2sa', '2016-11-04 22:58:34', '2016-11-04 22:58:39'),
  (44, '2016-11-04 19:00:00', '2016-11-04 19:29:59', 1, 'khada100', '2016-11-04 22:58:48', '2016-11-04 22:58:53'),
  (45, '2016-11-04 18:30:00', '2016-11-04 18:59:59', 1, 'library2sa', '2016-11-04 22:59:49', '2016-11-05 00:00:23'),
  (47, '2016-11-06 18:30:00', '2016-11-06 18:59:59', 1, 'khada100', '2016-11-06 12:49:07', '2016-11-06 12:49:13'),
  (48, '2016-11-06 19:30:00', '2016-11-06 19:59:59', 1, 'khada100', '2016-11-06 12:51:11', '2016-11-06 12:51:16'),
  (49, '2016-11-06 20:00:00', '2016-11-06 20:29:59', 1, 'khada100', '2016-11-06 12:53:16', '2016-11-06 12:53:20'),
  (50, '2016-11-06 19:00:00', '2016-11-06 19:29:59', 1, 'khada100', '2016-11-06 12:57:31', '2016-11-06 12:57:44'),
  (52, '2017-11-23 14:30:00', '2017-11-23 15:29:59', 1, 'dwilliams1', '2017-01-13 20:12:38', '2017-01-13 20:20:28');
/*!40000 ALTER TABLE `cancelled`
  ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `deletedrooms`
--

DROP TABLE IF EXISTS ` deletedrooms `;
/*!40101 SET @saved_cs_client = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `deletedrooms` (
`roomid` INT (11) NOT NULL,
`roomname` VARCHAR (255) NOT NULL,
`roomcapacity` INT (11) NOT NULL,
`roomgroupid` BIGINT (20) NOT NULL,
`roomdescription` LONGTEXT NOT NULL,
PRIMARY KEY (`roomid`)
)
ENGINE = InnoDB
DEFAULT CHARSET = utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `deletedrooms`
--

LOCK TABLES `deletedrooms ` WRITE;
/*!40000 ALTER TABLE `deletedrooms`
  DISABLE KEYS */;
/*!40000 ALTER TABLE `deletedrooms`
  ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `optionalfields`
--

DROP TABLE IF EXISTS ` optionalfields `;
/*!40101 SET @saved_cs_client = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `optionalfields` (
`optionname` VARCHAR (255) NOT NULL,
`optionformname` VARCHAR (255) NOT NULL
COMMENT 'no spaces, a-z only',
`optiontype` INT (11) NOT NULL
COMMENT '0 = text, 1 = select',
`optionchoices` VARCHAR (700) NOT NULL
COMMENT '";" delimited',
`optionorder` INT (11) NOT NULL,
`optionquestion` VARCHAR (255) NOT NULL,
`optionprivate`  TINYINT(1) NOT NULL DEFAULT '0',
`optionrequired` TINYINT(1) NOT NULL DEFAULT '0',
PRIMARY KEY (`optionname`),
UNIQUE KEY `optionformname` (`optionformname`)
)
ENGINE = InnoDB
DEFAULT CHARSET = latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `optionalfields`
--

LOCK TABLES `optionalfields ` WRITE;
/*!40000 ALTER TABLE `optionalfields`
  DISABLE KEYS */;
INSERT INTO ` optionalfields` VALUES
('Student classification', 'classification', 1, 'Freshman;Sophomore;Junior;Senior;Graduate;Staff;Other', 1,
'What is your classification?', 0, 1);
/*!40000 ALTER TABLE `optionalfields`
  ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `posts`
--

DROP TABLE IF EXISTS ` posts `;
/*!40101 SET @saved_cs_client = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `posts` (
`id` INT (11) NOT NULL,
`author` VARCHAR (45) NOT NULL,
` CONTENT ` VARCHAR (45) NOT NULL,
PRIMARY KEY (`id`)
)
ENGINE = InnoDB
DEFAULT CHARSET = latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `posts`
--

LOCK TABLES `posts ` WRITE;
/*!40000 ALTER TABLE `posts`
  DISABLE KEYS */;
INSERT INTO ` posts `
VALUES (1, 'kus', 'hello'), (2, 'kus', 'world'), (3, 'kus', 'latest news on apple computers '), (4, 'kus', 'haha oops');
/*!40000 ALTER TABLE `posts`
  ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reporters`
--

DROP TABLE IF EXISTS ` reporters `;
/*!40101 SET @saved_cs_client = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `reporters` (
`username` VARCHAR (255) NOT NULL,
PRIMARY KEY (`username`)
)
ENGINE = InnoDB
DEFAULT CHARSET = utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reporters`
--

LOCK TABLES `reporters ` WRITE;
/*!40000 ALTER TABLE `reporters`
  DISABLE KEYS */;
INSERT INTO ` reporters `
VALUES ('-1; DROP ALL TABLES; --'), ('-1; DROP ALL TABLES; -- asfsadf'), ('-1; DROP ALL TABLES; -- sdfsdf'), ('1'),
  ('; delete table administrators;'), ('afdsdf xc-1; DROP ALL TABLES; --'), ('apple'), ('asfd'),
  ('asfdsaf -1; DROP ALL TABLES; --'), ('ball'), ('cat'), ('dog'), ('egg'),
  ('error_log(\"Error message\\n\", 3, \"/mypath/php.log\");'), ('fish'), ('gun'), ('hen'), ('ice');
/*!40000 ALTER TABLE `reporters`
  ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reservationoptions`
--

DROP TABLE IF EXISTS ` reservationoptions `;
/*!40101 SET @saved_cs_client = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `reservationoptions` (
`optionname` VARCHAR (255) NOT NULL,
`reservationid` BIGINT (20) NOT NULL,
`optionvalue` VARCHAR (700) NOT NULL,
PRIMARY KEY (`optionname`, `reservationid`),
KEY `reservationid` (`reservationid`)
)
ENGINE = InnoDB
DEFAULT CHARSET = latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reservationoptions`
--

LOCK TABLES `reservationoptions ` WRITE;
/*!40000 ALTER TABLE `reservationoptions`
  DISABLE KEYS */;
INSERT INTO ` reservationoptions `
VALUES ('Student classification', 51, 'Graduate'), ('Student classification', 52, 'Staff'),
  ('Student classification', 53, 'Graduate');
/*!40000 ALTER TABLE `reservationoptions`
  ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reservations`
--

DROP TABLE IF EXISTS ` reservations `;
/*!40101 SET @saved_cs_client = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `reservations` (
`reservationid` BIGINT (20) NOT NULL AUTO_INCREMENT,
` START ` TIMESTAMP NOT NULL DEFAULT '0000-00-00 00:00:00',
` END ` TIMESTAMP NOT NULL DEFAULT '0000-00-00 00:00:00',
`roomid` INT (11) NOT NULL,
`username` VARCHAR (255) NOT NULL,
`numberingroup` INT (11) NOT NULL,
`timeofrequest` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
PRIMARY KEY (`reservationid`)
)
ENGINE = InnoDB
AUTO_INCREMENT = 54
DEFAULT CHARSET = latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reservations`
--

LOCK TABLES `reservations ` WRITE;
/*!40000 ALTER TABLE `reservations`
  DISABLE KEYS */;
INSERT INTO ` reservations `
VALUES (1, '2016-09-09 19:30:00', '2016-09-09 19:59:59', 1, 'dwilliams1', 4, '2016-09-09 18:58:21'),
  (2, '2016-09-18 18:30:00', '2016-09-18 18:59:59', 1, 'khada100', 8, '2016-09-18 15:45:17'),
  (3, '2016-10-03 17:00:00', '2016-10-03 17:29:59', 1, 'khada100', 4, '2016-10-03 16:58:03'),
  (4, '2016-10-03 17:30:00', '2016-10-03 19:29:59', 1, 'khada100', 1, '2016-10-03 16:58:16'),
  (5, '2016-10-03 20:00:00', '2016-10-03 22:59:59', 1, 'khada100', 1, '2016-10-03 16:58:54'),
  (6, '2016-10-04 14:30:00', '2016-10-04 14:59:59', 1, 'khada100', 1, '2016-10-03 22:13:29'),
  (7, '2016-10-04 15:00:00', '2016-10-04 15:29:59', 1, 'khada100', 6, '2016-10-03 22:20:10'),
  (8, '2016-10-05 13:30:00', '2016-10-05 14:29:59', 5, 'khada100', 3, '2016-10-05 11:49:57'),
  (9, '2016-10-05 22:00:00', '2016-10-05 22:29:59', 1, 'library2sa', 1, '2016-10-05 15:28:33'),
  (10, '2016-10-05 23:00:00', '2016-10-06 00:29:59', 4, 'khada100', 4, '2016-10-05 20:09:23'),
  (12, '2016-10-08 16:00:00', '2016-10-08 19:59:59', 1, 'khada100', 6, '2016-10-08 03:26:16'),
  (13, '2016-10-11 21:00:00', '2016-10-11 21:59:59', 2, 'Library2sa', 4, '2016-10-11 20:30:09'),
  (14, '2016-10-12 21:30:00', '2016-10-12 23:29:59', 4, 'khada100', 6, '2016-10-12 18:59:36'),
  (15, '2016-11-23 18:00:00', '2016-11-23 18:59:59', 3, 'dwilliams1', 3, '2016-10-12 21:20:12'),
  (16, '2016-10-17 15:00:00', '2016-10-17 15:59:59', 1, 'khada100', 1, '2016-10-17 01:21:26'),
  (17, '2016-10-18 18:30:00', '2016-10-18 20:29:59', 1, 'khada100', 1, '2016-10-17 20:41:33'),
  (18, '2016-10-18 20:30:00', '2016-10-18 22:29:59', 1, 'apple', 5, '2016-10-18 03:01:39'),
  (19, '2016-10-25 22:30:00', '2016-10-25 22:59:59', 1, 'khada100', 1, '2016-10-25 17:22:28'),
  (20, '2016-10-30 19:00:00', '2016-10-30 19:59:59', 1, 'khada100', 6, '2016-10-30 09:58:28'),
  (42, '2016-11-05 15:00:00', '2016-11-05 18:59:59', 1, 'appleballcatdogegg', 1, '2016-11-04 22:48:53'),
  (46, '2016-11-04 19:00:00', '2016-11-04 19:29:59', 1, 'khada100', 1, '2016-11-04 23:59:21'),
  (51, '2016-11-20 16:30:00', '2016-11-20 17:59:59', 4, 'khada100', 6, '2016-11-20 23:14:45'),
  (53, '2017-01-30 19:00:00', '2017-01-30 19:59:59', 3, 'dwilliams1', 4, '2017-01-13 20:23:35');
/*!40000 ALTER TABLE `reservations`
  ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `roomgroups`
--

DROP TABLE IF EXISTS ` roomgroups `;
/*!40101 SET @saved_cs_client = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `roomgroups` (
`roomgroupid` BIGINT (20) NOT NULL AUTO_INCREMENT,
`roomgroupname` VARCHAR (255) NOT NULL,
PRIMARY KEY (`roomgroupid`)
)
ENGINE = InnoDB
AUTO_INCREMENT = 3
DEFAULT CHARSET = latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roomgroups`
--

LOCK TABLES `roomgroups ` WRITE;
/*!40000 ALTER TABLE `roomgroups`
  DISABLE KEYS */;
INSERT INTO ` roomgroups` VALUES (1, 'Library'), (2, 'MediaScape');
/*!40000 ALTER TABLE `roomgroups`
  ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `roomhours`
--

DROP TABLE IF EXISTS ` roomhours `;
/*!40101 SET @saved_cs_client = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `roomhours` (
`roomhoursid` BIGINT (20) NOT NULL AUTO_INCREMENT,
`roomid` INT (11) NOT NULL,
`dayofweek` SMALLINT (6) NOT NULL,
` START ` TIME NOT NULL,
` END ` TIME NOT NULL,
PRIMARY KEY (`roomhoursid`)
)
ENGINE = InnoDB
AUTO_INCREMENT = 53
DEFAULT CHARSET = latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roomhours`
--

LOCK TABLES `roomhours ` WRITE;
/*!40000 ALTER TABLE `roomhours`
  DISABLE KEYS */;
INSERT INTO ` roomhours `
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

DROP TABLE IF EXISTS ` rooms `;
/*!40101 SET @saved_cs_client = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rooms` (
`roomid` INT (11) NOT NULL AUTO_INCREMENT,
`roomname` VARCHAR (255) NOT NULL,
`roomposition` INT (11) NOT NULL,
`roomcapacity` INT (11) NOT NULL,
`roomgroupid` BIGINT (20) NOT NULL,
`roomdescription` LONGTEXT NOT NULL,
PRIMARY KEY (`roomid`)
)
ENGINE = InnoDB
AUTO_INCREMENT = 8
DEFAULT CHARSET = latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rooms`
--

LOCK TABLES `rooms ` WRITE;
/*!40000 ALTER TABLE `rooms`
  DISABLE KEYS */;
INSERT INTO ` rooms `
VALUES (1, '445', 0, 8, 1, 'Room 445'), (2, '446', 1, 8, 1, 'Room 446'), (3, '503', 2, 8, 1, 'Room 503'),
  (4, '541', 3, 8, 1, 'Room 541'), (5, '1', 0, 8, 2, 'MediaScape Room 1'), (6, '2', 1, 8, 2, 'MediaScape Room 2'),
  (7, '3', 2, 8, 2, 'MediaScape Room 3');
/*!40000 ALTER TABLE `rooms`
  ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `roomspecialhours`
--

DROP TABLE IF EXISTS ` roomspecialhours `;
/*!40101 SET @saved_cs_client = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `roomspecialhours` (
`roomspecialhoursid` BIGINT (20) NOT NULL AUTO_INCREMENT,
`roomid` INT (11) NOT NULL,
`fromrange` TIMESTAMP NOT NULL DEFAULT '0000-00-00 00:00:00',
`torange` TIMESTAMP NOT NULL DEFAULT '0000-00-00 00:00:00',
` START ` TIME NOT NULL,
` END ` TIME NOT NULL,
PRIMARY KEY (`roomspecialhoursid`)
)
ENGINE = InnoDB
AUTO_INCREMENT = 22
DEFAULT CHARSET = latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roomspecialhours`
--

LOCK TABLES `roomspecialhours ` WRITE;
/*!40000 ALTER TABLE `roomspecialhours`
  DISABLE KEYS */;
INSERT INTO ` roomspecialhours` VALUES (1, 1, '2016-10-10 04:00:00', '2016-10-10 04:00:00', '00:00:00', '00:00:00'),
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
(21, 7, '2016-12-23 05:00:00', '2016-12-26 05:00:00', '00:00:00', '00:00:00');
/*!40000 ALTER TABLE `roomspecialhours`
  ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `settings`
--

DROP TABLE IF EXISTS ` settings `;
/*!40101 SET @saved_cs_client = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `settings` (
`settingname` VARCHAR (255) NOT NULL,
`settingvalue` LONGTEXT NOT NULL,
PRIMARY KEY (`settingname`)
)
ENGINE = InnoDB
DEFAULT CHARSET = latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `settings`
--

LOCK TABLES `settings ` WRITE;
/*!40000 ALTER TABLE `settings`
  DISABLE KEYS */;
INSERT INTO ` settings` VALUES ('allow_past_reservations', 'false'), ('allow_simultaneous_reservations', 'false'),
('email_can_gef', 'a:1:{i:0;s:0:\"\";}'), ('email_can_terse', 'a:1:{i:0;s:0:\"\";}'),
('email_can_verbose', 'a:1:{i:0;s:0:\"\";}'), ('email_condition', ''), ('email_condition_value', ''),
('email_cond_gef', 'a:1:{i:0;s:0:\"\";}'), ('email_cond_terse', 'a:1:{i:0;s:0:\"\";}'),
('email_cond_verbose', 'a:1:{i:0;s:0:\"\";}'),
('email_filter', 'a:2:{i:0;s:11:\"qc.cuny.edu\";i:1;s:14:\"qmail.cuny.edu\";}'),
('email_res_gef', 'a:1:{i:0;s:0:\"\";}'), ('email_res_terse', 'a:1:{i:0;s:0:\"\";}'),
('email_res_verbose', 'a:1:{i:0;s:0:\"\";}'), ('email_system', 'khada@qc.cuny.edu'), ('endtime', '21'),
('https', 'false'), ('instance_name', 'Rosenthal Room Reservations'),
('instance_url', 'library-test.qc.cuny.edu/or/'), ('interval', '30'), ('ldap_baseDN', 'ldap://149.4.100.201:3268'),
('ldap_host', 'DC=qc,DC=ads'), ('limit_duration', '240'), ('limit_frequency', 'a:2:{i:0;s:1:\"0\";i:1;s:3:\"day\";}'),
('limit_openingday', ''), ('limit_total', 'a:2:{i:0;s:3:\"240\";i:1;s:3:\"day\";}'),
('limit_window', 'a:2:{i:0;s:3:\"180\";i:1;s:3:\"day\";}'), ('login_method', 'ldap'),
('policies', 'Rosenthal Library usually has several rooms available to students for group study on a first-come, first-serve basis. These rooms are available to currently registered Queens College students only.\r\n\r\nImmediate use of a Group Study Room is made by presenting your valid Queens College ID at the Circulation Desk (located on Level 3 of the Library). If available, a room will be assigned to you for one 2-hour time block. If the room is in use a hold may be placed to secure the next available time slot. Room use, like book use, is assigned to your record in our automated circulation system. When a room is assigned to you, you will be handed a wooden block upon which the room number and policies governing Group Study Rooms is adhered. Upon completing your use of the room, the wooden block is to be returned to the Circulation Desk and the assignment of the room to your record will be released.\r\n\r\nShould you wish to extend the use of the room you are required to return to the Circulation desk with your ID and the wooden block at the end of the 2 hours. The room will then be reassigned to you provided there are no other users awaiting use of the room.'),
('remindermessage', 'The Library will be CLOSED, Monday, January 16. :D'), ('service_password', 'service_password'),
('service_username', 'library2sa'), ('starttime', '3'), ('systemid', '80zhh73n5'), ('theme', 'rosenthal'),
('time_format', 'g:i a');
/*!40000 ALTER TABLE `settings`
  ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS ` users `;
/*!40101 SET @saved_cs_client = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
`username` VARCHAR (255) NOT NULL,
` PASSWORD ` VARCHAR (255) NOT NULL,
`email` VARCHAR (255) NOT NULL,
`lastlogin` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
`active` VARCHAR (255) NOT NULL DEFAULT '0',
PRIMARY KEY (`username`)
)
ENGINE = InnoDB
DEFAULT CHARSET = latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users ` WRITE;
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

-- Dump completed on 2017-01-13 21:33:12