-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 18, 2018 at 03:57 PM
-- Server version: 10.1.30-MariaDB
-- PHP Version: 7.1.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `talitak`
--

-- --------------------------------------------------------

--
-- Table structure for table `abilities`
--

CREATE TABLE `abilities` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `entity_id` int(10) UNSIGNED DEFAULT NULL,
  `entity_type` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `only_owned` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `abilities`
--

INSERT INTO `abilities` (`id`, `name`, `title`, `entity_id`, `entity_type`, `only_owned`, `created_at`, `updated_at`) VALUES
(1, '*', 'جميع الصلاحيات', NULL, '*', 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `abuses`
--

CREATE TABLE `abuses` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `abuseable_id` int(11) NOT NULL,
  `abuseable_type` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_adopt` tinyint(4) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `app_ratios`
--

CREATE TABLE `app_ratios` (
  `id` int(10) UNSIGNED NOT NULL,
  `provider_id` int(10) UNSIGNED NOT NULL,
  `service_id` int(10) UNSIGNED NOT NULL,
  `order_id` int(10) UNSIGNED NOT NULL,
  `service_charge` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `app_ratio` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `app_ratio_photo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_paid` tinyint(1) NOT NULL DEFAULT '0',
  `is_paid_confirmed` tinyint(1) NOT NULL DEFAULT '0',
  `money_photo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `assigned_roles`
--

CREATE TABLE `assigned_roles` (
  `role_id` int(10) UNSIGNED NOT NULL,
  `entity_id` int(10) UNSIGNED NOT NULL,
  `entity_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `assigned_roles`
--

INSERT INTO `assigned_roles` (`role_id`, `entity_id`, `entity_type`) VALUES
(1, 1, 'App\\User'),
(1, 2, 'App\\User');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name_ar` varchar(255) NOT NULL,
  `name_en` varchar(255) NOT NULL,
  `target_gender` tinyint(4) NOT NULL,
  `parent_id` int(11) NOT NULL,
  `image` varchar(100) NOT NULL,
  `is_active` tinyint(4) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name_ar`, `name_en`, `target_gender`, `parent_id`, `image`, `is_active`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'طلتك', 'talitak', 1, 0, '', 1, '2018-03-14 11:33:50', '2018-03-11 06:05:42', NULL),
(2, 'حجامة', 'hgama', 0, 0, 'http://localhost:8000/files/categories/1520499688.flfZvt2wNAgj8t9oAYeygoogle play bg.png', 1, '2018-03-14 11:35:27', '2018-03-08 10:09:37', NULL),
(3, 'نوع خدمة 4', 'service type 4', 2, 0, 'http://localhost:8000/files/categories/1520840545.DDunjaocsvc5FmuGgWA7avatar.png', 1, '2018-03-12 07:43:08', '2018-03-12 05:43:08', NULL),
(4, 'نوع خدمة يييي', 'service type 4', 2, 0, 'http://localhost:8000/files/categories/1520840545.DDunjaocsvc5FmuGgWA7avatar.png', 1, '2018-03-12 07:44:52', '2018-03-12 05:44:52', '2018-03-12 05:44:52'),
(5, 'نوع خدمة ببب', 'service type 4', 2, 0, 'http://localhost:8000/files/categories/1520840545.DDunjaocsvc5FmuGgWA7avatar.png', 1, '2018-03-12 07:44:52', '2018-03-12 05:44:52', '2018-03-12 05:44:52'),
(6, 'نوع خدمة صص', 'service type 4', 2, 0, 'http://localhost:8000/files/categories/1520840545.DDunjaocsvc5FmuGgWA7avatar.png', 1, '2018-03-12 07:44:52', '2018-03-12 05:44:52', '2018-03-12 05:44:52');

-- --------------------------------------------------------

--
-- Table structure for table `centers`
--

CREATE TABLE `centers` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `place` enum('home','center') COLLATE utf8mb4_unicode_ci NOT NULL,
  `lat` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lng` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_accepted` tinyint(1) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `type` enum('person','center') COLLATE utf8mb4_unicode_ci NOT NULL,
  `document_photo` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `city_id` int(10) UNSIGNED NOT NULL,
  `category_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cities`
--

CREATE TABLE `cities` (
  `id` int(10) UNSIGNED NOT NULL,
  `created_by` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cities`
--

INSERT INTO `cities` (`id`, `created_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
(2, 1, '2018-03-07 10:47:18', '2018-03-08 09:22:32', '2018-03-08 09:22:32'),
(4, 1, '2018-03-07 10:55:32', '2018-03-08 09:33:50', '2018-03-08 09:33:50'),
(5, 1, '2018-03-07 10:59:12', '2018-03-08 09:21:40', '2018-03-08 09:21:40'),
(6, 1, '2018-03-08 09:52:42', '2018-03-08 09:52:42', NULL),
(7, 1, '2018-03-14 05:59:06', '2018-03-14 05:59:06', NULL),
(8, 1, '2018-03-14 11:17:21', '2018-03-14 11:17:21', NULL),
(9, 1, '2018-03-14 11:19:29', '2018-03-14 11:19:29', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `city_translations`
--

CREATE TABLE `city_translations` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `city_id` int(10) UNSIGNED NOT NULL,
  `locale` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `city_translations`
--

INSERT INTO `city_translations` (`id`, `name`, `city_id`, `locale`, `created_at`, `updated_at`) VALUES
(1, 'poiujhgfd', 1, 'administrator', NULL, NULL),
(2, 'مكة', 2, 'ar', NULL, NULL),
(3, 'uuuuuuu', 3, 'administrator', NULL, NULL),
(4, 'jedda', 4, 'en', NULL, NULL),
(5, 'مدينتى', 5, 'ar', NULL, NULL),
(6, 'my city', 5, 'en', NULL, NULL),
(7, 'mecca', 2, 'en', NULL, NULL),
(8, 'جدة', 4, 'ar', NULL, NULL),
(9, 'جدة', 6, 'ar', NULL, NULL),
(10, 'jeda', 6, 'en', NULL, NULL),
(11, 'مدينة', 7, 'ar', NULL, NULL),
(12, 'city', 7, 'en', NULL, NULL),
(13, 'المدينة', 8, 'ar', NULL, NULL),
(14, 'medina', 8, 'en', NULL, NULL),
(15, 'k', 9, 'ar', NULL, NULL),
(16, 'l', 9, 'en', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `parent_id` bigint(20) NOT NULL DEFAULT '0',
  `user_id` bigint(20) NOT NULL DEFAULT '0',
  `commentable_id` bigint(20) NOT NULL,
  `commentable_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `comment` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_active` tinyint(4) NOT NULL DEFAULT '1',
  `is_approve` tinyint(4) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `parent_id`, `user_id`, `commentable_id`, `commentable_type`, `comment`, `is_active`, `is_approve`, `created_at`, `updated_at`) VALUES
(1, 0, 2, 6, 'App\\Company', 'First Comment', 1, 0, '2018-02-11 14:05:14', '2018-02-11 14:05:14'),
(2, 0, 4, 6, 'App\\Company', 'First Comment', 0, 0, '2018-02-12 05:27:49', '2018-02-12 05:27:49'),
(3, 0, 5, 6, 'App\\Company', 'First Comment', 0, 0, '2018-02-12 05:27:55', '2018-02-12 05:27:55'),
(4, 0, 27, 6, 'App\\Company', 'First Comment', 1, 0, '2018-02-12 05:29:21', '2018-02-12 05:29:21'),
(5, 0, 27, 2, 'App\\Company', 'First Comment', 0, 0, '2018-02-12 05:29:27', '2018-02-12 05:29:27'),
(6, 0, 27, 2, 'App\\Company', 'First Comment', 1, 0, '2018-02-12 05:30:43', '2018-02-12 05:30:43'),
(7, 0, 27, 2, 'App\\Company', 'First Comment', 1, 0, '2018-02-12 05:31:15', '2018-02-12 05:31:15'),
(8, 0, 27, 2, 'App\\Company', 'First Comment', 0, 0, '2018-02-12 05:31:34', '2018-02-12 05:31:34'),
(9, 0, 27, 3, 'App\\Company', 'First Comment', 1, 0, '2018-02-12 05:31:46', '2018-02-12 05:31:46'),
(10, 0, 27, 1, 'App\\Company', 'First Comment', 1, 0, '2018-02-14 10:29:08', '2018-02-14 10:29:08'),
(11, 0, 27, 1, 'App\\Company', 'First Comment', 0, 0, '2018-02-14 10:31:25', '2018-02-14 10:31:25'),
(12, 0, 26, 1, 'App\\Company', 'Comment Here...00...', 1, 0, '2018-02-28 13:05:43', '2018-02-28 13:05:43'),
(13, 0, 26, 1, 'App\\Company', 'Comment Here...00...', 1, 0, '2018-02-28 13:06:31', '2018-02-28 13:06:31'),
(14, 0, 26, 1, 'App\\Company', 'Comment Here...00...', 1, 0, '2018-02-28 13:06:56', '2018-02-28 13:06:56'),
(15, 0, 26, 1, 'App\\Company', 'Comment Here...00...', 1, 0, '2018-02-28 13:08:12', '2018-02-28 13:08:12'),
(16, 0, 26, 1, 'App\\Company', 'Comment Here...00...', 1, 0, '2018-02-28 13:08:37', '2018-02-28 13:08:37'),
(17, 0, 26, 1, 'App\\Company', 'Comment Here...00...', 1, 0, '2018-02-28 13:10:04', '2018-02-28 13:10:04'),
(18, 0, 26, 1, 'App\\Company', 'Comment Here...00...', 1, 0, '2018-02-28 13:12:03', '2018-02-28 13:12:03'),
(19, 0, 26, 1, 'App\\Company', 'Comment Here...00...', 1, 0, '2018-02-28 13:12:32', '2018-02-28 13:12:32'),
(20, 0, 26, 1, 'App\\Company', 'Comment Here...00...', 1, 0, '2018-02-28 13:14:29', '2018-02-28 13:14:29'),
(21, 0, 26, 1, 'App\\Company', 'Comment Here...00...', 1, 0, '2018-02-28 13:15:21', '2018-02-28 13:15:21'),
(22, 0, 26, 1, 'App\\Company', 'Comment Here...00...', 1, 0, '2018-02-28 13:16:04', '2018-02-28 13:16:04'),
(23, 0, 26, 1, 'App\\Company', 'Comment Here...00...', 1, 0, '2018-02-28 13:16:50', '2018-02-28 13:16:50'),
(24, 0, 26, 1, 'App\\Company', 'Comment Here...00...', 1, 0, '2018-02-28 13:17:14', '2018-02-28 13:17:14'),
(25, 0, 26, 1, 'App\\Company', 'Comment Here', 1, 0, '2018-03-01 05:32:23', '2018-03-01 05:32:23'),
(26, 0, 26, 1, 'App\\Company', 'Comment Here', 1, 0, '2018-03-01 05:36:07', '2018-03-01 05:36:07'),
(27, 0, 26, 1, 'App\\Company', 'Comment Here', 1, 0, '2018-03-01 05:36:37', '2018-03-01 05:36:37'),
(28, 0, 26, 1, 'App\\Company', 'Comment Here', 1, 0, '2018-03-01 05:37:53', '2018-03-01 05:37:53'),
(29, 0, 26, 5, 'App\\Company', 'Comment Here', 1, 0, '2018-03-01 05:38:36', '2018-03-01 05:38:36'),
(30, 0, 26, 2, 'App\\Company', 'Comment Here', 1, 0, '2018-03-01 05:38:54', '2018-03-01 05:38:54'),
(31, 0, 26, 2, 'App\\Company', 'Comment Here', 1, 0, '2018-03-01 05:59:29', '2018-03-01 05:59:29'),
(32, 0, 26, 2, 'App\\Company', 'Comment Here', 1, 0, '2018-03-01 06:00:06', '2018-03-01 06:00:06'),
(33, 0, 26, 2, 'App\\Company', 'Comment Here', 1, 0, '2018-03-01 06:02:06', '2018-03-01 06:02:06'),
(34, 0, 26, 2, 'App\\Company', 'Comment Here', 1, 0, '2018-03-01 06:39:41', '2018-03-01 06:39:41'),
(36, 0, 26, 2, 'App\\Company', 'Comment Here', 1, 0, '2018-03-01 06:45:00', '2018-03-01 06:45:00'),
(37, 0, 26, 2, 'App\\Company', 'Comment Here', 1, 0, '2018-03-01 06:45:22', '2018-03-01 06:45:22'),
(38, 0, 26, 2, 'App\\Company', 'Comment Here', 1, 0, '2018-03-01 06:45:36', '2018-03-01 06:45:36'),
(39, 0, 26, 2, 'App\\Company', 'Comment Here', 1, 0, '2018-03-01 06:45:43', '2018-03-01 06:45:43'),
(40, 0, 26, 2, 'App\\Company', 'Comment Here', 1, 0, '2018-03-01 06:46:32', '2018-03-01 06:46:32'),
(41, 0, 26, 2, 'App\\Company', 'Comment Here', 1, 0, '2018-03-01 06:48:12', '2018-03-01 06:48:12'),
(42, 0, 26, 2, 'App\\Company', 'Comment Here', 1, 0, '2018-03-01 06:48:26', '2018-03-01 06:48:26'),
(43, 0, 26, 2, 'App\\Company', 'Comment Here', 1, 0, '2018-03-01 06:48:37', '2018-03-01 06:48:37'),
(44, 0, 26, 1, 'App\\Company', 'Comment Here', 1, 0, '2018-03-01 06:49:36', '2018-03-01 06:49:36'),
(45, 0, 26, 1, 'App\\Company', 'Comment Here', 1, 0, '2018-03-01 06:49:58', '2018-03-01 06:49:58'),
(46, 0, 26, 1, 'App\\Company', 'Comment Here', 1, 0, '2018-03-01 06:50:29', '2018-03-01 06:50:29'),
(47, 0, 1, 1, 'App\\Company', 'Comment Here', 1, 0, '2018-03-01 07:21:45', '2018-03-01 07:21:45'),
(48, 0, 1, 1, 'App\\Company', 'Comment Here', 1, 0, '2018-03-01 07:22:51', '2018-03-01 07:22:51'),
(49, 0, 1, 1, 'App\\Company', 'Comment Here 03', 1, 0, '2018-03-01 08:06:18', '2018-03-01 08:06:18'),
(50, 0, 1, 1, 'App\\Company', 'Comment Here 03', 1, 0, '2018-03-01 08:08:37', '2018-03-01 08:08:37'),
(51, 0, 1, 1, 'App\\Company', 'Comment Here 03', 1, 0, '2018-03-01 08:09:21', '2018-03-01 08:09:21'),
(52, 0, 1, 1, 'App\\Company', 'Comment Here 03', 1, 0, '2018-03-01 08:10:01', '2018-03-01 08:10:01'),
(53, 0, 1, 1, 'App\\Company', 'Comment Here 03', 1, 0, '2018-03-01 08:10:15', '2018-03-01 08:10:15'),
(54, 0, 1, 1, 'App\\Company', 'Comment Here 03', 1, 0, '2018-03-01 08:16:08', '2018-03-01 08:16:08'),
(55, 0, 1, 1, 'App\\Company', 'Comment Here 03', 1, 0, '2018-03-01 08:16:23', '2018-03-01 08:16:23'),
(56, 0, 1, 1, 'App\\Company', 'Comment Here 03', 1, 0, '2018-03-01 08:17:25', '2018-03-01 08:17:25'),
(57, 0, 1, 1, 'App\\Company', 'Comment Here 03', 1, 0, '2018-03-01 08:18:02', '2018-03-01 08:18:02'),
(58, 0, 1, 1, 'App\\Company', 'Comment Here 03', 1, 0, '2018-03-01 08:18:19', '2018-03-01 08:18:19'),
(59, 0, 1, 1, 'App\\Company', 'Comment Here 03', 1, 0, '2018-03-01 08:18:57', '2018-03-01 08:18:57'),
(60, 0, 1, 1, 'App\\Company', 'Comment Here 03', 1, 0, '2018-03-01 08:19:12', '2018-03-01 08:19:12'),
(61, 0, 1, 1, 'App\\Company', 'Comment Here 03', 1, 0, '2018-03-01 08:23:30', '2018-03-01 08:23:30'),
(62, 0, 1, 1, 'App\\Company', 'Comment Here 03', 1, 0, '2018-03-01 08:24:10', '2018-03-01 08:24:10'),
(63, 0, 25, 2, 'App\\Company', 'Comment Here 04', 1, 0, '2018-03-04 10:16:27', '2018-03-04 10:16:27'),
(64, 0, 25, 2, 'App\\Company', 'Comment Here 04', 1, 0, '2018-03-04 10:16:55', '2018-03-04 10:16:55'),
(65, 0, 25, 2, 'App\\Company', 'Comment Here 04', 1, 0, '2018-03-04 10:26:02', '2018-03-04 10:26:02');

-- --------------------------------------------------------

--
-- Table structure for table `comments_old`
--

CREATE TABLE `comments_old` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `parent_id` int(11) NOT NULL,
  `comment` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_approve` tinyint(4) NOT NULL DEFAULT '0',
  `is_active` tinyint(4) NOT NULL DEFAULT '0',
  `commentable_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `commentable_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `companies`
--

CREATE TABLE `companies` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_comment` tinyint(1) NOT NULL DEFAULT '1',
  `category_id` int(11) NOT NULL,
  `phone` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `place` tinyint(4) NOT NULL,
  `type` tinyint(4) NOT NULL,
  `document_photo` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_rate` tinyint(1) NOT NULL DEFAULT '1',
  `description` longtext COLLATE utf8mb4_unicode_ci,
  `city_id` int(11) NOT NULL,
  `address` text COLLATE utf8mb4_unicode_ci,
  `facebook` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `twitter` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `google` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lat` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lng` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_agree` tinyint(1) NOT NULL DEFAULT '0',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `membership_id` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `image` text COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `companies`
--

INSERT INTO `companies` (`id`, `user_id`, `name`, `is_comment`, `category_id`, `phone`, `place`, `type`, `document_photo`, `is_rate`, `description`, `city_id`, `address`, `facebook`, `twitter`, `google`, `lat`, `lng`, `is_agree`, `is_active`, `membership_id`, `created_at`, `updated_at`, `image`) VALUES
(5, 4, 'Compan', 1, 2, '', 0, 0, '', 1, '1212312312312123123123123223123', 6, 'Address Here', NULL, NULL, NULL, NULL, NULL, 1, 1, 3, '2018-02-21 06:08:04', '2018-03-11 07:27:11', NULL),
(6, 45, 'Hassan Saeed 98', 0, 1, '', 0, 0, '', 0, '1212312312312123123123123223123', 6, 'Address Here', NULL, NULL, NULL, '12.3566', '6565', 1, 1, NULL, '2018-03-04 10:56:33', '2018-03-11 11:32:19', '1518533327.6z8IONXf9r5ecenO18kLpark-new-york-city-nyc-manhattan-162024.jpeg'),
(8, 47, 'Hassan Saeed 8445', 0, 1, '', 0, 0, '', 0, '1212312312312123123123123223123', 1, 'Address Here', NULL, NULL, NULL, '12.3566', '6565', 1, 1, NULL, '2018-03-04 10:59:46', '2018-03-12 09:37:00', '1518533327.6z8IONXf9r5ecenO18kLpark-new-york-city-nyc-manhattan-162024.jpeg'),
(9, 48, 'Hassan Saeed 844585', 0, 1, '', 0, 0, '', 0, '1212312312312123123123123223123', 1, 'Address Here', NULL, NULL, NULL, '12.3566', '6565', 0, 1, NULL, '2018-03-04 11:02:10', '2018-03-11 07:27:32', '1518533327.6z8IONXf9r5ecenO18kLpark-new-york-city-nyc-manhattan-162024.jpeg'),
(10, 49, 'Hassan Saeed 8445812', 0, 1, '', 0, 0, '', 0, '1212312312312123123123123223123', 1, 'Address Here', NULL, NULL, NULL, '12.3566', '6565', 0, 1, NULL, '2018-03-04 11:07:55', '2018-03-11 07:27:32', '1518533327.6z8IONXf9r5ecenO18kLpark-new-york-city-nyc-manhattan-162024.jpeg'),
(11, 53, 'HassanSaeed9999', 0, 1, '', 0, 0, '', 0, '1212312312312123123123123223123', 1, 'Address Here', NULL, NULL, NULL, '12.3566', '6565', 0, 1, NULL, '2018-03-04 11:20:58', '2018-03-11 07:27:32', NULL),
(12, 54, 'HassanSaee9898', 0, 1, '', 0, 0, '', 0, '1212312312312123123123123223123', 1, 'Address Here', NULL, NULL, NULL, '12.3566', '6565', 0, 1, NULL, '2018-03-04 11:22:21', '2018-03-11 07:27:32', NULL),
(13, 55, 'HassanSaewwew', 0, 1, '', 0, 0, '', 0, '1212312312312123123123123223123', 1, 'Address Here', NULL, NULL, NULL, '12.3566', '6565', 0, 1, NULL, '2018-03-04 11:23:54', '2018-03-11 07:27:32', NULL),
(14, 56, 'HassanSaeed 9898', 0, 1, '', 0, 0, '', 0, '1212312312312123123123123223123', 1, 'Address Here', NULL, NULL, NULL, '12.3566', '6565', 0, 1, NULL, '2018-03-04 11:29:51', '2018-03-11 07:27:32', NULL),
(15, 57, 'HassanSaeed 33333', 0, 1, '', 0, 0, '', 0, '1212312312312123123123123223123', 1, 'Address Here', NULL, NULL, NULL, '12.3566', '6565', 0, 1, NULL, '2018-03-04 11:44:58', '2018-03-11 07:27:32', NULL),
(16, 58, 'HassanSaeed 445454', 0, 1, '', 0, 0, '', 0, '1212312312312123123123123223123', 1, 'Address Here', NULL, NULL, NULL, '12.3566', '6565', 0, 1, NULL, '2018-03-04 12:07:41', '2018-03-11 07:27:32', NULL),
(17, 59, 'HassanSaeed 47777', 0, 1, '', 0, 0, '', 0, '1212312312312123123123123223123', 1, 'Address Here', NULL, NULL, NULL, '12.3566', '6565', 0, 1, NULL, '2018-03-04 12:37:42', '2018-03-11 07:27:32', NULL),
(18, 60, 'HassanSaeed 4745', 0, 1, '', 0, 0, '', 0, '1212312312312123123123123223123', 1, 'Address Here', NULL, NULL, NULL, '12.3566', '6565', 0, 1, NULL, '2018-03-04 12:40:01', '2018-03-11 07:27:33', NULL),
(19, 61, 'HassanSaeed 4743333', 0, 1, '', 0, 0, '', 0, '1212312312312123123123123223123', 1, 'Address Here', NULL, NULL, NULL, '12.3566', '6565', 0, 1, NULL, '2018-03-04 12:42:06', '2018-03-11 07:27:33', NULL),
(20, 62, 'HassanSaeed 4743355', 0, 1, '', 0, 0, '', 0, '1212312312312123123123123223123', 1, 'Address Here', NULL, NULL, NULL, '12.3566', '6565', 0, 1, NULL, '2018-03-04 12:43:17', '2018-03-11 07:27:33', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `company_translations`
--

CREATE TABLE `company_translations` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `center_id` int(10) UNSIGNED NOT NULL,
  `locale` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `company_work_days`
--

CREATE TABLE `company_work_days` (
  `id` int(10) UNSIGNED NOT NULL,
  `day` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `from` time NOT NULL,
  `to` time NOT NULL,
  `company_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `company_work_days`
--

INSERT INTO `company_work_days` (`id`, `day`, `from`, `to`, `company_id`, `created_at`, `updated_at`) VALUES
(1, 'saturday', '02:02:33', '20:00:00', 6, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `contact_us`
--

CREATE TABLE `contact_us` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `text` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `msg_type` enum('complain','suggest','other') COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `devices`
--

CREATE TABLE `devices` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `device` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `districts`
--

CREATE TABLE `districts` (
  `id` int(10) UNSIGNED NOT NULL,
  `created_by` int(10) UNSIGNED NOT NULL,
  `city_id` int(10) UNSIGNED NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `districts`
--

INSERT INTO `districts` (`id`, `created_by`, `city_id`, `deleted_at`, `created_at`, `updated_at`) VALUES
(3, 1, 4, NULL, '2018-03-08 09:28:18', '2018-03-08 09:33:50'),
(4, 1, 4, '2018-03-08 09:33:50', '2018-03-08 09:29:01', '2018-03-08 09:33:50'),
(5, 1, 6, '2018-03-08 09:58:02', '2018-03-08 09:57:42', '2018-03-08 09:58:02');

-- --------------------------------------------------------

--
-- Table structure for table `district_translations`
--

CREATE TABLE `district_translations` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `district_id` int(10) UNSIGNED NOT NULL,
  `locale` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `district_translations`
--

INSERT INTO `district_translations` (`id`, `name`, `district_id`, `locale`, `created_at`, `updated_at`) VALUES
(1, 'حى 1', 1, 'ar', NULL, NULL),
(2, 'district 1', 1, 'en', NULL, NULL),
(3, 'حى2', 2, 'ar', NULL, NULL),
(4, 'district 2', 2, 'en', NULL, NULL),
(5, 'حى3', 3, 'ar', NULL, NULL),
(6, 'district 3', 3, 'en', NULL, NULL),
(7, 'حى4', 4, 'ar', NULL, NULL),
(8, 'district 4', 4, 'en', NULL, NULL),
(9, 'ننن', 5, 'ar', NULL, NULL),
(10, 'jjj', 5, 'en', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `favourites`
--

CREATE TABLE `favourites` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `company_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `financial_accounts`
--

CREATE TABLE `financial_accounts` (
  `id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `orders_count` varchar(100) NOT NULL,
  `net_app_ratio` varchar(100) NOT NULL,
  `pay_status` tinyint(4) NOT NULL,
  `pay_doc` varchar(100) NOT NULL,
  `is_confirmed` tinyint(4) NOT NULL,
  `paid` varchar(100) NOT NULL,
  `remain` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `financial_accounts`
--

INSERT INTO `financial_accounts` (`id`, `company_id`, `orders_count`, `net_app_ratio`, `pay_status`, `pay_doc`, `is_confirmed`, `paid`, `remain`, `created_at`, `updated_at`) VALUES
(1, 5, '1', '0', 1, 'pay.jpeg', 1, '25', '0', '2018-03-18 07:35:50', '2018-03-18 05:35:50');

-- --------------------------------------------------------

--
-- Table structure for table `images`
--

CREATE TABLE `images` (
  `id` int(11) NOT NULL,
  `service_id` int(11) NOT NULL,
  `imageable_id` varchar(100) NOT NULL,
  `imageable_type` varchar(100) NOT NULL,
  `image` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2018_03_05_000432_create_cities_table', 1),
(4, '2018_03_05_010806_create_districts_table', 1),
(5, '2018_03_05_013450_create_centers_table', 1),
(6, '2018_03_05_072831_create_service_types_table', 1),
(7, '2018_03_05_073229_create_service_type_translations_table', 1),
(8, '2018_03_05_082443_create_services_table', 1),
(9, '2018_03_05_082608_create_service_translations_table', 1),
(10, '2018_03_05_090443_create_contact_us_table', 1),
(11, '2018_03_05_091907_create_comments_table', 1),
(12, '2018_03_05_092255_create_rates_table', 1),
(13, '2018_03_05_092929_create_favourites_table', 1),
(14, '2018_03_05_100758_create_city_translations_table', 1),
(15, '2018_03_05_110915_create_district_translations_table', 1),
(16, '2018_03_05_115328_create_center_work_days_table', 1),
(17, '2018_03_05_115602_create_user_invitations_table', 1),
(18, '2018_03_05_115745_create_orders_table', 1),
(19, '2018_03_05_121823_create_reports_table', 1),
(20, '2018_03_05_144248_create_app_ratios_table', 1),
(21, '2018_03_06_093324_create_center_translations_table', 1),
(22, '2018_03_07_111626_create_bouncer_tables', 2);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(10) UNSIGNED NOT NULL,
  `gender` enum('male','female') COLLATE utf8mb4_unicode_ci NOT NULL,
  `place` enum('home','center') COLLATE utf8mb4_unicode_ci NOT NULL,
  `order_date` date NOT NULL,
  `order_time` time NOT NULL,
  `notes` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `lat` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lng` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `discount_accept` tinyint(1) NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `service_id` int(10) UNSIGNED NOT NULL,
  `company_id` int(11) UNSIGNED NOT NULL,
  `provider_id` int(10) UNSIGNED NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `user_is_finished` tinyint(1) NOT NULL DEFAULT '0',
  `refuse_reasons` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `gender`, `place`, `order_date`, `order_time`, `notes`, `lat`, `lng`, `address`, `price`, `discount_accept`, `user_id`, `service_id`, `company_id`, `provider_id`, `status`, `user_is_finished`, `refuse_reasons`, `created_at`, `updated_at`) VALUES
(1, 'male', 'center', '2018-03-15', '02:00:00', 'order notes', '', '', 'address', '500', 0, 5, 2, 5, 0, 3, 0, NULL, '2018-03-14 22:00:00', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `ability_id` int(10) UNSIGNED NOT NULL,
  `entity_id` int(10) UNSIGNED NOT NULL,
  `entity_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `forbidden` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`ability_id`, `entity_id`, `entity_type`, `forbidden`) VALUES
(1, 1, 'roles', 0);

-- --------------------------------------------------------

--
-- Table structure for table `rates`
--

CREATE TABLE `rates` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `company_id` int(10) UNSIGNED NOT NULL,
  `order_id` int(11) NOT NULL,
  `rate` tinyint(4) NOT NULL,
  `rate_from` enum('user','provider') COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `rates`
--

INSERT INTO `rates` (`id`, `user_id`, `company_id`, `order_id`, `rate`, `rate_from`, `price`, `created_at`, `updated_at`) VALUES
(3, 4, 5, 1, 3, 'user', '', NULL, NULL),
(4, 2, 5, 0, 2, 'user', '700', NULL, NULL),
(5, 2, 5, 1, 2, 'provider', '500', NULL, NULL),
(6, 5, 5, 1, 4, 'user', '', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `level` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `title`, `level`, `created_at`, `updated_at`) VALUES
(1, 'manager', 'المدير التنفيذى', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE `services` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `gender_type` enum('male','female','both') COLLATE utf8mb4_unicode_ci NOT NULL,
  `provider_type` enum('male','female') COLLATE utf8mb4_unicode_ci NOT NULL,
  `service_place` enum('center','home') COLLATE utf8mb4_unicode_ci NOT NULL,
  `serviceType_id` int(10) UNSIGNED NOT NULL,
  `provider_id` int(10) UNSIGNED NOT NULL,
  `company_id` int(10) UNSIGNED NOT NULL,
  `district_id` int(10) UNSIGNED NOT NULL,
  `price` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `photo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `seen_count` bigint(20) UNSIGNED NOT NULL,
  `status` tinyint(4) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`id`, `name`, `description`, `gender_type`, `provider_type`, `service_place`, `serviceType_id`, `provider_id`, `company_id`, `district_id`, `price`, `photo`, `seen_count`, `status`, `created_at`, `updated_at`) VALUES
(2, 'name', 'service description', 'male', 'male', 'center', 1, 4, 6, 3, '122', '', 0, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `service_translations`
--

CREATE TABLE `service_translations` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `service_id` int(10) UNSIGNED NOT NULL,
  `locale` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `service_types`
--

CREATE TABLE `service_types` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `gender_type` enum('male','female','both') COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` int(10) UNSIGNED NOT NULL,
  `status` tinyint(4) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `service_types`
--

INSERT INTO `service_types` (`id`, `name`, `gender_type`, `created_by`, `status`, `created_at`, `updated_at`) VALUES
(1, 'service type', 'male', 1, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `service_type_translations`
--

CREATE TABLE `service_type_translations` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `service_type_id` int(10) UNSIGNED NOT NULL,
  `locale` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int(11) NOT NULL,
  `key` varchar(255) NOT NULL,
  `body` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `key`, `body`, `created_at`, `updated_at`) VALUES
(1, 'about_app_name', 'عن التطبيق', '2018-03-08 09:39:24', '2018-03-08 09:39:24'),
(2, 'about_app_desc', '<p>بيانات عن التطبيق&nbsp;بيانات عن التطبيق&nbsp;بيانات عن التطبيق&nbsp;بيانات عن التطبيق</p>\r\n\r\n<p>بيانات عن التطبيق&nbsp;بيانات عن التطبيق&nbsp;بيانات عن التطبيق&nbsp;بيانات عن التطبيق</p>', '2018-03-08 09:39:24', '2018-03-08 09:39:24'),
(3, 'about_app_image', 'files/settings/1520509164.google play bg.png', '2018-03-08 11:39:25', '2018-03-08 09:39:25'),
(4, 'terms_title', 'بنود الاستخدام', '2018-03-14 07:51:24', '2018-03-14 05:51:24'),
(5, 'terms', '<ul>\r\n	<li>بنود استخدام التطبيق</li>\r\n	<li>بنود استخدام التطبيق</li>\r\n	<li>بنود استخدام التطبيق</li>\r\n</ul>', '2018-03-08 11:43:26', '2018-03-08 09:43:26'),
(6, 'facebook', 'fb.com', '2018-03-08 09:41:43', '2018-03-08 09:41:43'),
(7, 'twitter', 'twitter.com', '2018-03-08 09:41:43', '2018-03-08 09:41:43'),
(8, 'instagram', 'instagram.com', '2018-03-08 09:41:43', '2018-03-08 09:41:43'),
(9, 'comment_setting', '2', '2018-03-11 09:13:42', '2018-03-11 07:13:42'),
(10, 'comment_agree', '0', '2018-03-11 09:20:25', '2018-03-11 07:20:25'),
(11, 'rate_setting', '2', '2018-03-11 09:27:11', '2018-03-11 07:27:11'),
(12, 'rate_agree', '1', '2018-03-11 09:27:30', '2018-03-11 07:27:30'),
(13, 'commission', '5', '2018-03-15 08:47:21', '2018-03-14 06:01:13');

-- --------------------------------------------------------

--
-- Table structure for table `supports`
--

CREATE TABLE `supports` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `parent_id` int(11) NOT NULL,
  `type` tinyint(4) NOT NULL,
  `reply_type` tinyint(4) NOT NULL,
  `message` longtext NOT NULL,
  `is_read` tinyint(4) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `supports`
--

INSERT INTO `supports` (`id`, `user_id`, `email`, `phone`, `name`, `parent_id`, `type`, `reply_type`, `message`, `is_read`, `created_at`, `updated_at`) VALUES
(1, 3, 'inass@inas.com', '0123456', 'inass', 0, 1, 0, 'contact', 1, '2018-03-14 08:16:55', '2018-03-14 06:16:55'),
(2, 1, '', '', '', 1, -1, 0, 'message reply', 0, '2018-03-14 06:18:21', '2018-03-14 06:18:21');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `gender` enum('male','female') COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `action_code` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_invited` tinyint(1) NOT NULL,
  `is_active` tinyint(1) NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `api_token` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `is_suspend` tinyint(4) NOT NULL,
  `is_online` tinyint(4) NOT NULL,
  `is_user` tinyint(4) NOT NULL,
  `is_provider` tinyint(4) NOT NULL,
  `reject_reason` text COLLATE utf8mb4_unicode_ci,
  `is_approved` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `username`, `phone`, `email`, `password`, `image`, `gender`, `code`, `action_code`, `address`, `is_invited`, `is_active`, `remember_token`, `api_token`, `created_at`, `updated_at`, `is_suspend`, `is_online`, `is_user`, `is_provider`, `reject_reason`, `is_approved`) VALUES
(1, 'سند', 'سند', '01234567', 'saned@saned.sa', '$2y$10$l.9UoMrDd9932oz/yjX6feyqitjl2dHkTvEut.GHyim1VKSth1LNe', '', 'female', '', '1234', 'aaaaa', 0, 1, NULL, '', '2018-03-06 22:00:00', '2018-03-12 08:17:34', 0, 0, 0, 0, '', 0),
(2, 'enass', 'enas', '01234', 'enas@enas.com', '$2y$10$o3YWa8EIciAgnwHFYRSfa.eGHKw43V4jCgcYdz9lQ8XWpeWUVUbza', 'http://localhost:8000/files/users/1520512906.0orqzSsqc5uXXJ19Y8O8google play bg.png', 'male', '79669370', '', 'address', 0, 1, 'UvvJEZFkXwgvb8ph5AgttPFVPbhRepaMoRH3HTak', '8sDizpx8JNb97coZkF5YzKK6I530rswtDpd6p6wVia6QTTEzUXVwAaRArvnq', '2018-03-08 10:41:47', '2018-03-08 12:14:37', 0, 0, 0, 1, '', 0),
(4, 'inas', '', '012345', 'einas@enas.com', '$2y$10$QEVLWjAEwfuEZ.awhpuF6.8nhOiZhhpMs4hcCUjwgAK4mvVFeg0ru', 'http://localhost:8000/files/users/1520513067.bbmT7SgBqm5Gr3nf2gg7google play bg.png', 'male', '43862041', '', 'address', 0, 1, 'UvvJEZFkXwgvb8ph5AgttPFVPbhRepaMoRH3HTak', 'VBf0muTHibbSiPhBZpE6Thw3GrisFkEc2pczY2zpBgGnicpob8pNyYhTbQwM', '2018-03-08 10:44:27', '2018-03-13 05:53:58', 1, 0, 1, 0, '', 0),
(5, 'saned2', 'sanedd2', '0123455', 'saned2@saned.sa', '$2y$10$QEVLWjAEwfuEZ.awhpuF6.8nhOiZhhpMs4hcCUjwgAK4mvVFeg0ru', 'http://localhost:8000/files/users/1520513067.bbmT7SgBqm5Gr3nf2gg7google play bg.png', 'male', '43862041', '', 'address', 0, 1, 'UvvJEZFkXwgvb8ph5AgttPFVPbhRepaMoRH3HTak', 'VBf0muTHibbSiPhBZpE6Thw3GrisFkEc2pczY2zpBgGnicpob8pNyYhTbQwM', '2018-03-08 10:44:27', '2018-03-13 05:23:06', 0, 0, 1, 1, '', 1);

-- --------------------------------------------------------

--
-- Table structure for table `user_discounts`
--

CREATE TABLE `user_discounts` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `registered_users_no` int(11) NOT NULL,
  `discount` varchar(100) NOT NULL,
  `max_orders` int(11) NOT NULL,
  `from_date` date NOT NULL,
  `to_date` date NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user_discounts`
--

INSERT INTO `user_discounts` (`id`, `user_id`, `created_by`, `registered_users_no`, `discount`, `max_orders`, `from_date`, `to_date`, `created_at`, `updated_at`) VALUES
(1, 2, 1, 2, '33', 3, '2018-03-20', '2018-03-22', '2018-03-18 10:48:39', '2018-03-18 10:48:39'),
(2, 2, 1, 2, '33', 3, '2018-03-20', '2018-03-22', '2018-03-18 10:49:03', '2018-03-18 10:49:03'),
(3, 2, 1, 2, '44', 1, '2018-03-19', '2018-03-27', '2018-03-18 10:52:06', '2018-03-18 10:52:06'),
(4, 2, 1, 2, '20', 1, '2018-03-20', '2018-03-29', '2018-03-18 11:07:07', '2018-03-18 11:07:07'),
(5, 2, 1, 2, '33', 3, '2018-03-26', '2018-03-27', '2018-03-18 11:24:29', '2018-03-18 11:24:29'),
(6, 2, 1, 2, '20', 2, '2018-03-19', '2018-03-30', '2018-03-18 11:37:30', '2018-03-18 11:37:30'),
(7, 2, 1, 2, '22', 2, '2018-03-26', '2018-03-31', '2018-03-18 11:39:06', '2018-03-18 11:39:06'),
(8, 2, 1, 2, '22', 2, '2018-03-28', '2018-03-29', '2018-03-18 11:43:09', '2018-03-18 11:43:09');

-- --------------------------------------------------------

--
-- Table structure for table `user_invitations`
--

CREATE TABLE `user_invitations` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `invited_by` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_invitations`
--

INSERT INTO `user_invitations` (`id`, `user_id`, `invited_by`, `created_at`, `updated_at`) VALUES
(1, 4, 2, NULL, NULL),
(2, 5, 2, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `abilities`
--
ALTER TABLE `abilities`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `abilities_unique_index` (`name`,`entity_id`,`entity_type`,`only_owned`);

--
-- Indexes for table `abuses`
--
ALTER TABLE `abuses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `reports_user_id_foreign` (`user_id`);

--
-- Indexes for table `app_ratios`
--
ALTER TABLE `app_ratios`
  ADD PRIMARY KEY (`id`),
  ADD KEY `app_ratios_provider_id_foreign` (`provider_id`),
  ADD KEY `app_ratios_service_id_foreign` (`service_id`),
  ADD KEY `app_ratios_order_id_foreign` (`order_id`);

--
-- Indexes for table `assigned_roles`
--
ALTER TABLE `assigned_roles`
  ADD KEY `assigned_roles_entity_id_entity_type_index` (`entity_id`,`entity_type`),
  ADD KEY `assigned_roles_role_id_index` (`role_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `centers`
--
ALTER TABLE `centers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `centers_phone_unique` (`phone`),
  ADD KEY `centers_user_id_foreign` (`user_id`),
  ADD KEY `centers_city_id_foreign` (`city_id`);

--
-- Indexes for table `cities`
--
ALTER TABLE `cities`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cities_created_by_foreign` (`created_by`);

--
-- Indexes for table `city_translations`
--
ALTER TABLE `city_translations`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `city_translations_city_id_locale_unique` (`city_id`,`locale`),
  ADD KEY `city_translations_locale_index` (`locale`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `comments_commentable_id_index` (`commentable_id`),
  ADD KEY `comments_commentable_type_index` (`commentable_type`);

--
-- Indexes for table `comments_old`
--
ALTER TABLE `comments_old`
  ADD PRIMARY KEY (`id`),
  ADD KEY `comments_user_id_foreign` (`user_id`);

--
-- Indexes for table `companies`
--
ALTER TABLE `companies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `company_translations`
--
ALTER TABLE `company_translations`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `center_translations_center_id_locale_unique` (`center_id`,`locale`),
  ADD KEY `center_translations_locale_index` (`locale`);

--
-- Indexes for table `company_work_days`
--
ALTER TABLE `company_work_days`
  ADD PRIMARY KEY (`id`),
  ADD KEY `company_work_days_company_id_foreign` (`company_id`);

--
-- Indexes for table `contact_us`
--
ALTER TABLE `contact_us`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `devices`
--
ALTER TABLE `devices`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `districts`
--
ALTER TABLE `districts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `districts_created_by_foreign` (`created_by`),
  ADD KEY `districts_city_id_foreign` (`city_id`);

--
-- Indexes for table `district_translations`
--
ALTER TABLE `district_translations`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `district_translations_district_id_locale_unique` (`district_id`,`locale`),
  ADD KEY `district_translations_locale_index` (`locale`);

--
-- Indexes for table `favourites`
--
ALTER TABLE `favourites`
  ADD PRIMARY KEY (`id`),
  ADD KEY `favourites_user_id_foreign` (`user_id`),
  ADD KEY `favourites_company_id_foreign` (`company_id`) USING BTREE;

--
-- Indexes for table `financial_accounts`
--
ALTER TABLE `financial_accounts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `images`
--
ALTER TABLE `images`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `orders_user_id_foreign` (`user_id`),
  ADD KEY `orders_service_id_foreign` (`service_id`),
  ADD KEY `company_id` (`company_id`),
  ADD KEY `provider_id` (`provider_id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD KEY `permissions_entity_id_entity_type_index` (`entity_id`,`entity_type`),
  ADD KEY `permissions_ability_id_index` (`ability_id`);

--
-- Indexes for table `rates`
--
ALTER TABLE `rates`
  ADD PRIMARY KEY (`id`),
  ADD KEY `rates_user_id_foreign` (`user_id`),
  ADD KEY `rates_company_id_foreign` (`company_id`) USING BTREE;

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_unique` (`name`);

--
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`),
  ADD KEY `services_servicetype_id_foreign` (`serviceType_id`),
  ADD KEY `services_provider_id_foreign` (`provider_id`),
  ADD KEY `services_district_id_foreign` (`district_id`),
  ADD KEY `services_company_id_foreign` (`company_id`) USING BTREE;

--
-- Indexes for table `service_translations`
--
ALTER TABLE `service_translations`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `service_translations_service_id_locale_unique` (`service_id`,`locale`),
  ADD KEY `service_translations_locale_index` (`locale`);

--
-- Indexes for table `service_types`
--
ALTER TABLE `service_types`
  ADD PRIMARY KEY (`id`),
  ADD KEY `service_types_created_by_foreign` (`created_by`);

--
-- Indexes for table `service_type_translations`
--
ALTER TABLE `service_type_translations`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `service_type_translations_service_type_id_locale_unique` (`service_type_id`,`locale`),
  ADD KEY `service_type_translations_locale_index` (`locale`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `supports`
--
ALTER TABLE `supports`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_phone_unique` (`phone`);

--
-- Indexes for table `user_discounts`
--
ALTER TABLE `user_discounts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_invitations`
--
ALTER TABLE `user_invitations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_invitations_user_id_foreign` (`user_id`),
  ADD KEY `user_invitations_invited_by_foreign` (`invited_by`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `abilities`
--
ALTER TABLE `abilities`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `abuses`
--
ALTER TABLE `abuses`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `app_ratios`
--
ALTER TABLE `app_ratios`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `centers`
--
ALTER TABLE `centers`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cities`
--
ALTER TABLE `cities`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `city_translations`
--
ALTER TABLE `city_translations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

--
-- AUTO_INCREMENT for table `comments_old`
--
ALTER TABLE `comments_old`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `companies`
--
ALTER TABLE `companies`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `company_translations`
--
ALTER TABLE `company_translations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `company_work_days`
--
ALTER TABLE `company_work_days`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `contact_us`
--
ALTER TABLE `contact_us`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `devices`
--
ALTER TABLE `devices`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `districts`
--
ALTER TABLE `districts`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `district_translations`
--
ALTER TABLE `district_translations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `favourites`
--
ALTER TABLE `favourites`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `financial_accounts`
--
ALTER TABLE `financial_accounts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `images`
--
ALTER TABLE `images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `rates`
--
ALTER TABLE `rates`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `service_translations`
--
ALTER TABLE `service_translations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `service_types`
--
ALTER TABLE `service_types`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `service_type_translations`
--
ALTER TABLE `service_type_translations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `supports`
--
ALTER TABLE `supports`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `user_discounts`
--
ALTER TABLE `user_discounts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `user_invitations`
--
ALTER TABLE `user_invitations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `abuses`
--
ALTER TABLE `abuses`
  ADD CONSTRAINT `reports_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `app_ratios`
--
ALTER TABLE `app_ratios`
  ADD CONSTRAINT `app_ratios_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `app_ratios_provider_id_foreign` FOREIGN KEY (`provider_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `app_ratios_service_id_foreign` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `assigned_roles`
--
ALTER TABLE `assigned_roles`
  ADD CONSTRAINT `assigned_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `centers`
--
ALTER TABLE `centers`
  ADD CONSTRAINT `centers_city_id_foreign` FOREIGN KEY (`city_id`) REFERENCES `cities` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `centers_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `cities`
--
ALTER TABLE `cities`
  ADD CONSTRAINT `cities_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `comments_old`
--
ALTER TABLE `comments_old`
  ADD CONSTRAINT `comments_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `company_work_days`
--
ALTER TABLE `company_work_days`
  ADD CONSTRAINT `company_work_days_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `districts`
--
ALTER TABLE `districts`
  ADD CONSTRAINT `districts_city_id_foreign` FOREIGN KEY (`city_id`) REFERENCES `cities` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `districts_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `favourites`
--
ALTER TABLE `favourites`
  ADD CONSTRAINT `favourites_service_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `services` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `favourites_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `orders_service_id_foreign` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `orders_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `permissions`
--
ALTER TABLE `permissions`
  ADD CONSTRAINT `permissions_ability_id_foreign` FOREIGN KEY (`ability_id`) REFERENCES `abilities` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `rates`
--
ALTER TABLE `rates`
  ADD CONSTRAINT `rates_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `rates_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `services`
--
ALTER TABLE `services`
  ADD CONSTRAINT `services_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `services_district_id_foreign` FOREIGN KEY (`district_id`) REFERENCES `districts` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `services_provider_id_foreign` FOREIGN KEY (`provider_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `services_servicetype_id_foreign` FOREIGN KEY (`serviceType_id`) REFERENCES `service_types` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `service_types`
--
ALTER TABLE `service_types`
  ADD CONSTRAINT `service_types_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `user_invitations`
--
ALTER TABLE `user_invitations`
  ADD CONSTRAINT `user_invitations_invited_by_foreign` FOREIGN KEY (`invited_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_invitations_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
