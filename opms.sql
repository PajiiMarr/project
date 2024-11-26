-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Nov 26, 2024 at 01:12 PM
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
(1, 'admin', '$2y$10$87RfoQxL13LD9xgxvQvEz.7AfxpXeAqCdQxPmd3bYEjqp1orUfZTC', '2024-11-24 14:20:55');

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
  `status` enum('Active','Inactive') NOT NULL DEFAULT 'Active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `organization`
--

CREATE TABLE `organization` (
  `organization_id` int(11) NOT NULL,
  `org_name` varchar(100) DEFAULT NULL,
  `admin_id` int(11) DEFAULT 1,
  `org_description` varchar(255) NOT NULL,
  `required_fee` decimal(10,2) DEFAULT 0.00,
  `total_collected` decimal(10,2) DEFAULT 0.00,
  `pending_balance` decimal(10,2) DEFAULT 0.00,
  `created_date` date NOT NULL,
  `last_updated` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `contact_email` varchar(100) NOT NULL,
  `status` enum('Active','Inactive') NOT NULL DEFAULT 'Active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `organization`
--

INSERT INTO `organization` (`organization_id`, `org_name`, `admin_id`, `org_description`, `required_fee`, `total_collected`, `pending_balance`, `created_date`, `last_updated`, `contact_email`, `status`) VALUES
(1, 'Venom Publication', 1, '', 70.00, 0.00, 2.00, '2019-10-01', '2024-11-26 10:51:23', '', 'Active'),
(2, 'Gender Club', 1, '', 150.00, 0.00, 150.00, '2019-05-02', '2024-11-26 08:04:52', '', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE `payment` (
  `payment_id` int(11) NOT NULL,
  `student_org_id` int(11) DEFAULT NULL,
  `facilitator_id` int(11) DEFAULT NULL,
  `admin_id` int(11) DEFAULT NULL,
  `amount_to_pay` decimal(10,2) NOT NULL,
  `payment_status` enum('Paid','Unpaid') DEFAULT 'Unpaid',
  `date_of_payment` date DEFAULT NULL,
  `semester` enum('First Semester','Second Semester') DEFAULT NULL,
  `issue_pay` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payment`
--

INSERT INTO `payment` (`payment_id`, `student_org_id`, `facilitator_id`, `admin_id`, `amount_to_pay`, `payment_status`, `date_of_payment`, `semester`, `issue_pay`) VALUES
(339, 355, NULL, 1, 2.00, 'Unpaid', '2024-11-26', 'First Semester', 0),
(340, 355, NULL, NULL, 70.00, 'Unpaid', NULL, 'Second Semester', 0),
(341, 356, NULL, NULL, 150.00, 'Unpaid', NULL, 'First Semester', 0),
(342, 356, NULL, NULL, 150.00, 'Unpaid', NULL, 'Second Semester', 0);

-- --------------------------------------------------------

--
-- Table structure for table `payment_history`
--

CREATE TABLE `payment_history` (
  `payment_history_id` int(11) NOT NULL,
  `payment_id` int(11) NOT NULL,
  `issued_by` varchar(255) NOT NULL,
  `amount_paid` decimal(10,2) NOT NULL,
  `date_issued` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payment_history`
--

INSERT INTO `payment_history` (`payment_history_id`, `payment_id`, `issued_by`, `amount_paid`, `date_issued`) VALUES
(1, 339, 'Admin', 12.00, '2024-11-26 10:51:23');

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
  `course_section` char(1) DEFAULT NULL,
  `status` enum('Active','Inactive') NOT NULL DEFAULT 'Active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`student_id`, `course_id`, `last_name`, `first_name`, `middle_name`, `phone_number`, `dob`, `age`, `course_year`, `course_section`, `status`) VALUES
(115, 1, 'Manon-og', 'marlo', 'Baylen', '09531331877', '2009-11-03', 15, 'Second Year', 'C', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `student_organization`
--

CREATE TABLE `student_organization` (
  `stud_org_id` int(11) NOT NULL,
  `student_id` int(11) DEFAULT NULL,
  `organization_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `student_organization`
--

INSERT INTO `student_organization` (`stud_org_id`, `student_id`, `organization_id`) VALUES
(355, 115, 1),
(356, 115, 2);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `date_created` date NOT NULL,
  `date_updated` datetime DEFAULT NULL,
  `admin_id` int(11) DEFAULT 1,
  `is_student` tinyint(1) NOT NULL DEFAULT 1,
  `is_facilitator` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `email`, `password`, `date_created`, `date_updated`, `admin_id`, `is_student`, `is_facilitator`) VALUES
(115, 'gumanakana@gmail.com', '$2y$10$pgguS0Yb7Bzl/KK/A31IT.2WPYE9wCQVgg5yihsB5F0wnldm7llSe', '2024-11-26', '2024-11-26 09:04:52', 1, 1, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`admin_id`);

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
  ADD PRIMARY KEY (`organization_id`),
  ADD KEY `admin_id` (`admin_id`);

--
-- Indexes for table `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`payment_id`),
  ADD KEY `fk_payment_student_org` (`student_org_id`),
  ADD KEY `fk_payment_facilitator` (`facilitator_id`),
  ADD KEY `fk_payment_admin` (`admin_id`);

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
-- Indexes for table `student_organization`
--
ALTER TABLE `student_organization`
  ADD PRIMARY KEY (`stud_org_id`),
  ADD KEY `fk_student_org_student` (`student_id`),
  ADD KEY `fk_student_org_org` (`organization_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`),
  ADD KEY `fk_user_admin` (`admin_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `course`
--
ALTER TABLE `course`
  MODIFY `course_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `organization`
--
ALTER TABLE `organization`
  MODIFY `organization_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `payment`
--
ALTER TABLE `payment`
  MODIFY `payment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=343;

--
-- AUTO_INCREMENT for table `payment_history`
--
ALTER TABLE `payment_history`
  MODIFY `payment_history_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `student_organization`
--
ALTER TABLE `student_organization`
  MODIFY `stud_org_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=357;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=116;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `facilitator`
--
ALTER TABLE `facilitator`
  ADD CONSTRAINT `facilitator_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `course` (`course_id`),
  ADD CONSTRAINT `fk_facilitator_org` FOREIGN KEY (`organization_id`) REFERENCES `organization` (`organization_id`),
  ADD CONSTRAINT `fk_facilitator_user` FOREIGN KEY (`facilitator_id`) REFERENCES `user` (`user_id`);

--
-- Constraints for table `organization`
--
ALTER TABLE `organization`
  ADD CONSTRAINT `organization_ibfk_1` FOREIGN KEY (`admin_id`) REFERENCES `admin` (`admin_id`);

--
-- Constraints for table `payment`
--
ALTER TABLE `payment`
  ADD CONSTRAINT `fk_payment_admin` FOREIGN KEY (`admin_id`) REFERENCES `admin` (`admin_id`),
  ADD CONSTRAINT `fk_payment_facilitator` FOREIGN KEY (`facilitator_id`) REFERENCES `facilitator` (`facilitator_id`),
  ADD CONSTRAINT `fk_payment_student_org` FOREIGN KEY (`student_org_id`) REFERENCES `student_organization` (`stud_org_id`);

--
-- Constraints for table `student`
--
ALTER TABLE `student`
  ADD CONSTRAINT `fk_student_course` FOREIGN KEY (`course_id`) REFERENCES `course` (`course_id`),
  ADD CONSTRAINT `fk_student_user` FOREIGN KEY (`student_id`) REFERENCES `user` (`user_id`);

--
-- Constraints for table `student_organization`
--
ALTER TABLE `student_organization`
  ADD CONSTRAINT `fk_student_org_org` FOREIGN KEY (`organization_id`) REFERENCES `organization` (`organization_id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_student_org_student` FOREIGN KEY (`student_id`) REFERENCES `student` (`student_id`);

--
-- Constraints for table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `fk_user_admin` FOREIGN KEY (`admin_id`) REFERENCES `admin` (`admin_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
