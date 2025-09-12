-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Sep 12, 2025 at 07:32 PM
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
-- Database: `box_stock_order`
--

-- --------------------------------------------------------

--
-- Table structure for table `capital`
--

CREATE TABLE `capital` (
  `capital_id` int(11) NOT NULL,
  `count_capital` decimal(10,2) NOT NULL,
  `slip_capital` varchar(300) NOT NULL,
  `date_time_ad` datetime NOT NULL,
  `adder_id` int(11) NOT NULL,
  `create_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `list_productsell`
--

CREATE TABLE `list_productsell` (
  `list_sellid` int(11) NOT NULL,
  `ordersell_id` int(15) NOT NULL,
  `productname` varchar(250) NOT NULL,
  `rate_customertype` decimal(10,2) NOT NULL,
  `type_custom` varchar(100) NOT NULL,
  `tatol_product` int(11) NOT NULL,
  `price_to_pay` decimal(10,2) NOT NULL,
  `create_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `orders_sell`
--

CREATE TABLE `orders_sell` (
  `id_ordersell` int(11) NOT NULL,
  `ordersell_name` varchar(200) NOT NULL,
  `is_totalprice` decimal(10,2) NOT NULL,
  `custome_name` varchar(250) NOT NULL,
  `tell_custome` varchar(30) NOT NULL,
  `date_time_sell` datetime NOT NULL,
  `shipping_note` text NOT NULL,
  `sender` varchar(200) NOT NULL,
  `tell_sender` varchar(15) NOT NULL,
  `location_send` text NOT NULL,
  `wages` decimal(10,2) NOT NULL,
  `reason` text NOT NULL,
  `slip_ordersell` varchar(200) NOT NULL,
  `count_totalpays` decimal(10,2) NOT NULL,
  `count_stuck` decimal(10,2) NOT NULL,
  `adder_id` int(11) NOT NULL,
  `create_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `order_box`
--

CREATE TABLE `order_box` (
  `order_id` int(11) NOT NULL,
  `order_name` varchar(300) NOT NULL,
  `slip_order` varchar(200) NOT NULL,
  `totalcost_order` decimal(10,2) NOT NULL,
  `count_order` int(11) NOT NULL,
  `id_adder` int(11) NOT NULL,
  `date_time_order` datetime NOT NULL,
  `create_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `order_box`
--

INSERT INTO `order_box` (`order_id`, `order_name`, `slip_order`, `totalcost_order`, `count_order`, `id_adder`, `date_time_order`, `create_at`) VALUES
(3, 'คำสั่งซื้อที่1', 'slip-orderimg_68a0b502ba8c1.jpg', 117500.00, 3, 1, '2025-08-16 23:44:00', '2025-08-16 23:45:10'),
(4, 'คำสั่งซื้อที่2', 'slip-ordersimg_68a0b62f4ff27.jpg', 144874.00, 3, 1, '2025-08-16 23:46:00', '2025-08-16 23:47:43'),
(5, 'คำสั่งซื้อที่3', 'img_68a1931d4d404.png', 1034.00, 1, 1, '2025-08-17 15:29:00', '2025-08-17 15:30:21'),
(6, 'คำสั่งซื้อที่4', 'img_68a1986dc1f0b.jpg', 33000.00, 2, 1, '2025-08-17 15:52:00', '2025-08-17 15:53:01'),
(7, 'คำสั่งซื้อที่5', 'img_68a739dcc93c2.png', 2000.00, 1, 1, '2025-08-21 22:22:00', '2025-08-21 22:23:08'),
(8, 'คำสั่งซื้อที่6', 'img_68a73a0dd4a7a.png', 14400.00, 1, 1, '2025-08-21 22:23:00', '2025-08-21 22:23:57'),
(9, 'คำสั่งซื้อที่7', 'img_68ac61d40e1db.png', 39100.00, 2, 1, '2025-08-25 20:12:00', '2025-08-25 20:15:00'),
(10, 'คำสั่งซื้อที่8', 'img_68aea2d7a53f8.png', 87710.00, 3, 1, '2025-08-27 13:15:00', '2025-08-27 13:16:55'),
(11, 'คำสั่งซื้อที่11', 'img_68b404fd0d4a4.png', 7600.00, 2, 1, '2025-08-31 15:16:00', '2025-08-31 15:17:01'),
(28, 'order_name344', 'img_68b7000200587.jpeg', 68900.00, 3, 1, '2025-09-02 20:34:00', '2025-09-02 20:36:30'),
(29, 'Z5SYJG1G5G', 'img_68bdc666e6bf4.jpg', 1000.00, 1, 1, '2025-09-08 00:51:00', '2025-09-08 00:52:38'),
(30, 'XHHFLWI76D', 'img_68bed29438eb3.jpg', 59525.00, 2, 1, '2025-09-08 19:56:00', '2025-09-08 19:56:52'),
(31, '4ET2BUCK1V', 'img_68c2971929d9e.jpg', 746.90, 1, 1, '2025-09-11 16:31:00', '2025-09-11 16:32:09');

-- --------------------------------------------------------

--
-- Table structure for table `rate_price`
--

CREATE TABLE `rate_price` (
  `rate_id` int(11) NOT NULL,
  `product_name` varchar(200) NOT NULL,
  `id_adder` int(11) NOT NULL,
  `price_custommer_vip` decimal(10,2) NOT NULL,
  `price_customer_frontstore` decimal(10,2) NOT NULL,
  `price_customer_deliver` decimal(10,2) NOT NULL,
  `price_customer_dealer` decimal(10,2) NOT NULL,
  `create_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `rate_price`
--

INSERT INTO `rate_price` (`rate_id`, `product_name`, `id_adder`, `price_custommer_vip`, `price_customer_frontstore`, `price_customer_deliver`, `price_customer_dealer`, `create_at`) VALUES
(9, 'ZZX V99', 1, 14.00, 15.50, 18.00, 16.00, '2025-09-01 21:02:01'),
(10, 'SSR7', 1, 17.00, 15.50, 19.50, 16.05, '2025-09-01 21:03:08'),
(11, 'BOX J7', 1, 14.00, 16.00, 21.05, 15.00, '2025-09-01 23:50:18'),
(12, 'BOX J8', 1, 14.00, 15.50, 20.50, 16.05, '2025-09-01 22:46:01'),
(13, 'BOX J8S', 1, 25.50, 25.00, 30.00, 26.00, '2025-09-01 22:47:51'),
(14, 'BOX S9', 1, 15.00, 15.50, 19.70, 16.00, '2025-09-01 22:48:41'),
(15, 'BOX Z4', 1, 13.00, 14.70, 17.50, 15.00, '2025-09-01 22:49:23'),
(16, 'CSR67', 1, 23.50, 25.00, 26.50, 24.00, '2025-09-01 22:50:18'),
(17, 'DORA7', 1, 13.00, 14.00, 17.20, 15.50, '2025-09-01 22:50:52');

-- --------------------------------------------------------

--
-- Table structure for table `sell_typepay`
--

CREATE TABLE `sell_typepay` (
  `typepay_id` int(11) NOT NULL,
  `ordersell_id` int(11) NOT NULL,
  `list_typepay` varchar(70) NOT NULL,
  `create_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `stock_product`
--

CREATE TABLE `stock_product` (
  `product_id` int(11) NOT NULL,
  `product_name` varchar(200) NOT NULL,
  `product_count` int(11) NOT NULL,
  `product_price` decimal(10,2) NOT NULL,
  `expenses` decimal(10,2) NOT NULL,
  `id_adder` int(11) NOT NULL,
  `id_order` int(11) NOT NULL,
  `create_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `stock_product`
--

INSERT INTO `stock_product` (`product_id`, `product_name`, `product_count`, `product_price`, `expenses`, `id_adder`, `id_order`, `create_at`) VALUES
(1, 'SSR7', 1200, 10.00, 12000.00, 1, 3, '2025-08-16 23:45:10'),
(2, 'CSR67', 5000, 20.00, 100000.00, 1, 3, '2025-08-16 23:45:10'),
(3, 'DORA7', 500, 11.00, 5500.00, 1, 3, '2025-08-16 23:45:10'),
(4, 'BOX J7', 5000, 10.67, 53350.00, 1, 4, '2025-08-16 23:47:43'),
(5, 'BOX J8', 3000, 10.50, 31500.00, 1, 4, '2025-08-16 23:47:43'),
(6, 'BOX S9', 5002, 12.00, 60024.00, 1, 4, '2025-08-16 23:47:43'),
(7, 'BOX J7', 200, 5.17, 1034.00, 1, 5, '2025-08-17 15:30:21'),
(8, 'BOX J7', 1200, 10.00, 12000.00, 1, 6, '2025-08-17 15:53:01'),
(9, 'BOX S9', 2100, 10.00, 21000.00, 1, 6, '2025-08-17 15:53:01'),
(10, 'JJS9', 200, 10.00, 2000.00, 1, 7, '2025-08-21 22:23:08'),
(11, 'ZZX V99', 1200, 12.00, 14400.00, 1, 8, '2025-08-21 22:23:57'),
(12, 'JJS9', 700, 13.00, 9100.00, 1, 9, '2025-08-25 20:15:00'),
(13, 'DORA7', 2000, 15.00, 30000.00, 1, 9, '2025-08-25 20:15:00'),
(14, 'BOX S9', 200, 13.50, 2700.00, 1, 10, '2025-08-27 13:16:55'),
(15, 'BOX Z4', 5000, 10.00, 50000.00, 1, 10, '2025-08-27 13:16:55'),
(16, 'JJMS09', 3000, 11.67, 35010.00, 1, 10, '2025-08-27 13:16:55'),
(17, 'BOX J8S', 200, 20.00, 4000.00, 1, 11, '2025-08-31 15:17:01'),
(45, 'BOX S9', 200, 17.00, 3400.00, 1, 28, '2025-09-02 20:36:30'),
(47, 'BOX J8S', 5000, 12.50, 62500.00, 1, 28, '2025-09-02 20:53:35'),
(48, 'SSR7', 200, 15.00, 3000.00, 1, 28, '2025-09-02 21:32:34'),
(49, 'SSJ9', 200, 5.00, 1000.00, 1, 29, '2025-09-08 00:52:38'),
(50, 'BOX J8', 300, 12.00, 3600.00, 1, 11, '2025-09-08 18:50:58'),
(51, 'BOX J8S', 4000, 13.50, 54000.00, 1, 30, '2025-09-08 19:56:52'),
(52, 'JJS9', 500, 11.05, 5525.00, 1, 30, '2025-09-08 19:56:52'),
(53, 'PPBOX6', 70, 10.67, 746.90, 1, 31, '2025-09-11 16:32:09');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(20) NOT NULL,
  `fullname` varchar(300) NOT NULL,
  `username` varchar(300) NOT NULL,
  `password` varchar(300) NOT NULL,
  `create_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `fullname`, `username`, `password`, `create_at`) VALUES
(1, 'admin', 'admin.com', 'P@ssw0rd', '2025-08-16 11:32:10');

-- --------------------------------------------------------

--
-- Table structure for table `withdraw`
--

CREATE TABLE `withdraw` (
  `withdraw_id` int(11) NOT NULL,
  `count_withdraw` decimal(10,2) NOT NULL,
  `slip_withdraw` varchar(300) NOT NULL,
  `date_withdrow` datetime NOT NULL,
  `reason` text NOT NULL,
  `id_adder` int(11) NOT NULL,
  `create_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `capital`
--
ALTER TABLE `capital`
  ADD PRIMARY KEY (`capital_id`);

--
-- Indexes for table `list_productsell`
--
ALTER TABLE `list_productsell`
  ADD PRIMARY KEY (`list_sellid`);

--
-- Indexes for table `orders_sell`
--
ALTER TABLE `orders_sell`
  ADD PRIMARY KEY (`id_ordersell`);

--
-- Indexes for table `order_box`
--
ALTER TABLE `order_box`
  ADD PRIMARY KEY (`order_id`);

--
-- Indexes for table `rate_price`
--
ALTER TABLE `rate_price`
  ADD PRIMARY KEY (`rate_id`);

--
-- Indexes for table `sell_typepay`
--
ALTER TABLE `sell_typepay`
  ADD PRIMARY KEY (`typepay_id`);

--
-- Indexes for table `stock_product`
--
ALTER TABLE `stock_product`
  ADD PRIMARY KEY (`product_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `withdraw`
--
ALTER TABLE `withdraw`
  ADD PRIMARY KEY (`withdraw_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `capital`
--
ALTER TABLE `capital`
  MODIFY `capital_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `list_productsell`
--
ALTER TABLE `list_productsell`
  MODIFY `list_sellid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `orders_sell`
--
ALTER TABLE `orders_sell`
  MODIFY `id_ordersell` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `order_box`
--
ALTER TABLE `order_box`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `rate_price`
--
ALTER TABLE `rate_price`
  MODIFY `rate_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `sell_typepay`
--
ALTER TABLE `sell_typepay`
  MODIFY `typepay_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `stock_product`
--
ALTER TABLE `stock_product`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `withdraw`
--
ALTER TABLE `withdraw`
  MODIFY `withdraw_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
