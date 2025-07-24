<?php
class StaffModel {
    private $db;
    public function __construct($db) {
        $this->db = $db;
    }
    public function getAll() {
        $stmt = $this->db->prepare("SELECT * FROM nhanvien");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getById($id) {
        $stmt = $this->db->prepare("SELECT * FROM nhanvien WHERE MaNV = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function getByEmail($email) {
        $stmt = $this->db->prepare("SELECT * FROM nhanvien WHERE Email = ?");
        $stmt->execute([$email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function existsEmail($email) {
        $stmt = $this->db->prepare("SELECT MaNV FROM nhanvien WHERE Email = ?");
        $stmt->execute([$email]);
        return $stmt->fetch() ? true : false;
    }
    // Kiểm tra email trùng với username của admin
    public function existsEmailInAdmin($email) {
        $stmt = $this->db->prepare("SELECT AdminID FROM admin WHERE username = ?");
        $stmt->execute([$email]);
        return $stmt->fetch() ? true : false;
    }
    // Thêm nhân viên (có Roles)
    public function add($data) {
        $stmt = $this->db->prepare("
            INSERT INTO nhanvien (TenNV, Email, SDT, MatKhau, Roles)
            VALUES (?, ?, ?, ?, ?)
        ");
        $hash = password_hash($data['password'], PASSWORD_BCRYPT);
        return $stmt->execute([
            $data['tennv'],
            $data['email'],
            $data['sdt'],
            $hash,
            $data['roles']
        ]);
    }
    // Sửa thông tin nhân viên (có Roles)
    public function update($id, $data) {
        if (!empty($data['password'])) {
            $stmt = $this->db->prepare("
                UPDATE nhanvien SET TenNV=?, Email=?, SDT=?, MatKhau=?, Roles=? WHERE MaNV=?
            ");
            $hash = password_hash($data['password'], PASSWORD_BCRYPT);
            return $stmt->execute([
                $data['tennv'],
                $data['email'],
                $data['sdt'],
                $hash,
                $data['roles'],
                $id
            ]);
        } else {
            $stmt = $this->db->prepare("
                UPDATE nhanvien SET TenNV=?, Email=?, SDT=?, Roles=? WHERE MaNV=?
            ");
            return $stmt->execute([
                $data['tennv'],
                $data['email'],
                $data['sdt'],
                $data['roles'],
                $id
            ]);
        }
    }
    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM nhanvien WHERE MaNV = ?");
        return $stmt->execute([$id]);
    }
}
?>