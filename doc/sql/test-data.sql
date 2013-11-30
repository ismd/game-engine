-- phpMyAdmin SQL Dump
-- version 4.0.9
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Nov 30, 2013 at 12:16 PM
-- Server version: 5.5.33a-MariaDB-log
-- PHP Version: 5.5.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `game`
--

-- --------------------------------------------------------

--
-- Table structure for table `Character`
--

CREATE TABLE IF NOT EXISTS `Character` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idUser` int(11) NOT NULL,
  `name` varchar(30) NOT NULL,
  `level` tinyint(4) NOT NULL,
  `money` int(11) NOT NULL,
  `idLayout` tinyint(4) NOT NULL,
  `x` tinyint(4) NOT NULL,
  `y` tinyint(4) NOT NULL,
  `strength` tinyint(4) NOT NULL,
  `dexterity` tinyint(4) NOT NULL,
  `endurance` tinyint(4) NOT NULL,
  `hp` int(11) NOT NULL,
  `maxHp` int(11) NOT NULL,
  `minDamage` int(11) NOT NULL,
  `maxDamage` int(11) NOT NULL,
  `image` varchar(40) NOT NULL,
  `experience` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `idUser` (`idUser`),
  KEY `coordinates` (`idLayout`,`x`,`y`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `Character`
--

INSERT INTO `Character` (`id`, `idUser`, `name`, `level`, `money`, `idLayout`, `x`, `y`, `strength`, `dexterity`, `endurance`, `hp`, `maxHp`, `minDamage`, `maxDamage`, `image`, `experience`) VALUES
(1, 1, '1-pers', 1, 10, 1, 3, 2, 10, 10, 10, 20, 20, 3, 5, 'player.png', 0),
(2, 2, 'hi', 1, 10, 1, 3, 2, 10, 10, 10, 20, 20, 3, 5, 'player.png', 0);

-- --------------------------------------------------------

--
-- Table structure for table `CharacterItem`
--

CREATE TABLE IF NOT EXISTS `CharacterItem` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idCharacter` int(11) NOT NULL,
  `idItem` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idCharacter` (`idCharacter`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `Item`
--

CREATE TABLE IF NOT EXISTS `Item` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(50) NOT NULL,
  `idType` tinyint(4) NOT NULL,
  `price` int(11) NOT NULL,
  `description` text,
  PRIMARY KEY (`id`),
  KEY `idType` (`idType`),
  KEY `price` (`price`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `ItemType`
--

CREATE TABLE IF NOT EXISTS `ItemType` (
  `id` tinyint(4) NOT NULL AUTO_INCREMENT,
  `title` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `ItemType`
--

INSERT INTO `ItemType` (`id`, `title`) VALUES
(1, 'Оружие'),
(2, 'Шлем'),
(3, 'Щит');

-- --------------------------------------------------------

--
-- Table structure for table `Layout`
--

CREATE TABLE IF NOT EXISTS `Layout` (
  `id` tinyint(4) NOT NULL AUTO_INCREMENT,
  `title` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `Layout`
--

INSERT INTO `Layout` (`id`, `title`) VALUES
(1, 'Карта');

-- --------------------------------------------------------

--
-- Table structure for table `Mob`
--

CREATE TABLE IF NOT EXISTS `Mob` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idMob` int(11) NOT NULL,
  `idLayout` tinyint(4) NOT NULL,
  `x` tinyint(4) NOT NULL,
  `y` tinyint(4) NOT NULL,
  `hp` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `coordinates` (`idLayout`,`x`,`y`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `Mob`
--

INSERT INTO `Mob` (`id`, `idMob`, `idLayout`, `x`, `y`, `hp`) VALUES
(1, 1, 1, 3, 2, 10),
(2, 1, 1, 3, 2, 10),
(3, 1, 1, 3, 3, 10),
(4, 1, 1, 3, 2, 10),
(5, 1, 1, 3, 2, 10),
(6, 2, 1, 3, 2, 15),
(7, 2, 1, 3, 2, 15),
(8, 3, 1, 3, 2, 20),
(9, 3, 1, 3, 2, 20);

-- --------------------------------------------------------

--
-- Table structure for table `MobAvailableCell`
--

CREATE TABLE IF NOT EXISTS `MobAvailableCell` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idMob` int(11) NOT NULL,
  `idLayout` tinyint(4) NOT NULL,
  `x` tinyint(4) NOT NULL,
  `y` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `coordinates` (`idLayout`,`x`,`y`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `MobAvailableCell`
--

INSERT INTO `MobAvailableCell` (`id`, `idMob`, `idLayout`, `x`, `y`) VALUES
(1, 1, 1, 3, 2),
(2, 2, 1, 3, 2),
(3, 3, 1, 3, 2),
(4, 1, 1, 3, 3);

-- --------------------------------------------------------

--
-- Table structure for table `MobInfo`
--

CREATE TABLE IF NOT EXISTS `MobInfo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(40) NOT NULL,
  `level` tinyint(4) NOT NULL,
  `maxHp` int(11) NOT NULL,
  `minDamage` int(11) NOT NULL,
  `maxDamage` int(11) NOT NULL,
  `maxInWorld` int(11) NOT NULL,
  `experience` int(11) NOT NULL,
  `image` varchar(40) NOT NULL,
  `strength` tinyint(4) NOT NULL,
  `dexterity` tinyint(4) NOT NULL,
  `endurance` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `MobInfo`
--

INSERT INTO `MobInfo` (`id`, `name`, `level`, `maxHp`, `minDamage`, `maxDamage`, `maxInWorld`, `experience`, `image`, `strength`, `dexterity`, `endurance`) VALUES
(1, 'Кот', 1, 10, 1, 2, 5, 3, 'cat.png', 1, 1, 1),
(2, 'Собака', 2, 15, 2, 3, 2, 5, 'dog.png', 2, 2, 2),
(3, 'Кот Вася', 3, 20, 3, 5, 2, 10, 'vasya.png', 3, 3, 3);

-- --------------------------------------------------------

--
-- Table structure for table `Npc`
--

CREATE TABLE IF NOT EXISTS `Npc` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(40) NOT NULL,
  `greeting` text NOT NULL,
  `image` varchar(40) NOT NULL,
  `idLayout` tinyint(4) NOT NULL,
  `x` int(11) NOT NULL,
  `y` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `Npc`
--

INSERT INTO `Npc` (`id`, `name`, `greeting`, `image`, `idLayout`, `x`, `y`) VALUES
(1, 'Король', 'Hi', 'king.png', 1, 3, 3);

-- --------------------------------------------------------

--
-- Table structure for table `NpcItem`
--

CREATE TABLE IF NOT EXISTS `NpcItem` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idNpc` tinyint(4) NOT NULL,
  `idItem` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idItem` (`idItem`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `User`
--

CREATE TABLE IF NOT EXISTS `User` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `login` varchar(30) NOT NULL,
  `password` varchar(32) NOT NULL,
  `email` varchar(40) NOT NULL,
  `info` text,
  `site` varchar(40) DEFAULT NULL,
  `registered` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `authKey` varchar(32) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `User`
--

INSERT INTO `User` (`id`, `login`, `password`, `email`, `info`, `site`, `registered`, `authKey`) VALUES
(1, '1', 'c4ca4238a0b923820dcc509a6f75849b', '1', '1', '1', '2013-11-29 17:00:00', 'cb76683df7ac19d9da0e706f54a2ed54'),
(2, '2', 'c81e728d9d4c2f636f067f89cc14862c', '2', NULL, NULL, '2013-11-29 17:00:00', '901f2e5056b0921255fa392f7e977537');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
