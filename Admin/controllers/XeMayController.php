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
        $msg = $_GET['msg'] ?? '';
        include __DIR__ . '/../views/xemay/danhsach.php';
    }

    public function them()
    {
        $khachhangs = $this->model->getAllKhachHang();
        $msg = $_GET['msg'] ?? '';
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'TenXe' => $_POST['TenXe'] ?? '',
                'LoaiXe' => $_POST['LoaiXe'] ?? '',
                'PhanKhuc' => $_POST['PhanKhuc'] ?? '',
                'BienSoXe' => $_POST['BienSoXe'] ?? '',
                'SoKhung' => $_POST['SoKhung'] ?? '',
                'SoMay' => $_POST['SoMay'] ?? '',
                'khachhang_MaKH' => $_POST['khachhang_MaKH'] ?? '',
            ];

            // Đảm bảo User/uploads là đúng ở gốc project
            $uploadDir = dirname(__DIR__, 2) . '/User/uploads/';
            if (!file_exists($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            // Ảnh mặt trước
            if (
                isset($_FILES['HinhAnhMatTruocXe']) &&
                $_FILES['HinhAnhMatTruocXe']['error'] == 0 &&
                is_uploaded_file($_FILES['HinhAnhMatTruocXe']['tmp_name']) &&
                !empty($_FILES['HinhAnhMatTruocXe']['name'])
            ) {
                $name = time() . '_' . basename($_FILES['HinhAnhMatTruocXe']['name']);
                $uploadResult = move_uploaded_file($_FILES['HinhAnhMatTruocXe']['tmp_name'], $uploadDir . $name);
                $data['HinhAnhMatTruocXe'] = $uploadResult ? ('uploads/' . $name) : null;
            } else {
                $data['HinhAnhMatTruocXe'] = null;
            }

            // Ảnh mặt sau
            if (
                isset($_FILES['HinhAnhMatSauXe']) &&
                $_FILES['HinhAnhMatSauXe']['error'] == 0 &&
                is_uploaded_file($_FILES['HinhAnhMatSauXe']['tmp_name']) &&
                !empty($_FILES['HinhAnhMatSauXe']['name'])
            ) {
                $name = time() . '_' . basename($_FILES['HinhAnhMatSauXe']['name']);
                $uploadResult = move_uploaded_file($_FILES['HinhAnhMatSauXe']['tmp_name'], $uploadDir . $name);
                $data['HinhAnhMatSauXe'] = $uploadResult ? ('uploads/' . $name) : null;
            } else {
                $data['HinhAnhMatSauXe'] = null;
            }

            // Check duplicate SoKhung/SoMay
            if (
                (!empty($data['SoKhung']) || !empty($data['SoMay'])) &&
                $this->model->isExistedSoKhungOrSoMay($data['SoKhung'], $data['SoMay'])
            ) {
                header('Location: table.php?controller=xemay&action=them&msg=duplicate');
                exit;
            }

            $success = $this->model->add($data);

            if ($success) {
                header('Location: table.php?controller=xemay&action=index&msg=add_success');
            } else {
                header('Location: table.php?controller=xemay&action=them&msg=add_fail');
            }
            exit;
        }
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
        $msg = $_GET['msg'] ?? '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'TenXe' => $_POST['TenXe'] ?? '',
                'LoaiXe' => $_POST['LoaiXe'] ?? '',
                'PhanKhuc' => $_POST['PhanKhuc'] ?? '',
                'BienSoXe' => $_POST['BienSoXe'] ?? '',
                'SoKhung' => $_POST['SoKhung'] ?? '',
                'SoMay' => $_POST['SoMay'] ?? '',
                'khachhang_MaKH' => $_POST['khachhang_MaKH'] ?? '',
            ];

            $uploadDir = dirname(__DIR__, 2) . '/User/uploads/';
            if (!file_exists($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            // Ảnh mặt trước
            if (
                isset($_FILES['HinhAnhMatTruocXe']) &&
                $_FILES['HinhAnhMatTruocXe']['error'] == 0 &&
                is_uploaded_file($_FILES['HinhAnhMatTruocXe']['tmp_name']) &&
                !empty($_FILES['HinhAnhMatTruocXe']['name'])
            ) {
                $name = time() . '_' . basename($_FILES['HinhAnhMatTruocXe']['name']);
                $uploadResult = move_uploaded_file($_FILES['HinhAnhMatTruocXe']['tmp_name'], $uploadDir . $name);
                $data['HinhAnhMatTruocXe'] = $uploadResult ? ('uploads/' . $name) : $_POST['HinhAnhMatTruocXe_current'];
            } else {
                $data['HinhAnhMatTruocXe'] = $_POST['HinhAnhMatTruocXe_current'] ?? null;
            }

            // Ảnh mặt sau
            if (
                isset($_FILES['HinhAnhMatSauXe']) &&
                $_FILES['HinhAnhMatSauXe']['error'] == 0 &&
                is_uploaded_file($_FILES['HinhAnhMatSauXe']['tmp_name']) &&
                !empty($_FILES['HinhAnhMatSauXe']['name'])
            ) {
                $name = time() . '_' . basename($_FILES['HinhAnhMatSauXe']['name']);
                $uploadResult = move_uploaded_file($_FILES['HinhAnhMatSauXe']['tmp_name'], $uploadDir . $name);
                $data['HinhAnhMatSauXe'] = $uploadResult ? ('uploads/' . $name) : $_POST['HinhAnhMatSauXe_current'];
            } else {
                $data['HinhAnhMatSauXe'] = $_POST['HinhAnhMatSauXe_current'] ?? null;
            }

            // Check duplicate SoKhung/SoMay, trừ chính xe đang sửa
            $oldXe = $this->model->getById($MaXE);
            if (
                (!empty($data['SoKhung']) || !empty($data['SoMay'])) &&
                (
                    ($data['SoKhung'] != $oldXe['SoKhung'] && $this->model->isExistedSoKhungOrSoMay($data['SoKhung'], '')) ||
                    ($data['SoMay'] != $oldXe['SoMay'] && $this->model->isExistedSoKhungOrSoMay('', $data['SoMay']))
                )
            ) {
                header('Location: table.php?controller=xemay&action=sua&MaXE='.$MaXE.'&msg=duplicate');
                exit;
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