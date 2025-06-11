<?php

require_once 'StaffController.php';
require_once 'ManagerController.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $phone = $_POST['phone'] ?? '';
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';
    $adminID = $_POST['adminID'] ?? '';

    if ($password !== $confirm_password) {
        $error = "Mật khẩu xác nhận không khớp!";
    } elseif ($adminID == 2) {
        $controller = new ManagerController();
        $result = $controller->register($name, $email, $phone, $password);
        if ($result === true) {
            header('Location: ../NVmanagement.php?success=1&type=manager');
            exit();
        }
        $error = $result;
    } elseif ($adminID == 3) {
        $controller = new StaffController();
        $result = $controller->register($name, $email, $phone, $password);
        if ($result === true) {
            header('Location: ../NVmanagement.php?success=1&type=staff');
            exit();
        }
        $error = $result;
    } else {
        $error = "Vui lòng chọn loại tài khoản!";
    }
    // Có thể truyền $error về lại form nếu muốn
}
?>