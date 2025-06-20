<?php
session_start();
if (isset($_POST['qty'])) {
    foreach ($_POST['qty'] as $MaSP => $qty) {
        if ($qty <= 0) {
            unset($_SESSION['cart'][$MaSP]);
        } else {
            $_SESSION['cart'][$MaSP]['qty'] = $qty;
        }
    }
}
header('Location: cart.php');
exit;
?>