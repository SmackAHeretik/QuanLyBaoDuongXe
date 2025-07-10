<?php
// ===============================
// PHÂN QUYỀN: CHỈ ADMIN QUẢN LÝ KHÁCH HÀNG
// ===============================
$requiredRole = 'admin';
include __DIR__ . '/auth_check.php';

require_once __DIR__ . '/db.php';
require_once __DIR__ . '/controllers/khachhang_controller.php';
// ... các logic khác ...
?>