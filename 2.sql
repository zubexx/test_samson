-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Янв 31 2022 г., 16:23
-- Версия сервера: 5.7.33-log
-- Версия PHP: 7.1.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `test_samson`
--

-- --------------------------------------------------------

--
-- Структура таблицы `a_category`
--

CREATE TABLE `a_category` (
  `Id` int(11) NOT NULL,
  `Code` int(11) NOT NULL,
  `Name` tinytext COLLATE utf8mb4_unicode_ci NOT NULL,
  `productName` int(11) NOT NULL,
  `IdParentCategory` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `a_category`
--

INSERT INTO `a_category` (`Id`, `Code`, `Name`, `productName`, `IdParentCategory`) VALUES
(153, 2, 'Бумага', 201, 0),
(154, 2, 'Бумага', 202, 0),
(155, 3, 'Принтеры', 302, 0),
(156, 30, 'МФУ', 302, 3),
(157, 3, 'Принтеры', 305, 0),
(158, 30, 'МФУ', 305, 3);

-- --------------------------------------------------------

--
-- Структура таблицы `a_price`
--

CREATE TABLE `a_price` (
  `productCode` int(11) NOT NULL,
  `productName` tinytext COLLATE utf8mb4_unicode_ci NOT NULL,
  `priceType` tinytext COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `a_price`
--

INSERT INTO `a_price` (`productCode`, `productName`, `priceType`, `price`) VALUES
(201, 'Бумага А4', 'Базовая', 11.5),
(201, 'Бумага А4', 'Москва', 12.5),
(202, 'Бумага А3', 'Базовая', 18.5),
(202, 'Бумага А3', 'Москва', 22.5),
(302, 'Принтер Canon', 'Базовая', 3010),
(302, 'Принтер Canon', 'Москва', 3500),
(305, 'Принтер HP', 'Базовая', 3310),
(305, 'Принтер HP', 'Москва', 2999);

-- --------------------------------------------------------

--
-- Структура таблицы `a_product`
--

CREATE TABLE `a_product` (
  `Id` int(11) NOT NULL,
  `Code` int(11) NOT NULL,
  `Name` tinytext COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `a_product`
--

INSERT INTO `a_product` (`Id`, `Code`, `Name`) VALUES
(70, 201, 'Бумага А4'),
(71, 202, 'Бумага А3'),
(72, 302, 'Принтер Canon'),
(73, 305, 'Принтер HP');

-- --------------------------------------------------------

--
-- Структура таблицы `a_property`
--

CREATE TABLE `a_property` (
  `productCode` int(11) NOT NULL,
  `productName` tinytext COLLATE utf8mb4_unicode_ci NOT NULL,
  `property` text COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `a_property`
--

INSERT INTO `a_property` (`productCode`, `productName`, `property`) VALUES
(201, 'Бумага А4', 'Плотность 100'),
(201, 'Бумага А4', 'Белизна 150 %'),
(202, 'Бумага А3', 'Плотность 90'),
(202, 'Бумага А3', 'Белизна 100 %'),
(302, 'Принтер Canon', 'Формат A4'),
(302, 'Принтер Canon', 'Формат A3'),
(302, 'Принтер Canon', 'Тип Лазерный'),
(305, 'Принтер HP', 'Формат A3'),
(305, 'Принтер HP', 'Тип Лазерный');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `a_category`
--
ALTER TABLE `a_category`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `Код` (`productName`),
  ADD KEY `Ид` (`IdParentCategory`);

--
-- Индексы таблицы `a_price`
--
ALTER TABLE `a_price`
  ADD KEY `Код` (`productCode`);

--
-- Индексы таблицы `a_product`
--
ALTER TABLE `a_product`
  ADD PRIMARY KEY (`Id`),
  ADD UNIQUE KEY `Код` (`Code`);

--
-- Индексы таблицы `a_property`
--
ALTER TABLE `a_property`
  ADD KEY `Код` (`productCode`) USING BTREE;

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `a_category`
--
ALTER TABLE `a_category`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=159;

--
-- AUTO_INCREMENT для таблицы `a_product`
--
ALTER TABLE `a_product`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=74;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
