<?php
class LichLamViecModel {
    private $db;
    public function __construct($db) {
        $this->db = $db;
    }
    public function getAll() {
        $stmt = $this->db->prepare("SELECT * FROM lichlamviec ORDER BY ngay DESC");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getById($id) {
        $stmt = $this->db->prepare("SELECT * FROM lichlamviec WHERE MaLLV = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function add($data) {
        $stmt = $this->db->prepare("INSERT INTO lichlamviec (ngay, TrangThai, ThoiGianCa, LaNgayCuoiTuan, LaNgayNghiLe, admin_AdminID) VALUES (?, ?, ?, ?, ?, ?)");
        return $stmt->execute([
            $data['ngay'], $data['TrangThai'], $data['ThoiGianCa'], $data['LaNgayCuoiTuan'], $data['LaNgayNghiLe'], $data['admin_AdminID']
        ]);
    }
    public function update($id, $data) {
        $stmt = $this->db->prepare("UPDATE lichlamviec SET ngay=?, TrangThai=?, ThoiGianCa=?, LaNgayCuoiTuan=?, LaNgayNghiLe=?, admin_AdminID=? WHERE MaLLV=?");
        return $stmt->execute([
            $data['ngay'], $data['TrangThai'], $data['ThoiGianCa'], $data['LaNgayCuoiTuan'], $data['LaNgayNghiLe'], $data['admin_AdminID'], $id
        ]);
    }
    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM lichlamviec WHERE MaLLV = ?");
        return $stmt->execute([$id]);
    }
}
?>