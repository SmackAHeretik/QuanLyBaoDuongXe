<?php
include_once '../utils/ConnectDb.php';
include_once '../model/NhanVienModel.php';

$ngay = $_GET['ngay'] ?? '';
$ca = $_GET['ca'] ?? '';

$db = (new ConnectDb())->connect();
$nvModel = new NhanVienModel($db);
$nhanviens = $nvModel->getNhanVienConTrong($ngay, $ca);

if ($nhanviens && count($nhanviens) > 0) {
    $randomIdx = array_rand($nhanviens);
    $nv = $nhanviens[$randomIdx];
    echo json_encode([
        'MaNV' => $nv['MaNV'],
        'TenNV' => $nv['TenNV']
    ]);
} else {
    echo json_encode([]);
}
?>