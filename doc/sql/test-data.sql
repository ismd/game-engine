-- phpMyAdmin SQL Dump
-- version 4.0.4.1
-- http://www.phpmyadmin.net
--
-- Хост: localhost
-- Время создания: Июл 11 2013 г., 08:56
-- Версия сервера: 5.5.31-MariaDB-log
-- Версия PHP: 5.4.17

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База данных: `game`
--
CREATE DATABASE IF NOT EXISTS `game` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `game`;

--
-- Дамп данных таблицы `CharacterItem`
--

INSERT INTO `CharacterItem` (`id`, `idCharacter`, `idItem`) VALUES
(3, 3, 1),
(4, 3, 3);

--
-- Дамп данных таблицы `Item`
--

INSERT INTO `Item` (`id`, `title`, `idType`, `price`, `description`) VALUES
(1, 'Железный меч', 1, 10, 'Просто тестовый меч'),
(3, 'Маска вуду', 2, 5, 'Просто тестовая маска (шлем)');

--
-- Дамп данных таблицы `ItemType`
--

INSERT INTO `ItemType` (`id`, `title`) VALUES
(1, 'Оружие'),
(2, 'Шлем');

--
-- Дамп данных таблицы `Layout`
--

INSERT INTO `Layout` (`id`, `title`) VALUES
(1, 'Карта');

--
-- Дамп данных таблицы `Mob`
--

INSERT INTO `Mob` (`id`, `name`, `lvl`, `maxHp`, `minDamage`, `maxDamage`, `maxInWorld`, `experience`, `image`, `strength`, `dexterity`, `endurance`) VALUES
(1, 'Кот', 1, 10, 1, 2, 5, 3, 'cat.png', 1, 1, 1),
(2, 'Собака', 2, 15, 2, 3, 2, 5, 'dog.png', 2, 2, 2),
(3, 'Кот Вася', 3, 20, 3, 5, 2, 10, 'vasya.png', 3, 3, 3);

--
-- Дамп данных таблицы `MobCell`
--

INSERT INTO `MobCell` (`id`, `idMob`, `idLayout`, `x`, `y`) VALUES
(1, 1, 1, 3, 2),
(2, 2, 1, 3, 2),
(3, 3, 1, 3, 2),
(4, 1, 1, 3, 3);

--
-- Дамп данных таблицы `Npc`
--

INSERT INTO `Npc` (`id`, `name`, `greeting`, `image`, `idLayout`, `x`, `y`) VALUES
(1, 'Король', 'Привет!', 'king.png', 1, 3, 3);

--
-- Дамп данных таблицы `User`
--

INSERT INTO `User` (`id`, `login`, `password`, `email`, `info`, `site`, `registered`, `authKey`) VALUES
(4, 'ismd', '202cb962ac59075b964b07152d234b70', '', NULL, NULL, '2012-05-22 17:35:00', NULL),
(5, 'ismd1', '25d55ad283aa400af464c76d713c07ad', '', '', '', '2012-05-24 14:57:32', NULL),
(6, 'asdasd', 'a3dcb4d229de6fde0db5686dee47145d', '', '', '', '2012-05-24 17:06:05', NULL),
(7, 'ismd2', 'f5bb0c8de146c67b44babbf4e6584cc0', '', '', '', '2012-12-24 20:38:08', NULL),
(8, '1231', '4297f44b13955235245b2497399d7a93', '', '', '', '2013-04-27 12:38:46', NULL),
(9, 'tmp1', '4297f44b13955235245b2497399d7a93', '', '', '', '2013-04-27 13:23:16', NULL),
(10, 'tmp2', '4297f44b13955235245b2497399d7a93', '', '', '', '2013-04-27 13:24:51', NULL),
(11, 'tmp3', '4297f44b13955235245b2497399d7a93', '', '', '', '2013-04-27 13:32:23', NULL),
(12, 'tmp4', '4297f44b13955235245b2497399d7a93', '', '', '', '2013-04-27 13:43:09', NULL),
(13, 'tmp5', '4297f44b13955235245b2497399d7a93', '', '', '', '2013-04-27 13:46:23', NULL),
(14, 'tmp6', '4297f44b13955235245b2497399d7a93', '', '', '', '2013-04-27 13:47:16', NULL),
(15, 'tmp7', '4297f44b13955235245b2497399d7a93', '', '', '', '2013-04-27 14:11:58', NULL),
(16, 'tmp8', '4297f44b13955235245b2497399d7a93', '', '', '', '2013-04-27 14:13:57', NULL),
(17, 'test', '4297f44b13955235245b2497399d7a93', '', '', '', '2013-04-29 09:49:57', NULL);

--
-- Дамп данных таблицы `UserCharacter`
--

INSERT INTO `UserCharacter` (`id`, `idUser`, `name`, `lvl`, `money`, `idLayout`, `x`, `y`, `strength`, `dexterity`, `endurance`, `hp`, `maxHp`, `minDamage`, `maxDamage`, `image`, `experience`) VALUES
(3, 4, 'ismd', 3, 10, 1, 3, 2, 10, 10, 10, 100, 100, 5, 10, 'player.png', 0),
(4, 4, 'ismd1', 1, 10, 1, 3, 2, 10, 10, 10, 100, 100, 5, 10, 'player.png', 0),
(5, 5, 'test', 1, 0, 1, 3, 2, 5, 5, 5, 25, 25, 5, 10, 'player.png', 0),
(6, 5, 'test1', 1, 0, 1, 2, 2, 5, 5, 5, 25, 25, 5, 10, 'player.png', 0),
(7, 5, 'test2', 1, 0, 1, 2, 2, 5, 5, 5, 25, 25, 5, 10, 'player.png', 0),
(8, 6, 'asdasd', 1, 0, 1, 2, 2, 5, 5, 5, 25, 25, 5, 10, 'player.png', 0),
(9, 0, 'test3', 1, 0, 1, 2, 2, 5, 5, 5, 25, 25, 5, 10, 'player.png', 0),
(10, 0, 'test4', 1, 0, 1, 2, 2, 5, 5, 5, 25, 25, 5, 10, 'player.png', 0),
(11, 7, 'test5', 1, 0, 1, 2, 2, 5, 5, 5, 25, 25, 5, 10, 'player.png', 0),
(12, 14, 'tmp6', 1, 0, 1, 2, 2, 5, 5, 5, 25, 25, 5, 10, 'player.png', 0),
(13, 14, 'tmp7', 1, 0, 1, 2, 2, 5, 5, 5, 25, 25, 5, 10, 'player.png', 0),
(14, 15, 'tmp8', 1, 0, 1, 2, 2, 5, 5, 5, 25, 25, 5, 10, 'player.png', 0),
(15, 16, 'tmp88', 1, 0, 1, 2, 2, 5, 5, 5, 25, 25, 5, 10, 'player.png', 0),
(16, 16, 'tmp89', 1, 0, 1, 2, 2, 5, 5, 5, 25, 25, 5, 10, 'player.png', 0),
(17, 16, 'tmp90', 1, 0, 1, 2, 2, 5, 5, 5, 25, 25, 5, 10, 'player.png', 0),
(18, 16, 'tmp91', 1, 0, 1, 2, 2, 5, 5, 5, 25, 25, 5, 10, 'player.png', 0),
(19, 4, 'ismd2', 1, 0, 1, 2, 2, 5, 5, 5, 25, 25, 5, 10, 'player.png', 0),
(20, 4, 'Длинное имя', 1, 0, 1, 2, 2, 5, 5, 5, 25, 25, 5, 10, 'player.png', 0),
(21, 4, 'Очень длинное им', 1, 0, 1, 2, 2, 5, 5, 5, 25, 25, 5, 10, 'player.png', 0),
(22, 4, 'Очередной перс', 1, 0, 1, 2, 2, 5, 5, 5, 25, 25, 5, 10, 'player.png', 0),
(23, 4, 'Ещё один перс', 1, 0, 1, 2, 2, 5, 5, 5, 25, 25, 5, 10, 'player.png', 0),
(24, 4, 'test12', 1, 0, 1, 2, 2, 5, 5, 5, 25, 25, 5, 10, 'player.png', 0),
(25, 4, 'test45', 1, 0, 1, 1, 4, 5, 5, 5, 25, 25, 5, 10, 'player.png', 0),
(26, 17, 'test121', 1, 0, 1, 4, 4, 5, 5, 5, 25, 25, 5, 10, 'player.png', 0);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
