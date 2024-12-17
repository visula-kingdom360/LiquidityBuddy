-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               10.4.32-MariaDB - mariadb.org binary distribution
-- Server OS:                    Win64
-- HeidiSQL Version:             12.5.0.6677
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for liquiditybuddy
CREATE DATABASE IF NOT EXISTS `liquiditybuddy` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci */;
USE `liquiditybuddy`;

-- Dumping structure for table liquiditybuddy.account
CREATE TABLE IF NOT EXISTS `account` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sessionid` char(32) DEFAULT NULL,
  `name` varchar(50) DEFAULT NULL,
  `currentbalance` decimal(15,2) DEFAULT NULL,
  `createddatetime` int(11) DEFAULT NULL,
  `updateddatetime` int(11) DEFAULT NULL,
  `status` char(1) DEFAULT 'A',
  `usersessionid` char(32) DEFAULT NULL,
  `accountgroupid` char(32) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `sessionid` (`sessionid`),
  KEY `FK_account_user` (`usersessionid`),
  KEY `FK_account_accountgroup` (`accountgroupid`),
  CONSTRAINT `FK_account_accountgroup` FOREIGN KEY (`accountgroupid`) REFERENCES `accountgroup` (`sessionid`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `FK_account_user` FOREIGN KEY (`usersessionid`) REFERENCES `user` (`sessionid`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=80 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table liquiditybuddy.account: ~9 rows (approximately)
INSERT INTO `account` (`id`, `sessionid`, `name`, `currentbalance`, `createddatetime`, `updateddatetime`, `status`, `usersessionid`, `accountgroupid`) VALUES
	(2, '2d55834ae87ee76927f9783f249d901f', 'Cash in Hand', 870.00, NULL, NULL, 'A', '01b9ff2b173400203b74b4cbec306d6f', NULL),
	(4, '42853ec7ccebc2c04f3340c8b6c74d36', 'Sampath: Day to Day', 3141.57, NULL, NULL, 'A', '01b9ff2b173400203b74b4cbec306d6f', NULL),
	(5, '9fe7b9332f333ceae7f66c3d527651eb', 'Sampath: Standby', 682.10, NULL, NULL, 'A', '01b9ff2b173400203b74b4cbec306d6f', NULL),
	(6, '46ab23b6a8f8b3e67384006d7d84c540', 'Sampath: WE[Weekly Expenses] Handler', 0.00, NULL, NULL, 'A', '01b9ff2b173400203b74b4cbec306d6f', NULL),
	(7, '7d27840e1d1eef658dc483e820018980', 'Sampath: Saving', 0.00, NULL, NULL, 'A', '01b9ff2b173400203b74b4cbec306d6f', NULL),
	(8, '33a8f967f60fc39c83086831b11a6954', 'Sampath: Credit Card', 0.00, NULL, NULL, 'A', '01b9ff2b173400203b74b4cbec306d6f', NULL),
	(9, '90b3dc20e33d14ee2694c10b5f0814cf', 'Sampath: Trip Planning', 457.55, NULL, NULL, 'A', '01b9ff2b173400203b74b4cbec306d6f', NULL),
	(10, 'fe9ba415224b47f64a965717be29e4ce', 'Combank: Credit Card', 0.00, NULL, NULL, 'A', '01b9ff2b173400203b74b4cbec306d6f', NULL),
	(11, '7c017a7315f5d8f206b7c7b2bd16149f', 'Combank: Debit Account', 515.06, NULL, NULL, 'A', '01b9ff2b173400203b74b4cbec306d6f', NULL),
	(76, '5d584e6efe032ac132455fc222cc6a67', 'New Account', 2350.00, NULL, NULL, 'A', '01b9ff2b173400203b74b4cbec306d6f', '4dc766e2ab06bf1ca502318e70381e19'),
	(77, 'a59e19c63e9c08aa630885ef7fd4ce84', 'New Accoutn', 2323.00, NULL, NULL, 'A', '01b9ff2b173400203b74b4cbec306d6f', '4dc766e2ab06bf1ca502318e70381e19'),
	(78, '280a4a9e7339985e209aaf94643b5423', 'New Card', 2000.00, NULL, NULL, 'A', '01b9ff2b173400203b74b4cbec306d6f', '5ff26682c81055c0e34a4a41824bc979'),
	(79, 'a0c70d0ed2cc0870ffa4e318a3fd6c70', 'Credit Card', 250000.00, NULL, NULL, 'A', '01b9ff2b173400203b74b4cbec306d6f', '5ff26682c81055c0e34a4a41824bc979');

-- Dumping structure for table liquiditybuddy.accountgroup
CREATE TABLE IF NOT EXISTS `accountgroup` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sessionid` char(32) NOT NULL,
  `name` varchar(50) DEFAULT NULL,
  `status` varchar(50) DEFAULT 'A',
  `usersessionid` char(32) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `sessionid` (`sessionid`),
  KEY `FK_accountgroup_user` (`usersessionid`),
  CONSTRAINT `FK_accountgroup_user` FOREIGN KEY (`usersessionid`) REFERENCES `user` (`sessionid`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table liquiditybuddy.accountgroup: ~3 rows (approximately)
INSERT INTO `accountgroup` (`id`, `sessionid`, `name`, `status`, `usersessionid`) VALUES
	(1, '4dc766e2ab06bf1ca502318e70381e19', 'Cash', 'A', '01b9ff2b173400203b74b4cbec306d6f'),
	(2, '5ff26682c81055c0e34a4a41824bc979', 'Card', 'A', '01b9ff2b173400203b74b4cbec306d6f'),
	(3, '9b8d200c4bc82247422a0f1df78addfd', 'Account', 'A', '01b9ff2b173400203b74b4cbec306d6f');

-- Dumping structure for table liquiditybuddy.borrowed
CREATE TABLE IF NOT EXISTS `borrowed` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sessionid` char(32) DEFAULT NULL,
  `stackholdersessionid` char(32) DEFAULT NULL,
  `amount` decimal(15,2) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `paiddate` date DEFAULT NULL,
  `expected` date DEFAULT NULL,
  `createddatetime` int(11) DEFAULT NULL,
  `updateddatetime` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_travel_stackholder` (`stackholdersessionid`),
  CONSTRAINT `FK_travel_stackholder` FOREIGN KEY (`stackholdersessionid`) REFERENCES `stackholder` (`sessionid`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table liquiditybuddy.borrowed: ~0 rows (approximately)

-- Dumping structure for table liquiditybuddy.budget
CREATE TABLE IF NOT EXISTS `budget` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sessionid` char(32) DEFAULT NULL,
  `name` varchar(50) DEFAULT NULL,
  `periodic` enum('D','W','M','Q','H','Y') DEFAULT NULL,
  `createddatetime` int(11) DEFAULT NULL,
  `updateddatetime` int(11) DEFAULT NULL,
  `amount` decimal(15,2) DEFAULT NULL,
  `status` char(1) DEFAULT 'A',
  `usersessionid` char(32) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `sessionid` (`sessionid`),
  KEY `FK_budget_user` (`usersessionid`),
  CONSTRAINT `FK_budget_user` FOREIGN KEY (`usersessionid`) REFERENCES `user` (`sessionid`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table liquiditybuddy.budget: ~2 rows (approximately)
INSERT INTO `budget` (`id`, `sessionid`, `name`, `periodic`, `createddatetime`, `updateddatetime`, `amount`, `status`, `usersessionid`) VALUES
	(1, 'bdf37ae18f8955dd0a0d4c13c70b5013', 'Default', 'W', NULL, NULL, 261673.00, 'A', '01b9ff2b173400203b74b4cbec306d6f'),
	(2, '472944cd9f1577b490cd753628f02566', 'Monthly Expenses', 'M', NULL, NULL, 20000.00, 'A', '01b9ff2b173400203b74b4cbec306d6f');

-- Dumping structure for table liquiditybuddy.claim
CREATE TABLE IF NOT EXISTS `claim` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `stackholdersessionid` char(32) NOT NULL,
  `paymentplansessionid` char(32) NOT NULL,
  `rate` decimal(5,2) NOT NULL DEFAULT 0.00,
  `starteddate` date NOT NULL,
  `endate` date NOT NULL,
  `amount` decimal(15,2) NOT NULL DEFAULT 0.00,
  `createddatetime` int(11) NOT NULL,
  `updateddatetime` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_claim_new_stackholder` (`stackholdersessionid`),
  KEY `FK_claim_new_paymentplan` (`paymentplansessionid`),
  CONSTRAINT `FK_claim_new_paymentplan` FOREIGN KEY (`paymentplansessionid`) REFERENCES `paymentplan` (`sessionid`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `FK_claim_new_stackholder` FOREIGN KEY (`stackholdersessionid`) REFERENCES `stackholder` (`sessionid`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table liquiditybuddy.claim: ~0 rows (approximately)

-- Dumping structure for table liquiditybuddy.collectiondue
CREATE TABLE IF NOT EXISTS `collectiondue` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sessionid` char(32) NOT NULL,
  `collectionplansessionid` char(32) NOT NULL DEFAULT '',
  `stackholdersessionid` char(32) NOT NULL DEFAULT '',
  `payable` decimal(15,2) NOT NULL DEFAULT 0.00,
  `date` date NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `sessionidid` (`sessionid`) USING BTREE,
  KEY `FK_collectiondue_collectionplan` (`collectionplansessionid`),
  KEY `FK_collectiondue_stackholder` (`stackholdersessionid`),
  CONSTRAINT `FK_collectiondue_collectionplan` FOREIGN KEY (`collectionplansessionid`) REFERENCES `collectionplan` (`sessionid`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `FK_collectiondue_stackholder` FOREIGN KEY (`stackholdersessionid`) REFERENCES `stackholder` (`sessionid`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table liquiditybuddy.collectiondue: ~0 rows (approximately)

-- Dumping structure for table liquiditybuddy.collectionpaid
CREATE TABLE IF NOT EXISTS `collectionpaid` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sessionid` char(32) DEFAULT NULL,
  `collectionduesessionid` char(32) DEFAULT NULL,
  `stackholdersessionid` char(32) DEFAULT NULL,
  `payable` decimal(15,2) DEFAULT NULL,
  `date` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `sessionid` (`sessionid`),
  KEY `FK__stackholder` (`stackholdersessionid`),
  KEY `FK__collectionplan` (`collectionduesessionid`) USING BTREE,
  CONSTRAINT `FK__stackholder` FOREIGN KEY (`stackholdersessionid`) REFERENCES `stackholder` (`sessionid`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `FK_collectionpaid_collectiondue` FOREIGN KEY (`collectionduesessionid`) REFERENCES `collectiondue` (`sessionid`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table liquiditybuddy.collectionpaid: ~0 rows (approximately)

-- Dumping structure for table liquiditybuddy.collectionplan
CREATE TABLE IF NOT EXISTS `collectionplan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sessionid` char(32) NOT NULL,
  `collectedamount` decimal(15,2) NOT NULL DEFAULT 0.00,
  `totalamount` decimal(15,2) NOT NULL DEFAULT 0.00,
  `reason` varchar(50) NOT NULL,
  `is_planned` enum('Y','N') NOT NULL DEFAULT 'N',
  `is_individual` enum('Y','N') NOT NULL DEFAULT 'Y',
  `type` enum('O','D','W','M','Q','H','Y') NOT NULL DEFAULT 'O' COMMENT '''One Time'',''Day'',''Weekly'',''Monthly'',''Quarterly'',''Halfly'',''Year''',
  `period` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `sessionid` (`sessionid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table liquiditybuddy.collectionplan: ~0 rows (approximately)

-- Dumping structure for table liquiditybuddy.groupcollection
CREATE TABLE IF NOT EXISTS `groupcollection` (
  `id` int(11) NOT NULL,
  `sessionid` char(32) DEFAULT NULL,
  `is_collector` enum('Y','N') DEFAULT 'Y',
  `participentcount` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `sessionid` (`sessionid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table liquiditybuddy.groupcollection: ~0 rows (approximately)

-- Dumping structure for table liquiditybuddy.item
CREATE TABLE IF NOT EXISTS `item` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `purchasesessionid` char(32) NOT NULL,
  `name` varchar(50) DEFAULT NULL,
  `description` varchar(50) DEFAULT NULL,
  `units` decimal(20,6) DEFAULT NULL,
  `unitprice` decimal(15,2) DEFAULT NULL,
  `originalprice` varchar(50) DEFAULT NULL,
  `discountamount` decimal(15,2) DEFAULT NULL,
  `finalprice` decimal(15,2) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_item_purchase` (`purchasesessionid`),
  CONSTRAINT `FK_item_purchase` FOREIGN KEY (`purchasesessionid`) REFERENCES `purchase` (`sessionid`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=119 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table liquiditybuddy.item: ~116 rows (approximately)
INSERT INTO `item` (`id`, `purchasesessionid`, `name`, `description`, `units`, `unitprice`, `originalprice`, `discountamount`, `finalprice`) VALUES
	(1, '0091c8dd01fbef228d614ffa88dc58c2', 'Chocalate Icecream', '(Chocalate Icecream * 10)', 10.000000, 200.00, '2000', 500.00, 1500.00),
	(2, '0091c8dd01fbef228d614ffa88dc58c2', 'Vanila Icecream', '(Vanila Icecream * 5)', 5.000000, 250.00, '1250', 200.00, 1050.00),
	(3, '0091c8dd01fbef228d614ffa88dc58c2', 'Mango Icecream', '(Mango Icecream * 1)', 1.000000, 450.00, '450', 0.00, 450.00),
	(4, '5a6851fa6563747bd7da544e5911c5bf', 'Chocalate Icecream', '(Chocalate Icecream * 10)', 10.000000, 200.00, '2000', 500.00, 1500.00),
	(5, '5a6851fa6563747bd7da544e5911c5bf', 'Vanila Icecream', '(Vanila Icecream * 5)', 5.000000, 250.00, '1250', 200.00, 1050.00),
	(6, '5a6851fa6563747bd7da544e5911c5bf', 'Mango Icecream', '(Mango Icecream * 1)', 1.000000, 450.00, '450', 0.00, 450.00),
	(7, '015156fca37602724e09bc1120c59ef7', 'Chocalate Icecream', '(Chocalate Icecream * 10)', 10.000000, 200.00, '2000', 500.00, 1500.00),
	(8, '015156fca37602724e09bc1120c59ef7', 'Vanila Icecream', '(Vanila Icecream * 5)', 5.000000, 250.00, '1250', 200.00, 1050.00),
	(9, '015156fca37602724e09bc1120c59ef7', 'Mango Icecream', '(Mango Icecream * 1)', 1.000000, 450.00, '450', 0.00, 450.00),
	(10, '26ecd97c4f2be348a91f01a7d2e008e9', 'Chocalate Icecream', '(Chocalate Icecream * 10)', 10.000000, 200.00, '2000', 500.00, 1500.00),
	(11, '26ecd97c4f2be348a91f01a7d2e008e9', 'Vanila Icecream', '(Vanila Icecream * 5)', 5.000000, 250.00, '1250', 200.00, 1050.00),
	(12, '26ecd97c4f2be348a91f01a7d2e008e9', 'Mango Icecream', '(Mango Icecream * 1)', 1.000000, 450.00, '450', 0.00, 450.00),
	(13, 'd4c546fd2ef393d21e1cebf887e608a4', 'Chocalate Icecream', '(Chocalate Icecream * 10)', 10.000000, 200.00, '2000', 500.00, 1500.00),
	(14, 'd4c546fd2ef393d21e1cebf887e608a4', 'Vanila Icecream', '(Vanila Icecream * 5)', 5.000000, 250.00, '1250', 200.00, 1050.00),
	(15, 'd4c546fd2ef393d21e1cebf887e608a4', 'Mango Icecream', '(Mango Icecream * 1)', 1.000000, 450.00, '450', 0.00, 450.00),
	(16, '248f661d6472c7d4e1e9e311b70a99a0', 'Chocalate Icecream', '(Chocalate Icecream * 10)', 10.000000, 200.00, '2000', 500.00, 1500.00),
	(17, '248f661d6472c7d4e1e9e311b70a99a0', 'Vanila Icecream', '(Vanila Icecream * 5)', 5.000000, 250.00, '1250', 200.00, 1050.00),
	(18, '248f661d6472c7d4e1e9e311b70a99a0', 'Mango Icecream', '(Mango Icecream * 1)', 1.000000, 450.00, '450', 0.00, 450.00),
	(19, '920fc5c8ca587221cd776b661d036043', 'Chocalate Icecream', '(Chocalate Icecream * 10)', 10.000000, 200.00, '2000', 500.00, 1500.00),
	(20, '920fc5c8ca587221cd776b661d036043', 'Vanila Icecream', '(Vanila Icecream * 5)', 5.000000, 250.00, '1250', 200.00, 1050.00),
	(21, '920fc5c8ca587221cd776b661d036043', 'Mango Icecream', '(Mango Icecream * 1)', 1.000000, 450.00, '450', 0.00, 450.00),
	(22, 'ff5e5000753bb49f87b16e2be0e3ec92', 'Chocalate Icecream', '(Chocalate Icecream * 10)', 10.000000, 200.00, '2000', 500.00, 1500.00),
	(23, 'ff5e5000753bb49f87b16e2be0e3ec92', 'Vanila Icecream', '(Vanila Icecream * 5)', 5.000000, 250.00, '1250', 200.00, 1050.00),
	(24, 'ff5e5000753bb49f87b16e2be0e3ec92', 'Mango Icecream', '(Mango Icecream * 1)', 1.000000, 450.00, '450', 0.00, 450.00),
	(25, '9d6ea68d0cd1daafe2189ab2e47e6aad', 'Chocalate Icecream', '(Chocalate Icecream * 10)', 10.000000, 200.00, '2000', 500.00, 1500.00),
	(26, '9d6ea68d0cd1daafe2189ab2e47e6aad', 'Vanila Icecream', '(Vanila Icecream * 5)', 5.000000, 250.00, '1250', 200.00, 1050.00),
	(27, '9d6ea68d0cd1daafe2189ab2e47e6aad', 'Mango Icecream', '(Mango Icecream * 1)', 1.000000, 450.00, '450', 0.00, 450.00),
	(28, 'fdd532a34a2c096e77c35c8f8fbba1f4', 'Chocalate Icecream', '(Chocalate Icecream * 10)', 10.000000, 200.00, '2000', 500.00, 1500.00),
	(29, 'fdd532a34a2c096e77c35c8f8fbba1f4', 'Vanila Icecream', '(Vanila Icecream * 5)', 5.000000, 250.00, '1250', 200.00, 1050.00),
	(30, 'fdd532a34a2c096e77c35c8f8fbba1f4', 'Mango Icecream', '(Mango Icecream * 1)', 1.000000, 450.00, '450', 0.00, 450.00),
	(31, '57778294ac949752b3486aa553598cca', 'Chocalate Icecream', '(Chocalate Icecream * 10)', 10.000000, 200.00, '2000', 500.00, 1500.00),
	(32, '57778294ac949752b3486aa553598cca', 'Vanila Icecream', '(Vanila Icecream * 5)', 5.000000, 250.00, '1250', 200.00, 1050.00),
	(33, '57778294ac949752b3486aa553598cca', 'Mango Icecream', '(Mango Icecream * 1)', 1.000000, 450.00, '450', 0.00, 450.00),
	(34, 'de6d434c18388bf0ad13e66518235102', 'Chocalate Icecream', '(Chocalate Icecream * 10)', 10.000000, 200.00, '2000', 500.00, 1500.00),
	(35, 'de6d434c18388bf0ad13e66518235102', 'Vanila Icecream', '(Vanila Icecream * 5)', 5.000000, 250.00, '1250', 200.00, 1050.00),
	(36, 'de6d434c18388bf0ad13e66518235102', 'Mango Icecream', '(Mango Icecream * 1)', 1.000000, 450.00, '450', 0.00, 450.00),
	(37, '8946157af3b62498fc8aa2e27c2a008a', 'Chocalate Icecream', '(Chocalate Icecream * 10)', 10.000000, 200.00, '2000', 500.00, 1500.00),
	(38, '8946157af3b62498fc8aa2e27c2a008a', 'Vanila Icecream', '(Vanila Icecream * 5)', 5.000000, 250.00, '1250', 200.00, 1050.00),
	(39, '8946157af3b62498fc8aa2e27c2a008a', 'Mango Icecream', '(Mango Icecream * 1)', 1.000000, 450.00, '450', 0.00, 450.00),
	(40, '8c4c036d2011889fb74cc2416bd6e638', 'Chocalate Icecream', '(Chocalate Icecream * 10)', 10.000000, 200.00, '2000', 500.00, 1500.00),
	(41, '8c4c036d2011889fb74cc2416bd6e638', 'Vanila Icecream', '(Vanila Icecream * 5)', 5.000000, 250.00, '1250', 200.00, 1050.00),
	(42, '8c4c036d2011889fb74cc2416bd6e638', 'Mango Icecream', '(Mango Icecream * 1)', 1.000000, 450.00, '450', 0.00, 450.00),
	(43, '5c8c62a0b00370d0227d73b66cd92360', 'Chocalate Icecream', '(Chocalate Icecream * 10)', 10.000000, 200.00, '2000', 500.00, 1500.00),
	(44, '5c8c62a0b00370d0227d73b66cd92360', 'Vanila Icecream', '(Vanila Icecream * 5)', 5.000000, 250.00, '1250', 200.00, 1050.00),
	(45, '5c8c62a0b00370d0227d73b66cd92360', 'Mango Icecream', '(Mango Icecream * 1)', 1.000000, 450.00, '450', 0.00, 450.00),
	(46, '8389cfaac1e80b7e516609ca6c369b06', 'Chocalate Icecream', '(Chocalate Icecream * 10)', 10.000000, 200.00, '2000', 500.00, 1500.00),
	(47, '8389cfaac1e80b7e516609ca6c369b06', 'Vanila Icecream', '(Vanila Icecream * 5)', 5.000000, 250.00, '1250', 200.00, 1050.00),
	(48, '8389cfaac1e80b7e516609ca6c369b06', 'Mango Icecream', '(Mango Icecream * 1)', 1.000000, 450.00, '450', 0.00, 450.00),
	(49, 'be0ae05020d8e7470350633e2714e5c7', 'Chocalate Icecream', '(Chocalate Icecream * 10)', 10.000000, 200.00, '2000', 500.00, 1500.00),
	(50, 'be0ae05020d8e7470350633e2714e5c7', 'Vanila Icecream', '(Vanila Icecream * 5)', 5.000000, 250.00, '1250', 200.00, 1050.00),
	(51, 'be0ae05020d8e7470350633e2714e5c7', 'Mango Icecream', '(Mango Icecream * 1)', 1.000000, 450.00, '450', 0.00, 450.00),
	(52, '51c18c92abcaaa08267c8c5d06ed4ed5', 'Chocalate Icecream', '(Chocalate Icecream * 10)', 10.000000, 200.00, '2000', 500.00, 1500.00),
	(53, '51c18c92abcaaa08267c8c5d06ed4ed5', 'Vanila Icecream', '(Vanila Icecream * 5)', 5.000000, 250.00, '1250', 200.00, 1050.00),
	(54, '51c18c92abcaaa08267c8c5d06ed4ed5', 'Mango Icecream', '(Mango Icecream * 1)', 1.000000, 450.00, '450', 0.00, 450.00),
	(55, 'dd10f4ef894d6918d6ba6dd4469c3005', 'Chocalate Icecream', '(Chocalate Icecream * 10)', 10.000000, 200.00, '2000', 500.00, 1500.00),
	(56, 'dd10f4ef894d6918d6ba6dd4469c3005', 'Vanila Icecream', '(Vanila Icecream * 5)', 5.000000, 250.00, '1250', 200.00, 1050.00),
	(57, 'dd10f4ef894d6918d6ba6dd4469c3005', 'Mango Icecream', '(Mango Icecream * 1)', 1.000000, 450.00, '450', 0.00, 450.00),
	(58, '3575cf5aa094f6aa42bf307d8cb938a5', 'Chocalate Icecream', '(Chocalate Icecream * 10)', 10.000000, 200.00, '2000', 500.00, 1500.00),
	(59, '3575cf5aa094f6aa42bf307d8cb938a5', 'Vanila Icecream', '(Vanila Icecream * 5)', 5.000000, 250.00, '1250', 200.00, 1050.00),
	(60, '3575cf5aa094f6aa42bf307d8cb938a5', 'Mango Icecream', '(Mango Icecream * 1)', 1.000000, 450.00, '450', 0.00, 450.00),
	(61, '8d1f8263cf486253dee62888826cffbb', 'Chocalate Icecream', '(Chocalate Icecream * 10)', 10.000000, 200.00, '2000', 500.00, 1500.00),
	(62, '8d1f8263cf486253dee62888826cffbb', 'Vanila Icecream', '(Vanila Icecream * 5)', 5.000000, 250.00, '1250', 200.00, 1050.00),
	(63, '8d1f8263cf486253dee62888826cffbb', 'Mango Icecream', '(Mango Icecream * 1)', 1.000000, 450.00, '450', 0.00, 450.00),
	(64, '62943f36f506a5c422225aae5a9b9d7a', 'Chocalate Icecream', '(Chocalate Icecream * 10)', 10.000000, 200.00, '2000', 500.00, 1500.00),
	(65, '62943f36f506a5c422225aae5a9b9d7a', 'Vanila Icecream', '(Vanila Icecream * 5)', 5.000000, 250.00, '1250', 200.00, 1050.00),
	(66, '62943f36f506a5c422225aae5a9b9d7a', 'Mango Icecream', '(Mango Icecream * 1)', 1.000000, 450.00, '450', 0.00, 450.00),
	(67, 'ec8ea74d59450072489277711049edfd', 'Chocalate Icecream', '(Chocalate Icecream * 10)', 10.000000, 200.00, '2000', 500.00, 1500.00),
	(68, 'ec8ea74d59450072489277711049edfd', 'Vanila Icecream', '(Vanila Icecream * 5)', 5.000000, 250.00, '1250', 200.00, 1050.00),
	(69, 'ec8ea74d59450072489277711049edfd', 'Mango Icecream', '(Mango Icecream * 1)', 1.000000, 450.00, '450', 0.00, 450.00),
	(70, 'a3a7ec0a3bbe6b5bea404bf09debc23b', 'Chocalate Icecream', '(Chocalate Icecream * 10)', 10.000000, 200.00, '2000', 500.00, 1500.00),
	(71, 'a3a7ec0a3bbe6b5bea404bf09debc23b', 'Vanila Icecream', '(Vanila Icecream * 5)', 5.000000, 250.00, '1250', 200.00, 1050.00),
	(72, 'a3a7ec0a3bbe6b5bea404bf09debc23b', 'Mango Icecream', '(Mango Icecream * 1)', 1.000000, 450.00, '450', 0.00, 450.00),
	(73, 'e8d51231b2c91a70e40d02d211031f82', 'Chocalate Icecream', '(Chocalate Icecream * 10)', 10.000000, 200.00, '2000', 500.00, 1500.00),
	(74, 'e8d51231b2c91a70e40d02d211031f82', 'Vanila Icecream', '(Vanila Icecream * 5)', 5.000000, 250.00, '1250', 200.00, 1050.00),
	(75, 'e8d51231b2c91a70e40d02d211031f82', 'Mango Icecream', '(Mango Icecream * 1)', 1.000000, 450.00, '450', 0.00, 450.00),
	(76, '21b1c4a39f210324f88e29bf7ca08f4b', 'Chocalate Icecream', '(Chocalate Icecream * 10)', 10.000000, 200.00, '2000', 500.00, 1500.00),
	(77, '21b1c4a39f210324f88e29bf7ca08f4b', 'Vanila Icecream', '(Vanila Icecream * 5)', 5.000000, 250.00, '1250', 200.00, 1050.00),
	(78, '21b1c4a39f210324f88e29bf7ca08f4b', 'Mango Icecream', '(Mango Icecream * 1)', 1.000000, 450.00, '450', 0.00, 450.00),
	(79, '70573cf5c267cae761464e60dbbe23f2', 'Chocalate Icecream', '(Chocalate Icecream * 10)', 10.000000, 200.00, '2000', 500.00, 1500.00),
	(80, '70573cf5c267cae761464e60dbbe23f2', 'Vanila Icecream', '(Vanila Icecream * 5)', 5.000000, 250.00, '1250', 200.00, 1050.00),
	(81, '70573cf5c267cae761464e60dbbe23f2', 'Mango Icecream', '(Mango Icecream * 1)', 1.000000, 450.00, '450', 0.00, 450.00),
	(82, 'c9f5856703712d3c8f581fbd486fc87d', 'Chocalate Icecream', '(Chocalate Icecream * 10)', 10.000000, 200.00, '2000', 500.00, 1500.00),
	(83, 'c9f5856703712d3c8f581fbd486fc87d', 'Vanila Icecream', '(Vanila Icecream * 5)', 5.000000, 250.00, '1250', 200.00, 1050.00),
	(84, 'c9f5856703712d3c8f581fbd486fc87d', 'Mango Icecream', '(Mango Icecream * 1)', 1.000000, 450.00, '450', 0.00, 450.00),
	(85, '993279212de5db9511f2e2c7a7f1e7df', 'Chocalate Icecream', '(Chocalate Icecream * 10)', 10.000000, 200.00, '2000', 500.00, 1500.00),
	(86, '993279212de5db9511f2e2c7a7f1e7df', 'Vanila Icecream', '(Vanila Icecream * 5)', 5.000000, 250.00, '1250', 200.00, 1050.00),
	(87, '993279212de5db9511f2e2c7a7f1e7df', 'Mango Icecream', '(Mango Icecream * 1)', 1.000000, 450.00, '450', 0.00, 450.00),
	(88, '3410f4a75cec5668aacf32a9226140ed', 'Chocalate Icecream', '(Chocalate Icecream * 10)', 10.000000, 200.00, '2000', 500.00, 1500.00),
	(89, '3410f4a75cec5668aacf32a9226140ed', 'Vanila Icecream', '(Vanila Icecream * 5)', 5.000000, 250.00, '1250', 200.00, 1050.00),
	(90, '3410f4a75cec5668aacf32a9226140ed', 'Mango Icecream', '(Mango Icecream * 1)', 1.000000, 450.00, '450', 0.00, 450.00),
	(91, '81e681a15d7532be252e53b289594431', 'Chocalate Icecream', '(Chocalate Icecream * 10)', 10.000000, 200.00, '2000', 500.00, 1500.00),
	(92, '81e681a15d7532be252e53b289594431', 'Vanila Icecream', '(Vanila Icecream * 5)', 5.000000, 250.00, '1250', 200.00, 1050.00),
	(93, '81e681a15d7532be252e53b289594431', 'Mango Icecream', '(Mango Icecream * 1)', 1.000000, 450.00, '450', 0.00, 450.00),
	(94, 'b1127334c9a9e66e4d1159988e289908', 'Chocalate Icecream', '(Chocalate Icecream * 10)', 10.000000, 200.00, '2000', 500.00, 1500.00),
	(95, 'b1127334c9a9e66e4d1159988e289908', 'Vanila Icecream', '(Vanila Icecream * 5)', 5.000000, 250.00, '1250', 200.00, 1050.00),
	(96, 'b1127334c9a9e66e4d1159988e289908', 'Mango Icecream', '(Mango Icecream * 1)', 1.000000, 450.00, '450', 0.00, 450.00),
	(97, '6377288917d76d89a928f86bb5f75945', 'Chocalate Icecream', '(Chocalate Icecream * 10)', 10.000000, 200.00, '2000', 500.00, 1500.00),
	(98, '6377288917d76d89a928f86bb5f75945', 'Vanila Icecream', '(Vanila Icecream * 5)', 5.000000, 250.00, '1250', 200.00, 1050.00),
	(99, '6377288917d76d89a928f86bb5f75945', 'Mango Icecream', '(Mango Icecream * 1)', 1.000000, 450.00, '450', 0.00, 450.00),
	(100, '118c8c496fb7361aea43c8cf791e0886', 'asdas', '(asdas * 1)', 1.000000, 120.00, '120', 0.00, 120.00),
	(101, 'aee711bd92db4ae4a5f62703c431ca65', 'asdas', '(asdas * 10)', 10.000000, 50.00, '500', 0.00, 500.00),
	(102, '986e5f94dc4494fc07628ec87e487f8c', 'Deadpool Figure', '(Deadpool Figure * 1)', 1.000000, 13500.00, '13500', 7500.00, 6000.00),
	(103, '986e5f94dc4494fc07628ec87e487f8c', 'Ironman', '(Ironman * 1)', 1.000000, 14700.00, '14700', 12000.00, 2700.00),
	(104, '986e5f94dc4494fc07628ec87e487f8c', 'Cargane', '(Cargane * 1)', 1.000000, 7500.00, '7500', 4000.00, 3500.00),
	(105, 'a3e9cdcb2a1396155701b3ee7418300e', 'Deadpool Figure', '(Deadpool Figure * 1)', 1.000000, 13500.00, '13500', 7500.00, 6000.00),
	(106, 'a3e9cdcb2a1396155701b3ee7418300e', 'Ironman', '(Ironman * 1)', 1.000000, 14700.00, '14700', 12000.00, 2700.00),
	(107, 'a3e9cdcb2a1396155701b3ee7418300e', 'Cargane', '(Cargane * 1)', 1.000000, 7500.00, '7500', 4000.00, 3500.00),
	(108, '3ee1d191478ffcb4911f2d2f83fbf096', 'Deadpool Figure', '(Deadpool Figure * 1)', 1.000000, 13500.00, '13500', 7500.00, 6000.00),
	(109, '3ee1d191478ffcb4911f2d2f83fbf096', 'Ironman', '(Ironman * 1)', 1.000000, 14700.00, '14700', 12000.00, 2700.00),
	(110, '3ee1d191478ffcb4911f2d2f83fbf096', 'Cargane', '(Cargane * 1)', 1.000000, 7500.00, '7500', 4000.00, 3500.00),
	(111, 'ff2d59832af543a34e86fd91f6ddd9f3', 'Inronman', '(Inronman * 1)', 1.000000, 13500.00, '13500', 11200.00, 2300.00),
	(112, 'ff2d59832af543a34e86fd91f6ddd9f3', 'Deadpool', '(Deadpool * 1)', 1.000000, 15400.00, '15400', 11200.00, 4200.00),
	(113, 'ff2d59832af543a34e86fd91f6ddd9f3', 'Cargange', '(Cargange * 1)', 1.000000, 13200.00, '13200', 10000.00, 3200.00),
	(114, '52a01221296c5870ff192a9d558fd4b5', 'Inronman', '(Inronman * 1)', 1.000000, 13500.00, '13500', 11200.00, 2300.00),
	(115, '52a01221296c5870ff192a9d558fd4b5', 'Deadpool', '(Deadpool * 1)', 1.000000, 15400.00, '15400', 11200.00, 4200.00),
	(116, '52a01221296c5870ff192a9d558fd4b5', 'Cargange', '(Cargange * 1)', 1.000000, 13200.00, '13200', 10000.00, 3200.00),
	(117, '86e85c8ae3995868b3c68122287ac365', 'Ironman', '(Ironman * 1)', 1.000000, 13000.00, '13000', 10000.00, 3000.00),
	(118, '86e85c8ae3995868b3c68122287ac365', 'Batman', '(Batman * 1)', 1.000000, 1450.00, '1450', 500.00, 950.00);

-- Dumping structure for table liquiditybuddy.multiuseraccess
CREATE TABLE IF NOT EXISTS `multiuseraccess` (
  `usersessionid` char(32) DEFAULT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `accountsessionid` char(32) NOT NULL,
  `access` enum('Primary','Read','Write') NOT NULL DEFAULT 'Primary' COMMENT 'Primary User/ Read only/ Read & Write',
  `status` char(1) NOT NULL DEFAULT 'A',
  PRIMARY KEY (`id`),
  KEY `FK_multiuseraccess_user` (`usersessionid`),
  KEY `FK_multiuseraccess_account` (`accountsessionid`),
  CONSTRAINT `FK_multiuseraccess_account` FOREIGN KEY (`accountsessionid`) REFERENCES `account` (`sessionid`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `FK_multiuseraccess_user` FOREIGN KEY (`usersessionid`) REFERENCES `user` (`sessionid`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table liquiditybuddy.multiuseraccess: ~0 rows (approximately)

-- Dumping structure for table liquiditybuddy.participent
CREATE TABLE IF NOT EXISTS `participent` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sessionid` char(32) DEFAULT NULL,
  `groupcollectionsessionid` char(32) DEFAULT NULL,
  `stackholdersessionid` char(32) DEFAULT NULL,
  `payable` decimal(15,2) DEFAULT NULL,
  `paid` decimal(15,2) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `sessionid` (`sessionid`),
  KEY `FK_participent_groupcollection` (`groupcollectionsessionid`),
  KEY `FK_participent_stackholder` (`stackholdersessionid`),
  CONSTRAINT `FK_participent_groupcollection` FOREIGN KEY (`groupcollectionsessionid`) REFERENCES `groupcollection` (`sessionid`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `FK_participent_stackholder` FOREIGN KEY (`stackholdersessionid`) REFERENCES `stackholder` (`sessionid`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table liquiditybuddy.participent: ~0 rows (approximately)

-- Dumping structure for table liquiditybuddy.payable
CREATE TABLE IF NOT EXISTS `payable` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sessionid` char(32) NOT NULL,
  `paymentplansessionid` char(32) NOT NULL,
  `duedate` date NOT NULL,
  `paiddate` date DEFAULT NULL,
  `dueamount` decimal(15,2) NOT NULL DEFAULT 0.00,
  `paidamount` decimal(15,2) DEFAULT 0.00,
  `createddatetime` int(11) NOT NULL,
  `updateddatetime` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `sessionid` (`sessionid`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table liquiditybuddy.payable: ~13 rows (approximately)
INSERT INTO `payable` (`id`, `sessionid`, `paymentplansessionid`, `duedate`, `paiddate`, `dueamount`, `paidamount`, `createddatetime`, `updateddatetime`) VALUES
	(1, '70ce5809676ea29ceed24e7d4fa28375', 'eacef951fdba5e3bffde3155e4eaee0e', '0000-00-00', '2024-08-20', 1000.00, 0.00, 1724053891, 1724053891),
	(2, 'f1577815548a34020d1f336bf5ed393e', 'faa8038cf0349110ea3045b475c55805', '2024-08-20', '2024-08-20', 1000.00, 0.00, 1724053911, 1724053911),
	(3, '605108d75f5f9dd26b15f849fb7bcdbd', 'faa8038cf0349110ea3045b475c55805', '2024-09-17', '0000-00-00', 1000.00, 0.00, 1724053911, 1724053911),
	(4, '76fbe54eb15fe9a3dee415b20a8ba415', 'faa8038cf0349110ea3045b475c55805', '2024-11-12', '0000-00-00', 1000.00, 0.00, 1724053911, 1724053911),
	(5, '3dfeb0d5a1bd392732c5bd3f5de9624f', 'cb47e00c3dd484957405b84d7e875569', '2024-11-16', NULL, 4066.67, 0.00, 1731772919, 1731772919),
	(6, 'e99d7563966246b0056866add8e2b899', 'cb47e00c3dd484957405b84d7e875569', '2024-12-14', NULL, 4066.67, 0.00, 1731772919, 1731772919),
	(7, '7e1a5f0e13df888c60a63fd64d4a9545', 'cb47e00c3dd484957405b84d7e875569', '2025-02-08', NULL, 4066.67, 0.00, 1731772919, 1731772919),
	(8, '03b158113fcc3eab97f20a2cc7d260e6', '349d77e544cf34a6d3a4cbd63ce8b53e', '2024-11-17', NULL, 3233.33, 0.00, 1731753607, 1731753607),
	(9, 'a7ed23ae9808e1e4cea32e7482937651', '349d77e544cf34a6d3a4cbd63ce8b53e', '2024-12-15', NULL, 3233.33, 0.00, 1731753607, 1731753607),
	(10, '03541785908be88ecad9cbfe0f1d468c', '349d77e544cf34a6d3a4cbd63ce8b53e', '2025-02-09', NULL, 3233.33, 0.00, 1731753607, 1731753607),
	(11, 'd6c5a2b8945638dfae223e52e0d8fed5', '896d74fa0897a33408a247ad0d7d154c', '2024-11-17', NULL, 3233.33, 0.00, 1731753626, 1731753626),
	(12, 'e8800bb4458c82292a84c8b730a95329', '896d74fa0897a33408a247ad0d7d154c', '2024-12-15', NULL, 3233.33, 0.00, 1731753626, 1731753626),
	(13, 'ba5d0bfc6fed1762c20a1de6c871f29f', '896d74fa0897a33408a247ad0d7d154c', '2025-02-09', NULL, 3233.33, 0.00, 1731753626, 1731753626);

-- Dumping structure for table liquiditybuddy.paymentplan
CREATE TABLE IF NOT EXISTS `paymentplan` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `sessionid` char(32) DEFAULT NULL,
  `paymentplanlink` varchar(50) NOT NULL,
  `paymentplansessionid` char(32) NOT NULL,
  `paymentplan` char(1) NOT NULL DEFAULT 'I' COMMENT 'Instant/Daily/Weekly/Monthly/Anually/Continously',
  `period` int(11) NOT NULL DEFAULT 0,
  `rate` decimal(5,2) NOT NULL DEFAULT 0.00,
  `startdate` date NOT NULL,
  `enddate` date NOT NULL,
  `createddatetime` int(11) NOT NULL,
  `updateddatetime` int(11) NOT NULL,
  `usersessionid` char(32) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `sessionid` (`sessionid`),
  KEY `FK_paymentplan_user` (`usersessionid`),
  CONSTRAINT `FK_paymentplan_user` FOREIGN KEY (`usersessionid`) REFERENCES `user` (`sessionid`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table liquiditybuddy.paymentplan: ~11 rows (approximately)
INSERT INTO `paymentplan` (`id`, `sessionid`, `paymentplanlink`, `paymentplansessionid`, `paymentplan`, `period`, `rate`, `startdate`, `enddate`, `createddatetime`, `updateddatetime`, `usersessionid`) VALUES
	(1, 'db72894e5f637b331b0da547f1a90701', 'purchase', '21b1c4a39f210324f88e29bf7ca08f4b', 'M', 3, 0.00, '2024-08-20', '2024-11-12', 1724053197, 1724053197, NULL),
	(2, 'a340d03852b0ce48ac78859cbafd4b3e', 'purchase', '70573cf5c267cae761464e60dbbe23f2', 'M', 3, 0.00, '2024-08-20', '2024-11-12', 1724053414, 1724053414, NULL),
	(3, '1e306cb0e71e6f0bb7605f41442ca9ae', 'purchase', 'c9f5856703712d3c8f581fbd486fc87d', 'M', 3, 0.00, '2024-08-20', '2024-11-12', 1724053635, 1724053635, NULL),
	(4, '68a68eac751a8dee05c3057578dec66b', 'purchase', '993279212de5db9511f2e2c7a7f1e7df', 'M', 3, 0.00, '2024-08-20', '2024-11-12', 1724053654, 1724053654, NULL),
	(5, '1dd9714f7270eca48f576bf70c0afe0d', 'purchase', '3410f4a75cec5668aacf32a9226140ed', 'M', 3, 0.00, '2024-08-20', '2024-11-12', 1724053669, 1724053669, NULL),
	(6, '6608a72cce7caea4a270b6eb842c2136', 'purchase', '81e681a15d7532be252e53b289594431', 'M', 3, 0.00, '2024-08-20', '2024-11-12', 1724053861, 1724053861, NULL),
	(7, 'eacef951fdba5e3bffde3155e4eaee0e', 'purchase', 'b1127334c9a9e66e4d1159988e289908', 'M', 3, 0.00, '2024-08-20', '2024-11-12', 1724053891, 1724053891, NULL),
	(8, 'faa8038cf0349110ea3045b475c55805', 'purchase', '6377288917d76d89a928f86bb5f75945', 'M', 3, 0.00, '2024-08-20', '2024-11-12', 1724053911, 1724053911, NULL),
	(9, 'cb47e00c3dd484957405b84d7e875569', 'purchase', '3ee1d191478ffcb4911f2d2f83fbf096', 'M', 3, 0.00, '2024-11-16', '2025-02-08', 1731772919, 1731772919, NULL),
	(10, '349d77e544cf34a6d3a4cbd63ce8b53e', 'purchase', 'ff2d59832af543a34e86fd91f6ddd9f3', 'M', 3, 0.00, '2024-11-17', '2025-02-09', 1731753607, 1731753607, NULL),
	(11, '896d74fa0897a33408a247ad0d7d154c', 'purchase', '52a01221296c5870ff192a9d558fd4b5', 'M', 3, 0.00, '2024-11-17', '2025-02-09', 1731753626, 1731753626, NULL);

-- Dumping structure for table liquiditybuddy.purchase
CREATE TABLE IF NOT EXISTS `purchase` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sessionid` char(32) DEFAULT NULL,
  `shopsessionid` char(32) DEFAULT NULL,
  `description` varchar(50) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `totalamount` decimal(15,2) DEFAULT NULL,
  `totaldiscount` decimal(15,2) DEFAULT NULL,
  `finalamount` decimal(15,2) DEFAULT NULL,
  `createddatetime` int(11) DEFAULT NULL,
  `updateddatetime` int(11) DEFAULT NULL,
  `status` char(1) DEFAULT 'I',
  `usersessionid` char(32) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `sessionid` (`sessionid`),
  KEY `FK_purchase_user` (`usersessionid`),
  CONSTRAINT `FK_purchase_user` FOREIGN KEY (`usersessionid`) REFERENCES `user` (`sessionid`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=47 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table liquiditybuddy.purchase: ~42 rows (approximately)
INSERT INTO `purchase` (`id`, `sessionid`, `shopsessionid`, `description`, `date`, `totalamount`, `totaldiscount`, `finalamount`, `createddatetime`, `updateddatetime`, `status`, `usersessionid`) VALUES
	(1, '6d1dbd31b921bbc07438da837596a095', 'fcbbb6c65c41e172bf3de5e80d251ebc', 'Rio', '2024-08-19', NULL, NULL, NULL, 1724050778, 1724050778, 'I', '01b9ff2b173400203b74b4cbec306d6f'),
	(2, '615af42c9ee62c2261fdd2114c465ed1', 'fcbbb6c65c41e172bf3de5e80d251ebc', 'Rio', '2024-08-19', NULL, NULL, NULL, 1724050806, 1724050806, 'I', '01b9ff2b173400203b74b4cbec306d6f'),
	(3, '0091c8dd01fbef228d614ffa88dc58c2', 'fcbbb6c65c41e172bf3de5e80d251ebc', 'Rio', '2024-08-19', 3700.00, 700.00, 3000.00, 1724050898, 1724050898, 'I', '01b9ff2b173400203b74b4cbec306d6f'),
	(4, '5a6851fa6563747bd7da544e5911c5bf', 'fcbbb6c65c41e172bf3de5e80d251ebc', 'Rio', '2024-08-19', 3700.00, 700.00, 3000.00, 1724051048, 1724051048, 'I', '01b9ff2b173400203b74b4cbec306d6f'),
	(5, '015156fca37602724e09bc1120c59ef7', 'fcbbb6c65c41e172bf3de5e80d251ebc', 'Rio', '2024-08-19', 3700.00, 700.00, 3000.00, 1724051134, 1724051134, 'I', '01b9ff2b173400203b74b4cbec306d6f'),
	(6, '26ecd97c4f2be348a91f01a7d2e008e9', 'fcbbb6c65c41e172bf3de5e80d251ebc', 'Rio', '2024-08-19', 3700.00, 700.00, 3000.00, 1724051187, 1724051187, 'I', '01b9ff2b173400203b74b4cbec306d6f'),
	(7, 'd4c546fd2ef393d21e1cebf887e608a4', 'fcbbb6c65c41e172bf3de5e80d251ebc', 'Rio', '2024-08-19', 3700.00, 700.00, 3000.00, 1724051206, 1724051206, 'I', '01b9ff2b173400203b74b4cbec306d6f'),
	(8, '248f661d6472c7d4e1e9e311b70a99a0', 'fcbbb6c65c41e172bf3de5e80d251ebc', 'Rio', '2024-08-19', 3700.00, 700.00, 3000.00, 1724051230, 1724051230, 'I', '01b9ff2b173400203b74b4cbec306d6f'),
	(9, '920fc5c8ca587221cd776b661d036043', 'fcbbb6c65c41e172bf3de5e80d251ebc', 'Rio', '2024-08-19', 3700.00, 700.00, 3000.00, 1724051362, 1724051362, 'I', '01b9ff2b173400203b74b4cbec306d6f'),
	(10, 'ff5e5000753bb49f87b16e2be0e3ec92', 'fcbbb6c65c41e172bf3de5e80d251ebc', 'Rio', '2024-08-19', 3700.00, 700.00, 3000.00, 1724051739, 1724051739, 'I', '01b9ff2b173400203b74b4cbec306d6f'),
	(11, '9d6ea68d0cd1daafe2189ab2e47e6aad', 'fcbbb6c65c41e172bf3de5e80d251ebc', 'Rio', '2024-08-19', 3700.00, 700.00, 3000.00, 1724051782, 1724051782, 'I', '01b9ff2b173400203b74b4cbec306d6f'),
	(12, 'fdd532a34a2c096e77c35c8f8fbba1f4', 'fcbbb6c65c41e172bf3de5e80d251ebc', 'Rio', '2024-08-19', 3700.00, 700.00, 3000.00, 1724052030, 1724052030, 'I', '01b9ff2b173400203b74b4cbec306d6f'),
	(13, '57778294ac949752b3486aa553598cca', 'fcbbb6c65c41e172bf3de5e80d251ebc', 'Rio', '2024-08-19', 3700.00, 700.00, 3000.00, 1724052118, 1724052118, 'I', '01b9ff2b173400203b74b4cbec306d6f'),
	(14, 'de6d434c18388bf0ad13e66518235102', 'fcbbb6c65c41e172bf3de5e80d251ebc', 'Rio', '2024-08-19', 3700.00, 700.00, 3000.00, 1724052223, 1724052223, 'I', '01b9ff2b173400203b74b4cbec306d6f'),
	(15, '8946157af3b62498fc8aa2e27c2a008a', 'fcbbb6c65c41e172bf3de5e80d251ebc', 'Rio', '2024-08-19', 3700.00, 700.00, 3000.00, 1724052456, 1724052456, 'I', '01b9ff2b173400203b74b4cbec306d6f'),
	(16, '8c4c036d2011889fb74cc2416bd6e638', 'fcbbb6c65c41e172bf3de5e80d251ebc', 'Rio', '2024-08-19', 3700.00, 700.00, 3000.00, 1724052479, 1724052479, 'I', '01b9ff2b173400203b74b4cbec306d6f'),
	(17, '5c8c62a0b00370d0227d73b66cd92360', 'fcbbb6c65c41e172bf3de5e80d251ebc', 'Rio', '2024-08-19', 3700.00, 700.00, 3000.00, 1724052492, 1724052492, 'I', '01b9ff2b173400203b74b4cbec306d6f'),
	(18, '8389cfaac1e80b7e516609ca6c369b06', 'fcbbb6c65c41e172bf3de5e80d251ebc', 'Rio', '2024-08-19', 3700.00, 700.00, 3000.00, 1724052533, 1724052533, 'I', '01b9ff2b173400203b74b4cbec306d6f'),
	(19, 'be0ae05020d8e7470350633e2714e5c7', 'fcbbb6c65c41e172bf3de5e80d251ebc', 'Rio', '2024-08-19', 3700.00, 700.00, 3000.00, 1724052550, 1724052550, 'I', '01b9ff2b173400203b74b4cbec306d6f'),
	(20, '51c18c92abcaaa08267c8c5d06ed4ed5', 'fcbbb6c65c41e172bf3de5e80d251ebc', 'Rio', '2024-08-19', 3700.00, 700.00, 3000.00, 1724052576, 1724052576, 'I', '01b9ff2b173400203b74b4cbec306d6f'),
	(21, 'dd10f4ef894d6918d6ba6dd4469c3005', 'fcbbb6c65c41e172bf3de5e80d251ebc', 'Rio', '2024-08-19', 3700.00, 700.00, 3000.00, 1724052600, 1724052600, 'I', '01b9ff2b173400203b74b4cbec306d6f'),
	(22, '3575cf5aa094f6aa42bf307d8cb938a5', 'fcbbb6c65c41e172bf3de5e80d251ebc', 'Rio', '2024-08-19', 3700.00, 700.00, 3000.00, 1724052625, 1724052625, 'I', '01b9ff2b173400203b74b4cbec306d6f'),
	(23, '8d1f8263cf486253dee62888826cffbb', 'fcbbb6c65c41e172bf3de5e80d251ebc', 'Rio', '2024-08-19', 3700.00, 700.00, 3000.00, 1724052659, 1724052659, 'I', '01b9ff2b173400203b74b4cbec306d6f'),
	(24, '62943f36f506a5c422225aae5a9b9d7a', 'fcbbb6c65c41e172bf3de5e80d251ebc', 'Rio', '2024-08-19', 3700.00, 700.00, 3000.00, 1724052678, 1724052678, 'I', '01b9ff2b173400203b74b4cbec306d6f'),
	(25, 'ec8ea74d59450072489277711049edfd', 'fcbbb6c65c41e172bf3de5e80d251ebc', 'Rio', '2024-08-19', 3700.00, 700.00, 3000.00, 1724052689, 1724052689, 'I', '01b9ff2b173400203b74b4cbec306d6f'),
	(26, 'a3a7ec0a3bbe6b5bea404bf09debc23b', 'fcbbb6c65c41e172bf3de5e80d251ebc', 'Rio', '2024-08-19', 3700.00, 700.00, 3000.00, 1724052836, 1724052836, 'I', '01b9ff2b173400203b74b4cbec306d6f'),
	(27, 'e8d51231b2c91a70e40d02d211031f82', 'fcbbb6c65c41e172bf3de5e80d251ebc', 'Rio', '2024-08-19', 3700.00, 700.00, 3000.00, 1724053075, 1724053075, 'I', '01b9ff2b173400203b74b4cbec306d6f'),
	(28, '21b1c4a39f210324f88e29bf7ca08f4b', 'fcbbb6c65c41e172bf3de5e80d251ebc', 'Rio', '2024-08-19', 3700.00, 700.00, 3000.00, 1724053197, 1724053197, 'I', '01b9ff2b173400203b74b4cbec306d6f'),
	(29, '70573cf5c267cae761464e60dbbe23f2', 'fcbbb6c65c41e172bf3de5e80d251ebc', 'Rio', '2024-08-19', 3700.00, 700.00, 3000.00, 1724053414, 1724053414, 'I', '01b9ff2b173400203b74b4cbec306d6f'),
	(30, 'c9f5856703712d3c8f581fbd486fc87d', 'fcbbb6c65c41e172bf3de5e80d251ebc', 'Rio', '2024-08-19', 3700.00, 700.00, 3000.00, 1724053635, 1724053635, 'I', '01b9ff2b173400203b74b4cbec306d6f'),
	(31, '993279212de5db9511f2e2c7a7f1e7df', 'fcbbb6c65c41e172bf3de5e80d251ebc', 'Rio', '2024-08-19', 3700.00, 700.00, 3000.00, 1724053654, 1724053654, 'I', '01b9ff2b173400203b74b4cbec306d6f'),
	(32, '3410f4a75cec5668aacf32a9226140ed', 'fcbbb6c65c41e172bf3de5e80d251ebc', 'Rio', '2024-08-19', 3700.00, 700.00, 3000.00, 1724053669, 1724053669, 'I', '01b9ff2b173400203b74b4cbec306d6f'),
	(33, '81e681a15d7532be252e53b289594431', 'fcbbb6c65c41e172bf3de5e80d251ebc', 'Rio', '2024-08-19', 3700.00, 700.00, 3000.00, 1724053861, 1724053861, 'I', '01b9ff2b173400203b74b4cbec306d6f'),
	(34, 'b1127334c9a9e66e4d1159988e289908', 'fcbbb6c65c41e172bf3de5e80d251ebc', 'Rio', '2024-08-19', 3700.00, 700.00, 3000.00, 1724053891, 1724053891, 'I', '01b9ff2b173400203b74b4cbec306d6f'),
	(35, '6377288917d76d89a928f86bb5f75945', 'fcbbb6c65c41e172bf3de5e80d251ebc', 'Rio', '2024-08-19', 3700.00, 700.00, 3000.00, 1724053911, 1724053911, 'I', '01b9ff2b173400203b74b4cbec306d6f'),
	(36, '118c8c496fb7361aea43c8cf791e0886', 'fcbbb6c65c41e172bf3de5e80d251ebc', 'Payment Made', '2024-08-19', 120.00, 0.00, 120.00, 1724054131, 1724054131, 'I', '01b9ff2b173400203b74b4cbec306d6f'),
	(37, 'aee711bd92db4ae4a5f62703c431ca65', 'fcbbb6c65c41e172bf3de5e80d251ebc', 'Payment Made', '2024-08-19', 500.00, 0.00, 500.00, 1724054768, 1724054768, 'I', '01b9ff2b173400203b74b4cbec306d6f'),
	(38, '986e5f94dc4494fc07628ec87e487f8c', 'fcbbb6c65c41e172bf3de5e80d251ebc', 'I bought an action figure', '2024-11-16', NULL, NULL, NULL, 1731772147, 1731772147, 'I', '01b9ff2b173400203b74b4cbec306d6f'),
	(39, 'a3e9cdcb2a1396155701b3ee7418300e', 'fcbbb6c65c41e172bf3de5e80d251ebc', 'I bought an action figure', '2024-11-16', NULL, NULL, NULL, 1731772168, 1731772168, 'I', '01b9ff2b173400203b74b4cbec306d6f'),
	(40, '3ee1d191478ffcb4911f2d2f83fbf096', 'fcbbb6c65c41e172bf3de5e80d251ebc', 'I bought action figures', '2024-11-16', 35700.00, 23500.00, 12200.00, 1731772919, 1731772919, 'I', '01b9ff2b173400203b74b4cbec306d6f'),
	(41, 'ff2d59832af543a34e86fd91f6ddd9f3', 'fcbbb6c65c41e172bf3de5e80d251ebc', 'Action figures', '2024-11-16', 42100.00, 32400.00, 9700.00, 1731753607, 1731753607, 'I', '01b9ff2b173400203b74b4cbec306d6f'),
	(42, '52a01221296c5870ff192a9d558fd4b5', 'fcbbb6c65c41e172bf3de5e80d251ebc', 'Action figures', '2024-11-16', 42100.00, 32400.00, 9700.00, 1731753626, 1731753626, 'I', '01b9ff2b173400203b74b4cbec306d6f'),
	(43, 'cd1f70d1d173bd001a3ab1e57c02fb7d', 'fcbbb6c65c41e172bf3de5e80d251ebc', 'Icecream', '2024-12-07', NULL, NULL, NULL, 1733560030, 1733560030, 'I', '01b9ff2b173400203b74b4cbec306d6f'),
	(44, '86e85c8ae3995868b3c68122287ac365', 'fcbbb6c65c41e172bf3de5e80d251ebc', 'Acition figures', '2024-12-07', 14450.00, 10500.00, 3950.00, 1733571190, 1733571190, 'I', '01b9ff2b173400203b74b4cbec306d6f'),
	(45, 'cc21c26aa3a53b93d173c697c1e8efc4', '1b8753e79b0c1fd25707279a62f270b5', 'Icecream', '2024-12-07', NULL, NULL, NULL, 1733571555, 1733571555, 'I', '01b9ff2b173400203b74b4cbec306d6f'),
	(46, '4f6d52e3c79985cb7aeec4c27cac9f46', '1b8753e79b0c1fd25707279a62f270b5', 'Icecream', '2024-12-07', NULL, NULL, NULL, 1733571589, 1733571589, 'I', '01b9ff2b173400203b74b4cbec306d6f');

-- Dumping structure for table liquiditybuddy.shop
CREATE TABLE IF NOT EXISTS `shop` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sessionid` char(32) DEFAULT NULL,
  `name` varchar(50) DEFAULT NULL,
  `description` varchar(50) DEFAULT NULL,
  `moreinfo` blob DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `sessionid` (`sessionid`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table liquiditybuddy.shop: ~7 rows (approximately)
INSERT INTO `shop` (`id`, `sessionid`, `name`, `description`, `moreinfo`) VALUES
	(1, 'fcbbb6c65c41e172bf3de5e80d251ebc', 'Unknown', 'Default shop to add prices if you dont remeber the', _binary ''),
	(2, '1b9b0e4be2ee45fab89ac8c715b22eb0', 'Kells SUpermarket', NULL, NULL),
	(3, '1b8753e79b0c1fd25707279a62f270b5', 'Food City', NULL, NULL),
	(4, '8bf0c81b6b65b3d16e6f1d69f596a499', 'Arpico', NULL, NULL),
	(5, '400162dce331278227c1bbb723422f16', 'Pepers Corner', NULL, NULL),
	(6, 'f9e08751f793ba9e2fca89e61624c1be', 'Singer', NULL, NULL),
	(7, '1aa30d0be7b5c8b9d111782e280a27df', 'DIalog', NULL, NULL);

-- Dumping structure for table liquiditybuddy.shopaccessorder
CREATE TABLE IF NOT EXISTS `shopaccessorder` (
  `usersessionid` char(32) NOT NULL,
  `shopsessionid` char(32) NOT NULL,
  `accesscount` int(11) DEFAULT 0,
  PRIMARY KEY (`usersessionid`,`shopsessionid`),
  KEY `FK__shop` (`shopsessionid`),
  CONSTRAINT `FK__shop` FOREIGN KEY (`shopsessionid`) REFERENCES `shop` (`sessionid`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `FK__user` FOREIGN KEY (`usersessionid`) REFERENCES `user` (`sessionid`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table liquiditybuddy.shopaccessorder: ~4 rows (approximately)
INSERT INTO `shopaccessorder` (`usersessionid`, `shopsessionid`, `accesscount`) VALUES
	('01b9ff2b173400203b74b4cbec306d6f', '1aa30d0be7b5c8b9d111782e280a27df', 1),
	('01b9ff2b173400203b74b4cbec306d6f', '1b8753e79b0c1fd25707279a62f270b5', 12),
	('01b9ff2b173400203b74b4cbec306d6f', '400162dce331278227c1bbb723422f16', 3),
	('01b9ff2b173400203b74b4cbec306d6f', 'fcbbb6c65c41e172bf3de5e80d251ebc', 62);

-- Dumping structure for table liquiditybuddy.stackholder
CREATE TABLE IF NOT EXISTS `stackholder` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sessionid` char(32) NOT NULL,
  `linkedusersessionid` char(32) NOT NULL COMMENT 'linked user id',
  `name` varchar(50) NOT NULL DEFAULT '',
  `relationship` varchar(50) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  UNIQUE KEY `sessionid` (`sessionid`),
  KEY `FK_stackholder_user` (`linkedusersessionid`),
  CONSTRAINT `FK_stackholder_user` FOREIGN KEY (`linkedusersessionid`) REFERENCES `user` (`sessionid`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table liquiditybuddy.stackholder: ~1 rows (approximately)
INSERT INTO `stackholder` (`id`, `sessionid`, `linkedusersessionid`, `name`, `relationship`) VALUES
	(1, '8b962a69138ece3f0daeef107dd57424', '01b9ff2b173400203b74b4cbec306d6f', 'Angel', 'Girlfriend');

-- Dumping structure for table liquiditybuddy.transaction
CREATE TABLE IF NOT EXISTS `transaction` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sessionid` char(32) DEFAULT NULL,
  `description` varchar(50) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `amount` decimal(15,2) DEFAULT NULL,
  `paymenttype` varchar(10) DEFAULT 'income' COMMENT 'income, expense',
  `status` char(1) DEFAULT 'A',
  `createddatetime` int(11) DEFAULT NULL,
  `updateddatetime` int(11) DEFAULT NULL,
  `accountsessionid` char(32) DEFAULT NULL,
  `budgetsessionid` char(32) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `sessionid` (`sessionid`),
  KEY `FK_transaction_account_2` (`accountsessionid`) USING BTREE,
  KEY `FK_transaction_budget` (`budgetsessionid`),
  CONSTRAINT `FK_transaction_account` FOREIGN KEY (`accountsessionid`) REFERENCES `account` (`sessionid`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `FK_transaction_budget` FOREIGN KEY (`budgetsessionid`) REFERENCES `budget` (`sessionid`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=138 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table liquiditybuddy.transaction: ~103 rows (approximately)
INSERT INTO `transaction` (`id`, `sessionid`, `description`, `date`, `amount`, `paymenttype`, `status`, `createddatetime`, `updateddatetime`, `accountsessionid`, `budgetsessionid`) VALUES
	(1, 'eb0248118706eac2281e4604b1fd2201', 'Inital amount', '2024-08-07', 1000.00, 'income', 'A', NULL, NULL, '2d55834ae87ee76927f9783f249d901f', NULL),
	(2, 'fc0374e3c32381fb23a0231559bb9bde', NULL, '2024-08-10', 2322.00, 'income', 'A', 1723266000, 1723266000, '2d55834ae87ee76927f9783f249d901f', NULL),
	(3, '3be7b019d488a2220a2bdba9006fe943', 'Transferred to Cash in Hand', '2024-08-10', 232.00, 'income', 'A', 1723266000, 1723266000, '2d55834ae87ee76927f9783f249d901f', NULL),
	(4, 'dc36fc1885272358dd0fabb15bb1267f', 'Transferred to Cash in Hand', '2024-08-10', 222.00, 'income', 'A', 1723266000, 1723266000, '2d55834ae87ee76927f9783f249d901f', NULL),
	(5, 'dcb2e4016ea55fce903cc5c08245ca37', 'Transferred to Cash in Hand', '2024-08-10', 232.00, 'income', 'A', 1723266000, 1723266000, '2d55834ae87ee76927f9783f249d901f', NULL),
	(6, '80685604e710f8aaa70851b4652f4ca1', 'Transferred from Sampath: Day to Day', '2024-08-10', 232.00, 'expense', 'A', 1723266000, 1723266000, '42853ec7ccebc2c04f3340c8b6c74d36', NULL),
	(7, '4f957dd412da9c8d74af45752a53eb49', 'Transferred to Cash in Hand', '2024-08-10', 232.00, 'income', 'A', 1723266000, 1723266000, '2d55834ae87ee76927f9783f249d901f', NULL),
	(8, 'e38c2bc0256ecace80e15d31dc2505dd', 'Transferred from Sampath: Day to Day', '2024-08-10', 232.00, 'expense', 'A', 1723266000, 1723266000, '42853ec7ccebc2c04f3340c8b6c74d36', NULL),
	(9, 'c51c494b4916058df11cab11b368fd85', 'Transferred to Cash in Hand', '2024-08-10', 2323.00, 'income', 'A', 1723266000, 1723266000, '2d55834ae87ee76927f9783f249d901f', NULL),
	(10, '3ff04118ef28ff2fd0a10f8dd90cbf77', 'Transferred from Sampath: Day to Day', '2024-08-10', 2323.00, 'expense', 'A', 1723266000, 1723266000, '42853ec7ccebc2c04f3340c8b6c74d36', NULL),
	(11, '8a18b1aa3a4758d0a8859936d1ea41cf', 'Transferred from Cash in Hand', '2024-08-10', 232.00, 'expense', 'A', 1723266000, 1723266000, '2d55834ae87ee76927f9783f249d901f', NULL),
	(12, '11d0f2e2dccc52a542f33673bc13128b', 'Transferred from Cash in Hand', '2024-08-10', 222.00, 'expense', 'A', 1723266000, 1723266000, '2d55834ae87ee76927f9783f249d901f', NULL),
	(13, '24de9d5b58eed9fc94f6ec92543ba69a', 'Transferred to Cash in Hand', '2024-08-10', 22.00, 'income', 'A', 1723266000, 1723266000, '2d55834ae87ee76927f9783f249d901f', NULL),
	(14, '97a8faa8f266939322fd03c7ba2aaa6a', 'Transferred from Cash in Hand', '2024-08-10', 22.00, 'expense', 'A', 1723266000, 1723266000, '2d55834ae87ee76927f9783f249d901f', NULL),
	(15, 'd7a767afbb9cdc31ae0db3a07f063a9d', 'Transferred to Cash in Hand', '2024-08-10', 22.00, 'income', 'A', 1723266000, 1723266000, '2d55834ae87ee76927f9783f249d901f', NULL),
	(16, '318157aee00e89f845c71bf1c57383a0', 'Transferred to Cash in Hand', '2024-08-10', 23.00, 'income', 'A', 1723266000, 1723266000, '2d55834ae87ee76927f9783f249d901f', NULL),
	(17, '4cfe2c7b1c1c8b59286c4bf11224bd5a', 'Transferred from Sampath: Day to Day', '2024-08-10', 23.00, 'expense', 'A', 1723266000, 1723266000, '42853ec7ccebc2c04f3340c8b6c74d36', NULL),
	(18, 'd908be2e0cec0ee4d3d11c8b0d42ed46', 'Transferred from Cash in Hand', '2024-08-11', 550.00, 'expense', 'A', 1723352400, 1723352400, '2d55834ae87ee76927f9783f249d901f', NULL),
	(19, '1e05977ffb700ccd70fa8f566ea99970', 'Transferred to Sampath: Day to Day', '2024-08-11', 550.00, 'income', 'A', 1723352400, 1723352400, '42853ec7ccebc2c04f3340c8b6c74d36', NULL),
	(20, 'be25928948193284fd9948205d118817', 'Transferred to Cash in Hand', '2024-08-11', 121.00, 'income', 'A', 1723352400, 1723352400, '2d55834ae87ee76927f9783f249d901f', NULL),
	(21, '196e7722e5534d644a5ef726192bf869', 'Transferred from Sampath: Day to Day', '2024-08-11', 121.00, 'expense', 'A', 1723352400, 1723352400, '42853ec7ccebc2c04f3340c8b6c74d36', NULL),
	(22, '0f732cad6c9c20e12b7a05db365b3fe4', 'Transferred to Cash in Hand', '2024-08-11', 110.00, 'income', 'A', 1723352400, 1723352400, '2d55834ae87ee76927f9783f249d901f', NULL),
	(23, '3ae3554ff3fef2db67128105d35fdfc7', 'Transferred from Sampath: Day to Day', '2024-08-11', 110.00, 'expense', 'A', 1723352400, 1723352400, '42853ec7ccebc2c04f3340c8b6c74d36', NULL),
	(24, '0a8748ffb57268d42a6b7001b800ab11', 'Transferred to Cash in Hand', '2024-08-11', 100.00, 'income', 'A', 1723352400, 1723352400, '2d55834ae87ee76927f9783f249d901f', NULL),
	(25, '790aacf0b80fc277e97fff7b47b52eb6', 'Transferred from Sampath: Day to Day', '2024-08-11', 100.00, 'expense', 'A', 1723352400, 1723352400, '42853ec7ccebc2c04f3340c8b6c74d36', NULL),
	(26, 'd2bd4ff29eda4316227ac8d77283b33b', 'Transferred to Cash in Hand', '2024-08-11', 100.00, 'income', 'A', 1723352400, 1723352400, '2d55834ae87ee76927f9783f249d901f', NULL),
	(27, '8aee05ce81ae9fda34b577cff07f7931', 'Transferred from Sampath: Day to Day', '2024-08-11', 100.00, 'expense', 'A', 1723352400, 1723352400, '42853ec7ccebc2c04f3340c8b6c74d36', NULL),
	(28, '12dc515db0377066d0404eadd2d874ab', 'Transferred to Cash in Hand', '2024-08-11', 100.00, 'income', 'A', 1723352400, 1723352400, '2d55834ae87ee76927f9783f249d901f', NULL),
	(29, '7499553fff5bb2a71c0346d49aa57965', 'Transferred from Sampath: Day to Day', '2024-08-11', 100.00, 'expense', 'A', 1723352400, 1723352400, '42853ec7ccebc2c04f3340c8b6c74d36', NULL),
	(30, 'fa5430e9aed936d69d173824e664b112', 'Transferred to Cash in Hand', '2024-08-11', 100.00, 'income', 'A', 1723352400, 1723352400, '2d55834ae87ee76927f9783f249d901f', NULL),
	(31, '82ad346316f8ce634aeca86841d0cb54', 'Transferred from Sampath: Day to Day', '2024-08-11', 100.00, 'expense', 'A', 1723352400, 1723352400, '42853ec7ccebc2c04f3340c8b6c74d36', NULL),
	(32, '2d2336cea3d21f870d77784231cce4fc', 'Transferred to Cash in Hand', '2024-08-11', 100.00, 'income', 'A', 1723352400, 1723352400, '2d55834ae87ee76927f9783f249d901f', NULL),
	(33, '3bba1488612e241ed353c7dc0574ea02', 'Transferred from Sampath: Day to Day', '2024-08-11', 100.00, 'expense', 'A', 1723352400, 1723352400, '42853ec7ccebc2c04f3340c8b6c74d36', NULL),
	(34, '4b6517ba958a4bffe25a053882852d18', 'Transferred from Cash in Hand', '2024-08-11', 1000.00, 'expense', 'A', 1723352400, 1723352400, '2d55834ae87ee76927f9783f249d901f', NULL),
	(35, '46a675a77c1e98469070eaf6529eeca0', 'Transferred to Sampath: Day to Day', '2024-08-11', 1000.00, 'income', 'A', 1723352400, 1723352400, '42853ec7ccebc2c04f3340c8b6c74d36', NULL),
	(36, '96ac78f4dd4f30ab3dcfe2ba65325091', 'Transferred to Cash in Hand', '2024-08-14', 0.00, 'income', 'A', 1723611600, 1723611600, '2d55834ae87ee76927f9783f249d901f', 'bdf37ae18f8955dd0a0d4c13c70b5013'),
	(37, '4a891f09f6179f79178f8fe42bcc2451', 'Transferred from Sampath: Day to Day', '2024-08-14', 0.00, 'expense', 'A', 1723611600, 1723611600, '42853ec7ccebc2c04f3340c8b6c74d36', 'bdf37ae18f8955dd0a0d4c13c70b5013'),
	(38, '50d1162a435caa68da4cfa73fa36717e', 'Transferred to Cash in Hand', '2024-08-14', 0.00, 'income', 'A', 1723611600, 1723611600, '2d55834ae87ee76927f9783f249d901f', 'bdf37ae18f8955dd0a0d4c13c70b5013'),
	(39, '4b60300040d5ae8281eaa84dad5a5b12', 'Transferred from Sampath: Day to Day', '2024-08-14', 0.00, 'expense', 'A', 1723611600, 1723611600, '42853ec7ccebc2c04f3340c8b6c74d36', 'bdf37ae18f8955dd0a0d4c13c70b5013'),
	(40, '88f3a53c464fc0e88b898d0d8966566d', 'Transferred to Cash in Hand', '2024-08-14', 232.00, 'income', 'A', 1723611600, 1723611600, '2d55834ae87ee76927f9783f249d901f', 'bdf37ae18f8955dd0a0d4c13c70b5013'),
	(41, '892d0f9ebc9e519a049fa22c49af47c2', 'Transferred from Sampath: Day to Day', '2024-08-14', 232.00, 'expense', 'A', 1723611600, 1723611600, '42853ec7ccebc2c04f3340c8b6c74d36', 'bdf37ae18f8955dd0a0d4c13c70b5013'),
	(42, '21b7e1b9c4e8f5a32e4ce1759f6266b8', 'Transferred to Cash in Hand', '2024-08-14', 20.00, 'income', 'A', 1723611600, 1723611600, '2d55834ae87ee76927f9783f249d901f', 'bdf37ae18f8955dd0a0d4c13c70b5013'),
	(43, 'f193cc3efb24f7c07103183c861e9d00', 'Transferred from Sampath: Day to Day', '2024-08-14', 20.00, 'expense', 'A', 1723611600, 1723611600, '42853ec7ccebc2c04f3340c8b6c74d36', 'bdf37ae18f8955dd0a0d4c13c70b5013'),
	(44, 'a211010cd6e6a8bdc38a4adaebe79fd4', 'Transferred to Cash in Hand', '2024-08-14', 110.00, 'income', 'A', 1723611600, 1723611600, '2d55834ae87ee76927f9783f249d901f', 'bdf37ae18f8955dd0a0d4c13c70b5013'),
	(45, '84943e9900d47842fcb1f6444a2116f2', 'Transferred from Sampath: Day to Day', '2024-08-14', 110.00, 'expense', 'A', 1723611600, 1723611600, '42853ec7ccebc2c04f3340c8b6c74d36', 'bdf37ae18f8955dd0a0d4c13c70b5013'),
	(46, '51deffc766e6da0d76224e61fe684e4b', 'Transferred to Cash in Hand', '2024-08-14', 211.00, 'income', 'A', 1723611600, 1723611600, '2d55834ae87ee76927f9783f249d901f', 'bdf37ae18f8955dd0a0d4c13c70b5013'),
	(47, 'fa3e0e6c76712def5a83745b33aa63b4', 'Transferred from Sampath: Day to Day', '2024-08-14', 211.00, 'expense', 'A', 1723611600, 1723611600, '42853ec7ccebc2c04f3340c8b6c74d36', 'bdf37ae18f8955dd0a0d4c13c70b5013'),
	(48, 'e8d302b8c666aa27d5b423ebad352b92', 'Transferred to Cash in Hand', '2024-08-16', 211.00, 'income', 'A', 1723784400, 1723784400, '2d55834ae87ee76927f9783f249d901f', '472944cd9f1577b490cd753628f02566'),
	(49, '57fd84ceff7794cabeb6c0e443e0115c', 'Transferred from Sampath: Day to Day', '2024-08-16', 211.00, 'expense', 'A', 1723784400, 1723784400, '42853ec7ccebc2c04f3340c8b6c74d36', '472944cd9f1577b490cd753628f02566'),
	(60, 'd445cd522b8282038ae6c5aec69e6ffc', 'Transferred to Cash in Hand', '2024-08-16', 232.00, 'income', 'A', 1723784400, 1723784400, '2d55834ae87ee76927f9783f249d901f', 'bdf37ae18f8955dd0a0d4c13c70b5013'),
	(61, '43c38385557cd5936974b4b6591f389f', 'Transferred from Sampath: Day to Day', '2024-08-16', 232.00, 'expense', 'A', 1723784400, 1723784400, '42853ec7ccebc2c04f3340c8b6c74d36', 'bdf37ae18f8955dd0a0d4c13c70b5013'),
	(62, 'a0a94f976c2f9ca2be65b585a11b75e1', 'Transferred to Cash in Hand', '2024-08-16', 23.00, 'income', 'A', 1723784400, 1723784400, '2d55834ae87ee76927f9783f249d901f', 'bdf37ae18f8955dd0a0d4c13c70b5013'),
	(63, '382c0b6064cef24d7c109f8db1b463f0', 'Transferred from Sampath: Day to Day', '2024-08-16', 23.00, 'expense', 'A', 1723784400, 1723784400, '42853ec7ccebc2c04f3340c8b6c74d36', 'bdf37ae18f8955dd0a0d4c13c70b5013'),
	(64, '24497dd493ec55e2f8b7bb90277fa452', 'Icecream', '2024-08-16', 2323.00, 'expense', 'A', 1723784400, 1723784400, '2d55834ae87ee76927f9783f249d901f', 'bdf37ae18f8955dd0a0d4c13c70b5013'),
	(65, '64e83e5e8d3a3035bf63db6432782677', 'Transferred from Cash in Hand', '2024-08-17', 32.00, 'expense', 'A', 1723870800, 1723870800, '2d55834ae87ee76927f9783f249d901f', '472944cd9f1577b490cd753628f02566'),
	(66, '710c76b749141f956cdf3e176cda1ce1', 'Transferred to Sampath: Day to Day', '2024-08-17', 32.00, 'income', 'A', 1723870800, 1723870800, '42853ec7ccebc2c04f3340c8b6c74d36', '472944cd9f1577b490cd753628f02566'),
	(67, '7a51301733fef1f86aa440c63fa1cbd5', 'Transferred from Cash in Hand', '2024-08-17', 232.00, 'expense', 'A', 1723870800, 1723870800, '2d55834ae87ee76927f9783f249d901f', 'bdf37ae18f8955dd0a0d4c13c70b5013'),
	(68, '35ce10c708980b766892860ffbe64984', 'Transferred to Sampath: Day to Day', '2024-08-17', 232.00, 'income', 'A', 1723870800, 1723870800, '42853ec7ccebc2c04f3340c8b6c74d36', 'bdf37ae18f8955dd0a0d4c13c70b5013'),
	(69, '248164800be88dc2ebdf98961827c55d', 'Transferred from Cash in Hand', '2024-08-17', 122.00, 'expense', 'A', 1723917272, 1723917272, '2d55834ae87ee76927f9783f249d901f', 'bdf37ae18f8955dd0a0d4c13c70b5013'),
	(70, '754ff3826b2a1823c09551cad2dc1175', 'Transferred to Sampath: Day to Day', '2024-08-17', 122.00, 'income', 'A', 1723917272, 1723917272, '42853ec7ccebc2c04f3340c8b6c74d36', 'bdf37ae18f8955dd0a0d4c13c70b5013'),
	(71, '6c3da20f07b19c7d63cb1a0ac855e927', 'Transferred from Cash in Hand', '2024-08-18', 50.00, 'expense', 'A', 1724000209, 1724000209, '2d55834ae87ee76927f9783f249d901f', 'bdf37ae18f8955dd0a0d4c13c70b5013'),
	(72, '6dd75d9462a19ac173dd7cbd5d184424', 'Transferred to Sampath: Day to Day', '2024-08-18', 50.00, 'income', 'A', 1724000209, 1724000209, '42853ec7ccebc2c04f3340c8b6c74d36', 'bdf37ae18f8955dd0a0d4c13c70b5013'),
	(79, '1bb9feaac445f08067e68a3b44ffad3b', 'Rio', '2024-08-19', 3000.00, 'expense', 'A', 1724052030, 1724052030, '9fe7b9332f333ceae7f66c3d527651eb', 'bdf37ae18f8955dd0a0d4c13c70b5013'),
	(80, 'cd5364a3cd00feb897a6db574d837157', 'Rio', '2024-08-19', 3000.00, 'expense', 'A', 1724053911, 1724053911, '9fe7b9332f333ceae7f66c3d527651eb', 'bdf37ae18f8955dd0a0d4c13c70b5013'),
	(81, 'ec2b9d586b24f8e2e0b5a2ad4c8674d5', 'Payment Made', '2024-08-19', 120.00, 'expense', 'A', 1724054131, 1724054131, '2d55834ae87ee76927f9783f249d901f', 'bdf37ae18f8955dd0a0d4c13c70b5013'),
	(82, '59585e0f960ee7c0cd780fefed86f3fd', 'Payment Made', '2024-08-19', 500.00, 'expense', 'A', 1724054768, 1724054768, '2d55834ae87ee76927f9783f249d901f', 'bdf37ae18f8955dd0a0d4c13c70b5013'),
	(83, '8350a65b13363fa9c54c2a80c8cc5043', 'Transferred from Cash in Hand', '2024-08-19', 400.00, 'expense', 'A', 1724055345, 1724055345, '2d55834ae87ee76927f9783f249d901f', 'bdf37ae18f8955dd0a0d4c13c70b5013'),
	(84, 'bbe72958c6a5ffd380f122751f72cf32', 'Transferred to Sampath: Day to Day', '2024-08-19', 400.00, 'income', 'A', 1724055345, 1724055345, '42853ec7ccebc2c04f3340c8b6c74d36', 'bdf37ae18f8955dd0a0d4c13c70b5013'),
	(85, 'da5820dd64297a2d32061db2c5f6ef61', 'Payment Made', '2024-08-19', 2000.00, 'expense', 'A', 1724055365, 1724055365, '9fe7b9332f333ceae7f66c3d527651eb', 'bdf37ae18f8955dd0a0d4c13c70b5013'),
	(86, 'e20f8793665f057155f5685e66714cb8', 'Transferred from Sampath: Standby', '2024-08-22', 200.00, 'expense', 'A', 1724336518, 1724336518, '9fe7b9332f333ceae7f66c3d527651eb', 'bdf37ae18f8955dd0a0d4c13c70b5013'),
	(87, '558202e8794ee0bd31566b656dcbc537', 'Transferred to Sampath: Day to Day', '2024-08-22', 200.00, 'income', 'A', 1724336518, 1724336518, '42853ec7ccebc2c04f3340c8b6c74d36', 'bdf37ae18f8955dd0a0d4c13c70b5013'),
	(88, '6be63f6c2afc137c658f3aa59195b39a', 'Transferred from Sampath: Standby', '2024-08-22', 200.00, 'expense', 'A', 1724336543, 1724336543, '9fe7b9332f333ceae7f66c3d527651eb', 'bdf37ae18f8955dd0a0d4c13c70b5013'),
	(89, '226429c5bd06fcadf167390e3f2629f9', 'Transferred to Sampath: Day to Day', '2024-08-22', 200.00, 'income', 'A', 1724336543, 1724336543, '42853ec7ccebc2c04f3340c8b6c74d36', 'bdf37ae18f8955dd0a0d4c13c70b5013'),
	(90, 'd97546b18b279d1471896aa1378146dc', 'Transferred from Cash in Hand', '2024-08-22', 0.00, 'expense', 'A', 1724336628, 1724336628, '2d55834ae87ee76927f9783f249d901f', 'bdf37ae18f8955dd0a0d4c13c70b5013'),
	(91, '8301f5be5166bac1a56b54c588ed352e', 'Transferred to Sampath: Day to Day', '2024-08-22', 0.00, 'income', 'A', 1724336628, 1724336628, '42853ec7ccebc2c04f3340c8b6c74d36', 'bdf37ae18f8955dd0a0d4c13c70b5013'),
	(92, '188cb8b9e7271a6b28028bd997205620', 'Transferred from Cash in Hand', '2024-08-22', 12.00, 'expense', 'A', 1724343907, 1724343907, '2d55834ae87ee76927f9783f249d901f', 'bdf37ae18f8955dd0a0d4c13c70b5013'),
	(93, '5ce5d6bdc5076bc80ccde44929e5ef16', 'Transferred to Sampath: Day to Day', '2024-08-22', 12.00, 'income', 'A', 1724343907, 1724343907, '42853ec7ccebc2c04f3340c8b6c74d36', 'bdf37ae18f8955dd0a0d4c13c70b5013'),
	(94, '69c92ecdbc34e734f0339b451d300910', 'Transferred from Sampath: Standby', '2024-08-22', 120.00, 'expense', 'A', 1724343937, 1724343937, '9fe7b9332f333ceae7f66c3d527651eb', 'bdf37ae18f8955dd0a0d4c13c70b5013'),
	(95, '8533ca25cd77671b699d0869e53b6b02', 'Transferred to Cash in Hand', '2024-08-22', 120.00, 'income', 'A', 1724343937, 1724343937, '2d55834ae87ee76927f9783f249d901f', 'bdf37ae18f8955dd0a0d4c13c70b5013'),
	(96, 'fb38033d23d6878d8515830ebf3c5861', 'Transferred from Sampath: Standby', '2024-08-22', 120.00, 'expense', 'A', 1724343957, 1724343957, '9fe7b9332f333ceae7f66c3d527651eb', 'bdf37ae18f8955dd0a0d4c13c70b5013'),
	(97, '5050895ce30300bb8c7dc0d8b5d8aa7f', 'Transferred to Cash in Hand', '2024-08-22', 120.00, 'income', 'A', 1724343957, 1724343957, '2d55834ae87ee76927f9783f249d901f', 'bdf37ae18f8955dd0a0d4c13c70b5013'),
	(98, '4730e4d44ef118bb2c08516070d72b70', 'Transferred from Cash in Hand', '2024-08-22', 120.00, 'expense', 'A', 1724344185, 1724344185, '2d55834ae87ee76927f9783f249d901f', 'bdf37ae18f8955dd0a0d4c13c70b5013'),
	(99, 'ce75e04caf039f64abd525eb449938b6', 'Transferred to Sampath: Day to Day', '2024-08-22', 120.00, 'income', 'A', 1724344185, 1724344185, '42853ec7ccebc2c04f3340c8b6c74d36', 'bdf37ae18f8955dd0a0d4c13c70b5013'),
	(100, '309c4940ca9513bfc87a52d41177c65f', 'Transferred from Cash in Hand', '2024-08-22', 120.00, 'expense', 'A', 1724344930, 1724344930, '2d55834ae87ee76927f9783f249d901f', 'bdf37ae18f8955dd0a0d4c13c70b5013'),
	(101, 'b1da9d5f24943be065d24690326add4d', 'Transferred to Sampath: Day to Day', '2024-08-22', 120.00, 'income', 'A', 1724344930, 1724344930, '42853ec7ccebc2c04f3340c8b6c74d36', 'bdf37ae18f8955dd0a0d4c13c70b5013'),
	(102, '24ab46eb2ee61813adf6adedfc40fd69', 'Transferred from Sampath: Trip Planning', '2024-08-22', 600.00, 'expense', 'A', 1724344993, 1724344993, '90b3dc20e33d14ee2694c10b5f0814cf', 'bdf37ae18f8955dd0a0d4c13c70b5013'),
	(103, '0766d8a968504306f9162b5b64b5b6e0', 'Transferred to Sampath: Day to Day', '2024-08-22', 600.00, 'income', 'A', 1724344993, 1724344993, '42853ec7ccebc2c04f3340c8b6c74d36', 'bdf37ae18f8955dd0a0d4c13c70b5013'),
	(104, 'eec501a06632487eda3efddca9e11409', 'Transferred from Sampath: Trip Planning', '2024-08-22', 600.00, 'expense', 'A', 1724345041, 1724345041, '90b3dc20e33d14ee2694c10b5f0814cf', 'bdf37ae18f8955dd0a0d4c13c70b5013'),
	(105, 'c279562088c769ee4f5fa3ca98d74570', 'Transferred to Sampath: Day to Day', '2024-08-22', 600.00, 'income', 'A', 1724345041, 1724345041, '42853ec7ccebc2c04f3340c8b6c74d36', 'bdf37ae18f8955dd0a0d4c13c70b5013'),
	(106, '3b6e7efbce8bf30f0a08ea9751bafb2a', 'Transferred from Sampath: Trip Planning', '2024-08-22', 400.00, 'expense', 'A', 1724345112, 1724345112, '90b3dc20e33d14ee2694c10b5f0814cf', 'bdf37ae18f8955dd0a0d4c13c70b5013'),
	(107, '79c460e00444f395d6b552874981b37b', 'Transferred to Sampath: Day to Day', '2024-08-22', 400.00, 'income', 'A', 1724345112, 1724345112, '42853ec7ccebc2c04f3340c8b6c74d36', 'bdf37ae18f8955dd0a0d4c13c70b5013'),
	(108, '91f99f7e7212c1fe91d508b10e050cbf', 'Transferred from Cash in Hand', '2024-11-30', 7.00, 'expense', 'A', 1732992366, 1732992366, '2d55834ae87ee76927f9783f249d901f', 'bdf37ae18f8955dd0a0d4c13c70b5013'),
	(109, 'b70c967d4fcc99d109f3b346762e4a05', 'Transferred to Sampath: Day to Day', '2024-11-30', 7.00, 'income', 'A', 1732992366, 1732992366, '42853ec7ccebc2c04f3340c8b6c74d36', 'bdf37ae18f8955dd0a0d4c13c70b5013'),
	(121, '71bea6f73468eeacd5c6c330ac268e77', 'New Account', '2024-12-01', 2350.00, 'income', 'A', 1733046490, 1733046490, '5d584e6efe032ac132455fc222cc6a67', 'bdf37ae18f8955dd0a0d4c13c70b5013'),
	(122, '659a4ffb21a26e120a139044aa81cd34', 'New Accoutn', '2024-12-02', 2323.00, 'income', 'A', 1733154085, 1733154085, 'a59e19c63e9c08aa630885ef7fd4ce84', 'bdf37ae18f8955dd0a0d4c13c70b5013'),
	(123, '342e96d2954fb3b95eef9752d441b400', 'Icecream', '2024-12-03', 232.00, 'expense', 'A', 1733242988, 1733242988, '9fe7b9332f333ceae7f66c3d527651eb', 'bdf37ae18f8955dd0a0d4c13c70b5013'),
	(124, '9cd09b247a1e15d128eaa0a577fc4964', 'Payment Made', '2024-12-07', 2323.00, 'expense', 'A', 1733596774, 1733596774, '9fe7b9332f333ceae7f66c3d527651eb', '472944cd9f1577b490cd753628f02566'),
	(125, 'fe810bc22159cd81f3b1075750d791a4', 'Payment Made', '2024-12-07', 100.00, 'expense', 'A', 1733597593, 1733597593, '9fe7b9332f333ceae7f66c3d527651eb', 'bdf37ae18f8955dd0a0d4c13c70b5013'),
	(126, '3f47dbbb6bd7880ca555300808804dee', 'Transferred from Sampath: Standby', '2024-12-07', 1500.00, 'expense', 'A', 1733559042, 1733559042, '9fe7b9332f333ceae7f66c3d527651eb', 'bdf37ae18f8955dd0a0d4c13c70b5013'),
	(127, '40591dce70ffe2a5358999b4bdd8f754', 'Transferred to Cash in Hand', '2024-12-07', 1500.00, 'income', 'A', 1733559042, 1733559042, '2d55834ae87ee76927f9783f249d901f', 'bdf37ae18f8955dd0a0d4c13c70b5013'),
	(128, 'e33594e098a94b7652c8de522b75a50d', 'Icecream', '2024-12-07', 120.00, 'expense', 'A', 1733559498, 1733559498, '2d55834ae87ee76927f9783f249d901f', 'bdf37ae18f8955dd0a0d4c13c70b5013'),
	(129, 'e8f3fdd33c37ebced25e33d5f92637df', 'Icecream', '2024-12-07', 232.00, 'expense', 'A', 1733559726, 1733559726, '2d55834ae87ee76927f9783f249d901f', 'bdf37ae18f8955dd0a0d4c13c70b5013'),
	(130, 'efacf5b026aac9253fd779ba2ccc1698', 'Icecream', '2024-12-07', 232.00, 'expense', 'A', 1733559736, 1733559736, '2d55834ae87ee76927f9783f249d901f', 'bdf37ae18f8955dd0a0d4c13c70b5013'),
	(131, 'eea3d4ecdf48997236b0626eb7d46d70', 'Icecream', '2024-12-07', 23.00, 'expense', 'A', 1733560030, 1733560030, '2d55834ae87ee76927f9783f249d901f', 'bdf37ae18f8955dd0a0d4c13c70b5013'),
	(132, '375de051e9b595c76e6f04b9fc6060c1', 'Transferred from Cash in Hand', '2024-12-07', 23.00, 'expense', 'A', 1733560045, 1733560045, '2d55834ae87ee76927f9783f249d901f', 'bdf37ae18f8955dd0a0d4c13c70b5013'),
	(133, 'fcc081978cabf89e8f42fece2a99940e', 'Transferred to Sampath: Day to Day', '2024-12-07', 23.00, 'income', 'A', 1733560045, 1733560045, '42853ec7ccebc2c04f3340c8b6c74d36', 'bdf37ae18f8955dd0a0d4c13c70b5013'),
	(134, 'dc3b5bfc0dcd82bed7f53b964bb252e9', 'Icecream', '2024-12-07', 12.00, 'expense', 'A', 1733560073, 1733560073, '9fe7b9332f333ceae7f66c3d527651eb', 'bdf37ae18f8955dd0a0d4c13c70b5013'),
	(135, 'f3b249ec51a56970ca603a5c3b3111c6', 'Acition figures', '2024-12-07', 3950.00, 'expense', 'A', 1733571190, 1733571190, '90b3dc20e33d14ee2694c10b5f0814cf', '472944cd9f1577b490cd753628f02566'),
	(136, '09f68e628fb602f6fc9aa1a0fbfa50c1', 'New Card', '2024-12-07', 2000.00, 'income', 'A', 1733571293, 1733571293, '280a4a9e7339985e209aaf94643b5423', 'bdf37ae18f8955dd0a0d4c13c70b5013'),
	(137, '7dbb9321ddf5c54ea82c0aed7bd6d6db', 'Credit Card', '2024-12-07', 250000.00, 'income', 'A', 1733571322, 1733571322, 'a0c70d0ed2cc0870ffa4e318a3fd6c70', 'bdf37ae18f8955dd0a0d4c13c70b5013');

-- Dumping structure for table liquiditybuddy.travel
CREATE TABLE IF NOT EXISTS `travel` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `transporttype` varchar(50) NOT NULL DEFAULT '0',
  `cost` decimal(15,2) NOT NULL DEFAULT 0.00,
  `date` date NOT NULL,
  `createddatetime` int(11) NOT NULL DEFAULT 0,
  `updateddatefime` int(11) NOT NULL DEFAULT 0,
  `fromlocation` varchar(50) NOT NULL DEFAULT '0',
  `tolocation` varchar(50) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table liquiditybuddy.travel: ~0 rows (approximately)

-- Dumping structure for table liquiditybuddy.user
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sessionid` char(32) DEFAULT NULL,
  `contactno` varchar(15) DEFAULT NULL,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(50) DEFAULT '3e0cd7dbf477f6da9831acd7c1d617bc' COMMENT 'Abc@12345',
  `email` varchar(50) DEFAULT NULL,
  `status` char(1) DEFAULT 'A',
  PRIMARY KEY (`id`),
  UNIQUE KEY `sessionid` (`sessionid`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table liquiditybuddy.user: ~1 rows (approximately)
INSERT INTO `user` (`id`, `sessionid`, `contactno`, `username`, `password`, `email`, `status`) VALUES
	(2, '01b9ff2b173400203b74b4cbec306d6f', '0714583373', 'Visula', '3e0cd7dbf477f6da9831acd7c1d617bc', 'svisula@gmail.com', 'A');

-- Dumping structure for table liquiditybuddy.userstackholderlink
CREATE TABLE IF NOT EXISTS `userstackholderlink` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `usersessionid` char(32) DEFAULT NULL,
  `stackholdersessionid` char(32) DEFAULT NULL,
  `is_primary` enum('Y','N') DEFAULT 'N',
  UNIQUE KEY `id` (`id`),
  KEY `FK_userstackholderlink_user` (`usersessionid`),
  KEY `FK_userstackholderlink_stackholder` (`stackholdersessionid`),
  CONSTRAINT `FK_userstackholderlink_stackholder` FOREIGN KEY (`stackholdersessionid`) REFERENCES `stackholder` (`sessionid`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `FK_userstackholderlink_user` FOREIGN KEY (`usersessionid`) REFERENCES `user` (`sessionid`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table liquiditybuddy.userstackholderlink: ~0 rows (approximately)

-- Dumping structure for trigger liquiditybuddy.accountgroup_session_generation
SET @OLDTMP_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_ZERO_IN_DATE,NO_ZERO_DATE,NO_ENGINE_SUBSTITUTION';
DELIMITER //
CREATE TRIGGER `accountgroup_session_generation` BEFORE INSERT ON `accountgroup` FOR EACH ROW BEGIN
	SET NEW.sessionid = MD5(UUID());
END//
DELIMITER ;
SET SQL_MODE=@OLDTMP_SQL_MODE;

-- Dumping structure for trigger liquiditybuddy.account_session_generation
SET @OLDTMP_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO';
DELIMITER //
CREATE TRIGGER `account_session_generation` BEFORE INSERT ON `account` FOR EACH ROW BEGIN
	SET NEW.sessionid = MD5(UUID());
END//
DELIMITER ;
SET SQL_MODE=@OLDTMP_SQL_MODE;

-- Dumping structure for trigger liquiditybuddy.borrowed_session_generate
SET @OLDTMP_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_ZERO_IN_DATE,NO_ZERO_DATE,NO_ENGINE_SUBSTITUTION';
DELIMITER //
CREATE TRIGGER `borrowed_session_generate` BEFORE INSERT ON `borrowed` FOR EACH ROW BEGIN
	SET NEW.sessionid = MD5(UUID());
END//
DELIMITER ;
SET SQL_MODE=@OLDTMP_SQL_MODE;

-- Dumping structure for trigger liquiditybuddy.budget__session_generate
SET @OLDTMP_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_ZERO_IN_DATE,NO_ZERO_DATE,NO_ENGINE_SUBSTITUTION';
DELIMITER //
CREATE TRIGGER `budget__session_generate` BEFORE INSERT ON `budget` FOR EACH ROW BEGIN
	SET NEW.sessionid = MD5(UUID());
END//
DELIMITER ;
SET SQL_MODE=@OLDTMP_SQL_MODE;

-- Dumping structure for trigger liquiditybuddy.collectiondue_session_generate
SET @OLDTMP_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_ZERO_IN_DATE,NO_ZERO_DATE,NO_ENGINE_SUBSTITUTION';
DELIMITER //
CREATE TRIGGER `collectiondue_session_generate` BEFORE INSERT ON `collectiondue` FOR EACH ROW BEGIN
	SET NEW.sessionid = MD5(UUID());
END//
DELIMITER ;
SET SQL_MODE=@OLDTMP_SQL_MODE;

-- Dumping structure for trigger liquiditybuddy.collectionpaid_session_generate
SET @OLDTMP_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_ZERO_IN_DATE,NO_ZERO_DATE,NO_ENGINE_SUBSTITUTION';
DELIMITER //
CREATE TRIGGER `collectionpaid_session_generate` BEFORE INSERT ON `collectionpaid` FOR EACH ROW BEGIN
	SET NEW.sessionid = MD5(UUID());
END//
DELIMITER ;
SET SQL_MODE=@OLDTMP_SQL_MODE;

-- Dumping structure for trigger liquiditybuddy.collectionplan_session_generate
SET @OLDTMP_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_ZERO_IN_DATE,NO_ZERO_DATE,NO_ENGINE_SUBSTITUTION';
DELIMITER //
CREATE TRIGGER `collectionplan_session_generate` BEFORE INSERT ON `collectionplan` FOR EACH ROW BEGIN
	SET NEW.sessionid = MD5(UUID());
END//
DELIMITER ;
SET SQL_MODE=@OLDTMP_SQL_MODE;

-- Dumping structure for trigger liquiditybuddy.groupcollection_session_generate
SET @OLDTMP_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_ZERO_IN_DATE,NO_ZERO_DATE,NO_ENGINE_SUBSTITUTION';
DELIMITER //
CREATE TRIGGER `groupcollection_session_generate` BEFORE INSERT ON `groupcollection` FOR EACH ROW BEGIN
	SET NEW.sessionid = MD5(UUID());
END//
DELIMITER ;
SET SQL_MODE=@OLDTMP_SQL_MODE;

-- Dumping structure for trigger liquiditybuddy.participent_session_generate
SET @OLDTMP_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_ZERO_IN_DATE,NO_ZERO_DATE,NO_ENGINE_SUBSTITUTION';
DELIMITER //
CREATE TRIGGER `participent_session_generate` BEFORE INSERT ON `participent` FOR EACH ROW BEGIN
	SET NEW.sessionid = MD5(UUID());
END//
DELIMITER ;
SET SQL_MODE=@OLDTMP_SQL_MODE;

-- Dumping structure for trigger liquiditybuddy.payable_session_generation
SET @OLDTMP_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO';
DELIMITER //
CREATE TRIGGER `payable_session_generation` BEFORE INSERT ON `payable` FOR EACH ROW BEGIN
	SET NEW.sessionid = MD5(UUID());
END//
DELIMITER ;
SET SQL_MODE=@OLDTMP_SQL_MODE;

-- Dumping structure for trigger liquiditybuddy.paymentplan_session_generation
SET @OLDTMP_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO';
DELIMITER //
CREATE TRIGGER `paymentplan_session_generation` BEFORE INSERT ON `paymentplan` FOR EACH ROW BEGIN
	SET NEW.sessionid = MD5(UUID());
END//
DELIMITER ;
SET SQL_MODE=@OLDTMP_SQL_MODE;

-- Dumping structure for trigger liquiditybuddy.purchase_session_generation
SET @OLDTMP_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO';
DELIMITER //
CREATE TRIGGER `purchase_session_generation` BEFORE INSERT ON `purchase` FOR EACH ROW BEGIN
	SET NEW.sessionid = MD5(UUID());
END//
DELIMITER ;
SET SQL_MODE=@OLDTMP_SQL_MODE;

-- Dumping structure for trigger liquiditybuddy.shop_session_generate
SET @OLDTMP_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO';
DELIMITER //
CREATE TRIGGER `shop_session_generate` BEFORE INSERT ON `shop` FOR EACH ROW BEGIN
	SET NEW.sessionid = MD5(UUID());
END//
DELIMITER ;
SET SQL_MODE=@OLDTMP_SQL_MODE;

-- Dumping structure for trigger liquiditybuddy.stackholder_session_generate
SET @OLDTMP_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_ZERO_IN_DATE,NO_ZERO_DATE,NO_ENGINE_SUBSTITUTION';
DELIMITER //
CREATE TRIGGER `stackholder_session_generate` BEFORE INSERT ON `stackholder` FOR EACH ROW BEGIN
	SET NEW.sessionid = MD5(UUID());
END//
DELIMITER ;
SET SQL_MODE=@OLDTMP_SQL_MODE;

-- Dumping structure for trigger liquiditybuddy.transaction_session_generate
SET @OLDTMP_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO';
DELIMITER //
CREATE TRIGGER `transaction_session_generate` BEFORE INSERT ON `transaction` FOR EACH ROW BEGIN
	SET NEW.sessionid = MD5(UUID());
END//
DELIMITER ;
SET SQL_MODE=@OLDTMP_SQL_MODE;

-- Dumping structure for trigger liquiditybuddy.user_session_generate
SET @OLDTMP_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO';
DELIMITER //
CREATE TRIGGER `user_session_generate` BEFORE INSERT ON `user` FOR EACH ROW BEGIN
	SET NEW.sessionid = MD5(UUID());
END//
DELIMITER ;
SET SQL_MODE=@OLDTMP_SQL_MODE;

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
