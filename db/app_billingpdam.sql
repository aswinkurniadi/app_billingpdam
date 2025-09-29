-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 28, 2025 at 05:50 PM
-- Server version: 10.1.38-MariaDB
-- PHP Version: 7.3.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `app_billingpdam`
--

-- --------------------------------------------------------

--
-- Table structure for table `cabang`
--

CREATE TABLE `cabang` (
  `id_cabang` int(11) NOT NULL,
  `nama` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `cabang`
--

INSERT INTO `cabang` (`id_cabang`, `nama`) VALUES
(2, 'Ka. Pusat');

-- --------------------------------------------------------

--
-- Table structure for table `denda`
--

CREATE TABLE `denda` (
  `id_denda` int(11) NOT NULL,
  `plng_id` int(11) NOT NULL,
  `tgl` date NOT NULL,
  `nilai` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `kas`
--

CREATE TABLE `kas` (
  `id_kas` int(11) NOT NULL,
  `nm_kas` varchar(288) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `kas`
--

INSERT INTO `kas` (`id_kas`, `nm_kas`) VALUES
(1, 'Tunai');

-- --------------------------------------------------------

--
-- Table structure for table `log`
--

CREATE TABLE `log` (
  `id_log` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `ket` text NOT NULL,
  `waktu` text NOT NULL,
  `url` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `log`
--

INSERT INTO `log` (`id_log`, `id_user`, `ket`, `waktu`, `url`) VALUES
(3, 7, 'menambahkan pelanggan baru', '1724558454', 'tagihan/add');

-- --------------------------------------------------------

--
-- Table structure for table `menu`
--

CREATE TABLE `menu` (
  `id_menu` int(11) NOT NULL,
  `nama` varchar(288) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `menu`
--

INSERT INTO `menu` (`id_menu`, `nama`) VALUES
(2, 'Profile Company'),
(3, 'User'),
(4, 'Menu'),
(5, 'Admin'),
(6, 'tes');

-- --------------------------------------------------------

--
-- Table structure for table `piutang_in`
--

CREATE TABLE `piutang_in` (
  `id_piut` int(11) NOT NULL,
  `tgl` datetime NOT NULL,
  `plng_id` int(11) NOT NULL,
  `bln` int(11) NOT NULL,
  `nilai` bigint(20) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `ket` text NOT NULL,
  `id_piut_out` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `piutang_in`
--

INSERT INTO `piutang_in` (`id_piut`, `tgl`, `plng_id`, `bln`, `nilai`, `user_id`, `ket`, `id_piut_out`) VALUES
(1, '2024-08-15 09:39:32', 1, 1, 35000, 7, '', NULL),
(3, '2024-08-27 00:00:00', 6, 8, 1200000, 7, 'tesss', 1);

-- --------------------------------------------------------

--
-- Table structure for table `piutang_out`
--

CREATE TABLE `piutang_out` (
  `id_piut` int(11) NOT NULL,
  `tgl` datetime NOT NULL,
  `plng_id` int(11) NOT NULL,
  `bln` int(3) NOT NULL,
  `nilai` bigint(20) NOT NULL,
  `user_id` int(11) NOT NULL,
  `id_kas` int(11) NOT NULL,
  `dibayar` varchar(288) NOT NULL,
  `diterima` varchar(288) NOT NULL,
  `ket` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `piutang_out`
--

INSERT INTO `piutang_out` (`id_piut`, `tgl`, `plng_id`, `bln`, `nilai`, `user_id`, `id_kas`, `dibayar`, `diterima`, `ket`) VALUES
(1, '2024-08-27 18:59:36', 6, 8, 1000000, 7, 1, 'tes', 'tes', 'tes');

-- --------------------------------------------------------

--
-- Table structure for table `plng`
--

CREATE TABLE `plng` (
  `id_plng` int(11) NOT NULL,
  `no_plng` int(11) NOT NULL,
  `tgl` date NOT NULL,
  `nm` varchar(288) NOT NULL,
  `almt` text NOT NULL,
  `no_telp` varchar(20) NOT NULL,
  `nomor_air` varchar(288) NOT NULL,
  `stts` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `plng`
--

INSERT INTO `plng` (`id_plng`, `no_plng`, `tgl`, `nm`, `almt`, `no_telp`, `nomor_air`, `stts`) VALUES
(1, 1, '2024-08-15', 'aswin', 'magetan', '0895396051690', '998536521', 1),
(6, 2, '2024-08-25', 'andi', 'tes', '123', '213', 1);

-- --------------------------------------------------------

--
-- Table structure for table `plng_berhenti`
--

CREATE TABLE `plng_berhenti` (
  `id_pb` int(11) NOT NULL,
  `id_plng` int(11) NOT NULL,
  `tgl` datetime NOT NULL,
  `ket` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `plng_catatmeter`
--

CREATE TABLE `plng_catatmeter` (
  `id_cm` int(11) NOT NULL,
  `plng_id` int(11) NOT NULL,
  `tgl` date NOT NULL,
  `nilai` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `profile`
--

CREATE TABLE `profile` (
  `id_profile` int(11) NOT NULL,
  `name` varchar(128) NOT NULL,
  `almt` text NOT NULL,
  `no_telp` varchar(20) NOT NULL,
  `email` varchar(288) NOT NULL,
  `logo` varchar(288) NOT NULL,
  `deskripsi` text NOT NULL,
  `time_zone` varchar(288) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `profile`
--

INSERT INTO `profile` (`id_profile`, `name`, `almt`, `no_telp`, `email`, `logo`, `deskripsi`, `time_zone`) VALUES
(1, 'TIRTA SALAM', '-', '-', 'admin@gmail.com', 'pdam.jpg', '-', 'Asia/Jakarta');

-- --------------------------------------------------------

--
-- Table structure for table `setoran`
--

CREATE TABLE `setoran` (
  `id_setoran` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `tgl` date NOT NULL,
  `nilai` bigint(20) NOT NULL,
  `ket` text NOT NULL,
  `file` text NOT NULL,
  `stts` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `setoran`
--

INSERT INTO `setoran` (`id_setoran`, `id_user`, `tgl`, `nilai`, `ket`, `file`, `stts`) VALUES
(5, 7, '2024-08-25', 10000, 'tes', '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `subsidi`
--

CREATE TABLE `subsidi` (
  `id_subsidi` int(11) NOT NULL,
  `plng_id` int(11) NOT NULL,
  `tgl` date NOT NULL,
  `nilai` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `sub_menu`
--

CREATE TABLE `sub_menu` (
  `id_sub_menu` int(11) NOT NULL,
  `id_menu` int(11) NOT NULL,
  `nama` varchar(288) NOT NULL,
  `url` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sub_menu`
--

INSERT INTO `sub_menu` (`id_sub_menu`, `id_menu`, `nama`, `url`) VALUES
(1, 2, 'display profile', 'profilecompany/index'),
(2, 2, 'edit profile', 'profilecompany/edit_profile_perusahaan'),
(3, 3, 'index', 'user/'),
(4, 3, 'edit user', 'user/edit'),
(5, 3, 'ubah password', 'user/changePassword'),
(6, 4, 'menu', 'menu/index'),
(7, 4, 'tambah menu', 'menu/add'),
(8, 4, 'ubah menu', 'menu/update'),
(9, 4, 'hapus menu', 'menu/delete'),
(10, 4, 'sub menu', 'menu/sub_menu'),
(11, 4, 'tambah sub menu', 'menu/add_sub_menu'),
(12, 4, 'ubah sub menu', 'menu/sub_menu_update'),
(13, 4, 'hapus sub menu', 'menu/delete_sub_menu'),
(14, 5, 'manajemen user', 'admin/index'),
(15, 5, 'ubah user', 'admin/edit_user_management'),
(16, 5, 'hapus user', 'admin/delete_user_management'),
(17, 5, 'detail access', 'admin/detail_access');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id_user` int(11) NOT NULL,
  `username` varchar(288) NOT NULL,
  `name` varchar(128) NOT NULL,
  `email` varchar(128) NOT NULL,
  `image` varchar(128) NOT NULL,
  `password` varchar(256) NOT NULL,
  `id_role` int(11) NOT NULL,
  `is_active` int(2) NOT NULL,
  `date_created` int(11) NOT NULL,
  `id_cab` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id_user`, `username`, `name`, `email`, `image`, `password`, `id_role`, `is_active`, `date_created`, `id_cab`) VALUES
(7, 'administrator', 'aswin kurniadi', 'direktur@gmail.com', 'default2.jpg', '$2y$10$f/Nf4WIaWNmXEPLAniBwNeNSl7IAO1zWCNkAl9xNrcj07bZghisxa', 1, 1, 1723623356, 2),
(14, 'user', 'budi ', 'admin@gmail.com', 'default.jpg', '$2y$10$eqZeNpKhpOvWPRIzQi7TZOT5SdsbMvQfVN2PHELmeuW8BGkHpPd6G', 2, 1, 1723623360, 3);

-- --------------------------------------------------------

--
-- Table structure for table `user_access`
--

CREATE TABLE `user_access` (
  `id_user_access` int(11) NOT NULL,
  `id_role` int(11) NOT NULL,
  `id_sub_menu` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_access`
--

INSERT INTO `user_access` (`id_user_access`, `id_role`, `id_sub_menu`) VALUES
(10, 1, 1),
(11, 1, 2),
(12, 1, 3),
(13, 1, 4),
(14, 1, 5),
(15, 1, 6),
(16, 1, 7),
(17, 1, 8),
(18, 1, 9),
(19, 1, 10),
(20, 1, 11),
(21, 1, 12),
(22, 1, 13),
(23, 1, 14),
(24, 1, 15),
(25, 1, 16),
(26, 1, 17),
(27, 2, 1),
(28, 2, 3),
(29, 2, 4),
(30, 2, 5);

-- --------------------------------------------------------

--
-- Table structure for table `user_role`
--

CREATE TABLE `user_role` (
  `id_role` int(11) NOT NULL,
  `role` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_role`
--

INSERT INTO `user_role` (`id_role`, `role`) VALUES
(1, 'Direktur'),
(2, 'Admin');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cabang`
--
ALTER TABLE `cabang`
  ADD PRIMARY KEY (`id_cabang`);

--
-- Indexes for table `denda`
--
ALTER TABLE `denda`
  ADD PRIMARY KEY (`id_denda`),
  ADD KEY `plng_id` (`plng_id`);

--
-- Indexes for table `kas`
--
ALTER TABLE `kas`
  ADD PRIMARY KEY (`id_kas`);

--
-- Indexes for table `log`
--
ALTER TABLE `log`
  ADD PRIMARY KEY (`id_log`);

--
-- Indexes for table `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`id_menu`);

--
-- Indexes for table `piutang_in`
--
ALTER TABLE `piutang_in`
  ADD PRIMARY KEY (`id_piut`),
  ADD KEY `id_piut_out` (`id_piut_out`),
  ADD KEY `plng_id` (`plng_id`);

--
-- Indexes for table `piutang_out`
--
ALTER TABLE `piutang_out`
  ADD PRIMARY KEY (`id_piut`),
  ADD KEY `plng_id` (`plng_id`);

--
-- Indexes for table `plng`
--
ALTER TABLE `plng`
  ADD PRIMARY KEY (`id_plng`);

--
-- Indexes for table `plng_berhenti`
--
ALTER TABLE `plng_berhenti`
  ADD PRIMARY KEY (`id_pb`),
  ADD KEY `id_plng` (`id_plng`);

--
-- Indexes for table `plng_catatmeter`
--
ALTER TABLE `plng_catatmeter`
  ADD PRIMARY KEY (`id_cm`),
  ADD KEY `plng_id` (`plng_id`);

--
-- Indexes for table `profile`
--
ALTER TABLE `profile`
  ADD PRIMARY KEY (`id_profile`);

--
-- Indexes for table `setoran`
--
ALTER TABLE `setoran`
  ADD PRIMARY KEY (`id_setoran`);

--
-- Indexes for table `subsidi`
--
ALTER TABLE `subsidi`
  ADD PRIMARY KEY (`id_subsidi`),
  ADD KEY `plng_id` (`plng_id`);

--
-- Indexes for table `sub_menu`
--
ALTER TABLE `sub_menu`
  ADD PRIMARY KEY (`id_sub_menu`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`),
  ADD KEY `id_role` (`id_role`);

--
-- Indexes for table `user_access`
--
ALTER TABLE `user_access`
  ADD PRIMARY KEY (`id_user_access`);

--
-- Indexes for table `user_role`
--
ALTER TABLE `user_role`
  ADD PRIMARY KEY (`id_role`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cabang`
--
ALTER TABLE `cabang`
  MODIFY `id_cabang` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `denda`
--
ALTER TABLE `denda`
  MODIFY `id_denda` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kas`
--
ALTER TABLE `kas`
  MODIFY `id_kas` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `log`
--
ALTER TABLE `log`
  MODIFY `id_log` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `menu`
--
ALTER TABLE `menu`
  MODIFY `id_menu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `piutang_in`
--
ALTER TABLE `piutang_in`
  MODIFY `id_piut` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `piutang_out`
--
ALTER TABLE `piutang_out`
  MODIFY `id_piut` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `plng`
--
ALTER TABLE `plng`
  MODIFY `id_plng` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `plng_berhenti`
--
ALTER TABLE `plng_berhenti`
  MODIFY `id_pb` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `plng_catatmeter`
--
ALTER TABLE `plng_catatmeter`
  MODIFY `id_cm` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `profile`
--
ALTER TABLE `profile`
  MODIFY `id_profile` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `setoran`
--
ALTER TABLE `setoran`
  MODIFY `id_setoran` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `subsidi`
--
ALTER TABLE `subsidi`
  MODIFY `id_subsidi` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sub_menu`
--
ALTER TABLE `sub_menu`
  MODIFY `id_sub_menu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `user_access`
--
ALTER TABLE `user_access`
  MODIFY `id_user_access` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `user_role`
--
ALTER TABLE `user_role`
  MODIFY `id_role` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `user_ibfk_1` FOREIGN KEY (`id_role`) REFERENCES `user_role` (`id_role`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
