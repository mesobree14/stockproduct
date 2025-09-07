-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Sep 07, 2025 at 03:08 PM
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

--
-- Dumping data for table `capital`
--

INSERT INTO `capital` (`capital_id`, `count_capital`, `slip_capital`, `date_time_ad`, `adder_id`, `create_at`) VALUES
(9, 50000.00, 'img_68bd7fee99456.webp', '2025-09-07 19:51:00', 1, '2025-09-07 19:51:58');

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

--
-- Dumping data for table `list_productsell`
--

INSERT INTO `list_productsell` (`list_sellid`, `ordersell_id`, `productname`, `rate_customertype`, `type_custom`, `tatol_product`, `price_to_pay`, `create_at`) VALUES
(8, 20, 'BOX J7', 14.00, 'price_customer_frontstore', 122, 1708.00, '2025-08-23 16:53:24'),
(9, 21, 'BOX S9', 13.00, 'price_custommer_vip', 120, 1560.00, '2025-08-23 17:09:27'),
(10, 21, 'ZZX V99', 18.00, 'price_customer_deliver', 300, 5400.00, '2025-08-23 17:09:27'),
(11, 21, 'DORA7', 13.00, 'price_custommer_vip', 100, 1300.00, '2025-08-23 17:09:27'),
(16, 25, 'CSR67', 17.00, 'price_customer_dealer', 1200, 30000.00, '2025-08-25 14:54:08'),
(17, 25, 'DORA7', 15.00, 'price_customer_dealer', 2000, 30000.00, '2025-08-25 14:54:08'),
(18, 25, 'JJS9', 13.00, 'price_customer_dealer', 1000, 13000.00, '2025-08-25 14:54:08'),
(23, 29, 'BOX J8', 16.05, 'price_customer_dealer', 500, 8025.00, '2025-09-01 22:57:00'),
(24, 29, 'DORA7', 15.50, 'price_customer_dealer', 350, 5425.00, '2025-09-01 22:57:00'),
(25, 29, 'BOX J8S', 26.00, 'price_customer_dealer', 200, 5200.00, '2025-09-01 22:57:00'),
(26, 30, 'BOX J8', 1400.00, 'price_custommer_vip', 300, 4200.00, '2025-09-02 20:44:40'),
(27, 30, 'BOX S9', 1500.00, 'price_custommer_vip', 300, 4500.00, '2025-09-02 20:44:40'),
(28, 31, 'BOX J7', 1400.00, 'price_custommer_vip', 278, 3892.00, '2025-09-07 01:14:53'),
(29, 31, 'BOX Z4', 1300.00, 'price_custommer_vip', 2000, 26000.00, '2025-09-07 01:14:53');

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
  `adder_id` int(11) NOT NULL,
  `create_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `orders_sell`
--

INSERT INTO `orders_sell` (`id_ordersell`, `ordersell_name`, `is_totalprice`, `custome_name`, `tell_custome`, `date_time_sell`, `shipping_note`, `sender`, `tell_sender`, `location_send`, `wages`, `reason`, `slip_ordersell`, `adder_id`, `create_at`) VALUES
(20, 'รายการขาย1', 1708.00, 'monalisa', '0840991102', '2025-08-23 16:53:00', 'ลูกค้ามาไม่ได้', 'simula', '', '', 120.00, 'xxxx', '', 1, '2025-08-23 16:53:24'),
(21, 'รายการขาย2', 8260.00, 'kilua', '0840991102', '2025-08-23 17:08:00', 'ลูกค้ามาไม่ได้', 'simula', '', '', 150.00, 'xxxxxxx', 'img_68a993571b230.png', 1, '2025-08-23 17:09:27'),
(25, 'รายการขาย4', 73000.00, 'jint fress', '0840991188', '2025-08-25 14:53:00', '', '', '', '', 0.00, '-xxxx', '', 1, '2025-08-25 14:54:08'),
(29, 'HBT45TY7', 18650.00, 'koty prola', '0840991138', '2025-09-01 22:56:00', '', '', '', '', 0.00, '-', '', 1, '2025-09-01 22:57:00'),
(30, 'XTH5677TY', 8700.00, 'monalisa', '0840991102', '2025-09-02 20:44:00', '', '', '', '', 0.00, '-', '', 1, '2025-09-02 20:44:40'),
(31, '59TJV58GUX', 29892.00, 'monalisa', '0994561102', '2025-09-07 01:14:00', '', 'simula', '0984573324', 'm5, t.bana, a.muang j.pattani 94000', 0.00, '', 'img_68bc7a1da7657.jpg', 1, '2025-09-07 01:14:53');

-- --------------------------------------------------------

--
-- Table structure for table `order_box`
--

CREATE TABLE `order_box` (
  `order_id` int(11) NOT NULL,
  `order_name` varchar(300) NOT NULL,
  `slip_order` varchar(200) NOT NULL,
  `totalcost_order` int(11) NOT NULL,
  `count_order` int(11) NOT NULL,
  `id_adder` int(11) NOT NULL,
  `date_time_order` datetime NOT NULL,
  `create_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `order_box`
--

INSERT INTO `order_box` (`order_id`, `order_name`, `slip_order`, `totalcost_order`, `count_order`, `id_adder`, `date_time_order`, `create_at`) VALUES
(3, 'คำสั่งซื้อที่1', 'slip-orderimg_68a0b502ba8c1.jpg', 45000, 3, 1, '2025-08-16 23:44:00', '2025-08-16 23:45:10'),
(4, 'คำสั่งซื้อที่2', 'slip-ordersimg_68a0b62f4ff27.jpg', 5200, 3, 1, '2025-08-16 23:46:00', '2025-08-16 23:47:43'),
(5, 'คำสั่งซื้อที่3', 'img_68a1931d4d404.png', 1000, 1, 1, '2025-08-17 15:29:00', '2025-08-17 15:30:21'),
(6, 'คำสั่งซื้อที่4', 'img_68a1986dc1f0b.jpg', 50000, 2, 1, '2025-08-17 15:52:00', '2025-08-17 15:53:01'),
(7, 'คำสั่งซื้อที่5', 'img_68a739dcc93c2.png', 45000, 1, 1, '2025-08-21 22:22:00', '2025-08-21 22:23:08'),
(8, 'คำสั่งซื้อที่6', 'img_68a73a0dd4a7a.png', 45000, 1, 1, '2025-08-21 22:23:00', '2025-08-21 22:23:57'),
(9, 'คำสั่งซื้อที่7', 'img_68ac61d40e1db.png', 45000, 2, 1, '2025-08-25 20:12:00', '2025-08-25 20:15:00'),
(10, 'คำสั่งซื้อที่8', 'img_68aea2d7a53f8.png', 84700, 3, 1, '2025-08-27 13:15:00', '2025-08-27 13:16:55'),
(11, 'คำสั่งซื้อที่1', 'img_68b404fd0d4a4.png', 4000, 1, 1, '2025-08-31 15:16:00', '2025-08-31 15:17:01'),
(28, 'order_name344', 'img_68b7000200587.jpeg', 4605, 3, 1, '2025-09-02 20:34:00', '2025-09-02 20:36:30');

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

--
-- Dumping data for table `sell_typepay`
--

INSERT INTO `sell_typepay` (`typepay_id`, `ordersell_id`, `list_typepay`, `create_at`) VALUES
(18, 20, 'ติดค้าง', '2025-08-23 16:53:24'),
(19, 21, 'โอน', '2025-08-23 17:09:27'),
(20, 21, 'จ่ายสด', '2025-08-23 17:09:27'),
(21, 21, 'ติดค้าง', '2025-08-23 17:09:27'),
(22, 22, 'โอน', '2025-08-24 20:23:09'),
(25, 25, 'จ่ายสด', '2025-08-25 14:54:08'),
(26, 26, 'โอน', '2025-09-01 20:45:01'),
(27, 27, 'โอน', '2025-09-01 20:54:35'),
(28, 28, 'โอน', '2025-09-01 21:05:23'),
(29, 29, 'จ่ายสด', '2025-09-01 22:57:00'),
(30, 30, 'จ่ายสด', '2025-09-02 20:44:40'),
(31, 31, 'โอน', '2025-09-07 01:14:53');

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
(2, 'CSR67', 5000, 20.00, 0.00, 1, 3, '2025-08-16 23:45:10'),
(3, 'DORA7', 500, 10.00, 0.00, 1, 3, '2025-08-16 23:45:10'),
(4, 'BOX J7', 5000, 10.00, 0.00, 1, 4, '2025-08-16 23:47:43'),
(5, 'BOX J8', 3000, 10.00, 0.00, 1, 4, '2025-08-16 23:47:43'),
(6, 'BOX S9', 5002, 12.00, 0.00, 1, 4, '2025-08-16 23:47:43'),
(7, 'BOX J7', 200, 5.00, 0.00, 1, 5, '2025-08-17 15:30:21'),
(8, 'BOX J7', 1200, 10.00, 0.00, 1, 6, '2025-08-17 15:53:01'),
(9, 'BOX S9', 2100, 10.00, 0.00, 1, 6, '2025-08-17 15:53:01'),
(10, 'JJS9', 200, 10.00, 0.00, 1, 7, '2025-08-21 22:23:08'),
(11, 'ZZX V99', 1200, 12.00, 0.00, 1, 8, '2025-08-21 22:23:57'),
(12, 'JJS9', 700, 13.00, 0.00, 1, 9, '2025-08-25 20:15:00'),
(13, 'DORA7', 2000, 15.00, 0.00, 1, 9, '2025-08-25 20:15:00'),
(14, 'BOX S9', 200, 13.50, 2700.00, 1, 10, '2025-08-27 13:16:55'),
(15, 'BOX Z4', 5000, 10.00, 50000.00, 1, 10, '2025-08-27 13:16:55'),
(16, 'JJMS09', 3000, 10.67, 32000.00, 1, 10, '2025-08-27 13:16:55'),
(17, 'BOX J8S', 200, 20.00, 4000.00, 1, 11, '2025-08-31 15:17:01'),
(45, 'BOX S9', 200, 17.00, 3400.00, 1, 28, '2025-09-02 20:36:30'),
(47, 'BOX J8S', 5000, 12.50, 62500.00, 1, 28, '2025-09-02 20:53:35'),
(48, 'SSR7', 200, 15.00, 3000.00, 1, 28, '2025-09-02 21:32:34');

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
  `count_withdraw` decimal(10,0) NOT NULL,
  `slip_withdraw` varchar(300) NOT NULL,
  `date_withdrow` datetime NOT NULL,
  `reason` text NOT NULL,
  `id_adder` int(11) NOT NULL,
  `create_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `withdraw`
--

INSERT INTO `withdraw` (`withdraw_id`, `count_withdraw`, `slip_withdraw`, `date_withdrow`, `reason`, `id_adder`, `create_at`) VALUES
(3, 3000, 'img_68bd80e779247.jpg', '2025-09-07 19:55:00', 'xxxx', 1, '2025-09-07 19:56:07');

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
  MODIFY `capital_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `list_productsell`
--
ALTER TABLE `list_productsell`
  MODIFY `list_sellid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `orders_sell`
--
ALTER TABLE `orders_sell`
  MODIFY `id_ordersell` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `order_box`
--
ALTER TABLE `order_box`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `rate_price`
--
ALTER TABLE `rate_price`
  MODIFY `rate_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `sell_typepay`
--
ALTER TABLE `sell_typepay`
  MODIFY `typepay_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `stock_product`
--
ALTER TABLE `stock_product`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `withdraw`
--
ALTER TABLE `withdraw`
  MODIFY `withdraw_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
