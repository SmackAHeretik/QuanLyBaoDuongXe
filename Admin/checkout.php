<?php
require_once __DIR__ . '/../vendor/autoload.php'; // Đường dẫn autoload Composer, giữ nguyên nếu đúng

use PayOS\PayOS;

// Thông tin PayOS của bạn
$payOSClientId = 'b450480a-1b62-4c82-929e-f0b96dffd64e';
$payOSApiKey = 'eac0ec63-e14a-4812-8649-dc772d6502c8';
$payOSChecksumKey = '82c58e511a94abe79baccf2879ed6a555e97f6b7e9fce267f790d0250df4d53e';

// Địa chỉ domain thực tế, KHÔNG có port 3030
$YOUR_DOMAIN = 'http://localhost/QuanLyBaoDuongXe/Admin';

// Lấy thông tin từ POST hoặc GET (chỉ ví dụ, bạn kiểm soát đầu vào theo nhu cầu thực tế)
$tongtien = $_POST['tongtien'] ?? $_GET['tongtien'] ?? 1500000;
$description = $_POST['description'] ?? $_GET['description'] ?? "Thanh toán hóa đơn";

// TẠO orderCode duy nhất mỗi lần thanh toán (dùng time hoặc uniqid, KHÔNG lấy từ $mahd hay số hóa đơn đã có)
$orderCode = time(); // Hoặc uniqid('', true); nếu muốn chuỗi độc nhất

// Xử lý thanh toán QR
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
} else {
    echo "Thiếu thông tin số tiền!";
}
?>