-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 01, 2024 at 06:49 AM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 7.4.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pcad_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `m_final_process`
--

CREATE TABLE `m_final_process` (
  `id` int(10) UNSIGNED NOT NULL,
  `final_process` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_updated` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `m_final_process`
--

INSERT INTO `m_final_process` (`id`, `final_process`, `date_updated`) VALUES
(1, 'QA', '2024-02-01 13:28:58'),
(2, 'Appearance', '2024-02-01 13:28:58'),
(3, 'Dimension', '2024-02-01 13:28:58'),
(4, 'ECT', '2024-02-01 13:28:58'),
(5, 'Clamp Checking', '2024-02-01 13:29:16');

-- --------------------------------------------------------

--
-- Table structure for table `m_ircs_line`
--

CREATE TABLE `m_ircs_line` (
  `id` int(11) UNSIGNED NOT NULL,
  `line_no` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ircs_line` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `andon_line` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `final_process` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ip` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_updated` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `m_ircs_line`
--

INSERT INTO `m_ircs_line` (`id`, `line_no`, `ircs_line`, `andon_line`, `final_process`, `ip`, `date_updated`) VALUES
(1, '6101', 'NISSAN_01', '', '', '', '2024-02-01 13:22:04'),
(2, '6102', 'NISSAN_02', '', '', '', '2024-02-01 13:22:04'),
(3, '6103', 'NISSAN_03', '', '', '', '2024-02-01 13:22:04'),
(4, '3110', 'HONDA_10', '', '', '', '2024-02-01 13:22:04'),
(5, '2107', 'DAIHATSU_07', '', '', '', '2024-02-01 13:22:04'),
(6, '1115', 'MAZDA_15', '', '', '', '2024-02-01 13:22:04'),
(7, '1130', 'MAZDA_30', '', '', '', '2024-02-01 13:22:04'),
(8, '2102', 'DAIHATSU_02', '', '', '', '2024-02-01 13:22:04'),
(9, '3107', 'HONDA_05', '', '', '', '2024-02-01 13:22:04'),
(14, '1032', 'MAZDA_53', '', '', '', '2024-02-01 13:22:04'),
(15, '5105', 'SUZUKI_04', '', '', '', '2024-02-01 13:22:04'),
(16, '5006', 'SUZUKI_24', '', '', '', '2024-02-01 13:22:04'),
(17, '5108', 'SUZUKI_12', '', '', '', '2024-02-01 13:22:04'),
(18, '5110', 'SUZUKI_19', '', '', '', '2024-02-01 13:22:04'),
(19, '5111', 'SUZUKI_20', '', '', '', '2024-02-01 13:22:04'),
(20, '5112', 'SUZUKI_21', '', '', '', '2024-02-01 13:22:04'),
(21, '5015', 'SUZUKI_33', '', '', '', '2024-02-01 13:22:04'),
(22, '5121', 'SUZUKI_51', '', '', '', '2024-02-01 13:22:04'),
(23, '5022', 'SUZUKI_54', '', '', '', '2024-02-01 13:22:04'),
(24, '5101', 'SUZUKI_01', '', '', '172.25.119.133', '2024-02-01 13:22:04'),
(25, '1033', 'MAZDA_67', '', '', '172.25.113.196', '2024-02-01 13:22:04'),
(26, '1033', 'MAZDA_65', '', '', '172.25.113.246', '2024-02-01 13:22:04'),
(27, '1033', 'MAZDA_60', '', '', '172.25.113.198', '2024-02-01 13:22:04'),
(28, '1033', 'MAZDA_59', '', '', '172.25.115.251', '2024-02-01 13:22:04'),
(29, '1033', 'MAZDA_61', '', '', '172.25.115.60', '2024-02-01 13:22:04'),
(30, '1033', 'MAZDA_62', '', '', '172.25.113.218', '2024-02-01 13:22:04'),
(31, '1033', 'MAZDA_64', '', '', '172.25.113.197', '2024-02-01 13:22:04'),
(32, '1034', 'MAZDA_66', '', '', '172.25.115.65', '2024-02-01 13:22:04'),
(35, '5031', 'SUZUKI_73', '', '', '172.25.114.186', '2024-02-01 13:22:04'),
(36, '5031', 'SUZUKI_67', '', '', '172.25.115.244', '2024-02-01 13:22:04'),
(45, '3037', 'HONDA_49', '', '', '172.25.167.62', '2024-02-01 13:22:04'),
(49, '3135', 'HONDA_47_3', '', '', '172.25.165.66', '2024-02-01 13:22:04'),
(53, '7110', 'SUBARU_05_App', '', '', '172.25.167.28', '2024-02-01 13:22:04'),
(61, '5130', 'SUZUKI_70', '', '', '172.25.115.154', '2024-02-01 13:22:04'),
(62, '5132', 'SUZUKI_71', '', '', '172.25.115.102', '2024-02-01 13:22:04'),
(69, '3140', 'HONDA_48', '', '', '172.25.161.80', '2024-02-01 13:22:04'),
(70, '3142', 'HONDA_50', '', '', '172.25.167.121', '2024-02-01 13:22:04'),
(71, '3138', 'HONDA_40', '', '', '172.25.167.85', '2024-02-01 13:22:04'),
(72, '3043', 'HONDA_41', '', '', '172.25.161.128', '2024-02-01 13:22:04'),
(73, '3043', 'HONDA_51', '', '', '172.25.161.148', '2024-02-01 13:22:04'),
(74, '3043', 'HONDA_52', '', '', '172.25.161.123', '2024-02-01 13:22:04'),
(75, '3043', 'HONDA_42', '', '', '172.25.161.120', '2024-02-01 13:22:04'),
(78, '7111', 'SUBARU_02', '', '', '172.25.165.29', '2024-02-01 13:22:04'),
(79, '3129', 'HONDA_32', '', '', '172.25.165.128', '2024-02-01 13:22:04'),
(82, '3125', 'HONDA_34', '', '', '172.25.165.103', '2024-02-01 13:22:04'),
(83, '3139', 'HONDA_40_2', '', '', '172.25.161.75', '2024-02-01 13:22:04'),
(84, '3141', 'HONDA_53', '', '', '172.25.167.135', '2024-02-01 13:22:04'),
(85, '3124', 'HONDA_35', '', '', '172.25.165.122', '2024-02-01 13:22:04'),
(86, '5133', 'SUZUKI_77', '', '', '172.25.113.214', '2024-02-01 13:22:04'),
(89, '5031', 'SUZUKI_78', '', '', '172.25.113.146', '2024-02-01 13:22:04'),
(90, '3123', 'HONDA_36', '', '', '172.25.165.118', '2024-02-01 13:22:04'),
(93, '7121', 'SUBARU_09', '', '', '172.25.165.148', '2024-02-01 13:22:04'),
(96, '5136', 'SUZUKI_75', '', '', '172.25.113.83', '2024-02-01 13:22:04'),
(97, '3144', 'HONDA_47_5', '', '', '172.25.166.45', '2024-02-01 13:22:04'),
(98, '7122', 'SUBARU_10', '', '', '172.25.161.105', '2024-02-01 13:22:04'),
(99, '3127', 'HONDA_33', '', '', '172.25.165.165', '2024-02-01 13:22:04'),
(104, '7119', 'SUBARU_08_1', '', '', '172.25.167.226', '2024-02-01 13:22:04'),
(108, '7104', 'SUBARU_04', '', '', '172.25.167.129', '2024-02-01 13:22:04'),
(110, '7120', 'SUBARU_08_2', '', '', '172.25.167.39', '2024-02-01 13:22:04'),
(118, '3145', 'HONDA_58', '', '', '172.25.161.106', '2024-02-01 13:22:04'),
(119, '7101', 'SUBARU_04_1', '', '', '172.25.165.18', '2024-02-01 13:22:04'),
(120, '2117', 'DAIHATSU_16', '', '', '172.25.161.141', '2024-02-01 13:22:04'),
(121, '3133', 'HONDA_47_1', '', '', '172.25.165.57', '2024-02-01 13:22:04'),
(125, '7109', 'SUBARU_05', '', '', '172.25.165.27', '2024-02-01 13:22:04'),
(129, '3134', 'HONDA_47', '', '', '172.25.167.146', '2024-02-01 13:22:04'),
(132, '4111', 'TOYOTA_10', '', '', '172.25.119.93', '2024-02-01 13:22:04'),
(133, '4112', 'TOYOTA_11', '', '', '172.25.116.80', '2024-02-01 13:22:04'),
(134, '0000', 'TEST', '', '', '172.25.162.113', '2024-02-01 13:22:04'),
(136, '5138', 'SUZUKI_83_QA', '', '', '172.25.115.17', '2024-02-01 13:22:04'),
(137, '4117', 'TOYOTA_16', '', '', '172.25.114.134', '2024-02-01 13:22:04'),
(139, '5140', 'SUZUKI_82', '', '', '172.25.115.14', '2024-02-01 13:22:04'),
(140, '5138', 'SUZUKI_83', '', '', '172.25.113.146', '2024-02-01 13:22:04'),
(141, '3147', 'HONDA_60', '', '', '172.25.161.35', '2024-02-01 13:22:04'),
(142, '3126', 'HONDA_61', '', '', '172.25.167.161', '2024-02-01 13:22:04'),
(143, '3155', 'HONDA_71', '', '', '172.25.160.106', '2024-02-01 13:22:04'),
(144, '3154', 'HONDA_70', '', '', '172.25.160.97', '2024-02-01 13:22:04'),
(145, '3156', 'HONDA_69', '', '', '172.25.160.101', '2024-02-01 13:22:04'),
(146, '4121', 'TOYOTA_19', '', '', '172.25.117.133', '2024-02-01 13:22:04'),
(147, '4122', 'TOYOTA_21', '', '', '172.25.162.130', '2024-02-01 13:22:04'),
(148, '4122', 'TOYOTA_21', '', '', '172.25.162.130', '2024-02-01 13:22:04'),
(150, '4124', 'TOYOTA_22', '', '', '172.25.162.20', '2024-02-01 13:22:04'),
(151, '3136', 'HONDA_47_4', '', '', '172.25.165.240', '2024-02-01 13:22:04'),
(152, '3122', 'HONDA_37', '', '', '172.25.165.146', '2024-02-01 13:22:04'),
(153, '4120', 'TOYOTA_23', '', '', '172.25.162.80', '2024-02-01 13:22:04'),
(154, '1135', 'MAZDA_71', '', '', '172.25.114.247', '2024-02-01 13:22:04'),
(155, '4115', 'TOYOTA_12', '', '', '172.25.160.119', '2024-02-01 13:22:04'),
(156, '4125', 'TOYOTA_24', '', '', '172.25.165.224', '2024-02-01 13:22:04'),
(157, '3157', 'HONDA_72', '', '', '172.25.161.224', '2024-02-01 13:22:04'),
(158, '4126', 'TOYOTA_25', '', '', '172.25.162.110', '2024-02-01 13:22:04'),
(160, '3163', 'HONDA_76', '', '', '172.25.162.217', '2024-02-01 13:22:04'),
(161, '3162', 'HONDA_75', '', '', '172.25.162.223', '2024-02-01 13:22:04'),
(162, '3161', 'HONDA_74', '', '', '172.25.162.113', '2024-02-01 13:22:04'),
(163, '3067_1', 'HONDA_84', '', '', '172.25.162.183', '2024-02-01 13:22:04'),
(164, '3067_2', 'HONDA_85', '', '', '172.25.162.188', '2024-02-01 13:22:04'),
(165, '3067_3', 'HONDA_86', '', '', '172.25.162.193', '2024-02-01 13:22:04'),
(166, '3067_4', 'HONDA_87', '', '', '172.25.162.199', '2024-02-01 13:22:04'),
(167, '3067_5', 'HONDA_88', '', '', '172.25.162.230', '2024-02-01 13:22:04'),
(168, '3066_1', 'HONDA_80', '', '', '172.25.162.228', '2024-02-01 13:22:04'),
(169, '3066_2', 'HONDA_81', '', '', '172.25.162.236', '2024-02-01 13:22:04'),
(170, '3066_3', 'HONDA_82', '', '', '172.25.162.241', '2024-02-01 13:22:04'),
(171, '3066_4', 'HONDA_83', '', '', '172.25.162.246', '2024-02-01 13:22:04'),
(173, '3160', 'HONDA_74_N.APP', '', '', '172.25.162.46', '2024-02-01 13:22:04'),
(175, '3165', 'HONDA_78', '', '', '172.25.162.214', '2024-02-01 13:22:04'),
(176, '3158', 'HONDA_73', '', '', '172.25.165.225', '2024-02-01 13:22:04'),
(177, '1125', 'MAZDA_40', '', '', '172.25.119.175', '2024-02-01 13:22:04'),
(178, 'Suzuki 5139', 'SUZUKI_84', '', '', '172.25.115.103', '2024-02-01 13:22:04'),
(180, '2130', 'DAIHATSU_29', '', '', '172.25.160.180', '2024-02-01 13:22:04'),
(181, '2131', 'DAIHATSU_30_1', '', '', '172.25.162.38', '2024-02-01 13:22:04'),
(184, '2132', 'DAIHATSU_30', '', '', '172.25.161.166', '2024-02-01 13:22:04'),
(186, '5031', 'SUZUKI_72', '', '', '172.25.114.189', '2024-02-01 13:22:04'),
(187, '3169', 'HONDA_91', '', '', '172.25.160.105', '2024-02-01 13:22:04'),
(188, '3149', 'HONDA_64', '', '', '172.25.165.95', '2024-02-01 13:22:04'),
(189, '2115', 'DAIHATSU_09_APP', '', '', '172.25.160.198', '2024-02-01 13:22:04'),
(192, '7118', 'SUBARU_07_APP', '', '', '172.25.161.93', '2024-02-01 13:22:04'),
(193, '7118', 'SUBARU_07_QA', '', '', '172.25.161.107', '2024-02-01 13:22:04'),
(194, '7116_APP', 'SUBARU_07', '', '', '172.25.167.233', '2024-02-01 13:22:04'),
(195, '1138', 'MAZDA_72', '', '', '172.25.112.176', '2024-02-01 13:22:04'),
(199, '1136 ', 'MAZDA_71_1', '', '', '172.25.112.225', '2024-02-01 13:22:04'),
(201, '5136', 'SUZUKI_73', '', '', '172.25.113.83', '2024-02-01 13:22:04'),
(202, '3171', 'HONDA_95_1', '', '', '172.25.167.150', '2024-02-01 13:22:04'),
(203, '5134', 'SUZUKI_76', '', '', '172.25.113.251', '2024-02-01 13:22:04'),
(204, '5029', 'SUZUKI_85', '', '', '172.25.167.2', '2024-02-01 13:22:04'),
(205, '5041', 'SUZUKI_13', '', '', '172.25.116.253', '2024-02-01 13:22:04'),
(206, '5041', 'SUZUKI_05', '', '', '172.25.117.68', '2024-02-01 13:22:04'),
(207, '7112', 'SUBARU_02_1', '', '', '172.25.167.24', '2024-02-01 13:22:04'),
(208, '1008', 'MAZDA_16_1_QA_1', '', '', '172.25.115.189', '2024-02-01 13:22:04'),
(209, '1008', 'MAZDA_16_1', '', '', '172.25.115.41', '2024-02-01 13:22:04'),
(210, '3161', 'HONDA_74_APP', '', '', '172.25.162.115', '2024-02-01 13:22:04'),
(211, '5104', 'SUZUKI_02', '', '', '172.25.119.165', '2024-02-01 13:22:04'),
(212, '2116', 'DAIHATSU_09_01', '', '', '172.25.165.139', '2024-02-01 13:22:04'),
(213, '5126', 'SUZUKI_66', '', '', '172.25.113.231', '2024-02-01 13:22:04'),
(214, '5128', 'SUZUKI_63', '', '', '172.25.113.227', '2024-02-01 13:22:04'),
(215, '2125', 'DAIHATSU_12', '', '', '172.25.165.187', '2024-02-01 13:22:04'),
(218, '1145', 'MAZDA_75', '', '', '172.25.164.226', '2024-02-01 13:22:04'),
(219, '1008', 'MAZDA_16_2', '', '', '172.25.114.150', '2024-02-01 13:22:04'),
(221, '1144', 'MAZDA_76', '', '', '172.25.112.185', '2024-02-01 13:22:04'),
(222, '4127', 'TOYOTA_26', '', '', '172.25.115.241', '2024-02-01 13:22:04'),
(223, '2134', 'DAIHATSU_31', '', '', '172.25.162.39', '2024-02-01 13:22:04'),
(224, '1004', 'MAZDA_78', '', '', '172.25.167.231', '2024-02-01 13:22:04'),
(225, '3130', 'HONDA_97', '', '', '172.25.161.165', '2024-02-01 13:22:04'),
(226, '3172', 'HONDA_96', '', '', '172.25.165.170', '2024-02-01 13:22:04'),
(227, '3170', 'HONDA_95', '', '', '172.25.160.184', '2024-02-01 13:22:04'),
(228, '2035', 'DAIHATSU_33', '', '', '172.25.165.56', '2024-02-01 13:22:04'),
(230, '5102', 'SUZUKI_01_1', '', '', '172.25.119.148', '2024-02-01 13:22:04'),
(231, '2035', 'DAIHATSU_33_1', '', '', '172.25.160.139', '2024-02-01 13:22:04');

-- --------------------------------------------------------

--
-- Table structure for table `m_st`
--

CREATE TABLE `m_st` (
  `id` int(10) UNSIGNED NOT NULL,
  `parts_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `st` float NOT NULL,
  `updated_by_no` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `updated_by` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_updated` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `m_st_accounts`
--

CREATE TABLE `m_st_accounts` (
  `id` int(10) UNSIGNED NOT NULL,
  `emp_no` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `full_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_updated` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `t_plan`
--

CREATE TABLE `t_plan` (
  `ID` int(11) NOT NULL,
  `Carmodel` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Line` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ID_No` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Target` int(11) NOT NULL DEFAULT 0,
  `Actual_Target` int(11) NOT NULL DEFAULT 0,
  `Remaining_Target` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `Status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_paused` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'NO',
  `IRCS_Line` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lot_no` varchar(1024) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `datetime_DB` datetime DEFAULT NULL,
  `ended_DB` datetime DEFAULT NULL,
  `takt_secs_DB` int(11) DEFAULT 0,
  `last_takt_DB` int(11) DEFAULT 0,
  `last_update_DB` datetime DEFAULT NULL,
  `actual_start_DB` datetime DEFAULT NULL,
  `theme` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `IP_address` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `m_final_process`
--
ALTER TABLE `m_final_process`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `final_process` (`final_process`);

--
-- Indexes for table `m_ircs_line`
--
ALTER TABLE `m_ircs_line`
  ADD PRIMARY KEY (`id`),
  ADD KEY `line_no` (`line_no`),
  ADD KEY `ircs_line` (`ircs_line`),
  ADD KEY `ip` (`ip`);

--
-- Indexes for table `m_st`
--
ALTER TABLE `m_st`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `parts_name` (`parts_name`);

--
-- Indexes for table `m_st_accounts`
--
ALTER TABLE `m_st_accounts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `t_plan`
--
ALTER TABLE `t_plan`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `m_final_process`
--
ALTER TABLE `m_final_process`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `m_ircs_line`
--
ALTER TABLE `m_ircs_line`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=232;

--
-- AUTO_INCREMENT for table `m_st`
--
ALTER TABLE `m_st`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `m_st_accounts`
--
ALTER TABLE `m_st_accounts`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `t_plan`
--
ALTER TABLE `t_plan`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
