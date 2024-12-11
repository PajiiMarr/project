-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Dec 10, 2024 at 02:15 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `opms`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `admin_id` int(11) NOT NULL,
  `admin_username` varchar(50) NOT NULL,
  `admin_password` varchar(100) NOT NULL,
  `date_updated` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`admin_id`, `admin_username`, `admin_password`, `date_updated`) VALUES
(1, 'admin', '$2y$10$87RfoQxL13LD9xgxvQvEz.7AfxpXeAqCdQxPmd3bYEjqp1orUfZTC', '2024-12-07 07:06:46');

-- --------------------------------------------------------

--
-- Table structure for table `collection_fees`
--

CREATE TABLE `collection_fees` (
  `collection_id` int(11) NOT NULL,
  `organization_id` int(11) NOT NULL,
  `purpose` varchar(150) NOT NULL DEFAULT '',
  `amount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `total_collected` decimal(10,2) NOT NULL DEFAULT 0.00,
  `pending_balance` decimal(10,2) NOT NULL DEFAULT 0.00,
  `request_status` varchar(20) NOT NULL DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `collection_fees`
--

INSERT INTO `collection_fees` (`collection_id`, `organization_id`, `purpose`, `amount`, `total_collected`, `pending_balance`, `request_status`) VALUES
(1, 2, 'Clearance', 75.00, 0.00, 225.00, 'Pending'),
(2, 1, 'Clearance', 85.00, 173.00, 82.00, 'Pending'),
(6, 51, 'Clearance', 200.00, 0.00, 600.00, 'Pending'),
(7, 52, 'Clearance', 150.00, 0.00, 450.00, 'Pending'),
(8, 53, 'Clearance', 10.00, 0.00, 30.00, 'Pending'),
(9, 54, 'Clearance', 65.00, 0.00, 65.00, 'Pending'),
(10, 1, 'Clearance', 10.00, 0.00, 0.00, 'Pending'),
(11, 1, 'Clearance', 20.00, 0.00, 0.00, 'Pending'),
(12, 1, 'PSITS Fee', 20.00, 0.00, 0.00, 'Pending');

-- --------------------------------------------------------

--
-- Table structure for table `course`
--

CREATE TABLE `course` (
  `course_id` int(11) NOT NULL,
  `course_code` varchar(10) DEFAULT NULL,
  `course_name` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `course`
--

INSERT INTO `course` (`course_id`, `course_code`, `course_name`) VALUES
(1, 'BSIT', 'Bachelor of Science in Information Technology'),
(2, 'BSCS', 'Bachelor of Science In Computer Science'),
(3, 'ACT AD', 'Associate in Computer Technology Major in Application Development'),
(4, 'ACT NT', 'Associate in Computer Technology Major in Networking');

-- --------------------------------------------------------

--
-- Table structure for table `facilitator`
--

CREATE TABLE `facilitator` (
  `facilitator_id` int(11) NOT NULL,
  `organization_id` int(11) DEFAULT NULL,
  `course_id` int(11) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `middle_name` varchar(100) DEFAULT NULL,
  `phone_number` varchar(20) DEFAULT NULL,
  `dob` date NOT NULL,
  `age` int(11) NOT NULL,
  `course_year` varchar(15) NOT NULL,
  `course_section` text DEFAULT NULL,
  `status` enum('Active','Inactive') NOT NULL DEFAULT 'Active',
  `is_head` tinyint(1) NOT NULL DEFAULT 0,
  `is_assistant_head` tinyint(1) NOT NULL DEFAULT 0,
  `is_collector` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `facilitator`
--

INSERT INTO `facilitator` (`facilitator_id`, `organization_id`, `course_id`, `last_name`, `first_name`, `middle_name`, `phone_number`, `dob`, `age`, `course_year`, `course_section`, `status`, `is_head`, `is_assistant_head`, `is_collector`) VALUES
(123, 1, 2, 'Manon-og', 'mar', 'hellop', '09531331877', '2009-12-01', 15, 'Second Year', 'C', 'Active', 0, 0, 1),
(125, 1, 4, 'Mar', 'Manon-og', 'Po', '09556743241', '2005-07-06', 19, 'Second Year', 'None', 'Active', 0, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `organization`
--

CREATE TABLE `organization` (
  `organization_id` int(11) NOT NULL,
  `org_name` varchar(100) DEFAULT NULL,
  `org_description` varchar(255) NOT NULL,
  `created_date` date NOT NULL,
  `last_updated` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `contact_email` varchar(100) NOT NULL,
  `status` enum('Active','Inactive') NOT NULL DEFAULT 'Active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `organization`
--

INSERT INTO `organization` (`organization_id`, `org_name`, `org_description`, `created_date`, `last_updated`, `contact_email`, `status`) VALUES
(1, 'Venom Publication', 'Wala lang', '2019-10-01', '2024-12-06 14:27:36', '', 'Active'),
(2, 'Gender Club', 'Wala lang', '2019-05-02', '2024-12-06 14:27:40', '', 'Active'),
(51, 'PhiCCS', 'phicss po', '2024-12-06', '2024-12-06 14:55:31', 'phicss@gmail.com', 'Active'),
(52, 'College Student Council', 'csc po', '2024-12-06', '2024-12-06 14:58:48', 'csc@gmail.com', 'Active'),
(53, 'test', 'test', '2024-12-07', '2024-12-07 01:54:33', 'test@email.com', 'Active'),
(54, 'PSITS', 'jashahwfhajs', '2024-12-07', '2024-12-07 07:02:02', 'test@gmail.com', 'Active'),
(55, 'Mar', 'hello po', '2024-12-10', '2024-12-10 06:46:47', 'mar@gmail.com', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE `payment` (
  `payment_id` int(11) NOT NULL,
  `facilitator_id` int(11) DEFAULT NULL,
  `student_id` int(11) NOT NULL,
  `collection_id` int(11) NOT NULL,
  `amount_to_pay` decimal(10,2) NOT NULL,
  `semester` enum('First Semester','Second Semester','') NOT NULL DEFAULT '',
  `payment_status` enum('Paid','Unpaid') DEFAULT 'Unpaid',
  `date_of_payment` date DEFAULT NULL,
  `issue_pay` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payment_history`
--

CREATE TABLE `payment_history` (
  `payment_history_id` int(11) NOT NULL,
  `payment_id` int(11) NOT NULL,
  `issued_by` varchar(255) NOT NULL,
  `amount_paid` decimal(10,2) NOT NULL,
  `start_date` date NOT NULL,
  `date_issued` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE `student` (
  `student_id` int(11) NOT NULL,
  `course_id` int(11) DEFAULT NULL,
  `last_name` varchar(100) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `middle_name` varchar(100) DEFAULT NULL,
  `phone_number` varchar(20) DEFAULT NULL,
  `dob` date NOT NULL,
  `age` int(11) NOT NULL,
  `course_year` varchar(15) NOT NULL,
  `course_section` varchar(4) DEFAULT 'None',
  `status` enum('Enrolled','Dropped','Graduated','Undefined') NOT NULL DEFAULT 'Enrolled'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`student_id`, `course_id`, `last_name`, `first_name`, `middle_name`, `phone_number`, `dob`, `age`, `course_year`, `course_section`, `status`) VALUES
(123, 2, 'Manon-og', 'mar', 'hellop', '09531331877', '2009-12-01', 15, 'Second Year', 'C', 'Enrolled'),
(124, 3, 'Maria', 'Test', 'Hello', '0947321238', '2009-12-01', 15, 'Second Year', 'None', 'Graduated'),
(125, 4, 'Mar', 'Manon-og', 'Po', '09556743241', '2005-07-06', 19, 'Second Year', 'None', 'Dropped');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `date_created` date NOT NULL,
  `date_updated` timestamp NOT NULL DEFAULT current_timestamp(),
  `is_admin` tinyint(1) NOT NULL DEFAULT 0,
  `is_student` tinyint(1) NOT NULL DEFAULT 1,
  `is_facilitator` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `email`, `password`, `date_created`, `date_updated`, `is_admin`, `is_student`, `is_facilitator`) VALUES
(123, 'hz202301575@wmsu.edu.ph', '$2y$10$FVUfF4xBB3fabfaDp4Ai3urspMB7Rv/NvY1wXI4aydb0fihJa5xoK', '2024-12-06', '2024-12-09 23:32:56', 0, 1, 1),
(124, 'hz2023057834@wmsu.edu.ph', '$2y$10$iBPtWfWGGJAcOXwbHM8en.0wECn35OQ.3ko0PsLZD8Z8D1SjR8HZG', '2024-12-06', '2024-12-06 18:59:02', 0, 1, 0),
(125, 'try@gmail.com', '$2y$10$Bznych9LoFXmKZ84.LPpOuU.NoW5CnpvSDJ3yvd3q06J3kY442lj2', '2024-12-06', '2024-12-10 01:26:42', 0, 1, 1),
(126, 'admin', '$2y$10$hSeBlJB.V10pcWTJrLnmUeeeAZmiNjq//wSlIZRm4.E6YApuursEu', '2024-12-10', '2024-12-10 02:41:41', 1, 0, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `collection_fees`
--
ALTER TABLE `collection_fees`
  ADD PRIMARY KEY (`collection_id`),
  ADD KEY `organization_id` (`organization_id`);

--
-- Indexes for table `course`
--
ALTER TABLE `course`
  ADD PRIMARY KEY (`course_id`);

--
-- Indexes for table `facilitator`
--
ALTER TABLE `facilitator`
  ADD PRIMARY KEY (`facilitator_id`),
  ADD KEY `fk_facilitator_org` (`organization_id`),
  ADD KEY `course_id` (`course_id`);

--
-- Indexes for table `organization`
--
ALTER TABLE `organization`
  ADD PRIMARY KEY (`organization_id`);

--
-- Indexes for table `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`payment_id`),
  ADD KEY `fk_payment_facilitator` (`facilitator_id`),
  ADD KEY `collection_id` (`collection_id`),
  ADD KEY `student_id` (`student_id`);

--
-- Indexes for table `payment_history`
--
ALTER TABLE `payment_history`
  ADD PRIMARY KEY (`payment_history_id`);

--
-- Indexes for table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`student_id`),
  ADD KEY `fk_student_course` (`course_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `collection_fees`
--
ALTER TABLE `collection_fees`
  MODIFY `collection_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `course`
--
ALTER TABLE `course`
  MODIFY `course_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `organization`
--
ALTER TABLE `organization`
  MODIFY `organization_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT for table `payment`
--
ALTER TABLE `payment`
  MODIFY `payment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=477;

--
-- AUTO_INCREMENT for table `payment_history`
--
ALTER TABLE `payment_history`
  MODIFY `payment_history_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=127;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `collection_fees`
--
ALTER TABLE `collection_fees`
  ADD CONSTRAINT `collection_fees_ibfk_1` FOREIGN KEY (`organization_id`) REFERENCES `organization` (`organization_id`);

--
-- Constraints for table `facilitator`
--
ALTER TABLE `facilitator`
  ADD CONSTRAINT `facilitator_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `course` (`course_id`),
  ADD CONSTRAINT `fk_facilitator_org` FOREIGN KEY (`organization_id`) REFERENCES `organization` (`organization_id`),
  ADD CONSTRAINT `fk_facilitator_user` FOREIGN KEY (`facilitator_id`) REFERENCES `user` (`user_id`);

--
-- Constraints for table `payment`
--
ALTER TABLE `payment`
  ADD CONSTRAINT `fk_payment_facilitator` FOREIGN KEY (`facilitator_id`) REFERENCES `facilitator` (`facilitator_id`),
  ADD CONSTRAINT `payment_ibfk_1` FOREIGN KEY (`collection_id`) REFERENCES `collection_fees` (`collection_id`),
  ADD CONSTRAINT `payment_ibfk_2` FOREIGN KEY (`student_id`) REFERENCES `student` (`student_id`);

--
-- Constraints for table `student`
--
ALTER TABLE `student`
  ADD CONSTRAINT `fk_student_course` FOREIGN KEY (`course_id`) REFERENCES `course` (`course_id`),
  ADD CONSTRAINT `fk_student_user` FOREIGN KEY (`student_id`) REFERENCES `user` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
