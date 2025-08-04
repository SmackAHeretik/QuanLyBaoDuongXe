<?php
if (session_status() === PHP_SESSION_NONE) {
    session_name('USERSESSID');
    session_start();
}
unset($_SESSION['cart']);
header('Location: cart.php');
exit;
?>