-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 18, 2026 at 02:15 PM
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
-- Database: `aksara_lokal`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `icon_class` varchar(100) DEFAULT 'fa-box'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `icon_class`) VALUES
(1, 'Keramik', 'fa-mug-hot'),
(2, 'Tenun & Tekstil', 'fa-scroll'),
(3, 'Ukiran Kayu', 'fa-tree'),
(4, 'Perhiasan', 'fa-gem'),
(5, 'Anyaman', 'fa-basket-shopping'),
(6, 'Batik', 'fa-palette');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(10) UNSIGNED NOT NULL,
  `buyer_id` int(10) UNSIGNED NOT NULL,
  `total_amount` decimal(12,2) NOT NULL,
  `status` enum('pending','confirmed','shipped','delivered','cancelled') NOT NULL DEFAULT 'pending',
  `payment_method` varchar(50) DEFAULT 'bank_transfer',
  `payment_proof` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `buyer_id`, `total_amount`, `status`, `payment_method`, `payment_proof`, `created_at`) VALUES
(1, 4, 770000.00, 'delivered', 'bank_transfer', 'proof_1.jpg', '2026-03-07 10:30:00'),
(2, 5, 1250000.00, 'shipped', 'bank_transfer', 'proof_2.jpg', '2026-03-08 14:00:00'),
(3, 4, 890000.00, 'confirmed', 'bank_transfer', 'proof_3.jpg', '2026-03-09 09:15:00'),
(4, 6, 640000.00, 'pending', 'bank_transfer', NULL, '2026-03-10 16:45:00'),
(5, 5, 450000.00, 'delivered', 'bank_transfer', 'proof_5.jpg', '2026-03-11 11:00:00'),
(6, 4, 355000.00, 'shipped', 'bank_transfer', 'proof_6.jpg', '2026-03-12 08:30:00'),
(7, 6, 1570000.00, 'shipped', 'bank_transfer', NULL, '2026-03-13 07:00:00'),
(8, 4, 1362000.00, 'pending', 'bank_transfer', NULL, '2026-03-18 00:57:01'),
(9, 7, 120000.00, 'shipped', 'bank_transfer', NULL, '2026-03-18 10:12:57'),
(10, 7, 1362000.00, 'shipped', 'bank_transfer', 'proof_1773805370_69ba1f3a4ea66.png', '2026-03-18 10:42:50'),
(11, 12, 1112000.00, 'pending', 'bank_transfer', NULL, '2026-03-18 13:21:01'),
(12, 12, 147000.00, 'pending', 'bank_transfer', NULL, '2026-03-18 13:21:24'),
(13, 7, 112000.00, 'pending', 'bank_transfer', NULL, '2026-03-18 18:00:12'),
(14, 7, 201000.00, 'pending', 'bank_transfer', NULL, '2026-03-18 19:13:11');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` int(10) UNSIGNED NOT NULL,
  `order_id` int(10) UNSIGNED NOT NULL,
  `product_id` int(10) UNSIGNED NOT NULL,
  `quantity` int(10) UNSIGNED NOT NULL DEFAULT 1,
  `unit_price` decimal(12,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `quantity`, `unit_price`) VALUES
(1, 1, 1, 1, 450000.00),
(2, 1, 4, 1, 320000.00),
(3, 2, 2, 1, 1250000.00),
(4, 3, 5, 1, 890000.00),
(5, 4, 4, 2, 320000.00),
(6, 5, 3, 1, 450000.00),
(7, 6, 6, 1, 180000.00),
(8, 6, 8, 1, 175000.00),
(9, 7, 2, 1, 1250000.00),
(10, 7, 4, 1, 320000.00),
(11, 8, 2, 1, 1250000.00),
(12, 9, 2, 1, 100000.00),
(13, 10, 2, 1, 1250000.00),
(14, 11, 14, 1, 1250000.00),
(15, 12, 18, 1, 125000.00),
(16, 13, 14, 1, 1250000.00),
(17, 14, 8, 1, 175000.00);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(10) UNSIGNED NOT NULL,
  `seller_id` int(10) UNSIGNED NOT NULL,
  `name` varchar(200) NOT NULL,
  `description` text NOT NULL,
  `price` decimal(12,2) NOT NULL,
  `stock` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `category_id` int(10) UNSIGNED NOT NULL,
  `image` varchar(255) DEFAULT 'default.jpg',
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `flash_sale_price` decimal(12,2) DEFAULT NULL,
  `flash_sale_end` datetime DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `seller_id`, `name`, `description`, `price`, `stock`, `category_id`, `image`, `is_active`, `flash_sale_price`, `flash_sale_end`, `created_at`) VALUES
(1, 2, 'Vas Keramik Bali Earth-Woven', 'Hand-thrown by master artisan I Wayan Sudarta. Each piece is a dialogue between the clay and the coastal winds of our local studio. The warm taupe glaze is achieved through a 48-hour slow-fire process.', 450000.00, 4, 1, 'product_1.jpg', 1, NULL, NULL, '2026-03-13 12:47:06'),
(2, 2, 'Ukiran Kayu Suar Totem', 'Carved from sustainably-sourced suar wood in Mas village, Ubud. This totem represents the harmony between earth and sky in Balinese cosmology.', 1250000.00, 3, 3, 'product_2.jpg', 1, NULL, NULL, '2026-03-13 12:47:06'),
(3, 3, 'Tenun Lombok Basket', 'Handwoven rattan basket from Lombok artisans using traditional techniques passed down through generations. Perfect for home decor or storage.', 450000.00, 8, 5, 'product_3.jpg', 1, NULL, NULL, '2026-03-13 12:47:06'),
(4, 3, 'Kala Ceramic Vase', 'A contemporary take on Javanese pottery. The minimalist form is complemented by a subtle earth-tone glaze that catches light beautifully.', 320000.00, 12, 1, 'product_4.jpg', 1, NULL, NULL, '2026-03-13 12:47:06'),
(5, 3, 'Silk Batik Scarf', 'Premium silk scarf featuring traditional Solo batik motifs. Each piece is hand-drawn using the canting technique, taking up to 2 weeks to complete.', 890000.00, 6, 6, 'product_5.jpg', 1, 650000.00, '2026-03-15 23:59:59', '2026-03-13 12:47:06'),
(6, 2, 'Sandstone Mini Dish', 'A delicate sandstone dish perfect for jewelry or small offerings. Hand-carved and polished in Ubud.', 180000.00, 15, 1, 'product_6.jpg', 1, NULL, NULL, '2026-03-13 12:47:06'),
(7, 2, 'Stone Incense Burner', 'Volcanic stone incense burner from Bali. The porous material absorbs and slowly releases the fragrance.', 240000.00, 10, 1, 'product_7.jpg', 1, NULL, NULL, '2026-03-13 12:47:06'),
(8, 3, 'Batik Cushion Cover', 'Hand-stamped batik cushion cover from Pekalongan. Made with natural dyes and premium cotton fabric.', 175000.00, 19, 6, 'product_8.jpg', 1, NULL, NULL, '2026-03-13 12:47:06'),
(10, 2, 'Keranjang Anyaman Rotan', 'Handmade rattan storage basket perfect for minimal interiors.', 250000.00, 10, 5, 'dummy_rattan_basket.png', 1, 100000.00, '2026-03-27 18:50:00', '2026-03-18 13:15:25'),
(11, 3, 'Kemeja Batik Pria Premium', 'Premium hand-drawn Indonesian Men\'s Batik Shirt.', 550000.00, 5, 6, 'dummy_batik_shirt.png', 1, NULL, NULL, '2026-03-18 13:15:25'),
(12, 2, 'Set Cangkir Teh Tanah Liat', 'Rustic handmade clay tea cup set by local potters.', 150000.00, 15, 1, 'dummy_clay_teaset.png', 1, NULL, NULL, '2026-03-18 13:15:25'),
(13, 3, 'Kalung Mutiara Lombok', 'Elegant South Sea pearl necklace from the waters of Lombok.', 2450000.00, 2, 4, 'dummy_pearl_necklace.png', 1, 1000000.00, '2026-03-18 18:46:00', '2026-03-18 13:15:25'),
(14, 2, 'Kain Tenun Sumba', 'Traditional Sumba woven fabric with elegant horse motifs.', 1250000.00, 1, 2, 'dummy_sumba_tenun.png', 1, 100000.00, '2026-03-26 18:49:00', '2026-03-18 13:15:25'),
(15, 3, 'Pajangan Ukiran Kayu Jepara', 'Detailed Jepara wood carving wall decor.', 850000.00, 4, 3, 'dummy_wood_carving.png', 1, NULL, NULL, '2026-03-18 13:15:25'),
(16, 2, 'Topi Bambu Anyaman', 'Traditional woven bamboo hat for outdoor aesthetic.', 85000.00, 20, 5, 'dummy_bamboo_hat.png', 1, NULL, NULL, '2026-03-18 13:15:25'),
(17, 3, 'Kain Batik Pekalongan', 'Premium Pekalongan batik fabric folded elegantly.', 350000.00, 12, 6, 'dummy_batik_fabric.png', 1, NULL, NULL, '2026-03-18 13:15:25'),
(18, 2, 'Mangkuk Keramik Hias', 'Decorative handmade clay ceramic bowl.', 125000.00, 7, 1, 'dummy_ceramic_bowl.png', 1, NULL, NULL, '2026-03-18 13:15:25'),
(19, 3, 'Gelang Perak Kotagede', 'Traditional Kotagede burnt silver bracelet.', 450000.00, 6, 4, 'dummy_silver_bracelet.png', 1, NULL, NULL, '2026-03-18 13:15:25');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `role` enum('admin','seller','buyer') NOT NULL DEFAULT 'buyer',
  `address` text DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `email`, `role`, `address`, `phone`, `created_at`) VALUES
(1, 'admin', '$2y$10$iz1uAFssbDrHgJwsY/YIQOKWtRBfgkzsrwTF4I9PiO6kTHafXio5.', 'admin@aksaralokal.id', 'admin', 'Jl. Sudirman No. 1, Jakarta', '081234567890', '2025-01-01 08:00:00'),
(2, 'seller_bali', '$2y$10$iz1uAFssbDrHgJwsY/YIQOKWtRBfgkzsrwTF4I9PiO6kTHafXio5.', 'wayan@aksaralokal.id', 'seller', 'Jl. Raya Mas, Ubud, Bali', '081234567891', '2025-01-15 10:00:00'),
(3, 'seller_jogja', '$2y$10$iz1uAFssbDrHgJwsY/YIQOKWtRBfgkzsrwTF4I9PiO6kTHafXio5.', 'rini@aksaralokal.id', 'seller', 'Jl. Malioboro No. 45, Yogyakarta', '081234567892', '2025-02-01 09:00:00'),
(4, 'buyer_andi', '$2y$10$iz1uAFssbDrHgJwsY/YIQOKWtRBfgkzsrwTF4I9PiO6kTHafXio5.', 'andi@email.com', 'buyer', 'Jl. Kemang Raya No. 12, Jakarta Selatan', '081234567893', '2025-03-01 11:00:00'),
(5, 'buyer_sari', '$2y$10$iz1uAFssbDrHgJwsY/YIQOKWtRBfgkzsrwTF4I9PiO6kTHafXio5.', 'sari@email.com', 'buyer', 'Jl. Diponegoro No. 88, Surabaya', '081234567894', '2025-03-10 14:00:00'),
(6, 'buyer_dewi', '$2y$10$iz1uAFssbDrHgJwsY/YIQOKWtRBfgkzsrwTF4I9PiO6kTHafXio5.', 'dewi@email.com', 'buyer', 'Jl. Ahmad Yani No. 55, Bandung', '081234567895', '2025-04-05 16:00:00'),
(7, 'ali', '$2y$10$hsapdO6Sm2gTFt0WHtKpQudRawZo4TS4avs.ALm1MuAvdZk5V8pk.', 'ala@gmail.com', 'buyer', 'Cikaret Bogor', '081310866862', '2026-03-18 10:12:49'),
(8, 'alistore', '$2y$10$M4jAHhHp1xGayAN49qMR9u4dkMhWA4p4Fpxpp2hmL9sICtNkrUoU.', 'alii@gmail.com', 'seller', '', '', '2026-03-18 12:55:07'),
(9, 'asd', '$2y$10$9An1uNWu2FdK/XZLyPunUuxOr.Sb69/WHRff3TG52cJUxRLWwolaO', 'asd@gmail.com', 'buyer', '', '', '2026-03-18 12:59:08'),
(10, 'asdda', '$2y$10$ejXAkZ2li7.cKqcs3neaoO1lYa4XEEsJ8ey.y5ASNoC5Z7OiFX3tq', 'asd@asks.c', 'buyer', '', '', '2026-03-18 12:59:42'),
(11, 'aksdmksa', '$2y$10$.1zrVMudzEqL4fMMrQ8P9.jCY1d3cA/ZCKmGHPkJQ6eilk8.6hI8W', 'as@asm.c', 'seller', '', '', '2026-03-18 13:04:04'),
(12, 'asdadsa', '$2y$10$XFADf.lDjduAnHPzFpd.K.WkeRN8Q2VVhKSpPJqyKNhFvaOzEmeIa', 'asdsd@fsa.c', 'buyer', '', '', '2026-03-18 13:04:31');

-- --------------------------------------------------------

--
-- Table structure for table `vouchers`
--

CREATE TABLE `vouchers` (
  `id` int(10) UNSIGNED NOT NULL,
  `code` varchar(50) NOT NULL,
  `discount_percent` int(10) UNSIGNED NOT NULL,
  `max_use` int(10) UNSIGNED NOT NULL DEFAULT 100,
  `used_count` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `expired_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `vouchers`
--

INSERT INTO `vouchers` (`id`, `code`, `discount_percent`, `max_use`, `used_count`, `expired_at`) VALUES
(1, 'AKSARA10', 10, 100, 5, '2026-06-30 23:59:59'),
(2, 'LOKAL20', 20, 50, 13, '2026-04-30 23:59:59'),
(3, 'ARTISAN15', 15, 200, 30, '2026-05-31 23:59:59'),
(4, 'NUSANTARA25', 25, 30, 28, '2026-03-31 23:59:59'),
(5, 'HERITAGE5', 5, 500, 100, '2026-12-31 23:59:59'),
(6, 'PSDM', 100, 1, 1, '2026-03-20 17:59:00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_buyer` (`buyer_id`),
  ADD KEY `idx_status` (`status`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_order` (`order_id`),
  ADD KEY `idx_product` (`product_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_seller` (`seller_id`),
  ADD KEY `idx_category` (`category_id`),
  ADD KEY `idx_active` (`is_active`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `idx_role` (`role`);

--
-- Indexes for table `vouchers`
--
ALTER TABLE `vouchers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `code` (`code`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `vouchers`
--
ALTER TABLE `vouchers`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `fk_order_buyer` FOREIGN KEY (`buyer_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `fk_oi_order` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_oi_product` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `fk_product_category` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_product_seller` FOREIGN KEY (`seller_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
