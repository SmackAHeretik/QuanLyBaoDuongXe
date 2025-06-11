
<?php
require_once __DIR__ . '/../db.php';
require_once __DIR__ . '/../models/ManagerModel.php';

class ManagerController {
    private $managerModel;

    public function __construct() {
        $db = connectDB();
        $this->managerModel = new ManagerModel($db);
    }

    // Đăng ký quản lý
    public function register($name, $email, $phone, $password) {
        if ($this->managerModel->existsEmail($email)) {
            return "Email đã tồn tại!";
        }
        if ($this->managerModel->register($name, $email, $phone, $password)) {
            return true;
        }
        return "Đăng ký thất bại!";
    }

    // Đăng nhập quản lý
    public function login($email, $password) {
        $manager = $this->managerModel->login($email, $password);
        if ($manager) {
            session_start();
            $_SESSION['manager'] = $manager;
            return true;
        }
        return "Email hoặc mật khẩu không đúng!";
    }
}
?>