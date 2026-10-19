-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 13, 2026 at 04:10 AM
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
-- Database: `tripora`
--

-- --------------------------------------------------------

--
-- Table structure for table `audit_logs`
--

CREATE TABLE `audit_logs` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `action` varchar(80) NOT NULL,
  `detail` varchar(500) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `audit_logs`
--

INSERT INTO `audit_logs` (`id`, `user_id`, `action`, `detail`, `created_at`) VALUES
(1, 3, 'booking_cancel', '1', '2026-10-09 10:55:06'),
(2, 3, 'settings', 'Updated site settings', '2026-10-09 10:56:54'),
(3, 3, 'payment_verify', '2', '2026-10-09 11:08:07'),
(4, 3, 'payment_refunded', '1', '2026-10-09 11:09:33'),
(5, 3, 'payment_verify', '3', '2026-10-09 12:53:28'),
(6, 3, 'customer_toggle', '2', '2026-10-09 17:19:06'),
(7, 3, 'save_destinations', '1', '2026-10-11 02:38:41'),
(8, 3, 'save_destinations', '2', '2026-10-11 02:39:52'),
(9, 3, 'save_destinations', '3', '2026-10-11 02:40:01'),
(10, 3, 'save_destinations', '4', '2026-10-11 02:40:12'),
(11, 3, 'save_destinations', '5', '2026-10-11 02:40:24'),
(12, 3, 'save_countries', '6', '2026-10-11 02:43:09'),
(13, 3, 'save_countries', '6', '2026-10-11 02:43:13'),
(14, 3, 'save_destinations', '6', '2026-10-11 02:43:35'),
(15, 3, 'save_destinations', '7', '2026-10-11 02:43:54'),
(16, 3, 'save_destinations', '8', '2026-10-11 02:44:07'),
(17, 3, 'save_destinations', '9', '2026-10-11 02:44:20'),
(18, 3, 'save_destinations', '10', '2026-10-11 02:44:34'),
(19, 3, 'customer_toggle', '2', '2026-10-11 06:24:20'),
(20, 3, 'save_promotions', '1', '2026-10-11 06:25:00'),
(21, 3, 'gallery_add', '5', '2026-10-11 12:03:34'),
(22, 3, 'gallery_add', '5', '2026-10-11 12:03:41'),
(23, 3, 'gallery_remove', '5', '2026-10-11 12:03:43'),
(24, 3, 'gallery_add', '5', '2026-10-11 12:03:47'),
(25, 3, 'gallery_remove', '5', '2026-10-11 12:03:49'),
(26, 3, 'save_destinations', '5', '2026-10-11 12:03:59'),
(27, 3, 'save_destinations', '5', '2026-10-11 12:04:10'),
(28, 3, 'gallery_remove', '5', '2026-10-11 12:04:18'),
(29, 3, 'save_destinations', '5', '2026-10-11 12:04:20'),
(30, 3, 'gallery_add', '4', '2026-10-11 12:04:36'),
(31, 3, 'gallery_add', '4', '2026-10-11 12:04:39'),
(32, 3, 'save_destinations', '4', '2026-10-11 12:04:40'),
(33, 3, 'save_destinations', '4', '2026-10-11 12:04:50'),
(34, 3, 'gallery_add', '3', '2026-10-11 12:07:10'),
(35, 3, 'gallery_add', '3', '2026-10-11 12:07:12'),
(36, 3, 'save_destinations', '3', '2026-10-11 12:07:16'),
(37, 3, 'gallery_add', '2', '2026-10-11 12:07:31'),
(38, 3, 'gallery_add', '2', '2026-10-11 12:07:33'),
(39, 3, 'save_destinations', '2', '2026-10-11 12:07:35'),
(40, 3, 'gallery_add', '1', '2026-10-11 12:07:54'),
(41, 3, 'gallery_add', '1', '2026-10-11 12:08:00'),
(42, 3, 'save_destinations', '1', '2026-10-11 12:08:02'),
(43, 3, 'gallery_add', '15', '2026-10-11 12:10:11'),
(44, 3, 'gallery_add', '15', '2026-10-11 12:10:14'),
(45, 3, 'gallery_add', '15', '2026-10-11 12:10:17'),
(46, 3, 'save_destinations', '15', '2026-10-11 12:10:26'),
(47, 3, 'gallery_remove', '15', '2026-10-11 12:10:32'),
(48, 3, 'save_destinations', '15', '2026-10-11 12:10:33'),
(49, 3, 'gallery_add', '14', '2026-10-11 12:10:51'),
(50, 3, 'gallery_add', '14', '2026-10-11 12:10:54'),
(51, 3, 'save_destinations', '14', '2026-10-11 12:10:55'),
(52, 3, 'gallery_add', '13', '2026-10-11 12:11:11'),
(53, 3, 'gallery_add', '13', '2026-10-11 12:11:13'),
(54, 3, 'save_destinations', '13', '2026-10-11 12:11:20'),
(55, 3, 'gallery_add', '12', '2026-10-11 12:11:38'),
(56, 3, 'gallery_add', '12', '2026-10-11 12:11:38'),
(57, 3, 'save_destinations', '12', '2026-10-11 12:11:42'),
(58, 3, 'gallery_add', '11', '2026-10-11 12:12:29'),
(59, 3, 'gallery_add', '11', '2026-10-11 12:12:32'),
(60, 3, 'save_destinations', '11', '2026-10-11 12:12:33'),
(61, 3, 'save_destinations', '11', '2026-10-11 12:12:40'),
(62, 3, 'gallery_add', '20', '2026-10-11 12:13:06'),
(63, 3, 'gallery_add', '20', '2026-10-11 12:13:10'),
(64, 3, 'gallery_add', '20', '2026-10-11 12:13:10'),
(65, 3, 'save_destinations', '20', '2026-10-11 12:13:15'),
(66, 3, 'gallery_add', '19', '2026-10-11 12:14:05'),
(67, 3, 'gallery_add', '19', '2026-10-11 12:14:05'),
(68, 3, 'save_destinations', '19', '2026-10-11 12:14:08'),
(69, 3, 'gallery_remove', '20', '2026-10-11 12:14:16'),
(70, 3, 'save_destinations', '20', '2026-10-11 12:14:25'),
(71, 3, 'save_destinations', '20', '2026-10-11 12:14:29'),
(72, 3, 'gallery_add', '18', '2026-10-11 12:14:43'),
(73, 3, 'gallery_add', '18', '2026-10-11 12:14:48'),
(74, 3, 'save_destinations', '18', '2026-10-11 12:14:54'),
(75, 3, 'save_destinations', '18', '2026-10-11 12:15:00'),
(76, 3, 'gallery_add', '17', '2026-10-11 12:15:15'),
(77, 3, 'gallery_add', '17', '2026-10-11 12:15:15'),
(78, 3, 'save_destinations', '17', '2026-10-11 12:15:20'),
(79, 3, 'gallery_add', '16', '2026-10-11 12:15:45'),
(80, 3, 'gallery_add', '16', '2026-10-11 12:15:45'),
(81, 3, 'save_destinations', '16', '2026-10-11 12:15:47'),
(82, 3, 'gallery_add', '30', '2026-10-11 12:16:06'),
(83, 3, 'gallery_add', '30', '2026-10-11 12:16:07'),
(84, 3, 'gallery_add', '30', '2026-10-11 12:16:07'),
(85, 3, 'save_destinations', '30', '2026-10-11 12:16:09'),
(86, 3, 'gallery_add', '29', '2026-10-11 12:16:22'),
(87, 3, 'gallery_add', '29', '2026-10-11 12:16:22'),
(88, 3, 'gallery_add', '29', '2026-10-11 12:16:22'),
(89, 3, 'save_destinations', '29', '2026-10-11 12:16:24'),
(90, 3, 'gallery_add', '28', '2026-10-11 12:16:34'),
(91, 3, 'gallery_add', '28', '2026-10-11 12:16:34'),
(92, 3, 'gallery_add', '28', '2026-10-11 12:16:34'),
(93, 3, 'save_destinations', '28', '2026-10-11 12:16:36'),
(94, 3, 'gallery_add', '27', '2026-10-11 12:16:46'),
(95, 3, 'gallery_add', '27', '2026-10-11 12:16:46'),
(96, 3, 'gallery_add', '27', '2026-10-11 12:16:46'),
(97, 3, 'save_destinations', '27', '2026-10-11 12:16:48'),
(98, 3, 'gallery_add', '26', '2026-10-11 12:16:57'),
(99, 3, 'gallery_add', '26', '2026-10-11 12:16:57'),
(100, 3, 'gallery_add', '26', '2026-10-11 12:16:57'),
(101, 3, 'save_destinations', '26', '2026-10-11 12:17:01'),
(102, 3, 'gallery_add', '25', '2026-10-11 12:17:32'),
(103, 3, 'gallery_add', '25', '2026-10-11 12:17:32'),
(104, 3, 'save_destinations', '25', '2026-10-11 12:17:36'),
(105, 3, 'gallery_add', '24', '2026-10-11 12:17:51'),
(106, 3, 'gallery_add', '24', '2026-10-11 12:17:51'),
(107, 3, 'save_destinations', '24', '2026-10-11 12:17:54'),
(108, 3, 'gallery_add', '23', '2026-10-11 12:18:10'),
(109, 3, 'gallery_add', '23', '2026-10-11 12:18:10'),
(110, 3, 'save_destinations', '23', '2026-10-11 12:18:15'),
(111, 3, 'gallery_add', '22', '2026-10-11 12:18:33'),
(112, 3, 'gallery_add', '22', '2026-10-11 12:18:33'),
(113, 3, 'save_destinations', '22', '2026-10-11 12:18:37'),
(114, 3, 'save_destinations', '22', '2026-10-11 12:19:58'),
(115, 3, 'save_destinations', '23', '2026-10-11 12:20:05'),
(116, 3, 'gallery_add', '21', '2026-10-11 12:20:39'),
(117, 3, 'gallery_add', '21', '2026-10-11 12:20:39'),
(118, 3, 'save_destinations', '21', '2026-10-11 12:20:40'),
(119, 3, 'gallery_add', '10', '2026-10-11 12:21:27'),
(120, 3, 'gallery_add', '10', '2026-10-11 12:21:27'),
(121, 3, 'save_destinations', '10', '2026-10-11 12:21:31'),
(122, 3, 'gallery_add', '9', '2026-10-11 12:21:45'),
(123, 3, 'gallery_add', '9', '2026-10-11 12:21:45'),
(124, 3, 'save_destinations', '9', '2026-10-11 12:21:47'),
(125, 3, 'gallery_add', '8', '2026-10-11 12:22:01'),
(126, 3, 'gallery_add', '8', '2026-10-11 12:22:01'),
(127, 3, 'save_destinations', '8', '2026-10-11 12:22:08'),
(128, 3, 'gallery_add', '7', '2026-10-11 12:22:22'),
(129, 3, 'gallery_add', '7', '2026-10-11 12:22:22'),
(130, 3, 'save_destinations', '7', '2026-10-11 12:22:24'),
(131, 3, 'gallery_add', '6', '2026-10-11 12:22:36'),
(132, 3, 'gallery_add', '6', '2026-10-11 12:22:36'),
(133, 3, 'save_destinations', '6', '2026-10-11 12:22:37');

-- --------------------------------------------------------

--
-- Table structure for table `auth_tokens`
--

CREATE TABLE `auth_tokens` (
  `id` int(10) UNSIGNED NOT NULL,
  `email` varchar(190) NOT NULL,
  `kind` enum('verify','reset','change') NOT NULL,
  `code_hash` varchar(255) NOT NULL,
  `expires_at` datetime NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL DEFAULT 0,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `auth_tokens`
--

INSERT INTO `auth_tokens` (`id`, `email`, `kind`, `code_hash`, `expires_at`, `attempts`, `created_at`) VALUES
(17, 'mgmamarry2030@gmail.com', 'reset', '$2y$10$M7/jfgn3UIbE1p1VoMcij.U8MCwGeev75Gh5p/XAYcPLeVGf2gYka', '2026-10-11 04:18:23', 0, '2026-10-11 04:08:23');

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `id` int(10) UNSIGNED NOT NULL,
  `reference` varchar(40) NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `room_id` int(10) UNSIGNED NOT NULL,
  `guest_name` varchar(120) NOT NULL,
  `phone` varchar(40) NOT NULL,
  `guests` smallint(5) UNSIGNED NOT NULL,
  `check_in` date NOT NULL,
  `check_out` date NOT NULL,
  `nights` smallint(5) UNSIGNED NOT NULL,
  `nightly_price` decimal(10,2) NOT NULL,
  `subtotal` decimal(12,2) NOT NULL,
  `discount` decimal(12,2) NOT NULL DEFAULT 0.00,
  `total` decimal(12,2) NOT NULL,
  `promotion_id` int(10) UNSIGNED DEFAULT NULL,
  `status` enum('pending_payment','awaiting_review','confirmed','completed','cancelled','expired') NOT NULL DEFAULT 'pending_payment',
  `expires_at` datetime DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`id`, `reference`, `user_id`, `room_id`, `guest_name`, `phone`, `guests`, `check_in`, `check_out`, `nights`, `nightly_price`, `subtotal`, `discount`, `total`, `promotion_id`, `status`, `expires_at`, `created_at`) VALUES
(1, 'TRP-261009-6AFB92DF', 2, 25, 'Naing min Htet', '09779772319', 2, '2026-10-09', '2026-10-10', 1, 81.00, 81.00, 0.00, 81.00, NULL, 'cancelled', NULL, '2026-10-09 10:50:23'),
(2, 'TRP-261009-75047DA9', 3, 62, 'Naing min Htet', '09779772319', 2, '2026-10-09', '2026-10-10', 1, 158.00, 158.00, 0.00, 158.00, NULL, 'confirmed', NULL, '2026-10-09 11:05:44'),
(3, 'TRP-261009-DA986FC3', 2, 91, 'Naing min Htet', '09779772319', 2, '2026-10-09', '2026-10-10', 1, 129.00, 129.00, 0.00, 129.00, NULL, 'confirmed', NULL, '2026-10-09 12:51:29');

-- --------------------------------------------------------

--
-- Table structure for table `contacts`
--

CREATE TABLE `contacts` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(120) NOT NULL,
  `email` varchar(190) NOT NULL,
  `message` text NOT NULL,
  `status` enum('new','resolved') NOT NULL DEFAULT 'new',
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `contacts`
--

INSERT INTO `contacts` (`id`, `name`, `email`, `message`, `status`, `created_at`) VALUES
(1, 'Min Khant Kyaw', 'mgmamarry2030@gmail.com', 'hi', 'resolved', '2026-10-09 10:57:58'),
(2, 'Min Khant Kyaw', 'mgmamarry2030@gmail.com', 'hi', 'new', '2026-10-09 11:11:46');

-- --------------------------------------------------------

--
-- Table structure for table `countries`
--

CREATE TABLE `countries` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(190) NOT NULL,
  `description` text NOT NULL,
  `season` varchar(190) NOT NULL,
  `currency` varchar(190) NOT NULL,
  `attractions` text NOT NULL,
  `image` varchar(255) NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `countries`
--

INSERT INTO `countries` (`id`, `name`, `description`, `season`, `currency`, `attractions`, `image`, `active`) VALUES
(1, 'Japan', 'Old streets, lively neighborhoods and small moments of calm.', 'Plan around your preferred weather; check local forecasts.', 'Japanese yen (JPY)', 'Historic streets, gardens and local food', 'public/images/kyoto.jpg', 1),
(2, 'Thailand', 'A journey through welcoming cities, green landscapes and coastal escapes.', 'Check regional weather and local forecasts before booking.', 'Thai baht (THB)', 'Street food, markets and beaches', 'public/images/thailand.jpg', 1),
(3, 'Indonesia', 'Island scenery, creative neighborhoods and places to slow down.', 'Choose dates using local seasonal forecasts.', 'Indonesian rupiah (IDR)', 'Nature walks, coastal scenery and local crafts', 'public/images/bali.jpg', 1),
(4, 'Morocco', 'Courtyards, colorful markets and journeys with a little extra texture.', 'Check temperatures for your route before traveling.', 'Moroccan dirham (MAD)', 'Historic medinas, artisan markets and architecture', 'public/images/morocco.jpg', 1),
(5, 'Switzerland', 'Mountain air, lakeside days and a fresh perspective.', 'Plan for your activities and check mountain conditions.', 'Swiss franc (CHF)', 'Alpine scenery, lakes and scenic walks', 'public/images/switzerland.jpg', 1),
(6, 'Myanmar', 'A demonstration country guide featuring city landmarks, historic pagodas, lake scenery and coastal landscapes. Listings and prices are fictional; check current local conditions before making real travel plans.', 'Check current local weather and conditions before planning.', 'Myanmar kyat (MMK)', 'City landmarks, pagodas, lakes and coastal landscapes', 'public/images/bagan.jpg', 1);

-- --------------------------------------------------------

--
-- Table structure for table `destinations`
--

CREATE TABLE `destinations` (
  `id` int(10) UNSIGNED NOT NULL,
  `country_id` int(10) UNSIGNED NOT NULL,
  `name` varchar(190) NOT NULL,
  `description` text NOT NULL,
  `location` varchar(190) NOT NULL,
  `activities` text NOT NULL,
  `image` varchar(255) NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 1,
  `image_2` varchar(255) DEFAULT NULL,
  `image_3` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `destinations`
--

INSERT INTO `destinations` (`id`, `country_id`, `name`, `description`, `location`, `activities`, `image`, `active`, `image_2`, `image_3`) VALUES
(1, 1, 'Kyoto', 'Make time for the everyday details. Explore Kyoto at your own pace.', 'Kyoto, Japan', 'Neighborhood walks, local dining and time to unwind', 'public/uploads/df2b52652a2889ea1865a916a446c1bb.jpg', 1, NULL, NULL),
(2, 1, 'Tokyo', 'Make time for the everyday details. Explore Tokyo at your own pace.', 'Tokyo, Japan', 'Neighborhood walks, local dining and time to unwind', 'public/uploads/f10ea42e7a3e884b9468b730d2d4f556.jpg', 1, NULL, NULL),
(3, 1, 'Osaka', 'Make time for the everyday details. Explore Osaka at your own pace.', 'Osaka, Japan', 'Neighborhood walks, local dining and time to unwind', 'public/uploads/633fa55483b21c0e272e2c8387b30aba.jpg', 1, NULL, NULL),
(4, 1, 'Nara', 'Make time for the everyday details. Explore Nara at your own pace.', 'Nara, Japan', 'Neighborhood walks, local dining and time to unwind', 'public/uploads/71131713c57169b36133ebb7ee935f5c.jpg', 1, NULL, NULL),
(5, 1, 'Hakone', 'Make time for the everyday details. Explore Hakone at your own pace.', 'Hakone, Japan', 'Neighborhood walks, local dining and time to unwind', 'public/uploads/7d8403f0f7b72e5a8b22e85b243ea5fa.jpg', 1, 'public/images/hakone-open-air.png', 'public/images/hakone-railway.png'),
(6, 2, 'Bangkok', 'Make time for the everyday details. Explore Bangkok at your own pace.', 'Bangkok, Thailand', 'Neighborhood walks, local dining and time to unwind', 'public/uploads/416ae3756cda74c08909ed46e0ad45a4.jpg', 1, NULL, NULL),
(7, 2, 'Chiang Mai', 'Make time for the everyday details. Explore Chiang Mai at your own pace.', 'Chiang Mai, Thailand', 'Neighborhood walks, local dining and time to unwind', 'public/uploads/6399b1394479eab7693dfa48410ff793.jpg', 1, NULL, NULL),
(8, 2, 'Phuket', 'Make time for the everyday details. Explore Phuket at your own pace.', 'Phuket, Thailand', 'Neighborhood walks, local dining and time to unwind', 'public/uploads/41afccdf662fa6316452398ff73f0582.jpg', 1, NULL, NULL),
(9, 2, 'Krabi', 'Make time for the everyday details. Explore Krabi at your own pace.', 'Krabi, Thailand', 'Neighborhood walks, local dining and time to unwind', 'public/uploads/ff476c523924eabadcea46bfadd01c9c.jpg', 1, NULL, NULL),
(10, 2, 'Koh Samui', 'Make time for the everyday details. Explore Koh Samui at your own pace.', 'Koh Samui, Thailand', 'Neighborhood walks, local dining and time to unwind', 'public/uploads/7e1ff7b12dde66a2207321f8c590f60b.jpg', 1, NULL, NULL),
(11, 3, 'Ubud', 'Make time for the everyday details. Explore Ubud at your own pace.', 'Ubud, Indonesia', 'Neighborhood walks, local dining and time to unwind', 'public/uploads/6172513829b8460835eaf271a7a14eef.jpg', 1, NULL, NULL),
(12, 3, 'Canggu', 'Make time for the everyday details. Explore Canggu at your own pace.', 'Canggu, Indonesia', 'Neighborhood walks, local dining and time to unwind', 'public/uploads/7fda2ce9ab99681d63d24c802670b6ef.jpg', 1, NULL, NULL),
(13, 3, 'Seminyak', 'Make time for the everyday details. Explore Seminyak at your own pace.', 'Seminyak, Indonesia', 'Neighborhood walks, local dining and time to unwind', 'public/uploads/01eac37eeea2eb752bf5eb7f4e8d2f22.jpg', 1, NULL, NULL),
(14, 3, 'Yogyakarta', 'Make time for the everyday details. Explore Yogyakarta at your own pace.', 'Yogyakarta, Indonesia', 'Neighborhood walks, local dining and time to unwind', 'public/uploads/a6f2970b65f476ad71474ca65a3b6832.jpg', 1, NULL, NULL),
(15, 3, 'Lombok', 'Make time for the everyday details. Explore Lombok at your own pace.', 'Lombok, Indonesia', 'Neighborhood walks, local dining and time to unwind', 'public/uploads/73463dcb2f437be803065e6404f9ed2c.jpg', 1, NULL, NULL),
(16, 4, 'Marrakech', 'Make time for the everyday details. Explore Marrakech at your own pace.', 'Marrakech, Morocco', 'Neighborhood walks, local dining and time to unwind', 'public/uploads/bde47e5ae1dacea74a06271f6fe9d2f5.jpg', 1, NULL, NULL),
(17, 4, 'Fes', 'Make time for the everyday details. Explore Fes at your own pace.', 'Fes, Morocco', 'Neighborhood walks, local dining and time to unwind', 'public/uploads/54099df941896c4f1f1fc6cf84fd9a04.jpg', 1, NULL, NULL),
(18, 4, 'Chefchaouen', 'Make time for the everyday details. Explore Chefchaouen at your own pace.', 'Chefchaouen, Morocco', 'Neighborhood walks, local dining and time to unwind', 'public/uploads/42f2b36f45ad920a7d01890cd40359a9.jpg', 1, NULL, NULL),
(19, 4, 'Essaouira', 'Make time for the everyday details. Explore Essaouira at your own pace.', 'Essaouira, Morocco', 'Neighborhood walks, local dining and time to unwind', 'public/uploads/4cdcf4cd901847197b799065a35218f3.jpg', 1, NULL, NULL),
(20, 4, 'Rabat', 'Make time for the everyday details. Explore Rabat at your own pace.', 'Rabat, Morocco', 'Neighborhood walks, local dining and time to unwind', 'public/uploads/9fb4432b433bddc2f0e5f1d79f4dc27d.jpg', 1, NULL, NULL),
(21, 5, 'Zermatt', 'Make time for the everyday details. Explore Zermatt at your own pace.', 'Zermatt, Switzerland', 'Neighborhood walks, local dining and time to unwind', 'public/uploads/782f8017a9967a603ff4fa2a48c6ca14.jpg', 1, NULL, NULL),
(22, 5, 'Lucerne', 'Make time for the everyday details. Explore Lucerne at your own pace.', 'Lucerne, Switzerland', 'Neighborhood walks, local dining and time to unwind', 'public/uploads/be18fb1aee193a0aad1ce96c96ddc218.jpg', 1, NULL, NULL),
(23, 5, 'Interlaken', 'Make time for the everyday details. Explore Interlaken at your own pace.', 'Interlaken, Switzerland', 'Neighborhood walks, local dining and time to unwind', 'public/uploads/4a69d16286a7cc84f3c317ae079927cd.jpg', 1, NULL, NULL),
(24, 5, 'Zurich', 'Make time for the everyday details. Explore Zurich at your own pace.', 'Zurich, Switzerland', 'Neighborhood walks, local dining and time to unwind', 'public/uploads/a71789ea06074ae83eeae790ec7bdbc6.jpg', 1, NULL, NULL),
(25, 5, 'Lugano', 'Make time for the everyday details. Explore Lugano at your own pace.', 'Lugano, Switzerland', 'Neighborhood walks, local dining and time to unwind', 'public/uploads/def2c5a080f49cfb4b5d4580b117c7cd.jpg', 1, NULL, NULL),
(26, 6, 'Yangon', 'City landmarks and streets around Yangon. A sample destination guide for this demonstration.', 'Yangon, Myanmar', 'City architecture, local food and cultural landmarks', 'public/images/yangon.jpg', 1, NULL, NULL),
(27, 6, 'Mandalay', 'Pagoda architecture and cultural landmarks around Mandalay. A sample destination guide for this demonstration.', 'Mandalay, Myanmar', 'Pagoda architecture, city views and local crafts', 'public/images/mandalay.jpg', 1, NULL, NULL),
(28, 6, 'Bagan', 'Historic pagodas and broad plains around Bagan. A sample destination guide for this demonstration.', 'Bagan, Myanmar', 'Historic architecture, landscape photography and local crafts', 'public/images/bagan.jpg', 1, NULL, NULL),
(29, 6, 'Inle Lake', 'Lake scenery and communities around Inle Lake. A sample destination guide for this demonstration.', 'Inle Lake, Myanmar', 'Lake landscapes, local crafts and regional food', 'public/images/inle.jpg', 1, NULL, NULL),
(30, 6, 'Ngapali', 'Coastal scenery around Ngapali. A sample destination guide for this demonstration.', 'Ngapali, Myanmar', 'Coastal landscapes, beach scenery and local food', 'public/images/ngapali.jpg', 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `destination_images`
--

CREATE TABLE `destination_images` (
  `id` int(10) UNSIGNED NOT NULL,
  `destination_id` int(10) UNSIGNED NOT NULL,
  `image` varchar(255) NOT NULL,
  `position` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `destination_images`
--

INSERT INTO `destination_images` (`id`, `destination_id`, `image`, `position`, `created_at`) VALUES
(1, 5, 'public/images/hakone-open-air.png', 1, '2026-10-11 04:56:04'),
(2, 5, 'public/images/hakone-railway.png', 2, '2026-10-11 04:56:04'),
(6, 4, 'public/uploads/d175ae14cf7c27d32b624e9dde33d43f.jpg', 1, '2026-10-11 12:04:36'),
(7, 4, 'public/uploads/243da0e3974a78d12441483842def96f.jpg', 2, '2026-10-11 12:04:39'),
(8, 3, 'public/uploads/9fca178957ac16957ece0896bf32dda6.jpg', 1, '2026-10-11 12:07:10'),
(9, 3, 'public/uploads/1760d9554772c1604bddf5d29733eea3.jpg', 2, '2026-10-11 12:07:12'),
(10, 2, 'public/uploads/793333e0c4715df1abca814e87c80279.jpg', 1, '2026-10-11 12:07:31'),
(11, 2, 'public/uploads/03806e9927504639474bcaaced34d37b.jpg', 2, '2026-10-11 12:07:33'),
(12, 1, 'public/uploads/be4cc3b3639ade3da7db83172acd0bba.jpg', 1, '2026-10-11 12:07:54'),
(13, 1, 'public/uploads/1fbc1364bf98e0df8361e2f04fc3d9ae.jpg', 2, '2026-10-11 12:08:00'),
(15, 15, 'public/uploads/da3759024e5eb84e29aa18656091f196.jpg', 2, '2026-10-11 12:10:14'),
(16, 15, 'public/uploads/9d5aee1d5dbbb93fc35147e47ffb1750.jpg', 3, '2026-10-11 12:10:17'),
(17, 14, 'public/uploads/214c1ac29766770eeee12f930607a33a.jpg', 1, '2026-10-11 12:10:51'),
(18, 14, 'public/uploads/269af3d89aee45e78aae7965ab028768.jpg', 2, '2026-10-11 12:10:54'),
(19, 13, 'public/uploads/125a3d3d4d98f2400a1698e87541af7e.jpg', 1, '2026-10-11 12:11:11'),
(20, 13, 'public/uploads/104c510ce6ca60359269390fc801cab2.jpg', 2, '2026-10-11 12:11:13'),
(21, 12, 'public/uploads/216eeb6a2dd8d552d437a2988edb84f9.jpg', 1, '2026-10-11 12:11:38'),
(22, 12, 'public/uploads/0356b767db6d3629590aaf5f78416cca.jpg', 2, '2026-10-11 12:11:38'),
(23, 11, 'public/uploads/e2554d932c982ced87911c897cf48353.jpg', 1, '2026-10-11 12:12:29'),
(24, 11, 'public/uploads/d4b663bf5952afdfd3e5cac066056783.jpg', 2, '2026-10-11 12:12:32'),
(26, 20, 'public/uploads/12eefcbe587269312d81ce332a4dd389.jpg', 2, '2026-10-11 12:13:10'),
(27, 20, 'public/uploads/c7ce96c6cb32c3d6371045785020a4a3.jpg', 3, '2026-10-11 12:13:10'),
(28, 19, 'public/uploads/a7538ba4865bcba6221f6a02ae9cf026.jpg', 1, '2026-10-11 12:14:05'),
(29, 19, 'public/uploads/e6c6da153120a416dc28b1622c14663d.jpg', 2, '2026-10-11 12:14:05'),
(30, 18, 'public/uploads/84df41d8bc5fa2e1ff148dbfa6033980.jpg', 1, '2026-10-11 12:14:43'),
(31, 18, 'public/uploads/37a44b13ba1fa1a49719e19e782f7cc1.jpg', 2, '2026-10-11 12:14:48'),
(32, 17, 'public/uploads/ca42a892ddadaf0a0734d8482ee8b221.jpg', 1, '2026-10-11 12:15:15'),
(33, 17, 'public/uploads/0dc57376875dd404aceeebbcd193babd.jpg', 2, '2026-10-11 12:15:15'),
(34, 16, 'public/uploads/a31a38097d76fc547f563027a3e36058.jpg', 1, '2026-10-11 12:15:45'),
(35, 16, 'public/uploads/1139990520470bc7f9f3c332bbeb2d14.jpg', 2, '2026-10-11 12:15:45'),
(36, 30, 'public/uploads/6ee2a99adc9f37d4f47ec998b178a8a3.jpg', 1, '2026-10-11 12:16:06'),
(37, 30, 'public/uploads/3676d53bc254cae320362b33725bdc30.jpg', 2, '2026-10-11 12:16:07'),
(38, 30, 'public/uploads/21a66c4f1cf46d9c0007854976adceef.jpg', 3, '2026-10-11 12:16:07'),
(39, 29, 'public/uploads/e203cbf27c207e7ae01816463db8c796.jpg', 1, '2026-10-11 12:16:22'),
(40, 29, 'public/uploads/be77f54e080a6474c5e805d31205c5f5.jpg', 2, '2026-10-11 12:16:22'),
(41, 29, 'public/uploads/bf3dc5f9cb757fd5546faf42417046b1.jpg', 3, '2026-10-11 12:16:22'),
(42, 28, 'public/uploads/b1fcabcf715dd892cbd71d642fdbc4d2.jpg', 1, '2026-10-11 12:16:34'),
(43, 28, 'public/uploads/5eb456ec5d287f4057d9f971309d2485.jpg', 2, '2026-10-11 12:16:34'),
(44, 28, 'public/uploads/8b8006203a1dae29f4202c4889d21e37.jpg', 3, '2026-10-11 12:16:34'),
(45, 27, 'public/uploads/1d56e18b12fbd0f64752a73171b20500.jpg', 1, '2026-10-11 12:16:46'),
(46, 27, 'public/uploads/182148e3283c9cac932a845b73082b09.jpg', 2, '2026-10-11 12:16:46'),
(47, 27, 'public/uploads/792e67085cae5bc963fbb121f54f2872.jpg', 3, '2026-10-11 12:16:46'),
(48, 26, 'public/uploads/d613a9074cf4f8816373c356b34b2314.jpg', 1, '2026-10-11 12:16:57'),
(49, 26, 'public/uploads/a2752ddd64957ef40240e3ca2a22ae15.jpg', 2, '2026-10-11 12:16:57'),
(50, 26, 'public/uploads/b4dda3a10b961db6eec85bd75627c846.jpg', 3, '2026-10-11 12:16:57'),
(51, 25, 'public/uploads/6b5e51b8e9eaab30cd1a7af71a1d075d.jpg', 1, '2026-10-11 12:17:32'),
(52, 25, 'public/uploads/e02f02406057b1e8318b8a5d4f7af6b7.jpg', 2, '2026-10-11 12:17:32'),
(53, 24, 'public/uploads/03d9f9e573cdd69687473adb0baa5c7e.jpg', 1, '2026-10-11 12:17:51'),
(54, 24, 'public/uploads/0bc859f172daec6da784e2d0b8b900d8.jpg', 2, '2026-10-11 12:17:51'),
(55, 23, 'public/uploads/d20a9f4986af4b3be5f5a20a9bea1b0d.jpg', 1, '2026-10-11 12:18:10'),
(56, 23, 'public/uploads/7a5862ee120cc85278fefb3bf4528a8f.jpg', 2, '2026-10-11 12:18:10'),
(57, 22, 'public/uploads/6f3db2b90a8381dae69dd2292cc6a8ee.jpg', 1, '2026-10-11 12:18:33'),
(58, 22, 'public/uploads/fe759aa344639780fa557108e05b095e.jpg', 2, '2026-10-11 12:18:33'),
(59, 21, 'public/uploads/81f5cb673c180de198bb3e5c382c5e64.jpg', 1, '2026-10-11 12:20:39'),
(60, 21, 'public/uploads/634e66bac537fd9e497aaa8136cc952d.jpg', 2, '2026-10-11 12:20:39'),
(61, 10, 'public/uploads/20d852c12bde4f5e5ac7353d57204be0.jpg', 1, '2026-10-11 12:21:27'),
(62, 10, 'public/uploads/b8c8fba1ad25b0f5849924864a794669.jpg', 2, '2026-10-11 12:21:27'),
(63, 9, 'public/uploads/8c2e9df905c02b5a4354fe22b01cc61b.jpg', 1, '2026-10-11 12:21:45'),
(64, 9, 'public/uploads/fce7fabe5fa44a251266077cbc08f3b7.jpg', 2, '2026-10-11 12:21:45'),
(65, 8, 'public/uploads/7e46a76c5b49be1e15d38015cb953601.jpg', 1, '2026-10-11 12:22:01'),
(66, 8, 'public/uploads/c59f7d36f3fbae22927661716d540b1e.jpg', 2, '2026-10-11 12:22:01'),
(67, 7, 'public/uploads/53fa14fb37e101394c1ba83829308377.jpg', 1, '2026-10-11 12:22:22'),
(68, 7, 'public/uploads/90a99d50e09005fb8f32b89c3802e8c3.jpg', 2, '2026-10-11 12:22:22'),
(69, 6, 'public/uploads/0b1699f60978737acbd71172cf58d549.jpg', 1, '2026-10-11 12:22:36'),
(70, 6, 'public/uploads/b68f32de9541155277f4dcfd5e56a8c4.jpg', 2, '2026-10-11 12:22:36');

-- --------------------------------------------------------

--
-- Table structure for table `email_deliveries`
--

CREATE TABLE `email_deliveries` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `email` varchar(190) NOT NULL,
  `purpose` varchar(20) NOT NULL,
  `status` enum('accepted','failed','skipped') NOT NULL,
  `detail` varchar(500) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `email_deliveries`
--

INSERT INTO `email_deliveries` (`id`, `email`, `purpose`, `status`, `detail`, `created_at`) VALUES
(1, 'mgmamarry2030@gmail.com', 'reset', 'skipped', 'No active account matches this email. No email was sent.', '2026-10-11 04:01:16'),
(2, 'mgmamarry2030@gmail.com', 'reset', 'skipped', 'No active account matches this email. No email was sent.', '2026-10-11 04:04:33'),
(3, 'mgmamarry2030@gmail.com', 'reset', 'skipped', 'No active account matches this email. No email was sent.', '2026-10-11 04:04:53'),
(4, 'chouprobathaw19@gmail.com', 'reset', 'skipped', 'No active account matches this email. No email was sent.', '2026-10-11 04:07:37'),
(5, 'mgmamarry2030@gmail.com', 'reset', 'accepted', 'The SMTP server accepted the message. Check Inbox and Spam.', '2026-10-11 04:08:28'),
(6, 'hnaingmin21@gmail.com', 'verify', 'accepted', 'The SMTP server accepted the message. Check Inbox and Spam.', '2026-10-11 04:10:06'),
(7, 'hnaingmin21@gmail.com', 'reset', 'accepted', 'The SMTP server accepted the message. Check Inbox and Spam.', '2026-10-11 04:10:43'),
(8, 'hnaingmin21@gmail.com', 'reset', 'accepted', 'The SMTP server accepted the message. Check Inbox and Spam.', '2026-10-11 06:20:50');

-- --------------------------------------------------------

--
-- Table structure for table `hotels`
--

CREATE TABLE `hotels` (
  `id` int(10) UNSIGNED NOT NULL,
  `destination_id` int(10) UNSIGNED NOT NULL,
  `name` varchar(190) NOT NULL,
  `description` text NOT NULL,
  `address` varchar(190) NOT NULL,
  `stars` tinyint(3) UNSIGNED NOT NULL,
  `facilities` text NOT NULL,
  `image` varchar(255) NOT NULL,
  `featured` tinyint(1) NOT NULL DEFAULT 0,
  `active` tinyint(1) NOT NULL DEFAULT 1
) ;

--
-- Dumping data for table `hotels`
--

INSERT INTO `hotels` (`id`, `destination_id`, `name`, `description`, `address`, `stars`, `facilities`, `image`, `featured`, `active`) VALUES
(1, 1, 'Tripora Kyoto Garden House', 'A fictional demo stay with calm interiors, thoughtful shared spaces and a welcoming atmosphere. Replace this listing with your own verified property information.', 'Kyoto — demonstration listing; no real street address', 3, 'Wi-Fi, breakfast area, lounge, air conditioning, reception', 'public/images/hotel.jpg', 0, 1),
(2, 1, 'Tripora Kyoto Courtyard Lodge', 'A fictional demo stay with calm interiors, thoughtful shared spaces and a welcoming atmosphere. Replace this listing with your own verified property information.', 'Kyoto — demonstration listing; no real street address', 4, 'Wi-Fi, breakfast area, lounge, air conditioning, reception', 'public/images/pool.jpg', 0, 1),
(3, 1, 'Tripora Kyoto Atelier Stay', 'A fictional demo stay with calm interiors, thoughtful shared spaces and a welcoming atmosphere. Replace this listing with your own verified property information.', 'Kyoto — demonstration listing; no real street address', 5, 'Wi-Fi, breakfast area, lounge, air conditioning, reception', 'public/images/hotel.jpg', 0, 1),
(4, 2, 'Tripora Tokyo Garden House', 'A fictional demo stay with calm interiors, thoughtful shared spaces and a welcoming atmosphere. Replace this listing with your own verified property information.', 'Tokyo — demonstration listing; no real street address', 3, 'Wi-Fi, breakfast area, lounge, air conditioning, reception', 'public/images/hotel.jpg', 0, 1),
(5, 2, 'Tripora Tokyo Courtyard Lodge', 'A fictional demo stay with calm interiors, thoughtful shared spaces and a welcoming atmosphere. Replace this listing with your own verified property information.', 'Tokyo — demonstration listing; no real street address', 4, 'Wi-Fi, breakfast area, lounge, air conditioning, reception', 'public/images/pool.jpg', 0, 1),
(6, 2, 'Tripora Tokyo Atelier Stay', 'A fictional demo stay with calm interiors, thoughtful shared spaces and a welcoming atmosphere. Replace this listing with your own verified property information.', 'Tokyo — demonstration listing; no real street address', 5, 'Wi-Fi, breakfast area, lounge, air conditioning, reception', 'public/images/hotel.jpg', 0, 1),
(7, 3, 'Tripora Osaka Garden House', 'A fictional demo stay with calm interiors, thoughtful shared spaces and a welcoming atmosphere. Replace this listing with your own verified property information.', 'Osaka — demonstration listing; no real street address', 3, 'Wi-Fi, breakfast area, lounge, air conditioning, reception', 'public/images/hotel.jpg', 0, 1),
(8, 3, 'Tripora Osaka Courtyard Lodge', 'A fictional demo stay with calm interiors, thoughtful shared spaces and a welcoming atmosphere. Replace this listing with your own verified property information.', 'Osaka — demonstration listing; no real street address', 4, 'Wi-Fi, breakfast area, lounge, air conditioning, reception', 'public/images/pool.jpg', 0, 1),
(9, 3, 'Tripora Osaka Atelier Stay', 'A fictional demo stay with calm interiors, thoughtful shared spaces and a welcoming atmosphere. Replace this listing with your own verified property information.', 'Osaka — demonstration listing; no real street address', 5, 'Wi-Fi, breakfast area, lounge, air conditioning, reception', 'public/images/hotel.jpg', 0, 1),
(10, 4, 'Tripora Nara Garden House', 'A fictional demo stay with calm interiors, thoughtful shared spaces and a welcoming atmosphere. Replace this listing with your own verified property information.', 'Nara — demonstration listing; no real street address', 3, 'Wi-Fi, breakfast area, lounge, air conditioning, reception', 'public/images/hotel.jpg', 0, 1),
(11, 4, 'Tripora Nara Courtyard Lodge', 'A fictional demo stay with calm interiors, thoughtful shared spaces and a welcoming atmosphere. Replace this listing with your own verified property information.', 'Nara — demonstration listing; no real street address', 4, 'Wi-Fi, breakfast area, lounge, air conditioning, reception', 'public/images/pool.jpg', 0, 1),
(12, 4, 'Tripora Nara Atelier Stay', 'A fictional demo stay with calm interiors, thoughtful shared spaces and a welcoming atmosphere. Replace this listing with your own verified property information.', 'Nara — demonstration listing; no real street address', 5, 'Wi-Fi, breakfast area, lounge, air conditioning, reception', 'public/images/hotel.jpg', 0, 1),
(13, 5, 'Tripora Hakone Garden House', 'A fictional demo stay with calm interiors, thoughtful shared spaces and a welcoming atmosphere. Replace this listing with your own verified property information.', 'Hakone — demonstration listing; no real street address', 3, 'Wi-Fi, breakfast area, lounge, air conditioning, reception', 'public/images/hotel.jpg', 0, 1),
(14, 5, 'Tripora Hakone Courtyard Lodge', 'A fictional demo stay with calm interiors, thoughtful shared spaces and a welcoming atmosphere. Replace this listing with your own verified property information.', 'Hakone — demonstration listing; no real street address', 4, 'Wi-Fi, breakfast area, lounge, air conditioning, reception', 'public/images/pool.jpg', 0, 1),
(15, 5, 'Tripora Hakone Atelier Stay', 'A fictional demo stay with calm interiors, thoughtful shared spaces and a welcoming atmosphere. Replace this listing with your own verified property information.', 'Hakone — demonstration listing; no real street address', 5, 'Wi-Fi, breakfast area, lounge, air conditioning, reception', 'public/images/hotel.jpg', 0, 1),
(16, 6, 'Tripora Bangkok Garden House', 'A fictional demo stay with calm interiors, thoughtful shared spaces and a welcoming atmosphere. Replace this listing with your own verified property information.', 'Bangkok — demonstration listing; no real street address', 3, 'Wi-Fi, breakfast area, lounge, air conditioning, reception', 'public/images/hotel.jpg', 0, 1),
(17, 6, 'Tripora Bangkok Courtyard Lodge', 'A fictional demo stay with calm interiors, thoughtful shared spaces and a welcoming atmosphere. Replace this listing with your own verified property information.', 'Bangkok — demonstration listing; no real street address', 4, 'Wi-Fi, breakfast area, lounge, air conditioning, reception', 'public/images/pool.jpg', 0, 1),
(18, 6, 'Tripora Bangkok Atelier Stay', 'A fictional demo stay with calm interiors, thoughtful shared spaces and a welcoming atmosphere. Replace this listing with your own verified property information.', 'Bangkok — demonstration listing; no real street address', 5, 'Wi-Fi, breakfast area, lounge, air conditioning, reception', 'public/images/hotel.jpg', 0, 1),
(19, 7, 'Tripora Chiang Mai Garden House', 'A fictional demo stay with calm interiors, thoughtful shared spaces and a welcoming atmosphere. Replace this listing with your own verified property information.', 'Chiang Mai — demonstration listing; no real street address', 3, 'Wi-Fi, breakfast area, lounge, air conditioning, reception', 'public/images/hotel.jpg', 0, 1),
(20, 7, 'Tripora Chiang Mai Courtyard Lodge', 'A fictional demo stay with calm interiors, thoughtful shared spaces and a welcoming atmosphere. Replace this listing with your own verified property information.', 'Chiang Mai — demonstration listing; no real street address', 4, 'Wi-Fi, breakfast area, lounge, air conditioning, reception', 'public/images/pool.jpg', 0, 1),
(21, 7, 'Tripora Chiang Mai Atelier Stay', 'A fictional demo stay with calm interiors, thoughtful shared spaces and a welcoming atmosphere. Replace this listing with your own verified property information.', 'Chiang Mai — demonstration listing; no real street address', 5, 'Wi-Fi, breakfast area, lounge, air conditioning, reception', 'public/images/hotel.jpg', 0, 1),
(22, 8, 'Tripora Phuket Garden House', 'A fictional demo stay with calm interiors, thoughtful shared spaces and a welcoming atmosphere. Replace this listing with your own verified property information.', 'Phuket — demonstration listing; no real street address', 3, 'Wi-Fi, breakfast area, lounge, air conditioning, reception', 'public/images/hotel.jpg', 0, 1),
(23, 8, 'Tripora Phuket Courtyard Lodge', 'A fictional demo stay with calm interiors, thoughtful shared spaces and a welcoming atmosphere. Replace this listing with your own verified property information.', 'Phuket — demonstration listing; no real street address', 4, 'Wi-Fi, breakfast area, lounge, air conditioning, reception', 'public/images/pool.jpg', 0, 1),
(24, 8, 'Tripora Phuket Atelier Stay', 'A fictional demo stay with calm interiors, thoughtful shared spaces and a welcoming atmosphere. Replace this listing with your own verified property information.', 'Phuket — demonstration listing; no real street address', 5, 'Wi-Fi, breakfast area, lounge, air conditioning, reception', 'public/images/hotel.jpg', 0, 1),
(25, 9, 'Tripora Krabi Garden House', 'A fictional demo stay with calm interiors, thoughtful shared spaces and a welcoming atmosphere. Replace this listing with your own verified property information.', 'Krabi — demonstration listing; no real street address', 3, 'Wi-Fi, breakfast area, lounge, air conditioning, reception', 'public/images/hotel.jpg', 0, 1),
(26, 9, 'Tripora Krabi Courtyard Lodge', 'A fictional demo stay with calm interiors, thoughtful shared spaces and a welcoming atmosphere. Replace this listing with your own verified property information.', 'Krabi — demonstration listing; no real street address', 4, 'Wi-Fi, breakfast area, lounge, air conditioning, reception', 'public/images/pool.jpg', 0, 1),
(27, 9, 'Tripora Krabi Atelier Stay', 'A fictional demo stay with calm interiors, thoughtful shared spaces and a welcoming atmosphere. Replace this listing with your own verified property information.', 'Krabi — demonstration listing; no real street address', 5, 'Wi-Fi, breakfast area, lounge, air conditioning, reception', 'public/images/hotel.jpg', 0, 1),
(28, 10, 'Tripora Koh Samui Garden House', 'A fictional demo stay with calm interiors, thoughtful shared spaces and a welcoming atmosphere. Replace this listing with your own verified property information.', 'Koh Samui — demonstration listing; no real street address', 3, 'Wi-Fi, breakfast area, lounge, air conditioning, reception', 'public/images/hotel.jpg', 0, 1),
(29, 10, 'Tripora Koh Samui Courtyard Lodge', 'A fictional demo stay with calm interiors, thoughtful shared spaces and a welcoming atmosphere. Replace this listing with your own verified property information.', 'Koh Samui — demonstration listing; no real street address', 4, 'Wi-Fi, breakfast area, lounge, air conditioning, reception', 'public/images/pool.jpg', 0, 1),
(30, 10, 'Tripora Koh Samui Atelier Stay', 'A fictional demo stay with calm interiors, thoughtful shared spaces and a welcoming atmosphere. Replace this listing with your own verified property information.', 'Koh Samui — demonstration listing; no real street address', 5, 'Wi-Fi, breakfast area, lounge, air conditioning, reception', 'public/images/hotel.jpg', 0, 1),
(31, 11, 'Sage Garden House', 'A fictional demo stay with calm interiors, thoughtful shared spaces and a welcoming atmosphere. Replace this listing with your own verified property information.', 'Ubud — demonstration listing; no real street address', 3, 'Wi-Fi, breakfast area, lounge, air conditioning, reception', 'public/images/bali.jpg', 1, 1),
(32, 11, 'Tripora Ubud Courtyard Lodge', 'A fictional demo stay with calm interiors, thoughtful shared spaces and a welcoming atmosphere. Replace this listing with your own verified property information.', 'Ubud — demonstration listing; no real street address', 4, 'Wi-Fi, breakfast area, lounge, air conditioning, reception', 'public/images/pool.jpg', 0, 1),
(33, 11, 'Tripora Ubud Atelier Stay', 'A fictional demo stay with calm interiors, thoughtful shared spaces and a welcoming atmosphere. Replace this listing with your own verified property information.', 'Ubud — demonstration listing; no real street address', 5, 'Wi-Fi, breakfast area, lounge, air conditioning, reception', 'public/images/hotel.jpg', 0, 1),
(34, 12, 'Tripora Canggu Garden House', 'A fictional demo stay with calm interiors, thoughtful shared spaces and a welcoming atmosphere. Replace this listing with your own verified property information.', 'Canggu — demonstration listing; no real street address', 3, 'Wi-Fi, breakfast area, lounge, air conditioning, reception', 'public/images/hotel.jpg', 0, 1),
(35, 12, 'Tripora Canggu Courtyard Lodge', 'A fictional demo stay with calm interiors, thoughtful shared spaces and a welcoming atmosphere. Replace this listing with your own verified property information.', 'Canggu — demonstration listing; no real street address', 4, 'Wi-Fi, breakfast area, lounge, air conditioning, reception', 'public/images/pool.jpg', 0, 1),
(36, 12, 'Tripora Canggu Atelier Stay', 'A fictional demo stay with calm interiors, thoughtful shared spaces and a welcoming atmosphere. Replace this listing with your own verified property information.', 'Canggu — demonstration listing; no real street address', 5, 'Wi-Fi, breakfast area, lounge, air conditioning, reception', 'public/images/hotel.jpg', 0, 1),
(37, 13, 'Tripora Seminyak Garden House', 'A fictional demo stay with calm interiors, thoughtful shared spaces and a welcoming atmosphere. Replace this listing with your own verified property information.', 'Seminyak — demonstration listing; no real street address', 3, 'Wi-Fi, breakfast area, lounge, air conditioning, reception', 'public/images/hotel.jpg', 0, 1),
(38, 13, 'Tripora Seminyak Courtyard Lodge', 'A fictional demo stay with calm interiors, thoughtful shared spaces and a welcoming atmosphere. Replace this listing with your own verified property information.', 'Seminyak — demonstration listing; no real street address', 4, 'Wi-Fi, breakfast area, lounge, air conditioning, reception', 'public/images/pool.jpg', 0, 1),
(39, 13, 'Tripora Seminyak Atelier Stay', 'A fictional demo stay with calm interiors, thoughtful shared spaces and a welcoming atmosphere. Replace this listing with your own verified property information.', 'Seminyak — demonstration listing; no real street address', 5, 'Wi-Fi, breakfast area, lounge, air conditioning, reception', 'public/images/hotel.jpg', 0, 1),
(40, 14, 'Tripora Yogyakarta Garden House', 'A fictional demo stay with calm interiors, thoughtful shared spaces and a welcoming atmosphere. Replace this listing with your own verified property information.', 'Yogyakarta — demonstration listing; no real street address', 3, 'Wi-Fi, breakfast area, lounge, air conditioning, reception', 'public/images/hotel.jpg', 0, 1),
(41, 14, 'Tripora Yogyakarta Courtyard Lodge', 'A fictional demo stay with calm interiors, thoughtful shared spaces and a welcoming atmosphere. Replace this listing with your own verified property information.', 'Yogyakarta — demonstration listing; no real street address', 4, 'Wi-Fi, breakfast area, lounge, air conditioning, reception', 'public/images/pool.jpg', 0, 1),
(42, 14, 'Tripora Yogyakarta Atelier Stay', 'A fictional demo stay with calm interiors, thoughtful shared spaces and a welcoming atmosphere. Replace this listing with your own verified property information.', 'Yogyakarta — demonstration listing; no real street address', 5, 'Wi-Fi, breakfast area, lounge, air conditioning, reception', 'public/images/hotel.jpg', 0, 1),
(43, 15, 'Tripora Lombok Garden House', 'A fictional demo stay with calm interiors, thoughtful shared spaces and a welcoming atmosphere. Replace this listing with your own verified property information.', 'Lombok — demonstration listing; no real street address', 3, 'Wi-Fi, breakfast area, lounge, air conditioning, reception', 'public/images/hotel.jpg', 0, 1),
(44, 15, 'Tripora Lombok Courtyard Lodge', 'A fictional demo stay with calm interiors, thoughtful shared spaces and a welcoming atmosphere. Replace this listing with your own verified property information.', 'Lombok — demonstration listing; no real street address', 4, 'Wi-Fi, breakfast area, lounge, air conditioning, reception', 'public/images/pool.jpg', 0, 1),
(45, 15, 'Tripora Lombok Atelier Stay', 'A fictional demo stay with calm interiors, thoughtful shared spaces and a welcoming atmosphere. Replace this listing with your own verified property information.', 'Lombok — demonstration listing; no real street address', 5, 'Wi-Fi, breakfast area, lounge, air conditioning, reception', 'public/images/hotel.jpg', 0, 1),
(46, 16, 'Amber Courtyard', 'A fictional demo stay with calm interiors, thoughtful shared spaces and a welcoming atmosphere. Replace this listing with your own verified property information.', 'Marrakech — demonstration listing; no real street address', 3, 'Wi-Fi, breakfast area, lounge, air conditioning, reception', 'public/images/morocco.jpg', 1, 1),
(47, 16, 'Tripora Marrakech Courtyard Lodge', 'A fictional demo stay with calm interiors, thoughtful shared spaces and a welcoming atmosphere. Replace this listing with your own verified property information.', 'Marrakech — demonstration listing; no real street address', 4, 'Wi-Fi, breakfast area, lounge, air conditioning, reception', 'public/images/pool.jpg', 0, 1),
(48, 16, 'Tripora Marrakech Atelier Stay', 'A fictional demo stay with calm interiors, thoughtful shared spaces and a welcoming atmosphere. Replace this listing with your own verified property information.', 'Marrakech — demonstration listing; no real street address', 5, 'Wi-Fi, breakfast area, lounge, air conditioning, reception', 'public/images/hotel.jpg', 0, 1),
(49, 17, 'Tripora Fes Garden House', 'A fictional demo stay with calm interiors, thoughtful shared spaces and a welcoming atmosphere. Replace this listing with your own verified property information.', 'Fes — demonstration listing; no real street address', 3, 'Wi-Fi, breakfast area, lounge, air conditioning, reception', 'public/images/hotel.jpg', 0, 1),
(50, 17, 'Tripora Fes Courtyard Lodge', 'A fictional demo stay with calm interiors, thoughtful shared spaces and a welcoming atmosphere. Replace this listing with your own verified property information.', 'Fes — demonstration listing; no real street address', 4, 'Wi-Fi, breakfast area, lounge, air conditioning, reception', 'public/images/pool.jpg', 0, 1),
(51, 17, 'Tripora Fes Atelier Stay', 'A fictional demo stay with calm interiors, thoughtful shared spaces and a welcoming atmosphere. Replace this listing with your own verified property information.', 'Fes — demonstration listing; no real street address', 5, 'Wi-Fi, breakfast area, lounge, air conditioning, reception', 'public/images/hotel.jpg', 0, 1),
(52, 18, 'Tripora Chefchaouen Garden House', 'A fictional demo stay with calm interiors, thoughtful shared spaces and a welcoming atmosphere. Replace this listing with your own verified property information.', 'Chefchaouen — demonstration listing; no real street address', 3, 'Wi-Fi, breakfast area, lounge, air conditioning, reception', 'public/images/hotel.jpg', 0, 1),
(53, 18, 'Tripora Chefchaouen Courtyard Lodge', 'A fictional demo stay with calm interiors, thoughtful shared spaces and a welcoming atmosphere. Replace this listing with your own verified property information.', 'Chefchaouen — demonstration listing; no real street address', 4, 'Wi-Fi, breakfast area, lounge, air conditioning, reception', 'public/images/pool.jpg', 0, 1),
(54, 18, 'Tripora Chefchaouen Atelier Stay', 'A fictional demo stay with calm interiors, thoughtful shared spaces and a welcoming atmosphere. Replace this listing with your own verified property information.', 'Chefchaouen — demonstration listing; no real street address', 5, 'Wi-Fi, breakfast area, lounge, air conditioning, reception', 'public/images/hotel.jpg', 0, 1),
(55, 19, 'Tripora Essaouira Garden House', 'A fictional demo stay with calm interiors, thoughtful shared spaces and a welcoming atmosphere. Replace this listing with your own verified property information.', 'Essaouira — demonstration listing; no real street address', 3, 'Wi-Fi, breakfast area, lounge, air conditioning, reception', 'public/images/hotel.jpg', 0, 1),
(56, 19, 'Tripora Essaouira Courtyard Lodge', 'A fictional demo stay with calm interiors, thoughtful shared spaces and a welcoming atmosphere. Replace this listing with your own verified property information.', 'Essaouira — demonstration listing; no real street address', 4, 'Wi-Fi, breakfast area, lounge, air conditioning, reception', 'public/images/pool.jpg', 0, 1),
(57, 19, 'Tripora Essaouira Atelier Stay', 'A fictional demo stay with calm interiors, thoughtful shared spaces and a welcoming atmosphere. Replace this listing with your own verified property information.', 'Essaouira — demonstration listing; no real street address', 5, 'Wi-Fi, breakfast area, lounge, air conditioning, reception', 'public/images/hotel.jpg', 0, 1),
(58, 20, 'Tripora Rabat Garden House', 'A fictional demo stay with calm interiors, thoughtful shared spaces and a welcoming atmosphere. Replace this listing with your own verified property information.', 'Rabat — demonstration listing; no real street address', 3, 'Wi-Fi, breakfast area, lounge, air conditioning, reception', 'public/images/hotel.jpg', 0, 1),
(59, 20, 'Tripora Rabat Courtyard Lodge', 'A fictional demo stay with calm interiors, thoughtful shared spaces and a welcoming atmosphere. Replace this listing with your own verified property information.', 'Rabat — demonstration listing; no real street address', 4, 'Wi-Fi, breakfast area, lounge, air conditioning, reception', 'public/images/pool.jpg', 0, 1),
(60, 20, 'Tripora Rabat Atelier Stay', 'A fictional demo stay with calm interiors, thoughtful shared spaces and a welcoming atmosphere. Replace this listing with your own verified property information.', 'Rabat — demonstration listing; no real street address', 5, 'Wi-Fi, breakfast area, lounge, air conditioning, reception', 'public/images/hotel.jpg', 0, 1),
(61, 21, 'Pine & Peak', 'A fictional demo stay with calm interiors, thoughtful shared spaces and a welcoming atmosphere. Replace this listing with your own verified property information.', 'Zermatt — demonstration listing; no real street address', 3, 'Wi-Fi, breakfast area, lounge, air conditioning, reception', 'public/images/switzerland.jpg', 1, 1),
(62, 21, 'Tripora Zermatt Courtyard Lodge', 'A fictional demo stay with calm interiors, thoughtful shared spaces and a welcoming atmosphere. Replace this listing with your own verified property information.', 'Zermatt — demonstration listing; no real street address', 4, 'Wi-Fi, breakfast area, lounge, air conditioning, reception', 'public/images/pool.jpg', 0, 1),
(63, 21, 'Tripora Zermatt Atelier Stay', 'A fictional demo stay with calm interiors, thoughtful shared spaces and a welcoming atmosphere. Replace this listing with your own verified property information.', 'Zermatt — demonstration listing; no real street address', 5, 'Wi-Fi, breakfast area, lounge, air conditioning, reception', 'public/images/hotel.jpg', 0, 1),
(64, 22, 'Tripora Lucerne Garden House', 'A fictional demo stay with calm interiors, thoughtful shared spaces and a welcoming atmosphere. Replace this listing with your own verified property information.', 'Lucerne — demonstration listing; no real street address', 3, 'Wi-Fi, breakfast area, lounge, air conditioning, reception', 'public/images/hotel.jpg', 0, 1),
(65, 22, 'Tripora Lucerne Courtyard Lodge', 'A fictional demo stay with calm interiors, thoughtful shared spaces and a welcoming atmosphere. Replace this listing with your own verified property information.', 'Lucerne — demonstration listing; no real street address', 4, 'Wi-Fi, breakfast area, lounge, air conditioning, reception', 'public/images/pool.jpg', 0, 1),
(66, 22, 'Tripora Lucerne Atelier Stay', 'A fictional demo stay with calm interiors, thoughtful shared spaces and a welcoming atmosphere. Replace this listing with your own verified property information.', 'Lucerne — demonstration listing; no real street address', 5, 'Wi-Fi, breakfast area, lounge, air conditioning, reception', 'public/images/hotel.jpg', 0, 1),
(67, 23, 'Tripora Interlaken Garden House', 'A fictional demo stay with calm interiors, thoughtful shared spaces and a welcoming atmosphere. Replace this listing with your own verified property information.', 'Interlaken — demonstration listing; no real street address', 3, 'Wi-Fi, breakfast area, lounge, air conditioning, reception', 'public/images/hotel.jpg', 0, 1),
(68, 23, 'Tripora Interlaken Courtyard Lodge', 'A fictional demo stay with calm interiors, thoughtful shared spaces and a welcoming atmosphere. Replace this listing with your own verified property information.', 'Interlaken — demonstration listing; no real street address', 4, 'Wi-Fi, breakfast area, lounge, air conditioning, reception', 'public/images/pool.jpg', 0, 1),
(69, 23, 'Tripora Interlaken Atelier Stay', 'A fictional demo stay with calm interiors, thoughtful shared spaces and a welcoming atmosphere. Replace this listing with your own verified property information.', 'Interlaken — demonstration listing; no real street address', 5, 'Wi-Fi, breakfast area, lounge, air conditioning, reception', 'public/images/hotel.jpg', 0, 1),
(70, 24, 'Tripora Zurich Garden House', 'A fictional demo stay with calm interiors, thoughtful shared spaces and a welcoming atmosphere. Replace this listing with your own verified property information.', 'Zurich — demonstration listing; no real street address', 3, 'Wi-Fi, breakfast area, lounge, air conditioning, reception', 'public/images/hotel.jpg', 0, 1),
(71, 24, 'Tripora Zurich Courtyard Lodge', 'A fictional demo stay with calm interiors, thoughtful shared spaces and a welcoming atmosphere. Replace this listing with your own verified property information.', 'Zurich — demonstration listing; no real street address', 4, 'Wi-Fi, breakfast area, lounge, air conditioning, reception', 'public/images/pool.jpg', 0, 1),
(72, 24, 'Tripora Zurich Atelier Stay', 'A fictional demo stay with calm interiors, thoughtful shared spaces and a welcoming atmosphere. Replace this listing with your own verified property information.', 'Zurich — demonstration listing; no real street address', 5, 'Wi-Fi, breakfast area, lounge, air conditioning, reception', 'public/images/hotel.jpg', 0, 1),
(73, 25, 'Tripora Lugano Garden House', 'A fictional demo stay with calm interiors, thoughtful shared spaces and a welcoming atmosphere. Replace this listing with your own verified property information.', 'Lugano — demonstration listing; no real street address', 3, 'Wi-Fi, breakfast area, lounge, air conditioning, reception', 'public/images/hotel.jpg', 0, 1),
(74, 25, 'Tripora Lugano Courtyard Lodge', 'A fictional demo stay with calm interiors, thoughtful shared spaces and a welcoming atmosphere. Replace this listing with your own verified property information.', 'Lugano — demonstration listing; no real street address', 4, 'Wi-Fi, breakfast area, lounge, air conditioning, reception', 'public/images/pool.jpg', 0, 1),
(75, 25, 'Tripora Lugano Atelier Stay', 'A fictional demo stay with calm interiors, thoughtful shared spaces and a welcoming atmosphere. Replace this listing with your own verified property information.', 'Lugano — demonstration listing; no real street address', 5, 'Wi-Fi, breakfast area, lounge, air conditioning, reception', 'public/images/hotel.jpg', 0, 1),
(76, 26, 'Tripora Yangon Garden House', 'A fictional Myanmar demo stay with welcoming shared spaces and comfortable rooms. Replace this listing with verified property information.', 'Yangon — demonstration listing; no real street address', 3, 'Wi-Fi, breakfast area, lounge, air conditioning, reception', 'public/images/hotel.jpg', 0, 1),
(77, 26, 'Tripora Yangon Courtyard Lodge', 'A fictional Myanmar demo stay with welcoming shared spaces and comfortable rooms. Replace this listing with verified property information.', 'Yangon — demonstration listing; no real street address', 4, 'Wi-Fi, breakfast area, lounge, air conditioning, reception', 'public/images/pool.jpg', 0, 1),
(78, 26, 'Tripora Yangon Atelier Stay', 'A fictional Myanmar demo stay with welcoming shared spaces and comfortable rooms. Replace this listing with verified property information.', 'Yangon — demonstration listing; no real street address', 5, 'Wi-Fi, breakfast area, lounge, air conditioning, reception', 'public/images/hotel.jpg', 0, 1),
(79, 27, 'Tripora Mandalay Garden House', 'A fictional Myanmar demo stay with welcoming shared spaces and comfortable rooms. Replace this listing with verified property information.', 'Mandalay — demonstration listing; no real street address', 3, 'Wi-Fi, breakfast area, lounge, air conditioning, reception', 'public/images/hotel.jpg', 0, 1),
(80, 27, 'Tripora Mandalay Courtyard Lodge', 'A fictional Myanmar demo stay with welcoming shared spaces and comfortable rooms. Replace this listing with verified property information.', 'Mandalay — demonstration listing; no real street address', 4, 'Wi-Fi, breakfast area, lounge, air conditioning, reception', 'public/images/pool.jpg', 0, 1),
(81, 27, 'Tripora Mandalay Atelier Stay', 'A fictional Myanmar demo stay with welcoming shared spaces and comfortable rooms. Replace this listing with verified property information.', 'Mandalay — demonstration listing; no real street address', 5, 'Wi-Fi, breakfast area, lounge, air conditioning, reception', 'public/images/hotel.jpg', 0, 1),
(82, 28, 'Tripora Bagan Garden House', 'A fictional Myanmar demo stay with welcoming shared spaces and comfortable rooms. Replace this listing with verified property information.', 'Bagan — demonstration listing; no real street address', 3, 'Wi-Fi, breakfast area, lounge, air conditioning, reception', 'public/images/hotel.jpg', 0, 1),
(83, 28, 'Tripora Bagan Courtyard Lodge', 'A fictional Myanmar demo stay with welcoming shared spaces and comfortable rooms. Replace this listing with verified property information.', 'Bagan — demonstration listing; no real street address', 4, 'Wi-Fi, breakfast area, lounge, air conditioning, reception', 'public/images/pool.jpg', 0, 1),
(84, 28, 'Tripora Bagan Atelier Stay', 'A fictional Myanmar demo stay with welcoming shared spaces and comfortable rooms. Replace this listing with verified property information.', 'Bagan — demonstration listing; no real street address', 5, 'Wi-Fi, breakfast area, lounge, air conditioning, reception', 'public/images/hotel.jpg', 0, 1),
(85, 29, 'Tripora Inle Lake Garden House', 'A fictional Myanmar demo stay with welcoming shared spaces and comfortable rooms. Replace this listing with verified property information.', 'Inle Lake — demonstration listing; no real street address', 3, 'Wi-Fi, breakfast area, lounge, air conditioning, reception', 'public/images/hotel.jpg', 0, 1),
(86, 29, 'Tripora Inle Lake Courtyard Lodge', 'A fictional Myanmar demo stay with welcoming shared spaces and comfortable rooms. Replace this listing with verified property information.', 'Inle Lake — demonstration listing; no real street address', 4, 'Wi-Fi, breakfast area, lounge, air conditioning, reception', 'public/images/pool.jpg', 0, 1),
(87, 29, 'Tripora Inle Lake Atelier Stay', 'A fictional Myanmar demo stay with welcoming shared spaces and comfortable rooms. Replace this listing with verified property information.', 'Inle Lake — demonstration listing; no real street address', 5, 'Wi-Fi, breakfast area, lounge, air conditioning, reception', 'public/images/hotel.jpg', 0, 1),
(88, 30, 'Tripora Ngapali Garden House', 'A fictional Myanmar demo stay with welcoming shared spaces and comfortable rooms. Replace this listing with verified property information.', 'Ngapali — demonstration listing; no real street address', 3, 'Wi-Fi, breakfast area, lounge, air conditioning, reception', 'public/images/hotel.jpg', 0, 1),
(89, 30, 'Tripora Ngapali Courtyard Lodge', 'A fictional Myanmar demo stay with welcoming shared spaces and comfortable rooms. Replace this listing with verified property information.', 'Ngapali — demonstration listing; no real street address', 4, 'Wi-Fi, breakfast area, lounge, air conditioning, reception', 'public/images/pool.jpg', 0, 1),
(90, 30, 'Tripora Ngapali Atelier Stay', 'A fictional Myanmar demo stay with welcoming shared spaces and comfortable rooms. Replace this listing with verified property information.', 'Ngapali — demonstration listing; no real street address', 5, 'Wi-Fi, breakfast area, lounge, air conditioning, reception', 'public/images/hotel.jpg', 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `login_attempts`
--

CREATE TABLE `login_attempts` (
  `attempt_key` char(64) NOT NULL,
  `attempts` int(10) UNSIGNED NOT NULL,
  `window_start` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `login_attempts`
--

INSERT INTO `login_attempts` (`attempt_key`, `attempts`, `window_start`) VALUES
('026dab6e8200ff598ade053df079bc80ba4b380eb590ab24a8c8b78f4ffaea1a', 1, 1791699671),
('18cc30eaeaff7c38edadd3af168b4b8fb26d9db4d018ff483fa0f0e2f6bfe735', 1, 1791691473),
('307b4f83ab1086ce82128822132e8fc883a570798cc41c0566deffd570f902b2', 2, 1791543478),
('417c0370197a76cdb77fba27a9e02bef67b4c8e32139803fdb4aa185fe0f3e21', 1, 1791636670),
('444701fc10921939e520f1489344ce9d2bd844854486c210438b83f3437256bd', 1, 1791565985),
('8a88d7966487db6fa4e798865dd9c5375a6a0f32b97862cf3d1a7bdd0d036d38', 1, 1791565815),
('8e28c6fc927159ea7f9c3af9aab2c54b9088c92c86ab00388e7dca9b7a34b423', 1, 1791552003),
('b6bbbb7fd7b77bb4b173bb660f8838bcc89448d08c2768938f11f8e66a02b825', 1, 1791699761),
('bab4f99f5809c9b14dfa353f92e7f75790bf018cddfceb39a1b1778d64e10d48', 1, 1791565952),
('bc72b9d40d196ab801988b0ff199144920156c714a4a6ccc5cacad4e056d3ada', 2, 1791691783),
('c5cb5fd0c6c86670975f2f3120dc9075ec11d7aeef777c7fe8a342502423343d', 4, 1791528414),
('d146537a6f9a91574460f09ae133e3ba7ae7c65af4834ff2a9c9421d5bce69a5', 1, 1791699645),
('ddfa8ed3758780dc32bc7d284168c435ed6b9b9b432d1e48c3aa32cd247c8ae5', 1, 1791565861),
('ef71bbf7db724702153f0b002ecff130270da90987b386d8d44002bf2bcf5124', 1, 1791699697);

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` int(10) UNSIGNED NOT NULL,
  `booking_id` int(10) UNSIGNED NOT NULL,
  `method` enum('bank','kpay','wave') NOT NULL,
  `transaction_ref` varchar(120) NOT NULL,
  `amount` decimal(12,2) NOT NULL,
  `proof_path` varchar(100) NOT NULL,
  `status` enum('submitted','verified','rejected','refund_due','refunded','cancelled') NOT NULL DEFAULT 'submitted',
  `admin_note` varchar(500) NOT NULL DEFAULT '',
  `reviewed_by` int(10) UNSIGNED DEFAULT NULL,
  `reviewed_at` datetime DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`id`, `booking_id`, `method`, `transaction_ref`, `amount`, `proof_path`, `status`, `admin_note`, `reviewed_by`, `reviewed_at`, `created_at`) VALUES
(1, 1, 'kpay', '01004296021977431632', 81.00, 'a18323c091ffce9283f15a39e6b7c2df.jpg', 'refunded', 'refund', 3, '2026-10-09 11:09:33', '2026-10-09 10:52:25'),
(2, 2, 'kpay', '01004296021977431378', 158.00, '161b2587ddeec936d296f02e2237cacd.jpg', 'verified', 'Review', 3, '2026-10-09 11:08:07', '2026-10-09 11:06:12'),
(3, 3, 'kpay', '01004296021977431379', 129.00, '0392330c4444654a2d0ec005b23cdd22.jpg', 'verified', '', 3, '2026-10-09 12:53:28', '2026-10-09 12:51:45');

-- --------------------------------------------------------

--
-- Table structure for table `promotions`
--

CREATE TABLE `promotions` (
  `id` int(10) UNSIGNED NOT NULL,
  `code` varchar(30) NOT NULL,
  `title` varchar(190) NOT NULL,
  `description` text NOT NULL,
  `percent_off` decimal(5,2) NOT NULL,
  `usage_limit` int(10) UNSIGNED NOT NULL,
  `starts_on` date NOT NULL,
  `ends_on` date NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 1
) ;

--
-- Dumping data for table `promotions`
--

INSERT INTO `promotions` (`id`, `code`, `title`, `description`, `percent_off`, `usage_limit`, `starts_on`, `ends_on`, `active`) VALUES
(1, 'FIRSTCHAPTER', 'Your first little adventure', 'A fictional welcome offer for the demo booking flow.', 10.00, 1000, '2026-10-09', '2027-10-20', 1);

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `id` int(10) UNSIGNED NOT NULL,
  `booking_id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `hotel_id` int(10) UNSIGNED NOT NULL,
  `rating` tinyint(3) UNSIGNED NOT NULL,
  `body` text NOT NULL,
  `visible` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ;

-- --------------------------------------------------------

--
-- Table structure for table `rooms`
--

CREATE TABLE `rooms` (
  `id` int(10) UNSIGNED NOT NULL,
  `hotel_id` int(10) UNSIGNED NOT NULL,
  `name` varchar(190) NOT NULL,
  `description` text NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `capacity` smallint(5) UNSIGNED NOT NULL,
  `inventory` smallint(5) UNSIGNED NOT NULL,
  `image` varchar(255) NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 1
) ;

--
-- Dumping data for table `rooms`
--

INSERT INTO `rooms` (`id`, `hotel_id`, `name`, `description`, `price`, `capacity`, `inventory`, `image`, `active`) VALUES
(1, 1, 'Comfort King', 'A comfortable demo room with a private bathroom and a place to settle in.', 81.00, 2, 3, 'public/images/room.jpg', 1),
(2, 1, 'Family Suite', 'A comfortable demo room with a private bathroom and a place to settle in.', 126.00, 4, 2, 'public/images/suite.jpg', 1),
(3, 2, 'Comfort King', 'A comfortable demo room with a private bathroom and a place to settle in.', 99.00, 2, 3, 'public/images/room.jpg', 1),
(4, 2, 'Family Suite', 'A comfortable demo room with a private bathroom and a place to settle in.', 144.00, 4, 2, 'public/images/suite.jpg', 1),
(5, 3, 'Comfort King', 'A comfortable demo room with a private bathroom and a place to settle in.', 117.00, 2, 3, 'public/images/room.jpg', 1),
(6, 3, 'Family Suite', 'A comfortable demo room with a private bathroom and a place to settle in.', 162.00, 4, 2, 'public/images/suite.jpg', 1),
(7, 4, 'Comfort King', 'A comfortable demo room with a private bathroom and a place to settle in.', 81.00, 2, 3, 'public/images/room.jpg', 1),
(8, 4, 'Family Suite', 'A comfortable demo room with a private bathroom and a place to settle in.', 126.00, 4, 2, 'public/images/suite.jpg', 1),
(9, 5, 'Comfort King', 'A comfortable demo room with a private bathroom and a place to settle in.', 99.00, 2, 3, 'public/images/room.jpg', 1),
(10, 5, 'Family Suite', 'A comfortable demo room with a private bathroom and a place to settle in.', 144.00, 4, 2, 'public/images/suite.jpg', 1),
(11, 6, 'Comfort King', 'A comfortable demo room with a private bathroom and a place to settle in.', 117.00, 2, 3, 'public/images/room.jpg', 1),
(12, 6, 'Family Suite', 'A comfortable demo room with a private bathroom and a place to settle in.', 162.00, 4, 2, 'public/images/suite.jpg', 1),
(13, 7, 'Comfort King', 'A comfortable demo room with a private bathroom and a place to settle in.', 81.00, 2, 3, 'public/images/room.jpg', 1),
(14, 7, 'Family Suite', 'A comfortable demo room with a private bathroom and a place to settle in.', 126.00, 4, 2, 'public/images/suite.jpg', 1),
(15, 8, 'Comfort King', 'A comfortable demo room with a private bathroom and a place to settle in.', 99.00, 2, 3, 'public/images/room.jpg', 1),
(16, 8, 'Family Suite', 'A comfortable demo room with a private bathroom and a place to settle in.', 144.00, 4, 2, 'public/images/suite.jpg', 1),
(17, 9, 'Comfort King', 'A comfortable demo room with a private bathroom and a place to settle in.', 117.00, 2, 3, 'public/images/room.jpg', 1),
(18, 9, 'Family Suite', 'A comfortable demo room with a private bathroom and a place to settle in.', 162.00, 4, 2, 'public/images/suite.jpg', 1),
(19, 10, 'Comfort King', 'A comfortable demo room with a private bathroom and a place to settle in.', 81.00, 2, 3, 'public/images/room.jpg', 1),
(20, 10, 'Family Suite', 'A comfortable demo room with a private bathroom and a place to settle in.', 126.00, 4, 2, 'public/images/suite.jpg', 1),
(21, 11, 'Comfort King', 'A comfortable demo room with a private bathroom and a place to settle in.', 99.00, 2, 3, 'public/images/room.jpg', 1),
(22, 11, 'Family Suite', 'A comfortable demo room with a private bathroom and a place to settle in.', 144.00, 4, 2, 'public/images/suite.jpg', 1),
(23, 12, 'Comfort King', 'A comfortable demo room with a private bathroom and a place to settle in.', 117.00, 2, 3, 'public/images/room.jpg', 1),
(24, 12, 'Family Suite', 'A comfortable demo room with a private bathroom and a place to settle in.', 162.00, 4, 2, 'public/images/suite.jpg', 1),
(25, 13, 'Comfort King', 'A comfortable demo room with a private bathroom and a place to settle in.', 81.00, 2, 3, 'public/images/room.jpg', 1),
(26, 13, 'Family Suite', 'A comfortable demo room with a private bathroom and a place to settle in.', 126.00, 4, 2, 'public/images/suite.jpg', 1),
(27, 14, 'Comfort King', 'A comfortable demo room with a private bathroom and a place to settle in.', 99.00, 2, 3, 'public/images/room.jpg', 1),
(28, 14, 'Family Suite', 'A comfortable demo room with a private bathroom and a place to settle in.', 144.00, 4, 2, 'public/images/suite.jpg', 1),
(29, 15, 'Comfort King', 'A comfortable demo room with a private bathroom and a place to settle in.', 117.00, 2, 3, 'public/images/room.jpg', 1),
(30, 15, 'Family Suite', 'A comfortable demo room with a private bathroom and a place to settle in.', 162.00, 4, 2, 'public/images/suite.jpg', 1),
(31, 16, 'Comfort King', 'A comfortable demo room with a private bathroom and a place to settle in.', 97.00, 2, 3, 'public/images/room.jpg', 1),
(32, 16, 'Family Suite', 'A comfortable demo room with a private bathroom and a place to settle in.', 142.00, 4, 2, 'public/images/suite.jpg', 1),
(33, 17, 'Comfort King', 'A comfortable demo room with a private bathroom and a place to settle in.', 115.00, 2, 3, 'public/images/room.jpg', 1),
(34, 17, 'Family Suite', 'A comfortable demo room with a private bathroom and a place to settle in.', 160.00, 4, 2, 'public/images/suite.jpg', 1),
(35, 18, 'Comfort King', 'A comfortable demo room with a private bathroom and a place to settle in.', 133.00, 2, 3, 'public/images/room.jpg', 1),
(36, 18, 'Family Suite', 'A comfortable demo room with a private bathroom and a place to settle in.', 178.00, 4, 2, 'public/images/suite.jpg', 1),
(37, 19, 'Comfort King', 'A comfortable demo room with a private bathroom and a place to settle in.', 97.00, 2, 3, 'public/images/room.jpg', 1),
(38, 19, 'Family Suite', 'A comfortable demo room with a private bathroom and a place to settle in.', 142.00, 4, 2, 'public/images/suite.jpg', 1),
(39, 20, 'Comfort King', 'A comfortable demo room with a private bathroom and a place to settle in.', 115.00, 2, 3, 'public/images/room.jpg', 1),
(40, 20, 'Family Suite', 'A comfortable demo room with a private bathroom and a place to settle in.', 160.00, 4, 2, 'public/images/suite.jpg', 1),
(41, 21, 'Comfort King', 'A comfortable demo room with a private bathroom and a place to settle in.', 133.00, 2, 3, 'public/images/room.jpg', 1),
(42, 21, 'Family Suite', 'A comfortable demo room with a private bathroom and a place to settle in.', 178.00, 4, 2, 'public/images/suite.jpg', 1),
(43, 22, 'Comfort King', 'A comfortable demo room with a private bathroom and a place to settle in.', 97.00, 2, 3, 'public/images/room.jpg', 1),
(44, 22, 'Family Suite', 'A comfortable demo room with a private bathroom and a place to settle in.', 142.00, 4, 2, 'public/images/suite.jpg', 1),
(45, 23, 'Comfort King', 'A comfortable demo room with a private bathroom and a place to settle in.', 115.00, 2, 3, 'public/images/room.jpg', 1),
(46, 23, 'Family Suite', 'A comfortable demo room with a private bathroom and a place to settle in.', 160.00, 4, 2, 'public/images/suite.jpg', 1),
(47, 24, 'Comfort King', 'A comfortable demo room with a private bathroom and a place to settle in.', 133.00, 2, 3, 'public/images/room.jpg', 1),
(48, 24, 'Family Suite', 'A comfortable demo room with a private bathroom and a place to settle in.', 178.00, 4, 2, 'public/images/suite.jpg', 1),
(49, 25, 'Comfort King', 'A comfortable demo room with a private bathroom and a place to settle in.', 97.00, 2, 3, 'public/images/room.jpg', 1),
(50, 25, 'Family Suite', 'A comfortable demo room with a private bathroom and a place to settle in.', 142.00, 4, 2, 'public/images/suite.jpg', 1),
(51, 26, 'Comfort King', 'A comfortable demo room with a private bathroom and a place to settle in.', 115.00, 2, 3, 'public/images/room.jpg', 1),
(52, 26, 'Family Suite', 'A comfortable demo room with a private bathroom and a place to settle in.', 160.00, 4, 2, 'public/images/suite.jpg', 1),
(53, 27, 'Comfort King', 'A comfortable demo room with a private bathroom and a place to settle in.', 133.00, 2, 3, 'public/images/room.jpg', 1),
(54, 27, 'Family Suite', 'A comfortable demo room with a private bathroom and a place to settle in.', 178.00, 4, 2, 'public/images/suite.jpg', 1),
(55, 28, 'Comfort King', 'A comfortable demo room with a private bathroom and a place to settle in.', 97.00, 2, 3, 'public/images/room.jpg', 1),
(56, 28, 'Family Suite', 'A comfortable demo room with a private bathroom and a place to settle in.', 142.00, 4, 2, 'public/images/suite.jpg', 1),
(57, 29, 'Comfort King', 'A comfortable demo room with a private bathroom and a place to settle in.', 115.00, 2, 3, 'public/images/room.jpg', 1),
(58, 29, 'Family Suite', 'A comfortable demo room with a private bathroom and a place to settle in.', 160.00, 4, 2, 'public/images/suite.jpg', 1),
(59, 30, 'Comfort King', 'A comfortable demo room with a private bathroom and a place to settle in.', 133.00, 2, 3, 'public/images/room.jpg', 1),
(60, 30, 'Family Suite', 'A comfortable demo room with a private bathroom and a place to settle in.', 178.00, 4, 2, 'public/images/suite.jpg', 1),
(61, 31, 'Comfort King', 'A comfortable demo room with a private bathroom and a place to settle in.', 113.00, 2, 3, 'public/images/room.jpg', 1),
(62, 31, 'Family Suite', 'A comfortable demo room with a private bathroom and a place to settle in.', 158.00, 4, 2, 'public/images/suite.jpg', 1),
(63, 32, 'Comfort King', 'A comfortable demo room with a private bathroom and a place to settle in.', 131.00, 2, 3, 'public/images/room.jpg', 1),
(64, 32, 'Family Suite', 'A comfortable demo room with a private bathroom and a place to settle in.', 176.00, 4, 2, 'public/images/suite.jpg', 1),
(65, 33, 'Comfort King', 'A comfortable demo room with a private bathroom and a place to settle in.', 149.00, 2, 3, 'public/images/room.jpg', 1),
(66, 33, 'Family Suite', 'A comfortable demo room with a private bathroom and a place to settle in.', 194.00, 4, 2, 'public/images/suite.jpg', 1),
(67, 34, 'Comfort King', 'A comfortable demo room with a private bathroom and a place to settle in.', 113.00, 2, 3, 'public/images/room.jpg', 1),
(68, 34, 'Family Suite', 'A comfortable demo room with a private bathroom and a place to settle in.', 158.00, 4, 2, 'public/images/suite.jpg', 1),
(69, 35, 'Comfort King', 'A comfortable demo room with a private bathroom and a place to settle in.', 131.00, 2, 3, 'public/images/room.jpg', 1),
(70, 35, 'Family Suite', 'A comfortable demo room with a private bathroom and a place to settle in.', 176.00, 4, 2, 'public/images/suite.jpg', 1),
(71, 36, 'Comfort King', 'A comfortable demo room with a private bathroom and a place to settle in.', 149.00, 2, 3, 'public/images/room.jpg', 1),
(72, 36, 'Family Suite', 'A comfortable demo room with a private bathroom and a place to settle in.', 194.00, 4, 2, 'public/images/suite.jpg', 1),
(73, 37, 'Comfort King', 'A comfortable demo room with a private bathroom and a place to settle in.', 113.00, 2, 3, 'public/images/room.jpg', 1),
(74, 37, 'Family Suite', 'A comfortable demo room with a private bathroom and a place to settle in.', 158.00, 4, 2, 'public/images/suite.jpg', 1),
(75, 38, 'Comfort King', 'A comfortable demo room with a private bathroom and a place to settle in.', 131.00, 2, 3, 'public/images/room.jpg', 1),
(76, 38, 'Family Suite', 'A comfortable demo room with a private bathroom and a place to settle in.', 176.00, 4, 2, 'public/images/suite.jpg', 1),
(77, 39, 'Comfort King', 'A comfortable demo room with a private bathroom and a place to settle in.', 149.00, 2, 3, 'public/images/room.jpg', 1),
(78, 39, 'Family Suite', 'A comfortable demo room with a private bathroom and a place to settle in.', 194.00, 4, 2, 'public/images/suite.jpg', 1),
(79, 40, 'Comfort King', 'A comfortable demo room with a private bathroom and a place to settle in.', 113.00, 2, 3, 'public/images/room.jpg', 1),
(80, 40, 'Family Suite', 'A comfortable demo room with a private bathroom and a place to settle in.', 158.00, 4, 2, 'public/images/suite.jpg', 1),
(81, 41, 'Comfort King', 'A comfortable demo room with a private bathroom and a place to settle in.', 131.00, 2, 3, 'public/images/room.jpg', 1),
(82, 41, 'Family Suite', 'A comfortable demo room with a private bathroom and a place to settle in.', 176.00, 4, 2, 'public/images/suite.jpg', 1),
(83, 42, 'Comfort King', 'A comfortable demo room with a private bathroom and a place to settle in.', 149.00, 2, 3, 'public/images/room.jpg', 1),
(84, 42, 'Family Suite', 'A comfortable demo room with a private bathroom and a place to settle in.', 194.00, 4, 2, 'public/images/suite.jpg', 1),
(85, 43, 'Comfort King', 'A comfortable demo room with a private bathroom and a place to settle in.', 113.00, 2, 3, 'public/images/room.jpg', 1),
(86, 43, 'Family Suite', 'A comfortable demo room with a private bathroom and a place to settle in.', 158.00, 4, 2, 'public/images/suite.jpg', 1),
(87, 44, 'Comfort King', 'A comfortable demo room with a private bathroom and a place to settle in.', 131.00, 2, 3, 'public/images/room.jpg', 1),
(88, 44, 'Family Suite', 'A comfortable demo room with a private bathroom and a place to settle in.', 176.00, 4, 2, 'public/images/suite.jpg', 1),
(89, 45, 'Comfort King', 'A comfortable demo room with a private bathroom and a place to settle in.', 149.00, 2, 3, 'public/images/room.jpg', 1),
(90, 45, 'Family Suite', 'A comfortable demo room with a private bathroom and a place to settle in.', 194.00, 4, 2, 'public/images/suite.jpg', 1),
(91, 46, 'Comfort King', 'A comfortable demo room with a private bathroom and a place to settle in.', 129.00, 2, 3, 'public/images/room.jpg', 1),
(92, 46, 'Family Suite', 'A comfortable demo room with a private bathroom and a place to settle in.', 174.00, 4, 2, 'public/images/suite.jpg', 1),
(93, 47, 'Comfort King', 'A comfortable demo room with a private bathroom and a place to settle in.', 147.00, 2, 3, 'public/images/room.jpg', 1),
(94, 47, 'Family Suite', 'A comfortable demo room with a private bathroom and a place to settle in.', 192.00, 4, 2, 'public/images/suite.jpg', 1),
(95, 48, 'Comfort King', 'A comfortable demo room with a private bathroom and a place to settle in.', 165.00, 2, 3, 'public/images/room.jpg', 1),
(96, 48, 'Family Suite', 'A comfortable demo room with a private bathroom and a place to settle in.', 210.00, 4, 2, 'public/images/suite.jpg', 1),
(97, 49, 'Comfort King', 'A comfortable demo room with a private bathroom and a place to settle in.', 129.00, 2, 3, 'public/images/room.jpg', 1),
(98, 49, 'Family Suite', 'A comfortable demo room with a private bathroom and a place to settle in.', 174.00, 4, 2, 'public/images/suite.jpg', 1),
(99, 50, 'Comfort King', 'A comfortable demo room with a private bathroom and a place to settle in.', 147.00, 2, 3, 'public/images/room.jpg', 1),
(100, 50, 'Family Suite', 'A comfortable demo room with a private bathroom and a place to settle in.', 192.00, 4, 2, 'public/images/suite.jpg', 1),
(101, 51, 'Comfort King', 'A comfortable demo room with a private bathroom and a place to settle in.', 165.00, 2, 3, 'public/images/room.jpg', 1),
(102, 51, 'Family Suite', 'A comfortable demo room with a private bathroom and a place to settle in.', 210.00, 4, 2, 'public/images/suite.jpg', 1),
(103, 52, 'Comfort King', 'A comfortable demo room with a private bathroom and a place to settle in.', 129.00, 2, 3, 'public/images/room.jpg', 1),
(104, 52, 'Family Suite', 'A comfortable demo room with a private bathroom and a place to settle in.', 174.00, 4, 2, 'public/images/suite.jpg', 1),
(105, 53, 'Comfort King', 'A comfortable demo room with a private bathroom and a place to settle in.', 147.00, 2, 3, 'public/images/room.jpg', 1),
(106, 53, 'Family Suite', 'A comfortable demo room with a private bathroom and a place to settle in.', 192.00, 4, 2, 'public/images/suite.jpg', 1),
(107, 54, 'Comfort King', 'A comfortable demo room with a private bathroom and a place to settle in.', 165.00, 2, 3, 'public/images/room.jpg', 1),
(108, 54, 'Family Suite', 'A comfortable demo room with a private bathroom and a place to settle in.', 210.00, 4, 2, 'public/images/suite.jpg', 1),
(109, 55, 'Comfort King', 'A comfortable demo room with a private bathroom and a place to settle in.', 129.00, 2, 3, 'public/images/room.jpg', 1),
(110, 55, 'Family Suite', 'A comfortable demo room with a private bathroom and a place to settle in.', 174.00, 4, 2, 'public/images/suite.jpg', 1),
(111, 56, 'Comfort King', 'A comfortable demo room with a private bathroom and a place to settle in.', 147.00, 2, 3, 'public/images/room.jpg', 1),
(112, 56, 'Family Suite', 'A comfortable demo room with a private bathroom and a place to settle in.', 192.00, 4, 2, 'public/images/suite.jpg', 1),
(113, 57, 'Comfort King', 'A comfortable demo room with a private bathroom and a place to settle in.', 165.00, 2, 3, 'public/images/room.jpg', 1),
(114, 57, 'Family Suite', 'A comfortable demo room with a private bathroom and a place to settle in.', 210.00, 4, 2, 'public/images/suite.jpg', 1),
(115, 58, 'Comfort King', 'A comfortable demo room with a private bathroom and a place to settle in.', 129.00, 2, 3, 'public/images/room.jpg', 1),
(116, 58, 'Family Suite', 'A comfortable demo room with a private bathroom and a place to settle in.', 174.00, 4, 2, 'public/images/suite.jpg', 1),
(117, 59, 'Comfort King', 'A comfortable demo room with a private bathroom and a place to settle in.', 147.00, 2, 3, 'public/images/room.jpg', 1),
(118, 59, 'Family Suite', 'A comfortable demo room with a private bathroom and a place to settle in.', 192.00, 4, 2, 'public/images/suite.jpg', 1),
(119, 60, 'Comfort King', 'A comfortable demo room with a private bathroom and a place to settle in.', 165.00, 2, 3, 'public/images/room.jpg', 1),
(120, 60, 'Family Suite', 'A comfortable demo room with a private bathroom and a place to settle in.', 210.00, 4, 2, 'public/images/suite.jpg', 1),
(121, 61, 'Comfort King', 'A comfortable demo room with a private bathroom and a place to settle in.', 145.00, 2, 3, 'public/images/room.jpg', 1),
(122, 61, 'Family Suite', 'A comfortable demo room with a private bathroom and a place to settle in.', 190.00, 4, 2, 'public/images/suite.jpg', 1),
(123, 62, 'Comfort King', 'A comfortable demo room with a private bathroom and a place to settle in.', 163.00, 2, 3, 'public/images/room.jpg', 1),
(124, 62, 'Family Suite', 'A comfortable demo room with a private bathroom and a place to settle in.', 208.00, 4, 2, 'public/images/suite.jpg', 1),
(125, 63, 'Comfort King', 'A comfortable demo room with a private bathroom and a place to settle in.', 181.00, 2, 3, 'public/images/room.jpg', 1),
(126, 63, 'Family Suite', 'A comfortable demo room with a private bathroom and a place to settle in.', 226.00, 4, 2, 'public/images/suite.jpg', 1),
(127, 64, 'Comfort King', 'A comfortable demo room with a private bathroom and a place to settle in.', 145.00, 2, 3, 'public/images/room.jpg', 1),
(128, 64, 'Family Suite', 'A comfortable demo room with a private bathroom and a place to settle in.', 190.00, 4, 2, 'public/images/suite.jpg', 1),
(129, 65, 'Comfort King', 'A comfortable demo room with a private bathroom and a place to settle in.', 163.00, 2, 3, 'public/images/room.jpg', 1),
(130, 65, 'Family Suite', 'A comfortable demo room with a private bathroom and a place to settle in.', 208.00, 4, 2, 'public/images/suite.jpg', 1),
(131, 66, 'Comfort King', 'A comfortable demo room with a private bathroom and a place to settle in.', 181.00, 2, 3, 'public/images/room.jpg', 1),
(132, 66, 'Family Suite', 'A comfortable demo room with a private bathroom and a place to settle in.', 226.00, 4, 2, 'public/images/suite.jpg', 1),
(133, 67, 'Comfort King', 'A comfortable demo room with a private bathroom and a place to settle in.', 145.00, 2, 3, 'public/images/room.jpg', 1),
(134, 67, 'Family Suite', 'A comfortable demo room with a private bathroom and a place to settle in.', 190.00, 4, 2, 'public/images/suite.jpg', 1),
(135, 68, 'Comfort King', 'A comfortable demo room with a private bathroom and a place to settle in.', 163.00, 2, 3, 'public/images/room.jpg', 1),
(136, 68, 'Family Suite', 'A comfortable demo room with a private bathroom and a place to settle in.', 208.00, 4, 2, 'public/images/suite.jpg', 1),
(137, 69, 'Comfort King', 'A comfortable demo room with a private bathroom and a place to settle in.', 181.00, 2, 3, 'public/images/room.jpg', 1),
(138, 69, 'Family Suite', 'A comfortable demo room with a private bathroom and a place to settle in.', 226.00, 4, 2, 'public/images/suite.jpg', 1),
(139, 70, 'Comfort King', 'A comfortable demo room with a private bathroom and a place to settle in.', 145.00, 2, 3, 'public/images/room.jpg', 1),
(140, 70, 'Family Suite', 'A comfortable demo room with a private bathroom and a place to settle in.', 190.00, 4, 2, 'public/images/suite.jpg', 1),
(141, 71, 'Comfort King', 'A comfortable demo room with a private bathroom and a place to settle in.', 163.00, 2, 3, 'public/images/room.jpg', 1),
(142, 71, 'Family Suite', 'A comfortable demo room with a private bathroom and a place to settle in.', 208.00, 4, 2, 'public/images/suite.jpg', 1),
(143, 72, 'Comfort King', 'A comfortable demo room with a private bathroom and a place to settle in.', 181.00, 2, 3, 'public/images/room.jpg', 1),
(144, 72, 'Family Suite', 'A comfortable demo room with a private bathroom and a place to settle in.', 226.00, 4, 2, 'public/images/suite.jpg', 1),
(145, 73, 'Comfort King', 'A comfortable demo room with a private bathroom and a place to settle in.', 145.00, 2, 3, 'public/images/room.jpg', 1),
(146, 73, 'Family Suite', 'A comfortable demo room with a private bathroom and a place to settle in.', 190.00, 4, 2, 'public/images/suite.jpg', 1),
(147, 74, 'Comfort King', 'A comfortable demo room with a private bathroom and a place to settle in.', 163.00, 2, 3, 'public/images/room.jpg', 1),
(148, 74, 'Family Suite', 'A comfortable demo room with a private bathroom and a place to settle in.', 208.00, 4, 2, 'public/images/suite.jpg', 1),
(149, 75, 'Comfort King', 'A comfortable demo room with a private bathroom and a place to settle in.', 181.00, 2, 3, 'public/images/room.jpg', 1),
(150, 75, 'Family Suite', 'A comfortable demo room with a private bathroom and a place to settle in.', 226.00, 4, 2, 'public/images/suite.jpg', 1),
(151, 76, 'Comfort King', 'A comfortable demo room with a private bathroom and a place to settle in.', 55.00, 2, 3, 'public/images/room.jpg', 1),
(152, 76, 'Family Suite', 'A comfortable demo room with a private bathroom and a place to settle in.', 85.00, 4, 3, 'public/images/suite.jpg', 1),
(153, 77, 'Comfort King', 'A comfortable demo room with a private bathroom and a place to settle in.', 70.00, 2, 3, 'public/images/room.jpg', 1),
(154, 77, 'Family Suite', 'A comfortable demo room with a private bathroom and a place to settle in.', 100.00, 4, 3, 'public/images/suite.jpg', 1),
(155, 78, 'Comfort King', 'A comfortable demo room with a private bathroom and a place to settle in.', 85.00, 2, 3, 'public/images/room.jpg', 1),
(156, 78, 'Family Suite', 'A comfortable demo room with a private bathroom and a place to settle in.', 115.00, 4, 3, 'public/images/suite.jpg', 1),
(157, 79, 'Comfort King', 'A comfortable demo room with a private bathroom and a place to settle in.', 55.00, 2, 3, 'public/images/room.jpg', 1),
(158, 79, 'Family Suite', 'A comfortable demo room with a private bathroom and a place to settle in.', 85.00, 4, 3, 'public/images/suite.jpg', 1),
(159, 80, 'Comfort King', 'A comfortable demo room with a private bathroom and a place to settle in.', 70.00, 2, 3, 'public/images/room.jpg', 1),
(160, 80, 'Family Suite', 'A comfortable demo room with a private bathroom and a place to settle in.', 100.00, 4, 3, 'public/images/suite.jpg', 1),
(161, 81, 'Comfort King', 'A comfortable demo room with a private bathroom and a place to settle in.', 85.00, 2, 3, 'public/images/room.jpg', 1),
(162, 81, 'Family Suite', 'A comfortable demo room with a private bathroom and a place to settle in.', 115.00, 4, 3, 'public/images/suite.jpg', 1),
(163, 82, 'Comfort King', 'A comfortable demo room with a private bathroom and a place to settle in.', 55.00, 2, 3, 'public/images/room.jpg', 1),
(164, 82, 'Family Suite', 'A comfortable demo room with a private bathroom and a place to settle in.', 85.00, 4, 3, 'public/images/suite.jpg', 1),
(165, 83, 'Comfort King', 'A comfortable demo room with a private bathroom and a place to settle in.', 70.00, 2, 3, 'public/images/room.jpg', 1),
(166, 83, 'Family Suite', 'A comfortable demo room with a private bathroom and a place to settle in.', 100.00, 4, 3, 'public/images/suite.jpg', 1),
(167, 84, 'Comfort King', 'A comfortable demo room with a private bathroom and a place to settle in.', 85.00, 2, 3, 'public/images/room.jpg', 1),
(168, 84, 'Family Suite', 'A comfortable demo room with a private bathroom and a place to settle in.', 115.00, 4, 3, 'public/images/suite.jpg', 1),
(169, 85, 'Comfort King', 'A comfortable demo room with a private bathroom and a place to settle in.', 55.00, 2, 3, 'public/images/room.jpg', 1),
(170, 85, 'Family Suite', 'A comfortable demo room with a private bathroom and a place to settle in.', 85.00, 4, 3, 'public/images/suite.jpg', 1),
(171, 86, 'Comfort King', 'A comfortable demo room with a private bathroom and a place to settle in.', 70.00, 2, 3, 'public/images/room.jpg', 1),
(172, 86, 'Family Suite', 'A comfortable demo room with a private bathroom and a place to settle in.', 100.00, 4, 3, 'public/images/suite.jpg', 1),
(173, 87, 'Comfort King', 'A comfortable demo room with a private bathroom and a place to settle in.', 85.00, 2, 3, 'public/images/room.jpg', 1),
(174, 87, 'Family Suite', 'A comfortable demo room with a private bathroom and a place to settle in.', 115.00, 4, 3, 'public/images/suite.jpg', 1),
(175, 88, 'Comfort King', 'A comfortable demo room with a private bathroom and a place to settle in.', 55.00, 2, 3, 'public/images/room.jpg', 1),
(176, 88, 'Family Suite', 'A comfortable demo room with a private bathroom and a place to settle in.', 85.00, 4, 3, 'public/images/suite.jpg', 1),
(177, 89, 'Comfort King', 'A comfortable demo room with a private bathroom and a place to settle in.', 70.00, 2, 3, 'public/images/room.jpg', 1),
(178, 89, 'Family Suite', 'A comfortable demo room with a private bathroom and a place to settle in.', 100.00, 4, 3, 'public/images/suite.jpg', 1),
(179, 90, 'Comfort King', 'A comfortable demo room with a private bathroom and a place to settle in.', 85.00, 2, 3, 'public/images/room.jpg', 1),
(180, 90, 'Family Suite', 'A comfortable demo room with a private bathroom and a place to settle in.', 115.00, 4, 3, 'public/images/suite.jpg', 1);

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `setting_key` varchar(80) NOT NULL,
  `setting_value` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`setting_key`, `setting_value`) VALUES
('bank_account', 'NOT CONFIGURED — DEMO ONLY'),
('contact_email', 'hnaingmin21@gmail.com'),
('contact_phone', '09779772319'),
('destination_gallery_v5_migrated', '1'),
('kpay_account', '09779772319'),
('payment_instructions', 'Demo only. Replace these placeholders with verified payment instructions before accepting real bookings.'),
('setup_lock', '1'),
('site_tagline', 'Thoughtful stays and the little places that make a trip feel like yours.'),
('wave_account', '09779772319');

-- --------------------------------------------------------

--
-- Table structure for table `support_messages`
--

CREATE TABLE `support_messages` (
  `id` int(10) UNSIGNED NOT NULL,
  `thread_id` int(10) UNSIGNED NOT NULL,
  `sender_id` int(10) UNSIGNED NOT NULL,
  `sender_role` enum('customer','admin') NOT NULL,
  `body` text NOT NULL,
  `client_nonce` varchar(64) DEFAULT NULL,
  `legacy_contact_id` int(10) UNSIGNED DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `support_messages`
--

INSERT INTO `support_messages` (`id`, `thread_id`, `sender_id`, `sender_role`, `body`, `client_nonce`, `legacy_contact_id`, `created_at`) VALUES
(1, 1, 2, 'customer', 'hi', NULL, 1, '2026-10-09 10:57:58'),
(2, 1, 2, 'customer', 'hi', NULL, 2, '2026-10-09 11:11:46'),
(4, 1, 3, 'admin', 'hello', 'bfbe6a514e5ac4b990285adf69b6f249', NULL, '2026-10-09 13:20:03'),
(7, 1, 2, 'customer', 'What up?', '231b2cbcda797ee30abe35157c4571c0', NULL, '2026-10-09 17:11:01');

-- --------------------------------------------------------

--
-- Table structure for table `support_threads`
--

CREATE TABLE `support_threads` (
  `id` int(10) UNSIGNED NOT NULL,
  `customer_id` int(10) UNSIGNED NOT NULL,
  `status` enum('open','resolved') NOT NULL DEFAULT 'open',
  `customer_last_read` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `admin_last_read` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `last_message_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `support_threads`
--

INSERT INTO `support_threads` (`id`, `customer_id`, `status`, `customer_last_read`, `admin_last_read`, `created_at`, `last_message_at`) VALUES
(1, 2, 'open', 7, 7, '2026-10-09 18:59:23', '2026-10-09 17:11:01');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(120) NOT NULL,
  `email` varchar(190) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `phone` varchar(40) NOT NULL DEFAULT '',
  `profile_image` varchar(255) NOT NULL DEFAULT '',
  `role` enum('customer','admin') NOT NULL DEFAULT 'customer',
  `active` tinyint(1) NOT NULL DEFAULT 1,
  `auth_version` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `email_verified_at` datetime DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password_hash`, `phone`, `profile_image`, `role`, `active`, `auth_version`, `email_verified_at`, `created_at`) VALUES
(2, 'Naing min Htet', 'chouprobathaw19@gmail.com', '$2y$10$RRyR5a8Wqq1e3hlGMSAabOmKTZ7.QCVejjrkiSq5GqkR7XeF.puoW', '', '', 'customer', 1, 4, '2026-10-09 07:00:32', '2026-10-09 06:58:12'),
(3, 'Naing min Htet', 'mgmamarry2030@gmail.com', '$2y$10$b7Lermp.FDF10m.c8.JJKuxH5p.TMlbx2NRghbRRquFbAWdSsI/7i', '09779772319', '', 'admin', 1, 2, '2026-10-09 10:54:26', '2026-10-09 10:54:26'),
(4, 'Naing min Htet', 'hnaingmin21@gmail.com', '$2y$10$A2cjb.koNa7LOq4GnpSsiuocY3rlnXhl9O.9E65.9xBcOHbxQKf7e', '', '', 'customer', 1, 1, '2026-10-11 04:10:26', '2026-10-11 04:10:02');

-- --------------------------------------------------------

--
-- Table structure for table `wishlists`
--

CREATE TABLE `wishlists` (
  `user_id` int(10) UNSIGNED NOT NULL,
  `hotel_id` int(10) UNSIGNED NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `audit_logs`
--
ALTER TABLE `audit_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `auth_tokens`
--
ALTER TABLE `auth_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_token` (`email`,`kind`);

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `reference` (`reference`),
  ADD KEY `idx_availability` (`room_id`,`check_in`,`check_out`,`status`),
  ADD KEY `idx_customer` (`user_id`,`created_at`),
  ADD KEY `idx_expiry` (`status`,`expires_at`),
  ADD KEY `promotion_id` (`promotion_id`);

--
-- Indexes for table `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `countries`
--
ALTER TABLE `countries`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `destinations`
--
ALTER TABLE `destinations`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_destination` (`country_id`,`name`);

--
-- Indexes for table `destination_images`
--
ALTER TABLE `destination_images`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `destination_image_unique` (`destination_id`,`image`),
  ADD KEY `destination_image_order` (`destination_id`,`position`,`id`);

--
-- Indexes for table `email_deliveries`
--
ALTER TABLE `email_deliveries`
  ADD PRIMARY KEY (`id`),
  ADD KEY `email_delivery_lookup` (`email`,`created_at`);

--
-- Indexes for table `hotels`
--
ALTER TABLE `hotels`
  ADD PRIMARY KEY (`id`),
  ADD KEY `destination_id` (`destination_id`);

--
-- Indexes for table `login_attempts`
--
ALTER TABLE `login_attempts`
  ADD PRIMARY KEY (`attempt_key`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_payment_status` (`status`),
  ADD KEY `idx_transaction` (`method`,`transaction_ref`),
  ADD KEY `booking_id` (`booking_id`),
  ADD KEY `reviewed_by` (`reviewed_by`);

--
-- Indexes for table `promotions`
--
ALTER TABLE `promotions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `code` (`code`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `booking_id` (`booking_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `hotel_id` (`hotel_id`);

--
-- Indexes for table `rooms`
--
ALTER TABLE `rooms`
  ADD PRIMARY KEY (`id`),
  ADD KEY `hotel_id` (`hotel_id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`setting_key`);

--
-- Indexes for table `support_messages`
--
ALTER TABLE `support_messages`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `legacy_contact_id` (`legacy_contact_id`),
  ADD UNIQUE KEY `uq_chat_request` (`thread_id`,`sender_id`,`client_nonce`),
  ADD KEY `idx_thread_messages` (`thread_id`,`id`),
  ADD KEY `sender_id` (`sender_id`);

--
-- Indexes for table `support_threads`
--
ALTER TABLE `support_threads`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `customer_id` (`customer_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `wishlists`
--
ALTER TABLE `wishlists`
  ADD PRIMARY KEY (`user_id`,`hotel_id`),
  ADD KEY `hotel_id` (`hotel_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `audit_logs`
--
ALTER TABLE `audit_logs`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=134;

--
-- AUTO_INCREMENT for table `auth_tokens`
--
ALTER TABLE `auth_tokens`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `contacts`
--
ALTER TABLE `contacts`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `countries`
--
ALTER TABLE `countries`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `destinations`
--
ALTER TABLE `destinations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `destination_images`
--
ALTER TABLE `destination_images`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;

--
-- AUTO_INCREMENT for table `email_deliveries`
--
ALTER TABLE `email_deliveries`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `hotels`
--
ALTER TABLE `hotels`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `promotions`
--
ALTER TABLE `promotions`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rooms`
--
ALTER TABLE `rooms`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `support_messages`
--
ALTER TABLE `support_messages`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `support_threads`
--
ALTER TABLE `support_threads`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `audit_logs`
--
ALTER TABLE `audit_logs`
  ADD CONSTRAINT `audit_logs_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `bookings_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `bookings_ibfk_2` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`id`),
  ADD CONSTRAINT `bookings_ibfk_3` FOREIGN KEY (`promotion_id`) REFERENCES `promotions` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `destinations`
--
ALTER TABLE `destinations`
  ADD CONSTRAINT `destinations_ibfk_1` FOREIGN KEY (`country_id`) REFERENCES `countries` (`id`);

--
-- Constraints for table `destination_images`
--
ALTER TABLE `destination_images`
  ADD CONSTRAINT `destination_images_ibfk_1` FOREIGN KEY (`destination_id`) REFERENCES `destinations` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `hotels`
--
ALTER TABLE `hotels`
  ADD CONSTRAINT `hotels_ibfk_1` FOREIGN KEY (`destination_id`) REFERENCES `destinations` (`id`);

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_ibfk_1` FOREIGN KEY (`booking_id`) REFERENCES `bookings` (`id`),
  ADD CONSTRAINT `payments_ibfk_2` FOREIGN KEY (`reviewed_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_ibfk_1` FOREIGN KEY (`booking_id`) REFERENCES `bookings` (`id`),
  ADD CONSTRAINT `reviews_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `reviews_ibfk_3` FOREIGN KEY (`hotel_id`) REFERENCES `hotels` (`id`);

--
-- Constraints for table `rooms`
--
ALTER TABLE `rooms`
  ADD CONSTRAINT `rooms_ibfk_1` FOREIGN KEY (`hotel_id`) REFERENCES `hotels` (`id`);

--
-- Constraints for table `support_messages`
--
ALTER TABLE `support_messages`
  ADD CONSTRAINT `support_messages_ibfk_1` FOREIGN KEY (`thread_id`) REFERENCES `support_threads` (`id`),
  ADD CONSTRAINT `support_messages_ibfk_2` FOREIGN KEY (`sender_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `support_messages_ibfk_3` FOREIGN KEY (`legacy_contact_id`) REFERENCES `contacts` (`id`);

--
-- Constraints for table `support_threads`
--
ALTER TABLE `support_threads`
  ADD CONSTRAINT `support_threads_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `wishlists`
--
ALTER TABLE `wishlists`
  ADD CONSTRAINT `wishlists_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `wishlists_ibfk_2` FOREIGN KEY (`hotel_id`) REFERENCES `hotels` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
