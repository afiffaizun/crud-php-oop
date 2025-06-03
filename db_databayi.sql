-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3307
-- Waktu pembuatan: 02 Jun 2025 pada 13.15
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_databayi`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `databayi`
--

CREATE TABLE `databayi` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `tinggi` float NOT NULL,
  `berat` float NOT NULL,
  `jenisKelamin` varchar(20) NOT NULL,
  `tanggalLahir` date NOT NULL,
  `riwayat` varchar(100) NOT NULL,
  `catatan` varchar(50) NOT NULL,
  `orang_tua_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `databayi`
--

INSERT INTO `databayi` (`id`, `nama`, `tinggi`, `berat`, `jenisKelamin`, `tanggalLahir`, `riwayat`, `catatan`, `orang_tua_id`) VALUES
(106, 'Aisya Rahma', 82, 10, 'Perempuan', '2021-08-12', 'Pernah demam tinggi', 'berat badan ideal, tumbuh dengan baik', 9),
(107, 'Muhammad Farel', 80, 9, 'Laki-Laki', '2022-09-11', 'Alergi susu sapi', 'Disarankan ganti susu non-sapi', 8),
(108, 'Zahra Putri', 80, 11, 'Perempuan', '2022-01-20', 'Sering pilek', 'perlu pemantauan', 6),
(109, 'Rafi Pratama', 83, 10, 'Laki-Laki', '2022-09-10', 'Sehat', 'Sudahb bisa berjalan sendiri', 7),
(110, 'Ibrahimmovic', 80, 12, 'Laki-Laki', '2023-07-02', 'Sehat Sehat', 'Allhamdulilah Sehat', 10);

-- --------------------------------------------------------

--
-- Struktur dari tabel `orangtua`
--

CREATE TABLE `orangtua` (
  `orangtua_id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `jenisKelamin` varchar(15) NOT NULL,
  `telepon` int(11) NOT NULL,
  `alamat` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `orangtua`
--

INSERT INTO `orangtua` (`orangtua_id`, `nama`, `jenisKelamin`, `telepon`, `alamat`) VALUES
(3, 'Dolorum tenetur hic ', 'Laki-Laki', 123456789, 'Exercitation ea quid'),
(4, 'Laborum dolores in r', 'Perempuan', 12345678, 'Nulla pariatur In m'),
(5, 'Amet commodo deseru', 'Perempuan', 12345678, 'Temporibus illum no'),
(6, 'ibu peri', 'Perempuan', 2832923, 'Bantul'),
(7, 'Slamet', 'Laki-Laki', 895678, 'Bantul'),
(8, 'Wawan', 'Laki-Laki', 92383228, 'Sleman'),
(9, 'Siti', 'Perempuan', 1232131, 'Sleman'),
(10, 'Hendra', 'Laki-Laki', 567567567, 'Gunung Kidul');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pengguna`
--

CREATE TABLE `pengguna` (
  `user_id` int(11) NOT NULL,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `pengguna`
--

INSERT INTO `pengguna` (`user_id`, `username`, `password`) VALUES
(112, 'admin', '12345'),
(322, 'mama', '12345');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `databayi`
--
ALTER TABLE `databayi`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `orangtua`
--
ALTER TABLE `orangtua`
  ADD PRIMARY KEY (`orangtua_id`);

--
-- Indeks untuk tabel `pengguna`
--
ALTER TABLE `pengguna`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `databayi`
--
ALTER TABLE `databayi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=111;

--
-- AUTO_INCREMENT untuk tabel `orangtua`
--
ALTER TABLE `orangtua`
  MODIFY `orangtua_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
