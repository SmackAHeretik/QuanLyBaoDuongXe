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

    $ngaydat = date('Y-m-d');
    // TÍNH TỔNG TIỀN TẤT CẢ SẢN PHẨM
    $tongtien = 0;
    foreach ($cart as $item) {
        $tongtien += $item['DonGia'] * $item['qty'];
    }
    // Lấy mã xe của sản phẩm đầu tiên (hoặc cho phép khách chọn xe ở checkout)
    $maxe = null;
    foreach ($cart as $item) {
        if (!empty($item['MaXE'])) {
            $maxe = $item['MaXE'];
            break;
        }
    }
    // 1. Tạo hóa đơn duy nhất
    $sql = "INSERT INTO hoadon (TongTien, Ngay, TrangThai, xemay_MaXE) VALUES (?, ?, 'cho_thanh_toan', ?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 'dsi', $tongtien, $ngaydat, $maxe);
    mysqli_stmt_execute($stmt);
    $inserted_mahd = mysqli_insert_id($conn);

    // 2. Lặp qua giỏ hàng, thêm từng phụ tùng vào bảng chi tiết hóa đơn
    foreach ($cart as $item) {
        $masp = $item['MaSP'];
        $gia = $item['DonGia'];
        $soLuong = $item['qty'];

        $sql_ct = "INSERT INTO chitiethoadon (hoadon_MaHD, phutungxemay_MaSP, GiaTien, SoLuong) VALUES (?, ?, ?, ?)";
        $stmt_ct = mysqli_prepare($conn, $sql_ct);
        mysqli_stmt_bind_param($stmt_ct, 'iidi', $inserted_mahd, $masp, $gia, $soLuong);
        mysqli_stmt_execute($stmt_ct);
    }

    unset($_SESSION['cart']);
    mysqli_close($conn);

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