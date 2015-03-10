-- phpMyAdmin SQL Dump
-- version 4.0.9
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Oct 30, 2014 at 12:30 PM
-- Server version: 5.5.34
-- PHP Version: 5.4.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `craft`
--

-- --------------------------------------------------------

--
-- Table structure for table `bahan`
--

CREATE TABLE IF NOT EXISTS `bahan` (
  `id_bahan` int(3) NOT NULL AUTO_INCREMENT,
  `id_kategori` int(3) NOT NULL,
  `nama_bahan` varchar(50) NOT NULL,
  PRIMARY KEY (`id_bahan`),
  UNIQUE KEY `nama_bahan` (`nama_bahan`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `bahan`
--

INSERT INTO `bahan` (`id_bahan`, `id_kategori`, `nama_bahan`) VALUES
(1, 1, 'Btu'),
(2, 2, 'nn');

-- --------------------------------------------------------

--
-- Table structure for table `banner`
--

CREATE TABLE IF NOT EXISTS `banner` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `perusahaan` int(11) NOT NULL,
  `posisi` int(2) NOT NULL,
  `tgl_aktif` date NOT NULL,
  `tgl_habis` date NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `iklan`
--

CREATE TABLE IF NOT EXISTS `iklan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `judul_iklan` varchar(100) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_usaha` int(11) NOT NULL,
  `kategori` int(11) NOT NULL,
  `subkategori` int(11) NOT NULL,
  `bahan` int(15) NOT NULL,
  `harga` int(11) NOT NULL,
  `satuan` int(11) NOT NULL,
  `deskripsi` varchar(100) NOT NULL,
  `minimum_order` int(11) NOT NULL,
  `tanggal_pasang` datetime NOT NULL,
  `status` tinyint(2) NOT NULL DEFAULT '0',
  `foto_1` varchar(50) DEFAULT NULL,
  `foto_2` varchar(50) DEFAULT NULL,
  `foto_3` varchar(50) DEFAULT NULL,
  `foto_4` varchar(50) DEFAULT NULL,
  `foto_5` varchar(50) DEFAULT NULL,
  `foto_6` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=54 ;

--
-- Dumping data for table `iklan`
--

INSERT INTO `iklan` (`id`, `judul_iklan`, `id_user`, `id_usaha`, `kategori`, `subkategori`, `bahan`, `harga`, `satuan`, `deskripsi`, `minimum_order`, `tanggal_pasang`, `status`, `foto_1`, `foto_2`, `foto_3`, `foto_4`, `foto_5`, `foto_6`) VALUES
(52, 'test iklan', 134, 40, 3, 2, 0, 2143254235, 0, '35456b tyhjyjhyjhytyt', 0, '2014-10-20 17:20:31', 0, '5801-daaa.jpg', '', '', '', '', ''),
(53, 'test produk distribytor', 137, 43, 5, 1, 0, 1243455467, 0, 'frregreg bgtfhbt', 0, '2014-10-27 09:49:22', 0, '4002-dsfsd.jpg', '4002-dsfsd.jpg', '', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `kategori`
--

CREATE TABLE IF NOT EXISTS `kategori` (
  `id_kategori` int(5) NOT NULL AUTO_INCREMENT,
  `nama_kategori` varchar(50) DEFAULT NULL,
  `foto` varchar(50) NOT NULL,
  PRIMARY KEY (`id_kategori`),
  UNIQUE KEY `nama_kategori` (`nama_kategori`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `kategori`
--

INSERT INTO `kategori` (`id_kategori`, `nama_kategori`, `foto`) VALUES
(1, 'Tas', '-'),
(2, 'Kalung', '-'),
(3, 'Sepatu', ''),
(4, 'Patung', ''),
(5, 'Lukisan', ''),
(6, 'Ukiran', ''),
(7, 'Hisn', '');

-- --------------------------------------------------------

--
-- Table structure for table `kerja_sama`
--

CREATE TABLE IF NOT EXISTS `kerja_sama` (
  `id_kerjasama` int(15) NOT NULL AUTO_INCREMENT,
  `perusahaan` int(15) NOT NULL,
  `judul` varchar(50) NOT NULL,
  `deskripsi` varchar(400) NOT NULL,
  `dtcreate` datetime NOT NULL,
  `deadline` datetime NOT NULL,
  `foto_1` varchar(50) NOT NULL,
  `foto_2` varchar(50) NOT NULL,
  PRIMARY KEY (`id_kerjasama`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `kerja_sama`
--

INSERT INTO `kerja_sama` (`id_kerjasama`, `perusahaan`, `judul`, `deskripsi`, `dtcreate`, `deadline`, `foto_1`, `foto_2`) VALUES
(1, 43, 'Test Kerja Sama', 'ini testing aja', '2014-10-27 11:31:06', '2014-10-08 00:00:00', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `komentar`
--

CREATE TABLE IF NOT EXISTS `komentar` (
  `id_komentar` int(11) NOT NULL AUTO_INCREMENT,
  `id_iklan` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `isi` int(100) NOT NULL,
  PRIMARY KEY (`id_komentar`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `kota`
--

CREATE TABLE IF NOT EXISTS `kota` (
  `id_kota` int(6) NOT NULL AUTO_INCREMENT,
  `id_provinsi` int(2) NOT NULL,
  `nama_kota` varchar(100) NOT NULL,
  PRIMARY KEY (`id_kota`),
  UNIQUE KEY `nama_kota` (`nama_kota`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `kota`
--

INSERT INTO `kota` (`id_kota`, `id_provinsi`, `nama_kota`) VALUES
(1, 1, 'Banjarnegara'),
(2, 2, 'Surabaya'),
(3, 1, 'Boyolali'),
(5, 2, 'Ponorogo'),
(6, 1, 'Solo'),
(7, 1, '"Kudus');

-- --------------------------------------------------------

--
-- Table structure for table `membership`
--

CREATE TABLE IF NOT EXISTS `membership` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `jenis_paket` int(11) NOT NULL,
  `tgl_aktif` date NOT NULL,
  `tgl_habis` date NOT NULL,
  `user` int(11) NOT NULL,
  `status` int(1) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `message`
--

CREATE TABLE IF NOT EXISTS `message` (
  `id_message` int(11) NOT NULL AUTO_INCREMENT,
  `id_penerima` int(11) NOT NULL,
  `email_pengirim` varchar(50) NOT NULL,
  `telepon_pengirim` int(15) NOT NULL,
  `judul` varchar(100) NOT NULL,
  `isi` varchar(500) NOT NULL,
  `tgl_masuk` datetime NOT NULL,
  `status` int(1) NOT NULL,
  PRIMARY KEY (`id_message`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `pembelian`
--

CREATE TABLE IF NOT EXISTS `pembelian` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `perusahaan` int(11) NOT NULL,
  `judul` varchar(100) NOT NULL,
  `deskripsi` varchar(400) NOT NULL,
  `jumlah` int(11) NOT NULL,
  `satuan` int(3) NOT NULL,
  `status` int(1) NOT NULL,
  `tanggal_pasang` date NOT NULL,
  `tgl_expired` date NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `pembelian`
--

INSERT INTO `pembelian` (`id`, `perusahaan`, `judul`, `deskripsi`, `jumlah`, `satuan`, `status`, `tanggal_pasang`, `tgl_expired`) VALUES
(1, 40, 'testing tanggal', 'ferfgwreg vrgre vrfgvrf', 100, 1, 1, '2014-10-21', '2014-10-29');

-- --------------------------------------------------------

--
-- Table structure for table `perusahaan`
--

CREATE TABLE IF NOT EXISTS `perusahaan` (
  `id_usaha` int(20) NOT NULL AUTO_INCREMENT,
  `user` int(10) NOT NULL,
  `nama_usaha` varchar(100) NOT NULL,
  `paket` int(1) NOT NULL DEFAULT '1',
  `tipe` int(1) NOT NULL,
  `kategori` int(10) NOT NULL,
  `deskripsi` varchar(400) NOT NULL,
  `subkategori` int(11) DEFAULT NULL,
  `alamat` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `telepon` int(15) NOT NULL,
  `provinsi` int(3) DEFAULT NULL,
  `kabupaten` int(2) NOT NULL,
  `website` varchar(30) NOT NULL,
  `kontak_lain` varchar(100) DEFAULT NULL,
  `tanggal_daftar` datetime NOT NULL,
  `filename_1` varchar(150) NOT NULL,
  `filename_2` varchar(150) NOT NULL,
  `filename_3` varchar(150) NOT NULL,
  `filename_4` varchar(150) NOT NULL,
  `status` int(1) NOT NULL,
  `jenis` int(1) NOT NULL,
  PRIMARY KEY (`id_usaha`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=44 ;

--
-- Dumping data for table `perusahaan`
--

INSERT INTO `perusahaan` (`id_usaha`, `user`, `nama_usaha`, `paket`, `tipe`, `kategori`, `deskripsi`, `subkategori`, `alamat`, `email`, `telepon`, `provinsi`, `kabupaten`, `website`, `kontak_lain`, `tanggal_daftar`, `filename_1`, `filename_2`, `filename_3`, `filename_4`, `status`, `jenis`) VALUES
(40, 134, 'pt test indonesia', 1, 0, 3, '9ini test perusahaan aja', 3, 'jalan abc no 18 demak', '', 2147483647, 1, 7, '', '', '2014-10-20 17:15:30', 'kosong', '', '', '', 0, 1),
(41, 135, 'Test kabupatenyhjyjhyy', 1, 0, 3, 'tybh6yhy yhy6jhy6 hy6hy677hj5', 3, 'h6yj6u uyjhuy6juy y', '', 65787899, 1, 6, '', NULL, '2014-10-20 17:32:02', '6033-', '', '', '', 0, 1),
(42, 136, 'testkabu[paten3hji', 1, 1, 3, 'rfgrehb  brtghjrtjhu bgfrhrt', 4, 'rtyhte ghrtuhrth  trhtr', '', 2147483647, 1, 6, '', NULL, '2014-10-20 17:37:14', 'kosong', '', '', '', 0, 1),
(43, 137, 'test kategori nhtjmnhujkyu', 1, 1, 5, 'ewgfregreger fbfbhtf gbfhb', 1, 'tfrhtrh  gjnyhjytj', '', 2147483647, 1, 1, '', NULL, '2014-10-27 09:47:52', '', '', '', '', 0, 2);

-- --------------------------------------------------------

--
-- Table structure for table `pesan`
--

CREATE TABLE IF NOT EXISTS `pesan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama_pengirim` varchar(50) NOT NULL,
  `email_pengirim` varchar(50) NOT NULL,
  `no_telepon` varchar(14) NOT NULL,
  `judul` varchar(50) NOT NULL,
  `isi` varchar(200) NOT NULL,
  `tgl_masuk` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `provinsi`
--

CREATE TABLE IF NOT EXISTS `provinsi` (
  `id_provinsi` int(2) NOT NULL AUTO_INCREMENT,
  `nama_provinsi` varchar(100) NOT NULL,
  PRIMARY KEY (`id_provinsi`),
  UNIQUE KEY `nama_provinsi` (`nama_provinsi`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `provinsi`
--

INSERT INTO `provinsi` (`id_provinsi`, `nama_provinsi`) VALUES
(1, 'Jawa Tengah'),
(2, 'Jawa Timur'),
(3, 'Jawa Barat'),
(4, 'Bengkulu'),
(5, 'NTB'),
(6, 'Jakarta');

-- --------------------------------------------------------

--
-- Table structure for table `satuan`
--

CREATE TABLE IF NOT EXISTS `satuan` (
  `id_satuan` int(3) NOT NULL AUTO_INCREMENT,
  `nama_satuan` varchar(50) NOT NULL,
  PRIMARY KEY (`id_satuan`),
  UNIQUE KEY `id_satuan` (`id_satuan`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `satuan`
--

INSERT INTO `satuan` (`id_satuan`, `nama_satuan`) VALUES
(1, 'box'),
(2, 'pieces');

-- --------------------------------------------------------

--
-- Table structure for table `subkategori`
--

CREATE TABLE IF NOT EXISTS `subkategori` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_kategori` int(11) NOT NULL,
  `subkategori` varchar(85) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `subkategori`
--

INSERT INTO `subkategori` (`id`, `id_kategori`, `subkategori`) VALUES
(1, 5, 'kalung abcd'),
(2, 3, 'cwdfwef'),
(3, 3, 'Kulit'),
(4, 3, 'van tofel');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(25) NOT NULL,
  `password` varchar(100) NOT NULL,
  `aktivasi` varchar(50) NOT NULL,
  `level` int(1) NOT NULL,
  `status` int(1) NOT NULL DEFAULT '1',
  `tipe` int(1) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `telepon` varchar(15) NOT NULL,
  `tanggal_lahir` date NOT NULL,
  `alamat` varchar(100) NOT NULL,
  `provinsi` int(3) NOT NULL,
  `kota` int(3) NOT NULL,
  `email` varchar(50) NOT NULL,
  `tanggal_daftar` datetime NOT NULL,
  `foto` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`,`email`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=138 ;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `password`, `aktivasi`, `level`, `status`, `tipe`, `nama`, `telepon`, `tanggal_lahir`, `alamat`, `provinsi`, `kota`, `email`, `tanggal_daftar`, `foto`) VALUES
(134, 'usertest', 'e10adc3949ba59abbe56e057f20f883e', '1aa0265f152b53896e08ccd2e1f75f17', 0, 1, 0, 'usertest', '', '0000-00-00', '', 0, 0, 'chsetdffiodnfo919@gmail.com', '2014-10-20 17:15:30', ''),
(135, '5465789', '25d55ad283aa400af464c76d713c07ad', '99c7b00720ac9a8b3efcd205ac60db5e', 0, 1, 0, 'tetkab', '', '0000-00-00', '', 0, 0, 'chsetdffiojdnfo919@gmail.com', '2014-10-20 17:32:02', ''),
(136, 'srfewgrgvb', 'e10adc3949ba59abbe56e057f20f883e', 'dba9770c657b8e3d1e69680dc937d234', 0, 1, 0, 'test3', '', '0000-00-00', '', 0, 0, 'fgr@gmail.com', '2014-10-20 17:37:14', ''),
(137, 'chsetiono', 'e10adc3949ba59abbe56e057f20f883e', '640c8382c409c1b2b5e03ef47dc4b611', 1, 1, 1, 'ceksederhana', '', '0000-00-00', '', 0, 0, 'nhnffo919@gmail.com', '2014-10-27 09:47:52', '');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
