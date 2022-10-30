-- phpMyAdmin SQL Dump
-- version 4.9.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jul 07, 2020 at 07:49 AM
-- Server version: 5.7.26
-- PHP Version: 7.4.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `ci-tutor`
--

-- --------------------------------------------------------

--
-- Table structure for table `akses`
--

CREATE TABLE `akses` (
  `kode_menu` char(15) NOT NULL,
  `level_user` char(30) NOT NULL,
  `akses` enum('0','1') NOT NULL,
  `tambah` enum('0','1') NOT NULL,
  `edit` enum('0','1') NOT NULL,
  `hapus` enum('0','1') NOT NULL,
  `id` int(11) NOT NULL,
  `tanggal` datetime NOT NULL DEFAULT '2020-01-01 00:00:00',
  `user` char(10) NOT NULL DEFAULT 'admin'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `akses`
--

INSERT INTO `akses` (`kode_menu`, `level_user`, `akses`, `tambah`, `edit`, `hapus`, `id`, `tanggal`, `user`) VALUES
('mn001', 'admin', '1', '0', '0', '0', 1, '2020-01-01 00:00:00', 'admin'),
('mn001-s001', 'admin', '1', '1', '1', '1', 2, '2020-01-01 00:00:00', 'admin'),
('mn002', 'admin', '1', '0', '0', '0', 3, '2020-01-01 00:00:00', 'admin'),
('mn002-s001', 'admin', '1', '1', '1', '1', 4, '2020-01-01 00:00:00', 'admin'),
('mn001-s002', 'admin', '1', '1', '1', '1', 5, '2020-01-01 00:00:00', 'admin'),
('mn001-s001', 'karyawan', '1', '1', '1', '0', 7, '2020-01-01 00:00:00', 'admin'),
('mn001-s002', 'karyawan', '1', '1', '1', '0', 8, '2020-01-01 00:00:00', 'admin'),
('mn003', 'admin', '1', '0', '0', '0', 9, '2020-01-01 00:00:00', 'admin'),
('mn003-s001', 'admin', '1', '1', '1', '1', 10, '2020-01-01 00:00:00', 'admin'),
('mn001', 'karyawan', '1', '0', '0', '0', 11, '2020-01-01 00:00:00', 'admin'),
('mn002', 'karyawan', '1', '0', '0', '0', 12, '2020-01-01 00:00:00', 'admin'),
('mn002-s001', 'karyawan', '1', '1', '1', '0', 13, '2020-01-01 00:00:00', 'admin'),
('mn003', 'karyawan', '1', '0', '0', '0', 14, '2020-01-01 00:00:00', 'admin'),
('mn003-s001', 'karyawan', '1', '1', '1', '1', 15, '2020-01-01 00:00:00', 'admin'),
('mn001', 'hrd', '0', '0', '0', '0', 61, '2020-04-18 11:04:27', 'admin'),
('mn001-s001', 'hrd', '0', '0', '0', '0', 62, '2020-04-18 11:04:27', 'admin'),
('mn001-s002', 'hrd', '0', '0', '0', '0', 63, '2020-04-18 11:04:27', 'admin'),
('mn002', 'hrd', '0', '0', '0', '0', 64, '2020-04-18 11:04:27', 'admin'),
('mn002-s001', 'hrd', '0', '0', '0', '0', 65, '2020-04-18 11:04:27', 'admin'),
('mn003', 'hrd', '0', '0', '0', '0', 66, '2020-04-18 11:04:27', 'admin'),
('mn003-s001', 'hrd', '0', '0', '0', '0', 67, '2020-04-18 11:04:27', 'admin'),
('mn001', '', '0', '0', '0', '0', 68, '2020-04-18 11:12:30', 'admin'),
('mn001-s001', '', '0', '0', '0', '0', 69, '2020-04-18 11:12:30', 'admin'),
('mn001-s002', '', '0', '0', '0', '0', 70, '2020-04-18 11:12:30', 'admin'),
('mn002', '', '0', '0', '0', '0', 71, '2020-04-18 11:12:30', 'admin'),
('mn002-s001', '', '0', '0', '0', '0', 72, '2020-04-18 11:12:30', 'admin'),
('mn003', '', '0', '0', '0', '0', 73, '2020-04-18 11:12:30', 'admin'),
('mn003-s001', '', '0', '0', '0', '0', 74, '2020-04-18 11:12:30', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `data_cuti`
--

CREATE TABLE `data_cuti` (
  `nik` char(10) NOT NULL,
  `tahun` char(4) NOT NULL,
  `sisa_cuti` int(11) NOT NULL,
  `tgl_terakhir_cuti` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `data_cuti`
--

INSERT INTO `data_cuti` (`nik`, `tahun`, `sisa_cuti`, `tgl_terakhir_cuti`) VALUES
('spv-it1', '2020', 11, '2020-03-01 21:57:18'),
('staf-it1', '2020', 5, '2020-03-01 21:57:18');

-- --------------------------------------------------------

--
-- Table structure for table `data_karyawan`
--

CREATE TABLE `data_karyawan` (
  `nik` char(10) NOT NULL,
  `nama_lengkap` char(40) NOT NULL,
  `email` char(60) NOT NULL,
  `foto` char(100) NOT NULL,
  `tgl_lahir` date NOT NULL,
  `tgl_masuk` date NOT NULL,
  `tgl_keluar` date NOT NULL DEFAULT '1900-01-01',
  `divisi` enum('IT','HRD','FINANCE','ACCOUNTING','BOD') NOT NULL,
  `jabatan` char(30) NOT NULL,
  `atasan1` char(10) NOT NULL,
  `atasan2` char(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `data_karyawan`
--

INSERT INTO `data_karyawan` (`nik`, `nama_lengkap`, `email`, `foto`, `tgl_lahir`, `tgl_masuk`, `tgl_keluar`, `divisi`, `jabatan`, `atasan1`, `atasan2`) VALUES
('adasdasd', 'asd', 'a@a', '', '0000-00-00', '0000-00-00', '1900-01-01', '', '', '', ''),
('admin', 'Administrator', 'admin@admin.com', 'user8-128x128.jpg', '2020-03-01', '2020-03-01', '1900-01-01', 'IT', '', '', ''),
('mngr-acc', 'Manager accounting', 'a@a.com', '', '2020-03-04', '2020-03-11', '1900-01-01', 'IT', 'STAFF', 'mngr-it', 'mngr-it'),
('mngr-it', 'Manager IT', 'it@it', 'user8-128x128.jpg', '2020-03-12', '2020-03-19', '1900-01-01', 'IT', 'MANAGER', 'admin', 'admin'),
('spv-it1', 'Spv IT 1', 'it@it', 'user1-128x128.jpg', '2020-03-18', '2020-03-10', '1900-01-01', 'IT', 'SPV', 'mngr-it', 'mngr-it'),
('staf-it1', 'Staf IT 1', 'it@it', 'user8-128x128.jpg', '2020-03-11', '2020-03-11', '1900-01-01', 'IT', 'STAFF', 'mngr-it', 'mngr-it'),
('staff-acc1', 'Staff Accounting satu1', 'acc@acc', 'user8-128x128.jpg', '2020-02-28', '2020-03-05', '1900-01-01', 'ACCOUNTING', 'STAFF', 'staff-acc1', 'staff-acc1'),
('zzzzzzz', 'asdasdasdasd', 'a@a', '', '0000-00-00', '0000-00-00', '1900-01-01', '', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `divisi`
--

CREATE TABLE `divisi` (
  `id` int(11) NOT NULL,
  `nama` char(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `divisi`
--

INSERT INTO `divisi` (`id`, `nama`) VALUES
(1, 'IT'),
(2, 'FINANCE'),
(3, 'ACCOUNTING'),
(4, 'HRD'),
(5, 'BOD');

-- --------------------------------------------------------

--
-- Table structure for table `jabatan_divisi`
--

CREATE TABLE `jabatan_divisi` (
  `id` int(11) NOT NULL,
  `nama` char(30) NOT NULL,
  `divisi` char(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `jabatan_divisi`
--

INSERT INTO `jabatan_divisi` (`id`, `nama`, `divisi`) VALUES
(1, 'MANAGER', 'IT'),
(2, 'STAFF', 'IT'),
(3, 'SPV', 'IT');

-- --------------------------------------------------------

--
-- Table structure for table `konfigurasi`
--

CREATE TABLE `konfigurasi` (
  `nama_sistem` char(100) NOT NULL,
  `logo_sistem` char(100) NOT NULL,
  `hari_libur` char(100) NOT NULL,
  `param_approve_cuti` enum('1','2') NOT NULL DEFAULT '1',
  `hari_min_cuti` int(11) NOT NULL,
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `konfigurasi`
--

INSERT INTO `konfigurasi` (`nama_sistem`, `logo_sistem`, `hari_libur`, `param_approve_cuti`, `hari_min_cuti`, `id`) VALUES
('Pengelolaan Karyawan Online', '', 'Sat,Sun', '1', 7, 1);

-- --------------------------------------------------------

--
-- Table structure for table `level_user`
--

CREATE TABLE `level_user` (
  `kode_level` char(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `level_user`
--

INSERT INTO `level_user` (`kode_level`) VALUES
('admin'),
('hrd'),
('karyawan');

-- --------------------------------------------------------

--
-- Table structure for table `menu`
--

CREATE TABLE `menu` (
  `kode_menu` char(15) NOT NULL,
  `nama_menu` char(50) NOT NULL,
  `url` char(100) NOT NULL,
  `icon` char(50) NOT NULL,
  `level` enum('main_menu','sub_menu') NOT NULL DEFAULT 'main_menu',
  `main_menu` char(15) NOT NULL,
  `aktif` enum('0','1') NOT NULL DEFAULT '1',
  `no_urut` int(11) NOT NULL,
  `tanggal` datetime NOT NULL,
  `user` char(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `menu`
--

INSERT INTO `menu` (`kode_menu`, `nama_menu`, `url`, `icon`, `level`, `main_menu`, `aktif`, `no_urut`, `tanggal`, `user`) VALUES
('mn001', 'Konfigurasi', 'konfigurasi', 'fa-edit', 'main_menu', '', '1', 1, '2020-02-10 21:35:53', 'Abdul'),
('mn001-s001', 'Akses', 'konfigurasi/akses', 'fa-circle', 'sub_menu', 'mn001', '1', 2, '2020-02-10 21:35:53', 'Abdul'),
('mn001-s002', 'Menu Sistem', 'konfigurasi/menu-sistem', 'fa-circle', 'sub_menu', 'mn001', '1', 4, '2020-02-10 21:21:37', 'Abdul'),
('mn002', 'Master Data', 'master-data', 'fa-tachometer-alt', 'main_menu', '', '1', 3, '2020-02-10 21:21:37', 'Abdul'),
('mn002-s001', 'Data Karyawan', 'master-data/data-karyawan', '', 'sub_menu', 'mn002', '1', 5, '2020-02-18 16:05:19', 'Abdul'),
('mn003', 'Pengajuan Karyawan', 'pengajuan', 'fa-edit', 'main_menu', '', '1', 6, '2020-03-02 13:04:34', 'Abdul'),
('mn003-s001', 'Pengajuan Cuti', 'pengajuan/pengajuan-cuti', 'fa-circle', 'sub_menu', 'mn003', '1', 7, '2020-03-02 13:04:34', 'Abdul');

-- --------------------------------------------------------

--
-- Table structure for table `notif`
--

CREATE TABLE `notif` (
  `id` char(50) NOT NULL,
  `no_referensi` char(10) NOT NULL,
  `nik_target` char(15) NOT NULL,
  `nik_client` char(10) NOT NULL,
  `read` enum('Y','N') NOT NULL DEFAULT 'N',
  `tanggal` datetime NOT NULL,
  `keterangan` text NOT NULL,
  `jenis` char(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `notif`
--

INSERT INTO `notif` (`id`, `no_referensi`, `nik_target`, `nik_client`, `read`, `tanggal`, `keterangan`, `jenis`) VALUES
('0ef5352014229e3699e360c99ac77233', 'PC20030015', 'mngr-it', 'staf-it1', 'Y', '2020-03-07 17:17:08', 'Menunggu persetujuan atasan', 'Pengajuan Cuti'),
('16212120361583254126', 'PC20030001', 'mngr-it', 'spv-it1', 'Y', '2020-03-03 23:48:46', 'Menunggu persetujuan atasan', 'Pengajuan Cuti'),
('3071c1106fdb0b65dfb7108c1cfd8d53', 'PC20030004', 'mngr-it', 'spv-it1', 'Y', '2020-03-04 15:45:48', 'Menunggu persetujuan atasan', 'Pengajuan Cuti'),
('320886401bdcb7aac847dc36c6530c99', 'PC20030005', 'staf-it1', 'staf-it1', 'Y', '2020-03-04 23:28:23', 'Pengajuan cuti : PC20030005 sudah diproses', 'Pengajuan Cuti'),
('3e26666e491eecf9098b5746fb720f22', 'PC20030017', 'mngr-it', 'staf-it1', 'Y', '2020-03-07 17:20:11', 'Menunggu persetujuan atasan', 'Pengajuan Cuti'),
('3fec156933c9c0efad08e87eb29cf1e8', 'PC20030007', 'mngr-it', 'staf-it1', 'Y', '2020-03-07 11:42:30', 'Menunggu persetujuan atasan', 'Pengajuan Cuti'),
('42425240e4e925dde0f6a0e7dec9aca3', 'PC20030017', 'staf-it1', 'staf-it1', 'Y', '2020-03-07 17:20:40', 'Pengajuan cuti : PC20030017 sudah diproses', 'Pengajuan Cuti'),
('5bb487dad6eea647172e45177ff8f901', 'PC20030013', 'mngr-it', 'staf-it1', 'Y', '2020-03-07 17:10:18', 'Menunggu persetujuan atasan', 'Pengajuan Cuti'),
('5f602d394daa00126182e09a7ac0a07f', 'PC20030009', 'staf-it1', 'staf-it1', 'Y', '2020-03-07 12:44:52', 'Pengajuan cuti : PC20030009 sudah diproses', 'Pengajuan Cuti'),
('6161865891583254299', 'PC20030002', 'mngr-it', 'staf-it1', 'Y', '2020-03-03 23:51:39', 'Menunggu persetujuan atasan', 'Pengajuan Cuti'),
('6200b735d352b47f8d71b0865941f8c1', 'PC20030016', 'staf-it1', 'staf-it1', 'Y', '2020-03-07 17:19:57', 'Pengajuan cuti : PC20030016 sudah diproses', 'Pengajuan Cuti'),
('65eb44ad7647a78277c097cc402829ee', 'PC20030010', 'staf-it1', 'staf-it1', 'Y', '2020-03-07 12:50:41', 'Pengajuan cuti : PC20030010 sudah diproses', 'Pengajuan Cuti'),
('6ac1a053adfa35e09b5658e3722c8c7b', 'PC20030008', 'staf-it1', 'staf-it1', 'Y', '2020-03-07 12:42:24', 'Pengajuan cuti : PC20030008 sudah diproses', 'Pengajuan Cuti'),
('6be1f73bb39b2385780b9998f048bde2', 'PC20030011', 'staf-it1', 'staf-it1', 'Y', '2020-03-07 16:58:11', 'Pengajuan cuti : PC20030011 sudah diproses', 'Pengajuan Cuti'),
('751eb24006f8a00e6160b2ab4d5e58fe', 'PC20030006', 'mngr-it', 'staf-it1', 'Y', '2020-03-07 00:28:59', 'Menunggu persetujuan atasan', 'Pengajuan Cuti'),
('75a55f30c98b605ca4f3d263fc1b07c8', 'PC20030006', 'staf-it1', 'staf-it1', 'Y', '2020-03-07 11:42:23', 'Pengajuan cuti : PC20030006 sudah diproses', 'Pengajuan Cuti'),
('7b91fcf3ba9340fdbe9e4dbb96a86ad5', 'PC20030004', 'spv-it1', 'spv-it1', 'Y', '2020-03-04 15:46:10', 'Pengajuan cuti : PC20030004 sudah diproses', 'Pengajuan Cuti'),
('83a950cb43b2ce748369c64e7e88eba8', 'PC20030002', 'staf-it1', 'staf-it1', 'Y', '2020-03-04 16:14:07', 'Pengajuan cuti : PC20030002 sudah diproses', 'Pengajuan Cuti'),
('83c4d008beef5e95256bba8b953bcc1c', 'PC20030003', 'spv-it1', 'spv-it1', 'Y', '2020-03-04 15:44:28', 'Pengajuan cuti : PC20030003 sudah diproses', 'Pengajuan Cuti'),
('86dce935a856a14de04970d0cc6ab702', 'PC20030001', 'spv-it1', 'spv-it1', 'Y', '2020-03-04 14:50:11', 'Pengajuan cuti : PC20030001 sudah diproses', 'Pengajuan Cuti'),
('8ea41d6981518fb527db164b9015c735', 'PC20030019', 'mngr-it', 'spv-it1', 'Y', '2020-03-08 12:01:34', 'Menunggu persetujuan atasan', 'Pengajuan Cuti'),
('97228575208f3659f5f83bf46f4a41f9', 'PC20030019', 'spv-it1', 'spv-it1', 'N', '2020-03-24 23:09:03', 'Pengajuan cuti : PC20030019 sudah diproses', 'Pengajuan Cuti'),
('9eae3673142f9884fdd3db7204041318', 'PC20030005', 'mngr-it', 'staf-it1', 'Y', '2020-03-04 23:19:58', 'Menunggu persetujuan atasan', 'Pengajuan Cuti'),
('a0f154788199d9b9bd09df8e2923e52b', 'PC20030016', 'mngr-it', 'staf-it1', 'Y', '2020-03-07 17:17:51', 'Menunggu persetujuan atasan', 'Pengajuan Cuti'),
('a38428b8f31c4b54c96f8c79b305b5d7', 'PC20030012', 'spv-it1', 'spv-it1', 'N', '2020-03-07 12:53:13', 'Pengajuan cuti : PC20030012 sudah diproses', 'Pengajuan Cuti'),
('ac692dd6c81e926d6694c79a96e53462', 'PC20030018', 'mngr-it', 'staf-it1', 'Y', '2020-03-07 17:21:50', 'Menunggu persetujuan atasan', 'Pengajuan Cuti'),
('adbe0b9907df364820b7e113f6f9404b', 'PC20060001', 'mngr-it', 'staf-it1', 'Y', '2020-06-10 08:50:13', 'Menunggu persetujuan atasan', 'Pengajuan Cuti'),
('b0d2658e2a532a8d138f34210b4304b5', 'PC20030014', 'staf-it1', 'staf-it1', 'Y', '2020-03-07 17:16:55', 'Pengajuan cuti : PC20030014 sudah diproses', 'Pengajuan Cuti'),
('b1663234aee12f9e47a11cc1c5991c58', 'PC20030015', 'staf-it1', 'staf-it1', 'Y', '2020-03-07 17:17:41', 'Pengajuan cuti : PC20030015 sudah diproses', 'Pengajuan Cuti'),
('b3608da625a64c3e0e41042e998511ef', 'PC20030018', 'staf-it1', 'staf-it1', 'Y', '2020-03-07 17:22:01', 'Pengajuan cuti : PC20030018 sudah diproses', 'Pengajuan Cuti'),
('b7a7ac4a7d5d577a6bee54251ddcd6ea', 'PC20030010', 'mngr-it', 'staf-it1', 'Y', '2020-03-07 12:45:12', 'Menunggu persetujuan atasan', 'Pengajuan Cuti'),
('ba983b91e5c6f666c7dc1ff7090b5762', 'PC20030012', 'mngr-it', 'spv-it1', 'Y', '2020-03-07 12:53:00', 'Menunggu persetujuan atasan', 'Pengajuan Cuti'),
('bb01d0406160bca9b94ff58df1258719', 'PC20030007', 'staf-it1', 'staf-it1', 'Y', '2020-03-07 12:38:49', 'Pengajuan cuti : PC20030007 sudah diproses', 'Pengajuan Cuti'),
('bf8f528c1ba2428b5689bea2eee8ae8f', 'PC20060001', 'staf-it1', 'staf-it1', 'N', '2020-06-10 08:52:15', 'Pengajuan cuti : PC20060001 sudah diproses', 'Pengajuan Cuti'),
('c245f897b30b3529642db97ee75ed2f1', 'PC20030013', 'staf-it1', 'staf-it1', 'Y', '2020-03-07 17:15:54', 'Pengajuan cuti : PC20030013 sudah diproses', 'Pengajuan Cuti'),
('cb481d1a58bc0e3757dcda2c955838bd', 'PC20030003', 'mngr-it', 'spv-it1', 'Y', '2020-03-04 15:38:51', 'Menunggu persetujuan atasan', 'Pengajuan Cuti'),
('cd3b72b329cc67078fca0ec765fbfe83', 'PC20030014', 'mngr-it', 'staf-it1', 'Y', '2020-03-07 17:16:11', 'Menunggu persetujuan atasan', 'Pengajuan Cuti'),
('de10c7a0f206a292400063e6e39716b1', 'PC20030008', 'mngr-it', 'staf-it1', 'Y', '2020-03-07 12:39:57', 'Menunggu persetujuan atasan', 'Pengajuan Cuti'),
('e298932f50e827812692651d2cde2c96', 'PC20030009', 'mngr-it', 'staf-it1', 'Y', '2020-03-07 12:42:48', 'Menunggu persetujuan atasan', 'Pengajuan Cuti'),
('fea5ce2665acdf2ddd191191f158672e', 'PC20030011', 'mngr-it', 'staf-it1', 'Y', '2020-03-07 12:51:42', 'Menunggu persetujuan atasan', 'Pengajuan Cuti');

-- --------------------------------------------------------

--
-- Table structure for table `pengajuan_cuti`
--

CREATE TABLE `pengajuan_cuti` (
  `id` char(100) NOT NULL,
  `nomor` char(10) NOT NULL,
  `nik` char(10) NOT NULL,
  `tanggal` datetime NOT NULL,
  `alasan` text NOT NULL,
  `tgl_awal` date NOT NULL,
  `tgl_akhir` date NOT NULL,
  `jumlah_cuti` decimal(3,1) NOT NULL,
  `approve_atasan1` enum('Y','N','') NOT NULL DEFAULT '',
  `nik_atasan1` char(10) NOT NULL,
  `tgl_approve_atasan1` datetime NOT NULL DEFAULT '1900-01-01 00:00:00',
  `ket_approve_atasan1` text NOT NULL,
  `approve_atasan2` enum('Y','N','X','') NOT NULL DEFAULT '',
  `nik_approve_atasan2` char(10) NOT NULL,
  `tgl_approve_atasan2` datetime NOT NULL DEFAULT '1900-01-01 00:00:00',
  `ket_approve_atasan2` text NOT NULL,
  `approve_hrd` enum('Y','N','') NOT NULL DEFAULT '',
  `nik_approve_hrd` char(10) NOT NULL,
  `tgl_approve_hrd` datetime NOT NULL DEFAULT '1900-01-01 00:00:00',
  `ket_approve_hrd` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `pengajuan_cuti`
--

INSERT INTO `pengajuan_cuti` (`id`, `nomor`, `nik`, `tanggal`, `alasan`, `tgl_awal`, `tgl_akhir`, `jumlah_cuti`, `approve_atasan1`, `nik_atasan1`, `tgl_approve_atasan1`, `ket_approve_atasan1`, `approve_atasan2`, `nik_approve_atasan2`, `tgl_approve_atasan2`, `ket_approve_atasan2`, `approve_hrd`, `nik_approve_hrd`, `tgl_approve_hrd`, `ket_approve_hrd`) VALUES
('1a3abd1768496eff090acba121d06a91', 'PC20030002', 'staf-it1', '2020-03-03 23:51:39', 'tes staff it', '2020-03-10', '2020-03-10', '1.0', 'N', 'mngr-it', '2020-03-04 16:14:07', '', '', '', '1900-01-01 00:00:00', '', '', '', '1900-01-01 00:00:00', ''),
('311cd941cacb6bedc8bf53346a568eba', 'PC20030001', 'spv-it1', '2020-03-03 23:48:46', 'tes pengajuan spv-it', '2020-03-10', '2020-03-10', '1.0', 'N', 'mngr-it', '2020-03-04 14:50:11', '', '', '', '1900-01-01 00:00:00', '', '', '', '1900-01-01 00:00:00', ''),
('31c97bfd29f36647b3093b42600829c6', 'PC20030004', 'spv-it1', '2020-03-04 15:45:48', 'asd asd asdas dsad', '2020-03-12', '2020-03-13', '2.0', 'Y', 'mngr-it', '2020-03-04 15:46:10', '', '', '', '1900-01-01 00:00:00', '', '', '', '1900-01-01 00:00:00', ''),
('343bb049af8db2c5d76936c6f8348d6a', 'PC20030009', 'staf-it1', '2020-03-07 12:42:47', 'adasda', '2020-03-20', '2020-03-20', '1.0', 'N', 'mngr-it', '2020-03-07 12:44:52', '', '', '', '1900-01-01 00:00:00', '', '', '', '1900-01-01 00:00:00', ''),
('35c90def91e7b6959c2ada65b3d67144', 'PC20030007', 'staf-it1', '2020-03-07 11:42:29', 'asd sdasda', '2020-03-19', '2020-03-19', '1.0', 'N', 'mngr-it', '2020-03-07 12:38:49', '', '', '', '1900-01-01 00:00:00', '', '', '', '1900-01-01 00:00:00', ''),
('3d0d541f770f43038eede698d5df637c', 'PC20030008', 'staf-it1', '2020-03-07 12:39:56', 'asdasdasdasd', '2020-03-20', '2020-03-20', '1.0', 'N', 'mngr-it', '2020-03-07 12:42:24', '', '', '', '1900-01-01 00:00:00', '', '', '', '1900-01-01 00:00:00', ''),
('5bade90948d34a5813180d932dbddccf', 'PC20060001', 'staf-it1', '2020-06-10 08:50:13', 'ada acara keluarga', '2020-06-17', '2020-06-17', '1.0', 'N', 'mngr-it', '2020-06-10 08:52:15', '', '', '', '1900-01-01 00:00:00', '', '', '', '1900-01-01 00:00:00', ''),
('7c04e7168bacf17634607bbdd10b4500', 'PC20030011', 'staf-it1', '2020-03-07 12:51:41', 'asdasdasd', '2020-03-18', '2020-03-18', '1.0', 'N', 'mngr-it', '2020-03-07 16:58:11', '', '', '', '1900-01-01 00:00:00', '', '', '', '1900-01-01 00:00:00', ''),
('8890fa3bb2c5a0503c02bf87ccedbcac', 'PC20030010', 'staf-it1', '2020-03-07 12:45:10', 'asdasdasd', '2020-03-19', '2020-03-19', '1.0', 'Y', 'mngr-it', '2020-03-07 12:50:41', '', '', '', '1900-01-01 00:00:00', '', '', '', '1900-01-01 00:00:00', ''),
('aa66d2ec8101f53eb8c6db590de72702', 'PC20030006', 'staf-it1', '2020-03-07 00:28:59', 'asasdasd', '2020-03-16', '2020-03-16', '1.0', 'N', 'mngr-it', '2020-03-07 11:42:23', '', '', '', '1900-01-01 00:00:00', '', '', '', '1900-01-01 00:00:00', ''),
('acb890f18b89663e784038dbebd69df6', 'PC20030016', 'staf-it1', '2020-03-07 17:17:51', 'sdasdasd as da', '2020-03-17', '2020-03-17', '1.0', 'Y', 'mngr-it', '2020-03-07 17:19:57', '', '', '', '1900-01-01 00:00:00', '', '', '', '1900-01-01 00:00:00', ''),
('ad6b184e051f20918e119cd067fbe5bb', 'PC20030013', 'staf-it1', '2020-03-07 17:10:17', 'asd sd s', '2020-03-16', '2020-03-16', '1.0', 'Y', 'mngr-it', '2020-03-07 17:15:54', '', '', '', '1900-01-01 00:00:00', '', '', '', '1900-01-01 00:00:00', ''),
('b0c85b27962775e234afb8457cacc93d', 'PC20030005', 'staf-it1', '2020-03-04 23:19:58', 'Acara keluarga', '2020-04-09', '2020-04-13', '2.0', 'Y', 'mngr-it', '2020-03-04 23:28:23', '', '', '', '1900-01-01 00:00:00', '', '', '', '1900-01-01 00:00:00', ''),
('be50891b9c2af73eb10628e79dccbbad', 'PC20030017', 'staf-it1', '2020-03-07 17:20:10', 'sadsadas da', '2020-03-20', '2020-03-20', '1.0', 'Y', 'mngr-it', '2020-03-07 17:20:40', '', '', '', '1900-01-01 00:00:00', '', '', '', '1900-01-01 00:00:00', ''),
('c48995b839344d8f5e53f14a2811a2ea', 'PC20030018', 'staf-it1', '2020-03-07 17:21:50', 'sdaf sdf asdf', '2020-03-19', '2020-03-19', '1.0', 'Y', 'mngr-it', '2020-03-07 17:22:01', '', '', '', '1900-01-01 00:00:00', '', '', '', '1900-01-01 00:00:00', ''),
('c6d44dabde89a84dc6c90fc89cedd788', 'PC20030014', 'staf-it1', '2020-03-07 17:16:11', 'asdasdasdasd', '2020-03-17', '2020-03-17', '1.0', 'Y', 'mngr-it', '2020-03-07 17:16:55', '', '', '', '1900-01-01 00:00:00', '', '', '', '1900-01-01 00:00:00', ''),
('c7b74032c40c2ee9e1d16ce251b8eca8', 'PC20030019', 'spv-it1', '2020-03-08 12:01:34', 'sdfsadfsdfsadf', '2020-03-23', '2020-03-23', '1.0', 'Y', 'mngr-it', '2020-03-24 23:09:03', '', '', '', '1900-01-01 00:00:00', '', '', '', '1900-01-01 00:00:00', ''),
('de684cdf784cd9097a9eb296584ae70e', 'PC20030015', 'staf-it1', '2020-03-07 17:17:08', 'sadasdasd', '2020-03-16', '2020-03-16', '1.0', 'Y', 'mngr-it', '2020-03-07 17:17:41', '', '', '', '1900-01-01 00:00:00', '', '', '', '1900-01-01 00:00:00', ''),
('ee409ee61a070df3fa4a271c7bcfb1c8', 'PC20030003', 'spv-it1', '2020-03-04 15:38:51', 'dasf asdf sadfasdf', '2020-03-11', '2020-03-11', '1.0', 'N', 'mngr-it', '2020-03-04 15:44:28', '', '', '', '1900-01-01 00:00:00', '', '', '', '1900-01-01 00:00:00', ''),
('f858861c9939911b07fd21d37484762c', 'PC20030012', 'spv-it1', '2020-03-07 12:52:59', 'asdasd', '2020-03-14', '2020-03-14', '0.0', 'N', 'mngr-it', '2020-03-07 12:53:13', '', '', '', '1900-01-01 00:00:00', '', '', '', '1900-01-01 00:00:00', '');

-- --------------------------------------------------------

--
-- Table structure for table `tgl_libur_nasional`
--

CREATE TABLE `tgl_libur_nasional` (
  `no_urut` int(11) NOT NULL,
  `tgl_libur` date NOT NULL,
  `keterangan` varchar(100) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `tahun` char(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tgl_libur_nasional`
--

INSERT INTO `tgl_libur_nasional` (`no_urut`, `tgl_libur`, `keterangan`, `tahun`) VALUES
(43, '2020-01-01', 'Tahun baru Masehi', '2020'),
(45, '2020-01-25', 'TAHUN BARU IMLEK 2571', '2020'),
(46, '2020-03-22', 'ISRA MIKRAJ NABI MUHAMMAD SAW', '2020'),
(47, '2020-03-25', 'HARI RAYA NYEPI TAHUN BARU SAKA 1942', '2020'),
(48, '2020-04-10', 'WAFAT ISA ALMASIH', '2020'),
(49, '2020-05-01', 'HARI BURUH INTERNASIONAL', '2020'),
(50, '2020-05-07', 'HARI RAYA WAISAK 2562', '2020'),
(51, '2020-05-21', 'KENAIKAN ISA AL MASIH', '2020'),
(52, '2020-05-24', 'HARI RAYA IDUL FITRI 1441 HIJRIAH', '2020'),
(53, '2020-05-25', 'HARI RAYA IDUL FITRI 1441 HIJRIAH', '2020'),
(54, '2020-06-01', 'HARI LAHIR PANCASILA', '2020'),
(56, '2020-07-31', 'HARI RAYA IDUL ADHA 1441  HIJRIAH', '2020'),
(57, '2020-08-17', 'HARI KEMERDEKAAN REPUBLIK INDONESIA 75 TH', '2020'),
(58, '2020-08-20', 'TAHUN BARU ISLAM 1442 HIJRIYAH', '2020'),
(59, '2020-10-29', 'MAULID NABI MUHAMMAD SAW', '2020'),
(60, '2020-12-25', 'HARI RAYA NATAL', '2020'),
(61, '2020-05-22', 'CUTI MASSAL MENYAMBUT HARI RAYA IDUL FITRI', '2020'),
(62, '2020-05-23', 'CUTI MASSAL MENYAMBUT HARI RAYA IDUL FITRI', '2020'),
(63, '2020-05-26', 'CUTI MASSAL MENYAMBUT HARI RAYA IDUL FITRI', '2020'),
(64, '2020-05-27', 'CUTI MASSAL MENYAMBUT HARI RAYA IDUL FITRI', '2020'),
(65, '2020-12-26', 'CUTI MASSAL MENYAMBUT HARI RAYA NATAL', '2020'),
(66, '2021-01-02', 'CUTI MASSAL MENYAMBUT TAHUN BARU 2021', '2020');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `nik` char(10) NOT NULL,
  `password` char(100) NOT NULL,
  `level_user` char(30) NOT NULL,
  `salah_password` int(11) NOT NULL,
  `last_login` datetime NOT NULL,
  `blokir` enum('0','1') NOT NULL DEFAULT '0',
  `tanggal` datetime NOT NULL DEFAULT '2020-01-01 00:00:00',
  `user` char(10) NOT NULL,
  `tes` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`nik`, `password`, `level_user`, `salah_password`, `last_login`, `blokir`, `tanggal`, `user`, `tes`) VALUES
('admin', 'a00de6284c3cb5928865facaf0cbeba090d370003a1321e5f6a580804653e99d', 'admin', 0, '2020-05-01 12:18:06', '0', '2020-01-01 00:00:00', 'admin', ''),
('mngr-acc', 'a00de6284c3cb5928865facaf0cbeba090d370003a1321e5f6a580804653e99d', 'karyawan', 0, '2020-03-04 23:34:51', '0', '2020-01-01 00:00:00', 'admin', ''),
('mngr-it', 'a00de6284c3cb5928865facaf0cbeba090d370003a1321e5f6a580804653e99d', 'karyawan', 0, '2020-07-06 15:41:31', '0', '2020-01-01 00:00:00', 'admin', ''),
('spv-it1', 'a00de6284c3cb5928865facaf0cbeba090d370003a1321e5f6a580804653e99d', 'karyawan', 0, '2020-03-08 16:38:38', '0', '2020-01-01 00:00:00', 'admin', ''),
('staf-it1', 'a00de6284c3cb5928865facaf0cbeba090d370003a1321e5f6a580804653e99d', 'karyawan', 0, '2020-06-27 07:46:04', '0', '2020-01-01 00:00:00', 'admin', ''),
('staff-acc1', 'a00de6284c3cb5928865facaf0cbeba090d370003a1321e5f6a580804653e99d', 'karyawan', 0, '2020-03-01 23:07:29', '0', '2020-01-01 00:00:00', 'admin', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `akses`
--
ALTER TABLE `akses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `data_cuti`
--
ALTER TABLE `data_cuti`
  ADD UNIQUE KEY `nik` (`nik`,`tahun`) USING BTREE;

--
-- Indexes for table `data_karyawan`
--
ALTER TABLE `data_karyawan`
  ADD UNIQUE KEY `nik` (`nik`);

--
-- Indexes for table `divisi`
--
ALTER TABLE `divisi`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jabatan_divisi`
--
ALTER TABLE `jabatan_divisi`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `konfigurasi`
--
ALTER TABLE `konfigurasi`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `level_user`
--
ALTER TABLE `level_user`
  ADD UNIQUE KEY `kode_level` (`kode_level`);

--
-- Indexes for table `menu`
--
ALTER TABLE `menu`
  ADD UNIQUE KEY `kode_menu` (`kode_menu`);

--
-- Indexes for table `notif`
--
ALTER TABLE `notif`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `pengajuan_cuti`
--
ALTER TABLE `pengajuan_cuti`
  ADD PRIMARY KEY (`id`,`nomor`) USING BTREE;

--
-- Indexes for table `tgl_libur_nasional`
--
ALTER TABLE `tgl_libur_nasional`
  ADD PRIMARY KEY (`no_urut`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`nik`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `akses`
--
ALTER TABLE `akses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=75;

--
-- AUTO_INCREMENT for table `divisi`
--
ALTER TABLE `divisi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `jabatan_divisi`
--
ALTER TABLE `jabatan_divisi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `konfigurasi`
--
ALTER TABLE `konfigurasi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tgl_libur_nasional`
--
ALTER TABLE `tgl_libur_nasional`
  MODIFY `no_urut` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;
