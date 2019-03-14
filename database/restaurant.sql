-- phpMyAdmin SQL Dump
-- version 4.6.6
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: May 11, 2018 at 08:36 AM
-- Server version: 5.5.55-38.8-log
-- PHP Version: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `restaurant`
--

-- --------------------------------------------------------

--
-- Table structure for table `company`
--

CREATE TABLE `company` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `company`
--

INSERT INTO `company` (`id`, `name`) VALUES
(1, 'Restaurant');

-- --------------------------------------------------------

--
-- Table structure for table `customer_registration`
--

CREATE TABLE `customer_registration` (
  `customer_id` int(11) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `mobile` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `is_verified` int(1) NOT NULL DEFAULT '0',
  `status` int(1) NOT NULL DEFAULT '0',
  `added_time` timestamp NULL DEFAULT NULL,
  `updated_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `customer_registration`
--

INSERT INTO `customer_registration` (`customer_id`, `full_name`, `email`, `mobile`, `password`, `is_verified`, `status`, `added_time`, `updated_time`) VALUES
(1, 'test', 'test@gmail.com', '1234567890', 'e10adc3949ba59abbe56e057f20f883e', 1, 0, '2018-05-07 18:49:21', '2018-05-07 13:19:21'),
(2, 'test', 'test@gmail.com', '1234567899', 'e10adc3949ba59abbe56e057f20f883e', 1, 0, '2018-05-07 20:17:59', '2018-05-07 14:47:59');

-- --------------------------------------------------------

--
-- Table structure for table `final_order`
--

CREATE TABLE `final_order` (
  `id` int(11) NOT NULL,
  `table_id` varchar(255) NOT NULL,
  `rest_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `order_total` float(10,2) NOT NULL,
  `discount` float(10,2) NOT NULL DEFAULT '0.00',
  `net_amount` float(10,2) NOT NULL,
  `ord_id` int(11) NOT NULL,
  `added_time` datetime NOT NULL,
  `bill_status` varchar(255) NOT NULL DEFAULT 'ASKED_FOR_BILL',
  `updated_by` int(11) NOT NULL DEFAULT '0',
  `updated_time` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `final_order`
--

INSERT INTO `final_order` (`id`, `table_id`, `rest_id`, `user_id`, `role_id`, `order_total`, `discount`, `net_amount`, `ord_id`, `added_time`, `bill_status`, `updated_by`, `updated_time`) VALUES
(1, '7', 3, 10, 2, 80.00, 0.00, 80.00, 3, '2018-05-08 17:53:36', 'ASKED_FOR_BILL', 0, NULL),
(2, '20', 3, 10, 2, 235.00, 0.00, 235.00, 9, '2018-05-11 13:24:30', 'ASKED_FOR_BILL', 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `food_category`
--

CREATE TABLE `food_category` (
  `id` int(11) NOT NULL,
  `restaurant_id` int(11) NOT NULL,
  `category_name` varchar(255) NOT NULL,
  `category_image` varchar(255) NOT NULL,
  `added_by` int(11) NOT NULL DEFAULT '0',
  `updated_by` int(11) NOT NULL DEFAULT '0',
  `added_time` timestamp NULL DEFAULT NULL,
  `updated_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `food_category`
--

INSERT INTO `food_category` (`id`, `restaurant_id`, `category_name`, `category_image`, `added_by`, `updated_by`, `added_time`, `updated_time`) VALUES
(3, 3, 'Juice', '1523739426.png', 1, 1, '2018-04-14 18:44:27', '2018-04-16 16:05:33'),
(4, 3, 'Sandwich', '1523875101.png', 1, 1, '2018-04-14 19:24:09', '2018-04-16 16:08:21'),
(5, 3, 'Burger', '1523875160.png', 1, 1, '2018-04-14 20:03:19', '2018-04-16 16:09:20'),
(6, 3, 'Beverage', '1523875177.png', 1, 1, '2018-04-14 20:19:12', '2018-04-16 16:09:37'),
(7, 3, 'Soup', '1523875148.png', 1, 1, '2018-04-14 20:44:52', '2018-04-16 16:09:08'),
(8, 3, 'Today\'s Special', '1523875131.png', 1, 1, '2018-04-14 20:56:53', '2018-04-16 16:08:51');

-- --------------------------------------------------------

--
-- Table structure for table `food_item`
--

CREATE TABLE `food_item` (
  `id` int(11) NOT NULL,
  `restaurant_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `food_name` varchar(255) NOT NULL,
  `food_description` text NOT NULL,
  `food_image` varchar(255) NOT NULL,
  `food_rate` float(10,2) NOT NULL,
  `added_by` int(11) NOT NULL DEFAULT '0',
  `updated_by` int(11) NOT NULL DEFAULT '0',
  `added_time` timestamp NULL DEFAULT NULL,
  `updated_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `food_item`
--

INSERT INTO `food_item` (`id`, `restaurant_id`, `category_id`, `food_name`, `food_description`, `food_image`, `food_rate`, `added_by`, `updated_by`, `added_time`, `updated_time`) VALUES
(3, 0, 3, 'Mosambii Juice', 'Mosambi juicee is more than for beating the summer heat.\r\nGood for eyes, good for common cold, lowers cholestrol', '1523712063.jpg', 25.00, 1, 10, '2018-04-14 18:51:03', '2018-04-17 01:19:21'),
(4, 3, 3, 'Orange juice', 'Has the ability to boost immune system and metabolism. detoxify the body, improve blood circulation and pressure.', '1523712319.jpg', 45.00, 1, 0, '2018-04-14 18:55:19', '2018-04-14 13:25:19'),
(5, 3, 3, 'Pineapple Juice', 'Provides lots of health benifits because of its high quantity of minerals', '1523712902.jpg', 35.00, 1, 0, '2018-04-14 19:05:02', '2018-04-14 13:35:02'),
(6, 3, 3, 'Apple Juice', 'Full of vitamins and minerals, a best alternative to soda and other soft drinks.Try it!', '1523713066.jpg', 40.00, 1, 0, '2018-04-14 19:07:46', '2018-04-14 13:37:46'),
(7, 3, 3, 'Pomagranate Juice', 'High in antioxidants and vitamic C, said to fight viruses boost immune system and protects against cancer!', '1523713181.jpg', 35.00, 1, 0, '2018-04-14 19:09:41', '2018-04-14 13:39:41'),
(8, 3, 3, 'Grapes Juice', 'Reducing high risk of blood clots, healthy blood pressure, prevent bad cholestrol more over its tasy!', '1523713476.jpg', 30.00, 1, 0, '2018-04-14 19:14:36', '2018-04-14 13:44:36'),
(9, 3, 3, 'Watermelon Juice', 'Soaked with nutrients although the 92% is of water, significant amount of Vitamin A, B6 and C', '1523713694.jpg', 25.00, 1, 0, '2018-04-14 19:18:14', '2018-04-14 13:48:14'),
(10, 3, 3, 'Veggie Delight', 'Standard 6 inch delight sandwich has 230 calories and 2.5g of fat.\r\nMade of 6inch 9-grain wheat to add up to the taste.\r\nCustomers can remove the bread and also turn it into a salad!\r\nProvides 8 percent of daily value of Vitamin A and 20 percent of C.', '1523714881.jpg', 45.00, 1, 0, '2018-04-14 19:38:01', '2018-04-14 14:08:01'),
(11, 3, 4, 'Veggie Delight', 'Standard 6 inch delight sandwich has 230 calories and 2.5g of fat.\r\nMade of 6inch 9-grain wheat to add up to the taste.\r\nCustomers can remove the bread and also turn it into a salad!\r\nProvides 8 percent of daily value of Vitamin A and 20 percent of C.', '1523714886.jpg', 45.00, 1, 0, '2018-04-14 19:38:06', '2018-04-14 14:08:06'),
(12, 3, 4, 'Steak n Cheese', 'Two irresistible ingredients piles high onto freshlt prepard bread and your choice of crisp veggies.', '1523716198.jpg', 55.00, 1, 0, '2018-04-14 19:59:58', '2018-04-14 14:29:58'),
(13, 3, 5, 'Cheese Burger', 'Chef\'s special cheese burges satisfies al your fantacies.Made with freshly prepared bread with imported cheese and high quality vegetables and spices to add up to the taste.There is nothing that can be compared to our special cheese burger.Its healthy and tasy\r\nCalories : 60 \r\nVimitan  : A,C B6', '1523716868.jpg', 65.00, 1, 0, '2018-04-14 20:11:08', '2018-04-14 14:41:08'),
(14, 3, 5, 'Spicy Tandoor Crips', 'Special tandoor crisp burger made from fresh chicken and bread topped with veggis to make it clourful and tastly.With no use of atrificial flavours the burger is a good try and best recommended item.', '1523717166.jpg', 70.00, 1, 0, '2018-04-14 20:16:06', '2018-04-14 14:46:06'),
(15, 3, 6, 'Pepsi Can', 'Pepsi can 250ml', '1523718086.jpg', 25.00, 1, 0, '2018-04-14 20:31:26', '2018-04-14 15:01:26'),
(16, 3, 6, 'Mineral Water', '500ml Mineral water - Aquafina', '1523718458.png', 15.00, 1, 0, '2018-04-14 20:37:38', '2018-04-14 15:07:38'),
(17, 3, 6, 'Monster Energy Can', '160ml 10% off when ordering two nos.', '1523718623.jpg', 99.00, 1, 0, '2018-04-14 20:40:23', '2018-04-14 15:10:23'),
(18, 3, 6, 'Mirinda Can', '15ml Mirinda can', '1523718750.jpg', 25.00, 1, 0, '2018-04-14 20:42:30', '2018-04-14 15:12:30'),
(19, 3, 7, 'Hot n Sour Soup', 'Get healthy by the special hot n sour soup made with healthy veggies and spices.', '1523719029.jpg', 75.00, 1, 0, '2018-04-14 20:47:09', '2018-04-14 15:17:09'),
(20, 3, 7, 'Mutton Soup', 'Special kerala style mutton soup with continental spcies to take your touge in control.', '1523719168.jpg', 105.00, 1, 0, '2018-04-14 20:49:28', '2018-04-14 15:19:28'),
(21, 3, 8, 'Festive Special Side', 'Special festive vada + curry ', '1523720168.jpg', 30.00, 1, 1, '2018-04-14 20:59:23', '2018-04-14 21:06:08'),
(22, 3, 8, 'Ramdan Special', 'Check out our Ramdan special chicken casserole.Made in arabic style with the gravy in chineese, a chef\'s special.\r\nTry it with fried rice or noodels.', '1523719943.jpg', 130.00, 1, 0, '2018-04-14 21:02:23', '2018-04-14 15:32:23');

-- --------------------------------------------------------

--
-- Table structure for table `food_order_item`
--

CREATE TABLE `food_order_item` (
  `id` int(11) NOT NULL,
  `table_id` varchar(255) NOT NULL,
  `ord_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `item_qty` int(11) NOT NULL,
  `item_rate` float(10,2) NOT NULL,
  `total_per_item` float(10,2) NOT NULL,
  `item_status` varchar(20) NOT NULL DEFAULT 'PLACED' COMMENT 'PLACED, SERVED',
  `order_status` varchar(20) NOT NULL DEFAULT 'None' COMMENT 'None, New, Running',
  `order_complete` int(1) NOT NULL DEFAULT '0' COMMENT 'Default, Pending, Complete',
  `rest_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `added_time` datetime NOT NULL,
  `updated_by` int(11) NOT NULL DEFAULT '0',
  `updated_time` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `food_order_item`
--

INSERT INTO `food_order_item` (`id`, `table_id`, `ord_id`, `item_id`, `item_qty`, `item_rate`, `total_per_item`, `item_status`, `order_status`, `order_complete`, `rest_id`, `user_id`, `role_id`, `added_time`, `updated_by`, `updated_time`) VALUES
(222, '7', 1, 5, 1, 35.00, 35.00, 'SERVED', 'New', 1, 3, 10, 2, '2018-05-08 16:32:51', 10, '2018-05-11 13:21:46'),
(223, '7', 1, 6, 2, 40.00, 80.00, 'SERVED', 'New', 1, 3, 10, 2, '2018-05-08 16:32:51', 10, '2018-05-08 17:16:46'),
(224, '20', 2, 4, 1, 45.00, 45.00, 'SERVED', 'New', 1, 3, 10, 2, '2018-05-08 16:34:33', 10, '2018-05-08 17:19:14'),
(225, '20', 2, 5, 1, 35.00, 35.00, 'SERVED', 'New', 1, 3, 10, 2, '2018-05-08 16:34:33', 10, '2018-05-08 17:15:48'),
(226, '7', 1, 8, 1, 30.00, 30.00, 'SERVED', 'Running', 1, 3, 10, 2, '2018-05-08 16:35:39', 10, '2018-05-08 17:12:46'),
(227, '7', 1, 9, 1, 25.00, 25.00, 'SERVED', 'Running', 1, 3, 10, 2, '2018-05-08 16:35:39', 10, '2018-05-08 17:13:27'),
(228, '7', 1, 9, 2, 25.00, 50.00, 'SERVED', 'Running', 1, 3, 10, 2, '2018-05-08 17:07:04', 10, '2018-05-11 13:21:46'),
(229, '7', 1, 8, 1, 30.00, 30.00, 'SERVED', 'Running', 1, 3, 10, 2, '2018-05-08 17:07:04', 10, '2018-05-11 13:21:46'),
(230, '7', 3, 5, 1, 35.00, 35.00, 'SERVED', 'New', 2, 3, 10, 2, '2018-05-08 17:29:39', 10, '2018-05-08 17:53:21'),
(231, '7', 3, 4, 1, 45.00, 45.00, 'SERVED', 'New', 2, 3, 10, 2, '2018-05-08 17:29:39', 10, '2018-05-08 17:31:28'),
(232, '7', 4, 5, 1, 35.00, 35.00, 'SERVED', 'New', 1, 3, 10, 2, '2018-05-08 17:29:59', 10, '2018-05-08 17:31:29'),
(233, '7', 4, 4, 1, 45.00, 45.00, 'SERVED', 'New', 1, 3, 10, 2, '2018-05-08 17:29:59', 10, '2018-05-08 17:30:16'),
(234, '0', 5, 6, 2, 40.00, 80.00, 'SERVED', 'New', 1, 3, 10, 2, '2018-05-08 21:07:21', 10, '2018-05-11 13:21:53'),
(235, '0', 5, 10, 2, 45.00, 90.00, 'SERVED', 'New', 1, 3, 10, 2, '2018-05-08 21:07:21', 10, '2018-05-11 13:21:52'),
(236, '0', 5, 7, 5, 35.00, 175.00, 'SERVED', 'New', 1, 3, 10, 2, '2018-05-08 21:07:21', 10, '2018-05-11 13:21:52'),
(237, '0', 5, 9, 2, 25.00, 50.00, 'SERVED', 'New', 1, 3, 10, 2, '2018-05-08 21:07:21', 10, '2018-05-11 13:21:56'),
(238, '0', 5, 8, 1, 30.00, 30.00, 'SERVED', 'New', 1, 3, 10, 2, '2018-05-08 21:07:21', 10, '2018-05-11 13:21:54'),
(239, '0', 5, 6, 2, 40.00, 80.00, 'SERVED', 'Running', 1, 3, 10, 2, '2018-05-08 21:07:25', 10, '2018-05-11 13:21:56'),
(240, '0', 5, 10, 2, 45.00, 90.00, 'SERVED', 'Running', 1, 3, 10, 2, '2018-05-08 21:07:25', 10, '2018-05-11 13:21:50'),
(241, '0', 5, 7, 5, 35.00, 175.00, 'SERVED', 'Running', 1, 3, 10, 2, '2018-05-08 21:07:25', 10, '2018-05-11 13:21:50'),
(242, '0', 5, 9, 2, 25.00, 50.00, 'SERVED', 'Running', 1, 3, 10, 2, '2018-05-08 21:07:25', 10, '2018-05-11 13:21:51'),
(243, '0', 5, 8, 1, 30.00, 30.00, 'SERVED', 'Running', 1, 3, 10, 2, '2018-05-08 21:07:25', 10, '2018-05-11 13:21:54'),
(244, '0', 6, 6, 7, 40.00, 280.00, 'SERVED', 'New', 1, 3, 10, 2, '2018-05-09 23:43:30', 10, '2018-05-11 13:21:55'),
(245, '0', 6, 9, 1, 25.00, 25.00, 'SERVED', 'New', 1, 3, 10, 2, '2018-05-09 23:43:30', 10, '2018-05-11 13:21:48'),
(246, '0', 7, 4, 3, 45.00, 135.00, 'SERVED', 'New', 1, 3, 10, 2, '2018-05-09 23:51:24', 10, '2018-05-11 13:21:49'),
(247, '0', 7, 5, 1, 35.00, 35.00, 'SERVED', 'New', 1, 3, 10, 2, '2018-05-09 23:51:24', 10, '2018-05-11 13:21:47'),
(248, '0', 8, 6, 4, 40.00, 160.00, 'SERVED', 'New', 1, 3, 10, 2, '2018-05-10 14:27:01', 10, '2018-05-11 13:21:48'),
(249, '0', 8, 10, 1, 45.00, 45.00, 'SERVED', 'New', 1, 3, 10, 2, '2018-05-10 14:27:01', 10, '2018-05-11 13:21:44'),
(250, '0', 8, 7, 1, 35.00, 35.00, 'SERVED', 'New', 1, 3, 10, 2, '2018-05-10 14:27:01', 10, '2018-05-11 13:21:44'),
(251, '0', 8, 4, 1, 45.00, 45.00, 'SERVED', 'New', 1, 3, 10, 2, '2018-05-10 14:27:01', 10, '2018-05-11 13:21:43'),
(252, '20', 9, 4, 1, 45.00, 45.00, 'SERVED', 'New', 2, 3, 10, 2, '2018-05-11 13:22:09', 10, '2018-05-11 13:23:54'),
(253, '20', 9, 6, 1, 40.00, 40.00, 'SERVED', 'New', 2, 3, 10, 2, '2018-05-11 13:22:09', 10, '2018-05-11 13:23:30'),
(254, '20', 9, 5, 1, 35.00, 35.00, 'SERVED', 'New', 2, 3, 10, 2, '2018-05-11 13:22:09', 10, '2018-05-11 13:23:53'),
(255, '20', 9, 10, 2, 45.00, 90.00, 'SERVED', 'Running', 2, 3, 10, 2, '2018-05-11 13:23:28', 10, '2018-05-11 13:23:53'),
(256, '20', 9, 9, 1, 25.00, 25.00, 'SERVED', 'Running', 2, 3, 10, 2, '2018-05-11 13:23:28', 10, '2018-05-11 13:23:52');

-- --------------------------------------------------------

--
-- Table structure for table `restaurant`
--

CREATE TABLE `restaurant` (
  `id` int(4) NOT NULL,
  `name` varchar(255) NOT NULL,
  `address` text NOT NULL,
  `contact_no` varchar(10) NOT NULL,
  `added_by` int(10) NOT NULL DEFAULT '0',
  `updated_by` int(10) NOT NULL DEFAULT '0',
  `added_time` timestamp NULL DEFAULT NULL,
  `updated_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `restaurant`
--

INSERT INTO `restaurant` (`id`, `name`, `address`, `contact_no`, `added_by`, `updated_by`, `added_time`, `updated_time`) VALUES
(2, 'Cheese n Chips', 'Halar Road, Valsad', '7820065248', 1, 0, '2018-04-10 13:51:04', '2018-04-10 08:21:15'),
(3, 'Sugar n Spice', 'Dharampur Road, Valsad', '7820065248', 1, 0, '2018-04-13 12:10:04', '2018-04-13 06:40:32');

-- --------------------------------------------------------

--
-- Table structure for table `review`
--

CREATE TABLE `review` (
  `id` int(11) NOT NULL,
  `rest_id` int(11) NOT NULL,
  `customer_name` varchar(255) NOT NULL,
  `customer_contact` varchar(50) DEFAULT NULL,
  `description` text NOT NULL,
  `user_id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `added_time` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `review`
--

INSERT INTO `review` (`id`, `rest_id`, `customer_name`, `customer_contact`, `description`, `user_id`, `role_id`, `added_time`) VALUES
(1, 3, 'Customer', '9090909090', 'Good Work, Keep it Up.', 10, 2, '2018-05-02 12:36:05'),
(2, 3, 'Customer1', '', '1. Good Work, Keep it Up.', 10, 2, '2018-05-02 13:01:59'),
(3, 3, 'Customer2', '', '2. Good Work, Keep it Up.', 10, 2, '2018-05-02 13:03:18'),
(4, 3, 'Customer3', '', '3. Good Work, Keep it Up.', 10, 2, '2018-05-02 13:03:43'),
(5, 3, 'Hirak', '', 'Feedback', 10, 2, '2018-05-02 13:13:58');

-- --------------------------------------------------------

--
-- Table structure for table `role_master`
--

CREATE TABLE `role_master` (
  `role_id` int(11) NOT NULL,
  `role_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `role_master`
--

INSERT INTO `role_master` (`role_id`, `role_name`) VALUES
(1, 'Super Admin'),
(2, 'Restaurant Admin');

-- --------------------------------------------------------

--
-- Table structure for table `transaction_history`
--

CREATE TABLE `transaction_history` (
  `transaction_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL DEFAULT '0',
  `res_id` int(11) NOT NULL DEFAULT '0',
  `transaction_type` int(11) NOT NULL COMMENT '0-opening , 1- add , 2 reedem',
  `type` varchar(255) DEFAULT NULL,
  `bill_amount` float(10,2) NOT NULL DEFAULT '0.00',
  `point` float(10,2) NOT NULL DEFAULT '0.00',
  `transaction_date` date NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `transaction_history`
--

INSERT INTO `transaction_history` (`transaction_id`, `customer_id`, `res_id`, `transaction_type`, `type`, `bill_amount`, `point`, `transaction_date`) VALUES
(1, 1, 2, 0, 'Opening', 0.00, 0.00, '2018-05-07'),
(2, 1, 2, 1, 'Credit', 500.00, 25.00, '2018-05-07'),
(3, 1, 2, 2, 'Reedem', 1000.00, 10.00, '2018-05-07'),
(4, 1, 2, 1, 'Credit', 300.00, 20.00, '2018-05-07'),
(5, 1, 2, 1, 'Credit', 300.00, 20.00, '2018-05-07'),
(6, 1, 2, 2, 'Reedem', 300.00, 20.00, '2018-05-07'),
(7, 1, 2, 2, 'Reedem', 300.00, 5.00, '2018-05-07'),
(8, 1, 2, 1, 'Credit', 300.00, 5.00, '2018-05-07'),
(9, 2, 2, 0, 'Opening', 0.00, 0.00, '2018-05-07');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `restaurant_id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL DEFAULT '2',
  `username` varchar(255) NOT NULL,
  `mobile_no` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `added_by` int(11) NOT NULL DEFAULT '0',
  `updated_by` int(11) NOT NULL DEFAULT '0',
  `added_time` timestamp NULL DEFAULT NULL,
  `updated_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `restaurant_id`, `role_id`, `username`, `mobile_no`, `password`, `added_by`, `updated_by`, `added_time`, `updated_time`) VALUES
(1, 0, 1, 'superadmin', '9904196933', 'e10adc3949ba59abbe56e057f20f883e', 0, 0, NULL, '2018-04-07 11:54:01'),
(10, 3, 2, 'hirak', '7820065248', 'e10adc3949ba59abbe56e057f20f883e', 1, 1, '2018-04-14 02:16:04', '2018-04-27 21:16:08');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `company`
--
ALTER TABLE `company`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customer_registration`
--
ALTER TABLE `customer_registration`
  ADD PRIMARY KEY (`customer_id`);

--
-- Indexes for table `final_order`
--
ALTER TABLE `final_order`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `food_category`
--
ALTER TABLE `food_category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `food_item`
--
ALTER TABLE `food_item`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `food_order_item`
--
ALTER TABLE `food_order_item`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `restaurant`
--
ALTER TABLE `restaurant`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `review`
--
ALTER TABLE `review`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `role_master`
--
ALTER TABLE `role_master`
  ADD PRIMARY KEY (`role_id`);

--
-- Indexes for table `transaction_history`
--
ALTER TABLE `transaction_history`
  ADD PRIMARY KEY (`transaction_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `company`
--
ALTER TABLE `company`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `customer_registration`
--
ALTER TABLE `customer_registration`
  MODIFY `customer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `final_order`
--
ALTER TABLE `final_order`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `food_category`
--
ALTER TABLE `food_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `food_item`
--
ALTER TABLE `food_item`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;
--
-- AUTO_INCREMENT for table `food_order_item`
--
ALTER TABLE `food_order_item`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=257;
--
-- AUTO_INCREMENT for table `restaurant`
--
ALTER TABLE `restaurant`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `review`
--
ALTER TABLE `review`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `role_master`
--
ALTER TABLE `role_master`
  MODIFY `role_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `transaction_history`
--
ALTER TABLE `transaction_history`
  MODIFY `transaction_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
