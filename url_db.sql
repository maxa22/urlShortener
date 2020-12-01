-- --------------------------------------------------------
-- Host:                         localhost
-- Server version:               5.7.24 - MySQL Community Server (GPL)
-- Server OS:                    Win64
-- HeidiSQL Version:             10.2.0.5599
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Dumping structure for table url_db.count_data
CREATE TABLE IF NOT EXISTS `count_data` (
  `countId` int(11) NOT NULL AUTO_INCREMENT,
  `clickCount` int(11) NOT NULL DEFAULT '0',
  `id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`countId`),
  KEY `id` (`id`),
  CONSTRAINT `id` FOREIGN KEY (`id`) REFERENCES `url_data` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table url_db.count_data: ~0 rows (approximately)
/*!40000 ALTER TABLE `count_data` DISABLE KEYS */;
/*!40000 ALTER TABLE `count_data` ENABLE KEYS */;

-- Dumping structure for table url_db.url_data
CREATE TABLE IF NOT EXISTS `url_data` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `initialUrl` varchar(250) NOT NULL DEFAULT '0',
  `shortenedUrl` varchar(250) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table url_db.url_data: ~0 rows (approximately)
/*!40000 ALTER TABLE `url_data` DISABLE KEYS */;
/*!40000 ALTER TABLE `url_data` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
