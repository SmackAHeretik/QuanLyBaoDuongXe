<?php
require_once '../utils/ConnectDb.php';
require_once '../model/NhanVienModel.php';

header('Content-Type: application/json');
$ngay = $_GET['ngay'] ?? '';
$ca = $_GET['ca'] ?? '';

if (!$ngay || !$ca) {
    echo json_encode([]);
    exit;
}

$db = (new ConnectDb())->connect();
$nvModel = new NhanVienModel($db);

// Lấy danh sách nhân viên còn trống ca này
$nhanviensConTrong = $nvModel->getNhanVienConTrong($ngay, $ca);

if (!empty($nhanviensConTrong)) {
    $randomIdx = array_rand($nhanviensConTrong);
    $nv = $nhanviensConTrong[$randomIdx];
    echo json_encode([
        'MaNV' => $nv['MaNV'],
        'TenNV' => $nv['TenNV']
    ]);
} else {
    echo json_encode([]);
}
?>