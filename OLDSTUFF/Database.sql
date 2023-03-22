CREATE TABLE `users` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Cnum` varchar(255) NOT NULL,
  `Pword` varchar(255) NOT NULL, 
  `fname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `rank` varchar(255) NOT NULL DEFAULT "cadet",
  `section` int(11) NOT NULL DEFAULT 1,
  `CFAV` boolean NOT NULL DEFAULT FALSE,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

DROP TABLE IF EXISTS `items`;
CREATE TABLE `items` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `NSN` varchar(255) DEFAULT NULL,
  `ItemTypeID` int(11) NOT NULL,
  `NumIssued` int(11) NOT NULL,
  `NumInStore` int(11) NOT NULL,
  `NumReserved` int(11) NOT NULL,
  `NumOrdered` int(11) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


DROP TABLE IF EXISTS `itemType`;
CREATE TABLE `itemType` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `ItemTypeName` varchar(255) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `itemType` (`ID`, `ItemTypeName`, `NumSizesExpected`) VALUES
(1,	'SHIRT COMBAT',	2),
(2,	'SMOCK',	2),
(3,	'Undershirt(Fleece)',	2),
(4,	'T-Shirt ',	2),
(5,	'Trousers Combat',	3),
(6,	'Socks(Black)',	0),
(7,	'Boots',	1),
(8,	'Cap MTP',	1),
(9,	'Berrett',	1);

DROP TABLE IF EXISTS `sizes`;
CREATE TABLE `sizes` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `itemID` int(11) NOT NULL,
  `sizeTypeID` int(11) NOT NULL,
  `value` int(11) NOT NULL,
  `unit` varchar(255) DEFAULT 'cm',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


DROP TABLE IF EXISTS `sizeType`;
CREATE TABLE `sizeType` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `sizeTypeName` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

DROP TABLE IF EXISTS `itemRequest`;
CREATE TABLE `itemRequest` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `UserID` int(11) NOT NULL,
  `ItemTypeID` int(11) NOT NULL,
  `NumRequested` int(11) NOT NULL,
  `purpose` varchar(255) DEFAULT 'Uniform',
  `DateNeeded` date DEFAULT NULL,
  `DateRequested` datetime DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


DROP TABLE IF EXISTS `sizesRequest`;
CREATE TABLE `sizesRequest` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `itemID` int(11) NOT NULL,
  `sizeTypeID` int(11) NOT NULL,
  `value` int(11) NOT NULL,
  `unit` varchar(255) DEFAULT 'cm',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
