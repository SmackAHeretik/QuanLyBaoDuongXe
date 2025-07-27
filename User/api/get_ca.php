<?php
require_once '../utils/ConnectDb.php';
require_once '../model/LichLamViecModel.php';
require_once '../model/PhanCongLichLamViecModel.php';
require_once '../model/LichHenModel.php';

header('Content-Type: application/json');
$ngay = $_GET['ngay'] ?? '';

if (!$ngay) {
    echo json_encode([]);
    exit;
}

$db = (new ConnectDb())->connect();
$lichlamviecModel = new LichLamViecModel($db);
$phanCongModel = new PhanCongLichLamViecModel($db);
$lichHenModel = new LichHenModel($db);

$cas = $lichlamviecModel->getCaLamViecByNgay($ngay);

$result = [];
foreach ($cas as $ca) {
    $MaLLV = $ca['MaLLV'];
    $soTho = count($phanCongModel->getNhanVienByMaLLV($MaLLV));
    $soLichHen = $lichHenModel->countLichHenByLLV($MaLLV);

    $result[] = [
        'MaLLV'      => $MaLLV,
        'ThoiGianCa' => $ca['ThoiGianCa'],
        'disabled'   => ($soLichHen >= $soTho)
    ];
}

echo json_encode($result);
?>