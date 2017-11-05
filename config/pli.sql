-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Хост: 127.0.0.1
-- Час створення: Лис 05 2017 р., 20:45
-- Версія сервера: 10.1.19-MariaDB
-- Версія PHP: 7.0.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База даних: `pli`
--
USE `pli`;

-- --------------------------------------------------------

--
-- Структура таблиці `pli_counties`
--

DROP TABLE IF EXISTS `pli_counties`;
CREATE TABLE `pli_counties` (
  `ID` int(11) NOT NULL,
  `Name` varchar(12) CHARACTER SET utf8 NOT NULL,
  `COU_IS_GROUP` int(11) NOT NULL,
  `DefaultCurrency` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf16;

--
-- Дамп даних таблиці `pli_counties`
--

INSERT INTO `pli_counties` (`ID`, `Name`, `COU_IS_GROUP`, `DefaultCurrency`) VALUES
(225, 'Україна', 0, 1),
(187, 'Россия', 0, 2),
(158, 'Poland', 0, 5),
(52, 'Deutschland', 0, 3);

-- --------------------------------------------------------

--
-- Структура таблиці `pli_currencies`
--

DROP TABLE IF EXISTS `pli_currencies`;
CREATE TABLE `pli_currencies` (
  `ID` int(11) NOT NULL,
  `Name` varchar(3) CHARACTER SET utf8 NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf16;

--
-- Дамп даних таблиці `pli_currencies`
--

INSERT INTO `pli_currencies` (`ID`, `Name`) VALUES
(1, 'ГРН'),
(2, 'РУБ'),
(3, 'EUR'),
(4, 'USD'),
(5, 'Zł');

-- --------------------------------------------------------

--
-- Структура таблиці `pli_stockphones`
--

DROP TABLE IF EXISTS `pli_stockphones`;
CREATE TABLE `pli_stockphones` (
  `ID` int(11) NOT NULL,
  `StockID` int(11) NOT NULL,
  `CountryCode` varchar(4) NOT NULL,
  `Phone` varchar(11) NOT NULL,
  `IsViber` tinyint(1) NOT NULL,
  `IsWatsapp` tinyint(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf16;

--
-- Дамп даних таблиці `pli_stockphones`
--

INSERT INTO `pli_stockphones` (`ID`, `StockID`, `CountryCode`, `Phone`, `IsViber`, `IsWatsapp`) VALUES
(1, 7, '00', '', 0, 0),
(2, 7, '49', '123-45-67', 0, 1);

-- --------------------------------------------------------

--
-- Структура таблиці `pli_users`
--

DROP TABLE IF EXISTS `pli_users`;
CREATE TABLE `pli_users` (
  `UserID` int(11) NOT NULL,
  `UserName` varchar(25) NOT NULL,
  `UserPsw` varchar(254) NOT NULL,
  `UserEmail` varchar(50) NOT NULL,
  `UserPlan` int(11) NOT NULL,
  `Active` tinyint(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf16;

--
-- Дамп даних таблиці `pli_users`
--

INSERT INTO `pli_users` (`UserID`, `UserName`, `UserPsw`, `UserEmail`, `UserPlan`, `Active`) VALUES
(20, 'Имя1', 'c4ca4238a0b923820dcc509a6f75849b', '1@mail.ru', 1, 1);

-- --------------------------------------------------------

--
-- Структура таблиці `pli_userstoks`
--

DROP TABLE IF EXISTS `pli_userstoks`;
CREATE TABLE `pli_userstoks` (
  `ID` int(11) NOT NULL,
  `UserID` int(11) NOT NULL,
  `StockID` int(11) NOT NULL,
  `StockName` varchar(25) NOT NULL,
  `StockCountry` int(11) NOT NULL,
  `StockCity` varchar(20) NOT NULL,
  `StockAdress` varchar(50) NOT NULL,
  `StockEmail` varchar(50) NOT NULL,
  `StockPhones` int(11) NOT NULL,
  `StockComment` varchar(250) NOT NULL,
  `ShipsInfo` varchar(250) NOT NULL,
  `DateCreated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Currency` int(11) NOT NULL,
  `Lang` int(11) NOT NULL,
  `Active` tinyint(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf16;

--
-- Дамп даних таблиці `pli_userstoks`
--

INSERT INTO `pli_userstoks` (`ID`, `UserID`, `StockID`, `StockName`, `StockCountry`, `StockCity`, `StockAdress`, `StockEmail`, `StockPhones`, `StockComment`, `ShipsInfo`, `DateCreated`, `Currency`, `Lang`, `Active`) VALUES
(8, 20, 0, 'SkladNalich', 52, 'Berlin', 'Strasse 32', 'info@gmail.com', 2, '', 'SHip ifol', '2017-11-05 16:53:50', 3, 0, 1),
(7, 20, 0, '', 0, '', '', '', 0, '', '', '2017-11-05 16:53:51', 0, 0, 0);

--
-- Індекси збережених таблиць
--

--
-- Індекси таблиці `pli_brands`
--
ALTER TABLE `pli_brands`
  ADD PRIMARY KEY (`ID`);

--
-- Індекси таблиці `pli_counties`
--
ALTER TABLE `pli_counties`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `Counties_fk0` (`DefaultCurrency`);

--
-- Індекси таблиці `pli_currencies`
--
ALTER TABLE `pli_currencies`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `ID` (`ID`);

--
-- Індекси таблиці `pli_stockphones`
--
ALTER TABLE `pli_stockphones`
  ADD PRIMARY KEY (`ID`);

--
-- Індекси таблиці `pli_users`
--
ALTER TABLE `pli_users`
  ADD PRIMARY KEY (`UserID`);

--
-- Індекси таблиці `pli_userstoks`
--
ALTER TABLE `pli_userstoks`
  ADD UNIQUE KEY `ID` (`ID`),
  ADD KEY `UserStoks_fk0` (`UserID`),
  ADD KEY `UserStoks_fk1` (`StockCountry`),
  ADD KEY `UserStoks_fk2` (`StockPhones`),
  ADD KEY `UserStoks_fk3` (`Currency`),
  ADD KEY `UserStoks_fk4` (`Lang`);

--
-- AUTO_INCREMENT для збережених таблиць
--

--
-- AUTO_INCREMENT для таблиці `pli_brands`
--
ALTER TABLE `pli_brands`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблиці `pli_counties`
--
ALTER TABLE `pli_counties`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=226;
--
-- AUTO_INCREMENT для таблиці `pli_currencies`
--
ALTER TABLE `pli_currencies`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT для таблиці `pli_stockphones`
--
ALTER TABLE `pli_stockphones`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT для таблиці `pli_users`
--
ALTER TABLE `pli_users`
  MODIFY `UserID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
--
-- AUTO_INCREMENT для таблиці `pli_userstoks`
--
ALTER TABLE `pli_userstoks`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
