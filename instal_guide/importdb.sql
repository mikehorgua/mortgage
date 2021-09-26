-- phpMyAdmin SQL Dump
-- version 4.7.1
-- https://www.phpmyadmin.net/
--
-- Хост: sql11.freemysqlhosting.net
-- Час створення: Вер 26 2021 р., 06:47
-- Версія сервера: 5.5.62-0ubuntu0.14.04.1
-- Версія PHP: 7.0.33-0ubuntu0.16.04.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База даних
--

-- --------------------------------------------------------

--
-- Структура таблиці `banks`
--

CREATE TABLE `banks` (
                         `nom` int(11) NOT NULL,
                         `bankname` text NOT NULL,
                         `interestrate` decimal(15,4) NOT NULL,
                         `maxloan` decimal(15,4) NOT NULL,
                         `mindown` decimal(15,4) NOT NULL,
                         `loanterm` int(11) NOT NULL,
                         `visib` int(11) NOT NULL DEFAULT '1'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


--
-- Структура таблиці `requests`
--

CREATE TABLE `requests` (
                            `nom` int(11) NOT NULL,
                            `initialloan` decimal(15,4) NOT NULL,
                            `downpaym` decimal(15,4) NOT NULL,
                            `banknom` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


--
-- Індекси збережених таблиць
--

--
-- Індекси таблиці `banks`
--
ALTER TABLE `banks`
    ADD UNIQUE KEY `nom` (`nom`);

--
-- Індекси таблиці `requests`
--
ALTER TABLE `requests`
    ADD UNIQUE KEY `nom` (`nom`);

--
-- AUTO_INCREMENT для збережених таблиць
--

--
-- AUTO_INCREMENT для таблиці `banks`
--
ALTER TABLE `banks`
    MODIFY `nom` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT для таблиці `requests`
--
ALTER TABLE `requests`
    MODIFY `nom` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
