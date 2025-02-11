-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3308
-- Generation Time: Feb 11, 2025 at 06:38 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

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
-- Table structure for table `services`
--

CREATE TABLE `services` (
  `id` int(11) NOT NULL,
  `service_name` varchar(255) NOT NULL,
  `number_of_seats` int(11) NOT NULL,
  `base_fare` decimal(10,2) NOT NULL,
  `minimum_fare` decimal(10,2) NOT NULL,
  `booking_fee` decimal(10,2) NOT NULL,
  `tax_percentage` decimal(5,2) NOT NULL,
  `price_per_minute` decimal(10,2) NOT NULL,
  `price_per_mile_km` decimal(10,2) NOT NULL,
  `mileage` enum('Yes','No') NOT NULL,
  `daily_service` enum('Yes','No') NOT NULL,
  `outstation_service` enum('Yes','No') NOT NULL,
  `rental_service` enum('Yes','No') NOT NULL,
  `provider_commission` decimal(5,2) NOT NULL,
  `admin_commission` decimal(5,2) NOT NULL,
  `driver_cash_limit` decimal(10,2) NOT NULL,
  `service_picture` varchar(255) NOT NULL,
  `created_on` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`id`, `service_name`, `number_of_seats`, `base_fare`, `minimum_fare`, `booking_fee`, `tax_percentage`, `price_per_minute`, `price_per_mile_km`, `mileage`, `daily_service`, `outstation_service`, `rental_service`, `provider_commission`, `admin_commission`, `driver_cash_limit`, `service_picture`, `created_on`) VALUES
(12, 'mini', 4, 2.00, 3.00, 10.00, 5.00, 12.00, 20.00, 'Yes', 'Yes', 'No', 'Yes', 15.00, 20.00, 4000.00, 'car2.jpg', '2025-02-08 11:06:05'),
(14, 'Swift', 4, 2.00, 3.00, 6.00, 5.00, 10.00, 25.00, 'Yes', 'No', 'Yes', 'No', 22.00, 33.00, 5000.00, 'car1.png', '2025-02-08 11:53:24'),
(17, 'Swift', 5, 2.00, 2.00, 22.00, 5.00, 6.00, 7.00, 'Yes', 'Yes', 'Yes', 'No', 22.00, 33.00, 2900.00, 'car2.jpg', '2025-02-08 14:58:24');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
