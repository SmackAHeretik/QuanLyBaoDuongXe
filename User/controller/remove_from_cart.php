<?php
session_start();
$maSP = $_GET['MaSP'];
if (isset($_SESSION['cart'][$maSP])) {
    unset($_SESSION['cart'][$maSP]);
}
header('Location: ../cart.php');
exit;
?>