<?php
include '../model/userModel.php'; // Include the UserModel for database interactions
include '../utils/ConnectDb.php'; // Include the database connection file

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
