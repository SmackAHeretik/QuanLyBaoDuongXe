
<?php
require_once __DIR__ . '/../db.php';
require_once __DIR__ . '/../models/StaffModel.php';

class StaffController {
    private $staffModel;

    public function __construct() {
        $db = connectDB();
        $this->staffModel = new StaffModel($db);
    }

    // Đăng ký nhân viên
    public function register($name, $email, $phone, $password) {
        if ($this->staffModel->existsEmail($email)) {
            return "Email đã tồn tại!";
        }
        if ($this->staffModel->register($name, $email, $phone, $password)) {
            return true;
        }
        return "Đăng ký thất bại!";
    }

    // Đăng nhập nhân viên
    public function login($email, $password) {
        $staff = $this->staffModel->login($email, $password);
        if ($staff) {
            session_start();
            $_SESSION['staff'] = $staff;
            return true;
        }
        return "Email hoặc mật khẩu không đúng!";
    }
}
?>