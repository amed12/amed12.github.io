-- phpMyAdmin SQL Dump
-- version 4.7.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Sep 28, 2017 at 01:46 AM
-- Server version: 10.1.26-MariaDB
-- PHP Version: 7.1.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `beasiswa`
--

-- --------------------------------------------------------

--
-- Table structure for table `akses`
--

CREATE TABLE `akses` (
  `id` int(11) NOT NULL,
  `userId` varchar(12) DEFAULT NULL,
  `password` text,
  `idLevel` int(11) DEFAULT NULL,
  `status` enum('open','close') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `akses`
--

INSERT INTO `akses` (`id`, `userId`, `password`, `idLevel`, `status`) VALUES
(25, '1', '1', 1, 'open'),
(26, '2', '2', 2, 'open'),
(27, '3', '3', 3, 'open'),
(28, '4', '4', 4, 'open'),
(29, '5', '5', 5, 'open'),
(34, '6', '6', 6, 'open'),
(35, '15650025', '15650025', 5, 'open');

-- --------------------------------------------------------

--
-- Table structure for table `bea`
--

CREATE TABLE `bea` (
  `id` int(11) NOT NULL,
  `namaBeasiswa` varchar(100) DEFAULT NULL,
  `penyelenggaraBea` varchar(100) DEFAULT NULL,
  `kuota` char(10) DEFAULT NULL,
  `beasiswaDibuka` date DEFAULT NULL COMMENT 'pendaftaran',
  `beasiswaTutup` date DEFAULT NULL COMMENT 'pendaftaran',
  `periodeBerakhir` date DEFAULT NULL,
  `statusBeasiswa` tinyint(1) DEFAULT '2' COMMENT '0=pendaftaran_tutup, 1=aktif, 2=ditolak, 3=dikonfirmasi',
  `statusSeleksi` enum('0','1') NOT NULL DEFAULT '0' COMMENT '0=non aktif, 1=aktif',
  `selektor` int(1) NOT NULL COMMENT '1=kasubag kemahasiswaa, 2=kasubag fakultas, 3=keduanya',
  `selektorFakultas` int(5) DEFAULT NULL COMMENT 'berisi idFakultas',
  `keterangan` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `bea`
--

INSERT INTO `bea` (`id`, `namaBeasiswa`, `penyelenggaraBea`, `kuota`, `beasiswaDibuka`, `beasiswaTutup`, `periodeBerakhir`, `statusBeasiswa`, `statusSeleksi`, `selektor`, `selektorFakultas`, `keterangan`) VALUES
(1, 'Prestasi', 'UIN Malang', '50', '2017-08-01', '2017-08-31', '2018-08-25', 0, '0', 1, NULL, NULL),
(12, 'BRI Prestasi', 'Bank BRI Syariah', '45', '2017-07-05', '2017-07-19', '2018-08-03', 0, '1', 3, 6, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `berita`
--

CREATE TABLE `berita` (
  `idBerita` int(11) NOT NULL,
  `judulBerita` text,
  `topikBerita` text,
  `penulisBerita` varchar(100) DEFAULT NULL,
  `kontenBerita` text,
  `tglInBerita` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `berita`
--

INSERT INTO `berita` (`idBerita`, `judulBerita`, `topikBerita`, `penulisBerita`, `kontenBerita`, `tglInBerita`) VALUES
(1, 'Beasiswa PPA', 'Pendaftaran', '08:19:24', 'Pendaftaran Beasiswa', '2017-07-31 07:11:53'),
(2, 'Pengumuman bidik misi 2017', 'bidikmisi', '00:00:00', 'Selamat kepada para penerima', '2017-08-02 17:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `fakultas`
--

CREATE TABLE `fakultas` (
  `id` int(11) NOT NULL,
  `namaFk` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `fakultas`
--

INSERT INTO `fakultas` (`id`, `namaFk`) VALUES
(1, 'Tarbiyah dan Ilmu Keguruan'),
(2, 'Syari’ah'),
(3, 'Humaniora'),
(4, 'Psikologi'),
(5, 'Ekonomi'),
(6, 'Sains dan Teknologi');

-- --------------------------------------------------------

--
-- Table structure for table `identitas_mhs`
--

CREATE TABLE `identitas_mhs` (
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
  `fotoMhs` varchar(100) DEFAULT NULL,
  `idJrs` int(11) DEFAULT NULL,
  `idAkses` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `identitas_mhs`
--

INSERT INTO `identitas_mhs` (`nimMhs`, `namaLengkap`, `tempatLahir`, `tglLahir`, `asalKota`, `namaOrtu`, `alamatOrtu`, `kotaOrtu`, `propinsiOrtu`, `angkatan`, `jenisKel`, `alamatLengkap`, `emailAktif`, `noTelp`, `fotoMhs`, `idJrs`, `idAkses`) VALUES
(15650025, 'Muhammad', 'Malang', '2017-08-01', 'Malang', 'Muh', 'Malang', 'Malang', 'Jawa Timur', '2017', 1, 'Malang', 'Muhammad@gmail.com', '085756787654', 'file_1503562985.png', 6, 29);

-- --------------------------------------------------------

--
-- Table structure for table `jurusan`
--

CREATE TABLE `jurusan` (
  `id` int(11) NOT NULL,
  `namaJur` varchar(100) DEFAULT NULL,
  `idFk` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `jurusan`
--

INSERT INTO `jurusan` (`id`, `namaJur`, `idFk`) VALUES
(2, 'Teknik Informatika', 6),
(3, 'Pendidikan Agama Islam', 1),
(4, 'Pendidikan IPS', 1),
(5, 'Pendidikan Guru Madrasah Ibtidaiyah (PGMI)', 1),
(6, 'Pendidikan Bahasa Arab', 1),
(7, 'Pendidikan Islam Anak Usia Dini (PIAUD)', 1),
(8, 'Manajemen Pendidikan Islam', 1),
(9, 'Al-Ahwal Al-Syakhsiyah', 2),
(10, 'Hukum Bisnis Syari\'ah', 2),
(11, 'Hukum Tata Negara', 2);

-- --------------------------------------------------------

--
-- Table structure for table `kategori_skor`
--

CREATE TABLE `kategori_skor` (
  `id` int(11) NOT NULL,
  `nama` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `kategori_skor`
--

INSERT INTO `kategori_skor` (`id`, `nama`) VALUES
(1, 'PLN'),
(2, 'Penghasilan Ayah'),
(3, 'IPK');

-- --------------------------------------------------------

--
-- Table structure for table `levellog`
--

CREATE TABLE `levellog` (
  `id` int(11) NOT NULL,
  `level` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `levellog`
--

INSERT INTO `levellog` (`id`, `level`) VALUES
(1, 'Staff Kemahasiswaan'),
(2, 'Kasubag'),
(3, 'Kasubag Fakultas'),
(4, 'Kabag'),
(5, 'Mahasiswa'),
(6, 'Admin');

-- --------------------------------------------------------

--
-- Table structure for table `pendaftar`
--

CREATE TABLE `pendaftar` (
  `id` int(11) NOT NULL,
  `idBea` int(11) NOT NULL,
  `nim` int(11) NOT NULL,
  `semester` int(1) NOT NULL,
  `sks` int(2) NOT NULL,
  `ipk` float NOT NULL,
  `alamatMalang` text NOT NULL,
  `tanggal` date NOT NULL,
  `status` int(1) NOT NULL DEFAULT '0' COMMENT '1=diterima, 0=tidak_diterima',
  `waktuDiubah` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `pendaftar`
--

INSERT INTO `pendaftar` (`id`, `idBea`, `nim`, `semester`, `sks`, `ipk`, `alamatMalang`, `tanggal`, `status`, `waktuDiubah`) VALUES
(9, 12, 15650025, 2, 24, 3.5, '8', '2017-08-25', 1, '2017-09-05 15:41:59'),
(10, 1, 15650025, 2, 12, 3, 'Malang', '2017-08-25', 0, '2017-08-25 06:14:44');

-- --------------------------------------------------------

--
-- Table structure for table `pendaftar_skor`
--

CREATE TABLE `pendaftar_skor` (
  `id` int(40) NOT NULL,
  `idPendaftar` int(11) NOT NULL,
  `idBea` int(11) NOT NULL,
  `idKategori` int(11) NOT NULL,
  `idSubKategori` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `pendaftar_skor`
--

INSERT INTO `pendaftar_skor` (`id`, `idPendaftar`, `idBea`, `idKategori`, `idSubKategori`) VALUES
(15, 9, 12, 1, 2),
(16, 9, 12, 3, 11),
(17, 10, 1, 1, 1),
(18, 10, 1, 2, 8);

-- --------------------------------------------------------

--
-- Stand-in structure for view `penerima_bea`
-- (See below for the actual view)
--
CREATE TABLE `penerima_bea` (
`nimMhs` int(11)
,`namaLengkap` varchar(100)
,`idBea` int(11)
,`namaBeasiswa` varchar(100)
,`ipk` float
,`skor` decimal(32,0)
,`jumlah` double
,`status` int(1)
,`beasiswaDibuka` date
,`beasiswaTutup` date
,`periodeBerakhir` date
,`now` date
,`berakhirPendaftaran` int(7)
,`berakhirPeriode` int(7)
,`updated` timestamp
);

-- --------------------------------------------------------

--
-- Table structure for table `profil_admin`
--

CREATE TABLE `profil_admin` (
  `id` int(11) NOT NULL,
  `nama` varchar(50) DEFAULT NULL,
  `alamat` varchar(50) DEFAULT NULL,
  `noTelp` char(20) DEFAULT NULL,
  `email` varchar(30) DEFAULT NULL,
  `idAkses` int(11) DEFAULT NULL,
  `idFakultas` int(11) DEFAULT NULL,
  `foto` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `profil_admin`
--

INSERT INTO `profil_admin` (`id`, `nama`, `alamat`, `noTelp`, `email`, `idAkses`, `idFakultas`, `foto`) VALUES
(7, 'Ahmad', 'Malang', '085676547876', 'ahmad@gmail.com', 25, NULL, 'file_1503563606.png'),
(8, 'Fauzi', 'Malang', '085756787654', 'ahmad@gmail.com', 26, NULL, 'file_1503563711.jpg'),
(9, 'Denny', 'Malang', '085756787654', 'ahmad@gmail.com', 27, 6, NULL),
(10, 'Mahfudz', 'Malang', '085756787654', 'ahmad@gmail.com', 28, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `set_bea_kategori_skor`
--

CREATE TABLE `set_bea_kategori_skor` (
  `id` int(11) NOT NULL,
  `idBea` int(11) NOT NULL,
  `idKategoriSkor` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `set_bea_kategori_skor`
--

INSERT INTO `set_bea_kategori_skor` (`id`, `idBea`, `idKategoriSkor`) VALUES
(3, 1, 1),
(4, 1, 2),
(5, 12, 1),
(6, 12, 3);

-- --------------------------------------------------------

--
-- Table structure for table `set_sub_kategori_skor`
--

CREATE TABLE `set_sub_kategori_skor` (
  `id` int(11) NOT NULL,
  `idKategoriSkor` int(11) NOT NULL,
  `nama` varchar(150) NOT NULL,
  `skor` int(7) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
(10, 3, '1-4', 1),
(11, 3, '2-3', 2),
(12, 3, '3-4', 3);

-- --------------------------------------------------------

--
-- Stand-in structure for view `skor_mahasiswa`
-- (See below for the actual view)
--
CREATE TABLE `skor_mahasiswa` (
`nimMhs` int(11)
,`namaLengkap` varchar(100)
,`idPendaftar` int(11)
,`idBeasiswa` int(11)
,`namaBeasiswa` varchar(100)
,`ipk` float
,`skor` decimal(32,0)
,`jumlah` double
,`status` int(1)
,`updated` timestamp
);

-- --------------------------------------------------------

--
-- Structure for view `penerima_bea`
--
DROP TABLE IF EXISTS `penerima_bea`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `penerima_bea`  AS  select `pendaftar`.`nim` AS `nimMhs`,`identitas_mhs`.`namaLengkap` AS `namaLengkap`,`pendaftar`.`idBea` AS `idBea`,`bea`.`namaBeasiswa` AS `namaBeasiswa`,`pendaftar`.`ipk` AS `ipk`,(select sum(`set_sub_kategori_skor`.`skor`) from (((`pendaftar_skor` left join `pendaftar` on((`pendaftar`.`id` = `pendaftar_skor`.`idPendaftar`))) left join `kategori_skor` on((`pendaftar_skor`.`idKategori` = `kategori_skor`.`id`))) left join `set_sub_kategori_skor` on((`pendaftar_skor`.`idSubKategori` = `set_sub_kategori_skor`.`id`))) where (`pendaftar`.`nim` = `identitas_mhs`.`nimMhs`)) AS `skor`,(select (sum(`set_sub_kategori_skor`.`skor`) + `pendaftar`.`ipk`) from (((`pendaftar_skor` left join `pendaftar` on((`pendaftar`.`id` = `pendaftar_skor`.`idPendaftar`))) left join `kategori_skor` on((`pendaftar_skor`.`idKategori` = `kategori_skor`.`id`))) left join `set_sub_kategori_skor` on((`pendaftar_skor`.`idSubKategori` = `set_sub_kategori_skor`.`id`))) where (`pendaftar`.`nim` = `identitas_mhs`.`nimMhs`)) AS `jumlah`,`pendaftar`.`status` AS `status`,`bea`.`beasiswaDibuka` AS `beasiswaDibuka`,`bea`.`beasiswaTutup` AS `beasiswaTutup`,`bea`.`periodeBerakhir` AS `periodeBerakhir`,curdate() AS `now`,(to_days(curdate()) - to_days(`bea`.`beasiswaTutup`)) AS `berakhirPendaftaran`,(to_days(curdate()) - to_days(`bea`.`periodeBerakhir`)) AS `berakhirPeriode`,`pendaftar`.`waktuDiubah` AS `updated` from ((`pendaftar` left join `bea` on((`pendaftar`.`idBea` = `bea`.`id`))) left join `identitas_mhs` on((`pendaftar`.`nim` = `identitas_mhs`.`nimMhs`))) where ((`pendaftar`.`status` = '1') and (year(`bea`.`beasiswaTutup`) between (year(curdate()) - 1) and (year(curdate()) + 1)) and (year(`bea`.`periodeBerakhir`) between (year(curdate()) - 1) and (year(curdate()) + 1))) order by (select (sum(`set_sub_kategori_skor`.`skor`) + `pendaftar`.`ipk`) from (((`pendaftar_skor` left join `pendaftar` on((`pendaftar`.`id` = `pendaftar_skor`.`idPendaftar`))) left join `kategori_skor` on((`pendaftar_skor`.`idKategori` = `kategori_skor`.`id`))) left join `set_sub_kategori_skor` on((`pendaftar_skor`.`idSubKategori` = `set_sub_kategori_skor`.`id`))) where (`pendaftar`.`nim` = `identitas_mhs`.`nimMhs`)) desc ;

-- --------------------------------------------------------

--
-- Structure for view `skor_mahasiswa`
--
DROP TABLE IF EXISTS `skor_mahasiswa`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `skor_mahasiswa`  AS  select `pendaftar`.`nim` AS `nimMhs`,`identitas_mhs`.`namaLengkap` AS `namaLengkap`,`pendaftar`.`id` AS `idPendaftar`,`pendaftar`.`idBea` AS `idBeasiswa`,`bea`.`namaBeasiswa` AS `namaBeasiswa`,`pendaftar`.`ipk` AS `ipk`,(select sum(`set_sub_kategori_skor`.`skor`) from (((`pendaftar_skor` left join `pendaftar` on((`pendaftar`.`id` = `pendaftar_skor`.`idPendaftar`))) left join `kategori_skor` on((`pendaftar_skor`.`idKategori` = `kategori_skor`.`id`))) left join `set_sub_kategori_skor` on((`pendaftar_skor`.`idSubKategori` = `set_sub_kategori_skor`.`id`))) where ((`pendaftar`.`nim` = `identitas_mhs`.`nimMhs`) and (`pendaftar`.`idBea` = `idBeasiswa`))) AS `skor`,(select (sum(`set_sub_kategori_skor`.`skor`) + `pendaftar`.`ipk`) from (((`pendaftar_skor` left join `pendaftar` on((`pendaftar`.`id` = `pendaftar_skor`.`idPendaftar`))) left join `kategori_skor` on((`pendaftar_skor`.`idKategori` = `kategori_skor`.`id`))) left join `set_sub_kategori_skor` on((`pendaftar_skor`.`idSubKategori` = `set_sub_kategori_skor`.`id`))) where ((`pendaftar`.`nim` = `identitas_mhs`.`nimMhs`) and (`pendaftar`.`idBea` = `idBeasiswa`))) AS `jumlah`,`pendaftar`.`status` AS `status`,`pendaftar`.`waktuDiubah` AS `updated` from ((`pendaftar` left join `bea` on((`pendaftar`.`idBea` = `bea`.`id`))) left join `identitas_mhs` on((`pendaftar`.`nim` = `identitas_mhs`.`nimMhs`))) order by (select (sum(`set_sub_kategori_skor`.`skor`) + `pendaftar`.`ipk`) from (((`pendaftar_skor` left join `pendaftar` on((`pendaftar`.`id` = `pendaftar_skor`.`idPendaftar`))) left join `kategori_skor` on((`pendaftar_skor`.`idKategori` = `kategori_skor`.`id`))) left join `set_sub_kategori_skor` on((`pendaftar_skor`.`idSubKategori` = `set_sub_kategori_skor`.`id`))) where ((`pendaftar`.`nim` = `identitas_mhs`.`nimMhs`) and (`pendaftar`.`idBea` = `idBeasiswa`))) desc ;

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
-- Indexes for table `berita`
--
ALTER TABLE `berita`
  ADD PRIMARY KEY (`idBerita`);

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
  ADD UNIQUE KEY `nimMhs` (`nimMhs`),
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
-- Indexes for table `levellog`
--
ALTER TABLE `levellog`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pendaftar`
--
ALTER TABLE `pendaftar`
  ADD PRIMARY KEY (`id`),
  ADD KEY `nim` (`nim`),
  ADD KEY `idBea` (`idBea`);

--
-- Indexes for table `pendaftar_skor`
--
ALTER TABLE `pendaftar_skor`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idPendaftar` (`idPendaftar`),
  ADD KEY `idBea` (`idBea`),
  ADD KEY `idKategori` (`idKategori`),
  ADD KEY `idSubKategori` (`idSubKategori`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;
--
-- AUTO_INCREMENT for table `bea`
--
ALTER TABLE `bea`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT for table `berita`
--
ALTER TABLE `berita`
  MODIFY `idBerita` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `fakultas`
--
ALTER TABLE `fakultas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `jurusan`
--
ALTER TABLE `jurusan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `kategori_skor`
--
ALTER TABLE `kategori_skor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `levellog`
--
ALTER TABLE `levellog`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `pendaftar`
--
ALTER TABLE `pendaftar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `pendaftar_skor`
--
ALTER TABLE `pendaftar_skor`
  MODIFY `id` int(40) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
--
-- AUTO_INCREMENT for table `profil_admin`
--
ALTER TABLE `profil_admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `set_bea_kategori_skor`
--
ALTER TABLE `set_bea_kategori_skor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `set_sub_kategori_skor`
--
ALTER TABLE `set_sub_kategori_skor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `akses`
--
ALTER TABLE `akses`
  ADD CONSTRAINT `akses_ibfk_1` FOREIGN KEY (`idLevel`) REFERENCES `levellog` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

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
-- Constraints for table `pendaftar`
--
ALTER TABLE `pendaftar`
  ADD CONSTRAINT `pendaftar_ibfk_1` FOREIGN KEY (`nim`) REFERENCES `identitas_mhs` (`nimMhs`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `pendaftar_ibfk_2` FOREIGN KEY (`idBea`) REFERENCES `bea` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `pendaftar_skor`
--
ALTER TABLE `pendaftar_skor`
  ADD CONSTRAINT `pendaftar_skor_ibfk_1` FOREIGN KEY (`idPendaftar`) REFERENCES `pendaftar` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `pendaftar_skor_ibfk_2` FOREIGN KEY (`idBea`) REFERENCES `bea` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `pendaftar_skor_ibfk_3` FOREIGN KEY (`idKategori`) REFERENCES `kategori_skor` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `pendaftar_skor_ibfk_4` FOREIGN KEY (`idSubKategori`) REFERENCES `set_sub_kategori_skor` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

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
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
