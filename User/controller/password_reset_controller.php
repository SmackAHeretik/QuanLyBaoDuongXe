<?php
include '../model/userModel.php'; // Include the UserModel for database interactions
include '../utils/ConnectDb.php'; // Include the database connection file

// Display errors
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Check if the form has been submitted
if (isset($_POST['reset_password'])) {
    $email = isset($_POST['email']) ? $_POST['email'] : '';

    // Check if the email exists in the database
    $userAccount = new UserModel();
    $user = $userAccount->findByEmail($email);

    if ($user) {
        // Generate a password reset token
        $token = bin2hex(random_bytes(50));

        // Store the token in the database
        $userAccount->storeResetToken($email, $token);

        // Send a password reset email
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
