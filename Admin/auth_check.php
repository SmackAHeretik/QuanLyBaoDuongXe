<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['user'])) {
    header('Location: signin.php');
    exit();
}

if (!isset($requiredRole)) {
    return;
}

$role = $_SESSION['user']['role'] ?? '';
$staffRole = $_SESSION['user']['data']['Roles'] ?? '';

if ($requiredRole === 'admin') {
    if ($role !== 'admin') {
        echo "<script>
            alert('Bạn không có quyền truy cập trang này!');
            window.location.href = 'index.php';
        </script>";
        exit();
    }
}
if ($requiredRole === 'ketoan') {
    // Admin luôn được vào
    if ($role === 'admin') return;
    // Kế toán được vào
    if ($role !== 'staff' || $staffRole !== 'Nhân viên kế toán') {
        echo "<script>
            alert('Bạn không có quyền truy cập trang này!');
            window.location.href = 'index.php';
        </script>";
        exit();
    }
}
if ($requiredRole === 'thosuaxe') {
    if ($role === 'admin') return;
    if ($role !== 'staff' || $staffRole !== 'Thợ sửa xe') {
        echo "<script>
            alert('Bạn không có quyền truy cập trang này!');
            window.location.href = 'index.php';
        </script>";
        exit();
    }
}
?>