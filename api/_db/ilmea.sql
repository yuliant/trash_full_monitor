-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Feb 07, 2022 at 12:04 PM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 7.3.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ilm_ilm`
--

-- --------------------------------------------------------

--
-- Table structure for table `barang`
--

CREATE TABLE `barang` (
  `ID_BARANG` int(11) NOT NULL,
  `ID_PENGGUNA` int(11) DEFAULT NULL,
  `ID_SUPPLIER` int(11) DEFAULT NULL,
  `ID_SATUAN` int(11) DEFAULT NULL,
  `NAMA_BARANG` varchar(50) DEFAULT NULL,
  `STOK_BARANG` int(11) DEFAULT NULL,
  `HARGA_BELI_BARANG` int(11) DEFAULT NULL,
  `HARGA_JUAL_BARANG` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `detail_pesan_ulang`
--

CREATE TABLE `detail_pesan_ulang` (
  `ID_DETAIL_PESAN_ULANG` int(11) NOT NULL,
  `ID_PESAN_ULANG` int(11) NOT NULL,
  `ID_BARANG` int(11) NOT NULL,
  `JUMLAH_PESAN_ULANG` int(11) NOT NULL,
  `HARGA_PESAN_ULANG` int(30) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `detail_surat_jalan`
--

CREATE TABLE `detail_surat_jalan` (
  `ID_DETAIL_SURAT_JALAN` int(11) NOT NULL,
  `ID_SURAT_JALAN` int(11) NOT NULL,
  `ID_BARANG` int(11) NOT NULL,
  `JUMLAH_BAWA` int(11) NOT NULL,
  `JUMLAH_SISA` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `gps`
--

CREATE TABLE `gps` (
  `IDGPS` int(11) NOT NULL,
  `ID_PENGGUNA` int(11) NOT NULL,
  `LATITUDE` varchar(100) NOT NULL,
  `LONGTITUDE` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `gps_lokasi`
--

CREATE TABLE `gps_lokasi` (
  `ID_GPS_LOKASI` int(11) NOT NULL,
  `ID_PENGGUNA` int(11) NOT NULL,
  `LATITUDE` varchar(100) NOT NULL,
  `LONGTITUDE` varchar(100) NOT NULL,
  `NAMA_LOKASI` varchar(255) NOT NULL,
  `TANGGAL` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `hak_akses`
--

CREATE TABLE `hak_akses` (
  `ID_HAK_AKSES` int(11) NOT NULL,
  `HAK_AKSES` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `hak_akses`
--

INSERT INTO `hak_akses` (`ID_HAK_AKSES`, `HAK_AKSES`) VALUES
(1, 'Admin'),
(2, 'Supervisor'),
(3, 'Gudang'),
(4, 'Sales'),
(5, 'Owner Perusahaan'),
(6, 'Admin Perusahaan'),
(7, 'PPIC'),
(9, 'Manajer 1');

-- --------------------------------------------------------

--
-- Table structure for table `keys`
--

CREATE TABLE `keys` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `key` varchar(40) NOT NULL,
  `level` int(2) NOT NULL,
  `ignore_limits` tinyint(1) NOT NULL DEFAULT 0,
  `is_private_key` tinyint(1) NOT NULL DEFAULT 0,
  `ip_addresses` text DEFAULT NULL,
  `date_created` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `keys`
--

INSERT INTO `keys` (`id`, `user_id`, `key`, `level`, `ignore_limits`, `is_private_key`, `ip_addresses`, `date_created`) VALUES
(1, 1, 'masrizal', 1, 0, 0, NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `kunjungan`
--

CREATE TABLE `kunjungan` (
  `ID_KUNJUNGAN` int(11) NOT NULL,
  `ID_PENGGUNA` int(11) NOT NULL,
  `NAMA_KUNJUNGAN` varchar(50) NOT NULL,
  `ALAMAT_KUNJUNGAN` varchar(100) NOT NULL,
  `TGL_KUNJUNGAN` datetime NOT NULL,
  `NO_TELP_KUNJUNGAN` varchar(13) NOT NULL,
  `BUKTI_KUNJUNGAN` varchar(100) NOT NULL,
  `KETERANGAN_KUNJUNGAN` varchar(300) NOT NULL,
  `LATITUDE_KUNJUNGAN` varchar(100) NOT NULL,
  `LONGITUDE_KUNJUNGAN` varchar(100) NOT NULL,
  `STATUS_KUNJUNGAN` int(11) NOT NULL,
  `KODE` varchar(100) NOT NULL DEFAULT '123'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
-- Table structure for table `menu_hak_akses`
--

CREATE TABLE `menu_hak_akses` (
  `ID_MENU_HAK_AKSES` int(11) NOT NULL,
  `ID_HAK_AKSES` int(11) DEFAULT NULL,
  `ID_MENU_PENGGUNA` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `menu_hak_akses`
--

INSERT INTO `menu_hak_akses` (`ID_MENU_HAK_AKSES`, `ID_HAK_AKSES`, `ID_MENU_PENGGUNA`) VALUES
(1, 1, 1),
(2, 1, 2),
(4, 2, 11),
(5, 3, 9),
(6, 4, 10),
(9, 2, 2),
(19, 3, 5),
(20, 4, 4),
(21, 3, 2),
(22, 4, 2),
(23, 2, 6),
(24, 2, 7),
(26, 4, 7),
(28, 5, 2),
(29, 5, 4),
(30, 5, 5),
(31, 5, 6),
(32, 5, 7),
(36, 1, 3);

-- --------------------------------------------------------

--
-- Table structure for table `menu_pengguna`
--

CREATE TABLE `menu_pengguna` (
  `ID_MENU_PENGGUNA` int(11) NOT NULL,
  `MENU_PENGGUNA` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `menu_pengguna`
--

INSERT INTO `menu_pengguna` (`ID_MENU_PENGGUNA`, `MENU_PENGGUNA`) VALUES
(1, 'Admin'),
(2, 'User'),
(3, 'Menu'),
(4, 'Sales'),
(5, 'Gudang'),
(6, 'Supervisor'),
(7, 'Laporan'),
(8, 'Halaman Utama'),
(9, 'Halaman Utama'),
(10, 'Halaman Utama'),
(11, 'Halaman Utama'),
(12, 'Admin Perusahaan'),
(13, 'Manajer');

-- --------------------------------------------------------

--
-- Table structure for table `pelanggan`
--

CREATE TABLE `pelanggan` (
  `ID_PELANGGAN` int(11) NOT NULL,
  `ID_PENGGUNA` int(11) DEFAULT NULL,
  `NAMA_PELANGGAN` varchar(50) DEFAULT NULL,
  `EMAIL_PELANGGAN` varchar(50) DEFAULT NULL,
  `NO_HP_PELANGGAN` varchar(13) DEFAULT NULL,
  `ALAMAT_PELANGGAN` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `pengembalian`
--

CREATE TABLE `pengembalian` (
  `ID_PENGEMBALIAN` int(11) NOT NULL,
  `ID_PENJUALAN` int(11) DEFAULT NULL,
  `TGL_PENGEMBALIAN` date DEFAULT NULL,
  `JUMLAH_PENGEMBALIAN` int(11) DEFAULT NULL,
  `KETERANGAN_PENGEMBALIAN` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `pengguna`
--

CREATE TABLE `pengguna` (
  `ID_PENGGUNA` int(11) NOT NULL,
  `ID_HAK_AKSES` int(11) DEFAULT NULL,
  `ID_PERUSAHAAN` int(11) DEFAULT NULL,
  `ID_WILAYAH` int(11) NOT NULL,
  `NAMA_PENGGUNA` varchar(50) DEFAULT NULL,
  `EMAIL_PENGGUNA` varchar(100) DEFAULT NULL,
  `FOTO_PENGGUNA` varchar(100) DEFAULT NULL,
  `NO_HP_PENGGUNA` int(16) DEFAULT NULL,
  `PASSWORD_PENGGUNA` varchar(500) DEFAULT NULL,
  `STATUS_AKTIF_PENGGUNA` int(11) DEFAULT NULL,
  `TGL_DAFTAR_PENGGUNA` date DEFAULT NULL,
  `ATASAN_PENGGUNA` varchar(10) NOT NULL,
  `KODE_PENGGUNA` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pengguna`
--

INSERT INTO `pengguna` (`ID_PENGGUNA`, `ID_HAK_AKSES`, `ID_PERUSAHAAN`, `ID_WILAYAH`, `NAMA_PENGGUNA`, `EMAIL_PENGGUNA`, `FOTO_PENGGUNA`, `NO_HP_PENGGUNA`, `PASSWORD_PENGGUNA`, `STATUS_AKTIF_PENGGUNA`, `TGL_DAFTAR_PENGGUNA`, `ATASAN_PENGGUNA`, `KODE_PENGGUNA`) VALUES
(1, 1, 0, 0, 'Masrizal Eka Yulianto', 'masrizal04@gmail.com', 'default.jpg', NULL, '$2y$10$ahwcT4su2Dn7T5kcZOpdbesqyDwQOx9/cw1hoMifPtPo8iry4a2hu', 1, '2020-10-05', '', 'PLEGQsVdGSA6SbeJZ3V6'),
(207, 1, 0, 0, 'superadmin', 'mct@admin.com', 'default.jpg', NULL, '$2y$10$102U0NGVKAt77XHc1S5MvuKseWF7ZwkoTHTZkP2R5lHpAwtOxjg8m', 1, '2021-10-06', '', 'z4t8Yn7sanGZCtxL3ZQs'),
(209, 5, 26, 0, 'Leonardusyanto', 'leonardusyanto@gmail.com', 'default.jpg', NULL, '$2y$10$Tsmghc320AAPK648d4IV6Od2On7m8lncJmq/Xt2S5SDgkfo13jF/a', 1, '2021-10-08', '', '5ZEsAfacsKgIg26pIlgW'),
(213, 3, 26, 0, 'Gudang Perusahaan', 'gudangusm@gmail.com', 'business+costume+male+man+office+user+icon-1320196264882354682_512_(1).png', NULL, '$2y$10$102U0NGVKAt77XHc1S5MvuKseWF7ZwkoTHTZkP2R5lHpAwtOxjg8m', 1, '2021-10-08', '', 'Ynvd4YlcjpkirCXqTJ0P'),
(214, 2, 26, 0, 'Demo ILMea', 'demoilmea@gmail.com', 'Screenshot_2022-01-31-08-39-55-13_0449aff2f5871176cb6edd720f3be25c.jpg', NULL, '$2y$10$102U0NGVKAt77XHc1S5MvuKseWF7ZwkoTHTZkP2R5lHpAwtOxjg8m', 1, '2021-10-09', '', 'iUxYujoCFjerTIY52IKb'),
(219, 2, 26, 0, 'Arief Noorsjam', 'noorsjamarief@gmail.com', '9bb6ae57-30d1-4279-a1d0-9b1a2b6f361a.jpg', NULL, '$2y$10$DuoC/3Jyz5B182PR1WEmdexI344qkxfRshxPRJj/v1SnpVuzsftoi', 1, '2022-01-01', '', 'Amzf6HjujKjpxzqtmM9e'),
(220, 2, 26, 0, 'Suwarno', 'nikisuwarno@gmail.com', 'default.jpg', NULL, '$2y$10$102U0NGVKAt77XHc1S5MvuKseWF7ZwkoTHTZkP2R5lHpAwtOxjg8m', 1, '2022-01-01', '', 'ZTiZa6VKoHTW4Xw1cBhc'),
(221, 2, 26, 0, 'Bayu Suheri', 'herrybayu640@gmail.com', '20200807_211357.jpg', NULL, '$2y$10$102U0NGVKAt77XHc1S5MvuKseWF7ZwkoTHTZkP2R5lHpAwtOxjg8m', 1, '2022-01-01', '', '25UO39Y1VKHwVMazT5D7'),
(222, 2, 26, 0, 'Basuki Raharjo', 'basukiraharjo685@gmail.com', 'default.jpg', NULL, '$2y$10$102U0NGVKAt77XHc1S5MvuKseWF7ZwkoTHTZkP2R5lHpAwtOxjg8m', 1, '2022-01-01', '', 'GeGu55dwZQgMmzgPDgas'),
(223, 2, 26, 0, 'Agung Candra', 'akulho.agung@gmail.com', 'IMG-20220110-WA0041.jpg', NULL, '$2y$10$zaZNBZFfgT42Sh6z5pGXx.BFvzavU5YCth18CuPJyzXDnDdUVFqSW', 1, '2022-01-01', '', 'vX7hEGYficbQ6BZ5e2sE'),
(224, 4, 26, 0, '(MS) Satra Sigid P', 'pamungkassip@gmail.com', 'default.jpg', NULL, '$2y$10$Xm/uiCu7.y7A3EOkGp8KUOWNDleO80Bz2soyHbpNhXUJlVRc8m2OK', 1, '2022-01-01', '221', '971aXbpz5OHyQSjPsoXz'),
(225, 4, 26, 8, '(MS) Nandar', 'nandarhidayat99@gmail.com', 'default.jpg', NULL, '$2y$10$102U0NGVKAt77XHc1S5MvuKseWF7ZwkoTHTZkP2R5lHpAwtOxjg8m', 1, '2022-01-01', '222', 'c6RKbilrFngHPd0huzff'),
(226, 4, 26, 7, 'Eko Wahyono ', 'ekowahyonoo99@gmail.com', 'default.jpg', 2147483647, '$2y$10$fLJYwCDXZhAgGyzZwlz/beWWKKxRb7Z4F8e3bFLy7NR8.SflR0kE.', 1, '2022-01-01', '222', 'LkIvWeJrOUmmQxLcAwgs'),
(227, 4, 26, 0, '(MS) Dede Mamat Rahmat', 'dmamatrahmat@gmail.com', 'default.jpg', 2147483647, '$2y$10$102U0NGVKAt77XHc1S5MvuKseWF7ZwkoTHTZkP2R5lHpAwtOxjg8m', 1, '2022-01-01', '221', 'BJinktyY8QS3jDFpceUD'),
(228, 4, 26, 21, '(MS) Indra Bangsawan', 'indralampung360@gmail.com', 'default.jpg', NULL, '$2y$10$102U0NGVKAt77XHc1S5MvuKseWF7ZwkoTHTZkP2R5lHpAwtOxjg8m', 1, '2022-01-01', '221', 'CxpIA1lOJjhZBGBfjrjF'),
(229, 4, 26, 5, '(MS) Heru Jatmiko', 'djatmiko.doel@gmail.com', '229.jpg', NULL, '$2y$10$VBQRnFwlmvLMF3I7sBooM.pQGU7wURCA3zrA9D4f4Z0m3WLAkxQue', 1, '2022-01-01', '219', 'GZ80r8pUv0TTpWq813bY'),
(230, 4, 26, 11, '(MS) Aris Kurniawan', 'ariskurnia237@gmail.com', '230.jpg', 2147483647, '$2y$10$102U0NGVKAt77XHc1S5MvuKseWF7ZwkoTHTZkP2R5lHpAwtOxjg8m', 1, '2022-01-01', '220', 'AW0vTXJO3i1uJkYlAnvi'),
(231, 4, 26, 0, '(MS) Via Asyhari', 'harielibra17@gmail.com', 'default.jpg', 2147483647, '$2y$10$102U0NGVKAt77XHc1S5MvuKseWF7ZwkoTHTZkP2R5lHpAwtOxjg8m', 1, '2022-01-01', '221', '04mj9eD2YUw3VhVj33KI'),
(232, 4, 26, 0, '(MS) Adib Mubarok', 'adibm5555@gmail.com', '232.jpg', 2147483647, '$2y$10$102U0NGVKAt77XHc1S5MvuKseWF7ZwkoTHTZkP2R5lHpAwtOxjg8m', 1, '2022-01-01', '220', 'lBL3f1n5oZ9r4ZQGkUZf'),
(233, 4, 26, 7, '(MS) Harun', 'harunsobban@gmail.com', '233.jpg', 2147483647, '$2y$10$6n8XKMsfReXhh3Od/tOjLuzHdI397O8mA5LP4TrpxKsQyHSACHFKa', 1, '2022-01-01', '223', 'B2rLVccSxVL22XoSH6Mc'),
(234, 4, 26, 24, '(MS) Nur Cahyanto', 'nurcahyanto135@gmail.com', '234.jpg', 2147483647, '$2y$10$102U0NGVKAt77XHc1S5MvuKseWF7ZwkoTHTZkP2R5lHpAwtOxjg8m', 1, '2022-01-01', '222', 'GVnx76OwCRHsft9hYzwX'),
(235, 4, 26, 11, '(MS) Hariyanto', 'billboand09@gmail.com', '235.jpg', 2147483647, '$2y$10$102U0NGVKAt77XHc1S5MvuKseWF7ZwkoTHTZkP2R5lHpAwtOxjg8m', 1, '2022-01-01', '220', 'N2Wm9yhotihZybwCA0Hb'),
(236, 4, 26, 4, '(MS) Ach. Maralda Ainin Ghifar', 'aldoaibu@gmail.com', 'default.jpg', NULL, '$2y$10$102U0NGVKAt77XHc1S5MvuKseWF7ZwkoTHTZkP2R5lHpAwtOxjg8m', 1, '2022-01-01', '223', 'XR734OekEBPPnsV4rWKX'),
(237, 4, 26, 0, '(MS) Novianto Eka Setya Putra', 'ayahnyabiyyu@gmail.com', '237.jpg', NULL, '$2y$10$hQisSzbEAGEEjyq43KQzr.Usl67KA5VFdDQzdx8rSyt.HSIG/qjPm', 1, '2022-01-01', '221', 'phMrIjte8UXXv8GGKKdF'),
(352, 4, 26, 1, 'Ulfa Diana ', 'ulfad280@gmail.com', '352.jpg', 2147483647, '$2y$10$d3ndfdRjOhPb..AOuCtxCO1gEdSiRv/2VP0Zvr7jNNtu/9vBUeyMi', 1, '2022-01-01', '223', 'zE4z7tL1zC7SEPTGBzXk'),
(353, 4, 26, 1, 'Ni Made Karyani ', 'madekaryani96@gmail.com', '353.jpg', NULL, '$2y$10$Qm.5ukycrqLgc7Vv89GX4uT5TV0xVY15XlZhzAdGgTOfXyxkuDQzS', 1, '2022-01-01', '223', 'qli1PNGexHeylzIFphk8'),
(354, 4, 26, 1, 'Desy Fuji Septiyani ', 'meisyaluna4@gmail.com', '354.jpg', 2147483647, '$2y$10$Sc1TvLvmChs9M6M0RBtUa.9LI4Oi5OZITmzeyIe3mqX77yN/NpZI6', 1, '2022-01-01', '223', 'vsyDEYDiBztJ3dvLweb8'),
(355, 4, 26, 1, 'Sinta Bella', 'shintab314@gmail.com', '355.jpg', 2147483647, '$2y$10$AnFMzUWKUWaAAtn6QJbl8uvEsWRs0gP.XWTPY3P6rGkRnFyHuWgWC', 1, '2022-01-01', '223', '2th4XVVmj0fEaLeFl5AP'),
(356, 4, 26, 1, 'Dina Mariana ', 'mdina0525@gmail.com', '356.jpg', NULL, '$2y$10$CMODyaaQLDYxSQB4vMFcGub//kVKEdQ5TYqd6QBjxeVFEjpqGx2l2', 1, '2022-01-01', '223', '42E9MiH3b7WVUeYz9A6c'),
(357, 4, 26, 1, 'Wildan Nuril Fahmi', 'wildannurilfahmi@gmail.com', '357.jpg', 2147483647, '$2y$10$102U0NGVKAt77XHc1S5MvuKseWF7ZwkoTHTZkP2R5lHpAwtOxjg8m', 1, '2022-01-01', '223', '63kHkrnX4xDKNrOFmD78'),
(358, 4, 26, 1, 'Nurulita Dewi Lutfiana', 'nurulitadewi83@gmail.com', '358.jpg', 2147483647, '$2y$10$6OpsvWusPCNwWEWXb1msm.JYpmOb1qWOB51.DBAAYcd9UQBomJMn6', 1, '2022-01-01', '223', '7peJr8KEAcuWKKrCaQdb'),
(359, 4, 26, 2, 'Nurhayati ', 'anurhayatiyati876@gmail.com', 'default.jpg', NULL, '$2y$10$102U0NGVKAt77XHc1S5MvuKseWF7ZwkoTHTZkP2R5lHpAwtOxjg8m', 1, '2022-01-01', '223', 'afQJn86GnHIUlZlotijJ'),
(360, 4, 26, 3, 'Fitria Indriani', 'indriani881519@gmail.com', 'default.jpg', NULL, '$2y$10$102U0NGVKAt77XHc1S5MvuKseWF7ZwkoTHTZkP2R5lHpAwtOxjg8m', 1, '2022-01-01', '222', 'RmQg5MG4QIBDKcFIIYM2'),
(361, 4, 26, 4, 'Amani Siti Fatimah', 'amanisiti2304@gmail.com', '361.jpg', NULL, '$2y$10$fifgrJwF7vFjEcteZ8pS8e3d1fCJxB.HFLrxBioQNDirAzrzFT4hW', 1, '2022-01-01', '223', 'MpThb4IYzyGpztcXAkOv'),
(362, 4, 26, 5, 'Umi Khotimah ', 'umikhotimah45@gmail.com', 'default.jpg', NULL, '$2y$10$102U0NGVKAt77XHc1S5MvuKseWF7ZwkoTHTZkP2R5lHpAwtOxjg8m', 1, '2022-01-01', '219', '9WikF9uToSdSit9n1j1b'),
(363, 4, 26, 5, 'Minati Widastuti', 'minatiwidi62@gmail.com', '363.jpg', NULL, '$2y$10$102U0NGVKAt77XHc1S5MvuKseWF7ZwkoTHTZkP2R5lHpAwtOxjg8m', 1, '2022-01-01', '219', 'Rkgqw9ncAsWoKrYXQIzT'),
(364, 4, 26, 5, 'Marlinda Heni Puspita', 'marlindaheni@gmail.com', 'default.jpg', NULL, '$2y$10$102U0NGVKAt77XHc1S5MvuKseWF7ZwkoTHTZkP2R5lHpAwtOxjg8m', 1, '2022-01-01', '219', 'fXIp88Tb0h53XWAFDqXg'),
(365, 4, 26, 6, 'Anita Eka Susanti', 'anitagendut69@gmail.com', 'default.jpg', NULL, '$2y$10$102U0NGVKAt77XHc1S5MvuKseWF7ZwkoTHTZkP2R5lHpAwtOxjg8m', 1, '2022-01-01', '222', 'fGVz93EMAxddBadynwdu'),
(366, 4, 26, 7, 'Nurul eva Nurita Devi', 'neva6268@gmail.com', 'default.jpg', 2147483647, '$2y$10$102U0NGVKAt77XHc1S5MvuKseWF7ZwkoTHTZkP2R5lHpAwtOxjg8m', 1, '2022-01-01', '222', 'sy3OWmYMWIt5JlAYTHhZ'),
(367, 4, 26, 8, 'Danang ', 'danada2430@gmail.com', 'default.jpg', NULL, '$2y$10$102U0NGVKAt77XHc1S5MvuKseWF7ZwkoTHTZkP2R5lHpAwtOxjg8m', 1, '2022-01-01', '222', 'rv4d26X85wL0u4rkL5mG'),
(368, 4, 26, 8, 'Fifi Aliyah', 'fifi3.fya@gmail.com', 'default.jpg', NULL, '$2y$10$102U0NGVKAt77XHc1S5MvuKseWF7ZwkoTHTZkP2R5lHpAwtOxjg8m', 1, '2022-01-01', '222', 'nwNacEJgh5f9LNk0tApx'),
(369, 4, 26, 9, 'raka asadullah', 'rakaasadullah4@gmail.com', 'default.jpg', 2147483647, '$2y$10$102U0NGVKAt77XHc1S5MvuKseWF7ZwkoTHTZkP2R5lHpAwtOxjg8m', 1, '2022-01-01', '222', 'p9ZLi0KlMpasyBUSRs6r'),
(370, 4, 26, 10, 'Elyn Antonio', 'elynantonio64@gmail.com', '370.jpg', 2147483647, '$2y$10$102U0NGVKAt77XHc1S5MvuKseWF7ZwkoTHTZkP2R5lHpAwtOxjg8m', 1, '2022-01-01', '219', 'hL5xBggmcK13USXFxNhq'),
(371, 4, 26, 10, 'Henri', 'henryprasetyo202@gmail.com', '371.jpg', 2147483647, '$2y$10$102U0NGVKAt77XHc1S5MvuKseWF7ZwkoTHTZkP2R5lHpAwtOxjg8m', 1, '2022-01-01', '219', 'OniMrFTxDK7MlxQjOlii'),
(372, 4, 26, 11, 'Herlina ', 'lina21juni@gmail.com', '372.jpg', 2147483647, '$2y$10$102U0NGVKAt77XHc1S5MvuKseWF7ZwkoTHTZkP2R5lHpAwtOxjg8m', 1, '2022-01-01', '220', 'svUWGwFsCWvfQVb3P7YH'),
(373, 4, 26, 11, 'Murni ', 'murnibunga34@gmail.com', '373.jpg', 2147483647, '$2y$10$102U0NGVKAt77XHc1S5MvuKseWF7ZwkoTHTZkP2R5lHpAwtOxjg8m', 1, '2022-01-01', '220', 'wBJZSV7uccMfloEQRUXt'),
(374, 4, 26, 11, 'Masrida ', 'ridharidhaa2020@gmail.com', '374.jpg', NULL, '$2y$10$7Lc/i9F8DldqIDeqJfYEnu7MwBTO67tSNYcY1.ytIegLLnAy3WyHW', 1, '2022-01-01', '220', '5lOxSJs96j7jbnyXxxcy'),
(375, 4, 26, 11, 'SITI ROSLINA RUSLI', 'roslinahasby01@gmail.com', '375.jpg', 2147483647, '$2y$10$102U0NGVKAt77XHc1S5MvuKseWF7ZwkoTHTZkP2R5lHpAwtOxjg8m', 1, '2022-01-01', '220', 'SdCy0CR2o6jd1HXN0mlL'),
(376, 4, 26, 11, 'Rusdiana', 'dhianrosdhiani@gmail.com', '376.jpg', 2147483647, '$2y$10$QAsZT/4lKau6EHnGbmhFc.SK.IurEnTZaQNRy.YXLQWJKMKUbm7hK', 1, '2022-01-01', '220', '3GJXjp4U2DNKfXbPSzjh'),
(377, 4, 26, 12, 'Lucia Saraswati', 'lusiasaras96@gmail.com', '377.jpg', 2147483647, '$2y$10$3vU6RADrwk5TXYYXiTOwIO4er2Ct8SCqU/.Xrc8C32C9z3eXne88K', 1, '2022-01-01', '223', 'Xg8ARZOMEEAEMhxVXNab'),
(378, 4, 26, 12, 'Mira Dwi Amdriani ', 'mirna.28.ma@gmail.com', 'default.jpg', NULL, '$2y$10$KVvUKN1TbrZc1qF.HFqNP.fGg6w9rSS8GVPTIFKV.fK8C9Uz4vBei', 1, '2022-01-01', '223', 'gGwOQ2Tkj3Pbuh3emxDM'),
(379, 4, 26, 12, 'Fitria Ningsih ', 'fn6116525@gmail.com', 'default.jpg', NULL, '$2y$10$102U0NGVKAt77XHc1S5MvuKseWF7ZwkoTHTZkP2R5lHpAwtOxjg8m', 1, '2022-01-01', '223', 'foKuaP6qDCfAqA9YrpjW'),
(380, 4, 26, 12, 'Agus Priyatno', 'aguspria40@gmail.com', '380.jpg', 2147483647, '$2y$10$102U0NGVKAt77XHc1S5MvuKseWF7ZwkoTHTZkP2R5lHpAwtOxjg8m', 1, '2022-01-01', '223', 'k3EPrUoHDU7uh32LjPHA'),
(381, 4, 26, 12, 'Ananda Pradita Eka Putri', 'anandapradita2@gmail.com', 'default.jpg', 2147483647, '$2y$10$102U0NGVKAt77XHc1S5MvuKseWF7ZwkoTHTZkP2R5lHpAwtOxjg8m', 1, '2022-01-01', '223', '5mVNuyqwbMJ1WK8st9bP'),
(382, 4, 26, 13, 'Kana Afiya', 'kanaafiya8@gmail.com', 'default.jpg', 2147483647, '$2y$10$102U0NGVKAt77XHc1S5MvuKseWF7ZwkoTHTZkP2R5lHpAwtOxjg8m', 1, '2022-01-01', '221', 'O20cdgCUh1PaLYOpbaEn'),
(383, 4, 26, 14, 'Agus Hermawan', 'albiano824@gmail.com', 'default.jpg', NULL, '$2y$10$102U0NGVKAt77XHc1S5MvuKseWF7ZwkoTHTZkP2R5lHpAwtOxjg8m', 1, '2022-01-01', '221', 'BKRIDEDW3YciB7lqldkb'),
(384, 4, 26, 15, 'Dessy Putri Ayu ', 'dessyp.ayu9@gmail.com', 'default.jpg', NULL, '$2y$10$102U0NGVKAt77XHc1S5MvuKseWF7ZwkoTHTZkP2R5lHpAwtOxjg8m', 1, '2022-01-01', '220', 'NjiwN8cmcMF4WlYZ4INI'),
(385, 4, 26, 16, 'Wahab Hasan', 'wahabhasan18@yahoo.com', 'default.jpg', 2147483647, '$2y$10$102U0NGVKAt77XHc1S5MvuKseWF7ZwkoTHTZkP2R5lHpAwtOxjg8m', 1, '2022-01-01', '219', 'VpqvrXKuKFg27HRsJ5Uq'),
(386, 4, 26, 17, 'Yazid Ali Ma sum', 'idzay61@gmail.com', 'default.jpg', NULL, '$2y$10$102U0NGVKAt77XHc1S5MvuKseWF7ZwkoTHTZkP2R5lHpAwtOxjg8m', 1, '2022-01-01', '220', 'z6ITEbU0DogpWGg2HJjW'),
(387, 4, 26, 17, 'Nurul Khotimah', 'khotimahn792@gmail.com', 'default.jpg', 2147483647, '$2y$10$102U0NGVKAt77XHc1S5MvuKseWF7ZwkoTHTZkP2R5lHpAwtOxjg8m', 1, '2022-01-01', '220', 'y1DJioNsWXVW7fkm8uOn'),
(388, 4, 26, 17, 'Nico Ariadhita', 'nicoariadhita@gmail.com', 'default.jpg', NULL, '$2y$10$102U0NGVKAt77XHc1S5MvuKseWF7ZwkoTHTZkP2R5lHpAwtOxjg8m', 1, '2022-01-01', '220', '18m3GszhoL8Ph6hVqUA1'),
(389, 4, 26, 18, 'Maruf ', '', 'default.jpg', NULL, '$2y$10$102U0NGVKAt77XHc1S5MvuKseWF7ZwkoTHTZkP2R5lHpAwtOxjg8m', 1, '2022-01-01', '', 'pUpaGmTDfWVyqr9WMNpM'),
(390, 4, 26, 18, 'Novy Talenta Marunung', 'novytalentamanurung07@gmail.com', '390.jpg', 2147483647, '$2y$10$oZ1W8H7VIwYiSLox3plI1eXw5TOVHRDSHweHaJHz2pfDr6kwnLNn2', 1, '2022-01-01', '221', 'ysLf3OZGwlqxJGV4Ij3x'),
(391, 4, 26, 19, 'Restiana', 'anaresti028@gmail.com', 'default.jpg', 2147483647, '$2y$10$RgEgeKp1fJX396H.Z0wHPe9qj9D5EW2lRqiK5I/P9Nz0e9igW/AuK', 1, '2022-01-01', '221', 'NnRnNDzcDlEnDw3Mqo3l'),
(392, 4, 26, 20, 'Iwan Nugroho', 'ionenugros86@gmail.com', '392.jpg', 2147483647, '$2y$10$102U0NGVKAt77XHc1S5MvuKseWF7ZwkoTHTZkP2R5lHpAwtOxjg8m', 1, '2022-01-01', '219', '35MYcwDupdAglShTDElS'),
(393, 4, 26, 20, 'Nanda Raras Krisprasetianti', 'nandararask0@gmail.com', '393.jpg', 2147483647, '$2y$10$102U0NGVKAt77XHc1S5MvuKseWF7ZwkoTHTZkP2R5lHpAwtOxjg8m', 1, '2022-01-01', '219', 'FuFqJ1yPOwqoXHlPFnWW'),
(394, 4, 26, 21, 'Yenni Aplycia ', 'aplyciayenni@gmail.com', '394.jpg', NULL, '$2y$10$102U0NGVKAt77XHc1S5MvuKseWF7ZwkoTHTZkP2R5lHpAwtOxjg8m', 1, '2022-01-01', '221', 'zc1vdjZZrrzSY3iU0btW'),
(395, 4, 26, 21, 'Nindy Hanum Agustina', 'nharnumagustina@gmail.com', 'default.jpg', 2147483647, '$2y$10$102U0NGVKAt77XHc1S5MvuKseWF7ZwkoTHTZkP2R5lHpAwtOxjg8m', 1, '2022-01-01', '221', 'ai7O0ODX0MNRvbqEyfB0'),
(396, 4, 26, 21, 'Luky Darmawansyah ', 'luckydarma93@gmail.com', '396.jpg', 2147483647, '$2y$10$102U0NGVKAt77XHc1S5MvuKseWF7ZwkoTHTZkP2R5lHpAwtOxjg8m', 1, '2022-01-01', '221', 'whZQfw2EpAmEklNgIyzw'),
(397, 4, 26, 21, 'Amalia Sholiha ', 'liawawan37@gmail.com', 'default.jpg', NULL, '$2y$10$102U0NGVKAt77XHc1S5MvuKseWF7ZwkoTHTZkP2R5lHpAwtOxjg8m', 1, '2022-01-01', '221', 't2Zp7vHnOCcaPzwBPPKS'),
(398, 4, 26, 21, 'Fajarudin ', 'fajarudin076@gmail.com', '398.jpg', 2147483647, '$2y$10$102U0NGVKAt77XHc1S5MvuKseWF7ZwkoTHTZkP2R5lHpAwtOxjg8m', 1, '2022-01-01', '221', 'eKmLexoBoQiilGPOPBSW'),
(399, 4, 26, 22, 'Putri Dwi Anugrah ', 'putridwi2596@gmail.com', '399.jpg', 2147483647, '$2y$10$102U0NGVKAt77XHc1S5MvuKseWF7ZwkoTHTZkP2R5lHpAwtOxjg8m', 1, '2022-01-01', '222', 'xQKCjPPb3dYzEcu7dMfP'),
(400, 4, 26, 23, 'M. Ulum ', 'ulum04938@gmail.com', 'default.jpg', NULL, '$2y$10$102U0NGVKAt77XHc1S5MvuKseWF7ZwkoTHTZkP2R5lHpAwtOxjg8m', 1, '2022-01-01', '219', 'c2c4uirh7C0CWu4PUbBn'),
(401, 4, 26, 23, 'Masudin', 'masudinramadhan@gmail.com', '401.jpg', 2147483647, '$2y$10$102U0NGVKAt77XHc1S5MvuKseWF7ZwkoTHTZkP2R5lHpAwtOxjg8m', 1, '2022-01-01', '219', 'JmokvxvhSnne7RuWdXEG'),
(402, 4, 26, 23, 'Heldy Wisnu Wardana ', NULL, 'default.jpg', NULL, '$2y$10$102U0NGVKAt77XHc1S5MvuKseWF7ZwkoTHTZkP2R5lHpAwtOxjg8m', 1, '2022-01-01', '', 'y01cAhUFyoPY38DYnLny'),
(403, 4, 26, 23, 'Susi Fitriati ', 'susifitriatyy@gmail.com', 'default.jpg', NULL, '$2y$10$102U0NGVKAt77XHc1S5MvuKseWF7ZwkoTHTZkP2R5lHpAwtOxjg8m', 1, '2022-01-01', '219', 'iNWRLCdzva541kdtg5Vj'),
(404, 4, 26, 23, 'Lilik Fitriati ', 'lilikfitriyati@gmail.com', 'default.jpg', 2147483647, '$2y$10$102U0NGVKAt77XHc1S5MvuKseWF7ZwkoTHTZkP2R5lHpAwtOxjg8m', 1, '2022-01-01', '219', 'aA4QgWkwoAjSG2LYRnnr'),
(405, 4, 26, 23, 'Faidatun Nafiah', 'faidatunnafiah94@gmail.com', 'default.jpg', 2147483647, '$2y$10$102U0NGVKAt77XHc1S5MvuKseWF7ZwkoTHTZkP2R5lHpAwtOxjg8m', 1, '2022-01-01', '219', 'c83oTjhzqWScz2zg5g5F'),
(406, 4, 26, 23, 'Belinda Alviana ', 'belinda.alvina2@gmail.com', 'default.jpg', NULL, '$2y$10$102U0NGVKAt77XHc1S5MvuKseWF7ZwkoTHTZkP2R5lHpAwtOxjg8m', 1, '2022-01-01', '219', 'QgUbNIK2joHBtVPRgxHr'),
(407, 4, 26, 23, 'Inriyani Susanti ', 'inriyanisusanti19@gmail.com', 'default.jpg', 2147483647, '$2y$10$102U0NGVKAt77XHc1S5MvuKseWF7ZwkoTHTZkP2R5lHpAwtOxjg8m', 1, '2022-01-01', '219', 'JfoaFTUwXfiBA2ZMNODx'),
(408, 4, 26, 23, 'Diyah Sukristinningsih', 'diyahsukristinningsih@gmail.com', 'default.jpg', 2147483647, '$2y$10$102U0NGVKAt77XHc1S5MvuKseWF7ZwkoTHTZkP2R5lHpAwtOxjg8m', 1, '2022-01-01', '219', 'ddGHicqvyCRtVXpVNrmp'),
(409, 4, 26, 23, 'Amelia Nuraini ', 'amelramadhany1425@gmail.com', 'default.jpg', NULL, '$2y$10$102U0NGVKAt77XHc1S5MvuKseWF7ZwkoTHTZkP2R5lHpAwtOxjg8m', 1, '2022-01-01', '219', '1oxjvpz0sKoQIeJYSmAQ'),
(410, 4, 26, 23, 'Antonia Nolla A.S.', 'antonianollaapresiasuryaningty@gmail.com', 'default.jpg', NULL, '$2y$10$102U0NGVKAt77XHc1S5MvuKseWF7ZwkoTHTZkP2R5lHpAwtOxjg8m', 1, '2022-01-01', '219', '0MpFlH8hoyw7UZqNWGDv'),
(411, 4, 26, 23, 'Umi Kalsum', 'umiey15kalsum@gmail.com', 'default.jpg', 2147483647, '$2y$10$BPVffWeTWwIDKgDXXSzZveXrLXdn0r7khlfeNUJu/jPNcoXwRrJcG', 1, '2022-01-01', '219', 'ohkuxJVxr5PXmRljddUx'),
(412, 4, 26, 23, 'Meilani Saputri', 'meilanisaputri123@gmail.com', 'default.jpg', 2147483647, '$2y$10$102U0NGVKAt77XHc1S5MvuKseWF7ZwkoTHTZkP2R5lHpAwtOxjg8m', 1, '2022-01-01', '219', 'yBnMPh440sziaFKFI9VL'),
(413, 4, 26, 23, 'Lusiana Tri Lestari', 'lusianalestari353@gmail.com', 'default.jpg', NULL, '$2y$10$102U0NGVKAt77XHc1S5MvuKseWF7ZwkoTHTZkP2R5lHpAwtOxjg8m', 1, '2022-01-01', '219', 'jAyZ6NELN63G1UD7Grf7'),
(414, 4, 26, 23, 'Maimun Zulchoidah Afia', 'Jullieaurora@gmail.com', '414.jpg', 2147483647, '$2y$10$102U0NGVKAt77XHc1S5MvuKseWF7ZwkoTHTZkP2R5lHpAwtOxjg8m', 1, '2022-01-01', '219', '8qkg2hIbFTKWWX5xnPkK'),
(415, 4, 26, 23, 'Eka Wahyu Apriliani', 'ekayasmin736@gmail.com', '415.jpg', NULL, '$2y$10$102U0NGVKAt77XHc1S5MvuKseWF7ZwkoTHTZkP2R5lHpAwtOxjg8m', 1, '2022-01-01', '219', 'pXo5XzdmD4RHWULiwNzz'),
(416, 4, 26, 24, 'Fitria Ellyana ', 'fitriaeliana75@gmail.com', '416.jpg', 2147483647, '$2y$10$102U0NGVKAt77XHc1S5MvuKseWF7ZwkoTHTZkP2R5lHpAwtOxjg8m', 1, '2022-01-01', '222', 'Rf6y9EoXXvf9ARoRWUkb'),
(417, 4, 26, 25, 'Kalika Katriana ', 'kalikakatriana16@gmail.com', 'default.jpg', NULL, '$2y$10$102U0NGVKAt77XHc1S5MvuKseWF7ZwkoTHTZkP2R5lHpAwtOxjg8m', 1, '2022-01-01', '220', 'ar8jxCK63G92ykSwLD9b'),
(418, 4, 26, 11, 'Murni', 'murnibunga34@gmail.com', 'default.jpg', NULL, '$2y$10$102U0NGVKAt77XHc1S5MvuKseWF7ZwkoTHTZkP2R5lHpAwtOxjg8m', 1, '2022-01-18', '220', 'uMjXTqdlb40UqThAlAR0'),
(420, 4, 26, 26, 'Siti Suhairiyah', 'suhairiyah207@gmail.com', '420.jpg', 2147483647, '$2y$10$FanZIVdVXTiTff4UmJ74DO9tnGZutN3W9ELB0vAhHW/271KVOzVNW', 1, '2022-01-24', '222', '2x59cdQDpYjYN2jJBNZS'),
(421, 4, 26, 27, 'Sri Ikawati', 'srikawati8@gmail.com', 'default.jpg', 123, '$2y$10$102U0NGVKAt77XHc1S5MvuKseWF7ZwkoTHTZkP2R5lHpAwtOxjg8m', 1, '2022-01-24', '221', 'miqeraNHaMTBgnKBJiWS'),
(422, 4, 26, 18, '[SMD] Masrian', 'rianmr646@gmail.com', '422.jpg', 2147483647, '$2y$10$i0Vzw9KIPfWWTJdXVtCcuOy9ezX4TAYT6sZH2jsVqsm9tDWmjKslK', 1, '2022-01-24', '221', 'VL3XdIGqCWHlBhJ2hy3Z'),
(999, 4, 26, 0, 'pijardwi', 'pdk@mct.com', 'defaut.jpg', 855662518, '$2y$10$102U0NGVKAt77XHc1S5MvuKseWF7ZwkoTHTZkP2R5lHpAwtOxjg8m', 1, '2022-01-26', '0', 'nvZcI7APPe1YRDhRBlHM');

-- --------------------------------------------------------

--
-- Table structure for table `pengguna_token`
--

CREATE TABLE `pengguna_token` (
  `ID_PENGGUNA_TOKEN` int(11) NOT NULL,
  `EMAIL` varchar(128) NOT NULL,
  `TOKEN` varchar(128) NOT NULL,
  `TGL_DIBUAT` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pengguna_token`
--

INSERT INTO `pengguna_token` (`ID_PENGGUNA_TOKEN`, `EMAIL`, `TOKEN`, `TGL_DIBUAT`) VALUES
(5, 'irwanwijayanto04@gmail.com', 'NwiXdxph0Bp8Jybmo/L5ZzAJSNa8cX6r8Ze3hHKkq+c=', 1640697827),
(6, 'indralampung360@gmail.com', 'vpzEhOlp5wJ4/v5ovEnLF67WaauvodgQ2blb9PP/BPM=', 1641630904),
(7, 'ariskurnia237@gmail.com', 'zvXIo1y6qHapg/AlzNIIUijiu5eQRl3aHQYt4bW1ynI=', 1641631014),
(8, 'indralampung360@gmail.com', 'A3sqdQ5oDbEA7vAxZ641wQ05MS5JwHPR+Y20pt11zY8=', 1641631351),
(9, 'indralampung360@gmail.com', 'Mq3YslI6JzjrDnd6mewc4R8WkUO9RyaUJQzOOYMTvRQ=', 1641631398),
(10, 'shintab314@gmail.com', 'U3/dCx/62F+8fjP3pmuSQfOD2zlh9lT0gpNdSQjpAdo=', 1641632004),
(11, 'mdina0525@gmail.com', 'lLLLpajrcELlFkjECfZCkyGkGKsGzHEupA81bHcpC2w=', 1641632265),
(12, 'mdina0525@gmail.com', 'RnSsv8i5l666rzl4G3wzSh3VurQpRrmBz3TUcVkE3uY=', 1641632310),
(13, 'indralampung360@gmail.com', 'huZ0n8lAo1rPaukmKcNW2+/I5eTHt25VX2FR0oz3mOk=', 1641632370),
(14, 'mdina0525@gmail.com', 'sqTFu8/82qx2ewOzXx2JI/E6/basnLLl2bfTj/aSiLQ=', 1641632677),
(15, 'mdina0525@gmail.com', 'aBQEtZR0c4ic3OjTjcROjWicNnsbxoYNPY+ZpvWJdko=', 1641632689),
(16, 'mdina0525@gmail.com', 'RQ9yaqWFsm8ErRigVPxdYmyWeqzn58Y2UK/II6W86JM=', 1641632736),
(17, 'shintab314@gmail.com', 'gwd8CfOoQprL5bn8j9ddLOIT2XneazWjYYK7gFwQiYk=', 1641633117),
(18, 'indralampung360@gmail.com', 'WZJTvP2ec8uNbDb8hmAo0VukU20QKCwt+9UB6tz8sBw=', 1641633349),
(19, 'lilikfitriyati@gmail.com', '2M2AYG8bNt9xTNMztNxaH2RZdpwNVv0OhMu1TL4s6T8=', 1641662118),
(20, 'lilikfitriyati@gmail.com', 'wHLTaoUjsslPyXjIaIrqHTQzl4yrCjA3y6kMCo1naIo=', 1641662226),
(21, 'adibm5555@gmail.com', 'pDfA3ZKD6czV8Z9bCqhcDBE1rkitaUwp4G9LEYB4BSM=', 1641779842),
(22, 'adibm5555@gmail.com', 'GxZw7d0T4VHkCXRJ3EYeySq83SIsc+Al44t+qINY9c8=', 1641780024),
(23, 'indriani881519@gmail.com', '0+sO7CZAqeKZpah2neFQyKmwq+KtBukIfN3Oc8Le4C8=', 1641805047),
(24, 'indriani881519@gmail.com', 'OExnWdILNCT6j+vEH0+/7Pf2jkqNWrhBiKz0YVWAsyM=', 1641805100),
(25, 'indriani881519@gmail.com', 'IpXxYHlr9wlQ+wh30JbuedUlSi22+fA12G2WvWtF51o=', 1641805427),
(26, 'neva6268@gmail.com', 'FtkXaxHcsxV59TgalQ7B/KztRaHsNu858iLxfJAiXog=', 1641808789),
(27, 'ekowahyonoo99@gmail.com', '0gbPWAdlTD8RyXgG75btvO4MBixOR6NpDx1DujIV9Lg=', 1641809169),
(28, 'inriyanisusanti19@gmail.com', 'qopJC0qqIvC02UwtOcBIyaxqovDYRdWgETrEAJhOo8g=', 1641820843),
(29, 'inriyanisusanti19@gmail.com', '/jfjGrUd4riljueapUQ3tL8FDwqA9n9IriOUfJN1En8=', 1641820989),
(30, 'inriyanisusanti19@gmail.com', 'mn0CQuOKHcgMhMheucLT5ESxLaWw7mF4VJ7dlthZKo4=', 1641821253),
(31, 'inriyanisusanti19@gmail.com', 'uuj2o3wv2YG1DyEOrlU9LsUk4WSgsxjpldD2xa0mtMA=', 1641821588),
(32, 'inriyanisusanti19@gmail.com', 'iWIJ449l63ldb3OrakCqP9BY5PtIkWUcDeNF4qy2pB8=', 1641821974),
(33, 'adibm5555@gmail.com', 'p2NvP1wp7hSci24aWzNHm38LBSMSU2X7KSJtmfJ59gA=', 1641853331),
(43, 'ulfad280@gmail.com', 'xzFG6BLiMLRI/THBat1MUqaRbsfeI55dM4hQV/seA38=', 1642550711),
(44, 'ulfad280@gmail.com', '+dtHEwaF1VCioSxj0Ii0/ntdHLOuBXXSoeYfPGvE/Q8=', 1642550742),
(45, 'ulfad280@gmail.com', 'bbn6+LhVYg4S0JDrQNeIJ/2wGFoxRAVEPcIRARedegw=', 1642550849),
(46, 'ulfad280@gmail.com', 'qnSCGnP6UKT9QTT0POn15K51SzNvioY/Qcp2wEYx770=', 1642550953),
(47, 'ulfad280@gmail.com', 'SzYq3a8ZPzJ2oGGu1izSn5sD5v4A5RR+NroF3KuZ+Iw=', 1642551180);

-- --------------------------------------------------------

--
-- Table structure for table `penjualan`
--

CREATE TABLE `penjualan` (
  `ID_PENJUALAN` int(11) NOT NULL,
  `ID_DETAIL_SURAT_JALAN` int(11) DEFAULT NULL,
  `ID_PENGGUNA` int(11) NOT NULL,
  `ID_PELANGGAN` int(11) DEFAULT NULL,
  `TGL_PENJUALAN` date DEFAULT NULL,
  `JUMLAH_PENJUALAN` int(11) DEFAULT NULL,
  `HARGA_PENJUALAN` int(30) NOT NULL DEFAULT 0,
  `STATUS_PEMBAYARAN_PENJUALAN` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `pesan_ulang`
--

CREATE TABLE `pesan_ulang` (
  `ID_PESAN_ULANG` int(11) NOT NULL,
  `ID_PENGGUNA` int(11) NOT NULL,
  `ID_PELANGGAN` int(11) NOT NULL,
  `TGL_PESAN_ULANG` date NOT NULL,
  `STATUS_PESAN_ULANG` varchar(1) NOT NULL,
  `STATUS_PEMBAYARAN_PESAN_ULANG` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `satuan`
--

CREATE TABLE `satuan` (
  `ID_SATUAN` int(11) NOT NULL,
  `ID_PENGGUNA` int(11) NOT NULL,
  `NAMA_SATUAN` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `satuan`
--

INSERT INTO `satuan` (`ID_SATUAN`, `ID_PENGGUNA`, `NAMA_SATUAN`) VALUES
(4, 213, 'Dus'),
(5, 213, 'Tim'),
(6, 213, 'Slop'),
(7, 213, 'Pieces');

-- --------------------------------------------------------

--
-- Table structure for table `sub_menu_pengguna`
--

CREATE TABLE `sub_menu_pengguna` (
  `ID_SUB_MENU_PENGGUNA` int(11) NOT NULL,
  `ID_MENU_PENGGUNA` int(11) DEFAULT NULL,
  `JUDUL_SUB_MENU_PENGGUNA` varchar(100) DEFAULT NULL,
  `URL_SUB_MENU_PENGGUNA` varchar(100) DEFAULT NULL,
  `GAMBAR_SUB_MENU_PENGGUNA` varchar(100) DEFAULT NULL,
  `STATUS_AKTIF_SUB_MENU_PENGGUNA` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sub_menu_pengguna`
--

INSERT INTO `sub_menu_pengguna` (`ID_SUB_MENU_PENGGUNA`, `ID_MENU_PENGGUNA`, `JUDUL_SUB_MENU_PENGGUNA`, `URL_SUB_MENU_PENGGUNA`, `GAMBAR_SUB_MENU_PENGGUNA`, `STATUS_AKTIF_SUB_MENU_PENGGUNA`) VALUES
(1, 1, 'Dashboard', 'admin', 'fas fa-fw fa-tachometer-alt', 0),
(2, 2, 'Profil Saya', 'user', 'fas fa-fw fa-user', 1),
(3, 2, 'Ubah Profil', 'user/edit', 'fas fa-fw fa-user-edit', 1),
(4, 3, 'Manajemen Menu', 'menu', 'fas fa-fw fa-folder', 1),
(5, 3, 'Manajemen Sub Menu', 'menu/submenu', 'fas fa-fw fa-folder-open', 1),
(6, 1, 'Hak Akses', 'admin/role', 'fas fa-fw fa-user-tie', 1),
(7, 2, 'Ganti Password', 'user/changepassword', 'fas fa-fw fa-key', 1),
(11, 1, 'Kelola Pengguna', 'admin/kelolaUser', 'fas fa-fw fa-users-cog', 1),
(12, 5, 'Daftar Supplier', 'gudang/supplier', 'fas fa-fw fa-folder', 1),
(13, 5, 'Daftar Barang', 'gudang/barang', 'fas fa-fw fa-folder', 1),
(14, 5, 'Daftar Satuan', 'gudang/satuan', 'fas fa-fw fa-folder', 1),
(15, 4, 'Daftar Pelanggan', 'sales/pelanggan', 'fas fa-fw fa-folder', 1),
(17, 4, 'Daftar Surat Jalan', 'sales/surat_jalan', 'fas fa-fw fa-folder', 1),
(18, 6, 'Verifikasi Surat Jalan', 'supervisor/verif_surat_jalan', 'fas fa-fw fa-folder', 0),
(19, 4, 'Pesan Ulang', 'sales/pesan_ulang', 'fas fa-fw fa-folder', 1),
(20, 6, 'Verif Pesan Ulang', 'supervisor/verif_pesan_ulang', 'fas fa-fw fa-folder', 0),
(21, 7, 'Laporan Penjualan', 'laporan/penjualan', 'fas fa-fw fa-folder', 0),
(22, 7, 'Laporan Pengembalian', 'laporan/pengembalian', 'fas fa-fw fa-folder', 0),
(23, 7, 'Laporan Pesan Ulang', 'laporan/pesanulang', 'fas fa-fw fa-folder', 0),
(27, 10, 'Dasbor', 'sales/dasbor', 'fas fa-fw fa-tachometer-alt', 1),
(28, 9, 'Dasbor', 'gudang/dasbor', 'fas fa-fw fa-tachometer-alt', 1),
(29, 11, 'Dasbor', 'supervisor/dasbor', 'fas fa-fw fa-tachometer-alt', 1),
(30, 6, 'Jadwal Kunjungan', 'supervisor/kunjungan', 'fas fa-fw fa-folder-open', 1),
(31, 7, 'Laporan Linimasa Sales', 'laporan/linimasa', 'fas fa-fw-folder', 1),
(33, 6, 'Lacak Sales', 'supervisor/getgps', 'fas fa-map', 1);

-- --------------------------------------------------------

--
-- Table structure for table `supplier`
--

CREATE TABLE `supplier` (
  `ID_SUPPLIER` int(11) NOT NULL,
  `ID_PENGGUNA` int(11) DEFAULT NULL,
  `NAMA_SUPPLIER` varchar(50) DEFAULT NULL,
  `EMAIL_SUPPLIER` varchar(50) DEFAULT NULL,
  `NO_HP_SUPPLIER` varchar(13) DEFAULT NULL,
  `ALAMAT_SUPPLIER` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `surat_jalan`
--

CREATE TABLE `surat_jalan` (
  `ID_SURAT_JALAN` int(11) NOT NULL,
  `ID_PENGGUNA` int(11) DEFAULT NULL,
  `NO_SURAT_JALAN` varchar(50) NOT NULL,
  `STATUS_SURAT_JALAN` int(1) NOT NULL DEFAULT 0,
  `TGL_SURAT_JALAN` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `wilayah`
--

CREATE TABLE `wilayah` (
  `ID_WILAYAH` int(11) NOT NULL,
  `NAMA_WILAYAH` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `wilayah`
--

INSERT INTO `wilayah` (`ID_WILAYAH`, `NAMA_WILAYAH`) VALUES
(1, 'Bali dan Lombok'),
(2, 'Banyuwangi'),
(3, 'Blitar'),
(4, 'Jember'),
(5, 'Jogja'),
(6, 'Jombang'),
(7, 'Kediri'),
(8, 'Kudus'),
(9, 'Lamongan'),
(10, 'Madiun'),
(11, 'Makasar'),
(12, 'Malang'),
(13, 'Pekalongan'),
(14, 'Purwakarta'),
(15, 'Purwodadi'),
(16, 'Purwokerto'),
(17, 'Semarang'),
(18, 'Serang'),
(19, 'Slawi'),
(20, 'Solo'),
(21, 'Sumatra'),
(22, 'Sumenep'),
(23, 'Surabaya'),
(24, 'Tuban'),
(25, 'Wonosobo'),
(26, 'Pamekasan'),
(27, 'Cirebon');

-- --------------------------------------------------------

--
-- Table structure for table `_detail_langganan`
--

CREATE TABLE `_detail_langganan` (
  `ID_DETAIL_LANGGANAN` int(11) NOT NULL,
  `ID_LANGGANAN` int(11) NOT NULL,
  `ID_SERVIS` int(11) NOT NULL,
  `JUMLAH_DETAIL_LANGGANAN` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `_keluhan`
--

CREATE TABLE `_keluhan` (
  `ID_KELUHAN` int(11) NOT NULL,
  `ID_PERUSAHAAN` int(11) NOT NULL,
  `JUDUL_KELUHAN` varchar(100) NOT NULL,
  `DESKRIPSI_KELUHAN` varchar(500) NOT NULL,
  `TGL_KELUHAN` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `_langganan`
--

CREATE TABLE `_langganan` (
  `ID_LANGGANAN` int(11) NOT NULL,
  `ID_PERUSAHAAN` int(11) NOT NULL,
  `TGL_LANGGANAN` date DEFAULT NULL,
  `TGL_MULAI_LANGGANAN` date DEFAULT NULL,
  `TGL_AKHIR_LANGGANAN` date DEFAULT NULL,
  `NOMINAL_PEMBAYARAN_LANGGANAN` int(11) NOT NULL,
  `BUKTI_PEMBAYARAN_LANGGANAN` varchar(100) DEFAULT NULL,
  `STATUS_LANGGANAN` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `_perusahaan`
--

CREATE TABLE `_perusahaan` (
  `ID_PERUSAHAAN` int(11) NOT NULL,
  `NAMA_PERUSAHAAN` varchar(100) NOT NULL,
  `NAMA_PEMILIK` varchar(100) NOT NULL,
  `NO_HP_PEMILIK` varchar(14) NOT NULL,
  `EMAIL_PEMILIK` varchar(100) NOT NULL,
  `STATUS_PERUSAHAAN` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `_perusahaan`
--

INSERT INTO `_perusahaan` (`ID_PERUSAHAAN`, `NAMA_PERUSAHAAN`, `NAMA_PEMILIK`, `NO_HP_PEMILIK`, `EMAIL_PEMILIK`, `STATUS_PERUSAHAAN`) VALUES
(11, 'PT Kodok Akai', 'Rizal Eka', '089695615256', 'masrizalsn@gmail.com', 'AKTIF'),
(24, 'PT Kasep', 'masrizal kasep', '089695615256', 'masrizalkasep@gmail.com', 'AKTIF'),
(25, 'pt sns', 'snslalu', '089695615256', 'masrizalkasep@gmail.com', 'AKTIF'),
(26, 'PT. Unggul Sukses Mulia', 'Leo ', '082372666633', 'leonardusyanto@gmail.com', 'aktif'),
(27, 'PT. MCT', 'Mohammad zaidan salim', '085816868404', 'admin@gmail.com', 'AKTIF'),
(28, 'PT. MCT', 'Mohammad zaidan salim', '085816868404', 'salimzaidan40@gmail.com', 'AKTIF'),
(29, 'pt mct', 'mohammad zaidan', '085816868404', 'mohammadzaidan27@gmail.com', 'AKTIF');

-- --------------------------------------------------------

--
-- Table structure for table `_servis`
--

CREATE TABLE `_servis` (
  `ID_SERVIS` int(11) NOT NULL,
  `NAMA_SERVIS` varchar(100) NOT NULL,
  `NOMINAL_SERVIS` int(11) NOT NULL,
  `POTONGAN_SERVIS` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `_servis`
--

INSERT INTO `_servis` (`ID_SERVIS`, `NAMA_SERVIS`, `NOMINAL_SERVIS`, `POTONGAN_SERVIS`) VALUES
(1, 'Gratis', 0, '0'),
(2, 'Standar', 500000, '0'),
(3, 'Tambahan', 75000, '0');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `barang`
--
ALTER TABLE `barang`
  ADD PRIMARY KEY (`ID_BARANG`),
  ADD KEY `FK_BARANG_SUPPLIER` (`ID_SUPPLIER`),
  ADD KEY `FK_PENGGUNA_BARANG` (`ID_PENGGUNA`),
  ADD KEY `FK_SATUAN_BARANG` (`ID_SATUAN`);

--
-- Indexes for table `detail_pesan_ulang`
--
ALTER TABLE `detail_pesan_ulang`
  ADD PRIMARY KEY (`ID_DETAIL_PESAN_ULANG`),
  ADD KEY `ID_PESAN_ULANG` (`ID_PESAN_ULANG`),
  ADD KEY `ID_BARANG` (`ID_BARANG`);

--
-- Indexes for table `detail_surat_jalan`
--
ALTER TABLE `detail_surat_jalan`
  ADD PRIMARY KEY (`ID_DETAIL_SURAT_JALAN`),
  ADD KEY `ID_SURAT_JALAN` (`ID_SURAT_JALAN`),
  ADD KEY `ID_BARANG` (`ID_BARANG`);

--
-- Indexes for table `gps`
--
ALTER TABLE `gps`
  ADD PRIMARY KEY (`IDGPS`),
  ADD KEY `ID_PENGGUNA` (`ID_PENGGUNA`);

--
-- Indexes for table `gps_lokasi`
--
ALTER TABLE `gps_lokasi`
  ADD PRIMARY KEY (`ID_GPS_LOKASI`);

--
-- Indexes for table `hak_akses`
--
ALTER TABLE `hak_akses`
  ADD PRIMARY KEY (`ID_HAK_AKSES`);

--
-- Indexes for table `keys`
--
ALTER TABLE `keys`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kunjungan`
--
ALTER TABLE `kunjungan`
  ADD PRIMARY KEY (`ID_KUNJUNGAN`),
  ADD KEY `ID_PENGGUNA` (`ID_PENGGUNA`);

--
-- Indexes for table `limits`
--
ALTER TABLE `limits`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `menu_hak_akses`
--
ALTER TABLE `menu_hak_akses`
  ADD PRIMARY KEY (`ID_MENU_HAK_AKSES`),
  ADD KEY `FK_HAK_MENU` (`ID_HAK_AKSES`),
  ADD KEY `FK_MENU_HAK` (`ID_MENU_PENGGUNA`);

--
-- Indexes for table `menu_pengguna`
--
ALTER TABLE `menu_pengguna`
  ADD PRIMARY KEY (`ID_MENU_PENGGUNA`);

--
-- Indexes for table `pelanggan`
--
ALTER TABLE `pelanggan`
  ADD PRIMARY KEY (`ID_PELANGGAN`),
  ADD KEY `FK_PENGGUNA_PELANGGAN` (`ID_PENGGUNA`);

--
-- Indexes for table `pengembalian`
--
ALTER TABLE `pengembalian`
  ADD PRIMARY KEY (`ID_PENGEMBALIAN`),
  ADD KEY `FK_PENGEMBALIAN_SURAT_JALAN` (`ID_PENJUALAN`);

--
-- Indexes for table `pengguna`
--
ALTER TABLE `pengguna`
  ADD PRIMARY KEY (`ID_PENGGUNA`),
  ADD KEY `FK_HAK_AKSES_PENGGUNA` (`ID_HAK_AKSES`),
  ADD KEY `ID_PERUSAHAAN` (`ID_PERUSAHAAN`),
  ADD KEY `ID_WILAYAH` (`ID_WILAYAH`);

--
-- Indexes for table `pengguna_token`
--
ALTER TABLE `pengguna_token`
  ADD PRIMARY KEY (`ID_PENGGUNA_TOKEN`);

--
-- Indexes for table `penjualan`
--
ALTER TABLE `penjualan`
  ADD PRIMARY KEY (`ID_PENJUALAN`),
  ADD KEY `FK_PENJUALAN_PELANGGAN` (`ID_PELANGGAN`),
  ADD KEY `FK_PENJUALAN_SURAT_JALAN` (`ID_DETAIL_SURAT_JALAN`),
  ADD KEY `ID_PENGGUNA` (`ID_PENGGUNA`);

--
-- Indexes for table `pesan_ulang`
--
ALTER TABLE `pesan_ulang`
  ADD PRIMARY KEY (`ID_PESAN_ULANG`),
  ADD KEY `ID_PENGGUNA` (`ID_PENGGUNA`),
  ADD KEY `ID_PELANGGAN` (`ID_PELANGGAN`);

--
-- Indexes for table `satuan`
--
ALTER TABLE `satuan`
  ADD PRIMARY KEY (`ID_SATUAN`),
  ADD KEY `ID_PENGGUNA` (`ID_PENGGUNA`);

--
-- Indexes for table `sub_menu_pengguna`
--
ALTER TABLE `sub_menu_pengguna`
  ADD PRIMARY KEY (`ID_SUB_MENU_PENGGUNA`),
  ADD KEY `FK_MENU_SUB` (`ID_MENU_PENGGUNA`);

--
-- Indexes for table `supplier`
--
ALTER TABLE `supplier`
  ADD PRIMARY KEY (`ID_SUPPLIER`),
  ADD KEY `FK_PENGGUNA_SUPPLIER` (`ID_PENGGUNA`);

--
-- Indexes for table `surat_jalan`
--
ALTER TABLE `surat_jalan`
  ADD PRIMARY KEY (`ID_SURAT_JALAN`),
  ADD KEY `FK_SURAT_JALAN_PENGGUNA` (`ID_PENGGUNA`);

--
-- Indexes for table `wilayah`
--
ALTER TABLE `wilayah`
  ADD PRIMARY KEY (`ID_WILAYAH`);

--
-- Indexes for table `_detail_langganan`
--
ALTER TABLE `_detail_langganan`
  ADD PRIMARY KEY (`ID_DETAIL_LANGGANAN`),
  ADD KEY `ID_LANGGANAN` (`ID_LANGGANAN`),
  ADD KEY `ID_SERVIS` (`ID_SERVIS`);

--
-- Indexes for table `_keluhan`
--
ALTER TABLE `_keluhan`
  ADD PRIMARY KEY (`ID_KELUHAN`),
  ADD KEY `ID_PERUSAHAAN` (`ID_PERUSAHAAN`);

--
-- Indexes for table `_langganan`
--
ALTER TABLE `_langganan`
  ADD PRIMARY KEY (`ID_LANGGANAN`),
  ADD KEY `ID_PERUSAHAAN` (`ID_PERUSAHAAN`);

--
-- Indexes for table `_perusahaan`
--
ALTER TABLE `_perusahaan`
  ADD PRIMARY KEY (`ID_PERUSAHAAN`);

--
-- Indexes for table `_servis`
--
ALTER TABLE `_servis`
  ADD PRIMARY KEY (`ID_SERVIS`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `barang`
--
ALTER TABLE `barang`
  MODIFY `ID_BARANG` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `detail_pesan_ulang`
--
ALTER TABLE `detail_pesan_ulang`
  MODIFY `ID_DETAIL_PESAN_ULANG` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `detail_surat_jalan`
--
ALTER TABLE `detail_surat_jalan`
  MODIFY `ID_DETAIL_SURAT_JALAN` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `gps`
--
ALTER TABLE `gps`
  MODIFY `IDGPS` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `gps_lokasi`
--
ALTER TABLE `gps_lokasi`
  MODIFY `ID_GPS_LOKASI` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `hak_akses`
--
ALTER TABLE `hak_akses`
  MODIFY `ID_HAK_AKSES` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `keys`
--
ALTER TABLE `keys`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `kunjungan`
--
ALTER TABLE `kunjungan`
  MODIFY `ID_KUNJUNGAN` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `limits`
--
ALTER TABLE `limits`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `menu_hak_akses`
--
ALTER TABLE `menu_hak_akses`
  MODIFY `ID_MENU_HAK_AKSES` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `menu_pengguna`
--
ALTER TABLE `menu_pengguna`
  MODIFY `ID_MENU_PENGGUNA` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `pelanggan`
--
ALTER TABLE `pelanggan`
  MODIFY `ID_PELANGGAN` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pengembalian`
--
ALTER TABLE `pengembalian`
  MODIFY `ID_PENGEMBALIAN` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pengguna`
--
ALTER TABLE `pengguna`
  MODIFY `ID_PENGGUNA` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1000;

--
-- AUTO_INCREMENT for table `pengguna_token`
--
ALTER TABLE `pengguna_token`
  MODIFY `ID_PENGGUNA_TOKEN` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT for table `penjualan`
--
ALTER TABLE `penjualan`
  MODIFY `ID_PENJUALAN` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pesan_ulang`
--
ALTER TABLE `pesan_ulang`
  MODIFY `ID_PESAN_ULANG` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `satuan`
--
ALTER TABLE `satuan`
  MODIFY `ID_SATUAN` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `sub_menu_pengguna`
--
ALTER TABLE `sub_menu_pengguna`
  MODIFY `ID_SUB_MENU_PENGGUNA` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `supplier`
--
ALTER TABLE `supplier`
  MODIFY `ID_SUPPLIER` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `surat_jalan`
--
ALTER TABLE `surat_jalan`
  MODIFY `ID_SURAT_JALAN` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `wilayah`
--
ALTER TABLE `wilayah`
  MODIFY `ID_WILAYAH` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `_detail_langganan`
--
ALTER TABLE `_detail_langganan`
  MODIFY `ID_DETAIL_LANGGANAN` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `_keluhan`
--
ALTER TABLE `_keluhan`
  MODIFY `ID_KELUHAN` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `_langganan`
--
ALTER TABLE `_langganan`
  MODIFY `ID_LANGGANAN` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `_perusahaan`
--
ALTER TABLE `_perusahaan`
  MODIFY `ID_PERUSAHAAN` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `_servis`
--
ALTER TABLE `_servis`
  MODIFY `ID_SERVIS` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
