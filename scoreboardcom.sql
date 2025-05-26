-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 26, 2025 at 10:49 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `scoreboardcom`
--

-- --------------------------------------------------------

--
-- Table structure for table `judges`
--

CREATE TABLE `judges` (
  `id` int(11) NOT NULL,
  `judge_name` varchar(50) NOT NULL,
  `unique_ID` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `judges`
--

INSERT INTO `judges` (`id`, `judge_name`, `unique_ID`) VALUES
(13, 'Ian Musila', 'JN004'),
(14, 'Baraka Simiyu', 'HY4t7'),
(15, 'Davis Johnsons', 'JN67');

-- --------------------------------------------------------

--
-- Table structure for table `players`
--

CREATE TABLE `players` (
  `id` int(50) NOT NULL,
  `player_name` varchar(20) NOT NULL,
  `player_ID` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `players`
--

INSERT INTO `players` (`id`, `player_name`, `player_ID`) VALUES
(3, 'Garfield Kamau', 'PN130867'),
(4, 'Nimrod Nick', 'PN582016'),
(5, 'Daniella Ngeti', 'PN413113'),
(6, 'Chris Kamau', 'PN593234'),
(7, 'Ivy Precious', 'PN805258'),
(8, 'Brian Maina', 'PN532619'),
(9, 'Winnie Otieno', 'PN401028');

-- --------------------------------------------------------

--
-- Table structure for table `scores`
--

CREATE TABLE `scores` (
  `id` int(50) NOT NULL,
  `judge_id` int(50) NOT NULL,
  `player_id` int(50) NOT NULL,
  `score` int(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `scores`
--

INSERT INTO `scores` (`id`, `judge_id`, `player_id`, `score`) VALUES
(3, 13, 3, 568),
(4, 14, 3, 234),
(5, 14, 4, 237),
(6, 13, 4, 350),
(7, 15, 3, 100),
(8, 15, 4, 400),
(9, 15, 5, 600),
(10, 15, 6, 570),
(11, 15, 7, 500),
(12, 14, 5, 750),
(13, 14, 6, 850),
(14, 14, 7, 700),
(15, 13, 5, 450),
(16, 13, 6, 500),
(17, 13, 7, 700),
(18, 13, 8, 350),
(19, 14, 8, 500),
(20, 15, 8, 700),
(21, 13, 9, 400),
(22, 15, 9, 450),
(23, 14, 9, 730);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `judges`
--
ALTER TABLE `judges`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `players`
--
ALTER TABLE `players`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `scores`
--
ALTER TABLE `scores`
  ADD PRIMARY KEY (`id`),
  ADD KEY `judge's_id` (`judge_id`),
  ADD KEY `player_id` (`player_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `judges`
--
ALTER TABLE `judges`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `players`
--
ALTER TABLE `players`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `scores`
--
ALTER TABLE `scores`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `scores`
--
ALTER TABLE `scores`
  ADD CONSTRAINT `scores_ibfk_1` FOREIGN KEY (`judge_id`) REFERENCES `judges` (`id`),
  ADD CONSTRAINT `scores_ibfk_2` FOREIGN KEY (`player_id`) REFERENCES `players` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
