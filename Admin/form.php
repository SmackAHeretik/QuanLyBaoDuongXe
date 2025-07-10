<?php
// ===============================
// PHÂN QUYỀN: CHỈ ADMIN ĐƯỢC QUẢN LÝ PHỤ TÙNG
// ===============================
$requiredRole = 'admin';
include __DIR__ . '/auth_check.php';

session_start();
require_once __DIR__ . '/db.php';
require_once __DIR__ . '/controllers/phutungxemayController.php';

$pdo = connectDB();
$controller = new PhuTungXeMayController($pdo);

$action = $_GET['action'] ?? 'list';
switch ($action) {
    case 'add':
        $controller->add();
        break;
    case 'edit':
        $controller->edit();
        break;
    case 'delete':
        $controller->delete();
        break;
    case 'toggleStatus':
        $controller->toggleStatus();
        break;
    default:
        $controller->list();
}
?>