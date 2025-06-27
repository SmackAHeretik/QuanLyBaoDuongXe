<?php
class KhachHangModel {
    private $pdo;
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    // Lấy tất cả khách hàng
    public function getAll() {
        $stmt = $this->pdo->prepare("SELECT * FROM khachhang ORDER BY MaKH DESC");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Lấy khách hàng theo ID
    public function getById($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM khachhang WHERE MaKH = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Thêm khách hàng mới
    public function insert($TenKH, $Email, $MatKhau, $DiaChi, $SDT, $TrangThai) {
        $stmt = $this->pdo->prepare("INSERT INTO khachhang (TenKH, Email, MatKhau, DiaChi, SDT, TrangThai) VALUES (?, ?, ?, ?, ?, ?)");
        return $stmt->execute([$TenKH, $Email, $MatKhau, $DiaChi, $SDT, $TrangThai]);
    }

    // Cập nhật khách hàng
    public function update($id, $TenKH, $Email, $DiaChi, $SDT, $TrangThai) {
        $stmt = $this->pdo->prepare("UPDATE khachhang SET TenKH=?, Email=?, DiaChi=?, SDT=?, TrangThai=? WHERE MaKH=?");
        return $stmt->execute([$TenKH, $Email, $DiaChi, $SDT, $TrangThai, $id]);
    }

    // Xóa khách hàng
    public function delete($id) {
        $stmt = $this->pdo->prepare("DELETE FROM khachhang WHERE MaKH = ?");
        return $stmt->execute([$id]);
    }

    // Khóa/mở khóa khách hàng
    public function setStatus($id, $status) {
        $stmt = $this->pdo->prepare("UPDATE khachhang SET TrangThai=? WHERE MaKH=?");
        return $stmt->execute([$status, $id]);
    }

    // Lấy danh sách xe của khách hàng
    public function getXeByKhachHang($makh) {
        $stmt = $this->pdo->prepare("SELECT * FROM xemay WHERE khachhang_MaKH = ?");
        $stmt->execute([$makh]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>