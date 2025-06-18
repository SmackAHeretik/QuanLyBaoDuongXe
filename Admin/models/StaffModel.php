<?php
class StaffModel
{
    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    // Đăng ký tài khoản nhân viên
    public function register($name, $email, $phone, $password)
    {
        $stmt = $this->conn->prepare("INSERT INTO nhanvien (TenNV, Email, SDT, MatKhau) VALUES (?, ?, ?, ?)");
        return $stmt->execute([$name, $email, $phone, $password]);
    }

    // Kiểm tra email đã tồn tại chưa
    public function existsEmail($email)
    {
        $stmt = $this->conn->prepare("SELECT * FROM nhanvien WHERE Email = ?");
        $stmt->execute([$email]);
        // Có thể dùng rowCount hoặc fetch
        return $stmt->fetch(PDO::FETCH_ASSOC) !== false;
    }

    // Đăng nhập nhân viên
    public function login($email, $password)
    {
        $stmt = $this->conn->prepare("SELECT * FROM nhanvien WHERE Email = ? AND MatKhau = ?");
        $stmt->execute([$email, $password]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>