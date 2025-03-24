-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 24, 2025 at 09:22 AM
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
-- Database: `user_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `classes`
--

CREATE TABLE `classes` (
  `c_id` int(11) NOT NULL,
  `className` varchar(255) NOT NULL,
  `classCode` varchar(10) NOT NULL,
  `created_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `classes`
--

INSERT INTO `classes` (`c_id`, `className`, `classCode`, `created_by`) VALUES
(6, 'french', '1B766E', 3),
(7, 'maths', 'C11DE8', 3),
(8, 'science', '83911A', 3),
(9, 'english1', 'C254BC', 4),
(10, 'science', '5EFDAC', 4),
(11, 'php course', '61F896', 5),
(12, 'Anatomy', '179B60', 6);

-- --------------------------------------------------------

--
-- Table structure for table `class_members`
--

CREATE TABLE `class_members` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `class_id` int(11) NOT NULL,
  `joined_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `class_members`
--

INSERT INTO `class_members` (`id`, `user_id`, `class_id`, `joined_at`) VALUES
(1, 5, 8, '2025-03-22 18:28:52'),
(2, 5, 6, '2025-03-24 03:34:15'),
(3, 6, 11, '2025-03-24 06:59:13'),
(4, 5, 12, '2025-03-24 07:48:26');

-- --------------------------------------------------------

--
-- Table structure for table `notes`
--

CREATE TABLE `notes` (
  `noteId` int(11) NOT NULL,
  `noteTitle` varchar(255) NOT NULL,
  `filePath` varchar(255) NOT NULL,
  `uploadedBy` int(11) NOT NULL,
  `classId` int(11) NOT NULL,
  `uploadDate` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `notes`
--

INSERT INTO `notes` (`noteId`, `noteTitle`, `filePath`, `uploadedBy`, `classId`, `uploadDate`) VALUES
(6, 'contact design', 'uploads/contact pg.png', 5, 11, '2025-03-24 04:12:51'),
(10, 'colour palette', 'uploads/WhatsApp Image 2025-03-21 at 23.06.42_7d2ebf37.jpg', 5, 11, '2025-03-24 05:53:33'),
(11, 'home pg design', 'uploads/1.png', 5, 11, '2025-03-24 06:06:12'),
(28, 'footer', 'uploads/4.png', 5, 11, '2025-03-24 06:21:39');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(50) NOT NULL,
  `name` varchar(225) NOT NULL,
  `email` varchar(225) NOT NULL,
  `password` varchar(225) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`) VALUES
(1, 'amna', 'amnamuzavor@gmail.com', '$2y$10$tjzvIEBu9hb/SH3g.BBvrOPaV5Z57a6X1i3VAEl9ns.F8N5/zVWgW'),
(2, 'sam', 'sam@gmail.com', '$2y$10$76CyrpWK52xUp7cQO.Azs.NdTt2JaeTyGM6PFER4ZEFQf5b7DVwqu'),
(3, 'sameena', 's@gmail.com', '$2y$10$2WWgCAJd7RpiomrWAClNK.Xd9Mt/JaB1P3DK6HuhrT7amlPUe//SC'),
(4, 'amna', 'am@gmail.com', '$2y$10$BIh3/0QzEmT3GFh0bedtDuFrMpLYoXZWVilIYbYFMaeo3St3gbnKi'),
(5, 'preet', 'preetgaude@gmail.com', '$2y$10$PlLCih/6t.P7gnwtBhLDdOBJW3ZhSEmRyfuYsor7Zop5BBAx5fAUy'),
(6, 'presha', 'bh@gmail', '$2y$10$lBnR3iX810nMTkzEWRepKuP0cG/KnApIAyARAhurIeffNVbxJK/pO');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `classes`
--
ALTER TABLE `classes`
  ADD PRIMARY KEY (`c_id`),
  ADD UNIQUE KEY `classcode` (`classCode`),
  ADD KEY `created_by` (`created_by`);

--
-- Indexes for table `class_members`
--
ALTER TABLE `class_members`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `class_id` (`class_id`);

--
-- Indexes for table `notes`
--
ALTER TABLE `notes`
  ADD PRIMARY KEY (`noteId`),
  ADD KEY `uploadedBy` (`uploadedBy`),
  ADD KEY `classId` (`classId`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `classes`
--
ALTER TABLE `classes`
  MODIFY `c_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `class_members`
--
ALTER TABLE `class_members`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `notes`
--
ALTER TABLE `notes`
  MODIFY `noteId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `classes`
--
ALTER TABLE `classes`
  ADD CONSTRAINT `classes_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`);

--
-- Constraints for table `class_members`
--
ALTER TABLE `class_members`
  ADD CONSTRAINT `class_members_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `class_members_ibfk_2` FOREIGN KEY (`class_id`) REFERENCES `classes` (`c_id`) ON DELETE CASCADE;

--
-- Constraints for table `notes`
--
ALTER TABLE `notes`
  ADD CONSTRAINT `notes_ibfk_1` FOREIGN KEY (`uploadedBy`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `notes_ibfk_2` FOREIGN KEY (`classId`) REFERENCES `classes` (`c_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
