<?php
class PhanCongLichLamViecModel
{
    private $db;
    public function __construct($db) { $this->db = $db; }

    // Lấy tất cả nhân viên đã được phân công vào 1 ca, bao gồm cả tên nhân viên
    public function getNhanVienByMaLLV($MaLLV) {
        $sql = "SELECT nv.MaNV, nv.TenNV 
                FROM phancong_lichlamviec pc
                JOIN nhanvien nv ON pc.MaNV = nv.MaNV
                WHERE pc.MaLLV = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$MaLLV]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC); // Trả về mảng có MaNV, TenNV
    }

    // Lấy tất cả chỉ MaNV đã được phân công vào 1 ca (nếu muốn)
    public function getMaNVsByMaLLV($MaLLV) {
        $sql = "SELECT MaNV FROM phancong_lichlamviec WHERE MaLLV = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$MaLLV]);
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

    // Kiểm tra 1 nhân viên đã được phân công vào ca này chưa
    public function isNhanVienInCa($MaLLV, $MaNV) {
        $sql = "SELECT COUNT(*) FROM phancong_lichlamviec WHERE MaLLV = ? AND MaNV = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$MaLLV, $MaNV]);
        return $stmt->fetchColumn() > 0;
    }

    // Thêm phân công
    public function insert($MaLLV, $MaNV) {
        $sql = "INSERT INTO phancong_lichlamviec (MaLLV, MaNV) VALUES (?, ?)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$MaLLV, $MaNV]);
    }

    // Xóa tất cả phân công của 1 ca
    public function deleteByMaLLV($MaLLV) {
        $sql = "DELETE FROM phancong_lichlamviec WHERE MaLLV = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$MaLLV]);
    }
}
?>