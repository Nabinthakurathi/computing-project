-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 24, 2019 at 02:05 PM
-- Server version: 10.1.36-MariaDB
-- PHP Version: 7.2.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `liquorstore`
--

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` int(11) NOT NULL,
  `username` varchar(30) NOT NULL,
  `address` varchar(50) NOT NULL,
  `phone` varchar(50) NOT NULL,
  `password` varchar(200) NOT NULL,
  `email` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `username`, `address`, `phone`, `password`, `email`) VALUES
(1, 'storeadmin', 'Nepal', '9841868768', '65c77a859899488ed71401488ba7a9f10a43f594', 'storeadmin@admin.com');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(30) NOT NULL,
  `price` float NOT NULL,
  `description` varchar(105) NOT NULL,
  `category` varchar(50) NOT NULL,
  `shippingCost` int(11) NOT NULL,
  `imageName` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `price`, `description`, `category`, `shippingCost`, `imageName`) VALUES
(1, 'Nepal Ice', 3, 'Made with natural barley, Nepal Ice is the largest selling beer brand of the Chaudhary Groupâ€™s.', 'Beer', 1, '1561377170-0016645_nepal-ice-strong-bottle-650ml_600.jpeg'),
(2, 'Sherpa Craft', 2, ' This beer is brewed using ale yeast, the top-fermenting yeast that gives a mixture of complex flavors.', 'Beer', 1, '1561377417-18557037_1447518418635349_1745890184872215208_n.jpg'),
(3, 'Gorkha', 2, 'The name is derived from the word, Gurkha, the brave soldiers of Nepal.', 'Beer', 1, '1561377595-Nepal-Pokhara-Poon-Hill-Trek-230.jpg'),
(4, 'Everest', 3, 'Everest beer was launched to tribute the 50th Golden Jubilee celebration of the conquest of Mt. Everest.', 'Beer', 1, '1561377693-bbae818730a760e12eabcf6a2c5c4dd0.jpg'),
(5, 'Diplomatico Rum ', 22, 'This is distilled in copper pot stills,12 years old and considered among the best Venezuelan rums.', 'Rums', 2, '1561377855-1551977190-1487870659-diplomatico-reserva-exclusiva-rum-solera-venezuela-rom-40-alc-p.jpg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`customer_id`,`product_id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
