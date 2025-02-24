-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Feb 05, 2025 at 04:01 PM
-- Server version: 8.0.36
-- PHP Version: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `rentcar`
--

-- --------------------------------------------------------

--
-- Table structure for table `carcompany`
--

CREATE TABLE `carcompany` (
  `ComCode` char(2) COLLATE utf8mb4_general_ci NOT NULL,
  `ComName` varchar(20) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `carcompany`
--

INSERT INTO `carcompany` (`ComCode`, `ComName`) VALUES
('01', 'Toyota'),
('02', 'Mercedes'),
('03', 'Ford'),
('04', 'Mazda'),
('05', 'Lexus'),
('06', 'Nissan');

-- --------------------------------------------------------

--
-- Table structure for table `carmanagment`
--

CREATE TABLE `carmanagment` (
  `EID` int NOT NULL,
  `PlateNo` char(7) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `carmodel`
--

CREATE TABLE `carmodel` (
  `MCode` char(2) COLLATE utf8mb4_general_ci NOT NULL,
  `ComCode` char(2) COLLATE utf8mb4_general_ci NOT NULL,
  `MName` varchar(20) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `carmodel`
--

INSERT INTO `carmodel` (`MCode`, `ComCode`, `MName`) VALUES
('1', '03', 'Mondeo'),
('11', '01', 'RAIZE'),
('12', '01', 'Fortuner'),
('14', '01', 'GR86'),
('15', '01', 'Supra'),
('18', '01', 'GR86'),
('19', '01', 'Yars'),
('2', '03', 'Mustang GT'),
('21', '02', 'G-Class'),
('22', '02', 'GLE Coupe'),
('23', '02', 'GLA SUV'),
('24', '02', 'C-Class'),
('25', '02', 'Benz E-Class'),
('26', '02', 'Benz-EQE'),
('27', '02', 'Benz amg-gt'),
('28', '02', 'Benz_SL'),
('3', '03', 'Super Duty F-350'),
('31', '03', 'Ford Taurus'),
('32', '03', 'Ford Mustang'),
('34', '03', 'Explorer-st'),
('35', '03', 'saloon'),
('36', '03', 'Ford Everest-XLT'),
('37', '03', 'F-150'),
('38', '03', 'ford Marcez'),
('41', '04', 'Convertible'),
('42', '04', 'RX-7'),
('43', '04', 'CX-5'),
('44', '04', 'CX-60'),
('45', '04', 'Mazda 6'),
('46', '04', 'Mazda 3'),
('51', '05', 'GX460'),
('52', '05', 'ES'),
('53', '05', 'RX'),
('54', '05', 'IS'),
('55', '05', 'LC500-AA'),
('56', '05', 'RC-F'),
('61', '06', 'Altima'),
('63', '06', 'Maxima'),
('64', '06', 'Sentra'),
('65', '06', 'Patrol'),
('66', '06', 'crossovers'),
('67', '06', 'GT-R'),
('68', '06', 'Z Proto'),
('97', '01', 'Camery'),
('98', '01', 'Yars'),
('99', '01', 'Crola');

-- --------------------------------------------------------

--
-- Table structure for table `company`
--

CREATE TABLE `company` (
  `CompanyID` int NOT NULL,
  `UsName` varchar(15) COLLATE utf8mb4_general_ci NOT NULL,
  `Name` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `Addres` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `Phone` char(13) COLLATE utf8mb4_general_ci NOT NULL,
  `Email` varchar(50) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `company`
--

INSERT INTO `company` (`CompanyID`, `UsName`, `Name`, `Addres`, `Phone`, `Email`) VALUES
(1010, 'yelo', 'Yelo', 'medina', '0555556869', 'yelo@gmail.com'),
(2020, 'rotana', 'Rotana', 'Abha', '55555555', 'Rotana@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `contactus`
--

CREATE TABLE `contactus` (
  `Name` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `Email` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `Subject` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `Message` varchar(10000) COLLATE utf8mb4_general_ci NOT NULL,
  `CoNo` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contactus`
--

INSERT INTO `contactus` (`Name`, `Email`, `Subject`, `Message`, `CoNo`) VALUES
('Adel Alali', 'Adel@gmail.com', 'Inquiry about mileage limits', 'Dear team\r\nI would like to inquire about your car rental policy regarding mileage. Is there a daily limit, or is the mileage unlimited?\r\nIf possible, could you clarify any additional fees that may apply if the limit is exceeded (if applicable)?\r\nThank you.', 1),
('Ahmed Alghamdi', 'Ahmed@gmail.com', 'Inquiry about insurance terms', 'I would like to learn more about the insurance terms when renting a car through your platform. Does the insurance cover all accidents? Are there any additional fees for full insurance coverage?\r\nThank you, and I look forward to your response.', 2);

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `CID` int NOT NULL,
  `UsName` varchar(15) COLLATE utf8mb4_general_ci NOT NULL,
  `FName` varchar(15) COLLATE utf8mb4_general_ci NOT NULL,
  `LName` varchar(15) COLLATE utf8mb4_general_ci NOT NULL,
  `LicenesID` varchar(14) COLLATE utf8mb4_general_ci NOT NULL,
  `BirthDate` date NOT NULL,
  `City` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `Street` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `Phone` char(13) COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(50) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`CID`, `UsName`, `FName`, `LName`, `LicenesID`, `BirthDate`, `City`, `Street`, `Phone`, `email`) VALUES
(1111111111, 'ahmed', 'ahmed', 'Al-Otaybi', '12345678912345', '1998-04-09', 'Jeddah', 'Al-Hamra', '575569875', 'am479@gmail.com'),
(1119666967, 'Adel', 'Adel', 'Alharbi', '12451245123635', '1999-09-09', 'medina', 'Al-Hajra', '966570002759', 'Adel@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `employee`
--

CREATE TABLE `employee` (
  `EID` int NOT NULL,
  `mngID` int NOT NULL,
  `UsName` varchar(15) COLLATE utf8mb4_general_ci NOT NULL,
  `FName` varchar(15) COLLATE utf8mb4_general_ci NOT NULL,
  `LName` varchar(15) COLLATE utf8mb4_general_ci NOT NULL,
  `Email` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `Phone` int NOT NULL,
  `City` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `Street` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `Salary` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `employee`
--

INSERT INTO `employee` (`EID`, `mngID`, `UsName`, `FName`, `LName`, `Email`, `Phone`, `City`, `Street`, `Salary`) VALUES
(1, 1, 'emad', 'emad', 'Al-harbi', 'emad@gmail.com', 55555555, 'medina', ' medina', 10000);

-- --------------------------------------------------------

--
-- Table structure for table `rent`
--

CREATE TABLE `rent` (
  `RentNo` int NOT NULL,
  `EID` int NOT NULL,
  `CID` int NOT NULL,
  `PlateNo` char(7) COLLATE utf8mb4_general_ci NOT NULL,
  `CompanyID` int NOT NULL,
  `RentDateFrom` date NOT NULL,
  `RentDateTo` date NOT NULL,
  `RentPeriod` int NOT NULL,
  `RentDate` date NOT NULL,
  `Amount` float NOT NULL,
  `PayMethod` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `PayDate` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rent`
--

INSERT INTO `rent` (`RentNo`, `EID`, `CID`, `PlateNo`, `CompanyID`, `RentDateFrom`, `RentDateTo`, `RentPeriod`, `RentDate`, `Amount`, `PayMethod`, `PayDate`) VALUES
(17, 1, 1119666967, 'SDD2356', 2020, '2024-11-22', '2024-11-26', 5, '2024-11-21', 1250, 'cash', '2024-11-21'),
(18, 1, 1111111111, 'REY2365', 1010, '2024-11-26', '2024-11-30', 5, '2024-11-25', 990, 'cash', '2024-11-25'),
(19, 1, 1119666967, 'HJU8888', 2020, '2024-11-28', '2024-11-30', 3, '2024-11-28', 495, 'card', '2024-11-28'),
(21, 1, 1119666967, 'CVT3265', 1010, '2024-12-17', '2024-12-25', 9, '2024-12-16', 2250, 'cash', '2024-12-16'),
(22, 1, 1119666967, 'NBU3633', 2020, '2024-12-25', '2024-12-26', 2, '2024-12-16', 526, 'card', '2024-12-16');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `UsName` varchar(15) COLLATE utf8mb4_general_ci NOT NULL,
  `Password` varchar(15) COLLATE utf8mb4_general_ci NOT NULL,
  `UsType` char(1) COLLATE utf8mb4_general_ci NOT NULL,
  `DateCreat` date NOT NULL,
  `Status` char(1) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`UsName`, `Password`, `UsType`, `DateCreat`, `Status`) VALUES
('Adel', 'Adel1234', '3', '2024-11-19', 'A'),
('admin', 'admin', '1', '2024-11-25', 'A'),
('ahmed', 'ahmed1234', '3', '2024-11-02', 'A'),
('emad', 'emad1234', '1', '2024-11-01', 'A'),
('rotana', 'rotana2020', '2', '2024-11-14', 'A'),
('yelo', 'yelo1010', '2', '2024-11-01', 'A');

-- --------------------------------------------------------

--
-- Table structure for table `vehicle`
--

CREATE TABLE `vehicle` (
  `PlateNo` char(7) COLLATE utf8mb4_general_ci NOT NULL,
  `CompanyID` int NOT NULL,
  `GearType` char(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `CarType` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `DailyPrice` float NOT NULL,
  `Color` varchar(15) COLLATE utf8mb4_general_ci NOT NULL,
  `Year` year NOT NULL,
  `ComCode` char(2) COLLATE utf8mb4_general_ci NOT NULL,
  `MCode` char(2) COLLATE utf8mb4_general_ci NOT NULL,
  `Available` char(1) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `vehicle`
--

INSERT INTO `vehicle` (`PlateNo`, `CompanyID`, `GearType`, `CarType`, `DailyPrice`, `Color`, `Year`, `ComCode`, `MCode`, `Available`) VALUES
('AGO6666', 2020, 'Ordinary Qir', 'Sports', 236, 'Black', '2024', '06', '67', '1'),
('ASR3399', 1010, 'Tamatek Qir', 'Sedans', 150, 'Red', '2024', '04', '46', '1'),
('ASS5236', 1010, 'Tamatek Qir', 'SUV', 300, 'white', '2025', '01', '12', '0'),
('AXC2023', 1010, 'Ordinary Qir', 'SUV', 250, 'Green', '2023', '03', '36', '0'),
('BMI3299', 2020, 'Tamatek Qir', 'Sports', 420, 'Blue', '2024', '02', '28', '1'),
('ccv202', 1010, 'Tamatek Qir', 'SUV', 400, 'Blue', '2025', '05', '51', '1'),
('CVG3222', 1010, 'Ordinary Qir', 'Sports', 450, 'Red', '2021', '02', '27', '1'),
('CVK3333', 2020, 'Tamatek Qir', 'Sports', 350, 'Red', '2025', '03', '2', '1'),
('CVT3265', 1010, 'Tamatek Qir', 'Sedans', 250, 'light Grey', '2025', '02', '24', '0'),
('DBG3332', 1010, 'Tamatek Qir', 'Sedans', 190, 'Dark blue', '2024', '04', '45', '1'),
('DFI9855', 1010, 'Tamatek Qir', 'SUV', 210, 'Blue', '2025', '06', '66', '1'),
('EEE1', 2020, 'Tamatek Qir', 'Sedans', 300, 'Red', '2024', '05', '54', '1'),
('EOO3699', 2020, 'Tamatek Qir', 'Sedans', 240, 'Grey', '2025', '03', '1', '1'),
('FBH3368', 2020, 'Tamatek Qir', 'Sports', 590, 'Green', '2025', '01', '14', '1'),
('GBN8522', 2020, 'Tamatek Qir', 'SUV', 350, 'Black', '2024', '02', '21', '1'),
('HJU8888', 2020, 'Tamatek Qir', 'Sedans', 165, 'Black', '2024', '06', '64', '1'),
('IPT2223', 2020, 'Tamatek Qir', 'SUV', 320, 'Red', '2025', '02', '22', '1'),
('KAC5888', 2020, 'Ordinary Qir', 'Sports', 380, 'Blue', '2023', '06', '68', '1'),
('LMN1200', 2020, 'Tamatek Qir', 'Sedans', 170, 'Blue', '2022', '06', '63', '1'),
('MVT5555', 2020, 'Tamatek Qir', 'SUV', 230, 'White', '2024', '04', '44', '1'),
('NBU3633', 2020, 'Tamatek Qir', 'Sedans', 263, 'White', '2024', '02', '26', '0'),
('NMJ5699', 1010, 'Tamatek Qir', 'Sedans', 299, 'Black', '2025', '02', '25', '1'),
('NMU3333', 1010, 'Tamatek Qir', 'SUV', 210, 'Grey', '2024', '04', '43', '1'),
('PPO3265', 2020, 'Ordinary Qir', 'Sedans', 150, 'Grey', '2024', '01', '19', '1'),
('PPP7770', 1010, 'Tamatek Qir', 'Sports', 650, 'yellow', '2025', '05', '56', '1'),
('PWQ2222', 2020, 'Ordinary Qir', 'Sports', 395, 'White', '2023', '04', '41', '1'),
('QQQ1234', 2020, 'Tamatek Qir', 'Sedans', 190, 'Grey', '2023', '01', '99', '1'),
('QWO9965', 1010, 'Tamatek Qir', 'Sedans', 180, 'Black', '2023', '06', '61', '1'),
('RET5869', 2020, 'Tamatek Qir', 'Sedans', 380, 'Blue', '2025', '03', '31', '1'),
('REY2365', 1010, 'Tamatek Qir', 'Sedans', 198, 'Red', '2024', '03', '35', '1'),
('RRI3389', 1010, 'Tamatek Qir', 'SUV', 220, 'Black', '2024', '06', '65', '1'),
('RYU1023', 2020, 'Tamatek Qir', 'SUV', 230, 'light Blue', '2024', '01', '11', '1'),
('SDD2356', 2020, 'Tamatek Qir', 'Sedans', 250, 'Black', '2024', '05', '52', '1'),
('SDS2036', 2020, 'Tamatek Qir', 'Sports', 290, 'Dark blue', '2024', '03', '32', '1'),
('SSD9852', 1010, 'Tamatek Qir', 'Sports', 590, 'white', '2025', '01', '15', '1'),
('TBH2223', 1010, 'Tamatek Qir', 'Sports', 356, 'Grey', '2023', '04', '42', '1'),
('TYU3333', 1010, 'Tamatek Qir', 'SUV', 320, 'White', '2025', '02', '23', '1'),
('VBK3699', 2020, 'Ordinary Qir', 'SUV', 340, 'Dark blue', '2025', '03', '3', '1'),
('VVC3692', 1010, 'Tamatek Qir', 'SUV', 280, 'Black', '2024', '03', '34', '1'),
('VVM1203', 1010, 'Ordinary Qir', 'SUV', 260, 'Blue', '2024', '03', '37', '1'),
('WWW1000', 2020, 'Tamatek Qir', 'SUV', 360, 'white', '2024', '05', '53', '1'),
('ZXC1234', 1010, 'Tamatek Qir', 'Sedans', 200, 'Black', '2022', '01', '97', '1'),
('ZZX20', 2020, 'Tamatek Qir', 'Sports', 700, 'Blue', '2025', '05', '55', '1');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `carcompany`
--
ALTER TABLE `carcompany`
  ADD PRIMARY KEY (`ComCode`);

--
-- Indexes for table `carmanagment`
--
ALTER TABLE `carmanagment`
  ADD KEY `EID` (`EID`),
  ADD KEY `PlateNo` (`PlateNo`);

--
-- Indexes for table `carmodel`
--
ALTER TABLE `carmodel`
  ADD PRIMARY KEY (`MCode`),
  ADD KEY `ComCode` (`ComCode`);

--
-- Indexes for table `company`
--
ALTER TABLE `company`
  ADD PRIMARY KEY (`CompanyID`),
  ADD KEY `UsName` (`UsName`);

--
-- Indexes for table `contactus`
--
ALTER TABLE `contactus`
  ADD PRIMARY KEY (`CoNo`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`CID`),
  ADD KEY `UsName` (`UsName`);

--
-- Indexes for table `employee`
--
ALTER TABLE `employee`
  ADD PRIMARY KEY (`EID`),
  ADD KEY `mngID` (`mngID`),
  ADD KEY `UsName` (`UsName`);

--
-- Indexes for table `rent`
--
ALTER TABLE `rent`
  ADD PRIMARY KEY (`RentNo`),
  ADD KEY `EID` (`EID`),
  ADD KEY `CID` (`CID`),
  ADD KEY `PlateNo` (`PlateNo`,`CompanyID`),
  ADD KEY `CompanyID` (`CompanyID`,`PlateNo`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`UsName`);

--
-- Indexes for table `vehicle`
--
ALTER TABLE `vehicle`
  ADD PRIMARY KEY (`PlateNo`),
  ADD KEY `CompanyID` (`CompanyID`),
  ADD KEY `ComCode` (`ComCode`),
  ADD KEY `MCode` (`MCode`),
  ADD KEY `MCode_2` (`MCode`),
  ADD KEY `ComCode_2` (`ComCode`,`MCode`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `contactus`
--
ALTER TABLE `contactus`
  MODIFY `CoNo` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `rent`
--
ALTER TABLE `rent`
  MODIFY `RentNo` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `carmanagment`
--
ALTER TABLE `carmanagment`
  ADD CONSTRAINT `carmanagment_ibfk_1` FOREIGN KEY (`EID`) REFERENCES `employee` (`EID`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `carmanagment_ibfk_2` FOREIGN KEY (`PlateNo`) REFERENCES `vehicle` (`PlateNo`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `carmodel`
--
ALTER TABLE `carmodel`
  ADD CONSTRAINT `carmodel_ibfk_1` FOREIGN KEY (`ComCode`) REFERENCES `carcompany` (`ComCode`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `company`
--
ALTER TABLE `company`
  ADD CONSTRAINT `company_ibfk_1` FOREIGN KEY (`UsName`) REFERENCES `users` (`UsName`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `customer`
--
ALTER TABLE `customer`
  ADD CONSTRAINT `customer_ibfk_1` FOREIGN KEY (`UsName`) REFERENCES `users` (`UsName`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `employee`
--
ALTER TABLE `employee`
  ADD CONSTRAINT `employee_ibfk_1` FOREIGN KEY (`mngID`) REFERENCES `employee` (`EID`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `employee_ibfk_2` FOREIGN KEY (`UsName`) REFERENCES `users` (`UsName`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `rent`
--
ALTER TABLE `rent`
  ADD CONSTRAINT `rent_ibfk_1` FOREIGN KEY (`CID`) REFERENCES `customer` (`CID`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `rent_ibfk_2` FOREIGN KEY (`CompanyID`,`PlateNo`) REFERENCES `vehicle` (`CompanyID`, `PlateNo`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `rent_ibfk_3` FOREIGN KEY (`EID`) REFERENCES `employee` (`EID`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `vehicle`
--
ALTER TABLE `vehicle`
  ADD CONSTRAINT `vehicle_ibfk_1` FOREIGN KEY (`CompanyID`) REFERENCES `company` (`CompanyID`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `vehicle_ibfk_2` FOREIGN KEY (`ComCode`,`MCode`) REFERENCES `carmodel` (`ComCode`, `MCode`) ON DELETE RESTRICT ON UPDATE RESTRICT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
