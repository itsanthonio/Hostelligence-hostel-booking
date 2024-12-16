-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: Dec 14, 2024 at 04:39 PM
-- Server version: 8.0.35
-- PHP Version: 8.2.20

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `hostel`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int NOT NULL,
  `username` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `password` varchar(300) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `reg_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updation_date` timestamp NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `email`, `password`, `reg_date`, `updation_date`) VALUES
(1, 'admin', 'vera@ashesi.com', 'Test123', '2016-04-04 20:31:45', '2024-12-02 11:01:14');

-- --------------------------------------------------------

--
-- Table structure for table `adminlog`
--

CREATE TABLE `adminlog` (
  `id` int NOT NULL,
  `adminid` int NOT NULL,
  `ip` varbinary(16) NOT NULL,
  `logintime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `major`
--

CREATE TABLE `major` (
  `id` int NOT NULL,
  `major_code` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `major_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `posting_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `major`
--

INSERT INTO `major` (`id`, `major_code`, `major_name`, `posting_date`) VALUES
(1, 'CS001', 'Computer Science', '2016-04-11 19:31:42'),
(2, 'BA001', 'Business Administration', '2016-04-11 19:32:46'),
(3, 'ENG001', 'Engineering', '2016-04-11 19:33:23');

-- --------------------------------------------------------

--
-- Table structure for table `registration`
--

CREATE TABLE `registration` (
  `id` int NOT NULL,
  `roomno` int NOT NULL,
  `seater` int NOT NULL,
  `feespm` int NOT NULL,
  `stayfrom` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `duration` int NOT NULL,
  `course` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `regno` int NOT NULL,
  `firstName` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `middleName` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `lastName` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `gender` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `contactno` bigint NOT NULL,
  `emailid` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `guardianName` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `guardianRelation` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `guardianContactno` bigint NOT NULL,
  `postingDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updationDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `registration`
--

INSERT INTO `registration` (`id`, `roomno`, `seater`, `feespm`, `stayfrom`, `duration`, `course`, `regno`, `firstName`, `middleName`, `lastName`, `gender`, `contactno`, `emailid`, `guardianName`, `guardianRelation`, `guardianContactno`, `postingDate`, `updationDate`) VALUES
(6, 100, 5, 100, '2016-04-22 00:00:00', 5, 'Engineering', 10806121, 'Kwame', '', 'Mensah', 'male', 8285703354, 'kwame.mensah@gmail.com', 'Abena', 'Mother', 8285703354, '2016-04-16 08:24:09', '2024-12-12 14:22:53'),
(8, 112, 3, 4000, '2016-06-27 00:00:00', 5, 'Business Administration', 102355, 'Yaw', 'Adu', 'Poku', 'male', 6786786786, 'yaw.poku@gmail.com', 'Esi', 'Guardian', 1234567890, '2016-06-26 16:31:08', '2016-06-26 16:31:08'),
(9, 132, 5, 2000, '2016-06-28 00:00:00', 6, 'Engineering', 586952, 'Ama', '', 'Sarpong', 'female', 8596185625, 'ama.sarpong@gmail.com', 'Kwesi', 'Uncle', 8285703354, '2016-06-26 16:40:07', '2016-06-26 16:40:07'),
(10, 100, 5, 100, '2016-06-17 00:00:00', 4, 'Computer Science', 108061211, 'Kofi', 'Agyei', 'Osei', 'male', 8467067344, 'kofi.osei@gmail.com', 'Akosua', 'Father', 9999857868, '2016-06-23 11:54:35', '2024-12-14 12:48:05');

-- --------------------------------------------------------

--
-- Table structure for table `rooms`
--

CREATE TABLE `rooms` (
  `id` int NOT NULL,
  `seater` int NOT NULL,
  `room_no` int NOT NULL,
  `fees` int NOT NULL,
  `posting_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `rooms`
--

INSERT INTO `rooms` (`id`, `seater`, `room_no`, `fees`, `posting_date`) VALUES
(1, 5, 100, 100, '2016-04-11 22:45:43'),
(2, 2, 201, 6000, '2016-04-12 01:30:47'),
(3, 2, 200, 6000, '2016-04-12 01:30:58'),
(4, 1, 112, 4000, '2016-04-12 01:31:07'),
(5, 2, 132, 2000, '2016-04-12 01:31:15'),
(6, 1, 101, 4500, '2024-12-12 18:33:55');

-- --------------------------------------------------------

--
-- Table structure for table `room_images`
--

CREATE TABLE `room_images` (
  `id` int NOT NULL,
  `room_id` int NOT NULL,
  `image_url` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `room_images`
--

INSERT INTO `room_images` (`id`, `room_id`, `image_url`, `created_at`) VALUES
(1, 1, 'https://img.freepik.com/premium-photo/realistic-mockup-3d-rendered-interior-modern-living-room-with-sofa-couch-table_3146-2106.jpg?w=900', '2024-12-14 11:14:56'),
(2, 1, 'https://img.freepik.com/free-photo/white-bath-towel-table_74190-7887.jpg?t=st=1734174804~exp=1734178404~hmac=664a64a24bbb31c8c93133742b32ca8fd084c4c7d63c1b15543d795c42f7c16b&w=826', '2024-12-14 11:14:56'),
(3, 1, 'https://img.freepik.com/free-photo/white-toilet-bowl-seat_74190-8115.jpg?t=st=1734174870~exp=1734178470~hmac=dff6cd01db59413ccf4dbc474faf54a0cbb9ebf3e583180706256662194b7e95&w=826', '2024-12-14 11:14:56');

-- --------------------------------------------------------

--
-- Table structure for table `userlog`
--

CREATE TABLE `userlog` (
  `id` int NOT NULL,
  `userId` int NOT NULL,
  `userEmail` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `userIp` varbinary(16) NOT NULL,
  `loginTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `userlog`
--

INSERT INTO `userlog` (`id`, `userId`, `userEmail`, `userIp`, `loginTime`) VALUES
(1, 10, 'kofi.osei@gmail.com', '', '2016-06-22 06:16:42'),
(2, 10, 'kofi.osei@gmail.com', '', '2016-06-24 11:20:28'),
(4, 10, 'kofi.osei@gmail.com', 0x3a3a31, '2016-06-24 11:22:47'),
(5, 10, 'kofi.osei@gmail.com', 0x3a3a31, '2016-06-26 15:37:40'),
(6, 20, 'ama.sarpong@gmail.com', 0x3a3a31, '2016-06-26 16:40:57'),
(7, 10, 'kofi.osei@gmail.com', 0x3a3a31, '2024-11-23 04:03:34'),
(8, 10, 'kofi.osei@gmail.com', 0x3a3a31, '2024-12-12 12:30:37'),
(9, 10, 'kofi.osei@gmail.com', 0x3a3a31, '2024-12-12 12:30:54'),
(10, 10, 'kofi.osei@gmail.com', 0x3a3a31, '2024-12-12 12:32:28'),
(11, 10, 'kofi.osei@gmail.com', 0x3a3a31, '2024-12-12 13:12:54'),
(12, 10, 'kofi.osei@gmail.com', 0x3a3a31, '2024-12-12 13:22:10'),
(13, 10, 'kofi.osei@gmail.com', 0x3a3a31, '2024-12-12 13:47:06'),
(14, 10, 'kofi.osei@gmail.com', 0x3a3a31, '2024-12-12 13:58:17'),
(15, 10, 'kofi.osei@gmail.com', 0x3a3a31, '2024-12-12 13:58:33'),
(16, 10, 'kofi.osei@gmail.com', 0x3a3a31, '2024-12-12 13:58:57'),
(17, 10, 'kofi.osei@gmail.com', 0x3a3a31, '2024-12-12 14:37:13'),
(18, 10, 'kofi.osei@gmail.com', 0x3a3a31, '2024-12-12 17:22:21'),
(19, 10, 'kofi.osei@gmail.com', 0x3a3a31, '2024-12-12 18:54:32'),
(20, 10, 'kofi.osei@gmail.com', 0x3a3a31, '2024-12-12 18:59:49'),
(21, 10, 'kofi.osei@gmail.com', 0x3a3a31, '2024-12-14 10:08:25'),
(22, 10, 'kofi.osei@gmail.com', 0x3a3a31, '2024-12-14 10:24:12'),
(23, 10, 'kofi.osei@gmail.com', 0x3a3a31, '2024-12-14 13:15:07'),
(24, 10, 'kofi.osei@gmail.com', 0x3a3a31, '2024-12-14 13:15:43'),
(25, 10, 'kofi.osei@gmail.com', 0x3a3a31, '2024-12-14 13:25:33'),
(26, 10, 'kofi.osei@gmail.com', 0x3a3a31, '2024-12-14 13:35:47'),
(27, 19, 'steve.adetunji@gmail.com', 0x3a3a31, '2024-12-14 14:46:26'),
(28, 21, 'vera@ash.com', 0x3a3a31, '2024-12-14 15:22:30'),
(29, 10, 'kofi.osei@gmail.com', 0x3a3a31, '2024-12-14 15:23:12'),
(30, 10, 'kofi.osei@gmail.com', 0x3a3a31, '2024-12-14 15:28:33'),
(31, 21, 'vera@ash.com', 0x3a3a31, '2024-12-14 15:38:59');

-- --------------------------------------------------------

--
-- Table structure for table `userregistration`
--

CREATE TABLE `userregistration` (
  `id` int NOT NULL,
  `regNo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `firstName` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `middleName` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `lastName` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `gender` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `contactNo` bigint NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `regDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updationDate` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `passUdateDate` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `userregistration`
--

INSERT INTO `userregistration` (`id`, `regNo`, `firstName`, `middleName`, `lastName`, `gender`, `contactNo`, `email`, `password`, `regDate`, `updationDate`, `passUdateDate`) VALUES
(10, '108061211', 'Kwaku', 'Atta', 'Osei', 'male', 594954506, 'kofi.osei@gmail.com', 'test123', '2024-12-14 15:07:30', '2024-12-14 18:53:59', '2024-12-12 19:15:50'),
(19, '102355', 'Steve', '', 'Adetunji', 'male', 6786786786, 'steve.adetunji@gmail.com', '6786786786', '2024-12-14 15:07:30', NULL, NULL),
(21, '232333', 'Vera', 'Honam', 'Anthonio', 'female', 594954506, 'vera@ash.com', 'mytest', '2024-12-14 15:21:41', '2024-12-14 15:21:41', '2024-12-14 15:21:41');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `major`
--
ALTER TABLE `major`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `registration`
--
ALTER TABLE `registration`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rooms`
--
ALTER TABLE `rooms`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `room_images`
--
ALTER TABLE `room_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `room_id` (`room_id`);

--
-- Indexes for table `userlog`
--
ALTER TABLE `userlog`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `userregistration`
--
ALTER TABLE `userregistration`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `major`
--
ALTER TABLE `major`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `registration`
--
ALTER TABLE `registration`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `rooms`
--
ALTER TABLE `rooms`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `room_images`
--
ALTER TABLE `room_images`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `userlog`
--
ALTER TABLE `userlog`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `userregistration`
--
ALTER TABLE `userregistration`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `room_images`
--
ALTER TABLE `room_images`
  ADD CONSTRAINT `room_images_ibfk_1` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
