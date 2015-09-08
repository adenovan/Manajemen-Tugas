-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Inang: 127.0.0.1
-- Waktu pembuatan: 08 Sep 2015 pada 04.42
-- Versi Server: 5.5.27-log
-- Versi PHP: 5.4.7

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Basis data: `db_tugas`
--
CREATE DATABASE `db_tugas` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `db_tugas`;

-- --------------------------------------------------------

--
-- Struktur dari tabel `aksi`
--

CREATE TABLE IF NOT EXISTS `aksi` (
  `aksi_id` int(11) NOT NULL AUTO_INCREMENT,
  `karyawan_id` int(11) NOT NULL,
  `link` text NOT NULL,
  `isi` text NOT NULL,
  `waktu` datetime NOT NULL,
  `dibaca` int(11) NOT NULL,
  PRIMARY KEY (`aksi_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=15 ;

-- --------------------------------------------------------

--
-- Struktur dari tabel `karyawan`
--

CREATE TABLE IF NOT EXISTS `karyawan` (
  `karyawan_id` int(11) NOT NULL AUTO_INCREMENT,
  `nama_karyawan` varchar(100) NOT NULL,
  `foto_karyawan` varchar(150) DEFAULT '/img/default.png',
  `jabatan_karyawan` varchar(100) NOT NULL,
  `username` text NOT NULL,
  `password` text NOT NULL,
  PRIMARY KEY (`karyawan_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

-- --------------------------------------------------------

--
-- Struktur dari tabel `komentar`
--

CREATE TABLE IF NOT EXISTS `komentar` (
  `komentar_id` int(11) NOT NULL AUTO_INCREMENT,
  `karyawan_id` int(11) DEFAULT NULL,
  `tugas_id` int(11) DEFAULT NULL,
  `komentar` text NOT NULL,
  `waktu` datetime NOT NULL,
  PRIMARY KEY (`komentar_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

-- --------------------------------------------------------

--
-- Struktur dari tabel `notifikasi`
--

CREATE TABLE IF NOT EXISTS `notifikasi` (
  `notif_id` int(11) NOT NULL AUTO_INCREMENT,
  `karyawan_id` int(11) NOT NULL,
  `karyawan_oleh` int(11) NOT NULL,
  `link` text NOT NULL,
  `isi` text NOT NULL,
  `waktu` datetime NOT NULL,
  `dibaca` int(11) NOT NULL,
  PRIMARY KEY (`notif_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=15 ;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tugas`
--

CREATE TABLE IF NOT EXISTS `tugas` (
  `tugas_id` int(11) NOT NULL AUTO_INCREMENT,
  `tugas` text NOT NULL,
  `tags` text NOT NULL,
  `karyawan_id` int(11) NOT NULL,
  `karyawan_untuk` int(11) NOT NULL,
  `lokasi` text NOT NULL,
  `tanggal_penugasan` datetime NOT NULL,
  `batas_waktu` datetime NOT NULL,
  `tanggal_penyerahan` datetime DEFAULT NULL,
  `status` int(11) NOT NULL,
  `deskripsi_tugas` text NOT NULL,
  PRIMARY KEY (`tugas_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
