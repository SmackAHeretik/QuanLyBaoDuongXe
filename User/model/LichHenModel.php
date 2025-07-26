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
        // Kiểm tra nhân viên này đã bị đặt lịch ca/ngày này chưa (theo MaLLV)
        $sqlCheck = "SELECT COUNT(*) FROM lichhen WHERE nhanvien_MaNV = :nhanvien_MaNV AND MaLLV = :MaLLV AND TrangThai IN ('cho duyet','da duyet')";
        $stmtCheck = $this->conn->prepare($sqlCheck);
        $stmtCheck->execute([
            ':nhanvien_MaNV' => $data['nhanvien_MaNV'],
            ':MaLLV' => $data['MaLLV'],
        ]);
        $count = $stmtCheck->fetchColumn();
        if ($count > 0) {
            // Nhân viên này đã được đặt lịch cho ca này (MaLLV) rồi
            return false;
        }

        $sql = "INSERT INTO lichhen 
            (TenXe, LoaiXe, PhanKhuc, MoTaLyDo, nhanvien_MaNV, NgayHen, ThoiGianCa, PhanLoai, TrangThai, xemay_MaXE, khachhang_MaKH, MaLLV)
            VALUES 
            (:TenXe, :LoaiXe, :PhanKhuc, :MoTaLyDo, :nhanvien_MaNV, :NgayHen, :ThoiGianCa, :PhanLoai, :TrangThai, :xemay_MaXE, :khachhang_MaKH, :MaLLV)";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute($data);
    }

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

    // Đếm số lịch hẹn đã đặt theo MaLLV
    public function countLichHenByLLV($MaLLV) {
        $sql = "SELECT COUNT(*) FROM lichhen WHERE MaLLV = :mallv AND TrangThai IN ('cho duyet','da duyet')";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':mallv' => $MaLLV]);
        return (int)$stmt->fetchColumn();
    }
}
?>