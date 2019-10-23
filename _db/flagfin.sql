-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Oct 23, 2019 at 03:30 PM
-- Server version: 5.7.26
-- PHP Version: 7.3.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `flagfin`
--

-- --------------------------------------------------------

--
-- Table structure for table `aspnetroleclaims`
--

DROP TABLE IF EXISTS `aspnetroleclaims`;
CREATE TABLE IF NOT EXISTS `aspnetroleclaims` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `RoleId` varchar(255) NOT NULL,
  `ClaimType` longtext,
  `ClaimValue` longtext,
  PRIMARY KEY (`Id`),
  KEY `IX_AspNetRoleClaims_RoleId` (`RoleId`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `aspnetroles`
--

DROP TABLE IF EXISTS `aspnetroles`;
CREATE TABLE IF NOT EXISTS `aspnetroles` (
  `Id` varchar(255) NOT NULL,
  `Name` varchar(256) DEFAULT NULL,
  `NormalizedName` varchar(256) DEFAULT NULL,
  `ConcurrencyStamp` longtext,
  PRIMARY KEY (`Id`),
  UNIQUE KEY `RoleNameIndex` (`NormalizedName`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `aspnetroles`
--

INSERT INTO `aspnetroles` (`Id`, `Name`, `NormalizedName`, `ConcurrencyStamp`) VALUES
('a0777e43-755e-4101-b9dc-4b8be88ce442', 'Admin', 'ADMIN', '571410c0-a0e8-4c8b-b2a9-d598bbfb21ad'),
('b2732f2c-ef59-42ae-a635-bfa325110217', 'BasicUser', 'BASICUSER', '1e74e6a5-3aa6-4b99-8ed7-72a1c9916586');

-- --------------------------------------------------------

--
-- Table structure for table `aspnetuserclaims`
--

DROP TABLE IF EXISTS `aspnetuserclaims`;
CREATE TABLE IF NOT EXISTS `aspnetuserclaims` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `UserId` varchar(255) NOT NULL,
  `ClaimType` longtext,
  `ClaimValue` longtext,
  PRIMARY KEY (`Id`),
  KEY `IX_AspNetUserClaims_UserId` (`UserId`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `aspnetuserclaims`
--

INSERT INTO `aspnetuserclaims` (`Id`, `UserId`, `ClaimType`, `ClaimValue`) VALUES
(1, '0c05c288-004d-477f-b835-f40cb6672037', 'userName', 'QAfg'),
(2, '0c05c288-004d-477f-b835-f40cb6672037', 'firstName', 'QAfghfgh'),
(3, '0c05c288-004d-477f-b835-f40cb6672037', 'lastName', 'QAfgfgh'),
(4, '0c05c288-004d-477f-b835-f40cb6672037', 'email', 'test1121@ccd5656567.com'),
(5, '0c05c288-004d-477f-b835-f40cb6672037', 'role', 'BasicUser');

-- --------------------------------------------------------

--
-- Table structure for table `aspnetuserlogins`
--

DROP TABLE IF EXISTS `aspnetuserlogins`;
CREATE TABLE IF NOT EXISTS `aspnetuserlogins` (
  `LoginProvider` varchar(255) NOT NULL,
  `ProviderKey` varchar(255) NOT NULL,
  `ProviderDisplayName` longtext,
  `UserId` varchar(255) NOT NULL,
  PRIMARY KEY (`LoginProvider`,`ProviderKey`),
  KEY `IX_AspNetUserLogins_UserId` (`UserId`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `aspnetuserroles`
--

DROP TABLE IF EXISTS `aspnetuserroles`;
CREATE TABLE IF NOT EXISTS `aspnetuserroles` (
  `UserId` varchar(255) NOT NULL,
  `RoleId` varchar(255) NOT NULL,
  PRIMARY KEY (`UserId`,`RoleId`),
  KEY `IX_AspNetUserRoles_RoleId` (`RoleId`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `aspnetuserroles`
--

INSERT INTO `aspnetuserroles` (`UserId`, `RoleId`) VALUES
('0c05c288-004d-477f-b835-f40cb6672037', 'b2732f2c-ef59-42ae-a635-bfa325110217'),
('102d211d-574d-45ae-91a4-45332d1ea58b', 'b2732f2c-ef59-42ae-a635-bfa325110217'),
('222be44f-fa00-488a-a7a4-3775b1855416', 'b2732f2c-ef59-42ae-a635-bfa325110217'),
('3a8a9665-9d15-4ea2-b918-27765825e76e', 'b2732f2c-ef59-42ae-a635-bfa325110217'),
('43f31c3a-6ceb-49dd-9ef7-23cf31ec8877', 'b2732f2c-ef59-42ae-a635-bfa325110217'),
('4896d082-d26b-4f02-b276-3d77524d5f8b', 'a0777e43-755e-4101-b9dc-4b8be88ce442'),
('4896d082-d26b-4f02-b276-3d77524d5f8b', 'b2732f2c-ef59-42ae-a635-bfa325110217'),
('4f59c51b-e09a-4aa7-a80e-52b4218c62eb', 'b2732f2c-ef59-42ae-a635-bfa325110217'),
('5e0b187c-e14a-4dc1-86f1-6e73eb2ce9b6', 'b2732f2c-ef59-42ae-a635-bfa325110217'),
('6e7cfa72-2742-4bef-94ed-946de2b3b9b7', 'b2732f2c-ef59-42ae-a635-bfa325110217');

-- --------------------------------------------------------

--
-- Table structure for table `aspnetusers`
--

DROP TABLE IF EXISTS `aspnetusers`;
CREATE TABLE IF NOT EXISTS `aspnetusers` (
  `Id` varchar(255) NOT NULL,
  `UserName` varchar(256) DEFAULT NULL,
  `NormalizedUserName` varchar(256) DEFAULT NULL,
  `Email` varchar(256) DEFAULT NULL,
  `NormalizedEmail` varchar(256) DEFAULT NULL,
  `EmailConfirmed` bit(1) NOT NULL,
  `PasswordHash` longtext,
  `SecurityStamp` longtext,
  `ConcurrencyStamp` longtext,
  `PhoneNumber` longtext,
  `PhoneNumberConfirmed` bit(1) NOT NULL,
  `TwoFactorEnabled` bit(1) NOT NULL,
  `LockoutEnd` datetime(6) DEFAULT NULL,
  `LockoutEnabled` bit(1) NOT NULL,
  `AccessFailedCount` int(11) NOT NULL,
  `FirstName` longtext,
  `LastName` longtext,
  PRIMARY KEY (`Id`),
  UNIQUE KEY `UserNameIndex` (`NormalizedUserName`),
  KEY `EmailIndex` (`NormalizedEmail`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `aspnetusers`
--

INSERT INTO `aspnetusers` (`Id`, `UserName`, `NormalizedUserName`, `Email`, `NormalizedEmail`, `EmailConfirmed`, `PasswordHash`, `SecurityStamp`, `ConcurrencyStamp`, `PhoneNumber`, `PhoneNumberConfirmed`, `TwoFactorEnabled`, `LockoutEnd`, `LockoutEnabled`, `AccessFailedCount`, `FirstName`, `LastName`) VALUES
('4896d082-d26b-4f02-b276-3d77524d5f8b', 'chin', 'CHIN', 'chin@chin.chin', 'CHIN@CHIN.CHIN', b'0', 'AQAAAAEAACcQAAAAEIz347f9WzF7Q1No5FTYHT52H+ejLlWl0L0ahfDWCk8TinmD6/mmzz8U1GJQzDJKTg==', '7DEE5EIRKK2Z3GUNZQLPBW5WRVMBQLK5', '5516d3bc-af1e-44ce-bbed-9f102ac18e50', NULL, b'0', b'0', NULL, b'1', 0, 'chinthaka', 'fernando'),
('6e7cfa72-2742-4bef-94ed-946de2b3b9b7', 'test', 'TEST', 'test1121@ccd5656567.com', 'TEST1121@CCD5656567.COM', b'0', 'AQAAAAEAACcQAAAAEFKy8RM/6FGewp7UYHmCL3tgmzCwWhqGxC2TN6f8iGKDoIdUXe8BhCKu5PKh/rnfqQ==', 'G5F5WVZT4MY4D7I6X6XLKVV3BLEOSOYM', '40f7eb27-4726-49be-b5b6-26ce64bc51cc', NULL, b'0', b'0', NULL, b'1', 0, 'test', 'test'),
('4f59c51b-e09a-4aa7-a80e-52b4218c62eb', 'test123', 'TEST123', 'test1121@ccd5656567.com', 'TEST1121@CCD5656567.COM', b'0', 'AQAAAAEAACcQAAAAELZkyfLaiByMMhSw56gp0FOKl3hcOTS9eYBWJDCMew2KBSSOoC5PVIgHPWQpem4fkg==', '4UJ2OW373WTTPTP3E47QP6WGMJ4W3SCY', 'adc3392e-8347-46ef-8e4d-5552fd65c0af', NULL, b'0', b'0', NULL, b'1', 0, 'testghjgfhgfh', 'testrst'),
('3a8a9665-9d15-4ea2-b918-27765825e76e', 'test223', 'TEST223', 'test1121@ccd5656567.com', 'TEST1121@CCD5656567.COM', b'0', 'AQAAAAEAACcQAAAAEKOeXGhO0YtvaTSayVwdWrYYtNTCHjfFkgrtY2KwlpSLZdUGYnNGCk4PADUfK2aE1A==', 'APX3FFA4TUUY23MRW7SXHTJDJAZGSSS4', 'd1cb7e6e-1474-4621-9f7c-9e746bc70b21', NULL, b'0', b'0', NULL, b'1', 0, 'fgfdgdfgfdg', 'fdgfdgdgg'),
('5e0b187c-e14a-4dc1-86f1-6e73eb2ce9b6', 'test556', 'TEST556', 'test1121@ccd5656567.com', 'TEST1121@CCD5656567.COM', b'0', 'AQAAAAEAACcQAAAAEBvQtD/mKfcyfBU475lmZ4WMUq82nAeaci1CbmzVicHe2fN290HxfiulolJ0KivlSQ==', 'MNTJ45EH7R7Y6NIEZKFVLRKI6K5IORNE', 'ef9c11f5-a5bc-4865-89fa-76441b212444', NULL, b'0', b'0', NULL, b'1', 0, 'ghjgfhfhgfh123', 'fghgfhfgh'),
('102d211d-574d-45ae-91a4-45332d1ea58b', 'tfdgdgdg', 'TFDGDGDG', 'test1121@ccd5656567.com', 'TEST1121@CCD5656567.COM', b'0', 'AQAAAAEAACcQAAAAEAa4WgCm491jgdS7r+Cd7zD3Lv6Ez12YgdA1c8Iht1hVf1e9t9TpccqG9UIGI5VjJQ==', 'JVVPDWN6BGJ4UQHSEGOT4NGHOWELHLDU', 'df9f56da-a70f-4bcc-b6cb-bd54d3e1d06c', NULL, b'0', b'0', NULL, b'1', 0, 'test_fistname', 'calceytest'),
('43f31c3a-6ceb-49dd-9ef7-23cf31ec8877', 'vbnvnvbn', 'VBNVNVBN', 'nilenth@calcey.com', 'NILENTH@CALCEY.COM', b'0', 'AQAAAAEAACcQAAAAEP0P0rpvrTvEuxNhVVC6xysu2yinRyL9AA8zAklIfz/SRnIBT7cpBZROqttTSetRRQ==', 'IECXB3KCF6QKKFI2HKHNPMTMUDO44BN3', '4af22ec6-3e5d-4259-a782-48c73872a4c2', NULL, b'0', b'0', NULL, b'1', 0, 'test_fistname', 'test_lastname'),
('222be44f-fa00-488a-a7a4-3775b1855416', 'fghfghfgh', 'FGHFGHFGH', 'test1121@ccd56gnhghhg56567.com', 'TEST1121@CCD56GNHGHHG56567.COM', b'0', 'AQAAAAEAACcQAAAAELwsSt9S2v74yGpNShySrtpdiwa+qs6YIBi13WLIThVxBT5vk5a0E4U0vNpePU2KWQ==', 'KYS3KBIIPAXLLVZZEJUN6JAD2UGW77ZK', '8f33325f-04b6-45a9-b878-0dc21ecc8a8a', NULL, b'0', b'0', NULL, b'1', 0, 'test_fistname', 'test_lastname'),
('0c05c288-004d-477f-b835-f40cb6672037', 'QAfg', 'QAFG', 'test1121@ccd5656567.com', 'TEST1121@CCD5656567.COM', b'0', 'AQAAAAEAACcQAAAAELKJ7sg9iQB/1tGmSX+nDnxgOIPvPElAONYFaSqmE1rXPykYI40cy6CJDy1NJS46Lw==', '65IKCR5JXYOTAJGJ7C4GQFK2HRYIUGP6', '9fe9e910-bb39-49e8-b5d6-7959948e7f88', NULL, b'0', b'0', NULL, b'1', 0, 'QAfghfgh', 'QAfgfgh');

-- --------------------------------------------------------

--
-- Table structure for table `aspnetusertokens`
--

DROP TABLE IF EXISTS `aspnetusertokens`;
CREATE TABLE IF NOT EXISTS `aspnetusertokens` (
  `UserId` varchar(255) NOT NULL,
  `LoginProvider` varchar(255) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `Value` longtext,
  PRIMARY KEY (`UserId`,`LoginProvider`,`Name`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

DROP TABLE IF EXISTS `employees`;
CREATE TABLE IF NOT EXISTS `employees` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `UserId` varchar(255) DEFAULT NULL,
  `JobTitle` longtext,
  PRIMARY KEY (`Id`),
  KEY `IX_Employees_UserId` (`UserId`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`Id`, `UserId`, `JobTitle`) VALUES
(1, '4896d082-d26b-4f02-b276-3d77524d5f8b', NULL),
(2, '6e7cfa72-2742-4bef-94ed-946de2b3b9b7', NULL),
(3, '4f59c51b-e09a-4aa7-a80e-52b4218c62eb', NULL),
(4, '3a8a9665-9d15-4ea2-b918-27765825e76e', NULL),
(5, '5e0b187c-e14a-4dc1-86f1-6e73eb2ce9b6', NULL),
(6, '102d211d-574d-45ae-91a4-45332d1ea58b', NULL),
(7, '43f31c3a-6ceb-49dd-9ef7-23cf31ec8877', NULL),
(8, '222be44f-fa00-488a-a7a4-3775b1855416', NULL),
(9, '0c05c288-004d-477f-b835-f40cb6672037', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

DROP TABLE IF EXISTS `reviews`;
CREATE TABLE IF NOT EXISTS `reviews` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `ReviewerId` int(11) DEFAULT NULL,
  `EmployeeId` int(11) DEFAULT NULL,
  `Status` int(11) NOT NULL,
  `Comment` longtext,
  `Name` longtext,
  PRIMARY KEY (`Id`),
  KEY `IX_Reviews_EmployeeId` (`EmployeeId`),
  KEY `IX_Reviews_ReviewerId` (`ReviewerId`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`Id`, `ReviewerId`, `EmployeeId`, `Status`, `Comment`, `Name`) VALUES
(1, 6, 4, 2, 'test', 'test'),
(2, 2, 4, 1, 'test', 'test23232'),
(3, 6, 3, 1, 'test', 'test11244'),
(4, 6, 3, 1, 'test', 'chin1212');

-- --------------------------------------------------------

--
-- Table structure for table `__efmigrationshistory`
--

DROP TABLE IF EXISTS `__efmigrationshistory`;
CREATE TABLE IF NOT EXISTS `__efmigrationshistory` (
  `MigrationId` varchar(95) NOT NULL,
  `ProductVersion` varchar(32) NOT NULL,
  PRIMARY KEY (`MigrationId`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `__efmigrationshistory`
--

INSERT INTO `__efmigrationshistory` (`MigrationId`, `ProductVersion`) VALUES
('20191023133843_InitialCreate', '2.2.6-servicing-10079');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
