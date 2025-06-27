<?php
require_once __DIR__ . '/../db.php';
require_once __DIR__ . '/../models/KhachHangModel.php';

$pdo = connectDB();
$model = new KhachHangModel($pdo);

$action = $_GET['action'] ?? 'list';
$id = $_GET['id'] ?? null;

switch ($action) {
    case 'add':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $TenKH = $_POST['TenKH'] ?? '';
            $Email = $_POST['Email'] ?? '';
            $MatKhau = $_POST['MatKhau'] ?? '';
            $DiaChi = $_POST['DiaChi'] ?? '';
            $SDT = $_POST['SDT'] ?? '';
            $TrangThai = $_POST['TrangThai'] ?? 'hoat_dong';
            $MatKhauHash = password_hash($MatKhau, PASSWORD_DEFAULT);

            // Kiểm tra email đã tồn tại chưa
            $exist = false;
            foreach ($model->getAll() as $kh) {
                if ($kh['Email'] === $Email) $exist = true;
            }
            if ($exist) {
                $_SESSION['error'] = "Email đã tồn tại!";
                header("Location: khachhang.php?action=add");
                exit;
            }

            $model->insert($TenKH, $Email, $MatKhauHash, $DiaChi, $SDT, $TrangThai);
            $_SESSION['success'] = "Thêm khách hàng thành công!";
            header("Location: khachhang.php");
            exit;
        }
        $content = __DIR__ . '/../views/khachhang/add.php';
        include __DIR__ . '/../views/khachhang/layout.php';
        break;

    case 'edit':
        if (!$id) { header("Location: khachhang.php"); exit; }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $TenKH = $_POST['TenKH'] ?? '';
            $Email = $_POST['Email'] ?? '';
            $DiaChi = $_POST['DiaChi'] ?? '';
            $SDT = $_POST['SDT'] ?? '';
            $TrangThai = $_POST['TrangThai'] ?? 'hoat_dong';
            $model->update($id, $TenKH, $Email, $DiaChi, $SDT, $TrangThai);
            $_SESSION['success'] = "Cập nhật thành công!";
            header("Location: khachhang.php");
            exit;
        } else {
            $kh = $model->getById($id);
            $content = __DIR__ . '/../views/khachhang/edit.php';
            include __DIR__ . '/../views/khachhang/layout.php';
        }
        break;

    case 'delete':
        if ($id) {
            $model->delete($id);
            $_SESSION['success'] = "Đã xóa khách hàng!";
        }
        header("Location: khachhang.php");
        exit;

    case 'block':
        if ($id) $model->setStatus($id, 'bi_khoa');
        header("Location: khachhang.php");
        exit;

    case 'unblock':
        if ($id) $model->setStatus($id, 'hoat_dong');
        header("Location: khachhang.php");
        exit;

    // chính là case mặc định: danh sách khách hàng, mỗi khách có danh sách xe, mỗi xe có nút hóa đơn
    default:
        $list_khachhang = $model->getAll();
        foreach ($list_khachhang as &$kh) {
            $kh['ds_xe'] = $model->getXeByKhachHang($kh['MaKH']);
        }
        unset($kh);
        $content = __DIR__ . '/../views/khachhang/list.php';
        include __DIR__ . '/../views/khachhang/layout.php';
        break;
}
?>