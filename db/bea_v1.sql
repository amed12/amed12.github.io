-- phpMyAdmin SQL Dump
-- version 4.4.3
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 25, 2017 at 11:08 
-- Server version: 5.6.24
-- PHP Version: 5.6.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `bea`
--

-- --------------------------------------------------------

--
-- Table structure for table `akses`
--

CREATE TABLE IF NOT EXISTS `akses` (
  `id` int(11) NOT NULL,
  `user-id` varchar(12) DEFAULT NULL,
  `password` varchar(12) DEFAULT NULL,
  `id-level` int(11) DEFAULT NULL,
  `status` enum('open','close') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `bea`
--

CREATE TABLE IF NOT EXISTS `bea` (
  `id` int(11) NOT NULL,
  `nama-beasiswa` varchar(100) DEFAULT NULL,
  `penyelenggara-bea` varchar(100) DEFAULT NULL,
  `beasiswa-dibuka` date DEFAULT NULL,
  `beasiswa-tutup` date DEFAULT NULL,
  `status-beasiswa` tinyint(1) DEFAULT NULL,
  `status-tabel` enum('sudah','belum') DEFAULT NULL,
  `kuota` char(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `fakultas`
--

CREATE TABLE IF NOT EXISTS `fakultas` (
  `id` int(11) NOT NULL,
  `nama-fk` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `identitas_mhs`
--

CREATE TABLE IF NOT EXISTS `identitas_mhs` (
  `nim-mhs` int(11) NOT NULL,
  `nama-lengkap` varchar(100) DEFAULT NULL,
  `tempat-lahir` text,
  `tgl-lahir` date DEFAULT NULL,
  `asal-kota` varchar(20) DEFAULT NULL,
  `nama-ortu` varchar(20) DEFAULT NULL,
  `alamat-ortu` text,
  `kota-ortu` varchar(30) DEFAULT NULL,
  `propinsi-ortu` varchar(30) DEFAULT NULL,
  `angkatan` char(5) DEFAULT NULL,
  `jenis-kel` tinyint(1) DEFAULT NULL,
  `alamat-lengkap` text,
  `email-aktif` varchar(100) DEFAULT NULL,
  `no-telp` char(12) DEFAULT NULL,
  `foto-mhs` varchar(10) DEFAULT NULL,
  `id-jrs` int(11) DEFAULT NULL,
  `id-akses` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `jurusan`
--

CREATE TABLE IF NOT EXISTS `jurusan` (
  `id` int(11) NOT NULL,
  `nama-jur` varchar(100) DEFAULT NULL,
  `id-fk` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `kategori_skor`
--

CREATE TABLE IF NOT EXISTS `kategori_skor` (
  `id` int(11) NOT NULL,
  `nama` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `level`
--

CREATE TABLE IF NOT EXISTS `level` (
  `id` int(11) NOT NULL,
  `level` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `penerima_bea`
--

CREATE TABLE IF NOT EXISTS `penerima_bea` (
  `nim` int(11) DEFAULT NULL,
  `id-bea` int(11) DEFAULT NULL,
  `total_bobot` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `profil_admin`
--

CREATE TABLE IF NOT EXISTS `profil_admin` (
  `id` int(11) NOT NULL,
  `nama` varchar(50) DEFAULT NULL,
  `alamat` varchar(50) DEFAULT NULL,
  `no-telp` char(20) DEFAULT NULL,
  `email` varchar(30) DEFAULT NULL,
  `id-akses` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `set_bea_kategori_skor`
--

CREATE TABLE IF NOT EXISTS `set_bea_kategori_skor` (
  `id` int(11) NOT NULL,
  `id-bea` int(11) NOT NULL,
  `id-kategori-skor` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `set_sub_kategori_skor`
--

CREATE TABLE IF NOT EXISTS `set_sub_kategori_skor` (
  `id` int(11) NOT NULL,
  `id-kategori-skor` int(11) NOT NULL,
  `nama` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `akses`
--
ALTER TABLE `akses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_level` (`id-level`);

--
-- Indexes for table `bea`
--
ALTER TABLE `bea`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fakultas`
--
ALTER TABLE `fakultas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `identitas_mhs`
--
ALTER TABLE `identitas_mhs`
  ADD PRIMARY KEY (`nim-mhs`),
  ADD KEY `jurusan-mhs` (`id-jrs`),
  ADD KEY `id_akses` (`id-akses`);

--
-- Indexes for table `jurusan`
--
ALTER TABLE `jurusan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jurusan_fk` (`id-fk`);

--
-- Indexes for table `kategori_skor`
--
ALTER TABLE `kategori_skor`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `level`
--
ALTER TABLE `level`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `penerima_bea`
--
ALTER TABLE `penerima_bea`
  ADD KEY `nim` (`nim`),
  ADD KEY `id_bea` (`id-bea`);

--
-- Indexes for table `profil_admin`
--
ALTER TABLE `profil_admin`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_akses` (`id-akses`);

--
-- Indexes for table `set_bea_kategori_skor`
--
ALTER TABLE `set_bea_kategori_skor`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_bea` (`id-bea`),
  ADD KEY `id_kategori_skor` (`id-kategori-skor`);

--
-- Indexes for table `set_sub_kategori_skor`
--
ALTER TABLE `set_sub_kategori_skor`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_kategori_skor` (`id-kategori-skor`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `akses`
--
ALTER TABLE `akses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `bea`
--
ALTER TABLE `bea`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `fakultas`
--
ALTER TABLE `fakultas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `jurusan`
--
ALTER TABLE `jurusan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `kategori_skor`
--
ALTER TABLE `kategori_skor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `level`
--
ALTER TABLE `level`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `profil_admin`
--
ALTER TABLE `profil_admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `set_bea_kategori_skor`
--
ALTER TABLE `set_bea_kategori_skor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `set_sub_kategori_skor`
--
ALTER TABLE `set_sub_kategori_skor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `akses`
--
ALTER TABLE `akses`
  ADD CONSTRAINT `akses_ibfk_1` FOREIGN KEY (`id-level`) REFERENCES `level` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `identitas_mhs`
--
ALTER TABLE `identitas_mhs`
  ADD CONSTRAINT `identitas_mhs_ibfk_1` FOREIGN KEY (`id-akses`) REFERENCES `akses` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `jurusan-mhs` FOREIGN KEY (`id-jrs`) REFERENCES `jurusan` (`id`);

--
-- Constraints for table `jurusan`
--
ALTER TABLE `jurusan`
  ADD CONSTRAINT `jurusan_fk` FOREIGN KEY (`id-fk`) REFERENCES `fakultas` (`id`);

--
-- Constraints for table `penerima_bea`
--
ALTER TABLE `penerima_bea`
  ADD CONSTRAINT `penerima_bea_ibfk_1` FOREIGN KEY (`nim`) REFERENCES `identitas_mhs` (`nim-mhs`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `penerima_bea_ibfk_2` FOREIGN KEY (`id-bea`) REFERENCES `bea` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `profil_admin`
--
ALTER TABLE `profil_admin`
  ADD CONSTRAINT `profil_admin_ibfk_1` FOREIGN KEY (`id-akses`) REFERENCES `akses` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `set_bea_kategori_skor`
--
ALTER TABLE `set_bea_kategori_skor`
  ADD CONSTRAINT `set_bea_kategori_skor_ibfk_1` FOREIGN KEY (`id-bea`) REFERENCES `bea` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `set_bea_kategori_skor_ibfk_2` FOREIGN KEY (`id-kategori-skor`) REFERENCES `kategori_skor` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `set_sub_kategori_skor`
--
ALTER TABLE `set_sub_kategori_skor`
  ADD CONSTRAINT `set_sub_kategori_skor_ibfk_1` FOREIGN KEY (`id-kategori-skor`) REFERENCES `kategori_skor` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
