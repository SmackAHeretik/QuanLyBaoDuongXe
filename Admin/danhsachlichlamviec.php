<?php
// ===============================
// PHÂN QUYỀN: Chỉ admin và kế toán được xem/quản lý lịch làm việc
// ===============================
$requiredRole = 'ketoan'; // hoặc 'admin', tuỳ config hệ thống
include __DIR__ . '/auth_check.php';

require_once __DIR__ . '/controllers/LichLamViecController.php';
$action = $_GET['action'] ?? 'list';
$ctrl = new LichLamViecController();

ob_start();
if (method_exists($ctrl, $action)) {
    $ctrl->$action();
} else {
    echo "<div class='p-4 text-danger'>Không tìm thấy chức năng <b>$action</b></div>";
}
$mainContent = ob_get_clean();
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <title>Quản lý Lịch làm việc</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <link href="img/favicon.ico" rel="icon">
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
</head>
<body>
    <div class="container-xxl position-relative bg-white d-flex p-0">
        <?php include('./layouts/sidebar.php') ?>
        <div class="content">
            <?php include('./layouts/navbar.php') ?>
            <?= $mainContent ?>
        </div>
    </div>
    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/main.js"></script>
</body>
</html>