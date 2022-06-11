-- phpMyAdmin SQL Dump
-- version 4.9.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 11, 2022 at 10:59 AM
-- Server version: 10.5.12-MariaDB
-- PHP Version: 7.3.32

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `id19087684_incomeexpense`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbleincome`
--

CREATE TABLE `tbleincome` (
  `ID` int(10) NOT NULL,
  `UserId` int(10) DEFAULT NULL,
  `IncomeDate` date NOT NULL,
  `IncomeAmount` varchar(200) CHARACTER SET latin1 NOT NULL,
  `Remark` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `Type_Income` varchar(20) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tbleincome`
--

INSERT INTO `tbleincome` (`ID`, `UserId`, `IncomeDate`, `IncomeAmount`, `Remark`, `Type_Income`) VALUES
(1, 11, '2022-06-09', '45', 'sdsadasd', 'StockMarket');

-- --------------------------------------------------------

--
-- Table structure for table `tblexpense`
--

CREATE TABLE `tblexpense` (
  `ID` int(10) NOT NULL,
  `UserId` int(10) NOT NULL,
  `ExpenseDate` date DEFAULT NULL,
  `ExpenseItem` varchar(200) DEFAULT NULL,
  `ExpenseCost` varchar(200) DEFAULT NULL,
  `Type_Expense` varchar(20) DEFAULT NULL,
  `NoteDate` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tblexpense`
--

INSERT INTO `tblexpense` (`ID`, `UserId`, `ExpenseDate`, `ExpenseItem`, `ExpenseCost`, `Type_Expense`, `NoteDate`) VALUES
(36, 11, '2022-06-08', 'vv', '22', 'Food', '2022-06-11 10:28:34'),
(37, 11, '2022-06-12', 'dsd', '222', 'Electronics', '2022-06-11 10:44:16');

-- --------------------------------------------------------

--
-- Table structure for table `tbluser`
--

CREATE TABLE `tbluser` (
  `ID` int(10) NOT NULL,
  `FullName` varchar(150) DEFAULT NULL,
  `Email` varchar(200) DEFAULT NULL,
  `MobileNumber` bigint(10) DEFAULT NULL,
  `Password` varchar(200) DEFAULT NULL,
  `RegDate` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbluser`
--

INSERT INTO `tbluser` (`ID`, `FullName`, `Email`, `MobileNumber`, `Password`, `RegDate`) VALUES
(1, 'Rajeshwari', 'raj@gmail.com', 5655555655, '202cb962ac59075b964b07152d234b70', '2019-05-15 08:52:27'),
(2, 'Meenakhi', 'meena@gmail.com', 8989898897, '81dc9bdb52d04dc20036dbd8313ed055', '2019-05-15 08:52:27'),
(3, 'Khusbu', 'khusi@gmail.com', 5645798897, '202cb962ac59075b964b07152d234b70', '2019-05-15 08:52:27'),
(4, 'Shantanu Bhardwaj', 'shan@gmail.com', 7895641236, '202cb962ac59075b964b07152d234b70', '2019-05-17 05:13:23'),
(8, 'Test', 'test@gmail.com', 5656556565, '202cb962ac59075b964b07152d234b70', '2019-05-17 05:34:16'),
(9, 'Anuj kumar', 'phpgurukulofficial@gmail.com', 1234567890, 'f925916e2754e5e03f75dd58a5733251', '2019-05-18 05:31:47'),
(10, 'Test User demo', 'testuser@gmail.com', 987654321, 'f925916e2754e5e03f75dd58a5733251', '2019-05-18 05:34:53'),
(11, 'Smit', 'ssp9102000@gmail.com', 9898091616, '4560337fa04b2ab904e50a5416c75bde', '2022-06-11 10:18:05');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbleincome`
--
ALTER TABLE `tbleincome`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `tblexpense`
--
ALTER TABLE `tblexpense`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `tbluser`
--
ALTER TABLE `tbluser`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbleincome`
--
ALTER TABLE `tbleincome`
  MODIFY `ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tblexpense`
--
ALTER TABLE `tblexpense`
  MODIFY `ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `tbluser`
--
ALTER TABLE `tbluser`
  MODIFY `ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
