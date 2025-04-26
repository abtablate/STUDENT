-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 26, 2025 at 04:25 PM
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
-- Database: `studentenroll`
--

-- --------------------------------------------------------

--
-- Table structure for table `course`
--

CREATE TABLE `course` (
  `COURSEID` int(11) NOT NULL,
  `COURSE_CODE` varchar(255) DEFAULT NULL,
  `COURSE_DESCRIPTION` varchar(255) DEFAULT NULL,
  `UNITS` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `course`
--

INSERT INTO `course` (`COURSEID`, `COURSE_CODE`, `COURSE_DESCRIPTION`, `UNITS`) VALUES
(101, 'CS101', 'Introduction to Programming', '3'),
(102, 'ENG201', 'English Literature', '2'),
(103, 'CC225', 'Information Management', '3'),
(104, 'UTS', 'Understanding the self', '3'),
(105, 'COMPROG1', 'Computer Programming 1', '3');

-- --------------------------------------------------------

--
-- Table structure for table `enrollment`
--

CREATE TABLE `enrollment` (
  `ENROLLMENTID` int(11) NOT NULL,
  `ENROLLMENT_DATE` varchar(255) DEFAULT NULL,
  `STUDENTID` int(11) DEFAULT NULL,
  `COURSEID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `enrollment`
--

INSERT INTO `enrollment` (`ENROLLMENTID`, `ENROLLMENT_DATE`, `STUDENTID`, `COURSEID`) VALUES
(1001, '2024-06-01', 1, 101),
(1002, '2024-06-01', 2, 102),
(1003, '2023-12-1', 2, 102),
(1005, '2022-11-9', 5, 104),
(1006, '2022-6-1', 5, 104),
(1007, '2025-2-1', 3, 104),
(1008, '2023-12-1', 6, 105);

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE `student` (
  `STUDENTID` int(11) NOT NULL,
  `FIRSTNAME` varchar(255) DEFAULT NULL,
  `LASTNAME` varchar(225) DEFAULT NULL,
  `MIDDLEINITIAL` varchar(255) DEFAULT NULL,
  `EMAIL` varchar(255) DEFAULT NULL,
  `STUDENTTYPE` varchar(255) DEFAULT NULL,
  `YEARofSTUDY` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`STUDENTID`, `FIRSTNAME`, `LASTNAME`, `MIDDLEINITIAL`, `EMAIL`, `STUDENTTYPE`, `YEARofSTUDY`) VALUES
(1, 'Taehyung', 'Kim', ' ', 'kim@example.com', 'Regular', '2nd Year'),
(2, 'Wonwoo', 'Jeon', 'L', 'jeon@example.com', 'Regular', '2nd Year'),
(3, 'Seungkwan', 'Boo', 'M', 'boo@example.com', 'Regular\r\n', '1st Year'),
(5, 'Suga', 'Min', 'Y', 'min@gmail.com', 'Regular', '2nd Year'),
(6, 'Min-Seok', 'Xiu', 'K', 'xiu@gmail.com', 'Regular', '1st year');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `course`
--
ALTER TABLE `course`
  ADD PRIMARY KEY (`COURSEID`);

--
-- Indexes for table `enrollment`
--
ALTER TABLE `enrollment`
  ADD PRIMARY KEY (`ENROLLMENTID`),
  ADD KEY `STUDENTID` (`STUDENTID`),
  ADD KEY `COURSEID` (`COURSEID`);

--
-- Indexes for table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`STUDENTID`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `enrollment`
--
ALTER TABLE `enrollment`
  ADD CONSTRAINT `enrollment_ibfk_1` FOREIGN KEY (`STUDENTID`) REFERENCES `student` (`STUDENTID`),
  ADD CONSTRAINT `enrollment_ibfk_2` FOREIGN KEY (`COURSEID`) REFERENCES `course` (`COURSEID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
