<?php
class AdminModel {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Hàm kiểm tra đăng nhập
    public function login($email, $password) {
        $stmt = $this->conn->prepare("SELECT * FROM admin WHERE username = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $admin = $result->fetch_assoc();

        if ($admin && $admin['password'] === $password) {
            return $admin;
        }
        return false;
    }
}
?>