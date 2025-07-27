<?php
require_once 'db.php';

$mahd = $_GET['id'] ?? '';
if (!$mahd || !is_numeric($mahd)) {
    echo "Dữ liệu không hợp lệ!"; exit;
}

$db = connectDB();

// Kiểm tra trạng thái hóa đơn hiện tại
$stmt = $db->prepare("SELECT TrangThai FROM hoadon WHERE MaHD = ?");
$stmt->execute([$mahd]);
$hd = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$hd) {
    echo "Không tìm thấy hóa đơn!"; exit;
}

if ($hd['TrangThai'] == 'da_thanh_toan') {
    echo "Hóa đơn đã thanh toán trước đó!"; exit;
}
if ($hd['TrangThai'] == 'huy') {
    echo "Hóa đơn đã bị hủy!"; exit;
}

// Chuyển trạng thái sang đã thanh toán
$stmt = $db->prepare("UPDATE hoadon SET TrangThai = 'da_thanh_toan' WHERE MaHD = ?");
$stmt->execute([$mahd]);

echo "<div class='alert alert-success'>Thanh toán thành công!</div>";
echo "<meta http-equiv='refresh' content='1;url=khachhang.php'>";
?>