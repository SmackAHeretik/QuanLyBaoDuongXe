-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 07, 2025 at 01:20 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `quanlybaoduongxe`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `AdminID` int(11) NOT NULL,
  `username` varchar(45) DEFAULT NULL,
  `password` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`AdminID`, `username`, `password`) VALUES
(1, 'huy@gmail.com', '123');

-- --------------------------------------------------------

--
-- Table structure for table `chitiethoadon`
--

CREATE TABLE `chitiethoadon` (
  `MaCTHD` int(11) NOT NULL,
  `MaSP` int(11) DEFAULT NULL,
  `GiaTien` decimal(10,2) DEFAULT NULL,
  `SoLuong` int(11) DEFAULT NULL,
  `NgayBDBH` datetime DEFAULT NULL,
  `NgayKTBH` datetime DEFAULT NULL,
  `SoLanDaBaoHanh` int(11) DEFAULT NULL,
  `hoadon_MaHD` int(11) DEFAULT NULL,
  `phutungxemay_MaSP` int(11) DEFAULT NULL,
  `dichvu_MaDV` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `chitiethoadon`
--

INSERT INTO `chitiethoadon` (`MaCTHD`, `MaSP`, `GiaTien`, `SoLuong`, `NgayBDBH`, `NgayKTBH`, `SoLanDaBaoHanh`, `hoadon_MaHD`, `phutungxemay_MaSP`, `dichvu_MaDV`) VALUES
(25, NULL, 2300000.00, 2, '2025-06-18 09:00:00', '2025-12-18 09:00:00', 0, 1, 13, 1),
(26, NULL, 3200000.00, 1, '2025-06-02 10:00:00', '2025-12-02 10:00:00', 1, 2, 14, 2),
(27, NULL, 1400000.00, 3, '2025-06-03 11:00:00', '2025-12-03 11:00:00', 0, 3, 15, 3),
(28, NULL, 1900000.00, 1, '2025-06-04 14:00:00', '2025-12-04 14:00:00', 2, 4, 16, 2),
(29, NULL, 3600000.00, 2, '2025-06-05 15:00:00', '2025-12-05 15:00:00', 1, 5, 17, 1),
(30, NULL, 1800000.00, 1, '2025-06-06 08:00:00', '2025-12-06 08:00:00', 0, 6, 13, 3),
(31, NULL, 2300000.00, 2, '2025-06-18 11:00:00', '2025-12-18 11:00:00', 1, 1, 15, 2),
(32, NULL, 3200000.00, 1, '2025-06-02 08:00:00', '2025-12-02 08:00:00', 0, 2, 15, 2),
(33, NULL, 100000.00, 1, NULL, NULL, NULL, 18, 14, NULL),
(34, NULL, 70000.00, 1, NULL, NULL, NULL, 18, 15, NULL),
(35, NULL, 100000.00, 2, NULL, NULL, NULL, 19, 14, NULL),
(36, NULL, 30000.00, 1, NULL, NULL, NULL, 19, 13, NULL),
(37, NULL, 90000.00, 1, NULL, NULL, NULL, 19, 17, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `dichvu`
--

CREATE TABLE `dichvu` (
  `MaDV` int(11) NOT NULL,
  `TenDV` varchar(100) DEFAULT NULL,
  `HinhAnh` text DEFAULT NULL,
  `DonGia` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `dichvu`
--

INSERT INTO `dichvu` (`MaDV`, `TenDV`, `HinhAnh`, `DonGia`) VALUES
(1, 'Rửa xe', 'uploads/dv_68526e01d7a5e.png', 20000.00),
(2, 'Thay nhớt', 'uploads/dv_68526dd44bcb2.png', 50000.00),
(3, 'Bảo dưỡng phanh', 'uploads/dv_68526dc93ba23.png', 30000.00),
(4, 'test', 'uploads/dv_68526e1752ad5.png', 99999999.99);

-- --------------------------------------------------------

--
-- Table structure for table `hoadon`
--

CREATE TABLE `hoadon` (
  `MaHD` int(11) NOT NULL,
  `TongTien` decimal(10,2) DEFAULT NULL,
  `Ngay` date DEFAULT NULL,
  `TrangThai` enum('cho_thanh_toan','da_thanh_toan','huy') DEFAULT NULL,
  `xemay_MaXE` int(11) DEFAULT NULL,
  `phutungxemay_MaSP` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `hoadon`
--

INSERT INTO `hoadon` (`MaHD`, `TongTien`, `Ngay`, `TrangThai`, `xemay_MaXE`, `phutungxemay_MaSP`) VALUES
(1, 2500000.00, '2025-06-18', 'huy', NULL, 0),
(2, 3200000.00, '2025-06-02', 'huy', NULL, 0),
(3, 1500000.00, '2025-06-03', 'da_thanh_toan', NULL, 0),
(4, 2100000.00, '2025-06-04', 'huy', NULL, 0),
(5, 3900000.00, '2025-06-05', 'da_thanh_toan', NULL, 0),
(6, 1800000.00, '2025-06-06', 'cho_thanh_toan', NULL, 0),
(7, 2750000.00, '2025-06-07', 'da_thanh_toan', NULL, 0),
(8, 1900000.00, '2025-06-08', 'huy', NULL, 0),
(9, 5000000.00, '2025-06-09', 'da_thanh_toan', NULL, 0),
(10, 2100000.00, '2025-06-10', 'cho_thanh_toan', NULL, 0),
(11, 2000000.00, '2025-06-18', 'cho_thanh_toan', NULL, 0),
(12, 300000.00, '2025-06-18', 'huy', NULL, 0),
(13, 70000.00, '2025-06-22', 'cho_thanh_toan', NULL, 15),
(14, 30000.00, '2025-06-22', 'cho_thanh_toan', NULL, 13),
(15, 60000.00, '2025-06-22', 'cho_thanh_toan', NULL, 13),
(16, 30000.00, '2025-06-22', 'cho_thanh_toan', 9, 13),
(17, 30000.00, '2025-06-27', 'cho_thanh_toan', 8, 13),
(18, 170000.00, '2025-06-27', 'cho_thanh_toan', 8, 0),
(19, 320000.00, '2025-06-27', 'cho_thanh_toan', 8, 0);

-- --------------------------------------------------------

--
-- Table structure for table `khachhang`
--

CREATE TABLE `khachhang` (
  `MaKH` int(11) NOT NULL,
  `TenKH` varchar(100) DEFAULT NULL,
  `Email` varchar(30) DEFAULT NULL,
  `MatKhau` varchar(255) DEFAULT NULL,
  `DiaChi` text DEFAULT NULL,
  `SDT` varchar(10) DEFAULT NULL,
  `TrangThai` enum('hoat_dong','bi_khoa') DEFAULT NULL,
  `Reset_token` text DEFAULT NULL,
  `admin_AdminID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `khachhang`
--

INSERT INTO `khachhang` (`MaKH`, `TenKH`, `Email`, `MatKhau`, `DiaChi`, `SDT`, `TrangThai`, `Reset_token`, `admin_AdminID`) VALUES
(1, 'truong vinh khang', 'khang@gmail.com', '$2y$10$T0JL6NSGE15w7M3wZe9PRuAPjXQvfJ4G0FyfzA/bxednx5mf7MC/G', NULL, '123456789', NULL, NULL, NULL),
(2, 'huyadmin', 'huy@gmail.com', '$2y$10$jnZ4Hfbq9bmW8kknzxETUevh5U5qX0jV7.WAvh2P2iD00xChmpk2e', NULL, '1213123123', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `lichhen`
--

CREATE TABLE `lichhen` (
  `MaLH` int(11) NOT NULL,
  `TenXe` varchar(255) NOT NULL,
  `LoaiXe` varchar(100) NOT NULL,
  `PhanKhuc` varchar(100) NOT NULL,
  `MoTaLyDo` text NOT NULL,
  `nhanvien_MaNV` int(11) NOT NULL,
  `NgayHen` date NOT NULL,
  `ThoiGianCa` varchar(255) NOT NULL,
  `PhanLoai` int(11) DEFAULT 0,
  `TrangThai` varchar(50) NOT NULL DEFAULT 'cho duyet',
  `xemay_MaXE` int(11) NOT NULL,
  `khachhang_MaKH` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `lichhen`
--

INSERT INTO `lichhen` (`MaLH`, `TenXe`, `LoaiXe`, `PhanKhuc`, `MoTaLyDo`, `nhanvien_MaNV`, `NgayHen`, `ThoiGianCa`, `PhanLoai`, `TrangThai`, `xemay_MaXE`, `khachhang_MaKH`) VALUES
(1, 'Honda Air Blade', 'Tay ga', 'Phổ thông', 'bảo dưỡng', 3, '2025-06-22', '09:00-10:00', 0, 'cho duyet', 1, 1),
(2, 'Honda Air Blade', 'Tay ga', 'Phổ thông', 'bảo hành định kỳ', 2, '2025-06-22', '09:00-10:00', 1, 'cho duyet', 1, 1),
(5, 'Honda Air Blade', 'Tay ga', 'Phổ thông', 'test lần 1 ra C', 11, '2025-06-22', '09:00-10:00', 1, 'cho duyet', 1, 1),
(6, 'Honda Air Blade', 'Tay ga', 'Phổ thông', 'test lần 2 ra C', 11, '2025-06-22', '09:00-10:00', 1, 'cho duyet', 1, 1),
(7, 'Honda Air Blade', 'Tay ga', 'Phổ thông', 'test bảo hành lần 1 ra A', 9, '2025-06-22', '09:00-10:00', 1, 'cho duyet', 1, 1),
(8, 'Honda Air Blade', 'Tay ga', 'Phổ thông', 'test bảo hành lần 2 ra D', 12, '2025-06-22', '09:00-10:00', 1, 'cho duyet', 1, 1),
(9, 'Honda Air Blade', 'Tay ga', 'Phổ thông', 'test lịch hẹn lần 1 ra D', 10, '2025-06-22', '09:00-10:00', 0, 'cho duyet', 1, 1),
(10, 'Honda Air Blade', 'Tay ga', 'Phổ thông', 'test lịch hẹn lần 2 ra E', 13, '2025-06-22', '09:00-10:00', 0, 'cho duyet', 1, 1),
(11, 'HonDa T2', 'Tay Cônn', 'Cao Cấpp', 'khách yêu cầu đặt', 3, '2025-06-23', '8h-9h', 0, 'cho duyet', 6, 1),
(13, 'Honda Air Blade', 'Tay ga', 'Phổ thông', 'test', 3, '2025-06-25', '4h-6h', 0, 'da duyet', 1, 1),
(17, 'NVX 155', 'Xe tay ga', '150cc', 'rửa xe', 3, '2025-06-24', '13:00-14:00', 1, 'cho duyet', 9, 1),
(18, 'NVX 155', 'Xe tay ga', '150cc', 'bảo hành', 2, '2025-06-24', '13:00-14:00', 1, 'cho duyet', 9, 1);

-- --------------------------------------------------------

--
-- Table structure for table `lichlamviec`
--

CREATE TABLE `lichlamviec` (
  `MaLLV` int(11) NOT NULL,
  `ngay` date DEFAULT NULL,
  `TrangThai` enum('cho duyet','da duyet','huy') DEFAULT NULL,
  `ThoiGianCa` varchar(255) DEFAULT NULL,
  `LaNgayCuoiTuan` bit(1) DEFAULT NULL,
  `LaNgayNghiLe` bit(1) DEFAULT NULL,
  `admin_AdminID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `lichlamviec`
--

INSERT INTO `lichlamviec` (`MaLLV`, `ngay`, `TrangThai`, `ThoiGianCa`, `LaNgayCuoiTuan`, `LaNgayNghiLe`, `admin_AdminID`) VALUES
(7, '2025-06-22', 'da duyet', '09:00-10:00', b'1', b'0', 1),
(8, '2025-06-23', 'da duyet', '10:00-11:00', b'0', b'0', 1),
(9, '2025-06-24', 'da duyet', '13:00-14:00', b'0', b'1', 1),
(10, '2025-06-22', 'da duyet', '09:00-10:00', b'1', b'0', 1),
(11, '2025-06-23', 'da duyet', '10:00-11:00', b'0', b'0', 1),
(12, '2025-06-24', 'huy', '13:00-14:00', b'0', b'1', 1);

-- --------------------------------------------------------

--
-- Table structure for table `lichsubaohanh`
--

CREATE TABLE `lichsubaohanh` (
  `MaBHDK` int(11) NOT NULL,
  `TenBHDK` varchar(50) DEFAULT NULL,
  `Ngay` date DEFAULT NULL,
  `LoaiBaoHanh` varchar(45) DEFAULT NULL,
  `MaSeriesSP` varchar(45) DEFAULT NULL,
  `ThongTinTruocBaoHanh` varchar(45) DEFAULT NULL,
  `ThongTinSauBaoHanh` varchar(45) DEFAULT NULL,
  `xemay_MaXE` int(11) DEFAULT NULL,
  `chitiethoadon_MaCTHD` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `nhanvien`
--

CREATE TABLE `nhanvien` (
  `MaNV` int(11) NOT NULL,
  `TenNV` varchar(100) DEFAULT NULL,
  `MatKhau` varchar(100) DEFAULT NULL,
  `Email` varchar(45) DEFAULT NULL,
  `SDT` varchar(20) DEFAULT NULL,
  `lichlamviec_MaLLV` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `nhanvien`
--

INSERT INTO `nhanvien` (`MaNV`, `TenNV`, `MatKhau`, `Email`, `SDT`, `lichlamviec_MaLLV`) VALUES
(1, 'Trần quốc lâm', '123', 'lam@gmail.com', '123456789', 9),
(2, 'Nguyễn Quang Huy ', '123', 'huyz@gmail.com', '1234567678', 9),
(3, 'Ngô Mạnh Cường ', '123', 'cuong@gmail.com', '1234567678', 9),
(9, 'Nguyễn Văn A', 'matkhau123', 'a.nguyen@example.com', '0901111222', 10),
(10, 'Trần Thị B', 'baomat456', 'b.tran@example.com', '0902222333', 10),
(11, 'Lê Văn C', 'pass789', 'c.le@example.com', '0903333444', 10),
(12, 'Phạm Minh D', '123456', 'd.pham@example.com', '0904444555', 10),
(13, 'Hoàng Thị E', 'mkhoang', 'e.hoang@example.com', '0905555666', 10);

-- --------------------------------------------------------

--
-- Table structure for table `nhasanxuat`
--

CREATE TABLE `nhasanxuat` (
  `MaNSX` int(11) NOT NULL,
  `TenNhaSX` varchar(100) DEFAULT NULL,
  `XuatXu` text DEFAULT NULL,
  `MoTa` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `nhasanxuat`
--

INSERT INTO `nhasanxuat` (`MaNSX`, `TenNhaSX`, `XuatXu`, `MoTa`) VALUES
(1, 'Honda', 'Nhật Bản', 'Chuyên xe máy'),
(2, 'Yamaha', 'Nhật Bản', 'Xe máy & phụ tùng'),
(3, 'SYM', 'Đài Loan', 'Xe máy phổ thông'),
(4, 'Piaggio', 'Ý', 'Xe tay ga cao cấp'),
(5, 'Suzuki', 'Nhật Bản', 'Xe máy và phụ tùng'),
(6, 'Kawasaki', 'Nhật Bản', 'Phụ tùng thể thao'),
(7, 'Harley-Davidson', 'Mỹ', 'Xe phân khối lớn'),
(8, 'VinFast', 'Việt Nam', 'Xe máy điện'),
(9, 'Lifan', 'Trung Quốc', 'Xe giá rẻ'),
(10, 'Ducati', 'Ý', 'Phân khối lớn cao cấp');

-- --------------------------------------------------------

--
-- Table structure for table `phutungxemay`
--

CREATE TABLE `phutungxemay` (
  `MaSP` int(11) NOT NULL,
  `TenSP` varchar(100) DEFAULT NULL,
  `SoSeriesSP` varchar(100) DEFAULT NULL,
  `MieuTaSP` text DEFAULT NULL,
  `NamSX` int(11) DEFAULT NULL,
  `XuatXu` varchar(100) DEFAULT NULL,
  `ThoiGianBaoHanhDinhKy` varchar(255) DEFAULT NULL,
  `DonGia` decimal(15,2) DEFAULT NULL,
  `loaiphutung` varchar(45) DEFAULT NULL,
  `HinhAnh` varchar(255) DEFAULT NULL,
  `TrangThai` tinyint(1) DEFAULT NULL,
  `nhasanxuat_MaNSX` int(11) DEFAULT NULL,
  `SoLanBaoHanhToiDa` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `phutungxemay`
--

INSERT INTO `phutungxemay` (`MaSP`, `TenSP`, `SoSeriesSP`, `MieuTaSP`, `NamSX`, `XuatXu`, `ThoiGianBaoHanhDinhKy`, `DonGia`, `loaiphutung`, `HinhAnh`, `TrangThai`, `nhasanxuat_MaNSX`, `SoLanBaoHanhToiDa`) VALUES
(13, 'Bugi', 'Bugi01', 'Honda khuyến cáo cứ 8000 km bạn nên thay thế định kì 1 lần để đảm bảo xe của bạn được vận hành an toàn, riêng với Airblade và PCX 2016, sau 12000 km bạn nên thay thế định kì 1 lần.\r\n\r\nGiá bán lẻ đề xuất được công bố chi tiết tại các cửa hàng ủy nhiệm của Honda Việt Nam (HEAD) trên toàn quốc \r\n\r\n', 2023, 'Nhật Bản', '180 ngày', 30000.00, 'Cho xe 2 bánh', 'uploads/1749187789_bugi-ic-xe-may-35.jpg', 1, 1, 1),
(14, 'Bugi tải', 'Bugi02', 'Bugi cho xe tải', 2001, 'Nhật Bản', '365 ngày', 100000.00, 'Cho xe tải', 'uploads/1749187769_bugi-nhat.jpg', 1, 2, 2),
(15, 'Bugi SYM', 'BugiSYM-01', 'Bugi dùng cho SYM', 2022, 'Đài Loan', '365 ngày', 70000.00, 'Cho xe SYM', 'uploads/1749183654_bugi-nhat.jpg', 1, 3, 2),
(16, 'Bugi Piaggio', 'BugiPiaggio-01', 'Bugi cao cấp cho Piaggio', 2024, 'Ý', '30 ngày', 50000.00, 'Cho Piaggio', 'uploads/1749183713_bugi-ic-xe-may-35.jpg', 1, 4, 1),
(17, 'Nhớt Suzukii', 'NhotSuzuki-011', 'Nhớt dành cho xe Suzukii', 2024, 'Nhật Bảnn', '120 ngàyy', 90000.00, 'Cho xe Suzukii', 'uploads/1750153058_honda.png', 1, 6, 2),
(23, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(24, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(25, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(26, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(27, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `xemay`
--

CREATE TABLE `xemay` (
  `MaXE` int(11) NOT NULL,
  `TenXe` varchar(255) DEFAULT NULL,
  `LoaiXe` varchar(255) DEFAULT NULL,
  `PhanKhuc` varchar(255) DEFAULT NULL,
  `BienSoXe` varchar(255) DEFAULT NULL,
  `HinhAnhMatTruocXe` varchar(255) DEFAULT NULL,
  `HinhAnhMatSauXe` varchar(255) DEFAULT NULL,
  `hoadon_MaHD` int(11) DEFAULT NULL,
  `khachhang_MaKH` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `xemay`
--

INSERT INTO `xemay` (`MaXE`, `TenXe`, `LoaiXe`, `PhanKhuc`, `BienSoXe`, `HinhAnhMatTruocXe`, `HinhAnhMatSauXe`, `hoadon_MaHD`, `khachhang_MaKH`) VALUES
(8, 'Vision 155', 'Xe tay ga', '150cc', '59G2-65231', 'uploads/68580681b4680_honda-vision-2025-front.jpg', 'uploads/68580681b48af_honda-vision-2025-back.jpg', NULL, 2),
(9, 'NVX 155', 'Xe tay ga', '150cc', '29G2-72698', 'uploads/685806cea9123_nvx-front.jpg', 'uploads/685806cea92ce_nvx-back.jpg', NULL, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`AdminID`);

--
-- Indexes for table `chitiethoadon`
--
ALTER TABLE `chitiethoadon`
  ADD PRIMARY KEY (`MaCTHD`),
  ADD KEY `hoadon_MaHD` (`hoadon_MaHD`),
  ADD KEY `phutungxemay_MaSP` (`phutungxemay_MaSP`),
  ADD KEY `dichvu_MaDV` (`dichvu_MaDV`);

--
-- Indexes for table `dichvu`
--
ALTER TABLE `dichvu`
  ADD PRIMARY KEY (`MaDV`);

--
-- Indexes for table `hoadon`
--
ALTER TABLE `hoadon`
  ADD PRIMARY KEY (`MaHD`),
  ADD KEY `fk_hoadon_xemay` (`xemay_MaXE`);

--
-- Indexes for table `khachhang`
--
ALTER TABLE `khachhang`
  ADD PRIMARY KEY (`MaKH`),
  ADD KEY `fk_khachhang_admin` (`admin_AdminID`);

--
-- Indexes for table `lichhen`
--
ALTER TABLE `lichhen`
  ADD PRIMARY KEY (`MaLH`);

--
-- Indexes for table `lichlamviec`
--
ALTER TABLE `lichlamviec`
  ADD PRIMARY KEY (`MaLLV`),
  ADD KEY `fk_lichlamviec_admin` (`admin_AdminID`);

--
-- Indexes for table `lichsubaohanh`
--
ALTER TABLE `lichsubaohanh`
  ADD PRIMARY KEY (`MaBHDK`),
  ADD KEY `xemay_MaXE` (`xemay_MaXE`),
  ADD KEY `chitiethoadon_MaCTHD` (`chitiethoadon_MaCTHD`);

--
-- Indexes for table `nhanvien`
--
ALTER TABLE `nhanvien`
  ADD PRIMARY KEY (`MaNV`),
  ADD KEY `lichlamviec_MaLLV` (`lichlamviec_MaLLV`);

--
-- Indexes for table `nhasanxuat`
--
ALTER TABLE `nhasanxuat`
  ADD PRIMARY KEY (`MaNSX`);

--
-- Indexes for table `phutungxemay`
--
ALTER TABLE `phutungxemay`
  ADD PRIMARY KEY (`MaSP`),
  ADD KEY `nhasanxuat_MaNSX` (`nhasanxuat_MaNSX`);

--
-- Indexes for table `xemay`
--
ALTER TABLE `xemay`
  ADD PRIMARY KEY (`MaXE`),
  ADD KEY `hoadon_MaHD` (`hoadon_MaHD`),
  ADD KEY `khachhang_MaKH` (`khachhang_MaKH`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `AdminID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `chitiethoadon`
--
ALTER TABLE `chitiethoadon`
  MODIFY `MaCTHD` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `dichvu`
--
ALTER TABLE `dichvu`
  MODIFY `MaDV` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `hoadon`
--
ALTER TABLE `hoadon`
  MODIFY `MaHD` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `khachhang`
--
ALTER TABLE `khachhang`
  MODIFY `MaKH` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `lichhen`
--
ALTER TABLE `lichhen`
  MODIFY `MaLH` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `lichlamviec`
--
ALTER TABLE `lichlamviec`
  MODIFY `MaLLV` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `lichsubaohanh`
--
ALTER TABLE `lichsubaohanh`
  MODIFY `MaBHDK` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `nhanvien`
--
ALTER TABLE `nhanvien`
  MODIFY `MaNV` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `nhasanxuat`
--
ALTER TABLE `nhasanxuat`
  MODIFY `MaNSX` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `phutungxemay`
--
ALTER TABLE `phutungxemay`
  MODIFY `MaSP` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `xemay`
--
ALTER TABLE `xemay`
  MODIFY `MaXE` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `chitiethoadon`
--
ALTER TABLE `chitiethoadon`
  ADD CONSTRAINT `chitiethoadon_ibfk_1` FOREIGN KEY (`hoadon_MaHD`) REFERENCES `hoadon` (`MaHD`),
  ADD CONSTRAINT `chitiethoadon_ibfk_2` FOREIGN KEY (`phutungxemay_MaSP`) REFERENCES `phutungxemay` (`MaSP`),
  ADD CONSTRAINT `chitiethoadon_ibfk_3` FOREIGN KEY (`dichvu_MaDV`) REFERENCES `dichvu` (`MaDV`);

--
-- Constraints for table `hoadon`
--
ALTER TABLE `hoadon`
  ADD CONSTRAINT `fk_hoadon_xemay` FOREIGN KEY (`xemay_MaXE`) REFERENCES `xemay` (`MaXE`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `khachhang`
--
ALTER TABLE `khachhang`
  ADD CONSTRAINT `fk_khachhang_admin` FOREIGN KEY (`admin_AdminID`) REFERENCES `admin` (`AdminID`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `lichlamviec`
--
ALTER TABLE `lichlamviec`
  ADD CONSTRAINT `fk_lichlamviec_admin` FOREIGN KEY (`admin_AdminID`) REFERENCES `admin` (`AdminID`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `lichsubaohanh`
--
ALTER TABLE `lichsubaohanh`
  ADD CONSTRAINT `lichsubaohanh_ibfk_1` FOREIGN KEY (`xemay_MaXE`) REFERENCES `xemay` (`MaXE`),
  ADD CONSTRAINT `lichsubaohanh_ibfk_2` FOREIGN KEY (`chitiethoadon_MaCTHD`) REFERENCES `chitiethoadon` (`MaCTHD`);

--
-- Constraints for table `nhanvien`
--
ALTER TABLE `nhanvien`
  ADD CONSTRAINT `nhanvien_ibfk_1` FOREIGN KEY (`lichlamviec_MaLLV`) REFERENCES `lichlamviec` (`MaLLV`);

--
-- Constraints for table `phutungxemay`
--
ALTER TABLE `phutungxemay`
  ADD CONSTRAINT `phutungxemay_ibfk_1` FOREIGN KEY (`nhasanxuat_MaNSX`) REFERENCES `nhasanxuat` (`MaNSX`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
