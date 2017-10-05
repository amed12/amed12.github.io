-- phpMyAdmin SQL Dump
-- version 4.4.3
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jul 14, 2017 at 06:48 PM
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
  `userId` varchar(12) DEFAULT NULL,
  `password` varchar(12) DEFAULT NULL,
  `idLevel` int(11) DEFAULT NULL,
  `status` enum('open','close') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- RELATIONS FOR TABLE `akses`:
--   `idLevel`
--       `level` -> `id`
--

-- --------------------------------------------------------

--
-- Table structure for table `bea`
--

CREATE TABLE IF NOT EXISTS `bea` (
  `id` int(11) NOT NULL,
  `namaBeasiswa` varchar(100) DEFAULT NULL,
  `penyelenggaraBea` varchar(100) DEFAULT NULL,
  `beasiswaDibuka` date DEFAULT NULL,
  `beasiswaTutup` date DEFAULT NULL,
  `statusBeasiswa` tinyint(1) DEFAULT NULL,
  `statusTabel` enum('sudah','belum') DEFAULT NULL,
  `kuota` char(10) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- RELATIONS FOR TABLE `bea`:
--

--
-- Dumping data for table `bea`
--

INSERT INTO `bea` (`id`, `namaBeasiswa`, `penyelenggaraBea`, `beasiswaDibuka`, `beasiswaTutup`, `statusBeasiswa`, `statusTabel`, `kuota`) VALUES
(1, 'Prestasi', 'UIN Malang', '2017-07-04', '2017-07-18', 1, 'sudah', '50');

-- --------------------------------------------------------

--
-- Table structure for table `fakultas`
--

CREATE TABLE IF NOT EXISTS `fakultas` (
  `id` int(11) NOT NULL,
  `namaFk` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- RELATIONS FOR TABLE `fakultas`:
--

-- --------------------------------------------------------

--
-- Table structure for table `identitas_mhs`
--

CREATE TABLE IF NOT EXISTS `identitas_mhs` (
  `nimMhs` int(11) NOT NULL,
  `namaLengkap` varchar(100) DEFAULT NULL,
  `tempatLahir` text,
  `tglLahir` date DEFAULT NULL,
  `asalKota` varchar(20) DEFAULT NULL,
  `namaOrtu` varchar(20) DEFAULT NULL,
  `alamatOrtu` text,
  `kotaOrtu` varchar(30) DEFAULT NULL,
  `propinsiOrtu` varchar(30) DEFAULT NULL,
  `angkatan` char(5) DEFAULT NULL,
  `jenisKel` tinyint(1) DEFAULT NULL,
  `alamatLengkap` text,
  `emailAktif` varchar(100) DEFAULT NULL,
  `noTelp` char(12) DEFAULT NULL,
  `fotoMhs` varchar(10) DEFAULT NULL,
  `idJrs` int(11) DEFAULT NULL,
  `idAkses` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- RELATIONS FOR TABLE `identitas_mhs`:
--   `idAkses`
--       `akses` -> `id`
--   `idJrs`
--       `jurusan` -> `id`
--

-- --------------------------------------------------------

--
-- Table structure for table `jurusan`
--

CREATE TABLE IF NOT EXISTS `jurusan` (
  `id` int(11) NOT NULL,
  `namaJur` varchar(100) DEFAULT NULL,
  `idFk` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- RELATIONS FOR TABLE `jurusan`:
--   `idFk`
--       `fakultas` -> `id`
--

-- --------------------------------------------------------

--
-- Table structure for table `kategori_skor`
--

CREATE TABLE IF NOT EXISTS `kategori_skor` (
  `id` int(11) NOT NULL,
  `nama` varchar(150) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

--
-- RELATIONS FOR TABLE `kategori_skor`:
--

--
-- Dumping data for table `kategori_skor`
--

INSERT INTO `kategori_skor` (`id`, `nama`) VALUES
(1, 'PLN'),
(2, 'Penghasilan Ayah');

-- --------------------------------------------------------

--
-- Table structure for table `level`
--

CREATE TABLE IF NOT EXISTS `level` (
  `id` int(11) NOT NULL,
  `level` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- RELATIONS FOR TABLE `level`:
--

-- --------------------------------------------------------

--
-- Table structure for table `penerima_bea`
--

CREATE TABLE IF NOT EXISTS `penerima_bea` (
  `nim` int(11) DEFAULT NULL,
  `idBea` int(11) DEFAULT NULL,
  `totalBobot` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- RELATIONS FOR TABLE `penerima_bea`:
--   `nim`
--       `identitas_mhs` -> `nimMhs`
--   `idBea`
--       `bea` -> `id`
--

-- --------------------------------------------------------

--
-- Table structure for table `profil_admin`
--

CREATE TABLE IF NOT EXISTS `profil_admin` (
  `id` int(11) NOT NULL,
  `nama` varchar(50) DEFAULT NULL,
  `alamat` varchar(50) DEFAULT NULL,
  `noTelp` char(20) DEFAULT NULL,
  `email` varchar(30) DEFAULT NULL,
  `idAkses` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- RELATIONS FOR TABLE `profil_admin`:
--   `idAkses`
--       `akses` -> `id`
--

-- --------------------------------------------------------

--
-- Table structure for table `set_bea_kategori_skor`
--

CREATE TABLE IF NOT EXISTS `set_bea_kategori_skor` (
  `id` int(11) NOT NULL,
  `idBea` int(11) NOT NULL,
  `idKategoriSkor` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- RELATIONS FOR TABLE `set_bea_kategori_skor`:
--   `idBea`
--       `bea` -> `id`
--   `idKategoriSkor`
--       `kategori_skor` -> `id`
--

--
-- Dumping data for table `set_bea_kategori_skor`
--

INSERT INTO `set_bea_kategori_skor` (`id`, `idBea`, `idKategoriSkor`) VALUES
(3, 1, 1),
(4, 1, 2);

-- --------------------------------------------------------

--
-- Table structure for table `set_sub_kategori_skor`
--

CREATE TABLE IF NOT EXISTS `set_sub_kategori_skor` (
  `id` int(11) NOT NULL,
  `idKategoriSkor` int(11) NOT NULL,
  `nama` varchar(150) NOT NULL,
  `skor` int(7) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=latin1;

--
-- RELATIONS FOR TABLE `set_sub_kategori_skor`:
--   `idKategoriSkor`
--       `kategori_skor` -> `id`
--

--
-- Dumping data for table `set_sub_kategori_skor`
--

INSERT INTO `set_sub_kategori_skor` (`id`, `idKategoriSkor`, `nama`, `skor`) VALUES
(1, 1, '<450', 1),
(2, 1, '450-750', 2),
(3, 1, '750-900', 3),
(4, 1, '900-1000', 4),
(8, 2, '700-900rb', 3),
(9, 2, '900-1000rb', 4),
(10, 2, '>1000rb', 5);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `akses`
--
ALTER TABLE `akses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_level` (`idLevel`);

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
  ADD PRIMARY KEY (`nimMhs`),
  ADD KEY `jurusan-mhs` (`idJrs`),
  ADD KEY `id_akses` (`idAkses`);

--
-- Indexes for table `jurusan`
--
ALTER TABLE `jurusan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jurusan_fk` (`idFk`);

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
  ADD KEY `id_bea` (`idBea`);

--
-- Indexes for table `profil_admin`
--
ALTER TABLE `profil_admin`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_akses` (`idAkses`);

--
-- Indexes for table `set_bea_kategori_skor`
--
ALTER TABLE `set_bea_kategori_skor`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_bea` (`idBea`),
  ADD KEY `id_kategori_skor` (`idKategoriSkor`);

--
-- Indexes for table `set_sub_kategori_skor`
--
ALTER TABLE `set_sub_kategori_skor`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_kategori_skor` (`idKategoriSkor`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=9;
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `set_sub_kategori_skor`
--
ALTER TABLE `set_sub_kategori_skor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=21;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `akses`
--
ALTER TABLE `akses`
  ADD CONSTRAINT `akses_ibfk_1` FOREIGN KEY (`idLevel`) REFERENCES `level` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `identitas_mhs`
--
ALTER TABLE `identitas_mhs`
  ADD CONSTRAINT `identitas_mhs_ibfk_1` FOREIGN KEY (`idAkses`) REFERENCES `akses` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `jurusan-mhs` FOREIGN KEY (`idJrs`) REFERENCES `jurusan` (`id`);

--
-- Constraints for table `jurusan`
--
ALTER TABLE `jurusan`
  ADD CONSTRAINT `jurusan_fk` FOREIGN KEY (`idFk`) REFERENCES `fakultas` (`id`);

--
-- Constraints for table `penerima_bea`
--
ALTER TABLE `penerima_bea`
  ADD CONSTRAINT `penerima_bea_ibfk_1` FOREIGN KEY (`nim`) REFERENCES `identitas_mhs` (`nimMhs`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `penerima_bea_ibfk_2` FOREIGN KEY (`idBea`) REFERENCES `bea` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `profil_admin`
--
ALTER TABLE `profil_admin`
  ADD CONSTRAINT `profil_admin_ibfk_1` FOREIGN KEY (`idAkses`) REFERENCES `akses` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `set_bea_kategori_skor`
--
ALTER TABLE `set_bea_kategori_skor`
  ADD CONSTRAINT `set_bea_kategori_skor_ibfk_1` FOREIGN KEY (`idBea`) REFERENCES `bea` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `set_bea_kategori_skor_ibfk_2` FOREIGN KEY (`idKategoriSkor`) REFERENCES `kategori_skor` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `set_sub_kategori_skor`
--
ALTER TABLE `set_sub_kategori_skor`
  ADD CONSTRAINT `set_sub_kategori_skor_ibfk_1` FOREIGN KEY (`idKategoriSkor`) REFERENCES `kategori_skor` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
