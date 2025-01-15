-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: sql311.byetcluster.com
-- Generation Time: Jan 15, 2025 at 08:19 AM
-- Server version: 10.6.19-MariaDB
-- PHP Version: 7.2.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `icei_37863787_prod`
--

-- --------------------------------------------------------

--
-- Table structure for table `analytics`
--

CREATE TABLE `analytics` (
  `id` int(11) NOT NULL,
  `page` varchar(100) NOT NULL,
  `visitor_ip` varchar(50) NOT NULL,
  `visit_time` timestamp NOT NULL DEFAULT current_timestamp(),
  `os` varchar(100) DEFAULT NULL,
  `device_type` varchar(50) DEFAULT NULL,
  `browser` varchar(100) DEFAULT NULL,
  `referrer` varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `analytics`
--

INSERT INTO `analytics` (`id`, `page`, `visitor_ip`, `visit_time`, `os`, `device_type`, `browser`, `referrer`) VALUES
(1, '/pages/admin_dashboard', '86.120.188.158', '2025-01-14 15:02:34', 'Linux', 'Desktop', 'Chrome', 'https://echonewsmagazine.iceiy.com/pages/profile'),
(2, '/pages/admin_dashboard?chart_type=device_pie', '86.120.188.158', '2025-01-14 15:02:34', 'Linux', 'Desktop', 'Chrome', 'https://echonewsmagazine.iceiy.com/pages/admin_dashboard'),
(3, '/pages/admin_dashboard?chart_type=browser_bar', '86.120.188.158', '2025-01-14 15:02:34', 'Linux', 'Desktop', 'Chrome', 'https://echonewsmagazine.iceiy.com/pages/admin_dashboard'),
(4, '/pages/admin_dashboard?chart_type=visit_line', '86.120.188.158', '2025-01-14 15:02:34', 'Linux', 'Desktop', 'Chrome', 'https://echonewsmagazine.iceiy.com/pages/admin_dashboard'),
(5, '/pages/category1', '86.120.188.158', '2025-01-14 15:02:36', 'Linux', 'Desktop', 'Chrome', 'https://echonewsmagazine.iceiy.com/pages/admin_dashboard'),
(6, '/pages/category1', '86.120.188.158', '2025-01-14 15:06:22', 'Linux', 'Desktop', 'Chrome', 'https://echonewsmagazine.iceiy.com/pages/admin_dashboard'),
(7, '/pages/profile', '86.120.188.158', '2025-01-14 15:06:24', 'Linux', 'Desktop', 'Chrome', 'https://echonewsmagazine.iceiy.com/pages/category1'),
(8, '/pages/admin_dashboard', '86.120.188.158', '2025-01-14 15:06:27', 'Linux', 'Desktop', 'Chrome', 'https://echonewsmagazine.iceiy.com/pages/profile'),
(9, '/pages/admin_dashboard?chart_type=device_pie', '86.120.188.158', '2025-01-14 15:06:27', 'Linux', 'Desktop', 'Chrome', 'https://echonewsmagazine.iceiy.com/pages/admin_dashboard'),
(10, '/pages/admin_dashboard?chart_type=browser_bar', '86.120.188.158', '2025-01-14 15:06:27', 'Linux', 'Desktop', 'Chrome', 'https://echonewsmagazine.iceiy.com/pages/admin_dashboard'),
(11, '/pages/admin_dashboard?chart_type=visit_line', '86.120.188.158', '2025-01-14 15:06:27', 'Linux', 'Desktop', 'Chrome', 'https://echonewsmagazine.iceiy.com/pages/admin_dashboard'),
(12, '/pages/admin_dashboard', '86.120.188.158', '2025-01-14 15:06:29', 'Linux', 'Desktop', 'Chrome', 'https://echonewsmagazine.iceiy.com/pages/profile'),
(13, '/pages/admin_dashboard?chart_type=browser_bar', '86.120.188.158', '2025-01-14 15:06:29', 'Linux', 'Desktop', 'Chrome', 'https://echonewsmagazine.iceiy.com/pages/admin_dashboard'),
(14, '/pages/admin_dashboard?chart_type=device_pie', '86.120.188.158', '2025-01-14 15:06:29', 'Linux', 'Desktop', 'Chrome', 'https://echonewsmagazine.iceiy.com/pages/admin_dashboard'),
(15, '/pages/admin_dashboard?chart_type=visit_line', '86.120.188.158', '2025-01-14 15:06:29', 'Linux', 'Desktop', 'Chrome', 'https://echonewsmagazine.iceiy.com/pages/admin_dashboard'),
(16, '/pages/admin_dashboard', '86.120.188.158', '2025-01-14 15:06:35', 'Linux', 'Desktop', 'Chrome', 'https://echonewsmagazine.iceiy.com/pages/profile'),
(17, '/pages/admin_dashboard?chart_type=device_pie', '86.120.188.158', '2025-01-14 15:06:35', 'Linux', 'Desktop', 'Chrome', 'https://echonewsmagazine.iceiy.com/pages/admin_dashboard'),
(18, '/pages/admin_dashboard?chart_type=visit_line', '86.120.188.158', '2025-01-14 15:06:36', 'Linux', 'Desktop', 'Chrome', 'https://echonewsmagazine.iceiy.com/pages/admin_dashboard'),
(19, '/pages/admin_dashboard?chart_type=browser_bar', '86.120.188.158', '2025-01-14 15:06:36', 'Linux', 'Desktop', 'Chrome', 'https://echonewsmagazine.iceiy.com/pages/admin_dashboard'),
(20, '/pages/admin_dashboard.php', '86.120.188.158', '2025-01-14 15:08:21', 'Linux', 'Desktop', 'Chrome', 'Direct'),
(21, '/pages/admin_dashboard.php', '86.120.188.158', '2025-01-14 15:08:31', 'Linux', 'Desktop', 'Chrome', 'Direct'),
(22, '/pages/admin_dashboard?chart_type=device_pie', '86.120.188.158', '2025-01-14 15:08:32', 'Linux', 'Desktop', 'Chrome', 'https://echonewsmagazine.iceiy.com/pages/admin_dashboard.php'),
(23, '/pages/admin_dashboard?chart_type=browser_bar', '86.120.188.158', '2025-01-14 15:08:32', 'Linux', 'Desktop', 'Chrome', 'https://echonewsmagazine.iceiy.com/pages/admin_dashboard.php'),
(24, '/pages/admin_dashboard?chart_type=visit_line', '86.120.188.158', '2025-01-14 15:08:32', 'Linux', 'Desktop', 'Chrome', 'https://echonewsmagazine.iceiy.com/pages/admin_dashboard.php'),
(25, '/pages/admin_dashboard', '86.120.188.158', '2025-01-14 15:31:40', 'Linux', 'Desktop', 'Firefox', 'https://echonewsmagazine.iceiy.com/pages/profile'),
(26, '/pages/admin_dashboard?i=1', '86.120.188.158', '2025-01-14 15:45:43', 'Linux', 'Desktop', 'Firefox', 'https://echonewsmagazine.iceiy.com/pages/admin_dashboard'),
(27, '/pages/admin_dashboard?chart_type=device_pie', '86.120.188.158', '2025-01-14 15:45:43', 'Linux', 'Desktop', 'Firefox', 'https://echonewsmagazine.iceiy.com/pages/admin_dashboard?i=1'),
(28, '/pages/admin_dashboard?chart_type=browser_bar', '86.120.188.158', '2025-01-14 15:45:44', 'Linux', 'Desktop', 'Firefox', 'https://echonewsmagazine.iceiy.com/pages/admin_dashboard?i=1'),
(29, '/pages/admin_dashboard?chart_type=visit_line', '86.120.188.158', '2025-01-14 15:45:44', 'Linux', 'Desktop', 'Firefox', 'https://echonewsmagazine.iceiy.com/pages/admin_dashboard?i=1'),
(30, '/pages/dashboard', '86.120.188.158', '2025-01-14 15:45:46', 'Linux', 'Desktop', 'Firefox', 'https://echonewsmagazine.iceiy.com/pages/admin_dashboard?i=1'),
(31, '/pages/contact', '86.120.188.158', '2025-01-14 15:45:48', 'Linux', 'Desktop', 'Firefox', 'https://echonewsmagazine.iceiy.com/pages/dashboard'),
(32, '/pages/profile', '86.120.188.158', '2025-01-14 15:50:13', 'Linux', 'Desktop', 'Firefox', 'https://echonewsmagazine.iceiy.com/pages/contact'),
(33, '/pages/admin_dashboard', '86.120.188.158', '2025-01-14 15:50:14', 'Linux', 'Desktop', 'Firefox', 'https://echonewsmagazine.iceiy.com/pages/profile'),
(34, '/pages/admin_dashboard?chart_type=device_pie', '86.120.188.158', '2025-01-14 15:50:15', 'Linux', 'Desktop', 'Firefox', 'https://echonewsmagazine.iceiy.com/pages/admin_dashboard'),
(35, '/pages/admin_dashboard?chart_type=browser_bar', '86.120.188.158', '2025-01-14 15:50:15', 'Linux', 'Desktop', 'Firefox', 'https://echonewsmagazine.iceiy.com/pages/admin_dashboard'),
(36, '/pages/admin_dashboard?chart_type=visit_line', '86.120.188.158', '2025-01-14 15:50:15', 'Linux', 'Desktop', 'Firefox', 'https://echonewsmagazine.iceiy.com/pages/admin_dashboard'),
(37, '/pages/dashboard?i=1', '86.120.188.158', '2025-01-14 15:51:20', 'Linux; Android', 'Mobile', 'Chrome', 'https://echonewsmagazine.iceiy.com/'),
(38, '/pages/contact', '86.120.188.158', '2025-01-14 15:51:21', 'Linux; Android', 'Mobile', 'Chrome', 'https://echonewsmagazine.iceiy.com/pages/dashboard?i=1'),
(39, '/pages/contact', '74.125.208.72', '2025-01-14 15:51:23', 'Linux; Android', 'Mobile', 'Chrome', 'Direct'),
(40, '/pages/newsletter', '86.120.188.158', '2025-01-14 15:51:23', 'Linux; Android', 'Mobile', 'Chrome', 'https://echonewsmagazine.iceiy.com/pages/contact'),
(41, '/pages/contact', '74.125.210.1', '2025-01-14 15:51:24', 'Linux; Android', 'Mobile', 'Chrome', 'Direct'),
(42, '/pages/contact', '74.125.210.10', '2025-01-14 15:51:24', 'Linux; Android', 'Mobile', 'Chrome', 'Direct'),
(43, '/pages/category3', '86.120.188.158', '2025-01-14 15:52:21', 'Linux', 'Desktop', 'Firefox', 'https://echonewsmagazine.iceiy.com/pages/admin_dashboard'),
(44, '/pages/newsletter', '86.120.188.158', '2025-01-14 16:00:11', 'Linux', 'Desktop', 'Firefox', 'https://echonewsmagazine.iceiy.com/pages/admin_dashboard'),
(45, '/pages/category3?i=1', '178.132.108.53', '2025-01-14 21:56:41', 'Windows', 'Desktop', 'Chrome', 'https://echonewsmagazine.iceiy.com/pages/category3'),
(46, '/pages/contact', '178.132.108.53', '2025-01-14 21:56:44', 'Windows', 'Desktop', 'Chrome', 'https://echonewsmagazine.iceiy.com/pages/category3?i=1'),
(47, '/pages/dashboard', '178.132.108.53', '2025-01-14 21:57:48', 'Windows', 'Desktop', 'Chrome', 'https://echonewsmagazine.iceiy.com/pages/login'),
(48, '/pages/profile', '178.132.108.53', '2025-01-14 21:57:51', 'Windows', 'Desktop', 'Chrome', 'https://echonewsmagazine.iceiy.com/pages/dashboard'),
(49, '/pages/admin_dashboard', '178.132.108.53', '2025-01-14 21:57:52', 'Windows', 'Desktop', 'Chrome', 'https://echonewsmagazine.iceiy.com/pages/profile'),
(50, '/pages/admin_dashboard?chart_type=device_pie', '178.132.108.53', '2025-01-14 21:57:52', 'Windows', 'Desktop', 'Chrome', 'https://echonewsmagazine.iceiy.com/pages/admin_dashboard'),
(51, '/pages/admin_dashboard?chart_type=browser_bar', '178.132.108.53', '2025-01-14 21:57:52', 'Windows', 'Desktop', 'Chrome', 'https://echonewsmagazine.iceiy.com/pages/admin_dashboard'),
(52, '/pages/admin_dashboard?chart_type=visit_line', '178.132.108.53', '2025-01-14 21:57:52', 'Windows', 'Desktop', 'Chrome', 'https://echonewsmagazine.iceiy.com/pages/admin_dashboard'),
(53, '/pages/newsletter', '178.132.108.53', '2025-01-14 21:58:58', 'Windows', 'Desktop', 'Chrome', 'https://echonewsmagazine.iceiy.com/pages/contact'),
(54, '/pages/about_us', '178.132.108.53', '2025-01-14 22:06:21', 'Windows', 'Desktop', 'Chrome', 'https://echonewsmagazine.iceiy.com/pages/newsletter'),
(55, '/pages/dashboard?i=1', '86.120.188.44', '2025-01-14 22:06:44', 'Linux; Android', 'Mobile', 'Chrome', 'https://echonewsmagazine.iceiy.com/'),
(56, '/pages/dashboard', '86.120.188.44', '2025-01-14 22:06:50', 'Linux; Android', 'Mobile', 'Chrome', 'https://echonewsmagazine.iceiy.com/pages/login'),
(57, '/pages/category2', '86.120.188.44', '2025-01-14 22:06:52', 'Linux; Android', 'Mobile', 'Chrome', 'https://echonewsmagazine.iceiy.com/pages/dashboard'),
(58, '/pages/category1', '86.120.188.44', '2025-01-14 22:06:53', 'Linux; Android', 'Mobile', 'Chrome', 'https://echonewsmagazine.iceiy.com/pages/category2'),
(59, '/pages/contact', '86.120.188.44', '2025-01-14 22:06:54', 'Linux; Android', 'Mobile', 'Chrome', 'https://echonewsmagazine.iceiy.com/pages/category1'),
(60, '/pages/favorites', '178.132.108.53', '2025-01-14 22:07:21', 'Windows', 'Desktop', 'Chrome', 'https://echonewsmagazine.iceiy.com/pages/profile'),
(61, '/pages/admin_dashboard', '91.214.65.158', '2025-01-14 22:10:25', 'Windows', 'Desktop', 'Chrome', 'Direct'),
(62, '/pages/admin_dashboard?chart_type=device_pie', '91.214.65.158', '2025-01-14 22:10:25', 'Windows', 'Desktop', 'Chrome', 'https://echonewsmagazine.iceiy.com/pages/admin_dashboard'),
(63, '/pages/admin_dashboard?chart_type=browser_bar', '91.214.65.158', '2025-01-14 22:10:25', 'Windows', 'Desktop', 'Chrome', 'https://echonewsmagazine.iceiy.com/pages/admin_dashboard'),
(64, '/pages/admin_dashboard?chart_type=visit_line', '91.214.65.158', '2025-01-14 22:10:25', 'Windows', 'Desktop', 'Chrome', 'https://echonewsmagazine.iceiy.com/pages/admin_dashboard'),
(65, '/pages/newsletter', '91.214.65.158', '2025-01-14 22:10:29', 'Windows', 'Desktop', 'Chrome', 'https://echonewsmagazine.iceiy.com/pages/admin_dashboard'),
(66, '/pages/contact', '91.214.65.158', '2025-01-14 22:10:30', 'Windows', 'Desktop', 'Chrome', 'https://echonewsmagazine.iceiy.com/pages/newsletter'),
(67, '/pages/category1', '91.214.65.158', '2025-01-14 22:10:32', 'Windows', 'Desktop', 'Chrome', 'https://echonewsmagazine.iceiy.com/pages/contact'),
(68, '/pages/dashboard', '91.214.65.158', '2025-01-14 22:10:33', 'Windows', 'Desktop', 'Chrome', 'https://echonewsmagazine.iceiy.com/pages/category1'),
(69, '/pages/category3', '91.214.65.158', '2025-01-14 22:10:35', 'Windows', 'Desktop', 'Chrome', 'https://echonewsmagazine.iceiy.com/pages/dashboard'),
(70, '/pages/profile', '91.214.65.158', '2025-01-14 22:10:42', 'Windows', 'Desktop', 'Chrome', 'https://echonewsmagazine.iceiy.com/pages/contact'),
(71, '/pages/admin_dashboard', '178.132.109.143', '2025-01-14 22:18:52', 'Windows', 'Desktop', 'Chrome', 'https://echonewsmagazine.iceiy.com/pages/profile'),
(72, '/pages/admin_dashboard?chart_type=device_pie', '178.132.109.143', '2025-01-14 22:18:52', 'Windows', 'Desktop', 'Chrome', 'https://echonewsmagazine.iceiy.com/pages/admin_dashboard'),
(73, '/pages/admin_dashboard?chart_type=browser_bar', '178.132.109.143', '2025-01-14 22:18:52', 'Windows', 'Desktop', 'Chrome', 'https://echonewsmagazine.iceiy.com/pages/admin_dashboard'),
(74, '/pages/admin_dashboard?chart_type=visit_line', '178.132.109.143', '2025-01-14 22:18:52', 'Windows', 'Desktop', 'Chrome', 'https://echonewsmagazine.iceiy.com/pages/admin_dashboard'),
(75, '/pages/contact', '178.132.109.143', '2025-01-14 22:18:55', 'Windows', 'Desktop', 'Chrome', 'https://echonewsmagazine.iceiy.com/pages/admin_dashboard'),
(76, '/pages/category2', '178.132.109.143', '2025-01-14 22:18:57', 'Windows', 'Desktop', 'Chrome', 'https://echonewsmagazine.iceiy.com/pages/contact'),
(77, '/pages/profile', '178.132.109.143', '2025-01-14 22:18:59', 'Windows', 'Desktop', 'Chrome', 'https://echonewsmagazine.iceiy.com/pages/category2'),
(78, '/pages/category3', '178.132.109.143', '2025-01-14 22:21:05', 'Windows', 'Desktop', 'Chrome', 'https://echonewsmagazine.iceiy.com/pages/admin_dashboard'),
(79, '/pages/dashboard', '178.132.109.143', '2025-01-14 22:27:14', 'Windows', 'Desktop', 'Chrome', 'https://echonewsmagazine.iceiy.com/pages/login'),
(80, '/pages/category1', '178.132.109.143', '2025-01-15 08:30:02', 'Windows', 'Desktop', 'Chrome', 'https://echonewsmagazine.iceiy.com/pages/admin_dashboard'),
(81, '/pages/newsletter', '178.132.109.143', '2025-01-15 08:30:40', 'Windows', 'Desktop', 'Chrome', 'https://echonewsmagazine.iceiy.com/pages/dashboard'),
(82, '/pages/dashboard', '193.42.96.128', '2025-01-15 08:32:12', 'Windows', 'Desktop', 'Chrome', 'https://echonewsmagazine.iceiy.com/pages/login'),
(83, '/pages/profile', '193.42.96.128', '2025-01-15 08:32:14', 'Windows', 'Desktop', 'Chrome', 'https://echonewsmagazine.iceiy.com/pages/dashboard'),
(84, '/pages/admin_dashboard', '193.42.96.128', '2025-01-15 08:32:15', 'Windows', 'Desktop', 'Chrome', 'https://echonewsmagazine.iceiy.com/pages/profile'),
(85, '/pages/admin_dashboard?chart_type=device_pie', '193.42.96.128', '2025-01-15 08:32:15', 'Windows', 'Desktop', 'Chrome', 'https://echonewsmagazine.iceiy.com/pages/admin_dashboard'),
(86, '/pages/admin_dashboard?chart_type=visit_line', '193.42.96.128', '2025-01-15 08:32:15', 'Windows', 'Desktop', 'Chrome', 'https://echonewsmagazine.iceiy.com/pages/admin_dashboard'),
(87, '/pages/admin_dashboard?chart_type=browser_bar', '193.42.96.128', '2025-01-15 08:32:15', 'Windows', 'Desktop', 'Chrome', 'https://echonewsmagazine.iceiy.com/pages/admin_dashboard'),
(88, '/pages/newsletter', '193.42.96.128', '2025-01-15 08:34:14', 'Windows', 'Desktop', 'Chrome', 'https://echonewsmagazine.iceiy.com/pages/admin_dashboard'),
(89, '/pages/manage_users', '86.120.188.158', '2025-01-15 17:50:38', 'Linux', 'Desktop', 'Chrome', 'https://echonewsmagazine.iceiy.com/pages/profile'),
(90, '/pages/contact?i=1', '86.120.188.158', '2025-01-15 22:34:50', 'Linux', 'Desktop', 'Chrome', 'https://echonewsmagazine.iceiy.com/pages/contact'),
(91, '/pages/manage_users?search=CLF', '86.120.188.158', '2025-01-15 22:39:47', 'Linux', 'Desktop', 'Chrome', 'https://echonewsmagazine.iceiy.com/pages/manage_users'),
(92, '/pages/manage_users?search=', '86.120.188.158', '2025-01-15 22:40:15', 'Linux', 'Desktop', 'Chrome', 'https://echonewsmagazine.iceiy.com/pages/manage_users?search=CLF'),
(93, '/pages/manage_users.php', '86.120.188.158', '2025-01-15 22:40:38', 'Linux', 'Desktop', 'Chrome', 'https://echonewsmagazine.iceiy.com/pages/manage_users?search='),
(94, '/pages/favorites', '86.120.188.158', '2025-01-15 22:40:55', 'Linux', 'Desktop', 'Chrome', 'https://echonewsmagazine.iceiy.com/pages/profile'),
(95, '/pages/about_us', '86.120.188.158', '2025-01-15 22:41:18', 'Linux', 'Desktop', 'Chrome', 'https://echonewsmagazine.iceiy.com/pages/admin_dashboard'),
(96, '/pages/newsletter.php', '86.120.188.158', '2025-01-15 22:41:37', 'Linux', 'Desktop', 'Chrome', 'https://echonewsmagazine.iceiy.com/pages/about_us'),
(97, '/pages/category2', '86.120.188.158', '2025-01-15 23:15:45', 'Linux', 'Desktop', 'Chrome', 'https://echonewsmagazine.iceiy.com/pages/category1'),
(98, '/pages/manage_users?search=gmail', '86.120.188.158', '2025-01-15 23:15:59', 'Linux', 'Desktop', 'Chrome', 'https://echonewsmagazine.iceiy.com/pages/manage_users'),
(99, '/pages/manage_users?search=mr', '86.120.188.158', '2025-01-15 23:16:02', 'Linux', 'Desktop', 'Chrome', 'https://echonewsmagazine.iceiy.com/pages/manage_users?search=gmail'),
(100, '/pages/manage_users?search=cl', '86.120.188.158', '2025-01-15 23:16:06', 'Linux', 'Desktop', 'Chrome', 'https://echonewsmagazine.iceiy.com/pages/manage_users?search=mr'),
(101, '/pages/manage_users?search=t', '86.120.188.158', '2025-01-15 23:16:12', 'Linux', 'Desktop', 'Chrome', 'https://echonewsmagazine.iceiy.com/pages/manage_users?search=');

-- --------------------------------------------------------

--
-- Table structure for table `articles`
--

CREATE TABLE `articles` (
  `id` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `link` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `contact_messages`
--

CREATE TABLE `contact_messages` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `contact_messages`
--

INSERT INTO `contact_messages` (`id`, `name`, `email`, `message`, `created_at`) VALUES
(1, 'John Doe', 'CLFsmurf@yahoo.com', 'Hello, I have something to say, your site is amazing! :)', '2025-01-12 01:22:10'),
(2, 'Liliana', 'lilianagolea2009@gmail.com', 'bbfffg', '2025-01-12 17:45:18'),
(3, 'John', 'mricyveins@gmail.com', 'hello', '2025-01-12 21:58:41'),
(4, 'Icy', 'mricyveins@gmail.com', 'hello again', '2025-01-14 10:14:34');

-- --------------------------------------------------------

--
-- Table structure for table `favorites`
--

CREATE TABLE `favorites` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `article_id` varchar(255) NOT NULL,
  `title` text NOT NULL,
  `link` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `favorites`
--

INSERT INTO `favorites` (`id`, `user_id`, `article_id`, `title`, `link`, `created_at`) VALUES
(2, 2, 'd9f24828aeb1412279aa00061d98853f', 'LA firefighters battle to contain monster inferno as death toll rises', 'https://www.bbc.com/news/articles/c897l7wyzj5o', '2025-01-12 07:45:02'),
(5, 2, '2f8a3cdc2c6865dea7464448966ef338', '\'Everything is gone\' - Agony on a tight-knit LA street razed by inferno', 'https://www.bbc.com/news/articles/c2034p3g9z5o', '2025-01-12 08:07:25'),
(19, 3, '12cbfb67751eefa5f9d3527f387e681e', 'Online safety laws unsatisfactory, minister says', 'https://www.bbc.com/news/articles/cx2pk7589rno', '2025-01-12 23:07:27');

-- --------------------------------------------------------

--
-- Table structure for table `likes`
--

CREATE TABLE `likes` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `article_id` varchar(255) NOT NULL,
  `liked_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `likes`
--

INSERT INTO `likes` (`id`, `user_id`, `article_id`, `liked_at`) VALUES
(36, 3, '12cbfb67751eefa5f9d3527f387e681e', '2025-01-12 23:07:27'),
(40, 2, '12cbfb67751eefa5f9d3527f387e681e', '2025-01-12 23:22:19');

-- --------------------------------------------------------

--
-- Table structure for table `newsletter_subscribers`
--

CREATE TABLE `newsletter_subscribers` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `subscribed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `verified` tinyint(1) NOT NULL DEFAULT 0,
  `verification_token` varchar(255) DEFAULT NULL,
  `last_email_sent_at` timestamp NULL DEFAULT NULL,
  `is_admin` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `password_hash`, `created_at`, `verified`, `verification_token`, `last_email_sent_at`, `is_admin`) VALUES
(2, 'CLFsmurf@yahoo.com', '$2y$10$xXdWKukstHanhXO8UoTtaO1vFU7k4hgIjDJvk4MjydnaGASex3jEO', '2025-01-12 01:03:06', 0, '82882d75c40300e61880494e313d822a', NULL, 0),
(3, 'mricyveins@gmail.com', '$2y$10$r7J/UFvokFLs7P221qDSYOI5giUNp8cXmpHOtl32JQbMDlBnls4Je', '2025-01-12 02:05:01', 0, '5dc0ba715b833b97cadcb66e3139cab5', NULL, 1),
(6, 'andalice71@yahoo.com', '$2y$10$myWfT0R7RVMD2YbwTc6LhundU6DJtVUktfVonG8bv6wl1GKp84qPa', '2025-01-13 17:30:43', 1, NULL, NULL, 0),
(9, 'test@testsomething.com', '$2y$10$BvMlrAZNtcSUJWngXG1BpuL3e/91Nz1ID8ox6udz3SxVN20wDrvfC', '2025-01-14 01:29:47', 0, '4d339aa59706e1ad52a9e8f920b4917c', NULL, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `analytics`
--
ALTER TABLE `analytics`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `articles`
--
ALTER TABLE `articles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contact_messages`
--
ALTER TABLE `contact_messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `favorites`
--
ALTER TABLE `favorites`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `likes`
--
ALTER TABLE `likes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_id` (`user_id`,`article_id`);

--
-- Indexes for table `newsletter_subscribers`
--
ALTER TABLE `newsletter_subscribers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `analytics`
--
ALTER TABLE `analytics`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=102;

--
-- AUTO_INCREMENT for table `contact_messages`
--
ALTER TABLE `contact_messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `favorites`
--
ALTER TABLE `favorites`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `likes`
--
ALTER TABLE `likes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `newsletter_subscribers`
--
ALTER TABLE `newsletter_subscribers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
