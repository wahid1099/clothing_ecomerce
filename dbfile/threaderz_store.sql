-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 30, 2024 at 04:05 PM
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
-- Database: `threaderz_store`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `products_id` int(10) NOT NULL,
  `ip_add` varchar(255) NOT NULL,
  `qty` int(10) NOT NULL,
  `size` text NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `c_id` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`products_id`, `ip_add`, `qty`, `size`, `date`, `c_id`) VALUES
(18, '::1', 1, 'XL', '2024-01-29 12:30:33', 'hfju6v77b10v23lqe8rm3g11bk');

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `cat_id` int(10) NOT NULL,
  `cat_title` text NOT NULL,
  `cat_desc` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`cat_id`, `cat_title`, `cat_desc`) VALUES
(1, 'Men', ' Latest and best outfits for men'),
(2, 'Women', ' Latest and best outfits for women'),
(3, 'Kids', ' Latest and best outfits for kids');

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `customer_id` int(10) NOT NULL,
  `customer_name` varchar(255) NOT NULL,
  `customer_email` varchar(255) NOT NULL,
  `customer_pass` varchar(50) NOT NULL,
  `customer_address` varchar(400) NOT NULL,
  `customer_contact` text NOT NULL,
  `customer_image` text NOT NULL,
  `customer_ip` varchar(45) DEFAULT NULL,
  `user_role` varchar(255) NOT NULL DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`customer_id`, `customer_name`, `customer_email`, `customer_pass`, `customer_address`, `customer_contact`, `customer_image`, `customer_ip`, `user_role`) VALUES
(31, 'Yousaf', 'yo@gmail.com', '123', 'Karachi', '03002291527', '2.jpeg', '0', 'user'),
(32, 'Wahid', 'wahid@gmail.com', '123456', 'new', '01879439753', '221-15-5510.jpg', '0', 'user'),
(33, 'admin', 'admin@gmail.com', '123456', 'demo', '01111111', 'null', '0', 'admin'),
(34, 'zarir', 'z@gmail.com', '555555555', 'sdfdsaf', '01111111111', 'logoheader.jpg', '0', 'user'),
(35, 'Md testing', 'demo@gmail.com', '123456', 'dhaka', '01234567891', 'man.png', '0', 'user'),
(36, 'q@gmail.com', 'q@gmail.com', '123456', 'sadfdsaf', '12345678910', 'man.png', '0', 'user'),
(37, 'abc', 'abc@gmail.com', '12345699', 'dhaka', '12345678910', 'man.png', '::1', 'user');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(10) NOT NULL,
  `order_qty` int(10) NOT NULL,
  `order_price` int(10) NOT NULL,
  `c_id` varchar(255) DEFAULT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `customer_name` varchar(255) DEFAULT NULL,
  `customer_phone` varchar(15) DEFAULT NULL,
  `customer_address` varchar(255) DEFAULT NULL,
  `status` varchar(20) DEFAULT 'Pending',
  `product_id` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `order_qty`, `order_price`, `c_id`, `date`, `customer_name`, `customer_phone`, `customer_address`, `status`, `product_id`) VALUES
(1, 1, 2300, '32', '2024-01-24 11:11:48', NULL, NULL, NULL, 'Delivered', NULL),
(2, 1, 2200, '32', '2024-01-24 17:27:56', NULL, NULL, NULL, 'Delivered', NULL),
(3, 2, 4400, '32', '2024-01-24 17:31:28', NULL, NULL, NULL, 'Delivered', NULL),
(4, 4, 32700, '34', '2024-01-24 17:31:33', NULL, NULL, NULL, 'Delivered', NULL),
(5, 1, 9800, '0', '2024-01-24 13:16:33', NULL, NULL, NULL, 'Pending', NULL),
(6, 6, 111600, '0', '2024-01-24 16:24:34', '', '', '', 'Pending', NULL),
(7, 2, 3800, '0', '2024-01-24 16:35:29', '', '', '', 'Pending', '16'),
(8, 4, 5000, '0', '2024-01-24 16:43:14', 'wahid', '01879439999', 'dhaka', 'Pending', '15'),
(9, 2, 2400, '0', '2024-01-24 16:54:52', 'wahid', '01878777', 'dhaka', 'Pending', '17,39'),
(10, 1, 1900, '0', '2024-01-24 16:57:11', 'wahid', '22222222', 'dhaka', 'Pending', '16'),
(11, 1, 1900, '0', '2024-01-24 16:59:37', 'wahid', '500', 'asdfdsaf', 'Pending', '16'),
(12, 3, 1000, '0', '2024-01-24 17:06:52', 'md wahid', '01879999', 'dhaka', 'Pending', '0,41,46'),
(13, 1, 500, '0', '2024-01-24 17:09:05', 'd', 'd', 'd', 'Pending', '39'),
(14, 2, 2300, '33', '2024-01-24 17:58:07', 'wha', '4554', '544sadf', 'Pending', '18,42'),
(15, 2, 2300, '33', '2024-01-24 18:01:39', 'wha', '4554', '544sadf', 'Pending', '18,42'),
(16, 2, 2300, '33', '2024-01-24 18:01:52', 'sdf', 'sdfsd', '200', 'Pending', '18,42'),
(17, 2, 2300, '33', '2024-01-24 18:02:58', 'd', '66', 'df', 'Pending', '18,42'),
(18, 2, 2300, '33', '2024-01-24 18:10:36', 'a', 'b', 'cx', 'Pending', '18,42'),
(19, 2, 2300, '33', '2024-01-24 18:13:27', 'fd', 'sd', 'sd', 'Pending', '18,42'),
(20, 2, 2300, '33', '2024-01-24 18:16:11', 'fd', 'sd', 'sd', 'Pending', '18,42'),
(21, 2, 2300, '33', '2024-01-24 18:16:16', 'sd', 'dsf', 'sdf', 'Pending', '18,42'),
(22, 2, 2300, '33', '2024-01-24 18:18:35', 'a', 'b', 'cx', 'Pending', '18,42'),
(23, 2, 2300, '33', '2024-01-24 18:19:02', 'asdf', 'asdf', 'adf', 'Pending', '18,42'),
(24, 2, 2300, '33', '2024-01-24 18:20:41', 'asdf', 'asdf', 'adf', 'Pending', '18,42'),
(25, 1, 9800, '33', '2024-01-24 18:21:21', 'dsf', 'dsf', 'dsf', 'Pending', '37'),
(26, 1, 1900, '33', '2024-01-24 18:22:46', 'sdf', 'sdf', 'asdf', 'Pending', '17'),
(27, 1, 3200, '33', '2024-01-24 18:23:43', 'dsf', 'dsf', 'sdf', 'Pending', '13'),
(28, 1, 1900, '33', '2024-01-24 18:26:20', 'dd', '0111', 'dhaka', 'Pending', '17'),
(29, 1, 500, '33', '2024-01-24 18:30:27', 'sdf', 'df', 'dsf', 'Pending', '42'),
(30, 1, 500, '33', '2024-01-24 18:34:11', 'wahid', '0111', 'dhaka', 'Pending', '44'),
(31, 1, 1900, '33', '2024-01-24 18:37:08', 'wahid', '019999999', 'dhaka new market', 'Delivered', '16'),
(32, 1, 500, '0', '2024-01-24 18:38:49', 'wahid', '1111111111', 'dhaka', 'Pending', '38'),
(33, 4, 5900, '0', '2024-01-25 11:33:21', 'wahid', '0000000000', 'dhaka', 'Pending', '0,15,17,41'),
(34, 1, 500, '0', '2024-01-25 11:43:40', 'wahid', '1111111111', 'dhaka', 'Pending', '49'),
(35, 1, 500, '0', '2024-01-25 11:45:25', 'wahid', '01997897356', 'new babu parasaidpur', 'Pending', '38'),
(36, 1, 3100, '33', '2024-01-25 16:07:32', 'wahid', '0199999', 'dhaka', 'Pending', '20'),
(37, 0, 0, '0', '2024-01-27 01:33:01', 'testing', '00000000', 'dhaka', 'Pending', ''),
(38, 1, 1900, '0', '2024-01-27 01:34:13', 'a', 'b', 'c', 'Pending', '17'),
(39, 1, 27000, '0', '2024-01-27 02:04:17', 'wahid', 'sdaf`', '654sdfa', 'Pending', '12'),
(40, 1, 500, '0', '2024-01-27 02:05:26', 'af', 'safd', 'sadf', 'Pending', '49'),
(41, 2, 5100, '0', '2024-01-27 07:12:03', 'demo', '1111111', 'dhaka', 'Pending', '13,17'),
(42, 3, 5700, '1', '2024-01-27 09:58:40', 'wahid', '011111', 'dhaka', 'Pending', '17'),
(43, 1, 3500, '1', '2024-01-27 13:05:55', 'wahid', '01111111', 'dhaka', 'Pending', '15'),
(44, 0, 0, '1', '2024-01-27 14:33:45', 'sdfg', 'dsfgq', 'dsffgfd', 'Pending', ''),
(45, 1, 3200, '1', '2024-01-27 14:34:49', 'a', 'safd', 'sadf', 'Pending', '13');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `products_id` int(10) NOT NULL,
  `p_cat_id` int(10) NOT NULL,
  `cat_id` int(10) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `product_title` text NOT NULL,
  `product_img1` text NOT NULL,
  `product_img2` text NOT NULL,
  `product_price` int(10) NOT NULL,
  `product_keywords` text NOT NULL,
  `product_desc` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`products_id`, `p_cat_id`, `cat_id`, `date`, `product_title`, `product_img1`, `product_img2`, `product_price`, `product_keywords`, `product_desc`) VALUES
(12, 1, 2, '2024-01-24 07:00:36', 'Brown Coat Type Jackets', 'brown-jacket.jpg', 'brown-jacket.jpg', 27000, 'Warm', 'hhhhhhhhhhhhhhhhhhhhhhhhhhhh'),
(13, 1, 2, '2024-01-24 06:59:14', 'Pink Fluffy Jacket', 'pink jacket.jpg', 'pink jacket.jpg', 3200, 'Warm', '<p>Comfortable and Warm 2</p>'),
(14, 4, 2, '2020-06-18 04:20:20', 'Black High Heels', 'blackheels.jpg', 'blackheels.jpg', 2300, 'Black Heels', '<p>Very Stylish and Comfortable</p>'),
(15, 1, 1, '2020-06-16 11:49:45', 'Grey Royal Jacket', 'Man-Geox-Winter-jacket-1.jpg', 'Man-Geox-Winter-jacket-2.jpg', 3500, 'Jacket Grey', '<p>Warm Stylish and Comfortable</p>'),
(16, 4, 2, '2020-06-18 04:15:28', 'White Shiny Heels', 'whiteheels.jpg', 'whiteheels.jpg', 1900, 'Shiney', '<p>Style and Glamour at its best</p>'),
(17, 5, 1, '2020-06-16 11:56:59', 'Thrashers Hoodie', 'hoodie-2.png', 'hoodie-2.png', 1900, 'Grey Hoodie', '<p>Very comfortable, warm and cool</p>'),
(18, 3, 2, '2020-06-16 11:57:49', 'Black Ripped Jeans', 'jeanss.png', 'jeanss.png', 1800, 'Ripped Black', '<p>Very Cool and stylish</p>'),
(19, 5, 3, '2020-06-16 11:58:49', 'Colorful Hoodie', 'hoodie-4.png', 'hoodie-4.png', 2300, 'Colorful', '<p>Very cool</p>'),
(20, 1, 3, '2020-06-16 11:59:35', 'Black Polo Jacket', 'boys-Puffer-Coat-With-Detachable-Hood-3.jpg', 'boys-Puffer-Coat-With-Detachable-Hood-3.jpg', 3100, 'Black', '<p>Warm and comfy</p>'),
(25, 3, 2, '2024-01-24 09:31:55', 'testing', 'man.png', 'man.png', 600, 'jeans', '<p>jeansjeansjeansjeansjeansjeans</p>'),
(26, 2, 2, '2024-01-24 09:37:11', 'dummy', 'man.png', 'logoheader.jpg', 9800, 'jeans', '<p>testinbg</p>'),
(27, 2, 2, '2024-01-24 09:37:13', 'dummy', 'man.png', 'logoheader.jpg', 9800, 'jeans', '<p>testinbg</p>'),
(28, 2, 2, '2024-01-24 09:37:15', 'dummy', 'man.png', 'logoheader.jpg', 9800, 'jeans', '<p>testinbg</p>'),
(29, 2, 2, '2024-01-24 09:37:17', 'dummy', 'man.png', 'logoheader.jpg', 9800, 'jeans', '<p>testinbg</p>'),
(30, 2, 2, '2024-01-24 09:37:19', 'dummy', 'man.png', 'logoheader.jpg', 9800, 'jeans', '<p>testinbg</p>'),
(31, 2, 2, '2024-01-24 09:37:21', 'dummy', 'man.png', 'logoheader.jpg', 9800, 'jeans', '<p>testinbg</p>'),
(32, 2, 2, '2024-01-24 09:37:24', 'dummy', 'man.png', 'logoheader.jpg', 9800, 'jeans', '<p>testinbg</p>'),
(33, 2, 2, '2024-01-24 09:37:26', 'dummy', 'man.png', 'logoheader.jpg', 9800, 'jeans', '<p>testinbg</p>'),
(34, 2, 2, '2024-01-24 09:37:28', 'dummy', 'man.png', 'logoheader.jpg', 9800, 'jeans', '<p>testinbg</p>'),
(35, 2, 2, '2024-01-24 09:37:31', 'dummy', 'man.png', 'logoheader.jpg', 9800, 'jeans', '<p>testinbg</p>'),
(36, 2, 2, '2024-01-24 09:37:33', 'dummy', 'man.png', 'logoheader.jpg', 9800, 'jeans', '<p>testinbg</p>'),
(37, 2, 2, '2024-01-24 09:37:37', 'dummy', 'man.png', 'logoheader.jpg', 9800, 'jeans', '<p>testinbg</p>'),
(38, 2, 2, '2024-01-24 09:39:27', 'testing', 'logoheader.jpg', 'wplogo.jpg', 500, 'jeans', '<p>jeansjeansjeans</p>'),
(39, 2, 2, '2024-01-24 09:39:29', 'testing', 'logoheader.jpg', 'wplogo.jpg', 500, 'jeans', '<p>jeansjeansjeans</p>'),
(40, 2, 2, '2024-01-24 09:39:31', 'testing', 'logoheader.jpg', 'wplogo.jpg', 500, 'jeans', '<p>jeansjeansjeans</p>'),
(41, 2, 2, '2024-01-24 09:39:33', 'testing', 'logoheader.jpg', 'wplogo.jpg', 500, 'jeans', '<p>jeansjeansjeans</p>'),
(42, 2, 2, '2024-01-24 09:39:35', 'testing', 'logoheader.jpg', 'wplogo.jpg', 500, 'jeans', '<p>jeansjeansjeans</p>'),
(43, 2, 2, '2024-01-24 09:39:38', 'testing', 'logoheader.jpg', 'wplogo.jpg', 500, 'jeans', '<p>jeansjeansjeans</p>'),
(44, 2, 2, '2024-01-24 09:39:40', 'testing', 'logoheader.jpg', 'wplogo.jpg', 500, 'jeans', '<p>jeansjeansjeans</p>'),
(46, 2, 2, '2024-01-24 09:39:44', 'testing', 'logoheader.jpg', 'wplogo.jpg', 500, 'jeans', '<p>jeansjeansjeans</p>'),
(47, 2, 2, '2024-01-24 09:39:47', 'testing', 'logoheader.jpg', 'wplogo.jpg', 500, 'jeans', '<p>jeansjeansjeans</p>'),
(48, 2, 2, '2024-01-24 09:39:50', 'testing', 'logoheader.jpg', 'wplogo.jpg', 500, 'jeans', '<p>jeansjeansjeans</p>'),
(49, 2, 2, '2024-01-24 09:39:53', 'testing', 'logoheader.jpg', 'wplogo.jpg', 500, 'jeans', '<p>jeansjeansjeans</p>');

-- --------------------------------------------------------

--
-- Table structure for table `product_categories`
--

CREATE TABLE `product_categories` (
  `p_cat_id` int(10) NOT NULL,
  `p_cat_title` text NOT NULL,
  `p_cat_desc` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product_categories`
--

INSERT INTO `product_categories` (`p_cat_id`, `p_cat_title`, `p_cat_desc`) VALUES
(1, 'Jackets', 'Good quality custom made and casual wear jackets'),
(2, 'Tee-Shirts', 'Good and easy stuff designed Tee-Shirt '),
(3, 'Jeans', 'High Quality Denim and Leather Jeans'),
(4, 'Shoes', 'Good quality and soft sole shoes with good endurance'),
(5, 'Hoodies', 'Cool customized and colorful hoodies');

-- --------------------------------------------------------

--
-- Table structure for table `slider`
--

CREATE TABLE `slider` (
  `slide_id` int(10) NOT NULL,
  `slide_name` varchar(255) NOT NULL,
  `slide_image` text NOT NULL,
  `slide_heading` varchar(100) NOT NULL,
  `slide_text` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `slider`
--

INSERT INTO `slider` (`slide_id`, `slide_name`, `slide_image`, `slide_heading`, `slide_text`) VALUES
(1, 'Slide 1', 'slide_1.jpg', 'Summer Sale', 'Walk in for the Fashion, Stay in for the Style.'),
(2, 'Slide 2', 'slide_2.jpg', 'Black friday', 'Simply Eveything You Want.');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`products_id`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`cat_id`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`customer_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`products_id`);

--
-- Indexes for table `product_categories`
--
ALTER TABLE `product_categories`
  ADD PRIMARY KEY (`p_cat_id`);

--
-- Indexes for table `slider`
--
ALTER TABLE `slider`
  ADD PRIMARY KEY (`slide_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `cat_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `customer_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `products_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;

--
-- AUTO_INCREMENT for table `product_categories`
--
ALTER TABLE `product_categories`
  MODIFY `p_cat_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `slider`
--
ALTER TABLE `slider`
  MODIFY `slide_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
