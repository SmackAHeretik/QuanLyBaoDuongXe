<?php
class NhanVienModel
{
    private $db;
    public function __construct($db) { $this->db = $db; }

    // Lấy tất cả thợ sửa xe
    public function getAllThoSuaXe() {
        $sql = "SELECT * FROM nhanvien WHERE Roles = 'Thợ sửa xe'";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Lấy tất cả nhân viên
    public function getAll() {
        $sql = "SELECT * FROM nhanvien";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>