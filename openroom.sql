SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

-- 
-- Table structure for table `administrators`
-- 

CREATE TABLE IF NOT EXISTS `administrators` (
  `username` varchar(255) NOT NULL,
  PRIMARY KEY (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- --------------------------------------------------------

-- 
-- Table structure for table `bannedusers`
-- 

CREATE TABLE IF NOT EXISTS `bannedusers` (
  `username` varchar(255) NOT NULL,
  PRIMARY KEY (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



-- --------------------------------------------------------

-- 
-- Table structure for table `cancelled`
-- 

CREATE TABLE IF NOT EXISTS `cancelled` (
  `reservationid` bigint(20) NOT NULL,
  `start` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `end` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `roomid` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `timeofrequest` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `timeofcancel` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`reservationid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- --------------------------------------------------------

-- 
-- Table structure for table `deletedrooms`
-- 

CREATE TABLE IF NOT EXISTS `deletedrooms` (
  `roomid` int(11) NOT NULL,
  `roomname` varchar(255) NOT NULL,
  `roomcapacity` int(11) NOT NULL,
  `roomgroupid` bigint(20) NOT NULL,
  `roomdescription` longtext NOT NULL,
  PRIMARY KEY (`roomid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- --------------------------------------------------------

-- 
-- Table structure for table `optionalfields`
-- 

CREATE TABLE IF NOT EXISTS `optionalfields` (
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



-- --------------------------------------------------------

-- 
-- Table structure for table `reporters`
-- 

CREATE TABLE IF NOT EXISTS `reporters` (
  `username` varchar(255) NOT NULL,
  PRIMARY KEY (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



-- --------------------------------------------------------

-- 
-- Table structure for table `reservationoptions`
-- 

CREATE TABLE IF NOT EXISTS `reservationoptions` (
  `optionname` varchar(255) NOT NULL,
  `reservationid` bigint(20) NOT NULL,
  `optionvalue` varchar(700) NOT NULL,
  PRIMARY KEY (`optionname`,`reservationid`),
  KEY `reservationid` (`reservationid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



-- --------------------------------------------------------

-- 
-- Table structure for table `reservations`
-- 

CREATE TABLE IF NOT EXISTS `reservations` (
  `reservationid` bigint(20) NOT NULL AUTO_INCREMENT,
  `start` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `end` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `roomid` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `numberingroup` int(11) NOT NULL,
  `timeofrequest` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`reservationid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=90 ;



-- --------------------------------------------------------

-- 
-- Table structure for table `roomgroups`
-- 

CREATE TABLE IF NOT EXISTS `roomgroups` (
  `roomgroupid` bigint(20) NOT NULL AUTO_INCREMENT,
  `roomgroupname` varchar(255) NOT NULL,
  PRIMARY KEY (`roomgroupid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;



-- --------------------------------------------------------

-- 
-- Table structure for table `roomhours`
-- 

CREATE TABLE IF NOT EXISTS `roomhours` (
  `roomhoursid` bigint(20) NOT NULL AUTO_INCREMENT,
  `roomid` int(11) NOT NULL,
  `dayofweek` smallint(6) NOT NULL,
  `start` time NOT NULL,
  `end` time NOT NULL,
  PRIMARY KEY (`roomhoursid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=298 ;



-- --------------------------------------------------------

-- 
-- Table structure for table `rooms`
-- 

CREATE TABLE IF NOT EXISTS `rooms` (
  `roomid` int(11) NOT NULL AUTO_INCREMENT,
  `roomname` varchar(255) NOT NULL,
  `roomposition` int(11) NOT NULL,
  `roomcapacity` int(11) NOT NULL,
  `roomgroupid` bigint(20) NOT NULL,
  `roomdescription` longtext NOT NULL,
  PRIMARY KEY (`roomid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=28 ;



-- --------------------------------------------------------

-- 
-- Table structure for table `roomspecialhours`
-- 

CREATE TABLE IF NOT EXISTS `roomspecialhours` (
  `roomspecialhoursid` bigint(20) NOT NULL AUTO_INCREMENT,
  `roomid` int(11) NOT NULL,
  `fromrange` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `torange` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `start` time NOT NULL,
  `end` time NOT NULL,
  PRIMARY KEY (`roomspecialhoursid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;



-- --------------------------------------------------------

-- 
-- Table structure for table `settings`
-- 

CREATE TABLE IF NOT EXISTS `settings` (
  `settingname` varchar(255) NOT NULL,
  `settingvalue` longtext NOT NULL,
  PRIMARY KEY (`settingname`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- 
-- Dumping data for table `settings`
-- 

INSERT INTO `settings` (`settingname`, `settingvalue`) VALUES 
('allow_past_reservations', 'false'),
('allow_simultaneous_reservations', 'false'),
('email_can_gef', 'a:1:{i:0;s:0:"";}'),
('email_can_terse', 'a:1:{i:0;s:0:"";}'),
('email_can_verbose', 'a:1:{i:0;s:0:"";}'),
('email_condition', ''),
('email_condition_value', ''),
('email_cond_gef', 'a:1:{i:0;s:0:"";}'),
('email_cond_terse', 'a:1:{i:0;s:0:"";}'),
('email_cond_verbose', 'a:1:{i:0;s:0:"";}'),
('email_filter', 'a:1:{i:0;s:0:"";}'),
('email_res_gef', 'a:1:{i:0;s:0:"";}'),
('email_res_terse', 'a:1:{i:0;s:0:"";}'),
('email_res_verbose', 'a:1:{i:0;s:0:"";}'),
('email_system', ''),
('https', 'true'),
('instance_name', 'OpenRoom'),
('instance_url', ''),
('interval', '30'),
('ldap_baseDN', ''),
('ldap_host', ''),
('limit_duration', '240'),
('limit_frequency', 'a:2:{i:0;s:1:"0";i:1;s:3:"day";}'),
('limit_openingday', ''),
('limit_total', 'a:2:{i:0;s:3:"240";i:1;s:3:"day";}'),
('limit_window', 'a:2:{i:0;i:0;i:1;s:8:"7/1/2010";}'),
('login_method', 'normal'),
('policies', ''),
('remindermessage', ''),
('systemid', '0000000001'),
('theme', 'default'),
('time_format', 'g:i a');

-- --------------------------------------------------------

-- 
-- Table structure for table `users`
-- 

CREATE TABLE IF NOT EXISTS `users` (
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `lastlogin` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `active` varchar(255) NOT NULL DEFAULT '0',
  PRIMARY KEY (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

