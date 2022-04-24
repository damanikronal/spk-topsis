-- phpMyAdmin SQL Dump
-- version 2.11.9.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Waktu pembuatan: 28. Desember 2012 jam 21:35
-- Versi Server: 5.0.67
-- Versi PHP: 5.2.6

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `topsis`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `alternatif`
--

CREATE TABLE IF NOT EXISTS `alternatif` (
  `id_alt` varchar(3) collate latin1_general_ci NOT NULL,
  `nm_alt` varchar(100) collate latin1_general_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data untuk tabel `alternatif`
--

INSERT INTO `alternatif` (`id_alt`, `nm_alt`) VALUES
('1', 'Kost "Pelangi"'),
('2', 'Kost "Taruna"'),
('3', 'Kost "Adith"');

-- --------------------------------------------------------

--
-- Struktur dari tabel `bobot_kriteria`
--

CREATE TABLE IF NOT EXISTS `bobot_kriteria` (
  `id_kriteria` varchar(3) collate latin1_general_ci NOT NULL,
  `bobot` float NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data untuk tabel `bobot_kriteria`
--

INSERT INTO `bobot_kriteria` (`id_kriteria`, `bobot`) VALUES
('1', 0.28),
('2', 0.17),
('3', 0.22),
('4', 0.22),
('5', 0.11);

-- --------------------------------------------------------

--
-- Struktur dari tabel `hasil`
--

CREATE TABLE IF NOT EXISTS `hasil` (
  `id_alt` varchar(3) collate latin1_general_ci NOT NULL,
  `bobot_hasil` float NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data untuk tabel `hasil`
--

INSERT INTO `hasil` (`id_alt`, `bobot_hasil`) VALUES
('1', 0.6665),
('2', 0.7422),
('3', 0.173);

-- --------------------------------------------------------

--
-- Struktur dari tabel `kriteria`
--

CREATE TABLE IF NOT EXISTS `kriteria` (
  `id_kriteria` varchar(3) collate latin1_general_ci NOT NULL,
  `nama_kriteria` varchar(100) collate latin1_general_ci NOT NULL,
  `tipe` enum('COST','BENEFIT') collate latin1_general_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data untuk tabel `kriteria`
--

INSERT INTO `kriteria` (`id_kriteria`, `nama_kriteria`, `tipe`) VALUES
('1', 'Jarak dgn Kampus', 'COST'),
('2', 'Fasilitas kamar tidur', 'BENEFIT'),
('3', 'Biaya listrik', 'COST'),
('4', 'Jarak dgn fasilitas umum', 'BENEFIT'),
('5', 'Harga Sewa', 'COST');

-- --------------------------------------------------------

--
-- Struktur dari tabel `matrik`
--

CREATE TABLE IF NOT EXISTS `matrik` (
  `id_alt` varchar(3) collate latin1_general_ci NOT NULL,
  `id_kriteria` varchar(3) collate latin1_general_ci NOT NULL,
  `nilai` float NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data untuk tabel `matrik`
--

INSERT INTO `matrik` (`id_alt`, `id_kriteria`, `nilai`) VALUES
('1', '1', 0.75),
('1', '2', 2000),
('1', '3', 18),
('1', '4', 50),
('1', '5', 500),
('2', '1', 0.5),
('2', '2', 1500),
('2', '3', 20),
('2', '4', 40),
('2', '5', 450),
('3', '1', 0.9),
('3', '2', 2050),
('3', '3', 35),
('3', '4', 35),
('3', '5', 800);

-- --------------------------------------------------------

--
-- Struktur dari tabel `matrik_norm`
--

CREATE TABLE IF NOT EXISTS `matrik_norm` (
  `id_alt` varchar(3) collate latin1_general_ci NOT NULL,
  `id_kriteria` varchar(3) collate latin1_general_ci NOT NULL,
  `nilai_norm` float NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data untuk tabel `matrik_norm`
--

INSERT INTO `matrik_norm` (`id_alt`, `id_kriteria`, `nilai_norm`) VALUES
('1', '1', 0.1649),
('1', '2', 0.1052),
('1', '3', 0.0897),
('1', '4', 0.1507),
('1', '5', 0.0526),
('2', '1', 0.1099),
('2', '2', 0.0789),
('2', '3', 0.0997),
('2', '4', 0.1206),
('2', '5', 0.0474),
('3', '1', 0.1978),
('3', '2', 0.1078),
('3', '3', 0.1744),
('3', '4', 0.1055),
('3', '5', 0.0842);

-- --------------------------------------------------------

--
-- Struktur dari tabel `menu`
--

CREATE TABLE IF NOT EXISTS `menu` (
  `menu` varchar(30) collate latin1_general_ci NOT NULL,
  `link` varchar(50) collate latin1_general_ci NOT NULL,
  `status` enum('admin','user') collate latin1_general_ci NOT NULL default 'user',
  `aktif` enum('y','n') collate latin1_general_ci NOT NULL,
  `urutan` int(5) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data untuk tabel `menu`
--

INSERT INTO `menu` (`menu`, `link`, `status`, `aktif`, `urutan`) VALUES
('Data Pengguna', '?modul=pengguna', 'admin', 'y', 1),
('Kriteria Penilaian', '?modul=kriteria', 'admin', 'y', 2),
('Bobot Kriteria', '?modul=bobot', 'user', 'y', 3),
('Evaluasi', '?modul=evaluasi', 'user', 'y', 5),
('Alternatif', '?modul=alternatif', 'admin', 'y', 4);

-- --------------------------------------------------------

--
-- Struktur dari tabel `pengguna`
--

CREATE TABLE IF NOT EXISTS `pengguna` (
  `email` text collate latin1_general_ci NOT NULL,
  `username` varchar(30) collate latin1_general_ci NOT NULL,
  `password` varchar(32) collate latin1_general_ci NOT NULL,
  `level` enum('admin','user') collate latin1_general_ci NOT NULL default 'user',
  PRIMARY KEY  (`username`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data untuk tabel `pengguna`
--

INSERT INTO `pengguna` (`email`, `username`, `password`, `level`) VALUES
('karen@yahoo.com', 'karen', 'ba952731f97fb058035aa399b1cb3d5c', 'admin'),
('ari@yahoo.com', 'ari', '202cb962ac59075b964b07152d234b70', 'user'),
('putri@yahoo.com', 'putri', '202cb962ac59075b964b07152d234b70', 'user'),
('rina@yahoo.com', 'rina', '202cb962ac59075b964b07152d234b70', 'user');
