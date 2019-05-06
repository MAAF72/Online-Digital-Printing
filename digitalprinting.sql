-- --------------------------------------------------------
-- Host:                         localhost
-- Server version:               5.7.24 - MySQL Community Server (GPL)
-- Server OS:                    Win64
-- HeidiSQL Version:             9.5.0.5332
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Dumping database structure for digitalprinting
CREATE DATABASE IF NOT EXISTS `digitalprinting` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `digitalprinting`;

-- Dumping structure for table digitalprinting.dp_order
CREATE TABLE IF NOT EXISTS `dp_order` (
  `ID` int(255) NOT NULL AUTO_INCREMENT,
  `Code` varchar(10) NOT NULL,
  `Name` varchar(30) NOT NULL,
  `Email` varchar(50) NOT NULL,
  `Phone` varchar(15) NOT NULL,
  `Address` text NOT NULL,
  `File` varchar(100) NOT NULL,
  `Size` char(2) NOT NULL,
  `Type` char(5) NOT NULL,
  `Quantity` int(5) NOT NULL DEFAULT '1',
  `Note` text NOT NULL,
  `Charge` int(255) NOT NULL,
  `Status` char(1) NOT NULL DEFAULT '0',
  `DateCreated` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `DateEstimate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `Code` (`Code`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=latin1;

-- Dumping data for table digitalprinting.dp_order: ~1 rows (approximately)
/*!40000 ALTER TABLE `dp_order` DISABLE KEYS */;
INSERT INTO `dp_order` (`ID`, `Code`, `Name`, `Email`, `Phone`, `Address`, `File`, `Size`, `Type`, `Quantity`, `Note`, `Charge`, `Status`, `DateCreated`, `DateEstimate`) VALUES
	(17, 'E7C5BD8F88', 'Muhammad Abdurrohman Al Fatih', 'abdurrahmanalfatih72@gmail.com', '081295084653', 'Asrama Putra gedung 1 kamar 306', 'Testing.png', 'A3', 'AC230', 12, 'Ini adalah catatan untuk percetakan', 72000, '5', '2019-05-06 21:55:48', '2019-05-06 21:59:27');
/*!40000 ALTER TABLE `dp_order` ENABLE KEYS */;

-- Dumping structure for table digitalprinting.dp_track
CREATE TABLE IF NOT EXISTS `dp_track` (
  `ID` int(255) NOT NULL AUTO_INCREMENT,
  `Code` varchar(50) NOT NULL,
  `Detail` text NOT NULL,
  `DateCreated` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=64 DEFAULT CHARSET=latin1;

-- Dumping data for table digitalprinting.dp_track: ~6 rows (approximately)
/*!40000 ALTER TABLE `dp_track` DISABLE KEYS */;
INSERT INTO `dp_track` (`ID`, `Code`, `Detail`, `DateCreated`) VALUES
	(58, 'E7C5BD8F88', 'Pesanan telah dibayar', '2019-05-06 21:57:27'),
	(59, 'E7C5BD8F88', 'Pesanan masuk antrian', '2019-05-06 21:57:36'),
	(60, 'E7C5BD8F88', 'Pesanan sedang dikerjakan', '2019-05-06 21:57:57'),
	(61, 'E7C5BD8F88', 'Pesanan selesai dicetak', '2019-05-06 21:58:02'),
	(62, 'E7C5BD8F88', 'Pesanan sedang diantar(Kurir : Jony - 081919191919)', '2019-05-06 21:58:26'),
	(63, 'E7C5BD8F88', 'Pesanan diterima', '2019-05-06 21:58:47');
/*!40000 ALTER TABLE `dp_track` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
