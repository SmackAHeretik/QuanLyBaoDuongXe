<?php
require_once '../utils/ConnectDb.php';
require_once '../model/NhanVienModel.php';

header('Content-Type: application/json');
$ngay = $_GET['ngay'] ?? '';
$ca = $_GET['ca'] ?? '';

$db = (new ConnectDb())->connect();
$nvModel = new NhanVienModel($db);
$nhanviens = $nvModel->getNhanVienConTrong($ngay, $ca);

if ($nhanviens && count($nhanviens) > 0) {
  $randomIdx = array_rand($nhanviens);
  $nhanvien = $nhanviens[$randomIdx];
  echo json_encode(['MaNV' => $nhanvien['MaNV'], 'TenNV' => $nhanvien['TenNV']]);
} else {
  echo json_encode(null);
}
?>