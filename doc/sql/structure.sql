-- phpMyAdmin SQL Dump
-- version 3.4.9
-- http://www.phpmyadmin.net
--
-- Хост: localhost
-- Время создания: Июл 15 2012 г., 16:49
-- Версия сервера: 5.1.62
-- Версия PHP: 5.3.14-pl0-gentoo

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База данных: `game`
--

-- --------------------------------------------------------

--
-- Структура таблицы `Attribute`
--

DROP TABLE IF EXISTS `Attribute`;
CREATE TABLE IF NOT EXISTS `Attribute` (
  `id` tinyint(4) NOT NULL AUTO_INCREMENT,
  `title` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `Character`
--

DROP TABLE IF EXISTS `Character`;
CREATE TABLE IF NOT EXISTS `Character` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idUser` int(11) NOT NULL,
  `name` varchar(30) NOT NULL,
  `level` tinyint(4) NOT NULL,
  `money` int(11) NOT NULL,
  `idMap` tinyint(4) NOT NULL,
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
  KEY `coordinates` (`idMap`,`x`,`y`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `CharacterItem`
--

DROP TABLE IF EXISTS `CharacterItem`;
CREATE TABLE IF NOT EXISTS `CharacterItem` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idCharacter` int(11) NOT NULL,
  `idItem` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idCharacter` (`idCharacter`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `Item`
--

DROP TABLE IF EXISTS `Item`;
CREATE TABLE IF NOT EXISTS `Item` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(50) NOT NULL,
  `idType` tinyint(4) NOT NULL,
  `price` int(11) NOT NULL,
  `description` text,
  PRIMARY KEY (`id`),
  KEY `idType` (`idType`),
  KEY `price` (`price`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `ItemAttribute`
--

DROP TABLE IF EXISTS `ItemAttribute`;
CREATE TABLE IF NOT EXISTS `ItemAttribute` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idItem` int(11) NOT NULL,
  `idAttribute` tinyint(4) NOT NULL,
  `value` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idItem` (`idItem`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `ItemType`
--

DROP TABLE IF EXISTS `ItemType`;
CREATE TABLE IF NOT EXISTS `ItemType` (
  `id` tinyint(4) NOT NULL AUTO_INCREMENT,
  `title` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `Map`
--

DROP TABLE IF EXISTS `Map`;
CREATE TABLE IF NOT EXISTS `Map` (
  `id` tinyint(4) NOT NULL AUTO_INCREMENT,
  `title` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `Mob`
--

DROP TABLE IF EXISTS `Mob`;
CREATE TABLE IF NOT EXISTS `Mob` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(40) NOT NULL,
  `level` tinyint(4) NOT NULL,
  `maxHp` int(11) NOT NULL,
  `minDamage` int(11) NOT NULL,
  `maxDamage` int(11) NOT NULL,
  `maxOnMap` int(11) NOT NULL,
  `experience` int(11) NOT NULL,
  `image` varchar(40) NOT NULL,
  `strength` tinyint(4) NOT NULL,
  `dexterity` tinyint(4) NOT NULL,
  `endurance` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `MobCell`
--

DROP TABLE IF EXISTS `MobCell`;
CREATE TABLE IF NOT EXISTS `MobCell` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idMob` int(11) NOT NULL,
  `idMap` tinyint(4) NOT NULL,
  `x` tinyint(4) NOT NULL,
  `y` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `coordinates` (`idMap`,`x`,`y`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `MobMap`
--

DROP TABLE IF EXISTS `MobMap`;
CREATE TABLE IF NOT EXISTS `MobMap` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idMob` int(11) NOT NULL,
  `idMap` tinyint(4) NOT NULL,
  `x` tinyint(4) NOT NULL,
  `y` tinyint(4) NOT NULL,
  `hp` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `coordinates` (`idMap`,`x`,`y`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `Npc`
--

DROP TABLE IF EXISTS `Npc`;
CREATE TABLE IF NOT EXISTS `Npc` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(40) NOT NULL,
  `greeting` text NOT NULL,
  `image` varchar(40) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `NpcItem`
--

DROP TABLE IF EXISTS `NpcItem`;
CREATE TABLE IF NOT EXISTS `NpcItem` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idNpc` tinyint(4) NOT NULL,
  `idItem` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idItem` (`idItem`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `NpcMap`
--

DROP TABLE IF EXISTS `NpcMap`;
CREATE TABLE IF NOT EXISTS `NpcMap` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idNpc` int(11) NOT NULL,
  `idMap` int(11) NOT NULL,
  `x` int(11) NOT NULL,
  `y` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `coordinates` (`idMap`,`x`,`y`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `User`
--

DROP TABLE IF EXISTS `User`;
CREATE TABLE IF NOT EXISTS `User` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `login` varchar(30) NOT NULL,
  `password` varchar(32) NOT NULL,
  `email` varchar(40) NOT NULL,
  `info` text,
  `site` varchar(40) DEFAULT NULL,
  `registered` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
