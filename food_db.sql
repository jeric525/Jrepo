-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 19, 2024 at 11:25 AM
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
-- Database: `food_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(100) NOT NULL,
  `name` varchar(20) NOT NULL,
  `password` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `name`, `password`) VALUES
(1, 'admin', '6216f8a75fd5bb3d5f22b6f9958cdede3fc086c2');

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(100) NOT NULL,
  `user_id` int(100) NOT NULL,
  `pid` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `price` int(10) NOT NULL,
  `quantity` int(10) NOT NULL,
  `image` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`id`, `user_id`, `pid`, `name`, `price`, `quantity`, `image`) VALUES
(5, 3, 2, 'Strawberry Shake', 50, 1, 'dessert-1.png');

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int(100) NOT NULL,
  `user_id` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `number` varchar(12) NOT NULL,
  `message` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `user_id`, `name`, `email`, `number`, `message`) VALUES
(1, 2, 'j', 'j@gmail.com', '0912345678', 'i enjoyed the meal');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(100) NOT NULL,
  `user_id` int(100) NOT NULL,
  `name` varchar(20) NOT NULL,
  `number` varchar(10) NOT NULL,
  `email` varchar(50) NOT NULL,
  `method` varchar(50) NOT NULL,
  `address` varchar(500) NOT NULL,
  `total_products` varchar(1000) NOT NULL,
  `total_price` int(100) NOT NULL,
  `placed_on` date NOT NULL DEFAULT current_timestamp(),
  `payment_status` varchar(20) NOT NULL DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `name`, `number`, `email`, `method`, `address`, `total_products`, `total_price`, `placed_on`, `payment_status`) VALUES
(8, 2, 'Justine', '0912345678', 'j@gmail.com', 'gcash', '5, Dibuluan, Jones, Isabela, 3313', 'Spaghetti (60 x 1) - Pepperoni Pizza (100 x 1) - ', 160, '2024-01-23', 'completed'),
(9, 2, 'Justine', '0912345678', 'j@gmail.com', 'credit card', '5, Dibuluan, Jones, Isabela, 3313', 'Burger (30 x 2) - ', 60, '2024-01-23', 'pending'),
(10, 2, 'Justine', '0912345678', 'j@gmail.com', 'cash on delivery', '5, Dibuluan, Jones, Isabela, 3313', 'Burger (30 x 3) - ', 90, '2024-01-23', 'pending'),
(11, 2, 'Justine', '0912345678', 'j@gmail.com', 'cash on delivery', '5, Dibuluan, Jones, Isabela, 3313', 'Burger (30 x 1) - Pepperoni Pizza (100 x 2) - ', 230, '2024-01-24', 'completed'),
(12, 2, 'Justine', '0912345678', 'j@gmail.com', 'gcash', '5, Dibuluan, Jones, Isabela, 3313', 'Strawberry Shake (50 x 1) - ', 50, '2024-01-24', 'pending'),
(13, 2, 'Justine', '0912345678', 'j@gmail.com', 'credit card', '5, Dibuluan, Jones, Isabela, 3313', 'Spaghetti (60 x 1) - Orange Juice (10 x 1) - Pepperoni Pizza (100 x 1) - Burger (30 x 1) - Steak (459 x 1) - Strawberry Ice Cream (70 x 1) - Coffee (20 x 1) - Strawberry Juice (22 x 1) - ', 771, '2024-01-24', 'completed');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `category` varchar(100) NOT NULL,
  `quantity` int(50) NOT NULL,
  `price` int(10) NOT NULL,
  `image` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `category`, `quantity`, `price`, `image`) VALUES
(2, 'Strawberry Shake', 'desserts', 0, 50, 'dessert-1.png'),
(3, 'Spaghetti', 'main dish', 11, 60, 'dish-1.png'),
(4, 'Orange Juice', 'drinks', 23, 10, 'drink-1.png'),
(5, 'Pepperoni Pizza', 'fast food', 17, 100, 'pizza-3.png'),
(6, 'Burger', 'fast food', 43, 30, 'burger-1.png'),
(7, 'Steak', 'main dish', 9, 459, 'dish-4.png'),
(8, 'Strawberry Ice Cream', 'desserts', 14, 70, 'dessert-5.png'),
(9, 'Coffee', 'drinks', 23, 20, 'drink-2.png'),
(10, 'Strawberry Juice', 'drinks', 25, 22, 'drink-5.png'),
(11, 'Pasta', 'main dish', 13, 150, 'dish-3.png'),
(12, 'Chocolate Cake', 'desserts', 20, 28, 'dessert-2.png'),
(13, 'Chicken Burger', 'fast food', 34, 32, 'burger-2.png'),
(14, 'Mushroom Pizza', 'fast food', 14, 100, 'pizza-5.png');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(100) NOT NULL,
  `name` varchar(20) NOT NULL,
  `email` varchar(50) NOT NULL,
  `number` varchar(10) NOT NULL,
  `password` varchar(50) NOT NULL,
  `remember_me` longtext NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `address` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `number`, `password`, `remember_me`, `timestamp`, `address`) VALUES
(1, 'admin', 'admin@gmail.com', '1234', '356a192b7913b04c54574d18c28d46e6395428ab', '', '2024-01-25 13:16:57', ''),
(2, 'Justine', 'j@gmail.com', '0912345678', '356a192b7913b04c54574d18c28d46e6395428ab', '513ee6e64eb13d840d9fca5f35dc8c474964fba274daf71f5831b45f23135a10', '2024-01-25 13:17:24', '5, Dibuluan, Jones, Isabela, 3313'),
(3, 'admin', 'a1@gmail.com', '0979544212', '356a192b7913b04c54574d18c28d46e6395428ab', '', '2024-01-25 13:16:57', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

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
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
