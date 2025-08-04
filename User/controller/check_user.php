<?php
// File này KHÔNG dùng session, chỉ kiểm tra DB nên KHÔNG cần session_name

include '../model/userModel.php';
include '../utils/ConnectDb.php';

if (isset($_POST['TenKH'])) {
    $TenKH = $_POST['TenKH'];
    $userAccount = new UserModel();
    if ($userAccount->existsByTenKH($TenKH)) {
        echo 'exists';
    } else {
        echo 'available';
    }
} elseif (isset($_POST['Email'])) {
    $Email = $_POST['Email'];
    $userAccount = new UserModel();
    if ($userAccount->existsByEmail($Email)) {
        echo 'exists';
    } else {
        echo 'available';
    }
}
?>