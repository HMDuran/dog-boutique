-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 16, 2024 at 05:52 PM
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
-- Database: `dog_boutique`
--

-- --------------------------------------------------------

--
-- Table structure for table `carts`
--

CREATE TABLE `carts` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `total_amount` decimal(10,2) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cart_items`
--

CREATE TABLE `cart_items` (
  `id` int(11) NOT NULL,
  `cart_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `status` enum('purchased','pending') DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`) VALUES
(1, 'collars & leashes'),
(2, 'Apparel');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `total_amount` decimal(10,2) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `stock` int(11) DEFAULT NULL,
  `categoryid` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `image`, `description`, `price`, `stock`, `categoryid`, `created_at`, `updated_at`) VALUES
(48, 'Orson Parsons', '../../uploads/hanah.jpg', 'Ad fugiat dolor cons', 497.00, 14, 2, '2024-04-16 07:15:59', '2024-04-16 13:15:59');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `first_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `phone_number` int(11) NOT NULL,
  `delivery_address` varchar(255) DEFAULT NULL,
  `role` varchar(255) DEFAULT 'customer',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `email`, `password`, `phone_number`, `delivery_address`, `role`, `created_at`, `updated_at`) VALUES
(1, 'Madeson', 'Clay', 'kaxuxavi@mailinator.com', '$2y$10$u7758jEA7/StmMjPAyWoyebZ4ueGJdmuJTY6sNT9WdNglPj8cZ.W.', 0, 'Aliquid qui amet ad', 'customer', '0000-00-00 00:00:00', '2024-04-08 06:21:29'),
(2, 'Kuame', 'Pace', 'xuwiqelyzi@mailinator.com', '$2y$10$T9pHGhHQDnFRlNzEuxBo/OBDMA1K3hAnN8.46fcwBPpyy7ISjZF2y', 0, 'Numquam unde minus v', 'customer', '0000-00-00 00:00:00', '2024-04-08 06:24:07'),
(3, 'Dara', 'Armstrong', 'fewyf@mailinator.com', '$2y$10$lO5ghje/rDv0JFV7ef2Ecehy02DGEWtSfr/Zh2yIusrwt.AbilEyq', 0, 'Est reiciendis aliqu', 'customer', '0000-00-00 00:00:00', '2024-04-08 06:24:23'),
(4, 'Abra', 'Hutchinson', 'lolapuhal@mailinator.com', '$2y$10$vy02qX/G/KDC2pBGO6BdU.oByCBZd4p5aJcQGlV3kps4IplkGQVMW', 0, 'Nihil fugiat ipsa v', 'customer', '0000-00-00 00:00:00', '2024-04-08 06:27:04'),
(5, 'Armand', 'Beasley', 'watiqa@mailinator.com', '$2y$10$NshL93e3iETBZpJFOFAsb.ZwgZ/resnUSN8znXT5oz3nclQuIWVxe', 0, 'Corporis in mollitia', 'customer', '0000-00-00 00:00:00', '2024-04-08 06:28:24'),
(6, 'Hanah', 'Mae', 'admin@gmail.com', '$2y$10$7nSx7zxY4LL2xe/lNYLBfOVneEZ2Qe4bo4ZyERBja9H.5ZgAtOq1e', 0, NULL, 'admin', '2024-04-08 06:31:38', '2024-04-08 15:39:11'),
(7, 'Wynne', 'Aguilar', 'kijom@mailinator.com', '$2y$10$Wq9/HipumX/PoE8PXOyZAeDzttfTGqBj8jUlb84uwN55dQFOEpBd6', 0, 'Itaque eum qui et co', 'customer', '0000-00-00 00:00:00', '2024-04-08 06:35:48'),
(8, 'Aileen', 'Carrillo', 'bihydosa@mailinator.com', '$2y$10$G3Cb/MYaDO4U5WRViZVfAuKS8YlhdCY.q8OPD9ytUP7J3bR/.HNBK', 0, 'Duis sit iusto veni', 'customer', '0000-00-00 00:00:00', '2024-04-08 06:37:11'),
(9, 'Sandra', 'Allen', 'cycyn@mailinator.com', '$2y$10$9hytnyX1RMAyz8feUXRc1.Q2wM2QJuQJ9iEcDwC/IqWlPBk6Nlyui', 0, 'Culpa quod non ad vi', 'customer', '2024-04-08 00:52:17', '2024-04-08 06:52:17'),
(10, 'Brenda', 'Ryan', 'gisoxen@mailinator.com', '$2y$10$1ddcmRoP0mM2hdutd5Vbe.YTiJxZe5vyIEOBTyzjGBc.pGdL7IF96', 975238956, 'Culpa reprehenderit ', 'customer', '2024-04-08 01:00:24', '2024-04-08 07:00:24'),
(11, 'Theodore', 'Sargent', 'zabi@mailinator.com', '$2y$10$tcjsYJxGkuSv2qozwgDBEeskcz1YmeT0jnIfAsgstdwcLoEiLGxzS', 262, 'Et atque nulla nihil', 'customer', '2024-04-08 01:22:17', '2024-04-08 07:22:17'),
(12, 'Deirdre', 'Beck', 'tiquf@mailinator.com', '$2y$10$OlymUF0ejfWuIN.f.2yqyOTTlTXYMPmvGb79TwRTS19rQeebG3eV6', 488, 'Error fugit volupta', 'customer', '2024-04-08 08:18:36', '2024-04-08 14:18:36'),
(13, 'Lulu', 'mae', 'lulu@gmail.com', '$2y$10$Y.Vr9s599HSDw6jiorKtN.y1nn8sZJksuxxCt9k7IH2QyhoKNuGvq', 111, 'aa', 'customer', '2024-04-08 09:49:22', '2024-04-08 15:49:22');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `carts`
--
ALTER TABLE `carts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cart_items`
--
ALTER TABLE `cart_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
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
-- AUTO_INCREMENT for table `carts`
--
ALTER TABLE `carts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cart_items`
--
ALTER TABLE `cart_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
