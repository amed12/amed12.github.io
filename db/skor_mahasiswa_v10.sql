-- phpMyAdmin SQL Dump
-- version 4.7.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Sep 21, 2017 at 08:01 PM
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
-- Structure for view `skor_mahasiswa`
--

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `skor_mahasiswa`  AS  select `pendaftar`.`nim` AS `nimMhs`,`identitas_mhs`.`namaLengkap` AS `namaLengkap`,`pendaftar`.`id` AS `idPendaftar`,`pendaftar`.`idBea` AS `idBeasiswa`,`bea`.`namaBeasiswa` AS `namaBeasiswa`,`pendaftar`.`ipk` AS `ipk`,(select sum(`set_sub_kategori_skor`.`skor`) from (((`pendaftar_skor` left join `pendaftar` on((`pendaftar`.`id` = `pendaftar_skor`.`idPendaftar`))) left join `kategori_skor` on((`pendaftar_skor`.`idKategori` = `kategori_skor`.`id`))) left join `set_sub_kategori_skor` on((`pendaftar_skor`.`idSubKategori` = `set_sub_kategori_skor`.`id`))) where ((`pendaftar`.`nim` = `identitas_mhs`.`nimMhs`) and (`pendaftar`.`idBea` = `idBeasiswa`))) AS `skor`,(select (sum(`set_sub_kategori_skor`.`skor`) + `pendaftar`.`ipk`) from (((`pendaftar_skor` left join `pendaftar` on((`pendaftar`.`id` = `pendaftar_skor`.`idPendaftar`))) left join `kategori_skor` on((`pendaftar_skor`.`idKategori` = `kategori_skor`.`id`))) left join `set_sub_kategori_skor` on((`pendaftar_skor`.`idSubKategori` = `set_sub_kategori_skor`.`id`))) where ((`pendaftar`.`nim` = `identitas_mhs`.`nimMhs`) and (`pendaftar`.`idBea` = `idBeasiswa`))) AS `jumlah`,`pendaftar`.`status` AS `status`,`pendaftar`.`waktuDiubah` AS `updated` from ((`pendaftar` left join `bea` on((`pendaftar`.`idBea` = `bea`.`id`))) left join `identitas_mhs` on((`pendaftar`.`nim` = `identitas_mhs`.`nimMhs`))) order by (select (sum(`set_sub_kategori_skor`.`skor`) + `pendaftar`.`ipk`) from (((`pendaftar_skor` left join `pendaftar` on((`pendaftar`.`id` = `pendaftar_skor`.`idPendaftar`))) left join `kategori_skor` on((`pendaftar_skor`.`idKategori` = `kategori_skor`.`id`))) left join `set_sub_kategori_skor` on((`pendaftar_skor`.`idSubKategori` = `set_sub_kategori_skor`.`id`))) where ((`pendaftar`.`nim` = `identitas_mhs`.`nimMhs`) and (`pendaftar`.`idBea` = `idBeasiswa`))) desc ;

--
-- VIEW  `skor_mahasiswa`
-- Data: None
--

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
