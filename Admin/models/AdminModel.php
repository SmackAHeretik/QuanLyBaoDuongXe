<?php
class AdminModel
{
    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    // Hàm kiểm tra đăng nhập
    public function getByEmail($email)
    {
        // Ở đây email là username trong bảng admin
        $stmt = $this->conn->prepare("SELECT * FROM admin WHERE username = ?");
        $stmt->execute([$email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Hàm kiểm tra đăng nhập (nếu cần dùng riêng)
    public function login($email, $password)
    {
        $admin = $this->getByEmail($email);
        if ($admin && $admin['password'] === $password) {
            return $admin;
        }
        return false;
    }
}
?>