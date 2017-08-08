-- phpMyAdmin SQL Dump
-- version 4.5.2
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Aug 08, 2017 at 09:38 AM
-- Server version: 10.1.16-MariaDB
-- PHP Version: 5.5.38

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `survey_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_users`
--

CREATE TABLE `admin_users` (
  `user_id` mediumint(15) NOT NULL,
  `first_name` varchar(500) NOT NULL,
  `last_name` varchar(500) NOT NULL,
  `username` varchar(500) NOT NULL,
  `password` varchar(600) NOT NULL,
  `last_login` datetime NOT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ci_sessions`
--

CREATE TABLE `ci_sessions` (
  `session_id` varchar(40) NOT NULL DEFAULT '0',
  `ip_address` varchar(16) NOT NULL DEFAULT '0',
  `user_agent` varchar(50) NOT NULL,
  `last_activity` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `user_data` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `company_master`
--

CREATE TABLE `company_master` (
  `company_id` mediumint(15) NOT NULL,
  `company_name` varchar(500) NOT NULL,
  `email` varchar(500) NOT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `countries_master`
--

CREATE TABLE `countries_master` (
  `id` mediumint(15) NOT NULL,
  `country` varchar(600) NOT NULL,
  `country_code` varchar(50) NOT NULL,
  `latitude` varchar(50) NOT NULL,
  `longitude` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `graph_master`
--

CREATE TABLE `graph_master` (
  `id` mediumint(15) NOT NULL,
  `title` varchar(500) NOT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `menu_items`
--

CREATE TABLE `menu_items` (
  `id` mediumint(15) NOT NULL,
  `menu_name` varchar(500) NOT NULL,
  `menu_controller` varchar(300) NOT NULL,
  `menu_icon` varchar(300) NOT NULL,
  `menu_order` mediumint(15) NOT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `questions_master`
--

CREATE TABLE `questions_master` (
  `q_id` int(11) NOT NULL,
  `question` text NOT NULL,
  `q_type` enum('text','select','textarea','radio','checkbox') NOT NULL DEFAULT 'text',
  `q_option` mediumtext,
  `question_type_id` mediumint(15) NOT NULL,
  `listing_status` char(1) NOT NULL DEFAULT 'Y' COMMENT 'Y-Active,N-Inactive,T-Trashed',
  `snapshot_status` char(1) NOT NULL DEFAULT 'Y',
  `is_required` char(1) NOT NULL DEFAULT 'Y' COMMENT 'Y-Yes, N-No',
  `q_status` char(1) NOT NULL DEFAULT 'Y' COMMENT 'Y-Active,N-Inactive,T-Trashed'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `question_answers`
--

CREATE TABLE `question_answers` (
  `answer_id` mediumint(15) NOT NULL,
  `user_unique_id` varchar(300) NOT NULL,
  `answer` text NOT NULL,
  `map_id` mediumint(15) NOT NULL,
  `submitted_date` date NOT NULL,
  `type` enum('default','top','local','international','first time') NOT NULL DEFAULT 'default'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `question_answers_type_map`
--

CREATE TABLE `question_answers_type_map` (
  `id` mediumint(15) NOT NULL,
  `user_unique_id` varchar(300) NOT NULL,
  `type` enum('top','international','local','first time','vip','repeating','private','government','male','female') NOT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `question_type_master`
--

CREATE TABLE `question_type_master` (
  `id` mediumint(15) NOT NULL,
  `title` varchar(400) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `snapshot_widgets`
--

CREATE TABLE `snapshot_widgets` (
  `id` int(11) NOT NULL,
  `title` varchar(500) NOT NULL,
  `value` varchar(500) NOT NULL,
  `survey_id` mediumint(15) NOT NULL,
  `survey_type_id` mediumint(15) NOT NULL,
  `icon` varchar(30) NOT NULL,
  `color` varchar(30) NOT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `survey_comparison`
--

CREATE TABLE `survey_comparison` (
  `id` mediumint(15) NOT NULL,
  `survey_id` mediumint(15) NOT NULL,
  `survey_type_id` mediumint(15) NOT NULL,
  `comparison_type` enum('top','local','international','first time','vip','repeating','private','government','male','female') NOT NULL,
  `config` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `survey_corelations`
--

CREATE TABLE `survey_corelations` (
  `id` mediumint(15) NOT NULL,
  `survey_id` mediumint(15) NOT NULL,
  `survey_type_id` mediumint(15) NOT NULL,
  `title` varchar(600) NOT NULL,
  `answer_data` text NOT NULL,
  `answer_data_table` text NOT NULL,
  `observations` text NOT NULL,
  `show_index` enum('Y','N') NOT NULL,
  `rating_index_factor` varchar(10) NOT NULL DEFAULT '0',
  `type` enum('single','multiple') NOT NULL DEFAULT 'single',
  `status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `survey_further_insights`
--

CREATE TABLE `survey_further_insights` (
  `id` mediumint(15) NOT NULL,
  `survey_id` mediumint(15) NOT NULL,
  `survey_type_id` mediumint(15) NOT NULL,
  `insights` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `survey_looking_forward`
--

CREATE TABLE `survey_looking_forward` (
  `id` mediumint(15) NOT NULL,
  `survey_id` mediumint(15) NOT NULL,
  `survey_type_id` mediumint(15) NOT NULL,
  `looking_forward` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `survey_master`
--

CREATE TABLE `survey_master` (
  `survey_id` mediumint(15) NOT NULL,
  `survey_name` varchar(500) NOT NULL,
  `survey_logo` varchar(300) NOT NULL,
  `survey_report_logo` varchar(500) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `company_id` mediumint(15) NOT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `survey_menu_map`
--

CREATE TABLE `survey_menu_map` (
  `id` mediumint(15) NOT NULL,
  `survey_id` mediumint(15) NOT NULL,
  `survey_type_id` mediumint(15) NOT NULL,
  `menu_id` mediumint(15) NOT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `survey_previous_backup`
--

CREATE TABLE `survey_previous_backup` (
  `id` mediumint(15) NOT NULL,
  `map_id` mediumint(15) NOT NULL,
  `answer` text NOT NULL,
  `type` enum('default','top','local','international','first time','vip') NOT NULL DEFAULT 'default',
  `value_type` enum('index','percentage') NOT NULL DEFAULT 'index',
  `status` tinyint(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `survey_question_observation`
--

CREATE TABLE `survey_question_observation` (
  `id` mediumint(15) NOT NULL,
  `survey_id` mediumint(15) NOT NULL,
  `survey_type_id` mediumint(15) NOT NULL,
  `question_id` mediumint(15) NOT NULL,
  `observation` text NOT NULL,
  `conclusion` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `survey_type_master`
--

CREATE TABLE `survey_type_master` (
  `survey_type_id` mediumint(15) NOT NULL,
  `title` varchar(500) NOT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `survey_type_question_map`
--

CREATE TABLE `survey_type_question_map` (
  `map_id` mediumint(15) NOT NULL,
  `q_id` mediumint(15) NOT NULL,
  `survey_type_id` mediumint(15) NOT NULL,
  `survey_id` mediumint(15) NOT NULL,
  `question_type_id` mediumint(15) NOT NULL,
  `graph_id` mediumint(15) NOT NULL,
  `snapshot_view_type` enum('graph','table','','') NOT NULL,
  `prev_data_comparison_factor` enum('percentage','index') NOT NULL DEFAULT 'percentage',
  `display_order` mediumint(15) NOT NULL,
  `report_display_order` tinyint(1) NOT NULL,
  `enable_comparison` tinyint(1) NOT NULL,
  `enable_graph` enum('Y','N') NOT NULL DEFAULT 'Y',
  `enable_table` enum('Y','N') NOT NULL DEFAULT 'Y',
  `show_appendix` enum('Y','N') NOT NULL DEFAULT 'N',
  `enable_daily_analysis` enum('Y','N') NOT NULL DEFAULT 'N',
  `enable_demographics` enum('Y','N') NOT NULL DEFAULT 'N',
  `enable_observation` enum('Y','N') NOT NULL DEFAULT 'Y',
  `enable_sorting` enum('Y','N') NOT NULL DEFAULT 'Y',
  `snapshot_listing_status` enum('Y','N') NOT NULL DEFAULT 'N',
  `report_listing_status` enum('Y','N') NOT NULL DEFAULT 'N'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `survey_user_map`
--

CREATE TABLE `survey_user_map` (
  `id` mediumint(15) NOT NULL,
  `survey_id` mediumint(15) NOT NULL,
  `survey_type_id` mediumint(15) NOT NULL,
  `user_id` mediumint(15) NOT NULL,
  `enable_export` enum('Y','N') NOT NULL DEFAULT 'N',
  `report_status` enum('completed','ongoing') NOT NULL DEFAULT 'ongoing'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` mediumint(15) NOT NULL,
  `first_name` varchar(500) NOT NULL,
  `last_name` varchar(500) NOT NULL,
  `username` varchar(500) NOT NULL,
  `password` varchar(500) NOT NULL,
  `email` varchar(500) NOT NULL,
  `contact_number` varchar(300) NOT NULL,
  `designation` varchar(300) NOT NULL,
  `company_id` mediumint(15) NOT NULL,
  `is_admin` tinyint(1) NOT NULL,
  `created_date` datetime NOT NULL,
  `last_login` datetime NOT NULL,
  `logged_out` datetime NOT NULL,
  `login_status` varchar(300) NOT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user_logs`
--

CREATE TABLE `user_logs` (
  `id` mediumint(15) NOT NULL,
  `username` varchar(400) NOT NULL,
  `ip_address` varchar(400) NOT NULL,
  `log_date` datetime NOT NULL,
  `attempt` enum('success','failure') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_users`
--
ALTER TABLE `admin_users`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `ci_sessions`
--
ALTER TABLE `ci_sessions`
  ADD PRIMARY KEY (`session_id`);

--
-- Indexes for table `company_master`
--
ALTER TABLE `company_master`
  ADD PRIMARY KEY (`company_id`);

--
-- Indexes for table `countries_master`
--
ALTER TABLE `countries_master`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `graph_master`
--
ALTER TABLE `graph_master`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `menu_items`
--
ALTER TABLE `menu_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `questions_master`
--
ALTER TABLE `questions_master`
  ADD PRIMARY KEY (`q_id`);

--
-- Indexes for table `question_answers`
--
ALTER TABLE `question_answers`
  ADD PRIMARY KEY (`answer_id`),
  ADD KEY `User Uniqueid` (`user_unique_id`);

--
-- Indexes for table `question_answers_type_map`
--
ALTER TABLE `question_answers_type_map`
  ADD PRIMARY KEY (`id`);
ALTER TABLE `question_answers_type_map` ADD FULLTEXT KEY `User Uniqueid` (`user_unique_id`);

--
-- Indexes for table `question_type_master`
--
ALTER TABLE `question_type_master`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `snapshot_widgets`
--
ALTER TABLE `snapshot_widgets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `survey_comparison`
--
ALTER TABLE `survey_comparison`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `survey_corelations`
--
ALTER TABLE `survey_corelations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `survey_further_insights`
--
ALTER TABLE `survey_further_insights`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `survey_looking_forward`
--
ALTER TABLE `survey_looking_forward`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `survey_master`
--
ALTER TABLE `survey_master`
  ADD PRIMARY KEY (`survey_id`);

--
-- Indexes for table `survey_menu_map`
--
ALTER TABLE `survey_menu_map`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `survey_previous_backup`
--
ALTER TABLE `survey_previous_backup`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `survey_question_observation`
--
ALTER TABLE `survey_question_observation`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `survey_type_master`
--
ALTER TABLE `survey_type_master`
  ADD PRIMARY KEY (`survey_type_id`);

--
-- Indexes for table `survey_type_question_map`
--
ALTER TABLE `survey_type_question_map`
  ADD PRIMARY KEY (`map_id`);

--
-- Indexes for table `survey_user_map`
--
ALTER TABLE `survey_user_map`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `user_logs`
--
ALTER TABLE `user_logs`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_users`
--
ALTER TABLE `admin_users`
  MODIFY `user_id` mediumint(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `company_master`
--
ALTER TABLE `company_master`
  MODIFY `company_id` mediumint(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `countries_master`
--
ALTER TABLE `countries_master`
  MODIFY `id` mediumint(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=239;
--
-- AUTO_INCREMENT for table `graph_master`
--
ALTER TABLE `graph_master`
  MODIFY `id` mediumint(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `menu_items`
--
ALTER TABLE `menu_items`
  MODIFY `id` mediumint(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `questions_master`
--
ALTER TABLE `questions_master`
  MODIFY `q_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=558;
--
-- AUTO_INCREMENT for table `question_answers`
--
ALTER TABLE `question_answers`
  MODIFY `answer_id` mediumint(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=465624;
--
-- AUTO_INCREMENT for table `question_answers_type_map`
--
ALTER TABLE `question_answers_type_map`
  MODIFY `id` mediumint(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23496;
--
-- AUTO_INCREMENT for table `question_type_master`
--
ALTER TABLE `question_type_master`
  MODIFY `id` mediumint(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;
--
-- AUTO_INCREMENT for table `snapshot_widgets`
--
ALTER TABLE `snapshot_widgets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=92;
--
-- AUTO_INCREMENT for table `survey_comparison`
--
ALTER TABLE `survey_comparison`
  MODIFY `id` mediumint(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;
--
-- AUTO_INCREMENT for table `survey_corelations`
--
ALTER TABLE `survey_corelations`
  MODIFY `id` mediumint(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=109;
--
-- AUTO_INCREMENT for table `survey_further_insights`
--
ALTER TABLE `survey_further_insights`
  MODIFY `id` mediumint(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
--
-- AUTO_INCREMENT for table `survey_looking_forward`
--
ALTER TABLE `survey_looking_forward`
  MODIFY `id` mediumint(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `survey_master`
--
ALTER TABLE `survey_master`
  MODIFY `survey_id` mediumint(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `survey_menu_map`
--
ALTER TABLE `survey_menu_map`
  MODIFY `id` mediumint(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=187;
--
-- AUTO_INCREMENT for table `survey_previous_backup`
--
ALTER TABLE `survey_previous_backup`
  MODIFY `id` mediumint(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=245;
--
-- AUTO_INCREMENT for table `survey_question_observation`
--
ALTER TABLE `survey_question_observation`
  MODIFY `id` mediumint(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=392;
--
-- AUTO_INCREMENT for table `survey_type_master`
--
ALTER TABLE `survey_type_master`
  MODIFY `survey_type_id` mediumint(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `survey_type_question_map`
--
ALTER TABLE `survey_type_question_map`
  MODIFY `map_id` mediumint(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=756;
--
-- AUTO_INCREMENT for table `survey_user_map`
--
ALTER TABLE `survey_user_map`
  MODIFY `id` mediumint(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` mediumint(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `user_logs`
--
ALTER TABLE `user_logs`
  MODIFY `id` mediumint(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1586;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
