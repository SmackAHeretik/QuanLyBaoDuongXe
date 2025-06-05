<?php
session_start();
include '../model/userModel.php';
include '../utils/ConnectDb.php';

ini_set('display_errors', 1);
error_reporting(E_ALL);

$userModel = new UserModel();

// Đăng ký
if (isset($_POST['register'])) {
    $TenKH = $_POST['TenKH'] ?? '';
    $Email = $_POST['Email'] ?? '';
    $MatKhau = $_POST['MatKhau'] ?? '';
    $SDT = $_POST['SDT'] ?? '';

    if ($userModel->existsByTenKH($TenKH)) {
        echo "<script>alert('Tên khách hàng đã tồn tại!'); window.location.href='../login.php';</script>";
        exit();
    }

    if ($userModel->existsByEmail($Email)) {
        echo "<script>alert('Email đã tồn tại!'); window.location.href='../login.php';</script>";
        exit();
    }

    $MatKhauHash = password_hash($MatKhau, PASSWORD_DEFAULT);
    $userModel->insert($TenKH, $Email, $MatKhauHash, $SDT);

    echo "<script>alert('Đăng ký thành công!'); window.location.href='../login.php';</script>";
    exit();
}

// Đăng nhập
else if (isset($_POST['login'])) {
    $Email = $_POST['Email'] ?? '';
    $MatKhau = $_POST['MatKhau'] ?? '';

    $result = $userModel->findByEmail($Email);
    if ($result && password_verify($MatKhau, $result['MatKhau'])) {
        $_SESSION['MaKH'] = $result['MaKH'];
        $_SESSION['TenKH'] = $result['TenKH'];
        $_SESSION['Email'] = $result['Email'];
        $_SESSION['SDT'] = $result['SDT'];
        header("Location: ../index.php");
        exit();
    } else {
        echo "<script>alert('Email hoặc mật khẩu không đúng!'); window.location.href='../login.php';</script>";
        exit();
    }
}

// Cập nhật thông tin
else if (isset($_POST['update'])) {
    $MaKH = $_SESSION['MaKH'];
    $TenKH = $_POST['TenKH'] ?? '';
    $Email = $_POST['Email'] ?? '';
    $SDT = $_POST['SDT'] ?? '';

    if ($userModel->update($MaKH, $TenKH, $Email, $SDT)) {
        $_SESSION['TenKH'] = $TenKH;
        $_SESSION['Email'] = $Email;
        $_SESSION['SDT'] = $SDT;
        echo "<script>alert('Cập nhật thông tin thành công!'); window.location.href='../profile.php';</script>";
    } else {
        echo "<script>alert('Cập nhật thất bại!'); window.location.href='../profile.php';</script>";
    }
}
?>