-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Хост: 127.0.0.1
-- Время создания: Дек 27 2015 г., 21:22
-- Версия сервера: 5.5.25
-- Версия PHP: 5.3.13

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База данных: `lb_pdo_goods`
--
CREATE DATABASE IF NOT EXISTS `lb_pdo_goods`;
USE `lb_pdo_goods`;

-- --------------------------------------------------------

--
-- Структура таблицы `category`
--

CREATE TABLE IF NOT EXISTS `category` (
  `ID_Category` int(8) NOT NULL,
  `c_name` varchar(16) NOT NULL,
  PRIMARY KEY (`ID_Category`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `category`
--

INSERT INTO `category` (`ID_Category`, `c_name`) VALUES
(1, 'Videocard'),
(2, 'CPU'),
(3, 'Display'),
(4, 'Memory');

-- --------------------------------------------------------

--
-- Структура таблицы `items`
--

CREATE TABLE IF NOT EXISTS `items` (
  `ID_Items` int(16) NOT NULL,
  `name` varchar(16) NOT NULL,
  `price` int(16) NOT NULL,
  `quantity` int(16) NOT NULL,
  `quality` int(16) NOT NULL,
  `FID_Vendor` int(16) NOT NULL,
  `FID_Category` int(16) NOT NULL,
  PRIMARY KEY (`ID_Items`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `items`
--

INSERT INTO `items` (`ID_Items`, `name`, `price`, `quantity`, `quality`, `FID_Vendor`, `FID_Category`) VALUES
(1, 'Монитор 22"', 1500, 15, 5, 1, 3),
(2, 'Монитор 17"', 1200, 20, 4, 3, 3),
(3, 'GeForce 660M', 2000, 12, 4, 4, 1),
(4, 'Radeon R9', 2500, 7, 5, 5, 1),
(5, 'Core i7', 3000, 10, 5, 4, 2),
(6, 'FX-6300', 2700, 15, 4, 5, 2),
(7, 'RAM 8GB', 1500, 11, 5, 2, 4),
(8, 'RAM 4GB', 1000, 15, 4, 3, 4);

-- --------------------------------------------------------

--
-- Структура таблицы `vendors`
--

CREATE TABLE IF NOT EXISTS `vendors` (
  `ID_Vendors` int(8) NOT NULL,
  `v_name` varchar(16) NOT NULL,
  PRIMARY KEY (`ID_Vendors`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `vendors`
--

INSERT INTO `vendors` (`ID_Vendors`, `v_name`) VALUES
(1, 'LG'),
(2, 'ASUS'),
(3, 'Samsung'),
(4, 'Intel'),
(5, 'AMD');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
