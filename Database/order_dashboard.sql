-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 13, 2025 at 01:40 PM
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
-- Database: `admin_panel`
--

-- --------------------------------------------------------

--
-- Table structure for table `order_dashboard`
--

CREATE TABLE `order_dashboard` (
  `id` int(11) NOT NULL,
  `total_bookings` int(11) DEFAULT 0,
  `yearly_bookings` int(11) DEFAULT 0,
  `monthly_bookings` int(11) DEFAULT 0,
  `daily_bookings` int(11) DEFAULT 0,
  `total_requests` int(11) DEFAULT 0,
  `yearly_requests` int(11) DEFAULT 0,
  `monthly_requests` int(11) DEFAULT 0,
  `daily_requests` int(11) DEFAULT 0,
  `total_ongoing_rides` int(11) DEFAULT 0,
  `yearly_ongoing_rides` int(11) DEFAULT 0,
  `monthly_ongoing_rides` int(11) DEFAULT 0,
  `daily_ongoing_rides` int(11) DEFAULT 0,
  `total_completed_rides` int(11) DEFAULT 0,
  `yearly_completed_rides` int(11) DEFAULT 0,
  `monthly_completed_rides` int(11) DEFAULT 0,
  `daily_completed_rides` int(11) DEFAULT 0,
  `total_canceled_rides` int(11) DEFAULT 0,
  `yearly_canceled_rides` int(11) DEFAULT 0,
  `monthly_canceled_rides` int(11) DEFAULT 0,
  `daily_canceled_rides` int(11) DEFAULT 0,
  `total_rental_rides` int(11) DEFAULT 0,
  `yearly_rental_rides` int(11) DEFAULT 0,
  `monthly_rental_rides` int(11) DEFAULT 0,
  `daily_rental_rides` int(11) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_dashboard`
--

INSERT INTO `order_dashboard` (`id`, `total_bookings`, `yearly_bookings`, `monthly_bookings`, `daily_bookings`, `total_requests`, `yearly_requests`, `monthly_requests`, `daily_requests`, `total_ongoing_rides`, `yearly_ongoing_rides`, `monthly_ongoing_rides`, `daily_ongoing_rides`, `total_completed_rides`, `yearly_completed_rides`, `monthly_completed_rides`, `daily_completed_rides`, `total_canceled_rides`, `yearly_canceled_rides`, `monthly_canceled_rides`, `daily_canceled_rides`, `total_rental_rides`, `yearly_rental_rides`, `monthly_rental_rides`, `daily_rental_rides`, `created_at`) VALUES
(1, 745, 123, 745621, 4567, 7456, 0, 74, 0, 123, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2025-02-10 18:23:59');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `order_dashboard`
--
ALTER TABLE `order_dashboard`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `order_dashboard`
--
ALTER TABLE `order_dashboard`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
