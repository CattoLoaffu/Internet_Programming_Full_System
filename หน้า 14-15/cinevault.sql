-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Feb 10, 2023 at 11:07 AM
-- Server version: 8.0.17
-- PHP Version: 7.3.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cinevault`
--

-- --------------------------------------------------------

--
-- Table structure for table `movie`
--

CREATE TABLE `movie` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `copyright cost` int(11) NOT NULL,
  `sale` int(11) NOT NULL,
  `profit` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `movie`
--

INSERT INTO `movie` (`id`, `name`, `copyright cost`, `sale`, `profit`) VALUES
(1, 'Avatar : The Way of Water', 10000000, 50000000, 40000000),
(2, 'Top Gun: Maverick', 10000000, 70000000, 60000000),
(3, 'Jurassic World : Dominion', 10000000, 40000000, 30000000),
(4, 'Doctor Strange in the Multiverse \r\nof Madness', 10000000, 35000000, 25000000),
(5, 'Minions : The Rise of Gru', 5000000, 20000000, 15000000);

-- --------------------------------------------------------

--
-- Table structure for table `topsale`
--

CREATE TABLE `topsale` (
  `date` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `standdart` varchar(255) NOT NULL,
  `sofa Sweet` varchar(255) NOT NULL,
  `total number of seats` varchar(255) NOT NULL,
  `profit` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `topsale`
--

INSERT INTO `topsale` (`date`, `name`, `standdart`, `sofa Sweet`, `total number of seats`, `profit`) VALUES
('05042566', 'Top Gun: Maverick', '200', '20', '220', '1200000');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `movie`
--
ALTER TABLE `movie`
  ADD PRIMARY KEY (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
