-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jan 24, 2023 at 01:45 AM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.1.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `callappdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `calls`
--

CREATE TABLE `calls` (
  `id` int(11) NOT NULL,
  `unique_id` int(11) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp(),
  `itperson` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `subject` varchar(100) NOT NULL,
  `details` text NOT NULL,
  `total_time` varchar(10) NOT NULL,
  `status` varchar(10) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `calls`
--

INSERT INTO `calls` (`id`, `unique_id`, `date`, `itperson`, `username`, `subject`, `details`, `total_time`, `status`) VALUES
(1, 1, '2023-01-23 13:33:18', 'Person One ', 'Sam', 'Test', 'Test', '04:04', 'New');

-- --------------------------------------------------------

--
-- Table structure for table `call_details`
--

CREATE TABLE `call_details` (
  `id` int(11) NOT NULL,
  `call_id` int(11) NOT NULL,
  `datetime` datetime NOT NULL,
  `details` text NOT NULL,
  `hours` varchar(10) NOT NULL,
  `minutes` varchar(10) NOT NULL,
  `meridian` varchar(5) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `call_details`
--

INSERT INTO `call_details` (`id`, `call_id`, `datetime`, `details`, `hours`, `minutes`, `meridian`) VALUES
(1, 1, '2023-01-23 23:33:00', 'Test', '1', '40', 'AM'),
(3, 1, '2023-01-18 23:34:00', 'Test 2', '2', '24', 'AM');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `calls`
--
ALTER TABLE `calls`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `call_details`
--
ALTER TABLE `call_details`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `calls`
--
ALTER TABLE `calls`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `call_details`
--
ALTER TABLE `call_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
