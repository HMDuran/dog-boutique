-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 24, 2025 at 01:29 PM
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
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
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
(2, 'Apparel'),
(4, 'Bowl'),
(6, 'Collars and Leashes'),
(7, 'Beds'),
(9, 'Toys'),
(38, 'Gromming Kit');

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

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `status`, `total_amount`, `created_at`, `updated_at`) VALUES
(587800, 16, 'shipped', 7464.00, '2024-05-07 02:20:24', '2024-05-07 11:53:55'),
(587801, 16, 'processing', 1964.00, '2024-05-07 02:21:07', '2024-05-08 11:47:40'),
(587805, 13, 'pending', 1964.00, '2024-05-08 05:45:13', '2024-05-14 13:20:42'),
(587808, 16, 'delivered', 2464.00, '2024-07-05 21:22:57', '2024-07-06 03:24:01'),
(587809, 16, 'pending', 2984.00, '2024-07-05 21:30:49', '2024-07-05 21:30:49'),
(587811, 16, 'pending', 154.00, '2024-07-05 21:50:25', '2024-07-05 21:50:25'),
(587812, 16, 'pending', 564.00, '2024-07-05 21:57:30', '2024-07-05 21:57:30');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `total_price` decimal(10,2) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `quantity`, `total_price`, `created_at`, `updated_at`) VALUES
(75, 587800, 53, 5, 1400.00, '2024-05-07 02:20:24', '2024-05-07 02:20:24'),
(76, 587800, 105, 5, 6000.00, '2024-05-07 02:20:24', '2024-05-07 02:20:24'),
(77, 587801, 54, 5, 1900.00, '2024-05-07 02:21:07', '2024-05-07 02:21:07'),
(82, 587805, 54, 5, 1900.00, '2024-05-08 05:45:13', '2024-05-08 05:45:13'),
(85, 587808, 52, 4, 2400.00, '2024-07-05 21:22:57', '2024-07-05 21:22:57'),
(86, 587809, 52, 3, 1800.00, '2024-07-05 21:30:49', '2024-07-05 21:30:49'),
(87, 587809, 53, 4, 1120.00, '2024-07-05 21:30:49', '2024-07-05 21:30:49'),
(89, 587811, 160, 2, 90.00, '2024-07-05 21:50:25', '2024-07-05 21:50:25'),
(90, 587812, 51, 1, 500.00, '2024-07-05 21:57:30', '2024-07-05 21:57:30');

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `otp` varchar(6) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
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
(51, 'Warm Clothes', '../../uploads/warm-clothes.jpg', 'Lightweight and warm vest for small to medium-sized dogs', 500.00, 99, 2, '2024-04-18 05:49:03', '2024-07-06 03:57:30'),
(52, 'Leather Dog Collar	', '../../uploads/leather-collar.jpg', 'Handcrafted leather collar with brass hardware	', 600.00, 93, 6, '2024-04-18 05:51:35', '2024-07-06 03:30:49'),
(53, 'Rubber Dumbbell Toy', '../../uploads/dumbbell-dog-toy.jpg', 'Rubber dumbbell-shaped toy for fetching and chewing	', 280.00, 46, 9, '2024-04-18 05:54:30', '2024-07-06 03:30:49'),
(54, 'Slicker Brush ', '../../uploads/slicker-brush.jpg', 'Keep your dog coat smooth, shiny, and tangle-free. ', 380.00, 90, 38, '2024-04-18 05:59:20', '2024-05-08 11:45:13'),
(105, 'Grey Donut Bed', '../../uploads/greyDonutBed.jpg', 'Luxuriously soft bed for small to medium-sized dogs', 1200.00, 85, 7, '2024-04-28 08:25:03', '2024-05-07 16:00:30'),
(156, 'Stainless Steel Bowl', '../../uploads/dog-bowl-stainless-steel.jpg', 'Durable bowl suitable for both food and water', 350.00, 100, 4, '2024-05-17 05:47:22', '2024-05-17 11:47:22'),
(160, 'yema', '../../uploads/Tri-fold-Pet-Stroller-Detachable-Carrier-Gray.jpg', 'aa', 45.00, 48, 9, '2024-07-05 21:48:50', '2024-07-06 03:50:25');

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
  `phone_number` varchar(255) NOT NULL,
  `delivery_address` varchar(255) DEFAULT NULL,
  `role` varchar(255) DEFAULT 'customer',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `email`, `password`, `phone_number`, `delivery_address`, `role`, `created_at`, `updated_at`) VALUES
(6, 'Hanah', 'Mae', 'admin@gmail.com', '$2y$10$hZouxrhv7xzpHfe497kobeR.MP4jKmDqHmA3wqHPDq56D4O/VqB1C', '0', NULL, 'admin', '2024-04-08 06:31:38', '2025-03-23 06:37:42');

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
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_order_items_order_id` (`order_id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_user_id` (`user_id`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=202;

--
-- AUTO_INCREMENT for table `cart_items`
--
ALTER TABLE `cart_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=587813;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=91;

--
-- AUTO_INCREMENT for table `password_resets`
--
ALTER TABLE `password_resets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=161;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `fk_order_items_order_id` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`);

--
-- Constraints for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD CONSTRAINT `fk_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
