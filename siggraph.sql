-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3308
-- Generation Time: Jan 27, 2023 at 01:29 PM
-- Server version: 8.0.31
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `siggraph`
--

DELIMITER $$
--
-- Procedures
--
DROP PROCEDURE IF EXISTS `CheckIfAdmin`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `CheckIfAdmin` (IN `mUSN` VARCHAR(10), OUT `aUSN` VARCHAR(10))   BEGIN
	SELECT USN INTO aUSN FROM administrators WHERE USN=mUSN;
END$$

DROP PROCEDURE IF EXISTS `EnrollCount`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `EnrollCount` (OUT `ecount` INT)   BEGIN
	SELECT COUNT(*) FROM event_enrolled WHERE EventID IN (SELECT EventID FROM events WHERE STATUS='ONGOING') into ecount;
END$$

DROP PROCEDURE IF EXISTS `FeesCount`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `FeesCount` (OUT `fcount` INT)   BEGIN
	SELECT SUM(Amount) FROM fees_paid into fcount;
END$$

DROP PROCEDURE IF EXISTS `MemberCount`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `MemberCount` (OUT `mcount` INT)   BEGIN
	SELECT COUNT(*) FROM members into mcount;
END$$

DROP PROCEDURE IF EXISTS `PaidCount`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `PaidCount` (OUT `pcount` INT)   BEGIN
	SELECT COUNT(*) FROM fees_paid into pcount;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `administrators`
--

DROP TABLE IF EXISTS `administrators`;
CREATE TABLE IF NOT EXISTS `administrators` (
  `USN` varchar(10) NOT NULL,
  `Admin_date` date NOT NULL,
  PRIMARY KEY (`USN`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `administrators`
--

INSERT INTO `administrators` (`USN`, `Admin_date`) VALUES
('1BG20CS046', '2023-01-26'),
('root', '2023-01-27');

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

DROP TABLE IF EXISTS `events`;
CREATE TABLE IF NOT EXISTS `events` (
  `EventID` int NOT NULL,
  `EventName` varchar(50) NOT NULL,
  `Date` date NOT NULL,
  `Status` varchar(10) NOT NULL DEFAULT 'DONE',
  PRIMARY KEY (`EventID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`EventID`, `EventName`, `Date`, `Status`) VALUES
(99, 'Club Orientation', '2023-01-07', 'DONE'),
(100, 'Understanding Graphic Design', '2023-02-12', 'DONE'),
(2186785, 'Understanding Graphic Design', '2023-02-12', 'ONGOING');

-- --------------------------------------------------------

--
-- Table structure for table `event_enrolled`
--

DROP TABLE IF EXISTS `event_enrolled`;
CREATE TABLE IF NOT EXISTS `event_enrolled` (
  `USN` varchar(10) NOT NULL,
  `EventID` int NOT NULL,
  `EnrollDate` date NOT NULL,
  PRIMARY KEY (`USN`,`EventID`),
  KEY `EventID` (`EventID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `event_enrolled`
--

INSERT INTO `event_enrolled` (`USN`, `EventID`, `EnrollDate`) VALUES
('1BG20AI057', 2186785, '2023-01-27'),
('1BG20CS012', 2186785, '2023-01-27'),
('1BG20CS046', 2186785, '2023-01-27');

-- --------------------------------------------------------

--
-- Table structure for table `fees_paid`
--

DROP TABLE IF EXISTS `fees_paid`;
CREATE TABLE IF NOT EXISTS `fees_paid` (
  `PaymentID` int NOT NULL,
  `USN` varchar(10) NOT NULL,
  `Amount` int NOT NULL,
  `PaymentDate` date NOT NULL,
  PRIMARY KEY (`PaymentID`),
  KEY `USN` (`USN`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `fees_paid`
--

INSERT INTO `fees_paid` (`PaymentID`, `USN`, `Amount`, `PaymentDate`) VALUES
(212791588, '1BG20CS046', 500, '2023-01-27'),
(2147483647, 'ROOT', 100, '2023-01-26'),
(440434708, '1BG20CS002', 100, '2023-01-27'),
(864616353, '1BG20CS014', 500, '2023-01-27'),
(356950287, '1BG20CS012', 100, '2023-01-27'),
(757631882, '1BG20AI057', 100, '2023-01-27');

--
-- Triggers `fees_paid`
--
DROP TRIGGER IF EXISTS `MemberSet`;
DELIMITER $$
CREATE TRIGGER `MemberSet` AFTER INSERT ON `fees_paid` FOR EACH ROW UPDATE other_details SET Role = 'Siggraph Member' WHERE USN=NEW.USN
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `members`
--

DROP TABLE IF EXISTS `members`;
CREATE TABLE IF NOT EXISTS `members` (
  `USN` varchar(10) NOT NULL,
  `FName` varchar(30) NOT NULL,
  `LName` varchar(30) NOT NULL,
  `EmailID` varchar(30) NOT NULL,
  `Password` varchar(30) NOT NULL,
  PRIMARY KEY (`USN`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `members`
--

INSERT INTO `members` (`USN`, `FName`, `LName`, `EmailID`, `Password`) VALUES
('1BG20CS002', 'ABHISHEK', 'K A', 'abhirock@gmail.com', 'abhirocks'),
('1BG20EC023', 'KUSHAL', 'M', 'kushalm@gmail.com', 'kushalm'),
('1BG20CS046', 'KASHYAP', 'RAYAS', 'kashyap.rayas@gmail.com', 'hawkeye'),
('ROOT', 'ADMINISTRATOR', '', '', 'root'),
('1BG20CS014', 'ANAND', 'V A', 'anandva@proton.me', 'anand'),
('1BG20CS012', 'AMOGH', 'KRISHNA', 'beckendorfkrishna@gmail.com', 'proudofyouboy'),
('1BG20AI057', 'NISARGA', 'S', 'nisargashashidar@gmail.com', 'nisrocks');

--
-- Triggers `members`
--
DROP TRIGGER IF EXISTS `SetOthers`;
DELIMITER $$
CREATE TRIGGER `SetOthers` AFTER INSERT ON `members` FOR EACH ROW INSERT INTO `other_details` VALUES(NEW.USN, 'Not Set', 'Not Set', 'Not Set', 'Visitor')
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `other_details`
--

DROP TABLE IF EXISTS `other_details`;
CREATE TABLE IF NOT EXISTS `other_details` (
  `USN` varchar(10) NOT NULL,
  `Branch` varchar(10) NOT NULL,
  `Semester` varchar(10) NOT NULL,
  `Section` varchar(10) NOT NULL,
  `Role` varchar(30) NOT NULL DEFAULT 'Visitor',
  PRIMARY KEY (`USN`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `other_details`
--

INSERT INTO `other_details` (`USN`, `Branch`, `Semester`, `Section`, `Role`) VALUES
('ROOT', 'Not Set', 'Not Set', 'Not Set', 'Siggraph Member'),
('1BG20CS046', 'cse', '5th', 'a', 'Siggraph Member'),
('1BG20CS002', 'Not Set', 'Not Set', 'Not Set', 'Siggraph Member'),
('1BG20EC023', 'Not Set', 'Not Set', 'Not Set', 'Visitor'),
('1BG20CS014', 'cse', '5th', 'a', 'Siggraph Joker'),
('1BG20CS012', 'cse', '5th', 'a', 'Siggraph Helper'),
('1BG20AI057', 'aiml', '5th', 'Not Set', 'Siggraph Member');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
