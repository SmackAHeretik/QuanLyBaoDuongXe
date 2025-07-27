<?php
require_once __DIR__ . '/../vendor/autoload.php'; // Sửa đường dẫn autoload nếu cần (tùy cấu trúc thư mục)

use PayOS\PayOS;

// Thông tin PayOS của bạn (NHỚ thay các giá trị thật)
$payOSClientId = 'b450480a-1b62-4c82-929e-f0b96dffd64e';
$payOSApiKey = 'eac0ec63-e14a-4812-8649-dc772d6502c8';
$payOSChecksumKey = '82c58e511a94abe79baccf2879ed6a555e97f6b7e9fce267f790d0250df4d53e';

// Địa chỉ domain dự án của bạn (CHÚ Ý: không có port 3030, phải đúng đường dẫn thực tế)
$YOUR_DOMAIN = 'http://localhost/QuanLyBaoDuongXe/Admin';

// Lấy thông tin từ POST (hoặc gán thử giá trị test để kiểm tra)
$mahd = $_POST['mahd'] ?? 20;
$tongtien = $_POST['tongtien'] ?? 1500000;

// Xử lý thanh toán QR
if ($mahd && $tongtien && !isset($_POST['tienmat'])) {
    $data = [
        "orderCode" => intval($mahd),
        "amount" => intval($tongtien),
        "description" => "Thanh toán hóa đơn #$mahd",
        "items" => [
            [
                'name' => "Hóa đơn #$mahd",
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
        echo "<h2>Lỗi tạo link thanh toán:</h2>";
        echo "<p>" . $e->getMessage() . "</p>";
    }
} else {
    echo "Thiếu thông tin hóa đơn hoặc số tiền!";
}
?>