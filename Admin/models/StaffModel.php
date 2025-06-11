
<?php
class StaffModel {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Đăng ký tài khoản nhân viên
    public function register($name, $email, $phone, $password) {
        $stmt = $this->conn->prepare("INSERT INTO nhanvien (TenNV, Email, SDT, MatKhau) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $name, $email, $phone, $password);
        return $stmt->execute();
    }

    // Kiểm tra email đã tồn tại chưa
    public function existsEmail($email) {
        $stmt = $this->conn->prepare("SELECT * FROM nhanvien WHERE Email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->num_rows > 0;
    }

    // Đăng nhập nhân viên
    public function login($email, $password) {
        $stmt = $this->conn->prepare("SELECT * FROM nhanvien WHERE Email = ? AND MatKhau = ?");
        $stmt->bind_param("ss", $email, $password);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }
}
?>