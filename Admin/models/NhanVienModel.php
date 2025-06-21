<?php
class NhanVienModel {
    private $db;
    public function __construct($db) {
        $this->db = $db;
    }
    public function getAll() {
        $stmt = $this->db->prepare("SELECT * FROM nhanvien");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getById($maNV) {
        $stmt = $this->db->prepare("SELECT * FROM nhanvien WHERE MaNV = ?");
        $stmt->execute([$maNV]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}