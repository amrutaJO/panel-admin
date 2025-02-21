-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 20, 2025 at 09:26 AM
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
-- Table structure for table `all_users`
--

CREATE TABLE `all_users` (
  `id` int(11) NOT NULL,
  `user_name` varchar(255) DEFAULT NULL,
  `user_role` enum('user','admin','partner') DEFAULT NULL,
  `mobile_number` varchar(20) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `all_users`
--

INSERT INTO `all_users` (`id`, `user_name`, `user_role`, `mobile_number`, `email`) VALUES
(1234, 'mansi ', 'user', '8786543', 'abc@123'),
(767543, 'mansi ', 'user', '8786543', 'abc@123'),
(767544, 'Shashikant Shirsath', 'user', '9356234575', 'abc@gmail.com'),
(767545, 'Admin User', 'admin', '1234567890', 'admin@gmail.com'),
(767546, 'Partner User', 'partner', '9876543210', 'partner@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `cancellations`
--

CREATE TABLE `cancellations` (
  `id` int(11) NOT NULL,
  `customer_name` varchar(255) DEFAULT NULL,
  `cancellation_reason` varchar(255) DEFAULT NULL,
  `customer_id` varchar(100) DEFAULT NULL,
  `vehicle_id` varchar(100) DEFAULT NULL,
  `driver_name` varchar(255) DEFAULT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp(),
  `additional_info` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cancellations`
--

INSERT INTO `cancellations` (`id`, `customer_name`, `cancellation_reason`, `customer_id`, `vehicle_id`, `driver_name`, `date`, `additional_info`) VALUES
(1, 'Manish', 'delayed', 'UID876', 'VCL9676', 'Rahul Barhate	', '2025-02-11 12:11:32', '');

-- --------------------------------------------------------

--
-- Table structure for table `custom_push`
--

CREATE TABLE `custom_push` (
  `id` int(11) NOT NULL,
  `notification_type` enum('Notification','SMS','WhatsApp') NOT NULL,
  `send_by` enum('Admin','User','Partner') NOT NULL,
  `message` text NOT NULL,
  `recipients` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
(16, 'bonafite certificate', 'Bona.jpg', 'this is my mca bonafite', '2025-02-07 13:26:33', 'declined'),
(17, 'aadhar', '1.webp', 'Aadhar card', '2025-02-20 11:06:23', 'active'),
(18, 'aadhar', '1.webp', 'Aadhar card', '2025-02-20 11:08:22', 'active');

-- --------------------------------------------------------

--
-- Table structure for table `faq_main_topics`
--

CREATE TABLE `faq_main_topics` (
  `id` int(11) NOT NULL,
  `topic_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `faq_main_topics`
--

INSERT INTO `faq_main_topics` (`id`, `topic_name`) VALUES
(4, 'parcel'),
(7, 'Pickup Services'),
(13, 'Parcel Services'),
(14, 'Parcel'),
(4, 'parcel'),
(7, 'Pickup Services'),
(13, 'Parcel Services'),
(14, 'Parcel');

-- --------------------------------------------------------

--
-- Table structure for table `faq_questions`
--

CREATE TABLE `faq_questions` (
  `id` int(11) NOT NULL,
  `sub_topic_id` int(11) DEFAULT NULL,
  `question` text NOT NULL,
  `answer` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `faq_questions`
--

INSERT INTO `faq_questions` (`id`, `sub_topic_id`, `question`, `answer`) VALUES
(7, 13, ' What size of parcel?', ' We offer various shipping '),
(9, 4, 'What is the maximum weight allowed for a parcel?', 'The maximum weight limit depends on the courier service. Generally, it ranges from 20 kg to 70 kg for standard shipping.'),
(10, 4, 'Are there extra charges for heavy parcels?', 'Yes, parcels exceeding the standard weight limit may incur additional fees. Check with the courier for overweight charges.'),
(11, 12, 'How can I track my parcel?', 'Use the tracking number provided by the courier on their website or mobile app.'),
(12, 13, 'Can I change the delivery address after booking?', 'Address changes can be made before the parcel is dispatched by contacting support.'),
(13, 13, 'What if my parcel is lost or delayed?', 'If your parcel is delayed beyond the estimated time, check tracking or contact support for assistance. If lost, we will initiate a claim process.'),
(14, 13, 'How do I return a parcel?', 'If the return option is available, go to \"My Orders\" and select \"Request Return.\" Follow the instructions provided.'),
(15, 4, 'Maximum size of parcel', '30kg'),
(16, 4, 'Maximum size of parcel', '50kg'),
(17, 13, 'whats cost?', '123'),
(7, 13, ' What size of parcel?', ' We offer various shipping '),
(9, 4, 'What is the maximum weight allowed for a parcel?', 'The maximum weight limit depends on the courier service. Generally, it ranges from 20 kg to 70 kg for standard shipping.'),
(10, 4, 'Are there extra charges for heavy parcels?', 'Yes, parcels exceeding the standard weight limit may incur additional fees. Check with the courier for overweight charges.'),
(11, 12, 'How can I track my parcel?', 'Use the tracking number provided by the courier on their website or mobile app.'),
(12, 13, 'Can I change the delivery address after booking?', 'Address changes can be made before the parcel is dispatched by contacting support.'),
(13, 13, 'What if my parcel is lost or delayed?', 'If your parcel is delayed beyond the estimated time, check tracking or contact support for assistance. If lost, we will initiate a claim process.'),
(14, 13, 'How do I return a parcel?', 'If the return option is available, go to \"My Orders\" and select \"Request Return.\" Follow the instructions provided.'),
(15, 4, 'Maximum size of parcel', '30kg'),
(16, 4, 'Maximum size of parcel', '50kg'),
(17, 13, 'whats cost?', '123');

-- --------------------------------------------------------

--
-- Table structure for table `faq_sub_topics`
--

CREATE TABLE `faq_sub_topics` (
  `id` int(11) NOT NULL,
  `main_topic_id` int(11) DEFAULT NULL,
  `sub_topic_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `faq_sub_topics`
--

INSERT INTO `faq_sub_topics` (`id`, `main_topic_id`, `sub_topic_name`) VALUES
(4, 4, 'weight'),
(12, 12, 'Tracking'),
(13, 13, ' Canceling'),
(14, 14, 'Admin'),
(4, 4, 'weight'),
(12, 12, 'Tracking'),
(13, 13, ' Canceling'),
(14, 14, 'Admin');

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `feedback` text NOT NULL,
  `rating` int(11) DEFAULT NULL CHECK (`rating` between 1 and 5),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `feedback`
--

INSERT INTO `feedback` (`id`, `name`, `email`, `phone`, `feedback`, `rating`, `created_at`) VALUES
(8, 'Aj', 'amrutajoshi7878@gmail.com', '74476643111', 'heck', 3, '2025-02-05 10:21:25'),
(10, 'John', 'a123@gmail.com', '74476643111', 'Dummy', 5, '2025-02-07 12:13:33'),
(11, 'Amruta Joshi', 'aj123@gmail.com', '8899112233', 'Great Services', 5, '2025-02-10 07:01:19'),
(12, 'Alex', 'alex123@gmail.com', '7474747474', 'Great', 4, '2025-02-10 18:07:54'),
(13, 'KELVIN', 'K@123GMAIL.COM', '7474747474', 'DUMMY', 5, '2025-02-11 05:29:12'),
(14, 'KEL', 's@gmail.com', '8899112233', 'integration', 5, '2025-02-11 06:17:25'),
(8, 'Aj', 'amrutajoshi7878@gmail.com', '74476643111', 'heck', 3, '2025-02-05 10:21:25'),
(10, 'John', 'a123@gmail.com', '74476643111', 'Dummy', 5, '2025-02-07 12:13:33'),
(11, 'Amruta Joshi', 'aj123@gmail.com', '8899112233', 'Great Services', 5, '2025-02-10 07:01:19'),
(12, 'Alex', 'alex123@gmail.com', '7474747474', 'Great', 4, '2025-02-10 18:07:54'),
(13, 'KELVIN', 'K@123GMAIL.COM', '7474747474', 'DUMMY', 5, '2025-02-11 05:29:12'),
(14, 'KEL', 's@gmail.com', '8899112233', 'integration', 1, '2025-02-11 06:17:25');

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
-- Table structure for table `notification_management`
--

CREATE TABLE `notification_management` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `partner_id` int(11) NOT NULL,
  `status` enum('pending','sent','failed') NOT NULL DEFAULT 'pending',
  `message` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `delivered_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `notification_management`
--

INSERT INTO `notification_management` (`id`, `user_id`, `partner_id`, `status`, `message`, `created_at`, `delivered_at`) VALUES
(1, 1, 101, 'sent', 'Your parcel has been shipped.', '2025-02-05 06:40:54', '2025-02-05 06:40:54'),
(2, 2, 102, 'pending', 'Your parcel is ready for pickup.', '2025-02-05 06:40:54', NULL);

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

-- --------------------------------------------------------

--
-- Table structure for table `packages`
--

CREATE TABLE `packages` (
  `id` int(11) NOT NULL,
  `distance_km` decimal(10,2) NOT NULL,
  `time_hours` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `packages`
--

INSERT INTO `packages` (`id`, `distance_km`, `time_hours`) VALUES
(2, 10.00, '3'),
(3, 50.00, '3'),
(4, 20.00, '1');

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
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `joining_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `partners`
--

INSERT INTO `partners` (`id`, `partner_name`, `mobile_no`, `email_id`, `partner_type`, `daily_services`, `account_no`, `bank_name`, `gender`, `address`, `outstation_services`, `upi_id`, `ifsc_code`, `password`, `salary_type`, `salary`, `created_at`, `joining_date`) VALUES
(25, 'Manish Sonawane', '9322897948', 'manishsonawane3010@gmail.com', 'Full Time', 'yes', '123456789012', 'SBI Bank', 'Male', 'Room No 103, B-wing, Ganga Plaza, Navi Mumbai', 'yes', 'KJHGFDSA54321', 'FDSA432', 'Manish#0967', '', 430.00, '2025-02-06 16:36:56', '0000-00-00'),
(26, 'Rahul Barhate', '6789012345', 'rahulbarhate123@gmail.com', 'Part Time', 'no', '564523465332', 'SBI Bank', 'Male', 'Jalgaon, Maharashtra', 'no', 'ASDF1234ZXCV', 'FDSA432', 'Rahul@123', 'Monthly', 2341.00, '2025-02-07 05:22:17', NULL),
(28, 'Rahul Barhate', '8754347687', 'barhaterahul454@gmail.com', 'Part Time', 'no', '123456789012', 'Bank of Baroda', 'Male', 'Jalgaon, Maharashtra', 'yes', 'KJHGFDSA54321', 'FDSA432', 'Rahul@123', 'Monthly', 1211.00, '2025-02-09 15:49:43', NULL),
(29, 'Manish Sonawane', '9322897948', 'manishsonawane3010@gmail.com', 'Full Time', 'yes', '98765432121', 'HDFC Bank', 'Male', 'Room No 103, B-wing, Ganga Plaza', 'yes', 'ASDFGHJK1234AS', 'FDSA432', 'Manish%123&', 'Monthly', 2134.00, '2025-02-09 17:09:27', NULL);

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
-- Table structure for table `rental_services`
--

CREATE TABLE `rental_services` (
  `id` int(11) NOT NULL,
  `hourly_package` enum('basic','premium','luxury') NOT NULL,
  `base_fare` decimal(10,2) NOT NULL,
  `booking_fee` decimal(10,2) NOT NULL,
  `vehicle_type` enum('bike','three_wheeler','car','truck','other') NOT NULL,
  `per_km_rate` decimal(10,2) NOT NULL,
  `per_minute_rate` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `rental_services`
--

INSERT INTO `rental_services` (`id`, `hourly_package`, `base_fare`, `booking_fee`, `vehicle_type`, `per_km_rate`, `per_minute_rate`) VALUES
(1, 'luxury', 100.00, 50.00, 'bike', 10.00, 2.00),
(2, 'premium', 300.00, 200.00, 'car', 19.00, 20.00),
(3, 'basic', 20.00, 300.00, 'car', 30.00, 10.00);

-- --------------------------------------------------------

--
-- Table structure for table `ride_request`
--

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

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` int(11) NOT NULL,
  `transaction_id` varchar(50) NOT NULL,
  `order_id` varchar(50) NOT NULL,
  `user_id` varchar(50) NOT NULL,
  `partner_id` varchar(50) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `payment_method` varchar(20) NOT NULL,
  `status` enum('pending','completed','failed') NOT NULL,
  `transaction_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`id`, `transaction_id`, `order_id`, `user_id`, `partner_id`, `amount`, `payment_method`, `status`, `transaction_date`) VALUES
(1, 'GFD4564FHI', 'BKJ4W5', 'UID64', 'PYREGS54', 131.45, 'online', 'completed', '2025-02-14 09:56:57'),
(2, 'TRX7890ABC', 'ORD1234', 'USER987', 'PART567', 200.75, 'credit_card', 'pending', '2025-02-14 09:56:57'),
(3, 'TRX9876XYZ', 'ORD5678', 'USR789', 'PRT3456', 250.75, 'Credit Card', 'pending', '2025-02-14 10:15:00');

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
(126, 'Abhi', '7249208521', 'abhi@gmail.com', 'male', 'Nashik konarknagar', 'mumbai', 'maharashtra'),
(131, 'Ajay', '7778525878', 'ajay@gmail.com', 'male', 'Nashik', 'Nashik', 'Maharashtra'),
(133, 'Sameer', '7778525878', 'sameer@gmail.com', 'male', 'Nashik', 'Nashik', 'Maharashtra'),
(135, 'Amar', '655225263', '', 'male', '', 'Nashik', 'Maharashtra');

-- --------------------------------------------------------

--
-- Table structure for table `user_wallets`
--

CREATE TABLE `user_wallets` (
  `id` int(11) NOT NULL,
  `user_name` varchar(255) NOT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `remaining_amount` decimal(10,2) NOT NULL,
  `used_amount` decimal(10,2) NOT NULL,
  `last_updated` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_wallets`
--

INSERT INTO `user_wallets` (`id`, `user_name`, `total_amount`, `remaining_amount`, `used_amount`, `last_updated`) VALUES
(1, 'Manish9322', 3300.00, 3300.00, 0.00, '2025-02-13 19:23:35'),
(2, 'Tejas Khairnar', 2100.00, 1600.00, 500.00, '2025-02-06 06:31:24'),
(3, 'Manish9322', 1000.00, 700.00, 300.00, '2025-02-14 18:30:00'),
(4, 'Tejas Khairnar', 2000.00, 1500.00, 500.00, '2025-03-29 18:30:00');

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
(2, 'Honda', 'Blue', 'Sivic', '2024', '3', 'active'),
(3, 'Hero Honda', 'light blue', 'Sivic 0.1', '2024', '3', 'active'),
(6, 'Hero 12', 'Black', '!m_4', '2024', '2', 'active'),
(11, 'Hundai ', 'Red', 'silicon 0.4', '2002', '4', 'declined');

-- --------------------------------------------------------

--
-- Table structure for table `wallet_payments`
--

CREATE TABLE `wallet_payments` (
  `id` int(11) NOT NULL,
  `passenger_name` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `payment_id` varchar(50) NOT NULL,
  `payment_mode` varchar(50) NOT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `paid_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `wallet_payments`
--

INSERT INTO `wallet_payments` (`id`, `passenger_name`, `title`, `payment_id`, `payment_mode`, `total_amount`, `paid_at`) VALUES
(1, 'Manish Sonawane', 'Flight Payment', 'GRTGB123', 'Credit Card', 500.00, '2025-01-22 00:00:00'),
(2, 'Jayesh Chaudhari', 'Train Payment', 'HGHJT456', 'Debit Card', 300.00, '2025-01-21 00:00:00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cancellations`
--
ALTER TABLE `cancellations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `custom_push`
--
ALTER TABLE `custom_push`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `document_types`
--
ALTER TABLE `document_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `new_vehicles`
--
ALTER TABLE `new_vehicles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `vehicle_number` (`vehicle_number`);

--
-- Indexes for table `notification_management`
--
ALTER TABLE `notification_management`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_dashboard`
--
ALTER TABLE `order_dashboard`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `packages`
--
ALTER TABLE `packages`
  ADD PRIMARY KEY (`id`);

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
-- Indexes for table `partners`
--
ALTER TABLE `partners`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `partner_performance`
--
ALTER TABLE `partner_performance`
  ADD PRIMARY KEY (`partnerId`);

--
-- Indexes for table `rental_services`
--
ALTER TABLE `rental_services`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `user_wallets`
--
ALTER TABLE `user_wallets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vehicle-details`
--
ALTER TABLE `vehicle-details`
  ADD PRIMARY KEY (`partnerId`);

--
-- Indexes for table `vehicles`
--
ALTER TABLE `vehicles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vehicle_master`
--
ALTER TABLE `vehicle_master`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `wallet_payments`
--
ALTER TABLE `wallet_payments`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `payment_id` (`payment_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cancellations`
--
ALTER TABLE `cancellations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `custom_push`
--
ALTER TABLE `custom_push`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `document_types`
--
ALTER TABLE `document_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `new_vehicles`
--
ALTER TABLE `new_vehicles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `notification_management`
--
ALTER TABLE `notification_management`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `order_dashboard`
--
ALTER TABLE `order_dashboard`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `packages`
--
ALTER TABLE `packages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `partner-details`
--
ALTER TABLE `partner-details`
  MODIFY `partnerId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=74664546;

--
-- AUTO_INCREMENT for table `partners`
--
ALTER TABLE `partners`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `partner_performance`
--
ALTER TABLE `partner_performance`
  MODIFY `partnerId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1231233;

--
-- AUTO_INCREMENT for table `rental_services`
--
ALTER TABLE `rental_services`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=137;

--
-- AUTO_INCREMENT for table `user_wallets`
--
ALTER TABLE `user_wallets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `vehicles`
--
ALTER TABLE `vehicles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `vehicle_master`
--
ALTER TABLE `vehicle_master`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `wallet_payments`
--
ALTER TABLE `wallet_payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

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
