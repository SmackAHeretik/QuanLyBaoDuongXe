<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['user'])) {
    header('Location: signin.php');
    exit();
}

/**
 * Phân quyền nâng cao:
 * - Nếu trang chỉ dành cho admin, ở đầu file cần khai báo:
 *     $requiredRole = 'admin';
 *     include 'auth_check.php';
 * - Nếu không khai báo $requiredRole thì chỉ cần đăng nhập là vào được.
 */
if (isset($requiredRole)) {
    $role = $_SESSION['user']['role'] ?? '';
    if ($role !== $requiredRole) {
        // Không đủ quyền, thông báo popup rồi về trang chủ
        echo "<script>
            alert('Bạn không có quyền truy cập trang này!');
            window.location.href = 'index.php';
        </script>";
        exit();
    }
}
?>