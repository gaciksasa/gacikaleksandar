-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jun 14, 2024 at 10:40 AM
-- Server version: 5.7.36
-- PHP Version: 7.4.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `gacikaleksandar`
--

-- --------------------------------------------------------

--
-- Table structure for table `tags`
--

DROP TABLE IF EXISTS `tags`;
CREATE TABLE IF NOT EXISTS `tags` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `featured_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `language` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'sr',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tags`
--

INSERT INTO `tags` (`id`, `name`, `featured_image`, `language`) VALUES
(1, 'Cardio', 'uploads/277779603_1827067824161103_3882222726960542119_n.jpg', 'en'),
(2, 'Strength', 'uploads/IMG_20220502_213649_549.jpg', 'en'),
(3, 'Yoga', 'uploads/DSC02594_1.jpg', 'en'),
(4, 'BJJ', 'uploads/173986953_289671602597313_3386159334588386286_n.jpg', 'en'),
(7, 'Injury', 'uploads/IMG_20220502_213649_549.jpg', 'en'),
(8, 'Kardio', 'uploads/277779603_1827067824161103_3882222726960542119_n.jpg', 'sr'),
(10, 'Povrede', 'uploads/strength-1.png', 'sr'),
(11, 'Snaga', 'uploads/IMG_20220502_213649_549.webp', 'sr'),
(12, 'BJJ', 'uploads/173986953_289671602597313_3386159334588386286_n.jpg', 'sr');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
