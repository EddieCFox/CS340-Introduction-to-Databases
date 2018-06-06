SET FOREIGN_KEY_CHECKS = 0;
DROP TABLE IF EXISTS `era`;
DROP TABLE IF EXISTS `location`;
DROP TABLE IF EXISTS `quest`;
DROP TABLE IF EXISTS `equip_type`;
DROP TABLE IF EXISTS `equipment`;
DROP TABLE IF EXISTS `character`;
DROP TABLE IF EXISTS `tech`;
DROP TABLE IF EXISTS `combo`;
DROP TABLE IF EXISTS `enemy`;
DROP TABLE IF EXISTS `traverses`;
DROP TABLE IF EXISTS `utilizes`;
DROP TABLE IF EXISTS `performs`;
DROP TABLE IF EXISTS `bosses`;
SET FOREIGN_KEY_CHECKS = 1;

-- Eras
CREATE TABLE `era` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`name` varchar(255) NOT NULL,
	`year` varchar(255) DEFAULT NULL,
	PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Locations
CREATE TABLE `location` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`name` varchar(255) NOT NULL,
	`eid` int(11) NOT NULL,
	PRIMARY KEY (`id`),
	KEY `eid` (`eid`),
	CONSTRAINT `location_ibfk_1` FOREIGN KEY (`eid`) REFERENCES `era` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Quests
CREATE TABLE `quest` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`name` varchar(255) NOT NULL,
	`objective` text,
	PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Equipment Types
CREATE TABLE `equip_type` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`name` varchar(255) NOT NULL,
	PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Equipment
CREATE TABLE `equipment` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`name` varchar(255) NOT NULL,
	`etid` int(11) NOT NULL,
	`attack` int(11) DEFAULT NULL,
	`defense` int(11) DEFAULT NULL,
	`effect` varchar(255) DEFAULT NULL,
	PRIMARY KEY (`id`),
	KEY `etid` (`etid`),
	CONSTRAINT `equipment_ibfk_1` FOREIGN KEY (`etid`) REFERENCES `equip_type` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Characters
CREATE TABLE `character` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`name` varchar(255) NOT NULL,
	`eid` int(11) NOT NULL,
	`etid` int(11) NOT NULL,
	`element` varchar(255) NOT NULL,
	PRIMARY KEY (`id`),
	KEY `eid` (`eid`),
	KEY `etid` (`etid`),
	CONSTRAINT `character_ibfk_1` FOREIGN KEY (`eid`) REFERENCES `era` (`id`),
	CONSTRAINT `character_ibfk_2` FOREIGN KEY (`etid`) REFERENCES `equip_type` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Techniques
CREATE TABLE `tech` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`name` varchar(255) NOT NULL,
	`magic_cost` int(11),
	`tech_points` int(11),
	`targets` varchar(255),
	`description` text,
	PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Combination Techniques
CREATE TABLE `combo` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`name` varchar(255) NOT NULL,
	`tid_1` int(11) NOT NULL,
	`tid_2` int(11) NOT NULL,
	`tid_3` int(11) DEFAULT NULL,
	`targets` varchar(255) DEFAULT NULL,
	`description` text,
	PRIMARY KEY (`id`),
	KEY `tid_1` (`tid_1`),
	KEY `tid_2` (`tid_2`),
	KEY `tid_3` (`tid_3`),
	CONSTRAINT `combo_ibfk_1` FOREIGN KEY (`tid_1`) REFERENCES `tech` (`id`),
	CONSTRAINT `combo_ibfk_2` FOREIGN KEY (`tid_2`) REFERENCES `tech` (`id`),
	CONSTRAINT `combo_ibfk_3` FOREIGN KEY (`tid_3`) REFERENCES `tech` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Enemies and Bosses
CREATE TABLE `enemy` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`name` varchar(255) NOT NULL,
	`lid` int(11) NOT NULL,
	`health` int(11) DEFAULT NULL,
	`defense` int(11) DEFAULT NULL,
	`magic_defense` int(11) DEFAULT NULL,
	`tech_value` int(11) DEFAULT NULL,
	PRIMARY KEY (`id`),
	KEY `lid` (`lid`),
	CONSTRAINT `enemy_ibfk_1` FOREIGN KEY (`lid`) REFERENCES `location` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Quests Traverse Locations
CREATE TABLE `traverses` (
	`qid` int(11) NOT NULL DEFAULT '0',
	`lid` int(11) NOT NULL DEFAULT '0',
	PRIMARY KEY (`qid`,`lid`),
	KEY `lid` (`lid`),
	CONSTRAINT `traverses_ibfk_1` FOREIGN KEY (`qid`) REFERENCES `quest` (`id`),
	CONSTRAINT `traverses_ibfk_2` FOREIGN KEY (`lid`) REFERENCES `location` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Characters Utilize Equipment
CREATE TABLE `utilizes` (
	`cid` int(11) NOT NULL DEFAULT '0',
	`eqid` int(11) NOT NULL DEFAULT '0',
	PRIMARY KEY (`cid`,`eqid`),
	KEY `eqid` (`eqid`),
	CONSTRAINT `utilizes_ibfk_1` FOREIGN KEY (`cid`) REFERENCES `character` (`id`),
	CONSTRAINT `utilizes_ibfk_2` FOREIGN KEY (`eqid`) REFERENCES `equipment` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Characters Perform Techniques
CREATE TABLE `performs` (
	`cid` int(11) NOT NULL DEFAULT '0',
	`tid` int(11) NOT NULL DEFAULT '0',
	PRIMARY KEY (`cid`,`tid`),
	KEY `tid` (`tid`),
	CONSTRAINT `performs_ibfk_1` FOREIGN KEY (`cid`) REFERENCES `character` (`id`),
	CONSTRAINT `performs_ibfk_2` FOREIGN KEY (`tid`) REFERENCES `tech` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Enemies Boss Quests
CREATE TABLE `bosses` (
	`enid` int(11) NOT NULL DEFAULT '0',
	`qid` int(11) NOT NULL DEFAULT '0',
	PRIMARY KEY (`enid`,`qid`),
	KEY `qid` (`qid`),
	CONSTRAINT `bosses_ibfk_1` FOREIGN KEY (`enid`) REFERENCES `enemy` (`id`),
	CONSTRAINT `bosses_ibfk_2` FOREIGN KEY (`qid`) REFERENCES `quest` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;