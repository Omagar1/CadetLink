-- Adminer 4.8.1 MySQL 5.5.5-10.3.34-MariaDB-0ubuntu0.20.04.1 dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

SET NAMES utf8mb4;

DROP TABLE IF EXISTS `eventNotes`;
CREATE TABLE `eventNotes` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `eventID` int(11) NOT NULL,
  `Note` varchar(255) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


DROP TABLE IF EXISTS `events`;
CREATE TABLE `events` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `location` varchar(255) NOT NULL,
  `startDate` varchar(255) NOT NULL,
  `endDate` varchar(255) DEFAULT NULL,
  `startTime` varchar(255) DEFAULT NULL,
  `endTime` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `events` (`ID`, `name`, `location`, `startDate`, `endDate`, `startTime`, `endTime`) VALUES
(1,	'Thursday Training',	'Benenden',	'2022-06-30',	'',	'16:30',	'18:30'),
(2,	'Thursday Training',	'Benenden',	'2022-06-30',	'',	'16:30',	'18:30'),
(3,	'Thursday Training',	'Benenden',	'2022-06-23',	'',	'16:30',	'18:30'),
(4,	'Range Day',	'Crobourough Military Camp ',	'2022-06-21',	'2022-06-22',	'09:00',	'12:00'),
(5,	'Cadet Camp ',	'Crobourough Military Camp',	'2022-06-26',	'2022-07-01',	'05:00',	'16:00'),
(6,	'Thursday Training',	'John Wallis Academy ',	'2022-06-08',	'',	'15:30',	'16:30'),
(7,	'Thursday Training',	'John Wallis Academy ',	'2022-06-08',	'',	'12:30',	'16:30');

DROP TABLE IF EXISTS `eventTroops`;
CREATE TABLE `eventTroops` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `eventID` int(11) NOT NULL,
  `troop` varchar(255) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


DROP TABLE IF EXISTS `itemRequest`;
CREATE TABLE `itemRequest` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `StockID` int(11) DEFAULT NULL,
  `UserID` varchar(255) DEFAULT NULL,
  `ItemTypeID` varchar(255) DEFAULT NULL,
  `NumRequested` varchar(255) DEFAULT NULL,
  `purpose` varchar(255) DEFAULT 'Uniform',
  `DateNeeded` varchar(255) DEFAULT NULL,
  `DateRequested` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `itemRequest` (`ID`, `StockID`, `UserID`, `ItemTypeID`, `NumRequested`, `purpose`, `DateNeeded`, `DateRequested`, `status`) VALUES
(253,	1,	'12',	'1',	'1',	'GROWN OUT OF OLD KIT',	NULL,	'2022-06-21 13:50',	'ISSUED');

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `items` (`ID`, `NSN`, `ItemTypeID`, `NumIssued`, `NumInStore`, `NumReserved`, `NumOrdered`) VALUES
(1,	'8415-99-597-0428 ',	1,	20,	8,	1,	3),
(2,	'8415-99-597-0429 ',	1,	13,	0,	0,	0),
(3,	'8415-99-597-0430 ',	1,	1,	0,	0,	1),
(4,	'8415-99-597-0431 ',	1,	20,	6,	0,	0),
(5,	'8415-99-597-0432 ',	1,	11,	2,	0,	0),
(6,	'8415-99-597-0433 ',	1,	5,	2,	0,	0),
(7,	'8415-99-597-0434 ',	1,	0,	0,	0,	0),
(8,	'8415-99-597-0435 ',	1,	1,	2,	0,	0),
(9,	'8415-99-597-0436 ',	1,	5,	1,	0,	0),
(10,	'8415-99-597-0437 ',	1,	0,	0,	0,	0),
(11,	'8415-99-597-0438 ',	1,	0,	0,	0,	0),
(12,	'8415-99-597-0439 ',	1,	1,	0,	0,	0),
(13,	'8415-99-597-0440 ',	1,	0,	0,	0,	0),
(14,	'8415-99-597-0441 ',	1,	0,	0,	0,	0),
(15,	'8415-99-597-0442 ',	1,	0,	0,	0,	0),
(16,	'8415-99-597-0443 ',	1,	0,	0,	0,	0),
(17,	'8415-99-597-0444 ',	1,	0,	0,	0,	0),
(18,	'8415-99-597-0445 ',	1,	0,	0,	0,	0),
(19,	'8415-99-597-0446 ',	1,	0,	0,	0,	1),
(21,	'8415-99-597-0448 ',	1,	0,	0,	0,	0),
(22,	'8415-99-396-5988 ',	2,	2,	6,	0,	0),
(23,	'8415-99-396-5989 ',	2,	0,	1,	0,	0),
(24,	'8415-99-396-5990 ',	2,	5,	0,	0,	0),
(25,	'8415-99-396-5991 ',	2,	2,	8,	0,	0),
(26,	'8415-99-396-5992 ',	2,	9,	2,	0,	0),
(27,	'8415-99-396-5993 ',	2,	2,	2,	0,	0),
(28,	'8415-99-396-5994 ',	2,	0,	0,	0,	0),
(29,	'8415-99-396-5995 ',	2,	1,	2,	0,	0),
(30,	'8415-99-396-5996 ',	2,	1,	1,	0,	0),
(31,	'8415-99-396-5997 ',	2,	0,	0,	0,	0),
(32,	'8415-99-396-5998 ',	2,	0,	0,	0,	0),
(33,	'8415-99-396-5999 ',	2,	0,	0,	0,	0),
(34,	'8415-99-396-6000 ',	2,	0,	0,	0,	0),
(35,	'8415-99-396-6001 ',	2,	0,	0,	0,	0),
(36,	'8415-99-396-6002 ',	2,	0,	0,	0,	0),
(37,	'8415-99-396-6003 ',	2,	0,	0,	0,	0),
(38,	'8415-99-396-6004 ',	2,	0,	0,	0,	0),
(39,	'8415-99-813-3260 ',	3,	20,	3,	0,	0),
(40,	'8415-99-813-3261 ',	3,	13,	16,	0,	0),
(41,	'8415-99-813-3262 ',	3,	0,	3,	0,	0),
(42,	'8415-99-813-3263 ',	3,	0,	0,	0,	0),
(43,	'8415-99-813-3264 ',	3,	0,	0,	0,	0),
(44,	'8415-99-813-3265 ',	3,	0,	0,	0,	0),
(45,	'8415-99-813-3254 ',	4,	0,	6,	0,	0),
(46,	'8415-99-813-3255 ',	4,	0,	22,	0,	0),
(47,	'8415-99-813-3256 ',	4,	0,	4,	0,	0),
(48,	'8415-99-813-3257 ',	4,	0,	0,	0,	0),
(49,	'8415-99-813-3258 ',	4,	0,	0,	0,	0),
(50,	'8415-99-813-3259 ',	4,	0,	0,	0,	0),
(51,	'8415-99-317-8270 ',	5,	2,	3,	0,	0),
(52,	'8415-99-317-8271 ',	5,	1,	0,	0,	0),
(53,	'8415-99-317-8272 ',	5,	1,	9,	0,	0),
(54,	'8415-99-317-8273 ',	5,	0,	8,	0,	0),
(55,	'8415-99-317-8274 ',	5,	1,	4,	0,	0),
(56,	'8415-99-317-8275 ',	5,	1,	0,	0,	0),
(57,	'8415-99-317-8276 ',	5,	1,	0,	0,	0),
(58,	'8415-99-317-8277 ',	5,	1,	3,	0,	0),
(59,	'8415-99-317-8278 ',	5,	2,	8,	0,	0),
(60,	'8415-99-317-8279 ',	5,	2,	0,	0,	0),
(61,	'8415-99-317-8280 ',	5,	2,	15,	0,	0),
(62,	'8415-99-317-8281 ',	5,	1,	9,	0,	0),
(63,	'8415-99-317-8282 ',	5,	2,	12,	0,	0),
(64,	'8415-99-317-8283 ',	5,	0,	4,	0,	0),
(65,	'8415-99-317-8284 ',	5,	0,	1,	0,	0),
(66,	'8415-99-317-8285 ',	5,	0,	0,	0,	0),
(67,	'8415-99-317-8286 ',	5,	1,	0,	0,	0),
(68,	'8415-99-317-8287 ',	5,	0,	0,	0,	0),
(69,	'8415-99-317-8288 ',	5,	0,	0,	0,	0),
(70,	'8415-99-317-8289 ',	5,	2,	0,	0,	0),
(71,	'8415-99-317-8290 ',	5,	0,	0,	0,	0),
(72,	'8415-99-317-8291 ',	5,	1,	0,	0,	0),
(73,	'8415-99-317-8292 ',	5,	1,	0,	0,	0),
(74,	'8415-99-317-8293 ',	5,	0,	0,	0,	0),
(75,	'8415-99-317-8294 ',	5,	0,	0,	0,	0),
(76,	'8415-99-317-8295 ',	5,	0,	0,	0,	0),
(77,	'',	7,	1,	0,	2,	1),
(78,	NULL,	7,	2,	0,	0,	0),
(79,	NULL,	7,	3,	0,	0,	0),
(80,	NULL,	7,	5,	0,	0,	2),
(81,	NULL,	7,	7,	0,	0,	0),
(82,	NULL,	7,	2,	0,	0,	0),
(83,	NULL,	7,	2,	0,	0,	1),
(84,	NULL,	7,	0,	0,	0,	0),
(85,	NULL,	7,	0,	0,	0,	0),
(86,	NULL,	7,	0,	0,	0,	0),
(87,	NULL,	7,	1,	0,	0,	1),
(88,	'8405-99-976-0231',	8,	0,	7,	0,	0),
(89,	'8405-99-976-0232 ',	8,	0,	1,	0,	0),
(90,	'8405-99-976-0233 ',	8,	0,	5,	0,	0),
(91,	'8405-99-976-0234 ',	8,	1,	7,	0,	0),
(92,	'8405-99-976-0235 ',	8,	1,	5,	0,	0),
(93,	'8405-99-976-0236 ',	8,	0,	3,	0,	0),
(94,	'8405-99-976-0237 ',	8,	2,	0,	0,	0),
(95,	'8405-99-976-0238 ',	8,	1,	3,	0,	0),
(96,	'8405-99-976-0239 ',	8,	5,	4,	0,	0),
(97,	'8405-99-976-0240 ',	8,	1,	13,	0,	0),
(98,	'8405-99-976-0241 ',	8,	9,	0,	0,	0),
(99,	'8405-99-976-0242 ',	8,	2,	0,	0,	0),
(100,	'8405-99-976-0243 ',	8,	0,	0,	0,	0),
(101,	'8405-99-976-0244 ',	8,	0,	0,	0,	0),
(102,	'8405-99-976-0245 ',	8,	0,	0,	0,	0),
(103,	'8405-99-976-0246 ',	8,	0,	0,	0,	0),
(104,	'8415-99-915-8224',	9,	0,	0,	0,	0),
(105,	'8415-99-915-8225',	9,	0,	0,	0,	0),
(106,	'8415-99-915-8226',	9,	0,	0,	0,	0),
(107,	'8415-99-915-8227',	9,	0,	0,	0,	0),
(108,	'8415-99-915-8228',	9,	0,	0,	0,	0),
(109,	'8415-99-915-8229',	9,	0,	0,	0,	0),
(110,	'8415-99-915-8230',	9,	0,	0,	0,	0),
(111,	'8415-99-915-8231',	9,	0,	0,	0,	0),
(112,	'8415-99-915-8232',	9,	0,	0,	0,	0),
(113,	'8415-99-915-8233',	9,	0,	0,	0,	0),
(114,	'8415-99-915-8234',	9,	0,	0,	0,	0),
(115,	'8415-99-915-8235',	9,	0,	0,	0,	0),
(116,	'8415-99-915-8236',	9,	0,	0,	0,	0),
(117,	'8415-99-915-8237',	9,	0,	0,	0,	0),
(118,	'8415-99-915-8238',	9,	0,	0,	0,	0),
(119,	'8415-99-915-8239',	9,	0,	0,	0,	0),
(120,	'8415-99-915-8240',	9,	0,	0,	0,	0),
(127,	'',	7,	3,	2,	5,	1);

DROP TABLE IF EXISTS `itemType`;
CREATE TABLE `itemType` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `ItemTypeName` varchar(255) NOT NULL,
  `NumSizesExpected` int(11) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `itemType` (`ID`, `ItemTypeName`, `NumSizesExpected`) VALUES
(1,	'SHIRT COMBAT',	2),
(2,	'SMOCK',	2),
(3,	'Undershirt(Fleece)',	2),
(4,	'T- Shirt ',	2),
(5,	'Trousers Combat',	3),
(6,	'Socks(Black)',	0),
(7,	'Boots',	1),
(8,	'Cap MTP',	1),
(9,	'Berrett',	1);

DROP TABLE IF EXISTS `orders`;
CREATE TABLE `orders` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `dateFor` varchar(255) NOT NULL,
  `location` varchar(255) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `orders` (`ID`, `name`, `dateFor`, `location`) VALUES
(1,	'test3',	'2022-05-19',	'Orders/test3'),
(2,	'test4',	'2022-05-19',	'Orders/test4'),
(3,	'test5',	'2022-05-19',	'Orders/test5');

DROP TABLE IF EXISTS `ranks`;
CREATE TABLE `ranks` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `rank` varchar(255) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `ranks` (`ID`, `rank`) VALUES
(1,	'Cdt'),
(2,	'l/Cpl'),
(3,	'Cpl'),
(4,	'Sgt'),
(5,	'Ssgt'),
(6,	'W02'),
(7,	'W01'),
(8,	'SgtCFAV'),
(9,	'2lt'),
(10,	'lt'),
(11,	'Cpt'),
(12,	'Maj');

DROP TABLE IF EXISTS `sizes`;
CREATE TABLE `sizes` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `itemID` int(11) NOT NULL,
  `sizeTypeID` int(11) NOT NULL,
  `value` int(11) NOT NULL,
  `unit` varchar(255) DEFAULT 'cm',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `sizes` (`ID`, `itemID`, `sizeTypeID`, `value`, `unit`) VALUES
(1,	1,	1,	160,	'cm'),
(2,	1,	2,	88,	'cm'),
(3,	2,	1,	160,	'cm'),
(4,	2,	2,	96,	'cm'),
(5,	3,	1,	160,	'cm'),
(6,	3,	2,	104,	'cm'),
(7,	4,	1,	170,	'cm'),
(8,	4,	2,	88,	'cm'),
(9,	5,	1,	170,	'cm'),
(10,	5,	2,	96,	'cm'),
(11,	6,	1,	170,	'cm'),
(12,	6,	2,	104,	'cm'),
(13,	7,	1,	170,	'cm'),
(14,	7,	2,	112,	'cm'),
(15,	8,	1,	180,	'cm'),
(16,	8,	2,	96,	'cm'),
(17,	9,	1,	180,	'cm'),
(18,	9,	2,	104,	'cm'),
(19,	10,	1,	180,	'cm'),
(20,	10,	2,	112,	'cm'),
(21,	11,	1,	180,	'cm'),
(22,	11,	2,	120,	'cm'),
(23,	12,	1,	190,	'cm'),
(24,	12,	2,	96,	'cm'),
(25,	13,	1,	190,	'cm'),
(26,	13,	2,	104,	'cm'),
(27,	14,	1,	190,	'cm'),
(28,	14,	2,	112,	'cm'),
(29,	15,	1,	190,	'cm'),
(30,	15,	2,	120,	'cm'),
(31,	16,	1,	200,	'cm'),
(32,	16,	2,	104,	'cm'),
(33,	17,	1,	200,	'cm'),
(34,	17,	2,	112,	'cm'),
(35,	18,	1,	200,	'cm'),
(36,	18,	2,	120,	'cm'),
(37,	19,	1,	200,	'cm'),
(38,	19,	2,	128,	'cm'),
(41,	21,	1,	0,	'cm'),
(42,	21,	2,	0,	'cm'),
(43,	22,	1,	160,	'cm'),
(44,	22,	2,	88,	'cm'),
(45,	23,	1,	160,	'cm'),
(46,	23,	2,	96,	'cm'),
(47,	24,	1,	160,	'cm'),
(48,	24,	2,	104,	'cm'),
(49,	25,	1,	170,	'cm'),
(50,	25,	2,	88,	'cm'),
(51,	26,	1,	170,	'cm'),
(52,	26,	2,	96,	'cm'),
(53,	27,	1,	170,	'cm'),
(54,	27,	2,	104,	'cm'),
(55,	28,	1,	170,	'cm'),
(56,	28,	2,	112,	'cm'),
(57,	29,	1,	180,	'cm'),
(58,	29,	2,	96,	'cm'),
(59,	30,	1,	180,	'cm'),
(60,	30,	2,	104,	'cm'),
(61,	31,	1,	180,	'cm'),
(62,	31,	2,	112,	'cm'),
(63,	32,	1,	190,	'cm'),
(64,	32,	2,	96,	'cm'),
(65,	33,	1,	190,	'cm'),
(66,	33,	2,	104,	'cm'),
(67,	34,	1,	190,	'cm'),
(68,	34,	2,	112,	'cm'),
(69,	35,	1,	190,	'cm'),
(70,	35,	2,	120,	'cm'),
(71,	36,	1,	200,	'cm'),
(72,	36,	2,	112,	'cm'),
(73,	37,	1,	200,	'cm'),
(74,	37,	2,	120,	'cm'),
(75,	38,	1,	0,	'cm'),
(76,	38,	2,	0,	'cm'),
(77,	39,	1,	160,	'cm'),
(78,	39,	2,	80,	'cm'),
(79,	40,	1,	170,	'cm'),
(80,	40,	2,	90,	'cm'),
(81,	41,	1,	180,	'cm'),
(82,	41,	2,	100,	'cm'),
(83,	42,	1,	190,	'cm'),
(84,	42,	2,	110,	'cm'),
(85,	43,	1,	200,	'cm'),
(86,	43,	2,	120,	'cm'),
(87,	44,	1,	0,	'cm'),
(88,	44,	2,	0,	'cm'),
(89,	45,	1,	160,	'cm'),
(90,	45,	2,	80,	'cm'),
(91,	46,	1,	170,	'cm'),
(92,	46,	2,	90,	'cm'),
(93,	47,	1,	180,	'cm'),
(94,	47,	2,	100,	'cm'),
(95,	48,	1,	190,	'cm'),
(96,	48,	2,	110,	'cm'),
(97,	49,	1,	200,	'cm'),
(98,	49,	2,	120,	'cm'),
(99,	50,	1,	0,	'cm'),
(100,	50,	2,	0,	'cm'),
(101,	51,	3,	70,	'cm'),
(102,	51,	4,	72,	'cm'),
(103,	51,	5,	88,	'cm'),
(104,	52,	3,	70,	'cm'),
(105,	52,	4,	76,	'cm'),
(106,	52,	5,	92,	'cm'),
(107,	53,	3,	70,	'cm'),
(108,	53,	4,	80,	'cm'),
(109,	53,	5,	96,	'cm'),
(110,	54,	3,	75,	'cm'),
(111,	54,	4,	68,	'cm'),
(112,	54,	5,	84,	'cm'),
(113,	55,	3,	75,	'cm'),
(114,	55,	4,	72,	'cm'),
(115,	55,	5,	88,	'cm'),
(116,	56,	3,	75,	'cm'),
(117,	56,	4,	76,	'cm'),
(118,	56,	5,	92,	'cm'),
(119,	57,	3,	75,	'cm'),
(120,	57,	4,	80,	'cm'),
(121,	57,	5,	96,	'cm'),
(122,	58,	3,	75,	'cm'),
(123,	58,	4,	84,	'cm'),
(124,	58,	5,	100,	'cm'),
(125,	59,	3,	75,	'cm'),
(126,	59,	4,	88,	'cm'),
(127,	59,	5,	104,	'cm'),
(128,	60,	3,	75,	'cm'),
(129,	60,	4,	92,	'cm'),
(130,	60,	5,	108,	'cm'),
(131,	61,	3,	80,	'cm'),
(132,	61,	4,	72,	'cm'),
(133,	61,	5,	88,	'cm'),
(134,	62,	3,	80,	'cm'),
(135,	62,	4,	76,	'cm'),
(136,	62,	5,	92,	'cm'),
(137,	63,	3,	80,	'cm'),
(138,	63,	4,	80,	'cm'),
(139,	63,	5,	96,	'cm'),
(140,	64,	3,	80,	'cm'),
(141,	64,	4,	84,	'cm'),
(142,	64,	5,	100,	'cm'),
(143,	65,	3,	80,	'cm'),
(144,	65,	4,	88,	'cm'),
(145,	65,	5,	104,	'cm'),
(146,	66,	3,	80,	'cm'),
(147,	66,	4,	92,	'cm'),
(148,	66,	5,	108,	'cm'),
(149,	67,	3,	80,	'cm'),
(150,	67,	4,	96,	'cm'),
(151,	67,	5,	112,	'cm'),
(152,	68,	3,	80,	'cm'),
(153,	68,	4,	100,	'cm'),
(154,	68,	5,	116,	'cm'),
(155,	69,	3,	80,	'cm'),
(156,	69,	4,	104,	'cm'),
(157,	69,	5,	120,	'cm'),
(158,	70,	3,	85,	'cm'),
(159,	70,	4,	80,	'cm'),
(160,	70,	5,	96,	'cm'),
(161,	71,	3,	85,	'cm'),
(162,	71,	4,	84,	'cm'),
(163,	71,	5,	100,	'cm'),
(164,	72,	3,	85,	'cm'),
(165,	72,	4,	88,	'cm'),
(166,	72,	5,	104,	'cm'),
(167,	73,	3,	85,	'cm'),
(168,	73,	4,	92,	'cm'),
(169,	73,	5,	108,	'cm'),
(170,	74,	3,	85,	'cm'),
(171,	74,	4,	96,	'cm'),
(172,	74,	5,	112,	'cm'),
(173,	75,	3,	85,	'cm'),
(174,	75,	4,	100,	'cm'),
(175,	75,	5,	116,	'cm'),
(176,	76,	3,	85,	'cm'),
(177,	76,	4,	104,	'cm'),
(178,	76,	5,	120,	'cm'),
(179,	88,	7,	48,	'cm'),
(180,	89,	7,	49,	'cm'),
(181,	90,	7,	50,	'cm'),
(182,	91,	7,	51,	'cm'),
(183,	92,	7,	52,	'cm'),
(184,	93,	7,	53,	'cm'),
(185,	94,	7,	54,	'cm'),
(186,	95,	7,	55,	'cm'),
(187,	96,	7,	56,	'cm'),
(188,	97,	7,	57,	'cm'),
(189,	98,	7,	58,	'cm'),
(190,	99,	7,	59,	'cm'),
(191,	100,	7,	60,	'cm'),
(192,	101,	7,	61,	'cm'),
(193,	102,	7,	62,	'cm'),
(194,	103,	7,	63,	'cm'),
(195,	104,	7,	48,	'cm'),
(196,	105,	7,	49,	'cm'),
(197,	106,	7,	50,	'cm'),
(198,	107,	7,	51,	'cm'),
(199,	108,	7,	52,	'cm'),
(200,	109,	7,	53,	'cm'),
(201,	110,	7,	54,	'cm'),
(202,	111,	7,	55,	'cm'),
(203,	112,	7,	56,	'cm'),
(204,	113,	7,	57,	'cm'),
(205,	114,	7,	58,	'cm'),
(206,	115,	7,	59,	'cm'),
(207,	116,	7,	60,	'cm'),
(208,	117,	7,	61,	'cm'),
(209,	118,	7,	62,	'cm'),
(210,	119,	7,	63,	'cm'),
(211,	120,	7,	64,	'cm'),
(212,	77,	6,	3,	'shoeSize'),
(213,	78,	6,	4,	'shoeSize'),
(214,	79,	6,	5,	'shoeSize'),
(215,	80,	6,	6,	'shoeSize'),
(216,	81,	6,	7,	'shoeSize'),
(217,	82,	6,	8,	'shoeSize'),
(218,	83,	6,	9,	'shoeSize'),
(219,	84,	6,	10,	'shoeSize'),
(220,	85,	6,	11,	'shoeSize'),
(221,	86,	6,	12,	'shoeSize'),
(222,	87,	6,	13,	'shoeSize'),
(228,	127,	7,	7,	'cm');

DROP TABLE IF EXISTS `sizesRequest`;
CREATE TABLE `sizesRequest` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `itemID` int(11) NOT NULL,
  `sizeTypeID` int(11) NOT NULL,
  `value` int(11) NOT NULL,
  `unit` varchar(255) DEFAULT 'cm',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `sizesRequest` (`ID`, `itemID`, `sizeTypeID`, `value`, `unit`) VALUES
(372,	253,	1,	160,	'cm'),
(373,	253,	2,	88,	'cm');

DROP TABLE IF EXISTS `sizeType`;
CREATE TABLE `sizeType` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `sizeTypeName` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `sizeType` (`ID`, `sizeTypeName`) VALUES
(1,	'Height'),
(2,	'Chest'),
(3,	'Inside Leg'),
(4,	'Inside Leg'),
(5,	'Waist'),
(6,	'Seat'),
(7,	'ShoeSize');

DROP TABLE IF EXISTS `statuses`;
CREATE TABLE `statuses` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `status` varchar(255) NOT NULL,
  `linkedColumn` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `statuses` (`ID`, `status`, `linkedColumn`) VALUES
(1,	'ISSUED',	'NumIssued'),
(2,	'TO BE ISSUED',	'NumReserved'),
(3,	'ORDERED',	'NumOrdered'),
(4,	'AWAITING ORDER',	NULL);

DROP TABLE IF EXISTS `test`;
CREATE TABLE `test` (
  `test1` varchar(255) DEFAULT NULL,
  `test2` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `test` (`test1`, `test2`) VALUES
('hello',	'world'),
('hello',	'world');

DROP TABLE IF EXISTS `troops`;
CREATE TABLE `troops` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `troopName` varchar(255) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `troops` (`ID`, `troopName`) VALUES
(1,	'Chard'),
(2,	'Kitchener'),
(3,	'Gundulf'),
(4,	'Archibald'),
(6,	'CFAV');

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Cnum` varchar(255) NOT NULL,
  `Pword` varchar(255) NOT NULL,
  `fname` varchar(255) NOT NULL,
  `lname` varchar(255) NOT NULL,
  `rank` varchar(255) NOT NULL DEFAULT 'cadet',
  `troop` varchar(255) NOT NULL DEFAULT 'Chard',
  `section` int(11) NOT NULL DEFAULT 1,
  `profilePicURL` varchar(255) NOT NULL DEFAULT 'defaltProfilePic.jpg',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `users` (`ID`, `Cnum`, `Pword`, `fname`, `lname`, `rank`, `troop`, `section`, `profilePicURL`) VALUES
(1,	'12345678',	'$2y$10$H750ZC6fqieSOa9pUcotm.2YrhZuh3zh3n9JNpS7hfpbJLr2XJ6ZC',	'Josh',	'Torrance',	'Ssgt',	'Archibald',	1,	'defaltProfilePic.jpg'),
(5,	'43218765',	'$2y$10$ae/yE7i5CN/NUiX9gyW2Y.N9imRDnysu6QqNQJ4digmfS3eS.vkOC',	'mike',	'wazowsky',	'W02',	'Archibald',	1,	'defaltProfilePic.jpg'),
(6,	'18273645',	'$2y$10$UhcjJeEcnofh6Ry4lXRk6O4Zv1fiUSstURK2KO5giVSOB0AqQuxx6',	'mike',	'wazowsky the 2nd ',	'Cdt',	'Chard',	1,	'defaltProfilePic.jpg'),
(11,	'99999999',	'$2y$10$NszNEc1O5BkfZ99hY1rJ9uzJBnP2wuaOqM0eDxuRaAM45r2OB6gNW',	'Morgans',	'deen',	'2lt',	'Chard',	1,	'defaltProfilePic.jpg'),
(12,	'11111111',	'$2y$10$kYbu/DmaFyPseaZSSs59z.VHkotSpewbKsR2UUm1c/YpsdlOO3bHG',	'                                                                      ADMIN',	'01',	'Cpt',	'CFAV',	1,	'defaltProfilePic.jpg'),
(13,	'22222222',	'$2y$10$ajWvLpoKjYsgCyq.iIx3uu36vU8wujlualmUDnmhldab3kACtgI0e',	'john ',	'doe',	'Cdt',	'Chard',	1,	'defaltProfilePic.jpg'),
(19,	'11111112',	'$2y$10$X0vQ65isCXictClKNfzBc.u8DtcdorZKuixIOLKUALxRJOE9xxy6G',	'mike',	' not w',	'Cdt',	'Chard',	1,	'defaltProfilePic.jpg'),
(20,	'09876567890',	'$2y$10$hs/Rn4rdkPZbSs2Y1PEvX.7hlPE.MrILIoSb/a4VFm0miTVrdcDue',	'Mike',	'wazowsky the 3rd',	'Cdt',	'Kitchener',	1,	'defaltProfilePic.jpg'),
(21,	'696969696969696969',	'$2y$10$wkAgWAGN9wDqnWaVKWPA/.cTzDLPhJdt6FJJh5IrITPEILnELpo8u',	'Lella',	'Smith',	'Cdt',	'Kitchener',	1,	'defaltProfilePic.jpg');

-- 2022-06-24 12:56:39