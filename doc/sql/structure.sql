-- phpMyAdmin SQL Dump
-- version 4.0.9
-- http://www.phpmyadmin.net
--
-- Хост: localhost
-- Время создания: Дек 01 2013 г., 10:00
-- Версия сервера: 5.5.33a-MariaDB-log
-- Версия PHP: 5.5.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
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
-- Структура таблицы `Character`
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
  `speed` tinyint(4) NOT NULL,
  `endurance` tinyint(4) NOT NULL,
  `hp` int(11) NOT NULL,
  `maxHp` int(11) NOT NULL,
  `minDamage` int(11) NOT NULL,
  `maxDamage` int(11) NOT NULL,
  `image` varchar(40) NOT NULL,
  `experience` int(11) NOT NULL DEFAULT '0',
  `biography` text,
  PRIMARY KEY (`id`),
  KEY `idUser` (`idUser`),
  KEY `coordinates` (`idLayout`,`x`,`y`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- Структура таблицы `CharacterItem`
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
-- Структура таблицы `ChatMessage`
--

CREATE TABLE IF NOT EXISTS `ChatMessage` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `idSender` int(11) NOT NULL,
  `idReceiver` int(11) DEFAULT NULL,
  `message` text NOT NULL,
  `sended` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `Item`
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
-- Структура таблицы `ItemType`
--

CREATE TABLE IF NOT EXISTS `ItemType` (
  `id` tinyint(4) NOT NULL AUTO_INCREMENT,
  `title` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

-- --------------------------------------------------------

--
-- Структура таблицы `Layout`
--

CREATE TABLE IF NOT EXISTS `Layout` (
  `id` tinyint(4) NOT NULL AUTO_INCREMENT,
  `title` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Структура таблицы `Mob`
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

-- --------------------------------------------------------

--
-- Структура таблицы `MobAvailableCell`
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

-- --------------------------------------------------------

--
-- Структура таблицы `MobInfo`
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
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

-- --------------------------------------------------------

--
-- Структура таблицы `Npc`
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

-- --------------------------------------------------------

--
-- Структура таблицы `NpcItem`
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
-- Структура таблицы `User`
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

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
