-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: db
-- Generation Time: Dec 15, 2023 at 03:07 AM
-- Server version: 10.6.12-MariaDB-1:10.6.12+maria~ubu2004
-- PHP Version: 7.4.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mysql_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `banners`
--

CREATE TABLE `banners` (
  `id` int(10) UNSIGNED NOT NULL,
  `vendor_id` int(11) NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `image` varchar(255) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `sub_title` varchar(255) DEFAULT NULL,
  `link_text` varchar(255) DEFAULT NULL,
  `type` tinyint(1) DEFAULT NULL COMMENT '1=category,2=product',
  `section` int(11) NOT NULL DEFAULT 1 COMMENT '1=banner1,2=banner2,3=banner3',
  `is_available` tinyint(1) NOT NULL DEFAULT 1 COMMENT '1=yes,2=no',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `blogs`
--

CREATE TABLE `blogs` (
  `id` int(10) UNSIGNED NOT NULL,
  `vendor_id` int(11) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `description` longtext NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `booking`
--

CREATE TABLE `booking` (
  `id` int(11) NOT NULL,
  `vendor_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `product_id` int(11) NOT NULL,
  `booking_number` varchar(255) NOT NULL,
  `checkin_date` date NOT NULL,
  `checkin_time` varchar(255) NOT NULL,
  `checkin_location` varchar(255) NOT NULL,
  `checkout_date` date NOT NULL,
  `checkout_time` varchar(255) NOT NULL,
  `checkout_location` varchar(255) NOT NULL,
  `per_day_price` varchar(255) DEFAULT NULL,
  `per_hour_price` varchar(255) DEFAULT NULL,
  `subtotal` varchar(255) NOT NULL,
  `tax` varchar(255) DEFAULT NULL,
  `grand_total` varchar(255) DEFAULT NULL,
  `offer_code` varchar(255) DEFAULT NULL,
  `offer_amount` varchar(255) DEFAULT NULL,
  `product_image` varchar(255) NOT NULL,
  `customer_name` varchar(255) DEFAULT NULL,
  `customer_email` varchar(255) DEFAULT NULL,
  `customer_mobile` varchar(255) DEFAULT NULL,
  `customer_address` varchar(255) DEFAULT NULL,
  `transaction_type` varchar(255) DEFAULT NULL,
  `transaction_id` varchar(255) DEFAULT NULL,
  `status` varchar(255) NOT NULL COMMENT '1=pending,2=accepted,3=in progress,4=reject by vendor,5=rejected by customer,6=completed\r\n',
  `payment_status` int(11) NOT NULL COMMENT '1=unpaid,2=paid',
  `is_notification` int(11) NOT NULL DEFAULT 1 COMMENT '1=Unread,2=Read',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(10) UNSIGNED NOT NULL,
  `vendor_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `is_available` tinyint(1) NOT NULL DEFAULT 1 COMMENT '1--> yes, 2-->No',
  `is_deleted` tinyint(1) NOT NULL DEFAULT 2 COMMENT '1--> yes, 2-->No',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `city`
--

CREATE TABLE `city` (
  `id` int(11) NOT NULL,
  `country_id` int(11) NOT NULL,
  `city` varchar(255) NOT NULL,
  `is_deleted` int(11) NOT NULL DEFAULT 2 COMMENT '1=Yes,2=No',
  `is_available` int(11) NOT NULL DEFAULT 1 COMMENT '1=Yes,2=No',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `contacts`
--

CREATE TABLE `contacts` (
  `id` int(10) UNSIGNED NOT NULL,
  `vendor_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `mobile` varchar(255) NOT NULL,
  `message` longtext NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `country`
--

CREATE TABLE `country` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `is_deleted` int(11) NOT NULL DEFAULT 2 COMMENT '1=Yes,2=No',
  `is_available` int(11) NOT NULL DEFAULT 1 COMMENT '1=Yes,2=No',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `customdomains`
--

CREATE TABLE `customdomains` (
  `id` int(10) UNSIGNED NOT NULL,
  `vendor_id` varchar(255) NOT NULL,
  `requested_domain` varchar(255) NOT NULL,
  `current_domain` varchar(255) DEFAULT NULL,
  `status` tinyint(1) NOT NULL COMMENT '1=pending ,2=connected',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
-- Table structure for table `faqs`
--

CREATE TABLE `faqs` (
  `id` int(11) NOT NULL,
  `vendor_id` int(11) NOT NULL,
  `question` varchar(255) NOT NULL,
  `answer` longtext NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `features`
--

CREATE TABLE `features` (
  `id` int(11) NOT NULL,
  `vendor_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` longtext NOT NULL,
  `image` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `footerfeatures`
--

CREATE TABLE `footerfeatures` (
  `id` int(10) UNSIGNED NOT NULL,
  `vendor_id` int(11) NOT NULL,
  `icon` varchar(255) NOT NULL,
  `title` text NOT NULL,
  `description` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `gallery`
--

CREATE TABLE `gallery` (
  `id` int(11) NOT NULL,
  `vendor_id` int(11) NOT NULL,
  `image` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `languages`
--

CREATE TABLE `languages` (
  `id` int(10) UNSIGNED NOT NULL,
  `code` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `layout` int(11) NOT NULL DEFAULT 1 COMMENT '1=ltr,2=rtl',
  `is_default` int(11) NOT NULL DEFAULT 2 COMMENT '1 = yes , 2 = no',
  `is_available` int(11) NOT NULL DEFAULT 1 COMMENT '1=yes,2=no',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `languages`
--

INSERT INTO `languages` (`id`, `code`, `name`, `image`, `layout`, `is_default`, `is_available`, `created_at`, `updated_at`) VALUES
(1, 'en', 'English', 'flag-64005c4be9359.png', 1, 1, 1, '2022-12-13 05:15:46', '2023-03-24 07:06:36');

-- --------------------------------------------------------

--
-- Table structure for table `location`
--

CREATE TABLE `location` (
  `id` int(11) NOT NULL,
  `vendor_id` int(11) NOT NULL,
  `pickup_location` varchar(255) DEFAULT NULL,
  `drop_location` varchar(255) DEFAULT NULL,
  `type` int(11) NOT NULL COMMENT '1=pickup,2=drop',
  `is_available` int(11) NOT NULL COMMENT '1=Yes,2=No',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2023_12_06_082250_create_sessions_table', 1);

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
-- Table structure for table `payment`
--

CREATE TABLE `payment` (
  `id` int(11) NOT NULL,
  `vendor_id` int(11) NOT NULL,
  `environment` int(11) NOT NULL DEFAULT 1 COMMENT '1=sandbox,2=production',
  `payment_name` text NOT NULL,
  `type` int(11) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `currency` varchar(255) DEFAULT NULL,
  `public_key` text DEFAULT NULL,
  `secret_key` text DEFAULT NULL,
  `encryption_key` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bank_name` varchar(255) DEFAULT NULL,
  `account_holder_name` varchar(255) DEFAULT NULL,
  `account_number` varchar(255) DEFAULT NULL,
  `bank_ifsc_code` varchar(255) DEFAULT NULL,
  `is_available` int(11) NOT NULL,
  `is_activate` int(11) NOT NULL DEFAULT 1 COMMENT '1=Yes,2=No',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `payment`
--

INSERT INTO `payment` (`id`, `vendor_id`, `environment`, `payment_name`, `type`, `image`, `currency`, `public_key`, `secret_key`, `encryption_key`, `bank_name`, `account_holder_name`, `account_number`, `bank_ifsc_code`, `is_available`, `is_activate`, `created_at`, `updated_at`) VALUES
(2, 1, 1, 'RazorPay', 2, 'payment-65268c317e882.png', 'USD', 'rzp_test_4r8y0wDMkrUDFn', 'nys_ty_key', '', NULL, NULL, NULL, NULL, 1, 1, '2020-12-28 20:45:15', '2023-10-11 11:51:13'),
(3, 1, 1, 'Stripe', 3, 'payment-65268c500f603.png', 'USD', 'pk_test_51IjNgIJwZppK21ZQa6e7ZVOImwJ2auI54TD6xHici94u7DD5mhGf1oaBiDyL9mX7PbN5nt6Weap4tmGWLRIrslCu00d8QgQ3nI', 'sk_test_51IjNgIJwZppK21ZQK85uLARMdhtuuhA81PB24VDfiqSW8SXQZKrZzvbpIkigEb27zZPBMF4UEG7PK9587Xresuc000x8CdE22A', '', NULL, NULL, NULL, NULL, 1, 1, '2020-12-28 20:45:15', '2023-10-11 11:51:44'),
(4, 1, 1, 'Flutterwave', 4, 'payment-65268c500fbc4.png', 'NGN', 'FLWPUBK_TEST-61c94068c4a44548a771cc7cf9548d05-X', 'FLWSECK_TEST-1140781769b7bd5cfd6b3fb6d5704017-X', 'FLWSECK_TEST863a39eb1475', NULL, NULL, NULL, NULL, 1, 2, '2020-12-28 20:45:15', '2023-10-11 11:51:44'),
(5, 1, 1, 'Paystack', 5, 'payment-65268c50100e6.png', 'GHS', 'pk_test_8a6a139a3bae6e41cbbbc41f4d7b65d4da9f7967', 'sk_test_6ab143b6f0c2a209373adeef55a64411c1a91ae9', '', NULL, NULL, NULL, NULL, 1, 2, '2020-12-28 20:45:15', '2023-10-11 11:51:44'),
(6, 1, 1, 'BankTransfer', 6, 'bank.png', NULL, NULL, NULL, '', 'International Bank', 'John Doe', '554545877132412', '123456', 1, 2, '2020-12-28 20:45:15', '2023-03-11 04:32:49'),
(7, 1, 1, 'MercadoPago', 7, 'payment-65268c5010583.png', 'R$', '', 'APP_USR-3693146734015792-042811-c6deca56df8ac66e83efb5334c46110c-126508225', '', NULL, NULL, NULL, NULL, 1, 2, '2020-12-28 20:45:15', '2023-10-11 11:51:44'),
(8, 1, 1, 'PayPal', 8, 'payment-65268c50109cf.png', 'USD', 'AcRx7vvy79nbNxBemacGKmnnRe_CtxkItyspBS_eeMIPREwfCEIfPg1uX-bdqPrS_ZFGocxEH_SJRrIJ', 'EGtgNkjt3I5lkhEEzicdot8gVH_PcFiKxx6ZBiXpVrp4QLDYcVQQMLX6MMG_fkS9_H0bwmZzBovb4jLP', '', NULL, NULL, NULL, NULL, 1, 2, '2020-12-28 20:45:15', '2023-10-11 11:51:44'),
(9, 1, 1, 'MyFatoorah', 9, 'payment-65268c5010db4.png', 'KWT', '', 'rLtt6JWvbUHDDhsZnfpAhpYk4dxYDQkbcPTyGaKp2TYqQgG7FGZ5Th_WD53Oq8Ebz6A53njUoo1w3pjU1D4vs_ZMqFiz_j0urb_BH9Oq9VZoKFoJEDAbRZepGcQanImyYrry7Kt6MnMdgfG5jn4HngWoRdKduNNyP4kzcp3mRv7x00ahkm9LAK7ZRieg7k1PDAnBIOG3EyVSJ5kK4WLMvYr7sCwHbHcu4A5WwelxYK0GMJy37bNAarSJDFQsJ2ZvJjvMDmfWwDVFEVe_5tOomfVNt6bOg9mexbGjMrnHBnKnZR1vQbBtQieDlQepzTZMuQrSuKn-t5XZM7V6fCW7oP-uXGX-sMOajeX65JOf6XVpk29DP6ro8WTAflCDANC193yof8-f5_EYY-3hXhJj7RBXmizDpneEQDSaSz5sFk0sV5qPcARJ9zGG73vuGFyenjPPmtDtXtpx35A-BVcOSBYVIWe9kndG3nclfefjKEuZ3m4jL9Gg1h2JBvmXSMYiZtp9MR5I6pvbvylU_PP5xJFSjVTIz7IQSjcVGO41npnwIxRXNRxFOdIUHn0tjQ-7LwvEcTXyPsHXcMD8WtgBh-wxR8aKX7WPSsT1O8d8reb2aR7K3rkV3K82K_0OgawImEpwSvp9MNKynEAJQS6ZHe_J_l77652xwPNxMRTMASk1ZsJL', '', NULL, NULL, NULL, NULL, 1, 2, '2020-12-28 20:45:15', '2023-10-11 11:51:44'),
(10, 1, 1, 'toyyibpay', 10, 'payment-65268c501123f.png', 'RM', 'ts75iszg', 'luieh2jt-8hpa-m2xv-wrkv-ejrfvhjppnsj', '', NULL, NULL, NULL, NULL, 1, 2, '2020-12-28 20:45:15', '2023-10-11 11:51:44');

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `plans`
--

CREATE TABLE `plans` (
  `id` int(11) NOT NULL,
  `name` text NOT NULL,
  `description` longtext NOT NULL,
  `features` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` float NOT NULL,
  `themes_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `plan_type` int(11) NOT NULL COMMENT '1=fixed,2=custom',
  `duration` varchar(255) DEFAULT NULL COMMENT '1=1 month\r\n2=3 month\r\n3=6 month\r\n4=1 year\r\n5=lifetime\r\n\r\n\r\n\r\n',
  `days` int(11) DEFAULT NULL,
  `order_limit` int(11) NOT NULL,
  `appointment_limit` int(11) NOT NULL,
  `custom_domain` int(11) NOT NULL DEFAULT 2 COMMENT '1=yes,2=no',
  `vendor_app` int(11) NOT NULL,
  `zoom` int(11) NOT NULL DEFAULT 2 COMMENT '1 = Yes , 2 = No',
  `calendar` int(11) NOT NULL DEFAULT 2 COMMENT '1=yes,2=nn',
  `google_analytics` int(11) DEFAULT NULL,
  `is_available` int(11) DEFAULT 1 COMMENT '1=Yes\r\n2=No\r\n',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `id` int(11) NOT NULL,
  `vendor_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `additional_details` text NOT NULL,
  `tax` double NOT NULL,
  `per_hour_price` double DEFAULT NULL,
  `per_day_price` double DEFAULT NULL,
  `minimum_booking_hour` int(11) NOT NULL,
  `is_available` int(11) NOT NULL DEFAULT 1 COMMENT '1=yes,2=no',
  `is_deleted` int(11) NOT NULL DEFAULT 2 COMMENT '1=yes,2=no',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `productfeatures`
--

CREATE TABLE `productfeatures` (
  `id` int(11) NOT NULL,
  `vendor_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `sub_title` varchar(255) DEFAULT NULL,
  `image` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product_image`
--

CREATE TABLE `product_image` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `image` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `promocodes`
--

CREATE TABLE `promocodes` (
  `id` int(10) UNSIGNED NOT NULL,
  `vendor_id` int(11) NOT NULL,
  `offer_name` varchar(255) NOT NULL,
  `offer_code` varchar(255) NOT NULL,
  `offer_type` int(11) NOT NULL COMMENT '1=fixed,2=percentage',
  `offer_amount` varchar(255) NOT NULL,
  `min_amount` int(11) NOT NULL,
  `usage_type` int(11) DEFAULT NULL COMMENT '1=Limited time\r\n,2=multiple times',
  `usage_limit` int(11) NOT NULL,
  `start_date` date NOT NULL,
  `exp_date` date NOT NULL,
  `description` longtext NOT NULL,
  `is_available` int(11) DEFAULT 1 COMMENT '1=Yes\r\n2=No\r\n',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `promotionalbanner`
--

CREATE TABLE `promotionalbanner` (
  `id` int(11) NOT NULL,
  `vendor_id` int(11) NOT NULL,
  `image` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` text NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('OH5Kxg6GtSSgl9e2S0HZNSES7q7NjW3pvZtFtdOd', NULL, '172.21.0.3', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/119.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiMTQ3YkFEaWtTdkFaSXBuVDh4U2JkMXpzbHM1bDRuQ3RZc1dhWG0zViI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDc6Imh0dHA6Ly9sZW5kcmFwcC5zaG9wL2luc3RhbGwvZW52aXJvbm1lbnQvd2l6YXJkIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1702606473);

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int(10) UNSIGNED NOT NULL,
  `vendor_id` int(11) DEFAULT NULL,
  `currency` varchar(255) NOT NULL DEFAULT 'INR',
  `currency_position` varchar(255) NOT NULL DEFAULT '1' COMMENT '1=left, 2=right',
  `logo` varchar(255) DEFAULT 'default-logo.png',
  `favicon` varchar(255) NOT NULL DEFAULT 'default-favicon.png',
  `notification_sound` varchar(255) DEFAULT NULL,
  `footer_description` longtext DEFAULT NULL,
  `delivery_type` varchar(10) DEFAULT NULL,
  `timezone` varchar(255) NOT NULL DEFAULT 'Asia/Kolkata',
  `referral_amount` varchar(255) DEFAULT NULL,
  `wait_time` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `mobile` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `contact` varchar(255) DEFAULT NULL,
  `copyright` varchar(255) NOT NULL DEFAULT 'Copyright © 2021-2022',
  `web_title` varchar(255) NOT NULL DEFAULT 'admin',
  `primary_color` varchar(255) NOT NULL DEFAULT '#fffff',
  `secondary_color` varchar(255) DEFAULT NULL,
  `meta_title` varchar(255) DEFAULT NULL,
  `meta_description` text DEFAULT NULL,
  `og_image` varchar(255) DEFAULT NULL,
  `facebook_link` varchar(255) DEFAULT NULL,
  `twitter_link` varchar(255) DEFAULT NULL,
  `instagram_link` varchar(255) DEFAULT NULL,
  `linkedin_link` varchar(255) DEFAULT NULL,
  `whatsapp_widget` longtext DEFAULT NULL,
  `terms_content` longtext DEFAULT NULL,
  `privacy_content` longtext DEFAULT NULL,
  `about_content` longtext DEFAULT NULL,
  `whatsapp_message` longtext DEFAULT NULL,
  `whatsapp_number` varchar(255) DEFAULT NULL,
  `client_id` varchar(255) DEFAULT NULL,
  `client_secret` varchar(255) DEFAULT NULL,
  `redirect_uri` varchar(255) DEFAULT NULL,
  `custom_domain` text DEFAULT NULL,
  `cname_text` text DEFAULT NULL,
  `cname_title` text DEFAULT NULL,
  `maintenance_mode` tinyint(1) NOT NULL DEFAULT 2 COMMENT '1=Yes,2=No',
  `checkout_login_required` int(11) DEFAULT 2 COMMENT '1 = Yes , 2 = No',
  `interval_time` varchar(255) DEFAULT '1',
  `interval_type` int(1) DEFAULT NULL,
  `per_slot_limit` int(11) DEFAULT NULL,
  `time_format` tinyint(1) DEFAULT NULL COMMENT '1=12 hours,2=24 hours',
  `zoom_api_key` varchar(255) DEFAULT NULL,
  `zoom_api_secret_key` varchar(255) DEFAULT NULL,
  `zoom_email` varchar(255) DEFAULT NULL,
  `theme` int(11) NOT NULL DEFAULT 1,
  `tracking_id` varchar(255) DEFAULT NULL,
  `view_id` varchar(255) DEFAULT NULL,
  `firebase` longtext DEFAULT NULL,
  `cover_image` varchar(255) DEFAULT NULL,
  `auth_image` varchar(255) DEFAULT NULL,
  `listing_page_image` varchar(255) DEFAULT NULL,
  `work_title` varchar(255) DEFAULT NULL,
  `work_subtitle` varchar(255) DEFAULT NULL,
  `why_choose_title` varchar(255) DEFAULT NULL,
  `why_choose_subtitle` varchar(255) DEFAULT NULL,
  `why_choose_image` varchar(255) DEFAULT NULL,
  `faq_image` varchar(255) DEFAULT NULL,
  `telegram_message` longtext DEFAULT NULL,
  `telegram_access_token` text DEFAULT NULL,
  `telegram_chat_id` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `vendor_id`, `currency`, `currency_position`, `logo`, `favicon`, `notification_sound`, `footer_description`, `delivery_type`, `timezone`, `referral_amount`, `wait_time`, `address`, `mobile`, `email`, `description`, `contact`, `copyright`, `web_title`, `primary_color`, `secondary_color`, `meta_title`, `meta_description`, `og_image`, `facebook_link`, `twitter_link`, `instagram_link`, `linkedin_link`, `whatsapp_widget`, `terms_content`, `privacy_content`, `about_content`, `whatsapp_message`, `whatsapp_number`, `client_id`, `client_secret`, `redirect_uri`, `custom_domain`, `cname_text`, `cname_title`, `maintenance_mode`, `checkout_login_required`, `interval_time`, `interval_type`, `per_slot_limit`, `time_format`, `zoom_api_key`, `zoom_api_secret_key`, `zoom_email`, `theme`, `tracking_id`, `view_id`, `firebase`, `cover_image`, `auth_image`, `listing_page_image`, `work_title`, `work_subtitle`, `why_choose_title`, `why_choose_subtitle`, `why_choose_image`, `faq_image`, `telegram_message`, `telegram_access_token`, `telegram_chat_id`, `created_at`, `updated_at`) VALUES
(1, 1, '$', '1', 'logo-652549dbf02ee.png', 'favicon-65254983befcf.png', '', NULL, NULL, 'Asia/Kolkata', NULL, NULL, '248 Cedar Swamp Rd, Jackson, New Mexico - 08527', '', 'infotechgravity@gmail.com', NULL, '919499874557', '© 2024 Lendr - Marketplace. All rights reserved.', 'Lendr | Admin', '#16162e', '#80b213', 'Lendr', 'Lendr', 'og_image-639af6f93c526.png', 'https://www.facebook.com/', 'https://twitter.com/', 'https://www.instagram.com/', 'https://www.linkedin.com/', NULL, 'What is Lorem Ipsum?\nLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.\n\nWhat is Lorem Ipsum?\nLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.\n\nWhat is Lorem Ipsum?\nLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.\n\nWhat is Lorem Ipsum?\nLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.\n\nWhat is Lorem Ipsum?\nLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', 'What is Lorem Ipsum?\nLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.\n\nWhat is Lorem Ipsum?\nLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.\n\nWhat is Lorem Ipsum?\nLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.\n\nWhat is Lorem Ipsum?\nLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.\n\nWhat is Lorem Ipsum?\nLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', 'What is Lorem Ipsum?\nLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.\n\nWhat is Lorem Ipsum?\nLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.\n\nWhat is Lorem Ipsum?\nLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.\n\nWhat is Lorem Ipsum?\nLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.\n\nWhat is Lorem Ipsum?\nLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', NULL, '', 'client_id', 'client_secret', 'redirect_uri', '-', 'If you\'re using cPanel or Plesk then you need to manually add custom domain in your server with the same root directory as the script installation and user need to point their custom domain A record with your server IP. Example : 68.178.145.4', 'Read All Instructions Carefully Before Sending Custom Domain Request', 2, 2, NULL, NULL, 0, NULL, '', '', '', 1, 'tracking_id', 'view_id', NULL, '', '', NULL, NULL, NULL, '', '', '', '', NULL, NULL, NULL, '2022-12-02 10:09:25', '2023-10-12 07:53:19');

-- --------------------------------------------------------

--
-- Table structure for table `subscribers`
--

CREATE TABLE `subscribers` (
  `id` int(10) UNSIGNED NOT NULL,
  `vendor_id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `systemaddons`
--

CREATE TABLE `systemaddons` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `unique_identifier` varchar(255) NOT NULL,
  `version` varchar(20) NOT NULL,
  `activated` int(11) NOT NULL,
  `image` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `testimonials`
--

CREATE TABLE `testimonials` (
  `id` int(11) NOT NULL,
  `vendor_id` int(11) NOT NULL,
  `star` int(11) NOT NULL,
  `description` longtext NOT NULL,
  `name` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `position` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `timings`
--

CREATE TABLE `timings` (
  `id` int(11) NOT NULL,
  `vendor_id` int(11) NOT NULL,
  `day` varchar(50) NOT NULL,
  `open_time` varchar(30) NOT NULL,
  `close_time` varchar(30) NOT NULL,
  `break_start` varchar(255) NOT NULL,
  `break_end` varchar(255) NOT NULL,
  `is_always_close` tinyint(1) NOT NULL COMMENT '1 For Yes, 2 For No',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` int(11) NOT NULL,
  `vendor_id` int(11) NOT NULL,
  `plan_id` int(11) NOT NULL,
  `plan_name` varchar(255) NOT NULL,
  `payment_type` varchar(255) NOT NULL COMMENT '1: cod,\r\n2: RazorPay,\r\n3:Stripe,\r\n4:Flutterwave, \r\n5:Paystack,\r\n7 :Mercado Pago,\r\n8: PayPal, \r\n9: MyFatoorah,\r\n10: toyyibpay ',
  `payment_id` varchar(255) DEFAULT NULL,
  `amount` float NOT NULL DEFAULT 0,
  `duration` varchar(255) DEFAULT NULL COMMENT '1=1 Month,\r\n2=3Month\r\n3=6 Month\r\n4=1 Year\r\n5=lifetime\r\n',
  `days` int(11) DEFAULT NULL,
  `purchase_date` varchar(255) NOT NULL,
  `service_limit` varchar(255) NOT NULL,
  `themes_id` varchar(255) NOT NULL,
  `appoinment_limit` varchar(255) NOT NULL,
  `expire_date` varchar(255) NOT NULL,
  `screenshot` varchar(255) DEFAULT NULL,
  `custom_domain` int(11) NOT NULL DEFAULT 2 COMMENT '1=yes,2=no',
  `zoom` int(11) NOT NULL DEFAULT 2,
  `calendar` int(11) NOT NULL DEFAULT 2 COMMENT '1=yes,2=no',
  `google_analytics` int(11) NOT NULL DEFAULT 2,
  `status` int(11) NOT NULL COMMENT '1 = pending, 2 = yes/BankTransferAccepted,3=no/BankTransferDeclined',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `mobile` varchar(255) DEFAULT NULL,
  `image` varchar(255) NOT NULL,
  `password` varchar(255) DEFAULT NULL,
  `login_type` varchar(255) NOT NULL,
  `google_id` varchar(255) DEFAULT NULL,
  `facebook_id` varchar(255) DEFAULT NULL,
  `type` tinyint(1) NOT NULL COMMENT '1=Admin,2=vendor,3=user',
  `description` text DEFAULT NULL,
  `token` longtext DEFAULT NULL,
  `country_id` int(11) DEFAULT NULL,
  `city_id` int(11) DEFAULT NULL,
  `payment_id` varchar(255) DEFAULT NULL,
  `plan_id` varchar(255) DEFAULT NULL,
  `purchase_amount` varchar(255) DEFAULT NULL,
  `purchase_date` varchar(255) DEFAULT NULL,
  `payment_type` int(11) DEFAULT NULL COMMENT '1=COD,2=Wallet,3=Razorpay,4=stripe,5=Flutterwave,6=paystack',
  `referral_code` varchar(255) DEFAULT NULL,
  `wallet` varchar(255) DEFAULT '''0''',
  `otp` varchar(255) DEFAULT NULL,
  `available_on_landing` int(11) DEFAULT NULL COMMENT '1=Yes,2=No',
  `allow_without_subscription` int(11) DEFAULT NULL COMMENT '1=Yes,2=No',
  `is_verified` tinyint(1) NOT NULL COMMENT '1=Yes,2=No',
  `is_available` tinyint(11) NOT NULL COMMENT '1=Yes,2=No	',
  `remember_token` varchar(100) DEFAULT NULL,
  `username` varchar(255) DEFAULT NULL,
  `license_key` text DEFAULT NULL,
  `hostdomain` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `slug`, `email`, `mobile`, `image`, `password`, `login_type`, `google_id`, `facebook_id`, `type`, `description`, `token`, `country_id`, `city_id`, `payment_id`, `plan_id`, `purchase_amount`, `purchase_date`, `payment_type`, `referral_code`, `wallet`, `otp`, `available_on_landing`, `allow_without_subscription`, `is_verified`, `is_available`, `remember_token`, `username`, `license_key`, `hostdomain`, `created_at`, `updated_at`) VALUES
(1, 'Admin', '', 'admin@gmail.com', '1234567890', 'profile-6525497a19a02.png', '$2y$10$BGzS523wDK3hKQO1iZb6Z.Y6AgATl.LXccaa.WhGzxNVnEJHoy5SC', 'normal', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', NULL, 0, 0, 1, 1, NULL, NULL, NULL, NULL, '2022-09-03 05:54:32', '2023-10-10 12:54:18');

-- --------------------------------------------------------

--
-- Table structure for table `variation`
--

CREATE TABLE `variation` (
  `id` int(11) NOT NULL,
  `vendor_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `product_price` double NOT NULL,
  `variation` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `whychooseus`
--

CREATE TABLE `whychooseus` (
  `id` int(11) NOT NULL,
  `vendor_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `works`
--

CREATE TABLE `works` (
  `id` int(11) NOT NULL,
  `vendor_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `sub_title` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `users`
--
ALTER TABLE `users`
ADD PRIMARY KEY (`id`);

--
-- Indexes for table `banners`
--
ALTER TABLE `banners`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `blogs`
--
ALTER TABLE `blogs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `booking`
--
ALTER TABLE `booking`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `city`
--
ALTER TABLE `city`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `country`
--
ALTER TABLE `country`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customdomains`
--
ALTER TABLE `customdomains`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `faqs`
--
ALTER TABLE `faqs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `productfeatures`
--
ALTER TABLE `productfeatures`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_image`
--
ALTER TABLE `product_image`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT;
COMMIT;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `id` BIGINT NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `productfeatures`
--
ALTER TABLE `productfeatures`
  MODIFY `id` BIGINT NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product_image`
--
ALTER TABLE `product_image`
  MODIFY `id` BIGINT NOT NULL AUTO_INCREMENT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
