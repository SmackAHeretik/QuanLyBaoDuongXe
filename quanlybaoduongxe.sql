-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th6 03, 2025 lúc 10:25 AM
-- Phiên bản máy phục vụ: 10.4.32-MariaDB
-- Phiên bản PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `quanlybaoduongxe`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `admin`
--

CREATE TABLE `admin` (
  `AdminID` int(11) NOT NULL,
  `username` varchar(45) NOT NULL,
  `password` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `calamviec`
--

CREATE TABLE `calamviec` (
  `MaCaV` int(11) NOT NULL,
  `ThoiGianBD` datetime DEFAULT NULL,
  `ThoiGianKT` datetime DEFAULT NULL,
  `TrangThaiKT` enum('available','busy','off') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `chitiethoadon`
--

CREATE TABLE `chitiethoadon` (
  `MaCTHD` int(11) NOT NULL,
  `MaSP` int(11) DEFAULT NULL,
  `GiaTien` decimal(10,2) DEFAULT NULL,
  `SoLuong` int(11) DEFAULT NULL,
  `NgayBDBH` datetime DEFAULT NULL,
  `NgayKTBH` datetime DEFAULT NULL,
  `hoadon_MaHD` int(11) DEFAULT NULL,
  `phutungxemay_MaSP` int(11) DEFAULT NULL,
  `SoLanDaBaoHanh` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `dichvu`
--

CREATE TABLE `dichvu` (
  `MaDV` int(11) NOT NULL,
  `TenDV` varchar(50) DEFAULT NULL,
  `HinhAnh` text DEFAULT NULL,
  `DonGia` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `hoadon`
--

CREATE TABLE `hoadon` (
  `MaHD` int(11) NOT NULL,
  `TongTien` decimal(10,2) DEFAULT NULL,
  `Ngay` date DEFAULT NULL,
  `TrangThai` enum('paid','unpaid','cancelled') DEFAULT NULL,
  `khachhang_MaKH` int(11) DEFAULT NULL,
  `TienKhuyenMai_MaVoucher` int(11) DEFAULT NULL,
  `MaGiamGia_MaVoucher` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `khachhang`
--

CREATE TABLE `khachhang` (
  `MaKH` int(11) NOT NULL,
  `TenKH` varchar(50) DEFAULT NULL,
  `Email` varchar(30) DEFAULT NULL,
  `DiaChi` text DEFAULT NULL,
  `TrangThai` enum('active','inactive') DEFAULT NULL,
  `Reset_token` text DEFAULT NULL,
  `admin_AdminID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `lichen`
--

CREATE TABLE `lichen` (
  `MaLich` int(11) NOT NULL,
  `NgayHen` datetime DEFAULT NULL,
  `TrangThai` enum('pending','confirmed','cancelled') DEFAULT NULL,
  `lichen_nhanvien_MaNV` int(11) DEFAULT NULL,
  `lichen_khachhang_MaKH` int(11) DEFAULT NULL,
  `lichhen_lichlamviec_MaLLV` int(11) DEFAULT NULL,
  `MoTaLichtrinh` longtext DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `lichlamviec`
--

CREATE TABLE `lichlamviec` (
  `MaLLV` int(11) NOT NULL,
  `nhanvien_MaNV` int(11) DEFAULT NULL,
  `calamviec_MaCaV` int(11) DEFAULT NULL,
  `ngay` date DEFAULT NULL,
  `TrangThai` enum('on','off','leave') DEFAULT NULL,
  `ThoiGianCa` date DEFAULT NULL,
  `LaNgayCuoiTuan` bit(1) DEFAULT NULL,
  `LaNgayNghiLe` bit(1) DEFAULT NULL,
  `quanly_MaQL` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `lichsubaohanh`
--

CREATE TABLE `lichsubaohanh` (
  `MaBHK` int(11) NOT NULL,
  `TenBHK` varchar(50) DEFAULT NULL,
  `Ngay` date DEFAULT NULL,
  `chitiethoadon_MaCTHD` int(11) DEFAULT NULL,
  `lichen_MaLich` int(11) DEFAULT NULL,
  `LoaiBaoHanh` varchar(45) DEFAULT NULL,
  `MaSeriesSP` varchar(45) DEFAULT NULL,
  `ThongTinTruocBaoHanh` varchar(45) DEFAULT NULL,
  `ThongTinSauBaoHanh` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `magiamgia`
--

CREATE TABLE `magiamgia` (
  `MaVoucher` int(11) NOT NULL,
  `TenVoucher` varchar(45) DEFAULT NULL,
  `MoTa` varchar(45) DEFAULT NULL,
  `ThoiGianBD` date DEFAULT NULL,
  `ThoiGianKT` date DEFAULT NULL,
  `GiaTri` varchar(45) DEFAULT NULL,
  `Loai` enum('percent','cash','other') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `nhanvien`
--

CREATE TABLE `nhanvien` (
  `MaNV` int(11) NOT NULL,
  `TenNV` varchar(50) DEFAULT NULL,
  `MatKhau` varchar(45) DEFAULT NULL,
  `Email` varchar(45) DEFAULT NULL,
  `SDT` varchar(20) DEFAULT NULL,
  `admin_AdminID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `nhasanxuat`
--

CREATE TABLE `nhasanxuat` (
  `MaNSX` int(11) NOT NULL,
  `TenNhaSX` varchar(100) DEFAULT NULL,
  `XuatXu` text DEFAULT NULL,
  `MoTa` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `nhasanxuat`
--

INSERT INTO `nhasanxuat` (`MaNSX`, `TenNhaSX`, `XuatXu`, `MoTa`) VALUES
(1, 'Honda', 'Nhật Bản', 'Hãng xe nổi tiếng của Nhật'),
(2, 'Yamaha', 'Nhật Bản', 'Xe máy bền, đẹp'),
(3, 'Suzuki', 'Nhật Bản', 'Xe thể thao, mạnh mẽ'),
(4, 'SYM', 'Đài Loan', 'Xe phổ thông'),
(5, 'Piaggio', 'Ý', 'Phong cách châu Âu');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `phutungxemay`
--

CREATE TABLE `phutungxemay` (
  `MaSP` int(11) NOT NULL,
  `TenSP` varchar(100) NOT NULL,
  `SoSeriesSP` varchar(100) DEFAULT NULL,
  `MieuTaSP` text DEFAULT NULL,
  `NamSX` int(11) DEFAULT NULL,
  `XuatXu` varchar(100) DEFAULT NULL,
  `ThoiGianBaoHanhDinhKy` date DEFAULT NULL,
  `DonGia` decimal(15,2) DEFAULT NULL,
  `loaiphutung` varchar(100) DEFAULT NULL,
  `nhasanxuat_MaNSX` int(11) DEFAULT NULL,
  `SoLanBaoHanhToiDa` int(11) DEFAULT NULL,
  `HinhAnh` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `quanly`
--

CREATE TABLE `quanly` (
  `MaQL` int(11) NOT NULL,
  `TenQL` varchar(45) DEFAULT NULL,
  `Email` varchar(45) DEFAULT NULL,
  `MatKhau` varchar(45) DEFAULT NULL,
  `SDT` varchar(45) DEFAULT NULL,
  `admin_AdminID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`AdminID`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Chỉ mục cho bảng `calamviec`
--
ALTER TABLE `calamviec`
  ADD PRIMARY KEY (`MaCaV`);

--
-- Chỉ mục cho bảng `chitiethoadon`
--
ALTER TABLE `chitiethoadon`
  ADD PRIMARY KEY (`MaCTHD`),
  ADD KEY `hoadon_MaHD` (`hoadon_MaHD`),
  ADD KEY `phutungxemay_MaSP` (`phutungxemay_MaSP`);

--
-- Chỉ mục cho bảng `dichvu`
--
ALTER TABLE `dichvu`
  ADD PRIMARY KEY (`MaDV`);

--
-- Chỉ mục cho bảng `hoadon`
--
ALTER TABLE `hoadon`
  ADD PRIMARY KEY (`MaHD`),
  ADD KEY `khachhang_MaKH` (`khachhang_MaKH`),
  ADD KEY `MaGiamGia_MaVoucher` (`MaGiamGia_MaVoucher`);

--
-- Chỉ mục cho bảng `khachhang`
--
ALTER TABLE `khachhang`
  ADD PRIMARY KEY (`MaKH`),
  ADD KEY `admin_AdminID` (`admin_AdminID`);

--
-- Chỉ mục cho bảng `lichen`
--
ALTER TABLE `lichen`
  ADD PRIMARY KEY (`MaLich`),
  ADD KEY `lichen_nhanvien_MaNV` (`lichen_nhanvien_MaNV`),
  ADD KEY `lichen_khachhang_MaKH` (`lichen_khachhang_MaKH`);

--
-- Chỉ mục cho bảng `lichlamviec`
--
ALTER TABLE `lichlamviec`
  ADD PRIMARY KEY (`MaLLV`),
  ADD KEY `nhanvien_MaNV` (`nhanvien_MaNV`),
  ADD KEY `calamviec_MaCaV` (`calamviec_MaCaV`),
  ADD KEY `quanly_MaQL` (`quanly_MaQL`);

--
-- Chỉ mục cho bảng `lichsubaohanh`
--
ALTER TABLE `lichsubaohanh`
  ADD PRIMARY KEY (`MaBHK`),
  ADD KEY `chitiethoadon_MaCTHD` (`chitiethoadon_MaCTHD`),
  ADD KEY `lichen_MaLich` (`lichen_MaLich`);

--
-- Chỉ mục cho bảng `magiamgia`
--
ALTER TABLE `magiamgia`
  ADD PRIMARY KEY (`MaVoucher`);

--
-- Chỉ mục cho bảng `nhanvien`
--
ALTER TABLE `nhanvien`
  ADD PRIMARY KEY (`MaNV`),
  ADD KEY `admin_AdminID` (`admin_AdminID`);

--
-- Chỉ mục cho bảng `nhasanxuat`
--
ALTER TABLE `nhasanxuat`
  ADD PRIMARY KEY (`MaNSX`);

--
-- Chỉ mục cho bảng `phutungxemay`
--
ALTER TABLE `phutungxemay`
  ADD PRIMARY KEY (`MaSP`),
  ADD KEY `nhasanxuat_MaNSX` (`nhasanxuat_MaNSX`);

--
-- Chỉ mục cho bảng `quanly`
--
ALTER TABLE `quanly`
  ADD PRIMARY KEY (`MaQL`),
  ADD KEY `admin_AdminID` (`admin_AdminID`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `admin`
--
ALTER TABLE `admin`
  MODIFY `AdminID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `calamviec`
--
ALTER TABLE `calamviec`
  MODIFY `MaCaV` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `chitiethoadon`
--
ALTER TABLE `chitiethoadon`
  MODIFY `MaCTHD` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `dichvu`
--
ALTER TABLE `dichvu`
  MODIFY `MaDV` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `hoadon`
--
ALTER TABLE `hoadon`
  MODIFY `MaHD` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `khachhang`
--
ALTER TABLE `khachhang`
  MODIFY `MaKH` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `lichen`
--
ALTER TABLE `lichen`
  MODIFY `MaLich` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `lichlamviec`
--
ALTER TABLE `lichlamviec`
  MODIFY `MaLLV` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `lichsubaohanh`
--
ALTER TABLE `lichsubaohanh`
  MODIFY `MaBHK` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `magiamgia`
--
ALTER TABLE `magiamgia`
  MODIFY `MaVoucher` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `nhanvien`
--
ALTER TABLE `nhanvien`
  MODIFY `MaNV` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `nhasanxuat`
--
ALTER TABLE `nhasanxuat`
  MODIFY `MaNSX` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT cho bảng `phutungxemay`
--
ALTER TABLE `phutungxemay`
  MODIFY `MaSP` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `quanly`
--
ALTER TABLE `quanly`
  MODIFY `MaQL` int(11) NOT NULL AUTO_INCREMENT;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `chitiethoadon`
--
ALTER TABLE `chitiethoadon`
  ADD CONSTRAINT `chitiethoadon_ibfk_1` FOREIGN KEY (`hoadon_MaHD`) REFERENCES `hoadon` (`MaHD`),
  ADD CONSTRAINT `chitiethoadon_ibfk_2` FOREIGN KEY (`phutungxemay_MaSP`) REFERENCES `phutungxemay` (`MaSP`);

--
-- Các ràng buộc cho bảng `hoadon`
--
ALTER TABLE `hoadon`
  ADD CONSTRAINT `hoadon_ibfk_1` FOREIGN KEY (`khachhang_MaKH`) REFERENCES `khachhang` (`MaKH`),
  ADD CONSTRAINT `hoadon_ibfk_2` FOREIGN KEY (`MaGiamGia_MaVoucher`) REFERENCES `magiamgia` (`MaVoucher`);

--
-- Các ràng buộc cho bảng `khachhang`
--
ALTER TABLE `khachhang`
  ADD CONSTRAINT `khachhang_ibfk_1` FOREIGN KEY (`admin_AdminID`) REFERENCES `admin` (`AdminID`);

--
-- Các ràng buộc cho bảng `lichen`
--
ALTER TABLE `lichen`
  ADD CONSTRAINT `lichen_ibfk_1` FOREIGN KEY (`lichen_nhanvien_MaNV`) REFERENCES `nhanvien` (`MaNV`),
  ADD CONSTRAINT `lichen_ibfk_2` FOREIGN KEY (`lichen_khachhang_MaKH`) REFERENCES `khachhang` (`MaKH`);

--
-- Các ràng buộc cho bảng `lichlamviec`
--
ALTER TABLE `lichlamviec`
  ADD CONSTRAINT `lichlamviec_ibfk_1` FOREIGN KEY (`nhanvien_MaNV`) REFERENCES `nhanvien` (`MaNV`),
  ADD CONSTRAINT `lichlamviec_ibfk_2` FOREIGN KEY (`calamviec_MaCaV`) REFERENCES `calamviec` (`MaCaV`),
  ADD CONSTRAINT `lichlamviec_ibfk_3` FOREIGN KEY (`quanly_MaQL`) REFERENCES `quanly` (`MaQL`);

--
-- Các ràng buộc cho bảng `lichsubaohanh`
--
ALTER TABLE `lichsubaohanh`
  ADD CONSTRAINT `lichsubaohanh_ibfk_1` FOREIGN KEY (`chitiethoadon_MaCTHD`) REFERENCES `chitiethoadon` (`MaCTHD`),
  ADD CONSTRAINT `lichsubaohanh_ibfk_2` FOREIGN KEY (`lichen_MaLich`) REFERENCES `lichen` (`MaLich`);

--
-- Các ràng buộc cho bảng `nhanvien`
--
ALTER TABLE `nhanvien`
  ADD CONSTRAINT `nhanvien_ibfk_1` FOREIGN KEY (`admin_AdminID`) REFERENCES `admin` (`AdminID`);

--
-- Các ràng buộc cho bảng `phutungxemay`
--
ALTER TABLE `phutungxemay`
  ADD CONSTRAINT `phutungxemay_ibfk_1` FOREIGN KEY (`nhasanxuat_MaNSX`) REFERENCES `nhasanxuat` (`MaNSX`);

--
-- Các ràng buộc cho bảng `quanly`
--
ALTER TABLE `quanly`
  ADD CONSTRAINT `quanly_ibfk_1` FOREIGN KEY (`admin_AdminID`) REFERENCES `admin` (`AdminID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
