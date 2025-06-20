<?php
require_once '../utils/ConnectDb.php';
require_once '../model/LichLamViecModel.php';
require_once '../model/NhanVienModel.php';

header('Content-Type: application/json');
$ngay = $_GET['ngay'] ?? '';

if (!$ngay) {
  echo json_encode([]);
  exit;
}

$db = (new ConnectDb())->connect();
$lichlamviecModel = new LichLamViecModel($db);
$nvModel = new NhanVienModel($db);

// Lấy tất cả ca làm việc hợp lệ của ngày
$cas = $lichlamviecModel->getCaLamViecByNgay($ngay);

foreach ($cas as &$ca) {
  $nhanviens = $nvModel->getNhanVienConTrong($ngay, $ca['ThoiGianCa']);
  $ca['disabled'] = count($nhanviens) == 0;
}
echo json_encode($cas);
?>