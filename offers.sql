-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 15, 2020 at 08:09 AM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dawit`
--

-- --------------------------------------------------------

--
-- Table structure for table `offers`
--

DROP TABLE IF EXISTS `offers`;
CREATE TABLE IF NOT EXISTS `offers` (
  `offer_id` int(11) NOT NULL AUTO_INCREMENT,
  `offer_shop` text NOT NULL,
  `offer_text` longtext NOT NULL,
  `offer_button_text` text NOT NULL,
  `offer_color_scheme` text NOT NULL,
  `offer_layout` text NOT NULL,
  `offer_products` longtext NOT NULL,
  `offer_product_image` text NOT NULL,
  `offer_product_title` text NOT NULL,
  `offer_product_price` text NOT NULL,
  `offer_compare_at_price` text NOT NULL,
  `offer_variant_price` text NOT NULL,
  `offer_linked` text NOT NULL,
  `offer_closable` text NOT NULL,
  `offer_quantity_chooser` text NOT NULL,
  `offer_condition_rule` text NOT NULL,
  `offer_conditions` longtext NOT NULL,
  `offer_show_after_accepted` text NOT NULL,
  `offer_required_for_checkout` text NOT NULL,
  `offer_automatically_remove` text NOT NULL,
  `offer_apply_discount` text NOT NULL,
  `offer_discount_code` text NOT NULL,
  `offer_to_checkout` text NOT NULL,
  `offer_ab_text` text NOT NULL,
  `offer_ab_button` text NOT NULL,
  `offer_status` text NOT NULL,
  `offer_date` int(11) NOT NULL,
  `offer_custom_fields` longtext NOT NULL,
  PRIMARY KEY (`offer_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Truncate table before insert `offers`
--

TRUNCATE TABLE `offers`;COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
