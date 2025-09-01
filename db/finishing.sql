-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jul 01, 2025 at 03:12 AM
-- Server version: 5.7.33
-- PHP Version: 7.4.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `finishing`
--

-- --------------------------------------------------------

--
-- Table structure for table `tb_process_tageto`
--

CREATE TABLE `tb_process_tageto` (
  `id` int(11) NOT NULL,
  `process_date` date DEFAULT NULL,
  `charging_date` varchar(11) DEFAULT NULL,
  `model_id` varchar(11) DEFAULT NULL,
  `cav` varchar(5) DEFAULT NULL,
  `core_no` char(4) DEFAULT NULL,
  `shift` enum('1','2','3') DEFAULT NULL,
  `sampling` text,
  `remark` text,
  `process1_a` decimal(3,1) DEFAULT NULL,
  `process1_b` decimal(3,1) DEFAULT NULL,
  `process2_c` decimal(3,1) DEFAULT NULL,
  `process2_d` decimal(3,1) DEFAULT NULL,
  `process3_e` decimal(3,1) DEFAULT NULL,
  `oil_pump` decimal(3,1) DEFAULT NULL,
  `bosu_cope` decimal(3,1) DEFAULT NULL,
  `kijun_bosu3` enum('OK','NG') DEFAULT NULL,
  `by_gauge` enum('OK','NG') DEFAULT NULL,
  `slope_angel` enum('OK','NG') DEFAULT NULL,
  `gabari` enum('YES','NO') DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `created_log` varchar(255) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_log` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_process_tageto`
--

INSERT INTO `tb_process_tageto` (`id`, `process_date`, `charging_date`, `model_id`, `cav`, `core_no`, `shift`, `sampling`, `remark`, `process1_a`, `process1_b`, `process2_c`, `process2_d`, `process3_e`, `oil_pump`, `bosu_cope`, `kijun_bosu3`, `by_gauge`, `slope_angel`, `gabari`, `created_at`, `created_log`, `updated_at`, `updated_log`) VALUES
(1, '2025-06-02', '8888D', 'EJ40', 'B1', 'V722', '2', '112PCS', 'GOOD BANGET', '8.0', '7.0', '6.0', '5.0', '1.0', '5.0', '7.0', 'NG', 'NG', 'NG', 'YES', '2025-06-10 17:00:00', NULL, '2025-06-25 09:06:38', 'ade'),
(3, '2025-06-25', '80G', 'ES01', 'B2', 'V566', NULL, '120 PCS', 'GOOD PRODUCT', '1.0', '0.1', '0.3', '0.1', '0.3', '-2.0', '4.0', 'OK', 'NG', 'NG', 'YES', '2025-06-25 08:11:03', 'ade', '2025-06-26 06:58:34', 'dandi'),
(4, '2025-06-25', '8J', 'ES01', 'B2', 'T888', NULL, '200 PCS', 'NOT GOOD', '0.1', '0.2', '0.2', '4.0', '5.0', '-2.0', NULL, 'NG', 'NG', 'NG', 'NO', '2025-06-25 08:11:18', 'ade', '2025-06-26 06:55:34', 'dandi'),
(6, '2025-06-25', '2837H', '4JA1', 'H', '8988', NULL, '30 PCS', 'GOOD', '5.0', '4.0', '3.0', '1.0', '7.0', '5.0', '8.0', 'NG', 'NG', 'NG', 'YES', '2025-06-25 09:15:27', 'ade', '2025-06-26 06:58:31', 'dandi'),
(8, '2025-06-26', '9999H', 'ES01', 'B2', 'V897', NULL, '12 PCS', 'GOOD', '-2.0', '-1.0', '-6.0', '-3.0', '1.0', '1.2', '-1.5', 'NG', 'NG', 'NG', 'NO', '2025-06-26 00:58:03', 'dandi', '2025-06-26 08:59:10', 'dandi'),
(19, '2025-06-30', '55555S', 'ES01', 'B2', 'Y898', NULL, '4 PCS', 'Not Good', '-1.3', '-1.5', '1.4', '1.2', '1.1', '0.5', '-1.0', 'NG', 'NG', 'NG', 'NO', '2025-06-30 08:27:16', 'dandi', '2025-06-30 08:59:27', 'dandi'),
(20, '2025-06-30', '77777D', 'ES30', 'C2', 'T778', NULL, '20 PCS', 'Good', '-1.5', '1.5', '-5.0', '0.5', '1.0', '1.5', '0.0', 'OK', 'OK', 'OK', 'YES', '2025-06-30 08:32:49', 'dandi', '2025-07-01 01:20:21', 'dandi');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tb_process_tageto`
--
ALTER TABLE `tb_process_tageto`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tb_process_tageto`
--
ALTER TABLE `tb_process_tageto`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
