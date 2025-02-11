-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 11, 2025 at 08:35 AM
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
-- Database: `admin-panel`
--

-- --------------------------------------------------------

--
-- Table structure for table `partner-availability`
--

CREATE TABLE `partner-availability` (
  `partnerId` int(11) NOT NULL,
  `currentLocation` varchar(255) NOT NULL,
  `status` enum('Online','Offline') NOT NULL DEFAULT 'Offline',
  `schedule` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `partner-availability`
--

INSERT INTO `partner-availability` (`partnerId`, `currentLocation`, `status`, `schedule`) VALUES
(537467, 'Nimani', 'Online', '2pm-5pm'),
(1231232, 'nashik', 'Online', '1-9pm'),
(74664545, 'adgaon', 'Online', '2pm-4pm');

--
-- Triggers `partner-availability`
--
DELIMITER $$
CREATE TRIGGER `capitalize_partner_availability` BEFORE INSERT ON `partner-availability` FOR EACH ROW BEGIN
    SET NEW.`currentLocation` = CONCAT(UPPER(SUBSTRING(NEW.`currentLocation`, 1, 1)), LOWER(SUBSTRING(NEW.`currentLocation`, 2)));
    SET NEW.`status` = CONCAT(UPPER(SUBSTRING(NEW.`status`, 1, 1)), LOWER(SUBSTRING(NEW.`status`, 2)));
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `partner-details`
--

CREATE TABLE `partner-details` (
  `partnerId` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `mobile` varchar(20) NOT NULL,
  `email` varchar(255) NOT NULL,
  `licenseNo` varchar(50) NOT NULL,
  `vehicleType` varchar(100) NOT NULL,
  `vehicleColor` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `partner-details`
--

INSERT INTO `partner-details` (`partnerId`, `username`, `mobile`, `email`, `licenseNo`, `vehicleType`, `vehicleColor`) VALUES
(537467, 'Ajay', '7985645895', 'ajay@gmail.com', '2536534', 'Sedan', 'Green'),
(1231232, 'Abhi', '7249852658', 'abhi@gmail.com', '43234323434', 'Sedan', 'Black'),
(6373644, 'Vaishnav', '4659858785', 'vaishnav@gmail.com', '82774783', 'Hatchback', 'Red'),
(74664545, 'Manish', '9552365894', 'manish@gmail.com', '64773637', 'Suv', 'White');

--
-- Triggers `partner-details`
--
DELIMITER $$
CREATE TRIGGER `capitalize_partner_details` BEFORE INSERT ON `partner-details` FOR EACH ROW BEGIN
    SET NEW.`username` = CONCAT(UPPER(SUBSTRING(NEW.`username`, 1, 1)), LOWER(SUBSTRING(NEW.`username`, 2)));
    SET NEW.`licenseNo` = CONCAT(UPPER(SUBSTRING(NEW.`licenseNo`, 1, 1)), LOWER(SUBSTRING(NEW.`licenseNo`, 2)));
    SET NEW.`vehicleType` = CONCAT(UPPER(SUBSTRING(NEW.`vehicleType`, 1, 1)), LOWER(SUBSTRING(NEW.`vehicleType`, 2)));
    SET NEW.`vehicleColor` = CONCAT(UPPER(SUBSTRING(NEW.`vehicleColor`, 1, 1)), LOWER(SUBSTRING(NEW.`vehicleColor`, 2)));
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `partner-earning`
--

CREATE TABLE `partner-earning` (
  `partnerId` int(11) NOT NULL,
  `fareAmount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `commission` decimal(10,2) NOT NULL DEFAULT 0.00,
  `bonus` decimal(10,2) NOT NULL DEFAULT 0.00,
  `tips` decimal(10,2) NOT NULL DEFAULT 0.00,
  `totalEarnings` decimal(10,2) GENERATED ALWAYS AS (`fareAmount` - `commission` + `bonus` + `tips`) STORED
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `partner-earning`
--

INSERT INTO `partner-earning` (`partnerId`, `fareAmount`, `commission`, `bonus`, `tips`) VALUES
(537467, 40.00, 5.00, 0.00, 0.00),
(1231232, 20.90, 5.00, 1.00, 3.00),
(74664545, 50.00, 10.00, 0.00, 0.00);

-- --------------------------------------------------------

--
-- Table structure for table `partner_performance`
--

CREATE TABLE `partner_performance` (
  `partnerId` int(11) NOT NULL,
  `driverName` varchar(255) NOT NULL,
  `completionRate` decimal(5,2) NOT NULL,
  `cancellationRate` decimal(5,2) NOT NULL,
  `averageRating` decimal(3,2) NOT NULL,
  `customerFeedback` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `partner_performance`
--

INSERT INTO `partner_performance` (`partnerId`, `driverName`, `completionRate`, `cancellationRate`, `averageRating`, `customerFeedback`) VALUES
(537467, 'Ajay', 60.00, 40.00, 8.00, 'Better'),
(1231232, 'abhi', 50.00, 50.00, 4.00, 'good');

--
-- Triggers `partner_performance`
--
DELIMITER $$
CREATE TRIGGER `capitalize_performance_metrics` BEFORE INSERT ON `partner_performance` FOR EACH ROW BEGIN
    SET NEW.`driverName` = CONCAT(UPPER(SUBSTRING(NEW.`driverName`, 1, 1)), LOWER(SUBSTRING(NEW.`driverName`, 2)));
    SET NEW.`customerFeedback` = CONCAT(UPPER(SUBSTRING(NEW.`customerFeedback`, 1, 1)), LOWER(SUBSTRING(NEW.`customerFeedback`, 2)));
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `user_name` varchar(255) NOT NULL,
  `user_mobile` varchar(20) NOT NULL,
  `user_email` varchar(255) NOT NULL,
  `user_gender` enum('male','female','other','noshare') NOT NULL,
  `user_address` text NOT NULL,
  `user_city` varchar(100) NOT NULL,
  `user_state` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `user_name`, `user_mobile`, `user_email`, `user_gender`, `user_address`, `user_city`, `user_state`) VALUES
(2, 'Abhijeet', '7249208521', 'abhi@gmail.com', 'male', 'Nashik adgaon', 'Nashik', 'Maharashtra'),
(3, 'Manish', '7249208558', 'manish@gmail.com', 'male', 'Nashik jatra', 'Nashik', 'Maharashtra'),
(4, 'Ajay', '645626585', 'ajay@gmail.com', 'male', 'Mumbai santakruj', 'Mumbai', 'Maharashtra'),
(5, 'Abhijeet', '7249208521', 'abhi@gmail.com', 'male', 'Nashik', 'Nashik', 'Maharashtra');

-- --------------------------------------------------------

--
-- Table structure for table `vehicle-details`
--

CREATE TABLE `vehicle-details` (
  `partnerId` int(11) NOT NULL,
  `vehicleMake` varchar(255) NOT NULL,
  `vehicleModel` varchar(255) NOT NULL,
  `year` int(4) NOT NULL,
  `licensePlateNumber` varchar(50) NOT NULL,
  `insuranceDetails` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `vehicle-details`
--

INSERT INTO `vehicle-details` (`partnerId`, `vehicleMake`, `vehicleModel`, `year`, `licensePlateNumber`, `insuranceDetails`) VALUES
(1231232, 'CIAZ', 'CIAZ DIESEL', 2023, '32333232', '232344343'),
(74664545, 'Honda', 'Civic', 2023, '212323223', '3432343');

--
-- Triggers `vehicle-details`
--
DELIMITER $$
CREATE TRIGGER `capitalize_vehicle_details` BEFORE INSERT ON `vehicle-details` FOR EACH ROW BEGIN
    SET NEW.`vehicleMake` = CONCAT(UPPER(SUBSTRING(NEW.`vehicleMake`, 1, 1)), LOWER(SUBSTRING(NEW.`vehicleMake`, 2)));
    SET NEW.`vehicleModel` = CONCAT(UPPER(SUBSTRING(NEW.`vehicleModel`, 1, 1)), LOWER(SUBSTRING(NEW.`vehicleModel`, 2)));
    SET NEW.`insuranceDetails` = CONCAT(UPPER(SUBSTRING(NEW.`insuranceDetails`, 1, 1)), LOWER(SUBSTRING(NEW.`insuranceDetails`, 2)));
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `capitalize_vehicle_details_before_insert` BEFORE INSERT ON `vehicle-details` FOR EACH ROW BEGIN
    SET NEW.vehicleMake = UPPER(NEW.vehicleMake);
    SET NEW.vehicleModel = UPPER(NEW.vehicleModel);
    SET NEW.insuranceDetails = UPPER(NEW.insuranceDetails);
END
$$
DELIMITER ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `partner-availability`
--
ALTER TABLE `partner-availability`
  ADD PRIMARY KEY (`partnerId`);

--
-- Indexes for table `partner-details`
--
ALTER TABLE `partner-details`
  ADD PRIMARY KEY (`partnerId`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `partner-earning`
--
ALTER TABLE `partner-earning`
  ADD PRIMARY KEY (`partnerId`);

--
-- Indexes for table `partner_performance`
--
ALTER TABLE `partner_performance`
  ADD PRIMARY KEY (`partnerId`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `vehicle-details`
--
ALTER TABLE `vehicle-details`
  ADD PRIMARY KEY (`partnerId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `partner-details`
--
ALTER TABLE `partner-details`
  MODIFY `partnerId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=74664546;

--
-- AUTO_INCREMENT for table `partner_performance`
--
ALTER TABLE `partner_performance`
  MODIFY `partnerId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1231233;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `partner-availability`
--
ALTER TABLE `partner-availability`
  ADD CONSTRAINT `partner-availability_ibfk_1` FOREIGN KEY (`partnerId`) REFERENCES `partner-details` (`partnerId`) ON DELETE CASCADE;

--
-- Constraints for table `partner-earning`
--
ALTER TABLE `partner-earning`
  ADD CONSTRAINT `partner-earning_ibfk_1` FOREIGN KEY (`partnerId`) REFERENCES `partner-details` (`partnerId`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
