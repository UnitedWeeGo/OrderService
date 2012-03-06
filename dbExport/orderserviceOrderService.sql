-- phpMyAdmin SQL Dump
-- version 3.3.9.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Feb 29, 2012 at 10:11 AM
-- Server version: 5.5.9
-- PHP Version: 5.3.5

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `orderservice`
--

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `customerid` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `phonenumber` varchar(255) NOT NULL,
  `orderid` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`customerid`),
  KEY `orderid` (`orderid`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=372 ;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` VALUES(370, 'Nick', '123-123-1233', 576, 'CEO', 'nick@nick.com');
INSERT INTO `customer` VALUES(371, 'Nick2', '23442323423432', 577, '', '');

-- --------------------------------------------------------

--
-- Table structure for table `instance`
--

CREATE TABLE `instance` (
  `instanceid` int(11) NOT NULL AUTO_INCREMENT,
  `friendlyappname` varchar(255) NOT NULL,
  `twilioaccountsid` varchar(255) NOT NULL,
  `twilioauthtoken` varchar(255) NOT NULL,
  `twiliophonenumber` varchar(255) NOT NULL,
  `twiliosmsmessage` varchar(255) NOT NULL,
  PRIMARY KEY (`instanceid`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=455 ;

--
-- Dumping data for table `instance`
--

INSERT INTO `instance` VALUES(26, 'ShortBusSubs', 'AC6ca7bc22d08b4120b17763a3216b67c7', '02804533b7ea5b158fff0f97cc675b3f', '+14154948323', 'Your Short Bus Subs order is ready! Come pick it up!');

-- --------------------------------------------------------

--
-- Table structure for table `menuitem`
--

CREATE TABLE `menuitem` (
  `menuitemid` int(11) NOT NULL AUTO_INCREMENT,
  `itemprice` float NOT NULL,
  `orderid` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `categoryfriendlyname` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`menuitemid`),
  KEY `orderid` (`orderid`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=502 ;

--
-- Dumping data for table `menuitem`
--

INSERT INTO `menuitem` VALUES(500, 0.5, 577, 'Jalapeno', 'Sides');
INSERT INTO `menuitem` VALUES(501, 0.5, 577, 'Smokehouse BBQ', 'Sides');
INSERT INTO `menuitem` VALUES(499, 0, 576, 'Dublin Dr. Pepper', 'Drinks');
INSERT INTO `menuitem` VALUES(498, 0.5, 576, 'Jalapeno', 'Sides');
INSERT INTO `menuitem` VALUES(497, 0, 576, 'Detention', 'Sandwiches');

-- --------------------------------------------------------

--
-- Table structure for table `menuitemoption`
--

CREATE TABLE `menuitemoption` (
  `menuitemoptionid` int(11) NOT NULL AUTO_INCREMENT,
  `menuitemid` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `addlcost` float NOT NULL,
  PRIMARY KEY (`menuitemoptionid`),
  KEY `menuitemid` (`menuitemid`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=378 ;

--
-- Dumping data for table `menuitemoption`
--

INSERT INTO `menuitemoption` VALUES(373, 497, 'Mushroom', 0);
INSERT INTO `menuitemoption` VALUES(369, 497, 'Provolone', 0);
INSERT INTO `menuitemoption` VALUES(370, 497, 'Onions', 0);
INSERT INTO `menuitemoption` VALUES(371, 497, 'Red Peppers', 0);
INSERT INTO `menuitemoption` VALUES(372, 497, 'Green Peppers', 0);
INSERT INTO `menuitemoption` VALUES(368, 497, 'Roast Beef', 0);
INSERT INTO `menuitemoption` VALUES(377, 497, 'Upgrade to 12 inch sandwich', 4);
INSERT INTO `menuitemoption` VALUES(376, 497, 'Vinegar', 0);
INSERT INTO `menuitemoption` VALUES(375, 497, 'Oil', 0);
INSERT INTO `menuitemoption` VALUES(374, 497, 'Mayo', 0);

-- --------------------------------------------------------

--
-- Table structure for table `order`
--

CREATE TABLE `order` (
  `orderid` int(11) NOT NULL AUTO_INCREMENT,
  `orderplaced` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `instanceid` int(11) DEFAULT NULL,
  `ordercompletedtime` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `completed` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`orderid`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=579 ;

--
-- Dumping data for table `order`
--

INSERT INTO `order` VALUES(577, '2012-02-29 05:13:39', 26, '2012-02-29 17:55:28', 1);
INSERT INTO `order` VALUES(576, '2012-02-29 03:05:15', 26, '0000-00-00 00:00:00', 0);
