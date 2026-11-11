-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 10, 2026 at 01:44 PM
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
-- Database: `marketplace-ecommerce`
--

-- --------------------------------------------------------

--
-- Table structure for table `affiliates`
--

CREATE TABLE `affiliates` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `referral_code` varchar(50) NOT NULL,
  `commission_rate` decimal(5,2) DEFAULT 5.00,
  `status` enum('pending','approved','suspended') DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `affiliates`
--

INSERT INTO `affiliates` (`id`, `user_id`, `referral_code`, `commission_rate`, `status`, `created_at`, `updated_at`) VALUES
(1, 6, 'AFFTEST123', 0.00, 'approved', '2026-11-10 06:12:13', '2026-11-10 06:23:51');

-- --------------------------------------------------------

--
-- Table structure for table `affiliate_clicks`
--

CREATE TABLE `affiliate_clicks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `affiliate_link_id` bigint(20) UNSIGNED NOT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `referrer` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `affiliate_links`
--

CREATE TABLE `affiliate_links` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `affiliate_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED DEFAULT NULL,
  `code` varchar(255) NOT NULL,
  `target_url` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `affiliate_sales`
--

CREATE TABLE `affiliate_sales` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `affiliate_id` bigint(20) UNSIGNED NOT NULL,
  `affiliate_link_id` bigint(20) UNSIGNED DEFAULT NULL,
  `order_id` bigint(20) UNSIGNED DEFAULT NULL,
  `sale_amount` decimal(12,2) NOT NULL DEFAULT 0.00,
  `commission_amount` decimal(12,2) NOT NULL DEFAULT 0.00,
  `status` varchar(255) NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `attributes`
--

CREATE TABLE `attributes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `attributes`
--

INSERT INTO `attributes` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Color', '2026-09-17 17:06:25', '2026-09-17 17:06:25'),
(2, 'Size', '2026-09-17 17:06:25', '2026-09-17 17:06:25');

-- --------------------------------------------------------

--
-- Table structure for table `attribute_values`
--

CREATE TABLE `attribute_values` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `attribute_id` bigint(20) UNSIGNED NOT NULL,
  `value` varchar(100) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `attribute_values`
--

INSERT INTO `attribute_values` (`id`, `attribute_id`, `value`, `created_at`, `updated_at`) VALUES
(1, 1, 'Red', '2026-09-17 11:29:20', '2026-09-17 11:29:20'),
(2, 1, 'Blue', '2026-09-17 11:29:20', '2026-09-17 11:29:20'),
(3, 1, 'Black', '2026-09-17 11:29:20', '2026-09-17 11:29:20'),
(4, 2, 'S', '2026-09-17 11:29:20', '2026-09-17 11:29:20'),
(5, 2, 'M', '2026-09-17 11:29:20', '2026-09-17 11:29:20'),
(6, 2, 'L', '2026-09-17 11:29:20', '2026-09-17 11:29:20'),
(7, 2, 'XL', '2026-09-17 11:29:20', '2026-09-17 11:29:20'),
(8, 2, 'Mx', '2026-09-17 11:32:23', '2026-09-17 11:32:23');

-- --------------------------------------------------------

--
-- Table structure for table `banners`
--

CREATE TABLE `banners` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `link` varchar(255) DEFAULT NULL,
  `position` varchar(255) NOT NULL,
  `sort_order` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `banners`
--

INSERT INTO `banners` (`id`, `title`, `image`, `link`, `position`, `sort_order`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Nidar', '1793504848_29gfo0au.webp', 'https://electronicsbangladesh.com/offer/qurbani-dhamaka-offer-on-hitachi-washing-machine', 'hero_main', 0, 1, '2026-10-01 21:38:53', '2026-10-31 21:59:30'),
(2, 'Sidar', '1793504834_5SqSCKuW.webp', 'https://electronicsbangladesh.com/offer/qurbani-dhamaka-offer-on-hitachi-washing-machine', 'hero_main', 0, 1, '2026-10-01 21:39:17', '2026-10-31 21:58:31'),
(3, 'Kaidar', '1793504820_IDWJ2SUQ.webp', 'https://electronicsbangladesh.com/offer/sharp-washing-machines', 'hero_main', 0, 1, '2026-10-01 21:39:35', '2026-10-31 21:58:09'),
(4, 'Hisens', '1793504896_0iZYIVyw.webp', 'https://electronicsbangladesh.com/category/philips-air-fryer', 'hero_side_top', 0, 1, '2026-10-31 21:48:16', '2026-10-31 22:03:19'),
(5, 'Hisens1', '1793504954_fYhOjpJG.webp', 'https://electronicsbangladesh.com/product/hisense-ac-1-5-as-18tw4rmatd01bu', 'hero_side_bottom', 0, 1, '2026-10-31 21:48:54', '2026-10-31 22:03:01'),
(6, 'Promo Sript', '1793505292_Fi1hC5XA.gif', 'https://electronicsbangladesh.com/category/xiaomi-tv', 'promo_strip', 0, 1, '2026-10-31 21:54:52', '2026-10-31 22:03:38'),
(7, 'Dual', '1793505338_ILrLRULs.webp', 'https://electronicsbangladesh.com/offer/samsung-mega-tv-deals', 'dual_left', 0, 1, '2026-10-31 21:55:38', '2026-10-31 21:57:10'),
(8, 'Dual 1', '1793505369_qLZg640Q.webp', 'https://electronicsbangladesh.com/category/haier-washing-machine', 'dual_right', 0, 1, '2026-10-31 21:56:09', '2026-10-31 21:57:32');

-- --------------------------------------------------------

--
-- Table structure for table `brands`
--

CREATE TABLE `brands` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `slug` varchar(191) NOT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `brands`
--

INSERT INTO `brands` (`id`, `name`, `slug`, `logo`, `is_active`, `created_at`, `updated_at`, `status`) VALUES
(1, 'Samsung', 'samsung', NULL, 1, NULL, NULL, 1),
(2, 'Apple', 'apple', NULL, 1, NULL, NULL, 1),
(3, 'Sony', 'sony', NULL, 1, NULL, NULL, 1),
(4, 'LG', 'lg', NULL, 1, NULL, NULL, 1),
(5, 'Xiaomi', 'xiaomi', NULL, 1, NULL, NULL, 1),
(6, 'Nike', 'nike', NULL, 1, NULL, NULL, 1),
(7, 'Adidas', 'adidas', NULL, 1, NULL, NULL, 1),
(8, 'Nestle', 'nestle', NULL, 1, NULL, NULL, 1),
(9, 'Unilever', 'unilever', NULL, 1, NULL, NULL, 1),
(10, 'Coca-Cola', 'coca-cola', NULL, 1, NULL, NULL, 1),
(11, 'Hisense', 'hisense', NULL, 1, '2026-11-02 12:04:29', '2026-11-02 12:04:29', 1),
(12, 'Haier', 'haier', NULL, 1, '2026-11-02 12:04:29', '2026-11-02 12:04:29', 1);

-- --------------------------------------------------------

--
-- Table structure for table `bulk_orders`
--

CREATE TABLE `bulk_orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `wholesaler_id` bigint(20) UNSIGNED DEFAULT NULL,
  `customer_id` bigint(20) UNSIGNED NOT NULL,
  `wholesale_product_id` bigint(20) UNSIGNED NOT NULL,
  `quantity` int(11) NOT NULL,
  `total_price` decimal(12,2) NOT NULL,
  `status` enum('pending','confirmed','delivered','cancelled') DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('buydorbd-cache-0ade7c2cf97f75d009975f4d720d1fa6c19f4897', 'i:4;', 1794291838),
('buydorbd-cache-0ade7c2cf97f75d009975f4d720d1fa6c19f4897:timer', 'i:1794291838;', 1794291838),
('buydorbd-cache-19f08cb975a80ae00c3fa2b915fbd07f', 'i:1;', 1794227686),
('buydorbd-cache-19f08cb975a80ae00c3fa2b915fbd07f:timer', 'i:1794227686;', 1794227686),
('buydorbd-cache-1d1a1d8bfe53712a2afe720232300be7', 'i:1;', 1794216146),
('buydorbd-cache-1d1a1d8bfe53712a2afe720232300be7:timer', 'i:1794216146;', 1794216146),
('buydorbd-cache-3a12486d9c045ea9fc52e1f950c1d066', 'i:1;', 1794226319),
('buydorbd-cache-3a12486d9c045ea9fc52e1f950c1d066:timer', 'i:1794226319;', 1794226319),
('buydorbd-cache-429c7731adbd4fda81b6c23d4989a6bd885b425b', 'i:1;', 1793983058),
('buydorbd-cache-429c7731adbd4fda81b6c23d4989a6bd885b425b:timer', 'i:1793983058;', 1793983058),
('buydorbd-cache-47097028c7bd60acbddbc5d20b463ba5', 'i:2;', 1794215945),
('buydorbd-cache-47097028c7bd60acbddbc5d20b463ba5:timer', 'i:1794215945;', 1794215945),
('buydorbd-cache-4bde7e055989def7428182c52a8a86123d701282', 'i:1;', 1793862213),
('buydorbd-cache-4bde7e055989def7428182c52a8a86123d701282:timer', 'i:1793862213;', 1793862213),
('buydorbd-cache-5c785c036466adea360111aa28563bfd556b5fba', 'i:2;', 1794289399),
('buydorbd-cache-5c785c036466adea360111aa28563bfd556b5fba:timer', 'i:1794289399;', 1794289399),
('buydorbd-cache-abdullahfahim.evaly@gmail.com|144.48.109.61', 'i:1;', 1794227686),
('buydorbd-cache-abdullahfahim.evaly@gmail.com|144.48.109.61:timer', 'i:1794227686;', 1794227686),
('buydorbd-cache-b2ec88d0c43df059b66b02dcbce52f2f', 'i:1;', 1794305895),
('buydorbd-cache-b2ec88d0c43df059b66b02dcbce52f2f:timer', 'i:1794305895;', 1794305895),
('buydorbd-cache-b66fd11fec690560a4259cd327881ddd0491d819', 'i:1;', 1794229651),
('buydorbd-cache-b66fd11fec690560a4259cd327881ddd0491d819:timer', 'i:1794229651;', 1794229651),
('buydorbd-cache-c525a5357e97fef8d3db25841c86da1a', 'i:1;', 1794303981),
('buydorbd-cache-c525a5357e97fef8d3db25841c86da1a:timer', 'i:1794303981;', 1794303981);
INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('buydorbd-cache-header.categories', 'O:39:\"Illuminate\\Database\\Eloquent\\Collection\":2:{s:8:\"\0*\0items\";a:17:{i:0;O:19:\"App\\Models\\Category\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:10:\"categories\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:11:{s:2:\"id\";i:52;s:9:\"parent_id\";N;s:4:\"name\";s:15:\"Air Conditioner\";s:4:\"slug\";s:15:\"air-conditioner\";s:5:\"image\";N;s:6:\"status\";i:1;s:4:\"icon\";N;s:9:\"is_active\";i:1;s:10:\"sort_order\";i:0;s:10:\"created_at\";s:19:\"2026-11-01 12:52:49\";s:10:\"updated_at\";s:19:\"2026-11-01 12:52:49\";}s:11:\"\0*\0original\";a:11:{s:2:\"id\";i:52;s:9:\"parent_id\";N;s:4:\"name\";s:15:\"Air Conditioner\";s:4:\"slug\";s:15:\"air-conditioner\";s:5:\"image\";N;s:6:\"status\";i:1;s:4:\"icon\";N;s:9:\"is_active\";i:1;s:10:\"sort_order\";i:0;s:10:\"created_at\";s:19:\"2026-11-01 12:52:49\";s:10:\"updated_at\";s:19:\"2026-11-01 12:52:49\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:1:{s:8:\"children\";O:39:\"Illuminate\\Database\\Eloquent\\Collection\":2:{s:8:\"\0*\0items\";a:3:{i:0;O:19:\"App\\Models\\Category\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:10:\"categories\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:11:{s:2:\"id\";i:60;s:9:\"parent_id\";i:52;s:4:\"name\";s:11:\"Inverter AC\";s:4:\"slug\";s:11:\"ac-inverter\";s:5:\"image\";N;s:6:\"status\";i:1;s:4:\"icon\";N;s:9:\"is_active\";i:1;s:10:\"sort_order\";i:0;s:10:\"created_at\";s:19:\"2026-11-02 18:04:29\";s:10:\"updated_at\";s:19:\"2026-11-02 18:04:29\";}s:11:\"\0*\0original\";a:11:{s:2:\"id\";i:60;s:9:\"parent_id\";i:52;s:4:\"name\";s:11:\"Inverter AC\";s:4:\"slug\";s:11:\"ac-inverter\";s:5:\"image\";N;s:6:\"status\";i:1;s:4:\"icon\";N;s:9:\"is_active\";i:1;s:10:\"sort_order\";i:0;s:10:\"created_at\";s:19:\"2026-11-02 18:04:29\";s:10:\"updated_at\";s:19:\"2026-11-02 18:04:29\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:1:{s:8:\"children\";O:39:\"Illuminate\\Database\\Eloquent\\Collection\":2:{s:8:\"\0*\0items\";a:0:{}s:28:\"\0*\0escapeWhenCastingToString\";b:0;}}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:5:{i:0;s:9:\"parent_id\";i:1;s:4:\"name\";i:2;s:4:\"slug\";i:3;s:5:\"image\";i:4;s:6:\"status\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}i:1;O:19:\"App\\Models\\Category\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:10:\"categories\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:11:{s:2:\"id\";i:61;s:9:\"parent_id\";i:52;s:4:\"name\";s:15:\"Non-Inverter AC\";s:4:\"slug\";s:15:\"ac-non-inverter\";s:5:\"image\";N;s:6:\"status\";i:1;s:4:\"icon\";N;s:9:\"is_active\";i:1;s:10:\"sort_order\";i:0;s:10:\"created_at\";s:19:\"2026-11-02 18:04:29\";s:10:\"updated_at\";s:19:\"2026-11-02 18:04:29\";}s:11:\"\0*\0original\";a:11:{s:2:\"id\";i:61;s:9:\"parent_id\";i:52;s:4:\"name\";s:15:\"Non-Inverter AC\";s:4:\"slug\";s:15:\"ac-non-inverter\";s:5:\"image\";N;s:6:\"status\";i:1;s:4:\"icon\";N;s:9:\"is_active\";i:1;s:10:\"sort_order\";i:0;s:10:\"created_at\";s:19:\"2026-11-02 18:04:29\";s:10:\"updated_at\";s:19:\"2026-11-02 18:04:29\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:1:{s:8:\"children\";O:39:\"Illuminate\\Database\\Eloquent\\Collection\":2:{s:8:\"\0*\0items\";a:0:{}s:28:\"\0*\0escapeWhenCastingToString\";b:0;}}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:5:{i:0;s:9:\"parent_id\";i:1;s:4:\"name\";i:2;s:4:\"slug\";i:3;s:5:\"image\";i:4;s:6:\"status\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}i:2;O:19:\"App\\Models\\Category\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:10:\"categories\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:11:{s:2:\"id\";i:62;s:9:\"parent_id\";i:52;s:4:\"name\";s:24:\"Cassette AC (Commercial)\";s:4:\"slug\";s:11:\"ac-cassette\";s:5:\"image\";N;s:6:\"status\";i:1;s:4:\"icon\";N;s:9:\"is_active\";i:1;s:10:\"sort_order\";i:0;s:10:\"created_at\";s:19:\"2026-11-02 18:04:29\";s:10:\"updated_at\";s:19:\"2026-11-02 18:04:29\";}s:11:\"\0*\0original\";a:11:{s:2:\"id\";i:62;s:9:\"parent_id\";i:52;s:4:\"name\";s:24:\"Cassette AC (Commercial)\";s:4:\"slug\";s:11:\"ac-cassette\";s:5:\"image\";N;s:6:\"status\";i:1;s:4:\"icon\";N;s:9:\"is_active\";i:1;s:10:\"sort_order\";i:0;s:10:\"created_at\";s:19:\"2026-11-02 18:04:29\";s:10:\"updated_at\";s:19:\"2026-11-02 18:04:29\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:1:{s:8:\"children\";O:39:\"Illuminate\\Database\\Eloquent\\Collection\":2:{s:8:\"\0*\0items\";a:0:{}s:28:\"\0*\0escapeWhenCastingToString\";b:0;}}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:5:{i:0;s:9:\"parent_id\";i:1;s:4:\"name\";i:2;s:4:\"slug\";i:3;s:5:\"image\";i:4;s:6:\"status\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}}s:28:\"\0*\0escapeWhenCastingToString\";b:0;}}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:5:{i:0;s:9:\"parent_id\";i:1;s:4:\"name\";i:2;s:4:\"slug\";i:3;s:5:\"image\";i:4;s:6:\"status\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}i:1;O:19:\"App\\Models\\Category\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:10:\"categories\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:11:{s:2:\"id\";i:9;s:9:\"parent_id\";N;s:4:\"name\";s:11:\"Baby & Kids\";s:4:\"slug\";s:9:\"baby-kids\";s:5:\"image\";s:55:\"categories/vmY3aCyOXqEh5ntPMgJmn06KB6RedOC6k2yriSTu.png\";s:6:\"status\";i:1;s:4:\"icon\";N;s:9:\"is_active\";i:1;s:10:\"sort_order\";i:0;s:10:\"created_at\";s:19:\"2026-09-18 14:41:09\";s:10:\"updated_at\";s:19:\"2026-09-25 09:49:13\";}s:11:\"\0*\0original\";a:11:{s:2:\"id\";i:9;s:9:\"parent_id\";N;s:4:\"name\";s:11:\"Baby & Kids\";s:4:\"slug\";s:9:\"baby-kids\";s:5:\"image\";s:55:\"categories/vmY3aCyOXqEh5ntPMgJmn06KB6RedOC6k2yriSTu.png\";s:6:\"status\";i:1;s:4:\"icon\";N;s:9:\"is_active\";i:1;s:10:\"sort_order\";i:0;s:10:\"created_at\";s:19:\"2026-09-18 14:41:09\";s:10:\"updated_at\";s:19:\"2026-09-25 09:49:13\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:1:{s:8:\"children\";O:39:\"Illuminate\\Database\\Eloquent\\Collection\":2:{s:8:\"\0*\0items\";a:0:{}s:28:\"\0*\0escapeWhenCastingToString\";b:0;}}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:5:{i:0;s:9:\"parent_id\";i:1;s:4:\"name\";i:2;s:4:\"slug\";i:3;s:5:\"image\";i:4;s:6:\"status\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}i:2;O:19:\"App\\Models\\Category\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:10:\"categories\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:11:{s:2:\"id\";i:4;s:9:\"parent_id\";N;s:4:\"name\";s:22:\"Beauty & Personal Care\";s:4:\"slug\";s:20:\"beauty-personal-care\";s:5:\"image\";s:55:\"categories/bumGzgi3eUzXuiF6615Jsq6flcsOrCy7zUwB69Vm.png\";s:6:\"status\";i:1;s:4:\"icon\";N;s:9:\"is_active\";i:1;s:10:\"sort_order\";i:0;s:10:\"created_at\";s:19:\"2026-09-18 14:41:09\";s:10:\"updated_at\";s:19:\"2026-09-25 16:33:28\";}s:11:\"\0*\0original\";a:11:{s:2:\"id\";i:4;s:9:\"parent_id\";N;s:4:\"name\";s:22:\"Beauty & Personal Care\";s:4:\"slug\";s:20:\"beauty-personal-care\";s:5:\"image\";s:55:\"categories/bumGzgi3eUzXuiF6615Jsq6flcsOrCy7zUwB69Vm.png\";s:6:\"status\";i:1;s:4:\"icon\";N;s:9:\"is_active\";i:1;s:10:\"sort_order\";i:0;s:10:\"created_at\";s:19:\"2026-09-18 14:41:09\";s:10:\"updated_at\";s:19:\"2026-09-25 16:33:28\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:1:{s:8:\"children\";O:39:\"Illuminate\\Database\\Eloquent\\Collection\":2:{s:8:\"\0*\0items\";a:2:{i:0;O:19:\"App\\Models\\Category\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:10:\"categories\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:11:{s:2:\"id\";i:18;s:9:\"parent_id\";i:4;s:4:\"name\";s:9:\"Furniture\";s:4:\"slug\";s:9:\"furniture\";s:5:\"image\";s:55:\"categories/N4pjbZnynYSCUyKpjOa3DS7eabyeODKz6m9VlWxR.jpg\";s:6:\"status\";i:1;s:4:\"icon\";N;s:9:\"is_active\";i:1;s:10:\"sort_order\";i:0;s:10:\"created_at\";s:19:\"2026-09-18 14:41:09\";s:10:\"updated_at\";s:19:\"2026-09-19 17:28:23\";}s:11:\"\0*\0original\";a:11:{s:2:\"id\";i:18;s:9:\"parent_id\";i:4;s:4:\"name\";s:9:\"Furniture\";s:4:\"slug\";s:9:\"furniture\";s:5:\"image\";s:55:\"categories/N4pjbZnynYSCUyKpjOa3DS7eabyeODKz6m9VlWxR.jpg\";s:6:\"status\";i:1;s:4:\"icon\";N;s:9:\"is_active\";i:1;s:10:\"sort_order\";i:0;s:10:\"created_at\";s:19:\"2026-09-18 14:41:09\";s:10:\"updated_at\";s:19:\"2026-09-19 17:28:23\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:1:{s:8:\"children\";O:39:\"Illuminate\\Database\\Eloquent\\Collection\":2:{s:8:\"\0*\0items\";a:0:{}s:28:\"\0*\0escapeWhenCastingToString\";b:0;}}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:5:{i:0;s:9:\"parent_id\";i:1;s:4:\"name\";i:2;s:4:\"slug\";i:3;s:5:\"image\";i:4;s:6:\"status\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}i:1;O:19:\"App\\Models\\Category\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:10:\"categories\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:11:{s:2:\"id\";i:19;s:9:\"parent_id\";i:4;s:4:\"name\";s:10:\"Home Decor\";s:4:\"slug\";s:10:\"home-decor\";s:5:\"image\";s:55:\"categories/PZoHHYyWWaDMaz4uMQ5y0k4daCOct52C4xjuTmrw.jpg\";s:6:\"status\";i:1;s:4:\"icon\";N;s:9:\"is_active\";i:1;s:10:\"sort_order\";i:0;s:10:\"created_at\";s:19:\"2026-09-18 14:41:09\";s:10:\"updated_at\";s:19:\"2026-09-19 17:28:36\";}s:11:\"\0*\0original\";a:11:{s:2:\"id\";i:19;s:9:\"parent_id\";i:4;s:4:\"name\";s:10:\"Home Decor\";s:4:\"slug\";s:10:\"home-decor\";s:5:\"image\";s:55:\"categories/PZoHHYyWWaDMaz4uMQ5y0k4daCOct52C4xjuTmrw.jpg\";s:6:\"status\";i:1;s:4:\"icon\";N;s:9:\"is_active\";i:1;s:10:\"sort_order\";i:0;s:10:\"created_at\";s:19:\"2026-09-18 14:41:09\";s:10:\"updated_at\";s:19:\"2026-09-19 17:28:36\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:1:{s:8:\"children\";O:39:\"Illuminate\\Database\\Eloquent\\Collection\":2:{s:8:\"\0*\0items\";a:0:{}s:28:\"\0*\0escapeWhenCastingToString\";b:0;}}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:5:{i:0;s:9:\"parent_id\";i:1;s:4:\"name\";i:2;s:4:\"slug\";i:3;s:5:\"image\";i:4;s:6:\"status\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}}s:28:\"\0*\0escapeWhenCastingToString\";b:0;}}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:5:{i:0;s:9:\"parent_id\";i:1;s:4:\"name\";i:2;s:4:\"slug\";i:3;s:5:\"image\";i:4;s:6:\"status\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}i:3;O:19:\"App\\Models\\Category\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:10:\"categories\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:11:{s:2:\"id\";i:11;s:9:\"parent_id\";N;s:4:\"name\";s:18:\"Books & Stationery\";s:4:\"slug\";s:16:\"books-stationery\";s:5:\"image\";N;s:6:\"status\";i:1;s:4:\"icon\";N;s:9:\"is_active\";i:1;s:10:\"sort_order\";i:0;s:10:\"created_at\";s:19:\"2026-09-18 14:41:09\";s:10:\"updated_at\";s:19:\"2026-09-18 14:41:09\";}s:11:\"\0*\0original\";a:11:{s:2:\"id\";i:11;s:9:\"parent_id\";N;s:4:\"name\";s:18:\"Books & Stationery\";s:4:\"slug\";s:16:\"books-stationery\";s:5:\"image\";N;s:6:\"status\";i:1;s:4:\"icon\";N;s:9:\"is_active\";i:1;s:10:\"sort_order\";i:0;s:10:\"created_at\";s:19:\"2026-09-18 14:41:09\";s:10:\"updated_at\";s:19:\"2026-09-18 14:41:09\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:1:{s:8:\"children\";O:39:\"Illuminate\\Database\\Eloquent\\Collection\":2:{s:8:\"\0*\0items\";a:0:{}s:28:\"\0*\0escapeWhenCastingToString\";b:0;}}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:5:{i:0;s:9:\"parent_id\";i:1;s:4:\"name\";i:2;s:4:\"slug\";i:3;s:5:\"image\";i:4;s:6:\"status\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}i:4;O:19:\"App\\Models\\Category\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:10:\"categories\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:11:{s:2:\"id\";i:2;s:9:\"parent_id\";N;s:4:\"name\";s:11:\"Electronics\";s:4:\"slug\";s:11:\"electronics\";s:5:\"image\";s:55:\"categories/LlpqiQDo3FvUl3bfFmkErJtcm0adAK2BIxZKhFRx.jpg\";s:6:\"status\";i:1;s:4:\"icon\";N;s:9:\"is_active\";i:1;s:10:\"sort_order\";i:0;s:10:\"created_at\";s:19:\"2026-09-18 14:41:09\";s:10:\"updated_at\";s:19:\"2026-09-25 16:32:39\";}s:11:\"\0*\0original\";a:11:{s:2:\"id\";i:2;s:9:\"parent_id\";N;s:4:\"name\";s:11:\"Electronics\";s:4:\"slug\";s:11:\"electronics\";s:5:\"image\";s:55:\"categories/LlpqiQDo3FvUl3bfFmkErJtcm0adAK2BIxZKhFRx.jpg\";s:6:\"status\";i:1;s:4:\"icon\";N;s:9:\"is_active\";i:1;s:10:\"sort_order\";i:0;s:10:\"created_at\";s:19:\"2026-09-18 14:41:09\";s:10:\"updated_at\";s:19:\"2026-09-25 16:32:39\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:1:{s:8:\"children\";O:39:\"Illuminate\\Database\\Eloquent\\Collection\":2:{s:8:\"\0*\0items\";a:11:{i:0;O:19:\"App\\Models\\Category\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:10:\"categories\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:11:{s:2:\"id\";i:10;s:9:\"parent_id\";i:2;s:4:\"name\";s:10:\"Automotive\";s:4:\"slug\";s:10:\"automotive\";s:5:\"image\";s:55:\"categories/t7nhy3TKCNYZW8sd0NxIn0mO8PZD9O2Zap9TtvTQ.jpg\";s:6:\"status\";i:1;s:4:\"icon\";N;s:9:\"is_active\";i:1;s:10:\"sort_order\";i:0;s:10:\"created_at\";s:19:\"2026-09-18 14:41:09\";s:10:\"updated_at\";s:19:\"2026-09-19 17:22:07\";}s:11:\"\0*\0original\";a:11:{s:2:\"id\";i:10;s:9:\"parent_id\";i:2;s:4:\"name\";s:10:\"Automotive\";s:4:\"slug\";s:10:\"automotive\";s:5:\"image\";s:55:\"categories/t7nhy3TKCNYZW8sd0NxIn0mO8PZD9O2Zap9TtvTQ.jpg\";s:6:\"status\";i:1;s:4:\"icon\";N;s:9:\"is_active\";i:1;s:10:\"sort_order\";i:0;s:10:\"created_at\";s:19:\"2026-09-18 14:41:09\";s:10:\"updated_at\";s:19:\"2026-09-19 17:22:07\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:1:{s:8:\"children\";O:39:\"Illuminate\\Database\\Eloquent\\Collection\":2:{s:8:\"\0*\0items\";a:0:{}s:28:\"\0*\0escapeWhenCastingToString\";b:0;}}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:5:{i:0;s:9:\"parent_id\";i:1;s:4:\"name\";i:2;s:4:\"slug\";i:3;s:5:\"image\";i:4;s:6:\"status\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}i:1;O:19:\"App\\Models\\Category\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:10:\"categories\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:11:{s:2:\"id\";i:14;s:9:\"parent_id\";i:2;s:4:\"name\";s:13:\"Men\'s Fashion\";s:4:\"slug\";s:12:\"mens-fashion\";s:5:\"image\";s:55:\"categories/oXtyeK6WRYeB5M4Nm8nhyWmNlxq5n7DHvC1Djlu6.jpg\";s:6:\"status\";i:1;s:4:\"icon\";N;s:9:\"is_active\";i:1;s:10:\"sort_order\";i:0;s:10:\"created_at\";s:19:\"2026-09-18 14:41:09\";s:10:\"updated_at\";s:19:\"2026-09-19 17:25:00\";}s:11:\"\0*\0original\";a:11:{s:2:\"id\";i:14;s:9:\"parent_id\";i:2;s:4:\"name\";s:13:\"Men\'s Fashion\";s:4:\"slug\";s:12:\"mens-fashion\";s:5:\"image\";s:55:\"categories/oXtyeK6WRYeB5M4Nm8nhyWmNlxq5n7DHvC1Djlu6.jpg\";s:6:\"status\";i:1;s:4:\"icon\";N;s:9:\"is_active\";i:1;s:10:\"sort_order\";i:0;s:10:\"created_at\";s:19:\"2026-09-18 14:41:09\";s:10:\"updated_at\";s:19:\"2026-09-19 17:25:00\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:1:{s:8:\"children\";O:39:\"Illuminate\\Database\\Eloquent\\Collection\":2:{s:8:\"\0*\0items\";a:0:{}s:28:\"\0*\0escapeWhenCastingToString\";b:0;}}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:5:{i:0;s:9:\"parent_id\";i:1;s:4:\"name\";i:2;s:4:\"slug\";i:3;s:5:\"image\";i:4;s:6:\"status\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}i:2;O:19:\"App\\Models\\Category\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:10:\"categories\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:11:{s:2:\"id\";i:15;s:9:\"parent_id\";i:2;s:4:\"name\";s:15:\"Women\'s Fashion\";s:4:\"slug\";s:14:\"womens-fashion\";s:5:\"image\";s:55:\"categories/aZOOnaJn5uR5zJrCBRqZse9gR2ETr20Mq6KBQJE6.jpg\";s:6:\"status\";i:1;s:4:\"icon\";N;s:9:\"is_active\";i:1;s:10:\"sort_order\";i:0;s:10:\"created_at\";s:19:\"2026-09-18 14:41:09\";s:10:\"updated_at\";s:19:\"2026-09-19 17:25:22\";}s:11:\"\0*\0original\";a:11:{s:2:\"id\";i:15;s:9:\"parent_id\";i:2;s:4:\"name\";s:15:\"Women\'s Fashion\";s:4:\"slug\";s:14:\"womens-fashion\";s:5:\"image\";s:55:\"categories/aZOOnaJn5uR5zJrCBRqZse9gR2ETr20Mq6KBQJE6.jpg\";s:6:\"status\";i:1;s:4:\"icon\";N;s:9:\"is_active\";i:1;s:10:\"sort_order\";i:0;s:10:\"created_at\";s:19:\"2026-09-18 14:41:09\";s:10:\"updated_at\";s:19:\"2026-09-19 17:25:22\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:1:{s:8:\"children\";O:39:\"Illuminate\\Database\\Eloquent\\Collection\":2:{s:8:\"\0*\0items\";a:0:{}s:28:\"\0*\0escapeWhenCastingToString\";b:0;}}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:5:{i:0;s:9:\"parent_id\";i:1;s:4:\"name\";i:2;s:4:\"slug\";i:3;s:5:\"image\";i:4;s:6:\"status\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}i:3;O:19:\"App\\Models\\Category\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:10:\"categories\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:11:{s:2:\"id\";i:23;s:9:\"parent_id\";i:2;s:4:\"name\";s:11:\"Smartphones\";s:4:\"slug\";s:11:\"smartphones\";s:5:\"image\";N;s:6:\"status\";i:1;s:4:\"icon\";N;s:9:\"is_active\";i:1;s:10:\"sort_order\";i:0;s:10:\"created_at\";s:19:\"2026-09-20 00:24:46\";s:10:\"updated_at\";s:19:\"2026-09-20 02:29:34\";}s:11:\"\0*\0original\";a:11:{s:2:\"id\";i:23;s:9:\"parent_id\";i:2;s:4:\"name\";s:11:\"Smartphones\";s:4:\"slug\";s:11:\"smartphones\";s:5:\"image\";N;s:6:\"status\";i:1;s:4:\"icon\";N;s:9:\"is_active\";i:1;s:10:\"sort_order\";i:0;s:10:\"created_at\";s:19:\"2026-09-20 00:24:46\";s:10:\"updated_at\";s:19:\"2026-09-20 02:29:34\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:1:{s:8:\"children\";O:39:\"Illuminate\\Database\\Eloquent\\Collection\":2:{s:8:\"\0*\0items\";a:0:{}s:28:\"\0*\0escapeWhenCastingToString\";b:0;}}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:5:{i:0;s:9:\"parent_id\";i:1;s:4:\"name\";i:2;s:4:\"slug\";i:3;s:5:\"image\";i:4;s:6:\"status\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}i:4;O:19:\"App\\Models\\Category\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:10:\"categories\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:11:{s:2:\"id\";i:24;s:9:\"parent_id\";i:2;s:4:\"name\";s:7:\"Laptops\";s:4:\"slug\";s:7:\"laptops\";s:5:\"image\";s:55:\"categories/KHJNGeX2GSpGzSaEVz9ix8xY2i6yQWXQ1Re8vUfY.jpg\";s:6:\"status\";i:1;s:4:\"icon\";N;s:9:\"is_active\";i:1;s:10:\"sort_order\";i:0;s:10:\"created_at\";s:19:\"2026-09-20 00:40:15\";s:10:\"updated_at\";s:19:\"2026-09-20 02:29:17\";}s:11:\"\0*\0original\";a:11:{s:2:\"id\";i:24;s:9:\"parent_id\";i:2;s:4:\"name\";s:7:\"Laptops\";s:4:\"slug\";s:7:\"laptops\";s:5:\"image\";s:55:\"categories/KHJNGeX2GSpGzSaEVz9ix8xY2i6yQWXQ1Re8vUfY.jpg\";s:6:\"status\";i:1;s:4:\"icon\";N;s:9:\"is_active\";i:1;s:10:\"sort_order\";i:0;s:10:\"created_at\";s:19:\"2026-09-20 00:40:15\";s:10:\"updated_at\";s:19:\"2026-09-20 02:29:17\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:1:{s:8:\"children\";O:39:\"Illuminate\\Database\\Eloquent\\Collection\":2:{s:8:\"\0*\0items\";a:0:{}s:28:\"\0*\0escapeWhenCastingToString\";b:0;}}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:5:{i:0;s:9:\"parent_id\";i:1;s:4:\"name\";i:2;s:4:\"slug\";i:3;s:5:\"image\";i:4;s:6:\"status\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}i:5;O:19:\"App\\Models\\Category\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:10:\"categories\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:11:{s:2:\"id\";i:25;s:9:\"parent_id\";i:2;s:4:\"name\";s:12:\"Smartwatches\";s:4:\"slug\";s:12:\"smartwatches\";s:5:\"image\";s:55:\"categories/gYBdNotkmSoiXE6RlGWfCkOy4qZJuagXPjwO3JNd.jpg\";s:6:\"status\";i:1;s:4:\"icon\";N;s:9:\"is_active\";i:1;s:10:\"sort_order\";i:0;s:10:\"created_at\";s:19:\"2026-09-20 02:09:45\";s:10:\"updated_at\";s:19:\"2026-09-20 02:28:52\";}s:11:\"\0*\0original\";a:11:{s:2:\"id\";i:25;s:9:\"parent_id\";i:2;s:4:\"name\";s:12:\"Smartwatches\";s:4:\"slug\";s:12:\"smartwatches\";s:5:\"image\";s:55:\"categories/gYBdNotkmSoiXE6RlGWfCkOy4qZJuagXPjwO3JNd.jpg\";s:6:\"status\";i:1;s:4:\"icon\";N;s:9:\"is_active\";i:1;s:10:\"sort_order\";i:0;s:10:\"created_at\";s:19:\"2026-09-20 02:09:45\";s:10:\"updated_at\";s:19:\"2026-09-20 02:28:52\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:1:{s:8:\"children\";O:39:\"Illuminate\\Database\\Eloquent\\Collection\":2:{s:8:\"\0*\0items\";a:0:{}s:28:\"\0*\0escapeWhenCastingToString\";b:0;}}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:5:{i:0;s:9:\"parent_id\";i:1;s:4:\"name\";i:2;s:4:\"slug\";i:3;s:5:\"image\";i:4;s:6:\"status\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}i:6;O:19:\"App\\Models\\Category\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:10:\"categories\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:11:{s:2:\"id\";i:26;s:9:\"parent_id\";i:2;s:4:\"name\";s:10:\"Headphones\";s:4:\"slug\";s:10:\"headphones\";s:5:\"image\";N;s:6:\"status\";i:1;s:4:\"icon\";N;s:9:\"is_active\";i:1;s:10:\"sort_order\";i:0;s:10:\"created_at\";s:19:\"2026-09-20 02:27:12\";s:10:\"updated_at\";s:19:\"2026-09-20 02:30:56\";}s:11:\"\0*\0original\";a:11:{s:2:\"id\";i:26;s:9:\"parent_id\";i:2;s:4:\"name\";s:10:\"Headphones\";s:4:\"slug\";s:10:\"headphones\";s:5:\"image\";N;s:6:\"status\";i:1;s:4:\"icon\";N;s:9:\"is_active\";i:1;s:10:\"sort_order\";i:0;s:10:\"created_at\";s:19:\"2026-09-20 02:27:12\";s:10:\"updated_at\";s:19:\"2026-09-20 02:30:56\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:1:{s:8:\"children\";O:39:\"Illuminate\\Database\\Eloquent\\Collection\":2:{s:8:\"\0*\0items\";a:0:{}s:28:\"\0*\0escapeWhenCastingToString\";b:0;}}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:5:{i:0;s:9:\"parent_id\";i:1;s:4:\"name\";i:2;s:4:\"slug\";i:3;s:5:\"image\";i:4;s:6:\"status\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}i:7;O:19:\"App\\Models\\Category\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:10:\"categories\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:11:{s:2:\"id\";i:27;s:9:\"parent_id\";i:2;s:4:\"name\";s:7:\"Earbuds\";s:4:\"slug\";s:7:\"earbuds\";s:5:\"image\";N;s:6:\"status\";i:1;s:4:\"icon\";N;s:9:\"is_active\";i:1;s:10:\"sort_order\";i:0;s:10:\"created_at\";s:19:\"2026-09-20 02:27:23\";s:10:\"updated_at\";s:19:\"2026-09-20 02:31:04\";}s:11:\"\0*\0original\";a:11:{s:2:\"id\";i:27;s:9:\"parent_id\";i:2;s:4:\"name\";s:7:\"Earbuds\";s:4:\"slug\";s:7:\"earbuds\";s:5:\"image\";N;s:6:\"status\";i:1;s:4:\"icon\";N;s:9:\"is_active\";i:1;s:10:\"sort_order\";i:0;s:10:\"created_at\";s:19:\"2026-09-20 02:27:23\";s:10:\"updated_at\";s:19:\"2026-09-20 02:31:04\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:1:{s:8:\"children\";O:39:\"Illuminate\\Database\\Eloquent\\Collection\":2:{s:8:\"\0*\0items\";a:0:{}s:28:\"\0*\0escapeWhenCastingToString\";b:0;}}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:5:{i:0;s:9:\"parent_id\";i:1;s:4:\"name\";i:2;s:4:\"slug\";i:3;s:5:\"image\";i:4;s:6:\"status\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}i:8;O:19:\"App\\Models\\Category\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:10:\"categories\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:11:{s:2:\"id\";i:28;s:9:\"parent_id\";i:2;s:4:\"name\";s:11:\"Power Banks\";s:4:\"slug\";s:11:\"power-banks\";s:5:\"image\";N;s:6:\"status\";i:1;s:4:\"icon\";N;s:9:\"is_active\";i:1;s:10:\"sort_order\";i:0;s:10:\"created_at\";s:19:\"2026-09-20 02:27:34\";s:10:\"updated_at\";s:19:\"2026-09-20 02:31:12\";}s:11:\"\0*\0original\";a:11:{s:2:\"id\";i:28;s:9:\"parent_id\";i:2;s:4:\"name\";s:11:\"Power Banks\";s:4:\"slug\";s:11:\"power-banks\";s:5:\"image\";N;s:6:\"status\";i:1;s:4:\"icon\";N;s:9:\"is_active\";i:1;s:10:\"sort_order\";i:0;s:10:\"created_at\";s:19:\"2026-09-20 02:27:34\";s:10:\"updated_at\";s:19:\"2026-09-20 02:31:12\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:1:{s:8:\"children\";O:39:\"Illuminate\\Database\\Eloquent\\Collection\":2:{s:8:\"\0*\0items\";a:0:{}s:28:\"\0*\0escapeWhenCastingToString\";b:0;}}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:5:{i:0;s:9:\"parent_id\";i:1;s:4:\"name\";i:2;s:4:\"slug\";i:3;s:5:\"image\";i:4;s:6:\"status\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}i:9;O:19:\"App\\Models\\Category\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:10:\"categories\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:11:{s:2:\"id\";i:32;s:9:\"parent_id\";i:2;s:4:\"name\";s:18:\"Bluetooth Speakers\";s:4:\"slug\";s:18:\"bluetooth-speakers\";s:5:\"image\";N;s:6:\"status\";i:1;s:4:\"icon\";N;s:9:\"is_active\";i:1;s:10:\"sort_order\";i:0;s:10:\"created_at\";s:19:\"2026-09-20 02:31:40\";s:10:\"updated_at\";s:19:\"2026-09-20 02:31:40\";}s:11:\"\0*\0original\";a:11:{s:2:\"id\";i:32;s:9:\"parent_id\";i:2;s:4:\"name\";s:18:\"Bluetooth Speakers\";s:4:\"slug\";s:18:\"bluetooth-speakers\";s:5:\"image\";N;s:6:\"status\";i:1;s:4:\"icon\";N;s:9:\"is_active\";i:1;s:10:\"sort_order\";i:0;s:10:\"created_at\";s:19:\"2026-09-20 02:31:40\";s:10:\"updated_at\";s:19:\"2026-09-20 02:31:40\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:1:{s:8:\"children\";O:39:\"Illuminate\\Database\\Eloquent\\Collection\":2:{s:8:\"\0*\0items\";a:0:{}s:28:\"\0*\0escapeWhenCastingToString\";b:0;}}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:5:{i:0;s:9:\"parent_id\";i:1;s:4:\"name\";i:2;s:4:\"slug\";i:3;s:5:\"image\";i:4;s:6:\"status\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}i:10;O:19:\"App\\Models\\Category\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:10:\"categories\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:11:{s:2:\"id\";i:33;s:9:\"parent_id\";i:2;s:4:\"name\";s:20:\"Computer Accessories\";s:4:\"slug\";s:20:\"computer-accessories\";s:5:\"image\";N;s:6:\"status\";i:1;s:4:\"icon\";N;s:9:\"is_active\";i:1;s:10:\"sort_order\";i:0;s:10:\"created_at\";s:19:\"2026-09-20 02:32:04\";s:10:\"updated_at\";s:19:\"2026-09-20 02:32:04\";}s:11:\"\0*\0original\";a:11:{s:2:\"id\";i:33;s:9:\"parent_id\";i:2;s:4:\"name\";s:20:\"Computer Accessories\";s:4:\"slug\";s:20:\"computer-accessories\";s:5:\"image\";N;s:6:\"status\";i:1;s:4:\"icon\";N;s:9:\"is_active\";i:1;s:10:\"sort_order\";i:0;s:10:\"created_at\";s:19:\"2026-09-20 02:32:04\";s:10:\"updated_at\";s:19:\"2026-09-20 02:32:04\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:1:{s:8:\"children\";O:39:\"Illuminate\\Database\\Eloquent\\Collection\":2:{s:8:\"\0*\0items\";a:0:{}s:28:\"\0*\0escapeWhenCastingToString\";b:0;}}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:5:{i:0;s:9:\"parent_id\";i:1;s:4:\"name\";i:2;s:4:\"slug\";i:3;s:5:\"image\";i:4;s:6:\"status\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}}s:28:\"\0*\0escapeWhenCastingToString\";b:0;}}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:5:{i:0;s:9:\"parent_id\";i:1;s:4:\"name\";i:2;s:4:\"slug\";i:3;s:5:\"image\";i:4;s:6:\"status\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}i:5;O:19:\"App\\Models\\Category\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:10:\"categories\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:11:{s:2:\"id\";i:3;s:9:\"parent_id\";N;s:4:\"name\";s:7:\"Fashion\";s:4:\"slug\";s:7:\"fashion\";s:5:\"image\";s:55:\"categories/MipJzUm4TZJdyrYkPzN5k494JttxrHuAEDZbWB7H.png\";s:6:\"status\";i:1;s:4:\"icon\";N;s:9:\"is_active\";i:1;s:10:\"sort_order\";i:0;s:10:\"created_at\";s:19:\"2026-09-18 14:41:09\";s:10:\"updated_at\";s:19:\"2026-09-25 16:33:17\";}s:11:\"\0*\0original\";a:11:{s:2:\"id\";i:3;s:9:\"parent_id\";N;s:4:\"name\";s:7:\"Fashion\";s:4:\"slug\";s:7:\"fashion\";s:5:\"image\";s:55:\"categories/MipJzUm4TZJdyrYkPzN5k494JttxrHuAEDZbWB7H.png\";s:6:\"status\";i:1;s:4:\"icon\";N;s:9:\"is_active\";i:1;s:10:\"sort_order\";i:0;s:10:\"created_at\";s:19:\"2026-09-18 14:41:09\";s:10:\"updated_at\";s:19:\"2026-09-25 16:33:17\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:1:{s:8:\"children\";O:39:\"Illuminate\\Database\\Eloquent\\Collection\":2:{s:8:\"\0*\0items\";a:12:{i:0;O:19:\"App\\Models\\Category\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:10:\"categories\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:11:{s:2:\"id\";i:16;s:9:\"parent_id\";i:3;s:4:\"name\";s:8:\"Skincare\";s:4:\"slug\";s:8:\"skincare\";s:5:\"image\";s:55:\"categories/6fdZIz218M8lAqSMTRzCyhsAlHIq0p2T90SD3vLg.jpg\";s:6:\"status\";i:1;s:4:\"icon\";N;s:9:\"is_active\";i:1;s:10:\"sort_order\";i:0;s:10:\"created_at\";s:19:\"2026-09-18 14:41:09\";s:10:\"updated_at\";s:19:\"2026-09-19 17:26:47\";}s:11:\"\0*\0original\";a:11:{s:2:\"id\";i:16;s:9:\"parent_id\";i:3;s:4:\"name\";s:8:\"Skincare\";s:4:\"slug\";s:8:\"skincare\";s:5:\"image\";s:55:\"categories/6fdZIz218M8lAqSMTRzCyhsAlHIq0p2T90SD3vLg.jpg\";s:6:\"status\";i:1;s:4:\"icon\";N;s:9:\"is_active\";i:1;s:10:\"sort_order\";i:0;s:10:\"created_at\";s:19:\"2026-09-18 14:41:09\";s:10:\"updated_at\";s:19:\"2026-09-19 17:26:47\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:1:{s:8:\"children\";O:39:\"Illuminate\\Database\\Eloquent\\Collection\":2:{s:8:\"\0*\0items\";a:0:{}s:28:\"\0*\0escapeWhenCastingToString\";b:0;}}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:5:{i:0;s:9:\"parent_id\";i:1;s:4:\"name\";i:2;s:4:\"slug\";i:3;s:5:\"image\";i:4;s:6:\"status\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}i:1;O:19:\"App\\Models\\Category\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:10:\"categories\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:11:{s:2:\"id\";i:17;s:9:\"parent_id\";i:3;s:4:\"name\";s:6:\"Makeup\";s:4:\"slug\";s:6:\"makeup\";s:5:\"image\";s:55:\"categories/fcjbwbzZ8PcnDSSu5Y1e9WTbWOkyc4qYW7HVboKp.jpg\";s:6:\"status\";i:1;s:4:\"icon\";N;s:9:\"is_active\";i:1;s:10:\"sort_order\";i:0;s:10:\"created_at\";s:19:\"2026-09-18 14:41:09\";s:10:\"updated_at\";s:19:\"2026-09-19 17:26:59\";}s:11:\"\0*\0original\";a:11:{s:2:\"id\";i:17;s:9:\"parent_id\";i:3;s:4:\"name\";s:6:\"Makeup\";s:4:\"slug\";s:6:\"makeup\";s:5:\"image\";s:55:\"categories/fcjbwbzZ8PcnDSSu5Y1e9WTbWOkyc4qYW7HVboKp.jpg\";s:6:\"status\";i:1;s:4:\"icon\";N;s:9:\"is_active\";i:1;s:10:\"sort_order\";i:0;s:10:\"created_at\";s:19:\"2026-09-18 14:41:09\";s:10:\"updated_at\";s:19:\"2026-09-19 17:26:59\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:1:{s:8:\"children\";O:39:\"Illuminate\\Database\\Eloquent\\Collection\":2:{s:8:\"\0*\0items\";a:0:{}s:28:\"\0*\0escapeWhenCastingToString\";b:0;}}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:5:{i:0;s:9:\"parent_id\";i:1;s:4:\"name\";i:2;s:4:\"slug\";i:3;s:5:\"image\";i:4;s:6:\"status\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}i:2;O:19:\"App\\Models\\Category\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:10:\"categories\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:11:{s:2:\"id\";i:34;s:9:\"parent_id\";i:3;s:4:\"name\";s:14:\"Men\'s T-Shirts\";s:4:\"slug\";s:14:\"men-s-t-shirts\";s:5:\"image\";N;s:6:\"status\";i:1;s:4:\"icon\";N;s:9:\"is_active\";i:1;s:10:\"sort_order\";i:0;s:10:\"created_at\";s:19:\"2026-09-20 02:32:53\";s:10:\"updated_at\";s:19:\"2026-09-20 02:32:53\";}s:11:\"\0*\0original\";a:11:{s:2:\"id\";i:34;s:9:\"parent_id\";i:3;s:4:\"name\";s:14:\"Men\'s T-Shirts\";s:4:\"slug\";s:14:\"men-s-t-shirts\";s:5:\"image\";N;s:6:\"status\";i:1;s:4:\"icon\";N;s:9:\"is_active\";i:1;s:10:\"sort_order\";i:0;s:10:\"created_at\";s:19:\"2026-09-20 02:32:53\";s:10:\"updated_at\";s:19:\"2026-09-20 02:32:53\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:1:{s:8:\"children\";O:39:\"Illuminate\\Database\\Eloquent\\Collection\":2:{s:8:\"\0*\0items\";a:0:{}s:28:\"\0*\0escapeWhenCastingToString\";b:0;}}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:5:{i:0;s:9:\"parent_id\";i:1;s:4:\"name\";i:2;s:4:\"slug\";i:3;s:5:\"image\";i:4;s:6:\"status\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}i:3;O:19:\"App\\Models\\Category\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:10:\"categories\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:11:{s:2:\"id\";i:35;s:9:\"parent_id\";i:3;s:4:\"name\";s:12:\"Men\'s Shirts\";s:4:\"slug\";s:12:\"men-s-shirts\";s:5:\"image\";N;s:6:\"status\";i:1;s:4:\"icon\";N;s:9:\"is_active\";i:1;s:10:\"sort_order\";i:0;s:10:\"created_at\";s:19:\"2026-09-20 02:33:14\";s:10:\"updated_at\";s:19:\"2026-09-20 02:33:14\";}s:11:\"\0*\0original\";a:11:{s:2:\"id\";i:35;s:9:\"parent_id\";i:3;s:4:\"name\";s:12:\"Men\'s Shirts\";s:4:\"slug\";s:12:\"men-s-shirts\";s:5:\"image\";N;s:6:\"status\";i:1;s:4:\"icon\";N;s:9:\"is_active\";i:1;s:10:\"sort_order\";i:0;s:10:\"created_at\";s:19:\"2026-09-20 02:33:14\";s:10:\"updated_at\";s:19:\"2026-09-20 02:33:14\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:1:{s:8:\"children\";O:39:\"Illuminate\\Database\\Eloquent\\Collection\":2:{s:8:\"\0*\0items\";a:0:{}s:28:\"\0*\0escapeWhenCastingToString\";b:0;}}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:5:{i:0;s:9:\"parent_id\";i:1;s:4:\"name\";i:2;s:4:\"slug\";i:3;s:5:\"image\";i:4;s:6:\"status\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}i:4;O:19:\"App\\Models\\Category\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:10:\"categories\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:11:{s:2:\"id\";i:36;s:9:\"parent_id\";i:3;s:4:\"name\";s:11:\"Men\'s Pants\";s:4:\"slug\";s:11:\"men-s-pants\";s:5:\"image\";N;s:6:\"status\";i:1;s:4:\"icon\";N;s:9:\"is_active\";i:1;s:10:\"sort_order\";i:0;s:10:\"created_at\";s:19:\"2026-09-20 02:33:28\";s:10:\"updated_at\";s:19:\"2026-09-20 02:33:28\";}s:11:\"\0*\0original\";a:11:{s:2:\"id\";i:36;s:9:\"parent_id\";i:3;s:4:\"name\";s:11:\"Men\'s Pants\";s:4:\"slug\";s:11:\"men-s-pants\";s:5:\"image\";N;s:6:\"status\";i:1;s:4:\"icon\";N;s:9:\"is_active\";i:1;s:10:\"sort_order\";i:0;s:10:\"created_at\";s:19:\"2026-09-20 02:33:28\";s:10:\"updated_at\";s:19:\"2026-09-20 02:33:28\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:1:{s:8:\"children\";O:39:\"Illuminate\\Database\\Eloquent\\Collection\":2:{s:8:\"\0*\0items\";a:0:{}s:28:\"\0*\0escapeWhenCastingToString\";b:0;}}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:5:{i:0;s:9:\"parent_id\";i:1;s:4:\"name\";i:2;s:4:\"slug\";i:3;s:5:\"image\";i:4;s:6:\"status\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}i:5;O:19:\"App\\Models\\Category\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:10:\"categories\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:11:{s:2:\"id\";i:37;s:9:\"parent_id\";i:3;s:4:\"name\";s:15:\"Women\'s Dresses\";s:4:\"slug\";s:15:\"women-s-dresses\";s:5:\"image\";N;s:6:\"status\";i:1;s:4:\"icon\";N;s:9:\"is_active\";i:1;s:10:\"sort_order\";i:0;s:10:\"created_at\";s:19:\"2026-09-20 02:33:41\";s:10:\"updated_at\";s:19:\"2026-09-20 02:33:41\";}s:11:\"\0*\0original\";a:11:{s:2:\"id\";i:37;s:9:\"parent_id\";i:3;s:4:\"name\";s:15:\"Women\'s Dresses\";s:4:\"slug\";s:15:\"women-s-dresses\";s:5:\"image\";N;s:6:\"status\";i:1;s:4:\"icon\";N;s:9:\"is_active\";i:1;s:10:\"sort_order\";i:0;s:10:\"created_at\";s:19:\"2026-09-20 02:33:41\";s:10:\"updated_at\";s:19:\"2026-09-20 02:33:41\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:1:{s:8:\"children\";O:39:\"Illuminate\\Database\\Eloquent\\Collection\":2:{s:8:\"\0*\0items\";a:0:{}s:28:\"\0*\0escapeWhenCastingToString\";b:0;}}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:5:{i:0;s:9:\"parent_id\";i:1;s:4:\"name\";i:2;s:4:\"slug\";i:3;s:5:\"image\";i:4;s:6:\"status\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}i:6;O:19:\"App\\Models\\Category\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:10:\"categories\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:11:{s:2:\"id\";i:38;s:9:\"parent_id\";i:3;s:4:\"name\";s:12:\"Women\'s Tops\";s:4:\"slug\";s:12:\"women-s-tops\";s:5:\"image\";N;s:6:\"status\";i:1;s:4:\"icon\";N;s:9:\"is_active\";i:1;s:10:\"sort_order\";i:0;s:10:\"created_at\";s:19:\"2026-09-20 02:33:53\";s:10:\"updated_at\";s:19:\"2026-09-20 02:33:53\";}s:11:\"\0*\0original\";a:11:{s:2:\"id\";i:38;s:9:\"parent_id\";i:3;s:4:\"name\";s:12:\"Women\'s Tops\";s:4:\"slug\";s:12:\"women-s-tops\";s:5:\"image\";N;s:6:\"status\";i:1;s:4:\"icon\";N;s:9:\"is_active\";i:1;s:10:\"sort_order\";i:0;s:10:\"created_at\";s:19:\"2026-09-20 02:33:53\";s:10:\"updated_at\";s:19:\"2026-09-20 02:33:53\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:1:{s:8:\"children\";O:39:\"Illuminate\\Database\\Eloquent\\Collection\":2:{s:8:\"\0*\0items\";a:0:{}s:28:\"\0*\0escapeWhenCastingToString\";b:0;}}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:5:{i:0;s:9:\"parent_id\";i:1;s:4:\"name\";i:2;s:4:\"slug\";i:3;s:5:\"image\";i:4;s:6:\"status\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}i:7;O:19:\"App\\Models\\Category\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:10:\"categories\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:11:{s:2:\"id\";i:39;s:9:\"parent_id\";i:3;s:4:\"name\";s:14:\"Women\'s Sarees\";s:4:\"slug\";s:14:\"women-s-sarees\";s:5:\"image\";N;s:6:\"status\";i:1;s:4:\"icon\";N;s:9:\"is_active\";i:1;s:10:\"sort_order\";i:0;s:10:\"created_at\";s:19:\"2026-09-20 02:34:04\";s:10:\"updated_at\";s:19:\"2026-09-20 02:34:04\";}s:11:\"\0*\0original\";a:11:{s:2:\"id\";i:39;s:9:\"parent_id\";i:3;s:4:\"name\";s:14:\"Women\'s Sarees\";s:4:\"slug\";s:14:\"women-s-sarees\";s:5:\"image\";N;s:6:\"status\";i:1;s:4:\"icon\";N;s:9:\"is_active\";i:1;s:10:\"sort_order\";i:0;s:10:\"created_at\";s:19:\"2026-09-20 02:34:04\";s:10:\"updated_at\";s:19:\"2026-09-20 02:34:04\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:1:{s:8:\"children\";O:39:\"Illuminate\\Database\\Eloquent\\Collection\":2:{s:8:\"\0*\0items\";a:0:{}s:28:\"\0*\0escapeWhenCastingToString\";b:0;}}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:5:{i:0;s:9:\"parent_id\";i:1;s:4:\"name\";i:2;s:4:\"slug\";i:3;s:5:\"image\";i:4;s:6:\"status\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}i:8;O:19:\"App\\Models\\Category\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:10:\"categories\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:11:{s:2:\"id\";i:40;s:9:\"parent_id\";i:3;s:4:\"name\";s:13:\"Men\'s Panjabi\";s:4:\"slug\";s:13:\"men-s-panjabi\";s:5:\"image\";N;s:6:\"status\";i:1;s:4:\"icon\";N;s:9:\"is_active\";i:1;s:10:\"sort_order\";i:0;s:10:\"created_at\";s:19:\"2026-09-20 02:34:17\";s:10:\"updated_at\";s:19:\"2026-09-20 02:34:17\";}s:11:\"\0*\0original\";a:11:{s:2:\"id\";i:40;s:9:\"parent_id\";i:3;s:4:\"name\";s:13:\"Men\'s Panjabi\";s:4:\"slug\";s:13:\"men-s-panjabi\";s:5:\"image\";N;s:6:\"status\";i:1;s:4:\"icon\";N;s:9:\"is_active\";i:1;s:10:\"sort_order\";i:0;s:10:\"created_at\";s:19:\"2026-09-20 02:34:17\";s:10:\"updated_at\";s:19:\"2026-09-20 02:34:17\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:1:{s:8:\"children\";O:39:\"Illuminate\\Database\\Eloquent\\Collection\":2:{s:8:\"\0*\0items\";a:0:{}s:28:\"\0*\0escapeWhenCastingToString\";b:0;}}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:5:{i:0;s:9:\"parent_id\";i:1;s:4:\"name\";i:2;s:4:\"slug\";i:3;s:5:\"image\";i:4;s:6:\"status\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}i:9;O:19:\"App\\Models\\Category\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:10:\"categories\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:11:{s:2:\"id\";i:41;s:9:\"parent_id\";i:3;s:4:\"name\";s:5:\"Hijab\";s:4:\"slug\";s:5:\"hijab\";s:5:\"image\";N;s:6:\"status\";i:1;s:4:\"icon\";N;s:9:\"is_active\";i:1;s:10:\"sort_order\";i:0;s:10:\"created_at\";s:19:\"2026-09-20 02:34:29\";s:10:\"updated_at\";s:19:\"2026-09-20 02:34:29\";}s:11:\"\0*\0original\";a:11:{s:2:\"id\";i:41;s:9:\"parent_id\";i:3;s:4:\"name\";s:5:\"Hijab\";s:4:\"slug\";s:5:\"hijab\";s:5:\"image\";N;s:6:\"status\";i:1;s:4:\"icon\";N;s:9:\"is_active\";i:1;s:10:\"sort_order\";i:0;s:10:\"created_at\";s:19:\"2026-09-20 02:34:29\";s:10:\"updated_at\";s:19:\"2026-09-20 02:34:29\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:1:{s:8:\"children\";O:39:\"Illuminate\\Database\\Eloquent\\Collection\":2:{s:8:\"\0*\0items\";a:0:{}s:28:\"\0*\0escapeWhenCastingToString\";b:0;}}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:5:{i:0;s:9:\"parent_id\";i:1;s:4:\"name\";i:2;s:4:\"slug\";i:3;s:5:\"image\";i:4;s:6:\"status\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}i:10;O:19:\"App\\Models\\Category\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:10:\"categories\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:11:{s:2:\"id\";i:42;s:9:\"parent_id\";i:3;s:4:\"name\";s:7:\"Jackets\";s:4:\"slug\";s:7:\"jackets\";s:5:\"image\";N;s:6:\"status\";i:1;s:4:\"icon\";N;s:9:\"is_active\";i:1;s:10:\"sort_order\";i:0;s:10:\"created_at\";s:19:\"2026-09-20 02:34:40\";s:10:\"updated_at\";s:19:\"2026-09-20 02:34:40\";}s:11:\"\0*\0original\";a:11:{s:2:\"id\";i:42;s:9:\"parent_id\";i:3;s:4:\"name\";s:7:\"Jackets\";s:4:\"slug\";s:7:\"jackets\";s:5:\"image\";N;s:6:\"status\";i:1;s:4:\"icon\";N;s:9:\"is_active\";i:1;s:10:\"sort_order\";i:0;s:10:\"created_at\";s:19:\"2026-09-20 02:34:40\";s:10:\"updated_at\";s:19:\"2026-09-20 02:34:40\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:1:{s:8:\"children\";O:39:\"Illuminate\\Database\\Eloquent\\Collection\":2:{s:8:\"\0*\0items\";a:0:{}s:28:\"\0*\0escapeWhenCastingToString\";b:0;}}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:5:{i:0;s:9:\"parent_id\";i:1;s:4:\"name\";i:2;s:4:\"slug\";i:3;s:5:\"image\";i:4;s:6:\"status\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}i:11;O:19:\"App\\Models\\Category\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:10:\"categories\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:11:{s:2:\"id\";i:43;s:9:\"parent_id\";i:3;s:4:\"name\";s:13:\"Kids Clothing\";s:4:\"slug\";s:13:\"kids-clothing\";s:5:\"image\";N;s:6:\"status\";i:1;s:4:\"icon\";N;s:9:\"is_active\";i:1;s:10:\"sort_order\";i:0;s:10:\"created_at\";s:19:\"2026-09-20 02:34:52\";s:10:\"updated_at\";s:19:\"2026-09-20 02:34:52\";}s:11:\"\0*\0original\";a:11:{s:2:\"id\";i:43;s:9:\"parent_id\";i:3;s:4:\"name\";s:13:\"Kids Clothing\";s:4:\"slug\";s:13:\"kids-clothing\";s:5:\"image\";N;s:6:\"status\";i:1;s:4:\"icon\";N;s:9:\"is_active\";i:1;s:10:\"sort_order\";i:0;s:10:\"created_at\";s:19:\"2026-09-20 02:34:52\";s:10:\"updated_at\";s:19:\"2026-09-20 02:34:52\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:1:{s:8:\"children\";O:39:\"Illuminate\\Database\\Eloquent\\Collection\":2:{s:8:\"\0*\0items\";a:0:{}s:28:\"\0*\0escapeWhenCastingToString\";b:0;}}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:5:{i:0;s:9:\"parent_id\";i:1;s:4:\"name\";i:2;s:4:\"slug\";i:3;s:5:\"image\";i:4;s:6:\"status\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}}s:28:\"\0*\0escapeWhenCastingToString\";b:0;}}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:5:{i:0;s:9:\"parent_id\";i:1;s:4:\"name\";i:2;s:4:\"slug\";i:3;s:5:\"image\";i:4;s:6:\"status\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}i:6;O:19:\"App\\Models\\Category\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:10:\"categories\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:11:{s:2:\"id\";i:6;s:9:\"parent_id\";N;s:4:\"name\";s:9:\"Groceries\";s:4:\"slug\";s:9:\"groceries\";s:5:\"image\";s:55:\"categories/0MEA68BOWfB8piZP1HaNOM0F967u0XLb2eQyEqQK.png\";s:6:\"status\";i:1;s:4:\"icon\";N;s:9:\"is_active\";i:1;s:10:\"sort_order\";i:0;s:10:\"created_at\";s:19:\"2026-09-18 14:41:09\";s:10:\"updated_at\";s:19:\"2026-09-25 16:33:50\";}s:11:\"\0*\0original\";a:11:{s:2:\"id\";i:6;s:9:\"parent_id\";N;s:4:\"name\";s:9:\"Groceries\";s:4:\"slug\";s:9:\"groceries\";s:5:\"image\";s:55:\"categories/0MEA68BOWfB8piZP1HaNOM0F967u0XLb2eQyEqQK.png\";s:6:\"status\";i:1;s:4:\"icon\";N;s:9:\"is_active\";i:1;s:10:\"sort_order\";i:0;s:10:\"created_at\";s:19:\"2026-09-18 14:41:09\";s:10:\"updated_at\";s:19:\"2026-09-25 16:33:50\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:1:{s:8:\"children\";O:39:\"Illuminate\\Database\\Eloquent\\Collection\":2:{s:8:\"\0*\0items\";a:0:{}s:28:\"\0*\0escapeWhenCastingToString\";b:0;}}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:5:{i:0;s:9:\"parent_id\";i:1;s:4:\"name\";i:2;s:4:\"slug\";i:3;s:5:\"image\";i:4;s:6:\"status\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}i:7;O:19:\"App\\Models\\Category\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:10:\"categories\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:11:{s:2:\"id\";i:7;s:9:\"parent_id\";N;s:4:\"name\";s:17:\"Health & Wellness\";s:4:\"slug\";s:15:\"health-wellness\";s:5:\"image\";N;s:6:\"status\";i:1;s:4:\"icon\";N;s:9:\"is_active\";i:1;s:10:\"sort_order\";i:0;s:10:\"created_at\";s:19:\"2026-09-18 14:41:09\";s:10:\"updated_at\";s:19:\"2026-09-18 14:41:09\";}s:11:\"\0*\0original\";a:11:{s:2:\"id\";i:7;s:9:\"parent_id\";N;s:4:\"name\";s:17:\"Health & Wellness\";s:4:\"slug\";s:15:\"health-wellness\";s:5:\"image\";N;s:6:\"status\";i:1;s:4:\"icon\";N;s:9:\"is_active\";i:1;s:10:\"sort_order\";i:0;s:10:\"created_at\";s:19:\"2026-09-18 14:41:09\";s:10:\"updated_at\";s:19:\"2026-09-18 14:41:09\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:1:{s:8:\"children\";O:39:\"Illuminate\\Database\\Eloquent\\Collection\":2:{s:8:\"\0*\0items\";a:0:{}s:28:\"\0*\0escapeWhenCastingToString\";b:0;}}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:5:{i:0;s:9:\"parent_id\";i:1;s:4:\"name\";i:2;s:4:\"slug\";i:3;s:5:\"image\";i:4;s:6:\"status\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}i:8;O:19:\"App\\Models\\Category\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:10:\"categories\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:11:{s:2:\"id\";i:5;s:9:\"parent_id\";N;s:4:\"name\";s:13:\"Home & Living\";s:4:\"slug\";s:11:\"home-living\";s:5:\"image\";s:55:\"categories/NTTiJ6j707LEuZN6aGebNQ5fYNvKQh5aqZhCBSem.png\";s:6:\"status\";i:1;s:4:\"icon\";N;s:9:\"is_active\";i:1;s:10:\"sort_order\";i:0;s:10:\"created_at\";s:19:\"2026-09-18 14:41:09\";s:10:\"updated_at\";s:19:\"2026-09-25 16:33:37\";}s:11:\"\0*\0original\";a:11:{s:2:\"id\";i:5;s:9:\"parent_id\";N;s:4:\"name\";s:13:\"Home & Living\";s:4:\"slug\";s:11:\"home-living\";s:5:\"image\";s:55:\"categories/NTTiJ6j707LEuZN6aGebNQ5fYNvKQh5aqZhCBSem.png\";s:6:\"status\";i:1;s:4:\"icon\";N;s:9:\"is_active\";i:1;s:10:\"sort_order\";i:0;s:10:\"created_at\";s:19:\"2026-09-18 14:41:09\";s:10:\"updated_at\";s:19:\"2026-09-25 16:33:37\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:1:{s:8:\"children\";O:39:\"Illuminate\\Database\\Eloquent\\Collection\":2:{s:8:\"\0*\0items\";a:9:{i:0;O:19:\"App\\Models\\Category\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:10:\"categories\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:11:{s:2:\"id\";i:20;s:9:\"parent_id\";i:5;s:4:\"name\";s:16:\"Food & Beverages\";s:4:\"slug\";s:14:\"food-beverages\";s:5:\"image\";N;s:6:\"status\";i:1;s:4:\"icon\";N;s:9:\"is_active\";i:1;s:10:\"sort_order\";i:0;s:10:\"created_at\";s:19:\"2026-09-18 14:41:09\";s:10:\"updated_at\";s:19:\"2026-09-18 14:41:09\";}s:11:\"\0*\0original\";a:11:{s:2:\"id\";i:20;s:9:\"parent_id\";i:5;s:4:\"name\";s:16:\"Food & Beverages\";s:4:\"slug\";s:14:\"food-beverages\";s:5:\"image\";N;s:6:\"status\";i:1;s:4:\"icon\";N;s:9:\"is_active\";i:1;s:10:\"sort_order\";i:0;s:10:\"created_at\";s:19:\"2026-09-18 14:41:09\";s:10:\"updated_at\";s:19:\"2026-09-18 14:41:09\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:1:{s:8:\"children\";O:39:\"Illuminate\\Database\\Eloquent\\Collection\":2:{s:8:\"\0*\0items\";a:0:{}s:28:\"\0*\0escapeWhenCastingToString\";b:0;}}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:5:{i:0;s:9:\"parent_id\";i:1;s:4:\"name\";i:2;s:4:\"slug\";i:3;s:5:\"image\";i:4;s:6:\"status\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}i:1;O:19:\"App\\Models\\Category\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:10:\"categories\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:11:{s:2:\"id\";i:21;s:9:\"parent_id\";i:5;s:4:\"name\";s:20:\"Household Essentials\";s:4:\"slug\";s:20:\"household-essentials\";s:5:\"image\";N;s:6:\"status\";i:1;s:4:\"icon\";N;s:9:\"is_active\";i:1;s:10:\"sort_order\";i:0;s:10:\"created_at\";s:19:\"2026-09-18 14:41:09\";s:10:\"updated_at\";s:19:\"2026-09-20 00:48:19\";}s:11:\"\0*\0original\";a:11:{s:2:\"id\";i:21;s:9:\"parent_id\";i:5;s:4:\"name\";s:20:\"Household Essentials\";s:4:\"slug\";s:20:\"household-essentials\";s:5:\"image\";N;s:6:\"status\";i:1;s:4:\"icon\";N;s:9:\"is_active\";i:1;s:10:\"sort_order\";i:0;s:10:\"created_at\";s:19:\"2026-09-18 14:41:09\";s:10:\"updated_at\";s:19:\"2026-09-20 00:48:19\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:1:{s:8:\"children\";O:39:\"Illuminate\\Database\\Eloquent\\Collection\":2:{s:8:\"\0*\0items\";a:0:{}s:28:\"\0*\0escapeWhenCastingToString\";b:0;}}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:5:{i:0;s:9:\"parent_id\";i:1;s:4:\"name\";i:2;s:4:\"slug\";i:3;s:5:\"image\";i:4;s:6:\"status\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}i:2;O:19:\"App\\Models\\Category\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:10:\"categories\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:11:{s:2:\"id\";i:44;s:9:\"parent_id\";i:5;s:4:\"name\";s:17:\"Beds & Mattresses\";s:4:\"slug\";s:15:\"beds-mattresses\";s:5:\"image\";N;s:6:\"status\";i:1;s:4:\"icon\";N;s:9:\"is_active\";i:1;s:10:\"sort_order\";i:0;s:10:\"created_at\";s:19:\"2026-09-20 02:35:22\";s:10:\"updated_at\";s:19:\"2026-09-20 02:35:22\";}s:11:\"\0*\0original\";a:11:{s:2:\"id\";i:44;s:9:\"parent_id\";i:5;s:4:\"name\";s:17:\"Beds & Mattresses\";s:4:\"slug\";s:15:\"beds-mattresses\";s:5:\"image\";N;s:6:\"status\";i:1;s:4:\"icon\";N;s:9:\"is_active\";i:1;s:10:\"sort_order\";i:0;s:10:\"created_at\";s:19:\"2026-09-20 02:35:22\";s:10:\"updated_at\";s:19:\"2026-09-20 02:35:22\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:1:{s:8:\"children\";O:39:\"Illuminate\\Database\\Eloquent\\Collection\":2:{s:8:\"\0*\0items\";a:0:{}s:28:\"\0*\0escapeWhenCastingToString\";b:0;}}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:5:{i:0;s:9:\"parent_id\";i:1;s:4:\"name\";i:2;s:4:\"slug\";i:3;s:5:\"image\";i:4;s:6:\"status\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}i:3;O:19:\"App\\Models\\Category\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:10:\"categories\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:11:{s:2:\"id\";i:45;s:9:\"parent_id\";i:5;s:4:\"name\";s:8:\"Curtains\";s:4:\"slug\";s:8:\"curtains\";s:5:\"image\";N;s:6:\"status\";i:1;s:4:\"icon\";N;s:9:\"is_active\";i:1;s:10:\"sort_order\";i:0;s:10:\"created_at\";s:19:\"2026-09-20 02:35:41\";s:10:\"updated_at\";s:19:\"2026-09-20 02:35:41\";}s:11:\"\0*\0original\";a:11:{s:2:\"id\";i:45;s:9:\"parent_id\";i:5;s:4:\"name\";s:8:\"Curtains\";s:4:\"slug\";s:8:\"curtains\";s:5:\"image\";N;s:6:\"status\";i:1;s:4:\"icon\";N;s:9:\"is_active\";i:1;s:10:\"sort_order\";i:0;s:10:\"created_at\";s:19:\"2026-09-20 02:35:41\";s:10:\"updated_at\";s:19:\"2026-09-20 02:35:41\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:1:{s:8:\"children\";O:39:\"Illuminate\\Database\\Eloquent\\Collection\":2:{s:8:\"\0*\0items\";a:0:{}s:28:\"\0*\0escapeWhenCastingToString\";b:0;}}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:5:{i:0;s:9:\"parent_id\";i:1;s:4:\"name\";i:2;s:4:\"slug\";i:3;s:5:\"image\";i:4;s:6:\"status\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}i:4;O:19:\"App\\Models\\Category\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:10:\"categories\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:11:{s:2:\"id\";i:46;s:9:\"parent_id\";i:5;s:4:\"name\";s:9:\"Bedsheets\";s:4:\"slug\";s:9:\"bedsheets\";s:5:\"image\";N;s:6:\"status\";i:1;s:4:\"icon\";N;s:9:\"is_active\";i:1;s:10:\"sort_order\";i:0;s:10:\"created_at\";s:19:\"2026-09-20 02:35:53\";s:10:\"updated_at\";s:19:\"2026-09-20 02:35:53\";}s:11:\"\0*\0original\";a:11:{s:2:\"id\";i:46;s:9:\"parent_id\";i:5;s:4:\"name\";s:9:\"Bedsheets\";s:4:\"slug\";s:9:\"bedsheets\";s:5:\"image\";N;s:6:\"status\";i:1;s:4:\"icon\";N;s:9:\"is_active\";i:1;s:10:\"sort_order\";i:0;s:10:\"created_at\";s:19:\"2026-09-20 02:35:53\";s:10:\"updated_at\";s:19:\"2026-09-20 02:35:53\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:1:{s:8:\"children\";O:39:\"Illuminate\\Database\\Eloquent\\Collection\":2:{s:8:\"\0*\0items\";a:0:{}s:28:\"\0*\0escapeWhenCastingToString\";b:0;}}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:5:{i:0;s:9:\"parent_id\";i:1;s:4:\"name\";i:2;s:4:\"slug\";i:3;s:5:\"image\";i:4;s:6:\"status\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}i:5;O:19:\"App\\Models\\Category\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:10:\"categories\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:11:{s:2:\"id\";i:47;s:9:\"parent_id\";i:5;s:4:\"name\";s:7:\"Pillows\";s:4:\"slug\";s:7:\"pillows\";s:5:\"image\";N;s:6:\"status\";i:1;s:4:\"icon\";N;s:9:\"is_active\";i:1;s:10:\"sort_order\";i:0;s:10:\"created_at\";s:19:\"2026-09-20 02:36:03\";s:10:\"updated_at\";s:19:\"2026-09-20 02:36:03\";}s:11:\"\0*\0original\";a:11:{s:2:\"id\";i:47;s:9:\"parent_id\";i:5;s:4:\"name\";s:7:\"Pillows\";s:4:\"slug\";s:7:\"pillows\";s:5:\"image\";N;s:6:\"status\";i:1;s:4:\"icon\";N;s:9:\"is_active\";i:1;s:10:\"sort_order\";i:0;s:10:\"created_at\";s:19:\"2026-09-20 02:36:03\";s:10:\"updated_at\";s:19:\"2026-09-20 02:36:03\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:1:{s:8:\"children\";O:39:\"Illuminate\\Database\\Eloquent\\Collection\":2:{s:8:\"\0*\0items\";a:0:{}s:28:\"\0*\0escapeWhenCastingToString\";b:0;}}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:5:{i:0;s:9:\"parent_id\";i:1;s:4:\"name\";i:2;s:4:\"slug\";i:3;s:5:\"image\";i:4;s:6:\"status\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}i:6;O:19:\"App\\Models\\Category\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:10:\"categories\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:11:{s:2:\"id\";i:48;s:9:\"parent_id\";i:5;s:4:\"name\";s:15:\"Kitchen Storage\";s:4:\"slug\";s:15:\"kitchen-storage\";s:5:\"image\";N;s:6:\"status\";i:1;s:4:\"icon\";N;s:9:\"is_active\";i:1;s:10:\"sort_order\";i:0;s:10:\"created_at\";s:19:\"2026-09-20 02:36:16\";s:10:\"updated_at\";s:19:\"2026-09-20 02:36:16\";}s:11:\"\0*\0original\";a:11:{s:2:\"id\";i:48;s:9:\"parent_id\";i:5;s:4:\"name\";s:15:\"Kitchen Storage\";s:4:\"slug\";s:15:\"kitchen-storage\";s:5:\"image\";N;s:6:\"status\";i:1;s:4:\"icon\";N;s:9:\"is_active\";i:1;s:10:\"sort_order\";i:0;s:10:\"created_at\";s:19:\"2026-09-20 02:36:16\";s:10:\"updated_at\";s:19:\"2026-09-20 02:36:16\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:1:{s:8:\"children\";O:39:\"Illuminate\\Database\\Eloquent\\Collection\":2:{s:8:\"\0*\0items\";a:0:{}s:28:\"\0*\0escapeWhenCastingToString\";b:0;}}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:5:{i:0;s:9:\"parent_id\";i:1;s:4:\"name\";i:2;s:4:\"slug\";i:3;s:5:\"image\";i:4;s:6:\"status\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}i:7;O:19:\"App\\Models\\Category\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:10:\"categories\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:11:{s:2:\"id\";i:50;s:9:\"parent_id\";i:5;s:4:\"name\";s:14:\"Rugs & Carpets\";s:4:\"slug\";s:12:\"rugs-carpets\";s:5:\"image\";N;s:6:\"status\";i:1;s:4:\"icon\";N;s:9:\"is_active\";i:1;s:10:\"sort_order\";i:0;s:10:\"created_at\";s:19:\"2026-09-20 02:36:53\";s:10:\"updated_at\";s:19:\"2026-09-20 02:36:53\";}s:11:\"\0*\0original\";a:11:{s:2:\"id\";i:50;s:9:\"parent_id\";i:5;s:4:\"name\";s:14:\"Rugs & Carpets\";s:4:\"slug\";s:12:\"rugs-carpets\";s:5:\"image\";N;s:6:\"status\";i:1;s:4:\"icon\";N;s:9:\"is_active\";i:1;s:10:\"sort_order\";i:0;s:10:\"created_at\";s:19:\"2026-09-20 02:36:53\";s:10:\"updated_at\";s:19:\"2026-09-20 02:36:53\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:1:{s:8:\"children\";O:39:\"Illuminate\\Database\\Eloquent\\Collection\":2:{s:8:\"\0*\0items\";a:0:{}s:28:\"\0*\0escapeWhenCastingToString\";b:0;}}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:5:{i:0;s:9:\"parent_id\";i:1;s:4:\"name\";i:2;s:4:\"slug\";i:3;s:5:\"image\";i:4;s:6:\"status\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}i:8;O:19:\"App\\Models\\Category\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:10:\"categories\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:11:{s:2:\"id\";i:51;s:9:\"parent_id\";i:5;s:4:\"name\";s:20:\"Bathroom Accessories\";s:4:\"slug\";s:20:\"bathroom-accessories\";s:5:\"image\";N;s:6:\"status\";i:1;s:4:\"icon\";N;s:9:\"is_active\";i:1;s:10:\"sort_order\";i:0;s:10:\"created_at\";s:19:\"2026-09-20 02:38:20\";s:10:\"updated_at\";s:19:\"2026-09-20 02:38:20\";}s:11:\"\0*\0original\";a:11:{s:2:\"id\";i:51;s:9:\"parent_id\";i:5;s:4:\"name\";s:20:\"Bathroom Accessories\";s:4:\"slug\";s:20:\"bathroom-accessories\";s:5:\"image\";N;s:6:\"status\";i:1;s:4:\"icon\";N;s:9:\"is_active\";i:1;s:10:\"sort_order\";i:0;s:10:\"created_at\";s:19:\"2026-09-20 02:38:20\";s:10:\"updated_at\";s:19:\"2026-09-20 02:38:20\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:1:{s:8:\"children\";O:39:\"Illuminate\\Database\\Eloquent\\Collection\":2:{s:8:\"\0*\0items\";a:0:{}s:28:\"\0*\0escapeWhenCastingToString\";b:0;}}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:5:{i:0;s:9:\"parent_id\";i:1;s:4:\"name\";i:2;s:4:\"slug\";i:3;s:5:\"image\";i:4;s:6:\"status\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}}s:28:\"\0*\0escapeWhenCastingToString\";b:0;}}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:5:{i:0;s:9:\"parent_id\";i:1;s:4:\"name\";i:2;s:4:\"slug\";i:3;s:5:\"image\";i:4;s:6:\"status\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}i:9;O:19:\"App\\Models\\Category\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:10:\"categories\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:11:{s:2:\"id\";i:56;s:9:\"parent_id\";N;s:4:\"name\";s:14:\"Microwave Oven\";s:4:\"slug\";s:14:\"microwave-oven\";s:5:\"image\";N;s:6:\"status\";i:1;s:4:\"icon\";N;s:9:\"is_active\";i:1;s:10:\"sort_order\";i:0;s:10:\"created_at\";s:19:\"2026-11-01 12:52:49\";s:10:\"updated_at\";s:19:\"2026-11-01 12:52:49\";}s:11:\"\0*\0original\";a:11:{s:2:\"id\";i:56;s:9:\"parent_id\";N;s:4:\"name\";s:14:\"Microwave Oven\";s:4:\"slug\";s:14:\"microwave-oven\";s:5:\"image\";N;s:6:\"status\";i:1;s:4:\"icon\";N;s:9:\"is_active\";i:1;s:10:\"sort_order\";i:0;s:10:\"created_at\";s:19:\"2026-11-01 12:52:49\";s:10:\"updated_at\";s:19:\"2026-11-01 12:52:49\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:1:{s:8:\"children\";O:39:\"Illuminate\\Database\\Eloquent\\Collection\":2:{s:8:\"\0*\0items\";a:3:{i:0;O:19:\"App\\Models\\Category\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:10:\"categories\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:11:{s:2:\"id\";i:71;s:9:\"parent_id\";i:56;s:4:\"name\";s:14:\"Solo Microwave\";s:4:\"slug\";s:7:\"mw-solo\";s:5:\"image\";N;s:6:\"status\";i:1;s:4:\"icon\";N;s:9:\"is_active\";i:1;s:10:\"sort_order\";i:0;s:10:\"created_at\";s:19:\"2026-11-02 18:04:29\";s:10:\"updated_at\";s:19:\"2026-11-02 18:04:29\";}s:11:\"\0*\0original\";a:11:{s:2:\"id\";i:71;s:9:\"parent_id\";i:56;s:4:\"name\";s:14:\"Solo Microwave\";s:4:\"slug\";s:7:\"mw-solo\";s:5:\"image\";N;s:6:\"status\";i:1;s:4:\"icon\";N;s:9:\"is_active\";i:1;s:10:\"sort_order\";i:0;s:10:\"created_at\";s:19:\"2026-11-02 18:04:29\";s:10:\"updated_at\";s:19:\"2026-11-02 18:04:29\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:1:{s:8:\"children\";O:39:\"Illuminate\\Database\\Eloquent\\Collection\":2:{s:8:\"\0*\0items\";a:0:{}s:28:\"\0*\0escapeWhenCastingToString\";b:0;}}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:5:{i:0;s:9:\"parent_id\";i:1;s:4:\"name\";i:2;s:4:\"slug\";i:3;s:5:\"image\";i:4;s:6:\"status\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}i:1;O:19:\"App\\Models\\Category\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:10:\"categories\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:11:{s:2:\"id\";i:72;s:9:\"parent_id\";i:56;s:4:\"name\";s:15:\"Grill Microwave\";s:4:\"slug\";s:8:\"mw-grill\";s:5:\"image\";N;s:6:\"status\";i:1;s:4:\"icon\";N;s:9:\"is_active\";i:1;s:10:\"sort_order\";i:0;s:10:\"created_at\";s:19:\"2026-11-02 18:04:29\";s:10:\"updated_at\";s:19:\"2026-11-02 18:04:29\";}s:11:\"\0*\0original\";a:11:{s:2:\"id\";i:72;s:9:\"parent_id\";i:56;s:4:\"name\";s:15:\"Grill Microwave\";s:4:\"slug\";s:8:\"mw-grill\";s:5:\"image\";N;s:6:\"status\";i:1;s:4:\"icon\";N;s:9:\"is_active\";i:1;s:10:\"sort_order\";i:0;s:10:\"created_at\";s:19:\"2026-11-02 18:04:29\";s:10:\"updated_at\";s:19:\"2026-11-02 18:04:29\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:1:{s:8:\"children\";O:39:\"Illuminate\\Database\\Eloquent\\Collection\":2:{s:8:\"\0*\0items\";a:0:{}s:28:\"\0*\0escapeWhenCastingToString\";b:0;}}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:5:{i:0;s:9:\"parent_id\";i:1;s:4:\"name\";i:2;s:4:\"slug\";i:3;s:5:\"image\";i:4;s:6:\"status\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}i:2;O:19:\"App\\Models\\Category\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:10:\"categories\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:11:{s:2:\"id\";i:73;s:9:\"parent_id\";i:56;s:4:\"name\";s:20:\"Convection Microwave\";s:4:\"slug\";s:13:\"mw-convection\";s:5:\"image\";N;s:6:\"status\";i:1;s:4:\"icon\";N;s:9:\"is_active\";i:1;s:10:\"sort_order\";i:0;s:10:\"created_at\";s:19:\"2026-11-02 18:04:29\";s:10:\"updated_at\";s:19:\"2026-11-02 18:04:29\";}s:11:\"\0*\0original\";a:11:{s:2:\"id\";i:73;s:9:\"parent_id\";i:56;s:4:\"name\";s:20:\"Convection Microwave\";s:4:\"slug\";s:13:\"mw-convection\";s:5:\"image\";N;s:6:\"status\";i:1;s:4:\"icon\";N;s:9:\"is_active\";i:1;s:10:\"sort_order\";i:0;s:10:\"created_at\";s:19:\"2026-11-02 18:04:29\";s:10:\"updated_at\";s:19:\"2026-11-02 18:04:29\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:1:{s:8:\"children\";O:39:\"Illuminate\\Database\\Eloquent\\Collection\":2:{s:8:\"\0*\0items\";a:0:{}s:28:\"\0*\0escapeWhenCastingToString\";b:0;}}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:5:{i:0;s:9:\"parent_id\";i:1;s:4:\"name\";i:2;s:4:\"slug\";i:3;s:5:\"image\";i:4;s:6:\"status\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}}s:28:\"\0*\0escapeWhenCastingToString\";b:0;}}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:5:{i:0;s:9:\"parent_id\";i:1;s:4:\"name\";i:2;s:4:\"slug\";i:3;s:5:\"image\";i:4;s:6:\"status\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}i:10;O:19:\"App\\Models\\Category\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:10:\"categories\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:11:{s:2:\"id\";i:54;s:9:\"parent_id\";N;s:4:\"name\";s:12:\"Refrigerator\";s:4:\"slug\";s:12:\"refrigerator\";s:5:\"image\";N;s:6:\"status\";i:1;s:4:\"icon\";N;s:9:\"is_active\";i:1;s:10:\"sort_order\";i:0;s:10:\"created_at\";s:19:\"2026-11-01 12:52:49\";s:10:\"updated_at\";s:19:\"2026-11-01 12:52:49\";}s:11:\"\0*\0original\";a:11:{s:2:\"id\";i:54;s:9:\"parent_id\";N;s:4:\"name\";s:12:\"Refrigerator\";s:4:\"slug\";s:12:\"refrigerator\";s:5:\"image\";N;s:6:\"status\";i:1;s:4:\"icon\";N;s:9:\"is_active\";i:1;s:10:\"sort_order\";i:0;s:10:\"created_at\";s:19:\"2026-11-01 12:52:49\";s:10:\"updated_at\";s:19:\"2026-11-01 12:52:49\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:1:{s:8:\"children\";O:39:\"Illuminate\\Database\\Eloquent\\Collection\":2:{s:8:\"\0*\0items\";a:5:{i:0;O:19:\"App\\Models\\Category\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:10:\"categories\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:11:{s:2:\"id\";i:63;s:9:\"parent_id\";i:54;s:4:\"name\";s:17:\"Top Mount Freezer\";s:4:\"slug\";s:13:\"ref-top-mount\";s:5:\"image\";N;s:6:\"status\";i:1;s:4:\"icon\";N;s:9:\"is_active\";i:1;s:10:\"sort_order\";i:0;s:10:\"created_at\";s:19:\"2026-11-02 18:04:29\";s:10:\"updated_at\";s:19:\"2026-11-02 18:04:29\";}s:11:\"\0*\0original\";a:11:{s:2:\"id\";i:63;s:9:\"parent_id\";i:54;s:4:\"name\";s:17:\"Top Mount Freezer\";s:4:\"slug\";s:13:\"ref-top-mount\";s:5:\"image\";N;s:6:\"status\";i:1;s:4:\"icon\";N;s:9:\"is_active\";i:1;s:10:\"sort_order\";i:0;s:10:\"created_at\";s:19:\"2026-11-02 18:04:29\";s:10:\"updated_at\";s:19:\"2026-11-02 18:04:29\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:1:{s:8:\"children\";O:39:\"Illuminate\\Database\\Eloquent\\Collection\":2:{s:8:\"\0*\0items\";a:0:{}s:28:\"\0*\0escapeWhenCastingToString\";b:0;}}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:5:{i:0;s:9:\"parent_id\";i:1;s:4:\"name\";i:2;s:4:\"slug\";i:3;s:5:\"image\";i:4;s:6:\"status\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}i:1;O:19:\"App\\Models\\Category\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:10:\"categories\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:11:{s:2:\"id\";i:64;s:9:\"parent_id\";i:54;s:4:\"name\";s:20:\"Bottom Mount Freezer\";s:4:\"slug\";s:16:\"ref-bottom-mount\";s:5:\"image\";N;s:6:\"status\";i:1;s:4:\"icon\";N;s:9:\"is_active\";i:1;s:10:\"sort_order\";i:0;s:10:\"created_at\";s:19:\"2026-11-02 18:04:29\";s:10:\"updated_at\";s:19:\"2026-11-02 18:04:29\";}s:11:\"\0*\0original\";a:11:{s:2:\"id\";i:64;s:9:\"parent_id\";i:54;s:4:\"name\";s:20:\"Bottom Mount Freezer\";s:4:\"slug\";s:16:\"ref-bottom-mount\";s:5:\"image\";N;s:6:\"status\";i:1;s:4:\"icon\";N;s:9:\"is_active\";i:1;s:10:\"sort_order\";i:0;s:10:\"created_at\";s:19:\"2026-11-02 18:04:29\";s:10:\"updated_at\";s:19:\"2026-11-02 18:04:29\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:1:{s:8:\"children\";O:39:\"Illuminate\\Database\\Eloquent\\Collection\":2:{s:8:\"\0*\0items\";a:0:{}s:28:\"\0*\0escapeWhenCastingToString\";b:0;}}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:5:{i:0;s:9:\"parent_id\";i:1;s:4:\"name\";i:2;s:4:\"slug\";i:3;s:5:\"image\";i:4;s:6:\"status\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}i:2;O:19:\"App\\Models\\Category\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:10:\"categories\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:11:{s:2:\"id\";i:65;s:9:\"parent_id\";i:54;s:4:\"name\";s:12:\"Side by Side\";s:4:\"slug\";s:16:\"ref-side-by-side\";s:5:\"image\";N;s:6:\"status\";i:1;s:4:\"icon\";N;s:9:\"is_active\";i:1;s:10:\"sort_order\";i:0;s:10:\"created_at\";s:19:\"2026-11-02 18:04:29\";s:10:\"updated_at\";s:19:\"2026-11-02 18:04:29\";}s:11:\"\0*\0original\";a:11:{s:2:\"id\";i:65;s:9:\"parent_id\";i:54;s:4:\"name\";s:12:\"Side by Side\";s:4:\"slug\";s:16:\"ref-side-by-side\";s:5:\"image\";N;s:6:\"status\";i:1;s:4:\"icon\";N;s:9:\"is_active\";i:1;s:10:\"sort_order\";i:0;s:10:\"created_at\";s:19:\"2026-11-02 18:04:29\";s:10:\"updated_at\";s:19:\"2026-11-02 18:04:29\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:1:{s:8:\"children\";O:39:\"Illuminate\\Database\\Eloquent\\Collection\":2:{s:8:\"\0*\0items\";a:0:{}s:28:\"\0*\0escapeWhenCastingToString\";b:0;}}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:5:{i:0;s:9:\"parent_id\";i:1;s:4:\"name\";i:2;s:4:\"slug\";i:3;s:5:\"image\";i:4;s:6:\"status\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}i:3;O:19:\"App\\Models\\Category\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:10:\"categories\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:11:{s:2:\"id\";i:66;s:9:\"parent_id\";i:54;s:4:\"name\";s:6:\"T Door\";s:4:\"slug\";s:10:\"ref-t-door\";s:5:\"image\";N;s:6:\"status\";i:1;s:4:\"icon\";N;s:9:\"is_active\";i:1;s:10:\"sort_order\";i:0;s:10:\"created_at\";s:19:\"2026-11-02 18:04:29\";s:10:\"updated_at\";s:19:\"2026-11-02 18:04:29\";}s:11:\"\0*\0original\";a:11:{s:2:\"id\";i:66;s:9:\"parent_id\";i:54;s:4:\"name\";s:6:\"T Door\";s:4:\"slug\";s:10:\"ref-t-door\";s:5:\"image\";N;s:6:\"status\";i:1;s:4:\"icon\";N;s:9:\"is_active\";i:1;s:10:\"sort_order\";i:0;s:10:\"created_at\";s:19:\"2026-11-02 18:04:29\";s:10:\"updated_at\";s:19:\"2026-11-02 18:04:29\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:1:{s:8:\"children\";O:39:\"Illuminate\\Database\\Eloquent\\Collection\":2:{s:8:\"\0*\0items\";a:0:{}s:28:\"\0*\0escapeWhenCastingToString\";b:0;}}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:5:{i:0;s:9:\"parent_id\";i:1;s:4:\"name\";i:2;s:4:\"slug\";i:3;s:5:\"image\";i:4;s:6:\"status\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}i:4;O:19:\"App\\Models\\Category\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:10:\"categories\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:11:{s:2:\"id\";i:67;s:9:\"parent_id\";i:54;s:4:\"name\";s:8:\"No Frost\";s:4:\"slug\";s:12:\"ref-no-frost\";s:5:\"image\";N;s:6:\"status\";i:1;s:4:\"icon\";N;s:9:\"is_active\";i:1;s:10:\"sort_order\";i:0;s:10:\"created_at\";s:19:\"2026-11-02 18:04:29\";s:10:\"updated_at\";s:19:\"2026-11-02 18:04:29\";}s:11:\"\0*\0original\";a:11:{s:2:\"id\";i:67;s:9:\"parent_id\";i:54;s:4:\"name\";s:8:\"No Frost\";s:4:\"slug\";s:12:\"ref-no-frost\";s:5:\"image\";N;s:6:\"status\";i:1;s:4:\"icon\";N;s:9:\"is_active\";i:1;s:10:\"sort_order\";i:0;s:10:\"created_at\";s:19:\"2026-11-02 18:04:29\";s:10:\"updated_at\";s:19:\"2026-11-02 18:04:29\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:1:{s:8:\"children\";O:39:\"Illuminate\\Database\\Eloquent\\Collection\":2:{s:8:\"\0*\0items\";a:0:{}s:28:\"\0*\0escapeWhenCastingToString\";b:0;}}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:5:{i:0;s:9:\"parent_id\";i:1;s:4:\"name\";i:2;s:4:\"slug\";i:3;s:5:\"image\";i:4;s:6:\"status\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}}s:28:\"\0*\0escapeWhenCastingToString\";b:0;}}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:5:{i:0;s:9:\"parent_id\";i:1;s:4:\"name\";i:2;s:4:\"slug\";i:3;s:5:\"image\";i:4;s:6:\"status\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}i:11;O:19:\"App\\Models\\Category\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:10:\"categories\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:11:{s:2:\"id\";i:1;s:9:\"parent_id\";N;s:4:\"name\";s:4:\"Shop\";s:4:\"slug\";s:4:\"shop\";s:5:\"image\";s:55:\"categories/tsiPhi1Iya8vbpDidfzc0wPo2qZ1hdCdlyHTRmSl.png\";s:6:\"status\";i:1;s:4:\"icon\";N;s:9:\"is_active\";i:1;s:10:\"sort_order\";i:0;s:10:\"created_at\";s:19:\"2026-09-17 19:13:07\";s:10:\"updated_at\";s:19:\"2026-09-25 16:33:00\";}s:11:\"\0*\0original\";a:11:{s:2:\"id\";i:1;s:9:\"parent_id\";N;s:4:\"name\";s:4:\"Shop\";s:4:\"slug\";s:4:\"shop\";s:5:\"image\";s:55:\"categories/tsiPhi1Iya8vbpDidfzc0wPo2qZ1hdCdlyHTRmSl.png\";s:6:\"status\";i:1;s:4:\"icon\";N;s:9:\"is_active\";i:1;s:10:\"sort_order\";i:0;s:10:\"created_at\";s:19:\"2026-09-17 19:13:07\";s:10:\"updated_at\";s:19:\"2026-09-25 16:33:00\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:1:{s:8:\"children\";O:39:\"Illuminate\\Database\\Eloquent\\Collection\":2:{s:8:\"\0*\0items\";a:2:{i:0;O:19:\"App\\Models\\Category\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:10:\"categories\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:11:{s:2:\"id\";i:12;s:9:\"parent_id\";i:1;s:4:\"name\";s:13:\"Mobile Phones\";s:4:\"slug\";s:13:\"mobile-phones\";s:5:\"image\";s:55:\"categories/FtyaMtNSNP1qa67xSiSR6VjyH2O4hC1PBohqghny.jpg\";s:6:\"status\";i:1;s:4:\"icon\";N;s:9:\"is_active\";i:1;s:10:\"sort_order\";i:0;s:10:\"created_at\";s:19:\"2026-09-18 14:41:09\";s:10:\"updated_at\";s:19:\"2026-09-19 17:24:15\";}s:11:\"\0*\0original\";a:11:{s:2:\"id\";i:12;s:9:\"parent_id\";i:1;s:4:\"name\";s:13:\"Mobile Phones\";s:4:\"slug\";s:13:\"mobile-phones\";s:5:\"image\";s:55:\"categories/FtyaMtNSNP1qa67xSiSR6VjyH2O4hC1PBohqghny.jpg\";s:6:\"status\";i:1;s:4:\"icon\";N;s:9:\"is_active\";i:1;s:10:\"sort_order\";i:0;s:10:\"created_at\";s:19:\"2026-09-18 14:41:09\";s:10:\"updated_at\";s:19:\"2026-09-19 17:24:15\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:1:{s:8:\"children\";O:39:\"Illuminate\\Database\\Eloquent\\Collection\":2:{s:8:\"\0*\0items\";a:0:{}s:28:\"\0*\0escapeWhenCastingToString\";b:0;}}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:5:{i:0;s:9:\"parent_id\";i:1;s:4:\"name\";i:2;s:4:\"slug\";i:3;s:5:\"image\";i:4;s:6:\"status\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}i:1;O:19:\"App\\Models\\Category\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:10:\"categories\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:11:{s:2:\"id\";i:13;s:9:\"parent_id\";i:1;s:4:\"name\";s:19:\"Laptops & Computers\";s:4:\"slug\";s:17:\"laptops-computers\";s:5:\"image\";s:55:\"categories/xuL65vL0WptcfA3wMo9oYPNo2aNSrkl4Pi27w5Hf.jpg\";s:6:\"status\";i:1;s:4:\"icon\";N;s:9:\"is_active\";i:1;s:10:\"sort_order\";i:0;s:10:\"created_at\";s:19:\"2026-09-18 14:41:09\";s:10:\"updated_at\";s:19:\"2026-09-19 17:24:42\";}s:11:\"\0*\0original\";a:11:{s:2:\"id\";i:13;s:9:\"parent_id\";i:1;s:4:\"name\";s:19:\"Laptops & Computers\";s:4:\"slug\";s:17:\"laptops-computers\";s:5:\"image\";s:55:\"categories/xuL65vL0WptcfA3wMo9oYPNo2aNSrkl4Pi27w5Hf.jpg\";s:6:\"status\";i:1;s:4:\"icon\";N;s:9:\"is_active\";i:1;s:10:\"sort_order\";i:0;s:10:\"created_at\";s:19:\"2026-09-18 14:41:09\";s:10:\"updated_at\";s:19:\"2026-09-19 17:24:42\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:1:{s:8:\"children\";O:39:\"Illuminate\\Database\\Eloquent\\Collection\":2:{s:8:\"\0*\0items\";a:0:{}s:28:\"\0*\0escapeWhenCastingToString\";b:0;}}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:5:{i:0;s:9:\"parent_id\";i:1;s:4:\"name\";i:2;s:4:\"slug\";i:3;s:5:\"image\";i:4;s:6:\"status\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}}s:28:\"\0*\0escapeWhenCastingToString\";b:0;}}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:5:{i:0;s:9:\"parent_id\";i:1;s:4:\"name\";i:2;s:4:\"slug\";i:3;s:5:\"image\";i:4;s:6:\"status\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}i:12;O:19:\"App\\Models\\Category\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:10:\"categories\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:11:{s:2:\"id\";i:31;s:9:\"parent_id\";N;s:4:\"name\";s:16:\"Small Appliances\";s:4:\"slug\";s:16:\"small-appliances\";s:5:\"image\";N;s:6:\"status\";i:1;s:4:\"icon\";N;s:9:\"is_active\";i:1;s:10:\"sort_order\";i:0;s:10:\"created_at\";s:19:\"2026-09-20 02:29:53\";s:10:\"updated_at\";s:19:\"2026-11-01 05:40:38\";}s:11:\"\0*\0original\";a:11:{s:2:\"id\";i:31;s:9:\"parent_id\";N;s:4:\"name\";s:16:\"Small Appliances\";s:4:\"slug\";s:16:\"small-appliances\";s:5:\"image\";N;s:6:\"status\";i:1;s:4:\"icon\";N;s:9:\"is_active\";i:1;s:10:\"sort_order\";i:0;s:10:\"created_at\";s:19:\"2026-09-20 02:29:53\";s:10:\"updated_at\";s:19:\"2026-11-01 05:40:38\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:1:{s:8:\"children\";O:39:\"Illuminate\\Database\\Eloquent\\Collection\":2:{s:8:\"\0*\0items\";a:1:{i:0;O:19:\"App\\Models\\Category\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:10:\"categories\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:11:{s:2:\"id\";i:29;s:9:\"parent_id\";i:31;s:4:\"name\";s:8:\"Chargers\";s:4:\"slug\";s:8:\"chargers\";s:5:\"image\";N;s:6:\"status\";i:1;s:4:\"icon\";N;s:9:\"is_active\";i:1;s:10:\"sort_order\";i:0;s:10:\"created_at\";s:19:\"2026-09-20 02:27:43\";s:10:\"updated_at\";s:19:\"2026-11-01 05:43:36\";}s:11:\"\0*\0original\";a:11:{s:2:\"id\";i:29;s:9:\"parent_id\";i:31;s:4:\"name\";s:8:\"Chargers\";s:4:\"slug\";s:8:\"chargers\";s:5:\"image\";N;s:6:\"status\";i:1;s:4:\"icon\";N;s:9:\"is_active\";i:1;s:10:\"sort_order\";i:0;s:10:\"created_at\";s:19:\"2026-09-20 02:27:43\";s:10:\"updated_at\";s:19:\"2026-11-01 05:43:36\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:1:{s:8:\"children\";O:39:\"Illuminate\\Database\\Eloquent\\Collection\":2:{s:8:\"\0*\0items\";a:0:{}s:28:\"\0*\0escapeWhenCastingToString\";b:0;}}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:5:{i:0;s:9:\"parent_id\";i:1;s:4:\"name\";i:2;s:4:\"slug\";i:3;s:5:\"image\";i:4;s:6:\"status\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}}s:28:\"\0*\0escapeWhenCastingToString\";b:0;}}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:5:{i:0;s:9:\"parent_id\";i:1;s:4:\"name\";i:2;s:4:\"slug\";i:3;s:5:\"image\";i:4;s:6:\"status\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}i:13;O:19:\"App\\Models\\Category\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:10:\"categories\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:11:{s:2:\"id\";i:8;s:9:\"parent_id\";N;s:4:\"name\";s:16:\"Sports & Fitness\";s:4:\"slug\";s:14:\"sports-fitness\";s:5:\"image\";N;s:6:\"status\";i:1;s:4:\"icon\";N;s:9:\"is_active\";i:1;s:10:\"sort_order\";i:0;s:10:\"created_at\";s:19:\"2026-09-18 14:41:09\";s:10:\"updated_at\";s:19:\"2026-09-18 14:41:09\";}s:11:\"\0*\0original\";a:11:{s:2:\"id\";i:8;s:9:\"parent_id\";N;s:4:\"name\";s:16:\"Sports & Fitness\";s:4:\"slug\";s:14:\"sports-fitness\";s:5:\"image\";N;s:6:\"status\";i:1;s:4:\"icon\";N;s:9:\"is_active\";i:1;s:10:\"sort_order\";i:0;s:10:\"created_at\";s:19:\"2026-09-18 14:41:09\";s:10:\"updated_at\";s:19:\"2026-09-18 14:41:09\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:1:{s:8:\"children\";O:39:\"Illuminate\\Database\\Eloquent\\Collection\":2:{s:8:\"\0*\0items\";a:0:{}s:28:\"\0*\0escapeWhenCastingToString\";b:0;}}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:5:{i:0;s:9:\"parent_id\";i:1;s:4:\"name\";i:2;s:4:\"slug\";i:3;s:5:\"image\";i:4;s:6:\"status\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}i:14;O:19:\"App\\Models\\Category\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:10:\"categories\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:11:{s:2:\"id\";i:53;s:9:\"parent_id\";N;s:4:\"name\";s:10:\"Television\";s:4:\"slug\";s:10:\"television\";s:5:\"image\";N;s:6:\"status\";i:1;s:4:\"icon\";N;s:9:\"is_active\";i:1;s:10:\"sort_order\";i:0;s:10:\"created_at\";s:19:\"2026-11-01 12:52:49\";s:10:\"updated_at\";s:19:\"2026-11-01 12:52:49\";}s:11:\"\0*\0original\";a:11:{s:2:\"id\";i:53;s:9:\"parent_id\";N;s:4:\"name\";s:10:\"Television\";s:4:\"slug\";s:10:\"television\";s:5:\"image\";N;s:6:\"status\";i:1;s:4:\"icon\";N;s:9:\"is_active\";i:1;s:10:\"sort_order\";i:0;s:10:\"created_at\";s:19:\"2026-11-01 12:52:49\";s:10:\"updated_at\";s:19:\"2026-11-01 12:52:49\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:1:{s:8:\"children\";O:39:\"Illuminate\\Database\\Eloquent\\Collection\":2:{s:8:\"\0*\0items\";a:3:{i:0;O:19:\"App\\Models\\Category\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:10:\"categories\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:11:{s:2:\"id\";i:68;s:9:\"parent_id\";i:53;s:4:\"name\";s:7:\"QLED TV\";s:4:\"slug\";s:7:\"tv-qled\";s:5:\"image\";N;s:6:\"status\";i:1;s:4:\"icon\";N;s:9:\"is_active\";i:1;s:10:\"sort_order\";i:0;s:10:\"created_at\";s:19:\"2026-11-02 18:04:29\";s:10:\"updated_at\";s:19:\"2026-11-02 18:04:29\";}s:11:\"\0*\0original\";a:11:{s:2:\"id\";i:68;s:9:\"parent_id\";i:53;s:4:\"name\";s:7:\"QLED TV\";s:4:\"slug\";s:7:\"tv-qled\";s:5:\"image\";N;s:6:\"status\";i:1;s:4:\"icon\";N;s:9:\"is_active\";i:1;s:10:\"sort_order\";i:0;s:10:\"created_at\";s:19:\"2026-11-02 18:04:29\";s:10:\"updated_at\";s:19:\"2026-11-02 18:04:29\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:1:{s:8:\"children\";O:39:\"Illuminate\\Database\\Eloquent\\Collection\":2:{s:8:\"\0*\0items\";a:0:{}s:28:\"\0*\0escapeWhenCastingToString\";b:0;}}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:5:{i:0;s:9:\"parent_id\";i:1;s:4:\"name\";i:2;s:4:\"slug\";i:3;s:5:\"image\";i:4;s:6:\"status\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}i:1;O:19:\"App\\Models\\Category\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:10:\"categories\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:11:{s:2:\"id\";i:69;s:9:\"parent_id\";i:53;s:4:\"name\";s:8:\"HQLED TV\";s:4:\"slug\";s:8:\"tv-hqled\";s:5:\"image\";N;s:6:\"status\";i:1;s:4:\"icon\";N;s:9:\"is_active\";i:1;s:10:\"sort_order\";i:0;s:10:\"created_at\";s:19:\"2026-11-02 18:04:29\";s:10:\"updated_at\";s:19:\"2026-11-02 18:04:29\";}s:11:\"\0*\0original\";a:11:{s:2:\"id\";i:69;s:9:\"parent_id\";i:53;s:4:\"name\";s:8:\"HQLED TV\";s:4:\"slug\";s:8:\"tv-hqled\";s:5:\"image\";N;s:6:\"status\";i:1;s:4:\"icon\";N;s:9:\"is_active\";i:1;s:10:\"sort_order\";i:0;s:10:\"created_at\";s:19:\"2026-11-02 18:04:29\";s:10:\"updated_at\";s:19:\"2026-11-02 18:04:29\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:1:{s:8:\"children\";O:39:\"Illuminate\\Database\\Eloquent\\Collection\":2:{s:8:\"\0*\0items\";a:0:{}s:28:\"\0*\0escapeWhenCastingToString\";b:0;}}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:5:{i:0;s:9:\"parent_id\";i:1;s:4:\"name\";i:2;s:4:\"slug\";i:3;s:5:\"image\";i:4;s:6:\"status\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}i:2;O:19:\"App\\Models\\Category\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:10:\"categories\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:11:{s:2:\"id\";i:70;s:9:\"parent_id\";i:53;s:4:\"name\";s:10:\"MiniLED TV\";s:4:\"slug\";s:10:\"tv-miniled\";s:5:\"image\";N;s:6:\"status\";i:1;s:4:\"icon\";N;s:9:\"is_active\";i:1;s:10:\"sort_order\";i:0;s:10:\"created_at\";s:19:\"2026-11-02 18:04:29\";s:10:\"updated_at\";s:19:\"2026-11-02 18:04:29\";}s:11:\"\0*\0original\";a:11:{s:2:\"id\";i:70;s:9:\"parent_id\";i:53;s:4:\"name\";s:10:\"MiniLED TV\";s:4:\"slug\";s:10:\"tv-miniled\";s:5:\"image\";N;s:6:\"status\";i:1;s:4:\"icon\";N;s:9:\"is_active\";i:1;s:10:\"sort_order\";i:0;s:10:\"created_at\";s:19:\"2026-11-02 18:04:29\";s:10:\"updated_at\";s:19:\"2026-11-02 18:04:29\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:1:{s:8:\"children\";O:39:\"Illuminate\\Database\\Eloquent\\Collection\":2:{s:8:\"\0*\0items\";a:0:{}s:28:\"\0*\0escapeWhenCastingToString\";b:0;}}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:5:{i:0;s:9:\"parent_id\";i:1;s:4:\"name\";i:2;s:4:\"slug\";i:3;s:5:\"image\";i:4;s:6:\"status\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}}s:28:\"\0*\0escapeWhenCastingToString\";b:0;}}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:5:{i:0;s:9:\"parent_id\";i:1;s:4:\"name\";i:2;s:4:\"slug\";i:3;s:5:\"image\";i:4;s:6:\"status\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}i:15;O:19:\"App\\Models\\Category\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:10:\"categories\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:11:{s:2:\"id\";i:58;s:9:\"parent_id\";N;s:4:\"name\";s:15:\"Washing Machine\";s:4:\"slug\";s:15:\"washing-machine\";s:5:\"image\";N;s:6:\"status\";i:1;s:4:\"icon\";N;s:9:\"is_active\";i:1;s:10:\"sort_order\";i:0;s:10:\"created_at\";s:19:\"2026-11-02 18:04:29\";s:10:\"updated_at\";s:19:\"2026-11-02 18:04:29\";}s:11:\"\0*\0original\";a:11:{s:2:\"id\";i:58;s:9:\"parent_id\";N;s:4:\"name\";s:15:\"Washing Machine\";s:4:\"slug\";s:15:\"washing-machine\";s:5:\"image\";N;s:6:\"status\";i:1;s:4:\"icon\";N;s:9:\"is_active\";i:1;s:10:\"sort_order\";i:0;s:10:\"created_at\";s:19:\"2026-11-02 18:04:29\";s:10:\"updated_at\";s:19:\"2026-11-02 18:04:29\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:1:{s:8:\"children\";O:39:\"Illuminate\\Database\\Eloquent\\Collection\":2:{s:8:\"\0*\0items\";a:3:{i:0;O:19:\"App\\Models\\Category\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:10:\"categories\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:11:{s:2:\"id\";i:74;s:9:\"parent_id\";i:58;s:4:\"name\";s:10:\"Front Load\";s:4:\"slug\";s:13:\"wm-front-load\";s:5:\"image\";N;s:6:\"status\";i:1;s:4:\"icon\";N;s:9:\"is_active\";i:1;s:10:\"sort_order\";i:0;s:10:\"created_at\";s:19:\"2026-11-02 18:04:29\";s:10:\"updated_at\";s:19:\"2026-11-02 18:04:29\";}s:11:\"\0*\0original\";a:11:{s:2:\"id\";i:74;s:9:\"parent_id\";i:58;s:4:\"name\";s:10:\"Front Load\";s:4:\"slug\";s:13:\"wm-front-load\";s:5:\"image\";N;s:6:\"status\";i:1;s:4:\"icon\";N;s:9:\"is_active\";i:1;s:10:\"sort_order\";i:0;s:10:\"created_at\";s:19:\"2026-11-02 18:04:29\";s:10:\"updated_at\";s:19:\"2026-11-02 18:04:29\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:1:{s:8:\"children\";O:39:\"Illuminate\\Database\\Eloquent\\Collection\":2:{s:8:\"\0*\0items\";a:0:{}s:28:\"\0*\0escapeWhenCastingToString\";b:0;}}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:5:{i:0;s:9:\"parent_id\";i:1;s:4:\"name\";i:2;s:4:\"slug\";i:3;s:5:\"image\";i:4;s:6:\"status\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}i:1;O:19:\"App\\Models\\Category\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:10:\"categories\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:11:{s:2:\"id\";i:75;s:9:\"parent_id\";i:58;s:4:\"name\";s:8:\"Top Load\";s:4:\"slug\";s:11:\"wm-top-load\";s:5:\"image\";N;s:6:\"status\";i:1;s:4:\"icon\";N;s:9:\"is_active\";i:1;s:10:\"sort_order\";i:0;s:10:\"created_at\";s:19:\"2026-11-02 18:04:29\";s:10:\"updated_at\";s:19:\"2026-11-02 18:04:29\";}s:11:\"\0*\0original\";a:11:{s:2:\"id\";i:75;s:9:\"parent_id\";i:58;s:4:\"name\";s:8:\"Top Load\";s:4:\"slug\";s:11:\"wm-top-load\";s:5:\"image\";N;s:6:\"status\";i:1;s:4:\"icon\";N;s:9:\"is_active\";i:1;s:10:\"sort_order\";i:0;s:10:\"created_at\";s:19:\"2026-11-02 18:04:29\";s:10:\"updated_at\";s:19:\"2026-11-02 18:04:29\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:1:{s:8:\"children\";O:39:\"Illuminate\\Database\\Eloquent\\Collection\":2:{s:8:\"\0*\0items\";a:0:{}s:28:\"\0*\0escapeWhenCastingToString\";b:0;}}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:5:{i:0;s:9:\"parent_id\";i:1;s:4:\"name\";i:2;s:4:\"slug\";i:3;s:5:\"image\";i:4;s:6:\"status\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}i:2;O:19:\"App\\Models\\Category\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:10:\"categories\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:11:{s:2:\"id\";i:76;s:9:\"parent_id\";i:58;s:4:\"name\";s:12:\"Washer Dryer\";s:4:\"slug\";s:15:\"wm-washer-dryer\";s:5:\"image\";N;s:6:\"status\";i:1;s:4:\"icon\";N;s:9:\"is_active\";i:1;s:10:\"sort_order\";i:0;s:10:\"created_at\";s:19:\"2026-11-02 18:04:29\";s:10:\"updated_at\";s:19:\"2026-11-02 18:04:29\";}s:11:\"\0*\0original\";a:11:{s:2:\"id\";i:76;s:9:\"parent_id\";i:58;s:4:\"name\";s:12:\"Washer Dryer\";s:4:\"slug\";s:15:\"wm-washer-dryer\";s:5:\"image\";N;s:6:\"status\";i:1;s:4:\"icon\";N;s:9:\"is_active\";i:1;s:10:\"sort_order\";i:0;s:10:\"created_at\";s:19:\"2026-11-02 18:04:29\";s:10:\"updated_at\";s:19:\"2026-11-02 18:04:29\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:1:{s:8:\"children\";O:39:\"Illuminate\\Database\\Eloquent\\Collection\":2:{s:8:\"\0*\0items\";a:0:{}s:28:\"\0*\0escapeWhenCastingToString\";b:0;}}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:5:{i:0;s:9:\"parent_id\";i:1;s:4:\"name\";i:2;s:4:\"slug\";i:3;s:5:\"image\";i:4;s:6:\"status\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}}s:28:\"\0*\0escapeWhenCastingToString\";b:0;}}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:5:{i:0;s:9:\"parent_id\";i:1;s:4:\"name\";i:2;s:4:\"slug\";i:3;s:5:\"image\";i:4;s:6:\"status\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}i:16;O:19:\"App\\Models\\Category\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:10:\"categories\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:11:{s:2:\"id\";i:57;s:9:\"parent_id\";N;s:4:\"name\";s:12:\"Water Heater\";s:4:\"slug\";s:12:\"water-heater\";s:5:\"image\";N;s:6:\"status\";i:1;s:4:\"icon\";N;s:9:\"is_active\";i:1;s:10:\"sort_order\";i:0;s:10:\"created_at\";s:19:\"2026-11-02 18:04:29\";s:10:\"updated_at\";s:19:\"2026-11-02 18:04:29\";}s:11:\"\0*\0original\";a:11:{s:2:\"id\";i:57;s:9:\"parent_id\";N;s:4:\"name\";s:12:\"Water Heater\";s:4:\"slug\";s:12:\"water-heater\";s:5:\"image\";N;s:6:\"status\";i:1;s:4:\"icon\";N;s:9:\"is_active\";i:1;s:10:\"sort_order\";i:0;s:10:\"created_at\";s:19:\"2026-11-02 18:04:29\";s:10:\"updated_at\";s:19:\"2026-11-02 18:04:29\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:1:{s:8:\"children\";O:39:\"Illuminate\\Database\\Eloquent\\Collection\":2:{s:8:\"\0*\0items\";a:0:{}s:28:\"\0*\0escapeWhenCastingToString\";b:0;}}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:5:{i:0;s:9:\"parent_id\";i:1;s:4:\"name\";i:2;s:4:\"slug\";i:3;s:5:\"image\";i:4;s:6:\"status\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}}s:28:\"\0*\0escapeWhenCastingToString\";b:0;}', 1794308836);
INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('buydorbd-cache-johnkru6@gmail.com|116.206.254.117', 'i:2;', 1794215945),
('buydorbd-cache-johnkru6@gmail.com|116.206.254.117:timer', 'i:1794215945;', 1794215945),
('buydorbd-cache-nav_hot_deals', 'O:39:\"Illuminate\\Database\\Eloquent\\Collection\":2:{s:8:\"\0*\0items\";a:8:{i:0;O:18:\"App\\Models\\Product\":34:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:8:\"products\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:26:{s:2:\"id\";i:256;s:9:\"vendor_id\";N;s:11:\"category_id\";i:52;s:15:\"sub_category_id\";i:60;s:8:\"brand_id\";i:12;s:4:\"name\";s:44:\"Haier HSU-13AntirustCool Inverter AC 1.0 Ton\";s:4:\"slug\";s:24:\"haier-hsu-13antirustcool\";s:3:\"sku\";s:18:\"HSU-13AntirustCool\";s:11:\"description\";s:157:\"<p>Haier 1.0 Ton inverter air conditioner.</p><ul><li>Capacity: 1.0 Ton</li><li>Type: Inverter</li><li>Model: HSU-13AntirustCool(INV)(Pro)(X6)-WiFi</li></ul>\";s:17:\"short_description\";s:79:\"1.0 Ton inverter air conditioner. Model: HSU-13AntirustCool(INV)(Pro)(X6)-WiFi.\";s:5:\"price\";s:8:\"60990.00\";s:14:\"discount_price\";N;s:10:\"cost_price\";s:8:\"45743.00\";s:4:\"tags\";s:26:\"haier, air conditioner, ac\";s:14:\"stock_quantity\";i:0;s:12:\"product_type\";s:6:\"vendor\";s:9:\"thumbnail\";N;s:19:\"sponsored_video_url\";N;s:6:\"status\";s:5:\"draft\";s:6:\"is_new\";i:0;s:11:\"is_featured\";i:0;s:6:\"is_hot\";i:0;s:11:\"views_count\";i:0;s:10:\"created_at\";s:19:\"2026-11-02 18:08:00\";s:10:\"updated_at\";s:19:\"2026-11-02 18:08:00\";s:10:\"deleted_at\";N;}s:11:\"\0*\0original\";a:26:{s:2:\"id\";i:256;s:9:\"vendor_id\";N;s:11:\"category_id\";i:52;s:15:\"sub_category_id\";i:60;s:8:\"brand_id\";i:12;s:4:\"name\";s:44:\"Haier HSU-13AntirustCool Inverter AC 1.0 Ton\";s:4:\"slug\";s:24:\"haier-hsu-13antirustcool\";s:3:\"sku\";s:18:\"HSU-13AntirustCool\";s:11:\"description\";s:157:\"<p>Haier 1.0 Ton inverter air conditioner.</p><ul><li>Capacity: 1.0 Ton</li><li>Type: Inverter</li><li>Model: HSU-13AntirustCool(INV)(Pro)(X6)-WiFi</li></ul>\";s:17:\"short_description\";s:79:\"1.0 Ton inverter air conditioner. Model: HSU-13AntirustCool(INV)(Pro)(X6)-WiFi.\";s:5:\"price\";s:8:\"60990.00\";s:14:\"discount_price\";N;s:10:\"cost_price\";s:8:\"45743.00\";s:4:\"tags\";s:26:\"haier, air conditioner, ac\";s:14:\"stock_quantity\";i:0;s:12:\"product_type\";s:6:\"vendor\";s:9:\"thumbnail\";N;s:19:\"sponsored_video_url\";N;s:6:\"status\";s:5:\"draft\";s:6:\"is_new\";i:0;s:11:\"is_featured\";i:0;s:6:\"is_hot\";i:0;s:11:\"views_count\";i:0;s:10:\"created_at\";s:19:\"2026-11-02 18:08:00\";s:10:\"updated_at\";s:19:\"2026-11-02 18:08:00\";s:10:\"deleted_at\";N;}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:7:{s:5:\"price\";s:9:\"decimal:2\";s:14:\"discount_price\";s:9:\"decimal:2\";s:10:\"cost_price\";s:9:\"decimal:2\";s:6:\"is_new\";s:7:\"boolean\";s:11:\"is_featured\";s:7:\"boolean\";s:6:\"is_hot\";s:7:\"boolean\";s:10:\"deleted_at\";s:8:\"datetime\";}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:20:{i:0;s:9:\"vendor_id\";i:1;s:11:\"category_id\";i:2;s:15:\"sub_category_id\";i:3;s:8:\"brand_id\";i:4;s:4:\"name\";i:5;s:4:\"slug\";i:6;s:3:\"sku\";i:7;s:17:\"short_description\";i:8;s:11:\"description\";i:9;s:5:\"price\";i:10;s:14:\"discount_price\";i:11;s:10:\"cost_price\";i:12;s:4:\"tags\";i:13;s:12:\"product_type\";i:14;s:9:\"thumbnail\";i:15;s:19:\"sponsored_video_url\";i:16;s:6:\"status\";i:17;s:6:\"is_new\";i:18;s:11:\"is_featured\";i:19;s:6:\"is_hot\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}s:16:\"\0*\0forceDeleting\";b:0;}i:1;O:18:\"App\\Models\\Product\":34:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:8:\"products\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:26:{s:2:\"id\";i:257;s:9:\"vendor_id\";N;s:11:\"category_id\";i:52;s:15:\"sub_category_id\";i:60;s:8:\"brand_id\";i:12;s:4:\"name\";s:41:\"Haier HSU-13CleanCool Inverter AC 1.0 Ton\";s:4:\"slug\";s:21:\"haier-hsu-13cleancool\";s:3:\"sku\";s:15:\"HSU-13CleanCool\";s:11:\"description\";s:149:\"<p>Haier 1.0 Ton inverter air conditioner.</p><ul><li>Capacity: 1.0 Ton</li><li>Type: Inverter</li><li>Model: HSU-13CleanCool(INV)(Pro)(X6)</li></ul>\";s:17:\"short_description\";s:71:\"1.0 Ton inverter air conditioner. Model: HSU-13CleanCool(INV)(Pro)(X6).\";s:5:\"price\";s:8:\"58990.00\";s:14:\"discount_price\";N;s:10:\"cost_price\";s:8:\"44243.00\";s:4:\"tags\";s:26:\"haier, air conditioner, ac\";s:14:\"stock_quantity\";i:0;s:12:\"product_type\";s:6:\"vendor\";s:9:\"thumbnail\";N;s:19:\"sponsored_video_url\";N;s:6:\"status\";s:5:\"draft\";s:6:\"is_new\";i:0;s:11:\"is_featured\";i:0;s:6:\"is_hot\";i:0;s:11:\"views_count\";i:0;s:10:\"created_at\";s:19:\"2026-11-02 18:08:00\";s:10:\"updated_at\";s:19:\"2026-11-02 18:08:00\";s:10:\"deleted_at\";N;}s:11:\"\0*\0original\";a:26:{s:2:\"id\";i:257;s:9:\"vendor_id\";N;s:11:\"category_id\";i:52;s:15:\"sub_category_id\";i:60;s:8:\"brand_id\";i:12;s:4:\"name\";s:41:\"Haier HSU-13CleanCool Inverter AC 1.0 Ton\";s:4:\"slug\";s:21:\"haier-hsu-13cleancool\";s:3:\"sku\";s:15:\"HSU-13CleanCool\";s:11:\"description\";s:149:\"<p>Haier 1.0 Ton inverter air conditioner.</p><ul><li>Capacity: 1.0 Ton</li><li>Type: Inverter</li><li>Model: HSU-13CleanCool(INV)(Pro)(X6)</li></ul>\";s:17:\"short_description\";s:71:\"1.0 Ton inverter air conditioner. Model: HSU-13CleanCool(INV)(Pro)(X6).\";s:5:\"price\";s:8:\"58990.00\";s:14:\"discount_price\";N;s:10:\"cost_price\";s:8:\"44243.00\";s:4:\"tags\";s:26:\"haier, air conditioner, ac\";s:14:\"stock_quantity\";i:0;s:12:\"product_type\";s:6:\"vendor\";s:9:\"thumbnail\";N;s:19:\"sponsored_video_url\";N;s:6:\"status\";s:5:\"draft\";s:6:\"is_new\";i:0;s:11:\"is_featured\";i:0;s:6:\"is_hot\";i:0;s:11:\"views_count\";i:0;s:10:\"created_at\";s:19:\"2026-11-02 18:08:00\";s:10:\"updated_at\";s:19:\"2026-11-02 18:08:00\";s:10:\"deleted_at\";N;}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:7:{s:5:\"price\";s:9:\"decimal:2\";s:14:\"discount_price\";s:9:\"decimal:2\";s:10:\"cost_price\";s:9:\"decimal:2\";s:6:\"is_new\";s:7:\"boolean\";s:11:\"is_featured\";s:7:\"boolean\";s:6:\"is_hot\";s:7:\"boolean\";s:10:\"deleted_at\";s:8:\"datetime\";}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:20:{i:0;s:9:\"vendor_id\";i:1;s:11:\"category_id\";i:2;s:15:\"sub_category_id\";i:3;s:8:\"brand_id\";i:4;s:4:\"name\";i:5;s:4:\"slug\";i:6;s:3:\"sku\";i:7;s:17:\"short_description\";i:8;s:11:\"description\";i:9;s:5:\"price\";i:10;s:14:\"discount_price\";i:11;s:10:\"cost_price\";i:12;s:4:\"tags\";i:13;s:12:\"product_type\";i:14;s:9:\"thumbnail\";i:15;s:19:\"sponsored_video_url\";i:16;s:6:\"status\";i:17;s:6:\"is_new\";i:18;s:11:\"is_featured\";i:19;s:6:\"is_hot\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}s:16:\"\0*\0forceDeleting\";b:0;}i:2;O:18:\"App\\Models\\Product\":34:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:8:\"products\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:26:{s:2:\"id\";i:258;s:9:\"vendor_id\";N;s:11:\"category_id\";i:52;s:15:\"sub_category_id\";i:61;s:8:\"brand_id\";i:12;s:4:\"name\";s:45:\"Haier HSU-24TurboAqua Non-Inverter AC 2.0 Ton\";s:4:\"slug\";s:21:\"haier-hsu-24turboaqua\";s:3:\"sku\";s:15:\"HSU-24TurboAqua\";s:11:\"description\";s:157:\"<p>Haier 2.0 Ton non-inverter air conditioner.</p><ul><li>Capacity: 2.0 Ton</li><li>Type: Non-Inverter</li><li>Model: HSU-24TurboAqua(FIX)(Pro)(X6)</li></ul>\";s:17:\"short_description\";s:75:\"2.0 Ton non-inverter air conditioner. Model: HSU-24TurboAqua(FIX)(Pro)(X6).\";s:5:\"price\";s:8:\"78990.00\";s:14:\"discount_price\";N;s:10:\"cost_price\";s:8:\"59243.00\";s:4:\"tags\";s:26:\"haier, air conditioner, ac\";s:14:\"stock_quantity\";i:0;s:12:\"product_type\";s:6:\"vendor\";s:9:\"thumbnail\";N;s:19:\"sponsored_video_url\";N;s:6:\"status\";s:5:\"draft\";s:6:\"is_new\";i:0;s:11:\"is_featured\";i:0;s:6:\"is_hot\";i:0;s:11:\"views_count\";i:0;s:10:\"created_at\";s:19:\"2026-11-02 18:08:00\";s:10:\"updated_at\";s:19:\"2026-11-02 18:08:00\";s:10:\"deleted_at\";N;}s:11:\"\0*\0original\";a:26:{s:2:\"id\";i:258;s:9:\"vendor_id\";N;s:11:\"category_id\";i:52;s:15:\"sub_category_id\";i:61;s:8:\"brand_id\";i:12;s:4:\"name\";s:45:\"Haier HSU-24TurboAqua Non-Inverter AC 2.0 Ton\";s:4:\"slug\";s:21:\"haier-hsu-24turboaqua\";s:3:\"sku\";s:15:\"HSU-24TurboAqua\";s:11:\"description\";s:157:\"<p>Haier 2.0 Ton non-inverter air conditioner.</p><ul><li>Capacity: 2.0 Ton</li><li>Type: Non-Inverter</li><li>Model: HSU-24TurboAqua(FIX)(Pro)(X6)</li></ul>\";s:17:\"short_description\";s:75:\"2.0 Ton non-inverter air conditioner. Model: HSU-24TurboAqua(FIX)(Pro)(X6).\";s:5:\"price\";s:8:\"78990.00\";s:14:\"discount_price\";N;s:10:\"cost_price\";s:8:\"59243.00\";s:4:\"tags\";s:26:\"haier, air conditioner, ac\";s:14:\"stock_quantity\";i:0;s:12:\"product_type\";s:6:\"vendor\";s:9:\"thumbnail\";N;s:19:\"sponsored_video_url\";N;s:6:\"status\";s:5:\"draft\";s:6:\"is_new\";i:0;s:11:\"is_featured\";i:0;s:6:\"is_hot\";i:0;s:11:\"views_count\";i:0;s:10:\"created_at\";s:19:\"2026-11-02 18:08:00\";s:10:\"updated_at\";s:19:\"2026-11-02 18:08:00\";s:10:\"deleted_at\";N;}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:7:{s:5:\"price\";s:9:\"decimal:2\";s:14:\"discount_price\";s:9:\"decimal:2\";s:10:\"cost_price\";s:9:\"decimal:2\";s:6:\"is_new\";s:7:\"boolean\";s:11:\"is_featured\";s:7:\"boolean\";s:6:\"is_hot\";s:7:\"boolean\";s:10:\"deleted_at\";s:8:\"datetime\";}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:20:{i:0;s:9:\"vendor_id\";i:1;s:11:\"category_id\";i:2;s:15:\"sub_category_id\";i:3;s:8:\"brand_id\";i:4;s:4:\"name\";i:5;s:4:\"slug\";i:6;s:3:\"sku\";i:7;s:17:\"short_description\";i:8;s:11:\"description\";i:9;s:5:\"price\";i:10;s:14:\"discount_price\";i:11;s:10:\"cost_price\";i:12;s:4:\"tags\";i:13;s:12:\"product_type\";i:14;s:9:\"thumbnail\";i:15;s:19:\"sponsored_video_url\";i:16;s:6:\"status\";i:17;s:6:\"is_new\";i:18;s:11:\"is_featured\";i:19;s:6:\"is_hot\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}s:16:\"\0*\0forceDeleting\";b:0;}i:3;O:18:\"App\\Models\\Product\":34:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:8:\"products\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:26:{s:2:\"id\";i:259;s:9:\"vendor_id\";N;s:11:\"category_id\";i:52;s:15:\"sub_category_id\";i:61;s:8:\"brand_id\";i:12;s:4:\"name\";s:45:\"Haier HSU-18TurboAqua Non-Inverter AC 1.5 Ton\";s:4:\"slug\";s:21:\"haier-hsu-18turboaqua\";s:3:\"sku\";s:15:\"HSU-18TurboAqua\";s:11:\"description\";s:157:\"<p>Haier 1.5 Ton non-inverter air conditioner.</p><ul><li>Capacity: 1.5 Ton</li><li>Type: Non-Inverter</li><li>Model: HSU-18TurboAqua(FIX)(Pro)(X6)</li></ul>\";s:17:\"short_description\";s:75:\"1.5 Ton non-inverter air conditioner. Model: HSU-18TurboAqua(FIX)(Pro)(X6).\";s:5:\"price\";s:8:\"63990.00\";s:14:\"discount_price\";N;s:10:\"cost_price\";s:8:\"47993.00\";s:4:\"tags\";s:26:\"haier, air conditioner, ac\";s:14:\"stock_quantity\";i:0;s:12:\"product_type\";s:6:\"vendor\";s:9:\"thumbnail\";N;s:19:\"sponsored_video_url\";N;s:6:\"status\";s:5:\"draft\";s:6:\"is_new\";i:0;s:11:\"is_featured\";i:0;s:6:\"is_hot\";i:0;s:11:\"views_count\";i:0;s:10:\"created_at\";s:19:\"2026-11-02 18:08:00\";s:10:\"updated_at\";s:19:\"2026-11-02 18:08:00\";s:10:\"deleted_at\";N;}s:11:\"\0*\0original\";a:26:{s:2:\"id\";i:259;s:9:\"vendor_id\";N;s:11:\"category_id\";i:52;s:15:\"sub_category_id\";i:61;s:8:\"brand_id\";i:12;s:4:\"name\";s:45:\"Haier HSU-18TurboAqua Non-Inverter AC 1.5 Ton\";s:4:\"slug\";s:21:\"haier-hsu-18turboaqua\";s:3:\"sku\";s:15:\"HSU-18TurboAqua\";s:11:\"description\";s:157:\"<p>Haier 1.5 Ton non-inverter air conditioner.</p><ul><li>Capacity: 1.5 Ton</li><li>Type: Non-Inverter</li><li>Model: HSU-18TurboAqua(FIX)(Pro)(X6)</li></ul>\";s:17:\"short_description\";s:75:\"1.5 Ton non-inverter air conditioner. Model: HSU-18TurboAqua(FIX)(Pro)(X6).\";s:5:\"price\";s:8:\"63990.00\";s:14:\"discount_price\";N;s:10:\"cost_price\";s:8:\"47993.00\";s:4:\"tags\";s:26:\"haier, air conditioner, ac\";s:14:\"stock_quantity\";i:0;s:12:\"product_type\";s:6:\"vendor\";s:9:\"thumbnail\";N;s:19:\"sponsored_video_url\";N;s:6:\"status\";s:5:\"draft\";s:6:\"is_new\";i:0;s:11:\"is_featured\";i:0;s:6:\"is_hot\";i:0;s:11:\"views_count\";i:0;s:10:\"created_at\";s:19:\"2026-11-02 18:08:00\";s:10:\"updated_at\";s:19:\"2026-11-02 18:08:00\";s:10:\"deleted_at\";N;}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:7:{s:5:\"price\";s:9:\"decimal:2\";s:14:\"discount_price\";s:9:\"decimal:2\";s:10:\"cost_price\";s:9:\"decimal:2\";s:6:\"is_new\";s:7:\"boolean\";s:11:\"is_featured\";s:7:\"boolean\";s:6:\"is_hot\";s:7:\"boolean\";s:10:\"deleted_at\";s:8:\"datetime\";}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:20:{i:0;s:9:\"vendor_id\";i:1;s:11:\"category_id\";i:2;s:15:\"sub_category_id\";i:3;s:8:\"brand_id\";i:4;s:4:\"name\";i:5;s:4:\"slug\";i:6;s:3:\"sku\";i:7;s:17:\"short_description\";i:8;s:11:\"description\";i:9;s:5:\"price\";i:10;s:14:\"discount_price\";i:11;s:10:\"cost_price\";i:12;s:4:\"tags\";i:13;s:12:\"product_type\";i:14;s:9:\"thumbnail\";i:15;s:19:\"sponsored_video_url\";i:16;s:6:\"status\";i:17;s:6:\"is_new\";i:18;s:11:\"is_featured\";i:19;s:6:\"is_hot\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}s:16:\"\0*\0forceDeleting\";b:0;}i:4;O:18:\"App\\Models\\Product\":34:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:8:\"products\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:26:{s:2:\"id\";i:260;s:9:\"vendor_id\";N;s:11:\"category_id\";i:52;s:15:\"sub_category_id\";i:61;s:8:\"brand_id\";i:12;s:4:\"name\";s:45:\"Haier HSU-12TurboAqua Non-Inverter AC 1.0 Ton\";s:4:\"slug\";s:21:\"haier-hsu-12turboaqua\";s:3:\"sku\";s:15:\"HSU-12TurboAqua\";s:11:\"description\";s:157:\"<p>Haier 1.0 Ton non-inverter air conditioner.</p><ul><li>Capacity: 1.0 Ton</li><li>Type: Non-Inverter</li><li>Model: HSU-12TurboAqua(FIX)(Pro)(X6)</li></ul>\";s:17:\"short_description\";s:75:\"1.0 Ton non-inverter air conditioner. Model: HSU-12TurboAqua(FIX)(Pro)(X6).\";s:5:\"price\";s:8:\"50990.00\";s:14:\"discount_price\";N;s:10:\"cost_price\";s:8:\"38243.00\";s:4:\"tags\";s:26:\"haier, air conditioner, ac\";s:14:\"stock_quantity\";i:0;s:12:\"product_type\";s:6:\"vendor\";s:9:\"thumbnail\";N;s:19:\"sponsored_video_url\";N;s:6:\"status\";s:5:\"draft\";s:6:\"is_new\";i:0;s:11:\"is_featured\";i:0;s:6:\"is_hot\";i:0;s:11:\"views_count\";i:0;s:10:\"created_at\";s:19:\"2026-11-02 18:08:00\";s:10:\"updated_at\";s:19:\"2026-11-02 18:08:00\";s:10:\"deleted_at\";N;}s:11:\"\0*\0original\";a:26:{s:2:\"id\";i:260;s:9:\"vendor_id\";N;s:11:\"category_id\";i:52;s:15:\"sub_category_id\";i:61;s:8:\"brand_id\";i:12;s:4:\"name\";s:45:\"Haier HSU-12TurboAqua Non-Inverter AC 1.0 Ton\";s:4:\"slug\";s:21:\"haier-hsu-12turboaqua\";s:3:\"sku\";s:15:\"HSU-12TurboAqua\";s:11:\"description\";s:157:\"<p>Haier 1.0 Ton non-inverter air conditioner.</p><ul><li>Capacity: 1.0 Ton</li><li>Type: Non-Inverter</li><li>Model: HSU-12TurboAqua(FIX)(Pro)(X6)</li></ul>\";s:17:\"short_description\";s:75:\"1.0 Ton non-inverter air conditioner. Model: HSU-12TurboAqua(FIX)(Pro)(X6).\";s:5:\"price\";s:8:\"50990.00\";s:14:\"discount_price\";N;s:10:\"cost_price\";s:8:\"38243.00\";s:4:\"tags\";s:26:\"haier, air conditioner, ac\";s:14:\"stock_quantity\";i:0;s:12:\"product_type\";s:6:\"vendor\";s:9:\"thumbnail\";N;s:19:\"sponsored_video_url\";N;s:6:\"status\";s:5:\"draft\";s:6:\"is_new\";i:0;s:11:\"is_featured\";i:0;s:6:\"is_hot\";i:0;s:11:\"views_count\";i:0;s:10:\"created_at\";s:19:\"2026-11-02 18:08:00\";s:10:\"updated_at\";s:19:\"2026-11-02 18:08:00\";s:10:\"deleted_at\";N;}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:7:{s:5:\"price\";s:9:\"decimal:2\";s:14:\"discount_price\";s:9:\"decimal:2\";s:10:\"cost_price\";s:9:\"decimal:2\";s:6:\"is_new\";s:7:\"boolean\";s:11:\"is_featured\";s:7:\"boolean\";s:6:\"is_hot\";s:7:\"boolean\";s:10:\"deleted_at\";s:8:\"datetime\";}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:20:{i:0;s:9:\"vendor_id\";i:1;s:11:\"category_id\";i:2;s:15:\"sub_category_id\";i:3;s:8:\"brand_id\";i:4;s:4:\"name\";i:5;s:4:\"slug\";i:6;s:3:\"sku\";i:7;s:17:\"short_description\";i:8;s:11:\"description\";i:9;s:5:\"price\";i:10;s:14:\"discount_price\";i:11;s:10:\"cost_price\";i:12;s:4:\"tags\";i:13;s:12:\"product_type\";i:14;s:9:\"thumbnail\";i:15;s:19:\"sponsored_video_url\";i:16;s:6:\"status\";i:17;s:6:\"is_new\";i:18;s:11:\"is_featured\";i:19;s:6:\"is_hot\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}s:16:\"\0*\0forceDeleting\";b:0;}i:5;O:18:\"App\\Models\\Product\":34:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:8:\"products\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:26:{s:2:\"id\";i:226;s:9:\"vendor_id\";N;s:11:\"category_id\";i:58;s:15:\"sub_category_id\";i:74;s:8:\"brand_id\";i:12;s:4:\"name\";s:45:\"Haier HW140-BD14697WU1 3 Drum Washing Machine\";s:4:\"slug\";s:22:\"haier-hw140-bd14697wu1\";s:3:\"sku\";s:16:\"HW140-BD14697WU1\";s:11:\"description\";s:114:\"<p>Haier 3 Drum Washing Machine.</p><ul><li>Model: HW140-BD14697WU1</li><li>Type: 3 Drum Washing Machine</li></ul>\";s:17:\"short_description\";s:48:\"3 Drum Washing Machine. Model: HW140-BD14697WU1.\";s:5:\"price\";s:9:\"179900.00\";s:14:\"discount_price\";s:9:\"170905.00\";s:10:\"cost_price\";s:9:\"145719.00\";s:4:\"tags\";s:31:\"haier, washing machine, laundry\";s:14:\"stock_quantity\";i:0;s:12:\"product_type\";s:6:\"vendor\";s:9:\"thumbnail\";N;s:19:\"sponsored_video_url\";N;s:6:\"status\";s:5:\"draft\";s:6:\"is_new\";i:0;s:11:\"is_featured\";i:0;s:6:\"is_hot\";i:0;s:11:\"views_count\";i:0;s:10:\"created_at\";s:19:\"2026-11-02 18:08:00\";s:10:\"updated_at\";s:19:\"2026-11-02 18:08:00\";s:10:\"deleted_at\";N;}s:11:\"\0*\0original\";a:26:{s:2:\"id\";i:226;s:9:\"vendor_id\";N;s:11:\"category_id\";i:58;s:15:\"sub_category_id\";i:74;s:8:\"brand_id\";i:12;s:4:\"name\";s:45:\"Haier HW140-BD14697WU1 3 Drum Washing Machine\";s:4:\"slug\";s:22:\"haier-hw140-bd14697wu1\";s:3:\"sku\";s:16:\"HW140-BD14697WU1\";s:11:\"description\";s:114:\"<p>Haier 3 Drum Washing Machine.</p><ul><li>Model: HW140-BD14697WU1</li><li>Type: 3 Drum Washing Machine</li></ul>\";s:17:\"short_description\";s:48:\"3 Drum Washing Machine. Model: HW140-BD14697WU1.\";s:5:\"price\";s:9:\"179900.00\";s:14:\"discount_price\";s:9:\"170905.00\";s:10:\"cost_price\";s:9:\"145719.00\";s:4:\"tags\";s:31:\"haier, washing machine, laundry\";s:14:\"stock_quantity\";i:0;s:12:\"product_type\";s:6:\"vendor\";s:9:\"thumbnail\";N;s:19:\"sponsored_video_url\";N;s:6:\"status\";s:5:\"draft\";s:6:\"is_new\";i:0;s:11:\"is_featured\";i:0;s:6:\"is_hot\";i:0;s:11:\"views_count\";i:0;s:10:\"created_at\";s:19:\"2026-11-02 18:08:00\";s:10:\"updated_at\";s:19:\"2026-11-02 18:08:00\";s:10:\"deleted_at\";N;}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:7:{s:5:\"price\";s:9:\"decimal:2\";s:14:\"discount_price\";s:9:\"decimal:2\";s:10:\"cost_price\";s:9:\"decimal:2\";s:6:\"is_new\";s:7:\"boolean\";s:11:\"is_featured\";s:7:\"boolean\";s:6:\"is_hot\";s:7:\"boolean\";s:10:\"deleted_at\";s:8:\"datetime\";}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:20:{i:0;s:9:\"vendor_id\";i:1;s:11:\"category_id\";i:2;s:15:\"sub_category_id\";i:3;s:8:\"brand_id\";i:4;s:4:\"name\";i:5;s:4:\"slug\";i:6;s:3:\"sku\";i:7;s:17:\"short_description\";i:8;s:11:\"description\";i:9;s:5:\"price\";i:10;s:14:\"discount_price\";i:11;s:10:\"cost_price\";i:12;s:4:\"tags\";i:13;s:12:\"product_type\";i:14;s:9:\"thumbnail\";i:15;s:19:\"sponsored_video_url\";i:16;s:6:\"status\";i:17;s:6:\"is_new\";i:18;s:11:\"is_featured\";i:19;s:6:\"is_hot\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}s:16:\"\0*\0forceDeleting\";b:0;}i:6;O:18:\"App\\Models\\Product\":34:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:8:\"products\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:26:{s:2:\"id\";i:227;s:9:\"vendor_id\";N;s:11:\"category_id\";i:58;s:15:\"sub_category_id\";i:76;s:8:\"brand_id\";i:12;s:4:\"name\";s:38:\"Haier HWD140-BPD14387GNU1 Washer Dryer\";s:4:\"slug\";s:25:\"haier-hwd140-bpd14387gnu1\";s:3:\"sku\";s:19:\"HWD140-BPD14387GNU1\";s:11:\"description\";s:97:\"<p>Haier Washer Dryer.</p><ul><li>Model: HWD140-BPD14387GNU1</li><li>Type: Washer Dryer</li></ul>\";s:17:\"short_description\";s:41:\"Washer Dryer. Model: HWD140-BPD14387GNU1.\";s:5:\"price\";s:9:\"128900.00\";s:14:\"discount_price\";s:9:\"122455.00\";s:10:\"cost_price\";s:9:\"104409.00\";s:4:\"tags\";s:31:\"haier, washing machine, laundry\";s:14:\"stock_quantity\";i:0;s:12:\"product_type\";s:6:\"vendor\";s:9:\"thumbnail\";N;s:19:\"sponsored_video_url\";N;s:6:\"status\";s:5:\"draft\";s:6:\"is_new\";i:0;s:11:\"is_featured\";i:0;s:6:\"is_hot\";i:0;s:11:\"views_count\";i:0;s:10:\"created_at\";s:19:\"2026-11-02 18:08:00\";s:10:\"updated_at\";s:19:\"2026-11-02 18:08:00\";s:10:\"deleted_at\";N;}s:11:\"\0*\0original\";a:26:{s:2:\"id\";i:227;s:9:\"vendor_id\";N;s:11:\"category_id\";i:58;s:15:\"sub_category_id\";i:76;s:8:\"brand_id\";i:12;s:4:\"name\";s:38:\"Haier HWD140-BPD14387GNU1 Washer Dryer\";s:4:\"slug\";s:25:\"haier-hwd140-bpd14387gnu1\";s:3:\"sku\";s:19:\"HWD140-BPD14387GNU1\";s:11:\"description\";s:97:\"<p>Haier Washer Dryer.</p><ul><li>Model: HWD140-BPD14387GNU1</li><li>Type: Washer Dryer</li></ul>\";s:17:\"short_description\";s:41:\"Washer Dryer. Model: HWD140-BPD14387GNU1.\";s:5:\"price\";s:9:\"128900.00\";s:14:\"discount_price\";s:9:\"122455.00\";s:10:\"cost_price\";s:9:\"104409.00\";s:4:\"tags\";s:31:\"haier, washing machine, laundry\";s:14:\"stock_quantity\";i:0;s:12:\"product_type\";s:6:\"vendor\";s:9:\"thumbnail\";N;s:19:\"sponsored_video_url\";N;s:6:\"status\";s:5:\"draft\";s:6:\"is_new\";i:0;s:11:\"is_featured\";i:0;s:6:\"is_hot\";i:0;s:11:\"views_count\";i:0;s:10:\"created_at\";s:19:\"2026-11-02 18:08:00\";s:10:\"updated_at\";s:19:\"2026-11-02 18:08:00\";s:10:\"deleted_at\";N;}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:7:{s:5:\"price\";s:9:\"decimal:2\";s:14:\"discount_price\";s:9:\"decimal:2\";s:10:\"cost_price\";s:9:\"decimal:2\";s:6:\"is_new\";s:7:\"boolean\";s:11:\"is_featured\";s:7:\"boolean\";s:6:\"is_hot\";s:7:\"boolean\";s:10:\"deleted_at\";s:8:\"datetime\";}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:20:{i:0;s:9:\"vendor_id\";i:1;s:11:\"category_id\";i:2;s:15:\"sub_category_id\";i:3;s:8:\"brand_id\";i:4;s:4:\"name\";i:5;s:4:\"slug\";i:6;s:3:\"sku\";i:7;s:17:\"short_description\";i:8;s:11:\"description\";i:9;s:5:\"price\";i:10;s:14:\"discount_price\";i:11;s:10:\"cost_price\";i:12;s:4:\"tags\";i:13;s:12:\"product_type\";i:14;s:9:\"thumbnail\";i:15;s:19:\"sponsored_video_url\";i:16;s:6:\"status\";i:17;s:6:\"is_new\";i:18;s:11:\"is_featured\";i:19;s:6:\"is_hot\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}s:16:\"\0*\0forceDeleting\";b:0;}i:7;O:18:\"App\\Models\\Product\":34:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:8:\"products\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:26:{s:2:\"id\";i:228;s:9:\"vendor_id\";N;s:11:\"category_id\";i:58;s:15:\"sub_category_id\";i:74;s:8:\"brand_id\";i:12;s:4:\"name\";s:48:\"Haier HW120-BP12357S8 Front Load Washing Machine\";s:4:\"slug\";s:21:\"haier-hw120-bp12357s8\";s:3:\"sku\";s:15:\"HW120-BP12357S8\";s:11:\"description\";s:121:\"<p>Haier Front Load Washing Machine.</p><ul><li>Model: HW120-BP12357S8</li><li>Type: Front Load Washing Machine</li></ul>\";s:17:\"short_description\";s:51:\"Front Load Washing Machine. Model: HW120-BP12357S8.\";s:5:\"price\";s:8:\"81900.00\";s:14:\"discount_price\";s:8:\"77805.00\";s:10:\"cost_price\";s:8:\"66339.00\";s:4:\"tags\";s:31:\"haier, washing machine, laundry\";s:14:\"stock_quantity\";i:0;s:12:\"product_type\";s:6:\"vendor\";s:9:\"thumbnail\";N;s:19:\"sponsored_video_url\";N;s:6:\"status\";s:5:\"draft\";s:6:\"is_new\";i:0;s:11:\"is_featured\";i:0;s:6:\"is_hot\";i:0;s:11:\"views_count\";i:0;s:10:\"created_at\";s:19:\"2026-11-02 18:08:00\";s:10:\"updated_at\";s:19:\"2026-11-02 18:08:00\";s:10:\"deleted_at\";N;}s:11:\"\0*\0original\";a:26:{s:2:\"id\";i:228;s:9:\"vendor_id\";N;s:11:\"category_id\";i:58;s:15:\"sub_category_id\";i:74;s:8:\"brand_id\";i:12;s:4:\"name\";s:48:\"Haier HW120-BP12357S8 Front Load Washing Machine\";s:4:\"slug\";s:21:\"haier-hw120-bp12357s8\";s:3:\"sku\";s:15:\"HW120-BP12357S8\";s:11:\"description\";s:121:\"<p>Haier Front Load Washing Machine.</p><ul><li>Model: HW120-BP12357S8</li><li>Type: Front Load Washing Machine</li></ul>\";s:17:\"short_description\";s:51:\"Front Load Washing Machine. Model: HW120-BP12357S8.\";s:5:\"price\";s:8:\"81900.00\";s:14:\"discount_price\";s:8:\"77805.00\";s:10:\"cost_price\";s:8:\"66339.00\";s:4:\"tags\";s:31:\"haier, washing machine, laundry\";s:14:\"stock_quantity\";i:0;s:12:\"product_type\";s:6:\"vendor\";s:9:\"thumbnail\";N;s:19:\"sponsored_video_url\";N;s:6:\"status\";s:5:\"draft\";s:6:\"is_new\";i:0;s:11:\"is_featured\";i:0;s:6:\"is_hot\";i:0;s:11:\"views_count\";i:0;s:10:\"created_at\";s:19:\"2026-11-02 18:08:00\";s:10:\"updated_at\";s:19:\"2026-11-02 18:08:00\";s:10:\"deleted_at\";N;}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:7:{s:5:\"price\";s:9:\"decimal:2\";s:14:\"discount_price\";s:9:\"decimal:2\";s:10:\"cost_price\";s:9:\"decimal:2\";s:6:\"is_new\";s:7:\"boolean\";s:11:\"is_featured\";s:7:\"boolean\";s:6:\"is_hot\";s:7:\"boolean\";s:10:\"deleted_at\";s:8:\"datetime\";}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:20:{i:0;s:9:\"vendor_id\";i:1;s:11:\"category_id\";i:2;s:15:\"sub_category_id\";i:3;s:8:\"brand_id\";i:4;s:4:\"name\";i:5;s:4:\"slug\";i:6;s:3:\"sku\";i:7;s:17:\"short_description\";i:8;s:11:\"description\";i:9;s:5:\"price\";i:10;s:14:\"discount_price\";i:11;s:10:\"cost_price\";i:12;s:4:\"tags\";i:13;s:12:\"product_type\";i:14;s:9:\"thumbnail\";i:15;s:19:\"sponsored_video_url\";i:16;s:6:\"status\";i:17;s:6:\"is_new\";i:18;s:11:\"is_featured\";i:19;s:6:\"is_hot\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}s:16:\"\0*\0forceDeleting\";b:0;}}s:28:\"\0*\0escapeWhenCastingToString\";b:0;}', 1794306814),
('buydorbd-cache-route_permissions.hash', 's:32:\"f811cb12f6c07d9bee62bd12308786b5\";', 2109665643),
('buydorbd-cache-sidebar.open_buyer_requests', 'i:2;', 1794306916);
INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('buydorbd-cache-spatie.permission.cache', 'a:3:{s:5:\"alias\";a:5:{s:1:\"a\";s:2:\"id\";s:1:\"b\";s:4:\"name\";s:1:\"c\";s:10:\"guard_name\";s:1:\"f\";s:10:\"group_name\";s:1:\"r\";s:5:\"roles\";}s:11:\"permissions\";a:574:{i:0;a:5:{s:1:\"a\";i:1;s:1:\"b\";s:31:\"superadmin.activity-logs.create\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:13:\"activity-logs\";s:1:\"r\";a:2:{i:0;i:3;i:1;i:6;}}i:1;a:5:{s:1:\"a\";i:2;s:1:\"b\";s:32:\"superadmin.activity-logs.destroy\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:13:\"activity-logs\";s:1:\"r\";a:2:{i:0;i:3;i:1;i:6;}}i:2;a:5:{s:1:\"a\";i:3;s:1:\"b\";s:29:\"superadmin.activity-logs.edit\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:13:\"activity-logs\";s:1:\"r\";a:2:{i:0;i:3;i:1;i:6;}}i:3;a:5:{s:1:\"a\";i:4;s:1:\"b\";s:30:\"superadmin.activity-logs.index\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:13:\"activity-logs\";s:1:\"r\";a:2:{i:0;i:3;i:1;i:6;}}i:4;a:5:{s:1:\"a\";i:5;s:1:\"b\";s:29:\"superadmin.activity-logs.show\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:13:\"activity-logs\";s:1:\"r\";a:2:{i:0;i:3;i:1;i:6;}}i:5;a:5:{s:1:\"a\";i:6;s:1:\"b\";s:33:\"superadmin.affiliate.clicks.index\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:16:\"affiliate.clicks\";s:1:\"r\";a:1:{i:0;i:6;}}i:6;a:5:{s:1:\"a\";i:7;s:1:\"b\";s:32:\"superadmin.affiliate.links.index\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:15:\"affiliate.links\";s:1:\"r\";a:1:{i:0;i:6;}}i:7;a:5:{s:1:\"a\";i:8;s:1:\"b\";s:33:\"superadmin.affiliate.links.toggle\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:15:\"affiliate.links\";s:1:\"r\";a:1:{i:0;i:6;}}i:8;a:5:{s:1:\"a\";i:9;s:1:\"b\";s:32:\"superadmin.affiliate.sales.index\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:15:\"affiliate.sales\";s:1:\"r\";a:1:{i:0;i:6;}}i:9;a:5:{s:1:\"a\";i:10;s:1:\"b\";s:33:\"superadmin.affiliate.sales.status\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:15:\"affiliate.sales\";s:1:\"r\";a:1:{i:0;i:6;}}i:10;a:5:{s:1:\"a\";i:11;s:1:\"b\";s:29:\"superadmin.affiliates.approve\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:10:\"affiliates\";s:1:\"r\";a:1:{i:0;i:6;}}i:11;a:5:{s:1:\"a\";i:12;s:1:\"b\";s:28:\"superadmin.affiliates.create\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:10:\"affiliates\";s:1:\"r\";a:1:{i:0;i:6;}}i:12;a:5:{s:1:\"a\";i:13;s:1:\"b\";s:29:\"superadmin.affiliates.destroy\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:10:\"affiliates\";s:1:\"r\";a:1:{i:0;i:6;}}i:13;a:5:{s:1:\"a\";i:14;s:1:\"b\";s:26:\"superadmin.affiliates.edit\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:10:\"affiliates\";s:1:\"r\";a:1:{i:0;i:6;}}i:14;a:5:{s:1:\"a\";i:15;s:1:\"b\";s:27:\"superadmin.affiliates.index\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:10:\"affiliates\";s:1:\"r\";a:1:{i:0;i:6;}}i:15;a:5:{s:1:\"a\";i:16;s:1:\"b\";s:26:\"superadmin.affiliates.show\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:10:\"affiliates\";s:1:\"r\";a:1:{i:0;i:6;}}i:16;a:5:{s:1:\"a\";i:17;s:1:\"b\";s:29:\"superadmin.affiliates.suspend\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:10:\"affiliates\";s:1:\"r\";a:1:{i:0;i:6;}}i:17;a:5:{s:1:\"a\";i:18;s:1:\"b\";s:28:\"superadmin.attributes.create\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:10:\"attributes\";s:1:\"r\";a:1:{i:0;i:6;}}i:18;a:5:{s:1:\"a\";i:19;s:1:\"b\";s:29:\"superadmin.attributes.destroy\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:10:\"attributes\";s:1:\"r\";a:1:{i:0;i:6;}}i:19;a:5:{s:1:\"a\";i:20;s:1:\"b\";s:26:\"superadmin.attributes.edit\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:10:\"attributes\";s:1:\"r\";a:1:{i:0;i:6;}}i:20;a:5:{s:1:\"a\";i:21;s:1:\"b\";s:27:\"superadmin.attributes.index\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:10:\"attributes\";s:1:\"r\";a:1:{i:0;i:6;}}i:21;a:5:{s:1:\"a\";i:22;s:1:\"b\";s:26:\"superadmin.attributes.show\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:10:\"attributes\";s:1:\"r\";a:1:{i:0;i:6;}}i:22;a:5:{s:1:\"a\";i:23;s:1:\"b\";s:36:\"superadmin.attributes.values.destroy\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:17:\"attributes.values\";s:1:\"r\";a:1:{i:0;i:6;}}i:23;a:5:{s:1:\"a\";i:24;s:1:\"b\";s:34:\"superadmin.attributes.values.store\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:17:\"attributes.values\";s:1:\"r\";a:1:{i:0;i:6;}}i:24;a:5:{s:1:\"a\";i:25;s:1:\"b\";s:25:\"superadmin.banners.create\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:7:\"banners\";s:1:\"r\";a:1:{i:0;i:6;}}i:25;a:5:{s:1:\"a\";i:26;s:1:\"b\";s:26:\"superadmin.banners.destroy\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:7:\"banners\";s:1:\"r\";a:1:{i:0;i:6;}}i:26;a:5:{s:1:\"a\";i:27;s:1:\"b\";s:23:\"superadmin.banners.edit\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:7:\"banners\";s:1:\"r\";a:1:{i:0;i:6;}}i:27;a:5:{s:1:\"a\";i:28;s:1:\"b\";s:24:\"superadmin.banners.index\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:7:\"banners\";s:1:\"r\";a:1:{i:0;i:6;}}i:28;a:5:{s:1:\"a\";i:29;s:1:\"b\";s:24:\"superadmin.brands.create\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:6:\"brands\";s:1:\"r\";a:1:{i:0;i:6;}}i:29;a:5:{s:1:\"a\";i:30;s:1:\"b\";s:25:\"superadmin.brands.destroy\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:6:\"brands\";s:1:\"r\";a:1:{i:0;i:6;}}i:30;a:5:{s:1:\"a\";i:31;s:1:\"b\";s:22:\"superadmin.brands.edit\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:6:\"brands\";s:1:\"r\";a:1:{i:0;i:6;}}i:31;a:5:{s:1:\"a\";i:32;s:1:\"b\";s:23:\"superadmin.brands.index\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:6:\"brands\";s:1:\"r\";a:1:{i:0;i:6;}}i:32;a:5:{s:1:\"a\";i:33;s:1:\"b\";s:22:\"superadmin.brands.show\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:6:\"brands\";s:1:\"r\";a:1:{i:0;i:6;}}i:33;a:5:{s:1:\"a\";i:34;s:1:\"b\";s:27:\"superadmin.campaigns.create\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:9:\"campaigns\";s:1:\"r\";a:1:{i:0;i:6;}}i:34;a:5:{s:1:\"a\";i:35;s:1:\"b\";s:28:\"superadmin.campaigns.destroy\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:9:\"campaigns\";s:1:\"r\";a:1:{i:0;i:6;}}i:35;a:5:{s:1:\"a\";i:36;s:1:\"b\";s:25:\"superadmin.campaigns.edit\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:9:\"campaigns\";s:1:\"r\";a:1:{i:0;i:6;}}i:36;a:5:{s:1:\"a\";i:37;s:1:\"b\";s:26:\"superadmin.campaigns.index\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:9:\"campaigns\";s:1:\"r\";a:1:{i:0;i:6;}}i:37;a:5:{s:1:\"a\";i:38;s:1:\"b\";s:25:\"superadmin.campaigns.show\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:9:\"campaigns\";s:1:\"r\";a:1:{i:0;i:6;}}i:38;a:5:{s:1:\"a\";i:39;s:1:\"b\";s:28:\"superadmin.categories.create\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:10:\"categories\";s:1:\"r\";a:1:{i:0;i:6;}}i:39;a:5:{s:1:\"a\";i:40;s:1:\"b\";s:29:\"superadmin.categories.destroy\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:10:\"categories\";s:1:\"r\";a:1:{i:0;i:6;}}i:40;a:5:{s:1:\"a\";i:41;s:1:\"b\";s:26:\"superadmin.categories.edit\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:10:\"categories\";s:1:\"r\";a:1:{i:0;i:6;}}i:41;a:5:{s:1:\"a\";i:42;s:1:\"b\";s:27:\"superadmin.categories.index\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:10:\"categories\";s:1:\"r\";a:1:{i:0;i:6;}}i:42;a:5:{s:1:\"a\";i:43;s:1:\"b\";s:26:\"superadmin.categories.show\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:10:\"categories\";s:1:\"r\";a:1:{i:0;i:6;}}i:43;a:5:{s:1:\"a\";i:44;s:1:\"b\";s:35:\"superadmin.categories.subcategories\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:10:\"categories\";s:1:\"r\";a:1:{i:0;i:6;}}i:44;a:5:{s:1:\"a\";i:45;s:1:\"b\";s:35:\"superadmin.commission-rules.destroy\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:16:\"commission-rules\";s:1:\"r\";a:1:{i:0;i:6;}}i:45;a:5:{s:1:\"a\";i:46;s:1:\"b\";s:33:\"superadmin.commission-rules.index\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:16:\"commission-rules\";s:1:\"r\";a:1:{i:0;i:6;}}i:46;a:5:{s:1:\"a\";i:47;s:1:\"b\";s:33:\"superadmin.commission-rules.store\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:16:\"commission-rules\";s:1:\"r\";a:1:{i:0;i:6;}}i:47;a:5:{s:1:\"a\";i:48;s:1:\"b\";s:34:\"superadmin.commission-rules.update\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:16:\"commission-rules\";s:1:\"r\";a:1:{i:0;i:6;}}i:48;a:5:{s:1:\"a\";i:49;s:1:\"b\";s:28:\"superadmin.commissions.index\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:11:\"commissions\";s:1:\"r\";a:1:{i:0;i:6;}}i:49;a:5:{s:1:\"a\";i:50;s:1:\"b\";s:27:\"superadmin.commissions.show\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:11:\"commissions\";s:1:\"r\";a:1:{i:0;i:6;}}i:50;a:5:{s:1:\"a\";i:51;s:1:\"b\";s:29:\"superadmin.commissions.status\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:11:\"commissions\";s:1:\"r\";a:1:{i:0;i:6;}}i:51;a:5:{s:1:\"a\";i:52;s:1:\"b\";s:25:\"superadmin.coupons.create\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:7:\"coupons\";s:1:\"r\";a:1:{i:0;i:6;}}i:52;a:5:{s:1:\"a\";i:53;s:1:\"b\";s:26:\"superadmin.coupons.destroy\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:7:\"coupons\";s:1:\"r\";a:1:{i:0;i:6;}}i:53;a:5:{s:1:\"a\";i:54;s:1:\"b\";s:23:\"superadmin.coupons.edit\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:7:\"coupons\";s:1:\"r\";a:1:{i:0;i:6;}}i:54;a:5:{s:1:\"a\";i:55;s:1:\"b\";s:24:\"superadmin.coupons.index\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:7:\"coupons\";s:1:\"r\";a:1:{i:0;i:6;}}i:55;a:5:{s:1:\"a\";i:56;s:1:\"b\";s:23:\"superadmin.coupons.show\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:7:\"coupons\";s:1:\"r\";a:1:{i:0;i:6;}}i:56;a:5:{s:1:\"a\";i:57;s:1:\"b\";s:26:\"superadmin.couriers.create\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:8:\"couriers\";s:1:\"r\";a:1:{i:0;i:6;}}i:57;a:5:{s:1:\"a\";i:58;s:1:\"b\";s:27:\"superadmin.couriers.destroy\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:8:\"couriers\";s:1:\"r\";a:1:{i:0;i:6;}}i:58;a:5:{s:1:\"a\";i:59;s:1:\"b\";s:24:\"superadmin.couriers.edit\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:8:\"couriers\";s:1:\"r\";a:1:{i:0;i:6;}}i:59;a:5:{s:1:\"a\";i:60;s:1:\"b\";s:25:\"superadmin.couriers.index\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:8:\"couriers\";s:1:\"r\";a:1:{i:0;i:6;}}i:60;a:5:{s:1:\"a\";i:61;s:1:\"b\";s:24:\"superadmin.couriers.show\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:8:\"couriers\";s:1:\"r\";a:1:{i:0;i:6;}}i:61;a:5:{s:1:\"a\";i:62;s:1:\"b\";s:21:\"superadmin.deliveries\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:10:\"deliveries\";s:1:\"r\";a:1:{i:0;i:6;}}i:62;a:5:{s:1:\"a\";i:63;s:1:\"b\";s:32:\"superadmin.delivery-rates.create\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:14:\"delivery-rates\";s:1:\"r\";a:1:{i:0;i:6;}}i:63;a:5:{s:1:\"a\";i:64;s:1:\"b\";s:33:\"superadmin.delivery-rates.destroy\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:14:\"delivery-rates\";s:1:\"r\";a:1:{i:0;i:6;}}i:64;a:5:{s:1:\"a\";i:65;s:1:\"b\";s:30:\"superadmin.delivery-rates.edit\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:14:\"delivery-rates\";s:1:\"r\";a:1:{i:0;i:6;}}i:65;a:5:{s:1:\"a\";i:66;s:1:\"b\";s:31:\"superadmin.delivery-rates.index\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:14:\"delivery-rates\";s:1:\"r\";a:1:{i:0;i:6;}}i:66;a:5:{s:1:\"a\";i:67;s:1:\"b\";s:30:\"superadmin.delivery-rates.show\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:14:\"delivery-rates\";s:1:\"r\";a:1:{i:0;i:6;}}i:67;a:5:{s:1:\"a\";i:68;s:1:\"b\";s:26:\"superadmin.disputes.create\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:8:\"disputes\";s:1:\"r\";a:1:{i:0;i:6;}}i:68;a:5:{s:1:\"a\";i:69;s:1:\"b\";s:27:\"superadmin.disputes.destroy\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:8:\"disputes\";s:1:\"r\";a:1:{i:0;i:6;}}i:69;a:5:{s:1:\"a\";i:70;s:1:\"b\";s:24:\"superadmin.disputes.edit\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:8:\"disputes\";s:1:\"r\";a:1:{i:0;i:6;}}i:70;a:5:{s:1:\"a\";i:71;s:1:\"b\";s:25:\"superadmin.disputes.index\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:8:\"disputes\";s:1:\"r\";a:1:{i:0;i:6;}}i:71;a:5:{s:1:\"a\";i:72;s:1:\"b\";s:24:\"superadmin.disputes.show\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:8:\"disputes\";s:1:\"r\";a:1:{i:0;i:6;}}i:72;a:5:{s:1:\"a\";i:73;s:1:\"b\";s:37:\"superadmin.dropshipping.imports.index\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:20:\"dropshipping.imports\";s:1:\"r\";a:1:{i:0;i:6;}}i:73;a:5:{s:1:\"a\";i:74;s:1:\"b\";s:36:\"superadmin.dropshipping.orders.index\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:19:\"dropshipping.orders\";s:1:\"r\";a:1:{i:0;i:6;}}i:74;a:5:{s:1:\"a\";i:75;s:1:\"b\";s:35:\"superadmin.dropshipping.orders.show\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:19:\"dropshipping.orders\";s:1:\"r\";a:1:{i:0;i:6;}}i:75;a:5:{s:1:\"a\";i:76;s:1:\"b\";s:38:\"superadmin.dropshipping.products.index\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:21:\"dropshipping.products\";s:1:\"r\";a:1:{i:0;i:6;}}i:76;a:5:{s:1:\"a\";i:77;s:1:\"b\";s:39:\"superadmin.dropshipping.products.toggle\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:21:\"dropshipping.products\";s:1:\"r\";a:1:{i:0;i:6;}}i:77;a:5:{s:1:\"a\";i:78;s:1:\"b\";s:36:\"superadmin.dropshipping.profit.index\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:19:\"dropshipping.profit\";s:1:\"r\";a:1:{i:0;i:6;}}i:78;a:5:{s:1:\"a\";i:79;s:1:\"b\";s:38:\"superadmin.dropshipping.settings.index\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:21:\"dropshipping.settings\";s:1:\"r\";a:1:{i:0;i:6;}}i:79;a:5:{s:1:\"a\";i:80;s:1:\"b\";s:39:\"superadmin.dropshipping.settings.update\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:21:\"dropshipping.settings\";s:1:\"r\";a:1:{i:0;i:6;}}i:80;a:5:{s:1:\"a\";i:81;s:1:\"b\";s:39:\"superadmin.dropshipping.suppliers.index\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:22:\"dropshipping.suppliers\";s:1:\"r\";a:1:{i:0;i:6;}}i:81;a:5:{s:1:\"a\";i:82;s:1:\"b\";s:30:\"superadmin.dropshippings.index\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:13:\"dropshippings\";s:1:\"r\";a:1:{i:0;i:6;}}i:82;a:5:{s:1:\"a\";i:83;s:1:\"b\";s:29:\"superadmin.flash-sales.create\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:11:\"flash-sales\";s:1:\"r\";a:1:{i:0;i:6;}}i:83;a:5:{s:1:\"a\";i:84;s:1:\"b\";s:30:\"superadmin.flash-sales.destroy\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:11:\"flash-sales\";s:1:\"r\";a:1:{i:0;i:6;}}i:84;a:5:{s:1:\"a\";i:85;s:1:\"b\";s:27:\"superadmin.flash-sales.edit\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:11:\"flash-sales\";s:1:\"r\";a:1:{i:0;i:6;}}i:85;a:5:{s:1:\"a\";i:86;s:1:\"b\";s:28:\"superadmin.flash-sales.index\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:11:\"flash-sales\";s:1:\"r\";a:1:{i:0;i:6;}}i:86;a:5:{s:1:\"a\";i:87;s:1:\"b\";s:27:\"superadmin.flash-sales.show\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:11:\"flash-sales\";s:1:\"r\";a:1:{i:0;i:6;}}i:87;a:5:{s:1:\"a\";i:88;s:1:\"b\";s:17:\"superadmin.frauds\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:6:\"frauds\";s:1:\"r\";a:1:{i:0;i:6;}}i:88;a:5:{s:1:\"a\";i:89;s:1:\"b\";s:31:\"superadmin.notifications.create\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:13:\"notifications\";s:1:\"r\";a:1:{i:0;i:6;}}i:89;a:5:{s:1:\"a\";i:90;s:1:\"b\";s:32:\"superadmin.notifications.destroy\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:13:\"notifications\";s:1:\"r\";a:1:{i:0;i:6;}}i:90;a:5:{s:1:\"a\";i:91;s:1:\"b\";s:29:\"superadmin.notifications.edit\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:13:\"notifications\";s:1:\"r\";a:1:{i:0;i:6;}}i:91;a:5:{s:1:\"a\";i:92;s:1:\"b\";s:30:\"superadmin.notifications.index\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:13:\"notifications\";s:1:\"r\";a:1:{i:0;i:6;}}i:92;a:5:{s:1:\"a\";i:93;s:1:\"b\";s:29:\"superadmin.notifications.show\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:13:\"notifications\";s:1:\"r\";a:1:{i:0;i:6;}}i:93;a:5:{s:1:\"a\";i:97;s:1:\"b\";s:23:\"superadmin.orders.index\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:6:\"orders\";s:1:\"r\";a:1:{i:0;i:6;}}i:94;a:5:{s:1:\"a\";i:98;s:1:\"b\";s:22:\"superadmin.orders.show\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:6:\"orders\";s:1:\"r\";a:1:{i:0;i:6;}}i:95;a:5:{s:1:\"a\";i:99;s:1:\"b\";s:26:\"superadmin.payments.create\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:8:\"payments\";s:1:\"r\";a:1:{i:0;i:6;}}i:96;a:5:{s:1:\"a\";i:100;s:1:\"b\";s:27:\"superadmin.payments.destroy\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:8:\"payments\";s:1:\"r\";a:1:{i:0;i:6;}}i:97;a:5:{s:1:\"a\";i:101;s:1:\"b\";s:24:\"superadmin.payments.edit\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:8:\"payments\";s:1:\"r\";a:1:{i:0;i:6;}}i:98;a:5:{s:1:\"a\";i:102;s:1:\"b\";s:25:\"superadmin.payments.index\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:8:\"payments\";s:1:\"r\";a:1:{i:0;i:6;}}i:99;a:5:{s:1:\"a\";i:103;s:1:\"b\";s:24:\"superadmin.payments.show\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:8:\"payments\";s:1:\"r\";a:1:{i:0;i:6;}}i:100;a:5:{s:1:\"a\";i:104;s:1:\"b\";s:27:\"superadmin.products.approve\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:8:\"products\";s:1:\"r\";a:2:{i:0;i:3;i:1;i:6;}}i:101;a:5:{s:1:\"a\";i:105;s:1:\"b\";s:26:\"superadmin.products.create\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:8:\"products\";s:1:\"r\";a:2:{i:0;i:3;i:1;i:6;}}i:102;a:5:{s:1:\"a\";i:106;s:1:\"b\";s:27:\"superadmin.products.destroy\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:8:\"products\";s:1:\"r\";a:2:{i:0;i:3;i:1;i:6;}}i:103;a:5:{s:1:\"a\";i:107;s:1:\"b\";s:24:\"superadmin.products.edit\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:8:\"products\";s:1:\"r\";a:2:{i:0;i:3;i:1;i:6;}}i:104;a:5:{s:1:\"a\";i:108;s:1:\"b\";s:25:\"superadmin.products.index\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:8:\"products\";s:1:\"r\";a:2:{i:0;i:3;i:1;i:6;}}i:105;a:5:{s:1:\"a\";i:109;s:1:\"b\";s:24:\"superadmin.products.show\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:8:\"products\";s:1:\"r\";a:2:{i:0;i:3;i:1;i:6;}}i:106;a:5:{s:1:\"a\";i:110;s:1:\"b\";s:25:\"superadmin.refunds.create\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:7:\"refunds\";s:1:\"r\";a:1:{i:0;i:6;}}i:107;a:5:{s:1:\"a\";i:111;s:1:\"b\";s:26:\"superadmin.refunds.destroy\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:7:\"refunds\";s:1:\"r\";a:1:{i:0;i:6;}}i:108;a:5:{s:1:\"a\";i:112;s:1:\"b\";s:23:\"superadmin.refunds.edit\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:7:\"refunds\";s:1:\"r\";a:1:{i:0;i:6;}}i:109;a:5:{s:1:\"a\";i:113;s:1:\"b\";s:24:\"superadmin.refunds.index\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:7:\"refunds\";s:1:\"r\";a:1:{i:0;i:6;}}i:110;a:5:{s:1:\"a\";i:114;s:1:\"b\";s:23:\"superadmin.refunds.show\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:7:\"refunds\";s:1:\"r\";a:1:{i:0;i:6;}}i:111;a:5:{s:1:\"a\";i:115;s:1:\"b\";s:18:\"superadmin.reports\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:7:\"reports\";s:1:\"r\";a:1:{i:0;i:6;}}i:112;a:5:{s:1:\"a\";i:116;s:1:\"b\";s:34:\"superadmin.reseller.earnings.index\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:17:\"reseller.earnings\";s:1:\"r\";a:1:{i:0;i:6;}}i:113;a:5:{s:1:\"a\";i:117;s:1:\"b\";s:33:\"superadmin.reseller.pricing.index\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:16:\"reseller.pricing\";s:1:\"r\";a:1:{i:0;i:6;}}i:114;a:5:{s:1:\"a\";i:118;s:1:\"b\";s:34:\"superadmin.reseller.pricing.update\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:16:\"reseller.pricing\";s:1:\"r\";a:1:{i:0;i:6;}}i:115;a:5:{s:1:\"a\";i:119;s:1:\"b\";s:34:\"superadmin.reseller.products.index\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:17:\"reseller.products\";s:1:\"r\";a:1:{i:0;i:6;}}i:116;a:5:{s:1:\"a\";i:120;s:1:\"b\";s:35:\"superadmin.reseller.products.toggle\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:17:\"reseller.products\";s:1:\"r\";a:1:{i:0;i:6;}}i:117;a:5:{s:1:\"a\";i:121;s:1:\"b\";s:28:\"superadmin.resellers.approve\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:9:\"resellers\";s:1:\"r\";a:1:{i:0;i:6;}}i:118;a:5:{s:1:\"a\";i:122;s:1:\"b\";s:27:\"superadmin.resellers.create\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:9:\"resellers\";s:1:\"r\";a:1:{i:0;i:6;}}i:119;a:5:{s:1:\"a\";i:123;s:1:\"b\";s:28:\"superadmin.resellers.destroy\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:9:\"resellers\";s:1:\"r\";a:1:{i:0;i:6;}}i:120;a:5:{s:1:\"a\";i:124;s:1:\"b\";s:25:\"superadmin.resellers.edit\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:9:\"resellers\";s:1:\"r\";a:1:{i:0;i:6;}}i:121;a:5:{s:1:\"a\";i:125;s:1:\"b\";s:26:\"superadmin.resellers.index\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:9:\"resellers\";s:1:\"r\";a:1:{i:0;i:6;}}i:122;a:5:{s:1:\"a\";i:126;s:1:\"b\";s:25:\"superadmin.resellers.show\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:9:\"resellers\";s:1:\"r\";a:1:{i:0;i:6;}}i:123;a:5:{s:1:\"a\";i:127;s:1:\"b\";s:28:\"superadmin.resellers.suspend\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:9:\"resellers\";s:1:\"r\";a:1:{i:0;i:6;}}i:124;a:5:{s:1:\"a\";i:128;s:1:\"b\";s:18:\"superadmin.returns\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:7:\"returns\";s:1:\"r\";a:1:{i:0;i:6;}}i:125;a:5:{s:1:\"a\";i:129;s:1:\"b\";s:25:\"superadmin.reviews.create\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:7:\"reviews\";s:1:\"r\";a:1:{i:0;i:6;}}i:126;a:5:{s:1:\"a\";i:130;s:1:\"b\";s:26:\"superadmin.reviews.destroy\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:7:\"reviews\";s:1:\"r\";a:1:{i:0;i:6;}}i:127;a:5:{s:1:\"a\";i:131;s:1:\"b\";s:23:\"superadmin.reviews.edit\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:7:\"reviews\";s:1:\"r\";a:1:{i:0;i:6;}}i:128;a:5:{s:1:\"a\";i:132;s:1:\"b\";s:24:\"superadmin.reviews.index\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:7:\"reviews\";s:1:\"r\";a:1:{i:0;i:6;}}i:129;a:5:{s:1:\"a\";i:133;s:1:\"b\";s:23:\"superadmin.reviews.show\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:7:\"reviews\";s:1:\"r\";a:1:{i:0;i:6;}}i:130;a:4:{s:1:\"a\";i:134;s:1:\"b\";s:23:\"superadmin.roles.create\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:5:\"roles\";}i:131;a:4:{s:1:\"a\";i:135;s:1:\"b\";s:24:\"superadmin.roles.destroy\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:5:\"roles\";}i:132;a:4:{s:1:\"a\";i:136;s:1:\"b\";s:21:\"superadmin.roles.edit\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:5:\"roles\";}i:133;a:4:{s:1:\"a\";i:137;s:1:\"b\";s:22:\"superadmin.roles.index\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:5:\"roles\";}i:134;a:5:{s:1:\"a\";i:138;s:1:\"b\";s:30:\"superadmin.settings.commission\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:8:\"settings\";s:1:\"r\";a:1:{i:0;i:6;}}i:135;a:5:{s:1:\"a\";i:139;s:1:\"b\";s:37:\"superadmin.settings.commission.update\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:19:\"settings.commission\";s:1:\"r\";a:1:{i:0;i:6;}}i:136;a:5:{s:1:\"a\";i:140;s:1:\"b\";s:24:\"superadmin.settings.edit\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:8:\"settings\";s:1:\"r\";a:1:{i:0;i:6;}}i:137;a:5:{s:1:\"a\";i:141;s:1:\"b\";s:27:\"superadmin.settings.payment\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:8:\"settings\";s:1:\"r\";a:1:{i:0;i:6;}}i:138;a:5:{s:1:\"a\";i:142;s:1:\"b\";s:34:\"superadmin.settings.payment.update\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:16:\"settings.payment\";s:1:\"r\";a:1:{i:0;i:6;}}i:139;a:5:{s:1:\"a\";i:143;s:1:\"b\";s:28:\"superadmin.settings.shipping\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:8:\"settings\";s:1:\"r\";a:1:{i:0;i:6;}}i:140;a:5:{s:1:\"a\";i:144;s:1:\"b\";s:35:\"superadmin.settings.shipping.update\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:17:\"settings.shipping\";s:1:\"r\";a:1:{i:0;i:6;}}i:141;a:5:{s:1:\"a\";i:145;s:1:\"b\";s:27:\"superadmin.settings.website\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:8:\"settings\";s:1:\"r\";a:1:{i:0;i:6;}}i:142;a:5:{s:1:\"a\";i:146;s:1:\"b\";s:34:\"superadmin.settings.website.update\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:16:\"settings.website\";s:1:\"r\";a:1:{i:0;i:6;}}i:143;a:5:{s:1:\"a\";i:147;s:1:\"b\";s:34:\"superadmin.shipment-tracking.index\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:17:\"shipment-tracking\";s:1:\"r\";a:1:{i:0;i:6;}}i:144;a:5:{s:1:\"a\";i:148;s:1:\"b\";s:33:\"superadmin.shipment-tracking.show\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:17:\"shipment-tracking\";s:1:\"r\";a:1:{i:0;i:6;}}i:145;a:5:{s:1:\"a\";i:149;s:1:\"b\";s:32:\"superadmin.shipping-zones.create\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:14:\"shipping-zones\";s:1:\"r\";a:1:{i:0;i:6;}}i:146;a:5:{s:1:\"a\";i:150;s:1:\"b\";s:33:\"superadmin.shipping-zones.destroy\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:14:\"shipping-zones\";s:1:\"r\";a:1:{i:0;i:6;}}i:147;a:5:{s:1:\"a\";i:151;s:1:\"b\";s:30:\"superadmin.shipping-zones.edit\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:14:\"shipping-zones\";s:1:\"r\";a:1:{i:0;i:6;}}i:148;a:5:{s:1:\"a\";i:152;s:1:\"b\";s:31:\"superadmin.shipping-zones.index\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:14:\"shipping-zones\";s:1:\"r\";a:1:{i:0;i:6;}}i:149;a:5:{s:1:\"a\";i:153;s:1:\"b\";s:30:\"superadmin.shipping-zones.show\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:14:\"shipping-zones\";s:1:\"r\";a:1:{i:0;i:6;}}i:150;a:5:{s:1:\"a\";i:154;s:1:\"b\";s:25:\"superadmin.sliders.create\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:7:\"sliders\";s:1:\"r\";a:1:{i:0;i:6;}}i:151;a:5:{s:1:\"a\";i:155;s:1:\"b\";s:26:\"superadmin.sliders.destroy\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:7:\"sliders\";s:1:\"r\";a:1:{i:0;i:6;}}i:152;a:5:{s:1:\"a\";i:156;s:1:\"b\";s:23:\"superadmin.sliders.edit\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:7:\"sliders\";s:1:\"r\";a:1:{i:0;i:6;}}i:153;a:5:{s:1:\"a\";i:157;s:1:\"b\";s:24:\"superadmin.sliders.index\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:7:\"sliders\";s:1:\"r\";a:1:{i:0;i:6;}}i:154;a:5:{s:1:\"a\";i:158;s:1:\"b\";s:28:\"superadmin.suppliers.approve\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:9:\"suppliers\";s:1:\"r\";a:1:{i:0;i:6;}}i:155;a:5:{s:1:\"a\";i:159;s:1:\"b\";s:27:\"superadmin.suppliers.create\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:9:\"suppliers\";s:1:\"r\";a:1:{i:0;i:6;}}i:156;a:5:{s:1:\"a\";i:160;s:1:\"b\";s:28:\"superadmin.suppliers.destroy\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:9:\"suppliers\";s:1:\"r\";a:1:{i:0;i:6;}}i:157;a:5:{s:1:\"a\";i:161;s:1:\"b\";s:25:\"superadmin.suppliers.edit\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:9:\"suppliers\";s:1:\"r\";a:1:{i:0;i:6;}}i:158;a:5:{s:1:\"a\";i:162;s:1:\"b\";s:26:\"superadmin.suppliers.index\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:9:\"suppliers\";s:1:\"r\";a:1:{i:0;i:6;}}i:159;a:5:{s:1:\"a\";i:163;s:1:\"b\";s:25:\"superadmin.suppliers.show\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:9:\"suppliers\";s:1:\"r\";a:1:{i:0;i:6;}}i:160;a:5:{s:1:\"a\";i:164;s:1:\"b\";s:28:\"superadmin.suppliers.suspend\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:9:\"suppliers\";s:1:\"r\";a:1:{i:0;i:6;}}i:161;a:5:{s:1:\"a\";i:165;s:1:\"b\";s:19:\"superadmin.supports\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:8:\"supports\";s:1:\"r\";a:1:{i:0;i:6;}}i:162;a:4:{s:1:\"a\";i:166;s:1:\"b\";s:23:\"superadmin.users.create\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:5:\"users\";}i:163;a:4:{s:1:\"a\";i:167;s:1:\"b\";s:24:\"superadmin.users.destroy\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:5:\"users\";}i:164;a:4:{s:1:\"a\";i:168;s:1:\"b\";s:21:\"superadmin.users.edit\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:5:\"users\";}i:165;a:4:{s:1:\"a\";i:169;s:1:\"b\";s:22:\"superadmin.users.index\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:5:\"users\";}i:166;a:4:{s:1:\"a\";i:170;s:1:\"b\";s:21:\"superadmin.users.show\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:5:\"users\";}i:167;a:5:{s:1:\"a\";i:171;s:1:\"b\";s:26:\"superadmin.vendors.approve\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:7:\"vendors\";s:1:\"r\";a:1:{i:0;i:6;}}i:168;a:5:{s:1:\"a\";i:172;s:1:\"b\";s:25:\"superadmin.vendors.create\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:7:\"vendors\";s:1:\"r\";a:1:{i:0;i:6;}}i:169;a:5:{s:1:\"a\";i:173;s:1:\"b\";s:26:\"superadmin.vendors.destroy\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:7:\"vendors\";s:1:\"r\";a:1:{i:0;i:6;}}i:170;a:5:{s:1:\"a\";i:174;s:1:\"b\";s:23:\"superadmin.vendors.edit\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:7:\"vendors\";s:1:\"r\";a:1:{i:0;i:6;}}i:171;a:5:{s:1:\"a\";i:175;s:1:\"b\";s:24:\"superadmin.vendors.index\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:7:\"vendors\";s:1:\"r\";a:1:{i:0;i:6;}}i:172;a:5:{s:1:\"a\";i:176;s:1:\"b\";s:25:\"superadmin.vendors.reject\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:7:\"vendors\";s:1:\"r\";a:1:{i:0;i:6;}}i:173;a:5:{s:1:\"a\";i:177;s:1:\"b\";s:23:\"superadmin.vendors.show\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:7:\"vendors\";s:1:\"r\";a:1:{i:0;i:6;}}i:174;a:5:{s:1:\"a\";i:178;s:1:\"b\";s:26:\"superadmin.vendors.suspend\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:7:\"vendors\";s:1:\"r\";a:1:{i:0;i:6;}}i:175;a:5:{s:1:\"a\";i:179;s:1:\"b\";s:38:\"superadmin.wholesale.bulk-orders.index\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:21:\"wholesale.bulk-orders\";s:1:\"r\";a:1:{i:0;i:6;}}i:176;a:5:{s:1:\"a\";i:180;s:1:\"b\";s:32:\"superadmin.wholesale.moq.destroy\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:13:\"wholesale.moq\";s:1:\"r\";a:1:{i:0;i:6;}}i:177;a:5:{s:1:\"a\";i:181;s:1:\"b\";s:30:\"superadmin.wholesale.moq.index\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:13:\"wholesale.moq\";s:1:\"r\";a:1:{i:0;i:6;}}i:178;a:5:{s:1:\"a\";i:182;s:1:\"b\";s:30:\"superadmin.wholesale.moq.store\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:13:\"wholesale.moq\";s:1:\"r\";a:1:{i:0;i:6;}}i:179;a:5:{s:1:\"a\";i:183;s:1:\"b\";s:37:\"superadmin.wholesale.products.destroy\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:18:\"wholesale.products\";s:1:\"r\";a:1:{i:0;i:6;}}i:180;a:5:{s:1:\"a\";i:184;s:1:\"b\";s:35:\"superadmin.wholesale.products.index\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:18:\"wholesale.products\";s:1:\"r\";a:1:{i:0;i:6;}}i:181;a:5:{s:1:\"a\";i:185;s:1:\"b\";s:35:\"superadmin.wholesale.products.store\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:18:\"wholesale.products\";s:1:\"r\";a:1:{i:0;i:6;}}i:182;a:5:{s:1:\"a\";i:186;s:1:\"b\";s:36:\"superadmin.wholesale.products.toggle\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:18:\"wholesale.products\";s:1:\"r\";a:1:{i:0;i:6;}}i:183;a:5:{s:1:\"a\";i:187;s:1:\"b\";s:34:\"superadmin.wholesale.tiers.destroy\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:15:\"wholesale.tiers\";s:1:\"r\";a:1:{i:0;i:6;}}i:184;a:5:{s:1:\"a\";i:188;s:1:\"b\";s:32:\"superadmin.wholesale.tiers.index\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:15:\"wholesale.tiers\";s:1:\"r\";a:1:{i:0;i:6;}}i:185;a:5:{s:1:\"a\";i:189;s:1:\"b\";s:32:\"superadmin.wholesale.tiers.store\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:15:\"wholesale.tiers\";s:1:\"r\";a:1:{i:0;i:6;}}i:186;a:5:{s:1:\"a\";i:190;s:1:\"b\";s:27:\"superadmin.wholesales.index\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:10:\"wholesales\";s:1:\"r\";a:1:{i:0;i:6;}}i:187;a:5:{s:1:\"a\";i:191;s:1:\"b\";s:29:\"superadmin.withdrawals.create\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:11:\"withdrawals\";s:1:\"r\";a:1:{i:0;i:6;}}i:188;a:5:{s:1:\"a\";i:192;s:1:\"b\";s:30:\"superadmin.withdrawals.destroy\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:11:\"withdrawals\";s:1:\"r\";a:1:{i:0;i:6;}}i:189;a:5:{s:1:\"a\";i:193;s:1:\"b\";s:27:\"superadmin.withdrawals.edit\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:11:\"withdrawals\";s:1:\"r\";a:1:{i:0;i:6;}}i:190;a:5:{s:1:\"a\";i:194;s:1:\"b\";s:28:\"superadmin.withdrawals.index\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:11:\"withdrawals\";s:1:\"r\";a:1:{i:0;i:6;}}i:191;a:5:{s:1:\"a\";i:195;s:1:\"b\";s:27:\"superadmin.withdrawals.show\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:11:\"withdrawals\";s:1:\"r\";a:1:{i:0;i:6;}}i:192;a:5:{s:1:\"a\";i:196;s:1:\"b\";s:29:\"superadmin.withdrawals.status\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:11:\"withdrawals\";s:1:\"r\";a:1:{i:0;i:6;}}i:193;a:4:{s:1:\"a\";i:197;s:1:\"b\";s:29:\"superadmin.orders.notes.store\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:12:\"orders.notes\";}i:194;a:4:{s:1:\"a\";i:198;s:1:\"b\";s:32:\"superadmin.orders.payment-status\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:6:\"orders\";}i:195;a:4:{s:1:\"a\";i:199;s:1:\"b\";s:24:\"superadmin.orders.status\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:6:\"orders\";}i:196;a:4:{s:1:\"a\";i:200;s:1:\"b\";s:26:\"superadmin.customers.index\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:9:\"customers\";}i:197;a:4:{s:1:\"a\";i:201;s:1:\"b\";s:25:\"superadmin.customers.show\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:9:\"customers\";}i:198;a:4:{s:1:\"a\";i:202;s:1:\"b\";s:30:\"superadmin.orders.bulk.courier\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:11:\"orders.bulk\";}i:199;a:4:{s:1:\"a\";i:203;s:1:\"b\";s:29:\"superadmin.orders.bulk.delete\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:11:\"orders.bulk\";}i:200;a:4:{s:1:\"a\";i:204;s:1:\"b\";s:29:\"superadmin.orders.bulk.status\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:11:\"orders.bulk\";}i:201;a:4:{s:1:\"a\";i:205;s:1:\"b\";s:30:\"superadmin.orders.courier.send\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:14:\"orders.courier\";}i:202;a:4:{s:1:\"a\";i:206;s:1:\"b\";s:30:\"superadmin.orders.courier.sync\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:14:\"orders.courier\";}i:203;a:4:{s:1:\"a\";i:207;s:1:\"b\";s:25:\"superadmin.orders.destroy\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:6:\"orders\";}i:204;a:4:{s:1:\"a\";i:208;s:1:\"b\";s:34:\"admin.affiliates.affiliates.create\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:21:\"affiliates.affiliates\";}i:205;a:4:{s:1:\"a\";i:209;s:1:\"b\";s:35:\"admin.affiliates.affiliates.destroy\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:21:\"affiliates.affiliates\";}i:206;a:4:{s:1:\"a\";i:210;s:1:\"b\";s:32:\"admin.affiliates.affiliates.edit\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:21:\"affiliates.affiliates\";}i:207;a:4:{s:1:\"a\";i:211;s:1:\"b\";s:33:\"admin.affiliates.affiliates.index\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:21:\"affiliates.affiliates\";}i:208;a:4:{s:1:\"a\";i:212;s:1:\"b\";s:32:\"admin.affiliates.affiliates.show\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:21:\"affiliates.affiliates\";}i:209;a:4:{s:1:\"a\";i:213;s:1:\"b\";s:33:\"admin.affiliates.campaigns.create\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:20:\"affiliates.campaigns\";}i:210;a:4:{s:1:\"a\";i:214;s:1:\"b\";s:34:\"admin.affiliates.campaigns.destroy\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:20:\"affiliates.campaigns\";}i:211;a:4:{s:1:\"a\";i:215;s:1:\"b\";s:31:\"admin.affiliates.campaigns.edit\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:20:\"affiliates.campaigns\";}i:212;a:4:{s:1:\"a\";i:216;s:1:\"b\";s:32:\"admin.affiliates.campaigns.index\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:20:\"affiliates.campaigns\";}i:213;a:4:{s:1:\"a\";i:217;s:1:\"b\";s:31:\"admin.affiliates.campaigns.show\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:20:\"affiliates.campaigns\";}i:214;a:4:{s:1:\"a\";i:218;s:1:\"b\";s:23:\"admin.affiliates.clicks\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:10:\"affiliates\";}i:215;a:4:{s:1:\"a\";i:219;s:1:\"b\";s:35:\"admin.affiliates.commissions.create\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:22:\"affiliates.commissions\";}i:216;a:4:{s:1:\"a\";i:220;s:1:\"b\";s:36:\"admin.affiliates.commissions.destroy\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:22:\"affiliates.commissions\";}i:217;a:4:{s:1:\"a\";i:221;s:1:\"b\";s:33:\"admin.affiliates.commissions.edit\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:22:\"affiliates.commissions\";}i:218;a:4:{s:1:\"a\";i:222;s:1:\"b\";s:34:\"admin.affiliates.commissions.index\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:22:\"affiliates.commissions\";}i:219;a:4:{s:1:\"a\";i:223;s:1:\"b\";s:33:\"admin.affiliates.commissions.show\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:22:\"affiliates.commissions\";}i:220;a:4:{s:1:\"a\";i:224;s:1:\"b\";s:22:\"admin.affiliates.links\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:10:\"affiliates\";}i:221;a:4:{s:1:\"a\";i:225;s:1:\"b\";s:22:\"admin.affiliates.sales\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:10:\"affiliates\";}i:222;a:4:{s:1:\"a\";i:226;s:1:\"b\";s:35:\"admin.affiliates.withdrawals.create\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:22:\"affiliates.withdrawals\";}i:223;a:4:{s:1:\"a\";i:227;s:1:\"b\";s:36:\"admin.affiliates.withdrawals.destroy\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:22:\"affiliates.withdrawals\";}i:224;a:4:{s:1:\"a\";i:228;s:1:\"b\";s:33:\"admin.affiliates.withdrawals.edit\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:22:\"affiliates.withdrawals\";}i:225;a:4:{s:1:\"a\";i:229;s:1:\"b\";s:34:\"admin.affiliates.withdrawals.index\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:22:\"affiliates.withdrawals\";}i:226;a:4:{s:1:\"a\";i:230;s:1:\"b\";s:33:\"admin.affiliates.withdrawals.show\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:22:\"affiliates.withdrawals\";}i:227;a:4:{s:1:\"a\";i:231;s:1:\"b\";s:30:\"admin.customers.address.create\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:17:\"customers.address\";}i:228;a:4:{s:1:\"a\";i:232;s:1:\"b\";s:31:\"admin.customers.address.destroy\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:17:\"customers.address\";}i:229;a:4:{s:1:\"a\";i:233;s:1:\"b\";s:28:\"admin.customers.address.edit\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:17:\"customers.address\";}i:230;a:4:{s:1:\"a\";i:234;s:1:\"b\";s:29:\"admin.customers.address.index\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:17:\"customers.address\";}i:231;a:4:{s:1:\"a\";i:235;s:1:\"b\";s:28:\"admin.customers.address.show\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:17:\"customers.address\";}i:232;a:4:{s:1:\"a\";i:236;s:1:\"b\";s:31:\"admin.customers.customer-orders\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:9:\"customers\";}i:233;a:4:{s:1:\"a\";i:237;s:1:\"b\";s:32:\"admin.customers.customer-wallets\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:9:\"customers\";}i:234;a:4:{s:1:\"a\";i:238;s:1:\"b\";s:32:\"admin.customers.customers.create\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:19:\"customers.customers\";}i:235;a:4:{s:1:\"a\";i:239;s:1:\"b\";s:33:\"admin.customers.customers.destroy\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:19:\"customers.customers\";}i:236;a:4:{s:1:\"a\";i:240;s:1:\"b\";s:30:\"admin.customers.customers.edit\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:19:\"customers.customers\";}i:237;a:4:{s:1:\"a\";i:241;s:1:\"b\";s:31:\"admin.customers.customers.index\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:19:\"customers.customers\";}i:238;a:4:{s:1:\"a\";i:242;s:1:\"b\";s:30:\"admin.customers.customers.show\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:19:\"customers.customers\";}i:239;a:4:{s:1:\"a\";i:243;s:1:\"b\";s:30:\"admin.delivery.couriers.create\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:17:\"delivery.couriers\";}i:240;a:4:{s:1:\"a\";i:244;s:1:\"b\";s:31:\"admin.delivery.couriers.destroy\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:17:\"delivery.couriers\";}i:241;a:4:{s:1:\"a\";i:245;s:1:\"b\";s:28:\"admin.delivery.couriers.edit\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:17:\"delivery.couriers\";}i:242;a:4:{s:1:\"a\";i:246;s:1:\"b\";s:29:\"admin.delivery.couriers.index\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:17:\"delivery.couriers\";}i:243;a:4:{s:1:\"a\";i:247;s:1:\"b\";s:28:\"admin.delivery.couriers.show\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:17:\"delivery.couriers\";}i:244;a:4:{s:1:\"a\";i:248;s:1:\"b\";s:29:\"admin.delivery.delivery-rates\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:8:\"delivery\";}i:245;a:4:{s:1:\"a\";i:249;s:1:\"b\";s:24:\"admin.delivery.shippings\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:8:\"delivery\";}i:246;a:4:{s:1:\"a\";i:250;s:1:\"b\";s:24:\"admin.delivery.trackings\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:8:\"delivery\";}i:247;a:4:{s:1:\"a\";i:251;s:1:\"b\";s:20:\"admin.delivery.zones\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:8:\"delivery\";}i:248;a:4:{s:1:\"a\";i:252;s:1:\"b\";s:32:\"admin.dropshipping.dropshippings\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:12:\"dropshipping\";}i:249;a:4:{s:1:\"a\";i:253;s:1:\"b\";s:31:\"admin.dropshipping.fulfillments\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:12:\"dropshipping\";}i:250;a:4:{s:1:\"a\";i:254;s:1:\"b\";s:32:\"admin.dropshipping.orders.create\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:19:\"dropshipping.orders\";}i:251;a:4:{s:1:\"a\";i:255;s:1:\"b\";s:33:\"admin.dropshipping.orders.destroy\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:19:\"dropshipping.orders\";}i:252;a:4:{s:1:\"a\";i:256;s:1:\"b\";s:30:\"admin.dropshipping.orders.edit\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:19:\"dropshipping.orders\";}i:253;a:4:{s:1:\"a\";i:257;s:1:\"b\";s:31:\"admin.dropshipping.orders.index\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:19:\"dropshipping.orders\";}i:254;a:4:{s:1:\"a\";i:258;s:1:\"b\";s:30:\"admin.dropshipping.orders.show\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:19:\"dropshipping.orders\";}i:255;a:4:{s:1:\"a\";i:259;s:1:\"b\";s:41:\"admin.dropshipping.product-imports.create\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:28:\"dropshipping.product-imports\";}i:256;a:4:{s:1:\"a\";i:260;s:1:\"b\";s:42:\"admin.dropshipping.product-imports.destroy\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:28:\"dropshipping.product-imports\";}i:257;a:4:{s:1:\"a\";i:261;s:1:\"b\";s:39:\"admin.dropshipping.product-imports.edit\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:28:\"dropshipping.product-imports\";}i:258;a:4:{s:1:\"a\";i:262;s:1:\"b\";s:40:\"admin.dropshipping.product-imports.index\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:28:\"dropshipping.product-imports\";}i:259;a:4:{s:1:\"a\";i:263;s:1:\"b\";s:39:\"admin.dropshipping.product-imports.show\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:28:\"dropshipping.product-imports\";}i:260;a:4:{s:1:\"a\";i:264;s:1:\"b\";s:39:\"admin.dropshipping.product-syncs.create\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:26:\"dropshipping.product-syncs\";}i:261;a:4:{s:1:\"a\";i:265;s:1:\"b\";s:40:\"admin.dropshipping.product-syncs.destroy\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:26:\"dropshipping.product-syncs\";}i:262;a:4:{s:1:\"a\";i:266;s:1:\"b\";s:37:\"admin.dropshipping.product-syncs.edit\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:26:\"dropshipping.product-syncs\";}i:263;a:4:{s:1:\"a\";i:267;s:1:\"b\";s:38:\"admin.dropshipping.product-syncs.index\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:26:\"dropshipping.product-syncs\";}i:264;a:4:{s:1:\"a\";i:268;s:1:\"b\";s:37:\"admin.dropshipping.product-syncs.show\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:26:\"dropshipping.product-syncs\";}i:265;a:4:{s:1:\"a\";i:269;s:1:\"b\";s:34:\"admin.dropshipping.products.create\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:21:\"dropshipping.products\";}i:266;a:4:{s:1:\"a\";i:270;s:1:\"b\";s:35:\"admin.dropshipping.products.destroy\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:21:\"dropshipping.products\";}i:267;a:4:{s:1:\"a\";i:271;s:1:\"b\";s:32:\"admin.dropshipping.products.edit\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:21:\"dropshipping.products\";}i:268;a:4:{s:1:\"a\";i:272;s:1:\"b\";s:33:\"admin.dropshipping.products.index\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:21:\"dropshipping.products\";}i:269;a:4:{s:1:\"a\";i:273;s:1:\"b\";s:32:\"admin.dropshipping.products.show\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:21:\"dropshipping.products\";}i:270;a:4:{s:1:\"a\";i:274;s:1:\"b\";s:26:\"admin.dropshipping.profits\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:12:\"dropshipping\";}i:271;a:4:{s:1:\"a\";i:275;s:1:\"b\";s:35:\"admin.dropshipping.suppliers.create\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:22:\"dropshipping.suppliers\";}i:272;a:4:{s:1:\"a\";i:276;s:1:\"b\";s:36:\"admin.dropshipping.suppliers.destroy\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:22:\"dropshipping.suppliers\";}i:273;a:4:{s:1:\"a\";i:277;s:1:\"b\";s:33:\"admin.dropshipping.suppliers.edit\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:22:\"dropshipping.suppliers\";}i:274;a:4:{s:1:\"a\";i:278;s:1:\"b\";s:34:\"admin.dropshipping.suppliers.index\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:22:\"dropshipping.suppliers\";}i:275;a:4:{s:1:\"a\";i:279;s:1:\"b\";s:33:\"admin.dropshipping.suppliers.show\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:22:\"dropshipping.suppliers\";}i:276;a:4:{s:1:\"a\";i:280;s:1:\"b\";s:28:\"admin.dropshipping.trackings\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:12:\"dropshipping\";}i:277;a:4:{s:1:\"a\";i:281;s:1:\"b\";s:39:\"admin.finance.affiliate-balances.create\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:26:\"finance.affiliate-balances\";}i:278;a:4:{s:1:\"a\";i:282;s:1:\"b\";s:40:\"admin.finance.affiliate-balances.destroy\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:26:\"finance.affiliate-balances\";}i:279;a:4:{s:1:\"a\";i:283;s:1:\"b\";s:37:\"admin.finance.affiliate-balances.edit\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:26:\"finance.affiliate-balances\";}i:280;a:4:{s:1:\"a\";i:284;s:1:\"b\";s:38:\"admin.finance.affiliate-balances.index\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:26:\"finance.affiliate-balances\";}i:281;a:4:{s:1:\"a\";i:285;s:1:\"b\";s:37:\"admin.finance.affiliate-balances.show\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:26:\"finance.affiliate-balances\";}i:282;a:4:{s:1:\"a\";i:286;s:1:\"b\";s:32:\"admin.finance.commissions.create\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:19:\"finance.commissions\";}i:283;a:4:{s:1:\"a\";i:287;s:1:\"b\";s:33:\"admin.finance.commissions.destroy\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:19:\"finance.commissions\";}i:284;a:4:{s:1:\"a\";i:288;s:1:\"b\";s:30:\"admin.finance.commissions.edit\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:19:\"finance.commissions\";}i:285;a:4:{s:1:\"a\";i:289;s:1:\"b\";s:31:\"admin.finance.commissions.index\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:19:\"finance.commissions\";}i:286;a:4:{s:1:\"a\";i:290;s:1:\"b\";s:30:\"admin.finance.commissions.show\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:19:\"finance.commissions\";}i:287;a:4:{s:1:\"a\";i:291;s:1:\"b\";s:29:\"admin.finance.payments.create\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:16:\"finance.payments\";}i:288;a:4:{s:1:\"a\";i:292;s:1:\"b\";s:30:\"admin.finance.payments.destroy\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:16:\"finance.payments\";}i:289;a:4:{s:1:\"a\";i:293;s:1:\"b\";s:27:\"admin.finance.payments.edit\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:16:\"finance.payments\";}i:290;a:4:{s:1:\"a\";i:294;s:1:\"b\";s:28:\"admin.finance.payments.index\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:16:\"finance.payments\";}i:291;a:4:{s:1:\"a\";i:295;s:1:\"b\";s:27:\"admin.finance.payments.show\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:16:\"finance.payments\";}i:292;a:4:{s:1:\"a\";i:296;s:1:\"b\";s:38:\"admin.finance.reseller-balances.create\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:25:\"finance.reseller-balances\";}i:293;a:4:{s:1:\"a\";i:297;s:1:\"b\";s:39:\"admin.finance.reseller-balances.destroy\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:25:\"finance.reseller-balances\";}i:294;a:4:{s:1:\"a\";i:298;s:1:\"b\";s:36:\"admin.finance.reseller-balances.edit\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:25:\"finance.reseller-balances\";}i:295;a:4:{s:1:\"a\";i:299;s:1:\"b\";s:37:\"admin.finance.reseller-balances.index\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:25:\"finance.reseller-balances\";}i:296;a:4:{s:1:\"a\";i:300;s:1:\"b\";s:36:\"admin.finance.reseller-balances.show\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:25:\"finance.reseller-balances\";}i:297;a:4:{s:1:\"a\";i:301;s:1:\"b\";s:38:\"admin.finance.supplier-balances.create\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:25:\"finance.supplier-balances\";}i:298;a:4:{s:1:\"a\";i:302;s:1:\"b\";s:39:\"admin.finance.supplier-balances.destroy\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:25:\"finance.supplier-balances\";}i:299;a:4:{s:1:\"a\";i:303;s:1:\"b\";s:36:\"admin.finance.supplier-balances.edit\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:25:\"finance.supplier-balances\";}i:300;a:4:{s:1:\"a\";i:304;s:1:\"b\";s:37:\"admin.finance.supplier-balances.index\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:25:\"finance.supplier-balances\";}i:301;a:4:{s:1:\"a\";i:305;s:1:\"b\";s:36:\"admin.finance.supplier-balances.show\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:25:\"finance.supplier-balances\";}i:302;a:4:{s:1:\"a\";i:306;s:1:\"b\";s:33:\"admin.finance.transactions.create\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:20:\"finance.transactions\";}i:303;a:4:{s:1:\"a\";i:307;s:1:\"b\";s:34:\"admin.finance.transactions.destroy\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:20:\"finance.transactions\";}i:304;a:4:{s:1:\"a\";i:308;s:1:\"b\";s:31:\"admin.finance.transactions.edit\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:20:\"finance.transactions\";}i:305;a:4:{s:1:\"a\";i:309;s:1:\"b\";s:32:\"admin.finance.transactions.index\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:20:\"finance.transactions\";}i:306;a:4:{s:1:\"a\";i:310;s:1:\"b\";s:31:\"admin.finance.transactions.show\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:20:\"finance.transactions\";}i:307;a:4:{s:1:\"a\";i:311;s:1:\"b\";s:36:\"admin.finance.vendor-balances.create\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:23:\"finance.vendor-balances\";}i:308;a:4:{s:1:\"a\";i:312;s:1:\"b\";s:37:\"admin.finance.vendor-balances.destroy\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:23:\"finance.vendor-balances\";}i:309;a:4:{s:1:\"a\";i:313;s:1:\"b\";s:34:\"admin.finance.vendor-balances.edit\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:23:\"finance.vendor-balances\";}i:310;a:4:{s:1:\"a\";i:314;s:1:\"b\";s:35:\"admin.finance.vendor-balances.index\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:23:\"finance.vendor-balances\";}i:311;a:4:{s:1:\"a\";i:315;s:1:\"b\";s:34:\"admin.finance.vendor-balances.show\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:23:\"finance.vendor-balances\";}i:312;a:4:{s:1:\"a\";i:316;s:1:\"b\";s:32:\"admin.finance.withdrawals.create\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:19:\"finance.withdrawals\";}i:313;a:4:{s:1:\"a\";i:317;s:1:\"b\";s:33:\"admin.finance.withdrawals.destroy\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:19:\"finance.withdrawals\";}i:314;a:4:{s:1:\"a\";i:318;s:1:\"b\";s:30:\"admin.finance.withdrawals.edit\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:19:\"finance.withdrawals\";}i:315;a:4:{s:1:\"a\";i:319;s:1:\"b\";s:31:\"admin.finance.withdrawals.index\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:19:\"finance.withdrawals\";}i:316;a:4:{s:1:\"a\";i:320;s:1:\"b\";s:30:\"admin.finance.withdrawals.show\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:19:\"finance.withdrawals\";}i:317;a:4:{s:1:\"a\";i:321;s:1:\"b\";s:37:\"admin.marketing.advertisements.create\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:24:\"marketing.advertisements\";}i:318;a:4:{s:1:\"a\";i:322;s:1:\"b\";s:38:\"admin.marketing.advertisements.destroy\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:24:\"marketing.advertisements\";}i:319;a:4:{s:1:\"a\";i:323;s:1:\"b\";s:35:\"admin.marketing.advertisements.edit\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:24:\"marketing.advertisements\";}i:320;a:4:{s:1:\"a\";i:324;s:1:\"b\";s:36:\"admin.marketing.advertisements.index\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:24:\"marketing.advertisements\";}i:321;a:4:{s:1:\"a\";i:325;s:1:\"b\";s:35:\"admin.marketing.advertisements.show\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:24:\"marketing.advertisements\";}i:322;a:4:{s:1:\"a\";i:326;s:1:\"b\";s:30:\"admin.marketing.banners.create\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:17:\"marketing.banners\";}i:323;a:4:{s:1:\"a\";i:327;s:1:\"b\";s:31:\"admin.marketing.banners.destroy\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:17:\"marketing.banners\";}i:324;a:4:{s:1:\"a\";i:328;s:1:\"b\";s:28:\"admin.marketing.banners.edit\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:17:\"marketing.banners\";}i:325;a:4:{s:1:\"a\";i:329;s:1:\"b\";s:29:\"admin.marketing.banners.index\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:17:\"marketing.banners\";}i:326;a:4:{s:1:\"a\";i:330;s:1:\"b\";s:28:\"admin.marketing.banners.show\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:17:\"marketing.banners\";}i:327;a:4:{s:1:\"a\";i:331;s:1:\"b\";s:32:\"admin.marketing.campaigns.create\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:19:\"marketing.campaigns\";}i:328;a:4:{s:1:\"a\";i:332;s:1:\"b\";s:33:\"admin.marketing.campaigns.destroy\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:19:\"marketing.campaigns\";}i:329;a:4:{s:1:\"a\";i:333;s:1:\"b\";s:30:\"admin.marketing.campaigns.edit\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:19:\"marketing.campaigns\";}i:330;a:4:{s:1:\"a\";i:334;s:1:\"b\";s:31:\"admin.marketing.campaigns.index\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:19:\"marketing.campaigns\";}i:331;a:4:{s:1:\"a\";i:335;s:1:\"b\";s:30:\"admin.marketing.campaigns.show\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:19:\"marketing.campaigns\";}i:332;a:4:{s:1:\"a\";i:336;s:1:\"b\";s:30:\"admin.marketing.coupons.create\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:17:\"marketing.coupons\";}i:333;a:4:{s:1:\"a\";i:337;s:1:\"b\";s:31:\"admin.marketing.coupons.destroy\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:17:\"marketing.coupons\";}i:334;a:4:{s:1:\"a\";i:338;s:1:\"b\";s:28:\"admin.marketing.coupons.edit\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:17:\"marketing.coupons\";}i:335;a:4:{s:1:\"a\";i:339;s:1:\"b\";s:29:\"admin.marketing.coupons.index\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:17:\"marketing.coupons\";}i:336;a:4:{s:1:\"a\";i:340;s:1:\"b\";s:28:\"admin.marketing.coupons.show\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:17:\"marketing.coupons\";}i:337;a:4:{s:1:\"a\";i:341;s:1:\"b\";s:34:\"admin.marketing.flash-sales.create\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:21:\"marketing.flash-sales\";}i:338;a:4:{s:1:\"a\";i:342;s:1:\"b\";s:35:\"admin.marketing.flash-sales.destroy\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:21:\"marketing.flash-sales\";}i:339;a:4:{s:1:\"a\";i:343;s:1:\"b\";s:32:\"admin.marketing.flash-sales.edit\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:21:\"marketing.flash-sales\";}i:340;a:4:{s:1:\"a\";i:344;s:1:\"b\";s:33:\"admin.marketing.flash-sales.index\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:21:\"marketing.flash-sales\";}i:341;a:4:{s:1:\"a\";i:345;s:1:\"b\";s:32:\"admin.marketing.flash-sales.show\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:21:\"marketing.flash-sales\";}i:342;a:4:{s:1:\"a\";i:346;s:1:\"b\";s:33:\"admin.marketing.promotions.create\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:20:\"marketing.promotions\";}i:343;a:4:{s:1:\"a\";i:347;s:1:\"b\";s:34:\"admin.marketing.promotions.destroy\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:20:\"marketing.promotions\";}i:344;a:4:{s:1:\"a\";i:348;s:1:\"b\";s:31:\"admin.marketing.promotions.edit\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:20:\"marketing.promotions\";}i:345;a:4:{s:1:\"a\";i:349;s:1:\"b\";s:32:\"admin.marketing.promotions.index\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:20:\"marketing.promotions\";}i:346;a:4:{s:1:\"a\";i:350;s:1:\"b\";s:31:\"admin.marketing.promotions.show\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:20:\"marketing.promotions\";}i:347;a:4:{s:1:\"a\";i:351;s:1:\"b\";s:26:\"admin.notifications.create\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:13:\"notifications\";}i:348;a:4:{s:1:\"a\";i:352;s:1:\"b\";s:27:\"admin.notifications.destroy\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:13:\"notifications\";}i:349;a:4:{s:1:\"a\";i:353;s:1:\"b\";s:24:\"admin.notifications.edit\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:13:\"notifications\";}i:350;a:4:{s:1:\"a\";i:354;s:1:\"b\";s:25:\"admin.notifications.index\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:13:\"notifications\";}i:351;a:4:{s:1:\"a\";i:355;s:1:\"b\";s:24:\"admin.notifications.show\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:13:\"notifications\";}i:352;a:4:{s:1:\"a\";i:356;s:1:\"b\";s:31:\"admin.orders.order-items.create\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:18:\"orders.order-items\";}i:353;a:4:{s:1:\"a\";i:357;s:1:\"b\";s:32:\"admin.orders.order-items.destroy\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:18:\"orders.order-items\";}i:354;a:4:{s:1:\"a\";i:358;s:1:\"b\";s:29:\"admin.orders.order-items.edit\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:18:\"orders.order-items\";}i:355;a:4:{s:1:\"a\";i:359;s:1:\"b\";s:30:\"admin.orders.order-items.index\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:18:\"orders.order-items\";}i:356;a:4:{s:1:\"a\";i:360;s:1:\"b\";s:29:\"admin.orders.order-items.show\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:18:\"orders.order-items\";}i:357;a:4:{s:1:\"a\";i:361;s:1:\"b\";s:26:\"admin.orders.orders.create\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:13:\"orders.orders\";}i:358;a:4:{s:1:\"a\";i:362;s:1:\"b\";s:25:\"admin.orders.orders.index\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:13:\"orders.orders\";}i:359;a:4:{s:1:\"a\";i:363;s:1:\"b\";s:24:\"admin.orders.orders.show\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:13:\"orders.orders\";}i:360;a:4:{s:1:\"a\";i:364;s:1:\"b\";s:27:\"admin.orders.refunds.create\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:14:\"orders.refunds\";}i:361;a:4:{s:1:\"a\";i:365;s:1:\"b\";s:28:\"admin.orders.refunds.destroy\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:14:\"orders.refunds\";}i:362;a:4:{s:1:\"a\";i:366;s:1:\"b\";s:25:\"admin.orders.refunds.edit\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:14:\"orders.refunds\";}i:363;a:4:{s:1:\"a\";i:367;s:1:\"b\";s:26:\"admin.orders.refunds.index\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:14:\"orders.refunds\";}i:364;a:4:{s:1:\"a\";i:368;s:1:\"b\";s:25:\"admin.orders.refunds.show\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:14:\"orders.refunds\";}i:365;a:4:{s:1:\"a\";i:369;s:1:\"b\";s:20:\"admin.orders.returns\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:6:\"orders\";}i:366;a:4:{s:1:\"a\";i:370;s:1:\"b\";s:29:\"admin.orders.shipments.create\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:16:\"orders.shipments\";}i:367;a:4:{s:1:\"a\";i:371;s:1:\"b\";s:28:\"admin.orders.shipments.index\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:16:\"orders.shipments\";}i:368;a:4:{s:1:\"a\";i:372;s:1:\"b\";s:35:\"admin.orders.supplier-orders.create\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:22:\"orders.supplier-orders\";}i:369;a:4:{s:1:\"a\";i:373;s:1:\"b\";s:36:\"admin.orders.supplier-orders.destroy\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:22:\"orders.supplier-orders\";}i:370;a:4:{s:1:\"a\";i:374;s:1:\"b\";s:33:\"admin.orders.supplier-orders.edit\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:22:\"orders.supplier-orders\";}i:371;a:4:{s:1:\"a\";i:375;s:1:\"b\";s:34:\"admin.orders.supplier-orders.index\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:22:\"orders.supplier-orders\";}i:372;a:4:{s:1:\"a\";i:376;s:1:\"b\";s:33:\"admin.orders.supplier-orders.show\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:22:\"orders.supplier-orders\";}i:373;a:4:{s:1:\"a\";i:377;s:1:\"b\";s:22:\"admin.orders.trackings\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:6:\"orders\";}i:374;a:4:{s:1:\"a\";i:378;s:1:\"b\";s:33:\"admin.orders.vendor-orders.create\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:20:\"orders.vendor-orders\";}i:375;a:4:{s:1:\"a\";i:379;s:1:\"b\";s:34:\"admin.orders.vendor-orders.destroy\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:20:\"orders.vendor-orders\";}i:376;a:4:{s:1:\"a\";i:380;s:1:\"b\";s:31:\"admin.orders.vendor-orders.edit\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:20:\"orders.vendor-orders\";}i:377;a:4:{s:1:\"a\";i:381;s:1:\"b\";s:32:\"admin.orders.vendor-orders.index\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:20:\"orders.vendor-orders\";}i:378;a:4:{s:1:\"a\";i:382;s:1:\"b\";s:31:\"admin.orders.vendor-orders.show\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:20:\"orders.vendor-orders\";}i:379;a:4:{s:1:\"a\";i:383;s:1:\"b\";s:30:\"admin.payment-deposits.receipt\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:16:\"payment-deposits\";}i:380;a:5:{s:1:\"a\";i:384;s:1:\"b\";s:32:\"admin.products.attributes.create\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:19:\"products.attributes\";s:1:\"r\";a:1:{i:0;i:3;}}i:381;a:5:{s:1:\"a\";i:385;s:1:\"b\";s:33:\"admin.products.attributes.destroy\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:19:\"products.attributes\";s:1:\"r\";a:1:{i:0;i:3;}}i:382;a:5:{s:1:\"a\";i:386;s:1:\"b\";s:30:\"admin.products.attributes.edit\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:19:\"products.attributes\";s:1:\"r\";a:1:{i:0;i:3;}}i:383;a:5:{s:1:\"a\";i:387;s:1:\"b\";s:31:\"admin.products.attributes.index\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:19:\"products.attributes\";s:1:\"r\";a:1:{i:0;i:3;}}i:384;a:5:{s:1:\"a\";i:388;s:1:\"b\";s:30:\"admin.products.attributes.show\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:19:\"products.attributes\";s:1:\"r\";a:1:{i:0;i:3;}}i:385;a:5:{s:1:\"a\";i:389;s:1:\"b\";s:28:\"admin.products.brands.create\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:15:\"products.brands\";s:1:\"r\";a:1:{i:0;i:3;}}i:386;a:5:{s:1:\"a\";i:390;s:1:\"b\";s:29:\"admin.products.brands.destroy\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:15:\"products.brands\";s:1:\"r\";a:1:{i:0;i:3;}}i:387;a:5:{s:1:\"a\";i:391;s:1:\"b\";s:26:\"admin.products.brands.edit\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:15:\"products.brands\";s:1:\"r\";a:1:{i:0;i:3;}}i:388;a:5:{s:1:\"a\";i:392;s:1:\"b\";s:27:\"admin.products.brands.index\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:15:\"products.brands\";s:1:\"r\";a:1:{i:0;i:3;}}i:389;a:5:{s:1:\"a\";i:393;s:1:\"b\";s:26:\"admin.products.brands.show\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:15:\"products.brands\";s:1:\"r\";a:1:{i:0;i:3;}}i:390;a:5:{s:1:\"a\";i:394;s:1:\"b\";s:32:\"admin.products.categories.create\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:19:\"products.categories\";s:1:\"r\";a:1:{i:0;i:3;}}i:391;a:5:{s:1:\"a\";i:395;s:1:\"b\";s:33:\"admin.products.categories.destroy\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:19:\"products.categories\";s:1:\"r\";a:1:{i:0;i:3;}}i:392;a:5:{s:1:\"a\";i:396;s:1:\"b\";s:30:\"admin.products.categories.edit\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:19:\"products.categories\";s:1:\"r\";a:1:{i:0;i:3;}}i:393;a:5:{s:1:\"a\";i:397;s:1:\"b\";s:31:\"admin.products.categories.index\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:19:\"products.categories\";s:1:\"r\";a:1:{i:0;i:3;}}i:394;a:5:{s:1:\"a\";i:398;s:1:\"b\";s:30:\"admin.products.categories.show\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:19:\"products.categories\";s:1:\"r\";a:1:{i:0;i:3;}}i:395;a:5:{s:1:\"a\";i:399;s:1:\"b\";s:29:\"admin.products.import-exports\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:8:\"products\";s:1:\"r\";a:1:{i:0;i:3;}}i:396;a:5:{s:1:\"a\";i:400;s:1:\"b\";s:33:\"admin.products.inventories.create\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:20:\"products.inventories\";s:1:\"r\";a:1:{i:0;i:3;}}i:397;a:5:{s:1:\"a\";i:401;s:1:\"b\";s:34:\"admin.products.inventories.destroy\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:20:\"products.inventories\";s:1:\"r\";a:1:{i:0;i:3;}}i:398;a:5:{s:1:\"a\";i:402;s:1:\"b\";s:31:\"admin.products.inventories.edit\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:20:\"products.inventories\";s:1:\"r\";a:1:{i:0;i:3;}}i:399;a:5:{s:1:\"a\";i:403;s:1:\"b\";s:32:\"admin.products.inventories.index\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:20:\"products.inventories\";s:1:\"r\";a:1:{i:0;i:3;}}i:400;a:5:{s:1:\"a\";i:404;s:1:\"b\";s:31:\"admin.products.inventories.show\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:20:\"products.inventories\";s:1:\"r\";a:1:{i:0;i:3;}}i:401;a:5:{s:1:\"a\";i:405;s:1:\"b\";s:30:\"admin.products.products.create\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:17:\"products.products\";s:1:\"r\";a:1:{i:0;i:3;}}i:402;a:5:{s:1:\"a\";i:406;s:1:\"b\";s:31:\"admin.products.products.destroy\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:17:\"products.products\";s:1:\"r\";a:1:{i:0;i:3;}}i:403;a:5:{s:1:\"a\";i:407;s:1:\"b\";s:28:\"admin.products.products.edit\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:17:\"products.products\";s:1:\"r\";a:1:{i:0;i:3;}}i:404;a:5:{s:1:\"a\";i:408;s:1:\"b\";s:29:\"admin.products.products.index\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:17:\"products.products\";s:1:\"r\";a:1:{i:0;i:3;}}i:405;a:5:{s:1:\"a\";i:409;s:1:\"b\";s:28:\"admin.products.products.show\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:17:\"products.products\";s:1:\"r\";a:1:{i:0;i:3;}}i:406;a:5:{s:1:\"a\";i:410;s:1:\"b\";s:23:\"admin.products.variants\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:8:\"products\";s:1:\"r\";a:1:{i:0;i:3;}}i:407;a:5:{s:1:\"a\";i:411;s:1:\"b\";s:32:\"admin.products.warehouses.create\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:19:\"products.warehouses\";s:1:\"r\";a:1:{i:0;i:3;}}i:408;a:5:{s:1:\"a\";i:412;s:1:\"b\";s:33:\"admin.products.warehouses.destroy\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:19:\"products.warehouses\";s:1:\"r\";a:1:{i:0;i:3;}}i:409;a:5:{s:1:\"a\";i:413;s:1:\"b\";s:30:\"admin.products.warehouses.edit\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:19:\"products.warehouses\";s:1:\"r\";a:1:{i:0;i:3;}}i:410;a:5:{s:1:\"a\";i:414;s:1:\"b\";s:31:\"admin.products.warehouses.index\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:19:\"products.warehouses\";s:1:\"r\";a:1:{i:0;i:3;}}i:411;a:5:{s:1:\"a\";i:415;s:1:\"b\";s:30:\"admin.products.warehouses.show\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:19:\"products.warehouses\";s:1:\"r\";a:1:{i:0;i:3;}}i:412;a:4:{s:1:\"a\";i:416;s:1:\"b\";s:31:\"admin.reports.affiliate-reports\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:7:\"reports\";}i:413;a:4:{s:1:\"a\";i:417;s:1:\"b\";s:32:\"admin.reports.commission-reports\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:7:\"reports\";}i:414;a:4:{s:1:\"a\";i:418;s:1:\"b\";s:34:\"admin.reports.dropshipping-reports\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:7:\"reports\";}i:415;a:4:{s:1:\"a\";i:419;s:1:\"b\";s:31:\"admin.reports.financial-reports\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:7:\"reports\";}i:416;a:4:{s:1:\"a\";i:420;s:1:\"b\";s:29:\"admin.reports.product-reports\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:7:\"reports\";}i:417;a:4:{s:1:\"a\";i:421;s:1:\"b\";s:28:\"admin.reports.report-exports\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:7:\"reports\";}i:418;a:4:{s:1:\"a\";i:422;s:1:\"b\";s:30:\"admin.reports.reseller-reports\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:7:\"reports\";}i:419;a:4:{s:1:\"a\";i:423;s:1:\"b\";s:27:\"admin.reports.sales-reports\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:7:\"reports\";}i:420;a:4:{s:1:\"a\";i:424;s:1:\"b\";s:30:\"admin.reports.supplier-reports\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:7:\"reports\";}i:421;a:4:{s:1:\"a\";i:425;s:1:\"b\";s:28:\"admin.reports.vendor-reports\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:7:\"reports\";}i:422;a:4:{s:1:\"a\";i:426;s:1:\"b\";s:31:\"admin.reports.wholesale-reports\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:7:\"reports\";}i:423;a:4:{s:1:\"a\";i:427;s:1:\"b\";s:24:\"admin.resellers.earnings\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:9:\"resellers\";}i:424;a:4:{s:1:\"a\";i:428;s:1:\"b\";s:29:\"admin.resellers.orders.create\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:16:\"resellers.orders\";}i:425;a:4:{s:1:\"a\";i:429;s:1:\"b\";s:30:\"admin.resellers.orders.destroy\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:16:\"resellers.orders\";}i:426;a:4:{s:1:\"a\";i:430;s:1:\"b\";s:27:\"admin.resellers.orders.edit\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:16:\"resellers.orders\";}i:427;a:4:{s:1:\"a\";i:431;s:1:\"b\";s:28:\"admin.resellers.orders.index\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:16:\"resellers.orders\";}i:428;a:4:{s:1:\"a\";i:432;s:1:\"b\";s:27:\"admin.resellers.orders.show\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:16:\"resellers.orders\";}i:429;a:4:{s:1:\"a\";i:433;s:1:\"b\";s:24:\"admin.resellers.pricings\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:9:\"resellers\";}i:430;a:4:{s:1:\"a\";i:434;s:1:\"b\";s:31:\"admin.resellers.products.create\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:18:\"resellers.products\";}i:431;a:4:{s:1:\"a\";i:435;s:1:\"b\";s:32:\"admin.resellers.products.destroy\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:18:\"resellers.products\";}i:432;a:4:{s:1:\"a\";i:436;s:1:\"b\";s:29:\"admin.resellers.products.edit\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:18:\"resellers.products\";}i:433;a:4:{s:1:\"a\";i:437;s:1:\"b\";s:30:\"admin.resellers.products.index\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:18:\"resellers.products\";}i:434;a:4:{s:1:\"a\";i:438;s:1:\"b\";s:29:\"admin.resellers.products.show\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:18:\"resellers.products\";}i:435;a:4:{s:1:\"a\";i:439;s:1:\"b\";s:32:\"admin.resellers.resellers.create\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:19:\"resellers.resellers\";}i:436;a:4:{s:1:\"a\";i:440;s:1:\"b\";s:33:\"admin.resellers.resellers.destroy\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:19:\"resellers.resellers\";}i:437;a:4:{s:1:\"a\";i:441;s:1:\"b\";s:30:\"admin.resellers.resellers.edit\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:19:\"resellers.resellers\";}i:438;a:4:{s:1:\"a\";i:442;s:1:\"b\";s:31:\"admin.resellers.resellers.index\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:19:\"resellers.resellers\";}i:439;a:4:{s:1:\"a\";i:443;s:1:\"b\";s:30:\"admin.resellers.resellers.show\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:19:\"resellers.resellers\";}i:440;a:4:{s:1:\"a\";i:444;s:1:\"b\";s:34:\"admin.resellers.withdrawals.create\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:21:\"resellers.withdrawals\";}i:441;a:4:{s:1:\"a\";i:445;s:1:\"b\";s:35:\"admin.resellers.withdrawals.destroy\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:21:\"resellers.withdrawals\";}i:442;a:4:{s:1:\"a\";i:446;s:1:\"b\";s:32:\"admin.resellers.withdrawals.edit\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:21:\"resellers.withdrawals\";}i:443;a:4:{s:1:\"a\";i:447;s:1:\"b\";s:33:\"admin.resellers.withdrawals.index\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:21:\"resellers.withdrawals\";}i:444;a:4:{s:1:\"a\";i:448;s:1:\"b\";s:32:\"admin.resellers.withdrawals.show\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:21:\"resellers.withdrawals\";}i:445;a:4:{s:1:\"a\";i:449;s:1:\"b\";s:28:\"admin.reviews.ratings.create\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:15:\"reviews.ratings\";}i:446;a:4:{s:1:\"a\";i:450;s:1:\"b\";s:29:\"admin.reviews.ratings.destroy\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:15:\"reviews.ratings\";}i:447;a:4:{s:1:\"a\";i:451;s:1:\"b\";s:26:\"admin.reviews.ratings.edit\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:15:\"reviews.ratings\";}i:448;a:4:{s:1:\"a\";i:452;s:1:\"b\";s:27:\"admin.reviews.ratings.index\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:15:\"reviews.ratings\";}i:449;a:4:{s:1:\"a\";i:453;s:1:\"b\";s:26:\"admin.reviews.ratings.show\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:15:\"reviews.ratings\";}i:450;a:4:{s:1:\"a\";i:454;s:1:\"b\";s:28:\"admin.reviews.report-reviews\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:7:\"reviews\";}i:451;a:4:{s:1:\"a\";i:455;s:1:\"b\";s:28:\"admin.reviews.reviews.create\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:15:\"reviews.reviews\";}i:452;a:4:{s:1:\"a\";i:456;s:1:\"b\";s:29:\"admin.reviews.reviews.destroy\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:15:\"reviews.reviews\";}i:453;a:4:{s:1:\"a\";i:457;s:1:\"b\";s:26:\"admin.reviews.reviews.edit\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:15:\"reviews.reviews\";}i:454;a:4:{s:1:\"a\";i:458;s:1:\"b\";s:27:\"admin.reviews.reviews.index\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:15:\"reviews.reviews\";}i:455;a:4:{s:1:\"a\";i:459;s:1:\"b\";s:26:\"admin.reviews.reviews.show\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:15:\"reviews.reviews\";}i:456;a:4:{s:1:\"a\";i:460;s:1:\"b\";s:16:\"admin.rfqs.index\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:4:\"rfqs\";}i:457;a:4:{s:1:\"a\";i:461;s:1:\"b\";s:15:\"admin.rfqs.show\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:4:\"rfqs\";}i:458;a:4:{s:1:\"a\";i:462;s:1:\"b\";s:20:\"admin.store.profiles\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:5:\"store\";}i:459;a:4:{s:1:\"a\";i:463;s:1:\"b\";s:27:\"admin.store.settings.create\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:14:\"store.settings\";}i:460;a:4:{s:1:\"a\";i:464;s:1:\"b\";s:28:\"admin.store.settings.destroy\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:14:\"store.settings\";}i:461;a:4:{s:1:\"a\";i:465;s:1:\"b\";s:25:\"admin.store.settings.edit\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:14:\"store.settings\";}i:462;a:4:{s:1:\"a\";i:466;s:1:\"b\";s:26:\"admin.store.settings.index\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:14:\"store.settings\";}i:463;a:4:{s:1:\"a\";i:467;s:1:\"b\";s:25:\"admin.store.settings.show\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:14:\"store.settings\";}i:464;a:4:{s:1:\"a\";i:468;s:1:\"b\";s:25:\"admin.store.verifications\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:5:\"store\";}i:465;a:4:{s:1:\"a\";i:469;s:1:\"b\";s:24:\"admin.suppliers.balances\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:9:\"suppliers\";}i:466;a:4:{s:1:\"a\";i:470;s:1:\"b\";s:24:\"admin.suppliers.earnings\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:9:\"suppliers\";}i:467;a:4:{s:1:\"a\";i:471;s:1:\"b\";s:28:\"admin.suppliers.fulfillments\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:9:\"suppliers\";}i:468;a:4:{s:1:\"a\";i:472;s:1:\"b\";s:34:\"admin.suppliers.inventories.create\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:21:\"suppliers.inventories\";}i:469;a:4:{s:1:\"a\";i:473;s:1:\"b\";s:35:\"admin.suppliers.inventories.destroy\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:21:\"suppliers.inventories\";}i:470;a:4:{s:1:\"a\";i:474;s:1:\"b\";s:32:\"admin.suppliers.inventories.edit\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:21:\"suppliers.inventories\";}i:471;a:4:{s:1:\"a\";i:475;s:1:\"b\";s:33:\"admin.suppliers.inventories.index\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:21:\"suppliers.inventories\";}i:472;a:4:{s:1:\"a\";i:476;s:1:\"b\";s:32:\"admin.suppliers.inventories.show\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:21:\"suppliers.inventories\";}i:473;a:4:{s:1:\"a\";i:477;s:1:\"b\";s:29:\"admin.suppliers.orders.create\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:16:\"suppliers.orders\";}i:474;a:4:{s:1:\"a\";i:478;s:1:\"b\";s:30:\"admin.suppliers.orders.destroy\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:16:\"suppliers.orders\";}i:475;a:4:{s:1:\"a\";i:479;s:1:\"b\";s:27:\"admin.suppliers.orders.edit\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:16:\"suppliers.orders\";}i:476;a:4:{s:1:\"a\";i:480;s:1:\"b\";s:28:\"admin.suppliers.orders.index\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:16:\"suppliers.orders\";}i:477;a:4:{s:1:\"a\";i:481;s:1:\"b\";s:27:\"admin.suppliers.orders.show\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:16:\"suppliers.orders\";}i:478;a:4:{s:1:\"a\";i:482;s:1:\"b\";s:24:\"admin.suppliers.pricings\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:9:\"suppliers\";}i:479;a:4:{s:1:\"a\";i:483;s:1:\"b\";s:31:\"admin.suppliers.products.create\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:18:\"suppliers.products\";}i:480;a:4:{s:1:\"a\";i:484;s:1:\"b\";s:32:\"admin.suppliers.products.destroy\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:18:\"suppliers.products\";}i:481;a:4:{s:1:\"a\";i:485;s:1:\"b\";s:29:\"admin.suppliers.products.edit\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:18:\"suppliers.products\";}i:482;a:4:{s:1:\"a\";i:486;s:1:\"b\";s:30:\"admin.suppliers.products.index\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:18:\"suppliers.products\";}i:483;a:4:{s:1:\"a\";i:487;s:1:\"b\";s:29:\"admin.suppliers.products.show\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:18:\"suppliers.products\";}i:484;a:4:{s:1:\"a\";i:488;s:1:\"b\";s:24:\"admin.suppliers.profiles\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:9:\"suppliers\";}i:485;a:4:{s:1:\"a\";i:489;s:1:\"b\";s:31:\"admin.suppliers.purchase-orders\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:9:\"suppliers\";}i:486;a:4:{s:1:\"a\";i:490;s:1:\"b\";s:32:\"admin.suppliers.shipments.create\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:19:\"suppliers.shipments\";}i:487;a:4:{s:1:\"a\";i:491;s:1:\"b\";s:33:\"admin.suppliers.shipments.destroy\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:19:\"suppliers.shipments\";}i:488;a:4:{s:1:\"a\";i:492;s:1:\"b\";s:30:\"admin.suppliers.shipments.edit\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:19:\"suppliers.shipments\";}i:489;a:4:{s:1:\"a\";i:493;s:1:\"b\";s:31:\"admin.suppliers.shipments.index\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:19:\"suppliers.shipments\";}i:490;a:4:{s:1:\"a\";i:494;s:1:\"b\";s:30:\"admin.suppliers.shipments.show\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:19:\"suppliers.shipments\";}i:491;a:4:{s:1:\"a\";i:495;s:1:\"b\";s:32:\"admin.suppliers.suppliers.create\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:19:\"suppliers.suppliers\";}i:492;a:4:{s:1:\"a\";i:496;s:1:\"b\";s:33:\"admin.suppliers.suppliers.destroy\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:19:\"suppliers.suppliers\";}i:493;a:4:{s:1:\"a\";i:497;s:1:\"b\";s:30:\"admin.suppliers.suppliers.edit\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:19:\"suppliers.suppliers\";}i:494;a:4:{s:1:\"a\";i:498;s:1:\"b\";s:31:\"admin.suppliers.suppliers.index\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:19:\"suppliers.suppliers\";}i:495;a:4:{s:1:\"a\";i:499;s:1:\"b\";s:30:\"admin.suppliers.suppliers.show\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:19:\"suppliers.suppliers\";}i:496;a:4:{s:1:\"a\";i:500;s:1:\"b\";s:25:\"admin.suppliers.trackings\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:9:\"suppliers\";}i:497;a:4:{s:1:\"a\";i:501;s:1:\"b\";s:29:\"admin.suppliers.verifications\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:9:\"suppliers\";}i:498;a:4:{s:1:\"a\";i:502;s:1:\"b\";s:34:\"admin.suppliers.withdrawals.create\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:21:\"suppliers.withdrawals\";}i:499;a:4:{s:1:\"a\";i:503;s:1:\"b\";s:35:\"admin.suppliers.withdrawals.destroy\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:21:\"suppliers.withdrawals\";}i:500;a:4:{s:1:\"a\";i:504;s:1:\"b\";s:32:\"admin.suppliers.withdrawals.edit\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:21:\"suppliers.withdrawals\";}i:501;a:4:{s:1:\"a\";i:505;s:1:\"b\";s:33:\"admin.suppliers.withdrawals.index\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:21:\"suppliers.withdrawals\";}i:502;a:4:{s:1:\"a\";i:506;s:1:\"b\";s:32:\"admin.suppliers.withdrawals.show\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:21:\"suppliers.withdrawals\";}i:503;a:4:{s:1:\"a\";i:507;s:1:\"b\";s:30:\"admin.users.permissions.create\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:17:\"users.permissions\";}i:504;a:4:{s:1:\"a\";i:508;s:1:\"b\";s:31:\"admin.users.permissions.destroy\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:17:\"users.permissions\";}i:505;a:4:{s:1:\"a\";i:509;s:1:\"b\";s:28:\"admin.users.permissions.edit\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:17:\"users.permissions\";}i:506;a:4:{s:1:\"a\";i:510;s:1:\"b\";s:29:\"admin.users.permissions.index\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:17:\"users.permissions\";}i:507;a:4:{s:1:\"a\";i:511;s:1:\"b\";s:28:\"admin.users.permissions.show\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:17:\"users.permissions\";}i:508;a:4:{s:1:\"a\";i:512;s:1:\"b\";s:24:\"admin.users.roles.create\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:11:\"users.roles\";}i:509;a:4:{s:1:\"a\";i:513;s:1:\"b\";s:25:\"admin.users.roles.destroy\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:11:\"users.roles\";}i:510;a:4:{s:1:\"a\";i:514;s:1:\"b\";s:22:\"admin.users.roles.edit\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:11:\"users.roles\";}i:511;a:4:{s:1:\"a\";i:515;s:1:\"b\";s:23:\"admin.users.roles.index\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:11:\"users.roles\";}i:512;a:4:{s:1:\"a\";i:516;s:1:\"b\";s:22:\"admin.users.roles.show\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:11:\"users.roles\";}i:513;a:4:{s:1:\"a\";i:517;s:1:\"b\";s:24:\"admin.users.users.create\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:11:\"users.users\";}i:514;a:4:{s:1:\"a\";i:518;s:1:\"b\";s:25:\"admin.users.users.destroy\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:11:\"users.users\";}i:515;a:4:{s:1:\"a\";i:519;s:1:\"b\";s:22:\"admin.users.users.edit\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:11:\"users.users\";}i:516;a:4:{s:1:\"a\";i:520;s:1:\"b\";s:23:\"admin.users.users.index\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:11:\"users.users\";}i:517;a:4:{s:1:\"a\";i:521;s:1:\"b\";s:22:\"admin.users.users.show\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:11:\"users.users\";}i:518;a:4:{s:1:\"a\";i:522;s:1:\"b\";s:22:\"admin.vendors.earnings\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:7:\"vendors\";}i:519;a:4:{s:1:\"a\";i:523;s:1:\"b\";s:27:\"admin.vendors.orders.create\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:14:\"vendors.orders\";}i:520;a:4:{s:1:\"a\";i:524;s:1:\"b\";s:28:\"admin.vendors.orders.destroy\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:14:\"vendors.orders\";}i:521;a:4:{s:1:\"a\";i:525;s:1:\"b\";s:25:\"admin.vendors.orders.edit\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:14:\"vendors.orders\";}i:522;a:4:{s:1:\"a\";i:526;s:1:\"b\";s:26:\"admin.vendors.orders.index\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:14:\"vendors.orders\";}i:523;a:4:{s:1:\"a\";i:527;s:1:\"b\";s:25:\"admin.vendors.orders.show\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:14:\"vendors.orders\";}i:524;a:4:{s:1:\"a\";i:528;s:1:\"b\";s:29:\"admin.vendors.products.create\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:16:\"vendors.products\";}i:525;a:4:{s:1:\"a\";i:529;s:1:\"b\";s:30:\"admin.vendors.products.destroy\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:16:\"vendors.products\";}i:526;a:4:{s:1:\"a\";i:530;s:1:\"b\";s:27:\"admin.vendors.products.edit\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:16:\"vendors.products\";}i:527;a:4:{s:1:\"a\";i:531;s:1:\"b\";s:28:\"admin.vendors.products.index\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:16:\"vendors.products\";}i:528;a:4:{s:1:\"a\";i:532;s:1:\"b\";s:27:\"admin.vendors.products.show\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:16:\"vendors.products\";}i:529;a:4:{s:1:\"a\";i:533;s:1:\"b\";s:28:\"admin.vendors.vendors.create\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:15:\"vendors.vendors\";}i:530;a:4:{s:1:\"a\";i:534;s:1:\"b\";s:29:\"admin.vendors.vendors.destroy\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:15:\"vendors.vendors\";}i:531;a:4:{s:1:\"a\";i:535;s:1:\"b\";s:26:\"admin.vendors.vendors.edit\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:15:\"vendors.vendors\";}i:532;a:4:{s:1:\"a\";i:536;s:1:\"b\";s:27:\"admin.vendors.vendors.index\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:15:\"vendors.vendors\";}i:533;a:4:{s:1:\"a\";i:537;s:1:\"b\";s:26:\"admin.vendors.vendors.show\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:15:\"vendors.vendors\";}i:534;a:4:{s:1:\"a\";i:538;s:1:\"b\";s:27:\"admin.vendors.verifications\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:7:\"vendors\";}i:535;a:4:{s:1:\"a\";i:539;s:1:\"b\";s:32:\"admin.vendors.withdrawals.create\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:19:\"vendors.withdrawals\";}i:536;a:4:{s:1:\"a\";i:540;s:1:\"b\";s:33:\"admin.vendors.withdrawals.destroy\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:19:\"vendors.withdrawals\";}i:537;a:4:{s:1:\"a\";i:541;s:1:\"b\";s:30:\"admin.vendors.withdrawals.edit\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:19:\"vendors.withdrawals\";}i:538;a:4:{s:1:\"a\";i:542;s:1:\"b\";s:31:\"admin.vendors.withdrawals.index\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:19:\"vendors.withdrawals\";}i:539;a:4:{s:1:\"a\";i:543;s:1:\"b\";s:30:\"admin.vendors.withdrawals.show\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:19:\"vendors.withdrawals\";}i:540;a:4:{s:1:\"a\";i:544;s:1:\"b\";s:34:\"admin.wholesale.bulk-orders.create\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:21:\"wholesale.bulk-orders\";}i:541;a:4:{s:1:\"a\";i:545;s:1:\"b\";s:35:\"admin.wholesale.bulk-orders.destroy\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:21:\"wholesale.bulk-orders\";}i:542;a:4:{s:1:\"a\";i:546;s:1:\"b\";s:32:\"admin.wholesale.bulk-orders.edit\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:21:\"wholesale.bulk-orders\";}i:543;a:4:{s:1:\"a\";i:547;s:1:\"b\";s:33:\"admin.wholesale.bulk-orders.index\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:21:\"wholesale.bulk-orders\";}i:544;a:4:{s:1:\"a\";i:548;s:1:\"b\";s:32:\"admin.wholesale.bulk-orders.show\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:21:\"wholesale.bulk-orders\";}i:545;a:4:{s:1:\"a\";i:549;s:1:\"b\";s:32:\"admin.wholesale.customers.create\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:19:\"wholesale.customers\";}i:546;a:4:{s:1:\"a\";i:550;s:1:\"b\";s:33:\"admin.wholesale.customers.destroy\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:19:\"wholesale.customers\";}i:547;a:4:{s:1:\"a\";i:551;s:1:\"b\";s:30:\"admin.wholesale.customers.edit\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:19:\"wholesale.customers\";}i:548;a:4:{s:1:\"a\";i:552;s:1:\"b\";s:31:\"admin.wholesale.customers.index\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:19:\"wholesale.customers\";}i:549;a:4:{s:1:\"a\";i:553;s:1:\"b\";s:30:\"admin.wholesale.customers.show\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:19:\"wholesale.customers\";}i:550;a:4:{s:1:\"a\";i:554;s:1:\"b\";s:30:\"admin.wholesale.minimum-orders\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:9:\"wholesale\";}i:551;a:4:{s:1:\"a\";i:555;s:1:\"b\";s:24:\"admin.wholesale.pricings\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:9:\"wholesale\";}i:552;a:4:{s:1:\"a\";i:556;s:1:\"b\";s:31:\"admin.wholesale.products.create\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:18:\"wholesale.products\";}i:553;a:4:{s:1:\"a\";i:557;s:1:\"b\";s:32:\"admin.wholesale.products.destroy\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:18:\"wholesale.products\";}i:554;a:4:{s:1:\"a\";i:558;s:1:\"b\";s:29:\"admin.wholesale.products.edit\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:18:\"wholesale.products\";}i:555;a:4:{s:1:\"a\";i:559;s:1:\"b\";s:30:\"admin.wholesale.products.index\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:18:\"wholesale.products\";}i:556;a:4:{s:1:\"a\";i:560;s:1:\"b\";s:29:\"admin.wholesale.products.show\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:18:\"wholesale.products\";}i:557;a:4:{s:1:\"a\";i:561;s:1:\"b\";s:26:\"admin.wholesale.wholesales\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:9:\"wholesale\";}i:558;a:4:{s:1:\"a\";i:562;s:1:\"b\";s:36:\"superadmin.delivery-transport.create\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:18:\"delivery-transport\";}i:559;a:4:{s:1:\"a\";i:563;s:1:\"b\";s:35:\"superadmin.delivery-transport.index\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:18:\"delivery-transport\";}i:560;a:4:{s:1:\"a\";i:564;s:1:\"b\";s:31:\"superadmin.manual-orders.create\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:13:\"manual-orders\";}i:561;a:4:{s:1:\"a\";i:565;s:1:\"b\";s:30:\"superadmin.manual-orders.index\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:13:\"manual-orders\";}i:562;a:4:{s:1:\"a\";i:566;s:1:\"b\";s:29:\"superadmin.manual-orders.show\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:13:\"manual-orders\";}i:563;a:4:{s:1:\"a\";i:567;s:1:\"b\";s:33:\"superadmin.notifications.read-all\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:13:\"notifications\";}i:564;a:4:{s:1:\"a\";i:568;s:1:\"b\";s:31:\"superadmin.notifications.update\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:13:\"notifications\";}i:565;a:4:{s:1:\"a\";i:569;s:1:\"b\";s:25:\"superadmin.orders.invoice\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:6:\"orders\";}i:566;a:4:{s:1:\"a\";i:570;s:1:\"b\";s:35:\"superadmin.payment-deposits.receipt\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:16:\"payment-deposits\";}i:567;a:5:{s:1:\"a\";i:571;s:1:\"b\";s:26:\"superadmin.products.reject\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:8:\"products\";s:1:\"r\";a:1:{i:0;i:3;}}i:568;a:4:{s:1:\"a\";i:572;s:1:\"b\";s:21:\"superadmin.rfqs.index\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:4:\"rfqs\";}i:569;a:4:{s:1:\"a\";i:573;s:1:\"b\";s:20:\"superadmin.rfqs.show\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:4:\"rfqs\";}i:570;a:4:{s:1:\"a\";i:574;s:1:\"b\";s:28:\"superadmin.warranties.create\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:10:\"warranties\";}i:571;a:4:{s:1:\"a\";i:575;s:1:\"b\";s:29:\"superadmin.warranties.destroy\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:10:\"warranties\";}i:572;a:4:{s:1:\"a\";i:576;s:1:\"b\";s:26:\"superadmin.warranties.edit\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:10:\"warranties\";}i:573;a:4:{s:1:\"a\";i:577;s:1:\"b\";s:27:\"superadmin.warranties.index\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:10:\"warranties\";}}s:5:\"roles\";a:2:{i:0;a:3:{s:1:\"a\";i:3;s:1:\"b\";s:5:\"admin\";s:1:\"c\";s:3:\"web\";}i:1;a:3:{s:1:\"a\";i:6;s:1:\"b\";s:7:\"Testing\";s:1:\"c\";s:3:\"web\";}}}', 1794392690);
INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('buydorbd-cache-website_settings', 'O:25:\"App\\Models\\WebsiteSetting\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:16:\"website_settings\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:44:{s:2:\"id\";i:1;s:9:\"site_name\";s:6:\"Buydor\";s:7:\"tagline\";N;s:4:\"logo\";s:53:\"settings/X6cIs8giNnhmaExNggpDTbxpPJxERrvhxswZdP2R.png\";s:9:\"logo_dark\";s:53:\"settings/UAo3hFsYf4LDpknpGJhQ4XWrbTe38pClldOtnliX.png\";s:7:\"favicon\";s:53:\"settings/Hdb0K8STwAE8xZk2H7qHmi9OVdT7f3KU6m8AKR3c.png\";s:12:\"footer_about\";s:465:\"Welcome to Buydor, your trusted destination for top-tier electronics. We are committed to redefining your shopping experience by offering an unmatched selection of authentic domestic and international brands. Driven by a passion for quality and innovation, our core mission is to ensure absolute customer satisfaction at every step. At Buydor, we don\'t just sell electronics—we build lasting relationships through reliability, excellence, and exceptional service.\";s:14:\"copyright_text\";N;s:7:\"phone_1\";s:11:\"01617763027\";s:7:\"phone_2\";s:11:\"01690068136\";s:7:\"phone_3\";N;s:7:\"phone_4\";N;s:15:\"whatsapp_number\";s:11:\"01690068136\";s:14:\"messenger_link\";s:51:\"https://www.facebook.com/messages/t/369197663153268\";s:7:\"email_1\";s:22:\"sellymore678@gmail.com\";s:7:\"email_2\";s:19:\"anik.czit@gmail.com\";s:7:\"email_3\";s:19:\"anik.czit@gmail.com\";s:7:\"address\";s:27:\"Wari,Dhaka ,Bangladesh 1100\";s:12:\"google_map_1\";s:340:\"<iframe src=\"https://www.google.com/maps/embed?pb=!1m12!1m8!1m3!1d116889.04906420516!2d90.3919888!3d23.7194498!3m2!1i1024!2i768!4f13.1!2m1!1screativezoneit!5e0!3m2!1sen!2sbd!4v1790915990653!5m2!1sen!2sbd\" width=\"600\" height=\"450\" style=\"border:0;\" allowfullscreen=\"\" loading=\"lazy\" referrerpolicy=\"strict-origin-when-cross-origin\"></iframe>\";s:12:\"google_map_2\";s:41:\"https://maps.app.goo.gl/a6QaNcR9WRV6mjPj7\";s:12:\"facebook_url\";s:39:\"https://www.facebook.com/CreativeZoneIT\";s:13:\"instagram_url\";N;s:11:\"twitter_url\";N;s:11:\"youtube_url\";N;s:12:\"linkedin_url\";N;s:10:\"tiktok_url\";N;s:13:\"pinterest_url\";N;s:10:\"meta_title\";N;s:16:\"meta_description\";N;s:13:\"meta_keywords\";N;s:8:\"og_image\";N;s:19:\"google_analytics_id\";N;s:21:\"google_tag_manager_id\";N;s:17:\"facebook_pixel_id\";N;s:15:\"tiktok_pixel_id\";N;s:18:\"recaptcha_site_key\";N;s:20:\"recaptcha_secret_key\";N;s:13:\"currency_code\";s:3:\"BDT\";s:15:\"currency_symbol\";s:3:\"৳\";s:24:\"free_shipping_min_amount\";N;s:11:\"cod_enabled\";i:0;s:16:\"maintenance_mode\";i:0;s:10:\"created_at\";s:19:\"2026-09-18 05:03:17\";s:10:\"updated_at\";s:19:\"2026-11-05 13:15:41\";}s:11:\"\0*\0original\";a:44:{s:2:\"id\";i:1;s:9:\"site_name\";s:6:\"Buydor\";s:7:\"tagline\";N;s:4:\"logo\";s:53:\"settings/X6cIs8giNnhmaExNggpDTbxpPJxERrvhxswZdP2R.png\";s:9:\"logo_dark\";s:53:\"settings/UAo3hFsYf4LDpknpGJhQ4XWrbTe38pClldOtnliX.png\";s:7:\"favicon\";s:53:\"settings/Hdb0K8STwAE8xZk2H7qHmi9OVdT7f3KU6m8AKR3c.png\";s:12:\"footer_about\";s:465:\"Welcome to Buydor, your trusted destination for top-tier electronics. We are committed to redefining your shopping experience by offering an unmatched selection of authentic domestic and international brands. Driven by a passion for quality and innovation, our core mission is to ensure absolute customer satisfaction at every step. At Buydor, we don\'t just sell electronics—we build lasting relationships through reliability, excellence, and exceptional service.\";s:14:\"copyright_text\";N;s:7:\"phone_1\";s:11:\"01617763027\";s:7:\"phone_2\";s:11:\"01690068136\";s:7:\"phone_3\";N;s:7:\"phone_4\";N;s:15:\"whatsapp_number\";s:11:\"01690068136\";s:14:\"messenger_link\";s:51:\"https://www.facebook.com/messages/t/369197663153268\";s:7:\"email_1\";s:22:\"sellymore678@gmail.com\";s:7:\"email_2\";s:19:\"anik.czit@gmail.com\";s:7:\"email_3\";s:19:\"anik.czit@gmail.com\";s:7:\"address\";s:27:\"Wari,Dhaka ,Bangladesh 1100\";s:12:\"google_map_1\";s:340:\"<iframe src=\"https://www.google.com/maps/embed?pb=!1m12!1m8!1m3!1d116889.04906420516!2d90.3919888!3d23.7194498!3m2!1i1024!2i768!4f13.1!2m1!1screativezoneit!5e0!3m2!1sen!2sbd!4v1790915990653!5m2!1sen!2sbd\" width=\"600\" height=\"450\" style=\"border:0;\" allowfullscreen=\"\" loading=\"lazy\" referrerpolicy=\"strict-origin-when-cross-origin\"></iframe>\";s:12:\"google_map_2\";s:41:\"https://maps.app.goo.gl/a6QaNcR9WRV6mjPj7\";s:12:\"facebook_url\";s:39:\"https://www.facebook.com/CreativeZoneIT\";s:13:\"instagram_url\";N;s:11:\"twitter_url\";N;s:11:\"youtube_url\";N;s:12:\"linkedin_url\";N;s:10:\"tiktok_url\";N;s:13:\"pinterest_url\";N;s:10:\"meta_title\";N;s:16:\"meta_description\";N;s:13:\"meta_keywords\";N;s:8:\"og_image\";N;s:19:\"google_analytics_id\";N;s:21:\"google_tag_manager_id\";N;s:17:\"facebook_pixel_id\";N;s:15:\"tiktok_pixel_id\";N;s:18:\"recaptcha_site_key\";N;s:20:\"recaptcha_secret_key\";N;s:13:\"currency_code\";s:3:\"BDT\";s:15:\"currency_symbol\";s:3:\"৳\";s:24:\"free_shipping_min_amount\";N;s:11:\"cod_enabled\";i:0;s:16:\"maintenance_mode\";i:0;s:10:\"created_at\";s:19:\"2026-09-18 05:03:17\";s:10:\"updated_at\";s:19:\"2026-11-05 13:15:41\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:3:{s:11:\"cod_enabled\";s:7:\"boolean\";s:16:\"maintenance_mode\";s:7:\"boolean\";s:24:\"free_shipping_min_amount\";s:9:\"decimal:2\";}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:41:{i:0;s:9:\"site_name\";i:1;s:7:\"tagline\";i:2;s:4:\"logo\";i:3;s:9:\"logo_dark\";i:4;s:7:\"favicon\";i:5;s:12:\"footer_about\";i:6;s:14:\"copyright_text\";i:7;s:7:\"phone_1\";i:8;s:7:\"phone_2\";i:9;s:7:\"phone_3\";i:10;s:7:\"phone_4\";i:11;s:15:\"whatsapp_number\";i:12;s:14:\"messenger_link\";i:13;s:7:\"email_1\";i:14;s:7:\"email_2\";i:15;s:7:\"email_3\";i:16;s:7:\"address\";i:17;s:12:\"google_map_1\";i:18;s:12:\"google_map_2\";i:19;s:12:\"facebook_url\";i:20;s:13:\"instagram_url\";i:21;s:11:\"twitter_url\";i:22;s:11:\"youtube_url\";i:23;s:12:\"linkedin_url\";i:24;s:10:\"tiktok_url\";i:25;s:13:\"pinterest_url\";i:26;s:10:\"meta_title\";i:27;s:16:\"meta_description\";i:28;s:13:\"meta_keywords\";i:29;s:8:\"og_image\";i:30;s:19:\"google_analytics_id\";i:31;s:21:\"google_tag_manager_id\";i:32;s:17:\"facebook_pixel_id\";i:33;s:15:\"tiktok_pixel_id\";i:34;s:18:\"recaptcha_site_key\";i:35;s:20:\"recaptcha_secret_key\";i:36;s:13:\"currency_code\";i:37;s:15:\"currency_symbol\";i:38;s:24:\"free_shipping_min_amount\";i:39;s:11:\"cod_enabled\";i:40;s:16:\"maintenance_mode\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}', 2109244559);

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `carts`
--

CREATE TABLE `carts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` bigint(20) UNSIGNED DEFAULT NULL,
  `session_id` varchar(255) DEFAULT NULL,
  `status` enum('active','converted','abandoned') NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `carts`
--

INSERT INTO `carts` (`id`, `customer_id`, `session_id`, `status`, `created_at`, `updated_at`) VALUES
(1, NULL, '78da2c96-f9db-47eb-affb-c31007484cbb', 'active', '2026-09-26 10:08:48', '2026-09-26 10:08:48'),
(2, NULL, '11673ebc-5b82-4f53-8865-d03f6937c424', 'active', '2026-09-26 11:20:13', '2026-09-26 11:20:13'),
(3, NULL, '22eba147-ba65-430c-821c-daa386441842', 'active', '2026-09-26 11:20:42', '2026-09-26 11:20:42'),
(4, NULL, '299bd8a0-0fac-42a0-9b01-27e53f73f740', 'active', '2026-09-26 11:20:54', '2026-09-26 11:20:54'),
(5, NULL, 'af83fd5b-3ea2-4484-8205-3ab9592bac4c', 'active', '2026-09-26 11:20:59', '2026-09-26 11:20:59'),
(6, NULL, 'b65284f7-e801-4cfd-8ed2-4cc91dab8c7d', 'active', '2026-09-26 11:21:10', '2026-09-26 11:21:10'),
(7, NULL, 'cfbb7fbe-6019-46cf-a518-5d5806f6a950', 'active', '2026-09-26 11:21:15', '2026-09-26 11:21:15'),
(8, NULL, '2b9334c6-c39e-4c76-8eb7-8cb04c935c6b', 'active', '2026-09-26 11:22:02', '2026-09-26 11:22:02'),
(9, NULL, 'ef221864-6680-4590-a826-aebd677e4bec', 'active', '2026-09-26 11:22:05', '2026-09-26 11:22:05'),
(10, NULL, '43684d50-2515-4acb-8d6e-fdd68a445bb4', 'active', '2026-09-26 11:22:11', '2026-09-26 11:22:11'),
(11, NULL, '52f19242-5b10-4f7d-87b4-9ee8e771b546', 'active', '2026-09-26 11:22:14', '2026-09-26 11:22:14'),
(12, NULL, 'de2714c1-9dfe-40a9-b75f-2329f6507f69', 'active', '2026-09-26 11:22:44', '2026-09-26 11:22:44'),
(13, NULL, '57ff2586-9cb0-4423-9f50-22677464215d', 'active', '2026-09-26 11:22:47', '2026-09-26 11:22:47'),
(14, NULL, '8c1b4215-d1b0-441f-994a-c6ed08268243', 'active', '2026-09-26 11:22:51', '2026-09-26 11:22:51'),
(15, NULL, '5c855636-270c-4826-9141-5e9b84a73026', 'active', '2026-09-26 11:22:53', '2026-09-26 11:22:53'),
(16, NULL, 'c161da4c-a64d-4489-9151-63786c78b03e', 'active', '2026-09-26 11:22:58', '2026-09-26 11:22:58'),
(17, NULL, 'd481c61e-269a-4252-bc04-a7bf7ad8733e', 'active', '2026-09-26 11:23:05', '2026-09-26 11:23:05'),
(18, NULL, '5306ad00-45d7-47cd-9ba1-1557ba70e98c', 'active', '2026-09-26 11:23:29', '2026-09-26 11:23:29'),
(19, NULL, 'f12615a9-cf27-4433-a696-e0078f29530b', 'active', '2026-09-26 11:23:32', '2026-09-26 11:23:32'),
(20, NULL, '28e0433c-0ffd-4063-aa3e-507be49b5fa5', 'active', '2026-09-26 11:23:36', '2026-09-26 11:23:36'),
(21, NULL, '86cd1a24-dd50-4aaa-a5d1-9bf232ea781f', 'active', '2026-09-26 11:23:42', '2026-09-26 11:23:42'),
(22, NULL, '778d433c-79fe-48fd-9da6-f610bab14d4f', 'active', '2026-09-26 11:23:45', '2026-09-26 11:23:45'),
(23, NULL, 'b9cf9c0b-6b9b-44db-b621-f51030492402', 'active', '2026-09-26 11:23:59', '2026-09-26 11:23:59'),
(24, NULL, '0494538a-9bbd-4e7c-a7bd-928ddbfabd5f', 'active', '2026-09-26 11:44:39', '2026-09-26 11:44:39'),
(25, NULL, '1b1b2275-6f47-49fb-b3af-f71a7430778a', 'active', '2026-09-26 12:01:31', '2026-09-26 12:01:31'),
(26, NULL, '7c8c642c-0cc4-44a3-93ec-79187cbf11d6', 'active', '2026-09-26 12:24:52', '2026-09-26 12:24:52'),
(27, NULL, 'df82c0c4-6369-4f03-a158-9e67695b8f4f', 'active', '2026-09-26 12:28:02', '2026-09-26 12:28:02'),
(28, NULL, 'eb06b8c8-c2b0-413f-8cba-b99e1505f19c', 'active', '2026-09-27 11:10:39', '2026-09-27 11:10:39'),
(29, NULL, '16d07a85-8bf3-414b-b8c7-a6b181ce284b', 'active', '2026-10-01 21:11:38', '2026-10-01 21:11:38'),
(30, NULL, '668f865a-424d-4480-8180-75d105e238bd', 'active', '2026-10-01 21:21:31', '2026-10-01 21:21:31'),
(31, NULL, '31327535-c880-4855-892d-aefecfd539f3', 'active', '2026-10-01 21:21:32', '2026-10-01 21:21:32'),
(32, NULL, '6377240a-c15f-4afe-a744-b73bb34f6c1e', 'active', '2026-10-01 21:21:38', '2026-10-01 21:21:38'),
(33, NULL, 'a1582bd8-6647-4b63-9287-aa2ea8946e66', 'active', '2026-10-01 21:21:41', '2026-10-01 21:21:41'),
(34, NULL, '4eec89b3-d695-4100-bb75-7f9fe015658d', 'active', '2026-10-01 21:21:41', '2026-10-01 21:21:41'),
(35, NULL, '15e26873-8e3f-4ee5-ab08-dbdd45d48f89', 'active', '2026-10-01 21:34:36', '2026-10-01 21:34:36'),
(36, NULL, '3774144d-d5e5-43c8-b86e-cf04c2748496', 'active', '2026-10-01 21:34:44', '2026-10-01 21:34:44'),
(37, NULL, 'abafcc16-b240-40e6-bc3b-93e894a29b1f', 'active', '2026-10-01 21:38:54', '2026-10-01 21:38:54'),
(38, NULL, 'bb242bf9-b238-4552-a679-d0a69a286463', 'active', '2026-10-01 21:38:58', '2026-10-01 21:38:58'),
(39, NULL, 'e54809c3-f470-4cfd-bd35-0edcbeba820f', 'active', '2026-10-01 21:39:18', '2026-10-01 21:39:18'),
(40, NULL, '629c4eb1-faa3-4545-9f27-6d18c5658d99', 'active', '2026-10-01 21:39:21', '2026-10-01 21:39:21'),
(41, NULL, '20399d0d-e178-4bc7-8848-72965f28a928', 'active', '2026-10-01 21:39:36', '2026-10-01 21:39:36'),
(42, NULL, '1429f333-288b-4159-912b-12ad5e3480f6', 'active', '2026-10-01 21:46:25', '2026-10-01 21:46:25'),
(43, NULL, 'ee2bf749-7a5b-4ac4-9041-e40464d69377', 'active', '2026-10-01 22:16:01', '2026-10-01 22:16:01'),
(44, NULL, '5a02ef8e-cf16-436c-af6f-34ebee5ba19d', 'active', '2026-10-01 22:18:29', '2026-10-01 22:18:29'),
(45, NULL, 'f42b3931-f864-4a53-b1a4-5cfdd21f3de8', 'active', '2026-10-01 22:37:31', '2026-10-01 22:37:31'),
(46, NULL, '69874ae7-1a0c-469e-b3ad-3c88e10d0b7f', 'active', '2026-10-01 22:40:09', '2026-10-01 22:40:09'),
(47, NULL, '2f217364-7403-4440-b05e-dde3a26e4d79', 'active', '2026-10-01 22:40:38', '2026-10-01 22:40:38'),
(48, NULL, '83bccc6b-b632-4e0b-8771-18c9249bc16b', 'active', '2026-10-02 10:42:57', '2026-10-02 10:42:57'),
(49, NULL, '9d1111c6-4fc6-471f-9543-0477acbc981a', 'active', '2026-10-03 10:40:50', '2026-10-03 10:40:50'),
(50, NULL, '0e8d200d-4a9e-476b-9b61-b5a7bd83aa24', 'active', '2026-10-03 11:33:41', '2026-10-03 11:33:41'),
(51, NULL, '65cbcee7-fe8d-4609-bf11-bfe2c2833d06', 'active', '2026-10-19 21:49:21', '2026-10-19 21:49:21'),
(52, NULL, '93382239-5807-4964-91fd-4224b24ed795', 'active', '2026-10-20 03:17:41', '2026-10-20 03:17:41'),
(53, NULL, '37852849-0a74-4cb3-bef2-ea4c2ca44428', 'active', '2026-10-20 05:09:51', '2026-10-20 05:09:51'),
(54, NULL, '57aa533d-c2f8-48f5-bb93-e12eefed7907', 'active', '2026-10-20 06:57:26', '2026-10-20 06:57:26'),
(55, NULL, '76c8c02e-afb4-4c59-8bec-129424591ce8', 'active', '2026-10-20 06:59:59', '2026-10-20 06:59:59'),
(56, NULL, '7cde5f34-1d62-40a5-a827-82dac8c7a459', 'active', '2026-10-20 07:03:27', '2026-10-20 07:03:27'),
(57, NULL, '217424bd-f0cc-4ee1-838e-d665be237702', 'active', '2026-10-20 07:03:28', '2026-10-20 07:03:28'),
(58, NULL, '8e93227d-41d9-4f4b-95f6-ac3d5256c0d5', 'active', '2026-10-20 07:04:52', '2026-10-20 07:04:52'),
(59, NULL, '4cbfa621-4481-43a1-a9d4-fb56405a9e5c', 'active', '2026-10-20 07:06:35', '2026-10-20 07:06:35'),
(60, NULL, '09cb8e1a-3ffc-450b-92ad-f7485edc3bc5', 'active', '2026-10-20 07:06:35', '2026-10-20 07:06:35'),
(61, NULL, '28201609-5469-4aa1-969b-aaf1838849a3', 'active', '2026-10-20 07:06:36', '2026-10-20 07:06:36'),
(62, NULL, '112c91d7-3fe6-4aa9-bee1-6e081f71fefc', 'active', '2026-10-20 07:10:06', '2026-10-20 07:10:06'),
(63, NULL, 'd9166878-4ce3-402c-b380-9f0638952fe9', 'active', '2026-10-20 07:10:12', '2026-10-20 07:10:12'),
(64, NULL, '65b4f776-3939-4436-849d-ce92d290aeb6', 'active', '2026-10-20 07:12:32', '2026-10-20 07:12:32'),
(65, NULL, 'b3df1f44-00d9-4371-8ed8-41a8bd46c3fa', 'active', '2026-10-20 07:54:35', '2026-10-20 07:54:35'),
(66, NULL, '8118273f-4889-4f38-a31d-dfdd6944741a', 'active', '2026-10-20 08:00:11', '2026-10-20 08:00:11'),
(67, NULL, '7ba40a1c-047d-454e-98dc-8129144d5761', 'active', '2026-10-20 08:00:19', '2026-10-20 08:00:19'),
(68, NULL, '34bd5bdd-08e3-41d5-b5d6-c546f17e1cde', 'active', '2026-10-21 00:31:27', '2026-10-21 00:31:27'),
(69, NULL, 'a4144b52-d335-4db6-bf20-b1906b67e97c', 'active', '2026-10-21 03:56:26', '2026-10-21 03:56:26'),
(70, NULL, 'f58e9ddc-9a7f-4cee-8f5e-e3b88a16f81b', 'active', '2026-10-21 04:07:29', '2026-10-21 04:07:29'),
(71, NULL, 'ee56b4fc-c606-4974-9145-d191780ff869', 'active', '2026-10-21 04:07:35', '2026-10-21 04:07:35'),
(72, NULL, '6e214880-46da-48cd-bcb6-f65738ec3cab', 'active', '2026-10-21 04:24:56', '2026-10-21 04:24:56'),
(73, NULL, '8f83d8d7-1a0f-41f8-93db-320abbaf3d74', 'active', '2026-10-21 04:25:21', '2026-10-21 04:25:21'),
(74, NULL, '8721fe82-be01-48c1-8d62-35ab162401b0', 'active', '2026-10-21 04:25:22', '2026-10-21 04:25:22'),
(75, NULL, 'fe28a666-f4c5-41b1-8aea-11e313ee64ec', 'active', '2026-10-21 04:46:32', '2026-10-21 04:46:32'),
(76, NULL, '464b1abc-029d-4499-b4ad-0eb43f86e7b7', 'active', '2026-10-21 04:46:33', '2026-10-21 04:46:33'),
(77, NULL, '20a818ba-7e72-4514-af01-8d546bd620c8', 'active', '2026-10-21 04:48:21', '2026-10-21 04:48:21'),
(78, NULL, 'f821f805-25b0-44e1-830d-e9421dafad80', 'active', '2026-10-21 04:48:25', '2026-10-21 04:48:25'),
(79, NULL, 'dd289ce2-11a1-4001-8c00-41eed52db17a', 'active', '2026-10-21 04:48:28', '2026-10-21 04:48:28'),
(80, NULL, '89ed7a71-d74a-4130-843a-6509a61e1196', 'active', '2026-10-21 04:48:52', '2026-10-21 04:48:52'),
(81, NULL, 'cdad9664-d405-4476-b8a5-e39effd268e7', 'active', '2026-10-21 04:48:56', '2026-10-21 04:48:56'),
(82, NULL, '8e961a4f-8da1-4794-abb7-210c21564737', 'active', '2026-10-21 04:49:00', '2026-10-21 04:49:00'),
(83, NULL, '5eabbdd6-b801-46cf-9eb2-414063e16e68', 'active', '2026-10-21 04:50:17', '2026-10-21 04:50:17'),
(84, NULL, '6144e230-f79b-4b39-8cb6-cb141f0ba6dd', 'active', '2026-10-21 04:50:21', '2026-10-21 04:50:21'),
(85, NULL, '1a560f28-f57e-4079-82dc-cb6a07b068ab', 'active', '2026-10-21 04:53:36', '2026-10-21 04:53:36'),
(86, NULL, '4763659b-96b7-41df-baa9-c7610a987675', 'active', '2026-10-21 04:53:39', '2026-10-21 04:53:39'),
(87, NULL, '75338e64-da18-4144-a3fc-933fe1ee851b', 'active', '2026-10-21 04:56:26', '2026-10-21 04:56:26'),
(88, NULL, '20423614-8e2c-4057-a087-c927dc08dc07', 'active', '2026-10-21 05:17:48', '2026-10-21 05:17:48'),
(89, NULL, '6dacc0b7-5e01-402f-ac8a-7ff66a3d2759', 'active', '2026-10-21 05:17:49', '2026-10-21 05:17:49'),
(90, NULL, '7000fe88-ecc5-4cff-a6c9-8140a56c9350', 'active', '2026-10-21 05:23:52', '2026-10-21 05:23:52'),
(91, NULL, '2f3312ab-5f17-4320-94ac-1673e4adff37', 'active', '2026-10-21 05:23:53', '2026-10-21 05:23:53'),
(92, NULL, '41a18b7e-743f-4ce5-8c40-9ee9a1360ae8', 'active', '2026-10-21 05:25:10', '2026-10-21 05:25:10'),
(93, NULL, 'b8319e5f-ef6b-44e5-9d4b-f924afa00087', 'active', '2026-10-21 05:25:11', '2026-10-21 05:25:11'),
(94, NULL, 'b145d68b-67e8-4d83-b9a0-0014f3a21cf3', 'active', '2026-10-21 05:25:39', '2026-10-21 05:25:39'),
(95, NULL, '7eaf2ce7-5597-4e01-9013-e7d7f5e37828', 'active', '2026-10-21 05:25:40', '2026-10-21 05:25:40'),
(96, NULL, '1ab694e9-45f1-442f-bb14-892af73b1563', 'active', '2026-10-21 05:36:34', '2026-10-21 05:36:34'),
(97, NULL, 'a61ee5b8-c3b2-4490-a440-2d0aec230728', 'active', '2026-10-21 05:36:35', '2026-10-21 05:36:35'),
(98, NULL, '53febd88-8755-475d-bddc-b4c09af2a31d', 'active', '2026-10-21 06:23:17', '2026-10-21 06:23:17'),
(99, NULL, '8b226d00-bfdc-4cf5-8bdd-155b62804350', 'active', '2026-10-23 22:57:11', '2026-10-23 22:57:11'),
(100, NULL, '6e2977f0-946a-473f-af1a-9cf8953ecf64', 'active', '2026-10-23 23:04:09', '2026-10-23 23:04:09'),
(101, NULL, '6edae594-c5a6-4f72-88e8-10014f70be29', 'active', '2026-10-23 23:10:16', '2026-10-23 23:10:16'),
(102, NULL, '6e80ff44-0a8b-475f-8ce7-8a033d8b5b7c', 'active', '2026-10-23 23:10:19', '2026-10-23 23:10:19'),
(103, NULL, 'e6025159-6ded-483a-965f-a3ad99bb7824', 'active', '2026-10-23 23:10:38', '2026-10-23 23:10:38'),
(104, NULL, '341537c6-a0d2-4753-b77f-bdf9b3a089ec', 'active', '2026-10-23 23:10:39', '2026-10-23 23:10:39'),
(105, NULL, '234e411f-fa27-4f54-9de5-bf3503e0d812', 'active', '2026-10-23 23:12:36', '2026-10-23 23:12:36'),
(106, NULL, '3d8a6b7e-844d-457e-8204-88cf43a5064e', 'active', '2026-10-23 23:33:39', '2026-10-23 23:33:39'),
(107, NULL, 'e105bae6-5a7a-49a6-8728-406b7ae8bf56', 'active', '2026-10-23 23:40:47', '2026-10-23 23:40:47'),
(108, NULL, '2d23ecf2-e5ed-471c-986e-acac596171de', 'active', '2026-10-23 23:41:02', '2026-10-23 23:41:02'),
(109, NULL, 'b05298d7-5205-4106-a083-b986bd10d33a', 'active', '2026-10-23 23:41:03', '2026-10-23 23:41:03'),
(110, NULL, 'adfb58b2-545f-439d-b7ea-9102cb67ab47', 'active', '2026-10-23 23:41:30', '2026-10-23 23:41:30'),
(111, NULL, '07e576f4-2376-4140-8ed3-8d399115daf3', 'active', '2026-10-23 23:41:31', '2026-10-23 23:41:31'),
(112, NULL, 'ff94b996-38fd-4173-9cea-e83a5a5dae09', 'active', '2026-10-23 23:43:07', '2026-10-23 23:43:07'),
(113, NULL, '752a0c3a-bc1c-49c6-a865-a6009fe89573', 'active', '2026-10-23 23:46:13', '2026-10-23 23:46:13'),
(114, NULL, '4b886b27-6688-45f3-9e8e-f544b2ef2900', 'active', '2026-10-23 23:46:25', '2026-10-23 23:46:25'),
(115, NULL, '8db329f7-dae7-4473-87fc-1789d253b0a5', 'active', '2026-10-24 00:41:09', '2026-10-24 00:41:09'),
(116, NULL, 'fe138ad1-5d37-443c-a087-0e8ae9f5f0df', 'active', '2026-10-24 00:41:09', '2026-10-24 00:41:09'),
(117, NULL, 'f351aa77-576d-45e6-9a54-fade6f7b5549', 'active', '2026-10-24 00:41:13', '2026-10-24 00:41:13'),
(118, NULL, '8966d0d8-74f3-4457-b4b2-c52750eefe75', 'active', '2026-10-24 00:41:14', '2026-10-24 00:41:14'),
(119, NULL, 'cf2168ab-4e37-4621-90f7-7edd9066f2f6', 'active', '2026-10-24 00:41:48', '2026-10-24 00:41:48'),
(120, NULL, '73fd5624-90ed-4030-980b-ce6de331b759', 'active', '2026-10-24 00:42:00', '2026-10-24 00:42:00'),
(121, NULL, '62ac16a7-b869-4565-bb0e-16ee98d72146', 'active', '2026-10-24 00:42:19', '2026-10-24 00:42:19'),
(122, NULL, '7661aac8-4f33-41f6-bdf4-58d8cf8ae918', 'active', '2026-10-24 00:42:20', '2026-10-24 00:42:20'),
(123, NULL, '8beccdc1-7177-45aa-bd04-9edf9c7a4a70', 'active', '2026-10-24 00:48:02', '2026-10-24 00:48:02'),
(124, NULL, '44daa225-bfe6-4789-841d-c80b09b3f3cb', 'active', '2026-10-24 00:48:03', '2026-10-24 00:48:03'),
(125, NULL, 'c00d2ff9-adf1-4faf-a05b-bff5978182b4', 'active', '2026-10-24 01:33:16', '2026-10-24 01:33:16'),
(126, NULL, '9bf95802-6195-49e9-9247-412cbc711edf', 'active', '2026-10-24 01:33:17', '2026-10-24 01:33:17'),
(127, NULL, '6a7ac67a-7e14-4746-bb94-c535935e9ad7', 'active', '2026-10-24 01:33:21', '2026-10-24 01:33:21'),
(128, NULL, '862144f6-2cfa-4f49-a723-53a20bfd2015', 'active', '2026-10-24 01:33:36', '2026-10-24 01:33:36'),
(129, NULL, '58e205b1-1823-43d1-8547-f6a5c494b460', 'active', '2026-10-24 01:33:41', '2026-10-24 01:33:41'),
(130, NULL, '2426805c-47b2-44e8-ab78-36196aaac4c1', 'active', '2026-10-24 01:33:50', '2026-10-24 01:33:50'),
(131, NULL, '6c91885f-6b8a-472d-aef9-8fd82836ffc5', 'active', '2026-10-24 01:34:08', '2026-10-24 01:34:08'),
(132, NULL, '685dd3fc-45a2-4b7f-a280-843b40136cb3', 'active', '2026-10-24 01:34:16', '2026-10-24 01:34:16'),
(133, NULL, '601debbf-e464-45aa-981e-641bb075e473', 'active', '2026-10-24 01:34:20', '2026-10-24 01:34:20'),
(134, NULL, 'e0aec248-e1a0-481d-a0d0-c59d7a7bb054', 'active', '2026-10-24 01:34:33', '2026-10-24 01:34:33'),
(135, NULL, '91ea25b3-a06b-4d22-a0f2-1c5d2e27f63c', 'active', '2026-10-24 01:34:38', '2026-10-24 01:34:38'),
(136, NULL, '82d05a58-40bc-47d4-8233-9f010105e1de', 'active', '2026-10-24 01:54:47', '2026-10-24 01:54:47'),
(137, NULL, '497648ce-0f7f-4eb3-8195-573cebdfb659', 'active', '2026-10-24 01:54:48', '2026-10-24 01:54:48'),
(138, NULL, 'b4e3e87e-bbe8-4760-923d-ee1649b1d217', 'active', '2026-10-24 02:02:26', '2026-10-24 02:02:26'),
(139, NULL, 'f4ffaaed-0a66-4883-ae98-60849fdd6b66', 'active', '2026-10-24 02:02:29', '2026-10-24 02:02:29'),
(140, NULL, '089ece55-019a-441a-b372-0da39778aecf', 'active', '2026-10-24 02:08:28', '2026-10-24 02:08:28'),
(141, NULL, 'aa37b3d8-9131-48da-95d2-5e593b5a44fc', 'active', '2026-10-24 04:07:29', '2026-10-24 04:07:29'),
(142, NULL, 'b71f0a06-6621-4b77-bfa4-fdb49cbf1ce8', 'active', '2026-10-24 04:07:34', '2026-10-24 04:07:34'),
(143, NULL, '011fc0f2-05a2-4947-8c81-f20ad8180b72', 'active', '2026-10-24 04:07:45', '2026-10-24 04:07:45'),
(144, NULL, 'c237b877-dbbd-4392-9900-44e85387f537', 'active', '2026-10-24 04:07:59', '2026-10-24 04:07:59'),
(145, NULL, 'a7c49d1c-d32a-4ab7-91f8-e0ab407bac12', 'active', '2026-10-24 04:09:58', '2026-10-24 04:09:58'),
(146, NULL, 'acd7957c-37e3-44ee-8438-96fd24a4c0d0', 'active', '2026-10-24 04:11:10', '2026-10-24 04:11:10'),
(147, NULL, 'd9056819-218c-4e0b-96f8-8e574356f776', 'active', '2026-10-24 04:11:36', '2026-10-24 04:11:36'),
(148, NULL, '8590353e-acf8-421a-9aca-154a992add27', 'active', '2026-10-24 04:13:22', '2026-10-24 04:13:22'),
(149, NULL, '17f00602-657d-441e-9036-6e422b90f45d', 'active', '2026-10-24 04:13:25', '2026-10-24 04:13:25'),
(150, NULL, 'fe655570-1bdc-4054-8574-e47c7560e050', 'active', '2026-10-24 04:13:31', '2026-10-24 04:13:31'),
(151, NULL, '7641e795-6747-42fa-9bc7-2f6a7c7265ec', 'active', '2026-10-24 04:14:14', '2026-10-24 04:14:14'),
(152, NULL, 'd65bbd9d-cf33-4991-b43f-72dc36d661ff', 'active', '2026-10-24 04:14:45', '2026-10-24 04:14:45'),
(153, NULL, '51481905-25c1-47c5-925a-a061786a12ca', 'active', '2026-10-24 04:14:46', '2026-10-24 04:14:46'),
(154, NULL, '98a7317f-592a-4ddf-8fa6-4a5fb0ba8f63', 'active', '2026-10-24 04:14:48', '2026-10-24 04:14:48'),
(155, NULL, '28367423-389e-4917-be16-44e0bcc640e6', 'active', '2026-10-24 04:14:57', '2026-10-24 04:14:57'),
(156, NULL, 'f75a9d0d-81fe-4068-a240-62a3ae63ceb3', 'active', '2026-10-24 04:15:00', '2026-10-24 04:15:00'),
(157, NULL, 'd2474036-53d9-495b-b280-74112c8e22fb', 'active', '2026-10-24 04:15:02', '2026-10-24 04:15:02'),
(158, NULL, '7076745b-1f4e-4086-b15e-4d1c660d0d5b', 'active', '2026-10-24 04:15:04', '2026-10-24 04:15:04'),
(159, NULL, 'ff45f733-8d13-410c-849c-585981cb7966', 'active', '2026-10-24 04:15:07', '2026-10-24 04:15:07'),
(160, NULL, 'a5edd951-54f9-4fe4-ad48-a0f4036d0743', 'active', '2026-10-24 04:15:08', '2026-10-24 04:15:08'),
(161, NULL, 'e3b48137-70d6-4d38-8b5a-221227fad333', 'active', '2026-10-24 04:15:11', '2026-10-24 04:15:11'),
(162, NULL, '33de85b8-cefc-4c45-8543-099d04ca0468', 'active', '2026-10-24 04:18:30', '2026-10-24 04:18:30'),
(163, NULL, 'bc942385-912b-4ed9-a87c-f749a5360840', 'active', '2026-10-24 04:19:12', '2026-10-24 04:19:12'),
(164, NULL, 'aa3f6f1b-4bd6-4bba-8e9a-731663b5f43c', 'active', '2026-10-24 04:19:27', '2026-10-24 04:19:27'),
(165, NULL, '8cb1388d-afb9-4b6f-9b44-0d6e40dd9fce', 'active', '2026-10-24 04:19:44', '2026-10-24 04:19:44'),
(166, NULL, 'a68082ef-411c-4bd1-9732-d1827a169cc6', 'active', '2026-10-24 04:20:32', '2026-10-24 04:20:32'),
(167, NULL, '3c4ce843-aae7-4c07-95fd-7531f7eee6a4', 'active', '2026-10-24 04:21:24', '2026-10-24 04:21:24'),
(168, NULL, '20ab62ee-25ed-4a84-9d26-e41342b94766', 'active', '2026-10-24 05:08:00', '2026-10-24 05:08:00'),
(169, NULL, 'd36461fa-8c4c-42b8-a966-a44eb0a80509', 'active', '2026-10-24 05:13:09', '2026-10-24 05:13:09'),
(170, NULL, '79198f5d-8c5e-4f2e-a737-3622de0a8e4b', 'active', '2026-10-24 05:13:27', '2026-10-24 05:13:27'),
(171, NULL, 'e68deb52-1265-44ed-aff1-38a15a74c4b9', 'active', '2026-10-24 05:13:57', '2026-10-24 05:13:57'),
(172, NULL, '7eb315c7-ef12-4d10-a91c-76d67455c5d5', 'active', '2026-10-24 05:14:19', '2026-10-24 05:14:19'),
(173, NULL, '77cd9f95-099e-46d9-b80f-170d5a15c9d4', 'active', '2026-10-24 05:14:19', '2026-10-24 05:14:19'),
(174, NULL, '6bf62593-5c04-4b80-aa37-12fc5ed30d6c', 'active', '2026-10-24 05:14:23', '2026-10-24 05:14:23'),
(175, NULL, 'dbabf0a0-a85d-453a-b38f-085b03de5a38', 'active', '2026-10-24 05:14:28', '2026-10-24 05:14:28'),
(176, NULL, '436e6456-838e-4d0b-a2e8-1aacb018883b', 'active', '2026-10-24 05:15:09', '2026-10-24 05:15:09'),
(177, NULL, '5224cda4-d433-4f1a-91e7-3449bcbf85e3', 'active', '2026-10-24 05:15:10', '2026-10-24 05:15:10'),
(178, NULL, '7a71d07c-cf88-4521-b1a4-422b1f6d6877', 'active', '2026-10-24 05:15:12', '2026-10-24 05:15:12'),
(179, NULL, 'b2146d2b-4e32-448c-80d3-a6bd9dd18313', 'active', '2026-10-24 05:15:13', '2026-10-24 05:15:13'),
(180, NULL, '3e1d80f7-7f0b-4d77-8e61-2600e0e51769', 'active', '2026-10-24 05:15:15', '2026-10-24 05:15:15'),
(181, NULL, '5be30818-1294-4490-95c2-413771eb07c3', 'active', '2026-10-24 05:15:18', '2026-10-24 05:15:18'),
(182, NULL, '68ab762a-6add-4d85-aeac-a4b6b2d305af', 'active', '2026-10-24 05:15:23', '2026-10-24 05:15:23'),
(183, NULL, 'd3aea3a3-23df-45c3-9ca5-0736326acc7d', 'active', '2026-10-24 05:15:28', '2026-10-24 05:15:28'),
(184, NULL, '5c5cc3b5-263c-4f32-b754-5bd06234b90e', 'active', '2026-10-24 05:15:29', '2026-10-24 05:15:29'),
(185, NULL, '767cc1a9-14c5-46f9-9c19-38674721ffa9', 'active', '2026-10-25 23:21:30', '2026-10-25 23:21:30'),
(186, NULL, '8f1c2fb0-4715-4e07-a4b7-a2a590db62f9', 'active', '2026-10-26 00:00:43', '2026-10-26 00:00:43'),
(187, NULL, '5f4355a2-a2c4-44c1-8a42-7195a8452791', 'active', '2026-10-26 00:00:44', '2026-10-26 00:00:44'),
(188, NULL, '4f1054f5-18f4-445b-95dd-3f376a184ff9', 'active', '2026-10-26 00:00:44', '2026-10-26 00:00:44'),
(189, NULL, 'eb920dd5-dfcc-4b91-b426-007027068eb1', 'active', '2026-10-26 00:00:45', '2026-10-26 00:00:45'),
(190, NULL, 'edb4b056-e1c4-4ee4-9c71-d2e7c2de42d0', 'active', '2026-10-26 00:00:45', '2026-10-26 00:00:45'),
(191, NULL, '0092b034-63ab-4c2c-bc5d-5bc203e86119', 'active', '2026-10-31 03:49:05', '2026-10-31 03:49:05'),
(192, NULL, '8030278a-887a-4a4a-9262-143be2187866', 'active', '2026-10-31 05:52:20', '2026-10-31 05:52:20'),
(193, NULL, '15160739-7c21-462d-800d-64a9c3f62824', 'active', '2026-10-31 05:52:21', '2026-10-31 05:52:21'),
(194, NULL, 'b59d878d-0d19-4ab3-892d-40b527e6f343', 'active', '2026-10-31 05:54:34', '2026-10-31 05:54:34'),
(195, NULL, 'cdf51180-4c11-4a99-970c-27596f3ca71c', 'active', '2026-10-31 05:54:35', '2026-10-31 05:54:35'),
(196, NULL, '9f6de9d9-51ca-4abc-8c72-327e1bb20445', 'active', '2026-10-31 06:29:14', '2026-10-31 06:29:14'),
(197, NULL, 'b025eea2-815e-4af9-abb8-fccc3cf85cbd', 'active', '2026-10-31 06:30:41', '2026-10-31 06:30:41'),
(198, NULL, '177b6e10-1f2c-408b-8f98-54afc6de71eb', 'active', '2026-10-31 06:31:53', '2026-10-31 06:31:53'),
(199, NULL, '8e7bfa2a-d2ea-414e-80ee-e54ee1f52963', 'active', '2026-10-31 06:36:20', '2026-10-31 06:36:20'),
(200, NULL, '3fff3955-896a-44d6-8ae9-9f52974fec61', 'active', '2026-10-31 06:37:20', '2026-10-31 06:37:20'),
(201, NULL, '3cb25a62-79be-4963-b0ed-456797715966', 'active', '2026-10-31 06:39:07', '2026-10-31 06:39:07'),
(202, NULL, 'bb85a23c-5e57-4a60-94bb-76401cdb0b0a', 'active', '2026-10-31 06:40:09', '2026-10-31 06:40:09'),
(203, NULL, 'fbfe90a8-7c24-4acf-b1c7-a1669166fb6d', 'active', '2026-10-31 06:42:45', '2026-10-31 06:42:45'),
(204, NULL, 'f087f34a-5ae3-47c6-93d0-0af1fe05debe', 'active', '2026-10-31 06:42:54', '2026-10-31 06:42:54'),
(205, NULL, '785302c4-69ae-4d0e-9831-acc4831fee5f', 'active', '2026-10-31 06:44:37', '2026-10-31 06:44:37'),
(206, NULL, 'bbd33399-7ed7-42e5-87f3-728e974a011b', 'active', '2026-10-31 06:45:24', '2026-10-31 06:45:24'),
(207, NULL, 'c5cb158e-2bdb-43e1-b466-57a4d6ae61a0', 'active', '2026-10-31 06:45:31', '2026-10-31 06:45:31'),
(208, NULL, '31c68919-4123-41f1-8886-ac862bd5b745', 'active', '2026-10-31 06:45:40', '2026-10-31 06:45:40'),
(209, NULL, '8b340f2f-a557-47e6-adfe-14fb2f64dddc', 'active', '2026-10-31 06:45:46', '2026-10-31 06:45:46'),
(210, NULL, '48166a47-7676-426c-9a25-0d3b932fecf1', 'active', '2026-10-31 06:46:13', '2026-10-31 06:46:13'),
(211, NULL, 'df946a6e-c509-43dd-997e-58a684a0a387', 'active', '2026-10-31 06:46:18', '2026-10-31 06:46:18'),
(212, NULL, '4bfcf5f0-2db7-4c7d-a9d2-7ce9504dc6f8', 'active', '2026-10-31 21:33:38', '2026-10-31 21:33:38'),
(213, NULL, '7013661e-ee9c-4e60-a901-7461c149604a', 'active', '2026-10-31 21:34:51', '2026-10-31 21:34:51'),
(214, NULL, '7a7c9044-a8f4-4bea-9a66-35c389e00198', 'active', '2026-10-31 21:34:52', '2026-10-31 21:34:52'),
(215, NULL, '8275ab56-91c9-4bfb-9c50-c7dcdf42c1f8', 'active', '2026-10-31 21:35:36', '2026-10-31 21:35:36'),
(216, NULL, '4b91ddbb-f96a-4ee6-aaf3-7734c83931b6', 'active', '2026-10-31 21:36:24', '2026-10-31 21:36:24'),
(217, NULL, 'be6cc964-a14a-4809-9207-d589c379cd18', 'active', '2026-10-31 21:39:45', '2026-10-31 21:39:45'),
(218, NULL, '75a5496e-f163-4c8e-badc-b1b19dbdab84', 'active', '2026-10-31 21:42:47', '2026-10-31 21:42:47'),
(219, NULL, 'aeae1cb6-f09e-4b60-a78e-632dce0d4d3d', 'active', '2026-10-31 21:47:02', '2026-10-31 21:47:02'),
(220, NULL, '0934a554-44da-4a3a-a281-ed151c87b0f1', 'active', '2026-10-31 21:47:06', '2026-10-31 21:47:06'),
(221, NULL, '98b5147f-de14-4402-9a45-6f1588204f3c', 'active', '2026-10-31 21:47:16', '2026-10-31 21:47:16'),
(222, NULL, '05e1dbda-9994-4844-b752-96e7b5988452', 'active', '2026-10-31 21:47:19', '2026-10-31 21:47:19'),
(223, NULL, '5bf01a22-ff97-4785-89f4-c6a06c040d0f', 'active', '2026-10-31 21:47:30', '2026-10-31 21:47:30'),
(224, NULL, '81e72c3a-42a7-44e1-8ea2-1ca270988472', 'active', '2026-10-31 21:47:53', '2026-10-31 21:47:53'),
(225, NULL, 'a6fc1680-ddb8-4901-87b3-c2c3d0488266', 'active', '2026-10-31 21:48:18', '2026-10-31 21:48:18'),
(226, NULL, '86fe32f3-1e5e-41af-b3a5-f56305933c6b', 'active', '2026-10-31 21:48:28', '2026-10-31 21:48:28'),
(227, NULL, 'c0519224-28ef-4e70-8774-df79723be458', 'active', '2026-10-31 21:48:55', '2026-10-31 21:48:55'),
(228, NULL, '8cbb0e29-84a4-42ad-9d90-fc2eaf461d55', 'active', '2026-10-31 21:49:04', '2026-10-31 21:49:04'),
(229, NULL, '4957427f-2c6d-4d35-937e-660c78e3fb87', 'active', '2026-10-31 21:49:15', '2026-10-31 21:49:15'),
(230, NULL, 'b0b080da-247f-4097-a08e-31152a0a3942', 'active', '2026-10-31 21:49:29', '2026-10-31 21:49:29'),
(231, NULL, '90f22bb4-d7c1-498b-bdd2-f2425da5d8b7', 'active', '2026-10-31 21:50:28', '2026-10-31 21:50:28'),
(232, NULL, 'b214cadf-a260-4b55-9bb4-8521999c7c90', 'active', '2026-10-31 21:52:01', '2026-10-31 21:52:01'),
(233, NULL, '445f37bf-790e-4cde-85c7-6c118eff0e75', 'active', '2026-10-31 21:54:54', '2026-10-31 21:54:54'),
(234, NULL, 'a1acac9c-39ce-40c0-b7f8-6579d3422325', 'active', '2026-10-31 21:55:24', '2026-10-31 21:55:24'),
(235, NULL, '0787b4ec-ee24-4bb4-a5d9-208df53aa42f', 'active', '2026-10-31 21:55:39', '2026-10-31 21:55:39'),
(236, NULL, '59620467-9e68-48ee-8048-9b8c03cedbdc', 'active', '2026-10-31 21:55:53', '2026-10-31 21:55:53'),
(237, NULL, '868828e2-9d6c-4f82-ac6a-d38db9fd1da6', 'active', '2026-10-31 21:56:11', '2026-10-31 21:56:11'),
(238, NULL, '3b868c6b-7502-4905-942c-9a249dea471f', 'active', '2026-10-31 21:57:06', '2026-10-31 21:57:06'),
(239, NULL, '3198f866-2e79-4c52-b393-a64452d5955e', 'active', '2026-10-31 21:57:11', '2026-10-31 21:57:11'),
(240, NULL, '87e2ffcb-a7c7-4dcf-a047-21e6aa760e4f', 'active', '2026-10-31 21:57:29', '2026-10-31 21:57:29'),
(241, NULL, '31af83d8-6078-4d86-8ab3-1675d8ea42a8', 'active', '2026-10-31 21:57:34', '2026-10-31 21:57:34'),
(242, NULL, '47989f69-d6b7-41d1-adcc-de7a2617aae3', 'active', '2026-10-31 21:58:05', '2026-10-31 21:58:05'),
(243, NULL, '29d4494b-09dc-4d08-9296-39a8520fcc9c', 'active', '2026-10-31 21:58:10', '2026-10-31 21:58:10'),
(244, NULL, 'c8200e83-9621-4dff-86c0-f18490380a92', 'active', '2026-10-31 21:58:28', '2026-10-31 21:58:28'),
(245, NULL, '62d7acf4-1679-401e-bda8-eb570836155b', 'active', '2026-10-31 21:58:32', '2026-10-31 21:58:32'),
(246, NULL, '294d52eb-fbf5-4b14-9b5c-e877885d177a', 'active', '2026-10-31 21:59:23', '2026-10-31 21:59:23'),
(247, NULL, '17908311-95c3-449b-9efc-99bf61cb0216', 'active', '2026-10-31 21:59:32', '2026-10-31 21:59:32'),
(248, NULL, '3a43cb8e-0a90-4bb4-b53a-7a6a0d9c15e9', 'active', '2026-10-31 22:02:47', '2026-10-31 22:02:47'),
(249, NULL, '23bff4de-cc3f-42c0-bb1a-33e8e9fda907', 'active', '2026-10-31 22:03:03', '2026-10-31 22:03:03'),
(250, NULL, 'ce06b6a9-7450-4221-bce5-dc756d950d74', 'active', '2026-10-31 22:03:17', '2026-10-31 22:03:17'),
(251, NULL, '56863fae-39e1-486a-9a40-0a002aa6246a', 'active', '2026-10-31 22:03:21', '2026-10-31 22:03:21'),
(252, NULL, '08e0c3b6-ce0a-48f9-9e16-24691b1d014f', 'active', '2026-10-31 22:03:36', '2026-10-31 22:03:36'),
(253, NULL, '82873962-f28b-48ce-a1c5-c7e48746d5d5', 'active', '2026-10-31 22:03:39', '2026-10-31 22:03:39'),
(254, NULL, '12d0b938-3dae-47b7-a519-23bcccb9d065', 'active', '2026-10-31 23:33:21', '2026-10-31 23:33:21'),
(255, NULL, '1845c38f-286b-4337-a094-ba0532454520', 'active', '2026-10-31 23:39:36', '2026-10-31 23:39:36'),
(256, NULL, 'e1405079-c9b1-4d4f-983e-182ab60a53dc', 'active', '2026-10-31 23:39:56', '2026-10-31 23:39:56'),
(257, NULL, '6013099e-5d8e-451a-a8c3-f959ca848d59', 'active', '2026-10-31 23:40:40', '2026-10-31 23:40:40'),
(258, NULL, 'cc843cd3-e6bd-4336-9ee0-d5568f5eaf17', 'active', '2026-10-31 23:43:21', '2026-10-31 23:43:21'),
(259, NULL, '6be166b6-6406-4b12-bb2d-6bc3d5177223', 'active', '2026-10-31 23:43:31', '2026-10-31 23:43:31'),
(260, NULL, 'c1f08de5-c3d3-445f-8615-a8003f9a2e98', 'active', '2026-10-31 23:43:38', '2026-10-31 23:43:38'),
(261, NULL, 'f920810d-83c7-4bee-b353-74011773438d', 'active', '2026-10-31 23:52:30', '2026-10-31 23:52:30'),
(262, NULL, 'aedbb7aa-a248-4fed-b125-29f23ee795d1', 'active', '2026-10-31 23:52:31', '2026-10-31 23:52:31'),
(263, NULL, 'c4c1af57-22fb-44b0-8ad2-bcf636b05e84', 'active', '2026-11-01 01:18:42', '2026-11-01 01:18:42'),
(264, NULL, '398c7c49-18a7-4369-9840-0ea0588d77af', 'active', '2026-11-01 01:19:17', '2026-11-01 01:19:17'),
(265, NULL, '3821b7c4-10b7-4a79-a834-f58f96e126ce', 'active', '2026-11-01 01:50:59', '2026-11-01 01:50:59'),
(266, NULL, '1948298d-b9ff-4a6c-a1b0-9181fced3804', 'active', '2026-11-01 03:23:38', '2026-11-01 03:23:38'),
(267, NULL, '4d9ee773-a90f-4162-be4d-00b81db1abbc', 'active', '2026-11-01 03:34:33', '2026-11-01 03:34:33'),
(268, NULL, '927e959b-87d1-47f1-b04f-f2cc4fc5dd9e', 'active', '2026-11-01 04:37:30', '2026-11-01 04:37:30'),
(269, NULL, '443e8431-8e5a-4308-b445-8277577e5f04', 'active', '2026-11-01 05:42:12', '2026-11-01 05:42:12'),
(270, NULL, '414d0ca5-7763-4675-a832-0658dc18568b', 'active', '2026-11-01 05:42:29', '2026-11-01 05:42:29'),
(271, NULL, '611661d8-dc56-4fc0-941e-9c8c6faac246', 'active', '2026-11-01 05:42:45', '2026-11-01 05:42:45'),
(272, NULL, '67dad903-6a55-4833-a727-3aaf865316aa', 'active', '2026-11-01 05:42:52', '2026-11-01 05:42:52'),
(273, NULL, 'b966c02f-af6c-4a5f-b101-cd1ee0b2fce8', 'active', '2026-11-01 05:42:56', '2026-11-01 05:42:56'),
(274, NULL, '614eb2ec-b3fb-4291-8291-872470b09aaa', 'active', '2026-11-01 05:47:51', '2026-11-01 05:47:51'),
(275, NULL, '9cd7c014-608f-4dd1-9a58-c3908a45dbb8', 'active', '2026-11-01 05:48:42', '2026-11-01 05:48:42'),
(276, NULL, '80e6a813-a7fd-4fb7-996d-0bb34bbeba61', 'active', '2026-11-01 05:49:56', '2026-11-01 05:49:56'),
(277, NULL, '724a4f8f-d1c5-4108-905a-d1bf755675e3', 'active', '2026-11-01 22:35:41', '2026-11-01 22:35:41'),
(278, NULL, 'b5296196-83f6-40f4-8aae-4f76bcf7cd25', 'active', '2026-11-01 22:43:14', '2026-11-01 22:43:14'),
(279, NULL, '21f80a22-4c2f-4c7a-9f55-2eb63dd5220c', 'active', '2026-11-01 22:44:15', '2026-11-01 22:44:15'),
(280, NULL, 'a9652c8f-b4aa-4c0d-a08b-c95d7a4411e4', 'active', '2026-11-01 22:44:18', '2026-11-01 22:44:18'),
(281, NULL, '5f575a67-acb0-4551-81f2-c1e39c7352c9', 'active', '2026-11-01 23:46:17', '2026-11-01 23:46:17'),
(282, NULL, 'f589e032-0576-41d2-b43f-a8da53d8c658', 'active', '2026-11-02 03:19:00', '2026-11-02 03:19:00'),
(283, NULL, 'da1e0589-bab7-4884-bb5f-450336b2b60b', 'active', '2026-11-02 04:34:33', '2026-11-02 04:34:33'),
(284, NULL, 'c11ab973-9dc3-4ce5-aac6-44bb90f5e8ae', 'active', '2026-11-02 04:34:50', '2026-11-02 04:34:50'),
(285, NULL, '477cf83a-e4a3-4f0a-8736-f74e89308cfe', 'active', '2026-11-02 04:34:51', '2026-11-02 04:34:51'),
(286, NULL, '1a5909ce-06a7-4ff5-8501-689f831ab3c2', 'active', '2026-11-02 04:36:05', '2026-11-02 04:36:05'),
(287, NULL, '73d3e95a-3a7b-4998-97bd-c773daa4444c', 'active', '2026-11-02 04:36:16', '2026-11-02 04:36:16'),
(288, NULL, 'da798114-a1e5-477c-af90-211bba13030d', 'active', '2026-11-02 04:37:11', '2026-11-02 04:37:11'),
(289, NULL, 'dbd2c963-442e-44b2-8e78-ed1841d5fc6b', 'active', '2026-11-02 04:37:16', '2026-11-02 04:37:16'),
(290, NULL, '512829d1-9b31-4e2a-a582-1928d5b9e3a1', 'active', '2026-11-02 04:37:18', '2026-11-02 04:37:18'),
(291, NULL, '67a47c9f-d58c-45d5-972c-77cd8937ae40', 'active', '2026-11-02 04:37:23', '2026-11-02 04:37:23'),
(292, NULL, '313c1989-29b2-457b-8637-2ba67c4ccb65', 'active', '2026-11-02 04:37:45', '2026-11-02 04:37:45'),
(293, NULL, 'a995346b-eab3-41fa-ae21-495666f9dbbf', 'active', '2026-11-02 04:38:33', '2026-11-02 04:38:33'),
(294, NULL, 'bb36fb2a-d549-4840-8cc7-8d69c0c76b74', 'active', '2026-11-02 04:39:07', '2026-11-02 04:39:07'),
(295, NULL, '7e8aab80-d4c1-4da6-b4a1-d0ac513a5f67', 'active', '2026-11-02 04:41:29', '2026-11-02 04:41:29'),
(296, NULL, '7e3d294a-91fc-4fd0-9718-76aba664a083', 'active', '2026-11-02 04:49:11', '2026-11-02 04:49:11'),
(297, NULL, '575cf3d2-201e-4233-81dc-c10c60c72365', 'active', '2026-11-02 04:58:14', '2026-11-02 04:58:14'),
(298, NULL, 'df55c3fd-14eb-4e63-becc-60fd7a1966d8', 'active', '2026-11-02 05:04:16', '2026-11-02 05:04:16'),
(299, NULL, '67902b5c-f814-4832-988d-56a9984f3624', 'active', '2026-11-02 05:05:58', '2026-11-02 05:05:58'),
(300, NULL, '2fbb8384-4d2f-423f-9bbf-d1bf5716caaa', 'active', '2026-11-02 05:07:55', '2026-11-02 05:07:55'),
(301, NULL, 'fb2ab2a4-c0aa-4440-b696-70924bc4a0fa', 'active', '2026-11-02 05:10:13', '2026-11-02 05:10:13'),
(302, NULL, 'c4f87eac-e21d-4fd0-8e32-60ba531ef790', 'active', '2026-11-02 05:32:41', '2026-11-02 05:32:41'),
(303, NULL, '2569d517-5c14-4beb-b943-47b353718c75', 'active', '2026-11-02 05:37:28', '2026-11-02 05:37:28'),
(304, NULL, '632fcc2e-9fa0-4a3d-9ef7-20e09b22ba60', 'active', '2026-11-02 05:37:42', '2026-11-02 05:37:42'),
(305, NULL, '7602b535-40be-49f0-a772-e676185351e9', 'active', '2026-11-02 05:37:54', '2026-11-02 05:37:54'),
(306, NULL, '34b8e704-9f3a-4a63-9917-0b40f7a47f7e', 'active', '2026-11-02 05:38:42', '2026-11-02 05:38:42'),
(307, NULL, 'f2d77dae-9ec2-43e9-adc7-15decf1d4ac9', 'active', '2026-11-02 05:38:53', '2026-11-02 05:38:53'),
(308, NULL, '448e8c01-78c3-453d-bb71-780b90ff8639', 'active', '2026-11-02 05:38:57', '2026-11-02 05:38:57'),
(309, NULL, '15e47bf2-64c9-4494-a693-46f461c54cf4', 'active', '2026-11-02 05:39:57', '2026-11-02 05:39:57'),
(310, NULL, '744f2ecd-6bf1-46b6-b33e-8e14582d0518', 'active', '2026-11-02 05:41:14', '2026-11-02 05:41:14'),
(311, NULL, '9bcb45a7-8a6e-4c96-9b6f-710d7b8ef45f', 'active', '2026-11-02 05:41:35', '2026-11-02 05:41:35'),
(312, NULL, '10bced4e-4e43-4731-88cf-0f93b772b7f6', 'active', '2026-11-02 05:42:01', '2026-11-02 05:42:01'),
(313, NULL, 'b097be82-70c8-4890-9305-e236a8464769', 'active', '2026-11-02 05:42:01', '2026-11-02 05:42:01'),
(314, NULL, '8cb16bf2-6860-4d2b-8583-c8a264c58471', 'active', '2026-11-02 05:42:08', '2026-11-02 05:42:08'),
(315, NULL, '9e81f75e-5eaf-4a3f-8635-a90448845cb0', 'active', '2026-11-02 05:42:09', '2026-11-02 05:42:09'),
(316, NULL, '206a9dcc-d5c0-4f71-a27b-3404f87c4616', 'active', '2026-11-02 06:44:54', '2026-11-02 06:44:54'),
(317, NULL, '7fea00cd-2241-4b61-a836-689d3524fc4f', 'active', '2026-11-02 06:44:55', '2026-11-02 06:44:55'),
(318, NULL, 'e34bf39c-a8e2-494b-a09a-2068069ef303', 'active', '2026-11-02 06:45:36', '2026-11-02 06:45:36'),
(319, NULL, '82402ce0-e62b-44af-b9a4-e92c1fac4bae', 'active', '2026-11-02 06:45:37', '2026-11-02 06:45:37'),
(320, NULL, '414b8ac9-29fb-4322-bbed-28d4816b7b50', 'active', '2026-11-02 06:45:43', '2026-11-02 06:45:43'),
(321, NULL, 'b9a2d7bc-9b48-4d8e-923d-deaa04826fde', 'active', '2026-11-02 06:45:44', '2026-11-02 06:45:44'),
(322, NULL, '55dba501-f66f-4a0d-8a07-775053a7b8da', 'active', '2026-11-02 06:45:59', '2026-11-02 06:45:59'),
(323, NULL, '28059512-2205-4ca2-93f7-9802f3d9f829', 'active', '2026-11-02 06:46:00', '2026-11-02 06:46:00'),
(324, NULL, 'b878c64e-abb6-479a-901e-890fed9ce65c', 'active', '2026-11-02 06:52:23', '2026-11-02 06:52:23'),
(325, NULL, '1ed611c0-d192-41e2-a7b7-5b0fa5aea2ce', 'active', '2026-11-02 06:52:24', '2026-11-02 06:52:24'),
(326, NULL, '189e667a-7615-4f73-a0aa-651a5700f652', 'active', '2026-11-02 06:52:33', '2026-11-02 06:52:33'),
(327, NULL, '99810862-22f5-485f-834b-309052d0b0fa', 'active', '2026-11-02 06:52:34', '2026-11-02 06:52:34'),
(328, NULL, '290d428a-afb5-4cb7-8f85-55ed20c190d2', 'active', '2026-11-02 06:52:55', '2026-11-02 06:52:55'),
(329, NULL, 'e4a70f87-be65-406e-ac52-ec6affbd8fe6', 'active', '2026-11-02 06:52:56', '2026-11-02 06:52:56'),
(330, NULL, '06107ff6-486e-4ac7-b326-57f534353d2f', 'active', '2026-11-02 06:57:17', '2026-11-02 06:57:17'),
(331, NULL, '09435073-c0a7-46f9-bb01-afbb291936a9', 'active', '2026-11-02 06:57:18', '2026-11-02 06:57:18'),
(332, NULL, 'a8cb96ae-e99a-4a7b-8511-118249721965', 'active', '2026-11-02 06:57:21', '2026-11-02 06:57:21'),
(333, NULL, '95f4b67d-c6ef-4702-b794-b8a230daefb3', 'active', '2026-11-02 06:57:22', '2026-11-02 06:57:22'),
(334, NULL, 'cdfd5adf-529a-4dd4-9ebb-7d7a33f35f5b', 'active', '2026-11-02 06:57:27', '2026-11-02 06:57:27'),
(335, NULL, 'df1c1f10-d2e4-4f70-856f-c00f0a9d9053', 'active', '2026-11-02 06:57:28', '2026-11-02 06:57:28'),
(336, NULL, '58ffb607-99fb-4433-9419-82419d3e0580', 'active', '2026-11-02 06:57:36', '2026-11-02 06:57:36'),
(337, NULL, '429ee95c-5007-4210-bea4-5eb1a989d00d', 'active', '2026-11-02 06:57:37', '2026-11-02 06:57:37'),
(338, NULL, '6c4a2d67-9584-4294-8e58-95c3fcb514f6', 'active', '2026-11-02 06:58:14', '2026-11-02 06:58:14'),
(339, NULL, '9a2bc545-1606-4053-82a0-1ac4e7f487db', 'active', '2026-11-02 06:58:15', '2026-11-02 06:58:15'),
(340, NULL, 'fd1bd6dd-cfe5-4d31-94e9-f60305db4eb2', 'active', '2026-11-02 07:04:18', '2026-11-02 07:04:18'),
(341, NULL, '3d132bdb-a55e-4ca6-b525-b9b68673b090', 'active', '2026-11-02 07:04:19', '2026-11-02 07:04:19'),
(342, NULL, '7923fd67-be0c-4ed1-bbda-873c9fe1a852', 'active', '2026-11-02 21:06:49', '2026-11-02 21:06:49'),
(343, NULL, '5d05e673-51a3-4a91-8bab-514513eaf99b', 'active', '2026-11-02 21:20:56', '2026-11-02 21:20:56'),
(344, NULL, 'f6b9a5d9-c78d-4f26-a0d8-b147ce6c1e7d', 'active', '2026-11-02 21:20:57', '2026-11-02 21:20:57'),
(345, NULL, 'd617d163-e889-4dd9-b7dc-a3fb2b54de7f', 'active', '2026-11-02 21:51:54', '2026-11-02 21:51:54'),
(346, NULL, 'dfdfe686-1024-4a9e-80b5-455129a00fa9', 'active', '2026-11-02 21:51:54', '2026-11-02 21:51:54'),
(347, NULL, '36f4cd62-8d34-4a4a-b47c-54e9fdd88738', 'active', '2026-11-02 21:51:57', '2026-11-02 21:51:57'),
(348, NULL, 'c9b828e2-cbac-491c-9415-6f52b318a8cb', 'active', '2026-11-02 21:51:58', '2026-11-02 21:51:58'),
(349, NULL, 'de71548b-2416-4aab-8174-38734fd59566', 'active', '2026-11-02 21:52:06', '2026-11-02 21:52:06'),
(350, NULL, '7bb09b06-f144-41e4-a777-0f7fad4a9509', 'active', '2026-11-02 21:52:08', '2026-11-02 21:52:08'),
(351, NULL, '7f4e7ec9-a3b6-450e-a011-e1a2c7933c0d', 'active', '2026-11-02 21:52:09', '2026-11-02 21:52:09'),
(352, NULL, '91e9bb01-1411-409e-97d6-9b513adf3187', 'active', '2026-11-02 21:56:57', '2026-11-02 21:56:57'),
(353, NULL, '32846094-573a-4e50-846b-f2f46d3471e4', 'active', '2026-11-02 21:56:58', '2026-11-02 21:56:58'),
(354, NULL, '57378cbf-b9f4-4bc6-bd37-3fb410a4332c', 'active', '2026-11-02 21:57:05', '2026-11-02 21:57:05'),
(355, NULL, '846baa5e-06c1-4462-b31a-94cead0f2cf3', 'active', '2026-11-02 21:57:21', '2026-11-02 21:57:21'),
(356, NULL, '0b5bb20e-4c16-4eec-a486-14d17d9c84b9', 'active', '2026-11-02 21:58:04', '2026-11-02 21:58:04'),
(357, NULL, '315b1d6c-9871-4ea4-84bf-1588b68281e9', 'active', '2026-11-02 21:58:05', '2026-11-02 21:58:05'),
(358, NULL, 'bcc11b1d-4f06-42ce-b862-14525c80fa40', 'active', '2026-11-02 21:58:44', '2026-11-02 21:58:44'),
(359, NULL, 'fbe811e5-18e3-4d53-a0b9-8c08d03badf2', 'active', '2026-11-02 21:59:36', '2026-11-02 21:59:36'),
(360, NULL, '059f38b1-d82e-4646-8844-d9b361422ce4', 'active', '2026-11-02 21:59:39', '2026-11-02 21:59:39'),
(361, NULL, '8c37f51d-f522-4fad-9586-8ccecc1646cd', 'active', '2026-11-02 22:00:04', '2026-11-02 22:00:04'),
(362, NULL, '6c0b161e-0293-41d1-9a2e-8b18e8a85504', 'active', '2026-11-02 22:00:34', '2026-11-02 22:00:34'),
(363, NULL, 'e9f22aa9-d5ea-4ae9-9c85-ccac0a2011d1', 'active', '2026-11-02 22:00:38', '2026-11-02 22:00:38'),
(364, NULL, '331ffdf0-5cf2-4a13-ad72-b7378305cf2f', 'active', '2026-11-02 22:00:42', '2026-11-02 22:00:42'),
(365, NULL, 'f6cbbdd9-6d9d-4ce8-9933-8cdc4a819347', 'active', '2026-11-02 22:00:46', '2026-11-02 22:00:46'),
(366, NULL, '4b4d9b1e-1a57-4560-b47d-b429cde3b6a8', 'active', '2026-11-02 22:01:36', '2026-11-02 22:01:36'),
(367, NULL, 'e9be9d1e-7241-4174-b164-9be6a35924d7', 'active', '2026-11-02 22:01:37', '2026-11-02 22:01:37'),
(368, NULL, '89ee9536-cf78-4c59-a900-6b9fc11421a2', 'active', '2026-11-02 22:01:45', '2026-11-02 22:01:45'),
(369, NULL, '086d2e90-cd5a-4780-8e6e-8a130598c895', 'active', '2026-11-02 22:01:46', '2026-11-02 22:01:46'),
(370, NULL, '2cbfe73d-0592-4f15-be5b-469ccf320730', 'active', '2026-11-02 22:01:55', '2026-11-02 22:01:55'),
(371, NULL, '8447000e-3a50-4805-afc7-e89bccc7250d', 'active', '2026-11-02 22:01:57', '2026-11-02 22:01:57'),
(372, NULL, '6caa446f-da72-459b-a5e5-c64f49eaa136', 'active', '2026-11-02 22:04:38', '2026-11-02 22:04:38'),
(373, NULL, '11be8e18-481d-49fe-b9f4-4aa1fce6d81b', 'active', '2026-11-02 22:04:50', '2026-11-02 22:04:50'),
(374, NULL, 'cc8c903c-6a2c-4e72-aee8-b77a0cedefd0', 'active', '2026-11-02 22:04:50', '2026-11-02 22:04:50'),
(375, NULL, '6361be34-e1a6-4ddf-aec7-4fbae19d01b8', 'active', '2026-11-02 22:04:59', '2026-11-02 22:04:59'),
(376, NULL, '37229207-9991-45d1-af11-1a3f2669e82c', 'active', '2026-11-02 22:05:38', '2026-11-02 22:05:38'),
(377, NULL, '391acc9c-4e44-4db6-85d1-8a3515b6ba7c', 'active', '2026-11-02 22:05:39', '2026-11-02 22:05:39'),
(378, NULL, '504c3fb2-909f-45aa-a187-eb014819de9c', 'active', '2026-11-02 22:05:49', '2026-11-02 22:05:49'),
(379, NULL, 'd7368736-a7b8-4e86-8c9c-13b45128c399', 'active', '2026-11-02 22:06:08', '2026-11-02 22:06:08'),
(380, NULL, '694a636b-2738-4f97-9271-c5f3e7023077', 'active', '2026-11-02 22:13:28', '2026-11-02 22:13:28'),
(381, NULL, 'df186a20-bea9-41d0-b0da-43087a053b5f', 'active', '2026-11-02 22:13:29', '2026-11-02 22:13:29'),
(382, NULL, 'dbf86bd8-6e4e-4e5e-a89b-b3a50b4c3a53', 'active', '2026-11-02 22:13:44', '2026-11-02 22:13:44'),
(383, NULL, 'd7812692-bbb9-4eb2-95d7-8ab881cdf8ec', 'active', '2026-11-02 22:14:11', '2026-11-02 22:14:11'),
(384, NULL, '5be6094d-d0e5-4b93-81bf-c2f0f448bd6d', 'active', '2026-11-02 22:14:12', '2026-11-02 22:14:12'),
(385, NULL, '0484c510-f1dc-4678-aba8-30d8732d6d41', 'active', '2026-11-02 22:14:19', '2026-11-02 22:14:19'),
(386, NULL, 'e6cc79a5-fb5f-4706-9a7f-23ef5b3f8f9b', 'active', '2026-11-02 22:14:39', '2026-11-02 22:14:39'),
(387, NULL, '6a9307cd-1a61-486f-bd0b-287d9aaab00e', 'active', '2026-11-02 22:15:04', '2026-11-02 22:15:04'),
(388, NULL, 'f2e16db4-8278-44a3-bab0-cc016bb152c7', 'active', '2026-11-02 22:15:04', '2026-11-02 22:15:04'),
(389, NULL, '98bb9d08-15cd-4d99-9309-fba0f1653323', 'active', '2026-11-02 22:15:23', '2026-11-02 22:15:23'),
(390, NULL, 'dbec30e2-c00e-49e8-9627-d195a3d1e514', 'active', '2026-11-02 22:15:23', '2026-11-02 22:15:23'),
(391, NULL, 'bdcbddae-8330-4a93-8064-07f81c0dc3bc', 'active', '2026-11-02 22:15:28', '2026-11-02 22:15:28'),
(392, NULL, '0cfeabb5-bbb7-4485-9d56-a5c338ff6116', 'active', '2026-11-02 22:15:33', '2026-11-02 22:15:33'),
(393, NULL, 'f12ec502-bd76-4897-80d5-d18c256dc315', 'active', '2026-11-02 22:15:33', '2026-11-02 22:15:33'),
(394, NULL, '5e87cc1d-f026-494b-906d-6d269033b9a4', 'active', '2026-11-02 22:15:47', '2026-11-02 22:15:47'),
(395, NULL, 'f5e3900a-6aad-4c94-aa5d-923e26311400', 'active', '2026-11-02 22:15:49', '2026-11-02 22:15:49'),
(396, NULL, '1a880271-2b2c-4edf-a223-4526f765783e', 'active', '2026-11-02 22:15:50', '2026-11-02 22:15:50'),
(397, NULL, '941ee33b-babc-4232-8d58-1c5c1bd226d1', 'active', '2026-11-02 22:16:04', '2026-11-02 22:16:04'),
(398, NULL, 'e96b9687-09c5-4ce3-957a-9eb4decd93f4', 'active', '2026-11-02 22:16:08', '2026-11-02 22:16:08'),
(399, NULL, '1f8cf0be-2805-45c1-b34c-7bc66dcfb51d', 'active', '2026-11-02 22:16:18', '2026-11-02 22:16:18'),
(400, NULL, '31851692-dd83-4952-9364-27333ed5d6b6', 'active', '2026-11-02 22:16:19', '2026-11-02 22:16:19'),
(401, NULL, '91303032-44e8-4995-ab11-50d1ade175ae', 'active', '2026-11-02 22:16:36', '2026-11-02 22:16:36'),
(402, NULL, '9deff938-c823-44be-91d0-c069c2efbe6a', 'active', '2026-11-02 22:16:37', '2026-11-02 22:16:37'),
(403, NULL, 'b2cb9d17-dfaa-4404-8334-cfd6ce976c07', 'active', '2026-11-02 22:16:53', '2026-11-02 22:16:53'),
(404, NULL, '1fb82152-5d00-4502-8166-7c487132b23c', 'active', '2026-11-02 22:16:54', '2026-11-02 22:16:54'),
(405, NULL, 'b5b7e177-b1c3-4a76-a4b2-97179cc6ccd1', 'active', '2026-11-02 22:17:18', '2026-11-02 22:17:18'),
(406, NULL, '0563d860-48b5-4f2d-b351-8228cadece89', 'active', '2026-11-02 22:18:21', '2026-11-02 22:18:21'),
(407, NULL, '429961e9-dfe3-4d59-a457-b3d2fffebc09', 'active', '2026-11-02 22:41:09', '2026-11-02 22:41:09'),
(408, NULL, '991346a6-a8de-4bab-847e-5bb85d02635e', 'active', '2026-11-02 22:41:10', '2026-11-02 22:41:10'),
(409, NULL, '43d9ad36-b0fc-4686-840a-0269fffb3784', 'active', '2026-11-02 22:42:37', '2026-11-02 22:42:37'),
(410, NULL, 'cd7a84af-5e31-4446-b9e4-22262779a941', 'active', '2026-11-02 22:42:38', '2026-11-02 22:42:38'),
(411, NULL, '99168a23-edb8-4f7d-9bfe-7f76e4599da6', 'active', '2026-11-02 22:42:42', '2026-11-02 22:42:42'),
(412, NULL, '8568d4da-0ac5-45fc-94ff-557830934565', 'active', '2026-11-02 22:42:45', '2026-11-02 22:42:45'),
(413, NULL, '1f629818-e7c7-4eae-8b95-82de8d450348', 'active', '2026-11-02 22:58:33', '2026-11-02 22:58:33'),
(414, NULL, '9a27fce9-b8f7-4624-9f20-36e6963c2ac1', 'active', '2026-11-02 22:58:34', '2026-11-02 22:58:34'),
(415, NULL, 'a6287a9d-73e3-4cb7-a17d-322042f46617', 'active', '2026-11-02 22:58:42', '2026-11-02 22:58:42'),
(416, NULL, '5534eeab-4a65-4871-8a8d-8168660db723', 'active', '2026-11-02 22:59:41', '2026-11-02 22:59:41'),
(417, NULL, '56454988-1f27-492d-85e5-935ea47f13f9', 'active', '2026-11-02 22:59:44', '2026-11-02 22:59:44'),
(418, NULL, '86442ee2-4ac1-435f-ab09-49092bc1dfd8', 'active', '2026-11-02 22:59:48', '2026-11-02 22:59:48'),
(419, NULL, '0267c41f-7acd-44cd-b679-a28e09013f0c', 'active', '2026-11-02 22:59:50', '2026-11-02 22:59:50'),
(420, NULL, '9d0a1ae4-4294-490f-8b70-2e73cb7d82fa', 'active', '2026-11-02 22:59:52', '2026-11-02 22:59:52'),
(421, NULL, '0e5b5f50-cab1-4d55-98b2-68b5b06c3d93', 'active', '2026-11-02 22:59:54', '2026-11-02 22:59:54'),
(422, NULL, '4a330286-f407-4a88-a431-61822e39d544', 'active', '2026-11-02 22:59:55', '2026-11-02 22:59:55'),
(423, NULL, 'aff79d54-48cd-48dc-95d3-c39adcf4a7be', 'active', '2026-11-02 22:59:57', '2026-11-02 22:59:57'),
(424, NULL, '4193983d-9dcc-4928-a602-ccfb9ec5ac12', 'active', '2026-11-02 22:59:59', '2026-11-02 22:59:59'),
(425, NULL, '6feb4b33-e992-46ed-9d29-c0c7699ed4ea', 'active', '2026-11-02 23:00:11', '2026-11-02 23:00:11'),
(426, NULL, '7ed7424a-8404-437c-98a1-1353df0fdb24', 'active', '2026-11-02 23:01:44', '2026-11-02 23:01:44'),
(427, NULL, '4fa2712f-5f59-4c9e-86e2-9bc4a4e650ed', 'active', '2026-11-02 23:01:51', '2026-11-02 23:01:51'),
(428, NULL, 'f6ee46b5-205f-4b0a-a28d-672977d5e4e4', 'active', '2026-11-02 23:02:53', '2026-11-02 23:02:53'),
(429, NULL, '815ea054-b130-4621-af4e-6f3b0f7c66ea', 'active', '2026-11-02 23:03:04', '2026-11-02 23:03:04'),
(430, NULL, 'e2742d50-72cb-4df7-a948-4646d97d1714', 'active', '2026-11-02 23:03:06', '2026-11-02 23:03:06'),
(431, NULL, '726d6a95-af2b-4314-bd69-d1d0816ca6a3', 'active', '2026-11-02 23:05:44', '2026-11-02 23:05:44'),
(432, NULL, '54f1fcb9-e5b6-4039-96bd-b45dec04a932', 'active', '2026-11-02 23:06:43', '2026-11-02 23:06:43'),
(433, NULL, 'a5b78f74-2e64-4398-98f7-48ab587c92fb', 'active', '2026-11-02 23:35:54', '2026-11-02 23:35:54'),
(434, NULL, 'fa118d3a-bbd7-45f0-a4f5-b5c8cf931e14', 'active', '2026-11-02 23:35:58', '2026-11-02 23:35:58'),
(435, NULL, 'baed7876-3a8f-4f71-9db4-0928a073cfc4', 'active', '2026-11-02 23:36:09', '2026-11-02 23:36:09'),
(436, NULL, '0d785e09-ea62-4c09-bab0-2bf631239368', 'active', '2026-11-02 23:37:21', '2026-11-02 23:37:21'),
(437, NULL, 'fec2e9dc-baff-44df-8c9a-5d2f8f1927f9', 'active', '2026-11-02 23:37:28', '2026-11-02 23:37:28'),
(438, NULL, '64272bb7-0ca0-446e-871a-19b092f20c94', 'active', '2026-11-02 23:38:41', '2026-11-02 23:38:41'),
(439, NULL, 'f1062922-2eb2-4994-a83b-bdad2b31ab59', 'active', '2026-11-02 23:40:06', '2026-11-02 23:40:06'),
(440, NULL, 'ef1dfbe0-8e20-4502-90e2-0619c6d0d9f5', 'active', '2026-11-02 23:59:26', '2026-11-02 23:59:26'),
(441, NULL, '022b9147-7a2d-4709-bf13-6ce2b20e81d5', 'active', '2026-11-03 00:02:59', '2026-11-03 00:02:59'),
(442, NULL, 'd4730e88-c2b9-41ef-a04b-850f7e359216', 'active', '2026-11-03 00:03:46', '2026-11-03 00:03:46'),
(443, NULL, '8ae4fcaf-1d5b-420e-acba-d20bda91654a', 'active', '2026-11-03 00:03:47', '2026-11-03 00:03:47'),
(444, NULL, '5a4f8b17-86cf-41cb-b284-200338e3867c', 'active', '2026-11-03 00:05:38', '2026-11-03 00:05:38'),
(445, NULL, '042f6a39-ba47-4b6d-af6a-5582b7dc6a2a', 'active', '2026-11-03 00:17:10', '2026-11-03 00:17:10'),
(446, NULL, '2b1587ef-ddd5-4e56-9996-7e3d13379592', 'active', '2026-11-03 00:21:00', '2026-11-03 00:21:00'),
(447, NULL, 'd9ded56f-1853-42fc-ad43-115fb7f144a5', 'active', '2026-11-03 00:21:01', '2026-11-03 00:21:01'),
(448, NULL, 'c099f180-1c5c-4a47-8483-b9b15ff326bf', 'active', '2026-11-03 00:28:28', '2026-11-03 00:28:28'),
(449, NULL, '6aa6c49a-70ee-44d9-803c-3be351f79f7e', 'active', '2026-11-03 00:28:31', '2026-11-03 00:28:31'),
(450, NULL, 'ac8beb4d-878d-4a12-af4e-58e97d9040ff', 'active', '2026-11-03 00:28:56', '2026-11-03 00:28:56'),
(451, NULL, '17185f8b-d4d8-4b51-8bf1-7a5e686cdb0f', 'active', '2026-11-03 00:29:06', '2026-11-03 00:29:06'),
(452, NULL, '6d142509-17fc-468f-80e9-d79b56038c61', 'active', '2026-11-03 00:29:08', '2026-11-03 00:29:08'),
(453, NULL, '6b67199b-b536-4d34-9872-c040c8a97727', 'active', '2026-11-03 00:29:13', '2026-11-03 00:29:13'),
(454, NULL, 'c6c1006f-ca94-43bf-adb9-d857e10b36d6', 'active', '2026-11-03 00:29:19', '2026-11-03 00:29:19'),
(455, NULL, 'f3833b12-58ee-4bf1-9b7d-d95ca0315ea6', 'active', '2026-11-03 00:29:27', '2026-11-03 00:29:27'),
(456, NULL, 'baa3f388-273b-4953-b4a6-945935b3fda1', 'active', '2026-11-03 00:29:32', '2026-11-03 00:29:32'),
(457, NULL, 'd0e37c9c-1825-4960-8841-62cda9a1a3d8', 'active', '2026-11-03 00:29:43', '2026-11-03 00:29:43'),
(458, NULL, '58f99dd3-f5cf-4a7d-8109-5d04874eb59a', 'active', '2026-11-03 00:33:37', '2026-11-03 00:33:37'),
(459, NULL, '2a56fafa-9d9b-4ea7-b175-27aaf871b593', 'active', '2026-11-03 00:34:00', '2026-11-03 00:34:00'),
(460, NULL, 'bd9487cd-e97f-4c5e-b6f7-64815cd9c090', 'active', '2026-11-03 00:34:38', '2026-11-03 00:34:38'),
(461, NULL, '8b92477b-d1d3-48b5-85f6-c1f340608434', 'active', '2026-11-03 00:35:17', '2026-11-03 00:35:17'),
(462, NULL, '295dce6f-1156-48c4-9795-9547a5f2860d', 'active', '2026-11-03 00:35:28', '2026-11-03 00:35:28'),
(463, NULL, 'dca48e0d-5f85-4427-a8d8-fced34be5ea7', 'active', '2026-11-03 00:41:18', '2026-11-03 00:41:18'),
(464, NULL, '8d2dfff9-bfea-446f-a3e3-3180f458a77c', 'active', '2026-11-03 00:43:09', '2026-11-03 00:43:09'),
(465, NULL, '0069551d-dd69-42aa-af22-a97c22b8c1a1', 'active', '2026-11-03 00:43:51', '2026-11-03 00:43:51'),
(466, NULL, '3d16c727-847f-41e2-9094-8ffef56fbe9c', 'active', '2026-11-03 00:46:02', '2026-11-03 00:46:02'),
(467, NULL, 'b672af0a-0216-4bc7-aa46-5bcb40b82f96', 'active', '2026-11-03 00:47:18', '2026-11-03 00:47:18');
INSERT INTO `carts` (`id`, `customer_id`, `session_id`, `status`, `created_at`, `updated_at`) VALUES
(468, NULL, '86e0be06-6197-43b1-b1e6-b80d429b41fe', 'active', '2026-11-03 00:51:47', '2026-11-03 00:51:47'),
(469, NULL, 'a6da1ef4-09c7-466d-ae93-f4f0a843eae2', 'active', '2026-11-03 02:26:33', '2026-11-03 02:26:33'),
(470, NULL, '4470feea-e12e-4dbc-a578-a87c26c4e0e4', 'active', '2026-11-03 02:26:48', '2026-11-03 02:26:48'),
(471, NULL, '3ae01fa8-0fca-4138-9150-15cfbeedce98', 'active', '2026-11-03 02:28:17', '2026-11-03 02:28:17'),
(472, NULL, 'a50c06fc-3970-4052-9297-a17094116600', 'active', '2026-11-03 02:28:52', '2026-11-03 02:28:52'),
(473, NULL, '28ee0615-9340-4075-964a-3254a5dc6875', 'active', '2026-11-03 02:29:16', '2026-11-03 02:29:16'),
(474, NULL, '6289e268-19a8-4afd-aa1c-d4eb106458da', 'active', '2026-11-03 02:29:21', '2026-11-03 02:29:21'),
(475, NULL, 'bd09eb96-df5b-4a93-a8b8-c39f138a9eeb', 'active', '2026-11-03 02:29:30', '2026-11-03 02:29:30'),
(476, NULL, '1ee54502-4bfc-4538-b673-b8dc8e3a279f', 'active', '2026-11-03 02:29:34', '2026-11-03 02:29:34'),
(477, NULL, 'b148a022-1987-4c78-9bcc-6824e357bd25', 'active', '2026-11-03 02:29:51', '2026-11-03 02:29:51'),
(478, NULL, '254358c4-56b9-4dca-90aa-2a1e926fa0a5', 'active', '2026-11-03 02:36:01', '2026-11-03 02:36:01'),
(479, NULL, 'fd81842d-6e7c-4354-9b6e-a4deca5ec6b5', 'active', '2026-11-03 02:36:09', '2026-11-03 02:36:09'),
(480, NULL, '2c747a88-45c0-413a-9052-537ddd0c1e3b', 'active', '2026-11-03 02:38:09', '2026-11-03 02:38:09'),
(481, NULL, 'caa5bc3b-e286-4918-a215-7713c72ab25c', 'active', '2026-11-03 02:38:22', '2026-11-03 02:38:22'),
(482, NULL, '3104da46-6067-4b59-9387-5cdcf700bb9d', 'active', '2026-11-03 02:39:19', '2026-11-03 02:39:19'),
(483, NULL, 'b14bc33a-96c6-4c3b-8fea-304710ce27fd', 'active', '2026-11-03 03:13:01', '2026-11-03 03:13:01'),
(484, NULL, 'dccd9500-2a99-465b-9698-539abf89707d', 'active', '2026-11-03 03:13:17', '2026-11-03 03:13:17'),
(485, NULL, '501fd0ff-d30c-427e-a767-c5e2f0d9d5b2', 'active', '2026-11-03 03:13:30', '2026-11-03 03:13:30'),
(486, NULL, '73854cae-00bd-49a6-bb16-d7416749f2d6', 'active', '2026-11-03 03:14:18', '2026-11-03 03:14:18'),
(487, NULL, '7768af25-65e9-4258-8e3d-e274bc253930', 'active', '2026-11-03 03:14:20', '2026-11-03 03:14:20'),
(488, NULL, '06612497-893f-4b6f-b913-a9ecf52cfd90', 'active', '2026-11-03 03:39:58', '2026-11-03 03:39:58'),
(489, NULL, 'cdcefad1-e84d-4de8-8adb-4690047e6310', 'active', '2026-11-03 03:40:02', '2026-11-03 03:40:02'),
(490, NULL, '9a524850-600f-47af-977d-df8571ea698c', 'active', '2026-11-03 03:40:16', '2026-11-03 03:40:16'),
(491, NULL, '6f3bb3d7-3058-4928-a64a-f05318663383', 'active', '2026-11-03 03:41:02', '2026-11-03 03:41:02'),
(492, NULL, 'eef37bad-2e8e-4251-92de-9d47c68784e0', 'active', '2026-11-03 03:41:08', '2026-11-03 03:41:08'),
(493, NULL, 'b3d5a1ab-bf90-49e4-b037-eb570fd1b555', 'active', '2026-11-03 03:42:55', '2026-11-03 03:42:55'),
(494, NULL, 'bdcb266b-b0b3-4363-8d04-f313f7d55ddb', 'active', '2026-11-03 03:43:06', '2026-11-03 03:43:06'),
(495, NULL, '51c4081d-deab-4844-b61b-5614f51b4cc4', 'active', '2026-11-03 03:43:07', '2026-11-03 03:43:07'),
(496, NULL, 'b08a8219-c258-490d-a43d-9205e287cd3e', 'active', '2026-11-03 03:43:09', '2026-11-03 03:43:09'),
(497, NULL, '9f5c5bc5-6dc4-4804-a078-75f2182c24e0', 'active', '2026-11-03 03:44:55', '2026-11-03 03:44:55'),
(498, NULL, '1f62335f-93a6-49de-902f-62b734884ac3', 'active', '2026-11-03 03:53:13', '2026-11-03 03:53:13'),
(499, NULL, '67e9a349-b92a-4773-908f-9241e12b6897', 'active', '2026-11-03 04:00:38', '2026-11-03 04:00:38'),
(500, NULL, '4e488301-8e22-4fd6-b715-8a97dd994520', 'active', '2026-11-03 04:01:20', '2026-11-03 04:01:20'),
(501, NULL, '9609efe3-3579-4ada-90b2-450dcb16f5cf', 'active', '2026-11-03 04:01:51', '2026-11-03 04:01:51'),
(502, NULL, '117ea22d-ac32-4ffa-b04f-f667f77686b5', 'active', '2026-11-03 04:02:57', '2026-11-03 04:02:57'),
(503, NULL, '7830bae3-6045-45dd-9e12-35a97e2f8acd', 'active', '2026-11-03 04:03:02', '2026-11-03 04:03:02'),
(504, NULL, 'b4c034f7-1c8f-4468-b7dc-9af8992e0dc5', 'active', '2026-11-03 04:21:17', '2026-11-03 04:21:17'),
(505, NULL, 'a0d986ac-6bf5-4cdf-a7de-9c9454f31b32', 'active', '2026-11-03 04:21:39', '2026-11-03 04:21:39'),
(506, NULL, '13ce151b-0c9c-4425-ae4b-7561f6c7823c', 'active', '2026-11-03 04:21:57', '2026-11-03 04:21:57'),
(507, NULL, '54db95a2-f4a7-46c9-b4e2-53dcc10a2b7a', 'active', '2026-11-03 04:24:14', '2026-11-03 04:24:14'),
(508, NULL, 'aeeefa33-b40e-4dd2-92e5-44c189a1fe75', 'active', '2026-11-03 04:26:17', '2026-11-03 04:26:17'),
(509, NULL, '1a3fe454-a07a-4f4e-bc0c-4bf3e2a3620d', 'active', '2026-11-03 04:30:00', '2026-11-03 04:30:00'),
(510, NULL, '8447ac1b-9b5c-4331-8c35-62cac5a8cc21', 'active', '2026-11-03 04:30:06', '2026-11-03 04:30:06'),
(511, NULL, 'e8790043-deaa-4a0e-8c33-1f0ccf4a4055', 'active', '2026-11-03 07:37:27', '2026-11-03 07:37:27'),
(512, NULL, 'b2236d64-feec-43f9-9404-c89129f58da9', 'active', '2026-11-03 07:37:29', '2026-11-03 07:37:29'),
(513, NULL, '2d4e3764-8a61-46ca-ade0-13bf73fc9d81', 'active', '2026-11-03 21:17:52', '2026-11-03 21:17:52'),
(514, NULL, '8f6a0826-4b64-4e97-971a-4f96163c0d34', 'active', '2026-11-03 22:20:34', '2026-11-03 22:20:34'),
(515, NULL, 'eb2c215d-c641-415d-afad-2f53a3db767e', 'active', '2026-11-03 23:37:21', '2026-11-03 23:37:21'),
(516, NULL, '110f5fb0-632a-4e60-a2bb-ffd31cbf2dc9', 'active', '2026-11-03 23:43:31', '2026-11-03 23:43:31'),
(517, 4, NULL, 'active', '2026-11-03 23:48:03', '2026-11-03 23:48:03'),
(518, NULL, 'a028391c-2fcb-4411-ae5b-0184abce7254', 'active', '2026-11-04 00:01:14', '2026-11-04 00:01:14'),
(519, NULL, '0d364e34-b675-43d2-aa1d-7bcd62b4537a', 'active', '2026-11-04 00:47:42', '2026-11-04 00:47:42'),
(520, NULL, '86f66509-ed9a-4221-8178-1eb5a04fd1f8', 'active', '2026-11-04 03:29:25', '2026-11-04 03:29:25'),
(522, NULL, '029ea7e0-8fac-4640-99c9-64bd2af01495', 'active', '2026-11-04 04:42:07', '2026-11-04 04:42:07'),
(523, NULL, '06f07293-41df-4b90-8668-63f3790370e9', 'active', '2026-11-04 05:35:51', '2026-11-04 05:35:51'),
(524, NULL, '8b20e48c-faa1-4887-8073-9a45eb3def00', 'active', '2026-11-04 17:48:12', '2026-11-04 17:48:12'),
(525, NULL, '78818844-4a6a-44cb-a195-c1f6050edd7f', 'active', '2026-11-04 17:51:23', '2026-11-04 17:51:23'),
(526, NULL, 'e76e6257-aea8-4abc-ba0f-780d1f207d3a', 'active', '2026-11-04 17:51:25', '2026-11-04 17:51:25'),
(527, NULL, 'd2ba486d-e2f4-44dd-8483-d843454a239c', 'active', '2026-11-04 17:51:26', '2026-11-04 17:51:26'),
(528, NULL, 'f5f31164-3b2a-4600-a1ad-c788b65a1960', 'active', '2026-11-04 17:51:26', '2026-11-04 17:51:26'),
(529, NULL, '74f62357-fd56-408d-9e93-f9eeee797f78', 'active', '2026-11-04 17:51:26', '2026-11-04 17:51:26'),
(530, NULL, '46ed86ab-7cab-4a7b-b6d1-ad5153a77ee8', 'active', '2026-11-04 17:51:27', '2026-11-04 17:51:27'),
(531, NULL, '3f29a545-ac29-4235-a64d-05ccd8554d29', 'active', '2026-11-04 17:51:27', '2026-11-04 17:51:27'),
(532, NULL, 'ad3cde05-5236-4f60-97d6-76b454f662b1', 'active', '2026-11-04 17:51:33', '2026-11-04 17:51:33'),
(533, NULL, '22ba0b78-65b4-4280-8f95-1647adc59276', 'active', '2026-11-04 17:51:33', '2026-11-04 17:51:33'),
(534, NULL, '2122a783-9e0c-423f-b830-6464f2c923fc', 'active', '2026-11-04 17:52:34', '2026-11-04 17:52:34'),
(535, NULL, 'dcd48b08-6938-420c-b5e4-5620d729a093', 'active', '2026-11-04 17:52:34', '2026-11-04 17:52:34'),
(536, NULL, '14c29d8f-f34c-470a-9d4d-307b1d11e86a', 'active', '2026-11-04 17:52:34', '2026-11-04 17:52:34'),
(537, NULL, 'a9ef03a3-2bd2-4cfd-8850-7cd78144a1b7', 'active', '2026-11-04 17:52:34', '2026-11-04 17:52:34'),
(538, NULL, '15c8a435-6177-4b78-aaec-ff8cd303b833', 'active', '2026-11-04 17:52:45', '2026-11-04 17:52:45'),
(539, NULL, '9dac231b-7fac-4843-9a6a-04d4b0a9fdb5', 'active', '2026-11-04 17:52:45', '2026-11-04 17:52:45'),
(540, NULL, 'bc84d99a-12fd-43ef-8f18-190fef0adc5e', 'active', '2026-11-04 17:52:45', '2026-11-04 17:52:45'),
(541, NULL, 'afe110b8-6cfb-42f1-81c5-eca73d603400', 'active', '2026-11-04 17:52:45', '2026-11-04 17:52:45'),
(542, NULL, '88c42bb7-ad8a-489d-93cf-5173b7e9bcfc', 'active', '2026-11-04 17:52:45', '2026-11-04 17:52:45'),
(543, NULL, '46051aea-685d-4b37-af30-8bf8aa9e7a19', 'active', '2026-11-04 17:52:52', '2026-11-04 17:52:52'),
(544, NULL, 'a68c2b49-eb6a-47ae-8ba9-dc358baa5bf4', 'active', '2026-11-04 17:52:52', '2026-11-04 17:52:52'),
(545, NULL, '3c679ea1-57b2-49ba-b18f-b8428d433e35', 'active', '2026-11-04 17:52:56', '2026-11-04 17:52:56'),
(546, NULL, 'c585f71f-98d0-479a-bbe0-c716bdfddfc6', 'active', '2026-11-04 17:52:56', '2026-11-04 17:52:56'),
(547, NULL, '581e3e93-5840-49ef-8a3d-aaa876845ba4', 'active', '2026-11-04 17:52:57', '2026-11-04 17:52:57'),
(548, NULL, 'ffda6f08-7661-417c-93d0-881315085b6e', 'active', '2026-11-04 17:53:32', '2026-11-04 17:53:32'),
(549, NULL, 'ee3f278e-871b-4c46-b373-50878caf4238', 'active', '2026-11-04 17:53:32', '2026-11-04 17:53:32'),
(550, NULL, '8da1dc5b-0d96-4390-b638-71a4069c44fe', 'active', '2026-11-04 17:53:36', '2026-11-04 17:53:36'),
(551, NULL, '74fba44a-3ecd-43f1-ad12-5e89612bd6c2', 'active', '2026-11-04 17:53:36', '2026-11-04 17:53:36'),
(552, NULL, '0a6bd93c-a910-4150-aa47-3cc427642db6', 'active', '2026-11-04 17:53:43', '2026-11-04 17:53:43'),
(553, NULL, '185607cf-80fc-4007-a888-8995a6e3f949', 'active', '2026-11-04 17:53:43', '2026-11-04 17:53:43'),
(554, NULL, '824f27bf-7aed-479b-a235-68891de4136b', 'active', '2026-11-04 17:53:43', '2026-11-04 17:53:43'),
(555, NULL, 'e285b1f7-0a3a-4528-9ba4-a194a19f115c', 'active', '2026-11-04 17:53:45', '2026-11-04 17:53:45'),
(556, NULL, '6083a4b2-c18e-4674-aaa2-63bc0ac6209a', 'active', '2026-11-04 17:53:45', '2026-11-04 17:53:45'),
(557, NULL, 'c4cd14ce-d420-4f3b-bf4e-79cf3fb67404', 'active', '2026-11-04 17:54:21', '2026-11-04 17:54:21'),
(558, NULL, 'fec2e824-d786-426c-a7b5-cd68b7017052', 'active', '2026-11-04 17:54:21', '2026-11-04 17:54:21'),
(559, NULL, 'b575856d-8c65-476a-bfb3-ca6404c70581', 'active', '2026-11-04 17:55:49', '2026-11-04 17:55:49'),
(560, NULL, '567d1dc1-8e93-4e44-9ff6-38a3c3cccfa0', 'active', '2026-11-04 17:55:50', '2026-11-04 17:55:50'),
(561, NULL, 'eb21098d-7183-44c9-9d44-b4bc324d9f77', 'active', '2026-11-04 17:55:50', '2026-11-04 17:55:50'),
(562, NULL, 'd6a37bb9-4918-47da-b1fa-bb402bcee1f0', 'active', '2026-11-04 17:55:50', '2026-11-04 17:55:50'),
(563, NULL, '5ecc009b-cc73-4f2a-ab18-b3302aef6bb8', 'active', '2026-11-04 17:55:50', '2026-11-04 17:55:50'),
(564, NULL, 'c3f85cee-4874-4917-b4e9-b538496efb09', 'active', '2026-11-04 17:55:50', '2026-11-04 17:55:50'),
(565, NULL, 'a7efa8fc-1fcd-4fdd-8eec-a1dd63a130f4', 'active', '2026-11-04 17:55:50', '2026-11-04 17:55:50'),
(566, NULL, 'c3178e0f-e4c5-4513-acd0-8af2a1e2f360', 'active', '2026-11-04 17:55:50', '2026-11-04 17:55:50'),
(567, NULL, '61855b61-b38a-499f-b330-c51ded36b409', 'active', '2026-11-04 17:55:55', '2026-11-04 17:55:55'),
(568, NULL, '08f6396c-e960-4a0d-abc6-f29ed7ce385c', 'active', '2026-11-04 17:55:55', '2026-11-04 17:55:55'),
(569, NULL, 'b2c84651-06c3-42c2-8f2a-f377b1c7e49a', 'active', '2026-11-04 17:55:55', '2026-11-04 17:55:55'),
(570, NULL, '2bce9bd3-16a4-44a0-b6bd-f5f60483b93a', 'active', '2026-11-04 17:55:55', '2026-11-04 17:55:55'),
(571, NULL, 'dfc02e72-b058-47b0-99d6-49566425ca7b', 'active', '2026-11-04 17:55:55', '2026-11-04 17:55:55'),
(572, NULL, 'c66bb742-4390-4cf2-ad1f-7e96054e738a', 'active', '2026-11-04 17:55:55', '2026-11-04 17:55:55'),
(573, NULL, '28aa5057-0983-40d2-9018-70a4a3fe361c', 'active', '2026-11-04 17:55:56', '2026-11-04 17:55:56'),
(574, NULL, 'fe7db01b-c9bd-44c8-b33b-9b05447d5b53', 'active', '2026-11-04 17:55:56', '2026-11-04 17:55:56'),
(575, NULL, '3029dc30-b0f5-4fc6-a336-bfaaa87c564c', 'active', '2026-11-04 17:55:58', '2026-11-04 17:55:58'),
(576, NULL, 'c23b05b2-b182-406b-96d1-82f0c307ed4a', 'active', '2026-11-04 17:55:58', '2026-11-04 17:55:58'),
(577, NULL, 'd7a20b64-eba2-4324-9531-d18e9f0a58be', 'active', '2026-11-04 17:55:58', '2026-11-04 17:55:58'),
(578, NULL, 'ab833c4e-9a2e-418e-9e84-504b0762e3e8', 'active', '2026-11-04 17:55:58', '2026-11-04 17:55:58'),
(579, NULL, '456f0b39-aa8a-4e96-ba7f-9f2088a1886d', 'active', '2026-11-04 17:55:58', '2026-11-04 17:55:58'),
(580, NULL, 'db6b1099-b558-4ebc-8a17-794bf4c61781', 'active', '2026-11-04 17:55:59', '2026-11-04 17:55:59'),
(581, NULL, '49209bd3-d1ef-4ce4-ba69-b55edbae73ff', 'active', '2026-11-04 17:55:59', '2026-11-04 17:55:59'),
(582, NULL, '51ac2e50-57e3-4857-806a-25ba1f2b8658', 'active', '2026-11-04 17:56:02', '2026-11-04 17:56:02'),
(583, NULL, '9fa3bea5-b2b4-4ace-904a-90e73319ed40', 'active', '2026-11-04 17:56:02', '2026-11-04 17:56:02'),
(584, NULL, 'd77866f1-0164-4ac5-aca2-7241ea3fe167', 'active', '2026-11-04 17:56:02', '2026-11-04 17:56:02'),
(585, NULL, 'aee15d4d-3548-49d0-b05d-754d98fbdc60', 'active', '2026-11-04 17:56:02', '2026-11-04 17:56:02'),
(586, NULL, 'c5fa199e-477d-4301-98c6-9be7a84188ef', 'active', '2026-11-04 17:56:02', '2026-11-04 17:56:02'),
(587, NULL, '04c12b51-9dc6-411c-bd45-2552cb5339a6', 'active', '2026-11-04 17:56:02', '2026-11-04 17:56:02'),
(588, NULL, 'b3f8808f-6842-49fb-a6de-b2eca0c8a81e', 'active', '2026-11-04 17:56:02', '2026-11-04 17:56:02'),
(589, NULL, '3b61856f-9e8b-434f-9ac4-c7bd9696d9a8', 'active', '2026-11-04 17:56:26', '2026-11-04 17:56:26'),
(590, NULL, '63decb10-bf14-4e15-86da-326dd858f916', 'active', '2026-11-04 17:56:26', '2026-11-04 17:56:26'),
(591, NULL, 'a3a01244-8c41-4218-b235-e19cb3bd4321', 'active', '2026-11-04 17:56:26', '2026-11-04 17:56:26'),
(592, NULL, '07d497e5-fd34-4d59-a349-c85bdb1e4306', 'active', '2026-11-04 17:56:26', '2026-11-04 17:56:26'),
(593, NULL, '51353d0d-40bd-4e16-bea1-e153b849b35e', 'active', '2026-11-04 17:56:26', '2026-11-04 17:56:26'),
(594, NULL, '99cc72da-264f-4f17-a608-85f73ef47fa8', 'active', '2026-11-04 17:56:26', '2026-11-04 17:56:26'),
(595, NULL, '72bfc6f6-e972-4ea8-ac1c-be11dc3e2b48', 'active', '2026-11-04 17:56:26', '2026-11-04 17:56:26'),
(596, NULL, '211ccfd2-2c5c-49a6-b410-5643862e8e3d', 'active', '2026-11-04 17:56:28', '2026-11-04 17:56:28'),
(597, NULL, '10eea7f6-aaf3-41d9-8632-78139bcdec30', 'active', '2026-11-04 17:56:28', '2026-11-04 17:56:28'),
(598, NULL, '8f75557d-0d27-4d76-a8cf-8bc7cad380b3', 'active', '2026-11-04 17:56:38', '2026-11-04 17:56:38'),
(599, NULL, 'c7cfd485-7caa-4c77-a1d1-1cd259eb4d3d', 'active', '2026-11-04 17:56:40', '2026-11-04 17:56:40'),
(600, NULL, 'c826c94f-a83d-4af1-8ac1-fb7e65d31181', 'active', '2026-11-04 17:56:40', '2026-11-04 17:56:40'),
(601, NULL, 'e5c451c8-0490-4b9e-91fa-f489cced8bf6', 'active', '2026-11-04 17:56:40', '2026-11-04 17:56:40'),
(602, NULL, 'b0d3f191-8de8-401c-bef5-6c3aa4c97cd9', 'active', '2026-11-04 17:56:40', '2026-11-04 17:56:40'),
(603, NULL, 'a7582e10-9b1f-4aa0-afb7-cb28fef1f1e8', 'active', '2026-11-04 17:56:40', '2026-11-04 17:56:40'),
(604, NULL, '8a02cc2d-25c3-466d-91f3-ff73fd809e6e', 'active', '2026-11-04 17:56:40', '2026-11-04 17:56:40'),
(605, NULL, '349a6ac6-d47f-413a-aa13-9a586ed4549c', 'active', '2026-11-04 17:56:40', '2026-11-04 17:56:40'),
(606, NULL, '5edf64ac-839d-47b4-8522-34891a3a699c', 'active', '2026-11-04 17:56:42', '2026-11-04 17:56:42'),
(607, NULL, '9f2df0f8-111c-4cc5-a8bd-aae3ae968582', 'active', '2026-11-04 17:56:42', '2026-11-04 17:56:42'),
(608, NULL, '9a731dff-0f01-4311-b39c-42e331f1d5f8', 'active', '2026-11-04 17:56:42', '2026-11-04 17:56:42'),
(609, NULL, 'b05ef7e2-6e5e-45a6-adbf-6fca69833692', 'active', '2026-11-04 17:56:42', '2026-11-04 17:56:42'),
(610, NULL, 'c1cfaaa3-8890-4340-ac56-7ff1116d7722', 'active', '2026-11-04 17:56:42', '2026-11-04 17:56:42'),
(611, NULL, 'ddd34aa7-ffe9-4546-9d75-c5f5df8d6739', 'active', '2026-11-04 17:56:42', '2026-11-04 17:56:42'),
(612, NULL, '964e6f3a-13b9-44a4-bb0e-4a5af53eae05', 'active', '2026-11-04 17:56:42', '2026-11-04 17:56:42'),
(613, NULL, 'f8bf26c6-7f42-4298-ae30-275d8ef27b4c', 'active', '2026-11-04 17:56:43', '2026-11-04 17:56:43'),
(614, NULL, '7e0f0e40-d6d2-4022-a0d7-239dad6dbfd9', 'active', '2026-11-04 17:56:43', '2026-11-04 17:56:43'),
(615, NULL, '8385d228-ec69-46a0-b109-4ab78b1bf9c5', 'active', '2026-11-04 17:56:43', '2026-11-04 17:56:43'),
(616, NULL, '6dc5673d-e04d-4ee7-a799-d0be42c6f49f', 'active', '2026-11-04 17:56:43', '2026-11-04 17:56:43'),
(617, NULL, '2affc7be-5ef9-4249-839a-9bc9dff2b035', 'active', '2026-11-04 17:56:43', '2026-11-04 17:56:43'),
(618, NULL, '4c264870-a0cc-4cb3-adc1-2a679f980358', 'active', '2026-11-04 17:56:43', '2026-11-04 17:56:43'),
(619, NULL, '482e4ea5-8c14-4962-a250-80715ebba030', 'active', '2026-11-04 17:56:43', '2026-11-04 17:56:43'),
(620, NULL, '8fa0554f-9583-4ad4-92fe-51aecfa7acb1', 'active', '2026-11-04 17:56:47', '2026-11-04 17:56:47'),
(621, NULL, 'd6ae4643-7a9d-4cc5-8330-40906d836bf3', 'active', '2026-11-04 17:56:47', '2026-11-04 17:56:47'),
(622, NULL, '201580b5-788b-434a-ba1b-4ad678289abf', 'active', '2026-11-04 17:56:47', '2026-11-04 17:56:47'),
(623, NULL, '5c2c8e6b-7ac8-4c0e-b11e-22935de03822', 'active', '2026-11-04 17:56:47', '2026-11-04 17:56:47'),
(624, NULL, 'd2e387e1-694f-48be-8e29-6bc7fd1c6396', 'active', '2026-11-04 17:56:47', '2026-11-04 17:56:47'),
(625, NULL, '5375e6ac-c71d-4d7a-a5f9-2fe450e4afaa', 'active', '2026-11-04 17:56:47', '2026-11-04 17:56:47'),
(626, NULL, '8b05452b-4a34-467b-8b76-317ac29e10bb', 'active', '2026-11-04 17:56:47', '2026-11-04 17:56:47'),
(627, NULL, 'c4df9bcf-b51e-4fa1-a0b6-9e4c35945779', 'active', '2026-11-04 17:56:57', '2026-11-04 17:56:57'),
(628, NULL, '5164378e-f14c-4c56-9871-09dd57917370', 'active', '2026-11-04 17:56:57', '2026-11-04 17:56:57'),
(629, NULL, '0840f1b0-61e1-4862-abfc-9c26705ae052', 'active', '2026-11-04 17:56:57', '2026-11-04 17:56:57'),
(630, NULL, 'f649d634-e6e1-463f-a2ba-2a04a3afba52', 'active', '2026-11-04 17:56:57', '2026-11-04 17:56:57'),
(631, NULL, '1a82c3df-9c09-478a-9bce-c9cd210b3a54', 'active', '2026-11-04 17:56:57', '2026-11-04 17:56:57'),
(632, NULL, '60362762-c2f6-4951-b1ea-2f18f3089942', 'active', '2026-11-04 17:56:58', '2026-11-04 17:56:58'),
(633, NULL, 'ce2c64fb-ca9b-4242-a239-38edd448f5d8', 'active', '2026-11-04 17:56:58', '2026-11-04 17:56:58'),
(634, NULL, '359633d8-16a7-46a6-a005-ac9d91c9dbb7', 'active', '2026-11-04 17:57:06', '2026-11-04 17:57:06'),
(635, NULL, '68239d71-1d25-4c16-92f8-1926439f0af2', 'active', '2026-11-04 17:57:06', '2026-11-04 17:57:06'),
(636, NULL, 'b7f7c8ea-e030-41e0-a9aa-6eac3ad5b3d4', 'active', '2026-11-04 17:57:06', '2026-11-04 17:57:06'),
(637, NULL, '1b7d7127-dc43-4d5c-a94a-80f8a15bfa06', 'active', '2026-11-04 17:57:06', '2026-11-04 17:57:06'),
(638, NULL, '0f577e5c-2778-46e8-adc0-22d0e98572f6', 'active', '2026-11-04 17:57:06', '2026-11-04 17:57:06'),
(639, NULL, 'e49ca1c5-13f0-4354-bd46-7512ed6e2d17', 'active', '2026-11-04 17:57:06', '2026-11-04 17:57:06'),
(640, NULL, '819ceadf-aa89-46a1-b032-9e1dd7b29c9c', 'active', '2026-11-04 17:57:06', '2026-11-04 17:57:06'),
(641, NULL, 'a52b0d16-8f4e-4498-9a07-60153cc87fa0', 'active', '2026-11-04 17:57:11', '2026-11-04 17:57:11'),
(642, NULL, '3e46d039-f28d-485b-b377-0ffd49d81915', 'active', '2026-11-04 18:00:04', '2026-11-04 18:00:04'),
(643, NULL, '7aa35a43-4b17-4163-a404-6166df32a550', 'active', '2026-11-04 18:00:13', '2026-11-04 18:00:13'),
(644, NULL, '26203b63-e719-4b59-9cd9-8239ecf85c07', 'active', '2026-11-04 18:00:13', '2026-11-04 18:00:13'),
(645, NULL, '5f858985-99f0-44f4-a336-9486a267d144', 'active', '2026-11-04 18:00:13', '2026-11-04 18:00:13'),
(646, NULL, '0ecf4b76-eabb-4820-b760-10f9e8741227', 'active', '2026-11-04 18:00:13', '2026-11-04 18:00:13'),
(647, NULL, '52a08db0-0409-4dfa-8dd0-38cbd38e987e', 'active', '2026-11-04 18:00:13', '2026-11-04 18:00:13'),
(648, NULL, 'd5d6053e-b6c4-4f08-a12a-e8d2f560dd1a', 'active', '2026-11-04 18:00:14', '2026-11-04 18:00:14'),
(649, NULL, 'e7adaf30-9677-408e-a437-b41eb73623a0', 'active', '2026-11-04 18:00:14', '2026-11-04 18:00:14'),
(650, NULL, 'aa5dcb41-a9de-4ead-9503-d979f3eb7d93', 'active', '2026-11-04 18:00:21', '2026-11-04 18:00:21'),
(651, NULL, '7e751bcc-8381-4879-87c1-d0630b8b0129', 'active', '2026-11-04 18:00:21', '2026-11-04 18:00:21'),
(652, NULL, 'c925c1a3-0052-4ab7-ac70-a1ffd1f1b599', 'active', '2026-11-04 18:00:21', '2026-11-04 18:00:21'),
(653, NULL, '40d26f6d-8acf-4ffd-89c4-e21f032a7e17', 'active', '2026-11-04 18:00:21', '2026-11-04 18:00:21'),
(654, NULL, '1bfb98fd-76eb-466a-8aa7-f20c23af5049', 'active', '2026-11-04 18:00:21', '2026-11-04 18:00:21'),
(655, NULL, 'aebb16bf-334e-4532-97fe-040ead0d98ea', 'active', '2026-11-04 18:00:22', '2026-11-04 18:00:22'),
(656, NULL, '45d595fa-e292-4396-9113-59ec6cfa9ee6', 'active', '2026-11-04 18:00:22', '2026-11-04 18:00:22'),
(657, NULL, 'd1ac6539-c813-46cc-9a22-e554f880b158', 'active', '2026-11-04 18:00:23', '2026-11-04 18:00:23'),
(658, NULL, '829fa53a-b247-48f1-afd3-461720cb307d', 'active', '2026-11-04 18:00:25', '2026-11-04 18:00:25'),
(659, NULL, '3235e821-30b2-47a7-a516-34ef0cf09eca', 'active', '2026-11-04 18:00:25', '2026-11-04 18:00:25'),
(660, NULL, '56ea6513-bb9f-46a7-950b-76cd14130b32', 'active', '2026-11-04 18:00:45', '2026-11-04 18:00:45'),
(661, NULL, 'cea3e699-3d3a-4fa3-9c10-05956ee44130', 'active', '2026-11-04 18:00:45', '2026-11-04 18:00:45'),
(662, NULL, '419b71d4-069b-4bd3-98b5-7f796270d299', 'active', '2026-11-04 18:00:45', '2026-11-04 18:00:45'),
(663, NULL, 'af98195a-847f-4395-841a-dc302d656cef', 'active', '2026-11-04 18:00:45', '2026-11-04 18:00:45'),
(664, NULL, 'f3fbb1d7-928f-43d2-a418-f3c0dce759eb', 'active', '2026-11-04 18:00:45', '2026-11-04 18:00:45'),
(665, NULL, '4e460aa3-e42e-443c-83b4-72e6daa6f6cf', 'active', '2026-11-04 18:00:46', '2026-11-04 18:00:46'),
(666, NULL, 'f1540c6e-7d5b-4e55-bf40-602eaa5c0210', 'active', '2026-11-04 18:00:46', '2026-11-04 18:00:46'),
(667, NULL, '4151212f-aece-42ba-9ce3-066a00931c8e', 'active', '2026-11-04 18:00:47', '2026-11-04 18:00:47'),
(668, NULL, 'a5f33b28-8343-4af1-a767-062b37e20d3f', 'active', '2026-11-04 18:00:48', '2026-11-04 18:00:48'),
(669, NULL, '2bb092c2-3b88-4ef1-86d7-d202f6b6d768', 'active', '2026-11-04 18:00:48', '2026-11-04 18:00:48'),
(670, NULL, '90344d7d-eeea-4365-96a5-e9274f9bf979', 'active', '2026-11-04 18:01:27', '2026-11-04 18:01:27'),
(671, NULL, 'dc9be3b5-35f9-45a9-af6f-5ac6885751b7', 'active', '2026-11-04 18:05:12', '2026-11-04 18:05:12'),
(672, NULL, '707ae3a5-514c-4858-a855-024fd1143aab', 'active', '2026-11-04 18:17:03', '2026-11-04 18:17:03'),
(673, NULL, 'd842d3ec-9ef4-4741-b79d-a76a58b6c08c', 'active', '2026-11-04 18:17:12', '2026-11-04 18:17:12'),
(674, NULL, 'dd666aaf-a1a5-464d-ad84-81eeb8670385', 'active', '2026-11-04 18:17:36', '2026-11-04 18:17:36'),
(675, NULL, '95edc6cb-88bd-48d1-9aa1-1d5a1469926a', 'active', '2026-11-04 18:17:38', '2026-11-04 18:17:38'),
(676, NULL, '9008959e-eb92-4aa7-9087-8b1af699b180', 'active', '2026-11-04 18:22:02', '2026-11-04 18:22:02'),
(677, NULL, '38597b65-6c51-4f53-b392-f65d1edf0ced', 'active', '2026-11-04 18:26:51', '2026-11-04 18:26:51'),
(678, NULL, '44738ecc-2149-4070-a51a-1bbb4c0fc5b7', 'active', '2026-11-04 18:27:56', '2026-11-04 18:27:56'),
(679, NULL, '37988488-4a8b-49be-ab7e-cc90a7feb766', 'active', '2026-11-04 18:31:31', '2026-11-04 18:31:31'),
(680, NULL, 'f0f4e5f0-cd43-4ea7-b81c-d3aa45ebad4c', 'active', '2026-11-04 18:33:49', '2026-11-04 18:33:49'),
(681, NULL, '6e04f891-7ea3-43fd-b084-911d2f676a16', 'active', '2026-11-04 18:44:44', '2026-11-04 18:44:44'),
(682, NULL, 'aadf91ff-b813-4002-b6e2-b907d80ec525', 'active', '2026-11-04 18:44:51', '2026-11-04 18:44:51'),
(683, NULL, '95c77102-9467-476e-a507-b59503e03782', 'active', '2026-11-04 18:46:46', '2026-11-04 18:46:46'),
(684, NULL, '2d7dc9c9-e9d4-4a85-83bf-57006cc747dd', 'active', '2026-11-04 18:49:44', '2026-11-04 18:49:44'),
(685, NULL, 'b67d6b8e-9ade-40c9-95f4-d88c7c12e269', 'active', '2026-11-04 18:50:43', '2026-11-04 18:50:43'),
(686, NULL, '8bb7a82f-52e7-45e4-9e8a-539463ebb58a', 'active', '2026-11-04 19:11:43', '2026-11-04 19:11:43'),
(687, NULL, '1514b392-a73b-4d36-98f1-dffabb34b386', 'active', '2026-11-04 19:20:51', '2026-11-04 19:20:51'),
(688, NULL, 'f0e7c4fc-cabf-4552-972f-0430254bf5d7', 'active', '2026-11-04 19:30:50', '2026-11-04 19:30:50'),
(689, NULL, '24e9a640-c48e-4884-a6ce-cbee8e82ab71', 'active', '2026-11-04 19:47:55', '2026-11-04 19:47:55'),
(690, NULL, '18c88e24-b943-4287-bf3a-9e7ebf406008', 'active', '2026-11-04 20:01:35', '2026-11-04 20:01:35'),
(691, NULL, '4e354d8c-05ff-45a8-9ee7-fc40af18228a', 'active', '2026-11-04 20:04:28', '2026-11-04 20:04:28'),
(692, NULL, 'd8bbc8ed-f20b-49e3-b6e5-8c0387de7f47', 'active', '2026-11-04 20:09:45', '2026-11-04 20:09:45'),
(693, NULL, '53e38ab4-ec84-4ed5-adaa-9a6d329e897f', 'active', '2026-11-04 20:11:53', '2026-11-04 20:11:53'),
(694, NULL, 'a8b46faf-666c-4dae-879d-5f8f485902ec', 'active', '2026-11-04 20:21:17', '2026-11-04 20:21:17'),
(695, NULL, '2d1e4b6d-3a36-4106-9e93-421c3c592367', 'active', '2026-11-04 20:31:45', '2026-11-04 20:31:45'),
(696, NULL, '4c9c38f2-0295-4f20-9160-be8bcc7c6439', 'active', '2026-11-04 20:43:24', '2026-11-04 20:43:24'),
(697, NULL, '6b4572f3-5110-49e3-b231-f5ade031b59e', 'active', '2026-11-04 20:43:24', '2026-11-04 20:43:24'),
(698, NULL, '12427afe-dd92-4c9a-be7a-c558a33f72e9', 'active', '2026-11-04 20:43:27', '2026-11-04 20:43:27'),
(699, NULL, '36fb1bf1-9912-415c-af91-19aff861d7da', 'active', '2026-11-04 20:43:29', '2026-11-04 20:43:29'),
(700, NULL, 'c7fe6768-2476-4a81-a174-7a8e2298de49', 'active', '2026-11-04 20:43:33', '2026-11-04 20:43:33'),
(701, NULL, 'fe05b7aa-65c2-41a4-a46f-bd9166675d18', 'active', '2026-11-04 20:43:41', '2026-11-04 20:43:41'),
(702, NULL, 'f4feab61-5d22-41d3-8d29-032f394f7b87', 'active', '2026-11-04 20:44:25', '2026-11-04 20:44:25'),
(703, NULL, 'b09ce9f9-3770-45de-856e-e6095002322b', 'active', '2026-11-04 20:44:47', '2026-11-04 20:44:47'),
(704, NULL, '5a865122-7b07-4ac0-9cb1-08969eea6981', 'active', '2026-11-04 20:45:26', '2026-11-04 20:45:26'),
(705, NULL, 'a65ddc58-44ff-4949-ab4a-fd11dd964c50', 'active', '2026-11-04 20:47:09', '2026-11-04 20:47:09'),
(706, NULL, '34c0482f-8850-4954-b9ea-a691cbfaf80c', 'active', '2026-11-04 20:48:53', '2026-11-04 20:48:53'),
(707, NULL, 'a724b7f9-b6d2-45e7-9250-bf599c534b73', 'active', '2026-11-04 20:49:29', '2026-11-04 20:49:29'),
(708, NULL, 'f114d7ea-5979-4d0c-a893-38d0934c2e26', 'active', '2026-11-04 20:49:57', '2026-11-04 20:49:57'),
(709, NULL, '65d14f7d-452e-4c77-aeb5-f4c8c75c07e3', 'active', '2026-11-04 20:50:52', '2026-11-04 20:50:52'),
(710, NULL, 'd72319c6-d680-4708-8d0f-7ecf995dd846', 'active', '2026-11-04 20:54:48', '2026-11-04 20:54:48'),
(711, NULL, '067001a3-4646-492a-98b6-92a012cdd7d1', 'active', '2026-11-04 20:55:13', '2026-11-04 20:55:13'),
(712, NULL, '5123081e-e8f5-498a-b877-92792572076c', 'active', '2026-11-04 21:00:06', '2026-11-04 21:00:06'),
(713, NULL, '259c1295-4141-4fc4-9de1-4015650c7c78', 'active', '2026-11-04 21:07:15', '2026-11-04 21:07:15'),
(714, NULL, '64531693-1afd-428c-a490-247f11a83bab', 'active', '2026-11-04 21:09:14', '2026-11-04 21:09:14'),
(715, NULL, 'ba846570-905a-4a68-89fa-a85171abd863', 'active', '2026-11-04 21:12:31', '2026-11-04 21:12:31'),
(716, NULL, 'a3c6fe10-3deb-40a7-b9a5-33fd78fa9229', 'active', '2026-11-04 21:13:41', '2026-11-04 21:13:41'),
(717, NULL, '13c9dfd6-acc2-43af-a712-619136d03cac', 'active', '2026-11-04 21:14:12', '2026-11-04 21:14:12'),
(718, NULL, '98a34320-8553-4e26-8ab5-43b5cd4864cb', 'active', '2026-11-04 21:14:46', '2026-11-04 21:14:46'),
(719, NULL, 'abd41986-ce14-438f-9661-d32e4cad3fbc', 'active', '2026-11-04 21:15:16', '2026-11-04 21:15:16'),
(720, NULL, 'a4228083-94be-4017-9202-c0777c19e086', 'active', '2026-11-04 21:15:56', '2026-11-04 21:15:56'),
(721, NULL, '8ffc7fc5-b372-47b7-becf-bd39d7885ee4', 'active', '2026-11-04 21:16:32', '2026-11-04 21:16:32'),
(722, NULL, 'fa38129d-8012-4a6f-8dc8-5fb08d2f49c0', 'active', '2026-11-04 21:17:34', '2026-11-04 21:17:34'),
(723, NULL, 'a2b7bd4c-b233-4719-b174-0fe3ed700baf', 'active', '2026-11-04 21:18:59', '2026-11-04 21:18:59'),
(724, NULL, 'd7e1811c-33f3-4677-96a4-2f14b6e7ecb5', 'active', '2026-11-04 21:19:32', '2026-11-04 21:19:32'),
(725, NULL, '9352ee7d-b396-4524-9bc0-40eec9590997', 'active', '2026-11-04 21:20:15', '2026-11-04 21:20:15'),
(726, NULL, '3ffd9753-81bc-403c-b3b5-2f0995f95135', 'active', '2026-11-04 21:20:55', '2026-11-04 21:20:55'),
(727, NULL, 'be0213c4-14dc-4c81-9a66-06931119e20e', 'active', '2026-11-04 21:21:41', '2026-11-04 21:21:41'),
(728, NULL, '88db8207-e89e-4ba6-bc3a-0b49d447e87e', 'active', '2026-11-04 21:42:19', '2026-11-04 21:42:19'),
(729, NULL, '42ce0a3f-64de-4a0e-bd20-d9ee5d9afd89', 'active', '2026-11-04 21:42:46', '2026-11-04 21:42:46'),
(730, NULL, '2d972d3b-e989-4140-9336-2f37f8d81c4f', 'active', '2026-11-04 21:53:50', '2026-11-04 21:53:50'),
(731, NULL, '3132d809-693c-4804-a71f-fbb4612745b4', 'active', '2026-11-04 22:03:29', '2026-11-04 22:03:29'),
(732, NULL, 'b6474330-b7c9-43d2-93f4-00f1c412b0ad', 'active', '2026-11-04 22:05:16', '2026-11-04 22:05:16'),
(733, NULL, 'c7cf0985-b30c-412d-851c-87e61b519983', 'active', '2026-11-04 22:12:34', '2026-11-04 22:12:34'),
(734, NULL, '532d4119-dc3e-4af6-9e01-d16bc514b8a4', 'active', '2026-11-04 22:23:24', '2026-11-04 22:23:24'),
(735, NULL, '0b567a15-88b6-4214-9090-116b04035ff2', 'active', '2026-11-04 22:29:37', '2026-11-04 22:29:37'),
(736, NULL, 'b1a0cc0a-aaef-4274-9421-569aa469c0cd', 'active', '2026-11-04 22:45:43', '2026-11-04 22:45:43'),
(737, NULL, '3c66f539-1daa-4070-bb64-5e45d50502c1', 'active', '2026-11-04 22:53:22', '2026-11-04 22:53:22'),
(738, NULL, 'c0d54c90-6321-457c-b9de-0139dc6bf7cf', 'active', '2026-11-04 23:04:24', '2026-11-04 23:04:24'),
(739, NULL, '3ac90de8-1fce-46fd-a516-8d27b9317cee', 'active', '2026-11-04 23:04:34', '2026-11-04 23:04:34'),
(740, NULL, '12305913-45b3-4fc5-a6ac-d7fac84f7c3f', 'active', '2026-11-04 23:13:13', '2026-11-04 23:13:13'),
(741, NULL, '0e3ed983-3e80-4799-b998-c3a3b5500b44', 'active', '2026-11-05 00:34:40', '2026-11-05 00:34:40'),
(742, NULL, '0fc4c9a5-cac7-471c-8e03-22e37dcbca77', 'active', '2026-11-05 00:45:05', '2026-11-05 00:45:05'),
(743, NULL, '015e30a5-f1e6-4a44-b974-be81b62a7893', 'active', '2026-11-05 00:56:22', '2026-11-05 00:56:22'),
(744, NULL, '4917b302-3db0-4762-9cce-6c369d2c200e', 'active', '2026-11-05 01:11:38', '2026-11-05 01:11:38'),
(745, NULL, 'f42f6fbc-59ac-46fe-b96f-754244b7dbaf', 'active', '2026-11-05 01:12:23', '2026-11-05 01:12:23'),
(746, NULL, '320ec566-dd1f-4168-8e9a-da885bbca4af', 'active', '2026-11-05 01:19:12', '2026-11-05 01:19:12'),
(747, NULL, '0cb368bc-7966-4e42-850a-107caed91117', 'active', '2026-11-05 01:22:28', '2026-11-05 01:22:28'),
(748, NULL, 'aaf4a768-ff21-4a63-bf0c-5cf0db9d04fe', 'active', '2026-11-05 01:25:18', '2026-11-05 01:25:18'),
(749, NULL, 'a689cb04-24fd-4872-a057-2c1d8d53e298', 'active', '2026-11-05 02:08:27', '2026-11-05 02:08:27'),
(750, NULL, '9a6ba2ae-d1d6-4548-8b2c-c8d881b6434e', 'active', '2026-11-05 02:08:28', '2026-11-05 02:08:28'),
(751, NULL, '528b6ece-9345-4841-8338-1c872ad9770f', 'active', '2026-11-05 02:10:48', '2026-11-05 02:10:48'),
(752, NULL, '321947e9-a747-4e24-bb83-3525518051f6', 'active', '2026-11-05 04:08:20', '2026-11-05 04:08:20'),
(753, NULL, 'fca29e46-8e92-47d2-b9c2-0062064b5c90', 'active', '2026-11-05 05:06:03', '2026-11-05 05:06:03'),
(754, NULL, '9a607438-937a-47f8-a650-248a2fee7c53', 'active', '2026-11-05 05:06:05', '2026-11-05 05:06:05'),
(755, NULL, '72eb366f-b476-45aa-a20c-7a623f7489f8', 'active', '2026-11-05 05:15:39', '2026-11-05 05:15:39'),
(756, NULL, 'abe4afd2-f43d-4845-836c-e6be478756cd', 'active', '2026-11-05 05:58:12', '2026-11-05 05:58:12'),
(757, NULL, '2f7cf630-1876-4645-93b0-ba831054bab4', 'active', '2026-11-05 06:10:13', '2026-11-05 06:10:13'),
(758, NULL, '4ff61d94-6d7b-4a91-a8ca-d2b6def3767a', 'active', '2026-11-05 06:14:43', '2026-11-05 06:14:43'),
(759, NULL, 'f590bb17-af5f-4186-baca-d9fcc1b028f7', 'active', '2026-11-05 06:15:14', '2026-11-05 06:15:14'),
(760, NULL, '74b16f2e-8b66-4d53-8043-95ce8a7e4684', 'active', '2026-11-05 06:15:19', '2026-11-05 06:15:19'),
(761, NULL, '0c742359-3a45-47bb-85fc-b88109a34db7', 'active', '2026-11-05 06:15:31', '2026-11-05 06:15:31'),
(762, NULL, '475d3425-cec8-4832-abc3-fcb283662328', 'active', '2026-11-05 06:15:40', '2026-11-05 06:15:40'),
(763, NULL, '158d8076-d9f5-4ac4-853c-ed5e622e37f8', 'active', '2026-11-05 06:15:46', '2026-11-05 06:15:46'),
(764, NULL, '11bd4d25-cc02-4329-9cac-7c5708703720', 'active', '2026-11-05 06:15:51', '2026-11-05 06:15:51'),
(765, NULL, '9e87221e-ac75-44cc-bea8-34253be96e6a', 'active', '2026-11-05 06:16:03', '2026-11-05 06:16:03'),
(766, NULL, 'f55b7886-b50f-46a9-b495-00c3e8c21fd6', 'active', '2026-11-05 06:16:16', '2026-11-05 06:16:16'),
(767, NULL, '0137288f-8e06-4372-95a9-dd4212268c53', 'active', '2026-11-05 06:16:29', '2026-11-05 06:16:29'),
(768, NULL, '4aeb7955-2764-4009-a0d0-f933066e2b69', 'active', '2026-11-05 06:16:39', '2026-11-05 06:16:39'),
(769, NULL, '73d4f1da-e588-40de-918f-9e3dfa3371af', 'active', '2026-11-05 06:16:49', '2026-11-05 06:16:49'),
(770, NULL, 'b9df4e55-9221-4460-85f5-49c4cb4afbb4', 'active', '2026-11-05 07:20:53', '2026-11-05 07:20:53'),
(771, NULL, '2e0948ba-8750-4c06-9c7f-ff3389b98204', 'active', '2026-11-05 07:20:53', '2026-11-05 07:20:53'),
(772, NULL, '8a847d06-990e-4e16-a021-962027f86660', 'active', '2026-11-05 07:20:53', '2026-11-05 07:20:53'),
(773, NULL, '9eb99291-0b6e-41dd-ad8a-df70f641fb96', 'active', '2026-11-05 07:20:53', '2026-11-05 07:20:53'),
(774, NULL, 'd47b009a-eaaf-4eef-ba0d-99058a1917c0', 'active', '2026-11-05 07:20:54', '2026-11-05 07:20:54'),
(775, NULL, '09e51444-f8f8-4452-823e-7e176d5d6efd', 'active', '2026-11-05 07:20:54', '2026-11-05 07:20:54'),
(776, NULL, '5ad6d76b-dde7-4720-8f54-a7e0897ae2f6', 'active', '2026-11-05 07:20:54', '2026-11-05 07:20:54'),
(777, NULL, 'fc0b2239-1f29-4f3d-afed-25ffa1afa4af', 'active', '2026-11-05 07:20:54', '2026-11-05 07:20:54'),
(778, NULL, '14b9c54e-af69-48b3-8bcc-1ad49f00f2fc', 'active', '2026-11-05 07:38:19', '2026-11-05 07:38:19'),
(779, NULL, '8098b81f-8e75-48f8-aaa1-acdb858fec83', 'active', '2026-11-05 08:04:45', '2026-11-05 08:04:45'),
(780, NULL, 'f3eedc5c-ff6d-4bd4-9754-a9eaf3b61f2c', 'active', '2026-11-05 08:08:13', '2026-11-05 08:08:13'),
(781, NULL, '3effb5df-550f-42b6-bdb7-446e02529715', 'active', '2026-11-05 08:18:50', '2026-11-05 08:18:50'),
(782, NULL, '23fcc107-b55f-4f8e-95e1-c219848a64b4', 'active', '2026-11-05 08:30:58', '2026-11-05 08:30:58'),
(783, NULL, 'a025fa60-75d4-486a-b1df-e927c142fa45', 'active', '2026-11-05 08:48:28', '2026-11-05 08:48:28'),
(784, NULL, '7c8c00b6-e5e3-4971-8200-0b034a38dee0', 'active', '2026-11-05 09:00:39', '2026-11-05 09:00:39'),
(785, NULL, '11f18960-12cf-4dab-a387-859f9ddb1997', 'active', '2026-11-05 09:10:21', '2026-11-05 09:10:21'),
(786, NULL, '0a6ee03b-b4de-4163-977f-bc930d8fd90b', 'active', '2026-11-05 09:17:13', '2026-11-05 09:17:13'),
(787, NULL, '373d3495-d9f2-4d88-aefa-e434b9831b93', 'active', '2026-11-05 09:19:33', '2026-11-05 09:19:33'),
(788, NULL, 'd48a44aa-8637-4fb4-a476-6a3e85c6940c', 'active', '2026-11-05 09:20:08', '2026-11-05 09:20:08'),
(789, NULL, 'a9ed67f0-8b55-4789-b6bc-8539fe80815c', 'active', '2026-11-05 09:21:18', '2026-11-05 09:21:18'),
(790, NULL, '90626d9f-1c65-4753-8f16-912f1c80f726', 'active', '2026-11-05 09:23:09', '2026-11-05 09:23:09'),
(791, NULL, '3cef39bd-27d2-47c5-93de-e563f3079481', 'active', '2026-11-05 09:30:46', '2026-11-05 09:30:46'),
(792, NULL, '6a46a79c-2fd6-4a33-bd04-46f7d36dbe77', 'active', '2026-11-05 09:36:02', '2026-11-05 09:36:02'),
(793, NULL, 'cdff8b78-a66b-4ce4-9b9a-714ae76c48ea', 'active', '2026-11-05 09:38:29', '2026-11-05 09:38:29'),
(794, NULL, 'c0bbdb06-832c-4563-aa5a-9b30db8f9bc1', 'active', '2026-11-05 09:43:14', '2026-11-05 09:43:14'),
(795, NULL, '35ddf0b0-0b6d-4ca1-88f9-8adb7c52b723', 'active', '2026-11-05 09:44:20', '2026-11-05 09:44:20'),
(796, NULL, '64bcbdf6-7abd-4020-bd4a-8be242da6762', 'active', '2026-11-05 09:45:59', '2026-11-05 09:45:59'),
(797, NULL, '745d46d7-da00-4d9b-ab9a-8a619df5e08b', 'active', '2026-11-05 10:09:02', '2026-11-05 10:09:02'),
(798, NULL, 'fe8da030-96d1-42fb-b5ab-338268ff9b6e', 'active', '2026-11-05 10:10:48', '2026-11-05 10:10:48'),
(799, NULL, '7328688a-5c87-4ad3-9ab9-3d05fbee42e9', 'active', '2026-11-05 10:14:59', '2026-11-05 10:14:59'),
(800, NULL, '63c17b3d-d2f4-4085-a2b6-3edfbc9b4ba2', 'active', '2026-11-05 10:15:43', '2026-11-05 10:15:43'),
(801, NULL, '913df1b6-8275-4ba7-b718-0cf5cb89049a', 'active', '2026-11-05 10:37:58', '2026-11-05 10:37:58'),
(802, NULL, '5b6bafcf-1500-49da-a0bb-6cf798cbd4d4', 'active', '2026-11-05 10:47:17', '2026-11-05 10:47:17'),
(803, NULL, '20b057ec-08ba-4f2d-af22-6abd1b4b4d13', 'active', '2026-11-05 10:47:25', '2026-11-05 10:47:25'),
(804, NULL, '3d5ec718-69f1-4bd8-a792-be3ad4e4aaa9', 'active', '2026-11-05 10:49:21', '2026-11-05 10:49:21'),
(805, NULL, '8c6a9752-9712-4d52-b134-ad858077e5ac', 'active', '2026-11-05 10:52:12', '2026-11-05 10:52:12'),
(806, NULL, 'b8c9f05c-4210-4390-882c-f90cad8f5540', 'active', '2026-11-05 10:55:10', '2026-11-05 10:55:10'),
(807, NULL, 'a7d8f2f4-fca6-4354-95bd-10a5962df5a9', 'active', '2026-11-05 10:57:24', '2026-11-05 10:57:24'),
(808, NULL, '507aee03-d9b9-4558-81a6-646e6b28f2d2', 'active', '2026-11-05 10:57:52', '2026-11-05 10:57:52'),
(809, 1, NULL, 'active', '2026-11-05 10:57:57', '2026-11-05 10:57:57'),
(810, NULL, '4193cae2-2695-4917-b648-30d33c33df87', 'active', '2026-11-05 10:57:59', '2026-11-05 10:57:59'),
(811, NULL, 'fc1787fe-3fbd-44c0-8128-669df052cb4b', 'active', '2026-11-05 10:57:59', '2026-11-05 10:57:59'),
(812, NULL, '756a117b-d61f-4a29-99ed-6b7c3c676685', 'active', '2026-11-05 10:59:11', '2026-11-05 10:59:11'),
(813, NULL, 'bad081e8-f98b-4638-b1bd-6adc9ef4d9b1', 'active', '2026-11-05 10:59:11', '2026-11-05 10:59:11'),
(814, NULL, '6bb994b1-60a0-482b-87d3-feb535ac4e53', 'active', '2026-11-05 11:00:11', '2026-11-05 11:00:11'),
(815, NULL, '805ee2c1-bc71-409c-8a95-9452da11cc11', 'active', '2026-11-05 11:00:46', '2026-11-05 11:00:46'),
(816, NULL, 'bc788703-14c9-42de-9a71-c8ec906d267f', 'active', '2026-11-05 11:01:14', '2026-11-05 11:01:14'),
(817, NULL, 'c1a02f00-05fd-4e08-a318-6077d92065b8', 'active', '2026-11-05 11:02:10', '2026-11-05 11:02:10'),
(818, NULL, 'f3d560c5-51e0-4222-ab95-7fc6875a1e8b', 'active', '2026-11-05 11:04:23', '2026-11-05 11:04:23'),
(819, NULL, '3a53b8ac-650d-475d-8e84-742caea737f3', 'active', '2026-11-05 11:06:43', '2026-11-05 11:06:43'),
(820, NULL, '7375cfed-b11f-45ce-a0f7-812b08247ac7', 'active', '2026-11-05 11:12:06', '2026-11-05 11:12:06'),
(821, NULL, '7fd47d8a-73b8-4df7-9039-2808a171f152', 'active', '2026-11-05 11:18:06', '2026-11-05 11:18:06'),
(822, NULL, '92313c9d-b9f6-4840-b5c9-968ad1dfb4fa', 'active', '2026-11-05 11:25:16', '2026-11-05 11:25:16'),
(823, NULL, 'cd4c4c2e-1fb4-4a3b-ba3d-34128c45de84', 'active', '2026-11-05 11:27:20', '2026-11-05 11:27:20'),
(824, NULL, 'b2284972-4768-42c9-9c2d-2d1ecab7c4c7', 'active', '2026-11-05 11:29:30', '2026-11-05 11:29:30'),
(825, NULL, '164ce530-2e62-46cc-b119-4f075f4e3b79', 'active', '2026-11-05 11:35:41', '2026-11-05 11:35:41'),
(826, NULL, '99b42ed9-412c-4ff6-af9f-6dbb8fb83f52', 'active', '2026-11-05 11:39:02', '2026-11-05 11:39:02'),
(827, NULL, '245650ae-f2ae-4a21-abe7-5eb00970f838', 'active', '2026-11-05 11:53:42', '2026-11-05 11:53:42'),
(828, NULL, 'efe24b3f-1fc9-4231-8145-6643da4397e1', 'active', '2026-11-05 12:45:31', '2026-11-05 12:45:31'),
(829, NULL, '72f6ed74-5f8d-4069-9584-62aef7dc6da5', 'active', '2026-11-05 13:10:23', '2026-11-05 13:10:23'),
(830, NULL, '31694b75-b07b-4022-84f3-41b962d2e284', 'active', '2026-11-05 13:14:41', '2026-11-05 13:14:41'),
(831, NULL, '45805a4d-a377-4f85-b0f7-8d862169aa13', 'active', '2026-11-05 13:16:30', '2026-11-05 13:16:30'),
(832, NULL, '72bcac6c-71fe-4e3b-af42-37c908f28832', 'active', '2026-11-05 13:18:41', '2026-11-05 13:18:41'),
(833, NULL, '6df5da6a-8f3a-4560-ade3-df02cd558983', 'active', '2026-11-05 13:27:19', '2026-11-05 13:27:19'),
(834, NULL, '74ae59ce-ad69-4463-95a2-a85769b414af', 'active', '2026-11-05 14:20:13', '2026-11-05 14:20:13'),
(835, NULL, '14e6c443-35f0-4d44-bcbc-0b78cad6ac0f', 'active', '2026-11-05 14:23:52', '2026-11-05 14:23:52'),
(836, NULL, '6f9506d6-aade-4697-8dfe-fa15008ac4c5', 'active', '2026-11-05 14:55:10', '2026-11-05 14:55:10'),
(837, NULL, '5de4800b-ca57-43a2-a952-7cd885f9b49c', 'active', '2026-11-05 15:02:27', '2026-11-05 15:02:27'),
(838, NULL, '572fdeb8-7ec1-46b2-a354-e152651b118b', 'active', '2026-11-05 15:10:04', '2026-11-05 15:10:04'),
(839, NULL, '9f416b60-2fdd-47ac-9ace-814336a16d7e', 'active', '2026-11-05 15:16:51', '2026-11-05 15:16:51'),
(840, NULL, 'ce0b30df-c758-410a-a885-4887c1ce060e', 'active', '2026-11-05 15:27:15', '2026-11-05 15:27:15'),
(841, NULL, '25b26183-c365-48cc-bbfc-0a24fc47c953', 'active', '2026-11-05 15:36:38', '2026-11-05 15:36:38'),
(842, NULL, '788a9917-1d98-46c1-bab6-e21cd9e68257', 'active', '2026-11-05 16:13:48', '2026-11-05 16:13:48'),
(843, NULL, '16eef6a9-fd3f-447f-b3c3-b1813baa772a', 'active', '2026-11-05 16:54:52', '2026-11-05 16:54:52'),
(844, NULL, '0a98fac0-8717-4704-8010-645699b6acee', 'active', '2026-11-05 17:36:18', '2026-11-05 17:36:18'),
(845, NULL, 'a405d595-b915-4ffb-b05c-2ae391f99059', 'active', '2026-11-05 18:07:07', '2026-11-05 18:07:07'),
(846, NULL, '9a02a6d6-49a5-4d7c-960a-fee241d9e8b3', 'active', '2026-11-05 18:08:34', '2026-11-05 18:08:34'),
(847, NULL, 'ae7b739f-7b46-4b7d-8d17-90dbc76050ed', 'active', '2026-11-05 18:12:16', '2026-11-05 18:12:16'),
(848, NULL, '77078792-34f3-4250-aef1-fb6e442dcafa', 'active', '2026-11-05 18:12:32', '2026-11-05 18:12:32'),
(849, NULL, 'd842112b-07cd-4f46-8f05-18b6ec9b6386', 'active', '2026-11-05 18:12:55', '2026-11-05 18:12:55'),
(850, NULL, '37728eab-82ac-4b62-804d-951302dd772b', 'active', '2026-11-05 18:12:55', '2026-11-05 18:12:55'),
(851, NULL, '22856d9a-702e-490c-91a1-e78d56afbcdb', 'active', '2026-11-05 18:12:57', '2026-11-05 18:12:57'),
(852, NULL, 'f1f6bf12-0df0-4740-a187-fc3914018847', 'active', '2026-11-05 18:14:34', '2026-11-05 18:14:34'),
(853, NULL, '87827001-d4ca-4ea9-b665-483db1a288ed', 'active', '2026-11-05 18:14:40', '2026-11-05 18:14:40'),
(854, NULL, 'bd4235be-0d30-4266-aaa8-bea8544a279a', 'active', '2026-11-05 18:16:14', '2026-11-05 18:16:14'),
(855, NULL, '39b4ae13-b5b6-4140-8ee5-75b412ae9ba9', 'active', '2026-11-05 18:17:33', '2026-11-05 18:17:33'),
(856, NULL, '6b25f9e8-e22e-4dbb-ba02-a70bb3c59807', 'active', '2026-11-05 18:19:58', '2026-11-05 18:19:58'),
(857, NULL, '1bc0ee7f-7d4a-46a1-96a0-5d25e203f7e5', 'active', '2026-11-05 18:25:44', '2026-11-05 18:25:44'),
(858, NULL, '9e52e774-8256-4a8b-8b75-f7f7f2288135', 'active', '2026-11-05 18:37:26', '2026-11-05 18:37:26'),
(859, NULL, '498535ad-5c2b-4410-8fff-f6092abaee7e', 'active', '2026-11-05 18:39:48', '2026-11-05 18:39:48'),
(860, NULL, '31ad4cd3-1dad-4fad-98e3-001aa58b04ee', 'active', '2026-11-05 18:54:01', '2026-11-05 18:54:01'),
(861, NULL, 'c44f43b4-33f4-4d17-9f5d-d0d53b883902', 'active', '2026-11-05 20:05:29', '2026-11-05 20:05:29'),
(862, NULL, '52939dbf-6f13-49f4-b818-84a0c6a5dda3', 'active', '2026-11-05 20:07:40', '2026-11-05 20:07:40'),
(863, NULL, '7696b289-4d90-4048-8654-6f4fe637e3de', 'active', '2026-11-05 20:09:08', '2026-11-05 20:09:08'),
(864, NULL, '079ddd0d-1b60-49fd-af3f-dca4bb9d5d3a', 'active', '2026-11-05 20:11:44', '2026-11-05 20:11:44'),
(865, NULL, '7651dfb5-c292-4ed1-b77a-53f7493327e2', 'active', '2026-11-05 20:14:25', '2026-11-05 20:14:25'),
(866, NULL, '00d3f717-1d98-45f7-9c39-aee3faff3e21', 'active', '2026-11-05 20:14:28', '2026-11-05 20:14:28'),
(867, NULL, 'ec4ff3f4-050b-47b2-a6b8-b625cd221ad3', 'active', '2026-11-05 20:15:37', '2026-11-05 20:15:37'),
(868, NULL, '079baa2e-1206-433d-8b83-5b8c496a4d11', 'active', '2026-11-05 20:18:37', '2026-11-05 20:18:37'),
(869, NULL, '69616d0a-38ca-4b0e-a5c6-65e05fab208b', 'active', '2026-11-05 20:31:37', '2026-11-05 20:31:37'),
(870, NULL, 'c59bf18e-b4f1-4e60-83fe-188cab19ef84', 'active', '2026-11-05 20:35:34', '2026-11-05 20:35:34'),
(871, NULL, 'aea51fb5-0038-4761-9f44-3b39614cd668', 'active', '2026-11-05 20:35:35', '2026-11-05 20:35:35'),
(872, NULL, 'c9b07900-0c6c-4e86-901b-b159940a2360', 'active', '2026-11-05 20:35:36', '2026-11-05 20:35:36'),
(873, NULL, '96df1cba-1b5e-4f18-b67d-65cc5b21d76a', 'active', '2026-11-05 20:35:36', '2026-11-05 20:35:36'),
(874, NULL, '1f8a0ad1-53b2-4e71-ab64-38e8d8c39218', 'active', '2026-11-05 21:24:55', '2026-11-05 21:24:55'),
(875, NULL, 'b895a412-d471-4b7b-9240-3c3f9a228204', 'active', '2026-11-05 21:25:45', '2026-11-05 21:25:45'),
(876, NULL, '27c30fb7-32f3-4072-8fc9-0fe272f47737', 'active', '2026-11-05 22:47:29', '2026-11-05 22:47:29'),
(877, NULL, 'd379126d-983a-413c-8de4-ed3df046be0a', 'active', '2026-11-06 00:10:21', '2026-11-06 00:10:21'),
(878, NULL, '85f3fdce-aede-4265-9dd8-c5651cd99c63', 'active', '2026-11-06 00:50:22', '2026-11-06 00:50:22'),
(879, NULL, '4f8e627a-b02d-4cb3-9596-bf90d32c28b8', 'active', '2026-11-06 01:13:39', '2026-11-06 01:13:39'),
(880, NULL, '6d7af74d-46ee-4840-8285-8e9e61934ff5', 'active', '2026-11-06 01:20:03', '2026-11-06 01:20:03'),
(881, NULL, '0544872e-3438-4527-9f9c-d85ce96fdf04', 'active', '2026-11-06 01:50:54', '2026-11-06 01:50:54'),
(882, NULL, 'bb6d0b1a-7832-4235-8668-5b95076cd7af', 'active', '2026-11-06 01:50:54', '2026-11-06 01:50:54'),
(883, NULL, '52301feb-810b-427b-855f-00581de9550e', 'active', '2026-11-06 01:50:55', '2026-11-06 01:50:55'),
(884, NULL, 'c5e8fc12-2930-4dac-ba00-2ec8c4bdb5a5', 'active', '2026-11-06 01:50:56', '2026-11-06 01:50:56'),
(885, NULL, '77f2b23e-c287-4764-aebc-5f2f048b06f2', 'active', '2026-11-06 01:50:57', '2026-11-06 01:50:57'),
(886, NULL, '292ba5f0-0d09-4d7d-82e6-6d5724d2ff74', 'active', '2026-11-06 01:50:58', '2026-11-06 01:50:58'),
(887, NULL, 'c6b4dfb4-86e9-4abc-9243-872400b446d1', 'active', '2026-11-06 01:50:59', '2026-11-06 01:50:59'),
(888, NULL, '0f3ac55b-c7ff-4392-8ca1-9b18e92a1dad', 'active', '2026-11-06 01:51:00', '2026-11-06 01:51:00'),
(889, NULL, 'ad5b9f46-d73d-416b-ae8f-56b8f6a55170', 'active', '2026-11-06 01:51:01', '2026-11-06 01:51:01'),
(890, NULL, '91619de5-51e2-489c-a75b-303d3deed34f', 'active', '2026-11-06 01:51:02', '2026-11-06 01:51:02'),
(891, NULL, 'df2c4ca4-4359-485a-b9da-5a72a6a1cd4d', 'active', '2026-11-06 01:51:06', '2026-11-06 01:51:06'),
(892, NULL, '5639028d-89e8-4e86-9c72-d9f8434e873d', 'active', '2026-11-06 01:51:10', '2026-11-06 01:51:10'),
(893, NULL, '1a66699e-68be-46b0-9aca-1537492dc866', 'active', '2026-11-06 01:51:14', '2026-11-06 01:51:14'),
(894, NULL, '8660e385-8e21-42e4-b49f-f4fd0e79aa5e', 'active', '2026-11-06 01:51:22', '2026-11-06 01:51:22'),
(895, NULL, 'f81f41b0-68fe-4608-90d4-355a198bd548', 'active', '2026-11-06 01:54:07', '2026-11-06 01:54:07'),
(896, NULL, 'da100799-3b93-481c-8336-fdcff9028b3d', 'active', '2026-11-06 01:54:41', '2026-11-06 01:54:41'),
(897, NULL, '3ebdd6d4-e155-421a-8dab-6979c43d9cf2', 'active', '2026-11-06 01:55:15', '2026-11-06 01:55:15'),
(898, NULL, 'b7651cf8-9808-4bea-8c35-7d45e3eb421b', 'active', '2026-11-06 01:55:47', '2026-11-06 01:55:47'),
(899, NULL, '0083480a-b3b8-4a21-a89a-b7c50c9f6b4b', 'active', '2026-11-06 01:58:36', '2026-11-06 01:58:36'),
(900, NULL, 'cd19240b-172e-4f33-9c8b-606b1a3118f3', 'active', '2026-11-06 02:00:49', '2026-11-06 02:00:49'),
(901, NULL, '4898eaba-55dd-403e-b0f4-56abba62eea0', 'active', '2026-11-06 02:02:43', '2026-11-06 02:02:43'),
(902, NULL, '3b781ad9-81c0-4811-9087-040f714d23b2', 'active', '2026-11-06 02:03:45', '2026-11-06 02:03:45'),
(903, NULL, 'cb1e82c9-bb68-428e-9fb7-c83faf7f918d', 'active', '2026-11-06 02:32:28', '2026-11-06 02:32:28'),
(904, NULL, 'e5fbb83e-1a9b-4a67-a676-3cb1e66f89d7', 'active', '2026-11-06 02:32:29', '2026-11-06 02:32:29'),
(905, NULL, 'b6f5866a-a5f7-4d84-ad9d-2dba3c7e4da9', 'active', '2026-11-06 02:32:30', '2026-11-06 02:32:30'),
(906, NULL, '29525c8d-6c48-4ca1-9e6e-aadd8e73ec2e', 'active', '2026-11-06 03:03:31', '2026-11-06 03:03:31'),
(907, NULL, '6a7558b8-cd73-4427-9c1c-9f050f675429', 'active', '2026-11-06 03:04:55', '2026-11-06 03:04:55'),
(908, NULL, '3d652e01-3a0c-4b38-b92b-4a9c502bb3b5', 'active', '2026-11-06 03:27:57', '2026-11-06 03:27:57'),
(909, NULL, '52598e28-369c-49b0-a498-abb0c01d1d55', 'active', '2026-11-06 04:27:27', '2026-11-06 04:27:27'),
(910, NULL, '17a958d9-979d-4748-ac6b-b1f9fee8c911', 'active', '2026-11-06 04:36:49', '2026-11-06 04:36:49'),
(911, NULL, 'c8d6f510-de02-47a9-b71d-0b833b12ac60', 'active', '2026-11-06 05:11:09', '2026-11-06 05:11:09'),
(912, NULL, 'eb5fcb38-f01c-4a63-bae6-48802ec26bdc', 'active', '2026-11-06 06:13:53', '2026-11-06 06:13:53'),
(913, NULL, 'ed0c011d-e0ec-468b-8e95-01f79cb94a64', 'active', '2026-11-06 06:15:39', '2026-11-06 06:15:39'),
(914, NULL, 'd753fad4-cb77-47ef-a709-9cf085d15f3f', 'active', '2026-11-06 06:18:20', '2026-11-06 06:18:20'),
(915, NULL, 'bb728c68-65a1-4ca7-a19d-b7b7d6b32268', 'active', '2026-11-06 06:18:22', '2026-11-06 06:18:22'),
(916, NULL, '4de22ac2-5e3a-40ec-831d-b9a3173c4aa2', 'active', '2026-11-06 07:23:00', '2026-11-06 07:23:00'),
(917, NULL, 'ccefb2a8-dd4e-4169-9121-e97007ab2447', 'active', '2026-11-06 08:02:27', '2026-11-06 08:02:27'),
(918, NULL, 'cd23fb8c-6f8b-44c5-96c7-4fa5a6cc445f', 'active', '2026-11-06 08:10:07', '2026-11-06 08:10:07'),
(919, NULL, '6d3f9baf-01fd-4f1d-9319-f302f9288e53', 'active', '2026-11-06 08:19:25', '2026-11-06 08:19:25'),
(920, NULL, 'e6d1a757-aef8-4e67-80f7-340c085c956c', 'active', '2026-11-06 09:30:15', '2026-11-06 09:30:15'),
(921, NULL, 'e18b8d8a-6ddb-4c08-9bb4-5510f29a63f4', 'active', '2026-11-06 09:49:40', '2026-11-06 09:49:40'),
(922, NULL, '285396fc-55c3-44f0-9abc-baf0bbb0a7ea', 'active', '2026-11-06 10:01:27', '2026-11-06 10:01:27'),
(923, NULL, '92f877b0-bccb-4e98-82fb-5231ad8219b4', 'active', '2026-11-06 10:09:25', '2026-11-06 10:09:25'),
(924, NULL, 'd87d22d5-e674-49e3-b22a-bd13b5c117a9', 'active', '2026-11-06 10:13:24', '2026-11-06 10:13:24'),
(925, NULL, 'a3516177-dc88-48bb-b72c-5453d25d622c', 'active', '2026-11-06 10:20:12', '2026-11-06 10:20:12'),
(926, NULL, 'b99285b4-0c7b-4721-ab6c-2d7c0f28fc39', 'active', '2026-11-06 10:40:31', '2026-11-06 10:40:31'),
(927, NULL, '4b0fe298-0e08-4141-8062-edcffc3a3933', 'active', '2026-11-06 11:00:51', '2026-11-06 11:00:51'),
(928, NULL, '9a77ff66-44cb-46e1-9c03-87807ba098fa', 'active', '2026-11-06 11:35:18', '2026-11-06 11:35:18'),
(929, NULL, '085b9bd9-7966-47e0-a8ed-0c535f8f135d', 'active', '2026-11-06 11:56:41', '2026-11-06 11:56:41'),
(930, NULL, 'a7568abc-5f7e-4a27-a435-bd9d78f56244', 'active', '2026-11-06 12:20:34', '2026-11-06 12:20:34'),
(931, NULL, 'b13b7295-f86a-41e8-a361-858a176fcc18', 'active', '2026-11-06 12:30:57', '2026-11-06 12:30:57'),
(932, NULL, '87c05d22-3957-4dc5-ab53-1034b7262e81', 'active', '2026-11-06 12:32:12', '2026-11-06 12:32:12'),
(933, NULL, '76180ab2-fce6-499d-802d-d825bace5f99', 'active', '2026-11-06 12:56:31', '2026-11-06 12:56:31'),
(934, NULL, '72266be0-09ae-4a21-8a98-e5722471c8c7', 'active', '2026-11-06 13:10:12', '2026-11-06 13:10:12'),
(935, NULL, '099a48bc-50e1-4f7a-bd87-687572db0761', 'active', '2026-11-06 13:23:47', '2026-11-06 13:23:47');
INSERT INTO `carts` (`id`, `customer_id`, `session_id`, `status`, `created_at`, `updated_at`) VALUES
(936, NULL, '66894aaa-1866-45b5-868d-06655b7eafbe', 'active', '2026-11-06 14:18:14', '2026-11-06 14:18:14'),
(937, NULL, '89054ad9-8c35-4a1d-95e2-7d2a3eed2582', 'active', '2026-11-06 14:25:50', '2026-11-06 14:25:50'),
(938, NULL, '55afd773-c5d1-47fd-b194-32ec8fd5f24c', 'active', '2026-11-06 15:04:20', '2026-11-06 15:04:20'),
(939, NULL, '8cb11825-f109-410b-bf0e-23f04d4ce64c', 'active', '2026-11-06 15:09:45', '2026-11-06 15:09:45'),
(940, NULL, '92879cc0-56ad-4992-9daa-41f394b46e5c', 'active', '2026-11-06 15:20:57', '2026-11-06 15:20:57'),
(941, NULL, 'a42df6f0-d041-4be0-90d1-aefb7eeaec17', 'active', '2026-11-06 15:58:00', '2026-11-06 15:58:00'),
(942, NULL, '546929c4-ec4d-43ec-915a-29cdcbf65d60', 'active', '2026-11-06 16:19:42', '2026-11-06 16:19:42'),
(943, NULL, '5b8a0fdb-20f9-4b68-bb87-d54352e98bbf', 'active', '2026-11-06 16:29:30', '2026-11-06 16:29:30'),
(944, NULL, 'd42d28fa-065f-4c9c-b4d2-033f132c5880', 'active', '2026-11-06 16:33:32', '2026-11-06 16:33:32'),
(945, NULL, 'd0fe5f43-5608-4c50-96d0-4840a8323828', 'active', '2026-11-06 16:35:10', '2026-11-06 16:35:10'),
(946, NULL, '5f403f04-2b32-4b34-83d5-f92eaf0d55ab', 'active', '2026-11-06 16:40:22', '2026-11-06 16:40:22'),
(947, NULL, '8f5bb503-62a5-49f3-853d-888148fef335', 'active', '2026-11-06 16:56:22', '2026-11-06 16:56:22'),
(948, NULL, '7f2cc909-2415-4971-b7fb-6da41a3ecc68', 'active', '2026-11-06 16:57:21', '2026-11-06 16:57:21'),
(949, NULL, 'b59ee122-06d4-46f2-93c7-141b80fce418', 'active', '2026-11-06 16:57:52', '2026-11-06 16:57:52'),
(950, NULL, '53e112a7-6a69-482c-b1e7-939b6637cff7', 'active', '2026-11-06 16:58:23', '2026-11-06 16:58:23'),
(951, NULL, '8be519a8-8e04-4522-bcf8-0d35a2a3f48f', 'active', '2026-11-06 16:59:36', '2026-11-06 16:59:36'),
(952, NULL, 'b4cc7e8c-07b1-46a5-8bc3-c1dcefb7154e', 'active', '2026-11-06 16:59:58', '2026-11-06 16:59:58'),
(953, NULL, '9798d578-7cc8-42ce-ba91-db91b0a71d84', 'active', '2026-11-06 17:00:28', '2026-11-06 17:00:28'),
(954, NULL, 'da87231d-702f-4eb5-991c-c7ac53a19d62', 'active', '2026-11-06 17:12:05', '2026-11-06 17:12:05'),
(955, NULL, '8a38bba8-5cad-4651-a860-7ad556487a81', 'active', '2026-11-06 17:15:28', '2026-11-06 17:15:28'),
(956, NULL, '3b721378-5a96-4dd7-a140-df609644ac18', 'active', '2026-11-06 17:16:10', '2026-11-06 17:16:10'),
(957, NULL, '5aa36f07-1ad2-4e8b-a453-61e5c025fa20', 'active', '2026-11-06 17:16:42', '2026-11-06 17:16:42'),
(958, NULL, '120583eb-ff4f-44c4-92fc-cce5bcbcccce', 'active', '2026-11-06 17:17:14', '2026-11-06 17:17:14'),
(959, NULL, '3ea03d29-f74c-460b-840a-57eb7da056cc', 'active', '2026-11-06 17:17:56', '2026-11-06 17:17:56'),
(960, NULL, '2e4cd1d7-7b5d-4ca6-8484-384e153675b4', 'active', '2026-11-06 17:18:29', '2026-11-06 17:18:29'),
(961, NULL, 'b8e3b790-af3b-463c-aa5c-5a3dfca64d09', 'active', '2026-11-06 17:19:00', '2026-11-06 17:19:00'),
(962, NULL, '6225e54a-23e9-46d9-8f04-6115f81427ed', 'active', '2026-11-06 17:19:30', '2026-11-06 17:19:30'),
(963, NULL, 'd95fa5fa-ddd5-443b-b2c9-24bb1d5c092d', 'active', '2026-11-06 17:20:01', '2026-11-06 17:20:01'),
(964, NULL, '9eee5adb-15f1-443d-9e05-27d565907ff1', 'active', '2026-11-06 17:20:32', '2026-11-06 17:20:32'),
(965, NULL, '6c7b4710-369b-4317-b32d-88fd09064321', 'active', '2026-11-06 17:31:20', '2026-11-06 17:31:20'),
(966, NULL, 'ceb8c025-8744-4f42-96a9-f4e6b4c1c9f7', 'active', '2026-11-06 17:36:44', '2026-11-06 17:36:44'),
(967, NULL, '2a8128b2-a987-4bc9-bdc0-2115312bbc3c', 'active', '2026-11-06 17:37:54', '2026-11-06 17:37:54'),
(968, NULL, 'ae9ace01-769b-4241-88ff-fe6dc83c0dba', 'active', '2026-11-06 17:38:25', '2026-11-06 17:38:25'),
(969, NULL, '568d8a33-d350-478b-a953-3d107cf59545', 'active', '2026-11-06 17:38:56', '2026-11-06 17:38:56'),
(970, NULL, '53e7e270-3e51-4431-bb75-a84b27190ee5', 'active', '2026-11-06 17:39:32', '2026-11-06 17:39:32'),
(971, NULL, '8f251fd1-4f14-472f-ac78-f8bf19f35367', 'active', '2026-11-06 17:40:04', '2026-11-06 17:40:04'),
(972, NULL, '0dfb24dc-6d15-46b2-83f9-7d10a7ed5290', 'active', '2026-11-06 17:40:34', '2026-11-06 17:40:34'),
(973, NULL, 'b734e0cc-265a-438c-9095-7ac08bdb43e4', 'active', '2026-11-06 17:41:05', '2026-11-06 17:41:05'),
(974, NULL, 'e2077373-ad3a-4008-a7c3-05aa44f5333a', 'active', '2026-11-06 17:41:41', '2026-11-06 17:41:41'),
(975, NULL, 'd3ce615b-a115-46e1-b33d-1a7f45934906', 'active', '2026-11-06 18:04:52', '2026-11-06 18:04:52'),
(976, NULL, 'cfde5a22-9528-4281-9937-b313c8ba1721', 'active', '2026-11-06 18:11:00', '2026-11-06 18:11:00'),
(977, NULL, 'e4a97e61-0657-4021-8022-fa522408699d', 'active', '2026-11-06 18:41:36', '2026-11-06 18:41:36'),
(978, NULL, '4c0f40d9-0039-48ea-9279-ea23696e8bac', 'active', '2026-11-06 18:42:52', '2026-11-06 18:42:52'),
(979, NULL, 'aedee476-4291-4492-8859-c71c6108bba1', 'active', '2026-11-06 18:47:53', '2026-11-06 18:47:53'),
(980, NULL, '79d86435-6b42-48b9-9089-b24318e63427', 'active', '2026-11-06 19:18:10', '2026-11-06 19:18:10'),
(981, NULL, '40b23939-5aed-4014-9627-e8da297a8557', 'active', '2026-11-06 19:53:07', '2026-11-06 19:53:07'),
(982, NULL, '80869859-467a-490b-ac7b-f4e858f60bb4', 'active', '2026-11-06 20:03:54', '2026-11-06 20:03:54'),
(983, NULL, '35be1703-eb5a-4b4f-8fb4-b6dbc4ee188a', 'active', '2026-11-06 20:10:36', '2026-11-06 20:10:36'),
(984, NULL, 'b1fb9ee0-46b4-4a59-81b3-53800f95d2b8', 'active', '2026-11-06 20:22:21', '2026-11-06 20:22:21'),
(985, NULL, 'ca5c85ab-e263-4080-9a15-2c7ccd5f2285', 'active', '2026-11-06 20:25:32', '2026-11-06 20:25:32'),
(986, NULL, '61f16692-fe2f-40f7-8e8c-7da2e0f41876', 'active', '2026-11-06 20:36:51', '2026-11-06 20:36:51'),
(987, NULL, '3b61852f-4452-4c89-a518-b9ad4b9fb888', 'active', '2026-11-06 20:38:06', '2026-11-06 20:38:06'),
(988, NULL, '05c1460d-a74d-4b68-97ad-9eb8e1807012', 'active', '2026-11-06 20:44:38', '2026-11-06 20:44:38'),
(989, NULL, 'ceb5ca12-254e-4dc8-ac6b-6e342055bca0', 'active', '2026-11-06 20:46:12', '2026-11-06 20:46:12'),
(990, NULL, '665c4d93-1c04-4207-9635-5d67b636c7c5', 'active', '2026-11-06 21:33:52', '2026-11-06 21:33:52'),
(991, NULL, '16159d96-2cbe-4fac-b9db-9f854a21cd73', 'active', '2026-11-06 21:37:51', '2026-11-06 21:37:51'),
(992, NULL, '8d27722f-5350-48cf-baaf-8a62b0bfec4d', 'active', '2026-11-06 21:37:51', '2026-11-06 21:37:51'),
(993, NULL, '8cad7c30-aa3c-48b4-b883-627cf819a9a4', 'active', '2026-11-06 21:38:28', '2026-11-06 21:38:28'),
(994, NULL, '9f19e676-6489-46a6-b4fa-168359b1384c', 'active', '2026-11-06 21:39:22', '2026-11-06 21:39:22'),
(995, NULL, '3f7b3c2a-cf12-421e-93b8-06aa80b69e49', 'active', '2026-11-06 21:39:49', '2026-11-06 21:39:49'),
(996, NULL, 'd36d2dbf-08a6-425a-b2d5-540b22ce33bd', 'active', '2026-11-06 21:39:49', '2026-11-06 21:39:49'),
(997, NULL, '89808ad4-2197-4818-ad73-2118b68de642', 'active', '2026-11-06 21:40:33', '2026-11-06 21:40:33'),
(998, NULL, 'fb27b09a-5dc7-4326-aa3d-73ba4f7bcf05', 'active', '2026-11-06 21:40:43', '2026-11-06 21:40:43'),
(999, NULL, 'e8a937a7-a257-4469-8c9d-42531c00dbb3', 'active', '2026-11-06 21:44:47', '2026-11-06 21:44:47'),
(1000, NULL, 'ec3423a9-3b17-4cb1-95c0-877f84768852', 'active', '2026-11-06 21:44:47', '2026-11-06 21:44:47'),
(1001, NULL, '624025b0-bf42-4127-8488-bf4c9f918226', 'active', '2026-11-06 21:44:54', '2026-11-06 21:44:54'),
(1002, NULL, '8c404ec1-7153-467a-8332-c5b55721dec5', 'active', '2026-11-06 22:06:11', '2026-11-06 22:06:11'),
(1003, NULL, 'e39b6513-50ee-479c-917d-aeb94dced591', 'active', '2026-11-06 22:52:48', '2026-11-06 22:52:48'),
(1004, NULL, 'be828f88-cdc1-4e63-8f79-60ce06c202e7', 'active', '2026-11-07 00:45:09', '2026-11-07 00:45:09'),
(1005, NULL, '794a506c-0c7e-4cb6-8c04-4eea5dfbc9e2', 'active', '2026-11-07 01:12:53', '2026-11-07 01:12:53'),
(1006, NULL, '51f496fd-6642-4510-b7d2-6732732a01f1', 'active', '2026-11-07 01:13:10', '2026-11-07 01:13:10'),
(1007, NULL, '997c17af-d51a-4cd5-81aa-480fae2fe85e', 'active', '2026-11-07 01:22:02', '2026-11-07 01:22:02'),
(1008, NULL, '8f5f658e-cbe0-42d6-98b5-0d1d9fa19b18', 'active', '2026-11-07 01:32:53', '2026-11-07 01:32:53'),
(1009, NULL, 'adbc322f-8b60-4e00-9f4c-6c0b1c0ef447', 'active', '2026-11-07 01:32:57', '2026-11-07 01:32:57'),
(1010, NULL, '745ac0f1-66b9-460a-8c5d-e9e085cf700f', 'active', '2026-11-07 01:58:03', '2026-11-07 01:58:03'),
(1011, NULL, '5bd01b1e-1415-49a1-92fe-f8fa72eac8da', 'active', '2026-11-07 01:59:34', '2026-11-07 01:59:34'),
(1012, NULL, '6780732d-b260-495c-b3f1-bf5c9eafb566', 'active', '2026-11-07 02:13:29', '2026-11-07 02:13:29'),
(1013, NULL, '0d29f0b1-85e3-479f-b507-824308446544', 'active', '2026-11-07 03:18:39', '2026-11-07 03:18:39'),
(1014, NULL, '0557edea-f884-4c0a-a2af-0073c6b0a533', 'active', '2026-11-07 03:32:39', '2026-11-07 03:32:39'),
(1015, NULL, '52f83b87-4357-4f90-8e7a-5f40a6c39121', 'active', '2026-11-07 05:19:00', '2026-11-07 05:19:00'),
(1016, NULL, '873d33b3-a770-41da-82e0-55b32d7401f3', 'active', '2026-11-07 06:02:05', '2026-11-07 06:02:05'),
(1017, NULL, 'fcac6b8b-a550-498a-8176-ce8be0659eb1', 'active', '2026-11-07 06:09:30', '2026-11-07 06:09:30'),
(1018, NULL, '4db8fad2-a50c-46d0-a7fa-74b62a0ba46c', 'active', '2026-11-07 06:15:08', '2026-11-07 06:15:08'),
(1019, NULL, '33cce46a-29a4-429f-8f06-eb11e383a2c5', 'active', '2026-11-07 06:21:06', '2026-11-07 06:21:06'),
(1020, NULL, '5b342150-1837-4aec-81dc-498699b44fe4', 'active', '2026-11-07 06:25:06', '2026-11-07 06:25:06'),
(1021, NULL, 'a508baff-ef1b-4d86-8358-8b68d8176a97', 'active', '2026-11-07 07:23:44', '2026-11-07 07:23:44'),
(1022, NULL, '934755b2-af96-40cc-9303-900a32e4af5d', 'active', '2026-11-07 08:03:10', '2026-11-07 08:03:10'),
(1023, NULL, '13ac16e2-24e3-486a-a97d-8b7d124e2142', 'active', '2026-11-07 08:10:42', '2026-11-07 08:10:42'),
(1024, NULL, 'd6738710-6ea4-4289-baca-1e3de6d44624', 'active', '2026-11-07 08:15:10', '2026-11-07 08:15:10'),
(1025, NULL, 'fe56f5ef-4521-419f-9b4d-32e304e8929b', 'active', '2026-11-07 08:15:17', '2026-11-07 08:15:17'),
(1026, NULL, '7d2d2e55-1ca7-4643-9c55-fed427e7ad2e', 'active', '2026-11-07 08:19:46', '2026-11-07 08:19:46'),
(1027, NULL, '70db8218-689b-4a79-9f4e-ed9460bc0c15', 'active', '2026-11-07 08:22:53', '2026-11-07 08:22:53'),
(1028, NULL, '8320a047-b3bb-4217-af02-39e8f6badd4b', 'active', '2026-11-07 08:32:47', '2026-11-07 08:32:47'),
(1029, NULL, 'd91c731c-de0c-4ad2-a443-52f2a9d0b0da', 'active', '2026-11-07 08:33:03', '2026-11-07 08:33:03'),
(1030, NULL, '10da8352-1485-4067-afc6-f17524c2b43e', 'active', '2026-11-07 08:56:28', '2026-11-07 08:56:28'),
(1031, NULL, '7546a6d0-bcd6-4f63-84ee-f9b5fae15fd2', 'active', '2026-11-07 09:13:21', '2026-11-07 09:13:21'),
(1032, NULL, '8ecec92e-a1af-48a8-9794-0cc6f2080bb9', 'active', '2026-11-07 09:14:00', '2026-11-07 09:14:00'),
(1033, NULL, '3199e275-61e8-45a8-b670-ff5e748866ec', 'active', '2026-11-07 09:16:33', '2026-11-07 09:16:33'),
(1034, NULL, '1131e209-10d6-4269-82e2-db3c693b033a', 'active', '2026-11-07 10:00:00', '2026-11-07 10:00:00'),
(1035, NULL, '8246cc8b-16ad-4210-a78a-6a0192eed66e', 'active', '2026-11-07 10:09:18', '2026-11-07 10:09:18'),
(1036, NULL, '4846bbda-c0e0-4e1c-add3-0e1723c87d8d', 'active', '2026-11-07 10:12:25', '2026-11-07 10:12:25'),
(1037, NULL, '55a2e417-9407-4397-8ece-f076159265b0', 'active', '2026-11-07 10:37:38', '2026-11-07 10:37:38'),
(1038, NULL, '0af41fb0-8954-498e-a183-0296849685c5', 'active', '2026-11-07 10:38:37', '2026-11-07 10:38:37'),
(1039, NULL, '60e5af06-627c-4915-acbf-a0ffb4017644', 'active', '2026-11-07 10:54:34', '2026-11-07 10:54:34'),
(1040, NULL, '82b097fd-0f7e-4420-9382-ee074bc5b4b3', 'active', '2026-11-07 12:40:52', '2026-11-07 12:40:52'),
(1041, NULL, '0c9952ba-13d0-405a-aafa-19bd0298d40c', 'active', '2026-11-07 12:52:05', '2026-11-07 12:52:05'),
(1042, NULL, '640ccfe1-5cb9-45f5-957a-d6d5928897c5', 'active', '2026-11-07 13:10:35', '2026-11-07 13:10:35'),
(1043, NULL, 'c843f895-883a-4f5d-9803-ca5d8652e56f', 'active', '2026-11-07 13:12:37', '2026-11-07 13:12:37'),
(1044, NULL, 'ae3508b0-521e-4676-b2c5-ec97c9e2a9f1', 'active', '2026-11-07 13:41:31', '2026-11-07 13:41:31'),
(1045, NULL, 'd26dc4c5-e6e2-423c-a482-c0c492ba6a78', 'active', '2026-11-07 14:17:13', '2026-11-07 14:17:13'),
(1046, NULL, 'b4aff630-c004-4a87-a0a9-0d81d78821e9', 'active', '2026-11-07 14:45:17', '2026-11-07 14:45:17'),
(1047, NULL, '62981975-bff7-4bd5-8b53-158df823afcb', 'active', '2026-11-07 14:48:25', '2026-11-07 14:48:25'),
(1048, NULL, '8341594d-0e8c-44f0-b7e7-4f4da01deb8b', 'active', '2026-11-07 15:04:58', '2026-11-07 15:04:58'),
(1049, NULL, 'e54f9ec0-2c38-4745-bfd3-4fa7bcde981a', 'active', '2026-11-07 15:06:27', '2026-11-07 15:06:27'),
(1050, NULL, '38e21c0f-11b7-43b1-aeaa-02537a8adad4', 'active', '2026-11-07 15:11:14', '2026-11-07 15:11:14'),
(1051, NULL, '5b7fe3b4-01fb-4818-8476-68c156f13d05', 'active', '2026-11-07 15:18:22', '2026-11-07 15:18:22'),
(1052, NULL, '5a646e2e-3f83-49ca-8d3b-51e5c6ef163b', 'active', '2026-11-07 15:22:08', '2026-11-07 15:22:08'),
(1053, NULL, 'e495b270-cabf-4513-8e05-75ebb87e1584', 'active', '2026-11-07 15:23:54', '2026-11-07 15:23:54'),
(1054, NULL, 'a66591f3-e8b6-4530-920c-7d79510cea4c', 'active', '2026-11-07 15:28:23', '2026-11-07 15:28:23'),
(1055, NULL, '6024e32a-219b-4c9a-8b79-f4683d3c2e8c', 'active', '2026-11-07 15:39:57', '2026-11-07 15:39:57'),
(1056, NULL, '69fe6c84-87a2-4ef9-b823-6e82379d0cb5', 'active', '2026-11-07 17:03:22', '2026-11-07 17:03:22'),
(1057, NULL, '5591d5e8-834c-433d-b23c-5be5d045bf7c', 'active', '2026-11-07 17:14:37', '2026-11-07 17:14:37'),
(1058, NULL, '8c85f878-82e7-43f2-ae9b-ef91d6c5fa0b', 'active', '2026-11-07 18:05:56', '2026-11-07 18:05:56'),
(1059, NULL, 'ad3cf7be-8460-47a9-8cad-7dd159cdbbb7', 'active', '2026-11-07 18:09:29', '2026-11-07 18:09:29'),
(1060, NULL, 'f8345a57-ef5d-4996-8092-fd701b1406f1', 'active', '2026-11-07 19:02:27', '2026-11-07 19:02:27'),
(1061, NULL, 'cc086b16-aa59-4bfe-9d9f-dd48cc15ef19', 'active', '2026-11-07 19:10:28', '2026-11-07 19:10:28'),
(1062, NULL, '56f50a11-97bd-4bb1-a004-aec591eefec1', 'active', '2026-11-07 19:52:14', '2026-11-07 19:52:14'),
(1063, NULL, '32806203-7ec2-4f77-bff7-db866a296cdb', 'active', '2026-11-07 20:02:34', '2026-11-07 20:02:34'),
(1064, NULL, 'f1f03e67-9ea0-4b3b-9a93-6099d53ae840', 'active', '2026-11-07 20:02:34', '2026-11-07 20:02:34'),
(1065, NULL, '91677c2f-0e6f-49df-a340-6d0050502a81', 'active', '2026-11-07 20:02:34', '2026-11-07 20:02:34'),
(1066, NULL, 'f058ecd3-c65b-4ca4-bcad-604b57c7ca2d', 'active', '2026-11-07 20:02:35', '2026-11-07 20:02:35'),
(1067, NULL, '1aaf96cf-0729-40df-9854-2041a71d5318', 'active', '2026-11-07 20:02:36', '2026-11-07 20:02:36'),
(1068, NULL, '170d8bec-7435-402b-a86a-955864b403ea', 'active', '2026-11-07 20:02:37', '2026-11-07 20:02:37'),
(1069, NULL, '8c9b56dd-32f3-4356-b90d-3528eac14553', 'active', '2026-11-07 20:02:38', '2026-11-07 20:02:38'),
(1070, NULL, '7edeec66-b301-445e-aba6-0e9c01fa75aa', 'active', '2026-11-07 20:02:39', '2026-11-07 20:02:39'),
(1071, NULL, '3bfc8107-5b04-4e8b-930c-36aaf6da6aeb', 'active', '2026-11-07 20:02:41', '2026-11-07 20:02:41'),
(1072, NULL, 'e8a5559a-deb7-43fd-9b13-14f968d50ea8', 'active', '2026-11-07 20:02:41', '2026-11-07 20:02:41'),
(1073, NULL, 'fc30e6b7-1aa8-475e-837e-c806aedc35e4', 'active', '2026-11-07 20:02:47', '2026-11-07 20:02:47'),
(1074, NULL, 'fd7c0317-45cf-455f-a94c-7c95154a72de', 'active', '2026-11-07 20:02:49', '2026-11-07 20:02:49'),
(1075, NULL, '3cf9dc06-14f4-4f0b-8d34-c3e6566b23c5', 'active', '2026-11-07 20:02:53', '2026-11-07 20:02:53'),
(1076, NULL, '2fa0928b-68ee-4c2a-99f4-ed83690b510c', 'active', '2026-11-07 20:03:02', '2026-11-07 20:03:02'),
(1077, NULL, '8e1dfdc6-ab34-4f83-b404-01a3c774170d', 'active', '2026-11-07 20:03:19', '2026-11-07 20:03:19'),
(1078, NULL, 'fcf20900-9ef7-42fe-ab13-e3f154723f29', 'active', '2026-11-07 20:03:50', '2026-11-07 20:03:50'),
(1079, NULL, '9b098e1e-409c-4267-8383-f07d2f27c8dc', 'active', '2026-11-07 20:04:21', '2026-11-07 20:04:21'),
(1080, NULL, '8f5597bc-a018-46f4-ac71-f139a1136878', 'active', '2026-11-07 20:04:53', '2026-11-07 20:04:53'),
(1081, NULL, '4dd241a8-6e0c-42ef-9626-47e9835179cb', 'active', '2026-11-07 20:04:59', '2026-11-07 20:04:59'),
(1082, NULL, '39141db6-0cce-47fb-86ae-22648823b26b', 'active', '2026-11-07 20:05:25', '2026-11-07 20:05:25'),
(1083, NULL, '25934deb-1206-422e-b706-a3dfa89c1e10', 'active', '2026-11-07 20:06:24', '2026-11-07 20:06:24'),
(1084, NULL, '8fe68861-ac0a-4c6c-8e4b-1ead93a3d37f', 'active', '2026-11-07 20:08:34', '2026-11-07 20:08:34'),
(1085, NULL, 'e6423fd1-2dac-4298-b764-f82f8f5d7eee', 'active', '2026-11-07 20:09:40', '2026-11-07 20:09:40'),
(1086, NULL, '118d786f-cb7a-47a0-a037-0f88c8994cb7', 'active', '2026-11-07 20:18:49', '2026-11-07 20:18:49'),
(1087, NULL, 'e9ada10e-1007-4795-ac7d-33354204745b', 'active', '2026-11-07 21:53:00', '2026-11-07 21:53:00'),
(1088, NULL, 'aa91e270-9fef-43fd-afc0-43e0593060e8', 'active', '2026-11-07 22:09:40', '2026-11-07 22:09:40'),
(1089, NULL, '37b4caf4-090e-4f9a-b820-8e26e69d8732', 'active', '2026-11-07 23:52:45', '2026-11-07 23:52:45'),
(1090, NULL, '4a2efb4a-a637-4d6c-998e-7508c14c83fd', 'active', '2026-11-07 23:56:01', '2026-11-07 23:56:01'),
(1091, NULL, 'e30311d0-ca3a-4878-a66d-fe0ee287e3c2', 'active', '2026-11-08 00:35:42', '2026-11-08 00:35:42'),
(1092, NULL, '64857c6d-9cdc-45a5-a525-7ac9d4826be3', 'active', '2026-11-08 00:57:43', '2026-11-08 00:57:43'),
(1093, NULL, '0e7ea34d-b3a1-43fd-bf04-24fb98fef675', 'active', '2026-11-08 01:11:57', '2026-11-08 01:11:57'),
(1094, NULL, '87e3255b-b18c-42ab-ba81-15817dedd4a3', 'active', '2026-11-08 01:18:32', '2026-11-08 01:18:32'),
(1095, NULL, '3c209fe1-3751-4b55-9dbe-9dcd171d48c3', 'active', '2026-11-08 03:32:43', '2026-11-08 03:32:43'),
(1096, NULL, 'd038f962-71a1-4cb4-ba46-34751e543382', 'active', '2026-11-08 03:32:48', '2026-11-08 03:32:48'),
(1097, NULL, '2bda83ec-8521-4824-b1b8-2f4d13d53e14', 'active', '2026-11-08 05:32:26', '2026-11-08 05:32:26'),
(1098, NULL, '334b73bc-fa5b-40ad-9c6d-61f0191b3716', 'active', '2026-11-08 06:10:22', '2026-11-08 06:10:22'),
(1099, NULL, '1c9434d6-7902-498b-bb42-ab2a2e24473b', 'active', '2026-11-08 06:14:16', '2026-11-08 06:14:16'),
(1100, NULL, '61de8e9b-b500-4f00-a18d-b45a7e60d549', 'active', '2026-11-08 06:43:57', '2026-11-08 06:43:57'),
(1101, NULL, '8b631d85-7fc5-4220-97a6-c235e271de0e', 'active', '2026-11-08 06:46:18', '2026-11-08 06:46:18'),
(1102, NULL, '0227107e-5d55-47de-9355-56f4f4211ade', 'active', '2026-11-08 08:05:35', '2026-11-08 08:05:35'),
(1103, NULL, '3142d740-734b-4d02-ace6-88f6dbeb36b8', 'active', '2026-11-08 08:10:00', '2026-11-08 08:10:00'),
(1104, NULL, 'adfba91b-c1eb-4aa9-a1ca-30fbbab857bb', 'active', '2026-11-08 09:32:47', '2026-11-08 09:32:47'),
(1105, NULL, '0238a62c-84d8-41c9-83a5-323d2051da28', 'active', '2026-11-08 09:42:08', '2026-11-08 09:42:08'),
(1106, NULL, 'b0768991-8828-48f4-a74a-b09846a9b48e', 'active', '2026-11-08 09:42:55', '2026-11-08 09:42:55'),
(1107, NULL, '13392f09-2efd-4262-a77e-4595618732ef', 'active', '2026-11-08 09:47:26', '2026-11-08 09:47:26'),
(1108, NULL, '6150c5aa-9fc5-47e2-b294-bbbd5108f897', 'active', '2026-11-08 10:12:19', '2026-11-08 10:12:19'),
(1109, NULL, '7f0be1c6-3a52-446a-ad31-71cec5713cf5', 'active', '2026-11-08 10:16:45', '2026-11-08 10:16:45'),
(1110, NULL, '8d8bf080-94dc-4a30-8736-bfb882f04cb1', 'active', '2026-11-08 11:03:15', '2026-11-08 11:03:15'),
(1111, NULL, '0cb89d6c-2e17-452b-a05d-2ac2cd2928f9', 'active', '2026-11-08 11:59:44', '2026-11-08 11:59:44'),
(1112, NULL, '1d127a8f-b3d0-44b8-9c9e-5a30855d3811', 'active', '2026-11-08 12:17:31', '2026-11-08 12:17:31'),
(1113, NULL, '128c3399-c536-4189-ba9a-3a5ba6feaca5', 'active', '2026-11-08 12:27:49', '2026-11-08 12:27:49'),
(1114, NULL, 'f3f4d69e-0396-4149-acd4-a7327e6b74f2', 'active', '2026-11-08 13:10:51', '2026-11-08 13:10:51'),
(1115, NULL, 'b5f3e46b-8c67-45d0-83fc-e3286a2a40b0', 'active', '2026-11-08 13:14:32', '2026-11-08 13:14:32'),
(1116, NULL, 'dfe4ec22-994e-41db-bbc7-248cd7f7fb15', 'active', '2026-11-08 13:16:40', '2026-11-08 13:16:40'),
(1117, NULL, 'dd777799-eb23-46af-b41a-e536ce743ab0', 'active', '2026-11-08 14:10:06', '2026-11-08 14:10:06'),
(1118, NULL, '5febd8fa-ceeb-42f0-8826-e2f9b91583bd', 'active', '2026-11-08 14:17:28', '2026-11-08 14:17:28'),
(1119, NULL, '5c081054-17a9-4653-b37d-03e4c6a52f82', 'active', '2026-11-08 14:18:10', '2026-11-08 14:18:10'),
(1120, NULL, 'bfa9c21c-c07a-44b0-b437-b13e6ab99b6a', 'active', '2026-11-08 14:29:09', '2026-11-08 14:29:09'),
(1121, NULL, '84dfa604-72d0-43af-aeb4-a807f4fd6321', 'active', '2026-11-08 14:29:34', '2026-11-08 14:29:34'),
(1122, NULL, '9a4deffd-b7da-43bb-ab25-f4de7c6a8e37', 'active', '2026-11-08 14:29:35', '2026-11-08 14:29:35'),
(1123, NULL, '77e7b9ea-66cf-4902-92c8-34bc80c5a66e', 'active', '2026-11-08 14:29:35', '2026-11-08 14:29:35'),
(1124, NULL, '2b07220f-384f-444a-8a5e-9013717076f6', 'active', '2026-11-08 15:03:57', '2026-11-08 15:03:57'),
(1125, NULL, '88c8ae17-e4cd-4757-8e8a-c7a0af15a0c2', 'active', '2026-11-08 15:05:46', '2026-11-08 15:05:46'),
(1126, NULL, '6cc02627-72d9-4c26-940d-911bbeca8aa1', 'active', '2026-11-08 15:12:41', '2026-11-08 15:12:41'),
(1127, NULL, 'f2865dd4-2a4c-4c8e-9810-6eb175cbbebd', 'active', '2026-11-08 16:16:21', '2026-11-08 16:16:21'),
(1128, NULL, '4b7d9a9f-48d5-4801-affc-c24440f11013', 'active', '2026-11-08 16:27:47', '2026-11-08 16:27:47'),
(1129, NULL, 'fe1ed54c-b318-4a05-b423-5203b39c2c66', 'active', '2026-11-08 16:36:23', '2026-11-08 16:36:23'),
(1130, NULL, '4c720a77-7aad-44f7-8e3e-58a01257318b', 'active', '2026-11-08 16:51:11', '2026-11-08 16:51:11'),
(1131, NULL, '1398795c-7b91-4b24-b433-9c898d908427', 'active', '2026-11-08 16:52:11', '2026-11-08 16:52:11'),
(1132, NULL, '11f74a5b-97b9-4a57-b609-058598d2ccae', 'active', '2026-11-08 16:52:13', '2026-11-08 16:52:13'),
(1133, NULL, '6f5f85ff-120c-4471-b57e-fb7727e82dbc', 'active', '2026-11-08 16:52:14', '2026-11-08 16:52:14'),
(1134, NULL, '8caf3c25-119c-4070-8575-573daf176de7', 'active', '2026-11-08 16:52:16', '2026-11-08 16:52:16'),
(1135, NULL, '64fc6c14-1afc-4efe-94b1-2c05506c14b6', 'active', '2026-11-08 16:52:17', '2026-11-08 16:52:17'),
(1136, NULL, '161bdb17-be82-42e7-af94-929b2ca46840', 'active', '2026-11-08 16:52:19', '2026-11-08 16:52:19'),
(1137, NULL, 'cb0c75bc-c6c3-4408-b5eb-8f97494e0c8b', 'active', '2026-11-08 16:52:21', '2026-11-08 16:52:21'),
(1138, NULL, '1edea346-e413-4372-9858-51baabfaba38', 'active', '2026-11-08 16:52:24', '2026-11-08 16:52:24'),
(1139, NULL, '62a59caa-a133-402e-b1f9-6dba769390f1', 'active', '2026-11-08 16:52:26', '2026-11-08 16:52:26'),
(1140, NULL, 'b1f170ca-6c69-4343-84db-f55b0fdf4d02', 'active', '2026-11-08 16:52:27', '2026-11-08 16:52:27'),
(1141, NULL, '24f0e3ae-bc31-43db-8354-204519bc1237', 'active', '2026-11-08 16:52:28', '2026-11-08 16:52:28'),
(1142, NULL, 'c21f463b-2371-4609-bad9-d1994d1e5c05', 'active', '2026-11-08 16:52:30', '2026-11-08 16:52:30'),
(1143, NULL, '87e1fdfe-410a-4892-89bc-5147297f84bf', 'active', '2026-11-08 16:52:31', '2026-11-08 16:52:31'),
(1144, NULL, 'b5f27e15-9f45-449c-aa77-0c6a713148cf', 'active', '2026-11-08 16:52:33', '2026-11-08 16:52:33'),
(1145, NULL, 'b95ce080-1aea-4edc-af82-983d7802a6b6', 'active', '2026-11-08 16:52:34', '2026-11-08 16:52:34'),
(1146, NULL, '72619e43-f07c-41f1-a17c-e7ddd2f8656c', 'active', '2026-11-08 16:52:36', '2026-11-08 16:52:36'),
(1147, NULL, 'fb56ff56-5f2f-44cb-9856-df4f11297301', 'active', '2026-11-08 16:52:37', '2026-11-08 16:52:37'),
(1148, NULL, '75983777-da17-41d0-83f1-fbd9e646a9fb', 'active', '2026-11-08 16:52:39', '2026-11-08 16:52:39'),
(1149, NULL, 'ecffdfd3-eb08-41ca-93ae-908341a4366e', 'active', '2026-11-08 16:52:40', '2026-11-08 16:52:40'),
(1150, NULL, '7cc46d39-a9e4-408c-9292-c542344b5a00', 'active', '2026-11-08 16:52:41', '2026-11-08 16:52:41'),
(1151, NULL, 'd0bc3415-d730-4f58-ba8a-524526a33b42', 'active', '2026-11-08 16:52:43', '2026-11-08 16:52:43'),
(1152, NULL, 'bf010dd2-99fd-4a2b-8966-41ea00bd7592', 'active', '2026-11-08 16:52:44', '2026-11-08 16:52:44'),
(1153, NULL, '8dbfb94b-d9d5-4cb4-8835-2a7b72cbc379', 'active', '2026-11-08 16:52:46', '2026-11-08 16:52:46'),
(1154, NULL, '1f26df3e-cfe7-4d3f-808d-1803e55a44d6', 'active', '2026-11-08 16:52:47', '2026-11-08 16:52:47'),
(1155, NULL, '7c18908c-7805-425d-8b86-7c0650bb2489', 'active', '2026-11-08 16:52:49', '2026-11-08 16:52:49'),
(1156, NULL, '741fc885-e29f-4ae1-a114-b663a148a3fd', 'active', '2026-11-08 16:52:50', '2026-11-08 16:52:50'),
(1157, NULL, '3d9914e2-a8f8-4c9e-906d-e1808e426f01', 'active', '2026-11-08 16:52:52', '2026-11-08 16:52:52'),
(1158, NULL, 'f503a6d0-b5f2-4a8b-a588-268349a4818b', 'active', '2026-11-08 16:52:53', '2026-11-08 16:52:53'),
(1159, NULL, 'e70481eb-4f6e-425a-a7da-5b2bdc5e9618', 'active', '2026-11-08 16:52:54', '2026-11-08 16:52:54'),
(1160, NULL, '1e25caad-9d2b-41b4-a0de-3e5399a45fe5', 'active', '2026-11-08 16:52:56', '2026-11-08 16:52:56'),
(1161, NULL, '79914a52-37fc-4a22-a39d-fa9548c093e9', 'active', '2026-11-08 16:52:57', '2026-11-08 16:52:57'),
(1162, NULL, '307d48dc-9bc9-4b8d-8c8b-e0a7d23b1c80', 'active', '2026-11-08 16:52:59', '2026-11-08 16:52:59'),
(1163, NULL, 'c32b9b26-6c48-4a8c-915f-222a9ca6d9bb', 'active', '2026-11-08 16:53:00', '2026-11-08 16:53:00'),
(1164, NULL, 'ed967c2e-ed00-4681-985d-42ab9aac0193', 'active', '2026-11-08 16:53:01', '2026-11-08 16:53:01'),
(1165, NULL, '3a820e61-9a2e-42c0-9542-cf70ededc103', 'active', '2026-11-08 16:53:03', '2026-11-08 16:53:03'),
(1166, NULL, '8208a2ac-c58f-40bb-9d7c-ce5c858b4756', 'active', '2026-11-08 16:53:04', '2026-11-08 16:53:04'),
(1167, NULL, '56d20ffb-bb80-4e99-9dd1-319bc1c6268e', 'active', '2026-11-08 16:53:06', '2026-11-08 16:53:06'),
(1168, NULL, '6902b636-ffe2-4e4a-82ef-0e4ea72f9215', 'active', '2026-11-08 16:53:07', '2026-11-08 16:53:07'),
(1169, NULL, '22e33bb9-f432-4fcb-91d8-ffbed30e8298', 'active', '2026-11-08 16:53:09', '2026-11-08 16:53:09'),
(1170, NULL, '5c504298-4d59-43fc-8e8a-22d4eb3af732', 'active', '2026-11-08 16:53:10', '2026-11-08 16:53:10'),
(1171, NULL, '94382380-0973-4013-8237-fc875beefc64', 'active', '2026-11-08 16:53:12', '2026-11-08 16:53:12'),
(1172, NULL, '3d47029c-98b2-4699-bab9-2e14f450e1bb', 'active', '2026-11-08 16:53:12', '2026-11-08 16:53:12'),
(1173, NULL, '44995834-41dd-47d9-b4ec-3eb6603622cc', 'active', '2026-11-08 16:53:13', '2026-11-08 16:53:13'),
(1174, NULL, 'b346fdbd-2eab-4722-af87-2baa993c7513', 'active', '2026-11-08 16:53:14', '2026-11-08 16:53:14'),
(1175, NULL, '399d4a09-1532-4126-a56b-bd287273ee0f', 'active', '2026-11-08 16:53:16', '2026-11-08 16:53:16'),
(1176, NULL, '03b5fa10-ac7b-4c0a-90a5-8a5a37f6d733', 'active', '2026-11-08 16:53:17', '2026-11-08 16:53:17'),
(1177, NULL, '6239d555-3164-448f-9ee2-a080945d0389', 'active', '2026-11-08 16:53:19', '2026-11-08 16:53:19'),
(1178, NULL, '020b0ecc-2228-47e5-a940-55f42e72bc8b', 'active', '2026-11-08 16:53:20', '2026-11-08 16:53:20'),
(1179, NULL, 'da44d937-df8c-46e5-b3e5-aedb98102e1c', 'active', '2026-11-08 16:53:22', '2026-11-08 16:53:22'),
(1180, NULL, '4f1819b3-95de-43fa-bda8-a7000f341845', 'active', '2026-11-08 16:53:23', '2026-11-08 16:53:23'),
(1181, NULL, 'e74e7484-4e9b-46be-800a-515a363ff6e7', 'active', '2026-11-08 16:53:25', '2026-11-08 16:53:25'),
(1182, NULL, 'd1c2b923-a168-4765-9ca2-c1e735f5c20f', 'active', '2026-11-08 16:53:26', '2026-11-08 16:53:26'),
(1183, NULL, '8e5d5dec-e1fd-4aa0-8b7b-e1e3007bcf02', 'active', '2026-11-08 16:53:27', '2026-11-08 16:53:27'),
(1184, NULL, 'e06cd1f7-20b5-4507-8328-b0531100a3fd', 'active', '2026-11-08 16:53:29', '2026-11-08 16:53:29'),
(1185, NULL, 'f2407b71-289b-4343-9086-fe8d50cc244e', 'active', '2026-11-08 16:53:30', '2026-11-08 16:53:30'),
(1186, NULL, 'bd1c6da1-16fb-4ac8-87e8-0295674c458a', 'active', '2026-11-08 16:53:32', '2026-11-08 16:53:32'),
(1187, NULL, 'ee3e3eb5-89c0-41e9-a8a2-7e79ed29b065', 'active', '2026-11-08 16:53:33', '2026-11-08 16:53:33'),
(1188, NULL, '7f74ecc8-5a49-46a0-abc9-92342163c45d', 'active', '2026-11-08 16:53:35', '2026-11-08 16:53:35'),
(1189, NULL, '171a0292-4df8-470e-81e3-58ed98482e15', 'active', '2026-11-08 16:53:36', '2026-11-08 16:53:36'),
(1190, NULL, 'c876a44c-74f3-4c68-b1ab-e8802e52d9a5', 'active', '2026-11-08 16:53:38', '2026-11-08 16:53:38'),
(1191, NULL, '6a9ea068-a43b-4ffd-bb9b-80551a22df5d', 'active', '2026-11-08 16:53:39', '2026-11-08 16:53:39'),
(1192, NULL, 'e83d0f25-572a-4d1b-97a3-5954f1a96408', 'active', '2026-11-08 16:53:41', '2026-11-08 16:53:41'),
(1193, NULL, 'b6a057b5-a781-43b9-8545-2d59778d820e', 'active', '2026-11-08 16:53:42', '2026-11-08 16:53:42'),
(1194, NULL, '25aa0390-a01d-4a2c-b532-5e454342fbd9', 'active', '2026-11-08 16:53:42', '2026-11-08 16:53:42'),
(1195, NULL, 'c1d91247-dbaa-440e-a50c-f9673a1f99cb', 'active', '2026-11-08 16:53:44', '2026-11-08 16:53:44'),
(1196, NULL, '570437be-420f-45ad-99c5-f33a88088fbe', 'active', '2026-11-08 16:53:45', '2026-11-08 16:53:45'),
(1197, NULL, 'd2eb73ba-3611-41f2-9346-b9e10cf2feca', 'active', '2026-11-08 16:53:47', '2026-11-08 16:53:47'),
(1198, NULL, 'e4e5442f-6bce-4127-bff7-483ca2a2ac8b', 'active', '2026-11-08 16:53:48', '2026-11-08 16:53:48'),
(1199, NULL, '7902b843-bc49-46f1-9a1f-371a8570a9e8', 'active', '2026-11-08 16:53:50', '2026-11-08 16:53:50'),
(1200, NULL, '0cde3aa0-aa3c-4605-8656-48ec5080e165', 'active', '2026-11-08 16:53:51', '2026-11-08 16:53:51'),
(1201, NULL, '22d176fc-135b-41a5-9ae6-d1dcda2ec8b7', 'active', '2026-11-08 16:53:53', '2026-11-08 16:53:53'),
(1202, NULL, '99ad6162-fee1-48cb-ad40-d9139867e50d', 'active', '2026-11-08 16:53:54', '2026-11-08 16:53:54'),
(1203, NULL, '923db042-12ba-4ac1-802c-e88e54738a27', 'active', '2026-11-08 16:53:56', '2026-11-08 16:53:56'),
(1204, NULL, '818bb65e-ca44-4fee-9639-573306f5f7b9', 'active', '2026-11-08 16:53:57', '2026-11-08 16:53:57'),
(1205, NULL, '0d2750fa-d9c1-405f-b8e5-aa23501114a0', 'active', '2026-11-08 16:53:59', '2026-11-08 16:53:59'),
(1206, NULL, '07ed1d55-7877-4ac5-a5d8-37201db2cda9', 'active', '2026-11-08 16:54:00', '2026-11-08 16:54:00'),
(1207, NULL, '8d063e06-6848-474d-873b-45026b75489d', 'active', '2026-11-08 16:54:01', '2026-11-08 16:54:01'),
(1208, NULL, '144e7cbb-bb4e-4f48-a160-fb35306099f6', 'active', '2026-11-08 16:54:03', '2026-11-08 16:54:03'),
(1209, NULL, 'c1770410-657b-4be1-b95d-17ee0772973f', 'active', '2026-11-08 16:54:04', '2026-11-08 16:54:04'),
(1210, NULL, '5763d8b4-1722-474f-bb74-7c601093ce64', 'active', '2026-11-08 16:54:06', '2026-11-08 16:54:06'),
(1211, NULL, '884dcf1f-7c51-473d-82e5-8517f9a4e30f', 'active', '2026-11-08 16:54:07', '2026-11-08 16:54:07'),
(1212, NULL, 'f0bed875-bb93-4c93-9599-12eb6c311cdd', 'active', '2026-11-08 16:54:09', '2026-11-08 16:54:09'),
(1213, NULL, 'a0233471-c164-4587-b6df-5a143114e56c', 'active', '2026-11-08 16:54:10', '2026-11-08 16:54:10'),
(1214, NULL, '8030f141-2d6b-40ce-8822-fc873df8c4bf', 'active', '2026-11-08 16:54:11', '2026-11-08 16:54:11'),
(1215, NULL, '3b244467-5e22-498b-a9da-b08ef6d1124b', 'active', '2026-11-08 16:54:13', '2026-11-08 16:54:13'),
(1216, NULL, 'b2618333-9e98-47ae-893a-57ac6f8a24ca', 'active', '2026-11-08 16:54:14', '2026-11-08 16:54:14'),
(1217, NULL, '52447591-d8a1-4283-b6e4-893ab98a13d4', 'active', '2026-11-08 16:54:16', '2026-11-08 16:54:16'),
(1218, NULL, '52094a43-373c-4967-82ec-2309792bc132', 'active', '2026-11-08 16:54:17', '2026-11-08 16:54:17'),
(1219, NULL, '41545de6-61c9-45c7-b287-6f9240db0811', 'active', '2026-11-08 16:54:20', '2026-11-08 16:54:20'),
(1220, NULL, '7ab9d1c0-04d7-41a5-9578-ae142dd27285', 'active', '2026-11-08 16:54:21', '2026-11-08 16:54:21'),
(1221, NULL, 'c4adb3dd-9fc0-417e-bff7-0f84e5d589de', 'active', '2026-11-08 16:54:24', '2026-11-08 16:54:24'),
(1222, NULL, '87d33572-d3e5-42ce-8fbd-b018e9a3d46c', 'active', '2026-11-08 16:54:25', '2026-11-08 16:54:25'),
(1223, NULL, 'd1f9f395-00c4-4bee-8c62-c971c7e9c302', 'active', '2026-11-08 16:54:28', '2026-11-08 16:54:28'),
(1224, NULL, 'b5331575-26d7-4c5f-bcd3-4712e99cb9fa', 'active', '2026-11-08 16:54:30', '2026-11-08 16:54:30'),
(1225, NULL, '95bbd5e6-ae66-4922-b9bd-799def16e8bd', 'active', '2026-11-08 16:54:32', '2026-11-08 16:54:32'),
(1226, NULL, '3f353c63-d8e8-4036-86f0-39fe3d54929d', 'active', '2026-11-08 16:54:34', '2026-11-08 16:54:34'),
(1227, NULL, 'e9606cbc-3477-4df3-92b7-0c40c59f8245', 'active', '2026-11-08 16:54:36', '2026-11-08 16:54:36'),
(1228, NULL, 'eb6734a1-698a-46ae-9eab-99f445cd0ae9', 'active', '2026-11-08 16:54:38', '2026-11-08 16:54:38'),
(1229, NULL, 'aa107113-a0e2-4687-bc9e-a502ef472bcc', 'active', '2026-11-08 16:54:41', '2026-11-08 16:54:41'),
(1230, NULL, '00a3862b-9e21-416f-915c-24dc8d82eedb', 'active', '2026-11-08 16:54:42', '2026-11-08 16:54:42'),
(1231, NULL, 'c7a94405-5ae6-4286-ac84-535dffbd3ffe', 'active', '2026-11-08 16:54:45', '2026-11-08 16:54:45'),
(1232, NULL, 'f2b0dc43-0384-4a05-be03-c82fca9c74e4', 'active', '2026-11-08 16:54:46', '2026-11-08 16:54:46'),
(1233, NULL, '406aa1ed-ed0a-4ae1-9971-d24e05d2bd04', 'active', '2026-11-08 16:54:49', '2026-11-08 16:54:49'),
(1234, NULL, '8212e588-592f-4c14-8d31-94eafe64fa99', 'active', '2026-11-08 16:54:50', '2026-11-08 16:54:50'),
(1235, NULL, 'e1a367aa-73a9-45cb-84ae-7977b44fff26', 'active', '2026-11-08 16:54:53', '2026-11-08 16:54:53'),
(1236, NULL, '52f95b14-d41c-44d2-9c17-5c638cda284d', 'active', '2026-11-08 16:54:54', '2026-11-08 16:54:54'),
(1237, NULL, 'e1dfa659-4732-4a5e-beda-dfca7293db0a', 'active', '2026-11-08 16:54:57', '2026-11-08 16:54:57'),
(1238, NULL, 'f8563bd3-47d1-4398-bf42-d14498be1b1b', 'active', '2026-11-08 16:54:59', '2026-11-08 16:54:59'),
(1239, NULL, 'b9bc5b46-309e-4174-a342-f72c1a64b61f', 'active', '2026-11-08 16:55:01', '2026-11-08 16:55:01'),
(1240, NULL, 'cbe52975-e2c3-4eb1-b414-8c7a4aa7bc5e', 'active', '2026-11-08 16:55:03', '2026-11-08 16:55:03'),
(1241, NULL, '84e0a7c7-184b-494f-ab88-0148ee6c9dd5', 'active', '2026-11-08 16:55:06', '2026-11-08 16:55:06'),
(1242, NULL, 'cd2b80fe-c3ac-4f21-b590-fccbc6a63743', 'active', '2026-11-08 16:55:07', '2026-11-08 16:55:07'),
(1243, NULL, 'c15895f8-7d92-448b-b154-8afcb59402bf', 'active', '2026-11-08 16:55:10', '2026-11-08 16:55:10'),
(1244, NULL, 'a631dd8e-77de-416f-ab45-3502a84a6828', 'active', '2026-11-08 16:55:12', '2026-11-08 16:55:12'),
(1245, NULL, '60ec1cc9-81bd-46d8-a7cd-4a6f543c4c2a', 'active', '2026-11-08 16:55:14', '2026-11-08 16:55:14'),
(1246, NULL, 'f7cf64eb-1182-4f99-b096-5ef1397270d1', 'active', '2026-11-08 16:55:16', '2026-11-08 16:55:16'),
(1247, NULL, 'ca4751c1-4319-49b5-b8ea-df66f34b8ba8', 'active', '2026-11-08 16:55:19', '2026-11-08 16:55:19'),
(1248, NULL, '4d3efb36-66c4-4621-bcfa-00dbbfa76842', 'active', '2026-11-08 16:55:20', '2026-11-08 16:55:20'),
(1249, NULL, 'edaef33f-4c67-4da0-bc65-51bb5aef7b4a', 'active', '2026-11-08 16:55:23', '2026-11-08 16:55:23'),
(1250, NULL, '9019bb8d-257d-4f20-96ea-04959c3a51e1', 'active', '2026-11-08 16:55:24', '2026-11-08 16:55:24'),
(1251, NULL, 'ef6aee25-3135-41e7-8652-55defeed1157', 'active', '2026-11-08 16:55:27', '2026-11-08 16:55:27'),
(1252, NULL, '73ae14a9-9b83-4bc5-af15-010663fb5f93', 'active', '2026-11-08 16:55:28', '2026-11-08 16:55:28'),
(1253, NULL, 'f65fc5f9-baaa-4a17-83a9-1f6f931f39ec', 'active', '2026-11-08 16:55:31', '2026-11-08 16:55:31'),
(1254, NULL, '4487590e-0d2c-41ba-bac9-825be051df48', 'active', '2026-11-08 16:55:33', '2026-11-08 16:55:33'),
(1255, NULL, '97994d0f-7d2d-4cd1-aa0b-176c7238c366', 'active', '2026-11-08 16:55:35', '2026-11-08 16:55:35'),
(1256, NULL, '15d0638b-1c1f-4df0-b3dd-6754c04042ce', 'active', '2026-11-08 16:55:37', '2026-11-08 16:55:37'),
(1257, NULL, 'ef4ea30d-7892-4ca0-8011-0271a3362b67', 'active', '2026-11-08 16:55:40', '2026-11-08 16:55:40'),
(1258, NULL, 'c3f5cd66-1bb3-482c-9409-af3d00ffcbb8', 'active', '2026-11-08 16:55:41', '2026-11-08 16:55:41'),
(1259, NULL, '70ecbdad-d8a3-49b9-a06e-7d8d9c6d3487', 'active', '2026-11-08 16:55:44', '2026-11-08 16:55:44'),
(1260, NULL, '167365cc-fad8-4198-8857-f40d897aefde', 'active', '2026-11-08 16:55:46', '2026-11-08 16:55:46'),
(1261, NULL, '8327c63e-f74b-4e69-8267-a251ac6d5201', 'active', '2026-11-08 16:55:48', '2026-11-08 16:55:48'),
(1262, NULL, '17a40a21-375c-42ce-b525-51bbbfc8be0e', 'active', '2026-11-08 16:55:50', '2026-11-08 16:55:50'),
(1263, NULL, '3c1d0a43-e9ba-4ef4-a72c-9d585f06323d', 'active', '2026-11-08 16:55:53', '2026-11-08 16:55:53'),
(1264, NULL, '15eff062-3a6d-4231-8d10-cc687882db68', 'active', '2026-11-08 16:55:54', '2026-11-08 16:55:54'),
(1265, NULL, 'ccddb91d-d020-49e5-93c4-d1d98225ace5', 'active', '2026-11-08 16:55:57', '2026-11-08 16:55:57'),
(1266, NULL, '5b1a72d3-52b3-41d5-87b2-e46ba08ed426', 'active', '2026-11-08 16:55:58', '2026-11-08 16:55:58'),
(1267, NULL, '08a0ab04-2e98-4189-960b-b00daf9da3d1', 'active', '2026-11-08 16:56:01', '2026-11-08 16:56:01'),
(1268, NULL, '28aa818e-08ba-4d6b-bee8-4cf3324ad823', 'active', '2026-11-08 16:56:03', '2026-11-08 16:56:03'),
(1269, NULL, '5c26e18d-cec2-452d-8807-d46a01fe75d7', 'active', '2026-11-08 16:56:05', '2026-11-08 16:56:05'),
(1270, NULL, 'f96f2d45-6f30-4bf7-9f31-edc76eb8a453', 'active', '2026-11-08 16:56:07', '2026-11-08 16:56:07'),
(1271, NULL, 'ff2a1f37-5398-4be7-8331-fece6ec6972d', 'active', '2026-11-08 16:56:10', '2026-11-08 16:56:10'),
(1272, NULL, '2a5bffb0-848c-4ee5-ae03-891710a85593', 'active', '2026-11-08 16:56:11', '2026-11-08 16:56:11'),
(1273, NULL, 'c1049c30-bb3f-4912-be4c-7374745ad482', 'active', '2026-11-08 16:56:14', '2026-11-08 16:56:14'),
(1274, NULL, '4aaf9403-1dde-4253-92a1-b75918969f01', 'active', '2026-11-08 16:56:16', '2026-11-08 16:56:16'),
(1275, NULL, 'ba3b2691-cc05-421f-93c4-ea24803b852c', 'active', '2026-11-08 16:56:18', '2026-11-08 16:56:18'),
(1276, NULL, 'bfa2aa68-31ac-4f02-8c08-2319eedf2934', 'active', '2026-11-08 16:56:20', '2026-11-08 16:56:20'),
(1277, NULL, 'd9ee57e8-5815-4206-8148-924b59b70ea9', 'active', '2026-11-08 16:56:23', '2026-11-08 16:56:23'),
(1278, NULL, '7a348a7b-6aad-4db4-8c02-b6c0b767162e', 'active', '2026-11-08 16:56:24', '2026-11-08 16:56:24'),
(1279, NULL, '1f03c8e8-fd5f-4506-ad59-1584847b77e1', 'active', '2026-11-08 16:56:27', '2026-11-08 16:56:27'),
(1280, NULL, 'd0900222-14aa-423a-b5f5-3ad6188c53ff', 'active', '2026-11-08 16:56:28', '2026-11-08 16:56:28'),
(1281, NULL, '6f6abc2a-4b32-460a-bcd9-cf080c8e7af9', 'active', '2026-11-08 16:56:31', '2026-11-08 16:56:31'),
(1282, NULL, 'edd4529d-1607-4cae-bf39-6288e33a954c', 'active', '2026-11-08 16:56:32', '2026-11-08 16:56:32'),
(1283, NULL, '172af1e8-83d8-43de-9660-305954b04e6e', 'active', '2026-11-08 16:56:35', '2026-11-08 16:56:35'),
(1284, NULL, 'a26d9355-b0d2-4830-9f3a-515064236d25', 'active', '2026-11-08 16:56:37', '2026-11-08 16:56:37'),
(1285, NULL, '24e2e837-a4d4-459a-9fd3-b3d7857c5063', 'active', '2026-11-08 16:56:39', '2026-11-08 16:56:39'),
(1286, NULL, '449b6f9d-3f5e-4eb2-8cf9-dbcaddc7ec13', 'active', '2026-11-08 16:56:41', '2026-11-08 16:56:41'),
(1287, NULL, '447164b4-470b-4733-9786-d9aaa2dba5f8', 'active', '2026-11-08 16:56:43', '2026-11-08 16:56:43'),
(1288, NULL, 'a70409dc-bdaf-4b68-a257-2dac02f44214', 'active', '2026-11-08 16:56:45', '2026-11-08 16:56:45'),
(1289, NULL, '1f3cae6a-6c4f-48fd-b189-91b0f4d74843', 'active', '2026-11-08 16:56:47', '2026-11-08 16:56:47'),
(1290, NULL, 'c30cbeb4-8a93-4637-8600-26dc45c76a74', 'active', '2026-11-08 16:56:49', '2026-11-08 16:56:49'),
(1291, NULL, 'cc04a70a-0565-4a7d-a153-2b86431766ca', 'active', '2026-11-08 16:56:52', '2026-11-08 16:56:52'),
(1292, NULL, '3f251661-a379-481c-bae2-7f20e896542f', 'active', '2026-11-08 16:56:53', '2026-11-08 16:56:53'),
(1293, NULL, '3c29a66d-fded-4b3c-b44d-222f11e59f38', 'active', '2026-11-08 16:56:56', '2026-11-08 16:56:56'),
(1294, NULL, '7e28f089-8245-48a2-886b-aad5f059f7d8', 'active', '2026-11-08 16:56:57', '2026-11-08 16:56:57'),
(1295, NULL, '99949dea-fa6a-4ffd-90d6-bedf82822303', 'active', '2026-11-08 16:57:00', '2026-11-08 16:57:00'),
(1296, NULL, 'a40e4975-395c-4f45-8c4d-d64b3ea9945f', 'active', '2026-11-08 16:57:01', '2026-11-08 16:57:01'),
(1297, NULL, '28c15cf3-75d8-4a1b-9be1-9818fcb6f7ee', 'active', '2026-11-08 16:57:04', '2026-11-08 16:57:04'),
(1298, NULL, '21fff067-c29c-495e-9abd-59588f03d3b7', 'active', '2026-11-08 16:57:06', '2026-11-08 16:57:06'),
(1299, NULL, 'dd4e532b-3e22-48ed-8dd6-eaf4927641ba', 'active', '2026-11-08 16:57:08', '2026-11-08 16:57:08'),
(1300, NULL, '434f63eb-afde-4311-8507-88d686c72e71', 'active', '2026-11-08 16:57:10', '2026-11-08 16:57:10'),
(1301, NULL, '998a11c0-1b14-4fb6-a207-61a5918db037', 'active', '2026-11-08 16:57:12', '2026-11-08 16:57:12'),
(1302, NULL, '060bd157-139c-4c84-880e-088d09d8b1b7', 'active', '2026-11-08 16:57:14', '2026-11-08 16:57:14'),
(1303, NULL, '99bffbbe-c91e-4ff8-90a0-55567d3f1d71', 'active', '2026-11-08 16:57:17', '2026-11-08 16:57:17'),
(1304, NULL, '79223e3d-4d73-474a-a196-75171f4f9694', 'active', '2026-11-08 16:57:18', '2026-11-08 16:57:18'),
(1305, NULL, 'f17b7180-dd98-4c43-9974-8af419c10290', 'active', '2026-11-08 16:57:21', '2026-11-08 16:57:21'),
(1306, NULL, 'b8e54c2f-4ebe-4d0f-9b86-f8a8fb5eeda6', 'active', '2026-11-08 16:57:22', '2026-11-08 16:57:22'),
(1307, NULL, 'ecabecaf-acf1-4408-ab53-337465fe3064', 'active', '2026-11-08 16:57:25', '2026-11-08 16:57:25'),
(1308, NULL, 'a47910d3-6ee2-48ea-ac79-9b2dcd19ab15', 'active', '2026-11-08 16:57:27', '2026-11-08 16:57:27'),
(1309, NULL, '3f1f3be4-d369-4a53-a076-91d195ed0730', 'active', '2026-11-08 16:57:29', '2026-11-08 16:57:29'),
(1310, NULL, 'f1dcd177-e0f4-4717-b244-380361c1528f', 'active', '2026-11-08 16:57:31', '2026-11-08 16:57:31'),
(1311, NULL, 'e2830384-62e9-4b8a-bd1a-7ceb5eb03471', 'active', '2026-11-08 16:57:33', '2026-11-08 16:57:33'),
(1312, NULL, '59c4b386-da89-429b-a8e6-cb164aa093b9', 'active', '2026-11-08 16:57:35', '2026-11-08 16:57:35'),
(1313, NULL, 'efe99752-03c1-4913-ab5c-2b8f4323bfd5', 'active', '2026-11-08 16:57:38', '2026-11-08 16:57:38'),
(1314, NULL, '04641982-1fed-41ab-a51c-2549864beb76', 'active', '2026-11-08 16:57:39', '2026-11-08 16:57:39'),
(1315, NULL, '504d181a-9208-44c4-9f50-35851cf53a76', 'active', '2026-11-08 16:57:42', '2026-11-08 16:57:42'),
(1316, NULL, '5f2faeca-b291-4b6d-adf8-451e140373de', 'active', '2026-11-08 16:57:43', '2026-11-08 16:57:43'),
(1317, NULL, '31fbbbdd-f662-4b11-80de-cb5ad56aee7d', 'active', '2026-11-08 16:57:46', '2026-11-08 16:57:46'),
(1318, NULL, '35239a33-9bc5-476b-ab31-b7285251c4e4', 'active', '2026-11-08 16:57:47', '2026-11-08 16:57:47'),
(1319, NULL, '13b6b740-0803-4e53-89c3-0e8ceaa75e1c', 'active', '2026-11-08 16:57:50', '2026-11-08 16:57:50'),
(1320, NULL, 'b3fc19a4-136b-4e8f-94b3-b7cec8f9afc4', 'active', '2026-11-08 16:57:52', '2026-11-08 16:57:52'),
(1321, NULL, '2d84064a-d340-4fe8-886e-f818c64ae539', 'active', '2026-11-08 16:57:54', '2026-11-08 16:57:54'),
(1322, NULL, 'a9a5dcdb-b32a-4b4b-b2ba-aea88d4fc806', 'active', '2026-11-08 16:57:56', '2026-11-08 16:57:56'),
(1323, NULL, 'a5d847e6-2e1a-4288-b033-971169f80682', 'active', '2026-11-08 16:57:59', '2026-11-08 16:57:59'),
(1324, NULL, '197f3221-f692-448f-8cb5-cdd53a92d5d9', 'active', '2026-11-08 16:58:00', '2026-11-08 16:58:00'),
(1325, NULL, '61408157-8e25-4715-b9bd-58f82317d341', 'active', '2026-11-08 16:58:03', '2026-11-08 16:58:03'),
(1326, NULL, '3632c347-d46a-4db6-a951-7c3686e2a691', 'active', '2026-11-08 16:58:05', '2026-11-08 16:58:05'),
(1327, NULL, '2ca64c8e-0b37-40d6-aa19-e225ea0a74de', 'active', '2026-11-08 16:58:07', '2026-11-08 16:58:07'),
(1328, NULL, '12553897-9659-48a5-a32e-9a19187ef076', 'active', '2026-11-08 16:58:09', '2026-11-08 16:58:09'),
(1329, NULL, '2fd72157-bc64-4448-9891-31df2edca666', 'active', '2026-11-08 16:58:12', '2026-11-08 16:58:12'),
(1330, NULL, '4db5c04b-86b5-489c-9c37-e8c5db46dc3d', 'active', '2026-11-08 16:58:13', '2026-11-08 16:58:13'),
(1331, NULL, 'c4b120e8-2c94-4eac-9ba6-2767fb3b2af0', 'active', '2026-11-08 16:58:16', '2026-11-08 16:58:16'),
(1332, NULL, '06715a51-dbeb-4d1f-9dab-92c0f9f10f5a', 'active', '2026-11-08 16:58:17', '2026-11-08 16:58:17'),
(1333, NULL, 'baf4d9ab-075e-436f-bd0f-a9987f5f8db2', 'active', '2026-11-08 16:58:20', '2026-11-08 16:58:20'),
(1334, NULL, 'efcd63c3-dd4c-4bda-9654-48049acbc4ba', 'active', '2026-11-08 16:58:21', '2026-11-08 16:58:21'),
(1335, NULL, '86f4125c-b098-4e67-9d2f-a2ac293f306a', 'active', '2026-11-08 16:58:24', '2026-11-08 16:58:24'),
(1336, NULL, '03603fff-e39c-4cf7-9ab1-a3fbb4713a09', 'active', '2026-11-08 16:58:26', '2026-11-08 16:58:26'),
(1337, NULL, '3a8c95d1-1f4d-4f31-bcb6-056f27dd421d', 'active', '2026-11-08 16:58:28', '2026-11-08 16:58:28'),
(1338, NULL, '5bf371fb-1ece-43d3-be93-9eb93726301a', 'active', '2026-11-08 16:58:30', '2026-11-08 16:58:30'),
(1339, NULL, 'e0791929-34a6-4463-b28c-30c5b19b8331', 'active', '2026-11-08 16:58:31', '2026-11-08 16:58:31'),
(1340, NULL, '57209980-a07d-457c-b105-467237206a95', 'active', '2026-11-08 16:58:33', '2026-11-08 16:58:33'),
(1341, NULL, '8a41784f-a677-4642-94ec-05e305e8add0', 'active', '2026-11-08 16:58:34', '2026-11-08 16:58:34'),
(1342, NULL, '3afd9c2c-2098-408c-8d14-36cf3887f782', 'active', '2026-11-08 16:58:36', '2026-11-08 16:58:36'),
(1343, NULL, '623ec028-fe18-44c8-a187-1a8030edd3cf', 'active', '2026-11-08 16:58:37', '2026-11-08 16:58:37'),
(1344, NULL, '608698c4-fb83-4807-87a1-8e63d05dc57e', 'active', '2026-11-08 16:58:39', '2026-11-08 16:58:39'),
(1345, NULL, '7f502036-6575-4ddc-a356-8b9af76e7d06', 'active', '2026-11-08 16:58:41', '2026-11-08 16:58:41'),
(1346, NULL, '9626739c-a165-462f-9050-1dc807b2f75b', 'active', '2026-11-08 16:58:43', '2026-11-08 16:58:43'),
(1347, NULL, '6f1ce25a-9771-4d8f-a539-0b306c295252', 'active', '2026-11-08 16:58:44', '2026-11-08 16:58:44'),
(1348, NULL, '2cacd836-c4ce-437c-a034-d999093966ec', 'active', '2026-11-08 16:58:46', '2026-11-08 16:58:46'),
(1349, NULL, '26fe5480-7437-4363-9452-23e514e841df', 'active', '2026-11-08 16:58:47', '2026-11-08 16:58:47'),
(1350, NULL, 'a476665c-d515-4959-a178-d9d1c3ae8b89', 'active', '2026-11-08 16:58:47', '2026-11-08 16:58:47'),
(1351, NULL, 'b1689b69-9995-41f2-9a1c-03089c1571f9', 'active', '2026-11-08 16:58:49', '2026-11-08 16:58:49'),
(1352, NULL, '0cd3f4a6-b54f-4334-a9c6-5961c1625d51', 'active', '2026-11-08 16:58:50', '2026-11-08 16:58:50'),
(1353, NULL, '77a71144-a61b-4bcc-abc4-ec0744ae1953', 'active', '2026-11-08 16:58:53', '2026-11-08 16:58:53'),
(1354, NULL, 'c2e51d72-aea0-4b6a-9b2d-b33966e3512c', 'active', '2026-11-08 16:58:55', '2026-11-08 16:58:55'),
(1355, NULL, 'c4dd2ae2-9b67-49c2-b73b-0b4aa3d8a004', 'active', '2026-11-08 16:58:58', '2026-11-08 16:58:58'),
(1356, NULL, '80692b5a-312c-4112-b6c5-d39915582f62', 'active', '2026-11-08 16:59:00', '2026-11-08 16:59:00'),
(1357, NULL, '65a1f591-5cda-49ad-8d37-0bcd15282547', 'active', '2026-11-08 16:59:01', '2026-11-08 16:59:01'),
(1358, NULL, '9da3c37b-a9a5-4d46-ba33-8b15ff453d46', 'active', '2026-11-08 16:59:03', '2026-11-08 16:59:03'),
(1359, NULL, '09480187-fbc4-4176-a141-83c77d645e14', 'active', '2026-11-08 16:59:04', '2026-11-08 16:59:04'),
(1360, NULL, '8dc700c9-5ebe-4ae9-bbcd-c286065d5920', 'active', '2026-11-08 16:59:06', '2026-11-08 16:59:06'),
(1361, NULL, 'f858da8f-da37-4fcf-9fd5-7bd211184e7e', 'active', '2026-11-08 16:59:07', '2026-11-08 16:59:07'),
(1362, NULL, '93bc1c15-9983-41e6-9cd2-c6988510d9fe', 'active', '2026-11-08 16:59:09', '2026-11-08 16:59:09'),
(1363, NULL, '28adecfe-d8c0-4eb4-bbb7-263ab230c4c4', 'active', '2026-11-08 16:59:10', '2026-11-08 16:59:10'),
(1364, NULL, '52ceb23e-72ce-4696-9566-58c4be07181a', 'active', '2026-11-08 16:59:12', '2026-11-08 16:59:12'),
(1365, NULL, '2bbcecd7-396a-422c-8758-76a8d56a4d19', 'active', '2026-11-08 16:59:13', '2026-11-08 16:59:13'),
(1366, NULL, '8be76119-4be9-466c-9f90-1e39ea3db43f', 'active', '2026-11-08 16:59:16', '2026-11-08 16:59:16'),
(1367, NULL, '16e42b3f-f929-4e8b-8742-e34d8195430a', 'active', '2026-11-08 16:59:17', '2026-11-08 16:59:17'),
(1368, NULL, '49110bef-a441-4f07-a013-68c1d4da0923', 'active', '2026-11-08 16:59:20', '2026-11-08 16:59:20'),
(1369, NULL, '5690721b-df5d-484c-9156-36ee99ff3453', 'active', '2026-11-08 16:59:21', '2026-11-08 16:59:21'),
(1370, NULL, 'e0293430-5f54-4bf0-8d9f-2a04cf1a74c0', 'active', '2026-11-08 16:59:24', '2026-11-08 16:59:24'),
(1371, NULL, 'b36a51ef-f944-4c2c-829a-6a8533a24eec', 'active', '2026-11-08 16:59:25', '2026-11-08 16:59:25'),
(1372, NULL, 'cdb4d74f-3668-4799-b540-084cf01bea59', 'active', '2026-11-08 16:59:28', '2026-11-08 16:59:28'),
(1373, NULL, '7126a5e2-411e-4351-af43-301b34faa954', 'active', '2026-11-08 16:59:30', '2026-11-08 16:59:30'),
(1374, NULL, '4625f037-78d0-4514-a805-a742059772c2', 'active', '2026-11-08 16:59:32', '2026-11-08 16:59:32'),
(1375, NULL, '19147f9f-13bc-4902-9c97-6e2fab3ef292', 'active', '2026-11-08 16:59:34', '2026-11-08 16:59:34'),
(1376, NULL, '90515b4d-e1ea-4fef-be49-c0aca28d3240', 'active', '2026-11-08 16:59:36', '2026-11-08 16:59:36'),
(1377, NULL, 'cd347578-f1f8-4f73-8042-e5be0d40ed12', 'active', '2026-11-08 16:59:38', '2026-11-08 16:59:38'),
(1378, NULL, '8d1c9652-5d1f-4d34-9246-609b8b1e9b62', 'active', '2026-11-08 16:59:41', '2026-11-08 16:59:41'),
(1379, NULL, 'b0a75505-602f-44d1-8879-f712a71eadbc', 'active', '2026-11-08 16:59:42', '2026-11-08 16:59:42'),
(1380, NULL, 'dd335b8d-e4d7-48e5-9b06-46c8f1fd4300', 'active', '2026-11-08 16:59:44', '2026-11-08 16:59:44'),
(1381, NULL, 'ba868b3c-3e47-4554-8259-3d410eee5bbb', 'active', '2026-11-08 16:59:45', '2026-11-08 16:59:45'),
(1382, NULL, '027db019-de66-4581-bfda-e2fa9cf5b606', 'active', '2026-11-08 16:59:47', '2026-11-08 16:59:47'),
(1383, NULL, 'eb04224b-c507-456b-bcd3-b5547fbb8fd7', 'active', '2026-11-08 16:59:49', '2026-11-08 16:59:49'),
(1384, NULL, '1590bbfd-9f2e-4c97-9b08-b276ccfb0717', 'active', '2026-11-08 16:59:51', '2026-11-08 16:59:51'),
(1385, NULL, '60554611-14a9-44e4-b416-9ee0f8bd2deb', 'active', '2026-11-08 16:59:53', '2026-11-08 16:59:53'),
(1386, NULL, '660a9c37-8b8c-4b5c-91e0-eb6137248d1f', 'active', '2026-11-08 16:59:55', '2026-11-08 16:59:55'),
(1387, NULL, 'bfcd19ae-3f7e-4cfc-9d15-6ee06aecb0c6', 'active', '2026-11-08 16:59:58', '2026-11-08 16:59:58'),
(1388, NULL, '84971bb0-f981-4e35-b539-e8d9e994730c', 'active', '2026-11-08 16:59:59', '2026-11-08 16:59:59'),
(1389, NULL, '6f6525a3-e535-4d77-b1a6-c2e47fbefb77', 'active', '2026-11-08 17:00:01', '2026-11-08 17:00:01'),
(1390, NULL, '952fa61e-33df-4789-bdfc-144f3eeb2e65', 'active', '2026-11-08 17:00:02', '2026-11-08 17:00:02'),
(1391, NULL, '7273fa15-dd3c-4f55-8daf-094fd012e73a', 'active', '2026-11-08 17:04:19', '2026-11-08 17:04:19'),
(1392, NULL, '17b2c52c-f1ea-408c-99f3-fb9e421d5f8c', 'active', '2026-11-08 18:00:20', '2026-11-08 18:00:20'),
(1393, NULL, 'fa3b44c9-52ec-4f41-a4a4-3858f7126191', 'active', '2026-11-08 18:04:41', '2026-11-08 18:04:41'),
(1394, NULL, 'c39fdb8f-edbb-4957-82e4-304610ff7aa2', 'active', '2026-11-08 18:06:19', '2026-11-08 18:06:19'),
(1395, NULL, '20e295bf-71fd-4647-b692-7ec65fb6407b', 'active', '2026-11-08 18:08:40', '2026-11-08 18:08:40'),
(1396, NULL, '93c52cf0-728b-4f36-83ba-0110caf89e71', 'active', '2026-11-08 18:42:05', '2026-11-08 18:42:05'),
(1397, NULL, '89d12490-9290-4f22-984a-4f78a38713aa', 'active', '2026-11-08 18:42:08', '2026-11-08 18:42:08');
INSERT INTO `carts` (`id`, `customer_id`, `session_id`, `status`, `created_at`, `updated_at`) VALUES
(1398, NULL, 'b9d54214-3004-4197-b04d-3382998993f2', 'active', '2026-11-08 18:42:12', '2026-11-08 18:42:12'),
(1399, NULL, 'd2560e70-df54-4f9c-9df9-c8151852e829', 'active', '2026-11-08 18:42:33', '2026-11-08 18:42:33'),
(1400, NULL, '0296a2cd-3616-495d-a602-de040692bd75', 'active', '2026-11-08 18:43:04', '2026-11-08 18:43:04'),
(1401, NULL, 'd290fff7-3178-4852-833b-5a921d76e6d2', 'active', '2026-11-08 18:54:36', '2026-11-08 18:54:36'),
(1402, NULL, '72162684-bfe6-4250-b833-6b12b2dccee4', 'active', '2026-11-08 19:43:13', '2026-11-08 19:43:13'),
(1403, NULL, '78fa7014-6d8d-40a8-95ba-7e7cd1cdc8bd', 'active', '2026-11-08 20:06:49', '2026-11-08 20:06:49'),
(1404, NULL, '4b6949f1-7b24-4dcf-9e68-8cf9b212f395', 'active', '2026-11-08 20:14:28', '2026-11-08 20:14:28'),
(1405, NULL, 'c73486e5-0df3-49ee-a158-9c7294a04533', 'active', '2026-11-08 20:33:47', '2026-11-08 20:33:47'),
(1406, NULL, 'ff1e6cec-7ad4-4e89-bd94-1863033d0c18', 'active', '2026-11-08 21:11:37', '2026-11-08 21:11:37'),
(1407, NULL, '82108c1c-593c-41ad-9e6d-ee58995ecdcb', 'active', '2026-11-08 21:19:43', '2026-11-08 21:19:43'),
(1408, NULL, 'cc2cb616-0a38-4dd6-a114-2ddbe40c57ee', 'active', '2026-11-08 21:52:53', '2026-11-08 21:52:53'),
(1409, NULL, '254a0300-4534-42c2-ab85-dd1790406c38', 'active', '2026-11-08 22:12:06', '2026-11-08 22:12:06'),
(1410, NULL, '748336e3-38de-4d94-8cdc-e7ecd3b10fd0', 'active', '2026-11-08 22:17:52', '2026-11-08 22:17:52'),
(1411, NULL, '3b0233ab-7506-469c-82cf-94465afbf5aa', 'active', '2026-11-08 22:23:04', '2026-11-08 22:23:04'),
(1412, NULL, '0172cad0-f12b-4c0a-9cfc-1e1d45a50e46', 'active', '2026-11-08 22:35:08', '2026-11-08 22:35:08'),
(1413, NULL, '1acdbcac-af6f-4d63-802b-f774aeb0e00d', 'active', '2026-11-08 22:36:17', '2026-11-08 22:36:17'),
(1414, NULL, '39a1211e-5350-4359-a6d7-a43dad366288', 'active', '2026-11-08 22:46:20', '2026-11-08 22:46:20'),
(1415, NULL, '4dedebe1-5a7f-4637-b289-2d8fcb0da186', 'active', '2026-11-08 22:56:36', '2026-11-08 22:56:36'),
(1416, NULL, '8bdc74eb-cc94-4d73-a1a5-c04364c98ac4', 'active', '2026-11-08 23:07:22', '2026-11-08 23:07:22'),
(1417, NULL, '05968f62-7b01-487d-84c4-4e6eefe32090', 'active', '2026-11-08 23:16:54', '2026-11-08 23:16:54'),
(1418, NULL, '1275dd1d-b9a9-4b92-a8ce-028b4ceb5efb', 'active', '2026-11-08 23:26:03', '2026-11-08 23:26:03'),
(1419, NULL, 'b291181a-de08-4a2f-92c4-70fc69289c1a', 'active', '2026-11-08 23:39:12', '2026-11-08 23:39:12'),
(1420, NULL, '44ea6f46-98c1-4707-8895-3247c3e9168c', 'active', '2026-11-08 23:47:16', '2026-11-08 23:47:16'),
(1421, NULL, '3b2da72a-9fd8-43f2-8d29-e9ccf29c7af3', 'active', '2026-11-08 23:56:00', '2026-11-08 23:56:00'),
(1422, NULL, 'b2436065-c142-42df-873d-ab2b6a68bb4a', 'active', '2026-11-08 23:57:27', '2026-11-08 23:57:27'),
(1423, NULL, '856cf153-5f64-4f88-a243-e20b420ee32e', 'active', '2026-11-08 23:57:42', '2026-11-08 23:57:42'),
(1424, NULL, 'd6892537-4460-447d-93db-5049a4a88424', 'active', '2026-11-08 23:58:27', '2026-11-08 23:58:27'),
(1425, NULL, 'fd718138-77b7-4d34-8919-893a90592809', 'active', '2026-11-08 23:59:29', '2026-11-08 23:59:29'),
(1426, NULL, '18154e76-c98b-4f56-bed7-c7dc98c17a07', 'active', '2026-11-09 00:02:45', '2026-11-09 00:02:45'),
(1427, NULL, '6d543599-7c1c-4f54-b604-5f8520002444', 'active', '2026-11-09 00:05:49', '2026-11-09 00:05:49'),
(1428, NULL, 'ba723813-1016-4d08-af31-489cec2e4de1', 'active', '2026-11-09 00:16:13', '2026-11-09 00:16:13'),
(1429, NULL, '3607b837-a15b-4e94-b4f6-c8493e76b020', 'active', '2026-11-09 00:25:54', '2026-11-09 00:25:54'),
(1430, NULL, 'aecf5679-62ea-4351-a6d3-00be9e32eb25', 'active', '2026-11-09 00:33:15', '2026-11-09 00:33:15'),
(1431, NULL, '3915a4c8-f48f-485b-a649-28ae01e2f37b', 'active', '2026-11-09 00:34:11', '2026-11-09 00:34:11'),
(1432, NULL, 'e93ea4ba-51e3-4f42-99b0-c0d39629d8b9', 'active', '2026-11-09 00:39:00', '2026-11-09 00:39:00'),
(1433, NULL, 'db9f1b92-9f47-4a72-9392-6d3addd7ebf3', 'active', '2026-11-09 00:46:40', '2026-11-09 00:46:40'),
(1434, NULL, '26ec5590-7146-4afa-bb62-5f94d767572f', 'active', '2026-11-09 00:56:54', '2026-11-09 00:56:54'),
(1435, NULL, '6c443496-c49c-46f9-80cb-a88f5b6cea79', 'active', '2026-11-09 01:09:49', '2026-11-09 01:09:49'),
(1436, NULL, '107e12b8-7905-49a4-a93f-c99551cefce0', 'active', '2026-11-09 01:13:04', '2026-11-09 01:13:04'),
(1437, NULL, '73c0eb47-8100-4a35-bc8d-8be9b45d711a', 'active', '2026-11-09 01:19:00', '2026-11-09 01:19:00'),
(1438, NULL, '1d714f4f-3c4a-49f0-ad91-0d4111683bd0', 'active', '2026-11-09 01:23:51', '2026-11-09 01:23:51'),
(1439, NULL, '4b7973a2-c048-4775-9582-0cca97badf47', 'active', '2026-11-09 01:28:34', '2026-11-09 01:28:34'),
(1440, NULL, '028f7ec7-82db-4fd3-8cf3-3effdc4e6ac9', 'active', '2026-11-09 01:38:29', '2026-11-09 01:38:29'),
(1441, NULL, '986d8657-1184-4360-9175-3e4684501e33', 'active', '2026-11-09 01:44:14', '2026-11-09 01:44:14'),
(1442, NULL, '5154a71f-5b4f-42a0-b868-110d7858ba84', 'active', '2026-11-09 01:46:27', '2026-11-09 01:46:27'),
(1443, NULL, '764a492d-5531-453e-9d9c-e7e42a1a027a', 'active', '2026-11-09 01:46:31', '2026-11-09 01:46:31'),
(1444, NULL, '549edfeb-294d-4a66-98a2-7187fa80f469', 'active', '2026-11-09 01:55:33', '2026-11-09 01:55:33'),
(1445, NULL, '709ade5f-9c3f-45b8-bfb7-728253a5ad9b', 'active', '2026-11-09 01:56:58', '2026-11-09 01:56:58'),
(1446, NULL, 'f30e20b1-6578-4d4b-aeb8-eb3dde1ef259', 'active', '2026-11-09 02:07:20', '2026-11-09 02:07:20'),
(1447, NULL, 'dfc4d98e-5fb1-4813-ac14-87e2f1d61802', 'active', '2026-11-09 02:18:45', '2026-11-09 02:18:45'),
(1448, NULL, 'd5fa2b77-4750-41b8-bff3-a1e4dcea51c7', 'active', '2026-11-09 02:25:12', '2026-11-09 02:25:12'),
(1449, NULL, 'b74f5a10-1f1b-4996-86b2-197a4aa24848', 'active', '2026-11-09 02:37:27', '2026-11-09 02:37:27'),
(1450, NULL, 'cc60e5a3-d9f1-4692-97aa-a7467fbcf19c', 'active', '2026-11-09 02:47:28', '2026-11-09 02:47:28'),
(1451, NULL, 'a0d330b4-9b5e-4b98-bbb0-d3de8e27d945', 'active', '2026-11-09 02:56:24', '2026-11-09 02:56:24'),
(1452, NULL, '3e8e5863-eb64-45d9-9f36-4ab93a8b4f73', 'active', '2026-11-09 03:04:47', '2026-11-09 03:04:47'),
(1453, NULL, '5e70804a-4700-4fd0-8756-32adcd93dc5e', 'active', '2026-11-09 03:16:49', '2026-11-09 03:16:49'),
(1454, NULL, 'a57ce7a8-0d64-4cf6-9a9f-c31aab672b96', 'active', '2026-11-09 03:29:43', '2026-11-09 03:29:43'),
(1455, NULL, 'f04cae29-6a24-4ed3-8d7d-d7082cc385ba', 'active', '2026-11-09 03:30:16', '2026-11-09 03:30:16'),
(1456, NULL, '84fea9f8-38f2-4d04-af3c-f3f25838afb3', 'active', '2026-11-09 03:30:28', '2026-11-09 03:30:28'),
(1457, NULL, 'c3875079-4c30-4bac-89e7-f502439be180', 'active', '2026-11-09 03:30:44', '2026-11-09 03:30:44'),
(1458, NULL, '55ec3b16-f5d3-4e20-b88d-eedd4fb04f22', 'active', '2026-11-09 03:31:14', '2026-11-09 03:31:14'),
(1459, NULL, '1d0448e3-a25a-48ef-8c80-5cfb76096e3e', 'active', '2026-11-09 03:31:29', '2026-11-09 03:31:29'),
(1460, NULL, '6d7de1f0-7710-4ec4-b16b-e9cdb8fa99c1', 'active', '2026-11-09 03:31:44', '2026-11-09 03:31:44'),
(1461, NULL, '470fc8db-9560-4770-8f24-c6df6e085461', 'active', '2026-11-09 03:32:20', '2026-11-09 03:32:20'),
(1462, NULL, 'ff67aab9-f33a-4676-8819-3a65a3473892', 'active', '2026-11-09 03:32:34', '2026-11-09 03:32:34'),
(1463, NULL, '3656d238-e4be-46d4-b7ba-a2d0a1f16557', 'active', '2026-11-09 04:01:39', '2026-11-09 04:01:39'),
(1464, NULL, 'd1010356-3a45-4ef3-a7ee-12a53e40dd5e', 'active', '2026-11-09 04:28:51', '2026-11-09 04:28:51'),
(1465, NULL, '12d8641e-1e4a-47fe-9a71-3911fa8c043b', 'active', '2026-11-09 04:37:57', '2026-11-09 04:37:57'),
(1466, NULL, '2edbea1a-3e2d-4dd6-abb0-7205208c8de1', 'active', '2026-11-09 04:38:36', '2026-11-09 04:38:36'),
(1467, NULL, '59130ba1-f577-4fce-a61f-007ef8c3f0d3', 'active', '2026-11-09 04:38:43', '2026-11-09 04:38:43'),
(1468, NULL, 'b2507542-b291-41a5-88cb-abcf0feffef7', 'active', '2026-11-09 04:38:51', '2026-11-09 04:38:51'),
(1469, NULL, '1433eaa0-92e5-488d-b840-f1fe9b2c1b8b', 'active', '2026-11-09 04:38:59', '2026-11-09 04:38:59'),
(1470, NULL, '82adaeeb-3174-455b-813e-e4f48b06c516', 'active', '2026-11-09 04:39:07', '2026-11-09 04:39:07'),
(1471, NULL, 'b71d5981-2693-4276-bacc-5a76c899ecc3', 'active', '2026-11-09 04:39:17', '2026-11-09 04:39:17'),
(1472, NULL, 'b7ba52d9-796a-4a0a-890a-630b07f9990f', 'active', '2026-11-09 04:39:22', '2026-11-09 04:39:22'),
(1473, NULL, '7c733f09-7179-4144-b931-9e7e4c2410d2', 'active', '2026-11-09 04:39:25', '2026-11-09 04:39:25'),
(1474, NULL, 'fcb7ca91-163b-430a-aab9-bff7abab0cff', 'active', '2026-11-09 04:39:33', '2026-11-09 04:39:33'),
(1475, NULL, 'd9e93bd5-179d-4fdf-9715-b2bf0bf741c6', 'active', '2026-11-09 04:39:36', '2026-11-09 04:39:36'),
(1476, NULL, '7d516279-75f1-4d1b-8385-0e61fc9be6e9', 'active', '2026-11-09 04:39:40', '2026-11-09 04:39:40'),
(1477, NULL, '2421270d-e238-4ee2-9e8b-4b8cfed15acb', 'active', '2026-11-09 04:39:49', '2026-11-09 04:39:49'),
(1478, NULL, '7fed16bb-67b6-46f5-9a9d-b6cb10dfc8db', 'active', '2026-11-09 04:39:51', '2026-11-09 04:39:51'),
(1479, NULL, 'e91c9af8-9881-4388-80f2-bbf165cc7408', 'active', '2026-11-09 04:39:55', '2026-11-09 04:39:55'),
(1480, NULL, 'e1d5c644-ae13-4baa-90f8-9d64588e05a6', 'active', '2026-11-09 04:40:03', '2026-11-09 04:40:03'),
(1481, NULL, '5dbf46bb-1b37-48d0-b947-5116887c1c58', 'active', '2026-11-09 04:40:05', '2026-11-09 04:40:05'),
(1482, NULL, 'c81387e0-e447-4eb5-b28b-40ec4bd80394', 'active', '2026-11-09 05:08:35', '2026-11-09 05:08:35'),
(1483, NULL, '620b4879-9f5d-4539-a7cf-d9defa457699', 'active', '2026-11-09 05:08:35', '2026-11-09 05:08:35'),
(1484, NULL, '6aff52dc-3350-4a8f-a07d-21fc7e29d67e', 'active', '2026-11-09 05:11:00', '2026-11-09 05:11:00'),
(1485, NULL, '403c2d2b-6d4b-402e-8482-14a1e33ca76f', 'active', '2026-11-09 05:11:04', '2026-11-09 05:11:04'),
(1486, NULL, '0238dc60-e661-48ba-9f6f-d86ce679eb25', 'active', '2026-11-09 05:11:08', '2026-11-09 05:11:08'),
(1487, NULL, '61ab8d11-501c-4642-9463-bda040ddb0ff', 'active', '2026-11-09 05:11:19', '2026-11-09 05:11:19'),
(1488, NULL, 'ea339ff0-2266-4789-b369-c2a2aaffc5f5', 'active', '2026-11-09 05:11:21', '2026-11-09 05:11:21'),
(1489, NULL, '5f705ae1-ccc4-46e0-948e-4fd073fc01e8', 'active', '2026-11-09 05:11:22', '2026-11-09 05:11:22'),
(1490, NULL, '23462f06-cdf8-46b1-9b21-35d6407bdce3', 'active', '2026-11-09 05:11:25', '2026-11-09 05:11:25'),
(1491, NULL, 'b7a3e3db-ea4a-4178-b6a4-dafc9d3294b9', 'active', '2026-11-09 05:11:29', '2026-11-09 05:11:29'),
(1492, NULL, 'e80555b5-5269-4df6-a090-f8e7265b37eb', 'active', '2026-11-09 05:11:31', '2026-11-09 05:11:31'),
(1493, NULL, 'd1df3ab8-6f37-47b5-ad05-7590850605e4', 'active', '2026-11-09 05:45:55', '2026-11-09 05:45:55'),
(1494, NULL, '092e4021-e3d1-4e02-aa79-da265ce9ad75', 'active', '2026-11-09 05:45:58', '2026-11-09 05:45:58'),
(1495, NULL, '44cab0f6-bccc-4c9a-b0ae-44123d9a1d29', 'active', '2026-11-09 05:47:06', '2026-11-09 05:47:06'),
(1496, NULL, '0afd46f1-c1e9-4892-bbd5-6b9ae1896dd2', 'active', '2026-11-09 06:11:28', '2026-11-09 06:11:28'),
(1497, NULL, 'dfe7384c-ee60-4560-91fb-b04ecc990b80', 'active', '2026-11-09 06:17:07', '2026-11-09 06:17:07'),
(1498, NULL, '7e4e9fb8-8837-48c4-a171-b776f9dae0e8', 'active', '2026-11-09 08:05:10', '2026-11-09 08:05:10'),
(1499, NULL, '1f0c9b39-c086-4ee9-bb95-883b58254447', 'active', '2026-11-09 08:11:30', '2026-11-09 08:11:30'),
(1500, NULL, '508715f0-fec8-493b-b94e-0482b98c8e29', 'active', '2026-11-09 08:54:49', '2026-11-09 08:54:49'),
(1501, NULL, '8af48d02-2a39-4359-ac67-4d99d855c525', 'active', '2026-11-09 09:56:40', '2026-11-09 09:56:40'),
(1502, NULL, 'a96984f2-c239-413a-9942-5ed4659ede15', 'active', '2026-11-09 10:08:51', '2026-11-09 10:08:51'),
(1503, NULL, 'a7d862d1-02d2-42f1-ac2c-8d5cbebd6d99', 'active', '2026-11-09 10:14:42', '2026-11-09 10:14:42'),
(1504, NULL, '77d808cb-fe33-4d15-b809-26aafa552183', 'active', '2026-11-09 10:35:39', '2026-11-09 10:35:39'),
(1505, NULL, 'f75b5d6c-5c4a-4e78-929c-5aa284797816', 'active', '2026-11-09 10:35:39', '2026-11-09 10:35:39'),
(1506, NULL, '689371f1-a046-47ce-927e-6dd2e5059b6f', 'active', '2026-11-09 10:35:40', '2026-11-09 10:35:40'),
(1507, NULL, '985e9984-2f85-4c06-831f-7d9a8417df0e', 'active', '2026-11-09 10:35:42', '2026-11-09 10:35:42'),
(1508, NULL, 'e1fa5019-5e5e-4d80-a55a-82c825557172', 'active', '2026-11-09 10:35:51', '2026-11-09 10:35:51'),
(1509, NULL, 'a70c2043-7181-4fff-893e-e6ea33305076', 'active', '2026-11-09 10:35:52', '2026-11-09 10:35:52'),
(1510, NULL, 'dc760128-451c-43d1-8eb9-4614e039cbe7', 'active', '2026-11-09 10:35:53', '2026-11-09 10:35:53'),
(1511, NULL, '1dd5b1dc-a89a-45db-8003-8e47384aa593', 'active', '2026-11-09 10:35:56', '2026-11-09 10:35:56'),
(1512, NULL, '2c08115b-4625-4f31-8ebf-3006636009ab', 'active', '2026-11-09 10:36:00', '2026-11-09 10:36:00'),
(1513, NULL, 'cd845e5e-2e22-40c4-a5dd-887c61c9cf3a', 'active', '2026-11-09 10:36:02', '2026-11-09 10:36:02'),
(1514, NULL, '04c280cf-0bd3-44fb-ba7a-7fc4c7cfde62', 'active', '2026-11-09 10:36:03', '2026-11-09 10:36:03'),
(1515, NULL, '8000ad08-0a04-4c42-89ac-e8aa276b0ad6', 'active', '2026-11-09 10:36:04', '2026-11-09 10:36:04'),
(1516, NULL, '32d1cc0a-234f-495b-b7d2-f87d4479a895', 'active', '2026-11-09 10:42:24', '2026-11-09 10:42:24'),
(1517, NULL, '57554251-a0ce-4172-838e-16e75804f930', 'active', '2026-11-09 11:07:16', '2026-11-09 11:07:16'),
(1518, NULL, 'fe8cc78f-a6af-4090-aec5-74c3165f8220', 'active', '2026-11-09 11:07:16', '2026-11-09 11:07:16'),
(1519, NULL, '24fbd4a4-5eb2-4c0d-bab2-0bc8d18a67a1', 'active', '2026-11-09 11:07:19', '2026-11-09 11:07:19'),
(1520, NULL, 'cae04dca-cb8e-4822-8349-ecb1dd30920f', 'active', '2026-11-09 11:07:20', '2026-11-09 11:07:20'),
(1521, NULL, '5ae7966c-0903-4f6d-8476-0a511276c507', 'active', '2026-11-09 11:07:21', '2026-11-09 11:07:21'),
(1522, NULL, '41305542-7910-4825-bbd3-32583f4f4cae', 'active', '2026-11-09 11:07:22', '2026-11-09 11:07:22'),
(1523, NULL, '5cdbc8cc-9b9b-47ca-b1ee-931c9d75b61d', 'active', '2026-11-09 11:07:23', '2026-11-09 11:07:23'),
(1524, NULL, '2f23c00e-4a1f-4045-863b-5f5a7e324767', 'active', '2026-11-09 11:07:24', '2026-11-09 11:07:24'),
(1525, NULL, 'd1cdfcb5-6804-4c60-8d44-e2188176f4aa', 'active', '2026-11-09 11:07:26', '2026-11-09 11:07:26'),
(1526, NULL, '7f458c1e-32a5-440e-8c25-472f84d09371', 'active', '2026-11-09 11:29:54', '2026-11-09 11:29:54'),
(1527, NULL, 'b4ebd46e-8f42-4e72-ad69-d6318c8fe3f5', 'active', '2026-11-09 12:09:31', '2026-11-09 12:09:31'),
(1528, NULL, 'baf2afcd-ae6e-4ee8-b0f3-3f22872a408d', 'active', '2026-11-09 12:09:32', '2026-11-09 12:09:32'),
(1529, NULL, '35552d2e-f88f-4721-9c41-313b99f53af6', 'active', '2026-11-09 12:10:27', '2026-11-09 12:10:27'),
(1530, NULL, '9956fe1d-e436-4982-a425-8bb58756f0d9', 'active', '2026-11-09 13:08:47', '2026-11-09 13:08:47'),
(1531, NULL, '4152b049-9d9f-4523-86ed-17fc10084fce', 'active', '2026-11-09 13:09:27', '2026-11-09 13:09:27'),
(1532, NULL, '4cd98b42-5218-43e3-a7dd-90954dcc91ea', 'active', '2026-11-09 13:14:03', '2026-11-09 13:14:03'),
(1533, NULL, '27fc1b09-e4e0-462f-ba7f-dbde9fb4739c', 'active', '2026-11-09 13:39:59', '2026-11-09 13:39:59'),
(1534, NULL, '0aa852e7-0e0c-441c-a292-fe9241a1353d', 'active', '2026-11-09 13:40:02', '2026-11-09 13:40:02'),
(1535, NULL, '734481e3-df40-4550-888a-d4c6f3c2a1fb', 'active', '2026-11-09 13:40:04', '2026-11-09 13:40:04'),
(1536, NULL, '73e1e6e3-9f3b-45ae-a68f-7df1ed298462', 'active', '2026-11-09 13:40:05', '2026-11-09 13:40:05'),
(1537, NULL, '877b4e51-09ff-4232-a794-dc5cc8914ee7', 'active', '2026-11-09 13:40:06', '2026-11-09 13:40:06'),
(1538, NULL, 'fba0d067-c00d-4e8b-9456-8a99b5c0be4d', 'active', '2026-11-09 13:40:07', '2026-11-09 13:40:07'),
(1539, NULL, '1eba9fcb-7bd6-4b8d-8d99-33a71dd19b5b', 'active', '2026-11-09 13:40:08', '2026-11-09 13:40:08'),
(1540, NULL, '1c011101-27be-487a-9caf-a1cb2b8da5e1', 'active', '2026-11-09 13:40:10', '2026-11-09 13:40:10'),
(1541, NULL, '34250b3f-13ce-4cdb-b69e-8f6fc1dcec48', 'active', '2026-11-09 13:40:11', '2026-11-09 13:40:11'),
(1542, NULL, '17db546e-cf41-40cf-b184-0e45e6ae0b67', 'active', '2026-11-09 13:40:16', '2026-11-09 13:40:16'),
(1543, NULL, '65c960f1-d833-4303-8031-d82a7eca606a', 'active', '2026-11-09 14:12:07', '2026-11-09 14:12:07'),
(1544, NULL, 'c046b5ea-4b93-4c63-93e6-f2f6e825ef5e', 'active', '2026-11-09 14:17:24', '2026-11-09 14:17:24'),
(1545, NULL, '546425cb-c3eb-4dae-9234-e27abb7707cc', 'active', '2026-11-09 14:44:04', '2026-11-09 14:44:04'),
(1546, NULL, 'a48a5393-3110-4d1a-869f-b730832a179a', 'active', '2026-11-09 14:44:04', '2026-11-09 14:44:04'),
(1547, NULL, '45f1a5bc-4df0-45e9-beb1-89165a6e45ee', 'active', '2026-11-09 14:44:17', '2026-11-09 14:44:17'),
(1548, NULL, '58db458f-7750-4b90-aaa7-2ba42d722116', 'active', '2026-11-09 14:44:18', '2026-11-09 14:44:18'),
(1549, NULL, '88644825-99ef-4a3a-8526-3628d440e657', 'active', '2026-11-09 14:44:19', '2026-11-09 14:44:19'),
(1550, NULL, 'cbc44a34-3062-4ba6-991f-846d76a887d9', 'active', '2026-11-09 14:44:24', '2026-11-09 14:44:24'),
(1551, NULL, '7bfae0ef-dbde-4701-87de-43d8126c4e0b', 'active', '2026-11-09 14:44:27', '2026-11-09 14:44:27'),
(1552, NULL, '85ee171d-29a8-4b2f-9313-3b4d852c71f2', 'active', '2026-11-09 14:44:28', '2026-11-09 14:44:28'),
(1553, NULL, '644df430-0261-4908-8883-3345fc5eeb85', 'active', '2026-11-09 14:44:30', '2026-11-09 14:44:30'),
(1554, NULL, '3353bbaf-533e-4501-aeb6-b6180e9368d8', 'active', '2026-11-09 14:44:32', '2026-11-09 14:44:32'),
(1555, NULL, 'cb3b8921-3966-4b6c-ad91-f750c3ebbffa', 'active', '2026-11-09 14:44:34', '2026-11-09 14:44:34'),
(1556, NULL, 'ca7b5642-d8a6-4fce-be1f-0b6f64db63b1', 'active', '2026-11-09 14:44:34', '2026-11-09 14:44:34'),
(1557, NULL, '616a50f2-7251-447d-955c-e7b39bf1c592', 'active', '2026-11-09 14:44:38', '2026-11-09 14:44:38'),
(1558, NULL, 'dfab9735-e575-49e2-8789-2dca489eede9', 'active', '2026-11-09 14:44:38', '2026-11-09 14:44:38'),
(1559, NULL, 'd333bd7b-e295-4494-becd-7d5fd21c4590', 'active', '2026-11-09 15:07:06', '2026-11-09 15:07:06'),
(1560, NULL, '1c2e0288-5cd0-4b55-93d1-749e78bc7cab', 'active', '2026-11-09 15:10:32', '2026-11-09 15:10:32'),
(1561, NULL, '48a7c1cd-2a88-47fc-9e3b-974cf8bfa42c', 'active', '2026-11-09 15:32:26', '2026-11-09 15:32:26'),
(1562, NULL, 'f08ffbe1-0a24-48e0-8040-4901fc5a7401', 'active', '2026-11-09 15:48:38', '2026-11-09 15:48:38'),
(1563, NULL, '453d55ab-2c99-4f5c-8da0-81d10cf8025b', 'active', '2026-11-09 15:48:38', '2026-11-09 15:48:38'),
(1564, NULL, '1a31d71a-eb90-42a6-90b9-10935215b401', 'active', '2026-11-09 15:48:40', '2026-11-09 15:48:40'),
(1565, NULL, '12231ce4-24a6-436a-afb5-edfe3ba0869d', 'active', '2026-11-09 15:48:41', '2026-11-09 15:48:41'),
(1566, NULL, '0c2d4f5c-e5cf-47e8-a173-f24e8ce48f43', 'active', '2026-11-09 15:48:43', '2026-11-09 15:48:43'),
(1567, NULL, '2e24b4e6-f7e7-4a17-a6cd-216c65a45b99', 'active', '2026-11-09 15:48:52', '2026-11-09 15:48:52'),
(1568, NULL, 'db53ae7f-6afb-426d-99fb-32a5ba5433d3', 'active', '2026-11-09 15:48:53', '2026-11-09 15:48:53'),
(1569, NULL, 'bc91d70a-f522-4ae6-81e7-16c2301fa9c3', 'active', '2026-11-09 15:48:55', '2026-11-09 15:48:55'),
(1570, NULL, '5311cd38-cf33-41ff-b38d-1916b8d6c0e9', 'active', '2026-11-09 15:48:56', '2026-11-09 15:48:56'),
(1571, NULL, '0e27ca33-1417-44f2-9233-32231547d1c8', 'active', '2026-11-09 15:48:57', '2026-11-09 15:48:57'),
(1572, NULL, '58855dab-fbf3-4c38-b77c-e01987c190c7', 'active', '2026-11-09 15:48:59', '2026-11-09 15:48:59'),
(1573, NULL, '13d439f7-ac91-40aa-a022-db2dde9ce8f1', 'active', '2026-11-09 16:20:27', '2026-11-09 16:20:27'),
(1575, NULL, 'cf157d5a-be54-44b7-9a98-3c26ce137e9e', 'active', '2026-11-09 17:03:42', '2026-11-09 17:03:42'),
(1576, NULL, '9172214e-3ad9-4b7a-9401-feae6f52e992', 'active', '2026-11-09 17:05:49', '2026-11-09 17:05:49'),
(1577, NULL, '9b2047b1-0248-4bb9-8056-6400a07d7fd1', 'active', '2026-11-09 17:07:02', '2026-11-09 17:07:02'),
(1578, NULL, '8a65f537-8da2-404d-ba36-4b30eb01c0dc', 'active', '2026-11-09 17:09:02', '2026-11-09 17:09:02'),
(1579, NULL, '148d559f-4054-41b5-9dbd-0290fd11edb6', 'active', '2026-11-09 17:09:38', '2026-11-09 17:09:38'),
(1580, 3, NULL, 'active', '2026-11-09 17:09:52', '2026-11-09 17:09:52'),
(1581, NULL, '563ce3f0-2115-42e4-8c19-916587f5efaa', 'active', '2026-11-09 17:10:48', '2026-11-09 17:10:48'),
(1582, 5, NULL, 'active', '2026-11-09 17:11:00', '2026-11-09 17:11:00'),
(1583, NULL, '2104b522-670e-4fe1-9167-c5857eaa5c51', 'active', '2026-11-09 17:14:21', '2026-11-09 17:14:21'),
(1584, NULL, '4202ee3e-fa8f-4479-997e-63f4c00a423f', 'active', '2026-11-09 17:15:33', '2026-11-09 17:15:33'),
(1585, NULL, '56c39a28-f194-486b-9ad7-dedc34d7d2b0', 'active', '2026-11-09 17:25:09', '2026-11-09 17:25:09'),
(1586, NULL, '0374110e-6742-4480-b01f-bdb9cedb1c22', 'active', '2026-11-09 17:26:28', '2026-11-09 17:26:28'),
(1587, NULL, '002484fb-8700-4c0e-91f0-f9f9af383bba', 'active', '2026-11-09 17:26:29', '2026-11-09 17:26:29'),
(1588, NULL, 'ccad26e5-6b03-47a8-898c-ab760fa6ccca', 'active', '2026-11-09 17:26:30', '2026-11-09 17:26:30'),
(1589, NULL, '287bb032-79a9-49f3-bca2-433fb887ebcc', 'active', '2026-11-09 17:26:33', '2026-11-09 17:26:33'),
(1590, NULL, '686aabed-b664-4aba-8cb7-382827e84903', 'active', '2026-11-09 17:26:34', '2026-11-09 17:26:34'),
(1591, NULL, '8b09aec5-d3fa-4d85-9802-22a90cf6862a', 'active', '2026-11-09 17:26:35', '2026-11-09 17:26:35'),
(1592, NULL, '260967ed-d158-490f-b80b-90002ff834a0', 'active', '2026-11-09 17:26:38', '2026-11-09 17:26:38'),
(1593, NULL, 'd9ebc360-2469-418f-9984-325ec29494e4', 'active', '2026-11-09 17:26:43', '2026-11-09 17:26:43'),
(1594, NULL, 'd3070464-05f4-4226-be9f-87b64697647b', 'active', '2026-11-09 17:26:44', '2026-11-09 17:26:44'),
(1595, NULL, 'a1ed6fff-ea76-41d7-93ad-9c8fb155eb3c', 'active', '2026-11-09 17:26:46', '2026-11-09 17:26:46'),
(1596, NULL, '7a8f8d3f-a981-4412-9f2e-f3010c4e01c7', 'active', '2026-11-09 17:26:47', '2026-11-09 17:26:47'),
(1597, NULL, 'fe7e428f-533d-4e4c-826a-a7a2e8000518', 'active', '2026-11-09 17:32:28', '2026-11-09 17:32:28'),
(1598, NULL, 'cd523d44-167b-48ea-a8f6-1c7c9e27c334', 'active', '2026-11-09 17:39:26', '2026-11-09 17:39:26'),
(1599, 6, NULL, 'active', '2026-11-09 17:39:43', '2026-11-09 17:39:43'),
(1600, NULL, '05c3abbd-36a7-42c7-a6b0-66acb22e028f', 'active', '2026-11-09 17:39:50', '2026-11-09 17:39:50'),
(1601, NULL, '3c03bd89-e661-40bc-b1b2-137e067460a6', 'active', '2026-11-09 17:41:30', '2026-11-09 17:41:30'),
(1602, NULL, '793195d0-43ef-4b08-883b-ed64d8cab20a', 'active', '2026-11-09 17:42:48', '2026-11-09 17:42:48'),
(1603, NULL, 'a104d844-0c84-4a29-a3fe-876bcd3ebda9', 'active', '2026-11-09 17:43:01', '2026-11-09 17:43:01'),
(1604, NULL, 'c46b4c7b-6256-4123-b9f4-b91d59b270ff', 'active', '2026-11-09 17:43:11', '2026-11-09 17:43:11'),
(1605, NULL, 'bebb674a-0aa2-48ef-926b-18d12dc7dba5', 'active', '2026-11-09 17:43:28', '2026-11-09 17:43:28'),
(1606, NULL, '8c9de8d7-d0e7-4963-b1c3-15259d989aee', 'active', '2026-11-09 17:43:36', '2026-11-09 17:43:36'),
(1608, NULL, '818fe2ba-8431-472a-9895-135e200eabba', 'active', '2026-11-09 18:02:38', '2026-11-09 18:02:38'),
(1609, 7, NULL, 'active', '2026-11-09 18:06:31', '2026-11-09 18:06:31'),
(1610, NULL, '4876510d-ad77-4b81-8fea-aaf900792110', 'active', '2026-11-09 18:07:29', '2026-11-09 18:07:29'),
(1611, NULL, '53c3360c-9246-422b-a312-3588c500db6b', 'active', '2026-11-09 18:11:33', '2026-11-09 18:11:33'),
(1612, NULL, '606e8147-b624-4bc3-9f57-cfca58a09bab', 'active', '2026-11-09 18:25:26', '2026-11-09 18:25:26'),
(1613, NULL, '431e7628-60b6-4019-9252-679aa474dee0', 'active', '2026-11-09 18:25:27', '2026-11-09 18:25:27'),
(1614, NULL, '88ee46c7-f412-4314-a0ed-895023683ce6', 'active', '2026-11-09 18:25:28', '2026-11-09 18:25:28'),
(1615, NULL, 'c58dc260-81e7-442c-a3ba-00ab61e224b8', 'active', '2026-11-09 18:25:29', '2026-11-09 18:25:29'),
(1616, NULL, '81439ce6-3f64-47dd-9c99-72b744f89df4', 'active', '2026-11-09 18:29:29', '2026-11-09 18:29:29'),
(1617, NULL, 'fd01ce0f-82c7-43ad-822b-63dc4c26daa5', 'active', '2026-11-09 18:29:30', '2026-11-09 18:29:30'),
(1618, NULL, 'e059d554-f3ef-4ad9-bc0e-bb8cfea51f22', 'active', '2026-11-09 18:29:31', '2026-11-09 18:29:31'),
(1619, NULL, 'd2363681-4139-4cc1-9289-868eaffff805', 'active', '2026-11-09 18:29:32', '2026-11-09 18:29:32'),
(1620, NULL, 'd90dd0cf-4441-4af4-8c22-30630bb5b5d6', 'active', '2026-11-09 19:40:38', '2026-11-09 19:40:38'),
(1621, NULL, '8ca09e0b-315d-4d23-809b-4bb4476e51e5', 'active', '2026-11-09 19:40:39', '2026-11-09 19:40:39'),
(1622, NULL, 'f7fa774c-6a1c-4f35-856a-c183ce06a1fd', 'active', '2026-11-09 19:40:47', '2026-11-09 19:40:47'),
(1623, NULL, '96247f09-d97f-47e5-ae98-81f4d79fe6df', 'active', '2026-11-09 19:40:47', '2026-11-09 19:40:47'),
(1624, NULL, '362df7ce-25fe-43f3-bc0e-323d60382c47', 'active', '2026-11-09 19:40:48', '2026-11-09 19:40:48'),
(1625, NULL, '6c73b204-a608-4dcc-8973-84c5f8adcfcf', 'active', '2026-11-09 19:40:49', '2026-11-09 19:40:49'),
(1626, NULL, 'ed73d09c-c026-4a7a-8878-31fad3c69fd2', 'active', '2026-11-09 19:40:50', '2026-11-09 19:40:50'),
(1627, NULL, '09ba84d3-2130-4654-b72c-50d893f32a14', 'active', '2026-11-09 19:40:51', '2026-11-09 19:40:51'),
(1628, NULL, '09976d08-6fe5-4ab3-999e-063c24e2a149', 'active', '2026-11-09 19:40:52', '2026-11-09 19:40:52'),
(1629, NULL, '97bac668-8096-4998-bdfb-5d325845a6b8', 'active', '2026-11-09 19:40:53', '2026-11-09 19:40:53'),
(1630, NULL, 'ee141768-ecf1-45ad-b193-4ee180fece11', 'active', '2026-11-09 19:40:57', '2026-11-09 19:40:57'),
(1631, NULL, '5674a162-b3a9-401f-b1c7-592196160e94', 'active', '2026-11-09 19:40:58', '2026-11-09 19:40:58'),
(1632, NULL, '516f8b90-f8a7-465f-92e4-802554c30b05', 'active', '2026-11-09 19:41:00', '2026-11-09 19:41:00'),
(1633, NULL, '2aa0aebe-6493-4c89-8f9d-f8dc4d0bbef8', 'active', '2026-11-09 20:06:15', '2026-11-09 20:06:15'),
(1634, NULL, '63c13d10-5c13-42f4-bd25-f43c76e1bf96', 'active', '2026-11-09 20:09:31', '2026-11-09 20:09:31'),
(1635, NULL, 'f0f9ff49-3ba6-4b9c-9e36-72648118cef4', 'active', '2026-11-09 20:09:31', '2026-11-09 20:09:31'),
(1636, NULL, 'be58f421-89e9-467d-aeee-2e030e11bbb7', 'active', '2026-11-09 20:09:32', '2026-11-09 20:09:32'),
(1637, NULL, '51afd898-9fc1-4bc2-9093-c2447b89b500', 'active', '2026-11-09 20:09:34', '2026-11-09 20:09:34'),
(1638, NULL, 'c7af8a6a-0236-4128-9b6c-45d62a916404', 'active', '2026-11-09 20:09:37', '2026-11-09 20:09:37'),
(1639, NULL, 'd50ada9f-732e-4959-8204-d5ea6b562dda', 'active', '2026-11-09 20:09:38', '2026-11-09 20:09:38'),
(1640, NULL, 'dace930a-c525-49d4-b6a3-aa6864ee896d', 'active', '2026-11-09 20:09:39', '2026-11-09 20:09:39'),
(1641, NULL, 'cd6afc20-5508-49ff-975c-5ca77b0406f3', 'active', '2026-11-09 20:09:41', '2026-11-09 20:09:41'),
(1642, NULL, '48c3c17d-9cde-46aa-82ff-f44e3baef4a3', 'active', '2026-11-09 20:09:43', '2026-11-09 20:09:43'),
(1643, NULL, 'ecd64f93-6f7c-43df-856a-f281681bde0f', 'active', '2026-11-09 20:09:44', '2026-11-09 20:09:44'),
(1644, NULL, 'a2eeb5a0-caa4-462b-995c-006e94c8a2a5', 'active', '2026-11-09 20:10:08', '2026-11-09 20:10:08'),
(1645, NULL, '32b0e10d-c2df-4b13-ba07-19607dc7f297', 'active', '2026-11-09 20:11:25', '2026-11-09 20:11:25'),
(1646, NULL, 'be9330fb-c8bc-4807-97d5-29b320d0eac7', 'active', '2026-11-09 20:11:51', '2026-11-09 20:11:51'),
(1647, NULL, 'cb64dab0-df20-4c97-9ad7-3782f43352b5', 'active', '2026-11-09 20:12:40', '2026-11-09 20:12:40'),
(1648, NULL, 'ee800da8-e43e-4093-94e8-6fd849fc1b7e', 'active', '2026-11-09 20:31:55', '2026-11-09 20:31:55'),
(1649, NULL, '27bf20ae-40b8-454b-9ff9-9bd3a7256d30', 'active', '2026-11-09 21:13:21', '2026-11-09 21:13:21'),
(1650, NULL, '9ff52da2-b5ae-4a27-ba2f-e313b20e44d5', 'active', '2026-11-09 21:13:21', '2026-11-09 21:13:21'),
(1651, NULL, '067d6c80-a146-4f24-ab00-cf86a7d4c4c6', 'active', '2026-11-09 21:13:21', '2026-11-09 21:13:21'),
(1652, NULL, 'ff0a14b6-3b26-4fac-bbf3-77c4aba7ebac', 'active', '2026-11-09 21:13:22', '2026-11-09 21:13:22'),
(1653, NULL, '7add9275-f83f-4cbc-b07b-fe797d145bcd', 'active', '2026-11-09 21:13:23', '2026-11-09 21:13:23'),
(1654, NULL, '023002b5-639a-4af3-816b-384c000946b9', 'active', '2026-11-09 21:13:25', '2026-11-09 21:13:25'),
(1655, NULL, '196143b9-4d1d-4175-a621-1a062f1df200', 'active', '2026-11-09 21:13:27', '2026-11-09 21:13:27'),
(1656, NULL, '2c56be78-10f4-4e63-9deb-09517c4063cd', 'active', '2026-11-09 21:13:27', '2026-11-09 21:13:27'),
(1657, NULL, '41eb4110-3cde-4492-977f-1c0c1712961a', 'active', '2026-11-09 21:13:36', '2026-11-09 21:13:36'),
(1658, NULL, '2441b751-b632-49e1-ba70-4a6c252abd0e', 'active', '2026-11-09 21:13:39', '2026-11-09 21:13:39'),
(1659, NULL, 'c019cc62-9ff3-4ff8-840a-1a45eda54cee', 'active', '2026-11-09 21:13:41', '2026-11-09 21:13:41'),
(1660, NULL, '37e94488-805d-4275-818c-76be628645df', 'active', '2026-11-09 21:13:42', '2026-11-09 21:13:42'),
(1661, NULL, '514807dc-18ca-4e33-89f3-045dc92a957a', 'active', '2026-11-09 21:13:42', '2026-11-09 21:13:42'),
(1662, NULL, 'fd98e2ae-83b7-4eea-852f-7b11144bb8ef', 'active', '2026-11-09 21:13:44', '2026-11-09 21:13:44'),
(1663, NULL, 'fca51865-e43d-4dd6-a858-916c300071a9', 'active', '2026-11-09 21:22:40', '2026-11-09 21:22:40'),
(1664, NULL, '5d99eef7-0eaa-4b10-9267-7fe5384e5b82', 'active', '2026-11-09 21:26:01', '2026-11-09 21:26:01'),
(1665, NULL, '8b650bd8-ea8f-49de-81d3-8443ef354fce', 'active', '2026-11-09 21:37:16', '2026-11-09 21:37:16'),
(1666, NULL, '9a7047d0-d2e0-4bbb-bd6c-c0c2ef23eb98', 'active', '2026-11-09 21:48:42', '2026-11-09 21:48:42'),
(1667, NULL, '598bd1e6-bfb0-452a-98e7-88e2ea742912', 'active', '2026-11-09 21:48:50', '2026-11-09 21:48:50'),
(1668, NULL, 'fd5bca27-71b6-4c92-ad9a-25f84922dd40', 'active', '2026-11-09 21:50:27', '2026-11-09 21:50:27'),
(1669, NULL, '8a1df866-5dba-409c-a5c8-2e9f090babd4', 'active', '2026-11-09 21:57:18', '2026-11-09 21:57:18'),
(1670, NULL, '449044ff-6a1d-49c4-971f-2d80b0536822', 'active', '2026-11-09 22:07:33', '2026-11-09 22:07:33'),
(1671, NULL, '18addbb0-2a5c-423a-9b6f-a6d0168298f0', 'active', '2026-11-09 22:13:24', '2026-11-09 22:13:24'),
(1672, NULL, 'edc3eee0-1620-4bfe-8d31-0a93dc83cd9d', 'active', '2026-11-09 22:13:27', '2026-11-09 22:13:27'),
(1673, NULL, '3f28f923-5fb7-4fb4-851a-9ed0f8233579', 'active', '2026-11-09 22:13:29', '2026-11-09 22:13:29'),
(1674, NULL, 'a85bc029-ed27-43cd-ae0e-7f95e305fbba', 'active', '2026-11-09 22:13:30', '2026-11-09 22:13:30'),
(1675, NULL, 'bdd39c26-073d-45e2-b6f9-fc3211750da6', 'active', '2026-11-09 22:13:33', '2026-11-09 22:13:33'),
(1676, NULL, 'f8db4f14-f3c5-43b2-b238-898bed333831', 'active', '2026-11-09 22:13:51', '2026-11-09 22:13:51'),
(1677, NULL, '02c788e6-1838-4fec-9540-436adc9251fc', 'active', '2026-11-09 22:13:52', '2026-11-09 22:13:52'),
(1678, NULL, '2bfcad38-5d1c-4ec4-a7c6-6ac54e7d41e5', 'active', '2026-11-09 22:13:55', '2026-11-09 22:13:55'),
(1679, NULL, '71644e93-c2e4-4a24-b470-dcee11378ba2', 'active', '2026-11-09 22:14:08', '2026-11-09 22:14:08'),
(1680, NULL, '2f9a6fa2-13b9-497f-ab73-5c157b85c68f', 'active', '2026-11-09 22:14:16', '2026-11-09 22:14:16'),
(1681, NULL, 'd6a06b39-ec18-4d04-a527-7296a937871b', 'active', '2026-11-09 22:14:19', '2026-11-09 22:14:19'),
(1682, NULL, '05143a31-2c45-432f-ad62-d6766dba4fc3', 'active', '2026-11-09 22:17:30', '2026-11-09 22:17:30'),
(1683, NULL, 'e9c99050-0a3c-42a7-9d76-3b09375c8d22', 'active', '2026-11-09 22:28:04', '2026-11-09 22:28:04'),
(1684, NULL, 'cd616446-f186-41d8-94ce-2a3775e8a793', 'active', '2026-11-09 22:38:16', '2026-11-09 22:38:16'),
(1685, NULL, '49ecf4d4-5929-4087-aeb5-1a02a7b58afa', 'active', '2026-11-09 22:46:56', '2026-11-09 22:46:56'),
(1686, NULL, 'f6422afc-496a-4590-a639-14b09248e7b2', 'active', '2026-11-09 22:58:21', '2026-11-09 22:58:21'),
(1687, NULL, '66453671-6e41-46b8-9d15-b99d86757a9f', 'active', '2026-11-09 23:07:49', '2026-11-09 23:07:49'),
(1688, NULL, 'e15dfbb3-b344-4fef-8137-bb1c7a933d5b', 'active', '2026-11-09 23:16:20', '2026-11-09 23:16:20'),
(1689, NULL, '0fc856dc-337c-4b36-9d68-7c7e19e73246', 'active', '2026-11-09 23:21:11', '2026-11-09 23:21:11'),
(1690, NULL, 'c9ab0c34-fa52-4907-a30b-3ea7ecec75c3', 'active', '2026-11-09 23:21:12', '2026-11-09 23:21:12'),
(1691, NULL, 'ddde9109-a205-457b-b5ec-c7610339ddbe', 'active', '2026-11-09 23:21:13', '2026-11-09 23:21:13'),
(1692, NULL, 'a7d02791-df72-456f-b039-36f440ef723d', 'active', '2026-11-09 23:21:14', '2026-11-09 23:21:14'),
(1693, NULL, '31576343-2226-4bca-82f4-9d3c3084b39b', 'active', '2026-11-09 23:21:17', '2026-11-09 23:21:17'),
(1694, NULL, 'd745098c-ad98-44cf-a800-82b83ef6e9bf', 'active', '2026-11-09 23:21:19', '2026-11-09 23:21:19'),
(1695, NULL, '7599bd20-edcd-4c6e-9943-7b7c688b6080', 'active', '2026-11-09 23:21:21', '2026-11-09 23:21:21'),
(1696, NULL, '82e8ce59-d869-4435-8ff1-7838683e8987', 'active', '2026-11-09 23:21:23', '2026-11-09 23:21:23'),
(1697, NULL, 'c3ff6051-7efc-484b-b875-f5b68b702e21', 'active', '2026-11-09 23:21:23', '2026-11-09 23:21:23'),
(1698, NULL, '3f5c4164-8826-4522-bf8e-5870c7c04b30', 'active', '2026-11-09 23:21:24', '2026-11-09 23:21:24'),
(1699, NULL, '8b6871b9-ad68-4175-9cf3-f93bb1b42c12', 'active', '2026-11-09 23:21:25', '2026-11-09 23:21:25'),
(1700, NULL, '95b49f37-1326-4500-9ebf-22d7e629812c', 'active', '2026-11-09 23:21:27', '2026-11-09 23:21:27'),
(1701, NULL, '9f1e62f9-5de7-45b6-b580-8b0f00a4756f', 'active', '2026-11-09 23:21:28', '2026-11-09 23:21:28'),
(1702, NULL, '537aaf8a-32fe-455a-a1f0-310523d2751a', 'active', '2026-11-09 23:21:29', '2026-11-09 23:21:29'),
(1703, NULL, '755344f6-255c-4a3a-bb0e-ae57014b98d3', 'active', '2026-11-09 23:24:07', '2026-11-09 23:24:07'),
(1704, NULL, '4659a23f-f249-411e-88a5-7c361ee3c372', 'active', '2026-11-09 23:40:10', '2026-11-09 23:40:10'),
(1705, NULL, '199604bc-fec7-4db1-bd69-4e7e0474474f', 'active', '2026-11-09 23:45:43', '2026-11-09 23:45:43'),
(1706, NULL, '8fa1c2eb-7d17-4767-8b48-55e07ba2bc7d', 'active', '2026-11-09 23:56:50', '2026-11-09 23:56:50'),
(1707, NULL, '07069e64-0f30-467f-a42d-5d84fabd8a65', 'active', '2026-11-09 23:57:06', '2026-11-09 23:57:06'),
(1708, NULL, '7d29a516-6282-4d19-9559-9ff290a9690f', 'active', '2026-11-09 23:57:07', '2026-11-09 23:57:07'),
(1709, NULL, '747a49dc-b3c4-479d-b8b8-5145b0b3b5ba', 'active', '2026-11-09 23:57:09', '2026-11-09 23:57:09'),
(1710, NULL, '7253cd33-eeee-473d-a252-1c7b9e44c47a', 'active', '2026-11-09 23:57:10', '2026-11-09 23:57:10'),
(1711, NULL, '18c53bca-40d6-455a-9e37-3aabcc559b18', 'active', '2026-11-09 23:57:12', '2026-11-09 23:57:12'),
(1712, NULL, 'eb7b1aaa-955d-4e0d-9d71-4735c794f8ab', 'active', '2026-11-09 23:57:14', '2026-11-09 23:57:14'),
(1713, NULL, 'b61640f8-c4dd-4c2b-8ba5-dc6f7dff3c38', 'active', '2026-11-09 23:57:16', '2026-11-09 23:57:16'),
(1714, NULL, '9e069eba-9c46-430b-9b08-cef661000271', 'active', '2026-11-10 00:05:55', '2026-11-10 00:05:55'),
(1715, NULL, '058fd67b-e039-4266-a6db-4a88f8e51e5b', 'active', '2026-11-10 00:16:39', '2026-11-10 00:16:39'),
(1716, NULL, '5c00fd0a-5449-40d6-af81-7d597431da45', 'active', '2026-11-10 00:26:14', '2026-11-10 00:26:14'),
(1717, NULL, '430de8ec-5270-4b2d-8e63-f59a5df7a36f', 'active', '2026-11-10 00:34:21', '2026-11-10 00:34:21'),
(1718, NULL, '4f47abed-2d09-4197-b618-44d93e97f786', 'active', '2026-11-10 00:43:59', '2026-11-10 00:43:59'),
(1719, NULL, '49196797-f9b5-4c87-b32f-a487c3d71b4e', 'active', '2026-11-10 00:57:56', '2026-11-10 00:57:56'),
(1720, NULL, 'a75dfafd-9702-4252-9d85-db6aa64bfc52', 'active', '2026-11-10 01:04:15', '2026-11-10 01:04:15'),
(1721, NULL, '4ddd578c-d979-4c43-ad65-becd468f3d17', 'active', '2026-11-10 01:07:11', '2026-11-10 01:07:11'),
(1722, NULL, 'cdebd552-b3b5-4032-828e-dbe6a0890641', 'active', '2026-11-10 01:08:24', '2026-11-10 01:08:24'),
(1723, NULL, '9c1111d2-43d1-4fa5-9b8a-340bf5e6843b', 'active', '2026-11-10 01:08:25', '2026-11-10 01:08:25'),
(1724, NULL, '1940840b-9d52-490e-8390-200b1b7a5a7d', 'active', '2026-11-10 01:08:26', '2026-11-10 01:08:26'),
(1725, NULL, '72ec181e-3ab4-4df1-8348-ca28c92f3b80', 'active', '2026-11-10 01:08:28', '2026-11-10 01:08:28'),
(1726, NULL, 'bbf1f9ea-a1b4-402f-bb8a-df66937e234d', 'active', '2026-11-10 01:08:30', '2026-11-10 01:08:30'),
(1727, NULL, '07f52848-4ff3-4990-9d6d-bda50a646899', 'active', '2026-11-10 01:08:32', '2026-11-10 01:08:32'),
(1728, NULL, 'f16620dd-ea7f-4e95-81db-aa3ef2f059bf', 'active', '2026-11-10 01:08:32', '2026-11-10 01:08:32'),
(1729, NULL, '0b7fc339-56c4-441a-83a7-2ea226257347', 'active', '2026-11-10 01:08:34', '2026-11-10 01:08:34'),
(1730, NULL, 'a0b2467f-4d36-4fd8-80f3-f25301c90329', 'active', '2026-11-10 01:08:38', '2026-11-10 01:08:38'),
(1731, NULL, '4317c294-a763-46b2-9302-9fdd2324d587', 'active', '2026-11-10 01:08:39', '2026-11-10 01:08:39'),
(1732, NULL, '5fab747b-3fce-46c9-ad62-976c4baae15f', 'active', '2026-11-10 01:08:42', '2026-11-10 01:08:42'),
(1733, NULL, 'fc78b0dc-ad20-4f22-82e8-04bfe0a9c299', 'active', '2026-11-10 01:09:45', '2026-11-10 01:09:45'),
(1734, NULL, '5f74384b-08cb-475e-aec6-e82a28c08dda', 'active', '2026-11-10 01:17:39', '2026-11-10 01:17:39'),
(1735, NULL, '4ea32236-93e3-42ac-a142-122c79e9dd43', 'active', '2026-11-10 01:22:27', '2026-11-10 01:22:27'),
(1736, NULL, '258cfe2a-4214-40ff-a86c-7e6eb90e6b29', 'active', '2026-11-10 01:22:34', '2026-11-10 01:22:34'),
(1737, NULL, '220272b8-c30b-4d9f-ad14-7d55da81191d', 'active', '2026-11-10 01:27:57', '2026-11-10 01:27:57'),
(1738, NULL, 'a9d02f13-8ad2-48a6-87f7-7e49261e7730', 'active', '2026-11-10 01:39:50', '2026-11-10 01:39:50'),
(1739, NULL, '388724c0-1750-4284-b956-7120c50d1cfa', 'active', '2026-11-10 01:43:59', '2026-11-10 01:43:59'),
(1740, NULL, '0367fcae-3ee3-46a2-a796-2b9ca6282661', 'active', '2026-11-10 01:55:22', '2026-11-10 01:55:22'),
(1741, NULL, '8b0e61c5-3279-4323-acf0-8ed0667c641d', 'active', '2026-11-10 02:06:59', '2026-11-10 02:06:59'),
(1742, NULL, 'ddaf710a-359f-41a2-8f00-05616d7d693e', 'active', '2026-11-10 02:16:15', '2026-11-10 02:16:15'),
(1743, NULL, 'e5d32600-2bec-4313-9e88-df0a303d7208', 'active', '2026-11-10 02:26:20', '2026-11-10 02:26:20'),
(1744, NULL, '59d8af3f-4ac2-484c-9d69-ab7676d38979', 'active', '2026-11-10 02:27:18', '2026-11-10 02:27:18'),
(1745, NULL, '1488e506-adf4-4825-98a1-feb8a0c5b0d0', 'active', '2026-11-10 02:27:19', '2026-11-10 02:27:19'),
(1746, NULL, '4c411461-db0a-4489-96a3-d192017c7b4f', 'active', '2026-11-10 02:27:22', '2026-11-10 02:27:22'),
(1747, NULL, 'a5635237-1118-4a32-a3bc-bf8442b3c176', 'active', '2026-11-10 02:27:22', '2026-11-10 02:27:22'),
(1748, NULL, 'dba4e84b-23e6-4b1d-87d4-7c64b35899ba', 'active', '2026-11-10 02:27:23', '2026-11-10 02:27:23'),
(1749, NULL, 'd310215c-96e6-4f54-9b06-f605646c66ff', 'active', '2026-11-10 02:27:26', '2026-11-10 02:27:26'),
(1750, NULL, 'f08940cb-5732-419b-8d9b-df602040efff', 'active', '2026-11-10 02:27:29', '2026-11-10 02:27:29'),
(1751, NULL, '1763b9ca-f424-4d92-9d89-0023c7247d41', 'active', '2026-11-10 02:27:31', '2026-11-10 02:27:31'),
(1752, NULL, '4d76cf23-b15d-46c6-bc12-54ce98c0afc8', 'active', '2026-11-10 02:27:33', '2026-11-10 02:27:33'),
(1753, NULL, '4c7966bc-d1ad-4e21-b496-ce8047f8a575', 'active', '2026-11-10 02:27:34', '2026-11-10 02:27:34'),
(1754, NULL, '6c61a782-9a6c-4e1e-99ef-5741a4a34f2b', 'active', '2026-11-10 02:27:35', '2026-11-10 02:27:35'),
(1755, NULL, '42d86f09-7141-477b-8828-04c036091dc0', 'active', '2026-11-10 02:27:37', '2026-11-10 02:27:37'),
(1756, NULL, '6a0be9b3-e881-432b-8de3-9c3f996e6adc', 'active', '2026-11-10 02:37:28', '2026-11-10 02:37:28'),
(1757, NULL, 'aa90e8c8-1f2d-4843-99ab-a153c62c35c5', 'active', '2026-11-10 02:43:38', '2026-11-10 02:43:38'),
(1758, NULL, 'dc909d07-88a1-474d-b7ca-35586402039f', 'active', '2026-11-10 02:55:58', '2026-11-10 02:55:58'),
(1759, NULL, '31ee9193-510d-4ba2-ab54-adc7a81e3de0', 'active', '2026-11-10 03:02:05', '2026-11-10 03:02:05'),
(1760, NULL, 'c1fe512b-3c9f-4adc-b7aa-fafdfd3f7175', 'active', '2026-11-10 03:03:16', '2026-11-10 03:03:16'),
(1761, NULL, '03c1c6cd-71a0-45b9-9e2e-34edbc85ec90', 'active', '2026-11-10 03:03:16', '2026-11-10 03:03:16'),
(1762, NULL, 'e2332f3e-60ef-46f5-a044-f54ddec0242d', 'active', '2026-11-10 03:03:17', '2026-11-10 03:03:17'),
(1763, NULL, '1c2d92f5-c3b7-423c-a012-ae8050cec99c', 'active', '2026-11-10 03:03:22', '2026-11-10 03:03:22'),
(1764, NULL, '481c3575-b3dc-477b-a3a3-2f343fe73dd1', 'active', '2026-11-10 03:03:22', '2026-11-10 03:03:22'),
(1765, NULL, '42970ce5-149f-4e7b-95f3-57da67c1e2bd', 'active', '2026-11-10 03:03:28', '2026-11-10 03:03:28'),
(1766, NULL, '01db9907-899e-4cdc-8cd6-9a488ba38556', 'active', '2026-11-10 03:03:29', '2026-11-10 03:03:29'),
(1767, NULL, '6891d178-ecf1-4bff-84eb-ecbdcd09f18a', 'active', '2026-11-10 03:03:34', '2026-11-10 03:03:34'),
(1768, NULL, '6074e2eb-d93f-4baf-9b58-decf880f9567', 'active', '2026-11-10 03:03:40', '2026-11-10 03:03:40'),
(1769, NULL, '3fdb9366-26a7-41cb-9659-9232daeb417c', 'active', '2026-11-10 03:03:43', '2026-11-10 03:03:43'),
(1770, NULL, '39840e1a-0cff-42c4-ad7f-b3e0110d88bf', 'active', '2026-11-10 03:03:45', '2026-11-10 03:03:45'),
(1771, NULL, '94d09a52-ce7c-4348-b930-7ad53b01f22d', 'active', '2026-11-10 03:03:49', '2026-11-10 03:03:49'),
(1772, NULL, 'b7007a87-21d2-4821-9cae-2f7728814226', 'active', '2026-11-10 03:03:50', '2026-11-10 03:03:50'),
(1773, NULL, 'cc75730f-4014-4485-aa8a-94ae35f3368f', 'active', '2026-11-10 03:06:44', '2026-11-10 03:06:44'),
(1774, NULL, '24c6850b-5129-41f9-8bca-84683d2e913a', 'active', '2026-11-10 03:17:45', '2026-11-10 03:17:45'),
(1775, NULL, '63bdb12c-ae6e-4750-b769-884edb55fc38', 'active', '2026-11-10 03:26:43', '2026-11-10 03:26:43'),
(1776, NULL, '976c8c92-c8be-413a-b903-9586e5fb0bed', 'active', '2026-11-10 03:39:43', '2026-11-10 03:39:43'),
(1777, NULL, '601bde07-e0b8-4fc3-85bb-484cff6e2c85', 'active', '2026-11-10 03:46:40', '2026-11-10 03:46:40'),
(1778, NULL, '11edd3f5-b674-4137-a592-e310677dfc53', 'active', '2026-11-10 03:55:49', '2026-11-10 03:55:49'),
(1779, NULL, '0f66dce5-b8e4-44f0-8d54-4afbfb54ea84', 'active', '2026-11-10 04:05:06', '2026-11-10 04:05:06'),
(1780, NULL, '4cf247c8-202e-4ad5-ab3c-fd764a8a0d52', 'active', '2026-11-10 04:16:40', '2026-11-10 04:16:40'),
(1781, NULL, '809a7f31-047b-41f1-903c-9b1d8a67fbd9', 'active', '2026-11-10 04:18:24', '2026-11-10 04:18:24'),
(1782, NULL, '47ad5ad2-4478-4323-9dc0-7787ba8791ad', 'active', '2026-11-10 04:26:38', '2026-11-10 04:26:38'),
(1783, NULL, '59a104da-e551-4807-8b13-abf6c85098b3', 'active', '2026-11-10 04:37:11', '2026-11-10 04:37:11'),
(1784, NULL, 'd6ada555-c7aa-4566-92e7-29c6d2a68f16', 'active', '2026-11-10 04:38:32', '2026-11-10 04:38:32'),
(1785, NULL, 'e13e5ae0-d2fd-41b6-88ac-fa6db42ec45c', 'active', '2026-11-10 04:43:23', '2026-11-10 04:43:23'),
(1786, NULL, 'e0218d5e-8a48-4fa9-a5c3-517f3375b51f', 'active', '2026-11-10 04:52:27', '2026-11-10 04:52:27'),
(1787, NULL, '084e1a35-5f8a-4f3c-97ac-1188bdba7db0', 'active', '2026-11-10 04:52:28', '2026-11-10 04:52:28'),
(1788, NULL, 'a73f968c-ac2a-4cb5-a8e1-684eb60eb28e', 'active', '2026-11-10 04:52:28', '2026-11-10 04:52:28'),
(1789, NULL, 'e200c664-71fc-4a5d-b7bb-1101d714d074', 'active', '2026-11-10 04:52:29', '2026-11-10 04:52:29'),
(1790, NULL, '36706979-3bd3-4d99-96e0-63a634d4229c', 'active', '2026-11-10 04:52:30', '2026-11-10 04:52:30'),
(1791, NULL, 'face9fa1-1167-4d9e-b960-9fe4c946ed71', 'active', '2026-11-10 04:52:31', '2026-11-10 04:52:31'),
(1792, NULL, 'c4719f6a-c6b7-43db-a0ae-491da2a2090d', 'active', '2026-11-10 04:52:32', '2026-11-10 04:52:32'),
(1793, NULL, '6670a902-7f12-4b4d-bf9d-1fd0e5684ec6', 'active', '2026-11-10 04:52:33', '2026-11-10 04:52:33'),
(1794, NULL, 'c58e5697-0444-4af6-98a6-53e972600346', 'active', '2026-11-10 04:52:34', '2026-11-10 04:52:34'),
(1795, NULL, '0dc1ef9e-bc3a-45b7-a8b1-0275d2501f65', 'active', '2026-11-10 04:52:35', '2026-11-10 04:52:35'),
(1796, NULL, '93a601ad-65a6-43e1-8f45-344353485d2c', 'active', '2026-11-10 04:52:36', '2026-11-10 04:52:36'),
(1797, NULL, 'c66045ab-ddca-4940-bb38-8bf591fa7247', 'active', '2026-11-10 04:52:41', '2026-11-10 04:52:41'),
(1798, NULL, 'b824503c-91fd-48ed-b4bc-8cc03ce7d5e4', 'active', '2026-11-10 04:52:42', '2026-11-10 04:52:42'),
(1799, NULL, '5fecd2f2-ab74-4039-abcf-1dbfa8d90358', 'active', '2026-11-10 04:52:46', '2026-11-10 04:52:46'),
(1800, NULL, '99626505-b18e-4cc3-ba54-e454bb20e195', 'active', '2026-11-10 04:52:47', '2026-11-10 04:52:47'),
(1801, NULL, '64764d29-11f7-4b78-b6b0-3a8c8c20d4c8', 'active', '2026-11-10 04:52:48', '2026-11-10 04:52:48'),
(1802, NULL, 'b01845f2-b72f-4e07-92a4-08d858cd698f', 'active', '2026-11-10 04:56:21', '2026-11-10 04:56:21'),
(1803, NULL, 'df301911-3ec3-4aab-99fe-9db01c5f104f', 'active', '2026-11-10 05:09:08', '2026-11-10 05:09:08'),
(1804, NULL, '951218a5-57aa-4908-99d8-81ce1b12384e', 'active', '2026-11-10 05:15:00', '2026-11-10 05:15:00'),
(1805, NULL, '4d27efc6-16aa-4381-aee4-c33705a25007', 'active', '2026-11-10 05:17:24', '2026-11-10 05:17:24'),
(1806, NULL, '86d5e9bf-519f-4449-9839-3d1bed02d55c', 'active', '2026-11-10 05:17:24', '2026-11-10 05:17:24'),
(1807, NULL, 'e0e7ae67-7cfc-460f-94a0-93a5ea52e0c2', 'active', '2026-11-10 05:17:25', '2026-11-10 05:17:25'),
(1808, NULL, '38e225d2-ffc6-4a1f-8869-4a0bdd734d04', 'active', '2026-11-10 05:17:27', '2026-11-10 05:17:27'),
(1809, NULL, '3975b2ad-4dd8-4aed-a691-8587c609fca5', 'active', '2026-11-10 05:17:28', '2026-11-10 05:17:28'),
(1810, NULL, '03d24f37-57e6-454e-a62e-c4a84472377c', 'active', '2026-11-10 05:17:29', '2026-11-10 05:17:29'),
(1811, NULL, '9b720edc-93ed-4a16-998c-91ee35f6db70', 'active', '2026-11-10 05:17:30', '2026-11-10 05:17:30'),
(1812, NULL, '4603c6a9-75a6-4da1-a777-4f38bf70762c', 'active', '2026-11-10 05:17:31', '2026-11-10 05:17:31'),
(1813, NULL, 'c299b9b9-f3c3-4601-908d-b9ee74fd2363', 'active', '2026-11-10 05:17:32', '2026-11-10 05:17:32'),
(1814, NULL, '20cb6f97-2acc-4dbb-8f92-fd16967daec3', 'active', '2026-11-10 05:17:33', '2026-11-10 05:17:33'),
(1815, NULL, 'f1f4c7e4-f791-42da-8afc-4274f7ac1897', 'active', '2026-11-10 05:17:34', '2026-11-10 05:17:34'),
(1816, NULL, 'e3cf6ee4-88a6-4fe2-b08e-1df8d1fe15a7', 'active', '2026-11-10 05:17:35', '2026-11-10 05:17:35'),
(1817, NULL, '71f85dfd-14f0-4d73-848a-70605d0d02b9', 'active', '2026-11-10 05:17:36', '2026-11-10 05:17:36'),
(1818, NULL, 'ccf018d1-028e-4bc5-b59a-972311ccd4a0', 'active', '2026-11-10 05:17:37', '2026-11-10 05:17:37'),
(1819, NULL, '2492d3e6-ab03-49f8-b507-c0419543e9f2', 'active', '2026-11-10 05:17:38', '2026-11-10 05:17:38'),
(1820, NULL, '24a48285-5acc-4466-a426-299aa4dc6d9a', 'active', '2026-11-10 05:17:39', '2026-11-10 05:17:39'),
(1821, NULL, '1476747c-b589-4080-a2cc-4af675e49ee8', 'active', '2026-11-10 05:17:46', '2026-11-10 05:17:46'),
(1822, NULL, 'ffb4cb96-8f62-48a4-bfe3-63d38f7fd15a', 'active', '2026-11-10 05:26:55', '2026-11-10 05:26:55'),
(1823, NULL, '97ace978-217c-411c-91b3-45ec6a506014', 'active', '2026-11-10 05:31:38', '2026-11-10 05:31:38'),
(1824, NULL, '9f4a7f40-8f5d-4283-ae91-a00305f07d08', 'active', '2026-11-10 05:36:22', '2026-11-10 05:36:22'),
(1825, NULL, '2b32f233-199a-4adb-94b6-b5f0a502f059', 'active', '2026-11-10 05:46:36', '2026-11-10 05:46:36'),
(1826, NULL, '0c66a9d9-0c1e-4e32-9968-22eef7e3130e', 'active', '2026-11-10 05:49:07', '2026-11-10 05:49:07'),
(1827, NULL, '11b5d42e-6bca-4fd8-8da6-2d2535aba345', 'active', '2026-11-10 05:53:35', '2026-11-10 05:53:35'),
(1828, NULL, '6cd5e2b3-f99f-428f-a73c-6b92ee6b1276', 'active', '2026-11-10 06:05:22', '2026-11-10 06:05:22'),
(1829, NULL, '7bd70fcc-662b-492e-a8b8-92d4d3dd9408', 'active', '2026-11-10 06:16:06', '2026-11-10 06:16:06'),
(1830, NULL, '03f00378-3737-431f-98e9-d62ffab64cae', 'active', '2026-11-10 06:16:36', '2026-11-10 06:16:36'),
(1831, NULL, '4c112ca8-d773-42cc-b192-d0e5bf974cb0', 'active', '2026-11-10 06:18:51', '2026-11-10 06:18:51'),
(1832, NULL, '1bdd23c9-7bd4-4347-9601-7ec6a2887353', 'active', '2026-11-10 06:20:07', '2026-11-10 06:20:07'),
(1833, NULL, '21de3663-fbef-46ea-8fd6-526cee51fc71', 'active', '2026-11-10 06:20:46', '2026-11-10 06:20:46'),
(1834, NULL, 'bbae7860-8318-4181-aead-cf2728b4b182', 'active', '2026-11-10 06:20:46', '2026-11-10 06:20:46'),
(1835, NULL, '7c4b48e1-ba52-4968-8f9a-35535c8def4e', 'active', '2026-11-10 06:20:49', '2026-11-10 06:20:49'),
(1836, NULL, 'ea68b219-9e11-4447-b7ba-943b4ac0a58c', 'active', '2026-11-10 06:20:50', '2026-11-10 06:20:50'),
(1837, NULL, '9b9ef61c-6c61-4e5b-8d7f-d09f3e7f15aa', 'active', '2026-11-10 06:20:51', '2026-11-10 06:20:51'),
(1838, NULL, '49948279-7098-4b5b-a0f7-dffa77efdc71', 'active', '2026-11-10 06:20:52', '2026-11-10 06:20:52'),
(1839, NULL, 'f67826db-2596-445e-ae8c-552cca17ec66', 'active', '2026-11-10 06:20:53', '2026-11-10 06:20:53'),
(1840, NULL, '327ed5da-fb30-4e2b-927d-1017b27d3fda', 'active', '2026-11-10 06:20:55', '2026-11-10 06:20:55'),
(1841, NULL, '29546fa9-d71b-4fc0-a9a0-e3179a57f3ef', 'active', '2026-11-10 06:20:58', '2026-11-10 06:20:58'),
(1842, NULL, '00bdb3bb-8e5b-4bfa-9346-942caef7729c', 'active', '2026-11-10 06:20:59', '2026-11-10 06:20:59'),
(1843, NULL, '8b704c2b-d04e-4e4d-a3ed-c2bab651a400', 'active', '2026-11-10 06:21:01', '2026-11-10 06:21:01'),
(1844, NULL, '4a556c87-6318-485d-9532-a27d776667fe', 'active', '2026-11-10 06:21:05', '2026-11-10 06:21:05'),
(1845, NULL, '4ccc2088-9570-40ef-98b9-97225c4ff3e1', 'active', '2026-11-10 06:21:06', '2026-11-10 06:21:06'),
(1846, NULL, 'ac644212-34df-42b3-b7d5-287915388e3d', 'active', '2026-11-10 06:25:49', '2026-11-10 06:25:49'),
(1847, NULL, '0f06cfd9-00c8-4f15-a42e-4ec58cb6cccc', 'active', '2026-11-10 06:33:47', '2026-11-10 06:33:47'),
(1848, NULL, '07d8c6a4-e77e-427c-8bb1-804d39f2d273', 'active', '2026-11-10 06:45:14', '2026-11-10 06:45:14'),
(1849, NULL, '81c3f42e-2eca-4896-89c7-3656ce0bf489', 'active', '2026-11-10 06:53:10', '2026-11-10 06:53:10'),
(1850, NULL, '0a7b6ff7-c578-47ef-968f-673a7497992d', 'active', '2026-11-10 07:00:06', '2026-11-10 07:00:06'),
(1851, NULL, 'd04c00fc-3548-4eb7-adf8-af1f36eb88fc', 'active', '2026-11-10 07:00:08', '2026-11-10 07:00:08'),
(1852, NULL, '9cfefb8d-c8f6-4418-bd93-fd6480e15f8c', 'active', '2026-11-10 07:00:13', '2026-11-10 07:00:13'),
(1853, NULL, 'df8dfdd6-e0bc-4f3a-b554-1f548ede6815', 'active', '2026-11-10 07:00:14', '2026-11-10 07:00:14'),
(1854, NULL, '71f0ac24-3265-4e93-a614-26d932c73df6', 'active', '2026-11-10 07:00:17', '2026-11-10 07:00:17'),
(1855, NULL, 'e85941b5-14aa-44c7-8eed-6003bb7afd2e', 'active', '2026-11-10 07:00:18', '2026-11-10 07:00:18'),
(1856, NULL, '17824e48-f416-4e52-af93-c44f5d5afd16', 'active', '2026-11-10 07:00:19', '2026-11-10 07:00:19'),
(1857, NULL, '78e4b30d-f933-47cb-94be-b09ef8280581', 'active', '2026-11-10 07:00:20', '2026-11-10 07:00:20'),
(1858, NULL, '7cf82b46-7ea0-4f46-b94b-4ec61418a288', 'active', '2026-11-10 07:00:21', '2026-11-10 07:00:21'),
(1859, NULL, '4d82d4b0-0c4b-4ecc-8eb5-d201f8e6e35f', 'active', '2026-11-10 07:00:22', '2026-11-10 07:00:22'),
(1860, NULL, '0873d7bc-e268-4de3-9f24-ed66acd4593b', 'active', '2026-11-10 07:00:28', '2026-11-10 07:00:28'),
(1861, NULL, '87329cfa-34a9-4470-bd84-6775feec9ac7', 'active', '2026-11-10 07:00:30', '2026-11-10 07:00:30'),
(1862, NULL, 'a3593abc-d6a8-45c4-8c01-9f8200881102', 'active', '2026-11-10 07:00:30', '2026-11-10 07:00:30');
INSERT INTO `carts` (`id`, `customer_id`, `session_id`, `status`, `created_at`, `updated_at`) VALUES
(1863, NULL, 'df9d3fe3-c648-42c9-ba0f-569221925bac', 'active', '2026-11-10 07:05:14', '2026-11-10 07:05:14'),
(1864, NULL, '9a659d0c-092d-4661-a1d7-13024b57b901', 'active', '2026-11-10 07:16:14', '2026-11-10 07:16:14'),
(1865, NULL, '00c733ab-7df0-4044-90ca-d08ba591b1ba', 'active', '2026-11-10 07:24:34', '2026-11-10 07:24:34'),
(1866, NULL, 'a34e19d1-8064-4e09-b25a-a7120d6a3a58', 'active', '2026-11-10 07:24:39', '2026-11-10 07:24:39'),
(1867, NULL, 'ef3d43e0-9992-466f-808f-938ac9517167', 'active', '2026-11-10 07:24:45', '2026-11-10 07:24:45'),
(1868, NULL, '74b4809e-ed75-4798-98a5-c1c9da78a979', 'active', '2026-11-10 07:24:50', '2026-11-10 07:24:50'),
(1869, NULL, '8a2e238b-5c48-4d06-8a46-25d1639e691d', 'active', '2026-11-10 07:24:52', '2026-11-10 07:24:52'),
(1870, NULL, '3100c6e5-0f3f-48df-b634-91cd9fab838c', 'active', '2026-11-10 07:24:53', '2026-11-10 07:24:53'),
(1871, NULL, '266a415c-2e40-47f2-b8df-7f1bd42b6cc9', 'active', '2026-11-10 07:24:56', '2026-11-10 07:24:56'),
(1872, NULL, '3a9b5ee8-9b35-431e-82d4-a2ca145be47b', 'active', '2026-11-10 07:24:58', '2026-11-10 07:24:58'),
(1873, NULL, '62431f26-21c2-443f-836a-00525aabd06d', 'active', '2026-11-10 07:24:58', '2026-11-10 07:24:58'),
(1874, NULL, '30a653d5-61de-48af-8322-29226c9bdfa5', 'active', '2026-11-10 07:25:00', '2026-11-10 07:25:00'),
(1875, NULL, 'b50905c9-e79c-4627-98df-1281d53af200', 'active', '2026-11-10 07:25:55', '2026-11-10 07:25:55'),
(1876, NULL, '1e2e745b-6899-410a-8ab8-0d7f8ee86c0f', 'active', '2026-11-10 07:35:31', '2026-11-10 07:35:31'),
(1877, NULL, '9412504f-5113-4244-b191-a2e5e7c7d380', 'active', '2026-11-10 07:40:26', '2026-11-10 07:40:26'),
(1878, NULL, 'd75ce229-22e8-4846-90f0-8f2ab429afd7', 'active', '2026-11-10 07:40:30', '2026-11-10 07:40:30'),
(1879, NULL, 'ffcd64ba-1c5d-4e05-8970-aa43d3ebb56b', 'active', '2026-11-10 07:40:32', '2026-11-10 07:40:32'),
(1880, NULL, 'a827358c-14f2-4382-8053-137fa8ba88c4', 'active', '2026-11-10 07:40:33', '2026-11-10 07:40:33'),
(1881, NULL, '59e39460-552a-4d7b-89a0-72f729b8a7d8', 'active', '2026-11-10 07:40:35', '2026-11-10 07:40:35'),
(1882, NULL, '965722a7-c081-4a1d-840a-aa1ce66e11c0', 'active', '2026-11-10 07:40:36', '2026-11-10 07:40:36'),
(1883, NULL, 'ab4ea25b-1f32-4e13-bf05-ff58a8e8aaaa', 'active', '2026-11-10 07:40:38', '2026-11-10 07:40:38'),
(1884, NULL, '9b5f61fa-297e-4356-a1e4-7dd3fc4747c1', 'active', '2026-11-10 07:40:44', '2026-11-10 07:40:44'),
(1885, NULL, '2161984c-fefa-46a4-b5ff-3064ed48e8f5', 'active', '2026-11-10 07:43:28', '2026-11-10 07:43:28'),
(1886, NULL, 'a08e711c-41e9-4343-b4ff-16c5da4a8eb0', 'active', '2026-11-10 07:46:51', '2026-11-10 07:46:51'),
(1887, NULL, '0b597a74-f1e3-43ac-8bba-e49dbe2439af', 'active', '2026-11-10 07:56:32', '2026-11-10 07:56:32'),
(1888, NULL, '90a39f26-f3cc-4a5e-b2bd-ae319e12036d', 'active', '2026-11-10 08:06:20', '2026-11-10 08:06:20'),
(1889, NULL, 'c016041f-5182-42e1-be79-1cc8e7035ad4', 'active', '2026-11-10 08:07:44', '2026-11-10 08:07:44'),
(1890, NULL, '76f6b8e7-203d-4de3-a19c-3dcbb8d55c65', 'active', '2026-11-10 08:10:58', '2026-11-10 08:10:58'),
(1891, NULL, '0fc21004-bde9-4646-a8ec-d1304bfafea7', 'active', '2026-11-10 08:14:54', '2026-11-10 08:14:54'),
(1892, NULL, '20001fb0-4a01-4223-af01-f9ccda2cd0b9', 'active', '2026-11-10 08:14:55', '2026-11-10 08:14:55'),
(1893, NULL, '2263249d-20e6-44a8-b533-2a61d5e3a0bc', 'active', '2026-11-10 08:14:56', '2026-11-10 08:14:56'),
(1894, NULL, '16b1ba5f-beb1-4a77-bbac-dce0cf0ed891', 'active', '2026-11-10 08:14:57', '2026-11-10 08:14:57'),
(1895, NULL, '21e74553-214b-40dd-9403-91da95cd8a54', 'active', '2026-11-10 08:14:58', '2026-11-10 08:14:58'),
(1896, NULL, '641e959b-3216-4efd-afd4-22f9f0699ac1', 'active', '2026-11-10 08:14:59', '2026-11-10 08:14:59'),
(1897, NULL, 'c5375a6e-86b2-4f02-8523-f37879bfa5d6', 'active', '2026-11-10 08:15:00', '2026-11-10 08:15:00'),
(1898, NULL, '7e1553ae-bb6b-42a1-aa35-c943e5d965f0', 'active', '2026-11-10 08:15:01', '2026-11-10 08:15:01'),
(1899, NULL, '3de51aeb-f3b0-46f4-8b09-0e57adc38181', 'active', '2026-11-10 08:15:08', '2026-11-10 08:15:08'),
(1900, NULL, '45f80607-e63f-4fe9-a132-0ba382ed6055', 'active', '2026-11-10 08:15:09', '2026-11-10 08:15:09'),
(1901, NULL, 'a42fdea9-890c-4d08-80a7-7e069d351b17', 'active', '2026-11-10 08:15:10', '2026-11-10 08:15:10'),
(1902, NULL, '1bdbc4eb-cfec-4cf3-9369-b1d3b867cb3c', 'active', '2026-11-10 08:15:11', '2026-11-10 08:15:11'),
(1903, NULL, 'b2848f86-9bcb-4594-a8fa-8c658a4ded40', 'active', '2026-11-10 08:15:13', '2026-11-10 08:15:13'),
(1904, NULL, 'e1c7ccbc-3290-439d-b396-7ff4750bda48', 'active', '2026-11-10 08:15:17', '2026-11-10 08:15:17'),
(1905, NULL, '1c123801-9669-4992-94a3-7efd64861e97', 'active', '2026-11-10 08:15:18', '2026-11-10 08:15:18'),
(1906, NULL, 'fec590be-cb13-41bd-86d5-4f0b145b439b', 'active', '2026-11-10 08:15:18', '2026-11-10 08:15:18'),
(1907, NULL, 'af879e17-f78c-42f1-a784-c222a032a323', 'active', '2026-11-10 08:15:28', '2026-11-10 08:15:28'),
(1908, NULL, '9569a9d5-a581-47bf-a710-63fd63fce9de', 'active', '2026-11-10 08:21:33', '2026-11-10 08:21:33'),
(1909, NULL, 'e7169ff9-fae9-4b7c-b3bd-efe1fee79199', 'active', '2026-11-10 08:23:30', '2026-11-10 08:23:30'),
(1910, NULL, 'a386faf3-cc53-492e-b802-9a4d4a9cb93d', 'active', '2026-11-10 08:23:31', '2026-11-10 08:23:31'),
(1911, NULL, '7c284330-4c12-4d97-bdd0-138e487c65f4', 'active', '2026-11-10 08:23:32', '2026-11-10 08:23:32'),
(1912, NULL, '0a88258d-8e3c-43d8-a12d-9f617a86a7ca', 'active', '2026-11-10 08:23:34', '2026-11-10 08:23:34'),
(1913, NULL, 'da9db99c-4fc6-40a7-baf8-cf79e3317e2e', 'active', '2026-11-10 08:23:36', '2026-11-10 08:23:36'),
(1914, NULL, '33fcbb4f-993d-43ea-988b-4a51d70ac268', 'active', '2026-11-10 08:23:36', '2026-11-10 08:23:36'),
(1915, NULL, 'c11254d0-a7e5-44b2-a412-cf166b1314b5', 'active', '2026-11-10 08:23:36', '2026-11-10 08:23:36'),
(1916, NULL, 'cbb188f5-8419-4780-ad18-d490dfa4ec1f', 'active', '2026-11-10 08:23:37', '2026-11-10 08:23:37'),
(1917, NULL, '20b3da4b-f170-4bc0-be5f-53aae5bd98c6', 'active', '2026-11-10 08:23:38', '2026-11-10 08:23:38'),
(1918, NULL, '3cc4ab80-6c9e-455d-960d-cf66c1d7fc3f', 'active', '2026-11-10 08:23:40', '2026-11-10 08:23:40'),
(1919, NULL, '59d35a32-a1d8-4f50-b76c-dea47e624f6f', 'active', '2026-11-10 08:25:54', '2026-11-10 08:25:54'),
(1920, NULL, 'db44777f-57e2-46d4-af3f-376abaab7422', 'active', '2026-11-10 08:34:51', '2026-11-10 08:34:51'),
(1921, NULL, '2e03997b-2384-48ad-bafd-d150ab40cfc9', 'active', '2026-11-10 08:34:52', '2026-11-10 08:34:52'),
(1922, NULL, 'd9465fe1-983f-495a-ba82-5a77084a3e69', 'active', '2026-11-10 08:34:53', '2026-11-10 08:34:53'),
(1923, NULL, '741bcb43-7704-4a44-b6ce-08cc5735080a', 'active', '2026-11-10 08:34:54', '2026-11-10 08:34:54'),
(1924, NULL, '194b2744-9148-4ba3-a6da-d712dab50151', 'active', '2026-11-10 08:34:55', '2026-11-10 08:34:55'),
(1925, NULL, '2bb15f52-b853-4fa8-a84d-b2dc2c27afa1', 'active', '2026-11-10 08:34:57', '2026-11-10 08:34:57'),
(1926, NULL, '7612e454-af76-460a-9f22-ef0218981d90', 'active', '2026-11-10 08:34:59', '2026-11-10 08:34:59'),
(1927, NULL, 'b957fbe3-fe0e-4adf-a5b7-3b357742127a', 'active', '2026-11-10 08:35:02', '2026-11-10 08:35:02'),
(1928, NULL, '994d98c1-4fa4-43c4-9fea-09bb3f82d503', 'active', '2026-11-10 08:35:05', '2026-11-10 08:35:05'),
(1929, NULL, 'f535c600-0a61-4971-9980-fec90a256048', 'active', '2026-11-10 08:35:08', '2026-11-10 08:35:08'),
(1930, NULL, '7381a7c3-8a45-401f-9903-4efb8f01c898', 'active', '2026-11-10 08:35:09', '2026-11-10 08:35:09'),
(1931, NULL, 'f201bd73-1075-49d1-84e9-542b0e4acf26', 'active', '2026-11-10 08:36:16', '2026-11-10 08:36:16'),
(1932, NULL, 'f2ee4860-8a3a-43bc-952d-a23b537813ed', 'active', '2026-11-10 08:46:21', '2026-11-10 08:46:21'),
(1933, NULL, '3174b581-1822-494c-a51f-05f83356a01f', 'active', '2026-11-10 08:54:13', '2026-11-10 08:54:13'),
(1934, NULL, '9e43edb0-a517-4a0c-8a1a-576926779905', 'active', '2026-11-10 08:54:37', '2026-11-10 08:54:37'),
(1935, NULL, '36d6907f-507c-4f1d-9211-b7d145d32cab', 'active', '2026-11-10 08:54:38', '2026-11-10 08:54:38'),
(1936, NULL, '42e1efb8-4756-4fc8-9024-96d773f03dff', 'active', '2026-11-10 08:54:38', '2026-11-10 08:54:38'),
(1937, NULL, '2ac34942-8baa-450c-953f-2a8c082af5ce', 'active', '2026-11-10 08:54:39', '2026-11-10 08:54:39'),
(1938, NULL, 'e0f508de-62c0-4924-8329-37b42025f057', 'active', '2026-11-10 08:54:40', '2026-11-10 08:54:40'),
(1939, NULL, 'a9d0660f-1a57-4d68-affe-22cab30b198e', 'active', '2026-11-10 08:54:41', '2026-11-10 08:54:41'),
(1940, NULL, 'b20e2195-818a-410d-aa8d-5974d792b3f8', 'active', '2026-11-10 08:54:42', '2026-11-10 08:54:42'),
(1941, NULL, '3acaee12-56f6-4f91-8cb9-21d86f6ad349', 'active', '2026-11-10 08:54:43', '2026-11-10 08:54:43'),
(1942, NULL, '572eea27-15b5-4a4b-826f-0f7699baa079', 'active', '2026-11-10 08:54:44', '2026-11-10 08:54:44'),
(1943, NULL, '91539c4e-1eae-4a02-9f39-05a83eb96759', 'active', '2026-11-10 08:54:45', '2026-11-10 08:54:45'),
(1944, NULL, 'e4f12824-2acd-4fdb-bc9d-12c3cc714174', 'active', '2026-11-10 08:54:46', '2026-11-10 08:54:46'),
(1945, NULL, 'b187b01a-2ce1-4edb-b34d-6c63ddfc0394', 'active', '2026-11-10 08:54:47', '2026-11-10 08:54:47'),
(1946, NULL, '5070ba61-e2d4-4872-8e11-ed0dd3f4d425', 'active', '2026-11-10 08:54:48', '2026-11-10 08:54:48'),
(1947, NULL, 'b53ad13c-aeed-4567-af88-15a5dd8de709', 'active', '2026-11-10 08:54:49', '2026-11-10 08:54:49'),
(1948, NULL, 'dd893fe0-1989-456a-96b3-c5cc4297a6c3', 'active', '2026-11-10 08:54:50', '2026-11-10 08:54:50'),
(1949, NULL, 'fce19838-43f0-4756-afa4-6fa50748580a', 'active', '2026-11-10 09:05:04', '2026-11-10 09:05:04'),
(1951, NULL, 'a23c63e6-8726-4810-9797-aad3a4bdf7b3', 'active', '2026-11-10 01:52:03', '2026-11-10 01:52:03'),
(1952, NULL, '1ac8a2c4-61d6-478f-88ae-9238951edba3', 'active', '2026-11-10 03:30:33', '2026-11-10 03:30:33'),
(1953, NULL, '50953147-6b7f-46cb-b966-eea7306db7b9', 'active', '2026-11-10 03:44:17', '2026-11-10 03:44:17'),
(1954, NULL, 'da725755-d5d3-40c1-ba91-23d69d1e0f10', 'active', '2026-11-10 03:46:29', '2026-11-10 03:46:29'),
(1955, NULL, 'ac8a04c1-e02b-4cb8-804a-2426c0954ad5', 'active', '2026-11-10 04:17:02', '2026-11-10 04:17:02'),
(1956, NULL, 'cbf90b48-0849-4e20-98b0-6652ea29ef65', 'active', '2026-11-10 04:51:26', '2026-11-10 04:51:26'),
(1957, 8, NULL, 'active', '2026-11-10 04:52:08', '2026-11-10 04:52:08'),
(1958, NULL, 'f6d0230d-8f26-4d2a-937e-6a7160f5abb7', 'active', '2026-11-10 06:03:14', '2026-11-10 06:03:14'),
(1959, NULL, 'c889754a-465f-409f-b40b-db67e0b1e44f', 'active', '2026-11-10 06:14:07', '2026-11-10 06:14:07'),
(1960, NULL, 'b3e654db-7123-46ad-9dca-9591aae9c26e', 'active', '2026-11-10 06:17:43', '2026-11-10 06:17:43'),
(1961, NULL, '414d0a8d-22ef-4b27-a504-2c76105b560e', 'active', '2026-11-10 06:18:42', '2026-11-10 06:18:42'),
(1962, NULL, 'a82757a9-38f6-455e-9316-a29cbd5997cc', 'active', '2026-11-10 06:19:09', '2026-11-10 06:19:09'),
(1963, NULL, '6bed9490-8a1b-4d53-a4b5-1eb34ba09d37', 'active', '2026-11-10 06:26:53', '2026-11-10 06:26:53'),
(1964, NULL, '4311ba65-5607-476c-9a3f-1c946c20e411', 'active', '2026-11-10 06:27:40', '2026-11-10 06:27:40'),
(1965, NULL, '0019fd0e-e43b-4b0f-b441-40140264a332', 'active', '2026-11-10 06:29:37', '2026-11-10 06:29:37'),
(1966, NULL, '1bcd9024-54cf-43d6-822a-dfe832784331', 'active', '2026-11-10 06:31:46', '2026-11-10 06:31:46'),
(1967, NULL, 'd4709301-473d-47fb-afd6-e3a9d9b2b0f5', 'active', '2026-11-10 06:32:24', '2026-11-10 06:32:24');

-- --------------------------------------------------------

--
-- Table structure for table `cart_items`
--

CREATE TABLE `cart_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `cart_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `variant_id` bigint(20) UNSIGNED DEFAULT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `price` decimal(12,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart_items`
--

INSERT INTO `cart_items` (`id`, `cart_id`, `product_id`, `variant_id`, `quantity`, `price`, `created_at`, `updated_at`) VALUES
(4, 28, 38, NULL, 1, 269.00, '2026-09-27 11:13:30', '2026-09-27 11:13:43'),
(5, 42, 46, NULL, 2, 65000.00, '2026-10-01 22:57:03', '2026-10-01 23:36:32'),
(8, 49, 47, NULL, 2, 13000.00, '2026-10-03 11:03:12', '2026-10-03 11:14:20'),
(10, 49, 49, NULL, 3, 4500.00, '2026-10-03 11:09:15', '2026-10-03 11:33:37'),
(13, 268, 45, NULL, 2, 35000.00, '2026-11-01 05:50:30', '2026-11-01 05:58:41'),
(15, 267, 54, NULL, 1, 2375.00, '2026-11-01 06:16:09', '2026-11-01 06:36:00'),
(19, 277, 45, NULL, 1, 35000.00, '2026-11-01 23:46:08', '2026-11-01 23:46:08'),
(22, 281, 45, NULL, 2, 35000.00, '2026-11-02 00:06:47', '2026-11-02 00:15:18'),
(24, 281, 84, NULL, 1, 33750.00, '2026-11-02 01:07:23', '2026-11-02 01:07:23'),
(26, 990, 45, NULL, 1, 35000.00, '2026-11-06 21:41:05', '2026-11-06 21:41:05'),
(27, 809, 45, NULL, 1, 35000.00, '2026-11-09 14:24:55', '2026-11-09 14:24:55'),
(28, 1580, 185, NULL, 1, 449900.00, '2026-11-09 17:09:52', '2026-11-09 17:09:52'),
(29, 1582, 45, NULL, 1, 35000.00, '2026-11-09 17:11:17', '2026-11-09 17:11:17');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `parent_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(191) NOT NULL,
  `slug` varchar(191) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `icon` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT 1,
  `sort_order` int(11) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `parent_id`, `name`, `slug`, `image`, `status`, `icon`, `is_active`, `sort_order`, `created_at`, `updated_at`) VALUES
(1, NULL, 'Shop', 'shop', 'categories/tsiPhi1Iya8vbpDidfzc0wPo2qZ1hdCdlyHTRmSl.png', 1, NULL, 1, 0, '2026-09-17 13:13:07', '2026-09-25 10:33:00'),
(2, NULL, 'Electronics', 'electronics', 'categories/LlpqiQDo3FvUl3bfFmkErJtcm0adAK2BIxZKhFRx.jpg', 1, NULL, 1, 0, '2026-09-18 08:41:09', '2026-09-25 10:32:39'),
(3, NULL, 'Fashion', 'fashion', 'categories/MipJzUm4TZJdyrYkPzN5k494JttxrHuAEDZbWB7H.png', 1, NULL, 1, 0, '2026-09-18 08:41:09', '2026-09-25 10:33:17'),
(4, NULL, 'Beauty & Personal Care', 'beauty-personal-care', 'categories/bumGzgi3eUzXuiF6615Jsq6flcsOrCy7zUwB69Vm.png', 1, NULL, 1, 0, '2026-09-18 08:41:09', '2026-09-25 10:33:28'),
(5, NULL, 'Home & Living', 'home-living', 'categories/NTTiJ6j707LEuZN6aGebNQ5fYNvKQh5aqZhCBSem.png', 1, NULL, 1, 0, '2026-09-18 08:41:09', '2026-09-25 10:33:37'),
(6, NULL, 'Groceries', 'groceries', 'categories/0MEA68BOWfB8piZP1HaNOM0F967u0XLb2eQyEqQK.png', 1, NULL, 1, 0, '2026-09-18 08:41:09', '2026-09-25 10:33:50'),
(7, NULL, 'Health & Wellness', 'health-wellness', NULL, 1, NULL, 1, 0, '2026-09-18 08:41:09', '2026-09-18 08:41:09'),
(8, NULL, 'Sports & Fitness', 'sports-fitness', NULL, 1, NULL, 1, 0, '2026-09-18 08:41:09', '2026-09-18 08:41:09'),
(9, NULL, 'Baby & Kids', 'baby-kids', 'categories/vmY3aCyOXqEh5ntPMgJmn06KB6RedOC6k2yriSTu.png', 1, NULL, 1, 0, '2026-09-18 08:41:09', '2026-09-25 03:49:13'),
(10, 2, 'Automotive', 'automotive', 'categories/t7nhy3TKCNYZW8sd0NxIn0mO8PZD9O2Zap9TtvTQ.jpg', 1, NULL, 1, 0, '2026-09-18 08:41:09', '2026-09-19 11:22:07'),
(11, NULL, 'Books & Stationery', 'books-stationery', NULL, 1, NULL, 1, 0, '2026-09-18 08:41:09', '2026-09-18 08:41:09'),
(12, 1, 'Mobile Phones', 'mobile-phones', 'categories/FtyaMtNSNP1qa67xSiSR6VjyH2O4hC1PBohqghny.jpg', 1, NULL, 1, 0, '2026-09-18 08:41:09', '2026-09-19 11:24:15'),
(13, 1, 'Laptops & Computers', 'laptops-computers', 'categories/xuL65vL0WptcfA3wMo9oYPNo2aNSrkl4Pi27w5Hf.jpg', 1, NULL, 1, 0, '2026-09-18 08:41:09', '2026-09-19 11:24:42'),
(14, 2, 'Men\'s Fashion', 'mens-fashion', 'categories/oXtyeK6WRYeB5M4Nm8nhyWmNlxq5n7DHvC1Djlu6.jpg', 1, NULL, 1, 0, '2026-09-18 08:41:09', '2026-09-19 11:25:00'),
(15, 2, 'Women\'s Fashion', 'womens-fashion', 'categories/aZOOnaJn5uR5zJrCBRqZse9gR2ETr20Mq6KBQJE6.jpg', 1, NULL, 1, 0, '2026-09-18 08:41:09', '2026-09-19 11:25:22'),
(16, 3, 'Skincare', 'skincare', 'categories/6fdZIz218M8lAqSMTRzCyhsAlHIq0p2T90SD3vLg.jpg', 1, NULL, 1, 0, '2026-09-18 08:41:09', '2026-09-19 11:26:47'),
(17, 3, 'Makeup', 'makeup', 'categories/fcjbwbzZ8PcnDSSu5Y1e9WTbWOkyc4qYW7HVboKp.jpg', 1, NULL, 1, 0, '2026-09-18 08:41:09', '2026-09-19 11:26:59'),
(18, 4, 'Furniture', 'furniture', 'categories/N4pjbZnynYSCUyKpjOa3DS7eabyeODKz6m9VlWxR.jpg', 1, NULL, 1, 0, '2026-09-18 08:41:09', '2026-09-19 11:28:23'),
(19, 4, 'Home Decor', 'home-decor', 'categories/PZoHHYyWWaDMaz4uMQ5y0k4daCOct52C4xjuTmrw.jpg', 1, NULL, 1, 0, '2026-09-18 08:41:09', '2026-09-19 11:28:36'),
(20, 5, 'Food & Beverages', 'food-beverages', NULL, 1, NULL, 1, 0, '2026-09-18 08:41:09', '2026-09-18 08:41:09'),
(21, 5, 'Household Essentials', 'household-essentials', NULL, 1, NULL, 1, 0, '2026-09-18 08:41:09', '2026-09-19 18:48:19'),
(23, 2, 'Smartphones', 'smartphones', NULL, 1, NULL, 1, 0, '2026-09-19 18:24:46', '2026-09-19 20:29:34'),
(24, 2, 'Laptops', 'laptops', 'categories/KHJNGeX2GSpGzSaEVz9ix8xY2i6yQWXQ1Re8vUfY.jpg', 1, NULL, 1, 0, '2026-09-19 18:40:15', '2026-09-19 20:29:17'),
(25, 2, 'Smartwatches', 'smartwatches', 'categories/gYBdNotkmSoiXE6RlGWfCkOy4qZJuagXPjwO3JNd.jpg', 1, NULL, 1, 0, '2026-09-19 20:09:45', '2026-09-19 20:28:52'),
(26, 2, 'Headphones', 'headphones', NULL, 1, NULL, 1, 0, '2026-09-19 20:27:12', '2026-09-19 20:30:56'),
(27, 2, 'Earbuds', 'earbuds', NULL, 1, NULL, 1, 0, '2026-09-19 20:27:23', '2026-09-19 20:31:04'),
(28, 2, 'Power Banks', 'power-banks', NULL, 1, NULL, 1, 0, '2026-09-19 20:27:34', '2026-09-19 20:31:12'),
(29, 31, 'Chargers', 'chargers', NULL, 1, NULL, 1, 0, '2026-09-19 20:27:43', '2026-10-31 23:43:36'),
(31, NULL, 'Small Appliances', 'small-appliances', NULL, 1, NULL, 1, 0, '2026-09-19 20:29:53', '2026-10-31 23:40:38'),
(32, 2, 'Bluetooth Speakers', 'bluetooth-speakers', NULL, 1, NULL, 1, 0, '2026-09-19 20:31:40', '2026-09-19 20:31:40'),
(33, 2, 'Computer Accessories', 'computer-accessories', NULL, 1, NULL, 1, 0, '2026-09-19 20:32:04', '2026-09-19 20:32:04'),
(34, 3, 'Men\'s T-Shirts', 'men-s-t-shirts', NULL, 1, NULL, 1, 0, '2026-09-19 20:32:53', '2026-09-19 20:32:53'),
(35, 3, 'Men\'s Shirts', 'men-s-shirts', NULL, 1, NULL, 1, 0, '2026-09-19 20:33:14', '2026-09-19 20:33:14'),
(36, 3, 'Men\'s Pants', 'men-s-pants', NULL, 1, NULL, 1, 0, '2026-09-19 20:33:28', '2026-09-19 20:33:28'),
(37, 3, 'Women\'s Dresses', 'women-s-dresses', NULL, 1, NULL, 1, 0, '2026-09-19 20:33:41', '2026-09-19 20:33:41'),
(38, 3, 'Women\'s Tops', 'women-s-tops', NULL, 1, NULL, 1, 0, '2026-09-19 20:33:53', '2026-09-19 20:33:53'),
(39, 3, 'Women\'s Sarees', 'women-s-sarees', NULL, 1, NULL, 1, 0, '2026-09-19 20:34:04', '2026-09-19 20:34:04'),
(40, 3, 'Men\'s Panjabi', 'men-s-panjabi', NULL, 1, NULL, 1, 0, '2026-09-19 20:34:17', '2026-09-19 20:34:17'),
(41, 3, 'Hijab', 'hijab', NULL, 1, NULL, 1, 0, '2026-09-19 20:34:29', '2026-09-19 20:34:29'),
(42, 3, 'Jackets', 'jackets', NULL, 1, NULL, 1, 0, '2026-09-19 20:34:40', '2026-09-19 20:34:40'),
(43, 3, 'Kids Clothing', 'kids-clothing', NULL, 1, NULL, 1, 0, '2026-09-19 20:34:52', '2026-09-19 20:34:52'),
(44, 5, 'Beds & Mattresses', 'beds-mattresses', NULL, 1, NULL, 1, 0, '2026-09-19 20:35:22', '2026-09-19 20:35:22'),
(45, 5, 'Curtains', 'curtains', NULL, 1, NULL, 1, 0, '2026-09-19 20:35:41', '2026-09-19 20:35:41'),
(46, 5, 'Bedsheets', 'bedsheets', NULL, 1, NULL, 1, 0, '2026-09-19 20:35:53', '2026-09-19 20:35:53'),
(47, 5, 'Pillows', 'pillows', NULL, 1, NULL, 1, 0, '2026-09-19 20:36:03', '2026-09-19 20:36:03'),
(48, 5, 'Kitchen Storage', 'kitchen-storage', NULL, 1, NULL, 1, 0, '2026-09-19 20:36:16', '2026-09-19 20:36:16'),
(50, 5, 'Rugs & Carpets', 'rugs-carpets', NULL, 1, NULL, 1, 0, '2026-09-19 20:36:53', '2026-09-19 20:36:53'),
(51, 5, 'Bathroom Accessories', 'bathroom-accessories', NULL, 1, NULL, 1, 0, '2026-09-19 20:38:20', '2026-09-19 20:38:20'),
(52, NULL, 'Air Conditioner', 'air-conditioner', NULL, 1, NULL, 1, 0, '2026-11-01 06:52:49', '2026-11-01 06:52:49'),
(53, NULL, 'Television', 'television', NULL, 1, NULL, 1, 0, '2026-11-01 06:52:49', '2026-11-01 06:52:49'),
(54, NULL, 'Refrigerator', 'refrigerator', NULL, 1, NULL, 1, 0, '2026-11-01 06:52:49', '2026-11-01 06:52:49'),
(56, NULL, 'Microwave Oven', 'microwave-oven', NULL, 1, NULL, 1, 0, '2026-11-01 06:52:49', '2026-11-01 06:52:49'),
(57, NULL, 'Water Heater', 'water-heater', NULL, 1, NULL, 1, 0, '2026-11-02 12:04:29', '2026-11-02 12:04:29'),
(58, NULL, 'Washing Machine', 'washing-machine', NULL, 1, NULL, 1, 0, '2026-11-02 12:04:29', '2026-11-02 12:04:29'),
(60, 52, 'Inverter AC', 'ac-inverter', NULL, 1, NULL, 1, 0, '2026-11-02 12:04:29', '2026-11-02 12:04:29'),
(61, 52, 'Non-Inverter AC', 'ac-non-inverter', NULL, 1, NULL, 1, 0, '2026-11-02 12:04:29', '2026-11-02 12:04:29'),
(62, 52, 'Cassette AC (Commercial)', 'ac-cassette', NULL, 1, NULL, 1, 0, '2026-11-02 12:04:29', '2026-11-02 12:04:29'),
(63, 54, 'Top Mount Freezer', 'ref-top-mount', NULL, 1, NULL, 1, 0, '2026-11-02 12:04:29', '2026-11-02 12:04:29'),
(64, 54, 'Bottom Mount Freezer', 'ref-bottom-mount', NULL, 1, NULL, 1, 0, '2026-11-02 12:04:29', '2026-11-02 12:04:29'),
(65, 54, 'Side by Side', 'ref-side-by-side', NULL, 1, NULL, 1, 0, '2026-11-02 12:04:29', '2026-11-02 12:04:29'),
(66, 54, 'T Door', 'ref-t-door', NULL, 1, NULL, 1, 0, '2026-11-02 12:04:29', '2026-11-02 12:04:29'),
(67, 54, 'No Frost', 'ref-no-frost', NULL, 1, NULL, 1, 0, '2026-11-02 12:04:29', '2026-11-02 12:04:29'),
(68, 53, 'QLED TV', 'tv-qled', NULL, 1, NULL, 1, 0, '2026-11-02 12:04:29', '2026-11-02 12:04:29'),
(69, 53, 'HQLED TV', 'tv-hqled', NULL, 1, NULL, 1, 0, '2026-11-02 12:04:29', '2026-11-02 12:04:29'),
(70, 53, 'MiniLED TV', 'tv-miniled', NULL, 1, NULL, 1, 0, '2026-11-02 12:04:29', '2026-11-02 12:04:29'),
(71, 56, 'Solo Microwave', 'mw-solo', NULL, 1, NULL, 1, 0, '2026-11-02 12:04:29', '2026-11-02 12:04:29'),
(72, 56, 'Grill Microwave', 'mw-grill', NULL, 1, NULL, 1, 0, '2026-11-02 12:04:29', '2026-11-02 12:04:29'),
(73, 56, 'Convection Microwave', 'mw-convection', NULL, 1, NULL, 1, 0, '2026-11-02 12:04:29', '2026-11-02 12:04:29'),
(74, 58, 'Front Load', 'wm-front-load', NULL, 1, NULL, 1, 0, '2026-11-02 12:04:29', '2026-11-02 12:04:29'),
(75, 58, 'Top Load', 'wm-top-load', NULL, 1, NULL, 1, 0, '2026-11-02 12:04:29', '2026-11-02 12:04:29'),
(76, 58, 'Washer Dryer', 'wm-washer-dryer', NULL, 1, NULL, 1, 0, '2026-11-02 12:04:29', '2026-11-02 12:04:29');

-- --------------------------------------------------------

--
-- Table structure for table `commissions`
--

CREATE TABLE `commissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_item_id` bigint(20) UNSIGNED DEFAULT NULL,
  `vendor_id` bigint(20) UNSIGNED DEFAULT NULL,
  `affiliate_id` bigint(20) UNSIGNED DEFAULT NULL,
  `amount` decimal(12,2) NOT NULL DEFAULT 0.00,
  `status` varchar(255) NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `commission_rules`
--

CREATE TABLE `commission_rules` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `category_id` bigint(20) UNSIGNED DEFAULT NULL,
  `vendor_id` bigint(20) UNSIGNED DEFAULT NULL,
  `commission_percent` decimal(5,2) NOT NULL DEFAULT 0.00,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `compare_lists`
--

CREATE TABLE `compare_lists` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `contact_messages`
--

CREATE TABLE `contact_messages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `subject` varchar(255) DEFAULT NULL,
  `message` text NOT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'unread',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `contact_messages`
--

INSERT INTO `contact_messages` (`id`, `name`, `email`, `subject`, `message`, `status`, `created_at`, `updated_at`) VALUES
(1, 'sfdafdasf', 'ssafsaore678@gmail.com', 'dfsfasfdas', 'sadfasfdsaf', 'unread', '2026-10-01 22:10:28', '2026-10-01 22:10:28'),
(2, 'sfasfds', 'sesfsafdre678@gmail.com', 'sfsafd', 'sadfsadfsafd', 'unread', '2026-10-01 22:13:25', '2026-10-01 22:13:25'),
(3, 'jessica 97', 'sellymore678@gmail.com', 'sfsadfsa', 'sadfasfdsafdfas', 'unread', '2026-10-01 22:15:43', '2026-10-01 22:15:43');

-- --------------------------------------------------------

--
-- Table structure for table `coupons`
--

CREATE TABLE `coupons` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(100) NOT NULL,
  `type` enum('fixed','percentage') NOT NULL DEFAULT 'fixed',
  `value` decimal(10,2) NOT NULL DEFAULT 0.00,
  `min_order_amount` decimal(10,2) DEFAULT NULL,
  `max_discount_amount` decimal(10,2) DEFAULT NULL,
  `usage_limit` int(10) UNSIGNED DEFAULT NULL,
  `used_count` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `starts_at` datetime DEFAULT NULL,
  `expires_at` datetime DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `coupons`
--

INSERT INTO `coupons` (`id`, `code`, `type`, `value`, `min_order_amount`, `max_discount_amount`, `usage_limit`, `used_count`, `starts_at`, `expires_at`, `status`, `created_at`, `updated_at`) VALUES
(1, 'EID20256', 'percentage', 10.00, 2000.00, NULL, NULL, 0, NULL, NULL, 0, '2026-09-18 10:39:14', '2026-09-18 10:39:14');

-- --------------------------------------------------------

--
-- Table structure for table `coupon_products`
--

CREATE TABLE `coupon_products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `coupon_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `coupon_usages`
--

CREATE TABLE `coupon_usages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `coupon_id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` bigint(20) UNSIGNED DEFAULT NULL,
  `order_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `couriers`
--

CREATE TABLE `couriers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `driver` varchar(255) NOT NULL DEFAULT 'manual',
  `tracking_url` varchar(255) DEFAULT NULL,
  `credentials` text DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `couriers`
--

INSERT INTO `couriers` (`id`, `name`, `driver`, `tracking_url`, `credentials`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Steadfast', 'steadfast', NULL, 'eyJpdiI6ImlpRFZ5eGRWZ3p2RHc3alRrT1JXWEE9PSIsInZhbHVlIjoidG1rVkRMR1JPTDJWcGZjWXY1V2FWU05WUXlhRVdicUpBK051djkvYkRmVm52WmwzSkNXam1ZcmN3RHJGRlJnREo0S08vSnorQVcyS2NLeGZsdUhpQ2c9PSIsIm1hYyI6IjM2YzU5NjNhODViMmM1NTU5NzY2ZDRiMmY2NDFhOWU4MmVmYTBhMmMwMDAyY2IwNzE0OGU2YTQ5ZTc4MDZkMGQiLCJ0YWciOiIifQ==', 1, '2026-09-18 11:36:39', '2026-11-03 02:29:29');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `date_of_birth` date DEFAULT NULL,
  `gender` enum('male','female','other') DEFAULT NULL,
  `loyalty_points` int(11) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `user_id`, `date_of_birth`, `gender`, `loyalty_points`, `created_at`, `updated_at`) VALUES
(1, 1, NULL, NULL, 0, '2026-10-21 05:49:36', '2026-10-21 05:49:36'),
(2, 7, NULL, NULL, 0, '2026-11-01 23:27:52', '2026-11-01 23:27:52'),
(3, 8, NULL, NULL, 0, '2026-11-01 23:47:22', '2026-11-01 23:47:22'),
(4, 9, NULL, 'male', 0, '2026-11-03 23:44:41', '2026-11-04 04:34:27'),
(5, 2, NULL, NULL, 0, '2026-11-09 17:11:00', '2026-11-09 17:11:00'),
(6, 10, NULL, NULL, 0, '2026-11-09 17:39:43', '2026-11-09 17:39:43'),
(7, 11, NULL, NULL, 0, '2026-11-09 18:06:31', '2026-11-09 18:06:31'),
(8, 12, NULL, NULL, 0, '2026-11-10 04:52:08', '2026-11-10 04:52:08');

-- --------------------------------------------------------

--
-- Table structure for table `dropshippers`
--

CREATE TABLE `dropshippers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `business_name` varchar(150) NOT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `dropshipper_orders`
--

CREATE TABLE `dropshipper_orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `dropshipper_id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` bigint(20) UNSIGNED DEFAULT NULL,
  `source_order_id` bigint(20) UNSIGNED DEFAULT NULL,
  `supplier_id` bigint(20) UNSIGNED DEFAULT NULL,
  `status` varchar(30) NOT NULL DEFAULT 'pending',
  `sales_total` decimal(12,2) NOT NULL DEFAULT 0.00,
  `total_cost` decimal(12,2) NOT NULL DEFAULT 0.00,
  `profit` decimal(12,2) NOT NULL DEFAULT 0.00,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `dropshipper_order_items`
--

CREATE TABLE `dropshipper_order_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `dropshipper_order_id` bigint(20) UNSIGNED NOT NULL,
  `supplier_product_id` bigint(20) UNSIGNED DEFAULT NULL,
  `product_name` varchar(255) NOT NULL,
  `quantity` int(10) UNSIGNED NOT NULL,
  `unit_cost` decimal(12,2) NOT NULL,
  `unit_price` decimal(12,2) NOT NULL,
  `line_total` decimal(12,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `dropshipper_products`
--

CREATE TABLE `dropshipper_products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `dropshipper_id` bigint(20) UNSIGNED NOT NULL,
  `supplier_product_id` bigint(20) UNSIGNED NOT NULL,
  `markup_price` decimal(12,2) NOT NULL DEFAULT 0.00,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `dropshipping_fulfillments`
--

CREATE TABLE `dropshipping_fulfillments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `dropshipping_order_id` bigint(20) UNSIGNED NOT NULL,
  `status` enum('pending','packed','shipped') DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `dropshipping_orders`
--

CREATE TABLE `dropshipping_orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `vendor_id` bigint(20) UNSIGNED NOT NULL,
  `supplier_id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED DEFAULT NULL,
  `status` enum('pending','processing','shipped','delivered','cancelled') DEFAULT 'pending',
  `total_cost` decimal(12,2) DEFAULT 0.00,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `dropshipping_order_items`
--

CREATE TABLE `dropshipping_order_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `dropshipping_order_id` bigint(20) UNSIGNED NOT NULL,
  `supplier_product_id` bigint(20) UNSIGNED NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `unit_cost` decimal(12,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `dropshipping_products`
--

CREATE TABLE `dropshipping_products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `vendor_id` bigint(20) UNSIGNED NOT NULL,
  `supplier_product_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED DEFAULT NULL,
  `markup_price` decimal(12,2) DEFAULT 0.00,
  `is_active` tinyint(1) DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `dropshipping_settings`
--

CREATE TABLE `dropshipping_settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `vendor_id` bigint(20) UNSIGNED NOT NULL,
  `auto_sync` tinyint(1) DEFAULT 1,
  `markup_percentage` decimal(5,2) DEFAULT 20.00,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `dropshipping_shipments`
--

CREATE TABLE `dropshipping_shipments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `dropshipping_order_id` bigint(20) UNSIGNED NOT NULL,
  `tracking_number` varchar(100) DEFAULT NULL,
  `courier_name` varchar(100) DEFAULT NULL,
  `shipped_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `email_otps`
--

CREATE TABLE `email_otps` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `email` varchar(255) NOT NULL,
  `code_hash` varchar(255) NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL DEFAULT 0,
  `expires_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `last_sent_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `email_otps`
--

INSERT INTO `email_otps` (`id`, `email`, `code_hash`, `attempts`, `expires_at`, `last_sent_at`, `created_at`, `updated_at`) VALUES
(7, 'abdullahfahim.evaly@gmail.com', '$2y$12$kdyoY6b1L12hLC271zmLc.8Z0vdK4QBwe/Lx1rkIYTfE8t856C78u', 0, '2026-11-05 12:07:34', '2026-11-05 12:02:34', '2026-11-05 12:02:34', '2026-11-05 12:02:34');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `inventory`
--

CREATE TABLE `inventory` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `variant_id` bigint(20) UNSIGNED DEFAULT NULL,
  `warehouse_id` bigint(20) UNSIGNED DEFAULT NULL,
  `quantity` int(11) DEFAULT 0,
  `reserved_quantity` int(11) DEFAULT 0,
  `reorder_level` int(11) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `inventory`
--

INSERT INTO `inventory` (`id`, `product_id`, `variant_id`, `warehouse_id`, `quantity`, `reserved_quantity`, `reorder_level`, `created_at`, `updated_at`) VALUES
(1, 170, NULL, NULL, 50, 0, 5, '2026-11-02 12:14:37', '2026-11-02 12:14:37'),
(2, 171, NULL, NULL, 50, 0, 5, '2026-11-02 12:14:37', '2026-11-02 12:14:37'),
(3, 172, NULL, NULL, 50, 0, 5, '2026-11-02 12:14:37', '2026-11-02 12:14:37'),
(4, 173, NULL, NULL, 50, 0, 5, '2026-11-02 12:14:37', '2026-11-02 12:14:37'),
(5, 174, NULL, NULL, 50, 0, 5, '2026-11-02 12:14:37', '2026-11-02 12:14:37'),
(6, 175, NULL, NULL, 50, 0, 5, '2026-11-02 12:14:37', '2026-11-02 12:14:37'),
(7, 176, NULL, NULL, 50, 0, 5, '2026-11-02 12:14:37', '2026-11-02 12:14:37'),
(8, 177, NULL, NULL, 50, 0, 5, '2026-11-02 12:14:37', '2026-11-02 12:14:37'),
(9, 178, NULL, NULL, 50, 0, 5, '2026-11-02 12:14:37', '2026-11-02 12:14:37'),
(10, 179, NULL, NULL, 50, 0, 5, '2026-11-02 12:14:37', '2026-11-02 12:14:37'),
(11, 180, NULL, NULL, 50, 0, 5, '2026-11-02 12:14:37', '2026-11-02 12:14:37'),
(12, 181, NULL, NULL, 50, 0, 5, '2026-11-02 12:14:37', '2026-11-02 12:14:37'),
(13, 182, NULL, NULL, 50, 0, 5, '2026-11-02 12:14:37', '2026-11-02 12:14:37'),
(14, 183, NULL, NULL, 50, 0, 5, '2026-11-02 12:14:37', '2026-11-02 12:14:37'),
(15, 184, NULL, NULL, 50, 0, 5, '2026-11-02 12:14:37', '2026-11-02 12:14:37'),
(16, 185, NULL, NULL, 50, 0, 5, '2026-11-02 12:14:37', '2026-11-02 12:14:37'),
(17, 201, NULL, NULL, 50, 0, 5, '2026-11-02 12:14:37', '2026-11-02 12:14:37'),
(18, 202, NULL, NULL, 50, 0, 5, '2026-11-02 12:14:37', '2026-11-02 12:14:37'),
(19, 203, NULL, NULL, 50, 0, 5, '2026-11-02 12:14:37', '2026-11-02 12:14:37'),
(20, 204, NULL, NULL, 50, 0, 5, '2026-11-02 12:14:37', '2026-11-02 12:14:37'),
(21, 205, NULL, NULL, 50, 0, 5, '2026-11-02 12:14:37', '2026-11-02 12:14:37'),
(22, 206, NULL, NULL, 50, 0, 5, '2026-11-02 12:14:37', '2026-11-02 12:14:37'),
(23, 207, NULL, NULL, 50, 0, 5, '2026-11-02 12:14:37', '2026-11-02 12:14:37'),
(24, 208, NULL, NULL, 50, 0, 5, '2026-11-02 12:14:37', '2026-11-02 12:14:37'),
(25, 209, NULL, NULL, 50, 0, 5, '2026-11-02 12:14:37', '2026-11-02 12:14:37'),
(26, 210, NULL, NULL, 50, 0, 5, '2026-11-02 12:14:37', '2026-11-02 12:14:37'),
(27, 211, NULL, NULL, 50, 0, 5, '2026-11-02 12:14:37', '2026-11-02 12:14:37'),
(28, 212, NULL, NULL, 50, 0, 5, '2026-11-02 12:14:37', '2026-11-02 12:14:37'),
(29, 219, NULL, NULL, 50, 0, 5, '2026-11-02 12:14:37', '2026-11-02 12:14:37'),
(30, 220, NULL, NULL, 50, 0, 5, '2026-11-02 12:14:37', '2026-11-02 12:14:37'),
(31, 221, NULL, NULL, 50, 0, 5, '2026-11-02 12:14:37', '2026-11-02 12:14:37'),
(32, 222, NULL, NULL, 50, 0, 5, '2026-11-02 12:14:37', '2026-11-02 12:14:37'),
(33, 223, NULL, NULL, 50, 0, 5, '2026-11-02 12:14:37', '2026-11-02 12:14:37'),
(34, 224, NULL, NULL, 50, 0, 5, '2026-11-02 12:14:37', '2026-11-02 12:14:37'),
(35, 226, NULL, NULL, 50, 0, 5, '2026-11-02 12:14:37', '2026-11-02 12:14:37'),
(36, 227, NULL, NULL, 50, 0, 5, '2026-11-02 12:14:37', '2026-11-02 12:14:37'),
(37, 228, NULL, NULL, 50, 0, 5, '2026-11-02 12:14:37', '2026-11-02 12:14:37'),
(38, 229, NULL, NULL, 50, 0, 5, '2026-11-02 12:14:37', '2026-11-02 12:14:37'),
(39, 230, NULL, NULL, 50, 0, 5, '2026-11-02 12:14:37', '2026-11-02 12:14:37'),
(40, 231, NULL, NULL, 50, 0, 5, '2026-11-02 12:14:37', '2026-11-02 12:14:37'),
(41, 232, NULL, NULL, 50, 0, 5, '2026-11-02 12:14:37', '2026-11-02 12:14:37'),
(42, 233, NULL, NULL, 50, 0, 5, '2026-11-02 12:14:37', '2026-11-02 12:14:37'),
(43, 234, NULL, NULL, 50, 0, 5, '2026-11-02 12:14:37', '2026-11-02 12:14:37'),
(44, 235, NULL, NULL, 50, 0, 5, '2026-11-02 12:14:37', '2026-11-02 12:14:37'),
(45, 236, NULL, NULL, 50, 0, 5, '2026-11-02 12:14:37', '2026-11-02 12:14:37'),
(46, 237, NULL, NULL, 50, 0, 5, '2026-11-02 12:14:37', '2026-11-02 12:14:37'),
(47, 238, NULL, NULL, 50, 0, 5, '2026-11-02 12:14:37', '2026-11-02 12:14:37'),
(48, 241, NULL, NULL, 50, 0, 5, '2026-11-02 12:14:37', '2026-11-02 12:14:37'),
(49, 242, NULL, NULL, 50, 0, 5, '2026-11-02 12:14:37', '2026-11-02 12:14:37'),
(50, 243, NULL, NULL, 50, 0, 5, '2026-11-02 12:14:37', '2026-11-02 12:14:37'),
(51, 244, NULL, NULL, 50, 0, 5, '2026-11-02 12:14:37', '2026-11-02 12:14:37'),
(52, 245, NULL, NULL, 50, 0, 5, '2026-11-02 12:14:37', '2026-11-02 12:14:37'),
(53, 246, NULL, NULL, 50, 0, 5, '2026-11-02 12:14:37', '2026-11-02 12:14:37'),
(54, 247, NULL, NULL, 50, 0, 5, '2026-11-02 12:14:37', '2026-11-02 12:14:37'),
(55, 248, NULL, NULL, 50, 0, 5, '2026-11-02 12:14:37', '2026-11-02 12:14:37'),
(56, 249, NULL, NULL, 50, 0, 5, '2026-11-02 12:14:37', '2026-11-02 12:14:37'),
(57, 250, NULL, NULL, 50, 0, 5, '2026-11-02 12:14:37', '2026-11-02 12:14:37'),
(58, 251, NULL, NULL, 50, 0, 5, '2026-11-02 12:14:37', '2026-11-02 12:14:37'),
(59, 252, NULL, NULL, 50, 0, 5, '2026-11-02 12:14:37', '2026-11-02 12:14:37'),
(60, 253, NULL, NULL, 50, 0, 5, '2026-11-02 12:14:37', '2026-11-02 12:14:37'),
(61, 254, NULL, NULL, 50, 0, 5, '2026-11-02 12:14:37', '2026-11-02 12:14:37'),
(62, 255, NULL, NULL, 50, 0, 5, '2026-11-02 12:14:37', '2026-11-02 12:14:37'),
(63, 256, NULL, NULL, 50, 0, 5, '2026-11-02 12:14:37', '2026-11-02 12:14:37'),
(64, 257, NULL, NULL, 50, 0, 5, '2026-11-02 12:14:37', '2026-11-02 12:14:37'),
(65, 258, NULL, NULL, 50, 0, 5, '2026-11-02 12:14:37', '2026-11-02 12:14:37'),
(66, 259, NULL, NULL, 50, 0, 5, '2026-11-02 12:14:37', '2026-11-02 12:14:37'),
(67, 260, NULL, NULL, 50, 0, 5, '2026-11-02 12:14:37', '2026-11-02 12:14:37'),
(68, 85, NULL, NULL, 50, 0, 5, '2026-11-02 12:14:37', '2026-11-02 12:14:37'),
(69, 86, NULL, NULL, 50, 0, 5, '2026-11-02 12:14:37', '2026-11-02 12:14:37'),
(70, 87, NULL, NULL, 50, 0, 5, '2026-11-02 12:14:37', '2026-11-02 12:14:37'),
(71, 88, NULL, NULL, 50, 0, 5, '2026-11-02 12:14:37', '2026-11-02 12:14:37'),
(72, 89, NULL, NULL, 50, 0, 5, '2026-11-02 12:14:37', '2026-11-02 12:14:37'),
(73, 90, NULL, NULL, 50, 0, 5, '2026-11-02 12:14:37', '2026-11-02 12:14:37'),
(74, 92, NULL, NULL, 50, 0, 5, '2026-11-02 12:14:37', '2026-11-02 12:14:37'),
(75, 93, NULL, NULL, 50, 0, 5, '2026-11-02 12:14:37', '2026-11-02 12:14:37'),
(76, 94, NULL, NULL, 50, 0, 5, '2026-11-02 12:14:37', '2026-11-02 12:14:37'),
(77, 95, NULL, NULL, 50, 0, 5, '2026-11-02 12:14:37', '2026-11-02 12:14:37'),
(78, 96, NULL, NULL, 50, 0, 5, '2026-11-02 12:14:37', '2026-11-02 12:14:37'),
(79, 97, NULL, NULL, 50, 0, 5, '2026-11-02 12:14:37', '2026-11-02 12:14:37'),
(80, 98, NULL, NULL, 50, 0, 5, '2026-11-02 12:14:37', '2026-11-02 12:14:37'),
(81, 99, NULL, NULL, 50, 0, 5, '2026-11-02 12:14:37', '2026-11-02 12:14:37'),
(82, 100, NULL, NULL, 50, 0, 5, '2026-11-02 12:14:37', '2026-11-02 12:14:37'),
(83, 101, NULL, NULL, 50, 0, 5, '2026-11-02 12:14:37', '2026-11-02 12:14:37'),
(84, 102, NULL, NULL, 50, 0, 5, '2026-11-02 12:14:37', '2026-11-02 12:14:37'),
(85, 103, NULL, NULL, 50, 0, 5, '2026-11-02 12:14:37', '2026-11-02 12:14:37'),
(86, 104, NULL, NULL, 50, 0, 5, '2026-11-02 12:14:37', '2026-11-02 12:14:37'),
(87, 105, NULL, NULL, 50, 0, 5, '2026-11-02 12:14:37', '2026-11-02 12:14:37'),
(88, 106, NULL, NULL, 50, 0, 5, '2026-11-02 12:14:37', '2026-11-02 12:14:37'),
(89, 107, NULL, NULL, 50, 0, 5, '2026-11-02 12:14:37', '2026-11-02 12:14:37'),
(90, 108, NULL, NULL, 50, 0, 5, '2026-11-02 12:14:37', '2026-11-02 12:14:37'),
(91, 109, NULL, NULL, 50, 0, 5, '2026-11-02 12:14:37', '2026-11-02 12:14:37'),
(92, 110, NULL, NULL, 50, 0, 5, '2026-11-02 12:14:37', '2026-11-02 12:14:37'),
(93, 111, NULL, NULL, 50, 0, 5, '2026-11-02 12:14:37', '2026-11-02 12:14:37'),
(94, 112, NULL, NULL, 50, 0, 5, '2026-11-02 12:14:37', '2026-11-02 12:14:37'),
(95, 113, NULL, NULL, 50, 0, 5, '2026-11-02 12:14:37', '2026-11-02 12:14:37'),
(96, 114, NULL, NULL, 50, 0, 5, '2026-11-02 12:14:37', '2026-11-02 12:14:37'),
(97, 115, NULL, NULL, 50, 0, 5, '2026-11-02 12:14:37', '2026-11-02 12:14:37'),
(98, 116, NULL, NULL, 50, 0, 5, '2026-11-02 12:14:37', '2026-11-02 12:14:37'),
(99, 117, NULL, NULL, 50, 0, 5, '2026-11-02 12:14:37', '2026-11-02 12:14:37'),
(100, 118, NULL, NULL, 50, 0, 5, '2026-11-02 12:14:37', '2026-11-02 12:14:37'),
(101, 119, NULL, NULL, 50, 0, 5, '2026-11-02 12:14:37', '2026-11-02 12:14:37'),
(102, 120, NULL, NULL, 50, 0, 5, '2026-11-02 12:14:37', '2026-11-02 12:14:37'),
(103, 121, NULL, NULL, 50, 0, 5, '2026-11-02 12:14:37', '2026-11-02 12:14:37'),
(104, 122, NULL, NULL, 50, 0, 5, '2026-11-02 12:14:37', '2026-11-02 12:14:37'),
(105, 123, NULL, NULL, 50, 0, 5, '2026-11-02 12:14:37', '2026-11-02 12:14:37'),
(106, 124, NULL, NULL, 50, 0, 5, '2026-11-02 12:14:37', '2026-11-02 12:14:37'),
(107, 125, NULL, NULL, 50, 0, 5, '2026-11-02 12:14:37', '2026-11-02 12:14:37'),
(108, 126, NULL, NULL, 50, 0, 5, '2026-11-02 12:14:37', '2026-11-02 12:14:37'),
(109, 127, NULL, NULL, 50, 0, 5, '2026-11-02 12:14:37', '2026-11-02 12:14:37'),
(110, 128, NULL, NULL, 50, 0, 5, '2026-11-02 12:14:37', '2026-11-02 12:14:37'),
(111, 129, NULL, NULL, 50, 0, 5, '2026-11-02 12:14:37', '2026-11-02 12:14:37'),
(112, 130, NULL, NULL, 50, 0, 5, '2026-11-02 12:14:37', '2026-11-02 12:14:37'),
(113, 131, NULL, NULL, 50, 0, 5, '2026-11-02 12:14:37', '2026-11-02 12:14:37'),
(114, 132, NULL, NULL, 50, 0, 5, '2026-11-02 12:14:37', '2026-11-02 12:14:37'),
(115, 133, NULL, NULL, 50, 0, 5, '2026-11-02 12:14:37', '2026-11-02 12:14:37'),
(116, 134, NULL, NULL, 50, 0, 5, '2026-11-02 12:14:37', '2026-11-02 12:14:37'),
(117, 135, NULL, NULL, 50, 0, 5, '2026-11-02 12:14:37', '2026-11-02 12:14:37'),
(118, 136, NULL, NULL, 50, 0, 5, '2026-11-02 12:14:37', '2026-11-02 12:14:37'),
(119, 137, NULL, NULL, 50, 0, 5, '2026-11-02 12:14:37', '2026-11-02 12:14:37'),
(120, 138, NULL, NULL, 50, 0, 5, '2026-11-02 12:14:37', '2026-11-02 12:14:37'),
(121, 139, NULL, NULL, 50, 0, 5, '2026-11-02 12:14:37', '2026-11-02 12:14:37'),
(122, 140, NULL, NULL, 50, 0, 5, '2026-11-02 12:14:37', '2026-11-02 12:14:37'),
(123, 141, NULL, NULL, 50, 0, 5, '2026-11-02 12:14:37', '2026-11-02 12:14:37'),
(124, 142, NULL, NULL, 50, 0, 5, '2026-11-02 12:14:37', '2026-11-02 12:14:37'),
(125, 143, NULL, NULL, 50, 0, 5, '2026-11-02 12:14:37', '2026-11-02 12:14:37'),
(126, 144, NULL, NULL, 50, 0, 5, '2026-11-02 12:14:37', '2026-11-02 12:14:37'),
(127, 33, NULL, NULL, 50, 0, 5, '2026-11-02 12:14:37', '2026-11-02 12:14:37'),
(128, 34, NULL, NULL, 50, 0, 5, '2026-11-02 12:14:37', '2026-11-02 12:14:37'),
(129, 35, NULL, NULL, 50, 0, 5, '2026-11-02 12:14:37', '2026-11-02 12:14:37'),
(130, 36, NULL, NULL, 50, 0, 5, '2026-11-02 12:14:37', '2026-11-02 12:14:37'),
(131, 37, NULL, NULL, 50, 0, 5, '2026-11-02 12:14:37', '2026-11-02 12:14:37'),
(132, 38, NULL, NULL, 50, 0, 5, '2026-11-02 12:14:37', '2026-11-02 12:14:37'),
(133, 39, NULL, NULL, 50, 0, 5, '2026-11-02 12:14:37', '2026-11-02 12:14:37'),
(134, 40, NULL, NULL, 50, 0, 5, '2026-11-02 12:14:37', '2026-11-02 12:14:37'),
(135, 41, NULL, NULL, 50, 0, 5, '2026-11-02 12:14:37', '2026-11-02 12:14:37'),
(136, 42, NULL, NULL, 50, 0, 5, '2026-11-02 12:14:37', '2026-11-02 12:14:37'),
(137, 43, NULL, NULL, 50, 0, 5, '2026-11-02 12:14:37', '2026-11-02 12:14:37'),
(138, 45, NULL, NULL, 50, 0, 5, '2026-11-02 12:14:37', '2026-11-02 12:14:37'),
(139, 52, NULL, NULL, 50, 0, 5, '2026-11-02 12:14:37', '2026-11-02 12:14:37'),
(140, 155, NULL, NULL, 50, 0, 5, '2026-11-02 12:14:37', '2026-11-02 12:14:37'),
(141, 156, NULL, NULL, 50, 0, 5, '2026-11-02 12:14:37', '2026-11-02 12:14:37'),
(142, 157, NULL, NULL, 50, 0, 5, '2026-11-02 12:14:37', '2026-11-02 12:14:37'),
(143, 158, NULL, NULL, 50, 0, 5, '2026-11-02 12:14:37', '2026-11-02 12:14:37'),
(144, 159, NULL, NULL, 50, 0, 5, '2026-11-02 12:14:37', '2026-11-02 12:14:37'),
(145, 160, NULL, NULL, 50, 0, 5, '2026-11-02 12:14:37', '2026-11-02 12:14:37'),
(146, 161, NULL, NULL, 50, 0, 5, '2026-11-02 12:14:37', '2026-11-02 12:14:37'),
(147, 162, NULL, NULL, 50, 0, 5, '2026-11-02 12:14:37', '2026-11-02 12:14:37'),
(148, 163, NULL, NULL, 50, 0, 5, '2026-11-02 12:14:37', '2026-11-02 12:14:37');

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2026_09_12_035804_add_two_factor_columns_to_users_table', 1),
(5, '2026_09_12_035805_create_passkeys_table', 1),
(6, '2026_09_12_035849_create_personal_access_tokens_table', 1),
(7, '2026_09_14_173546_create_permission_tables', 2),
(8, '2026_11_10_000000_create_rfqs_and_quotes_tables', 3),
(9, '2026_11_10_010000_create_payment_deposit_details_table', 4),
(10, '2026_11_10_020000_add_payment_method_code_to_payments_table', 4),
(11, '2026_11_10_030000_add_self_transport_details_to_shipments_table', 5),
(12, '2026_11_10_100001_create_dropshippers_table', 6),
(13, '2026_11_10_100002_create_wholesalers_table', 6),
(14, '2026_11_10_100003_create_dropshipper_owned_catalog_tables', 7),
(15, '2026_11_10_100004_connect_dropshipper_orders_to_customers', 8);

-- --------------------------------------------------------

--
-- Table structure for table `minimum_order_quantities`
--

CREATE TABLE `minimum_order_quantities` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `wholesale_product_id` bigint(20) UNSIGNED NOT NULL,
  `moq` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(1, 'App\\Models\\User', 1),
(2, 'App\\Models\\User', 3),
(3, 'App\\Models\\User', 4),
(4, 'App\\Models\\User', 5),
(5, 'App\\Models\\User', 6),
(6, 'App\\Models\\User', 2),
(7, 'App\\Models\\User', 13);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_number` varchar(50) NOT NULL,
  `customer_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(150) DEFAULT NULL,
  `phone` varchar(20) NOT NULL,
  `email` varchar(150) DEFAULT NULL,
  `subtotal` decimal(12,2) NOT NULL DEFAULT 0.00,
  `discount` decimal(12,2) DEFAULT 0.00,
  `shipping_cost` decimal(12,2) DEFAULT 0.00,
  `tax` decimal(12,2) DEFAULT 0.00,
  `total` decimal(12,2) NOT NULL DEFAULT 0.00,
  `status` enum('pending','processing','shipped','delivered','completed','cancelled','returned') NOT NULL DEFAULT 'pending',
  `payment_status` enum('unpaid','paid','partially_refunded','refunded') DEFAULT 'unpaid',
  `coupon_id` bigint(20) UNSIGNED DEFAULT NULL,
  `shipping_address_id` bigint(20) UNSIGNED DEFAULT NULL,
  `shipping_zone_id` bigint(20) UNSIGNED DEFAULT NULL,
  `affiliate_id` bigint(20) UNSIGNED DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `source` varchar(30) NOT NULL DEFAULT 'website',
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `extra_charge` decimal(12,2) NOT NULL DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `order_number`, `customer_id`, `name`, `phone`, `email`, `subtotal`, `discount`, `shipping_cost`, `tax`, `total`, `status`, `payment_status`, `coupon_id`, `shipping_address_id`, `shipping_zone_id`, `affiliate_id`, `notes`, `created_at`, `updated_at`, `deleted_at`, `source`, `created_by`, `extra_charge`) VALUES
(4, 'ORD-260926-XBDXM', NULL, 'jessica 97', '01690068136', 'sellymore678@gmail.com', 73200.00, 0.00, 70.00, 0.00, 73270.00, 'pending', 'unpaid', NULL, 4, 3, NULL, NULL, '2026-09-26 12:32:41', '2026-09-26 12:32:41', NULL, 'website', NULL, 0.00),
(5, 'ORD-261024-CIYIW', NULL, 'CZIT Web', '01690068136', 'anik.czit@gmail.com', 4100.00, 0.00, 170.00, 0.00, 4270.00, 'cancelled', 'unpaid', NULL, 5, 4, NULL, NULL, '2026-10-23 23:22:10', '2026-11-03 03:13:15', NULL, 'website', NULL, 0.00),
(6, 'ORD-261102-R1JGR', 3, 'Johnkru6', '01690068136', 'johnkru6@gmail.com', 102500.00, 0.00, 170.00, 0.00, 102670.00, 'pending', 'unpaid', NULL, 6, 4, NULL, NULL, '2026-11-01 23:58:09', '2026-11-01 23:58:09', NULL, 'website', NULL, 0.00),
(7, 'ORD-261109-7WJWD', 6, 'Fahim Rahman', '01625557147', 'abdullahfahim.evaly@gmail.com', 449900.00, 0.00, 170.00, 0.00, 450070.00, 'pending', 'unpaid', NULL, 7, 4, NULL, NULL, '2026-11-09 17:43:23', '2026-11-09 17:43:23', NULL, 'website', NULL, 0.00),
(8, 'ORD-261110-ULUUC', 4, 'Bhmyers745', '01690068136', 'bhmyers745@gmail.com', 105000.00, 0.00, 170.00, 0.00, 105170.00, 'pending', 'unpaid', NULL, 8, 4, NULL, NULL, '2026-11-10 03:36:35', '2026-11-10 03:36:35', NULL, 'website', NULL, 0.00);

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `product_variant_id` bigint(20) UNSIGNED DEFAULT NULL,
  `variant_id` bigint(20) UNSIGNED DEFAULT NULL,
  `vendor_id` bigint(20) UNSIGNED DEFAULT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `unit_price` decimal(12,2) NOT NULL,
  `total_price` decimal(12,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `product_variant_id`, `variant_id`, `vendor_id`, `quantity`, `unit_price`, `total_price`, `created_at`, `updated_at`) VALUES
(5, 4, 50, NULL, NULL, NULL, 2, 4100.00, 8200.00, '2026-09-26 12:32:41', '2026-09-26 12:32:41'),
(6, 4, 46, NULL, NULL, 1, 1, 65000.00, 65000.00, '2026-09-26 12:32:41', '2026-09-26 12:32:41'),
(7, 5, 50, NULL, NULL, NULL, 1, 4100.00, 4100.00, '2026-10-23 23:22:10', '2026-10-23 23:22:10'),
(8, 6, 45, NULL, NULL, 1, 1, 35000.00, 35000.00, '2026-11-01 23:58:09', '2026-11-01 23:58:09'),
(9, 6, 84, NULL, NULL, 1, 2, 33750.00, 67500.00, '2026-11-01 23:58:09', '2026-11-01 23:58:09'),
(10, 7, 185, NULL, NULL, NULL, 1, 449900.00, 449900.00, '2026-11-09 17:43:23', '2026-11-09 17:43:23'),
(11, 8, 45, NULL, NULL, 1, 3, 35000.00, 105000.00, '2026-11-10 03:36:35', '2026-11-10 03:36:35');

-- --------------------------------------------------------

--
-- Table structure for table `order_notes`
--

CREATE TABLE `order_notes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `note` text NOT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_notes`
--

INSERT INTO `order_notes` (`id`, `order_id`, `note`, `created_by`, `created_at`, `updated_at`) VALUES
(1, 5, 'Status changed from pending to cancelled.', 1, '2026-11-03 03:13:15', '2026-11-03 03:13:15');

-- --------------------------------------------------------

--
-- Table structure for table `order_statuses`
--

CREATE TABLE `order_statuses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `slug` varchar(100) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `passkeys`
--

CREATE TABLE `passkeys` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `credential_id` varchar(255) NOT NULL,
  `credential` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`credential`)),
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `payment_method_id` bigint(20) UNSIGNED DEFAULT NULL,
  `payment_method_code` varchar(40) DEFAULT NULL,
  `amount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `transaction_ref` varchar(255) DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'pending',
  `paid_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`id`, `order_id`, `payment_method_id`, `payment_method_code`, `amount`, `transaction_ref`, `status`, `paid_at`, `created_at`, `updated_at`) VALUES
(1, 4, NULL, NULL, 73270.00, NULL, 'pending', NULL, '2026-09-26 12:32:41', '2026-09-26 12:32:41'),
(2, 5, NULL, NULL, 4270.00, NULL, 'pending', NULL, '2026-10-23 23:22:10', '2026-10-23 23:22:10'),
(3, 6, NULL, NULL, 102670.00, NULL, 'pending', NULL, '2026-11-01 23:58:09', '2026-11-01 23:58:09'),
(4, 7, NULL, NULL, 450070.00, NULL, 'pending', NULL, '2026-11-09 17:43:23', '2026-11-09 17:43:23'),
(5, 8, NULL, 'bank_deposit', 105170.00, NULL, 'pending', NULL, '2026-11-10 03:36:35', '2026-11-10 03:36:35');

-- --------------------------------------------------------

--
-- Table structure for table `payment_deposit_details`
--

CREATE TABLE `payment_deposit_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `payment_id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `deposit_date` date NOT NULL,
  `depositor_bank` varchar(150) NOT NULL,
  `depositor_branch` varchar(150) NOT NULL,
  `deposit_type` varchar(30) NOT NULL,
  `amount` decimal(12,2) NOT NULL,
  `company_account` varchar(190) NOT NULL,
  `bank_name` varchar(150) NOT NULL,
  `company_name` varchar(150) NOT NULL,
  `receipt_id` varchar(190) DEFAULT NULL,
  `receipt_path` varchar(255) NOT NULL,
  `remark` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `payment_deposit_details`
--

INSERT INTO `payment_deposit_details` (`id`, `payment_id`, `order_id`, `deposit_date`, `depositor_bank`, `depositor_branch`, `deposit_type`, `amount`, `company_account`, `bank_name`, `company_name`, `receipt_id`, `receipt_path`, `remark`, `created_at`, `updated_at`) VALUES
(1, 5, 8, '2026-11-03', 'Islam Bank', 'Motijheel', 'bank_transfer', 25000.00, 'ddddsaddsfs', 'dssfdsafdsfd', 'Namar', 'dsddfdfs', 'payment-deposits/mJp6oxE3HHAwoThuGLWEWhULK3h9ar15EFzXhxIu.png', 'ddddd', '2026-11-10 03:36:35', '2026-11-10 03:36:35');

-- --------------------------------------------------------

--
-- Table structure for table `payment_methods`
--

CREATE TABLE `payment_methods` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `group_name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`, `group_name`) VALUES
(1, 'superadmin.activity-logs.create', 'web', '2026-11-02 21:54:16', '2026-11-02 21:54:16', 'activity-logs'),
(2, 'superadmin.activity-logs.destroy', 'web', '2026-11-02 21:54:16', '2026-11-02 21:54:16', 'activity-logs'),
(3, 'superadmin.activity-logs.edit', 'web', '2026-11-02 21:54:16', '2026-11-02 21:54:16', 'activity-logs'),
(4, 'superadmin.activity-logs.index', 'web', '2026-11-02 21:54:16', '2026-11-02 21:54:16', 'activity-logs'),
(5, 'superadmin.activity-logs.show', 'web', '2026-11-02 21:54:16', '2026-11-02 21:54:16', 'activity-logs'),
(6, 'superadmin.affiliate.clicks.index', 'web', '2026-11-02 21:54:16', '2026-11-02 21:54:16', 'affiliate.clicks'),
(7, 'superadmin.affiliate.links.index', 'web', '2026-11-02 21:54:16', '2026-11-02 21:54:16', 'affiliate.links'),
(8, 'superadmin.affiliate.links.toggle', 'web', '2026-11-02 21:54:16', '2026-11-02 21:54:16', 'affiliate.links'),
(9, 'superadmin.affiliate.sales.index', 'web', '2026-11-02 21:54:16', '2026-11-02 21:54:16', 'affiliate.sales'),
(10, 'superadmin.affiliate.sales.status', 'web', '2026-11-02 21:54:16', '2026-11-02 21:54:16', 'affiliate.sales'),
(11, 'superadmin.affiliates.approve', 'web', '2026-11-02 21:54:16', '2026-11-02 21:54:16', 'affiliates'),
(12, 'superadmin.affiliates.create', 'web', '2026-11-02 21:54:16', '2026-11-02 21:54:16', 'affiliates'),
(13, 'superadmin.affiliates.destroy', 'web', '2026-11-02 21:54:16', '2026-11-02 21:54:16', 'affiliates'),
(14, 'superadmin.affiliates.edit', 'web', '2026-11-02 21:54:16', '2026-11-02 21:54:16', 'affiliates'),
(15, 'superadmin.affiliates.index', 'web', '2026-11-02 21:54:16', '2026-11-02 21:54:16', 'affiliates'),
(16, 'superadmin.affiliates.show', 'web', '2026-11-02 21:54:16', '2026-11-02 21:54:16', 'affiliates'),
(17, 'superadmin.affiliates.suspend', 'web', '2026-11-02 21:54:16', '2026-11-02 21:54:16', 'affiliates'),
(18, 'superadmin.attributes.create', 'web', '2026-11-02 21:54:16', '2026-11-02 21:54:16', 'attributes'),
(19, 'superadmin.attributes.destroy', 'web', '2026-11-02 21:54:16', '2026-11-02 21:54:16', 'attributes'),
(20, 'superadmin.attributes.edit', 'web', '2026-11-02 21:54:16', '2026-11-02 21:54:16', 'attributes'),
(21, 'superadmin.attributes.index', 'web', '2026-11-02 21:54:16', '2026-11-02 21:54:16', 'attributes'),
(22, 'superadmin.attributes.show', 'web', '2026-11-02 21:54:16', '2026-11-02 21:54:16', 'attributes'),
(23, 'superadmin.attributes.values.destroy', 'web', '2026-11-02 21:54:16', '2026-11-02 21:54:16', 'attributes.values'),
(24, 'superadmin.attributes.values.store', 'web', '2026-11-02 21:54:16', '2026-11-02 21:54:16', 'attributes.values'),
(25, 'superadmin.banners.create', 'web', '2026-11-02 21:54:16', '2026-11-02 21:54:16', 'banners'),
(26, 'superadmin.banners.destroy', 'web', '2026-11-02 21:54:16', '2026-11-02 21:54:16', 'banners'),
(27, 'superadmin.banners.edit', 'web', '2026-11-02 21:54:16', '2026-11-02 21:54:16', 'banners'),
(28, 'superadmin.banners.index', 'web', '2026-11-02 21:54:16', '2026-11-02 21:54:16', 'banners'),
(29, 'superadmin.brands.create', 'web', '2026-11-02 21:54:16', '2026-11-02 21:54:16', 'brands'),
(30, 'superadmin.brands.destroy', 'web', '2026-11-02 21:54:16', '2026-11-02 21:54:16', 'brands'),
(31, 'superadmin.brands.edit', 'web', '2026-11-02 21:54:16', '2026-11-02 21:54:16', 'brands'),
(32, 'superadmin.brands.index', 'web', '2026-11-02 21:54:16', '2026-11-02 21:54:16', 'brands'),
(33, 'superadmin.brands.show', 'web', '2026-11-02 21:54:16', '2026-11-02 21:54:16', 'brands'),
(34, 'superadmin.campaigns.create', 'web', '2026-11-02 21:54:16', '2026-11-02 21:54:16', 'campaigns'),
(35, 'superadmin.campaigns.destroy', 'web', '2026-11-02 21:54:16', '2026-11-02 21:54:16', 'campaigns'),
(36, 'superadmin.campaigns.edit', 'web', '2026-11-02 21:54:16', '2026-11-02 21:54:16', 'campaigns'),
(37, 'superadmin.campaigns.index', 'web', '2026-11-02 21:54:16', '2026-11-02 21:54:16', 'campaigns'),
(38, 'superadmin.campaigns.show', 'web', '2026-11-02 21:54:16', '2026-11-02 21:54:16', 'campaigns'),
(39, 'superadmin.categories.create', 'web', '2026-11-02 21:54:16', '2026-11-02 21:54:16', 'categories'),
(40, 'superadmin.categories.destroy', 'web', '2026-11-02 21:54:16', '2026-11-02 21:54:16', 'categories'),
(41, 'superadmin.categories.edit', 'web', '2026-11-02 21:54:16', '2026-11-02 21:54:16', 'categories'),
(42, 'superadmin.categories.index', 'web', '2026-11-02 21:54:16', '2026-11-02 21:54:16', 'categories'),
(43, 'superadmin.categories.show', 'web', '2026-11-02 21:54:16', '2026-11-02 21:54:16', 'categories'),
(44, 'superadmin.categories.subcategories', 'web', '2026-11-02 21:54:16', '2026-11-02 21:54:16', 'categories'),
(45, 'superadmin.commission-rules.destroy', 'web', '2026-11-02 21:54:16', '2026-11-02 21:54:16', 'commission-rules'),
(46, 'superadmin.commission-rules.index', 'web', '2026-11-02 21:54:16', '2026-11-02 21:54:16', 'commission-rules'),
(47, 'superadmin.commission-rules.store', 'web', '2026-11-02 21:54:16', '2026-11-02 21:54:16', 'commission-rules'),
(48, 'superadmin.commission-rules.update', 'web', '2026-11-02 21:54:16', '2026-11-02 21:54:16', 'commission-rules'),
(49, 'superadmin.commissions.index', 'web', '2026-11-02 21:54:16', '2026-11-02 21:54:16', 'commissions'),
(50, 'superadmin.commissions.show', 'web', '2026-11-02 21:54:16', '2026-11-02 21:54:16', 'commissions'),
(51, 'superadmin.commissions.status', 'web', '2026-11-02 21:54:16', '2026-11-02 21:54:16', 'commissions'),
(52, 'superadmin.coupons.create', 'web', '2026-11-02 21:54:16', '2026-11-02 21:54:16', 'coupons'),
(53, 'superadmin.coupons.destroy', 'web', '2026-11-02 21:54:16', '2026-11-02 21:54:16', 'coupons'),
(54, 'superadmin.coupons.edit', 'web', '2026-11-02 21:54:16', '2026-11-02 21:54:16', 'coupons'),
(55, 'superadmin.coupons.index', 'web', '2026-11-02 21:54:16', '2026-11-02 21:54:16', 'coupons'),
(56, 'superadmin.coupons.show', 'web', '2026-11-02 21:54:16', '2026-11-02 21:54:16', 'coupons'),
(57, 'superadmin.couriers.create', 'web', '2026-11-02 21:54:16', '2026-11-02 21:54:16', 'couriers'),
(58, 'superadmin.couriers.destroy', 'web', '2026-11-02 21:54:16', '2026-11-02 21:54:16', 'couriers'),
(59, 'superadmin.couriers.edit', 'web', '2026-11-02 21:54:16', '2026-11-02 21:54:16', 'couriers'),
(60, 'superadmin.couriers.index', 'web', '2026-11-02 21:54:16', '2026-11-02 21:54:16', 'couriers'),
(61, 'superadmin.couriers.show', 'web', '2026-11-02 21:54:16', '2026-11-02 21:54:16', 'couriers'),
(62, 'superadmin.deliveries', 'web', '2026-11-02 21:54:16', '2026-11-02 21:54:16', 'deliveries'),
(63, 'superadmin.delivery-rates.create', 'web', '2026-11-02 21:54:16', '2026-11-02 21:54:16', 'delivery-rates'),
(64, 'superadmin.delivery-rates.destroy', 'web', '2026-11-02 21:54:16', '2026-11-02 21:54:16', 'delivery-rates'),
(65, 'superadmin.delivery-rates.edit', 'web', '2026-11-02 21:54:16', '2026-11-02 21:54:16', 'delivery-rates'),
(66, 'superadmin.delivery-rates.index', 'web', '2026-11-02 21:54:16', '2026-11-02 21:54:16', 'delivery-rates'),
(67, 'superadmin.delivery-rates.show', 'web', '2026-11-02 21:54:16', '2026-11-02 21:54:16', 'delivery-rates'),
(68, 'superadmin.disputes.create', 'web', '2026-11-02 21:54:16', '2026-11-02 21:54:16', 'disputes'),
(69, 'superadmin.disputes.destroy', 'web', '2026-11-02 21:54:16', '2026-11-02 21:54:16', 'disputes'),
(70, 'superadmin.disputes.edit', 'web', '2026-11-02 21:54:16', '2026-11-02 21:54:16', 'disputes'),
(71, 'superadmin.disputes.index', 'web', '2026-11-02 21:54:16', '2026-11-02 21:54:16', 'disputes'),
(72, 'superadmin.disputes.show', 'web', '2026-11-02 21:54:16', '2026-11-02 21:54:16', 'disputes'),
(73, 'superadmin.dropshipping.imports.index', 'web', '2026-11-02 21:54:16', '2026-11-02 21:54:16', 'dropshipping.imports'),
(74, 'superadmin.dropshipping.orders.index', 'web', '2026-11-02 21:54:16', '2026-11-02 21:54:16', 'dropshipping.orders'),
(75, 'superadmin.dropshipping.orders.show', 'web', '2026-11-02 21:54:16', '2026-11-02 21:54:16', 'dropshipping.orders'),
(76, 'superadmin.dropshipping.products.index', 'web', '2026-11-02 21:54:16', '2026-11-02 21:54:16', 'dropshipping.products'),
(77, 'superadmin.dropshipping.products.toggle', 'web', '2026-11-02 21:54:16', '2026-11-02 21:54:16', 'dropshipping.products'),
(78, 'superadmin.dropshipping.profit.index', 'web', '2026-11-02 21:54:16', '2026-11-02 21:54:16', 'dropshipping.profit'),
(79, 'superadmin.dropshipping.settings.index', 'web', '2026-11-02 21:54:16', '2026-11-02 21:54:16', 'dropshipping.settings'),
(80, 'superadmin.dropshipping.settings.update', 'web', '2026-11-02 21:54:16', '2026-11-02 21:54:16', 'dropshipping.settings'),
(81, 'superadmin.dropshipping.suppliers.index', 'web', '2026-11-02 21:54:16', '2026-11-02 21:54:16', 'dropshipping.suppliers'),
(82, 'superadmin.dropshippings.index', 'web', '2026-11-02 21:54:16', '2026-11-02 21:54:16', 'dropshippings'),
(83, 'superadmin.flash-sales.create', 'web', '2026-11-02 21:54:16', '2026-11-02 21:54:16', 'flash-sales'),
(84, 'superadmin.flash-sales.destroy', 'web', '2026-11-02 21:54:16', '2026-11-02 21:54:16', 'flash-sales'),
(85, 'superadmin.flash-sales.edit', 'web', '2026-11-02 21:54:16', '2026-11-02 21:54:16', 'flash-sales'),
(86, 'superadmin.flash-sales.index', 'web', '2026-11-02 21:54:16', '2026-11-02 21:54:16', 'flash-sales'),
(87, 'superadmin.flash-sales.show', 'web', '2026-11-02 21:54:16', '2026-11-02 21:54:16', 'flash-sales'),
(88, 'superadmin.frauds', 'web', '2026-11-02 21:54:16', '2026-11-02 21:54:16', 'frauds'),
(89, 'superadmin.notifications.create', 'web', '2026-11-02 21:54:16', '2026-11-02 21:54:16', 'notifications'),
(90, 'superadmin.notifications.destroy', 'web', '2026-11-02 21:54:16', '2026-11-02 21:54:16', 'notifications'),
(91, 'superadmin.notifications.edit', 'web', '2026-11-02 21:54:16', '2026-11-02 21:54:16', 'notifications'),
(92, 'superadmin.notifications.index', 'web', '2026-11-02 21:54:16', '2026-11-02 21:54:16', 'notifications'),
(93, 'superadmin.notifications.show', 'web', '2026-11-02 21:54:16', '2026-11-02 21:54:16', 'notifications'),
(97, 'superadmin.orders.index', 'web', '2026-11-02 21:54:16', '2026-11-02 21:54:16', 'orders'),
(98, 'superadmin.orders.show', 'web', '2026-11-02 21:54:16', '2026-11-02 21:54:16', 'orders'),
(99, 'superadmin.payments.create', 'web', '2026-11-02 21:54:16', '2026-11-02 21:54:16', 'payments'),
(100, 'superadmin.payments.destroy', 'web', '2026-11-02 21:54:16', '2026-11-02 21:54:16', 'payments'),
(101, 'superadmin.payments.edit', 'web', '2026-11-02 21:54:16', '2026-11-02 21:54:16', 'payments'),
(102, 'superadmin.payments.index', 'web', '2026-11-02 21:54:16', '2026-11-02 21:54:16', 'payments'),
(103, 'superadmin.payments.show', 'web', '2026-11-02 21:54:16', '2026-11-02 21:54:16', 'payments'),
(104, 'superadmin.products.approve', 'web', '2026-11-02 21:54:16', '2026-11-02 21:54:16', 'products'),
(105, 'superadmin.products.create', 'web', '2026-11-02 21:54:16', '2026-11-02 21:54:16', 'products'),
(106, 'superadmin.products.destroy', 'web', '2026-11-02 21:54:16', '2026-11-02 21:54:16', 'products'),
(107, 'superadmin.products.edit', 'web', '2026-11-02 21:54:16', '2026-11-02 21:54:16', 'products'),
(108, 'superadmin.products.index', 'web', '2026-11-02 21:54:16', '2026-11-02 21:54:16', 'products'),
(109, 'superadmin.products.show', 'web', '2026-11-02 21:54:16', '2026-11-02 21:54:16', 'products'),
(110, 'superadmin.refunds.create', 'web', '2026-11-02 21:54:16', '2026-11-02 21:54:16', 'refunds'),
(111, 'superadmin.refunds.destroy', 'web', '2026-11-02 21:54:16', '2026-11-02 21:54:16', 'refunds'),
(112, 'superadmin.refunds.edit', 'web', '2026-11-02 21:54:16', '2026-11-02 21:54:16', 'refunds'),
(113, 'superadmin.refunds.index', 'web', '2026-11-02 21:54:16', '2026-11-02 21:54:16', 'refunds'),
(114, 'superadmin.refunds.show', 'web', '2026-11-02 21:54:16', '2026-11-02 21:54:16', 'refunds'),
(115, 'superadmin.reports', 'web', '2026-11-02 21:54:16', '2026-11-02 21:54:16', 'reports'),
(116, 'superadmin.reseller.earnings.index', 'web', '2026-11-02 21:54:16', '2026-11-02 21:54:16', 'reseller.earnings'),
(117, 'superadmin.reseller.pricing.index', 'web', '2026-11-02 21:54:16', '2026-11-02 21:54:16', 'reseller.pricing'),
(118, 'superadmin.reseller.pricing.update', 'web', '2026-11-02 21:54:16', '2026-11-02 21:54:16', 'reseller.pricing'),
(119, 'superadmin.reseller.products.index', 'web', '2026-11-02 21:54:16', '2026-11-02 21:54:16', 'reseller.products'),
(120, 'superadmin.reseller.products.toggle', 'web', '2026-11-02 21:54:16', '2026-11-02 21:54:16', 'reseller.products'),
(121, 'superadmin.resellers.approve', 'web', '2026-11-02 21:54:16', '2026-11-02 21:54:16', 'resellers'),
(122, 'superadmin.resellers.create', 'web', '2026-11-02 21:54:16', '2026-11-02 21:54:16', 'resellers'),
(123, 'superadmin.resellers.destroy', 'web', '2026-11-02 21:54:16', '2026-11-02 21:54:16', 'resellers'),
(124, 'superadmin.resellers.edit', 'web', '2026-11-02 21:54:16', '2026-11-02 21:54:16', 'resellers'),
(125, 'superadmin.resellers.index', 'web', '2026-11-02 21:54:16', '2026-11-02 21:54:16', 'resellers'),
(126, 'superadmin.resellers.show', 'web', '2026-11-02 21:54:16', '2026-11-02 21:54:16', 'resellers'),
(127, 'superadmin.resellers.suspend', 'web', '2026-11-02 21:54:16', '2026-11-02 21:54:16', 'resellers'),
(128, 'superadmin.returns', 'web', '2026-11-02 21:54:16', '2026-11-02 21:54:16', 'returns'),
(129, 'superadmin.reviews.create', 'web', '2026-11-02 21:54:16', '2026-11-02 21:54:16', 'reviews'),
(130, 'superadmin.reviews.destroy', 'web', '2026-11-02 21:54:16', '2026-11-02 21:54:16', 'reviews'),
(131, 'superadmin.reviews.edit', 'web', '2026-11-02 21:54:16', '2026-11-02 21:54:16', 'reviews'),
(132, 'superadmin.reviews.index', 'web', '2026-11-02 21:54:16', '2026-11-02 21:54:16', 'reviews'),
(133, 'superadmin.reviews.show', 'web', '2026-11-02 21:54:16', '2026-11-02 21:54:16', 'reviews'),
(134, 'superadmin.roles.create', 'web', '2026-11-02 21:54:16', '2026-11-02 21:54:16', 'roles'),
(135, 'superadmin.roles.destroy', 'web', '2026-11-02 21:54:16', '2026-11-02 21:54:16', 'roles'),
(136, 'superadmin.roles.edit', 'web', '2026-11-02 21:54:16', '2026-11-02 21:54:16', 'roles'),
(137, 'superadmin.roles.index', 'web', '2026-11-02 21:54:16', '2026-11-02 21:54:16', 'roles'),
(138, 'superadmin.settings.commission', 'web', '2026-11-02 21:54:16', '2026-11-02 21:54:16', 'settings'),
(139, 'superadmin.settings.commission.update', 'web', '2026-11-02 21:54:16', '2026-11-02 21:54:16', 'settings.commission'),
(140, 'superadmin.settings.edit', 'web', '2026-11-02 21:54:16', '2026-11-02 21:54:16', 'settings'),
(141, 'superadmin.settings.payment', 'web', '2026-11-02 21:54:16', '2026-11-02 21:54:16', 'settings'),
(142, 'superadmin.settings.payment.update', 'web', '2026-11-02 21:54:16', '2026-11-02 21:54:16', 'settings.payment'),
(143, 'superadmin.settings.shipping', 'web', '2026-11-02 21:54:16', '2026-11-02 21:54:16', 'settings'),
(144, 'superadmin.settings.shipping.update', 'web', '2026-11-02 21:54:16', '2026-11-02 21:54:16', 'settings.shipping'),
(145, 'superadmin.settings.website', 'web', '2026-11-02 21:54:16', '2026-11-02 21:54:16', 'settings'),
(146, 'superadmin.settings.website.update', 'web', '2026-11-02 21:54:16', '2026-11-02 21:54:16', 'settings.website'),
(147, 'superadmin.shipment-tracking.index', 'web', '2026-11-02 21:54:16', '2026-11-02 21:54:16', 'shipment-tracking'),
(148, 'superadmin.shipment-tracking.show', 'web', '2026-11-02 21:54:16', '2026-11-02 21:54:16', 'shipment-tracking'),
(149, 'superadmin.shipping-zones.create', 'web', '2026-11-02 21:54:16', '2026-11-02 21:54:16', 'shipping-zones'),
(150, 'superadmin.shipping-zones.destroy', 'web', '2026-11-02 21:54:16', '2026-11-02 21:54:16', 'shipping-zones'),
(151, 'superadmin.shipping-zones.edit', 'web', '2026-11-02 21:54:16', '2026-11-02 21:54:16', 'shipping-zones'),
(152, 'superadmin.shipping-zones.index', 'web', '2026-11-02 21:54:16', '2026-11-02 21:54:16', 'shipping-zones'),
(153, 'superadmin.shipping-zones.show', 'web', '2026-11-02 21:54:16', '2026-11-02 21:54:16', 'shipping-zones'),
(154, 'superadmin.sliders.create', 'web', '2026-11-02 21:54:16', '2026-11-02 21:54:16', 'sliders'),
(155, 'superadmin.sliders.destroy', 'web', '2026-11-02 21:54:16', '2026-11-02 21:54:16', 'sliders'),
(156, 'superadmin.sliders.edit', 'web', '2026-11-02 21:54:16', '2026-11-02 21:54:16', 'sliders'),
(157, 'superadmin.sliders.index', 'web', '2026-11-02 21:54:16', '2026-11-02 21:54:16', 'sliders'),
(158, 'superadmin.suppliers.approve', 'web', '2026-11-02 21:54:16', '2026-11-02 21:54:16', 'suppliers'),
(159, 'superadmin.suppliers.create', 'web', '2026-11-02 21:54:16', '2026-11-02 21:54:16', 'suppliers'),
(160, 'superadmin.suppliers.destroy', 'web', '2026-11-02 21:54:16', '2026-11-02 21:54:16', 'suppliers'),
(161, 'superadmin.suppliers.edit', 'web', '2026-11-02 21:54:16', '2026-11-02 21:54:16', 'suppliers'),
(162, 'superadmin.suppliers.index', 'web', '2026-11-02 21:54:16', '2026-11-02 21:54:16', 'suppliers'),
(163, 'superadmin.suppliers.show', 'web', '2026-11-02 21:54:16', '2026-11-02 21:54:16', 'suppliers'),
(164, 'superadmin.suppliers.suspend', 'web', '2026-11-02 21:54:16', '2026-11-02 21:54:16', 'suppliers'),
(165, 'superadmin.supports', 'web', '2026-11-02 21:54:16', '2026-11-02 21:54:16', 'supports'),
(166, 'superadmin.users.create', 'web', '2026-11-02 21:54:16', '2026-11-02 21:54:16', 'users'),
(167, 'superadmin.users.destroy', 'web', '2026-11-02 21:54:16', '2026-11-02 21:54:16', 'users'),
(168, 'superadmin.users.edit', 'web', '2026-11-02 21:54:16', '2026-11-02 21:54:16', 'users'),
(169, 'superadmin.users.index', 'web', '2026-11-02 21:54:16', '2026-11-02 21:54:16', 'users'),
(170, 'superadmin.users.show', 'web', '2026-11-02 21:54:16', '2026-11-02 21:54:16', 'users'),
(171, 'superadmin.vendors.approve', 'web', '2026-11-02 21:54:16', '2026-11-02 21:54:16', 'vendors'),
(172, 'superadmin.vendors.create', 'web', '2026-11-02 21:54:16', '2026-11-02 21:54:16', 'vendors'),
(173, 'superadmin.vendors.destroy', 'web', '2026-11-02 21:54:16', '2026-11-02 21:54:16', 'vendors'),
(174, 'superadmin.vendors.edit', 'web', '2026-11-02 21:54:16', '2026-11-02 21:54:16', 'vendors'),
(175, 'superadmin.vendors.index', 'web', '2026-11-02 21:54:16', '2026-11-02 21:54:16', 'vendors'),
(176, 'superadmin.vendors.reject', 'web', '2026-11-02 21:54:16', '2026-11-02 21:54:16', 'vendors'),
(177, 'superadmin.vendors.show', 'web', '2026-11-02 21:54:16', '2026-11-02 21:54:16', 'vendors'),
(178, 'superadmin.vendors.suspend', 'web', '2026-11-02 21:54:16', '2026-11-02 21:54:16', 'vendors'),
(179, 'superadmin.wholesale.bulk-orders.index', 'web', '2026-11-02 21:54:16', '2026-11-02 21:54:16', 'wholesale.bulk-orders'),
(180, 'superadmin.wholesale.moq.destroy', 'web', '2026-11-02 21:54:16', '2026-11-02 21:54:16', 'wholesale.moq'),
(181, 'superadmin.wholesale.moq.index', 'web', '2026-11-02 21:54:16', '2026-11-02 21:54:16', 'wholesale.moq'),
(182, 'superadmin.wholesale.moq.store', 'web', '2026-11-02 21:54:16', '2026-11-02 21:54:16', 'wholesale.moq'),
(183, 'superadmin.wholesale.products.destroy', 'web', '2026-11-02 21:54:16', '2026-11-02 21:54:16', 'wholesale.products'),
(184, 'superadmin.wholesale.products.index', 'web', '2026-11-02 21:54:16', '2026-11-02 21:54:16', 'wholesale.products'),
(185, 'superadmin.wholesale.products.store', 'web', '2026-11-02 21:54:16', '2026-11-02 21:54:16', 'wholesale.products'),
(186, 'superadmin.wholesale.products.toggle', 'web', '2026-11-02 21:54:16', '2026-11-02 21:54:16', 'wholesale.products'),
(187, 'superadmin.wholesale.tiers.destroy', 'web', '2026-11-02 21:54:16', '2026-11-02 21:54:16', 'wholesale.tiers'),
(188, 'superadmin.wholesale.tiers.index', 'web', '2026-11-02 21:54:16', '2026-11-02 21:54:16', 'wholesale.tiers'),
(189, 'superadmin.wholesale.tiers.store', 'web', '2026-11-02 21:54:16', '2026-11-02 21:54:16', 'wholesale.tiers'),
(190, 'superadmin.wholesales.index', 'web', '2026-11-02 21:54:16', '2026-11-02 21:54:16', 'wholesales'),
(191, 'superadmin.withdrawals.create', 'web', '2026-11-02 21:54:16', '2026-11-02 21:54:16', 'withdrawals'),
(192, 'superadmin.withdrawals.destroy', 'web', '2026-11-02 21:54:16', '2026-11-02 21:54:16', 'withdrawals'),
(193, 'superadmin.withdrawals.edit', 'web', '2026-11-02 21:54:16', '2026-11-02 21:54:16', 'withdrawals'),
(194, 'superadmin.withdrawals.index', 'web', '2026-11-02 21:54:16', '2026-11-02 21:54:16', 'withdrawals'),
(195, 'superadmin.withdrawals.show', 'web', '2026-11-02 21:54:16', '2026-11-02 21:54:16', 'withdrawals'),
(196, 'superadmin.withdrawals.status', 'web', '2026-11-02 21:54:16', '2026-11-02 21:54:16', 'withdrawals'),
(197, 'superadmin.orders.notes.store', 'web', '2026-11-02 22:58:18', '2026-11-02 22:58:18', 'orders.notes'),
(198, 'superadmin.orders.payment-status', 'web', '2026-11-02 22:58:18', '2026-11-02 22:58:18', 'orders'),
(199, 'superadmin.orders.status', 'web', '2026-11-02 22:58:18', '2026-11-02 22:58:18', 'orders'),
(200, 'superadmin.customers.index', 'web', '2026-11-03 03:26:16', '2026-11-03 03:26:16', 'customers'),
(201, 'superadmin.customers.show', 'web', '2026-11-03 03:26:16', '2026-11-03 03:26:16', 'customers'),
(202, 'superadmin.orders.bulk.courier', 'web', '2026-11-03 03:26:16', '2026-11-03 03:26:16', 'orders.bulk'),
(203, 'superadmin.orders.bulk.delete', 'web', '2026-11-03 03:26:16', '2026-11-03 03:26:16', 'orders.bulk'),
(204, 'superadmin.orders.bulk.status', 'web', '2026-11-03 03:26:16', '2026-11-03 03:26:16', 'orders.bulk'),
(205, 'superadmin.orders.courier.send', 'web', '2026-11-03 03:26:16', '2026-11-03 03:26:16', 'orders.courier'),
(206, 'superadmin.orders.courier.sync', 'web', '2026-11-03 03:26:16', '2026-11-03 03:26:16', 'orders.courier'),
(207, 'superadmin.orders.destroy', 'web', '2026-11-03 03:26:16', '2026-11-03 03:26:16', 'orders'),
(208, 'admin.affiliates.affiliates.create', 'web', '2026-11-10 04:14:01', '2026-11-10 04:14:01', 'affiliates.affiliates'),
(209, 'admin.affiliates.affiliates.destroy', 'web', '2026-11-10 04:14:01', '2026-11-10 04:14:01', 'affiliates.affiliates'),
(210, 'admin.affiliates.affiliates.edit', 'web', '2026-11-10 04:14:01', '2026-11-10 04:14:01', 'affiliates.affiliates'),
(211, 'admin.affiliates.affiliates.index', 'web', '2026-11-10 04:14:01', '2026-11-10 04:14:01', 'affiliates.affiliates'),
(212, 'admin.affiliates.affiliates.show', 'web', '2026-11-10 04:14:01', '2026-11-10 04:14:01', 'affiliates.affiliates'),
(213, 'admin.affiliates.campaigns.create', 'web', '2026-11-10 04:14:01', '2026-11-10 04:14:01', 'affiliates.campaigns'),
(214, 'admin.affiliates.campaigns.destroy', 'web', '2026-11-10 04:14:01', '2026-11-10 04:14:01', 'affiliates.campaigns'),
(215, 'admin.affiliates.campaigns.edit', 'web', '2026-11-10 04:14:01', '2026-11-10 04:14:01', 'affiliates.campaigns'),
(216, 'admin.affiliates.campaigns.index', 'web', '2026-11-10 04:14:01', '2026-11-10 04:14:01', 'affiliates.campaigns'),
(217, 'admin.affiliates.campaigns.show', 'web', '2026-11-10 04:14:01', '2026-11-10 04:14:01', 'affiliates.campaigns'),
(218, 'admin.affiliates.clicks', 'web', '2026-11-10 04:14:01', '2026-11-10 04:14:01', 'affiliates'),
(219, 'admin.affiliates.commissions.create', 'web', '2026-11-10 04:14:01', '2026-11-10 04:14:01', 'affiliates.commissions'),
(220, 'admin.affiliates.commissions.destroy', 'web', '2026-11-10 04:14:01', '2026-11-10 04:14:01', 'affiliates.commissions'),
(221, 'admin.affiliates.commissions.edit', 'web', '2026-11-10 04:14:01', '2026-11-10 04:14:01', 'affiliates.commissions'),
(222, 'admin.affiliates.commissions.index', 'web', '2026-11-10 04:14:01', '2026-11-10 04:14:01', 'affiliates.commissions'),
(223, 'admin.affiliates.commissions.show', 'web', '2026-11-10 04:14:01', '2026-11-10 04:14:01', 'affiliates.commissions'),
(224, 'admin.affiliates.links', 'web', '2026-11-10 04:14:01', '2026-11-10 04:14:01', 'affiliates'),
(225, 'admin.affiliates.sales', 'web', '2026-11-10 04:14:01', '2026-11-10 04:14:01', 'affiliates'),
(226, 'admin.affiliates.withdrawals.create', 'web', '2026-11-10 04:14:01', '2026-11-10 04:14:01', 'affiliates.withdrawals'),
(227, 'admin.affiliates.withdrawals.destroy', 'web', '2026-11-10 04:14:01', '2026-11-10 04:14:01', 'affiliates.withdrawals'),
(228, 'admin.affiliates.withdrawals.edit', 'web', '2026-11-10 04:14:01', '2026-11-10 04:14:01', 'affiliates.withdrawals'),
(229, 'admin.affiliates.withdrawals.index', 'web', '2026-11-10 04:14:01', '2026-11-10 04:14:01', 'affiliates.withdrawals'),
(230, 'admin.affiliates.withdrawals.show', 'web', '2026-11-10 04:14:01', '2026-11-10 04:14:01', 'affiliates.withdrawals'),
(231, 'admin.customers.address.create', 'web', '2026-11-10 04:14:01', '2026-11-10 04:14:01', 'customers.address'),
(232, 'admin.customers.address.destroy', 'web', '2026-11-10 04:14:01', '2026-11-10 04:14:01', 'customers.address'),
(233, 'admin.customers.address.edit', 'web', '2026-11-10 04:14:01', '2026-11-10 04:14:01', 'customers.address'),
(234, 'admin.customers.address.index', 'web', '2026-11-10 04:14:01', '2026-11-10 04:14:01', 'customers.address'),
(235, 'admin.customers.address.show', 'web', '2026-11-10 04:14:01', '2026-11-10 04:14:01', 'customers.address'),
(236, 'admin.customers.customer-orders', 'web', '2026-11-10 04:14:01', '2026-11-10 04:14:01', 'customers'),
(237, 'admin.customers.customer-wallets', 'web', '2026-11-10 04:14:01', '2026-11-10 04:14:01', 'customers'),
(238, 'admin.customers.customers.create', 'web', '2026-11-10 04:14:01', '2026-11-10 04:14:01', 'customers.customers'),
(239, 'admin.customers.customers.destroy', 'web', '2026-11-10 04:14:01', '2026-11-10 04:14:01', 'customers.customers'),
(240, 'admin.customers.customers.edit', 'web', '2026-11-10 04:14:01', '2026-11-10 04:14:01', 'customers.customers'),
(241, 'admin.customers.customers.index', 'web', '2026-11-10 04:14:01', '2026-11-10 04:14:01', 'customers.customers'),
(242, 'admin.customers.customers.show', 'web', '2026-11-10 04:14:01', '2026-11-10 04:14:01', 'customers.customers'),
(243, 'admin.delivery.couriers.create', 'web', '2026-11-10 04:14:01', '2026-11-10 04:14:01', 'delivery.couriers'),
(244, 'admin.delivery.couriers.destroy', 'web', '2026-11-10 04:14:01', '2026-11-10 04:14:01', 'delivery.couriers'),
(245, 'admin.delivery.couriers.edit', 'web', '2026-11-10 04:14:01', '2026-11-10 04:14:01', 'delivery.couriers'),
(246, 'admin.delivery.couriers.index', 'web', '2026-11-10 04:14:01', '2026-11-10 04:14:01', 'delivery.couriers'),
(247, 'admin.delivery.couriers.show', 'web', '2026-11-10 04:14:01', '2026-11-10 04:14:01', 'delivery.couriers'),
(248, 'admin.delivery.delivery-rates', 'web', '2026-11-10 04:14:01', '2026-11-10 04:14:01', 'delivery'),
(249, 'admin.delivery.shippings', 'web', '2026-11-10 04:14:01', '2026-11-10 04:14:01', 'delivery'),
(250, 'admin.delivery.trackings', 'web', '2026-11-10 04:14:01', '2026-11-10 04:14:01', 'delivery'),
(251, 'admin.delivery.zones', 'web', '2026-11-10 04:14:01', '2026-11-10 04:14:01', 'delivery'),
(252, 'admin.dropshipping.dropshippings', 'web', '2026-11-10 04:14:01', '2026-11-10 04:14:01', 'dropshipping'),
(253, 'admin.dropshipping.fulfillments', 'web', '2026-11-10 04:14:01', '2026-11-10 04:14:01', 'dropshipping'),
(254, 'admin.dropshipping.orders.create', 'web', '2026-11-10 04:14:01', '2026-11-10 04:14:01', 'dropshipping.orders'),
(255, 'admin.dropshipping.orders.destroy', 'web', '2026-11-10 04:14:01', '2026-11-10 04:14:01', 'dropshipping.orders'),
(256, 'admin.dropshipping.orders.edit', 'web', '2026-11-10 04:14:01', '2026-11-10 04:14:01', 'dropshipping.orders'),
(257, 'admin.dropshipping.orders.index', 'web', '2026-11-10 04:14:01', '2026-11-10 04:14:01', 'dropshipping.orders'),
(258, 'admin.dropshipping.orders.show', 'web', '2026-11-10 04:14:01', '2026-11-10 04:14:01', 'dropshipping.orders'),
(259, 'admin.dropshipping.product-imports.create', 'web', '2026-11-10 04:14:01', '2026-11-10 04:14:01', 'dropshipping.product-imports'),
(260, 'admin.dropshipping.product-imports.destroy', 'web', '2026-11-10 04:14:01', '2026-11-10 04:14:01', 'dropshipping.product-imports'),
(261, 'admin.dropshipping.product-imports.edit', 'web', '2026-11-10 04:14:01', '2026-11-10 04:14:01', 'dropshipping.product-imports'),
(262, 'admin.dropshipping.product-imports.index', 'web', '2026-11-10 04:14:01', '2026-11-10 04:14:01', 'dropshipping.product-imports'),
(263, 'admin.dropshipping.product-imports.show', 'web', '2026-11-10 04:14:01', '2026-11-10 04:14:01', 'dropshipping.product-imports'),
(264, 'admin.dropshipping.product-syncs.create', 'web', '2026-11-10 04:14:01', '2026-11-10 04:14:01', 'dropshipping.product-syncs'),
(265, 'admin.dropshipping.product-syncs.destroy', 'web', '2026-11-10 04:14:01', '2026-11-10 04:14:01', 'dropshipping.product-syncs'),
(266, 'admin.dropshipping.product-syncs.edit', 'web', '2026-11-10 04:14:01', '2026-11-10 04:14:01', 'dropshipping.product-syncs'),
(267, 'admin.dropshipping.product-syncs.index', 'web', '2026-11-10 04:14:01', '2026-11-10 04:14:01', 'dropshipping.product-syncs'),
(268, 'admin.dropshipping.product-syncs.show', 'web', '2026-11-10 04:14:01', '2026-11-10 04:14:01', 'dropshipping.product-syncs'),
(269, 'admin.dropshipping.products.create', 'web', '2026-11-10 04:14:01', '2026-11-10 04:14:01', 'dropshipping.products'),
(270, 'admin.dropshipping.products.destroy', 'web', '2026-11-10 04:14:02', '2026-11-10 04:14:02', 'dropshipping.products'),
(271, 'admin.dropshipping.products.edit', 'web', '2026-11-10 04:14:02', '2026-11-10 04:14:02', 'dropshipping.products'),
(272, 'admin.dropshipping.products.index', 'web', '2026-11-10 04:14:02', '2026-11-10 04:14:02', 'dropshipping.products'),
(273, 'admin.dropshipping.products.show', 'web', '2026-11-10 04:14:02', '2026-11-10 04:14:02', 'dropshipping.products'),
(274, 'admin.dropshipping.profits', 'web', '2026-11-10 04:14:02', '2026-11-10 04:14:02', 'dropshipping'),
(275, 'admin.dropshipping.suppliers.create', 'web', '2026-11-10 04:14:02', '2026-11-10 04:14:02', 'dropshipping.suppliers'),
(276, 'admin.dropshipping.suppliers.destroy', 'web', '2026-11-10 04:14:02', '2026-11-10 04:14:02', 'dropshipping.suppliers'),
(277, 'admin.dropshipping.suppliers.edit', 'web', '2026-11-10 04:14:02', '2026-11-10 04:14:02', 'dropshipping.suppliers'),
(278, 'admin.dropshipping.suppliers.index', 'web', '2026-11-10 04:14:02', '2026-11-10 04:14:02', 'dropshipping.suppliers'),
(279, 'admin.dropshipping.suppliers.show', 'web', '2026-11-10 04:14:02', '2026-11-10 04:14:02', 'dropshipping.suppliers'),
(280, 'admin.dropshipping.trackings', 'web', '2026-11-10 04:14:02', '2026-11-10 04:14:02', 'dropshipping'),
(281, 'admin.finance.affiliate-balances.create', 'web', '2026-11-10 04:14:02', '2026-11-10 04:14:02', 'finance.affiliate-balances'),
(282, 'admin.finance.affiliate-balances.destroy', 'web', '2026-11-10 04:14:02', '2026-11-10 04:14:02', 'finance.affiliate-balances'),
(283, 'admin.finance.affiliate-balances.edit', 'web', '2026-11-10 04:14:02', '2026-11-10 04:14:02', 'finance.affiliate-balances'),
(284, 'admin.finance.affiliate-balances.index', 'web', '2026-11-10 04:14:02', '2026-11-10 04:14:02', 'finance.affiliate-balances'),
(285, 'admin.finance.affiliate-balances.show', 'web', '2026-11-10 04:14:02', '2026-11-10 04:14:02', 'finance.affiliate-balances'),
(286, 'admin.finance.commissions.create', 'web', '2026-11-10 04:14:02', '2026-11-10 04:14:02', 'finance.commissions'),
(287, 'admin.finance.commissions.destroy', 'web', '2026-11-10 04:14:02', '2026-11-10 04:14:02', 'finance.commissions'),
(288, 'admin.finance.commissions.edit', 'web', '2026-11-10 04:14:02', '2026-11-10 04:14:02', 'finance.commissions'),
(289, 'admin.finance.commissions.index', 'web', '2026-11-10 04:14:02', '2026-11-10 04:14:02', 'finance.commissions'),
(290, 'admin.finance.commissions.show', 'web', '2026-11-10 04:14:02', '2026-11-10 04:14:02', 'finance.commissions'),
(291, 'admin.finance.payments.create', 'web', '2026-11-10 04:14:02', '2026-11-10 04:14:02', 'finance.payments'),
(292, 'admin.finance.payments.destroy', 'web', '2026-11-10 04:14:02', '2026-11-10 04:14:02', 'finance.payments'),
(293, 'admin.finance.payments.edit', 'web', '2026-11-10 04:14:02', '2026-11-10 04:14:02', 'finance.payments'),
(294, 'admin.finance.payments.index', 'web', '2026-11-10 04:14:02', '2026-11-10 04:14:02', 'finance.payments'),
(295, 'admin.finance.payments.show', 'web', '2026-11-10 04:14:02', '2026-11-10 04:14:02', 'finance.payments'),
(296, 'admin.finance.reseller-balances.create', 'web', '2026-11-10 04:14:02', '2026-11-10 04:14:02', 'finance.reseller-balances'),
(297, 'admin.finance.reseller-balances.destroy', 'web', '2026-11-10 04:14:02', '2026-11-10 04:14:02', 'finance.reseller-balances'),
(298, 'admin.finance.reseller-balances.edit', 'web', '2026-11-10 04:14:02', '2026-11-10 04:14:02', 'finance.reseller-balances'),
(299, 'admin.finance.reseller-balances.index', 'web', '2026-11-10 04:14:02', '2026-11-10 04:14:02', 'finance.reseller-balances'),
(300, 'admin.finance.reseller-balances.show', 'web', '2026-11-10 04:14:02', '2026-11-10 04:14:02', 'finance.reseller-balances'),
(301, 'admin.finance.supplier-balances.create', 'web', '2026-11-10 04:14:02', '2026-11-10 04:14:02', 'finance.supplier-balances'),
(302, 'admin.finance.supplier-balances.destroy', 'web', '2026-11-10 04:14:02', '2026-11-10 04:14:02', 'finance.supplier-balances'),
(303, 'admin.finance.supplier-balances.edit', 'web', '2026-11-10 04:14:02', '2026-11-10 04:14:02', 'finance.supplier-balances'),
(304, 'admin.finance.supplier-balances.index', 'web', '2026-11-10 04:14:02', '2026-11-10 04:14:02', 'finance.supplier-balances'),
(305, 'admin.finance.supplier-balances.show', 'web', '2026-11-10 04:14:02', '2026-11-10 04:14:02', 'finance.supplier-balances'),
(306, 'admin.finance.transactions.create', 'web', '2026-11-10 04:14:02', '2026-11-10 04:14:02', 'finance.transactions'),
(307, 'admin.finance.transactions.destroy', 'web', '2026-11-10 04:14:02', '2026-11-10 04:14:02', 'finance.transactions'),
(308, 'admin.finance.transactions.edit', 'web', '2026-11-10 04:14:02', '2026-11-10 04:14:02', 'finance.transactions'),
(309, 'admin.finance.transactions.index', 'web', '2026-11-10 04:14:02', '2026-11-10 04:14:02', 'finance.transactions'),
(310, 'admin.finance.transactions.show', 'web', '2026-11-10 04:14:02', '2026-11-10 04:14:02', 'finance.transactions'),
(311, 'admin.finance.vendor-balances.create', 'web', '2026-11-10 04:14:02', '2026-11-10 04:14:02', 'finance.vendor-balances'),
(312, 'admin.finance.vendor-balances.destroy', 'web', '2026-11-10 04:14:02', '2026-11-10 04:14:02', 'finance.vendor-balances'),
(313, 'admin.finance.vendor-balances.edit', 'web', '2026-11-10 04:14:02', '2026-11-10 04:14:02', 'finance.vendor-balances'),
(314, 'admin.finance.vendor-balances.index', 'web', '2026-11-10 04:14:02', '2026-11-10 04:14:02', 'finance.vendor-balances'),
(315, 'admin.finance.vendor-balances.show', 'web', '2026-11-10 04:14:02', '2026-11-10 04:14:02', 'finance.vendor-balances'),
(316, 'admin.finance.withdrawals.create', 'web', '2026-11-10 04:14:02', '2026-11-10 04:14:02', 'finance.withdrawals'),
(317, 'admin.finance.withdrawals.destroy', 'web', '2026-11-10 04:14:02', '2026-11-10 04:14:02', 'finance.withdrawals'),
(318, 'admin.finance.withdrawals.edit', 'web', '2026-11-10 04:14:02', '2026-11-10 04:14:02', 'finance.withdrawals'),
(319, 'admin.finance.withdrawals.index', 'web', '2026-11-10 04:14:02', '2026-11-10 04:14:02', 'finance.withdrawals'),
(320, 'admin.finance.withdrawals.show', 'web', '2026-11-10 04:14:02', '2026-11-10 04:14:02', 'finance.withdrawals'),
(321, 'admin.marketing.advertisements.create', 'web', '2026-11-10 04:14:02', '2026-11-10 04:14:02', 'marketing.advertisements'),
(322, 'admin.marketing.advertisements.destroy', 'web', '2026-11-10 04:14:02', '2026-11-10 04:14:02', 'marketing.advertisements'),
(323, 'admin.marketing.advertisements.edit', 'web', '2026-11-10 04:14:02', '2026-11-10 04:14:02', 'marketing.advertisements'),
(324, 'admin.marketing.advertisements.index', 'web', '2026-11-10 04:14:02', '2026-11-10 04:14:02', 'marketing.advertisements'),
(325, 'admin.marketing.advertisements.show', 'web', '2026-11-10 04:14:02', '2026-11-10 04:14:02', 'marketing.advertisements'),
(326, 'admin.marketing.banners.create', 'web', '2026-11-10 04:14:02', '2026-11-10 04:14:02', 'marketing.banners'),
(327, 'admin.marketing.banners.destroy', 'web', '2026-11-10 04:14:02', '2026-11-10 04:14:02', 'marketing.banners'),
(328, 'admin.marketing.banners.edit', 'web', '2026-11-10 04:14:02', '2026-11-10 04:14:02', 'marketing.banners'),
(329, 'admin.marketing.banners.index', 'web', '2026-11-10 04:14:02', '2026-11-10 04:14:02', 'marketing.banners'),
(330, 'admin.marketing.banners.show', 'web', '2026-11-10 04:14:02', '2026-11-10 04:14:02', 'marketing.banners'),
(331, 'admin.marketing.campaigns.create', 'web', '2026-11-10 04:14:02', '2026-11-10 04:14:02', 'marketing.campaigns'),
(332, 'admin.marketing.campaigns.destroy', 'web', '2026-11-10 04:14:02', '2026-11-10 04:14:02', 'marketing.campaigns'),
(333, 'admin.marketing.campaigns.edit', 'web', '2026-11-10 04:14:02', '2026-11-10 04:14:02', 'marketing.campaigns'),
(334, 'admin.marketing.campaigns.index', 'web', '2026-11-10 04:14:02', '2026-11-10 04:14:02', 'marketing.campaigns'),
(335, 'admin.marketing.campaigns.show', 'web', '2026-11-10 04:14:02', '2026-11-10 04:14:02', 'marketing.campaigns'),
(336, 'admin.marketing.coupons.create', 'web', '2026-11-10 04:14:02', '2026-11-10 04:14:02', 'marketing.coupons'),
(337, 'admin.marketing.coupons.destroy', 'web', '2026-11-10 04:14:02', '2026-11-10 04:14:02', 'marketing.coupons'),
(338, 'admin.marketing.coupons.edit', 'web', '2026-11-10 04:14:02', '2026-11-10 04:14:02', 'marketing.coupons'),
(339, 'admin.marketing.coupons.index', 'web', '2026-11-10 04:14:02', '2026-11-10 04:14:02', 'marketing.coupons'),
(340, 'admin.marketing.coupons.show', 'web', '2026-11-10 04:14:02', '2026-11-10 04:14:02', 'marketing.coupons'),
(341, 'admin.marketing.flash-sales.create', 'web', '2026-11-10 04:14:02', '2026-11-10 04:14:02', 'marketing.flash-sales'),
(342, 'admin.marketing.flash-sales.destroy', 'web', '2026-11-10 04:14:02', '2026-11-10 04:14:02', 'marketing.flash-sales'),
(343, 'admin.marketing.flash-sales.edit', 'web', '2026-11-10 04:14:02', '2026-11-10 04:14:02', 'marketing.flash-sales'),
(344, 'admin.marketing.flash-sales.index', 'web', '2026-11-10 04:14:02', '2026-11-10 04:14:02', 'marketing.flash-sales'),
(345, 'admin.marketing.flash-sales.show', 'web', '2026-11-10 04:14:02', '2026-11-10 04:14:02', 'marketing.flash-sales'),
(346, 'admin.marketing.promotions.create', 'web', '2026-11-10 04:14:02', '2026-11-10 04:14:02', 'marketing.promotions'),
(347, 'admin.marketing.promotions.destroy', 'web', '2026-11-10 04:14:02', '2026-11-10 04:14:02', 'marketing.promotions'),
(348, 'admin.marketing.promotions.edit', 'web', '2026-11-10 04:14:02', '2026-11-10 04:14:02', 'marketing.promotions'),
(349, 'admin.marketing.promotions.index', 'web', '2026-11-10 04:14:02', '2026-11-10 04:14:02', 'marketing.promotions'),
(350, 'admin.marketing.promotions.show', 'web', '2026-11-10 04:14:02', '2026-11-10 04:14:02', 'marketing.promotions'),
(351, 'admin.notifications.create', 'web', '2026-11-10 04:14:02', '2026-11-10 04:14:02', 'notifications'),
(352, 'admin.notifications.destroy', 'web', '2026-11-10 04:14:02', '2026-11-10 04:14:02', 'notifications'),
(353, 'admin.notifications.edit', 'web', '2026-11-10 04:14:02', '2026-11-10 04:14:02', 'notifications'),
(354, 'admin.notifications.index', 'web', '2026-11-10 04:14:02', '2026-11-10 04:14:02', 'notifications'),
(355, 'admin.notifications.show', 'web', '2026-11-10 04:14:02', '2026-11-10 04:14:02', 'notifications'),
(356, 'admin.orders.order-items.create', 'web', '2026-11-10 04:14:02', '2026-11-10 04:14:02', 'orders.order-items'),
(357, 'admin.orders.order-items.destroy', 'web', '2026-11-10 04:14:02', '2026-11-10 04:14:02', 'orders.order-items'),
(358, 'admin.orders.order-items.edit', 'web', '2026-11-10 04:14:02', '2026-11-10 04:14:02', 'orders.order-items'),
(359, 'admin.orders.order-items.index', 'web', '2026-11-10 04:14:02', '2026-11-10 04:14:02', 'orders.order-items'),
(360, 'admin.orders.order-items.show', 'web', '2026-11-10 04:14:02', '2026-11-10 04:14:02', 'orders.order-items'),
(361, 'admin.orders.orders.create', 'web', '2026-11-10 04:14:02', '2026-11-10 04:14:02', 'orders.orders'),
(362, 'admin.orders.orders.index', 'web', '2026-11-10 04:14:02', '2026-11-10 04:14:02', 'orders.orders'),
(363, 'admin.orders.orders.show', 'web', '2026-11-10 04:14:02', '2026-11-10 04:14:02', 'orders.orders'),
(364, 'admin.orders.refunds.create', 'web', '2026-11-10 04:14:02', '2026-11-10 04:14:02', 'orders.refunds'),
(365, 'admin.orders.refunds.destroy', 'web', '2026-11-10 04:14:02', '2026-11-10 04:14:02', 'orders.refunds'),
(366, 'admin.orders.refunds.edit', 'web', '2026-11-10 04:14:02', '2026-11-10 04:14:02', 'orders.refunds'),
(367, 'admin.orders.refunds.index', 'web', '2026-11-10 04:14:02', '2026-11-10 04:14:02', 'orders.refunds'),
(368, 'admin.orders.refunds.show', 'web', '2026-11-10 04:14:02', '2026-11-10 04:14:02', 'orders.refunds'),
(369, 'admin.orders.returns', 'web', '2026-11-10 04:14:02', '2026-11-10 04:14:02', 'orders'),
(370, 'admin.orders.shipments.create', 'web', '2026-11-10 04:14:02', '2026-11-10 04:14:02', 'orders.shipments'),
(371, 'admin.orders.shipments.index', 'web', '2026-11-10 04:14:02', '2026-11-10 04:14:02', 'orders.shipments'),
(372, 'admin.orders.supplier-orders.create', 'web', '2026-11-10 04:14:02', '2026-11-10 04:14:02', 'orders.supplier-orders'),
(373, 'admin.orders.supplier-orders.destroy', 'web', '2026-11-10 04:14:02', '2026-11-10 04:14:02', 'orders.supplier-orders'),
(374, 'admin.orders.supplier-orders.edit', 'web', '2026-11-10 04:14:02', '2026-11-10 04:14:02', 'orders.supplier-orders'),
(375, 'admin.orders.supplier-orders.index', 'web', '2026-11-10 04:14:02', '2026-11-10 04:14:02', 'orders.supplier-orders'),
(376, 'admin.orders.supplier-orders.show', 'web', '2026-11-10 04:14:02', '2026-11-10 04:14:02', 'orders.supplier-orders'),
(377, 'admin.orders.trackings', 'web', '2026-11-10 04:14:02', '2026-11-10 04:14:02', 'orders'),
(378, 'admin.orders.vendor-orders.create', 'web', '2026-11-10 04:14:02', '2026-11-10 04:14:02', 'orders.vendor-orders'),
(379, 'admin.orders.vendor-orders.destroy', 'web', '2026-11-10 04:14:02', '2026-11-10 04:14:02', 'orders.vendor-orders'),
(380, 'admin.orders.vendor-orders.edit', 'web', '2026-11-10 04:14:02', '2026-11-10 04:14:02', 'orders.vendor-orders'),
(381, 'admin.orders.vendor-orders.index', 'web', '2026-11-10 04:14:02', '2026-11-10 04:14:02', 'orders.vendor-orders'),
(382, 'admin.orders.vendor-orders.show', 'web', '2026-11-10 04:14:02', '2026-11-10 04:14:02', 'orders.vendor-orders'),
(383, 'admin.payment-deposits.receipt', 'web', '2026-11-10 04:14:02', '2026-11-10 04:14:02', 'payment-deposits'),
(384, 'admin.products.attributes.create', 'web', '2026-11-10 04:14:02', '2026-11-10 04:14:02', 'products.attributes'),
(385, 'admin.products.attributes.destroy', 'web', '2026-11-10 04:14:02', '2026-11-10 04:14:02', 'products.attributes'),
(386, 'admin.products.attributes.edit', 'web', '2026-11-10 04:14:02', '2026-11-10 04:14:02', 'products.attributes'),
(387, 'admin.products.attributes.index', 'web', '2026-11-10 04:14:02', '2026-11-10 04:14:02', 'products.attributes'),
(388, 'admin.products.attributes.show', 'web', '2026-11-10 04:14:02', '2026-11-10 04:14:02', 'products.attributes'),
(389, 'admin.products.brands.create', 'web', '2026-11-10 04:14:02', '2026-11-10 04:14:02', 'products.brands'),
(390, 'admin.products.brands.destroy', 'web', '2026-11-10 04:14:02', '2026-11-10 04:14:02', 'products.brands'),
(391, 'admin.products.brands.edit', 'web', '2026-11-10 04:14:02', '2026-11-10 04:14:02', 'products.brands'),
(392, 'admin.products.brands.index', 'web', '2026-11-10 04:14:02', '2026-11-10 04:14:02', 'products.brands'),
(393, 'admin.products.brands.show', 'web', '2026-11-10 04:14:02', '2026-11-10 04:14:02', 'products.brands'),
(394, 'admin.products.categories.create', 'web', '2026-11-10 04:14:02', '2026-11-10 04:14:02', 'products.categories'),
(395, 'admin.products.categories.destroy', 'web', '2026-11-10 04:14:02', '2026-11-10 04:14:02', 'products.categories'),
(396, 'admin.products.categories.edit', 'web', '2026-11-10 04:14:02', '2026-11-10 04:14:02', 'products.categories'),
(397, 'admin.products.categories.index', 'web', '2026-11-10 04:14:02', '2026-11-10 04:14:02', 'products.categories'),
(398, 'admin.products.categories.show', 'web', '2026-11-10 04:14:02', '2026-11-10 04:14:02', 'products.categories'),
(399, 'admin.products.import-exports', 'web', '2026-11-10 04:14:02', '2026-11-10 04:14:02', 'products'),
(400, 'admin.products.inventories.create', 'web', '2026-11-10 04:14:02', '2026-11-10 04:14:02', 'products.inventories'),
(401, 'admin.products.inventories.destroy', 'web', '2026-11-10 04:14:02', '2026-11-10 04:14:02', 'products.inventories'),
(402, 'admin.products.inventories.edit', 'web', '2026-11-10 04:14:02', '2026-11-10 04:14:02', 'products.inventories'),
(403, 'admin.products.inventories.index', 'web', '2026-11-10 04:14:02', '2026-11-10 04:14:02', 'products.inventories'),
(404, 'admin.products.inventories.show', 'web', '2026-11-10 04:14:02', '2026-11-10 04:14:02', 'products.inventories'),
(405, 'admin.products.products.create', 'web', '2026-11-10 04:14:02', '2026-11-10 04:14:02', 'products.products'),
(406, 'admin.products.products.destroy', 'web', '2026-11-10 04:14:02', '2026-11-10 04:14:02', 'products.products'),
(407, 'admin.products.products.edit', 'web', '2026-11-10 04:14:02', '2026-11-10 04:14:02', 'products.products'),
(408, 'admin.products.products.index', 'web', '2026-11-10 04:14:02', '2026-11-10 04:14:02', 'products.products'),
(409, 'admin.products.products.show', 'web', '2026-11-10 04:14:02', '2026-11-10 04:14:02', 'products.products'),
(410, 'admin.products.variants', 'web', '2026-11-10 04:14:02', '2026-11-10 04:14:02', 'products'),
(411, 'admin.products.warehouses.create', 'web', '2026-11-10 04:14:02', '2026-11-10 04:14:02', 'products.warehouses'),
(412, 'admin.products.warehouses.destroy', 'web', '2026-11-10 04:14:02', '2026-11-10 04:14:02', 'products.warehouses'),
(413, 'admin.products.warehouses.edit', 'web', '2026-11-10 04:14:02', '2026-11-10 04:14:02', 'products.warehouses'),
(414, 'admin.products.warehouses.index', 'web', '2026-11-10 04:14:02', '2026-11-10 04:14:02', 'products.warehouses'),
(415, 'admin.products.warehouses.show', 'web', '2026-11-10 04:14:02', '2026-11-10 04:14:02', 'products.warehouses'),
(416, 'admin.reports.affiliate-reports', 'web', '2026-11-10 04:14:02', '2026-11-10 04:14:02', 'reports'),
(417, 'admin.reports.commission-reports', 'web', '2026-11-10 04:14:02', '2026-11-10 04:14:02', 'reports'),
(418, 'admin.reports.dropshipping-reports', 'web', '2026-11-10 04:14:02', '2026-11-10 04:14:02', 'reports'),
(419, 'admin.reports.financial-reports', 'web', '2026-11-10 04:14:02', '2026-11-10 04:14:02', 'reports'),
(420, 'admin.reports.product-reports', 'web', '2026-11-10 04:14:02', '2026-11-10 04:14:02', 'reports'),
(421, 'admin.reports.report-exports', 'web', '2026-11-10 04:14:02', '2026-11-10 04:14:02', 'reports'),
(422, 'admin.reports.reseller-reports', 'web', '2026-11-10 04:14:02', '2026-11-10 04:14:02', 'reports'),
(423, 'admin.reports.sales-reports', 'web', '2026-11-10 04:14:02', '2026-11-10 04:14:02', 'reports'),
(424, 'admin.reports.supplier-reports', 'web', '2026-11-10 04:14:02', '2026-11-10 04:14:02', 'reports'),
(425, 'admin.reports.vendor-reports', 'web', '2026-11-10 04:14:02', '2026-11-10 04:14:02', 'reports'),
(426, 'admin.reports.wholesale-reports', 'web', '2026-11-10 04:14:02', '2026-11-10 04:14:02', 'reports'),
(427, 'admin.resellers.earnings', 'web', '2026-11-10 04:14:02', '2026-11-10 04:14:02', 'resellers'),
(428, 'admin.resellers.orders.create', 'web', '2026-11-10 04:14:02', '2026-11-10 04:14:02', 'resellers.orders'),
(429, 'admin.resellers.orders.destroy', 'web', '2026-11-10 04:14:02', '2026-11-10 04:14:02', 'resellers.orders'),
(430, 'admin.resellers.orders.edit', 'web', '2026-11-10 04:14:02', '2026-11-10 04:14:02', 'resellers.orders'),
(431, 'admin.resellers.orders.index', 'web', '2026-11-10 04:14:02', '2026-11-10 04:14:02', 'resellers.orders'),
(432, 'admin.resellers.orders.show', 'web', '2026-11-10 04:14:02', '2026-11-10 04:14:02', 'resellers.orders'),
(433, 'admin.resellers.pricings', 'web', '2026-11-10 04:14:02', '2026-11-10 04:14:02', 'resellers'),
(434, 'admin.resellers.products.create', 'web', '2026-11-10 04:14:02', '2026-11-10 04:14:02', 'resellers.products'),
(435, 'admin.resellers.products.destroy', 'web', '2026-11-10 04:14:02', '2026-11-10 04:14:02', 'resellers.products'),
(436, 'admin.resellers.products.edit', 'web', '2026-11-10 04:14:02', '2026-11-10 04:14:02', 'resellers.products'),
(437, 'admin.resellers.products.index', 'web', '2026-11-10 04:14:02', '2026-11-10 04:14:02', 'resellers.products'),
(438, 'admin.resellers.products.show', 'web', '2026-11-10 04:14:02', '2026-11-10 04:14:02', 'resellers.products'),
(439, 'admin.resellers.resellers.create', 'web', '2026-11-10 04:14:02', '2026-11-10 04:14:02', 'resellers.resellers'),
(440, 'admin.resellers.resellers.destroy', 'web', '2026-11-10 04:14:02', '2026-11-10 04:14:02', 'resellers.resellers'),
(441, 'admin.resellers.resellers.edit', 'web', '2026-11-10 04:14:02', '2026-11-10 04:14:02', 'resellers.resellers'),
(442, 'admin.resellers.resellers.index', 'web', '2026-11-10 04:14:02', '2026-11-10 04:14:02', 'resellers.resellers'),
(443, 'admin.resellers.resellers.show', 'web', '2026-11-10 04:14:02', '2026-11-10 04:14:02', 'resellers.resellers'),
(444, 'admin.resellers.withdrawals.create', 'web', '2026-11-10 04:14:02', '2026-11-10 04:14:02', 'resellers.withdrawals'),
(445, 'admin.resellers.withdrawals.destroy', 'web', '2026-11-10 04:14:02', '2026-11-10 04:14:02', 'resellers.withdrawals'),
(446, 'admin.resellers.withdrawals.edit', 'web', '2026-11-10 04:14:02', '2026-11-10 04:14:02', 'resellers.withdrawals'),
(447, 'admin.resellers.withdrawals.index', 'web', '2026-11-10 04:14:02', '2026-11-10 04:14:02', 'resellers.withdrawals'),
(448, 'admin.resellers.withdrawals.show', 'web', '2026-11-10 04:14:02', '2026-11-10 04:14:02', 'resellers.withdrawals'),
(449, 'admin.reviews.ratings.create', 'web', '2026-11-10 04:14:02', '2026-11-10 04:14:02', 'reviews.ratings'),
(450, 'admin.reviews.ratings.destroy', 'web', '2026-11-10 04:14:02', '2026-11-10 04:14:02', 'reviews.ratings'),
(451, 'admin.reviews.ratings.edit', 'web', '2026-11-10 04:14:02', '2026-11-10 04:14:02', 'reviews.ratings'),
(452, 'admin.reviews.ratings.index', 'web', '2026-11-10 04:14:02', '2026-11-10 04:14:02', 'reviews.ratings'),
(453, 'admin.reviews.ratings.show', 'web', '2026-11-10 04:14:02', '2026-11-10 04:14:02', 'reviews.ratings'),
(454, 'admin.reviews.report-reviews', 'web', '2026-11-10 04:14:02', '2026-11-10 04:14:02', 'reviews'),
(455, 'admin.reviews.reviews.create', 'web', '2026-11-10 04:14:02', '2026-11-10 04:14:02', 'reviews.reviews');
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`, `group_name`) VALUES
(456, 'admin.reviews.reviews.destroy', 'web', '2026-11-10 04:14:02', '2026-11-10 04:14:02', 'reviews.reviews'),
(457, 'admin.reviews.reviews.edit', 'web', '2026-11-10 04:14:02', '2026-11-10 04:14:02', 'reviews.reviews'),
(458, 'admin.reviews.reviews.index', 'web', '2026-11-10 04:14:02', '2026-11-10 04:14:02', 'reviews.reviews'),
(459, 'admin.reviews.reviews.show', 'web', '2026-11-10 04:14:02', '2026-11-10 04:14:02', 'reviews.reviews'),
(460, 'admin.rfqs.index', 'web', '2026-11-10 04:14:02', '2026-11-10 04:14:02', 'rfqs'),
(461, 'admin.rfqs.show', 'web', '2026-11-10 04:14:02', '2026-11-10 04:14:02', 'rfqs'),
(462, 'admin.store.profiles', 'web', '2026-11-10 04:14:02', '2026-11-10 04:14:02', 'store'),
(463, 'admin.store.settings.create', 'web', '2026-11-10 04:14:02', '2026-11-10 04:14:02', 'store.settings'),
(464, 'admin.store.settings.destroy', 'web', '2026-11-10 04:14:02', '2026-11-10 04:14:02', 'store.settings'),
(465, 'admin.store.settings.edit', 'web', '2026-11-10 04:14:02', '2026-11-10 04:14:02', 'store.settings'),
(466, 'admin.store.settings.index', 'web', '2026-11-10 04:14:02', '2026-11-10 04:14:02', 'store.settings'),
(467, 'admin.store.settings.show', 'web', '2026-11-10 04:14:02', '2026-11-10 04:14:02', 'store.settings'),
(468, 'admin.store.verifications', 'web', '2026-11-10 04:14:02', '2026-11-10 04:14:02', 'store'),
(469, 'admin.suppliers.balances', 'web', '2026-11-10 04:14:02', '2026-11-10 04:14:02', 'suppliers'),
(470, 'admin.suppliers.earnings', 'web', '2026-11-10 04:14:02', '2026-11-10 04:14:02', 'suppliers'),
(471, 'admin.suppliers.fulfillments', 'web', '2026-11-10 04:14:02', '2026-11-10 04:14:02', 'suppliers'),
(472, 'admin.suppliers.inventories.create', 'web', '2026-11-10 04:14:02', '2026-11-10 04:14:02', 'suppliers.inventories'),
(473, 'admin.suppliers.inventories.destroy', 'web', '2026-11-10 04:14:02', '2026-11-10 04:14:02', 'suppliers.inventories'),
(474, 'admin.suppliers.inventories.edit', 'web', '2026-11-10 04:14:02', '2026-11-10 04:14:02', 'suppliers.inventories'),
(475, 'admin.suppliers.inventories.index', 'web', '2026-11-10 04:14:02', '2026-11-10 04:14:02', 'suppliers.inventories'),
(476, 'admin.suppliers.inventories.show', 'web', '2026-11-10 04:14:02', '2026-11-10 04:14:02', 'suppliers.inventories'),
(477, 'admin.suppliers.orders.create', 'web', '2026-11-10 04:14:02', '2026-11-10 04:14:02', 'suppliers.orders'),
(478, 'admin.suppliers.orders.destroy', 'web', '2026-11-10 04:14:02', '2026-11-10 04:14:02', 'suppliers.orders'),
(479, 'admin.suppliers.orders.edit', 'web', '2026-11-10 04:14:02', '2026-11-10 04:14:02', 'suppliers.orders'),
(480, 'admin.suppliers.orders.index', 'web', '2026-11-10 04:14:02', '2026-11-10 04:14:02', 'suppliers.orders'),
(481, 'admin.suppliers.orders.show', 'web', '2026-11-10 04:14:02', '2026-11-10 04:14:02', 'suppliers.orders'),
(482, 'admin.suppliers.pricings', 'web', '2026-11-10 04:14:02', '2026-11-10 04:14:02', 'suppliers'),
(483, 'admin.suppliers.products.create', 'web', '2026-11-10 04:14:02', '2026-11-10 04:14:02', 'suppliers.products'),
(484, 'admin.suppliers.products.destroy', 'web', '2026-11-10 04:14:02', '2026-11-10 04:14:02', 'suppliers.products'),
(485, 'admin.suppliers.products.edit', 'web', '2026-11-10 04:14:02', '2026-11-10 04:14:02', 'suppliers.products'),
(486, 'admin.suppliers.products.index', 'web', '2026-11-10 04:14:02', '2026-11-10 04:14:02', 'suppliers.products'),
(487, 'admin.suppliers.products.show', 'web', '2026-11-10 04:14:02', '2026-11-10 04:14:02', 'suppliers.products'),
(488, 'admin.suppliers.profiles', 'web', '2026-11-10 04:14:02', '2026-11-10 04:14:02', 'suppliers'),
(489, 'admin.suppliers.purchase-orders', 'web', '2026-11-10 04:14:02', '2026-11-10 04:14:02', 'suppliers'),
(490, 'admin.suppliers.shipments.create', 'web', '2026-11-10 04:14:02', '2026-11-10 04:14:02', 'suppliers.shipments'),
(491, 'admin.suppliers.shipments.destroy', 'web', '2026-11-10 04:14:02', '2026-11-10 04:14:02', 'suppliers.shipments'),
(492, 'admin.suppliers.shipments.edit', 'web', '2026-11-10 04:14:02', '2026-11-10 04:14:02', 'suppliers.shipments'),
(493, 'admin.suppliers.shipments.index', 'web', '2026-11-10 04:14:02', '2026-11-10 04:14:02', 'suppliers.shipments'),
(494, 'admin.suppliers.shipments.show', 'web', '2026-11-10 04:14:02', '2026-11-10 04:14:02', 'suppliers.shipments'),
(495, 'admin.suppliers.suppliers.create', 'web', '2026-11-10 04:14:02', '2026-11-10 04:14:02', 'suppliers.suppliers'),
(496, 'admin.suppliers.suppliers.destroy', 'web', '2026-11-10 04:14:02', '2026-11-10 04:14:02', 'suppliers.suppliers'),
(497, 'admin.suppliers.suppliers.edit', 'web', '2026-11-10 04:14:03', '2026-11-10 04:14:03', 'suppliers.suppliers'),
(498, 'admin.suppliers.suppliers.index', 'web', '2026-11-10 04:14:03', '2026-11-10 04:14:03', 'suppliers.suppliers'),
(499, 'admin.suppliers.suppliers.show', 'web', '2026-11-10 04:14:03', '2026-11-10 04:14:03', 'suppliers.suppliers'),
(500, 'admin.suppliers.trackings', 'web', '2026-11-10 04:14:03', '2026-11-10 04:14:03', 'suppliers'),
(501, 'admin.suppliers.verifications', 'web', '2026-11-10 04:14:03', '2026-11-10 04:14:03', 'suppliers'),
(502, 'admin.suppliers.withdrawals.create', 'web', '2026-11-10 04:14:03', '2026-11-10 04:14:03', 'suppliers.withdrawals'),
(503, 'admin.suppliers.withdrawals.destroy', 'web', '2026-11-10 04:14:03', '2026-11-10 04:14:03', 'suppliers.withdrawals'),
(504, 'admin.suppliers.withdrawals.edit', 'web', '2026-11-10 04:14:03', '2026-11-10 04:14:03', 'suppliers.withdrawals'),
(505, 'admin.suppliers.withdrawals.index', 'web', '2026-11-10 04:14:03', '2026-11-10 04:14:03', 'suppliers.withdrawals'),
(506, 'admin.suppliers.withdrawals.show', 'web', '2026-11-10 04:14:03', '2026-11-10 04:14:03', 'suppliers.withdrawals'),
(507, 'admin.users.permissions.create', 'web', '2026-11-10 04:14:03', '2026-11-10 04:14:03', 'users.permissions'),
(508, 'admin.users.permissions.destroy', 'web', '2026-11-10 04:14:03', '2026-11-10 04:14:03', 'users.permissions'),
(509, 'admin.users.permissions.edit', 'web', '2026-11-10 04:14:03', '2026-11-10 04:14:03', 'users.permissions'),
(510, 'admin.users.permissions.index', 'web', '2026-11-10 04:14:03', '2026-11-10 04:14:03', 'users.permissions'),
(511, 'admin.users.permissions.show', 'web', '2026-11-10 04:14:03', '2026-11-10 04:14:03', 'users.permissions'),
(512, 'admin.users.roles.create', 'web', '2026-11-10 04:14:03', '2026-11-10 04:14:03', 'users.roles'),
(513, 'admin.users.roles.destroy', 'web', '2026-11-10 04:14:03', '2026-11-10 04:14:03', 'users.roles'),
(514, 'admin.users.roles.edit', 'web', '2026-11-10 04:14:03', '2026-11-10 04:14:03', 'users.roles'),
(515, 'admin.users.roles.index', 'web', '2026-11-10 04:14:03', '2026-11-10 04:14:03', 'users.roles'),
(516, 'admin.users.roles.show', 'web', '2026-11-10 04:14:03', '2026-11-10 04:14:03', 'users.roles'),
(517, 'admin.users.users.create', 'web', '2026-11-10 04:14:03', '2026-11-10 04:14:03', 'users.users'),
(518, 'admin.users.users.destroy', 'web', '2026-11-10 04:14:03', '2026-11-10 04:14:03', 'users.users'),
(519, 'admin.users.users.edit', 'web', '2026-11-10 04:14:03', '2026-11-10 04:14:03', 'users.users'),
(520, 'admin.users.users.index', 'web', '2026-11-10 04:14:03', '2026-11-10 04:14:03', 'users.users'),
(521, 'admin.users.users.show', 'web', '2026-11-10 04:14:03', '2026-11-10 04:14:03', 'users.users'),
(522, 'admin.vendors.earnings', 'web', '2026-11-10 04:14:03', '2026-11-10 04:14:03', 'vendors'),
(523, 'admin.vendors.orders.create', 'web', '2026-11-10 04:14:03', '2026-11-10 04:14:03', 'vendors.orders'),
(524, 'admin.vendors.orders.destroy', 'web', '2026-11-10 04:14:03', '2026-11-10 04:14:03', 'vendors.orders'),
(525, 'admin.vendors.orders.edit', 'web', '2026-11-10 04:14:03', '2026-11-10 04:14:03', 'vendors.orders'),
(526, 'admin.vendors.orders.index', 'web', '2026-11-10 04:14:03', '2026-11-10 04:14:03', 'vendors.orders'),
(527, 'admin.vendors.orders.show', 'web', '2026-11-10 04:14:03', '2026-11-10 04:14:03', 'vendors.orders'),
(528, 'admin.vendors.products.create', 'web', '2026-11-10 04:14:03', '2026-11-10 04:14:03', 'vendors.products'),
(529, 'admin.vendors.products.destroy', 'web', '2026-11-10 04:14:03', '2026-11-10 04:14:03', 'vendors.products'),
(530, 'admin.vendors.products.edit', 'web', '2026-11-10 04:14:03', '2026-11-10 04:14:03', 'vendors.products'),
(531, 'admin.vendors.products.index', 'web', '2026-11-10 04:14:03', '2026-11-10 04:14:03', 'vendors.products'),
(532, 'admin.vendors.products.show', 'web', '2026-11-10 04:14:03', '2026-11-10 04:14:03', 'vendors.products'),
(533, 'admin.vendors.vendors.create', 'web', '2026-11-10 04:14:03', '2026-11-10 04:14:03', 'vendors.vendors'),
(534, 'admin.vendors.vendors.destroy', 'web', '2026-11-10 04:14:03', '2026-11-10 04:14:03', 'vendors.vendors'),
(535, 'admin.vendors.vendors.edit', 'web', '2026-11-10 04:14:03', '2026-11-10 04:14:03', 'vendors.vendors'),
(536, 'admin.vendors.vendors.index', 'web', '2026-11-10 04:14:03', '2026-11-10 04:14:03', 'vendors.vendors'),
(537, 'admin.vendors.vendors.show', 'web', '2026-11-10 04:14:03', '2026-11-10 04:14:03', 'vendors.vendors'),
(538, 'admin.vendors.verifications', 'web', '2026-11-10 04:14:03', '2026-11-10 04:14:03', 'vendors'),
(539, 'admin.vendors.withdrawals.create', 'web', '2026-11-10 04:14:03', '2026-11-10 04:14:03', 'vendors.withdrawals'),
(540, 'admin.vendors.withdrawals.destroy', 'web', '2026-11-10 04:14:03', '2026-11-10 04:14:03', 'vendors.withdrawals'),
(541, 'admin.vendors.withdrawals.edit', 'web', '2026-11-10 04:14:03', '2026-11-10 04:14:03', 'vendors.withdrawals'),
(542, 'admin.vendors.withdrawals.index', 'web', '2026-11-10 04:14:03', '2026-11-10 04:14:03', 'vendors.withdrawals'),
(543, 'admin.vendors.withdrawals.show', 'web', '2026-11-10 04:14:03', '2026-11-10 04:14:03', 'vendors.withdrawals'),
(544, 'admin.wholesale.bulk-orders.create', 'web', '2026-11-10 04:14:03', '2026-11-10 04:14:03', 'wholesale.bulk-orders'),
(545, 'admin.wholesale.bulk-orders.destroy', 'web', '2026-11-10 04:14:03', '2026-11-10 04:14:03', 'wholesale.bulk-orders'),
(546, 'admin.wholesale.bulk-orders.edit', 'web', '2026-11-10 04:14:03', '2026-11-10 04:14:03', 'wholesale.bulk-orders'),
(547, 'admin.wholesale.bulk-orders.index', 'web', '2026-11-10 04:14:03', '2026-11-10 04:14:03', 'wholesale.bulk-orders'),
(548, 'admin.wholesale.bulk-orders.show', 'web', '2026-11-10 04:14:03', '2026-11-10 04:14:03', 'wholesale.bulk-orders'),
(549, 'admin.wholesale.customers.create', 'web', '2026-11-10 04:14:03', '2026-11-10 04:14:03', 'wholesale.customers'),
(550, 'admin.wholesale.customers.destroy', 'web', '2026-11-10 04:14:03', '2026-11-10 04:14:03', 'wholesale.customers'),
(551, 'admin.wholesale.customers.edit', 'web', '2026-11-10 04:14:03', '2026-11-10 04:14:03', 'wholesale.customers'),
(552, 'admin.wholesale.customers.index', 'web', '2026-11-10 04:14:03', '2026-11-10 04:14:03', 'wholesale.customers'),
(553, 'admin.wholesale.customers.show', 'web', '2026-11-10 04:14:03', '2026-11-10 04:14:03', 'wholesale.customers'),
(554, 'admin.wholesale.minimum-orders', 'web', '2026-11-10 04:14:03', '2026-11-10 04:14:03', 'wholesale'),
(555, 'admin.wholesale.pricings', 'web', '2026-11-10 04:14:03', '2026-11-10 04:14:03', 'wholesale'),
(556, 'admin.wholesale.products.create', 'web', '2026-11-10 04:14:03', '2026-11-10 04:14:03', 'wholesale.products'),
(557, 'admin.wholesale.products.destroy', 'web', '2026-11-10 04:14:03', '2026-11-10 04:14:03', 'wholesale.products'),
(558, 'admin.wholesale.products.edit', 'web', '2026-11-10 04:14:03', '2026-11-10 04:14:03', 'wholesale.products'),
(559, 'admin.wholesale.products.index', 'web', '2026-11-10 04:14:03', '2026-11-10 04:14:03', 'wholesale.products'),
(560, 'admin.wholesale.products.show', 'web', '2026-11-10 04:14:03', '2026-11-10 04:14:03', 'wholesale.products'),
(561, 'admin.wholesale.wholesales', 'web', '2026-11-10 04:14:03', '2026-11-10 04:14:03', 'wholesale'),
(562, 'superadmin.delivery-transport.create', 'web', '2026-11-10 04:14:03', '2026-11-10 04:14:03', 'delivery-transport'),
(563, 'superadmin.delivery-transport.index', 'web', '2026-11-10 04:14:03', '2026-11-10 04:14:03', 'delivery-transport'),
(564, 'superadmin.manual-orders.create', 'web', '2026-11-10 04:14:03', '2026-11-10 04:14:03', 'manual-orders'),
(565, 'superadmin.manual-orders.index', 'web', '2026-11-10 04:14:03', '2026-11-10 04:14:03', 'manual-orders'),
(566, 'superadmin.manual-orders.show', 'web', '2026-11-10 04:14:03', '2026-11-10 04:14:03', 'manual-orders'),
(567, 'superadmin.notifications.read-all', 'web', '2026-11-10 04:14:03', '2026-11-10 04:14:03', 'notifications'),
(568, 'superadmin.notifications.update', 'web', '2026-11-10 04:14:03', '2026-11-10 04:14:03', 'notifications'),
(569, 'superadmin.orders.invoice', 'web', '2026-11-10 04:14:03', '2026-11-10 04:14:03', 'orders'),
(570, 'superadmin.payment-deposits.receipt', 'web', '2026-11-10 04:14:03', '2026-11-10 04:14:03', 'payment-deposits'),
(571, 'superadmin.products.reject', 'web', '2026-11-10 04:14:03', '2026-11-10 04:14:03', 'products'),
(572, 'superadmin.rfqs.index', 'web', '2026-11-10 04:14:03', '2026-11-10 04:14:03', 'rfqs'),
(573, 'superadmin.rfqs.show', 'web', '2026-11-10 04:14:03', '2026-11-10 04:14:03', 'rfqs'),
(574, 'superadmin.warranties.create', 'web', '2026-11-10 04:14:03', '2026-11-10 04:14:03', 'warranties'),
(575, 'superadmin.warranties.destroy', 'web', '2026-11-10 04:14:03', '2026-11-10 04:14:03', 'warranties'),
(576, 'superadmin.warranties.edit', 'web', '2026-11-10 04:14:03', '2026-11-10 04:14:03', 'warranties'),
(577, 'superadmin.warranties.index', 'web', '2026-11-10 04:14:03', '2026-11-10 04:14:03', 'warranties');

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` text NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `vendor_id` bigint(20) UNSIGNED DEFAULT NULL,
  `category_id` bigint(20) UNSIGNED DEFAULT NULL,
  `sub_category_id` bigint(20) UNSIGNED DEFAULT NULL,
  `brand_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(191) NOT NULL,
  `slug` varchar(191) NOT NULL,
  `sku` varchar(100) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `short_description` varchar(500) DEFAULT NULL,
  `price` decimal(12,2) NOT NULL DEFAULT 0.00,
  `discount_price` decimal(12,2) DEFAULT NULL,
  `cost_price` decimal(12,2) DEFAULT NULL,
  `tags` varchar(255) DEFAULT NULL,
  `stock_quantity` int(11) DEFAULT 0,
  `product_type` enum('vendor','supplier','affiliate','dropshipping','wholesale','reseller') NOT NULL DEFAULT 'vendor',
  `thumbnail` varchar(255) DEFAULT NULL,
  `sponsored_video_url` varchar(500) DEFAULT NULL,
  `status` enum('draft','pending','published','rejected') DEFAULT 'draft',
  `is_new` tinyint(1) NOT NULL DEFAULT 0,
  `is_featured` tinyint(1) DEFAULT 0,
  `is_hot` tinyint(1) NOT NULL DEFAULT 0,
  `views_count` int(11) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `vendor_id`, `category_id`, `sub_category_id`, `brand_id`, `name`, `slug`, `sku`, `description`, `short_description`, `price`, `discount_price`, `cost_price`, `tags`, `stock_quantity`, `product_type`, `thumbnail`, `sponsored_video_url`, `status`, `is_new`, `is_featured`, `is_hot`, `views_count`, `created_at`, `updated_at`, `deleted_at`) VALUES
(33, NULL, 1, NULL, 1, 'Premium Basmati Rice 5kg', 'premium-basmati-rice-5kg-2', 'RICE-0002', 'Premium quality long grain basmati rice suitable for daily cooking, pulao and special occasions.', 'Premium long grain basmati rice for everyday cooking.', 850.00, 799.00, 650.00, 'rice,basmati,premium,grocery', 0, 'vendor', 'products/thumbnails/eYBf8x7Sl1OQagEKwI7jHFiJtF7pMl8cSDi24aC9.png', NULL, 'draft', 0, 0, 0, 0, '2026-09-18 08:58:24', '2026-09-20 07:03:54', NULL),
(34, NULL, 1, NULL, 1, 'Fresh Miniket Rice 5kg', 'fresh-miniket-rice-5kg', 'RICE-0003', 'High quality miniket rice with fine grains and excellent taste. Suitable for everyday family meals.', 'Premium quality miniket rice for everyday meals.', 720.00, 680.00, 550.00, 'rice,miniket,grocery,daily-essential', 0, 'vendor', 'products/thumbnails/elv9cV1jpq6PnVddM0YowXq7EBLyktosFIi5c5To.png', NULL, 'draft', 0, 0, 0, 0, '2026-09-18 08:59:15', '2026-09-20 07:04:24', NULL),
(35, NULL, 1, NULL, 1, 'Premium Nazirshail Rice 5kg', 'premium-nazirshail-rice-5kg', 'RICE-0004', 'Premium Nazirshail rice carefully processed to preserve natural taste, aroma and texture.', 'Premium Nazirshail rice with natural taste and aroma.', 780.00, 745.00, 590.00, 'rice,nazirshail,premium,bangladesh', 0, 'vendor', 'products/thumbnails/ZxUe29xfINHQqnlxMgqekW8t1Gg9I8NTTFvjpjM0.png', NULL, 'draft', 0, 0, 0, 0, '2026-09-18 08:59:15', '2026-09-20 07:04:55', NULL),
(36, NULL, 1, NULL, 1, 'Premium Chinigura Rice 2kg', 'premium-chinigura-rice-2kg', 'RICE-0005', 'Aromatic Chinigura rice ideal for pulao, khichuri, biryani and traditional Bengali dishes.', 'Aromatic Chinigura rice for special dishes.', 420.00, 395.00, 310.00, 'rice,chinigura,aromatic,pulao', 0, 'vendor', 'products/thumbnails/iciWWVNFQSvicaQUJlCi3TpzSbkJ88Y5YWIhQS3A.png', NULL, 'draft', 0, 0, 0, 0, '2026-09-18 08:59:15', '2026-09-20 07:05:27', NULL),
(37, NULL, 1, NULL, 1, 'Premium Brown Rice 1kg', 'premium-brown-rice-1kg', 'RICE-0006', 'Naturally nutritious brown rice with a rich texture and wholesome flavor for healthy meals.', 'Wholesome brown rice for healthy everyday meals.', 220.00, 199.00, 150.00, 'rice,brown-rice,healthy,organic', 0, 'vendor', 'products/thumbnails/S5Kb2XDp68q6W3BtHyiDqkTXen0TCyHTcfbgXPWt.png', NULL, 'draft', 0, 0, 0, 0, '2026-09-18 08:59:15', '2026-09-20 07:05:56', NULL),
(38, NULL, 1, 12, 1, 'Basmati Rice 1kg', 'basmati-rice-1kg', 'RICE-0007', 'Long grain aromatic basmati rice perfect for biryani, pulao and premium rice dishes.', 'Long grain aromatic basmati rice for premium dishes.', 290.00, 269.00, 210.00, 'rice,basmati,biryani,pulao', 0, 'vendor', 'products/thumbnails/SM1JC5oWjBhWoohJmqDiXln4j0Tdc7wMW3dgmueA.png', NULL, 'draft', 0, 0, 0, 0, '2026-09-18 08:59:15', '2026-09-20 07:06:35', NULL),
(39, NULL, 1, NULL, 1, 'Premium Basmati Rice 2kg', 'premium-basmati-rice-2kg', 'RICE-0008', 'Selected long grain basmati rice with beautiful aroma and excellent cooking performance.', 'Selected long grain basmati rice with rich aroma.', 520.00, 485.00, 390.00, 'rice,basmati,premium,long-grain', 0, 'vendor', 'products/thumbnails/u68mYNG4jNz82N4oom3QcNocSRH6GG2g371BGi3J.png', NULL, 'draft', 0, 0, 0, 0, '2026-09-18 08:59:15', '2026-09-20 07:07:02', NULL),
(40, NULL, 1, NULL, 1, 'Everyday White Rice 5kg', 'everyday-white-rice-5kg', 'RICE-0009', 'Clean and carefully processed white rice suitable for regular family meals.', 'Affordable quality rice for everyday family meals.', 650.00, 615.00, 500.00, 'rice,white-rice,grocery,daily', 0, 'vendor', 'products/thumbnails/cAq7cjA8mNRUpnk5kRXbxMUxVVnmNGnT0Y7QjKqn.png', NULL, 'draft', 0, 0, 0, 0, '2026-09-18 08:59:15', '2026-09-20 07:07:21', NULL),
(41, NULL, 1, NULL, 1, 'Premium Kalijira Rice 1kg', 'premium-kalijira-rice-1kg', 'RICE-0010', 'Small aromatic Kalijira rice traditionally used for pulao, desserts and special Bengali recipes.', 'Aromatic Kalijira rice for traditional recipes.', 260.00, 239.00, 185.00, 'rice,kalijira,aromatic,bengali', 0, 'vendor', 'products/thumbnails/QxgyQujJcOeN0GtRnp746SVJdbSnfJmIEPHWQ1iE.png', NULL, 'draft', 0, 0, 1, 0, '2026-09-18 08:59:15', '2026-09-25 02:32:05', NULL),
(42, NULL, 1, NULL, 1, 'Premium Kataribhog Rice 5kg', 'premium-kataribhog-rice-5kg', 'RICE-0011', 'Fragrant Kataribhog rice with a distinctive taste, ideal for pulao and special family occasions.', 'Fragrant Kataribhog rice for special occasions.', 850.00, 810.00, 650.00, 'rice,kataribhog,fragrant,premium', 0, 'vendor', 'products/thumbnails/367NO2nUe27UU5orxqtgOZ1EoQCWtuXOlwie7iif.png', NULL, 'draft', 0, 0, 1, 0, '2026-09-18 08:59:15', '2026-09-25 02:31:58', NULL),
(43, NULL, 1, NULL, 1, 'Premium Rice Combo Pack 10kg', 'premium-rice-combo-pack-10kg', 'RICE-0012', 'A convenient family rice combo containing selected premium rice varieties for everyday and special meals.', 'Family-size premium rice combo pack.', 1450.00, 1350.00, 1080.00, 'rice,combo,family-pack,premium,grocery', 0, 'vendor', 'products/thumbnails/TO2fVBSUdRyGwDkKYAu8dUJTBvwmcK0CAPDYUHJk.png', NULL, 'draft', 0, 1, 0, 0, '2026-09-18 08:59:15', '2026-09-25 02:32:19', NULL),
(44, 1, 2, 23, 2, 'iPhone 15', 'iphone-15', NULL, '<p><span style=\"color: rgb(13, 13, 13); font-family: -apple-system-body, ui-sans-serif, -apple-system, &quot;system-ui&quot;, &quot;Segoe UI&quot;, Helvetica, &quot;Apple Color Emoji&quot;, Arial, &quot;sans-serif&quot;, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;; font-size: 16px; letter-spacing: normal;\">Powerful performance, advanced</span><span style=\"color: rgb(13, 13, 13); font-family: -apple-system-body, ui-sans-serif, -apple-system, &quot;system-ui&quot;, &quot;Segoe UI&quot;, Helvetica, &quot;Apple Color Emoji&quot;, Arial, &quot;sans-serif&quot;, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;; font-size: 16px; letter-spacing: normal;\"> camera system and</span><span style=\"color: rgb(13, 13, 13); font-family: -apple-system-body, ui-sans-serif, -apple-system, &quot;system-ui&quot;, &quot;Segoe UI&quot;, Helvetica, &quot;Apple Color Emoji&quot;, Arial, &quot;sans-serif&quot;, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;; font-size: 16px; letter-spacing: normal;\"> a vibrant display</span><span style=\"color: rgb(13, 13, 13); font-family: -apple-system-body, ui-sans-serif, -apple-system, &quot;system-ui&quot;, &quot;Segoe UI&quot;, Helvetica, &quot;Apple Color Emoji&quot;, Arial, &quot;sans-serif&quot;, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;; font-size: 16px; letter-spacing: normal;\"> make this smartphone</span><span style=\"color: rgb(13, 13, 13); font-family: -apple-system-body, ui-sans-serif, -apple-system, &quot;system-ui&quot;, &quot;Segoe UI&quot;, Helvetica, &quot;Apple Color Emoji&quot;, Arial, &quot;sans-serif&quot;, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;; font-size: 16px; letter-spacing: normal;\"> suitable for everyday</span><span style=\"color: rgb(13, 13, 13); font-family: -apple-system-body, ui-sans-serif, -apple-system, &quot;system-ui&quot;, &quot;Segoe UI&quot;, Helvetica, &quot;Apple Color Emoji&quot;, Arial, &quot;sans-serif&quot;, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;; font-size: 16px; letter-spacing: normal;\"> communication</span><span style=\"color: rgb(13, 13, 13); font-family: -apple-system-body, ui-sans-serif, -apple-system, &quot;system-ui&quot;, &quot;Segoe UI&quot;, Helvetica, &quot;Apple Color Emoji&quot;, Arial, &quot;sans-serif&quot;, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;; font-size: 16px; letter-spacing: normal;\">, photography, entertainment</span><span style=\"color: rgb(13, 13, 13); font-family: -apple-system-body, ui-sans-serif, -apple-system, &quot;system-ui&quot;, &quot;Segoe UI&quot;, Helvetica, &quot;Apple Color Emoji&quot;, Arial, &quot;sans-serif&quot;, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;; font-size: 16px; letter-spacing: normal;\"> and productivity.</span></p>', 'Powerful performance', 5000.00, 4500.00, 0.00, NULL, 0, 'vendor', 'products/thumbnails/IgSiAlFchNMWimilxhJF67aKnFsombghO0bu9sRV.jpg', NULL, 'draft', 0, 0, 0, 0, '2026-09-19 20:58:47', '2026-09-20 06:48:56', NULL),
(45, 1, 2, 23, 1, 'Samsung Galaxy A55', 'samsung-galaxy-a55', 'RICE-00120', '<p><span style=\"color: rgb(13, 13, 13); font-family: -apple-system-body, ui-sans-serif, -apple-system, &quot;system-ui&quot;, &quot;Segoe UI&quot;, Helvetica, &quot;Apple Color Emoji&quot;, Arial, &quot;sans-serif&quot;, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;; font-size: 16px; letter-spacing: normal;\">A stylish smartphone</span><span style=\"color: rgb(13, 13, 13); font-family: -apple-system-body, ui-sans-serif, -apple-system, &quot;system-ui&quot;, &quot;Segoe UI&quot;, Helvetica, &quot;Apple Color Emoji&quot;, Arial, &quot;sans-serif&quot;, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;; font-size: 16px; letter-spacing: normal;\"> featuring a bright</span><span style=\"color: rgb(13, 13, 13); font-family: -apple-system-body, ui-sans-serif, -apple-system, &quot;system-ui&quot;, &quot;Segoe UI&quot;, Helvetica, &quot;Apple Color Emoji&quot;, Arial, &quot;sans-serif&quot;, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;; font-size: 16px; letter-spacing: normal;\"> display, capable camera</span><span style=\"color: rgb(13, 13, 13); font-family: -apple-system-body, ui-sans-serif, -apple-system, &quot;system-ui&quot;, &quot;Segoe UI&quot;, Helvetica, &quot;Apple Color Emoji&quot;, Arial, &quot;sans-serif&quot;, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;; font-size: 16px; letter-spacing: normal;\"> setup, long-lasting</span><span style=\"color: rgb(13, 13, 13); font-family: -apple-system-body, ui-sans-serif, -apple-system, &quot;system-ui&quot;, &quot;Segoe UI&quot;, Helvetica, &quot;Apple Color Emoji&quot;, Arial, &quot;sans-serif&quot;, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;; font-size: 16px; letter-spacing: normal;\"> battery and smooth</span><span style=\"color: rgb(13, 13, 13); font-family: -apple-system-body, ui-sans-serif, -apple-system, &quot;system-ui&quot;, &quot;Segoe UI&quot;, Helvetica, &quot;Apple Color Emoji&quot;, Arial, &quot;sans-serif&quot;, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;; font-size: 16px; letter-spacing: normal;\"> performance for everyday</span><span style=\"color: rgb(13, 13, 13); font-family: -apple-system-body, ui-sans-serif, -apple-system, &quot;system-ui&quot;, &quot;Segoe UI&quot;, Helvetica, &quot;Apple Color Emoji&quot;, Arial, &quot;sans-serif&quot;, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;; font-size: 16px; letter-spacing: normal;\"> apps and entertainment</span><span style=\"color: rgb(13, 13, 13); font-family: -apple-system-body, ui-sans-serif, -apple-system, &quot;system-ui&quot;, &quot;Segoe UI&quot;, Helvetica, &quot;Apple Color Emoji&quot;, Arial, &quot;sans-serif&quot;, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;; font-size: 16px; letter-spacing: normal;\">.</span></p>', 'A stylish smartphone', 50000.00, 35000.00, NULL, NULL, 0, 'vendor', 'products/thumbnails/PjLXbaX9SoxvX4dqRALjWGS1Mr9U99KGTeJZgd7D.jpg', NULL, 'draft', 0, 1, 0, 0, '2026-09-19 21:04:42', '2026-10-31 06:46:17', NULL),
(46, 1, 2, 24, 2, 'HP Pavilion 15', 'hp-pavilion-15', NULL, '<p><span style=\"color: rgb(13, 13, 13); font-family: -apple-system-body, ui-sans-serif, -apple-system, &quot;system-ui&quot;, &quot;Segoe UI&quot;, Helvetica, &quot;Apple Color Emoji&quot;, Arial, &quot;sans-serif&quot;, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;; font-size: 16px; letter-spacing: normal;\">A versatile laptop</span><span style=\"color: rgb(13, 13, 13); font-family: -apple-system-body, ui-sans-serif, -apple-system, &quot;system-ui&quot;, &quot;Segoe UI&quot;, Helvetica, &quot;Apple Color Emoji&quot;, Arial, &quot;sans-serif&quot;, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;; font-size: 16px; letter-spacing: normal;\"> designed for office</span><span style=\"color: rgb(13, 13, 13); font-family: -apple-system-body, ui-sans-serif, -apple-system, &quot;system-ui&quot;, &quot;Segoe UI&quot;, Helvetica, &quot;Apple Color Emoji&quot;, Arial, &quot;sans-serif&quot;, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;; font-size: 16px; letter-spacing: normal;\"> work, study, browsing</span><span style=\"color: rgb(13, 13, 13); font-family: -apple-system-body, ui-sans-serif, -apple-system, &quot;system-ui&quot;, &quot;Segoe UI&quot;, Helvetica, &quot;Apple Color Emoji&quot;, Arial, &quot;sans-serif&quot;, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;; font-size: 16px; letter-spacing: normal;\"> and multimedia use</span><span style=\"color: rgb(13, 13, 13); font-family: -apple-system-body, ui-sans-serif, -apple-system, &quot;system-ui&quot;, &quot;Segoe UI&quot;, Helvetica, &quot;Apple Color Emoji&quot;, Arial, &quot;sans-serif&quot;, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;; font-size: 16px; letter-spacing: normal;\">, with</span><span style=\"color: rgb(13, 13, 13); font-family: -apple-system-body, ui-sans-serif, -apple-system, &quot;system-ui&quot;, &quot;Segoe UI&quot;, Helvetica, &quot;Apple Color Emoji&quot;, Arial, &quot;sans-serif&quot;, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;; font-size: 16px; letter-spacing: normal;\"> a comfortable keyboard</span><span style=\"color: rgb(13, 13, 13); font-family: -apple-system-body, ui-sans-serif, -apple-system, &quot;system-ui&quot;, &quot;Segoe UI&quot;, Helvetica, &quot;Apple Color Emoji&quot;, Arial, &quot;sans-serif&quot;, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;; font-size: 16px; letter-spacing: normal;\"> and responsive performance</span><span style=\"color: rgb(13, 13, 13); font-family: -apple-system-body, ui-sans-serif, -apple-system, &quot;system-ui&quot;, &quot;Segoe UI&quot;, Helvetica, &quot;Apple Color Emoji&quot;, Arial, &quot;sans-serif&quot;, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;; font-size: 16px; letter-spacing: normal;\">.</span></p>', 'A versatile laptop', 70000.00, 65000.00, NULL, NULL, 0, 'vendor', 'products/thumbnails/XA5K6DaL7gghFXsiiy4uqeNWPB0mCfDPwopSwI4R.webp', NULL, 'draft', 0, 1, 0, 0, '2026-09-19 21:08:53', '2026-09-25 02:31:45', NULL),
(47, NULL, 2, 31, 3, 'Samsung Galaxy Tab A9', 'samsung-galaxy-tab-a9', NULL, '<p><span id=\"docs-internal-guid-abb80ff7-7fff-d0af-0e2e-69d38a058bc4\"><span style=\"font-size: 12pt; font-family: Arial, sans-serif; color: rgb(13, 13, 13); background-color: transparent; font-variant: normal; vertical-align: baseline; white-space: pre-wrap;\">A compact tablet designed for browsing, streaming, reading, online classes and everyday entertainment with a convenient portable design.</span></span></p>', 'Samsung Galaxy Tab A9', 15000.00, 13000.00, NULL, NULL, 0, 'vendor', 'products/thumbnails/mVcH2tFeZd1Bgy3nwipCP6KUbdIISh1Vq5umiAKT.jpg', NULL, 'draft', 0, 1, 0, 0, '2026-09-20 06:48:18', '2026-10-31 06:45:44', NULL),
(48, NULL, 2, 31, NULL, 'Xiaomi Pad 6', 'xiaomi-pad-6', NULL, '<p><span id=\"docs-internal-guid-ecb69905-7fff-6e86-b587-4755a2b73583\"></span></p><p dir=\"ltr\" style=\"line-height:1.38;background-color:#ffffff;margin-top:12pt;margin-bottom:12pt;\"><span style=\"font-size:12pt;font-family:Arial,sans-serif;color:#0d0d0d;background-color:transparent;font-weight:400;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre;white-space:pre-wrap;\">A high-performance tablet featuring a large display and smooth operation, suitable for entertainment, productivity, study and creative tasks.</span></p><p dir=\"ltr\" style=\"line-height:1.38;background-color:#ffffff;margin-top:12pt;margin-bottom:12pt;\"><span style=\"font-size:12pt;font-family:Arial,sans-serif;color:#0d0d0d;background-color:transparent;font-weight:400;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre;white-space:pre-wrap;\"><br></span></p><div class=\"otQkpb\" aria-level=\"3\" role=\"heading\" data-animation-nesting=\"\" data-sfc-cp=\"\" jsaction=\"\" data-wiz-attrbind=\"aria-level=EniQZ_13/fLk2Md\" jscontroller=\"a7qCn#ZxCkTb\" data-sfc-root=\"ep\" jsuid=\"EniQZ_13\" data-complete=\"true\" data-copy-service-computed-style=\"font-family: &quot;Google Sans&quot;, Arial, sans-serif, &quot;Noto Color Emoji&quot;; font-size: 20px; font-weight: 600; margin: 24px 0px 12px; text-decoration: none; border-bottom: 0px rgb(0, 29, 53);\" style=\"font-family: &quot;Google Sans&quot;, Arial, sans-serif, &quot;Noto Color Emoji&quot;; font-size: 20px; font-weight: 600; margin: 24px 0px 12px; border-bottom: 0px rgb(0, 29, 53);\">Top High-Performance Large Tablets<!--TgQPHd|||[]--></div><ul class=\"KsbFXc U6u95\" data-sfc-cp=\"\" jsaction=\"\" jscontroller=\"mPWODf#NS0kde\" data-sfc-root=\"ep\" jsuid=\"EniQZ_14\" data-ved=\"2ahUKEwin0rTLmf2WAxVKVmwGHaZyKbcQ-7AUegoIAggACAAIEBAA\" data-hveid=\"CAIIAAgACBAQAA\" data-complete=\"true\" data-copy-service-computed-style=\"font-family: &quot;Google Sans&quot;, Arial, sans-serif, &quot;Noto Color Emoji&quot;; font-size: 16px; font-weight: 400; margin: 12px 0px 16px; text-decoration: none; border-bottom: 0px rgb(10, 10, 10);\" style=\"font-family: &quot;Google Sans&quot;, Arial, sans-serif, &quot;Noto Color Emoji&quot;; font-size: 16px; margin: 12px 0px 16px; border-bottom: 0px rgb(10, 10, 10);\"><div data-bfc=\"\" class=\"\" data-sfc-cp=\"\" jsaction=\"\" jscontroller=\"eHDDzf#DtOdcb\" data-sfc-root=\"ep\" jsuid=\"EniQZ_15\" data-ved=\"2ahUKEwin0rTLmf2WAxVKVmwGHaZyKbcQi4wTegoIAggACAAIEBAB\" data-hveid=\"CAIIAAgACBAQAQ\" data-complete=\"true\" data-copy-service-computed-style=\"font-family: &quot;Google Sans&quot;, Arial, sans-serif, &quot;Noto Color Emoji&quot;; font-size: 16px; font-weight: 400; margin: 0px; text-decoration: none; border-bottom: 0px rgb(10, 10, 10);\" style=\"margin: 0px; border-bottom: 0px rgb(10, 10, 10);\"><li class=\"Z1qcYe\" data-sfc-cp=\"\" jsaction=\"\" jscontroller=\"oSLmPe#HokZ0d\" data-sfc-root=\"ep\" jsuid=\"EniQZ_16\" data-hveid=\"CAIIAAgACBAQAg\" data-complete=\"true\" data-copy-service-computed-style=\"font-family: &quot;Google Sans&quot;, Arial, sans-serif, &quot;Noto Color Emoji&quot;; font-size: 16px; font-weight: 400; margin: 0px 0px 12px; text-decoration: none; border-bottom: 0px rgb(10, 10, 10);\" style=\"margin: 0px 0px 12px; border-bottom: 0px rgb(10, 10, 10);\"><span class=\"iNqyIf\" data-sfc-cp=\"\" jsaction=\"\" jscontroller=\"KdQfFc#d5Qebf\" data-sfc-root=\"ep\" jsuid=\"EniQZ_17\" data-complete=\"true\" data-copy-service-computed-style=\"font-family: &quot;Google Sans&quot;, Arial, sans-serif, &quot;Noto Color Emoji&quot;; font-size: 16px; font-weight: 400; margin: 0px; text-decoration: none; border-bottom: 0px rgb(10, 10, 10);\" style=\"margin: 0px; border-bottom: 0px rgb(10, 10, 10);\"><span class=\"rQesXe MPyX\" data-sfc-cp=\"\" jsaction=\"\" jscontroller=\"tP2kf#s32ZS\" data-sfc-root=\"ep\" jsuid=\"EniQZ_18\" data-complete=\"true\" data-copy-service-computed-style=\"font-family: &quot;Google Sans&quot;, Arial, sans-serif, &quot;Noto Color Emoji&quot;; font-size: 16px; font-weight: 700; margin: 0px; text-decoration: none; border-bottom: 0px rgb(10, 10, 10);\" style=\"font-weight: 700; margin: 0px; border-bottom: 0px rgb(10, 10, 10);\">Apple iPad Pro (13-inch / M-series):<!--TgQPHd|||[]--></span> Delivers fluid performance via advanced processing power, a stunning tandem OLED screen, and precise Apple Pencil support for digital art, note-taking, and heavy multitasking.<!--TgQPHd|||[]--></span> [<a href=\"https://www.pcmag.com/picks/the-best-tablets\">1</a>, <a href=\"https://large-tablet.com/\">2</a>]<!--TgQPHd|||[]--></li><!--TgQPHd|||[]--></div><div data-bfc=\"\" class=\"\" data-sfc-cp=\"\" jsaction=\"\" jscontroller=\"eHDDzf#DtOdcb\" data-sfc-root=\"ep\" jsuid=\"EniQZ_1e\" data-ved=\"2ahUKEwin0rTLmf2WAxVKVmwGHaZyKbcQi4wTegoIAggACAAIEBAH\" data-hveid=\"CAIIAAgACBAQBw\" data-complete=\"true\" data-copy-service-computed-style=\"font-family: &quot;Google Sans&quot;, Arial, sans-serif, &quot;Noto Color Emoji&quot;; font-size: 16px; font-weight: 400; margin: 0px; text-decoration: none; border-bottom: 0px rgb(10, 10, 10);\" style=\"margin: 0px; border-bottom: 0px rgb(10, 10, 10);\"><li class=\"Z1qcYe\" data-sfc-cp=\"\" jsaction=\"\" jscontroller=\"oSLmPe#HokZ0d\" data-sfc-root=\"ep\" jsuid=\"EniQZ_1f\" data-hveid=\"CAIIAAgACBAQCA\" data-complete=\"true\" data-copy-service-computed-style=\"font-family: &quot;Google Sans&quot;, Arial, sans-serif, &quot;Noto Color Emoji&quot;; font-size: 16px; font-weight: 400; margin: 0px 0px 12px; text-decoration: none; border-bottom: 0px rgb(10, 10, 10);\" style=\"margin: 0px 0px 12px; border-bottom: 0px rgb(10, 10, 10);\"><span class=\"iNqyIf\" data-sfc-cp=\"\" jsaction=\"\" jscontroller=\"KdQfFc#d5Qebf\" data-sfc-root=\"ep\" jsuid=\"EniQZ_1g\" data-complete=\"true\" data-copy-service-computed-style=\"font-family: &quot;Google Sans&quot;, Arial, sans-serif, &quot;Noto Color Emoji&quot;; font-size: 16px; font-weight: 400; margin: 0px; text-decoration: none; border-bottom: 0px rgb(10, 10, 10);\" style=\"margin: 0px; border-bottom: 0px rgb(10, 10, 10);\"><span class=\"rQesXe MPyX\" data-sfc-cp=\"\" jsaction=\"\" jscontroller=\"tP2kf#s32ZS\" data-sfc-root=\"ep\" jsuid=\"EniQZ_1h\" data-complete=\"true\" data-copy-service-computed-style=\"font-family: &quot;Google Sans&quot;, Arial, sans-serif, &quot;Noto Color Emoji&quot;; font-size: 16px; font-weight: 700; margin: 0px; text-decoration: none; border-bottom: 0px rgb(10, 10, 10);\" style=\"font-weight: 700; margin: 0px; border-bottom: 0px rgb(10, 10, 10);\">Samsung Galaxy Tab S11 Ultra:<!--TgQPHd|||[]--></span> Features a massive 14.6-inch high-resolution display, vibrant contrast, smooth refresh rates, and an included S Pen for professional-grade creative drawing and split-screen productivity.<!--TgQPHd|||[]--></span> [<a href=\"https://www.youtube.com/watch?v=Q6iK4QNOcjM&amp;t=436\">1</a>]<!--TgQPHd|||[]--></li><!--TgQPHd|||[]--></div><div data-bfc=\"\" class=\"\" data-sfc-cp=\"\" jsaction=\"\" jscontroller=\"eHDDzf#DtOdcb\" data-sfc-root=\"ep\" jsuid=\"EniQZ_1n\" data-ved=\"2ahUKEwin0rTLmf2WAxVKVmwGHaZyKbcQi4wTegoIAggACAAIEBAL\" data-hveid=\"CAIIAAgACBAQCw\" data-complete=\"true\" data-copy-service-computed-style=\"font-family: &quot;Google Sans&quot;, Arial, sans-serif, &quot;Noto Color Emoji&quot;; font-size: 16px; font-weight: 400; margin: 0px; text-decoration: none; border-bottom: 0px rgb(10, 10, 10);\" style=\"margin: 0px; border-bottom: 0px rgb(10, 10, 10);\"><li class=\"Z1qcYe\" data-sfc-cp=\"\" jsaction=\"\" jscontroller=\"oSLmPe#HokZ0d\" data-sfc-root=\"ep\" jsuid=\"EniQZ_1o\" data-hveid=\"CAIIAAgACBAQDA\" data-complete=\"true\" data-copy-service-computed-style=\"font-family: &quot;Google Sans&quot;, Arial, sans-serif, &quot;Noto Color Emoji&quot;; font-size: 16px; font-weight: 400; margin: 0px 0px 12px; text-decoration: none; border-bottom: 0px rgb(10, 10, 10);\" style=\"margin: 0px 0px 12px; border-bottom: 0px rgb(10, 10, 10);\"><span class=\"iNqyIf\" data-sfc-cp=\"\" jsaction=\"\" jscontroller=\"KdQfFc#d5Qebf\" data-sfc-root=\"ep\" jsuid=\"EniQZ_1p\" data-complete=\"true\" data-copy-service-computed-style=\"font-family: &quot;Google Sans&quot;, Arial, sans-serif, &quot;Noto Color Emoji&quot;; font-size: 16px; font-weight: 400; margin: 0px; text-decoration: none; border-bottom: 0px rgb(10, 10, 10);\" style=\"margin: 0px; border-bottom: 0px rgb(10, 10, 10);\"><span class=\"rQesXe MPyX\" data-sfc-cp=\"\" jsaction=\"\" jscontroller=\"tP2kf#s32ZS\" data-sfc-root=\"ep\" jsuid=\"EniQZ_1q\" data-complete=\"true\" data-copy-service-computed-style=\"font-family: &quot;Google Sans&quot;, Arial, sans-serif, &quot;Noto Color Emoji&quot;; font-size: 16px; font-weight: 700; margin: 0px; text-decoration: none; border-bottom: 0px rgb(10, 10, 10);\" style=\"font-weight: 700; margin: 0px; border-bottom: 0px rgb(10, 10, 10);\">Lenovo Idea Tab Pro:<!--TgQPHd|||[]--></span> Packs a sharp 12.7-inch 3K display (144Hz) and quad JBL speakers with Dolby Atmos, paired with a bundled Lenovo Tab Pen Plus for seamless studying and media consumption.<!--TgQPHd|||[]--></span> [<a href=\"https://www.facebook.com/PCMag/posts/the-lenovo-idea-tab-plus-android-tablet-impresses-thanks-to-its-large-bright-dis/1428514085815053/\">1</a>]<!--TgQPHd|||[]--></li><!--TgQPHd|||[]--></div><!--TgQPHd|||[]--></ul><div class=\"yhAwj\" data-sfc-cp=\"\" jsaction=\"rcuQ6b:&amp;EniQZ_20|npT2md\" jscontroller=\"UTzWVc#U8DOt\" data-sfc-root=\"ep\" jsuid=\"EniQZ_20\" data-complete=\"true\" data-sfc-inited=\"2\" data-copy-service-computed-style=\"font-family: &quot;Google Sans&quot;, Arial, sans-serif, &quot;Noto Color Emoji&quot;; font-size: 16px; font-weight: 400; margin: 0px; text-decoration: none; border-bottom: 0px rgb(10, 10, 10);\" style=\"font-family: &quot;Google Sans&quot;, Arial, sans-serif, &quot;Noto Color Emoji&quot;; font-size: 16px; margin: 0px; border-bottom: 0px rgb(10, 10, 10);\"><!--TgQPHd|||[]--></div><p dir=\"ltr\" style=\"line-height: 1.38; margin-top: 12pt; margin-bottom: 12pt;\"><span style=\"font-size: 12pt; font-family: Arial, sans-serif; color: rgb(13, 13, 13); background-color: transparent; font-variant: normal; vertical-align: baseline; white-space: pre-wrap;\"></span></p><div data-bfc=\"\" class=\"\" data-sfc-cp=\"\" jsaction=\"\" jscontroller=\"eHDDzf#DtOdcb\" data-sfc-root=\"ep\" jsuid=\"EniQZ_22\" data-ved=\"2ahUKEwin0rTLmf2WAxVKVmwGHaZyKbcQi4wTegoIAggACAAIEhAA\" data-hveid=\"CAIIAAgACBIQAA\" data-complete=\"true\" data-copy-service-computed-style=\"font-family: &quot;Google Sans&quot;, Arial, sans-serif, &quot;Noto Color Emoji&quot;; font-size: 16px; font-weight: 400; margin: 0px; text-decoration: none; border-bottom: 0px rgb(10, 10, 10);\" style=\"font-family: &quot;Google Sans&quot;, Arial, sans-serif, &quot;Noto Color Emoji&quot;; font-size: 16px; margin: 0px; border-bottom: 0px rgb(10, 10, 10);\"><div class=\"AHmQrc\" data-sfc-cp=\"\" jsaction=\"\" jscontroller=\"LkYPVc#wdvZmf\" data-sfc-root=\"ep\" jsuid=\"EniQZ_23\" data-hveid=\"CAIIAAgACBIQAQ\" data-complete=\"true\" data-copy-service-computed-style=\"font-family: &quot;Google Sans&quot;, Arial, sans-serif, &quot;Noto Color Emoji&quot;; font-size: 16px; font-weight: 400; margin: 0px; text-decoration: none; border-bottom: 0px rgb(10, 10, 10);\" style=\"margin: 0px; border-bottom: 0px rgb(10, 10, 10);\"><div class=\"n6owBd awi2gc\" data-sfc-cp=\"\" jsaction=\"\" jscontroller=\"TDBkbc#Ml18Xb\" data-sfc-root=\"ep\" jsuid=\"EniQZ_24\" data-hveid=\"CAIIAAgACBIQAg\" data-complete=\"true\" data-copy-service-computed-style=\"font-family: &quot;Google Sans&quot;, Arial, sans-serif, &quot;Noto Color Emoji&quot;; font-size: 16px; font-weight: 400; margin: 12px 0px 16px; text-decoration: none; border-bottom: 0px rgb(10, 10, 10);\" style=\"margin: 12px 0px 16px; border-bottom: 0px rgb(10, 10, 10);\">To find the exact right match, could you let me know:<!--TgQPHd|||[]--></div><ul class=\"KsbFXc U6u95\" data-sfc-cp=\"\" jsaction=\"\" jscontroller=\"mPWODf#NS0kde\" data-sfc-root=\"ep\" jsuid=\"EniQZ_25\" data-ved=\"2ahUKEwin0rTLmf2WAxVKVmwGHaZyKbcQ-7AUegoIAggACAAIEhAD\" data-hveid=\"CAIIAAgACBIQAw\" data-complete=\"true\" data-copy-service-computed-style=\"font-family: &quot;Google Sans&quot;, Arial, sans-serif, &quot;Noto Color Emoji&quot;; font-size: 16px; font-weight: 400; margin: 12px 0px 16px; text-decoration: none; border-bottom: 0px rgb(10, 10, 10);\" style=\"margin: 12px 0px 16px; border-bottom: 0px rgb(10, 10, 10);\"><span data-copy-service-computed-style=\"font-family: &quot;Google Sans&quot;, Arial, sans-serif, &quot;Noto Color Emoji&quot;; font-size: 16px; font-weight: 400; margin: 0px; text-decoration: none; border-bottom: 0px rgb(10, 10, 10);\" style=\"margin: 0px; border-bottom: 0px rgb(10, 10, 10);\"><li class=\"Z1qcYe\" data-sfc-cp=\"\" jsaction=\"\" jscontroller=\"oSLmPe#HokZ0d\" data-sfc-root=\"ep\" jsuid=\"EniQZ_52\" data-hveid=\"CAIIAAgACB4QAA\" data-complete=\"true\" data-copy-service-computed-style=\"font-family: &quot;Google Sans&quot;, Arial, sans-serif, &quot;Noto Color Emoji&quot;; font-size: 16px; font-weight: 400; margin: 0px 0px 12px; text-decoration: none; border-bottom: 0px rgb(10, 10, 10);\" style=\"margin: 0px 0px 12px; border-bottom: 0px rgb(10, 10, 10);\"><span class=\"iNqyIf\" data-sfc-cp=\"\" jsaction=\"\" jscontroller=\"KdQfFc#d5Qebf\" data-sfc-root=\"ep\" jsuid=\"EniQZ_53\" data-complete=\"true\" data-copy-service-computed-style=\"font-family: &quot;Google Sans&quot;, Arial, sans-serif, &quot;Noto Color Emoji&quot;; font-size: 16px; font-weight: 400; margin: 0px; text-decoration: none; border-bottom: 0px rgb(10, 10, 10);\" style=\"margin: 0px; border-bottom: 0px rgb(10, 10, 10);\">Your preferred <span class=\"rQesXe MPyX\" data-sfc-cp=\"\" jsaction=\"\" jscontroller=\"tP2kf#s32ZS\" data-sfc-root=\"ep\" jsuid=\"EniQZ_54\" data-complete=\"true\" data-copy-service-computed-style=\"font-family: &quot;Google Sans&quot;, Arial, sans-serif, &quot;Noto Color Emoji&quot;; font-size: 16px; font-weight: 700; margin: 0px; text-decoration: none; border-bottom: 0px rgb(10, 10, 10);\" style=\"font-weight: 700; margin: 0px; border-bottom: 0px rgb(10, 10, 10);\">operating system<!--TgQPHd|||[]--></span> (iPadOS, Android, or Windows)?<!--TgQPHd|||[]--></span><!--TgQPHd|||[]--></li><li class=\"Z1qcYe\" data-sfc-cp=\"\" jsaction=\"\" jscontroller=\"oSLmPe#HokZ0d\" data-sfc-root=\"ep\" jsuid=\"EniQZ_55\" data-hveid=\"CAIIAAgACB4QAQ\" data-complete=\"true\" data-copy-service-computed-style=\"font-family: &quot;Google Sans&quot;, Arial, sans-serif, &quot;Noto Color Emoji&quot;; font-size: 16px; font-weight: 400; margin: 0px 0px 12px; text-decoration: none; border-bottom: 0px rgb(10, 10, 10);\" style=\"margin: 0px 0px 12px; border-bottom: 0px rgb(10, 10, 10);\"><span class=\"iNqyIf\" data-sfc-cp=\"\" jsaction=\"\" jscontroller=\"KdQfFc#d5Qebf\" data-sfc-root=\"ep\" jsuid=\"EniQZ_56\" data-complete=\"true\" data-copy-service-computed-style=\"font-family: &quot;Google Sans&quot;, Arial, sans-serif, &quot;Noto Color Emoji&quot;; font-size: 16px; font-weight: 400; margin: 0px; text-decoration: none; border-bottom: 0px rgb(10, 10, 10);\" style=\"margin: 0px; border-bottom: 0px rgb(10, 10, 10);\">Your target <span class=\"rQesXe MPyX\" data-sfc-cp=\"\" jsaction=\"\" jscontroller=\"tP2kf#s32ZS\" data-sfc-root=\"ep\" jsuid=\"EniQZ_57\" data-complete=\"true\" data-copy-service-computed-style=\"font-family: &quot;Google Sans&quot;, Arial, sans-serif, &quot;Noto Color Emoji&quot;; font-size: 16px; font-weight: 700; margin: 0px; text-decoration: none; border-bottom: 0px rgb(10, 10, 10);\" style=\"font-weight: 700; margin: 0px; border-bottom: 0px rgb(10, 10, 10);\">budget range<!--TgQPHd|||[]--></span>?<!--TgQPHd|||[]--></span><!--TgQPHd|||[]--></li><li class=\"Z1qcYe\" data-sfc-cp=\"\" jsaction=\"\" jscontroller=\"oSLmPe#HokZ0d\" data-sfc-root=\"ep\" jsuid=\"EniQZ_58\" data-hveid=\"CAIIAAgACB4QAg\" data-complete=\"true\" data-copy-service-computed-style=\"font-family: &quot;Google Sans&quot;, Arial, sans-serif, &quot;Noto Color Emoji&quot;; font-size: 16px; font-weight: 400; margin: 0px 0px 12px; text-decoration: none; border-bottom: 0px rgb(10, 10, 10);\" style=\"margin: 0px 0px 12px; border-bottom: 0px rgb(10, 10, 10);\"><span class=\"iNqyIf\" data-sfc-cp=\"\" jsaction=\"\" jscontroller=\"KdQfFc#d5Qebf\" data-sfc-root=\"ep\" jsuid=\"EniQZ_59\" data-complete=\"true\" data-copy-service-computed-style=\"font-family: &quot;Google Sans&quot;, Arial, sans-serif, &quot;Noto Color Emoji&quot;; font-size: 16px; font-weight: 400; margin: 0px; text-decoration: none; border-bottom: 0px rgb(10, 10, 10);\" style=\"margin: 0px; border-bottom: 0px rgb(10, 10, 10);\">Whether you need included accessories like a <span class=\"rQesXe MPyX\" data-sfc-cp=\"\" jsaction=\"\" jscontroller=\"tP2kf#s32ZS\" data-sfc-root=\"ep\" jsuid=\"EniQZ_5a\" data-complete=\"true\" data-copy-service-computed-style=\"font-family: &quot;Google Sans&quot;, Arial, sans-serif, &quot;Noto Color Emoji&quot;; font-size: 16px; font-weight: 700; margin: 0px; text-decoration: none; border-bottom: 0px rgb(10, 10, 10);\" style=\"font-weight: 700; margin: 0px; border-bottom: 0px rgb(10, 10, 10);\">stylus or keyboard<!--TgQPHd|||[]--></span>?<!--TgQPHd|||[]--></span><!--TgQPHd|||[]--></li></span><!--TgQPHd|||[]--></ul><span data-copy-service-computed-style=\"font-family: &quot;Google Sans&quot;, Arial, sans-serif, &quot;Noto Color Emoji&quot;; font-size: 16px; font-weight: 400; margin: 0px; text-decoration: none; border-bottom: 0px rgb(10, 10, 10);\" style=\"margin: 0px; border-bottom: 0px rgb(10, 10, 10);\"><div class=\"n6owBd awi2gc\" data-sfc-cp=\"\" jsaction=\"\" jscontroller=\"TDBkbc#Ml18Xb\" data-sfc-root=\"ep\" jsuid=\"EniQZ_5b\" data-hveid=\"CAIIAAgACB8QAA\" data-complete=\"true\" data-copy-service-computed-style=\"font-family: &quot;Google Sans&quot;, Arial, sans-serif, &quot;Noto Color Emoji&quot;; font-size: 16px; font-weight: 400; margin: 12px 0px 16px; text-decoration: none; border-bottom: 0px rgb(10, 10, 10);\" style=\"margin: 12px 0px 16px; border-bottom: 0px rgb(10, 10, 10);\">I can provide a tailored recommendation and local availability.</div></span></div></div>', 'Xiaomi Pad 6', 18000.00, 17000.00, NULL, NULL, 0, 'vendor', 'products/thumbnails/zOyTyEkPDY6FihuwgOpmHjhA9WrcVbRrAIqGgvXa.png', NULL, 'draft', 0, 0, 0, 0, '2026-09-20 06:53:27', '2026-09-20 06:53:27', NULL);
INSERT INTO `products` (`id`, `vendor_id`, `category_id`, `sub_category_id`, `brand_id`, `name`, `slug`, `sku`, `description`, `short_description`, `price`, `discount_price`, `cost_price`, `tags`, `stock_quantity`, `product_type`, `thumbnail`, `sponsored_video_url`, `status`, `is_new`, `is_featured`, `is_hot`, `views_count`, `created_at`, `updated_at`, `deleted_at`) VALUES
(49, NULL, 2, 25, 3, 'Apple Watch SE', 'apple-watch-se', NULL, '<div class=\"n6owBd awi2gc\" data-sfc-cp=\"\" jsaction=\"\" jscontroller=\"TDBkbc#Ml18Xb\" data-sfc-root=\"ep\" jsuid=\"jPIje_n\" data-hveid=\"CAIIAAgACAoQAA\" data-complete=\"true\" data-copy-service-computed-style=\"font-family: &quot;Google Sans&quot;, Arial, sans-serif, &quot;Noto Color Emoji&quot;; font-size: 16px; font-weight: 400; margin: 0px 0px 16px; text-decoration: none; border-bottom: 0px rgb(10, 10, 10);\" style=\"font-family: &quot;Google Sans&quot;, Arial, sans-serif, &quot;Noto Color Emoji&quot;; font-size: 16px; margin: 0px 0px 16px; border-bottom: 0px rgb(10, 10, 10);\"><span data-subtree=\"aimfl,mfl\" data-copy-service-computed-style=\"font-family: &quot;Google Sans&quot;, Arial, sans-serif, &quot;Noto Color Emoji&quot;; font-size: 16px; font-weight: 400; margin: 0px; text-decoration: none; border-bottom: 0px rgb(10, 10, 10);\" style=\"margin: 0px; border-bottom: 0px rgb(10, 10, 10);\">The Apple Watch SE is </span><mark jsuid=\"jPIje_o\" class=\"MAeH\" jsaction=\"click:&amp;jPIje_o|ZUljYd;\" data-wiz-attrbind=\"class=jPIje_o/cFwyDc\" jscontroller=\"IyE5S#Mt0KKb\" data-sfc-root=\"ep\" data-ved=\"2ahUKEwj33631mv2WAxXhRmcHHScyNbkQuJAPegoIAggACAAIChAB\" data-complete=\"true\" data-copy-service-computed-style=\"font-family: &quot;Google Sans&quot;, Arial, sans-serif, &quot;Noto Color Emoji&quot;; font-size: 16px; font-weight: 500; margin: 0px; text-decoration: none; border-bottom: 0px rgb(0, 29, 53);\" style=\"margin: 0px; border-bottom: 0px rgb(0, 29, 53);\">Apple\'s affordable smartwatch lineup, offering essential health, fitness, and safety features in a lightweight aluminum design<!--TgQPHd|||[[[null,null,null,null,null,null,null,null,null,null,null,null,[247864,null,0]]]]--></mark>. [<a href=\"https://www.youtube.com/watch?v=pzUOg87NSzU&amp;vl=en\">1</a>, <a href=\"https://www.apple.com/newsroom/2020/09/apple-watch-se-the-ultimate-combination-of-design-function-and-value/\">2</a>]<!--TgQPHd|||[]--></div><div class=\"yhAwj\" data-sfc-cp=\"\" jsaction=\"rcuQ6b:&amp;jPIje_w|npT2md\" jscontroller=\"UTzWVc#U8DOt\" data-sfc-root=\"ep\" jsuid=\"jPIje_w\" data-complete=\"true\" data-sfc-inited=\"2\" data-copy-service-computed-style=\"font-family: &quot;Google Sans&quot;, Arial, sans-serif, &quot;Noto Color Emoji&quot;; font-size: 16px; font-weight: 400; margin: 0px; text-decoration: none; border-bottom: 0px rgb(10, 10, 10);\" style=\"font-family: &quot;Google Sans&quot;, Arial, sans-serif, &quot;Noto Color Emoji&quot;; font-size: 16px; margin: 0px; border-bottom: 0px rgb(10, 10, 10);\"><!--TgQPHd|||[]--></div><div class=\"otQkpb\" aria-level=\"3\" role=\"heading\" data-animation-nesting=\"\" data-sfc-cp=\"\" jsaction=\"\" data-wiz-attrbind=\"aria-level=jPIje_x/fLk2Md\" jscontroller=\"a7qCn#ZxCkTb\" data-sfc-root=\"ep\" jsuid=\"jPIje_x\" data-complete=\"true\" data-copy-service-computed-style=\"font-family: &quot;Google Sans&quot;, Arial, sans-serif, &quot;Noto Color Emoji&quot;; font-size: 20px; font-weight: 600; margin: 24px 0px 12px; text-decoration: none; border-bottom: 0px rgb(0, 29, 53);\" style=\"font-family: &quot;Google Sans&quot;, Arial, sans-serif, &quot;Noto Color Emoji&quot;; font-size: 20px; font-weight: 600; margin: 24px 0px 12px; border-bottom: 0px rgb(0, 29, 53);\">Key Specifications &amp; Features<!--TgQPHd|||[]--></div><ul class=\"KsbFXc U6u95\" data-sfc-cp=\"\" jsaction=\"\" jscontroller=\"mPWODf#NS0kde\" data-sfc-root=\"ep\" jsuid=\"jPIje_y\" data-ved=\"2ahUKEwj33631mv2WAxXhRmcHHScyNbkQ-7AUegoIAggACAAIFRAA\" data-hveid=\"CAIIAAgACBUQAA\" data-complete=\"true\" data-copy-service-computed-style=\"font-family: &quot;Google Sans&quot;, Arial, sans-serif, &quot;Noto Color Emoji&quot;; font-size: 16px; font-weight: 400; margin: 12px 0px 16px; text-decoration: none; border-bottom: 0px rgb(10, 10, 10);\" style=\"font-family: &quot;Google Sans&quot;, Arial, sans-serif, &quot;Noto Color Emoji&quot;; font-size: 16px; margin: 12px 0px 16px; border-bottom: 0px rgb(10, 10, 10);\"><div data-bfc=\"\" class=\"\" data-sfc-cp=\"\" jsaction=\"\" jscontroller=\"eHDDzf#DtOdcb\" data-sfc-root=\"ep\" jsuid=\"jPIje_z\" data-ved=\"2ahUKEwj33631mv2WAxXhRmcHHScyNbkQi4wTegoIAggACAAIFRAB\" data-hveid=\"CAIIAAgACBUQAQ\" data-complete=\"true\" data-copy-service-computed-style=\"font-family: &quot;Google Sans&quot;, Arial, sans-serif, &quot;Noto Color Emoji&quot;; font-size: 16px; font-weight: 400; margin: 0px; text-decoration: none; border-bottom: 0px rgb(10, 10, 10);\" style=\"margin: 0px; border-bottom: 0px rgb(10, 10, 10);\"><li class=\"Z1qcYe\" data-sfc-cp=\"\" jsaction=\"\" jscontroller=\"oSLmPe#HokZ0d\" data-sfc-root=\"ep\" jsuid=\"jPIje_10\" data-hveid=\"CAIIAAgACBUQAg\" data-complete=\"true\" data-copy-service-computed-style=\"font-family: &quot;Google Sans&quot;, Arial, sans-serif, &quot;Noto Color Emoji&quot;; font-size: 16px; font-weight: 400; margin: 0px 0px 12px; text-decoration: none; border-bottom: 0px rgb(10, 10, 10);\" style=\"margin: 0px 0px 12px; border-bottom: 0px rgb(10, 10, 10);\"><span class=\"iNqyIf\" data-sfc-cp=\"\" jsaction=\"\" jscontroller=\"KdQfFc#d5Qebf\" data-sfc-root=\"ep\" jsuid=\"jPIje_11\" data-complete=\"true\" data-copy-service-computed-style=\"font-family: &quot;Google Sans&quot;, Arial, sans-serif, &quot;Noto Color Emoji&quot;; font-size: 16px; font-weight: 400; margin: 0px; text-decoration: none; border-bottom: 0px rgb(10, 10, 10);\" style=\"margin: 0px; border-bottom: 0px rgb(10, 10, 10);\"><span class=\"rQesXe MPyX\" data-sfc-cp=\"\" jsaction=\"\" jscontroller=\"tP2kf#s32ZS\" data-sfc-root=\"ep\" jsuid=\"jPIje_12\" data-complete=\"true\" data-copy-service-computed-style=\"font-family: &quot;Google Sans&quot;, Arial, sans-serif, &quot;Noto Color Emoji&quot;; font-size: 16px; font-weight: 700; margin: 0px; text-decoration: none; border-bottom: 0px rgb(10, 10, 10);\" style=\"font-weight: 700; margin: 0px; border-bottom: 0px rgb(10, 10, 10);\">Sizes:<!--TgQPHd|||[]--></span> Available in 40mm and 44mm lightweight recycled aluminum cases.<!--TgQPHd|||[]--></span> [<a href=\"https://www.cnet.com/tech/mobile/apple-watch-series-12-vs-apple-watch-se-3-compare-apples-new-watch-and-its-lower-cost-option/\">1</a>, <a href=\"https://www.youtube.com/watch?v=pzUOg87NSzU&amp;vl=en\">2</a>]<!--TgQPHd|||[]--></li><!--TgQPHd|||[]--></div><div data-bfc=\"\" class=\"\" data-sfc-cp=\"\" jsaction=\"\" jscontroller=\"eHDDzf#DtOdcb\" data-sfc-root=\"ep\" jsuid=\"jPIje_18\" data-ved=\"2ahUKEwj33631mv2WAxXhRmcHHScyNbkQi4wTegoIAggACAAIFRAH\" data-hveid=\"CAIIAAgACBUQBw\" data-complete=\"true\" data-copy-service-computed-style=\"font-family: &quot;Google Sans&quot;, Arial, sans-serif, &quot;Noto Color Emoji&quot;; font-size: 16px; font-weight: 400; margin: 0px; text-decoration: none; border-bottom: 0px rgb(10, 10, 10);\" style=\"margin: 0px; border-bottom: 0px rgb(10, 10, 10);\"><li class=\"Z1qcYe\" data-sfc-cp=\"\" jsaction=\"\" jscontroller=\"oSLmPe#HokZ0d\" data-sfc-root=\"ep\" jsuid=\"jPIje_19\" data-hveid=\"CAIIAAgACBUQCA\" data-complete=\"true\" data-copy-service-computed-style=\"font-family: &quot;Google Sans&quot;, Arial, sans-serif, &quot;Noto Color Emoji&quot;; font-size: 16px; font-weight: 400; margin: 0px 0px 12px; text-decoration: none; border-bottom: 0px rgb(10, 10, 10);\" style=\"margin: 0px 0px 12px; border-bottom: 0px rgb(10, 10, 10);\"><span class=\"iNqyIf\" data-sfc-cp=\"\" jsaction=\"\" jscontroller=\"KdQfFc#d5Qebf\" data-sfc-root=\"ep\" jsuid=\"jPIje_1a\" data-complete=\"true\" data-copy-service-computed-style=\"font-family: &quot;Google Sans&quot;, Arial, sans-serif, &quot;Noto Color Emoji&quot;; font-size: 16px; font-weight: 400; margin: 0px; text-decoration: none; border-bottom: 0px rgb(10, 10, 10);\" style=\"margin: 0px; border-bottom: 0px rgb(10, 10, 10);\"><span class=\"rQesXe MPyX\" data-sfc-cp=\"\" jsaction=\"\" jscontroller=\"tP2kf#s32ZS\" data-sfc-root=\"ep\" jsuid=\"jPIje_1b\" data-complete=\"true\" data-copy-service-computed-style=\"font-family: &quot;Google Sans&quot;, Arial, sans-serif, &quot;Noto Color Emoji&quot;; font-size: 16px; font-weight: 700; margin: 0px; text-decoration: none; border-bottom: 0px rgb(10, 10, 10);\" style=\"font-weight: 700; margin: 0px; border-bottom: 0px rgb(10, 10, 10);\">Display:<!--TgQPHd|||[]--></span> Retina OLED display with up to 1,000 nits of brightness.<!--TgQPHd|||[]--></span> [<a href=\"https://www.applegadgetsbd.com/product/apple-watch-se-2024\">1</a>]<!--TgQPHd|||[]--></li><!--TgQPHd|||[]--></div><div data-bfc=\"\" class=\"\" data-sfc-cp=\"\" jsaction=\"\" jscontroller=\"eHDDzf#DtOdcb\" data-sfc-root=\"ep\" jsuid=\"jPIje_1h\" data-ved=\"2ahUKEwj33631mv2WAxXhRmcHHScyNbkQi4wTegoIAggACAAIFRAN\" data-hveid=\"CAIIAAgACBUQDQ\" data-complete=\"true\" data-copy-service-computed-style=\"font-family: &quot;Google Sans&quot;, Arial, sans-serif, &quot;Noto Color Emoji&quot;; font-size: 16px; font-weight: 400; margin: 0px; text-decoration: none; border-bottom: 0px rgb(10, 10, 10);\" style=\"margin: 0px; border-bottom: 0px rgb(10, 10, 10);\"><li class=\"Z1qcYe\" data-sfc-cp=\"\" jsaction=\"\" jscontroller=\"oSLmPe#HokZ0d\" data-sfc-root=\"ep\" jsuid=\"jPIje_1i\" data-hveid=\"CAIIAAgACBUQDg\" data-complete=\"true\" data-copy-service-computed-style=\"font-family: &quot;Google Sans&quot;, Arial, sans-serif, &quot;Noto Color Emoji&quot;; font-size: 16px; font-weight: 400; margin: 0px 0px 12px; text-decoration: none; border-bottom: 0px rgb(10, 10, 10);\" style=\"margin: 0px 0px 12px; border-bottom: 0px rgb(10, 10, 10);\"><span class=\"iNqyIf\" data-sfc-cp=\"\" jsaction=\"\" jscontroller=\"KdQfFc#d5Qebf\" data-sfc-root=\"ep\" jsuid=\"jPIje_1j\" data-complete=\"true\" data-copy-service-computed-style=\"font-family: &quot;Google Sans&quot;, Arial, sans-serif, &quot;Noto Color Emoji&quot;; font-size: 16px; font-weight: 400; margin: 0px; text-decoration: none; border-bottom: 0px rgb(10, 10, 10);\" style=\"margin: 0px; border-bottom: 0px rgb(10, 10, 10);\"><span class=\"rQesXe MPyX\" data-sfc-cp=\"\" jsaction=\"\" jscontroller=\"tP2kf#s32ZS\" data-sfc-root=\"ep\" jsuid=\"jPIje_1k\" data-complete=\"true\" data-copy-service-computed-style=\"font-family: &quot;Google Sans&quot;, Arial, sans-serif, &quot;Noto Color Emoji&quot;; font-size: 16px; font-weight: 700; margin: 0px; text-decoration: none; border-bottom: 0px rgb(10, 10, 10);\" style=\"font-weight: 700; margin: 0px; border-bottom: 0px rgb(10, 10, 10);\">Battery Life:<!--TgQPHd|||[]--></span> Up to 18 hours of normal daily use.<!--TgQPHd|||[]--></span> [<a href=\"https://www.apple.com/apple-watch-se-3/specs/\">1</a>, <a href=\"https://www.applegadgetsbd.com/product/apple-watch-se-2024\">2</a>]<!--TgQPHd|||[]--></li><!--TgQPHd|||[]--></div><div data-bfc=\"\" class=\"\" data-sfc-cp=\"\" jsaction=\"\" jscontroller=\"eHDDzf#DtOdcb\" data-sfc-root=\"ep\" jsuid=\"jPIje_1q\" data-ved=\"2ahUKEwj33631mv2WAxXhRmcHHScyNbkQi4wTegoIAggACAAIFRAT\" data-hveid=\"CAIIAAgACBUQEw\" data-complete=\"true\" data-copy-service-computed-style=\"font-family: &quot;Google Sans&quot;, Arial, sans-serif, &quot;Noto Color Emoji&quot;; font-size: 16px; font-weight: 400; margin: 0px; text-decoration: none; border-bottom: 0px rgb(10, 10, 10);\" style=\"margin: 0px; border-bottom: 0px rgb(10, 10, 10);\"><li class=\"Z1qcYe\" data-sfc-cp=\"\" jsaction=\"\" jscontroller=\"oSLmPe#HokZ0d\" data-sfc-root=\"ep\" jsuid=\"jPIje_1r\" data-hveid=\"CAIIAAgACBUQFA\" data-complete=\"true\" data-copy-service-computed-style=\"font-family: &quot;Google Sans&quot;, Arial, sans-serif, &quot;Noto Color Emoji&quot;; font-size: 16px; font-weight: 400; margin: 0px 0px 12px; text-decoration: none; border-bottom: 0px rgb(10, 10, 10);\" style=\"margin: 0px 0px 12px; border-bottom: 0px rgb(10, 10, 10);\"><span class=\"iNqyIf\" data-sfc-cp=\"\" jsaction=\"\" jscontroller=\"KdQfFc#d5Qebf\" data-sfc-root=\"ep\" jsuid=\"jPIje_1s\" data-complete=\"true\" data-copy-service-computed-style=\"font-family: &quot;Google Sans&quot;, Arial, sans-serif, &quot;Noto Color Emoji&quot;; font-size: 16px; font-weight: 400; margin: 0px; text-decoration: none; border-bottom: 0px rgb(10, 10, 10);\" style=\"margin: 0px; border-bottom: 0px rgb(10, 10, 10);\"><span class=\"rQesXe MPyX\" data-sfc-cp=\"\" jsaction=\"\" jscontroller=\"tP2kf#s32ZS\" data-sfc-root=\"ep\" jsuid=\"jPIje_1t\" data-complete=\"true\" data-copy-service-computed-style=\"font-family: &quot;Google Sans&quot;, Arial, sans-serif, &quot;Noto Color Emoji&quot;; font-size: 16px; font-weight: 700; margin: 0px; text-decoration: none; border-bottom: 0px rgb(10, 10, 10);\" style=\"font-weight: 700; margin: 0px; border-bottom: 0px rgb(10, 10, 10);\">Water Resistance:<!--TgQPHd|||[]--></span> Swimproof up to 50 meters (ISO standard 22810:2010).<!--TgQPHd|||[]--></span> [<a href=\"https://support.apple.com/en-us/111853\">1</a>, <a href=\"https://support.apple.com/en-bn/111853\">2</a>]<!--TgQPHd|||[]--></li><!--TgQPHd|||[]--></div><div data-bfc=\"\" class=\"\" data-sfc-cp=\"\" jsaction=\"\" jscontroller=\"eHDDzf#DtOdcb\" data-sfc-root=\"ep\" jsuid=\"jPIje_1z\" data-ved=\"2ahUKEwj33631mv2WAxXhRmcHHScyNbkQi4wTegoIAggACAAIFRAZ\" data-hveid=\"CAIIAAgACBUQGQ\" data-complete=\"true\" data-copy-service-computed-style=\"font-family: &quot;Google Sans&quot;, Arial, sans-serif, &quot;Noto Color Emoji&quot;; font-size: 16px; font-weight: 400; margin: 0px; text-decoration: none; border-bottom: 0px rgb(10, 10, 10);\" style=\"margin: 0px; border-bottom: 0px rgb(10, 10, 10);\"><li class=\"Z1qcYe\" data-sfc-cp=\"\" jsaction=\"\" jscontroller=\"oSLmPe#HokZ0d\" data-sfc-root=\"ep\" jsuid=\"jPIje_20\" data-hveid=\"CAIIAAgACBUQGg\" data-complete=\"true\" data-copy-service-computed-style=\"font-family: &quot;Google Sans&quot;, Arial, sans-serif, &quot;Noto Color Emoji&quot;; font-size: 16px; font-weight: 400; margin: 0px 0px 12px; text-decoration: none; border-bottom: 0px rgb(10, 10, 10);\" style=\"margin: 0px 0px 12px; border-bottom: 0px rgb(10, 10, 10);\"><span class=\"iNqyIf\" data-sfc-cp=\"\" jsaction=\"\" jscontroller=\"KdQfFc#d5Qebf\" data-sfc-root=\"ep\" jsuid=\"jPIje_21\" data-complete=\"true\" data-copy-service-computed-style=\"font-family: &quot;Google Sans&quot;, Arial, sans-serif, &quot;Noto Color Emoji&quot;; font-size: 16px; font-weight: 400; margin: 0px; text-decoration: none; border-bottom: 0px rgb(10, 10, 10);\" style=\"margin: 0px; border-bottom: 0px rgb(10, 10, 10);\"><span class=\"rQesXe MPyX\" data-sfc-cp=\"\" jsaction=\"\" jscontroller=\"tP2kf#s32ZS\" data-sfc-root=\"ep\" jsuid=\"jPIje_22\" data-complete=\"true\" data-copy-service-computed-style=\"font-family: &quot;Google Sans&quot;, Arial, sans-serif, &quot;Noto Color Emoji&quot;; font-size: 16px; font-weight: 700; margin: 0px; text-decoration: none; border-bottom: 0px rgb(10, 10, 10);\" style=\"font-weight: 700; margin: 0px; border-bottom: 0px rgb(10, 10, 10);\">Health &amp; Safety:<!--TgQPHd|||[]--></span> Includes heart rate monitoring, sleep tracking, Fall Detection, Emergency SOS, and Crash Detection.<!--TgQPHd|||[]--></span> [<a href=\"https://support.apple.com/en-us/111853\">1</a>, <a href=\"https://www.applegadgetsbd.com/product/apple-watch-se-2024\">2</a>]<!--TgQPHd|||[]--></li><!--TgQPHd|||[]--></div><div data-bfc=\"\" class=\"\" data-sfc-cp=\"\" jsaction=\"\" jscontroller=\"eHDDzf#DtOdcb\" data-sfc-root=\"ep\" jsuid=\"jPIje_28\" data-ved=\"2ahUKEwj33631mv2WAxXhRmcHHScyNbkQi4wTegoIAggACAAIFRAf\" data-hveid=\"CAIIAAgACBUQHw\" data-complete=\"true\" data-copy-service-computed-style=\"font-family: &quot;Google Sans&quot;, Arial, sans-serif, &quot;Noto Color Emoji&quot;; font-size: 16px; font-weight: 400; margin: 0px; text-decoration: none; border-bottom: 0px rgb(10, 10, 10);\" style=\"margin: 0px; border-bottom: 0px rgb(10, 10, 10);\"><li class=\"Z1qcYe\" data-sfc-cp=\"\" jsaction=\"\" jscontroller=\"oSLmPe#HokZ0d\" data-sfc-root=\"ep\" jsuid=\"jPIje_29\" data-hveid=\"CAIIAAgACBUQIA\" data-complete=\"true\" data-copy-service-computed-style=\"font-family: &quot;Google Sans&quot;, Arial, sans-serif, &quot;Noto Color Emoji&quot;; font-size: 16px; font-weight: 400; margin: 0px 0px 12px; text-decoration: none; border-bottom: 0px rgb(10, 10, 10);\" style=\"margin: 0px 0px 12px; border-bottom: 0px rgb(10, 10, 10);\"><span class=\"iNqyIf\" data-sfc-cp=\"\" jsaction=\"\" jscontroller=\"KdQfFc#d5Qebf\" data-sfc-root=\"ep\" jsuid=\"jPIje_2a\" data-complete=\"true\" data-copy-service-computed-style=\"font-family: &quot;Google Sans&quot;, Arial, sans-serif, &quot;Noto Color Emoji&quot;; font-size: 16px; font-weight: 400; margin: 0px; text-decoration: none; border-bottom: 0px rgb(10, 10, 10);\" style=\"margin: 0px; border-bottom: 0px rgb(10, 10, 10);\"><span class=\"rQesXe MPyX\" data-sfc-cp=\"\" jsaction=\"\" jscontroller=\"tP2kf#s32ZS\" data-sfc-root=\"ep\" jsuid=\"jPIje_2b\" data-complete=\"true\" data-copy-service-computed-style=\"font-family: &quot;Google Sans&quot;, Arial, sans-serif, &quot;Noto Color Emoji&quot;; font-size: 16px; font-weight: 700; margin: 0px; text-decoration: none; border-bottom: 0px rgb(10, 10, 10);\" style=\"font-weight: 700; margin: 0px; border-bottom: 0px rgb(10, 10, 10);\">Connectivity:<!--TgQPHd|||[]--></span> Available in GPS-only or GPS + Cellular configurations.<!--TgQPHd|||[]--></span> [<a href=\"https://support.apple.com/en-us/111853\">1</a>, <a href=\"https://www.applegadgetsbd.com/product/apple-watch-se-2024\">2</a>]<!--TgQPHd|||[]--></li><!--TgQPHd|||[]--></div><div data-bfc=\"\" class=\"\" data-sfc-cp=\"\" jsaction=\"\" jscontroller=\"eHDDzf#DtOdcb\" data-sfc-root=\"ep\" jsuid=\"jPIje_2h\" data-ved=\"2ahUKEwj33631mv2WAxXhRmcHHScyNbkQi4wTegoIAggACAAIFRAl\" data-hveid=\"CAIIAAgACBUQJQ\" data-complete=\"true\" data-copy-service-computed-style=\"font-family: &quot;Google Sans&quot;, Arial, sans-serif, &quot;Noto Color Emoji&quot;; font-size: 16px; font-weight: 400; margin: 0px; text-decoration: none; border-bottom: 0px rgb(10, 10, 10);\" style=\"margin: 0px; border-bottom: 0px rgb(10, 10, 10);\"><li class=\"Z1qcYe\" data-sfc-cp=\"\" jsaction=\"\" jscontroller=\"oSLmPe#HokZ0d\" data-sfc-root=\"ep\" jsuid=\"jPIje_2i\" data-hveid=\"CAIIAAgACBUQJg\" data-complete=\"true\" data-copy-service-computed-style=\"font-family: &quot;Google Sans&quot;, Arial, sans-serif, &quot;Noto Color Emoji&quot;; font-size: 16px; font-weight: 400; margin: 0px 0px 12px; text-decoration: none; border-bottom: 0px rgb(10, 10, 10);\" style=\"margin: 0px 0px 12px; border-bottom: 0px rgb(10, 10, 10);\"><span class=\"iNqyIf\" data-sfc-cp=\"\" jsaction=\"\" jscontroller=\"KdQfFc#d5Qebf\" data-sfc-root=\"ep\" jsuid=\"jPIje_2j\" data-complete=\"true\" data-copy-service-computed-style=\"font-family: &quot;Google Sans&quot;, Arial, sans-serif, &quot;Noto Color Emoji&quot;; font-size: 16px; font-weight: 400; margin: 0px; text-decoration: none; border-bottom: 0px rgb(10, 10, 10);\" style=\"margin: 0px; border-bottom: 0px rgb(10, 10, 10);\"><span class=\"rQesXe MPyX\" data-sfc-cp=\"\" jsaction=\"\" jscontroller=\"tP2kf#s32ZS\" data-sfc-root=\"ep\" jsuid=\"jPIje_2k\" data-complete=\"true\" data-copy-service-computed-style=\"font-family: &quot;Google Sans&quot;, Arial, sans-serif, &quot;Noto Color Emoji&quot;; font-size: 16px; font-weight: 700; margin: 0px; text-decoration: none; border-bottom: 0px rgb(10, 10, 10);\" style=\"font-weight: 700; margin: 0px; border-bottom: 0px rgb(10, 10, 10);\">Omissions:<!--TgQPHd|||[]--></span> Lacks advanced clinical-grade sensors like an electrical heart sensor (ECG) or blood oxygen monitoring found on flagship Series</span></li></div></ul>', 'Apple Watch SE', 5000.00, 4500.00, NULL, NULL, 0, 'vendor', 'products/thumbnails/qWiawGTYQCcvhd7T2n2e0E1Jz4MPJL7dbUhZ2Lft.webp', NULL, 'draft', 1, 0, 0, 0, '2026-09-20 06:59:18', '2026-09-25 02:32:27', NULL);
INSERT INTO `products` (`id`, `vendor_id`, `category_id`, `sub_category_id`, `brand_id`, `name`, `slug`, `sku`, `description`, `short_description`, `price`, `discount_price`, `cost_price`, `tags`, `stock_quantity`, `product_type`, `thumbnail`, `sponsored_video_url`, `status`, `is_new`, `is_featured`, `is_hot`, `views_count`, `created_at`, `updated_at`, `deleted_at`) VALUES
(50, NULL, 2, 25, NULL, 'Xiaomi Watch S3', 'xiaomi-watch-s3', NULL, '<div class=\"pWvJNd j2luwe\" jsaction=\"\" jscontroller=\"zp3Dsd#fP0RJ\" data-sfc-root=\"ep\" jsuid=\"tcCwGe_5\" data-complete=\"true\" data-copy-service-computed-style=\"font-family: &quot;Google Sans&quot;, Arial, sans-serif, &quot;Noto Color Emoji&quot;; font-size: 16px; font-weight: 400; margin: 0px; text-decoration: none; border-bottom: 0px rgb(10, 10, 10);\" style=\"font-family: &quot;Google Sans&quot;, Arial, sans-serif, &quot;Noto Color Emoji&quot;; font-size: 16px; margin: 0px; border-bottom: 0px rgb(10, 10, 10);\"><div jsuid=\"tcCwGe_7\" dir=\"ltr\" data-container-id=\"main-col\" data-xid=\"VpUvz\" jsname=\"KFl8ub\" class=\"mZJni Dn7Fzd\" jsaction=\"cC6SSe:&amp;tcCwGe_7|mNzCb;\" jscontroller=\"Aoijq#INwBm\" data-sfc-root=\"ep\" data-ctx-provider=\"[[[&quot;dMtGDc&quot;,&quot;[false]&quot;]]]\" data-ved=\"2ahUKEwj53dPom_2WAxUqa2wGHUrWNgIQ3KYQegoIAggACAAIAhAB\" data-sfc-inited=\"2\" data-copy-service-computed-style=\"font-family: &quot;Google Sans&quot;, Arial, sans-serif, &quot;Noto Color Emoji&quot;; font-size: 16px; font-weight: 400; margin: 0px; text-decoration: none; border-bottom: 0px rgb(10, 10, 10);\" style=\"margin: 0px; border-bottom: 0px rgb(10, 10, 10);\"><span data-copy-service-computed-style=\"font-family: &quot;Google Sans&quot;, Arial, sans-serif, &quot;Noto Color Emoji&quot;; font-size: 16px; font-weight: 400; margin: 0px; text-decoration: none; border-bottom: 0px rgb(10, 10, 10);\" style=\"margin: 0px; border-bottom: 0px rgb(10, 10, 10);\"><div class=\"n6owBd awi2gc\" data-sfc-cp=\"\" jsaction=\"\" jscontroller=\"TDBkbc#Ml18Xb\" data-sfc-root=\"ep\" jsuid=\"tcCwGe_n\" data-hveid=\"CAIIAAgACAwQAA\" data-complete=\"true\" data-copy-service-computed-style=\"font-family: &quot;Google Sans&quot;, Arial, sans-serif, &quot;Noto Color Emoji&quot;; font-size: 16px; font-weight: 400; margin: 0px 0px 16px; text-decoration: none; border-bottom: 0px rgb(10, 10, 10);\" style=\"margin: 0px 0px 16px; border-bottom: 0px rgb(10, 10, 10);\"><span data-subtree=\"aimfl,mfl\" data-copy-service-computed-style=\"font-family: &quot;Google Sans&quot;, Arial, sans-serif, &quot;Noto Color Emoji&quot;; font-size: 16px; font-weight: 400; margin: 0px; text-decoration: none; border-bottom: 0px rgb(10, 10, 10);\" style=\"margin: 0px; border-bottom: 0px rgb(10, 10, 10);\">The </span><span jsuid=\"tcCwGe_s\" class=\"\" data-sfc-cp=\"\" jsaction=\"mouseenter:&amp;tcCwGe_s|ZUljYd;mouseleave:&amp;tcCwGe_s|aXD3Gb;focusin:&amp;tcCwGe_s|Mrjwi;focusout:&amp;tcCwGe_s|CXhG2e;pointerdown:&amp;tcCwGe_s|wndyDd;click:&amp;tcCwGe_s|yrMC6;\" jscontroller=\"KMhGd#Mx1qPe\" data-sfc-root=\"ep\" data-complete=\"true\" data-sfc-inited=\"2\" data-copy-service-computed-style=\"font-family: &quot;Google Sans&quot;, Arial, sans-serif, &quot;Noto Color Emoji&quot;; font-size: 16px; font-weight: 400; margin: 0px; text-decoration: none; border-bottom: 0px rgb(10, 10, 10);\" style=\"margin: 0px; border-bottom: 0px rgb(10, 10, 10);\"><a class=\"H23r4e\" target=\"_blank\" rel=\"noopener\" data-ved=\"2ahUKEwj53dPom_2WAxUqa2wGHUrWNgIQy_kOegoIAggACAAIDBAD\" data-hveid=\"CAIIAAgACAwQAw\" href=\"https://www.mi.com/global/product/xiaomi-watch-s3/\" ping=\"/url?sa=t&amp;source=web&amp;rct=j&amp;url=https://www.mi.com/global/product/xiaomi-watch-s3/&amp;ved=2ahUKEwj53dPom_2WAxUqa2wGHUrWNgIQy_kOegoIAggACAAIDBAD&amp;opi=89978449\" data-copy-service-computed-style=\"font-family: &quot;Google Sans&quot;, Arial, sans-serif, &quot;Noto Color Emoji&quot;; font-size: 16px; font-weight: 500; margin: 0px; text-decoration: underline 1px rgb(26, 13, 171); border-bottom: 0px rgb(26, 13, 171);\" style=\"margin: 0px; text-decoration: underline 1px rgb(26, 13, 171); border-bottom: 0px rgb(26, 13, 171);\">Xiaomi Watch S3</a><!--TgQPHd|||[[&quot;https://www.mi.com/global/product/xiaomi-watch-s3/&quot;,null,null,[null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,[{&quot;1218&quot;:[16]}]],16,null,null,null,null,null,null,[[1789909318037241,107768618,37148234],null,null,null,null,[[2,0,0,11]]],null,&quot;4f486f68-59c8-4cac-b7cd-b194fced8fed&quot;]]--></span> is <mark jsuid=\"tcCwGe_t\" class=\"MAeH\" jsaction=\"click:&amp;tcCwGe_t|ZUljYd;\" data-wiz-attrbind=\"class=tcCwGe_t/cFwyDc\" jscontroller=\"IyE5S#Mt0KKb\" data-sfc-root=\"ep\" data-ved=\"2ahUKEwj53dPom_2WAxUqa2wGHUrWNgIQuJAPegoIAggACAAIDBAE\" data-complete=\"true\" data-copy-service-computed-style=\"font-family: &quot;Google Sans&quot;, Arial, sans-serif, &quot;Noto Color Emoji&quot;; font-size: 16px; font-weight: 500; margin: 0px; text-decoration: none; border-bottom: 0px rgb(0, 29, 53);\" style=\"margin: 0px; border-bottom: 0px rgb(0, 29, 53);\">a versatile, premium smartwatch featuring a unique interchangeable bezel design and running on Xiaomi\'s <span class=\"iNqyIf\" data-sfc-cp=\"\" jsaction=\"\" jscontroller=\"KdQfFc#d5Qebf\" data-sfc-root=\"ep\" jsuid=\"tcCwGe_u\" data-complete=\"true\" data-copy-service-computed-style=\"font-family: &quot;Google Sans&quot;, Arial, sans-serif, &quot;Noto Color Emoji&quot;; font-size: 16px; font-weight: 500; margin: 0px; text-decoration: none; border-bottom: 0px rgb(0, 29, 53);\" style=\"margin: 0px; border-bottom: 0px rgb(0, 29, 53);\">HyperOS<!--TgQPHd|||[]--></span><!--TgQPHd|||[[[null,null,null,null,null,null,null,null,null,null,null,null,[247864,null,0]]]]--></mark>. [<a href=\"https://www.mi.com/global/product/xiaomi-watch-s3/\">1</a>, <a href=\"https://gadgetbd.com/product/xiaomi-watch-s3/\">2</a>, <a href=\"https://www.youtube.com/watch?v=q0oEQQQ86KQ&amp;t=240\">3</a>]<!--TgQPHd|||[]--></div><div class=\"yhAwj\" data-sfc-cp=\"\" jsaction=\"rcuQ6b:&amp;tcCwGe_13|npT2md\" jscontroller=\"UTzWVc#U8DOt\" data-sfc-root=\"ep\" jsuid=\"tcCwGe_13\" data-complete=\"true\" data-sfc-inited=\"2\" data-copy-service-computed-style=\"font-family: &quot;Google Sans&quot;, Arial, sans-serif, &quot;Noto Color Emoji&quot;; font-size: 16px; font-weight: 400; margin: 0px; text-decoration: none; border-bottom: 0px rgb(10, 10, 10);\" style=\"margin: 0px; border-bottom: 0px rgb(10, 10, 10);\"><!--TgQPHd|||[]--></div><div class=\"otQkpb\" aria-level=\"3\" role=\"heading\" data-animation-nesting=\"\" data-sfc-cp=\"\" jsaction=\"\" data-wiz-attrbind=\"aria-level=tcCwGe_14/fLk2Md\" jscontroller=\"a7qCn#ZxCkTb\" data-sfc-root=\"ep\" jsuid=\"tcCwGe_14\" data-complete=\"true\" data-copy-service-computed-style=\"font-family: &quot;Google Sans&quot;, Arial, sans-serif, &quot;Noto Color Emoji&quot;; font-size: 20px; font-weight: 600; margin: 24px 0px 12px; text-decoration: none; border-bottom: 0px rgb(0, 29, 53);\" style=\"font-size: 20px; font-weight: 600; margin: 24px 0px 12px; border-bottom: 0px rgb(0, 29, 53);\">Key Features<!--TgQPHd|||[]--></div><ul class=\"KsbFXc U6u95\" data-sfc-cp=\"\" jsaction=\"\" jscontroller=\"mPWODf#NS0kde\" data-sfc-root=\"ep\" jsuid=\"tcCwGe_1u\" data-ved=\"2ahUKEwj53dPom_2WAxUqa2wGHUrWNgIQ-7AUegoIAggACAAIIRAA\" data-hveid=\"CAIIAAgACCEQAA\" data-complete=\"true\" data-copy-service-computed-style=\"font-family: &quot;Google Sans&quot;, Arial, sans-serif, &quot;Noto Color Emoji&quot;; font-size: 16px; font-weight: 400; margin: 12px 0px 16px; text-decoration: none; border-bottom: 0px rgb(10, 10, 10);\" style=\"margin: 12px 0px 16px; border-bottom: 0px rgb(10, 10, 10);\"><div data-bfc=\"\" class=\"\" data-sfc-cp=\"\" jsaction=\"\" jscontroller=\"eHDDzf#DtOdcb\" data-sfc-root=\"ep\" jsuid=\"tcCwGe_1v\" data-ved=\"2ahUKEwj53dPom_2WAxUqa2wGHUrWNgIQi4wTegoIAggACAAIIRAB\" data-hveid=\"CAIIAAgACCEQAQ\" data-complete=\"true\" data-copy-service-computed-style=\"font-family: &quot;Google Sans&quot;, Arial, sans-serif, &quot;Noto Color Emoji&quot;; font-size: 16px; font-weight: 400; margin: 0px; text-decoration: none; border-bottom: 0px rgb(10, 10, 10);\" style=\"margin: 0px; border-bottom: 0px rgb(10, 10, 10);\"><li class=\"Z1qcYe\" data-sfc-cp=\"\" jsaction=\"\" jscontroller=\"oSLmPe#HokZ0d\" data-sfc-root=\"ep\" jsuid=\"tcCwGe_1w\" data-hveid=\"CAIIAAgACCEQAg\" data-complete=\"true\" data-copy-service-computed-style=\"font-family: &quot;Google Sans&quot;, Arial, sans-serif, &quot;Noto Color Emoji&quot;; font-size: 16px; font-weight: 400; margin: 0px 0px 12px; text-decoration: none; border-bottom: 0px rgb(10, 10, 10);\" style=\"margin: 0px 0px 12px; border-bottom: 0px rgb(10, 10, 10);\"><span class=\"iNqyIf\" data-sfc-cp=\"\" jsaction=\"\" jscontroller=\"KdQfFc#d5Qebf\" data-sfc-root=\"ep\" jsuid=\"tcCwGe_1x\" data-complete=\"true\" data-copy-service-computed-style=\"font-family: &quot;Google Sans&quot;, Arial, sans-serif, &quot;Noto Color Emoji&quot;; font-size: 16px; font-weight: 400; margin: 0px; text-decoration: none; border-bottom: 0px rgb(10, 10, 10);\" style=\"margin: 0px; border-bottom: 0px rgb(10, 10, 10);\"><span class=\"rQesXe MPyX\" data-sfc-cp=\"\" jsaction=\"\" jscontroller=\"tP2kf#s32ZS\" data-sfc-root=\"ep\" jsuid=\"tcCwGe_1y\" data-complete=\"true\" data-copy-service-computed-style=\"font-family: &quot;Google Sans&quot;, Arial, sans-serif, &quot;Noto Color Emoji&quot;; font-size: 16px; font-weight: 700; margin: 0px; text-decoration: none; border-bottom: 0px rgb(10, 10, 10);\" style=\"font-weight: 700; margin: 0px; border-bottom: 0px rgb(10, 10, 10);\">Display:<!--TgQPHd|||[]--></span> 1.43-inch large circular AMOLED screen with 466 × 466 resolution, 60Hz refresh rate, and protective glass.<!--TgQPHd|||[]--></span> [<a href=\"https://www.wired.com/review/xiaomi-watch-s3/\">1</a>, <a href=\"https://www.mi.com/global/product/xiaomi-watch-s3/\">2</a>, <a href=\"https://gadgetbd.com/product/xiaomi-watch-s3/\">3</a>]<!--TgQPHd|||[]--></li><!--TgQPHd|||[]--></div><div data-bfc=\"\" class=\"\" data-sfc-cp=\"\" jsaction=\"\" jscontroller=\"eHDDzf#DtOdcb\" data-sfc-root=\"ep\" jsuid=\"tcCwGe_24\" data-ved=\"2ahUKEwj53dPom_2WAxUqa2wGHUrWNgIQi4wTegoIAggACAAIIRAH\" data-hveid=\"CAIIAAgACCEQBw\" data-complete=\"true\" data-copy-service-computed-style=\"font-family: &quot;Google Sans&quot;, Arial, sans-serif, &quot;Noto Color Emoji&quot;; font-size: 16px; font-weight: 400; margin: 0px; text-decoration: none; border-bottom: 0px rgb(10, 10, 10);\" style=\"margin: 0px; border-bottom: 0px rgb(10, 10, 10);\"><li class=\"Z1qcYe\" data-sfc-cp=\"\" jsaction=\"\" jscontroller=\"oSLmPe#HokZ0d\" data-sfc-root=\"ep\" jsuid=\"tcCwGe_25\" data-hveid=\"CAIIAAgACCEQCA\" data-complete=\"true\" data-copy-service-computed-style=\"font-family: &quot;Google Sans&quot;, Arial, sans-serif, &quot;Noto Color Emoji&quot;; font-size: 16px; font-weight: 400; margin: 0px 0px 12px; text-decoration: none; border-bottom: 0px rgb(10, 10, 10);\" style=\"margin: 0px 0px 12px; border-bottom: 0px rgb(10, 10, 10);\"><span class=\"iNqyIf\" data-sfc-cp=\"\" jsaction=\"\" jscontroller=\"KdQfFc#d5Qebf\" data-sfc-root=\"ep\" jsuid=\"tcCwGe_26\" data-complete=\"true\" data-copy-service-computed-style=\"font-family: &quot;Google Sans&quot;, Arial, sans-serif, &quot;Noto Color Emoji&quot;; font-size: 16px; font-weight: 400; margin: 0px; text-decoration: none; border-bottom: 0px rgb(10, 10, 10);\" style=\"margin: 0px; border-bottom: 0px rgb(10, 10, 10);\"><span class=\"rQesXe MPyX\" data-sfc-cp=\"\" jsaction=\"\" jscontroller=\"tP2kf#s32ZS\" data-sfc-root=\"ep\" jsuid=\"tcCwGe_27\" data-complete=\"true\" data-copy-service-computed-style=\"font-family: &quot;Google Sans&quot;, Arial, sans-serif, &quot;Noto Color Emoji&quot;; font-size: 16px; font-weight: 700; margin: 0px; text-decoration: none; border-bottom: 0px rgb(10, 10, 10);\" style=\"font-weight: 700; margin: 0px; border-bottom: 0px rgb(10, 10, 10);\">Design:<!--TgQPHd|||[]--></span> Aluminum alloy frame with a swappable, interchangeable bezel system that lets you change styles easily.<!--TgQPHd|||[]--></span> [<a href=\"https://www.youtube.com/watch?v=amnM6iHhMXA\">1</a>, <a href=\"https://www.mi.com/ph/support/faq/details/KA-92489/\">2</a>]<!--TgQPHd|||[]--></li><!--TgQPHd|||[]--></div><div data-bfc=\"\" class=\"\" data-sfc-cp=\"\" jsaction=\"\" jscontroller=\"eHDDzf#DtOdcb\" data-sfc-root=\"ep\" jsuid=\"tcCwGe_2d\" data-ved=\"2ahUKEwj53dPom_2WAxUqa2wGHUrWNgIQi4wTegoIAggACAAIIRAO\" data-hveid=\"CAIIAAgACCEQDg\" data-complete=\"true\" data-copy-service-computed-style=\"font-family: &quot;Google Sans&quot;, Arial, sans-serif, &quot;Noto Color Emoji&quot;; font-size: 16px; font-weight: 400; margin: 0px; text-decoration: none; border-bottom: 0px rgb(10, 10, 10);\" style=\"margin: 0px; border-bottom: 0px rgb(10, 10, 10);\"><li class=\"Z1qcYe\" data-sfc-cp=\"\" jsaction=\"\" jscontroller=\"oSLmPe#HokZ0d\" data-sfc-root=\"ep\" jsuid=\"tcCwGe_2e\" data-hveid=\"CAIIAAgACCEQDw\" data-complete=\"true\" data-copy-service-computed-style=\"font-family: &quot;Google Sans&quot;, Arial, sans-serif, &quot;Noto Color Emoji&quot;; font-size: 16px; font-weight: 400; margin: 0px 0px 12px; text-decoration: none; border-bottom: 0px rgb(10, 10, 10);\" style=\"margin: 0px 0px 12px; border-bottom: 0px rgb(10, 10, 10);\"><span class=\"iNqyIf\" data-sfc-cp=\"\" jsaction=\"\" jscontroller=\"KdQfFc#d5Qebf\" data-sfc-root=\"ep\" jsuid=\"tcCwGe_2f\" data-complete=\"true\" data-copy-service-computed-style=\"font-family: &quot;Google Sans&quot;, Arial, sans-serif, &quot;Noto Color Emoji&quot;; font-size: 16px; font-weight: 400; margin: 0px; text-decoration: none; border-bottom: 0px rgb(10, 10, 10);\" style=\"margin: 0px; border-bottom: 0px rgb(10, 10, 10);\"><span class=\"rQesXe MPyX\" data-sfc-cp=\"\" jsaction=\"\" jscontroller=\"tP2kf#s32ZS\" data-sfc-root=\"ep\" jsuid=\"tcCwGe_2g\" data-complete=\"true\" data-copy-service-computed-style=\"font-family: &quot;Google Sans&quot;, Arial, sans-serif, &quot;Noto Color Emoji&quot;; font-size: 16px; font-weight: 700; margin: 0px; text-decoration: none; border-bottom: 0px rgb(10, 10, 10);\" style=\"font-weight: 700; margin: 0px; border-bottom: 0px rgb(10, 10, 10);\">Battery Life:<!--TgQPHd|||[]--></span> Up to 15 days of typical usage on a single charge with a 486 mAh battery.<!--TgQPHd|||[]--></span> [<a href=\"https://www.gsmarena.com/xiaomi_watch_s3-12834.php\">1</a>, <a href=\"https://www.mi.com/global/product/xiaomi-watch-s3/\">2</a>, <a href=\"https://gadgetbd.com/product/xiaomi-watch-s3/\">3</a>]<!--TgQPHd|||[]--></li><!--TgQPHd|||[]--></div><div data-bfc=\"\" class=\"\" data-sfc-cp=\"\" jsaction=\"\" jscontroller=\"eHDDzf#DtOdcb\" data-sfc-root=\"ep\" jsuid=\"tcCwGe_2m\" data-ved=\"2ahUKEwj53dPom_2WAxUqa2wGHUrWNgIQi4wTegoIAggACAAIIRAU\" data-hveid=\"CAIIAAgACCEQFA\" data-complete=\"true\" data-copy-service-computed-style=\"font-family: &quot;Google Sans&quot;, Arial, sans-serif, &quot;Noto Color Emoji&quot;; font-size: 16px; font-weight: 400; margin: 0px; text-decoration: none; border-bottom: 0px rgb(10, 10, 10);\" style=\"margin: 0px; border-bottom: 0px rgb(10, 10, 10);\"><li class=\"Z1qcYe\" data-sfc-cp=\"\" jsaction=\"\" jscontroller=\"oSLmPe#HokZ0d\" data-sfc-root=\"ep\" jsuid=\"tcCwGe_2n\" data-hveid=\"CAIIAAgACCEQFQ\" data-complete=\"true\" data-copy-service-computed-style=\"font-family: &quot;Google Sans&quot;, Arial, sans-serif, &quot;Noto Color Emoji&quot;; font-size: 16px; font-weight: 400; margin: 0px 0px 12px; text-decoration: none; border-bottom: 0px rgb(10, 10, 10);\" style=\"margin: 0px 0px 12px; border-bottom: 0px rgb(10, 10, 10);\"><span class=\"iNqyIf\" data-sfc-cp=\"\" jsaction=\"\" jscontroller=\"KdQfFc#d5Qebf\" data-sfc-root=\"ep\" jsuid=\"tcCwGe_2o\" data-complete=\"true\" data-copy-service-computed-style=\"font-family: &quot;Google Sans&quot;, Arial, sans-serif, &quot;Noto Color Emoji&quot;; font-size: 16px; font-weight: 400; margin: 0px; text-decoration: none; border-bottom: 0px rgb(10, 10, 10);\" style=\"margin: 0px; border-bottom: 0px rgb(10, 10, 10);\"><span class=\"rQesXe MPyX\" data-sfc-cp=\"\" jsaction=\"\" jscontroller=\"tP2kf#s32ZS\" data-sfc-root=\"ep\" jsuid=\"tcCwGe_2p\" data-complete=\"true\" data-copy-service-computed-style=\"font-family: &quot;Google Sans&quot;, Arial, sans-serif, &quot;Noto Color Emoji&quot;; font-size: 16px; font-weight: 700; margin: 0px; text-decoration: none; border-bottom: 0px rgb(10, 10, 10);\" style=\"font-weight: 700; margin: 0px; border-bottom: 0px rgb(10, 10, 10);\">Connectivity:<!--TgQPHd|||[]--></span> Supports Bluetooth phone calls via a built-in speaker and microphone, plus Bluetooth 5.2. Available in Bluetooth and eSIM variants.<!--TgQPHd|||[]--></span> [<a href=\"https://www.mi.com/global/product/xiaomi-watch-s3/specs/\">1</a>, <a href=\"https://www.mi.com/global/product/xiaomi-watch-s3/\">2</a>, <a href=\"https://www.mi.com/ph/support/faq/details/KA-92489/\">3</a>]<!--TgQPHd|||[]--></li><!--TgQPHd|||[]--></div><div data-bfc=\"\" class=\"\" data-sfc-cp=\"\" jsaction=\"\" jscontroller=\"eHDDzf#DtOdcb\" data-sfc-root=\"ep\" jsuid=\"tcCwGe_2v\" data-ved=\"2ahUKEwj53dPom_2WAxUqa2wGHUrWNgIQi4wTegoIAggACAAIIRAa\" data-hveid=\"CAIIAAgACCEQGg\" data-complete=\"true\" data-copy-service-computed-style=\"font-family: &quot;Google Sans&quot;, Arial, sans-serif, &quot;Noto Color Emoji&quot;; font-size: 16px; font-weight: 400; margin: 0px; text-decoration: none; border-bottom: 0px rgb(10, 10, 10);\" style=\"margin: 0px; border-bottom: 0px rgb(10, 10, 10);\"><li class=\"Z1qcYe\" data-sfc-cp=\"\" jsaction=\"\" jscontroller=\"oSLmPe#HokZ0d\" data-sfc-root=\"ep\" jsuid=\"tcCwGe_2w\" data-hveid=\"CAIIAAgACCEQGw\" data-complete=\"true\" data-copy-service-computed-style=\"font-family: &quot;Google Sans&quot;, Arial, sans-serif, &quot;Noto Color Emoji&quot;; font-size: 16px; font-weight: 400; margin: 0px 0px 12px; text-decoration: none; border-bottom: 0px rgb(10, 10, 10);\" style=\"margin: 0px 0px 12px; border-bottom: 0px rgb(10, 10, 10);\"><span class=\"iNqyIf\" data-sfc-cp=\"\" jsaction=\"\" jscontroller=\"KdQfFc#d5Qebf\" data-sfc-root=\"ep\" jsuid=\"tcCwGe_2x\" data-complete=\"true\" data-copy-service-computed-style=\"font-family: &quot;Google Sans&quot;, Arial, sans-serif, &quot;Noto Color Emoji&quot;; font-size: 16px; font-weight: 400; margin: 0px; text-decoration: none; border-bottom: 0px rgb(10, 10, 10);\" style=\"margin: 0px; border-bottom: 0px rgb(10, 10, 10);\"><span class=\"rQesXe MPyX\" data-sfc-cp=\"\" jsaction=\"\" jscontroller=\"tP2kf#s32ZS\" data-sfc-root=\"ep\" jsuid=\"tcCwGe_2y\" data-complete=\"true\" data-copy-service-computed-style=\"font-family: &quot;Google Sans&quot;, Arial, sans-serif, &quot;Noto Color Emoji&quot;; font-size: 16px; font-weight: 700; margin: 0px; text-decoration: none; border-bottom: 0px rgb(10, 10, 10);\" style=\"font-weight: 700; margin: 0px; border-bottom: 0px rgb(10, 10, 10);\">Fitness &amp; GPS:<!--TgQPHd|||[]--></span> Built-in dual-band L1+L5 5-star positioning (GPS, Galileo, GLONASS, BeiDou, QZSS) and over 150 sports modes.<!--TgQPHd|||[]--></span> [<a href=\"https://www.mi.com/global/product/xiaomi-watch-s3/\">1</a>, <a href=\"https://www.mi.com/global/product/xiaomi-watch-s3/specs/\">2</a>, <a href=\"https://www.mi.com/ph/support/faq/details/KA-92489/\">3</a>]<!--TgQPHd|||[]--></li><!--TgQPHd|||[]--></div><div data-bfc=\"\" class=\"\" data-sfc-cp=\"\" jsaction=\"\" jscontroller=\"eHDDzf#DtOdcb\" data-sfc-root=\"ep\" jsuid=\"tcCwGe_34\" data-ved=\"2ahUKEwj53dPom_2WAxUqa2wGHUrWNgIQi4wTegoIAggACAAIIRAg\" data-hveid=\"CAIIAAgACCEQIA\" data-complete=\"true\" data-copy-service-computed-style=\"font-family: &quot;Google Sans&quot;, Arial, sans-serif, &quot;Noto Color Emoji&quot;; font-size: 16px; font-weight: 400; margin: 0px; text-decoration: none; border-bottom: 0px rgb(10, 10, 10);\" style=\"margin: 0px; border-bottom: 0px rgb(10, 10, 10);\"><li class=\"Z1qcYe\" data-sfc-cp=\"\" jsaction=\"\" jscontroller=\"oSLmPe#HokZ0d\" data-sfc-root=\"ep\" jsuid=\"tcCwGe_35\" data-hveid=\"CAIIAAgACCEQIQ\" data-complete=\"true\" data-copy-service-computed-style=\"font-family: &quot;Google Sans&quot;, Arial, sans-serif, &quot;Noto Color Emoji&quot;; font-size: 16px; font-weight: 400; margin: 0px 0px 12px; text-decoration: none; border-bottom: 0px rgb(10, 10, 10);\" style=\"margin: 0px 0px 12px; border-bottom: 0px rgb(10, 10, 10);\"><span class=\"iNqyIf\" data-sfc-cp=\"\" jsaction=\"\" jscontroller=\"KdQfFc#d5Qebf\" data-sfc-root=\"ep\" jsuid=\"tcCwGe_36\" data-complete=\"true\" data-copy-service-computed-style=\"font-family: &quot;Google Sans&quot;, Arial, sans-serif, &quot;Noto Color Emoji&quot;; font-size: 16px; font-weight: 400; margin: 0px; text-decoration: none; border-bottom: 0px rgb(10, 10, 10);\" style=\"margin: 0px; border-bottom: 0px rgb(10, 10, 10);\"><span class=\"rQesXe MPyX\" data-sfc-cp=\"\" jsaction=\"\" jscontroller=\"tP2kf#s32ZS\" data-sfc-root=\"ep\" jsuid=\"tcCwGe_37\" data-complete=\"true\" data-copy-service-computed-style=\"font-family: &quot;Google Sans&quot;, Arial, sans-serif, &quot;Noto Color Emoji&quot;; font-size: 16px; font-weight: 700; margin: 0px; text-decoration: none; border-bottom: 0px rgb(10, 10, 10);\" style=\"font-weight: 700; margin: 0px; border-bottom: 0px rgb(10, 10, 10);\">Health Monitoring:<!--TgQPHd|||[]--></span> All-day heart rate tracking, blood oxygen (SpO₂) monitoring, stress tracking, and sleep analysis<span data-copy-service-computed-style=\"font-family: &quot;Google Sans&quot;, Arial, sans-serif, &quot;Noto Color Emoji&quot;; font-size: 16px; font-weight: 400; margin: 0px; text-decoration: none; border-bottom: 0px rgb(10, 10, 10);\" style=\"margin: 0px; border-bottom: 0px rgb(10, 10, 10);\">.</span><!--TgQPHd|||[]--></span><span data-copy-service-computed-style=\"font-family: &quot;Google Sans&quot;, Arial, sans-serif, &quot;Noto Color Emoji&quot;; font-size: 16px; font-weight: 400; margin: 0px; text-decoration: none; border-bottom: 0px rgb(10, 10, 10);\" style=\"margin: 0px; border-bottom: 0px rgb(10, 10, 10);\"> [<a href=\"https://dazzle.com.bd/product/xiaomi-watch-s3\">1</a>, <a href=\"https://www.youtube.com/watch?v=RBKTeRf5SGE\">2</a>, <a href=\"https://www.mi.com/ph/support/faq/details/KA-92489/\">3</a>]</span><!--TgQPHd|||[]--></li><!--TgQPHd|||[]--></div><span data-copy-service-computed-style=\"font-family: &quot;Google Sans&quot;, Arial, sans-serif, &quot;Noto Color Emoji&quot;; font-size: 16px; font-weight: 400; margin: 0px; text-decoration: none; border-bottom: 0px rgb(10, 10, 10);\" style=\"margin: 0px; border-bottom: 0px rgb(10, 10, 10);\"><div data-bfc=\"\" class=\"\" data-sfc-cp=\"\" jsaction=\"\" jscontroller=\"eHDDzf#DtOdcb\" data-sfc-root=\"ep\" jsuid=\"tcCwGe_7l\" data-ved=\"2ahUKEwj53dPom_2WAxUqa2wGHUrWNgIQi4wTegoIAggACAAIMBAA\" data-hveid=\"CAIIAAgACDAQAA\" data-complete=\"true\" data-copy-service-computed-style=\"font-family: &quot;Google Sans&quot;, Arial, sans-serif, &quot;Noto Color Emoji&quot;; font-size: 16px; font-weight: 400; margin: 0px; text-decoration: none; border-bottom: 0px rgb(10, 10, 10);\" style=\"margin: 0px; border-bottom: 0px rgb(10, 10, 10);\"><li class=\"Z1qcYe\" data-sfc-cp=\"\" jsaction=\"\" jscontroller=\"oSLmPe#HokZ0d\" data-sfc-root=\"ep\" jsuid=\"tcCwGe_7m\" data-hveid=\"CAIIAAgACDAQAQ\" data-complete=\"true\" data-copy-service-computed-style=\"font-family: &quot;Google Sans&quot;, Arial, sans-serif, &quot;Noto Color Emoji&quot;; font-size: 16px; font-weight: 400; margin: 0px 0px 12px; text-decoration: none; border-bottom: 0px rgb(10, 10, 10);\" style=\"margin: 0px 0px 12px; border-bottom: 0px rgb(10, 10, 10);\"><span class=\"iNqyIf\" data-sfc-cp=\"\" jsaction=\"\" jscontroller=\"KdQfFc#d5Qebf\" data-sfc-root=\"ep\" jsuid=\"tcCwGe_7n\" data-complete=\"true\" data-copy-service-computed-style=\"font-family: &quot;Google Sans&quot;, Arial, sans-serif, &quot;Noto Color Emoji&quot;; font-size: 16px; font-weight: 400; margin: 0px; text-decoration: none; border-bottom: 0px rgb(10, 10, 10);\" style=\"margin: 0px; border-bottom: 0px rgb(10, 10, 10);\"><span class=\"rQesXe MPyX\" data-sfc-cp=\"\" jsaction=\"\" jscontroller=\"tP2kf#s32ZS\" data-sfc-root=\"ep\" jsuid=\"tcCwGe_7o\" data-complete=\"true\" data-copy-service-computed-style=\"font-family: &quot;Google Sans&quot;, Arial, sans-serif, &quot;Noto Color Emoji&quot;; font-size: 16px; font-weight: 700; margin: 0px; text-decoration: none; border-bottom: 0px rgb(10, 10, 10);\" style=\"font-weight: 700; margin: 0px; border-bottom: 0px rgb(10, 10, 10);\">Water Resistance:<!--TgQPHd|||[]--></span> 5ATM rating, making it safe for swimming.<!--TgQPHd|||[]--></span> [<a href=\"https://www.mi.com/ph/support/faq/details/KA-92489/\">1</a>, <a href=\"https://gadgetbd.com/product/xiaomi-watch-s3/\">2</a>, <a href=\"https://www.wired.com/review/xiaomi-watch-s3/\">3</a>]<!--TgQPHd|||[]--></li><!--TgQPHd|||[]--></div></span><!--TgQPHd|||[]--></ul><span data-copy-service-computed-style=\"font-family: &quot;Google Sans&quot;, Arial, sans-serif, &quot;Noto Color Emoji&quot;; font-size: 16px; font-weight: 400; margin: 0px; text-decoration: none; border-bottom: 0px rgb(10, 10, 10);\" style=\"margin: 0px; border-bottom: 0px rgb(10, 10, 10);\"></span><span data-copy-service-computed-style=\"font-family: &quot;Google Sans&quot;, Arial, sans-serif, &quot;Noto Color Emoji&quot;; font-size: 16px; font-weight: 400; margin: 0px; text-decoration: none; border-bottom: 0px rgb(10, 10, 10);\" style=\"margin: 0px; border-bottom: 0px rgb(10, 10, 10);\"></span><span data-copy-service-computed-style=\"font-family: &quot;Google Sans&quot;, Arial, sans-serif, &quot;Noto Color Emoji&quot;; font-size: 16px; font-weight: 400; margin: 0px; text-decoration: none; border-bottom: 0px rgb(10, 10, 10);\" style=\"margin: 0px; border-bottom: 0px rgb(10, 10, 10);\"></span><span data-copy-service-computed-style=\"font-family: &quot;Google Sans&quot;, Arial, sans-serif, &quot;Noto Color Emoji&quot;; font-size: 16px; font-weight: 400; margin: 0px; text-decoration: none; border-bottom: 0px rgb(10, 10, 10);\" style=\"margin: 0px; border-bottom: 0px rgb(10, 10, 10);\"></span><span data-copy-service-computed-style=\"font-family: &quot;Google Sans&quot;, Arial, sans-serif, &quot;Noto Color Emoji&quot;; font-size: 16px; font-weight: 400; margin: 0px; text-decoration: none; border-bottom: 0px rgb(10, 10, 10);\" style=\"margin: 0px; border-bottom: 0px rgb(10, 10, 10);\"></span><span data-copy-service-computed-style=\"font-family: &quot;Google Sans&quot;, Arial, sans-serif, &quot;Noto Color Emoji&quot;; font-size: 16px; font-weight: 400; margin: 0px; text-decoration: none; border-bottom: 0px rgb(10, 10, 10);\" style=\"margin: 0px; border-bottom: 0px rgb(10, 10, 10);\"></span><span data-copy-service-computed-style=\"font-family: &quot;Google Sans&quot;, Arial, sans-serif, &quot;Noto Color Emoji&quot;; font-size: 16px; font-weight: 400; margin: 0px; text-decoration: none; border-bottom: 0px rgb(10, 10, 10);\" style=\"margin: 0px; border-bottom: 0px rgb(10, 10, 10);\"></span><span data-copy-service-computed-style=\"font-family: &quot;Google Sans&quot;, Arial, sans-serif, &quot;Noto Color Emoji&quot;; font-size: 16px; font-weight: 400; margin: 0px; text-decoration: none; border-bottom: 0px rgb(10, 10, 10);\" style=\"margin: 0px; border-bottom: 0px rgb(10, 10, 10);\"></span><span data-copy-service-computed-style=\"font-family: &quot;Google Sans&quot;, Arial, sans-serif, &quot;Noto Color Emoji&quot;; font-size: 16px; font-weight: 400; margin: 0px; text-decoration: none; border-bottom: 0px rgb(10, 10, 10);\" style=\"margin: 0px; border-bottom: 0px rgb(10, 10, 10);\"></span><span data-copy-service-computed-style=\"font-family: &quot;Google Sans&quot;, Arial, sans-serif, &quot;Noto Color Emoji&quot;; font-size: 16px; font-weight: 400; margin: 0px; text-decoration: none; border-bottom: 0px rgb(10, 10, 10);\" style=\"margin: 0px; border-bottom: 0px rgb(10, 10, 10);\"></span><span data-copy-service-computed-style=\"font-family: &quot;Google Sans&quot;, Arial, sans-serif, &quot;Noto Color Emoji&quot;; font-size: 16px; font-weight: 400; margin: 0px; text-decoration: none; border-bottom: 0px rgb(10, 10, 10);\" style=\"margin: 0px; border-bottom: 0px rgb(10, 10, 10);\"></span><span data-copy-service-computed-style=\"font-family: &quot;Google Sans&quot;, Arial, sans-serif, &quot;Noto Color Emoji&quot;; font-size: 16px; font-weight: 400; margin: 0px; text-decoration: none; border-bottom: 0px rgb(10, 10, 10);\" style=\"margin: 0px; border-bottom: 0px rgb(10, 10, 10);\"></span><span data-copy-service-computed-style=\"font-family: &quot;Google Sans&quot;, Arial, sans-serif, &quot;Noto Color Emoji&quot;; font-size: 16px; font-weight: 400; margin: 0px; text-decoration: none; border-bottom: 0px rgb(10, 10, 10);\" style=\"margin: 0px; border-bottom: 0px rgb(10, 10, 10);\"></span><span data-copy-service-computed-style=\"font-family: &quot;Google Sans&quot;, Arial, sans-serif, &quot;Noto Color Emoji&quot;; font-size: 16px; font-weight: 400; margin: 0px; text-decoration: none; border-bottom: 0px rgb(10, 10, 10);\" style=\"margin: 0px; border-bottom: 0px rgb(10, 10, 10);\"></span><span data-copy-service-computed-style=\"font-family: &quot;Google Sans&quot;, Arial, sans-serif, &quot;Noto Color Emoji&quot;; font-size: 16px; font-weight: 400; margin: 0px; text-decoration: none; border-bottom: 0px rgb(10, 10, 10);\" style=\"margin: 0px; border-bottom: 0px rgb(10, 10, 10);\"></span><span data-copy-service-computed-style=\"font-family: &quot;Google Sans&quot;, Arial, sans-serif, &quot;Noto Color Emoji&quot;; font-size: 16px; font-weight: 400; margin: 0px; text-decoration: none; border-bottom: 0px rgb(10, 10, 10);\" style=\"margin: 0px; border-bottom: 0px rgb(10, 10, 10);\"></span><span data-copy-service-computed-style=\"font-family: &quot;Google Sans&quot;, Arial, sans-serif, &quot;Noto Color Emoji&quot;; font-size: 16px; font-weight: 400; margin: 0px; text-decoration: none; border-bottom: 0px rgb(10, 10, 10);\" style=\"margin: 0px; border-bottom: 0px rgb(10, 10, 10);\"></span><span data-copy-service-computed-style=\"font-family: &quot;Google Sans&quot;, Arial, sans-serif, &quot;Noto Color Emoji&quot;; font-size: 16px; font-weight: 400; margin: 0px; text-decoration: none; border-bottom: 0px rgb(10, 10, 10);\" style=\"margin: 0px; border-bottom: 0px rgb(10, 10, 10);\"></span><span data-copy-service-computed-style=\"font-family: &quot;Google Sans&quot;, Arial, sans-serif, &quot;Noto Color Emoji&quot;; font-size: 16px; font-weight: 400; margin: 0px; text-decoration: none; border-bottom: 0px rgb(10, 10, 10);\" style=\"margin: 0px; border-bottom: 0px rgb(10, 10, 10);\"></span><span data-copy-service-computed-style=\"font-family: &quot;Google Sans&quot;, Arial, sans-serif, &quot;Noto Color Emoji&quot;; font-size: 16px; font-weight: 400; margin: 0px; text-decoration: none; border-bottom: 0px rgb(10, 10, 10);\" style=\"margin: 0px; border-bottom: 0px rgb(10, 10, 10);\"></span><span data-copy-service-computed-style=\"font-family: &quot;Google Sans&quot;, Arial, sans-serif, &quot;Noto Color Emoji&quot;; font-size: 16px; font-weight: 400; margin: 0px; text-decoration: none; border-bottom: 0px rgb(10, 10, 10);\" style=\"margin: 0px; border-bottom: 0px rgb(10, 10, 10);\"><div class=\"yhAwj\" data-sfc-cp=\"\" jsaction=\"rcuQ6b:&amp;tcCwGe_8f|npT2md\" jscontroller=\"UTzWVc#U8DOt\" data-sfc-root=\"ep\" jsuid=\"tcCwGe_8f\" data-complete=\"true\" data-sfc-inited=\"2\" data-copy-service-computed-style=\"font-family: &quot;Google Sans&quot;, Arial, sans-serif, &quot;Noto Color Emoji&quot;; font-size: 16px; font-weight: 400; margin: 0px; text-decoration: none; border-bottom: 0px rgb(10, 10, 10);\" style=\"margin: 0px; border-bottom: 0px rgb(10, 10, 10);\"><!--TgQPHd|||[]--></div></span><span data-copy-service-computed-style=\"font-family: &quot;Google Sans&quot;, Arial, sans-serif, &quot;Noto Color Emoji&quot;; font-size: 16px; font-weight: 400; margin: 0px; text-decoration: none; border-bottom: 0px rgb(10, 10, 10);\" style=\"margin: 0px; border-bottom: 0px rgb(10, 10, 10);\"><div data-bfc=\"\" class=\"\" data-sfc-cp=\"\" jsaction=\"\" jscontroller=\"eHDDzf#DtOdcb\" data-sfc-root=\"ep\" jsuid=\"tcCwGe_8g\" data-ved=\"2ahUKEwj53dPom_2WAxUqa2wGHUrWNgIQi4wTegoIAggACAAIMRAA\" data-hveid=\"CAIIAAgACDEQAA\" data-complete=\"true\" data-copy-service-computed-style=\"font-family: &quot;Google Sans&quot;, Arial, sans-serif, &quot;Noto Color Emoji&quot;; font-size: 16px; font-weight: 400; margin: 0px; text-decoration: none; border-bottom: 0px rgb(10, 10, 10);\" style=\"margin: 0px; border-bottom: 0px rgb(10, 10, 10);\"><div class=\"AHmQrc\" data-sfc-cp=\"\" jsaction=\"\" jscontroller=\"LkYPVc#wdvZmf\" data-sfc-root=\"ep\" jsuid=\"tcCwGe_8h\" data-hveid=\"CAIIAAgACDEQAQ\" data-complete=\"true\" data-copy-service-computed-style=\"font-family: &quot;Google Sans&quot;, Arial, sans-serif, &quot;Noto Color Emoji&quot;; font-size: 16px; font-weight: 400; margin: 0px; text-decoration: none; border-bottom: 0px rgb(10, 10, 10);\" style=\"margin: 0px; border-bottom: 0px rgb(10, 10, 10);\"><div class=\"n6owBd awi2gc\" data-sfc-cp=\"\" jsaction=\"\" jscontroller=\"TDBkbc#Ml18Xb\" data-sfc-root=\"ep\" jsuid=\"tcCwGe_8i\" data-hveid=\"CAIIAAgACDEQAg\" data-complete=\"true\" data-copy-service-computed-style=\"font-family: &quot;Google Sans&quot;, Arial, sans-serif, &quot;Noto Color Emoji&quot;; font-size: 16px; font-weight: 400; margin: 12px 0px 16px; text-decoration: none; border-bottom: 0px rgb(10, 10, 10);\" style=\"margin: 12px 0px 16px; border-bottom: 0px rgb(10, 10, 10);\">To help you further, would you like to know more about its <span class=\"rQesXe MPyX\" data-sfc-cp=\"\" jsaction=\"\" jscontroller=\"tP2kf#s32ZS\" data-sfc-root=\"ep\" jsuid=\"tcCwGe_8j\" data-complete=\"true\" data-copy-service-computed-style=\"font-family: &quot;Google Sans&quot;, Arial, sans-serif, &quot;Noto Color Emoji&quot;; font-size: 16px; font-weight: 700; margin: 0px; text-decoration: none; border-bottom: 0px rgb(10, 10, 10);\" style=\"font-weight: 700; margin: 0px; border-bottom: 0px rgb(10, 10, 10);\">compatibility<!--TgQPHd|||[]--></span> with your phone, <span class=\"rQesXe MPyX\" data-sfc-cp=\"\" jsaction=\"\" jscontroller=\"tP2kf#s32ZS\" data-sfc-root=\"ep\" jsuid=\"tcCwGe_8k\" data-complete=\"true\" data-copy-service-computed-style=\"font-family: &quot;Google Sans&quot;, Arial, sans-serif, &quot;Noto Color Emoji&quot;; font-size: 16px; font-weight: 700; margin: 0px; text-decoration: none; border-bottom: 0px rgb(10, 10, 10);\" style=\"font-weight: 700; margin: 0px; border-bottom: 0px rgb(10, 10, 10);\">price and availability<!--TgQPHd|||[]--></span> in Bangladesh, or a comparison with other smartwatch models?<!--TgQPHd|||[]--></div><!--TgQPHd|||[]--></div><!--TgQPHd|||[]--></div></span><span data-copy-service-computed-style=\"font-family: &quot;Google Sans&quot;, Arial, sans-serif, &quot;Noto Color Emoji&quot;; font-size: 16px; font-weight: 400; margin: 0px; text-decoration: none; border-bottom: 0px rgb(10, 10, 10);\" style=\"margin: 0px; border-bottom: 0px rgb(10, 10, 10);\"><div class=\"yhAwj\" data-sfc-cp=\"\" jsaction=\"rcuQ6b:&amp;tcCwGe_8q|npT2md\" jscontroller=\"UTzWVc#U8DOt\" data-sfc-root=\"ep\" jsuid=\"tcCwGe_8q\" data-complete=\"true\" data-sfc-inited=\"2\" data-copy-service-computed-style=\"font-family: &quot;Google Sans&quot;, Arial, sans-serif, &quot;Noto Color Emoji&quot;; font-size: 16px; font-weight: 400; margin: 0px; text-decoration: none; border-bottom: 0px rgb(10, 10, 10);\" style=\"margin: 0px; border-bottom: 0px rgb(10, 10, 10);\"><!--TgQPHd|||[]--></div></span><span data-copy-service-computed-style=\"font-family: &quot;Google Sans&quot;, Arial, sans-serif, &quot;Noto Color Emoji&quot;; font-size: 16px; font-weight: 400; margin: 0px; text-decoration: none; border-bottom: 0px rgb(10, 10, 10);\" style=\"margin: 0px; border-bottom: 0px rgb(10, 10, 10);\"><div class=\"yhAwj\" data-sfc-cp=\"\" jsaction=\"rcuQ6b:&amp;tcCwGe_8r|npT2md\" jscontroller=\"UTzWVc#U8DOt\" data-sfc-root=\"ep\" jsuid=\"tcCwGe_8r\" data-complete=\"true\" data-sfc-inited=\"2\" data-copy-service-computed-style=\"font-family: &quot;Google Sans&quot;, Arial, sans-serif, &quot;Noto Color Emoji&quot;; font-size: 16px; font-weight: 400; margin: 0px; text-decoration: none; border-bottom: 0px rgb(10, 10, 10);\" style=\"margin: 0px; border-bottom: 0px rgb(10, 10, 10);\"><!--TgQPHd|||[]--></div></span></span><!--TgQPHd|||[]--></div><!--TgQPHd|||[]--></div><div class=\"\" jsaction=\"\" jscontroller=\"zp3Dsd#fP0RJ\" data-sfc-root=\"ep\" jsuid=\"tcCwGe_8\" data-complete=\"true\" data-copy-service-computed-style=\"font-family: &quot;Google Sans&quot;, Arial, sans-serif, &quot;Noto Color Emoji&quot;; font-size: 16px; font-weight: 400; margin: 0px; text-decoration: none; border-bottom: 0px rgb(10, 10, 10);\" style=\"font-family: &quot;Google Sans&quot;, Arial, sans-serif, &quot;Noto Color Emoji&quot;; font-size: 16px; margin: 0px; border-bottom: 0px rgb(10, 10, 10);\"><div data-container-id=\"rhs-col\" data-ignore-copy=\"\" class=\"ofHStc Dn7Fzd OIPUDf\" jsaction=\"aimRenderComplete:&amp;tcCwGe_9|ZUljYd;rcuQ6b:&amp;tcCwGe_9|npT2md\" jscontroller=\"Oh6VO#OPWA4e\" data-sfc-root=\"ep\" jsuid=\"tcCwGe_9\" data-ved=\"2ahUKEwj53dPom_2WAxUqa2wGHUrWNgIQ3aYQegoIAggACAAIAhAC\" data-sfc-inited=\"2\" data-copy-service-computed-style=\"font-family: &quot;Google Sans&quot;, Arial, sans-serif, &quot;Noto Color Emoji&quot;; font-size: 16px; font-weight: 400; margin: 0px; text-decoration: none; border-bottom: 0px rgb(10, 10, 10);\" style=\"margin: 0px; border-bottom: 0px rgb(10, 10, 10);\"><span data-copy-service-computed-style=\"font-family: &quot;Google Sans&quot;, Arial, sans-serif, &quot;Noto Color Emoji&quot;; font-size: 16px; font-weight: 400; margin: 0px; text-decoration: none; border-bottom: 0px rgb(10, 10, 10);\" style=\"margin: 0px; border-bottom: 0px rgb(10, 10, 10);\"><div class=\"ub891 notranslate\" data-animation-skip=\"\" jsuid=\"tcCwGe_15\" dir=\"ltr\" data-xid=\"aim-aside-initial-corroboration-container\" data-ignore-copy=\"\" data-sfc-cp=\"\" jsaction=\"aimThreadsViewStateChange:&amp;tcCwGe_15|ZUljYd;rcuQ6b:&amp;tcCwGe_15|npT2md\" jscontroller=\"iuhW0b#IjGble\" data-sfc-root=\"ep\" data-wiz-uids=\"tcCwGe_16,tcCwGe_17,tcCwGe_18\" data-complete=\"true\" data-sfc-inited=\"2\" data-copy-service-computed-style=\"font-family: &quot;Google Sans&quot;, Arial, sans-serif, &quot;Noto Color Emoji&quot;; font-size: 16px; font-weight: 400; margin: 0px; text-decoration: none; border-bottom: 0px rgb(10, 10, 10);\" style=\"margin: 0px; border-bottom: 0px rgb(10, 10, 10);\"><div class=\"nLDHre\" data-ved=\"2ahUKEwj53dPom_2WAxUqa2wGHUrWNgIQ_YQPegoIAggACAAIGhAA\" data-copy-service-computed-style=\"font-family: &quot;Google Sans&quot;, Arial, sans-serif, &quot;Noto Color Emoji&quot;; font-size: 16px; font-weight: 400; margin: 0px; text-decoration: none; border-bottom: 1px solid rgb(210, 210, 210);\" style=\"margin: 0px; border-bottom: 1px solid rgb(210, 210, 210);\"><span jsuid=\"tcCwGe_19\" jsaction=\"rcuQ6b:&amp;tcCwGe_19|npT2md\" jscontroller=\"x5974b#yV2pad\" data-sfc-root=\"c\" data-complete=\"true\" data-sfc-inited=\"1\" data-copy-service-computed-style=\"font-family: &quot;Google Sans&quot;, Arial, sans-serif, &quot;Noto Color Emoji&quot;; font-size: 16px; font-weight: 400; margin: 0px; text-decoration: none; border-bottom: 0px rgb(10, 10, 10);\" style=\"margin: 0px; border-bottom: 0px rgb(10, 10, 10);\"></span><div class=\"raGCNe\" data-copy-service-computed-style=\"font-family: &quot;Google Sans&quot;, Arial, sans-serif, &quot;Noto Color Emoji&quot;; font-size: 16px; font-weight: 400; margin: 0px; text-decoration: none; border-bottom: 0px rgb(10, 10, 10);\" style=\"margin: 0px; border-bottom: 0px rgb(10, 10, 10);\"></div></div></div></span></div></div>', 'Xiaomi Watch S3', 4500.00, 4100.00, NULL, NULL, 0, 'vendor', 'products/thumbnails/HMdr3gKIXtc3JRk5GtK5N7peTCM51AOSCWSBXMNy.png', NULL, 'draft', 1, 0, 0, 0, '2026-09-20 07:03:15', '2026-09-25 02:31:38', NULL);
INSERT INTO `products` (`id`, `vendor_id`, `category_id`, `sub_category_id`, `brand_id`, `name`, `slug`, `sku`, `description`, `short_description`, `price`, `discount_price`, `cost_price`, `tags`, `stock_quantity`, `product_type`, `thumbnail`, `sponsored_video_url`, `status`, `is_new`, `is_featured`, `is_hot`, `views_count`, `created_at`, `updated_at`, `deleted_at`) VALUES
(51, 2, 2, 23, 2, 'Premium Android Tablet', 'premium-android-tablet', NULL, '<p><span data-d-streaming-word=\"\" style=\"color: rgb(13, 13, 13); font-family: -apple-system-body, ui-sans-serif, -apple-system, system-ui, &quot;Segoe UI&quot;, Helvetica, &quot;Apple Color Emoji&quot;, Arial, sans-serif, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;; font-size: 16px; letter-spacing: normal; white-space: pre-line; background-color: rgb(252, 252, 252);\">This</span><span style=\"color: rgb(13, 13, 13); font-family: -apple-system-body, ui-sans-serif, -apple-system, system-ui, &quot;Segoe UI&quot;, Helvetica, &quot;Apple Color Emoji&quot;, Arial, sans-serif, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;; font-size: 16px; letter-spacing: normal; white-space: pre-line; background-color: rgb(252, 252, 252);\"> </span><span data-d-streaming-word=\"\" style=\"color: rgb(13, 13, 13); font-family: -apple-system-body, ui-sans-serif, -apple-system, system-ui, &quot;Segoe UI&quot;, Helvetica, &quot;Apple Color Emoji&quot;, Arial, sans-serif, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;; font-size: 16px; letter-spacing: normal; white-space: pre-line; background-color: rgb(252, 252, 252);\">premium</span><span style=\"color: rgb(13, 13, 13); font-family: -apple-system-body, ui-sans-serif, -apple-system, system-ui, &quot;Segoe UI&quot;, Helvetica, &quot;Apple Color Emoji&quot;, Arial, sans-serif, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;; font-size: 16px; letter-spacing: normal; white-space: pre-line; background-color: rgb(252, 252, 252);\"> </span><span data-d-streaming-word=\"\" style=\"color: rgb(13, 13, 13); font-family: -apple-system-body, ui-sans-serif, -apple-system, system-ui, &quot;Segoe UI&quot;, Helvetica, &quot;Apple Color Emoji&quot;, Arial, sans-serif, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;; font-size: 16px; letter-spacing: normal; white-space: pre-line; background-color: rgb(252, 252, 252);\">Android</span><span style=\"color: rgb(13, 13, 13); font-family: -apple-system-body, ui-sans-serif, -apple-system, system-ui, &quot;Segoe UI&quot;, Helvetica, &quot;Apple Color Emoji&quot;, Arial, sans-serif, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;; font-size: 16px; letter-spacing: normal; white-space: pre-line; background-color: rgb(252, 252, 252);\"> </span><span data-d-streaming-word=\"\" style=\"color: rgb(13, 13, 13); font-family: -apple-system-body, ui-sans-serif, -apple-system, system-ui, &quot;Segoe UI&quot;, Helvetica, &quot;Apple Color Emoji&quot;, Arial, sans-serif, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;; font-size: 16px; letter-spacing: normal; white-space: pre-line; background-color: rgb(252, 252, 252);\">tablet</span><span style=\"color: rgb(13, 13, 13); font-family: -apple-system-body, ui-sans-serif, -apple-system, system-ui, &quot;Segoe UI&quot;, Helvetica, &quot;Apple Color Emoji&quot;, Arial, sans-serif, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;; font-size: 16px; letter-spacing: normal; white-space: pre-line; background-color: rgb(252, 252, 252);\"> </span><span data-d-streaming-word=\"\" style=\"color: rgb(13, 13, 13); font-family: -apple-system-body, ui-sans-serif, -apple-system, system-ui, &quot;Segoe UI&quot;, Helvetica, &quot;Apple Color Emoji&quot;, Arial, sans-serif, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;; font-size: 16px; letter-spacing: normal; white-space: pre-line; background-color: rgb(252, 252, 252);\">offers</span><span style=\"color: rgb(13, 13, 13); font-family: -apple-system-body, ui-sans-serif, -apple-system, system-ui, &quot;Segoe UI&quot;, Helvetica, &quot;Apple Color Emoji&quot;, Arial, sans-serif, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;; font-size: 16px; letter-spacing: normal; white-space: pre-line; background-color: rgb(252, 252, 252);\"> </span><span data-d-streaming-word=\"\" style=\"color: rgb(13, 13, 13); font-family: -apple-system-body, ui-sans-serif, -apple-system, system-ui, &quot;Segoe UI&quot;, Helvetica, &quot;Apple Color Emoji&quot;, Arial, sans-serif, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;; font-size: 16px; letter-spacing: normal; white-space: pre-line; background-color: rgb(252, 252, 252);\">a</span><span style=\"color: rgb(13, 13, 13); font-family: -apple-system-body, ui-sans-serif, -apple-system, system-ui, &quot;Segoe UI&quot;, Helvetica, &quot;Apple Color Emoji&quot;, Arial, sans-serif, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;; font-size: 16px; letter-spacing: normal; white-space: pre-line; background-color: rgb(252, 252, 252);\"> </span><span data-d-streaming-word=\"\" style=\"color: rgb(13, 13, 13); font-family: -apple-system-body, ui-sans-serif, -apple-system, system-ui, &quot;Segoe UI&quot;, Helvetica, &quot;Apple Color Emoji&quot;, Arial, sans-serif, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;; font-size: 16px; letter-spacing: normal; white-space: pre-line; background-color: rgb(252, 252, 252);\">smooth</span><span style=\"color: rgb(13, 13, 13); font-family: -apple-system-body, ui-sans-serif, -apple-system, system-ui, &quot;Segoe UI&quot;, Helvetica, &quot;Apple Color Emoji&quot;, Arial, sans-serif, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;; font-size: 16px; letter-spacing: normal; white-space: pre-line; background-color: rgb(252, 252, 252);\"> </span><span data-d-streaming-word=\"\" style=\"color: rgb(13, 13, 13); font-family: -apple-system-body, ui-sans-serif, -apple-system, system-ui, &quot;Segoe UI&quot;, Helvetica, &quot;Apple Color Emoji&quot;, Arial, sans-serif, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;; font-size: 16px; letter-spacing: normal; white-space: pre-line; background-color: rgb(252, 252, 252);\">user</span><span style=\"color: rgb(13, 13, 13); font-family: -apple-system-body, ui-sans-serif, -apple-system, system-ui, &quot;Segoe UI&quot;, Helvetica, &quot;Apple Color Emoji&quot;, Arial, sans-serif, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;; font-size: 16px; letter-spacing: normal; white-space: pre-line; background-color: rgb(252, 252, 252);\"> </span><span data-d-streaming-word=\"\" style=\"color: rgb(13, 13, 13); font-family: -apple-system-body, ui-sans-serif, -apple-system, system-ui, &quot;Segoe UI&quot;, Helvetica, &quot;Apple Color Emoji&quot;, Arial, sans-serif, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;; font-size: 16px; letter-spacing: normal; white-space: pre-line; background-color: rgb(252, 252, 252);\">experience</span><span style=\"color: rgb(13, 13, 13); font-family: -apple-system-body, ui-sans-serif, -apple-system, system-ui, &quot;Segoe UI&quot;, Helvetica, &quot;Apple Color Emoji&quot;, Arial, sans-serif, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;; font-size: 16px; letter-spacing: normal; white-space: pre-line; background-color: rgb(252, 252, 252);\"> </span><span data-d-streaming-word=\"\" style=\"color: rgb(13, 13, 13); font-family: -apple-system-body, ui-sans-serif, -apple-system, system-ui, &quot;Segoe UI&quot;, Helvetica, &quot;Apple Color Emoji&quot;, Arial, sans-serif, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;; font-size: 16px; letter-spacing: normal; white-space: pre-line; background-color: rgb(252, 252, 252);\">with</span><span style=\"color: rgb(13, 13, 13); font-family: -apple-system-body, ui-sans-serif, -apple-system, system-ui, &quot;Segoe UI&quot;, Helvetica, &quot;Apple Color Emoji&quot;, Arial, sans-serif, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;; font-size: 16px; letter-spacing: normal; white-space: pre-line; background-color: rgb(252, 252, 252);\"> </span><span data-d-streaming-word=\"\" style=\"color: rgb(13, 13, 13); font-family: -apple-system-body, ui-sans-serif, -apple-system, system-ui, &quot;Segoe UI&quot;, Helvetica, &quot;Apple Color Emoji&quot;, Arial, sans-serif, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;; font-size: 16px; letter-spacing: normal; white-space: pre-line; background-color: rgb(252, 252, 252);\">a</span><span style=\"color: rgb(13, 13, 13); font-family: -apple-system-body, ui-sans-serif, -apple-system, system-ui, &quot;Segoe UI&quot;, Helvetica, &quot;Apple Color Emoji&quot;, Arial, sans-serif, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;; font-size: 16px; letter-spacing: normal; white-space: pre-line; background-color: rgb(252, 252, 252);\"> </span><span data-d-streaming-word=\"\" style=\"color: rgb(13, 13, 13); font-family: -apple-system-body, ui-sans-serif, -apple-system, system-ui, &quot;Segoe UI&quot;, Helvetica, &quot;Apple Color Emoji&quot;, Arial, sans-serif, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;; font-size: 16px; letter-spacing: normal; white-space: pre-line; background-color: rgb(252, 252, 252);\">large</span><span style=\"color: rgb(13, 13, 13); font-family: -apple-system-body, ui-sans-serif, -apple-system, system-ui, &quot;Segoe UI&quot;, Helvetica, &quot;Apple Color Emoji&quot;, Arial, sans-serif, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;; font-size: 16px; letter-spacing: normal; white-space: pre-line; background-color: rgb(252, 252, 252);\"> </span><span data-d-streaming-word=\"\" style=\"color: rgb(13, 13, 13); font-family: -apple-system-body, ui-sans-serif, -apple-system, system-ui, &quot;Segoe UI&quot;, Helvetica, &quot;Apple Color Emoji&quot;, Arial, sans-serif, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;; font-size: 16px; letter-spacing: normal; white-space: pre-line; background-color: rgb(252, 252, 252);\">display</span><span style=\"color: rgb(13, 13, 13); font-family: -apple-system-body, ui-sans-serif, -apple-system, system-ui, &quot;Segoe UI&quot;, Helvetica, &quot;Apple Color Emoji&quot;, Arial, sans-serif, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;; font-size: 16px; letter-spacing: normal; white-space: pre-line; background-color: rgb(252, 252, 252);\"> </span><span data-d-streaming-word=\"\" style=\"color: rgb(13, 13, 13); font-family: -apple-system-body, ui-sans-serif, -apple-system, system-ui, &quot;Segoe UI&quot;, Helvetica, &quot;Apple Color Emoji&quot;, Arial, sans-serif, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;; font-size: 16px; letter-spacing: normal; white-space: pre-line; background-color: rgb(252, 252, 252);\">and</span><span style=\"color: rgb(13, 13, 13); font-family: -apple-system-body, ui-sans-serif, -apple-system, system-ui, &quot;Segoe UI&quot;, Helvetica, &quot;Apple Color Emoji&quot;, Arial, sans-serif, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;; font-size: 16px; letter-spacing: normal; white-space: pre-line; background-color: rgb(252, 252, 252);\"> </span><span data-d-streaming-word=\"\" style=\"color: rgb(13, 13, 13); font-family: -apple-system-body, ui-sans-serif, -apple-system, system-ui, &quot;Segoe UI&quot;, Helvetica, &quot;Apple Color Emoji&quot;, Arial, sans-serif, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;; font-size: 16px; letter-spacing: normal; white-space: pre-line; background-color: rgb(252, 252, 252);\">modern</span><span style=\"color: rgb(13, 13, 13); font-family: -apple-system-body, ui-sans-serif, -apple-system, system-ui, &quot;Segoe UI&quot;, Helvetica, &quot;Apple Color Emoji&quot;, Arial, sans-serif, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;; font-size: 16px; letter-spacing: normal; white-space: pre-line; background-color: rgb(252, 252, 252);\"> </span><span data-d-streaming-word=\"\" style=\"color: rgb(13, 13, 13); font-family: -apple-system-body, ui-sans-serif, -apple-system, system-ui, &quot;Segoe UI&quot;, Helvetica, &quot;Apple Color Emoji&quot;, Arial, sans-serif, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;; font-size: 16px; letter-spacing: normal; white-space: pre-line; background-color: rgb(252, 252, 252);\">design.</span><span style=\"color: rgb(13, 13, 13); font-family: -apple-system-body, ui-sans-serif, -apple-system, system-ui, &quot;Segoe UI&quot;, Helvetica, &quot;Apple Color Emoji&quot;, Arial, sans-serif, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;; font-size: 16px; letter-spacing: normal; white-space: pre-line; background-color: rgb(252, 252, 252);\"> </span><span data-d-streaming-word=\"\" style=\"color: rgb(13, 13, 13); font-family: -apple-system-body, ui-sans-serif, -apple-system, system-ui, &quot;Segoe UI&quot;, Helvetica, &quot;Apple Color Emoji&quot;, Arial, sans-serif, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;; font-size: 16px; letter-spacing: normal; white-space: pre-line; background-color: rgb(252, 252, 252);\">It</span><span style=\"color: rgb(13, 13, 13); font-family: -apple-system-body, ui-sans-serif, -apple-system, system-ui, &quot;Segoe UI&quot;, Helvetica, &quot;Apple Color Emoji&quot;, Arial, sans-serif, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;; font-size: 16px; letter-spacing: normal; white-space: pre-line; background-color: rgb(252, 252, 252);\"> </span><span data-d-streaming-word=\"\" style=\"color: rgb(13, 13, 13); font-family: -apple-system-body, ui-sans-serif, -apple-system, system-ui, &quot;Segoe UI&quot;, Helvetica, &quot;Apple Color Emoji&quot;, Arial, sans-serif, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;; font-size: 16px; letter-spacing: normal; white-space: pre-line; background-color: rgb(252, 252, 252);\">is</span><span style=\"color: rgb(13, 13, 13); font-family: -apple-system-body, ui-sans-serif, -apple-system, system-ui, &quot;Segoe UI&quot;, Helvetica, &quot;Apple Color Emoji&quot;, Arial, sans-serif, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;; font-size: 16px; letter-spacing: normal; white-space: pre-line; background-color: rgb(252, 252, 252);\"> </span><span data-d-streaming-word=\"\" style=\"color: rgb(13, 13, 13); font-family: -apple-system-body, ui-sans-serif, -apple-system, system-ui, &quot;Segoe UI&quot;, Helvetica, &quot;Apple Color Emoji&quot;, Arial, sans-serif, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;; font-size: 16px; letter-spacing: normal; white-space: pre-line; background-color: rgb(252, 252, 252);\">suitable</span><span style=\"color: rgb(13, 13, 13); font-family: -apple-system-body, ui-sans-serif, -apple-system, system-ui, &quot;Segoe UI&quot;, Helvetica, &quot;Apple Color Emoji&quot;, Arial, sans-serif, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;; font-size: 16px; letter-spacing: normal; white-space: pre-line; background-color: rgb(252, 252, 252);\"> </span><span data-d-streaming-word=\"\" style=\"color: rgb(13, 13, 13); font-family: -apple-system-body, ui-sans-serif, -apple-system, system-ui, &quot;Segoe UI&quot;, Helvetica, &quot;Apple Color Emoji&quot;, Arial, sans-serif, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;; font-size: 16px; letter-spacing: normal; white-space: pre-line; background-color: rgb(252, 252, 252);\">for</span><span style=\"color: rgb(13, 13, 13); font-family: -apple-system-body, ui-sans-serif, -apple-system, system-ui, &quot;Segoe UI&quot;, Helvetica, &quot;Apple Color Emoji&quot;, Arial, sans-serif, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;; font-size: 16px; letter-spacing: normal; white-space: pre-line; background-color: rgb(252, 252, 252);\"> </span><span data-d-streaming-word=\"\" style=\"color: rgb(13, 13, 13); font-family: -apple-system-body, ui-sans-serif, -apple-system, system-ui, &quot;Segoe UI&quot;, Helvetica, &quot;Apple Color Emoji&quot;, Arial, sans-serif, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;; font-size: 16px; letter-spacing: normal; white-space: pre-line; background-color: rgb(252, 252, 252);\">watching</span><span style=\"color: rgb(13, 13, 13); font-family: -apple-system-body, ui-sans-serif, -apple-system, system-ui, &quot;Segoe UI&quot;, Helvetica, &quot;Apple Color Emoji&quot;, Arial, sans-serif, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;; font-size: 16px; letter-spacing: normal; white-space: pre-line; background-color: rgb(252, 252, 252);\"> </span><span data-d-streaming-word=\"\" style=\"color: rgb(13, 13, 13); font-family: -apple-system-body, ui-sans-serif, -apple-system, system-ui, &quot;Segoe UI&quot;, Helvetica, &quot;Apple Color Emoji&quot;, Arial, sans-serif, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;; font-size: 16px; letter-spacing: normal; white-space: pre-line; background-color: rgb(252, 252, 252);\">videos,</span><span style=\"color: rgb(13, 13, 13); font-family: -apple-system-body, ui-sans-serif, -apple-system, system-ui, &quot;Segoe UI&quot;, Helvetica, &quot;Apple Color Emoji&quot;, Arial, sans-serif, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;; font-size: 16px; letter-spacing: normal; white-space: pre-line; background-color: rgb(252, 252, 252);\"> </span><span data-d-streaming-word=\"\" style=\"color: rgb(13, 13, 13); font-family: -apple-system-body, ui-sans-serif, -apple-system, system-ui, &quot;Segoe UI&quot;, Helvetica, &quot;Apple Color Emoji&quot;, Arial, sans-serif, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;; font-size: 16px; letter-spacing: normal; white-space: pre-line; background-color: rgb(252, 252, 252);\">browsing</span><span style=\"color: rgb(13, 13, 13); font-family: -apple-system-body, ui-sans-serif, -apple-system, system-ui, &quot;Segoe UI&quot;, Helvetica, &quot;Apple Color Emoji&quot;, Arial, sans-serif, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;; font-size: 16px; letter-spacing: normal; white-space: pre-line; background-color: rgb(252, 252, 252);\"> </span><span data-d-streaming-word=\"\" style=\"color: rgb(13, 13, 13); font-family: -apple-system-body, ui-sans-serif, -apple-system, system-ui, &quot;Segoe UI&quot;, Helvetica, &quot;Apple Color Emoji&quot;, Arial, sans-serif, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;; font-size: 16px; letter-spacing: normal; white-space: pre-line; background-color: rgb(252, 252, 252);\">the</span><span style=\"color: rgb(13, 13, 13); font-family: -apple-system-body, ui-sans-serif, -apple-system, system-ui, &quot;Segoe UI&quot;, Helvetica, &quot;Apple Color Emoji&quot;, Arial, sans-serif, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;; font-size: 16px; letter-spacing: normal; white-space: pre-line; background-color: rgb(252, 252, 252);\"> </span><span data-d-streaming-word=\"\" style=\"color: rgb(13, 13, 13); font-family: -apple-system-body, ui-sans-serif, -apple-system, system-ui, &quot;Segoe UI&quot;, Helvetica, &quot;Apple Color Emoji&quot;, Arial, sans-serif, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;; font-size: 16px; letter-spacing: normal; white-space: pre-line; background-color: rgb(252, 252, 252);\">internet,</span><span style=\"color: rgb(13, 13, 13); font-family: -apple-system-body, ui-sans-serif, -apple-system, system-ui, &quot;Segoe UI&quot;, Helvetica, &quot;Apple Color Emoji&quot;, Arial, sans-serif, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;; font-size: 16px; letter-spacing: normal; white-space: pre-line; background-color: rgb(252, 252, 252);\"> </span><span data-d-streaming-word=\"\" style=\"color: rgb(13, 13, 13); font-family: -apple-system-body, ui-sans-serif, -apple-system, system-ui, &quot;Segoe UI&quot;, Helvetica, &quot;Apple Color Emoji&quot;, Arial, sans-serif, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;; font-size: 16px; letter-spacing: normal; white-space: pre-line; background-color: rgb(252, 252, 252);\">reading</span><span style=\"color: rgb(13, 13, 13); font-family: -apple-system-body, ui-sans-serif, -apple-system, system-ui, &quot;Segoe UI&quot;, Helvetica, &quot;Apple Color Emoji&quot;, Arial, sans-serif, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;; font-size: 16px; letter-spacing: normal; white-space: pre-line; background-color: rgb(252, 252, 252);\"> </span><span data-d-streaming-word=\"\" style=\"color: rgb(13, 13, 13); font-family: -apple-system-body, ui-sans-serif, -apple-system, system-ui, &quot;Segoe UI&quot;, Helvetica, &quot;Apple Color Emoji&quot;, Arial, sans-serif, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;; font-size: 16px; letter-spacing: normal; white-space: pre-line; background-color: rgb(252, 252, 252);\">e-books,</span><span style=\"color: rgb(13, 13, 13); font-family: -apple-system-body, ui-sans-serif, -apple-system, system-ui, &quot;Segoe UI&quot;, Helvetica, &quot;Apple Color Emoji&quot;, Arial, sans-serif, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;; font-size: 16px; letter-spacing: normal; white-space: pre-line; background-color: rgb(252, 252, 252);\"> </span><span data-d-streaming-word=\"\" style=\"color: rgb(13, 13, 13); font-family: -apple-system-body, ui-sans-serif, -apple-system, system-ui, &quot;Segoe UI&quot;, Helvetica, &quot;Apple Color Emoji&quot;, Arial, sans-serif, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;; font-size: 16px; letter-spacing: normal; white-space: pre-line; background-color: rgb(252, 252, 252);\">attending</span><span style=\"color: rgb(13, 13, 13); font-family: -apple-system-body, ui-sans-serif, -apple-system, system-ui, &quot;Segoe UI&quot;, Helvetica, &quot;Apple Color Emoji&quot;, Arial, sans-serif, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;; font-size: 16px; letter-spacing: normal; white-space: pre-line; background-color: rgb(252, 252, 252);\"> </span><span data-d-streaming-word=\"\" style=\"color: rgb(13, 13, 13); font-family: -apple-system-body, ui-sans-serif, -apple-system, system-ui, &quot;Segoe UI&quot;, Helvetica, &quot;Apple Color Emoji&quot;, Arial, sans-serif, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;; font-size: 16px; letter-spacing: normal; white-space: pre-line; background-color: rgb(252, 252, 252);\">online</span><span style=\"color: rgb(13, 13, 13); font-family: -apple-system-body, ui-sans-serif, -apple-system, system-ui, &quot;Segoe UI&quot;, Helvetica, &quot;Apple Color Emoji&quot;, Arial, sans-serif, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;; font-size: 16px; letter-spacing: normal; white-space: pre-line; background-color: rgb(252, 252, 252);\"> </span><span data-d-streaming-word=\"\" style=\"color: rgb(13, 13, 13); font-family: -apple-system-body, ui-sans-serif, -apple-system, system-ui, &quot;Segoe UI&quot;, Helvetica, &quot;Apple Color Emoji&quot;, Arial, sans-serif, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;; font-size: 16px; letter-spacing: normal; white-space: pre-line; background-color: rgb(252, 252, 252);\">classes,</span><span style=\"color: rgb(13, 13, 13); font-family: -apple-system-body, ui-sans-serif, -apple-system, system-ui, &quot;Segoe UI&quot;, Helvetica, &quot;Apple Color Emoji&quot;, Arial, sans-serif, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;; font-size: 16px; letter-spacing: normal; white-space: pre-line; background-color: rgb(252, 252, 252);\"> </span><span data-d-streaming-word=\"\" style=\"color: rgb(13, 13, 13); font-family: -apple-system-body, ui-sans-serif, -apple-system, system-ui, &quot;Segoe UI&quot;, Helvetica, &quot;Apple Color Emoji&quot;, Arial, sans-serif, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;; font-size: 16px; letter-spacing: normal; white-space: pre-line; background-color: rgb(252, 252, 252);\">and</span><span style=\"color: rgb(13, 13, 13); font-family: -apple-system-body, ui-sans-serif, -apple-system, system-ui, &quot;Segoe UI&quot;, Helvetica, &quot;Apple Color Emoji&quot;, Arial, sans-serif, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;; font-size: 16px; letter-spacing: normal; white-space: pre-line; background-color: rgb(252, 252, 252);\"> </span><span data-d-streaming-word=\"\" style=\"color: rgb(13, 13, 13); font-family: -apple-system-body, ui-sans-serif, -apple-system, system-ui, &quot;Segoe UI&quot;, Helvetica, &quot;Apple Color Emoji&quot;, Arial, sans-serif, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;; font-size: 16px; letter-spacing: normal; white-space: pre-line; background-color: rgb(252, 252, 252);\">completing</span><span style=\"color: rgb(13, 13, 13); font-family: -apple-system-body, ui-sans-serif, -apple-system, system-ui, &quot;Segoe UI&quot;, Helvetica, &quot;Apple Color Emoji&quot;, Arial, sans-serif, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;; font-size: 16px; letter-spacing: normal; white-space: pre-line; background-color: rgb(252, 252, 252);\"> </span><span data-d-streaming-word=\"\" style=\"color: rgb(13, 13, 13); font-family: -apple-system-body, ui-sans-serif, -apple-system, system-ui, &quot;Segoe UI&quot;, Helvetica, &quot;Apple Color Emoji&quot;, Arial, sans-serif, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;; font-size: 16px; letter-spacing: normal; white-space: pre-line; background-color: rgb(252, 252, 252);\">daily</span><span style=\"color: rgb(13, 13, 13); font-family: -apple-system-body, ui-sans-serif, -apple-system, system-ui, &quot;Segoe UI&quot;, Helvetica, &quot;Apple Color Emoji&quot;, Arial, sans-serif, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;; font-size: 16px; letter-spacing: normal; white-space: pre-line; background-color: rgb(252, 252, 252);\"> </span><span data-d-streaming-word=\"\" style=\"color: rgb(13, 13, 13); font-family: -apple-system-body, ui-sans-serif, -apple-system, system-ui, &quot;Segoe UI&quot;, Helvetica, &quot;Apple Color Emoji&quot;, Arial, sans-serif, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;; font-size: 16px; letter-spacing: normal; white-space: pre-line; background-color: rgb(252, 252, 252);\">tasks.</span></p>', 'A stylish and powerful tablet for entertainment, study, and everyday use.', 10000.00, 9000.00, NULL, NULL, 0, 'vendor', 'products/thumbnails/4DPb4qulz1j7OcVJZUISt8UZ1TYRJ8sE5d4NhbrJ.jpg', NULL, 'draft', 0, 1, 0, 0, '2026-10-31 06:36:19', '2026-10-31 06:45:29', NULL),
(52, 1, 2, 10, 1, 'Stainless Steel Travel Mug', 'stainless-steel-travel-mug', NULL, '<p><span data-d-streaming-word=\"\" style=\"color: rgb(13, 13, 13); font-family: -apple-system-body, ui-sans-serif, -apple-system, system-ui, &quot;Segoe UI&quot;, Helvetica, &quot;Apple Color Emoji&quot;, Arial, sans-serif, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;; font-size: 16px; letter-spacing: normal; white-space: pre-line; background-color: rgb(252, 252, 252);\">This</span><span style=\"color: rgb(13, 13, 13); font-family: -apple-system-body, ui-sans-serif, -apple-system, system-ui, &quot;Segoe UI&quot;, Helvetica, &quot;Apple Color Emoji&quot;, Arial, sans-serif, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;; font-size: 16px; letter-spacing: normal; white-space: pre-line; background-color: rgb(252, 252, 252);\"> </span><span data-d-streaming-word=\"\" style=\"color: rgb(13, 13, 13); font-family: -apple-system-body, ui-sans-serif, -apple-system, system-ui, &quot;Segoe UI&quot;, Helvetica, &quot;Apple Color Emoji&quot;, Arial, sans-serif, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;; font-size: 16px; letter-spacing: normal; white-space: pre-line; background-color: rgb(252, 252, 252);\">stainless</span><span style=\"color: rgb(13, 13, 13); font-family: -apple-system-body, ui-sans-serif, -apple-system, system-ui, &quot;Segoe UI&quot;, Helvetica, &quot;Apple Color Emoji&quot;, Arial, sans-serif, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;; font-size: 16px; letter-spacing: normal; white-space: pre-line; background-color: rgb(252, 252, 252);\"> </span><span data-d-streaming-word=\"\" style=\"color: rgb(13, 13, 13); font-family: -apple-system-body, ui-sans-serif, -apple-system, system-ui, &quot;Segoe UI&quot;, Helvetica, &quot;Apple Color Emoji&quot;, Arial, sans-serif, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;; font-size: 16px; letter-spacing: normal; white-space: pre-line; background-color: rgb(252, 252, 252);\">steel</span><span style=\"color: rgb(13, 13, 13); font-family: -apple-system-body, ui-sans-serif, -apple-system, system-ui, &quot;Segoe UI&quot;, Helvetica, &quot;Apple Color Emoji&quot;, Arial, sans-serif, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;; font-size: 16px; letter-spacing: normal; white-space: pre-line; background-color: rgb(252, 252, 252);\"> </span><span data-d-streaming-word=\"\" style=\"color: rgb(13, 13, 13); font-family: -apple-system-body, ui-sans-serif, -apple-system, system-ui, &quot;Segoe UI&quot;, Helvetica, &quot;Apple Color Emoji&quot;, Arial, sans-serif, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;; font-size: 16px; letter-spacing: normal; white-space: pre-line; background-color: rgb(252, 252, 252);\">travel</span><span style=\"color: rgb(13, 13, 13); font-family: -apple-system-body, ui-sans-serif, -apple-system, system-ui, &quot;Segoe UI&quot;, Helvetica, &quot;Apple Color Emoji&quot;, Arial, sans-serif, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;; font-size: 16px; letter-spacing: normal; white-space: pre-line; background-color: rgb(252, 252, 252);\"> </span><span data-d-streaming-word=\"\" style=\"color: rgb(13, 13, 13); font-family: -apple-system-body, ui-sans-serif, -apple-system, system-ui, &quot;Segoe UI&quot;, Helvetica, &quot;Apple Color Emoji&quot;, Arial, sans-serif, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;; font-size: 16px; letter-spacing: normal; white-space: pre-line; background-color: rgb(252, 252, 252);\">mug</span><span style=\"color: rgb(13, 13, 13); font-family: -apple-system-body, ui-sans-serif, -apple-system, system-ui, &quot;Segoe UI&quot;, Helvetica, &quot;Apple Color Emoji&quot;, Arial, sans-serif, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;; font-size: 16px; letter-spacing: normal; white-space: pre-line; background-color: rgb(252, 252, 252);\"> </span><span data-d-streaming-word=\"\" style=\"color: rgb(13, 13, 13); font-family: -apple-system-body, ui-sans-serif, -apple-system, system-ui, &quot;Segoe UI&quot;, Helvetica, &quot;Apple Color Emoji&quot;, Arial, sans-serif, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;; font-size: 16px; letter-spacing: normal; white-space: pre-line; background-color: rgb(252, 252, 252);\">features</span><span style=\"color: rgb(13, 13, 13); font-family: -apple-system-body, ui-sans-serif, -apple-system, system-ui, &quot;Segoe UI&quot;, Helvetica, &quot;Apple Color Emoji&quot;, Arial, sans-serif, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;; font-size: 16px; letter-spacing: normal; white-space: pre-line; background-color: rgb(252, 252, 252);\"> </span><span data-d-streaming-word=\"\" style=\"color: rgb(13, 13, 13); font-family: -apple-system-body, ui-sans-serif, -apple-system, system-ui, &quot;Segoe UI&quot;, Helvetica, &quot;Apple Color Emoji&quot;, Arial, sans-serif, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;; font-size: 16px; letter-spacing: normal; white-space: pre-line; background-color: rgb(252, 252, 252);\">a</span><span style=\"color: rgb(13, 13, 13); font-family: -apple-system-body, ui-sans-serif, -apple-system, system-ui, &quot;Segoe UI&quot;, Helvetica, &quot;Apple Color Emoji&quot;, Arial, sans-serif, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;; font-size: 16px; letter-spacing: normal; white-space: pre-line; background-color: rgb(252, 252, 252);\"> </span><span data-d-streaming-word=\"\" style=\"color: rgb(13, 13, 13); font-family: -apple-system-body, ui-sans-serif, -apple-system, system-ui, &quot;Segoe UI&quot;, Helvetica, &quot;Apple Color Emoji&quot;, Arial, sans-serif, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;; font-size: 16px; letter-spacing: normal; white-space: pre-line; background-color: rgb(252, 252, 252);\">stylish</span><span style=\"color: rgb(13, 13, 13); font-family: -apple-system-body, ui-sans-serif, -apple-system, system-ui, &quot;Segoe UI&quot;, Helvetica, &quot;Apple Color Emoji&quot;, Arial, sans-serif, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;; font-size: 16px; letter-spacing: normal; white-space: pre-line; background-color: rgb(252, 252, 252);\"> </span><span data-d-streaming-word=\"\" style=\"color: rgb(13, 13, 13); font-family: -apple-system-body, ui-sans-serif, -apple-system, system-ui, &quot;Segoe UI&quot;, Helvetica, &quot;Apple Color Emoji&quot;, Arial, sans-serif, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;; font-size: 16px; letter-spacing: normal; white-space: pre-line; background-color: rgb(252, 252, 252);\">design</span><span style=\"color: rgb(13, 13, 13); font-family: -apple-system-body, ui-sans-serif, -apple-system, system-ui, &quot;Segoe UI&quot;, Helvetica, &quot;Apple Color Emoji&quot;, Arial, sans-serif, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;; font-size: 16px; letter-spacing: normal; white-space: pre-line; background-color: rgb(252, 252, 252);\"> </span><span data-d-streaming-word=\"\" style=\"color: rgb(13, 13, 13); font-family: -apple-system-body, ui-sans-serif, -apple-system, system-ui, &quot;Segoe UI&quot;, Helvetica, &quot;Apple Color Emoji&quot;, Arial, sans-serif, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;; font-size: 16px; letter-spacing: normal; white-space: pre-line; background-color: rgb(252, 252, 252);\">and</span><span style=\"color: rgb(13, 13, 13); font-family: -apple-system-body, ui-sans-serif, -apple-system, system-ui, &quot;Segoe UI&quot;, Helvetica, &quot;Apple Color Emoji&quot;, Arial, sans-serif, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;; font-size: 16px; letter-spacing: normal; white-space: pre-line; background-color: rgb(252, 252, 252);\"> </span><span data-d-streaming-word=\"\" style=\"color: rgb(13, 13, 13); font-family: -apple-system-body, ui-sans-serif, -apple-system, system-ui, &quot;Segoe UI&quot;, Helvetica, &quot;Apple Color Emoji&quot;, Arial, sans-serif, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;; font-size: 16px; letter-spacing: normal; white-space: pre-line; background-color: rgb(252, 252, 252);\">durable</span><span style=\"color: rgb(13, 13, 13); font-family: -apple-system-body, ui-sans-serif, -apple-system, system-ui, &quot;Segoe UI&quot;, Helvetica, &quot;Apple Color Emoji&quot;, Arial, sans-serif, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;; font-size: 16px; letter-spacing: normal; white-space: pre-line; background-color: rgb(252, 252, 252);\"> </span><span data-d-streaming-word=\"\" style=\"color: rgb(13, 13, 13); font-family: -apple-system-body, ui-sans-serif, -apple-system, system-ui, &quot;Segoe UI&quot;, Helvetica, &quot;Apple Color Emoji&quot;, Arial, sans-serif, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;; font-size: 16px; letter-spacing: normal; white-space: pre-line; background-color: rgb(252, 252, 252);\">construction.</span><span style=\"color: rgb(13, 13, 13); font-family: -apple-system-body, ui-sans-serif, -apple-system, system-ui, &quot;Segoe UI&quot;, Helvetica, &quot;Apple Color Emoji&quot;, Arial, sans-serif, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;; font-size: 16px; letter-spacing: normal; white-space: pre-line; background-color: rgb(252, 252, 252);\"> </span><span data-d-streaming-word=\"\" style=\"color: rgb(13, 13, 13); font-family: -apple-system-body, ui-sans-serif, -apple-system, system-ui, &quot;Segoe UI&quot;, Helvetica, &quot;Apple Color Emoji&quot;, Arial, sans-serif, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;; font-size: 16px; letter-spacing: normal; white-space: pre-line; background-color: rgb(252, 252, 252);\">It</span><span style=\"color: rgb(13, 13, 13); font-family: -apple-system-body, ui-sans-serif, -apple-system, system-ui, &quot;Segoe UI&quot;, Helvetica, &quot;Apple Color Emoji&quot;, Arial, sans-serif, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;; font-size: 16px; letter-spacing: normal; white-space: pre-line; background-color: rgb(252, 252, 252);\"> </span><span data-d-streaming-word=\"\" style=\"color: rgb(13, 13, 13); font-family: -apple-system-body, ui-sans-serif, -apple-system, system-ui, &quot;Segoe UI&quot;, Helvetica, &quot;Apple Color Emoji&quot;, Arial, sans-serif, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;; font-size: 16px; letter-spacing: normal; white-space: pre-line; background-color: rgb(252, 252, 252);\">is</span><span style=\"color: rgb(13, 13, 13); font-family: -apple-system-body, ui-sans-serif, -apple-system, system-ui, &quot;Segoe UI&quot;, Helvetica, &quot;Apple Color Emoji&quot;, Arial, sans-serif, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;; font-size: 16px; letter-spacing: normal; white-space: pre-line; background-color: rgb(252, 252, 252);\"> </span><span data-d-streaming-word=\"\" style=\"color: rgb(13, 13, 13); font-family: -apple-system-body, ui-sans-serif, -apple-system, system-ui, &quot;Segoe UI&quot;, Helvetica, &quot;Apple Color Emoji&quot;, Arial, sans-serif, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;; font-size: 16px; letter-spacing: normal; white-space: pre-line; background-color: rgb(252, 252, 252);\">perfect</span><span style=\"color: rgb(13, 13, 13); font-family: -apple-system-body, ui-sans-serif, -apple-system, system-ui, &quot;Segoe UI&quot;, Helvetica, &quot;Apple Color Emoji&quot;, Arial, sans-serif, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;; font-size: 16px; letter-spacing: normal; white-space: pre-line; background-color: rgb(252, 252, 252);\"> </span><span data-d-streaming-word=\"\" style=\"color: rgb(13, 13, 13); font-family: -apple-system-body, ui-sans-serif, -apple-system, system-ui, &quot;Segoe UI&quot;, Helvetica, &quot;Apple Color Emoji&quot;, Arial, sans-serif, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;; font-size: 16px; letter-spacing: normal; white-space: pre-line; background-color: rgb(252, 252, 252);\">for</span><span style=\"color: rgb(13, 13, 13); font-family: -apple-system-body, ui-sans-serif, -apple-system, system-ui, &quot;Segoe UI&quot;, Helvetica, &quot;Apple Color Emoji&quot;, Arial, sans-serif, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;; font-size: 16px; letter-spacing: normal; white-space: pre-line; background-color: rgb(252, 252, 252);\"> </span><span data-d-streaming-word=\"\" style=\"color: rgb(13, 13, 13); font-family: -apple-system-body, ui-sans-serif, -apple-system, system-ui, &quot;Segoe UI&quot;, Helvetica, &quot;Apple Color Emoji&quot;, Arial, sans-serif, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;; font-size: 16px; letter-spacing: normal; white-space: pre-line; background-color: rgb(252, 252, 252);\">carrying</span><span style=\"color: rgb(13, 13, 13); font-family: -apple-system-body, ui-sans-serif, -apple-system, system-ui, &quot;Segoe UI&quot;, Helvetica, &quot;Apple Color Emoji&quot;, Arial, sans-serif, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;; font-size: 16px; letter-spacing: normal; white-space: pre-line; background-color: rgb(252, 252, 252);\"> </span><span data-d-streaming-word=\"\" style=\"color: rgb(13, 13, 13); font-family: -apple-system-body, ui-sans-serif, -apple-system, system-ui, &quot;Segoe UI&quot;, Helvetica, &quot;Apple Color Emoji&quot;, Arial, sans-serif, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;; font-size: 16px; letter-spacing: normal; white-space: pre-line; background-color: rgb(252, 252, 252);\">coffee,</span><span style=\"color: rgb(13, 13, 13); font-family: -apple-system-body, ui-sans-serif, -apple-system, system-ui, &quot;Segoe UI&quot;, Helvetica, &quot;Apple Color Emoji&quot;, Arial, sans-serif, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;; font-size: 16px; letter-spacing: normal; white-space: pre-line; background-color: rgb(252, 252, 252);\"> </span><span data-d-streaming-word=\"\" style=\"color: rgb(13, 13, 13); font-family: -apple-system-body, ui-sans-serif, -apple-system, system-ui, &quot;Segoe UI&quot;, Helvetica, &quot;Apple Color Emoji&quot;, Arial, sans-serif, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;; font-size: 16px; letter-spacing: normal; white-space: pre-line; background-color: rgb(252, 252, 252);\">tea,</span><span style=\"color: rgb(13, 13, 13); font-family: -apple-system-body, ui-sans-serif, -apple-system, system-ui, &quot;Segoe UI&quot;, Helvetica, &quot;Apple Color Emoji&quot;, Arial, sans-serif, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;; font-size: 16px; letter-spacing: normal; white-space: pre-line; background-color: rgb(252, 252, 252);\"> </span><span data-d-streaming-word=\"\" style=\"color: rgb(13, 13, 13); font-family: -apple-system-body, ui-sans-serif, -apple-system, system-ui, &quot;Segoe UI&quot;, Helvetica, &quot;Apple Color Emoji&quot;, Arial, sans-serif, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;; font-size: 16px; letter-spacing: normal; white-space: pre-line; background-color: rgb(252, 252, 252);\">and</span><span style=\"color: rgb(13, 13, 13); font-family: -apple-system-body, ui-sans-serif, -apple-system, system-ui, &quot;Segoe UI&quot;, Helvetica, &quot;Apple Color Emoji&quot;, Arial, sans-serif, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;; font-size: 16px; letter-spacing: normal; white-space: pre-line; background-color: rgb(252, 252, 252);\"> </span><span data-d-streaming-word=\"\" style=\"color: rgb(13, 13, 13); font-family: -apple-system-body, ui-sans-serif, -apple-system, system-ui, &quot;Segoe UI&quot;, Helvetica, &quot;Apple Color Emoji&quot;, Arial, sans-serif, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;; font-size: 16px; letter-spacing: normal; white-space: pre-line; background-color: rgb(252, 252, 252);\">other</span><span style=\"color: rgb(13, 13, 13); font-family: -apple-system-body, ui-sans-serif, -apple-system, system-ui, &quot;Segoe UI&quot;, Helvetica, &quot;Apple Color Emoji&quot;, Arial, sans-serif, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;; font-size: 16px; letter-spacing: normal; white-space: pre-line; background-color: rgb(252, 252, 252);\"> </span><span data-d-streaming-word=\"\" style=\"color: rgb(13, 13, 13); font-family: -apple-system-body, ui-sans-serif, -apple-system, system-ui, &quot;Segoe UI&quot;, Helvetica, &quot;Apple Color Emoji&quot;, Arial, sans-serif, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;; font-size: 16px; letter-spacing: normal; white-space: pre-line; background-color: rgb(252, 252, 252);\">beverages</span><span style=\"color: rgb(13, 13, 13); font-family: -apple-system-body, ui-sans-serif, -apple-system, system-ui, &quot;Segoe UI&quot;, Helvetica, &quot;Apple Color Emoji&quot;, Arial, sans-serif, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;; font-size: 16px; letter-spacing: normal; white-space: pre-line; background-color: rgb(252, 252, 252);\"> </span><span data-d-streaming-word=\"\" style=\"color: rgb(13, 13, 13); font-family: -apple-system-body, ui-sans-serif, -apple-system, system-ui, &quot;Segoe UI&quot;, Helvetica, &quot;Apple Color Emoji&quot;, Arial, sans-serif, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;; font-size: 16px; letter-spacing: normal; white-space: pre-line; background-color: rgb(252, 252, 252);\">while</span><span style=\"color: rgb(13, 13, 13); font-family: -apple-system-body, ui-sans-serif, -apple-system, system-ui, &quot;Segoe UI&quot;, Helvetica, &quot;Apple Color Emoji&quot;, Arial, sans-serif, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;; font-size: 16px; letter-spacing: normal; white-space: pre-line; background-color: rgb(252, 252, 252);\"> </span><span data-d-streaming-word=\"\" style=\"color: rgb(13, 13, 13); font-family: -apple-system-body, ui-sans-serif, -apple-system, system-ui, &quot;Segoe UI&quot;, Helvetica, &quot;Apple Color Emoji&quot;, Arial, sans-serif, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;; font-size: 16px; letter-spacing: normal; white-space: pre-line; background-color: rgb(252, 252, 252);\">traveling,</span><span style=\"color: rgb(13, 13, 13); font-family: -apple-system-body, ui-sans-serif, -apple-system, system-ui, &quot;Segoe UI&quot;, Helvetica, &quot;Apple Color Emoji&quot;, Arial, sans-serif, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;; font-size: 16px; letter-spacing: normal; white-space: pre-line; background-color: rgb(252, 252, 252);\"> </span><span data-d-streaming-word=\"\" style=\"color: rgb(13, 13, 13); font-family: -apple-system-body, ui-sans-serif, -apple-system, system-ui, &quot;Segoe UI&quot;, Helvetica, &quot;Apple Color Emoji&quot;, Arial, sans-serif, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;; font-size: 16px; letter-spacing: normal; white-space: pre-line; background-color: rgb(252, 252, 252);\">working,</span><span style=\"color: rgb(13, 13, 13); font-family: -apple-system-body, ui-sans-serif, -apple-system, system-ui, &quot;Segoe UI&quot;, Helvetica, &quot;Apple Color Emoji&quot;, Arial, sans-serif, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;; font-size: 16px; letter-spacing: normal; white-space: pre-line; background-color: rgb(252, 252, 252);\"> </span><span data-d-streaming-word=\"\" style=\"color: rgb(13, 13, 13); font-family: -apple-system-body, ui-sans-serif, -apple-system, system-ui, &quot;Segoe UI&quot;, Helvetica, &quot;Apple Color Emoji&quot;, Arial, sans-serif, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;; font-size: 16px; letter-spacing: normal; white-space: pre-line; background-color: rgb(252, 252, 252);\">or</span><span style=\"color: rgb(13, 13, 13); font-family: -apple-system-body, ui-sans-serif, -apple-system, system-ui, &quot;Segoe UI&quot;, Helvetica, &quot;Apple Color Emoji&quot;, Arial, sans-serif, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;; font-size: 16px; letter-spacing: normal; white-space: pre-line; background-color: rgb(252, 252, 252);\"> </span><span data-d-streaming-word=\"\" style=\"color: rgb(13, 13, 13); font-family: -apple-system-body, ui-sans-serif, -apple-system, system-ui, &quot;Segoe UI&quot;, Helvetica, &quot;Apple Color Emoji&quot;, Arial, sans-serif, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;; font-size: 16px; letter-spacing: normal; white-space: pre-line; background-color: rgb(252, 252, 252);\">enjoying</span><span style=\"color: rgb(13, 13, 13); font-family: -apple-system-body, ui-sans-serif, -apple-system, system-ui, &quot;Segoe UI&quot;, Helvetica, &quot;Apple Color Emoji&quot;, Arial, sans-serif, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;; font-size: 16px; letter-spacing: normal; white-space: pre-line; background-color: rgb(252, 252, 252);\"> </span><span data-d-streaming-word=\"\" style=\"color: rgb(13, 13, 13); font-family: -apple-system-body, ui-sans-serif, -apple-system, system-ui, &quot;Segoe UI&quot;, Helvetica, &quot;Apple Color Emoji&quot;, Arial, sans-serif, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;; font-size: 16px; letter-spacing: normal; white-space: pre-line; background-color: rgb(252, 252, 252);\">outdoor</span><span style=\"color: rgb(13, 13, 13); font-family: -apple-system-body, ui-sans-serif, -apple-system, system-ui, &quot;Segoe UI&quot;, Helvetica, &quot;Apple Color Emoji&quot;, Arial, sans-serif, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;; font-size: 16px; letter-spacing: normal; white-space: pre-line; background-color: rgb(252, 252, 252);\"> </span><span data-d-streaming-word=\"\" style=\"color: rgb(13, 13, 13); font-family: -apple-system-body, ui-sans-serif, -apple-system, system-ui, &quot;Segoe UI&quot;, Helvetica, &quot;Apple Color Emoji&quot;, Arial, sans-serif, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;; font-size: 16px; letter-spacing: normal; white-space: pre-line; background-color: rgb(252, 252, 252);\">activities.</span></p>', 'A durable stainless steel travel mug for keeping beverages hot or cold.', 5000.00, 4250.00, NULL, NULL, 0, 'vendor', 'products/thumbnails/1w2ACNM2lX6hQgQ2nuoHguEQuBHRFOTfTusTX0Xk.jpg', NULL, 'draft', 1, 0, 0, 0, '2026-10-31 06:39:05', '2026-10-31 06:39:05', NULL);
INSERT INTO `products` (`id`, `vendor_id`, `category_id`, `sub_category_id`, `brand_id`, `name`, `slug`, `sku`, `description`, `short_description`, `price`, `discount_price`, `cost_price`, `tags`, `stock_quantity`, `product_type`, `thumbnail`, `sponsored_video_url`, `status`, `is_new`, `is_featured`, `is_hot`, `views_count`, `created_at`, `updated_at`, `deleted_at`) VALUES
(53, 2, 3, 34, 3, 'Wireless Gaming Controller', 'wireless-gaming-controller', NULL, '<p><span data-d-streaming-word=\"\" style=\"color: rgb(13, 13, 13); font-family: -apple-system-body, ui-sans-serif, -apple-system, system-ui, &quot;Segoe UI&quot;, Helvetica, &quot;Apple Color Emoji&quot;, Arial, sans-serif, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;; font-size: 16px; letter-spacing: normal; white-space: pre-line; background-color: rgb(252, 252, 252);\">This</span><span style=\"color: rgb(13, 13, 13); font-family: -apple-system-body, ui-sans-serif, -apple-system, system-ui, &quot;Segoe UI&quot;, Helvetica, &quot;Apple Color Emoji&quot;, Arial, sans-serif, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;; font-size: 16px; letter-spacing: normal; white-space: pre-line; background-color: rgb(252, 252, 252);\"> </span><span data-d-streaming-word=\"\" style=\"color: rgb(13, 13, 13); font-family: -apple-system-body, ui-sans-serif, -apple-system, system-ui, &quot;Segoe UI&quot;, Helvetica, &quot;Apple Color Emoji&quot;, Arial, sans-serif, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;; font-size: 16px; letter-spacing: normal; white-space: pre-line; background-color: rgb(252, 252, 252);\">wireless</span><span style=\"color: rgb(13, 13, 13); font-family: -apple-system-body, ui-sans-serif, -apple-system, system-ui, &quot;Segoe UI&quot;, Helvetica, &quot;Apple Color Emoji&quot;, Arial, sans-serif, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;; font-size: 16px; letter-spacing: normal; white-space: pre-line; background-color: rgb(252, 252, 252);\"> </span><span data-d-streaming-word=\"\" style=\"color: rgb(13, 13, 13); font-family: -apple-system-body, ui-sans-serif, -apple-system, system-ui, &quot;Segoe UI&quot;, Helvetica, &quot;Apple Color Emoji&quot;, Arial, sans-serif, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;; font-size: 16px; letter-spacing: normal; white-space: pre-line; background-color: rgb(252, 252, 252);\">gaming</span><span style=\"color: rgb(13, 13, 13); font-family: -apple-system-body, ui-sans-serif, -apple-system, system-ui, &quot;Segoe UI&quot;, Helvetica, &quot;Apple Color Emoji&quot;, Arial, sans-serif, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;; font-size: 16px; letter-spacing: normal; white-space: pre-line; background-color: rgb(252, 252, 252);\"> </span><span data-d-streaming-word=\"\" style=\"color: rgb(13, 13, 13); font-family: -apple-system-body, ui-sans-serif, -apple-system, system-ui, &quot;Segoe UI&quot;, Helvetica, &quot;Apple Color Emoji&quot;, Arial, sans-serif, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;; font-size: 16px; letter-spacing: normal; white-space: pre-line; background-color: rgb(252, 252, 252);\">controller</span><span style=\"color: rgb(13, 13, 13); font-family: -apple-system-body, ui-sans-serif, -apple-system, system-ui, &quot;Segoe UI&quot;, Helvetica, &quot;Apple Color Emoji&quot;, Arial, sans-serif, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;; font-size: 16px; letter-spacing: normal; white-space: pre-line; background-color: rgb(252, 252, 252);\"> </span><span data-d-streaming-word=\"\" style=\"color: rgb(13, 13, 13); font-family: -apple-system-body, ui-sans-serif, -apple-system, system-ui, &quot;Segoe UI&quot;, Helvetica, &quot;Apple Color Emoji&quot;, Arial, sans-serif, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;; font-size: 16px; letter-spacing: normal; white-space: pre-line; background-color: rgb(252, 252, 252);\">provides</span><span style=\"color: rgb(13, 13, 13); font-family: -apple-system-body, ui-sans-serif, -apple-system, system-ui, &quot;Segoe UI&quot;, Helvetica, &quot;Apple Color Emoji&quot;, Arial, sans-serif, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;; font-size: 16px; letter-spacing: normal; white-space: pre-line; background-color: rgb(252, 252, 252);\"> </span><span data-d-streaming-word=\"\" style=\"color: rgb(13, 13, 13); font-family: -apple-system-body, ui-sans-serif, -apple-system, system-ui, &quot;Segoe UI&quot;, Helvetica, &quot;Apple Color Emoji&quot;, Arial, sans-serif, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;; font-size: 16px; letter-spacing: normal; white-space: pre-line; background-color: rgb(252, 252, 252);\">responsive</span><span style=\"color: rgb(13, 13, 13); font-family: -apple-system-body, ui-sans-serif, -apple-system, system-ui, &quot;Segoe UI&quot;, Helvetica, &quot;Apple Color Emoji&quot;, Arial, sans-serif, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;; font-size: 16px; letter-spacing: normal; white-space: pre-line; background-color: rgb(252, 252, 252);\"> </span><span data-d-streaming-word=\"\" style=\"color: rgb(13, 13, 13); font-family: -apple-system-body, ui-sans-serif, -apple-system, system-ui, &quot;Segoe UI&quot;, Helvetica, &quot;Apple Color Emoji&quot;, Arial, sans-serif, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;; font-size: 16px; letter-spacing: normal; white-space: pre-line; background-color: rgb(252, 252, 252);\">controls</span><span style=\"color: rgb(13, 13, 13); font-family: -apple-system-body, ui-sans-serif, -apple-system, system-ui, &quot;Segoe UI&quot;, Helvetica, &quot;Apple Color Emoji&quot;, Arial, sans-serif, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;; font-size: 16px; letter-spacing: normal; white-space: pre-line; background-color: rgb(252, 252, 252);\"> </span><span data-d-streaming-word=\"\" style=\"color: rgb(13, 13, 13); font-family: -apple-system-body, ui-sans-serif, -apple-system, system-ui, &quot;Segoe UI&quot;, Helvetica, &quot;Apple Color Emoji&quot;, Arial, sans-serif, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;; font-size: 16px; letter-spacing: normal; white-space: pre-line; background-color: rgb(252, 252, 252);\">and</span><span style=\"color: rgb(13, 13, 13); font-family: -apple-system-body, ui-sans-serif, -apple-system, system-ui, &quot;Segoe UI&quot;, Helvetica, &quot;Apple Color Emoji&quot;, Arial, sans-serif, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;; font-size: 16px; letter-spacing: normal; white-space: pre-line; background-color: rgb(252, 252, 252);\"> </span><span data-d-streaming-word=\"\" style=\"color: rgb(13, 13, 13); font-family: -apple-system-body, ui-sans-serif, -apple-system, system-ui, &quot;Segoe UI&quot;, Helvetica, &quot;Apple Color Emoji&quot;, Arial, sans-serif, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;; font-size: 16px; letter-spacing: normal; white-space: pre-line; background-color: rgb(252, 252, 252);\">an</span><span style=\"color: rgb(13, 13, 13); font-family: -apple-system-body, ui-sans-serif, -apple-system, system-ui, &quot;Segoe UI&quot;, Helvetica, &quot;Apple Color Emoji&quot;, Arial, sans-serif, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;; font-size: 16px; letter-spacing: normal; white-space: pre-line; background-color: rgb(252, 252, 252);\"> </span><span data-d-streaming-word=\"\" style=\"color: rgb(13, 13, 13); font-family: -apple-system-body, ui-sans-serif, -apple-system, system-ui, &quot;Segoe UI&quot;, Helvetica, &quot;Apple Color Emoji&quot;, Arial, sans-serif, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;; font-size: 16px; letter-spacing: normal; white-space: pre-line; background-color: rgb(252, 252, 252);\">ergonomic</span><span style=\"color: rgb(13, 13, 13); font-family: -apple-system-body, ui-sans-serif, -apple-system, system-ui, &quot;Segoe UI&quot;, Helvetica, &quot;Apple Color Emoji&quot;, Arial, sans-serif, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;; font-size: 16px; letter-spacing: normal; white-space: pre-line; background-color: rgb(252, 252, 252);\"> </span><span data-d-streaming-word=\"\" style=\"color: rgb(13, 13, 13); font-family: -apple-system-body, ui-sans-serif, -apple-system, system-ui, &quot;Segoe UI&quot;, Helvetica, &quot;Apple Color Emoji&quot;, Arial, sans-serif, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;; font-size: 16px; letter-spacing: normal; white-space: pre-line; background-color: rgb(252, 252, 252);\">design.</span><span style=\"color: rgb(13, 13, 13); font-family: -apple-system-body, ui-sans-serif, -apple-system, system-ui, &quot;Segoe UI&quot;, Helvetica, &quot;Apple Color Emoji&quot;, Arial, sans-serif, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;; font-size: 16px; letter-spacing: normal; white-space: pre-line; background-color: rgb(252, 252, 252);\"> </span><span data-d-streaming-word=\"\" style=\"color: rgb(13, 13, 13); font-family: -apple-system-body, ui-sans-serif, -apple-system, system-ui, &quot;Segoe UI&quot;, Helvetica, &quot;Apple Color Emoji&quot;, Arial, sans-serif, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;; font-size: 16px; letter-spacing: normal; white-space: pre-line; background-color: rgb(252, 252, 252);\">It</span><span style=\"color: rgb(13, 13, 13); font-family: -apple-system-body, ui-sans-serif, -apple-system, system-ui, &quot;Segoe UI&quot;, Helvetica, &quot;Apple Color Emoji&quot;, Arial, sans-serif, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;; font-size: 16px; letter-spacing: normal; white-space: pre-line; background-color: rgb(252, 252, 252);\"> </span><span data-d-streaming-word=\"\" style=\"color: rgb(13, 13, 13); font-family: -apple-system-body, ui-sans-serif, -apple-system, system-ui, &quot;Segoe UI&quot;, Helvetica, &quot;Apple Color Emoji&quot;, Arial, sans-serif, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;; font-size: 16px; letter-spacing: normal; white-space: pre-line; background-color: rgb(252, 252, 252);\">is</span><span style=\"color: rgb(13, 13, 13); font-family: -apple-system-body, ui-sans-serif, -apple-system, system-ui, &quot;Segoe UI&quot;, Helvetica, &quot;Apple Color Emoji&quot;, Arial, sans-serif, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;; font-size: 16px; letter-spacing: normal; white-space: pre-line; background-color: rgb(252, 252, 252);\"> </span><span data-d-streaming-word=\"\" style=\"color: rgb(13, 13, 13); font-family: -apple-system-body, ui-sans-serif, -apple-system, system-ui, &quot;Segoe UI&quot;, Helvetica, &quot;Apple Color Emoji&quot;, Arial, sans-serif, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;; font-size: 16px; letter-spacing: normal; white-space: pre-line; background-color: rgb(252, 252, 252);\">suitable</span><span style=\"color: rgb(13, 13, 13); font-family: -apple-system-body, ui-sans-serif, -apple-system, system-ui, &quot;Segoe UI&quot;, Helvetica, &quot;Apple Color Emoji&quot;, Arial, sans-serif, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;; font-size: 16px; letter-spacing: normal; white-space: pre-line; background-color: rgb(252, 252, 252);\"> </span><span data-d-streaming-word=\"\" style=\"color: rgb(13, 13, 13); font-family: -apple-system-body, ui-sans-serif, -apple-system, system-ui, &quot;Segoe UI&quot;, Helvetica, &quot;Apple Color Emoji&quot;, Arial, sans-serif, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;; font-size: 16px; letter-spacing: normal; white-space: pre-line; background-color: rgb(252, 252, 252);\">for</span><span style=\"color: rgb(13, 13, 13); font-family: -apple-system-body, ui-sans-serif, -apple-system, system-ui, &quot;Segoe UI&quot;, Helvetica, &quot;Apple Color Emoji&quot;, Arial, sans-serif, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;; font-size: 16px; letter-spacing: normal; white-space: pre-line; background-color: rgb(252, 252, 252);\"> </span><span data-d-streaming-word=\"\" style=\"color: rgb(13, 13, 13); font-family: -apple-system-body, ui-sans-serif, -apple-system, system-ui, &quot;Segoe UI&quot;, Helvetica, &quot;Apple Color Emoji&quot;, Arial, sans-serif, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;; font-size: 16px; letter-spacing: normal; white-space: pre-line; background-color: rgb(252, 252, 252);\">playing</span><span style=\"color: rgb(13, 13, 13); font-family: -apple-system-body, ui-sans-serif, -apple-system, system-ui, &quot;Segoe UI&quot;, Helvetica, &quot;Apple Color Emoji&quot;, Arial, sans-serif, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;; font-size: 16px; letter-spacing: normal; white-space: pre-line; background-color: rgb(252, 252, 252);\"> </span><span data-d-streaming-word=\"\" style=\"color: rgb(13, 13, 13); font-family: -apple-system-body, ui-sans-serif, -apple-system, system-ui, &quot;Segoe UI&quot;, Helvetica, &quot;Apple Color Emoji&quot;, Arial, sans-serif, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;; font-size: 16px; letter-spacing: normal; white-space: pre-line; background-color: rgb(252, 252, 252);\">different</span><span style=\"color: rgb(13, 13, 13); font-family: -apple-system-body, ui-sans-serif, -apple-system, system-ui, &quot;Segoe UI&quot;, Helvetica, &quot;Apple Color Emoji&quot;, Arial, sans-serif, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;; font-size: 16px; letter-spacing: normal; white-space: pre-line; background-color: rgb(252, 252, 252);\"> </span><span data-d-streaming-word=\"\" style=\"color: rgb(13, 13, 13); font-family: -apple-system-body, ui-sans-serif, -apple-system, system-ui, &quot;Segoe UI&quot;, Helvetica, &quot;Apple Color Emoji&quot;, Arial, sans-serif, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;; font-size: 16px; letter-spacing: normal; white-space: pre-line; background-color: rgb(252, 252, 252);\">types</span><span style=\"color: rgb(13, 13, 13); font-family: -apple-system-body, ui-sans-serif, -apple-system, system-ui, &quot;Segoe UI&quot;, Helvetica, &quot;Apple Color Emoji&quot;, Arial, sans-serif, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;; font-size: 16px; letter-spacing: normal; white-space: pre-line; background-color: rgb(252, 252, 252);\"> </span><span data-d-streaming-word=\"\" style=\"color: rgb(13, 13, 13); font-family: -apple-system-body, ui-sans-serif, -apple-system, system-ui, &quot;Segoe UI&quot;, Helvetica, &quot;Apple Color Emoji&quot;, Arial, sans-serif, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;; font-size: 16px; letter-spacing: normal; white-space: pre-line; background-color: rgb(252, 252, 252);\">of</span><span style=\"color: rgb(13, 13, 13); font-family: -apple-system-body, ui-sans-serif, -apple-system, system-ui, &quot;Segoe UI&quot;, Helvetica, &quot;Apple Color Emoji&quot;, Arial, sans-serif, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;; font-size: 16px; letter-spacing: normal; white-space: pre-line; background-color: rgb(252, 252, 252);\"> </span><span data-d-streaming-word=\"\" style=\"color: rgb(13, 13, 13); font-family: -apple-system-body, ui-sans-serif, -apple-system, system-ui, &quot;Segoe UI&quot;, Helvetica, &quot;Apple Color Emoji&quot;, Arial, sans-serif, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;; font-size: 16px; letter-spacing: normal; white-space: pre-line; background-color: rgb(252, 252, 252);\">games</span><span style=\"color: rgb(13, 13, 13); font-family: -apple-system-body, ui-sans-serif, -apple-system, system-ui, &quot;Segoe UI&quot;, Helvetica, &quot;Apple Color Emoji&quot;, Arial, sans-serif, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;; font-size: 16px; letter-spacing: normal; white-space: pre-line; background-color: rgb(252, 252, 252);\"> </span><span data-d-streaming-word=\"\" style=\"color: rgb(13, 13, 13); font-family: -apple-system-body, ui-sans-serif, -apple-system, system-ui, &quot;Segoe UI&quot;, Helvetica, &quot;Apple Color Emoji&quot;, Arial, sans-serif, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;; font-size: 16px; letter-spacing: normal; white-space: pre-line; background-color: rgb(252, 252, 252);\">and</span><span style=\"color: rgb(13, 13, 13); font-family: -apple-system-body, ui-sans-serif, -apple-system, system-ui, &quot;Segoe UI&quot;, Helvetica, &quot;Apple Color Emoji&quot;, Arial, sans-serif, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;; font-size: 16px; letter-spacing: normal; white-space: pre-line; background-color: rgb(252, 252, 252);\"> </span><span data-d-streaming-word=\"\" style=\"color: rgb(13, 13, 13); font-family: -apple-system-body, ui-sans-serif, -apple-system, system-ui, &quot;Segoe UI&quot;, Helvetica, &quot;Apple Color Emoji&quot;, Arial, sans-serif, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;; font-size: 16px; letter-spacing: normal; white-space: pre-line; background-color: rgb(252, 252, 252);\">offers</span><span style=\"color: rgb(13, 13, 13); font-family: -apple-system-body, ui-sans-serif, -apple-system, system-ui, &quot;Segoe UI&quot;, Helvetica, &quot;Apple Color Emoji&quot;, Arial, sans-serif, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;; font-size: 16px; letter-spacing: normal; white-space: pre-line; background-color: rgb(252, 252, 252);\"> </span><span data-d-streaming-word=\"\" style=\"color: rgb(13, 13, 13); font-family: -apple-system-body, ui-sans-serif, -apple-system, system-ui, &quot;Segoe UI&quot;, Helvetica, &quot;Apple Color Emoji&quot;, Arial, sans-serif, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;; font-size: 16px; letter-spacing: normal; white-space: pre-line; background-color: rgb(252, 252, 252);\">comfortable</span><span style=\"color: rgb(13, 13, 13); font-family: -apple-system-body, ui-sans-serif, -apple-system, system-ui, &quot;Segoe UI&quot;, Helvetica, &quot;Apple Color Emoji&quot;, Arial, sans-serif, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;; font-size: 16px; letter-spacing: normal; white-space: pre-line; background-color: rgb(252, 252, 252);\"> </span><span data-d-streaming-word=\"\" style=\"color: rgb(13, 13, 13); font-family: -apple-system-body, ui-sans-serif, -apple-system, system-ui, &quot;Segoe UI&quot;, Helvetica, &quot;Apple Color Emoji&quot;, Arial, sans-serif, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;; font-size: 16px; letter-spacing: normal; white-space: pre-line; background-color: rgb(252, 252, 252);\">handling</span><span style=\"color: rgb(13, 13, 13); font-family: -apple-system-body, ui-sans-serif, -apple-system, system-ui, &quot;Segoe UI&quot;, Helvetica, &quot;Apple Color Emoji&quot;, Arial, sans-serif, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;; font-size: 16px; letter-spacing: normal; white-space: pre-line; background-color: rgb(252, 252, 252);\"> </span><span data-d-streaming-word=\"\" style=\"color: rgb(13, 13, 13); font-family: -apple-system-body, ui-sans-serif, -apple-system, system-ui, &quot;Segoe UI&quot;, Helvetica, &quot;Apple Color Emoji&quot;, Arial, sans-serif, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;; font-size: 16px; letter-spacing: normal; white-space: pre-line; background-color: rgb(252, 252, 252);\">during</span><span style=\"color: rgb(13, 13, 13); font-family: -apple-system-body, ui-sans-serif, -apple-system, system-ui, &quot;Segoe UI&quot;, Helvetica, &quot;Apple Color Emoji&quot;, Arial, sans-serif, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;; font-size: 16px; letter-spacing: normal; white-space: pre-line; background-color: rgb(252, 252, 252);\"> </span><span data-d-streaming-word=\"\" style=\"color: rgb(13, 13, 13); font-family: -apple-system-body, ui-sans-serif, -apple-system, system-ui, &quot;Segoe UI&quot;, Helvetica, &quot;Apple Color Emoji&quot;, Arial, sans-serif, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;; font-size: 16px; letter-spacing: normal; white-space: pre-line; background-color: rgb(252, 252, 252);\">long</span><span style=\"color: rgb(13, 13, 13); font-family: -apple-system-body, ui-sans-serif, -apple-system, system-ui, &quot;Segoe UI&quot;, Helvetica, &quot;Apple Color Emoji&quot;, Arial, sans-serif, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;; font-size: 16px; letter-spacing: normal; white-space: pre-line; background-color: rgb(252, 252, 252);\"> </span><span data-d-streaming-word=\"\" style=\"color: rgb(13, 13, 13); font-family: -apple-system-body, ui-sans-serif, -apple-system, system-ui, &quot;Segoe UI&quot;, Helvetica, &quot;Apple Color Emoji&quot;, Arial, sans-serif, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;; font-size: 16px; letter-spacing: normal; white-space: pre-line; background-color: rgb(252, 252, 252);\">gaming</span><span style=\"color: rgb(13, 13, 13); font-family: -apple-system-body, ui-sans-serif, -apple-system, system-ui, &quot;Segoe UI&quot;, Helvetica, &quot;Apple Color Emoji&quot;, Arial, sans-serif, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;; font-size: 16px; letter-spacing: normal; white-space: pre-line; background-color: rgb(252, 252, 252);\"> </span><span data-d-streaming-word=\"\" style=\"color: rgb(13, 13, 13); font-family: -apple-system-body, ui-sans-serif, -apple-system, system-ui, &quot;Segoe UI&quot;, Helvetica, &quot;Apple Color Emoji&quot;, Arial, sans-serif, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;; font-size: 16px; letter-spacing: normal; white-space: pre-line; background-color: rgb(252, 252, 252);\">sessions.</span></p>', 'A comfortable wireless gaming controller for an enjoyable gaming experience.', 3500.00, 3080.00, NULL, NULL, 0, 'vendor', 'products/thumbnails/2W20h203mvxvuWtrqIVEOxs6ZwPxkI4j7vCF2TTd.jpg', NULL, 'draft', 0, 1, 0, 0, '2026-10-31 06:42:43', '2026-10-31 06:42:43', NULL),
(54, 2, 2, 10, 4, 'Mini Projector', 'mini-projector', NULL, '<p><span data-d-streaming-word=\"\" style=\"color: rgb(13, 13, 13); font-family: -apple-system-body, ui-sans-serif, -apple-system, system-ui, &quot;Segoe UI&quot;, Helvetica, &quot;Apple Color Emoji&quot;, Arial, sans-serif, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;; font-size: 16px; letter-spacing: normal; white-space: pre-line; background-color: rgb(252, 252, 252);\">This</span><span style=\"color: rgb(13, 13, 13); font-family: -apple-system-body, ui-sans-serif, -apple-system, system-ui, &quot;Segoe UI&quot;, Helvetica, &quot;Apple Color Emoji&quot;, Arial, sans-serif, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;; font-size: 16px; letter-spacing: normal; white-space: pre-line; background-color: rgb(252, 252, 252);\"> </span><span data-d-streaming-word=\"\" style=\"color: rgb(13, 13, 13); font-family: -apple-system-body, ui-sans-serif, -apple-system, system-ui, &quot;Segoe UI&quot;, Helvetica, &quot;Apple Color Emoji&quot;, Arial, sans-serif, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;; font-size: 16px; letter-spacing: normal; white-space: pre-line; background-color: rgb(252, 252, 252);\">portable</span><span style=\"color: rgb(13, 13, 13); font-family: -apple-system-body, ui-sans-serif, -apple-system, system-ui, &quot;Segoe UI&quot;, Helvetica, &quot;Apple Color Emoji&quot;, Arial, sans-serif, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;; font-size: 16px; letter-spacing: normal; white-space: pre-line; background-color: rgb(252, 252, 252);\"> </span><span data-d-streaming-word=\"\" style=\"color: rgb(13, 13, 13); font-family: -apple-system-body, ui-sans-serif, -apple-system, system-ui, &quot;Segoe UI&quot;, Helvetica, &quot;Apple Color Emoji&quot;, Arial, sans-serif, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;; font-size: 16px; letter-spacing: normal; white-space: pre-line; background-color: rgb(252, 252, 252);\">mini</span><span style=\"color: rgb(13, 13, 13); font-family: -apple-system-body, ui-sans-serif, -apple-system, system-ui, &quot;Segoe UI&quot;, Helvetica, &quot;Apple Color Emoji&quot;, Arial, sans-serif, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;; font-size: 16px; letter-spacing: normal; white-space: pre-line; background-color: rgb(252, 252, 252);\"> </span><span data-d-streaming-word=\"\" style=\"color: rgb(13, 13, 13); font-family: -apple-system-body, ui-sans-serif, -apple-system, system-ui, &quot;Segoe UI&quot;, Helvetica, &quot;Apple Color Emoji&quot;, Arial, sans-serif, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;; font-size: 16px; letter-spacing: normal; white-space: pre-line; background-color: rgb(252, 252, 252);\">projector</span><span style=\"color: rgb(13, 13, 13); font-family: -apple-system-body, ui-sans-serif, -apple-system, system-ui, &quot;Segoe UI&quot;, Helvetica, &quot;Apple Color Emoji&quot;, Arial, sans-serif, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;; font-size: 16px; letter-spacing: normal; white-space: pre-line; background-color: rgb(252, 252, 252);\"> </span><span data-d-streaming-word=\"\" style=\"color: rgb(13, 13, 13); font-family: -apple-system-body, ui-sans-serif, -apple-system, system-ui, &quot;Segoe UI&quot;, Helvetica, &quot;Apple Color Emoji&quot;, Arial, sans-serif, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;; font-size: 16px; letter-spacing: normal; white-space: pre-line; background-color: rgb(252, 252, 252);\">is</span><span style=\"color: rgb(13, 13, 13); font-family: -apple-system-body, ui-sans-serif, -apple-system, system-ui, &quot;Segoe UI&quot;, Helvetica, &quot;Apple Color Emoji&quot;, Arial, sans-serif, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;; font-size: 16px; letter-spacing: normal; white-space: pre-line; background-color: rgb(252, 252, 252);\"> </span><span data-d-streaming-word=\"\" style=\"color: rgb(13, 13, 13); font-family: -apple-system-body, ui-sans-serif, -apple-system, system-ui, &quot;Segoe UI&quot;, Helvetica, &quot;Apple Color Emoji&quot;, Arial, sans-serif, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;; font-size: 16px; letter-spacing: normal; white-space: pre-line; background-color: rgb(252, 252, 252);\">designed</span><span style=\"color: rgb(13, 13, 13); font-family: -apple-system-body, ui-sans-serif, -apple-system, system-ui, &quot;Segoe UI&quot;, Helvetica, &quot;Apple Color Emoji&quot;, Arial, sans-serif, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;; font-size: 16px; letter-spacing: normal; white-space: pre-line; background-color: rgb(252, 252, 252);\"> </span><span data-d-streaming-word=\"\" style=\"color: rgb(13, 13, 13); font-family: -apple-system-body, ui-sans-serif, -apple-system, system-ui, &quot;Segoe UI&quot;, Helvetica, &quot;Apple Color Emoji&quot;, Arial, sans-serif, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;; font-size: 16px; letter-spacing: normal; white-space: pre-line; background-color: rgb(252, 252, 252);\">for</span><span style=\"color: rgb(13, 13, 13); font-family: -apple-system-body, ui-sans-serif, -apple-system, system-ui, &quot;Segoe UI&quot;, Helvetica, &quot;Apple Color Emoji&quot;, Arial, sans-serif, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;; font-size: 16px; letter-spacing: normal; white-space: pre-line; background-color: rgb(252, 252, 252);\"> </span><span data-d-streaming-word=\"\" style=\"color: rgb(13, 13, 13); font-family: -apple-system-body, ui-sans-serif, -apple-system, system-ui, &quot;Segoe UI&quot;, Helvetica, &quot;Apple Color Emoji&quot;, Arial, sans-serif, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;; font-size: 16px; letter-spacing: normal; white-space: pre-line; background-color: rgb(252, 252, 252);\">home</span><span style=\"color: rgb(13, 13, 13); font-family: -apple-system-body, ui-sans-serif, -apple-system, system-ui, &quot;Segoe UI&quot;, Helvetica, &quot;Apple Color Emoji&quot;, Arial, sans-serif, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;; font-size: 16px; letter-spacing: normal; white-space: pre-line; background-color: rgb(252, 252, 252);\"> </span><span data-d-streaming-word=\"\" style=\"color: rgb(13, 13, 13); font-family: -apple-system-body, ui-sans-serif, -apple-system, system-ui, &quot;Segoe UI&quot;, Helvetica, &quot;Apple Color Emoji&quot;, Arial, sans-serif, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;; font-size: 16px; letter-spacing: normal; white-space: pre-line; background-color: rgb(252, 252, 252);\">entertainment,</span><span style=\"color: rgb(13, 13, 13); font-family: -apple-system-body, ui-sans-serif, -apple-system, system-ui, &quot;Segoe UI&quot;, Helvetica, &quot;Apple Color Emoji&quot;, Arial, sans-serif, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;; font-size: 16px; letter-spacing: normal; white-space: pre-line; background-color: rgb(252, 252, 252);\"> </span><span data-d-streaming-word=\"\" style=\"color: rgb(13, 13, 13); font-family: -apple-system-body, ui-sans-serif, -apple-system, system-ui, &quot;Segoe UI&quot;, Helvetica, &quot;Apple Color Emoji&quot;, Arial, sans-serif, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;; font-size: 16px; letter-spacing: normal; white-space: pre-line; background-color: rgb(252, 252, 252);\">office</span><span style=\"color: rgb(13, 13, 13); font-family: -apple-system-body, ui-sans-serif, -apple-system, system-ui, &quot;Segoe UI&quot;, Helvetica, &quot;Apple Color Emoji&quot;, Arial, sans-serif, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;; font-size: 16px; letter-spacing: normal; white-space: pre-line; background-color: rgb(252, 252, 252);\"> </span><span data-d-streaming-word=\"\" style=\"color: rgb(13, 13, 13); font-family: -apple-system-body, ui-sans-serif, -apple-system, system-ui, &quot;Segoe UI&quot;, Helvetica, &quot;Apple Color Emoji&quot;, Arial, sans-serif, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;; font-size: 16px; letter-spacing: normal; white-space: pre-line; background-color: rgb(252, 252, 252);\">presentations,</span><span style=\"color: rgb(13, 13, 13); font-family: -apple-system-body, ui-sans-serif, -apple-system, system-ui, &quot;Segoe UI&quot;, Helvetica, &quot;Apple Color Emoji&quot;, Arial, sans-serif, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;; font-size: 16px; letter-spacing: normal; white-space: pre-line; background-color: rgb(252, 252, 252);\"> </span><span data-d-streaming-word=\"\" style=\"color: rgb(13, 13, 13); font-family: -apple-system-body, ui-sans-serif, -apple-system, system-ui, &quot;Segoe UI&quot;, Helvetica, &quot;Apple Color Emoji&quot;, Arial, sans-serif, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;; font-size: 16px; letter-spacing: normal; white-space: pre-line; background-color: rgb(252, 252, 252);\">and</span><span style=\"color: rgb(13, 13, 13); font-family: -apple-system-body, ui-sans-serif, -apple-system, system-ui, &quot;Segoe UI&quot;, Helvetica, &quot;Apple Color Emoji&quot;, Arial, sans-serif, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;; font-size: 16px; letter-spacing: normal; white-space: pre-line; background-color: rgb(252, 252, 252);\"> </span><span data-d-streaming-word=\"\" style=\"color: rgb(13, 13, 13); font-family: -apple-system-body, ui-sans-serif, -apple-system, system-ui, &quot;Segoe UI&quot;, Helvetica, &quot;Apple Color Emoji&quot;, Arial, sans-serif, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;; font-size: 16px; letter-spacing: normal; white-space: pre-line; background-color: rgb(252, 252, 252);\">movie</span><span style=\"color: rgb(13, 13, 13); font-family: -apple-system-body, ui-sans-serif, -apple-system, system-ui, &quot;Segoe UI&quot;, Helvetica, &quot;Apple Color Emoji&quot;, Arial, sans-serif, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;; font-size: 16px; letter-spacing: normal; white-space: pre-line; background-color: rgb(252, 252, 252);\"> </span><span data-d-streaming-word=\"\" style=\"color: rgb(13, 13, 13); font-family: -apple-system-body, ui-sans-serif, -apple-system, system-ui, &quot;Segoe UI&quot;, Helvetica, &quot;Apple Color Emoji&quot;, Arial, sans-serif, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;; font-size: 16px; letter-spacing: normal; white-space: pre-line; background-color: rgb(252, 252, 252);\">nights.</span><span style=\"color: rgb(13, 13, 13); font-family: -apple-system-body, ui-sans-serif, -apple-system, system-ui, &quot;Segoe UI&quot;, Helvetica, &quot;Apple Color Emoji&quot;, Arial, sans-serif, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;; font-size: 16px; letter-spacing: normal; white-space: pre-line; background-color: rgb(252, 252, 252);\"> </span><span data-d-streaming-word=\"\" style=\"color: rgb(13, 13, 13); font-family: -apple-system-body, ui-sans-serif, -apple-system, system-ui, &quot;Segoe UI&quot;, Helvetica, &quot;Apple Color Emoji&quot;, Arial, sans-serif, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;; font-size: 16px; letter-spacing: normal; white-space: pre-line; background-color: rgb(252, 252, 252);\">Its</span><span style=\"color: rgb(13, 13, 13); font-family: -apple-system-body, ui-sans-serif, -apple-system, system-ui, &quot;Segoe UI&quot;, Helvetica, &quot;Apple Color Emoji&quot;, Arial, sans-serif, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;; font-size: 16px; letter-spacing: normal; white-space: pre-line; background-color: rgb(252, 252, 252);\"> </span><span data-d-streaming-word=\"\" style=\"color: rgb(13, 13, 13); font-family: -apple-system-body, ui-sans-serif, -apple-system, system-ui, &quot;Segoe UI&quot;, Helvetica, &quot;Apple Color Emoji&quot;, Arial, sans-serif, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;; font-size: 16px; letter-spacing: normal; white-space: pre-line; background-color: rgb(252, 252, 252);\">compact</span><span style=\"color: rgb(13, 13, 13); font-family: -apple-system-body, ui-sans-serif, -apple-system, system-ui, &quot;Segoe UI&quot;, Helvetica, &quot;Apple Color Emoji&quot;, Arial, sans-serif, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;; font-size: 16px; letter-spacing: normal; white-space: pre-line; background-color: rgb(252, 252, 252);\"> </span><span data-d-streaming-word=\"\" style=\"color: rgb(13, 13, 13); font-family: -apple-system-body, ui-sans-serif, -apple-system, system-ui, &quot;Segoe UI&quot;, Helvetica, &quot;Apple Color Emoji&quot;, Arial, sans-serif, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;; font-size: 16px; letter-spacing: normal; white-space: pre-line; background-color: rgb(252, 252, 252);\">design</span><span style=\"color: rgb(13, 13, 13); font-family: -apple-system-body, ui-sans-serif, -apple-system, system-ui, &quot;Segoe UI&quot;, Helvetica, &quot;Apple Color Emoji&quot;, Arial, sans-serif, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;; font-size: 16px; letter-spacing: normal; white-space: pre-line; background-color: rgb(252, 252, 252);\"> </span><span data-d-streaming-word=\"\" style=\"color: rgb(13, 13, 13); font-family: -apple-system-body, ui-sans-serif, -apple-system, system-ui, &quot;Segoe UI&quot;, Helvetica, &quot;Apple Color Emoji&quot;, Arial, sans-serif, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;; font-size: 16px; letter-spacing: normal; white-space: pre-line; background-color: rgb(252, 252, 252);\">makes</span><span style=\"color: rgb(13, 13, 13); font-family: -apple-system-body, ui-sans-serif, -apple-system, system-ui, &quot;Segoe UI&quot;, Helvetica, &quot;Apple Color Emoji&quot;, Arial, sans-serif, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;; font-size: 16px; letter-spacing: normal; white-space: pre-line; background-color: rgb(252, 252, 252);\"> </span><span data-d-streaming-word=\"\" style=\"color: rgb(13, 13, 13); font-family: -apple-system-body, ui-sans-serif, -apple-system, system-ui, &quot;Segoe UI&quot;, Helvetica, &quot;Apple Color Emoji&quot;, Arial, sans-serif, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;; font-size: 16px; letter-spacing: normal; white-space: pre-line; background-color: rgb(252, 252, 252);\">it</span><span style=\"color: rgb(13, 13, 13); font-family: -apple-system-body, ui-sans-serif, -apple-system, system-ui, &quot;Segoe UI&quot;, Helvetica, &quot;Apple Color Emoji&quot;, Arial, sans-serif, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;; font-size: 16px; letter-spacing: normal; white-space: pre-line; background-color: rgb(252, 252, 252);\"> </span><span data-d-streaming-word=\"\" style=\"color: rgb(13, 13, 13); font-family: -apple-system-body, ui-sans-serif, -apple-system, system-ui, &quot;Segoe UI&quot;, Helvetica, &quot;Apple Color Emoji&quot;, Arial, sans-serif, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;; font-size: 16px; letter-spacing: normal; white-space: pre-line; background-color: rgb(252, 252, 252);\">easy</span><span style=\"color: rgb(13, 13, 13); font-family: -apple-system-body, ui-sans-serif, -apple-system, system-ui, &quot;Segoe UI&quot;, Helvetica, &quot;Apple Color Emoji&quot;, Arial, sans-serif, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;; font-size: 16px; letter-spacing: normal; white-space: pre-line; background-color: rgb(252, 252, 252);\"> </span><span data-d-streaming-word=\"\" style=\"color: rgb(13, 13, 13); font-family: -apple-system-body, ui-sans-serif, -apple-system, system-ui, &quot;Segoe UI&quot;, Helvetica, &quot;Apple Color Emoji&quot;, Arial, sans-serif, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;; font-size: 16px; letter-spacing: normal; white-space: pre-line; background-color: rgb(252, 252, 252);\">to</span><span style=\"color: rgb(13, 13, 13); font-family: -apple-system-body, ui-sans-serif, -apple-system, system-ui, &quot;Segoe UI&quot;, Helvetica, &quot;Apple Color Emoji&quot;, Arial, sans-serif, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;; font-size: 16px; letter-spacing: normal; white-space: pre-line; background-color: rgb(252, 252, 252);\"> </span><span data-d-streaming-word=\"\" style=\"color: rgb(13, 13, 13); font-family: -apple-system-body, ui-sans-serif, -apple-system, system-ui, &quot;Segoe UI&quot;, Helvetica, &quot;Apple Color Emoji&quot;, Arial, sans-serif, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;; font-size: 16px; letter-spacing: normal; white-space: pre-line; background-color: rgb(252, 252, 252);\">carry</span><span style=\"color: rgb(13, 13, 13); font-family: -apple-system-body, ui-sans-serif, -apple-system, system-ui, &quot;Segoe UI&quot;, Helvetica, &quot;Apple Color Emoji&quot;, Arial, sans-serif, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;; font-size: 16px; letter-spacing: normal; white-space: pre-line; background-color: rgb(252, 252, 252);\"> </span><span data-d-streaming-word=\"\" style=\"color: rgb(13, 13, 13); font-family: -apple-system-body, ui-sans-serif, -apple-system, system-ui, &quot;Segoe UI&quot;, Helvetica, &quot;Apple Color Emoji&quot;, Arial, sans-serif, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;; font-size: 16px; letter-spacing: normal; white-space: pre-line; background-color: rgb(252, 252, 252);\">and</span><span style=\"color: rgb(13, 13, 13); font-family: -apple-system-body, ui-sans-serif, -apple-system, system-ui, &quot;Segoe UI&quot;, Helvetica, &quot;Apple Color Emoji&quot;, Arial, sans-serif, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;; font-size: 16px; letter-spacing: normal; white-space: pre-line; background-color: rgb(252, 252, 252);\"> </span><span data-d-streaming-word=\"\" style=\"color: rgb(13, 13, 13); font-family: -apple-system-body, ui-sans-serif, -apple-system, system-ui, &quot;Segoe UI&quot;, Helvetica, &quot;Apple Color Emoji&quot;, Arial, sans-serif, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;; font-size: 16px; letter-spacing: normal; white-space: pre-line; background-color: rgb(252, 252, 252);\">use</span><span style=\"color: rgb(13, 13, 13); font-family: -apple-system-body, ui-sans-serif, -apple-system, system-ui, &quot;Segoe UI&quot;, Helvetica, &quot;Apple Color Emoji&quot;, Arial, sans-serif, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;; font-size: 16px; letter-spacing: normal; white-space: pre-line; background-color: rgb(252, 252, 252);\"> </span><span data-d-streaming-word=\"\" style=\"color: rgb(13, 13, 13); font-family: -apple-system-body, ui-sans-serif, -apple-system, system-ui, &quot;Segoe UI&quot;, Helvetica, &quot;Apple Color Emoji&quot;, Arial, sans-serif, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;; font-size: 16px; letter-spacing: normal; white-space: pre-line; background-color: rgb(252, 252, 252);\">in</span><span style=\"color: rgb(13, 13, 13); font-family: -apple-system-body, ui-sans-serif, -apple-system, system-ui, &quot;Segoe UI&quot;, Helvetica, &quot;Apple Color Emoji&quot;, Arial, sans-serif, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;; font-size: 16px; letter-spacing: normal; white-space: pre-line; background-color: rgb(252, 252, 252);\"> </span><span data-d-streaming-word=\"\" style=\"color: rgb(13, 13, 13); font-family: -apple-system-body, ui-sans-serif, -apple-system, system-ui, &quot;Segoe UI&quot;, Helvetica, &quot;Apple Color Emoji&quot;, Arial, sans-serif, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;; font-size: 16px; letter-spacing: normal; white-space: pre-line; background-color: rgb(252, 252, 252);\">different</span><span style=\"color: rgb(13, 13, 13); font-family: -apple-system-body, ui-sans-serif, -apple-system, system-ui, &quot;Segoe UI&quot;, Helvetica, &quot;Apple Color Emoji&quot;, Arial, sans-serif, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;; font-size: 16px; letter-spacing: normal; white-space: pre-line; background-color: rgb(252, 252, 252);\"> </span><span data-d-streaming-word=\"\" style=\"color: rgb(13, 13, 13); font-family: -apple-system-body, ui-sans-serif, -apple-system, system-ui, &quot;Segoe UI&quot;, Helvetica, &quot;Apple Color Emoji&quot;, Arial, sans-serif, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;; font-size: 16px; letter-spacing: normal; white-space: pre-line; background-color: rgb(252, 252, 252);\">environments.</span></p>', 'A compact mini projector for enjoying movies and presentations on a big screen.', 2500.00, 2375.00, NULL, NULL, 0, 'vendor', 'products/thumbnails/BO1VWayRHh7NEdRwg1rTh5uhl0PJ7xnrHELVICiQ.jpg', NULL, 'draft', 0, 0, 1, 0, '2026-10-31 06:44:35', '2026-10-31 06:44:35', NULL),
(55, 1, 31, NULL, NULL, 'Small Appliances Sample 1', 'small-appliances-sample-1', 'SMAL-S1', 'Small Appliances sample product description 1', 'Small Appliances sample product 1', 25000.00, 23750.00, 19000.00, NULL, 0, 'vendor', NULL, NULL, 'draft', 1, 1, 1, 0, '2026-11-01 06:55:40', '2026-11-01 06:55:40', NULL),
(56, 1, 31, NULL, NULL, 'Small Appliances Sample 2', 'small-appliances-sample-2', 'SMAL-S2', 'Small Appliances sample product description 2', 'Small Appliances sample product 2', 30000.00, 27000.00, 23000.00, NULL, 0, 'vendor', NULL, NULL, 'draft', 1, 1, 1, 0, '2026-11-01 06:55:40', '2026-11-01 06:55:40', NULL),
(57, 1, 31, NULL, NULL, 'Small Appliances Sample 3', 'small-appliances-sample-3', 'SMAL-S3', 'Small Appliances sample product description 3', 'Small Appliances sample product 3', 35000.00, 29750.00, 27000.00, NULL, 0, 'vendor', NULL, NULL, 'draft', 1, 1, 1, 0, '2026-11-01 06:55:40', '2026-11-01 06:55:40', NULL),
(58, 1, 31, NULL, NULL, 'Small Appliances Sample 4', 'small-appliances-sample-4', 'SMAL-S4', 'Small Appliances sample product description 4', 'Small Appliances sample product 4', 40000.00, 32000.00, 31000.00, NULL, 0, 'vendor', NULL, NULL, 'draft', 1, 1, 1, 0, '2026-11-01 06:55:40', '2026-11-01 06:55:40', NULL),
(59, 1, 31, NULL, NULL, 'Small Appliances Sample 5', 'small-appliances-sample-5', 'SMAL-S5', 'Small Appliances sample product description 5', 'Small Appliances sample product 5', 45000.00, 33750.00, 35000.00, NULL, 0, 'vendor', NULL, NULL, 'draft', 1, 1, 1, 0, '2026-11-01 06:55:40', '2026-11-01 06:55:40', NULL),
(60, 1, 52, NULL, NULL, 'Air Conditioner Sample 1', 'air-conditioner-sample-1', 'AIRC-S1', 'Air Conditioner sample product description 1', 'Air Conditioner sample product 1', 25000.00, 23750.00, 19000.00, NULL, 0, 'vendor', NULL, NULL, 'draft', 1, 1, 1, 0, '2026-11-01 06:55:40', '2026-11-01 06:55:40', NULL),
(61, 1, 52, NULL, NULL, 'Air Conditioner Sample 2', 'air-conditioner-sample-2', 'AIRC-S2', 'Air Conditioner sample product description 2', 'Air Conditioner sample product 2', 30000.00, 27000.00, 23000.00, NULL, 0, 'vendor', NULL, NULL, 'draft', 1, 1, 1, 0, '2026-11-01 06:55:40', '2026-11-01 06:55:40', NULL),
(62, 1, 52, NULL, NULL, 'Air Conditioner Sample 3', 'air-conditioner-sample-3', 'AIRC-S3', 'Air Conditioner sample product description 3', 'Air Conditioner sample product 3', 35000.00, 29750.00, 27000.00, NULL, 0, 'vendor', NULL, NULL, 'draft', 1, 1, 1, 0, '2026-11-01 06:55:40', '2026-11-01 06:55:40', NULL),
(63, 1, 52, NULL, NULL, 'Air Conditioner Sample 4', 'air-conditioner-sample-4', 'AIRC-S4', 'Air Conditioner sample product description 4', 'Air Conditioner sample product 4', 40000.00, 32000.00, 31000.00, NULL, 0, 'vendor', NULL, NULL, 'draft', 1, 1, 1, 0, '2026-11-01 06:55:40', '2026-11-01 06:55:40', NULL),
(64, 1, 52, NULL, NULL, 'Air Conditioner Sample 5', 'air-conditioner-sample-5', 'AIRC-S5', 'Air Conditioner sample product description 5', 'Air Conditioner sample product 5', 45000.00, 33750.00, 35000.00, NULL, 0, 'vendor', NULL, NULL, 'draft', 1, 1, 1, 0, '2026-11-01 06:55:40', '2026-11-01 06:55:40', NULL),
(65, 1, 53, NULL, NULL, 'Television Sample 1', 'television-sample-1', 'TELE-S1', 'Television sample product description 1', 'Television sample product 1', 25000.00, 23750.00, 19000.00, NULL, 0, 'vendor', NULL, NULL, 'draft', 1, 1, 1, 0, '2026-11-01 06:55:40', '2026-11-01 06:55:40', NULL),
(66, 1, 53, NULL, NULL, 'Television Sample 2', 'television-sample-2', 'TELE-S2', 'Television sample product description 2', 'Television sample product 2', 30000.00, 27000.00, 23000.00, NULL, 0, 'vendor', NULL, NULL, 'draft', 1, 1, 1, 0, '2026-11-01 06:55:40', '2026-11-01 06:55:40', NULL),
(67, 1, 53, NULL, NULL, 'Television Sample 3', 'television-sample-3', 'TELE-S3', 'Television sample product description 3', 'Television sample product 3', 35000.00, 29750.00, 27000.00, NULL, 0, 'vendor', NULL, NULL, 'draft', 1, 1, 1, 0, '2026-11-01 06:55:40', '2026-11-01 06:55:40', NULL),
(68, 1, 53, NULL, NULL, 'Television Sample 4', 'television-sample-4', 'TELE-S4', 'Television sample product description 4', 'Television sample product 4', 40000.00, 32000.00, 31000.00, NULL, 0, 'vendor', NULL, NULL, 'draft', 1, 1, 1, 0, '2026-11-01 06:55:40', '2026-11-01 06:55:40', NULL),
(69, 1, 53, NULL, NULL, 'Television Sample 5', 'television-sample-5', 'TELE-S5', 'Television sample product description 5', 'Television sample product 5', 45000.00, 33750.00, 35000.00, NULL, 0, 'vendor', NULL, NULL, 'draft', 1, 1, 1, 0, '2026-11-01 06:55:40', '2026-11-01 06:55:40', NULL),
(70, 1, 54, NULL, NULL, 'Refrigerator Sample 1', 'refrigerator-sample-1', 'REFR-S1', 'Refrigerator sample product description 1', 'Refrigerator sample product 1', 25000.00, 23750.00, 19000.00, NULL, 0, 'vendor', NULL, NULL, 'draft', 1, 1, 1, 0, '2026-11-01 06:55:40', '2026-11-01 06:55:40', NULL),
(71, 1, 54, NULL, NULL, 'Refrigerator Sample 2', 'refrigerator-sample-2', 'REFR-S2', 'Refrigerator sample product description 2', 'Refrigerator sample product 2', 30000.00, 27000.00, 23000.00, NULL, 0, 'vendor', NULL, NULL, 'draft', 1, 1, 1, 0, '2026-11-01 06:55:40', '2026-11-01 06:55:40', NULL),
(72, 1, 54, NULL, NULL, 'Refrigerator Sample 3', 'refrigerator-sample-3', 'REFR-S3', 'Refrigerator sample product description 3', 'Refrigerator sample product 3', 35000.00, 29750.00, 27000.00, NULL, 0, 'vendor', NULL, NULL, 'draft', 1, 1, 1, 0, '2026-11-01 06:55:40', '2026-11-01 06:55:40', NULL),
(73, 1, 54, NULL, NULL, 'Refrigerator Sample 4', 'refrigerator-sample-4', 'REFR-S4', 'Refrigerator sample product description 4', 'Refrigerator sample product 4', 40000.00, 32000.00, 31000.00, NULL, 0, 'vendor', NULL, NULL, 'draft', 1, 1, 1, 0, '2026-11-01 06:55:40', '2026-11-01 06:55:40', NULL),
(74, 1, 54, NULL, NULL, 'Refrigerator Sample 5', 'refrigerator-sample-5', 'REFR-S5', 'Refrigerator sample product description 5', 'Refrigerator sample product 5', 45000.00, 33750.00, 35000.00, NULL, 0, 'vendor', NULL, NULL, 'draft', 1, 1, 1, 0, '2026-11-01 06:55:40', '2026-11-01 06:55:40', NULL),
(75, 1, NULL, NULL, NULL, 'Washing Machine Sample 1', 'washing-machine-sample-1', 'WASH-S1', 'Washing Machine sample product description 1', 'Washing Machine sample product 1', 25000.00, 23750.00, 19000.00, NULL, 0, 'vendor', NULL, NULL, 'draft', 1, 1, 1, 0, '2026-11-01 06:55:40', '2026-11-01 06:55:40', NULL),
(76, 1, NULL, NULL, NULL, 'Washing Machine Sample 2', 'washing-machine-sample-2', 'WASH-S2', 'Washing Machine sample product description 2', 'Washing Machine sample product 2', 30000.00, 27000.00, 23000.00, NULL, 0, 'vendor', NULL, NULL, 'draft', 1, 1, 1, 0, '2026-11-01 06:55:40', '2026-11-01 06:55:40', NULL),
(77, 1, NULL, NULL, NULL, 'Washing Machine Sample 3', 'washing-machine-sample-3', 'WASH-S3', 'Washing Machine sample product description 3', 'Washing Machine sample product 3', 35000.00, 29750.00, 27000.00, NULL, 0, 'vendor', NULL, NULL, 'draft', 1, 1, 1, 0, '2026-11-01 06:55:40', '2026-11-01 06:55:40', NULL),
(78, 1, NULL, NULL, NULL, 'Washing Machine Sample 4', 'washing-machine-sample-4', 'WASH-S4', 'Washing Machine sample product description 4', 'Washing Machine sample product 4', 40000.00, 32000.00, 31000.00, NULL, 0, 'vendor', NULL, NULL, 'draft', 1, 1, 1, 0, '2026-11-01 06:55:40', '2026-11-01 06:55:40', NULL),
(79, 1, NULL, NULL, NULL, 'Washing Machine Sample 5', 'washing-machine-sample-5', 'WASH-S5', 'Washing Machine sample product description 5', 'Washing Machine sample product 5', 45000.00, 33750.00, 35000.00, NULL, 0, 'vendor', NULL, NULL, 'draft', 1, 1, 1, 0, '2026-11-01 06:55:40', '2026-11-01 06:55:40', NULL);
INSERT INTO `products` (`id`, `vendor_id`, `category_id`, `sub_category_id`, `brand_id`, `name`, `slug`, `sku`, `description`, `short_description`, `price`, `discount_price`, `cost_price`, `tags`, `stock_quantity`, `product_type`, `thumbnail`, `sponsored_video_url`, `status`, `is_new`, `is_featured`, `is_hot`, `views_count`, `created_at`, `updated_at`, `deleted_at`) VALUES
(80, 1, 56, NULL, NULL, 'Microwave Oven Sample 1', 'microwave-oven-sample-1', 'MICR-S1', 'Microwave Oven sample product description 1', 'Microwave Oven sample product 1', 25000.00, 23750.00, 19000.00, NULL, 0, 'vendor', NULL, NULL, 'draft', 1, 1, 1, 0, '2026-11-01 06:55:40', '2026-11-01 06:55:40', NULL),
(81, 1, 56, NULL, NULL, 'Microwave Oven Sample 2', 'microwave-oven-sample-2', 'MICR-S2', 'Microwave Oven sample product description 2', 'Microwave Oven sample product 2', 30000.00, 27000.00, 23000.00, NULL, 0, 'vendor', NULL, NULL, 'draft', 1, 1, 1, 0, '2026-11-01 06:55:40', '2026-11-01 06:55:40', NULL),
(82, 1, 56, NULL, NULL, 'Microwave Oven Sample 3', 'microwave-oven-sample-3', 'MICR-S3', 'Microwave Oven sample product description 3', 'Microwave Oven sample product 3', 35000.00, 29750.00, 27000.00, NULL, 0, 'vendor', NULL, NULL, 'draft', 1, 1, 1, 0, '2026-11-01 06:55:40', '2026-11-01 06:55:40', NULL),
(83, 1, 56, NULL, NULL, 'Microwave Oven Sample 4', 'microwave-oven-sample-4', 'MICR-S4', 'Microwave Oven sample product description 4', 'Microwave Oven sample product 4', 40000.00, 32000.00, 31000.00, NULL, 0, 'vendor', NULL, NULL, 'draft', 1, 1, 1, 0, '2026-11-01 06:55:40', '2026-11-01 06:55:40', NULL),
(84, 1, 56, NULL, NULL, 'Microwave Oven Sample 5', 'microwave-oven-sample-5', 'MICR-S5', 'Microwave Oven sample product description 5', 'Microwave Oven sample product 5', 45000.00, 33750.00, 35000.00, NULL, 0, 'vendor', 'products/thumbnails/j6IvOgOJjdibd3AE40cKyrxJpdVfh4Q62WKp9ht4.webp', NULL, 'draft', 1, 1, 1, 0, '2026-11-01 06:55:40', '2026-11-01 05:49:54', NULL),
(85, NULL, 52, 60, 11, 'Hisense Smart Compact Inverter Air Conditioner AS18TW4RGSKB02DU', 'hisense-as18tw4rgskb02du', 'AS18TW4RGSKB02DU', '<p>Hisense Smart Compact series inverter air conditioner. Model: AS18TW4RGSKB02DU.</p><h5>Warranty</h5><ul><li>Compressor: 12 Years (Inverter)</li><li>Mainboard: 5 Years</li><li>Spare parts: 5 Years</li><li>Service: 2 Years Free Service (2 times Hydro Wash Free)</li></ul>', 'Smart Compact series inverter air conditioner. Model: AS18TW4RGSKB02DU.', 73900.00, NULL, 50500.00, 'hisense, air conditioner, inverter ac', 0, 'vendor', NULL, NULL, 'draft', 0, 0, 0, 0, '2026-11-02 12:07:01', '2026-11-02 12:07:01', NULL),
(86, NULL, 52, 60, 11, 'Hisense Smart Cool Inverter Air Conditioner AS18TW4RMATD01BU', 'hisense-as18tw4rmatd01bu', 'AS18TW4RMATD01BU', '<p>Hisense Smart Cool series inverter air conditioner. Model: AS18TW4RMATD01BU.</p><h5>Warranty</h5><ul><li>Compressor: 12 Years (Inverter)</li><li>Mainboard: 5 Years</li><li>Spare parts: 5 Years</li><li>Service: 2 Years Free Service (2 times Hydro Wash Free)</li></ul>', 'Smart Cool series inverter air conditioner. Model: AS18TW4RMATD01BU.', 79900.00, NULL, 57000.00, 'hisense, air conditioner, inverter ac', 0, 'vendor', NULL, NULL, 'draft', 0, 0, 0, 0, '2026-11-02 12:07:01', '2026-11-02 12:07:01', NULL),
(87, NULL, 52, 60, 11, 'Hisense Smart Cool Inverter Air Conditioner AS22TW4RXBTD00BU', 'hisense-as22tw4rxbtd00bu', 'AS22TW4RXBTD00BU', '<p>Hisense Smart Cool series inverter air conditioner. Model: AS22TW4RXBTD00BU.</p><h5>Warranty</h5><ul><li>Compressor: 12 Years (Inverter)</li><li>Mainboard: 5 Years</li><li>Spare parts: 5 Years</li><li>Service: 2 Years Free Service (2 times Hydro Wash Free)</li></ul>', 'Smart Cool series inverter air conditioner. Model: AS22TW4RXBTD00BU.', 95900.00, NULL, 68500.00, 'hisense, air conditioner, inverter ac', 0, 'vendor', NULL, NULL, 'draft', 0, 0, 0, 0, '2026-11-02 12:07:01', '2026-11-02 12:07:01', NULL),
(88, NULL, 52, 60, 11, 'Hisense Smart WiFi Inverter Air Conditioner AS18TZ4RMATD01AU', 'hisense-as18tz4rmatd01au', 'AS18TZ4RMATD01AU', '<p>Hisense Smart WiFi series inverter air conditioner. Model: AS18TZ4RMATD01AU.</p><h5>Warranty</h5><ul><li>Compressor: 12 Years (Inverter)</li><li>Mainboard: 5 Years</li><li>Spare parts: 5 Years</li><li>Service: 2 Years Free Service (2 times Hydro Wash Free)</li></ul>', 'Smart WiFi series inverter air conditioner. Model: AS18TZ4RMATD01AU.', 81900.00, NULL, 60000.00, 'hisense, air conditioner, inverter ac', 0, 'vendor', NULL, NULL, 'draft', 0, 0, 0, 0, '2026-11-02 12:07:01', '2026-11-02 12:07:01', NULL),
(89, NULL, 52, 60, 11, 'Hisense Smart WiFi Inverter Air Conditioner AS22TZ4RMATD00AU', 'hisense-as22tz4rmatd00au', 'AS22TZ4RMATD00AU', '<p>Hisense Smart WiFi series inverter air conditioner. Model: AS22TZ4RMATD00AU.</p><h5>Warranty</h5><ul><li>Compressor: 12 Years (Inverter)</li><li>Mainboard: 5 Years</li><li>Spare parts: 5 Years</li><li>Service: 2 Years Free Service (2 times Hydro Wash Free)</li></ul>', 'Smart WiFi series inverter air conditioner. Model: AS22TZ4RMATD00AU.', 99900.00, NULL, 75000.00, 'hisense, air conditioner, inverter ac', 0, 'vendor', NULL, NULL, 'draft', 0, 0, 0, 0, '2026-11-02 12:07:01', '2026-11-02 12:07:01', NULL),
(90, NULL, 52, 62, 11, 'Hisense LCAC Cassette Inverter Air Conditioner AUC48TRFRQKA2U', 'hisense-auc48trfrqka2u', 'AUC48TRFRQKA2U', '<p>Hisense LCAC Cassette series inverter air conditioner. Model: AUC48TRFRQKA2U.</p><h5>Warranty</h5><ul><li>Compressor: 6 Years</li><li>Mainboard: 2 Years</li><li>Spare parts: 2 Years</li><li>Service: 2 Years Free Service (2 times Hydro Wash Free)</li></ul>', 'LCAC Cassette series inverter air conditioner. Model: AUC48TRFRQKA2U.', 223900.00, NULL, 188000.00, 'hisense, air conditioner, inverter ac', 0, 'vendor', NULL, NULL, 'draft', 0, 0, 0, 0, '2026-11-02 12:07:01', '2026-11-02 12:07:01', NULL),
(92, NULL, 54, 63, 11, 'Hisense 238L Refrigerator RTDG238NAB - Premium Black', 'hisense-rtdg238nab-bd3', 'RTDG238NAB/BD3', '<p>238 Litre Top Mount Freezer refrigerator. Color: Premium Black. Model: RTDG238NAB/BD3.</p>', '238 Litre Top Mount Freezer refrigerator. Color: Premium Black.', 42900.00, NULL, 33462.00, 'hisense, refrigerator, fridge', 0, 'vendor', NULL, NULL, 'draft', 0, 0, 0, 0, '2026-11-02 12:07:12', '2026-11-02 12:07:12', NULL),
(93, NULL, 54, 63, 11, 'Hisense 238L Refrigerator RTDG238NASR - Starry Red', 'hisense-rtdg238nasr-bd3', 'RTDG238NASR/BD3', '<p>238 Litre Top Mount Freezer refrigerator. Color: Starry Red. Model: RTDG238NASR/BD3.</p>', '238 Litre Top Mount Freezer refrigerator. Color: Starry Red.', 42900.00, NULL, 33462.00, 'hisense, refrigerator, fridge', 0, 'vendor', NULL, NULL, 'draft', 0, 0, 0, 0, '2026-11-02 12:07:12', '2026-11-02 12:07:12', NULL),
(94, NULL, 54, 63, 11, 'Hisense 238L Refrigerator RTDG238NADP - Dreamy Purple', 'hisense-rtdg238nadp-bd3', 'RTDG238NADP/BD3', '<p>238 Litre Top Mount Freezer refrigerator. Color: Dreamy Purple. Model: RTDG238NADP/BD3.</p>', '238 Litre Top Mount Freezer refrigerator. Color: Dreamy Purple.', 42900.00, NULL, 33462.00, 'hisense, refrigerator, fridge', 0, 'vendor', NULL, NULL, 'draft', 0, 0, 0, 0, '2026-11-02 12:07:12', '2026-11-02 12:07:12', NULL),
(95, NULL, 54, 63, 11, 'Hisense 238L Refrigerator RTDG238NAAB - Avatar Black', 'hisense-rtdg238naab-bd3', 'RTDG238NAAB/BD3', '<p>238 Litre Top Mount Freezer refrigerator. Color: Avatar Black. Model: RTDG238NAAB/BD3.</p>', '238 Litre Top Mount Freezer refrigerator. Color: Avatar Black.', 42900.00, NULL, 33462.00, 'hisense, refrigerator, fridge', 0, 'vendor', NULL, NULL, 'draft', 0, 0, 0, 0, '2026-11-02 12:07:12', '2026-11-02 12:07:12', NULL),
(96, NULL, 54, 63, 11, 'Hisense 238L Refrigerator RTDG238NAMB - Magnetic Blue', 'hisense-rtdg238namb-bd3', 'RTDG238NAMB/BD3', '<p>238 Litre Top Mount Freezer refrigerator. Color: Magnetic Blue. Model: RTDG238NAMB/BD3.</p>', '238 Litre Top Mount Freezer refrigerator. Color: Magnetic Blue.', 42900.00, NULL, 33462.00, 'hisense, refrigerator, fridge', 0, 'vendor', NULL, NULL, 'draft', 0, 0, 0, 0, '2026-11-02 12:07:12', '2026-11-02 12:07:12', NULL),
(97, NULL, 54, 63, 11, 'Hisense 277L Refrigerator RTDG277NAB2 - Premium Black', 'hisense-rtdg277nab2-bd3', 'RTDG277NAB2/BD3', '<p>277 Litre Top Mount Freezer refrigerator. Color: Premium Black. Model: RTDG277NAB2/BD3.</p>', '277 Litre Top Mount Freezer refrigerator. Color: Premium Black.', 46900.00, NULL, 36582.00, 'hisense, refrigerator, fridge', 0, 'vendor', NULL, NULL, 'draft', 0, 0, 0, 0, '2026-11-02 12:07:12', '2026-11-02 12:07:12', NULL),
(98, NULL, 54, 63, 11, 'Hisense 277L Refrigerator RTDG277NARG - Rose Gold', 'hisense-rtdg277narg-bd3', 'RTDG277NARG/BD3', '<p>277 Litre Top Mount Freezer refrigerator. Color: Rose Gold. Model: RTDG277NARG/BD3.</p>', '277 Litre Top Mount Freezer refrigerator. Color: Rose Gold.', 46900.00, NULL, 36582.00, 'hisense, refrigerator, fridge', 0, 'vendor', NULL, NULL, 'draft', 0, 0, 0, 0, '2026-11-02 12:07:12', '2026-11-02 12:07:12', NULL),
(99, NULL, 54, 63, 11, 'Hisense 277L Refrigerator RTDG277NAGS - Golden Sunlight', 'hisense-rtdg277nags-bd3', 'RTDG277NAGS/BD3', '<p>277 Litre Top Mount Freezer refrigerator. Color: Golden Sunlight. Model: RTDG277NAGS/BD3.</p>', '277 Litre Top Mount Freezer refrigerator. Color: Golden Sunlight.', 46900.00, NULL, 36582.00, 'hisense, refrigerator, fridge', 0, 'vendor', NULL, NULL, 'draft', 0, 0, 0, 0, '2026-11-02 12:07:12', '2026-11-02 12:07:12', NULL),
(100, NULL, 54, 63, 11, 'Hisense 277L Refrigerator RTDG277NAFB - Fusion Blue', 'hisense-rtdg277nafb-bd3', 'RTDG277NAFB/BD3', '<p>277 Litre Top Mount Freezer refrigerator. Color: Fusion Blue. Model: RTDG277NAFB/BD3.</p>', '277 Litre Top Mount Freezer refrigerator. Color: Fusion Blue.', 46900.00, NULL, 36582.00, 'hisense, refrigerator, fridge', 0, 'vendor', NULL, NULL, 'draft', 0, 0, 0, 0, '2026-11-02 12:07:12', '2026-11-02 12:07:12', NULL),
(101, NULL, 54, 64, 11, 'Hisense 270L Refrigerator RBDG270NARG - Rose Gold', 'hisense-rbdg270narg-bd3', 'RBDG270NARG/BD3', '<p>270 Litre Bottom Mount Freezer refrigerator. Color: Rose Gold. Model: RBDG270NARG/BD3.</p>', '270 Litre Bottom Mount Freezer refrigerator. Color: Rose Gold.', 47900.00, NULL, 37362.00, 'hisense, refrigerator, fridge', 0, 'vendor', NULL, NULL, 'draft', 0, 0, 0, 0, '2026-11-02 12:07:12', '2026-11-02 12:07:12', NULL),
(102, NULL, 54, 64, 11, 'Hisense 270L Refrigerator RBDG270NAFB - Fusion Blue', 'hisense-rbdg270nafb-bd3', 'RBDG270NAFB/BD3', '<p>270 Litre Bottom Mount Freezer refrigerator. Color: Fusion Blue. Model: RBDG270NAFB/BD3.</p>', '270 Litre Bottom Mount Freezer refrigerator. Color: Fusion Blue.', 47900.00, NULL, 37362.00, 'hisense, refrigerator, fridge', 0, 'vendor', NULL, NULL, 'draft', 0, 0, 0, 0, '2026-11-02 12:07:12', '2026-11-02 12:07:12', NULL),
(103, NULL, 54, 64, 11, 'Hisense 270L Refrigerator RBDG270NAAR - Avatar Red', 'hisense-rbdg270naar-bd3', 'RBDG270NAAR/BD3', '<p>270 Litre Bottom Mount Freezer refrigerator. Color: Avatar Red. Model: RBDG270NAAR/BD3.</p>', '270 Litre Bottom Mount Freezer refrigerator. Color: Avatar Red.', 47900.00, NULL, 37362.00, 'hisense, refrigerator, fridge', 0, 'vendor', NULL, NULL, 'draft', 0, 0, 0, 0, '2026-11-02 12:07:12', '2026-11-02 12:07:12', NULL),
(104, NULL, 54, 63, 11, 'Hisense 238L Inverter Refrigerator RT1G238NAB - Premium Black', 'hisense-rt1g238nab-bd3', 'RT1G238NAB/BD3', '<p>238 Litre Top Mount Freezer refrigerator with inverter compressor. Color: Premium Black. Model: RT1G238NAB/BD3.</p>', '238 Litre Top Mount Freezer refrigerator with inverter compressor. Color: Premium Black.', 44900.00, NULL, 35022.00, 'hisense, refrigerator, fridge', 0, 'vendor', NULL, NULL, 'draft', 0, 0, 0, 0, '2026-11-02 12:07:12', '2026-11-02 12:07:12', NULL),
(105, NULL, 54, 63, 11, 'Hisense 238L Inverter Refrigerator RT1G238NAMB - Mirror Black', 'hisense-rt1g238namb-bd3', 'RT1G238NAMB/BD3', '<p>238 Litre Top Mount Freezer refrigerator with inverter compressor. Color: Mirror Black. Model: RT1G238NAMB/BD3.</p>', '238 Litre Top Mount Freezer refrigerator with inverter compressor. Color: Mirror Black.', 46900.00, NULL, 36582.00, 'hisense, refrigerator, fridge', 0, 'vendor', NULL, NULL, 'draft', 0, 0, 0, 0, '2026-11-02 12:07:12', '2026-11-02 12:07:12', NULL),
(106, NULL, 54, 63, 11, 'Hisense 238L Inverter Refrigerator RT1G238NACR - Cherry Red', 'hisense-rt1g238nacr-bd3', 'RT1G238NACR/BD3', '<p>238 Litre Top Mount Freezer refrigerator with inverter compressor. Color: Cherry Red. Model: RT1G238NACR/BD3.</p>', '238 Litre Top Mount Freezer refrigerator with inverter compressor. Color: Cherry Red.', 44900.00, NULL, 35022.00, 'hisense, refrigerator, fridge', 0, 'vendor', NULL, NULL, 'draft', 0, 0, 0, 0, '2026-11-02 12:07:12', '2026-11-02 12:07:12', NULL),
(107, NULL, 54, 63, 11, 'Hisense 238L Inverter Refrigerator RT1G238NARB - Royal Blue', 'hisense-rt1g238narb-bd3', 'RT1G238NARB/BD3', '<p>238 Litre Top Mount Freezer refrigerator with inverter compressor. Color: Royal Blue. Model: RT1G238NARB/BD3.</p>', '238 Litre Top Mount Freezer refrigerator with inverter compressor. Color: Royal Blue.', 44900.00, NULL, 35022.00, 'hisense, refrigerator, fridge', 0, 'vendor', NULL, NULL, 'draft', 0, 0, 0, 0, '2026-11-02 12:07:12', '2026-11-02 12:07:12', NULL),
(108, NULL, 54, 63, 11, 'Hisense 277L Inverter Refrigerator RT1G277NAB - Premium Black', 'hisense-rt1g277nab-bd3', 'RT1G277NAB/BD3', '<p>277 Litre Top Mount Freezer refrigerator with inverter compressor. Color: Premium Black. Model: RT1G277NAB/BD3.</p>', '277 Litre Top Mount Freezer refrigerator with inverter compressor. Color: Premium Black.', 48900.00, NULL, 38142.00, 'hisense, refrigerator, fridge', 0, 'vendor', NULL, NULL, 'draft', 0, 0, 0, 0, '2026-11-02 12:07:12', '2026-11-02 12:07:12', NULL),
(109, NULL, 54, 63, 11, 'Hisense 277L Inverter Refrigerator RT1G277NAMB - Mirror Black', 'hisense-rt1g277namb-bd3', 'RT1G277NAMB/BD3', '<p>277 Litre Top Mount Freezer refrigerator with inverter compressor. Color: Mirror Black. Model: RT1G277NAMB/BD3.</p>', '277 Litre Top Mount Freezer refrigerator with inverter compressor. Color: Mirror Black.', 50900.00, NULL, 39702.00, 'hisense, refrigerator, fridge', 0, 'vendor', NULL, NULL, 'draft', 0, 0, 0, 0, '2026-11-02 12:07:12', '2026-11-02 12:07:12', NULL),
(110, NULL, 54, 63, 11, 'Hisense 277L Inverter Refrigerator RT1G277NABM - Metro Blue', 'hisense-rt1g277nabm-bd3', 'RT1G277NABM/BD3', '<p>277 Litre Top Mount Freezer refrigerator with inverter compressor. Color: Metro Blue. Model: RT1G277NABM/BD3.</p>', '277 Litre Top Mount Freezer refrigerator with inverter compressor. Color: Metro Blue.', 48900.00, NULL, 38142.00, 'hisense, refrigerator, fridge', 0, 'vendor', NULL, NULL, 'draft', 0, 0, 0, 0, '2026-11-02 12:07:12', '2026-11-02 12:07:12', NULL),
(111, NULL, 54, 63, 11, 'Hisense 277L Inverter Refrigerator RT1G277NARB - Royal Blue', 'hisense-rt1g277narb-bd3', 'RT1G277NARB/BD3', '<p>277 Litre Top Mount Freezer refrigerator with inverter compressor. Color: Royal Blue. Model: RT1G277NARB/BD3.</p>', '277 Litre Top Mount Freezer refrigerator with inverter compressor. Color: Royal Blue.', 48900.00, NULL, 38142.00, 'hisense, refrigerator, fridge', 0, 'vendor', NULL, NULL, 'draft', 0, 0, 0, 0, '2026-11-02 12:07:12', '2026-11-02 12:07:12', NULL),
(112, NULL, 54, 64, 11, 'Hisense 270L Inverter Refrigerator RB1G270NAB - Premium Black', 'hisense-rb1g270nab-bd3', 'RB1G270NAB/BD3', '<p>270 Litre Bottom Mount Freezer refrigerator with inverter compressor. Color: Premium Black. Model: RB1G270NAB/BD3.</p>', '270 Litre Bottom Mount Freezer refrigerator with inverter compressor. Color: Premium Black.', 49900.00, NULL, 38922.00, 'hisense, refrigerator, fridge', 0, 'vendor', NULL, NULL, 'draft', 0, 0, 0, 0, '2026-11-02 12:07:12', '2026-11-02 12:07:12', NULL),
(113, NULL, 54, 64, 11, 'Hisense 270L Inverter Refrigerator RB1G270NADR - Dark Red', 'hisense-rb1g270nadr-bd3', 'RB1G270NADR/BD3', '<p>270 Litre Bottom Mount Freezer refrigerator with inverter compressor. Color: Dark Red. Model: RB1G270NADR/BD3.</p>', '270 Litre Bottom Mount Freezer refrigerator with inverter compressor. Color: Dark Red.', 49900.00, NULL, 38922.00, 'hisense, refrigerator, fridge', 0, 'vendor', NULL, NULL, 'draft', 0, 0, 0, 0, '2026-11-02 12:07:12', '2026-11-02 12:07:12', NULL),
(114, NULL, 54, 64, 11, 'Hisense 270L Inverter Refrigerator RB1G270NARB - Royal Blue', 'hisense-rb1g270narb-bd3', 'RB1G270NARB/BD3', '<p>270 Litre Bottom Mount Freezer refrigerator with inverter compressor. Color: Royal Blue. Model: RB1G270NARB/BD3.</p>', '270 Litre Bottom Mount Freezer refrigerator with inverter compressor. Color: Royal Blue.', 49900.00, NULL, 38922.00, 'hisense, refrigerator, fridge', 0, 'vendor', NULL, NULL, 'draft', 0, 0, 0, 0, '2026-11-02 12:07:12', '2026-11-02 12:07:12', NULL),
(115, NULL, 54, 64, 11, 'Hisense 270L Inverter Refrigerator RB1G270NMB - Premium Black (With Display)', 'hisense-rb1g270nmb-bd3', 'RB1G270NMB/BD3', '<p>270 Litre Bottom Mount Freezer refrigerator with inverter compressor. Color: Premium Black (With Display). Model: RB1G270NMB/BD3.</p>', '270 Litre Bottom Mount Freezer refrigerator with inverter compressor. Color: Premium Black (With Display).', 51900.00, NULL, 40482.00, 'hisense, refrigerator, fridge', 0, 'vendor', NULL, NULL, 'draft', 0, 0, 0, 0, '2026-11-02 12:07:12', '2026-11-02 12:07:12', NULL),
(116, NULL, 54, 64, 11, 'Hisense 270L Inverter Refrigerator RB1G270NMMB - Mirror Black (With Display)', 'hisense-rb1g270nmmb-bd3', 'RB1G270NMMB/BD3', '<p>270 Litre Bottom Mount Freezer refrigerator with inverter compressor. Color: Mirror Black (With Display). Model: RB1G270NMMB/BD3.</p>', '270 Litre Bottom Mount Freezer refrigerator with inverter compressor. Color: Mirror Black (With Display).', 53900.00, NULL, 42042.00, 'hisense, refrigerator, fridge', 0, 'vendor', NULL, NULL, 'draft', 0, 0, 0, 0, '2026-11-02 12:07:12', '2026-11-02 12:07:12', NULL),
(117, NULL, 54, 64, 11, 'Hisense 270L Inverter Refrigerator RB1G270NMBM - Metro Blue (With Display)', 'hisense-rb1g270nmbm-bd3', 'RB1G270NMBM/BD3', '<p>270 Litre Bottom Mount Freezer refrigerator with inverter compressor. Color: Metro Blue (With Display). Model: RB1G270NMBM/BD3.</p>', '270 Litre Bottom Mount Freezer refrigerator with inverter compressor. Color: Metro Blue (With Display).', 51900.00, NULL, 40482.00, 'hisense, refrigerator, fridge', 0, 'vendor', NULL, NULL, 'draft', 0, 0, 0, 0, '2026-11-02 12:07:12', '2026-11-02 12:07:12', NULL),
(118, NULL, 54, 64, 11, 'Hisense 270L Inverter Refrigerator RB1G270NMRB - Royal Blue (With Display)', 'hisense-rb1g270nmrb-bd3', 'RB1G270NMRB/BD3', '<p>270 Litre Bottom Mount Freezer refrigerator with inverter compressor. Color: Royal Blue (With Display). Model: RB1G270NMRB/BD3.</p>', '270 Litre Bottom Mount Freezer refrigerator with inverter compressor. Color: Royal Blue (With Display).', 51900.00, NULL, 40482.00, 'hisense, refrigerator, fridge', 0, 'vendor', NULL, NULL, 'draft', 0, 0, 0, 0, '2026-11-02 12:07:12', '2026-11-02 12:07:12', NULL),
(119, NULL, 54, 63, 11, 'Hisense 238L Inverter Refrigerator RT1G236NAB - Premium Black', 'hisense-rt1g236nab-bd3', 'RT1G236NAB/BD3', '<p>238 Litre Top Mount Freezer refrigerator with inverter compressor. Color: Premium Black. Model: RT1G236NAB/BD3.</p>', '238 Litre Top Mount Freezer refrigerator with inverter compressor. Color: Premium Black.', 44900.00, NULL, 35022.00, 'hisense, refrigerator, fridge', 0, 'vendor', NULL, NULL, 'draft', 0, 0, 0, 0, '2026-11-02 12:07:12', '2026-11-02 12:07:12', NULL),
(120, NULL, 54, 63, 11, 'Hisense 238L Inverter Refrigerator RT1G236NACR - Cherry Red', 'hisense-rt1g236nacr-bd3', 'RT1G236NACR/BD3', '<p>238 Litre Top Mount Freezer refrigerator with inverter compressor. Color: Cherry Red. Model: RT1G236NACR/BD3.</p>', '238 Litre Top Mount Freezer refrigerator with inverter compressor. Color: Cherry Red.', 44900.00, NULL, 35022.00, 'hisense, refrigerator, fridge', 0, 'vendor', NULL, NULL, 'draft', 0, 0, 0, 0, '2026-11-02 12:07:12', '2026-11-02 12:07:12', NULL),
(121, NULL, 54, 63, 11, 'Hisense 238L Inverter Refrigerator RT1G236NARB - Royal Blue', 'hisense-rt1g236narb-bd3', 'RT1G236NARB/BD3', '<p>238 Litre Top Mount Freezer refrigerator with inverter compressor. Color: Royal Blue. Model: RT1G236NARB/BD3.</p>', '238 Litre Top Mount Freezer refrigerator with inverter compressor. Color: Royal Blue.', 44900.00, NULL, 35022.00, 'hisense, refrigerator, fridge', 0, 'vendor', NULL, NULL, 'draft', 0, 0, 0, 0, '2026-11-02 12:07:12', '2026-11-02 12:07:12', NULL),
(122, NULL, 54, 63, 11, 'Hisense 238L Inverter Refrigerator RT1G236NAMB - Mirror Black', 'hisense-rt1g236namb-bd3', 'RT1G236NAMB/BD3', '<p>238 Litre Top Mount Freezer refrigerator with inverter compressor. Color: Mirror Black. Model: RT1G236NAMB/BD3.</p>', '238 Litre Top Mount Freezer refrigerator with inverter compressor. Color: Mirror Black.', 46900.00, NULL, 36582.00, 'hisense, refrigerator, fridge', 0, 'vendor', NULL, NULL, 'draft', 0, 0, 0, 0, '2026-11-02 12:07:12', '2026-11-02 12:07:12', NULL),
(123, NULL, 54, 63, 11, 'Hisense 238L Refrigerator RTDG236NASR - Starry Red', 'hisense-rtdg236nasr-bd3', 'RTDG236NASR/BD3', '<p>238 Litre Top Mount Freezer refrigerator. Color: Starry Red. Model: RTDG236NASR/BD3.</p>', '238 Litre Top Mount Freezer refrigerator. Color: Starry Red.', 42900.00, NULL, 33462.00, 'hisense, refrigerator, fridge', 0, 'vendor', NULL, NULL, 'draft', 0, 0, 0, 0, '2026-11-02 12:07:12', '2026-11-02 12:07:12', NULL),
(124, NULL, 54, 63, 11, 'Hisense 238L Refrigerator RTDG236NADP - Dreamy Purple', 'hisense-rtdg236nadp-bd3', 'RTDG236NADP/BD3', '<p>238 Litre Top Mount Freezer refrigerator. Color: Dreamy Purple. Model: RTDG236NADP/BD3.</p>', '238 Litre Top Mount Freezer refrigerator. Color: Dreamy Purple.', 42900.00, NULL, 33462.00, 'hisense, refrigerator, fridge', 0, 'vendor', NULL, NULL, 'draft', 0, 0, 0, 0, '2026-11-02 12:07:12', '2026-11-02 12:07:12', NULL),
(125, NULL, 54, 63, 11, 'Hisense 238L Refrigerator RTDG236NAAB - Avatar Black', 'hisense-rtdg236naab-bd3', 'RTDG236NAAB/BD3', '<p>238 Litre Top Mount Freezer refrigerator. Color: Avatar Black. Model: RTDG236NAAB/BD3.</p>', '238 Litre Top Mount Freezer refrigerator. Color: Avatar Black.', 42900.00, NULL, 33462.00, 'hisense, refrigerator, fridge', 0, 'vendor', NULL, NULL, 'draft', 0, 0, 0, 0, '2026-11-02 12:07:12', '2026-11-02 12:07:12', NULL),
(126, NULL, 54, 63, 11, 'Hisense 238L Refrigerator RTDG236NAMB - Magnetic Blue', 'hisense-rtdg236namb-bd3', 'RTDG236NAMB/BD3', '<p>238 Litre Top Mount Freezer refrigerator. Color: Magnetic Blue. Model: RTDG236NAMB/BD3.</p>', '238 Litre Top Mount Freezer refrigerator. Color: Magnetic Blue.', 42900.00, NULL, 33462.00, 'hisense, refrigerator, fridge', 0, 'vendor', NULL, NULL, 'draft', 0, 0, 0, 0, '2026-11-02 12:07:12', '2026-11-02 12:07:12', NULL),
(127, NULL, 54, 63, 11, 'Hisense 277L Inverter Refrigerator RT1G276NAB - Premium Black', 'hisense-rt1g276nab-bd3', 'RT1G276NAB/BD3', '<p>277 Litre Top Mount Freezer refrigerator with inverter compressor. Color: Premium Black. Model: RT1G276NAB/BD3.</p>', '277 Litre Top Mount Freezer refrigerator with inverter compressor. Color: Premium Black.', 48900.00, NULL, 38142.00, 'hisense, refrigerator, fridge', 0, 'vendor', NULL, NULL, 'draft', 0, 0, 0, 0, '2026-11-02 12:07:12', '2026-11-02 12:07:12', NULL),
(128, NULL, 54, 63, 11, 'Hisense 277L Inverter Refrigerator RT1G276NABM - Metro Blue', 'hisense-rt1g276nabm-bd3', 'RT1G276NABM/BD3', '<p>277 Litre Top Mount Freezer refrigerator with inverter compressor. Color: Metro Blue. Model: RT1G276NABM/BD3.</p>', '277 Litre Top Mount Freezer refrigerator with inverter compressor. Color: Metro Blue.', 48900.00, NULL, 38142.00, 'hisense, refrigerator, fridge', 0, 'vendor', NULL, NULL, 'draft', 0, 0, 0, 0, '2026-11-02 12:07:12', '2026-11-02 12:07:12', NULL),
(129, NULL, 54, 63, 11, 'Hisense 277L Inverter Refrigerator RT1G276NARB - Royal Blue', 'hisense-rt1g276narb-bd3', 'RT1G276NARB/BD3', '<p>277 Litre Top Mount Freezer refrigerator with inverter compressor. Color: Royal Blue. Model: RT1G276NARB/BD3.</p>', '277 Litre Top Mount Freezer refrigerator with inverter compressor. Color: Royal Blue.', 48900.00, NULL, 38142.00, 'hisense, refrigerator, fridge', 0, 'vendor', NULL, NULL, 'draft', 0, 0, 0, 0, '2026-11-02 12:07:12', '2026-11-02 12:07:12', NULL),
(130, NULL, 54, 63, 11, 'Hisense 277L Inverter Refrigerator RT1G276NAMB - Mirror Black', 'hisense-rt1g276namb-bd3', 'RT1G276NAMB/BD3', '<p>277 Litre Top Mount Freezer refrigerator with inverter compressor. Color: Mirror Black. Model: RT1G276NAMB/BD3.</p>', '277 Litre Top Mount Freezer refrigerator with inverter compressor. Color: Mirror Black.', 50900.00, NULL, 39702.00, 'hisense, refrigerator, fridge', 0, 'vendor', NULL, NULL, 'draft', 0, 0, 0, 0, '2026-11-02 12:07:12', '2026-11-02 12:07:12', NULL),
(131, NULL, 54, 63, 11, 'Hisense 277L Refrigerator RTDG276NAB2 - Premium Black', 'hisense-rtdg276nab2-bd3', 'RTDG276NAB2/BD3', '<p>277 Litre Top Mount Freezer refrigerator. Color: Premium Black. Model: RTDG276NAB2/BD3.</p>', '277 Litre Top Mount Freezer refrigerator. Color: Premium Black.', 46900.00, NULL, 36582.00, 'hisense, refrigerator, fridge', 0, 'vendor', NULL, NULL, 'draft', 0, 0, 0, 0, '2026-11-02 12:07:12', '2026-11-02 12:07:12', NULL),
(132, NULL, 54, 63, 11, 'Hisense 277L Refrigerator RTDG276NARG - Rose Gold', 'hisense-rtdg276narg-bd3', 'RTDG276NARG/BD3', '<p>277 Litre Top Mount Freezer refrigerator. Color: Rose Gold. Model: RTDG276NARG/BD3.</p>', '277 Litre Top Mount Freezer refrigerator. Color: Rose Gold.', 46900.00, NULL, 36582.00, 'hisense, refrigerator, fridge', 0, 'vendor', NULL, NULL, 'draft', 0, 0, 0, 0, '2026-11-02 12:07:12', '2026-11-02 12:07:12', NULL),
(133, NULL, 54, 63, 11, 'Hisense 277L Refrigerator RTDG276NAGS - Golden Sunlight', 'hisense-rtdg276nags-bd3', 'RTDG276NAGS/BD3', '<p>277 Litre Top Mount Freezer refrigerator. Color: Golden Sunlight. Model: RTDG276NAGS/BD3.</p>', '277 Litre Top Mount Freezer refrigerator. Color: Golden Sunlight.', 46900.00, NULL, 36582.00, 'hisense, refrigerator, fridge', 0, 'vendor', NULL, NULL, 'draft', 0, 0, 0, 0, '2026-11-02 12:07:12', '2026-11-02 12:07:12', NULL),
(134, NULL, 54, 63, 11, 'Hisense 277L Refrigerator RTDG276NAFB - Fusion Blue', 'hisense-rtdg276nafb-bd3', 'RTDG276NAFB/BD3', '<p>277 Litre Top Mount Freezer refrigerator. Color: Fusion Blue. Model: RTDG276NAFB/BD3.</p>', '277 Litre Top Mount Freezer refrigerator. Color: Fusion Blue.', 46900.00, NULL, 36582.00, 'hisense, refrigerator, fridge', 0, 'vendor', NULL, NULL, 'draft', 0, 0, 0, 0, '2026-11-02 12:07:12', '2026-11-02 12:07:12', NULL),
(135, NULL, 54, 64, 11, 'Hisense 270L Inverter Refrigerator RB1G266NAB - Premium Black', 'hisense-rb1g266nab-bd3', 'RB1G266NAB/BD3', '<p>270 Litre Bottom Mount Freezer refrigerator with inverter compressor. Color: Premium Black. Model: RB1G266NAB/BD3.</p>', '270 Litre Bottom Mount Freezer refrigerator with inverter compressor. Color: Premium Black.', 49900.00, NULL, 38922.00, 'hisense, refrigerator, fridge', 0, 'vendor', NULL, NULL, 'draft', 0, 0, 0, 0, '2026-11-02 12:07:12', '2026-11-02 12:07:12', NULL),
(136, NULL, 54, 64, 11, 'Hisense 270L Inverter Refrigerator RB1G266NADR - Dark Red', 'hisense-rb1g266nadr-bd3', 'RB1G266NADR/BD3', '<p>270 Litre Bottom Mount Freezer refrigerator with inverter compressor. Color: Dark Red. Model: RB1G266NADR/BD3.</p>', '270 Litre Bottom Mount Freezer refrigerator with inverter compressor. Color: Dark Red.', 49900.00, NULL, 38922.00, 'hisense, refrigerator, fridge', 0, 'vendor', NULL, NULL, 'draft', 0, 0, 0, 0, '2026-11-02 12:07:12', '2026-11-02 12:07:12', NULL),
(137, NULL, 54, 64, 11, 'Hisense 270L Inverter Refrigerator RB1G266NARB - Royal Blue', 'hisense-rb1g266narb-bd3', 'RB1G266NARB/BD3', '<p>270 Litre Bottom Mount Freezer refrigerator with inverter compressor. Color: Royal Blue. Model: RB1G266NARB/BD3.</p>', '270 Litre Bottom Mount Freezer refrigerator with inverter compressor. Color: Royal Blue.', 49900.00, NULL, 38922.00, 'hisense, refrigerator, fridge', 0, 'vendor', NULL, NULL, 'draft', 0, 0, 0, 0, '2026-11-02 12:07:12', '2026-11-02 12:07:12', NULL),
(138, NULL, 54, 64, 11, 'Hisense 270L Refrigerator RBDG266NARG - Rose Gold', 'hisense-rbdg266narg-bd3', 'RBDG266NARG/BD3', '<p>270 Litre Bottom Mount Freezer refrigerator. Color: Rose Gold. Model: RBDG266NARG/BD3.</p>', '270 Litre Bottom Mount Freezer refrigerator. Color: Rose Gold.', 47900.00, NULL, 37362.00, 'hisense, refrigerator, fridge', 0, 'vendor', NULL, NULL, 'draft', 0, 0, 0, 0, '2026-11-02 12:07:12', '2026-11-02 12:07:12', NULL),
(139, NULL, 54, 64, 11, 'Hisense 270L Refrigerator RBDG266NAFB - Fusion Blue', 'hisense-rbdg266nafb-bd3', 'RBDG266NAFB/BD3', '<p>270 Litre Bottom Mount Freezer refrigerator. Color: Fusion Blue. Model: RBDG266NAFB/BD3.</p>', '270 Litre Bottom Mount Freezer refrigerator. Color: Fusion Blue.', 47900.00, NULL, 37362.00, 'hisense, refrigerator, fridge', 0, 'vendor', NULL, NULL, 'draft', 0, 0, 0, 0, '2026-11-02 12:07:12', '2026-11-02 12:07:12', NULL),
(140, NULL, 54, 64, 11, 'Hisense 270L Refrigerator RBDG266NAAR - Avatar Red', 'hisense-rbdg266naar-bd3', 'RBDG266NAAR/BD3', '<p>270 Litre Bottom Mount Freezer refrigerator. Color: Avatar Red. Model: RBDG266NAAR/BD3.</p>', '270 Litre Bottom Mount Freezer refrigerator. Color: Avatar Red.', 47900.00, NULL, 37362.00, 'hisense, refrigerator, fridge', 0, 'vendor', NULL, NULL, 'draft', 0, 0, 0, 0, '2026-11-02 12:07:12', '2026-11-02 12:07:12', NULL),
(141, NULL, 54, 64, 11, 'Hisense 270L Inverter Refrigerator RB1G266NMB - Premium Black (With Display)', 'hisense-rb1g266nmb-bd3', 'RB1G266NMB/BD3', '<p>270 Litre Bottom Mount Freezer refrigerator with inverter compressor. Color: Premium Black (With Display). Model: RB1G266NMB/BD3.</p>', '270 Litre Bottom Mount Freezer refrigerator with inverter compressor. Color: Premium Black (With Display).', 51900.00, NULL, 40482.00, 'hisense, refrigerator, fridge', 0, 'vendor', NULL, NULL, 'draft', 0, 0, 0, 0, '2026-11-02 12:07:12', '2026-11-02 12:07:12', NULL),
(142, NULL, 54, 64, 11, 'Hisense 270L Inverter Refrigerator RB1G266NMBB - Metro Blue (With Display)', 'hisense-rb1g266nmbb-bd3', 'RB1G266NMBB/BD3', '<p>270 Litre Bottom Mount Freezer refrigerator with inverter compressor. Color: Metro Blue (With Display). Model: RB1G266NMBB/BD3.</p>', '270 Litre Bottom Mount Freezer refrigerator with inverter compressor. Color: Metro Blue (With Display).', 51900.00, NULL, 40482.00, 'hisense, refrigerator, fridge', 0, 'vendor', NULL, NULL, 'draft', 0, 0, 0, 0, '2026-11-02 12:07:12', '2026-11-02 12:07:12', NULL),
(143, NULL, 54, 64, 11, 'Hisense 270L Inverter Refrigerator RB1G266NMRB - Royal Blue (With Display)', 'hisense-rb1g266nmrb-bd3', 'RB1G266NMRB/BD3', '<p>270 Litre Bottom Mount Freezer refrigerator with inverter compressor. Color: Royal Blue (With Display). Model: RB1G266NMRB/BD3.</p>', '270 Litre Bottom Mount Freezer refrigerator with inverter compressor. Color: Royal Blue (With Display).', 51900.00, NULL, 40482.00, 'hisense, refrigerator, fridge', 0, 'vendor', NULL, NULL, 'draft', 0, 0, 0, 0, '2026-11-02 12:07:12', '2026-11-02 12:07:12', NULL),
(144, NULL, 54, 64, 11, 'Hisense 270L Inverter Refrigerator RB1G266NMMB - Mirror Black (With Display)', 'hisense-rb1g266nmmb-bd3', 'RB1G266NMMB/BD3', '<p>270 Litre Bottom Mount Freezer refrigerator with inverter compressor. Color: Mirror Black (With Display). Model: RB1G266NMMB/BD3.</p>', '270 Litre Bottom Mount Freezer refrigerator with inverter compressor. Color: Mirror Black (With Display).', 53900.00, NULL, 42042.00, 'hisense, refrigerator, fridge', 0, 'vendor', NULL, NULL, 'draft', 0, 0, 0, 0, '2026-11-02 12:07:12', '2026-11-02 12:07:12', NULL),
(155, NULL, 54, 63, 1, 'Samsung 275L MC TMF Refrigerator RT29HAR9DUT/D3 - Pebble Blue', 'samsung-rt29har9dut-d3', 'RT29HAR9DUT/D3', '<p>Samsung 275 Litre MC TMF refrigerator. Color: Pebble Blue. Model: RT29HAR9DUT/D3.</p><h5>Warranty</h5><ul><li>Compressor: 10 Years</li><li>Parts: 1 Year</li><li>Service: 1 Year</li></ul><p><small>Warranty policy applies to products lifted from 28 August 2026.</small></p>', '275 Litre MC TMF refrigerator. Color: Pebble Blue.', 70500.00, NULL, 54383.00, 'samsung, refrigerator, fridge', 0, 'vendor', NULL, NULL, 'draft', 0, 0, 0, 0, '2026-11-02 12:07:25', '2026-11-02 12:07:25', NULL),
(156, NULL, 54, 63, 1, 'Samsung 275L MC TMF Refrigerator RT29HAR9DBS/D3 - Black Caviar', 'samsung-rt29har9dbs-d3', 'RT29HAR9DBS/D3', '<p>Samsung 275 Litre MC TMF refrigerator. Color: Black Caviar. Model: RT29HAR9DBS/D3.</p><h5>Warranty</h5><ul><li>Compressor: 10 Years</li><li>Parts: 1 Year</li><li>Service: 1 Year</li></ul><p><small>Warranty policy applies to products lifted from 28 August 2026.</small></p>', '275 Litre MC TMF refrigerator. Color: Black Caviar.', 70900.00, NULL, 54792.00, 'samsung, refrigerator, fridge', 0, 'vendor', NULL, NULL, 'draft', 0, 0, 0, 0, '2026-11-02 12:07:25', '2026-11-02 12:07:25', NULL),
(157, NULL, 54, 63, 1, 'Samsung 324L 5 IN 1 TC TMF Refrigerator RT34K5532UT/D3 - Pebble Blue', 'samsung-rt34k5532ut-d3', 'RT34K5532UT/D3', '<p>Samsung 324 Litre 5 IN 1 TC TMF refrigerator. Color: Pebble Blue. Model: RT34K5532UT/D3.</p><h5>Warranty</h5><ul><li>Compressor: 10 Years</li><li>Parts: 1 Year</li><li>Service: 1 Year</li></ul><p><small>Warranty policy applies to products lifted from 28 August 2026.</small></p>', '324 Litre 5 IN 1 TC TMF refrigerator. Color: Pebble Blue.', 85900.00, NULL, 66477.00, 'samsung, refrigerator, fridge', 0, 'vendor', NULL, NULL, 'draft', 0, 0, 0, 0, '2026-11-02 12:07:25', '2026-11-02 12:07:25', NULL),
(158, NULL, 54, 63, 1, 'Samsung 324L 5 IN 1 TC TMF Refrigerator RT34K5532BS/D3 - Black Caviar', 'samsung-rt34k5532bs-d3', 'RT34K5532BS/D3', '<p>Samsung 324 Litre 5 IN 1 TC TMF refrigerator. Color: Black Caviar. Model: RT34K5532BS/D3.</p><h5>Warranty</h5><ul><li>Compressor: 10 Years</li><li>Parts: 1 Year</li><li>Service: 1 Year</li></ul><p><small>Warranty policy applies to products lifted from 28 August 2026.</small></p>', '324 Litre 5 IN 1 TC TMF refrigerator. Color: Black Caviar.', 86900.00, NULL, 66958.00, 'samsung, refrigerator, fridge', 0, 'vendor', NULL, NULL, 'draft', 0, 0, 0, 0, '2026-11-02 12:07:25', '2026-11-02 12:07:25', NULL),
(159, NULL, 54, 63, 1, 'Samsung 345L 5 IN 1 TC TMF Refrigerator RT37K5532UT/D3 - Pebble Blue', 'samsung-rt37k5532ut-d3', 'RT37K5532UT/D3', '<p>Samsung 345 Litre 5 IN 1 TC TMF refrigerator. Color: Pebble Blue. Model: RT37K5532UT/D3.</p><h5>Warranty</h5><ul><li>Compressor: 10 Years</li><li>Parts: 1 Year</li><li>Service: 1 Year</li></ul><p><small>Warranty policy applies to products lifted from 28 August 2026.</small></p>', '345 Litre 5 IN 1 TC TMF refrigerator. Color: Pebble Blue.', 89900.00, NULL, 69601.00, 'samsung, refrigerator, fridge', 0, 'vendor', NULL, NULL, 'draft', 0, 0, 0, 0, '2026-11-02 12:07:25', '2026-11-02 12:07:25', NULL),
(160, NULL, 54, 63, 1, 'Samsung 345L 5 IN 1 TC TMF Refrigerator RT37K5532BS/D3 - Black Caviar', 'samsung-rt37k5532bs-d3', 'RT37K5532BS/D3', '<p>Samsung 345 Litre 5 IN 1 TC TMF refrigerator. Color: Black Caviar. Model: RT37K5532BS/D3.</p><h5>Warranty</h5><ul><li>Compressor: 10 Years</li><li>Parts: 1 Year</li><li>Service: 1 Year</li></ul><p><small>Warranty policy applies to products lifted from 28 August 2026.</small></p>', '345 Litre 5 IN 1 TC TMF refrigerator. Color: Black Caviar.', 90900.00, NULL, 70056.00, 'samsung, refrigerator, fridge', 0, 'vendor', NULL, NULL, 'draft', 0, 0, 0, 0, '2026-11-02 12:07:25', '2026-11-02 12:07:25', NULL),
(161, NULL, 54, 63, 1, 'Samsung 465L 5 IN 1 TC TMF Refrigerator RT47K6231UT/D3 - Pebble Blue', 'samsung-rt47k6231ut-d3', 'RT47K6231UT/D3', '<p>Samsung 465 Litre 5 IN 1 TC TMF refrigerator. Color: Pebble Blue. Model: RT47K6231UT/D3.</p><h5>Warranty</h5><ul><li>Compressor: 10 Years</li><li>Parts: 1 Year</li><li>Service: 1 Year</li></ul><p><small>Warranty policy applies to products lifted from 28 August 2026.</small></p>', '465 Litre 5 IN 1 TC TMF refrigerator. Color: Pebble Blue.', 112900.00, NULL, 88675.00, 'samsung, refrigerator, fridge', 0, 'vendor', NULL, NULL, 'draft', 0, 0, 0, 0, '2026-11-02 12:07:25', '2026-11-02 12:07:25', NULL),
(162, NULL, 54, 63, 1, 'Samsung 465L 5 IN 1 TC TMF Refrigerator RT47K6231BS/D3 - Black Caviar', 'samsung-rt47k6231bs-d3', 'RT47K6231BS/D3', '<p>Samsung 465 Litre 5 IN 1 TC TMF refrigerator. Color: Black Caviar. Model: RT47K6231BS/D3.</p><h5>Warranty</h5><ul><li>Compressor: 10 Years</li><li>Parts: 1 Year</li><li>Service: 1 Year</li></ul><p><small>Warranty policy applies to products lifted from 28 August 2026.</small></p>', '465 Litre 5 IN 1 TC TMF refrigerator. Color: Black Caviar.', 113900.00, NULL, 89093.00, 'samsung, refrigerator, fridge', 0, 'vendor', NULL, NULL, 'draft', 0, 0, 0, 0, '2026-11-02 12:07:25', '2026-11-02 12:07:25', NULL),
(163, NULL, 54, 65, 1, 'Samsung 647L MC SBS Refrigerator RS74R5101SL/D3 - Silver (CKD)', 'samsung-rs74r5101sl-d3', 'RS74R5101SL/D3', '<p>Samsung 647 Litre MC SBS refrigerator. Color: Silver (CKD). Model: RS74R5101SL/D3.</p><h5>Warranty</h5><ul><li>Compressor: 10 Years</li><li>Parts: 1 Year</li><li>Service: 1 Year</li></ul><p><small>Warranty policy applies to products lifted from 28 August 2026.</small></p>', '647 Litre MC SBS refrigerator. Color: Silver (CKD).', 229900.00, NULL, 177322.00, 'samsung, refrigerator, fridge', 0, 'vendor', NULL, NULL, 'draft', 0, 0, 0, 0, '2026-11-02 12:07:25', '2026-11-02 12:07:25', NULL),
(170, NULL, 53, 68, 12, 'Haier H32S80GFX 32 Inch QLED FHD Google TV', 'haier-dh20h5z01', 'DH20H5Z01', '<p>Haier H32S80GFX - 32 Inch QLED FHD Google TV.</p><ul><li>Size: 32 Inch</li><li>Model: H32S80GFX</li><li>Material Code: DH20H5Z01</li></ul>', '32 Inch QLED FHD Google TV.', 35900.00, 33900.00, 28063.00, 'haier, television, tv, smart tv', 0, 'vendor', NULL, NULL, 'draft', 0, 0, 0, 0, '2026-11-02 12:07:35', '2026-11-02 12:07:35', NULL),
(171, NULL, 53, 68, 12, 'Haier H43S80GFX 43 Inch QLED FHD Google TV', 'haier-dh20gcz01', 'DH20GCZ01', '<p>Haier H43S80GFX - 43 Inch QLED FHD Google TV, 1G+8G.</p><ul><li>Size: 43 Inch</li><li>Model: H43S80GFX</li><li>Material Code: DH20GCZ01</li></ul>', '43 Inch QLED FHD Google TV, 1G+8G.', 46900.00, 43900.00, 35252.00, 'haier, television, tv, smart tv', 0, 'vendor', NULL, NULL, 'draft', 0, 0, 0, 0, '2026-11-02 12:07:35', '2026-11-02 12:07:35', NULL),
(172, NULL, 53, 68, 12, 'Haier H43S80GUX 43 Inch QLED 4K Google TV', 'haier-dh20qez00', 'DH20QEZ00', '<p>Haier H43S80GUX - 43 Inch QLED 4K Google TV, 2G+32G.</p><ul><li>Size: 43 Inch</li><li>Model: H43S80GUX</li><li>Material Code: DH20QEZ00</li></ul>', '43 Inch QLED 4K Google TV, 2G+32G.', 57900.00, 54900.00, 42359.00, 'haier, television, tv, smart tv', 0, 'vendor', NULL, NULL, 'draft', 0, 0, 0, 0, '2026-11-02 12:07:35', '2026-11-02 12:07:35', NULL),
(173, NULL, 53, 69, 12, 'Haier 43P7 PRO 43 Inch HQLED Google TV', 'haier-dh20p7z00', 'DH20P7Z00', '<p>Haier 43P7 PRO - 43 Inch HQLED, Google TV, 2G+32G, Hands Free Voice Control.</p><ul><li>Size: 43 Inch</li><li>Model: 43P7 PRO</li><li>Material Code: DH20P7Z00</li></ul>', '43 Inch HQLED, Google TV, 2G+32G, Hands Free Voice Control.', 62900.00, 59900.00, 46017.00, 'haier, television, tv, smart tv', 0, 'vendor', NULL, NULL, 'draft', 0, 0, 0, 0, '2026-11-02 12:07:35', '2026-11-02 12:07:35', NULL),
(174, NULL, 53, 69, 12, 'Haier H43S85GUX 43 Inch HQLED Google TV', 'haier-dh20p8z00', 'DH20P8Z00', '<p>Haier H43S85GUX - 43 Inch HQLED, 120Hz, Hands Free, 2G+32G.</p><ul><li>Size: 43 Inch</li><li>Model: H43S85GUX</li><li>Material Code: DH20P8Z00</li></ul>', '43 Inch HQLED, 120Hz, Hands Free, 2G+32G.', 66900.00, 60900.00, 46749.00, 'haier, television, tv, smart tv', 0, 'vendor', NULL, NULL, 'draft', 0, 0, 0, 0, '2026-11-02 12:07:35', '2026-11-02 12:07:35', NULL),
(175, NULL, 53, 69, 12, 'Haier 50P7 PRO 50 Inch HQLED Google TV', 'haier-dh20n8z00', 'DH20N8Z00', '<p>Haier 50P7 PRO - 50 Inch HQLED, Google TV, 2G+32G, Hands Free Voice Control.</p><ul><li>Size: 50 Inch</li><li>Model: 50P7 PRO</li><li>Material Code: DH20N8Z00</li></ul>', '50 Inch HQLED, Google TV, 2G+32G, Hands Free Voice Control.', 76900.00, 72900.00, 56260.00, 'haier, television, tv, smart tv', 0, 'vendor', NULL, NULL, 'draft', 0, 0, 0, 0, '2026-11-02 12:07:35', '2026-11-02 12:07:35', NULL),
(176, NULL, 53, 69, 12, 'Haier 55P7 PRO 55 Inch HQLED Google TV', 'haier-dh20mgz00', 'DH20MGZ00', '<p>Haier 55P7 PRO - 55 Inch HQLED, Google TV, 2G+32G, Hands Free Voice Control.</p><ul><li>Size: 55 Inch</li><li>Model: 55P7 PRO</li><li>Material Code: DH20MGZ00</li></ul>', '55 Inch HQLED, Google TV, 2G+32G, Hands Free Voice Control.', 91900.00, 86900.00, 67233.00, 'haier, television, tv, smart tv', 0, 'vendor', NULL, NULL, 'draft', 0, 0, 0, 0, '2026-11-02 12:07:35', '2026-11-02 12:07:35', NULL),
(177, NULL, 53, 69, 12, 'Haier H55S85GUX 55 Inch HQLED Google TV', 'haier-dh20mhz00', 'DH20MHZ00', '<p>Haier H55S85GUX - 55 Inch HQLED, 120Hz, Hands Free, 2G+32G.</p><ul><li>Size: 55 Inch</li><li>Model: H55S85GUX</li><li>Material Code: DH20MHZ00</li></ul>', '55 Inch HQLED, 120Hz, Hands Free, 2G+32G.', 92900.00, 87900.00, 67965.00, 'haier, television, tv, smart tv', 0, 'vendor', NULL, NULL, 'draft', 0, 0, 0, 0, '2026-11-02 12:07:35', '2026-11-02 12:07:35', NULL),
(178, NULL, 53, 69, 12, 'Haier 65P7 PRO 65 Inch HQLED Google TV', 'haier-dh20ljz00', 'DH20LJZ00', '<p>Haier 65P7 PRO - 65 Inch HQLED, Google TV, 2G+32G, Hands Free Voice Control.</p><ul><li>Size: 65 Inch</li><li>Model: 65P7 PRO</li><li>Material Code: DH20LJZ00</li></ul>', '65 Inch HQLED, Google TV, 2G+32G, Hands Free Voice Control.', 123900.00, 117900.00, 90644.00, 'haier, television, tv, smart tv', 0, 'vendor', NULL, NULL, 'draft', 0, 0, 0, 0, '2026-11-02 12:07:35', '2026-11-02 12:07:35', NULL),
(179, NULL, 53, 69, 12, 'Haier H65S85GUX 65 Inch HQLED Google TV', 'haier-dh20lkz00', 'DH20LKZ00', '<p>Haier H65S85GUX - 65 Inch HQLED, 120Hz, Hands Free, 2G+32G.</p><ul><li>Size: 65 Inch</li><li>Model: H65S85GUX</li><li>Material Code: DH20LKZ00</li></ul>', '65 Inch HQLED, 120Hz, Hands Free, 2G+32G.', 124900.00, 118900.00, 91376.00, 'haier, television, tv, smart tv', 0, 'vendor', NULL, NULL, 'draft', 0, 0, 0, 0, '2026-11-02 12:07:35', '2026-11-02 12:07:35', NULL),
(180, NULL, 53, 69, 12, 'Haier 75P7 PRO 75 Inch HQLED Google TV', 'haier-dh20kjz00', 'DH20KJZ00', '<p>Haier 75P7 PRO - 75 Inch HQLED, Google TV, 2G+32G, Hands Free Voice Control.</p><ul><li>Size: 75 Inch</li><li>Model: 75P7 PRO</li><li>Material Code: DH20KJZ00</li></ul>', '75 Inch HQLED, Google TV, 2G+32G, Hands Free Voice Control.', 164900.00, 154900.00, 120639.00, 'haier, television, tv, smart tv', 0, 'vendor', NULL, NULL, 'draft', 0, 0, 0, 0, '2026-11-02 12:07:35', '2026-11-02 12:07:35', NULL),
(181, NULL, 53, 70, 12, 'Haier H55M80GUX 55 Inch MiniLED TV', 'haier-dh210fz00', 'DH210FZ00', '<p>Haier H55M80GUX - 55 Inch MiniLED, 120Hz, KEF Sound.</p><ul><li>Size: 55 Inch</li><li>Model: H55M80GUX</li><li>Material Code: DH210FZ00</li></ul>', '55 Inch MiniLED, 120Hz, KEF Sound.', 109900.00, 101900.00, 82605.00, 'haier, television, tv, smart tv', 0, 'vendor', NULL, NULL, 'draft', 0, 0, 0, 0, '2026-11-02 12:07:35', '2026-11-02 12:07:35', NULL),
(182, NULL, 53, 70, 12, 'Haier H65M80GUX 65 Inch MiniLED TV', 'haier-dh20zez00', 'DH20ZEZ00', '<p>Haier H65M80GUX - 65 Inch MiniLED, 120Hz, KEF Sound.</p><ul><li>Size: 65 Inch</li><li>Model: H65M80GUX</li><li>Material Code: DH20ZEZ00</li></ul>', '65 Inch MiniLED, 120Hz, KEF Sound.', 145900.00, 135900.00, 109663.00, 'haier, television, tv, smart tv', 0, 'vendor', NULL, NULL, 'draft', 0, 0, 0, 0, '2026-11-02 12:07:35', '2026-11-02 12:07:35', NULL),
(183, NULL, 53, 70, 12, 'Haier H75M80GUX 75 Inch MiniLED TV', 'haier-dh20yez00', 'DH20YEZ00', '<p>Haier H75M80GUX - 75 Inch MiniLED, 120Hz, KEF Sound.</p><ul><li>Size: 75 Inch</li><li>Model: H75M80GUX</li><li>Material Code: DH20YEZ00</li></ul>', '75 Inch MiniLED, 120Hz, KEF Sound.', 197900.00, 182900.00, 148748.00, 'haier, television, tv, smart tv', 0, 'vendor', 'products/thumbnails/DWR7oM2FuWeJKI1CVDUQfOepd4iwjRfFzsY1ZQO8.webp', NULL, 'draft', 0, 0, 0, 0, '2026-11-02 12:07:35', '2026-11-08 10:29:19', NULL),
(184, NULL, 53, 70, 12, 'Haier H85M80GUX 85 Inch MiniLED TV', 'haier-dh20xbz00', 'DH20XBZ00', '<p>Haier H85M80GUX - 85 Inch MiniLED, 120Hz, KEF Sound.</p><ul><li>Size: 85 Inch</li><li>Model: H85M80GUX</li><li>Material Code: DH20XBZ00</li></ul>', '85 Inch MiniLED, 120Hz, KEF Sound.', 259900.00, 245900.00, 195349.00, 'haier, television, tv, smart tv', 0, 'vendor', 'products/thumbnails/IWDf2Jk6EY1YgR54PVEw1E2bOG4lq5enSOOozDXW.webp', NULL, 'draft', 0, 0, 0, 0, '2026-11-02 12:07:35', '2026-11-08 10:28:22', NULL),
(185, NULL, 53, 70, 12, 'Haier H100S90FUX 100 Inch MiniLED TV', 'haier-dh20eme00', 'DH20EME00', '<p dir=\"ltr\"><strong>Samsung 65Q7F 65″ QLED 4K Vision AI Smart TV</strong></p><p dir=\"ltr\">The Samsung 65Q7F 65″ QLED 4K Vision AI Smart TV is the ultimate upgrade for modern homes in Bangladesh, delivering breathtaking visuals, intelligent performance and advanced smart features. Designed with Quantum Dot Technology, this large 65-inch display ensures 100% Color Volume for richer, more vibrant and accurate colors.</p><p dir=\"ltr\"><strong>Stunning Picture Quality</strong></p><p dir=\"ltr\">With Quantum HDR and Contrast Enhancer, the TV delivers striking brightness, deep blacks and lifelike detail, perfect for movies, sports and gaming. Powered by the Q4 AI Processor, 4K AI Upscaling makes even lower-resolution content look sharp and immersive.</p><p dir=\"ltr\"><strong>Immersive Sound</strong></p><p dir=\"ltr\">Object Tracking Sound Lite (OTS Lite) creates a dynamic audio experience that makes action scenes more engaging. With Q-Symphony, you can pair the TV with a compatible Samsung soundbar for a more cinematic effect. The 20W RMS 2CH speakers deliver clear, balanced sound for any room size.</p><p dir=\"ltr\"><strong>Smart Features</strong></p><p dir=\"ltr\">Running on Samsung Tizen OS, the TV offers smooth navigation and easy access to streaming platforms like Netflix, YouTube, Amazon Prime Video and local Bangladeshi apps. Control it hands-free with Bixby and Alexa, while Samsung Knox Security keeps your smart ecosystem protected. Motion Xcelerator ensures smoother visuals for sports and fast-paced gaming, and Auto Power Saving helps reduce electricity usage.</p><p dir=\"ltr\"><strong>Versatile Connectivity</strong></p><ul dir=\"ltr\">\r\n<li>3 × HDMI ports (4K 60Hz)</li>\r\n<li>1 × USB-A port</li>\r\n<li>LAN (Ethernet) and RF input</li>\r\n<li>Bluetooth 5.3</li>\r\n<li>Dongle-based Zigbee / Thread support for smart home integration</li>\r\n<li>Sleek TM2560E remote controller</li>\r\n</ul><p dir=\"ltr\"><strong>Availability &amp; Warranty</strong></p><p>\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n</p><p dir=\"ltr\">Available at Best Electronics showrooms and online across Bangladesh, the Samsung 65Q7F QLED Smart TV comes with a 3-year warranty on panel and parts. For anyone in Bangladesh seeking a premium large-screen TV with advanced AI and QLED brilliance, the Samsung 65Q7F is the perfect choice.</p>', 'Samsung 65Q7F 65″', 499900.00, 449900.00, 390770.00, 'haier, television, tv, smart tv', 0, 'vendor', 'products/thumbnails/dUyrnCHaCaJ0F7CW7SNsgI8xIevhb7CqLwyuy8QD.webp', 'https://www.youtube.com/shorts/_8ztB0_Y8RQ?feature=share', 'draft', 0, 0, 0, 0, '2026-11-02 12:07:35', '2026-11-08 09:55:35', NULL),
(201, NULL, 56, 71, 12, 'Haier HMW-M2001BBD Solo Microwave Oven', 'haier-hmw-m2001bbd', 'HMW-M2001BBD', '<p>Haier Solo microwave oven.</p><ul><li>Model: HMW-M2001BBD</li><li>Material Code: FZ03WYM07</li><li>Type: Solo</li></ul>', 'Solo type microwave oven. Model: HMW-M2001BBD.', 10990.00, 10441.00, 9012.00, 'haier, microwave oven, microwave', 0, 'vendor', NULL, NULL, 'draft', 0, 0, 0, 0, '2026-11-02 12:07:46', '2026-11-02 12:07:46', NULL),
(202, NULL, 56, 72, 12, 'Haier HMW-E2301GBBD Grill Microwave Oven', 'haier-hmw-e2301gbbd', 'HMW-E2301GBBD', '<p>Haier Grill microwave oven.</p><ul><li>Model: HMW-E2301GBBD</li><li>Material Code: FZ03WXM07</li><li>Type: Grill</li></ul>', 'Grill type microwave oven. Model: HMW-E2301GBBD.', 15990.00, 15191.00, 13112.00, 'haier, microwave oven, microwave', 0, 'vendor', NULL, NULL, 'draft', 0, 0, 0, 0, '2026-11-02 12:07:46', '2026-11-02 12:07:46', NULL),
(203, NULL, 56, 73, 12, 'Haier HMW-E3001CBBD Convection Microwave Oven', 'haier-hmw-e3001cbbd', 'HMW-E3001CBBD', '<p>Haier Convection microwave oven.</p><ul><li>Model: HMW-E3001CBBD</li><li>Material Code: FZ03WWM07</li><li>Type: Convection</li></ul>', 'Convection type microwave oven. Model: HMW-E3001CBBD.', 23990.00, 22791.00, 19672.00, 'haier, microwave oven, microwave', 0, 'vendor', NULL, NULL, 'draft', 0, 0, 0, 0, '2026-11-02 12:07:46', '2026-11-02 12:07:46', NULL),
(204, NULL, 54, 66, 12, 'Haier HRF-578TPB T Door Refrigerator', 'haier-hrf-578tpb', 'HRF-578TPB', '<p>Haier T Door refrigerator.</p><ul><li>Model: HRF-578TPB</li><li>Type: T Door</li></ul>', 'T Door refrigerator. Model: HRF-578TPB.', 149900.00, 142405.00, 122918.00, 'haier, refrigerator, fridge', 0, 'vendor', NULL, NULL, 'draft', 0, 0, 0, 0, '2026-11-02 12:07:46', '2026-11-02 12:07:46', NULL),
(205, NULL, 54, 65, 12, 'Haier HRF-622IBG Side by Side Refrigerator', 'haier-hrf-622ibg', 'HRF-622IBG', '<p>Haier Side by Side refrigerator.</p><ul><li>Model: HRF-622IBG</li><li>Type: Side by Side</li></ul>', 'Side by Side refrigerator. Model: HRF-622IBG.', 145900.00, 138605.00, 119638.00, 'haier, refrigerator, fridge', 0, 'vendor', NULL, NULL, 'draft', 0, 0, 0, 0, '2026-11-02 12:07:46', '2026-11-02 12:07:46', NULL),
(206, NULL, 54, 65, 12, 'Haier HRF-622ICG Side by Side Refrigerator', 'haier-hrf-622icg', 'HRF-622ICG', '<p>Haier Side by Side refrigerator.</p><ul><li>Model: HRF-622ICG</li><li>Type: Side by Side</li></ul>', 'Side by Side refrigerator. Model: HRF-622ICG.', 144900.00, 137655.00, 118818.00, 'haier, refrigerator, fridge', 0, 'vendor', NULL, NULL, 'draft', 0, 0, 0, 0, '2026-11-02 12:07:46', '2026-11-02 12:07:46', NULL);
INSERT INTO `products` (`id`, `vendor_id`, `category_id`, `sub_category_id`, `brand_id`, `name`, `slug`, `sku`, `description`, `short_description`, `price`, `discount_price`, `cost_price`, `tags`, `stock_quantity`, `product_type`, `thumbnail`, `sponsored_video_url`, `status`, `is_new`, `is_featured`, `is_hot`, `views_count`, `created_at`, `updated_at`, `deleted_at`) VALUES
(207, NULL, 54, 67, 12, 'Haier HRF-386TBG No Frost Refrigerator', 'haier-hrf-386tbg', 'HRF-386TBG', '<p>Haier No Frost refrigerator.</p><ul><li>Model: HRF-386TBG</li><li>Type: No Frost</li></ul>', 'No Frost refrigerator. Model: HRF-386TBG.', 79900.00, 75905.00, 65518.00, 'haier, refrigerator, fridge', 0, 'vendor', NULL, NULL, 'draft', 0, 0, 0, 0, '2026-11-02 12:07:46', '2026-11-02 12:07:46', NULL),
(208, NULL, 54, 67, 12, 'Haier HRF-362TBG No Frost Refrigerator', 'haier-hrf-362tbg', 'HRF-362TBG', '<p>Haier No Frost refrigerator.</p><ul><li>Model: HRF-362TBG</li><li>Type: No Frost</li></ul>', 'No Frost refrigerator. Model: HRF-362TBG.', 75900.00, 72105.00, 62238.00, 'haier, refrigerator, fridge', 0, 'vendor', NULL, NULL, 'draft', 0, 0, 0, 0, '2026-11-02 12:07:46', '2026-11-02 12:07:46', NULL),
(209, NULL, 54, 67, 12, 'Haier HRF-500VBG No Frost Refrigerator', 'haier-hrf-500vbg', 'HRF-500VBG', '<p>Haier No Frost refrigerator.</p><ul><li>Model: HRF-500VBG</li><li>Type: No Frost</li></ul>', 'No Frost refrigerator. Model: HRF-500VBG.', 114900.00, 109155.00, 94218.00, 'haier, refrigerator, fridge', 0, 'vendor', NULL, NULL, 'draft', 0, 0, 0, 0, '2026-11-02 12:07:46', '2026-11-02 12:07:46', NULL),
(210, NULL, 54, 67, 12, 'Haier HRF-500VMB No Frost Refrigerator', 'haier-hrf-500vmb', 'HRF-500VMB', '<p>Haier No Frost refrigerator.</p><ul><li>Model: HRF-500VMB</li><li>Type: No Frost</li></ul>', 'No Frost refrigerator. Model: HRF-500VMB.', 108900.00, 103455.00, 89298.00, 'haier, refrigerator, fridge', 0, 'vendor', NULL, NULL, 'draft', 0, 0, 0, 0, '2026-11-02 12:07:46', '2026-11-02 12:07:46', NULL),
(211, NULL, 54, 67, 12, 'Haier HRF-475VBG No Frost Refrigerator', 'haier-hrf-475vbg', 'HRF-475VBG', '<p>Haier No Frost refrigerator.</p><ul><li>Model: HRF-475VBG</li><li>Type: No Frost</li></ul>', 'No Frost refrigerator. Model: HRF-475VBG.', 107900.00, 102505.00, 88478.00, 'haier, refrigerator, fridge', 0, 'vendor', NULL, NULL, 'draft', 0, 0, 0, 0, '2026-11-02 12:07:46', '2026-11-02 12:07:46', NULL),
(212, NULL, 54, 67, 12, 'Haier HRF-475VMB No Frost Refrigerator', 'haier-hrf-475vmb', 'HRF-475VMB', '<p>Haier No Frost refrigerator.</p><ul><li>Model: HRF-475VMB</li><li>Type: No Frost</li></ul>', 'No Frost refrigerator. Model: HRF-475VMB.', 102900.00, 97755.00, 84378.00, 'haier, refrigerator, fridge', 0, 'vendor', NULL, NULL, 'draft', 0, 0, 0, 0, '2026-11-02 12:07:46', '2026-11-02 12:07:46', NULL),
(219, NULL, 57, NULL, 12, 'Haier ES30H-CK3 Water Heater 30L', 'haier-es30h-ck3', 'ES30H-CK3', '<p>Haier 30 Litre water heater.</p><ul><li>Model: ES30H-CK3</li><li>Material Code: GA0SJHE00</li><li>Capacity: 30 Litre</li></ul>', '30 Litre water heater. Model: ES30H-CK3.', 13300.00, 11970.00, 9975.00, 'haier, water heater, geyser', 0, 'vendor', NULL, NULL, 'draft', 0, 0, 0, 0, '2026-11-02 12:07:46', '2026-11-02 12:07:46', NULL),
(220, NULL, 57, NULL, 12, 'Haier ES40H-CK3 Water Heater 40L', 'haier-es40h-ck3', 'ES40H-CK3', '<p>Haier 40 Litre water heater.</p><ul><li>Model: ES40H-CK3</li><li>Material Code: GA0G8WE00</li><li>Capacity: 40 Litre</li></ul>', '40 Litre water heater. Model: ES40H-CK3.', 14800.00, 13320.00, 11100.00, 'haier, water heater, geyser', 0, 'vendor', NULL, NULL, 'draft', 0, 0, 0, 0, '2026-11-02 12:07:46', '2026-11-02 12:07:46', NULL),
(221, NULL, 57, NULL, 12, 'Haier ES50H-CK3 Water Heater 50L', 'haier-es50h-ck3', 'ES50H-CK3', '<p>Haier 50 Litre water heater.</p><ul><li>Model: ES50H-CK3</li><li>Material Code: GA0G8VE00</li><li>Capacity: 50 Litre</li></ul>', '50 Litre water heater. Model: ES50H-CK3.', 16300.00, 14670.00, 12225.00, 'haier, water heater, geyser', 0, 'vendor', NULL, NULL, 'draft', 0, 0, 0, 0, '2026-11-02 12:07:46', '2026-11-02 12:07:46', NULL),
(222, NULL, 57, NULL, 12, 'Haier ES35H-Tigris Water Heater 35L', 'haier-es35h-tigris', 'ES35H-Tigris', '<p>Haier 35 Litre water heater.</p><ul><li>Model: ES35H-Tigris</li><li>Material Code: GA0UM0E04</li><li>Capacity: 35 Litre</li></ul>', '35 Litre water heater. Model: ES35H-Tigris.', 13800.00, 12420.00, 10350.00, 'haier, water heater, geyser', 0, 'vendor', NULL, NULL, 'draft', 1, 0, 0, 0, '2026-11-02 12:07:46', '2026-11-02 12:07:46', NULL),
(223, NULL, 57, NULL, 12, 'Haier ES45H-Tigris Water Heater 45L', 'haier-es45h-tigris', 'ES45H-Tigris', '<p>Haier 45 Litre water heater.</p><ul><li>Model: ES45H-Tigris</li><li>Material Code: GA0UM1E04</li><li>Capacity: 45 Litre</li></ul>', '45 Litre water heater. Model: ES45H-Tigris.', 15500.00, 13950.00, 11625.00, 'haier, water heater, geyser', 0, 'vendor', NULL, NULL, 'draft', 1, 0, 0, 0, '2026-11-02 12:07:46', '2026-11-02 12:07:46', NULL),
(224, NULL, 57, NULL, 12, 'Haier ES30V-Tigris Water Heater 30L', 'haier-es30v-tigris', 'ES30V-Tigris', '<p>Haier 30 Litre water heater.</p><ul><li>Model: ES30V-Tigris</li><li>Material Code: GA0UAAE02</li><li>Capacity: 30 Litre</li></ul>', '30 Litre water heater. Model: ES30V-Tigris.', 14300.00, 12870.00, 10725.00, 'haier, water heater, geyser', 0, 'vendor', NULL, NULL, 'draft', 1, 0, 0, 0, '2026-11-02 12:07:46', '2026-11-02 12:07:46', NULL),
(226, NULL, 58, 74, 12, 'Haier HW140-BD14697WU1 3 Drum Washing Machine', 'haier-hw140-bd14697wu1', 'HW140-BD14697WU1', '<p>Haier 3 Drum Washing Machine.</p><ul><li>Model: HW140-BD14697WU1</li><li>Type: 3 Drum Washing Machine</li></ul>', '3 Drum Washing Machine. Model: HW140-BD14697WU1.', 179900.00, 170905.00, 145719.00, 'haier, washing machine, laundry', 0, 'vendor', NULL, NULL, 'draft', 0, 0, 0, 0, '2026-11-02 12:08:00', '2026-11-02 12:08:00', NULL),
(227, NULL, 58, 76, 12, 'Haier HWD140-BPD14387GNU1 Washer Dryer', 'haier-hwd140-bpd14387gnu1', 'HWD140-BPD14387GNU1', '<p>Haier Washer Dryer.</p><ul><li>Model: HWD140-BPD14387GNU1</li><li>Type: Washer Dryer</li></ul>', 'Washer Dryer. Model: HWD140-BPD14387GNU1.', 128900.00, 122455.00, 104409.00, 'haier, washing machine, laundry', 0, 'vendor', NULL, NULL, 'draft', 0, 0, 0, 0, '2026-11-02 12:08:00', '2026-11-02 12:08:00', NULL),
(228, NULL, 58, 74, 12, 'Haier HW120-BP12357S8 Front Load Washing Machine', 'haier-hw120-bp12357s8', 'HW120-BP12357S8', '<p>Haier Front Load Washing Machine.</p><ul><li>Model: HW120-BP12357S8</li><li>Type: Front Load Washing Machine</li></ul>', 'Front Load Washing Machine. Model: HW120-BP12357S8.', 81900.00, 77805.00, 66339.00, 'haier, washing machine, laundry', 0, 'vendor', NULL, NULL, 'draft', 0, 0, 0, 0, '2026-11-02 12:08:00', '2026-11-02 12:08:00', NULL),
(229, NULL, 58, 74, 12, 'Haier HW100-BP12357S8 Front Load Washing Machine', 'haier-hw100-bp12357s8', 'HW100-BP12357S8', '<p>Haier Front Load Washing Machine.</p><ul><li>Model: HW100-BP12357S8</li><li>Type: Front Load Washing Machine</li></ul>', 'Front Load Washing Machine. Model: HW100-BP12357S8.', 76900.00, 73055.00, 62289.00, 'haier, washing machine, laundry', 0, 'vendor', NULL, NULL, 'draft', 0, 0, 0, 0, '2026-11-02 12:08:00', '2026-11-02 12:08:00', NULL),
(230, NULL, 58, 74, 12, 'Haier HW90-BP12357S8 Front Load Washing Machine', 'haier-hw90-bp12357s8', 'HW90-BP12357S8', '<p>Haier Front Load Washing Machine.</p><ul><li>Model: HW90-BP12357S8</li><li>Type: Front Load Washing Machine</li></ul>', 'Front Load Washing Machine. Model: HW90-BP12357S8.', 68900.00, 65455.00, 55809.00, 'haier, washing machine, laundry', 0, 'vendor', NULL, NULL, 'draft', 0, 0, 0, 0, '2026-11-02 12:08:00', '2026-11-02 12:08:00', NULL),
(231, NULL, 58, 76, 12, 'Haier HD80-V939S Front Load Dryer', 'haier-hd80-v939s', 'HD80-V939S', '<p>Haier Front Load Dryer.</p><ul><li>Model: HD80-V939S</li><li>Type: Front Load Dryer</li></ul>', 'Front Load Dryer. Model: HD80-V939S.', 54900.00, 49410.00, 39528.00, 'haier, washing machine, laundry', 0, 'vendor', NULL, NULL, 'draft', 0, 0, 0, 0, '2026-11-02 12:08:00', '2026-11-02 12:08:00', NULL),
(232, NULL, 58, 75, 12, 'Haier HWM200-BD2178S8 Top Load Washing Machine', 'haier-hwm200-bd2178s8', 'HWM200-BD2178S8', '<p>Haier Top Load Washing Machine.</p><ul><li>Model: HWM200-BD2178S8</li><li>Type: Top Load Washing Machine</li></ul>', 'Top Load Washing Machine. Model: HWM200-BD2178S8.', 63900.00, 60705.00, 51759.00, 'haier, washing machine, laundry', 0, 'vendor', NULL, NULL, 'draft', 0, 0, 0, 0, '2026-11-02 12:08:00', '2026-11-02 12:08:00', NULL),
(233, NULL, 58, 75, 12, 'Haier HWM130-B1678ES8 Top Load Washing Machine', 'haier-hwm130-b1678es8', 'HWM130-B1678ES8', '<p>Haier Top Load Washing Machine.</p><ul><li>Model: HWM130-B1678ES8</li><li>Type: Top Load Washing Machine</li></ul>', 'Top Load Washing Machine. Model: HWM130-B1678ES8.', 56900.00, 54055.00, 46089.00, 'haier, washing machine, laundry', 0, 'vendor', NULL, NULL, 'draft', 0, 0, 0, 0, '2026-11-02 12:08:00', '2026-11-02 12:08:00', NULL),
(234, NULL, 58, 75, 12, 'Haier HWM120-316S6 Top Load Washing Machine', 'haier-hwm120-316s6', 'HWM120-316S6', '<p>Haier Top Load Washing Machine.</p><ul><li>Model: HWM120-316S6</li><li>Type: Top Load Washing Machine</li></ul>', 'Top Load Washing Machine. Model: HWM120-316S6.', 52900.00, 50255.00, 42849.00, 'haier, washing machine, laundry', 0, 'vendor', NULL, NULL, 'draft', 0, 0, 0, 0, '2026-11-02 12:08:00', '2026-11-02 12:08:00', NULL),
(235, NULL, 58, 75, 12, 'Haier HWM100-316S6 Top Load Washing Machine', 'haier-hwm100-316s6', 'HWM100-316S6', '<p>Haier Top Load Washing Machine.</p><ul><li>Model: HWM100-316S6</li><li>Type: Top Load Washing Machine</li></ul>', 'Top Load Washing Machine. Model: HWM100-316S6.', 46900.00, 44555.00, 37989.00, 'haier, washing machine, laundry', 0, 'vendor', NULL, NULL, 'draft', 0, 0, 0, 0, '2026-11-02 12:08:00', '2026-11-02 12:08:00', NULL),
(236, NULL, 58, 75, 12, 'Haier HWM90-316S6 Top Load Washing Machine', 'haier-hwm90-316s6', 'HWM90-316S6', '<p>Haier Top Load Washing Machine.</p><ul><li>Model: HWM90-316S6</li><li>Type: Top Load Washing Machine</li></ul>', 'Top Load Washing Machine. Model: HWM90-316S6.', 38900.00, 36955.00, 31509.00, 'haier, washing machine, laundry', 0, 'vendor', NULL, NULL, 'draft', 0, 0, 0, 0, '2026-11-02 12:08:00', '2026-11-02 12:08:00', NULL),
(237, NULL, 58, 75, 12, 'Haier HWM80-316S6 Top Load Washing Machine', 'haier-hwm80-316s6', 'HWM80-316S6', '<p>Haier Top Load Washing Machine.</p><ul><li>Model: HWM80-316S6</li><li>Type: Top Load Washing Machine</li></ul>', 'Top Load Washing Machine. Model: HWM80-316S6.', 34400.00, 32680.00, 27864.00, 'haier, washing machine, laundry', 0, 'vendor', NULL, NULL, 'draft', 0, 0, 0, 0, '2026-11-02 12:08:00', '2026-11-02 12:08:00', NULL),
(238, NULL, 58, 75, 12, 'Haier HWM80-1269S6 Top Load Washing Machine', 'haier-hwm80-1269s6', 'HWM80-1269S6', '<p>Haier Top Load Washing Machine.</p><ul><li>Model: HWM80-1269S6</li><li>Type: Top Load Washing Machine</li></ul>', 'Top Load Washing Machine. Model: HWM80-1269S6.', 29900.00, 25500.00, 23000.00, 'haier, washing machine, laundry', 0, 'vendor', NULL, NULL, 'draft', 0, 0, 0, 0, '2026-11-02 12:08:00', '2026-11-02 12:08:00', NULL),
(241, NULL, 52, 60, 12, 'Haier HSU-24Gravity Inverter AC 2.0 Ton', 'haier-hsu-24gravity', 'HSU-24Gravity', '<p>Haier 2.0 Ton inverter air conditioner.</p><ul><li>Capacity: 2.0 Ton</li><li>Type: Inverter</li><li>Model: HSU-24Gravity(INV)(Pro)(X6)-WiFi*UV*AI</li></ul>', '2.0 Ton inverter air conditioner. Model: HSU-24Gravity(INV)(Pro)(X6)-WiFi*UV*AI.', 100990.00, NULL, 79782.00, 'haier, air conditioner, ac', 0, 'vendor', NULL, NULL, 'draft', 0, 0, 0, 0, '2026-11-02 12:08:00', '2026-11-02 12:08:00', NULL),
(242, NULL, 52, 60, 12, 'Haier HSU-19Gravity Inverter AC 1.6 Ton', 'haier-hsu-19gravity', 'HSU-19Gravity', '<p>Haier 1.6 Ton inverter air conditioner.</p><ul><li>Capacity: 1.6 Ton</li><li>Type: Inverter</li><li>Model: HSU-19Gravity(INV)(Pro)(X6)-WiFi*UV*AI</li></ul>', '1.6 Ton inverter air conditioner. Model: HSU-19Gravity(INV)(Pro)(X6)-WiFi*UV*AI.', 83990.00, NULL, 66352.00, 'haier, air conditioner, ac', 0, 'vendor', NULL, NULL, 'draft', 0, 0, 0, 0, '2026-11-02 12:08:00', '2026-11-02 12:08:00', NULL),
(243, NULL, 52, 60, 12, 'Haier HSU-13Gravity Inverter AC 1.0 Ton', 'haier-hsu-13gravity', 'HSU-13Gravity', '<p>Haier 1.0 Ton inverter air conditioner.</p><ul><li>Capacity: 1.0 Ton</li><li>Type: Inverter</li><li>Model: HSU-13Gravity(INV)(Pro)(X6)-WiFi*UV*AI</li></ul>', '1.0 Ton inverter air conditioner. Model: HSU-13Gravity(INV)(Pro)(X6)-WiFi*UV*AI.', 66990.00, NULL, 52922.00, 'haier, air conditioner, ac', 0, 'vendor', NULL, NULL, 'draft', 0, 0, 0, 0, '2026-11-02 12:08:00', '2026-11-02 12:08:00', NULL),
(244, NULL, 52, 60, 12, 'Haier HSU-19SolarCool Inverter AC 1.6 Ton', 'haier-hsu-19solarcool', 'HSU-19SolarCool', '<p>Haier 1.6 Ton inverter air conditioner.</p><ul><li>Capacity: 1.6 Ton</li><li>Type: Inverter</li><li>Model: HSU-19SolarCool:(INV)(WiFi)(FA)**</li></ul>', '1.6 Ton inverter air conditioner. Model: HSU-19SolarCool:(INV)(WiFi)(FA)**.', 155000.00, NULL, 120990.00, 'haier, air conditioner, ac', 0, 'vendor', NULL, NULL, 'draft', 0, 0, 0, 0, '2026-11-02 12:08:00', '2026-11-02 12:08:00', NULL),
(245, NULL, 52, 60, 12, 'Haier HSU-24UVCool Inverter AC 2.0 Ton', 'haier-hsu-24uvcool', 'HSU-24UVCool', '<p>Haier 2.0 Ton inverter air conditioner.</p><ul><li>Capacity: 2.0 Ton</li><li>Type: Inverter</li><li>Model: HSU-24UVCool(INV)(Pro)(X6)-WiFi*UV</li></ul>', '2.0 Ton inverter air conditioner. Model: HSU-24UVCool(INV)(Pro)(X6)-WiFi*UV.', 95990.00, NULL, 71993.00, 'haier, air conditioner, ac', 0, 'vendor', NULL, NULL, 'draft', 0, 0, 0, 0, '2026-11-02 12:08:00', '2026-11-02 12:08:00', NULL),
(246, NULL, 52, 60, 12, 'Haier HSU-24AntirustCool Inverter AC 2.0 Ton', 'haier-hsu-24antirustcool', 'HSU-24AntirustCool', '<p>Haier 2.0 Ton inverter air conditioner.</p><ul><li>Capacity: 2.0 Ton</li><li>Type: Inverter</li><li>Model: HSU-24AntirustCool(INV)(Pro)(X6)-WiFi</li></ul>', '2.0 Ton inverter air conditioner. Model: HSU-24AntirustCool(INV)(Pro)(X6)-WiFi.', 93990.00, NULL, 70493.00, 'haier, air conditioner, ac', 0, 'vendor', NULL, NULL, 'draft', 0, 0, 0, 0, '2026-11-02 12:08:00', '2026-11-02 12:08:00', NULL),
(247, NULL, 52, 60, 12, 'Haier HSU-24CleanCool Inverter AC 2.0 Ton', 'haier-hsu-24cleancool', 'HSU-24CleanCool', '<p>Haier 2.0 Ton inverter air conditioner.</p><ul><li>Capacity: 2.0 Ton</li><li>Type: Inverter</li><li>Model: HSU-24CleanCool(INV)(Pro)(X6)</li></ul>', '2.0 Ton inverter air conditioner. Model: HSU-24CleanCool(INV)(Pro)(X6).', 91990.00, NULL, 68993.00, 'haier, air conditioner, ac', 0, 'vendor', NULL, NULL, 'draft', 0, 0, 0, 0, '2026-11-02 12:08:00', '2026-11-02 12:08:00', NULL),
(248, NULL, 52, 60, 12, 'Haier HSU-19UltimateCool Inverter AC 1.6 Ton', 'haier-hsu-19ultimatecool', 'HSU-19UltimateCool', '<p>Haier 1.6 Ton inverter air conditioner.</p><ul><li>Capacity: 1.6 Ton</li><li>Type: Inverter</li><li>Model: HSU-19UltimateCool:(INV)(Pro)/T3-WiFi*UV**</li></ul>', '1.6 Ton inverter air conditioner. Model: HSU-19UltimateCool:(INV)(Pro)/T3-WiFi*UV**.', 99990.00, NULL, 74993.00, 'haier, air conditioner, ac', 0, 'vendor', NULL, NULL, 'draft', 0, 0, 0, 0, '2026-11-02 12:08:00', '2026-11-02 12:08:00', NULL),
(249, NULL, 52, 60, 12, 'Haier HSU-19PuriCool Inverter AC 1.6 Ton', 'haier-hsu-19puricool', 'HSU-19PuriCool', '<p>Haier 1.6 Ton inverter air conditioner.</p><ul><li>Capacity: 1.6 Ton</li><li>Type: Inverter</li><li>Model: HSU-19PuriCool(INV)(Pro)-WiFi*IFD*AirPurifier**</li></ul>', '1.6 Ton inverter air conditioner. Model: HSU-19PuriCool(INV)(Pro)-WiFi*IFD*AirPurifier**.', 99990.00, NULL, 74993.00, 'haier, air conditioner, ac', 0, 'vendor', NULL, NULL, 'draft', 0, 0, 0, 0, '2026-11-02 12:08:00', '2026-11-02 12:08:00', NULL),
(250, NULL, 52, 60, 12, 'Haier HSU-19HeatCool Inverter AC 1.6 Ton', 'haier-hsu-19heatcool', 'HSU-19HeatCool', '<p>Haier 1.6 Ton inverter air conditioner.</p><ul><li>Capacity: 1.6 Ton</li><li>Type: Inverter</li><li>Model: HSU-19HeatCool:(INV)(Pro)-WiFi</li></ul>', '1.6 Ton inverter air conditioner. Model: HSU-19HeatCool:(INV)(Pro)-WiFi.', 80990.00, NULL, 60743.00, 'haier, air conditioner, ac', 0, 'vendor', NULL, NULL, 'draft', 0, 0, 0, 0, '2026-11-02 12:08:00', '2026-11-02 12:08:00', NULL),
(251, NULL, 52, 60, 12, 'Haier HSU-19UVCool Inverter AC 1.6 Ton', 'haier-hsu-19uvcool', 'HSU-19UVCool', '<p>Haier 1.6 Ton inverter air conditioner.</p><ul><li>Capacity: 1.6 Ton</li><li>Type: Inverter</li><li>Model: HSU-19UVCool:(INV)(Pro)(X6)-WiFi*UV</li></ul>', '1.6 Ton inverter air conditioner. Model: HSU-19UVCool:(INV)(Pro)(X6)-WiFi*UV.', 79990.00, NULL, 59993.00, 'haier, air conditioner, ac', 0, 'vendor', NULL, NULL, 'draft', 0, 0, 0, 0, '2026-11-02 12:08:00', '2026-11-02 12:08:00', NULL),
(252, NULL, 52, 60, 12, 'Haier HSU-19AntirustCool Inverter AC 1.6 Ton', 'haier-hsu-19antirustcool', 'HSU-19AntirustCool', '<p>Haier 1.6 Ton inverter air conditioner.</p><ul><li>Capacity: 1.6 Ton</li><li>Type: Inverter</li><li>Model: HSU-19AntirustCool(INV)(Pro)(X6)-WiFi</li></ul>', '1.6 Ton inverter air conditioner. Model: HSU-19AntirustCool(INV)(Pro)(X6)-WiFi.', 77990.00, NULL, 58493.00, 'haier, air conditioner, ac', 0, 'vendor', NULL, NULL, 'draft', 0, 0, 0, 0, '2026-11-02 12:08:00', '2026-11-02 12:08:00', NULL),
(253, NULL, 52, 60, 12, 'Haier HSU-19CleanCool Inverter AC 1.6 Ton', 'haier-hsu-19cleancool', 'HSU-19CleanCool', '<p>Haier 1.6 Ton inverter air conditioner.</p><ul><li>Capacity: 1.6 Ton</li><li>Type: Inverter</li><li>Model: HSU-19CleanCool(INV)(Pro)(X6)</li></ul>', '1.6 Ton inverter air conditioner. Model: HSU-19CleanCool(INV)(Pro)(X6).', 75990.00, NULL, 56993.00, 'haier, air conditioner, ac', 0, 'vendor', NULL, NULL, 'draft', 0, 0, 0, 0, '2026-11-02 12:08:00', '2026-11-02 12:08:00', NULL),
(254, NULL, 52, 60, 12, 'Haier HSU-18ReviveCool Inverter AC 1.5 Ton', 'haier-hsu-18revivecool', 'HSU-18ReviveCool', '<p>Haier 1.5 Ton inverter air conditioner.</p><ul><li>Capacity: 1.5 Ton</li><li>Type: Inverter</li><li>Model: HSU-18ReviveCool(INV)(Pro)(X6)</li></ul>', '1.5 Ton inverter air conditioner. Model: HSU-18ReviveCool(INV)(Pro)(X6).', 69990.00, NULL, 52493.00, 'haier, air conditioner, ac', 0, 'vendor', NULL, NULL, 'draft', 0, 0, 0, 0, '2026-11-02 12:08:00', '2026-11-02 12:08:00', NULL),
(255, NULL, 52, 60, 12, 'Haier HSU-13UVCool Inverter AC 1.0 Ton', 'haier-hsu-13uvcool', 'HSU-13UVCool', '<p>Haier 1.0 Ton inverter air conditioner.</p><ul><li>Capacity: 1.0 Ton</li><li>Type: Inverter</li><li>Model: HSU-13UVCool(INV)(Pro)(X6)-WiFi*UV</li></ul>', '1.0 Ton inverter air conditioner. Model: HSU-13UVCool(INV)(Pro)(X6)-WiFi*UV.', 62990.00, NULL, 47243.00, 'haier, air conditioner, ac', 0, 'vendor', NULL, NULL, 'draft', 0, 0, 0, 0, '2026-11-02 12:08:00', '2026-11-02 12:08:00', NULL),
(256, NULL, 52, 60, 12, 'Haier HSU-13AntirustCool Inverter AC 1.0 Ton', 'haier-hsu-13antirustcool', 'HSU-13AntirustCool', '<p>Haier 1.0 Ton inverter air conditioner.</p><ul><li>Capacity: 1.0 Ton</li><li>Type: Inverter</li><li>Model: HSU-13AntirustCool(INV)(Pro)(X6)-WiFi</li></ul>', '1.0 Ton inverter air conditioner. Model: HSU-13AntirustCool(INV)(Pro)(X6)-WiFi.', 60990.00, NULL, 45743.00, 'haier, air conditioner, ac', 0, 'vendor', NULL, NULL, 'draft', 0, 0, 0, 0, '2026-11-02 12:08:00', '2026-11-02 12:08:00', NULL),
(257, NULL, 52, 60, 12, 'Haier HSU-13CleanCool Inverter AC 1.0 Ton', 'haier-hsu-13cleancool', 'HSU-13CleanCool', '<p>Haier 1.0 Ton inverter air conditioner.</p><ul><li>Capacity: 1.0 Ton</li><li>Type: Inverter</li><li>Model: HSU-13CleanCool(INV)(Pro)(X6)</li></ul>', '1.0 Ton inverter air conditioner. Model: HSU-13CleanCool(INV)(Pro)(X6).', 58990.00, NULL, 44243.00, 'haier, air conditioner, ac', 0, 'vendor', NULL, NULL, 'draft', 0, 0, 0, 0, '2026-11-02 12:08:00', '2026-11-02 12:08:00', NULL),
(258, NULL, 52, 61, 12, 'Haier HSU-24TurboAqua Non-Inverter AC 2.0 Ton', 'haier-hsu-24turboaqua', 'HSU-24TurboAqua', '<p>Haier 2.0 Ton non-inverter air conditioner.</p><ul><li>Capacity: 2.0 Ton</li><li>Type: Non-Inverter</li><li>Model: HSU-24TurboAqua(FIX)(Pro)(X6)</li></ul>', '2.0 Ton non-inverter air conditioner. Model: HSU-24TurboAqua(FIX)(Pro)(X6).', 78990.00, NULL, 59243.00, 'haier, air conditioner, ac', 0, 'vendor', NULL, NULL, 'draft', 0, 0, 0, 0, '2026-11-02 12:08:00', '2026-11-02 12:08:00', NULL),
(259, NULL, 52, 61, 12, 'Haier HSU-18TurboAqua Non-Inverter AC 1.5 Ton', 'haier-hsu-18turboaqua', 'HSU-18TurboAqua', '<p>Haier 1.5 Ton non-inverter air conditioner.</p><ul><li>Capacity: 1.5 Ton</li><li>Type: Non-Inverter</li><li>Model: HSU-18TurboAqua(FIX)(Pro)(X6)</li></ul>', '1.5 Ton non-inverter air conditioner. Model: HSU-18TurboAqua(FIX)(Pro)(X6).', 63990.00, NULL, 47993.00, 'haier, air conditioner, ac', 0, 'vendor', NULL, NULL, 'draft', 0, 0, 0, 0, '2026-11-02 12:08:00', '2026-11-02 12:08:00', NULL),
(260, NULL, 52, 61, 12, 'Haier HSU-12TurboAqua Non-Inverter AC 1.0 Ton', 'haier-hsu-12turboaqua', 'HSU-12TurboAqua', '<p>Haier 1.0 Ton non-inverter air conditioner.</p><ul><li>Capacity: 1.0 Ton</li><li>Type: Non-Inverter</li><li>Model: HSU-12TurboAqua(FIX)(Pro)(X6)</li></ul>', '1.0 Ton non-inverter air conditioner. Model: HSU-12TurboAqua(FIX)(Pro)(X6).', 50990.00, NULL, 38243.00, 'haier, air conditioner, ac', 0, 'vendor', NULL, NULL, 'draft', 0, 0, 0, 0, '2026-11-02 12:08:00', '2026-11-02 12:08:00', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `product_attributes`
--

CREATE TABLE `product_attributes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `attribute_id` bigint(20) UNSIGNED NOT NULL,
  `attribute_value_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_attributes`
--

INSERT INTO `product_attributes` (`id`, `product_id`, `attribute_id`, `attribute_value_id`, `created_at`, `updated_at`) VALUES
(14, 44, 1, 3, '2026-09-20 06:48:56', '2026-09-20 06:48:56'),
(15, 44, 2, 6, '2026-09-20 06:48:56', '2026-09-20 06:48:56'),
(16, 44, 2, 7, '2026-09-20 06:48:56', '2026-09-20 06:48:56'),
(20, 48, 1, 1, '2026-09-20 06:53:27', '2026-09-20 06:53:27'),
(21, 48, 1, 2, '2026-09-20 06:53:27', '2026-09-20 06:53:27'),
(22, 48, 1, 3, '2026-09-20 06:53:27', '2026-09-20 06:53:27'),
(25, 35, 2, 5, '2026-09-20 07:04:55', '2026-09-20 07:04:55'),
(26, 35, 2, 6, '2026-09-20 07:04:55', '2026-09-20 07:04:55'),
(27, 35, 2, 7, '2026-09-20 07:04:55', '2026-09-20 07:04:55'),
(28, 38, 2, 4, '2026-09-20 07:06:35', '2026-09-20 07:06:35'),
(29, 38, 2, 5, '2026-09-20 07:06:35', '2026-09-20 07:06:35'),
(30, 38, 2, 6, '2026-09-20 07:06:35', '2026-09-20 07:06:35'),
(31, 38, 2, 7, '2026-09-20 07:06:35', '2026-09-20 07:06:35'),
(32, 38, 2, 8, '2026-09-20 07:06:35', '2026-09-20 07:06:35'),
(33, 46, 1, 1, '2026-09-25 02:31:45', '2026-09-25 02:31:45'),
(34, 46, 1, 2, '2026-09-25 02:31:45', '2026-09-25 02:31:45'),
(35, 49, 1, 1, '2026-09-25 02:32:27', '2026-09-25 02:32:27'),
(36, 49, 1, 2, '2026-09-25 02:32:27', '2026-09-25 02:32:27'),
(38, 52, 1, 3, '2026-10-31 06:39:05', '2026-10-31 06:39:05'),
(39, 53, 1, 1, '2026-10-31 06:42:43', '2026-10-31 06:42:43'),
(40, 54, 1, 3, '2026-10-31 06:44:35', '2026-10-31 06:44:35'),
(41, 51, 1, 2, '2026-10-31 06:45:29', '2026-10-31 06:45:29'),
(42, 47, 1, 1, '2026-10-31 06:45:44', '2026-10-31 06:45:44'),
(43, 47, 1, 2, '2026-10-31 06:45:44', '2026-10-31 06:45:44'),
(44, 47, 1, 3, '2026-10-31 06:45:44', '2026-10-31 06:45:44'),
(45, 45, 1, 2, '2026-10-31 06:46:17', '2026-10-31 06:46:17'),
(46, 45, 1, 3, '2026-10-31 06:46:17', '2026-10-31 06:46:17'),
(47, 84, 1, 3, '2026-11-01 05:49:54', '2026-11-01 05:49:54');

-- --------------------------------------------------------

--
-- Table structure for table `product_images`
--

CREATE TABLE `product_images` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `image_path` varchar(255) NOT NULL,
  `is_primary` tinyint(1) DEFAULT 0,
  `sort_order` int(11) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product_images`
--

INSERT INTO `product_images` (`id`, `product_id`, `image_path`, `is_primary`, `sort_order`, `created_at`, `updated_at`) VALUES
(1, 44, 'products/gallery/9nRIQURhddSjMDFtwl05zPW5P5bpmlwchOL0aV13.jpg', 0, 0, '2026-09-19 20:58:47', '2026-09-19 20:58:47'),
(2, 44, 'products/gallery/25TFn9HsrPE4W2xMetJ29T93v1utmuLpMkQMcCq0.jpg', 0, 1, '2026-09-19 20:58:47', '2026-09-19 20:58:47'),
(3, 44, 'products/gallery/G9Nvq6wNzcXAUooHDF2SP6UDWpFvncUEa32aMOTG.webp', 0, 2, '2026-09-19 20:58:47', '2026-09-19 20:58:47'),
(4, 44, 'products/gallery/aVGQeOfsEu7C11fOVBpyhAGPjX4FGs1TlkDrFVgo.jpg', 0, 3, '2026-09-19 20:58:47', '2026-09-19 20:58:47'),
(5, 45, 'products/gallery/7A8ktbaQSPdAzxVc7wiPOEFs1gDcRf1OaOKRWZMB.jpg', 0, 0, '2026-09-19 21:04:42', '2026-09-19 21:04:42'),
(6, 45, 'products/gallery/4gH2Fe03rjyTWs0yqJL54uR6CtFKy11789muGkuM.jpg', 0, 1, '2026-09-19 21:04:42', '2026-09-19 21:04:42'),
(7, 45, 'products/gallery/53MOTPGriZ2iaBaShiOW6XVvo7oJMzlsZ43xlJb1.jpg', 0, 2, '2026-09-19 21:04:42', '2026-09-19 21:04:42'),
(8, 45, 'products/gallery/RcuWUYnIaLQNQ0RuXfI05p5R07Ge67KRdL3CGNIN.jpg', 0, 3, '2026-09-19 21:04:42', '2026-09-19 21:04:42'),
(9, 46, 'products/gallery/d3hqF5tqUTDZiwaOHWtXOGbSUGVXmhHsRG6ocexq.jpg', 0, 0, '2026-09-19 21:08:53', '2026-09-19 21:08:53'),
(10, 46, 'products/gallery/lYWpj4ilVz5BrnNwjyrofISLslttf9uMEjPL59vz.jpg', 0, 1, '2026-09-19 21:08:53', '2026-09-19 21:08:53'),
(11, 46, 'products/gallery/syMY4MN2mNs1XBc74DO7H2lTn4YQV4ubF9gFvn9n.jpg', 0, 2, '2026-09-19 21:08:53', '2026-09-19 21:08:53'),
(12, 46, 'products/gallery/Im3uvVHbHAyAB3WjQMFt6iV8r7PTCAXeDFh1d4Mk.jpg', 0, 3, '2026-09-19 21:08:53', '2026-09-19 21:08:53'),
(13, 46, 'products/gallery/rPiLeg6vtWvqlxvBcloN0XAqFR1nb4hV8B2uD2ug.jpg', 0, 4, '2026-09-19 21:08:53', '2026-09-19 21:08:53'),
(14, 46, 'products/gallery/QVAtI55fHc0ezBq6ESSRpTFhrH0OyM8J32vDJyNS.jpg', 0, 5, '2026-09-19 21:08:53', '2026-09-19 21:08:53'),
(15, 47, 'products/gallery/WtA181NnEz5QRliAnt7nmwkBZAGntvdaLvny08Ws.jpg', 0, 0, '2026-09-20 06:48:18', '2026-09-20 06:48:18'),
(16, 48, 'products/gallery/a4imomTmLNEtGZ8F1tfDkBHawz58sOlDQtg4Z6sg.jpg', 0, 0, '2026-09-20 06:53:27', '2026-09-20 06:53:27'),
(17, 48, 'products/gallery/6degt9qEbILiDo7U772hUDZcsKdNzuFhrCknXhox.webp', 0, 1, '2026-09-20 06:53:27', '2026-09-20 06:53:27'),
(18, 48, 'products/gallery/0BdpC9vuSmB5EJVpySE8jtohfSlbdu6XJSKzqbr1.jpg', 0, 2, '2026-09-20 06:53:27', '2026-09-20 06:53:27'),
(19, 48, 'products/gallery/yWARoVyeTZ564eaE7uDZVisL9417XhbPaO3PDv6W.jpg', 0, 3, '2026-09-20 06:53:27', '2026-09-20 06:53:27'),
(20, 49, 'products/gallery/OJqTZJQdCm63tqlKZ8I21nPCfFd1KyYVHCcsT5tq.jpg', 0, 0, '2026-09-20 06:59:18', '2026-09-20 06:59:18'),
(21, 49, 'products/gallery/aJdn2aapCIgEL6V9CzqEigUTtHnCj1eNh83HuXtP.jpg', 0, 1, '2026-09-20 06:59:18', '2026-09-20 06:59:18'),
(22, 49, 'products/gallery/HxIFTNt4fWoofVtJKdkKq5sGSMcBOWRZW6jE8nAo.webp', 0, 2, '2026-09-20 06:59:18', '2026-09-20 06:59:18'),
(23, 49, 'products/gallery/HaDOuCHw2AzewmrEKxfMq7EBA3TLvmTwaF4MV42o.jpg', 0, 3, '2026-09-20 06:59:18', '2026-09-20 06:59:18'),
(24, 49, 'products/gallery/9Fh1CareoGvx7SSFWdxcRbyPWRBn10CMIvmXH4D0.webp', 0, 4, '2026-09-20 06:59:18', '2026-09-20 06:59:18'),
(25, 49, 'products/gallery/Umt2p9KlbW6JzOifMBefRprLaPh8mErmmYSN3CSz.webp', 0, 5, '2026-09-20 06:59:18', '2026-09-20 06:59:18'),
(26, 50, 'products/gallery/rOHXCrmxt2hZDwymORTjDCVvqDyLEuJfKcGxNvZP.jpg', 0, 0, '2026-09-20 07:03:15', '2026-09-20 07:03:15'),
(27, 50, 'products/gallery/bSEkLmnTPgt2Ut5Kx4aNcgWij2K0V68jMeBbpghe.jpg', 0, 1, '2026-09-20 07:03:15', '2026-09-20 07:03:15'),
(28, 50, 'products/gallery/skhbqOU9nz08XV9K50J1xeZ6PggqBBZBjSTfmTUb.png', 0, 2, '2026-09-20 07:03:15', '2026-09-20 07:03:15'),
(29, 50, 'products/gallery/5x58PYS3HkQckH7H1sSVtodfv1HQJN7U3YQnknE6.jpg', 0, 3, '2026-09-20 07:03:15', '2026-09-20 07:03:15'),
(30, 50, 'products/gallery/Sl0j44Ncs1ouBnVwvyWKPoluY3qZaxed8wtFnbrx.jpg', 0, 4, '2026-09-20 07:03:15', '2026-09-20 07:03:15'),
(31, 33, 'products/gallery/VBf0e5vtEIY6CN5zN4iq9HtuZSPz1xnRULJliIZ3.png', 0, 1, '2026-09-20 07:03:54', '2026-09-20 07:03:54'),
(32, 33, 'products/gallery/cEc7e52ulOQxfv2LyaDAjs8MnuibGPpp3o9TqSaF.png', 0, 2, '2026-09-20 07:03:54', '2026-09-20 07:03:54'),
(33, 33, 'products/gallery/NO5mQxVpixf1JWtYHMlVRfdbdbuX6VeQfvYWdzsL.png', 0, 3, '2026-09-20 07:03:54', '2026-09-20 07:03:54'),
(34, 34, 'products/gallery/5Yzb5JpFd1eOe09NfRzDeg44D2E0eYipWSpiGrnL.png', 0, 1, '2026-09-20 07:04:24', '2026-09-20 07:04:24'),
(35, 34, 'products/gallery/wvs6WGRJUFGLBIJ9ap4XIdYvqJKdKdD28IHvWPf7.png', 0, 2, '2026-09-20 07:04:24', '2026-09-20 07:04:24'),
(36, 34, 'products/gallery/2KyZkLDH7USNdw6iSQ7HT0OTeKxjldF8KW1bMeUN.png', 0, 3, '2026-09-20 07:04:24', '2026-09-20 07:04:24'),
(37, 34, 'products/gallery/qDeNHwM6LWjuIFv27DbGmhUPvZE50a34vsACyzBu.png', 0, 4, '2026-09-20 07:04:24', '2026-09-20 07:04:24'),
(38, 35, 'products/gallery/kkMpAT64tUjYcTIM8vaMKohJlgOhjxi22k6grzRO.png', 0, 1, '2026-09-20 07:04:55', '2026-09-20 07:04:55'),
(39, 35, 'products/gallery/obiqrb6TDEIVO2M4lJTnCu2GuBRPsKqQfjLLyq1v.png', 0, 2, '2026-09-20 07:04:55', '2026-09-20 07:04:55'),
(40, 35, 'products/gallery/S3mbE1DMXVSnDzxVIcp3dMPI5crmkbq6rDZ1sTx5.png', 0, 3, '2026-09-20 07:04:55', '2026-09-20 07:04:55'),
(41, 36, 'products/gallery/pIMLcMnC1mIa8SC1pOAnbx6mjagz50cPcnHsayMP.png', 0, 1, '2026-09-20 07:05:27', '2026-09-20 07:05:27'),
(42, 36, 'products/gallery/N4qr3jklxuy8TMwZ5rpl4JssvkTRDaxJpNlexZgP.png', 0, 2, '2026-09-20 07:05:27', '2026-09-20 07:05:27'),
(43, 36, 'products/gallery/G8fCzolKB87BtLCjQ4Xl1xqbOrPbkFphPwEPkcFq.png', 0, 3, '2026-09-20 07:05:27', '2026-09-20 07:05:27'),
(44, 37, 'products/gallery/JyK8DynBPYQRh4NRj9UH7VgV9r1H3cK3fYQJ4axk.png', 0, 1, '2026-09-20 07:05:56', '2026-09-20 07:05:56'),
(45, 37, 'products/gallery/MsrRXrkFUVe5s0raeTa0fiqtEidZMfjXf2077SNW.png', 0, 2, '2026-09-20 07:05:56', '2026-09-20 07:05:56'),
(46, 37, 'products/gallery/FA9bEBkLfjbXxkq575H8MkjC3Uy5aGhRI5GFMz1n.png', 0, 3, '2026-09-20 07:05:56', '2026-09-20 07:05:56'),
(47, 38, 'products/gallery/MrwCcV6bgx7XlHRh4BfZJ6QwkeSXabbGWU4THF5N.png', 0, 1, '2026-09-20 07:06:35', '2026-09-20 07:06:35'),
(48, 38, 'products/gallery/f5qQmFSRMNXBVC1wkpJgi4ZZO99RP6bGoOldBCk6.png', 0, 2, '2026-09-20 07:06:35', '2026-09-20 07:06:35'),
(49, 38, 'products/gallery/EgvuYPRja9EvIwAy3ahWTqNnFwdf51Fj2vbfc7Eo.png', 0, 3, '2026-09-20 07:06:35', '2026-09-20 07:06:35'),
(50, 38, 'products/gallery/jjDzMBYUehzZokRSJGw40QD0gIVH9DuhMaNbHaPX.png', 0, 4, '2026-09-20 07:06:35', '2026-09-20 07:06:35'),
(51, 39, 'products/gallery/pN2v9lv98lHu3YYsVT0ipHVFfRygp1Rw8hs3EE1X.png', 0, 1, '2026-09-20 07:07:02', '2026-09-20 07:07:02'),
(52, 39, 'products/gallery/z9TAkjNzdZdb3s1f6WYwyP7XbmS9y1Y9HyZZCD36.png', 0, 2, '2026-09-20 07:07:02', '2026-09-20 07:07:02'),
(53, 39, 'products/gallery/WktDQvqc9CTnuJwYDIZgeklblx0wJZAVfMIskPnU.png', 0, 3, '2026-09-20 07:07:02', '2026-09-20 07:07:02'),
(54, 40, 'products/gallery/ZyrtakPr4LMIrxjh0Md19qwnSymHcgHIvhD0aYBt.jpg', 0, 1, '2026-09-20 07:07:21', '2026-09-20 07:07:21'),
(55, 40, 'products/gallery/ekKn6Typ3df0jdESCpSjBBJJ2WhfZn0cUPFjTNr3.jpg', 0, 2, '2026-09-20 07:07:21', '2026-09-20 07:07:21'),
(56, 40, 'products/gallery/4Kr68IWqIBndcuEW8Jq46RAiAVrTL8DQR2qqJG8X.jpg', 0, 3, '2026-09-20 07:07:21', '2026-09-20 07:07:21'),
(57, 43, 'products/gallery/KU7n0YWICbHTsytUfdKMHTRk90yhN6TzsssIgkAA.png', 0, 1, '2026-09-20 07:07:55', '2026-09-20 07:07:55'),
(58, 43, 'products/gallery/ttyYv3hs3WFXkyd9GeqnPY61a9jh8PZhSyCQWtUh.png', 0, 2, '2026-09-20 07:07:55', '2026-09-20 07:07:55'),
(59, 43, 'products/gallery/lw6dxDO2STwqqYwTemS5VHC6UyBOAyx0Ko5usAft.png', 0, 3, '2026-09-20 07:07:55', '2026-09-20 07:07:55'),
(60, 43, 'products/gallery/IMpE7eval7WJGdtI9xIZ8tvOTaEH0fPYLKMbhk03.png', 0, 4, '2026-09-20 07:07:55', '2026-09-20 07:07:55'),
(61, 43, 'products/gallery/6Gk7CONOc4t0jXuUqndHs04bU7da1RSx4F5hkouh.png', 0, 5, '2026-09-20 07:07:55', '2026-09-20 07:07:55'),
(62, 43, 'products/gallery/4s4dKkzcXpr2Y1VZv8BNHdIYyy5zY4BWrnrdwc83.png', 0, 6, '2026-09-20 07:07:55', '2026-09-20 07:07:55'),
(63, 42, 'products/gallery/Gk2882kbmMLo2vHQqhpHeim5bdIG6ijPGa1y13v0.png', 0, 1, '2026-09-20 07:08:16', '2026-09-20 07:08:16'),
(64, 41, 'products/gallery/Bc6DiVIog8KtVlmCiphRpUH668w6Mdtc1etcqdes.png', 0, 1, '2026-09-20 07:08:35', '2026-09-20 07:08:35'),
(65, 41, 'products/gallery/0PdZwSodKsRjvdSncUixEhS1pXLA0QuxhFWnfmhD.png', 0, 2, '2026-09-20 07:08:35', '2026-09-20 07:08:35'),
(66, 41, 'products/gallery/n5w9XMG0wqvDW05DpfK9YC8SM5HVBusnwaqJpmL4.png', 0, 3, '2026-09-20 07:08:35', '2026-09-20 07:08:35'),
(67, 51, 'products/gallery/U0x1EWvSf4viFMmT8iLnl4FAAvCIgY37poFbbsOT.jpg', 0, 0, '2026-10-31 06:36:19', '2026-10-31 06:36:19'),
(68, 51, 'products/gallery/ThM4woIP6W5JYQw3mr0OBWvOtCu7YiPxTlL8Eb72.jpg', 0, 1, '2026-10-31 06:36:19', '2026-10-31 06:36:19'),
(69, 52, 'products/gallery/OVp7Qj2ANSRn92N4ZjLRZGpxaktjcTnWaO5BTkq1.jpg', 0, 0, '2026-10-31 06:39:05', '2026-10-31 06:39:05'),
(70, 52, 'products/gallery/I9s2IGvK2tpc749TF579u2NoWy2r6NKwjJxMAJTW.jpg', 0, 1, '2026-10-31 06:39:05', '2026-10-31 06:39:05'),
(71, 52, 'products/gallery/55LvcH0lg8kJrMUiC4x4coMnmYcXMwKRCawl7p8e.jpg', 0, 2, '2026-10-31 06:39:05', '2026-10-31 06:39:05'),
(72, 52, 'products/gallery/R11qNMopWItRVPAOhJ6JAGxbzCZyOIycmNTjzNDN.jpg', 0, 3, '2026-10-31 06:39:05', '2026-10-31 06:39:05'),
(73, 52, 'products/gallery/YbyYWFvomYouvDPY3rcUJkxqmkC8buM9fR4u5f38.jpg', 0, 4, '2026-10-31 06:39:05', '2026-10-31 06:39:05'),
(74, 52, 'products/gallery/YfHAjsu51FmnS8sSusFyxsqqeWWHGqEhZq0oY7Z6.jpg', 0, 5, '2026-10-31 06:39:05', '2026-10-31 06:39:05'),
(75, 53, 'products/gallery/4fvSC9KxjZRd2GUEPqOtTyEZF0DbWu33SfvuzHMT.jpg', 0, 0, '2026-10-31 06:42:43', '2026-10-31 06:42:43'),
(76, 53, 'products/gallery/OyLyf6qmQZrhhylCFD8UKj9Gg55nreZ7ziriUIQY.jpg', 0, 1, '2026-10-31 06:42:43', '2026-10-31 06:42:43'),
(77, 53, 'products/gallery/oCcE6oGeTCjWoUS65qJOIrm1TPuzldgzkBbDd3Bx.jpg', 0, 2, '2026-10-31 06:42:43', '2026-10-31 06:42:43'),
(78, 54, 'products/gallery/cYAWtXX5cFWcIdJJYcL6qXDoFJ4KhyBP48AAtMQz.jpg', 0, 0, '2026-10-31 06:44:35', '2026-10-31 06:44:35'),
(79, 54, 'products/gallery/hIz2t3P6ph1YGynA6Wc39vIpvA9Fmzghr6yv0ZDV.jpg', 0, 1, '2026-10-31 06:44:35', '2026-10-31 06:44:35'),
(80, 54, 'products/gallery/LBfcseHd7nQQYh1Ce96nCIVAej3u5mo52fM0IwDu.jpg', 0, 2, '2026-10-31 06:44:35', '2026-10-31 06:44:35'),
(81, 54, 'products/gallery/A69WjYcl0UMLUV9nr01YFX2Y6q7ooQcVKuauIfAB.jpg', 0, 3, '2026-10-31 06:44:35', '2026-10-31 06:44:35'),
(82, 84, 'products/gallery/9h8HHzhXmsLFFR9FnzrOY3KsGPRogqTksaPxdW5i.webp', 0, 1, '2026-11-01 05:49:54', '2026-11-01 05:49:54'),
(83, 185, 'products/gallery/zE0DN8fDz8tsKUmMaEXEhrb8XUfTozCMWYGKPpF6.webp', 0, 1, '2026-11-08 09:55:35', '2026-11-08 09:55:35'),
(84, 185, 'products/gallery/kEROD7BlLB7JySyjhVOfulJeFJkMdWNTajL9lFxU.webp', 0, 2, '2026-11-08 09:55:35', '2026-11-08 09:55:35'),
(85, 185, 'products/gallery/T60SiStjUyv8kCkN3WhXI03sntukIZRyEyoWROuv.webp', 0, 3, '2026-11-08 09:55:35', '2026-11-08 09:55:35'),
(86, 185, 'products/gallery/kCzIpfvO58H7Qb8aj8JQx8arrU274orb7MFS60G7.webp', 0, 4, '2026-11-08 09:55:35', '2026-11-08 09:55:35'),
(87, 184, 'products/gallery/NDZgDgIdOfFnGtvzXoMeBWYmhxzj57krh9wopeHd.webp', 0, 1, '2026-11-08 10:28:22', '2026-11-08 10:28:22'),
(88, 184, 'products/gallery/UlvrIy4XbrrW0aH7gK9MhkGCzvB3kuskC29D5Dk2.webp', 0, 2, '2026-11-08 10:28:22', '2026-11-08 10:28:22'),
(89, 184, 'products/gallery/zxrI1JfqBw3l5gYj1UWetHlXwEfxxh2i80Z0pVfY.webp', 0, 3, '2026-11-08 10:28:22', '2026-11-08 10:28:22'),
(90, 183, 'products/gallery/LV2iytmnfUDqftCV7Am7xJniCGKcleQjBo82o0TU.webp', 0, 1, '2026-11-08 10:29:19', '2026-11-08 10:29:19'),
(91, 183, 'products/gallery/plgz085gnvOvZCsQN16VQyZ6Y8STihZn4fC5b9Ts.webp', 0, 2, '2026-11-08 10:29:19', '2026-11-08 10:29:19'),
(92, 183, 'products/gallery/3aSjlzAIcw1e2TNlNYm8ncvEqbeuaY1lZYz8V4kW.webp', 0, 3, '2026-11-08 10:29:19', '2026-11-08 10:29:19'),
(93, 183, 'products/gallery/9RfjbQEZTVG2f3IyDLx4kyWYIDFMdbb50M1nr6Po.webp', 0, 4, '2026-11-08 10:29:19', '2026-11-08 10:29:19'),
(94, 183, 'products/gallery/TFIyRwkJzZwFlAWEqtSzPgrvBgUsc9VxSdIWTbT8.webp', 0, 5, '2026-11-08 10:29:19', '2026-11-08 10:29:19');

-- --------------------------------------------------------

--
-- Table structure for table `product_imports`
--

CREATE TABLE `product_imports` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `vendor_id` bigint(20) UNSIGNED NOT NULL,
  `supplier_product_id` bigint(20) UNSIGNED NOT NULL,
  `status` enum('pending','imported','failed') DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product_offer_images`
--

CREATE TABLE `product_offer_images` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `image_path` varchar(255) NOT NULL,
  `sort_order` smallint(5) UNSIGNED NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_offer_images`
--

INSERT INTO `product_offer_images` (`id`, `product_id`, `image_path`, `sort_order`, `created_at`, `updated_at`) VALUES
(1, 185, 'products/offers/KDTxJMicpffLfOvE89O1OmlovcyzvxOjnIWQrMCG.webp', 1, '2026-11-08 09:55:35', '2026-11-08 09:55:35'),
(2, 185, 'products/offers/FnsPS8co9Pd0l8EoMcmATndcGdpCIbqKkNvmN3Jr.webp', 2, '2026-11-08 09:55:35', '2026-11-08 09:55:35');

-- --------------------------------------------------------

--
-- Table structure for table `product_specifications`
--

CREATE TABLE `product_specifications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `value` text DEFAULT NULL,
  `sort_order` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_specifications`
--

INSERT INTO `product_specifications` (`id`, `product_id`, `name`, `value`, `sort_order`, `created_at`, `updated_at`) VALUES
(1, 33, 'Brand', 'Panasonic', 0, '2026-11-05 11:14:24', '2026-11-05 11:14:24'),
(2, 33, 'Color', 'Gray', 1, '2026-11-05 11:14:24', '2026-11-05 11:14:24'),
(3, 33, 'WM Capacity', '8 KG', 2, '2026-11-05 11:14:24', '2026-11-05 11:14:24'),
(4, 33, 'WM Type', 'Front Load', 3, '2026-11-05 11:14:24', '2026-11-05 11:14:24'),
(5, 33, 'Number Of Program', '15', 4, '2026-11-05 11:14:24', '2026-11-05 11:14:24'),
(6, 33, 'RPM', '1400', 5, '2026-11-05 11:14:24', '2026-11-05 11:14:24'),
(7, 33, 'Rated Power Supply', '220-240 V', 6, '2026-11-05 11:14:24', '2026-11-05 11:14:24'),
(8, 33, 'Rated Frequency', '50 / 60Hz', 7, '2026-11-05 11:14:24', '2026-11-05 11:14:24'),
(9, 33, 'Child Lock', 'Yes', 8, '2026-11-05 11:14:24', '2026-11-05 11:14:24'),
(10, 33, 'Warranty', '2 Years', 9, '2026-11-05 11:14:24', '2026-11-05 11:14:24'),
(11, 34, 'Brand', 'Conion', 0, '2026-11-05 11:14:24', '2026-11-05 11:14:24'),
(12, 34, 'WM Type', 'Top Load', 1, '2026-11-05 11:14:24', '2026-11-05 11:14:24'),
(13, 34, 'WM Capacity', '9.5 KG', 2, '2026-11-05 11:14:24', '2026-11-05 11:14:24'),
(14, 34, 'Color', 'Black', 3, '2026-11-05 11:14:24', '2026-11-05 11:14:24'),
(15, 34, 'Voltage/Frequency', '220-240V/50Hz', 4, '2026-11-05 11:14:24', '2026-11-05 11:14:24'),
(16, 34, 'Wash Power (W)', '420W', 5, '2026-11-05 11:14:24', '2026-11-05 11:14:24'),
(17, 34, 'Spin Speed (RPM)', '740', 6, '2026-11-05 11:14:24', '2026-11-05 11:14:24'),
(18, 34, 'Net Dimensions (mm)', '570 * 580 * 985', 7, '2026-11-05 11:14:24', '2026-11-05 11:14:24'),
(19, 34, 'Warranty', '10 Years Motor', 8, '2026-11-05 11:14:24', '2026-11-05 11:14:24'),
(20, 35, 'Brand', 'Whirlpool', 0, '2026-11-05 11:14:24', '2026-11-05 11:14:24'),
(21, 35, 'WM Type', 'Top Load', 1, '2026-11-05 11:14:24', '2026-11-05 11:14:24'),
(22, 35, 'WM Capacity', '8 KG', 2, '2026-11-05 11:14:24', '2026-11-05 11:14:24'),
(23, 35, 'Color', 'Grey', 3, '2026-11-05 11:14:24', '2026-11-05 11:14:24'),
(24, 35, 'Heater', 'In-built', 4, '2026-11-05 11:14:24', '2026-11-05 11:14:24'),
(25, 35, 'Spin Speed Selection', '0-400-600-800-1000-1200-1400', 5, '2026-11-05 11:14:24', '2026-11-05 11:14:24'),
(26, 35, 'Child Lock', 'Yes', 6, '2026-11-05 11:14:24', '2026-11-05 11:14:24'),
(27, 35, 'Warranty', '2 Years', 7, '2026-11-05 11:14:24', '2026-11-05 11:14:24'),
(40, 185, 'Brand', 'Samsung', 0, '2026-11-08 09:55:35', '2026-11-08 09:55:35'),
(41, 185, 'Screen Size', '65″', 1, '2026-11-08 09:55:35', '2026-11-08 09:55:35'),
(42, 185, 'Screen Type', 'QLED', 2, '2026-11-08 09:55:35', '2026-11-08 09:55:35'),
(43, 185, 'Resolution', 'UHD (4K)', 3, '2026-11-08 09:55:35', '2026-11-08 09:55:35'),
(44, 185, 'OS	Samsung', 'Tizen OS', 4, '2026-11-08 09:55:35', '2026-11-08 09:55:35'),
(45, 185, 'Remote Controller Model', 'TM2560E', 5, '2026-11-08 09:55:35', '2026-11-08 09:55:35');

-- --------------------------------------------------------

--
-- Table structure for table `product_syncs`
--

CREATE TABLE `product_syncs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `dropshipping_product_id` bigint(20) UNSIGNED NOT NULL,
  `last_synced_at` timestamp NULL DEFAULT NULL,
  `sync_status` enum('success','failed') DEFAULT 'success',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product_variants`
--

CREATE TABLE `product_variants` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `sku` varchar(100) DEFAULT NULL,
  `variant_name` varchar(191) DEFAULT NULL,
  `unit_type` varchar(255) NOT NULL,
  `unit_value` decimal(10,2) NOT NULL,
  `price` decimal(12,2) NOT NULL DEFAULT 0.00,
  `compare_price` decimal(10,2) DEFAULT NULL,
  `stock_quantity` int(11) DEFAULT 0,
  `is_default` tinyint(1) NOT NULL DEFAULT 0,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product_variants`
--

INSERT INTO `product_variants` (`id`, `product_id`, `sku`, `variant_name`, `unit_type`, `unit_value`, `price`, `compare_price`, `stock_quantity`, `is_default`, `image`, `created_at`, `updated_at`) VALUES
(1, 44, NULL, NULL, 'piece', 1.00, 5000.00, NULL, 20, 0, NULL, '2026-09-19 20:58:47', '2026-09-19 20:58:47'),
(2, 45, NULL, NULL, 'piece', 1.00, 50000.00, NULL, 30, 0, NULL, '2026-09-19 21:04:42', '2026-09-19 21:04:42'),
(3, 46, NULL, NULL, 'piece', 1.00, 70000.00, NULL, 5, 0, NULL, '2026-09-19 21:08:53', '2026-09-19 21:08:53'),
(4, 47, NULL, NULL, 'piece', 1.00, 15000.00, NULL, 5, 0, NULL, '2026-09-20 06:48:18', '2026-09-20 06:48:18'),
(5, 48, NULL, NULL, 'piece', 1.00, 18000.00, NULL, 8, 0, NULL, '2026-09-20 06:53:27', '2026-09-20 06:53:27'),
(6, 49, NULL, NULL, 'piece', 1.00, 5000.00, NULL, 30, 0, NULL, '2026-09-20 06:59:18', '2026-09-20 06:59:18'),
(7, 50, NULL, NULL, 'piece', 1.00, 4500.00, NULL, 50, 0, NULL, '2026-09-20 07:03:15', '2026-09-20 07:03:15'),
(8, 34, NULL, NULL, 'piece', 1.00, 720.00, NULL, 20, 0, NULL, '2026-09-20 07:04:24', '2026-09-20 07:04:24'),
(9, 37, NULL, NULL, 'piece', 1.00, 220.00, NULL, 10, 0, NULL, '2026-09-20 07:05:56', '2026-09-20 07:05:56'),
(10, 38, NULL, NULL, 'piece', 1.00, 290.00, NULL, 20, 0, NULL, '2026-09-20 07:06:35', '2026-09-20 07:06:35'),
(11, 51, NULL, NULL, 'piece', 1.00, 10000.00, NULL, 10, 0, NULL, '2026-10-31 06:36:19', '2026-10-31 06:36:19'),
(12, 52, NULL, NULL, 'piece', 1.00, 5000.00, NULL, 9, 0, NULL, '2026-10-31 06:39:05', '2026-10-31 06:39:05'),
(13, 53, NULL, NULL, 'piece', 1.00, 3500.00, NULL, 25, 0, NULL, '2026-10-31 06:42:43', '2026-10-31 06:42:43'),
(14, 54, NULL, NULL, 'piece', 1.00, 2500.00, NULL, 47, 0, NULL, '2026-10-31 06:44:35', '2026-10-31 06:44:35'),
(15, 84, NULL, NULL, 'piece', 1.00, 45000.00, NULL, 20, 0, NULL, '2026-11-01 05:49:54', '2026-11-01 05:49:54'),
(16, 185, NULL, NULL, 'piece', 1.00, 499900.00, NULL, 40, 0, NULL, '2026-11-08 09:55:35', '2026-11-08 09:55:35');

-- --------------------------------------------------------

--
-- Table structure for table `product_videos`
--

CREATE TABLE `product_videos` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `video_url` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `resellers`
--

CREATE TABLE `resellers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `business_name` varchar(191) DEFAULT NULL,
  `markup_rate` decimal(5,2) DEFAULT 15.00,
  `status` enum('pending','approved','suspended') DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `resellers`
--

INSERT INTO `resellers` (`id`, `user_id`, `business_name`, `markup_rate`, `status`, `created_at`, `updated_at`) VALUES
(1, 13, 'Reseller Test Account', 0.00, 'approved', '2026-11-10 06:23:52', '2026-11-10 06:23:52');

-- --------------------------------------------------------

--
-- Table structure for table `reseller_customers`
--

CREATE TABLE `reseller_customers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `reseller_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reseller_orders`
--

CREATE TABLE `reseller_orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `reseller_id` bigint(20) UNSIGNED NOT NULL,
  `reseller_customer_id` bigint(20) UNSIGNED NOT NULL,
  `reseller_product_id` bigint(20) UNSIGNED NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `total_price` decimal(12,2) NOT NULL,
  `status` enum('pending','confirmed','delivered','cancelled') DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reseller_prices`
--

CREATE TABLE `reseller_prices` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `reseller_product_id` bigint(20) UNSIGNED NOT NULL,
  `selling_price` decimal(12,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reseller_products`
--

CREATE TABLE `reseller_products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `reseller_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `is_active` tinyint(1) DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` bigint(20) UNSIGNED NOT NULL,
  `order_item_id` bigint(20) UNSIGNED DEFAULT NULL,
  `comment` text DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `rfqs`
--

CREATE TABLE `rfqs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `product_name` varchar(180) NOT NULL,
  `requirements` text NOT NULL,
  `attachments` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`attachments`)),
  `quantity` int(10) UNSIGNED NOT NULL,
  `unit` varchar(40) NOT NULL,
  `share_business_card` tinyint(1) NOT NULL DEFAULT 0,
  `status` varchar(20) NOT NULL DEFAULT 'open',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `rfqs`
--

INSERT INTO `rfqs` (`id`, `user_id`, `product_name`, `requirements`, `attachments`, `quantity`, `unit`, `share_business_card`, `status`, `created_at`, `updated_at`) VALUES
(1, 9, 'Nakaraadsa', 'sdafsdfasfasdsafaaaaaaa', '[\"rfqs\\/Vs8xoXN8kfOldY3vEQyJ3bg4V2pezcExHepn3spR.webp\"]', 210, 'Piece/Pieces', 1, 'open', '2026-11-09 23:46:16', '2026-11-09 23:46:16'),
(2, 9, 'Small Appliances Sample 5', 'sdsafdsafasdfasfsafasfsafsaf', '[\"rfqs\\/YnheCr8xYNp53VoRTb8sOBUBqbr12Wa6f1m0Pc3T.jpg\"]', 20, 'Piece/Pieces', 1, 'open', '2026-11-09 23:57:46', '2026-11-09 23:57:46');

-- --------------------------------------------------------

--
-- Table structure for table `rfq_quotes`
--

CREATE TABLE `rfq_quotes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `rfq_id` bigint(20) UNSIGNED NOT NULL,
  `supplier_id` bigint(20) UNSIGNED NOT NULL,
  `unit_price` decimal(12,2) NOT NULL,
  `lead_time_days` int(10) UNSIGNED DEFAULT NULL,
  `message` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'superadmin', 'web', '2026-09-14 11:49:40', '2026-09-14 11:49:40'),
(2, 'vendor', 'web', '2026-10-24 00:15:29', '2026-10-24 00:15:29'),
(3, 'admin', 'web', '2026-10-24 04:45:13', '2026-10-24 04:45:13'),
(4, 'supplier', 'web', '2026-10-24 04:45:13', '2026-10-24 04:45:13'),
(5, 'affiliate', 'web', '2026-10-24 04:45:13', '2026-10-24 04:45:13'),
(6, 'Testing', 'web', '2026-11-02 22:04:36', '2026-11-02 22:04:36'),
(7, 'reseller', 'web', '2026-11-10 05:10:14', '2026-11-10 05:10:14'),
(8, 'dropshipping', 'web', '2026-11-10 05:10:14', '2026-11-10 05:10:14'),
(9, 'wholesale', 'web', '2026-11-10 05:10:14', '2026-11-10 05:10:14'),
(10, 'customer', 'web', '2026-11-10 05:10:14', '2026-11-10 05:10:14');

-- --------------------------------------------------------

--
-- Table structure for table `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_has_permissions`
--

INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES
(1, 3),
(1, 6),
(2, 3),
(2, 6),
(3, 3),
(3, 6),
(4, 3),
(4, 6),
(5, 3),
(5, 6),
(6, 6),
(7, 6),
(8, 6),
(9, 6),
(10, 6),
(11, 6),
(12, 6),
(13, 6),
(14, 6),
(15, 6),
(16, 6),
(17, 6),
(18, 6),
(19, 6),
(20, 6),
(21, 6),
(22, 6),
(23, 6),
(24, 6),
(25, 6),
(26, 6),
(27, 6),
(28, 6),
(29, 6),
(30, 6),
(31, 6),
(32, 6),
(33, 6),
(34, 6),
(35, 6),
(36, 6),
(37, 6),
(38, 6),
(39, 6),
(40, 6),
(41, 6),
(42, 6),
(43, 6),
(44, 6),
(45, 6),
(46, 6),
(47, 6),
(48, 6),
(49, 6),
(50, 6),
(51, 6),
(52, 6),
(53, 6),
(54, 6),
(55, 6),
(56, 6),
(57, 6),
(58, 6),
(59, 6),
(60, 6),
(61, 6),
(62, 6),
(63, 6),
(64, 6),
(65, 6),
(66, 6),
(67, 6),
(68, 6),
(69, 6),
(70, 6),
(71, 6),
(72, 6),
(73, 6),
(74, 6),
(75, 6),
(76, 6),
(77, 6),
(78, 6),
(79, 6),
(80, 6),
(81, 6),
(82, 6),
(83, 6),
(84, 6),
(85, 6),
(86, 6),
(87, 6),
(88, 6),
(89, 6),
(90, 6),
(91, 6),
(92, 6),
(93, 6),
(97, 6),
(98, 6),
(99, 6),
(100, 6),
(101, 6),
(102, 6),
(103, 6),
(104, 3),
(104, 6),
(105, 3),
(105, 6),
(106, 3),
(106, 6),
(107, 3),
(107, 6),
(108, 3),
(108, 6),
(109, 3),
(109, 6),
(110, 6),
(111, 6),
(112, 6),
(113, 6),
(114, 6),
(115, 6),
(116, 6),
(117, 6),
(118, 6),
(119, 6),
(120, 6),
(121, 6),
(122, 6),
(123, 6),
(124, 6),
(125, 6),
(126, 6),
(127, 6),
(128, 6),
(129, 6),
(130, 6),
(131, 6),
(132, 6),
(133, 6),
(138, 6),
(139, 6),
(140, 6),
(141, 6),
(142, 6),
(143, 6),
(144, 6),
(145, 6),
(146, 6),
(147, 6),
(148, 6),
(149, 6),
(150, 6),
(151, 6),
(152, 6),
(153, 6),
(154, 6),
(155, 6),
(156, 6),
(157, 6),
(158, 6),
(159, 6),
(160, 6),
(161, 6),
(162, 6),
(163, 6),
(164, 6),
(165, 6),
(171, 6),
(172, 6),
(173, 6),
(174, 6),
(175, 6),
(176, 6),
(177, 6),
(178, 6),
(179, 6),
(180, 6),
(181, 6),
(182, 6),
(183, 6),
(184, 6),
(185, 6),
(186, 6),
(187, 6),
(188, 6),
(189, 6),
(190, 6),
(191, 6),
(192, 6),
(193, 6),
(194, 6),
(195, 6),
(196, 6),
(384, 3),
(385, 3),
(386, 3),
(387, 3),
(388, 3),
(389, 3),
(390, 3),
(391, 3),
(392, 3),
(393, 3),
(394, 3),
(395, 3),
(396, 3),
(397, 3),
(398, 3),
(399, 3),
(400, 3),
(401, 3),
(402, 3),
(403, 3),
(404, 3),
(405, 3),
(406, 3),
(407, 3),
(408, 3),
(409, 3),
(410, 3),
(411, 3),
(412, 3),
(413, 3),
(414, 3),
(415, 3),
(571, 3);

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('DjxjbrdJmBMPBQM3LGCEykf9QJcjmfROrgP42lvb', 4, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/156.0.0.0 Safari/537.36', 'YTo2OntzOjY6Il90b2tlbiI7czo0MDoiRHZRVGRPMlJEbE5rZTVLbTNVNnROc1FrZkFXMzlJVnJYdndrMElWbCI7czozOiJ1cmwiO2E6MDp7fXM6OToiX3ByZXZpb3VzIjthOjI6e3M6MzoidXJsIjtzOjUyOiJodHRwOi8vMTI3LjAuMC4xOjgwMDAvYWRtaW4vcHJvZHVjdHMvcHJvZHVjdHM/cGFnZT0yIjtzOjU6InJvdXRlIjtzOjI5OiJhZG1pbi5wcm9kdWN0cy5wcm9kdWN0cy5pbmRleCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6MTU6ImNhcnRfc2Vzc2lvbl9pZCI7czozNjoiYWM4YTA0YzEtZTAyYi00Y2I4LTgwNGEtMjQyNmMwOTU0YWQ1IjtzOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aTo0O30=', 1794307804),
('dwnpSuFV795foZYgNcREK2G8B5kDQTSYItLyKO76', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/156.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiMWJtSjBlYXA5Z2djTGEzVXpURkpFQXhHd0lhZmpSTEV1OGdab1hHciI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJuZXciO2E6MDp7fXM6Mzoib2xkIjthOjA6e319czoxNToiY2FydF9zZXNzaW9uX2lkIjtzOjM2OiJkNDcwOTMwMS00NzNkLTQ3ZmItYWZkNi1lM2E5ZDliMmIwZjUiO3M6OToiX3ByZXZpb3VzIjthOjI6e3M6MzoidXJsIjtzOjMxOiJodHRwOi8vMTI3LjAuMC4xOjgwMDAvY2FydC9taW5pIjtzOjU6InJvdXRlIjtzOjk6ImNhcnQubWluaSI7fX0=', 1794313946),
('IMjjJG41GQ7kn8PoRE3xmLskVExO00m8UCNpMXdg', 12, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/156.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiMnZNSVdsQlRSRGtyRzdpakJCZHZVdkhsaDBpMTZvaVZwcmxxVnh4USI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czoxNToiY2FydF9zZXNzaW9uX2lkIjtzOjM2OiJjYmY5MGI0OC0wODQ5LTRlMjAtOThiMC02NjUyZWEyOWVmNjUiO3M6OToiX3ByZXZpb3VzIjthOjI6e3M6MzoidXJsIjtzOjM3NToiaHR0cDovLzEyNy4wLjAuMTo4MDAwL3Byb2R1Y3Qtc3BlY3M/aWRzPTQ1JTJDNTklMkM2NCUyQzY5JTJDNzQlMkM3OSUyQzg0JTJDNTglMkM2MyUyQzY4JTJDNjIlMkM2MSUyQzYwJTJDMjYwJTJDMjU5JTJDMjU4JTJDMjU3JTJDMjU2JTJDMTg1JTJDMTg0JTJDMTgzJTJDMTgyJTJDMTgxJTJDMTgwJTJDMTc5JTJDMTc4JTJDMTc3JTJDMTc2JTJDMjEyJTJDMjExJTJDMjEwJTJDMjA5JTJDMjA4JTJDMjA3JTJDMjA2JTJDMjA1JTJDMjA0JTJDMTYzJTJDMjM4JTJDMjM3JTJDMjM2JTJDMjM1JTJDMjM0JTJDMjMzJTJDMjMyJTJDMjMxJTJDMjMwJTJDMjI5JTJDMjAzJTJDMjAyJTJDMjAxJTJDODMlMkM4MiUyQzgxJTJDODAlMkM1NyUyQzU2JTJDNTUlMkM0OCUyQzQ3IjtzOjU6InJvdXRlIjtzOjEzOiJwcm9kdWN0LnNwZWNzIjt9czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTI7fQ==', 1794311934),
('oPqe5XEgsGLCdUhWVxznARwbFzlNICACi96zb23K', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/156.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiaFZQa3llUEd0RFk5ZW5KaVlYMkxGR3pKbE15NUhNQktUNThYMk9ZQyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJuZXciO2E6MDp7fXM6Mzoib2xkIjthOjA6e319czoxNToiY2FydF9zZXNzaW9uX2lkIjtzOjM2OiJhODI3NTdhOS0zOGY2LTQ1NWUtOTMxNi1hMjljYmQ1OTk3Y2MiO3M6OToiX3ByZXZpb3VzIjthOjI6e3M6MzoidXJsIjtzOjMxOiJodHRwOi8vMTI3LjAuMC4xOjgwMDAvY2FydC9taW5pIjtzOjU6InJvdXRlIjtzOjk6ImNhcnQubWluaSI7fX0=', 1794313151),
('RsGXUm4kHWmwdz2EEtpKgp4sygAc6fMhoW2cFNdV', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/156.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiYjlVZ3duRENSREZER0dkVm40a1NvV253b0JKeXNUM0wyVlFXYnpiWCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJuZXciO2E6MDp7fXM6Mzoib2xkIjthOjA6e319czoxNToiY2FydF9zZXNzaW9uX2lkIjtzOjM2OiJjODg5NzU0YS00NjVmLTQwOWYtYjQwYi1kYjY3ZTBiMWU0NGYiO3M6OToiX3ByZXZpb3VzIjthOjI6e3M6MzoidXJsIjtzOjgzOiJodHRwOi8vMTI3LjAuMC4xOjgwMDAvc3RvcmFnZS9zZXR0aW5ncy9YNmNJczhnaU5uaG1hRXhOZ2dwRFRieHBQSnhFUnJ2aHhzd1pkUDJSLnBuZyI7czo1OiJyb3V0ZSI7Tjt9fQ==', 1794312967);

-- --------------------------------------------------------

--
-- Table structure for table `shipments`
--

CREATE TABLE `shipments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `courier_id` bigint(20) UNSIGNED DEFAULT NULL,
  `transport_type` varchar(30) NOT NULL DEFAULT 'self',
  `driver_name` varchar(150) DEFAULT NULL,
  `driver_phone` varchar(30) DEFAULT NULL,
  `vehicle_number` varchar(50) DEFAULT NULL,
  `vehicle_owner` varchar(150) DEFAULT NULL,
  `tracking_number` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'pending',
  `shipped_at` timestamp NULL DEFAULT NULL,
  `expected_arrival_at` date DEFAULT NULL,
  `delivered_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `shipping_addresses`
--

CREATE TABLE `shipping_addresses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` bigint(20) UNSIGNED DEFAULT NULL,
  `recipient_name` varchar(255) DEFAULT NULL,
  `phone` varchar(255) NOT NULL,
  `address_line1` varchar(255) NOT NULL,
  `address_line2` varchar(255) DEFAULT NULL,
  `city` varchar(255) NOT NULL,
  `state` varchar(255) DEFAULT NULL,
  `postal_code` varchar(255) DEFAULT NULL,
  `country` varchar(255) NOT NULL DEFAULT 'Bangladesh',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `shipping_addresses`
--

INSERT INTO `shipping_addresses` (`id`, `customer_id`, `recipient_name`, `phone`, `address_line1`, `address_line2`, `city`, `state`, `postal_code`, `country`, `created_at`, `updated_at`) VALUES
(4, NULL, 'jessica 97', '01690068136', 'Wari,Dhaka ,Bangladesh 1100', NULL, 'Dhaka', NULL, '1203', 'Bangladesh', '2026-09-26 12:32:41', '2026-09-26 12:32:41'),
(5, NULL, 'CZIT Web', '01690068136', 'drarad', NULL, 'Cox\'s Bazar', NULL, NULL, 'Bangladesh', '2026-10-23 23:22:10', '2026-10-23 23:22:10'),
(6, 3, 'Johnkru6', '01690068136', 'ddd', 'dsdfsfdsf', 'Brahmanbaria', NULL, NULL, 'Bangladesh', '2026-11-01 23:57:37', '2026-11-01 23:57:37'),
(7, 6, 'Fahim Rahman', '01625557147', 'Abdul majid super market,Navaran ( sarsha more) sarsha, jessore', 'Sodor', 'Jashore', NULL, NULL, 'Bangladesh', '2026-11-09 17:43:23', '2026-11-09 17:43:23'),
(8, 4, 'Bhmyers745', '01690068136', 'sdfsafsdafsafds', 'sdfsfsadfsaf', 'Bhola', NULL, NULL, 'Bangladesh', '2026-11-10 01:25:56', '2026-11-10 01:25:56');

-- --------------------------------------------------------

--
-- Table structure for table `shipping_rates`
--

CREATE TABLE `shipping_rates` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `shipping_zone_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `rate` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `shipping_rates`
--

INSERT INTO `shipping_rates` (`id`, `shipping_zone_id`, `name`, `rate`, `created_at`, `updated_at`) VALUES
(1, 1, 'Dhaka Area', 70.00, '2026-09-26 11:22:43', '2026-09-26 11:22:43'),
(2, 2, 'Outside Area', 170.00, '2026-09-26 11:23:58', '2026-09-26 11:23:58'),
(3, 3, 'Inside Dhaka', 70.00, '2026-09-26 12:18:10', '2026-09-26 12:18:10'),
(4, 4, 'Outside Dhaka', 170.00, '2026-09-26 12:18:10', '2026-09-26 12:18:10'),
(5, 5, 'Inside Dhaka', 70.00, '2026-09-26 12:20:34', '2026-09-26 12:20:34'),
(6, 6, 'Outside Dhaka', 170.00, '2026-09-26 12:20:34', '2026-09-26 12:20:34');

-- --------------------------------------------------------

--
-- Table structure for table `shipping_zones`
--

CREATE TABLE `shipping_zones` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `regions` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`regions`)),
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `shipping_zones`
--

INSERT INTO `shipping_zones` (`id`, `name`, `regions`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Dhaka', '[]', 1, '2026-09-26 11:21:09', '2026-09-26 11:21:09'),
(2, 'Outside Dhaka', '[]', 1, '2026-09-26 11:22:04', '2026-09-26 11:23:35'),
(3, 'Dhaka', '[\"Dhaka\"]', 1, '2026-09-26 12:18:09', '2026-09-26 12:18:09'),
(4, 'Outside Dhaka', '[\"OTHERS\"]', 1, '2026-09-26 12:18:10', '2026-09-26 12:18:10'),
(5, 'Dhaka', '[\"Dhaka\"]', 1, '2026-09-26 12:20:34', '2026-09-26 12:20:34'),
(6, 'Outside Dhaka', '[\"OTHERS\"]', 1, '2026-09-26 12:20:34', '2026-09-26 12:20:34');

-- --------------------------------------------------------

--
-- Table structure for table `sliders`
--

CREATE TABLE `sliders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `link` varchar(255) DEFAULT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `stock_movements`
--

CREATE TABLE `stock_movements` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `variant_id` bigint(20) UNSIGNED DEFAULT NULL,
  `type` enum('in','out','adjustment') NOT NULL,
  `quantity` int(11) NOT NULL,
  `reason` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `suppliers`
--

CREATE TABLE `suppliers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `company_name` varchar(191) NOT NULL,
  `company_slug` varchar(191) NOT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `is_verified` tinyint(1) DEFAULT 0,
  `status` enum('pending','approved','suspended') DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `suppliers`
--

INSERT INTO `suppliers` (`id`, `user_id`, `company_name`, `company_slug`, `logo`, `description`, `is_verified`, `status`, `created_at`, `updated_at`) VALUES
(1, 5, 'Supplier Test Account', 'supplier-test-account', NULL, NULL, 1, 'approved', '2026-11-10 06:23:51', '2026-11-10 06:23:51');

-- --------------------------------------------------------

--
-- Table structure for table `supplier_inventory`
--

CREATE TABLE `supplier_inventory` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `supplier_product_id` bigint(20) UNSIGNED NOT NULL,
  `warehouse_id` bigint(20) UNSIGNED DEFAULT NULL,
  `quantity` int(11) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `supplier_pricing`
--

CREATE TABLE `supplier_pricing` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `supplier_product_id` bigint(20) UNSIGNED NOT NULL,
  `min_quantity` int(11) NOT NULL DEFAULT 1,
  `max_quantity` int(11) DEFAULT NULL,
  `unit_price` decimal(12,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `supplier_products`
--

CREATE TABLE `supplier_products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `supplier_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `sku` varchar(100) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `base_price` decimal(12,2) NOT NULL DEFAULT 0.00,
  `moq` int(11) DEFAULT 1,
  `status` enum('pending','approved','rejected') DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `supplier_product_variants`
--

CREATE TABLE `supplier_product_variants` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `supplier_product_id` bigint(20) UNSIGNED NOT NULL,
  `variant_name` varchar(191) DEFAULT NULL,
  `price` decimal(12,2) NOT NULL DEFAULT 0.00,
  `stock_quantity` int(11) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `supplier_warehouses`
--

CREATE TABLE `supplier_warehouses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `supplier_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `address` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tags`
--

CREATE TABLE `tags` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `slug` varchar(100) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tracking_events`
--

CREATE TABLE `tracking_events` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `shipment_id` bigint(20) UNSIGNED NOT NULL,
  `status` varchar(255) NOT NULL,
  `location` varchar(255) DEFAULT NULL,
  `event_time` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `units`
--

CREATE TABLE `units` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `short_code` varchar(20) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `units`
--

INSERT INTO `units` (`id`, `name`, `short_code`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Piece', 'pc', 1, '2026-09-16 17:30:18', '2026-09-16 17:30:18'),
(2, 'Kilogram', 'kg', 1, '2026-09-16 17:30:18', '2026-09-16 17:30:18'),
(3, 'Gram', 'g', 1, '2026-09-16 17:30:18', '2026-09-16 17:30:18'),
(4, 'Litre', 'ltr', 1, '2026-09-16 17:30:18', '2026-09-16 17:30:18'),
(5, 'Millilitre', 'ml', 1, '2026-09-16 17:30:18', '2026-09-16 17:30:18'),
(6, 'Dozen', 'dz', 1, '2026-09-16 17:30:18', '2026-09-16 17:30:18'),
(7, 'Box', 'box', 1, '2026-09-16 17:30:18', '2026-09-16 17:30:18'),
(8, 'Meter', 'm', 1, '2026-09-16 17:30:18', '2026-09-16 17:30:18'),
(9, 'Piece', 'pc', 1, '2026-09-16 17:33:16', '2026-09-16 17:33:16'),
(10, 'Kilogram', 'kg', 1, '2026-09-16 17:33:16', '2026-09-16 17:33:16'),
(11, 'Gram', 'g', 1, '2026-09-16 17:33:16', '2026-09-16 17:33:16'),
(12, 'Litre', 'ltr', 1, '2026-09-16 17:33:16', '2026-09-16 17:33:16'),
(13, 'Millilitre', 'ml', 1, '2026-09-16 17:33:16', '2026-09-16 17:33:16'),
(14, 'Dozen', 'dz', 1, '2026-09-16 17:33:16', '2026-09-16 17:33:16'),
(15, 'Box', 'box', 1, '2026-09-16 17:33:16', '2026-09-16 17:33:16'),
(16, 'Meter', 'm', 1, '2026-09-16 17:33:16', '2026-09-16 17:33:16');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `two_factor_secret` text DEFAULT NULL,
  `two_factor_recovery_codes` text DEFAULT NULL,
  `two_factor_confirmed_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `current_team_id` bigint(20) UNSIGNED DEFAULT NULL,
  `profile_photo_path` varchar(2048) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `password_set_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `phone`, `avatar`, `status`, `email_verified_at`, `password`, `two_factor_secret`, `two_factor_recovery_codes`, `two_factor_confirmed_at`, `remember_token`, `current_team_id`, `profile_photo_path`, `created_at`, `updated_at`, `password_set_at`) VALUES
(1, 'admin', 'admin@gmail.com', NULL, 'users/MeAY89YEtrsKaVPNUE8bhyCkXevuBtIRvmzk9ul3.jpg', 1, '2026-11-10 02:16:44', '$2y$12$nps9o2V5N.vcEcumY7M5xOtCDt5JMjuZS/5pPyB7F1XUFBLiWy062', NULL, NULL, NULL, NULL, NULL, NULL, '2026-09-11 22:01:25', '2026-11-10 02:16:44', NULL),
(2, 'Orpita', 'orpita@gmail.com', NULL, 'users/Ou4eKIBTtiyhnYWd1bydS9EgB8PU9vc3f2Mo8OTI.jpg', 1, NULL, '$2y$12$BL7JxC3rWcDucMisUd4o0OBS4gdCOLMvC6uG4FAVAfdxk5jhiy17q', NULL, NULL, NULL, NULL, NULL, NULL, '2026-09-13 12:45:09', '2026-11-02 22:05:37', NULL),
(3, 'Test Vendor', 'vendor@gmail.com', NULL, NULL, 1, '2026-11-10 06:23:51', '$2y$12$1l1RNhmWpZgdoUeTsoUxGuhKMvqfH0eupzmcw9wR0fpcwWmS2e47S', NULL, NULL, NULL, NULL, NULL, NULL, '2026-10-24 00:15:42', '2026-11-10 06:23:51', NULL),
(4, 'Admin', 'admin@test.com', NULL, NULL, 1, '2026-11-10 06:23:50', '$2y$12$RMaTCa3fJEPwTfxrTVlmPeqtmhL3E99cKMIfMePCG8G5tGr99VffG', NULL, NULL, NULL, NULL, NULL, NULL, '2026-10-24 04:45:22', '2026-11-10 06:23:50', NULL),
(5, 'Test Supplier', 'supplier@test.com', NULL, NULL, 1, '2026-11-10 06:23:51', '$2y$12$CKfU/K1jQGW7GBC35oBJYOlnQJWET6d0ZChnmV2rtrwPED5AgglLy', NULL, NULL, NULL, NULL, NULL, NULL, '2026-10-24 04:45:22', '2026-11-10 06:23:51', NULL),
(6, 'Test Affiliate', 'affiliate@test.com', NULL, NULL, 1, '2026-11-10 06:23:51', '$2y$12$tLuHkcBD5j9OljTT3B7mue2Msaih2uIQx.OTQA0VWK5.UjlTQ2E1i', NULL, NULL, NULL, NULL, NULL, NULL, '2026-10-24 04:45:22', '2026-11-10 06:23:51', NULL),
(7, 'Anik Czit', 'anik.czit@gmail.com', NULL, NULL, 1, '2026-11-01 23:27:52', '$2y$12$tb5nRqRexwt/SL4rVPfJ1utVrkrJgW4ItYWeWOc4y83Z0JWYEQLJe', NULL, NULL, NULL, 'zmkLalQBc5H0GqgNracXoZg4fIpK8PNSW545JR5tc6SpHNKOyzEsbHyKlJns', NULL, NULL, '2026-11-01 23:27:52', '2026-11-01 23:27:52', NULL),
(8, 'Johnkru6', 'johnkru6@gmail.com', '01617763027', NULL, 1, '2026-11-01 23:47:22', '$2y$12$OZR2a1/xoNhqgRGyVGtzPOWCkviVlEVuCszdzRCPA4OVXoV0mUN3W', NULL, NULL, NULL, 'cWPOZQCSy5FCTZTTnpyK5HfYwwkTg1jq1H8nsxDYabtkkgtZb2q8GoHtsdEH', NULL, NULL, '2026-11-01 23:47:22', '2026-11-09 17:09:52', NULL),
(9, 'Bhmyers745', 'bhmyers745@gmail.com', '01690068136', NULL, 1, '2026-11-03 23:44:40', '$2y$12$sGeR6bibdj3DSsoR57iK.OO7BEK.7EaFfFrYqy8BJ6JuxQE2UJVY.', NULL, NULL, NULL, '9ciVb9f0DH2JHocCOUBN6qih6bRRLFwq5YGn1y5JSfgm5LQ4VWRjB8BwJlAY', NULL, NULL, '2026-11-03 23:44:41', '2026-11-04 04:34:43', '2026-11-04 04:34:43'),
(10, 'Fahim Rahman', 'abdullahfahim.evaly@gmail.com', NULL, NULL, 1, NULL, '$2y$12$zKFhaFS2cpMsH43y.hQiVexDQSJYByOpMhfew1zWeViKju4U.JSYC', NULL, NULL, NULL, NULL, NULL, NULL, '2026-11-09 17:39:42', '2026-11-09 17:39:42', NULL),
(11, 'Director Czit', 'director.czit@gmail.com', '01711843742', NULL, 1, '2026-11-09 18:06:31', '$2y$12$Yat5syggxJti4H/5vqBNFObygH1/JuGv.9rC8xUrFHFNoY3NAzvg2', NULL, NULL, NULL, 'pxMPOX4qB4NqmqvXee1tt1GMSDERhmkl5W20ZXG7O0QwUNItNiqNWgj646tz', NULL, NULL, '2026-11-09 18:06:31', '2026-11-09 18:06:31', NULL),
(12, 'ewewe', 'dddddd1123@gmail.com', NULL, NULL, 1, NULL, '$2y$12$Pg4dBMXps6nZMjdCdYaDlOfWuCgOuv9kyok6Vt.O5HeEdlQ1Gbrpe', NULL, NULL, NULL, NULL, NULL, NULL, '2026-11-10 04:52:07', '2026-11-10 04:52:07', NULL),
(13, 'Reseller Test Account', 'reseller@gmail.com', NULL, NULL, 1, '2026-11-10 06:23:52', '$2y$12$D/Q4mVAMtZMd1vznzpylQOL/B.lmH0RohEWZp/qj7sLTd2aWAKJfe', NULL, NULL, NULL, NULL, NULL, NULL, '2026-11-10 06:23:52', '2026-11-10 06:23:52', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `vendors`
--

CREATE TABLE `vendors` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL DEFAULT '',
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `shop_name` varchar(191) NOT NULL,
  `shop_slug` varchar(191) NOT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `banner` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `commission_rate` decimal(5,2) DEFAULT 10.00,
  `is_verified` tinyint(1) DEFAULT 0,
  `status` enum('pending','approved','suspended') DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `verification_status` enum('pending','verified','rejected') NOT NULL DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `vendors`
--

INSERT INTO `vendors` (`id`, `name`, `user_id`, `shop_name`, `shop_slug`, `logo`, `banner`, `description`, `commission_rate`, `is_verified`, `status`, `created_at`, `updated_at`, `verification_status`) VALUES
(1, '', 1, 'cte', 'cte', 'vendors/logos/bCLBuPYtXPeObnHB3P2eYdCvKRZ987eCjbUtqL35.png', 'vendors/banners/SepKNOo4HZzqGI6CFL6LoB1r6UB5n9dDm7Awlpn6.png', 'sdfasf', 10.00, 1, 'approved', '2026-09-19 13:17:30', '2026-10-24 04:14:47', 'pending'),
(2, 'Test Vendor', 3, 'Test Shop', 'test-shop', NULL, NULL, NULL, 10.00, 1, 'approved', '2026-10-24 04:17:35', '2026-11-10 06:23:51', 'pending');

-- --------------------------------------------------------

--
-- Table structure for table `vendor_orders`
--

CREATE TABLE `vendor_orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `vendor_id` bigint(20) UNSIGNED NOT NULL,
  `subtotal` decimal(10,2) NOT NULL DEFAULT 0.00,
  `commission_amount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `status` varchar(255) NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `vendor_orders`
--

INSERT INTO `vendor_orders` (`id`, `order_id`, `vendor_id`, `subtotal`, `commission_amount`, `status`, `created_at`, `updated_at`) VALUES
(2, 4, 1, 65000.00, 0.00, 'pending', '2026-09-26 12:32:41', '2026-09-26 12:32:41'),
(3, 6, 1, 102500.00, 0.00, 'pending', '2026-11-01 23:58:09', '2026-11-01 23:58:09'),
(4, 8, 1, 105000.00, 0.00, 'pending', '2026-11-10 03:36:35', '2026-11-10 03:36:35');

-- --------------------------------------------------------

--
-- Table structure for table `warehouses`
--

CREATE TABLE `warehouses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `address` varchar(255) DEFAULT NULL,
  `city` varchar(100) DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `warehouse_products`
--

CREATE TABLE `warehouse_products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `warehouse_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `quantity` int(11) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `warranty_registrations`
--

CREATE TABLE `warranty_registrations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `serial_number` varchar(60) NOT NULL,
  `product_name` varchar(255) DEFAULT NULL,
  `customer_name` varchar(255) DEFAULT NULL,
  `phone` varchar(30) DEFAULT NULL,
  `purchase_date` date NOT NULL,
  `warranty_months` smallint(5) UNSIGNED NOT NULL DEFAULT 12,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `website_settings`
--

CREATE TABLE `website_settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `site_name` varchar(255) DEFAULT NULL,
  `tagline` varchar(255) DEFAULT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `logo_dark` varchar(255) DEFAULT NULL,
  `favicon` varchar(255) DEFAULT NULL,
  `footer_about` text DEFAULT NULL,
  `copyright_text` varchar(255) DEFAULT NULL,
  `phone_1` varchar(255) DEFAULT NULL,
  `phone_2` varchar(255) DEFAULT NULL,
  `phone_3` varchar(255) DEFAULT NULL,
  `phone_4` varchar(255) DEFAULT NULL,
  `whatsapp_number` varchar(255) DEFAULT NULL,
  `messenger_link` varchar(255) DEFAULT NULL,
  `email_1` varchar(255) DEFAULT NULL,
  `email_2` varchar(255) DEFAULT NULL,
  `email_3` varchar(255) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `google_map_1` text DEFAULT NULL,
  `google_map_2` text DEFAULT NULL,
  `facebook_url` varchar(255) DEFAULT NULL,
  `instagram_url` varchar(255) DEFAULT NULL,
  `twitter_url` varchar(255) DEFAULT NULL,
  `youtube_url` varchar(255) DEFAULT NULL,
  `linkedin_url` varchar(255) DEFAULT NULL,
  `tiktok_url` varchar(255) DEFAULT NULL,
  `pinterest_url` varchar(255) DEFAULT NULL,
  `meta_title` varchar(255) DEFAULT NULL,
  `meta_description` text DEFAULT NULL,
  `meta_keywords` text DEFAULT NULL,
  `og_image` varchar(255) DEFAULT NULL,
  `google_analytics_id` varchar(255) DEFAULT NULL,
  `google_tag_manager_id` varchar(255) DEFAULT NULL,
  `facebook_pixel_id` varchar(255) DEFAULT NULL,
  `tiktok_pixel_id` varchar(255) DEFAULT NULL,
  `recaptcha_site_key` varchar(255) DEFAULT NULL,
  `recaptcha_secret_key` varchar(255) DEFAULT NULL,
  `currency_code` varchar(255) NOT NULL DEFAULT 'BDT',
  `currency_symbol` varchar(255) NOT NULL DEFAULT '৳',
  `free_shipping_min_amount` decimal(10,2) DEFAULT NULL,
  `cod_enabled` tinyint(1) NOT NULL DEFAULT 1,
  `maintenance_mode` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `website_settings`
--

INSERT INTO `website_settings` (`id`, `site_name`, `tagline`, `logo`, `logo_dark`, `favicon`, `footer_about`, `copyright_text`, `phone_1`, `phone_2`, `phone_3`, `phone_4`, `whatsapp_number`, `messenger_link`, `email_1`, `email_2`, `email_3`, `address`, `google_map_1`, `google_map_2`, `facebook_url`, `instagram_url`, `twitter_url`, `youtube_url`, `linkedin_url`, `tiktok_url`, `pinterest_url`, `meta_title`, `meta_description`, `meta_keywords`, `og_image`, `google_analytics_id`, `google_tag_manager_id`, `facebook_pixel_id`, `tiktok_pixel_id`, `recaptcha_site_key`, `recaptcha_secret_key`, `currency_code`, `currency_symbol`, `free_shipping_min_amount`, `cod_enabled`, `maintenance_mode`, `created_at`, `updated_at`) VALUES
(1, 'Buydor', NULL, 'settings/X6cIs8giNnhmaExNggpDTbxpPJxERrvhxswZdP2R.png', 'settings/UAo3hFsYf4LDpknpGJhQ4XWrbTe38pClldOtnliX.png', 'settings/Hdb0K8STwAE8xZk2H7qHmi9OVdT7f3KU6m8AKR3c.png', 'Welcome to Buydor, your trusted destination for top-tier electronics. We are committed to redefining your shopping experience by offering an unmatched selection of authentic domestic and international brands. Driven by a passion for quality and innovation, our core mission is to ensure absolute customer satisfaction at every step. At Buydor, we don\'t just sell electronics—we build lasting relationships through reliability, excellence, and exceptional service.', NULL, '01617763027', '01690068136', NULL, NULL, '01690068136', 'https://www.facebook.com/messages/t/369197663153268', 'sellymore678@gmail.com', 'anik.czit@gmail.com', 'anik.czit@gmail.com', 'Wari,Dhaka ,Bangladesh 1100', '<iframe src=\"https://www.google.com/maps/embed?pb=!1m12!1m8!1m3!1d116889.04906420516!2d90.3919888!3d23.7194498!3m2!1i1024!2i768!4f13.1!2m1!1screativezoneit!5e0!3m2!1sen!2sbd!4v1790915990653!5m2!1sen!2sbd\" width=\"600\" height=\"450\" style=\"border:0;\" allowfullscreen=\"\" loading=\"lazy\" referrerpolicy=\"strict-origin-when-cross-origin\"></iframe>', 'https://maps.app.goo.gl/a6QaNcR9WRV6mjPj7', 'https://www.facebook.com/CreativeZoneIT', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'BDT', '৳', NULL, 0, 0, '2026-09-18 09:03:17', '2026-11-05 18:15:41');

-- --------------------------------------------------------

--
-- Table structure for table `wholesalers`
--

CREATE TABLE `wholesalers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `business_name` varchar(150) NOT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `wholesale_prices`
--

CREATE TABLE `wholesale_prices` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `wholesale_tier_id` bigint(20) UNSIGNED NOT NULL,
  `unit_price` decimal(12,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `wholesale_products`
--

CREATE TABLE `wholesale_products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `wholesaler_id` bigint(20) UNSIGNED DEFAULT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `is_wholesale_enabled` tinyint(1) DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `wholesale_tiers`
--

CREATE TABLE `wholesale_tiers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `wholesale_product_id` bigint(20) UNSIGNED NOT NULL,
  `min_quantity` int(11) NOT NULL,
  `max_quantity` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `wishlists`
--

CREATE TABLE `wishlists` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `wishlists`
--

INSERT INTO `wishlists` (`id`, `customer_id`, `created_at`, `updated_at`) VALUES
(2, 1, '2026-10-21 05:49:36', '2026-10-21 05:49:36'),
(3, 3, '2026-11-02 01:06:22', '2026-11-02 01:06:22'),
(4, 5, '2026-11-09 17:11:00', '2026-11-09 17:11:00'),
(5, 4, '2026-11-10 00:29:30', '2026-11-10 00:29:30');

-- --------------------------------------------------------

--
-- Table structure for table `wishlist_items`
--

CREATE TABLE `wishlist_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `wishlist_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `withdrawals`
--

CREATE TABLE `withdrawals` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `withdrawable_type` varchar(255) NOT NULL,
  `withdrawable_id` bigint(20) UNSIGNED NOT NULL,
  `amount` decimal(12,2) NOT NULL,
  `method` varchar(255) DEFAULT NULL,
  `account_details` text DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'pending',
  `note` text DEFAULT NULL,
  `processed_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `affiliates`
--
ALTER TABLE `affiliates`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `referral_code` (`referral_code`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `affiliate_clicks`
--
ALTER TABLE `affiliate_clicks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `affiliate_clicks_affiliate_link_id_foreign` (`affiliate_link_id`);

--
-- Indexes for table `affiliate_links`
--
ALTER TABLE `affiliate_links`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `affiliate_links_code_unique` (`code`),
  ADD KEY `affiliate_links_affiliate_id_foreign` (`affiliate_id`),
  ADD KEY `affiliate_links_product_id_foreign` (`product_id`);

--
-- Indexes for table `affiliate_sales`
--
ALTER TABLE `affiliate_sales`
  ADD PRIMARY KEY (`id`),
  ADD KEY `affiliate_sales_order_id_index` (`order_id`),
  ADD KEY `affiliate_sales_affiliate_id_foreign` (`affiliate_id`),
  ADD KEY `affiliate_sales_affiliate_link_id_foreign` (`affiliate_link_id`);

--
-- Indexes for table `attributes`
--
ALTER TABLE `attributes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `attribute_values`
--
ALTER TABLE `attribute_values`
  ADD PRIMARY KEY (`id`),
  ADD KEY `attribute_id` (`attribute_id`);

--
-- Indexes for table `banners`
--
ALTER TABLE `banners`
  ADD PRIMARY KEY (`id`),
  ADD KEY `banners_position_index` (`position`),
  ADD KEY `banners_status_index` (`status`);

--
-- Indexes for table `brands`
--
ALTER TABLE `brands`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Indexes for table `bulk_orders`
--
ALTER TABLE `bulk_orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `customer_id` (`customer_id`),
  ADD KEY `wholesale_product_id` (`wholesale_product_id`),
  ADD KEY `wholesaler_order_status_index` (`wholesaler_id`,`status`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_expiration_index` (`expiration`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_locks_expiration_index` (`expiration`);

--
-- Indexes for table `carts`
--
ALTER TABLE `carts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `customer_id` (`customer_id`);

--
-- Indexes for table `cart_items`
--
ALTER TABLE `cart_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cart_id` (`cart_id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `variant_id` (`variant_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`),
  ADD KEY `parent_id` (`parent_id`);

--
-- Indexes for table `commissions`
--
ALTER TABLE `commissions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `commissions_order_item_id_index` (`order_item_id`),
  ADD KEY `commissions_vendor_id_foreign` (`vendor_id`),
  ADD KEY `commissions_affiliate_id_foreign` (`affiliate_id`);

--
-- Indexes for table `commission_rules`
--
ALTER TABLE `commission_rules`
  ADD PRIMARY KEY (`id`),
  ADD KEY `commission_rules_category_id_foreign` (`category_id`),
  ADD KEY `commission_rules_vendor_id_foreign` (`vendor_id`);

--
-- Indexes for table `compare_lists`
--
ALTER TABLE `compare_lists`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_compare_user` (`user_id`),
  ADD KEY `fk_compare_product` (`product_id`);

--
-- Indexes for table `contact_messages`
--
ALTER TABLE `contact_messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `coupons`
--
ALTER TABLE `coupons`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `code` (`code`);

--
-- Indexes for table `coupon_products`
--
ALTER TABLE `coupon_products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_coupon_products_coupon` (`coupon_id`),
  ADD KEY `fk_coupon_products_product` (`product_id`);

--
-- Indexes for table `coupon_usages`
--
ALTER TABLE `coupon_usages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `coupon_usages_coupon_id_foreign` (`coupon_id`),
  ADD KEY `coupon_usages_customer_id_foreign` (`customer_id`),
  ADD KEY `coupon_usages_order_id_foreign` (`order_id`);

--
-- Indexes for table `couriers`
--
ALTER TABLE `couriers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `dropshippers`
--
ALTER TABLE `dropshippers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `dropshippers_user_id_unique` (`user_id`),
  ADD KEY `dropshippers_status_index` (`status`);

--
-- Indexes for table `dropshipper_orders`
--
ALTER TABLE `dropshipper_orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `dropshipper_orders_source_order_id_foreign` (`source_order_id`),
  ADD KEY `dropshipper_orders_supplier_id_foreign` (`supplier_id`),
  ADD KEY `dropshipper_order_status_index` (`dropshipper_id`,`status`),
  ADD KEY `dropshipper_orders_customer_id_foreign` (`customer_id`);

--
-- Indexes for table `dropshipper_order_items`
--
ALTER TABLE `dropshipper_order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `dropshipper_order_items_supplier_product_id_foreign` (`supplier_product_id`),
  ADD KEY `dropship_order_item_product_index` (`dropshipper_order_id`,`supplier_product_id`);

--
-- Indexes for table `dropshipper_products`
--
ALTER TABLE `dropshipper_products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `dropshipper_supplier_product_unique` (`dropshipper_id`,`supplier_product_id`),
  ADD KEY `dropshipper_products_supplier_product_id_foreign` (`supplier_product_id`),
  ADD KEY `dropshipper_product_active_index` (`dropshipper_id`,`is_active`);

--
-- Indexes for table `dropshipping_fulfillments`
--
ALTER TABLE `dropshipping_fulfillments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `dropshipping_order_id` (`dropshipping_order_id`);

--
-- Indexes for table `dropshipping_orders`
--
ALTER TABLE `dropshipping_orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `vendor_id` (`vendor_id`),
  ADD KEY `supplier_id` (`supplier_id`);

--
-- Indexes for table `dropshipping_order_items`
--
ALTER TABLE `dropshipping_order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `dropshipping_order_id` (`dropshipping_order_id`),
  ADD KEY `supplier_product_id` (`supplier_product_id`);

--
-- Indexes for table `dropshipping_products`
--
ALTER TABLE `dropshipping_products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `vendor_id` (`vendor_id`),
  ADD KEY `supplier_product_id` (`supplier_product_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `dropshipping_settings`
--
ALTER TABLE `dropshipping_settings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `vendor_id` (`vendor_id`);

--
-- Indexes for table `dropshipping_shipments`
--
ALTER TABLE `dropshipping_shipments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `dropshipping_order_id` (`dropshipping_order_id`);

--
-- Indexes for table `email_otps`
--
ALTER TABLE `email_otps`
  ADD PRIMARY KEY (`id`),
  ADD KEY `email_otps_email_index` (`email`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `inventory`
--
ALTER TABLE `inventory`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `variant_id` (`variant_id`),
  ADD KEY `warehouse_id` (`warehouse_id`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `minimum_order_quantities`
--
ALTER TABLE `minimum_order_quantities`
  ADD PRIMARY KEY (`id`),
  ADD KEY `wholesale_product_id` (`wholesale_product_id`);

--
-- Indexes for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  ADD KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  ADD KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `order_number` (`order_number`),
  ADD KEY `customer_id` (`customer_id`),
  ADD KEY `affiliate_id` (`affiliate_id`),
  ADD KEY `orders_shipping_zone_id_foreign` (`shipping_zone_id`),
  ADD KEY `orders_source_index` (`source`),
  ADD KEY `orders_created_by_foreign` (`created_by`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `variant_id` (`variant_id`),
  ADD KEY `vendor_id` (`vendor_id`);

--
-- Indexes for table `order_notes`
--
ALTER TABLE `order_notes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_notes_order_id_foreign` (`order_id`),
  ADD KEY `order_notes_created_by_foreign` (`created_by`);

--
-- Indexes for table `order_statuses`
--
ALTER TABLE `order_statuses`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Indexes for table `passkeys`
--
ALTER TABLE `passkeys`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `passkeys_credential_id_unique` (`credential_id`),
  ADD KEY `passkeys_user_id_index` (`user_id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payment_deposit_details`
--
ALTER TABLE `payment_deposit_details`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `payment_deposit_details_payment_id_unique` (`payment_id`),
  ADD KEY `payment_deposit_details_order_id_foreign` (`order_id`);

--
-- Indexes for table `payment_methods`
--
ALTER TABLE `payment_methods`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `payment_methods_slug_unique` (`slug`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`),
  ADD KEY `permissions_group_name_index` (`group_name`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`),
  ADD KEY `personal_access_tokens_expires_at_index` (`expires_at`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`),
  ADD UNIQUE KEY `sku` (`sku`),
  ADD KEY `vendor_id` (`vendor_id`),
  ADD KEY `category_id` (`category_id`),
  ADD KEY `brand_id` (`brand_id`);

--
-- Indexes for table `product_attributes`
--
ALTER TABLE `product_attributes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_attributes_product_id_foreign` (`product_id`),
  ADD KEY `product_attributes_attribute_id_foreign` (`attribute_id`),
  ADD KEY `product_attributes_attribute_value_id_foreign` (`attribute_value_id`);

--
-- Indexes for table `product_images`
--
ALTER TABLE `product_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `product_imports`
--
ALTER TABLE `product_imports`
  ADD PRIMARY KEY (`id`),
  ADD KEY `vendor_id` (`vendor_id`),
  ADD KEY `supplier_product_id` (`supplier_product_id`);

--
-- Indexes for table `product_offer_images`
--
ALTER TABLE `product_offer_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_offer_images_product_id_foreign` (`product_id`);

--
-- Indexes for table `product_specifications`
--
ALTER TABLE `product_specifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_specifications_product_id_foreign` (`product_id`);

--
-- Indexes for table `product_syncs`
--
ALTER TABLE `product_syncs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `dropshipping_product_id` (`dropshipping_product_id`);

--
-- Indexes for table `product_variants`
--
ALTER TABLE `product_variants`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `product_videos`
--
ALTER TABLE `product_videos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `resellers`
--
ALTER TABLE `resellers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `reseller_customers`
--
ALTER TABLE `reseller_customers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `reseller_id` (`reseller_id`);

--
-- Indexes for table `reseller_orders`
--
ALTER TABLE `reseller_orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `reseller_id` (`reseller_id`),
  ADD KEY `reseller_customer_id` (`reseller_customer_id`),
  ADD KEY `reseller_product_id` (`reseller_product_id`);

--
-- Indexes for table `reseller_prices`
--
ALTER TABLE `reseller_prices`
  ADD PRIMARY KEY (`id`),
  ADD KEY `reseller_product_id` (`reseller_product_id`);

--
-- Indexes for table `reseller_products`
--
ALTER TABLE `reseller_products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `reseller_id` (`reseller_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `reviews_product_id_index` (`product_id`),
  ADD KEY `reviews_customer_id_index` (`customer_id`),
  ADD KEY `reviews_order_item_id_index` (`order_item_id`);

--
-- Indexes for table `rfqs`
--
ALTER TABLE `rfqs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `rfqs_user_id_foreign` (`user_id`),
  ADD KEY `rfqs_status_index` (`status`);

--
-- Indexes for table `rfq_quotes`
--
ALTER TABLE `rfq_quotes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `rfq_quotes_rfq_id_supplier_id_unique` (`rfq_id`,`supplier_id`),
  ADD KEY `rfq_quotes_supplier_id_foreign` (`supplier_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `shipments`
--
ALTER TABLE `shipments`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `shipments_tracking_number_unique` (`tracking_number`),
  ADD KEY `shipments_order_id_index` (`order_id`),
  ADD KEY `shipments_courier_id_index` (`courier_id`);

--
-- Indexes for table `shipping_addresses`
--
ALTER TABLE `shipping_addresses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `shipping_addresses_customer_id_foreign` (`customer_id`);

--
-- Indexes for table `shipping_rates`
--
ALTER TABLE `shipping_rates`
  ADD PRIMARY KEY (`id`),
  ADD KEY `shipping_rates_shipping_zone_id_foreign` (`shipping_zone_id`);

--
-- Indexes for table `shipping_zones`
--
ALTER TABLE `shipping_zones`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sliders`
--
ALTER TABLE `sliders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sliders_sort_order_index` (`sort_order`),
  ADD KEY `sliders_status_index` (`status`);

--
-- Indexes for table `stock_movements`
--
ALTER TABLE `stock_movements`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `variant_id` (`variant_id`);

--
-- Indexes for table `suppliers`
--
ALTER TABLE `suppliers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `company_slug` (`company_slug`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `supplier_inventory`
--
ALTER TABLE `supplier_inventory`
  ADD PRIMARY KEY (`id`),
  ADD KEY `supplier_product_id` (`supplier_product_id`),
  ADD KEY `warehouse_id` (`warehouse_id`);

--
-- Indexes for table `supplier_pricing`
--
ALTER TABLE `supplier_pricing`
  ADD PRIMARY KEY (`id`),
  ADD KEY `supplier_product_id` (`supplier_product_id`);

--
-- Indexes for table `supplier_products`
--
ALTER TABLE `supplier_products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `supplier_id` (`supplier_id`);

--
-- Indexes for table `supplier_product_variants`
--
ALTER TABLE `supplier_product_variants`
  ADD PRIMARY KEY (`id`),
  ADD KEY `supplier_product_id` (`supplier_product_id`);

--
-- Indexes for table `supplier_warehouses`
--
ALTER TABLE `supplier_warehouses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `supplier_id` (`supplier_id`);

--
-- Indexes for table `tags`
--
ALTER TABLE `tags`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Indexes for table `tracking_events`
--
ALTER TABLE `tracking_events`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tracking_events_shipment_id_index` (`shipment_id`);

--
-- Indexes for table `units`
--
ALTER TABLE `units`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `vendors`
--
ALTER TABLE `vendors`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `shop_slug` (`shop_slug`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `vendor_orders`
--
ALTER TABLE `vendor_orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `warehouses`
--
ALTER TABLE `warehouses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `warehouse_products`
--
ALTER TABLE `warehouse_products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `warehouse_id` (`warehouse_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `warranty_registrations`
--
ALTER TABLE `warranty_registrations`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `warranty_registrations_serial_number_unique` (`serial_number`);

--
-- Indexes for table `website_settings`
--
ALTER TABLE `website_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `wholesalers`
--
ALTER TABLE `wholesalers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `wholesalers_user_id_unique` (`user_id`),
  ADD KEY `wholesalers_status_index` (`status`);

--
-- Indexes for table `wholesale_prices`
--
ALTER TABLE `wholesale_prices`
  ADD PRIMARY KEY (`id`),
  ADD KEY `wholesale_tier_id` (`wholesale_tier_id`);

--
-- Indexes for table `wholesale_products`
--
ALTER TABLE `wholesale_products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `wholesaler_product_enabled_index` (`wholesaler_id`,`is_wholesale_enabled`);

--
-- Indexes for table `wholesale_tiers`
--
ALTER TABLE `wholesale_tiers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `wholesale_product_id` (`wholesale_product_id`);

--
-- Indexes for table `wishlists`
--
ALTER TABLE `wishlists`
  ADD PRIMARY KEY (`id`),
  ADD KEY `customer_id` (`customer_id`);

--
-- Indexes for table `wishlist_items`
--
ALTER TABLE `wishlist_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `wishlist_id` (`wishlist_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `withdrawals`
--
ALTER TABLE `withdrawals`
  ADD PRIMARY KEY (`id`),
  ADD KEY `withdrawals_withdrawable_type_withdrawable_id_index` (`withdrawable_type`,`withdrawable_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `affiliates`
--
ALTER TABLE `affiliates`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `affiliate_clicks`
--
ALTER TABLE `affiliate_clicks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `affiliate_links`
--
ALTER TABLE `affiliate_links`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `affiliate_sales`
--
ALTER TABLE `affiliate_sales`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `attributes`
--
ALTER TABLE `attributes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `attribute_values`
--
ALTER TABLE `attribute_values`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `banners`
--
ALTER TABLE `banners`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `brands`
--
ALTER TABLE `brands`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `bulk_orders`
--
ALTER TABLE `bulk_orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `carts`
--
ALTER TABLE `carts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1968;

--
-- AUTO_INCREMENT for table `cart_items`
--
ALTER TABLE `cart_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=77;

--
-- AUTO_INCREMENT for table `commissions`
--
ALTER TABLE `commissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `commission_rules`
--
ALTER TABLE `commission_rules`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `compare_lists`
--
ALTER TABLE `compare_lists`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `contact_messages`
--
ALTER TABLE `contact_messages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `coupons`
--
ALTER TABLE `coupons`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `coupon_products`
--
ALTER TABLE `coupon_products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `coupon_usages`
--
ALTER TABLE `coupon_usages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `couriers`
--
ALTER TABLE `couriers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `dropshippers`
--
ALTER TABLE `dropshippers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dropshipper_orders`
--
ALTER TABLE `dropshipper_orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dropshipper_order_items`
--
ALTER TABLE `dropshipper_order_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dropshipper_products`
--
ALTER TABLE `dropshipper_products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dropshipping_fulfillments`
--
ALTER TABLE `dropshipping_fulfillments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dropshipping_orders`
--
ALTER TABLE `dropshipping_orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dropshipping_order_items`
--
ALTER TABLE `dropshipping_order_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dropshipping_products`
--
ALTER TABLE `dropshipping_products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dropshipping_settings`
--
ALTER TABLE `dropshipping_settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dropshipping_shipments`
--
ALTER TABLE `dropshipping_shipments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `email_otps`
--
ALTER TABLE `email_otps`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `inventory`
--
ALTER TABLE `inventory`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=149;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `minimum_order_quantities`
--
ALTER TABLE `minimum_order_quantities`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `order_notes`
--
ALTER TABLE `order_notes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `order_statuses`
--
ALTER TABLE `order_statuses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `passkeys`
--
ALTER TABLE `passkeys`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `payment_deposit_details`
--
ALTER TABLE `payment_deposit_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `payment_methods`
--
ALTER TABLE `payment_methods`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=578;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=261;

--
-- AUTO_INCREMENT for table `product_attributes`
--
ALTER TABLE `product_attributes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT for table `product_images`
--
ALTER TABLE `product_images`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=95;

--
-- AUTO_INCREMENT for table `product_imports`
--
ALTER TABLE `product_imports`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product_offer_images`
--
ALTER TABLE `product_offer_images`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `product_specifications`
--
ALTER TABLE `product_specifications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `product_syncs`
--
ALTER TABLE `product_syncs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product_variants`
--
ALTER TABLE `product_variants`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `product_videos`
--
ALTER TABLE `product_videos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `resellers`
--
ALTER TABLE `resellers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `reseller_customers`
--
ALTER TABLE `reseller_customers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `reseller_orders`
--
ALTER TABLE `reseller_orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `reseller_prices`
--
ALTER TABLE `reseller_prices`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `reseller_products`
--
ALTER TABLE `reseller_products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rfqs`
--
ALTER TABLE `rfqs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `rfq_quotes`
--
ALTER TABLE `rfq_quotes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `shipments`
--
ALTER TABLE `shipments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `shipping_addresses`
--
ALTER TABLE `shipping_addresses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `shipping_rates`
--
ALTER TABLE `shipping_rates`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `shipping_zones`
--
ALTER TABLE `shipping_zones`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `sliders`
--
ALTER TABLE `sliders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `stock_movements`
--
ALTER TABLE `stock_movements`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `suppliers`
--
ALTER TABLE `suppliers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `supplier_inventory`
--
ALTER TABLE `supplier_inventory`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `supplier_pricing`
--
ALTER TABLE `supplier_pricing`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `supplier_products`
--
ALTER TABLE `supplier_products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `supplier_product_variants`
--
ALTER TABLE `supplier_product_variants`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `supplier_warehouses`
--
ALTER TABLE `supplier_warehouses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tags`
--
ALTER TABLE `tags`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tracking_events`
--
ALTER TABLE `tracking_events`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `units`
--
ALTER TABLE `units`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `vendors`
--
ALTER TABLE `vendors`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `vendor_orders`
--
ALTER TABLE `vendor_orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `warehouses`
--
ALTER TABLE `warehouses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `warehouse_products`
--
ALTER TABLE `warehouse_products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `warranty_registrations`
--
ALTER TABLE `warranty_registrations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `website_settings`
--
ALTER TABLE `website_settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `wholesalers`
--
ALTER TABLE `wholesalers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `wholesale_prices`
--
ALTER TABLE `wholesale_prices`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `wholesale_products`
--
ALTER TABLE `wholesale_products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `wholesale_tiers`
--
ALTER TABLE `wholesale_tiers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `wishlists`
--
ALTER TABLE `wishlists`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `wishlist_items`
--
ALTER TABLE `wishlist_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `withdrawals`
--
ALTER TABLE `withdrawals`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `affiliates`
--
ALTER TABLE `affiliates`
  ADD CONSTRAINT `affiliates_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `affiliate_clicks`
--
ALTER TABLE `affiliate_clicks`
  ADD CONSTRAINT `affiliate_clicks_affiliate_link_id_foreign` FOREIGN KEY (`affiliate_link_id`) REFERENCES `affiliate_links` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `affiliate_links`
--
ALTER TABLE `affiliate_links`
  ADD CONSTRAINT `affiliate_links_affiliate_id_foreign` FOREIGN KEY (`affiliate_id`) REFERENCES `affiliates` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `affiliate_links_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `affiliate_sales`
--
ALTER TABLE `affiliate_sales`
  ADD CONSTRAINT `affiliate_sales_affiliate_id_foreign` FOREIGN KEY (`affiliate_id`) REFERENCES `affiliates` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `affiliate_sales_affiliate_link_id_foreign` FOREIGN KEY (`affiliate_link_id`) REFERENCES `affiliate_links` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `attribute_values`
--
ALTER TABLE `attribute_values`
  ADD CONSTRAINT `attribute_values_ibfk_1` FOREIGN KEY (`attribute_id`) REFERENCES `attributes` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `bulk_orders`
--
ALTER TABLE `bulk_orders`
  ADD CONSTRAINT `bulk_orders_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `bulk_orders_ibfk_2` FOREIGN KEY (`wholesale_product_id`) REFERENCES `wholesale_products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `bulk_orders_wholesaler_id_foreign` FOREIGN KEY (`wholesaler_id`) REFERENCES `wholesalers` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `carts`
--
ALTER TABLE `carts`
  ADD CONSTRAINT `carts_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `cart_items`
--
ALTER TABLE `cart_items`
  ADD CONSTRAINT `cart_items_ibfk_1` FOREIGN KEY (`cart_id`) REFERENCES `carts` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `cart_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `cart_items_ibfk_3` FOREIGN KEY (`variant_id`) REFERENCES `product_variants` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `categories`
--
ALTER TABLE `categories`
  ADD CONSTRAINT `categories_ibfk_1` FOREIGN KEY (`parent_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `commissions`
--
ALTER TABLE `commissions`
  ADD CONSTRAINT `commissions_affiliate_id_foreign` FOREIGN KEY (`affiliate_id`) REFERENCES `affiliates` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `commissions_vendor_id_foreign` FOREIGN KEY (`vendor_id`) REFERENCES `vendors` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `commission_rules`
--
ALTER TABLE `commission_rules`
  ADD CONSTRAINT `commission_rules_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `commission_rules_vendor_id_foreign` FOREIGN KEY (`vendor_id`) REFERENCES `vendors` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `compare_lists`
--
ALTER TABLE `compare_lists`
  ADD CONSTRAINT `fk_compare_product` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_compare_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `coupon_products`
--
ALTER TABLE `coupon_products`
  ADD CONSTRAINT `fk_coupon_products_coupon` FOREIGN KEY (`coupon_id`) REFERENCES `coupons` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_coupon_products_product` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `coupon_usages`
--
ALTER TABLE `coupon_usages`
  ADD CONSTRAINT `coupon_usages_coupon_id_foreign` FOREIGN KEY (`coupon_id`) REFERENCES `coupons` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `coupon_usages_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `coupon_usages_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `customers`
--
ALTER TABLE `customers`
  ADD CONSTRAINT `customers_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `dropshippers`
--
ALTER TABLE `dropshippers`
  ADD CONSTRAINT `dropshippers_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `dropshipper_orders`
--
ALTER TABLE `dropshipper_orders`
  ADD CONSTRAINT `dropshipper_orders_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `dropshipper_orders_dropshipper_id_foreign` FOREIGN KEY (`dropshipper_id`) REFERENCES `dropshippers` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `dropshipper_orders_source_order_id_foreign` FOREIGN KEY (`source_order_id`) REFERENCES `orders` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `dropshipper_orders_supplier_id_foreign` FOREIGN KEY (`supplier_id`) REFERENCES `suppliers` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `dropshipper_order_items`
--
ALTER TABLE `dropshipper_order_items`
  ADD CONSTRAINT `dropshipper_order_items_dropshipper_order_id_foreign` FOREIGN KEY (`dropshipper_order_id`) REFERENCES `dropshipper_orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `dropshipper_order_items_supplier_product_id_foreign` FOREIGN KEY (`supplier_product_id`) REFERENCES `supplier_products` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `dropshipper_products`
--
ALTER TABLE `dropshipper_products`
  ADD CONSTRAINT `dropshipper_products_dropshipper_id_foreign` FOREIGN KEY (`dropshipper_id`) REFERENCES `dropshippers` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `dropshipper_products_supplier_product_id_foreign` FOREIGN KEY (`supplier_product_id`) REFERENCES `supplier_products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `dropshipping_fulfillments`
--
ALTER TABLE `dropshipping_fulfillments`
  ADD CONSTRAINT `dropshipping_fulfillments_ibfk_1` FOREIGN KEY (`dropshipping_order_id`) REFERENCES `dropshipping_orders` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `dropshipping_orders`
--
ALTER TABLE `dropshipping_orders`
  ADD CONSTRAINT `dropshipping_orders_ibfk_1` FOREIGN KEY (`vendor_id`) REFERENCES `vendors` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `dropshipping_orders_ibfk_2` FOREIGN KEY (`supplier_id`) REFERENCES `suppliers` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `dropshipping_order_items`
--
ALTER TABLE `dropshipping_order_items`
  ADD CONSTRAINT `dropshipping_order_items_ibfk_1` FOREIGN KEY (`dropshipping_order_id`) REFERENCES `dropshipping_orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `dropshipping_order_items_ibfk_2` FOREIGN KEY (`supplier_product_id`) REFERENCES `supplier_products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `dropshipping_products`
--
ALTER TABLE `dropshipping_products`
  ADD CONSTRAINT `dropshipping_products_ibfk_1` FOREIGN KEY (`vendor_id`) REFERENCES `vendors` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `dropshipping_products_ibfk_2` FOREIGN KEY (`supplier_product_id`) REFERENCES `supplier_products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `dropshipping_products_ibfk_3` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `dropshipping_settings`
--
ALTER TABLE `dropshipping_settings`
  ADD CONSTRAINT `dropshipping_settings_ibfk_1` FOREIGN KEY (`vendor_id`) REFERENCES `vendors` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `dropshipping_shipments`
--
ALTER TABLE `dropshipping_shipments`
  ADD CONSTRAINT `dropshipping_shipments_ibfk_1` FOREIGN KEY (`dropshipping_order_id`) REFERENCES `dropshipping_orders` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `inventory`
--
ALTER TABLE `inventory`
  ADD CONSTRAINT `inventory_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `inventory_ibfk_2` FOREIGN KEY (`variant_id`) REFERENCES `product_variants` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `inventory_ibfk_3` FOREIGN KEY (`warehouse_id`) REFERENCES `warehouses` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `minimum_order_quantities`
--
ALTER TABLE `minimum_order_quantities`
  ADD CONSTRAINT `minimum_order_quantities_ibfk_1` FOREIGN KEY (`wholesale_product_id`) REFERENCES `wholesale_products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`affiliate_id`) REFERENCES `affiliates` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `orders_shipping_zone_id_foreign` FOREIGN KEY (`shipping_zone_id`) REFERENCES `shipping_zones` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_items_ibfk_3` FOREIGN KEY (`variant_id`) REFERENCES `product_variants` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_items_ibfk_4` FOREIGN KEY (`vendor_id`) REFERENCES `vendors` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `order_notes`
--
ALTER TABLE `order_notes`
  ADD CONSTRAINT `order_notes_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `order_notes_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `passkeys`
--
ALTER TABLE `passkeys`
  ADD CONSTRAINT `passkeys_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `payment_deposit_details`
--
ALTER TABLE `payment_deposit_details`
  ADD CONSTRAINT `payment_deposit_details_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `payment_deposit_details_payment_id_foreign` FOREIGN KEY (`payment_id`) REFERENCES `payments` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`vendor_id`) REFERENCES `vendors` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `products_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `products_ibfk_3` FOREIGN KEY (`brand_id`) REFERENCES `brands` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `product_attributes`
--
ALTER TABLE `product_attributes`
  ADD CONSTRAINT `product_attributes_attribute_id_foreign` FOREIGN KEY (`attribute_id`) REFERENCES `attributes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `product_attributes_attribute_value_id_foreign` FOREIGN KEY (`attribute_value_id`) REFERENCES `attribute_values` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `product_attributes_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `product_images`
--
ALTER TABLE `product_images`
  ADD CONSTRAINT `product_images_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `product_imports`
--
ALTER TABLE `product_imports`
  ADD CONSTRAINT `product_imports_ibfk_1` FOREIGN KEY (`vendor_id`) REFERENCES `vendors` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `product_imports_ibfk_2` FOREIGN KEY (`supplier_product_id`) REFERENCES `supplier_products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `product_offer_images`
--
ALTER TABLE `product_offer_images`
  ADD CONSTRAINT `product_offer_images_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `product_specifications`
--
ALTER TABLE `product_specifications`
  ADD CONSTRAINT `product_specifications_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `product_syncs`
--
ALTER TABLE `product_syncs`
  ADD CONSTRAINT `product_syncs_ibfk_1` FOREIGN KEY (`dropshipping_product_id`) REFERENCES `dropshipping_products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `product_variants`
--
ALTER TABLE `product_variants`
  ADD CONSTRAINT `product_variants_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `product_videos`
--
ALTER TABLE `product_videos`
  ADD CONSTRAINT `product_videos_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `resellers`
--
ALTER TABLE `resellers`
  ADD CONSTRAINT `resellers_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `reseller_customers`
--
ALTER TABLE `reseller_customers`
  ADD CONSTRAINT `reseller_customers_ibfk_1` FOREIGN KEY (`reseller_id`) REFERENCES `resellers` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `reseller_orders`
--
ALTER TABLE `reseller_orders`
  ADD CONSTRAINT `reseller_orders_ibfk_1` FOREIGN KEY (`reseller_id`) REFERENCES `resellers` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reseller_orders_ibfk_2` FOREIGN KEY (`reseller_customer_id`) REFERENCES `reseller_customers` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reseller_orders_ibfk_3` FOREIGN KEY (`reseller_product_id`) REFERENCES `reseller_products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `reseller_prices`
--
ALTER TABLE `reseller_prices`
  ADD CONSTRAINT `reseller_prices_ibfk_1` FOREIGN KEY (`reseller_product_id`) REFERENCES `reseller_products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `reseller_products`
--
ALTER TABLE `reseller_products`
  ADD CONSTRAINT `reseller_products_ibfk_1` FOREIGN KEY (`reseller_id`) REFERENCES `resellers` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reseller_products_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `rfqs`
--
ALTER TABLE `rfqs`
  ADD CONSTRAINT `rfqs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `rfq_quotes`
--
ALTER TABLE `rfq_quotes`
  ADD CONSTRAINT `rfq_quotes_rfq_id_foreign` FOREIGN KEY (`rfq_id`) REFERENCES `rfqs` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `rfq_quotes_supplier_id_foreign` FOREIGN KEY (`supplier_id`) REFERENCES `suppliers` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `shipping_addresses`
--
ALTER TABLE `shipping_addresses`
  ADD CONSTRAINT `shipping_addresses_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `shipping_rates`
--
ALTER TABLE `shipping_rates`
  ADD CONSTRAINT `shipping_rates_shipping_zone_id_foreign` FOREIGN KEY (`shipping_zone_id`) REFERENCES `shipping_zones` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `stock_movements`
--
ALTER TABLE `stock_movements`
  ADD CONSTRAINT `stock_movements_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `stock_movements_ibfk_2` FOREIGN KEY (`variant_id`) REFERENCES `product_variants` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `suppliers`
--
ALTER TABLE `suppliers`
  ADD CONSTRAINT `suppliers_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `supplier_inventory`
--
ALTER TABLE `supplier_inventory`
  ADD CONSTRAINT `supplier_inventory_ibfk_1` FOREIGN KEY (`supplier_product_id`) REFERENCES `supplier_products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `supplier_inventory_ibfk_2` FOREIGN KEY (`warehouse_id`) REFERENCES `supplier_warehouses` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `supplier_pricing`
--
ALTER TABLE `supplier_pricing`
  ADD CONSTRAINT `supplier_pricing_ibfk_1` FOREIGN KEY (`supplier_product_id`) REFERENCES `supplier_products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `supplier_products`
--
ALTER TABLE `supplier_products`
  ADD CONSTRAINT `supplier_products_ibfk_1` FOREIGN KEY (`supplier_id`) REFERENCES `suppliers` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `supplier_product_variants`
--
ALTER TABLE `supplier_product_variants`
  ADD CONSTRAINT `supplier_product_variants_ibfk_1` FOREIGN KEY (`supplier_product_id`) REFERENCES `supplier_products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `supplier_warehouses`
--
ALTER TABLE `supplier_warehouses`
  ADD CONSTRAINT `supplier_warehouses_ibfk_1` FOREIGN KEY (`supplier_id`) REFERENCES `suppliers` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `vendors`
--
ALTER TABLE `vendors`
  ADD CONSTRAINT `vendors_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `warehouse_products`
--
ALTER TABLE `warehouse_products`
  ADD CONSTRAINT `warehouse_products_ibfk_1` FOREIGN KEY (`warehouse_id`) REFERENCES `warehouses` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `warehouse_products_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `wholesalers`
--
ALTER TABLE `wholesalers`
  ADD CONSTRAINT `wholesalers_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `wholesale_prices`
--
ALTER TABLE `wholesale_prices`
  ADD CONSTRAINT `wholesale_prices_ibfk_1` FOREIGN KEY (`wholesale_tier_id`) REFERENCES `wholesale_tiers` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `wholesale_products`
--
ALTER TABLE `wholesale_products`
  ADD CONSTRAINT `wholesale_products_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `wholesale_products_wholesaler_id_foreign` FOREIGN KEY (`wholesaler_id`) REFERENCES `wholesalers` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `wholesale_tiers`
--
ALTER TABLE `wholesale_tiers`
  ADD CONSTRAINT `wholesale_tiers_ibfk_1` FOREIGN KEY (`wholesale_product_id`) REFERENCES `wholesale_products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `wishlists`
--
ALTER TABLE `wishlists`
  ADD CONSTRAINT `wishlists_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `wishlist_items`
--
ALTER TABLE `wishlist_items`
  ADD CONSTRAINT `wishlist_items_ibfk_1` FOREIGN KEY (`wishlist_id`) REFERENCES `wishlists` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `wishlist_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
