-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 13 Jul 2024 pada 10.38
-- Versi server: 10.4.22-MariaDB
-- Versi PHP: 8.1.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_app`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `kategori`
--

CREATE TABLE `kategori` (
  `id` int(11) NOT NULL,
  `nama_kategori` varchar(128) NOT NULL,
  `created` datetime DEFAULT NULL,
  `status` int(2) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `kategori`
--

INSERT INTO `kategori` (`id`, `nama_kategori`, `created`, `status`) VALUES
(1, 'Oragnisasi', NULL, 1),
(2, 'Ekstrakulikuler', NULL, 1),
(3, 'Olympiade Sains', '2022-07-30 11:32:49', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `keys`
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `keys`
--

INSERT INTO `keys` (`id`, `user_id`, `key`, `level`, `ignore_limits`, `is_private_key`, `ip_addresses`, `date_created`) VALUES
(1, 1, 'restapi', 1, 0, 0, NULL, 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `limits`
--

CREATE TABLE `limits` (
  `id` int(11) NOT NULL,
  `uri` varchar(255) NOT NULL,
  `count` int(10) NOT NULL,
  `hour_started` int(11) NOT NULL,
  `api_key` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `limits`
--

INSERT INTO `limits` (`id`, `uri`, `count`, `hour_started`, `api_key`) VALUES
(1, 'uri:Api_Berita/index:get', 2, 1674370982, 'restapi');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_pengguna`
--

CREATE TABLE `tbl_pengguna` (
  `id_pengguna` int(11) NOT NULL,
  `username` varchar(128) NOT NULL,
  `password` varchar(128) DEFAULT NULL,
  `npwp` bigint(20) DEFAULT NULL,
  `nama` varchar(256) NOT NULL,
  `email` varchar(256) NOT NULL,
  `mobile` varchar(15) NOT NULL,
  `jenis_kelamin` varchar(30) NOT NULL,
  `tgl_lahir` varchar(64) NOT NULL,
  `alamat` text NOT NULL,
  `nama_instansi` varchar(256) NOT NULL,
  `t_msk` int(5) NOT NULL,
  `t_tmt` int(5) NOT NULL,
  `pekerjaan` varchar(64) NOT NULL,
  `prestasi` text NOT NULL,
  `img` varchar(128) DEFAULT NULL,
  `created` varchar(20) DEFAULT NULL,
  `modified` varchar(20) DEFAULT NULL,
  `isDeleted` tinyint(4) NOT NULL DEFAULT 0,
  `status` int(5) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tbl_pengguna`
--

INSERT INTO `tbl_pengguna` (`id_pengguna`, `username`, `password`, `npwp`, `nama`, `email`, `mobile`, `jenis_kelamin`, `tgl_lahir`, `alamat`, `nama_instansi`, `t_msk`, `t_tmt`, `pekerjaan`, `prestasi`, `img`, `created`, `modified`, `isDeleted`, `status`) VALUES
(68, 'agunglbn', '$2y$10$9qAfYHfXH3LLy44KbloVHuQ47B2VZQY7aPq5G/QHW9lSOtnCYdV5O', 981231232131, 'AgungFs', 'agung@gmail.com', '0890098900', 'L', '24/07/1977', 'Jalan Nuri Raya 209 Perumahan Sidomulyo', 'Universitas Riau', 2016, 2019, 'Mahasiswa', 'Debat, Karya Ilmia', 'Pas_Photo.jpg', '2022-06-29 07:48:49', '2024-Jul-13 10:35:24', 0, 1),
(73, 'aldops', '$2y$10$tuhXj7lIVxV4M9SSYeMto.X/BMIqDfiERRuyYLbakI7qw8QycPiHO', 62124123122, 'Aldo Fernando Silaban', 'aldoastek242@gmail.com', '0890098900', 'L', '2001-06-25', 'Jalan Melur Raya Pekanbaru', 'PT Jaya Serba Guna', 2010, 2013, 'Bekerja', '', 'aaaaaaaaaaaa2.jpg', '2022-07-13 04:47:06', '2024-Jul-13 10:19:03', 0, 0),
(75, 'santa25', '$2y$10$pObAPZ1W3MIA9/KOLe8FsOGjpmH4V0JCTg7KFblUQSFuq7d5aXHjm', 32423423424, 'Santa Putri222', 'santa253@gmail.com', '0890098900', 'P', '', 'Jalan Pahlawan Perumah Citra No 198 Pekanbaru', 'PT Cahaya Sejahtera Jakarta', 0, 0, '', '', 'download_(1).jpeg', '2022-07-25 08:10:37', '2024-07-13 10:35:45', 0, 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_reset_password`
--

CREATE TABLE `tbl_reset_password` (
  `id` bigint(20) NOT NULL,
  `email` varchar(128) NOT NULL,
  `activation_id` varchar(32) NOT NULL,
  `agent` varchar(512) NOT NULL,
  `client_ip` varchar(32) NOT NULL,
  `isDeleted` tinyint(4) NOT NULL DEFAULT 0,
  `createdBy` bigint(20) NOT NULL DEFAULT 1,
  `createdDtm` datetime NOT NULL,
  `updatedBy` bigint(20) DEFAULT NULL,
  `updatedDtm` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tbl_reset_password`
--

INSERT INTO `tbl_reset_password` (`id`, `email`, `activation_id`, `agent`, `client_ip`, `isDeleted`, `createdBy`, `createdDtm`, `updatedBy`, `updatedDtm`) VALUES
(22, 'agungsilaban25@gmail.com', 'F7bSsk5N1WPeh0Z', 'Chrome 98.0.4758.102', '::1', 0, 1, '2022-02-22 05:46:29', NULL, NULL),
(23, 'agungsilaban25@gmail.com', 'rl8y0NKLpsXUn3C', 'Chrome 98.0.4758.102', '::1', 0, 1, '2022-02-22 05:46:33', NULL, NULL),
(24, 'agungsilaban25@gmail.com', 'sHvLENnyT9RUzKF', 'Chrome 102.0.0.0', '::1', 0, 1, '2022-06-13 08:31:54', NULL, NULL),
(25, 'agungsilaban25@gmail.com', 'uhMYw5tEyZfkPxW', 'Chrome 102.0.0.0', '::1', 0, 1, '2022-06-26 19:33:32', NULL, NULL),
(26, 'admin@bewithdhanu.in', 'uWq9jVRZH2FUXkS', 'Chrome 102.0.0.0', '::1', 0, 1, '2022-06-26 19:33:42', NULL, NULL),
(27, 'admin@bewithdhanu.in', 'aQtpEzWi0r13dTM', 'Chrome 102.0.0.0', '::1', 0, 1, '2022-06-26 19:33:56', NULL, NULL),
(28, 'agungsilaban25@gmail.com', 'fm97NVuHdgIEkwn', 'Chrome 102.0.0.0', '::1', 0, 1, '2022-06-27 11:04:19', NULL, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_roles`
--

CREATE TABLE `tbl_roles` (
  `roleId` tinyint(4) NOT NULL COMMENT 'role id',
  `role` varchar(50) NOT NULL COMMENT 'role text'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `tbl_roles`
--

INSERT INTO `tbl_roles` (`roleId`, `role`) VALUES
(1, 'System Administrator'),
(2, 'Admin');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_users`
--

CREATE TABLE `tbl_users` (
  `userId` int(11) NOT NULL,
  `email` varchar(128) NOT NULL COMMENT 'login email',
  `password` varchar(128) NOT NULL COMMENT 'hashed login password',
  `name` varchar(128) DEFAULT NULL COMMENT 'full name of user',
  `npwp` int(15) NOT NULL,
  `mobile` varchar(20) DEFAULT NULL,
  `roleId` tinyint(4) NOT NULL DEFAULT 3,
  `isDeleted` tinyint(4) NOT NULL DEFAULT 0,
  `createdBy` int(11) NOT NULL,
  `createdDtm` datetime NOT NULL,
  `updatedBy` int(11) DEFAULT NULL,
  `updatedDtm` datetime DEFAULT NULL,
  `level` int(2) NOT NULL COMMENT '1:admin,2:user'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `tbl_users`
--

INSERT INTO `tbl_users` (`userId`, `email`, `password`, `name`, `npwp`, `mobile`, `roleId`, `isDeleted`, `createdBy`, `createdDtm`, `updatedBy`, `updatedDtm`, `level`) VALUES
(5, 'agungsilaban25@gmail.com', '$2y$10$KmzCL24GjX5yvsaQGw8oAOOYvAlMUfof2FXyr03iYV9qMYtRnXSre', 'Agung', 2134212342, '0812898732', 1, 0, 1, '2022-02-22 05:45:42', 1, '2022-02-28 13:08:52', 0);

-- --------------------------------------------------------

--
-- Struktur dari tabel `upload`
--

CREATE TABLE `upload` (
  `id` int(11) NOT NULL,
  `id_potong` varchar(32) NOT NULL,
  `nama_file` varchar(64) NOT NULL,
  `pasal` varchar(16) NOT NULL,
  `kode_objek_pajak` varchar(64) NOT NULL,
  `no_bukti_potong` varchar(16) NOT NULL,
  `tanggal_bupot` varchar(16) NOT NULL,
  `pph_potong` varchar(16) NOT NULL,
  `jumlah_bruto` varchar(16) NOT NULL,
  `file` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `upload`
--

INSERT INTO `upload` (`id`, `id_potong`, `nama_file`, `pasal`, `kode_objek_pajak`, `no_bukti_potong`, `tanggal_bupot`, `pph_potong`, `jumlah_bruto`, `file`) VALUES
(3, '755808078085000', 'KREASI FUNEDGE NUSANTARA', 'PPH23', '24-104-24', '2 00 0000001', '27-05-2024', '260000', '13000000', '');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `keys`
--
ALTER TABLE `keys`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `limits`
--
ALTER TABLE `limits`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tbl_pengguna`
--
ALTER TABLE `tbl_pengguna`
  ADD PRIMARY KEY (`id_pengguna`);

--
-- Indeks untuk tabel `tbl_reset_password`
--
ALTER TABLE `tbl_reset_password`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tbl_roles`
--
ALTER TABLE `tbl_roles`
  ADD PRIMARY KEY (`roleId`);

--
-- Indeks untuk tabel `tbl_users`
--
ALTER TABLE `tbl_users`
  ADD PRIMARY KEY (`userId`);

--
-- Indeks untuk tabel `upload`
--
ALTER TABLE `upload`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `kategori`
--
ALTER TABLE `kategori`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `keys`
--
ALTER TABLE `keys`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `limits`
--
ALTER TABLE `limits`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `tbl_pengguna`
--
ALTER TABLE `tbl_pengguna`
  MODIFY `id_pengguna` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=232;

--
-- AUTO_INCREMENT untuk tabel `tbl_reset_password`
--
ALTER TABLE `tbl_reset_password`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT untuk tabel `tbl_roles`
--
ALTER TABLE `tbl_roles`
  MODIFY `roleId` tinyint(4) NOT NULL AUTO_INCREMENT COMMENT 'role id', AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `tbl_users`
--
ALTER TABLE `tbl_users`
  MODIFY `userId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT untuk tabel `upload`
--
ALTER TABLE `upload`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
