-- phpMyAdmin SQL Dump
-- version 3.4.9
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: May 18, 2025 at 02:30 PM
-- Server version: 5.5.20
-- PHP Version: 5.3.10

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `hamburgerto`
--

-- --------------------------------------------------------

--
-- Table structure for table `chitietdonhang`
--

CREATE TABLE IF NOT EXISTS `chitietdonhang` (
  `MaCTDH` int(11) NOT NULL AUTO_INCREMENT,
  `MaDonHang` int(11) NOT NULL,
  `MaMonAn` int(11) NOT NULL,
  `SoLuong` int(11) NOT NULL,
  `DonGia` decimal(12,2) NOT NULL,
  PRIMARY KEY (`MaCTDH`),
  KEY `MaDonHang` (`MaDonHang`),
  KEY `MaMonAn` (`MaMonAn`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `chitietdonhang`
--

INSERT INTO `chitietdonhang` (`MaCTDH`, `MaDonHang`, `MaMonAn`, `SoLuong`, `DonGia`) VALUES
(1, 1, 10, 2, '56000.00'),
(2, 1, 2, 4, '30000.00'),
(3, 1, 1, 8, '50000.00'),
(4, 1, 4, 8, '30000.00'),
(5, 2, 25, 2, '30000.00'),
(6, 2, 21, 4, '25000.00'),
(7, 2, 1, 1, '50000.00');

-- --------------------------------------------------------

--
-- Table structure for table `danhsach`
--

CREATE TABLE IF NOT EXISTS `danhsach` (
  `MaMonAn` int(10) NOT NULL AUTO_INCREMENT,
  `PhanLoaiMon` varchar(50) CHARACTER SET utf8 NOT NULL,
  `TenMonAn` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `Gia` float NOT NULL,
  `SoLuong` int(11) NOT NULL,
  `AnhMonAn` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`MaMonAn`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=27 ;

--
-- Dumping data for table `danhsach`
--

INSERT INTO `danhsach` (`MaMonAn`, `PhanLoaiMon`, `TenMonAn`, `Gia`, `SoLuong`, `AnhMonAn`) VALUES
(1, 'hamburger', 'Hamburger gà 2 tầng', 50000, 123, 'images/humbergerga2.jpg'),
(2, 'hamburger', 'Hamburger bò', 30000, 4, 'images/humbergerbo.jpg'),
(3, 'hamburger', 'Hamburger bò + khoai tây', 95000, 6, 'images/humbergerbotay.jpg'),
(4, 'hamburger', 'Hamburger phô mai', 30000, 8, 'images/hambergerpm.jpg'),
(5, 'hamburger', 'Impossible 2 tầng', 105000, 10, 'images/impossible1.jpg'),
(6, 'hamburger', 'Impossible bò phô mai', 106000, 250, 'images/impossible2.jpg'),
(7, 'hamburger', 'Impossible bò khoai tây', 100000, 10, 'images/impossible3.jpg'),
(8, 'hamburger', 'Impossible ngược', 120000, 0, 'images/impossible4.jpg'),
(9, 'hamburger', 'Hamburger gà rán', 45000, 2, 'images/garan.jpg'),
(10, 'hamburger', 'Hamburger ức gà', 56000, 10, 'images/ucga.jpg'),
(11, 'hamburger', 'Hamburger chay', 20000, 10, 'images/hambergerchay.jpg'),
(12, 'hamburger', 'Hamburger thập cẩm', 35000, 3, 'images/HAMBURGER THAP CAM.png'),
(15, 'hamburger', 'Hamburger thập cẩm ( Bigsize )', 35000, 3, 'images/HAMBURGER THAP CAM.png'),
(16, 'douong', 'Trà sữa trân trâu', 20000, 100, 'images/TraSuaTranChau.png'),
(17, 'douong', 'Trà chanh', 18000, 100, 'images/TraChanh.png'),
(20, 'douong', 'Matcha Latte', 25000, 100, 'images/matchaLate.png'),
(21, 'douong', 'Trà thái nâu', 25000, 100, 'images/TraThaiNau.png'),
(22, 'cacmonkhac', 'Xúc xích nướng', 22000, 100, 'images/XucXichNuong.png'),
(23, 'cacmonkhac', 'Khoai chiên', 18000, 3, 'images/KhoaiChien.png'),
(24, 'cacmonkhac', 'Hot Dog', 19000, 100, 'images/hotdog.png'),
(25, 'cacmonkhac', 'Mì cay', 30000, 100, 'images/micay.png'),
(26, '', 'Shiba', 100000, 100, 'images/shiba_dog.png');

-- --------------------------------------------------------

--
-- Table structure for table `donhang`
--

CREATE TABLE IF NOT EXISTS `donhang` (
  `MaDonHang` int(11) NOT NULL AUTO_INCREMENT,
  `MaNguoiDung` int(11) NOT NULL,
  `NgayDatHang` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `TrangThai` enum('Chưa Xử Lý','Đang Xử Lý','Đã Hoàn Thành') NOT NULL DEFAULT 'Chưa Xử Lý',
  `TongTien` decimal(12,2) NOT NULL,
  PRIMARY KEY (`MaDonHang`),
  KEY `MaNguoiDung` (`MaNguoiDung`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `donhang`
--

INSERT INTO `donhang` (`MaDonHang`, `MaNguoiDung`, `NgayDatHang`, `TrangThai`, `TongTien`) VALUES
(1, 7, '2025-05-18 13:07:53', 'Chưa Xử Lý', '872000.00'),
(2, 7, '2025-05-18 13:44:16', 'Đã Hoàn Thành', '210000.00');

-- --------------------------------------------------------

--
-- Table structure for table `giohang`
--

CREATE TABLE IF NOT EXISTS `giohang` (
  `MaGio` int(11) NOT NULL AUTO_INCREMENT,
  `MaNguoiDung` int(11) NOT NULL,
  `MaMonAn` int(11) DEFAULT NULL,
  `TenMon` text COLLATE utf8_unicode_ci,
  `SoLuong` int(11) DEFAULT NULL,
  `Gia` int(11) DEFAULT NULL,
  `Anh` text COLLATE utf8_unicode_ci,
  PRIMARY KEY (`MaGio`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=62 ;

--
-- Dumping data for table `giohang`
--

INSERT INTO `giohang` (`MaGio`, `MaNguoiDung`, `MaMonAn`, `TenMon`, `SoLuong`, `Gia`, `Anh`) VALUES
(14, 17, 4, 'Hamburger gà 2 tầng', 150, 50000, 'images/humbergerga2.jpg'),
(15, 17, 5, 'Hamburger bò', 200, 30000, 'images/humbergerbo.jpg'),
(17, 5, 2, 'Hamburger bò + khoai tây', 10, 95000, 'images/humbergerbotay.jpg'),
(19, 83, 1, 'Impossible 2 tầng', 10, 105000, 'images/impossible1.jpg'),
(22, 4, 2, 'Hamburger gà rán', 10, 45000, 'images/garan.jpg'),
(27, 2, 3, 'Hamburger bò + khoai tây', 2, 95000, 'images/humbergerbotay.jpg'),
(28, 20, 1, 'Hamburger gà 2 tầng', 1, 50000, 'images/humbergerga2.jpg'),
(29, 20, 2, 'Hamburger bò', 1, 30000, 'images/humbergerbo.jpg'),
(30, 1, 1, 'Hamburger gà 2 tầng', 1, 50000, 'images/humbergerga2.jpg'),
(31, 1, 2, 'Hamburger bò', 1, 30000, 'images/humbergerbo.jpg'),
(57, 9, 5, 'Impossible 2 tầng', 1, 105000, 'images/impossible1.jpg'),
(58, 9, 2, 'Hamburger bò', 1, 30000, 'images/humbergerbo.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `hotro`
--

CREATE TABLE IF NOT EXISTS `hotro` (
  `MaHoTro` int(11) NOT NULL AUTO_INCREMENT,
  `MaND` int(11) NOT NULL,
  `TieuDe` varchar(200) NOT NULL,
  `NoiDung` text NOT NULL,
  `NgayGui` datetime NOT NULL,
  `TrangThai` enum('Chưa Xử Lý','Đang Xử Lý','Đã Hoàn Thành') NOT NULL DEFAULT 'Chưa Xử Lý',
  PRIMARY KEY (`MaHoTro`),
  KEY `MaND` (`MaND`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `hotro`
--

INSERT INTO `hotro` (`MaHoTro`, `MaND`, `TieuDe`, `NoiDung`, `NgayGui`, `TrangThai`) VALUES
(1, 7, 'Tôi hết tiền', 'Hướng dẫn tôi kiếm tiền', '2025-05-17 19:58:25', 'Chưa Xử Lý'),
(2, 7, 'aaaaaa', 'Tôi bị đau bụng', '2025-05-17 20:11:00', 'Đã Hoàn Thành');

-- --------------------------------------------------------

--
-- Table structure for table `nguoidung`
--

CREATE TABLE IF NOT EXISTS `nguoidung` (
  `MaNguoiDung` int(10) NOT NULL AUTO_INCREMENT,
  `QuyenHan` int(1) NOT NULL,
  `TenNguoiDung` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `TenDangNhap` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `MatKhau` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `DiaChi` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`MaNguoiDung`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=11 ;

--
-- Dumping data for table `nguoidung`
--

INSERT INTO `nguoidung` (`MaNguoiDung`, `QuyenHan`, `TenNguoiDung`, `TenDangNhap`, `MatKhau`, `DiaChi`) VALUES
(1, 1, 'Trần Nguyễn Minh Thiên', 'tnmt', 'dbceb2333cc28c1038da113ade53fa53', 'Long Xuyên, An Giang'),
(2, 0, 'Lê Hiệp Nguyên', 'lhn', 'cafa3a1f553f1181506e4678a0342fb3', 'Long Xuyên, An Giang'),
(3, 1, 'Bùi Sơn Thái', 'bst', '2a60352d7d5f7a58519abe2a737b42ab', 'Long Xuyên, An Giang'),
(4, 1, 'Đào Duy Thành', 'ddt', 'd836a85fa1c22c57023ac28b8f992ffa', 'Long Xuyên, An Giang'),
(7, 1, 'Nguyễn Hồng Thanh Toàn HaHa', 'nhtt', 'e10adc3949ba59abbe56e057f20f883e', 'An Giang'),
(8, 0, 'Trần Minh Mèo Mèo', 'meo', 'c4ca4238a0b923820dcc509a6f75849b', 'Trường An, Trung Quốc'),
(9, 1, 'Tuong', 'npt', '8e296a067a37563370ded05f5a3bf3ec', 'long xuyen'),
(10, 0, 'Trần Văn T', 'tvt', 'e10adc3949ba59abbe56e057f20f883e', 'Giang Nam, Triết Giang');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `chitietdonhang`
--
ALTER TABLE `chitietdonhang`
  ADD CONSTRAINT `chitietdonhang_ibfk_1` FOREIGN KEY (`MaDonHang`) REFERENCES `donhang` (`MaDonHang`),
  ADD CONSTRAINT `chitietdonhang_ibfk_2` FOREIGN KEY (`MaMonAn`) REFERENCES `danhsach` (`MaMonAn`);

--
-- Constraints for table `donhang`
--
ALTER TABLE `donhang`
  ADD CONSTRAINT `donhang_ibfk_1` FOREIGN KEY (`MaNguoiDung`) REFERENCES `nguoidung` (`MaNguoiDung`);

--
-- Constraints for table `hotro`
--
ALTER TABLE `hotro`
  ADD CONSTRAINT `hotro_ibfk_1` FOREIGN KEY (`MaND`) REFERENCES `nguoidung` (`MaNguoiDung`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
