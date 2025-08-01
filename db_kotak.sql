-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 15, 2021 at 05:33 AM
-- Server version: 10.1.37-MariaDB
-- PHP Version: 7.3.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_kotak`
--

-- --------------------------------------------------------

--
-- Table structure for table `ktk_donatur`
--

CREATE TABLE `ktk_donatur` (
  `don_id` bigint(20) NOT NULL,
  `don_nama` varchar(100) DEFAULT NULL,
  `don_alamat` varchar(100) DEFAULT NULL,
  `don_status` smallint(1) DEFAULT NULL COMMENT '0=Tidak aktif, 1=Aktif',
  `don_created` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ktk_donatur`
--

INSERT INTO `ktk_donatur` (`don_id`, `don_nama`, `don_alamat`, `don_status`, `don_created`) VALUES
(10, 'donatur1', 'Jl. Soebrantas km. 10', 1, '2021-03-31 11:06:08'),
(11, 'donatur2', 'Jl. SM. Amin', 1, '2021-03-31 11:06:48'),
(12, 'donatur3', 'Jl. Sudirman', 1, '2021-03-31 11:07:23'),
(13, 'donatur4', 'Jl. Garuda Sakti km. 2', 1, '2021-03-31 11:08:06');

-- --------------------------------------------------------

--
-- Table structure for table `ktk_history`
--

CREATE TABLE `ktk_history` (
  `his_id` bigint(20) NOT NULL,
  `his_ref_id` bigint(20) DEFAULT NULL,
  `his_tgl` date DEFAULT NULL,
  `his_jenis` smallint(1) DEFAULT NULL COMMENT '1=kotak masuk, 2=kotak keluar',
  `his_stok` int(11) DEFAULT NULL,
  `his_ket` varchar(50) DEFAULT NULL,
  `his_created` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ktk_history`
--

INSERT INTO `ktk_history` (`his_id`, `his_ref_id`, `his_tgl`, `his_jenis`, `his_stok`, `his_ket`, `his_created`) VALUES
(18, 17, '2021-03-03', 1, 10, 'masuk1', '2021-03-31 12:57:14'),
(23, 13, '2021-03-05', 2, 9, 'keluar1', '2021-03-31 13:14:41'),
(24, 14, '2021-03-06', 2, 8, 'keluar2', '2021-03-31 13:15:16'),
(25, 15, '2021-03-08', 2, 7, 'keluar3', '2021-03-31 13:17:47'),
(26, 16, '2021-03-09', 2, 6, 'keluar4', '2021-03-31 13:18:21');

-- --------------------------------------------------------

--
-- Table structure for table `ktk_jadwal`
--

CREATE TABLE `ktk_jadwal` (
  `jwl_id` bigint(20) NOT NULL,
  `jwl_don_id` bigint(20) DEFAULT NULL,
  `jwl_tanggal` date DEFAULT NULL,
  `jwl_created` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ktk_jadwal`
--

INSERT INTO `ktk_jadwal` (`jwl_id`, `jwl_don_id`, `jwl_tanggal`, `jwl_created`) VALUES
(40, 10, '2021-03-31', '2021-03-31 11:06:08'),
(41, 10, '2021-04-30', '2021-03-31 11:06:08'),
(42, 10, '2021-05-14', '2021-03-31 11:06:08'),
(43, 11, '2021-03-09', '2021-03-31 11:06:48'),
(44, 11, '2021-08-09', '2021-03-31 11:06:48'),
(45, 12, '2021-03-14', '2021-03-31 11:07:23'),
(46, 12, '2021-10-14', '2021-03-31 11:07:23'),
(52, 13, '2021-01-01', '2021-03-31 11:08:52'),
(53, 13, '2021-05-01', '2021-03-31 11:08:52'),
(54, 13, '2021-10-01', '2021-03-31 11:08:52');

-- --------------------------------------------------------

--
-- Table structure for table `ktk_karyawan`
--

CREATE TABLE `ktk_karyawan` (
  `kry_id` bigint(20) NOT NULL,
  `kry_nama` varchar(50) DEFAULT NULL,
  `kry_jk` smallint(1) DEFAULT NULL COMMENT '1=laki-laki, 2=perempuan',
  `kry_tgl_lahir` date DEFAULT NULL,
  `kry_tempat_lahir` varchar(30) DEFAULT NULL,
  `kry_alamat` varchar(50) DEFAULT NULL,
  `kry_telp` varchar(20) DEFAULT NULL,
  `kry_wa` varchar(20) DEFAULT NULL,
  `kry_created` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ktk_karyawan`
--

INSERT INTO `ktk_karyawan` (`kry_id`, `kry_nama`, `kry_jk`, `kry_tgl_lahir`, `kry_tempat_lahir`, `kry_alamat`, `kry_telp`, `kry_wa`, `kry_created`) VALUES
(1, 'Wegi Zulianda', 1, '1998-08-04', 'Taluk Kuantan', 'Jl. Garuda Sakti km. 2', '089519720386', '089519720386', '2021-03-03 11:01:17'),
(2, 'Rizki Prasetia', 1, '1998-03-29', 'Bangkinang', 'Jl. UKA', '082283839023', '082283839023', '2021-03-06 14:46:57');

-- --------------------------------------------------------

--
-- Table structure for table `ktk_kontak_donatur`
--

CREATE TABLE `ktk_kontak_donatur` (
  `kd_id` bigint(20) NOT NULL,
  `kd_don_id` bigint(20) DEFAULT NULL,
  `kd_nama` varchar(50) DEFAULT NULL,
  `kd_jk` smallint(1) DEFAULT NULL COMMENT '1=laki-laki, 2=perempuan',
  `kd_telp` varchar(20) DEFAULT NULL,
  `kd_wa` varchar(20) DEFAULT NULL,
  `kd_created` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ktk_kontak_donatur`
--

INSERT INTO `ktk_kontak_donatur` (`kd_id`, `kd_don_id`, `kd_nama`, `kd_jk`, `kd_telp`, `kd_wa`, `kd_created`) VALUES
(12, 10, 'Anja', 2, '0812345678', '089519720386', '2021-03-31 12:53:51'),
(13, 11, 'Duis', 2, '0812345678', '089519720386', '2021-03-31 12:54:05'),
(14, 12, 'Dinal', 1, '0812345678', '0812345678', '2021-03-31 12:54:15'),
(15, 13, 'Totoxx', 1, '0812345678', '089519720386', '2021-03-31 12:54:26');

-- --------------------------------------------------------

--
-- Table structure for table `ktk_kotak`
--

CREATE TABLE `ktk_kotak` (
  `kot_id` bigint(20) NOT NULL,
  `kot_nomor` int(11) DEFAULT NULL,
  `kot_status` smallint(1) DEFAULT NULL COMMENT '0=gudang, 1=disebar',
  `kot_don_id` bigint(20) DEFAULT NULL,
  `kot_ref_id` bigint(20) DEFAULT NULL,
  `kot_created` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ktk_kotak`
--

INSERT INTO `ktk_kotak` (`kot_id`, `kot_nomor`, `kot_status`, `kot_don_id`, `kot_ref_id`, `kot_created`) VALUES
(55, 1, 1, 10, 17, '2021-03-31 12:57:14'),
(56, 2, 1, 11, 17, '2021-03-31 12:57:14'),
(57, 3, 1, 13, 17, '2021-03-31 12:57:14'),
(58, 4, 0, NULL, 17, '2021-03-31 12:57:14'),
(59, 5, 1, 12, 17, '2021-03-31 12:57:14'),
(60, 6, 0, NULL, 17, '2021-03-31 12:57:14'),
(61, 7, 0, NULL, 17, '2021-03-31 12:57:14'),
(62, 8, 0, NULL, 17, '2021-03-31 12:57:14'),
(63, 9, 0, NULL, 17, '2021-03-31 12:57:14'),
(64, 10, 0, NULL, 17, '2021-03-31 12:57:14');

-- --------------------------------------------------------

--
-- Table structure for table `ktk_kotak_keluar`
--

CREATE TABLE `ktk_kotak_keluar` (
  `kel_id` bigint(20) NOT NULL,
  `kel_tgl` date DEFAULT NULL,
  `kel_don_id` bigint(20) DEFAULT NULL,
  `kel_kry_id` bigint(20) DEFAULT NULL,
  `kel_kot_nomor` int(11) DEFAULT NULL,
  `kel_ket` varchar(20) DEFAULT NULL,
  `kel_created` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ktk_kotak_keluar`
--

INSERT INTO `ktk_kotak_keluar` (`kel_id`, `kel_tgl`, `kel_don_id`, `kel_kry_id`, `kel_kot_nomor`, `kel_ket`, `kel_created`) VALUES
(13, '2021-03-05', 10, 1, 1, 'keluar1', '2021-03-31 13:14:41'),
(14, '2021-03-06', 11, 1, 2, 'keluar2', '2021-03-31 13:15:16'),
(15, '2021-03-08', 12, 2, 5, 'keluar3', '2021-03-31 13:17:47'),
(16, '2021-03-09', 13, 2, 3, 'keluar4', '2021-03-31 13:18:21');

-- --------------------------------------------------------

--
-- Table structure for table `ktk_kotak_masuk`
--

CREATE TABLE `ktk_kotak_masuk` (
  `msk_id` bigint(20) NOT NULL,
  `msk_tgl` date DEFAULT NULL,
  `msk_nomor_awal` int(11) DEFAULT NULL,
  `msk_nomor_akhir` int(11) DEFAULT NULL,
  `msk_jumlah` int(11) DEFAULT NULL,
  `msk_ket` varchar(50) DEFAULT NULL,
  `msk_created` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ktk_kotak_masuk`
--

INSERT INTO `ktk_kotak_masuk` (`msk_id`, `msk_tgl`, `msk_nomor_awal`, `msk_nomor_akhir`, `msk_jumlah`, `msk_ket`, `msk_created`) VALUES
(17, '2021-03-03', 1, 10, 10, 'masuk1', '2021-03-31 12:57:14');

-- --------------------------------------------------------

--
-- Table structure for table `ktk_kwitansi`
--

CREATE TABLE `ktk_kwitansi` (
  `kw_id` bigint(20) NOT NULL,
  `kw_pkw_id` bigint(20) DEFAULT NULL,
  `kw_nomor` int(11) DEFAULT NULL,
  `kw_pemegang` bigint(20) DEFAULT NULL,
  `kw_status` smallint(1) DEFAULT NULL COMMENT '0=Belum Digunakan, 1=Digunakan, 2=Sudah Disetor, 3=Dikembalikan, 4=Hilang',
  `kw_ket` varchar(255) DEFAULT NULL,
  `kw_don_id` bigint(20) DEFAULT NULL COMMENT 'ID donatur jika sudah digunakan',
  `kw_tgl` date DEFAULT NULL COMMENT 'Tgl penggunaan'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `ktk_kwitansi`
--

INSERT INTO `ktk_kwitansi` (`kw_id`, `kw_pkw_id`, `kw_nomor`, `kw_pemegang`, `kw_status`, `kw_ket`, `kw_don_id`, `kw_tgl`) VALUES
(30, 1, 1, 1, 1, NULL, 10, '2021-04-06'),
(31, 1, 2, 1, 0, NULL, NULL, NULL),
(32, 1, 3, 1, 0, NULL, NULL, NULL),
(33, 11, 4, 2, 0, NULL, NULL, NULL),
(34, 11, 5, 2, 1, NULL, 12, '2021-04-06'),
(35, 11, 6, 2, 0, NULL, NULL, NULL),
(36, 11, 7, 2, 0, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `ktk_login`
--

CREATE TABLE `ktk_login` (
  `log_id` bigint(20) NOT NULL,
  `log_username` varchar(20) DEFAULT NULL,
  `log_nama` varchar(255) DEFAULT NULL,
  `log_password` varchar(255) DEFAULT NULL,
  `log_level` smallint(1) DEFAULT NULL,
  `log_kry_id` bigint(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ktk_login`
--

INSERT INTO `ktk_login` (`log_id`, `log_username`, `log_nama`, `log_password`, `log_level`, `log_kry_id`) VALUES
(1, 'admin', 'Admin', 'aaf4c28b2493222c60731a05e718dafe', 1, NULL),
(2, 'rizki', 'Rizki Prasetia', 'aaf4c28b2493222c60731a05e718dafe', 3, 2),
(3, 'wegizul', 'Wegi Zulianda', '4be70c052e661e3e883a89d938c68136', 3, 1);

-- --------------------------------------------------------

--
-- Table structure for table `ktk_pecahan_pengumpulan`
--

CREATE TABLE `ktk_pecahan_pengumpulan` (
  `pcg_id` bigint(20) NOT NULL,
  `pcg_jpt_id` bigint(20) DEFAULT NULL,
  `pcg_jenis` enum('Logam','Kertas') DEFAULT NULL,
  `pcg_nilai` int(20) DEFAULT NULL,
  `pcg_jml` int(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ktk_pecahan_pengumpulan`
--

INSERT INTO `ktk_pecahan_pengumpulan` (`pcg_id`, `pcg_jpt_id`, `pcg_jenis`, `pcg_nilai`, `pcg_jml`) VALUES
(34, 9, 'Logam', 100, 2),
(35, 9, 'Logam', 1000, 1),
(36, 9, 'Kertas', 1000, 3),
(39, 10, 'Logam', 200, 5),
(40, 10, 'Kertas', 2000, 8);

-- --------------------------------------------------------

--
-- Table structure for table `ktk_pecahan_uang`
--

CREATE TABLE `ktk_pecahan_uang` (
  `pec_id` bigint(20) NOT NULL,
  `pec_jenis` enum('Logam','Kertas') DEFAULT NULL,
  `pec_nilai` int(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ktk_pecahan_uang`
--

INSERT INTO `ktk_pecahan_uang` (`pec_id`, `pec_jenis`, `pec_nilai`) VALUES
(16, 'Logam', 100),
(17, 'Logam', 200),
(18, 'Logam', 500),
(20, 'Logam', 1000),
(21, 'Kertas', 1000),
(22, 'Kertas', 2000),
(23, 'Kertas', 5000),
(24, 'Kertas', 10000),
(25, 'Kertas', 20000),
(26, 'Kertas', 50000),
(27, 'Kertas', 100000);

-- --------------------------------------------------------

--
-- Table structure for table `ktk_pengambilan_kwitansi`
--

CREATE TABLE `ktk_pengambilan_kwitansi` (
  `pkw_id` bigint(20) NOT NULL,
  `pkw_kry_id` bigint(20) DEFAULT NULL,
  `pkw_tgl` date DEFAULT NULL,
  `pkw_waktu_entry` datetime DEFAULT NULL,
  `pkw_user_entry` varchar(255) DEFAULT NULL,
  `pkw_awal` int(11) DEFAULT NULL,
  `pkw_akhir` int(11) DEFAULT NULL,
  `pkw_jml` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `ktk_pengambilan_kwitansi`
--

INSERT INTO `ktk_pengambilan_kwitansi` (`pkw_id`, `pkw_kry_id`, `pkw_tgl`, `pkw_waktu_entry`, `pkw_user_entry`, `pkw_awal`, `pkw_akhir`, `pkw_jml`) VALUES
(10, 1, '2021-03-04', '2021-03-31 13:36:34', '1', 1, 3, 3),
(11, 2, '2021-03-04', '2021-03-31 13:37:11', '1', 4, 7, 4);

-- --------------------------------------------------------

--
-- Table structure for table `ktk_penjemputan`
--

CREATE TABLE `ktk_penjemputan` (
  `jpt_id` bigint(20) NOT NULL,
  `jpt_tgs_tgl` date DEFAULT NULL,
  `jpt_tgs_id` bigint(20) DEFAULT NULL,
  `jpt_kry_id` bigint(20) DEFAULT NULL,
  `jpt_don_id` bigint(20) DEFAULT NULL,
  `jpt_status` int(1) DEFAULT NULL,
  `jpt_tgl_jemput` datetime DEFAULT CURRENT_TIMESTAMP,
  `jpt_user_jemput` varchar(100) DEFAULT NULL,
  `jpt_tgl_hitung` datetime DEFAULT NULL,
  `jpt_user_hitung` varchar(100) DEFAULT NULL,
  `jpt_jml_pecahan` int(11) DEFAULT NULL,
  `jpt_kw_nomor` int(11) DEFAULT NULL,
  `jpt_kwitansi` varchar(50) DEFAULT NULL,
  `jpt_tgl_validasi` datetime DEFAULT NULL,
  `jpt_user_validasi` bigint(20) DEFAULT NULL,
  `jpt_catatan` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ktk_penjemputan`
--

INSERT INTO `ktk_penjemputan` (`jpt_id`, `jpt_tgs_tgl`, `jpt_tgs_id`, `jpt_kry_id`, `jpt_don_id`, `jpt_status`, `jpt_tgl_jemput`, `jpt_user_jemput`, `jpt_tgl_hitung`, `jpt_user_hitung`, `jpt_jml_pecahan`, `jpt_kw_nomor`, `jpt_kwitansi`, `jpt_tgl_validasi`, `jpt_user_validasi`, `jpt_catatan`) VALUES
(9, '2021-04-01', 50, 2, 12, 2, '2021-04-06 10:13:51', '2', '2021-04-06 10:13:52', '2', 4200, 5, '9-file.png', NULL, NULL, NULL),
(10, '2021-04-01', 48, 1, 10, 2, '2021-08-30 12:47:45', '3', '2021-08-30 12:47:45', '3', 17000, NULL, '10-file.png', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `ktk_penugasan`
--

CREATE TABLE `ktk_penugasan` (
  `tgs_id` bigint(20) NOT NULL,
  `tgs_tanggal` date DEFAULT NULL,
  `tgs_kry_id` bigint(20) DEFAULT NULL,
  `tgs_don_id` bigint(20) DEFAULT NULL,
  `tgs_status` smallint(1) DEFAULT '0',
  `tgs_created` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ktk_penugasan`
--

INSERT INTO `ktk_penugasan` (`tgs_id`, `tgs_tanggal`, `tgs_kry_id`, `tgs_don_id`, `tgs_status`, `tgs_created`) VALUES
(48, '2021-04-01', 1, 10, 2, '2021-03-31 13:21:19'),
(50, '2021-04-01', 2, 12, 2, '2021-03-31 13:22:51'),
(51, '2021-05-26', 1, 11, 1, '2021-05-26 23:01:24');

-- --------------------------------------------------------

--
-- Table structure for table `ktk_spesimen`
--

CREATE TABLE `ktk_spesimen` (
  `sps_id` bigint(20) NOT NULL,
  `sps_kry_id` bigint(20) DEFAULT NULL,
  `sps_nama` varchar(30) DEFAULT NULL,
  `sps_foto` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ktk_spesimen`
--

INSERT INTO `ktk_spesimen` (`sps_id`, `sps_kry_id`, `sps_nama`, `sps_foto`) VALUES
(3, 2, 'coba', 'ttd-1617351279.3817.png');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ktk_donatur`
--
ALTER TABLE `ktk_donatur`
  ADD PRIMARY KEY (`don_id`);

--
-- Indexes for table `ktk_history`
--
ALTER TABLE `ktk_history`
  ADD PRIMARY KEY (`his_id`);

--
-- Indexes for table `ktk_jadwal`
--
ALTER TABLE `ktk_jadwal`
  ADD PRIMARY KEY (`jwl_id`);

--
-- Indexes for table `ktk_karyawan`
--
ALTER TABLE `ktk_karyawan`
  ADD PRIMARY KEY (`kry_id`);

--
-- Indexes for table `ktk_kontak_donatur`
--
ALTER TABLE `ktk_kontak_donatur`
  ADD PRIMARY KEY (`kd_id`);

--
-- Indexes for table `ktk_kotak`
--
ALTER TABLE `ktk_kotak`
  ADD PRIMARY KEY (`kot_id`);

--
-- Indexes for table `ktk_kotak_keluar`
--
ALTER TABLE `ktk_kotak_keluar`
  ADD PRIMARY KEY (`kel_id`);

--
-- Indexes for table `ktk_kotak_masuk`
--
ALTER TABLE `ktk_kotak_masuk`
  ADD PRIMARY KEY (`msk_id`);

--
-- Indexes for table `ktk_kwitansi`
--
ALTER TABLE `ktk_kwitansi`
  ADD PRIMARY KEY (`kw_id`) USING BTREE;

--
-- Indexes for table `ktk_login`
--
ALTER TABLE `ktk_login`
  ADD PRIMARY KEY (`log_id`);

--
-- Indexes for table `ktk_pecahan_pengumpulan`
--
ALTER TABLE `ktk_pecahan_pengumpulan`
  ADD PRIMARY KEY (`pcg_id`);

--
-- Indexes for table `ktk_pecahan_uang`
--
ALTER TABLE `ktk_pecahan_uang`
  ADD PRIMARY KEY (`pec_id`);

--
-- Indexes for table `ktk_pengambilan_kwitansi`
--
ALTER TABLE `ktk_pengambilan_kwitansi`
  ADD PRIMARY KEY (`pkw_id`) USING BTREE;

--
-- Indexes for table `ktk_penjemputan`
--
ALTER TABLE `ktk_penjemputan`
  ADD PRIMARY KEY (`jpt_id`);

--
-- Indexes for table `ktk_penugasan`
--
ALTER TABLE `ktk_penugasan`
  ADD PRIMARY KEY (`tgs_id`);

--
-- Indexes for table `ktk_spesimen`
--
ALTER TABLE `ktk_spesimen`
  ADD PRIMARY KEY (`sps_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ktk_donatur`
--
ALTER TABLE `ktk_donatur`
  MODIFY `don_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `ktk_history`
--
ALTER TABLE `ktk_history`
  MODIFY `his_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `ktk_jadwal`
--
ALTER TABLE `ktk_jadwal`
  MODIFY `jwl_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT for table `ktk_karyawan`
--
ALTER TABLE `ktk_karyawan`
  MODIFY `kry_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `ktk_kontak_donatur`
--
ALTER TABLE `ktk_kontak_donatur`
  MODIFY `kd_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `ktk_kotak`
--
ALTER TABLE `ktk_kotak`
  MODIFY `kot_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;

--
-- AUTO_INCREMENT for table `ktk_kotak_keluar`
--
ALTER TABLE `ktk_kotak_keluar`
  MODIFY `kel_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `ktk_kotak_masuk`
--
ALTER TABLE `ktk_kotak_masuk`
  MODIFY `msk_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `ktk_kwitansi`
--
ALTER TABLE `ktk_kwitansi`
  MODIFY `kw_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `ktk_login`
--
ALTER TABLE `ktk_login`
  MODIFY `log_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `ktk_pecahan_pengumpulan`
--
ALTER TABLE `ktk_pecahan_pengumpulan`
  MODIFY `pcg_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `ktk_pecahan_uang`
--
ALTER TABLE `ktk_pecahan_uang`
  MODIFY `pec_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `ktk_pengambilan_kwitansi`
--
ALTER TABLE `ktk_pengambilan_kwitansi`
  MODIFY `pkw_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `ktk_penjemputan`
--
ALTER TABLE `ktk_penjemputan`
  MODIFY `jpt_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `ktk_penugasan`
--
ALTER TABLE `ktk_penugasan`
  MODIFY `tgs_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT for table `ktk_spesimen`
--
ALTER TABLE `ktk_spesimen`
  MODIFY `sps_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
