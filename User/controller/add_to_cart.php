<?php
session_start();

$maSP    = $_GET['MaSP']    ?? $_POST['MaSP']    ?? null;
$maXE    = $_GET['MaXE']    ?? $_POST['MaXE']    ?? null;
$tenXE   = $_GET['TenXE']   ?? $_POST['TenXE']   ?? null;

if (!$maSP) {
    header("Location: ../cart.php");
    exit;
}

// Kết nối DB lấy sản phẩm
$conn = mysqli_connect('localhost', 'root', '', 'quanlybaoduongxe');
mysqli_set_charset($conn, 'utf8mb4');
$sql = "SELECT * FROM phutungxemay WHERE MaSP = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $maSP);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$product = mysqli_fetch_assoc($result);
mysqli_close($conn);

if (!$product) {
    header("Location: ../cart.php");
    exit;
}

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Sửa chỗ này: chỉ lấy tên file ảnh
$hinhAnh = !empty($product['HinhAnh']) ? $product['HinhAnh'] : 'no-image.png';

if (isset($_SESSION['cart'][$maSP])) {
    $_SESSION['cart'][$maSP]['qty'] += 1;
    if ($maXE) {
        $_SESSION['cart'][$maSP]['MaXE'] = $maXE;
        $_SESSION['cart'][$maSP]['TenXE'] = $tenXE;
    }
} else {
    $_SESSION['cart'][$maSP] = [
        'MaSP'    => $product['MaSP'],
        'TenSP'   => $product['TenSP'],
        'DonGia'  => $product['DonGia'],
        'HinhAnh' => $hinhAnh,
        'qty'     => 1,
        'MaXE'    => $maXE,
        'TenXE'   => $tenXE
    ];
}

header('Location: ../cart.php');
exit;
?>