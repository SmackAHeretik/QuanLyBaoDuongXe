<?php
require_once '../vendor/autoload.php';
use PayOS\PayOS;

$mahd = intval($_POST['mahd'] ?? 0);
$tongtien = intval($_POST['tongtien'] ?? 0);

if ($mahd <= 0 || $tongtien <= 0) {
    http_response_code(400);
    echo json_encode(['error' => 'Dữ liệu không hợp lệ']);
    exit;
}

// Thay các thông tin key dưới bằng key của bạn
$payOSClientId = 'b450480a-1b62-4c82-929e-f0b96dffd64e';
$payOSApiKey = 'eac0ec63-e14a-4812-8649-dc772d6502c8';
$payOSChecksumKey = '82c58e511a94abe79baccf2879ed6a555e97f6b7e9fce267f790d0250df4d53e';
$payOS = new PayOS($payOSClientId, $payOSApiKey, $payOSChecksumKey);

$YOUR_DOMAIN = 'http://localhost:3030'; // Sửa nếu deploy lên server khác

$data = [
    "orderCode" => $mahd,
    "amount" => $tongtien,
    "description" => "Thanh toán hóa đơn #$mahd",
    "returnUrl" => $YOUR_DOMAIN . "/Admin/payos_success.php?mahd=$mahd",
    "cancelUrl" => $YOUR_DOMAIN . "/Admin/payos_cancel.php?mahd=$mahd"
];

try {
    $response = $payOS->createPaymentLink($data);
    echo json_encode(['checkoutUrl' => $response['checkoutUrl']]);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}