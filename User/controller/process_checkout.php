<?php
// Đảm bảo đồng bộ session_name cho USER
if (session_status() === PHP_SESSION_NONE) {
    session_name('USERSESSID');
    session_start();
}
$cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];

date_default_timezone_set('Asia/Ho_Chi_Minh'); // Đảm bảo giờ đúng với Việt Nam

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

        // Lấy thông tin bảo hành từ bảng phutungxemay
        $sql_pt = "SELECT ThoiGianBaoHanhDinhKy, SoLanBaoHanhToiDa FROM phutungxemay WHERE MaSP = ?";
        $stmt_pt = mysqli_prepare($conn, $sql_pt);
        mysqli_stmt_bind_param($stmt_pt, 'i', $masp);
        mysqli_stmt_execute($stmt_pt);
        $result_pt = mysqli_stmt_get_result($stmt_pt);
        $phutung = mysqli_fetch_assoc($result_pt);

        // Tính ngày bắt đầu bảo hành (thời điểm đặt hàng, có giờ phút giây chính xác)
        $ngayBatDauBH = date('Y-m-d H:i:s');
        // Tính số ngày bảo hành từ ThoiGianBaoHanhDinhKy
        $soNgayBH = 0;
        if ($phutung && isset($phutung['ThoiGianBaoHanhDinhKy'])) {
            if (preg_match('/(\d+)/', $phutung['ThoiGianBaoHanhDinhKy'], $matches)) {
                $soNgayBH = (int)$matches[1];
            }
        }
        // Ngày kết thúc bảo hành = ngày bắt đầu + số ngày bảo hành
        $ngayKetThucBH = date('Y-m-d H:i:s', strtotime("+$soNgayBH days", strtotime($ngayBatDauBH)));
        // Số lần bảo hành tối đa
        $soLanBaoHanhToiDa = $phutung['SoLanBaoHanhToiDa'] ?? 0;

        // Thêm vào bảng chi tiết hóa đơn (đã đồng bộ đủ các trường)
        $sql_ct = "INSERT INTO chitiethoadon (hoadon_MaHD, phutungxemay_MaSP, GiaTien, SoLuong, NgayBDBH, NgayKTBH, SoLanDaBaoHanh) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt_ct = mysqli_prepare($conn, $sql_ct);
        mysqli_stmt_bind_param($stmt_ct, 'iidisss', $inserted_mahd, $masp, $gia, $soLuong, $ngayBatDauBH, $ngayKetThucBH, $soLanBaoHanhToiDa);
        mysqli_stmt_execute($stmt_ct);
    }

    // Lưu đầy đủ đơn hàng vào session (nếu muốn show lại thông tin đơn hàng sau khi đặt)
    $order = [
        'cart' => $cart,
        'fullname' => $fullname,
        'phone' => $phone,
        'note' => $note,
        'total' => $tongtien,
        'date' => date('Y-m-d H:i:s'),
        'mahd' => $inserted_mahd
    ];
    $_SESSION['order'] = $order;

    unset($_SESSION['cart']);
    mysqli_close($conn);

    // Chuyển hướng về trang danh sách đơn đã mua hoặc cảm ơn
    header('Location: ../listphutungdamua.php');
    exit;

} else {
    header('Location: ../checkout.php');
    exit;
}
?>