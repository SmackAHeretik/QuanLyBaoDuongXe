<?php
require_once __DIR__ . '/../models/LichHenModel.php';

class LichHenController {
    private $model;
    private $khachHangModel;
    private $xeModel;
    private $nhanVienModel;
    public function __construct($db) {
        $this->model = new LichHenModel($db);
        $this->khachHangModel = new KhachHangModel($db);
        $this->xeModel = new XeModel($db);
        $this->nhanVienModel = new NhanVienModel($db);
    }
    // Hiển thị danh sách lịch hẹn (filter theo role)
    public function index() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        $user = $_SESSION['user'] ?? null;
        $role = $user['role'] ?? '';
        $staffRole = $user['data']['Roles'] ?? '';
        $maNV = $user['data']['MaNV'] ?? '';

        if ($role === 'staff' && $staffRole === 'Thợ sửa xe') {
            // Chỉ lấy lịch hẹn của thợ này
            $ds = $this->model->getAllByNhanVien($maNV);
        } else {
            // Admin, kế toán... lấy tất cả lịch hẹn
            $ds = $this->model->getAll();
        }
        require './views/lichhen/danhsachlichhen.php';
    }
    // Thêm lịch hẹn
    public function add() {
        $khachhangs = $this->khachHangModel->getAll();
        $nhanviens = $this->nhanVienModel->getAll();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = $_POST;
            $this->model->insert($data);
            header('Location: ?controller=lichhen');
            exit;
        }
        require './views/lichhen/themlichhen.php';
    }
    // Sửa lịch hẹn
    public function edit() {
        $khachhangs = $this->khachHangModel->getAll();
        $nhanviens = $this->nhanVienModel->getAll();
        $id = $_GET['id'] ?? null;
        if (!$id) { header('Location: ?controller=lichhen'); exit; }
        $lichhen = $this->model->getById($id);
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = $_POST;
            $this->model->update($id, $data);
            header('Location: ?controller=lichhen');
            exit;
        }
        require './views/lichhen/sualichhen.php';
    }
    // Xóa lịch hẹn
    public function delete() {
        $id = $_GET['id'] ?? null;
        if ($id) $this->model->delete($id);
        header('Location: ?controller=lichhen');
        exit;
    }

    // Duyệt/hủy lịch hẹn (AJAX)
    public function update_status() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id']) && isset($_POST['status'])) {
            $id = (int)$_POST['id'];
            $status = $_POST['status'];
            $validStatuses = ['da duyet', 'huy'];
            if (!in_array($status, $validStatuses)) {
                echo json_encode(['status'=>'fail', 'msg'=>'Trạng thái không hợp lệ']);
                exit;
            }
            $lichhen = $this->model->getById($id);
            if (!$lichhen) {
                echo json_encode(['status'=>'fail', 'msg'=>'Không tìm thấy lịch hẹn']);
                exit;
            }
            if ($lichhen['TrangThai'] !== 'cho duyet') {
                echo json_encode(['status'=>'fail', 'msg'=>'Chỉ xử lý lịch hẹn chờ duyệt']);
                exit;
            }
            $ok = $this->model->update($id, array_merge($lichhen, ['TrangThai'=>$status]));
            if ($ok) {
                echo json_encode(['status'=>'success']);
            } else {
                echo json_encode(['status'=>'fail', 'msg'=>'Cập nhật thất bại']);
            }
            exit;
        }
        echo json_encode(['status'=>'fail', 'msg'=>'Thiếu dữ liệu']);
        exit;
    }
}
?>