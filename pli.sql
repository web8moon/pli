SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;


CREATE TABLE `brands` (
  `ID` int(11) NOT NULL,
  `BrandName` varchar(15) NOT NULL,
  `BrandGroup` int(11) NOT NULL,
  `SUP_SUPPLIER_NR` int(11) NOT NULL,
  `BRA_MF_NR` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

CREATE TABLE `counties` (
  `ID` int(11) NOT NULL,
  `Name` varchar(12) NOT NULL,
  `COU_IS_GROUP` int(11) NOT NULL,
  `DefaultCurrency` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

CREATE TABLE `currencies` (
  `ID` int(11) NOT NULL,
  `ShortName` varchar(3) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

CREATE TABLE `languages` (
  `ID` int(11) NOT NULL,
  `ShortName` varchar(2) NOT NULL,
  `Name` varchar(12) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

CREATE TABLE `orders` (
  `ID` int(11) NOT NULL,
  `StockID` int(11) NOT NULL,
  `Brand` int(11) NOT NULL,
  `Code` varchar(17) NOT NULL,
  `Name` varchar(50) NOT NULL,
  `IsUsed` tinyint(1) NOT NULL,
  `Price` float NOT NULL,
  `Quantity` int(11) NOT NULL,
  `CustomerContact` varchar(250) NOT NULL,
  `CustomerID` int(11) NOT NULL,
  `Currency` int(11) NOT NULL,
  `Status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `orderstatuses` (
  `ID` int(11) NOT NULL,
  `StatusEN` varchar(12) NOT NULL,
  `StatusRU` varchar(15) NOT NULL,
  `StatusDE` varchar(15) NOT NULL,
  `StatusTR` varchar(15) NOT NULL,
  `StatusPL` varchar(15) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

CREATE TABLE `stockphones` (
  `ID` int(11) NOT NULL,
  `CountryCode` int(4) NOT NULL,
  `Phone` varchar(11) NOT NULL,
  `IsViber` tinyint(1) NOT NULL,
  `IsWatsapp` tinyint(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

CREATE TABLE `users` (
  `UserID` int(11) NOT NULL,
  `UserName` varchar(25) NOT NULL,
  `UserPsw` varchar(254) NOT NULL,
  `UserEmail` varchar(50) NOT NULL,
  `UserPlan` int(11) NOT NULL,
  `Active` tinyint(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

INSERT INTO `users` (`UserID`, `UserName`, `UserPsw`, `UserEmail`, `UserPlan`, `Active`) VALUES
(12, 'Ð˜Ð¼Ñ1', 'c4ca4238a0b923820dcc509a6f75849b', '1@mail.ru', 1, 1),
(9, '', 'c81e728d9d4c2f636f067f89cc14862c', '2@mail.ru', 1, -1);

CREATE TABLE `usersparts` (
  `PartID` int(11) NOT NULL,
  `StockID` int(11) NOT NULL,
  `Brand` int(11) NOT NULL,
  `Code` varchar(17) NOT NULL,
  `Name` varchar(50) NOT NULL,
  `IsUsed` tinyint(1) NOT NULL,
  `Quantity` int(11) NOT NULL,
  `Price` float NOT NULL,
  `Photo` varchar(250) NOT NULL,
  `Active` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `userstoks` (
  `StockID` int(11) NOT NULL,
  `UserID` int(11) NOT NULL,
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
  `Active` tinyint(1) NOT NULL,
  `StockName` varchar(25) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;


ALTER TABLE `brands`
  ADD PRIMARY KEY (`ID`);

ALTER TABLE `counties`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `Counties_fk0` (`DefaultCurrency`);

ALTER TABLE `currencies`
  ADD PRIMARY KEY (`ID`);

ALTER TABLE `languages`
  ADD PRIMARY KEY (`ID`);

ALTER TABLE `orders`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `Orders_fk0` (`StockID`),
  ADD KEY `Orders_fk1` (`Brand`),
  ADD KEY `Orders_fk2` (`CustomerID`),
  ADD KEY `Orders_fk3` (`Currency`),
  ADD KEY `Orders_fk4` (`Status`);

ALTER TABLE `orderstatuses`
  ADD PRIMARY KEY (`ID`);

ALTER TABLE `stockphones`
  ADD PRIMARY KEY (`ID`);

ALTER TABLE `users`
  ADD PRIMARY KEY (`UserID`);

ALTER TABLE `usersparts`
  ADD PRIMARY KEY (`PartID`),
  ADD KEY `UsersParts_fk0` (`StockID`),
  ADD KEY `UsersParts_fk1` (`Brand`);

ALTER TABLE `userstoks`
  ADD PRIMARY KEY (`StockID`),
  ADD KEY `UserStoks_fk0` (`UserID`),
  ADD KEY `UserStoks_fk1` (`StockCountry`),
  ADD KEY `UserStoks_fk2` (`StockPhones`),
  ADD KEY `UserStoks_fk3` (`Currency`),
  ADD KEY `UserStoks_fk4` (`Lang`);


ALTER TABLE `brands`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `counties`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `currencies`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `languages`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `orders`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `orderstatuses`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `stockphones`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `users`
  MODIFY `UserID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=155;
ALTER TABLE `usersparts`
  MODIFY `PartID` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `userstoks`
  MODIFY `StockID` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `orders`
  ADD CONSTRAINT `Orders_fk0` FOREIGN KEY (`StockID`) REFERENCES `userstoks` (`StockID`),
  ADD CONSTRAINT `Orders_fk1` FOREIGN KEY (`Brand`) REFERENCES `brands` (`ID`),
  ADD CONSTRAINT `Orders_fk2` FOREIGN KEY (`CustomerID`) REFERENCES `users` (`UserID`),
  ADD CONSTRAINT `Orders_fk3` FOREIGN KEY (`Currency`) REFERENCES `currencies` (`ID`),
  ADD CONSTRAINT `Orders_fk4` FOREIGN KEY (`Status`) REFERENCES `orderstatuses` (`ID`);

ALTER TABLE `usersparts`
  ADD CONSTRAINT `UsersParts_fk0` FOREIGN KEY (`StockID`) REFERENCES `userstoks` (`StockID`),
  ADD CONSTRAINT `UsersParts_fk1` FOREIGN KEY (`Brand`) REFERENCES `brands` (`ID`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
