-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 19, 2019 at 10:35 AM
-- Server version: 10.1.38-MariaDB
-- PHP Version: 7.3.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `stcmgt`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_admin`
--

CREATE TABLE `tbl_admin` (
  `admin_id` int(11) NOT NULL,
  `admin_user_name` varchar(100) NOT NULL,
  `admin_password` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_admin`
--

INSERT INTO `tbl_admin` (`admin_id`, `admin_user_name`, `admin_password`) VALUES
(2, 'admin', '$2y$10$/UFxU4iaqvHEU6Hbl3aWheLPE0WUPIUmj3nNuic6nu2rMEhIzUcOC'),
(3, 'Lee', '$2y$10$5WpECVp4cTR81hZBexoEpOxalP0ETRtz4gK/YQfolZTqFShYovYuu');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_attendance`
--

CREATE TABLE `tbl_attendance` (
  `attendance_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `attendance_status` enum('Present','Absent') DEFAULT NULL,
  `attendance_date` date NOT NULL,
  `teacher_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_grade`
--

CREATE TABLE `tbl_grade` (
  `grade_id` int(11) NOT NULL,
  `grade_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_grade`
--

INSERT INTO `tbl_grade` (`grade_id`, `grade_name`) VALUES
(1, '11 - A'),
(2, '11 - B'),
(3, '12 - A'),
(4, '12 - B'),
(6, '11 - C');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_students`
--

CREATE TABLE `tbl_students` (
  `student_id` int(11) NOT NULL,
  `student_name` varchar(150) NOT NULL,
  `student_roll_number` int(11) NOT NULL,
  `student_dob` date NOT NULL,
  `student_grade_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_teacher`
--

CREATE TABLE `tbl_teacher` (
  `teacher_id` int(11) NOT NULL,
  `teacher_name` varchar(100) NOT NULL,
  `teacher_address` text,
  `teacher_emailId` varchar(100) DEFAULT NULL,
  `teacher_password` varchar(100) DEFAULT NULL,
  `teacher_qualification` varchar(100) DEFAULT NULL,
  `teacher_doj` date DEFAULT NULL,
  `teacher_image` varchar(100) DEFAULT NULL,
  `teacher_grade_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_teacher`
--

INSERT INTO `tbl_teacher` (`teacher_id`, `teacher_name`, `teacher_address`, `teacher_emailId`, `teacher_password`, `teacher_qualification`, `teacher_doj`, `teacher_image`, `teacher_grade_id`) VALUES
(1, 'Lew', '2567 Granary Phase 2A Harare', 'honye.lewism@gmail.com', '$2y$10$5WpECVp4cTR81hZBexoEpOxalP0ETRtz4gK/YQfolZTqFShYovYuu', 'Information Tech ', '2019-08-12', 'user.png', 2),
(2, 'Lee', 'hon 23', 'lee@zol.com', '$2y$10$PFhrHg4EvJLQ84gwpnt4P.MRjjdWMVR2E96KnbKgMncllzYLP5e1u', 'Gen Pop', '2019-08-13', '5d52f5692ee26.jpg', 1),
(5, 'Leehon123', 'kwandioba', 'hey@wakuita.here', '$2y$10$LaZo.wA6GuGLaCs5l2ZZ1uc/BZHjv/Jc823yWjqqYGNfgZaM/GR3S', 'hameno hu student', '2019-08-09', '5d5a5b24379e2.jpg', 2),
(6, 'mamukasei', 'nhasi wacho wese', 'killing@it.com', '$2y$10$qGxJcW4xDn30mzx1PM1CS.6EB6fVZKrL6Kk2/g1OFzV7SajxQe.a6', 'look at them', '2019-08-24', '5d5a5c048d993.png', 6),
(7, 'hello world', 'we the newbies', 'start@web.com', '$2y$10$mLQKsUGsD7N9Ab25.YN9x.TnSI5xTWoZDuAjosIvSzNc7heVJA3Du', 'Web junior developer', '2019-08-21', '5d5a5c048d993.png', 1),
(8, 'wayev', 'kayteee weku O ukooo', 'wayev@kayz.net', '$2y$10$j/5Eu6UEtPo9B7s9SKjQY.yW6aFT.R0i3Sz53iPkNB6toX1kKrlL2', 'qualified systems analyst', '2019-01-09', '5d5a5e0e1ec28.png', 3),
(9, 'wayne katuruza', 'anogara ku O ukoo', 'mtarepoly@kaytee.zw', '$2y$10$CheL1xzlt6lbOFbYrgXsTOYfhHEx1DNLd.AXRhMeVOw/p8GNug2ZG', 'Vanoseva amai ivava especially zviya zve code', '2019-01-17', '5d5a5c048d993.png', 4),
(10, 'chekudero', 'inini hamneo zvacho', 'trying@tomakeitwork.pliz', '$2y$10$CFeco0XO3oea.Hx5HK.AFOpOHrzIEwHT32Lh.V/DqRgT55pG6cwjq', 'coding per square day', '2019-08-31', '5d5a5e0e1ec28.png', 4);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_admin`
--
ALTER TABLE `tbl_admin`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `tbl_attendance`
--
ALTER TABLE `tbl_attendance`
  ADD PRIMARY KEY (`attendance_id`);

--
-- Indexes for table `tbl_grade`
--
ALTER TABLE `tbl_grade`
  ADD PRIMARY KEY (`grade_id`);

--
-- Indexes for table `tbl_students`
--
ALTER TABLE `tbl_students`
  ADD PRIMARY KEY (`student_id`),
  ADD UNIQUE KEY `student_roll_number` (`student_roll_number`);

--
-- Indexes for table `tbl_teacher`
--
ALTER TABLE `tbl_teacher`
  ADD PRIMARY KEY (`teacher_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_admin`
--
ALTER TABLE `tbl_admin`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tbl_grade`
--
ALTER TABLE `tbl_grade`
  MODIFY `grade_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tbl_teacher`
--
ALTER TABLE `tbl_teacher`
  MODIFY `teacher_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
