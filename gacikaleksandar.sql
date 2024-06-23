-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jun 22, 2024 at 08:40 PM
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
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `subtitle` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `link` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `language` varchar(2) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'sr',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `about`
--

INSERT INTO `about` (`id`, `title`, `subtitle`, `content`, `link`, `image`, `created_at`, `language`) VALUES
(2, 'Personal trainer with specialized skills', 'Know About Me', '<p>Hello! I\'m Aleksandar Gacik, a dedicated personal trainer specializing in nutrition and strength plans. I offer comprehensive training that combines fitness, nutrition, and martial arts. My mission is to help you achieve your health and fitness goals through customized programs and expert guidance.</p>', 'about-me', 'gacik-aleksandar-square.jpg', '2024-06-08 18:51:38', 'en'),
(3, 'Personalni trener sa specijalizovanim veštinama ', 'Saznajte više', '<p>Zdravo! Ja sam Aleksandar Gacik, posvećeni personalni trener specijalizovan za planove ishrane i treninga snage. Nudim sveobuhvatne treninge koji kombinuju fitnes, ishranu i borilačke ve&scaron;tine. Moja misija je da vam pomognem da postignete svoje zdravstvene i fitnes ciljeve kroz prilagođene programe i struče savete.</p>', 'o-meni', 'gacik-aleksandar-square.jpg', '2024-06-08 18:51:38', 'sr');

-- --------------------------------------------------------

--
-- Table structure for table `blog_posts`
--

DROP TABLE IF EXISTS `blog_posts`;
CREATE TABLE IF NOT EXISTS `blog_posts` (
  `id` int NOT NULL AUTO_INCREMENT,
  `article_group_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `content` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `category_id` int NOT NULL,
  `featured_image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `language` enum('en','sr') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `slug` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `published_date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`(191)),
  KEY `article_group_id` (`article_group_id`(191))
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `blog_posts`
--

INSERT INTO `blog_posts` (`id`, `article_group_id`, `title`, `content`, `category_id`, `featured_image`, `language`, `slug`, `published_date`, `created_at`, `updated_at`) VALUES
(1, '666c84abc5b20', 'Novi clanak na srpskom', '<ol>\r\n<li>dasasdasdasd asdasdasasdasdasd asdasdasasdasdasd asdasdasasdasdasd</li>\r\n<li>asdasdasasdasdasd asdasdasasdasdasd asdasdasasdasdasd asdasdasasdasdasd asdasdasasdasdasd asdasdasasdasdasd asdasdasasdasdasd asdasdasasdasdasd asdasdasasdasdasd asdasdasasdasdasd asdasdasasdasdasd asdasdasasdasdasd asdasdasasdasdasd asdasdasasdasdasd</li>\r\n<li>asdasdasasdasdasd asdasdasasdasdasd asdasdasasdasdasd asdasdasasdasdasd asdasdasasdasdasd asdasdasasdasdasd asdasdasasdasdasd asdasdasasdasdasd asdasdasasdasdasd asdasdasasdasdasd asdasdasasdasdasd asdasdasasdasdasd asdasdasasdasdasd asdasdasasdasdasd</li>\r\n<li>asdasdasasdasdasd asdas</li>\r\n</ol>', 12, 'uploads/diet-1.jpg', 'sr', 'novi-clanak-na-srpskom', '2024-06-14', '2024-06-14 17:58:03', '2024-06-15 15:30:05'),
(2, '666c84abc5b20', 'New post in english', '<p><img class=\"img-fluid\" style=\"float: right;\" src=\"data:image/jpeg;base64,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\" alt=\"\" width=\"225\" height=\"225\" /></p>\r\n<h2>Subheading 1&nbsp;</h2>\r\n<p>dasasdasdasd asdasdasasdasdasd asdasdasasdasdasd <span style=\"color: #e03e2d;\">asdasdasasdasdasd </span>asdasdasasdasdasd asdasdasasdasdasd asdasdasasdasdasd asdasdasasdasdasd asdasdasasdasdasd asdasdasasdasdasd asdasdasasdasdasd asdas</p>\r\n<ol>\r\n<li>as das dasd asd</li>\r\n<li>as dasd asdas asd as asd&nbsp;</li>\r\n<li>asd asd asdasd asd</li>\r\n</ol>\r\n<table style=\"border-collapse: collapse; width: 100%;\" border=\"1\">\r\n<tbody>\r\n<tr>\r\n<td style=\"width: 49.0396%;\">asda sd</td>\r\n<td style=\"width: 49.0396%;\">asd asd</td>\r\n</tr>\r\n<tr>\r\n<td style=\"width: 49.0396%;\">asdasd</td>\r\n<td style=\"width: 49.0396%;\">asd asd&nbsp;</td>\r\n</tr>\r\n</tbody>\r\n</table>', 13, 'uploads/diet-1.jpg', 'en', 'new-post-in-english', '2024-06-14', '2024-06-14 17:58:03', '2024-06-15 10:19:43'),
(3, '666c8e8fc85a1', 'Jos jedan clanak na srpskom', 'asd asdasd asd asd asda sasd asdasd asd asd asda sasd asdasd asd asd asda sasd asdasd asd asd asda sasd asdasd asd asd asda sasd asdasd asd asd asda sasd asdasd asd asd asda sasd asdasd asd asd asda sasd asdasd asd asd asda sasd asdasd asd asd asda sasd asdasd asd asd asda sasd asdasd asd asd asda sasd asdasd asd asd asda sasd asdasd asd asd asda sasd asdasd asd asd asda sasd asdasd asd asd asda sasd asdasd asd asd asda sasd asdasd asd asd asda sasd asdasd asd asd asda sasd asdasd asd asd asda sasd asdasd asd asd asda sasd asdasd asd asd asda sasd asdasd asd asd asda sasd asdasd asd asd asda s', 8, 'uploads/diet-2.jpg', 'sr', 'jos-jedan-clanak-na-srpskom', '2024-06-14', '2024-06-14 18:40:15', '2024-06-14 21:37:44'),
(4, '666c8e8fc85a1', 'Another article on english', 'asd asdasd asd asd asda sasd asdasd asd asd asda sasd asdasd asd asd asda sasd asdasd asd asd asda sasd asdasd asd asd asda sasd asdasd asd asd asda s', 9, 'uploads/diet-2.jpg', 'en', 'another-article-on-english', '2024-06-14', '2024-06-14 18:40:15', '2024-06-14 21:37:44');

-- --------------------------------------------------------

--
-- Table structure for table `blog_section`
--

DROP TABLE IF EXISTS `blog_section`;
CREATE TABLE IF NOT EXISTS `blog_section` (
  `id` int NOT NULL AUTO_INCREMENT,
  `section_title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `section_subtitle` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `section_title_en` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `section_subtitle_en` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `blog_section`
--

INSERT INTO `blog_section` (`id`, `section_title`, `section_subtitle`, `section_title_en`, `section_subtitle_en`) VALUES
(1, 'Ovo niste znali o treninzima i ishrani', 'Najnoviji Älanci', 'SEE WHAT\'S HAPPENNING AROUND', 'LATEST BLOG POSTS');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
CREATE TABLE IF NOT EXISTS `categories` (
  `id` int NOT NULL AUTO_INCREMENT,
  `category_group_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `featured_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `language` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'en',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `category_group_id`, `name`, `featured_image`, `language`) VALUES
(13, '666c37775b621', 'Diet', 'uploads/diet-1.jpg', 'en'),
(12, '666c37775b621', 'Ishrana', 'uploads/diet-1.jpg', 'sr'),
(9, '666c35e4a2116', 'Running', 'uploads/bulletproof_runners-knee-1920x1080.jpg', 'en'),
(8, '666c35e4a2116', 'TrÄanje', 'uploads/bulletproof_runners-knee-1920x1080.jpg', 'sr');

-- --------------------------------------------------------

--
-- Table structure for table `footer_items`
--

DROP TABLE IF EXISTS `footer_items`;
CREATE TABLE IF NOT EXISTS `footer_items` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title_sr` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title_en` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `link_sr` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `link_en` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `menu` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `order` int NOT NULL,
  `is_custom` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `footer_items`
--

INSERT INTO `footer_items` (`id`, `title_sr`, `title_en`, `link_sr`, `link_en`, `menu`, `order`, `is_custom`) VALUES
(1, 'Program 1', 'Program 1', 'novi-clanak-na-srpskom', 'new-post-in-english', 'information', 1, 0),
(2, 'Plan ishrane', 'Nutrition plan', 'strana-na-srpskom', 'english-page', 'services', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `menu_items`
--

DROP TABLE IF EXISTS `menu_items`;
CREATE TABLE IF NOT EXISTS `menu_items` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title_sr` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `title_en` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `link_sr` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `link_en` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `order` int NOT NULL DEFAULT '0',
  `is_custom` tinyint(1) NOT NULL DEFAULT '0',
  `parent_id` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `menu_items`
--

INSERT INTO `menu_items` (`id`, `title_sr`, `title_en`, `link_sr`, `link_en`, `order`, `is_custom`, `parent_id`) VALUES
(1, 'Početna', 'Home', 'index.php', 'index.php', 1, 1, NULL),
(2, 'Kontakt', 'Contact', 'contact.php', 'contact.php', 5, 1, NULL),
(3, 'Blog', 'Blog', 'blog.php', 'blog.php', 4, 1, NULL),
(4, 'O meni', 'About me', 'o-meni', 'about-me', 2, 0, NULL),
(5, 'Programi', 'Programs', 'strana-na-srpskom', 'english-page', 3, 0, NULL),
(6, 'Program 1', 'Program 1', 'strana-na-srpskom', 'english-page', 1, 0, 5);

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

DROP TABLE IF EXISTS `pages`;
CREATE TABLE IF NOT EXISTS `pages` (
  `id` int NOT NULL AUTO_INCREMENT,
  `page_group_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `content` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `slug` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `language` enum('en','sr') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug_language` (`slug`,`language`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pages`
--

INSERT INTO `pages` (`id`, `page_group_id`, `title`, `content`, `slug`, `language`, `created_at`, `updated_at`) VALUES
(1, '6670a96a53639', 'strana na srpskom', '<p>asd asdas dasdasdas dasd</p>', 'strana-na-srpskom', 'sr', '2024-06-17 21:23:54', '2024-06-18 11:11:23'),
(2, '6670a96a53639', 'English page', '<p>sd asdasd adasdasdasdassd asdasd adasdasdasdassd asdasd adasdasdasdassd asdasd adasdasdasdassd asdasd adasdasdasdassd asdasd adasdasdasdassd asdasd adasdasdasdas</p>', 'english-page', 'en', '2024-06-17 21:23:54', '2024-06-18 11:11:23'),
(5, '6673f31373020', 'O meni', '<p>Zdravo, ja sam Aleksandar Gacik, sertifikovani lični trener sa preko 10 godina iskustva. Posedujem sertifikate Konzulat Fitnessa i specijalizovan sam za personalni trening i savetovanje o ishrani. Moja misija je da vam pomognem da postignete svoje fitnes ciljeve kroz prilagožene planove vežbanja i smernice za ishranu. Fitnes je oduvek bio moja strast i volim da pomažem drugima da otkriju prednosti zdravog načina života.</p>\r\n<h4>Lična priča</h4>\r\n<p>Započeo sam svoje fitnes putovanje pre 15 godina, boreći se sa sopstvenim problemima sa težinom. Kroz posvećenost i pravo vođstvo, transformisao sam svoje telo i um. Sada sam tu da vam pomognem da uradite isto.</p>\r\n<h4>Filozofija</h4>\r\n<p>Verujem u holistički pristup fitnesu, fokusirajući se ne samo na vežbanje već i na ishranu, mentalno zdravlje i op&scaron;te blagostanje. Moja filozofija treninga se vrti oko doslednosti, motivacije i pozitivnog načina razmi&scaron;ljanja.</p>', 'o-meni', 'sr', '2024-06-20 09:14:59', '2024-06-22 20:33:22'),
(6, '6673f31373020', 'About me', '<p>Hi, I\'m Aleksandar Gacik, a certified personal trainer with over 10 years of experience. I hold certifications from Konzulat Fitness, and I specialize in personal training and nutrition counseling. My mission is to help you achieve your fitness goals through customized workout plans and nutritional guidance. Fitness has always been my passion, and I love helping others discover the benefits of a healthy lifestyle.</p>\r\n<h4>Personal story</h4>\r\n<p>I started my fitness journey 15 years ago, struggling with my own weight issues. Through dedication and the right guidance, I transformed my body and mind. Now, I&rsquo;m here to help you do the same.</p>\r\n<h4>Philosophy&nbsp;</h4>\r\n<p>I believe in a holistic approach to fitness, focusing not just on exercise but also on nutrition, mental health, and overall well-being. My training philosophy revolves around consistency, motivation, and a positive mindset.</p>', 'about-me', 'en', '2024-06-20 09:14:59', '2024-06-22 20:33:22');

-- --------------------------------------------------------

--
-- Table structure for table `pricing`
--

DROP TABLE IF EXISTS `pricing`;
CREATE TABLE IF NOT EXISTS `pricing` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` int NOT NULL,
  `currency_symbol` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `frequency` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `features` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_featured` tinyint(1) NOT NULL,
  `link` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `language` varchar(2) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'sr',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pricing`
--

INSERT INTO `pricing` (`id`, `title`, `price`, `currency_symbol`, `frequency`, `features`, `is_featured`, `link`, `language`) VALUES
(1, 'BASIC PLAN', 120, '€', 'Monthly', 'Free Custom,\r\n Outstanding,\r\n Happy Customers', 0, '#', 'en'),
(2, 'STANDARD PLAN', 150, '€', 'Monthly', 'Free Custom,\r\n Outstanding,\r\n Happy Customers', 1, '#', 'en'),
(3, 'Ultimate plan', 210, '€', 'Monthly', 'Free Custom,\r\nOutstanding,\r\nHappy Customers', 0, '#', 'en'),
(4, 'Osnovni plan', 120, 'â‚¬', 'MeseÄno', ' Free Custom,\r\n Outstanding,\r\n Happy Customers', 0, '#', 'sr'),
(5, 'Standardni plan', 150, 'â‚¬', 'meseÄno', ' Free Custom,\r\n Outstanding,\r\n Happy Customers', 1, '#', 'sr'),
(6, 'Ultimativni plan', 210, 'â‚¬', 'meseÄno', ' Free Custom,\r\n Outstanding,\r\n Happy Customers', 0, '#', 'sr');

-- --------------------------------------------------------

--
-- Table structure for table `pricing_section`
--

DROP TABLE IF EXISTS `pricing_section`;
CREATE TABLE IF NOT EXISTS `pricing_section` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `subtitle` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `language` varchar(2) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'sr',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pricing_section`
--

INSERT INTO `pricing_section` (`id`, `title`, `subtitle`, `content`, `language`) VALUES
(1, 'FIND THE PERFECT PLAN', 'PRICING TABLE', 'Discover our diverse range of weight loss and strength training programs designed to help you achieve your fitness goals. Each program is tailored to meet your specific needs, offering comprehensive workout plans, nutritional guidance, and personalized support. With flexible pricing plans, you can choose the perfect option that fits your lifestyle and budget.', 'en'),
(2, 'Odaberite najbolji plan', 'Raznovrsna ponuda programa', 'Otkrijte naÅ¡u raznovrsnu ponudu programa za mrÅ¡avljenje i trening snage, dizajniranih da vam pomognu da postignete svoje fitness ciljeve. Svaki program je prilagoÄ‘en vaÅ¡im specifiÄnim potrebama, nudeÄ‡i sveobuhvatne planove veÅ¾banja, nutricionistiÄke smernice i personalizovanu podrÅ¡ku. Sa fleksibilnim planovima plaÄ‡anja, moÅ¾ete odabrati savrÅ¡enu opciju koja odgovara vaÅ¡em naÄinu Å¾ivota i budÅ¾etu.', 'sr');

-- --------------------------------------------------------

--
-- Table structure for table `programs`
--

DROP TABLE IF EXISTS `programs`;
CREATE TABLE IF NOT EXISTS `programs` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `subtitle` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `icon` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `link` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `language` varchar(2) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'sr',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `programs`
--

INSERT INTO `programs` (`id`, `title`, `subtitle`, `icon`, `link`, `content`, `language`) VALUES
(1, 'CARDIO PROGRAM', 'FRIENDLY ATMOSPHERE', 'heart-rate', '#', 'Make the muscles of your body larger and fit stronger through tension and exercises such as lifting weights.', 'en'),
(2, 'PURE STRENGTH', 'FRIENDLY ATMOSPHERE', 'running-man', '#', 'Make the muscles of your body larger and fit stronger through tension and exercises such as lifting weights.', 'en'),
(3, 'POWER YOGA', 'FRIENDLY ATMOSPHERE', 'wellness', '#', 'Make the muscles of your body larger and fit stronger through tension and exercises such as lifting weights.', 'en'),
(6, 'Kardio program', 'Prijateljsko okruÅ¾enje', 'heart-rate', '#', 'PovecÌajte miÅ¡icÌe vaÅ¡eg tela i ojaÄajte ih kroz napetost i veÅ¾be kao Å¡to je podizanje tegova.', 'sr'),
(7, 'ÄŒista snaga', 'poveÄ‡ajte miÅ¡Ä‡nu masu', 'muscle', '#', 'PovecÌajte miÅ¡icÌe vaÅ¡eg tela i ojaÄajte ih kroz napetost i veÅ¾be kao Å¡to je podizanje tegova.', 'sr'),
(8, 'Samoodbrana za Å¾ene', 'Izvucite maksimum iz svog tela', 'woman', '#', 'PovecÌajte miÅ¡icÌe vaÅ¡eg tela i ojaÄajte ih kroz napetost i veÅ¾be kao Å¡to je podizanje tegova.', 'sr');

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

DROP TABLE IF EXISTS `services`;
CREATE TABLE IF NOT EXISTS `services` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `icon` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `link` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `language` varchar(2) COLLATE utf8mb4_unicode_ci DEFAULT 'sr',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`id`, `title`, `icon`, `description`, `image`, `created_at`, `link`, `language`) VALUES
(5, 'Diet service', 'diet-1', 'as dasd aasdas asd', 'uploads/diet-1.jpg', '2024-05-27 11:12:00', '#', 'en'),
(2, 'Self Defense', 'no-smoking', 'Donâ€™t practice until you get it right practice until canâ€™t wrong', 'uploads/blog-01.jpg', '2024-05-27 08:55:54', '#', 'en'),
(4, 'Strength Training', 'wellness', 'Improve your body strength with Join our trainings & get shape.', 'images/homepage-2/service/service-03.jpg', '2024-05-27 08:55:54', '#', 'en'),
(6, 'Skidanje kilograma', 'diet', 'as dasdasd asdasd asas dasdasd asdasd asas dasdasd asdasd asas dasdasd asdasd asas dasdasd asdasd asas dasdasd asdasd as', 'uploads/diet-1.jpg', '2024-06-10 11:49:23', '#', 'sr'),
(7, 'Samoodbrana', 'sports-and-competition-1', 'as dasdasd asdasd asas dasdasd asdasd asas dasdasd asdasd asas dasdasd asdasd asas dasdasd asdasd asas dasdasd asdasd asas dasdasd asdasd asas dasdasd asdasd as', 'uploads/strength-1.png', '2024-06-10 12:27:14', '#', 'sr'),
(8, 'Treninzi snage', 'weight-1', 'as asdad ad asdasd asdas dasd asdasd asdasd asdasd asdasasd as asd asasdas', 'uploads/strength-1.png', '2024-06-10 12:28:04', '#', 'sr');

-- --------------------------------------------------------

--
-- Table structure for table `services_section`
--

DROP TABLE IF EXISTS `services_section`;
CREATE TABLE IF NOT EXISTS `services_section` (
  `id` int NOT NULL AUTO_INCREMENT,
  `section_title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `section_subtitle` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `section_content` mediumtext COLLATE utf8mb4_unicode_ci,
  `language` varchar(2) COLLATE utf8mb4_unicode_ci DEFAULT 'sr',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `services_section`
--

INSERT INTO `services_section` (`id`, `section_title`, `section_subtitle`, `section_content`, `language`) VALUES
(1, 'OUR FEATURED CLASSES', 'OUR CLASSES', 'Discover our diverse range of weight loss and strength training programs designed to help you achieve your fitness goals. Each program is tailored to meet your specific needs, offering comprehensive workout plans, nutritional guidance, and personalized support. With flexible pricing plans, you can choose the perfect option that fits your lifestyle and budget.', 'en'),
(2, 'Izdvojeni programi', 'Programi', 'Otkrijte naÅ¡u raznovrsnu ponudu programa za mrÅ¡avljenje i trening snage, dizajniranih da vam pomognu da postignete svoje fitness ciljeve. Svaki program je prilagoÄ‘en vaÅ¡im specifiÄnim potrebama, nudeÄ‡i sveobuhvatne planove veÅ¾banja, nutricionistiÄke smernice i personalizovanu podrÅ¡ku. Sa fleksibilnim planovima plaÄ‡anja, moÅ¾ete odabrati savrÅ¡enu opciju koja odgovara vaÅ¡em naÄinu Å¾ivota i budÅ¾etu.', 'sr');

-- --------------------------------------------------------

--
-- Table structure for table `sliders`
--

DROP TABLE IF EXISTS `sliders`;
CREATE TABLE IF NOT EXISTS `sliders` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `subtitle` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `background_image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `link` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `language` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'en',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sliders`
--

INSERT INTO `sliders` (`id`, `title`, `subtitle`, `background_image`, `link`, `language`) VALUES
(1, 'The best fitness studio in town', 'The Runner\'s Life  							', 'slider-2.jpg', '#', 'en'),
(3, 'Best weight lose programs', 'individual trainings', 'slider-1.jpg', '#', 'en'),
(4, 'The best fitness studio in town', 'The runner\'s life', 'slider-3.jpg', '#', 'en'),
(5, 'Programi za pripremu sportista', 'individualne vežbe snage', 'slider-1.jpg', '#', 'sr'),
(6, 'Programi za skidanje kilograma', 'posebno izdvajamo', 'slider-3.jpg', '#', 'sr');

-- --------------------------------------------------------

--
-- Table structure for table `testimonials`
--

DROP TABLE IF EXISTS `testimonials`;
CREATE TABLE IF NOT EXISTS `testimonials` (
  `id` int NOT NULL AUTO_INCREMENT,
  `author_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `author_designation` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `testimonial_text` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `rating` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `language` varchar(5) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `testimonials`
--

INSERT INTO `testimonials` (`id`, `author_name`, `author_designation`, `testimonial_text`, `rating`, `created_at`, `language`) VALUES
(1, 'Marc', 'Expert', 'Fitness Gym isn\'t anything like a regular chain gym. The gym also has amazing equipment that you don\'t find in most gyms like Kettlebells, challengin battle ropes and sledges.', 4, '2024-05-25 20:12:43', 'en'),
(2, 'Jovana S.', 'Journalist', 'Fitness Gym isnï¿½t anything like a regular chain gym. The gym also has amazing equipment that you donï¿½t find in most gyms like Kettlebells, challeng battle ropes and sledges.', 4, '2024-05-25 20:12:43', 'en'),
(4, 'Milica', 'Model', 'Fitness Within is an amazing gym and community of trainers and clients that all want one thingâ€¦.to be the best version of themselves! Workouts, nutrition plans, everything is tailored to your body and current fitness journey! I came in with back and shoulder issues.', 5, '2024-05-26 10:46:07', 'en'),
(5, 'Marta', 'IT struÄnjak', 'Treniram veÄ‡ nekoliko meseci i prezadovoljna sam rezultatima. Ne samo Å¡to sam konaÄno uspela da skinem kilograme, veÄ‡ sam uz pomoÄ‡ treninga znatno popravila svoje najbolje vreme na polumaratonu! Sve preporuke za Aleksandra!', 5, '2024-06-10 16:02:03', 'sr'),
(6, 'Mirjana Kostić', 'HR menadžerka', 'Sa Aleksandrom sam shvatila važnost pravilne ishrane i njen uticaj na zdravlje! Skinula sam 12 kg za 3 meseca i prezadovoljna sam!', 5, '2024-06-10 16:27:22', 'sr'),
(7, 'Katarina', 'studentkinja', 'Sve preporuke za rad sa Aleksandrom! Njegova struÄnost i posveÄ‡enost su na najviÅ¡em nivou!', 5, '2024-06-10 16:28:56', 'sr');

-- --------------------------------------------------------

--
-- Table structure for table `testimonial_section`
--

DROP TABLE IF EXISTS `testimonial_section`;
CREATE TABLE IF NOT EXISTS `testimonial_section` (
  `id` int NOT NULL AUTO_INCREMENT,
  `section_title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `section_subtitle` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `language` varchar(5) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `testimonial_section`
--

INSERT INTO `testimonial_section` (`id`, `section_title`, `section_subtitle`, `language`) VALUES
(1, 'WHAT OUR CLIENTS SAY ABOUT US', 'OUR TESTIMONIALS', 'en'),
(2, 'Šta kažu naši vežbači', 'ocene iz prve ruke', 'sr');

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
