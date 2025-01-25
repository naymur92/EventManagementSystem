-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jan 25, 2025 at 04:11 PM
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
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` smallint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `mobile` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `status` tinyint NOT NULL DEFAULT '0' COMMENT '0=>inactive, 1=>active',
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` smallint NOT NULL DEFAULT '0',
  `updated_by` smallint NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `name`, `email`, `mobile`, `email_verified_at`, `status`, `password`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 'Naymur Rahman', 'naymur92@gmail.com', NULL, NULL, 1, '$2y$10$qQji/ujnkB6upiQXyENnR.UHy.XkqIx1YGiSpDbCv/F0616FvnLiG', 0, 0, '2025-01-23 01:51:37', '2025-01-23 01:51:37'),
(3, 'Kamrul Hasan', 'kamrul@gmail.com', '01558981652', NULL, 0, '$2y$10$qQji/ujnkB6upiQXyENnR.UHy.XkqIx1YGiSpDbCv/F0616FvnLiG', 0, 1, '2025-01-24 09:27:53', '2025-01-25 07:41:37'),
(4, 'Abdur Rahman', 'abdrahman@gmail.com', '01737036324', NULL, 2, '$2y$10$6ZHQFuUJDRq5mdYCmsJ5lu/cli9URQ7fG4aH5mto3HEjmmeeIOPuC', 1, 1, '2025-01-25 05:35:22', '2025-01-25 08:35:39'),
(6, 'Abdur Rahman', 'naymur@gmail.com', '', NULL, 0, '$2y$10$snZMAYf93NtOW3MyKpCr6eafO.895r.IMrj2fGZo4R2p322AXLQCK', 1, 0, '2025-01-25 08:28:34', '2025-01-25 08:28:34');

--
-- Indexes for dumped tables
--

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
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` smallint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
