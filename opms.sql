-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Dec 02, 2024 at 03:19 PM
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
(1, 'admin', '$2y$10$87RfoQxL13LD9xgxvQvEz.7AfxpXeAqCdQxPmd3bYEjqp1orUfZTC', '2024-12-01 13:35:50');

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
(118, 45, 4, 'Kulong', 'Rone', '', '09768548923', '2003-02-04', 21, 'Second Year', 'None', 'Active', 1, 0, 0),
(119, 44, 2, 'Zamora', 'Test', 'D', '09876546754', '1999-05-12', 25, 'Third Year', 'C', 'Active', 1, 0, 0);

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
  `optional_fee` decimal(10,2) NOT NULL DEFAULT 0.00,
  `total_collected` decimal(10,2) DEFAULT 0.00,
  `total_optional_collected` decimal(10,2) NOT NULL DEFAULT 0.00,
  `pending_balance` decimal(10,2) DEFAULT 0.00,
  `pending_optional_balance` decimal(10,2) NOT NULL,
  `created_date` date NOT NULL,
  `last_updated` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `contact_email` varchar(100) NOT NULL,
  `status` enum('Active','Inactive') NOT NULL DEFAULT 'Active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `organization`
--

INSERT INTO `organization` (`organization_id`, `org_name`, `admin_id`, `org_description`, `required_fee`, `optional_fee`, `total_collected`, `total_optional_collected`, `pending_balance`, `pending_optional_balance`, `created_date`, `last_updated`, `contact_email`, `status`) VALUES
(1, 'Venom Publication', 1, '', 70.00, 0.00, 0.00, 0.00, 210.00, 0.00, '2019-10-01', '2024-12-02 12:27:24', '', 'Active'),
(2, 'Gender Club', 1, '', 150.00, 0.00, 252.00, 0.00, 498.00, 0.00, '2019-05-02', '2024-12-02 12:27:24', '', 'Active'),
(44, 'College Student Council', 1, 'wala', 65.00, 0.00, 65.00, 0.00, 260.00, 0.00, '2024-11-27', '2024-12-02 12:27:24', 'csc@email.com', 'Active'),
(45, 'PSITS', 1, 'test', 200.00, 0.00, 12.00, 0.00, 988.00, 0.00, '2024-11-27', '2024-12-02 12:27:24', 'test@test.com', 'Active'),
(46, 'PhiCCS', 1, 'test', 200.00, 0.00, 0.00, 0.00, 1000.00, 0.00, '2024-11-27', '2024-12-02 12:27:24', 'phicss@gmail.com', 'Active');

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
(339, 355, NULL, 1, 0.00, 'Paid', '2024-11-26', 'First Semester', 0),
(341, 356, NULL, 1, 0.00, 'Paid', '2024-11-27', 'First Semester', 0),
(343, 357, NULL, 1, 0.00, 'Paid', '2024-11-26', 'First Semester', 0),
(345, 358, NULL, 1, 48.00, 'Unpaid', '2024-11-26', 'First Semester', 0),
(347, 359, NULL, 1, 0.00, 'Paid', '2024-11-28', 'First Semester', 0),
(349, 360, NULL, NULL, 65.00, 'Unpaid', NULL, 'First Semester', 0),
(351, 362, NULL, 1, 188.00, 'Unpaid', '2024-11-27', 'First Semester', 0),
(353, 363, NULL, NULL, 200.00, 'Unpaid', NULL, 'First Semester', 0),
(355, 365, NULL, NULL, 200.00, 'Unpaid', NULL, 'First Semester', 0),
(357, 366, NULL, NULL, 200.00, 'Unpaid', NULL, 'First Semester', 0),
(359, 367, NULL, NULL, 70.00, 'Unpaid', NULL, 'First Semester', 0),
(361, 368, NULL, NULL, 150.00, 'Unpaid', NULL, 'First Semester', 0),
(363, 369, NULL, NULL, 65.00, 'Unpaid', NULL, 'First Semester', 0),
(365, 370, NULL, NULL, 200.00, 'Unpaid', NULL, 'First Semester', 0),
(367, 371, NULL, NULL, 200.00, 'Unpaid', NULL, 'First Semester', 0),
(369, 372, NULL, NULL, 70.00, 'Unpaid', NULL, 'First Semester', 0),
(371, 373, NULL, NULL, 150.00, 'Unpaid', NULL, 'First Semester', 0),
(373, 374, NULL, NULL, 65.00, 'Unpaid', NULL, 'First Semester', 0),
(375, 375, NULL, NULL, 200.00, 'Unpaid', NULL, 'First Semester', 0),
(377, 376, NULL, NULL, 200.00, 'Unpaid', NULL, 'First Semester', 0),
(379, 377, NULL, NULL, 70.00, 'Unpaid', NULL, 'First Semester', 0),
(381, 378, NULL, NULL, 150.00, 'Unpaid', NULL, 'First Semester', 0),
(383, 379, NULL, NULL, 65.00, 'Unpaid', NULL, 'First Semester', 0),
(385, 380, NULL, NULL, 200.00, 'Unpaid', NULL, 'First Semester', 0),
(387, 381, NULL, NULL, 200.00, 'Unpaid', NULL, 'First Semester', 0);

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
(1, 339, 'Admin', 12.00, '2024-11-26 10:51:23'),
(3, 343, 'Admin', 12.00, '2024-11-26 12:37:25'),
(4, 343, 'Admin', 58.00, '2024-11-26 12:38:05'),
(5, 345, 'Admin', 102.00, '2024-11-26 13:34:08'),
(6, 347, 'Admin', 50.00, '2024-11-27 01:52:13'),
(7, 341, 'Admin', 69.00, '2024-11-27 03:02:03'),
(8, 341, 'Admin', 69.00, '2024-11-27 03:02:05'),
(9, 341, 'Admin', 12.00, '2024-11-27 03:03:02'),
(10, 351, 'Admin', 12.00, '2024-11-27 03:26:56'),
(11, 347, 'Admin', 15.00, '2024-11-28 03:07:00');

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
(115, 1, 'Manon-og', 'marlo', 'Baylen', '09531331877', '2009-11-03', 15, 'Second Year', 'C', 'Dropped'),
(116, 2, 'Guanzon', 'Maria', 'hello', '09531331877', '2009-11-01', 15, 'First Year', 'C', 'Graduated'),
(117, 3, 'Ramillano', 'Austin Kelly', '', '09567435678', '2009-11-01', 15, 'Second Year', 'None', 'Enrolled'),
(118, 4, 'Kulong', 'Rone', '', '09768548923', '2003-02-04', 21, 'Second Year', 'None', 'Enrolled'),
(119, 2, 'Zamora', 'Test', 'D', '09876546754', '1999-05-12', 25, 'Third Year', 'C', 'Enrolled');

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
(356, 115, 2),
(357, 116, 1),
(358, 116, 2),
(359, 115, 44),
(360, 116, 44),
(362, 115, 45),
(363, 116, 45),
(365, 115, 46),
(366, 116, 46),
(367, 117, 1),
(368, 117, 2),
(369, 117, 44),
(370, 117, 45),
(371, 117, 46),
(372, 118, 1),
(373, 118, 2),
(374, 118, 44),
(375, 118, 45),
(376, 118, 46),
(377, 119, 1),
(378, 119, 2),
(379, 119, 44),
(380, 119, 45),
(381, 119, 46);

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
(115, 'gumanakana@gmail.com', '$2y$10$pgguS0Yb7Bzl/KK/A31IT.2WPYE9wCQVgg5yihsB5F0wnldm7llSe', '2024-11-26', '2024-11-27 04:44:37', 1, 1, 0),
(116, 'hz202301575@wmsu.edu.ph', '$2y$10$DXzQ/sOpHPKZgk0UWh9XbuVt5rhqekOcR8nRGEB4vUni/Sd6JfWlO', '2024-11-26', '2024-11-26 13:36:57', 1, 1, 0),
(117, 'hz201501575@wmsu.edu.ph', '$2y$10$n/KcxZh5Qp1RBU9aieHVkuPXu.nW6FM8nk4yDSZ5l2VuyjqYyxuvG', '2024-11-30', '2024-11-30 14:50:30', 1, 1, 0),
(118, 'hz202101575@wmsu.edu.ph', '$2y$10$xlfw6X.0ljwCw.V4s4whRe0mNHJ.JoJNLLpcwpFAQxmogNKHhqk1m', '2024-11-30', '2024-11-30 15:16:16', 1, 1, 1),
(119, 'hz2023057834@wmsu.edu.ph', '$2y$10$9Rc3uHXS/2jcgDLLrMUMIuqey1a6rY9ltJ1gsD9crMXBkZUctD7hC', '2024-12-02', '2024-12-02 13:27:24', 1, 1, 1);

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
  MODIFY `organization_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT for table `payment`
--
ALTER TABLE `payment`
  MODIFY `payment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=389;

--
-- AUTO_INCREMENT for table `payment_history`
--
ALTER TABLE `payment_history`
  MODIFY `payment_history_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `student_organization`
--
ALTER TABLE `student_organization`
  MODIFY `stud_org_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=382;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=120;

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
