<?php
// File này KHÔNG dùng session, chỉ xử lý DB và gửi mail, nên KHÔNG cần session_name

include '../model/userModel.php';
include '../utils/ConnectDb.php';

// Display errors
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (isset($_POST['reset_password'])) {
    $email = isset($_POST['email']) ? $_POST['email'] : '';

    $userAccount = new UserModel();
    $user = $userAccount->findByEmail($email);

    if ($user) {
        $token = bin2hex(random_bytes(50));
        $userAccount->storeResetToken($email, $token);

        $resetLink = "http://yourwebsite.com/reset_password.php?token=" . $token;
        $subject = "Password Reset Request";
        $message = "Click on the following link to reset your password: " . $resetLink;
        $headers = "From: no-reply@yourwebsite.com";

        if (mail($email, $subject, $message, $headers)) {
            echo "<script>alert('A password reset link has been sent to your email.'); window.location.href='../login.php';</script>";
        } else {
            echo "<script>alert('Failed to send password reset email.'); window.location.href='../login.php';</script>";
        }
    } else {
        echo "<script>alert('Email address not found.'); window.location.href='../login.php';</script>";
    }
}
?>