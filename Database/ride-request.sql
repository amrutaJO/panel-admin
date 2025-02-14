-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 14, 2025 at 09:01 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

CREATE TABLE `ride_request` (
  `id` int(11) NOT NULL,
  `user` varchar(255) NOT NULL,
  `pickup_address` varchar(255) NOT NULL,
  `drop_address` varchar(255) NOT NULL,
  `time` datetime NOT NULL,
  `type` varchar(100) NOT NULL,
  `status` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ride_request`
--

INSERT INTO `ride_request` (`id`, `user`, `pickup_address`, `drop_address`, `time`, `type`, `status`) VALUES
(2, 'John Doe', 'Location A', 'Location B', '0000-00-00 00:00:00', 'History', 'Completed'),
(3, 'Jane Smith', 'Location C', 'Location D', '0000-00-00 00:00:00', 'Todays Ride', 'Ongoing'),
(4, 'Alex Johnson', 'Location E', 'Location F', '0000-00-00 00:00:00', 'Canceled', 'Canceled'),
(5, 'Emily Davis', 'Location G', 'Location H', '0000-00-00 00:00:00', 'Scheduled', 'Scheduled'),
(6, 'Michael Brown', 'Location I', 'Location J', '0000-00-00 00:00:00', 'Daily Ride', 'Completed'),
(7, 'Sarah Wilson', 'Location K', 'Location L', '0000-00-00 00:00:00', 'Rental Ride', 'Pending'),
(8, 'David Lee', 'Location M', 'Location N', '0000-00-00 00:00:00', 'On-Demand Ride', 'Ongoing'),
(9, 'Olivia Taylor', 'Location O', 'Location P', '0000-00-00 00:00:00', 'Outstation Ride', 'Completed'),
(10, 'James Anderson', 'Location Q', 'Location R', '0000-00-00 00:00:00', 'History', 'Completed'),
(11, 'Emma White', 'Location S', 'Location T', '0000-00-00 00:00:00', 'Todays Ride', 'Ongoing'),
(12, 'Oliver Black', 'Location U', 'Location V', '0000-00-00 00:00:00', 'Canceled', 'Canceled'),
(13, 'Sophia Green', 'Location W', 'Location X', '0000-00-00 00:00:00', 'Scheduled', 'Scheduled'),
(14, 'Benjamin Clark', 'Location Y', 'Location Z', '0000-00-00 00:00:00', 'Daily Ride', 'Completed'),
(15, 'Mia Scott', 'Location AA', 'Location BB', '0000-00-00 00:00:00', 'Rental Ride', 'Pending');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ride_request`
--
ALTER TABLE `ride_request`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ride_request`
--
ALTER TABLE `ride_request`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
