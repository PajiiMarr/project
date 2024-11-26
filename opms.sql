-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Nov 25, 2024 at 09:58 AM
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
  `required_fee` decimal(10,2) DEFAULT NULL,
  `total_collected` decimal(10,2) DEFAULT 0.00,
  `pending_balance` decimal(10,2) DEFAULT NULL,
  `created_date` date NOT NULL,
  `last_updated` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `contact_email` varchar(100) NOT NULL,
  `status` enum('Active','Inactive') NOT NULL DEFAULT 'Active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `organization`
--

INSERT INTO `organization` (`organization_id`, `org_name`, `admin_id`, `org_description`, `required_fee`, `total_collected`, `pending_balance`, `created_date`, `last_updated`, `contact_email`, `status`) VALUES
(1, 'Venom Publication', 1, '', 70.00, 0.00, 280.00, '2019-10-01', '2024-11-24 14:07:48', '', 'Active'),
(2, 'Gender Club', 1, '', 150.00, 0.00, 600.00, '2019-05-02', '2024-11-24 14:46:51', '', 'Active'),
(9, 'PSITS', 1, 'hello', 75.00, 0.00, 300.00, '2024-11-21', '2024-11-24 14:09:39', 'hi@gmail.com', 'Active'),
(10, 'csc', 1, 'hellpo', 200.00, 0.00, 800.00, '2024-11-21', '2024-11-24 14:09:18', 'csc@gmail.com', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE `payment` (
  `payment_id` int(11) NOT NULL,
  `student_org_id` int(11) DEFAULT NULL,
  `facilitator_id` int(11) DEFAULT NULL,
  `admin_id` int(11) DEFAULT NULL,
  `amount_to_pay` decimal(10,2) DEFAULT NULL,
  `payment_status` enum('Paid','Unpaid') DEFAULT 'Unpaid',
  `date_of_payment` date DEFAULT NULL,
  `semester` enum('First Semester','Second Semester') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payment`
--

INSERT INTO `payment` (`payment_id`, `student_org_id`, `facilitator_id`, `admin_id`, `amount_to_pay`, `payment_status`, `date_of_payment`, `semester`) VALUES
(155, 249, NULL, NULL, NULL, 'Unpaid', NULL, 'First Semester'),
(156, 249, NULL, NULL, NULL, 'Unpaid', NULL, 'Second Semester'),
(157, 250, NULL, NULL, NULL, 'Unpaid', NULL, 'First Semester'),
(158, 250, NULL, NULL, NULL, 'Unpaid', NULL, 'Second Semester'),
(159, 251, NULL, NULL, NULL, 'Unpaid', NULL, 'First Semester'),
(160, 251, NULL, NULL, NULL, 'Unpaid', NULL, 'Second Semester'),
(161, 252, NULL, NULL, NULL, 'Unpaid', NULL, 'First Semester'),
(162, 252, NULL, NULL, NULL, 'Unpaid', NULL, 'Second Semester'),
(163, 253, NULL, NULL, NULL, 'Unpaid', NULL, 'First Semester'),
(164, 253, NULL, NULL, NULL, 'Unpaid', NULL, 'Second Semester'),
(165, 254, NULL, NULL, NULL, 'Unpaid', NULL, 'First Semester'),
(166, 254, NULL, NULL, NULL, 'Unpaid', NULL, 'Second Semester'),
(167, 255, NULL, NULL, NULL, 'Unpaid', NULL, 'First Semester'),
(168, 255, NULL, NULL, NULL, 'Unpaid', NULL, 'Second Semester'),
(169, 256, NULL, NULL, NULL, 'Unpaid', NULL, 'First Semester'),
(170, 256, NULL, NULL, NULL, 'Unpaid', NULL, 'Second Semester'),
(171, 257, NULL, NULL, NULL, 'Unpaid', NULL, 'First Semester'),
(172, 257, NULL, NULL, NULL, 'Unpaid', NULL, 'Second Semester'),
(173, 258, NULL, NULL, NULL, 'Unpaid', NULL, 'First Semester'),
(174, 258, NULL, NULL, NULL, 'Unpaid', NULL, 'Second Semester'),
(175, 259, NULL, NULL, NULL, 'Unpaid', NULL, 'First Semester'),
(176, 259, NULL, NULL, NULL, 'Unpaid', NULL, 'Second Semester'),
(177, 260, NULL, NULL, NULL, 'Unpaid', NULL, 'First Semester'),
(178, 260, NULL, NULL, NULL, 'Unpaid', NULL, 'Second Semester'),
(179, 261, NULL, NULL, NULL, 'Unpaid', NULL, 'First Semester'),
(180, 261, NULL, NULL, NULL, 'Unpaid', NULL, 'Second Semester'),
(181, 262, NULL, NULL, NULL, 'Unpaid', NULL, 'First Semester'),
(182, 262, NULL, NULL, NULL, 'Unpaid', NULL, 'Second Semester'),
(183, 263, NULL, NULL, NULL, 'Unpaid', NULL, 'First Semester'),
(184, 263, NULL, NULL, NULL, 'Unpaid', NULL, 'Second Semester'),
(185, 264, NULL, NULL, NULL, 'Unpaid', NULL, 'First Semester'),
(186, 264, NULL, NULL, NULL, 'Unpaid', NULL, 'Second Semester');

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
(78, 4, 'manon-og', 'marlo', 'baylen', '09531331877', '2009-11-10', 15, 'Second Year', NULL, 'Active'),
(79, 1, 'test', 'student', '', '09523187831', '2009-11-14', 15, 'First Year', 'A', 'Active'),
(80, 2, 'test', 'ako', 'test', '09531331877', '2009-11-19', 15, 'Third Year', 'B', 'Active'),
(81, 3, 'test_name', 'test_pass', 'hello po', '0976182746', '2009-11-18', 15, 'Second Year', NULL, 'Active'),
(88, 1, 'manon-og', 'marlo', 'baylen', '09531331877', '2009-11-01', 15, 'First Year', 'A', 'Active'),
(89, 2, 'guanzon', 'maria', 'm', '09531331877', '2009-11-01', 15, 'Second Year', 'A', 'Active'),
(90, 3, 'inin', 'inandout', 'baylen', '09263727924', '2009-11-17', 15, 'Second Year', NULL, 'Active'),
(91, 4, 'marlo', 'amount', 'amount', '09531331877', '2009-11-01', 15, 'Second Year', NULL, 'Active');

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
(249, 88, 1),
(250, 88, 2),
(251, 88, 9),
(252, 88, 10),
(253, 89, 1),
(254, 89, 2),
(255, 89, 9),
(256, 89, 10),
(257, 90, 1),
(258, 90, 2),
(259, 90, 9),
(260, 90, 10),
(261, 91, 1),
(262, 91, 2),
(263, 91, 9),
(264, 91, 10);

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
(78, 'hz202301575@wmsu.edu.ph', '$2y$10$TSKLV7vEdMeDurUZ/l47gOIdRLQuTDbL3redBYUoESXhbEb1J0KS6', '2024-11-22', '2024-11-22 15:08:21', 1, 0, 0),
(79, 'hello@gmail.com', '$2y$10$j1oMdhpQlnPqxDq9iMrjfOdbtMnUpGPX3BRWrrHYBxi8BAUDgs6Z.', '2024-11-23', '2024-11-23 02:18:21', 1, 1, 0),
(80, 'hz202307564@wmsu.edu.ph', '$2y$10$MENnUtmJuIdGMi3fuNcx4eZWVDjQ1Rx6IxoLu0igz99ivc0k62wfa', '2024-11-24', '2024-11-24 10:44:13', 1, 1, 0),
(81, 'test@gmail.com', '$2y$10$I6Dm4jSsWj3nCAp8yW.ZbOQqdfxoq7UoRSWOmCwHqlQd3ZWmt7j/q', '2024-11-24', '2024-11-24 10:45:01', 1, 1, 0),
(88, 'hii@gmail.com', '$2y$10$E0KAkkwvqvbOyV7.MzOIj.JELokebObn.K7z6/Wb9MI9BBrX2KwdG', '2024-11-25', '2024-11-25 09:51:19', 1, 1, 0),
(89, 'hiipo@gmail.com', '$2y$10$CzgttnfmE59rukXtx1X.weHfi0R1N2fnocT1uViNweomlF2QKH4Ku', '2024-11-25', '2024-11-25 09:52:01', 1, 1, 0),
(90, 'hellopo@gmail.com', '$2y$10$wjP1LAGI3sRmzKf.ER62i.ODVx0aZdtj5gqpuxjxJjAS8/jXfCvHq', '2024-11-25', '2024-11-25 09:53:21', 1, 1, 0),
(91, 'luyahan@gmail.com', '$2y$10$1eiefxjQeB1meuWQmDfKhu8zSYEAWJj9cs/5AvEJk/SD/erooBMS2', '2024-11-25', '2024-11-25 09:56:58', 1, 1, 0);

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
  MODIFY `organization_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `payment`
--
ALTER TABLE `payment`
  MODIFY `payment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=187;

--
-- AUTO_INCREMENT for table `student_organization`
--
ALTER TABLE `student_organization`
  MODIFY `stud_org_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=265;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=92;

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
