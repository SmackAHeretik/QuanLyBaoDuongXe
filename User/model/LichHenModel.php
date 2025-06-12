<?php

class LichHenModel
{
    private $conn;

    public function __construct($db = null)
    {
        if ($db) {
            $this->conn = $db;
        } else {
            $this->conn = new mysqli('localhost', 'root', '', 'quanlybaoduongxe');
            if ($this->conn->connect_error) {
                die("Kết nối thất bại: " . $this->conn->connect_error);
            }
        }
    }

    // Thêm lịch hẹn mới
    public function themLichHen($ngayHen, $loaiXe, $maNV, $moTa, $trangThai = 'pending')
    {
        $maNV = (int)$maNV;
        $stmt = $this->conn->prepare("INSERT INTO lichen (NgayHen, TrangThai, LoaiXe, lichen_nhanvien_MaNV, MoTaLichtrinh) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssis", $ngayHen, $trangThai, $loaiXe, $maNV, $moTa);
        if (!$stmt->execute()) {
            error_log("MySQL error: " . $stmt->error);
            return false;
        }
        return true;
    }

    // Kiểm tra trùng lịch cho nhân viên
    public function kiemTraTrungLich($ngayHen, $maNV)
    {
        $stmt = $this->conn->prepare("SELECT * FROM lichen WHERE NgayHen = ? AND lichen_nhanvien_MaNV = ?");
        $stmt->bind_param("si", $ngayHen, $maNV);
        $stmt->execute();
        return $stmt->get_result()->num_rows > 0;
    }

    // Lấy nhân viên rảnh tại thời điểm $datetime
    public function getNhanVienRanh($datetime)
    {
        $sql = "SELECT nv.MaNV, nv.TenNV 
                FROM nhanvien nv
                WHERE nv.MaNV NOT IN (
                    SELECT lichen_nhanvien_MaNV FROM lichen WHERE NgayHen = ?
                )";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $datetime);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }
}
?>