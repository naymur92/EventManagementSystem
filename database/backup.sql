-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jan 29, 2025 at 03:13 AM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ems`
--

-- --------------------------------------------------------

--
-- Table structure for table `attendees`
--

CREATE TABLE `attendees` (
  `attendee_id` bigint UNSIGNED NOT NULL,
  `event_id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `mobile` varchar(15) COLLATE utf8mb4_general_ci NOT NULL,
  `payment_trnx_no` varchar(128) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `payment_amount` int DEFAULT NULL,
  `payment_account_no` varchar(128) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `registration_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` tinyint NOT NULL DEFAULT '1' COMMENT '0=>cancelled, 1=>registered'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `event_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `location` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '',
  `google_map_location` varchar(1024) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `start_time` datetime DEFAULT NULL,
  `end_time` datetime DEFAULT NULL,
  `max_capacity` int UNSIGNED NOT NULL DEFAULT '0',
  `registration_fee` int NOT NULL DEFAULT '0',
  `current_capacity` int UNSIGNED NOT NULL DEFAULT '0',
  `status` tinyint NOT NULL DEFAULT '0' COMMENT '0=>inactive, 1=>active',
  `user_id` bigint UNSIGNED NOT NULL COMMENT 'Host id from users table',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`event_id`, `name`, `location`, `google_map_location`, `description`, `start_time`, `end_time`, `max_capacity`, `registration_fee`, `current_capacity`, `status`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 'Conference', 'Campus', 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d790.2122945870129!2d90.393922331316!3d23.751119177046576!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3755b997dc0f0797%3A0xd1806d5180d36a7d!2sMAF%20Motors%20Limited!5e0!3m2!1sen!2sbd!4v1738077217749!5m2!1sen!2sbd', '&lt;ul&gt;&lt;li&gt;a&lt;/li&gt;&lt;li&gt;b&lt;/li&gt;&lt;li&gt;c&lt;/li&gt;&lt;li&gt;d&lt;/li&gt;&lt;/ul&gt;&lt;p&gt;Payment &lt;br&gt;&lt;/p&gt;', '2025-02-05 10:15:00', '2025-02-08 10:15:00', 500, 2000, 500, 0, 10, '2025-01-28 09:21:25', '2025-01-28 09:21:25'),
(2, 'Open conference', 'Online', '', '', NULL, NULL, 0, 0, 0, 0, 10, '2025-01-28 09:27:13', '2025-01-28 09:27:13'),
(3, 'Seminar', 'IU', '', '', '2025-03-18 10:00:00', '2025-03-18 21:29:00', 200, 0, 200, 0, 10, '2025-01-28 09:29:31', '2025-01-28 09:29:31');

-- --------------------------------------------------------

--
-- Table structure for table `files`
--

CREATE TABLE `files` (
  `file_id` bigint UNSIGNED NOT NULL,
  `operation_name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `table_id` bigint UNSIGNED NOT NULL COMMENT 'id of operations table',
  `filepath` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `filename` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `fileinfo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` bigint UNSIGNED NOT NULL,
  `deleted_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `files`
--

INSERT INTO `files` (`file_id`, `operation_name`, `table_id`, `filepath`, `filename`, `fileinfo`, `created_by`, `deleted_by`, `created_at`, `deleted_at`) VALUES
(2, 'users', 1, 'users', '1_1737864125.jpg', 'profile_picture', 1, 1, '2025-01-25 22:02:05', '2025-01-26 10:05:30'),
(3, 'users', 1, 'users', '1_1737864521.jpg', 'profile_picture', 1, 1, '2025-01-25 22:08:41', '2025-01-26 10:05:30'),
(4, 'users', 1, 'users', '1_1737864658.jpg', 'profile_picture', 1, 1, '2025-01-25 22:10:58', '2025-01-26 10:05:30'),
(5, 'users', 1, 'users', '1_1737864879.jpg', 'profile_picture', 1, 1, '2025-01-25 22:14:39', '2025-01-26 10:05:30'),
(6, 'users', 1, 'users', '1_1737865116.jpg', 'profile_picture', 1, 1, '2025-01-25 22:18:36', '2025-01-26 10:05:30'),
(7, 'users', 1, 'users', '1_1737907625.jpg', 'profile_picture', 1, NULL, '2025-01-26 10:07:05', NULL),
(10, 'events', 3, 'events', '3_1738078171.jpg', 'banner_image', 10, NULL, '2025-01-28 09:29:31', NULL),
(11, 'users', 10, 'users', '10_1738116457.JPG', 'profile_picture', 10, NULL, '2025-01-28 20:07:37', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `host_details`
--

CREATE TABLE `host_details` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `description` text COLLATE utf8mb4_general_ci NOT NULL,
  `location` varchar(255) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `host_details`
--

INSERT INTO `host_details` (`id`, `user_id`, `description`, `location`) VALUES
(1, 10, '&lt;ol&gt;&lt;li&gt;hello&lt;/li&gt;&lt;li&gt;there&lt;br&gt;&lt;/li&gt;&lt;/ol&gt;', 'Kawran Bazar, Dhaka');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `mobile` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `status` tinyint NOT NULL DEFAULT '0' COMMENT '0=>inactive, 1=>active',
  `type` tinyint NOT NULL DEFAULT '3' COMMENT '1=>superuser, 2=>host, 3=>general_user',
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` bigint NOT NULL DEFAULT '0',
  `updated_by` bigint NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `name`, `email`, `mobile`, `email_verified_at`, `status`, `type`, `password`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 'Naymur Rahman', 'naymur92@gmail.com', '01737036324', NULL, 1, 1, '$2y$10$.HRiuajTuUBzB6QcgjoXcu0jMasD5XZZSymxn0jZkNZ12rdI0qVva', 0, 1, '2025-01-23 01:51:37', '2025-01-26 12:46:40'),
(3, 'Md. Kamrul Hasan', 'kamrul@gmail.com', '01558981652', NULL, 0, 2, '$2y$10$qQji/ujnkB6upiQXyENnR.UHy.XkqIx1YGiSpDbCv/F0616FvnLiG', 0, 1, '2025-01-24 09:27:53', '2025-01-26 12:03:58'),
(4, 'Abdur Rahman', 'abdrahman@gmail.com', '01737036324', NULL, 0, 3, '$2y$10$6ZHQFuUJDRq5mdYCmsJ5lu/cli9URQ7fG4aH5mto3HEjmmeeIOPuC', 1, 1, '2025-01-25 05:35:22', '2025-01-25 08:35:39'),
(6, 'Abdur Rahman', 'naymur@gmail.com', '', NULL, 1, 3, '$2y$10$snZMAYf93NtOW3MyKpCr6eafO.895r.IMrj2fGZo4R2p322AXLQCK', 1, 0, '2025-01-25 08:28:34', '2025-01-25 08:28:34'),
(7, 'Sabbir Saad', 'saad@gmail.com', '', NULL, 0, 2, '$2y$10$2j3g8ESbh3ktyotkh9akrOPhKyOlLbsGFWvccqqPkCQBcDrKrLKVu', 0, 1, '2025-01-25 19:36:10', '2025-01-26 20:28:54'),
(10, 'Test User', 'test@gmail.com', '', NULL, 1, 2, '$2y$10$exPSoX9MyOnQL8ttMd7MYu9iwbghEO6jwOIn.W8mzLMdfWho4lxzi', 1, 10, '2025-01-26 20:26:43', '2025-01-28 20:04:13'),
(11, 'BUET', 'into@buet.ac.bd', '', NULL, 1, 2, '$2y$10$yUTNsSDIAd0oAyn/ggKXI.NMKe3OpYbZcv/sgkhGTAGPOfPcUlPOu', 0, 0, '2025-01-27 09:38:09', '2025-01-27 09:38:09');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `attendees`
--
ALTER TABLE `attendees`
  ADD PRIMARY KEY (`attendee_id`),
  ADD KEY `attendees_user_id_foreign` (`user_id`),
  ADD KEY `attendees_event_id_foreign` (`event_id`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`event_id`),
  ADD KEY `events_user_id_foreign` (`user_id`);

--
-- Indexes for table `files`
--
ALTER TABLE `files`
  ADD PRIMARY KEY (`file_id`),
  ADD KEY `files_created_by_foreign` (`created_by`),
  ADD KEY `files_deleted_by_foreign` (`deleted_by`);

--
-- Indexes for table `host_details`
--
ALTER TABLE `host_details`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `attendees`
--
ALTER TABLE `attendees`
  MODIFY `attendee_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `event_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `files`
--
ALTER TABLE `files`
  MODIFY `file_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `host_details`
--
ALTER TABLE `host_details`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `attendees`
--
ALTER TABLE `attendees`
  ADD CONSTRAINT `attendees_event_id_foreign` FOREIGN KEY (`event_id`) REFERENCES `events` (`event_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `attendees_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `events`
--
ALTER TABLE `events`
  ADD CONSTRAINT `events_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `files`
--
ALTER TABLE `files`
  ADD CONSTRAINT `files_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`user_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `files_deleted_by_foreign` FOREIGN KEY (`deleted_by`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `host_details`
--
ALTER TABLE `host_details`
  ADD CONSTRAINT `host_details_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
