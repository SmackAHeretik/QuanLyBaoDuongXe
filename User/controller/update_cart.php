<?php
if (session_status() === PHP_SESSION_NONE) {
    session_name('USERSESSID');
    session_start();
}
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['qty'])) {
    foreach ($_POST['qty'] as $MaSP => $qty) {
        foreach ($_SESSION['cart'] as &$item) {
            if ($item['MaSP'] == $MaSP) {
                $item['qty'] = max(1, intval($qty));
            }
        }
    }
    unset($item);
}
header('Location: ../cart.php');
exit;
?>