-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 11, 2025 at 07:18 AM
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
(13, 'Parcel Services');

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
(16, 4, 'Maximum size of parcel', '50kg');

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
(13, 13, ' Canceling');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `faq_main_topics`
--
ALTER TABLE `faq_main_topics`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `faq_questions`
--
ALTER TABLE `faq_questions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sub_topic_id` (`sub_topic_id`);

--
-- Indexes for table `faq_sub_topics`
--
ALTER TABLE `faq_sub_topics`
  ADD PRIMARY KEY (`id`),
  ADD KEY `main_topic_id` (`main_topic_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `faq_main_topics`
--
ALTER TABLE `faq_main_topics`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `faq_questions`
--
ALTER TABLE `faq_questions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `faq_sub_topics`
--
ALTER TABLE `faq_sub_topics`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `faq_questions`
--
ALTER TABLE `faq_questions`
  ADD CONSTRAINT `faq_questions_ibfk_1` FOREIGN KEY (`sub_topic_id`) REFERENCES `faq_sub_topics` (`id`);

--
-- Constraints for table `faq_sub_topics`
--
ALTER TABLE `faq_sub_topics`
  ADD CONSTRAINT `faq_sub_topics_ibfk_1` FOREIGN KEY (`main_topic_id`) REFERENCES `faq_main_topics` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
