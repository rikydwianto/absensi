-- phpMyAdmin SQL Dump
-- version 4.1.12
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 17 Apr 2016 pada 11.24
-- Versi Server: 5.5.36
-- PHP Version: 5.4.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `ptlsg`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `buyer`
--

CREATE TABLE IF NOT EXISTS `buyer` (
  `id_buyer` int(11) NOT NULL AUTO_INCREMENT,
  `nama_buyer` char(50) NOT NULL,
  `instansi_buyer` char(100) NOT NULL,
  `telepon_buyer` char(15) NOT NULL,
  `alamat_buyer` text NOT NULL,
  `keterangan_buyer` text NOT NULL,
  `date_created` datetime NOT NULL,
  `date_modified` datetime NOT NULL,
  PRIMARY KEY (`id_buyer`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data untuk tabel `buyer`
--

INSERT INTO `buyer` (`id_buyer`, `nama_buyer`, `instansi_buyer`, `telepon_buyer`, `alamat_buyer`, `keterangan_buyer`, `date_created`, `date_modified`) VALUES
(1, 'buyer 1', 'Pt. bla bla', '7677', 'vjnjh', 'jjjhgjk', '0000-00-00 00:00:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Struktur dari tabel `kedatangan_barang`
--

CREATE TABLE IF NOT EXISTS `kedatangan_barang` (
  `id_kedatangan` int(11) NOT NULL AUTO_INCREMENT,
  `id_order` int(11) NOT NULL,
  `qty_datang` int(11) NOT NULL,
  `keterangan_datang` text NOT NULL,
  `tanggal_datang` date NOT NULL,
  `status_datang` varchar(30) NOT NULL,
  `id_karyawan` int(11) NOT NULL,
  `date_created` datetime NOT NULL,
  `date_modified` datetime NOT NULL,
  PRIMARY KEY (`id_kedatangan`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=17 ;

--
-- Dumping data untuk tabel `kedatangan_barang`
--

INSERT INTO `kedatangan_barang` (`id_kedatangan`, `id_order`, `qty_datang`, `keterangan_datang`, `tanggal_datang`, `status_datang`, `id_karyawan`, `date_created`, `date_modified`) VALUES
(1, 5, 50, '', '2016-04-16', 'kurang', 296, '2016-04-16 10:19:55', '0000-00-00 00:00:00'),
(2, 5, 40, 'sds', '2016-04-16', 'lebih', 296, '2016-04-16 10:20:43', '0000-00-00 00:00:00'),
(3, 4, 100, '', '2016-04-16', 'lebih', 296, '2016-04-16 10:22:07', '0000-00-00 00:00:00'),
(4, 2, 230, '', '2016-04-16', 'sesuai', 296, '2016-04-16 10:56:39', '0000-00-00 00:00:00'),
(5, 6, 60, '', '2016-04-16', 'sesuai', 296, '2016-04-16 11:01:01', '0000-00-00 00:00:00'),
(6, 7, 500, 'sdsd', '2016-04-16', 'kurang', 296, '2016-04-16 12:44:42', '0000-00-00 00:00:00'),
(7, 7, 200, 'lebih', '2016-04-16', 'lebih', 296, '2016-04-16 12:45:11', '0000-00-00 00:00:00'),
(8, 8, 100, 'sdsd', '2016-04-16', 'kurang', 296, '2016-04-16 12:51:00', '0000-00-00 00:00:00'),
(9, 8, 50, 'sisa kemairn', '2016-04-16', 'lebih', 296, '2016-04-16 12:51:34', '0000-00-00 00:00:00'),
(10, 9, 100, 'ufuyg', '2016-04-17', 'kurang', 296, '2016-04-17 16:08:35', '0000-00-00 00:00:00'),
(11, 9, 50, 'ygyg', '2016-04-17', 'lebih', 296, '2016-04-17 16:09:22', '0000-00-00 00:00:00'),
(12, 10, 100, '', '2016-04-17', 'lebih', 296, '2016-04-17 16:11:26', '0000-00-00 00:00:00'),
(13, 11, 5, '', '2016-04-17', 'kurang', 296, '2016-04-17 16:13:36', '0000-00-00 00:00:00'),
(14, 11, 10, '', '2016-04-17', 'lebih', 296, '2016-04-17 16:14:20', '0000-00-00 00:00:00'),
(15, 12, 400, '', '2016-04-17', 'kurang', 296, '2016-04-17 16:20:47', '0000-00-00 00:00:00'),
(16, 12, 200, '', '2016-04-17', 'lebih', 296, '2016-04-17 16:21:49', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Struktur dari tabel `order_aksesoris`
--

CREATE TABLE IF NOT EXISTS `order_aksesoris` (
  `id_order` int(11) NOT NULL AUTO_INCREMENT,
  `nama_style` char(100) NOT NULL,
  `deskripsi` text NOT NULL,
  `size` varchar(100) NOT NULL,
  `warna` varchar(100) NOT NULL,
  `cons` double NOT NULL,
  `qty` int(11) NOT NULL,
  `totalqty` double NOT NULL,
  `keterangan` text NOT NULL,
  `satuan` char(30) NOT NULL,
  `tanggal_order` date NOT NULL,
  `id_karyawan` int(11) NOT NULL,
  `id_buyer` int(11) NOT NULL,
  `id_suplier` int(11) NOT NULL,
  `date_created` datetime NOT NULL,
  `date_modified` datetime NOT NULL,
  `status_order` char(50) NOT NULL,
  PRIMARY KEY (`id_order`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

--
-- Dumping data untuk tabel `order_aksesoris`
--

INSERT INTO `order_aksesoris` (`id_order`, `nama_style`, `deskripsi`, `size`, `warna`, `cons`, `qty`, `totalqty`, `keterangan`, `satuan`, `tanggal_order`, `id_karyawan`, `id_buyer`, `id_suplier`, `date_created`, `date_modified`, `status_order`) VALUES
(1, 'RB13 CB1', 'Facvsd', 'M', 'merah', 1.3, 500, 650, 'ss', 'PCS', '0000-00-00', 296, 1, 1, '2016-04-16 07:24:40', '2016-04-16 10:56:12', 'batal'),
(2, 'MD01', 'Kancing', 'L', '', 1, 230, 230, '', 'PCS', '0000-00-00', 296, 1, 1, '2016-04-16 07:26:48', '2016-04-16 07:26:48', 'sukses'),
(3, 'MD01', 'Kain ', 'XXXXL', 'mera', 1.2, 100, 120, 'sdsd', 'Yard', '0000-00-00', 296, 1, 1, '2016-04-16 08:04:56', '2016-04-16 10:51:58', 'batal'),
(4, 'RB13 CB1', 'Zipper', '30', '', 1, 10, 10, 'nm', 'Yard', '2016-04-16', 296, 1, 1, '2016-04-16 08:32:50', '2016-04-16 08:32:50', 'sukses'),
(5, 'baju renang', 'bahan', '', 'kuning', 2, 30, 60, 'khusus wanita', 'Yard', '2016-04-16', 296, 1, 1, '2016-04-16 09:42:01', '2016-04-16 09:42:01', 'sukses'),
(6, 'RB1', 'Bahan Baju ', '300', 'Navy', 2, 30, 60, 'kjk', 'Yard', '2015-10-30', 296, 1, 1, '2016-04-16 11:00:15', '2016-04-16 11:00:15', 'sukses'),
(7, 'RB13 CB1', 'Wangky TC 20s 413821', '40 x 9', '', 1, 600, 600, '', 'KG', '2016-04-16', 296, 1, 1, '2016-04-16 11:14:18', '2016-04-16 11:14:18', 'sukses'),
(8, 'HAHAHAH', 'deskri', '40 x 9', 'wanra', 1.2, 100, 120, 'sds', 'KG', '2016-04-16', 296, 1, 1, '2016-04-16 12:50:36', '2016-04-16 12:50:36', 'sukses'),
(9, '', '', '', '', 1.2, 100, 120, '', 'KG', '2016-04-17', 296, 1, 1, '2016-04-17 15:40:20', '2016-04-17 15:40:20', 'sukses'),
(10, 'RA', 'Kancing ', '', 'merah', 1, 90, 90, 'klsnjd', 'PCS', '2016-04-17', 296, 1, 1, '2016-04-17 16:10:59', '2016-04-17 16:10:59', 'sukses'),
(11, 'RJ MD01', 'Bahan Baju', '40 x 9', 'merah', 1, 10, 10, 'kbkj', 'KG', '2016-04-17', 296, 1, 1, '2016-04-17 16:13:15', '2016-04-17 16:13:15', 'sukses'),
(12, 'Coba', 'Tali', '100', 'merah', 1, 500, 500, 'ds', 'Yard', '2016-04-17', 296, 1, 1, '2016-04-17 16:20:31', '2016-04-17 16:20:31', 'sukses');

-- --------------------------------------------------------

--
-- Struktur dari tabel `satuan`
--

CREATE TABLE IF NOT EXISTS `satuan` (
  `id_satuan` int(11) NOT NULL AUTO_INCREMENT,
  `satuan` varchar(30) NOT NULL,
  `keterangan_satuan` text NOT NULL,
  PRIMARY KEY (`id_satuan`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data untuk tabel `satuan`
--

INSERT INTO `satuan` (`id_satuan`, `satuan`, `keterangan_satuan`) VALUES
(1, 'KG', ''),
(2, 'Yard', ''),
(3, 'PCS', '');

-- --------------------------------------------------------

--
-- Struktur dari tabel `stock_aksesoris`
--

CREATE TABLE IF NOT EXISTS `stock_aksesoris` (
  `id_stock` int(11) NOT NULL AUTO_INCREMENT,
  `nama_style` char(100) NOT NULL,
  `deskripsi` text NOT NULL,
  `size` varchar(100) NOT NULL,
  `warna` varchar(100) NOT NULL,
  `qty` int(11) NOT NULL,
  `keterangan` text NOT NULL,
  `satuan` char(30) NOT NULL,
  `tanggal_input` date NOT NULL,
  `id_karyawan` int(11) NOT NULL,
  `date_created` datetime NOT NULL,
  `date_modified` datetime NOT NULL,
  `lebihan` enum('ya','tidak') NOT NULL DEFAULT 'tidak',
  PRIMARY KEY (`id_stock`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=16 ;

--
-- Dumping data untuk tabel `stock_aksesoris`
--

INSERT INTO `stock_aksesoris` (`id_stock`, `nama_style`, `deskripsi`, `size`, `warna`, `qty`, `keterangan`, `satuan`, `tanggal_input`, `id_karyawan`, `date_created`, `date_modified`, `lebihan`) VALUES
(1, 'baju renang', 'bahan', '', 'kuning', 60, 'khusus wanita', 'Yard', '2016-04-16', 296, '2016-04-16 10:19:55', '2016-04-16 10:19:55', 'tidak'),
(2, 'baju renang', 'bahan', '', 'kuning', 30, 'khusus wanita', 'Yard', '2016-04-16', 296, '2016-04-16 10:20:43', '2016-04-16 10:20:43', 'ya'),
(3, 'RB13 CB1', 'Zipper', '30', '', 690, 'nm', 'Yard', '2016-04-16', 296, '2016-04-16 10:22:07', '2016-04-16 12:45:11', 'ya'),
(4, 'RB13 CB1', 'Zipper', '30', '', 10, 'nm', 'Yard', '2016-04-16', 296, '2016-04-16 10:22:07', '2016-04-16 10:22:07', 'tidak'),
(5, 'MD01', 'Kancing', 'L', '', 230, '', 'PCS', '2016-04-16', 296, '2016-04-16 10:56:39', '2016-04-16 10:56:39', 'tidak'),
(6, 'RB1', 'Bahan Baju ', '300', 'Navy', 60, 'kjk', 'Yard', '2016-04-16', 296, '2016-04-16 11:01:01', '2016-04-16 11:01:01', 'tidak'),
(7, 'RB13 CB1', 'Wangky TC 20s 413821', '40 x 9', '', 100, '', 'KG', '2016-04-16', 296, '2016-04-16 12:45:10', '2016-04-16 12:45:10', 'ya'),
(8, 'HAHAHAH', 'deskri', '40 x 9', 'wanra', 120, 'sds', 'KG', '2016-04-16', 296, '2016-04-16 12:51:00', '2016-04-16 12:51:34', 'tidak'),
(9, 'HAHAHAH', 'deskri', '40 x 9', 'wanra', 30, 'sds', 'KG', '2016-04-16', 296, '2016-04-16 12:51:34', '2016-04-16 12:51:34', 'ya'),
(10, '', '', '', '', 130, '', 'KG', '2016-04-17', 296, '2016-04-17 16:08:35', '2016-04-17 16:09:21', 'tidak'),
(11, 'RA', 'Kancing ', '', 'merah', 10, 'klsnjd', 'PCS', '2016-04-17', 296, '2016-04-17 16:11:26', '2016-04-17 16:11:26', 'tidak'),
(12, 'RA', 'Kancing ', '', 'merah', 90, 'klsnjd', 'PCS', '2016-04-17', 296, '2016-04-17 16:11:26', '2016-04-17 16:11:26', 'tidak'),
(13, 'RJ MD01', 'Bahan Baju', '40 x 9', 'merah', 10, 'kbkj', 'KG', '2016-04-17', 296, '2016-04-17 16:13:35', '2016-04-17 16:14:20', 'tidak'),
(14, 'Coba', 'Tali', '100', 'merah', 500, 'ds', 'Yard', '2016-04-17', 296, '2016-04-17 16:20:47', '2016-04-17 16:21:49', 'tidak'),
(15, 'Coba', 'Tali', '100', 'merah', 100, 'ds', 'Yard', '2016-04-17', 296, '2016-04-17 16:21:49', '2016-04-17 16:21:49', 'ya');

-- --------------------------------------------------------

--
-- Struktur dari tabel `suplier`
--

CREATE TABLE IF NOT EXISTS `suplier` (
  `id_suplier` int(11) NOT NULL AUTO_INCREMENT,
  `nama_suplier` char(50) NOT NULL,
  `telepon_suplier` char(16) NOT NULL,
  `alamat_suplier` text NOT NULL,
  `keterangan_suplier` text NOT NULL,
  PRIMARY KEY (`id_suplier`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data untuk tabel `suplier`
--

INSERT INTO `suplier` (`id_suplier`, `nama_suplier`, `telepon_suplier`, `alamat_suplier`, `keterangan_suplier`) VALUES
(1, 'Suplier 1', '8789', 'nknhlkmh', 'jhklkh');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
