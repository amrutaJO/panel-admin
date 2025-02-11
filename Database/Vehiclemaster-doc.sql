-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 11, 2025 at 06:43 AM
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
-- Database: `admin_panel`
--

-- --------------------------------------------------------

--
-- Table structure for table `document_types`
--

CREATE TABLE `document_types` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `preview_image` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `status` enum('active','declined') DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `document_types`
--

INSERT INTO `document_types` (`id`, `name`, `preview_image`, `description`, `created_at`, `status`) VALUES
(12, 'bike', 'Nature.jpg', 'this is my bike', '2025-02-06 18:15:55', 'declined'),
(15, 'signature', 'Signature.jpg', 'This is my updated signature!', '2025-02-07 10:43:29', 'active'),
(16, 'bonafite certificate', 'Bona.jpg', 'this is my mca bonafite', '2025-02-07 13:26:33', 'declined');

-- --------------------------------------------------------

--
-- Table structure for table `vehicle_master`
--

CREATE TABLE `vehicle_master` (
  `id` int(11) NOT NULL,
  `manufacturer_name` varchar(100) NOT NULL,
  `color` varchar(50) NOT NULL,
  `model_name` varchar(100) NOT NULL,
  `manufacturing_year` year(4) NOT NULL,
  `seat_arrangement` varchar(50) NOT NULL,
  `status` varchar(20) DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `vehicle_master`
--

INSERT INTO `vehicle_master` (`id`, `manufacturer_name`, `color`, `model_name`, `manufacturing_year`, `seat_arrangement`, `status`) VALUES
(2, 'Honda', 'Blue', 'Sivic', 2024, '3', 'active'),
(3, 'Hero Honda', 'light blue', 'Sivic 0.1', 2024, '3', 'active'),
(6, 'Hero 12', 'Black', '!m_4', 2024, '2', 'active'),
(11, 'Hundai ', 'Red', 'silicon 0.4', 2002, '4', 'declined');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `document_types`
--
ALTER TABLE `document_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vehicle_master`
--
ALTER TABLE `vehicle_master`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `document_types`
--
ALTER TABLE `document_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `vehicle_master`
--
ALTER TABLE `vehicle_master`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
