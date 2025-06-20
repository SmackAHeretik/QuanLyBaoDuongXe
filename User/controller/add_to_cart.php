<?php
session_start();

// Lấy thông tin sản phẩm từ form gửi lên (không cần DB)
$maSP    = $_GET['MaSP']    ?? $_POST['MaSP']    ?? null;
$tenSP   = $_GET['TenSP']   ?? $_POST['TenSP']   ?? null;
$donGia  = $_GET['DonGia']  ?? $_POST['DonGia']  ?? null;
$hinhAnh = $_GET['HinhAnh'] ?? $_POST['HinhAnh'] ?? null;

if (!$maSP) {
    header("Location: ../cart.php");
    exit;
}

// Nếu chưa có giỏ hàng thì tạo giỏ hàng
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Nếu sản phẩm đã có trong giỏ, tăng số lượng
if (isset($_SESSION['cart'][$maSP])) {
    $_SESSION['cart'][$maSP]['qty'] += 1;
} else {
    $_SESSION['cart'][$maSP] = [
        'MaSP'    => $maSP,
        'TenSP'   => $tenSP,
        'DonGia'  => $donGia,
        'HinhAnh' => $hinhAnh,
        'qty'     => 1
    ];
}

// Chuyển về trang giỏ hàng
header('Location: ../cart.php');
exit;
?>