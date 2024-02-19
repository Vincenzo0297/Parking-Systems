-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Feb 19, 2024 at 07:43 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dbparkingsystem`
--

-- --------------------------------------------------------

--
-- Table structure for table `locations`
--

CREATE TABLE `locations` (
  `LocationID` int(11) NOT NULL,
  `LocationName` varchar(100) NOT NULL,
  `DescriptionLocation` varchar(100) NOT NULL,
  `Capacity` int(11) NOT NULL,
  `ParkingSpace` int(11) NOT NULL,
  `CostPerHr` double NOT NULL,
  `LateCost` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `locations`
--

INSERT INTO `locations` (`LocationID`, `LocationName`, `DescriptionLocation`, `Capacity`, `ParkingSpace`, `CostPerHr`, `LateCost`) VALUES
(22, 'Tampines', 'West is a good place to start', 2, 50, 1.4, 3.4),
(23, 'bedok', 'bedok is beautiful', 1, 2, 12, 42),
(24, 'PEETOWN', 'lolyou', 1, 12, 32, 12),
(25, 'Yankee', 'fff', 1, 32, 32, 32);

-- --------------------------------------------------------

--
-- Table structure for table `systems`
--

CREATE TABLE `systems` (
  `SystemID` int(11) NOT NULL,
  `Date` date NOT NULL,
  `StartHour` int(2) NOT NULL,
  `StartMinutes` int(11) NOT NULL,
  `ExpectedEndHour` int(11) NOT NULL,
  `ExpectedEndMinutes` int(11) NOT NULL,
  `EndHour` int(11) NOT NULL,
  `EndMinutes` int(11) NOT NULL,
  `Duration` int(11) NOT NULL,
  `TotalCost` double NOT NULL,
  `userID` int(11) NOT NULL,
  `LocationID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `systems`
--

INSERT INTO `systems` (`SystemID`, `Date`, `StartHour`, `StartMinutes`, `ExpectedEndHour`, `ExpectedEndMinutes`, `EndHour`, `EndMinutes`, `Duration`, `TotalCost`, `userID`, `LocationID`) VALUES
(35, '2024-02-19', 15, 9, 23, 9, 15, 5, 8, 89.6, 16, 22),
(36, '2024-02-20', 13, 10, 26, 10, 1, 32, 13, 2028, 17, 23),
(37, '2024-02-21', 15, 10, 27, 10, 10, 5, 12, 1728, 16, 23),
(38, '2024-02-21', 10, 4, 14, 4, 10, 6, 4, 22.4, 16, 22),
(39, '2024-02-20', 8, 7, 14, 7, 17, 23, 6, 22, 16, 22),
(40, '2024-02-22', 10, 32, 44, 32, 1, 54, 34, 1618.4, 16, 22),
(41, '2024-02-28', 10, 3, 14, 3, 8, 43, 4, 22.4, 17, 22),
(42, '2024-02-21', 1, 43, 34, 43, 1, 43, 33, 1524.6, 16, 22),
(43, '2024-02-21', 8, 4, 14, 4, 12, 34, 6, 50.4, 16, 22),
(44, '2024-02-28', 13, 4, 18, 4, 1, 54, 5, 35, 16, 22),
(45, '2024-02-21', 12, 54, 46, 54, 11, 43, 34, 1618.4, 16, 22),
(46, '2024-02-20', 11, 43, 34, 43, 7, 3, 23, 740.6, 16, 22),
(47, '2024-02-22', 12, 5, 17, 5, 10, 32, 5, 35, 16, 22),
(48, '2024-02-21', 8, 32, 31, 32, 0, 0, 23, 0, 15, 22),
(49, '2024-02-14', 1, 32, 33, 32, 0, 0, 32, 0, 15, 23),
(50, '2024-02-21', 8, 3, 12, 3, 0, 0, 4, 0, 15, 24),
(51, '2024-02-22', 8, 3, 12, 3, 0, 0, 4, 0, 0, 25),
(52, '2024-02-20', 1, 32, 33, 32, 1, 32, 32, 6.8, 16, 22),
(53, '2024-02-21', 1, 32, 33, 32, 1, 22, 32, 0, 16, 23),
(54, '2024-02-28', 1, 32, 33, 32, 1, 4, 32, 24, 16, 24),
(55, '2024-02-13', 1, 32, 33, 32, 1, 43, 32, 0, 16, 22),
(56, '2024-02-14', 8, 43, 51, 43, 1, 32, 43, 0, 16, 25),
(57, '2024-02-22', 1, 43, 44, 43, 0, 0, 43, 0, 16, 0),
(58, '2024-02-28', 10, 32, 53, 32, 14, 54, 43, 0, 16, 23),
(59, '2024-02-28', 10, 43, 53, 43, 12, 4, 43, 156, 16, 24),
(60, '2024-02-14', 9, 5, 14, 5, 13, 7, 5, 588, 16, 23),
(61, '2024-02-29', 9, 4, 14, 4, 15, 7, 5, 0, 17, 23),
(62, '2024-02-28', 7, 43, 50, 43, 19, 43, 43, 640, 17, 25),
(63, '2024-02-29', 10, 5, 15, 5, 14, 5, 5, 480, 17, 25),
(64, '2024-02-22', 11, 5, 17, 5, 8, 6, 6, 288, 17, 25),
(65, '2024-02-21', 1, 43, 44, 43, 1, 23, 43, 24, 17, 24),
(66, '2024-02-14', 9, 43, 32, 43, 14, 12, 23, 630, 17, 23),
(67, '2024-02-21', 10, 4, 13, 4, 12, 4, 3, 0, 16, 24),
(68, '2024-02-22', 8, 43, 20, 43, 10, 5, 12, 37.4, 16, 22),
(69, '2024-02-29', 10, 43, 22, 43, 14, 20, 12, 0, 17, 23),
(70, '2024-02-29', 10, 5, 15, 5, 12, 43, 5, 156, 17, 24),
(71, '2024-02-21', 8, 32, 31, 32, 15, 52, 23, 740.6, 16, 22),
(72, '2024-02-14', 8, 43, 31, 43, 17, 42, 23, 6348, 16, 23),
(73, '2024-02-22', 10, 32, 33, 32, 20, 17, 23, 0, 17, 23),
(74, '2024-02-22', 1, 23, 55, 23, 18, 43, 54, 34992, 17, 23),
(75, '2024-02-22', 9, 43, 13, 43, 17, 42, 4, 192, 17, 23),
(76, '2024-02-22', 10, 32, 33, 32, 19, 43, 23, 6348, 16, 23),
(77, '2024-02-29', 11, 32, 34, 32, 17, 53, 23, 0, 16, 23),
(78, '2024-02-21', 9, 32, 32, 32, 11, 6, 23, 740.6, 0, 22),
(79, '2024-02-21', 9, 4, 12, 4, 0, 0, 3, 0, 16, 22);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `userID` int(11) NOT NULL,
  `userName` varchar(100) NOT NULL,
  `userSurname` varchar(100) NOT NULL,
  `userPassword` varchar(20) NOT NULL,
  `userNumber` int(20) NOT NULL,
  `userEmail` varchar(100) NOT NULL,
  `userRole` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`userID`, `userName`, `userSurname`, `userPassword`, `userNumber`, `userEmail`, `userRole`) VALUES
(15, 'vincent', 'ong', 'vincent123', 962059210, 'vincent@gmail.com', 'admin'),
(16, 'Barack', 'Obama', 'obama123', 987654321, 'osama89@gmail.com', 'user'),
(17, 'Osama', 'labin', 'obsama123', 543216789, 'osama89@gmail.com', 'user');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `locations`
--
ALTER TABLE `locations`
  ADD PRIMARY KEY (`LocationID`);

--
-- Indexes for table `systems`
--
ALTER TABLE `systems`
  ADD PRIMARY KEY (`SystemID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`userID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `locations`
--
ALTER TABLE `locations`
  MODIFY `LocationID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `systems`
--
ALTER TABLE `systems`
  MODIFY `SystemID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=80;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `userID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
