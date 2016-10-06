-- phpMyAdmin SQL Dump
-- version 4.5.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Oct 05, 2016 at 04:49 PM
-- Server version: 5.7.11
-- PHP Version: 7.0.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `restaurant`
--

-- --------------------------------------------------------

--
-- Table structure for table `filter`
--

CREATE TABLE `filter` (
  `f_id` int(10) NOT NULL,
  `f_status` int(10) NOT NULL,
  `f_name` varchar(255) NOT NULL,
  `f_type` int(10) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `filter`
--

INSERT INTO `filter` (`f_id`, `f_status`, `f_name`, `f_type`) VALUES
(1, 1, 'filter 1', 1),
(2, 1, 'filter 2', 2),
(3, 1, 'TV', 3);

-- --------------------------------------------------------

--
-- Table structure for table `filter_props`
--

CREATE TABLE `filter_props` (
  `p_id` int(10) NOT NULL,
  `p_status` int(10) NOT NULL,
  `p_filter` int(10) NOT NULL,
  `p_name` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `filter_props`
--

INSERT INTO `filter_props` (`p_id`, `p_status`, `p_filter`, `p_name`) VALUES
(1, 1, 1, 'prop 1 - 1'),
(2, 1, 1, 'prop 1 - 2'),
(3, 1, 2, 'prop 2 - 1'),
(4, 1, 2, 'prop 2 - 2'),
(5, 1, 3, 'yes'),
(6, 1, 3, 'no');

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `i_id` int(10) NOT NULL,
  `i_delete` int(11) NOT NULL,
  `i_status` int(10) NOT NULL,
  `i_name` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`i_id`, `i_delete`, `i_status`, `i_name`) VALUES
(1, 0, 0, '11'),
(2, 0, 0, '22');

-- --------------------------------------------------------

--
-- Table structure for table `items_props`
--

CREATE TABLE `items_props` (
  `ip_id` int(10) NOT NULL,
  `ip_item` int(10) NOT NULL,
  `ip_prop` int(10) NOT NULL,
  `ip_value` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `items_props`
--

INSERT INTO `items_props` (`ip_id`, `ip_item`, `ip_prop`, `ip_value`) VALUES
(10, 2, 5, 'no'),
(2, 1, 2, '1212'),
(3, 1, 3, '1313'),
(4, 1, 4, '1414'),
(5, 2, 1, '2121'),
(9, 1, 5, 'ok'),
(7, 2, 3, '2323'),
(8, 2, 4, '2424');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `filter`
--
ALTER TABLE `filter`
  ADD PRIMARY KEY (`f_id`);

--
-- Indexes for table `filter_props`
--
ALTER TABLE `filter_props`
  ADD PRIMARY KEY (`p_id`);

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`i_id`);

--
-- Indexes for table `items_props`
--
ALTER TABLE `items_props`
  ADD PRIMARY KEY (`ip_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `filter`
--
ALTER TABLE `filter`
  MODIFY `f_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `filter_props`
--
ALTER TABLE `filter_props`
  MODIFY `p_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `i_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `items_props`
--
ALTER TABLE `items_props`
  MODIFY `ip_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
