# ************************************************************
# Sequel Pro SQL dump
# Version 4541
#
# http://www.sequelpro.com/
# https://github.com/sequelpro/sequelpro
#
# Host: localhost (MySQL 5.6.26)
# Database: magic
# Generation Time: 2017-12-12 05:32:41 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table locations
# ------------------------------------------------------------

DROP TABLE IF EXISTS `locations`;

CREATE TABLE `locations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `type` enum('store','office','kitchen') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'store',
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `shortName` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `city` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL,
  `province` varchar(2) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(16) COLLATE utf8mb4_unicode_ci NOT NULL,
  `post` varchar(16) COLLATE utf8mb4_unicode_ci NOT NULL,
  `open` time DEFAULT NULL,
  `close` time DEFAULT NULL,
  `openMorning` time DEFAULT NULL,
  `endMorning` time DEFAULT NULL,
  `endClose` time DEFAULT NULL,
  `lunchStart` time DEFAULT NULL,
  `lunchEnd` time DEFAULT NULL,
  `dinnerStart` time DEFAULT NULL,
  `dinnerEnd` time DEFAULT NULL,
  `nightStart` time DEFAULT NULL,
  `nightEnd` time DEFAULT NULL,
  `manager_id` int(11) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `locations` WRITE;
/*!40000 ALTER TABLE `locations` DISABLE KEYS */;

INSERT INTO `locations` (`id`, `type`, `name`, `shortName`, `address`, `city`, `province`, `phone`, `post`, `open`, `close`, `openMorning`, `endMorning`, `endClose`, `lunchStart`, `lunchEnd`, `dinnerStart`, `dinnerEnd`, `nightStart`, `nightEnd`, `manager_id`, `created_at`, `updated_at`)
VALUES
	(0,'kitchen','中央厨房','央厨','686 Denison St.','Markham','ON','905-513-9989','L3R 1C1','09:00:00','21:00:00',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL),
	(1,'store','士嘉堡店 ','1店','2190 McNicoll Ave. Unit 119','Scarborough','ON','416-293-6696','M1V 0VB',NULL,NULL,'08:00:00','12:00:00','03:00:00','11:30:00','14:30:00','18:00:00','21:00:00','00:00:00','03:00:00',56,NULL,NULL),
	(2,'store','列治文山店','2店','1383 16th Ave. Unit D','Richmond Hill','ON','905-889-9886','L4B 1J3','11:00:00','01:00:00','10:00:00','12:00:00','01:00:00','11:30:00','14:30:00','18:00:00','21:00:00','00:00:00','01:00:00',88,NULL,NULL),
	(3,'store','Downtown店','3店','93 Harbord St.','Toronto','ON','647-345-8839','M5S 1G4','11:00:00','23:00:00','10:00:00','12:00:00','23:00:00','11:30:00','14:30:00','18:00:00','21:00:00',NULL,NULL,395,NULL,NULL),
	(4,'store','北约克店','4店','5453 Yonge St.','Toronto','ON','416-546-9686','M2N 5S1',NULL,NULL,'08:00:00','12:00:00','03:00:00','11:30:00','14:30:00','18:00:00','21:00:00','00:00:00','03:00:00',59,NULL,NULL),
	(9,'office','Head Office','本部','686 Denison St.','Markham','ON','905-513-9989','L3R 1C1',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,12,NULL,NULL);

/*!40000 ALTER TABLE `locations` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
