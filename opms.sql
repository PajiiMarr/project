-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Dec 13, 2024 at 03:41 PM
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
-- Table structure for table `adviser`
--

CREATE TABLE `adviser` (
  `adviser_id` int(11) NOT NULL,
  `last_name` varchar(150) NOT NULL,
  `first_name` varchar(150) NOT NULL,
  `middle_name` varchar(150) NOT NULL,
  `sy/sem` varchar(150) NOT NULL,
  `organization_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `adviser`
--

INSERT INTO `adviser` (`adviser_id`, `last_name`, `first_name`, `middle_name`, `sy/sem`, `organization_id`) VALUES
(1, 'Jaafar', 'Rhamirl', '', '2024-2025 First Semester', 57),
(2, 'Sample Gender Club', 'Adviser', '', '2024-2025 First Semester', 2),
(3, 'Sample PHICSS ', 'Adviser', '', '2024-2025 First Semester', 56),
(4, 'Sample Venom Publication', 'Adviser', '', '2024-2025 First Semester', 1);

-- --------------------------------------------------------

--
-- Table structure for table `collection_fees`
--

CREATE TABLE `collection_fees` (
  `collection_id` int(11) NOT NULL,
  `organization_id` int(11) NOT NULL,
  `purpose` varchar(150) NOT NULL DEFAULT '',
  `description` varchar(255) NOT NULL,
  `amount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `total_collected` decimal(10,2) NOT NULL DEFAULT 0.00,
  `pending_balance` decimal(10,2) NOT NULL DEFAULT 0.00,
  `start_date` date NOT NULL,
  `date_due` date DEFAULT NULL,
  `request_status` varchar(20) NOT NULL DEFAULT 'Pending',
  `label` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `collection_fees`
--

INSERT INTO `collection_fees` (`collection_id`, `organization_id`, `purpose`, `description`, `amount`, `total_collected`, `pending_balance`, `start_date`, `date_due`, `request_status`, `label`) VALUES
(36, 2, 'gender club', 'gender club', 123.00, 13.00, 1217.00, '2024-12-13', NULL, 'Approved', 'Required'),
(37, 57, 'test', 'test', 998.00, 0.00, 0.00, '2024-12-13', NULL, 'Declined', 'Required'),
(38, 57, 'test', 'test', 100.00, 0.00, 0.00, '2024-12-13', '2026-06-09', 'Pending', 'Required');

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
(4, 'ACT NT', 'Associate in Computer Technology Major in Networking'),
(5, 'MIT', 'Masters in Information Technology');

-- --------------------------------------------------------

--
-- Table structure for table `facilitator`
--

CREATE TABLE `facilitator` (
  `facilitator_id` int(11) NOT NULL,
  `organization_id` int(11) DEFAULT NULL,
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

INSERT INTO `facilitator` (`facilitator_id`, `organization_id`, `last_name`, `first_name`, `middle_name`, `phone_number`, `dob`, `age`, `course_year`, `course_section`, `status`, `is_head`, `is_assistant_head`, `is_collector`) VALUES
(131, 57, 'Santos', 'Emmanuelle', '', '09876574734', '2009-12-01', 15, 'First Year', 'A', 'Active', 1, 0, 0),
(132, 2, 'Ramillano', 'Austin Kelly', '', '09875463212', '2009-12-01', 15, 'Second Year', 'A', 'Active', 1, 0, 0),
(133, 1, 'Bregundot', 'RIchmond', '', '09876443', '2009-12-01', 15, 'First Year', 'None', 'Active', 1, 0, 0),
(137, 56, 'James', 'LeBron', '', '09876543123', '2009-12-01', 15, 'Second Year', 'None', 'Active', 1, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `officer`
--

CREATE TABLE `officer` (
  `officer_id` int(11) NOT NULL,
  `last_name` varchar(150) NOT NULL,
  `first_name` varchar(150) NOT NULL,
  `middle_name` varchar(150) NOT NULL,
  `position` varchar(100) NOT NULL,
  `organization_id` int(11) NOT NULL,
  `sy/sem` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `officer`
--

INSERT INTO `officer` (`officer_id`, `last_name`, `first_name`, `middle_name`, `position`, `organization_id`, `sy/sem`) VALUES
(1, 'Manon-og', 'Marlo', '', 'President', 57, '2025-2025 First Semester'),
(2, 'Santos', 'Emmanuelle', '', 'Vice President', 57, '2025-2025 First Semester'),
(3, 'Ramillano', 'Austin', '', 'President', 1, '2025-2025 First Semester'),
(4, 'Santos', 'Emmanuelle', '', 'Vice President', 1, '2025-2025 FIrst Semester'),
(5, 'Bregundot', 'Richmond', '', 'President', 2, '2025-2025 FIrst Semester'),
(6, 'Kulong', 'Rone', '', 'Vice President', 2, '2025-2025 FIrst Semester');

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
  `contact_email` varchar(100) NOT NULL DEFAULT 'None',
  `org_status` enum('Active','Deactivated') NOT NULL DEFAULT 'Active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `organization`
--

INSERT INTO `organization` (`organization_id`, `org_name`, `org_description`, `created_date`, `last_updated`, `contact_email`, `org_status`) VALUES
(1, 'Venom Publication', 'Wala lang', '2019-10-01', '2024-12-12 14:49:20', 'testpo@gmail.com', 'Active'),
(2, 'Gender Club', 'Wala lang', '2019-05-02', '2024-12-06 14:27:40', '', 'Active'),
(56, 'PhiCCS', '', '2024-12-13', '2024-12-13 00:52:31', 'None', 'Active'),
(57, 'CSC', '', '2024-12-13', '2024-12-13 00:52:44', 'None', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE `payment` (
  `payment_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `collection_id` int(11) NOT NULL,
  `amount_to_pay` decimal(10,2) NOT NULL,
  `balance` decimal(10,2) NOT NULL DEFAULT 0.00,
  `date_due` date NOT NULL,
  `sy_sem` varchar(50) NOT NULL DEFAULT '2024-2025 First Semester',
  `collection_status` varchar(20) NOT NULL DEFAULT 'Collecting',
  `payment_status` enum('Paid','Unpaid') DEFAULT 'Unpaid',
  `date_of_payment` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payment`
--

INSERT INTO `payment` (`payment_id`, `student_id`, `collection_id`, `amount_to_pay`, `balance`, `date_due`, `sy_sem`, `collection_status`, `payment_status`, `date_of_payment`) VALUES
(581, 131, 36, 123.00, 123.00, '0000-00-00', '2024-2025 First Semester', 'Collecting', 'Unpaid', NULL),
(582, 135, 36, 123.00, 123.00, '0000-00-00', '2024-2025 First Semester', 'Collecting', 'Unpaid', NULL),
(583, 132, 36, 123.00, 123.00, '0000-00-00', '2024-2025 First Semester', 'Collecting', 'Unpaid', NULL),
(584, 136, 36, 123.00, 123.00, '0000-00-00', '2024-2025 First Semester', 'Collecting', 'Unpaid', NULL),
(585, 133, 36, 123.00, 110.00, '0000-00-00', '2024-2025 First Semester', 'Collecting', 'Unpaid', '2024-12-13'),
(586, 137, 36, 123.00, 123.00, '0000-00-00', '2024-2025 First Semester', 'Collecting', 'Unpaid', NULL),
(587, 138, 36, 123.00, 123.00, '0000-00-00', '2024-2025 First Semester', 'Collecting', 'Unpaid', NULL),
(588, 134, 36, 123.00, 123.00, '0000-00-00', '2024-2025 First Semester', 'Collecting', 'Unpaid', NULL),
(589, 130, 36, 123.00, 123.00, '0000-00-00', '2024-2025 First Semester', 'Collecting', 'Unpaid', NULL),
(590, 139, 36, 123.00, 123.00, '0000-00-00', '2024-2025 First Semester', 'Collecting', 'Unpaid', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `payment_history`
--

CREATE TABLE `payment_history` (
  `payment_history_id` int(11) NOT NULL,
  `payment_id` int(11) NOT NULL,
  `facilitator_id` int(11) NOT NULL,
  `amount_paid` decimal(10,2) NOT NULL,
  `date_issued` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payment_history`
--

INSERT INTO `payment_history` (`payment_history_id`, `payment_id`, `facilitator_id`, `amount_paid`, `date_issued`) VALUES
(65, 585, 132, 13.00, '2024-12-13 06:29:36');

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
  `status` enum('Unenrolled','Enrolled','Dropped','Graduated','Undefined') NOT NULL DEFAULT 'Unenrolled'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`student_id`, `course_id`, `last_name`, `first_name`, `middle_name`, `phone_number`, `dob`, `age`, `course_year`, `course_section`, `status`) VALUES
(130, 5, 'Manon-og', 'Marlo', 'B.', '09531331877', '2002-06-03', 22, 'First Year', 'None', 'Unenrolled'),
(131, 1, 'Santos', 'Emmanuelle', '', '09876574734', '2009-12-01', 15, 'First Year', 'A', 'Unenrolled'),
(132, 2, 'Ramillano', 'Austin Kelly', '', '09875463212', '2009-12-01', 15, 'Second Year', 'A', 'Unenrolled'),
(133, 3, 'Bregundot', 'RIchmond', '', '09876443', '2009-12-01', 15, 'First Year', 'None', 'Unenrolled'),
(134, 4, 'Kulong', 'Rone', '', '09875422121', '2002-06-27', 22, 'Second Year', 'None', 'Unenrolled'),
(135, 1, 'Dela Cruz', 'Juan', '', '09876546783', '2005-05-01', 19, 'Second Year', 'B', 'Unenrolled'),
(136, 2, 'Doe', 'John', '', '09876543212', '1999-11-25', 25, 'Second Year', 'B', 'Unenrolled'),
(137, 3, 'James', 'LeBron', '', '09876543123', '2009-12-01', 15, 'Second Year', 'None', 'Unenrolled'),
(138, 3, 'Earnings', 'Kyrie', '', '09876453321', '2009-11-30', 15, 'Second Year', 'None', 'Unenrolled'),
(139, 5, 'Sample', 'Student', '', '09876523123', '2000-05-29', 24, 'Second Year', 'None', 'Unenrolled');

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
(130, 'hz202301575@wmsu.edu.ph', '$2y$10$qq1ZQ5MFOy.9UcnnMy8t0uGwShIdVApyDQrE73kw9jFb2oTSa6HRu', '2024-12-13', '2024-12-12 18:09:50', 0, 1, 0),
(131, 'hz202399999@wmsu.edu.ph', '$2y$10$A3MzrmIYpy2QOlaMGCjRNuZYrwQHhedak4l4XcnOPCbfipHQ3IJbS', '2024-12-13', '2024-12-13 05:58:53', 0, 1, 1),
(132, 'hz202388888@wmsu.edu.ph', '$2y$10$i2BU1MLMzxzsmXcXH.9uMu.lPN.R6HdCuF3aZ0UAxk0e0/EM6N/HS', '2024-12-13', '2024-12-13 05:41:24', 0, 1, 1),
(133, 'hz202377777@wmsu.edu.ph', '$2y$10$M7n3l.81YQIgPGcls0TZjueAdWu1ozyVqynv3RuMvfNKvS.fS8pSe', '2024-12-13', '2024-12-12 17:59:28', 0, 1, 1),
(134, 'hz202266666@wmsu.edu.ph', '$2y$10$2C3TPOM8MRQnks26DR.RduWmIdbW.9.LLE4Cr/zc2sTng9L.iCju6', '2024-12-13', '2024-12-12 17:21:41', 0, 1, 0),
(135, 'hz202322221@wmsu.edu.ph', '$2y$10$kjb3jQXg3G61OljS1S/O0OijzlZcjEpVz4Nmcxr9RenEe3zqYPfU6', '2024-12-13', '2024-12-12 17:22:52', 0, 1, 0),
(136, 'hz2023765432@wmsu.edu.ph', '$2y$10$W10y0Dmr/qZjj8XuTMgjpeBNSQzd9yteSqtZxq9lGumIQSD989GFi', '2024-12-13', '2024-12-12 17:25:59', 0, 1, 0),
(137, 'hz202101575@wmsu.edu.ph', '$2y$10$4NWD72bsU5UbdRxe6sj3HeVa5zR7Tn3gLmn8Hp4Wk5lkxrqJdUAI.', '2024-12-13', '2024-12-12 18:04:20', 0, 1, 1),
(138, 'hz202201575@wmsu.edu.ph', '$2y$10$aSX3OVV7PKsqlcYluTPTke0rpIjJfcB7iuWleoYLaMyr4erkkzn/2', '2024-12-13', '2024-12-12 17:43:29', 0, 1, 0),
(139, 'hz202333375@wmsu.edu.ph', '$2y$10$2sAcFBE94YpFc9U0PDbFPOPVHRbfBdylbnQWQUh4yWjzc8f43WC3C', '2024-12-13', '2024-12-13 00:10:39', 0, 1, 0),
(141, 'admin', '$2y$10$ONJJw.4a/qCY4oTUn7mIh.2XDznZYupuSvlfRRMjHEnz4k2X.ICtC', '2024-12-13', '2024-12-13 07:04:54', 1, 0, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `adviser`
--
ALTER TABLE `adviser`
  ADD PRIMARY KEY (`adviser_id`),
  ADD KEY `organization_id` (`organization_id`);

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
  ADD KEY `fk_facilitator_org` (`organization_id`);

--
-- Indexes for table `officer`
--
ALTER TABLE `officer`
  ADD PRIMARY KEY (`officer_id`),
  ADD KEY `organization_id` (`organization_id`);

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
  ADD KEY `collection_id` (`collection_id`),
  ADD KEY `student_id` (`student_id`);

--
-- Indexes for table `payment_history`
--
ALTER TABLE `payment_history`
  ADD PRIMARY KEY (`payment_history_id`),
  ADD KEY `payment_id` (`payment_id`),
  ADD KEY `facilitator_id` (`facilitator_id`);

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
-- AUTO_INCREMENT for table `adviser`
--
ALTER TABLE `adviser`
  MODIFY `adviser_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `collection_fees`
--
ALTER TABLE `collection_fees`
  MODIFY `collection_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `course`
--
ALTER TABLE `course`
  MODIFY `course_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `officer`
--
ALTER TABLE `officer`
  MODIFY `officer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `organization`
--
ALTER TABLE `organization`
  MODIFY `organization_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT for table `payment`
--
ALTER TABLE `payment`
  MODIFY `payment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=591;

--
-- AUTO_INCREMENT for table `payment_history`
--
ALTER TABLE `payment_history`
  MODIFY `payment_history_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=142;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `adviser`
--
ALTER TABLE `adviser`
  ADD CONSTRAINT `adviser_ibfk_1` FOREIGN KEY (`organization_id`) REFERENCES `organization` (`organization_id`);

--
-- Constraints for table `collection_fees`
--
ALTER TABLE `collection_fees`
  ADD CONSTRAINT `collection_fees_ibfk_1` FOREIGN KEY (`organization_id`) REFERENCES `organization` (`organization_id`);

--
-- Constraints for table `facilitator`
--
ALTER TABLE `facilitator`
  ADD CONSTRAINT `fk_facilitator_org` FOREIGN KEY (`organization_id`) REFERENCES `organization` (`organization_id`),
  ADD CONSTRAINT `fk_facilitator_user` FOREIGN KEY (`facilitator_id`) REFERENCES `user` (`user_id`);

--
-- Constraints for table `officer`
--
ALTER TABLE `officer`
  ADD CONSTRAINT `officer_ibfk_1` FOREIGN KEY (`organization_id`) REFERENCES `organization` (`organization_id`);

--
-- Constraints for table `payment`
--
ALTER TABLE `payment`
  ADD CONSTRAINT `payment_ibfk_1` FOREIGN KEY (`collection_id`) REFERENCES `collection_fees` (`collection_id`),
  ADD CONSTRAINT `payment_ibfk_2` FOREIGN KEY (`student_id`) REFERENCES `student` (`student_id`);

--
-- Constraints for table `payment_history`
--
ALTER TABLE `payment_history`
  ADD CONSTRAINT `payment_history_ibfk_1` FOREIGN KEY (`payment_id`) REFERENCES `payment` (`payment_id`),
  ADD CONSTRAINT `payment_history_ibfk_2` FOREIGN KEY (`facilitator_id`) REFERENCES `facilitator` (`facilitator_id`);

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
