ALTER TABLE `User` ADD `admin` TINYINT NOT NULL DEFAULT '0' AFTER `authKey`;
ALTER TABLE `Character` ADD `intelligence` TINYINT NOT NULL AFTER `endurance`;
ALTER TABLE `Character` ADD `perception` TINYINT NOT NULL AFTER `intelligence`;
ALTER TABLE `Character` ADD `stat1` TINYINT NOT NULL AFTER `perception`;
ALTER TABLE `Character` ADD `stat2` TINYINT NOT NULL AFTER `stat1`;
ALTER TABLE `Character` ADD `stat3` TINYINT NOT NULL AFTER `stat2`;
ALTER TABLE `Character` ADD `will` TINYINT NOT NULL AFTER `stat3`;
