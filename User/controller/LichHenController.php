<?php

require_once __DIR__ . '/../model/LichHenModel.php';

class LichHenController
{
    private $model;

    public function __construct($db = null)
    {
        $this->model = new LichHenModel($db);
    }

    // Xử lý AJAX lấy nhân viên rảnh
    public function nhanvienRon()
    {
        if (!isset($_POST['datetime'])) {
            http_response_code(400);
            echo json_encode(['error' => 'Thiếu dữ liệu']);
            exit;
        }
        $datetime = $_POST['datetime'];
        $dsNhanVien = $this->model->getNhanVienRanh($datetime);
        header('Content-Type: application/json');
        echo json_encode($dsNhanVien);
        exit;
    }

    // Hiển thị form đặt lịch
    public function datLichForm()
    {
        require_once __DIR__ . '/../layouts/contact/contact.php';
    }

    // Xử lý đặt lịch
    public function datLich()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $loaixe = $_POST['loaixe'] ?? '';
            $thoigianhen = $_POST['thoigianhen'] ?? '';
            $manv = $_POST['manv'] ?? '';
            $moTa = $_POST['message'] ?? '';

            // Validate dữ liệu
            if (empty($loaixe) || empty($thoigianhen) || empty($manv) || empty($moTa)) {
                $GLOBALS['error'] = "Vui lòng nhập đầy đủ thông tin!";
                return;
            }

            // Kiểm tra trùng lịch
            if ($this->model->kiemTraTrungLich($thoigianhen, $manv)) {
                $GLOBALS['error'] = "Nhân viên đã có lịch vào thời gian này!";
                return;
            }

            // Thêm lịch hẹn
            $result = $this->model->themLichHen($thoigianhen, $loaixe, $manv, $moTa);
            if ($result) {
                echo "<script>
                    alert('Đặt lịch thành công!');
                    window.location.href = 'index.php';
                </script>";
                exit();
            } else {
                $GLOBALS['error'] = "Đặt lịch thất bại! Vui lòng thử lại.";
                return;
            }
        }
    }
}
?>