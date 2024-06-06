-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jun 06, 2024 at 10:29 AM
-- Server version: 8.3.0
-- PHP Version: 8.2.18

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
-- Table structure for table `about`
--

DROP TABLE IF EXISTS `about`;
CREATE TABLE IF NOT EXISTS `about` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `subtitle` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `link` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `about`
--

INSERT INTO `about` (`id`, `title`, `subtitle`, `content`, `link`, `image`, `created_at`) VALUES
(1, 'WHY CHOOSE ME? BECAUSE I\'M THE BEST!', 'KNOW ABOUT ME', '<p>Our state of the <strong>art gyms provide yo</strong>u with a great place to work out in, whether you are there to burn off some calories or are training for something more specific. Why not visit your nearest Gym Center and take a look? We\'re here to help you<em>! Train with the best experts in b</em>odybuilding field. Our personal trainers will help you find a perfect workout.</p>', '#', 'img-02.jpg', '2024-05-27 16:46:33');

-- --------------------------------------------------------

--
-- Table structure for table `blog_posts`
--

DROP TABLE IF EXISTS `blog_posts`;
CREATE TABLE IF NOT EXISTS `blog_posts` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `author` varchar(255) NOT NULL,
  `category_id` int NOT NULL,
  `featured_image` varchar(255) DEFAULT NULL,
  `published_date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `slug` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`),
  KEY `category_id` (`category_id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `blog_posts`
--

INSERT INTO `blog_posts` (`id`, `title`, `content`, `author`, `category_id`, `featured_image`, `published_date`, `created_at`, `slug`) VALUES
(1, 'Ovo je neki clanak', '<h3>EATING HABIT FOR BEST PERFORMANCE</h3>\r\n<p>It is a long established f<strong>act that a reader will be </strong>distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using &lsquo;Content here, content here&rsquo;, making it look like readable English. Many desktop publishing packages and web page editors Sed eleifend ligula vitae ligula euismod porta. Donec in accumsan tellus.</p>\r\n<h3>EATING HABIT FOR BEST PERFORMANCE</h3>\r\n<p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using &lsquo;Content here, content here&rsquo;, making it look like readable English. Many desktop publishing packages and web page editors Sed eleifend ligula vitae ligula euismod porta. Donec in accumsan tellus.</p>', 'Sasa', 1, 'uploads/DSC02594_1.jpg', '2024-05-17', '2024-05-24 21:00:26', 'fitness-is-not-about-being-better-than-someone-else'),
(2, 'HOW TO KEEP YOUR BODY HEALTHY IN OVER THE FESTIVAL', 'asd asd asdad asd asd asdad asd asd asdad asd asd asdad asd asd asdad asd asd asdad asd asd asdad asd asd asdad asd asd asdad asd asd asdad asd asd asdad asd asd asdad asd asd asdad asd asd asdad asd asd asdad asd asd asdad asd asd asdad asd asd asdad asd asd asdad asd asd asdad asd asd asdad asd asd asdad asd asd asdad asd asd asdad asd asd asdad asd asd asdad asd asd asdad asd asd asdad asd asd asdad asd asd asdad asd asd asdad asd asd asdad asd asd asdad asd asd asdad asd asd asdad asd asd asdad asd asd asdad asd asd asdad asd asd asdad asd asd asdad asd asd asdad asd asd asdad asd asd asdad asd asd asdad asd asd asdad asd asd asdad asd asd asdad asd asd asdad asd asd asdad asd asd asdad asd asd asdad asd asd asdad asd asd asdad asd asd asdad asd asd asdad asd asd asdad asd asd asdad asd asd asdad asd asd asdad asd asd asdad asd asd asdad asd asd asdad asd asd asdad asd asd asdad asd asd asdad asd asd asdad asd asd asdad asd asd asdad asd asd asdad asd asd asdad asd asd asdad asd asd asdad asd asd asdad asd asd asdad asd asd asdad asd asd asdad asd asd asdad asd asd asdad asd asd asdad asd asd asdad asd asd asdad asd asd asdad asd asd asdad asd asd asdad asd asd asdad asd asd asdad asd asd asdad asd asd asdad asd asd asdad asd asd asdad asd asd asdad asd asd asdad asd asd asdad asd asd asdad asd asd asdad asd asd asdad asd asd asdad asd asd asdad asd asd asdad asd asd asdad asd asd asdad asd asd asdad asd asd asdad asd asd asdad asd asd asdad asd asd asdad asd asd asdad asd asd asdad asd asd asdad asd asd asdad asd asd asdad asd asd asdad asd asd asdad asd asd asdad asd asd asdad asd asd asdad asd asd asdad asd asd asdad asd asd asdad asd asd asdad asd asd asdad asd asd asdad asd asd asdad asd asd asdad asd asd asdad asd asd asdad asd asd asdad asd asd asdad asd asd asdad asd asd asdad asd asd asdad asd asd asdad asd asd asdad asd asd asdad asd asd asdad asd asd asdad asd asd asdad asd asd asdad asd asd asdad asd asd asdad asd asd asdad asd asd asdad asd asd asdad asd asd asdad asd asd asdad asd asd asdad asd asd asdad asd asd asdad asd asd asdad asd asd asdad asd asd asdad asd asd asdad asd asd asdad asd asd asdad asd asd asdad asd asd asdad asd asd asdad asd asd asdad asd asd asdad asd asd asdad asd asd asdad asd asd asdad asd asd asdad asd asd asdad asd asd asdad asd asd asdad asd asd asdad asd asd asdad ', 'Gare', 1, 'uploads/173986953_289671602597313_3386159334588386286_n.jpg', '2024-05-09', '2024-05-24 21:29:49', 'how-to-keep-your-body-healthy-in-over-festival'),
(3, 'SUCCESS STORY: JOHN SHARES HIS TRANSFORM STORY', 'asd asd asdad asd asd asdad asd asd asdad asd asd asdad asd asd asdad asd asd asdad asd asd asdad asd asd asdad asd asd asdad asd asd asdad asd asd asdad asd asd asdad asd asd asdad asd asd asdad asd asd asdad asd asd asdad asd asd asdad asd asd asdad asd asd asdad asd asd asdad asd asd asdad asd asd asdad asd asd asdad asd asd asdad asd asd asdad asd asd asdad asd asd asdad asd asd asdad asd asd asdad asd asd asdad asd asd asdad asd asd asdad asd asd asdad asd asd asdad asd asd asdad asd asd asdad asd asd asdad asd asd asdad asd asd asdad asd asd asdad asd asd asdad asd asd asdad asd asd asdad asd asd asdad asd asd asdad asd asd asdad asd asd asdad asd asd asdad asd asd asdad asd asd asdad asd asd asdad asd asd asdad asd asd asdad asd asd asdad asd asd asdad asd asd asdad asd asd asdad asd asd asdad asd asd asdad asd asd asdad asd asd asdad asd asd asdad asd asd asdad asd asd asdad asd asd asdad asd asd asdad asd asd asdad asd asd asdad asd asd asdad asd asd asdad asd asd asdad asd asd asdad asd asd asdad asd asd asdad asd asd asdad asd asd asdad asd asd asdad asd asd asdad asd asd asdad asd asd asdad asd asd asdad asd asd asdad asd asd asdad asd asd asdad asd asd asdad asd asd asdad asd asd asdad asd asd asdad asd asd asdad asd asd asdad asd asd asdad asd asd asdad asd asd asdad asd asd asdad asd asd asdad asd asd asdad asd asd asdad asd asd asdad asd asd asdad asd asd asdad asd asd asdad asd asd asdad asd asd asdad asd asd asdad asd asd asdad asd asd asdad asd asd asdad asd asd asdad asd asd asdad asd asd asdad asd asd asdad asd asd asdad ', 'Gare', 2, 'uploads/IMG_20220502_213649_549.jpg', '2024-05-01', '2024-05-24 21:30:23', 'success-story-john-shares-his-transform-story'),
(4, 'WHY CHOOSE US? BECAUSE WEâ€™RE THE BEST.', 'Our state of the art gyms provide you with a great place to work out in, whether you are there to burn off some calories or are training for something more specific. Why not visit your nearest Gym Center and take a look? Weâ€™re here to help you!\r\n\r\nTrain with the best experts in bodybuilding field.\r\nOur personal trainers will help you find a perfect workout.', 'Sasa', 3, 'uploads/blog-01.jpg', '2024-05-30', '2024-05-24 22:26:38', 'why-choose-us-beacuse-we-are-the-best'),
(5, 'How to Modify any Program to Improve Weakness', '<p><strong>Our gyms are designed</strong> and maintained to the highest standards, with state-of-the-art equipment. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>\r\n<p>Ut enim ad minim veniam,<a href=\"#\" target=\"_blank\" rel=\"noopener\"> quis nostrud exercitation </a>ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Cum sociis</p>\r\n<h2><strong>Theme natoque</strong></h2>\r\n<p>penatibus et magnis dis par<em>turient montes, nascetur ridiculus mus.\\r\\n\\r\\nQuisque mattis, li</em>gula id sodales ullamcorper, urna sem placerat lacus, id laoreet lectus sapien quis nisl. Phasellus eu massa id leo consectetur vehicula. Donec quis finibus lacus, id accumsan magna. Etiam ullamcorper id quam vitae iaculis.</p>\r\n<p></p>', 'Gare', 4, 'uploads/blog-01.jpg', '2024-05-25', '2024-05-25 13:02:23', 'how-to-modify-any-program-to-improve-weakness');

-- --------------------------------------------------------

--
-- Table structure for table `blog_post_tags`
--

DROP TABLE IF EXISTS `blog_post_tags`;
CREATE TABLE IF NOT EXISTS `blog_post_tags` (
  `blog_post_id` int NOT NULL,
  `tag_id` int NOT NULL,
  PRIMARY KEY (`blog_post_id`,`tag_id`),
  KEY `tag_id` (`tag_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `blog_post_tags`
--

INSERT INTO `blog_post_tags` (`blog_post_id`, `tag_id`) VALUES
(1, 3),
(2, 2),
(3, 1),
(3, 2),
(4, 3),
(5, 2),
(5, 7),
(8, 2),
(8, 4);

-- --------------------------------------------------------

--
-- Table structure for table `blog_section`
--

DROP TABLE IF EXISTS `blog_section`;
CREATE TABLE IF NOT EXISTS `blog_section` (
  `id` int NOT NULL AUTO_INCREMENT,
  `section_title` varchar(255) DEFAULT NULL,
  `section_subtitle` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `blog_section`
--

INSERT INTO `blog_section` (`id`, `section_title`, `section_subtitle`) VALUES
(1, 'SEE WHAT\'S HAPPENNING AROUND', 'LATEST BLOG POSTS');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
CREATE TABLE IF NOT EXISTS `categories` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `featured_image` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `featured_image`) VALUES
(1, 'Fitness', 'uploads/68725727_2422332131179969_4718199386302054400_o.jpg'),
(2, 'Nutrition', 'uploads/DSC02594_1.jpg'),
(3, 'Wellness', 'uploads/gacik-aleksandar (1).jpg'),
(4, 'Running', 'uploads/68725727_2422332131179969_4718199386302054400_o.jpg'),
(5, 'Dijeta', 'uploads/blog-01.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `pricing`
--

DROP TABLE IF EXISTS `pricing`;
CREATE TABLE IF NOT EXISTS `pricing` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `price` int NOT NULL,
  `currency_symbol` varchar(10) NOT NULL,
  `frequency` varchar(50) NOT NULL,
  `features` text NOT NULL,
  `is_featured` tinyint(1) NOT NULL,
  `link` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pricing`
--

INSERT INTO `pricing` (`id`, `title`, `price`, `currency_symbol`, `frequency`, `features`, `is_featured`, `link`) VALUES
(1, 'BASIC PLAN', 120, '€', 'Monthly', 'Free Custom,\r\n Outstanding,\r\n Happy Customers', 0, '#'),
(2, 'STANDARD PLAN', 150, '€', 'Monthly', 'Free Custom,\r\n Outstanding,\r\n Happy Customers', 1, '#'),
(3, 'Ultimate plan', 210, '€', 'Monthly', 'Free Custom,\r\nOutstanding,\r\nHappy Customers', 0, '#');

-- --------------------------------------------------------

--
-- Table structure for table `pricing_section`
--

DROP TABLE IF EXISTS `pricing_section`;
CREATE TABLE IF NOT EXISTS `pricing_section` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `subtitle` varchar(255) NOT NULL,
  `content` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pricing_section`
--

INSERT INTO `pricing_section` (`id`, `title`, `subtitle`, `content`) VALUES
(1, 'FIND THE PERFECT PLAN', 'PRICING TABLE', 'Our state of the art gyms provide you with a great place to work out in, whether you are there to burn off some calories or are training for something more specific.');

-- --------------------------------------------------------

--
-- Table structure for table `programs`
--

DROP TABLE IF EXISTS `programs`;
CREATE TABLE IF NOT EXISTS `programs` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `subtitle` varchar(255) NOT NULL,
  `icon` varchar(255) NOT NULL,
  `link` varchar(255) NOT NULL,
  `content` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `programs`
--

INSERT INTO `programs` (`id`, `title`, `subtitle`, `icon`, `link`, `content`) VALUES
(1, 'CARDIO PROGRAM', 'FRIENDLY ATMOSPHERE', 'fruits', '#', 'Make the muscles of your body larger and fit stronger through tension and exercises such as lifting weights.'),
(2, 'PURE STRENGTH', 'FRIENDLY ATMOSPHERE', 'running-man', '#', 'Make the muscles of your body larger and fit stronger through tension and exercises such as lifting weights.'),
(3, 'POWER YOGA', 'FRIENDLY ATMOSPHERE', 'wellness', '#', 'Make the muscles of your body larger and fit stronger through tension and exercises such as lifting weights.');

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

DROP TABLE IF EXISTS `services`;
CREATE TABLE IF NOT EXISTS `services` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `icon` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `image` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `link` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`id`, `title`, `icon`, `description`, `image`, `created_at`, `link`) VALUES
(5, 'Diet service', 'diet-1', 'as dasd aasdas asd', 'uploads/173986953_289671602597313_3386159334588386286_n.jpg', '2024-05-27 11:12:00', '#'),
(2, 'Self Defense', 'no-smoking', 'Donâ€™t practice until you get it right practice until canâ€™t wrong', 'uploads/blog-01.jpg', '2024-05-27 08:55:54', '#'),
(4, 'Strength Training', 'wellness', 'Improve your body strength with Join our trainings & get shape.', 'images/homepage-2/service/service-03.jpg', '2024-05-27 08:55:54', '#');

-- --------------------------------------------------------

--
-- Table structure for table `services_section`
--

DROP TABLE IF EXISTS `services_section`;
CREATE TABLE IF NOT EXISTS `services_section` (
  `id` int NOT NULL AUTO_INCREMENT,
  `section_title` varchar(255) DEFAULT NULL,
  `section_subtitle` varchar(255) DEFAULT NULL,
  `section_content` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `services_section`
--

INSERT INTO `services_section` (`id`, `section_title`, `section_subtitle`, `section_content`) VALUES
(1, 'OUR FEATURED CLASSES', 'OUR CLASSES', 'Fitness is not about being better than someone. Fitness is about being better than the person you were yesterday. Whether you are there to burn off some calories or are training.');

-- --------------------------------------------------------

--
-- Table structure for table `sliders`
--

DROP TABLE IF EXISTS `sliders`;
CREATE TABLE IF NOT EXISTS `sliders` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `subtitle` varchar(255) NOT NULL,
  `background_image` varchar(255) NOT NULL,
  `link` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sliders`
--

INSERT INTO `sliders` (`id`, `title`, `subtitle`, `background_image`, `link`) VALUES
(1, 'The best fitness studio in town', 'The Runner\'s Life  							', 'slider-2.jpg', '#'),
(3, 'as dasda sas d', 'as dasda sdasd', 'slider-1.jpg', '#'),
(4, 'The best fitness studio in town', 'The runner\'s life', 'slider-3.jpg', '#');

-- --------------------------------------------------------

--
-- Table structure for table `tags`
--

DROP TABLE IF EXISTS `tags`;
CREATE TABLE IF NOT EXISTS `tags` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `featured_image` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tags`
--

INSERT INTO `tags` (`id`, `name`, `featured_image`) VALUES
(1, 'Cardio', 'uploads/277779603_1827067824161103_3882222726960542119_n.jpg'),
(2, 'Strength', 'uploads/IMG_20220502_213649_549.jpg'),
(3, 'Yoga', 'uploads/DSC02594_1.jpg'),
(4, 'BJJ', 'uploads/173986953_289671602597313_3386159334588386286_n.jpg'),
(7, 'Injury', 'uploads/IMG_20220502_213649_549.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `testimonials`
--

DROP TABLE IF EXISTS `testimonials`;
CREATE TABLE IF NOT EXISTS `testimonials` (
  `id` int NOT NULL AUTO_INCREMENT,
  `author_name` varchar(100) NOT NULL,
  `author_designation` varchar(100) DEFAULT NULL,
  `testimonial_text` text NOT NULL,
  `rating` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `testimonials`
--

INSERT INTO `testimonials` (`id`, `author_name`, `author_designation`, `testimonial_text`, `rating`, `created_at`) VALUES
(1, 'Marko', 'Expert', 'Fitness Gym isn\'t anything like a regular chain gym. The gym also has amazing equipment that you don\'t find in most gyms like Kettlebells, challengin battle ropes and sledges.', 3, '2024-05-25 20:12:43'),
(2, 'Jovana S.', 'Journalist', 'Fitness Gym isnï¿½t anything like a regular chain gym. The gym also has amazing equipment that you donï¿½t find in most gyms like Kettlebells, challeng battle ropes and sledges.', 4, '2024-05-25 20:12:43'),
(4, 'Milica', 'Model', 'Fitness Within is an amazing gym and community of trainers and clients that all want one thingâ€¦.to be the best version of themselves! Workouts, nutrition plans, everything is tailored to your body and current fitness journey! I came in with back and shoulder issues.', 5, '2024-05-26 10:46:07');

-- --------------------------------------------------------

--
-- Table structure for table `testimonial_section`
--

DROP TABLE IF EXISTS `testimonial_section`;
CREATE TABLE IF NOT EXISTS `testimonial_section` (
  `id` int NOT NULL AUTO_INCREMENT,
  `section_title` varchar(255) DEFAULT NULL,
  `section_subtitle` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `testimonial_section`
--

INSERT INTO `testimonial_section` (`id`, `section_title`, `section_subtitle`) VALUES
(1, 'WHAT OUR CLIENTS SAY ABOUT US', 'OUR TESTIMONIAL');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `email`, `created_at`) VALUES
(1, 'gare', '$2y$10$3cEWS0jq8jEbkhHvUDNaEO3Qbmich4Ci.2fdRN3C9vePQZeyLAtqa', 'garegaree@gmail.com', '2024-05-24 19:23:22');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
