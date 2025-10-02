-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 30, 2025 at 10:35 AM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `fruit_store`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart_items`
--

CREATE TABLE `cart_items` (
  `cart_item_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `session_id` varchar(255) DEFAULT NULL,
  `fruit_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
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
-- Table structure for table `fruits`
--

CREATE TABLE `fruits` (
  `fruit_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,0) NOT NULL,
  `stock_quantity` int(11) DEFAULT NULL,
  `type_id` int(11) NOT NULL,
  `image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `fruits`
--

INSERT INTO `fruits` (`fruit_id`, `name`, `description`, `price`, `stock_quantity`, `type_id`, `image`) VALUES
(1, 'Apple', 'Apples offer numerous health benefits, thanks to their high content of fiber, vitamin C, and antioxidants like polyphenols. These nutrients support heart health by lowering cholesterol and blood pressure, aid digestion, and help with weight management by promoting fullness', '150', 100, 1, '1759064456.webp'),
(2, 'Orange', 'Oranges offer benefits like boosting the immune system due to their high Vitamin C content, improving heart health by providing potassium and flavonoids, aiding digestion through fiber, enhancing skin health by supporting collagen production, and reducing inflammation with their antioxidants', '180', 75, 4, '1759064782.jpg'),
(3, 'Banana', 'Delicious banana for your everyday energy levels', '60', 50, 2, '1759111922.webp'),
(4, 'Pear', 'Pears offer benefits like improved digestion, enhanced heart health, and boosted immunity due to their high fiber, vitamin, and antioxidant content', '150', 20, 1, '1759112023.webp'),
(5, 'Grapefruit', 'Healthy and rich in Vitamin C and antioxidants, supports weight management', '300', 50, 4, '1759112037.png'),
(6, 'Kiwi', 'Native to China, Kiwi fruit is an excellent source of vitamins C and K, dietary fiber, and antioxidants', '250', 30, 2, '1759059007.webp'),
(9, 'Lemon', 'Lemons provide numerous health benefits due to their rich Vitamin C content and other antioxidants, which support the immune system, improve skin health by promoting collagen production, and protect against free radicals', '120', 100, 4, '1759134076.jpg'),
(10, 'Almond', 'Almonds offer benefits for heart health by lowering bad cholesterol and blood pressure, support weight management by promoting fullness with fiber and protein, regulate blood sugar, and provide powerful antioxidants like Vitamin E that protect cells from damage and reduce inflammation', '800', 50, 3, '1759134232.webp'),
(11, 'Cashew', 'Cashew nuts offer various health benefits due to their rich content of healthy fats, protein, fiber, and essential minerals like copper, magnesium, and antioxidants. These nutrients support heart health, aid in weight and blood sugar management, strengthen bones, and boost brain function and immunity', '800', 50, 3, '1759134348.jpg'),
(12, 'Walnut', 'Walnuts offer benefits for heart and brain health due to their omega-3 fatty acids, fiber, and antioxidants, while also supporting healthy weight, aiding sleep, and potentially reducing the risk of certain cancers. They contain vitamins and minerals like Vitamin E and magnesium, and the plant compounds like polyphenols help fight inflammation and oxidative stress', '900', 50, 3, '1759134442.jpg'),
(13, 'Watermelon', 'Eating watermelon offers benefits such as hydration due to its high water content, nutrient intake from vitamins A and C, and its antioxidant properties thanks to lycopene. It also supports heart health, aids digestion, and may help alleviate post-workout muscle soreness', '40', 100, 5, '1759134579.png'),
(14, 'Pumpkin', 'Eating pumpkin offers benefits for your immune system, vision, heart health, and digestion, largely due to its rich content of beta-carotene, vitamins A, C, and E, fiber, and potassium', '40', 60, 5, '1759135376.jpg'),
(15, 'Mango', 'Mangoes offer numerous health benefits due to their high content of vitamins, minerals, and antioxidants like vitamin C, vitamin A, and mangiferin. Key benefits include boosting the immune system, supporting eye and skin health, aiding digestion, promoting heart health by regulating blood pressure, and having anti-inflammatory properties that may help reduce the risk of certain cancers', '300', 40, 6, '1759135724.jpg'),
(16, 'Pineapple', 'Pineapple offers benefits for digestion, skin, and immune health due to its nutrient and enzyme content, particularly the enzyme bromelain, which helps break down protein and reduce inflammation. It is rich in vitamin C and manganese, which support collagen production, boost immunity, and contribute to bone health', '100', 100, 6, '1759135810.jpg'),
(17, 'Papaya', 'Papaya has many benefits, including protection against heart disease, reduced inflammation, aid in digestion, and boosting your immune system', '50', 200, 6, '1759135889.webp');

-- --------------------------------------------------------

--
-- Table structure for table `fruits_types`
--

CREATE TABLE `fruits_types` (
  `type_id` int(11) NOT NULL,
  `type_name` varchar(255) NOT NULL,
  `type_img` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `fruits_types`
--

INSERT INTO `fruits_types` (`type_id`, `type_name`, `type_img`) VALUES
(1, 'Pomes', 'ti1759110933.webp'),
(2, 'Berries', 'ti1759111149.webp'),
(3, 'Dry Fruits', 'ti1759112564.webp'),
(4, 'Citrus Fruits', 'ti1759111677.webp'),
(5, 'Pepos', 'ti1759111711.webp'),
(6, 'Tropical', 'ti1759111756.webp'),
(8, 'test type', NULL),
(10, 'test type2', 'ti1759110476.png');

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
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2025_09_15_063552_add_phone_to_users_table', 1),
(5, '2025_09_17_130000_create_cart_items_table', 1),
(6, '2025_09_25_113848_create_fruits_types_table', 2),
(7, '2025_09_25_114442_create_fruits_table', 2),
(8, '2025_09_25_120037_add_fruit_id_foreignkey_to_cart_items_table', 3),
(9, '2025_09_26_100423_add_user_type_to_users_table', 4),
(10, '2025_09_28_110127_add_image_to_fruits_table', 5);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `user_type` tinyint(4) DEFAULT NULL COMMENT '0-customer,1-admin'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `phone`, `user_type`) VALUES
(1, 'Admin', 'admin@gmail.com', NULL, '$2y$10$OSaLMu2yqmv9TDIEvNc4XOvexFNhE784a7fknUTSCdq5c3KhkOlEq', NULL, '2025-09-25 07:00:54', '2025-09-25 07:00:54', NULL, 1),
(3, 'Kiran Sone', 'kirans.git@gmail.com', NULL, '$2y$10$OSaLMu2yqmv9TDIEvNc4XOvexFNhE784a7fknUTSCdq5c3KhkOlEq', NULL, '2025-09-25 07:00:54', '2025-09-25 07:00:54', NULL, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart_items`
--
ALTER TABLE `cart_items`
  ADD PRIMARY KEY (`cart_item_id`),
  ADD KEY `cart_items_user_id_foreign` (`user_id`),
  ADD KEY `cart_items_fruit_id_foreign` (`fruit_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `fruits`
--
ALTER TABLE `fruits`
  ADD PRIMARY KEY (`fruit_id`),
  ADD KEY `indexfruitname` (`name`),
  ADD KEY `fktypeid` (`type_id`);

--
-- Indexes for table `fruits_types`
--
ALTER TABLE `fruits_types`
  ADD PRIMARY KEY (`type_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart_items`
--
ALTER TABLE `cart_items`
  MODIFY `cart_item_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `fruits`
--
ALTER TABLE `fruits`
  MODIFY `fruit_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `fruits_types`
--
ALTER TABLE `fruits_types`
  MODIFY `type_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart_items`
--
ALTER TABLE `cart_items`
  ADD CONSTRAINT `cart_items_fruit_id_foreign` FOREIGN KEY (`fruit_id`) REFERENCES `fruits` (`fruit_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `cart_items_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `fruits`
--
ALTER TABLE `fruits`
  ADD CONSTRAINT `fktypeid` FOREIGN KEY (`type_id`) REFERENCES `fruits_types` (`type_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
