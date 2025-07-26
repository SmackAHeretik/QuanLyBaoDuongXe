<?php
require_once __DIR__ . '/../db.php';
require_once __DIR__ . '/../models/LichLamViecModel.php';

class LichLamViecController {
    private $model;
    public function __construct() {
        $db = connectDB();
        $this->model = new LichLamViecModel($db);
    }

    public function list() {
        $dsLich = $this->model->getAll();
        include __DIR__ . '/../views/lichlamviec/list.php';
    }

    public function add() {
        $error = '';
        $data = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data['ngay'] = $_POST['ngay'] ?? '';
            $data['TrangThai'] = $_POST['TrangThai'] ?? '';
            $data['ThoiGianCa'] = $_POST['ThoiGianCa'] ?? '';
            $data['LaNgayCuoiTuan'] = isset($_POST['LaNgayCuoiTuan']) ? 1 : 0;
            $data['LaNgayNghiLe'] = isset($_POST['LaNgayNghiLe']) ? 1 : 0;
            $data['admin_AdminID'] = $_POST['admin_AdminID'] ?? null;

            if (!$data['ngay'] || !$data['TrangThai'] || !$data['ThoiGianCa']) {
                $error = "Vui lòng điền đầy đủ thông tin!";
            } else {
                if ($this->model->add($data)) {
                    header('Location: ?action=list');
                    exit;
                } else {
                    $error = "Thêm lịch làm việc thất bại!";
                }
            }
        }
        include __DIR__ . '/../views/lichlamviec/add.php';
    }

    public function edit() {
        $error = '';
        $id = $_GET['id'] ?? '';
        $data = $this->model->getById($id);
        if (!$data) {
            echo '<div class="alert alert-danger">Không tìm thấy lịch làm việc!</div>';
            return;
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data['ngay'] = $_POST['ngay'] ?? $data['ngay'];
            $data['TrangThai'] = $_POST['TrangThai'] ?? $data['TrangThai'];
            $data['ThoiGianCa'] = $_POST['ThoiGianCa'] ?? $data['ThoiGianCa'];
            $data['LaNgayCuoiTuan'] = isset($_POST['LaNgayCuoiTuan']) ? 1 : 0;
            $data['LaNgayNghiLe'] = isset($_POST['LaNgayNghiLe']) ? 1 : 0;
            $data['admin_AdminID'] = $_POST['admin_AdminID'] ?? $data['admin_AdminID'];

            if (!$data['ngay'] || !$data['TrangThai'] || !$data['ThoiGianCa']) {
                $error = "Vui lòng điền đầy đủ thông tin!";
            } else {
                if ($this->model->update($id, $data)) {
                    header('Location: ?action=list');
                    exit;
                } else {
                    $error = "Cập nhật lịch làm việc thất bại!";
                }
            }
        }
        include __DIR__ . '/../views/lichlamviec/edit.php';
    }

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