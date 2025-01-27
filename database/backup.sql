-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jan 27, 2025 at 03:14 AM
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
(7, 'users', 1, 'users', '1_1737907625.jpg', 'profile_picture', 1, NULL, '2025-01-26 10:07:05', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `host_details`
--

CREATE TABLE `host_details` (
  `user_id` bigint UNSIGNED NOT NULL,
  `description` text COLLATE utf8mb4_general_ci NOT NULL,
  `location` varchar(255) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
(10, 'Test User', 'test@gmail.com', '', NULL, 1, 2, '$2y$10$exPSoX9MyOnQL8ttMd7MYu9iwbghEO6jwOIn.W8mzLMdfWho4lxzi', 1, 0, '2025-01-26 20:26:43', '2025-01-26 20:26:43');

--
-- Indexes for dumped tables
--

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
-- AUTO_INCREMENT for table `files`
--
ALTER TABLE `files`
  MODIFY `file_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

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
