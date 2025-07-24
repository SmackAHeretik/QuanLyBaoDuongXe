<?php
// ===============================
// PHÂN QUYỀN: CHỈ ADMIN VÀ KẾ TOÁN ĐƯỢC QUẢN LÝ KHÁCH HÀNG
// ===============================
$requiredRole = 'ketoan'; // đổi từ 'admin' sang 'ketoan'
include __DIR__ . '/auth_check.php';

require_once __DIR__ . '/db.php';
require_once __DIR__ . '/controllers/khachhang_controller.php';
// ... các logic khác ...
?>