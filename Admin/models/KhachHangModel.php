<?php
class KhachHangModel {
    private $db;
    public function __construct($db) {
        $this->db = $db;
    }
    public function getAll() {
        $stmt = $this->db->prepare("SELECT * FROM khachhang");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getById($maKH) {
        $stmt = $this->db->prepare("SELECT * FROM khachhang WHERE MaKH = ?");
        $stmt->execute([$maKH]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}