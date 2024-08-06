-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               10.4.14-MariaDB - mariadb.org binary distribution
-- Server OS:                    Win64
-- HeidiSQL Version:             11.2.0.6213
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for cms
CREATE DATABASE IF NOT EXISTS `cms` /*!40100 DEFAULT CHARACTER SET utf8mb4 */;
USE `cms`;

-- Dumping structure for table cms.account
CREATE TABLE IF NOT EXISTS `account` (
  `accountid` int(11) NOT NULL AUTO_INCREMENT,
  `accountno` char(16) NOT NULL,
  `name` varchar(50) DEFAULT NULL,
  `description` varchar(50) DEFAULT NULL,
  `runningbal` decimal(20,6) DEFAULT 0.000000,
  `initdate` timestamp NULL DEFAULT current_timestamp(),
  `clodate` timestamp NULL DEFAULT NULL,
  `status` char(1) DEFAULT 'A',
  PRIMARY KEY (`accountid`),
  UNIQUE KEY `accountno` (`accountno`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Data exporting was unselected.

-- Dumping structure for table cms.acc_user_link
CREATE TABLE IF NOT EXISTS `acc_user_link` (
  `acc_user_linkid` int(11) NOT NULL AUTO_INCREMENT,
  `accountid` int(11) NOT NULL DEFAULT 0,
  `userid` int(11) NOT NULL DEFAULT 0,
  `status` char(1) NOT NULL DEFAULT 'A',
  PRIMARY KEY (`acc_user_linkid`),
  UNIQUE KEY `accountid_userid` (`accountid`,`userid`),
  KEY `FK_acc_user_link_user` (`userid`),
  CONSTRAINT `FK_acc_user_link_account` FOREIGN KEY (`accountid`) REFERENCES `account` (`accountid`),
  CONSTRAINT `FK_acc_user_link_user` FOREIGN KEY (`userid`) REFERENCES `user` (`userid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Data exporting was unselected.

-- Dumping structure for table cms.borrow
CREATE TABLE IF NOT EXISTS `borrow` (
  `borrowid` int(11) NOT NULL AUTO_INCREMENT,
  `remark` varchar(50) NOT NULL,
  `borrowdte` date NOT NULL DEFAULT current_timestamp(),
  `borrowedamt` decimal(20,6) NOT NULL DEFAULT 0.000000,
  `interestrate` decimal(5,2) NOT NULL DEFAULT 0.00,
  `interesttype` enum('M','Q','H','A','N') NOT NULL DEFAULT 'M',
  `loan-lend` enum('loan','lend') NOT NULL DEFAULT 'loan',
  `loancusid` int(11) NOT NULL DEFAULT 0,
  `lendcusid` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`borrowid`),
  KEY `FK_borrow_customer` (`loancusid`) USING BTREE,
  KEY `FK_borrow_customer_2` (`lendcusid`),
  CONSTRAINT `FK_borrow_customer` FOREIGN KEY (`loancusid`) REFERENCES `customer` (`customerid`),
  CONSTRAINT `FK_borrow_customer_2` FOREIGN KEY (`lendcusid`) REFERENCES `customer` (`customerid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Data exporting was unselected.

-- Dumping structure for table cms.company
CREATE TABLE IF NOT EXISTS `company` (
  `companyid` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL DEFAULT '0',
  `description` varchar(50) NOT NULL DEFAULT '0',
  `contactno` varchar(16) NOT NULL DEFAULT '0',
  PRIMARY KEY (`companyid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Data exporting was unselected.

-- Dumping structure for table cms.customer
CREATE TABLE IF NOT EXISTS `customer` (
  `customerid` int(11) NOT NULL AUTO_INCREMENT,
  `title` enum('Mr.','Mrs.','Miss','Master','Thero') DEFAULT 'Mr.',
  `firstname` varchar(50) DEFAULT NULL,
  `lastname` varchar(50) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `contactno` char(12) DEFAULT NULL,
  `address` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`customerid`),
  UNIQUE KEY `contactno` (`contactno`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Data exporting was unselected.

-- Dumping structure for table cms.dues
CREATE TABLE IF NOT EXISTS `dues` (
  `dueid` int(11) NOT NULL AUTO_INCREMENT,
  `duedte` date DEFAULT current_timestamp(),
  `dueamt` decimal(20,6) DEFAULT NULL,
  `discount` decimal(20,6) DEFAULT NULL,
  `paidamt` decimal(20,6) DEFAULT NULL,
  PRIMARY KEY (`dueid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Data exporting was unselected.

-- Dumping structure for table cms.due_paid
CREATE TABLE IF NOT EXISTS `due_paid` (
  `due_paidid` int(11) NOT NULL AUTO_INCREMENT,
  `dueid` int(11) NOT NULL DEFAULT 0,
  `transactionid` int(11) NOT NULL DEFAULT 0,
  `settledamount` decimal(20,6) NOT NULL DEFAULT 0.000000,
  PRIMARY KEY (`due_paidid`),
  UNIQUE KEY `dueid_transactionid` (`dueid`,`transactionid`),
  KEY `FK_due_paid_transaction` (`transactionid`),
  CONSTRAINT `FK_due_paid_dues` FOREIGN KEY (`dueid`) REFERENCES `dues` (`dueid`),
  CONSTRAINT `FK_due_paid_transaction` FOREIGN KEY (`transactionid`) REFERENCES `transaction` (`transactionid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Data exporting was unselected.

-- Dumping structure for table cms.purchases
CREATE TABLE IF NOT EXISTS `purchases` (
  `purchasesid` int(11) NOT NULL AUTO_INCREMENT,
  `item` varchar(50) NOT NULL DEFAULT '0',
  `price` decimal(20,6) NOT NULL DEFAULT 0.000000,
  `companyid` int(11) NOT NULL DEFAULT 0,
  `transactionid` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`purchasesid`),
  KEY `FK_purchases_company` (`companyid`),
  KEY `FK_purchases_transactions` (`transactionid`),
  CONSTRAINT `FK_purchases_company` FOREIGN KEY (`companyid`) REFERENCES `company` (`companyid`),
  CONSTRAINT `FK_purchases_transactions` FOREIGN KEY (`transactionid`) REFERENCES `transaction` (`transactionid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Data exporting was unselected.

-- Dumping structure for table cms.schdpayments
CREATE TABLE IF NOT EXISTS `schdpayments` (
  `scheduledpaymentsid` int(11) NOT NULL AUTO_INCREMENT,
  `description` varchar(50) NOT NULL,
  `type` enum('I','E') DEFAULT NULL COMMENT 'Income or Expense',
  `periodtype` enum('M','Q','H','A','O','N') DEFAULT 'M' COMMENT '''Monthly'',''Quarterly'',''Half'',''Anual'',''Onetime'',''None of the Above''',
  `manualperiod` decimal(6,3) DEFAULT NULL COMMENT 'in Days',
  `amount` decimal(20,6) DEFAULT 0.000000,
  `rate` decimal(5,2) DEFAULT 0.00 COMMENT 'Rate of payment',
  `initateddate` date DEFAULT current_timestamp(),
  `expiredate` date DEFAULT NULL,
  `customerid` int(11) DEFAULT NULL,
  `status` char(1) NOT NULL DEFAULT 'A',
  PRIMARY KEY (`scheduledpaymentsid`),
  KEY `FK_scheduledpayments_customer` (`customerid`),
  CONSTRAINT `FK_scheduledpayments_customer` FOREIGN KEY (`customerid`) REFERENCES `customer` (`customerid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Data exporting was unselected.

-- Dumping structure for table cms.transaction
CREATE TABLE IF NOT EXISTS `transaction` (
  `transactionid` int(11) NOT NULL AUTO_INCREMENT,
  `accountid` int(11) NOT NULL,
  `countno` int(11) NOT NULL,
  `description` varchar(50) DEFAULT '0',
  `transactiontype` enum('I','E') NOT NULL DEFAULT 'I',
  `crdr` enum('CR','DR') NOT NULL DEFAULT 'CR',
  `amount` decimal(20,6) NOT NULL DEFAULT 0.000000,
  `openingamt` decimal(20,6) NOT NULL DEFAULT 0.000000,
  `date` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`transactionid`),
  UNIQUE KEY `accountid_countno` (`accountid`,`countno`),
  CONSTRAINT `FK_transaction_account` FOREIGN KEY (`accountid`) REFERENCES `account` (`accountid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Data exporting was unselected.

-- Dumping structure for table cms.transport
CREATE TABLE IF NOT EXISTS `transport` (
  `transportid` int(11) NOT NULL AUTO_INCREMENT,
  `transactionid` int(11) NOT NULL DEFAULT 0,
  `description` varchar(50) NOT NULL DEFAULT '0',
  `transporttype` enum('Bus','Train','Three Wheel','Car','Van') NOT NULL DEFAULT 'Bus',
  `fromlocation` varchar(50) NOT NULL DEFAULT '0',
  `tolocation` varchar(50) NOT NULL DEFAULT '0',
  `expense` decimal(20,6) NOT NULL DEFAULT 0.000000,
  PRIMARY KEY (`transportid`),
  KEY `FK__transactions` (`transactionid`),
  CONSTRAINT `FK__transactions` FOREIGN KEY (`transactionid`) REFERENCES `transaction` (`transactionid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Data exporting was unselected.

-- Dumping structure for table cms.user
CREATE TABLE IF NOT EXISTS `user` (
  `userid` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL DEFAULT '0',
  `customerid` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`userid`),
  UNIQUE KEY `username` (`username`),
  KEY `FK_user_customer` (`customerid`),
  CONSTRAINT `FK_user_customer` FOREIGN KEY (`customerid`) REFERENCES `customer` (`customerid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Data exporting was unselected.

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
