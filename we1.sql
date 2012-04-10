-- phpMyAdmin SQL Dump
-- version 3.4.3.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 03, 2012 at 03:11 PM
-- Server version: 5.0.77
-- PHP Version: 5.2.17

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `SmithMeats`
--

-- --------------------------------------------------------

--
-- Table structure for table `code_table`
--

CREATE TABLE IF NOT EXISTS `code_table` (
  `id` int(15) NOT NULL,
  `code_name` varchar(100) NOT NULL,
  `code_value` varchar(100) default NULL,
  `row_version` int(14) NOT NULL,
  `row_max_id` int(14) NOT NULL,
  `created_on` bigint(28) NOT NULL,
  `updated_on` bigint(28) NOT NULL,
  `created_by` int(15) NOT NULL,
  `updated_by` int(15) NOT NULL,
  `row_guid` varchar(255) NOT NULL,
  `status` varchar(50) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `code_table`
--

INSERT INTO `code_table` (`id`, `code_name`, `code_value`, `row_version`, `row_max_id`, `created_on`, `updated_on`, `created_by`, `updated_by`, `row_guid`, `status`) VALUES
(-2147483648, '', '', 14, 14, 0, 0, 0, 0, '', ''),
(1, 'transaction_id', '10017', 18, 5, 0, 1333380353, 0, 1, '', '1'),
(2, 'sequence_num', '1', 70, 0, 0, 1333438126, 0, 0, '', ''),
(3, 'tag_num', '10036', 33, 0, 0, 1333438126, 0, 0, '', '');

-- --------------------------------------------------------

--
-- Table structure for table `control_type`
--

CREATE TABLE IF NOT EXISTS `control_type` (
  `id` int(5) NOT NULL auto_increment,
  `name` varchar(100) NOT NULL,
  `value` varchar(100) NOT NULL,
  `status` int(5) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `control_type`
--

INSERT INTO `control_type` (`id`, `name`, `value`, `status`) VALUES
(1, 'Drop down', 'select', 1),
(2, 'Radio Button', 'RadioButton', 1),
(3, 'Check Box', 'CheckBox', 1);

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE IF NOT EXISTS `customer` (
  `id` bigint(10) NOT NULL,
  `org_name` varchar(255) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `state` varchar(255) NOT NULL,
  `zip` varchar(40) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `fax` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `bfirst_name` varchar(255) NOT NULL,
  `blast_name` varchar(255) NOT NULL,
  `baddress` varchar(255) NOT NULL,
  `bcity` varchar(255) NOT NULL,
  `bstate` varchar(100) NOT NULL,
  `bzip` varchar(15) NOT NULL,
  `created_on` bigint(28) NOT NULL,
  `updated_on` bigint(28) NOT NULL,
  `created_by` int(15) NOT NULL,
  `updated_by` int(15) NOT NULL,
  `row_guid` varchar(255) NOT NULL,
  `row_version` int(14) NOT NULL,
  `row_max_id` int(14) NOT NULL,
  `status` int(1) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`id`, `org_name`, `first_name`, `last_name`, `address`, `city`, `state`, `zip`, `phone`, `fax`, `email`, `bfirst_name`, `blast_name`, `baddress`, `bcity`, `bstate`, `bzip`, `created_on`, `updated_on`, `created_by`, `updated_by`, `row_guid`, `row_version`, `row_max_id`, `status`) VALUES
(-2147483648, 'infopro', 'vikash', 'rajput', 'c-4', 'noida', 'UP', '201307', '', 0, 'test@fg.kl', '', '', '', '', '', '', 0, 0, 0, 0, '', 14, 14, 0),
(4, 'infopro', 'vikash', 'rajput', 'c-4', 'noida', 'up', '201307', '9540774955', 2147483647, 'agh@gh.kl', 'vikash', 'rajput', 'c-4', 'noida', 'up', '201307', 1331540045, 1331819173, 1, 1, 'c210d8cc-896b-593f-907f-2352fc3ce46e', 6, 0, 1),
(5, 'a', 'first', 'last', 'address', 'city', 'stater', 'zip', '988', 9100, 'vvikash.368@gmail.com', 'first', 'last', 'address', 'city', 'stater', 'zip', 1331540779, 1331819173, 1, 1, '049740c2-9a5b-5838-8b02-0bf62df45812', 2, 0, 1),
(6, 'a', 'vvikash', 'a', 'a', 'a', 'a', 'a', '1', 1, 'aas@gmail.com', 'vvikash', 'a', 'a', 'a', 'a', 'a', 1331545106, 1333352442, 1, 1, '078d557b-9e12-5d5a-aaf2-a0633d8a74f7', 11, 0, 1),
(7, 'a', 'a', 'a', 'a', 'a', 'a', 'a', '1', 1, 'fg@rth.kl', 'a', 'a', 'a', 'a', 'a', 'a', 1331545119, 1332478412, 1, 1, '51529f37-3f4f-547d-8c54-e8cc42d237be', 12, 0, 1),
(8, 'a', 'a', 'a', 'a', 'a', 'a', 'a', '1', 1, 'asdad@hj.kl', 'a', 'a', 'a', 'a', 'a', 'a', 1331545138, 1331819171, 1, 1, '628bb870-3086-5c38-ad23-5028ca515fe3', 8, 0, 1),
(9, 'a', 'a', 'a', 'a', 'a', 'a', 'a', '123', 1, 'vikash368@gmail.com', 'aaaaa', 'vikash', 'sahfdl', 'hljh', 'l', 'jlk', 1331545166, 1331810390, 1, 1, 'e4c3b724-1814-53f3-8900-64f054053723', 13, 0, 1),
(10, 'a', 'a', 'a', 'a', 'a', 'a', 'a', '1', 1, 'awaa@pla.nl', 'a', 'a', 'a', 'a', 'a', 'a', 1331545178, 1331819172, 1, 1, 'f70578d4-d4c6-5ef9-a515-79fc68f1fc74', 4, 0, 1),
(11, 'a', 'a', 'a', 'a', 'a', 'a', 'a', '1', 1, 'as@ee.k', 'a', 'a', 'a', 'a', 'a', 'a', 1331545190, 0, 1, 0, '7ccba776-ef37-5621-9e63-f66374490580', 0, 0, 1),
(12, 'a', 'a', 'a', 'a', 'a', 'a', 'a', '1', 1, 'vvikash368@gmail.com', 'a', 'a', 'a', 'a', 'a', 'a', 1331545202, 1331803695, 1, 1, '3455b778-5401-546a-958a-bdcd6f560567', 2, 0, 1),
(13, 'asdsad', 'a', 'a', 'a', 'a', 'a', 'a', '1', 1, 'vikash38@gmail.com', 'a', 'a', 'a', 'a', 'a', 'a', 1332748641, 0, 1, 0, '914dee6d-f9f2-5b0a-b94c-a499a2d6cc23', 0, 0, 1),
(14, 'a', 'a', 'a', 'a', 'a', 'a', 'a', '9540774955', 2147483647, 'vvvikas@gmail.com', 'a', 'a', 'a', 'a', 'a', 'a', 1333352379, 0, 1, 0, 'c06cbf2d-897b-597c-a54e-97352d6e7d50', 0, 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `dbconfiguration`
--

CREATE TABLE IF NOT EXISTS `dbconfiguration` (
  `dbcnf_id` int(10) NOT NULL,
  `config_id` int(10) NOT NULL,
  `db_server_name` varchar(256) NOT NULL,
  `db_server_port` int(10) NOT NULL,
  `db_name` varchar(25) NOT NULL,
  `db_user` varchar(25) NOT NULL,
  `db_password` varchar(25) NOT NULL,
  `db_trans_type` varchar(10) NOT NULL,
  `status` int(1) NOT NULL,
  `created_by` int(10) NOT NULL,
  `created_on` bigint(28) default NULL,
  `updated_by` varchar(15) NOT NULL,
  `updated_on` bigint(28) NOT NULL,
  `row_guid` varchar(256) NOT NULL,
  `row_max_id` int(14) NOT NULL,
  `row_version` int(14) NOT NULL,
  PRIMARY KEY  (`dbcnf_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

--
-- Dumping data for table `dbconfiguration`
--

INSERT INTO `dbconfiguration` (`dbcnf_id`, `config_id`, `db_server_name`, `db_server_port`, `db_name`, `db_user`, `db_password`, `db_trans_type`, `status`, `created_by`, `created_on`, `updated_by`, `updated_on`, `row_guid`, `row_max_id`, `row_version`) VALUES
(-2147483648, 30, 'sdfsdfsd', 23423, 'werwerwe', 'werwerwe', 'rwerwer', '1', 0, 1, 2012, '', 0, '0ae36810-fef1-5676-91a2-324ac2db505e', 1, 1),
(1, 0, 'sdafsadfsfasd', 324324, 'dsfsdfas', 'dfasdf', 'asdfasdfasd', '1', 0, 1, 1331791903, '1', 1333435142, 'a3da8272-2a08-5468-b070-e623acd75bc7', 0, 1);

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
(8, 'Forgot Password Email', 'ONSIS: Forgotten Your Password?', 'forgot_password_email', '<p>\r\n	Dear __FIRSTNAME__,</p>\r\n<p>\r\n	&nbsp;</p>\r\n<p>\r\n	Your password for your ONSIS account has now been reset.</p>\r\n<p>\r\n	Your new password is __PASSWORD__</p>\r\n<p>\r\n	&nbsp;</p>\r\n<p>\r\n	From,</p>\r\n<p>\r\n	ONSIS Team.</p>\r\n<p>\r\n	__SITE_URL__</p>\r\n<p>\r\n	&nbsp;</p>'),
(9, 'Contact Us', 'Gap Daemon User Feedback/Enquiry', 'contactus_email', '<p>Hi,</p>\r\n<p>One of our users has sent in the following :</p>\r\n<p>Name :&nbsp;__NAME__</p>\r\n<p>Email :&nbsp;__EMAIL__</p>\r\n<p>Enquiry :&nbsp;__ENQUIRY__</p>\r\n<p>&nbsp;</p>\r\n<p>&nbsp;</p>'),
(11, 'Forgot Username Email', 'Gap Daemon: Forgotten Your Username?', 'forgot_username_email', '<p>\r\n	Dear __FIRSTNAME__,</p>\r\n<p>\r\n	Your username is __USERNAME__</p>\r\n<p>\r\n	&nbsp;</p>\r\n<p>\r\n	From,</p>\r\n<p>\r\n	The Gap Daemon Team.</p>\r\n<p>\r\n	__SITE_URL__</p>\r\n<p>\r\n	&nbsp;</p>\r\n<p>\r\n	&nbsp;</p>'),
(17, 'Request Notification Template', 'You have got a request notification', 'request_notification_email', '<p>Hello,</p>\r\n<p>You have got the below request.</p>\r\n<p>Request : __REQUEST__</p>\r\n<br/>\r\n<p>Requested By : __REQUESTER_NAME__</p><p>Requester Email : __REQUESTER_EMAIL__</p>\r\n<p>Requester Emp. Code : __REQUESTER_EMP_CODE__</p>\r\n<br/>\r\n<p>From</p>\r\n<p>ONSIS Admin</p>'),
(23, 'Request Complete NotificationTemplate', 'Yous request has been resolved', 'request_complete_notification_email', '<p>Hello __REQUESTER_NAME__,</p>\r\n\r\n<p>Your request #__REQUEST_NO__ has been resolved.</p>\r\n<p>Remarks : __REMARKS__</p>\r\n	\r\n<p>From</p>\r\n<p>ONSIS Admin</p>');

-- --------------------------------------------------------

--
-- Table structure for table `error_log`
--

CREATE TABLE IF NOT EXISTS `error_log` (
  `log_id` int(10) NOT NULL auto_increment COMMENT 'primary_ker',
  `msg_id` int(10) NOT NULL COMMENT 'reference_to_message',
  `machine_name` varchar(256) NOT NULL,
  `app_name` varchar(256) NOT NULL,
  `process_name` varchar(256) NOT NULL,
  `module_name` varchar(256) NOT NULL,
  `method_name` varchar(256) NOT NULL,
  `log_message` varchar(4096) NOT NULL,
  `created_on` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  `created_by` int(10) NOT NULL,
  `updated_on` timestamp NOT NULL default '0000-00-00 00:00:00',
  `updated_by` int(10) NOT NULL,
  `row_guid` varchar(256) NOT NULL,
  PRIMARY KEY  (`log_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `error_log`
--

INSERT INTO `error_log` (`log_id`, `msg_id`, `machine_name`, `app_name`, `process_name`, `module_name`, `method_name`, `log_message`, `created_on`, `created_by`, `updated_on`, `updated_by`, `row_guid`) VALUES
(1, 3, 'ere', 'dfg', 'sdf', 'sdf', 'sdf', 'asf', '2012-03-22 07:07:46', 3, '0000-00-00 00:00:00', 343, '3434');

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
-- Table structure for table `group`
--

CREATE TABLE IF NOT EXISTS `group` (
  `id` int(11) NOT NULL auto_increment,
  `title` varchar(255) NOT NULL,
  `addedon` bigint(24) NOT NULL,
  `updatedon` bigint(24) default NULL,
  `created_by` int(15) NOT NULL,
  `updated_by` int(15) NOT NULL,
  `row_guid` varchar(255) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=57 ;

--
-- Dumping data for table `group`
--

INSERT INTO `group` (`id`, `title`, `addedon`, `updatedon`, `created_by`, `updated_by`, `row_guid`) VALUES
(1, 'Group1', 1317133683, 1321541399, 0, 0, ''),
(53, 'Group2', 1328675283, NULL, 1, 0, 'e9a27b17-82c9-5103-a8d3-23ede3ef815f'),
(54, 'Group3', 1328675291, NULL, 1, 0, '0b7e9514-2e65-52c1-8296-fb2800c0686e'),
(55, 'Group4', 1328675297, NULL, 1, 0, '4f3cf4f2-06c6-5200-9e80-5ac5c4aa938a');

-- --------------------------------------------------------

--
-- Table structure for table `location`
--

CREATE TABLE IF NOT EXISTS `location` (
  `id` int(50) NOT NULL,
  `title` varchar(50) NOT NULL,
  `description` varchar(255) NOT NULL,
  `weight` varchar(50) NOT NULL,
  `created_on` bigint(28) NOT NULL,
  `updated_on` bigint(28) NOT NULL,
  `created_by` int(15) NOT NULL,
  `updated_by` int(15) NOT NULL,
  `row_guid` varchar(255) NOT NULL,
  `row_version` int(14) NOT NULL,
  `row_max_id` int(14) NOT NULL,
  `status` int(1) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `location`
--

INSERT INTO `location` (`id`, `title`, `description`, `weight`, `created_on`, `updated_on`, `created_by`, `updated_by`, `row_guid`, `row_version`, `row_max_id`, `status`) VALUES
(-2147483648, '', '', '250000', 1318838489, 1318838489, 0, 0, '', 30, 30, 1),
(26, 'Mumbai', 'Metro city', '5000000', 1331548822, 1331616579, 1, 1, '973dbeb6-7c84-5587-9ae4-a174c0d92abf', 11, 0, 1),
(27, 'Chennai', 'Metro city', '2000000', 1331548875, 1331621364, 1, 1, 'ef946ced-b6d0-50d9-b0c5-5e1f41e1a9fa', 31, 0, 1),
(28, 'Hyderabad', 'This is Metro city', '450000', 1331550584, 1331621359, 1, 1, '91ff42d9-e2d9-572b-8232-dc4f760d2881', 26, 0, 1),
(29, 'London', 'foreign location', '340000', 1331550619, 1332506886, 1, 1, 'c3659c15-62c8-50cf-860d-ab42d91bb397', 18, 0, 1),
(30, 'Chandigarh', 'Chandigarh city', '234444', 1331561313, 1333443396, 1, 1, 'dfb1676a-d686-5823-a08f-ead7a5310590', 23, 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `logentries`
--

CREATE TABLE IF NOT EXISTS `logentries` (
  `entryID` int(11) NOT NULL auto_increment,
  `logType` varchar(50) NOT NULL default 'default',
  `projectName` varchar(20) NOT NULL default 'not available',
  `environment` varchar(15) NOT NULL default 'not available',
  `priority` int(11) NOT NULL,
  `errorNumber` int(11) default NULL,
  `message` text NOT NULL,
  `file` varchar(255) default NULL,
  `line` int(11) default NULL,
  `context` longtext,
  `stacktrace` longtext,
  `timestamp` varchar(30) NOT NULL,
  `priorityName` varchar(15) NOT NULL,
  PRIMARY KEY  (`entryID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `log_2012_03`
--

CREATE TABLE IF NOT EXISTS `log_2012_03` (
  `id` int(14) NOT NULL auto_increment,
  `request_uri` tinytext NOT NULL,
  `params` text NOT NULL,
  `remote_addr` varchar(255) NOT NULL,
  `user_id` int(11) NOT NULL,
  `addedon` datetime NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `log_2012_04`
--

CREATE TABLE IF NOT EXISTS `log_2012_04` (
  `id` int(14) NOT NULL auto_increment,
  `request_uri` tinytext NOT NULL,
  `params` text NOT NULL,
  `remote_addr` varchar(255) NOT NULL,
  `user_id` int(11) NOT NULL,
  `addedon` datetime NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `message_category`
--

CREATE TABLE IF NOT EXISTS `message_category` (
  `message_category_id` int(11) NOT NULL auto_increment,
  `message_category_name` varchar(256) NOT NULL,
  `created_by` int(15) NOT NULL,
  `created_on` datetime NOT NULL,
  `updated_by` int(15) NOT NULL,
  `updated_on` datetime NOT NULL,
  `row_guid` varchar(256) NOT NULL,
  PRIMARY KEY  (`message_category_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `message_category`
--

INSERT INTO `message_category` (`message_category_id`, `message_category_name`, `created_by`, `created_on`, `updated_by`, `updated_on`, `row_guid`) VALUES
(5, 'category1', 1, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', '70643ac8-a3ed-5fed-91db-91596154b2c5'),
(6, 'category12', 1, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', '8d6b386a-d526-5be0-871c-4f3cc6b3d634'),
(7, 'category 3', 1, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 'b58a45bb-22e0-5f18-8e96-e2ab08d47eea'),
(8, 'category 4', 1, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 'b0563a10-5d6c-57e3-9c6e-85520a151317');

-- --------------------------------------------------------

--
-- Table structure for table `message_sevirity`
--

CREATE TABLE IF NOT EXISTS `message_sevirity` (
  `message_sevirity_id` int(15) NOT NULL auto_increment,
  `message_sevirity_name` varchar(256) NOT NULL,
  `created_by` int(15) NOT NULL,
  `created_on` datetime NOT NULL,
  `updated_by` int(15) NOT NULL,
  `updated_on` datetime NOT NULL,
  `row_guid` varchar(256) NOT NULL,
  PRIMARY KEY  (`message_sevirity_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `message_sevirity`
--

INSERT INTO `message_sevirity` (`message_sevirity_id`, `message_sevirity_name`, `created_by`, `created_on`, `updated_by`, `updated_on`, `row_guid`) VALUES
(2, 'sevirity2', 1, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', '8355bffe-aa04-56a5-926e-392e84eee545'),
(3, 'Sevirity1', 1, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', '898e0bbf-523c-51e6-89b6-b7c99e1802d7'),
(4, 'Sevirity3', 1, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', '665e1bfe-12f7-5e42-a9d0-69afc1fe8b1c'),
(5, 'Sevirity4', 1, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 'b00f892d-41b9-57c0-8088-ea06b7ce0286');

-- --------------------------------------------------------

--
-- Table structure for table `message_type`
--

CREATE TABLE IF NOT EXISTS `message_type` (
  `message_type_id` int(10) NOT NULL auto_increment,
  `message_type_name` varchar(256) NOT NULL,
  `created_by` int(15) NOT NULL,
  `created_on` datetime NOT NULL,
  `updated_by` int(15) NOT NULL,
  `updated_on` datetime NOT NULL,
  `row_guid` varchar(256) NOT NULL,
  PRIMARY KEY  (`message_type_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `message_type`
--

INSERT INTO `message_type` (`message_type_id`, `message_type_name`, `created_by`, `created_on`, `updated_by`, `updated_on`, `row_guid`) VALUES
(3, 'type2', 1, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', '9a3debfa-f169-5f21-a156-05b445bbfc9b'),
(2, 'type1', 1, '0000-00-00 00:00:00', 1, '0000-00-00 00:00:00', 'ab230fb3-e2a4-5b78-a601-cce6934dac48'),
(4, 'type3', 1, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 'dc7e54e3-e0bf-51cd-887d-b4193ffc364c'),
(5, 'type4', 1, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 'ff52a850-e18e-5ddc-a891-2f1981a92583'),
(6, 'type5', 1, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 'e1e8d831-2d3c-57aa-97a5-dea3d8505d52');

-- --------------------------------------------------------

--
-- Table structure for table `organization`
--

CREATE TABLE IF NOT EXISTS `organization` (
  `id` int(11) NOT NULL,
  `organization_name` varchar(100) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `address1` text NOT NULL,
  `address2` text NOT NULL,
  `city` varchar(50) NOT NULL,
  `state` varchar(50) NOT NULL,
  `zip` varchar(30) NOT NULL,
  `phone` varchar(30) NOT NULL,
  `fax` varchar(30) NOT NULL,
  `email` varchar(80) NOT NULL,
  `created_on` bigint(28) NOT NULL,
  `updated_on` bigint(28) NOT NULL,
  `created_by` int(15) NOT NULL,
  `updated_by` int(15) NOT NULL,
  `row_guid` varchar(255) NOT NULL,
  `row_version` int(14) NOT NULL,
  `row_max_id` int(14) NOT NULL,
  `status` int(1) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `organization`
--

INSERT INTO `organization` (`id`, `organization_name`, `first_name`, `last_name`, `address1`, `address2`, `city`, `state`, `zip`, `phone`, `fax`, `email`, `created_on`, `updated_on`, `created_by`, `updated_by`, `row_guid`, `row_version`, `row_max_id`, `status`) VALUES
(-2147483648, 'infopro', 'a', 'a', 'a', 'a', 'aa', 'a', 'a', 'a', '', '', 0, 0, 0, 0, '', 0, 0, 0),
(1, 'infopro Corporatio', 'vikash', 'rajput', 'addresss1', 'address2', 'Noida', 'Uttar Pradesh', '201307', '9540774955', '99', 'vikash368@gmail.com', 0, 1331799257, 0, 1, '', 3, 0, 1),
(29, 'test', 'test', 'test', 'j', 'j', 'j', 'j', 'jj', 'j', 'j', 'vikash@hh.kk', 1331734860, 1331802247, 1, 1, 'dba2677a-bbe5-5aa0-8034-3c44b41fbb88', 8, 0, 1),
(30, 'kh', 'kjh', 'jk', 'hjk', 'h', 'jkh', 'jkh', 'kj', 'hk', 'j', 'sdfsdf@gmail.com', 1331734993, 1331799531, 1, 1, 'c58c95f8-6525-529e-b224-436e7aed8cb5', 3, 0, 1),
(31, 'k', 'h', 'kjh', 'kjhjk', 'h', 'jkh', 'jk', 'hkjh', 'kj', 'jkhk', 'jkhjk', 1331735079, 1331798301, 1, 1, '2ff74392-5870-55e8-b66e-d6687d900e78', 1, 0, 1),
(32, 'Google Corporation', 'Google', 'Corporation', 'Illuionis', 'CA', 'CA', 'CA', '11005', '9866', '7282', 'info@goo', 1331793947, 1331811031, 1, 1, '9c77b8eb-45ba-5691-8fe5-824d21582150', 5, 0, 1),
(33, 'Google Corporatio', 'Google', 'Corporation', 'Illuionis', 'CA', 'CA', 'CA', '11005', '9866', '7282', 'info@google.com', 1331793959, 1331802253, 1, 1, '4cc72163-0211-57c7-b271-60b27d286734', 1, 0, 1),
(34, 'u', 'u', 'u', 'u', 'u', 'uu', 'u', 'y', 'uujj', 'u', 'u', 1331798342, 1331798362, 1, 1, 'e5af83b9-88e0-5104-be7c-233aef21a070', 2, 0, 1),
(35, 'sqs', 'k', 'hk', 'h', 'h', 'kjh', 'kj', 'hjk', 'h', 'kjh', 'k', 1331799523, 0, 1, 0, 'a0b9ce10-9e04-540d-8c9f-9a5d654e4685', 0, 0, 1),
(36, 'test', 'test', 'test', 'j', 'j', 'j', 'j', 'jj', 'j', 'j', 'vikash@hh.kk', 1331802850, 0, 1, 0, '516350b2-6657-5ca6-b061-ec5cb85e521b', 0, 0, 1),
(38, 'new new', 'i', 'i', 'ii', 'i', 'i', 'ii', 'i', 'i', 'i', 'vikash368@gmail.com', 1332483465, 0, 1, 0, '77267e6c-e21b-5945-90e4-1b27f288dc23', 0, 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE IF NOT EXISTS `product` (
  `id` int(50) NOT NULL,
  `case_format` varchar(50) NOT NULL,
  `label_case` varchar(50) NOT NULL,
  `product_identifier` varchar(50) NOT NULL,
  `pack_location` varchar(50) NOT NULL,
  `part_number` varchar(50) NOT NULL,
  `sell_by_days` varchar(50) NOT NULL,
  `price_lb` varchar(50) NOT NULL,
  `pallet_id` varchar(50) NOT NULL,
  `des_line_1` varchar(100) NOT NULL,
  `des_line_2` varchar(100) NOT NULL,
  `des_line_3` varchar(100) NOT NULL,
  `des_line_4` varchar(100) NOT NULL,
  `lower_weight` varchar(50) NOT NULL,
  `fixed_weight` varchar(50) NOT NULL,
  `heigh_weight` varchar(50) NOT NULL,
  `tare_weight` varchar(50) NOT NULL,
  `required_application` varchar(200) NOT NULL,
  `created_on` bigint(28) NOT NULL,
  `updated_on` bigint(28) NOT NULL,
  `created_by` int(15) NOT NULL,
  `updated_by` int(15) NOT NULL,
  `row_guid` varchar(255) NOT NULL,
  `row_version` int(14) NOT NULL,
  `row_max_id` int(14) NOT NULL,
  `status` int(1) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`id`, `case_format`, `label_case`, `product_identifier`, `pack_location`, `part_number`, `sell_by_days`, `price_lb`, `pallet_id`, `des_line_1`, `des_line_2`, `des_line_3`, `des_line_4`, `lower_weight`, `fixed_weight`, `heigh_weight`, `tare_weight`, `required_application`, `created_on`, `updated_on`, `created_by`, `updated_by`, `row_guid`, `row_version`, `row_max_id`, `status`) VALUES
(-2147483648, 'cas_format', 'Test', 'P', 'Loc', '100', '12', '100', '14', 'Test1', 'Test2', 'Test3', 'Test4', '12', '781', '18', '18', '3', 10090, 10098, 10098, 1868, 'hhgg', 24, 24, 1),
(20, 'BlackOutBug', 'asdfasdf', 'afsadf', '26,27,29', 'afasdfasdf', 'aasdfasd', 'aasdfasd', 'fasdfasd', '', '', '', '', 'asas', 'a', 'asdfasdfsa', 'adfasdfsdf', 'Print Random Wts.within limits', 1331634653, 1332748700, 1, 1, '4abf1496-19ba-5921-8075-2d36f947dc83', 29, 0, 1),
(22, 'pork', 'a', 'a', '26,27,28,29', 'a', 'a', 'a', 'a', '', '', '', '', 'a', 'a', 'a', 'a', 'Print all Random Weight', 1331635244, 1332748699, 1, 1, '184329ca-ac31-53b9-a4e5-717120264ee2', 25, 0, 1),
(24, 'Packed+Julian', 'asdfdsaf', 'asdfasdf', '27,28', 'asdf', 'asdf', '', '', '', '', '', '', 'asdf', 'asdfasdf', 'asdf', 'sadfasdf', 'Print Random Wts.within limits', 1331635455, 1332748702, 1, 1, '32100747-ee17-5946-99a6-4b7a78e89b52', 12, 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `raw_product`
--

CREATE TABLE IF NOT EXISTS `raw_product` (
  `id` bigint(10) NOT NULL,
  `sequence_no` int(15) default NULL,
  `type` varchar(200) default NULL,
  `breed` varchar(200) default NULL,
  `color` varchar(100) default NULL,
  `created_on` bigint(28) NOT NULL,
  `updated_on` bigint(28) NOT NULL,
  `created_by` int(15) NOT NULL,
  `updated_by` int(15) NOT NULL,
  `supplier_id` int(10) NOT NULL,
  `description` text,
  `tag_no` varchar(10) default NULL,
  `transaction_id` int(10) default NULL,
  `incoming_date` date default NULL,
  `knocked_date` date default NULL,
  `weighing_date` date default NULL,
  `auction_tag` varchar(100) default NULL,
  `ear_tag` varchar(100) default NULL,
  `trich` varchar(100) default NULL,
  `back_tag` varchar(100) default NULL,
  `defects` varchar(200) default NULL,
  `grade` varchar(100) default NULL,
  `weight` varchar(50) default NULL,
  `status` varchar(50) NOT NULL,
  `condumn_sub_status` varchar(50) default NULL,
  `process_status` varchar(100) NOT NULL default ' ',
  `status_on` varchar(50) default NULL,
  `row_guid` varchar(255) NOT NULL,
  `row_version` int(14) NOT NULL,
  `row_max_id` int(14) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `raw_product`
--

INSERT INTO `raw_product` (`id`, `sequence_no`, `type`, `breed`, `color`, `created_on`, `updated_on`, `created_by`, `updated_by`, `supplier_id`, `description`, `tag_no`, `transaction_id`, `incoming_date`, `knocked_date`, `weighing_date`, `auction_tag`, `ear_tag`, `trich`, `back_tag`, `defects`, `grade`, `weight`, `status`, `condumn_sub_status`, `process_status`, `status_on`, `row_guid`, `row_version`, `row_max_id`) VALUES
(-2147483648, 0, '', '', '', 0, 0, 0, 0, 0, '', '', 0, '0000-00-00', '0000-00-00', '0000-00-00', '', '', '', '', '', '', '', '', '', ' ', '', '', 1732, 11706),
(1234, 1, 'type1', 'Bull', 'color 1', 1332833437, 1333371792, 1, 1, 16, 'This is test', '12', 232323, '2012-03-27', '2012-03-27', '2012-03-26', '45676', '231323434', 'hello ', 'hello', 'no', 'A', '2222', '1', '7,1,2,3,5', 'Compliance', '3', '980f4009-1166-5f20-9897-111f06d48766', 214, 1),
(11311, 2, '4', '2', '5', 1333014503, 1333443678, 1, 1, 19, '', '10000', 10005, '2012-03-29', '0000-00-00', '0000-00-00', '343', '34343', 'test', '', 'No', 'B', '6666', 'Weighing', '7,1,2,3', 'BloodStation', '2', 'b49cc70e-985a-532f-aab8-836c633103ba', 40, 0),
(10037, 0, '', '', '', 1332859787, 1333371796, 1, 1, 14, '', '', 0, '2012-03-27', '0000-00-00', '0000-00-00', '21311', '145734', '34443', '', '', '', '45454', '1', '6,4,2,3,5', 'Weighing', '3', 'be0656a0-7cd5-50ca-aa96-5e16c7f75010', 88, 0),
(10040, 0, '', '', '', 1332859925, 1333371795, 1, 1, 19, 'Information', '', 0, '2012-03-27', '0000-00-00', '0000-00-00', '65', '34', '55', '', '', '', '23', '0', '4,1,3,5', ' ', '', '01660fee-16c7-576a-a38b-ed23f7c936a2', 50, 0),
(10042, 0, '', '', '', 1332859925, 1333371797, 1, 1, 19, 'Information', '', 0, '2012-03-27', '0000-00-00', '0000-00-00', '2323', '34344', '343', '', '', '', '23', '1', '', ' ', '', 'd437403b-f077-581f-b9d5-d7bbec6c8f73', 31, 0),
(10043, 0, '', '', '', 1332859925, 1333371791, 1, 1, 19, 'Information', '', 0, '2012-03-27', '0000-00-00', '0000-00-00', '233344', '45454', '34', '', '', '', '678', '1', '', ' ', '', '5a27ff39-9d1a-58f0-98fb-ae90f0f091e4', 22, 0),
(10044, 0, '', '', '', 1332859925, 1333371776, 1, 1, 19, 'Information', '', 0, '2012-03-27', '0000-00-00', '0000-00-00', '45454', '23', '3434', '', '', '', '23', '1', '6,4,1,2,3', ' ', '', '2aaec52c-3853-5a3a-a410-54b28c4babbb', 20, 0),
(10045, 0, '', '', '', 1332859925, 1333371775, 1, 1, 19, 'Information is important', '', 0, '2012-03-27', '0000-00-00', '0000-00-00', '874', '454343', '23', '', '', '', '434', '1', '7,4,1', ' ', '', '3e79871e-bc00-565b-9506-4ad6696749e5', 16, 0),
(10046, 0, '', '', '', 1332859925, 1333371774, 1, 1, 19, 'Information is important', '', 0, '2012-03-27', '0000-00-00', '0000-00-00', '3432', '34343', '3434', '', '', '', '23', '1', '6,4', ' ', '', '784471bd-1a59-5dda-b7bb-29f0f7c12c62', 29, 0),
(10047, 0, '', '', '', 1332859925, 1333371771, 1, 1, 19, 'Information is important', '', 0, '2012-03-27', '0000-00-00', '0000-00-00', '34', '34343', '343', '', '', '', 'ghgh', '1', '6,4', ' ', '', '9702221d-38e4-5591-a122-436532db9e7c', 15, 0),
(10048, 0, '', '', '', 1332859925, 1333371772, 1, 1, 19, 'Information is important', '', 0, '2012-03-27', '0000-00-00', '0000-00-00', '5454', '3', '3434', '', '', '', '454', '1', '4,1', ' ', '', 'aa182d9a-d836-5024-9ec5-ab1cfa962079', 12, 0),
(10049, 0, '', '', '', 1332859925, 1333371773, 1, 1, 19, 'Information is important', '', 0, '2012-03-27', '0000-00-00', '0000-00-00', '3', '3', '434', '', '', '', '34543543', '1', '7,4,1,2,3,5', ' ', '', '26d9f8d6-f9b4-54a8-b6bc-3c86762e4d83', 42, 0),
(10051, 0, '', '', '', 1332859982, 1333025244, 1, 1, 19, 'New Description', '', 0, '2012-03-27', '0000-00-00', '0000-00-00', '3', '34', '34', '', '', '', '534534', '1', '', ' ', '', '274ea966-a878-5ee2-9d6e-add42c768fd5', 24, 0),
(10052, 0, '', '', '', 1332859982, 1333025233, 1, 1, 19, 'New Description', '', 0, '2012-03-27', '0000-00-00', '0000-00-00', '4566', '6767', '456436sd', '', '', '', 'asdf', '1', '', ' ', '', '8b738bc1-6b44-577b-83d5-aec55a55ff12', 18, 0),
(10053, 0, '', '', '', 1332859982, 1333026276, 1, 1, 19, 'New Description', '', 0, '2012-03-27', '0000-00-00', '0000-00-00', '', '', '', '', '', '', '', '1', '', ' ', '', 'b8bc9181-97ac-5a47-8cdd-7c55d2d62aa0', 1, 0),
(10054, 0, '', '', '', 1332859982, 1333026178, 1, 1, 19, 'New Description', '', 0, '2012-03-27', '0000-00-00', '0000-00-00', '', '', '', '', '', '', '34545', '1', '', ' ', '', '846117a6-4992-5807-bbea-2ad2f273a1a8', 11, 0),
(10055, 0, '', '', '', 1332859982, 1333026183, 1, 1, 19, 'New Description', '', 0, '2012-03-27', '0000-00-00', '0000-00-00', '', '', '', '', '', '', '234322', '1', '', ' ', '', '3eb73300-9df7-5534-8519-c5c764a94aa0', 4, 0),
(10056, 0, '', '', '', 1332859982, 1333082207, 1, 1, 19, 'New Description', '', 0, '2012-03-27', '0000-00-00', '0000-00-00', '', '', '', '', '', '', '567', '1', '', ' ', '', '70c7ccbb-bbf6-5523-89f6-2c4b6eff480a', 2, 0),
(10057, 0, '', '', '', 1332859982, 1333023792, 1, 1, 19, 'New Description', '', 0, '2012-03-27', '0000-00-00', '0000-00-00', '', '', '', '', '', '', '454545', '1', '', ' ', '', 'f11f6925-5228-5ef5-934f-0ef753598f3f', 6, 0),
(10058, 0, '', '', '', 1332859982, 1333097770, 1, 1, 19, 'New Description', '', 0, '2012-03-27', '0000-00-00', '0000-00-00', '', '', '', '', '', '', '3', '1', '', ' ', '', '048be949-e5f2-52ec-8090-02364a778e1b', 2, 0),
(10059, 0, '', '', '', 1332859982, 1333097766, 1, 1, 19, 'New Description', '', 0, '2012-03-27', '0000-00-00', '0000-00-00', '', '', '', '', '', '', '454', '1', '', ' ', '', '14ba1c3a-9985-5330-9a35-69646b59d3b0', 5, 0),
(10060, 0, '', '', '', 1332859982, 1333340013, 1, 1, 19, 'New Description', '', 0, '2012-03-27', '0000-00-00', '0000-00-00', '', '', '', '', '', '', '345345', '1', '4,1,2', ' ', '', '7862230c-45d1-5e4b-8550-b04fc4d134e7', 7, 0),
(10061, 0, '', '', '', 1332859982, 1333371799, 1, 1, 19, 'New Description', '', 0, '2012-03-27', '0000-00-00', '0000-00-00', '', '', '', '', '', '', 'aaaa6', '1', '', ' ', '', 'dc7585df-b471-54df-b872-b8a840f22589', 5, 0),
(10062, 0, '', '', '', 1332859982, 1333371798, 1, 1, 19, 'New Description', '', 0, '2012-03-27', '0000-00-00', '0000-00-00', '', '', '', '', '', '', '43443', '1', '', ' ', '', 'afb310d4-0560-5f5b-a0aa-0005e395d00c', 12, 0),
(10064, 0, '', '', '', 1332860050, 1333097684, 1, 1, 15, 'vv', '', 0, '2012-03-27', '0000-00-00', '0000-00-00', '', '', '', '', '', '', 'aa34444444', '1', '', ' ', '', '875081e9-7a16-53d5-9863-bb87bd677cdf', 22, 0),
(10065, 0, '', '', '', 1332860050, 1333097682, 1, 1, 15, 'vv', '', 0, '2012-03-27', '0000-00-00', '0000-00-00', '', '', '', '', '', '', '34334', '1', '', ' ', '', '5c4897ea-0dcb-5629-b631-4b80a1c6d516', 10, 0),
(10067, 0, '', '', '', 1332860167, 1333363030, 1, 1, 15, 'ft', '', 0, '2012-03-27', '0000-00-00', '0000-00-00', '', '', '', '', '', '', '76676', '1', '', ' ', '', 'bc4a4789-6ea4-5c02-a1c4-1573282e7fdf', 9, 0),
(11451, 6, '', '', '', 1333020605, 1333026267, 1, 1, 19, 'srfsdf', '10001', 10004, '2012-03-29', '0000-00-00', '0000-00-00', '', '', '', '', '', '', '5456', '1', '', ' ', '', 'f2535679-6740-5819-843d-ca14d3b3d78d', 2, 0),
(11452, 7, '', '', '', 1333020605, 1333026268, 1, 1, 19, 'srfsdf', '10002', 10004, '2012-03-29', '0000-00-00', '0000-00-00', '', '', '', '', '', '', '554', '1', '', ' ', '', '8d0dc58c-2e47-5e20-95bb-a018e44b1dc0', 2, 0),
(11699, 1, '4', '10', '4', 1333380353, 1333380410, 1, 1, 36, '', '10029', 10017, '2012-04-02', '2012-04-02', '0000-00-00', '', '', '', '', '', '', '', '1', '', 'Knocked', '', '84c0b6c6-face-5c68-b129-3f882ccaaf68', 1, 0),
(11700, 2, '2', '1', '2', 1333380353, 1333440407, 1, 1, 36, '', '10030', 10017, '2012-04-02', '2012-04-03', '0000-00-00', '', '', '', '', '', '', '', '1', '', 'Knocked', '', '1f973260-8e1a-5c6d-bee8-7c7c8c7b23f7', 1, 0),
(11701, 3, '4', '9', '4', 1333380353, 1333440420, 1, 1, 36, '', '10031', 10017, '2012-04-02', '2012-04-03', '0000-00-00', '', '', '', '', '', '', '', '1', '', 'Knocked', '', '1d54678f-fb73-54d3-bfb3-fd3e9263a769', 1, 0),
(11702, 4, NULL, NULL, NULL, 1333380353, 0, 1, 0, 36, '', '10032', 10017, '2012-04-02', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1', NULL, 'Incoming', NULL, 'b8c1c3e5-4d38-51ce-b4bb-dfd05a507f6d', 0, 0),
(11703, 5, NULL, NULL, NULL, 1333380353, 0, 1, 0, 36, '', '10033', 10017, '2012-04-02', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1', NULL, 'Incoming', NULL, 'c95b6495-cbd0-5f7b-bbe0-c55a6e4dbc9f', 0, 0),
(11704, 1, '1', '1', '1', 1333380377, 0, 1, 0, 35, NULL, '10034', 0, NULL, '2012-04-02', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1', NULL, 'Knocked', NULL, 'fdf56ce0-3953-5b85-9f4d-311ccc38286c', 0, 0),
(11705, 1, '2', '2', '2', 1333380436, 0, 1, 0, 36, NULL, '10035', 0, NULL, '2012-04-02', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1', NULL, 'Knocked', NULL, '17baefe9-33e4-5cc7-8990-10060613034c', 0, 0),
(11706, 1, '4', '10', '4', 1333438126, 0, 1, 0, 36, NULL, '10036', 0, NULL, '2012-04-03', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1', NULL, 'Knocked', NULL, 'c38bdbfe-90b7-51a1-8165-2ecb764706bd', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `raw_product_status_log`
--

CREATE TABLE IF NOT EXISTS `raw_product_status_log` (
  `rawproductstatus_id` bigint(10) NOT NULL,
  `created_on` bigint(28) NOT NULL,
  `created_by` int(15) NOT NULL,
  `status` varchar(10) NOT NULL,
  `row_guid` varchar(255) NOT NULL,
  `is_deleted` varchar(15) NOT NULL,
  PRIMARY KEY  (`rawproductstatus_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `seo_url`
--

CREATE TABLE IF NOT EXISTS `seo_url` (
  `id` int(11) NOT NULL auto_increment,
  `actual_url` varchar(255) NOT NULL,
  `seo_url` varchar(255) character set utf8 collate utf8_bin NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=392 ;

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
(389, '/employee/page/identifire/employee-benifits.html', '/employee-benifits.html'),
(390, '/employee/page/identifire/important-contacts.html', '/important-contacts.html'),
(391, '/index/forgot-password', '/forgot-password');

-- --------------------------------------------------------

--
-- Table structure for table `subgroup`
--

CREATE TABLE IF NOT EXISTS `subgroup` (
  `id` int(11) NOT NULL auto_increment,
  `title` varchar(255) NOT NULL,
  `addedon` bigint(24) NOT NULL,
  `updatedon` bigint(24) default NULL,
  `created_by` int(15) NOT NULL,
  `updated_by` int(15) NOT NULL,
  `row_guid` varchar(255) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=19 ;

--
-- Dumping data for table `subgroup`
--

INSERT INTO `subgroup` (`id`, `title`, `addedon`, `updatedon`, `created_by`, `updated_by`, `row_guid`) VALUES
(4, 'SubGroup2', 1317803157, 1321604769, 0, 0, ''),
(5, 'SubGroup3', 1317803174, 1321604806, 0, 0, ''),
(16, 'SubGroup1', 1321605567, 1328674719, 0, 1, '');

-- --------------------------------------------------------

--
-- Table structure for table `supplier`
--

CREATE TABLE IF NOT EXISTS `supplier` (
  `id` int(50) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `org_name` varchar(50) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `address1` text NOT NULL,
  `address2` text NOT NULL,
  `city` varchar(50) NOT NULL,
  `state` varchar(50) NOT NULL,
  `zip` varchar(50) NOT NULL,
  `phone` varchar(50) NOT NULL,
  `fax` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `created_on` bigint(28) NOT NULL,
  `updated_on` bigint(28) NOT NULL,
  `created_by` int(15) NOT NULL,
  `updated_by` int(15) NOT NULL,
  `row_guid` varchar(255) NOT NULL,
  `row_version` int(14) NOT NULL,
  `row_max_id` int(14) NOT NULL,
  `status` int(1) NOT NULL,
  `quick_supplier` varchar(10) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

--
-- Dumping data for table `supplier`
--

INSERT INTO `supplier` (`id`, `username`, `password`, `org_name`, `first_name`, `last_name`, `address1`, `address2`, `city`, `state`, `zip`, `phone`, `fax`, `email`, `created_on`, `updated_on`, `created_by`, `updated_by`, `row_guid`, `row_version`, `row_max_id`, `status`, `quick_supplier`) VALUES
(-2147483648, 'vikash368', 'f1d7405cf06be812e5d2f9d5145a8dc7', 'InfoPro', 'Vikash', 'Rajput', 'C-4', 'Sector-58', 'Noida', 'Uttar Pradesh', '201307', '9540774955', '9768', 'vikash368@gmail.com', 1318838489, 1318838489, 0, 1, '0', 36, 36, 0, '0'),
(36, 'Supplier 2', 'e10adc3949ba59abbe56e057f20f883e', 'Supplier 2 Organization', 'Smith', 'Dale', '1, Church road', 'Opposite Mystiqe garden', 'Washington', 'Washington DC', '11009', '9540774955', '9540774955', 'vvikash.368@gmail.com', 1333379254, 0, 1, 0, 'f3484a17-856e-5afb-a4d0-606fa1f13508', 0, 0, 1, '1'),
(35, 'Supplier 1', 'e10adc3949ba59abbe56e057f20f883e', 'Supplier 1 Organization', 'Vikash', 'Rajput', 'C-4', 'Sector-58', 'Noida', 'Uttar Pradesh', '201307', '9540774955', '9540774955', 'vikash.rajput@compunne.com', 1333378365, 0, 1, 0, '0c13d78e-65ff-5fb1-9e65-72c75a6fb85c', 0, 0, 1, '1');

-- --------------------------------------------------------

--
-- Table structure for table `system_mapping`
--

CREATE TABLE IF NOT EXISTS `system_mapping` (
  `map_code` varchar(100) NOT NULL,
  `map_id1` int(10) NOT NULL,
  `map_id2` int(10) NOT NULL,
  `map_id3` int(10) default NULL,
  `status` int(1) NOT NULL default '1',
  `intval1` int(10) NOT NULL default '0',
  `intval2` int(10) NOT NULL default '0',
  `strval1` varchar(256) NOT NULL default '',
  `strval2` varchar(256) NOT NULL default '',
  `blnval1` tinyint(1) NOT NULL default '0',
  `blnval2` tinyint(1) NOT NULL default '0',
  `dblval1` double NOT NULL default '0',
  `dblval2` double NOT NULL default '0',
  `created_on` bigint(24) NOT NULL,
  `created_by` int(10) NOT NULL,
  `updated_on` bigint(24) NOT NULL,
  `updated_by` int(10) NOT NULL,
  `row_guid` varchar(256) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `system_mapping`
--

INSERT INTO `system_mapping` (`map_code`, `map_id1`, `map_id2`, `map_id3`, `status`, `intval1`, `intval2`, `strval1`, `strval2`, `blnval1`, `blnval2`, `dblval1`, `dblval2`, `created_on`, `created_by`, `updated_on`, `updated_by`, `row_guid`) VALUES
('fdSubGroupRoleMap', 5, 1, 0, 1, 0, 0, '', '', 0, 0, 0, 0, 1329745999, 1, 0, 0, '53578c80-fde5-5ca4-8292-2707d9605eff'),
('fdGroupSubGroupMap', 1, 5, 0, 1, 0, 0, '', '', 0, 0, 0, 0, 1329745450, 1, 0, 0, '4bedea43-1872-58fb-9612-95e2abae44a8'),
('fdGroupSubGroupMap', 1, 4, 0, 1, 0, 0, '', '', 0, 0, 0, 0, 1329745337, 1, 0, 0, '04566565-47ab-543d-9c77-3472085fb0db'),
('fdSubGroupRoleMap', 7, 5, 0, 1, 0, 0, '', '', 0, 0, 0, 0, 1329802690, 1, 0, 0, '19a96e54-0472-5925-a28d-0093d1ced585'),
('fdSubGroupRoleMap', 4, 4, 0, 1, 0, 0, '', '', 0, 0, 0, 0, 1329802470, 1, 0, 0, '94818cca-ccd8-5dbf-8f09-20eeffeb30bc'),
('fdGroupSubGroupMap', 5, 7, 0, 1, 0, 0, '', '', 0, 0, 0, 0, 1329802679, 1, 0, 0, '42c3b3ae-52c4-5ef4-91a8-69cd10cbd7ca'),
('fdGroupSubGroupMap', 6, 13, 0, 1, 0, 0, '', '', 0, 0, 0, 0, 1330329393, 1, 0, 0, 'd938c527-89a5-5edd-8554-4df5270c8dd2'),
('fdSubGroupRoleMap', 7, 6, 0, 1, 0, 0, '', '', 0, 0, 0, 0, 1329803228, 1, 0, 0, '19fb74fd-7a6a-5102-a0cc-d2907a09d1fb'),
('fdGroupSubGroupMap', 5, 8, 0, 1, 0, 0, '', '', 0, 0, 0, 0, 1329804012, 1, 0, 0, '8c8bcb79-41c3-5479-8aad-f11f6c02643c'),
('fdLegendsLegendsValMap', 1, 1, 0, 1, 0, 0, '', '', 0, 0, 0, 0, 1329807194, 1, 0, 0, '91f2ffc3-cc2c-5400-ac86-8dc204a97557'),
('fdLegendsLegendsValMap', 1, 4, 0, 1, 0, 0, '', '', 0, 0, 0, 0, 1329807322, 1, 0, 0, '937223fd-d9ba-597c-ab56-052909a1a790'),
('fdLegendsLegendsValMap', 1, 5, 0, 1, 0, 0, '', '', 0, 0, 0, 0, 1329807332, 1, 0, 0, '4fe8f108-cf60-5900-8308-1a1c4badf858'),
('fdLegendsLegendsValMap', 3, 6, 0, 1, 0, 0, '', '', 0, 0, 0, 0, 1329807359, 1, 0, 0, '8100e772-cb71-5c33-b409-002572bbaa1e'),
('fdLegendsLegendsValMap', 3, 7, 0, 1, 0, 0, '', '', 0, 0, 0, 0, 1329807362, 1, 0, 0, 'b65a2db7-ff6c-5c68-a6b7-f678d88af6b7'),
('fdLegendsLegendsValMap', 3, 8, 0, 1, 0, 0, '', '', 0, 0, 0, 0, 1329807378, 1, 0, 0, '9921e76d-7c85-53ff-9a49-56ffcda8986f'),
('fdGroupSubGroupMap', 1, 8, 0, 1, 0, 0, '', '', 0, 0, 0, 0, 1329916028, 1, 0, 0, '09ebebc0-1e3b-53d8-a445-18652d4ed27e'),
('fdGroupSubGroupMap', 3, 8, 0, 1, 0, 0, '', '', 0, 0, 0, 0, 1330329312, 1, 0, 0, '09bc8621-f306-5dd8-a846-4d99f62c2886'),
('fdGroupSubGroupMap', 3, 9, 0, 1, 0, 0, '', '', 0, 0, 0, 0, 1330329320, 1, 0, 0, 'b762bed7-9b4a-595c-98a9-99d16daebd10'),
('fdGroupSubGroupMap', 3, 10, 0, 1, 0, 0, '', '', 0, 0, 0, 0, 1330329336, 1, 0, 0, 'e134617c-ac82-5730-9d94-c85f0c1a2e15'),
('fdGroupSubGroupMap', 3, 11, 0, 1, 0, 0, '', '', 0, 0, 0, 0, 1330329342, 1, 0, 0, '75924938-36cb-52c7-b5a3-4e7ed6948d20'),
('fdGroupSubGroupMap', 3, 12, 0, 1, 0, 0, '', '', 0, 0, 0, 0, 1330329351, 1, 0, 0, 'd976cf90-ddd4-500c-95cc-ff07a8c9add9'),
('fdSubGroupRoleMap', 13, 9, 0, 1, 0, 0, '', '', 0, 0, 0, 0, 1330329429, 1, 0, 0, '19fe266c-b041-5d11-ab29-5df209f5decb'),
('fdUserBookmark', 1, 63, 8, 1, 0, 0, '', '', 0, 0, 0, 0, 1332486644, 1, 0, 0, 'cd76bef6-7940-59c5-ae1d-dc8da81d49e3'),
('fdMenuRoleMap', 140, 5, NULL, 1, 0, 0, '', '', 0, 0, 0, 0, 1333438869, 1, 0, 0, '092d3a73-d9ef-5df2-960a-65cf99c82a28'),
('fdMenuRoleMap', 139, 5, NULL, 1, 0, 0, '', '', 0, 0, 0, 0, 1333438869, 1, 0, 0, '32215f33-67e4-56c9-9706-cd5828790de1'),
('fdMenuRoleMap', 137, 5, NULL, 1, 0, 0, '', '', 0, 0, 0, 0, 1333438869, 1, 0, 0, 'f8dcbe5c-a1aa-5748-a850-d1ff0525a2c0'),
('fdMenuRoleMap', 136, 5, NULL, 1, 0, 0, '', '', 0, 0, 0, 0, 1333438869, 1, 0, 0, '8fc02e21-b324-5287-b231-8a7f7c063565'),
('fdMenuRoleMap', 135, 5, NULL, 1, 0, 0, '', '', 0, 0, 0, 0, 1333438869, 1, 0, 0, 'cb5e3001-4072-59f0-9bc9-b97738961ef6'),
('fdMenuRoleMap', 134, 5, NULL, 1, 0, 0, '', '', 0, 0, 0, 0, 1333438869, 1, 0, 0, '045a209f-92d4-5735-b698-ca79735a708a'),
('fdMenuRoleMap', 133, 5, NULL, 1, 0, 0, '', '', 0, 0, 0, 0, 1333438869, 1, 0, 0, '9e439895-36f5-5cd6-8ca0-9dd56395221a'),
('fdMenuRoleMap', 132, 5, NULL, 1, 0, 0, '', '', 0, 0, 0, 0, 1333438869, 1, 0, 0, '0a4ed38b-027d-5d09-a245-da059ef3143a'),
('fdMenuRoleMap', 90, 5, NULL, 1, 0, 0, '', '', 0, 0, 0, 0, 1333438869, 1, 0, 0, 'c73d3cf3-1385-5a84-a9ce-3ea400d94498'),
('fdMenuRoleMap', 84, 5, NULL, 1, 0, 0, '', '', 0, 0, 0, 0, 1333438869, 1, 0, 0, '10383c96-0572-5af8-a7ba-034588288765'),
('fdMenuRoleMap', 79, 5, NULL, 1, 0, 0, '', '', 0, 0, 0, 0, 1333438869, 1, 0, 0, 'f9626409-ccd3-554c-9c9c-47bce1b9eeb6'),
('fdMenuRoleMap', 74, 5, NULL, 1, 0, 0, '', '', 0, 0, 0, 0, 1333438869, 1, 0, 0, 'aa796544-b0b0-5fc8-a5d3-c0e2fe50e74e'),
('fdMenuRoleMap', 113, 5, NULL, 1, 0, 0, '', '', 0, 0, 0, 0, 1333438869, 1, 0, 0, '90c350b2-9acd-5863-b37a-13fd45ace76f'),
('fdMenuRoleMap', 73, 5, NULL, 1, 0, 0, '', '', 0, 0, 0, 0, 1333438869, 1, 0, 0, 'a856699c-12a2-5368-8fc0-c77100aa4105'),
('fdMenuRoleMap', 112, 5, NULL, 1, 0, 0, '', '', 0, 0, 0, 0, 1333438869, 1, 0, 0, 'c62a0e67-4311-5887-baef-e86c4342f9a3'),
('fdWidget', 37, 3, 0, 1, 1, 1, '', '', 0, 0, 0, 0, 1332150963, 37, 0, 0, '5ff4d576-0e24-5447-8599-1f021964ea6b'),
('fdWidget', 37, 4, 0, 1, 0, 4, '', '', 0, 0, 0, 0, 1332150963, 37, 0, 0, '59e7777d-3772-58c2-9b30-75762e3936d7'),
('fdWidget', 37, 2, 0, 1, 0, 0, '', '', 0, 0, 0, 0, 1332150963, 37, 0, 0, '803ee8a4-b933-5f1f-b5a6-05b0cf6b76e8'),
('fdWidget', 37, 1, 0, 1, 1, 0, '', '', 0, 0, 0, 0, 1332150963, 37, 0, 0, '8e051349-3c7e-54e3-8891-a4f749af2b3e'),
('fdWidget', 1, 4, NULL, 1, 1, 1, '', '', 0, 0, 0, 0, 1332910078, 1, 0, 0, 'f27f2d90-8a19-547a-a27f-8836f1f98f02'),
('fdWidget', 1, 3, NULL, 1, 1, 4, '', '', 0, 0, 0, 0, 1332910078, 1, 0, 0, '3e94958a-520f-5dcd-8266-b2238d925582'),
('fdActionGroupMap', 1, 5, 0, 1, 0, 0, '', '', 0, 0, 0, 0, 1331725019, 1, 0, 0, 'c3e7823e-c51c-5fe3-9d67-84ac06edecf8'),
('fdWidget', 1, 2, NULL, 1, 1, 6, '', '', 0, 0, 0, 0, 1332910078, 1, 0, 0, '2abf912a-4330-5dc6-b1af-fb58520c6eff'),
('fdWidget', 1, 1, NULL, 1, 1, 5, '', '', 0, 0, 0, 0, 1332910078, 1, 0, 0, 'be958c22-b03c-58fb-89bb-ebeb8b6e74f5'),
('fdMenuGroupMap', 4, 5, 0, 1, 0, 0, '', '', 0, 0, 0, 0, 1331722528, 1, 0, 0, '34f8a48f-f6b3-568a-8e38-d25184420d15'),
('fdMenuGroupMap', 3, 5, 0, 1, 0, 0, '', '', 0, 0, 0, 0, 1331722528, 1, 0, 0, 'c81aa7e2-83d1-5995-aaf3-490c765fd7df'),
('fdMenuGroupMap', 2, 5, 0, 1, 0, 0, '', '', 0, 0, 0, 0, 1331722528, 1, 0, 0, 'e1c48abb-6e87-583a-bff8-db905c7fedc8'),
('fdMenuGroupMap', 1, 5, 0, 1, 0, 0, '', '', 0, 0, 0, 0, 1331722528, 1, 0, 0, '8f3fe01d-69cd-5729-8bfd-228beeac5ba6'),
('fdMenuRoleMap', 72, 5, NULL, 1, 0, 0, '', '', 0, 0, 0, 0, 1333438869, 1, 0, 0, 'bc368f11-bb12-51c9-b756-a7a70d51e926'),
('fdMenuRoleMap', 71, 5, NULL, 1, 0, 0, '', '', 0, 0, 0, 0, 1333438869, 1, 0, 0, 'f62281a6-a797-5f77-86c0-f427dd3898a1'),
('fdMenuRoleMap', 70, 5, NULL, 1, 0, 0, '', '', 0, 0, 0, 0, 1333438869, 1, 0, 0, '7bfbb809-d610-5c66-b28a-092bc84ee8f4'),
('fdMenuRoleMap', 69, 5, NULL, 1, 0, 0, '', '', 0, 0, 0, 0, 1333438869, 1, 0, 0, '0fbebde7-b792-5050-912c-48b1893a5fdb'),
('fdMenuRoleMap', 111, 5, NULL, 1, 0, 0, '', '', 0, 0, 0, 0, 1333438869, 1, 0, 0, 'ff89217e-513b-52de-85fe-c139c69b2ec6'),
('fdMenuRoleMap', 68, 5, NULL, 1, 0, 0, '', '', 0, 0, 0, 0, 1333438869, 1, 0, 0, '1b5d5f05-cc93-5275-8d4a-76da7b26fe48'),
('fdMenuRoleMap', 67, 5, NULL, 1, 0, 0, '', '', 0, 0, 0, 0, 1333438869, 1, 0, 0, 'c05b12f4-c46c-57bd-9f75-4da3ad6c3c0b'),
('fdMenuRoleMap', 66, 5, NULL, 1, 0, 0, '', '', 0, 0, 0, 0, 1333438869, 1, 0, 0, '89aa3b7a-ab8c-54b8-abee-830f083cb887'),
('fdMenuRoleMap', 65, 5, NULL, 1, 0, 0, '', '', 0, 0, 0, 0, 1333438869, 1, 0, 0, '42701bfb-f44b-514d-aceb-afd1f504c99e'),
('fdMenuRoleMap', 108, 5, NULL, 1, 0, 0, '', '', 0, 0, 0, 0, 1333438869, 1, 0, 0, '421b1e64-2bea-5415-8810-aceeb3ffc35e'),
('fdMenuSubGroupMap', 28, 7, 0, 1, 0, 0, '', '', 0, 0, 0, 0, 1332408072, 1, 0, 0, 'd8e650f0-4faf-5e9e-be76-962cc96398de'),
('fdMenuSubGroupMap', 27, 7, 0, 1, 0, 0, '', '', 0, 0, 0, 0, 1332408072, 1, 0, 0, '0f84b19c-b48a-55a6-9e1f-2037fc401b5d'),
('fdMenuSubGroupMap', 26, 7, 0, 1, 0, 0, '', '', 0, 0, 0, 0, 1332408072, 1, 0, 0, 'f30c6eab-4078-51f7-b536-4359e6708852'),
('fdMenuSubGroupMap', 25, 7, 0, 1, 0, 0, '', '', 0, 0, 0, 0, 1332408072, 1, 0, 0, 'ab2310bc-4bb6-5e4a-bb36-3befdb24f822'),
('fdMenuSubGroupMap', 24, 7, 0, 1, 0, 0, '', '', 0, 0, 0, 0, 1332408072, 1, 0, 0, '85c48a64-91a4-5c0f-94bc-33089d0081a7'),
('fdMenuSubGroupMap', 23, 7, 0, 1, 0, 0, '', '', 0, 0, 0, 0, 1332408072, 1, 0, 0, '42be09bc-cdfe-555d-8714-8d5f62c88e46'),
('fdMenuSubGroupMap', 22, 7, 0, 1, 0, 0, '', '', 0, 0, 0, 0, 1332408072, 1, 0, 0, '868ac718-2281-567f-b6fb-f784b23c988d'),
('fdMenuSubGroupMap', 21, 7, 0, 1, 0, 0, '', '', 0, 0, 0, 0, 1332408072, 1, 0, 0, 'b0d54180-a36c-5bef-b79f-7e8b75faedf2'),
('fdMenuSubGroupMap', 20, 7, 0, 1, 0, 0, '', '', 0, 0, 0, 0, 1332408072, 1, 0, 0, '8194e135-ae85-564d-b43b-ac8c47ebe1ac'),
('fdMenuSubGroupMap', 19, 7, 0, 1, 0, 0, '', '', 0, 0, 0, 0, 1332408072, 1, 0, 0, 'a7f31482-ae82-546d-afaa-6579e2096c1a'),
('fdMenuSubGroupMap', 18, 7, 0, 1, 0, 0, '', '', 0, 0, 0, 0, 1332408072, 1, 0, 0, '586e4eb7-45ba-53da-9b39-2dcb09b12b55'),
('fdMenuSubGroupMap', 17, 7, 0, 1, 0, 0, '', '', 0, 0, 0, 0, 1332408072, 1, 0, 0, '7581cbdc-a7af-5604-bd6c-88b221bcfb76'),
('fdMenuSubGroupMap', 16, 7, 0, 1, 0, 0, '', '', 0, 0, 0, 0, 1332408072, 1, 0, 0, 'bb0d60d9-5b2d-50fb-9dbf-510a332b396f'),
('fdMenuSubGroupMap', 15, 7, 0, 1, 0, 0, '', '', 0, 0, 0, 0, 1332408072, 1, 0, 0, '1081325b-b44f-5a5e-892d-bcf8a3a6d5f9'),
('fdMenuSubGroupMap', 14, 7, 0, 1, 0, 0, '', '', 0, 0, 0, 0, 1332408072, 1, 0, 0, 'e94fbdab-0d31-5c75-b68b-2a5fff042a4b'),
('fdMenuSubGroupMap', 13, 7, 0, 1, 0, 0, '', '', 0, 0, 0, 0, 1332408072, 1, 0, 0, '43dc6463-792f-5e00-8e5b-c4e1f047e3aa'),
('fdMenuSubGroupMap', 12, 7, 0, 1, 0, 0, '', '', 0, 0, 0, 0, 1332408072, 1, 0, 0, '9d8df713-835a-5f6d-99a6-ab4278366fd1'),
('fdMenuSubGroupMap', 11, 7, 0, 1, 0, 0, '', '', 0, 0, 0, 0, 1332408072, 1, 0, 0, 'c5a947c3-060f-5c45-babb-5018d3adb2b1'),
('fdMenuSubGroupMap', 10, 7, 0, 1, 0, 0, '', '', 0, 0, 0, 0, 1332408072, 1, 0, 0, '9f340117-137b-5d70-8bd9-a5f0b8dad96f'),
('fdMenuSubGroupMap', 4, 7, 0, 1, 0, 0, '', '', 0, 0, 0, 0, 1332408072, 1, 0, 0, 'ac2bd0e1-6ce2-517c-99d8-7f38d729c6a7'),
('fdMenuSubGroupMap', 3, 7, 0, 1, 0, 0, '', '', 0, 0, 0, 0, 1332408072, 1, 0, 0, 'e588c476-2782-5510-8551-7be89e534e00'),
('fdMenuSubGroupMap', 2, 7, 0, 1, 0, 0, '', '', 0, 0, 0, 0, 1332408072, 1, 0, 0, 'e59c0a1d-2c5f-5361-b3e4-b9d23856cf9a'),
('fdMenuSubGroupMap', 1, 7, 0, 1, 0, 0, '', '', 0, 0, 0, 0, 1332408072, 1, 0, 0, 'c2a5f43e-cc0b-5b28-a446-b52a20225f38'),
('fdMenuRoleMap', 64, 5, NULL, 1, 0, 0, '', '', 0, 0, 0, 0, 1333438869, 1, 0, 0, '0caf6199-a960-5f13-a474-cc9e22c4b3ce'),
('fdMenuRoleMap', 106, 5, NULL, 1, 0, 0, '', '', 0, 0, 0, 0, 1333438869, 1, 0, 0, 'e222c9ee-4379-5898-aad7-6bafa127a70b'),
('fdMenuRoleMap', 61, 5, NULL, 1, 0, 0, '', '', 0, 0, 0, 0, 1333438869, 1, 0, 0, 'b12bbfa4-42d7-5300-9c59-3239756df90f'),
('fdMenuRoleMap', 62, 5, NULL, 1, 0, 0, '', '', 0, 0, 0, 0, 1333438869, 1, 0, 0, '4aa51676-d65f-584b-9fa5-eaa92d73e59e'),
('fdMenuRoleMap', 63, 5, NULL, 1, 0, 0, '', '', 0, 0, 0, 0, 1333438869, 1, 0, 0, 'd4f2a0b9-4722-5349-85b2-e828c430c8da'),
('fdAnimalAnimalTypeAnimalColorMap', 1, 2, NULL, 1, 0, 0, '', '', 0, 0, 0, 0, 1332489801, 1, 0, 0, 'bc7c1262-83ad-5a7e-91b1-5106c7cf95b1'),
('fdAnimalAnimalTypeAnimalColorMap', 2, 2, NULL, 1, 0, 0, '', '', 0, 0, 0, 0, 1332487062, 1, 0, 0, '73f1f7e3-c94e-58a5-abc7-5dd92b4f1f13'),
('fdAnimalAnimalTypeAnimalColorMap', 1, 1, 1, 1, 0, 0, '', '', 0, 0, 0, 0, 1332489064, 1, 0, 0, 'a62d4030-47ef-50b5-8508-0e4cd3634de5'),
('fdAnimalAnimalTypeAnimalColorMap', 1, 1, 3, 1, 0, 0, '', '', 0, 0, 0, 0, 1332489383, 1, 0, 0, '4b40ec87-2a6c-5399-8165-19269ad884d3'),
('fdMenuRoleMap', 60, 5, NULL, 1, 0, 0, '', '', 0, 0, 0, 0, 1333438869, 1, 0, 0, '29349487-4733-5b29-97a8-f9d6bce2f056'),
('fdMenuUserMap', 83, 1, NULL, 1, 0, 0, '', '', 0, 0, 0, 0, 1332424319, 1, 0, 0, 'c868b707-e33d-554e-882e-e68d2ab81417'),
('fdMenuRoleMap', 105, 5, NULL, 1, 0, 0, '', '', 0, 0, 0, 0, 1333438869, 1, 0, 0, '1484c77c-9944-5f37-bef3-4d38b9311b65'),
('fdMenuRoleMap', 107, 5, NULL, 1, 0, 0, '', '', 0, 0, 0, 0, 1333438869, 1, 0, 0, 'e7264bf6-5b21-56db-a025-8bc7c2bff87c'),
('fdAnimalAnimalTypeAnimalColorMap', 3, 2, NULL, 1, 0, 0, '', '', 0, 0, 0, 0, 1332487082, 1, 0, 0, '2196ebbd-9b95-5e4c-8497-dcb97c662537'),
('fdUserBookmark', 1, 74, NULL, 1, 0, 0, '', '', 0, 0, 0, 0, 1333000666, 1, 0, 0, '9b057532-72cc-558b-a9a0-dfe583b88f7a'),
('fdUserBookmark', 1, 50, 10, 1, 0, 0, '', '', 0, 0, 0, 0, 1332486644, 1, 0, 0, 'f88fd10d-7df7-520d-98de-111ada97414a'),
('fdMenuRoleMap', 59, 5, NULL, 1, 0, 0, '', '', 0, 0, 0, 0, 1333438869, 1, 0, 0, '4f939c89-e738-59e5-b671-65bae215b170'),
('fdMenuRoleMap', 58, 5, NULL, 1, 0, 0, '', '', 0, 0, 0, 0, 1333438869, 1, 0, 0, '493a90ca-1022-5b7a-8c82-438b1af77223'),
('fdMenuRoleMap', 54, 5, NULL, 1, 0, 0, '', '', 0, 0, 0, 0, 1333438869, 1, 0, 0, '530c18a2-f05f-54c8-be13-af3820d045f0'),
('fdMenuRoleMap', 78, 5, NULL, 1, 0, 0, '', '', 0, 0, 0, 0, 1333438869, 1, 0, 0, '545e07d7-0658-5369-a8da-f406ebe59ae9'),
('fdMenuRoleMap', 83, 5, NULL, 1, 0, 0, '', '', 0, 0, 0, 0, 1333438869, 1, 0, 0, 'fd9ce0ff-60af-542e-96d9-c6ca4ffdda9f'),
('fdMenuRoleMap', 110, 5, NULL, 1, 0, 0, '', '', 0, 0, 0, 0, 1333438869, 1, 0, 0, '63de9966-1bc6-5216-a648-7ca770eb5074'),
('fdMenuRoleMap', 55, 5, NULL, 1, 0, 0, '', '', 0, 0, 0, 0, 1333438869, 1, 0, 0, '409273c4-3666-5db9-b8a7-385d630a2f43'),
('fdMenuRoleMap', 102, 5, NULL, 1, 0, 0, '', '', 0, 0, 0, 0, 1333438869, 1, 0, 0, '61e5ab2b-aa6a-5962-8f96-9408e3f916f1'),
('fdMenuRoleMap', 109, 5, NULL, 1, 0, 0, '', '', 0, 0, 0, 0, 1333438869, 1, 0, 0, 'd26bf2d2-35e8-581b-9427-dec6888ba4a1'),
('fdMenuUserMap', 78, 1, NULL, 1, 0, 0, '', '', 0, 0, 0, 0, 1332424319, 1, 0, 0, '5e6cc4df-99b8-5190-9064-3d1ad7284154'),
('fdMenuUserMap', 54, 1, NULL, 1, 0, 0, '', '', 0, 0, 0, 0, 1332424319, 1, 0, 0, '3fda0ffb-9ba9-5a7b-8a14-dc4ef084112c'),
('fdMenuUserMap', 1, -2147483648, 0, 1, 0, 0, '', '', 0, 0, 0, 0, 1331639894, 1, 0, 0, '0126c399-bcde-542f-a702-73c2bb05065a'),
('fdMenuUserMap', 2, -2147483648, 0, 1, 0, 0, '', '', 0, 0, 0, 0, 1331639894, 1, 0, 0, 'a106c2cb-0e5d-5b43-b22d-16f652d6b463'),
('fdMenuUserMap', 3, -2147483648, 0, 1, 0, 0, '', '', 0, 0, 0, 0, 1331639894, 1, 0, 0, '67b31365-5a84-5798-9fe2-fda856113924'),
('fdMenuUserMap', 4, -2147483648, 0, 1, 0, 0, '', '', 0, 0, 0, 0, 1331639894, 1, 0, 0, '2fdfe32b-df0c-547d-b40d-8a7592d8f882'),
('fdMenuUserMap', 5, -2147483648, 0, 1, 0, 0, '', '', 0, 0, 0, 0, 1331639894, 1, 0, 0, 'de79ca2a-8535-54a4-8896-3dcd661e32d8'),
('fdMenuUserMap', 6, -2147483648, 0, 1, 0, 0, '', '', 0, 0, 0, 0, 1331639894, 1, 0, 0, '70c1f627-a9f4-583b-b92d-6fd1e0f82161'),
('fdMenuUserMap', 7, -2147483648, 0, 1, 0, 0, '', '', 0, 0, 0, 0, 1331639894, 1, 0, 0, '62ed6934-7432-52a3-9fa5-1e14228118c0'),
('fdMenuUserMap', 8, -2147483648, 0, 1, 0, 0, '', '', 0, 0, 0, 0, 1331639894, 1, 0, 0, '263840cd-f7aa-5f09-8338-077ac1f7d1dd'),
('fdMenuUserMap', 9, -2147483648, 0, 1, 0, 0, '', '', 0, 0, 0, 0, 1331639894, 1, 0, 0, '1c0e68ce-bb83-5d3c-9f3b-a070b992c4d0'),
('fdMenuUserMap', 10, -2147483648, 0, 1, 0, 0, '', '', 0, 0, 0, 0, 1331639894, 1, 0, 0, '12b97dde-9c62-547e-a0ca-71f5f5761b78'),
('fdMenuUserMap', 11, -2147483648, 0, 1, 0, 0, '', '', 0, 0, 0, 0, 1331639894, 1, 0, 0, '96b0a476-ae13-5620-b8bd-c6656cb4afb7'),
('fdMenuUserMap', 12, -2147483648, 0, 1, 0, 0, '', '', 0, 0, 0, 0, 1331639894, 1, 0, 0, '10e6c83e-0a3d-5ba6-8942-424703f3a64f'),
('fdMenuUserMap', 13, -2147483648, 0, 1, 0, 0, '', '', 0, 0, 0, 0, 1331639894, 1, 0, 0, '460045f3-08df-565d-986c-c973eaa8a4b1'),
('fdMenuUserMap', 14, -2147483648, 0, 1, 0, 0, '', '', 0, 0, 0, 0, 1331639894, 1, 0, 0, '88787061-3a9c-5d69-b625-2b0b05d4e4b6'),
('fdMenuUserMap', 15, -2147483648, 0, 1, 0, 0, '', '', 0, 0, 0, 0, 1331639894, 1, 0, 0, '6c2014b9-cf0c-54cc-a7b7-f65d59b7f454'),
('fdMenuUserMap', 16, -2147483648, 0, 1, 0, 0, '', '', 0, 0, 0, 0, 1331639894, 1, 0, 0, 'b1e07ab0-77a1-513d-a031-7144ea559fc0'),
('fdMenuUserMap', 17, -2147483648, 0, 1, 0, 0, '', '', 0, 0, 0, 0, 1331639894, 1, 0, 0, '525ea818-1f2e-5b1e-83f9-0882d977fb3b'),
('fdMenuUserMap', 18, -2147483648, 0, 1, 0, 0, '', '', 0, 0, 0, 0, 1331639894, 1, 0, 0, 'e517e7e5-46e9-57dd-b94a-f769804ce51f'),
('fdMenuUserMap', 19, -2147483648, 0, 1, 0, 0, '', '', 0, 0, 0, 0, 1331639894, 1, 0, 0, '6bb998af-17bc-5abd-91bd-6046552ec672'),
('fdMenuUserMap', 20, -2147483648, 0, 1, 0, 0, '', '', 0, 0, 0, 0, 1331639894, 1, 0, 0, '266bdc09-8bb9-523c-8764-101f2c6e55b0'),
('fdMenuUserMap', 21, -2147483648, 0, 1, 0, 0, '', '', 0, 0, 0, 0, 1331639894, 1, 0, 0, 'e007fed2-0272-5c16-a42b-7ac6049f5d7f'),
('fdMenuUserMap', 22, -2147483648, 0, 1, 0, 0, '', '', 0, 0, 0, 0, 1331639894, 1, 0, 0, '9f1aca15-58a3-5630-bcce-0ac30682c906'),
('fdMenuUserMap', 23, -2147483648, 0, 1, 0, 0, '', '', 0, 0, 0, 0, 1331639894, 1, 0, 0, 'bb62d83e-a4ee-58ba-a9ba-f3f2e5631e5d'),
('fdMenuUserMap', 24, -2147483648, 0, 1, 0, 0, '', '', 0, 0, 0, 0, 1331639894, 1, 0, 0, '5dcd0d3c-8841-5fe6-adc0-5f49c6bc6520'),
('fdMenuUserMap', 25, -2147483648, 0, 1, 0, 0, '', '', 0, 0, 0, 0, 1331639894, 1, 0, 0, 'f2c65c37-781a-50ba-abf4-bb817cb46947'),
('fdMenuUserMap', 26, -2147483648, 0, 1, 0, 0, '', '', 0, 0, 0, 0, 1331639894, 1, 0, 0, 'df8d8af2-ccec-5690-b2d8-b9e75fb11fe8'),
('fdMenuUserMap', 27, -2147483648, 0, 1, 0, 0, '', '', 0, 0, 0, 0, 1331639894, 1, 0, 0, '5ba2e08c-8072-56cc-96ce-7d3e99c7624b'),
('fdMenuUserMap', 28, -2147483648, 0, 1, 0, 0, '', '', 0, 0, 0, 0, 1331639894, 1, 0, 0, 'd4af1c7c-8d2f-5b90-9a5e-d99f7f9f4e40'),
('fdMenuUserMap', 29, -2147483648, 0, 1, 0, 0, '', '', 0, 0, 0, 0, 1331639894, 1, 0, 0, '419dc048-ff36-50f6-b05a-3400b0b21fd5'),
('fdMenuUserMap', 30, -2147483648, 0, 1, 0, 0, '', '', 0, 0, 0, 0, 1331639894, 1, 0, 0, '8b6d8f26-487e-547b-9728-02daae0fbdd1'),
('fdMenuUserMap', 31, -2147483648, 0, 1, 0, 0, '', '', 0, 0, 0, 0, 1331639894, 1, 0, 0, 'b8b41f9d-2aee-59b9-8338-722019d01fd7'),
('fdMenuUserMap', 32, -2147483648, 0, 1, 0, 0, '', '', 0, 0, 0, 0, 1331639894, 1, 0, 0, '0c1e329f-7324-51eb-a054-caf2ee84b908'),
('fdMenuUserMap', 33, -2147483648, 0, 1, 0, 0, '', '', 0, 0, 0, 0, 1331639894, 1, 0, 0, '92d011a7-3889-51f2-b941-8b7b551983e1'),
('fdMenuUserMap', 34, -2147483648, 0, 1, 0, 0, '', '', 0, 0, 0, 0, 1331639894, 1, 0, 0, 'e5bcfe92-d8f2-5430-88e1-7565851ef8b8'),
('fdMenuUserMap', 35, -2147483648, 0, 1, 0, 0, '', '', 0, 0, 0, 0, 1331639894, 1, 0, 0, '9c3c2685-e7c0-5287-bf01-fd04b8135d31'),
('fdMenuUserMap', 36, -2147483648, 0, 1, 0, 0, '', '', 0, 0, 0, 0, 1331639894, 1, 0, 0, 'f7b3f768-6174-5fb5-bcc0-7393125923f7'),
('fdMenuUserMap', 37, -2147483648, 0, 1, 0, 0, '', '', 0, 0, 0, 0, 1331639894, 1, 0, 0, '57b4b3b3-bc09-5ea1-8b66-bcbda33a28b3'),
('fdMenuUserMap', 38, -2147483648, 0, 1, 0, 0, '', '', 0, 0, 0, 0, 1331639894, 1, 0, 0, '252bc30f-536b-5b45-99bb-c9f51b2f0e42'),
('fdMenuUserMap', 39, -2147483648, 0, 1, 0, 0, '', '', 0, 0, 0, 0, 1331639894, 1, 0, 0, '549793eb-98db-5290-9988-de8ddc166d6b'),
('fdMenuUserMap', 40, -2147483648, 0, 1, 0, 0, '', '', 0, 0, 0, 0, 1331639894, 1, 0, 0, 'ad4e84ac-db56-5093-a25d-52984f59f7d5'),
('fdMenuUserMap', 41, -2147483648, 0, 1, 0, 0, '', '', 0, 0, 0, 0, 1331639894, 1, 0, 0, 'd68bb562-22e4-5766-98b9-98bed7cca3dd'),
('fdMenuUserMap', 42, -2147483648, 0, 1, 0, 0, '', '', 0, 0, 0, 0, 1331639894, 1, 0, 0, 'df64f145-9784-5445-a4c1-85b39a7bb305'),
('fdMenuUserMap', 43, -2147483648, 0, 1, 0, 0, '', '', 0, 0, 0, 0, 1331639894, 1, 0, 0, '5ad3d873-f1f2-5694-8c32-126c2746d645'),
('fdMenuUserMap', 44, -2147483648, 0, 1, 0, 0, '', '', 0, 0, 0, 0, 1331639894, 1, 0, 0, '27fba125-be32-5ab4-a435-7e7ad9e27654'),
('fdMenuUserMap', 45, -2147483648, 0, 1, 0, 0, '', '', 0, 0, 0, 0, 1331639894, 1, 0, 0, '54c79ff1-e669-5bc5-8b97-1113b43ff1db'),
('fdMenuUserMap', 46, -2147483648, 0, 1, 0, 0, '', '', 0, 0, 0, 0, 1331639894, 1, 0, 0, '41c724ea-447b-5e6c-9d87-c79bfdcb56bd'),
('fdMenuUserMap', 47, -2147483648, 0, 1, 0, 0, '', '', 0, 0, 0, 0, 1331639894, 1, 0, 0, '45c9881f-b147-52eb-9df4-d07e28fd18bf'),
('fdMenuUserMap', 49, -2147483648, 0, 1, 0, 0, '', '', 0, 0, 0, 0, 1331639894, 1, 0, 0, '4e5e3ec0-a92a-57a7-ac12-39c352ed3ede'),
('fdMenuUserMap', 48, -2147483648, 0, 1, 0, 0, '', '', 0, 0, 0, 0, 1331639894, 1, 0, 0, 'd7e46127-0a26-56ad-816f-7ccb337249c7'),
('fdMenuUserMap', 50, -2147483648, 0, 1, 0, 0, '', '', 0, 0, 0, 0, 1331639894, 1, 0, 0, '5db3444f-de09-5f9a-807d-bd88a473a9a0'),
('fdMenuUserMap', 51, -2147483648, 0, 1, 0, 0, '', '', 0, 0, 0, 0, 1331639894, 1, 0, 0, '432f271a-4294-5eb6-bdbd-c21984772a1e'),
('fdMenuUserMap', 52, -2147483648, 0, 1, 0, 0, '', '', 0, 0, 0, 0, 1331639894, 1, 0, 0, '4d160901-c093-5d18-b6c8-87e4913ff425'),
('fdMenuUserMap', 53, -2147483648, 0, 1, 0, 0, '', '', 0, 0, 0, 0, 1331639894, 1, 0, 0, '1d302239-5733-5c60-8185-2c20525924a0'),
('fdMenuUserMap', 54, -2147483648, 0, 1, 0, 0, '', '', 0, 0, 0, 0, 1331639894, 1, 0, 0, '6fed4190-53d5-5c91-9327-b9de68a273fd'),
('fdMenuUserMap', 55, -2147483648, 0, 1, 0, 0, '', '', 0, 0, 0, 0, 1331639894, 1, 0, 0, '0d20bbe8-7d69-58b6-a48c-36e6eb9fd8a3'),
('fdMenuRoleMap', 138, 5, NULL, 1, 0, 0, '', '', 0, 0, 0, 0, 1333438869, 1, 0, 0, '6274460e-1552-5983-a4ea-f56a0251cb92'),
('fdMenuRoleMap', 100, 5, NULL, 1, 0, 0, '', '', 0, 0, 0, 0, 1333438869, 1, 0, 0, '5c5c3ed0-3c9a-558a-a8c5-f3d4328ac576'),
('fdMenuRoleMap', 101, 5, NULL, 1, 0, 0, '', '', 0, 0, 0, 0, 1333438869, 1, 0, 0, 'caa07ace-f2ea-55d2-8205-50f39c8bd927'),
('fdMenuRoleMap', 2, 1, 0, 1, 0, 0, '', '', 0, 0, 0, 0, 1331642358, 1, 0, 0, '2103ea90-3824-52bf-91a6-1e358cb47cf1'),
('fdMenuRoleMap', 99, 5, NULL, 1, 0, 0, '', '', 0, 0, 0, 0, 1333438869, 1, 0, 0, 'a117f26e-cc1a-5e17-bf83-69a4620635e8'),
('fdMenuRoleMap', 53, 5, NULL, 1, 0, 0, '', '', 0, 0, 0, 0, 1333438869, 1, 0, 0, '73c62f28-908c-59dc-9add-5b760803ccc7'),
('fdMenuRoleMap', 98, 5, NULL, 1, 0, 0, '', '', 0, 0, 0, 0, 1333438869, 1, 0, 0, 'ea7aa6b2-e064-5540-b9b1-6d34db47e79d'),
('fdMenuRoleMap', 97, 5, NULL, 1, 0, 0, '', '', 0, 0, 0, 0, 1333438869, 1, 0, 0, '71eb8938-e9b0-5cbf-bbc4-245674299e8a'),
('fdMenuRoleMap', 96, 5, NULL, 1, 0, 0, '', '', 0, 0, 0, 0, 1333438869, 1, 0, 0, '730a6f28-2a7d-5578-beaf-aa6b858008e6'),
('fdMenuRoleMap', 51, 5, NULL, 1, 0, 0, '', '', 0, 0, 0, 0, 1333438869, 1, 0, 0, 'c1f3f835-e530-5702-b840-d76891ac042d'),
('fdMenuRoleMap', 141, 5, NULL, 1, 0, 0, '', '', 0, 0, 0, 0, 1333438869, 1, 0, 0, 'a90e932d-fae3-5416-84c4-620d538f6aa1'),
('fdMenuRoleMap', 95, 5, NULL, 1, 0, 0, '', '', 0, 0, 0, 0, 1333438869, 1, 0, 0, '325e5608-10e3-5bb9-b2ed-694b52db816c'),
('fdMenuRoleMap', 94, 5, NULL, 1, 0, 0, '', '', 0, 0, 0, 0, 1333438869, 1, 0, 0, '3d329874-6c51-5f4a-8bef-1fc5774213ad'),
('fdMenuRoleMap', 50, 5, NULL, 1, 0, 0, '', '', 0, 0, 0, 0, 1333438869, 1, 0, 0, '6ba66265-b15c-5706-a3f2-0cb4f532880f'),
('fdUserBookmark', 1, 7, NULL, 1, 0, 0, '', '', 0, 0, 0, 0, 1333350330, 1, 0, 0, 'fa6197c4-d44b-5df6-a15d-b4cfd63b463f'),
('fdMenuRoleMap', 48, 5, NULL, 1, 0, 0, '', '', 0, 0, 0, 0, 1333438869, 1, 0, 0, 'f4551926-88d5-5db7-b7ef-6c36812374bd'),
('fdMenuRoleMap', 49, 5, NULL, 1, 0, 0, '', '', 0, 0, 0, 0, 1333438869, 1, 0, 0, '8c29fe4f-98dc-546b-adf1-43d484bdc97a'),
('fdMenuRoleMap', 76, 5, NULL, 1, 0, 0, '', '', 0, 0, 0, 0, 1333438869, 1, 0, 0, 'dfdf95df-04b3-52fb-afcf-9847d49593b3'),
('fdMenuRoleMap', 75, 5, NULL, 1, 0, 0, '', '', 0, 0, 0, 0, 1333438869, 1, 0, 0, 'a12da425-2acb-5f58-9f7d-d1eefff3e8b2'),
('fdMenuRoleMap', 47, 5, NULL, 1, 0, 0, '', '', 0, 0, 0, 0, 1333438869, 1, 0, 0, '616f1530-31ed-5e25-a1b7-1931b7d0001c'),
('fdUserBookmark', 1, 46, NULL, 1, 0, 0, '', '', 0, 0, 0, 0, 1332999078, 1, 0, 0, '3280c6fa-fad6-55dd-bdb7-199863919ff1'),
('fdMenuRoleMap', 88, 5, NULL, 1, 0, 0, '', '', 0, 0, 0, 0, 1333438869, 1, 0, 0, '8bff028c-949b-5998-ac44-d3284e9054e9'),
('fdUserBookmark', 1, 8, NULL, 1, 0, 0, '', '', 0, 0, 0, 0, 1332998831, 1, 0, 0, '868f1994-b19c-5530-b659-4551ebcc33b6'),
('fdUserBookmark', 1, 4, NULL, 1, 0, 0, '', '', 0, 0, 0, 0, 1332939646, 1, 0, 0, '892a6a0d-5bc4-5907-b235-8f7b434897bb'),
('fdMenuRoleMap', 57, 5, NULL, 1, 0, 0, '', '', 0, 0, 0, 0, 1333438869, 1, 0, 0, 'f22faa8f-19f7-51b5-9767-111f6c13ea96'),
('fdMenuRoleMap', 85, 5, NULL, 1, 0, 0, '', '', 0, 0, 0, 0, 1333438869, 1, 0, 0, 'a9d08513-0dcf-5c99-b692-5420d43ada0a'),
('fdMenuRoleMap', 86, 5, NULL, 1, 0, 0, '', '', 0, 0, 0, 0, 1333438869, 1, 0, 0, '8652aca9-5f2d-51e6-a132-b7773c0097b3'),
('fdMenuRoleMap', 46, 5, NULL, 1, 0, 0, '', '', 0, 0, 0, 0, 1333438869, 1, 0, 0, '3c24f8c9-1569-5bc6-b65d-86cd7988630c'),
('fdMenuRoleMap', 116, 6, NULL, 1, 0, 0, '', '', 0, 0, 0, 0, 1332833472, 1, 0, 0, '935049a0-94bd-507f-89a6-83fddfe334ec'),
('fdMenuRoleMap', 5, 6, NULL, 1, 0, 0, '', '', 0, 0, 0, 0, 1332833472, 1, 0, 0, '539b57df-ef80-54b6-acf0-4e231ddc0bea'),
('fdMenuRoleMap', 4, 6, NULL, 1, 0, 0, '', '', 0, 0, 0, 0, 1332833472, 1, 0, 0, '5f2c1592-156b-53eb-a32e-10636b3b7cec'),
('fdGroupSubGroupMap', 1, 14, 0, 1, 0, 0, '', '', 0, 0, 0, 0, 1331641063, 1, 0, 0, '2efe4d19-7609-50bc-ac68-621bc2fa075a'),
('fdMenuGroupMap', 55, 6, 0, 1, 0, 0, '', '', 0, 0, 0, 0, 1331641945, 1, 0, 0, '6f1f6342-c643-5a69-9975-6c7db9ef1f59'),
('fdMenuGroupMap', 54, 6, 0, 1, 0, 0, '', '', 0, 0, 0, 0, 1331641945, 1, 0, 0, 'ac82e65b-2073-5927-be88-5bff23cc4932'),
('fdMenuGroupMap', 53, 6, 0, 1, 0, 0, '', '', 0, 0, 0, 0, 1331641945, 1, 0, 0, '36bbdeb1-4ade-583b-aebb-dec8598f7833'),
('fdMenuGroupMap', 52, 6, 0, 1, 0, 0, '', '', 0, 0, 0, 0, 1331641945, 1, 0, 0, '9a3e8c9f-3bc1-57cf-8883-8f12b754383c'),
('fdMenuGroupMap', 51, 6, 0, 1, 0, 0, '', '', 0, 0, 0, 0, 1331641945, 1, 0, 0, '3a36e979-5dd4-5e88-b3d4-5657f38b0306'),
('fdMenuGroupMap', 50, 6, 0, 1, 0, 0, '', '', 0, 0, 0, 0, 1331641945, 1, 0, 0, '9faaa046-fac3-5f8a-a191-6bd8d07b6955'),
('fdMenuGroupMap', 48, 6, 0, 1, 0, 0, '', '', 0, 0, 0, 0, 1331641945, 1, 0, 0, 'fe9ad822-e356-55ab-9f4a-dbafa1f61791'),
('fdMenuGroupMap', 49, 6, 0, 1, 0, 0, '', '', 0, 0, 0, 0, 1331641945, 1, 0, 0, 'db43995a-5653-566f-9e4b-7377d0020277'),
('fdMenuGroupMap', 47, 6, 0, 1, 0, 0, '', '', 0, 0, 0, 0, 1331641945, 1, 0, 0, 'baeafcba-08de-5e59-8fa6-165ac7a295fd'),
('fdMenuGroupMap', 46, 6, 0, 1, 0, 0, '', '', 0, 0, 0, 0, 1331641945, 1, 0, 0, 'de5e53a6-4507-5fdc-b0cc-ce9711f25042'),
('fdMenuGroupMap', 45, 6, 0, 1, 0, 0, '', '', 0, 0, 0, 0, 1331641945, 1, 0, 0, '908cf644-7c32-5174-96d3-003e15865dff'),
('fdMenuGroupMap', 44, 6, 0, 1, 0, 0, '', '', 0, 0, 0, 0, 1331641945, 1, 0, 0, '99b08da9-5964-5f92-a34e-950f9edc8a44'),
('fdMenuGroupMap', 43, 6, 0, 1, 0, 0, '', '', 0, 0, 0, 0, 1331641945, 1, 0, 0, '4e8c7dfc-c2a3-5b4e-be0a-d30b05f0da09'),
('fdMenuGroupMap', 42, 6, 0, 1, 0, 0, '', '', 0, 0, 0, 0, 1331641945, 1, 0, 0, '10e1c786-9a1f-56db-9953-56f3f96f294c'),
('fdMenuGroupMap', 41, 6, 0, 1, 0, 0, '', '', 0, 0, 0, 0, 1331641945, 1, 0, 0, '4977fbcd-2314-5d8c-b04b-76184d39ce6f'),
('fdMenuGroupMap', 40, 6, 0, 1, 0, 0, '', '', 0, 0, 0, 0, 1331641945, 1, 0, 0, '2ed858a6-7394-5054-9d02-07207e39bbea'),
('fdMenuGroupMap', 39, 6, 0, 1, 0, 0, '', '', 0, 0, 0, 0, 1331641945, 1, 0, 0, '8736fc42-0f24-5b25-8d1c-166ee0bd32e8'),
('fdMenuGroupMap', 38, 6, 0, 1, 0, 0, '', '', 0, 0, 0, 0, 1331641945, 1, 0, 0, 'e0edcfbd-1c0e-5b98-881b-bae0e159038a'),
('fdMenuGroupMap', 37, 6, 0, 1, 0, 0, '', '', 0, 0, 0, 0, 1331641945, 1, 0, 0, '9e8baa4b-c14e-5256-84f5-67235f10d0c8'),
('fdMenuGroupMap', 36, 6, 0, 1, 0, 0, '', '', 0, 0, 0, 0, 1331641945, 1, 0, 0, 'b29f3a58-5147-5259-9412-b340dfb7c1a3'),
('fdMenuGroupMap', 35, 6, 0, 1, 0, 0, '', '', 0, 0, 0, 0, 1331641945, 1, 0, 0, '3be7505b-6947-5a6c-a0f0-3c8b38c8feab'),
('fdMenuGroupMap', 34, 6, 0, 1, 0, 0, '', '', 0, 0, 0, 0, 1331641945, 1, 0, 0, '608d44be-266e-5eee-8e8b-cb5e230c53ac'),
('fdMenuGroupMap', 33, 6, 0, 1, 0, 0, '', '', 0, 0, 0, 0, 1331641945, 1, 0, 0, 'd574d028-6b83-57df-925e-d2c1fd85c06d'),
('fdMenuGroupMap', 32, 6, 0, 1, 0, 0, '', '', 0, 0, 0, 0, 1331641945, 1, 0, 0, 'f49af469-2e02-5278-9d98-9147ae4dd387'),
('fdMenuGroupMap', 31, 6, 0, 1, 0, 0, '', '', 0, 0, 0, 0, 1331641945, 1, 0, 0, '32123701-fdfc-5f3d-8fe6-4aca168c83e8'),
('fdMenuGroupMap', 30, 6, 0, 1, 0, 0, '', '', 0, 0, 0, 0, 1331641945, 1, 0, 0, '596adbe1-dd36-50e1-95d3-a4f96d671a2e'),
('fdMenuGroupMap', 29, 6, 0, 1, 0, 0, '', '', 0, 0, 0, 0, 1331641945, 1, 0, 0, 'bc4f4ca6-9805-5560-9c8b-422a723f5d41'),
('fdMenuGroupMap', 28, 6, 0, 1, 0, 0, '', '', 0, 0, 0, 0, 1331641945, 1, 0, 0, 'ed086263-32ef-5723-ba14-48c10d7a6c6a'),
('fdMenuGroupMap', 27, 6, 0, 1, 0, 0, '', '', 0, 0, 0, 0, 1331641945, 1, 0, 0, '1a41c508-6f17-5010-9ed8-2a91875f6786'),
('fdMenuGroupMap', 26, 6, 0, 1, 0, 0, '', '', 0, 0, 0, 0, 1331641945, 1, 0, 0, 'c7515b92-afa8-5254-a770-1805a2e01aa1'),
('fdMenuGroupMap', 25, 6, 0, 1, 0, 0, '', '', 0, 0, 0, 0, 1331641945, 1, 0, 0, 'd4c9098c-bb43-5349-b7e5-fad1624e6750'),
('fdMenuGroupMap', 24, 6, 0, 1, 0, 0, '', '', 0, 0, 0, 0, 1331641945, 1, 0, 0, '86d863e6-7c43-5116-bfe9-55dd6990c5ce'),
('fdMenuGroupMap', 23, 6, 0, 1, 0, 0, '', '', 0, 0, 0, 0, 1331641945, 1, 0, 0, '46992d53-8237-59ac-87e5-c8df0527b338'),
('fdMenuGroupMap', 22, 6, 0, 1, 0, 0, '', '', 0, 0, 0, 0, 1331641945, 1, 0, 0, 'b3002d3b-f6af-5592-a092-c26014e2f0eb'),
('fdMenuGroupMap', 21, 6, 0, 1, 0, 0, '', '', 0, 0, 0, 0, 1331641945, 1, 0, 0, 'af123854-bdf7-5804-84de-adc2b1b0b3c9'),
('fdMenuGroupMap', 20, 6, 0, 1, 0, 0, '', '', 0, 0, 0, 0, 1331641945, 1, 0, 0, 'e4185ef7-8f48-55cf-8dd4-dfa63d173392'),
('fdMenuGroupMap', 19, 6, 0, 1, 0, 0, '', '', 0, 0, 0, 0, 1331641945, 1, 0, 0, '7fcbf3ab-4609-5a90-b823-0011e3adc5ab'),
('fdMenuGroupMap', 18, 6, 0, 1, 0, 0, '', '', 0, 0, 0, 0, 1331641945, 1, 0, 0, '21514f34-a9fa-5714-9ed8-2616a8d8c292'),
('fdMenuGroupMap', 17, 6, 0, 1, 0, 0, '', '', 0, 0, 0, 0, 1331641945, 1, 0, 0, 'eeb36302-9edf-5da4-a88e-ba56cf8bdecc'),
('fdMenuGroupMap', 16, 6, 0, 1, 0, 0, '', '', 0, 0, 0, 0, 1331641945, 1, 0, 0, '50ccc45a-48ec-5b50-8ff2-da20c7f1bc9a'),
('fdMenuGroupMap', 15, 6, 0, 1, 0, 0, '', '', 0, 0, 0, 0, 1331641945, 1, 0, 0, '3ae7750f-cf1a-53e3-81f5-e9743e5d4419'),
('fdMenuGroupMap', 14, 6, 0, 1, 0, 0, '', '', 0, 0, 0, 0, 1331641945, 1, 0, 0, '19037287-c643-5ae3-a51f-d42f5ca03820'),
('fdMenuGroupMap', 13, 6, 0, 1, 0, 0, '', '', 0, 0, 0, 0, 1331641945, 1, 0, 0, '88986bc5-c207-5355-a7f1-5b71149724d1'),
('fdMenuGroupMap', 12, 6, 0, 1, 0, 0, '', '', 0, 0, 0, 0, 1331641945, 1, 0, 0, '890b296a-28b1-52d5-88c1-fa0010a80142'),
('fdMenuGroupMap', 11, 6, 0, 1, 0, 0, '', '', 0, 0, 0, 0, 1331641945, 1, 0, 0, '85373195-b4b0-5219-ba7f-d0dfa9214667'),
('fdMenuGroupMap', 10, 6, 0, 1, 0, 0, '', '', 0, 0, 0, 0, 1331641945, 1, 0, 0, 'b8ac9029-eb9c-5eb3-87a0-c599d3a5ff19'),
('fdMenuGroupMap', 9, 6, 0, 1, 0, 0, '', '', 0, 0, 0, 0, 1331641945, 1, 0, 0, '3115ccf4-2408-51e3-956f-7094683180c1'),
('fdMenuGroupMap', 8, 6, 0, 1, 0, 0, '', '', 0, 0, 0, 0, 1331641945, 1, 0, 0, '2b9c7e1e-9ff2-5643-aa1b-6ed538547086'),
('fdMenuGroupMap', 7, 6, 0, 1, 0, 0, '', '', 0, 0, 0, 0, 1331641945, 1, 0, 0, '4034d3f5-0dea-52a9-9c94-78ff67d73b93'),
('fdMenuGroupMap', 6, 6, 0, 1, 0, 0, '', '', 0, 0, 0, 0, 1331641945, 1, 0, 0, '6426a7a6-0b6f-5a04-a32b-20cc7b615f5b'),
('fdMenuGroupMap', 5, 6, 0, 1, 0, 0, '', '', 0, 0, 0, 0, 1331641945, 1, 0, 0, '93b9f4c4-ec14-53df-8153-8725778b6959'),
('fdMenuGroupMap', 4, 6, 0, 1, 0, 0, '', '', 0, 0, 0, 0, 1331641945, 1, 0, 0, 'f87b6b5c-8847-5046-9091-d745644d1d87'),
('fdMenuGroupMap', 3, 6, 0, 1, 0, 0, '', '', 0, 0, 0, 0, 1331641945, 1, 0, 0, 'e5dbbb83-35dc-5906-95a3-537f26e8c190'),
('fdMenuGroupMap', 2, 6, 0, 1, 0, 0, '', '', 0, 0, 0, 0, 1331641945, 1, 0, 0, '5b7a8407-bd59-5782-afab-1337c1b5864d'),
('fdMenuGroupMap', 1, 6, 0, 1, 0, 0, '', '', 0, 0, 0, 0, 1331641945, 1, 0, 0, '898c8da5-4550-547f-aea2-f5982f69ee9b'),
('fdMenuUserMap', 37, 6, 0, 1, 0, 0, '', '', 0, 0, 0, 0, 1331642303, 1, 0, 0, '12bd59f7-971e-505e-a160-78e55e9f1741'),
('fdMenuUserMap', 36, 6, 0, 1, 0, 0, '', '', 0, 0, 0, 0, 1331642303, 1, 0, 0, '75c098a3-995f-5516-8860-6341d8aa8756'),
('fdMenuUserMap', 35, 6, 0, 1, 0, 0, '', '', 0, 0, 0, 0, 1331642303, 1, 0, 0, '255c751f-e42f-56a4-8356-8c735adb9761'),
('fdMenuRoleMap', 45, 5, NULL, 1, 0, 0, '', '', 0, 0, 0, 0, 1333438869, 1, 0, 0, '42896fb0-57a5-5484-a537-d3bf9a503df9'),
('fdMenuRoleMap', 44, 5, NULL, 1, 0, 0, '', '', 0, 0, 0, 0, 1333438869, 1, 0, 0, '4dcb31f2-7913-57c3-9636-5358fc41f37e'),
('fdMenuRoleMap', 93, 5, NULL, 1, 0, 0, '', '', 0, 0, 0, 0, 1333438869, 1, 0, 0, 'ce1f00b5-36fe-56c9-a986-9e561d5675e1'),
('fdMenuRoleMap', 92, 5, NULL, 1, 0, 0, '', '', 0, 0, 0, 0, 1333438869, 1, 0, 0, 'bc8fee0b-e22e-50f5-9726-dd1c3b2d2dcd'),
('fdMenuRoleMap', 43, 5, NULL, 1, 0, 0, '', '', 0, 0, 0, 0, 1333438869, 1, 0, 0, 'ef97f5d4-ed91-501f-bdba-9ed8005a3a04'),
('fdMenuRoleMap', 42, 5, NULL, 1, 0, 0, '', '', 0, 0, 0, 0, 1333438869, 1, 0, 0, '72876c67-bc8c-517e-9700-e726d0959c09'),
('fdMenuRoleMap', 41, 5, NULL, 1, 0, 0, '', '', 0, 0, 0, 0, 1333438869, 1, 0, 0, '2a16c48f-1cb9-5a08-81a7-cf8ddb8b1518'),
('fdMenuRoleMap', 91, 5, NULL, 1, 0, 0, '', '', 0, 0, 0, 0, 1333438869, 1, 0, 0, 'd9343ada-d497-5c7b-aee0-899b661f84ec'),
('fdMenuRoleMap', 89, 5, NULL, 1, 0, 0, '', '', 0, 0, 0, 0, 1333438869, 1, 0, 0, 'e894a91f-ebd8-56b8-b4b3-7a35976a7f42'),
('fdMenuRoleMap', 40, 5, NULL, 1, 0, 0, '', '', 0, 0, 0, 0, 1333438869, 1, 0, 0, '8ca29483-7117-595b-9518-28dbe3d7fb75'),
('fdMenuRoleMap', 39, 5, NULL, 1, 0, 0, '', '', 0, 0, 0, 0, 1333438869, 1, 0, 0, '7de7b644-a715-5b64-ac21-4f777d5464be'),
('fdMenuRoleMap', 38, 5, NULL, 1, 0, 0, '', '', 0, 0, 0, 0, 1333438869, 1, 0, 0, 'e610f499-954b-5c3c-b7ca-3acc6fc79820'),
('fdMenuRoleMap', 81, 5, NULL, 1, 0, 0, '', '', 0, 0, 0, 0, 1333438869, 1, 0, 0, '764a3f50-1284-56a8-aa0c-379720d5d881'),
('fdMenuRoleMap', 80, 5, NULL, 1, 0, 0, '', '', 0, 0, 0, 0, 1333438869, 1, 0, 0, 'c4f2c830-ba31-5882-aa51-2e7920525556'),
('fdMenuRoleMap', 37, 5, NULL, 1, 0, 0, '', '', 0, 0, 0, 0, 1333438869, 1, 0, 0, '9fc03f5f-4083-5dc0-b4a8-f651db912741'),
('fdMenuRoleMap', 36, 5, NULL, 1, 0, 0, '', '', 0, 0, 0, 0, 1333438869, 1, 0, 0, 'bbe8b3de-0301-53ee-b644-dcde1c6aefeb'),
('fdMenuRoleMap', 35, 5, NULL, 1, 0, 0, '', '', 0, 0, 0, 0, 1333438869, 1, 0, 0, 'cc5f3b0c-3ecc-5d05-a1d1-ae04c93cb41c'),
('fdMenuRoleMap', 34, 5, NULL, 1, 0, 0, '', '', 0, 0, 0, 0, 1333438869, 1, 0, 0, '96e5e662-d99e-5aa9-9586-de1e205ff635'),
('fdMenuRoleMap', 77, 5, NULL, 1, 0, 0, '', '', 0, 0, 0, 0, 1333438869, 1, 0, 0, 'f3969900-eace-5d24-a44f-cd31cbd04b83'),
('fdMenuRoleMap', 115, 5, NULL, 1, 0, 0, '', '', 0, 0, 0, 0, 1333438869, 1, 0, 0, '7920d4f3-dfc9-5141-9209-ba605cc27cac'),
('fdMenuRoleMap', 114, 5, NULL, 1, 0, 0, '', '', 0, 0, 0, 0, 1333438869, 1, 0, 0, 'bdaa44a1-ac01-5fa3-bf7d-005ea2d775d7'),
('fdMenuRoleMap', 56, 5, NULL, 1, 0, 0, '', '', 0, 0, 0, 0, 1333438869, 1, 0, 0, 'fcdfabfd-352b-5e4b-82db-be637cc05e15'),
('fdMenuRoleMap', 33, 5, NULL, 1, 0, 0, '', '', 0, 0, 0, 0, 1333438869, 1, 0, 0, '09698675-37ba-5c61-8732-75574856f07f'),
('fdMenuRoleMap', 32, 5, NULL, 1, 0, 0, '', '', 0, 0, 0, 0, 1333438869, 1, 0, 0, '84473e6e-64a6-5e33-85e9-eac4876c0819'),
('fdMenuRoleMap', 31, 5, NULL, 1, 0, 0, '', '', 0, 0, 0, 0, 1333438869, 1, 0, 0, 'ce1337b5-cf20-5d36-a480-4a2a5e292d07'),
('fdMenuRoleMap', 30, 5, NULL, 1, 0, 0, '', '', 0, 0, 0, 0, 1333438869, 1, 0, 0, 'fd8affc7-788e-59be-a2cf-5ab642788570'),
('fdMenuRoleMap', 29, 5, NULL, 1, 0, 0, '', '', 0, 0, 0, 0, 1333438869, 1, 0, 0, 'a6ac6e3b-2819-5aae-a144-d35f2ec1a347'),
('fdMenuRoleMap', 28, 5, NULL, 1, 0, 0, '', '', 0, 0, 0, 0, 1333438869, 1, 0, 0, '37b5737b-54ad-56e7-bb53-d2b54c4a1040'),
('fdMenuRoleMap', 27, 5, NULL, 1, 0, 0, '', '', 0, 0, 0, 0, 1333438869, 1, 0, 0, 'f0840253-8d12-511c-b9c6-5bb769f50fda'),
('fdMenuRoleMap', 26, 5, NULL, 1, 0, 0, '', '', 0, 0, 0, 0, 1333438869, 1, 0, 0, 'f1dec06a-e110-5243-b559-ad0e65f2e340'),
('fdMenuRoleMap', 25, 5, NULL, 1, 0, 0, '', '', 0, 0, 0, 0, 1333438869, 1, 0, 0, '1fe52432-64d4-58cd-b52b-550df3825b65'),
('fdMenuRoleMap', 24, 5, NULL, 1, 0, 0, '', '', 0, 0, 0, 0, 1333438869, 1, 0, 0, '3de005d2-2bfa-54e0-b16d-8fbddaa20c14'),
('fdMenuRoleMap', 23, 5, NULL, 1, 0, 0, '', '', 0, 0, 0, 0, 1333438869, 1, 0, 0, '0a66c384-62bb-5ec9-a2b0-3cf42738b111'),
('fdMenuRoleMap', 22, 5, NULL, 1, 0, 0, '', '', 0, 0, 0, 0, 1333438869, 1, 0, 0, '7bba59b1-affa-50ad-a614-b59af4353740'),
('fdMenuRoleMap', 21, 5, NULL, 1, 0, 0, '', '', 0, 0, 0, 0, 1333438869, 1, 0, 0, 'c1fc7097-bcde-5527-b263-f587fa63f93c'),
('fdMenuRoleMap', 20, 5, NULL, 1, 0, 0, '', '', 0, 0, 0, 0, 1333438869, 1, 0, 0, 'cc912a81-2ea1-599f-afa4-1ff42fd89f02'),
('fdMenuRoleMap', 19, 5, NULL, 1, 0, 0, '', '', 0, 0, 0, 0, 1333438869, 1, 0, 0, '0be7562d-6702-56f0-af42-fcf64ede5193'),
('fdMenuRoleMap', 18, 5, NULL, 1, 0, 0, '', '', 0, 0, 0, 0, 1333438869, 1, 0, 0, '7984ec1c-f8be-5333-bbbf-c05e23bff9e1'),
('fdMenuRoleMap', 17, 5, NULL, 1, 0, 0, '', '', 0, 0, 0, 0, 1333438869, 1, 0, 0, 'c821ee1c-4966-5c9c-b8fa-8eb238b3ec51'),
('fdMenuRoleMap', 16, 5, NULL, 1, 0, 0, '', '', 0, 0, 0, 0, 1333438869, 1, 0, 0, 'b07cfb1c-0c45-5b2b-8be7-ffb56ccbf9b5'),
('fdMenuRoleMap', 15, 5, NULL, 1, 0, 0, '', '', 0, 0, 0, 0, 1333438869, 1, 0, 0, 'bba2bd99-8e04-58d6-aae0-a8ef94067798'),
('fdMenuRoleMap', 14, 5, NULL, 1, 0, 0, '', '', 0, 0, 0, 0, 1333438869, 1, 0, 0, 'ad879c1f-5078-5c71-97be-2c431bc3f33d'),
('fdMenuRoleMap', 13, 5, NULL, 1, 0, 0, '', '', 0, 0, 0, 0, 1333438869, 1, 0, 0, 'cbe7a6d8-6f55-56f0-9e11-e164d4e21baf'),
('fdMenuRoleMap', 12, 5, NULL, 1, 0, 0, '', '', 0, 0, 0, 0, 1333438869, 1, 0, 0, '0c126f6f-1e64-5e23-a5f6-05eb45784c99'),
('fdMenuRoleMap', 11, 5, NULL, 1, 0, 0, '', '', 0, 0, 0, 0, 1333438869, 1, 0, 0, '02859712-655e-5185-a214-c34fbcbafd72'),
('fdMenuRoleMap', 10, 5, NULL, 1, 0, 0, '', '', 0, 0, 0, 0, 1333438869, 1, 0, 0, 'b7c36a55-ab9e-5c4b-a597-1a712d1881a4'),
('fdMenuGroupMap', 50, 1, 0, 1, 0, 0, '', '', 0, 0, 0, 0, 1332415778, 37, 0, 0, '76f1c1a6-e640-5bbd-8c0e-7b2e3ae67835'),
('fdMenuGroupMap', 49, 1, 0, 1, 0, 0, '', '', 0, 0, 0, 0, 1332415778, 37, 0, 0, '72dbd67f-3faa-541d-a1a4-61fd4455ceab'),
('fdMenuGroupMap', 76, 1, 0, 1, 0, 0, '', '', 0, 0, 0, 0, 1332415778, 37, 0, 0, '46532de0-26f5-5484-ade0-b271c53ac664'),
('fdMenuGroupMap', 75, 1, 0, 1, 0, 0, '', '', 0, 0, 0, 0, 1332415778, 37, 0, 0, '5c92e767-573c-53c2-9aad-830133d4bbc4'),
('fdMenuGroupMap', 47, 1, 0, 1, 0, 0, '', '', 0, 0, 0, 0, 1332415778, 37, 0, 0, '6000e493-3e56-5c3b-ad45-ea596518dc6f'),
('fdMenuGroupMap', 46, 1, 0, 1, 0, 0, '', '', 0, 0, 0, 0, 1332415778, 37, 0, 0, 'a40ff5f3-e0ba-57a8-b44f-3e6e850b6384'),
('fdMenuGroupMap', 45, 1, 0, 1, 0, 0, '', '', 0, 0, 0, 0, 1332415778, 37, 0, 0, '8c6e9f8a-539c-57d3-9534-ffe763fa6847'),
('fdMenuGroupMap', 44, 1, 0, 1, 0, 0, '', '', 0, 0, 0, 0, 1332415778, 37, 0, 0, '13141c58-ff3f-5dfb-977f-8253007cc75b'),
('fdMenuGroupMap', 34, 1, 0, 1, 0, 0, '', '', 0, 0, 0, 0, 1332415778, 37, 0, 0, 'b3d6f1dd-0f99-55a3-8540-959d2f5ffab1'),
('fdMenuRoleMap', 130, 5, NULL, 1, 0, 0, '', '', 0, 0, 0, 0, 1333438869, 1, 0, 0, '98e5c483-ee39-5c38-8eff-d916ba6f496b'),
('fdMenuRoleMap', 129, 5, NULL, 1, 0, 0, '', '', 0, 0, 0, 0, 1333438869, 1, 0, 0, '2a37b70c-14f6-5365-862f-a3efb9f98aa5'),
('fdMenuGroupMap', 77, 1, 0, 1, 0, 0, '', '', 0, 0, 0, 0, 1332415778, 37, 0, 0, '838b9d35-624f-54f9-89ef-5d7fba1ce8eb'),
('fdMenuGroupMap', 56, 1, 0, 1, 0, 0, '', '', 0, 0, 0, 0, 1332415778, 37, 0, 0, 'ced1e363-b4c3-5495-97eb-6e3bd77e155b'),
('fdMenuGroupMap', 33, 1, 0, 1, 0, 0, '', '', 0, 0, 0, 0, 1332415778, 37, 0, 0, 'cfc012b2-e485-54b4-9c03-ba5fa41a36c7'),
('fdMenuGroupMap', 32, 1, 0, 1, 0, 0, '', '', 0, 0, 0, 0, 1332415778, 37, 0, 0, 'cba84f29-5cdc-5400-883d-2ec8aa91ae04'),
('fdMenuGroupMap', 31, 1, 0, 1, 0, 0, '', '', 0, 0, 0, 0, 1332415778, 37, 0, 0, '96326623-de40-56a1-b8f7-248df6ccbc2a'),
('fdMenuGroupMap', 30, 1, 0, 1, 0, 0, '', '', 0, 0, 0, 0, 1332415778, 37, 0, 0, 'f97210b7-5ad8-510b-bef6-32256e963125'),
('fdMenuGroupMap', 4, 1, 0, 1, 0, 0, '', '', 0, 0, 0, 0, 1332415778, 37, 0, 0, 'b8313f91-8010-5771-8361-31f5c4db7671'),
('fdMenuGroupMap', 3, 1, 0, 1, 0, 0, '', '', 0, 0, 0, 0, 1332415778, 37, 0, 0, '1a93f477-6e16-508b-a319-8a8c515cb836'),
('fdMenuGroupMap', 2, 1, 0, 1, 0, 0, '', '', 0, 0, 0, 0, 1332415778, 37, 0, 0, '425cf220-c7b0-5d13-8b0c-b2c49bb3ec5a'),
('fdMenuGroupMap', 1, 1, 0, 1, 0, 0, '', '', 0, 0, 0, 0, 1332415778, 37, 0, 0, '73826665-e90d-56e7-a5aa-8d1acfb1c40c'),
('fdMenuSubGroupMap', 29, 7, 0, 1, 0, 0, '', '', 0, 0, 0, 0, 1332408072, 1, 0, 0, 'c4b1ec0e-373c-5ebd-9158-0131b18dbb75'),
('fdMenuRoleMap', 124, 5, NULL, 1, 0, 0, '', '', 0, 0, 0, 0, 1333438869, 1, 0, 0, '764c6e16-bee4-5b39-9e5a-6bbc3a76a56b'),
('fdMenuRoleMap', 9, 5, NULL, 1, 0, 0, '', '', 0, 0, 0, 0, 1333438869, 1, 0, 0, 'fbc81e90-0d8f-5c66-ac60-0a222866ded0'),
('fdMenuRoleMap', 123, 5, NULL, 1, 0, 0, '', '', 0, 0, 0, 0, 1333438869, 1, 0, 0, 'be827fa3-4808-57e8-95e2-34a4114ac570'),
('fdMenuRoleMap', 122, 5, NULL, 1, 0, 0, '', '', 0, 0, 0, 0, 1333438869, 1, 0, 0, '60c6ccb1-33c0-5d74-aada-6ae67ee30930'),
('fdMenuRoleMap', 121, 5, NULL, 1, 0, 0, '', '', 0, 0, 0, 0, 1333438869, 1, 0, 0, '71b7cc27-6991-5bbe-88d8-0b3600e6a8a8'),
('fdMenuRoleMap', 118, 5, NULL, 1, 0, 0, '', '', 0, 0, 0, 0, 1333438869, 1, 0, 0, '0436d4a5-fde3-5f9b-a50d-2b1fd02af3e2'),
('fdMenuRoleMap', 8, 5, NULL, 1, 0, 0, '', '', 0, 0, 0, 0, 1333438869, 1, 0, 0, 'fa78495c-a348-51e0-ba59-113af443af45'),
('fdMenuRoleMap', 119, 5, NULL, 1, 0, 0, '', '', 0, 0, 0, 0, 1333438869, 1, 0, 0, 'a13d2ad3-3e62-5ae6-9c83-002ecc4c36da'),
('fdMenuRoleMap', 120, 5, NULL, 1, 0, 0, '', '', 0, 0, 0, 0, 1333438869, 1, 0, 0, '8cc567d0-1fef-57f0-ba09-a6abe9a8808c'),
('fdMenuRoleMap', 5, 5, NULL, 1, 0, 0, '', '', 0, 0, 0, 0, 1333438869, 1, 0, 0, '30f0c61d-fc16-513e-853a-992ed554d8b0'),
('fdMenuRoleMap', 6, 5, NULL, 1, 0, 0, '', '', 0, 0, 0, 0, 1333438869, 1, 0, 0, 'e9c9ceb9-afd8-58f5-bc96-51a292ca6f92'),
('fdMenuRoleMap', 82, 5, NULL, 1, 0, 0, '', '', 0, 0, 0, 0, 1333438869, 1, 0, 0, 'b064906e-32a9-541e-8f32-daf9d3994c0b'),
('fdMenuRoleMap', 126, 5, NULL, 1, 0, 0, '', '', 0, 0, 0, 0, 1333438869, 1, 0, 0, '111ae868-81f8-5f41-b4ff-03031399210c'),
('fdMenuRoleMap', 127, 5, NULL, 1, 0, 0, '', '', 0, 0, 0, 0, 1333438869, 1, 0, 0, 'b6b4ee17-1fc7-50c7-a3e3-781fe9405c60'),
('fdUserBookmark', 1, 42, 6, 1, 0, 0, '', '', 0, 0, 0, 0, 1332486644, 1, 0, 0, '48465b56-5fe2-5b48-b741-3306cf2a618e'),
('fdMenuRoleMap', 131, 5, NULL, 1, 0, 0, '', '', 0, 0, 0, 0, 1333438869, 1, 0, 0, 'be73b5f0-8c54-53f7-b0be-303e927096b7'),
('fdUserBookmark', 1, 62, 7, 1, 0, 0, '', '', 0, 0, 0, 0, 1332486644, 1, 0, 0, '9e8c0905-ce64-5cb0-b94f-845f7bee5ec9'),
('fdUserBookmark', 1, 38, 5, 1, 0, 0, '', '', 0, 0, 0, 0, 1332486644, 1, 0, 0, 'b4cf30ad-e7f5-589a-a04a-b9845f08621f'),
('fdUserBookmark', 1, 39, 4, 1, 0, 0, '', '', 0, 0, 0, 0, 1332486644, 1, 0, 0, '30683cff-4ea1-50aa-b112-e29d3feced55'),
('fdMenuRoleMap', 7, 5, NULL, 1, 0, 0, '', '', 0, 0, 0, 0, 1333438869, 1, 0, 0, 'bdd078da-21fb-5676-8195-c9b4ef5b5cfb'),
('fdUserBookmark', 1, 73, 3, 1, 0, 0, '', '', 0, 0, 0, 0, 1332486644, 1, 0, 0, '0d193b2c-1f6b-58f5-b206-1481e1a3a491'),
('fdMenuRoleMap', 128, 5, NULL, 1, 0, 0, '', '', 0, 0, 0, 0, 1333438869, 1, 0, 0, '6920b759-1901-58cf-bcc5-2ba1d5baf267'),
('fdUserBookmark', 1, 45, 1, 1, 0, 0, '', '', 0, 0, 0, 0, 1332486644, 1, 0, 0, 'fea6183f-470c-5a01-bdd8-023a0f2dc801'),
('fdMenuRoleMap', 117, 5, NULL, 1, 0, 0, '', '', 0, 0, 0, 0, 1333438869, 1, 0, 0, '9b6b9360-8fa4-511e-a914-d2d36ce33057'),
('fdMenuRoleMap', 4, 5, NULL, 1, 0, 0, '', '', 0, 0, 0, 0, 1333438869, 1, 0, 0, 'f07a9894-c90f-5bd6-b49b-3c08d4726ddd'),
('fdAnimalAnimalTypeAnimalColorMap', 1, 1, 2, 1, 0, 0, '', '', 0, 0, 0, 0, 1332486932, 1, 1332488616, 0, '55b2b3e5-4ead-583b-a25f-fbdd68640c1f'),
('fdAnimalAnimalTypeAnimalColorMap', 1, 2, 1, 1, 0, 0, '', '', 0, 0, 0, 0, 1332489823, 1, 0, 0, '6de92922-1a7c-57ba-8be4-21260d4f0110'),
('fdAnimalAnimalTypeAnimalColorMap', 2, 2, 3, 1, 0, 0, '', '', 0, 0, 0, 0, 1332489861, 1, 0, 0, 'c2e47184-bdf6-586e-b017-7d50cb26f3ef'),
('fdAnimalAnimalTypeAnimalColorMap', 9, 4, NULL, 1, 0, 0, '', '', 0, 0, 0, 0, 1332492787, 1, 0, 0, '09f8be89-c645-585a-8855-e058de1405e1'),
('fdAnimalAnimalTypeAnimalColorMap', 10, 4, NULL, 1, 0, 0, '', '', 0, 0, 0, 0, 1332492803, 1, 0, 0, '57dd81b9-ef7b-5cc4-b5b1-84c9e823cd7f'),
('fdAnimalAnimalTypeAnimalColorMap', 9, 4, 4, 1, 0, 0, '', '', 0, 0, 0, 0, 1332492849, 1, 0, 0, '366ef2b3-eabc-5252-84c3-033d3c6bca7c'),
('fdAnimalAnimalTypeAnimalColorMap', 10, 4, 4, 1, 0, 0, '', '', 0, 0, 0, 0, 1332492897, 1, 0, 0, '2ca34749-8553-59ee-a2b6-dce1f96047fc'),
('fdMenuRoleMap', 3, 5, NULL, 1, 0, 0, '', '', 0, 0, 0, 0, 1333438869, 1, 0, 0, 'eadb6dc1-6ce5-5345-831e-a5d5df47576f'),
('fdMenuRoleMap', 2, 5, NULL, 1, 0, 0, '', '', 0, 0, 0, 0, 1333438869, 1, 0, 0, 'c9b59eb9-3892-5d43-8510-da63b9751251'),
('fdAnimalAnimalTypeAnimalColorMap', 2, 2, 5, 1, 0, 0, '', '', 0, 0, 0, 0, 1332494267, 1, 0, 0, '98e1db8b-075b-53cd-a085-135cc4d58ba2'),
('fdUserBookmark', 1, 13, NULL, 1, 0, 0, '', '', 0, 0, 0, 0, 1332931624, 1, 0, 0, '75ad7ee9-5d8d-580e-826a-cb06b39f8bc6'),
('fdMenuRoleMap', 1, 5, NULL, 1, 0, 0, '', '', 0, 0, 0, 0, 1333438869, 1, 0, 0, '8ad9e8ce-7d4f-5b51-bf0d-2983a6f798f4'),
('fdUserBookmark', 1, 9, NULL, 1, 0, 0, '', '', 0, 0, 0, 0, 1332915119, 1, 0, 0, 'e962ade5-3055-5b11-83e1-32cf2e613e80'),
('fdMenuRoleMap', 3, 6, NULL, 1, 0, 0, '', '', 0, 0, 0, 0, 1332833472, 1, 0, 0, '5b1302ea-f5c1-5b3b-a084-018f8b29208a');

-- --------------------------------------------------------

--
-- Table structure for table `system_master`
--

CREATE TABLE IF NOT EXISTS `system_master` (
  `master_code` varchar(50) NOT NULL,
  `master_id` int(10) NOT NULL,
  `master_value` varchar(256) NOT NULL,
  `status` int(1) NOT NULL default '1',
  `intval1` int(10) NOT NULL default '0',
  `intval2` int(10) NOT NULL default '0',
  `strval1` varchar(256) NOT NULL default '',
  `strval2` varchar(256) NOT NULL default '',
  `strval3` varchar(256) NOT NULL,
  `blnval1` tinyint(1) NOT NULL default '0',
  `blnval2` tinyint(1) NOT NULL default '0',
  `dblval1` double NOT NULL default '0',
  `dblval2` double NOT NULL default '0',
  `created_on` bigint(28) NOT NULL,
  `created_by` int(10) NOT NULL,
  `updated_on` bigint(28) NOT NULL,
  `updated_by` bigint(28) NOT NULL,
  `row_guid` varchar(256) NOT NULL,
  `row_version` int(11) NOT NULL,
  KEY `master_code` (`master_code`,`master_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `system_master`
--

INSERT INTO `system_master` (`master_code`, `master_id`, `master_value`, `status`, `intval1`, `intval2`, `strval1`, `strval2`, `strval3`, `blnval1`, `blnval2`, `dblval1`, `dblval2`, `created_on`, `created_by`, `updated_on`, `updated_by`, `row_guid`, `row_version`) VALUES
('fdUserGroup', 1, 'Sales', 1, 0, 0, '', '', '', 0, 0, 0, 0, 1329745308, 1, 1329745430, 1, '83670e5a-9401-5787-beac-7ad73403206d', 1),
('fdUserGroup', 6, 'Management', 1, 0, 0, '', '', 'defaultmenuicon.png', 0, 0, 0, 0, 1330329387, 1, 1332479605, 1, '59dfe7be-12d0-5842-90dc-ed6a2e8526c0', 0),
('fdUserSubGroup', 5, 'Group 1', 1, 0, 0, '', '', '', 0, 0, 0, 0, 1329745450, 1, 1330329194, 1, 'b3178e75-3077-592e-97fc-b2708fc13f45', 5),
('fdUserGroup', 3, 'Production', 1, 0, 0, '', '', '', 0, 0, 0, 0, 1329745587, 1, 1330329345, 1, '6fef0687-0cd5-5184-8318-ce221aa8a8fa', 5),
('fdUserSubGroup', 4, 'Group 2', 1, 0, 0, '', '', '', 0, 0, 0, 0, 1329745337, 1, 1330329199, 1, '7b37c19e-70ed-55b8-b5b4-39d09cc4f00f', 6),
('fdUserRole', 6, 'Administrator', 1, 0, 0, '', '', '', 0, 0, 0, 0, 1329803228, 1, 0, 0, 'c6f06583-7e77-59ca-afd7-4f65c49cd422', 0),
('fdUserRole', 1, 'Sales Executive', 1, 0, 0, '', '', '', 0, 0, 0, 0, 1329745999, 1, 1330329216, 1, '18ab4dd3-42f6-5861-895b-9782100eac01', 2),
('fdUserSubGroup', 13, 'Management', 1, 0, 0, '', '', '', 0, 0, 0, 0, 1330329393, 1, 1330329418, 1, '6b7983af-2a69-5faa-9084-c765d5c7a638', 1),
('fdUserGroup', 5, 'AdminPanel', 1, 0, 0, '', '', '', 0, 0, 0, 0, 1329802668, 1, 1329802708, 1, '679f2d92-0a7f-5eb6-b7ac-c92a3bac5ed0', 2),
('fdUserRole', 4, 'Sales Manager', 1, 0, 0, '', '', '', 0, 0, 0, 0, 1329802470, 1, 1330329236, 1, '9a1fb712-c0ec-5873-af55-a5c84971fec4', 2),
('fdUserSubGroup', 7, 'Administration', 1, 0, 0, '', '', '', 0, 0, 0, 0, 1329802679, 1, 0, 0, 'd0a56851-4ee4-5859-a974-5142d02964f0', 0),
('fdUserRole', 5, 'SuperAdministrator', 1, 0, 0, '', '', '', 0, 0, 0, 0, 1329802690, 1, 1329803246, 1, '0c3d66c2-9144-5ab8-b0e8-7c53da056f1b', 1),
('fdLegends', 2, 'Vertical', 1, 0, 0, '', '', '', 0, 0, 0, 0, 1329807183, 1, 1329807251, 1, 'ea6a1e2e-86cd-567c-bf8f-a0bdbf6676f7', 2),
('fdLegends', 1, 'Geography', 1, 0, 0, '', '', '', 0, 0, 0, 0, 1329807174, 1, 1329807245, 1, '45a807b7-00a1-51e3-a415-7f00af9dd863', 1),
('fdLegends', 3, 'Line Of Sales', 1, 0, 0, '', '', '', 0, 0, 0, 0, 1329807191, 1, 1329807258, 1, '71a52cb8-12f8-5867-b0c4-04cc03720410', 1),
('fdLegendsVal', 1, 'USA', 1, 0, 0, '', '', '', 0, 0, 0, 0, 1329807194, 1, 1329807324, 1, 'cf49dbff-f23b-577f-9470-2fb131b0236e', 1),
('fdLegends', 4, 'Model Of Execution', 1, 0, 0, '', '', '', 0, 0, 0, 0, 1329807272, 1, 0, 0, 'a2eae086-5f3e-50d2-9905-f1536f448a66', 0),
('fdLegendsVal', 4, 'UK', 1, 0, 0, '', '', '', 0, 0, 0, 0, 1329807322, 1, 1329807329, 1, '922a92a9-90d4-561f-a30a-b5df221cb137', 1),
('fdLegendsVal', 5, 'India', 1, 0, 0, '', '', 'defaultmenuicon.png', 0, 0, 0, 0, 1329807332, 1, 1332480403, 1, '5fb1a268-ce8e-5e66-9414-20ade6c47c55', 1),
('fdLegendsVal', 6, 'Accountant a dd', 1, 0, 0, '', '', '', 0, 0, 0, 0, 1329807359, 1, 1331615458, 1, 'fede13e3-7624-52da-9fb4-4309909300b8', 2),
('fdLegendsVal', 7, 'Architect', 1, 0, 0, '', '', '', 0, 0, 0, 0, 1329807362, 1, 1329807371, 1, '16c13ebb-bbba-5810-bc1a-eec995f4f195', 1),
('fdLegendsVal', 8, 'Plumber', 1, 0, 0, '', '', '', 0, 0, 0, 0, 1329807378, 1, 0, 0, '45a9a8e5-cd79-5259-a2da-97bb5f808fb3', 0),
('fdMenu', 48, 'Add Location', 1, 49, 0, '/admin/location/create-location', 'Add Location', 'defaultmenuicon.png', 0, 0, 0, 0, 1331552970, 1, 1332416750, 1, 'bbadc07e-319f-519d-97cf-d44044750703', 1),
('fdMenu', 47, 'Permission Setup', 1, 44, 0, '/security/menu/permission-setup', 'Permission Setup', '', 0, 0, 0, 0, 1331552936, 1, 1331808840, 1, '95f188bd-f6d1-59ce-a6f7-c9228e8e8a6a', 0),
('fdMenu', 46, 'Menu List', 1, 44, 0, '/security/menu/index', 'Menu List', '', 0, 0, 0, 0, 1331552893, 1, 1331894310, 1, 'd1d81b5f-fa8b-52a7-a5fa-7af52f1cdfe3', 0),
('fdMenu', 45, 'Add Menu', 1, 44, 0, '/security/menu/add-menu-item', 'Add Menu', '', 0, 0, 0, 0, 1331552723, 1, 1331808840, 1, '7870bd47-9bdc-5c61-ab3c-d672b0791a19', 0),
('fdMenu', 44, 'Manage Menu', 1, 30, 0, '/security/menu/manage-menu', 'Manage Menu', '', 0, 0, 0, 0, 1331552695, 1, 1331808840, 1, '31b5c89c-c38b-5bbf-8c9d-d39c77faaa36', 0),
('fdMenu', 43, 'Product List', 1, 41, 0, '/admin/product/index', 'Product List', '', 0, 0, 0, 0, 1331552625, 1, 1331808840, 1, 'f1144d54-47e4-5c24-bfa9-e4e11fb2db70', 0),
('fdMenu', 42, 'Add Product', 1, 41, 0, '/admin/product/create-product', 'Add Product', '', 0, 0, 0, 0, 1331552596, 1, 1331808840, 1, 'aa14a909-bf62-5a5e-9284-60fd5bc767b1', 0),
('fdMenu', 41, 'Manage Product', 1, 30, 0, '/mps/app/manage-product', 'Manage Product', '', 0, 0, 0, 0, 1331552571, 1, 1331808840, 1, '61d9ec7d-3012-5907-abf5-deacb2478ff9', 0),
('fdUserSubGroup', 8, 'Incoming Cows', 1, 0, 0, '', '', '', 0, 0, 0, 0, 1330329312, 1, 0, 0, '6d1d03f6-7d1a-5fed-8141-0359d197355c', 0),
('fdUserSubGroup', 9, 'Knocking', 1, 0, 0, '', '', '', 0, 0, 0, 0, 1330329320, 1, 0, 0, '219f4d19-47a0-5cb0-a9db-890f6beaaf82', 0),
('fdUserSubGroup', 10, 'Compliance', 1, 0, 0, '', '', '', 0, 0, 0, 0, 1330329336, 1, 0, 0, '68b83699-adb0-59d3-a899-c7c9e7b06b39', 0),
('fdUserSubGroup', 11, 'Blood Station', 1, 0, 0, '', '', '', 0, 0, 0, 0, 1330329342, 1, 0, 0, '7cb3c7f5-868c-56cb-a9d0-cf224d23c170', 0),
('fdUserSubGroup', 12, 'Weighing', 1, 0, 0, '', '', '', 0, 0, 0, 0, 1330329351, 1, 0, 0, '2d0e462a-178e-5373-adbd-bb79accab78e', 0),
('fdUserRole', 9, 'Technical Head', 1, 0, 0, '', '', '', 0, 0, 0, 0, 1330329429, 1, 1330329437, 1, '7727853e-4ccf-5f10-90a3-4c9ce47375a5', 1),
('fdMenu', 40, 'Customer List', 1, 38, 0, '/admin/customer/index', 'Customer List', 'defaultmenuicon.png', 0, 0, 0, 0, 1331552253, 1, 1332478169, 1, 'da097454-3ac4-5353-bae8-ecc3c7eded9d', 0),
('fdMenu', 39, 'Add Customer', 1, 38, 0, '/admin/customer/create-customer', 'Add Customer', 'defaultmenuicon.png', 0, 0, 0, 0, 1331552204, 1, 1332478137, 1, '0d6930f4-0fdb-5191-b93a-364a42c8b174', 0),
('fdMenu', 38, 'Manage Customer', 1, 30, 0, '/admin/customer/index', 'Manage Customer', 'defaultmenuicon.png', 0, 0, 0, 0, 1331552157, 1, 1332478111, 1, '83f1878a-10d8-52db-907e-ed0c3c87dfe1', 1),
('fdMenu', 37, 'Supplier List', 1, 35, 0, '/admin/supplier/index', 'Supplier List', '', 0, 0, 0, 0, 1331552081, 1, 1331808840, 1, 'f7e75657-d2c1-5a57-ab81-f40eef14a53a', 0),
('fdMenu', 36, 'Add Supplier', 1, 35, 0, '/admin/supplier/create-supplier', 'Add Supplier', '', 0, 0, 0, 0, 1331552033, 1, 1331808840, 1, 'acf05168-ab9a-507d-b725-9f1aa08f4d1d', 0),
('fdMenu', 35, 'Manage Supplier', 1, 30, 0, '/admin/supplier/manage-supplier', 'Manage Supplier', '', 0, 0, 0, 0, 1331551947, 1, 1331808840, 1, '399a111f-1038-53df-8188-bd6c3bac914c', 1),
('fdMenu', 34, 'Change Password', 1, 31, 0, '/security/user/change-password', 'Change Password', '', 0, 0, 0, 0, 1331551896, 1, 1331808840, 1, '7e0bbd12-7743-5c3f-886f-6f4c49f24375', 0),
('fdMenu', 33, 'User List', 1, 31, 0, '/security/user/index', 'User List', '', 0, 0, 0, 0, 1331551870, 1, 1331808840, 1, '51f76f9f-f4b1-5321-a804-bcd3d8f18f81', 0),
('fdMenu', 32, 'Add User', 1, 31, 0, '/security/user/add-new-user', 'Add User', '', 0, 0, 0, 0, 1331551841, 1, 1331808840, 1, '64518222-6bb0-580e-a88c-c490d2cfac46', 0),
('fdMenu', 31, 'Manage User', 1, 30, 0, '/security/user/manage-user', 'Manage User', '', 0, 0, 0, 0, 1331551795, 1, 1331808840, 1, '886a82e6-7abc-5ad0-a44f-c5199bb74108', 1),
('fdMenu', 30, 'System Settings', 1, 0, 0, '/mps/app/system-settings', 'System Settings', '', 0, 0, 0, 0, 1331551670, 1, 1331808840, 1, '989699ec-5af1-5ff1-81b3-3629826cfabf', 0),
('fdMenu', 29, 'Production Report', 1, 25, 0, '/mps/app/production-reports', 'Production Report', '', 0, 0, 0, 0, 1331551632, 1, 1331808840, 1, 'cad92ebf-d9dd-5648-a4ac-dbccd499f855', 0),
('fdMenu', 28, 'Order Status', 1, 25, 0, '/mps/app/order-status', 'Order Status', '', 0, 0, 0, 0, 1331551600, 1, 1331808840, 1, '647520bd-0ede-54c7-94d1-a7fb003b1514', 0),
('fdMenu', 27, 'Cow Status', 1, 25, 0, '/mps/app/cow-status', 'Cow Status', '', 0, 0, 0, 0, 1331551576, 1, 1331808840, 1, '5aca30de-6c6b-5186-a6cc-28a2ad8f7a73', 12),
('fdMenu', 26, 'Scan Production', 1, 25, 0, '/mps/app/scan-production', 'Scan Production', '', 0, 0, 0, 0, 1331551541, 1, 1331808840, 1, '9b5adc85-41bc-543a-80b3-fe93a45f2bd9', 3),
('fdMenu', 25, 'Reports', 1, 1, 0, '/mps/app/reports', 'Reports', '', 0, 0, 0, 0, 1331551515, 1, 1331808840, 1, '1300567c-325b-5c0a-8a62-4f763b1def79', 2),
('fdMenu', 24, 'Pick Order', 1, 23, 0, '/mps/app/pick-order', 'Pick Order', '', 0, 0, 0, 0, 1331551477, 1, 1331808840, 1, '2ec8df55-37db-5077-bfea-9bb337a64494', 0),
('fdMenu', 23, 'Shipping', 1, 1, 0, '/mps/app/shipping', 'Shipping', '', 0, 0, 0, 0, 1331551430, 1, 1331808840, 1, '4f167233-dde9-5ae2-a7ed-057ddb412d76', 0),
('fdMenu', 22, 'Order List', 1, 20, 0, '/mps/app/order-list', 'Order List', '', 0, 0, 0, 0, 1331551403, 1, 1331808840, 1, 'c5527f7f-12c5-53f2-bc5e-e88f62994f6b', 0),
('fdMenu', 21, 'Order Capture', 1, 20, 0, '/mps/app/order-capture', 'Order Capture', '', 0, 0, 0, 0, 1331551384, 1, 1331808840, 1, 'e5c464f9-d530-5ff8-9f3f-68b869ae3a4a', 0),
('fdMenu', 20, 'Order Processing', 1, 1, 0, '/mps/app/order-processing', 'Order Processing', '', 0, 0, 0, 0, 1331551355, 1, 1331808840, 1, '3a22af5d-f559-5d85-a66e-a01adf8f310f', 0),
('fdMenu', 19, 'Office Retail', 1, 1, 0, '/mps/app/office-retail', 'Office Retail', '', 0, 0, 0, 0, 1331551310, 1, 1331808840, 1, 'f41f90ca-eeaa-53ff-8713-fbbedc91fba9', 0),
('fdMenu', 17, 'Combo', 1, 14, 0, '/mps/app/combo', 'Combo', '', 0, 0, 0, 0, 1331551218, 1, 1331808840, 1, 'f283b65b-4445-5f9b-b857-ab81d4018ba5', 0),
('fdMenu', 3, 'Buying', 1, 1, 0, '/mps/buying/buying', 'Buying', 'defaultmenuicon.jpg', 0, 0, 0, 0, 1331550794, 1, 1332937997, 1, '739fdb22-099e-5177-a5d9-425b13912a04', 16),
('fdMenu', 5, 'Production', 1, 1, 0, '/mps/production/index', 'Production', 'defaultmenuicon.jpg', 0, 0, 0, 0, 1331550882, 1, 1332926048, 1, 'e351ef23-6b41-50c7-a089-8ed7fa6f86e9', 5),
('fdMenu', 4, 'Incoming Cows', 1, 3, 0, '/mps/buying/index', 'Incoming Cows', 'IncomingCows.png', 0, 0, 0, 0, 1331550849, 1, 1332933968, 1, '9a76c276-5054-5057-9b53-06cfb8070eb0', 31),
('fdMenu', 1, 'Menu Options', 1, 0, 0, '/mps/app/menu-options', 'Menu Options', 'ManageCustomers_img.png', 0, 0, 0, 0, 1331550695, 1, 1332920098, 1, '6c2fc175-1311-57c9-b30f-99a3dc098fcd', 21),
('fdMenu', 2, 'Dashboard', 1, 1, 0, '/mps/app/dashboard', 'Dashboard', 'Dashboard.png', 0, 0, 0, 0, 1331550724, 1, 1333000987, 1, '773111f7-bb65-595f-98ac-e407917a8760', 55),
('fdMenu', 18, 'Retail Production', 1, 14, 0, '/mps/app/retail-inventory', 'Retail Production', '', 0, 0, 0, 0, 1331551287, 1, 1331808840, 1, '22c97035-22d8-5f8f-b8af-6b3b4c053236', 4),
('fdMenu', 12, 'Billing', 1, 10, 0, '/mps/app/billing', '/mps/app/billing', '', 0, 0, 0, 0, 1331551101, 1, 1331808840, 1, '3608d36d-da68-5bb2-9ce3-3291ef9bdf02', 0),
('fdMenu', 11, 'Pricing', 1, 10, 0, '/mps/app/pricing', 'Pricing', 'InventoryLocation_img.png', 0, 0, 0, 0, 1331551084, 1, 1332503370, 1, '98b15134-7ac2-5d9a-be0e-9e9c6dd83225', 0),
('fdMenu', 10, 'Accounts', 1, 1, 0, '/mps/app/accounts', 'Accounts', '', 0, 0, 0, 0, 1331551024, 1, 1331818974, 1, '6cc5fdd2-eb16-5042-bf92-f35bcdba8852', 2),
('fdMenu', 9, 'Weighing', 1, 5, 0, '/mps/production/weighing', 'Weighing', 'defaultmenuicon.jpg', 0, 0, 0, 0, 1331550986, 1, 1333013078, 1, '4253aaf4-d550-5a96-8855-1cc8309c4de4', 0),
('fdMenu', 8, 'Blood Station', 1, 5, 0, '/mps/production/list-blood-station', 'Blood Station', 'BloodStation.png', 0, 0, 0, 0, 1331550965, 1, 1333001038, 1, '143a3bb6-3fca-56a7-a67b-d6804a161ab9', 0),
('fdMenu', 7, 'Compliance', 1, 5, 0, '/mps/compliance/index', 'Compliance', 'defaultmenuicon.jpg', 0, 0, 0, 0, 1331550942, 1, 1333380478, 1, 'faf80cca-afe1-5e83-acf5-a90067a2a0ed', 0),
('fdMenu', 6, 'Knocking', 1, 5, 0, '/mps/knocking/index', 'Knocking', 'defaultmenuicon.jpg', 0, 0, 0, 0, 1331550911, 1, 1333092778, 1, 'd22babeb-71bb-5865-89d5-2b0993884c98', 0),
('fdMenu', 13, 'Invoicing', 1, 10, 0, '/mps/app/invoicing', 'Invoicing', '', 0, 0, 0, 0, 1331551122, 1, 1331808840, 1, 'b7595c3a-e0aa-5aab-95fb-3424d084dbb7', 0),
('fdMenu', 16, 'Tripe', 1, 14, 0, '/mps/app/tripe', 'Tripe', '', 0, 0, 0, 0, 1331551200, 1, 1331808840, 1, 'f3ba6e30-ca1c-5d5b-a57e-778b25aa39db', 0),
('fdMenu', 15, 'Bone', 1, 14, 0, '/mps/app/bone', 'Bone', '', 0, 0, 0, 0, 1331551179, 1, 1331808840, 1, 'e9e806f2-60d6-5321-b4d7-b7b195b9531f', 2),
('fdMenu', 14, 'Inventory', 1, 1, 0, '/mps/app/inventory', 'Inventory', '', 0, 0, 0, 0, 1331551154, 1, 1331808840, 1, '821bdddf-09a7-532f-bf10-518572214fcf', 0),
('fdMenu', 49, 'Manage Location', 1, 30, 0, '/mps/app/manage-location', 'Manage Location', '', 0, 0, 0, 0, 1331553012, 1, 1331808840, 1, '044f9583-feac-5a73-9fd0-d07a0a00686c', 0),
('fdMenu', 50, 'Location List', 1, 49, 0, '/admin/location/index', 'Location List', 'defaultmenuicon.png', 0, 0, 0, 0, 1331553093, 1, 1332416653, 1, '976a3253-6a16-5523-8663-5f6b07a23098', 0),
('fdMenu', 51, 'Group/Role Setup', 1, 30, 0, '/security/privilege/index', 'Group/Role Setup', '', 0, 0, 0, 0, 1331553133, 1, 1331808840, 1, '4b223d58-b4f8-58cf-8a25-1a18557e30c0', 0),
('fdMenu', 101, 'Remove Legend', 1, 53, 0, '/security/legend/remove', 'Remove Legend', '', 0, 1, 0, 0, 1332480350, 1, 0, 0, '95965529-eb70-5d84-860f-e50657a7c754', 0),
('fdMenu', 53, 'Manage Legends', 1, 30, 0, '/security/legend/index', 'Manage Legends', '', 0, 0, 0, 0, 1331553210, 1, 1331808840, 1, '1f45102d-9d97-5d8f-bc6b-9f3b6dee0f3e', 0),
('fdMenu', 54, 'Manage Cow Profile', 1, 30, 0, '/security/animal/index', 'Manage Cow Profile', '', 0, 0, 0, 0, 1331553242, 1, 1332226209, 1, 'abd8e32e-b4ab-557f-9099-589579b40c45', 0),
('fdMenu', 55, 'Manage Organization', 1, 30, 0, '/admin/organization/index', 'Manage Organization', 'defaultmenuicon.png', 0, 0, 0, 0, 1331553269, 1, 1332480566, 1, '9a90d102-5197-560f-a8fa-61b399f35ed2', 0),
('fdAction', 1, 'Add', 1, 0, 0, '', '', 'defaultmenuicon.jpg', 0, 0, 0, 0, 1331721593, 1, 1332736071, 1, 'ae120080-af76-50dd-b029-4eef78530550', 0),
('fdAction', 2, 'Edit', 1, 0, 0, '', '', 'defaultmenuicon.jpg', 0, 0, 0, 0, 1331724976, 1, 1332736071, 1, '519779eb-eac3-546b-a8b4-55a15d073da7', 0),
('fdAction', 3, 'Delete', 1, 0, 0, '', '', 'defaultmenuicon.jpg', 0, 0, 0, 0, 1331724979, 1, 1332736071, 1, '7ba65512-dbb6-5c9f-9e0a-a31b8acfbcf0', 0),
('fdAction', 4, 'Remove', 1, 0, 0, '', '', 'defaultmenuicon.jpg', 0, 0, 0, 0, 1331724981, 1, 1332736071, 1, '84d18583-5386-5d78-95bd-5ca06066660b', 0),
('fdCity', 16, 'jeet2', 1, 0, 0, '', '', '', 0, 0, 0, 0, 1331806987, 1, 1331879676, 1, '60a146fd-d1e5-5332-9dfb-abba0c15396b', 0),
('fdJeet', 4, 'jeet4', 1, 0, 0, '', '', '', 0, 0, 0, 0, 1331808994, 1, 1331812193, 1, '22489c2a-bfd4-58f0-9d8f-c67ea6914050', 0),
('fdSysMessageCategory', 2, 'Database (used in SP)', 1, 0, 0, '', '', '', 0, 0, 0, 0, 1331809330, 1, 1331818464, 1, '62842b49-5c27-5c9b-bf69-3fb5559565b9', 0),
('fdCountry', 1, 'test', 1, 0, 0, '', '', '', 0, 0, 0, 0, 1331794259, 1, 1331879682, 1, 'ed881d42-1920-5b1c-b795-cea5effa1d5c', 0),
('fdCountry', 2, 'test', 1, 0, 0, '', '', '', 0, 0, 0, 0, 1331794305, 1, 1331879682, 1, 'd6074b4f-573c-5800-aa72-a68a801a734e', 0),
('fdCountry', 3, 'adfasdfsdfasdfa', 1, 0, 0, '', '', '', 0, 0, 0, 0, 1331794342, 1, 1331879682, 1, '8cce2013-1f92-5ba2-ab9b-7a63c42bd85d', 0),
('fdCountry', 4, 'adfasdfsdfasdfa', 1, 0, 0, '', '', '', 0, 0, 0, 0, 1331794441, 1, 1331879682, 1, 'e4a39aa2-983a-5e9a-872f-60a16d09772b', 0),
('fdCountry', 5, 'adfasdfsdfasdfa', 1, 0, 0, '', '', '', 0, 0, 0, 0, 1331794443, 1, 1331879682, 1, 'e527c1f4-f02d-5297-aad0-266f82e192b8', 0),
('fdCountry', 6, 'adfasdfsdfasdfa', 1, 0, 0, '', '', '', 0, 0, 0, 0, 1331794451, 1, 1331879682, 1, '2b71c26b-c045-59f0-8ebf-168ae5f13cba', 0),
('fdCountry', 7, 'sdfsdafa', 1, 0, 0, '', '', '', 0, 0, 0, 0, 1331794762, 1, 1331879682, 1, '96463bc9-341a-5f49-bca2-f8b6bfee65cd', 0),
('fdCountry', 8, 'sdfsdafa', 1, 0, 0, '', '', '', 0, 0, 0, 0, 1331794827, 1, 1331879682, 1, 'e1bce198-9873-5521-96b7-9ba52d89a760', 0),
('fdCountry', 9, 'sdfsdafa', 1, 0, 0, '', '', '', 0, 0, 0, 0, 1331794873, 1, 1331879682, 1, 'bdd27530-8413-5412-9bb7-e057d560d74c', 0),
('fdCountry', 10, 'india', 1, 0, 0, '', '', '', 0, 0, 0, 0, 1331794880, 1, 1331879682, 1, '2cb457c3-7ce4-5d50-b8d4-f46a4e32c6c5', 0),
('fdCountry', 11, 'asdfsadfsda', 1, 0, 0, '', '', '', 0, 0, 0, 0, 1331794886, 1, 1331879682, 1, '4638ecd9-5deb-5f9f-82c3-ea1f40e14294', 0),
('fdCountry', 12, 'asdfsadfsda', 1, 0, 0, '', '', '', 0, 0, 0, 0, 1331794940, 1, 1331879682, 1, '05ed4d37-ebfe-5aac-a39e-92a583bce2de', 0),
('fdCountry', 13, 'rrterterte', 1, 0, 0, '', '', '', 0, 0, 0, 0, 1331795053, 1, 1331879682, 1, '4dd121cc-8fc9-514b-99c0-7759289c58fb', 0),
('fdMenu', 110, 'Rename Animal', 1, 54, 0, '/security/animal/rename', 'Rename Animal', '', 0, 1, 0, 0, 1332482072, 1, 0, 0, '8d58624c-4ce8-52a1-a75c-3c4709652447', 0),
('fdMenu', 107, 'Delete Master Value', 1, 59, 0, '/security/privilege/delete-system-master', 'Delete Master Value', '', 0, 1, 0, 0, 1332481563, 1, 0, 0, 'd6bb75cf-f9ab-5bc2-8608-b51f8c3754ab', 0),
('fdCountry', 14, 'sdfasdfasdfsd', 1, 0, 0, '', '', '', 0, 0, 0, 0, 1331795076, 1, 1331879682, 1, 'db2b86df-7a9b-51bf-bff0-483c9f004755', 0),
('fdCountry', 15, 'asdfsf', 1, 0, 0, '', '', '', 0, 0, 0, 0, 1331795082, 1, 1331879682, 1, '94fe5e33-3f28-5f42-a3e7-e1c9c39edecf', 0),
('fdCountry', 16, 'fsadfasd', 1, 0, 0, '', '', '', 0, 0, 0, 0, 1331795344, 1, 1331879682, 1, '3e0793cb-e6bf-5ede-a01a-23a10e4ddac8', 0),
('fdCountry', 17, 'sadfsadfsadf', 1, 0, 0, '', '', '', 0, 0, 0, 0, 1331795502, 1, 1331879682, 1, '51c71bcc-a9df-5e21-a9b6-b0db5a1d6184', 0),
('fdCountry', 18, 'asdfsdafsd', 1, 0, 0, '', '', '', 0, 0, 0, 0, 1331795506, 1, 1331879682, 1, 'ea98448b-b683-5b42-9d59-2054126d8ae4', 0),
('fdCountry', 19, 'asdfasdf', 1, 0, 0, '', '', '', 0, 0, 0, 0, 1331795510, 1, 1331879682, 1, '1aa7e043-1393-5223-b0de-e62151fdd6b8', 0),
('fdCountry', 20, 'sadfsadfsadsdafasdf', 1, 0, 0, '', '', '', 0, 0, 0, 0, 1331795515, 1, 1331879682, 1, '2609d225-d4b8-57f0-b8fd-31fb13a6e585', 0),
('fdCity', 2, 'Noida', 1, 0, 0, '', '', '', 0, 0, 0, 0, 1331795602, 1, 1331879675, 1, '938aa23e-d8e7-52d0-9e95-216f546221b2', 0),
('fdCity', 3, 'Ghaziabad', 1, 0, 0, '', '', '', 0, 0, 0, 0, 1331795844, 1, 1331879675, 1, '5453890e-25ae-5853-8ec2-39a53bb44c30', 0),
('fdCity', 4, 'allahabad', 1, 0, 0, '', '', '', 0, 0, 0, 0, 1331795881, 1, 1331879675, 1, '37dd7c6d-d4c5-5572-99c0-31be4b7d0a27', 0),
('fdCity', 5, 'allahabad22', 1, 0, 0, '', '', '', 0, 0, 0, 0, 1331796434, 1, 1331879676, 1, '46608c2b-b6ed-5b9d-b22e-31add952278a', 0),
('fdCity', 6, 'allahabad33', 1, 0, 0, '', '', '', 0, 0, 0, 0, 1331796465, 1, 1331879676, 1, '63b7adbf-da60-5e2a-b659-8a6af25c856b', 0),
('fdCity', 7, 'kanpur', 1, 0, 0, '', '', '', 0, 0, 0, 0, 1331798210, 1, 1331879676, 1, 'a0b73ac7-0196-54be-96fa-0e07c952f769', 0),
('fdCity', 8, 'Aligarh', 1, 0, 0, '', '', '', 0, 0, 0, 0, 1331798233, 1, 1331879676, 1, '0bd4a3fe-6865-524f-a964-89b88de44422', 0),
('fdCity', 15, 'asfasdfasdf', 1, 0, 0, '', '', '', 0, 0, 0, 0, 1331804313, 1, 1331879676, 1, 'f2d0d21f-60f2-5571-9b01-4e881f55e232', 0),
('fdSysMessageCategory', 1, 'None', 1, 0, 0, '', '', '', 0, 0, 0, 0, 1331809318, 1, 1331818464, 1, 'bf911fe1-a965-534e-a255-75165b2a6470', 0),
('fdCity', 13, 'Faridabad', 1, 0, 0, '', '', '', 0, 0, 0, 0, 1331798873, 1, 1331879676, 1, '99e481f9-6ceb-5dd0-810c-1385d4c45a03', 0),
('fdCity', 14, 'sfasdf', 1, 0, 0, '', '', '', 0, 0, 0, 0, 1331804310, 1, 1331879676, 1, '8a5fff6c-7f1c-5abe-82c6-57dfd92830e7', 0),
('fdJeet', 3, 'jeet3', 0, 0, 0, '', '', '', 0, 0, 0, 0, 1331808979, 1, 1331812208, 1, '6956437e-796c-546b-8159-1affb83bbee3', 0),
('fdJeet', 2, 'jeet2', 1, 0, 0, '', '', '', 0, 0, 0, 0, 1331808913, 1, 1331808964, 1, 'b389b39d-a562-53ce-bce3-2bb8799e4c2a', 0),
('fdJeet', 1, 'jeet1', 1, 0, 0, '', '', '', 0, 0, 0, 0, 1331808904, 1, 1331808972, 1, '3080e747-5529-577d-82f2-98a7fa424a85', 0),
('fdSysMessageCategory', 3, 'System (used in DAL)', 1, 0, 0, '', '', '', 0, 0, 0, 0, 1331809343, 1, 1331818464, 1, '2ee965d9-6b1f-5b77-bb43-e0682e9e89a8', 0),
('fdSysMessageCategory', 4, 'Application (used in BAL/Page)', 1, 0, 0, '', '', '', 0, 0, 0, 0, 1331809352, 1, 1331818464, 1, 'a2fc71be-e29d-532f-b388-c05949fced76', 0),
('fdSysMessageCategory', 5, 'User (Display on screen)', 1, 0, 0, '', '', '', 0, 0, 0, 0, 1331809359, 1, 1331818464, 1, '88e77b88-3b57-57e6-960e-6ecb7435ffa5', 0),
('fdSysMessageSeverity', 1, 'None', 1, 0, 0, '', '', '', 0, 0, 0, 0, 1331809400, 1, 0, 0, '034da39f-568b-5f4a-bb4b-12fa1aac67b5', 0),
('fdSysMessageSeverity', 2, 'Critical', 1, 0, 0, '', '', '', 0, 0, 0, 0, 1331809404, 1, 0, 0, 'ee255844-a51d-5053-b4ff-4eb643f9d134', 0),
('fdSysMessageSeverity', 3, 'High', 1, 0, 0, '', '', '', 0, 0, 0, 0, 1331809407, 1, 0, 0, '867024c4-391f-519a-a5bd-e3d8252ce4f1', 0),
('fdSysMessageSeverity', 4, 'Medium', 1, 0, 0, '', '', '', 0, 0, 0, 0, 1331809410, 1, 0, 0, '0b408100-2975-5f35-b870-cae4856804f7', 0),
('fdSysMessageSeverity', 5, 'Low', 1, 0, 0, '', '', '', 0, 0, 0, 0, 1331809417, 1, 0, 0, 'd91237ce-e7b5-5b8a-97c3-b85a82ad38ff', 0),
('fdSysMessageType', 1, 'None', 1, 0, 0, '', '', '', 0, 0, 0, 0, 1331809444, 1, 0, 0, 'fff7079a-a963-521b-ac26-17f5fe69aeef', 0),
('fdSysMessageType', 2, 'Error', 1, 0, 0, '', '', '', 0, 0, 0, 0, 1331809448, 1, 0, 0, 'c16b9772-0d15-584d-bd58-8259c13544e0', 0),
('fdSysMessageType', 3, 'Warning', 1, 0, 0, '', '', '', 0, 0, 0, 0, 1331809452, 1, 0, 0, '82113cdb-87ab-56b8-9fd3-787ad821823d', 0),
('fdSysMessageType', 4, 'Information', 1, 0, 0, '', '', '', 0, 0, 0, 0, 1331809456, 1, 0, 0, 'f3111f8d-0c40-512f-94d6-4e0aa9f84c5f', 0),
('fdSysMessageType', 5, 'Debug', 1, 0, 0, '', '', '', 0, 0, 0, 0, 1331809459, 1, 1331809769, 1, '53e6d459-716f-502c-99c2-0ae8af416f3e', 0),
('fdJKtest', 1, 'Value1', 1, 0, 0, '', '', '', 0, 0, 0, 0, 1331809593, 1, 1331879687, 1, '118b2b12-af28-5dcf-aea9-4657887af8d1', 0),
('fdJKtest', 2, 'Value 2', 1, 0, 0, '', '', '', 0, 0, 0, 0, 1331809605, 1, 1331879687, 1, 'fc4f040c-38d1-504d-bac7-1fc9240f8076', 0),
('fdJKtest', 3, 'Value 3', 1, 0, 0, '', '', '', 0, 0, 0, 0, 1331809617, 1, 1331879687, 1, '5f282826-3ca8-59d2-9a72-f1bb6c204837', 0),
('fdJKtest', 4, 'Value 4', 1, 0, 0, '', '', '', 0, 0, 0, 0, 1331809628, 1, 1331879687, 1, '44822ecd-8f48-5b78-9e52-60065c4a254c', 0),
('fdJKtest', 5, 'Value 5', 1, 0, 0, '', '', '', 0, 0, 0, 0, 1331809638, 1, 1331879687, 1, '145dbd18-4fbf-550e-ae4d-3dd63480a6b8', 0),
('fdJKtest', 6, 'Value 66', 1, 0, 0, '', '', '', 0, 0, 0, 0, 1331813041, 1, 1331879687, 1, '9efadfa1-f019-5b9f-96cd-8d17776264a0', 0),
('fdSystemMessageTypell', 1, 'hh', 1, 0, 0, '', '', '', 0, 0, 0, 0, 1331809689, 1, 0, 0, '8995c1ba-ad5c-5151-b80a-59189b15dded', 0),
('fdMenu', 56, 'Edit User', 1, 33, 0, '/security/user/edit-user', 'Edit User', 'defaultmenuicon.png', 0, 1, 0, 0, 1331892544, 1, 1332411198, 1, 'a73aba78-884d-5ae1-9f40-c45fbf0d8608', 0),
('fdMenu', 57, 'Edit Menu', 1, 46, 0, '/security/menu/edit-menu-item', 'Edit Menu', 'defaultmenuicon.png', 0, 1, 0, 0, 1331892910, 1, 1332411209, 1, '8e3dc749-07e5-5f04-8fee-f0688986ce04', 0),
('fdMenu', 58, 'System Master', 1, 30, 0, '/security/privilege/system-master', 'System Master', 'defaultmenuicon.jpg', 0, 0, 0, 0, 1331901168, 1, 1332498948, 1, 'fcec8b5d-3dd6-5fc5-938b-8a6b9b0ec525', 0),
('fdMenu', 59, 'Add/Edit System Master', 1, 58, 0, '/security/privilege/add-system-master', 'Add/Edit System Master', '', 0, 0, 0, 0, 1331901221, 1, 1331901327, 1, 'c8f16366-1123-5cab-b92b-4abb3579b335', 0),
('fdMenu', 60, 'List System Master', 1, 58, 0, '/security/privilege/list-system-master', 'List System Master', '', 0, 0, 0, 0, 1331901258, 1, 1331901334, 1, '67a17c8c-6d0b-5880-83d3-7a03f96a3bde', 0),
('fdMenu', 61, 'System Messages', 1, 30, 0, '/security/sys-message/index', 'System Messages', '', 0, 0, 0, 0, 1331901662, 1, 0, 0, '3116c792-92ca-590f-aec4-8f63365965fe', 0),
('fdMenu', 62, 'Add Messages', 1, 61, 0, '/security/sys-message/add-message', 'Add Messages', '', 0, 0, 0, 0, 1331901723, 1, 0, 0, 'ef53c570-cdd8-5db0-914b-5391ed67b5ec', 0),
('fdMenu', 63, 'Message List', 1, 61, 0, '/security/sys-message/messages', 'Message List', '', 0, 0, 0, 0, 1331901773, 1, 1331901829, 1, 'ada2f9fd-a0a3-5d25-a5e1-6a87beb55a94', 0),
('fdMenu', 64, 'Edit Message', 1, 63, 0, '/security/sys-message/edit-message', 'Edit Message', 'defaultmenuicon.png', 0, 1, 0, 0, 1331901900, 1, 1332411246, 1, 'fd18aef2-1dfa-5d94-9396-c82db2d9d24e', 0),
('fdMenu', 65, 'System Config', 1, 30, 0, '/security/db-config/index', 'System Config', '', 0, 0, 0, 0, 1331901944, 1, 0, 0, '8980bf6d-f5bd-5d2a-b9d2-aa81c81b5531', 0),
('fdMenu', 66, 'Add Config', 1, 65, 0, '/security/sys-config/add-config', 'Add Config', '', 0, 0, 0, 0, 1331901988, 1, 0, 0, 'b928a3e4-5214-5a46-ae13-5163ae6a6f3d', 0),
('fdMenu', 67, 'Config List', 1, 65, 0, '/security/sys-config/index', 'Config List', '', 0, 0, 0, 0, 1331902029, 1, 1331902100, 1, '30b85a16-804e-5fb0-9215-cab9bf4c71d9', 0),
('fdMenu', 68, 'Edit Config', 1, 67, 0, '/security/sys-config/edit-config', 'Edit Config', 'defaultmenuicon.png', 0, 1, 0, 0, 1331902156, 1, 1332482889, 1, '419a1242-5edc-54d0-a798-deb4ef36f14b', 0),
('fdMenu', 69, 'Database Config', 1, 30, 0, '/security/db-config/index', 'Database Config', '', 0, 0, 0, 0, 1331902240, 1, 0, 0, 'a5592e52-76f0-5d2e-b645-7b9e5fbabbbe', 0),
('fdMenu', 70, 'Add Database', 1, 69, 0, '/security/db-config/add-new-db-config', 'Add Database', '', 0, 0, 0, 0, 1331902267, 1, 0, 0, 'ad10401b-619e-5934-8f9f-b41c8d47de8a', 0),
('fdMenu', 71, 'Database List', 1, 69, 0, '/security/db-config/database-configs', 'Database List', '', 0, 0, 0, 0, 1331902299, 1, 0, 0, '317d9a9f-c742-542c-bf0e-5cc2e5a880b0', 0),
('fdMenu', 72, 'Edit Database', 1, 71, 0, '/security/db-config/edit-config', 'Edit Database', 'defaultmenuicon.png', 0, 1, 0, 0, 1331902337, 1, 1332411268, 1, 'c42ef8ca-9462-5420-91fb-7ddb4d0eb1b2', 0),
('fdWidget', 1, 'Production', 1, 0, 0, '', '', '', 0, 0, 0, 0, 1332132548, 1, 1332141450, 1, '96cf9e87-b259-523a-8b61-8d344f555280', 0),
('fdWidget', 2, 'Buying', 1, 0, 0, '', '', '', 0, 0, 0, 0, 1332132623, 1, 1332141450, 1, '14f4f1ee-6b32-53b6-bfe2-12d6cbdc6933', 0),
('fdWidget', 3, 'Order Processing', 1, 0, 0, '', '', '', 0, 0, 0, 0, 1332132644, 1, 1332141450, 1, 'f7e2abdf-60e5-55b6-b042-1b3cd78e3315', 0),
('fdWidget', 4, 'Meat Packing & Fulfilment', 1, 0, 0, '', '', '', 0, 0, 0, 0, 1332132663, 1, 1332141450, 1, '734709bb-0976-56e1-8320-ef9659c41f27', 0),
('fdMenu', 73, 'Widgets', 1, 30, 0, '/admin/widget/manage', 'Widgets', '', 0, 0, 0, 0, 1332133280, 1, 1332133334, 1, 'a37a678f-b5fb-5267-b849-07a29df84d1f', 0),
('fdAnimal', 1, 'Cow 3', 1, 0, 0, '', '', 'defaultmenuicon.png', 0, 0, 0, 0, 1332226024, 1, 1332486501, 1, '2213b9e8-c871-5044-92fd-338058d58de7', 0),
('fdAnimal', 2, 'Bull', 1, 0, 0, '', '', 'defaultmenuicon.png', 0, 0, 0, 0, 1332226036, 1, 1332481236, 1, 'd0fcb412-fb7e-5857-9308-ad3b352fc357', 0),
('fdAnimal', 3, 'Hefe', 1, 0, 0, '', '', 'defaultmenuicon.png', 0, 0, 0, 0, 1332226038, 1, 1332492534, 1, 'd213470d-e1f5-53dc-8c85-97e478d046a9', 0),
('fdAnimal', 4, 'Steer', 1, 0, 0, '', '', 'defaultmenuicon.png', 0, 0, 0, 0, 1332226041, 1, 1332481236, 1, '4a03d5b1-4fb4-517d-a6fa-80dc98d447b9', 0),
('fdMenu', 75, 'Save Permission', 1, 47, 0, '/security/menu/save-permission', 'Save Permission', '', 0, 0, 0, 0, 1332410262, 1, 0, 0, 'c248f837-9825-5584-9767-bbc90975e6d3', 0),
('fdMenu', 76, 'Get Permission', 1, 47, 0, '/security/menu/get-permission', 'Get Permission', '', 0, 0, 0, 0, 1332410304, 1, 0, 0, '41e270a5-6836-5e78-8417-f792eb6ca579', 0),
('fdUserBookmark', 1, 'Quick Bookmark', 1, 0, 0, '', '', '', 0, 0, 0, 0, 1332397819, 1, 0, 0, 'f2988a4b-b903-5fc0-8d0d-92a2592809f8', 0),
('fdAnimal', 6, 'rajput', 1, 0, 0, '', '', 'defaultmenuicon.png', 0, 0, 0, 0, 1332333859, 1, 1332481236, 1, '01d79430-fe20-50f3-a09a-75469317555a', 0),
('fdMenu', 109, 'Get Organization', 1, 102, 0, '/admin/organization/ajax-get-sub-group', 'Get Organization', '', 0, 1, 0, 0, 1332481945, 1, 0, 0, '9f1cead1-59b5-5ac6-8bd6-b3015e1d4bff', 0),
('fdAnimal', 9, 'new animal 2', 1, 0, 0, '', '', 'defaultmenuicon.png', 0, 0, 0, 0, 1332420112, 1, 1332481236, 1, 'b78eea22-1478-5a38-af61-24e1714b71e8', 0),
('fdMenu', 74, 'BookMark', 1, 30, 0, '/admin/bookmark/index', 'Manage Bookmark list', 'defaultmenuicon.png', 0, 0, 0, 0, 1332408179, 1, 1332410149, 1, 'bbdf33dc-fd72-5515-8402-043b3dcc596d', 0),
('fdMenu', 77, 'Change User Status', 1, 33, 0, '/security/user/change-user-status', 'Change User Status', '', 0, 1, 0, 0, 1332415753, 37, 0, 0, 'cc251839-fff7-5af0-9dd5-85f9d0232c57', 0),
('fdMenu', 78, 'Create Animal', 1, 54, 0, '/security/animal/create', 'Create Animal', '', 0, 1, 0, 0, 1332419685, 1, 0, 0, 'ec5ac509-ca97-51fe-9279-1f430d70b0b1', 0),
('fdMenu', 81, 'Edit Supplier', 1, 37, 0, '/admin/supplier/edit-supplier', 'Edit Supplier', '', 0, 1, 0, 0, 1332422795, 1, 0, 0, '6c871afa-3eac-51a8-8cb2-c55bea67fd61', 0),
('fdAnimalType', 3, 'New node', 1, 0, 0, '', '', '', 0, 0, 0, 0, 1332489037, 1, 0, 0, 'f4a91c7e-d6f3-518d-b919-a3fba8de0c5b', 0),
('fdMenu', 79, 'Quick BookMark', 1, 74, 0, '/security/privilege/add-book-mark', 'Quick BookMark', '', 0, 1, 0, 0, 1332422310, 1, 0, 0, 'ba653462-533e-5880-a347-f85e119b5d60', 0),
('fdMenu', 80, 'Change Supplier Status', 1, 37, 0, '/admin/supplier/change-status', 'Change Supplier Status', '', 0, 1, 0, 0, 1332422663, 1, 0, 0, '630cd588-1aaf-505c-abcd-e00947e72a80', 0),
('fdAnimalColor', 3, 'color 4', 1, 0, 0, '', '', 'defaultmenuicon.jpg', 0, 0, 0, 0, 1332489383, 1, 1332489841, 1, '4b5a5256-ff74-582a-aa9b-92e18003764b', 0),
('fdMenu', 82, 'Knocking Popup', 1, 6, 0, '/mps/app/popup-knocking', 'Knocking Popup', 'defaultmenuicon.png', 0, 1, 0, 0, 1332423672, 1, 1332423730, 1, '7071a216-e082-5152-87b1-2fddd8cbe924', 0),
('fdMenu', 83, 'Remove Animal', 1, 54, 0, '/security/animal/remove', 'Remove Animal', '', 0, 1, 0, 0, 1332424233, 1, 0, 0, '9f999787-19fb-5fee-be41-75078548b57b', 0),
('fdAnimalColor', 1, 'color 1', 1, 0, 0, '', '', '', 0, 0, 0, 0, 1332487141, 1, 0, 0, 'f9e2db00-a51c-5dce-86cc-e0a6be449a3d', 0),
('fdAnimalType', 2, 'type 1', 1, 0, 0, '', '', '', 0, 0, 0, 0, 1332487062, 1, 0, 0, '6c8f2cdd-e1f9-5c0c-943c-c62d94c8b4ab', 0),
('fdAnimal', 10, 'new animal 3', 1, 0, 0, '', '', '', 0, 0, 0, 0, 1332486387, 1, 0, 0, '3bfd6435-154f-5be7-8209-cad0f8754d1f', 0),
('fdMenu', 84, 'Edit Bookmark', 1, 74, 0, '/admin/bookmark/edit-bookmark', 'Edit Bookmark', 'defaultmenuicon.jpg', 0, 1, 0, 0, 1332477290, 1, 1332850535, 1, '26adb99a-52cd-5533-a9ae-49908cc7cd27', 0),
('fdMenu', 85, 'Change Menu Status', 1, 46, 0, '/security/menu/change-status', 'Change Menu Status', '', 0, 1, 0, 0, 1332477503, 1, 0, 0, 'b2e85069-e350-50d9-a105-1ddb04aefb5f', 0),
('fdMenu', 86, 'Change Child Status', 1, 46, 0, '/security/menu/change-child-status', 'Change Child Status', '', 0, 1, 0, 0, 1332477568, 1, 0, 0, '2b0e1816-c67c-57b4-adfc-a475690deff1', 0),
('fdMenu', 88, 'Delete Menu Item', 1, 46, 0, '/security/menu/delete-menu-item', 'Delete Menu Item', '', 0, 1, 0, 0, 1332477816, 1, 0, 0, '0eb2c32b-959f-506c-88d6-3d9a981f7e30', 0),
('fdMenu', 89, 'Edit Customer', 1, 40, 0, '/admin/customer/edit-customer', 'Edit Customer', '', 0, 1, 0, 0, 1332478253, 1, 0, 0, '778ec148-7e31-54d3-bfa3-629e44d97821', 0),
('fdMenu', 90, 'Delete Bookmark', 1, 74, 0, '/admin/bookmark/delete-bookmark', 'Delete Bookmark', '', 0, 1, 0, 0, 1332478348, 1, 0, 0, 'fc9cdada-4ce0-5241-8c8d-a068cb022316', 0),
('fdMenu', 91, 'Change Customer Status', 1, 40, 0, '/admin/customer/change-status', 'Change Customer Status', '', 0, 1, 0, 0, 1332478366, 1, 0, 0, '7fa89bab-4ee0-5ec2-afe9-c0f4f049c1d2', 0),
('fdMenu', 92, 'Change Product Status', 1, 43, 0, '/admin/product/change-status', 'Change Product Status', '', 0, 1, 0, 0, 1332478485, 1, 0, 0, '840e2bfe-c921-507e-ba48-f661a872c9e2', 0),
('fdMenu', 93, 'Edit Product', 1, 43, 0, '/admin/product/edit-product', 'Edit Product', '', 0, 1, 0, 0, 1332478581, 1, 0, 0, 'f25c8123-86d0-5597-b29d-5289d4875d32', 0),
('fdMenu', 94, 'Change Location Status', 1, 50, 0, '/admin/location/change-status', 'Change Location Status', '', 0, 1, 0, 0, 1332479008, 1, 0, 0, '13016245-2444-521d-be53-e35e1d19fb35', 0),
('fdMenu', 95, 'Edit Location', 1, 50, 0, '/admin/location/edit-location', 'Edit Location', '', 0, 1, 0, 0, 1332479087, 1, 0, 0, '73e3cf5d-a18d-5395-a3e5-030c6088987a', 0),
('fdMenu', 96, 'Create Privilege', 1, 51, 0, '/security/privilege/create', 'Create Privilege', '', 0, 1, 0, 0, 1332479258, 1, 0, 0, '28e326a1-5f45-5814-b966-12196c238243', 0),
('fdMenu', 99, 'Create Legend', 1, 53, 0, '/security/legend/create', 'Create Legend', '', 0, 1, 0, 0, 1332480285, 1, 0, 0, 'ac44359a-5ec5-5761-b717-41820f2bc91f', 0),
('fdMenu', 100, 'Rename Legend', 1, 53, 0, '/security/legend/rename', 'Rename Legend', '', 0, 1, 0, 0, 1332480325, 1, 0, 0, '03f1a3e1-d4af-5635-9e61-1131412f4998', 0),
('fdMenu', 97, 'Rename Privilege', 1, 51, 0, '/security/privilege/rename', 'Rename Privilege', '', 0, 1, 0, 0, 1332479370, 1, 0, 0, '9034588d-ec92-5997-acf0-c756f78f7bba', 0),
('fdMenu', 98, 'Remove Privilege', 1, 51, 0, '/security/privilege/remove', 'Remove Privilege', '', 0, 1, 0, 0, 1332479423, 1, 0, 0, 'e5819c38-8ccc-547e-9672-e6f392b1fae1', 0),
('fdMenu', 102, 'Add Organization', 1, 55, 0, '/admin/organization/create-organization', 'Add Organization', '', 0, 0, 0, 0, 1332480636, 1, 0, 0, 'cbbe2095-e143-52b1-b0eb-4edb78e6f2b8', 0),
('fdMenu', 112, 'Delete Database Config', 1, 71, 0, '/security/db-config/delete-config', 'Delete Database Config', '', 0, 1, 0, 0, 1332483013, 1, 0, 0, '355ede1f-7cdd-5c1a-a6b5-eec439b40108', 0),
('fdMenu', 111, 'Delete Config', 1, 67, 0, '/security/sys-config/delete-config', 'Delete Config', '', 0, 1, 0, 0, 1332482388, 1, 0, 0, 'beb82176-d8b8-58f3-8e30-f9ca60995c41', 0),
('fdMenu', 105, 'Change Master Status', 1, 60, 0, '/security/privilege/change-status', 'Change Master Status', '', 0, 1, 0, 0, 1332481180, 1, 0, 0, '980f4009-1166-5f20-9897-111f06d48766', 0),
('fdMenu', 108, 'Delete System Message', 1, 63, 0, '/security/sys-message/delete-message', 'Delete System Message', '', 0, 1, 0, 0, 1332481752, 1, 0, 0, 'e0200cd3-25cd-5417-93cb-423a5a8ed271', 0),
('fdMenu', 106, 'Delete System Master', 1, 60, 0, '/security/privilege/delete-system-master-code', 'Delete System Master', '', 0, 1, 0, 0, 1332481388, 1, 0, 0, '347021ab-0f64-52b9-93ea-c2713aac9060', 0),
('fdMenu', 113, 'Save Widget', 1, 73, 0, '/admin/widget/edit-widget', 'Save Widget', '', 0, 1, 0, 0, 1332483110, 1, 0, 0, '4dd7c107-0d76-5e25-b1e2-63ae23d344fe', 0),
('fdAnimalColor', 2, 'color 2', 1, 0, 0, '', '', '', 0, 0, 0, 0, 1332488616, 1, 0, 0, '5f30f750-f63f-5c41-89ee-054b0d79becf', 0),
('fdAnimalType', 1, 'type 2', 1, 0, 0, '', '', 'defaultmenuicon.jpg', 0, 0, 0, 0, 1332486932, 1, 1332486991, 1, '27fd77b7-5b4e-5e5b-ad74-435a3e94fbcb', 0),
('fdAnimalType', 4, 'type1', 1, 0, 0, '', '', '', 0, 0, 0, 0, 1332492787, 1, 0, 0, 'd1f354e2-27c1-59e5-8c5d-0bfa93aa23b9', 0),
('fdAnimalColor', 4, 'c1', 1, 0, 0, '', '', '', 0, 0, 0, 0, 1332492849, 1, 0, 0, '329c94b6-4810-5535-b54f-6acdbcfd22a2', 0),
('fdMenu', 114, 'Get Sub Group', 1, 56, 0, '/security/privilege/ajax-get-sub-group', 'Get Sub Group', 'defaultmenuicon.jpg', 0, 1, 0, 0, 1332493601, 1, 1332493939, 1, '4e89fb7c-49d7-5b07-ba5f-f6db30935780', 0),
('fdMenu', 115, 'Get Role', 1, 56, 0, '/security/privilege/ajax-get-role', 'Get Role', 'defaultmenuicon.jpg', 0, 1, 0, 0, 1332493654, 1, 1332493922, 1, '1f790931-1409-55fc-be16-37aef004578f', 0),
('fdAnimalColor', 5, 'color 5', 1, 0, 0, '', '', '', 0, 0, 0, 0, 1332494267, 1, 0, 0, 'e2a8c4bc-f3d9-5547-b5ab-74f1df12d910', 0),
('fdMenu', 118, 'Edit Blood station process status', 1, 8, 0, '/mps/production/change-blood-process-status', 'Edit Blood station process status', 'defaultmenuicon.jpg', 0, 1, 0, 0, 1332850038, 1, 1333346194, 1, 'de2d3839-143f-5bbe-bcbd-e2113de96419', 0),
('fdMenu', 117, 'Get RawProduct Max ID', 1, 4, 0, '/mps/buying/ajax-get-save-raw-product', 'Get RawProduct Max ID', '', 0, 1, 0, 0, 1332844855, 1, 0, 0, '9d6e063f-a115-5ed1-91a4-961c9b2dac2f', 0),
('fdMenu', 119, 'Save Raw Product', 1, 4, 0, '/mps/buying/ajax-save-raw-product', 'Save Raw Product', '', 0, 1, 0, 0, 1332856438, 1, 0, 0, '28922514-263a-5ed4-a93e-8fd8a969a2eb', 0),
('fdMenu', 120, 'Save Print Raw Product', 1, 4, 0, '/mps/buying/ajax-get-save-print-raw-product', 'Save Print Raw Product', '', 0, 1, 0, 0, 1332861209, 1, 0, 0, 'dc19dac5-85bc-5c15-9539-988ae4d618c1', 0),
('fdCondumnSubStatus', 1, 'Head', 1, 0, 0, '', '', '', 0, 0, 0, 0, 1332906508, 1, 0, 0, '0f785859-7342-54fb-b6c2-8c4ea266df90', 0),
('fdCondumnSubStatus', 2, 'Heart', 1, 0, 0, '', '', '', 0, 0, 0, 0, 1332906518, 1, 0, 0, 'efba3660-deb2-5a66-9af2-2fbc1037a2fd', 0),
('fdCondumnSubStatus', 3, 'Intestines', 1, 0, 0, '', '', '', 0, 0, 0, 0, 1332906549, 1, 0, 0, '8134cd5e-3709-55c1-9a36-a66fc45361c2', 0),
('fdCondumnSubStatus', 4, 'Gut', 1, 0, 0, '', '', '', 0, 0, 0, 0, 1332906560, 1, 0, 0, '9f298146-c1a7-5c8e-9b61-6ee8de26d5d0', 0),
('fdCondumnSubStatus', 5, 'Liver', 1, 0, 0, '', '', '', 0, 0, 0, 0, 1332906571, 1, 0, 0, 'cc535cad-084b-5632-ae79-49c24d93eef2', 0),
('fdCondumnSubStatus', 6, 'Extra Trim Hyde Affected', 1, 0, 0, '', '', '', 0, 0, 0, 0, 1332906604, 1, 0, 0, '7ba422d6-61dd-5e3e-978f-4ade9e9f7f39', 0),
('fdCondumnSubStatus', 7, 'Extra Trim Hyde Not Affected', 1, 0, 0, '', '', '', 0, 0, 0, 0, 1332906632, 1, 0, 0, 'bfd21724-be93-5069-9d0b-0e5ecea0625a', 0),
('fdMenu', 121, 'Edit values of Blood station', 1, 8, 0, '/mps/production/save-blood-station-value', 'Edit values of Blood station', 'defaultmenuicon.jpg', 0, 1, 0, 0, 1332914466, 1, 1333001604, 1, '84cb482d-6780-5ce1-8732-a698377cd434', 0),
('fdMenu', 122, 'Edit condumn value of Blood station', 1, 8, 0, '/mps/production/save-condumn-value', 'Edit condumn value of Blood station', '', 0, 1, 0, 0, 1332919474, 1, 0, 0, 'a2135625-9163-55d5-b84a-9a1a3b447f4d', 0),
('fdMenu', 123, 'Edit Blood Station', 1, 8, 0, '/mps/production/edit-blood-station', 'Edit Blood Station', '', 0, 1, 0, 0, 1332927039, 1, 0, 0, '072f59ad-1001-574e-95cf-0bad9910b52c', 0),
('fdMenu', 124, 'Edit Cow weight', 1, 9, 0, '/mps/production/save-weighing-value', 'Edit Cow weight', '', 0, 1, 0, 0, 1333016856, 1, 0, 0, '2e335898-7dc0-59e3-bc27-ff08a177dce6', 0),
('fdMenu', 129, 'Check Cow ID Exist or Not', 1, 9, 0, '/mps/production/check-cowid', 'Check Cow ID Exist or Not', '', 0, 1, 0, 0, 1333341384, 1, 0, 0, 'd1f34624-8313-506d-a374-41bfd147417d', 0),
('fdMenu', 126, 'Knocking Get Animal Type', 1, 6, 0, '/mps/knocking/ajax-get-animal-type', 'Knocking Get Animal Type', '', 0, 1, 0, 0, 1333031571, 1, 0, 0, '64f61609-8f04-5a5b-93e1-e49cc3a15678', 0),
('fdCondumnStatus', 1, 'Condumn', 1, 0, 0, '', '', '', 0, 0, 0, 0, 1333082972, 1, 0, 0, '68f9114e-2c39-59ec-b2c9-259954e48d7a', 0),
('fdCondumnStatus', 2, 'UnCondumn', 1, 0, 0, '', '', '', 0, 0, 0, 0, 1333082981, 1, 0, 0, 'f74077f4-deed-5290-9d10-36dc3491e41f', 0),
('fdCondumnStatus', 3, 'Retain', 1, 0, 0, '', '', '', 0, 0, 0, 0, 1333082991, 1, 0, 0, '9a186d18-2f70-5bc2-9d9d-77dc425ce06d', 0),
('fdCondumnStatus', 4, 'UnRetain', 1, 0, 0, '', '', '', 0, 0, 0, 0, 1333083000, 1, 0, 0, '9815e54c-fc34-5758-b47c-4166be9e2807', 0),
('fdMenu', 127, 'Knocking Get Animal color', 1, 6, 0, '/mps/knocking/ajax-get-animal-color', 'Knocking Get Animal color', '', 0, 1, 0, 0, 1333086725, 1, 0, 0, 'a45767e6-1167-5f73-95d5-baa027fb4494', 0),
('fdMenu', 128, 'Kill Cow', 1, 6, 0, '/mps/knocking/kill-cow', 'Kill Cow', '', 0, 1, 0, 0, 1333097644, 1, 0, 0, '9d21f0a5-5f27-5e6c-bb40-c7cd7147f9df', 0),
('fdMenu', 130, 'Edit process status', 1, 9, 0, '/mps/production/change-process-status', 'Edit process status', 'defaultmenuicon.jpg', 0, 1, 0, 0, 1333348472, 1, 1333350170, 1, 'eea33038-8d65-562a-93a7-342eb05e67d3', 0),
('fdProcessCode', 1, 'In Yard', 1, 0, 0, '', '', 'defaultmenuicon.jpg', 0, 0, 0, 0, 1333361722, 1, 1333361746, 1, '905e7507-aaeb-50c0-a3af-dfd12940bec9', 0),
('fdProcessCode', 2, 'Killed', 1, 0, 0, '', '', '', 0, 0, 0, 0, 1333361756, 1, 0, 0, '72c50729-fc38-5535-9db9-e45e50efccf1', 0),
('fdProcessCode', 3, 'Compliance', 1, 0, 0, '', '', '', 0, 0, 0, 0, 1333361811, 1, 0, 0, 'eb374faa-a66d-5625-99d4-d02438102c58', 0),
('fdProcessCode', 4, 'Blood Station', 1, 0, 0, '', '', '', 0, 0, 0, 0, 1333361828, 1, 0, 0, '6884f38a-37f6-518d-b13d-9ce280ba864c', 0),
('fdProcessCode', 5, 'Weighing', 1, 0, 0, '', '', '', 0, 0, 0, 0, 1333361842, 1, 0, 0, '0278f7fc-8a26-5e0a-bf03-60fbded88b7c', 0),
('fdMenu', 131, 'Knocking Get Cow Id for Supplier', 1, 6, 0, '/mps/knocking/ajax-get-supplier-cow', 'Knocking Get Cow Id for Supplier', '', 0, 1, 0, 0, 1333363770, 1, 0, 0, '52dc0851-f91f-5758-b068-860a3d5f7256', 0),
('fdMenu', 132, 'Manage Workflow', 1, 30, 0, '/security/workflow/index', 'Manage Workflow', 'AddDatabase.png', 0, 0, 0, 0, 1333430021, 1, 0, 0, '9416e20f-7687-5c24-a74f-21a928a75448', 0),
('fdMenu', 133, 'Add Workflow', 1, 132, 0, '/security/workflow/add-workflow', 'Add Workflow', 'AddOrganization.png', 0, 0, 0, 0, 1333431565, 1, 1333431689, 1, 'af0fe387-d660-5987-9237-2b39f58b1c4a', 0),
('fdMenu', 134, 'Workflow List', 1, 132, 0, '/security/workflow/workflow-list', 'Workflow List', 'MenuList.png', 0, 0, 0, 0, 1333431779, 1, 0, 0, '1a5be416-acef-5056-a342-403a28992413', 0),
('fdMenu', 135, 'Edit Workflow', 1, 134, 0, '/security/workflow/edit-workflow', 'Edit Workflow', 'ProductList.png', 0, 1, 0, 0, 1333433507, 1, 0, 0, 'b90bcf73-1cc3-5ed6-8852-059d33bb6c50', 0),
('fdMenu', 136, 'Delete Workflow', 1, 134, 0, '/security/workflow/delete-workflow', 'Delete Workflow', '', 0, 1, 0, 0, 1333434958, 1, 0, 0, '6d4e102b-f4e6-5487-8337-40bbc646f813', 0),
('fdMenu', 137, 'List Wofkflow Detail', 1, 132, 0, '/security/workflow/list-workflow-detail', 'List Wofkflow Detail', 'LocationList.png', 0, 0, 0, 0, 1333436333, 1, 0, 0, '94fcefcb-d116-5db4-946c-e4dc00148a97', 0),
('fdMenu', 138, 'Add Workflow Detail', 1, 132, 0, '/security/workflow/add-workflow-detail', 'Add Workflow Detail', 'AddSupplier.png', 0, 0, 0, 0, 1333436395, 1, 0, 0, 'c5c048f2-37ad-5b75-b0b7-6121df56aeeb', 0),
('fdMenu', 139, 'Edit Workflow Detail', 1, 137, 0, '/security/workflow/edit-workflow-detail', 'Edit Workflow Detail', 'ScanProduction.png', 0, 1, 0, 0, 1333436475, 1, 0, 0, 'd40e5200-9096-5dc4-8feb-14abbf16479e', 0),
('fdMenu', 140, 'Delete Workflow Detail', 1, 137, 0, '/security/workflow/delete-workflow-detail', 'Delete Workflow Detail', 'UserList.png', 0, 1, 0, 0, 1333436511, 1, 0, 0, '212d109a-2e5f-5e48-9c67-859cf933b247', 0),
('fdMenu', 141, 'Location Mapping', 1, 49, 0, '/admin/location/location-mapping', 'Location Mapping', '', 0, 0, 0, 0, 1333438842, 1, 0, 0, '29232363-a770-5084-b7ad-981cddc2935f', 0);

-- --------------------------------------------------------

--
-- Table structure for table `sys_config`
--

CREATE TABLE IF NOT EXISTS `sys_config` (
  `config_id` int(10) NOT NULL,
  `parent_config_id` int(10) NOT NULL,
  `config_name` varchar(256) NOT NULL,
  `config_desc` varchar(1024) NOT NULL,
  `param1` varchar(256) NOT NULL,
  `param2` varchar(256) NOT NULL,
  `param3` varchar(256) NOT NULL,
  `param4` varchar(256) NOT NULL,
  `param5` varchar(256) NOT NULL,
  `created_on` bigint(28) NOT NULL,
  `updated_on` bigint(28) default NULL,
  `created_by` int(10) NOT NULL,
  `updated_by` int(10) NOT NULL,
  `row_guid` varchar(255) NOT NULL,
  `row_version` int(14) NOT NULL,
  `row_max_id` int(14) NOT NULL,
  PRIMARY KEY  (`config_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sys_config`
--

INSERT INTO `sys_config` (`config_id`, `parent_config_id`, `config_name`, `config_desc`, `param1`, `param2`, `param3`, `param4`, `param5`, `created_on`, `updated_on`, `created_by`, `updated_by`, `row_guid`, `row_version`, `row_max_id`) VALUES
(-2147483648, 30, 'werfewt', 'etertert', 'erter', 'tert', 'erte', 'rter', 'tert', 2012, 0, 1, 0, 'a8bac817-f9bc-5e79-bf74-557b005236bd', 18, 18),
(18, 15, 'test1', 'sdfsdf', '22', '', '', '', '', 1333369622, NULL, 1, 0, 'b46040cc-8627-500d-86b5-58b217d72b46', 0, 0),
(16, 16, 'Bookmark Limit', 'User Menu Bookmark Limit', '15', '', '', '', '', 1332399151, 1332402289, 1, 1, 'ba1889ab-d594-55af-8913-89a186514a7b', 7, 0),
(15, 0, 'Pagination', 'Number of records per page', '25', '22', '55', '22', '55', 1331815651, 1333369320, 1, 1, '78f35d92-01cd-53bf-a9c4-01bc8588896e', 3, 0);

-- --------------------------------------------------------

--
-- Table structure for table `sys_message`
--

CREATE TABLE IF NOT EXISTS `sys_message` (
  `message_id` int(10) NOT NULL,
  `category_id` int(10) NOT NULL,
  `severity_id` int(10) NOT NULL,
  `type_id` int(10) NOT NULL,
  `user_message` varchar(4096) NOT NULL,
  `sys_message` varchar(4096) NOT NULL,
  `created_on` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  `created_by` int(10) NOT NULL,
  `updated_on` timestamp NOT NULL default '0000-00-00 00:00:00',
  `updated_by` int(10) NOT NULL,
  `row_guid` varchar(256) NOT NULL,
  `row_version` int(14) NOT NULL,
  `row_max_id` int(14) NOT NULL,
  PRIMARY KEY  (`message_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sys_message`
--

INSERT INTO `sys_message` (`message_id`, `category_id`, `severity_id`, `type_id`, `user_message`, `sys_message`, `created_on`, `created_by`, `updated_on`, `updated_by`, `row_guid`, `row_version`, `row_max_id`) VALUES
(-2147483648, 7, 4, 4, 'user message2', 'sys message 2', '2012-03-23 05:47:45', 1, '0000-00-00 00:00:00', 0, 'dcc30c2f-55f3-5016-9531-09408c5e05b2', 4, 4),
(9, 6, 3, 2, 'test message1', 'sys message 1', '2012-02-09 23:56:21', 1, '0000-00-00 00:00:00', 0, '854bc398-b5d4-5035-9fd6-9a704ea805af', 0, 0),
(4, 2, 2, 2, 'sdfdasf', 'asdfasdf', '0000-00-00 00:00:00', 1, '0000-00-00 00:00:00', 0, 'e5d56c1b-c0f1-57d7-af4d-1047dce31e65', 0, 0),
(3, 4, 3, 4, 'asdasfd', 'sasaf', '0000-00-00 00:00:00', 1, '0000-00-00 00:00:00', 0, '76ac9b18-f529-599d-bbbe-a853ae0d34fa', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(14) NOT NULL,
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
  `status` int(1) NOT NULL default '1',
  `group_id` int(6) NOT NULL,
  `sub_group_id` int(14) NOT NULL,
  `correspondence_address` text,
  `organization_name` varchar(256) NOT NULL,
  `address1` varchar(256) NOT NULL,
  `address2` varchar(256) NOT NULL,
  `city` varchar(100) NOT NULL,
  `state` varchar(100) NOT NULL,
  `zip` varchar(100) NOT NULL,
  `phone` varchar(100) NOT NULL,
  `fax` varchar(100) NOT NULL,
  `supervisor_id` int(10) NOT NULL,
  `created_on` bigint(28) NOT NULL,
  `updated_on` bigint(28) default NULL,
  `role_id` int(11) default NULL,
  `created_by` int(15) NOT NULL,
  `updated_by` int(15) NOT NULL,
  `row_guid` varchar(255) NOT NULL,
  `row_version` int(14) NOT NULL,
  `row_max_id` int(14) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `email`, `username`, `password`, `first_name`, `middle_name`, `last_name`, `dob`, `sex`, `profile_picture`, `mobile`, `status`, `group_id`, `sub_group_id`, `correspondence_address`, `organization_name`, `address1`, `address2`, `city`, `state`, `zip`, `phone`, `fax`, `supervisor_id`, `created_on`, `updated_on`, `role_id`, `created_by`, `updated_by`, `row_guid`, `row_version`, `row_max_id`) VALUES
(-2147483648, 'ritesh@profitbyoutsourcing.com', 'riteshsahu', 'e10adc3949ba59abbe56e057f20f883e', 'Ritesh', 'Kumar', 'Sahu', '1981-06-15', 'male', 'profile_1.jpg', '9871901519', 1, 1, 4, '95-D, Jagriti Apartment\r\nSector-71\r\nNoida', '', '', '', '', '', '', '', '', 0, 1318838489, 1329199229, 2, 0, 1, '8af4e8d5-6589-50a3-aef1-e415f6d07213', 38, 39),
(1, 'ritesh.sahu@compunnel.com', 'admin', 'e10adc3949ba59abbe56e057f20f883e', 'Riteshsssssss', 'K', 'Sahu', '1981-06-15', 'male', '', '123456454', 1, 5, 7, '', 'test', 'test', 'test', 'tst', 'tt', '34534534', '534534', '534534534', 1, 1328519316, 1331035545, 5, 0, 1, '8af4e8d5-7661-50a3-aef1-e415f6321413', 9, 0),
(6, 'yatendra@compunnel.com', 'yatendra', 'e10adc3949ba59abbe56e057f20f883e', 'Yatendra', '', 'Singh', '2012-02-01', 'male', 'profile_6.jpg', '423423423', 1, 5, 7, '25', 'sdfsdf', 'sdfsd', 'sdfsd', 'asdfasd', 'UP', 'fasdf', 'asdfasdf', 'asdfasdf', 26, 1329465566, 1332421161, 5, 1, 1, '8af4e8d5-7661-50a3-aef1-e415f6d07213', 44, 0),
(25, 'riteshsahdfdfu1981@gmail.com', 'test', 'e10adc3949ba59abbe56e057f20f883e', 'asdfasd', '', 'fasdfasdf', '0000-00-00', 'male', '', '', 1, 1, 4, '0', '', '', '', '', '', '', '', '', 1, 1331023820, 1332415805, 4, 1, 37, 'f7eb9704-6c4b-532c-bc03-a755f9471c74', 10, 0),
(26, 'riteshsahuddd1981@gmail.com', 'test1111111', 'e10adc3949ba59abbe56e057f20f883e', 'tet', '', 'test', '0000-00-00', 'male', '', '', 1, 1, 4, '', 'test', 'test', 'test', 'sfsd', 'fsdfsdfs', '34534534', '534534', '34534534', 1, 1331024660, 1333100177, 4, 1, 1, '08295ef6-0c70-5ab9-95c9-bd0aa5b170d1', 28, 0),
(27, 'riteshsahu1981@gmail.com', '324234234234', 'e9b04702bd3bb084c977b56bff7e1277', '2341324', '', '32141234', '0000-00-00', 'male', '', '', 1, 5, 7, '', '324234234234', '21343214321', '234321412', '234234', '23432141', '23423423', '34234', '234324', 25, 1331107210, 1332506402, 5, 1, 1, 'b2a9e15d-55bf-531a-b6e9-6e83b80763e3', 6, 0),
(28, 'aaaa@test.com', 'dsfsadfasdfas', '5ab842ed3f317bd9ae4fc8f5b20fadfb', 'dsfsadfasdfas', '', 'dsfsadfasdfas', '0000-00-00', 'male', '', '', 1, 5, 7, '', 'dsfsadfasdfas', 'dsfsadfasdfas', 'dsfsadfasdfas', 'dsfsadfasdfas', 'dsfsadfasdfas', '32423424', 'dsfsadfasdfas', 'dsfsadfasdfas', -2147483648, 1331114551, 1332424006, 5, 1, 1, 'e7e401f5-d524-5681-9bbf-7ea0ab7f2ba1', 9, 0),
(39, 'vikash368@gmail.com', 'vikash368', '1c37af94af71d664fdc16ddb48295cbe', 'Vikash', '', 'Rajput', '0000-00-00', 'male', '', '', 1, 1, 5, '', 'Info', 'C-4', 'Sector-58', 'Noida', 'UP', '201307', '954', '99', 6, 1332506346, 1332506429, 1, 1, 1, 'e109e358-d93f-5d65-88b3-1d8d08724eba', 2, 0),
(37, 'ritesh@example.com', 'riteshtest', 'e10adc3949ba59abbe56e057f20f883e', 'riteshtest', '', 'riteshtest', '0000-00-00', 'male', '', '', 1, 1, 5, '', 'riteshtestriteshtest', 'riteshtest', 'riteshtest', 'riteshtest', 'riteshtest', 'riteshtest', 'riteshtest', 'riteshtest', 1, 1332150922, 1333100758, 1, 1, 1, 'd6ed6fa8-ed62-5c7c-b96c-63af99f21051', 3, 0);

-- --------------------------------------------------------

--
-- Table structure for table `user_privilege`
--

CREATE TABLE IF NOT EXISTS `user_privilege` (
  `id` int(11) NOT NULL auto_increment,
  `user_id` int(11) NOT NULL,
  `menu_id` int(11) NOT NULL,
  `screen_id` int(11) NOT NULL,
  `action_id` int(11) NOT NULL,
  `row_guid` int(11) NOT NULL,
  `addedon` int(25) NOT NULL,
  `updatedon` int(25) NOT NULL,
  `created_by` int(25) NOT NULL,
  `updated_by` int(25) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `user_privilege`
--

INSERT INTO `user_privilege` (`id`, `user_id`, `menu_id`, `screen_id`, `action_id`, `row_guid`, `addedon`, `updatedon`, `created_by`, `updated_by`) VALUES
(1, 1, 1, 2, 1, 12121212, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `user_role`
--

CREATE TABLE IF NOT EXISTS `user_role` (
  `id` int(14) NOT NULL auto_increment,
  `identifire` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL,
  `status` enum('active','inactive') NOT NULL default 'active',
  `addedon` int(24) NOT NULL,
  `updatedon` int(24) default NULL,
  `created_by` int(15) NOT NULL,
  `updated_by` int(15) NOT NULL,
  `row_guid` varchar(255) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

--
-- Dumping data for table `user_role`
--

INSERT INTO `user_role` (`id`, `identifire`, `role`, `status`, `addedon`, `updatedon`, `created_by`, `updated_by`, `row_guid`) VALUES
(1, 'employee', 'Employee', 'active', 34234, 1279623199, 0, 0, ''),
(2, 'administrator', 'Administrator', 'active', 435345434, 1273133025, 0, 0, ''),
(3, 'human_resource', 'Human Resource', 'active', 1273133203, 1328610027, 0, 0, ''),
(4, 'project_manager', 'Project Manager', 'active', 432432, 3432432, 0, 0, ''),
(5, 'team_leader', 'Team Leader', 'active', 3453535, 3432423, 0, 0, '');

-- --------------------------------------------------------

--
-- Table structure for table `workflow_detail`
--

CREATE TABLE IF NOT EXISTS `workflow_detail` (
  `id` int(11) NOT NULL,
  `created_on` bigint(28) NOT NULL,
  `updated_on` bigint(28) NOT NULL,
  `created_by` int(14) NOT NULL,
  `updated_by` int(14) NOT NULL,
  `row_guid` varchar(255) NOT NULL,
  `row_version` int(14) NOT NULL,
  `row_max_id` int(14) NOT NULL,
  `workflow_id` int(14) NOT NULL,
  `group_id` int(14) NOT NULL,
  `subgroup_id` int(14) NOT NULL,
  `role_id` int(14) NOT NULL,
  `process_id` int(14) NOT NULL,
  `preceeding_process_id` int(14) NOT NULL,
  `start_status` int(4) NOT NULL,
  `end_status` int(4) NOT NULL,
  `is_deleted` int(1) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `workflow_master`
--

CREATE TABLE IF NOT EXISTS `workflow_master` (
  `id` int(11) NOT NULL,
  `workflow_name` varchar(255) NOT NULL,
  `created_by` int(15) NOT NULL,
  `updated_by` int(15) NOT NULL,
  `row_guid` varchar(255) NOT NULL,
  `row_version` int(14) NOT NULL,
  `row_max_id` int(14) NOT NULL,
  `is_deleted` int(11) NOT NULL,
  `created_on` bigint(28) NOT NULL,
  `updated_on` bigint(28) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `workflow_master`
--

INSERT INTO `workflow_master` (`id`, `workflow_name`, `created_by`, `updated_by`, `row_guid`, `row_version`, `row_max_id`, `is_deleted`, `created_on`, `updated_on`) VALUES
(-2147483648, 'junk', 0, 0, '', 14, 14, 0, 0, 0),
(14, 'Smith Meats', 1, 0, '368e1276-ddb3-53ef-8271-a1368e4ae9db', 0, 0, 0, 1333435368, 0);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
