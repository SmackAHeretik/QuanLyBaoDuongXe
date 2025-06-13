<?php
require_once '../model/userModel.php';

$userModel = new UserModel();

// Đăng ký
if (isset($_POST['register'])) {
    $TenKH = htmlspecialchars($_POST['TenKH'] ?? '');
    $Email = htmlspecialchars($_POST['Email'] ?? '');
    $MatKhau = htmlspecialchars($_POST['MatKhau'] ?? '');
    $SDT = htmlspecialchars($_POST['SDT'] ?? '');

    try {
        if ($userModel->existsByTenKH($TenKH)) {
            echo "<script>alert('Tên khách hàng đã tồn tại!'); window.location.href='../login.php';</script>";
            exit();
        }

        if ($userModel->existsByEmail($Email)) {
            echo "<script>alert('Email đã tồn tại!'); window.location.href='../login.php';</script>";
            exit();
        }

        // Mã hóa mật khẩu trước khi lưu
        $MatKhauHash = password_hash($MatKhau, PASSWORD_DEFAULT);
        $userModel->insert($TenKH, $Email, $MatKhauHash, $SDT);

        echo "<script>alert('Đăng ký thành công!'); window.location.href='../login.php';</script>";
        exit();
    } catch (Exception $e) {
        error_log($e->getMessage(), 3, 'errors.log');
        echo "<script>alert('Có lỗi xảy ra, vui lòng thử lại sau!'); window.location.href='../login.php';</script>";
        exit();
    }
}

// Đăng nhập
else if (isset($_POST['login'])) {
    $Email = htmlspecialchars($_POST['Email'] ?? '');
    $MatKhau = htmlspecialchars($_POST['MatKhau'] ?? '');

    try {
        $result = $userModel->findByEmail($Email);
        if ($result) {
            // Sử dụng password_verify để kiểm tra mật khẩu
            if (password_verify($MatKhau, $result['MatKhau'])) {
                // Khởi tạo session nếu chưa có
                if (session_status() === PHP_SESSION_NONE) {
                    session_start();
                }

                // Thiết lập session
                $_SESSION['TenKH'] = $result['TenKH'];
                $_SESSION['MaKH'] = $result['MaKH'];
                echo "<script>alert('Đăng nhập thành công!'); window.location.href='../index.php';</script>";
                exit();
            } else {
                echo "<script>alert('Mật khẩu không đúng!'); window.location.href='../login.php';</script>";
                exit();
            }
        } else {
            echo "<script>alert('Email không tồn tại!'); window.location.href='../login.php';</script>";
            exit();
        }
    } catch (Exception $e) {
        error_log($e->getMessage(), 3, 'errors.log');
        echo "<script>alert('Có lỗi xảy ra, vui lòng thử lại sau!'); window.location.href='../login.php';</script>";
        exit();
    }
}
?>