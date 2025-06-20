<?php
session_start();
$cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($cart)) {
    $fullname = trim($_POST['fullname'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $address = trim($_POST['address'] ?? '');
    $note = trim($_POST['note'] ?? '');

    // Validate cơ bản
    $errors = [];
    if ($fullname === '') $errors[] = 'Vui lòng nhập họ tên';
    if ($phone === '') $errors[] = 'Vui lòng nhập số điện thoại';
    if ($address === '') $errors[] = 'Vui lòng nhập địa chỉ giao hàng';

    if (count($errors) > 0) {
        // Nếu có lỗi, lưu vào session và quay lại
        $_SESSION['checkout_errors'] = $errors;
        header('Location: ../checkout.php');
        exit;
    }

    // Kết nối database (bạn cần chỉnh lại thông tin kết nối)
    $conn = mysqli_connect('localhost', 'root', '', 'ten_cua_database');
    if (!$conn) {
        die('Không kết nối được CSDL');
    }
    mysqli_set_charset($conn, 'utf8mb4');

    // Lưu đơn hàng vào bảng orders (giả định tên bảng)
    $ngaydat = date('Y-m-d H:i:s');
    $sql_order = "INSERT INTO orders (fullname, phone, address, note, order_date, total) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql_order);
    mysqli_stmt_bind_param($stmt, 'sssssd', $fullname, $phone, $address, $note, $ngaydat, $total);

    // Tính tổng tiền lại cho chắc chắn
    $total = 0;
    foreach ($cart as $item) {
        $total += $item['DonGia'] * $item['qty'];
    }

    if (mysqli_stmt_execute($stmt)) {
        $order_id = mysqli_insert_id($conn);

        // Lưu từng sản phẩm vào bảng orders_detail (giả định tên bảng)
        $sql_detail = "INSERT INTO orders_detail (order_id, MaSP, TenSP, DonGia, qty) VALUES (?, ?, ?, ?, ?)";
        $stmt_detail = mysqli_prepare($conn, $sql_detail);

        foreach ($cart as $item) {
            mysqli_stmt_bind_param($stmt_detail, 'iisdi', $order_id, $item['MaSP'], $item['TenSP'], $item['DonGia'], $item['qty']);
            mysqli_stmt_execute($stmt_detail);
        }

        // Xóa giỏ hàng sau khi đặt thành công
        unset($_SESSION['cart']);
        mysqli_close($conn);

        // Chuyển hướng sang trang cảm ơn hoặc thông báo thành công
        header('Location: ../checkout_success.php');
        exit;
    } else {
        mysqli_close($conn);
        die('Đặt hàng thất bại, vui lòng thử lại.');
    }
} else {
    // Không có dữ liệu post hoặc giỏ hàng trống
    header('Location: ../checkout.php');
    exit;
}
?>