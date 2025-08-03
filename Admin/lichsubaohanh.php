<?php
$requiredRole = 'admin';
include __DIR__ . '/auth_check.php';

require_once __DIR__ . '/db.php';
require_once __DIR__ . '/controllers/LichSuBaoHanhController.php';

$pdo = connectDB();
$controller = new LichSuBaoHanhController($pdo);

$action = $_GET['action'] ?? 'index';

// Các action sẽ trả về nội dung view qua return (controller đã dùng ob_start...)
switch ($action) {
    case 'add':
        $content = $controller->add();
        break;
    case 'edit':
        $content = $controller->edit();
        break;
    case 'delete':
        $controller->delete();
        exit;
    case 'ajaxByXe':
        $controller->ajaxByXe();
        exit;
    default:
        $content = $controller->index();
        break;
}

include __DIR__ . '/views/lichsubaohanh/layout.php';
?>