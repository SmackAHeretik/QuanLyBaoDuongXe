<?php
if (session_status() === PHP_SESSION_NONE) {
    session_name('USERSESSID');
    session_start();
}
$maSP = $_GET['MaSP'];
if (isset($_SESSION['cart'][$maSP])) {
    unset($_SESSION['cart'][$maSP]);
}
header('Location: ../cart.php');
exit;
?>