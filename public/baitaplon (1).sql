-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: baitaplon
-- Generation Time: Nov 03, 2021 at 02:16 PM
-- Server version: 5.7.35
-- PHP Version: 7.4.20

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `baitaplon`
--

-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

CREATE TABLE `groups` (
  `group_id` int(11) NOT NULL,
  `group_name` varchar(255) NOT NULL,
  `group_description` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `groups`
--

INSERT INTO `groups` (`group_id`, `group_name`, `group_description`) VALUES
(1, 'Front End Developer 4', 'Front end developer'),
(2, 'Backend Developer', 'Backend Developer'),
(5, 'Tester', 'Tester'),
(6, 's', 'ds');

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `noti_id` int(11) NOT NULL,
  `notification_title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `notification_detail` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `notification_type` int(11) NOT NULL,
  `send_user` int(11) NOT NULL,
  `send_group` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`noti_id`, `notification_title`, `notification_detail`, `notification_type`, `send_user`, `send_group`, `created_at`) VALUES
(7, 'Shop edidiset go live', 'Add .disabled to a .list-group-item to make it appear disabled. Note that some elements with .disabled will also require custom JavaScript to fully disable their click events (e.g., links).\n\n', 1, 0, 0, '2021-11-01 14:00:23'),
(8, 'Thoong baso thu nha', '', 1, 5, 1, '2021-11-01 14:05:26'),
(9, 'Thong bao cho tri', 'asdadsasdasd', 1, 5, 0, '2021-11-01 14:05:34');

-- --------------------------------------------------------

--
-- Table structure for table `tasks`
--

CREATE TABLE `tasks` (
  `id` int(11) NOT NULL,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('Created','Todo','Doing','QA','Done') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Created',
  `deadline_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(11) NOT NULL,
  `assign_user` int(11) NOT NULL,
  `assign_group` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tasks`
--

INSERT INTO `tasks` (`id`, `title`, `description`, `status`, `deadline_at`, `created_at`, `updated_at`, `created_by`, `assign_user`, `assign_group`) VALUES
(29, '2', 'Template Sign In ', 'Done', '2021-11-03 16:07:35', '2021-11-01 14:24:49', '2021-11-03 13:56:46', 5, 0, 1),
(32, '3', 'Template Sign In page', 'Doing', '2021-11-01 16:07:36', '2021-11-01 14:55:09', '2021-11-01 14:59:43', 5, 0, 1),
(33, 'Template Sign Page 1', 'Template Sign Page 1', 'Created', '2021-11-03 16:07:37', '2021-11-01 15:32:06', '2021-11-01 16:16:34', 5, 7, 0),
(34, 'Template Landing Page', 'Template Landing Page', 'Created', '2021-11-03 23:58:23', '2021-11-01 16:58:25', '2021-11-01 16:58:25', 5, 7, 0),
(35, 'asdfasdfasdfs', 'fasfasfasdf', 'Created', '2021-11-03 21:04:06', '2021-11-01 17:00:04', '2021-11-01 17:00:04', 5, 0, 0),
(36, 'Template Sign In pgae q23jk12j', 'Template Sign In pgae q23jk12j', 'Created', '2021-11-05 00:03:48', '2021-11-01 17:00:46', '2021-11-01 17:03:54', 5, 7, 0),
(37, 'Facebook helps you', 'Facebook helps you connect and share with the people in your life.\n', 'Created', '2021-11-04 00:06:43', '2021-11-01 17:05:30', '2021-11-01 17:06:46', 5, 7, 0);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) NOT NULL,
  `fullName` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `birthday` date NOT NULL,
  `groupId` int(11) DEFAULT '99',
  `role` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `email`, `fullName`, `birthday`, `groupId`, `role`) VALUES
(5, 'admin', '292aabe9b3b4583d81068ad544521d82', 'admin@nguyentri.me', ' Văn Trí', '2021-11-02', 2, 1),
(7, 'user1', '3378506e848caec60d917c0d0a3f603b', 'trideptrai1@kajsd.com', 'User 1', '0000-00-00', 99, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `groups`
--
ALTER TABLE `groups`
  ADD PRIMARY KEY (`group_id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`noti_id`);

--
-- Indexes for table `tasks`
--
ALTER TABLE `tasks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `groups`
--
ALTER TABLE `groups`
  MODIFY `group_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `noti_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `tasks`
--
ALTER TABLE `tasks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
