-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Nov 03, 2017 at 03:28 PM
-- Server version: 10.1.19-MariaDB
-- PHP Version: 7.0.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pli`
--

-- --------------------------------------------------------

--
-- Table structure for table `pli_counties`
--

DROP TABLE IF EXISTS `pli_counties`;
CREATE TABLE `pli_counties` (
  `ID` int(11) NOT NULL,
  `Name` varchar(12) CHARACTER SET utf8 NOT NULL,
  `COU_IS_GROUP` int(11) NOT NULL,
  `DefaultCurrency` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pli_counties`
--

INSERT INTO `pli_counties` (`ID`, `Name`, `COU_IS_GROUP`, `DefaultCurrency`) VALUES
(225, 'Україна', 0, 1),
(187, 'Россия', 0, 2),
(158, 'Poland', 0, 5),
(52, 'Deutschland', 0, 3);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `pli_counties`
--
ALTER TABLE `pli_counties`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `Counties_fk0` (`DefaultCurrency`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `pli_counties`
--
ALTER TABLE `pli_counties`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=226;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
