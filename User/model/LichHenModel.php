<?php
class LichHenModel
{
    private $conn;
    public function __construct($conn)
    {
        $this->conn = $conn;
    }
    public function insertLichHen($data)
    {
        $sql = "INSERT INTO lichhen 
            (TenXe, LoaiXe, PhanKhuc, MoTaLyDo, nhanvien_MaNV, NgayHen, ThoiGianCa, PhanLoai, TrangThai, xemay_MaXE, khachhang_MaKH)
            VALUES 
            (:TenXe, :LoaiXe, :PhanKhuc, :MoTaLyDo, :nhanvien_MaNV, :NgayHen, :ThoiGianCa, :PhanLoai, :TrangThai, :xemay_MaXE, :khachhang_MaKH)";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute($data);
    }
    // Lấy các ca đã được đặt trong ngày (chỉ lấy trạng thái đang chờ duyệt hoặc đã duyệt)
    public function getThoiGianCaDaDat($ngay)
    {
        $sql = "SELECT ThoiGianCa FROM lichhen WHERE DATE(NgayHen) = :ngay AND TrangThai IN ('cho duyet','da duyet')";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':ngay', $ngay);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_COLUMN);
        return $result ?: [];
    }
    public function getLichHenByKhachHang($makh)
    {
        $sql = "SELECT lh.*, nv.TenNV 
            FROM lichhen lh 
            LEFT JOIN nhanvien nv ON lh.nhanvien_MaNV = nv.MaNV 
            WHERE lh.khachhang_MaKH = :makh 
            ORDER BY lh.NgayHen DESC, lh.ThoiGianCa ASC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':makh' => $makh]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    // Bổ sung các hàm còn thiếu:
    public function getLichById($malich)
    {
        $sql = "SELECT * FROM lichhen WHERE MaLich = :malich";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':malich' => $malich]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function updateTrangThai($malich, $trangthai)
    {
        $sql = "UPDATE lichhen SET TrangThai = :trangthai WHERE MaLich = :malich";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([':trangthai' => $trangthai, ':malich' => $malich]);
    }
}
?>