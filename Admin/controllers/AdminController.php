<?php
require_once __DIR__ . '/../db.php';
require_once __DIR__ . '/../models/AdminModel.php';

class AdminController {
    private $adminModel;

    public function __construct() {
        $db = connectDB();
        $this->adminModel = new AdminModel($db);
    }

    // Đăng nhập, trả về dữ liệu nếu thành công, false nếu thất bại. KHÔNG set session ở đây.
    public function loginNoSession($email, $password) {
        return $this->adminModel->login($email, $password);
    }
}
?>