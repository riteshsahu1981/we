-- phpMyAdmin SQL Dump
-- version 3.4.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Nov 21, 2011 at 01:41 PM
-- Server version: 5.0.77
-- PHP Version: 5.2.14

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `we`
--

-- --------------------------------------------------------

--
-- Table structure for table `album`
--

CREATE TABLE IF NOT EXISTS `album` (
  `id` int(11) NOT NULL auto_increment,
  `user_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `cover_image` varchar(255) default NULL,
  `description` text,
  `status` enum('publish','unpublish') NOT NULL default 'publish',
  `addedon` bigint(26) default NULL,
  `updatedon` bigint(24) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

--
-- Dumping data for table `album`
--

INSERT INTO `album` (`id`, `user_id`, `title`, `cover_image`, `description`, `status`, `addedon`, `updatedon`) VALUES
(5, 1, 'Rihikesh Trip - 2011', 'album_cover_5.jpg', '', 'publish', 1319443130, 1319443131),
(11, 1, 'India Gate', 'album_cover_11.jpg', '', 'publish', 1319444395, 1319465039);

-- --------------------------------------------------------

--
-- Table structure for table `appriciation`
--

CREATE TABLE IF NOT EXISTS `appriciation` (
  `id` int(14) NOT NULL auto_increment,
  `appriciation_date` date NOT NULL,
  `user_id` int(14) NOT NULL,
  `appriciation_type_id` int(14) NOT NULL,
  `remarks` text NOT NULL,
  `addedon` bigint(28) NOT NULL,
  `updatedon` bigint(28) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `appriciation`
--

INSERT INTO `appriciation` (`id`, `appriciation_date`, `user_id`, `appriciation_type_id`, `remarks`, `addedon`, `updatedon`) VALUES
(5, '2011-11-16', 5, 2, 'sds', 1321445754, NULL),
(2, '2011-10-06', 2, 2, 'xfdfsd', 1317986385, 1317987669),
(3, '2011-10-20', 8, 3, 'fsasd fasdf', 1317986407, NULL),
(4, '2011-09-06', 3, 1, 'well done', 1317992791, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `appriciation_type`
--

CREATE TABLE IF NOT EXISTS `appriciation_type` (
  `id` int(11) NOT NULL auto_increment,
  `title` varchar(255) NOT NULL,
  `addedon` bigint(24) NOT NULL,
  `updatedon` bigint(24) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `appriciation_type`
--

INSERT INTO `appriciation_type` (`id`, `title`, `addedon`, `updatedon`) VALUES
(1, 'Employee of the month', 1317985242, 1317985336),
(2, 'Employee of the quarter', 1317985361, NULL),
(3, 'Employee of the year', 1317985366, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `attendance`
--

CREATE TABLE IF NOT EXISTS `attendance` (
  `id` int(14) NOT NULL auto_increment,
  `emp_code` varchar(100) NOT NULL,
  `user_id` int(14) NOT NULL,
  `attendance` enum('0','1','0.5') NOT NULL default '1',
  `addedon` bigint(28) NOT NULL,
  `updatedon` bigint(28) NOT NULL,
  `attendance_date` date NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=151 ;

--
-- Dumping data for table `attendance`
--

INSERT INTO `attendance` (`id`, `emp_code`, `user_id`, `attendance`, `addedon`, `updatedon`, `attendance_date`) VALUES
(1, '123', 2, '0', 1317718960, 1317719029, '2011-09-01'),
(2, '123', 2, '1', 1317718960, 1317719029, '2011-09-02'),
(3, '123', 2, '1', 1317718960, 1317719029, '2011-09-03'),
(4, '123', 2, '0.5', 1317718960, 1317719029, '2011-09-04'),
(5, '123', 2, '1', 1317718960, 1317719029, '2011-09-05'),
(6, '123', 2, '1', 1317718960, 1317719029, '2011-09-06'),
(7, '123', 2, '1', 1317718960, 1317719029, '2011-09-07'),
(8, '123', 2, '1', 1317718960, 1317719029, '2011-09-08'),
(9, '123', 2, '1', 1317718960, 1317719029, '2011-09-09'),
(10, '123', 2, '1', 1317718960, 1317719029, '2011-09-10'),
(11, '123', 2, '1', 1317718960, 1317719029, '2011-09-11'),
(12, '123', 2, '1', 1317718960, 1317719029, '2011-09-12'),
(13, '123', 2, '1', 1317718960, 1317719029, '2011-09-13'),
(14, '123', 2, '1', 1317718960, 1317719029, '2011-09-14'),
(15, '123', 2, '1', 1317718960, 1317719029, '2011-09-15'),
(16, '123', 2, '1', 1317718960, 1317719029, '2011-09-16'),
(17, '123', 2, '1', 1317718960, 1317719029, '2011-09-17'),
(18, '123', 2, '1', 1317718960, 1317719029, '2011-09-18'),
(19, '123', 2, '1', 1317718960, 1317719029, '2011-09-19'),
(20, '123', 2, '1', 1317718960, 1317719029, '2011-09-20'),
(21, '123', 2, '1', 1317718960, 1317719029, '2011-09-21'),
(22, '123', 2, '1', 1317718960, 1317719029, '2011-09-22'),
(23, '123', 2, '1', 1317718960, 1317719029, '2011-09-23'),
(24, '123', 2, '1', 1317718960, 1317719029, '2011-09-24'),
(25, '123', 2, '1', 1317718960, 1317719029, '2011-09-25'),
(26, '123', 2, '1', 1317718960, 1317719029, '2011-09-26'),
(27, '123', 2, '1', 1317718960, 1317719029, '2011-09-27'),
(28, '123', 2, '1', 1317718960, 1317719029, '2011-09-28'),
(29, '123', 2, '1', 1317718960, 1317719029, '2011-09-29'),
(30, '123', 2, '1', 1317718960, 1317719029, '2011-09-30'),
(31, '23', 3, '1', 1317718960, 1317719029, '2011-09-01'),
(32, '23', 3, '1', 1317718960, 1317719029, '2011-09-02'),
(33, '23', 3, '0', 1317718960, 1317719029, '2011-09-03'),
(34, '23', 3, '1', 1317718960, 1317719029, '2011-09-04'),
(35, '23', 3, '1', 1317718960, 1317719029, '2011-09-05'),
(36, '23', 3, '1', 1317718960, 1317719029, '2011-09-06'),
(37, '23', 3, '1', 1317718960, 1317719029, '2011-09-07'),
(38, '23', 3, '1', 1317718960, 1317719029, '2011-09-08'),
(39, '23', 3, '1', 1317718960, 1317719029, '2011-09-09'),
(40, '23', 3, '1', 1317718960, 1317719029, '2011-09-10'),
(41, '23', 3, '1', 1317718960, 1317719029, '2011-09-11'),
(42, '23', 3, '1', 1317718960, 1317719029, '2011-09-12'),
(43, '23', 3, '1', 1317718960, 1317719029, '2011-09-13'),
(44, '23', 3, '1', 1317718960, 1317719029, '2011-09-14'),
(45, '23', 3, '1', 1317718960, 1317719029, '2011-09-15'),
(46, '23', 3, '1', 1317718960, 1317719029, '2011-09-16'),
(47, '23', 3, '1', 1317718960, 1317719029, '2011-09-17'),
(48, '23', 3, '1', 1317718960, 1317719029, '2011-09-18'),
(49, '23', 3, '1', 1317718960, 1317719029, '2011-09-19'),
(50, '23', 3, '1', 1317718960, 1317719029, '2011-09-20'),
(51, '23', 3, '1', 1317718960, 1317719029, '2011-09-21'),
(52, '23', 3, '1', 1317718960, 1317719029, '2011-09-22'),
(53, '23', 3, '1', 1317718960, 1317719029, '2011-09-23'),
(54, '23', 3, '1', 1317718960, 1317719029, '2011-09-24'),
(55, '23', 3, '1', 1317718960, 1317719029, '2011-09-25'),
(56, '23', 3, '1', 1317718960, 1317719029, '2011-09-26'),
(57, '23', 3, '1', 1317718960, 1317719029, '2011-09-27'),
(58, '23', 3, '1', 1317718960, 1317719029, '2011-09-28'),
(59, '23', 3, '1', 1317718960, 1317719029, '2011-09-29'),
(60, '23', 3, '1', 1317718960, 1317719029, '2011-09-30'),
(61, '123', 2, '0', 1317726355, 0, '2011-10-01'),
(62, '123', 2, '1', 1317726355, 0, '2011-10-02'),
(63, '123', 2, '1', 1317726355, 0, '2011-10-03'),
(64, '123', 2, '0', 1317726355, 0, '2011-10-04'),
(65, '123', 2, '1', 1317726355, 0, '2011-10-05'),
(66, '123', 2, '0.5', 1317726355, 0, '2011-10-06'),
(67, '123', 2, '1', 1317726355, 0, '2011-10-07'),
(68, '123', 2, '1', 1317726355, 0, '2011-10-08'),
(69, '123', 2, '1', 1317726355, 0, '2011-10-09'),
(70, '123', 2, '1', 1317726355, 0, '2011-10-10'),
(71, '123', 2, '1', 1317726355, 0, '2011-10-11'),
(72, '123', 2, '1', 1317726355, 0, '2011-10-12'),
(73, '123', 2, '1', 1317726355, 0, '2011-10-13'),
(74, '123', 2, '1', 1317726355, 0, '2011-10-14'),
(75, '123', 2, '1', 1317726355, 0, '2011-10-15'),
(76, '123', 2, '1', 1317726355, 0, '2011-10-16'),
(77, '123', 2, '1', 1317726355, 0, '2011-10-17'),
(78, '123', 2, '1', 1317726355, 0, '2011-10-18'),
(79, '123', 2, '1', 1317726355, 0, '2011-10-19'),
(80, '123', 2, '1', 1317726355, 0, '2011-10-20'),
(81, '123', 2, '1', 1317726355, 0, '2011-10-21'),
(82, '123', 2, '1', 1317726355, 0, '2011-10-22'),
(83, '123', 2, '1', 1317726355, 0, '2011-10-23'),
(84, '123', 2, '1', 1317726355, 0, '2011-10-24'),
(85, '123', 2, '1', 1317726355, 0, '2011-10-25'),
(86, '123', 2, '1', 1317726355, 0, '2011-10-26'),
(87, '123', 2, '1', 1317726355, 0, '2011-10-27'),
(88, '123', 2, '1', 1317726355, 0, '2011-10-28'),
(89, '123', 2, '1', 1317726355, 0, '2011-10-29'),
(90, '123', 2, '1', 1317726355, 0, '2011-10-30'),
(91, '23', 3, '1', 1317726355, 0, '2011-10-01'),
(92, '23', 3, '1', 1317726355, 0, '2011-10-02'),
(93, '23', 3, '0', 1317726355, 0, '2011-10-03'),
(94, '23', 3, '1', 1317726355, 0, '2011-10-04'),
(95, '23', 3, '1', 1317726355, 0, '2011-10-05'),
(96, '23', 3, '1', 1317726355, 0, '2011-10-06'),
(97, '23', 3, '1', 1317726355, 0, '2011-10-07'),
(98, '23', 3, '1', 1317726355, 0, '2011-10-08'),
(99, '23', 3, '1', 1317726355, 0, '2011-10-09'),
(100, '23', 3, '1', 1317726355, 0, '2011-10-10'),
(101, '23', 3, '1', 1317726355, 0, '2011-10-11'),
(102, '23', 3, '1', 1317726355, 0, '2011-10-12'),
(103, '23', 3, '1', 1317726355, 0, '2011-10-13'),
(104, '23', 3, '1', 1317726355, 0, '2011-10-14'),
(105, '23', 3, '1', 1317726355, 0, '2011-10-15'),
(106, '23', 3, '1', 1317726355, 0, '2011-10-16'),
(107, '23', 3, '1', 1317726355, 0, '2011-10-17'),
(108, '23', 3, '1', 1317726355, 0, '2011-10-18'),
(109, '23', 3, '1', 1317726355, 0, '2011-10-19'),
(110, '23', 3, '1', 1317726355, 0, '2011-10-20'),
(111, '23', 3, '1', 1317726355, 0, '2011-10-21'),
(112, '23', 3, '1', 1317726355, 0, '2011-10-22'),
(113, '23', 3, '1', 1317726355, 0, '2011-10-23'),
(114, '23', 3, '1', 1317726355, 0, '2011-10-24'),
(115, '23', 3, '1', 1317726355, 0, '2011-10-25'),
(116, '23', 3, '1', 1317726355, 0, '2011-10-26'),
(117, '23', 3, '1', 1317726356, 0, '2011-10-27'),
(118, '23', 3, '1', 1317726356, 0, '2011-10-28'),
(119, '23', 3, '1', 1317726356, 0, '2011-10-29'),
(120, '23', 3, '1', 1317726356, 0, '2011-10-30'),
(121, '123', 96, '0', 1321530235, 0, '2011-11-01'),
(122, '123', 96, '1', 1321530235, 0, '2011-11-02'),
(123, '123', 96, '1', 1321530235, 0, '2011-11-03'),
(124, '123', 96, '1', 1321530235, 0, '2011-11-04'),
(125, '123', 96, '1', 1321530235, 0, '2011-11-05'),
(126, '123', 96, '1', 1321530235, 0, '2011-11-06'),
(127, '123', 96, '1', 1321530235, 0, '2011-11-07'),
(128, '123', 96, '1', 1321530235, 0, '2011-11-08'),
(129, '123', 96, '1', 1321530235, 0, '2011-11-09'),
(130, '123', 96, '1', 1321530235, 0, '2011-11-10'),
(131, '123', 96, '1', 1321530235, 0, '2011-11-11'),
(132, '123', 96, '1', 1321530235, 0, '2011-11-12'),
(133, '123', 96, '1', 1321530235, 0, '2011-11-13'),
(134, '123', 96, '1', 1321530235, 0, '2011-11-14'),
(135, '123', 96, '1', 1321530235, 0, '2011-11-15'),
(136, '123', 96, '1', 1321530235, 0, '2011-11-16'),
(137, '123', 96, '1', 1321530235, 0, '2011-11-17'),
(138, '123', 96, '1', 1321530235, 0, '2011-11-18'),
(139, '123', 96, '1', 1321530235, 0, '2011-11-19'),
(140, '123', 96, '1', 1321530235, 0, '2011-11-20'),
(141, '123', 96, '1', 1321530235, 0, '2011-11-21'),
(142, '123', 96, '1', 1321530235, 0, '2011-11-22'),
(143, '123', 96, '1', 1321530235, 0, '2011-11-23'),
(144, '123', 96, '1', 1321530235, 0, '2011-11-24'),
(145, '123', 96, '1', 1321530235, 0, '2011-11-25'),
(146, '123', 96, '1', 1321530235, 0, '2011-11-26'),
(147, '123', 96, '1', 1321530235, 0, '2011-11-27'),
(148, '123', 96, '1', 1321530236, 0, '2011-11-28'),
(149, '123', 96, '1', 1321530236, 0, '2011-11-29'),
(150, '123', 96, '1', 1321530236, 0, '2011-11-30');

-- --------------------------------------------------------

--
-- Table structure for table `department`
--

CREATE TABLE IF NOT EXISTS `department` (
  `id` int(11) NOT NULL auto_increment,
  `title` varchar(255) NOT NULL,
  `type` enum('operations','normal') NOT NULL default 'normal',
  `department_head_id` int(14) NOT NULL,
  `addedon` bigint(24) NOT NULL,
  `updatedon` bigint(24) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=18 ;

--
-- Dumping data for table `department`
--

INSERT INTO `department` (`id`, `title`, `type`, `department_head_id`, `addedon`, `updatedon`) VALUES
(1, 'SEO', 'normal', 79, 1317803123, 1321604616),
(2, 'Link Building', 'normal', 61, 1317803128, 1321604664),
(3, 'JAVA', 'normal', 56, 1317803146, 1321604706),
(4, 'PHP', 'normal', 1, 1317803157, 1321604769),
(5, '.Net', 'normal', 28, 1317803174, 1321604806),
(6, 'Designing', 'normal', 113, 1317803178, 1321604844),
(7, 'Testing', 'normal', 110, 1317803255, 1321604876),
(8, 'Internet Marketing', 'normal', 98, 1317895862, 1321604908),
(9, 'Recruitment', 'normal', 87, 1318330414, 1321604966),
(13, 'Busines Development', 'normal', 25, 1321605382, NULL),
(12, 'Content Writer', 'normal', 112, 1321605364, NULL),
(10, 'PPC', 'normal', 96, 1318408179, 1321605000),
(11, 'Offpage', 'normal', 50, 1321510690, 1321605334),
(14, 'System Admin', 'operations', 103, 1321605411, 1321605647),
(15, 'HR', 'operations', 57, 1321605432, 1321605629),
(16, 'Development', 'normal', 39, 1321605567, NULL),
(17, 'Chief Officer', 'operations', 4, 1321605608, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `designation`
--

CREATE TABLE IF NOT EXISTS `designation` (
  `id` int(11) NOT NULL auto_increment,
  `title` varchar(255) NOT NULL,
  `addedon` bigint(24) NOT NULL,
  `updatedon` bigint(24) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=48 ;

--
-- Dumping data for table `designation`
--

INSERT INTO `designation` (`id`, `title`, `addedon`, `updatedon`) VALUES
(1, 'Chief Executive Officer', 1317133683, 1321541399),
(2, 'Chief Operating Officer', 1317133723, 1321541520),
(3, 'Chief Business officer', 1317133730, 1321603946),
(4, 'Trainee Software Engineer', 1317133737, 1321603969),
(5, 'Jr. Software Engineer', 1317133743, 1321603991),
(6, 'Software Engineer', 1317133749, 1321604014),
(7, 'Sr. Software Engineer', 1317133756, 1321604033),
(8, 'Associate Technical Lead', 1317133760, 1321604050),
(9, 'Technical Team Lead', 1317133764, 1321604071),
(10, 'Technical Manager', 1317133768, 1321604089),
(11, 'Delivery Head', 1317133774, 1321604103),
(12, 'Project Manager', 1317133794, 1321604123),
(13, 'Sr. Project Manager', 1317133804, 1321604139),
(14, 'Web Designer', 1317133810, 1321604157),
(15, 'Sr. Web Designer', 1318408213, 1321604173),
(16, 'Designing Team Lead', 1321604187, NULL),
(17, 'Head Of Design', 1321604200, NULL),
(18, 'Content Writer', 1321604226, NULL),
(19, 'Jr. SEO Executive', 1321604232, NULL),
(20, 'SEO Executive', 1321604254, NULL),
(21, 'Sr. SEO Professional', 1321604271, NULL),
(22, 'SEO Team Lead', 1321604276, NULL),
(23, 'SEO Project Manager', 1321604282, NULL),
(24, 'PPC Manager', 1321604294, NULL),
(25, 'Sr. SMO Specialist', 1321604318, NULL),
(26, 'Head Of Search', 1321604337, NULL),
(27, 'Jr. Link Builder', 1321604343, NULL),
(28, 'Link Builder', 1321604351, NULL),
(29, 'Sr. Link Builder', 1321604360, NULL),
(30, 'Sr. Link Buyer', 1321604369, NULL),
(31, 'Link Builder Team Lead', 1321604375, NULL),
(32, 'Jr. Offpage Specialist', 1321604388, NULL),
(33, 'Offpage Specialist', 1321604395, NULL),
(34, 'Sr. Offpage Specialist', 1321604402, NULL),
(35, 'Offpage Team Lead', 1321604409, NULL),
(36, 'Recruitments Head', 1321604425, NULL),
(37, 'Manager Recruitments', 1321604431, NULL),
(38, 'Account Manager', 1321604439, NULL),
(39, 'Sr. Technical Recruiter', 1321604448, NULL),
(40, 'Technical Recruiter', 1321604454, NULL),
(41, 'Internet Marketing Project Manager', 1321604460, NULL),
(42, 'Internet Marketing Team Lead', 1321604466, NULL),
(43, 'Internet Marketing Executive', 1321604472, NULL),
(44, 'Business Development Manager', 1321604478, NULL),
(45, 'System Admin Team Lead', 1321604484, NULL),
(46, 'System Admin', 1321604491, NULL),
(47, 'HR', 1321604497, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `email_template`
--

CREATE TABLE IF NOT EXISTS `email_template` (
  `id` int(14) NOT NULL auto_increment,
  `name` varchar(255) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `identifire` varchar(255) NOT NULL,
  `body` text NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=24 ;

--
-- Dumping data for table `email_template`
--

INSERT INTO `email_template` (`id`, `name`, `subject`, `identifire`, `body`) VALUES
(1, 'Registration Email', 'Welcome to Gap Daemon', 'registration_email', '<p>\r\n	Dear __FIRSTNAME__ ,</p>\r\n<p>\r\n	Thank you for joining Gap Daemon. Please click on the link below to activate your account:</p>\r\n<p>\r\n	__ACTIVATE_LINK__</p>\r\n<p>\r\n	Gap Daemon gives you:</p>\r\n<ul>\r\n	<li>\r\n		Expertly written articles to help plan your trip</li>\r\n	<li>\r\n		A growing community of travellers to link up with on the road</li>\r\n	<li>\r\n		Information storage, so you can re-live your trip when you get home</li>\r\n</ul>\r\n<p>\r\n	Your email is:&nbsp; __EMAIL__</p>\r\n<p>\r\n	Your username is:&nbsp; __USERNAME__</p>\r\n<p>\r\n	Your&nbsp; password is:&nbsp; __PASSWORD__</p>\r\n<p>\r\n	Welcome to your personal travel community!</p>\r\n<p>\r\n	The GD Team.</p>\r\n<p>\r\n	__SITE_URL__</p>\r\n<p>\r\n	&nbsp;</p>\r\n<p>\r\n	<wbr><wbr></wbr></wbr></p>\r\n'),
(8, 'Forgot Password Email', 'Gap Daemon: Forgotten Your Password?', 'forgot_password_email', '<p>\r\n	Dear __FIRSTNAME__,</p>\r\n<p>\r\n	&nbsp;</p>\r\n<p>\r\n	Your password for your Gap Daemon account has now been reset.</p>\r\n<p>\r\n	Your new password is __PASSWORD__</p>\r\n<p>\r\n	&nbsp;</p>\r\n<p>\r\n	From,</p>\r\n<p>\r\n	The Gap Daemon Team.</p>\r\n<p>\r\n	__SITE_URL__</p>\r\n<p>\r\n	&nbsp;</p>'),
(9, 'Contact Us', 'Gap Daemon User Feedback/Enquiry', 'contactus_email', '<p>Hi,</p>\r\n<p>One of our users has sent in the following :</p>\r\n<p>Name :&nbsp;__NAME__</p>\r\n<p>Email :&nbsp;__EMAIL__</p>\r\n<p>Enquiry :&nbsp;__ENQUIRY__</p>\r\n<p>&nbsp;</p>\r\n<p>&nbsp;</p>'),
(11, 'Forgot Username Email', 'Gap Daemon: Forgotten Your Username?', 'forgot_username_email', '<p>\r\n	Dear __FIRSTNAME__,</p>\r\n<p>\r\n	Your username is __USERNAME__</p>\r\n<p>\r\n	&nbsp;</p>\r\n<p>\r\n	From,</p>\r\n<p>\r\n	The Gap Daemon Team.</p>\r\n<p>\r\n	__SITE_URL__</p>\r\n<p>\r\n	&nbsp;</p>\r\n<p>\r\n	&nbsp;</p>'),
(17, 'Request Notification Template', 'You have got a request notification', 'request_notification_email', '<p>Hello,</p>\r\n<p>You have got the below request.</p>\r\n<p>Request : __REQUEST__</p>\r\n<br/>\r\n<p>Requested By : __REQUESTER_NAME__</p><p>Requester Email : __REQUESTER_EMAIL__</p>\r\n<p>Requester Emp. Code : __REQUESTER_EMP_CODE__</p>\r\n<br/>\r\n<p>From</p>\r\n<p>ONSIS Admin</p>'),
(23, 'Request Complete NotificationTemplate', 'Yous request has been resolved', 'request_complete_notification_email', '<p>Hello __REQUESTER_NAME__,</p>\r\n\r\n<p>Your request #__REQUEST_NO__ has been resolved.</p>\r\n<p>Remarks : __REMARKS__</p>\r\n	\r\n<p>From</p>\r\n<p>ONSIS Admin</p>');

-- --------------------------------------------------------

--
-- Table structure for table `global_settings`
--

CREATE TABLE IF NOT EXISTS `global_settings` (
  `id` int(14) NOT NULL auto_increment,
  `label` varchar(100) NOT NULL,
  `identifire` varchar(100) NOT NULL,
  `value` text NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=20 ;

--
-- Dumping data for table `global_settings`
--

INSERT INTO `global_settings` (`id`, `label`, `identifire`, `value`) VALUES
(1, 'ONSIS Support', 'support_email', 'ritesh@profitbyoutsourcing.com'),
(2, 'ONSIS Admin', 'admin_email', 'ritesh@profitbyoutsourcing.com'),
(3, 'Common Pagination Size', 'pagination_size', '20');

-- --------------------------------------------------------

--
-- Table structure for table `leave_type`
--

CREATE TABLE IF NOT EXISTS `leave_type` (
  `id` int(5) NOT NULL auto_increment,
  `code` varchar(100) NOT NULL,
  `title` varchar(100) NOT NULL,
  `total_leaves_in_year` int(5) NOT NULL,
  `addedon` bigint(24) NOT NULL,
  `updatedon` bigint(24) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `leave_type`
--

INSERT INTO `leave_type` (`id`, `code`, `title`, `total_leaves_in_year`, `addedon`, `updatedon`) VALUES
(1, 'ML', 'Maternity Leave', 36, 1317191318, 1317213374),
(2, 'EL', 'Earn Leave', 12, 1317191337, 1317213340),
(3, 'SL', 'Sick Leave', 12, 1317191422, 1317213329),
(4, 'CL', 'Casual Leave', 12, 1317191434, 1317213312),
(5, 'PL', 'Paternity Leave', 2, 1317213392, 0);

-- --------------------------------------------------------

--
-- Table structure for table `notice`
--

CREATE TABLE IF NOT EXISTS `notice` (
  `id` int(11) NOT NULL auto_increment,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `addedon` bigint(24) NOT NULL,
  `updatedon` bigint(24) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `notice`
--

INSERT INTO `notice` (`id`, `title`, `content`, `addedon`, `updatedon`) VALUES
(2, 'Test Notice Title', '<p>\r\n	this is test notice.as fdasdf asd fasdf asdfasdfasdfas dfadsfasdfsadfasdf asdfsad fasdfas fasdfasdfadsfasdfsadf asfdf asdf asdfsadfsda&nbsp; fadsfasd fsadf adsfsadf adsfsadfadsfas dfadsfadsfasdfadsf asdfadsfasdfdsfds fasdf asdfadsf adsfadsfsadfsdaas dfadsfads fasdf adsf sdafsadf sadf asdfsadf sdafsdaf</p>\r\n<ol>\r\n	<li>\r\n		sadfasdf asdfsad fsadf</li>\r\n	<li>\r\n		asdf asdf</li>\r\n	<li>\r\n		asd f</li>\r\n	<li>\r\n		asd fsadf</li>\r\n</ol>\r\n<p>\r\n	Thanks,</p>\r\n<p>\r\n	Admin</p>\r\n', 1317975600, 1317976865),
(3, 'Happy Diwali - 2011', '<center>\r\n	<p>\r\n		<br />\r\n		<embed height="375" quality="high" src="http://www.goodlightscraps.com/content/diwali-greetings2011/diwali-card-1.swf" type="application/x-shockwave-flash" width="448"></embed></p>\r\n</center>\r\n<p>\r\n	From,</p>\r\n<p>\r\n	ONSIS Team</p>\r\n', 1319543958, 1319544116);

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

CREATE TABLE IF NOT EXISTS `pages` (
  `id` int(14) NOT NULL auto_increment,
  `title` varchar(255) NOT NULL,
  `identifire` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `meta_title` varchar(255) default NULL,
  `meta_description` text,
  `meta_keyword` varchar(255) default NULL,
  `status` enum('1','0') NOT NULL default '0',
  `addedon` bigint(28) NOT NULL,
  `updatedon` bigint(28) NOT NULL,
  `user_id` int(14) NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `identifire` (`identifire`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=32 ;

--
-- Dumping data for table `pages`
--

INSERT INTO `pages` (`id`, `title`, `identifire`, `content`, `meta_title`, `meta_description`, `meta_keyword`, `status`, `addedon`, `updatedon`, `user_id`) VALUES
(30, 'Employee Benifits', 'employee-benifits', '<div class="content-box-content">\r\n	<div class="normal-txt">\r\n		<div id="lipsum">\r\n			<p>\r\n				Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur eu eros nisi. Donec dignissim lacus nec ante interdum quis aliquet dolor posuere. Nullam id eros erat, quis sollicitudin ante. Donec ut nibh nibh, at tempor lacus. Sed dictum, nisl non elementum laoreet, ligula eros facilisis nisl, sit amet consequat nisl purus id lectus. Aliquam non eros vitae enim ornare tempus eu vel elit. Sed vehicula tempus suscipit.</p>\r\n			<p>\r\n				Mauris vel urna eget urna vehicula facilisis. Quisque id magna eu urna tempor laoreet vel ut libero. Sed ut nisl non velit gravida egestas. Suspendisse ultrices nibh nec urna mattis a egestas mi suscipit. Ut nulla lectus, scelerisque in mollis in, posuere sed purus. Donec quis lectus iaculis sem eleifend congue. Curabitur at dolor sed mauris tristique iaculis ac ut nisl. Morbi vulputate augue vel lectus malesuada feugiat. Praesent lacus nisi, consectetur aliquam suscipit in, tempus in leo. Proin sed eros diam, vel mattis dolor. Cras a urna aliquet quam posuere euismod ac vitae metus. Morbi faucibus, dolor ut eleifend convallis, metus lectus luctus felis, nec porta orci velit vitae magna. Etiam mattis, elit quis ultricies pretium, mauris augue mattis enim, eu posuere enim dui quis nunc.</p>\r\n			<p>\r\n				Praesent massa augue, mollis at consequat vel, dignissim eu metus. Suspendisse eros elit, mattis nec accumsan nec, tempus eu felis. Maecenas eu nibh nec nisi fermentum dignissim. Donec et dui orci. Pellentesque ut diam tellus. Etiam fermentum, felis ac dapibus dignissim, eros nisi commodo diam, sit amet euismod eros nulla rhoncus metus. Nullam sed purus a risus rutrum viverra id interdum turpis.</p>\r\n			<p>\r\n				Phasellus consequat accumsan justo, in molestie neque luctus in. Nulla urna nisl, semper non pharetra non, convallis ut ante. Sed libero felis, sodales eget congue quis, facilisis id arcu. Vestibulum vel augue magna. Phasellus id euismod mi. Maecenas pulvinar posuere arcu, et pellentesque magna eleifend vitae. Pellentesque magna magna, egestas id auctor ut, sodales at nibh. In malesuada tempor eros, nec posuere justo aliquet scelerisque. Suspendisse at laoreet mi. Vestibulum porttitor consequat risus quis lacinia. Nulla id ultricies magna. Fusce congue aliquet justo, in fermentum tortor laoreet lobortis. Mauris posuere ornare mattis. Nam scelerisque tellus a nisi hendrerit vel adipiscing mi hendrerit. Duis ac leo arcu, nec tincidunt enim.</p>\r\n			<p>\r\n				Curabitur blandit, lectus aliquet porta tempor, lacus enim vulputate purus, non rhoncus ligula nulla at quam. Integer congue accumsan suscipit. Suspendisse quis velit metus. Nam velit urna, eleifend quis eleifend id, tristique quis urna. Vivamus pellentesque vulputate ante, eu fringilla nibh ornare vel. Integer ultricies iaculis neque, nec semper neque scelerisque ut. Duis lectus sapien, tempor vitae semper et, semper eget mauris.</p>\r\n			<p>\r\n				Mauris elementum, orci in facilisis porta, mi ligula placerat sem, nec ullamcorper velit mauris id eros. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Cras eget diam nisl, nec venenatis dolor. Integer laoreet sapien facilisis erat volutpat aliquet. Fusce feugiat eleifend mi. Phasellus et lectus feugiat urna semper interdum. Morbi a lobortis dolor. Etiam ultrices accumsan quam vitae venenatis. Pellentesque at magna libero. Donec ut purus non magna lacinia consequat vel eu urna. Proin dignissim lacinia mauris vel sollicitudin. Donec est velit, pellentesque vel imperdiet vel, pharetra quis eros. Duis tincidunt sem enim. Quisque sed consequat enim. Pellentesque ut purus ligula, sit amet tincidunt nibh.</p>\r\n			<p>\r\n				Mauris sagittis convallis faucibus. Etiam at faucibus lorem. Pellentesque eu enim nec dolor vestibulum commodo eu eu justo. Duis dictum aliquam purus, sit amet suscipit sapien congue a. Donec commodo sem a sapien vulputate auctor. Sed lectus nisi, dictum quis varius nec, viverra quis nisi. Fusce porta imperdiet urna, eu lacinia felis commodo nec. Proin ac metus ante.</p>\r\n			<p>\r\n				In ac mauris dui, et eleifend dolor. Vestibulum et purus augue, non venenatis erat. Sed eu risus nec ligula mattis ullamcorper et sed nunc. Quisque tristique lacus eros. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque vitae elementum lectus. Maecenas nec libero erat. Nulla et ornare dolor. Quisque faucibus, est et consectetur hendrerit, lacus sem lacinia elit, nec fringilla mi ante non tellus. Vestibulum laoreet faucibus leo vestibulum laoreet.</p>\r\n			<p>\r\n				Fusce eu nunc ante, a varius lacus. Vestibulum sed odio at metus pharetra feugiat eu quis tellus. Morbi gravida, eros sit amet lacinia viverra, tortor risus sagittis mi, eu molestie libero augue ac dolor. Vestibulum id condimentum augue. Pellentesque placerat condimentum libero non tincidunt. Praesent feugiat, tortor non placerat consequat, felis ligula euismod lacus, sed lobortis sapien nisl id justo. Sed ac mauris leo, at vestibulum quam. Maecenas arcu est, egestas eu auctor vel, euismod sit amet eros. Fusce sagittis tortor eu nisi hendrerit ut ullamcorper lectus aliquam. Praesent a placerat quam. Maecenas interdum posuere enim sit amet aliquet. Maecenas sit amet urna ac lectus pretium commodo at ut nunc. Aliquam congue ultrices placerat. Nunc quis posuere dolor. Aenean vitae lacus purus. Vestibulum molestie sem at dolor accumsan ultrices.</p>\r\n			<p>\r\n				Morbi in mauris ac tortor semper porttitor vitae et massa. Aliquam lacus ante, consectetur quis convallis non, sodales in elit. Nunc hendrerit interdum sapien, a malesuada lorem egestas sit amet. Suspendisse mauris est, rhoncus in placerat ut, ornare sit amet sapien. Donec lacus turpis, tincidunt non posuere ac, sollicitudin vel eros. In feugiat est in sem viverra aliquam. Praesent condimentum tristique neque vitae pellentesque. Maecenas sodales luctus justo vitae pulvinar. Praesent tellus mauris, cursus in accumsan sit amet, pellentesque quis sem. Vestibulum in orci eros, id adipiscing dui.</p>\r\n			<p>\r\n				Donec sit amet tempor felis. Pellentesque molestie felis ut velit rutrum sagittis in et nisi. Pellentesque diam metus, accumsan quis tristique at, bibendum sed nisi. Cras eleifend nisi eget ligula viverra a auctor odio placerat. Praesent euismod adipiscing rhoncus. Sed malesuada condimentum dolor vitae luctus. Pellentesque dui nibh, viverra non ornare ac, rhoncus vel nibh. Integer iaculis bibendum lacus nec pharetra. Proin non magna vitae nisl convallis vestibulum. Proin ut nibh felis. Pellentesque quis magna leo, eget ultricies lectus. Vivamus congue justo dui, eu cursus dolor. Suspendisse ornare nulla ut massa ornare et varius dolor viverra. Donec massa lorem, dapibus nec accumsan quis, molestie in lorem.</p>\r\n			<p>\r\n				Praesent congue, nibh vitae porttitor molestie, sapien ipsum sollicitudin nunc, eu varius lorem risus id risus. Nunc quis malesuada mi. Nam neque lectus, malesuada ac feugiat non, adipiscing eu diam. Mauris et molestie enim. Nam laoreet nunc ut lorem commodo bibendum. Aenean dapibus, turpis ac fermentum vestibulum, orci elit feugiat risus, id pharetra quam mauris quis lectus. Donec magna nunc, pulvinar in adipiscing vel, pulvinar nec nulla. Aenean vitae est at nisi volutpat lobortis et id diam.</p>\r\n		</div>\r\n	</div>\r\n</div>\r\n<p>\r\n	&nbsp;</p>\r\n', '', '', '', '1', 1317966185, 1317978111, 2),
(31, 'Important Contacts', 'important-contacts.html', '<table align="left" border="1" cellpadding="1" cellspacing="1" style="width: 500px;">\r\n	<thead>\r\n		<tr>\r\n			<th scope="col">\r\n				Name</th>\r\n			<th scope="col">\r\n				Ext. No.</th>\r\n			<th scope="col">\r\n				Mobile</th>\r\n		</tr>\r\n	</thead>\r\n	<tbody>\r\n		<tr>\r\n			<td>\r\n				<strong>Abhinav Girdhar, Dennis John, Ravindra Juyal</strong></td>\r\n			<td>\r\n				<strong>201</strong></td>\r\n			<td>\r\n				&nbsp;</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n				<strong>System Admin &ndash; Tarun Pandey</strong></td>\r\n			<td>\r\n				<strong>507</strong></td>\r\n			<td>\r\n				&nbsp;</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n				<strong>HR &ndash; Nandini</strong></td>\r\n			<td>\r\n				<strong>311</strong></td>\r\n			<td>\r\n				&nbsp;</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n				<strong>Reception</strong></td>\r\n			<td>\r\n				<strong>200</strong></td>\r\n			<td>\r\n				&nbsp;</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n				<strong>Conference Room</strong></td>\r\n			<td>\r\n				<strong>300</strong></td>\r\n			<td>\r\n				&nbsp;</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n				<strong>Cafeteria</strong></td>\r\n			<td>\r\n				<strong>225</strong></td>\r\n			<td>\r\n				&nbsp;</td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n<p>\r\n	&nbsp;</p>\r\n', 'Important Contacts', 'Important Contacts', 'Important Contacts', '1', 1318403122, 1318409373, 2),
(12, 'Rules & Regulations', 'rules.html', '<div id="lipsum">\r\n	<p>\r\n		Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur eu eros nisi. Donec dignissim lacus nec ante interdum quis aliquet dolor posuere. Nullam id eros erat, quis sollicitudin ante. Donec ut nibh nibh, at tempor lacus. Sed dictum, nisl non elementum laoreet, ligula eros facilisis nisl, sit amet consequat nisl purus id lectus. Aliquam non eros vitae enim ornare tempus eu vel elit. Sed vehicula tempus suscipit.</p>\r\n	<p>\r\n		Mauris vel urna eget urna vehicula facilisis. Quisque id magna eu urna tempor laoreet vel ut libero. Sed ut nisl non velit gravida egestas. Suspendisse ultrices nibh nec urna mattis a egestas mi suscipit. Ut nulla lectus, scelerisque in mollis in, posuere sed purus. Donec quis lectus iaculis sem eleifend congue. Curabitur at dolor sed mauris tristique iaculis ac ut nisl. Morbi vulputate augue vel lectus malesuada feugiat. Praesent lacus nisi, consectetur aliquam suscipit in, tempus in leo. Proin sed eros diam, vel mattis dolor. Cras a urna aliquet quam posuere euismod ac vitae metus. Morbi faucibus, dolor ut eleifend convallis, metus lectus luctus felis, nec porta orci velit vitae magna. Etiam mattis, elit quis ultricies pretium, mauris augue mattis enim, eu posuere enim dui quis nunc.</p>\r\n	<p>\r\n		Praesent massa augue, mollis at consequat vel, dignissim eu metus. Suspendisse eros elit, mattis nec accumsan nec, tempus eu felis. Maecenas eu nibh nec nisi fermentum dignissim. Donec et dui orci. Pellentesque ut diam tellus. Etiam fermentum, felis ac dapibus dignissim, eros nisi commodo diam, sit amet euismod eros nulla rhoncus metus. Nullam sed purus a risus rutrum viverra id interdum turpis.</p>\r\n	<p>\r\n		Phasellus consequat accumsan justo, in molestie neque luctus in. Nulla urna nisl, semper non pharetra non, convallis ut ante. Sed libero felis, sodales eget congue quis, facilisis id arcu. Vestibulum vel augue magna. Phasellus id euismod mi. Maecenas pulvinar posuere arcu, et pellentesque magna eleifend vitae. Pellentesque magna magna, egestas id auctor ut, sodales at nibh. In malesuada tempor eros, nec posuere justo aliquet scelerisque. Suspendisse at laoreet mi. Vestibulum porttitor consequat risus quis lacinia. Nulla id ultricies magna. Fusce congue aliquet justo, in fermentum tortor laoreet lobortis. Mauris posuere ornare mattis. Nam scelerisque tellus a nisi hendrerit vel adipiscing mi hendrerit. Duis ac leo arcu, nec tincidunt enim.</p>\r\n	<p>\r\n		Curabitur blandit, lectus aliquet porta tempor, lacus enim vulputate purus, non rhoncus ligula nulla at quam. Integer congue accumsan suscipit. Suspendisse quis velit metus. Nam velit urna, eleifend quis eleifend id, tristique quis urna. Vivamus pellentesque vulputate ante, eu fringilla nibh ornare vel. Integer ultricies iaculis neque, nec semper neque scelerisque ut. Duis lectus sapien, tempor vitae semper et, semper eget mauris.</p>\r\n	<p>\r\n		Mauris elementum, orci in facilisis porta, mi ligula placerat sem, nec ullamcorper velit mauris id eros. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Cras eget diam nisl, nec venenatis dolor. Integer laoreet sapien facilisis erat volutpat aliquet. Fusce feugiat eleifend mi. Phasellus et lectus feugiat urna semper interdum. Morbi a lobortis dolor. Etiam ultrices accumsan quam vitae venenatis. Pellentesque at magna libero. Donec ut purus non magna lacinia consequat vel eu urna. Proin dignissim lacinia mauris vel sollicitudin. Donec est velit, pellentesque vel imperdiet vel, pharetra quis eros. Duis tincidunt sem enim. Quisque sed consequat enim. Pellentesque ut purus ligula, sit amet tincidunt nibh.</p>\r\n	<p>\r\n		Mauris sagittis convallis faucibus. Etiam at faucibus lorem. Pellentesque eu enim nec dolor vestibulum commodo eu eu justo. Duis dictum aliquam purus, sit amet suscipit sapien congue a. Donec commodo sem a sapien vulputate auctor. Sed lectus nisi, dictum quis varius nec, viverra quis nisi. Fusce porta imperdiet urna, eu lacinia felis commodo nec. Proin ac metus ante.</p>\r\n	<p>\r\n		In ac mauris dui, et eleifend dolor. Vestibulum et purus augue, non venenatis erat. Sed eu risus nec ligula mattis ullamcorper et sed nunc. Quisque tristique lacus eros. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque vitae elementum lectus. Maecenas nec libero erat. Nulla et ornare dolor. Quisque faucibus, est et consectetur hendrerit, lacus sem lacinia elit, nec fringilla mi ante non tellus. Vestibulum laoreet faucibus leo vestibulum laoreet.</p>\r\n	<p>\r\n		Fusce eu nunc ante, a varius lacus. Vestibulum sed odio at metus pharetra feugiat eu quis tellus. Morbi gravida, eros sit amet lacinia viverra, tortor risus sagittis mi, eu molestie libero augue ac dolor. Vestibulum id condimentum augue. Pellentesque placerat condimentum libero non tincidunt. Praesent feugiat, tortor non placerat consequat, felis ligula euismod lacus, sed lobortis sapien nisl id justo. Sed ac mauris leo, at vestibulum quam. Maecenas arcu est, egestas eu auctor vel, euismod sit amet eros. Fusce sagittis tortor eu nisi hendrerit ut ullamcorper lectus aliquam. Praesent a placerat quam. Maecenas interdum posuere enim sit amet aliquet. Maecenas sit amet urna ac lectus pretium commodo at ut nunc. Aliquam congue ultrices placerat. Nunc quis posuere dolor. Aenean vitae lacus purus. Vestibulum molestie sem at dolor accumsan ultrices.</p>\r\n	<p>\r\n		Morbi in mauris ac tortor semper porttitor vitae et massa. Aliquam lacus ante, consectetur quis convallis non, sodales in elit. Nunc hendrerit interdum sapien, a malesuada lorem egestas sit amet. Suspendisse mauris est, rhoncus in placerat ut, ornare sit amet sapien. Donec lacus turpis, tincidunt non posuere ac, sollicitudin vel eros. In feugiat est in sem viverra aliquam. Praesent condimentum tristique neque vitae pellentesque. Maecenas sodales luctus justo vitae pulvinar. Praesent tellus mauris, cursus in accumsan sit amet, pellentesque quis sem. Vestibulum in orci eros, id adipiscing dui.</p>\r\n	<p>\r\n		Donec sit amet tempor felis. Pellentesque molestie felis ut velit rutrum sagittis in et nisi. Pellentesque diam metus, accumsan quis tristique at, bibendum sed nisi. Cras eleifend nisi eget ligula viverra a auctor odio placerat. Praesent euismod adipiscing rhoncus. Sed malesuada condimentum dolor vitae luctus. Pellentesque dui nibh, viverra non ornare ac, rhoncus vel nibh. Integer iaculis bibendum lacus nec pharetra. Proin non magna vitae nisl convallis vestibulum. Proin ut nibh felis. Pellentesque quis magna leo, eget ultricies lectus. Vivamus congue justo dui, eu cursus dolor. Suspendisse ornare nulla ut massa ornare et varius dolor viverra. Donec massa lorem, dapibus nec accumsan quis, molestie in lorem.</p>\r\n	<p>\r\n		Praesent congue, nibh vitae porttitor molestie, sapien ipsum sollicitudin nunc, eu varius lorem risus id risus. Nunc quis malesuada mi. Nam neque lectus, malesuada ac feugiat non, adipiscing eu diam. Mauris et molestie enim. Nam laoreet nunc ut lorem commodo bibendum. Aenean dapibus, turpis ac fermentum vestibulum, orci elit feugiat risus, id pharetra quam mauris quis lectus. Donec magna nunc, pulvinar in adipiscing vel, pulvinar nec nulla. Aenean vitae est at nisi volutpat lobortis et id diam.</p>\r\n</div>\r\n', 'rules', 'rules', 'rules', '1', 1284464039, 1317974807, 1);

-- --------------------------------------------------------

--
-- Table structure for table `pictures`
--

CREATE TABLE IF NOT EXISTS `pictures` (
  `id` int(14) NOT NULL auto_increment,
  `image` varchar(255) NOT NULL,
  `album_id` int(14) NOT NULL,
  `addedon` bigint(24) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=193 ;

--
-- Dumping data for table `pictures`
--

INSERT INTO `pictures` (`id`, `image`, `album_id`, `addedon`) VALUES
(1, 'album_picture_1.jpg', 2, 1319204178),
(2, 'album_picture_2.jpg', 2, 1319204185),
(3, 'album_picture_3.jpg', 2, 1319204193),
(4, 'album_picture_4.jpg', 2, 1319204200),
(5, 'album_picture_5.jpg', 2, 1319204216),
(6, 'album_picture_6.jpg', 2, 1319204223),
(7, 'album_picture_7.jpg', 2, 1319204230),
(8, 'album_picture_8.jpg', 2, 1319204245),
(9, 'album_picture_9.jpg', 2, 1319204254),
(10, 'album_picture_10.jpg', 2, 1319204261),
(11, 'album_picture_11.jpg', 2, 1319204726),
(12, 'album_picture_12.jpg', 2, 1319204732),
(13, 'album_picture_13.jpg', 2, 1319204738),
(14, 'album_picture_14.jpg', 2, 1319204744),
(15, 'album_picture_15.jpg', 2, 1319204752),
(16, 'album_picture_16.jpg', 2, 1319204758),
(17, 'album_picture_17.jpg', 2, 1319204768),
(18, 'album_picture_18.jpg', 2, 1319204774),
(19, 'album_picture_19.jpg', 4, 1319204805),
(20, 'album_picture_20.jpg', 4, 1319204811),
(21, 'album_picture_21.jpg', 2, 1319205005),
(22, 'album_picture_22.jpg', 2, 1319205175),
(23, 'album_picture_23.jpg', 2, 1319206311),
(24, 'album_picture_24.jpg', 2, 1319206336),
(25, 'album_picture_25.jpg', 2, 1319206406),
(26, 'album_picture_26.jpg', 2, 1319206475),
(27, 'album_picture_27.jpg', 2, 1319206522),
(28, 'album_picture_28.jpg', 2, 1319206539),
(29, 'album_picture_29.jpg', 2, 1319206545),
(30, 'album_picture_30.jpg', 2, 1319206550),
(31, 'album_picture_31.jpg', 2, 1319206556),
(32, 'album_picture_32.jpg', 2, 1319206562),
(33, 'album_picture_33.jpg', 3, 1319208005),
(34, 'album_picture_34.jpg', 3, 1319208010),
(35, 'album_picture_35.jpg', 3, 1319208016),
(36, 'album_picture_36.jpg', 3, 1319208021),
(37, 'album_picture_37.jpg', 3, 1319208029),
(38, 'album_picture_38.jpg', 3, 1319208037),
(39, 'album_picture_39.jpg', 3, 1319208042),
(40, 'album_picture_40.jpg', 3, 1319208048),
(41, 'album_picture_41.jpg', 3, 1319208054),
(42, 'album_picture_42.jpg', 3, 1319208059),
(43, 'album_picture_43.jpg', 3, 1319208066),
(44, 'album_picture_44.jpg', 3, 1319208072),
(45, 'album_picture_45.jpg', 3, 1319208077),
(46, 'album_picture_46.jpg', 3, 1319208082),
(47, 'album_picture_47.jpg', 3, 1319208088),
(48, 'album_picture_48.jpg', 3, 1319208093),
(49, 'album_picture_49.jpg', 3, 1319208099),
(50, 'album_picture_50.jpg', 3, 1319208104),
(51, 'album_picture_51.jpg', 1, 1319208137),
(52, 'album_picture_52.jpg', 1, 1319208142),
(53, 'album_picture_53.jpg', 1, 1319208148),
(54, 'album_picture_54.jpg', 1, 1319208154),
(55, 'album_picture_55.jpg', 1, 1319208160),
(56, 'album_picture_56.jpg', 1, 1319208165),
(57, 'album_picture_57.jpg', 1, 1319208171),
(58, 'album_picture_58.jpg', 1, 1319208177),
(59, 'album_picture_59.jpg', 1, 1319208182),
(60, 'album_picture_60.jpg', 1, 1319208188),
(61, 'album_picture_61.jpg', 4, 1319208215),
(62, 'album_picture_62.jpg', 4, 1319208221),
(63, 'album_picture_63.jpg', 4, 1319208227),
(64, 'album_picture_64.jpg', 4, 1319208232),
(65, 'album_picture_65.jpg', 4, 1319439802),
(66, 'album_picture_66.jpg', 4, 1319440385),
(67, 'album_picture_67.jpg', 0, 1319441117),
(68, 'album_picture_68.jpg', 4, 1319441186),
(69, 'album_picture_69.jpg', 3, 1319441226),
(70, 'album_picture_70.jpg', 3, 1319441238),
(188, 'album_picture_188.jpg', 5, 1319465610),
(74, 'album_picture_74.jpg', 5, 1319443174),
(76, 'album_picture_76.jpg', 5, 1319443185),
(79, 'album_picture_79.jpg', 5, 1319443203),
(81, 'album_picture_81.jpg', 5, 1319443214),
(82, 'album_picture_82.jpg', 5, 1319443220),
(83, 'album_picture_83.jpg', 5, 1319443226),
(84, 'album_picture_84.jpg', 5, 1319443232),
(85, 'album_picture_85.jpg', 5, 1319443237),
(86, 'album_picture_86.jpg', 5, 1319443243),
(87, 'album_picture_87.jpg', 5, 1319443249),
(88, 'album_picture_88.jpg', 5, 1319443254),
(91, 'album_picture_91.jpg', 5, 1319443272),
(92, 'album_picture_92.jpg', 5, 1319443278),
(93, 'album_picture_93.jpg', 5, 1319443284),
(94, 'album_picture_94.jpg', 5, 1319443290),
(95, 'album_picture_95.jpg', 5, 1319443296),
(97, 'album_picture_97.jpg', 5, 1319443306),
(98, 'album_picture_98.jpg', 5, 1319443312),
(99, 'album_picture_99.jpg', 5, 1319443317),
(100, 'album_picture_100.jpg', 5, 1319443323),
(101, 'album_picture_101.jpg', 5, 1319443328),
(102, 'album_picture_102.jpg', 5, 1319443334),
(103, 'album_picture_103.jpg', 5, 1319443340),
(104, 'album_picture_104.jpg', 5, 1319443346),
(107, 'album_picture_107.jpg', 5, 1319443364),
(108, 'album_picture_108.jpg', 5, 1319443370),
(109, 'album_picture_109.jpg', 5, 1319443376),
(112, 'album_picture_112.jpg', 5, 1319443394),
(113, 'album_picture_113.jpg', 5, 1319443400),
(114, 'album_picture_114.jpg', 5, 1319443405),
(115, 'album_picture_115.jpg', 5, 1319443412),
(116, 'album_picture_116.jpg', 5, 1319443417),
(117, 'album_picture_117.jpg', 5, 1319443423),
(118, 'album_picture_118.jpg', 5, 1319443429),
(119, 'album_picture_119.jpg', 5, 1319443434),
(120, 'album_picture_120.jpg', 5, 1319443440),
(121, 'album_picture_121.jpg', 5, 1319443446),
(122, 'album_picture_122.jpg', 5, 1319443452),
(123, 'album_picture_123.jpg', 5, 1319443458),
(124, 'album_picture_124.jpg', 5, 1319443464),
(125, 'album_picture_125.jpg', 5, 1319443469),
(126, 'album_picture_126.jpg', 5, 1319443475),
(127, 'album_picture_127.jpg', 5, 1319443480),
(128, 'album_picture_128.jpg', 5, 1319443486),
(129, 'album_picture_129.jpg', 5, 1319443491),
(130, 'album_picture_130.jpg', 5, 1319443497),
(131, 'album_picture_131.jpg', 5, 1319443503),
(132, 'album_picture_132.jpg', 5, 1319443509),
(133, 'album_picture_133.jpg', 5, 1319443514),
(134, 'album_picture_134.jpg', 5, 1319443520),
(135, 'album_picture_135.jpg', 5, 1319443525),
(136, 'album_picture_136.jpg', 5, 1319443531),
(137, 'album_picture_137.jpg', 5, 1319443537),
(138, 'album_picture_138.jpg', 5, 1319443542),
(139, 'album_picture_139.jpg', 5, 1319443548),
(140, 'album_picture_140.jpg', 5, 1319443553),
(141, 'album_picture_141.jpg', 5, 1319443559),
(142, 'album_picture_142.jpg', 5, 1319443565),
(144, 'album_picture_144.jpg', 5, 1319443575),
(145, 'album_picture_145.jpg', 5, 1319443581),
(146, 'album_picture_146.jpg', 5, 1319443586),
(148, 'album_picture_148.jpg', 5, 1319443597),
(149, 'album_picture_149.jpg', 5, 1319443603),
(150, 'album_picture_150.jpg', 5, 1319443609),
(151, 'album_picture_151.jpg', 5, 1319443614),
(152, 'album_picture_152.jpg', 5, 1319443620),
(153, 'album_picture_153.jpg', 5, 1319443626),
(154, 'album_picture_154.jpg', 5, 1319443632),
(155, 'album_picture_155.jpg', 5, 1319443638),
(157, 'album_picture_157.jpg', 5, 1319443650),
(158, 'album_picture_158.jpg', 5, 1319443655),
(159, 'album_picture_159.jpg', 5, 1319443661),
(162, 'album_picture_162.jpg', 5, 1319443678),
(163, 'album_picture_163.jpg', 5, 1319443683),
(192, 'album_picture_192.jpg', 5, 1319799609),
(166, 'album_picture_166.jpg', 5, 1319443700),
(167, 'album_picture_167.jpg', 5, 1319443706),
(172, 'album_picture_172.jpg', 5, 1319443734),
(173, 'album_picture_173.jpg', 8, 1319444019),
(174, 'album_picture_174.jpg', 10, 1319444302),
(175, 'album_picture_175.jpg', 11, 1319444469),
(176, 'album_picture_176.jpg', 11, 1319444474),
(177, 'album_picture_177.jpg', 11, 1319444478),
(178, 'album_picture_178.jpg', 11, 1319444482),
(179, 'album_picture_179.jpg', 11, 1319444487);

-- --------------------------------------------------------

--
-- Table structure for table `project`
--

CREATE TABLE IF NOT EXISTS `project` (
  `id` int(11) NOT NULL auto_increment,
  `title` varchar(255) NOT NULL,
  `description` text,
  `client_info` text,
  `start_date` date default NULL,
  `end_date` date default NULL,
  `status` enum('open','close') NOT NULL,
  `project_manager_id` int(14) NOT NULL,
  `team_leader_id` int(14) NOT NULL,
  `addedon` bigint(28) NOT NULL,
  `updatedon` bigint(28) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `project`
--

INSERT INTO `project` (`id`, `title`, `description`, `client_info`, `start_date`, `end_date`, `status`, `project_manager_id`, `team_leader_id`, `addedon`, `updatedon`) VALUES
(1, '3Bakers', '3Bakers.pbodev.info', 'Jim', '2011-10-01', '2011-11-30', 'open', 39, 1, 1321536446, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `project_user`
--

CREATE TABLE IF NOT EXISTS `project_user` (
  `id` int(14) NOT NULL auto_increment,
  `project_id` int(14) NOT NULL,
  `user_id` int(14) NOT NULL,
  `status` enum('active','inactive') NOT NULL default 'active',
  `addedon` bigint(28) NOT NULL,
  `updatedon` bigint(28) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `project_user`
--

INSERT INTO `project_user` (`id`, `project_id`, `user_id`, `status`, `addedon`, `updatedon`) VALUES
(1, 1, 30, 'active', 1321536446, NULL),
(2, 1, 1, 'active', 1321536446, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `request`
--

CREATE TABLE IF NOT EXISTS `request` (
  `id` int(14) NOT NULL auto_increment,
  `department_id` int(11) NOT NULL,
  `request` text NOT NULL,
  `status` enum('open','close') NOT NULL default 'open',
  `remarks` text,
  `requested_by` int(14) NOT NULL,
  `user_id` int(14) default NULL,
  `addedon` bigint(28) NOT NULL,
  `updatedon` bigint(28) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=21 ;

--
-- Dumping data for table `request`
--

INSERT INTO `request` (`id`, `department_id`, `request`, `status`, `remarks`, `requested_by`, `user_id`, `addedon`, `updatedon`) VALUES
(1, 2, 'my system is not working', 'close', 'you request has been resolved, please check', 2, 2, 1317733984, 1318402159),
(2, 2, 'asdsdf asdfadsf', 'close', 'your request has been resolved.', 2, 2, 1317734136, 1318402262),
(3, 2, 'asfsdfdsf', 'open', NULL, 2, 2, 1317734160, NULL),
(4, 2, 'asdfsd fdsf sdfdfdasfs sdfsadf safdsf asdf asfasd fasdasdfasd', 'close', 'jiyo mere laal', 2, 2, 1317734279, 1318402390),
(5, 2, 'as sdf adsfsdas as sdf adsfsdas as sdf adsfsdas as sdf adsfsdas as sdf adsfsdas as sdf adsfsdas as sdf adsfsdas as sdf adsfsdas as sdf adsfsdas as sdf adsfsdas as sdf adsfsdas as sdf adsfsdas as sdf adsfsdas as sdf adsfsdas as sdf adsfsdas as sdf adsfsdas as sdf adsfsdas as sdf adsfsdas as sdf adsfsdas as sdf adsfsdas as sdf adsfsdas as sdf adsfsdas as sdf adsfsdas as sdf adsfsdas as sdf adsfsdas as sdf adsfsdas as sdf adsfsdas as sdf adsfsdas as sdf adsfsdas as sdf adsfsdas as sdf adsfsdas as sdf adsfsdas as sdf adsfsdas ', 'open', NULL, 2, 2, 1317734306, NULL),
(6, 3, 'xdsfdsfdsfsf', 'open', NULL, 2, 2, 1317812953, NULL),
(7, 5, 'dsfasdfsad', 'open', NULL, 2, 2, 1317886467, NULL),
(8, 2, 'my system is not working, please look into this.', 'close', 'aaaaaaaaaaaaa', 2, 2, 1317899653, 1318334994),
(9, 2, 'can you see my previous request.', 'close', 'dddddddddd', 2, 2, 1317899698, 1318334984),
(10, 2, 'please see', 'open', NULL, 2, 2, 1317899861, NULL),
(11, 2, 'please see', 'close', 'closed and fixed', 2, 2, 1317899894, 1318336438),
(12, 2, 'hi you are not serious', 'close', 'cool', 2, 2, 1317900000, 1318335308),
(13, 9, 'hgkkkkk', 'close', 'ravinesh test', 83, 1, 1319097467, 1319098477),
(14, 9, 'czxcxzczxc', 'open', NULL, 83, NULL, 1319097606, NULL),
(15, 9, 'asdfsdaf', 'open', NULL, 1, NULL, 1319098429, NULL),
(16, 9, 'asdfsdaf', 'open', NULL, 1, NULL, 1319098440, NULL),
(17, 8, 'test', 'open', NULL, 1, NULL, 1319116840, NULL),
(18, 8, 'test aaaaa', 'open', NULL, 1, NULL, 1319116890, NULL),
(19, 8, 'tttsssaaa', 'open', NULL, 1, NULL, 1319117046, NULL),
(20, 8, 'test from onsis', 'open', NULL, 1, NULL, 1319117400, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `seo_url`
--

CREATE TABLE IF NOT EXISTS `seo_url` (
  `id` int(11) NOT NULL auto_increment,
  `actual_url` varchar(255) NOT NULL,
  `seo_url` varchar(255) character set utf8 collate utf8_bin NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=391 ;

--
-- Dumping data for table `seo_url`
--

INSERT INTO `seo_url` (`id`, `actual_url`, `seo_url`) VALUES
(380, '/index/login', '/login'),
(381, '/employee/page/identifire/my-page', '/my-page'),
(382, '/employee/page/identifire/sdfsdf-asdfasdfassdfasdf', '/sdfsdf-asdfasdfassdfasdf'),
(383, '/employee/page/identifire/dsdafsadf-asdfsda-fasd-test', '/dsdafsadf-asdfsda-fasd-test'),
(384, '/employee/page/identifire/leave-policy.html', '/leave-policy.html'),
(385, '/employee/page/identifire/rules.html', '/rules.html'),
(386, '/employee/page/identifire/advice', '/advice'),
(387, '/employee/page/identifire/privacy-policy', '/privacy-policy'),
(388, '/employee/page/identifire/about', '/about'),
(389, '/employee/page/identifire/employee-benifits', '/employee-benifits'),
(390, '/employee/page/identifire/important-contacts.html', '/important-contacts.html');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(14) NOT NULL auto_increment,
  `employee_code` varchar(100) NOT NULL,
  `email` varchar(100) default NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(40) NOT NULL,
  `first_name` varchar(60) default NULL,
  `middle_name` varchar(100) default NULL,
  `last_name` varchar(60) default NULL,
  `dob` date default NULL,
  `sex` enum('male','female') default 'male',
  `profile_picture` varchar(255) default NULL,
  `mobile` varchar(15) default NULL,
  `contact_no` varchar(100) default NULL,
  `extension_no` varchar(50) default NULL,
  `skype` varchar(100) default NULL,
  `status` enum('active','inactive','deleted') NOT NULL default 'active',
  `doj` date NOT NULL,
  `marriage_anniversary` date default NULL,
  `father_name` varchar(255) default NULL,
  `designation_id` int(6) NOT NULL,
  `department_id` int(14) NOT NULL,
  `correspondence_address` text,
  `pan` varchar(100) default NULL,
  `addedon` int(28) NOT NULL,
  `updatedon` int(28) default NULL,
  `user_level_id` int(11) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=115 ;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `employee_code`, `email`, `username`, `password`, `first_name`, `middle_name`, `last_name`, `dob`, `sex`, `profile_picture`, `mobile`, `contact_no`, `extension_no`, `skype`, `status`, `doj`, `marriage_anniversary`, `father_name`, `designation_id`, `department_id`, `correspondence_address`, `pan`, `addedon`, `updatedon`, `user_level_id`) VALUES
(1, '53', 'ritesh@profitbyoutsourcing.com', 'riteshsahu', '2e355c62e2700da907332157c85b44d4', 'Ritesh', 'Kumar', 'Sahu', '1980-10-05', 'male', 'profile_1.png', '9871901519', '', '307', 'ritesh.ons', 'active', '2006-05-17', '2011-09-01', 'Pradeep Kumar Sahu', 10, 4, '95D, Sector-71, Noida', 'BIZPS232', 1318838489, 1321620720, 2),
(2, '41', 'ak@profitbysearch.com', 'ak@profitbysearch.com', 'e10adc3949ba59abbe56e057f20f883e', 'Aasif', '', 'Khan', '1981-01-04', 'male', '', '9911177596', '', '511', 'aasif.pbs', 'active', '2009-01-01', '0000-00-00', 'Asfak  Khan', 29, 2, 'B-186/10, Suraj Kund Road, (Faridabad)', 'AVKPK2195B', 1318838489, 1321620720, 1),
(3, '188', 'abhijeet@profitbyoutsourcing.com', 'abhijeet@profitbyoutsourcing.com', 'e10adc3949ba59abbe56e057f20f883e', 'Abhijeet', '', 'Kumar', '1963-06-05', 'male', '', '9899898529', '', '510', 'abhijeet.ons', 'active', '2009-05-17', '0000-00-00', 'RatneshÂ  Kr. Sinha', 7, 4, 'A-737, BudhaÂ  Marg, Mandawali, Delhi -110092', '', 1318838489, 1321620720, 1),
(4, '1', 'abhinav@profitbyoutsourcing.com', 'abhinav@profitbyoutsourcing.com', 'e10adc3949ba59abbe56e057f20f883e', 'Abhinav', '', 'Girdhar', '1958-08-05', 'male', '', '', '', '509', '', 'active', '2009-05-18', '0000-00-00', 'Mr. Raj kumar Girdhar', 2, 17, '', '', 1318838489, 1321620720, 1),
(5, '153', 'anupam@profitbyoutsourcing.com', 'anupam@profitbyoutsourcing.com', 'e10adc3949ba59abbe56e057f20f883e', 'Abhishek', '', 'Anupam', '1981-07-13', 'male', '', '9958070398', '', '508', 'abhishek.ons', 'active', '2009-05-19', '0000-00-00', 'Mr. Arun Pandey', 15, 6, 'D2-23/A, Jeevan Park, Uttam Nagar, 100059', 'AGMPA8380K', 1318838489, 1321620720, 1),
(6, '167', 'ajay@profitbyoutsourcing.com', 'ajay@profitbyoutsourcing.com', 'e10adc3949ba59abbe56e057f20f883e', 'Ajay', '', 'Singh', '2011-07-04', 'male', '', '9990584889', '', '507', 'ajay.ons', 'active', '2009-05-20', '2010-12-02', '', 7, 4, '', '', 1318838489, 1321620720, 1),
(7, '193', 'akhilendra@revosysit.com', 'akhilendra@revosysit.com', 'e10adc3949ba59abbe56e057f20f883e', 'Akhilendra', '', 'Pratap', '1999-02-01', 'male', '', '', '', '506', 'akhilendra', 'active', '2010-09-12', '0000-00-00', '', 40, 9, '', '', 1318838489, 1321620720, 1),
(8, '104', 'akshay@revosysit.com', 'akshay@revosysit.com', 'e10adc3949ba59abbe56e057f20f883e', 'Akshay', '', '', '2000-08-20', 'male', '', '', '', '505', 'akshay', 'active', '2010-09-13', '0000-00-00', '', 40, 9, '', '', 1318838489, 1321620720, 1),
(9, '233', 'alakh@profitbyoutsourcing.com', 'alakh@profitbyoutsourcing.com', 'e10adc3949ba59abbe56e057f20f883e', 'Alakh', 'Niranjan', 'Kumar', '1958-08-05', 'male', '', '9015111017', '', '504', 'alakh.ons', 'active', '2010-09-14', '0000-00-00', 'Shri Munna Lal Prasad', 6, 4, '', '', 1318838489, 1321620720, 1),
(10, '44', 'amit@profitbysearch.com', 'amit@profitbysearch.com', 'e10adc3949ba59abbe56e057f20f883e', 'Amit', '', 'Kapoor', '1958-08-06', 'male', '', '9868272527', '', '503', 'amit.pbs', 'active', '2010-09-15', '0000-00-00', 'Kamal Kapoor', 29, 2, 'C-26/1, East Arjun Nagar, Shadhra, Delhi-32', '', 1318838489, 1321620720, 1),
(11, '155', 'amit@profitbysearch.com', 'amit@profitbysearch.com', 'e10adc3949ba59abbe56e057f20f883e', 'Amit', 'Kumar', 'Raman', '1958-08-07', 'male', '', '9312249132', '', '502', 'amit', 'active', '2010-09-16', '0000-00-00', 'Shree Gopal Jee', 43, 8, 'E/104, sector 36,Noida, Gautambuddha Nagar, UP', 'ALQPR4793J', 1318838489, 1321620720, 1),
(12, '190', 'ankit@profitbysearch.com', 'ankit@profitbysearch.com', 'e10adc3949ba59abbe56e057f20f883e', 'Ankit', '', 'Jain', '2011-07-04', 'male', '', '9953808716', '', '501', 'ankit.pbs', 'active', '2011-05-16', '0000-00-00', 'Sh.D.K.Jain', 43, 8, 'B/2, Akanksha Kunj, Mawana,Meerut(U.P.)', '', 1318838489, 1321620720, 1),
(13, '81', 'arun@profitbyoutsourcing.com', 'arun@profitbyoutsourcing.com', 'e10adc3949ba59abbe56e057f20f883e', 'Arun', 'Kumar', 'Shrivastava', '1981-01-04', 'male', '', '9582102025', '', '500', 'arun.ons', 'active', '2010-08-23', '0000-00-00', 'Sri Ravi Kishor shrivastava ', 7, 4, '100 radheshyam park sec-5 Rajender Nagar,Sahibabad', 'COJPS0585M', 1318838489, 1321620720, 1),
(14, '101', 'avadhesh@profitbyoutsourcing.com', 'avadhesh@profitbyoutsourcing.com', 'e10adc3949ba59abbe56e057f20f883e', 'Avadhesh', '', 'Kumar', '1981-01-05', 'male', '', '9899982115', '', '300', 'Avadhesh.ons', 'active', '2010-09-16', '2000-03-05', 'Shri Ramesh Chandra Purwar ', 9, 4, 'D-10 East Vinod Nagar Delhi', 'AOOPK2092N', 1318838489, 1321620720, 1),
(15, '16', 'avnish@profitbysearch.com', 'avnish@profitbysearch.com', 'e10adc3949ba59abbe56e057f20f883e', 'Avnish', '', 'Sharma', '1981-01-06', 'male', '', '9717336623', '', '301', 'avi.onsis', 'active', '2010-08-24', '0000-00-00', 'Mr S.K. Sharma', 43, 9, 'Hostel, A- 186, Aruna Park, Street No 1, Sakarpur, Delhi', '', 1318838489, 1321620720, 1),
(16, '204', 'barun@profitbysearch.com', 'barun@profitbysearch.com', 'e10adc3949ba59abbe56e057f20f883e', 'Barun', '', 'Kundu', '1981-01-07', 'male', '', '9971758134', '', '302', 'barun.pbs', 'active', '2011-06-13', '0000-00-00', '', 18, 12, '', '', 1318838489, 1321620720, 1),
(17, '115', 'bhupendra@profitbysearch.com', 'bhupendra@profitbysearch.com', 'e10adc3949ba59abbe56e057f20f883e', 'Bhupendra', 'Singh', 'Bisht', '1981-01-08', 'male', '', '8826471517', '', '303', 'bhupendra.pbs', 'active', '2010-10-18', '0000-00-00', '', 28, 2, '', '', 1318838489, 1321620720, 1),
(18, '186', 'bishakha@profitbysearch.com', 'bishakha@profitbysearch.com', 'e10adc3949ba59abbe56e057f20f883e', 'Bishakha', '', 'Mazumdar', '1981-01-09', 'female', '', '9582935496', '', '304', 'bishakha.pbs', 'active', '2011-05-10', '0000-00-00', 'Mr. P.C.Mazumdar', 18, 12, '', '', 1318838489, 1321620720, 1),
(19, '230', 'brijesh@profitbyoutsourcing.com', 'brijesh@profitbyoutsourcing.com', 'e10adc3949ba59abbe56e057f20f883e', 'Brijesh', '', 'Kumar', '1981-01-10', 'male', '', '9891236054', '', '305', 'brijesh.ons', 'active', '2011-08-22', '2011-03-07', 'Shri Shiv Narayan', 6, 4, 'MB- 165, Gali No- 4, Shakarpur New Delhi- 110092', 'BFWPK3727C', 1318838489, 1321620720, 1),
(20, '125', 'shekhar@profitbyoutsourcing.com', 'shekhar@profitbyoutsourcing.com', 'e10adc3949ba59abbe56e057f20f883e', 'Chandra', 'Shekhar', 'Pandey', '1980-02-19', 'male', '', '9210130688', '', '306', 'shekhar.ons', 'active', '2010-10-27', '1990-07-01', 'Mr. K. K . Pandey', 8, 4, 'D-467/8 ,Kadi Vihar Near Burari Delhi-84 ', 'ARVPP2643J', 1318838489, 1321620720, 1),
(21, '212', 'deepak@profitbysearch.com', 'deepak@profitbysearch.com', 'e10adc3949ba59abbe56e057f20f883e', 'Deepak', '', 'Kumar', '1980-02-20', 'male', '', '9313669540', '', '307', 'deepakkr.pbs', 'active', '2011-06-22', '0000-00-00', 'Sh. Dilip kumar', 21, 1, 'E-232Â  Sector 22 Noida, UP,201301', 'CDAPK6008H', 1318838489, 1321620720, 1),
(22, '89', ' deepakn@profitbysearch.com', ' deepakn@profitbysearch.com', 'e10adc3949ba59abbe56e057f20f883e', 'Deepak', '', 'Nagpal', '1980-02-21', 'male', '', '8800241945', '', '308', 'deepakn.pbs', 'active', '2010-07-05', '0000-00-00', 'Sh. Ashok Nagpal', 34, 2, 'R K Hostel Block - J sector -22, Noida', 'ADNPN8861A', 1318838489, 1321620720, 1),
(23, '163', 'deepak@profitbysearch.com', 'deepak@profitbysearch.com', 'e10adc3949ba59abbe56e057f20f883e', 'Deepak', '', 'Rajput', '1980-02-22', 'male', '', '9958568260', '', '309', 'deepak.pbs2', 'active', '2008-07-18', '0000-00-00', '', 30, 11, '', '', 1318838489, 1321620720, 1),
(24, '178', 'deepak@profitbyoutsourcing.com', 'deepak@profitbyoutsourcing.com', 'e10adc3949ba59abbe56e057f20f883e', 'Deepak', '', 'Verma', '1980-02-23', 'male', '', '9873450127', '', '310', 'dv.ons', 'active', '2008-07-19', '0000-00-00', 'BRAHMSINGH VERMA', 14, 6, 'HO. NO. D-92/24 VIJAY PARK MAIN ROAD MAUJPUR DELHI-110053', 'AMXPV9220G', 1318838489, 1321620721, 1),
(25, '88', 'dennis.john@profitbysearch.com', 'dennis.john@profitbysearch.com', 'e10adc3949ba59abbe56e057f20f883e', 'Dennis', '', 'John', '1980-02-24', 'male', '', '9999-3534-87 ', '', '311', 'dennis.ons', 'active', '2008-07-20', '2011-05-12', 'Mr. C.C. John', 3, 17, 'House Number 755, Sector 37, Arun vihar, NOIDA, 201303', 'AHRP J0086B', 1318838489, 1321620721, 1),
(26, '171', 'dharmendra@profitbyoutsourcing.com', 'dharmendra@profitbyoutsourcing.com', 'e10adc3949ba59abbe56e057f20f883e', 'Dharmendra', '', '', '1980-02-25', 'male', '', '8802914190', '', '312', 'dharmendra.ons', 'active', '2008-07-21', '0000-00-00', 'Mr. Anand Pal Gupta', 14, 6, 'RC-863, Vandana Encalev Eksatenshan, Khora Colony,Â  Ghaziabad. ', 'AXFPG3847H', 1318838489, 1321620721, 1),
(27, '201', 'dhiraj@profitbyoutsourcing.com', 'dhiraj@profitbyoutsourcing.com', 'e10adc3949ba59abbe56e057f20f883e', 'Dhiraj', '', 'Kumar', '1980-02-26', 'male', '', '9818398524', '', '313', 'dhiraj.ons', 'active', '2008-07-22', '2011-08-04', 'Dharmadeo mishra pant', 14, 6, 'A-110, New Ashok Nagar, new delhi- 110096', 'BPBPK5120E', 1318838489, 1321620721, 1),
(28, '203', 'dinesh@profitbyoutsourcing.com', 'dinesh@profitbyoutsourcing.com', 'e10adc3949ba59abbe56e057f20f883e', 'Dinesh', '', 'Saxena', '1999-11-30', 'male', '', '9899625702', '', '314', 'dinesh.ons', 'active', '2008-07-23', '2011-08-05', 'Shri Ved Prakash Saxena', 9, 5, 'B-338 New Ashok Nagar,New Delhi', 'AVLPS0713J', 1318838489, 1321620721, 1),
(29, '196', 'divij@revosysit.com', 'divij@revosysit.com', 'e10adc3949ba59abbe56e057f20f883e', 'Divij', '', 'Chadha', '1998-10-29', 'male', '', '9990565981', '', '315', 'divij', 'active', '2008-07-24', '0000-00-00', '', 38, 9, '', '', 1318838489, 1321620721, 1),
(30, '136', 'dushyant@profitbyoutsourcing.com', 'dushyant@profitbyoutsourcing.com', 'e10adc3949ba59abbe56e057f20f883e', 'Dushyant', '', 'Sharma', '1997-09-27', 'male', '', '9958296180Â ', '', '316', 'dushyant.ons', 'active', '2005-01-12', '0000-00-00', 'Prem Shanker Sharma', 15, 6, 'S 205 B block gali number 3 delhi 1100092', '', 1318838489, 1321620721, 1),
(31, '124', 'hari@profitbysearch.com', 'hari@profitbysearch.com', 'e10adc3949ba59abbe56e057f20f883e', 'Hari', 'Narayan', 'Jha', '1996-08-26', 'male', '', '9871177757', '', '317', 'hari.pbs', 'active', '2005-01-13', '0000-00-00', '', 28, 2, '', '', 1318838489, 1321620721, 1),
(32, '147', 'harish@profitbysearch.com', 'harish@profitbysearch.com', 'e10adc3949ba59abbe56e057f20f883e', 'Harish', '', 'Mehta', '1995-07-26', 'male', '', '9868646183', '', '318', 'harish.pbs', 'active', '2005-01-14', '0000-00-00', 'TrilokÂ  SinghÂ  Mehta', 21, 1, 'A - 100,Â  NewÂ  AshokÂ  Nagar,Â  Delhi -Â  96Â  (Near Sector - 1, Noida)', 'ANTPM8281F', 1318838489, 1321620721, 1),
(33, '231', 'harsharan@revosysit.com', 'harsharan@revosysit.com', 'e10adc3949ba59abbe56e057f20f883e', 'Harsharan', '', 'Singh', '1994-06-24', 'male', '', '9958068020, 955', '', '319', 'harsharan', 'active', '2005-01-15', '0000-00-00', 'Mr. Pritam Singh ', 39, 9, 'HNO: R-26, Sector-11, Noida ', 'AJKPB0999E', 1318838489, 1321620721, 1),
(34, '224', 'ishan@revosysit.com', 'ishan@revosysit.com', 'e10adc3949ba59abbe56e057f20f883e', 'Ishan', '', 'Mishra', '1993-05-23', 'male', '', '8800163488', '', '320', 'ishan', 'active', '2005-01-16', '0000-00-00', 'Mr. Ramesh Mishra', 40, 9, 'S-407 School Block Sakar PurÂ  , Laxmi Nagar, New Delhi', 'APWPM0288H', 1318838489, 1321620721, 1),
(35, '174', 'jai@profitbyoutsourcing.com', 'jai@profitbyoutsourcing.com', 'e10adc3949ba59abbe56e057f20f883e', 'Jai', '', 'Singh', '1992-04-21', 'male', '', '9013605806/9044', '', '321', 'jai.ons ', 'active', '2005-01-17', '0000-00-00', 'Mr.  Ravindra  Kumar  Singh', 5, 4, 'D-852  Madanpur  Khadar,  New  Delhi', '', 1318838489, 1321620721, 1),
(36, '141', 'jigyasa@profitbyoutsourcing.com', 'jigyasa@profitbyoutsourcing.com', 'e10adc3949ba59abbe56e057f20f883e', 'Jigyasa', '', 'Kulshrestha', '1991-03-21', 'female', '', '9899002766', '', '200', 'jigyasa.ons', 'active', '2005-01-18', '2009-02-26', 'Mr. R.K. Verma', 11, 16, '4-H, DEEPA APPARTMENTS, PLOT # 10, I.P. EXTENSION, PATPARGANJ, DELHI - 110092', 'APDPK8828E', 1318838489, 1321620721, 1),
(37, '73', 'jitendra@profitbyoutsourcing.com', 'jitendra@profitbyoutsourcing.com', 'e10adc3949ba59abbe56e057f20f883e', 'Jitendra', '', 'Saklani', '1990-02-17', 'male', '', '9650783330', '', '201', 'jitendra.pbs', 'active', '2005-01-19', '0000-00-00', 'Mr I D Saklani', 9, 4, '130 Z Block Sec 12 Noida', 'CAKPS4129J', 1318838489, 1321620721, 1),
(38, '213', 'jugal@profitbysearch.com', 'jugal@profitbysearch.com', 'e10adc3949ba59abbe56e057f20f883e', 'Jugal', '', 'Sharma', '1989-01-16', 'male', '', '9560722715', '', '202', 'jugal.pbs', 'active', '2005-01-20', '0000-00-00', 'Mr. Ram Avtar Sharma', 43, 8, 'G-5,sector-56,noida (U.P)', '', 1318838489, 1321620721, 1),
(39, '5', 'karn@neswebdesign.com', 'karn@neswebdesign.com', 'e10adc3949ba59abbe56e057f20f883e', 'Karn', '', 'Singh', '1987-12-16', 'male', '', '9891654650', '', '203', 'karn.ons', 'active', '2005-01-21', '2007-05-13', 'Late Shri Uday Pal Singh', 13, 16, 'C-76 D, Rajat Vihar, Sec - 62, Noida - 201301', 'BCZPS5902H', 1318838489, 1321620721, 4),
(40, '197', 'keshav@revosysit.com', 'keshav@revosysit.com', 'e10adc3949ba59abbe56e057f20f883e', 'Keshav', '', 'Adlakha', '1986-11-14', 'male', '', '8800338731', '', '204', 'keshav', 'active', '2005-01-22', '0000-00-00', '', 38, 9, '', '', 1318838489, 1321620721, 1),
(41, '120', 'zahir@profitbysearch.com', 'zahir@profitbysearch.com', 'e10adc3949ba59abbe56e057f20f883e', 'Khandakar', 'Zahir', 'Abbas', '1985-10-13', 'male', '', '9015215713', '', '205', 'khandakar', 'active', '2005-01-23', '0000-00-00', 'KHANDAKAR AMANULLAH', 42, 8, '1C/701, AWHO COLONY, GREATER NOIDA, UP-201308', 'AIVPA7655C', 1318838489, 1321620721, 1),
(42, '18', 'kunal@profitbyoutsourcing.com', 'kunal@profitbyoutsourcing.com', 'e10adc3949ba59abbe56e057f20f883e', 'Kunal', '', 'Shukla', '1984-09-11', 'male', '', '9871531566', '', '206', 'kunal.ons', 'active', '2005-01-24', '0000-00-00', 'Mr. Ramesh Chandra Shukla', 14, 6, 'WZ-5A, Dayal Sar Road Uttam Nagar Delhi-59', 'CCEPS9752D', 1318838489, 1321620721, 1),
(43, '34', 'lakhvinder@profitbysearch.com', 'lakhvinder@profitbysearch.com', 'e10adc3949ba59abbe56e057f20f883e', 'Lakhvinder', '', 'Singh', '1983-08-11', 'male', '', '9818981961', '', '207', 'lakhvinder.pbs', 'active', '2009-01-22', '0000-00-00', 'Anter Singh', 29, 2, 'C-17 East Arjun Nagar Delhi Shahdara 32', '', 1318838489, 1321620721, 1),
(44, '33', 'lalit@profitbysearch.com', 'lalit@profitbysearch.com', 'e10adc3949ba59abbe56e057f20f883e', 'Lalit', '', 'Kumar', '1982-07-10', 'male', '', '9971254305', '', '208', 'lalit.pbs', 'active', '2009-01-14', '0000-00-00', 'Jaiprakash', 29, 2, 'House No. 200, Main Market Badarpur, New Delhi-44', '', 1318838489, 1321620721, 1),
(45, '113', 'mahipal@profitbyoutsourcing.com', 'mahipal@profitbyoutsourcing.com', 'e10adc3949ba59abbe56e057f20f883e', 'Mahipal', 'Singh', 'Adhikari', '1981-06-08', 'male', '', '9818819730', '', '209', 'mahipal.ons', 'active', '2010-10-13', '0000-00-00', 'N. S.Â  Adhikari', 7, 4, 'E-127, Street No. 4, East Vinod Nagar, Delhi 110091', 'ALGPA6059A', 1318838489, 1321620721, 1),
(46, '66', 'manendra@profitbyoutsourcing.com', 'manendra@profitbyoutsourcing.com', 'e10adc3949ba59abbe56e057f20f883e', 'Manendra', 'Singh', 'Rawat', '1980-05-07', 'male', '', '9873265036', '', '210', 'manendra-singh', 'active', '2010-08-17', '0000-00-00', '', 6, 4, '', '', 1318838489, 1321620721, 1),
(47, '143', 'manikesh@profitbysearch.com', 'manikesh@profitbysearch.com', 'e10adc3949ba59abbe56e057f20f883e', 'Manikesh', '', 'Patel', '1979-04-06', 'male', '', '9268457184', '', '211', 'manikesh.pbs', 'active', '2010-12-13', '0000-00-00', '', 28, 2, '', '', 1318838489, 1321620721, 1),
(48, '219', 'manish@profitbysearch.com', 'manish@profitbysearch.com', 'e10adc3949ba59abbe56e057f20f883e', 'Manish', '', 'Kumar', '1978-03-05', 'male', '', '9555050812', '', '212', 'manish.pbs', 'active', '2011-07-18', '0000-00-00', '', 43, 8, '', '', 1318838489, 1321620722, 1),
(49, '85', 'manoj@profitbysearch.com', 'manoj@profitbysearch.com', 'e10adc3949ba59abbe56e057f20f883e', 'Manoj', '', 'Khanna', '1977-02-01', 'male', '', '9899196330', '', '213', 'manojk.pbs', 'active', '2010-06-14', '0000-00-00', 'Sh. Kimti Lal Khanna', 28, 2, '710/7 Govind Puri Kalka Ji, New  Delhi -110019', 'BKCPK4294D', 1318838489, 1321620722, 1),
(50, '8', 'khan@profitbysearch.com', 'khan@profitbysearch.com', 'e10adc3949ba59abbe56e057f20f883e', 'Md', 'Ataullah', 'Khan', '1974-11-30', 'male', '', '9953237567', '', '215', 'khan.pbs', 'active', '2008-03-31', '0000-00-00', 'Ashraf Ali', 35, 11, 'H. No. -40/17, Gautam Nagar, New Delhi-49', '', 1318838489, 1321620722, 1),
(51, '226', 'mitu@revosysit.com', 'mitu@revosysit.com', 'e10adc3949ba59abbe56e057f20f883e', 'Mitu', '', 'Kumari', '1973-10-29', 'female', '', '', '', '216', 'mitu', 'active', '2011-08-08', '0000-00-00', '', 40, 9, '', '', 1318838489, 1321620722, 1),
(52, '202', 'hasim@profitbyoutsourcing.com', 'hasim@profitbyoutsourcing.com', 'e10adc3949ba59abbe56e057f20f883e', 'Mohammad', '', 'Hasim', '1972-09-27', 'male', '', '9971832236', '', '217', 'hasim.ons', 'active', '2011-06-13', '0000-00-00', 'Late .Mohammad Nasim Siddiqui', 6, 3, 'C/o Nadebb Ahmad Flat No.1901 Army Camp Sec.37 Noida', 'CKMPS1672N', 1318838489, 1321620722, 1),
(53, '221', 'mohitg@profitbysearch.com', 'mohitg@profitbysearch.com', 'e10adc3949ba59abbe56e057f20f883e', 'Mohit', '', 'Gupta', '1971-08-27', 'male', '', '9212310121', '', '218', 'pbs.mohit', 'active', '2011-07-28', '0000-00-00', '', 33, 2, '', '', 1318838489, 1321620722, 1),
(54, '132', 'mohit@profitbysearch.com', 'mohit@profitbysearch.com', 'e10adc3949ba59abbe56e057f20f883e', 'Mohit', '', 'Sharma', '1970-07-26', 'male', '', '9873599691', '', '219', 'mohit.pbs', 'active', '2010-11-01', '0000-00-00', 'Sh.Â  AmarÂ  JeetÂ  Sharma', 22, 1, '#168 C,Â  Regent,Â  ShipraÂ  SunÂ  City,Â  Indrapuram,Â  GaziabadÂ  (U.P)', 'BXEPS9266E', 1318838489, 1321620722, 1),
(55, '198', 'moonmun@profitbysearch.com', 'moonmun@profitbysearch.com', 'e10adc3949ba59abbe56e057f20f883e', 'Moonmun', '', 'Ganguly', '1969-06-24', 'female', '', '9313633218', '', '500', 'moonmun.pbs', 'active', '2011-05-23', '0000-00-00', 'Mr.S.N.Ganguly', 18, 12, 'E-10,Ganesh nagar,near Akshardham,New Delhi-92', 'AQEPG9237B', 1318838489, 1321620722, 1),
(56, '156', 'mukesh@profitbyoutsourcing.com', 'mukesh@profitbyoutsourcing.com', 'e10adc3949ba59abbe56e057f20f883e', 'Mukesh', '', 'Vishwakarma', '1968-05-23', 'male', '', '9990150182', '', '501', 'mukesh11', 'active', '2011-01-31', '0000-00-00', 'Shri  Ram Ratan  Vishwakarma', 6, 3, 'C-111,  Raghubeer  Nagar,  New  Delhi', 'AJJPV1525D', 1318838489, 1321620722, 1),
(57, '2', 'hr@profitbysearch.com', 'hr@profitbysearch.com', 'e10adc3949ba59abbe56e057f20f883e', 'Nandini', '', 'Purkayastha', '1967-04-22', 'female', '', '9958180495', '', '502', 'nandini.hr', 'active', '2010-02-01', '0000-00-00', 'Mr K P Purkayastha', 47, 15, '163 Nitikhand 1st Indirapuram', 'AWFPP1476N', 1318838489, 1321620722, 3),
(58, '116', 'naresh@profitbysearch.com', 'naresh@profitbysearch.com', 'e10adc3949ba59abbe56e057f20f883e', 'Naresh', '', 'Kumar', '1966-03-21', 'male', '', '9213543217', '', '503', 'naresh.pbs', 'active', '2010-10-18', '0000-00-00', 'Mr.Kehar Singh', 28, 2, 'A/42 gali no 2 west vinod nagar delhi 110092    ', 'AZRPK6642E', 1318838489, 1321620722, 1),
(59, '187', 'neha.agarwal@profitbysearch.com', 'neha.agarwal@profitbysearch.com', 'e10adc3949ba59abbe56e057f20f883e', 'Neha', '', 'Agarwal', '1965-02-17', 'female', '', '8802409382', '', '504', 'neha.pbs', 'active', '2011-05-16', '0000-00-00', 'Mr Sanjay Agarwal', 21, 1, 'C-59, Sec19, NOIDA', 'AREPA8473A', 1318838489, 1321620722, 1),
(60, '199', 'nitin@revosysit.com', 'nitin@revosysit.com', 'e10adc3949ba59abbe56e057f20f883e', 'Nitin', 'Kumar', 'Saxena', '1964-01-17', 'male', '', '9999727296', '', '505', 'nitin.saxena23', 'active', '2011-05-23', '0000-00-00', '', 40, 9, '', '', 1318838489, 1321620722, 1),
(61, '157', 'nitins@profitbysearch.com', 'nitins@profitbysearch.com', 'e10adc3949ba59abbe56e057f20f883e', 'Nitin', 'Kumar', 'Srivastava', '1962-12-16', 'male', '', '9868100654', '', '506', 'nitin.pbs', 'active', '2007-02-09', '0000-00-00', 'Guru Prasad Shrivastava', 31, 2, 'B-149, Shiv Durga Vihar, Lakadpur, Faridabad, Haryana', '', 1318838489, 1321620722, 1),
(62, '185', 'nitin.nagpal@profitbysearch.com', 'nitin.nagpal@profitbysearch.com', 'e10adc3949ba59abbe56e057f20f883e', 'Nitin', '', 'Nagpal', '1961-11-14', 'male', '', '9911039888', '', '507', 'nitinn.pbs', 'active', '2007-02-10', '0000-00-00', 'sh. umeshÂ  chander nagpalÂ Â  ', 21, 1, 'h.no:-515/12 multani chowk hisar (haryana) ', 'ALAPN8086A', 1318838489, 1321620722, 1),
(63, '229', 'om@profitbyoutsourcing.com', 'om@profitbyoutsourcing.com', 'e10adc3949ba59abbe56e057f20f883e', 'Om', '', 'Prakash', '1960-10-13', 'male', '', '9871098813', '', '508', 'omi.ons', 'active', '2007-02-11', '0000-00-00', 'Late Shri Raghunath Prasad', 46, 14, 'C-49,IInd Floor, Ram Gali, Kotla Mubarakpur, New Delhi, Delhi 110003', 'BFTPP6471B', 1318838489, 1321620722, 1),
(64, '175', 'pankaj@profitbysearch.com', 'pankaj@profitbysearch.com', 'e10adc3949ba59abbe56e057f20f883e', 'Pankaj', '', 'Chauhan', '1959-09-12', 'male', '', '9717617459', '', '509', 'pankajc.pbs', 'active', '2007-02-12', '0000-00-00', '', 21, 1, '', '', 1318838489, 1321620722, 1),
(65, '99', 'pankaj@profitbysearch.com', 'pankaj@profitbysearch.com', 'e10adc3949ba59abbe56e057f20f883e', 'Pankaj', 'Kumar', 'Sharma', '1958-08-11', 'male', '', '9911014784', '', '510', 'pankaj.pbs', 'active', '2007-02-13', '0000-00-00', 'Mr. Rajendra Prasad Sharma', 28, 2, '476-B Chaura Raghunathpur, Sec-22 Noida-201301', '', 1318838489, 1321620722, 1),
(66, '232', 'paramjeet@profitbysearch.com', 'paramjeet@profitbysearch.com', 'e10adc3949ba59abbe56e057f20f883e', 'Paramjeet', 'Kaur', 'Narula', '1997-01-01', 'female', '', '9899140696', '', '511', 'paramjeet.pbs', 'active', '2007-02-14', '0000-00-00', 'Harbans Singh Narula', 43, 8, '67- D Pocket-1 Mayur Vihar, Phase- 1. New Delhi- 110091', 'ANYPN9877D', 1318838489, 1321620722, 1),
(67, '117', 'parul@profitbysearch.com', 'parul@profitbysearch.com', 'e10adc3949ba59abbe56e057f20f883e', 'Parul', '', 'Chaturvedi', '1997-01-09', 'female', '', '7838907338', '', '512', 'parul.pbs', 'active', '2007-02-15', '0000-00-00', 'Mr.Peyush Kumar Chaturvedi', 43, 8, 'A-17, Sector-27,Noida', '', 1318838489, 1321620722, 1),
(68, '225', 'praful@revosysit.com', 'praful@revosysit.com', 'e10adc3949ba59abbe56e057f20f883e', 'Praful', '', 'Prakash', '1998-02-10', 'male', '', '8527916288/ +91', '', '513', 'praful', 'active', '2011-03-31', '0000-00-00', 'Sri Satish Prasad', 40, 9, 'S-407, School Block,Sakarpur,Laxmi Nagar,New Delhi-110092', 'BJVPP1975N', 1318838489, 1321620722, 1),
(69, '138', 'pratishtha@profitbyoutsourcing.com', 'pratishtha@profitbyoutsourcing.com', 'e10adc3949ba59abbe56e057f20f883e', 'Pratishtha', '', 'Singh', '1999-03-14', 'female', '', '956077199', '', '514', 'pratishtha.ons', 'active', '2011-04-01', '0000-00-00', 'Krishna Pal Singh', 7, 4, 'PlotÂ  No-766 G1,Â  VaishaliÂ  GZBÂ  (UP)', 'APPPJ5007G', 1318838489, 1321620722, 1),
(70, '189', 'praveen@profitbysearch.com', 'praveen@profitbysearch.com', 'e10adc3949ba59abbe56e057f20f883e', 'Praveen', '', 'Kumar', '2000-04-14', 'male', '', '9716452355', '', '515', 'praveen.pbs', 'active', '2011-04-02', '0000-00-00', 'Yeswant Kumar', 43, 8, 'Vill:  Karehra,  Braham  Colony,  Mohan  Nagar, Ghaziabad,  U.P.  Pin:201007', 'BCAPK1175P', 1318838489, 1321620722, 1),
(71, '223', 'priti@profitbyoutsourcing.com', 'priti@profitbyoutsourcing.com', 'e10adc3949ba59abbe56e057f20f883e', 'Priti', '', 'Ray', '2001-05-16', 'female', '', '9899189616', '', '700', 'priti.ons', 'active', '2011-04-03', '2002-09-18', 'Anil Kumar Rai', 14, 6, 'A-95 F2 Sector, 2 Vaishali', 'APUPR9871F', 1318838489, 1321620722, 1),
(72, '83', 'puneet@profitbysearch.com', 'puneet@profitbysearch.com', 'e10adc3949ba59abbe56e057f20f883e', 'Puneet', '', 'Raman', '2002-06-17', 'male', '', '9818820605', '', '701', 'puneet.pbs', 'active', '2011-04-04', '0000-00-00', 'Mr . T.V.K. Raman', 21, 1, 'Plot No 730,Sec 5,Vaishali,GZB', 'AOFPR3496G', 1318838489, 1321620722, 1),
(73, '181', 'puneet@profitbyoutsourcing.com', 'puneet@profitbyoutsourcing.com', 'e10adc3949ba59abbe56e057f20f883e', 'Puneet', '', 'Tripathi', '2003-07-19', 'male', '', '9899850541', '', '702', 'puneet.ons', 'active', '2011-04-05', '0000-00-00', 'Shri. A.N. Tripathi', 7, 4, 'P-118 Sec-11 NoidaÂ  U.P. 201301', 'AFOPT6950P', 1318838489, 1321620722, 1),
(74, '183', 'raaj@profitbyoutsourcing.com', 'raaj@profitbyoutsourcing.com', 'e10adc3949ba59abbe56e057f20f883e', 'Raaj', '', 'Sharma', '2004-08-19', 'male', '', '9811531110', '', '703', 'raaj.ons', 'active', '2011-04-06', '0000-00-00', 'Sh. N. L. Sharma', 7, 4, '489, GF, Sector-4, Vaishali, Ghaziabad', 'AXSPS4937K', 1318838489, 1321620722, 1),
(75, '38', 'rg@profitbysearch.com', 'rg@profitbysearch.com', 'e10adc3949ba59abbe56e057f20f883e', 'Rahul', '', 'Goel', '2005-09-20', 'male', '', '9312787221', '', '704', 'rahul.pbs', 'active', '2011-04-07', '0000-00-00', 'Sushil Kumar Goyal', 25, 2, 'H-181, F. F., Sec- 22, Noida', '', 1318838489, 1321620722, 1),
(76, '214', 'rahulp@profitbysearch.com', 'rahulp@profitbysearch.com', 'e10adc3949ba59abbe56e057f20f883e', 'Rahul', '', 'Pokhriyal', '2006-10-22', 'male', '', '8802884856', '', '705', 'rahul', 'active', '2011-04-08', '0000-00-00', 'Mr. T.R. Pokhriyal', 43, 8, 'A-142, Sec-22, Noida', '', 1318838489, 1321620722, 1),
(77, '205', 'raj@profitbysearch.com', 'raj@profitbysearch.com', 'e10adc3949ba59abbe56e057f20f883e', 'Raj', 'Kumar', 'Mishra', '2007-11-23', 'male', '', '9540899876', '', '706', 'raj.pbs', 'active', '2011-04-09', '0000-00-00', 'M.L.Mishra', 21, 1, 'B-1377Â  New Ashok Nagar', 'AUVTM0322N', 1318838489, 1321620722, 1),
(78, '217', 'rajiv@profitbyoutsourcing.com', 'rajiv@profitbyoutsourcing.com', 'e10adc3949ba59abbe56e057f20f883e', 'Rajiv', '', 'Kumar', '2008-12-24', 'male', '', '9555217750', '', '707', 'rajiv.ons', 'active', '2011-04-10', '2005-11-10', 'Raj Nandan Singh', 8, 4, '8-I, Pkt-4, Mayur vihar ph-3', 'ARCPK9308C', 1318838489, 1321620722, 1),
(79, '6', 'rakesh@profitbysearch.com', 'rakesh@profitbysearch.com', 'e10adc3949ba59abbe56e057f20f883e', 'Rakesh', 'Kumar', 'Bijewar', '2010-01-25', 'male', '', '9013512232', '', '708', 'pbs.rakesh', 'active', '2010-09-01', '2011-09-27', 'C. L. Bijewar', 26, 1, 'C-2, Iind Floor, Acharya Niketan, Mayur Vihar Phase -1, New Delhi-91', 'AKAPB9525H', 1318838489, 1321620722, 1),
(80, '77', 'raman@profitbysearch.com', 'raman@profitbysearch.com', 'e10adc3949ba59abbe56e057f20f883e', 'Raman', '', 'Taneja', '2011-02-26', 'male', '', '9873203468', '', '709', 'raman.pbs', 'active', '2010-09-02', '0000-00-00', 'Mr. Ashok Taneja', 28, 2, 'A-41, 2nd Floor, Sector-22, Noida(UP)', '', 1318838489, 1321620722, 1),
(81, '30', 'ranjana@profitbysearch.com', 'ranjana@profitbysearch.com', 'e10adc3949ba59abbe56e057f20f883e', 'Ranjana', '', 'Yadav', '2012-03-29', 'female', '', '9811875377', '', '710', 'ranjana.pbs', 'active', '2010-09-03', '0000-00-00', 'Ramnath Yadav', 23, 1, 'R-186, Adarsh Colony, NH-04, Faridabad-121001', 'ADTPY3893P', 1318838489, 1321620722, 1),
(82, '78', 'ravindrajuyal@profitbysearch.com', 'ravindrajuyal@profitbysearch.com', 'e10adc3949ba59abbe56e057f20f883e', 'Ravindra', '', 'Juyal', '1901-05-09', 'male', '', '9899149979', '', '100', 'ravindra.pbs', 'active', '2010-09-04', '0000-00-00', 'Mr Y P Juyal', 44, 13, 'W-89 (Ground Floor),Sec â€“ 12,Noida â€“ 201301', 'AOEPJ2676P', 1318838489, 1321620722, 1),
(83, '80', 'ravinesh@profitbyoutsourcing.com', 'ravinesh@profitbyoutsourcing.com', 'e10adc3949ba59abbe56e057f20f883e', 'Ravinesh', '', 'Raj', '1902-06-10', 'male', 'profile_83.jpg', '9990155011', '', '101', 'ravinesh.ons', 'active', '2010-09-05', '0000-00-00', 'Mr Raja Ram Singh', 9, 4, '', 'AKOPR6392N', 1318838489, 1321620722, 1),
(84, '227', 'richa@revosysit.com', 'richa@revosysit.com', 'e10adc3949ba59abbe56e057f20f883e', 'Richa', '', 'Gaur', '1903-07-12', 'female', '', '', '', '102', 'richa', 'active', '2010-09-06', '0000-00-00', '', 40, 9, '', '', 1318838489, 1321620722, 1),
(85, '21', 'ritesh@profitbysearch.com', 'ritesh@profitbysearch.com', 'e10adc3949ba59abbe56e057f20f883e', 'Ritesh', 'Kumar', 'Gupta', '1904-08-12', 'male', '', '7838045755', '', '103', 'ritesh836', 'active', '2010-09-07', '0000-00-00', 'Mr. Jitnarayan Sha', 34, 11, 'E-222  3 rd Floor New Ashok Nagar  Delhi -110096', '', 1318838489, 1321620722, 1),
(86, '135', 'rohit@profitbyoutsourcing.com', 'rohit@profitbyoutsourcing.com', 'e10adc3949ba59abbe56e057f20f883e', 'Rohit', '', '', '1906-10-15', 'male', '', '9013413734', '', '105', 'rohit.ons', 'active', '2010-09-09', '0000-00-00', '', 14, 6, '', '', 1318838489, 1321620722, 1),
(87, '176', 'sachendra@profitbyoutsourcing.com', 'sachendra@profitbyoutsourcing.com', 'e10adc3949ba59abbe56e057f20f883e', 'Sachendra', '', 'Kumar', '1907-11-16', 'male', '', '9818380640', '', '106', 'sachendra.ons', 'active', '2010-09-10', '0000-00-00', 'Satya Prakash Gupta', 6, 4, 'RZ-510 J Block , OldÂ  RoshanÂ  Pura ,NajafagarhÂ  New delhi', 'BULPK1208E', 1318838489, 1321620722, 1),
(88, '67', 'sandeep@profitbysearch.com', 'sandeep@profitbysearch.com', 'e10adc3949ba59abbe56e057f20f883e', 'Sandeep', '', 'Kumar', '1908-12-17', 'male', '', '9716103836', '', '107', 'sandeep.pbs', 'active', '2010-09-11', '0000-00-00', 'Mr Mahendra Singh', 28, 2, 'RK Public School,Sector 45,Noida', 'BNSPK7784D', 1318838489, 1321620722, 1),
(89, '200', 'sandeep@profitbyoutsourcing.com', 'sandeep@profitbyoutsourcing.com', 'e10adc3949ba59abbe56e057f20f883e', 'Sandeep', 'Kumar', 'Singh', '1910-01-18', 'male', '', '', '', '108', 'sandeep.ons', 'active', '2010-09-12', '0000-00-00', '', 6, 3, '', '', 1318838489, 1321620722, 1),
(90, '58', 'sanjay@profitbyserach.com', 'sanjay@profitbyserach.com', 'e10adc3949ba59abbe56e057f20f883e', 'Sanjay', 'Singh', 'Rathore', '1911-02-19', 'male', '', '8802787174', '', '109', 'sanjay.pbs', 'active', '2009-07-02', '0000-00-00', 'Amar Singh Rathor ', 28, 2, 'C-10/15 Shiv Durga Vihaar Lakkar pur Faridabad 121009', '', 1318838489, 1321620722, 1),
(91, '184', 'sanjeev@profitbyoutsourcing.com', 'sanjeev@profitbyoutsourcing.com', 'e10adc3949ba59abbe56e057f20f883e', 'Sanjeev', '', 'Kumar', '1912-03-22', 'male', '', '8800579822', '', '110', 'sanjeev.neswebdesign', 'active', '2009-07-03', '0000-00-00', 'Mr.Chandra  Pal  Singh', 6, 4, '192-A,Block E,Sector-2,Kamna,Vaishali ,Ghaziabad                              ', 'BOYPK7033L', 1318838489, 1321620722, 1),
(92, '131', 'sanjiv@profitbyoutsourcing.com', 'sanjiv@profitbyoutsourcing.com', 'e10adc3949ba59abbe56e057f20f883e', 'Sanjiv', '', 'Kumar', '1913-04-23', 'male', '', '8010480660', '', '111', 'sanjiv.ons', 'active', '2009-07-04', '0000-00-00', '', 9, 3, '', '', 1318838489, 1321620722, 1),
(93, '228', 'saurabh@profitbysearch.com', 'saurabh@profitbysearch.com', 'e10adc3949ba59abbe56e057f20f883e', 'Saurabh', '', 'Kalra', '1914-05-25', 'male', '', '7838578168, 991', '', '400', 'saurabh', 'active', '2009-07-05', '0000-00-00', 'Ashok Kumar Kalra', 34, 2, 'House no. d-196 , sec 55, NoidaÂ Â Â  ', 'BQZPK3275K', 1318838489, 1321620722, 1),
(94, '108', 'shailendra@profitbyoutsourcing.com', 'shailendra@profitbyoutsourcing.com', 'e10adc3949ba59abbe56e057f20f883e', 'Shailendra', 'Kumar', 'Singh', '1915-06-26', 'male', '', '', '', '401', 'shailendra.ons', 'active', '2009-07-06', '0000-00-00', '', 6, 4, '', '', 1318838489, 1321620722, 1),
(95, '151', 'shailesh@profitbyoutsourcing.com', 'shailesh@profitbyoutsourcing.com', 'e10adc3949ba59abbe56e057f20f883e', 'Shailesh', '', 'Thapa', '1916-07-27', 'male', '', '9212053149', '', '402', 'shailesh.ons', 'active', '2009-07-07', '0000-00-00', 'Mr Kamlesh Thapa', 6, 4, 'A-388,sec-17  Gurgaon', 'AIXPT4932B', 1318838489, 1321620722, 1),
(96, '123', 'shilpa@profitbysearch.com', 'shilpa@profitbysearch.com', 'e10adc3949ba59abbe56e057f20f883e', 'Shilpa', '', 'Arora', '1917-08-28', 'female', '', '9999968523', '', '403', 'shilpa.pbs', 'active', '2009-07-08', '0000-00-00', 'Mr. Vijay Kumar', 24, 10, '125 B Gopal Nagar Gurgaon', 'CFHPS5676E', 1318838489, 1321620722, 1),
(97, '210', 'shubham@revosysit.com', 'shubham@revosysit.com', 'e10adc3949ba59abbe56e057f20f883e', 'Shubham', '', 'Arora', '1918-09-29', 'male', '', '', '', '404', 'shubham', 'active', '2009-07-09', '0000-00-00', '', 40, 9, '', '', 1318838489, 1321620722, 1),
(98, '94', 'sonal@profitbysearch.com', 'sonal@profitbysearch.com', 'e10adc3949ba59abbe56e057f20f883e', 'Sonal', '', 'Singh', '1919-10-31', 'male', '', '7838907337', '', '405', 'sonal.pbs', 'active', '2009-07-10', '0000-00-00', 'Vidya Nand Singh', 41, 8, 'B-36,sector-31 ,Noida (u.p)', '', 1318838489, 1321620722, 1),
(99, '182', 'sonu@profitbyoutsourcing.com', 'sonu@profitbyoutsourcing.com', 'e10adc3949ba59abbe56e057f20f883e', 'Sonu', '', 'Gupta', '1920-12-01', 'male', '', '9335601646', '', '406', 'sonu.ons', 'active', '2009-07-11', '0000-00-00', 'Sri Harinam Gupta', 7, 4, 'B-210, Sector 20,Noida 201 301,Uttar Pradesh, India.', '', 1318838489, 1321620722, 1),
(100, '162', 'suhel@profitbyoutsourcing.com', 'suhel@profitbyoutsourcing.com', 'e10adc3949ba59abbe56e057f20f883e', 'Suhel', '', 'Sadat', '1922-01-02', 'male', '', '9015076581', '', '407', 'suhel.ons', 'active', '2009-07-12', '0000-00-00', 'Shafiq Ahmed', 7, 5, 'B-338, Sangam Path, New Ashok Nagar, Delhi', 'DDQPS9247R', 1318838490, 1321620722, 1),
(101, '119', 'sunilg@profitbysearch.com', 'sunilg@profitbysearch.com', 'e10adc3949ba59abbe56e057f20f883e', 'Sunil', 'Kumar', 'Gupta', '1923-02-03', 'male', '', '9910439400', '', '408', 'sunil', 'active', '2009-07-13', '0000-00-00', 'RAMKRAPAL GUPTA', 43, 8, 'B779, New Ashok Nagar - New Delhi 96', 'ATAPG5007A', 1318838490, 1321620722, 1),
(102, '98', 'sweety@profitbysearch.com', 'sweety@profitbysearch.com', 'e10adc3949ba59abbe56e057f20f883e', 'Sweety', '', 'Gupta', '1924-03-06', 'female', '', '9818992264', '', '409', 'sweety.ons', 'active', '2009-07-14', '0000-00-00', '', 14, 6, '', '', 1318838490, 1321620722, 1),
(103, '25', 'tarun@profitbyoutsourcing.com', 'tarun@profitbyoutsourcing.com', 'e10adc3949ba59abbe56e057f20f883e', 'Tarkeshwar', 'Nath', 'Pandeya', '1925-04-07', 'male', '', '9958829967', '', '410', 'tnp.tarun', 'active', '2009-07-15', '0000-00-00', 'Braj Kishore Pandeya', 45, 14, 'F-93, Room No. - 27, Fourth Floor, Katwaria Sarai, New Delhi-16', 'BKKPP8792H', 1318838490, 1321620722, 1),
(104, '169', 'tarun@profitbyoutsourcing.com', 'tarun@profitbyoutsourcing.com', 'e10adc3949ba59abbe56e057f20f883e', 'Tarun', '', 'Malhotra', '1926-05-09', 'male', '', '9313050014', '', '411', 'tarun.ons', 'active', '2009-07-16', '0000-00-00', 'Mr. B.K.Malhotra', 8, 4, 'V-65 ground floor sector-12 noida', 'APLPM1557J', 1318838490, 1321620722, 1),
(105, '68', 'uma@profitbyoutsourcing.com', 'uma@profitbyoutsourcing.com', 'e10adc3949ba59abbe56e057f20f883e', 'Uma', '', 'Vashishth', '1927-06-10', 'female', '', '9999227284', '', '412', 'uma.ons', 'active', '2000-11-02', '0000-00-00', '', 15, 6, '', '', 1318838490, 1321620722, 1),
(106, '235', 'umesh@profitbysearch.com', 'umesh@profitbysearch.com', 'e10adc3949ba59abbe56e057f20f883e', 'Umesh', '', 'Kumar', '1928-07-11', 'male', '', '', '', '413', 'umesh.pbs', 'active', '2000-11-03', '0000-00-00', '', 28, 2, '', '', 1318838490, 1321620722, 1),
(107, '216', 'vijay@profitbysearch.com', 'vijay@profitbysearch.com', 'e10adc3949ba59abbe56e057f20f883e', 'Vijay', '', 'Kumar', '1929-08-12', 'male', '', '9911656509', '', '414', 'vijay.pbs', 'active', '2000-11-04', '0000-00-00', '', 33, 2, '', '', 1318838490, 1321620722, 1),
(108, '121', 'vimlendu@profitbysearch.com', 'vimlendu@profitbysearch.com', 'e10adc3949ba59abbe56e057f20f883e', 'Vimlendu', '', 'Kumar', '1930-09-13', 'male', '', '7827596206', '', '415', 'vimlendu.pbs', 'active', '2000-11-05', '0000-00-00', '', 43, 8, '', '', 1318838490, 1321620722, 1),
(109, '236', 'vinay@revosysit.com', 'vinay@revosysit.com', 'e10adc3949ba59abbe56e057f20f883e', 'Vinay', '', 'Mishra', '1931-10-15', 'male', '', '9313261905', '', '416', 'vinay', 'active', '2000-11-06', '2011-05-19', 'Surendra Nath Mishra', 37, 9, 'House No :334 Pocket B3,Sector- 6 Rohini Delhi-110085', 'AOLPM0420K', 1318838490, 1321620722, 1),
(110, '237', 'vishalg@profitbyoutsourcing.com', 'vishalg@profitbyoutsourcing.com', 'e10adc3949ba59abbe56e057f20f883e', 'Vishal', '', 'Gupta', '1932-11-15', 'male', '', '', '', '417', 'vishalg.ons', 'active', '2000-11-07', '0000-00-00', '', 4, 7, '', '', 1318838490, 1321620722, 1),
(111, '179', 'vishal@profitbyoutsourcing.com', 'vishal@profitbyoutsourcing.com', 'e10adc3949ba59abbe56e057f20f883e', 'Vishal', '', 'Verma', '1933-12-17', 'male', '', '9811440493', '', '418', 'vishal.ons', 'active', '1999-11-08', '0000-00-00', 'Shri K. A. Verma', 7, 4, 'S-191, First Floor,Â  Pandav Nagar,Â  Delhi-92', 'AFSPV9657D', 1318838490, 1321620722, 1),
(112, '54', 'vivek@profitbysearch.com', 'vivek@profitbysearch.com', 'e10adc3949ba59abbe56e057f20f883e', 'Vivek', '', 'Srivastava', '1935-01-18', 'male', '', '9971202013', '', '419', 'vivek.pbs', 'active', '1999-11-09', '2011-07-13', 'Mr. D.C. Srivastava', 23, 1, '1/8 F.F. Malviya nagar', 'BYPPS2124H', 1318838490, 1321620722, 1),
(113, '9', 'zuhair@neswebdesign.com', 'zuhair@neswebdesign.com', 'e10adc3949ba59abbe56e057f20f883e', 'Zuhair', '', 'Naqvi', '1936-02-19', 'male', '', '9313907340', '', '420', 'Zuhair.neswebdesign ', 'active', '1999-11-10', '0000-00-00', 'Syed Burair Mohd Naqvi', 17, 6, 'S 9/20 1st Floor, Jogabai Extn. Jamia Nagar New Delhi', 'AFNPN0178E', 1318838490, 1321620722, 1),
(114, '', '', '', '', '', '', '', '0000-00-00', '', '', '', '', '', '', 'active', '0000-00-00', '0000-00-00', '', 15, 10, '', '', 1321620722, 1321620723, 1);

-- --------------------------------------------------------

--
-- Table structure for table `user_leave_account`
--

CREATE TABLE IF NOT EXISTS `user_leave_account` (
  `id` int(14) NOT NULL auto_increment,
  `user_id` int(14) NOT NULL,
  `transaction_type` enum('debit','credit') NOT NULL,
  `value` float NOT NULL,
  `narration` text NOT NULL,
  `leave_type_id` int(14) NOT NULL,
  `addedon` bigint(24) NOT NULL,
  `updatedon` bigint(24) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `user_leave_account`
--

INSERT INTO `user_leave_account` (`id`, `user_id`, `transaction_type`, `value`, `narration`, `leave_type_id`, `addedon`, `updatedon`) VALUES
(1, 9, 'credit', 1, 'ssdsd', 2, 1317381473, NULL),
(2, 2, 'credit', 4, 'ddd', 2, 1317395343, NULL),
(3, 2, 'debit', 1, 'testing', 1, 1317736419, NULL),
(4, 2, 'credit', 5, 'fadff d f fdfd s sfd', 1, 1317736454, NULL),
(5, 8, 'credit', 4, 'sdsadas', 5, 1317828087, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_level`
--

CREATE TABLE IF NOT EXISTS `user_level` (
  `id` int(14) NOT NULL auto_increment,
  `identifire` varchar(255) NOT NULL,
  `label` varchar(255) NOT NULL,
  `status` enum('active','inactive') NOT NULL default 'active',
  `addedon` int(24) NOT NULL,
  `updatedon` int(24) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `user_level`
--

INSERT INTO `user_level` (`id`, `identifire`, `label`, `status`, `addedon`, `updatedon`) VALUES
(1, 'employee', 'Employee', 'active', 34234, 1279623199),
(2, 'administrator', 'Administrator', 'active', 435345434, 1273133025),
(3, 'human_resource', 'Human Resource', 'active', 1273133203, 1273133217),
(4, 'project_manager', 'Project Manager', 'active', 432432, 3432432),
(5, 'team_leader', 'Team Leader', 'active', 3453535, 3432423);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
