-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 11, 2025 at 05:43 AM
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
-- Table structure for table `new_vehicles`
--

CREATE TABLE `new_vehicles` (
  `id` int(11) NOT NULL,
  `vehicle_name` varchar(100) NOT NULL,
  `vehicle_type` enum('Bike','Three-wheeler','Car','Pickup','Truck','Other') NOT NULL,
  `vehicle_number` varchar(50) NOT NULL,
  `vehicle_model` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `new_vehicles`
--

INSERT INTO `new_vehicles` (`id`, `vehicle_name`, `vehicle_type`, `vehicle_number`, `vehicle_model`, `created_at`) VALUES
(1, 'Passion Plus', 'Bike', 'MH 12 AB 1234', '2018', '2025-02-06 17:11:23'),
(2, 'Creta', 'Car', 'MH 15 AB 5433', '2017', '2025-02-06 17:25:56'),
(7, 'Swift', 'Car', 'MH 43 AV 5421', '2015', '2025-02-06 17:37:20'),
(9, 'Pulsar 220', 'Bike', 'MH 04 AD 6521', '2021', '2025-02-06 17:39:09'),
(11, 'G-Wagon', 'Car', 'MH 15 AD 5634', '2022', '2025-02-06 17:54:55'),
(20, 'Omni', 'Car', 'MH 18 AS 2354', '2025', '2025-02-06 18:20:29'),
(22, 'Apache RTR 160 4V', 'Bike', 'MH 15 AD 6532', '2022', '2025-02-06 18:22:18'),
(31, 'Honda Shine SP', 'Bike', 'MH 04 AD 9829', '2023', '2025-02-06 18:45:42'),
(38, 'Bajaj RX 100', 'Bike', 'MH 43 AV 5422', '2018', '2025-02-07 07:59:36'),
(40, 'Kia Seltos', 'Car', 'MH 18 DZ 1234', '20218', '2025-02-07 10:00:01');

-- --------------------------------------------------------

--
-- Table structure for table `partners`
--

CREATE TABLE `partners` (
  `id` int(11) NOT NULL,
  `partner_name` varchar(255) NOT NULL,
  `mobile_no` varchar(15) NOT NULL,
  `email_id` varchar(255) NOT NULL,
  `partner_type` enum('Full Time','Part Time') NOT NULL,
  `daily_services` enum('yes','no') NOT NULL,
  `account_no` varchar(50) NOT NULL,
  `bank_name` varchar(255) NOT NULL,
  `gender` enum('Male','Female','Other','No Share') NOT NULL,
  `address` text NOT NULL,
  `outstation_services` enum('yes','no') NOT NULL,
  `upi_id` varchar(255) NOT NULL,
  `ifsc_code` varchar(20) NOT NULL,
  `password` varchar(255) NOT NULL,
  `salary_type` enum('Monthly','Daily') NOT NULL,
  `salary` decimal(10,2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `partners`
--

INSERT INTO `partners` (`id`, `partner_name`, `mobile_no`, `email_id`, `partner_type`, `daily_services`, `account_no`, `bank_name`, `gender`, `address`, `outstation_services`, `upi_id`, `ifsc_code`, `password`, `salary_type`, `salary`, `created_at`) VALUES
(28, 'Rahul Barhate', '8754347687', 'barhaterahul454@gmail.com', 'Part Time', 'no', '123456789012', 'Bank of Baroda', 'Male', 'Jalgaon, Maharashtra', 'yes', 'KJHGFDSA54321', 'FDSA432', 'Rahul@123', 'Monthly', '1211.00', '2025-02-09 15:49:43'),
(29, 'Manish Sonawane', '9322897948', 'manishsonawane3010@gmail.com', 'Full Time', 'yes', '98765432121', 'HDFC Bank', 'Male', 'Room No 103, B-wing, Ganga Plaza', 'yes', 'ASDFGHJK1234AS', 'FDSA432', 'Manish%123&', 'Monthly', '2134.00', '2025-02-09 17:09:27');

-- --------------------------------------------------------

--
-- Table structure for table `vehicles`
--

CREATE TABLE `vehicles` (
  `id` int(11) NOT NULL,
  `vehicle_name` varchar(255) NOT NULL,
  `vehicle_model` varchar(255) NOT NULL,
  `vehicle_number` varchar(50) NOT NULL,
  `driver_name` varchar(255) NOT NULL,
  `driver_mobile_number` varchar(15) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `vehicles`
--

INSERT INTO `vehicles` (`id`, `vehicle_name`, `vehicle_model`, `vehicle_number`, `driver_name`, `driver_mobile_number`, `created_at`) VALUES
(1, 'Apache RTR 160 4V', '2022', 'MH 15 AD 6532', 'Manish Sonawane', '9322897948', '2025-02-07 09:59:10'),
(2, 'Kia Seltos', '2018', 'MH 18 DZ 1234', 'Shashikant Shirsath', '3456789212', '2025-02-07 10:01:13'),
(4, 'Passion Plus', '2018', 'MH 12 AB 1234', 'Harshal Mutdak', '7540923287', '2025-02-07 10:31:54');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `new_vehicles`
--
ALTER TABLE `new_vehicles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `vehicle_number` (`vehicle_number`);

--
-- Indexes for table `partners`
--
ALTER TABLE `partners`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vehicles`
--
ALTER TABLE `vehicles`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `new_vehicles`
--
ALTER TABLE `new_vehicles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `partners`
--
ALTER TABLE `partners`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `vehicles`
--
ALTER TABLE `vehicles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
