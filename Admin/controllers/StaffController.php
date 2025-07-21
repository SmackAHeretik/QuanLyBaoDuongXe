<?php
require_once __DIR__ . '/../db.php';
require_once __DIR__ . '/../models/StaffModel.php';

class StaffController {
    private $model;

    public function __construct() {
        $db = connectDB();
        $this->model = new StaffModel($db);
    }

    // Đăng nhập nhân viên không lưu session
    public function loginNoSession($email, $password) {
        $user = $this->model->getByEmail($email);
        // Kiểm tra bằng password_verify (đã lưu hash)
        if ($user && password_verify($password, $user['MatKhau'])) {
            return $user;
        }
        return false;
    }

    // Hiển thị danh sách nhân viên
    public function list() {
        $dsStaff = $this->model->getAll();
        include __DIR__ . '/../views/nhanvien/list.php';
    }

    // Thêm nhân viên
    public function add() {
        $error = '';
        $data = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data['tennv'] = trim($_POST['tennv'] ?? '');
            $data['email'] = trim($_POST['email'] ?? '');
            $data['sdt'] = trim($_POST['sdt'] ?? '');
            $password = $_POST['password'] ?? '';
            $confirm = $_POST['confirm'] ?? '';
            $data['password'] = $password;

            if (!$data['tennv'] || !$data['email'] || !$data['sdt'] || !$password || !$confirm) {
                $error = "Vui lòng điền đầy đủ thông tin!";
            } elseif (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
                $error = "Email không hợp lệ!";
            } elseif ($password !== $confirm) {
                $error = "Mật khẩu xác nhận không khớp!";
            } elseif ($this->model->existsEmail($data['email'])) {
                $error = "Email đã tồn tại!";
            } else {
                if ($this->model->add($data)) {
                    header('Location: ?action=list');
                    exit;
                } else {
                    $error = "Thêm nhân viên thất bại!";
                }
            }
        }
        include __DIR__ . '/../views/nhanvien/add.php';
    }

    // Sửa thông tin nhân viên
    public function edit() {
        $error = '';
        $id = $_GET['id'] ?? '';
        $data = $this->model->getById($id);
        if (!$data) {
            echo '<div class="alert alert-danger">Không tìm thấy nhân viên!</div>';
            return;
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data['tennv'] = trim($_POST['tennv'] ?? '');
            $data['email'] = trim($_POST['email'] ?? '');
            $data['sdt'] = trim($_POST['sdt'] ?? '');
            $password = $_POST['password'] ?? '';
            $confirm = $_POST['confirm'] ?? '';
            $data['password'] = $password;

            if (!$data['tennv'] || !$data['email'] || !$data['sdt']) {
                $error = "Vui lòng điền đầy đủ thông tin!";
            } elseif (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
                $error = "Email không hợp lệ!";
            } elseif ($password && $password !== $confirm) {
                $error = "Mật khẩu xác nhận không khớp!";
            } else {
                if ($this->model->update($id, $data)) {
                    header('Location: ?action=list');
                    exit;
                } else {
                    $error = "Cập nhật nhân viên thất bại!";
                }
            }
        }
        include __DIR__ . '/../views/nhanvien/edit.php';
    }

    // Xóa nhân viên
    public function delete() {
        $id = $_GET['id'] ?? '';
        if ($id) {
            $this->model->delete($id);
        }
        header('Location: ?action=list');
        exit;
    }
}
?>