<?php
class AdminModel
{
    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    // Hàm kiểm tra đăng nhập
    public function login($email, $password)
    {
        $stmt = $this->conn->prepare("SELECT * FROM admin WHERE username = ?");
        $stmt->execute([$email]);
        $admin = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($admin && $admin['password'] === $password) {
            return $admin;
        }
        return false;
    }
}
?>