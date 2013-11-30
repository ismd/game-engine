-- phpMyAdmin SQL Dump
-- version 4.0.9
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Nov 30, 2013 at 01:12 PM
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

--
-- Dumping data for table `Character`
--

INSERT INTO `Character` (`id`, `idUser`, `name`, `level`, `money`, `idLayout`, `x`, `y`, `strength`, `dexterity`, `endurance`, `hp`, `maxHp`, `minDamage`, `maxDamage`, `image`, `experience`) VALUES
(1, 1, '1-pers', 1, 10, 1, 3, 2, 10, 10, 10, 20, 20, 3, 5, 'player.png', 0),
(2, 2, 'hi', 1, 10, 1, 3, 2, 10, 10, 10, 20, 20, 3, 5, 'player.png', 0);

--
-- Dumping data for table `ItemType`
--

INSERT INTO `ItemType` (`id`, `title`) VALUES
(1, 'Оружие'),
(2, 'Шлем'),
(3, 'Щит');

--
-- Dumping data for table `Layout`
--

INSERT INTO `Layout` (`id`, `title`) VALUES
(1, 'Карта');

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

--
-- Dumping data for table `MobAvailableCell`
--

INSERT INTO `MobAvailableCell` (`id`, `idMob`, `idLayout`, `x`, `y`) VALUES
(1, 1, 1, 3, 2),
(2, 2, 1, 3, 2),
(3, 3, 1, 3, 2),
(4, 1, 1, 3, 3);

--
-- Dumping data for table `MobInfo`
--

INSERT INTO `MobInfo` (`id`, `name`, `level`, `maxHp`, `minDamage`, `maxDamage`, `maxInWorld`, `experience`, `image`, `strength`, `dexterity`, `endurance`) VALUES
(1, 'Кот', 1, 10, 1, 2, 5, 3, 'cat.png', 1, 1, 1),
(2, 'Собака', 2, 15, 2, 3, 2, 5, 'dog.png', 2, 2, 2),
(3, 'Кот Вася', 3, 20, 3, 5, 2, 10, 'vasya.png', 3, 3, 3);

--
-- Dumping data for table `Npc`
--

INSERT INTO `Npc` (`id`, `name`, `greeting`, `image`, `idLayout`, `x`, `y`) VALUES
(1, 'Король', 'Hi', 'king.png', 1, 3, 3);

--
-- Dumping data for table `User`
--

INSERT INTO `User` (`id`, `login`, `password`, `email`, `info`, `site`, `registered`, `authKey`) VALUES
(1, '1', 'c4ca4238a0b923820dcc509a6f75849b', '1', '1', '1', '2013-11-29 17:00:00', 'cb76683df7ac19d9da0e706f54a2ed54'),
(2, '2', 'c81e728d9d4c2f636f067f89cc14862c', '2', NULL, NULL, '2013-11-29 17:00:00', '901f2e5056b0921255fa392f7e977537');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
