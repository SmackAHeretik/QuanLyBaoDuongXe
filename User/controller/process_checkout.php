<?php
session_start();
$cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($cart)) {
    $fullname = trim($_POST['fullname'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $note = trim($_POST['note'] ?? '');

    // Validate cơ bản
    $errors = [];
    if ($fullname === '') $errors[] = 'Vui lòng nhập họ tên';
    if ($phone === '') $errors[] = 'Vui lòng nhập số điện thoại';

    if (count($errors) > 0) {
        $_SESSION['checkout_errors'] = $errors;
        header('Location: ../checkout.php');
        exit;
    }

    // Kết nối database
    $conn = mysqli_connect('localhost', 'root', '', 'quanlybaoduongxe');
    if (!$conn) {
        die('Không kết nối được CSDL');
    }
    mysqli_set_charset($conn, 'utf8mb4');

    // Ngày đặt hàng
    $ngaydat = date('Y-m-d');

    // Lưu từng sản phẩm trong cart vào bảng hoadon (NHỚ: mã xe và mã phụ tùng phải có)
    foreach ($cart as $item) {
        $tongtien = $item['DonGia'] * $item['qty'];
        $masp = $item['MaSP'];
        $maxe = isset($item['MaXE']) && $item['MaXE'] !== '' ? $item['MaXE'] : null; // có thể null nếu không chọn xe

        $sql = "INSERT INTO hoadon (TongTien, Ngay, TrangThai, xemay_MaXE, phutungxemay_MaSP) 
                VALUES (?, ?, 'cho_thanh_toan', ?, ?)";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, 'dsii', $tongtien, $ngaydat, $maxe, $masp);
        mysqli_stmt_execute($stmt);
    }

    // Xóa giỏ hàng sau khi đặt thành công
    unset($_SESSION['cart']);
    mysqli_close($conn);

    // Hiện popup và về trang chủ
    echo "<script>
        alert('Đặt hàng thành công!');
        window.location.href = '../index.php';
    </script>";
    exit;

} else {
    header('Location: ../checkout.php');
    exit;
}
?>