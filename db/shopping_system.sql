-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Oct 12, 2020 at 02:24 PM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.2.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `shopping_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `cart_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `u_id` int(11) DEFAULT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `new_price` double(20,2) NOT NULL,
  `dateTime` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`cart_id`, `product_id`, `u_id`, `quantity`, `new_price`, `dateTime`) VALUES
(128, 5, 10, 2, 798.00, '2020-10-12 11:15:57');

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `pid` int(11) NOT NULL,
  `pname` varchar(20) DEFAULT NULL,
  `detail` varchar(255) DEFAULT NULL,
  `img` varchar(255) DEFAULT NULL,
  `price` double(20,2) DEFAULT NULL,
  `discription` varchar(255) NOT NULL,
  `type` varchar(30) DEFAULT NULL,
  `instock` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`pid`, `pname`, `detail`, `img`, `price`, `discription`, `type`, `instock`) VALUES
(1, 'nokia 3301', 'Nokia 3301,ram 2gb,memory 16gb,camera 5mp', 'img/nokia.jpg', 2000.00, '\r\n    Dual SIM phone\r\n    2.4-inch (6.1 cm) screen\r\n    22 hours talk time\r\n    Rear camera\r\n    FM Radio, MP3 player\r\n    Customer care number - 1800 1028 169\r\n    Country of Origin: India\r\n', 'electronic', 3),
(2, 'Earphone', 'JBL', 'img/jbl.jpeg', 700.00, '', 'electronic', 0),
(3, 'Tshirt', 'M size mens shirt', 'img/mtshirt.jpg', 300.00, '', 'clothing', 0),
(5, 'Jens', '30 size mens jeans', 'img/jens30.jpg', 399.00, '', 'clothing', 0),
(7, 'Sony camera', '40MPX sony Digital camera', 'img/sonycam40mp.jpg', 25000.00, '', 'electronic', 0);

-- --------------------------------------------------------

--
-- Table structure for table `user_table`
--

CREATE TABLE `user_table` (
  `user_id` int(11) NOT NULL,
  `user_email_address` varchar(250) NOT NULL,
  `user_password` varchar(150) NOT NULL,
  `user_verfication_code` varchar(100) NOT NULL,
  `user_name` varchar(150) NOT NULL,
  `user_gender` enum('Male','Female') NOT NULL,
  `user_address` text NOT NULL,
  `user_mobile_no` varchar(30) NOT NULL,
  `user_image` varchar(150) NOT NULL,
  `user_created_on` datetime NOT NULL,
  `user_email_verified` enum('no','yes') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_table`
--

INSERT INTO `user_table` (`user_id`, `user_email_address`, `user_password`, `user_verfication_code`, `user_name`, `user_gender`, `user_address`, `user_mobile_no`, `user_image`, `user_created_on`, `user_email_verified`) VALUES
(4, 'raksharampatel0408@gmail.com', '$2y$10$3Yr//0RKBQtF4oQDVykA0epLjngHhEijaD6WzSRhxei1PUbKZDO0S', '5b1ac2a1933527ad5476ae2f1e07949b', 'Raksh', 'Male', 'pune', '9373634951', '5f7f4aefbc47e.png', '2020-10-08 19:22:55', 'yes'),
(9, 'mokshparmar1998@gmail.com', '$2y$10$nTgWXiZlKDz//uix4KqmpeZ4xQl7jC9qT.sojXxY9yPmLhNR.Rf9W', 'f11d6c88e2efe8d83fc7c27b8114de26', 'Moksh', 'Male', 'Bibwewadi, Pune-37', '9518530410', '5f82a5f1c3b7f.jpg', '2020-10-11 08:28:01', 'yes'),
(10, 'chauhanbhaskar51@gmail.com', '$2y$10$hsvpF0W.mssB1PogodeOveEr77tCMG4fKEVDgjBNq.76vCs34UmAG', '8fb5e4bcf878a7e68be1c52ef2fa82ca', 'Bhaskar Chauhan', 'Male', 'Balajinagar, Pune-43', '7620264927', '5f843a254a48b.jpeg', '2020-10-12 13:12:37', 'yes');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`cart_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`pid`);

--
-- Indexes for table `user_table`
--
ALTER TABLE `user_table`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `cart_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=129;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `pid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `user_table`
--
ALTER TABLE `user_table`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `product` (`pid`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
