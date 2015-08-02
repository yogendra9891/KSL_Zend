-- phpMyAdmin SQL Dump
-- version 4.0.4.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Oct 09, 2014 at 05:59 AM
-- Server version: 5.5.32
-- PHP Version: 5.4.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `crestorp_zend`
--
CREATE DATABASE IF NOT EXISTS `crestorp_zend` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `crestorp_zend`;

-- --------------------------------------------------------

--
-- Table structure for table `ksl_child_category`
--

CREATE TABLE IF NOT EXISTS `ksl_child_category` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `parent_id` bigint(20) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `created_date` datetime NOT NULL,
  `modified_date` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=15 ;

--
-- Dumping data for table `ksl_child_category`
--

INSERT INTO `ksl_child_category` (`id`, `parent_id`, `title`, `description`, `created_date`, `modified_date`) VALUES
(1, 0, 'child_cat1', 'child_cat1 is heren', '2014-05-13 13:37:12', '2014-05-13 13:37:12'),
(3, 0, 'child_cat3', 'child_cat3 is here.dfsf', '2014-05-13 13:37:33', '2014-05-13 13:37:33'),
(4, 1, 'child_cat4', 'child_cat4 is here.', '2014-05-13 13:41:09', '2014-05-13 13:41:09'),
(5, 1, 'sdad', 'asda', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(10, 0, 'fsdfsdfs', 'sdfs', '2014-05-13 13:38:48', '2014-05-13 13:38:48'),
(11, 2, 'wdas1', 'asdfasadaqw', '2014-05-13 15:40:50', '2014-05-13 14:11:09'),
(12, 3, 'asdad', 'asdfad', '2014-05-13 14:12:31', '2014-05-13 14:12:31'),
(13, 3, 'sub cat check 2', 'sub cat check 2 here.', '2014-05-13 15:05:46', '2014-05-13 15:06:35'),
(14, 3, 'sdsad', 'asdad', '2014-05-13 15:19:57', '2014-05-13 15:19:57');

-- --------------------------------------------------------

--
-- Table structure for table `ksl_parent_category`
--

CREATE TABLE IF NOT EXISTS `ksl_parent_category` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `title` varchar(225) NOT NULL,
  `description` text NOT NULL,
  `created_date` varchar(225) NOT NULL,
  `modified_date` varchar(225) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `ksl_parent_category`
--

INSERT INTO `ksl_parent_category` (`id`, `title`, `description`, `created_date`, `modified_date`) VALUES
(1, 'parent_cat1', 'parent_cat1 description is here.', '', ''),
(2, 'parent_cat2', 'parent_cat2 description is here.', '', ''),
(3, 'par3', 'par3 desc here.', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `ksl_posts`
--

CREATE TABLE IF NOT EXISTS `ksl_posts` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) NOT NULL,
  `category_id` bigint(20) NOT NULL,
  `sub_category_id` bigint(20) NOT NULL,
  `ad_type` int(10) NOT NULL,
  `ad_level` int(10) NOT NULL,
  `title` varchar(255) NOT NULL,
  `short_description` text NOT NULL,
  `description` text NOT NULL,
  `price` decimal(12,2) NOT NULL,
  `contact_name` varchar(255) NOT NULL,
  `contact_email` varchar(255) NOT NULL,
  `contact_phone_home` varchar(20) NOT NULL,
  `contact_phone_work` varchar(20) NOT NULL,
  `contact_phone_cell` varchar(20) NOT NULL,
  `address_1` varchar(255) NOT NULL,
  `address_2` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `state` varchar(255) NOT NULL,
  `is_featured` tinyint(1) NOT NULL,
  `status` int(2) NOT NULL COMMENT '//0=>pending, 1=>publish, 2=>draft',
  `zip` varchar(255) NOT NULL,
  `created_date` datetime NOT NULL,
  `modified_date` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `ksl_posts`
--

INSERT INTO `ksl_posts` (`id`, `user_id`, `category_id`, `sub_category_id`, `ad_type`, `ad_level`, `title`, `short_description`, `description`, `price`, `contact_name`, `contact_email`, `contact_phone_home`, `contact_phone_work`, `contact_phone_cell`, `address_1`, `address_2`, `city`, `state`, `is_featured`, `status`, `zip`, `created_date`, `modified_date`) VALUES
(1, 1, 2, 11, 2, 3, 'testedit', 'short test', 'description', '200.00', 'abhishek', 'ab@gmail.com', '9877141714', '989999999', '9999999999', 'address1', 'address_2', 'delhi', 'state', 1, 2, '122223213222', '2014-05-14 00:00:00', '2014-05-14 14:59:44');

-- --------------------------------------------------------

--
-- Table structure for table `ksl_post_images`
--

CREATE TABLE IF NOT EXISTS `ksl_post_images` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `post_id` bigint(20) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `image` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=22 ;

--
-- Dumping data for table `ksl_post_images`
--

INSERT INTO `ksl_post_images` (`id`, `post_id`, `user_id`, `image`) VALUES
(5, 2, 1, 'Jellyfish.jpg'),
(16, 1, 1, '1400070307photo 2.JPG'),
(21, 1, 1, '1400138461Koala.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `user_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `display_name` varchar(50) DEFAULT NULL,
  `password` varchar(128) NOT NULL,
  `state` smallint(5) unsigned DEFAULT NULL,
  `type` varchar(255) NOT NULL DEFAULT 'guest',
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `username`, `email`, `display_name`, `password`, `state`, `type`) VALUES
(1, 'yogi', 'yogendra.singh@daffodilsw.com', 'yogi', '$2y$14$uVYTlGv1FLX/DdNeAEe74.I.y1uoBw8ukv57wfz9KwVAZzW4CttSC', NULL, 'admin'),
(2, 'abhi', 'abhishek.gupta@gmail.com', 'abhi', '$2y$14$Wod7CvwL0TiU0IBX0uz9pu4ZOzIiM/1sCEkeyTnF4Dn8pStYH91qa', NULL, 'guest'),
(3, 'ankit', 'ankit.jain@daffodilsw.com', 'ankit', '$2y$14$Kqh6xzM4mZJQLoiBoMtWZ.t0Ocekn2f8xWN.T3rHgLy5zTEoduUCy', NULL, 'guest');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
