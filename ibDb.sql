-- Adminer 4.2.2 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP TABLE IF EXISTS `calendar`;
CREATE TABLE `calendar` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `location_id` int(11) NOT NULL,
  `date` datetime NOT NULL COMMENT 'Date',
  `title` text NOT NULL COMMENT 'Value',
  `link` text NOT NULL,
  `location_name` text NOT NULL,
  `event_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `location_id` (`location_id`),
  KEY `event_id` (`event_id`),
  CONSTRAINT `calendar_ibfk_2` FOREIGN KEY (`event_id`) REFERENCES `events` (`id`),
  CONSTRAINT `calendar_ibfk_1` FOREIGN KEY (`location_id`) REFERENCES `locations` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `calendar` (`id`, `location_id`, `date`, `title`, `link`, `location_name`, `event_id`) VALUES
(35,	199,	'2016-03-02 01:03:00',	'item1',	'link',	'location1',	247),
(36,	199,	'2016-03-16 01:01:00',	'itemName222',	'sad',	'location1',	247),
(37,	201,	'2016-03-10 04:02:00',	'newLastItasd',	'asd',	'loc1',	247),
(38,	199,	'2016-03-09 01:02:00',	'itemName',	'sad',	'location1',	247),
(39,	201,	'2016-03-19 02:03:00',	'itemName',	'linkItem',	'loc1',	248),
(40,	200,	'2016-03-12 03:03:00',	'asd',	'sad',	'location2',	247),
(41,	199,	'2016-03-09 00:00:00',	'sda',	'das',	'location1',	247),
(42,	200,	'2016-03-09 05:00:00',	'last',	'sad',	'location2',	247);

DROP TABLE IF EXISTS `events`;
CREATE TABLE `events` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `event_name` varchar(50) NOT NULL,
  `mapImgLink` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `events` (`id`, `event_name`, `mapImgLink`) VALUES
(247,	'firstEvent',	'http://ibeaconserver/backend/maps/testMap.jpg'),
(248,	'EventTwo',	'http://ibeaconserver/backend/maps/testMap.jpg');

DROP TABLE IF EXISTS `items`;
CREATE TABLE `items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_location` int(11) NOT NULL,
  `title` varchar(50) NOT NULL,
  `date` varchar(50) NOT NULL,
  `link` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_location` (`id_location`),
  CONSTRAINT `items_ibfk_2` FOREIGN KEY (`id_location`) REFERENCES `locations` (`id`),
  CONSTRAINT `items_ibfk_1` FOREIGN KEY (`id_location`) REFERENCES `locations` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `locations`;
CREATE TABLE `locations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `event_id` int(11) NOT NULL,
  `name` varchar(25) NOT NULL,
  `crd_north` varchar(25) NOT NULL,
  `crd_south` varchar(25) NOT NULL,
  `crd_east` varchar(25) NOT NULL,
  `crd_west` varchar(25) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `event_id` (`event_id`),
  CONSTRAINT `locations_ibfk_1` FOREIGN KEY (`event_id`) REFERENCES `events` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `locations` (`id`, `event_id`, `name`, `crd_north`, `crd_south`, `crd_east`, `crd_west`) VALUES
(199,	247,	'location1',	'84.9754338146497',	'68.97126438517834',	'-60',	'-176.25'),
(200,	247,	'location2',	'-6.481955067266262',	'-85.33169629509908',	'69.375',	'-72.1875'),
(201,	248,	'loc1',	'68.8505805183818',	'-4.748727676882761',	'-60',	'179.53125'),
(202,	248,	'loc2',	'-3.6807918661423003',	'-85.33169629509908',	'-179.53125',	'67.03125');

DROP TABLE IF EXISTS `migration`;
CREATE TABLE `migration` (
  `version` varchar(180) NOT NULL,
  `apply_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `migration` (`version`, `apply_time`) VALUES
('m000000_000000_base',	1457519222),
('m130524_201442_init',	1457519225);

DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `auth_key` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `password_hash` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password_reset_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` smallint(6) NOT NULL DEFAULT '10',
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `password_reset_token` (`password_reset_token`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `user` (`id`, `username`, `auth_key`, `password_hash`, `password_reset_token`, `email`, `status`, `created_at`, `updated_at`) VALUES
(1,	'admin',	'OxyL-3XlFDhEVjBnjynnNZ3Q8fY02b_x',	'$2y$13$U0VdAatvmO0rCJhuBeO3j.kZF.58hTWiFtf7RcMM83Mz6.egC.R4u',	NULL,	'admin@admin.com',	10,	1457519270,	1457519270);

-- 2016-03-16 14:30:07
