-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Aug 21, 2022 at 02:49 PM
-- Server version: 5.7.33
-- PHP Version: 7.4.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `trash_full_monitor`
--

-- --------------------------------------------------------

--
-- Table structure for table `keys`
--

CREATE TABLE `keys` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `key` varchar(40) NOT NULL,
  `level` int(2) NOT NULL,
  `ignore_limits` tinyint(1) NOT NULL DEFAULT '0',
  `is_private_key` tinyint(1) NOT NULL DEFAULT '0',
  `ip_addresses` text,
  `date_created` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `keys`
--

INSERT INTO `keys` (`id`, `user_id`, `key`, `level`, `ignore_limits`, `is_private_key`, `ip_addresses`, `date_created`) VALUES
(1, 1, 'masrizal', 1, 0, 0, NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `limits`
--

CREATE TABLE `limits` (
  `id` int(11) NOT NULL,
  `uri` varchar(255) NOT NULL,
  `count` int(10) NOT NULL,
  `hour_started` int(11) NOT NULL,
  `api_key` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `list_tugas`
--

CREATE TABLE `list_tugas` (
  `ID_LIST_TUGAS` int(11) NOT NULL,
  `ID_TEMPAT_SAMPAH` int(25) NOT NULL,
  `ID_MOBIL_SAMPAH` int(25) NOT NULL,
  `ID_PENGGUNA` int(25) NOT NULL,
  `STATUS_LIST` varchar(50) NOT NULL DEFAULT 'angkut' COMMENT 'angkut, menuju lokasi',
  `TANGGAL` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `list_tugas`
--

INSERT INTO `list_tugas` (`ID_LIST_TUGAS`, `ID_TEMPAT_SAMPAH`, `ID_MOBIL_SAMPAH`, `ID_PENGGUNA`, `STATUS_LIST`, `TANGGAL`) VALUES
(2, 3, 1, 5, 'angkut', '2022-08-21 14:05:05');

-- --------------------------------------------------------

--
-- Table structure for table `mobil_sampah`
--

CREATE TABLE `mobil_sampah` (
  `ID_MOBIL_SAMPAH` int(11) NOT NULL,
  `MEREK` varchar(255) DEFAULT NULL,
  `NO_PLAT` varchar(50) NOT NULL,
  `STATUS` varchar(100) NOT NULL DEFAULT 'ready' COMMENT 'ready, dipakai, service',
  `LOKASI` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `mobil_sampah`
--

INSERT INTO `mobil_sampah` (`ID_MOBIL_SAMPAH`, `MEREK`, `NO_PLAT`, `STATUS`, `LOKASI`) VALUES
(1, 'Tosa', 'W 123 BH', 'ready', 'Omah e masrizal'),
(2, 'PCX', 'w 123 gh', 'ready', 'Kendal');

-- --------------------------------------------------------

--
-- Table structure for table `pengguna`
--

CREATE TABLE `pengguna` (
  `ID_PENGGUNA` int(11) NOT NULL,
  `NAMA_PENGGUNA` varchar(100) NOT NULL,
  `EMAIL_PENGGUNA` varchar(250) NOT NULL,
  `PASSWORD_PENGGUNA` varchar(250) NOT NULL,
  `NOHP_PENGGUNA` varchar(50) NOT NULL,
  `JABATAN_PENGGUNA` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pengguna`
--

INSERT INTO `pengguna` (`ID_PENGGUNA`, `NAMA_PENGGUNA`, `EMAIL_PENGGUNA`, `PASSWORD_PENGGUNA`, `NOHP_PENGGUNA`, `JABATAN_PENGGUNA`) VALUES
(1, 'Zaidan', 'zaidan@gmail.com', '21232f297a57a5a743894a0e4a801fc3', '0979878687', 'Administrator'),
(3, 'Mohammad Zaidan Salim', 'zaidan@mutiaract.com', 'e10adc3949ba59abbe56e057f20f883e', '123', 'Petugas'),
(4, 'Kosanku Store', 'kosankukosan@gmail.com', '07a37c9f017ed8d24ce03c7a3a8301f3', '085678810909', 'Petugas'),
(5, 'MASRIZAL EKA YULIANTO', 'masrizal04@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', '089695615256', 'Petugas');

-- --------------------------------------------------------

--
-- Table structure for table `tempat_sampah`
--

CREATE TABLE `tempat_sampah` (
  `ID_TEMPAT_SAMPAH` int(11) NOT NULL,
  `NAMA_TEMPAT_SAMPAH` varchar(255) DEFAULT NULL,
  `LONGITUDE` varchar(100) NOT NULL,
  `LATITUDE` varchar(100) NOT NULL,
  `LOKASI` varchar(100) NOT NULL,
  `BERAT` int(11) DEFAULT '0' COMMENT 'satuan persen',
  `STATUS_JEMPUT` int(1) NOT NULL DEFAULT '0' COMMENT '1 jika ada yang kelokasi, 0 untuk tidak ada'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tempat_sampah`
--

INSERT INTO `tempat_sampah` (`ID_TEMPAT_SAMPAH`, `NAMA_TEMPAT_SAMPAH`, `LONGITUDE`, `LATITUDE`, `LOKASI`, `BERAT`, `STATUS_JEMPUT`) VALUES
(3, 'Gebang', '-7.4670757', '112.7146733', 'dinoyo jatirejo mojokerto', 80, 0),
(4, 'Pasar Larangan', '-7.493567117308107', '112.73667038743336', 'Pasar Larangan', 0, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `keys`
--
ALTER TABLE `keys`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `limits`
--
ALTER TABLE `limits`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `list_tugas`
--
ALTER TABLE `list_tugas`
  ADD PRIMARY KEY (`ID_LIST_TUGAS`),
  ADD KEY `ID_MOBIL_SAMPAH` (`ID_MOBIL_SAMPAH`),
  ADD KEY `ID_PENGGUNA` (`ID_PENGGUNA`),
  ADD KEY `ID_TEMPAT_SAMPAH` (`ID_TEMPAT_SAMPAH`);

--
-- Indexes for table `mobil_sampah`
--
ALTER TABLE `mobil_sampah`
  ADD PRIMARY KEY (`ID_MOBIL_SAMPAH`);

--
-- Indexes for table `pengguna`
--
ALTER TABLE `pengguna`
  ADD PRIMARY KEY (`ID_PENGGUNA`);

--
-- Indexes for table `tempat_sampah`
--
ALTER TABLE `tempat_sampah`
  ADD PRIMARY KEY (`ID_TEMPAT_SAMPAH`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `keys`
--
ALTER TABLE `keys`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `limits`
--
ALTER TABLE `limits`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `list_tugas`
--
ALTER TABLE `list_tugas`
  MODIFY `ID_LIST_TUGAS` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `mobil_sampah`
--
ALTER TABLE `mobil_sampah`
  MODIFY `ID_MOBIL_SAMPAH` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `pengguna`
--
ALTER TABLE `pengguna`
  MODIFY `ID_PENGGUNA` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tempat_sampah`
--
ALTER TABLE `tempat_sampah`
  MODIFY `ID_TEMPAT_SAMPAH` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `list_tugas`
--
ALTER TABLE `list_tugas`
  ADD CONSTRAINT `list_tugas_ibfk_1` FOREIGN KEY (`ID_MOBIL_SAMPAH`) REFERENCES `mobil_sampah` (`ID_MOBIL_SAMPAH`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `list_tugas_ibfk_2` FOREIGN KEY (`ID_PENGGUNA`) REFERENCES `pengguna` (`ID_PENGGUNA`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `list_tugas_ibfk_3` FOREIGN KEY (`ID_TEMPAT_SAMPAH`) REFERENCES `tempat_sampah` (`ID_TEMPAT_SAMPAH`) ON DELETE CASCADE ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
