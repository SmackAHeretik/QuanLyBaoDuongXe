<?php
$mahd = $_GET['mahd'] ?? '';

if ($mahd) {
    require_once __DIR__ . '/db.php';
    require_once __DIR__ . '/models/HoaDonModel.php';
    $hoadonModel = new HoaDonModel(connectDB());
    $hoadonModel->updateTrangThai($mahd, 'da_thanh_toan');
}

// Hiển thị alert cảm ơn rồi về trang khachhang.php
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Thanh toán thành công</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
<script>
document.addEventListener('DOMContentLoaded', function() {
    Swal.fire({
        icon: 'success',
        title: 'Cảm ơn khách hàng',
        text: 'Thanh toán thành công!',
        confirmButtonText: 'OK'
    }).then(() => {
        window.location.href = 'khachhang.php';
    });
});
</script>
</body>
</html>