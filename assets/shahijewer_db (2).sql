-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: May 14, 2026 at 06:38 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `shahijewer_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `appointments`
--

CREATE TABLE `appointments` (
  `appointment_id` int(11) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `appointment_date` date NOT NULL,
  `appointment_time` time NOT NULL,
  `message` text DEFAULT NULL,
  `status` enum('pending','confirmed','cancelled') DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `appointments`
--

INSERT INTO `appointments` (`appointment_id`, `full_name`, `email`, `phone`, `appointment_date`, `appointment_time`, `message`, `status`, `created_at`) VALUES
(1, 'sandy', 'sandy@gmail.com', '234-432-9090', '2026-03-14', '12:00:00', 'i want see bridal collection', 'pending', '2026-02-19 00:13:09'),
(2, 'Komal Sharma', 'komalsharma251@gmail.com', '4379877028', '2026-03-06', '10:00:00', 'need to finalize my custum bridal jewellry', 'pending', '2026-02-19 22:34:01'),
(3, 'rehaan', 'rehaanshori@gmail.com', '432-789-1212', '2026-03-13', '12:00:00', 'jewellery', 'pending', '2026-02-20 23:13:42'),
(4, 'komal', 'komalsharma251@gmail.com', '234-567-7878', '2026-03-26', '10:00:00', 'bridal jewellery', 'pending', '2026-03-06 17:01:59'),
(5, 'George', 'george@gmail.com', '123-456-6565', '2026-03-27', '12:00:00', 'i want to customize some brodal sets', 'pending', '2026-03-24 16:04:42'),
(6, 'reema bagga', 'reema221093@gmail.com', '4379877028', '2026-05-15', '12:00:00', 'hii', 'pending', '2026-05-08 22:09:11'),
(7, 'Komal Sharma', 'komalsharma251@gmail.com', '4379877028', '2026-05-22', '10:00:00', 'hiii its urgent', 'pending', '2026-05-08 22:49:28'),
(8, 'Komal Sharma', 'komalsharma251@gmail.com', '654-987-9898', '2026-05-16', '14:00:00', 'bridal jewellery order', 'pending', '2026-05-14 16:03:52');

-- --------------------------------------------------------

--
-- Table structure for table `carts`
--

CREATE TABLE `carts` (
  `cart_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `carts`
--

INSERT INTO `carts` (`cart_id`, `user_id`, `product_id`, `quantity`, `created_at`, `updated_at`) VALUES
(11, 10, 1, 1, '2026-02-19 23:27:25', '2026-03-06 17:04:57'),
(13, 10, 2, 2, '2026-02-19 23:27:31', '2026-02-20 23:12:05'),
(23, 12, 13, 2, '2026-05-08 22:08:00', '2026-05-09 00:55:41'),
(24, 12, 17, 2, '2026-05-08 22:50:26', '2026-05-09 00:55:49'),
(26, 12, 20, 2, '2026-05-14 16:06:31', '2026-05-14 16:06:31');

-- --------------------------------------------------------

--
-- Table structure for table `cart_items`
--

CREATE TABLE `cart_items` (
  `cart_item_id` int(11) NOT NULL,
  `cart_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `category_id` int(11) NOT NULL,
  `category_name` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `image_url` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`category_id`, `category_name`, `created_at`, `image_url`, `description`) VALUES
(1, 'Necklaces', '2026-02-07 20:36:23', 'assets/images/necklace6.png', 'Elegant handcrafted necklaces designed for bridal and festive wear.'),
(2, 'Earrings', '2026-02-07 20:36:23', 'assets/images/earring6.png', 'Premium earrings blending traditional Indian artistry with modern luxury.'),
(3, 'Bangles', '2026-02-07 20:36:23', 'assets/images/bangle5.png', 'Explore handcrafted bangles designed for weddings, festivals, and everyday elegance.'),
(4, 'Rings', '2026-02-07 20:36:23', 'assets/images/ring2.png', 'Stylish rings symbolizing love, elegance, and timeless beauty.'),
(5, 'Paranda', '2026-02-07 20:36:23', 'assets/images/paranda2.png', 'Traditional Punjabi Paranda accessories celebrating cultural beauty and heritage.'),
(7, 'Patiala shahi punjabi jutti', '2026-02-18 01:57:10', 'assets/images/punjabijutti1.png', 'Traditional Punjabi Jutti crafted with elegance, comfort, and rich cultural heritage. Each pair is beautifully designed with intricate embroidery and detailed craftsmanship, reflecting the vibrant spirit of Punjab. Perfect for weddings, festive occasions. ');

-- --------------------------------------------------------

--
-- Table structure for table `contact_messages`
--

CREATE TABLE `contact_messages` (
  `message_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `phone` varchar(30) DEFAULT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contact_messages`
--

INSERT INTO `contact_messages` (`message_id`, `name`, `email`, `phone`, `message`, `created_at`) VALUES
(1, 'rehaan shori', 'rehaanshori@gmail.com', '4379877028', 'hello, i want to book an appointment for custom jewellery', '2026-05-01 16:41:42'),
(2, 'reema bagga', 'reema221093@gmail.com', '4379877028', 'hello', '2026-05-02 00:42:53'),
(3, 'Kapil Sharma', 'komalsharma251@gmail.com', '543-654-9898', 'hi can we book an appointment regarding custom jewellery', '2026-05-09 00:27:48'),
(4, 'reema bagga', 'reema221093@gmail.com', '4379877028', 'hiiii', '2026-05-09 00:46:47'),
(5, 'Komal Sharma', 'komalsharma251@gmail.com', '234-876-9898', 'i need to book an appointment for custom jewellery', '2026-05-09 01:33:43');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `order_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` enum('pending','processing','shipped','delivered','cancelled') DEFAULT 'pending',
  `total_amount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `shipping_address` varchar(255) DEFAULT NULL,
  `shipping_city` varchar(100) DEFAULT NULL,
  `shipping_postal_code` varchar(20) DEFAULT NULL,
  `shipping_country` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `user_id`, `order_date`, `status`, `total_amount`, `shipping_address`, `shipping_city`, `shipping_postal_code`, `shipping_country`) VALUES
(1, 1, '2026-02-18 02:06:48', 'shipped', 250.00, '123 Queen Street', 'Brampton', 'L6X 1A1', 'Canada'),
(2, 7, '2026-02-18 02:30:50', 'delivered', 150.00, '123 Maple Street', 'Toronto', 'M4B1B3', 'Canada'),
(3, 1, '2026-02-18 02:30:50', 'delivered', 250.00, '123 Maple Street', 'Toronto', 'M4B1B3', 'Canada'),
(4, 8, '2026-02-18 02:30:50', 'shipped', 120.00, '456 Oak Avenue', 'Brampton', 'L6T1A2', 'Canada'),
(5, 9, '2026-02-18 02:30:50', 'processing', 300.00, '789 Pine Road', 'Mississauga', 'L5N2X3', 'Canada'),
(6, 1, '2026-05-01 22:04:14', 'processing', 3207.45, '26 homeland court', 'bramton', 'L6S 1R8', 'Canada'),
(7, 1, '2026-05-01 22:17:59', 'delivered', 564.44, '26 homeland court mississauga', 'bramton', 'L6S 1R8', 'Canada'),
(8, 1, '2026-05-02 06:43:52', 'processing', 564.44, '26 homeland court', 'bramton', 'L6S 1R8', 'Canada'),
(9, 1, '2026-05-07 03:39:29', 'processing', 112.99, '26 homeland court', 'bramton', 'L6S 1R8', 'Canada'),
(10, 12, '2026-05-07 22:01:34', 'processing', 56.50, '26 homeland court', 'bramton', 'L6S 1R8', 'Canada'),
(11, 12, '2026-05-07 22:16:23', 'processing', 609.64, '28 homeland court', 'bramton', 'L6S 1R8', 'Canada'),
(12, 1, '2026-05-08 02:32:23', 'processing', 90.97, '27 homeland court', 'bramton', 'L6S 1R8', 'Canada'),
(13, 12, '2026-05-09 00:29:08', 'cancelled', 108.47, '22 home court', 'bramton', 'L6S 1R8', 'Canada'),
(14, 12, '2026-05-09 02:52:06', 'processing', 158.20, '66 homeland court', 'bramton', 'L6S 1R8', 'Canada'),
(15, 12, '2026-05-09 02:59:18', 'delivered', 112.99, '66 homeland court', 'bramton', 'L6S 1R8', 'Canada'),
(16, 12, '2026-05-09 03:02:52', 'shipped', 225.99, '64 ravenswood crt', 'bramton', 'L6S 1R8', 'Canada'),
(17, 12, '2026-05-09 04:37:07', 'shipped', 113.00, '21 homeland court', 'bramton', 'L6S 1R8', 'Canada'),
(18, 12, '2026-05-09 06:42:43', 'delivered', 536.75, '96 homeland court', 'bramton', 'L6S 1R8', 'Canada'),
(19, 12, '2026-05-09 06:46:13', 'delivered', 113.00, '26 homeland court', 'bramton', 'L6S 1R8', 'Canada'),
(20, 12, '2026-05-09 07:31:24', 'shipped', 112.98, '26 homeland court', 'bramton', 'L6S 1R8', 'Canada');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `order_item_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`order_item_id`, `order_id`, `product_id`, `quantity`, `price`) VALUES
(1, 1, 2, 2, 49.99),
(2, 1, 3, 1, 150.00),
(3, 1, 1, 1, 200.00),
(4, 1, 2, 1, 50.00),
(5, 2, 2, 1, 150.00),
(6, 3, 1, 1, 200.00),
(7, 3, 3, 1, 50.00),
(8, 4, 3, 1, 120.00),
(9, 5, 1, 1, 200.00),
(10, 5, 2, 1, 100.00),
(11, 6, 12, 3, 99.99),
(12, 6, 13, 3, 499.50),
(13, 6, 14, 1, 299.99),
(14, 6, 18, 1, 40.00),
(15, 6, 16, 1, 699.99),
(16, 7, 13, 1, 499.50),
(17, 8, 13, 1, 499.50),
(18, 9, 12, 1, 99.99),
(19, 10, 11, 1, 50.00),
(20, 11, 13, 1, 499.50),
(21, 11, 18, 1, 40.00),
(23, 13, 20, 1, 95.99),
(24, 14, 11, 2, 50.00),
(25, 14, 18, 1, 40.00),
(26, 15, 12, 1, 99.99),
(27, 16, 17, 1, 199.99),
(28, 17, 11, 2, 50.00),
(29, 18, 5, 2, 200.00),
(30, 18, 10, 1, 75.00),
(31, 19, 11, 2, 50.00),
(32, 20, 2, 2, 49.99);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `product_id` int(11) NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  `product_name` varchar(150) NOT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `stock_quantity` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `image_url` varchar(255) DEFAULT NULL,
  `is_featured` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `category_id`, `product_name`, `description`, `price`, `stock_quantity`, `image_url`, `is_featured`, `created_at`) VALUES
(1, 1, 'Mossonite collection', 'Modern mossonite necklace  for parties.', 199.99, 10, 'assets/images/necklace4.png', 1, '2026-02-07 20:41:35'),
(2, 2, 'Jhumka Earrings', 'Classic Indian jhumka earrings.', 49.99, 25, 'assets/images/earring1.png', 1, '2026-02-07 20:41:35'),
(3, 3, 'Bridal Bangles Set', 'Red bridal bangles set.', 99.99, 15, 'assets/images/necklace9.png', 0, '2026-02-07 20:41:35'),
(5, 1, 'Traditional Heritage Jewelley', 'Traditional Heritage Jewelley', 200.00, 23, 'assets/images/necklace5.png', 0, '2026-02-16 21:12:47'),
(6, 1, 'AD Necklaces', 'American Diamond necklaces are available', 200.00, 70, '/assets/images/necklace7.png', 1, '2026-02-16 21:15:42'),
(8, 1, 'Necklace', 'Elegant traditional gold Necklace perfect for weddings.', 120.00, 10, 'assets/images/necklace1.png', 0, '2026-02-19 23:59:07'),
(10, 1, 'Necklace', 'Necklace for festive occasions.', 75.00, 20, '/assets/images/necklace8.png', 0, '2026-02-19 23:59:07'),
(11, 1, 'necklace', 'kundan set', 50.00, 20, '/assets/images/necklace6.png', 0, '2026-02-20 13:10:24'),
(12, 1, 'Gold Bridal Necklace Set', 'Elegant handcrafted bridal necklace set with intricate traditional design.', 99.99, 10, 'assets/images/necklace2.png', 1, '2026-02-20 17:34:30'),
(13, 1, 'Traditional Piece', 'Beautiful piece for weddings and festive occasions.', 499.50, 25, 'assets/images/necklace3.png', 1, '2026-02-20 17:34:30'),
(14, 1, 'Diamond Stone', 'Minimal and classy for elegance.', 299.99, 40, 'assets/images/necklace11.png', 0, '2026-02-20 17:34:30'),
(15, 1, 'Luxury Pearl Necklace', 'Premium freshwater pearl necklace with gold finish clasp.', 349.00, 18, 'assets/images/necklace9.png', 0, '2026-02-20 17:34:30'),
(16, 3, 'Gold Engagement Ring', 'Elegant gold engagement ring with sparkling center stone.', 599.99, 15, 'assets/images/ring1.png', 1, '2026-02-20 17:34:30'),
(17, 1, 'Stylish Design', 'Stylish set with modern charm design.', 199.99, 30, 'assets/images/necklace11.png', 0, '2026-02-20 17:34:30'),
(18, 5, 'Punjabi Paranda', 'Elegant handcrafted Paranda with intricate traditional design.', 40.00, 10, 'assets/images/paranda1.png', 1, '2026-02-20 17:41:46'),
(20, 1, 'Modern Necklace', 'it\'s the fusion of modern and traditional heritage collection.', 95.99, 50, '/assets/images/necklace8.png', 0, '2026-05-08 16:28:10'),
(21, 1, 'necklace', 'regular wear necklace set', 265.00, 30, '/assets/images/necklace7.png', 1, '2026-05-08 22:45:57'),
(23, NULL, 'necklace', NULL, 345.00, 0, 'assets/images/necklace10.png', 0, '2026-05-09 01:36:18');

-- --------------------------------------------------------

--
-- Table structure for table `promo_slides`
--

CREATE TABLE `promo_slides` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `button_text` varchar(100) NOT NULL,
  `link` varchar(255) NOT NULL DEFAULT '#',
  `image_url` varchar(255) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `promo_slides`
--

INSERT INTO `promo_slides` (`id`, `title`, `description`, `button_text`, `link`, `image_url`, `is_active`, `created_at`) VALUES
(1, 'Elegance Beyond Time', 'Discover handcrafted jewellery inspired by India’s royal heritage. Each piece tells a story of tradition, artistry, and timeless beauty.', 'Explore Collection', '#', 'assets/images/necklace9.png', 1, '2026-02-19 17:35:01'),
(2, 'Royal Gold Necklaces', 'Handpicked luxury necklaces that speak elegance and sophistication. Perfect for every occasion.', 'Shop Necklaces', '#', 'assets/images/necklace10.png', 1, '2026-02-19 17:35:01'),
(3, 'Timeless Earrings', 'Exquisite handcrafted earrings that combine tradition and modern elegance. Shine in every moment.', 'Shop Earrings', '#', 'assets/images/earring3.png', 1, '2026-02-19 17:35:01');

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `review_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `customer_name` varchar(100) NOT NULL,
  `rating` tinyint(4) NOT NULL CHECK (`rating` between 1 and 5),
  `review_text` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`review_id`, `product_id`, `user_id`, `customer_name`, `rating`, `review_text`, `created_at`) VALUES
(1, 9, 12, 'samaira', 5, 'really good customer service provided by komal', '2026-05-07 18:46:59'),
(2, 20, 12, 'samaira', 5, 'excellent collection', '2026-05-08 18:28:10'),
(4, 16, 12, 'samaira', 5, 'very premium quality', '2026-05-09 01:33:00');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `role` enum('admin','customer') DEFAULT 'customer',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `full_name`, `email`, `password_hash`, `role`, `created_at`) VALUES
(1, 'Komal Sharma', 'admin@shahizewer.com', '$2y$10$lZ3mfgV3yFSNaqS3K7j0FOnF2iCZ3q6gRV7Wucgv1GaAcsGmboXli', 'admin', '2026-02-07 20:44:03'),
(3, 'rehaan shori', 'rehanshori@gmail.com', '$2y$10$mTDMr4ce.WCNklyMjJaOPO.u2h9SKo1xPGxTKFuxjw/hepAXxzwcS', 'customer', '2026-02-08 03:35:41'),
(5, 'ekjot', 'ekjot@gmail.com', '$2y$10$PSyb.hFhJU5VnXtJP.6u8eC5bYBN1dPIk3n2.3fmzkRhh1tateCXW', 'customer', '2026-02-08 03:40:52'),
(6, 'navjot shori', 'navjot@yahoo.com', '$2y$10$0lyvbsvFYT/0wv/wNazfc.mKp.JM.Q41xsWJKIDwXRUh0TmiR7fE6', 'customer', '2026-02-10 00:36:54'),
(7, 'Alice Johnson', 'alice@example.com', 'hashedpassword1', 'customer', '2026-02-18 02:29:09'),
(8, 'Bob Smith', 'bob@example.com', 'hashedpassword2', 'customer', '2026-02-18 02:29:09'),
(9, 'Charlie Brown', 'charlie@example.com', 'hashedpassword3', 'customer', '2026-02-18 02:29:09'),
(10, 'ekjot shori', 'ekjotshori@gmail.com', '$2y$10$dUiKyiReygpK3ZNDQUEHdutN6hTOEgGY/BO5dBDBNNxSAEJHcv2FC', 'customer', '2026-02-19 19:30:42'),
(12, 'samaira', 'samaira@gmail.com', '$2y$10$0MFodc6Ay5l/GHVl8KTWXe9G3NP6UOrSAzb1yncQpAgBAr6VuIEvS', 'customer', '2026-05-07 15:44:50');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `appointments`
--
ALTER TABLE `appointments`
  ADD PRIMARY KEY (`appointment_id`);

--
-- Indexes for table `carts`
--
ALTER TABLE `carts`
  ADD PRIMARY KEY (`cart_id`),
  ADD UNIQUE KEY `user_product_unique` (`user_id`,`product_id`);

--
-- Indexes for table `cart_items`
--
ALTER TABLE `cart_items`
  ADD PRIMARY KEY (`cart_item_id`),
  ADD KEY `cart_id` (`cart_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`category_id`),
  ADD UNIQUE KEY `category_name` (`category_name`);

--
-- Indexes for table `contact_messages`
--
ALTER TABLE `contact_messages`
  ADD PRIMARY KEY (`message_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`order_item_id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`),
  ADD KEY `fk_category` (`category_id`);

--
-- Indexes for table `promo_slides`
--
ALTER TABLE `promo_slides`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`review_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `appointments`
--
ALTER TABLE `appointments`
  MODIFY `appointment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `carts`
--
ALTER TABLE `carts`
  MODIFY `cart_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `cart_items`
--
ALTER TABLE `cart_items`
  MODIFY `cart_item_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `contact_messages`
--
ALTER TABLE `contact_messages`
  MODIFY `message_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `order_item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `promo_slides`
--
ALTER TABLE `promo_slides`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `review_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `carts`
--
ALTER TABLE `carts`
  ADD CONSTRAINT `carts_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `cart_items`
--
ALTER TABLE `cart_items`
  ADD CONSTRAINT `cart_items_ibfk_1` FOREIGN KEY (`cart_id`) REFERENCES `carts` (`cart_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `cart_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`) ON DELETE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`) ON DELETE CASCADE;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `fk_category` FOREIGN KEY (`category_id`) REFERENCES `categories` (`category_id`) ON DELETE SET NULL,
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`category_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
