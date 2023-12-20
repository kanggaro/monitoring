-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 13, 2023 at 02:44 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_monitor`
--

-- --------------------------------------------------------

--
-- Table structure for table `tb_history`
--

CREATE TABLE `tb_history` (
  `hst_id` int(11) NOT NULL,
  `hst_baterai` int(11) NOT NULL,
  `hst_mesin` int(11) NOT NULL,
  `hst_last_maint` date NOT NULL,
  `hst_next_maint` date NOT NULL,
  `hst_keterangan` varchar(250) NOT NULL,
  `tb_user_usr_id` varchar(20) DEFAULT NULL,
  `tb_mesin_msn_id` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_history`
--

INSERT INTO `tb_history` (`hst_id`, `hst_baterai`, `hst_mesin`, `hst_last_maint`, `hst_next_maint`, `hst_keterangan`, `tb_user_usr_id`, `tb_mesin_msn_id`) VALUES
(101987, 80, 90, '2023-11-25', '2023-12-06', 'Aman terkendali boss', NULL, 'WM-16'),
(101994, 90, 90, '2023-11-20', '2023-12-09', 'Perbaikan berikutnya harap dicek kembali mesinnya', '123123', 'WM-16'),
(102013, 90, 75, '2023-11-30', '2023-12-30', 'Terus ditingkatkan', NULL, 'WM-18'),
(102019, 0, 90, '2023-11-24', '2023-11-24', '80', '123123', 'WM-04'),
(102020, 0, 0, '2023-11-27', '2023-12-09', 'aman terkendali', '123123', 'WM-19'),
(102021, 80, 90, '2023-12-09', '2023-11-29', 'aman', '123123', 'WM-16'),
(102022, 90, 90, '2023-11-29', '2023-12-09', 'tingkatkan', '123123', 'WM-16'),
(102023, 80, 20, '2023-12-09', '2023-12-27', 'perlu penggantian mesin', '123123', 'WM-16'),
(102028, 50, 80, '2023-11-29', '2023-12-27', 'Perlu penggantian baterai', '123123', 'WM-16'),
(102030, 90, 100, '2024-01-03', '2024-02-07', 'okee', '123123', 'WM-16'),
(102031, 80, 90, '2023-12-08', '2023-12-22', 'pinjam dulu seratus', '123123', 'WM-16'),
(102032, 90, 90, '2023-12-11', '2024-01-20', 'Perbaikan telah dilakukan, mesin masih bagus', '123123', 'WM-08'),
(102033, 90, 90, '2023-12-15', '2024-01-15', 'Kondisi mesin bagus, lakukan maintenance berkala', '123123', 'WM-06');

-- --------------------------------------------------------

--
-- Table structure for table `tb_location`
--

CREATE TABLE `tb_location` (
  `lct_id` int(11) NOT NULL,
  `lct_lat` float(10,6) DEFAULT NULL,
  `lct_lng` float(10,6) DEFAULT NULL,
  `lct_date` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `tb_mesin_msn_id` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_location`
--

INSERT INTO `tb_location` (`lct_id`, `lct_lat`, `lct_lng`, `lct_date`, `tb_mesin_msn_id`) VALUES
(1001, 0.181538, 117.489754, '2023-12-13 08:18:59', 'WM-16'),
(1003, NULL, NULL, NULL, 'WM-04'),
(1004, NULL, NULL, NULL, 'WM-05'),
(1005, 0.187951, 117.489807, '2023-12-12 08:05:00', 'WM-06'),
(1006, 0.176385, 117.496635, '2023-12-12 13:43:12', 'WM-08'),
(1007, NULL, NULL, NULL, 'WM-09'),
(1008, NULL, NULL, NULL, 'WM-10'),
(1009, NULL, NULL, NULL, 'WM-11'),
(1010, NULL, NULL, NULL, 'WM-12'),
(1011, NULL, NULL, NULL, 'WM-14'),
(1012, NULL, NULL, NULL, 'WM-15'),
(1013, NULL, NULL, NULL, 'WM-17'),
(1014, NULL, NULL, NULL, 'WM-18'),
(1015, NULL, NULL, NULL, 'WM-19');

-- --------------------------------------------------------

--
-- Table structure for table `tb_mesin`
--

CREATE TABLE `tb_mesin` (
  `msn_id` varchar(10) NOT NULL,
  `msn_merk` varchar(25) NOT NULL,
  `msn_tipe` varchar(25) NOT NULL,
  `msn_ampere` varchar(20) NOT NULL,
  `msn_voltage` varchar(7) NOT NULL,
  `msn_status` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_mesin`
--

INSERT INTO `tb_mesin` (`msn_id`, `msn_merk`, `msn_tipe`, `msn_ampere`, `msn_voltage`, `msn_status`) VALUES
('WM-04', 'Miller', 'BIG BLUE 500 DX', '600 AMP/ 400 AMP', '75 VDC', 'Unavailable'),
('WM-05', 'Miller', 'BIG BLUE 602 D', '600 AMP/ 400 AMP', '80 VDC', 'Unavailable'),
('WM-06', 'Miller', 'BIG BLUE 602 P', '600 AMP/ 400 AMP', '80 VDC', 'Available'),
('WM-08', 'Miller', 'BIG BLUE 600 X', '600 AMP/ 500 AMP', '80 VDC', 'Available'),
('WM-09', 'Miller', 'BIG BLUE 600 X', '600 AMP/ 500 AMP', '80 VDC', 'Unavailable'),
('WM-10', 'Miller', 'TITAN 701', '700 AMP/ 500 AMP', '85 VDC', 'Unavailable'),
('WM-11', 'Miller', 'BIG BLUE TURBO', '700 AMP/ 600 AMP', '85 VDC', 'Unavailable'),
('WM-12', 'Miller', 'VINTAGE 400', '750 AMP/ 500 AMP', '85 VDC', 'Unavailable'),
('WM-14', 'Miller', 'BIG BLUE TURBO', '700 AMP/ 600 AMP', '85 VDC', 'Unavailable'),
('WM-15', 'Miller', 'BIG BLUE TURBO', '700 AMP/ 600 AMP', '85 VDC', 'Unavailable'),
('WM-16', 'Miller', 'BIG BLUE 700X DUO PRO', '700 AMP / 500 AMP', '85 VDC', 'Available'),
('WM-17', 'Miller', 'BIG BLUE 700X DUO PRO', '700 AMP / 500 AMP', '85 VDC', 'Unavailable'),
('WM-18', 'Miller', 'BIG BLUE 700X DUO PRO', '700 AMP / 500 AMP', '85 VDC', 'Unavailable'),
('WM-19', 'Miller', 'BIG BLUE 800X DUO AIRPACK', '800 AMP/ 600 AMP', '90 VDC', 'Unavailable');

-- --------------------------------------------------------

--
-- Table structure for table `tb_mesin_kondisi`
--

CREATE TABLE `tb_mesin_kondisi` (
  `mk_id` int(11) NOT NULL,
  `mk_token` varchar(10) NOT NULL,
  `mk_condition` tinyint(1) DEFAULT NULL,
  `mk_date` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `tb_mesin_msn_id` varchar(10) DEFAULT NULL,
  `tb_user_usr_id` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_mesin_kondisi`
--

INSERT INTO `tb_mesin_kondisi` (`mk_id`, `mk_token`, `mk_condition`, `mk_date`, `tb_mesin_msn_id`, `tb_user_usr_id`) VALUES
(1001, 'WMT-16-PKT', 0, '2023-12-13 09:31:57', 'WM-16', '123123'),
(1002, 'WMT-08-PKT', 0, '2023-12-13 09:37:12', 'WM-08', '234234'),
(1003, 'WMT-04-PKT', NULL, NULL, 'WM-04', NULL),
(1004, 'WMT-05-PKT', NULL, NULL, 'WM-05', NULL),
(1005, 'WMT-06-PKT', 0, '2023-12-12 15:16:11', 'WM-06', '123123'),
(1006, 'WMT-09-PKT', NULL, NULL, 'WM-09', NULL),
(1007, 'WMT-10-PKT', NULL, NULL, 'WM-10', NULL),
(1008, 'WMT-11-PKT', NULL, NULL, 'WM-11', NULL),
(1009, 'WMT-12-PKT', NULL, NULL, 'WM-12', NULL),
(1010, 'WMT-14-PKT', NULL, NULL, 'WM-14', NULL),
(1011, 'WMT-15-PKT', NULL, NULL, 'WM-15', NULL),
(1012, 'WMT-17-PKT', NULL, NULL, 'WM-17', NULL),
(1013, 'WMT-18-PKT', NULL, NULL, 'WM-18', NULL),
(1014, 'WMT-19-PKT', NULL, NULL, 'WM-19', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tb_user`
--

CREATE TABLE `tb_user` (
  `usr_id` varchar(20) NOT NULL,
  `usr_name` varchar(50) NOT NULL,
  `usr_hp` varchar(15) NOT NULL,
  `usr_departemen` varchar(75) NOT NULL,
  `usr_role` varchar(10) NOT NULL,
  `usr_password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_user`
--

INSERT INTO `tb_user` (`usr_id`, `usr_name`, `usr_hp`, `usr_departemen`, `usr_role`, `usr_password`) VALUES
('0803774', 'Dony Setiawan', '085367867867', 'Departement Operation & Maintenance', 'user', '$2y$10$.m.WPtGBCJz4MPBQYD8g4unUos1ZrOTjAG01x/.ICp3HTmt4ZvBQ.'),
('0803811', 'Agus Maryadi', '082243243243', 'Departement Bengkel dan Alat Berat', 'user', '$2y$10$rforM6E1WahtnMvCFMSRSuhDRFSMvVwnkS/UYaAB6W0njd6CsWoIe'),
('0903866', 'Akip Hermanto', '081276576576', 'Departement Bengkel dan Alat Berat', 'user', '$2y$10$4iJmnbFihdYyFR/UWZVkO.dDxmUq4EZtr9P.YKynGFscrTHvbueHq'),
('1104090', 'Arsyad S', '085387096896', 'Departement Bengkel dan Alat Berat', 'admin', '$2y$10$Qgq8WtU1lq4t5MuqG4qrieQ3pAPFw0Zqn0bea4x15kLbWEGSmT1pe'),
('123123', 'admin', '08123456789', 'Departement Pengelasan dan Perpipaan', 'admin', '$2y$10$CHmjpvFhJdO2HT96WQo9Zu9cZ4C6/8k8jWQELjbws77XLjjM1JwMK'),
('1404349', 'Brillians Cahragil S.P.', '082134534534', 'Departement Perencanaan & Pemeliharaan 2', 'user', '$2y$10$UcxZoQl4XGMIaah6b78YYOziX0M7Ij6NwWCUpZUtdzoR.GvTzaioW'),
('1404357', 'Abdul Razak F.', '081298798787', 'Departement Manajemen Aset', 'user', '$2y$10$xHbDLit52/Oqd2BnBAOAj.VfDGsb2uWcydzVnDkIqssXZK0dWiMHK'),
('1604430', 'Prima Perdana A.P.', '089523423423', 'Departement Bengkel dan Alat Berat', 'user', '$2y$10$Gd0nzLGHCRdsRrpktLUzHuPDFt1AF.gBZYnH518eKV3OTf2nO0fS6'),
('234234', 'User', '08234234234', 'Departement Inspeksi Teknik', 'user', '$2y$10$DwXO/tsAwzoFyd2FDpvSbeQ4lo7lZLyqhxH8g7ewe3IHrIFVYc4Em'),
('4083740', 'M. Sarif', '081254700055', 'Departement Bengkel dan Alat Berat', 'admin', '$2y$10$WcD2Ml/dKZyshh6HycabfeiuAjlXyXYNzX5is9shEO8dIIsNTetH6'),
('8903143', 'Suwarto', '081345645645', 'Departement Bengkel dan Alat Berat', 'user', '$2y$10$3GpFkEfXncuCNPdoyjKDueRjtqIFgtfEwt1VDp1BwxBIPbXD5ikGi'),
('K225333', 'Imran', '081134534534', 'Departement Kelistrikan', 'user', '$2y$10$/4TXKF5N6kPcBBg0BegI4.zDUlzc6u73NyN.iVsmYe7kLjU.0C0fC'),
('K225381', 'Saleh Lipu', '081243243243', 'Departement Teknik Kontrol Kualitas', 'user', '$2y$10$ApKVXjmCw4UCYj52fa29NO2YaCMnMqJnO5W4YRVb8fvYMbELQoe7y'),
('K225673', 'Sapari', '081135735735', 'Departement Bengkel dan Alat Berat', 'user', '$2y$10$hSe23ip8GeLglmGJdC5tE.klV3M0/0gHHrvh2tcAVpbHQm7PjjPsC'),
('M1809', 'Wariadi', '082278978978', 'Departement Bengkel dan Alat Berat', 'user', '$2y$10$vrViIsGarVOb7fkZPxhiRuErBR4JbQA/qIYq1Tc12b4g.md1ZNWFi');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tb_history`
--
ALTER TABLE `tb_history`
  ADD PRIMARY KEY (`hst_id`),
  ADD KEY `tb_history_tb_mesin` (`tb_mesin_msn_id`),
  ADD KEY `tb_history_tb_user` (`tb_user_usr_id`);

--
-- Indexes for table `tb_location`
--
ALTER TABLE `tb_location`
  ADD PRIMARY KEY (`lct_id`),
  ADD KEY `tb_location_tb_mesin` (`tb_mesin_msn_id`);

--
-- Indexes for table `tb_mesin`
--
ALTER TABLE `tb_mesin`
  ADD PRIMARY KEY (`msn_id`);

--
-- Indexes for table `tb_mesin_kondisi`
--
ALTER TABLE `tb_mesin_kondisi`
  ADD PRIMARY KEY (`mk_id`),
  ADD KEY `tb_mesin_kondisi_tb_mesin` (`tb_mesin_msn_id`),
  ADD KEY `tb_mesin_kondisi_tb_user` (`tb_user_usr_id`);

--
-- Indexes for table `tb_user`
--
ALTER TABLE `tb_user`
  ADD PRIMARY KEY (`usr_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tb_history`
--
ALTER TABLE `tb_history`
  MODIFY `hst_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=102034;

--
-- AUTO_INCREMENT for table `tb_location`
--
ALTER TABLE `tb_location`
  MODIFY `lct_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1016;

--
-- AUTO_INCREMENT for table `tb_mesin_kondisi`
--
ALTER TABLE `tb_mesin_kondisi`
  MODIFY `mk_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1015;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tb_history`
--
ALTER TABLE `tb_history`
  ADD CONSTRAINT `tb_history_tb_mesin` FOREIGN KEY (`tb_mesin_msn_id`) REFERENCES `tb_mesin` (`msn_id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `tb_history_tb_user` FOREIGN KEY (`tb_user_usr_id`) REFERENCES `tb_user` (`usr_id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `tb_location`
--
ALTER TABLE `tb_location`
  ADD CONSTRAINT `tb_location_tb_mesin` FOREIGN KEY (`tb_mesin_msn_id`) REFERENCES `tb_mesin` (`msn_id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `tb_mesin_kondisi`
--
ALTER TABLE `tb_mesin_kondisi`
  ADD CONSTRAINT `tb_mesin_kondisi_tb_mesin` FOREIGN KEY (`tb_mesin_msn_id`) REFERENCES `tb_mesin` (`msn_id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `tb_mesin_kondisi_tb_user` FOREIGN KEY (`tb_user_usr_id`) REFERENCES `tb_user` (`usr_id`) ON DELETE SET NULL ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
