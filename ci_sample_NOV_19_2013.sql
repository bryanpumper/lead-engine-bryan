-- phpMyAdmin SQL Dump
-- version 3.5.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Nov 20, 2013 at 01:48 AM
-- Server version: 5.5.25a
-- PHP Version: 5.4.4

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `ci_sample`
--

-- --------------------------------------------------------

--
-- Table structure for table `alert_pref_tbl_yle`
--

CREATE TABLE IF NOT EXISTS `alert_pref_tbl_yle` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `alert_name` varchar(50) NOT NULL,
  `alert_types` varchar(50) NOT NULL,
  `alert_desc` varchar(150) NOT NULL,
  `date_created` varchar(50) NOT NULL,
  `date_tracked` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `campaign_tbl_yle`
--

CREATE TABLE IF NOT EXISTS `campaign_tbl_yle` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `campaign_name` varchar(150) NOT NULL,
  `campaign_description` varchar(150) NOT NULL,
  `campaign_type` int(5) NOT NULL,
  `associated_competition` int(20) NOT NULL,
  `campaign_start_date` varchar(50) NOT NULL,
  `campaign_end_date` varchar(50) NOT NULL,
  `campaign_url` varchar(220) NOT NULL,
  `alert_preferences` int(20) NOT NULL,
  `survey_questions` int(20) NOT NULL,
  `offers_creation` varchar(50) NOT NULL,
  `default_emails` varchar(150) NOT NULL,
  `date_created` varchar(50) NOT NULL,
  `date_tracked` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `ci_cookies`
--

CREATE TABLE IF NOT EXISTS `ci_cookies` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cookie_id` varchar(255) DEFAULT NULL,
  `netid` varchar(255) DEFAULT NULL,
  `ip_address` varchar(255) DEFAULT NULL,
  `user_agent` varchar(255) DEFAULT NULL,
  `orig_page_requested` varchar(120) DEFAULT NULL,
  `php_session_id` varchar(40) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `ci_sessions`
--

CREATE TABLE IF NOT EXISTS `ci_sessions` (
  `session_id` varchar(40) NOT NULL DEFAULT '0',
  `ip_address` varchar(45) NOT NULL DEFAULT '0',
  `user_agent` varchar(120) NOT NULL,
  `last_activity` int(10) unsigned NOT NULL DEFAULT '0',
  `user_data` text NOT NULL,
  PRIMARY KEY (`session_id`),
  KEY `last_activity_idx` (`last_activity`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ci_sessions`
--

INSERT INTO `ci_sessions` (`session_id`, `ip_address`, `user_agent`, `last_activity`, `user_data`) VALUES
('60fcb435fbe2bc14d82639f229b39332', '::1', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:25.0) Gecko/20100101 Firefox/25.0', 1384906922, 'a:7:{s:9:"user_data";s:0:"";s:9:"user_name";s:11:"bryanpumper";s:12:"is_logged_in";b:1;s:20:"manufacture_selected";N;s:22:"search_string_selected";N;s:5:"order";N;s:10:"order_type";N;}');

-- --------------------------------------------------------

--
-- Table structure for table `competition_tbl_yle`
--

CREATE TABLE IF NOT EXISTS `competition_tbl_yle` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `compt_name` varchar(150) NOT NULL,
  `logo` varchar(100) NOT NULL,
  `badge_text` varchar(220) NOT NULL,
  `privacy_text` varchar(220) NOT NULL,
  `about_us` varchar(220) NOT NULL,
  `prize_details` varchar(150) NOT NULL,
  `contest_rules` text NOT NULL,
  `website_conditions` varchar(220) NOT NULL,
  `page_link` varchar(150) NOT NULL,
  `date_added` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `competition_tbl_yle`
--

INSERT INTO `competition_tbl_yle` (`id`, `compt_name`, `logo`, `badge_text`, `privacy_text`, `about_us`, `prize_details`, `contest_rules`, `website_conditions`, `page_link`, `date_added`) VALUES
(1, 'Sample Competition', 'sample.png', 'Sample Badge', 'Sample Privacy Text', 'Sample About Us', 'Sample Price Details', 'Sample Contests Rules', 'Sample Website Conditions', 'Sample Page Link', ''),
(2, 'Sample Competition 2', 'sample2.png', 'Sample Badge 2', 'Sample Privacy Text 2', 'Sample About Us 2', 'Sample Price Details 2', 'Sample Contests Rules 2', 'Sample Website Conditions 2', 'Sample Page Link 2', ''),
(4, 'Sample Competition 4', 'sample4.png', 'Sample Badge 4', 'Sample Privacy Text 4', 'Sample About Us 4', 'Sample Price Details 4', 'Sample Contests Rules 4', 'Sample Website Conditions 4', 'Sample Page Link 4', ''),
(5, 'Sample Competition 5', 'sample5.png', 'Sample Badge 5', 'Sample Privacy Text 5', 'Sample About Us 5', 'Sample Price Details 5', 'Sample Contests Rules 5', 'Sample Website Conditions 5', 'Sample Page Link 5', '');

-- --------------------------------------------------------

--
-- Table structure for table `default_email_tbl_yle`
--

CREATE TABLE IF NOT EXISTS `default_email_tbl_yle` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `user_id` int(20) NOT NULL,
  `email_address` varchar(50) NOT NULL,
  `relative_campaign_link` varchar(100) NOT NULL,
  `email_template_preference` int(10) NOT NULL,
  `date_created` varchar(50) NOT NULL,
  `date_tracked` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `email_templates_tbl_yle`
--

CREATE TABLE IF NOT EXISTS `email_templates_tbl_yle` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `template_name` varchar(50) NOT NULL,
  `template_type` int(5) NOT NULL,
  `html_template_location` varchar(100) NOT NULL,
  `template_text` text NOT NULL,
  `date_created` varchar(50) NOT NULL,
  `date_tracked` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table ` leads_table_schema`
--

CREATE TABLE IF NOT EXISTS ` leads_table_schema` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `referral_list` varchar(50) NOT NULL,
  `email_me_your_offer_list` varchar(50) NOT NULL,
  `offer_alert_list` varchar(50) NOT NULL,
  `contact_alert_lists` varchar(50) NOT NULL,
  `unsubscribe_list` varchar(50) NOT NULL,
  `non_qualified_list` varchar(50) NOT NULL,
  `date_added` varchar(50) NOT NULL,
  `date_tracked` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `lifestyle_survey_questions-tbl_yle`
--

CREATE TABLE IF NOT EXISTS `lifestyle_survey_questions-tbl_yle` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `survey_name` varchar(50) NOT NULL,
  `survey_type` varchar(50) NOT NULL,
  `survey_desc` varchar(150) NOT NULL,
  `date_created` varchar(50) NOT NULL,
  `date_tracked` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `manufacturers`
--

CREATE TABLE IF NOT EXISTS `manufacturers` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `manufacturers`
--

INSERT INTO `manufacturers` (`id`, `name`) VALUES
(1, 'Coca Cola'),
(2, 'Hersheys');

-- --------------------------------------------------------

--
-- Table structure for table `membership`
--

CREATE TABLE IF NOT EXISTS `membership` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `email_addres` varchar(255) DEFAULT NULL,
  `user_name` varchar(255) DEFAULT NULL,
  `pass_word` varchar(32) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `membership`
--

INSERT INTO `membership` (`id`, `first_name`, `last_name`, `email_addres`, `user_name`, `pass_word`) VALUES
(1, 'bryan', 'urfano', 'bryan@iquantum.com.au', 'bryanpumper', 'ec723e5591de327369629c9f57250e07');

-- --------------------------------------------------------

--
-- Table structure for table `offers_tbl_yle`
--

CREATE TABLE IF NOT EXISTS `offers_tbl_yle` (
  `id` bigint(20) NOT NULL DEFAULT '0',
  `offer_name` varchar(50) NOT NULL,
  `offer_type` varchar(50) NOT NULL,
  `offer_desc` varchar(150) NOT NULL,
  `date_created` varchar(50) NOT NULL,
  `date_tracked` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE IF NOT EXISTS `products` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `description` varchar(40) DEFAULT NULL,
  `stock` double DEFAULT NULL,
  `cost_price` double DEFAULT NULL,
  `sell_price` double DEFAULT NULL,
  `manufacture_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `description`, `stock`, `cost_price`, `sell_price`, `manufacture_id`) VALUES
(1, 'Coca Cola Bottle', 23, 12, 5, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_plans_yle`
--

CREATE TABLE IF NOT EXISTS `tbl_plans_yle` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) NOT NULL,
  `schedule_title` varchar(150) NOT NULL,
  `free_schedule_30_day_free_trial` varchar(220) NOT NULL,
  `free_schedule_30_standard_plan` varchar(220) NOT NULL,
  `free_schedule_30_pro_plan` varchar(220) NOT NULL,
  `date_added` varchar(50) NOT NULL,
  `date_tracked` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_tier_matrix_yle`
--

CREATE TABLE IF NOT EXISTS `tbl_tier_matrix_yle` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `tier` int(10) NOT NULL,
  `creadits` varchar(10) NOT NULL,
  `monthly_approx_1_month` int(10) NOT NULL,
  `monthly_credit_cost` int(10) NOT NULL,
  `prepay_10_percent_off_approx_6_months` int(10) NOT NULL,
  `prepay_10_percent_off_credit_cost` int(10) NOT NULL,
  `prepay_for_15_percent_off_approx_12_months` int(10) NOT NULL,
  `prepay_for_15_percent_off_credit_cost` int(10) NOT NULL,
  `date_added` varchar(50) NOT NULL,
  `date_tracked` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `user_tbl_yle`
--

CREATE TABLE IF NOT EXISTS `user_tbl_yle` (
  `id` bigint(20) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `user_type` int(5) NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` varchar(30) NOT NULL,
  `age` int(5) NOT NULL,
  `default_email_address` varchar(50) NOT NULL,
  `subscription_level` int(10) NOT NULL,
  `plan_name` varchar(50) NOT NULL,
  `current_credits` int(5) NOT NULL,
  `recurring_bill` int(5) NOT NULL,
  `date_created` varchar(50) NOT NULL,
  `date_tracked` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
