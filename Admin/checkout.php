<?php
require_once __DIR__ . '/db.php';
require_once __DIR__ . '/models/HoaDonModel.php';
require_once __DIR__ . '/../vendor/autoload.php'; // Đường dẫn autoload Composer, giữ nguyên nếu đúng

use PayOS\PayOS;

// Thông tin PayOS của bạn (nếu dùng QR)
$payOSClientId = 'b450480a-1b62-4c82-929e-f0b96dffd64e';
$payOSApiKey = 'eac0ec63-e14a-4812-8649-dc772d6502c8';
$payOSChecksumKey = '82c58e511a94abe79baccf2879ed6a555e97f6b7e9fce267f790d0250df4d53e';

// Địa chỉ domain thực tế, KHÔNG có port 3030
$YOUR_DOMAIN = 'http://localhost/QuanLyBaoDuongXe/Admin';

$mahd = $_POST['mahd'] ?? $_GET['mahd'] ?? null;
$tongtien = $_POST['tongtien'] ?? $_GET['tongtien'] ?? null;
$description = $_POST['description'] ?? $_GET['description'] ?? "Thanh toán hóa đơn";
$orderCode = time(); // Hoặc uniqid('', true);

// Nếu là thanh toán tiền mặt
if (isset($_POST['tienmat']) && $mahd && $tongtien) {
    $hoadonModel = new HoaDonModel(connectDB());
    $hoadonModel->updateTrangThai($mahd, 'da_thanh_toan'); // cập nhật trạng thái

    ?>
    <!DOCTYPE html>
    <html>
    <head>
        <meta charset="utf-8">
        <title>Thanh toán tiền mặt</title>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <style>
            body { font-family: Arial, sans-serif; }
        </style>
    </head>
    <body>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        Swal.fire({
            icon: 'success',
            title: 'Thanh toán tiền mặt thành công!',
            html: `<b>Mã HĐ:</b> <?= htmlspecialchars($mahd) ?><br>
                   <b>Số tiền:</b> <?= number_format($tongtien, 0, ',', '.') ?> VNĐ`,
            confirmButtonText: 'Xem chi tiết hóa đơn'
        }).then(() => {
            window.location.href = 'chitiethoadon.php?hoadon_MaHD=<?= urlencode($mahd) ?>';
        });
    });
    </script>
    </body>
    </html>
    <?php
    exit;
}

// Nếu là thanh toán QR (PayOS)
if ($tongtien && !isset($_POST['tienmat'])) {
    $data = [
        "orderCode" => $orderCode,
        "amount" => intval($tongtien),
        "description" => $description,
        "items" => [
            [
                'name' => $description,
                'price' => intval($tongtien),
                'quantity' => 1
            ]
        ],
        "returnUrl" => $YOUR_DOMAIN . "/success.html",
        "cancelUrl" => $YOUR_DOMAIN . "/cancel.html",
    ];

    try {
        $payOS = new PayOS(
            clientId: $payOSClientId,
            apiKey: $payOSApiKey,
            checksumKey: $payOSChecksumKey
        );
        $response = $payOS->createPaymentLink($data);
        header('Location: ' . $response['checkoutUrl']);
        exit;
    } catch (Exception $e) {
        echo "<h2 style='color:red'>Lỗi tạo link thanh toán:</h2>";
        echo "<p>" . htmlspecialchars($e->getMessage()) . "</p>";
        echo "<p>Mã đơn đã gửi đi: <b>$orderCode</b></p>";
    }
} else if (!isset($_POST['tienmat'])) {
    echo "<h2 style='color:red'>Thiếu thông tin số tiền!</h2>";
}
?>