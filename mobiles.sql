-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 18, 2024 at 07:03 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `own_cart`
--

-- --------------------------------------------------------

--
-- Table structure for table `mobiles`
--

CREATE TABLE `mobiles` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `rating` decimal(3,1) NOT NULL,
  `photo` varchar(255) NOT NULL,
  `is_removed` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `mobiles`
--

INSERT INTO `mobiles` (`id`, `name`, `price`, `rating`, `photo`, `is_removed`) VALUES
(1, 'vivo T2x 5G (Aurora Gold, 128 GB) (4 GB RAM)', 11999.00, 4.4, 'vivot2x.jpeg', 0),
(2, 'Apple iPhone 14 (Starlight, 128 GB)', 57999.00, 4.6, 'iphone14.jpeg', 0),
(3, 'Google Pixel 7 (Snow, 128 GB) (8 GB RAM)', 32999.00, 4.3, 'Pixel7.jpeg', 0),
(4, 'realme 11x 5G (Purple Dawn, 128 GB) (6 GB RAM)', 14999.00, 4.4, 'realme11x.jpeg', 0),
(5, 'SAMSUNG Galaxy F14 5G (B.A.E. Purple, 128 GB) (4 GB RAM)', 10990.00, 4.2, 'GalaxyF14.jpeg', 0),
(6, 'Apple iPhone 13 (Green, 128 GB)', 50990.00, 4.6, 'iPhone13.jpeg', 0),
(7, 'SAMSUNG Galaxy S23 5G (Lavender, 256 GB) (8 GB RAM)', 49999.00, 4.5, 'GalaxyS23s.jpeg', 0),
(8, 'OPPO Reno8T 5G (Sunrise Gold, 128 GB) (8 GB RAM)', 38999.00, 4.3, 'Reno8T.jpeg', 0),
(9, 'POCO M4 5G (Cool Blue, 64 GB) (4 GB RAM)', 12999.00, 4.2, 'POCOM4.jpeg', 0),
(10, 'vivo X90 (Asteroid Black, 256 GB) (8 GB RAM)', 61999.00, 4.4, 'vivoX90.jpeg', 0),
(11, 'Motorola Edge 30 Fusion (Cosmic grey, 128 GB) (8 GB RAM)', 42999.00, 4.3, 'Edge30.jpeg', 0),
(12, 'Apple iPhone 15 (Black, 128 GB)', 65499.00, 4.6, 'iPhone15.jpeg', 0),
(13, 'SAMSUNG Galaxy M14 4G (Arctic Blue, 64 GB) (4 GB RAM)', 8565.00, 4.0, 'GalaxyM14.jpeg', 0),
(14, 'Nothing Phone (2a) 5G (Black, 256 GB) (12 GB RAM)', 27999.00, 4.4, 'Phone(2a).jpeg', 0),
(15, 'Nothing Phone (2a) 5G (Black, 256 GB) (8 GB RAM)', 25999.00, 4.4, 'Phone(2a)8.jpeg', 0),
(16, 'Motorola Edge 50 Pro 5G (Moonlight Pearl, 256 GB) (8 GB RAM)', 29999.00, 4.4, 'Edge50Pro.jpeg', 0),
(17, 'realme Narzo 70 Pro 5G (Glass Gold, 256 GB) (8 GB RAM)', 18266.00, 4.4, 'Narzo70Pro.jpeg', 0),
(27, 'shukoor', 1234.00, 1.5, 'https://th.bing.com/th/id/OIP.0JsJtagT8cRezbdlxOt7cgHaHa?rs=1&pid=ImgDetMain', 0),
(28, 'shukoor', 1234.00, 1.5, 'https://th.bing.com/th/id/OIP.GyWNmHOuAgUwTSlF8u39TgHaHQ?w=173&h=180&c=7&r=0&o=5&dpr=1.3&pid=1.7', 0),
(29, 'shukoor', 1234.00, 1.5, 'https://th.bing.com/th/id/OIP.GyWNmHOuAgUwTSlF8u39TgHaHQ?w=173&h=180&c=7&r=0&o=5&dpr=1.3&pid=1.7', 0),
(30, 'shukoor', 1234.00, 1.5, 'https://th.bing.com/th/id/OIP.GyWNmHOuAgUwTSlF8u39TgHaHQ?w=173&h=180&c=7&r=0&o=5&dpr=1.3&pid=1.7', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `mobiles`
--
ALTER TABLE `mobiles`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `mobiles`
--
ALTER TABLE `mobiles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
