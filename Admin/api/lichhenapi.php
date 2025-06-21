<?php
require_once __DIR__ . '/../models/LichHenModel.php';
$db = connectDB();

// Lấy xe theo khách hàng
if (isset($_GET['action']) && $_GET['action'] == 'get_xemay_by_khachhang' && isset($_GET['MaKH'])) {
    $model = new XeModel($db);
    $data = $model->getByKhachHang((int)$_GET['MaKH']);
    echo json_encode($data); exit;
}

// Lấy thông tin xe máy
if (isset($_GET['action']) && $_GET['action'] == 'get_thongtin_xemay' && isset($_GET['MaXE'])) {
    $model = new XeModel($db);
    $data = $model->getById((int)$_GET['MaXE']);
    echo json_encode($data); exit;
}

// Xử lý thêm lịch hẹn từ AJAX POST
if ($_SERVER['REQUEST_METHOD']=='POST' && isset($_POST['action']) && $_POST['action']=='add_lichhen') {
    $model = new LichHenModel($db);
    $data = [
        'TenXe' => $_POST['TenXe'] ?? '',
        'LoaiXe' => $_POST['LoaiXe'] ?? '',
        'PhanKhuc' => $_POST['PhanKhuc'] ?? '',
        'NgayHen' => $_POST['NgayHen'] ?? '',
        'ThoiGianCa' => $_POST['ThoiGianCa'] ?? '',
        'TrangThai' => $_POST['TrangThai'] ?? '',
        'MoTaLyDo' => $_POST['MoTaLyDo'] ?? '',
        'nhanvien_MaNV' => $_POST['nhanvien_MaNV'] ?? '',
        'khachhang_MaKH' => $_POST['khachhang_MaKH'] ?? '',
        'xemay_MaXE' => $_POST['xemay_MaXE'] ?? ''
    ];
    $ok = $model->insert($data);
    if($ok){
        echo json_encode(['status'=>'success']);
    }else{
        echo json_encode(['status'=>'fail','msg'=>'Lỗi thêm dữ liệu']);
    }
    exit;
}
?>