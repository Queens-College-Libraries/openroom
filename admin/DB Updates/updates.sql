
--specify start time and end time for app
INSERT INTO `settings` (`settingname`, `settingvalue`) VALUES ('starttime', '');
INSERT INTO `settings` (`settingname`, `settingvalue`) VALUES ('endtime', '');

--adds phone number field
INSERT INTO `settings` (`settingname`, `settingvalue`) VALUES ('phone_number', '');

--room capacity max and min
ALTER TABLE `rooms` ADD `roomcapacitymin` INT(11) NOT NULL AFTER `roomdescription`, ADD `roomcapacitymax` INT(11) NOT NULL AFTER `roomcapacitymin`;