-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 12, 2020 at 05:27 PM
-- Server version: 10.1.29-MariaDB
-- PHP Version: 7.1.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `layhospital`
--

-- --------------------------------------------------------

--
-- Table structure for table `channel`
--

CREATE TABLE `channel` (
  `chno` int(11) NOT NULL,
  `docno` int(11) NOT NULL,
  `pno` int(11) NOT NULL,
  `rno` int(11) NOT NULL,
  `date` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `channel`
--

INSERT INTO `channel` (`chno`, `docno`, `pno`, `rno`, `date`) VALUES
(1, 1, 3, 1, '2019-09-05'),
(2, 2, 1, 2, '2019-09-05'),
(3, 2, 4, 4, '2019-09-05');

-- --------------------------------------------------------

--
-- Table structure for table `doctor`
--

CREATE TABLE `doctor` (
  `doctorno` int(11) NOT NULL,
  `dname` varchar(255) NOT NULL,
  `special` varchar(255) NOT NULL,
  `qual` varchar(255) NOT NULL,
  `fee` int(11) NOT NULL,
  `phone` int(11) NOT NULL,
  `room` int(11) NOT NULL,
  `log_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `doctor`
--

INSERT INTO `doctor` (`doctorno`, `dname`, `special`, `qual`, `fee`, `phone`, `room`, `log_id`) VALUES
(0, 's', 'dsf', 'sd', 444, 3222, 1, 11),
(1, 'James', 'werw', 'MBBS', 12000, 435345, 2, 6),
(2, 'Anne d', 'sdfdsf', 'MBBS', 15000, 2324234, 1, 7),
(3, 'Ragu', 'sdf', 'sdf', 2300, 2323, 2, 10);

-- --------------------------------------------------------

--
-- Table structure for table `item`
--

CREATE TABLE `item` (
  `id` int(11) NOT NULL,
  `itemname` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `sellprice` int(11) NOT NULL,
  `buyprice` int(11) NOT NULL,
  `qty` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `item`
--

INSERT INTO `item` (`id`, `itemname`, `description`, `sellprice`, `buyprice`, `qty`) VALUES
(0, 'asd', 'sdfsd', 4, 5, 3),
(1, 'Panadol', 'sdsfsdf', 10, 8, 1000),
(2, 'Pddd', 'dsfsdf', 20, 10, 500);

-- --------------------------------------------------------

--
-- Table structure for table `patient`
--

CREATE TABLE `patient` (
  `patientno` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `phone` int(11) NOT NULL,
  `address` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `prescription`
--

CREATE TABLE `prescription` (
  `pid` int(11) NOT NULL,
  `cno` int(11) NOT NULL,
  `dtype` varchar(255) NOT NULL,
  `des` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `prescription`
--

INSERT INTO `prescription` (`pid`, `cno`, `dtype`, `des`) VALUES
(1, 1, 'Fever', 'Panadol dfdsf dsfsdffffffffffffff sddsdfsdf sfdsfsdf'),
(2, 3, 'dfd', 'sdsd');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` varchar(255) NOT NULL,
  `fullname` varchar(255) NOT NULL,
  `uname` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `utype` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `fullname`, `uname`, `password`, `utype`) VALUES
('10', 'Ragu', 'ragu', '123', 2),
('11', 'nira', 'nira', '123', 2),
('4', 'JohnPeter', 'john', '123', 1),
('5', 'Kumar', 'kumar', '202cb962ac59075b964b07152d234b70', 3),
('6', 'James', 'james', '202cb962ac59075b964b07152d234b70', 2),
('7', 'Anne', 'anne', '202cb962ac59075b964b07152d234b70', 2),
('8', 'Kishan', 'kishan', '202cb962ac59075b964b07152d234b70', 2),
('9', 'd', 'dd', '202cb962ac59075b964b07152d234b70', 2);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `channel`
--
ALTER TABLE `channel`
  ADD PRIMARY KEY (`chno`);

--
-- Indexes for table `doctor`
--
ALTER TABLE `doctor`
  ADD PRIMARY KEY (`doctorno`);

--
-- Indexes for table `item`
--
ALTER TABLE `item`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `patient`
--
ALTER TABLE `patient`
  ADD PRIMARY KEY (`patientno`);

--
-- Indexes for table `prescription`
--
ALTER TABLE `prescription`
  ADD PRIMARY KEY (`pid`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
