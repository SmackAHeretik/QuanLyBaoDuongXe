<?php
class StaffModel {
    private $db;
    public function __construct($db) {
        $this->db = $db;
    }
    // Lấy danh sách nhân viên
    public function getAll() {
        $stmt = $this->db->prepare("SELECT * FROM nhanvien");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    // Lấy thông tin nhân viên theo ID
    public function getById($id) {
        $stmt = $this->db->prepare("SELECT * FROM nhanvien WHERE MaNV = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    // Lấy thông tin nhân viên theo email
    public function getByEmail($email) {
        $stmt = $this->db->prepare("SELECT * FROM nhanvien WHERE Email = ?");
        $stmt->execute([$email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    // Kiểm tra email đã tồn tại
    public function existsEmail($email) {
        $stmt = $this->db->prepare("SELECT MaNV FROM nhanvien WHERE Email = ?");
        $stmt->execute([$email]);
        return $stmt->fetch() ? true : false;
    }
    // Thêm nhân viên
    public function add($data) {
        $stmt = $this->db->prepare("
            INSERT INTO nhanvien (TenNV, Email, SDT, MatKhau)
            VALUES (?, ?, ?, ?)
        ");
        $hash = password_hash($data['password'], PASSWORD_BCRYPT);
        return $stmt->execute([
            $data['tennv'],
            $data['email'],
            $data['sdt'],
            $hash
        ]);
    }
    // Sửa thông tin nhân viên
    public function update($id, $data) {
        if (!empty($data['password'])) {
            $stmt = $this->db->prepare("
                UPDATE nhanvien SET TenNV=?, Email=?, SDT=?, MatKhau=? WHERE MaNV=?
            ");
            $hash = password_hash($data['password'], PASSWORD_BCRYPT);
            return $stmt->execute([
                $data['tennv'],
                $data['email'],
                $data['sdt'],
                $hash,
                $id
            ]);
        } else {
            $stmt = $this->db->prepare("
                UPDATE nhanvien SET TenNV=?, Email=?, SDT=? WHERE MaNV=?
            ");
            return $stmt->execute([
                $data['tennv'],
                $data['email'],
                $data['sdt'],
                $id
            ]);
        }
    }
    // Xóa nhân viên
    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM nhanvien WHERE MaNV = ?");
        return $stmt->execute([$id]);
    }
}
?>