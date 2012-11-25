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

--
-- Дамп данных таблицы `Attribute`
--

INSERT INTO `Attribute` (`id`, `title`) VALUES
(3, 'Сила'),
(4, 'Ловкость'),
(5, 'Выносливость'),
(6, 'Жизни');

--
-- Дамп данных таблицы `Character`
--

INSERT INTO `Character` (`id`, `idUser`, `name`, `level`, `money`, `idMap`, `coordinateX`, `coordinateY`, `strength`, `dexterity`, `endurance`, `hp`, `maxHp`, `minDamage`, `maxDamage`, `image`, `experience`) VALUES
(3, 4, 'ismd', 2, 10, 1, 3, 0, 10, 10, 10, 100, 100, 5, 10, 'player.png', 0),
(4, 4, 'ismd1', 1, 10, 1, 2, 2, 10, 10, 10, 100, 100, 5, 10, 'player.png', 0),
(5, 5, 'test', 1, 0, 1, 2, 2, 5, 5, 5, 25, 25, 5, 10, 'player.png', 0),
(6, 5, 'test1', 1, 0, 1, 2, 2, 5, 5, 5, 25, 25, 5, 10, 'player.png', 0),
(7, 5, 'test2', 1, 0, 1, 2, 2, 5, 5, 5, 25, 25, 5, 10, 'player.png', 0),
(8, 6, 'asdasd', 1, 0, 1, 2, 2, 5, 5, 5, 25, 25, 5, 10, 'player.png', 0);

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
-- Дамп данных таблицы `ItemAttribute`
--

INSERT INTO `ItemAttribute` (`id`, `idItem`, `idAttribute`, `value`) VALUES
(3, 1, 3, 10),
(4, 1, 5, 2),
(5, 3, 4, 10),
(6, 3, 5, 10),
(7, 3, 3, 10),
(8, 3, 6, 10);

--
-- Дамп данных таблицы `ItemType`
--

INSERT INTO `ItemType` (`id`, `title`) VALUES
(1, 'Оружие'),
(2, 'Шлем');

--
-- Дамп данных таблицы `Map`
--

INSERT INTO `Map` (`id`, `title`) VALUES
(1, 'test');

--
-- Дамп данных таблицы `Npc`
--

INSERT INTO `Npc` (`id`, `name`, `greeting`, `image`) VALUES
(1, 'Тестовый NPC', 'Привет!', 'king.png');

--
-- Дамп данных таблицы `NpcMap`
--

INSERT INTO `NpcMap` (`id`, `idNpc`, `idMap`, `coordinateX`, `coordinateY`) VALUES
(1, 1, 1, 3, 1);

--
-- Дамп данных таблицы `User`
--

INSERT INTO `User` (`id`, `login`, `password`, `email`, `info`, `site`, `registered`) VALUES
(4, 'ismd', '202cb962ac59075b964b07152d234b70', '', NULL, NULL, '2012-05-22 17:35:00'),
(5, 'ismd1', '25d55ad283aa400af464c76d713c07ad', '', '', '', '2012-05-24 14:57:32'),
(6, 'asdasd', 'a3dcb4d229de6fde0db5686dee47145d', '', '', '', '2012-05-24 17:06:05');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
