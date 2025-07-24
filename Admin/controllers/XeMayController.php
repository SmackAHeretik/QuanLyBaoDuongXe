<?php
require_once __DIR__ . '/../models/XeMayModel.php';
require_once __DIR__ . '/../db.php';

class XeMayController
{
    private $model;
    public function __construct()
    {
        $this->model = new XeMayModel(connectDB());
    }

    public function index()
    {
        $xemays = $this->model->getAll();
        // Đọc thông báo nếu có
        $msg = $_GET['msg'] ?? '';
        include __DIR__ . '/../views/xemay/danhsach.php';
    }

    public function them()
    {
        $khachhangs = $this->model->getAllKhachHang();
        $msg = '';
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'TenXe' => $_POST['TenXe'] ?? '',
                'LoaiXe' => $_POST['LoaiXe'] ?? '',
                'PhanKhuc' => $_POST['PhanKhuc'] ?? '',
                'BienSoXe' => $_POST['BienSoXe'] ?? '',
                'khachhang_MaKH' => $_POST['khachhang_MaKH'] ?? '',
            ];

            // Đảm bảo thư mục upload tồn tại
            $uploadDir = __DIR__ . '/../User/uploads/';
            if (!file_exists($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            // Xử lý upload ảnh mặt trước vào User/uploads
            if (isset($_FILES['HinhAnhMatTruocXe']) && $_FILES['HinhAnhMatTruocXe']['error'] == 0) {
                $name = time() . '_' . basename($_FILES['HinhAnhMatTruocXe']['name']);
                $targetPath = $uploadDir . $name;
                move_uploaded_file($_FILES['HinhAnhMatTruocXe']['tmp_name'], $targetPath);
                $data['HinhAnhMatTruocXe'] = $name;
            } else {
                $data['HinhAnhMatTruocXe'] = null;
            }

            // Xử lý upload ảnh mặt sau vào User/uploads
            if (isset($_FILES['HinhAnhMatSauXe']) && $_FILES['HinhAnhMatSauXe']['error'] == 0) {
                $name = time() . '_' . basename($_FILES['HinhAnhMatSauXe']['name']);
                $targetPath = $uploadDir . $name;
                move_uploaded_file($_FILES['HinhAnhMatSauXe']['tmp_name'], $targetPath);
                $data['HinhAnhMatSauXe'] = $name;
            } else {
                $data['HinhAnhMatSauXe'] = null;
            }

            $success = $this->model->add($data);

            if ($success) {
                header('Location: table.php?controller=xemay&action=index&msg=add_success');
            } else {
                header('Location: table.php?controller=xemay&action=them&msg=add_fail');
            }
            exit;
        }
        $msg = $_GET['msg'] ?? '';
        include __DIR__ . '/../views/xemay/them.php';
    }

    public function sua()
    {
        $MaXE = $_GET['MaXE'] ?? null;
        if (!$MaXE) {
            header('Location: table.php?controller=xemay&action=index');
            exit;
        }

        $khachhangs = $this->model->getAllKhachHang();
        $msg = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'TenXe' => $_POST['TenXe'] ?? '',
                'LoaiXe' => $_POST['LoaiXe'] ?? '',
                'PhanKhuc' => $_POST['PhanKhuc'] ?? '',
                'BienSoXe' => $_POST['BienSoXe'] ?? '',
                'khachhang_MaKH' => $_POST['khachhang_MaKH'] ?? '',
            ];

            // Đảm bảo thư mục upload tồn tại
            $uploadDir = __DIR__ . '/../User/uploads/';
            if (!file_exists($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            // Xử lý upload ảnh mặt trước vào User/uploads
            if (isset($_FILES['HinhAnhMatTruocXe']) && $_FILES['HinhAnhMatTruocXe']['error'] == 0 && $_FILES['HinhAnhMatTruocXe']['name'] != "") {
                $name = time() . '_' . basename($_FILES['HinhAnhMatTruocXe']['name']);
                $targetPath = $uploadDir . $name;
                move_uploaded_file($_FILES['HinhAnhMatTruocXe']['tmp_name'], $targetPath);
                $data['HinhAnhMatTruocXe'] = $name;
            } else {
                $data['HinhAnhMatTruocXe'] = $_POST['HinhAnhMatTruocXe_current'] ?? null;
            }

            // Xử lý upload ảnh mặt sau vào User/uploads
            if (isset($_FILES['HinhAnhMatSauXe']) && $_FILES['HinhAnhMatSauXe']['error'] == 0 && $_FILES['HinhAnhMatSauXe']['name'] != "") {
                $name = time() . '_' . basename($_FILES['HinhAnhMatSauXe']['name']);
                $targetPath = $uploadDir . $name;
                move_uploaded_file($_FILES['HinhAnhMatSauXe']['tmp_name'], $targetPath);
                $data['HinhAnhMatSauXe'] = $name;
            } else {
                $data['HinhAnhMatSauXe'] = $_POST['HinhAnhMatSauXe_current'] ?? null;
            }

            $success = $this->model->update($MaXE, $data);

            if ($success) {
                header('Location: table.php?controller=xemay&action=index&msg=edit_success');
            } else {
                header('Location: table.php?controller=xemay&action=sua&MaXE='.$MaXE.'&msg=edit_fail');
            }
            exit;
        }
        $xemay = $this->model->getById($MaXE);
        $msg = $_GET['msg'] ?? '';
        include __DIR__ . '/../views/xemay/sua.php';
    }

    public function xoa()
    {
        $MaXE = $_GET['MaXE'] ?? null;
        if ($MaXE) {
            $this->model->delete($MaXE);
        }
        header('Location: table.php?controller=xemay&action=index&msg=delete_success');
        exit;
    }
}