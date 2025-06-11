<?php
require_once __DIR__ . '/../db.php';
require_once __DIR__ . '/../models/AdminModel.php';

class AdminController {
    private $adminModel;

    public function __construct() {
        $db = connectDB();
        $this->adminModel = new AdminModel($db);
    }

    public function login($email, $password) {
        $admin = $this->adminModel->login($email, $password);
        if ($admin) {
            session_start();
            $_SESSION['admin'] = $admin;
            header('Location: index.php');
            exit();
        } else {
            return "Email hoặc mật khẩu không đúng!";
        }
    }
}
?>