-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Aug 13, 2022 at 02:06 AM
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
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `nama` varchar(250) NOT NULL,
  `username` varchar(250) NOT NULL,
  `password` varchar(250) NOT NULL,
  `email` varchar(250) NOT NULL,
  `no_telp` tinyint(50) NOT NULL,
  `status` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `list_tugas`
--

CREATE TABLE `list_tugas` (
  `id` int(11) NOT NULL,
  `id_tempat_sampah` int(25) NOT NULL,
  `id_mobil_sampah` int(25) NOT NULL,
  `id_admin` int(25) NOT NULL,
  `status` varchar(50) NOT NULL,
  `waktu` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `mobil_sampah`
--

CREATE TABLE `mobil_sampah` (
  `id` int(11) NOT NULL,
  `id_tempat_sampah` int(11) NOT NULL,
  `no_telp` varchar(50) NOT NULL,
  `status` varchar(100) NOT NULL,
  `lokasi` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
(3, 'Mohammad Zaidan Salim', 'zaidan@mutiaract.com', '871c62f5e67defd80aceac2def69254c', 'sunanampel10', 'Petugas'),
(4, 'Kosanku Store', 'kosankukosan@gmail.com', '07a37c9f017ed8d24ce03c7a3a8301f3', '085678810909', 'Petugas');

-- --------------------------------------------------------

--
-- Table structure for table `tempat_sampah`
--

CREATE TABLE `tempat_sampah` (
  `ID_TEMPAT_SAMPAH` int(11) NOT NULL,
  `LONGITUDE` varchar(100) NOT NULL,
  `LATITUDE` varchar(100) NOT NULL,
  `LOKASI` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tempat_sampah`
--

INSERT INTO `tempat_sampah` (`ID_TEMPAT_SAMPAH`, `LONGITUDE`, `LATITUDE`, `LOKASI`) VALUES
(3, '12345', 'jsdbfjhbdffvbdj', 'dinoyo jatirejo mojokerto');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `list_tugas`
--
ALTER TABLE `list_tugas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mobil_sampah`
--
ALTER TABLE `mobil_sampah`
  ADD PRIMARY KEY (`id`);

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
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `list_tugas`
--
ALTER TABLE `list_tugas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mobil_sampah`
--
ALTER TABLE `mobil_sampah`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pengguna`
--
ALTER TABLE `pengguna`
  MODIFY `ID_PENGGUNA` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tempat_sampah`
--
ALTER TABLE `tempat_sampah`
  MODIFY `ID_TEMPAT_SAMPAH` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
